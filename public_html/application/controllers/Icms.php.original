<?php

// page security
defined('BASEPATH') OR exit('No direct script access allowed');

class Icms extends CI_Controller {

    public function __construct() {
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
    public function __sessionChecker() {

        echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';
    }

    /**
     * Session Destruct
     *
     * For Development use only
     */
    public function sessionDestruct() {
        // session destroy
        $this->sessionPushLogout('icms');
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
        
        if(!empty($_GET['cn']) !== false) {
            $param['temporary_case_number'] = $this->yel->decrypt_param($_GET['cn']);
            $param['temp_case_info'] = $this->Web_public_model->getCaseInfoByCaseNumber($param);
            $param['temp_case_info']['temporary_case_id'] = 'CN-'.$param['temp_case_info']['case_id'];
        }

        if(!empty($_GET['tcn']) !== false) {
            $param['temporary_case_number'] = $this->yel->decrypt_param($_GET['tcn']);
            $param['temp_case_info'] = $this->Web_public_model->getTempCaseInfoByCaseTempNumber($param);
        }

        if($param['temporary_case_number'] == '') {
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


        if ($sendOTP == 1) {
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
            'plugin' => array('sweetalert/sweetalert2.all.js',
            'sweetalert/sweetalert2.all.min.js',
            'sweetalert/sweetalert2.css',
            'sweetalert/sweetalert2.js',
            'sweetalert/sweetalert2.min.css',
            'sweetalert/sweetalert2.min.js'),
            'css' => array('verification', 'global'), 
            'js' => array('verification', 'global_methods', 'icms_message', 'dg')
        );

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
        
        if(empty($param['temp_case_info']['temporary_case_id']) !== false) {
            return redirect('/tracking');
        } 
        
        if($param['temp_case_info']['session_status'] == '1' ) {
            if (strtotime($param['temp_case_info']['otp_last_update']) <= strtotime("-30 minutes")) {
                // update session staus to inactive
                $this->Web_public_model->sessionToInactive($param);
                return redirect('/tracking');
            }
        } else {
            return redirect('/tracking');
        }


        if(strpos($param['temp_case_info']['temporary_case_id'], 'CN-') !== false) {
            $param['case_id'] = str_replace('CN-', '', $param['temp_case_info']['temporary_case_id']);
            // check if has record in temporary case
            $temp_case_info_by_case_id = $this->Web_public_model->getTemporaryCaseDetailsByCaseID($param);

            if(empty($temp_case_info_by_case_id['temporary_case_id']) !== true) {
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
        if(!empty($param['temporary_case_id']) !== false) {
            $temp_case_data = $this->Web_public_model->getTemporaryCaseDetailsByTempCaseID($param);

            if(empty($temp_case_data['temporary_case_id']) !== true) {
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
                    
                    $remarks = array_merge($remarks,$services);

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
                if($value['log_type'] == 'service'){
                    $data = [];
                    $data['log_type'] = "service";
                    // 1 = legal, 2 = reintegration
                    if ($value['service_category_type'] == '1') {
                        $data['log_type'] = "legal";
                        // criminal case = services_id = 40 
                        if($value['services_id'] == 40){
                            $cc =  $this->Temporary_case_model->getCriminalCaseForRemarks($temp_case);
                            $data = array_merge($data, $cc);
                            $data['service_type'] = "criminal_case";
                        }
                    
                        // administrative case = services_id = 41
                        if($value['services_id'] == 41){
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

        switch($aRecordSet['resp']['status']) {
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
            'plugin' => array('sweetalert/sweetalert2.all.js',
            'sweetalert/sweetalert2.all.min.js',
            'sweetalert/sweetalert2.css',
            'sweetalert/sweetalert2.js',
            'sweetalert/sweetalert2.min.css',
            'sweetalert/sweetalert2.min.js'),
            'css' => array('result_page' , 'global'), 
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
            'plugin' => array('jquery.validate.min.js',
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
            'sweetalert/sweetalert2.min.js'),
            'css' => array('file_complaint', 'global'), 
            'js' => array('file_complaint', 'global_methods', 'icms_message', 'dg')
        );

        $this->setTemplate('diginex/file_complaint', $aRecordSet, null, false, true, false, false, false, $aLibraries, $aSEO);
    }

  
    
    
}
