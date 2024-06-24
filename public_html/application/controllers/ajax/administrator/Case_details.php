<?php

/**
 * Case Internal Ajax
 * 
 * @module Ajax Loader
 * @author LBS eBusiness Solutions Corp. 
 * @since 2017
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Case_details extends CI_Controller {

    const SUCCESS_RESPONSE = 1;
    const FAILED_RESPONSE = 0;

    public function __construct() {
        parent::__construct();

        // load models
        $this->load->model('Global_data_model');
        $this->load->model('administrator/Case_model');
        $this->load->model('administrator/Victims_model');
        $this->load->model('administrator/Users_model');
        $this->load->model('administrator/Case_details_model');
    }

    /**
     * Ajax Route :: Action Controller
     */
    public function ajax() {
        // route ajax api
        $this->base_action_ajax();
    }

    // Private Functions  
    // Global Data 
    private function getGlobalParameter($sParam) {
        $aParam = [];
        $aParam['parameter_type'] = $sParam;
        $aParam = $this->getGlobalParameterTypeIdAndStatus($aParam);

        $aResponse = $this->Global_data_model->getGlobalParameter($aParam);
        return $aResponse;
    }

    private function getGlobalParameterTypeIdAndStatus($aParam) {

        $aParam['order_by'] = "ORDER BY  `parameter_name`  REGEXP   '%[^a-zA-Z0-9]%' ASC";

        switch ($aParam['parameter_type']) {
            case 'sex':
                $aParam['type_id'] = '9';
                $aParam['status'] = '1';
                break;
            case 'civil':
                $aParam['type_id'] = '3';
                $aParam['status'] = '1';
                break;
            case 'religion':
                $aParam['type_id'] = '4';
                $aParam['status'] = '1';
                break;
            case 'education':
                $aParam['type_id'] = '6';
                $aParam['status'] = '1';
                $aParam['order_by'] = " ORDER BY  CAST(`parameter_description` as unsigned) DESC";
                break;
            case 'nextofkin':
                $aParam['type_id'] = '8';
                $aParam['status'] = '1';
                break;
        }

        return $aParam;
    }

    private function getTransactionParameter($sParam) {

        $aParam['transaction_type'] = $sParam;
        $aParam = $this->getTransactionParameterTypeIdAndStatus($aParam);
        $aResponse = [];
        $aResponse = $this->Global_data_model->getTransactionParameter($aParam);

        return $aResponse;
    }

    private function getTransactionParameterTypeIdAndStatus($aParam) {

        switch ($aParam['transaction_type']) {
            case 'contact':
                $aParam['type_id'] = '6';
                $aParam['status'] = '1';
                break;
            case 'offender_type':
                $aParam['type_id'] = '10';
                $aParam['status'] = '1';
                break;
        }

        return $aParam;
    }

    // Global Parameter For Manage Case 
    public function getUpdateCaseGlobalParameter() {

        $aResponse = [];
        $aParam = [];

        // victim information // Global Parameter 
        $aResponse['info']['sex'] = $this->getGlobalParameter('sex');
        $aResponse['info']['civil_status'] = $this->getGlobalParameter('civil');
        $aResponse['info']['religion'] = $this->getGlobalParameter('religion');
        $aResponse['info']['educational_attainment'] = $this->getGlobalParameter('education');
        $aResponse['info']['family_relation'] = $this->getGlobalParameter('nextofkin');

        // victim information // Transaction Parameter 
        $aResponse['info']['contact_type'] = $this->getTransactionParameter('contact');

        // victim information // places // location 
        $aResponse['location']['country'] = $this->Global_data_model->getCountries($aParam);
        $aResponse['location']['regions'] = $this->Global_data_model->getRegions($aParam);
        $aResponse['location']['province'] = $this->Global_data_model->getProvinces($aParam);
        $aResponse['location']['city'] = $this->Global_data_model->getCities($aParam);
        $aResponse['location']['barangay'] = '';

        // case details // tip infomration 
        $aResponse['case']['acts'] = $this->Global_data_model->getTraficInPerson_Act();
        $aResponse['case']['means'] = $this->Global_data_model->getTraficInPerson_means();
        $aResponse['case']['purposes'] = $this->Global_data_model->getTraficInPerson_purpose();

        // case details // complainant source 
        $aResponse['case']['complainant_source'] = $this->Global_data_model->getGlobalComplainSource($aParam);

        // case details // offender position
        $aResponse['case']['offender_type'] = $this->getTransactionParameter('offender_type');

        // case details // assessment type 
        $aResponse['case']['assessment_type'] = $this->Global_data_model->getAssessmentType($aParam);

        // employment 
        $aResponse['employment']['employment_type'] = $this->Global_data_model->getEmploymentType($aParam);

        // departure 
        $aResponse['employment']['departure_type'] = $this->Global_data_model->getDepartureType($aParam);

        // visa category 
        $aResponse['employment']['visa_category'] = $this->Global_data_model->getVisaCategory($aParam);

        return $aResponse;
    }

    public function sessionDestruct() {
        // session destroy
        $this->sessionPushLogout('admininistrator');
    }

    public function getComplainantDetailsByCaseId($aParam) {
        $aResponse = [];
        $aParam['caseid'] = $this->yel->decrypt_param($aParam['caseid']);
        $list = $this->Case_details_model->getComplainantDetailsByCaseId($aParam);
        $list['victim_id'] = $this->yel->encrypt_param($list['victim_id']);
        $list['case_complainant_id'] = $this->yel->encrypt_param($list['case_complainant_id']);

        $aResponse['result'] = '0';
        if (!empty($list) == true) {
            $aResponse['result'] = '1';
        }
        $aResponse['list'] = $list;
        return $aResponse;
    }

    public function setComplainantDetails($aParam) {

        // initialize
        $aResponse = [];

        // sanitize
        $aParam = $this->yel->fix_html_entities($aParam);
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        $aResult['flag'] = self::FAILED_RESPONSE;

        //validation rules
        $aRules = array(
            //'datecomplained' => 'required',
            'complainsource' => 'required',
            //'complainantname' => 'required',
            //'relation' => 'required',
            //'address' => 'required',
            //'contact' => 'required'
        );

//        relationother:relationother

        /**
         * Parameter Validation
         */
        $aAssert = $this->assert->formValidate($aParam, $aRules);

        $aResponse['php_validation'] = $aAssert;
        if ($aAssert['flag'] != self::ACTIVE_STATUS) {
            return $aResponse;
        }
//        if (isset($aParam['datecomplained']) == true && empty($aParam['datecomplained']) == false) {
//            if (strpos($aParam['datecomplained'], '/') !== false) {
//                $ddate = explode('/', $aParam['datecomplained']);
//                $aParam['datecomplained'] = $ddate[2] . "-" . $ddate[0] . "-" . $ddate[1];
//            }
//        } else {
//            $aParam['datecomplained'] = "1970-01-01";
//        }

        if (isset($aParam['complainantid']) == true && $aParam['complainantid'] !== "") {
            // update
            $aParam['complainantid'] = $this->yel->decrypt_param($aParam['complainantid']);

            //user log
            $aLog = [];
            $aLog['old_data'] = $this->Case_details_model->getComplainantDetails($aParam);

            $aResponse['result'] = $this->Case_details_model->setComplainantDetails($aParam);
            $aLog['new_data'] = $this->Case_details_model->getComplainantDetails($aParam);

            $aLog['log_event_type'] = 18; // base on table : icms_user_event_type
            $aLog['log_message'] = "Change case Complainant Details";
            $aLog['log_action'] = 2; // 1= new inserted // 2=update table
            $aLog['new_data'] = $this->yel->encrypt_param(json_encode($aLog['new_data']));
            $aLog['old_data'] = $this->yel->encrypt_param(json_encode($aLog['old_data']));
            $aLog['module_primary_id'] = $this->yel->decrypt_param($aParam['caseid']);
            $aLog['sub_module_primary_id'] = $aParam['complainantid'];
            $aResponse['log'] = $this->audit->create($aLog);

            return $aResponse;
        } else {
            //add new
            $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);
            $aParam['case_victim_id'] = $this->Case_model->getCaseVictimIdByCaseId($aParam);
            $case_number = $this->Case_details_model->getCaseNumberByCaseId($aParam);
            $aResponse['result'] = $this->Case_details_model->addComplainantDetails($aParam);

            $aLog = [];
            $aLog['log_action'] = 1; // 1= new inserted // 2=update table
            $aLog['log_event_type'] = 54; // base on table : icms_user_event_type
            $aLog['log_message'] = "added complainant detailsin case report <a href='update_case/" . $this->yel->encrypt_param($aParam['case_id']) . "'>" . $case_number . "</a>";
            $aLog['module_primary_id'] = $aParam['case_id'];
            $aLog['sub_module_primary_id'] = $aResponse['result']['insert_id'];
            $aResponse['log'] = $this->audit->create($aLog);

            return $aResponse;
        }
    }

    public function getCaseTIP($aParam) {
        $aResponse = [];
        $aParam['caseid'] = $this->yel->decrypt_param($aParam['caseid']);

        // get victims per case id, this will be change for multiple victims in the future
        // for now it will be limited to 1, victim id should came from ajax
        $caseVictim = $this->Case_details_model->getCaseVictimsDetailsByCaseID($aParam);
        $caseInfo = $this->Case_details_model->getCaseEvaluation($aParam);

        $aParam['victim_id'] = $caseVictim['victim_id'];
        $aParam['case_victim_id'] = $caseVictim['case_victim_id'];
        //getc case_victim_id id to to be used for getting act means and purpose
        $aResponse['case_victim_id'] = $this->yel->encrypt_param($caseVictim['case_victim_id']);
        $aResponse['case_victim_facts'] = $caseVictim['case_facts'];

        $aResponse['case_is_illegal_rec'] = $caseInfo['case_is_illegal_rec'];
        $aResponse['case_is_other_law'] = $caseInfo['case_is_other_law'];
        $aResponse['case_is_other_law_desc'] = $caseInfo['case_is_other_law_desc'];

        $aResponse['acts'] = $this->Case_details_model->getActsMeansPurposeByCaseID($aParam, 1);
        $aResponse['means'] = $this->Case_details_model->getActsMeansPurposeByCaseID($aParam, 3);
        $aResponse['purpose'] = $this->Case_details_model->getActsMeansPurposeByCaseID($aParam, 2);

        return $aResponse;
    }

    function logsArrayToString($arr) {
        $str = "";
        $ctr = 1;
        foreach ($arr as $key => $val) {
            if ($ctr == 1) {
                $str = $val['tip_details_name'];
            } else {
                $str .= " | " . $val['tip_details_name'];
            }
            $ctr++;
        }

        return $str;
    }

    public function setActMeansPurpose($aParam) {

        $aResponse = [];

        $aParam['caseid'] = $this->yel->decrypt_param($aParam['caseid']);
        $aParam['casevictimid'] = $this->yel->decrypt_param($aParam['casevictimid']);
        //prepare for user logs
        $aLog = [];
        $logs_act = $this->logsArrayToString($this->Case_details_model->getActsForLogs($aParam, 1));
        $logs_purpose = $this->logsArrayToString($this->Case_details_model->getActsForLogs($aParam, 2));
        $logs_means = $this->logsArrayToString($this->Case_details_model->getActsForLogs($aParam, 3));
        $logs_fact = $this->Case_details_model->getBriefFactOfTheCase($aParam, 3);
        $aLog['old_data'] = array('acts' => $logs_act, 'means' => $logs_means, 'purpose' => $logs_purpose, 'case_facts' => $logs_fact);


        //update brief summary
        $aResponse['summary'] = $this->Case_details_model->setBriefFactOfTheCase($aParam);

        // update is illegal rec, is other law, other law desc 
        $aResponse['case_details'] = $this->Case_details_model->setCaseOtherDetails($aParam);

        //disabled actmeans and purpose first
        $this->Case_details_model->setActMeansPurposeInactive($aParam);
        //convert csv to array 
        $act = explode(",", $aParam['acts']);
        $means = explode(",", $aParam['means']);
        $purpose = explode(",", $aParam['purpose']);

        foreach ($act as $key => $val) {
            $aParam['tip_id'] = $val;
            $actExist = $this->Case_details_model->checkTIPIfExist($aParam, 1);
            if ($actExist >= 1) {
                //update to active
                $aResponse['act'] = $this->Case_details_model->updateTIPtoActive($aParam, 1);
            } else {
                $aResponse['act'] = $this->Case_details_model->addNewVictimTIP($aParam, 1);
            }
        }

        foreach ($purpose as $key => $val) {
            $aParam['tip_id'] = $val;
            $actExist = $this->Case_details_model->checkTIPIfExist($aParam, 2);
            if ($actExist >= 1) {
                //update to active
                $aResponse['purpose'] = $this->Case_details_model->updateTIPtoActive($aParam, 2);
            } else {
                //addnew
                $aResponse['purpose'] = $this->Case_details_model->addNewVictimTIP($aParam, 2);
            }
        }

        foreach ($means as $key => $val) {
            $aParam['tip_id'] = $val;
            $actExist = $this->Case_details_model->checkTIPIfExist($aParam, 3);
            if ($actExist >= 1) {
                //update to active
                $aResponse['means'] = $this->Case_details_model->updateTIPtoActive($aParam, 3);
            } else {
                //addnew
                $aResponse['means'] = $this->Case_details_model->addNewVictimTIP($aParam, 3);
            }
        }

        //get changes for logs
        $logs_act = $this->logsArrayToString($this->Case_details_model->getActsForLogs($aParam, 1));
        $logs_purpose = $this->logsArrayToString($this->Case_details_model->getActsForLogs($aParam, 2));
        $logs_means = $this->logsArrayToString($this->Case_details_model->getActsForLogs($aParam, 3));
        $logs_fact = $this->Case_details_model->getBriefFactOfTheCase($aParam, 3);
        $aLog['new_data'] = array('acts' => $logs_act, 'means' => $logs_means, 'purpose' => $logs_purpose, 'case_facts' => $logs_fact);

        $case_number = $this->Case_details_model->getCaseNumberByCaseId($aParam);

        $aLog['log_event_type'] = 21; // base on table : icms_user_event_type
        $aLog['log_link'] = "update_case/" . $this->yel->encrypt_param($aParam['caseid']);
        $aLog['log_action'] = 2; // 1= new inserted // 2=update table
        $aLog['new_data'] = $this->yel->encrypt_param(json_encode($aLog['new_data']));
        $aLog['old_data'] = $this->yel->encrypt_param(json_encode($aLog['old_data']));
        $aLog['module_primary_id'] = $aParam['caseid'];
        $link = $aLog['log_message'] = "update Case Information:Means <a href='update_case/" . $this->yel->encrypt_param($aParam['caseid']) . "'>" . $case_number . "</a>";
        if (isset($aResponse['means']['insert_id']) == true) {
            $aLog['sub_module_primary_id'] = $aResponse['means']['insert_id'];
        } else {
            $aLog['sub_module_primary_id'] = $aResponse['means'];
        }

        $aResponse['log'] = $this->audit->create($aLog);

        $link = $aLog['log_message'] = "update Case Information:Act <a href='update_case/" . $this->yel->encrypt_param($aParam['caseid']) . "'>" . $case_number . "</a>";
        if (isset($aResponse['act']['insert_id']) == true) {
            $aLog['sub_module_primary_id'] = $aResponse['act']['insert_id'];
        } else {
            $aLog['sub_module_primary_id'] = $aResponse['act'];
        }
        $aResponse['log'] = $this->audit->create($aLog);

        $link = $aLog['log_message'] = "update Case Information:Purpose <a href='update_case/" . $this->yel->encrypt_param($aParam['caseid']) . "'>" . $case_number . "</a>";
        if (isset($aResponse['means']['insert_id']) == true) {
            $aLog['sub_module_primary_id'] = $aResponse['purpose']['insert_id'];
        } else {
            $aLog['sub_module_primary_id'] = $aResponse['purpose'];
        }
        $aResponse['log'] = $this->audit->create($aLog);

        return $aResponse;
    }

    public function getCaseEvaluation($aParam) {
        // initialize
        $aResponse = [];

        // sanitize
        $aParam = $this->yel->fix_html_entities($aParam);
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        $aResponse['result'] = 0;
        $aParam['caseid'] = $this->yel->decrypt_param($aParam['caseid']);
        $evaluation = $this->Case_details_model->getCaseEvaluation($aParam);
        if (empty($evaluation) == false) {
            $aResponse['result'] = 1;
        }
        $aResponse['evaluation'] = $evaluation;

        return $aResponse;
    }

    public function setCaseEvaluation($aParam) {
        // initialize
        $aResponse = [];

        // sanitize
        $aParam = $this->yel->fix_html_entities($aParam);
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        $aParam['caseid'] = $this->yel->decrypt_param($aParam['caseid']);

        $aLog = [];
        $aLog['old_data'] = $this->Case_details_model->getCaseEvaluation($aParam);
        $aResponse = $this->Case_details_model->setCaseEvaluation($aParam);
        $aLog['new_data'] = $this->Case_details_model->getCaseEvaluation($aParam);
        $case_number = $this->Case_details_model->getCaseNumberByCaseId($aParam);

        //user log -update
        $aLog['log_event_type'] = 22; // base on table : icms_user_event_type
        $aLog['log_message'] = "update case evaluation <a href='update_case/'" . $this->yel->encrypt_param($aParam['caseid']) . ">" . $case_number . "</a>";
        $aLog['log_link'] = 'update_case/' . $this->yel->encrypt_param($aParam['caseid']);
        $aLog['log_action'] = 2; // 1= new inserted // 2=update table
        $aLog['new_data'] = $this->yel->encrypt_param(json_encode($aLog['new_data']));
        $aLog['old_data'] = $this->yel->encrypt_param(json_encode($aLog['old_data']));
        $aLog['module_primary_id'] = $aParam['caseid'];
        $aLog['sub_module_primary_id'] = $aParam['caseid'];
        $aResponse['log'] = $this->audit->create($aLog);
        return $aResponse;
    }

    public function getCaseAllegedOffender($aParam) {
        $aResponse = [];
        $aResponse['result'] = 0;
        $aParam['caseid'] = $this->yel->decrypt_param($aParam['caseid']);
        $offender = $this->Case_details_model->getCaseAllegedOffender($aParam);
        if (empty($offender) == false) {
            $aResponse['result'] = 1;
        }
        $aResponse['offender'] = $offender;
        return $aResponse;
    }

    public function getCaseAllegedOffenderByOffenderID($aParam) {
        $aResponse = [];
        $aResponse['result'] = 0;
        $offender = $this->Case_details_model->getCaseAllegedOffenderByOffenderID($aParam);
        if (empty($offender) == false) {
            $aResponse['result'] = 1;
        }
        $aResponse['offender'] = $offender;
        return $aResponse;
    }

    public function addSetOffenderInfo($aParam) {
        // initialize
        $aResponse = [];

        // sanitize
        $aParam = $this->yel->fix_html_entities($aParam);
        $aParam = $this->yel->safe_mode_clean_array($aParam);
        
        $aParam['caseid'] = $this->yel->decrypt_param($aParam['caseid']);
        $case_number = $this->Case_details_model->getCaseNumberByCaseId($aParam);
        $aLog = [];
        if ($aParam['action'] == "add") {
            $aResponse = $this->Case_details_model->addOffenderInfo($aParam);
            $aLog['log_event_type'] = 24; // base on table : icms_user_event_type
            $aLog['log_message'] = "add  " . $aParam['offender_name'] . " in alleged offender in report case number  <a href='update_case/'" . $this->yel->encrypt_param($aParam['caseid']) . ">" . $case_number . "</a>";
            $aLog['log_action'] = 1; // 1= new inserted // 2=update table
            $aLog['module_primary_id'] = $aParam['caseid'];
            $aLog['sub_module_primary_id'] = $aResponse['insert_id'];
        } else {
            $aLog['old_data'] = $this->Case_details_model->getOffenderInfo($aParam);
            $aResponse = $this->Case_details_model->setOffenderInfo($aParam);
            $aLog['new_data'] = $this->Case_details_model->getOffenderInfo($aParam);
            $case_number = $this->Case_details_model->getCaseNumberByCaseId($aParam);
            $aLog['log_event_type'] = 25;
            $aLog['log_message'] = "update alleged offender in report case number  <a href='update_case/'" . $this->yel->encrypt_param($aParam['caseid']) . ">" . $case_number . "</a>";
            $aLog['log_action'] = 2; // 1= new inserted // 2=update table
            $aLog['new_data'] = $this->yel->encrypt_param(json_encode($aLog['new_data']));
            $aLog['old_data'] = $this->yel->encrypt_param(json_encode($aLog['old_data']));
            $aLog['module_primary_id'] = $aParam['caseid'];
            $aLog['sub_module_primary_id'] = $aParam['offenderid'];
        }
        $aLog['log_link'] = 'update_case/' . $this->yel->encrypt_param($aParam['caseid']);
        $aResponse['log'] = $this->audit->create($aLog);
        return $aResponse;
    }

    public function removeOffender($aParam) {
        $aResponse = [];
        $aParam = $this->yel->safe_mode_clean_array($aParam);
        $aParam['caseid'] = $this->yel->decrypt_param($aParam['caseid']);
        $case_number = $this->Case_details_model->getCaseNumberByCaseId($aParam);
        $offerndername = $this->Case_details_model->getOffernderNameByOffenderID($aParam);
        $aResponse = $this->Case_details_model->removeOffender($aParam);
        //user log -update
        $aLog = [];
        $aLog['log_event_type'] = 23; // base on table : icms_user_event_type
        $aLog['log_message'] = "removed " . $offerndername . " from alleged offender in report case number  <a href='update_case/'" . $this->yel->encrypt_param($aParam['caseid']) . ">" . $case_number . "</a>";
        $aLog['log_link'] = 'update_case/' . $this->yel->encrypt_param($aParam['caseid']);
        $aLog['log_action'] = 1; // 1= new inserted // 2=update table
        $aLog['module_primary_id'] = $aParam['caseid'];
        $aLog['sub_module_primary_id'] = $aParam['offenderid'];
        $aResponse['log'] = $this->audit->create($aLog);
        return $aResponse;
    }

    public function getUploadedDocuments($aParam) {
        $aResponse = [];
        $aParam = $this->yel->safe_mode_clean_array($aParam);
        $aParam['caseid'] = $this->yel->decrypt_param($aParam['caseid']);
        $aResponse['result'] = 0;
        $docs = $this->Case_details_model->getUploadedDocuments($aParam);
        if (empty($docs) == false) {
            $aResponse['result'] = 1;
        }
        $aResponse['docs'] = $docs;
        return $aResponse;
    }

    public function removeDocument($aParam) {
        $aResponse = [];
        $aParam = $this->yel->safe_mode_clean_array($aParam);
        $aParam['caseid'] = $this->yel->decrypt_param($aParam['caseid']);
        $aResponse = $this->Case_details_model->removeDocument($aParam);
        $case_number = $this->Case_details_model->getCaseNumberByCaseId($aParam);

        //user log -update
        $aLog = [];
        $aLog['log_event_type'] = 27; // base on table : icms_user_event_type
        $aLog['log_message'] = "remove case document for the report case number  <a href='update_case/'" . $this->yel->encrypt_param($aParam['caseid']) . ">" . $case_number . "</a>";
        $aLog['log_link'] = 'update_case/' . $this->yel->encrypt_param($aParam['caseid']);
        $aLog['log_action'] = 1; // 1= new inserted // 2=update table
        $aLog['module_primary_id'] = $aParam['caseid'];
        $aLog['sub_module_primary_id'] = $aParam['docid'];
        $aResponse['log'] = $this->audit->create($aLog);
        return $aResponse;
    }

    public function addNewDocument($aParam) {
        // initialize
        $aResponse = [];

        // sanitize
        $aParam = $this->yel->fix_html_entities($aParam);
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        $aParam['caseid'] = $this->yel->decrypt_param($aParam['caseid']);
        $aResponse = $this->Case_details_model->addNewDocument($aParam);
        $case_number = $this->Case_details_model->getCaseNumberByCaseId($aParam);

        //user log -update
        $aLog = [];
        $aLog['log_event_type'] = 26; // base on table : icms_user_event_type
        $aLog['log_message'] = "added new document for the report case number  <a href='update_case/'" . $this->yel->encrypt_param($aParam['caseid']) . ">" . $case_number . "</a>";
        $aLog['log_link'] = 'update_case/' . $this->yel->encrypt_param($aParam['caseid']);
        $aLog['log_action'] = 1; // 1= new inserted // 2=update table
        $aLog['module_primary_id'] = $aParam['caseid'];
        $aLog['sub_module_primary_id'] = $aResponse['insert_id'];
        $aResponse['log'] = $this->audit->create($aLog);

        return $aResponse;
    }

    public function setPassportDetails($aParam) {
        // initialize
        $aResponse = [];

        // sanitize
        $aParam = $this->yel->fix_html_entities($aParam);
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);
        $aParam['caseid'] = $aParam['case_id'];
        $case_number = $this->Case_details_model->getCaseNumberByCaseId($aParam);
        $aParam['case_victim_id'] = $this->Case_model->getCaseVictimIdByCaseId($aParam);

        if (isset($aParam['dob']) == true && empty($aParam['dob']) == false) {
            if (strpos($aParam['dob'], '/') !== false) {
                $ddate = explode('/', $aParam['dob']);
                $aParam['dob'] = $ddate[2] . "-" . $ddate[0] . "-" . $ddate[1];
            }
        } else {
            $aParam['dob'] = "1970-01-01";
        }
        if (isset($aParam['date_issued']) == true && empty($aParam['date_issued']) == false) {
            if (strpos($aParam['date_issued'], '/') !== false) {
                $ddate = explode('/', $aParam['date_issued']);
                $aParam['date_issued'] = $ddate[2] . "-" . $ddate[0] . "-" . $ddate[1];
            }
        } else {
            $aParam['date_issued'] = "1970-01-01";
        }

        if (isset($aParam['date_xp']) == true && empty($aParam['date_xp']) == false) {
            if (strpos($aParam['date_xp'], '/') !== false) {
                $ddate = explode('/', $aParam['date_xp']);
                $aParam['date_xp'] = $ddate[2] . "-" . $ddate[0] . "-" . $ddate[1];
            }
        } else {
            $aParam['date_xp'] = "1970-01-01";
        }
        if ($aParam['passport_id'] >= 1) {
            //update
            $aLog = [];
            $aLog['old_data'] = $this->Case_details_model->getCaseVictimPassport($aParam);
            $aResponse['passport'] = $this->Case_details_model->setCaseVictimPassport($aParam);
            $aLog['new_data'] = $this->Case_details_model->getCaseVictimPassport($aParam);
            $aLog['log_event_type'] = 42;
            $aLog['log_message'] = "update passport number for the case report <a href='update_case/" . $this->yel->encrypt_param($aParam['case_id']) . "'>" . $case_number . "</a>";
            $aLog['log_action'] = 2; // 1= new inserted // 2=update table
            $aLog['new_data'] = $this->yel->encrypt_param(json_encode($aLog['new_data']));
            $aLog['old_data'] = $this->yel->encrypt_param(json_encode($aLog['old_data']));
            $aLog['module_primary_id'] = $aParam['case_id'];
            $aLog['sub_module_primary_id'] = $aParam['passport_id'];
            $aResponse['log'] = $this->audit->create($aLog);
        } else {
            //add new
            $aResponse['passport'] = $this->Case_details_model->addNewCaseVictimPassport($aParam);
            $aLog = [];
            $aLog['log_action'] = 1; // 1= new inserted // 2=update table
            $aLog['log_event_type'] = 41; // base on table : icms_user_event_type
            $aLog['log_message'] = "added passport details for the case report <a href='update_case/" . $this->yel->encrypt_param($aParam['case_id']) . "'>" . $case_number . "</a>";
            $aLog['module_primary_id'] = $aParam['case_id'];
            $aLog['sub_module_primary_id'] = $aResponse['passport']['insert_id'];
            $aResponse['log'] = $this->audit->create($aLog);
        }
        return $aResponse;
    }

    public function getTransitList($aParam) {
        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);
        $aParam['caseid'] = $aParam['case_id'];
        $case_number = $this->Case_details_model->getCaseNumberByCaseId($aParam);
        $aParam['case_victim_id'] = $this->Case_model->getCaseVictimIdByCaseId($aParam);
        $aResponse = $this->Case_details_model->getTransitList($aParam);
        return $aResponse;
    }

    public function addTransitDetails($aParam) {

        // initialize
        $aResponse = [];

        // sanitize
        $aParam = $this->yel->fix_html_entities($aParam);
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);
        $aParam['caseid'] = $aParam['case_id'];
        $case_number = $this->Case_details_model->getCaseNumberByCaseId($aParam);
        $aParam['case_victim_id'] = $this->Case_model->getCaseVictimIdByCaseId($aParam);

//        if (isset($aParam['depdate']) == true && empty($aParam['depdate']) == false) {
//            if (strpos($aParam['depdate'], '/') !== false) {
//                $ddate = explode('/', $aParam['depdate']);
//                $aParam['depdate'] = $ddate[2] . "-" . $ddate[0] . "-" . $ddate[1];
//            }
//        } else {
//            $aParam['depdate'] = "1970-01-01";
//        }
//
//        if (isset($aParam['arrdate']) == true && empty($aParam['arrdate']) == false) {
//            if (strpos($aParam['arrdate'], '/') !== false) {
//                $ddate = explode('/', $aParam['arrdate']);
//                $aParam['arrdate'] = $ddate[2] . "-" . $ddate[0] . "-" . $ddate[1];
//            }
//        } else {
//            $aParam['arrdate'] = "1970-01-01";
//        }

        $aResponse = $this->Case_details_model->addTransitDetails($aParam);
        $aLog = [];
        $aLog['log_action'] = 1; // 1= new inserted // 2=update table
        $aLog['log_event_type'] = 43; // base on table : icms_user_event_type
        $aLog['log_message'] = "added transit details for the case report <a href='update_case/" . $this->yel->encrypt_param($aParam['case_id']) . "'>" . $case_number . "</a>";
        $aLog['module_primary_id'] = $aParam['case_id'];
        $aLog['sub_module_primary_id'] = $aResponse['insert_id'];
        $aResponse['log'] = $this->audit->create($aLog);

        return $aResponse;
    }

    public function removeVictimTransitInfoById($aParam) {
        $aParam = $this->yel->clean_array($aParam);
        $aResponse['flag'] = self::FAILED_RESPONSE;
        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);
        $aParam['caseid'] = $aParam['case_id'];
        $case_number = $this->Case_details_model->getCaseNumberByCaseId($aParam);

        $aResponse['victim_transit_info'] = $this->Case_model->removeVictimTransitInfoById($aParam);

        if ($aResponse['victim_transit_info']['stat'] == 1) {
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
        }
        $aLog = [];
        $aLog['log_action'] = 1; // 1= new inserted // 2=update table
        $aLog['log_event_type'] = 45; // base on table : icms_user_event_type
        $aLog['log_message'] = "removed transit details for the case report <a href='update_case/" . $this->yel->encrypt_param($aParam['case_id']) . "'>" . $case_number . "</a>";
        $aLog['module_primary_id'] = $aParam['case_id'];
        $aLog['sub_module_primary_id'] = $aParam['case_victim_transit_id'];
        $aResponse['log'] = $this->audit->create($aLog);

        return $aResponse;
    }

    public function getVictimTransitInfoById($aParam) {
        $aParam = $this->yel->clean_array($aParam);

        $aResponse['flag'] = self::FAILED_RESPONSE;

        $aResponse['victim_transit_info'] = $this->Case_model->getVictimTransitInfoById($aParam);
        if ($aResponse['victim_transit_info']) {
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
        }

        return $aResponse;
    }

    public function updateVictimTransitInfoById($aParam) {

        // initialize
        $aResponse = [];

        // sanitize
        $aParam = $this->yel->fix_html_entities($aParam);
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);
        $aParam['caseid'] = $aParam['case_id'];
        $case_number = $this->Case_details_model->getCaseNumberByCaseId($aParam);

//        if (isset($aParam['case_victim_transit_departure_date']) == true && empty($aParam['case_victim_transit_departure_date']) == false) {
//            if (strpos($aParam['case_victim_transit_departure_date'], '/') !== false) {
//                $ddate = explode('/', $aParam['case_victim_transit_departure_date']);
//                $aParam['case_victim_transit_departure_date'] = $ddate[2] . "-" . $ddate[0] . "-" . $ddate[1];
//            }
//        } else {
//            $aParam['case_victim_transit_departure_date'] = "1970-01-01";
//        }
//
//        if (isset($aParam['case_victim_transit_arrival_date']) == true && empty($aParam['case_victim_transit_arrival_date']) == false) {
//            if (strpos($aParam['case_victim_transit_arrival_date'], '/') !== false) {
//                $ddate = explode('/', $aParam['case_victim_transit_arrival_date']);
//                $aParam['case_victim_transit_arrival_date'] = $ddate[2] . "-" . $ddate[0] . "-" . $ddate[1];
//            }
//        } else {
//            $aParam['case_victim_transit_arrival_date'] = "1970-01-01";
//        }


        $aLog = [];
        $aLog['old_data'] = $this->Case_details_model->getTransitDetailsByTransitID($aParam);
        $aResponse['victim_transit_info'] = $this->Case_model->updateVictimTransitInfoById($aParam);
        $aLog['new_data'] = $this->Case_details_model->getTransitDetailsByTransitID($aParam);
        $aLog['log_event_type'] = 44;
        $aLog['log_message'] = "update transit details in case report <a href='update_case/" . $this->yel->encrypt_param($aParam['case_id']) . "'>" . $case_number . "</a>";
        $aLog['log_action'] = 2; // 1= new inserted // 2=update table
        $aLog['new_data'] = $this->yel->encrypt_param(json_encode($aLog['new_data']));
        $aLog['old_data'] = $this->yel->encrypt_param(json_encode($aLog['old_data']));
        $aLog['module_primary_id'] = $aParam['case_id'];
        $aLog['sub_module_primary_id'] = $aParam['transid'];

        $aResponse['log'] = $this->audit->create($aLog);

        return $aResponse;
    }

    public function addServiceInformation($aParam) {

        // initialize
        $aResponse = [];
        $aResponse['flag'] = self::FAILED_RESPONSE;

        // sanitize
        $aParam = $this->yel->fix_html_entities($aParam);
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);
        $aParam['caseid'] = $aParam['case_id'];
        $case_number = $this->Case_details_model->getCaseNumberByCaseId($aParam);
        $aParam['case_victim_id'] = $this->Case_model->getCaseVictimIdByCaseId($aParam);

//        if (isset($aParam['deliveryService']) == true && empty($aParam['deliveryService']) == false) {
//            if (strpos($aParam['deliveryService'], '/') !== false) {
//                $ddate = explode('/', $aParam['deliveryService']);
//                $aParam['deliveryService'] = $ddate[2] . "-" . $ddate[0] . "-" . $ddate[1];
//            }
//        } else {
//            $aParam['deliveryService'] = "1970-01-01";
//        }

        // check service 
        // $check = $this->Case_details_model->checkServiceInformation($aParam); 
        // if($check){
        //     return $aResponse;
        // }

        $aResponse = $this->Case_details_model->addServiceInformation($aParam);
        // add notif
        // logs : tag agency
        $aLog['log_event_type'] = 56; // base on table : icms_user_event_type
        $v['agency_id'] = $aParam['agency_id'];
        $agency_details = $this->Case_model->getAgencyDetailsToBeTagged($aParam, $v);

        $aLog['log_message'] = " tagged " . $agency_details['agency_abbr'] . " - " . $agency_details['agency_branch_name'];
        $aLog['log_message'] .= " for the case report <a href='update_case/" . $this->yel->encrypt_param($aParam['case_id']) . "'>" . $case_number . "</a>";
        $aLog['module_primary_id'] = $aParam['case_id'];
        $aLog['sub_module_primary_id'] = $aResponse['tagged_agency']['insert_id'];
        $aResponse['log'] = $this->audit->create($aLog);

        // add system notification
        $aParam['agency_branch_id'] = $aParam['agency_id'];

        // send notification 
        $this->notif->sendNotificationToVictim([
            "notif_type" => "add-service",
            "id_type" => "case_id",
            "id" => $aParam['caseid']
        ]);

        $taggedAgencyBranchesAdmin = $this->Users_model->getAdminUsersByAgencyBranchId($aParam);
        if (isset($taggedAgencyBranchesAdmin['user_id']) == true) {

            $aNotif = [];
            $aNotif['receiver'] = $taggedAgencyBranchesAdmin['user_id'];
            $aNotif['notif_type'] = "1";
            $aNotif['method'] = "view_victim_services";
            $aNotif['tbl_id'] = $aParam['caseid'];
            $aNotif['msg'] = "You have been tagged by ";
            $aNotif['msg'] .= $_SESSION['userData']['agency_abbr'] . " - " . $_SESSION['userData']['agency_branch_name'];
            $aNotif['msg'] .= " with case report <orange><a href='update_case/" . $this->yel->encrypt_param($aParam['case_id']) . "'>" . $case_number . "</a></orange>";
            $aNotif['msg'] .= ' for "' . $aParam['service_name'] . '"';
            $test = $this->notif->create($aNotif);

            $aEmail = [];
            $aEmail['to'] = $taggedAgencyBranchesAdmin['user_email'];
            $aEmail['subject'] = 'New tagged case added';
            $aEmail['message'] = 'Hi ' . $taggedAgencyBranchesAdmin['user_firstname'] . ',  <br><br>Your agency has been tagged  by ' . $_SESSION['userData']['user_firstname'] . ' ' . $_SESSION['userData']['user_lastname'] . ' of ' . $_SESSION['userData']['agency_name'] . ' (' . $_SESSION['userData']['agency_branch_name'] . '). A trafficked person with case number (' . $case_number . ') is in need of your help. ';
            $aEmail['message'] .= 'You may login to ICMS using your account to see more details about the case.';
            $aResponse['mail'] = $this->mailbox->sendMail($aEmail);

            if ($_SESSION['userData']['user_level_id'] !== "1") {
                //send notif to iacat admin
                $adminDetails = $this->Users_model->getSuperAdminUserId();
                $aEmail = [];
                $aEmail['to'] = $adminDetails['user_email'];
                $aEmail['subject'] = 'New tagged case added';
                $aEmail['message'] = 'Hi ' . $adminDetails['user_firstname'] . ',  <br><br>';
                $aEmail['message'] .= 'New tagged agency was added  by ' . $_SESSION['userData']['user_firstname'] . ' ' . $_SESSION['userData']['user_lastname'] . ' of ' . $_SESSION['userData']['agency_name'] . ' (' . $_SESSION['userData']['agency_branch_name'] . '). A trafficked person with case number (' . $case_number . ') is in need of your help. ';
                $aEmail['message'] .= 'You may login to ICMS using your account to see more details about the case.';
                $aResponse['mail'] = $this->mailbox->sendMail($aEmail);

                $aNotif = [];
                $aNotif['receiver'] = $adminDetails['user_id'];
                $aNotif['notif_type'] = "1";
                $aNotif['method'] = "view_victim_services";
                $aNotif['tbl_id'] = $aParam['caseid'];
                $aNotif['msg'] = "New tagged agencies was added by ";
                $aNotif['msg'] .= $_SESSION['userData']['agency_abbr'] . " - " . $_SESSION['userData']['agency_branch_name'];
                $aNotif['msg'] .= " with case report <orange><a href='update_case/" . $this->yel->encrypt_param($aParam['case_id']) . "'>" . $case_number . "</a></orange>";
                $aNotif['msg'] .= ' for "' . $aParam['service_name'] . '"';
                $test = $this->notif->create($aNotif);
            }
        }
        return $aResponse;
    }

    public function notifyChangesInReport($aParam) {
        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);
        $aParam['caseid'] = $aParam['case_id'];
        $case_number = $this->Case_details_model->getCaseNumberByCaseId($aParam);
        $adminDetails = $this->Users_model->getSuperAdminUserId();
        if ($_SESSION['userData']['user_level_id'] !== "1") {
            $aNotif = [];
            $aNotif['method'] = "view_victim_services";
            $aNotif['tbl_id'] = $aParam['caseid'];
            $aNotif['receiver'] = $adminDetails['user_id'];
            $aNotif['notif_type'] = "1";
            $aNotif['msg'] = $_SESSION['userData']['user_firstname'] . "  " . $_SESSION['userData']['user_lastname'] . " has updated case report <orange><a href='update_case/" . $this->yel->encrypt_param($aParam['caseid']) . "'>" . $case_number . "</a></orange>";
            $result = $this->notif->create($aNotif);
        }

        $aNotif = [];
        $aNotif['method'] = "view_victim_services";
        $aNotif['tbl_id'] = $aParam['caseid'];
        $aNotif['receiver'] = $_SESSION['userData']['user_id'];
        $aNotif['notif_type'] = "1";
        $aNotif['msg'] = "You have successfully updated case report <orange><a href='update_case/" . $this->yel->encrypt_param($aParam['caseid']) . "'>" . $case_number . "</a></orange>";
        $result = $this->notif->create($aNotif);
        return $result;
    }

    public function updateDocument($aParam) {
        // initialize
        $aResponse = [];

        // sanitize
        $aParam = $this->yel->fix_html_entities($aParam);
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        $aParam['caseid'] = $this->yel->decrypt_param($aParam['caseid']);
        $aResponse = $this->Case_details_model->updateDocument($aParam);
        $case_number = $this->Case_details_model->getCaseNumberByCaseId($aParam);

        return $aResponse;
    }

}
