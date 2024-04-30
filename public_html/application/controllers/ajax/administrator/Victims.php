<?php

/**
 * Reports Internal Ajax
 * 
 * @module Ajax Loader
 * @author LBS eBusiness Solutions Corp. 
 * @since 2017
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Victims extends CI_Controller {

    const SUCCESS_RESPONSE = 1;
    const FAILED_RESPONSE = 0;

    public function __construct() {
        parent::__construct();

        // load models
        $this->load->model('administrator/Victims_model');
        $this->load->model('administrator/Case_details_model');
        // OSAEC Comment Code Start
        // $this->load->model('Global_data_model');
        // OSAEC Comment Code END
    }

    /**
     * Ajax Route :: Action Controller
     */
    public function ajax() {

        // route ajax api
        $this->base_action_ajax();
    }

    public function sessionDestruct() {
        // session destroy
        $this->sessionPushLogout('admininistrator');
    }

    public function getPermission() {
        return $_SESSION['userData'];
    }

    /*
     * fetching victim list
     * by:dev_arvin
     */

    public function getVictimList($aParam) {
        $aResponse = [];
        $aResult = [];
        $aParam['sRelevance'] = "";
        $aParam['cRelevance'] = " 1 ";

        $aParam = $this->yel->pagination($aParam);

        // pagination
        $aResponse['pagination'] = $aParam;

        // keyword
        if ($aParam['keyword'] !== "" || empty($aParam['keyword']) == false) {
            $aParam['sRelevance'] = "
                    , MATCH (`iv`.`victim_number`) AGAINST ('+" . $aParam['keyword'] . "*' IN BOOLEAN MODE)  as relevance1
             ";
            $aParam['cRelevance'] = "
                 (MATCH (`iv`.`victim_number`) AGAINST ('+" . $aParam['keyword'] . "*' IN BOOLEAN MODE))      
            OR  `iv`.`victim_id` IN (SELECT `victim_id` FROM `icms_victim_info` WHERE MATCH (`victim_info_first_name`, `victim_info_middle_name`,`victim_info_last_name`) AGAINST ('+" . $aParam['keyword'] . "*') GROUP BY `victim_id`)
            ";
        }

        //list 
        $aResponse['content'] = $this->Victims_model->getVictimList($aParam);

        foreach ($aResponse['content']['list'] as $key => $val) {
            $aResponse['content']['list'][$key]['address_list'] = $this->Victims_model->getGovernmentContactAddressByID($val['victim_id']);
            //$aResponse['content']['list'][$key]['contact_details'] = $this->Victims_model->getVictimListContactDetailsbyID($val['victim_id']);
            $aResponse['content']['list'][$key]['count_associated_case'] = $this->Victims_model->getCountAssociateCasePerVictimID($val['victim_id']);
            $aResponse['content']['list'][$key]['victim_id'] = $this->yel->encrypt_param($val['victim_id']);
        }

        unset($aResponse['pagination']);

        return $aResponse;
    }

    public function getVitimInfoById($aParam) {
        $aResponse = [];
        $aResult = [];
        $aResponse['flag'] = self::FAILED_RESPONSE;
        $aParam['victim_id'] = $this->yel->decrypt_param($aParam['victim_id']);

        $aResult['res'] = $this->Victims_model->getVitimInfoById($aParam);
        $aResult['res']['case_list'] = $this->Victims_model->getAssociateCasePerVictimID($aParam);

        if (sizeof($aResult['res']) > 0) {
            $aResponse['flag'] = self:: SUCCESS_RESPONSE;
            $aResult['res']['victim_id'] = $this->yel->encrypt_param($aResult['res']['victim_id']);
            $aResponse['res'] = $aResult['res'];
        }
        return $aResponse;
    }

    public function getVictimInfoByCaseId($aParam) {

        $aResponse = [];

        $aParam = $this->yel->clean_array($aParam);

        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);

        $aResponse['victim_info'] = $this->Victims_model->getVictimInfoByCaseId($aParam);
        $aParam['victim_id'] = $aResponse['victim_info']['victim_id'];

        $aParam['case_victim_id'] = $aResponse['victim_info']['case_victim_id'];


        $aResponse['victim_info_assumed'] = $this->Victims_model->getVictimAssumedInfoByCaseId($aParam);

        $aResponse['victim_contact_info'] = $this->Victims_model->getVictimListContactDetailsbyID($aParam['victim_id']);
        if (!empty($aResponse['victim_contact_info'])) {
            $cnt = 0;
            foreach ($aResponse['victim_contact_info'] as $val) {
                $aResponse['victim_contact_info'][$cnt]['victim_contact_details_id'] = $this->yel->encrypt_param($val['victim_contact_details_id']);
                $cnt++;
            }
        }

        $aResponse['victim_education_info'] = $this->Victims_model->getVictimListEducationDetailsbyVictimId($aParam);
        if (!empty($aResponse['victim_education_info'])) {
            $cnt = 0;
            foreach ($aResponse['victim_education_info'] as $val) {
                $aResponse['victim_education_info'][$cnt]['victim_education_id'] = $this->yel->encrypt_param($val['victim_education_id']);
                $cnt++;
            }
        }

        $aResponse['victim_address_info'] = $this->Victims_model->getVictimListAddressDetailsbyVictimId($aParam);
        if (!empty($aResponse['victim_address_info'])) {
            $cnt = 0;
            foreach ($aResponse['victim_address_info'] as $val) {
                $aResponse['victim_address_info'][$cnt]['victim_address_list_id'] = $this->yel->encrypt_param($val['victim_address_list_id']);
                $cnt++;
            }
        }

        $aResponse['victim_relatives_info'] = $this->Victims_model->getVictimListRelativeDetailsbyVictimId($aParam);
        if (!empty($aResponse['victim_relatives_info'])) {
            $cnt = 0;
            foreach ($aResponse['victim_relatives_info'] as $val) {
                $aResponse['victim_relatives_info'][$cnt]['victim_relative_id'] = $this->yel->encrypt_param($val['victim_relative_id']);
                $cnt++;
            }
        }

        //employment
        $aResponse['victim_employment_info'] = $this->Victims_model->getVictimListEmploymentDetailsbyVictimId($aParam);


        $aResponse['victim_id'] = $this->yel->encrypt_param($aParam['victim_id']);
        $aResponse['case_victim_id'] = $this->yel->encrypt_param($aParam['case_victim_id']);
        return $aResponse;
    }

    public function addVictimContactByVictimId($aParam) {

        // initialize
        $aResponse = [];

        // sanitize
        $aParam = $this->yel->fix_html_entities($aParam);
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        // flag indicator
        $aResponse['flag'] = self::FAILED_RESPONSE;

        // new parameter 
        $aParam['victim_id'] = $this->yel->decrypt_param($aParam['victim_id']);
        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);

        $aResponse['victim_contact_info'] = $this->Victims_model->addVictimContactByVictimId($aParam);

        if ($aResponse['victim_contact_info']['stat'] == 1) {

            // flag indicator
            $aResponse['flag'] = self::SUCCESS_RESPONSE;

            // For logs 
            $aLog = [];
            $aLog['log_action'] = 1; // 1= new inserted // 2=update table
            $aLog['log_event_type'] = 31; // base on table : icms_user_event_type
            $aLog['log_message'] = "added <a href='victim_list/" . $this->yel->encrypt_param($aParam['victim_id']) . "'>victim's </a> contact";
            $aLog['module_primary_id'] = $aParam['case_id'];
            $aLog['sub_module_primary_id'] = $aResponse['victim_contact_info']['insert_id'];
            $aResponse['log'] = $this->audit->create($aLog);
        }

        return $aResponse;
    }

    public function addVictimEducationByVictimId($aParam) {
        // initialize
        $aResponse = [];

        // sanitize
        $aParam = $this->yel->fix_html_entities($aParam);
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        // flag indicator
        $aResponse['flag'] = self::FAILED_RESPONSE;

        // new parameter 
        $aParam['victim_id'] = $this->yel->decrypt_param($aParam['victim_id']);
        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);

        $aResponse['victim_education_info'] = $this->Victims_model->addVictimEducationByVictimId($aParam);

        if ($aResponse['victim_education_info']['stat'] == 1) {

            // flag indicator
            $aResponse['flag'] = self::SUCCESS_RESPONSE;

            // For log
            $aLog = [];
            $aLog['log_action'] = 1; // 1= new inserted // 2=update table
            $aLog['log_event_type'] = 32; // base on table : icms_user_event_type
            $aLog['log_message'] = "added <a href='victim_list/" . $this->yel->encrypt_param($aParam['victim_id']) . "'>victim's </a> educational background";
            $aLog['module_primary_id'] = $aParam['case_id'];
            $aLog['sub_module_primary_id'] = $aResponse['victim_education_info']['insert_id'];
            $aResponse['log'] = $this->audit->create($aLog);
        }

        return $aResponse;
    }

    public function addVictimAddressByVictimId($aParam) {
        // initialize
        $aResponse = [];

        // sanitize
        $aParam = $this->yel->fix_html_entities($aParam);
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        // flag indicator
        $aResponse['flag'] = self::FAILED_RESPONSE;

        // new parameter 
        $aParam['victim_id'] = $this->yel->decrypt_param($aParam['victim_id']);
        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);

        // Add Victim Address 
        $aResponse['victim_address_info'] = $this->Victims_model->addVictimAddressByVictimId($aParam);

        if ($aResponse['victim_address_info']['stat'] == 1) {
            // flag indicator
            $aResponse['flag'] = self::SUCCESS_RESPONSE;

            // For logs 
            $aLog = [];
            $aLog['log_action'] = 1; // 1= new inserted // 2=update table
            $aLog['log_event_type'] = 53; // base on table : icms_user_event_type
            $aLog['log_message'] = "added <a href='victim_list/" . $this->yel->encrypt_param($aParam['victim_id']) . "'>victim's </a> address";
            $aLog['module_primary_id'] = $aParam['case_id'];
            $aLog['sub_module_primary_id'] = $aResponse['victim_address_info']['insert_id'];

            $aResponse['log'] = $this->audit->create($aLog);
        }

        return $aResponse;
    }

    public function addVictimRelativeByVictimId($aParam) {
        // initialize
        $aResponse = [];

        // sanitize
        $aParam = $this->yel->fix_html_entities($aParam);
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        // flag indicator
        $aResponse['flag'] = self::FAILED_RESPONSE;

        // new parameter 
        $aParam['victim_id'] = $this->yel->decrypt_param($aParam['victim_id']);
        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);

        // aadd victim relative 
        $aResponse['victim_relative_info'] = $this->Victims_model->addVictimRelativeByVictimId($aParam);

        if ($aResponse['victim_relative_info']['stat'] == 1) {
            // flag indicator
            $aResponse['flag'] = self::SUCCESS_RESPONSE;

            // for logs 
            $aLog = [];
            $aLog['log_action'] = 1; // 1= new inserted // 2=update table
            $aLog['log_event_type'] = 33; // base on table : icms_user_event_type
            $aLog['log_message'] = "added <a href='victim_list/" . $this->yel->encrypt_param($aParam['victim_id']) . "'>victim's </a> next of kin";
            $aLog['module_primary_id'] = $aParam['case_id'];
            $aLog['sub_module_primary_id'] = $aResponse['victim_relative_info']['insert_id'];

            // log response 
            $aResponse['log'] = $this->audit->create($aLog);
        }

        return $aResponse;
    }

    public function removeVictimContactInfoById($aParam) {

        // initialize
        $aResponse = [];

        // sanitize
        $aParam = $this->yel->fix_html_entities($aParam);
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        // flag indicator
        $aResponse['flag'] = self::FAILED_RESPONSE;

        // new parameter 
        $aParam['victim_contact_details_id'] = $this->yel->decrypt_param($aParam['victim_contact_details_id']);
        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);

        // remove victim contact 
        $aResponse['victim_contact_info'] = $this->Victims_model->removeVictimContactInfoById($aParam);

        if ($aResponse['victim_contact_info']['stat'] == 1) {

            // flag indicator 
            $aResponse['flag'] = self::SUCCESS_RESPONSE;

            // for logs 
            $aLog = [];
            $aLog['log_action'] = 1; // 1= new inserted // 2=update table
            $aLog['log_event_type'] = 58; // base on table : icms_user_event_type
            $victim_id = $this->Victims_model->getVictimIdByVictimContactID($aParam);
            $aLog['log_message'] = "removed <a href='victim_list/" . $this->yel->encrypt_param($victim_id) . "'>victim's </a> contact";
            $aLog['module_primary_id'] = $aParam['case_id'];
            $aLog['sub_module_primary_id'] = $aParam['victim_contact_details_id'];

            $aResponse['log'] = $this->audit->create($aLog);
        }

        return $aResponse;
    }

    public function removeVictimEducationInfoById($aParam) {
        $aParam = $this->yel->clean_array($aParam);
        $aParam['victim_education_id'] = $this->yel->decrypt_param($aParam['victim_education_id']);
        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);
        $victim_id = $this->Victims_model->getVictimIDByVictimEducationID($aParam);
        $aResponse['flag'] = self::FAILED_RESPONSE;

        $aResponse['victim_education_info'] = $this->Victims_model->removeVictimEducationInfoById($aParam);

        if ($aResponse['victim_education_info']['stat'] == 1) {
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
            $aLog = [];
            $aLog['log_action'] = 1; // 1= new inserted // 2=update table
            $aLog['log_event_type'] = 60; // base on table : icms_user_event_type
            $aLog['log_message'] = "removed <a href='victim_list/" . $this->yel->encrypt_param($victim_id) . "'>victim's </a> educational background";
            $aLog['module_primary_id'] = $aParam['case_id'];
            $aLog['sub_module_primary_id'] = $aParam['victim_education_id'];
            $aResponse['log'] = $this->audit->create($aLog);
        }

        return $aResponse;
    }

    public function removeVictimAddressInfoById($aParam) {
        $aParam = $this->yel->clean_array($aParam);
        $aParam['victim_address_list_id'] = $this->yel->decrypt_param($aParam['victim_address_list_id']);
        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);

        $aResponse['flag'] = self::FAILED_RESPONSE;

        $aResponse['victim_address_info'] = $this->Victims_model->removeVictimAddressInfoById($aParam);

        if ($aResponse['victim_address_info']['stat'] == 1) {
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
            $victim_id = $this->Victims_model->getVictimIDByVictimAddressID($aParam);
            $aLog = [];
            $aLog['log_action'] = 1; // 1= new inserted // 2=update table
            $aLog['log_event_type'] = 62; // base on table : icms_user_event_type
            $aLog['log_message'] = "removed <a href='victim_list/" . $this->yel->encrypt_param($victim_id) . "'>victim's </a> address details";
            $aLog['module_primary_id'] = $aParam['case_id'];
            $aLog['sub_module_primary_id'] = $aParam['victim_address_list_id'];
            $aResponse['log'] = $this->audit->create($aLog);
        }

        return $aResponse;
    }

    public function removeVictimRelativeInfoById($aParam) {
        $aParam = $this->yel->clean_array($aParam);
        $aParam['victim_relative_id'] = $this->yel->decrypt_param($aParam['victim_relative_id']);
        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);

        $victim_id = $this->Victims_model->getVictimIDByRelativeId($aParam);
        $aResponse['flag'] = self::FAILED_RESPONSE;

        $aResponse['victim_relative_info'] = $this->Victims_model->removeVictimRelativeInfoById($aParam);

        if ($aResponse['victim_relative_info']['stat'] == 1) {
            $aResponse['flag'] = self::SUCCESS_RESPONSE;

            $aLog = [];
            $aLog['log_action'] = 1; // 1= new inserted // 2=update table
            $aLog['log_event_type'] = 64; // base on table : icms_user_event_type
            $aLog['log_message'] = "added <a href='victim_list/" . $this->yel->encrypt_param($victim_id) . "'>victim's </a> next of kin details";
            $aLog['module_primary_id'] = $aParam['case_id'];
            $aLog['sub_module_primary_id'] = $aParam['victim_relative_id'];
            $aResponse['log'] = $this->audit->create($aLog);
        }

        return $aResponse;
    }

    public function getVictimContactInfoById($aParam) {
        $aParam = $this->yel->clean_array($aParam);
        $aParam['victim_contact_details_id'] = $this->yel->decrypt_param($aParam['victim_contact_details_id']);

        $aResponse['flag'] = self::FAILED_RESPONSE;

        $aResponse['victim_contact_info'] = $this->Victims_model->getVictimContactInfoById($aParam);
        $aResponse['victim_contact_info']['victim_contact_details_id'] = $this->yel->encrypt_param($aResponse['victim_contact_info']['victim_contact_details_id']);
        $aResponse['victim_contact_info']['victim_id'] = $this->yel->encrypt_param($aResponse['victim_contact_info']['victim_id']);

        if ($aResponse['victim_contact_info']) {
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
        }

        return $aResponse;
    }

    public function updateVictimContactInfoById($aParam) {

        // initialize
        $aResponse = [];

        // sanitize
        $aParam = $this->yel->fix_html_entities($aParam);
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        // flag indicator
        $aResponse['flag'] = self::FAILED_RESPONSE;

        // new param 
        $aParam['victim_contact_details_id'] = $this->yel->decrypt_param($aParam['victim_contact_details_id']);
        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);

        // for logs 
        $aLog = [];
        $aLog['old_data'] = $this->Victims_model->getVictimContactInfoByContactId($aParam);
        $aResponse['victim_contact_info'] = $this->Victims_model->updateVictimContactInfoById($aParam);
        $aLog['new_data'] = $this->Victims_model->getVictimContactInfoByContactId($aParam);


        if ($aResponse['victim_contact_info']['stat'] == 1) {

            // for logs 
            $aLog['log_event_type'] = 57;
            $victim_id = $this->Victims_model->getVictimIdByVictimContactID($aParam);
            $aLog['log_message'] = "update <a href='victim_list/" . $this->yel->encrypt_param($victim_id) . "'>victim's</a> contact details";
            $aLog['log_action'] = 2; // 1= new inserted // 2=update table
            $aLog['new_data'] = $this->yel->encrypt_param(json_encode($aLog['new_data']));
            $aLog['old_data'] = $this->yel->encrypt_param(json_encode($aLog['old_data']));
            $aLog['module_primary_id'] = $aParam['case_id'];
            $aLog['sub_module_primary_id'] = $aParam['victim_contact_details_id'];
            $aResponse['log'] = $this->audit->create($aLog);

            // flag indicator
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
        }

        return $aResponse;
    }

    public function getVictimEducationInfoById($aParam) {
        $aParam = $this->yel->clean_array($aParam);
        $aParam['victim_education_id'] = $this->yel->decrypt_param($aParam['victim_education_id']);

        $aResponse['flag'] = self::FAILED_RESPONSE;

        $aResponse['victim_education_info'] = $this->Victims_model->getVictimEducationInfoById($aParam);
        $aResponse['victim_education_info']['victim_education_id'] = $this->yel->encrypt_param($aResponse['victim_education_info']['victim_education_id']);
        $aResponse['victim_education_info']['victim_id'] = $this->yel->encrypt_param($aResponse['victim_education_info']['victim_id']);

        if ($aResponse['victim_education_info']) {
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
        }

        return $aResponse;
    }

    public function updateVictimEducationInfoById($aParam) {

        // initialize
        $aResponse = [];

        // sanitize
        $aParam = $this->yel->fix_html_entities($aParam);
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        // flag indicator
        $aResponse['flag'] = self::FAILED_RESPONSE;

        // new parameter 
        $aParam['victim_education_id'] = $this->yel->decrypt_param($aParam['victim_education_id']);
        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);
        $victim_id = $this->Victims_model->getVictimIDByVictimEducationID($aParam);

        $aLog = [];
        $aLog['old_data'] = $this->Victims_model->getVictimEducationInfoById($aParam);
        $aResponse['victim_education_info'] = $this->Victims_model->updateVictimEducationInfoById($aParam);
        $aLog['new_data'] = $this->Victims_model->getVictimEducationInfoById($aParam);


        if ($aResponse['victim_education_info']['stat'] == 1) {

            // flag indicator
            $aResponse['flag'] = self::SUCCESS_RESPONSE;

            // for logs 
            $aLog['log_event_type'] = 59;
            $aLog['log_message'] = "update <a href='victim_list/" . $this->yel->encrypt_param($victim_id) . "'> victim's </a> educational background";
            $aLog['log_action'] = 2; // 1= new inserted // 2=update table
            $aLog['new_data'] = $this->yel->encrypt_param(json_encode($aLog['new_data']));
            $aLog['old_data'] = $this->yel->encrypt_param(json_encode($aLog['old_data']));
            $aLog['module_primary_id'] = $aParam['case_id'];
            $aLog['sub_module_primary_id'] = $aParam['victim_education_id'];

            // log response 
            $aResponse['log'] = $this->audit->create($aLog);
        }

        return $aResponse;
    }

    public function getVictimAddressInfoById($aParam) {
        $aParam = $this->yel->clean_array($aParam);
        $aParam['victim_address_list_id'] = $this->yel->decrypt_param($aParam['victim_address_list_id']);

        $aResponse['flag'] = self::FAILED_RESPONSE;

        $aResponse['victim_address_info'] = $this->Victims_model->getVictimAddressInfoById($aParam);
        $aResponse['victim_address_info']['victim_address_list_id'] = $this->yel->encrypt_param($aResponse['victim_address_info']['victim_address_list_id']);
        $aResponse['victim_address_info']['victim_id'] = $this->yel->encrypt_param($aResponse['victim_address_info']['victim_id']);

        if ($aResponse['victim_address_info']) {
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
        }

        return $aResponse;
    }

    public function updateVictimAddressInfoById($aParam) {
        // initialize
        $aResponse = [];

        // sanitize
        $aParam = $this->yel->fix_html_entities($aParam);
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        // flag indicator
        $aResponse['flag'] = self::FAILED_RESPONSE;

        // new parameter
        $aParam['victim_address_list_id'] = $this->yel->decrypt_param($aParam['victim_address_list_id']);
        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);

        // for logs 
        $aLog = [];
        $aLog['old_data'] = $this->Victims_model->getVictimAddressInfoByAddressId($aParam);
        $aResponse['victim_address_info'] = $this->Victims_model->updateVictimAddressInfoById($aParam);
        $aLog['new_data'] = $this->Victims_model->getVictimAddressInfoByAddressId($aParam);


        if ($aResponse['victim_address_info']['stat'] == 1) {

            // flag indicator
            $aResponse['flag'] = self::SUCCESS_RESPONSE;

            // for logs 
            $aLog['log_event_type'] = 61;
            $victim_id = $this->Victims_model->getVictimIDByVictimAddressID($aParam);
            $aLog['log_message'] = "update <a href='victim_list/" . $this->yel->encrypt_param($victim_id) . "'>victim's address</a> information";
            $aLog['log_action'] = 2; // 1= new inserted // 2=update table
            $aLog['new_data'] = $this->yel->encrypt_param(json_encode($aLog['new_data']));
            $aLog['old_data'] = $this->yel->encrypt_param(json_encode($aLog['old_data']));
            $aLog['module_primary_id'] = $aParam['case_id'];
            $aLog['sub_module_primary_id'] = $aParam['victim_address_list_id'];
            $aResponse['log'] = $this->audit->create($aLog);
        }

        return $aResponse;
    }

    public function getVictimRelativeInfoById($aParam) {
        // initialize
        $aResponse = [];

        // sanitize
        $aParam = $this->yel->fix_html_entities($aParam);
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        // flag indicator
        $aResponse['flag'] = self::FAILED_RESPONSE;

        // new param 
        $aParam['victim_relative_id'] = $this->yel->decrypt_param($aParam['victim_relative_id']);

        $aResponse['victim_relative_info'] = $this->Victims_model->getVictimRelativeInfoById($aParam);
        $aResponse['victim_relative_info']['victim_relative_id'] = $this->yel->encrypt_param($aResponse['victim_relative_info']['victim_relative_id']);
        $aResponse['victim_relative_info']['victim_id'] = $this->yel->encrypt_param($aResponse['victim_relative_info']['victim_id']);

        if ($aResponse['victim_relative_info']) {
            // flag indicator
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
        }

        return $aResponse;
    }

    public function updateVictimRelativeInfoById($aParam) {
        // initialize
        $aResponse = [];

        // sanitize
        $aParam = $this->yel->fix_html_entities($aParam);
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        // flag indicator
        $aResponse['flag'] = self::FAILED_RESPONSE;

        // new param
        $aParam['victim_relative_id'] = $this->yel->decrypt_param($aParam['victim_relative_id']);
        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);

        // for logs 
        $aLog = [];
        $aLog['old_data'] = $this->Victims_model->getVictimRelativeInfoByRelativeId($aParam);
        if (strtolower($aLog['old_data']['victim_relation']) == "other") {
            $aLog['old_data']['relation'] = $aLog['old_data']['victim_relative_type_other'];
        } else {
            $aLog['old_data']['relation'] = $aLog['old_data']['victim_relation'];
        }
        unset($aLog['old_data']['victim_relation']);
        unset($aLog['old_data']['victim_relative_type_other']);


        $aResponse['victim_relative_info'] = $this->Victims_model->updateVictimRelativeInfoById($aParam);
        $aLog['new_data'] = $this->Victims_model->getVictimRelativeInfoByRelativeId($aParam);
        if (strtolower($aLog['new_data']['victim_relation']) == "other") {
            $aLog['new_data']['relation'] = $aLog['new_data']['victim_relative_type_other'];
        } else {
            $aLog['new_data']['relation'] = $aLog['new_data']['victim_relation'];
        }

        // unset data 
        unset($aLog['new_data']['victim_relation']);
        unset($aLog['new_data']['victim_relative_type_other']);

        if ($aResponse['victim_relative_info']['stat'] == 1) {

            // flag indicator
            $aResponse['flag'] = self::SUCCESS_RESPONSE;

            // for logs 
            $aLog['log_event_type'] = 63;
            $victim_id = $this->Victims_model->getVictimIDByRelativeId($aParam);
            $aLog['log_message'] = "update <a href='victim_list/" . $this->yel->encrypt_param($victim_id) . "'>victim's</a> next of kin details";
            $aLog['log_action'] = 2; // 1= new inserted // 2=update table
            $aLog['new_data'] = $this->yel->encrypt_param(json_encode($aLog['new_data']));
            $aLog['old_data'] = $this->yel->encrypt_param(json_encode($aLog['old_data']));
            $aLog['module_primary_id'] = $aParam['case_id'];
            $aLog['sub_module_primary_id'] = $aParam['victim_relative_id'];
            $aResponse['log'] = $this->audit->create($aLog);
        }

        return $aResponse;
    }

    public function getVictimCaseList($aParam) {
        $aResponse = [];
        $aParam = $this->yel->clean_array($aParam);

        $aParam['victim_id'] = $this->yel->decrypt_param($aParam['victim_id']);

        $aResponse['flag'] = self::FAILED_RESPONSE;

        // get victim details
        $aResponse['victim_details'] = $this->Victims_model->getVictimInfoByID($aParam['victim_id']);

        if ($aResponse['victim_details']) {
            // optional for getting the other victim details
            $aResponse['content']['assumed'] = $this->Victims_model->getVictimAssumedNamebyId($aResponse['victim_details']['victim_id']);
            $aResponse['content']['real'] = $this->Victims_model->getVictimRealNamebyId($aResponse['victim_details']['victim_id']);

            $aResponse['content']['info'] = $aResponse['content']['assumed'];
            if (count($aResponse['content']['real']) != 0) {
                $aResponse['content']['info'] = $aResponse['content']['real'];
            }

            $aResponse['content']['address'] = $this->Victims_model->getGovernmentContactAddressByID($aResponse['victim_details']['victim_id']);

            if ($aParam['include_all'] == '1') {
                $aResponse['content']['contact_details'] = $this->Victims_model->getVictimListContactDetailsbyID($aResponse['victim_details']['victim_id']);
                $aResponse['content']['count_associated_case'] = $this->Victims_model->getCountAssociateCasePerVictimID($aResponse['victim_details']['victim_id']);
                $aResponse['content']['victim_education_info'] = $this->Victims_model->getVictimListEducationDetailsbyVictimId($aResponse['victim_details']);
                $aResponse['content']['victim_address_list'] = $this->Victims_model->getVictimListAddressDetailsbyVictimId($aResponse['victim_details']);
                $aResponse['content']['victim_relatives_info'] = $this->Victims_model->getVictimListRelativeDetailsbyVictimId($aResponse['victim_details']);

                if (!empty($aResponse['content']['contact_details'])) {
                    foreach ($aResponse['content']['contact_details'] as $key => $val) {
                        $aResponse['content']['contact_details'][$key]['victim_contact_details_id'] = $this->yel->encrypt_param($val['victim_contact_details_id']);
                    }
                }

                if (!empty($aResponse['content']['victim_education_info'])) {
                    foreach ($aResponse['content']['victim_education_info'] as $key => $val) {
                        $aResponse['content']['victim_education_info'][$key]['victim_education_id'] = $this->yel->encrypt_param($val['victim_education_id']);
                    }
                }

                if (!empty($aResponse['content']['victim_address_list'])) {
                    foreach ($aResponse['content']['victim_address_list'] as $key => $val) {
                        $aResponse['content']['victim_address_list'][$key]['victim_address_list_id'] = $this->yel->encrypt_param($val['victim_address_list_id']);
                    }
                }

                if (!empty($aResponse['content']['victim_relatives_info'])) {
                    foreach ($aResponse['content']['victim_relatives_info'] as $key => $val) {
                        $aResponse['content']['victim_relatives_info'][$key]['victim_relative_id'] = $this->yel->encrypt_param($val['victim_relative_id']);
                    }
                }
            }

            $aResponse['content']['victim_id'] = $this->yel->encrypt_param($aResponse['victim_details']['victim_id']);

            // victim cases
            $aResponse['cases'] = $this->Victims_model->getVictimCaseList($aParam['victim_id']);

            foreach ($aResponse['cases'] as $key => $val) {
                $aResponse['cases'][$key]['passport'] = $this->Victims_model->getVictimPassportByCaseVictimID($val['case_victim_id']);
            }
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
        }

        return $aResponse;
    }

    public function updateVictimInfo($aParam) {
        $aParam = $this->yel->clean_array($aParam);
        $aParam['victim_id'] = $this->yel->decrypt_param($aParam['victim_id']);

        $aResponse['flag'] = self::FAILED_RESPONSE;
        $aLog_r['old_data_real'] = $this->Victims_model->getVictimRealNamebyId($aParam['victim_id']);
        $aResponse['victim_info']['real'] = $this->Victims_model->updateVictimInfoById($aParam);

        if ($aResponse['victim_info']['real']['stat'] == 1) {
            $aLog_r['new_data_real'] = $this->Victims_model->getVictimRealNamebyId($aParam['victim_id']);
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
            $aLog_r['log_event_type'] = 75;
            $aLog_r['log_message'] = "updated <a href='victim_list/" . $this->yel->encrypt_param($aParam['victim_id']) . "'>victim information</a> information";
            $aLog_r['log_action'] = 2; // 1= new inserted // 2=update table
            $aLog_r['new_data'] = $this->yel->encrypt_param(json_encode($aLog_r['new_data_real']));
            $aLog_r['old_data'] = $this->yel->encrypt_param(json_encode($aLog_r['old_data_real']));
            $aLog_r['module_primary_id'] = $aParam['victim_id'];
            $aLog_r['sub_module_primary_id'] = $aResponse['victim_info']['real']['insert_id'];

            $aResponse['log_r'] = $this->audit->create($aLog_r);
        }

        $aLog_vi['old_data_vi'] = $this->Victims_model->getVictimDetailById($aParam['victim_id']);
        $aResponse['victim_info']['vi'] = $this->Victims_model->updateVictimDetailById($aParam);

        if ($aResponse['victim_info']['vi']['stat'] == 1) {
            $aLog_vi['new_data_vi'] = $this->Victims_model->getVictimRealNamebyId($aParam['victim_id']);
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
            $aLog_vi['log_event_type'] = 76;
            $aLog_vi['log_message'] = "updated <a href='victim_list/" . $this->yel->encrypt_param($aParam['victim_id']) . "'>victim detail</a> information";
            $aLog_vi['log_action'] = 2; // 1= new inserted // 2=update table
            $aLog_vi['new_data'] = $this->yel->encrypt_param(json_encode($aLog_vi['new_data_vi']));
            $aLog_vi['old_data'] = $this->yel->encrypt_param(json_encode($aLog_vi['old_data_vi']));
            $aLog_vi['module_primary_id'] = $aParam['victim_id'];
            $aLog_vi['sub_module_primary_id'] = $aResponse['victim_info']['vi']['insert_id'];

            $aResponse['log_vi'] = $this->audit->create($aLog_vi);
        }

        $aLog_a['old_data_a'] = $this->Victims_model->getVictimDetailById($aParam['victim_id']);
        $aResponse['victim_info']['assumed'] = $this->Victims_model->updateAssumedVictimInfoByVictimId($aParam);

        if ($aResponse['victim_info']['assumed']['stat'] == 1) {
            $aLog_vi['new_data_a'] = $this->Victims_model->getVictimRealNamebyId($aParam['victim_id']);
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
            $aLog_a['log_event_type'] = 75;
            $aLog_a['log_message'] = "updated <a href='victim_list/" . $this->yel->encrypt_param($aParam['victim_id']) . "'>victim detail</a> information";
            $aLog_a['log_action'] = 2; // 1= new inserted // 2=update table
            $aLog_a['new_data'] = $this->yel->encrypt_param(json_encode($aLog_a['new_data_a']));
            $aLog_a['old_data'] = $this->yel->encrypt_param(json_encode($aLog_a['old_data_a']));
            $aLog_a['module_primary_id'] = $aParam['victim_id'];
            $aLog_a['sub_module_primary_id'] = $aResponse['victim_info']['assumed']['insert_id'];

            $aResponse['log_a'] = $this->audit->create($aLog_a);
        }

        return $aResponse;
    }

    public function getVictimInfoByID($aParam) {
        $aResponse = [];

        $aParam = $this->yel->clean_array($aParam);
        $aParam['victim_id'] = $this->yel->decrypt_param($aParam['victim_id']);

        $aResponse['flag'] = self::FAILED_RESPONSE;

        $aResponse['resp'] = $this->Victims_model->getVictimInfoByID($aParam['victim_id']);

        if ($aResponse['resp']) {

            $aResponse['resp']['assumed'] = $this->Victims_model->getVictimAssumedNamebyId($aResponse['resp']['victim_id']);
            $aResponse['resp']['real'] = $this->Victims_model->getVictimRealNamebyId($aResponse['resp']['victim_id']);

            $aResponse['flag'] = self::SUCCESS_RESPONSE;
        }

        return $aResponse;
    }

    public function getVictimAddressByID($aParam) {
        $aResponse = [];

        $aParam = $this->yel->clean_array($aParam);
        $aParam['victim_id'] = $this->yel->decrypt_param($aParam['victim_id']);
        $aParam['victim_address_list_id'] = $this->yel->decrypt_param($aParam['victim_address_list_id']);

        $aResponse['flag'] = self::FAILED_RESPONSE;

        $aResponse['resp'] = $this->Victims_model->getVictimAddressByID($aParam);

        if ($aResponse['resp']) {

            $aResponse['flag'] = self::SUCCESS_RESPONSE;
        }

        return $aResponse;
    }

    public function updateVictimAddrById($aParam) {
        $aParam = $this->yel->clean_array($aParam);
        $aParam['victim_address_list_id'] = $this->yel->decrypt_param($aParam['victim_address_list_id']);
//        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);

        $aResponse['flag'] = self::FAILED_RESPONSE;
        $aLog = [];
        $aLog['old_data'] = $this->Victims_model->getVictimAddressInfoByAddressId($aParam);
        $aResponse['victim_address_info'] = $this->Victims_model->updateVictimAddressInfoById($aParam);
        $aLog['new_data'] = $this->Victims_model->getVictimAddressInfoByAddressId($aParam);


        if ($aResponse['victim_address_info']['stat'] == 1) {
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
            $aLog['log_event_type'] = 67;
            $victim_id = $this->Victims_model->getVictimIDByVictimAddressID($aParam);
            $aLog['log_message'] = "update <a href='victim_list/" . $this->yel->encrypt_param($victim_id) . "'>victim's address</a> information";
            $aLog['log_action'] = 2; // 1= new inserted // 2=update table
            $aLog['new_data'] = $this->yel->encrypt_param(json_encode($aLog['new_data']));
            $aLog['old_data'] = $this->yel->encrypt_param(json_encode($aLog['old_data']));
            $aLog['module_primary_id'] = $aParam['victim_address_list_id'];
            $aLog['sub_module_primary_id'] = $aParam['victim_address_list_id'];

            $aResponse['log'] = $this->audit->create($aLog);
        }

        return $aResponse;
    }

    public function addVictimAddrById($aParam) {
        $aParam = $this->yel->clean_array($aParam);
//        $aParam['victim_address_list_id'] = $this->yel->decrypt_param($aParam['victim_address_list_id']);
        $aParam['victim_id'] = $this->yel->decrypt_param($aParam['victim_id']);

        $aResponse['flag'] = self::FAILED_RESPONSE;
        $aLog = [];
//        $aLog['old_data'] = $this->Victims_model->getVictimAddressInfoByAddressId($aParam);
        $aResponse['victim_address_info'] = $this->Victims_model->addVictimAddrById($aParam);
//        $aLog['new_data'] = $this->Victims_model->getVictimAddressInfoByAddressId($aParam);

        if ($aResponse['victim_address_info']['stat'] == 1) {
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
            $aLog['log_event_type'] = 68;
//            $victim_id = $this->Victims_model->getVictimIDByVictimAddressID($aParam);
            $aLog['log_message'] = "added <a href='victim_list/" . $this->yel->encrypt_param($aParam['victim_id']) . "'>victim's address</a> information";
            $aLog['log_action'] = 1; // 1= new inserted // 2=update table
            $aLog['module_primary_id'] = $aParam['victim_id'];
            $aLog['sub_module_primary_id'] = $aResponse['victim_address_info']['insert_id'];

            $aResponse['log'] = $this->audit->create($aLog);
        }

        return $aResponse;
    }

    public function updateVictimContactById($aParam) {
        $aParam = $this->yel->clean_array($aParam);
        $aParam['victim_contact_details_id'] = $this->yel->decrypt_param($aParam['victim_contact_details_id']);
//        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);

        $aResponse['flag'] = self::FAILED_RESPONSE;
        $aLog = [];
        $aLog['old_data'] = $this->Victims_model->getVictimContactInfoByContactId($aParam);
        $aResponse['victim_contact_info'] = $this->Victims_model->updateVictimContactInfoById($aParam);
        $aLog['new_data'] = $this->Victims_model->getVictimContactInfoByContactId($aParam);

        if ($aResponse['victim_contact_info']['stat'] == 1) {
            $aLog['log_event_type'] = 69;
            $victim_id = $this->Victims_model->getVictimIdByVictimContactID($aParam);
            $aLog['log_message'] = "update <a href='victim_list/" . $this->yel->encrypt_param($victim_id) . "'>victim's</a> contact details";
            $aLog['log_action'] = 2; // 1= new inserted // 2=update table
            $aLog['new_data'] = $this->yel->encrypt_param(json_encode($aLog['new_data']));
            $aLog['old_data'] = $this->yel->encrypt_param(json_encode($aLog['old_data']));
            $aLog['module_primary_id'] = $aParam['victim_contact_details_id'];
            $aLog['sub_module_primary_id'] = $aParam['victim_contact_details_id'];

            $aResponse['log'] = $this->audit->create($aLog);
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
        }

        return $aResponse;
    }

    public function addVictimContactById($aParam) {
        $aParam = $this->yel->clean_array($aParam);
//        $aParam['victim_address_list_id'] = $this->yel->decrypt_param($aParam['victim_address_list_id']);
        $aParam['victim_id'] = $this->yel->decrypt_param($aParam['victim_id']);

        $aResponse['flag'] = self::FAILED_RESPONSE;
        $aLog = [];
//        $aLog['old_data'] = $this->Victims_model->getVictimAddressInfoByAddressId($aParam);
        $aResponse['victim_contact_info'] = $this->Victims_model->addVictimContactById($aParam);
//        $aLog['new_data'] = $this->Victims_model->getVictimAddressInfoByAddressId($aParam);

        if ($aResponse['victim_contact_info']['stat'] == 1) {
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
            $aLog['log_event_type'] = 70;
//            $victim_id = $this->Victims_model->getVictimIDByVictimAddressID($aParam);
            $aLog['log_message'] = "added <a href='victim_list/" . $this->yel->encrypt_param($aParam['victim_id']) . "'>victim's</a> contact details";
            $aLog['log_action'] = 1; // 1= new inserted // 2=update table
            $aLog['module_primary_id'] = $aParam['victim_id'];
            $aLog['sub_module_primary_id'] = $aResponse['victim_contact_info']['insert_id'];

            $aResponse['log'] = $this->audit->create($aLog);
        }

        return $aResponse;
    }

    public function updateVictimEducationById($aParam) {
        $aParam = $this->yel->clean_array($aParam);
        $aParam['victim_education_id'] = $this->yel->decrypt_param($aParam['victim_education_id']);
//        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);
        $victim_id = $this->Victims_model->getVictimIDByVictimEducationID($aParam);
        $aResponse['flag'] = self::FAILED_RESPONSE;
        $aLog = [];
        $aLog['old_data'] = $this->Victims_model->getVictimEducationInfoById($aParam);
        $aResponse['victim_education_info'] = $this->Victims_model->updateVictimEducationInfoById($aParam);
        $aLog['new_data'] = $this->Victims_model->getVictimEducationInfoById($aParam);


        if ($aResponse['victim_education_info']['stat'] == 1) {
            $aResponse['flag'] = self::SUCCESS_RESPONSE;

            $aLog['log_event_type'] = 71;
            $aLog['log_message'] = "update <a href='victim_list/" . $this->yel->encrypt_param($victim_id) . "'> victim's </a> educational background";
            $aLog['log_action'] = 2; // 1= new inserted // 2=update table
            $aLog['new_data'] = $this->yel->encrypt_param(json_encode($aLog['new_data']));
            $aLog['old_data'] = $this->yel->encrypt_param(json_encode($aLog['old_data']));
            $aLog['module_primary_id'] = $aParam['victim_education_id'];
            $aLog['sub_module_primary_id'] = $aParam['victim_education_id'];

            $aResponse['log'] = $this->audit->create($aLog);
        }

        return $aResponse;
    }

    public function addVictimEducationById($aParam) {
        $aParam = $this->yel->clean_array($aParam);
//        $aParam['victim_address_list_id'] = $this->yel->decrypt_param($aParam['victim_address_list_id']);
        $aParam['victim_id'] = $this->yel->decrypt_param($aParam['victim_id']);

        $aResponse['flag'] = self::FAILED_RESPONSE;
        $aLog = [];
//        $aLog['old_data'] = $this->Victims_model->getVictimAddressInfoByAddressId($aParam);
        $aResponse['victim_education_info'] = $this->Victims_model->addVictimEducationById($aParam);
//        $aLog['new_data'] = $this->Victims_model->getVictimAddressInfoByAddressId($aParam);

        if ($aResponse['victim_education_info']['stat'] == 1) {
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
            $aLog['log_event_type'] = 72;
//            $victim_id = $this->Victims_model->getVictimIDByVictimAddressID($aParam);
            $aLog['log_message'] = "added <a href='victim_list/" . $this->yel->encrypt_param($aParam['victim_id']) . "'>victim's</a> educational backgroud";
            $aLog['log_action'] = 1; // 1= new inserted // 2=update table
            $aLog['module_primary_id'] = $aParam['victim_id'];
            $aLog['sub_module_primary_id'] = $aResponse['victim_education_info']['insert_id'];

            $aResponse['log'] = $this->audit->create($aLog);
        }

        return $aResponse;
    }

    public function updateVictimRelativeById($aParam) {
        $aParam = $this->yel->clean_array($aParam);
        $aParam['victim_relative_id'] = $this->yel->decrypt_param($aParam['victim_relative_id']);
//        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);

        $aResponse['flag'] = self::FAILED_RESPONSE;
        $aLog = [];
        $aLog['old_data'] = $this->Victims_model->getVictimRelativeInfoByRelativeId($aParam);
        if (strtolower($aLog['old_data']['victim_relation']) == "other") {
            $aLog['old_data']['relation'] = $aLog['old_data']['victim_relative_type_other'];
        } else {
            $aLog['old_data']['relation'] = $aLog['old_data']['victim_relation'];
        }
        unset($aLog['old_data']['victim_relation']);
        unset($aLog['old_data']['victim_relative_type_other']);


        $aResponse['victim_relative_info'] = $this->Victims_model->updateVictimRelativeInfoById($aParam);
        $aLog['new_data'] = $this->Victims_model->getVictimRelativeInfoByRelativeId($aParam);
        if (strtolower($aLog['new_data']['victim_relation']) == "other") {
            $aLog['new_data']['relation'] = $aLog['new_data']['victim_relative_type_other'];
        } else {
            $aLog['new_data']['relation'] = $aLog['new_data']['victim_relation'];
        }
        unset($aLog['new_data']['victim_relation']);
        unset($aLog['new_data']['victim_relative_type_other']);
        if ($aResponse['victim_relative_info']['stat'] == 1) {
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
            $aLog['log_event_type'] = 73;
            $victim_id = $this->Victims_model->getVictimIDByRelativeId($aParam);
            $aLog['log_message'] = "update <a href='victim_list/" . $this->yel->encrypt_param($victim_id) . "'>victim's</a> next of kin details";
            $aLog['log_action'] = 2; // 1= new inserted // 2=update table
            $aLog['new_data'] = $this->yel->encrypt_param(json_encode($aLog['new_data']));
            $aLog['old_data'] = $this->yel->encrypt_param(json_encode($aLog['old_data']));
            $aLog['module_primary_id'] = $aParam['victim_relative_id'];
            $aLog['sub_module_primary_id'] = $aParam['victim_relative_id'];
            $aResponse['log'] = $this->audit->create($aLog);
        }

        return $aResponse;
    }

    public function addVictimRelativeById($aParam) {
        $aParam = $this->yel->clean_array($aParam);
        $aParam['victim_id'] = $this->yel->decrypt_param($aParam['victim_id']);

        $aResponse['flag'] = self::FAILED_RESPONSE;
        $aLog = [];

        $aResponse['victim_relative_info'] = $this->Victims_model->addVictimRelativeById($aParam);

        if ($aResponse['victim_relative_info']['stat'] == 1) {
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
            $aLog['log_event_type'] = 73;
//            $victim_id = $this->Victims_model->getVictimIDByRelativeId($aParam);
            $aLog['log_message'] = "added <a href='victim_list/" . $this->yel->encrypt_param($aParam['victim_id']) . "'>victim's</a> next of kin details";
            $aLog['log_action'] = 1; // 1= new inserted // 2=update table
            $aLog['module_primary_id'] = $aParam['victim_id'];
            $aLog['sub_module_primary_id'] = $aResponse['victim_relative_info']['insert_id'];
            $aResponse['log'] = $this->audit->create($aLog);
        }

        return $aResponse;
    }

    /*
     * dev_andy
     */

    public function setVictimInfoByCaseId($aParam) {

        // initialize
        $aResponse = [];

        // sanitize
        $aParam = $this->yel->fix_html_entities($aParam);
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        // flag indicator
        $aResponse['flag'] = self::FAILED_RESPONSE;

        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);
        $aParam['caseid'] = $aParam['case_id'];
        $case_number = $this->Case_details_model->getCaseNumberByCaseId($aParam);
        $aParam['victim_id'] = $this->Victims_model->getVictimIdByCaseId($aParam);
//        if (isset($aParam['dob']) == true && empty($aParam['dob']) == false) {
//            $ddate = explode('/', $aParam['dob']);
//            $aParam['dob'] = $ddate[2] . "-" . $ddate[0] . "-" . $ddate[1];
//        } else {
//            $aParam['dob'] = "";
//        }
        $aLog = [];
        //main victim table
        $aLog['old_data'] = $this->Victims_model->getVictimDetailsByVictimID($aParam, 0); //0 for real name
        $aResponse['set_details'] = $this->Victims_model->setVictimDetailsByVictimId($aParam);
        $aLog['new_data'] = $this->Victims_model->getVictimDetailsByVictimID($aParam, 0); //0 for real name

        $aLog['log_event_type'] = 76;
        $aLog['log_message'] = "update victim details <a href='update_case/" . $this->yel->encrypt_param($aParam['case_id']) . "'>" . $case_number . "</a>";
        $aLog['log_action'] = 2; // 1= new inserted // 2=update table
        $aLog['new_data'] = $this->yel->encrypt_param(json_encode($aLog['new_data']));
        $aLog['old_data'] = $this->yel->encrypt_param(json_encode($aLog['old_data']));
        $aLog['module_primary_id'] = $aParam['case_id'];
        $aLog['sub_module_primary_id'] = $aParam['victim_id'];
        if ($aResponse['set_details']['stat'] == "1") {
            $aResponse['log'] = $this->audit->create($aLog);
        }

        $aLogs = [];
        //victim info table
        $aLogs['old_data'] = $this->Victims_model->getVictimInfoByVictimID($aParam);
        $aResponse['set_detail'] = $this->Victims_model->setVictimInfoByVictimID($aParam);
        $aLogs['new_data'] = $this->Victims_model->getVictimInfoByVictimID($aParam);
        $aLogs['log_event_type'] = 75;
        $aLogs['log_message'] = "update victim details for the case report <a href='update_case/" . $this->yel->encrypt_param($aParam['case_id']) . "'>" . $case_number . "</a>";
        $aLogs['log_action'] = 2; // 1= new inserted // 2=update table
        $aLogs['new_data'] = $this->yel->encrypt_param(json_encode($aLogs['new_data']));
        $aLogs['old_data'] = $this->yel->encrypt_param(json_encode($aLogs['old_data']));
        $aLogs['module_primary_id'] = $aParam['case_id'];
        $aLogs['sub_module_primary_id'] = $aParam['victim_id'];
        if ($aResponse['set_detail']['stat'] == "1") {
            $aResponse['logs'] = $this->audit->create($aLogs);
        }

        return $aResponse;
    }

    public function deleteVictimAddressInfoById($aParam) {
        $aParam = $this->yel->clean_array($aParam);
        $aParam['victim_address_list_id'] = $this->yel->decrypt_param($aParam['victim_address_list_id']);

        $aResponse['flag'] = self::FAILED_RESPONSE;

        $aResponse['victim_address_info'] = $this->Victims_model->removeVictimAddressInfoById($aParam);

        if ($aResponse['victim_address_info']['stat'] == 1) {
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
            $victim_id = $this->Victims_model->getVictimIDByVictimAddressID($aParam);
            $aLog = [];
            $aLog['log_action'] = 1; // 1= new inserted // 2=update table
            $aLog['log_event_type'] = 77; // base on table : icms_user_event_type
            $aLog['log_message'] = "removed <a href='victim_list/" . $this->yel->encrypt_param($victim_id) . "'>victim's </a> address details";
            $aLog['module_primary_id'] = $victim_id;
            $aLog['sub_module_primary_id'] = $aParam['victim_address_list_id'];
            $aResponse['log'] = $this->audit->create($aLog);
        }

        return $aResponse;
    }

    public function deleteVictimContactInfoById($aParam) {
        $aParam = $this->yel->clean_array($aParam);
        $aParam['victim_contact_details_id'] = $this->yel->decrypt_param($aParam['victim_contact_details_id']);

        $aResponse['flag'] = self::FAILED_RESPONSE;

        $aResponse['victim_contact_info'] = $this->Victims_model->removeVictimContactInfoById($aParam);

        if ($aResponse['victim_contact_info']['stat'] == 1) {
            $aResponse['flag'] = self::SUCCESS_RESPONSE;

            $aLog = [];
            $aLog['log_action'] = 1; // 1= new inserted // 2=update table
            $aLog['log_event_type'] = 78; // base on table : icms_user_event_type
            $victim_id = $this->Victims_model->getVictimIdByVictimContactID($aParam);
            $aLog['log_message'] = "removed <a href='victim_list/" . $this->yel->encrypt_param($victim_id) . "'>victim's </a> contact";
            $aLog['module_primary_id'] = $victim_id;
            $aLog['sub_module_primary_id'] = $aParam['victim_contact_details_id'];
            $aResponse['log'] = $this->audit->create($aLog);
        }

        return $aResponse;
    }

    public function deleteVictimEducationInfoById($aParam) {
        $aParam = $this->yel->clean_array($aParam);
        $aParam['victim_education_id'] = $this->yel->decrypt_param($aParam['victim_education_id']);
        $victim_id = $this->Victims_model->getVictimIDByVictimEducationID($aParam);
        $aResponse['flag'] = self::FAILED_RESPONSE;

        $aResponse['victim_education_info'] = $this->Victims_model->removeVictimEducationInfoById($aParam);

        if ($aResponse['victim_education_info']['stat'] == 1) {
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
            $aLog = [];
            $aLog['log_action'] = 1; // 1= new inserted // 2=update table
            $aLog['log_event_type'] = 79; // base on table : icms_user_event_type
            $aLog['log_message'] = "removed <a href='victim_list/" . $this->yel->encrypt_param($victim_id) . "'>victim's </a> educational background";
            $aLog['module_primary_id'] = $victim_id;
            $aLog['sub_module_primary_id'] = $aParam['victim_education_id'];
            $aResponse['log'] = $this->audit->create($aLog);
        }

        return $aResponse;
    }

    public function deleteVictimRelativeInfoById($aParam) {
        $aParam = $this->yel->clean_array($aParam);
        $aParam['victim_relative_id'] = $this->yel->decrypt_param($aParam['victim_relative_id']);
        $victim_id = $this->Victims_model->getVictimIDByRelativeId($aParam);
        $aResponse['flag'] = self::FAILED_RESPONSE;

        $aResponse['victim_relative_info'] = $this->Victims_model->removeVictimRelativeInfoById($aParam);

        if ($aResponse['victim_relative_info']['stat'] == 1) {
            $aResponse['flag'] = self::SUCCESS_RESPONSE;

            $aLog = [];
            $aLog['log_action'] = 1; // 1= new inserted // 2=update table
            $aLog['log_event_type'] = 80; // base on table : icms_user_event_type
            $aLog['log_message'] = "added <a href='victim_list/" . $this->yel->encrypt_param($victim_id) . "'>victim's </a> next of kin details";
            $aLog['module_primary_id'] = $victim_id;
            $aLog['sub_module_primary_id'] = $aParam['victim_relative_id'];
            $aResponse['log'] = $this->audit->create($aLog);
        }

        return $aResponse;
    }

    public function setAssumedVictimInfoByCaseId($aParam) {

        // initialize
        $aResponse = [];

        // sanitize
        $aParam = $this->yel->fix_html_entities($aParam);
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        // flag indicator
        $aResponse['flag'] = self::FAILED_RESPONSE;

        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);
        $aParam['caseid'] = $aParam['case_id'];
        $case_number = $this->Case_details_model->getCaseNumberByCaseId($aParam);
        $aParam['victim_id'] = $this->Victims_model->getVictimIdByCaseId($aParam);
        if (isset($aParam['dob']) == true && empty($aParam['dob']) == false) {
            $ddate = explode('/', $aParam['dob']);
            $aParam['dob'] = $ddate[2] . "-" . $ddate[0] . "-" . $ddate[1];
        } else {
            $aParam['dob'] = "";
        }
        $aLog = [];
        //main victim table
        $aLog['old_data'] = $this->Victims_model->getVictimDetailsByVictimID($aParam, 1); //0 for real name
        $aResponse['set_details'] = $this->Victims_model->setAssumedVictimDetailsByVictimId($aParam);
        $aLog['new_data'] = $this->Victims_model->getVictimDetailsByVictimID($aParam, 1); //0 for real name
        $aLog['log_event_type'] = 76;
        $aLog['log_message'] = "update victim details <a href='update_case/" . $this->yel->encrypt_param($aParam['case_id']) . "'>" . $case_number . "</a>";
        $aLog['log_action'] = 2; // 1= new inserted // 2=update table
        $aLog['new_data'] = $this->yel->encrypt_param(json_encode($aLog['new_data']));
        $aLog['old_data'] = $this->yel->encrypt_param(json_encode($aLog['old_data']));
        $aLog['module_primary_id'] = $aParam['case_id'];
        $aLog['sub_module_primary_id'] = $aParam['victim_id'];
        if ($aResponse['set_details']['stat'] == "1") {
            $aResponse['log'] = $this->audit->create($aLog);
            // flag indicator
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
        }

        return $aResponse;
    }

    public function getVictimInformationById($aParam) {

        $aResponse = [];
        $aParam = $this->yel->clean_array($aParam);

        $aParam['victim_id'] = $this->yel->decrypt_param($aParam['victim_id']);

        $aResponse['flag'] = self::FAILED_RESPONSE;

        // get victim details
        $aResponse['victim_details'] = $this->Victims_model->getVitimInfoById($aParam);
        // OSAEC Comment Code Start
        // $aResponse['Global_data'] = $this->Global_data_model->getGlobalDataVictimInformation($aParam);
        // OSAEC Comment Code END
        

        if ($aResponse['victim_details']) {
            // optional for getting the other victim details
            $aResponse['content']['assumed'] = $this->Victims_model->getVictimAssumedNamebyId($aResponse['victim_details']['victim_id']);
            $aResponse['content']['real'] = $this->Victims_model->getVictimRealNamebyId($aResponse['victim_details']['victim_id']);

            $aResponse['content']['info'] = $aResponse['content']['assumed'];
            if (count($aResponse['content']['real']) != 0) {
                $aResponse['content']['info'] = $aResponse['content']['real'];
            }

            $aResponse['content']['address'] = $this->Victims_model->getGovernmentContactAddressByID($aResponse['victim_details']['victim_id']);

            if ($aParam['include_all'] == '1') {
                $aResponse['content']['contact_details'] = $this->Victims_model->getVictimListContactDetailsbyID($aResponse['victim_details']['victim_id']);
                $aResponse['content']['count_associated_case'] = $this->Victims_model->getCountAssociateCasePerVictimID($aResponse['victim_details']['victim_id']);
                $aResponse['content']['victim_education_info'] = $this->Victims_model->getVictimListEducationDetailsbyVictimId($aResponse['victim_details']);
                $aResponse['content']['victim_address_list'] = $this->Victims_model->getVictimListAddressDetailsbyVictimId($aResponse['victim_details']);
                $aResponse['content']['victim_relatives_info'] = $this->Victims_model->getVictimListRelativeDetailsbyVictimId($aResponse['victim_details']);

                if (!empty($aResponse['content']['contact_details'])) {
                    foreach ($aResponse['content']['contact_details'] as $key => $val) {
                        $aResponse['content']['contact_details'][$key]['victim_contact_details_id'] = $this->yel->encrypt_param($val['victim_contact_details_id']);
                    }
                }

                if (!empty($aResponse['content']['victim_education_info'])) {
                    foreach ($aResponse['content']['victim_education_info'] as $key => $val) {
                        $aResponse['content']['victim_education_info'][$key]['victim_education_id'] = $this->yel->encrypt_param($val['victim_education_id']);
                    }
                }

                if (!empty($aResponse['content']['victim_address_list'])) {
                    foreach ($aResponse['content']['victim_address_list'] as $key => $val) {
                        $aResponse['content']['victim_address_list'][$key]['victim_address_list_id'] = $this->yel->encrypt_param($val['victim_address_list_id']);
                    }
                }

                if (!empty($aResponse['content']['victim_relatives_info'])) {
                    foreach ($aResponse['content']['victim_relatives_info'] as $key => $val) {
                        $aResponse['content']['victim_relatives_info'][$key]['victim_relative_id'] = $this->yel->encrypt_param($val['victim_relative_id']);
                    }
                }
            }

            $aResponse['content']['victim_id'] = $this->yel->encrypt_param($aResponse['victim_details']['victim_id']);

            $aResponse['flag'] = self::SUCCESS_RESPONSE;
        }

        return $aResponse;
    }

}
