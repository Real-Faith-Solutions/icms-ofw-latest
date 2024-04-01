<?php

/**
 * Case Internal Ajax
 * 
 * @module Ajax Loader
 * @author LBS eBusiness Solutions Corp. 
 * @since 2017
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Web_public extends CI_Controller
{

    const SUCCESS_RESPONSE = 1;
    const FAILED_RESPONSE = 0;

    public function __construct()
    {
        parent::__construct();

        //load validation library
        $this->load->library('form_validation');

        // load models
        $this->load->model('web_public/Web_public_model');
    }

    /**
     * Ajax Route :: Action Controller
     */
    public function ajax()
    {

        // route ajax api
        $this->base_action_ajax();
    }

    // public function sessionDestruct() {
    //     // session destroy
    //     $this->sessionPushLogout('admininistrator');
    // }

    public function addFileComplaint($aParam)
    {

        $aResponse = [];
        $aResponse['flag'] = self::FAILED_RESPONSE;
        $aParam = $this->yel->safe_mode_clean_array($aParam);


        $old_date = explode('/', $aParam['temporary_victim_dob']);
        $new_data = $old_date[2] . '-' . $old_date[0] . '-' . $old_date[1];
        $aParam['temporary_victim_dob'] = $new_data;


        // complainant form validation
        $this->form_validation->set_rules('is_victim', '', 'required');
        $this->form_validation->set_rules('temporary_complainant_firstname', '', 'required');
        // $this->form_validation->set_rules('temporary_complainant_middlename', '', 'required');
        $this->form_validation->set_rules('temporary_complainant_lastname', '', 'required');
        // $this->form_validation->set_rules('temporary_complainant_mobile_number', '', 'required');
        // $this->form_validation->set_rules('temporary_complainant_email_address', '', 'required|valid_email');
        $this->form_validation->set_rules('temporary_complainant_relation', '', 'required|integer');
        // $this->form_validation->set_rules('temporary_complainant_preffered_contact_method', '', 'required|integer');
        $this->form_validation->set_rules('temporary_complainant_complain', '', 'required');

        // victim form validation
        $this->form_validation->set_rules('temporary_victim_firstname', '', 'required');
        // $this->form_validation->set_rules('temporary_victim_middlename', '', 'required');
        $this->form_validation->set_rules('temporary_victim_lastname', '', 'required');
        $this->form_validation->set_rules('temporary_victim_dob', '', 'required|valid_date');
        // $this->form_validation->set_rules('temporary_victim_email_address', '', 'required|valid_email');
        // $this->form_validation->set_rules('temporary_victim_mobile_number', '', 'req uired');
        $this->form_validation->set_rules('temporary_victim_address', '', 'required');
        $this->form_validation->set_rules('temporary_victim_country_deployment', '', 'required|integer');
        $this->form_validation->set_rules('temporary_victim_civil_status', '', 'required|integer');
        $this->form_validation->set_rules('temporary_victim_departure_type', '', 'required|integer');
        $this->form_validation->set_rules('temporary_victim_sex', '', 'required|integer');

        // //return validation errors
        if ($this->form_validation->run() == FALSE) {
            $aResponse['message'] = validation_errors();
            return $aResponse;
        }

        // add to temporary case table
        $add_data = $this->Web_public_model->addFileComplaint($aParam);

        if ($add_data[0]['stat'] == 1) {

            //temporary case logs / remarks
            // $aParam['temporary_case_remarks'] = "Complainant info has been updated."; 
            // $aParam['temporary_case_remarks_added_by'] = $_SESSION['userData']['user_id'];
            // $addTemporaryCaseAccessLog = $this->Temporary_case_model->AddTemporaryCaseRemarksBySystem($aParam);

            //temporary case access logs
            $aParam['temporary_case_id'] = $add_data[0]['insert_id'];
            $aParam['temporary_case_access_log_description'] = "Added new complaint.";
            $addTempCaseLog = $this->Web_public_model->addTempCaseLog($aParam);

            $aResponse['tcn'] = $add_data[1]['temporary_case_number'];
            $aResponse['tcid'] = $this->yel->encrypt_param($aParam['temporary_case_id']);

            // send otp
            $otp = [];
            $otp['otp_code'] = mt_rand(100000, 999999);
            $otp['otp_type'] = 0; // Default 0 = no value
            $otp['otp_portal'] = 2; // email
            $otp['temporary_case_id'] = $aParam['temporary_case_id'];

            $mail['to'] = array('raymark@s2-tech.com');
            $mail['subject'] = ' One-Time-Password';
            // $mail['template'] = 'otp';
            $mail['message'] = $otp['otp_code'] . '<br>';
            $mail['message'] .= "please enter this code";
            $email_result = $this->mailbox->sendMail($mail);
            // $email_result = $this->mailbox->sendEmailWithTemplate('email_verification', $aEmail);
            $aResponse['sending_result'] = $email_result['flag'];
            if ($aResponse['sending_result'] == "1") {
                $this->Web_public_model->saveOTP($otp);


                // temporary for testing only
                $param['otp_portal'] =  $otp['otp_portal'];
                $param['temp_case_info']['temporary_case_id'] = $otp['temporary_case_id'];
                // ------//

                // temp removal of verification code

                $this->Web_public_model->updateOTPStatusSuccess($aParam);
                // ------ //
                $aResponse['otp_details'] = $this->Web_public_model->getLastOtpRequestDetails($param);
                $aResponse['otp_details']['otp_code'] = $this->yel->encrypt_param($aResponse['otp_details']['otp_code']);

                $this->Web_public_model->resetOTPSuspension($aParam);
            }

            //send victim notification
            $this->notif->sendNotificationToVictim([
                "notif_type" => "add-temp",
                "id_type" => "temporary_case_id",
                "id" => $aParam['temporary_case_id']
            ]);



            $aResponse['flag'] = self::SUCCESS_RESPONSE;
        }

        return $aResponse;
    }

    //Email Verification
    public function verify_otp($aParam)
    {

        // if (isset($_GET['tcn']) == false) {
        //     redirect(MAIN_SITE_URL);
        // }

        $aRecordSet = [];
        $param = [];

        $param['temporary_case_number'] = $this->yel->decrypt_param($_GET['tcn']);
        $param['temp_case_info'] = $this->Web_public_model->getTempCaseInfoByCaseTempNumber($param);
        $param['otp_portal'] = 2;
        $lastOTPDetails = $this->Web_public_model->getLastOtpRequestDetails($param);

        $sendOTP = 0;
        $aRecordSet['suspend'] = 0;
        if ($lastOTPDetails['otp_try'] >= 5 && strtotime($lastOTPDetails['otp_last_update']) >= strtotime("-30 minutes")) {
            $aRecordSet['suspend'] = "2"; //retry limit
        } else {
            if ($lastOTPDetails['resend_count'] >= 5 && strtotime($lastOTPDetails['otp_last_update']) >= strtotime("-30 minutes")) {
                $aRecordSet['suspend'] = "1"; //resend send limit
            } else {
                if (strtotime($lastOTPDetails['otp_last_update']) >= strtotime("-2 minutes")) {
                    $aRecordSet['suspend'] = "3"; //waiting for resending
                } else {
                    $sendOTP = 1;
                }
            }
        }


        if ($sendOTP == 1) {
            $otp = [];
            $otp['otp_code'] = mt_rand(10000, 99999);
            $otp['otp_type'] = 0; // Default 0 = no value
            $otp['otp_portal'] = 2; // email
            $otp['temporary_case_id'] = $param['temp_case_info']['temporary_case_id'];

            $mail['to'] = array('raymark@s2-tech.com');
            $mail['subject'] = ' One-Time-Password';
            // $mail['template'] = 'otp';
            $mail['message'] = $otp['otp_code'] . '<br>';
            $mail['message'] .= "please enter this code";
            $email_result = $this->mailbox->sendMail($mail);
            // $email_result = $this->mailbox->sendEmailWithTemplate('email_verification', $aEmail);
            $aRecordSet['email_result'] = $email_result['flag'];
            if ($aRecordSet['email_result'] == "1") {
                $this->Web_public_model->saveOTP($otp);
            }
        }

        $lastOTPDetails =  $this->Web_public_model->getLastOtpRequestDetails($param);
        $aRecordSet['lastOTPDetails'] = $lastOTPDetails;
        $aRecordSet['contactDetails'] = $param['temp_case_info'];
        $aRecordSet['sendOTP'] = $sendOTP;

        return $aRecordSet;
    }

    //Submit Email OTP
    public function submitEmailOTP($param)
    {
        $rs = [];
        $rs['flag'] = self::FAILED_RESPONSE;

        $param = $this->yel->safe_mode_clean_array($param);

        $this->form_validation->set_rules('otp_code', '', 'required');
        $this->form_validation->set_rules('tcn', '', 'required');

        $param['temporary_case_no'] = $this->yel->decrypt_param($param['tcn']);

        //return validation errors
        if ($this->form_validation->run() == FALSE) {
            $rs['message'] = validation_errors();
            return $rs;
        }
        if (empty($param['temporary_case_no']) !== false) {
            $rs['message'] = 'Invalid Request';
            return $rs;
        }

        $param['temporary_case_id'] = $this->Web_public_model->getTempCaseId($param['temporary_case_no']);

        if ($param['temporary_case_id'] == '') {
            $param['case_id'] = $this->Web_public_model->getCaseId($param['temporary_case_no']);
            $param['temporary_case_id'] = 'CN-' . $param['case_id'];
        }

        // check tries and resend count
        $param['otp_portal'] = 2;
        $param['temp_case_info']['temporary_case_id'] =  $param['temporary_case_id'];
        $lastOTPDetails = $this->Web_public_model->getLastOtpRequestDetails($param);


        if ($lastOTPDetails['otp_try'] > 3 && strtotime($lastOTPDetails['otp_last_update']) >= strtotime("-30 minutes")) {
            $rs['result']['otp_try'] = $lastOTPDetails['otp_try'];
            $rs['message'] = 'Reached retry limit';
            return $rs;
        }


        $otpCompare = $this->Web_public_model->submitOTP($param);

        if ($otpCompare['otp_code'] == $param['otp_code']) {
            $rs['message'] = 'Verified Successfully';
            $rs['flag'] = self::SUCCESS_RESPONSE;
            $this->Web_public_model->resetOTPSuspension($param);
            $this->Web_public_model->updateOTPStatusSuccess($param);
            // $this->Web_public_model->emailAddressOrMobileNumberChanged($member_id, 'verified_email');
            // $this->Web_public_model->verifiedEmailAddress($param);
            // $this->Web_public_model->setMemberAsVerified($param);
            $rs['result']['otp_code'] = $this->yel->encrypt_param($otpCompare['otp_code']);

            // if($param['case_id'] != '') {
            //     $param['temporary_case_id'] = $param['case_id'];
            // }

            $rs['result']['tcid'] = $this->yel->encrypt_param($param['temporary_case_id']);
        }

        $rs['result']['otp_code'] = $this->yel->encrypt_param($otpCompare['otp_code']);
        $rs['result']['otp_try'] = $otpCompare['otp_try'];

        return $rs;
    }

    //Resend Email OTP
    public function resendEmailOTP($param)
    {
        $aRecordSet = [];
        $aRecordSet['flag'] = self::FAILED_RESPONSE;
        $param = $this->yel->safe_mode_clean_array($param);

        if (empty($param['tcn']) == true) {
            return redirect('/tracking');
        }

        $param['temporary_case_number'] = $this->yel->decrypt_param($param['tcn']);
        $param['temp_case_info'] = $this->Web_public_model->getTempCaseInfoByCaseTempNumber($param);
        $param['otp_portal'] = 2;

        if (empty($param['temp_case_info']['temporary_case_id']) !== false) {
            return redirect('/tracking');
        }

        $lastOTPDetails = $this->Web_public_model->getLastOtpRequestDetails($param);

        $current_time = time();
        $last_otp_time = strtotime($lastOTPDetails['otp_last_update']);
        $time_difference = $current_time - $last_otp_time;

        // if ($lastOTPDetails['resend_count'] > 3 && strtotime($lastOTPDetails['otp_last_update']) >= strtotime("-30 minutes")) {
        //     $aRecordSet['err_msg'] = 'You have reach the maximum resending limit of OTP';
        //     return $aRecordSet; //resend send limit
        // } 

        if ($lastOTPDetails['resend_count'] == 1 || $lastOTPDetails['resend_count'] == 2) {
            // Check if it's the first or second attempt and if the last OTP was sent more than 180 seconds ago
            $remaining_time = 180 - $time_difference;
            if ($remaining_time > 0) {
                $aRecordSet['remaining_time'] = $remaining_time; // Pass remaining time
                return $aRecordSet;
            }
        } elseif ($lastOTPDetails['resend_count'] >= 3) {
            // Check if it's the third or subsequent attempt and if the last OTP was sent more than 30 minutes ago
            $remaining_time = 1800 - $time_difference;
            if ($remaining_time > 0) {
                $aRecordSet['remaining_time'] = $remaining_time; // Pass remaining time
                return $aRecordSet;
            }
        }


        $otp = [];
        $otp['otp_code'] = mt_rand(100000, 999999);
        $otp['otp_type'] = 0; // Default 0 = no value
        $otp['otp_portal'] = 2; // email
        $otp['temporary_case_id'] = $param['temp_case_info']['temporary_case_id'];

        $mail['to'] = array($param['temp_case_info']['temporary_complainant_email_address']);
        $mail['subject'] = ' One-Time-Password';
        // $mail['template'] = 'otp';
        $mail['message'] = $otp['otp_code'] . '<br>';
        $mail['message'] .= "please enter this code";
        $email_result = $this->mailbox->sendMail($mail);
        // $email_result = $this->mailbox->sendEmailWithTemplate('email_verification', $aEmail);
        $aRecordSet['email_result'] = $email_result['flag'];
        if ($aRecordSet['email_result'] == "1") {
            $this->Web_public_model->saveOTP($otp);
        }

        $aRecordSet['flag'] = self::SUCCESS_RESPONSE;
        $aRecordSet['resend_count'] = $lastOTPDetails['resend_count'];
        $aRecordSet['last_update_time'] = $lastOTPDetails['otp_last_update'];
        $this->send();
        return $aRecordSet;
    }

    public function searchCase($param)
    {
        $rs = [];
        $rs['flag'] = self::FAILED_RESPONSE;

        $param = $this->yel->safe_mode_clean_array($param);

        $this->form_validation->set_rules('case_no', '', 'required');

        //return validation errors
        if ($this->form_validation->run() == FALSE) {
            $rs['message'] = validation_errors();
            return $rs;
        }


        // searched temp case
        $param['temporary_case_number'] = $param['case_no'];

        // check if temp case is existing in icms_temporary_case table
        $param['temp_case_info'] = $this->Web_public_model->getTempCaseInfoByCaseTempNumber($param);


        if (!empty($param['temp_case_info']['temporary_case_id']) !== false) {
            $rs['tcn'] = $this->yel->encrypt_param($param['temporary_case_number']);
            $rs['result'] = 'temporary_case';
            $rs['link'] = 'tcn=' . $rs['tcn'];
            $param['temporary_case_id'] = $param['temp_case_info']['temporary_case_id'];
        } else {
            // check if existing in icms_case table
            $param['case_info'] = $this->Web_public_model->getCaseInfoByCaseNumber($param);
            if (!empty($param['case_info']['case_id']) !== false) {
                $rs['cn'] = $this->yel->encrypt_param($param['case_info']['case_number']);
                $rs['result'] = 'case';
                $rs['link'] = 'cn=' . $rs['cn'];
                $param['temporary_case_id'] = $param['case_info']['case_id'];
            } else {
                $rs['message'] = 'No record found.';
                return $rs;
            }
        }

        //logs
        $param['temporary_case_access_log_description'] = "Searched from public website.";
        $addTempCaseLog = $this->Web_public_model->addTempCaseLog($param);

        if ($rs['result'] == 'case') {
            $param['temporary_case_id'] = 'CN-' . $param['case_info']['case_id'];
        }

        // send otp
        $otp = [];
        $otp['otp_code'] = mt_rand(100000, 999999);
        $otp['otp_type'] = 0; // Default 0 = no value
        $otp['otp_portal'] = 2; // email
        $otp['temporary_case_id'] = $param['temporary_case_id'];

        $mail['to'] = array('raymark@s2-tech.com');
        $mail['subject'] = ' One-Time-Password';
        // $mail['template'] = 'otp';
        $mail['message'] = $otp['otp_code'] . '<br>';
        $mail['message'] .= "please enter this code";
        $email_result = $this->mailbox->sendMail($mail);
        // $email_result = $this->mailbox->sendEmailWithTemplate('email_verification', $aEmail);
        $rs['sending_result'] = $email_result['flag'];
        if ($rs['sending_result'] == "1") {
            $this->Web_public_model->saveOTP($otp);
        }

        // temporary for testing only
        $aParam['otp_portal'] =  '2';
        // if($rs['result'] == 'case') {
        //     $aParam['temp_case_info']['temporary_case_id'] = $param['case_info']['case_id'];
        // } else {
        $aParam['temp_case_info']['temporary_case_id'] = $param['temporary_case_id'];
        // }
        $aResponse['otp_details'] = $this->Web_public_model->getLastOtpRequestDetails($aParam);
        // $rs['link'] = '/verification?code='. $aResponse['otp_details']['otp_code'] . $rs['link'];
        $rs['link'] = '/verification?' . $rs['link'];

        $rs['flag'] = self::SUCCESS_RESPONSE;
        $this->send();
        return $rs;
    }



    public function sessionToInactive($aParam)
    {

        $aResponse = [];
        $aResponse['flag'] = self::FAILED_RESPONSE;
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        $this->form_validation->set_rules('tcid', '', 'required');
        $this->form_validation->set_rules('ovc', '', 'required');


        //return validation errors
        if ($this->form_validation->run() == FALSE) {
            $rs['message'] = validation_errors();
            return $rs;
        }

        $aParam['temporary_case_id'] = $this->yel->decrypt_param($aParam['tcid']);
        $aParam['otp_v_code'] = $this->yel->decrypt_param($aParam['ovc']);

        $aResponse['resp'] = $this->Web_public_model->sessionToInactive($aParam);
        $aResponse['flag'] = self::SUCCESS_RESPONSE;

        return $aResponse;
    }

    function send()
    {
        // Load CodeIgniter instance
        $CI = &get_instance();
        $CI->load->library('email');

        // Fetch all temporary cases
        $temporaryCases = $this->Web_public_model->getAllTemporaryCases();

        // Check if there are temporary cases fetched
        if ($temporaryCases) {
            // Load email configuration dynamically
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'smtp.gmail.com';
            $config['smtp_port'] = 587;
            $config['smtp_user'] = 'lalata.jhunriz.bscs2019@gmail.com';
            $config['smtp_pass'] = 'shsamihjjdkunaxs';
            $config['mailtype'] = 'html';
            $config['charset'] = 'utf-8';
            $config['newline'] = "\r\n";
            $config['smtp_crypto'] = 'tls';

            $CI->email->initialize($config);

            // Iterate through each temporary case
            foreach ($temporaryCases as $tempCase) {
                if ($tempCase['temporary_complainant_preffered_contact_method'] == 2) { // 2 = email

                    // Fetch the OTP for the temporary case number
                    $param['otp_portal'] = 2;
                    // $fetchedOTP = $this->Web_public_model->getOTPByTemporaryCaseIdEmail($param['otp_portal']);


                    $CI->email->from('lalata.jhunriz.bscs2019@gmail.com', 'ICMS-IACAT');
                    $CI->email->to($tempCase['temporary_complainant_email_address']);
                    $CI->email->subject('Confirm Email');

                    // Construct email message
                    $message = '<div style="font-family: Arial, sans-serif; font-size:18px; max-width: 600px; margin: 0 auto; padding: 20px; text-align: left;">';
                    $message .= '<p>Hi ' . $tempCase['temporary_complainant_firstname'] . ',</p>';
                    $message .= '<p>You recently added <strong style"color:#3b5998;">' . $tempCase['temporary_complainant_email_address'] . '</strong> to your ICMS.IACAT account.</p>';
                    $message .= '<p>Please confirm this email address so that we can update your Account. You may be asked to enter this confirmation code:</p>';
                    $message .= '<p style="font-weight: bold; font-size: 24px; margin-bottom: 20px; text-align:center;">' . $tempCase['otp_code'] . '</p>';
                    $message .= '<hr style="border: none; border-top: 1px solid #ccc; margin: 20px 0;">';
                    $message .= '<p style="font-size: 12px;">';
                    $message .= '<div style="text-align:center;">';
                    $message .= 'from<br>';
                    $message .= 'ICMS.IACAT<br>';
                    $message .= 'ICMS, Inc., Attention: Community Support, Philippines.<br>';
                    $message .= 'This message was sent to <ICMS.IACAT@gmail.com>.';
                    $message .= '</p>';
                    $message .= '<p style="font-size: 12px; text-align:center;">To help keep your account secure, please don\'t forward this email. Learn more</p>';
                    $message .= '</div>';
                    $message .= '</div>';
                    $CI->email->message($message);

                    // Send email
                    if ($CI->email->send()) {
                        // Email sent successfully
                        // Handle success if needed
                    } else {
                        // Email sending failed
                        // Handle failure if needed
                    }

                    // // Check if OTP was fetched successfully
                    // if ($fetchedOTP) {

                    // } else {
                    //     // Handle case where OTP fetch failed
                    //     // Handle failure if needed
                    // }
                }
            }
        } else {
            // Handle case where no temporary cases are found
            $response = array("success" => false, "message" => "No temporary cases found");
            echo json_encode($response);
        }
    }

    function ConfirmationGmail()
    {
        // Load CodeIgniter instance
        $CI = &get_instance();
        $CI->load->library('email');

        // Fetch all temporary cases
        $temporaryCases = $this->Web_public_model->getAllTemporaryCases();

        // Check if there are temporary cases fetched
        if ($temporaryCases) {
            // Iterate through each temporary case
            foreach ($temporaryCases as $tempCase) {
                if ($tempCase['temporary_complainant_preffered_contact_method'] == 2) { // 2 = email
                    // Load email configuration dynamically
                    $config['protocol'] = 'smtp';
                    $config['smtp_host'] = 'smtp.gmail.com';
                    $config['smtp_port'] = 587;
                    $config['smtp_user'] = 'lalata.jhunriz.bscs2019@gmail.com';
                    $config['smtp_pass'] = 'shsamihjjdkunaxs';
                    $config['mailtype'] = 'html';
                    $config['charset'] = 'utf-8';
                    $config['newline'] = "\r\n";
                    $config['smtp_crypto'] = 'tls';

                    $CI->email->initialize($config);

                    $CI->email->from('lalata.jhunriz.bscs2019@gmail.com', 'ICMS-IACAT');
                    $CI->email->to($tempCase['temporary_complainant_email_address']); // Use the fetched email address
                    $CI->email->subject('ICMS-IACAT CASE');
                    // Construct email message
                    $message = '<div style="font-family: Arial, sans-serif; font-size:18px; max-width: 600px; margin: 0 auto; padding: 20px; text-align: left;">';
                    $message .= '<p>Your Case Mr/Mrs <b>' . $tempCase['temporary_complainant_lastname'] . ',' . $tempCase['temporary_complainant_firstname'] . '</b> was added successfully with a case number of <strong style="color:#3b5998;">' . $tempCase['temporary_case_number'] . '</strong> to your ICMS.IACAT account.</p>'; // Use the fetched email address
                    $message .= '<hr style="border: none; border-top: 1px solid #ccc; margin: 20px 0;">';
                    $message .= '<p style="font-size: 12px;">';
                    $message .= '<div style="text-align:center;">';
                    $message .= 'from<br>';
                    $message .= 'ICMS.IACAT<br>';
                    $message .= 'ICMS, Inc., Attention: Community Support, Philippines.<br>';
                    $message .= 'This message was sent to <ICMS.IACAT@gmail.com>.';
                    $message .= '</p>';
                    $message .= '<p style="font-size: 12px; text-align:center;">To help keep your account secure, please don\'t forward this email. Learn more</p>';
                    $message .= '</div>';
                    $message .= '</div>';
                    $CI->email->message($message);

                    // Send email
                    if ($CI->email->send()) {
                        // $response = array("success" => true);
                        // echo json_encode($response);
                    } else {
                        // $response = array("success" => false, "message" => $CI->email->print_debugger());
                        // echo json_encode($response);
                    }
                }
                else {
                    // send sms
                    // echo "send sms";
                    // $this->Icms->send_sms();
                }
            }
        } else {
            // Handle case where no temporary cases are found
            $response = array("success" => false, "message" => "No temporary cases found");
            echo json_encode($response);
        }
    }
}
