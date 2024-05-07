<?php

/**
 * Temporary case Internal Ajax
 * 
 * @module Ajax Loader
 * @author LBS eBusiness Solutions Corp. 
 * @since 2017
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Temporary_case extends CI_Controller {

    const SUCCESS_RESPONSE = 1;
    const FAILED_RESPONSE = 0;

    public function __construct() {
        parent::__construct();

        //load validation library
        $this->load->library('form_validation');

        // $this->load->helper('helper');
        // load models
        $this->load->model('administrator/Temporary_case_model');
        $this->load->model('Global_data_model');
        $this->load->model('web_public/Web_public_model');
    }

    /**
     * Ajax Route :: Action Controller
     */
    public function ajax() {
        // route ajax api
        $this->base_action_ajax();
    }

    public function test($aParam) {
        $aResponse = [];
        $aResponse['flag'] = self::FAILED_RESPONSE;
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        //backend validation
        // $this->form_validation->set_rules('temporary_case_id', '', 'required');
        // $this->form_validation->set_rules('temporary_complainant_firstname', '', 'required');
        // $this->form_validation->set_rules('temporary_complainant_middlename', '', 'required');
        // //return validation errors
        // if ($this->form_validation->run() == FALSE) {
        //     $aResponse['message']['temporary_case_id'] = form_error('temporary_case_id');
        //     $aResponse['message']['temporary_complainant_firstname'] = form_error('temporary_complainant_firstname');
        //     $aResponse['message']['temporary_complainant_middlename'] = form_error('temporary_complainant_middlename');
        // }
        $test = '10/22/1990';
        $aResponse['test_helper'] = convert_date_format($test, 'F j, Y', 'date');

        return $aResponse;
    }

    public function getTemporaryCaseByTemporaryCaseId($aParam) {
        $aResponse = [];
        $aResponse['flag'] = self::FAILED_RESPONSE;
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        //backend validation
        $this->form_validation->set_rules('temporary_case_id', '', 'required');

        //return validation errors
        if ($this->form_validation->run() == FALSE) {
            $aResponse['message']['temporary_case_id'] = form_error('temporary_case_id');
            return $aResponse;
        }

        //set param
        $aParam['temporary_case_id'] = $this->yel->decrypt_param($aParam['temporary_case_id']);

        $aRecordSet = $this->Temporary_case_model->getTemporaryCaseByTemporaryCaseId($aParam);

        if (!empty($aRecordSet)) {

            $temp_case_number = $this->Temporary_case_model->getTemporaryCaseNumberByTemporaryCaseId($aParam);

            // Get Case ID and Case Number 
            if($aRecordSet['temporary_case_status_id'] == "3"){
                $case = $this->Temporary_case_model->getCaseDetails($aRecordSet);
                $aRecordSet['case_number'] = $case['case_number'];
                $aRecordSet['case_link'] = ADMIN_SITE_URL . "update_case/" . $this->yel->encrypt_param($case['case_id']);
            }

            //temporary case access logs
            $aParam['temporary_case_access_log_description'] = 'Fetch data of temporary case number (' . $temp_case_number . ') by admin user';
            $addTemporaryCaseAccessLog = $this->Temporary_case_model->addTemporaryCaseAccessLog($aParam);

            $aRecordSet = convert_date_format($aRecordSet, 'F d, Y h:i A', array('temporary_case_date_added'));
            $aRecordSet = convert_date_format($aRecordSet, 'm/d/Y', array('temporary_victim_dob'));
            $aResponse['recordset'] = $this->yel->encrypt_param_row($aRecordSet, array('temporary_case_id', 'case_id'));

            $aResponse['flag'] = self::SUCCESS_RESPONSE;
        }

        return $aResponse;
    }

    public function updateComplainantInfoByTemporaryCaseId($aParam) {
        $aResponse = [];
        $aResponse['flag'] = self::FAILED_RESPONSE;
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        //backend validation
        $this->form_validation->set_rules('temporary_case_id', '', 'required');
        $this->form_validation->set_rules('temporary_complainant_firstname', '', 'required');
        $this->form_validation->set_rules('temporary_complainant_lastname', '', 'required');
        $this->form_validation->set_rules('temporary_complainant_mobile_number', '', 'required');
        $this->form_validation->set_rules('temporary_complainant_email_address', '', 'required|valid_email');
        $this->form_validation->set_rules('temporary_complainant_relation', '', 'required|integer');
        $this->form_validation->set_rules('temporary_complainant_address', '', 'required');
        $this->form_validation->set_rules('temporary_complainant_preffered_contact_method', '', 'required|integer');

        //return validation errors
        if ($this->form_validation->run() == FALSE) {

            $aResponse['message']['temporary_case_id'] = form_error('temporary_case_id');
            $aResponse['message']['temporary_complainant_firstname'] = form_error('temporary_complainant_firstname');
            $aResponse['message']['temporary_complainant_lastname'] = form_error('temporary_complainant_lastname');
            $aResponse['message']['temporary_complainant_mobile_number'] = form_error('temporary_complainant_mobile_number');
            $aResponse['message']['temporary_complainant_email_address'] = form_error('temporary_complainant_email_address');
            $aResponse['message']['temporary_complainant_relation'] = form_error('temporary_complainant_relation');
            $aResponse['message']['temporary_complainant_address'] = form_error('temporary_complainant_address');
            $aResponse['message']['temporary_complainant_preffered_contact_method'] = form_error('temporary_complainant_preffered_contact_method');

            // }
            return $aResponse;
        }

        //set param
        $aParam['temporary_case_id'] = $this->yel->decrypt_param($aParam['temporary_case_id']);
        $aParam['temporary_case_updated_by'] = $_SESSION['userData']['user_id'];

        $update = $this->Temporary_case_model->updateComplainantInfoByTemporaryCaseId($aParam);

        if ($update['stat'] == 1) {

            //temporary case logs / remarks
            $aParam['temporary_case_remarks'] = "Complainant info has been updated.";
            $aParam['temporary_case_remarks_added_by'] = $_SESSION['userData']['user_id'];
            $addTemporaryCaseAccessLog = $this->Temporary_case_model->AddTemporaryCaseRemarksBySystem($aParam);

            // //temporary case access logs
            // $aParam['temporary_case_access_log_description'] = $aParam['temporary_case_remarks'];
            // $addTemporaryCaseAccessLog = $this->Temporary_case_model->addTemporaryCaseAccessLog($aParam);

            //user log
            $temporary_case_number = $this->Temporary_case_model->getTemporaryCaseNumberByTemporaryCaseId($aParam);

            $aLog = [];
            $aLog['log_event_type'] = 47; // base on table : icms_user_event_type
            $aLog['log_message'] = "Update complainant details of temporary case number (".$temporary_case_number.").";
            $aLog['log_link'] = 'temporary_case/' . $this->yel->encrypt_param($aParam['temporary_case_id']);
            $aLog['log_action'] = 1; // 1= new inserted // 2=update table
            $aResponse['log'] = $this->audit->create($aLog);

            $aResponse['flag'] = self::SUCCESS_RESPONSE;
            $this->UpdateConfirmationGmail();
        }

        return $aResponse;
    }

    public function updateVictimInfoByTemporaryCaseId($aParam) {
        $aResponse = [];
        $aResponse['flag'] = self::FAILED_RESPONSE;
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        //backend validation
        $this->form_validation->set_rules('temporary_case_id', '', 'required');
        $this->form_validation->set_rules('temporary_victim_firstname', '', 'required');
        $this->form_validation->set_rules('temporary_victim_lastname', '', 'required');
        $this->form_validation->set_rules('temporary_victim_dob', '', 'required|valid_date');
        $this->form_validation->set_rules('temporary_victim_email_address', '', 'required|valid_email');
        $this->form_validation->set_rules('temporary_victim_mobile_number', '', 'required');
        $this->form_validation->set_rules('temporary_victim_address', '', 'required');
        $this->form_validation->set_rules('temporary_victim_country_deployment', '', 'required|integer');
        $this->form_validation->set_rules('temporary_victim_civil_status', '', 'required|integer');
        $this->form_validation->set_rules('temporary_victim_departure_type', '', 'required|integer');
        $this->form_validation->set_rules('temporary_victim_sex', '', 'required|integer');

        //return validation errors
        if ($this->form_validation->run() == FALSE) {
            $aResponse['message']['temporary_case_id'] = form_error('temporary_case_id');
            $aResponse['message']['temporary_victim_firstname'] = form_error('temporary_victim_firstname');
            $aResponse['message']['temporary_victim_lastname'] = form_error('temporary_victim_lastname');
            $aResponse['message']['temporary_victim_dob'] = form_error('temporary_victim_dob');
            $aResponse['message']['temporary_victim_email_address'] = form_error('temporary_victim_email_address');
            $aResponse['message']['temporary_victim_mobile_number'] = form_error('temporary_victim_mobile_number');
            $aResponse['message']['temporary_victim_address'] = form_error('temporary_victim_address');
            $aResponse['message']['temporary_victim_country_deployment'] = form_error('temporary_victim_country_deployment');
            $aResponse['message']['temporary_victim_civil_status'] = form_error('temporary_victim_civil_status');
            $aResponse['message']['temporary_victim_departure_type'] = form_error('temporary_victim_departure_type');
            $aResponse['message']['temporary_victim_sex'] = form_error('temporary_victim_sex');

            return $aResponse;
        }

        //set param
        $aParam['temporary_case_id'] = $this->yel->decrypt_param($aParam['temporary_case_id']);
        $aParam['temporary_case_updated_by'] = $_SESSION['userData']['user_id'];
        $aParam['temporary_victim_dob'] = convert_date_format($aParam['temporary_victim_dob'], 'Y-m-d', 'temporary_victim_dob');

        $update = $this->Temporary_case_model->updateVictimInfoByTemporaryCaseId($aParam);

        if ($update['stat'] == 1) {

            //temporary case logs / remarks
            $aParam['temporary_case_remarks'] = "Victim info has been updated.";
            $aParam['temporary_case_remarks_added_by'] = $_SESSION['userData']['user_id'];
            $addTemporaryCaseAccessLog = $this->Temporary_case_model->AddTemporaryCaseRemarksBySystem($aParam);

            // //temporary case access logs
            // $aParam['temporary_case_access_log_description'] = $aParam['temporary_case_remarks'];
            // $addTemporaryCaseAccessLog = $this->Temporary_case_model->addTemporaryCaseAccessLog($aParam);

            //user log
            $temporary_case_number = $this->Temporary_case_model->getTemporaryCaseNumberByTemporaryCaseId($aParam);

            $aLog = [];
            $aLog['log_event_type'] = 46; // base on table : icms_user_event_type
            $aLog['log_message'] = "Update victim details of temporary case number (".$temporary_case_number.").";
            $aLog['log_link'] = 'temporary_case/' . $this->yel->encrypt_param($aParam['temporary_case_id']);
            $aLog['log_action'] = 1; // 1= new inserted // 2=update table
            $aResponse['log'] = $this->audit->create($aLog);

            $aResponse['flag'] = self::SUCCESS_RESPONSE;
            $this->UpdateConfirmationGmail();
        }

        return $aResponse;
    }

    public function getTemporaryCaseRemarksByTemporaryCaseId($aParam) {
        $aResponse = [];
        $aResponse['flag'] = self:: FAILED_RESPONSE;
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        //backend validation
        $this->form_validation->set_rules('temporary_case_id', '', 'required');

        //return validation errors
        if ($this->form_validation->run() == FALSE) {
            $aResponse['message']['temporary_case_id'] = form_error('temporary_case_id');
            return $aResponse;
        }

        $aParam['temporary_case_id'] = $this->yel->decrypt_param($aParam['temporary_case_id']);

        $remarks = $this->Temporary_case_model->getTemporaryCaseRemarksByTemporaryCaseId($aParam);

        //if case status is added to case
        $temp_case = $this->Temporary_case_model->getTemporaryCaseByTemporaryCaseId($aParam);
        $status = $temp_case['temporary_case_status_id'];

        if ($status == '3') { //if added to case get services logs
            $services_logs = '';
            $services = $this->Temporary_case_model->getServices($aParam);
       
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
        }

        // SORT BY DATE 
        $sort = [];
        foreach ($remarks as $key => $part) {
                $sort[$key] = strtotime($part['temporary_case_remarks_date_added']);
        }
        
        array_multisort($sort, SORT_DESC, $remarks);

        // if there is remarks 
        if (count($remarks) > 0) {
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
                    $data['temporary_case_id'] = $value['temporary_case_id'];
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
            $aResponse['recordset']['listing'] = $this->yel->encrypt_id_in_array($remarks, array('temporary_case_remarks_id', 'temporary_case_id'));
            $aResponse['flag'] = self:: SUCCESS_RESPONSE;
        }

        return $aResponse;
    }

    public function getTemporaryCaseAccessLogsByTemporaryCaseId($aParam) {
        $aResponse = [];
        $aResponse['flag'] = self:: FAILED_RESPONSE;
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        //backend validation
        $this->form_validation->set_rules('temporary_case_id', '', 'required');

        //return validation errors
        if ($this->form_validation->run() == FALSE) {
            $aResponse['message']['temporary_case_id'] = form_error('temporary_case_id');
            return $aResponse;
        }

        $aParam['temporary_case_id'] = $this->yel->decrypt_param($aParam['temporary_case_id']);

        $logs = $this->Temporary_case_model->getTemporaryCaseAccessLogsByTemporaryCaseId($aParam);

        if (count($logs) > 0) {
            $logs = convert_date_format($logs, 'F d, Y h:i A', array('date_added'));
            $aResponse['recordset']['listing'] = $this->yel->encrypt_id_in_array($logs, array('temporary_case_access_log_id', 'temporary_case_id'));
            $aResponse['flag'] = self:: SUCCESS_RESPONSE;
        }

        return $aResponse;
    }

    public function AddTemporaryCaseRemarksByUser($aParam) {
        $aResponse = [];
        $aResponse['flag'] = self::FAILED_RESPONSE;
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        //backend validation
        $this->form_validation->set_rules('temporary_case_id', '', 'required');
        $this->form_validation->set_rules('temporary_case_remarks', '', 'required');

        //return validation errors
        if ($this->form_validation->run() == FALSE) {
            $aResponse['message']['temporary_case_id'] = form_error('temporary_case_id');
            $aResponse['message']['temporary_case_remarks'] = form_error('temporary_case_remarks');
            return $aResponse;
        }

        //set param
        $aParam['temporary_case_id'] = $this->yel->decrypt_param($aParam['temporary_case_id']);
        $aParam['temporary_case_remarks_added_by'] = $_SESSION['userData']['user_id'];

        $update = $this->Temporary_case_model->AddTemporaryCaseRemarksByUser($aParam);

        if ($update['stat'] == 1) {

            //user log
            $temporary_case_number = $this->Temporary_case_model->getTemporaryCaseNumberByTemporaryCaseId($aParam);

            $aLog = [];
            $aLog['log_event_type'] = 48; // base on table : icms_user_event_type
            $aLog['log_message'] = "Add remarks on temporary case number (".$temporary_case_number.").";
            $aLog['log_link'] = 'temporary_case/' . $this->yel->encrypt_param($aParam['temporary_case_id']);
            $aLog['log_action'] = 1; // 1= new inserted // 2=update table
            $aResponse['log'] = $this->audit->create($aLog);

             //send victim notification
             $this->notif->sendNotificationToVictim([
                "notif_type" => "add-remarks",
                "id_type" => "temporary_case_id",
                "id" => $aParam['temporary_case_id']
            ]);

            $aResponse['flag'] = self::SUCCESS_RESPONSE;
            
        }

        return $aResponse;
    }

    public function updateTemporaryCaseRemarks($aParam) {
        $aResponse = [];
        $aResponse['flag'] = self::FAILED_RESPONSE;
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        //backend validation
        $this->form_validation->set_rules('temporary_case_remarks_id', '', 'required');
        $this->form_validation->set_rules('temporary_case_remarks', '', 'required');

        //return validation errors
        if ($this->form_validation->run() == FALSE) {
            $aResponse['message']['temporary_case_remarks_id'] = form_error('temporary_case_remarks_id');
            $aResponse['message']['temporary_case_remarks'] = form_error('temporary_case_remarks');
            return $aResponse;
        }

        //set param
        $aParam['temporary_case_remarks_id'] = $this->yel->decrypt_param($aParam['temporary_case_remarks_id']);
        $aParam['temporary_case_remarks_updated_by'] = $_SESSION['userData']['user_id'];

        $update = $this->Temporary_case_model->updateTemporaryCaseRemarks($aParam);

        if ($update['stat'] == 1) {

            //user log
            $temporary_case_number = $this->Temporary_case_model->getTemporaryCaseNumberByTemporaryCaseRemarksId($aParam);
            $temp_case_id = $this->Temporary_case_model->getTemporaryCaseIdByTemporaryCaseRemarksId($aParam);

            $aLog = [];
            $aLog['log_event_type'] = 48; // base on table : icms_user_event_type
            $aLog['log_message'] = "Update remarks on temporary case number (".$temporary_case_number.").";
            $aLog['log_link'] = 'temporary_case/' . $this->yel->encrypt_param($temp_case_id);
            $aLog['log_action'] = 1; // 1= new inserted // 2=update table
            $aResponse['log'] = $this->audit->create($aLog);

            $aResponse['flag'] = self::SUCCESS_RESPONSE;
        }

        return $aResponse;
    }

    public function updateTemporaryCaseStatusById($aParam) {
        $aResponse = [];
        $aResponse['flag'] = self::FAILED_RESPONSE;
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        //backend validation
        $this->form_validation->set_rules('temporary_case_id', '', 'required');
        $this->form_validation->set_rules('temporary_case_status_id', '', 'required|integer');

        //return validation errors
        if ($this->form_validation->run() == FALSE) {
            $aResponse['message']['temporary_case_id'] = form_error('temporary_case_id');
            $aResponse['message']['temporary_case_status_id'] = form_error('temporary_case_status_id');
            return $aResponse;
        }

        //set param
        $aParam['temporary_case_id'] = $this->yel->decrypt_param($aParam['temporary_case_id']);
        $aParam['temporary_case_updated_by'] = $_SESSION['userData']['user_id'];

        $update = $this->Temporary_case_model->updateTemporaryCaseStatusById($aParam);

        if ($update['stat'] == 1) {

            //temporary case logs / remarks
            $temp_case_number = $this->Temporary_case_model->getTemporaryCaseNumberByTemporaryCaseId($aParam);
            $aParam['transaction_parameter_type_id'] = '12';
            $aParam['transaction_parameter_count_id'] = $aParam['temporary_case_status_id'];
            $temp_case_status_name = $this->Global_data_model->getTransactionParamaterNameByTypeAndCountId($aParam);

            $aParam['temporary_case_remarks'] = 'Temporary case number (' . $temp_case_number . ') status has been updated to (' . $temp_case_status_name . ')';
            $aParam['temporary_case_remarks_added_by'] = $_SESSION['userData']['user_id'];
            $addTemporaryCaseAccessLog = $this->Temporary_case_model->AddTemporaryCaseRemarksBySystem($aParam);

            //temporary case access logs
            $aParam['temporary_case_access_log_description'] = $aParam['temporary_case_remarks'];
            $addTemporaryCaseAccessLog = $this->Temporary_case_model->addTemporaryCaseAccessLog($aParam);

            //send victim notification
            $this->notif->sendNotificationToVictim([
                "notif_type" => "temp-status",
                "id_type" => "temporary_case_id",
                "id" => $aParam['temporary_case_id']
            ]);

            //user log
            $temporary_case_number = $this->Temporary_case_model->getTemporaryCaseNumberByTemporaryCaseId($aParam);

            $aLog = [];
            $aLog['log_event_type'] = 45; // base on table : icms_user_event_type
            $aLog['log_message'] = "Update status of temporary case number (".$temporary_case_number.") to " . $temp_case_status_name . ".";
            $aLog['log_link'] = 'temporary_case/' . $this->yel->encrypt_param($aParam['temporary_case_id']);
            $aLog['log_action'] = 1; // 1= new inserted // 2=update table
            $aResponse['log'] = $this->audit->create($aLog);

            $aResponse['flag'] = self::SUCCESS_RESPONSE;
            $this->UpdateConfirmationGmail();
        }

        return $aResponse;
    }

    public function getFilter($aParam){
        $filter = json_decode($aParam['filters'], true);
        $data = [];
        $data['cFilter'] = "";
        $data['sRelevance'] = "";
        
        if (!empty($filter['name_complainant']) !== false) {
            $data['sRelevance'] .= "";
            $data['cFilter'] .= " AND (MATCH (`temporary_complainant_firstname`, `temporary_complainant_middlename`, `temporary_complainant_lastname`) AGAINST ('+" . $filter['name_complainant'] . "*' IN BOOLEAN MODE))";
        }
        
        if (!empty($filter['name_victim']) !== false) {
            $data['sRelevance'] .= "";
            $data['cFilter'] .= " AND (MATCH (`temporary_victim_firstname`, `temporary_victim_middlename`, `temporary_victim_lastname`, `temporary_victim_suffix`) AGAINST ('+" . $filter['name_victim'] . "*' IN BOOLEAN MODE))";
        }
        
        if (!empty($filter['temporary_victim_departure_type']) !== false) {
            $data['cFilter'] .= " AND temporary_victim_departure_type  IN (".$filter['temporary_victim_departure_type'].")" ;
        }
        
        if (!empty($filter['temporary_victim_sex']) !== false) {
            $data['cFilter'] .= " AND temporary_victim_sex  IN (".$filter['temporary_victim_sex'].")" ;
        }

        if (!empty($filter['temporary_victim_civil_status']) !== false) {
            $data['cFilter'] .= " AND temporary_victim_civil_status  IN (".$filter['temporary_victim_civil_status'].")" ;
        }
        
        if (!empty($filter['temporary_victim_country_deployment']) !== false) {
            $data['cFilter'] .= " AND temporary_victim_country_deployment  IN  (".implode(",",$filter['temporary_victim_country_deployment']).")" ;
        }
        
        if ((!empty($filter['start_temporary_case_date_added']) !== false) && (!empty($filter['end_temporary_case_date_added']) !== false)) {
            $data['cFilter'] .= " AND DATE(temporary_case_date_added)  BETWEEN '". convert_date_format($filter['start_temporary_case_date_added'], 'Y-m-d', 'start_temporary_case_date_added')  ."' AND '". convert_date_format($filter['end_temporary_case_date_added'], 'Y-m-d', 'end_temporary_case_date_added') ."'";
        }
        
        return $data;
    }
    
    public function getAllTemporaryCaseList($aParam) {

        $aResponse = [];
        $aResult = [];
        $filter = $this->getFilter($aParam); 
        
        $aResult['cOderByRelevance'] = "";
        $aParam['sRelevance'] = "";
        $aParam['cRelevance'] = "";
        $aParam['cOrderBy'] = "";
        $aParam['countCondition'] = "";
        $aParam['countConditionStatus'] = "";
        $aParam['countConditionCategory'] = "";

        $aParam = $this->yel->clean_array($aParam);
        $aParam = $this->yel->pagination($aParam);

        $aResponse['flag'] = self:: FAILED_RESPONSE;

        // pagination
        $aResult['pagination'] = $aParam;
        // filter
        $aParam['cFilter'] = $filter['cFilter'];
        
        $aResponse['recordset'] = $this->Temporary_case_model->getAllTemporaryCaseList($aParam);

        // Unset Result pagination and relevanceco ndtion
        unset($aResponse['cOderByRelevance'], $aResult['pagination']);

        if (($aResponse['recordset']['count']) > 0) {
            foreach ($aResponse['recordset']['listing'] as $key => $val) {
                $aResponse['recordset']['listing'][$key]['temporary_case_id'] = $this->yel->encrypt_param($val['temporary_case_id']);
                $aResponse['recordset']['listing'][$key]['case_id'] = $this->yel->encrypt_param($val['case_id']);
            }
            $aResponse['flag'] = self:: SUCCESS_RESPONSE;
        }

        return $aResponse;
    }
    
    public function getPendingTemporaryCaseList($aParam) {

        $aResponse = [];
        $aResult = [];
        $filter = $this->getFilter($aParam); 
        
        $aResult['cOderByRelevance'] = "";
        $aParam['sRelevance'] = "";
        $aParam['cRelevance'] = "";
        $aParam['cOrderBy'] = "";
        $aParam['countCondition'] = "";
        $aParam['countConditionStatus'] = "";
        $aParam['countConditionCategory'] = "";

        $aParam = $this->yel->clean_array($aParam);
        $aParam = $this->yel->pagination($aParam);

        $aResponse['flag'] = self:: FAILED_RESPONSE;

        // pagination
        $aResult['pagination'] = $aParam;
        // filter
        $aParam['cFilter'] = $filter['cFilter'];

        // Condition for keyword
        // if ($aParam['keyword'] !== "" || empty($aParam['keyword']) == false) {
        //     $aParam['sRelevance'] = ", MATCH (`igat`.`agency_name`, `igat`.`agency_abbr`) AGAINST ('+" . $aParam['keyword'] . "*' IN BOOLEAN MODE)  as all_relevance";
        //     $aParam['cRelevance'] = " AND ( MATCH (`igat`.`agency_name`, `igat`.`agency_abbr`) AGAINST ('+" . $aParam['keyword'] . "*' IN BOOLEAN MODE) ) ";
        //     $aResult['cOderByRelevance'] = ' all_relevance ,';
        // }
        // Condition for Status 
        // if ($aParam['case_status'] !== "" || empty($aParam['case_status']) == false) {
        //     $aParam['cRelevance'] .= " AND `itc`.`temporary_case_status_id` = '".$aParam['case_status']."' ";
        // }


        $aResponse['recordset'] = $this->Temporary_case_model->getPendingTemporaryCases($aParam);

        // Unset Result pagination and relevanceco ndtion
        unset($aResponse['cOderByRelevance'], $aResult['pagination']);

        if (($aResponse['recordset']['count']) > 0) {
            foreach ($aResponse['recordset']['listing'] as $key => $val) {
                $aResponse['recordset']['listing'][$key]['temporary_case_id'] = $this->yel->encrypt_param($val['temporary_case_id']);
                $aResponse['recordset']['listing'][$key]['case_id'] = $this->yel->encrypt_param($val['case_id']);
            }
            $aResponse['flag'] = self:: SUCCESS_RESPONSE;
        }

        return $aResponse;
    }

    public function getForVerificationTemporaryCaseList($aParam) {

        $aResponse = [];
        $aResult = [];
        $filter = $this->getFilter($aParam); 
        
        $aResult['cOderByRelevance'] = "";
        $aParam['sRelevance'] = "";
        $aParam['cRelevance'] = "";
        $aParam['cOrderBy'] = "";
        $aParam['countCondition'] = "";
        $aParam['countConditionStatus'] = "";
        $aParam['countConditionCategory'] = "";

        $aParam = $this->yel->clean_array($aParam);
        $aParam = $this->yel->pagination($aParam);

        $aResponse['flag'] = self:: FAILED_RESPONSE;

        // pagination
        $aResult['pagination'] = $aParam;
        // filter
        $aParam['cFilter'] = $filter['cFilter'];

        // Condition for keyword
        // if ($aParam['keyword'] !== "" || empty($aParam['keyword']) == false) {
        //     $aParam['sRelevance'] = ", MATCH (`igat`.`agency_name`, `igat`.`agency_abbr`) AGAINST ('+" . $aParam['keyword'] . "*' IN BOOLEAN MODE)  as all_relevance";
        //     $aParam['cRelevance'] = " AND ( MATCH (`igat`.`agency_name`, `igat`.`agency_abbr`) AGAINST ('+" . $aParam['keyword'] . "*' IN BOOLEAN MODE) ) ";
        //     $aResult['cOderByRelevance'] = ' all_relevance ,';
        // }
        // Condition for Status 
        // if ($aParam['case_status'] !== "" || empty($aParam['case_status']) == false) {
        //     $aParam['cRelevance'] .= " AND `itc`.`temporary_case_status_id` = '".$aParam['case_status']."' ";
        // }


        $aResponse['recordset'] = $this->Temporary_case_model->getAddedToCaseTemporaryCases($aParam);

        // Unset Result pagination and relevanceco ndtion
        unset($aResponse['cOderByRelevance'], $aResult['pagination']);

        if (($aResponse['recordset']['count']) > 0) {
            foreach ($aResponse['recordset']['listing'] as $key => $val) {
                $aResponse['recordset']['listing'][$key]['temporary_case_id'] = $this->yel->encrypt_param($val['temporary_case_id']);
                $aResponse['recordset']['listing'][$key]['case_id'] = $this->yel->encrypt_param($val['case_id']);
            }
            $aResponse['flag'] = self:: SUCCESS_RESPONSE;
        }

        return $aResponse;
    }

    public function getAddedToCaseTemporaryCaseList($aParam) {

        $aResponse = [];
        $aResult = [];
        $filter = $this->getFilter($aParam); 
        
        $aResult['cOderByRelevance'] = "";
        $aParam['sRelevance'] = "";
        $aParam['cRelevance'] = "";
        $aParam['cOrderBy'] = "";
        $aParam['countCondition'] = "";
        $aParam['countConditionStatus'] = "";
        $aParam['countConditionCategory'] = "";

        $aParam = $this->yel->clean_array($aParam);
        $aParam = $this->yel->pagination($aParam);

        $aResponse['flag'] = self:: FAILED_RESPONSE;

        // pagination
        $aResult['pagination'] = $aParam;
        // filter
        $aParam['cFilter'] = $filter['cFilter'];
        
        // Condition for keyword
        // if ($aParam['keyword'] !== "" || empty($aParam['keyword']) == false) {
        //     $aParam['sRelevance'] = ", MATCH (`igat`.`agency_name`, `igat`.`agency_abbr`) AGAINST ('+" . $aParam['keyword'] . "*' IN BOOLEAN MODE)  as all_relevance";
        //     $aParam['cRelevance'] = " AND ( MATCH (`igat`.`agency_name`, `igat`.`agency_abbr`) AGAINST ('+" . $aParam['keyword'] . "*' IN BOOLEAN MODE) ) ";
        //     $aResult['cOderByRelevance'] = ' all_relevance ,';
        // }
        // Condition for Status 
        // if ($aParam['case_status'] !== "" || empty($aParam['case_status']) == false) {
        //     $aParam['cRelevance'] .= " AND `itc`.`temporary_case_status_id` = '".$aParam['case_status']."' ";
        // }


        $aResponse['recordset'] = $this->Temporary_case_model->getAddedToCaseTemporaryCases($aParam);

        // Unset Result pagination and relevanceco ndtion
        unset($aResponse['cOderByRelevance'], $aResult['pagination']);

        if (($aResponse['recordset']['count']) > 0) {
            foreach ($aResponse['recordset']['listing'] as $key => $val) {
                $aResponse['recordset']['listing'][$key]['temporary_case_id'] = $this->yel->encrypt_param($val['temporary_case_id']);
                $aResponse['recordset']['listing'][$key]['case_id'] = $this->yel->encrypt_param($val['case_id']);
            }
            $aResponse['flag'] = self:: SUCCESS_RESPONSE;
        }

        return $aResponse;
    }

    public function getArchivedTemporaryCaseList($aParam) {

        $aResponse = [];
        $aResult = [];
        $filter = $this->getFilter($aParam); 
        
        $aResult['cOderByRelevance'] = "";
        $aParam['sRelevance'] = "";
        $aParam['cRelevance'] = "";
        $aParam['cOrderBy'] = "";
        $aParam['countCondition'] = "";
        $aParam['countConditionStatus'] = "";
        $aParam['countConditionCategory'] = "";

        $aParam = $this->yel->clean_array($aParam);
        $aParam = $this->yel->pagination($aParam);

        $aResponse['flag'] = self:: FAILED_RESPONSE;

        // pagination
        $aResult['pagination'] = $aParam;
        // filter
        $aParam['cFilter'] = $filter['cFilter'];
        
        // Condition for keyword
        // if ($aParam['keyword'] !== "" || empty($aParam['keyword']) == false) {
        //     $aParam['sRelevance'] = ", MATCH (`igat`.`agency_name`, `igat`.`agency_abbr`) AGAINST ('+" . $aParam['keyword'] . "*' IN BOOLEAN MODE)  as all_relevance";
        //     $aParam['cRelevance'] = " AND ( MATCH (`igat`.`agency_name`, `igat`.`agency_abbr`) AGAINST ('+" . $aParam['keyword'] . "*' IN BOOLEAN MODE) ) ";
        //     $aResult['cOderByRelevance'] = ' all_relevance ,';
        // }
        // Condition for Status 
        // if ($aParam['case_status'] !== "" || empty($aParam['case_status']) == false) {
        //     $aParam['cRelevance'] .= " AND `itc`.`temporary_case_status_id` = '".$aParam['case_status']."' ";
        // }


        $aResponse['recordset'] = $this->Temporary_case_model->getArchivedTemporaryCases($aParam);

        // Unset Result pagination and relevanceco ndtion
        unset($aResponse['cOderByRelevance'], $aResult['pagination']);

        if (($aResponse['recordset']['count']) > 0) {
            foreach ($aResponse['recordset']['listing'] as $key => $val) {
                $aResponse['recordset']['listing'][$key]['temporary_case_id'] = $this->yel->encrypt_param($val['temporary_case_id']);
                $aResponse['recordset']['listing'][$key]['case_id'] = $this->yel->encrypt_param($val['case_id']);
            }
            $aResponse['flag'] = self:: SUCCESS_RESPONSE;
        }

        return $aResponse;
    }

    protected function getTemporaryCaseStatuses($aParam) {
        $aResponse = [];
        $aResponse['flag'] = self:: FAILED_RESPONSE;
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        $aParam['type_id'] = '12';
        $aParam['status'] = '1';
        $result = $this->Global_data_model->getTransactionParameter($aParam);

        if (count($result) > 0) {

            $aResponse['recordset']['listing'] = $result;

            $aResponse['flag'] = self:: SUCCESS_RESPONSE;
        }

        return $aResponse;
    }

    protected function getTemporaryCaseByAdvanceSearch($aParam) {
        // $aResponse = [];
        // $aResponse['flag'] = self:: FAILED_RESPONSE;
        // $aParam = $this->yel->safe_mode_clean_array($aParam);
        // //backend validation
        // $this->form_validation->set_rules('temporary_case_id', '', 'required');
        // //return validation errors
        // if ($this->form_validation->run() == FALSE) {
        //     $aResponse['message'] = validation_errors();
        //     return $aResponse;
        // }
        // $aParam['temporary_case_id'] = $this->yel->decrypt_param($aParam['temporary_case_id']);
        // $result = $this->Temporary_case_model->getTemporaryCaseRemarksByTemporaryCaseId($aParam);
        // if (count($result) > 0) {
        //     $aResponse['recordset']['listing'] = $this->yel->encrypt_id_in_array($result, array('temporary_case_remarks_id','temporary_case_id'));
        //     $aResponse['flag'] = self:: SUCCESS_RESPONSE;
        // }
        // return $aResponse;
    }

    public function deleteTemporaryCaseRemarks($aParam) {
        $aResponse = [];
        $aResponse['flag'] = self::FAILED_RESPONSE;
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        //backend validation
        $this->form_validation->set_rules('temporary_case_remarks_id', '', 'required');

        //return validation errors
        if ($this->form_validation->run() == FALSE) {
            $aResponse['message']['temporary_case_remarks_id'] = form_error('temporary_case_remarks_id');
            return $aResponse;
        }

        //set param
        $aParam['temporary_case_remarks_id'] = $this->yel->decrypt_param($aParam['temporary_case_remarks_id']);
        $aParam['temporary_case_remarks_updated_by'] = $_SESSION['userData']['user_id'];

        $update = $this->Temporary_case_model->deleteTemporaryCaseRemarks($aParam);

        if ($update['stat'] == 1) {
            //user log
            $temporary_case_number = $this->Temporary_case_model->getTemporaryCaseNumberByTemporaryCaseRemarksId($aParam);
            $temp_case_id = $this->Temporary_case_model->getTemporaryCaseIdByTemporaryCaseRemarksId($aParam);

            $aLog = [];
            $aLog['log_event_type'] = 48; // base on table : icms_user_event_type
            $aLog['log_message'] = "Remove remarks on temporary case number (".$temporary_case_number.").";
            $aLog['log_link'] = 'temporary_case/' . $this->yel->encrypt_param($temp_case_id);
            $aLog['log_action'] = 1; // 1= new inserted // 2=update table
            $aResponse['log'] = $this->audit->create($aLog);

            $aResponse['flag'] = self::SUCCESS_RESPONSE;
        }

        return $aResponse;
    }

    function UpdateConfirmationGmail() {
        // Load CodeIgniter instance
        $CI = &get_instance();
        // Load Email Library
        $CI->load->library('email');
    
        // Fetch all temporary cases
        $temporaryCases = $this->Temporary_case_model->getUpdateDataThatWillSend();
    
        // Check if there are temporary cases fetched
        if ($temporaryCases) {
            // Iterate through each temporary case
            foreach ($temporaryCases as $tempCase) {

                $value = $tempCase['temporary_complainant_relation'];
                $victimSex =$tempCase['temporary_victim_sex'];
                $victimCivilStatus =$tempCase['temporary_victim_civil_status'];
                $victimDepartureType =$tempCase['temporary_victim_departure_type'];
                $victimCountryDeloyment =$tempCase['temporary_victim_country_deployment'];
                $victimStatus =$tempCase['temporary_case_status_id'];

                $getGlobalValue = $this->Temporary_case_model->getGlobalData($value);
                $getGlobalDataVictimSex = $this->Temporary_case_model->getGlobalDataVictimSex($victimSex);
                $getGlobalDataVictimCivilStatus = $this->Temporary_case_model->getGlobalDataVictimCivilStatus($victimCivilStatus);
                $getGlobalDataDepartureType = $this->Temporary_case_model->getGlobalDataVictimDepartureType($victimDepartureType);
                $getGlobalDataCountryDeployment = $this->Temporary_case_model->getGlobalDataVictimCountryDeployment($victimCountryDeloyment);
                $getGlobalDataStatus = $this->Temporary_case_model->getGlobalDataVictimStatus($victimStatus);

                // Load email configuration dynamically
                $config = array(
                    'protocol' => EMAIL_FROM_PROTOCOL,
                    'smtp_host' => EMAIL_FROM_HOST,
                    'smtp_port' => EMAIL_FROM_PORT,
                    'smtp_user' => EMAIL_FROM_USER,
                    'smtp_pass' => EMAIL_FROM_PASS,
                    'mailtype' => EMAIL_FROM_mailtype,
                    'charset' => EMAIL_FROM_charset,
                    'smtp_crypto' => EMAIL_FROM_smtp_crypto,
                    'newline' => "\r\n"
                );
    
                $CI->email->initialize($config);
    
                $CI->email->from(EMAIL_FROM_EMAIL, EMAIL_FROM_NAME);
                $CI->email->to($tempCase['temporary_complainant_email_address']); // Use the fetched email address
                $CI->email->subject('[CASE NOTIFICATION] INTEGRATED CASE MANAGEMENT SYSTEM');
                // Construct email message
                $message = '<div style="font-family: Arial, sans-serif; font-size:18px; max-width: 600px; margin: 0 auto; padding: 20px; text-align: left;">';
                $message .= '<p>Hi! Mr/Mrs <b>'. $tempCase['temporary_complainant_lastname'] . ','. $tempCase['temporary_complainant_firstname'] .'</b> Your case data is been update!. <strong style="color:#3b5998;">' . $tempCase['temporary_case_number'] . '</strong> to your ICMS.OFW account.</p>'; // Use the fetched email address   
                $message .= '<hr style="border: none; border-top: 1px solid #ccc; margin: 20px 0;">';
                $message .= '<div style="display: flex; flex-wrap: wrap;">';
                $message .= '<div style="width: 50%;">';
                $message .= '<p>Status: </p>';
                $message .= $getGlobalDataStatus ? 
                implode('', array_map(function($globalDataStatus) { return '<p style="font-size: 11px;">Status: ' . $globalDataStatus['transaction_parameter_name']. '</p>'; }, $getGlobalDataStatus)) :
                '<p style="font-size: 11px;">Status: ' . $victimStatus . '</p>';
                // $message .= '<p style="font-size: 11px;">Status: ' . $tempCase['temporary_victim_civil_status']. '</p>';
                $message .= '<p>Complainant Details: </p>';
                $message .= '<p style="font-size: 11px;">Firstname: ' . $tempCase['temporary_complainant_firstname']. '</p>';
                $message .= '<p style="font-size: 11px;">Middlename: ' . $tempCase['temporary_complainant_middlename']. '</p>';
                $message .= '<p style="font-size: 11px;">Lastname: ' . $tempCase['temporary_complainant_lastname']. '</p>';
                $message .= '<p style="font-size: 11px;">Mobile Number: ' . $tempCase['temporary_complainant_mobile_number']. '</p>';
                $message .= '<p style="font-size: 11px;">Email: ' . $tempCase['temporary_complainant_email_address']. '</p>';
                $message .= '<p style="font-size: 11px;">Complain: ' . $tempCase['temporary_complainant_complain']. '</p>';
                // if ($getGlobalValue) {
                //     foreach ($getGlobalValue as $globalData) {
                //         $message .= '<p style="font-size: 11px;">Relationship to the victim: ' . $globalData['parameter_name']. '</p>';
                //     }
                // } else {
                //     $message .= 'Relationship to the victim: ' . $value . '</p>';
                // }
                $message .= $getGlobalValue ? 
                implode('', array_map(function($globalData) { return '<p style="font-size: 11px;">Relationship to the victim: ' . $globalData['parameter_name']. '</p>'; }, $getGlobalValue)) :
                '<p style="font-size: 11px;">Relationship to the victim: ' . $value . '</p>';

                // $message .= '<p style="font-size: 11px;">Relationship to the victim: ' . $tempCase['temporary_complainant_relation']. '</p>';
                $message .= '<p style="font-size: 11px;">Address: ' . $tempCase['temporary_complainant_address']. '</p>';
                $message .= '</div>';
                $message .= '<div style="width: 50%;">';
                $message .= '<p>Victim Details: </p>';
                $message .= '<p style="font-size: 11px;">Firstname: ' . $tempCase['temporary_victim_firstname']. '</p>';
                $message .= '<p style="font-size: 11px;">Middlename: ' . $tempCase['temporary_victim_middlename']. '</p>';
                $message .= '<p style="font-size: 11px;">Lastname: ' . $tempCase['temporary_victim_lastname']. '</p>';
                $message .= '<p style="font-size: 11px;">Birthday: ' . $tempCase['temporary_victim_dob']. '</p>';
                $message .= '<p style="font-size: 11px;">Email: ' . $tempCase['temporary_victim_email_address']. '</p>';
                $message .= '<p style="font-size: 11px;">Mobile Number: ' . $tempCase['temporary_victim_mobile_number']. '</p>';
                // if ($getGlobalDataVictimSex) {
                //     foreach ($getGlobalDataVictimSex as $globalDataSex) {
                //         $message .= '<p style="font-size: 11px;">Sex: ' . $globalDataSex['parameter_name']. '</p>';
                //     }
                // } else {
                //     $message .= 'Relationship to the victim: ' . $victimSex . '</p>';
                // }
                $message .= $getGlobalDataVictimSex ? 
                implode('', array_map(function($globalDataSex) { return '<p style="font-size: 11px;">Sex: ' . $globalDataSex['parameter_name']. '</p>'; }, $getGlobalDataVictimSex)) :
                '<p style="font-size: 11px;">Sex: ' . $victimSex . '</p>';


                $message .= '';

                if ($getGlobalDataCountryDeployment) {
                    foreach ($getGlobalDataCountryDeployment as $globalDataDeployment) {
                        $message .= '<p style="font-size: 11px;">Country of Deployment: ' . $globalDataDeployment['country_name']. '</p>';
                    }
                } else {
                    $message .= '<p style="font-size: 11px;">Country of Deployment: ' . $victimCountryDeloyment . '</p>';
                }


                // $message .= '<p style="font-size: 11px;">Country of Deployment: ' . $getGlobalDataCountryDeployment. '</p>';


                $message .= $getGlobalDataVictimCivilStatus ? 
                implode('', array_map(function($globalDataCivilStatus) { return '<p style="font-size: 11px;">Civil Status: ' . $globalDataCivilStatus['parameter_name']. '</p>'; }, $getGlobalDataVictimCivilStatus)) :
                '<p style="font-size: 11px;">Civil Status: ' . $victimCivilStatus . '</p>';
                // $message .= '<p style="font-size: 11px;">Civil Status: ' . $tempCase['temporary_victim_civil_status']. '</p>';

                $message .= $getGlobalDataDepartureType ? 
                implode('', array_map(function($globalDataDepartureType) { return '<p style="font-size: 11px;">Departure Type: ' . $globalDataDepartureType['parameter_name']. '</p>'; }, $getGlobalDataDepartureType)) :
                '<p style="font-size: 11px;">Departure Type: ' . $victimDepartureType . '</p>';
                // $message .= '<p style="font-size: 11px;">Departure Type: ' . $tempCase['temporary_victim_departure_type']. '</p>';
                $message .= '<p style="font-size: 11px;">Address: ' . $tempCase['temporary_victim_address']. '</p>';
                $message .= '</div>';
                $message .= '</div>';
                $message .= '<hr style="border: none; border-top: 1px solid #ccc; margin: 20px 0;">';
                $message .= '<p style="font-size: 12px;">';
                $message .= '<div style="text-align:center;">';
                $message .= 'from<br>';
                $message .= 'ICMS.OFW<br>';
                $message .= 'ICMS, Inc., Attention: Community Support, Philippines.<br>';
                $message .= 'This message was sent to <ICMS.OFW@gmail.com>.';
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
        } else {
            // Handle case where no temporary cases are found
            $response = array("success" => false, "message" => "No temporary cases found");
            echo json_encode($response);
        }
    }
    
    

}
