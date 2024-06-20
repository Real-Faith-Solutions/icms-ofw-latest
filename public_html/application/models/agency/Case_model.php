<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class Case_model extends CI_Model {

    public function generateCaseNumber($last_id) {
        $agencyData = $this->session->userdata('userData');
        $agencyId = $agencyData['agency_id'];
        $year = date("y");
        $caseCnt = str_pad($last_id, 5, '0', STR_PAD_LEFT);
        $cn = 'CN' . $agencyId . $year . $caseCnt;
        return $cn;
    }

    public function generateVictimNumber($last_id) {
        $year = date("y");
        $victimCnt = str_pad($last_id, 5, '0', STR_PAD_LEFT);
        $vn = 'VN' . $year . $victimCnt;
        return $vn;
    }

    public function getAllCaseLists($aParam) {
        $aResponse = [];

        $sql = "
                SELECT
                    `ic`.`case_id`,
                    `ic`.`case_number`,
                    `ic`.`case_criminal_case`,
                    `ic`.`case_facts`, 
                    DATE_FORMAT(`ic`.`case_date_added`, '%M %d, %Y %r') as `case_date_added`, 
                    DATE_FORMAT(`ic`.`case_date_modified`, '%M %d, %Y %r') as `case_date_last_updated`,
                    `ic`.`case_added_by`,
                    `ic`.`case_status_id`, 
                    `ic`.`case_priority_level_id`,
                    `ic`.`case_priority_level_is_approved`, 
                    (SELECT CONCAT(`user_firstname`, ' ', `user_lastname`) FROM `icms_user` WHERE `user_id` = `ic`.`case_added_by` LIMIT 1) as `filed_by`,
                    (SELECT CONCAT(`ab`.`agency_branch_name`, ' (',(SELECT `agency_abbr` FROM `icms_agency` WHERE `agency_id` = `ab`.`agency_id` LIMIT 1),')') FROM `icms_agency_branch` `ab` WHERE `ab`.`agency_branch_id` = (SELECT `agency_branch_id` FROM `icms_user` WHERE `user_id` = `ic`.`case_added_by` LIMIT 1) LIMIT 1) as `filed_by_agency`,
                    (SELECT `transaction_parameter_name` FROM `icms_transaction_parameter` WHERE `transaction_parameter_type_id`='2' AND `transaction_parameter_count_id`=`ic`.`case_priority_level_id` LIMIT 1) as priority_level, 
                    (SELECT `transaction_parameter_name` FROM `icms_transaction_parameter` WHERE `transaction_parameter_type_id`='3' AND `transaction_parameter_count_id`=`ic`.`case_status_id` LIMIT 1) as case_status,
                    CONCAT_WS ('' ,`iv`.`victim_info_first_name`,' ', `iv`.`victim_info_middle_name`,' ',`iv`.`victim_info_last_name` ,' ', `iv`.`victim_info_suffix`) as victim_name
                    " . $aParam['sRelevance'] . "
                FROM
                    `icms_case` `ic`, 
                    `icms_case_victim` `icv`, 
                    `icms_victim_info` `iv`
                WHERE 
                    `icv`.`case_victim_id` IN (SELECT `case_victim_id` FROM `view_report_summary`) AND 
                    `ic`.`case_id` = `icv`.`case_id` AND
                    `icv`.`victim_id` = `iv`.`victim_id` AND 
                    `iv`.`victim_info_is_assumed` = 0
                    " . $aParam['cTab'] . "
                    " . $aParam['cRelevance'] . "
                    " . $aParam['cFilter'] . "   
                    " . $aParam['advance_search'] . "   
                ORDER BY  " . $aParam['cOrderBy'] . "  `ic`.`case_date_added` DESC
                LIMIT " . $aParam['start'] . "," . $aParam['limit'] . "
               ";
        // exit($sql);
        $aResponse['listing'] = $this->yel->GetAll($sql);

        $qry = "
                SELECT
                    COUNT(1)
                FROM
                    `icms_case` `ic`, 
                    `icms_case_victim` `icv`, 
                    `icms_victim_info` `iv`
                WHERE 
                    `icv`.`case_victim_id` IN (SELECT `case_victim_id` FROM `view_report_summary`) AND 
                    `ic`.`case_id` = `icv`.`case_id` AND
                    `icv`.`victim_id` = `iv`.`victim_id` AND 
                    `iv`.`victim_info_is_assumed` = 0
                    " . $aParam['cTab'] . "
                    " . $aParam['cRelevance'] . "
                    " . $aParam['cFilter'] . "      
                    " . $aParam['advance_search'] . "   
               ";

        $aResponse['count'] = $this->yel->GetOne($qry);
        return $aResponse;
    }

    public function getVictimlistById($case_id) {

        $sList = "  
                SELECT 
                    `cv`.`victim_id`,
                    `cv`.`case_id`,
                    `cv`.`case_victim_id`,
                    DATE_FORMAT(`cv`.`case_victim_date_added`, '%M %d, %Y %r') as case_victim_date_added                    
                FROM 
                    `icms_case_victim` `cv`
                WHERE 
                    `cv`.`case_id` = " . $case_id . "
                LIMIT 5
            ";
        $aResponse = $this->yel->getAll($sList);
        return $aResponse;
    }

    public function getAgencyTypeBasedOnUserId($id) {
        $sql = "
                    SELECT 
                        `gat`.`govt_agency_type_id`,
                        `gat`.`govt_agency_type_name` 
                    FROM 
                        `icms_govt_agency_type` `gat`,
                        `icms_govt_agency` `ga`,
                        `icms_user` `iu`
                    WHERE 
                        `gat`.`govt_agency_type_id`=`ga`.`govt_agency_type_id` 
                    AND `ga`.`govt_agency_id`=`iu`.`govt_agency_id`
                    AND `iu`.`user_id`='" . $id . "'
                    LIMIT 1
               ";

        $aResponse = $this->yel->GetRow($sql);
        return $aResponse;
    }

    public function getUserDetailsTypeBasedOnUserId($id) {
        $sql = "
                    SELECT 
                        CONCAT(`user_firstname`,' ',`user_lastname`) as username
                    FROM 
                        `icms_user` 
                    WHERE 
                        `user_id`='" . $id . "'
                    LIMIT 1
               ";
        $aResponse = $this->yel->GetOne($sql);
        return $aResponse;
    }

    public function getAgencyBranchBasedOnUserId($id) {
        $sql = "
                    SELECT 
                        `ga`.`govt_agency_id`,
                        `ga`.`govt_agency_branch_name`
                    FROM 
                        `icms_govt_agency` `ga`,
                        `icms_user` `iu`
                    WHERE 
                        `ga`.`govt_agency_id`=`iu`.`govt_agency_id`
                    AND `iu`.`user_id`='" . $id . "'
                    LIMIT 1
               ";
        $aResponse = $this->yel->GetRow($sql);
        return $aResponse;
    }

    public function getTaggedCase($aParam) {
        $aResponse = [];
        $sql = "SELECT
                    `ic`.*,
                    (SELECT `transaction_parameter_name` FROM `icms_transaction_parameter` WHERE `transaction_parameter_type_id`='2' AND `transaction_parameter_count_id`=`ic`.`case_priority_level_id` LIMIT 1) as priority_level, 
                    (SELECT `transaction_parameter_name` FROM `icms_transaction_parameter` WHERE `transaction_parameter_type_id`='3' AND `transaction_parameter_count_id`=`ic`.`case_priority_level_id` LIMIT 1) as case_status
                FROM
                    `icms_case` `ic`
                WHERE
                      `ic`.`case_id` IN(" . $aParam['condition_case_id'] . ")
               ";
        $aResponse['list'] = $this->yel->GetAll($sql);
        $qry = "SELECT
                    COUNT(1)
                  FROM
                    `icms_case` `ic`
                WHERE
                      `ic`.`case_id` IN(" . $aParam['condition_case_id'] . ")
               ";
        $aResponse['count'] = $this->yel->GetOne($qry);
        return $aResponse;
    }

    public function getCreatedCase($aParam) {
        $aResponse = [];
        $sql = "SELECT
                    `ic`.*,
                    (SELECT `transaction_parameter_name` FROM `icms_transaction_parameter` WHERE `transaction_parameter_type_id`='2' AND `transaction_parameter_count_id`=`ic`.`case_priority_level_id` LIMIT 1) as priority_level, 
                    (SELECT `transaction_parameter_name` FROM `icms_transaction_parameter` WHERE `transaction_parameter_type_id`='3' AND `transaction_parameter_count_id`=`ic`.`case_priority_level_id` LIMIT 1) as case_status
                FROM
                    `icms_case` `ic`
                WHERE
                    `ic`.`case_added_by` IN(" . $aParam['condition_user_id'] . ");
               ";
        $aResponse['list'] = $this->yel->GetAll($sql);
        $qry = "SELECT
                    COUNT(1)
                 FROM
                    `icms_case` `ic`
                WHERE
                  `ic`.`case_added_by` IN(" . $aParam['condition_user_id'] . ");
               ";
        $aResponse['count'] = $this->yel->GetOne($qry);
        return $aResponse;
    }

    public function getVictimListByCaseID($caseid) {
        $aResponse = [];
        $qry = "  SELECT
                        `cw`.`worker_id`,
                        `wnl`.`worker_name_list_first_name`,
                        `wnl`.`worker_name_list_middle_name`,
                        `wnl`.`worker_name_list_last_name`,
                        `wnl`.`worker_name_list_suffix`
                        
                    FROM
                        `icms_case_worker` `cw`,
                        `icms_worker_name_list` `wnl`
                    WHERE
                        `cw`.`case_id`='" . $caseid . "'
                    AND `cw`.`case_worker_is_active`='1'
                    AND `wnl`.`worker_id`=`cw`.`worker_id`
                 ";
        $aResponse['list'] = $this->yel->GetAll($qry);

        $qry = "  SELECT
                     COUNT(1)
                    FROM
                        `icms_case_worker` `cw`,
                        `icms_worker_name_list` `wnl`
                    WHERE
                        `cw`.`case_id`='" . $caseid . "'
                    AND `cw`.`case_worker_is_active`='1'
                    AND `wnl`.`worker_id`=`cw`.`worker_id`
                 ";

        $aResponse['count'] = $this->yel->GetOne($qry);
        return $aResponse;
    }

    public function getAllAgencyIdUnderAgencyType($agencyTypeId) {

        $qry = "  SELECT
                        `govt_agency_id`
                    FROM
                        `icms_govt_agency` 
                    WHERE
                        `govt_agency_type_id` IN (" . $agencyTypeId . ")
                 ";

        $aResponse = $this->yel->GetAll($qry);
        return $aResponse;
    }

    public function getAllUserIdPerAgencyID($agencyIds) {


        $sql = "SELECT
                   `user_id`
                FROM
                    `icms_user` 
                WHERE
                    `govt_agency_id` IN (" . $agencyIds . ")
               ";

        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getCaseIdByUserIdAndAgencyId($aParam) {

        $sql = "SELECT
                   `cw`.`case_id`
                FROM
                    `icms_case_worker`  `cw`,
                    `icms_case_assistance` `ca`
                WHERE
                    `cw`.`case_worker_id`= `ca`.`case_worker_id`
                AND `ca`.`govt_agency_id` IN(" . $aParam['conditionAgencyids'] . ")
                AND `ca`.`case_assistance_added_by` NOT IN(" . $aParam['condition_user_id'] . ")
                GROUP BY  `cw`.`case_id`
               ";
        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getRecentAddCase() {
        $sql = "
                SELECT
                    `c`.`case_number`, 
                    `c`.`case_priority_level_id` ,   
                    DATE_FORMAT(`c`.`case_date_added`, '%M %d, %Y') as `case_data_added`, 
                    (   SELECT 
                            `ab`.`agency_branch_name`
                        FROM 
                            `icms_agency_branch` `ab`
                        WHERE 
                            `ab`.`agency_branch_id` = (SELECT `agency_branch_id` FROM `icms_user` `u`  WHERE `u`.`user_id` = `c`.`case_added_by` LIMIT 1)
                        LIMIT 1                         
                    ) as `agency_branch_filed_by`, 
                    
                    (   SELECT  `a`.`agency_name`
                        FROM `icms_agency` `a`
                        WHERE `agency_id` = (SELECT `ab`.`agency_id`  FROM  `icms_agency_branch` `ab`
                                                WHERE 
                                                    `ab`.`agency_branch_id` = (SELECT `agency_branch_id` FROM `icms_user` `u`  WHERE `u`.`user_id` = `c`.`case_added_by` LIMIT 1)
                                                LIMIT 1)   
                        LIMIT 1                        
                    ) as `agency_filed_by`                    
                FROM
                    `icms_case` `c`
                ORDER BY `c`.`case_date_added` DESC
                LIMIT 10
            ";
        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getHighPriorityCase() {
        $sql = "
                SELECT
                    `c`.`case_number`, 
                    `c`.`case_priority_level_id` ,   
                    DATE_FORMAT(`c`.`case_date_added`, '%M %d, %Y') as `case_data_added`, 
                    (   SELECT 
                            `ab`.`agency_branch_name`
                        FROM 
                            `icms_agency_branch` `ab`
                        WHERE 
                            `ab`.`agency_branch_id` = (SELECT `agency_branch_id` FROM `icms_user` `u`  WHERE `u`.`user_id` = `c`.`case_added_by` LIMIT 1)
                        LIMIT 1                         
                    ) as `agency_branch_filed_by`, 
                    
                    (   SELECT  `a`.`agency_name`
                        FROM `icms_agency` `a`
                        WHERE `agency_id` = (SELECT `ab`.`agency_id`  FROM  `icms_agency_branch` `ab`
                                                WHERE 
                                                    `ab`.`agency_branch_id` = (SELECT `agency_branch_id` FROM `icms_user` `u`  WHERE `u`.`user_id` = `c`.`case_added_by` LIMIT 1)
                                                LIMIT 1)   
                        LIMIT 1                        
                    ) as `agency_filed_by`                    
                FROM
                    `icms_case` `c`
                WHERE 
                    `c`.`case_priority_level_id` = 2
                ORDER BY `c`.`case_date_added` DESC
                LIMIT 10
            ";
        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getForReviewCase() {
        $sql = "
                SELECT
                    `c`.`case_number`, 
                    `c`.`case_priority_level_id` ,   
                    DATE_FORMAT(`c`.`case_date_added`, '%M %d, %Y') as `case_data_added`, 
                    (   SELECT 
                            `ab`.`agency_branch_name`
                        FROM 
                            `icms_agency_branch` `ab`
                        WHERE 
                            `ab`.`agency_branch_id` = (SELECT `agency_branch_id` FROM `icms_user` `u`  WHERE `u`.`user_id` = `c`.`case_added_by` LIMIT 1)
                        LIMIT 1                         
                    ) as `agency_branch_filed_by`, 
                    
                    (   SELECT  `a`.`agency_name`
                        FROM `icms_agency` `a`
                        WHERE `agency_id` = (SELECT `ab`.`agency_id`  FROM  `icms_agency_branch` `ab`
                                                WHERE 
                                                    `ab`.`agency_branch_id` = (SELECT `agency_branch_id` FROM `icms_user` `u`  WHERE `u`.`user_id` = `c`.`case_added_by` LIMIT 1)
                                                LIMIT 1)   
                        LIMIT 1                        
                    ) as `agency_filed_by`                    
                FROM
                    `icms_case` `c`
                WHERE 
                    `c`.`case_status_id` = 2
                ORDER BY `c`.`case_date_added` DESC
                LIMIT 10
            ";
        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getLastCaseId() {
        $sql = "
                SELECT MAX(`case_id`) FROM `icms_case`;
               ";

        $aResponse = $this->yel->getOne($sql);

        return $aResponse;
    }

    public function addCase($aParam) {
        $sql = "
                INSERT INTO 
                    `icms_case` 
                SET 
                    `case_priority_level_id`= '" . $aParam['recommended_priority_level'] . "', 
                    `case_facts`= " . $this->yel->checkifStringExist($aParam['victim_case_details']['facts']) . ", 
                    `case_evaluation`= " . $this->yel->checkifStringExist($aParam['victim_case_details']['evaluation']) . ", 
                    `case_risk_assessment`= " . $this->yel->checkifStringExist($aParam['victim_case_details']['risk_assessment']) . ",
                    `case_coordination_detail_lea`= " . $this->yel->checkifStringExist($aParam['victim_case_details']['case_coordination_lea']) . ",  
                    `case_is_illegal_rec`= " . $this->yel->checkifStringExist($aParam['victim_case_details']['is_illegal_rec']) . ", 
                    `case_is_other_law`= " . $this->yel->checkifStringExist($aParam['victim_case_details']['is_other_law']) . ", 
                    `case_is_other_law_desc`= " . $this->yel->checkifStringExist($aParam['victim_case_details']['other_law_desc']) . ", 
                    `case_status_id`= '1', 
                    `case_date_added`=now(), 
                    `case_added_by`='" . $this->session->userdata('userData')['user_id'] . "', 
                    `case_date_modified`=now(), 
                    `case_modified_by`='" . $this->session->userdata('userData')['user_id'] . "',
                    `case_violated`= " . $this->yel->checkifStringExist($aParam['victim_case_details']['violated']) . " 
               ";
//        echo '<pre>';        echo $sql; exit();
        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function addCaseChecker($aParam) {

        $new = strval(json_encode($aParam['param']));
        $new = $this->yel->removeslashes($new);
        $new = addslashes($new);

        $sql = "    
                INSERT INTO 
                    `icms_case_checker` 
                SET 
                    `case_checker_param` ='" . $new . "', 
                    `case_checker_added_by`='" . $this->session->userdata('userData')['user_id'] . "'
        ";
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function getCaseDataCheckerById($aParam) {
        $sql = "
                SELECT
                    `case_checker_param`
                FROM
                    `icms_case_checker` 
                WHERE 
                    `case_checker_id` = " . $aParam['case_checker_id'] . "
               ";
//          echo $sql; exit();
        $aResponse = $this->yel->getone($sql);

        return $aResponse;
    }

    public function setCaseDataCheckerById($aParam) {

        $new = strval(json_encode($aParam['param']));
        $new = $this->yel->removeslashes($new);
        $new = addslashes($new);

        $sql = "
                UPDATE
                    `icms_case_checker` 
                SET
                    `case_checker_param` = '" . $new . "'                     
                WHERE 
                    `case_checker_id` = " . $aParam['case_checker_id'] . "
               ";
        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function setCaseDataCheckerCaseIdById($aParam) {

        $new = strval(json_encode($aParam['param']));
        $new = $this->yel->removeslashes($new);
        $new = addslashes($new);
        
        $sql = "
                UPDATE
                    `icms_case_checker` 
                SET
                    `case_id` = '" . $aParam['case_id'] . "',
                    `case_checker_param` = '" . $new . "'       
                WHERE 
                    `case_checker_id` = " . $aParam['case_checker_id'] . " 
               ";
        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function addCaseNumber($aParam) {

        $case_number = $this->generateCaseNumber($aParam['case_id']);

        $sql = "
                UPDATE 
                    `icms_case` 
                SET 
                    `case_number`= '" . $case_number . "'
               WHERE 
                    `case_id` = " . $aParam['case_id'] . " 
               ";
        $aResponse['response'] = $this->yel->exec($sql);
        $aResponse['case_number'] = $case_number;
        return $aResponse;
    }

    public function addVictim($aParam) {
        $sql = "
                INSERT INTO 
                    `icms_victim` 
                SET 
                    `victim_civil_status`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['civil']) . ", 
                    `victim_gender`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['sex']) . ", 
                    `victim_religion`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['religion']) . ",
                    `victim_info_nickname`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['nickname']) . ",
                    `victim_ethnic_group`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['ethnic_group']) . ", 
                    `victim_date_added`= now(), 
                    `victim_added_by`='" . $this->session->userdata('userData')['user_id'] . "', 
                    `victim_date_modified`=now(), 
                    `victim_modified_by`='" . $this->session->userdata('userData')['user_id'] . "' 
               ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function addVictimNumber($aParam) {

        $victim_number = $this->generateVictimNumber($aParam['victim_id']);

        $sql = "
                UPDATE 
                    `icms_victim` 
                SET 
                    `victim_number`= '" . $victim_number . "'
               WHERE 
                    `victim_id` = " . $aParam['victim_id'] . " 
               ";
        $aResponse['response'] = $this->yel->exec($sql);
        $aResponse['victim_number'] = $victim_number;

        return $aResponse;
    }

    public function addCaseVictim($aParam) {
        $sql = "
                INSERT INTO 
                `icms_case_victim` 
                SET 
                `case_id`='" . $aParam['case_id'] . "', 
                `victim_id`='" . $aParam['victim_id'] . "', 
                `case_victim_is_active`='1' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function __addVictimInfo($aParam) {

        // Real 
        $sql = "
                INSERT INTO 
                `icms_victim_info` 
                SET 
                `victim_id`= '" . $aParam['victim_id'] . "', 
                `victim_info_first_name`= '" . $aParam['victim_personal_info']['first_name'] . "', 
                `victim_info_middle_name`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['middle_name']) . ", 
                `victim_info_last_name`= '" . $aParam['victim_personal_info']['last_name'] . "', 
                `victim_info_suffix`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['suffix']) . ", 
                `victim_info_dob`= " . $this->yel->checkDateIfExist($aParam['victim_personal_info']['dob']) . ", 
                `victim_info_city_pob`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['pob']) . ",  
                `victim_info_is_assumed`= '0',
                `victim_info_date_added`= now(), 
                `victim_info_added_by`= '" . $this->session->userdata('userData')['user_id'] . "', 
                `victim_info_added_by_govt_agency`= '" . $this->session->userdata('userData')['agency_branch_id'] . "', 
                `victim_info_date_modified`= now(), 
                `victim_info_modified_by`= '" . $this->session->userdata('userData')['user_id'] . "', 
                `victim_info_is_active`= '1' 
               ";
        $aResponse = $this->yel->exec($sql);

        // Assumed 
        $sql = "
                INSERT INTO 
                `icms_victim_info` 
                SET 
                `victim_id`='" . $aParam['victim_id'] . "', 
                `victim_info_first_name`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['assumed_first_name']) . ", 
                `victim_info_middle_name`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['assumed_middle_name']) . ", 
                `victim_info_last_name`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['assumed_last_name']) . ", 
                `victim_info_dob`= " . $this->yel->checkDateIfExist($aParam['victim_personal_info']['assumed_dob']) . ", 
                `victim_info_is_assumed`='1', 
                `victim_info_date_added`=now(), 
                `victim_info_added_by`='" . $this->session->userdata('userData')['user_id'] . "', 
                `victim_info_added_by_govt_agency`='" . $this->session->userdata('userData')['agency_branch_id'] . "', 
                `victim_info_date_modified`=now(), 
                `victim_info_modified_by`='" . $this->session->userdata('userData')['user_id'] . "', 
                `victim_info_is_active`='1' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function addVictimInfo($aParam) {
        
        // Real 
        $sql = "
                INSERT INTO 
                `icms_victim_info` 
                SET 
                `victim_id`= '" . $aParam['victim_id'] . "', 
                `victim_info_first_name`= '" . $aParam['victim_personal_info']['first_name'] . "', 
                `victim_info_middle_name`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['middle_name']) . ", 
                `victim_info_last_name`= '" . $aParam['victim_personal_info']['last_name'] . "',
                `victim_info_nickname`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['nickname']) . ", 
                `victim_info_suffix`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['suffix']) . ", 
                `victim_info_dob`= " . $this->yel->checkDateIfExist($aParam['victim_personal_info']['dob']) . ", 
                `victim_info_city_pob`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['pob']) . ",
                `victim_info_disability`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['disability']) . ",
                `victim_info_allergy`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['allergy']) . ",
                `victim_info_hospitality`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['hospitality']) . ",
                `other_victim_info_hospitalization`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['other_hospitalization_history']) . ",  
                `victim_info_is_assumed`= '0',
                `victim_info_date_added`= now(), 
                `victim_info_added_by`= '" . $this->session->userdata('userData')['user_id'] . "', 
                `victim_info_added_by_govt_agency`= '" . $this->session->userdata('userData')['agency_branch_id'] . "', 
                `victim_info_date_modified`= now(), 
                `victim_info_modified_by`= '" . $this->session->userdata('userData')['user_id'] . "', 
                `victim_info_is_active`= '1'
               ";
        $aResponse['real'] = $this->yel->exec($sql);

        // Assumed
        $sql = "
                 INSERT INTO 
                `icms_victim_info` 
                SET 
                `victim_id`='" . $aParam['victim_id'] . "', 
                `victim_info_first_name`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['assumed_first_name']) . ", 
                `victim_info_middle_name`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['assumed_middle_name']) . ", 
                `victim_info_last_name`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['assumed_last_name']) . ",
                `victim_info_nickname`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['nickname']) . ", 
                `victim_info_dob`= " . $this->yel->checkDateIfExist($aParam['victim_personal_info']['assumed_dob']) . ", 
                `victim_info_is_assumed`='1', 
                `victim_info_disability`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['disability']) . ",
                `victim_info_allergy`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['allergy']) . ",
                `victim_info_hospitality`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['hospitality']) . ",
                `other_victim_info_hospitalization`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['other_hospitalization_history']) . ",
                `victim_info_date_added`=now(), 
                `victim_info_added_by`='" . $this->session->userdata('userData')['user_id'] . "', 
                `victim_info_added_by_govt_agency`='" . $this->session->userdata('userData')['agency_branch_id'] . "', 
                `victim_info_date_modified`=now(), 
                `victim_info_modified_by`='" . $this->session->userdata('userData')['user_id'] . "', 
                `victim_info_is_active`='1'; 
        ";

        $aResponse['assume'] = $this->yel->exec($sql);

        return $aResponse;
    }

    public function addVictimInfoReal($aParam) {
        $sql = "
                INSERT INTO 
                `icms_victim_info` 
                SET 
                `victim_id`= '" . $aParam['victim_id'] . "', 
                `victim_info_first_name`= '" . $aParam['victim_personal_info']['first_name'] . "', 
                `victim_info_middle_name`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['middle_name']) . ", 
                `victim_info_last_name`= '" . $aParam['victim_personal_info']['last_name'] . "', 
                `victim_info_suffix`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['suffix']) . ", 
                `victim_info_dob`= " . $this->yel->checkDateIfExist($aParam['victim_personal_info']['dob']) . ", 
                `victim_info_city_pob`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['pob']) . ",  
                `victim_info_is_assumed`= '0',
                `victim_info_date_added`= now(), 
                `victim_info_added_by`= '" . $this->session->userdata('userData')['user_id'] . "', 
                `victim_info_added_by_govt_agency`= '" . $this->session->userdata('userData')['agency_branch_id'] . "', 
                `victim_info_date_modified`= now(), 
                `victim_info_modified_by`= '" . $this->session->userdata('userData')['user_id'] . "', 
                `victim_info_is_active`= '1'                
               ";
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function addVictimInfoAssume($aParam) {
        // Assume 
        $sql = "
                INSERT INTO 
                    `icms_victim_info` 
                SET 
                    `victim_id`='" . $aParam['victim_id'] . "', 
                    `victim_info_first_name`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['assumed_first_name']) . ", 
                    `victim_info_middle_name`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['assumed_middle_name']) . ", 
                    `victim_info_last_name`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['assumed_last_name']) . ",
                    `victim_info_nickname`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['nickname']) . ", 
                    `victim_info_dob`= " . $this->yel->checkDateIfExist($aParam['victim_personal_info']['assumed_dob']) . ",
                    `victim_info_disability`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['disability']) . ",
                    `victim_info_allergy`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['allergy']) . ",
                    `victim_info_hospitality`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['hospitality']) . ",
                    `other_victim_info_hospitalization`= " . $this->yel->checkifStringExist($aParam['victim_personal_info']['other_hospitalization_history']) . ", 
                    `victim_info_is_assumed`='1', 
                    `victim_info_date_added`=now(), 
                    `victim_info_added_by`='" . $this->session->userdata('userData')['user_id'] . "', 
                    `victim_info_added_by_govt_agency`='" . $this->session->userdata('userData')['agency_branch_id'] . "', 
                    `victim_info_date_modified`=now(), 
                    `victim_info_modified_by`='" . $this->session->userdata('userData')['user_id'] . "', 
                    `victim_info_is_active`='1'; 
                
               ";
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function addVictimAddress($aParam, $val) {
        $sql = "
                INSERT INTO 
                `icms_victim_address_list` 
                SET 
                `victim_id`= '" . $aParam['victim_id'] . "', 
                `country_id`= '173', 
                `victim_address_list_region_id`= " . $this->yel->checkifStringExist($val['address_region']) . ", 
                `victim_address_list_province_id`= " . $this->yel->checkifStringExist($val['address_province']) . ", 
                `victim_address_list_city_id`= " . $this->yel->checkifStringExist($val['address_city']) . ", 
                `victim_address_list_brgy_id`= " . $this->yel->checkifStringExist($val['address_barangay']) . ", 
                `victim_address_list_address`= " . $this->yel->checkifStringExist($val['address_complete']) . ", 
                `victim_address_list_date_added`= now(),
                `victim_address_list_added_by`= '" . $this->session->userdata('userData')['user_id'] . "', 
                `victim_address_list_date_modified`=now(), 
                `victim_address_list_updated_by`= '" . $this->session->userdata('userData')['user_id'] . "', 
                `victim_address_list_is_active`= '1' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function updateVictimAddress($aParam, $val) {
        $sql = "
                UPDATE 
                    `icms_victim_address_list` 
                SET 
                    `victim_id`= '" . $aParam['victim_id'] . "', 
                    `country_id`= '173', 
                    `victim_address_list_region_id`= " . $this->yel->checkifStringExist($val['address_region']) . ", 
                    `victim_address_list_province_id`= " . $this->yel->checkifStringExist($val['address_province']) . ", 
                    `victim_address_list_city_id`= " . $this->yel->checkifStringExist($val['address_city']) . ", 
                    `victim_address_list_brgy_id`= " . $this->yel->checkifStringExist($val['address_barangay']) . ", 
                    `victim_address_list_address`= " . $this->yel->checkifStringExist($val['address_complete']) . ", 
                    `victim_address_list_date_modified`= now(), 
                    `victim_address_list_updated_by`= '" . $this->session->userdata('userData')['user_id'] . "', 
                    `victim_address_list_is_active`= " . $val['status'] . " 
               WHERE 
                    `victim_address_list_id` = " . $val['address_id'] . " 
               ";
        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function addVictimContact($aParam, $val) {
        $sql = "
                INSERT INTO 
                    `icms_victim_contact_details` 
                SET 
                    `victim_id`='" . $aParam['victim_id'] . "', 
                    `victim_contact_detail_type`='" . $val['contact_type'] . "', 
                    `victim_contact_detail_content`='" . $val['contact_content'] . "', 
                    `victim_contact_details_added_date`=now(),
                    `victim_contact_details_added_by`='" . $this->session->userdata('userData')['user_id'] . "', 
                    `victim_contact_details_is_active`='1' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function updateVictimContact($aParam, $val) {
        $sql = "
                UPDATE 
                    `icms_victim_contact_details` 
                SET 
                    `victim_contact_detail_type`= '" . $val['contact_type'] . "', 
                    `victim_contact_detail_content`='" . $val['contact_content'] . "', 
                    `victim_contact_details_added_by` = " . $this->session->userdata('userData')['user_id'] . ", 
                    `victim_contact_details_is_active`= '" . $val['status'] . "'
                WHERE 
                    `victim_contact_details_id` =   " . $val['conctact_details_id'] . "
               ";
        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function addVictimEducation($aParam, $val) {
        $sql = "
                INSERT INTO 
                `icms_victim_education` 
                SET 
                `victim_id`='" . $aParam['victim_id'] . "', 
                `victim_education_type`= '" . $val['education_type'] . "', 
                `victim_education_grade_year`= " . $this->yel->checkifStringExist($val['education_grade_year']) . ", 
                `victim_education_school`= " . $this->yel->checkifStringExist($val['education_school']) . ", 
                `victim_education_course`= " . $this->yel->checkifStringExist($val['education_course']) . ", 
                `victim_education_start`= " . $this->yel->checkifStringExist($val['education_start']) . ", 
                `victim_education_end`= " . $this->yel->checkifStringExist($val['education_end']) . ", 
                `victim_education_added_date`=now(),
                `victim_education_added_by`='" . $this->session->userdata('userData')['user_id'] . "', 
                `victim_education_is_active`='1' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function setVictimEducationById($aParam, $val) {
        $sql = "
                UPDATE  
                    `icms_victim_education` 
                SET 
                    `victim_education_type`= '" . $val['education_type'] . "', 
                    `victim_education_grade_year`= " . $this->yel->checkifStringExist($val['education_grade_year']) . ", 
                    `victim_education_school`= " . $this->yel->checkifStringExist($val['education_school']) . ", 
                    `victim_education_course`= " . $this->yel->checkifStringExist($val['education_course']) . ", 
                    `victim_education_start`= " . $this->yel->checkifStringExist($val['education_start']) . ", 
                    `victim_education_end`= " . $this->yel->checkifStringExist($val['education_end']) . ", 
                    `victim_education_is_active`= " . $val['status'] . "
                WHERE 
                    `victim_education_id` = " . $val['victim_education_id'] . "
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function addVictimRelative($aParam, $val) {

        $sql = "
                INSERT INTO 
                `icms_victim_relative` 
                SET 
                `victim_id`='" . $aParam['victim_id'] . "', 
                `victim_relative_fullname`='" . $val['relative_name'] . "', 
                `victim_relative_type`='" . $val['relative_type'] . "', 
                `victim_relative_primary_contact_number`= " . $this->yel->checkifStringExist($val['relative_primary_contact_number']) . ", 
                `victim_relative_second_contact_number`= " . $this->yel->checkifStringExist($val['relative_secondary_contact_number']) . ", 
                `victim_relative_type_other` = " . $this->yel->checkifStringExist($val['relative_other']) . ", 
                `victim_relative_email`= " . $this->yel->checkifStringExist($val['relative_email']) . ", 
                `victim_relative_added_date`=now(),
                `victim_relative_added_by`='" . $this->session->userdata('userData')['user_id'] . "', 
                `victim_relative_is_active`='1' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function updateVictimRelative($aParam, $val) {
        $sql = "
                UPDATE  
                    `icms_victim_relative` 
                SET 
                    `victim_relative_fullname`='" . $val['relative_name'] . "', 
                    `victim_relative_type`='" . $val['relative_type'] . "', 
                    `victim_relative_primary_contact_number`= " . $this->yel->checkifStringExist($val['relative_primary_contact_number']) . ", 
                    `victim_relative_second_contact_number`= " . $this->yel->checkifStringExist($val['relative_secondary_contact_number']) . ", 
                    `victim_relative_email`= " . $this->yel->checkifStringExist($val['relative_email']) . ", 
                    `victim_relative_type_other` = " . $this->yel->checkifStringExist($val['relative_other']) . ", 
                    `victim_relative_added_date`=now(),
                    `victim_relative_added_by`='" . $this->session->userdata('userData')['user_id'] . "', 
                    `victim_relative_is_active`= " . $val['status'] . " 
               WHERE 
                    `victim_relative_id` = " . $val['relative_id'] . "
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    //employment
    //recruitment
    public function addLocalRecruitmentAgency($aParam) {

        $sql = "
                INSERT INTO 
                `icms_recruitment_agency` 
                SET 
                `recruitment_agency_name`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_name']) . ", 
                `recruitment_agency_address`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_address']) . ", 
                `recruitment_agency_tel_no`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_telephone']) . ", 
                `recruitment_agency_email`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_email']) . ", 
                `recruitment_agency_fax_no`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_fax']) . ", 
                `recruitment_agency_website`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_website']) . ", 
                `country_id`=" . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_country']) . ", 
                `region_id`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_region']) . ", 
                `province_id`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_province']) . ", 
                `recruitment_agency_is_local`='1', 
                `recruitment_agency_date_added`=now(), 
                `recruitment_agency_added_by`='" . $this->session->userdata('userData')['user_id'] . "', 
                `recruitment_agency_date_modified`=now(), 
                `recruitment_agency_modified_by`= '" . $this->session->userdata('userData')['user_id'] . "', 
                `recruitment_agency_is_active`='1' 
               ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function addLocalRecruitmentAgencyByManage($aParam) {

        $sql = "
            INSERT INTO 
                `icms_recruitment_agency` 
            SET 
                `recruitment_agency_name`= " . $this->yel->checkifStringExist($aParam['agn_name']) . ",  
                `recruitment_agency_address`='" . $aParam['agn_address'] . "',
                `recruitment_agency_tel_no`='" . $aParam['agn_tel'] . "',
                `recruitment_agency_email`='" . $aParam['agn_email'] . "',
                `recruitment_agency_fax_no`='" . $aParam['agn_fax'] . "',
                `recruitment_agency_website`= '" . $aParam['agn_web'] . "',
                `region_id` = '" . $aParam['agn_region'] . "',
                `province_id` = '" . $aParam['agn_province'] . "',
                `country_id`='" . $aParam['country'] . "', 
                `recruitment_agency_is_local`='1', 
                `recruitment_agency_date_added`=now(), 
                `recruitment_agency_added_by`='" . $this->session->userdata('userData')['user_id'] . "', 
                `recruitment_agency_date_modified`=now(), 
                `recruitment_agency_modified_by`= '" . $this->session->userdata('userData')['user_id'] . "', 
                `recruitment_agency_is_active`='1' 
         ";
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function addForeignRecruitmentAgencyByManage($aParam) {

        $sql = "
            INSERT INTO 
                `icms_recruitment_agency` 
            SET 
                `recruitment_agency_name`= " . $this->yel->checkifStringExist($aParam['agn_name']) . ", 
                `recruitment_agency_address`='" . $aParam['agn_address'] . "',
                `recruitment_agency_tel_no`='" . $aParam['agn_tel'] . "',
                `recruitment_agency_email`='" . $aParam['agn_email'] . "',
                `recruitment_agency_fax_no`='" . $aParam['agn_fax'] . "',
                `recruitment_agency_website`= '" . $aParam['agn_web'] . "',
                `country_id`='" . $aParam['country'] . "', 
                `recruitment_agency_is_local`='0', 
                `recruitment_agency_date_added`=now(), 
                `recruitment_agency_added_by`='" . $this->session->userdata('userData')['user_id'] . "', 
                `recruitment_agency_date_modified`=now(), 
                `recruitment_agency_modified_by`= '" . $this->session->userdata('userData')['user_id'] . "', 
                `recruitment_agency_is_active`='1' 
         ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function setLocalRecruitmentAgency($aParam) {

        $sql = "
                UPDATE  
                    `icms_recruitment_agency` 
                SET 
                    `recruitment_agency_name`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_name']) . ", 
                    `recruitment_agency_address`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_address']) . ", 
                    `recruitment_agency_tel_no`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_telephone']) . ", 
                    `recruitment_agency_email`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_email']) . ", 
                    `recruitment_agency_fax_no`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_fax']) . ", 
                    `recruitment_agency_website`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_website']) . ", 
                    `country_id`=" . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_country']) . ", 
                    `region_id`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_region']) . ", 
                    `province_id`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_province']) . ", 
                    `recruitment_agency_date_modified`=now(), 
                    `recruitment_agency_modified_by`= '" . $this->session->userdata('userData')['user_id'] . "'
                WHERE 
                    `recruitment_agency_id` = '" . $aParam['local_agency_id'] . "'
               ";
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function addForeignRecruitmentAgencyOwner($aParam) {

        $sql = "
                INSERT INTO 
                    `icms_recruitment_agency_info` 
                SET 
                    `recruitment_agency_info_type_id`= '1', 
                    `recruitment_agency_id` = '" . $aParam['foreign_agency_id'] . "', 
                    `recruitment_agency_info_name`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['foreign_agency_owner_name']) . ", 
                    `recruitment_agency_info_address`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['foreign_agency_owner_address']) . ", 
                    `recruitment_agency_info_contact_number`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['foreign_agency_owner_contact']) . ", 
                    `recruitment_agency_info_added_by`= '" . $this->session->userdata('userData')['user_id'] . "'
               ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function setForeignRecruitmentAgencyOwner($aParam) {

        $sql = "
                UPDATE  
                    `icms_recruitment_agency_info` 
                SET 
                    `recruitment_agency_info_name`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['foreign_agency_owner_name']) . ", 
                    `recruitment_agency_info_address`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['foreign_agency_owner_address']) . ", 
                    `recruitment_agency_info_contact_number`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['foreign_agency_owner_contact']) . "
                WHERE 
                    `recruitment_agency_info_type_id`= '1'
                AND `recruitment_agency_id` = '" . $aParam['foreign_agency_id'] . "'
        ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function addForeignRecruitmentAgencyRep($aParam) {

        $sql = "
                INSERT INTO 
                    `icms_recruitment_agency_info` 
                SET 
                    `recruitment_agency_info_type_id`= '2', 
                    `recruitment_agency_id` = '" . $aParam['foreign_agency_id'] . "', 
                    `recruitment_agency_info_name`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['foreign_agency_rep_name']) . ", 
                    `recruitment_agency_info_address`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['foreign_agency_rep_address']) . ", 
                    `recruitment_agency_info_contact_number`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['foreign_agency_rep_contact']) . ", 
                    `recruitment_agency_info_added_by`= '" . $this->session->userdata('userData')['user_id'] . "'
               ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function setForeignRecruitmentAgencyRep($aParam) {

        $sql = "
                UPDATE
                    `icms_recruitment_agency_info` 
                SET 
                    `recruitment_agency_info_name`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['foreign_agency_rep_name']) . ", 
                    `recruitment_agency_info_address`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['foreign_agency_rep_address']) . ", 
                    `recruitment_agency_info_contact_number`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['foreign_agency_rep_contact']) . "
                WHERE
                    `recruitment_agency_info_type_id`= '2'
                AND `recruitment_agency_id` = '" . $aParam['foreign_agency_id'] . "'
            ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function addLocalRecruitmentAgencyOwner($aParam) {

        $sql = "
                INSERT INTO 
                    `icms_recruitment_agency_info` 
                SET 
                    `recruitment_agency_info_type_id`= '1', 
                    `recruitment_agency_id` = '" . $aParam['local_agency_id'] . "', 
                    `recruitment_agency_info_name`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_owner_name']) . ", 
                    `recruitment_agency_info_address`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_owner_address']) . ", 
                    `recruitment_agency_info_contact_number`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_owner_contact']) . ", 
                    `recruitment_agency_info_added_by`= '" . $this->session->userdata('userData')['user_id'] . "'
               ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function addLocalRecruitmentAgencyOwnerByManage($aParam) {

        $sql = "
                INSERT INTO 
                    `icms_recruitment_agency_info` 
                SET 
                    `recruitment_agency_info_type_id`= '1', 
                    `recruitment_agency_id` = '" . $aParam['local_agency_id'] . "', 
                    `recruitment_agency_info_name`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_owner_name']) . ", 
                    `recruitment_agency_info_address`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_owner_address']) . ", 
                    `recruitment_agency_info_contact_number`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_owner_contact']) . ", 
                    `recruitment_agency_info_added_by`= '" . $this->session->userdata('userData')['user_id'] . "'
               ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function setLocalRecruitmentAgencyOwner($aParam) {

        $sql = "
                UPDATE
                    `icms_recruitment_agency_info` 
                SET 
                    `recruitment_agency_info_name`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_owner_name']) . ", 
                    `recruitment_agency_info_address`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_owner_address']) . ", 
                    `recruitment_agency_info_contact_number`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_owner_contact']) . "
                WHERE 
                    `recruitment_agency_info_type_id`= '1'
                AND `recruitment_agency_id` = '" . $aParam['local_agency_id'] . "'
        ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function addLocalRecruitmentAgencyRep($aParam) {

        $sql = "
                INSERT INTO 
                `icms_recruitment_agency_info` 
                SET 
                `recruitment_agency_info_type_id`= '2', 
                `recruitment_agency_id` = '" . $aParam['local_agency_id'] . "', 
                `recruitment_agency_info_name`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_rep_name']) . ", 
                `recruitment_agency_info_address`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_rep_address']) . ", 
                `recruitment_agency_info_contact_number`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_rep_contact']) . ", 
                `recruitment_agency_info_added_by`= '" . $this->session->userdata('userData')['user_id'] . "'
               ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function setLocalRecruitmentAgencyRep($aParam) {

        $sql = "
                UPDATE  
                    `icms_recruitment_agency_info` 
                SET 
                   
                    `recruitment_agency_info_name`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_rep_name']) . ", 
                    `recruitment_agency_info_address`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_rep_address']) . ", 
                    `recruitment_agency_info_contact_number`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_rep_contact']) . "
                WHERE 
                     `recruitment_agency_info_type_id`= '2'
                AND  `recruitment_agency_id` = '" . $aParam['local_agency_id'] . "'
        ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function setLocalRecAgencyRepByMngReport($aParam) {

        $sql = "
                UPDATE  
                    `icms_recruitment_agency_info` 
                SET 
                    `recruitment_agency_info_name`= " . $this->yel->checkifStringExist($aParam['local_agency_rep_name']) . ", 
                    `recruitment_agency_info_address`= " . $this->yel->checkifStringExist($aParam['local_agency_rep_address']) . ", 
                    `recruitment_agency_info_contact_number`= " . $this->yel->checkifStringExist($aParam['local_agency_rep_contact']) . "
                WHERE 
                     `recruitment_agency_info_type_id`= '2'
                AND  `recruitment_agency_id` = '" . $aParam['agn_id'] . "'
        ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function setCasePriorityLevel($aParam) {
        $sql = "
                UPDATE  
                    `icms_case` 
                SET 
                    `case_priority_level_id`= " . $aParam['level_id'] . ", 
                    `case_date_modified`= NOW(), 
                    `case_modified_by`= " . $this->session->userdata('userData')['user_id'] . "
                WHERE 
                     `case_id`= " . $aParam['case_id'] . "
        ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function addLocalRecAgencyRepByMngReport($aParam) {
        $sql = "                              
                INSERT INTO
                    `icms_recruitment_agency_info` 
                SET 
                    `recruitment_agency_info_name`= " . $this->yel->checkifStringExist($aParam['local_agency_rep_name']) . ", 
                    `recruitment_agency_info_address`= " . $this->yel->checkifStringExist($aParam['local_agency_rep_address']) . ", 
                    `recruitment_agency_info_contact_number`= " . $this->yel->checkifStringExist($aParam['local_agency_rep_contact']) . ",                 
                    `recruitment_agency_info_type_id`= '2', 
                    `recruitment_agency_id` = '" . $aParam['agn_id'] . "'
        ";
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function setForeignRecAgencyRepByMngReport($aParam) {
        $sql = "
                UPDATE  
                    `icms_recruitment_agency_info` 
                SET 
                    `recruitment_agency_info_name`= " . $this->yel->checkifStringExist($aParam['agn_rep']) . ", 
                    `recruitment_agency_info_address`= " . $this->yel->checkifStringExist($aParam['rep_address']) . ", 
                    `recruitment_agency_info_contact_number`= " . $this->yel->checkifStringExist($aParam['rep_contact']) . "
                WHERE 
                     `recruitment_agency_info_type_id`= '2'
                AND  `recruitment_agency_id` = '" . $aParam['agn_id'] . "'
        ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function addForeignRecAgencyRepByMngReport($aParam) {
        $sql = "
                INSERT INTO   
                    `icms_recruitment_agency_info` 
                SET 
                    `recruitment_agency_info_name`= " . $this->yel->checkifStringExist($aParam['agn_rep']) . ", 
                    `recruitment_agency_info_address`= " . $this->yel->checkifStringExist($aParam['rep_address']) . ", 
                    `recruitment_agency_info_contact_number`= " . $this->yel->checkifStringExist($aParam['rep_contact']) . ", 
                     `recruitment_agency_info_type_id`= '2', 
                     `recruitment_agency_id` = '" . $aParam['agn_id'] . "'
        ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function setLocalRecAgencyOwnerByMngReport($aParam) {

        $sql = "
                UPDATE
                    `icms_recruitment_agency_info` 
                SET 
                    `recruitment_agency_info_name`= " . $this->yel->checkifStringExist($aParam['local_agency_owner_name']) . ", 
                    `recruitment_agency_info_address`= " . $this->yel->checkifStringExist($aParam['local_agency_owner_address']) . ", 
                    `recruitment_agency_info_contact_number`= " . $this->yel->checkifStringExist($aParam['local_agency_owner_contact']) . "
                WHERE 
                    `recruitment_agency_info_type_id`= '1'
                AND `recruitment_agency_id` = '" . $aParam['agn_id'] . "'
        ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function addLocalRecAgencyOwnerByMngReport($aParam) {

        $sql = "
                INSERT INTO
                    `icms_recruitment_agency_info` 
                SET 
                    `recruitment_agency_info_name`= " . $this->yel->checkifStringExist($aParam['local_agency_owner_name']) . ", 
                    `recruitment_agency_info_address`= " . $this->yel->checkifStringExist($aParam['local_agency_owner_address']) . ", 
                    `recruitment_agency_info_contact_number`= " . $this->yel->checkifStringExist($aParam['local_agency_owner_contact']) . ",  
                    `recruitment_agency_info_type_id`= '1', 
                    `recruitment_agency_id` = '" . $aParam['agn_id'] . "'
        ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function setForeignRecAgencyOwnerByMngReport($aParam) {

        $sql = "
                UPDATE
                    `icms_recruitment_agency_info` 
                SET 
                    `recruitment_agency_info_name`= " . $this->yel->checkifStringExist($aParam['agn_owner']) . ", 
                    `recruitment_agency_info_address`= " . $this->yel->checkifStringExist($aParam['owner_address']) . ", 
                    `recruitment_agency_info_contact_number`= " . $this->yel->checkifStringExist($aParam['owner_contact']) . "
                WHERE 
                    `recruitment_agency_info_type_id`= '1'
                AND `recruitment_agency_id` = '" . $aParam['agn_id'] . "'
        ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function addForeignRecAgencyOwnerByMngReport($aParam) {

        $sql = "
                INSERT INTO
                    `icms_recruitment_agency_info` 
                SET 
                    `recruitment_agency_info_name`= " . $this->yel->checkifStringExist($aParam['agn_owner']) . ", 
                    `recruitment_agency_info_address`= " . $this->yel->checkifStringExist($aParam['owner_address']) . ", 
                    `recruitment_agency_info_contact_number`= " . $this->yel->checkifStringExist($aParam['owner_contact']) . ", 
                    `recruitment_agency_info_type_id`= '1',
                    `recruitment_agency_id` = '" . $aParam['agn_id'] . "'
        ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function setLocalRecAgencyAgentByMngReport($aParam) {

        $sql = "
                UPDATE 
                    `icms_recruitment_agency_info` 
                SET 
                    `recruitment_agency_info_name`= " . $this->yel->checkifStringExist($aParam['local_agency_agent_name']) . ", 
                    `recruitment_agency_info_address`= " . $this->yel->checkifStringExist($aParam['local_agency_rep_address']) . ", 
                    `recruitment_agency_info_contact_number`= " . $this->yel->checkifStringExist($aParam['local_agency_rep_contact']) . "
                WHERE 
                    `recruitment_agency_info_type_id`= '3'
                AND `recruitment_agency_id` = '" . $aParam['agn_id'] . "'
        ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function addLocalRecAgencyAgentByMngReport($aParam) {

        $sql = "
                INSERT INTO 
                    `icms_recruitment_agency_info` 
                SET 
                    `recruitment_agency_info_name`= " . $this->yel->checkifStringExist($aParam['local_agency_agent_name']) . ", 
                    `recruitment_agency_info_address`= " . $this->yel->checkifStringExist($aParam['local_agency_rep_address']) . ", 
                    `recruitment_agency_info_contact_number`= " . $this->yel->checkifStringExist($aParam['local_agency_rep_contact']) . ", 
                    `recruitment_agency_info_type_id`= '3',
                    `recruitment_agency_id` = '" . $aParam['agn_id'] . "'
        ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function addLocalRecruitmentAgencyAgent($aParam) {

        $sql = "
                INSERT INTO 
                    `icms_recruitment_agency_info` 
                SET 
                    `recruitment_agency_info_type_id`= '3', 
                    `recruitment_agency_id` = '" . $aParam['local_agency_id'] . "', 
                    `recruitment_agency_info_name`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_agent_name']) . ", 
                    `recruitment_agency_info_address`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_rep_address']) . ", 
                    `recruitment_agency_info_contact_number`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_rep_contact']) . ", 
                    `recruitment_agency_info_added_by`= '" . $this->session->userdata('userData')['user_id'] . "'
               ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function setLocalRecruitmentAgencyAgent($aParam) {

        $sql = "
                UPDATE 
                    `icms_recruitment_agency_info` 
                SET 
                    `recruitment_agency_info_name`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_agent_name']) . ", 
                    `recruitment_agency_info_address`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_rep_address']) . ", 
                    `recruitment_agency_info_contact_number`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['local_agency_rep_contact']) . "
                WHERE 
                    `recruitment_agency_info_type_id`= '3'
                AND `recruitment_agency_id` = '" . $aParam['local_agency_id'] . "'
        ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function addForeignRecruitmentAgency($aParam) {
        $sql = "
            INSERT INTO 
                `icms_recruitment_agency` 
            SET 
                `recruitment_agency_name`='" . $aParam['victim_recruitment_details']['foreign_agency_name'] . "', 
                `recruitment_agency_address`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['foreign_agency_address']) . ", 
                `recruitment_agency_tel_no`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['foreign_agency_telephone']) . ", 
                `recruitment_agency_email`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['foreign_agency_email']) . ", 
                `recruitment_agency_fax_no`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['foreign_agency_fax']) . ", 
                `recruitment_agency_website`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['foreign_agency_website']) . ", 
                `country_id`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['foreign_agency_country']) . ", 
                `recruitment_agency_is_local`='0', 
                `recruitment_agency_date_added`=now(), 
                `recruitment_agency_added_by`='" . $this->session->userdata('userData')['user_id'] . "', 
                `recruitment_agency_date_modified`=now(), 
                `recruitment_agency_modified_by`='" . $this->session->userdata('userData')['user_id'] . "', 
                `recruitment_agency_is_active`='1' 
           ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function setForeignRecruitmentAgency($aParam) {
        $sql = "
                UPDATE
                    `icms_recruitment_agency` 
                SET 
                    `recruitment_agency_name`=" . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['foreign_agency_name']) . ", 
                    `recruitment_agency_address`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['foreign_agency_address']) . ", 
                    `recruitment_agency_tel_no`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['foreign_agency_telephone']) . ", 
                    `recruitment_agency_email`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['foreign_agency_email']) . ", 
                    `recruitment_agency_fax_no`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['foreign_agency_fax']) . ", 
                    `recruitment_agency_website`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['foreign_agency_website']) . ", 
                    `country_id`= " . $this->yel->checkifStringExist($aParam['victim_recruitment_details']['foreign_agency_country']) . ", 
                    `recruitment_agency_is_local`='0', 
                    `recruitment_agency_date_modified`=now(), 
                    `recruitment_agency_modified_by`='" . $this->session->userdata('userData')['user_id'] . "'
                 WHERE 
                    `recruitment_agency_id` = '" . $aParam['foreign_agency_id'] . "'
               ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function addEmployer($aParam) {
        $sql = "
                INSERT INTO 
                    `icms_employer` 
                SET 
                    `employer_name`='" . $aParam['victim_employer_details']['employer_name'] . "', 
                    `employer_representative_name`='" . $aParam['victim_employer_details']['employer_representative'] . "', 
                    `employer_tel_no`='" . $aParam['victim_employer_details']['employer_telephone'] . "', 
                    `employer_email`='" . $aParam['victim_employer_details']['employer_email'] . "', 
                    `employer_country_id`='" . $aParam['victim_employer_details']['employer_country'] . "', 
                    `employer_city`='" . $aParam['victim_employer_details']['employer_city'] . "', 
                    `employer_full_address`='" . $aParam['victim_employer_details']['employer_address'] . "', 
                    `employer_date_added`=now(), 
                    `employer_added_by`='" . $this->session->userdata('userData')['user_id'] . "', 
                    `employer_date_modified`=now(), 
                    `employer_date_modified_by`='" . $this->session->userdata('userData')['user_id'] . "', 
                    `employer_is_active`='1' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function addEmployerInManageReport($aParam) {
        $sql = "
                INSERT INTO 
                    `icms_employer` 
                SET 
                    `employer_name`='" . $aParam['emp_name'] . "', 
                    `employer_representative_name`='" . $aParam['rep_name'] . "', 
                    `employer_tel_no`='" . $aParam['telno'] . "', 
                    `employer_email`='" . $aParam['email'] . "', 
                    `employer_country_id`='" . $aParam['country'] . "', 
                    `employer_city`='" . $aParam['city'] . "', 
                    `employer_full_address`='" . $aParam['emp_address'] . "', 
                    `employer_date_added`=now(), 
                    `employer_added_by`='" . $this->session->userdata('userData')['user_id'] . "', 
                    `employer_date_modified`=now(), 
                    `employer_date_modified_by`='" . $this->session->userdata('userData')['user_id'] . "', 
                    `employer_is_active`='1' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function setEmployer($aParam) {
        $sql = "
                UPDATE  
                    `icms_employer` 
                SET 
                    `employer_name`= '" . $aParam['victim_employer_details']['employer_name'] . "', 
                    `employer_representative_name`='" . $aParam['victim_employer_details']['employer_representative'] . "', 
                    `employer_tel_no`='" . $aParam['victim_employer_details']['employer_telephone'] . "', 
                    `employer_email`='" . $aParam['victim_employer_details']['employer_email'] . "', 
                    `employer_country_id`='" . $aParam['victim_employer_details']['employer_country'] . "', 
                    `employer_city`='" . $aParam['victim_employer_details']['employer_city'] . "', 
                    `employer_full_address`='" . $aParam['victim_employer_details']['employer_address'] . "', 
                    `employer_date_modified`=now(), 
                    `employer_date_modified_by`='" . $this->session->userdata('userData')['user_id'] . "', 
                    `employer_is_active`='1' 
                WHERE 
                    `employer_id` =  '" . $aParam['employer_id'] . "'
        ";
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function addEmployment($aParam) {

        //remove this field from coding but not in database
//       case_victim_employment_type`='" . $aParam['victim_employment_info']['employment_type'] . "', 

        $sql = "
                INSERT INTO 
                `icms_case_victim_employment` 
                SET 
                `case_victim_id` = '" . $aParam['case_victim_id'] . "', 
                `recruitment_agency_id_local` = " . $this->yel->checkifStringExist($aParam['local_agency_id']) . ", 
                `recruitment_agency_id_foreign` = " . $this->yel->checkifStringExist($aParam['foreign_agency_id']) . ", 
                `employer_id`= " . $this->yel->checkifStringExist($aParam['employer_id']) . ", 
                `case_victim_employment_is_documented`= '" . $aParam['victim_employment_info']['is_documented'] . "', 
                `case_victim_employment_date_added`= now(), 
                `case_victim_employment_added_by`='" . $this->session->userdata('userData')['user_id'] . "', 
                `case_victim_employment_added_by_agency`= '" . $this->session->userdata('userData')['agency_id'] . "', 
                `case_victim_employment_is_active`='1' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function addEmploymentDetails($aParam, $val) {
        $sql = "
                INSERT INTO 
                `icms_case_victim_employment_details` 
                SET 
                `case_victim_employment_id`= '" . $aParam['case_victim_employment_id'] . "', 
                `case_victim_employment_details_job_title`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['position']) . ", 
                `country_id`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['country']) . ", 
                `case_victim_employment_city`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['city']) . ", 
                `case_victim_employment_details_salary_in_foreign`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['salary']) . ", 
                `case_victim_employment_details_salary_foreign_iso`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['currency']) . ", 
                `case_victim_employment_details_salary_in_local`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['salary_in_peso']) . ", 
                `case_victim_employment_details_working_hours`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['working_hours']) . ", 
                `case_victim_employment_details_working_days`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['days_of_work']) . ",
                `employee_local_type_of_employment`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['employment_local_employment_type']) . ",
                `employee_local_type_of_child_cases`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['employment_local_child_case_type']) . ",
                `employee_local_region`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['employment_local_agency_region']) . ",
                `employee_local_province`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['employment_local_agency_province']) . ",
                `employee_local_city`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['employment_local_agency_city']) . ",
                `employee_local_barangay`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['employment_local_agency_barangay']) . ",
                `employee_local_age_started_working`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['employment_local_age_started_working']) . ",
                `employee_local_salary_per_hour`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['employment_local_agency_salary_per_hour']) . ",
                `employee_local_reason_for_employment`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['employment_local_agency_reason_for_employment']) . ", 
                `case_victim_employment_details_is_actual`= '" . $val . "' 
               ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function addEmploymentDetails_actualWork($aParam) {
        $sql2 = "
                INSERT INTO 
                `icms_case_victim_employment_details` 
                SET 
                `case_victim_employment_id`='" . $aParam['case_victim_employment_id'] . "', 
                `case_victim_employment_details_job_title`=  " . $this->yel->checkifStringExist($aParam['victim_employment_info']['act_position']) . ", 
                `country_id`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['act_country']) . ", 
                `case_victim_employment_city`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['act_city']) . ", 
                `case_victim_employment_details_salary_in_foreign`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['act_salary']) . ", 
                `case_victim_employment_details_salary_foreign_iso`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['act_currency']) . ", 
                `case_victim_employment_details_salary_in_local`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['act_salary_in_peso']) . ", 
                `case_victim_employment_details_working_hours`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['act_working_hours']) . ", 
                `case_victim_employment_details_working_days`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['act_days_of_work']) . ",
                `employee_local_type_of_employment`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['employment_local_employment_type']) . ",
                `employee_local_type_of_child_cases`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['employment_local_child_case_type']) . ",
                `employee_local_region`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['employment_local_agency_region']) . ",
                `employee_local_province`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['employment_local_agency_province']) . ",
                `employee_local_city`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['employment_local_agency_city']) . ",
                `employee_local_barangay`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['employment_local_agency_barangay']) . ",
                `employee_local_age_started_working`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['employment_local_age_started_working']) . ",
                `employee_local_salary_per_hour`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['employment_local_agency_salary_per_hour']) . ",
                `employee_local_reason_for_employment`= " . $this->yel->checkifStringExist($aParam['victim_employment_info']['employment_local_agency_reason_for_employment']) . ", 
                `case_victim_employment_details_is_actual`='1' 
               ";
        $aResponse = $this->yel->exec($sql2);
    }

    public function addDeployment($aParam) {


        $sql = "
                INSERT INTO 
                `icms_case_victim_deployment` 
                SET 
                `case_victim_id`='" . $aParam['case_victim_id'] . "', 
                `case_victim_deployment_document_is_falsified`='" . $aParam['victim_deployment_details']['deployment_document_is_falsified'] . "', 
                `case_victim_deployment_type`='" . $aParam['victim_deployment_details']['deployment_departure_type'] . "', 
                `case_victim_deployment_escorted_person_name`= " . $this->yel->checkifStringExist($aParam['victim_deployment_details']['deployment_escort_name']) . ", 
                `case_victim_deployment_escorted_details`= " . $this->yel->checkifStringExist($aParam['victim_deployment_details']['deployment_escort_description']) . ", 
                `case_victim_deployment_date`= " . $this->yel->checkDateIfExist($aParam['victim_deployment_details']['deployment_date']) . ",  
                `case_victim_deployment_arrival_date`= " . $this->yel->checkDateIfExist($aParam['victim_deployment_details']['deployment_arrival_date']) . ",  
                `case_victim_visa_category_id`='" . $aParam['victim_deployment_details']['deployment_visa_category'] . "', 
                `port_id`=" . $this->yel->checkifStringExist($aParam['victim_deployment_details']['port_of_exit']) . ", 
                `case_victim_deployment_other_port_details`= " . $this->yel->checkifStringExist($aParam['victim_deployment_details']['port_of_exit_description']) . ", 
                `case_victim_deployment_added_by`='" . $this->session->userdata('userData')['user_id'] . "', 
                `case_victim_deployment_date_added`= now(), 
                `case_victim_deployment_remark` = " . $this->yel->checkifStringExist($aParam['victim_deployment_details']['deployment_remark']) . ",
                `case_victim_deployment_is_active`='1' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function addPassport($aParam) {
        $sql = "
                INSERT INTO 
                `icms_victim_passport` 
                SET 
                `case_victim_id`= '" . $aParam['case_victim_id'] . "', 
                `victim_passport_number`= " . $this->yel->checkifStringExist($aParam['victim_passport_details']['passport_no']) . ", 
                `victim_passport_last_name`= " . $this->yel->checkifStringExist($aParam['victim_passport_details']['passport_last_name']) . ", 
                `victim_passport_middle_name`= " . $this->yel->checkifStringExist($aParam['victim_passport_details']['passport_middle_name']) . ", 
                `victim_passport_first_name`= " . $this->yel->checkifStringExist($aParam['victim_passport_details']['passport_first_name']) . ", 
                `victim_passport_suffix_name`= " . $this->yel->checkifStringExist($aParam['victim_passport_details']['passport_suffix']) . ", 
                `victim_passport_dob`= " . $this->yel->checkDateIfExist($aParam['victim_passport_details']['passport_dob']) . ",
                `victim_passport_province_pob`= " . $this->yel->checkifStringExist($aParam['victim_passport_details']['passport_province']) . ", 
                `victim_passport_city_pob`= " . $this->yel->checkifStringExist($aParam['victim_passport_details']['passport_city']) . ", 
                `victim_passport_gender`= " . $this->yel->checkifStringExist($aParam['victim_passport_details']['passport_sex']) . ", 
                `victim_passport_civil_status`= " . $this->yel->checkifStringExist($aParam['victim_passport_details']['passport_civil']) . ", 
                `victim_passport_date_issued`= " . $this->yel->checkDateIfExist($aParam['victim_passport_details']['passport_date_issued']) . ", 
                `victim_passport_date_expired`= " . $this->yel->checkDateIfExist($aParam['victim_passport_details']['passport_date_expired']) . ", 
                `victim_passport_place_issue`= " . $this->yel->checkifStringExist($aParam['victim_passport_details']['passport_place_issue']) . ", 
                `victim_passport_date_added`= now(), 
                `victim_passport_added_by`='" . $this->session->userdata('userData')['user_id'] . "'
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function addTransit($aParam, $val) {
        $sql = "
        INSERT INTO 
            `icms_case_victim_transit` 
        SET 
            `case_victim_id`='" . $aParam['case_victim_id'] . "', 
            `case_victim_transit_departure_country`=" . $this->yel->checkifStringExist($val['country_id']) . ", 
            `case_victim_transit_departure_city`=" . $this->yel->checkifStringExist($val['city']) . ", 
            `case_victim_transit_remarks`=" . $this->yel->checkifStringExist($val['remarks']) . ", 
            `case_victim_transit_departure_date`=" . $this->yel->checkDateIfExist($val['departure']) . ", 
            `case_victim_transit_arrival_date`=" . $this->yel->checkDateIfExist($val['arrival']) . ", 
            `case_victim_transit_is_active`='1' 
        ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    //case
    public function addComplainant($aParam) {
        //requested to be removed
        //`case_complainant_remarks`='" . $aParam['victim_complainant_details']['complainant_remarks'] . "', 
        $sql = "
                INSERT INTO 
                `icms_case_complainant` 
                SET 
                `case_victim_id`='" . $aParam['case_victim_id'] . "', 
                `case_complainant_source_id`=" . $this->yel->checkifStringExist($aParam['victim_complainant_details']['complainant_source']) . ", 
                `case_complainant_name`=" . $this->yel->checkifStringExist($aParam['victim_complainant_details']['complainant_name']) . ", 
                `case_complainant_contact_number`=" . $this->yel->checkifStringExist($aParam['victim_complainant_details']['complainant_contact']) . ",
                `case_complainant_alternate_contact_number`=" . $this->yel->checkifStringExist($aParam['victim_complainant_details']['complainant_alternate_contact']) . ", 
                `case_complainant_relation`=" . $this->yel->checkifStringExist($aParam['victim_complainant_details']['complainant_relation']) . ", 
                `case_complainant_address`=" . $this->yel->checkifStringExist($aParam['victim_complainant_details']['complainant_address']) . ",
                `case_complainant_place_of_incident`=" . $this->yel->checkifStringExist($aParam['victim_complainant_details']['complainant_place_of_incident']) . ",
                `case_complainant_place_of_destination`=" . $this->yel->checkifStringExist($aParam['victim_complainant_details']['complainant_place_of_destination']) . ",
                `case_complainant_place_of_origin`=" . $this->yel->checkifStringExist($aParam['victim_complainant_details']['complainant_place_of_origin']) . ",
                `case_complainant_date_time_of_incident`=" . $this->yel->checkifStringExist($aParam['victim_complainant_details']['complainant_date_time_of_incident']) . ",
                `case_complainant_other_possible_source`=" . $this->yel->checkifStringExist($aParam['victim_complainant_details']['complainant_other_possible_source_info']) . ", 
                `case_complainant_date_complained`=" . $this->yel->checkDateIfExist($aParam['victim_complainant_details']['date_complained']) . ", 
                `case_complainant_relation_other`=" . $this->yel->checkifStringExist($aParam['victim_complainant_details']['complainant_relation_other']) . ", 
                `case_complainant_date_added`= now(), 
                `case_complainant_added_by`='" . $this->session->userdata('userData')['user_id'] . "',  
                `case_complainant_date_modified`= now(), 
                `case_complainant_modified_by`='" . $this->session->userdata('userData')['user_id'] . "',  
                `case_complainant_is_active`= '1' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function addOffender($aParam, $val) {
        $sql = "
                INSERT INTO 
                `icms_case_offender` 
                SET 
                 `case_id`='" . $aParam['case_id'] . "', 
                `case_offender_type_id`=" . $this->yel->checkifStringExist($val['offender_type']) . ", 
                `case_offender_name`=" . $this->yel->checkifStringExist($val['offender_name'] ?? '') . ", 
                `case_offender_nationality`=" . $this->yel->checkifStringExist($val['offender_nationality'] ?? '') . ", 
                `case_offender_other`=" . $this->yel->checkifStringExist($val['offender_relation'] ?? '') . ", 
                `case_offender_address`=" . $this->yel->checkifStringExist($val['offender_address'] ?? '') . ", 
                `case_offender_contact_details`=" . $this->yel->checkifStringExist($val['offender_contact'] ?? '') . ", 
                `case_offender_remarks`=" . $this->yel->checkifStringExist($val['offender_remarks'] ?? '') . ",
                `case_offender_alias`=" . $this->yel->checkifStringExist($val['offender_alias'] ?? '') . ",
                `case_offender_pob`=" . $this->yel->checkifStringExist($val['offender_pob'] ?? '') . ",
                `case_offender_dob`=" . $this->yel->checkDateIfExist($val['offender_dob'] ?? '') . ",
                `case_offender_occupation`=" . $this->yel->checkifStringExist($val['offender_occupation'] ?? '') . ",
                `case_offender_principal_place_of_business`=" . $this->yel->checkifStringExist($val['offender_principal_place_of_business'] ?? '') . ",
                `case_offender_gender`=" . $this->yel->checkifStringExist($val['offender_gender'] ?? '') . ",
                `case_offender_religion`=" . $this->yel->checkifStringExist($val['offender_religion'] ?? '') . ",
                `case_offender_race_ethnicity`=" . $this->yel->checkifStringExist($val['offender_race_ethnicity'] ?? '') . ",
                `case_offender_civil_status`=" . $this->yel->checkifStringExist($val['offender_civil_status'] ?? '') . ",
                `case_offender_previous_case_commited`=" . $this->yel->checkifStringExist($val['offender_previous_case_committed'] ?? '') . ",
                `case_offender_name_of_parents`=" . $this->yel->checkifStringExist($val['offender_name_of_parents'] ?? '') . ",
                `case_offender_name_of_spouse`=" . $this->yel->checkifStringExist($val['offender_name_of_spouse'] ?? '') . ",
                `case_offender_socialmedia`=" . $this->yel->checkifStringExist($val['offender_socialmedia'] ?? '') . ",
                `case_offender_email_address`=" . $this->yel->checkifStringExist($val['offender_email_address'] ?? '') . ",
                `case_offender_place_of_arrest`=" . $this->yel->checkifStringExist($val['offender_place_of_arrest'] ?? '') . ",
                `case_offender_date_of_arrest`=" . $this->yel->checkDateIfExist($val['offender_date_of_arrest'] ?? '') . ",
                `case_offender_is_at_large`=" . $this->yel->checkifStringExist($val['offender_is_at_large'] ?? '') . ",   
                `case_offender_is_active`= '1' 
                ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function addCaseActTIP($aParam, $val) {
        $sql = "
                INSERT INTO 
                `icms_case_victim_tip` 
                SET 
                `case_victim_id`='" . $aParam['case_victim_id'] . "', 
                `case_victim_tip_type_id`='1', 
                `case_victim_tip_type_content_id`='" . $val['act_id'] . "', 
                `case_victim_tip_type_added_by`='" . $this->session->userdata('userData')['user_id'] . "',  
                `case_victim_tip_date_added`=now(), 
                `case_victim_tip_is_active`= '1' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function addCaseMeanTIP($aParam, $val) {
        $sql = "
                INSERT INTO 
                `icms_case_victim_tip` 
                SET 
                `case_victim_id`='" . $aParam['case_victim_id'] . "', 
                `case_victim_tip_type_id`='3', 
                `case_victim_tip_type_content_id`='" . $val['mean_id'] . "', 
                `case_victim_tip_type_added_by`='" . $this->session->userdata('userData')['user_id'] . "',  
                `case_victim_tip_date_added`=now(), 
                `case_victim_tip_is_active`= '1' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function addCasePurposeTIP($aParam, $val) {
        $sql = "
                INSERT INTO 
                `icms_case_victim_tip` 
                SET 
                `case_victim_id`='" . $aParam['case_victim_id'] . "', 
                `case_victim_tip_type_id`='2', 
                `case_victim_tip_type_content_id`='" . $val['purpose_id'] . "', 
                `case_victim_tip_type_added_by`='" . $this->session->userdata('userData')['user_id'] . "',  
                `case_victim_tip_date_added`=now(), 
                `case_victim_tip_is_active`= '1' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function addCaseService($aParam, $val) {
        $sql = "
                INSERT INTO 
                    `icms_case_victim_services` 
                SET 
                    `case_victim_id`='" . $aParam['case_victim_id'] . "', 
                    `services_id`='" . $val['services'] . "', 
                    `case_victim_services_remarks`= " . $this->yel->checkifStringExist($val['remarks']) . ", 
                    `case_victim_services_assessment_type`='" . $val['assessment_type'] . "',  
                    `case_victim_services_aging_date`= " . $this->yel->checkDateIfExist($val['aging']) . ",  
                    `case_victim_services_departure_date`= " . $this->yel->checkDateTimeIfExist($val['departure']) . ",  
                    `case_victim_services_arrival_date`= " . $this->yel->checkDateTimeIfExist($val['arrival']) . ",  
                    `case_victim_services_is_active`= '1' 
               ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function addServicesAgency($aParam, $val) {
        $sql = "
                INSERT INTO 
                `icms_case_victim_services_agency_tag` 
                SET 
                `case_victim_services_id`='" . $aParam['case_victim_services_id'] . "', 
                `agency_branch_id`='" . $val['agency_id'] . "', 
                `case_victim_services_agency_tag_added_by`='" . $this->session->userdata('userData')['user_id'] . "',  
                `case_victim_services_agency_tag_added_date`=now(), 
                `case_victim_services_agency_tag_is_active`= '1' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function getAgencyDetailsToBeTagged($aParam, $val) {
        $qry = "SELECT   
                    `ab`.`agency_branch_name`,
                    `ag`.`agency_abbr`
                FROM 
                    `icms_agency_branch` `ab`,
                    `icms_agency` `ag`
                WHERE 
                    `ab`.`agency_branch_id`='" . $val['agency_id'] . "'
                AND `ag`.`agency_id`=`ab`.`agency_id`
                LIMIT 1
                ";
        $aResponse = $this->yel->GetRow($qry);
        return $aResponse;
    }

    public function taggedAgencyBranchAdmin($aParam, $val) {
        $qry = "  SELECT   
                    `user_id` 
                FROM 
                    `icms_user` 
                WHERE 
                    `agency_branch_id`='" . $val['agency_id'] . "'
                AND `user_level_id`='1'
                AND `user_is_active`='1'
                LIMIT 1
                ";
        $user_id = $this->yel->GetOne($qry);

        $sql = "
                INSERT INTO 
                `icms_case_tagged_users` 
                SET 
                `case_id`='" . $aParam['case_id'] . "', 
                `agency_branch_id`='" . $val['agency_id'] . "', 
                `user_id`='" . $user_id . "',
                `case_tagged_users_status`='1',
                `case_tagged_users_added_by`='" . $this->session->userdata('userData')['user_id'] . "',  
                `case_tagged_users_modified_by`='" . $this->session->userdata('userData')['user_id'] . "'
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function addCaseDocuments($aParam, $val) {
        $__sql = "
                INSERT INTO 
                `icms_case_file_upload` 
                SET 
                `case_id`='" . $aParam['case_id'] . "', 
                `document_hash`='" . $val['document_hash'] . "', 
                `case_file_upload_category`='" . $val['doc_category'] . "', 
                `case_file_upload_type`='" . $val['doc_type'] . "', 
                `case_file_upload_remarks`='" . $val['doc_remark'] . "',  
                `case_file_upload_added_by`='" . $this->session->userdata('userData')['user_id'] . "',  
                `case_file_upload_date_added`=now(), 
                `case_file_upload_is_active`= '1' 
        ";

        $sql = "
                INSERT INTO 
                `icms_case_file_upload` 
                SET 
                `case_id`='" . $aParam['case_id'] . "', 
                `document_hash`='" . $val['document_hash'] . "', 
                `case_file_upload_remarks`='" . $val['doc_remark'] . "',  
                `case_file_upload_added_by`='" . $this->session->userdata('userData')['user_id'] . "',  
                `case_file_upload_date_added`=now(), 
                `case_file_upload_is_active`= '1' 
        ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function getDocumentTypeAndCategory($aNewParam, $val) {

        $sql = "SELECT
                (SELECT `parameter_name` FROM `icms_global_parameter` WHERE `parameter_type_id` = 17 AND  `parameter_count_id`='" . $val['doc_category'] . "') as `category`,
                (SELECT `parameter_name` FROM `icms_global_parameter` WHERE `parameter_type_id` = 18 AND  `parameter_count_id`='" . $val['doc_type'] . "') as `docType`
             ";
        $aResponse = $this->yel->getRow($sql);
        return $aResponse;
    }

    public function getCaseDetailsById($aParam) {
        $aResponse = [];
        $sql = " 
            SELECT
                `ic`.`case_id`,
                `ic`.`case_number`,
                `ic`.`case_criminal_case`,
                `ic`.`case_facts`, 
                DATE_FORMAT(`ic`.`case_date_added`, '%M %d, %Y %r') as `case_date_added`, 
                DATE_FORMAT(`ic`.`case_date_modified`, '%M %d, %Y %r') as `case_date_last_updated`,
                `ic`.`case_added_by`,
                `ic`.`case_status_id`, 
                `ic`.`case_priority_level_id`,
                (SELECT COUNT(1)  FROM  `icms_case_victim` `cv`  WHERE  `cv`.`case_id` = `ic`.`case_id` LIMIT 1) as `victim_count`,
                (SELECT CONCAT(`user_firstname`, ' ', `user_lastname`) FROM `icms_user` WHERE `user_id` = `ic`.`case_added_by` LIMIT 1) as `filed_by`,
                (SELECT CONCAT(`ab`.`agency_branch_name`, ' (',(SELECT `agency_abbr` FROM `icms_agency` WHERE `agency_id` = `ab`.`agency_id` LIMIT 1),')') FROM `icms_agency_branch` `ab` WHERE `ab`.`agency_branch_id` = (SELECT `agency_branch_id` FROM `icms_user` WHERE `user_id` = `ic`.`case_added_by` LIMIT 1) LIMIT 1) as `filed_by_agency`,
                (SELECT `transaction_parameter_name` FROM `icms_transaction_parameter` WHERE `transaction_parameter_type_id`='2' AND `transaction_parameter_count_id`=`ic`.`case_priority_level_id` LIMIT 1) as priority_level, 
                (SELECT `transaction_parameter_name` FROM `icms_transaction_parameter` WHERE `transaction_parameter_type_id`='3' AND `transaction_parameter_count_id`=`ic`.`case_status_id` LIMIT 1) as case_status
            FROM
                `icms_case` `ic`
            WHERE 
                `ic`.`case_id` = " . $aParam['case_id'] . "
        ";
        $aResponse = $this->yel->getRow($sql);
        return $aResponse;
    }

    public function getCaseVictimListByCaseId($aParam) {
        $aResponse = [];
        $sql = "
                SELECT 
                    `v`.`victim_number`,
                    `vi`.`victim_info_first_name`, 
                    `vi`.`victim_info_middle_name`, 
                    `vi`.`victim_info_last_name`, 
                    `vi`.`victim_info_suffix`
                FROM 
                    `icms_case_victim` `cv`, 
                    `icms_victim_info` `vi`, 
                    `icms_victim` `v`
                WHERE 
                    `cv`.`case_id` = " . $aParam['case_id'] . "
                AND `cv`.`victim_id` = `vi`.`victim_id` 
                AND `cv`.`victim_id` = `v`.`victim_id`               
                ORDER BY `vi`.`victim_info_date_added` DESC
            ";
        $aResponse = $this->yel->getAll($sql);
        return $aResponse;
    }

    public function getCaseVictimEmploymentByCaseVictimId($aParam) {
        $aResponse = [];
        $sql = "
                SELECT `cve`.`*` 
                FROM 
                `icms_case_victim_employment` `cve` 
                WHERE 
                `cve`.`case_victim_id`='" . $aParam['case_victim_id'] . "' 
               ";

        $aResponse = $this->yel->getRow($sql);
        return $aResponse;
    }

    public function getCaseVictimEmploymentDetailsByEmploymentId($aParam) {
        $aResponse = [];
        $sql = "
                SELECT `cve`.`*` 
                FROM 
                `icms_case_victim_employment_details` `cve` 
                WHERE 
                `cve`.`case_victim_employment_id`='" . $aParam['case_victim_employment_id'] . "' 
                AND 
                `cve`.`case_victim_employment_details_is_actual` = '0' 
               ";

        $aResponse = $this->yel->getRow($sql);
        return $aResponse;
    }

    public function getCaseVictimEmploymentDetailsActualByEmploymentId($aParam) {
        $aResponse = [];
        $sql = "
                SELECT `cve`.`*` 
                FROM 
                `icms_case_victim_employment_details` `cve` 
                WHERE 
                `cve`.`case_victim_employment_id`='" . $aParam['case_victim_employment_id'] . "' 
                AND 
                `cve`.`case_victim_employment_details_is_actual` = '1' 
               ";

        $aResponse = $this->yel->getRow($sql);
        return $aResponse;
    }

    public function getCaseVictimEmploymentEmployerByEmployerId($aParam) {
        $aResponse = [];
        $sql = "
                SELECT `emp`.`*` 
                FROM 
                `icms_employer` `emp` 
                WHERE 
                `emp`.`employer_id`='" . $aParam['employer_id'] . "' 
               ";

        $aResponse = $this->yel->getRow($sql);
        return $aResponse;
    }

    public function getCaseVictimLocalRecruitmentById($aParam) {
        $aResponse = [];
        $sql = "
                SELECT `rec`.`*` 
                FROM 
                `icms_recruitment_agency` `rec` 
                WHERE 
                `rec`.`recruitment_agency_id`='" . $aParam['recruitment_agency_id_local'] . "' 
               ";

        $aResponse = $this->yel->getRow($sql);
        return $aResponse;
    }

    public function getCaseVictimForeignRecruitmentById($aParam) {
        $aResponse = [];
        $sql = "
                SELECT `rec`.`*` 
                FROM 
                `icms_recruitment_agency` `rec` 
                WHERE 
                `rec`.`recruitment_agency_id`='" . $aParam['recruitment_agency_id_foreign'] . "' 
               ";

        $aResponse = $this->yel->getRow($sql);
        return $aResponse;
    }

    public function getCaseVictimDeploymentByCaseVictimId($aParam) {
        $aResponse = [];
        $sql = "
                SELECT `dep`.`*` 
                FROM 
                `icms_case_victim_deployment` `dep` 
                WHERE 
                `dep`.`case_victim_id`='" . $aParam['case_victim_id'] . "' 
               ";

        $aResponse = $this->yel->getRow($sql);
        return $aResponse;
    }

    public function getCaseVictimPassportByCaseVictimId($aParam) {
        $aResponse = [];
        $sql = "
                SELECT `pas`.`*` 
                FROM 
                `icms_victim_passport` `pas` 
                WHERE 
                `pas`.`case_victim_id`='" . $aParam['case_victim_id'] . "' 
               ";

        $aResponse = $this->yel->getRow($sql);
        return $aResponse;
    }

    public function getCaseVictimTransitByCaseVictimId($aParam) {
        $aResponse = [];
        $sql = "
                SELECT `tra`.`*`, 
                (SELECT `country_name` FROM `icms_global_country` `ctry` WHERE `country_id` = `tra`.`case_victim_transit_departure_country`) AS case_victim_transit_departure_country_name 
                FROM 
                `icms_case_victim_transit` `tra`
                WHERE 
                `tra`.`case_victim_transit_is_active` = '1' 
                AND 
                `tra`.`case_victim_id`='" . $aParam['case_victim_id'] . "' 
               ";


        $aResponse = $this->yel->getAll($sql);
        return $aResponse;
    }

    public function removeVictimTransitInfoById($aParam) {
        $sql = "
                UPDATE  
                `icms_case_victim_transit` 
                SET 
                `case_victim_transit_is_active`='0' 
                WHERE 
                `case_victim_transit_id` = '" . $aParam['case_victim_transit_id'] . "' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function addVictimTransitInfo($aParam) {

        $sql = "
                INSERT INTO 
                `icms_case_victim_transit` 
                SET 
                `case_victim_id`='" . $aParam['case_victim_id'] . "', 
                `case_victim_transit_departure_country`='" . $aParam['case_victim_transit_departure_country'] . "', 
                `case_victim_transit_departure_state`='" . $aParam['case_victim_transit_departure_state'] . "', 
                `case_victim_transit_departure_date`= " . $this->yel->checkDateIfExist($aParam['case_victim_transit_departure_date']) . ", 
                `case_victim_transit_arrival_date`= " . $this->yel->checkDateIfExist($aParam['case_victim_transit_arrival_date']) . ", 
                `case_victim_transit_remarks`='" . $aParam['case_victim_transit_remarks'] . "' 
                `case_victim_transit_is_active`='1' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function getVictimTransitInfoById($aParam) {
        $sql = "
                SELECT * FROM 
                `icms_case_victim_transit` 
                WHERE 
                `case_victim_transit_id` = '" . $aParam['case_victim_transit_id'] . "' 
               ";

        $aResponse = $this->yel->getRow($sql);

        return $aResponse;
    }

    public function updateVictimTransitInfoById($aParam) {
        $sql = "
                UPDATE  
                    `icms_case_victim_transit` 
                SET 
                    `case_victim_transit_departure_country`='" . $aParam['case_victim_transit_departure_country'] . "', 
                    `case_victim_transit_departure_city` = '" . $aParam['case_victim_transit_departure_city'] . "', 
                    `case_victim_transit_departure_date` = " . $this->yel->checkDateIfExist($aParam['case_victim_transit_departure_date']) . ", 
                    `case_victim_transit_arrival_date` = " . $this->yel->checkDateIfExist($aParam['case_victim_transit_arrival_date']) . ",
                    `case_victim_transit_remarks` = '" . $aParam['case_victim_transit_remarks'] . "' 
                WHERE 
                    `case_victim_transit_id` = '" . $aParam['transid'] . "' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function getVictimIDByCaseId($case_id) {
        $sql = "
                SELECT 
                    `victim_id`
                FROM 
                    `icms_case_victim`
                WHERE
                    `case_id`='" . $case_id . "'
                LIMIT 1
              ";
        $victim_id = $this->yel->GetOne($sql);
        return $victim_id;
    }

    public function getCaseDetailsByCaseID($case_id) {
        $aResponse = [];
        $sql = "
                SELECT 
                    `c`.`case_id`, 
                    `c`.`case_number` ,
                    `c`.`case_date_added`,
                    (SELECT `b`.`agency_branch_name` FROM  `icms_agency_branch` `b`,`icms_user` `u` WHERE `u`.`user_id`=`c`.`case_added_by` AND `b`.`agency_branch_id`=`u`.`agency_branch_id` LIMIT 1) as agency_branch,
                    (SELECT `a`.`agency_abbr` FROM  `icms_agency_branch` `b`,`icms_user` `u`, `icms_agency` `a` WHERE `u`.`user_id`=`c`.`case_added_by` AND `b`.`agency_branch_id`=`u`.`agency_branch_id` AND `a`.`agency_id`=`b`.`agency_id` LIMIT 1) as agency_abbr,
                    (SELECT `a`.`agency_name` FROM  `icms_agency_branch` `b`,`icms_user` `u`, `icms_agency` `a` WHERE `u`.`user_id`=`c`.`case_added_by` AND `b`.`agency_branch_id`=`u`.`agency_branch_id` AND `a`.`agency_id`=`b`.`agency_id` LIMIT 1) as agency_name
                FROM 
                    `icms_case` `c`
                WHERE
                    `c`.`case_id`='" . $case_id . "'
                LIMIT 1
              ";
        $aResponse = $this->yel->GetRow($sql);
        return $aResponse;
    }

    public function getVictimDetailsByVictimID($victim_id) {
        $aResponse = [];
        $sql = "
                SELECT 
                    `v`.`victim_number`,
                    `i`.`victim_info_first_name`,
                    `i`.`victim_info_middle_name`,
                    `i`.`victim_info_last_name`,
                    `i`.`victim_info_suffix`
                   FROM 
                    `icms_victim` `v`,
                    `icms_victim_info` `i`
                WHERE
                    `v`.`victim_id`='" . $victim_id . "'
                AND `i`.`victim_id`=`v`.`victim_id`
                LIMIT 1
              ";
        $aResponse = $this->yel->GetRow($sql);
        return $aResponse;
    }

    public function getVictimNumberByVictimId($victim_id) {
        $sql = "
                SELECT 
                    `v`.`victim_number`
                   FROM 
                    `icms_victim` `v`
                WHERE
                    `v`.`victim_id`='" . $victim_id . "'
                LIMIT 1
              ";
        $aResponse = $this->yel->GetOne($sql);
        return $aResponse;
    }

    public function getCaseVictimDetails($aParam) {
        $aResponse = [];
        $sql = "
                SELECT 
                   `case_victim_id`
                FROM 
                   `icms_case_victim`
                WHERE
                    `victim_id`='" . $aParam['victim_id'] . "'
                AND `case_id`='" . $aParam['case_id'] . "'
                LIMIT 1
              ";
        $aResponse = $this->yel->GetRow($sql);
        return $aResponse;
    }

    public function getCaseVictimIdByCaseId($aParam) {
        $sql = "
                SELECT 
                    `case_victim_id`
                FROM 
                    `icms_case_victim`
                WHERE 
                    `case_id`='" . $aParam['case_id'] . "'
                LIMIT 1
              ";
        $aResponse = $this->yel->GetOne($sql);
        return $aResponse;
    }

    public function getEmploymentInformation($aParam) {
        $aResponse = [];
        $sql = "
                SELECT 
                   `icve`.`case_victim_employment_id`,
                   `icve`.`case_victim_employment_is_documented`,
                   `icved`.`case_victim_employment_details_id`,
                   `icved`.`case_victim_employment_details_job_title`,
                   `icved`.`case_victim_employment_details_job_title_description`,
                   `icved`.`country_id`,
                   `icved`.`case_victim_employment_city`,
                   `icved`.`case_victim_employment_details_salary_in_foreign`,
                   `icved`.`case_victim_employment_details_salary_foreign_iso`,
                   `icved`.`case_victim_employment_details_salary_in_local`,
                   `icved`.`case_victim_employment_details_working_hours`,
                   `icved`.`case_victim_employment_details_working_in_out`,
                   `icved`.`case_victim_employment_details_working_days`,
                   `icved`.`employee_local_type_of_employment`,
                   `icved`.`employee_local_type_of_child_cases`,
                   `icved`.`employee_local_region`,
                   `icved`.`employee_local_province`,
                   `icved`.`employee_local_city`,
                   `icved`.`employee_local_barangay`,
                   `icved`.`employee_local_age_started_working`,
                   `icved`.`employee_local_salary_per_hour`,
                   `icved`.`employee_local_reason_for_employment`
                FROM 
                   `icms_case_victim_employment` `icve`,
                   `icms_case_victim_employment_details` `icved`
                WHERE
                    `icve`.`case_victim_id`='" . $aParam['case_victim_id'] . "'
                AND `icved`.`case_victim_employment_id`= `icve`.`case_victim_employment_id`
                AND `icved`.`case_victim_employment_details_is_actual`='" . $aParam['is_contract'] . "'
                
                LIMIT 1
              ";
        $aResponse = $this->yel->GetRow($sql);
        return $aResponse;
    }

    public function setVictimEmploymentType($aParam) {
        $aResponse = [];
        $sql = "
                UPDATE 
                   `icms_case_victim_employment`
                SET
                   `case_victim_employment_is_documented`='" . $aParam['is_documented'] . "'
                WHERE
                    `case_victim_employment_id`='" . $aParam['datacveid'] . "'
              ";
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function getEmploymentDetails($aParam) {
        $aResponse = [];
        $sql = "
                SELECT 
                   `ed`.`case_victim_employment_details_job_title` as `job_title`,
                   (SELECT `country_name` FROM`icms_global_country` WHERE `country_id`=`ed`.`country_id` LIMIT 1) as `country`,
                   `ed`.`case_victim_employment_city` as `employment_city`,
                   `ed`.`case_victim_employment_details_salary_in_foreign` as `foreign_salary`,
                   `ed`.`case_victim_employment_details_salary_foreign_iso` as `currency_iso`,
                   `ed`.`case_victim_employment_details_salary_in_local` as `local_salary`,
                   `ed`.`case_victim_employment_details_working_hours` as `working_hours`,
                   `ed`.`case_victim_employment_details_working_days` as `working_days`
                FROM
                    `icms_case_victim_employment_details`  `ed`
                WHERE
                    `ed`.`case_victim_employment_details_id`='" . $aParam['datacvedetid'] . "'
                LIMIT 1
              ";
        $aResponse = $this->yel->GetRow($sql);
        return $aResponse;
    }

    public function setCaseVictimEmploymentDetails($aParam) {
        $sql = "
                UPDATE 
                    `icms_case_victim_employment_details`
                SET
                  `case_victim_employment_details_job_title`='" . $aParam['jobtitle'] . "',
                  `country_id`= " . $this->yel->checkifStringExist($aParam['country_id']) . ",
                  `case_victim_employment_city`='" . $aParam['city'] . "',
                  `case_victim_employment_details_salary_in_foreign`='" . $aParam['salary_foreign'] . "',
                  `case_victim_employment_details_salary_foreign_iso`='" . $aParam['foreign_iso'] . "',
                  `case_victim_employment_details_salary_in_local` ='" . $aParam['salary_local'] . "',
                  `case_victim_employment_details_working_hours`='" . $aParam['working_hours'] . "',
                  `case_victim_employment_details_working_days`='" . $aParam['working_days'] . "',
                  `employee_local_type_of_employment`='" . $aParam['type_employment_local'] . "',
                  `employee_local_type_of_child_cases`='" . $aParam['type_child_case_local'] . "',
                  `employee_local_age_started_working`='" . $aParam['age_started_working_local'] . "',
                  `employee_local_salary_per_hour`='" . $aParam['salary_per_hour_local'] . "',
                  `employee_local_reason_for_employment`='" . $aParam['reasons_for_employment_local'] . "'
                WHERE
                    `case_victim_employment_details_id`='" . $aParam['datacvedetid'] . "'
              ";
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function getEmployerInformation($aParam) {
        $aResponse = [];
        $sql = "
                SELECT 
                   `icve`.`case_victim_employment_id`,
                   `icve`.`employer_id`,
                   `emp`.`employer_name`,
                   `emp`.`employer_representative_name`,
                   `emp`.`employer_tel_no`,
                   `emp`.`employer_email`,
                   `emp`.`employer_country_id`,
                   `emp`.`employer_city`,
                   `emp`.`employer_full_address`        
                FROM 
                   `icms_case_victim_employment` `icve`,
                   `icms_employer` `emp`
                WHERE
                    `icve`.`case_victim_id`='" . $aParam['case_victim_id'] . "'
                AND `emp`.`employer_id`=`icve`.`employer_id`
                LIMIT 1
              ";
        $aResponse = $this->yel->GetRow($sql);
        return $aResponse;
    }

    public function getEmployerInformationByEmployerId($aParam) {
        $aResponse = [];
        $sql = "
                SELECT 
                   `emp`.`employer_name`,
                   `emp`.`employer_representative_name`,
                   `emp`.`employer_tel_no`,
                   `emp`.`employer_email`,
                   (SELECT `country_name` FROM`icms_global_country` WHERE `country_id`=`emp`.`employer_country_id` LIMIT 1) as `employer_country`,
                   `emp`.`employer_city`,
                   `emp`.`employer_full_address`        
                FROM 
                   `icms_employer` `emp`
                WHERE
                    `emp`.`employer_id`='" . $aParam['emp_id'] . "'
                LIMIT 1
              ";
        $aResponse = $this->yel->GetRow($sql);
        return $aResponse;
    }

    public function setCaseVictimEmployerDetails($aParam) {
        $sql = "
                UPDATE
                    `icms_employer`
                SET
                    `employer_name`='" . $aParam['emp_name'] . "',
                    `employer_representative_name`='" . $aParam['rep_name'] . "',
                    `employer_tel_no`='" . $aParam['telno'] . "',
                    `employer_email`='" . $aParam['email'] . "',
                    `employer_country_id`='" . $aParam['country'] . "',
                    `employer_city`='" . $aParam['city'] . "',
                    `employer_full_address`='" . $aParam['emp_address'] . "',
                    `employer_date_modified_by`='" . $_SESSION['userData']['user_id'] . "'
                WHERE
                    `employer_id`='" . $aParam['emp_id'] . "'
               ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function setCaseVictimEmployer($aParam) {
        $sql = "
                UPDATE
                    `icms_case_victim_employment`
                SET
                    `employer_id`='" . $aParam['emp_id'] . "'
                WHERE
                    `case_victim_id`= (SELECT `cv`.`case_victim_id` FROM `icms_case_victim` `cv` WHERE `cv`.`case_id` =  '" . $aParam['caseid'] . "'  LIMIT 1 )
               ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function setCaseVictimEmploymentLocalAgency($aParam) {
        $sql = "
                UPDATE
                    `icms_case_victim_employment`
                SET
                    `recruitment_agency_id_local`='" . $aParam['agn_id'] . "'
                WHERE
                     `case_victim_id`= (SELECT `cv`.`case_victim_id` FROM `icms_case_victim` `cv` WHERE `cv`.`case_id` =  '" . $aParam['caseid'] . "'  LIMIT 1 )
               ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function setCaseVictimEmploymentForeignAgency($aParam) {
        $sql = "
                UPDATE
                    `icms_case_victim_employment`
                SET
                    `recruitment_agency_id_foreign`='" . $aParam['agn_id'] . "'
                WHERE
                    `case_victim_id`= (SELECT `cv`.`case_victim_id` FROM `icms_case_victim` `cv` WHERE `cv`.`case_id` =  '" . $aParam['caseid'] . "'  LIMIT 1 )
               ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function getRecruitmentInformation_local($aParam) {
        $aResponse = [];

        $sql = "
                SELECT 
                   `rect`.`recruitment_agency_id`
                FROM 
                   `icms_case_victim_employment` `icve`,
                   `icms_recruitment_agency` `rect`
                WHERE
                    `icve`.`case_victim_id`='" . $aParam['case_victim_id'] . "'
                AND `rect`.`recruitment_agency_id`=`icve`.`recruitment_agency_id_local`
                AND `rect`.`recruitment_agency_is_active`='1'
                LIMIT 1
              ";
        $aResponse['recruitment_agency_id'] = $this->yel->GetOne($sql);

        $sql = "
                SELECT 
                   `icve`.`case_victim_employment_id`,
                   `icve`.`recruitment_agency_id_local`,
                   `rect`.`recruitment_agency_name`,
                   `rect`.`recruitment_agency_address`,
                   `rect`.`recruitment_agency_tel_no`,
                   `rect`.`recruitment_agency_email`,
                   `rect`.`recruitment_agency_fax_no`,
                   `rect`.`recruitment_agency_website`,
                   `rect`.`country_id`,
                   `rect`.`region_id`, 
                   `rect`.`province_id`
                FROM 
                   `icms_case_victim_employment` `icve`,
                   `icms_recruitment_agency` `rect`
                WHERE
                    `icve`.`case_victim_id`='" . $aParam['case_victim_id'] . "'
                AND `rect`.`recruitment_agency_id`=`icve`.`recruitment_agency_id_local`
                AND `rect`.`recruitment_agency_is_active`='1'
                LIMIT 1
              ";
        $aResponse['details'] = $this->yel->GetRow($sql);

        $aResponse['owner'] = $this->getRecruitmentPersonInformation($aResponse['recruitment_agency_id'], 1);
        $aResponse['representative'] = $this->getRecruitmentPersonInformation($aResponse['recruitment_agency_id'], 2);
        $aResponse['agent'] = $this->getRecruitmentPersonInformation($aResponse['recruitment_agency_id'], 3);

        return $aResponse;
    }

    /*
     * $id = recruitment_agency_id; 
     * $type = recruitment_agency_info_type_id
     * 1 = Owner
     * 2 = Representative 
     * 3 = Agent 
     */

    private function getRecruitmentPersonInformation($id, $type) {
        $sql = " 
            SELECT 
                `recruitment_agency_info_name` as `name`, 
                `recruitment_agency_info_address` as `address`, 
                `recruitment_agency_info_contact_number` as `contact`
            FROM 
                `icms_recruitment_agency_info`
            WHERE 
                `recruitment_agency_id` = '" . $id . "'
            AND `recruitment_agency_info_type_id` = '" . $type . "'
        ";
        $aResponse = $this->yel->GetRow($sql);
        return $aResponse;
    }

    public function getRecruitmentInformation_foreign($aParam) {
        $aResponse = [];

        $sql = "
                SELECT 
                   `rect`.`recruitment_agency_id`
                FROM 
                   `icms_case_victim_employment` `icve`,
                   `icms_recruitment_agency` `rect`
                WHERE
                    `icve`.`case_victim_id`='" . $aParam['case_victim_id'] . "'
                AND `rect`.`recruitment_agency_id`=`icve`.`recruitment_agency_id_foreign`
                AND `rect`.`recruitment_agency_is_active`='1'
                LIMIT 1
              ";
        $aResponse['recruitment_agency_id'] = $this->yel->GetOne($sql);

        $sql = "
                SELECT 
                   `icve`.`case_victim_employment_id`,
                   `icve`.`recruitment_agency_id_foreign`,
                   `rect`.`recruitment_agency_name`,
                   `rect`.`recruitment_agency_address`,
                   `rect`.`recruitment_agency_tel_no`,
                   `rect`.`recruitment_agency_email`,
                   `rect`.`recruitment_agency_fax_no`,
                   `rect`.`recruitment_agency_website`,
                   `rect`.`country_id`,
                   `rect`.`recruitment_agency_owner_name`,
                   `rect`.`recruitment_agency_owner_address`,
                   `rect`.`recruitment_agency_owner_contact_no`
                FROM 
                   `icms_case_victim_employment` `icve`,
                   `icms_recruitment_agency` `rect`
                WHERE
                    `icve`.`case_victim_id`='" . $aParam['case_victim_id'] . "'
                AND `rect`.`recruitment_agency_id`=`icve`.`recruitment_agency_id_foreign`
                AND `rect`.`recruitment_agency_is_active`='1'
                LIMIT 1
              ";
        $aResponse['details'] = $this->yel->GetRow($sql);

        $aResponse['owner'] = $this->getRecruitmentPersonInformation($aResponse['recruitment_agency_id'], 1);
        $aResponse['representative'] = $this->getRecruitmentPersonInformation($aResponse['recruitment_agency_id'], 2);
        $aResponse['agent'] = $this->getRecruitmentPersonInformation($aResponse['recruitment_agency_id'], 3);

        return $aResponse;
    }

    public function getRecruitmentDetailsByRecruitmentId($aParam) {
        $sql = "  
                SELECT
                    `ra`.`recruitment_agency_name`,
                    `ra`.`recruitment_agency_address`,
                    `ra`.`recruitment_agency_tel_no`,
                    `ra`.`recruitment_agency_email`,
                    `ra`.`recruitment_agency_fax_no`,
                    `ra`.`recruitment_agency_website`,
                    (SELECT `country_name` FROM`icms_global_country` WHERE `country_id`=`ra`.`country_id` LIMIT 1) as `country`,
                    `ra`.`recruitment_agency_owner_name`,
                    `ra`.`recruitment_agency_owner_address`,
                    `ra`.`recruitment_agency_owner_contact_no`, 
                    `ra`.`recruitment_agency_is_local`
                FROM 
                    `icms_recruitment_agency` `ra`
                WHERE
                    `ra`.`recruitment_agency_id`='" . $aParam['agn_id'] . "'
                LIMIT 1       
                ";
        $aResponse = $this->yel->getRow($sql);
        return $aResponse;
    }

    public function setLocalRecruitmentDetails($aParam) {
        $sql = "  
                UPDATE 
                    `icms_recruitment_agency` `ra`
                SET
                    `recruitment_agency_name`='" . $aParam['agn_name'] . "',
                    `recruitment_agency_address`='" . $aParam['agn_address'] . "',
                    `recruitment_agency_tel_no`='" . $aParam['agn_tel'] . "',
                    `recruitment_agency_email`='" . $aParam['agn_email'] . "',
                    `recruitment_agency_fax_no`='" . $aParam['agn_fax'] . "',
                    `recruitment_agency_website`= '" . $aParam['agn_web'] . "',
                    `region_id` = '" . $aParam['agn_region'] . "',
                    `province_id` = '" . $aParam['agn_province'] . "',
                    `country_id`='" . $aParam['country'] . "'
                WHERE
                    `recruitment_agency_id`='" . $aParam['agn_id'] . "'
                ";
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function setForeignRecruitmentDetails($aParam) {
        $sql = "  
                UPDATE 
                    `icms_recruitment_agency` `ra`
                SET
                    `recruitment_agency_name`='" . $aParam['agn_name'] . "',
                    `recruitment_agency_address`='" . $aParam['agn_address'] . "',
                    `recruitment_agency_tel_no`='" . $aParam['agn_tel'] . "',
                    `recruitment_agency_email`='" . $aParam['agn_email'] . "',
                    `recruitment_agency_fax_no`='" . $aParam['agn_fax'] . "',
                    `recruitment_agency_website`= '" . $aParam['agn_web'] . "',
                    `country_id`='" . $aParam['country'] . "'
                WHERE
                    `recruitment_agency_id`='" . $aParam['agn_id'] . "'
                ";
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function getDeploymentDetails($aParam) {
        $sql = "
                SELECT
                    `case_victim_deployment_document_is_falsified`,
                    `case_victim_deployment_date`,
                    `case_victim_deployment_arrival_date`,
                    `case_victim_visa_category_id`,
                    `port_id`,
                    `case_victim_deployment_country_destination`,
                    `case_victim_deployment_id`,
                    `case_victim_deployment_type`, 
                    `case_victim_deployment_other_port_details`, 
                    `case_victim_deployment_remark`, 
                    `case_victim_deployment_escorted_person_name` , 
                    `case_victim_deployment_escorted_details`
                FROM
                    `icms_case_victim_deployment`
                WHERE
                    `case_victim_id`='" . $aParam['case_victim_id'] . "'
                LIMIT 1
               ";

        $aResponse = $this->yel->GetRow($sql);
        return $aResponse;
    }

    public function getDeploymentDetailsByDeploymentID($aParam) {
        $sql = "
                SELECT
                    (SELECT CASE WHEN `case_victim_deployment_document_is_falsified`='1' THEN 'Yes' ELSE 'No' END) as `is_falsified`,
                    (SELECT `parameter_name` FROM `icms_global_parameter` WHERE  `parameter_type_id` = '5' AND `parameter_count_id`=`icvd`.`case_victim_deployment_type` LIMIT 1) as `departure_type`,
                    `icvd`.`case_victim_deployment_date`,
                    `icvd`.`case_victim_deployment_arrival_date`,
                    (SELECT `parameter_name` FROM `icms_global_parameter` WHERE  `parameter_type_id` = '11' AND `parameter_count_id`=`icvd`.`case_victim_visa_category_id` LIMIT 1) as `Visa_Category`,
                    (SELECT `port_name` FROM `icms_global_ph_port` WHERE  `port_id` = `icvd`.`port_id` LIMIT 1) as `port`,
                    (SELECT `country_name` FROM `icms_global_country` WHERE  `country_id` = `icvd`.`case_victim_deployment_country_destination` LIMIT 1) as `destination`
                FROM
                    `icms_case_victim_deployment` `icvd`
                WHERE
                    `icvd`.`case_victim_deployment_id`='" . $aParam['deployment_id'] . "'
                LIMIT 1
                ";
        $aResponse = $this->yel->GetRow($sql);
        return $aResponse;
    }

    public function setDeploymentDetails($aParam) {
        $sql = "
                UPDATE
                    `icms_case_victim_deployment`
                SET
                    `case_victim_deployment_document_is_falsified`=" . $this->yel->checkifStringExist($aParam['is_falsified']) . ",
                    `case_victim_deployment_type`= " . $this->yel->checkifStringExist($aParam['departure_type']) . ",
                    `case_victim_deployment_date`= " . $this->yel->checkDateTimeIfExist($aParam['deployment_date']) . ",
                    `case_victim_deployment_arrival_date`= " . $this->yel->checkDateTimeIfExist($aParam['arrival_date']) . ",
                    `case_victim_visa_category_id`= " . $this->yel->checkifStringExist($aParam['visacat']) . ",
                    `port_id`= " . $this->yel->checkifStringExist($aParam['portofexit']) . ",
                    `case_victim_deployment_country_destination`= " . $this->yel->checkifStringExist($aParam['destination']) . ", 
                    `case_victim_deployment_other_port_details`= " . $this->yel->checkifStringExist($aParam['other_port_details']) . ", 
                    `case_victim_deployment_remark` = " . $this->yel->checkifStringExist($aParam['deployment_remark']) . ", 
                    `case_victim_deployment_escorted_person_name` = " . $this->yel->checkifStringExist($aParam['deployment_escort_name']) . ",
                    `case_victim_deployment_escorted_details` = " . $this->yel->checkifStringExist($aParam['deployment_escort_description']) . " 
                WHERE
                    `case_victim_deployment_id`='" . $aParam['deployment_id'] . "'
                ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function getPassportDetails($aParam) {
        $sql = "
                SELECT
                    `victim_passport_id`,
                    `victim_passport_number`,
                    `victim_passport_last_name`,
                    `victim_passport_middle_name`,
                    `victim_passport_first_name`,
                    `victim_passport_suffix_name`,
                    `victim_passport_dob`,
                    `victim_passport_province_pob`,
                    `victim_passport_city_pob`,
                    `victim_passport_gender`,
                    `victim_passport_civil_status`,
                    `victim_passport_date_issued`,
                    `victim_passport_date_expired`,
                    `victim_passport_place_issue`
                FROM
                    `icms_victim_passport`
                WHERE
                    `case_victim_id`='" . $aParam['case_victim_id'] . "'
                LIMIT 1
               ";
        $aResponse = $this->yel->GetRow($sql);
        return $aResponse;
    }

}

