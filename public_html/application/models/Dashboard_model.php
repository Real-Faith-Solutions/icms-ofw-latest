<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class Dashboard_model extends CI_Model {

    public function test($aParam) {

        $aResponse = [];

        $sql = "";

//        $aResponse = $this->yel->GetRow($sql);

        return $aResponse;
    }

    public function getTotalCaseCount() {

        $aResponse = [];

        $sSequel = "
            SELECT
                 FORMAT(CEIL(COUNT(1)),0) as `cnt`
            FROM
                `icms_case_victim`
            WHERE 
                `case_victim_id` IN (SELECT `case_victim_id` FROM `view_report_summary`)
            ";

        /*$sSequel = "
            SELECT
                    FORMAT(CEIL(COUNT(1)),0) as `cnt`
            FROM
                `icms_case_victim`
            ";*/
        $aResponse = $this->yel->GetOne($sSequel);

        return $aResponse;
    }

    public function getOnGoingCaseCount() {

        $aResponse = [];

        $sSequel = "
            SELECT
                FORMAT(CEIL(COUNT(1)),0) as `cnt`
            FROM
                `icms_case_victim`
            WHERE 
                `case_victim_is_active` = '1' 
            AND 
                `case_victim_id` IN (SELECT `case_victim_id` FROM `view_report_summary`)
            ";
        $aResponse = $this->yel->GetOne($sSequel);

        return $aResponse;
    }
    
    public function _getTIPReportCount() {

        $aResponse = [];

        $sSequel = "                
                SELECT 
                    COUNT(1)
                FROM
                    `icms_case_victim`
                WHERE
                    `case_victim_id` IN (SELECT 
                                `case_victim_id`
                            FROM 
                                `icms_case_victim_tip`
                            WHERE
                                `case_victim_tip_type_id` = 1 
                            GROUP BY 
                                `case_victim_id`) AND 
                    `case_victim_id` IN (SELECT 
                                `case_victim_id`
                            FROM 
                                `icms_case_victim_tip`
                            WHERE
                                `case_victim_tip_type_id` = 2
                            GROUP BY 
                                `case_victim_id`) AND 
                    `case_victim_id` IN (SELECT 
                                `case_victim_id`
                            FROM 
                                `icms_case_victim_tip`
                            WHERE
                                `case_victim_tip_type_id` = 3
                            GROUP BY 
                                `case_victim_id`)
            ";
        $aResponse = $this->yel->GetOne($sSequel);

        return $aResponse;
    }
    
    public function getTIPReportCount() {

        $aResponse = [];

        $sSequel = "                
                SELECT 
                    FORMAT(CEIL(COUNT(1)),0)
                FROM
                    `view_report_summary`
                WHERE
                    `case_is_tip` = 1
            ";
        $aResponse = $this->yel->GetOne($sSequel);

        return $aResponse;
    }
    
    public function getNonTIPReportCount() {

        $aResponse = [];

         $sSequel = "                
                SELECT 
                    FORMAT(CEIL(COUNT(1)),0)
                FROM
                    `view_report_summary`
                WHERE
                    `case_is_tip` = 0
            ";
        $aResponse = $this->yel->GetOne($sSequel);

        return $aResponse;
    }
    
    public function _getNonTIPReportCount() {

        $aResponse = [];

        $sSequel = "     
            
                SELECT 
                    COUNT(`case_victim_id`)
                FROM 
                    `icms_case_victim`
                WHERE 
                    `case_victim_id` NOT IN (
                        SELECT 
                            `case_victim_id`
                        FROM
                            `icms_case_victim`
                        WHERE
                            `case_victim_id` IN (SELECT 
                                        `case_victim_id`
                                    FROM 
                                        `icms_case_victim_tip`
                                    WHERE
                                        `case_victim_tip_type_id` = 1 
                                    GROUP BY 
                                        `case_victim_id`) AND 
                            `case_victim_id` IN (SELECT 
                                        `case_victim_id`
                                    FROM 
                                        `icms_case_victim_tip`
                                    WHERE
                                        `case_victim_tip_type_id` = 2
                                    GROUP BY 
                                        `case_victim_id`) AND 
                            `case_victim_id` IN (SELECT 
                                        `case_victim_id`
                                    FROM 
                                        `icms_case_victim_tip`
                                    WHERE
                                        `case_victim_tip_type_id` = 3
                                    GROUP BY 
                                        `case_victim_id`)
                    )
            ";
        $aResponse = $this->yel->GetOne($sSequel);

        return $aResponse;
    }

    public function getClosedCaseCount() {

        $aResponse = [];

        $sSequel = "
              SELECT
                FORMAT(CEIL(COUNT(1)),0) as `cnt`
            FROM
                `icms_case`
            WHERE 
                `case_status_id` = '3'
            ";
        $aResponse = $this->yel->GetOne($sSequel);

        return $aResponse;
    }

    public function getStagnantCaseCount() {

        $aResponse = [];

        $sSequel = "
            SELECT
                FORMAT(CEIL(COUNT(1)),0) as `cnt`
            FROM
                `icms_case`
            WHERE 
                `case_status_id` = '3'
            ";

        $aResponse = $this->yel->GetOne($sSequel);

        return $aResponse;
    }

    public function getRecentCase() {
        $aResponse = [];

        $sSequel = "
                SELECT 
                    `ic`.`case_number`,
                    `ic`.`case_priority_level_id`,
                    (SELECT COUNT(1)  
                     FROM `icms_case_victim` `icc` WHERE `icc`.`case_id` = `ic`.`case_id`
                     LIMIT 1 ) as `victim_count`, 
                    DATE_FORMAT(`ic`.`case_date_added`, '%M %d, %Y %r') as `case_date_added`,
                    (SELECT CONCAT(`ab`.`agency_branch_name`, ' (',(SELECT `agency_abbr` FROM `icms_agency` WHERE `agency_id` = `ab`.`agency_id` LIMIT 1),')') FROM `icms_agency_branch` `ab` WHERE `ab`.`agency_branch_id` = (SELECT `agency_branch_id` FROM `icms_user` WHERE `user_id` = `ic`.`case_added_by` LIMIT 1) LIMIT 1) as `filed_by_agency`                  
                FROM 
                    `icms_case`  `ic` 
               ORDER BY 
                     `case_date_added` DESC
               LIMIT 3

            ";

        $aResponse = $this->yel->GetAll($sSequel);

        return $aResponse;
    }

    public function getCaseViolatedCount($caseViolated) {

        $aResponse = [];

        $sSequel = "
            SELECT
                FORMAT(CEIL(COUNT(1)),0) as `cnt`
            FROM
                `icms_case`
            WHERE 
                `case_violated` = '" . $caseViolated . "'
            ";
        $aResponse = $this->yel->GetOne($sSequel);

        return $aResponse;
    }
    
     //OSAEC CODE START
     public function getCaseViolated($caseViolated) {
        $aResponse = [];

        $sSequel = "
                SELECT 
                    `ic`.`case_number`,
                    `ic`.`case_priority_level_id`,
                    (SELECT COUNT(1)  
                     FROM `icms_case_victim` `icc` WHERE `icc`.`case_id` = `ic`.`case_id`
                     LIMIT 1 ) as `victim_count`, 
                    DATE_FORMAT(`ic`.`case_date_added`, '%M %d, %Y %r') as `case_date_added`,
                    (SELECT CONCAT(`ab`.`agency_branch_name`, ' (',(SELECT `agency_abbr` FROM `icms_agency` WHERE `agency_id` = `ab`.`agency_id` LIMIT 1),')') FROM `icms_agency_branch` `ab` WHERE `ab`.`agency_branch_id` = (SELECT `agency_branch_id` FROM `icms_user` WHERE `user_id` = `ic`.`case_added_by` LIMIT 1) LIMIT 1) as `filed_by_agency`                  
                FROM 
                    `icms_case`  `ic` 
                WHERE 
                    `ic`.`case_violated` = '" . $caseViolated . "'
                ORDER BY 
                    `case_date_added` DESC
                LIMIT 3
            ";

        $aResponse = $this->yel->GetAll($sSequel);

        return $aResponse;
    }
    //OSAEC CODE END
    public function getHighPriorityCase() {
        $aResponse = [];

        $sSequel = "
                SELECT 
                    `ic`.`case_number`,
                    (SELECT COUNT(1)  
                     FROM `icms_case_victim` `icc` WHERE `icc`.`case_id` = `ic`.`case_id`
                     LIMIT 1 ) as `victim_count`, 
                    DATE_FORMAT(`ic`.`case_date_added`, '%M %d, %Y %r') as `case_date_added`,
                    (SELECT CONCAT(`ab`.`agency_branch_name`, ' (',(SELECT `agency_abbr` FROM `icms_agency` WHERE `agency_id` = `ab`.`agency_id` LIMIT 1),')') FROM `icms_agency_branch` `ab` WHERE `ab`.`agency_branch_id` = (SELECT `agency_branch_id` FROM `icms_user` WHERE `user_id` = `ic`.`case_added_by` LIMIT 1) LIMIT 1) as `filed_by_agency`                  
                FROM 
                    `icms_case`  `ic` 
               WHERE 
                    `ic`.`case_priority_level_id` = 2 
               ORDER BY 
                    `case_date_added` DESC
               LIMIT 3
            ";

        $aResponse = $this->yel->GetAll($sSequel);

        return $aResponse;
    }
    
    public function getForReviewCasePriorityLevel() {
        $aResponse = [];

        $sSequel = "
                SELECT 
                    `ic`.`case_number`,
                    (SELECT COUNT(1)  
                     FROM `icms_case_victim` `icc` WHERE `icc`.`case_id` = `ic`.`case_id`
                     LIMIT 1 ) as `victim_count`, 
                    DATE_FORMAT(`ic`.`case_date_added`, '%M %d, %Y %r') as `case_date_added`,
                    (SELECT CONCAT(`ab`.`agency_branch_name`, ' (',(SELECT `agency_abbr` FROM `icms_agency` WHERE `agency_id` = `ab`.`agency_id` LIMIT 1),')') FROM `icms_agency_branch` `ab` WHERE `ab`.`agency_branch_id` = (SELECT `agency_branch_id` FROM `icms_user` WHERE `user_id` = `ic`.`case_added_by` LIMIT 1) LIMIT 1) as `filed_by_agency`                  
                FROM 
                    `icms_case`  `ic` 
               WHERE 
                    `ic`.`case_priority_level_is_approved` = 0
               ORDER BY 
                     `case_date_added` DESC
               LIMIT 3

            ";

        $aResponse = $this->yel->GetAll($sSequel);

        return $aResponse;
    }
    
    public function getTopFiveActiveAgencyBranch() {
        $aResponse = [];

        $sSequel = "
            SELECT     
                COUNT(`cv`.`case_id`) as `case_count`,
                
                (SELECT 
                    (SELECT `agency_name` FROM `icms_agency` WHERE `agency_id` = `ab`.`agency_id` LIMIT 1) 
                FROM `icms_agency_branch` `ab` 
                WHERE `ab`.`agency_branch_id` = (SELECT `agency_branch_id` 
                                               FROM `icms_user` 
                                               WHERE `user_id` = `ic`.`case_added_by` LIMIT 1) 
                 LIMIT 1) as `filed_by_agency`,
                 
                (SELECT CONCAT(`ab`.`agency_branch_name`) 
                FROM `icms_agency_branch` `ab` 
                WHERE `ab`.`agency_branch_id` = (SELECT `agency_branch_id` 
                                                 FROM `icms_user` 
                                                 WHERE `user_id` = `ic`.`case_added_by` LIMIT 1) 
                LIMIT 1) as `filed_by_agency_branch`   
                
            FROM 
                `icms_case` `ic` ,
                `icms_case_victim` `cv`
            WHERE 
                `cv`.`case_victim_id` IN (SELECT `case_victim_id` FROM `view_report_summary`) AND 
                `ic`.`case_added_by` != 0  AND 
                `ic`.`case_id` = `cv`.`case_id`
            GROUP BY `filed_by_agency_branch`
            ORDER BY `case_count` DESC
            LIMIT 5 
            
            ";

        $aResponse = $this->yel->GetAll($sSequel);

        return $aResponse;
    }
    
    public function getTopTipPerCountry() {
        $aResponce = [];
        $sSequel = "
                    SELECT 
                        `gc`.`country_name` as country, 
                        COUNT(`cvd`.`country_id`) AS count
                    FROM 
                        `icms_case_victim_employment_details` `cvd`,  `icms_global_country` `gc`
                    WHERE 
                        `gc`.`country_id` =  `cvd`.`country_id`
                    AND
                    	`cvd`.`case_victim_employment_details_is_actual` = 1
                    GROUP BY 
                        `cvd`.`country_id`
                    ORDER BY count DESC
                  	LIMIT 5
                    ";
       
        $aResponse = $this->yel->GetAll($sSequel);

        return $aResponse;
        
    }
    
    
    public function getTopNatureOfCase() {
        $aResponce = [];
        $sSequel = "
                    SELECT 
                        `td`.`tip_details_name` AS purpose, COUNT(`cv`.`case_victim_tip_type_content_id`) AS purpose_count
                    FROM 
                        `icms_case_victim_tip` `cv`, `icms_tip_details` `td`
                    WHERE  
                        `td`.`tip_form_type_id` = 2 AND `cv`.`case_victim_tip_type_content_id` = 						`td`.`tip_details_count`
                    GROUP BY 
                        `td`.`tip_details_name`
                    ORDER BY purpose_count DESC
                    ";
       
        $aResponse = $this->yel->GetAll($sSequel);

        return $aResponse;
        
    }

}
