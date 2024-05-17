<?php

/**
 * Reports Internal Ajax
 * 
 * @module Ajax Loader
 * @author LBS eBusiness Solutions Corp. 
 * @since 2017
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class icms_sandbox extends CI_Controller {

    const SECRET_KEY = 'LBS3bus1n3sss0lut10nsc0rp';

    const SUCCESS_RESPONSE = 1;
    const FAILED_RESPONSE = 0;

    const AUTHENTICATION_SUCCESS = 1;
    const AUTHENITCATION_FAILED = 0;

    public function __construct() {
        parent::__construct();

        // $this->load->library('form_apivalidation');
        $this->load->library('form_apivalidation');
        
        // load models
        $this->load->model('Api/API_model');
        $this->load->model('web_public/Web_public_model');
        $this->load->model('administrator/Temporary_case_model');
        $this->load->model('Global_data_model');
    }

    /**
     * Ajax Route :: Action Controller
     */
    public function api() {

        // route ajax api
        $this->base_action_api();
    }

    private function generate_authentication_id($sValue) {
        $sValue = strtoupper(substr(sha1(md5(sha1(BASE_SALT) . sha1($sValue))), 2, 12));
        return $sValue;
    }

    /**
     * Validate authentication parameters
     * 
     * @param array
     * @return int
     **/
    private function authenticate_access($aParam){

        $aResponse = self::SUCCESS_RESPONSE;

        $aParam['api_authentication_id'] = $this->yel->decrypt_param($aParam['api_authentication_id']);

        $authenticate = $this->API_model->authenticate_api($aParam);

        if($authenticate!=1){

            $aResponse = self::FAILED_RESPONSE;
        }

        return $aResponse;
    }

    /*
    * $param = string  | object | array
    *
    * return true|false
    */
    public function is_exist($param) {

        $rs = self::FAILED_RESPONSE;

        if ((isset($param) !== false) and ( $param !== "") and ( empty($param) == false) and ( $param !== "NULL")) {

            $rs = self::SUCCESS_RESPONSE;
        }

        return $rs;

    }

    /*
    * setDefaultParam
    *
    * @param  = object
    * $default  = object
    *
    * If value exist it remove whitespace
    * Else the value will set as default as NULL string
    *
    * NOTE: Do not add single qoute in the model for insert and update
    *
    * @return $rs object
    *
    */
    private function set_default_param($param = null, $default = null, $param_exceptions = []) {

        if ( count($param) > 0) { 
            foreach ($param as $key => $val) {

                // exist
                if (($this->is_exist($val) == '1')) {

                    //if value exist in param exception
                    if (in_array($key, $param_exceptions)) {
                        $param[$key] = trim($val);
                    } else {
                        $val = str_replace("<br>", "\n", $val);
                        $param[$key] = htmlentities(trim($val));
                    }
                }else { // not exist
                // set null
                    $param[$key] = NULL;

                    // set default value
                    if (($this->is_exist($default) == '1')) {
                        foreach ($default as $dkey => $dval) {
                            if ($dkey == $key) {
                                $param[$dkey] = $dval;
                            }
                        }
                    }
                }
            }
        }

        $param = array_merge($default, $param);

        return $param;
    }

    public function generate_api_keys($aParam) {

        $aResponse = [];
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        //backend validation
        $this->form_apivalidation->set_rules('api_maskname', '', 'required');
        $this->form_apivalidation->set_rules('authentication_id', '', 'required');

        //return validation errors
        if ($this->form_apivalidation->run() == FALSE) {
            $aResponse['xhr']['status_code'] = 400;
            $aResponse['data']['message']['api_maskname'] = form_apierror('api_maskname');
            $aResponse['data']['message']['authentication_id'] = form_apierror('authentication_id');
            return $aResponse;
        }

        if($aParam['authentication_id']!=self::SECRET_KEY){
            $aResponse['xhr']['status_code'] = 401;
            $aResponse['data']['message'] = 'Authentication failed. Invalid authentication_id';
            return $aResponse;
        }

        //logic process
        $aResponse['xhr']['status_code'] = 200;
        $aResponse['data']['message']['api_key'] = $this->yel->encrypt_param($aParam['api_maskname']);
        $aResponse['data']['message']['api_authentication_id_value'] = $this->generate_authentication_id($aParam['api_maskname']);
        $aResponse['data']['message']['api_authentication_id'] = $this->yel->encrypt_param($this->generate_authentication_id($aParam['api_maskname']));

        return $aResponse;
    }

    public function add_file_complaint($aParam) {

        $aResponse = [];
        // $aResponse['flag'] = self::FAILED_RESPONSE;
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        //authenticate
        $this->form_apivalidation->set_rules('api_authentication_id', '', 'required');
        $this->form_apivalidation->set_rules('api_key', '', 'required');

        if ($this->form_apivalidation->run() == FALSE) {

            $aResponse['xhr']['status_code'] = 400;
            $aResponse['data']['message']['api_authentication_id'] = form_apierror('api_authentication_id');
            $aResponse['data']['message']['api_key'] = form_apierror('api_key');
            return $aResponse;
        }

        $auth = $this->authenticate_access($aParam);
        if($auth!=1){
            $aResponse['xhr']['status_code'] = 401;
            $aResponse['data']['message'] = 'Authentication failed. Invalid api_key or api_authentication_id';
            return $aResponse;
        }

        // complainant form validation
        $this->form_apivalidation->set_rules('is_victim', '', 'required');
        $this->form_apivalidation->set_rules('temporary_complainant_firstname', '', 'required');
        // $this->form_apivalidation->set_rules('temporary_complainant_middlename', '', 'required');
        $this->form_apivalidation->set_rules('temporary_complainant_lastname', '', 'required');
        $this->form_apivalidation->set_rules('temporary_complainant_mobile_number', '', 'required');
        $this->form_apivalidation->set_rules('temporary_complainant_email_address', '', 'required|valid_email');
        $this->form_apivalidation->set_rules('temporary_complainant_relation', '', 'required|integer');
        $this->form_apivalidation->set_rules('temporary_complainant_preffered_contact_method', '', 'required|integer');
        $this->form_apivalidation->set_rules('temporary_complainant_complain', '', 'required');

        // victim form validation
        $this->form_apivalidation->set_rules('temporary_victim_firstname', '', 'required');
        // $this->form_apivalidation->set_rules('temporary_victim_middlename', '', 'required');
        $this->form_apivalidation->set_rules('temporary_victim_lastname', '', 'required');
        $this->form_apivalidation->set_rules('temporary_victim_dob', '', 'required|valid_date');
        $this->form_apivalidation->set_rules('temporary_victim_email_address', '', 'required|valid_email');
        $this->form_apivalidation->set_rules('temporary_victim_mobile_number', '', 'required');
        $this->form_apivalidation->set_rules('temporary_victim_address', '', 'required');
        $this->form_apivalidation->set_rules('temporary_victim_country_deployment', '', 'required|integer');
        $this->form_apivalidation->set_rules('temporary_victim_civil_status', '', 'required|integer');
        $this->form_apivalidation->set_rules('temporary_victim_departure_type', '', 'required|integer');
        $this->form_apivalidation->set_rules('temporary_victim_sex', '', 'required|integer');

        // //return validation errors
        if ($this->form_apivalidation->run() == FALSE) {
            $aResponse['xhr']['status_code'] = 400;
            $aResponse['data']['message']['is_victim'] = form_apierror('is_victim');
            $aResponse['data']['message']['temporary_complainant_firstname'] = form_apierror('temporary_complainant_firstname');
            // $aResponse['data']['message']['temporary_complainant_middlename'] = form_apierror('temporary_complainant_middlename');
            $aResponse['data']['message']['temporary_complainant_lastname'] = form_apierror('temporary_complainant_lastname');
            $aResponse['data']['message']['temporary_complainant_mobile_number'] = form_apierror('temporary_complainant_mobile_number');
            $aResponse['data']['message']['temporary_complainant_email_address'] = form_apierror('temporary_complainant_email_address');
            $aResponse['data']['message']['temporary_complainant_relation'] = form_apierror('temporary_complainant_relation');
            $aResponse['data']['message']['temporary_complainant_preffered_contact_method'] = form_apierror('temporary_complainant_preffered_contact_method');
            $aResponse['data']['message']['temporary_complainant_complain'] = form_apierror('temporary_complainant_complain');
            $aResponse['data']['message']['temporary_victim_firstname'] = form_apierror('temporary_victim_firstname');
            // $aResponse['data']['message']['temporary_victim_middlename'] = form_apierror('temporary_victim_middlename');
            $aResponse['data']['message']['temporary_victim_lastname'] = form_apierror('temporary_victim_lastname');
            $aResponse['data']['message']['temporary_victim_dob'] = form_apierror('temporary_victim_dob');
            $aResponse['data']['message']['temporary_victim_email_address'] = form_apierror('temporary_victim_email_address');
            $aResponse['data']['message']['temporary_victim_mobile_number'] = form_apierror('temporary_victim_mobile_number');
            $aResponse['data']['message']['temporary_victim_address'] = form_apierror('temporary_victim_address');
            $aResponse['data']['message']['temporary_victim_country_deployment'] = form_apierror('temporary_victim_country_deployment');
            $aResponse['data']['message']['temporary_victim_civil_status'] = form_apierror('temporary_victim_civil_status');
            $aResponse['data']['message']['temporary_victim_departure_type'] = form_apierror('temporary_victim_departure_type');
            $aResponse['data']['message']['temporary_victim_sex'] = form_apierror('temporary_victim_sex');
            return $aResponse;
        }

        //convert date to db date format
        $aParam['temporary_victim_dob'] = convert_date_format($aParam['temporary_victim_dob'], 'Y-m-d', );

        //set default values
        $default = array(
            'temporary_complainant_middlename' => NULL,
            'temporary_victim_middlename' => NULL, 
            'is_victim' => 0, 
        );

        $aParam = $this->set_default_param($aParam, $default);

        // add to temporary case table
        $add_data = $this->Web_public_model->addFileComplaint($aParam);

        if($add_data[0]['stat'] == 1) {

           //temporary case logs / remarks
            // $aParam['temporary_case_remarks'] = "Complainant info has been updated."; 
            // $aParam['temporary_case_remarks_added_by'] = $_SESSION['userData']['user_id'];
            // $addTemporaryCaseAccessLog = $this->Temporary_case_model->AddTemporaryCaseRemarksBySystem($aParam);

            //temporary case access logs
            $aParam['temporary_case_id'] = $add_data[0]['insert_id'];
            $aParam['temporary_case_access_log_description'] = "Added new complaint."; 
            $addTempCaseLog = $this->Web_public_model->addTempCaseLog($aParam);

            $aResponse['tcn'] = $add_data[1]['temporary_case_number'];

            // send otp
            $otp = [];  
            $otp['otp_code'] = mt_rand(100000, 999999);
            $otp['otp_type'] = 0; // Default 0 = no value
            $otp['otp_portal'] = 2; // email
            $otp['temporary_case_id'] = $aParam['temporary_case_id'];

            $mail['to'] = array('raymark@s2-tech.com');
            $mail['subject'] = ' Your One Time Password';
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

                $aResponse['otp_details'] = $this->Web_public_model->getLastOtpRequestDetails($param);
            }

            $aResponse['xhr']['status_code'] = 200;
            $aResponse['data']['message'] = "Temporary Case added successfully";
        }
        
        return $aResponse;
    }

    public function search_case($param) {
        $aResponse = [];
        // $aResponse['flag'] = self::FAILED_RESPONSE;
        $param = $this->yel->safe_mode_clean_array($param);

        //authenticate
        $this->form_apivalidation->set_rules('api_authentication_id', '', 'required');
        $this->form_apivalidation->set_rules('api_key', '', 'required');

        if ($this->form_apivalidation->run() == FALSE) {

            $aResponse['xhr']['status_code'] = 400;
            $aResponse['data']['message']['api_authentication_id'] = form_apierror('api_authentication_id');
            $aResponse['data']['message']['api_key'] = form_apierror('api_key');
            return $aResponse;
        }

        $auth = $this->authenticate_access($param);
        if($auth!=1){
            $aResponse['xhr']['status_code'] = 401;
            $aResponse['data']['message'] = 'Authentication failed. Invalid api_key or api_authentication_id';
            return $aResponse;
        }

        // complainant form validation
        $this->form_apivalidation->set_rules('case_no', '', 'required');
        
        // //return validation errors
        if ($this->form_apivalidation->run() == FALSE) {
            $aResponse['xhr']['status_code'] = 400;
            $aResponse['data']['message']['case_no'] = form_apierror('case_no');
            return $aResponse;
        }

        // searched temp case
        $param['temporary_case_number'] = $param['case_no'];

        // check if temp case is existing in icms_temporary_case table
        $param['temp_case_info'] = $this->Web_public_model->getTempCaseInfoByCaseTempNumber($param);

        if(!empty($param['temp_case_info']['temporary_case_id']) !== false ) {
            $rs['tcn'] = $this->yel->encrypt_param($param['temporary_case_number']);
            $rs['result'] = 'temporary_case';
            $rs['link'] = '&tcn=' . $rs['tcn'];
            $param['temporary_case_id'] = $param['temp_case_info']['temporary_case_id'];

        } else {
            // check if existing in icms_case table
            $param['case_info'] = $this->Web_public_model->getCaseInfoByCaseNumber($param);
            if(!empty($param['case_info']['case_id']) !== false ) {
                $rs['cn'] = $this->yel->encrypt_param($param['case_info']['case_number']);
                $rs['result'] = 'case';
                $rs['link'] = '&cn=' . $rs['cn'];
                $param['temporary_case_id'] = $param['case_info']['case_id'];
                
            } else {
                $aResponse['xhr']['status_code'] = 400;
                $aResponse['data']['message']['case_no']= 'Invalid case_no. case_no not found';
                return $aResponse;
            }
        }
        
        //logs
        $param['temporary_case_access_log_description'] = "Searched from public website."; 
        $addTempCaseLog = $this->Web_public_model->addTempCaseLog($param);

        if($rs['result'] == 'case') {
            $param['temporary_case_id'] = 'CN-' . $param['case_info']['case_id'];
        }

        // send otp
        $otp = [];  
        $otp['otp_code'] = mt_rand(100000, 999999);
        $otp['otp_type'] = 0; // Default 0 = no value
        $otp['otp_portal'] = 2; // email
        $otp['temporary_case_id'] = $param['temporary_case_id'];

        $mail['to'] = array('raymark@s2-tech.com');
        $mail['subject'] = ' Your One Time Password';
        // $mail['template'] = 'otp';
        $mail['message'] = $otp['otp_code'] . '<br>';
        $mail['message'] .= "please enter this code";
        $email_result = $this->mailbox->sendMail($mail);
        // $email_result = $this->mailbox->sendEmailWithTemplate('email_verification', $aEmail);
        $rs['email_sent'] = $email_result['flag'];
        if ($rs['email_sent'] == "1") {
            $this->Web_public_model->saveOTP($otp);
        }

        // temporary for testing only
        $aParam['otp_portal'] =  '2';
        // if($rs['result'] == 'case') {
        //     $aParam['temp_case_info']['temporary_case_id'] = $param['case_info']['case_id'];
        // } else {
        $aParam['temp_case_info']['temporary_case_id'] = $param['temporary_case_id'];
        // }
        $rs['otp_details'] = $this->Web_public_model->getLastOtpRequestDetails($aParam);
        $rs['link'] = MAIN_SITE_URL.'verification?code='. $rs['otp_details']['otp_code'] . $rs['link'];
        
        $aResponse['xhr']['status_code'] = 200;
        $aResponse['data'] = $rs;

        return $aResponse;

    }


    public function get_complainant_relation_types($aParam){
        $aResponse = [];

        $aParam = $this->yel->safe_mode_clean_array($aParam);

        //authenticate
        $this->form_apivalidation->set_rules('api_authentication_id', '', 'required');
        $this->form_apivalidation->set_rules('api_key', '', 'required');

        if ($this->form_apivalidation->run() == FALSE) {

            $aResponse['xhr']['status_code'] = 400;
            $aResponse['data']['message']['api_authentication_id'] = form_apierror('api_authentication_id');
            $aResponse['data']['message']['api_key'] = form_apierror('api_key');
            return $aResponse;
        }

        $auth = $this->authenticate_access($aParam);
        if($auth!=1){
            $aResponse['xhr']['status_code'] = 401;
            $aResponse['data']['message'] = 'Authentication failed. Invalid api_key or api_authentication_id';
            return $aResponse;
        }

        $aParam['order_by'] = 'ORDER  BY `parameter_count_id` ASC';
        $aParam['status'] = '1';

        $aParam['type_id'] = '31';
        $aResponse['data']['complainant_relations_types'] = $this->Global_data_model->getGlobalParameter($aParam);
        $aResponse['xhr']['status_code'] = 200;
        
        return $aResponse;
    }

    public function get_preferred_contact_method_types($aParam){
        $aResponse = [];

        $aParam = $this->yel->safe_mode_clean_array($aParam);

        //authenticate
        $this->form_apivalidation->set_rules('api_authentication_id', '', 'required');
        $this->form_apivalidation->set_rules('api_key', '', 'required');

        if ($this->form_apivalidation->run() == FALSE) {

            $aResponse['xhr']['status_code'] = 400;
            $aResponse['data']['message']['api_authentication_id'] = form_apierror('api_authentication_id');
            $aResponse['data']['message']['api_key'] = form_apierror('api_key');
            return $aResponse;
        }

        $auth = $this->authenticate_access($aParam);
        if($auth!=1){
            $aResponse['xhr']['status_code'] = 401;
            $aResponse['data']['message'] = 'Authentication failed. Invalid api_key or api_authentication_id';
            return $aResponse;
        }

        $aParam['order_by'] = 'ORDER  BY `parameter_count_id` ASC';
        $aParam['status'] = '1';

        $aParam['type_id'] = '30';
        $aResponse['data']['contact_method_types'] = $this->Global_data_model->getGlobalParameter($aParam);
        $aResponse['xhr']['status_code'] = 200;
        
        return $aResponse;
    }

    public function get_sex_types($aParam){
        $aResponse = [];

        $aParam = $this->yel->safe_mode_clean_array($aParam);

        //authenticate
        $this->form_apivalidation->set_rules('api_authentication_id', '', 'required');
        $this->form_apivalidation->set_rules('api_key', '', 'required');

        if ($this->form_apivalidation->run() == FALSE) {

            $aResponse['xhr']['status_code'] = 400;
            $aResponse['data']['message']['api_authentication_id'] = form_apierror('api_authentication_id');
            $aResponse['data']['message']['api_key'] = form_apierror('api_key');
            return $aResponse;
        }

        $auth = $this->authenticate_access($aParam);
        if($auth!=1){
            $aResponse['xhr']['status_code'] = 401;
            $aResponse['data']['message'] = 'Authentication failed. Invalid api_key or api_authentication_id';
            return $aResponse;
        }

        $aParam['order_by'] = 'ORDER  BY `parameter_count_id` ASC';
        $aParam['status'] = '1';

        $aParam['type_id'] = '9';
        $aResponse['data']['sex_types'] = $this->Global_data_model->getGlobalParameter($aParam);
        $aResponse['xhr']['status_code'] = 200;
        
        return $aResponse;
    }

    public function get_civil_status_types($aParam){
        $aResponse = [];

        $aParam = $this->yel->safe_mode_clean_array($aParam);

        //authenticate
        $this->form_apivalidation->set_rules('api_authentication_id', '', 'required');
        $this->form_apivalidation->set_rules('api_key', '', 'required');

        if ($this->form_apivalidation->run() == FALSE) {

            $aResponse['xhr']['status_code'] = 400;
            $aResponse['data']['message']['api_authentication_id'] = form_apierror('api_authentication_id');
            $aResponse['data']['message']['api_key'] = form_apierror('api_key');
            return $aResponse;
        }

        $auth = $this->authenticate_access($aParam);
        if($auth!=1){
            $aResponse['xhr']['status_code'] = 401;
            $aResponse['data']['message'] = 'Authentication failed. Invalid api_key or api_authentication_id';
            return $aResponse;
        }

        $aParam['order_by'] = 'ORDER  BY `parameter_count_id` ASC';
        $aParam['status'] = '1';

        $aParam['type_id'] = '3';
        $aResponse['data']['civil_status_types'] = $this->Global_data_model->getGlobalParameter($aParam);
        $aResponse['xhr']['status_code'] = 200;
        
        return $aResponse;
    }

    public function get_departure_types($aParam){
        $aResponse = [];

        $aParam = $this->yel->safe_mode_clean_array($aParam);

        //authenticate
        $this->form_apivalidation->set_rules('api_authentication_id', '', 'required');
        $this->form_apivalidation->set_rules('api_key', '', 'required');

        if ($this->form_apivalidation->run() == FALSE) {

            $aResponse['xhr']['status_code'] = 400;
            $aResponse['data']['message']['api_authentication_id'] = form_apierror('api_authentication_id');
            $aResponse['data']['message']['api_key'] = form_apierror('api_key');
            return $aResponse;
        }

        $auth = $this->authenticate_access($aParam);
        if($auth!=1){
            $aResponse['xhr']['status_code'] = 401;
            $aResponse['data']['message'] = 'Authentication failed. Invalid api_key or api_authentication_id';
            return $aResponse;
        }

        $aParam['order_by'] = 'ORDER  BY `parameter_count_id` ASC';
        $aParam['status'] = '1';

        $aParam['type_id'] = '5';
        $aResponse['data']['departure_types'] = $this->Global_data_model->getGlobalParameter($aParam);
        $aResponse['xhr']['status_code'] = 200;
        
        return $aResponse;
    }

    public function get_countries($aParam){
        $aResponse = [];

        $aParam = $this->yel->safe_mode_clean_array($aParam);

        //authenticate
        $this->form_apivalidation->set_rules('api_authentication_id', '', 'required');
        $this->form_apivalidation->set_rules('api_key', '', 'required');

        if ($this->form_apivalidation->run() == FALSE) {

            $aResponse['xhr']['status_code'] = 400;
            $aResponse['data']['message']['api_authentication_id'] = form_apierror('api_authentication_id');
            $aResponse['data']['message']['api_key'] = form_apierror('api_key');
            return $aResponse;
        }

        $auth = $this->authenticate_access($aParam);
        if($auth!=1){
            $aResponse['xhr']['status_code'] = 401;
            $aResponse['data']['message'] = 'Authentication failed. Invalid api_key or api_authentication_id';
            return $aResponse;
        }

        $aParam['order_by'] = 'ORDER  BY `parameter_count_id` ASC';
        $aParam['status'] = '1';

        $aResponse['data']['countries'] = $this->Global_data_model->getCountries($aParam);
        $aResponse['xhr']['status_code'] = 200;
        
        return $aResponse;
    }

}
