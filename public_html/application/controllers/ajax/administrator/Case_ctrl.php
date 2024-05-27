<?php

/**
 * Case Internal Ajax
 * 
 * @module Ajax Loader
 * @author LBS eBusiness Solutions Corp. 
 * @since 2017
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Case_ctrl extends CI_Controller {

    const SUCCESS_RESPONSE = 1;
    const FAILED_RESPONSE = 0;

    public function __construct() {
        parent::__construct();

        // load models
        $this->load->model('administrator/Case_model');
        $this->load->model('administrator/Victims_model');
        $this->load->model('administrator/Users_model');
        $this->load->model('administrator/Service_details_model');
        $this->load->model('administrator/Case_details_model');
        $this->load->model('administrator/Assignee_model');
        $this->load->model('administrator/Temporary_case_model');
        $this->load->model('Global_data_model');
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

    /*
     * Generate Case Number 
     */

    public function generateCaseNumber() {

        $agencyData = $this->session->userdata('userData');
        $agencyId = $agencyData['agency_id'];
        $year = date("y");
        $last_id = $this->Case_model->getLastCaseId();
        $caseCnt = str_pad($last_id + 1, 5, '0', STR_PAD_LEFT);

        $cn = 'CN' . $agencyId . $year . $caseCnt;

        return $cn;
    }

    /*
     * Generate Victim Number
     */

    public function generateVictimNumber() {
        $year = date("y");
        $last_id = $this->Victims_model->getLastVictimId();
        $victimCnt = str_pad($last_id + 1, 5, '0', STR_PAD_LEFT);

        $vn = 'VN' . $year . $victimCnt;

        return $vn;
    }

    /*
    * Advance search 
    * by: Kim Arvin 
    */ 
    public function getAdvanceSearch($param){

        $param = json_decode($param, true);

        $sql = ""; 
        $data =[]; 
        $age = $param['age_min'] + $param['age_max']; 
        
         # Age based on Departure 
         if (!empty($age) !== false) {
            array_push($data,"age");
            $sql .= " AND `case_victim_id` IN ( SELECT `case_victim_id` FROM `view_report_summary` WHERE `deployment_age` BETWEEN ". $param['age_min'] ." AND ". $param['age_max'] ."
                                             )";
            // exit($sql);
        }

        # For Country 
         if (!empty($param['country']) !== false) {
             
            array_push($data,"country");
            
            $no_record = ""; 
            if (in_array("no_record", $param['country'], TRUE)) {
                 $no_record = " AND `country_id` IS NULL "; 
                 unset($param['country'][count($param['country']) - 1]); 
            }
            
            $sql .= " AND `case_victim_id` IN ( SELECT `case_victim_id` FROM `icms_case_victim_employment` 
                                                WHERE `case_victim_employment_is_active` = 1 
                                                AND `case_victim_employment_id` IN (SELECT `case_victim_employment_id` FROM `icms_case_victim_employment_details` 
                                                                                    WHERE `case_victim_employment_details_is_actual` = '1' 
                                                                                    AND `country_id` IN (".implode(",",$param['country'])."))  ". $no_record ."
                                             )";
        }

        # For Departure Type 
        if (!empty($param['departure_type']) !== false) {
            array_push($data,"departure_type");
            $sql .= " AND `case_victim_id` IN ( SELECT `case_victim_id` FROM `icms_case_victim_deployment` 
                                                WHERE `case_victim_deployment_is_active` = 1 
                                                AND `case_victim_deployment_type` IN (".$param['departure_type'].") 
                                             )";
            // exit($sql);
        }
        
        # For Sex 
        if (!empty($param['sex']) !== false) {
            array_push($data,"sex");
            $sql .= " AND `victim_id` IN (SELECT `victim_id` 
                            FROM `icms_victim` 
                            WHERE `victim_gender` = '". $param['sex'] . "')";
                            // exit($sql);
        }

        # Job
        if (!empty($param['job']) !== false) {
            array_push($data,"job");
            $sql .=  " AND `case_victim_id` IN (SELECT `cve`.`case_victim_id`
                            FROM `icms_case_victim_employment_details` `cved`, `icms_case_victim_employment` `cve` 
                            WHERE `cve`.`case_victim_employment_id` = `cved`.`case_victim_employment_id` AND
                                    UPPER(`cved`.`case_victim_employment_details_job_title`) = '".$param['job']."'
                            )";
            // exit($sql);
        }

        # Region 
        if (!empty($param['region']) !== false) {
            array_push($data,"region");
            $sql .="AND `victim_id` IN (SELECT `victim_id`
                            FROM `icms_victim_address_list` 
                            WHERE `victim_address_list_region_id` = '".$param['region']."'
                            )";
        }

        # Province 
        if (!empty($param['province']) !== false) {
            array_push($data,"province");
            $sql .="AND `victim_id` IN (SELECT `victim_id`
                            FROM `icms_victim_address_list` 
                            WHERE `victim_address_list_province_id` = '".$param['province']."'
                            )";
        }

        # City 
        if (!empty($param['city']) !== false) {
            array_push($data,"city");
            $sql .="AND `victim_id` IN (SELECT `victim_id`
                            FROM `icms_victim_address_list` 
                            WHERE `victim_address_list_city_id` = '".$param['city']."'
                            )";
        }

        # Acts 
        if (!empty($param['tip_act']) !== false) {
            array_push($data,"act");
            $sql .="AND `case_victim_id` IN (SELECT `case_victim_id`
                            FROM `icms_case_victim_tip` 
                            WHERE `case_victim_tip_type_id` = '1' AND 
                                  `case_victim_tip_type_content_id` IN (".implode(",",$param['tip_act']).")
                            )";
        }

        # Purposes 
        if (!empty($param['tip_purpose']) !== false) {
            array_push($data,"purpose");
            $sql .="AND `case_victim_id` IN (SELECT `case_victim_id`
                            FROM `icms_case_victim_tip` 
                            WHERE `case_victim_tip_type_id` = '2' AND 
                                  `case_victim_tip_type_content_id` IN (".implode(",",$param['tip_purpose']).")
                            )";
        }

        # Means 
        if (!empty($param['tip_mean']) !== false) {
            array_push($data,"mean");
            $sql .="AND `case_victim_id` IN (SELECT `case_victim_id`
                            FROM `icms_case_victim_tip` 
                            WHERE `case_victim_tip_type_id` = '3' AND 
                                  `case_victim_tip_type_content_id` IN (".implode(",",$param['tip_mean']).")
                            )";
        }

        # Departure type 
        if (!empty($param['departure_type']) !== false) {
            array_push($data,"departure_type");
            $sql .="AND `case_victim_id` IN (SELECT `case_victim_id`
                            FROM `icms_case_victim_deployment` 
                            WHERE `case_victim_deployment_type` = '".$param['departure_type']."'
                            )";
        }

        # Date filed 
        if (!empty($param['date_filed']) !== false) {
            array_push($data,"date_filed");
            $sql .="AND `case_id` IN (SELECT `case_id`
                            FROM `icms_case` 
                            WHERE DATE(`case_date_added`) BETWEEN '" . $param['date_filed_start'] . "' AND '" . $param['date_filed_end'] . "'
                            )";
        }
        
        # Local Agency  
       if (!empty($param['local_agency_id']) !== false) {
           array_push($data,"local_agency");
           $param['local_agency_id'] = $this->yel->decrypt_param($param['local_agency_id']);
           $sql .="AND `case_victim_id` IN (SELECT `case_victim_id`
                           FROM `icms_case_victim_employment` 
                           WHERE `recruitment_agency_id_local` = '" . $param['local_agency_id'] . "'
                           )";
           // exit($sql);
       }

       # Foreign Agency  
        if (!empty($param['foreign_agency_id']) !== false) {
            array_push($data,"foreign_agency");
            $param['foreign_agency_id'] = $this->yel->decrypt_param($param['foreign_agency_id']);
            $sql .="AND `case_victim_id` IN (SELECT `case_victim_id`
                            FROM `icms_case_victim_employment` 
                            WHERE `recruitment_agency_id_foreign`  = '" . $param['foreign_agency_id'] . "'
                            )";
            // exit($sql);
        }

        # Employer
        if (!empty($param['employer_id']) !== false) {
            array_push($data,"employer");
            $param['employer_id'] = $this->yel->decrypt_param($param['employer_id']);
            $sql .="AND `case_victim_id` IN (SELECT `case_victim_id`
                            FROM `icms_case_victim_employment` 
                            WHERE `employer_id`  = '" . $param['employer_id'] . "'
                            )";
            // exit($sql);
        }

        # Agency branches 
//        if (!empty($param['agecies_branch']) !== false) {
//            array_push($data,"agecies_branch");
//            $sql .="AND `case_id` IN (SELECT `case_id`
//                            FROM `icms_case` 
//                            WHERE `case_added_by` IN (SELECT `user_id` FROM `icms_user` 
//                                                      WHERE `agency_branch_id` IN (".$param['agecies_branch'].") 
//                                                     )
//                            )";
//            // exit($sql);
//        }
        
        # Agency branches 
        if (!empty($param['agecies_branch']) !== false) {
            array_push($data,"agecies_branch");
            $sql .="AND `case_victim_id` IN (SELECT `case_victim_id`
                            FROM `icms_case_victim_services` 
                            WHERE `case_victim_services_id` IN (
                                    SELECT `case_victim_services_id`
                                    FROM `icms_case_victim_services_agency_tag` 
                                    WHERE `agency_branch_id` IN (".$param['agecies_branch'].") 
                                    AND `case_victim_services_agency_tag_is_active` = '1'
                                )  AND `case_victim_services_is_active` = '1' 
                            )";
            // exit($sql);
        }
        
        # Services
        if (!empty($param['services']) !== false) {
            array_push($data,"services");
            $sql .="AND `case_victim_id` IN (SELECT `case_victim_id`
                            FROM `icms_case_victim_services` 
                            WHERE `services_id` IN (".$param['services'].") 
                            )";
            // exit($sql);
        }
        
        # Sql 
        if (!empty($data) !== false) {
            $fsql =  "
                AND `icv`.`case_victim_id` IN (SELECT 
                    `case_victim_id`
                FROM  
                    `icms_case_victim` 
                WHERE 
                `case_victim_id` IN (SELECT `case_victim_id` FROM `view_report_summary`) 
                ". $sql .")
            ";
            // exit($fsql);
            return $fsql; 
        }
  
        return $sql; 
    }

    /*
     * fetching main info of case details
     * by:dev_andres
     */
    public function getAllCaseLists($aParam) {
        
        $aResponse = [];
        $aResult = [];
        $aParam['sRelevance'] = "";
        $aParam['cRelevance'] = "";
        $aParam['cOrderBy'] = "";
        $aParam['cFilter'] = "";
        $aParam['advance_search'] = ""; 
        $advance_search = $this->getAdvanceSearch($aParam['optData']);
        $aParam = $this->yel->clean_array($aParam);
        $aResponse['flag'] = self::FAILED_RESPONSE;
        $aParam = $this->yel->pagination($aParam);
        $aParam['advance_search'] = ($advance_search) ? $advance_search : ""; 

        
        // For Filter Priority Level 
        if ($aParam['filter'] !== '') {
            $aParam['cFilter'] = ' AND  `ic`.`case_priority_level_id` IN(' . $aParam['filter'] . ') ';
        }

        switch ((int) $aParam['tab']) {
            case 1:
                // For IACAT - ALL CASES 
                if ($_SESSION['userData']['agency_id'] == '1') {
                    $aParam['cTab'] = '';
                    if ($aParam['filter'] !== '') {
                        $aParam['cFilter'] = ' AND  `ic`.`case_priority_level_id` IN(' . $aParam['filter'] . ') ';
                    }
                }
                // For Agency branch - ALL CASES 
                else {
                    'AND `ic`.`case_id` IN (SELECT `icv`.`case_id` FROM `icms_case_victim` `icv` WHERE `icv`.`case_victim_id` IN ( SELECT `case_victim_id` FROM `icms_case_victim_services` `icvs` WHERE `icvs`.`case_victim_services_is_active` = "1" AND `icvs`.`case_victim_services_id` IN ( (SELECT `icvsa`.`case_victim_services_id` FROM `icms_case_victim_services_agency_tag` `icvsa` WHERE `cvsa`.`case_victim_services_agency_tag_is_active` = "1"  AND  `icvsa`.`agency_branch_id` = ' . $_SESSION['userData']['agency_branch_id'] . ' ) )  ) )';
                }
                break;
            case 2:
                $aParam['cTab'] = 'AND `ic`.`case_added_by` = ' . $_SESSION['userData']['user_id'] . ' AND `ic`.`case_id` IN (SELECT `ictu`.`case_id` FROM `icms_case_tagged_users` `ictu` WHERE `ictu`.`user_id` = ' . $_SESSION['userData']['user_id'] . ' ) ';
                break;
            case 3:
                $aParam['cTab'] = 'AND `ic`.`case_id` IN (SELECT `icv`.`case_id` FROM `icms_case_victim` `icv` WHERE `icv`.`case_victim_id` IN ( SELECT `case_victim_id` FROM `icms_case_victim_services` `icvs` WHERE `icvs`.`case_victim_services_is_active` = "1" AND `icvs`.`case_victim_services_id` IN ( (SELECT `icvsa`.`case_victim_services_id` FROM `icms_case_victim_services_agency_tag` `icvsa` WHERE `cvsa`.`case_victim_services_agency_tag_is_active` = "1"  AND  `icvsa`.`agency_branch_id` = ' . $_SESSION['userData']['agency_branch_id'] . ' ) )  ) )';
                break;
            case 4:
                $aParam['cTab'] = 'AND `ic`.`case_id` IN (SELECT `ictu`.`case_id` FROM `icms_case_tagged_users` `ictu` WHERE `ictu`.`user_id` = ' . $_SESSION['userData']['user_id'] . ' AND `ictu`.`case_tagged_users_status` = 1)';
                break;
        }

        if ($aParam['keyword'] !== "" || empty($aParam['keyword']) == false) {
            $aParam['keyword'] = str_replace("-", "+", $aParam['keyword']);
            $aParam['sRelevance'] = " , MATCH (`ic`.`case_number`) AGAINST ('+" . $aParam['keyword'] . "*' IN BOOLEAN MODE)  as all_relevance ";
            $aParam['cOrderBy'] = ' `all_relevance`, ';

            $victim_no = ""; 
            $victim_name= ""; 
            $case_no = ""; 

            $victim_no = "  `icv`.`victim_id` IN (SELECT `victim_id` FROM icms_victim WHERE MATCH (`victim_number`) AGAINST ('+" . $aParam['keyword'] . "*' IN BOOLEAN MODE)) ";
            $victim_name = " OR `icv`.`victim_id` IN (SELECT `victim_id` FROM icms_victim_info WHERE MATCH (`victim_info_first_name`,`victim_info_middle_name`,`victim_info_last_name`,`victim_info_suffix`) AGAINST ('+" . $aParam['keyword'] . "*' IN BOOLEAN MODE)) ";
            $case_no = "OR (MATCH (`ic`.`case_number`) AGAINST ('+" . $aParam['keyword'] . "*' IN BOOLEAN MODE)) ";

            $aParam['cRelevance'] = " 
                AND ( ". $victim_no." ". $victim_name." ". $case_no." )
            ";
            // exit($aParam['cRelevance']);
        }

        $aResult = $this->Case_model->getAllCaseLists($aParam);

        if ($aResult['count'] > 0) {
            foreach ($aResult['listing'] as $key => $val) {
                $aResult['listing'][$key]['victim_id'] = $this->yel->encrypt_param($this->Case_model->getVictimIDByCaseId($val['case_id']));
                $aResult['listing'][$key]['case_id'] = $this->yel->encrypt_param($val['case_id']);
            }
            $aResponse['content'] = $aResult;
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
        }

        return $aResponse;
    }

    public function getCreatedCase($aParam) {
        $aParam['userid'] = $this->yel->getUserIDByAccessKey($_SESSION['userData']['accessKey']);
        $agencyTypeId = $this->Case_model->getAgencyTypeBasedOnUserId($aParam['userid']);
        $agencyIds = $this->Case_model->getAllAgencyIdUnderAgencyType($agencyTypeId['govt_agency_type_id']);
        $aIDs = [];
        foreach ($agencyIds as $key => $val) {
            array_push($aIDs, $val['govt_agency_id']);
        }
        $conditionAgencyids = implode(',', $aIDs);


        $user_id_per_agency = $this->Case_model->getAllUserIdPerAgencyID($conditionAgencyids);

        $condition_user_id = [];
        foreach ($user_id_per_agency as $key => $val) {
            array_push($condition_user_id, $val['user_id']);
        }

        $aParam['condition_user_id'] = implode(',', $condition_user_id);

        $aResponse = $this->Case_model->getCreatedCase($aParam);
        foreach ($aResponse['list'] as $key => $val) {
            $agencyType = $this->Case_model->getAgencyTypeBasedOnUserId($val['case_added_by']);
            $aResponse['list'][$key]['agency_added_by'] = $agencyType['govt_agency_type_name'];

            $agencyBranch = $this->Case_model->getAgencyBranchBasedOnUserId($val['case_added_by']);
            $aResponse['list'][$key]['branch_added_by'] = $agencyBranch['govt_agency_branch_name'];

            $aResponse['list'][$key]['user_added_by'] = $this->Case_model->getUserDetailsTypeBasedOnUserId($val['case_added_by']);
            $aResponse['list'][$key]['modified_by'] = $this->Case_model->getAgencyTypeBasedOnUserId($val['case_modified_by']);
            $aResponse['list'][$key]['case_date_added'] = date("F d, Y", strtotime($val['case_date_added']));
            $aResponse['list'][$key]['victims'] = $this->Case_model->getVictimListByCaseID($val['case_id']);
            unset($aResponse['list'][$key]['case_id']);
        }
        return $aResponse;
    }

    public function getTaggedCase($aParam) {
        $aParam['userid'] = $this->yel->getUserIDByAccessKey($_SESSION['userData']['accessKey']);

        $agencyTypeId = $this->Case_model->getAgencyTypeBasedOnUserId($aParam['userid']);
        $agencyIds = $this->Case_model->getAllAgencyIdUnderAgencyType($agencyTypeId['govt_agency_type_id']);
        $aIDs = [];
        foreach ($agencyIds as $key => $val) {
            array_push($aIDs, $val['govt_agency_id']);
        }
        $conditionAgencyids = implode(',', $aIDs);
        $aParam['conditionAgencyids'] = $conditionAgencyids;
        $user_id_per_agency = $this->Case_model->getAllUserIdPerAgencyID($conditionAgencyids);
        $condition_user_id = [];
        foreach ($user_id_per_agency as $key => $val) {
            array_push($condition_user_id, $val['user_id']);
        }

        $aParam['condition_user_id'] = implode(',', $condition_user_id);
        $caseIds = $this->Case_model->getCaseIdByUserIdAndAgencyId($aParam);
        $condition_case_id = [];
        foreach ($caseIds as $key => $val) {
            array_push($condition_case_id, $val['case_id']);
        }
        $aParam['condition_case_id'] = implode(',', $condition_case_id);

        $aResponse = $this->Case_model->getTaggedCase($aParam);
        foreach ($aResponse['list'] as $key => $val) {
            $agencyType = $this->Case_model->getAgencyTypeBasedOnUserId($val['case_added_by']);
            $aResponse['list'][$key]['agency_added_by'] = $agencyType['govt_agency_type_name'];

            $agencyBranch = $this->Case_model->getAgencyBranchBasedOnUserId($val['case_added_by']);
            $aResponse['list'][$key]['branch_added_by'] = $agencyBranch['govt_agency_branch_name'];

            $aResponse['list'][$key]['user_added_by'] = $this->Case_model->getUserDetailsTypeBasedOnUserId($val['case_added_by']);
            $aResponse['list'][$key]['modified_by'] = $this->Case_model->getAgencyTypeBasedOnUserId($val['case_modified_by']);
            $aResponse['list'][$key]['case_date_added'] = date("F d, Y", strtotime($val['case_date_added']));
            $aResponse['list'][$key]['victims'] = $this->Case_model->getVictimListByCaseID($val['case_id']);
            unset($aResponse['list'][$key]['case_id']);
        }
        return $aResponse;
    }

    /*
     * Decode Parameter 
     */

    private function getDecodedParam($aParam) {
        $aResult['victim_exist_victim_id'] = NULL;

        if (empty($aParam['caseParameters']['victim_exist_victim_id']) == false) {
            $aResult['victim_exist_victim_id'] = $this->yel->decrypt_param($aParam['caseParameters']['victim_exist_victim_id']);
        }

        $aResponse = array(
            'victim_exist_victim_id' => $aResult['victim_exist_victim_id'],
            'recommended_priority_level' => $aParam['caseParameters']['recommended_priority_level'] ?? '',
            'victim_personal_info' => $this->decodeParam($aParam['caseParameters']['victim_personal_info']),
            'victim_personal_contact_info' => $this->decodeParam($aParam['caseParameters']['victim_personal_contact_info']),
            'victim_personal_relative_info' => $this->decodeParam($aParam['caseParameters']['victim_personal_relative_info']),
            'victim_personal_education_info' => $this->decodeParam($aParam['caseParameters']['victim_personal_education_info']),
            'victim_personal_address_info' => $this->decodeParam($aParam['caseParameters']['victim_personal_address_info']),
            'victim_employment_info' => $this->decodeParam($aParam['caseParameters']['victim_employment_info']),
            'victim_employer_details' => $this->decodeParam($aParam['caseParameters']['victim_employer_details']),
            'victim_recruitment_details' => $this->decodeParam($aParam['caseParameters']['victim_recruitment_details']),
            'victim_passport_details' => $this->decodeParam($aParam['caseParameters']['victim_passport_details']),
            'victim_deployment_details' => $this->decodeParam($aParam['caseParameters']['victim_deployment_details']),
            'victim_transit_info' => $this->decodeParam($aParam['caseParameters']['victim_transit_info']),
            'victim_complainant_details' => $this->decodeParam($aParam['caseParameters']['victim_complainant_details']),
            'victim_offender_details' => $this->decodeParam($aParam['caseParameters']['victim_offender_details']),
            'victim_case_details' => $aParam['caseParameters']['victim_case_details'],
            'victim_case_evaluation_details' => $this->decodeParam($aParam['caseParameters']['victim_case_evaluation_details']),
            'victim_services_info' => $aParam['caseParameters']['victim_services_info'],
            'document_attachment_info' => $this->decodeParam($aParam['caseParameters']['document_attachment_info']),
        );

        /*
         * Decrypt_param id's if exist
         */

        // Local Agency Id
        if ((empty($aParam['victim_recruitment_details']['local_agency_id']) == false) || ($aResponse['victim_recruitment_details']['local_agency_id'] !== '0')) {
            $aResponse['victim_recruitment_details']['local_agency_id'] = $this->yel->decrypt_param($aResponse['victim_recruitment_details']['local_agency_id']);
        }

        // Foreign Agency Id
        if ((empty($aParam['victim_recruitment_details']['foreign_agency_id']) == false) || ($aResponse['victim_recruitment_details']['foreign_agency_id'] !== '0')) {
            $aResponse['victim_recruitment_details']['foreign_agency_id'] = $this->yel->decrypt_param($aResponse['victim_recruitment_details']['foreign_agency_id']);
        }

        // Employer Agency Id
        if ((empty($aParam['victim_employer_details']['employer_id']) == false) || ($aResponse['victim_employer_details']['employer_id'] !== '0')) {
            $aResponse['victim_employer_details']['employer_id'] = $this->yel->decrypt_param($aResponse['victim_employer_details']['employer_id']);
        }

        // sanitize
        $aResponse['content'] = $this->yel->fix_html_entities($aResponse);

        // validate required parameters 
        $aResponse['flag'] = $this->validateParameters($aResponse);
        $aResponse['flag'] = true;
        
        return $aResponse;
    }

    /*
     * Validate Parameters 
     * Validate Required Parameters
     * @aParam array 
     * @rs array 
     */

    public function validateParameters($aParam) {

        /*         * For victim_personal_info         */
        $aCheck = $aParam['victim_personal_info'];
        // Rules 
        $aRules = array(
            'first_name' => 'required',
            'last_name' => 'required',
            //'dob' => 'required',
            'sex_value' => 'required',
            'civil_value' => 'required',
        );
        // Validate 
        $aAssert = $this->assert->formValidate($aCheck, $aRules);
        $aResponse['php_validation'] = $aAssert;
        // Return Value 
        if ($aAssert['flag'] != self::ACTIVE_STATUS) {
            return self::FAILED_RESPONSE;
        }

        /*         * For victim_personal_address_info         */
        $aCheck = $aParam['victim_personal_address_info'];

        if (empty($aCheck)) {
            return self::FAILED_RESPONSE;
        }

        /*         * For victim_employment_info         */
        $aCheck = $aParam['victim_employment_info'];
        // Rules 
        $aRules = array(
            'act_country' => 'required',
        );
        // Validate 
        $aAssert = $this->assert->formValidate($aCheck, $aRules);
        $aResponse['php_validation'] = $aAssert;
        // Return Value 
        if ($aAssert['flag'] != self::ACTIVE_STATUS) {
            return self::FAILED_RESPONSE;
        }

        /*         * For victim_deployment_details         */
        $aCheck = $aParam['victim_deployment_details'];
        // Rules 
        $aRules = array(
            'deployment_date' => 'required',
            'deployment_departure_type' => 'required',
        );
        // Validate 
        $aAssert = $this->assert->formValidate($aCheck, $aRules);
        $aResponse['php_validation'] = $aAssert;
        // Return Value 
        if ($aAssert['flag'] != self::ACTIVE_STATUS) {
            return self::FAILED_RESPONSE;
        }
        
         /*         * For victim_complainant_details         */
        $aCheck = $aParam['victim_complainant_details'];
        // Rules 
        $aRules = array(
            'complainant_source' => 'required',
        );
        // Validate 
        $aAssert = $this->assert->formValidate($aCheck, $aRules);
        $aResponse['php_validation'] = $aAssert;
        // Return Value 
        if ($aAssert['flag'] != self::ACTIVE_STATUS) {
            return self::FAILED_RESPONSE;
        }

        return self::ACTIVE_STATUS;
    }

    /**
     * Add New Case
     * 
     * @param array $aParam
     * @return array
     * 
     */
    public function __addCase($aParam) {

        $aRepsonse = [];
        $taggedAgencyBranches = [];

        $aResponse['flag'] = self::FAILED_RESPONSE;

        if (empty($_SESSION['userData']) !== true) {

            // Decode Parameter 
            $aNewParam = $this->getDecodedParam($aParam);

            // Add Report / Case 
            $aResponse['add_case'] = $this->Case_model->addCase($aNewParam);

            // Initialize case_id 
            $aNewParam['case_id'] = $aResponse['add_case']['insert_id'];

            // add case number 
            $aNewParam['case_number'] = $this->Case_model->addCaseNumber($aNewParam);
            $aResponse['case_number'] = $aNewParam['case_number'];

            /*             * Register Victim if not exist *         */
            if ($aNewParam['victim_exist_victim_id'] === NULL) {
                $aResponse['add_victim'] = $this->addNewVictim($aNewParam, $aResponse);
                $aNewParam['victim_id'] = $aResponse['add_victim'];
                // update victim numnber 
                $aResponse['victim_number'] = $this->Case_model->addVictimNumber($aNewParam);
                $aNewParam['victim_number'] = $aResponse['victim_number'];
            } else {
                // Initialize victim_id if exist
                $aNewParam['victim_id'] = $aNewParam['victim_exist_victim_id'];
                // get victim number 
                $aNewParam['victim_number'] = $this->Case_model->getVictimNumberByVictimId($aNewParam['victim_id']);
                $aResponse['victim_number'] = $aNewParam['victim_number'];
            }

            /*             * Add/Update Victim Information          */
            $aResponse['add_update_victim_info'] = $this->addCaseVictimInformation($aNewParam, $aResponse);

            /*             *  Add case victim         */
            $aResponse['add_caseVictim'] = $this->addCaseVictim($aNewParam, $aResponse);
            $aNewParam['case_victim_id'] = $aResponse['add_caseVictim'];

            /*             * For Local recruitment agency          */
            $aNewParam['local_agency_id'] = $this->addCaseLocalRecruitmentAgency($aNewParam, $aResponse);

            /*             * For Foreign recruitment agency          */
            $aNewParam['foreign_agency_id'] = $this->addCaseForeignRecruitmentAgency($aNewParam, $aResponse);

            /*             * For Employer       */
            $aNewParam['employer_id'] = $this->addCaseEmployer($aNewParam, $aResponse);

            /*             *  Employment           */
            $aResponse['add_employment'] = $this->addCaseEmployment($aNewParam, $aResponse);
            $aNewParam['case_victim_employment_id'] = $aResponse['add_employment'];

            /*             * Employment Details         */
            $aResponse['add_employment_details'] = $this->addCaseEmploymentDetails($aNewParam, $aResponse);

            /*             * Deployment Details         */
            $aResponse['add_deployment'] = $this->addCaseDeployment($aNewParam, $aResponse);

            /*             * Passport Details         */
            $aResponse['add_passport'] = $this->addCasePassport($aNewParam, $aResponse);

            /*             * Transit Details         */
            $aResponse['add_transit_details'] = $this->addCaseTransit($aNewParam, $aResponse);

            /*             * Start Case Details          */

            /*             *  Complainant          */
            $aResponse['add_complainant'] = $this->addCaseComplainant($aNewParam, $aResponse);

            /*             *  Offender          */
            $aResponse['add_offender'] = $this->addCaseOffender($aNewParam, $aResponse);

            /*             * Case TIP Details         */
            $aResponse['add_tip_details'] = $this->addCaseTIPDetails($aNewParam, $aResponse);

            /*             * Services         */
            $aResponse['add_service'] = $this->addCaseService($aNewParam, $aResponse);

            /*             * Documents         */
            $aResponse['add_documents'] = $this->addCaseDocuments($aNewParam, $aResponse);

            /*             * Tagged Assignee             */
            $aResponse['tagged_assignee'] = $this->setAssigneeByCaseId($aNewParam);

            if ($aResponse['add_case']['stat'] == 1) {
                $aResponse['flag'] = self::SUCCESS_RESPONSE;
            }
        }

        return $aResponse;
    }

    public function savingDetailsFromChecker($aParam) {
        $aResponse = [];
        $aResult = [];
        $aResponse['flag'] = self::FAILED_RESPONSE;

        /**
         * Parameter Validation
         */
        $aRules = array(
            'case_checker_id' => 'required',
            'stage' => 'required'
        );
        $aAssert = $this->assert->formValidate($aParam, $aRules);
        $aResponse['php_validation'] = $aAssert;
        if ($aAssert['flag'] != self::ACTIVE_STATUS) {
            return $aResponse;
        }

        $aNewParam = $this->getCaseDataCheckerById($aParam);

        switch (intval($aParam['stage'])) {
            case '1':
                /*                 * Add/Update Victim Information          */
                $aResponse['add_update_victim_info'] = $this->addCaseVictimInformation($aNewParam);
                if ($aResponse['add_update_victim_info']['flag'] == 1) {
                    $aResponse['flag'] = self::SUCCESS_RESPONSE;
                }
                break;
            case '2':
                /*                 *  Add case victim         */
                $aResponse['add_caseVictim'] = $this->addCaseVictim($aNewParam, $aResponse);
                $aNewParam['case_victim_id'] = $aResponse['add_caseVictim'];
                if ($aResponse['add_caseVictim'] != '0') {
                    $aResponse['flag'] = self::SUCCESS_RESPONSE;
                }
                break;
            case '3':
                /*                 * For Local recruitment agency          */
                $aNewData = [];
                $aNewData = $this->addCaseLocalRecruitmentAgency($aNewParam);
                if ($aNewData['flag'] != '0') {
                    $aNewParam['local_agency_id'] = $aNewData['local_agency_id'];
                    $aResponse['flag'] = self::SUCCESS_RESPONSE;
                }
                break;
            case '4':
                /*                 * For Foreign recruitment agency          */
                $aNewData = [];
                $aNewData = $this->addCaseForeignRecruitmentAgency($aNewParam);
                if ($aNewData['flag'] != '0') {
                    $aNewParam['foreign_agency_id'] = $aNewData['foreign_agency_id'];
                    $aResponse['flag'] = self::SUCCESS_RESPONSE;
                }
                break;
            case '5':
                /*                 * For Employer       */
                $aNewData = [];
                $aNewData = $this->addCaseEmployer($aNewParam);
                if ($aNewData['flag'] != '0') {
                    $aNewParam['employer_id'] = $aNewData['employer_id'];
                    $aResponse['flag'] = self::SUCCESS_RESPONSE;
                }
                break;
            case '6':
                /*                 *  Employment           */
                $aResponse['add_employment'] = $this->addCaseEmployment($aNewParam);
                $aNewParam['case_victim_employment_id'] = $aResponse['add_employment'];
                if ($aNewParam['case_victim_employment_id'] != '0') {
                    $aResponse['flag'] = self::SUCCESS_RESPONSE;
                }
                break;
            case '7':
                /*                 * Employment Details         */
                $aResponse['add_employment_details'] = $this->addCaseEmploymentDetails($aNewParam);
                if ($aNewParam['case_victim_employment_id'] != '0') {
                    $aResponse['flag'] = self::SUCCESS_RESPONSE;
                }
                break;
            case '8':
                /*                 * Deployment Details         */
                $aResponse['add_deployment'] = $this->addCaseDeployment($aNewParam);
                if ($aResponse['add_deployment'] != '0') {
                    $aResponse['flag'] = self::SUCCESS_RESPONSE;
                }
                break;
            case '9':
                /*                 * Passport Details         */
                $aResponse['add_passport'] = $this->addCasePassport($aNewParam);
                if ($aResponse['add_passport'] != '0') {
                    $aResponse['flag'] = self::SUCCESS_RESPONSE;
                }
                break;
            case '10':
                /*                 * Transit Details         */
                $aResponse['add_transit_details'] = $this->addCaseTransit($aNewParam);
                if ($aResponse['add_transit_details'] != '0') {
                    $aResponse['flag'] = self::SUCCESS_RESPONSE;
                }
                break;
            /*             * Start Case Details          */
            case '11':
                /*                 *  Complainant          */
                $aResponse['add_complainant'] = $this->addCaseComplainant($aNewParam);
                if ($aResponse['add_complainant'] != '0') {
                    $aResponse['flag'] = self::SUCCESS_RESPONSE;
                }
                break;
            case '12':
                /*                 *  Offender          */
                $aResponse['add_offender'] = $this->addCaseOffender($aNewParam);
                if ($aResponse['add_offender']['flag'] != '0') {
                    $aResponse['flag'] = self::SUCCESS_RESPONSE;
                }
                break;
            case '13':
                /*                 * Case TIP Details         */
                $aResponse['add_tip_details'] = $this->addCaseTIPDetails($aNewParam);
                if ($aResponse['add_tip_details']['flag'] != '0') {
                    $aResponse['flag'] = self::SUCCESS_RESPONSE;
                }
                break;
            case '14':
                /*                 * Services         */
                $aResponse['add_service'] = $this->addCaseService($aNewParam);
                if ($aResponse['add_service']['flag'] != '0') {
                    $aResponse['flag'] = self::SUCCESS_RESPONSE;
                }
                break;
            case '15':
                /*                 * Documents         */
                $aResponse['add_documents'] = $this->addCaseDocuments($aNewParam);
                if ($aResponse['add_documents']['flag'] != '0') {
                    $aResponse['flag'] = self::SUCCESS_RESPONSE;
                }
                break;
            case '16':
                /*                 * Tagged Assignee             */
                $aResponse['tagged_assignee'] = $this->setAssigneeByCaseId($aNewParam);
                if ($aResponse['tagged_assignee']['flag'] != '0') {
                    $aResponse['flag'] = self::SUCCESS_RESPONSE;
                }
                break;
            default:
        }

        // update 
        $aParam['case_checker_id'] = $this->yel->decrypt_param($aParam['case_checker_id']);
        $aParam['param'] = json_encode($aNewParam);
        $this->Case_model->setCaseDataCheckerById($aParam);

        $aResponse['case_number'] = $aNewParam['case_number'];
        $aResponse['victim_number'] = $aNewParam['victim_number'];

        return $aResponse;
    }

    /*
     * Add New Case
     * 
     * @param array $aParam
     * @return array 
     */

    public function addCase($aParam) {
        $aRepsonse = [];
        $aResult = [];
        $aResponse['flag'] = self::FAILED_RESPONSE;
        $aRepsonse['stat_info'] = [];
     

        if (empty($_SESSION['userData']) !== true) {
            // Decode Parameter 
            $aNewParam = $this->getDecodedParam($aParam);
            
            if ($aNewParam['flag'] == "0") {
                $aRepsonse['stat_info'] = 'Sorry, there was invalid inputs.';
                return $aRepsonse; 
            }
            
            $aNewParam = $aNewParam['content'];             

            foreach ($aNewParam as $key => $value) {
                if (is_array($value) === true && sizeof($value) > 0) {
                    $aNewParam[$key] = $this->yel->safe_mode_clean_array_walk_recursive($value);
                } else if (is_string($value) === true) {
                    $aNewParam[$key] = $this->yel->safe_mode_clean($value);
                }
            }

            // Json Encode 
            $aResult['param'] = json_encode($aNewParam);

            // Add Case Checker 
            $aResult['cheker'] = $this->Case_model->addCaseChecker($aResult);
            $aRepsonse['stat_info']['cheker'] = $aResult['cheker'];

            if ($aResult['cheker']['insert_id'] !== NULL) {

                // Add Report / Case 
                $aResult['add_case'] = $this->Case_model->addCase($aNewParam);
                $aRepsonse['stat_info']['add_case'] = $aResult['add_case'];

                if ($aResult['add_case']['insert_id'] !== NULL) {

                    // Initialize case_id 
                    $aNewParam['case_id'] = $aResult['add_case']['insert_id'];

                    // Update Case Status 
                    if($aParam['temporary_case_id'] !== '0'){
                        $aNewParam['temporary_case_id'] =  $this->yel->decrypt_param($aParam['temporary_case_id']);
                        $update_temp_case_id = $this->Case_model->setTemporaryCaseId($aNewParam);
                        if ($update_temp_case_id['stat'] == 1) {
                            $aNewParam['temporary_case_status_id'] = 3;
                            $update_status = $this->Temporary_case_model->updateTemporaryCaseStatusById($aNewParam);
                            //temporary case logs / remarks
                            $temp_case_number = $this->Temporary_case_model->getTemporaryCaseNumberByTemporaryCaseId($aNewParam);
                            $aNewParam['transaction_parameter_type_id'] = '12';
                            $aNewParam['transaction_parameter_count_id'] = $aNewParam['temporary_case_status_id'];
                            $temp_case_status_name = $this->Global_data_model->getTransactionParamaterNameByTypeAndCountId($aNewParam);
                
                            $aNewParam['temporary_case_remarks'] = 'Temporary case number (' . $temp_case_number . ') status has been updated to (' . $temp_case_status_name . ')';
                            $aNewParam['temporary_case_remarks_added_by'] = $_SESSION['userData']['user_id'];
                            $addTemporaryCaseAccessLog = $this->Temporary_case_model->AddTemporaryCaseRemarksBySystem($aNewParam);
                
                            //temporary case access logs
                            $aNewParam['temporary_case_access_log_description'] = $aNewParam['temporary_case_remarks'];
                            $addTemporaryCaseAccessLog = $this->Temporary_case_model->addTemporaryCaseAccessLog($aNewParam);
                        }
                    }

                    // Initialize case_checker_id
                    $aNewParam['case_checker_id'] = $aResult['cheker']['insert_id'];

                    // Json Encode 
                    $aNewParam['param'] = json_encode($aNewParam);

                    // Update Case Checker Case Id
                    $aResult['case_cheker_update'] = $this->Case_model->setCaseDataCheckerCaseIdById($aNewParam);
                    $aRepsonse['stat_info']['case_cheker_update'] = $aResult['case_cheker_update'];

                    // Check Update Checker Stat is okay 
                    if ($aResult['case_cheker_update']['stat'] == '1') {
                        $aResponse['flag'] = self::SUCCESS_RESPONSE;
                        $aResponse['checker_id'] = $this->yel->encrypt_param($aNewParam['case_checker_id']);
                        $aRepsonse['stat_info'] = 'Okay';

                        // Add Case Number 
                        $aResult['case_number'] = $this->addCaseNumber($aResponse);
                         
                    }
                }
            }
        } else {
            $aRepsonse['stat_info'] = 'Session has been expired.';
        }
        return $aResponse;
    }

    public function addCaseNumber($aParam) {
        $aResponse = [];
        $aResult = [];
        $aNewParam = [];

        $aResponse['stat_info'] = [];
        $aResponse['flag'] = self::FAILED_RESPONSE;
        
       $aParam["case_checker_id"] = isset($aParam["checker_id"]) ? $aParam["checker_id"] : $aParam["case_checker_id"];
       
       /**
         * Parameter Validation
         */
        $aRules = array(
            'case_checker_id' => 'required'
        );
        $aAssert = $this->assert->formValidate($aParam, $aRules);
        $aResponse['php_validation'] = $aAssert;
        if ($aAssert['flag'] != self::ACTIVE_STATUS) {
            $aResponse['stat_info'] = 'Incomplete parameters';
            return $aResponse;
        }
        
        /*
         * Initialize Parameter 
         */
        $aNewParam = $this->getCaseDataCheckerById($aParam);
        $aResponse['stat_info'] = 'There is something wrong in your data.';

        /*
         * Add Case Number 
         */
        if ($aNewParam !== '0') {
            $aResult['case_number'] = $this->Case_model->addCaseNumber($aNewParam);
            $aResponse['stat_info'] = $aResult['case_number'];
            if ($aResult['case_number']['response']['stat'] == '1') {
                // Initialize Case Number 
                $aNewParam['case_number'] = $aResult['case_number']['case_number'];

                // update checker 
                $aParam['case_checker_id'] = $this->yel->decrypt_param($aParam['case_checker_id']);
                $aParam['param'] = json_encode($aNewParam);
                $aResult['case_cheker_update'] = $this->Case_model->setCaseDataCheckerById($aParam);
                $aResponse['stat_info'] = $aResult['case_cheker_update'];

                // Check Update Checker Stat is okay 
                if ($aResult['case_cheker_update']['stat'] == '1') {
                    $aResponse['flag'] = self::SUCCESS_RESPONSE;
                    //$aResponse['checker_id'] = $aNewParam['case_checker_id'];
                    $aResponse['stat_info'] = 'Okay';
                }
            }
        }

        return $aResponse;
    }

    public function addVictim($aParam) {
        $aResponse = [];
        $aResult = [];
        $aNewParam = [];

        $aResponse['stat_info'] = [];
        $aResponse['flag'] = self::FAILED_RESPONSE;

        /**
         * Parameter Validation
         */
        $aRules = array(
            'case_checker_id' => 'required'
        );
        $aAssert = $this->assert->formValidate($aParam, $aRules);
        $aResponse['php_validation'] = $aAssert;
        if ($aAssert['flag'] != self::ACTIVE_STATUS) {
            $aResponse['stat_info'] = 'Incomplete parameters';
            return $aResponse;
        }

        /*
         * Initialize Parameter 
         */
        $aNewParam = $this->getCaseDataCheckerById($aParam);
        $aResponse['stat_info'] = 'There is something wrong in your data.';
       
        if ($aNewParam !== '0') {
            /*             * Register Victim if not exist *         */
            if (($aNewParam['victim_exist_victim_id'] === NULL) || ($aNewParam['victim_exist_victim_id'] == "")) {
                $aResponse['add_victim'] = $this->addNewVictim($aNewParam);
                $aResponse['stat_info'] = $aResponse['add_victim'];

                // check 
                if ($aResponse['add_victim']['flag'] == '1') {
                    $aNewParam['victim_id'] = $aResponse['add_victim']['victim_id'];
                    $aRepsonse['flag'] = self::SUCCESS_RESPONSE;
                }
            }

            /*             * Update Victim if exist *         */ else {
                // Initialize victim_id if exist           
                $aNewParam['victim_id'] = $aNewParam['victim_exist_victim_id'];
                // get victim number 
                $aNewParam['victim_number'] = $this->Case_model->getVictimNumberByVictimId($aNewParam['victim_id']);
                $aResponse['victim_number'] = $aNewParam['victim_number'];
                $aRepsonse['flag'] = self::SUCCESS_RESPONSE;
            }

            // update checker 
            $case_checker_id = $aParam['case_checker_id'];
            $aParam['case_checker_id'] = $aNewParam['case_checker_id'];
            $aParam['param'] = json_encode($aNewParam);
            $aResult['case_cheker_update'] = $this->Case_model->setCaseDataCheckerById($aParam);
            $aResponse['stat_info'] = $aResult['case_cheker_update'];

            // Check Update Checker Stat is okay 
            if ($aResult['case_cheker_update']['stat'] == '1') {
                $aResponse['flag'] = self::SUCCESS_RESPONSE;
                $aResponse['checker_id'] = $aNewParam['case_checker_id'];
                $aResponse['stat_info'] = 'Okay';
                $aParam['case_checker_id'] = $case_checker_id;
                $aResponse['victim_number'] = $this->addVictimNumber($aParam);
            }
        }

        return $aResponse;
    }

    public function addVictimNumber($aParam) {

        $aResponse = [];
        $aResult = [];
        $aNewParam = [];

        $aResponse['stat_info'] = [];
        $aResponse['flag'] = self::FAILED_RESPONSE;

        /**
         * Parameter Validation
         */
        $aRules = array(
            'case_checker_id' => 'required'
        );
        $aAssert = $this->assert->formValidate($aParam, $aRules);
        $aResponse['php_validation'] = $aAssert;
        if ($aAssert['flag'] != self::ACTIVE_STATUS) {
            $aResponse['stat_info'] = 'Incomplete parameters';
            return $aResponse;
        }

        /*
         * Initialize Parameter 
         */
        $aNewParam = $this->getCaseDataCheckerById($aParam);
        $aResponse['stat_info'] = 'There is something wrong in your data.';

        if ($aNewParam !== '0') {

            if (($aNewParam['victim_exist_victim_id'] === NULL) || ($aNewParam['victim_exist_victim_id'] == "")) {
                // update victim numnber 
                $aResponse['victim_number'] = $this->Case_model->addVictimNumber($aNewParam);
                $aResponse['stat_info'] = $aResponse['victim_number'];
                if ($aResponse['victim_number']['response']['stat'] == '1') {
                    $aNewParam['victim_number'] = $aResponse['victim_number']['victim_number'];
                    $aResponse['victim_number'] = $aResponse['victim_number']['victim_number'];
                    $aResponse['flag'] = self::SUCCESS_RESPONSE;
                }
            } else {
                // Initialize victim_id if exist
                $aNewParam['victim_id'] = $aNewParam['victim_exist_victim_id'];
                // get victim number 
                $aNewParam['victim_number'] = $this->Case_model->getVictimNumberByVictimId($aNewParam['victim_id']);
                $aResponse['victim_number'] = $aNewParam['victim_number'];
                $aResponse['flag'] = self::SUCCESS_RESPONSE;
            }

            // update checker 
            $aParam['case_checker_id'] = $aNewParam['case_checker_id'];
            $aParam['param'] = json_encode($aNewParam);
            $aResult['case_cheker_update'] = $this->Case_model->setCaseDataCheckerById($aParam);
            $aResponse['stat_info'] = $aResult['case_cheker_update'];

            // Check Update Checker Stat is okay 
            if ($aResult['case_cheker_update']['stat'] == '1') {
                //$aResponse['checker_id'] = $aNewParam['case_checker_id'];
                $aResponse['stat_info'] = 'Okay';
            }
        }

        return $aResponse;
    }

    private function getCaseDataCheckerById($aParam) {
        $aResponse = [];
        $aParam['case_checker_id'] = $this->yel->decrypt_param($aParam['case_checker_id']);
        if ($aParam['case_checker_id']) {
            $aResponse = $this->Case_model->getCaseDataCheckerById($aParam);
            $aResponse = $this->isJson($aResponse);
            $aResponse = json_decode($aResponse, true);
            return $aResponse;
        } else {
            return self::FAILED_RESPONSE;
        }
    }

    private function isJson($string) {

        $string = substr($string, 1, -1);
        json_decode(json_encode($string), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return self:: FAILED_RESPONSE;
        } else {
            return json_decode(json_encode($string), true);
        }
    }

    private function setAssigneeByCaseId($aParam) {
        $aResponse = [];
        $aResult = [];
        $aLog_info = [];
        $aResult['flag'] = self::FAILED_RESPONSE;
        $aParam['inp_user_id'] = $_SESSION['userData']['user_id'];
        $aParam['user_id'] = $_SESSION['userData']['user_id'];
        $aParam['status'] = 1;
        $aParam['email'] = $_SESSION['userData']['user_email'];
        $aParam['fname'] = $_SESSION['userData']['user_firstname'];
        $aParam['case_number'] = $this->Assignee_model->getCaseNumberByCaseId($aParam);
        $aParam['user_info'] = $this->Users_model->getUsersInfobyID($aParam);


        $aResult['res'] = $this->Assignee_model->addCaseTagged($aParam);

        $aNotif = [];
        $aNotif['receiver'] = $aParam['user_id'];
        $aNotif['method'] = "view_victim_services";
        $aNotif['notif_type'] = "1";
        $aNotif['tbl_id'] = $aParam['case_id'];
        $aNotif['msg'] = "You have been tagged to ";
        $aNotif['msg'] .= "case report <orange><a href='update_case/" . $this->yel->encrypt_param($aParam['case_id']) . "'>" . $aParam['case_number'] . "</a></orange>";
        $this->notif->create($aNotif);

        $aEmail = [];
        $aEmail['to'] = $aParam['email'];
        $aEmail['subject'] = 'Report tagged';
        $aEmail['message'] = 'Hi ' . $aParam['fname'] . ',  <br><br> You have been tagged to report number (' . $aParam['case_number'] . ')  <br>';
        $aEmail['message'] .= '<br>To view details of the case, login to ICMS using your account and search using the report number.<br>';
        $aResponse['mail'] = $this->mailbox->sendMail($aEmail);

        // For Add
        $aLog['module_primary_id'] = $aParam['case_id'];

        $aLog_info['log_event_type'] = 19;
        $aParam['tag'] = '';
        $aLog_info['log_message'] = " tagged " . $aParam['user_info']['user_firstname'] . ' ' . $aParam['user_info']['user_lastname'] . " to case report " . $aParam['case_number'];

        //saving logs for user details
        $result = "0";
        if ($aResult['res']['stat'] == "1") {
            $result = "1";
            $aLog_info['log_link'] = 'update_case/' . $this->yel->encrypt_param($aParam['case_id']);
            $aResult['log'] = $this->audit->create($aLog_info);
            $aResult['flag'] = self::SUCCESS_RESPONSE;
        }

        $aResponse = $aResult;
        return $aResponse;
    }

    /**
     * Decode Encrypted Array from Javascript
     * 
     * @param type $string
     * @return array
     */
    private function decodeParam($string) {
        $aResponse = [];
        if (!empty($string)) {
            $aResponse = json_decode(base64_decode($string), true);
        }
        return $aResponse;
    }

    public function getCaseInforById($aParam) {
        $aResponse = [];
        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);
        $aResponse['case_details'] = $this->Case_model->getCaseDetailsById($aParam);


        $aResponse['case_details']['victim_list'] = $this->Case_model->getVictimlistById($aParam['case_id']);
        foreach ($aResponse['case_details']['victim_list'] as $k => $v) {
            $aReal = $this->Victims_model->getVictimRealNamebyId($v['victim_id']);
            $aResponse['case_details']['victim_list'][$k] = $aReal;
            if (count($aReal) <= 0) {
                $aResponse['case_details']['victim_list'][$k] = $this->Victims_model->getVictimAssumedNamebyId($v['victim_id']);
            }
            $aParam['case_victim_id'] = $v['case_victim_id'];
            $aParam['case_victim_tip_type_id'] = '2';
            $aResponse['case_details']['victim_list'][$k]['case_victim_id'] = $this->yel->encrypt_param($v['case_victim_id']);
            $aResponse['case_details']['victim_list'][$k]['case_victim_date_added'] = $v['case_victim_date_added'];
            $aResponse['case_details']['victim_list'][$k]['tip_purpose'] = $this->Victims_model->getCaseVictimTIPDetailsByCaseVictimIdAndTIPType($aParam);

            unset($aResponse['case_details']['victim_list'][$k]['victim_id']);
        }
        return $aResponse;
    }

    public function updateCaseVictimInfoByVictimId($aParam) {
        $aResponse = [];
        $aResponse['flag'] = self::FAILED_RESPONSE;

        $aParam['victim_id'] = $this->yel->decrypt_param($aParam['victim_id']);
        $aResponse['updateVictimInfo'] = $this->Victims_model->updateVictimInfoByVictimId($aParam);
        $aResponse['updateAssumedVictimInfo'] = $this->Victims_model->updateAssumedVictimInfoByVictimId($aParam);

        if ($aResponse['updateAssumedVictimInfo']['stat'] == 1) {
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
        }

        return $aResponse;
    }

    public function getEmploymentInfoByCaseVictimId($aParam) {
        $aResponse = [];
        $aResponse['flag'] = self::FAILED_RESPONSE;
        $aParam = $this->yel->clean_array($aParam);

        $aParam['case_victim_id'] = $this->yel->decrypt_param($aParam['case_victim_id']);

        $aResponse['case_victim_employment'] = $this->Case_model->getCaseVictimEmploymentByCaseVictimId($aParam);
        $aParam['case_victim_employment_id'] = $aResponse['case_victim_employment']['case_victim_employment_id'];
        $aParam['employer_id'] = $aResponse['case_victim_employment']['employer_id'];
        $aParam['recruitment_agency_id_local'] = $aResponse['case_victim_employment']['recruitment_agency_id_local'];
        $aParam['recruitment_agency_id_foreign'] = $aResponse['case_victim_employment']['recruitment_agency_id_foreign'];

        $aResponse['case_victim_employment_details'] = $this->Case_model->getCaseVictimEmploymentDetailsByEmploymentId($aParam);
        $aResponse['case_victim_employment_details_actual'] = $this->Case_model->getCaseVictimEmploymentDetailsActualByEmploymentId($aParam);

        $aResponse['case_victim_employment_employer'] = $this->Case_model->getCaseVictimEmploymentEmployerByEmployerId($aParam);

        $aResponse['case_victim_local_recruitment'] = $this->Case_model->getCaseVictimLocalRecruitmentById($aParam);
        $aResponse['case_victim_foreign_recruitment'] = $this->Case_model->getCaseVictimForeignRecruitmentById($aParam);

        $aResponse['case_victim_deployment'] = $this->Case_model->getCaseVictimDeploymentByCaseVictimId($aParam);

        $aResponse['case_victim_passport'] = $this->Case_model->getCaseVictimPassportByCaseVictimId($aParam);

        $aResponse['case_victim_transit'] = $this->Case_model->getCaseVictimTransitByCaseVictimId($aParam);
        if (!empty($aResponse['case_victim_transit'])) {
            $cnt = 0;
            foreach ($aResponse['case_victim_transit'] as $val) {
                $aResponse['case_victim_transit'][$cnt]['case_victim_transit_id'] = $this->yel->encrypt_param($val['case_victim_transit_id']);
                $cnt++;
            }
        }

        $aResponse['case_victim_employment']['case_victim_employment_id'] = $this->yel->encrypt_param($aParam['case_victim_employment_id']);
        $aResponse['case_victim_employment_details']['case_victim_employment_id'] = $this->yel->encrypt_param($aParam['case_victim_employment_id']);
        $aResponse['case_victim_employment_details_actual']['case_victim_employment_id'] = $this->yel->encrypt_param($aParam['case_victim_employment_id']);

        $aResponse['case_victim_employment_details']['case_victim_employment_details_id'] = $this->yel->encrypt_param($aResponse['case_victim_employment_details']['case_victim_employment_details_id']);
        $aResponse['case_victim_employment_details_actual']['case_victim_employment_details_id'] = $this->yel->encrypt_param($aResponse['case_victim_employment_details_actual']['case_victim_employment_details_id']);


        return $aResponse;
    }

    public function addVictimTransitInfo($aParam) {

        $aParam['case_victim_id'] = $this->yel->decrypt_param($aParam['case_victim_id']);
        $aResponse['flag'] = self::FAILED_RESPONSE;

        $aResponse['victim_transit_info'] = $this->Case_model->addVictimTransitInfo($aParam);

        if ($aResponse['victim_transit_info']['stat'] == 1) {
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
        }

        return $aResponse;
    }

    public function getEmploymentInformation($aParam) {
        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);
        $aParam['case_victim_id'] = $this->Case_model->getCaseVictimIdByCaseId($aParam);
        $aResponse = $this->Case_model->getEmploymentInformation($aParam);
        return $aResponse;
    }

    public function setCaseVictimEmploymentDetails($aParam) {

        // initialize
        $aResponse = [];

        // sanitize
        $aParam = $this->yel->fix_html_entities($aParam);
        $aParam = $this->yel->safe_mode_clean_array($aParam);


        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);
        $aParam['caseid'] = $aParam['case_id'];
        $case_number = $this->Case_details_model->getCaseNumberByCaseId($aParam);

        //update icms_case_victim_employment
        $isUpdated = $this->Case_model->setVictimEmploymentType($aParam);
        $aLog = [];
        if ($isUpdated['stat'] == "1") {
            if ($aParam['is_documented'] == "1") {
                $aLog['old_data'] = array("status" => "Undocumented");
                $aLog['new_data'] = array("status" => "Documented");
            } else {
                $aLog['old_data'] = array("status" => "Documented");
                $aLog['new_data'] = array("status" => "Undocumented");
            }

            $aLog['log_event_type'] = 49;
            $aLog['log_message'] = "update employment type for the case report <a href='update_case/" . $this->yel->encrypt_param($aParam['case_id']) . "'>" . $case_number . "</a> details";
            $aLog['log_action'] = 2; // 1= new inserted // 2=update table
            $aLog['new_data'] = $this->yel->encrypt_param(json_encode($aLog['new_data']));
            $aLog['old_data'] = $this->yel->encrypt_param(json_encode($aLog['old_data']));
            $aLog['module_primary_id'] = $aParam['case_id'];
            $aLog['sub_module_primary_id'] = $aParam['datacveid'];
            $aResponse['log'] = $this->audit->create($aLog);
        }

        //update employment details
        $aLog['old_data'] = $this->Case_model->getEmploymentDetails($aParam);
        $aResponse['set_details'] = $this->Case_model->setCaseVictimEmploymentDetails($aParam);
        $aLog['new_data'] = $this->Case_model->getEmploymentDetails($aParam);
        $aLog['log_event_type'] = 65;
        $aLog['log_message'] = "update employment details for the case report <a href='update_case/" . $this->yel->encrypt_param($aParam['case_id']) . "'>" . $case_number . "</a> details";
        $aLog['log_action'] = 2; // 1= new inserted // 2=update table
        $aLog['new_data'] = $this->yel->encrypt_param(json_encode($aLog['new_data']));
        $aLog['old_data'] = $this->yel->encrypt_param(json_encode($aLog['old_data']));
        $aLog['module_primary_id'] = $aParam['case_id'];
        $aLog['sub_module_primary_id'] = $aParam['datacvedetid'];
        $aResponse['log'] = $this->audit->create($aLog);

        return $aResponse;
    }

    public function getEmployerInformation($aParam) {
        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);
        $aParam['case_victim_id'] = $this->Case_model->getCaseVictimIdByCaseId($aParam);
        $aResponse = $this->Case_model->getEmployerInformation($aParam);
        return $aResponse;
    }

    public function setCaseVictimEmployerDetails($aParam) {

        // initialize
        $aResponse = [];

        // sanitize
        $aParam = $this->yel->fix_html_entities($aParam);
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);
        $aParam['caseid'] = $aParam['case_id'];

        $case_number = $this->Case_details_model->getCaseNumberByCaseId($aParam);

        if (isset($aParam['emp_id']) == true && empty($aParam['emp_id']) == false) {
            // update 
            // decrypt employer id 
            $empId = $this->yel->decrypt_param($aParam['emp_id']);
            if ($empId) {
                $aParam['emp_id'] = $empId;
                $aResponse['employer'] = $this->Case_model->setCaseVictimEmployer($aParam);
            }
        } else {
            // register new 
            $empId = $this->Case_model->addEmployerInManageReport($aParam);
            $aParam['emp_id'] = $empId['insert_id'];
            $set = $this->Case_model->setCaseVictimEmployer($aParam);
        }

        $aLog['old_data'] = $this->Case_model->getEmployerInformationByEmployerId($aParam);
        $aResponse['set_details'] = $this->Case_model->setCaseVictimEmployerDetails($aParam);
        $aLog['new_data'] = $this->Case_model->getEmployerInformationByEmployerId($aParam);

        $aLog['log_event_type'] = 40;
        $aLog['log_message'] = "update employer details for the case report <a href='update_case/" . $this->yel->encrypt_param($aParam['case_id']) . "'>" . $case_number . "</a> details";
        $aLog['log_action'] = 2; // 1= new inserted // 2=update table
        $aLog['new_data'] = $this->yel->encrypt_param(json_encode($aLog['new_data']));
        $aLog['old_data'] = $this->yel->encrypt_param(json_encode($aLog['old_data']));
        $aLog['module_primary_id'] = $aParam['case_id'];
        $aLog['sub_module_primary_id'] = $aParam['emp_id'];
        $aResponse['log'] = $this->audit->create($aLog);

        return $aResponse;
    }

    public function getRecruitmentInformation($aParam) {
        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);
        $aParam['caseid'] = $aParam['case_id'];
        $aParam['case_victim_id'] = $this->Case_model->getCaseVictimIdByCaseId($aParam);

        if ($aParam['rect_type'] == "1") { // local
            $aResponse = $this->Case_model->getRecruitmentInformation_local($aParam);
        } else {
            $aResponse = $this->Case_model->getRecruitmentInformation_foreign($aParam);
        }
        return $aResponse;
    }

    public function setRecruitmentDetails($aParam) {

        // initialize
        $aResponse = [];

        // sanitize
        $aParam = $this->yel->fix_html_entities($aParam);
        $aParam = $this->yel->safe_mode_clean_array($aParam);


        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);
        $aParam['caseid'] = $aParam['case_id'];
        $case_number = $this->Case_details_model->getCaseNumberByCaseId($aParam);

        if (isset($aParam['agn_id']) == true && empty($aParam['agn_id']) == false) {
            // update 
            // decrypt employer id 
            $agnId = $this->yel->decrypt_param($aParam['agn_id']);
            if ($agnId) {
                $aParam['agn_id'] = $agnId;

                if ($aParam['rec_type'] == '1') {
                    // local
                    $aResponse['recruitment_agency_local'] = $this->Case_model->setCaseVictimEmploymentLocalAgency($aParam);
                } else {
                    // foreign 
                    $aResponse['recruitment_agency_foreign'] = $this->Case_model->setCaseVictimEmploymentForeignAgency($aParam);
                }
            }
        } else {
// register new 

            if ($aParam['rec_type'] == '1') {
                // local
                $agnId = $this->Case_model->addLocalRecruitmentAgencyByManage($aParam);
                $aParam['agn_id'] = $agnId['insert_id'];
                $aResponse['register_local_rec'] = $agnId;
                $aResponse['recruitment_agency_local'] = $this->Case_model->setCaseVictimEmploymentLocalAgency($aParam);

                $aResponse['representative'] = $this->Case_model->addLocalRecAgencyRepByMngReport($aParam);
                $aResponse['owner'] = $this->Case_model->addLocalRecAgencyOwnerByMngReport($aParam);
                $aResponse['agent'] = $this->Case_model->addLocalRecAgencyAgentByMngReport($aParam);

                $aResponse['set_details'] = $this->Case_model->setLocalRecruitmentDetails($aParam);
            } else {
                // foreign 
                $agnId = $this->Case_model->addForeignRecruitmentAgencyByManage($aParam);
                $aParam['agn_id'] = $agnId['insert_id'];
                $aResponse['register_local_rec'] = $agnId;
                $aResponse['recruitment_agency_foreign'] = $this->Case_model->setCaseVictimEmploymentForeignAgency($aParam);

                $aResponse['representative'] = $this->Case_model->addForeignRecAgencyRepByMngReport($aParam);
                $aResponse['owner'] = $this->Case_model->addForeignRecAgencyOwnerByMngReport($aParam);

                $aResponse['set_details'] = $this->Case_model->setForeignRecruitmentDetails($aParam);
            }
        }

        $aLog = [];
        $aLog['old_data'] = $this->Case_model->getRecruitmentDetailsByRecruitmentId($aParam);

        if ($aLog['old_data']['recruitment_agency_is_local'] == '1') {
            $aResponse['representative'] = $this->Case_model->setLocalRecAgencyRepByMngReport($aParam);
            $aResponse['owner'] = $this->Case_model->setLocalRecAgencyOwnerByMngReport($aParam);
            $aResponse['agent'] = $this->Case_model->setLocalRecAgencyAgentByMngReport($aParam);
            $aResponse['set_details'] = $this->Case_model->setLocalRecruitmentDetails($aParam);
        } else {
            $aResponse['representative'] = $this->Case_model->setForeignRecAgencyRepByMngReport($aParam);
            $aResponse['owner'] = $this->Case_model->setForeignRecAgencyOwnerByMngReport($aParam);
            $aResponse['set_details'] = $this->Case_model->setForeignRecruitmentDetails($aParam);
        }

        $aLog['new_data'] = $this->Case_model->getRecruitmentDetailsByRecruitmentId($aParam);
        $aLog['log_event_type'] = 28;
        $aLog['log_message'] = "update recruitment agency details for the case report <a href='update_case/" . $this->yel->encrypt_param($aParam['case_id']) . "'>" . $case_number . "</a> details";
        $aLog['log_action'] = 2; // 1= new inserted // 2=update table
        $aLog['new_data'] = $this->yel->encrypt_param(json_encode($aLog['new_data']));
        $aLog['old_data'] = $this->yel->encrypt_param(json_encode($aLog['old_data']));
        $aLog['module_primary_id'] = $aParam['case_id'];
        $aLog['sub_module_primary_id'] = $aParam['agn_id'];
        $aResponse['log'] = $this->audit->create($aLog);
        return $aResponse;
    }

    public function getDeploymentDetails($aParam) {
        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);
        $aParam['caseid'] = $aParam['case_id'];
        $aParam['case_victim_id'] = $this->Case_model->getCaseVictimIdByCaseId($aParam);
        $aResponse = $this->Case_model->getDeploymentDetails($aParam);
        if (isset($aResponse['case_victim_deployment_date']) == true && empty($aResponse['case_victim_deployment_date']) == false) {
            $deploy = explode("-", $aResponse['case_victim_deployment_date']);
            $aResponse['case_victim_deployment_date'] = $deploy[1] . "/" . $deploy[2] . "/" . $deploy[0];
        }
        if (isset($aResponse['case_victim_deployment_arrival_date']) == true && empty($aResponse['case_victim_deployment_arrival_date']) == false) {
            $arrival = explode("-", $aResponse['case_victim_deployment_arrival_date']);
            $aResponse['case_victim_deployment_arrival_date'] = $arrival[1] . "/" . $arrival[2] . "/" . $arrival[0];
        }else {
            $aResponse['case_victim_deployment_arrival_date'] = '';
        }
        
        return $aResponse;
    }

    private function getLabelPriorityLevelById($id) {
        switch ($id) {
            case '1':
                $sLevel = 'Low priority';
                break;
            case '2':
                $sLevel = 'Midium priority';
                break;
            case '3':
                $sLevel = 'High priority';
                break;
        }
        return $sLevel;
    }

    public function setCasePriorityLevel($aParam) {
        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);
        $aParam['caseid'] = $aParam['case_id'];
        $case_number = $this->Case_details_model->getCaseNumberByCaseId($aParam);

        $aLog['old_data'] = array('Priority Level' => $this->getLabelPriorityLevelById($aParam['old_level_id']));
        $aResponse['details'] = $this->Case_model->setCasePriorityLevel($aParam);
        $aLog['new_data'] = array('Priority Level' => $this->getLabelPriorityLevelById($aParam['level_id']));

        $aLog['log_event_type'] = 171;
        $aLog['log_message'] = "update case priority level for the case report <a href='update_case/" . $this->yel->encrypt_param($aParam['case_id']) . "'>" . $case_number . "</a> details";
        $aLog['log_action'] = 2; // 1= new inserted // 2=update table
        $aLog['new_data'] = $this->yel->encrypt_param(json_encode($aLog['new_data']));
        $aLog['old_data'] = $this->yel->encrypt_param(json_encode($aLog['old_data']));
        $aLog['module_primary_id'] = $aParam['case_id'];
        $aResponse['log'] = $this->audit->create($aLog);

        return $aResponse;
    }

    public function setDeploymentDetails($aParam) {

        // initialize
        $aResponse = [];

        // sanitize
        $aParam = $this->yel->fix_html_entities($aParam);
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);
        $aParam['caseid'] = $aParam['case_id'];

//        if (isset($aParam['deployment_date']) == true && empty($aParam['deployment_date']) == false) {
//            $ddate = explode('/', $aParam['deployment_date']);
//            $aParam['deployment_date'] = $ddate[2] . "-" . $ddate[0] . "-" . $ddate[1];
//        } else {
//            $aParam['deployment_date'] = "1970-01-01";
//        }
//        if (isset($aParam['arrival_date']) == true && empty($aParam['arrival_date']) == false) {
//            $ddate = explode('/', $aParam['arrival_date']);
//            $aParam['arrival_date'] = $ddate[2] . "-" . $ddate[0] . "-" . $ddate[1];
//        } else {
//            $aParam['arrival_date'] = "1970-01-01";
//        }

        $case_number = $this->Case_details_model->getCaseNumberByCaseId($aParam);
        $aLog = [];
        $aLog['old_data'] = $this->Case_model->getDeploymentDetailsByDeploymentID($aParam);
        $aResponse['set_details'] = $this->Case_model->setDeploymentDetails($aParam);
        $aLog['new_data'] = $this->Case_model->getDeploymentDetailsByDeploymentID($aParam);
        $aLog['log_event_type'] = 66;
        $aLog['log_message'] = "update deployment details for the case report <a href='update_case/" . $this->yel->encrypt_param($aParam['case_id']) . "'>" . $case_number . "</a> details";
        $aLog['log_action'] = 2; // 1= new inserted // 2=update table
        $aLog['new_data'] = $this->yel->encrypt_param(json_encode($aLog['new_data']));
        $aLog['old_data'] = $this->yel->encrypt_param(json_encode($aLog['old_data']));
        $aLog['module_primary_id'] = $aParam['case_id'];
        $aLog['sub_module_primary_id'] = $aParam['deployment_id'];
        $aResponse['log'] = $this->audit->create($aLog);
        return $aResponse;
    }

    public function getPassportDetails($aParam) {
        $aResponse = [];
        $aParam['case_id'] = $this->yel->decrypt_param($aParam['case_id']);
        $aParam['caseid'] = $aParam['case_id'];
        $aParam['case_victim_id'] = $this->Case_model->getCaseVictimIdByCaseId($aParam);

        $aResponse['passport'] = $this->Case_model->getPassportDetails($aParam);
        $aResponse['result'] = '0';
        $aResponse['case_victim_id'] = $aParam['case_victim_id'];
        if (empty($aResponse['passport']) == false && isset($aResponse['passport']['victim_passport_id']) == true) {
            $aResponse['result'] = '1';
            if (isset($aResponse['victim_passport_date_issued']) == true && empty($aResponse['victim_passport_date_issued']) == false) {
                $deploy = explode("-", $aResponse['victim_passport_date_issued']);
                $aResponse['victim_passport_date_issued'] = $deploy[1] . "/" . $deploy[2] . "/" . $deploy[0];
            }
            if (isset($aResponse['victim_passport_date_expired']) == true && empty($aResponse['victim_passport_date_expired']) == false) {
                $arrival = explode("-", $aResponse['victim_passport_date_expired']);
                $aResponse['victim_passport_date_expired'] = $arrival[1] . "/" . $arrival[2] . "/" . $arrival[0];
            }
            if (isset($aResponse['victim_passport_dob']) == true && empty($aResponse['victim_passport_dob']) == false) {
                $arrival = explode("-", $aResponse['victim_passport_dob']);
                $aResponse['victim_passport_dob'] = $arrival[1] . "/" . $arrival[2] . "/" . $arrival[0];
            }
        }
        return $aResponse;
    }

    /*
     * Add New Victin 
     * @aParam type array $aParam
     * @return array
     */

    private function addNewVictim($aNewParam) {

        $aResponse = [];
        $aResponse['flag'] = self::FAILED_RESPONSE;

        // Add New Victim 
        $aResponse['add_victim'] = $this->Case_model->addVictim($aNewParam);
        $aResponse['stat_info'] = $aResponse['add_victim'];

        if ($aResponse['add_victim']['stat'] == '1') {

            // ini $aNewParam['victim_id'] 
            $aNewParam['victim_id'] = $aResponse['add_victim']['insert_id'];
            $aResponse['victim_id'] = $aResponse['add_victim']['insert_id'];

            //victim personal info
            $aResponse['add_victimInfo'] = $this->Case_model->addVictimInfo($aNewParam);
            $aResponse['stat_info'] = $aResponse['add_victimInfo'];

            // check 
            if (($aResponse['add_victimInfo']['real']['stat'] == '1') && ($aResponse['add_victimInfo']['assume']['stat'] == '1')) {
                $aResponse['flag'] = self::SUCCESS_RESPONSE;
                $aResponse['stat_info'] = 'Okay';
            }
        }

        return $aResponse;
    }

    private function addCaseVictimInformation($aNewParam) {

        $aResponse = [];

        $aResponse['flag'] = self::FAILED_RESPONSE;

        //victim contact
        if (empty($aNewParam['victim_personal_contact_info']) == false) {
            foreach ($aNewParam['victim_personal_contact_info'] as $key => $val) {
                if (!empty($val['conctact_details_id']) !== false) {
                    $val['conctact_details_id'] = $this->yel->decrypt_param($val['conctact_details_id']);
                    if ($val['status'] == '1') {
                        /*                         *  Update Victim Information                          */
                        $aParam['victim_contact_details_id'] = $val['conctact_details_id'];
                        $aLog = [];
                        $aLog['old_data'] = $this->Victims_model->getVictimContactInfoByContactId($aParam);
                        $aResponse['update_victimContact'] = $this->Case_model->updateVictimContact($aNewParam, $val);
                        $aLog['new_data'] = $this->Victims_model->getVictimContactInfoByContactId($aParam);

                        if ($aResponse['update_victimContact']['stat'] == 1) {
                            $aLog['log_event_type'] = 57;
                            $aLog['log_message'] = "update <a href='victim_list/" . $this->yel->encrypt_param($aNewParam['victim_id']) . "'>victim's</a> contact details";
                            $aLog['log_action'] = 2; // 1= new inserted // 2=update table
                            $aLog['new_data'] = $this->yel->encrypt_param(json_encode($aLog['new_data']));
                            $aLog['old_data'] = $this->yel->encrypt_param(json_encode($aLog['old_data']));
                            $aLog['module_primary_id'] = $aNewParam['case_id'];
                            $aLog['sub_module_primary_id'] = $aParam['victim_contact_details_id'];
                            $aResponse['log'] = $this->audit->create($aLog);
                        }
                    } else {
                        /*                         *  Remove Victim Information                          */
                        $aResponse['add_victimContact'] = $this->Case_model->updateVictimContact($aNewParam, $val);
                        if ($aResponse['add_victimContact']['stat'] == 1) {
                            // logs
                            $aLog = [];
                            $aLog['log_action'] = 1; // 1= new inserted // 2=update table
                            $aLog['log_event_type'] = 58; // base on table : icms_user_event_type
                            $aLog['log_message'] = "removed <a href='victim_list/" . $this->yel->encrypt_param($aNewParam['victim_id']) . "'>victim's </a> contact";
                            $aLog['module_primary_id'] = $aNewParam['case_id'];
                            $aLog['sub_module_primary_id'] = $val['conctact_details_id'];
                            $aResponse['log'] = $this->audit->create($aLog);
                        }
                    }
                } else {
                    /*                     * Add Victim Contact                      */
                    $aResponse['add_victimContact'] = $this->Case_model->addVictimContact($aNewParam, $val);
                    if ($aResponse['add_victimContact']['stat'] == 1) {
                        //add contact address of the victim
                        $aLog['log_event_type'] = 31; // base on table : icms_user_event_type
                        $aLog['log_message'] = "added <a href='victim_list/" . $this->yel->encrypt_param($aNewParam['victim_id']) . "'>victim's </a> contact person  for the case report <a href='update_case/" . $this->yel->encrypt_param($aNewParam['case_id']) . "'>" . $aNewParam['case_number'] . "</a>";
                        $aLog['module_primary_id'] = $aNewParam['case_id'];
                        $aLog['sub_module_primary_id'] = $aResponse['add_victimContact']['insert_id'];
                        $aResponse['log'] = $this->audit->create($aLog);
                    }
                }
            }
        } else {
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
        }
      
        //victim address
        if (empty($aNewParam['victim_personal_address_info']) == false) {
            foreach ($aNewParam['victim_personal_address_info'] as $key => $val) {
                if (!empty($val['address_id']) !== false) {
                    $val['address_id'] = $this->yel->decrypt_param($val['address_id']);
                    $aParam['victim_address_list_id'] = $val['address_id'];
                    if ($val['status'] == '1') {
                        /*                         *  Update Victim address info                          */
                        $aLog = [];
                        $aLog['old_data'] = $this->Victims_model->getVictimAddressInfoByAddressId($aParam);
                        $aResponse['update_victim_address_info'] = $this->Case_model->updateVictimAddress($aNewParam, $val);
                        $aLog['new_data'] = $this->Victims_model->getVictimAddressInfoByAddressId($aParam);

                        if ($aResponse['update_victim_address_info']['stat'] == 1) {
                            $aLog['log_event_type'] = 61;
                            $aLog['log_message'] = "update <a href='victim_list/" . $this->yel->encrypt_param($aNewParam['victim_id']) . "'>victim's address</a> information";
                            $aLog['log_action'] = 2; // 1= new inserted // 2=update table
                            $aLog['new_data'] = $this->yel->encrypt_param(json_encode($aLog['new_data']));
                            $aLog['old_data'] = $this->yel->encrypt_param(json_encode($aLog['old_data']));
                            $aLog['module_primary_id'] = $aNewParam['case_id'];
                            $aLog['sub_module_primary_id'] = $aParam['victim_address_list_id'];
                            $aResponse['log'] = $this->audit->create($aLog);
                        }
                    } else {
                        /*                         *  Remove Victim Information                          */
                        $aResponse['update_victim_address_info'] = $this->Case_model->updateVictimAddress($aNewParam, $val);
                        if ($aResponse['update_victim_address_info']['stat'] == 1) {
                            // logs
                            $aLog = [];
                            $aLog['log_action'] = 1; // 1= new inserted // 2=update table
                            $aLog['log_event_type'] = 77; // base on table : icms_user_event_type
                            $aLog['log_message'] = "removed <a href='victim_list/" . $this->yel->encrypt_param($aNewParam['victim_id']) . "'>victim's </a> address details";
                            $aLog['module_primary_id'] = $aNewParam['case_id'];
                            $aLog['sub_module_primary_id'] = $aParam['victim_address_list_id'];
                            $aResponse['log'] = $this->audit->create($aLog);
                        }
                    }
                } else {
                    $aResponse['add_victimAddress'] = $this->Case_model->addVictimAddress($aNewParam, $val);
                    //add address of the victim
                    $aLog['log_event_type'] = 53; // base on table : icms_user_event_type
                    $aLog['log_message'] = "added <a href='victim_list/" . $this->yel->encrypt_param($aNewParam['victim_id']) . "'>victim's </a> address for the case report <a href='update_case/" . $this->yel->encrypt_param($aNewParam['case_id']) . "'>" . $aNewParam['case_number'] . "</a>";
                    $aLog['module_primary_id'] = $aNewParam['case_id'];
                    $aLog['sub_module_primary_id'] = $aResponse['add_victimAddress']['insert_id'];
                    $aResponse['log'] = $this->audit->create($aLog);
                }
            }
        } else {
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
        }

        //victim education
        if (empty($aNewParam['victim_personal_education_info']) == false) {
            foreach ($aNewParam['victim_personal_education_info'] as $key => $val) {

                if (!empty($val['victim_education_id']) !== false) {
                    $val['victim_education_id'] = $this->yel->decrypt_param($val['victim_education_id']);
                    $aParam['victim_education_id'] = $val['victim_education_id'];
                    if ($val['status'] == '1') {
                        /*                         *  Update Victim Education                          */
                        $aLog = [];
                        $aLog['old_data'] = $this->Victims_model->getVictimEducationInfoById($aParam);
                        $aResponse['update_victimEducation'] = $this->Case_model->setVictimEducationById($aNewParam, $val);
                        $aLog['new_data'] = $this->Victims_model->getVictimEducationInfoById($aParam);

                        if ($aResponse['update_victimEducation']['stat'] == 1) {
                            $aLog['log_event_type'] = 59;
                            $aLog['log_message'] = "update <a href='victim_list/" . $this->yel->encrypt_param($aNewParam['victim_id']) . "'> victim's </a> educational background";
                            $aLog['log_action'] = 2; // 1= new inserted // 2=update table
                            $aLog['new_data'] = $this->yel->encrypt_param(json_encode($aLog['new_data']));
                            $aLog['old_data'] = $this->yel->encrypt_param(json_encode($aLog['old_data']));
                            $aLog['module_primary_id'] = $aNewParam['case_id'];
                            $aLog['sub_module_primary_id'] = $val['victim_education_id'];
                            $aResponse['log'] = $this->audit->create($aLog);
                        }
                    } else {
                        /*                         *  Remove Victim Education                          */
                        $aResponse['update_victimEducation'] = $this->Case_model->setVictimEducationById($aParam, $val);
                        if ($aResponse['update_victimEducation']['stat'] == 1) {
                            // logs
                            $aLog = [];
                            $aLog['log_action'] = 1; // 1= new inserted // 2=update table
                            $aLog['log_event_type'] = 79; // base on table : icms_user_event_type
                            $aLog['log_message'] = "removed <a href='victim_list/" . $this->yel->encrypt_param($aNewParam['victim_id']) . "'>victim's </a> educational background";
                            $aLog['module_primary_id'] = $aNewParam['victim_id'];
                            $aLog['sub_module_primary_id'] = $val['victim_education_id'];
                            $aResponse['log'] = $this->audit->create($aLog);
                        }
                    }
                } else {
                    $aResponse['add_victimEducation'] = $this->Case_model->addVictimEducation($aNewParam, $val);
                    if ($aResponse['add_victimEducation']['stat'] == 1) {
                        //add contact address of the victim
                        $aLog['log_event_type'] = 31; // base on table : icms_user_event_type
                        $aLog['log_message'] = "added <a href='victim_list/" . $this->yel->encrypt_param($aNewParam['victim_id']) . "'>victim's </a> education  for the case report <a href='update_case/" . $this->yel->encrypt_param($aNewParam['case_id']) . "'>" . $aNewParam['case_number'] . "</a>";
                        $aLog['module_primary_id'] = $aNewParam['case_id'];
                        $aLog['sub_module_primary_id'] = $aResponse['add_victimEducation']['insert_id'];
                        $aResponse['log'] = $this->audit->create($aLog);
                    }
                }
            }
        } else {
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
        }



        //victim relative/next of kin
        if (empty($aNewParam['victim_personal_relative_info']) == false) {
            foreach ($aNewParam['victim_personal_relative_info'] as $key => $val) {
                if (!empty($val['relative_id']) !== false) {
                    $val['relative_id'] = $this->yel->decrypt_param($val['relative_id']);
                    $aParam['victim_relative_id'] = $val['relative_id'];
                    if ($val['status'] == '1') {
                        /*                         *  Update Victim Relative                          */
                        $aLog = [];
                        $aLog['old_data'] = $this->Victims_model->getVictimRelativeInfoByRelativeId($aParam);
                        $aResponse['update_VictimRelative'] = $this->Case_model->updateVictimRelative($aNewParam, $val);
                        $aLog['new_data'] = $this->Victims_model->getVictimRelativeInfoByRelativeId($aParam);

                        if ($aResponse['update_VictimRelative']['stat'] == 1) {
                            $aLog['log_event_type'] = 63;
                            $aLog['log_message'] = "update <a href='victim_list/" . $this->yel->encrypt_param($aNewParam['victim_id']) . "'>victim's</a> next of kin details";
                            $aLog['log_action'] = 2; // 1= new inserted // 2=update table
                            $aLog['new_data'] = $this->yel->encrypt_param(json_encode($aLog['new_data']));
                            $aLog['old_data'] = $this->yel->encrypt_param(json_encode($aLog['old_data']));
                            $aLog['module_primary_id'] = $aNewParam['case_id'];
                            $aLog['sub_module_primary_id'] = $aParam['victim_relative_id'];
                            $aResponse['log'] = $this->audit->create($aLog);
                        }
                    } else {
                        /*                         *  Remove Victim Relative                         */
                        $aResponse['update_victimEducation'] = $this->Case_model->updateVictimRelative($aParam, $val);
                        if ($aResponse['update_victimEducation']['stat'] == 1) {
                            // logs
                            $aLog = [];
                            $aLog['log_action'] = 1; // 1= new inserted // 2=update table
                            $aLog['log_event_type'] = 80; // base on table : icms_user_event_type
                            $aLog['log_message'] = "added <a href='victim_list/" . $this->yel->encrypt_param($aNewParam['victim_id']) . "'>victim's </a> next of kin details";
                            $aLog['module_primary_id'] = $aNewParam['victim_id'];
                            $aLog['sub_module_primary_id'] = $aParam['victim_relative_id'];
                            $aResponse['log'] = $this->audit->create($aLog);
                        }
                    }
                } else {
                    $aResponse['add_victimRelative'] = $this->Case_model->addVictimRelative($aNewParam, $val);
                    //add victim's relative
                    $aLog['log_event_type'] = 33; // base on table : icms_user_event_type
                    $aLog['log_message'] = "added <a href='victim_list/" . $this->yel->encrypt_param($aNewParam['victim_id']) . "'>victim's </a> relative/next of kin  for the case report <a href='update_case/" . $this->yel->encrypt_param($aNewParam['case_id']) . "'>" . $aNewParam['case_number'] . "</a>";
                    $aLog['module_primary_id'] = $aNewParam['case_id'];
                    $aLog['sub_module_primary_id'] = $aResponse['add_victimRelative']['insert_id'];
                    $aResponse['log'] = $this->audit->create($aLog);
                }
            }
        } else {
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
        }

        $aResponse['flag'] = self::SUCCESS_RESPONSE;
        return $aResponse;
    }

    private function addCaseVictim($aNewParam) {

        $aResult['add_caseVictim'] = $this->Case_model->addCaseVictim($aNewParam);

        // Initialize case_victim_id 
        $aNewParam['case_victim_id'] = $aResult['add_caseVictim']['insert_id'];
        $aResponse['case_victim_id'] = $aNewParam['case_victim_id'];


        // Logs for Adding New Case 
        $aLog = [];
        $aLog['log_action'] = 1; // 1= new inserted // 2=update table
        //add new case id
        $aLog['log_event_type'] = 29; // base on table : icms_user_event_type
        $aLog['log_message'] = "added new case report <a href='update_case/" . $this->yel->encrypt_param($aNewParam['case_id']) . "'>" . $aNewParam['case_number'] . "</a>";
        $aLog['module_primary_id'] = $aNewParam['case_id'];
        $aLog['sub_module_primary_id'] = $aNewParam['case_id'];
        $aResponse['log'] = $this->audit->create($aLog);

        // Logs for Adding New Victim in Case 
        $aLog['log_event_type'] = 52; // base on table : icms_user_event_type
        $aLog['log_message'] = "added victim profile  <a href='victim_list/" . $this->yel->encrypt_param($aNewParam['victim_id']) . "'>" . $aNewParam['victim_number'] . "</a> for the case report <a href='update_case/" . $this->yel->encrypt_param($aNewParam['case_id']) . "'>" . $aNewParam['case_number'] . "</a>";
        $aLog['module_primary_id'] = $aNewParam['case_id'];
        $aLog['sub_module_primary_id'] = $aNewParam['victim_id'];
        $aResponse['log'] = $this->audit->create($aLog);

        // Logs for Adding Victim Profile
        $aLog['log_event_type'] = 30; // base on table : icms_user_event_type
        $aLog['log_message'] = "added victim profile  <a href='victim_list/" . $this->yel->encrypt_param($aNewParam['victim_id']) . "'>" . $aNewParam['victim_number'] . "</a> for the case report <a href='update_case/" . $this->yel->encrypt_param($aNewParam['case_id']) . "'>" . $aNewParam['case_number'] . "</a>";
        $aLog['module_primary_id'] = $aNewParam['case_id'];
        $aLog['sub_module_primary_id'] = $aNewParam['victim_id'];
        $aResponse['log'] = $this->audit->create($aLog);

        if ($_SESSION['userData']['user_level_id'] == "1") {
            //send email to iacat admin - no email to himself
            $agencyData = $this->session->userdata('userData');
            $aParam['agency_branch_id'] = $agencyData['agency_branch_id'];
            $adminBranchUsers = $this->Users_model->getAdminUsersByAgencyBranchId($aParam);
            //send system notification to iacat admin 
            $aNotif = [];
            $aNotif['method'] = "view_victim_services";
            $aNotif['tbl_id'] = $aNewParam['case_id'];
            $aNotif['receiver'] = 1;
            $aNotif['notif_type'] = "1";
            $aNotif['msg'] = "You have successfully ";
            $aNotif['msg'] .= " created a new case report <orange><a href='update_case/" . $this->yel->encrypt_param($aNewParam['case_id']) . "'>" . $aNewParam['case_number'] . "</a></orange>";
            $this->notif->create($aNotif);
        } else {
            //send email to admin
            $aEmail = [];
            $agencyData = $this->session->userdata('userData');
            $aParam['agency_branch_id'] = $agencyData['agency_branch_id'];
            $adminBranchUsers = $this->Users_model->getAdminUsersByAgencyBranchId($aParam);

            if (isset($adminBranchUsers['user_email']) == true) {

                $aEmail['to'] = $adminBranchUsers['user_email'];
                $aEmail['subject'] = 'New case added';
                $aEmail['message'] = 'Hi ' . $adminBranchUsers['user_firstname'] . ',  <br><br> A new case has been added in the system with case number (' . $aNewParam['case_number'] . ') by ' . $agencyData['user_firstname'] . ' ' . $agencyData['user_lastname'] . ' of ' . $agencyData['agency_name'] . ' (' . $agencyData['agency_branch_name'] . ').  <br>';
                $aEmail['message'] .= '<br>To view details of the case, login to ICMS using your account and search using the case number.<br>';
                $aResponse['mail'] = $this->mailbox->sendMail($aEmail);
                //send system notification to himself
                $aNotif = [];
                $aNotif['method'] = "view_victim_services";
                $aNotif['tbl_id'] = $aNewParam['case_id'];
                $aNotif['receiver'] = $_SESSION['userData']['user_id'];
                $aNotif['notif_type'] = "1";
                $aNotif['msg'] = "You have successfully ";
                $aNotif['msg'] .= " created a new case report <orange><a href='update_case/" . $this->yel->encrypt_param($aNewParam['case_id']) . "'>" . $aNewParam['case_number'] . "</a></orange>";
                $this->notif->create($aNotif);

                //send system notification to admin
                $aNotif = [];
                $aNotif['method'] = "view_victim_services";
                $aNotif['tbl_id'] = $aNewParam['case_id'];
                $aNotif['receiver'] = $adminBranchUsers['user_id'];
                $aNotif['notif_type'] = "1";
                $aNotif['msg'] = $agencyData['agency_name'] . ' (' . $agencyData['agency_branch_name'] . ') ';
                $aNotif['msg'] .= " created a new case report <orange><a href='update_case/" . $this->yel->encrypt_param($aNewParam['case_id']) . "'>" . $aNewParam['case_number'] . "</a></orange>";
                $this->notif->create($aNotif);
            }
        }

        $aLog = [];
        $aLog['log_event_type'] = 29; // base on table : icms_user_event_type
        $aLog['log_message'] = "added new report case " . $aNewParam['case_number'] . " and victim number " . $aNewParam['victim_number'];
        $aLog['log_link'] = 'case/' . $this->yel->encrypt_param($aNewParam['case_id']);
        $aLog['log_action'] = 1; // 1= new inserted // 2=update table
        $aLog['module_primary_id'] = $aNewParam['case_id'];
        $aLog['sub_module_primary_id'] = 15;
        $aResponse['log'] = $this->audit->create($aLog);

        return $aResponse['case_victim_id'];
    }

    private function addCaseLocalRecruitmentAgency($aNewParam) {
        $aResponse = [];
        $aResponse['flag'] = self::FAILED_RESPONSE;

        $aNewParam['local_agency_id'] = $aNewParam['victim_recruitment_details']['local_agency_id'];

        if (!empty($aNewParam['victim_recruitment_details']['local_agency_name']) == false) {
            $aResponse['local_agency_id'] = NULL;
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
            return $aResponse;
        }

        if (($aNewParam['victim_recruitment_details']['local_agency_id'] == '0') && (!empty($aNewParam['victim_recruitment_details']['local_agency_name']) == true)) {
            // var_dump($aNewParam);
            $aResponse['local_agency'] = $this->Case_model->addLocalRecruitmentAgency($aNewParam);
            $aResponse['local_agency'] = $this->Case_model->addLocalRecruitmentAgencyByManagePhilippines($aNewParam);
            $aNewParam['local_agency_id'] = $aResponse['local_agency']['insert_id'];
            $aResponse['local_agency_owner'] = $this->Case_model->addLocalRecruitmentAgencyOwner($aNewParam);
            $aResponse['local_agency_rep'] = $this->Case_model->addLocalRecruitmentAgencyRep($aNewParam);
            $aResponse['local_agency_agent'] = $this->Case_model->addLocalRecruitmentAgencyAgent($aNewParam);
        } else {
            $aResponse['set-local_agency'] = $this->Case_model->setLocalRecruitmentAgency($aNewParam);
            $aResponse['set-local_agency_owner'] = $this->Case_model->setLocalRecruitmentAgencyOwner($aNewParam);
            $aResponse['set-local_agency_rep'] = $this->Case_model->setLocalRecruitmentAgencyRep($aNewParam);
            $aResponse['set-local_agency_agent'] = $this->Case_model->setLocalRecruitmentAgencyAgent($aNewParam);
        }

        $aResponse['local_agency_id'] = $aNewParam['local_agency_id'];

        // logs : add local recruitment
        $aLog['log_event_type'] = 37; // base on table : icms_user_event_type
        $aLog['log_message'] = "added new <a href='recruitment_and_employer/lra/'" . $this->yel->encrypt_param($aNewParam['local_agency_id']) . ">Local recruitment agency details </a>";
        $aLog['log_message'] .= " of the  <a href='victim_list/" . $this->yel->encrypt_param($aNewParam['victim_id']) . "'>victim </a>";
        $aLog['log_message'] .= " for the case report <a href='update_case/" . $this->yel->encrypt_param($aNewParam['case_id']) . "'>" . $aNewParam['case_number'] . "</a>";
        $aLog['module_primary_id'] = $aNewParam['case_id'];
        $aLog['sub_module_primary_id'] = $aNewParam['local_agency_id'];
        $aResponse['log'] = $this->audit->create($aLog);

        $aResponse['flag'] = self::SUCCESS_RESPONSE;

        return $aResponse;
    }

    private function addCaseForeignRecruitmentAgency($aNewParam) {
        $aResponse = [];
        $aResponse['flag'] = self::FAILED_RESPONSE;

        $aNewParam['foreign_agency_id'] = $aNewParam['victim_recruitment_details']['foreign_agency_id'];

        if (!empty($aNewParam['victim_recruitment_details']['foreign_agency_name']) == false) {
            $aResponse['foreign_agency_id'] = NULL;
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
            return $aResponse;
        }

        if (($aNewParam['victim_recruitment_details']['foreign_agency_id'] == '0') && (!empty($aNewParam['victim_recruitment_details']['foreign_agency_name']) == true)) {
            $aResponse['foreign_agency'] = $this->Case_model->addForeignRecruitmentAgency($aNewParam);
            $aNewParam['foreign_agency_id'] = $aResponse['foreign_agency']['insert_id'];
            $aResponse['foreign_agency_owner'] = $this->Case_model->addForeignRecruitmentAgencyOwner($aNewParam);
            $aResponse['foreign_agency_rep'] = $this->Case_model->addForeignRecruitmentAgencyRep($aNewParam);
        } else {
            $aResponse['foreign_agency'] = $this->Case_model->setForeignRecruitmentAgency($aNewParam);
            $aResponse['foreign_agency_owner'] = $this->Case_model->setForeignRecruitmentAgencyOwner($aNewParam);
            $aResponse['foreign_agency_rep'] = $this->Case_model->setForeignRecruitmentAgencyRep($aNewParam);
        }

        $aResponse['foreign_agency_id'] = $aNewParam['foreign_agency_id'];

        // logs : add foreign recruitment
        $aLog['log_event_type'] = 37; // base on table : icms_user_event_type
        $aLog['log_message'] = "added new <a href='recruitment_and_employer/fra/'" . $this->yel->encrypt_param($aNewParam['foreign_agency_id']) . ">foreign recruitment agency details </a>";
        $aLog['log_message'] .= " of the  <a href='victim_list/" . $this->yel->encrypt_param($aNewParam['victim_id']) . "'>victim </a>";
        $aLog['log_message'] .= " for the case report <a href='update_case/" . $this->yel->encrypt_param($aNewParam['case_id']) . "'>" . $aNewParam['case_number'] . "</a>";
        $aLog['module_primary_id'] = $aNewParam['case_id'];
        $aLog['sub_module_primary_id'] = $aNewParam['foreign_agency_id'];
        $aResponse['log'] = $this->audit->create($aLog);

        $aResponse['flag'] = self::SUCCESS_RESPONSE;
        return $aResponse;
    }

    private function addCaseEmployer($aNewParam) {
        $aResponse = [];

        $aNewParam['employer_id'] = $aNewParam['victim_employer_details']['employer_id'];

        if (!empty($aNewParam['victim_employer_details']['employer_name']) == false) {
            $aResponse['employer_id'] = NULL;
            $aResponse['flag'] = self:: SUCCESS_RESPONSE;
            return $aResponse;
        }

        if (($aNewParam['victim_employer_details']['employer_id'] == '0') && (!empty($aNewParam['victim_employer_details']['employer_name']) == true)) {
            $aResponse['add_employer'] = $this->Case_model->addEmployer($aNewParam);
            $aNewParam['employer_id'] = $aResponse['add_employer']['insert_id'];
        } else {
            $aResponse['add_employer'] = $this->Case_model->setEmployer($aNewParam);
        }

        $aResponse['employer_id'] = $aNewParam['employer_id'];

        // logs : add employer details
        $aLog['log_event_type'] = 36; // base on table : icms_user_event_type
        $aLog['log_message'] = "added new <a href='recruitment_and_employer/emp/'" . $this->yel->encrypt_param($aNewParam['employer_id']) . ">employer details </a>";
        $aLog['log_message'] .= " of the  <a href='victim_list/" . $this->yel->encrypt_param($aNewParam['victim_id']) . "'>victim </a>";
        $aLog['log_message'] .= " for the case report <a href='update_case/" . $this->yel->encrypt_param($aNewParam['case_id']) . "'>" . $aNewParam['case_number'] . "</a>";
        $aLog['module_primary_id'] = $aNewParam['case_id'];
        $aLog['sub_module_primary_id'] = $aNewParam['employer_id'];
        $aResponse['log'] = $this->audit->create($aLog);

        $aResponse['flag'] = self:: SUCCESS_RESPONSE;

        return $aResponse;
    }

    private function addCaseEmployment($aNewParam) {
        $sResponse = '';

        // Check if $aNewParam['victim_employment_info']['is_documented'] exist, if not the default value is 1 
        if (empty($aNewParam['victim_employment_info']['is_documented']) == false) {
            $aNewParam['victim_employment_info']['is_documented'] = '1';
        } else {
            $aNewParam['victim_employment_info']['is_documented'] = '0';
        }

        $aResponse['add_employment'] = $this->Case_model->addEmployment($aNewParam);

        $sResponse = $aResponse['add_employment']['insert_id'];

        // logs : add employement type details
        $aLog['log_event_type'] = 35; // base on table : icms_user_event_type
        $aLog['log_message'] = "added employment type details";
        $aLog['log_message'] .= " of the  <a href='victim_list/" . $this->yel->encrypt_param($aNewParam['victim_id']) . "'>victim </a>";
        $aLog['log_message'] .= " for the case report <a href='update_case/" . $this->yel->encrypt_param($aNewParam['case_id']) . "'>" . $aNewParam['case_number'] . "</a>";
        $aLog['module_primary_id'] = $aNewParam['case_id'];
        $aLog['sub_module_primary_id'] = $aNewParam['victim_id'];
        $aResponse['log'] = $this->audit->create($aLog);

        return $sResponse;
    }

    private function addCaseEmploymentDetails($aNewParam) {
        $aResponse = [];
        $aResult = [];
        //Add Employment Details Based on the contract 
        $empType = "0";
        $aResponse['emp_details_contract'] = $this->Case_model->addEmploymentDetails($aNewParam, $empType);

        // Add Employment Details Based on  the actual 
        $aResponse['emp_details_actual'] = $this->Case_model->addEmploymentDetails_actualWork($aNewParam);

        // logs : add employement type details
        $aLog['log_event_type'] = 35; // base on table : icms_user_event_type
        $aLog['log_message'] = "added employment details ";
        $aLog['log_message'] .= " of the  <a href='victim_list/" . $this->yel->encrypt_param($aNewParam['victim_id']) . "'>victim </a>";
        $aLog['log_message'] .= " for the case report <a href='update_case/" . $this->yel->encrypt_param($aNewParam['case_id']) . "'>" . $aNewParam['case_number'] . "</a>";
        $aLog['module_primary_id'] = $aNewParam['case_id'];
        $aLog['sub_module_primary_id'] = $aResponse['emp_details_contract']['insert_id'] ?? 1;
        $aResponse['log'] = $this->audit->create($aLog);

        // logs : add employement type details actual work
        $aLog['log_event_type'] = 35; // base on table : icms_user_event_type
        $aLog['log_message'] = "added employment details(actual work) ";
        $aLog['log_message'] .= " of the  <a href='victim_list/" . $this->yel->encrypt_param($aNewParam['victim_id']) . "'>victim </a>";
        $aLog['log_message'] .= " for the case report <a href='update_case/" . $this->yel->encrypt_param($aNewParam['case_id']) . "'>" . $aNewParam['case_number'] . "</a>";
        $aLog['module_primary_id'] = $aNewParam['case_id'];
        $aLog['sub_module_primary_id'] = $aResponse['emp_details_actual']['insert_id'] ?? 1;
        $aResponse['log'] = $this->audit->create($aLog);

        $aResult['emp_details_actual'] = $aResponse['emp_details_actual']['insert_id'] ?? 1;
        $aResult['emp_details_contract'] = $aResponse['emp_details_contract']['insert_id'] ?? 1;

        $aResponse['flag'] = self::SUCCESS_RESPONSE;

        return $aResult;
    }

    private function addCaseDeployment($aNewParam) {
        $sResponse = '';

        //deployment details       
        if (empty($aNewParam['victim_deployment_details']['deployment_document_is_falsified']) == false) {
            $aNewParam['victim_deployment_details']['deployment_document_is_falsified'] = '1';
        } else {
            $aNewParam['victim_deployment_details']['deployment_document_is_falsified'] = '0';
        }

        // Add Deployment Details
        $aResponse['add_deployment'] = $this->Case_model->addDeployment($aNewParam);

        $sResponse = $aResponse['add_deployment']['insert_id'];

        // logs : add deployment  details
        $aLog['log_event_type'] = 38; // base on table : icms_user_event_type
        $aLog['log_message'] = "added deployment details ";
        $aLog['log_message'] .= " of the  <a href='victim_list/" . $this->yel->encrypt_param($aNewParam['victim_id']) . "'>victim </a>";
        $aLog['log_message'] .= " for the case report <a href='update_case/" . $this->yel->encrypt_param($aNewParam['case_id']) . "'>" . $aNewParam['case_number'] . "</a>";
        $aLog['module_primary_id'] = $aNewParam['case_id'];
        $aLog['sub_module_primary_id'] = $aResponse['add_deployment']['insert_id'];
        $aResponse['log'] = $this->audit->create($aLog);

        return $sResponse;
    }

    private function addCasePassport($aNewParam) {
        $sResponse = '';
        $aResponse['add_passport'] = $this->Case_model->addPassport($aNewParam);
        $sResponse = $aResponse['add_passport']['insert_id'];

        // logs : add deployment  details
        $aLog['log_event_type'] = 41; // base on table : icms_user_event_type
        $aLog['log_message'] = "added passport details ";
        $aLog['log_message'] .= " of the  <a href='victim_list/" . $this->yel->encrypt_param($aNewParam['victim_id']) . "'>victim </a>";
        $aLog['log_message'] .= " for the case report <a href='update_case/" . $this->yel->encrypt_param($aNewParam['case_id']) . "'>" . $aNewParam['case_number'] . "</a>";
        $aLog['module_primary_id'] = $aNewParam['case_id'];
        $aLog['sub_module_primary_id'] = $aResponse['add_passport']['insert_id'];
        $aResponse['log'] = $this->audit->create($aLog);

        return $sResponse;
    }

    private function addCaseTransit($aNewParam) {

        $aResult = [];

        $aResult['flag'] = self::FAILED_RESPONSE;

        if ($aNewParam['victim_transit_info'] != 'false') {
            foreach ($aNewParam['victim_transit_info'] as $key => $val) {
                $aResponse['add_transit'] = $this->Case_model->addTransit($aNewParam, $val);
                // logs : add deployment  details
                $aLog['log_event_type'] = 43; // base on table : icms_user_event_type
                $aLog['log_message'] = "added transit details ";
                $aLog['log_message'] .= " of the  <a href='victim_list/" . $this->yel->encrypt_param($aNewParam['victim_id']) . "'>victim </a>";
                $aLog['log_message'] .= " for the case report <a href='update_case/" . $this->yel->encrypt_param($aNewParam['case_id']) . "'>" . $aNewParam['case_number'] . "</a>";
                $aLog['module_primary_id'] = $aNewParam['case_id'];
                $aLog['sub_module_primary_id'] = $aResponse['add_transit']['insert_id'];
                $aResponse['log'] = $this->audit->create($aLog);
                $aResult['flag'] = self::SUCCESS_RESPONSE;
            }
        }

        return $aResult;
    }

    private function addCaseComplainant($aNewParam) {
        $sResponse = '';

        //complainant
        $aResponse['add_complainant'] = $this->Case_model->addComplainant($aNewParam);

        // logs : add complainant  details
        $aLog['log_event_type'] = 54; // base on table : icms_user_event_type
        $aLog['log_message'] = "added case complainant details ";
        $aLog['log_message'] .= " for the case report <a href='update_case/" . $this->yel->encrypt_param($aNewParam['case_id']) . "'>" . $aNewParam['case_number'] . "</a>";
        $aLog['module_primary_id'] = $aNewParam['case_id'];
        $aLog['sub_module_primary_id'] = $aResponse['add_complainant']['insert_id'];
        $aResponse['log'] = $this->audit->create($aLog);

        $sResponse = $aResponse['add_complainant']['insert_id'];

        return $sResponse;
    }

    private function addCaseOffender($aNewParam) {
        $aResult = [];

        $aResult['flag'] = self::FAILED_RESPONSE;

        //offender
        if (count($aNewParam['victim_offender_details']) > 0) {
            foreach ($aNewParam['victim_offender_details'] as $key => $val) {
                $aResponse['add_offender'] = $this->Case_model->addOffender($aNewParam, $val);
                // logs : add offender  details
                $aLog['log_event_type'] = 24; // base on table : icms_user_event_type
                $aLog['log_message'] = "added offender details ";
                $aLog['log_message'] .= " of the  <a href='victim_list/" . $this->yel->encrypt_param($aNewParam['victim_id']) . "'>victim </a>";
                $aLog['log_message'] .= " for the case report <a href='update_case/" . $this->yel->encrypt_param($aNewParam['case_id']) . "'>" . $aNewParam['case_number'] . "</a>";
                $aLog['module_primary_id'] = $aNewParam['case_id'];
                $aLog['sub_module_primary_id'] = $aResponse['add_offender']['insert_id'];
                $aResponse['log'] = $this->audit->create($aLog);
                $aResult['flag'] = self::SUCCESS_RESPONSE;
            }
        } else {
            $aResult['flag'] = self::SUCCESS_RESPONSE;
        }

        return $aResult;
    }

    private function addCaseTIPDetails($aNewParam) {

        $aResult = [];

        //acts
        $aResult['acts'] = self::FAILED_RESPONSE;
        $sDecode = html_entity_decode($aNewParam['victim_case_details']['acts']);
        $acts = json_decode($sDecode, true);

        if ($acts != 'false') {
            foreach ($acts as $key => $val) {
                $aResponse['add_acts'] = $this->Case_model->addCaseActTIP($aNewParam, $val);
                // logs : add offender  details
                $aLog['log_event_type'] = 55; // base on table : icms_user_event_type
                $aLog['log_message'] = "added case report details TIP:Act ";
                $aLog['log_message'] .= " for the case report <a href='update_case/" . $this->yel->encrypt_param($aNewParam['case_id']) . "'>" . $aNewParam['case_number'] . "</a>";
                $aLog['module_primary_id'] = $aNewParam['case_id'];
                $aLog['sub_module_primary_id'] = $aResponse['add_acts']['insert_id'];
                $aResponse['log'] = $this->audit->create($aLog);
                $aResult['acts'] = self::SUCCESS_RESPONSE;
            }
        }

        //means
        $aResult['means'] = self::FAILED_RESPONSE;
        $sDecode = html_entity_decode($aNewParam['victim_case_details']['means']);
        $means = json_decode($sDecode, true);

        if ($means != 'false') {
            foreach ($means as $key => $val) {
                $aResponse['add_means'] = $this->Case_model->addCaseMeanTIP($aNewParam, $val);
                // logs : add offender  details
                $aLog['log_event_type'] = 55; // base on table : icms_user_event_type
                $aLog['log_message'] = "added case report details TIP:Means ";
                $aLog['log_message'] .= " for the case report <a href='update_case/" . $this->yel->encrypt_param($aNewParam['case_id']) . "'>" . $aNewParam['case_number'] . "</a>";
                $aLog['module_primary_id'] = $aNewParam['case_id'];
                $aLog['sub_module_primary_id'] = $aResponse['add_means']['insert_id'];
                $aResponse['log'] = $this->audit->create($aLog);
                $aResult['means'] = self::SUCCESS_RESPONSE;
            }
        }


        //purposes
        $aResult['purpose'] = self::FAILED_RESPONSE;
        $sDecode = html_entity_decode($aNewParam['victim_case_details']['purposes']);
        $purposes = json_decode($sDecode, true);

        if ($purposes != 'false') {
            foreach ($purposes as $key => $val) {
                $aResponse['add_purposes'] = $this->Case_model->addCasePurposeTIP($aNewParam, $val);
                // logs : add offender  details
                $aLog['log_event_type'] = 55; // base on table : icms_user_event_type
                $aLog['log_message'] = "added case report details TIP:Purpose";
                $aLog['log_message'] .= " for the case report <a href='update_case/" . $this->yel->encrypt_param($aNewParam['case_id']) . "'>" . $aNewParam['case_number'] . "</a>";
                $aLog['module_primary_id'] = $aNewParam['case_id'];
                $aLog['sub_module_primary_id'] = $aResponse['add_purposes']['insert_id'];
                $aResponse['log'] = $this->audit->create($aLog);
                $aResult['purpose'] = self::SUCCESS_RESPONSE;
            }
        }

        $aResult['flag'] = self::SUCCESS_RESPONSE;

        return $aResult;
    }

    private function addCaseService($aNewParam) {

        $aResult = [];

        $aResult['flag'] = self::FAILED_RESPONSE;

        $is_notif = self::FAILED_RESPONSE;

        if ($aNewParam['victim_services_info'] != 'false') {
            foreach ($aNewParam['victim_services_info'] as $key => $val) {
                $aResponse['add_caseService'] = $this->Case_model->addCaseService($aNewParam, $val);
                $aNewParam['case_victim_services_id'] = $aResponse['add_caseService']['insert_id'];
                //tagged agency on services
                $sDecode = html_entity_decode($val['agency_json']);
                $agencies = json_decode($sDecode, true);
                $cnt = 0;
                if (count($agencies) > 0) {

                    //get agency services and range service terms 
                    $services = $this->Service_details_model->getServicesByServiceId($val['services']);
                    foreach ($agencies as $k => $v) {
                        $aResponse['add_servicesAgencies'] = $this->Case_model->addServicesAgency($aNewParam, $v);
                        $taggedAgencyBranches[$cnt] = $v['agency_id'];

                        //add details to icms_case_tagged _user 
                        $aResponse['tagged_agency'] = $this->Case_model->taggedAgencyBranchAdmin($aNewParam, $v);

                        // logs : tag agency
                        $aLog['log_event_type'] = 56; // base on table : icms_user_event_type
                        $agency_details = $this->Case_model->getAgencyDetailsToBeTagged($aNewParam, $v);
                        $aLog['log_message'] = " tagged " . $agency_details['agency_abbr'] . " - " . $agency_details['agency_branch_name'];
                        $aLog['log_message'] .= " for the case report <a href='update_case/" . $this->yel->encrypt_param($aNewParam['case_id']) . "'>" . $aNewParam['case_number'] . "</a>";
                        $aLog['module_primary_id'] = $aNewParam['case_id'];
                        $aLog['sub_module_primary_id'] = $aResponse['tagged_agency']['insert_id'];
                        $aResponse['log'] = $this->audit->create($aLog);


                        $aParam['agency_branch_id'] = $v['agency_id'];
                        $adminBranchUsers = $this->Users_model->getAdminUsersByAgencyBranchId($aParam);
                        if (isset($adminBranchUsers['user_id']) == true) {

                            // add system notification to agency admin
                            $aNotif = [];
                            $aNotif['method'] = "view_victim_services";
                            $aNotif['tbl_id'] = $aNewParam['case_id'];
                            $aNotif['receiver'] = $adminBranchUsers['user_id'];
                            $aNotif['notif_type'] = "1";
                            $aNotif['msg'] = "You have been tagged by ";
                            $aNotif['msg'] .= $_SESSION['userData']['agency_abbr'] . " - " . $_SESSION['userData']['agency_branch_name'];
                            $aNotif['msg'] .= " with case report <orange><a href='update_case/" . $this->yel->encrypt_param($aNewParam['case_id']) . "'>" . $aNewParam['case_number'] . "</a></orange>";
                            $aNotif['msg'] .= ' for "' . $services['service_name'] . '"';
                            $test = $this->notif->create($aNotif);

                            //add email notif to agency admin                       
                            $aEmail = [];
                            $aEmail['to'] = $adminBranchUsers['user_email'];
                            $aEmail['subject'] = 'New case added';
                            $aEmail['message'] = 'Hi ' . $adminBranchUsers['user_firstname'] . ',  <br><br> You added a new report in the system with report number (' . $aNewParam['case_number'] . ')  <br>';
                            $aEmail['message'] .= '<br>To view details of the case, login to ICMS using your account and search using the case number.<br>';
                            $aResponse['mail'] = $this->mailbox->sendMail($aEmail);
                        }
                        //increment counter
                        $cnt++;
                    }
                    $aResult['flag'] = self::SUCCESS_RESPONSE;
                    $is_notif = self::SUCCESS_RESPONSE;
                }
            }
            

            // if ($is_notif == self::SUCCESS_RESPONSE) {
            //     $this->notif->sendNotificationToVictim([
            //         "notif_type" => "add-service",
            //         "id_type" => "case_victim_id",
            //         "id" => $aNewParam['case_victim_id']
            //     ]);
            // }

        } else {
            $aResult['flag'] = self::SUCCESS_RESPONSE;
        }

        return $aResult;
    }

    private function addCaseDocuments($aNewParam) {

        $aResult = [];

        $aResult['flag'] = self::FAILED_RESPONSE;
        if (count($aNewParam['document_attachment_info']) > 0) {
            foreach ($aNewParam['document_attachment_info'] as $key => $val) {
                $aResponse['add_caseDocuments'] = $this->Case_model->addCaseDocuments($aNewParam, $val);
                //get document type and category
                $docs = $this->Case_model->getDocumentTypeAndCategory($aNewParam, $val);
                // logs : tag agency
                $aLog['log_event_type'] = 26; // base on table : icms_user_event_type
                $aLog['log_message'] = " added " . $docs['category'] . " - " . $docs['docType'];
                $aLog['log_message'] .= " for the case report <a href='update_case/" . $this->yel->encrypt_param($aNewParam['case_id']) . "'>" . $aNewParam['case_number'] . "</a>";
                $aLog['module_primary_id'] = $aNewParam['case_id'];
                $aLog['sub_module_primary_id'] = $aResponse['add_caseDocuments']['insert_id'];
                $aResponse['log'] = $this->audit->create($aLog);
            }
            $aResult['flag'] = self::SUCCESS_RESPONSE;
        } else {
            $aResult['flag'] = self::SUCCESS_RESPONSE;
        }

        return $aResult;
    }

    
}
