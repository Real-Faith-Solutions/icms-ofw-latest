<?php

// page security

use Aws\Sns\SnsClient;

defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';

class Icms extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // load modes

        $this->load->model('web_public/Web_public_model');
        $this->load->model('administrator/Temporary_case_model');
        $this->load->model('Global_data_model');
    }

    /**
     * Session Checker
     *
     * For Development use only
     */
    public function __sessionChecker()
    {

        echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';
    }

    /**
     * Session Destruct
     *
     * For Development use only
     */
    public function sessionDestruct()
    {
        // session destroy
        $this->sessionPushLogout('icms');
    }


    public function send_sms()
    {

        // Initialize AWS SDK SNS client
        $snsClient = new SnsClient([
            'version' => 'latest',
            'region' => 'ap-southeast-1',
            'credentials' => [
                'key' => constant('AWS_ACCESS_KEY'),
                'secret' => constant('AWS_SECRET_KEY'),
            ]
        ]);

        $temporaryCases = $this->Web_public_model->getAllTemporaryCases();
        if ($temporaryCases) {
            foreach ($temporaryCases as $tempCase) {
                if ($tempCase['temporary_complainant_preffered_contact_method'] == 1) { // 1 = sms
                    try {
                        // Sending SMS
                        $result = $snsClient->publish([
                            'Message' => 'This is Your One Time Password: ' . $tempCase['otp_code'],
                            // 'PhoneNumber' => '+639761401847', 
                            'PhoneNumber' => $tempCase['temporary_complainant_mobile_number'],
                            // 'MessageAttributes' => [], // If you need to specify any additional attributes
                        ]);

                        // Check for errors or log results
                        // if ($result['@metadata']['statusCode'] == 200) {
                        //     echo "SMS Sent Successfully, OTP:" . $tempCase['otp_code'];
                        //     echo "<br> number :" . $tempCase['temporary_complainant_mobile_number'];
                        //     echo "<br>temporary_complainant_preffered_contact_method :" . $tempCase['temporary_complainant_preffered_contact_method'];
                        // } else {
                        //     echo "Failed to send SMS";
                        // }
                    } catch (Exception $error) {
                        echo $error;
                    }
                }
            }
        }
    }



    public function index()
    {
        redirect(SITE_URL . 'agency');
    }

    public function tracking()
    {
        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Landing Page',
            'page_description' => 'Landing Page',
            'page_keyword' => 'Landing Page'
        );

        $aLibraries = array(
            'plugin' => array('jquery.validate.min.js'),
            'css' => array('landing_page', 'global'),
            'js' => array('landing_page', 'global_methods', 'icms_message', 'dg')
        );

        $this->setTemplate('diginex/landing_page', $aRecordSet, null, false, true, false, false, false, $aLibraries, $aSEO);
    }

    public function verification()
    {

        $aRecordSet = [];
        $param = [];
        $param['otp_portal'] = 2;

        if (empty($_GET['tcn']) == true && empty($_GET['cn']) == true) {
            return redirect('/tracking');
        }

        if (!empty($_GET['cn']) !== false) {
            $param['temporary_case_number'] = $this->yel->decrypt_param($_GET['cn']);
            $param['temp_case_info'] = $this->Web_public_model->getCaseInfoByCaseNumber($param);
            $param['temp_case_info']['temporary_case_id'] = 'CN-' . $param['temp_case_info']['case_id'];
        }

        if (!empty($_GET['tcn']) !== false) {
            $param['temporary_case_number'] = $this->yel->decrypt_param($_GET['tcn']);
            $param['temp_case_info'] = $this->Web_public_model->getTempCaseInfoByCaseTempNumber($param);
        }

        if ($param['temporary_case_number'] == '') {
            return redirect('/tracking');
        }

        $lastOTPDetails = $this->Web_public_model->getLastOtpRequestDetails($param);

        $sendOTP = 0;
        $aRecordSet['suspend'] = 0;
        if ($lastOTPDetails['otp_try'] > 3 && strtotime($lastOTPDetails['otp_last_update']) >= strtotime("-30 minutes")) {
            $aRecordSet['suspend'] = "2"; //retry limit
        } else {
            if ($lastOTPDetails['resend_count'] > 3 && strtotime($lastOTPDetails['otp_last_update']) >= strtotime("-30 minutes")) {
                $aRecordSet['suspend'] = "1"; //resend send limit
            } else {
                if (strtotime($lastOTPDetails['otp_last_update']) >= strtotime("-2 minutes")) {
                    $aRecordSet['suspend'] = "3"; //waiting for resending
                } else {
                    $sendOTP = 1;
                }
            }
        }

        if ($sendOTP == 1) { // email
            $otp = [];
            $otp['otp_code'] = mt_rand(100000, 999999);
            $otp['otp_type'] = 0; // Default 0 = no value
            $otp['otp_portal'] = 2; // email
            $otp['temporary_case_id'] = $param['temp_case_info']['temporary_case_id'];

            $mail['to'] = array($param['temp_case_info']['temporary_complainant_email_address']);
            $mail['subject'] = ' One-Time-Password';
            // $mail['template'] = 'otp';
            $mail['message'] = $otp['otp_code'] . '<br>';
            // $mail['message'] .= "please enter this code";
            // $email_result = $this->mailbox->sendMail($mail);
            // $email_result = $this->mailbox->sendEmailWithTemplate('email_verification', $aEmail);
            $aRecordSet['email_result'] = $email_result['flag'];
            if ($aRecordSet['email_result'] == "1") {
                $this->Web_public_model->saveOTP($otp);
            }
            // $this->send(); 

            $this->send_sms(); // send sms

        }
        $this->send_sms(); // send sms


        // Add this code after sending OTP
        // Initialize the variable to store fetched OTP
        $aRecordSet['fetchedOTP'] = 'otp_last_update';

        // Fetch the OTP for the temporary case number
        $fetchedOTP = $this->Web_public_model->getOTPByTemporaryCaseId($param['temp_case_info']['temporary_case_id']);

        // Check if OTP was fetched successfully
        if ($fetchedOTP) {
            // Update the variable with the fetched OTP code
            $aRecordSet['fetchedOTP'] = $fetchedOTP['otp_code'];
        }


        $lastOTPDetails =  $this->Web_public_model->getLastOtpRequestDetails($param);
        $aRecordSet['lastOTPDetails'] = $lastOTPDetails;
        $aRecordSet['contactDetails'] = $param['temp_case_info'];
        $aRecordSet['sendOTP'] = $sendOTP;


        $aSEO = array(
            'page_title' => 'Verification Page',
            'page_description' => 'Verification Page ',
            'page_keyword' => 'Verification Page'
        );

        $aLibraries = array(
            'plugin' => array(
                'sweetalert/sweetalert2.all.js',
                'sweetalert/sweetalert2.all.min.js',
                'sweetalert/sweetalert2.css',
                'sweetalert/sweetalert2.js',
                'sweetalert/sweetalert2.min.css',
                'sweetalert/sweetalert2.min.js'
            ),
            'css' => array('verification', 'global'),
            'js' => array('verification', 'global_methods', 'icms_message', 'dg')
        );
        // $this->send();
        $this->setTemplate('diginex/verification', $aRecordSet, null, false, true, false, false, false, $aLibraries, $aSEO);
    }

    public function result_page()
    {

        if (empty($_GET['tcid']) == true && empty($_GET['ovc']) == true) {
            return redirect('/tracking');
        }

        $aRecordSet = [];
        $param = [];
        $remarks = [];

        $param['temporary_case_id'] = $this->yel->decrypt_param($_GET['tcid']);
        $param['otp_v_code'] = $this->yel->decrypt_param($_GET['ovc']);

        $param['temp_case_info'] = $this->Web_public_model->getLatestOtpVerifiedCode($param);

        if (empty($param['temp_case_info']['temporary_case_id']) !== false) {
            return redirect('/tracking');
        }

        if ($param['temp_case_info']['session_status'] == '1') {
            if (strtotime($param['temp_case_info']['otp_last_update']) <= strtotime("-30 minutes")) {
                // update session staus to inactive
                $this->Web_public_model->sessionToInactive($param);
                return redirect('/tracking');
            }
        } else {
            return redirect('/tracking');
        }


        if (strpos($param['temp_case_info']['temporary_case_id'], 'CN-') !== false) {
            $param['case_id'] = str_replace('CN-', '', $param['temp_case_info']['temporary_case_id']);
            // check if has record in temporary case
            $temp_case_info_by_case_id = $this->Web_public_model->getTemporaryCaseDetailsByCaseID($param);

            if (empty($temp_case_info_by_case_id['temporary_case_id']) !== true) {
                $param['temporary_case_id'] = $temp_case_info_by_case_id['temporary_case_id'];
            } else {
                $param['temporary_case_id'] = NULL;
                $victim_info = [];
                $complainant_info = [];

                // get case info by case id
                $case_info = $this->Web_public_model->getCaseInfoByCaseID($param['case_id']);
                // get vimtim id by case id
                $victim_id = $this->Web_public_model->getVictimIDByCaseID($param['case_id']);

                // get vitim info
                $victim_info = $this->Web_public_model->getVictimInfoByVictimID($victim_id['victim_id']);

                // get complainant info by victim id
                $complainant_info = $this->Web_public_model->getComplainantInfoByVictimID($victim_id['case_victim_id']);

                // get access logs
                $logs = $this->Web_public_model->getTempCaseAccessLogsByCaseID($param['case_id']);
                $logs = convert_date_format($logs, 'F d, Y h:i A', array('date_added'));

                // displayed data
                $aRecordSet['resp']['date_of_complaint'] = convert_date_format('F d, Y h:i A', $complainant_info['case_complainant_date_added']);
                $aRecordSet['resp']['complainant_name'] = $complainant_info['case_complainant_name'];
                $aRecordSet['resp']['victim_name'] = $victim_info['victim_info_last_name'] . ', ' . $victim_info['victim_info_first_name'] . ' ' .  $victim_info['victim_info_middle_name'];
                $aRecordSet['resp']['status'] = $case_info['case_status_id'];
                $aRecordSet['resp']['last_tracked'] = $logs['date_added'];
                $aRecordSet['resp']['tracking_number'] = $case_info['case_number'];

                $services = $this->Web_public_model->getServices($param['case_id']);

                if (count($services) > 0) {
                    $newservices = $services;
                    $temp_services = [];

                    foreach ($services as $key => $value) {
                        $newservices[$key]['service_status'] = "Ongoing";
                        $services_logs = $this->Temporary_case_model->getServiceLogs($value);

                        $cnt = 0;
                        if (count($services_logs) > 0) {
                            foreach ($services_logs as $k => $v) {
                                $temp_services[$cnt] = $value;
                                $temp_services[$cnt]['service_status'] = $v['user_log_update_new_parameter'];
                                $temp_services[$cnt]['temporary_case_remarks_date_added'] = $v['temporary_case_remarks_date_added'];
                                $cnt++;
                            }
                            $newservices = array_merge($newservices, $temp_services);
                        }
                    }
                    $services = $newservices;
                }

                $remarks = $services;

                $temp_case = $case_info;
            }
        }



        // start of temp case number seaching
        if (!empty($param['temporary_case_id']) !== false) {
            $temp_case_data = $this->Web_public_model->getTemporaryCaseDetailsByTempCaseID($param);

            if (empty($temp_case_data['temporary_case_id']) !== true) {
                // get access logs
                $logs = $this->Web_public_model->getTempCaseAccessLogs($temp_case_data);
                $logs = convert_date_format($logs, 'F d, Y h:i A', array('date_added'));
                // $logs  = $this->yel->encrypt_param_row($logs , array('temporary_case_access_log_id', 'temporary_case_id'));

                // displayed data
                // convert_date_format($temp_case_data, 'F d, Y h:i A', array('temporary_case_date_added'));
                $aRecordSet['resp']['date_of_complaint'] = convert_date_format('F d, Y h:i A', $temp_case_data['temporary_case_date_added']);
                $aRecordSet['resp']['complainant_name'] = $temp_case_data['temporary_complainant_lastname'] . ', ' . $temp_case_data['temporary_complainant_firstname'] . ' ' .  $temp_case_data['temporary_complainant_middlename'];
                $aRecordSet['resp']['victim_name'] = $temp_case_data['temporary_victim_lastname'] . ', ' . $temp_case_data['temporary_victim_firstname'] . ' ' .  $temp_case_data['temporary_victim_middlename'];
                $aRecordSet['resp']['status'] = $temp_case_data['temporary_case_status_id'];
                $aRecordSet['resp']['last_updated'] = $temp_case_data['temporary_case_date_updated'];
                $aRecordSet['resp']['last_tracked'] = $logs['date_added'];
                $aRecordSet['resp']['tracking_number'] = $temp_case_data['temporary_case_number'];

                // get remarks
                $remarks = $this->Temporary_case_model->getTemporaryCaseRemarksByTemporaryCaseId($temp_case_data);

                //if case status is added to case
                $temp_case = $this->Temporary_case_model->getTemporaryCaseByTemporaryCaseId($temp_case_data);

                $status = $temp_case['temporary_case_status_id'];

                if ($status == '3') { //if added to case get services logs
                    $services_logs = '';
                    $services = $this->Temporary_case_model->getServices($temp_case_data);

                    if (count($services) > 0) {
                        $newservices = $services;
                        $temp_services = [];

                        foreach ($services as $key => $value) {
                            $newservices[$key]['service_status'] = "Ongoing";
                            $services_logs = $this->Temporary_case_model->getServiceLogs($value);
                            $cnt = 0;
                            if (count($services_logs) > 0) {
                                foreach ($services_logs as $k => $v) {
                                    $temp_services[$cnt] = $value;
                                    $temp_services[$cnt]['service_status'] = $v['user_log_update_new_parameter'];
                                    $temp_services[$cnt]['temporary_case_remarks_date_added'] = $v['temporary_case_remarks_date_added'];
                                    $cnt++;
                                }
                                $newservices = array_merge($newservices, $temp_services);
                            }
                        }

                        $services = $newservices;
                    }

                    $remarks = array_merge($remarks, $services);

                    $aRecordSet['resp']['status'] = $temp_case_data['temporary_case_status_id'];
                }
            }
        }

        // print_r($param); exit();

        // SORT BY DATE 
        foreach ($remarks as $key => $part) {
            $sort[$key] = strtotime($part['temporary_case_remarks_date_added']);
        }


        // if there is remarks 
        if (count($remarks) > 0) {
            array_multisort($sort, SORT_DESC, $remarks);

            foreach ($remarks as $key => $value) {
                if ($value['log_type'] == 'service') {
                    $data = [];
                    $data['log_type'] = "service";
                    // 1 = legal, 2 = reintegration
                    if ($value['service_category_type'] == '1') {
                        $data['log_type'] = "legal";
                        // criminal case = services_id = 40 
                        if ($value['services_id'] == 40) {
                            $cc =  $this->Temporary_case_model->getCriminalCaseForRemarks($temp_case);
                            $data = array_merge($data, $cc);
                            $data['service_type'] = "criminal_case";
                        }

                        // administrative case = services_id = 41
                        if ($value['services_id'] == 41) {
                            $ac =  $this->Temporary_case_model->getAdministrativeCaseForRemarks($temp_case);
                            $data = array_merge($data, $ac);
                            $data['service_type'] = "administrative_case";
                        }
                    }
                    $data['temporary_case_remarks_date_added'] = $value['temporary_case_remarks_date_added'];
                    $data['temporary_case_remarks_id'] = $value['temporary_case_remarks_id'];
                    $data['temporary_case_id'] = 1;
                    $data['is_system_generated'] = 1;
                    $data['is_active'] = 1;
                    $data['is_editable'] = 0;
                    $data['agency'] = $value['agency_branch_name'];
                    $data['service_name'] = $value['service_name'];
                    $data['service_duration'] = $value['service_duration'];
                    $data['service_status'] = $value['service_status'];
                    $remarks[$key] = $data;
                }
            }


            $remarks = convert_date_format($remarks, 'F d, Y h:i A', array('temporary_case_remarks_date_added'));
            $aRecordSet['resp']['last_updated'] = $remarks[0]['temporary_case_remarks_date_added'];
        }

        switch ($aRecordSet['resp']['status']) {
            case '1':
                $aRecordSet['resp']['status'] = 'Pending';
                break;
            case '2':
                $aRecordSet['resp']['status'] = 'For Verification';
                break;
            case '3':
                $aRecordSet['resp']['status'] = 'Added to Case';
                break;
            case '4':
                $aRecordSet['resp']['status'] = 'Archived';
                break;
        }

        $aRecordSet['listing'] = $this->yel->encrypt_id_in_array($remarks, array('temporary_case_remarks_id', 'temporary_case_id'));


        // print_r('<pre>');
        // print_r($aRecordSet); exit();
        $aSEO = array(
            'page_title' => 'Result Page',
            'page_description' => 'Result Page ',
            'page_keyword' => 'Result Page'
        );

        $aLibraries = array(
            'plugin' => array(
                'sweetalert/sweetalert2.all.js',
                'sweetalert/sweetalert2.all.min.js',
                'sweetalert/sweetalert2.css',
                'sweetalert/sweetalert2.js',
                'sweetalert/sweetalert2.min.css',
                'sweetalert/sweetalert2.min.js'
            ),
            'css' => array('result_page', 'global'),
            'js' => array('result_page', 'global_methods', 'icms_message', 'dg')
        );

        $this->setTemplate('diginex/result_page', $aRecordSet, null, false, true, false, false, false, $aLibraries, $aSEO);
    }

    public function file_complaint()
    {
        $aRecordSet = [];
        $aParam = [];
        $aParam['order_by'] = 'ORDER  BY `parameter_count_id` ASC';
        $aParam['status'] = '1';

        // Relation to victim
        $aParam['type_id'] = '31';
        $aRecordSet['rel_to_victim'] = $this->Global_data_model->getGlobalParameter($aParam);

        // Preferred contact method
        $aParam['type_id'] = '30';
        $aRecordSet['pref_cont_meth'] = $this->Global_data_model->getGlobalParameter($aParam);

        // Sex
        $aParam['type_id'] = '9';
        $aRecordSet['sex'] = $this->Global_data_model->getGlobalParameter($aParam);

        // Civil Status
        $aParam['type_id'] = '3';
        $aRecordSet['civil_status'] = $this->Global_data_model->getGlobalParameter($aParam);

        // Departure type
        $aParam['type_id'] = '5';
        $aRecordSet['dep_type'] = $this->Global_data_model->getGlobalParameter($aParam);

        // Country
        $aRecordSet['country'] = $this->Global_data_model->getCountries($aParam);

        // print_r('<pre>');
        // print_r($aRecordSet); exit();
        $aSEO = array(
            'page_title' => 'File Complaint',
            'page_description' => 'File Complaint',
            'page_keyword' => 'File Complaint'
        );

        $aLibraries = array(
            'plugin' => array(
                'jquery.validate.min.js',
                'select2_/select2.full.js',
                'select2_/select2.full.min.js',
                'select2_/select2.js',
                'chosen/chosen.min.css',
                'chosen/chosen.jquery.min.js',
                'select2_/select2.min.js',
                'case_datepicker/jquery.datetimepicker.full.js',
                'case_datepicker/jquery.datetimepicker.css',
                'sweetalert/sweetalert2.all.js',
                'sweetalert/sweetalert2.all.min.js',
                'sweetalert/sweetalert2.css',
                'sweetalert/sweetalert2.js',
                'sweetalert/sweetalert2.min.css',
                'sweetalert/sweetalert2.min.js'
            ),
            'css' => array('file_complaint', 'global'),
            'js' => array('file_complaint', 'global_methods', 'icms_message', 'dg')
        );

        $this->setTemplate('diginex/file_complaint', $aRecordSet, null, false, true, false, false, false, $aLibraries, $aSEO);
    }


    // function send() {
    //     // Load CodeIgniter instance
    //     $CI = &get_instance();
    //     $CI->load->library('email');

    //     // Fetch all temporary cases
    //     $temporaryCases = $this->Web_public_model->getAllTemporaryCases();

    //     // Check if there are temporary cases fetched
    //     if ($temporaryCases) {
    //         // Load email configuration dynamically
    //         $config['protocol'] = 'smtp';
    //         $config['smtp_host'] = 'smtp.gmail.com';
    //         $config['smtp_port'] = 587;
    //         $config['smtp_user'] = 'lalata.jhunriz.bscs2019@gmail.com';
    //         $config['smtp_pass'] = 'shsamihjjdkunaxs';
    //         $config['mailtype'] = 'html';
    //         $config['charset'] = 'utf-8';
    //         $config['newline'] = "\r\n";
    //         $config['smtp_crypto'] = 'tls';

    //         $CI->email->initialize($config);

    //         // Iterate through each temporary case
    //         foreach ($temporaryCases as $tempCase) {
    //             // Fetch the OTP for the temporary case number
    //             $param['otp_portal'] = 2;
    //             $fetchedOTP = $this->Web_public_model->getOTPByTemporaryCaseIdEmail($param['otp_portal']);

    //             // Check if OTP was fetched successfully
    //             if ($fetchedOTP) {
    //                 $CI->email->from('lalata.jhunriz.bscs2019@gmail.com', 'ICMS-IACAT');
    //                 $CI->email->to($tempCase['temporary_complainant_email_address']);
    //                 $CI->email->subject('Confirm Email');

    //                 // Construct email message
    //                 $message = '<div style="font-family: Arial, sans-serif; font-size:18px; max-width: 600px; margin: 0 auto; padding: 20px; text-align: left;">';
    //                 $message .= '<p>Hi ' . $tempCase['temporary_complainant_firstname'] . ',</p>';
    //                 $message .= '<p>You recently added <strong style"color:#3b5998;">' . $tempCase['temporary_complainant_email_address'] . '</strong> to your ICMS.IACAT account.</p>';
    //                 $message .= '<p>Please confirm this email address so that we can update your Account. You may be asked to enter this confirmation code:</p>';
    //                 $message .= '<p style="font-weight: bold; font-size: 24px; margin-bottom: 20px; text-align:center;">' . $fetchedOTP['otp_code'] . '</p>';
    //                 $message .= '<hr style="border: none; border-top: 1px solid #ccc; margin: 20px 0;">';
    //                 $message .= '<p style="font-size: 12px;">';
    //                 $message .= '<div style="text-align:center;">';
    //                 $message .= 'from<br>';
    //                 $message .= 'ICMS.IACAT<br>';
    //                 $message .= 'ICMS, Inc., Attention: Community Support, Philippines.<br>';
    //                 $message .= 'This message was sent to <ICMS.IACAT@gmail.com>.';
    //                 $message .= '</p>';
    //                 $message .= '<p style="font-size: 12px; text-align:center;">To help keep your account secure, please don\'t forward this email. Learn more</p>';
    //                 $message .= '</div>';
    //                 $message .= '</div>';
    //                 $CI->email->message($message);

    //                 // Send email
    //                 if ($CI->email->send()) {
    //                     // Email sent successfully
    //                     // Handle success if needed
    //                 } else {
    //                     // Email sending failed
    //                     // Handle failure if needed
    //                 }
    //             } else {
    //                 // Handle case where OTP fetch failed
    //                 // Handle failure if needed
    //             }
    //         }
    //     } else {
    //         // Handle case where no temporary cases are found
    //         $response = array("success" => false, "message" => "No temporary cases found");
    //         echo json_encode($response);
    //     }
    // }


    // function send() {
    //     // Load CodeIgniter instance
    //     $CI = &get_instance();
    //     $CI->load->library('email');

    //     // Fetch the OTP for the temporary case number
    //     $param['otp_portal'] = 2;
    //     $fetchedOTP = $this->Web_public_model->getOTPByTemporaryCaseIdEmail($param['otp_portal']);

    //     // Load email configuration dynamically
    //     $config['protocol'] = 'smtp';
    //     $config['smtp_host'] = 'smtp.gmail.com';
    //     $config['smtp_port'] = 587;
    //     $config['smtp_user'] = 'lalata.jhunriz.bscs2019@gmail.com';
    //     $config['smtp_pass'] = 'shsamihjjdkunaxs';
    //     $config['mailtype'] = 'html';
    //     $config['charset'] = 'utf-8';
    //     $config['newline'] = "\r\n";
    //     $config['smtp_crypto'] = 'tls';

    //     $CI->email->initialize($config);

    //     $CI->email->from('lalata.jhunriz.bscs2019@gmail.com', 'ICMS-IACAT');
    //     $CI->email->to('lhattz.jhunriz@gmail.com');
    //     $CI->email->subject('Confirm Email');

    //     // Check if OTP was fetched successfully
    //     if ($fetchedOTP) {
    //         // Construct email message
    //         $message = '<div style="font-family: Arial, sans-serif; font-size:18px; max-width: 600px; margin: 0 auto; padding: 20px; text-align: left;">';
    //         $message .= '<p>Hi <Name of the User>,</p>';
    //         $message .= '<p>You recently added <a href="#">'.$iwantfetchtheemailindatabase['temporary_complainant_email_address'] .'</a> to your ICMS.IACAT account.</p>';
    //         $message .= '<p>Please confirm this email address so that we can update your Account. You may be asked to enter this confirmation code:</p>';
    //         $message .= '<p style="font-weight: bold; font-size: 24px; margin-bottom: 20px; text-align:center;">' . $fetchedOTP['otp_code'] . '</p>';
    //         $message .= '<hr style="border: none; border-top: 1px solid #ccc; margin: 20px 0;">';
    //         $message .= '<p style="font-size: 12px;">';
    //         $message .= '<div style="text-align:center;">';
    //         $message .= 'from<br>';
    //         $message .= 'ICMS.IACAT<br>';
    //         $message .= 'ICMS, Inc., Attention: Community Support, Philippines.<br>';
    //         $message .= 'This message was sent to <ICMS.IACAT@gmail.com>.';
    //         $message .= '</p>';
    //         $message .= '<p style="font-size: 12px; text-align:center;">To help keep your account secure, please don\'t forward this email. Learn more</p>';
    //         $message .= '</div>';
    //         $message .= '</div>';
    //         $CI->email->message($message);

    //         // Send email
    //         if ($CI->email->send()) {
    //             $response = array("success" => true);
    //             echo json_encode($response);
    //         } else {
    //             $response = array("success" => false, "message" => $CI->email->print_debugger());
    //             echo json_encode($response);
    //         }
    //     } else {
    //         // Handle case where OTP fetching failed
    //         $response = array("success" => false, "message" => "Error fetching OTP");
    //         echo json_encode($response);
    //     }
    // }


    // function send() {
    //     // Load CodeIgniter instance
    //     $CI = &get_instance();
    //     $CI->load->library('email');

    //     // Fetch the OTP for the temporary case number
    //     $param['otp_portal'] = 2;
    //     $fetchedOTP = $this->Web_public_model->getOTPByTemporaryCaseIdEmail($param['otp_portal']);

    //     // Load email configuration dynamically
    //     $config['protocol'] = 'smtp';
    //     $config['smtp_host'] = 'smtp.gmail.com';
    //     $config['smtp_port'] = 587;
    //     $config['smtp_user'] = 'lalata.jhunriz.bscs2019@gmail.com';
    //     $config['smtp_pass'] = 'shsamihjjdkunaxs';
    //     $config['mailtype'] = 'html';
    //     $config['charset'] = 'utf-8';
    //     $config['newline'] = "\r\n";
    //     $config['smtp_crypto'] = 'tls';

    //     $CI->email->initialize($config);

    //     $CI->email->from('lalata.jhunriz.bscs2019@gmail.com', 'ICMS-IACAT');
    //     $CI->email->to('lhattz.jhunriz@gmail.com');
    //     // $CI->email->cc('lalata.jhunriz.bscs2019@gmail.com');
    //     // $CI->email->bcc('lalata.jhunriz.bscs2019@gmail.com');

    //     $CI->email->subject('Confirm Email');
    //     // Check if OTP was fetched successfully
    //     if ($fetchedOTP) {
    //         // Concatenate the fetched OTP value with the message
    //         $message = '<div style="font-family: Arial, sans-serif; font-size:18px; max-width: 600px; margin: 0 auto; padding: 20px; text-align: left;">';
    //         $message .= '<p>Hi <Name of the User>,</p>';
    //         $message .= '<p>You recently added <a href="#">sample@gmail.com</a> to your ICMS.IACAT account.</p>';
    //         $message .= '<p>Please confirm this email address so that we can update your Account. You may be asked to enter this confirmation code:</p>';
    //         $message .= '<p style="font-weight: bold; font-size: 24px; margin-bottom: 20px; text-align:center;">' . $fetchedOTP['otp_code'] . '</p>';
    //         $message .= '<hr style="border: none; border-top: 1px solid #ccc; margin: 20px 0;">';
    //         $message .= '<p style="font-size: 12px;">';
    //         $message .= '<div style="text-align:center;">';
    //         $message .= 'from<br>';
    //         $message .= 'ICMS.IACAT<br>';
    //         $message .= 'ICMS, Inc., Attention: Community Support, Philippines.<br>';
    //         $message .= 'This message was sent to <ICMS.IACAT@gmail.com>.';
    //         $message .= '</p>';
    //         $message .= '<p style="font-size: 12px; text-align:center;">To help keep your account secure, please don\'t forward this email. Learn more</p>';
    //         $message .= '</div>';
    //         $message .= '</div>';
    //         $CI->email->message($message);
    //     } else {
    //         // Handle case where OTP fetching failed
    //         echo 'Error fetching OTP';
    //         return;
    //     }
    //     if ($CI->email->send()) {
    //         echo 'EMAIL SEND!';
    //     } else {
    //         echo 'Error sending email: ' . $CI->email->print_debugger();
    //     }
    // }




}
