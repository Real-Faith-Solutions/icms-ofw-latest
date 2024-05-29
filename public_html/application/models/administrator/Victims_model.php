<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class Victims_model extends CI_Model {

    public function getVictimList($aParam) {

        $aResponse = [];

        $sList = "
                SELECT  
                   `iv`.`victim_id`,
                   `iv`.`victim_number`, 
                   `iv`.`victim_civil_status`, 
                   `iv`.`victim_gender`, 
                   `iv`.`victim_religion`,
                   (SELECT 
                      CONCAT(`vi`.`victim_info_first_name`, ' ', COALESCE(`vi`.`victim_info_middle_name`, ''), ' ', `vi`.`victim_info_last_name`)
                    FROM 
                       `icms_victim_info` `vi`
                    WHERE 
                        `vi`.`victim_info_is_assumed` = 0
                    AND 
                        `vi`.`victim_id` = `iv`.`victim_id`
                    LIMIT 1 
                   ) as `real_full_name`, 
                   (SELECT 
                      CONCAT(`vi`.`victim_info_first_name`, ' ', COALESCE(`vi`.`victim_info_middle_name`, ''), ' ', `vi`.`victim_info_last_name`)
                    FROM 
                       `icms_victim_info` `vi`
                    WHERE 
                        `vi`.`victim_info_is_assumed` = 1 
                    AND 
                        `vi`.`victim_id` = `iv`.`victim_id`
                    LIMIT 1 
                   ) as `assumed_full_name`
                   " . $aParam['sRelevance'] . "
                FROM 
                   `icms_victim` as `iv`       
                WHERE 
                    " . $aParam['cRelevance'] . "
                LIMIT  " . $aParam['start'] . "," . $aParam['limit'] . " 
               ";


        $aResponse['list'] = $this->yel->GetAll($sList);

        $sCount = "
                SELECT
                    COUNT(1)
                FROM
                    `icms_victim`  `iv`
                WHERE 
                    " . $aParam['cRelevance'] . "
               ";

        $aResponse['count'] = $this->yel->GetOne($sCount);

        return $aResponse;
    }

    public function getListsVictimNamebyId($victim_id) {

        $sql = " 
                SELECT 
                    `victim_info_first_name`, 
                    `victim_info_middle_name`, 
                    `victim_info_last_name`, 
                    `victim_info_suffix`, 
                    `victim_info_dob`,
                    `victim_info_city_pob`, 
                    `victim_info_is_assumed`
                FROM 
                    `icms_victim_info` 
                WHERE 
                    `victim_id` = '" . $victim_id . "'
              ";

        $aResponse = $this->yel->getAll($sql);
        return $aResponse;
    }

    public function getVictimAssumedNamebyId($victim_id) {

        $sql = " 
                SELECT 
                    (SELECT `v`.`victim_number` FROM `icms_victim` `v` WHERE `v`.`victim_id` = `vi`.`victim_id`) as victim_number, 
                    `vi`.`victim_info_first_name`, 
                    `vi`.`victim_info_middle_name`, 
                    `vi`.`victim_info_last_name`, 
                    `vi`.`victim_info_suffix`, 
                    `vi`.`victim_info_dob`,
                    `vi`.`victim_info_city_pob`, 
                    `vi`.`victim_info_is_assumed`
                FROM 
                    `icms_victim_info` `vi`
                WHERE 
                    `vi`.`victim_id` = '" . $victim_id . "' AND 
                    `vi`.`victim_info_is_assumed` = '1' AND 
                    `vi`.`victim_info_is_active` = 1
                ORDER BY `vi`.`victim_info_id` DESC                
                LIMIT 1
              ";

        $aResponse = $this->yel->getRow($sql);
        return $aResponse;
    }

    public function getVictimRealNamebyId($victim_id) {

        $sql = " 
                SELECT 
                    (SELECT `v`.`victim_number` FROM `icms_victim` `v` WHERE `v`.`victim_id` = `vi`.`victim_id`) as victim_number, 
                    `vi`.`victim_info_first_name`, 
                    `vi`.`victim_info_middle_name`, 
                    `vi`.`victim_info_last_name`, 
                    `vi`.`victim_info_suffix`, 
                    `vi`.`victim_info_dob`,
                    `vi`.`victim_info_city_pob`, 
                    `vi`.`victim_info_is_assumed`
                FROM 
                    `icms_victim_info` `vi`
                WHERE 
                    `vi`.`victim_id` = '" . $victim_id . "' AND 
                    `vi`.`victim_info_is_assumed` != '1' AND 
                    `vi`.`victim_info_is_active` = 1
                ORDER BY `vi`.`victim_info_id` DESC                
                LIMIT 1
              ";

        $aResponse = $this->yel->getRow($sql);
        return $aResponse;
    }

    public function getVictimAddressListbyId($victim_id) {
        $sql = " 
                SELECT 
                    `country_id`, 
                    `victim_address_list_region_id`, 
                    `victim_address_list_province_id`, 
                    `victim_address_list_city_id`, 
                    `victim_address_list_brgy_id`,
                    `victim_address_list_address`, 
                    `victim_address_list_date_added`
                FROM 
                    `icms_victim_address_list` 
                WHERE 
                    `victim_id` = '" . $victim_id . "' 
              ";

        $aResponse = $this->yel->getAll($sql);
        return $aResponse;
    }

    public function getGovernmentContactAddressByID($victim_id) {

        $sql = "
                SELECT
                   COALESCE(`al`.`victim_address_list_address`,' ') as `f_address`, 
                   COALESCE((SELECT `country_name` FROM `icms_global_country` WHERE `country_id` = `al`.`country_id`),' ') as country,
                   COALESCE((SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`al`.`victim_address_list_region_id` AND `location_type_id`='3'),' ') as region,
                   COALESCE((SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`al`.`victim_address_list_province_id` AND `location_type_id`='4'),' ') as province,
                   COALESCE((SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`al`.`victim_address_list_province_id` AND `location_type_id`='2' AND `location_prerequisite_id`=`al`.`country_id`),' ') as state,
                   COALESCE((SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`al`.`victim_address_list_city_id` AND `location_type_id`='5'),' ') as city,
                   COALESCE((SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`al`.`victim_address_list_brgy_id` AND `location_type_id`='6'),' ') as brgy
                FROM 
                    `icms_victim_address_list` `al`
                WHERE
                    `al`.`victim_id`='" . $victim_id . "' AND 
                    `al`.`victim_address_list_is_active` = 1 
                ORDER BY `victim_address_list_date_added` DESC
                LIMIT 1                         
                ";

        $result = $this->yel->getRow($sql);

        return $result;
    }

    public function getVictimListContactDetailsbyID($victim_id) {
        $sql = "  
                SELECT 
                    `vcd`.`victim_contact_details_id`, 
                    `vcd`.`victim_contact_detail_type`,
                    (SELECT `transaction_parameter_name` FROM `icms_transaction_parameter`  WHERE `transaction_parameter_type_id` = 6 AND `transaction_parameter_count_id` =  `vcd`.`victim_contact_detail_type` LIMIT 1) as `contact_type` ,
                    `vcd`.`victim_contact_detail_content`
                FROM 
                    `icms_victim_contact_details`  `vcd`
                WHERE 
                    `vcd`.`victim_id` = " . $victim_id . " AND 
                    `vcd`.`victim_contact_details_is_active` = 1 
                ORDER BY `vcd`.`victim_contact_details_added_date` 
                    
            ";

        $aResponse = $this->yel->getAll($sql);

        return $aResponse;
    }

    public function getCountAssociateCasePerVictimID($victim_id) {
        $sql = "  
                SELECT 
                    COUNT(1)
                FROM 
                    `icms_case_victim`
                WHERE 
                    `victim_id` = " . $victim_id . " 
                AND `case_victim_is_active` = 1
            ";

        $aResponse = $this->yel->getOne($sql);

        return $aResponse;
    }

    public function getAssociateCasePerVictimID($aParam) {
        $sql = "  
                SELECT 
                    `ic`.`case_number`, 
                    DATE_FORMAT(`ic`.`case_date_added`, '%M %d, %Y %r') as `case_date_added`, 
                    (SELECT 
                        `transaction_parameter_name`
                     FROM 
                        `icms_transaction_parameter`
                     WHERE 
                        `transaction_parameter_type_id` = 3
                    LIMIT 1) as `case_status_name` 
                FROM 
                    `icms_case` `ic`
                WHERE 
                    `ic`.`case_id` IN (
                        SELECT 
                            `case_id`
                        FROM 
                            `icms_case_victim`
                        WHERE 
                            `victim_id` = " . $aParam['victim_id'] . " 
                        AND `case_victim_is_active` = 1
                    )    
            ";

        $aResponse = $this->yel->getAll($sql);

        return $aResponse;
    }

    public function getLastVictimId() {
//        $sql = "
//                SELECT MAX(`victim_id`) FROM `icms_victim_copy`;
//               ";
        $sql = "
                SELECT COUNT(1) FROM `icms_victim`;
               ";

        $aResponse = $this->yel->getOne($sql);

        return $aResponse;
    }

    public function getCaseVictimTIPDetailsByCaseVictimIdAndTIPType($aParam) {
        $sql = " 
                SELECT 
                    (SELECT 
                        `td`.`tip_details_name` 
                    FROM 
                        `icms_tip_details` `td` 
                    WHERE 
                        `td`.`tip_details_is_active` = 1 
                    AND `td`.`tip_form_type_id`  = " . $aParam['case_victim_tip_type_id'] . "
                    AND `td`.`tip_details_count` = `cvt`.`case_victim_tip_type_content_id`
                    ) as `details`,
                    `cvt`.`case_victim_tip_type_added_by`, 
                    `cvt`.`case_victim_tip_date_added`
                FROM 
                    `icms_case_victim_tip` `cvt` 
                WHERE 
                    `cvt`.`case_victim_tip_is_active` = 1 
                AND `cvt`.`case_victim_tip_type_id` = " . $aParam['case_victim_tip_type_id'] . "
                AND `cvt`.`case_victim_id` =  " . $aParam['case_victim_id'] . "
            ";

        $aResponse = $this->yel->getAll($sql);
        return $aResponse;
    }

    public function getVictimListEducationDetailsbyVictimId($aParam) {
        $sql = "
                SELECT `ved`.*, 
                (SELECT `parameter_name` FROM `icms_global_parameter`  WHERE `parameter_type_id` = 6 AND `parameter_count_id` =  `ved`.`victim_education_type` LIMIT 1) as `education_type_name` 
                FROM 
                `icms_victim_education` `ved` 
                WHERE  
                `ved`.`victim_id`='" . $aParam['victim_id'] . "' 
                AND 
                `ved`.`victim_education_is_active` = '1' 
               ";

        $aResponse = $this->yel->getAll($sql);

        return $aResponse;
    }

    public function getVictimListAddressDetailsbyVictimId($aParam) {
        $sql = "
                SELECT `vad`.*,
                (SELECT `country_name` FROM `icms_global_country` WHERE `country_id` = `vad`.`country_id`) as country,
                (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`vad`.`victim_address_list_region_id` AND `location_type_id`='3') as region,
                (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`vad`.`victim_address_list_province_id` AND `location_type_id`='4') as province,
                (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`vad`.`victim_address_list_province_id` AND `location_type_id`='2' AND `location_prerequisite_id`=`vad`.`country_id`) as state,
                (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`vad`.`victim_address_list_city_id` AND `location_type_id`='5') as city,
                (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`vad`.`victim_address_list_brgy_id` AND `location_type_id`='6') as brgy

                FROM 
                `icms_victim_address_list` `vad` 
                WHERE  
                `vad`.`victim_id`='" . $aParam['victim_id'] . "' 
                AND 
                `vad`.`victim_address_list_is_active` = '1' 
               ";
        $aResponse = $this->yel->getAll($sql);

        return $aResponse;
    }

    public function getVictimListRelativeDetailsbyVictimId($aParam) {
        $sql = "
                SELECT `vr`.*, 
                (SELECT `parameter_name` FROM `icms_global_parameter`  WHERE `parameter_type_id` = 8 AND `parameter_count_id` =  `vr`.`victim_relative_type` LIMIT 1) as `victim_relative_type_name`,
                (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`vr`.`victim_relative_region` AND `location_type_id`='3') as region,
                (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`vr`.`victim_relative_province` AND `location_type_id`='4') as province,
                (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`vr`.`victim_relative_city` AND `location_type_id`='5') as city,
                (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`vr`.`victim_relative_brgy` AND `location_type_id`='6') as brgy

                FROM 
                `icms_victim_relative` `vr` 
                WHERE  
                `vr`.`victim_id`= " . $aParam['victim_id'] . "
                AND 
                `vr`.`victim_relative_is_active` = '1'  
               ";

        $aResponse = $this->yel->getAll($sql);

        return $aResponse;
    }

    public function getVictimInfoByCaseId($aParam) {
        $sql = "
                SELECT `cv`.*, `vi`.*, `v`.*  
                FROM 
                `icms_case_victim` `cv`, 
                `icms_victim` `v`, 
                `icms_victim_info` `vi` 
                WHERE 
                `cv`.`victim_id` = `vi`.`victim_id` 
                AND 
                `cv`.`victim_id` = `v`.`victim_id` 
                AND 
                `cv`.`case_id` = '" . $aParam['case_id'] . "' 
                AND 
                `vi`.`victim_info_is_assumed` = '0' 
               ";

        $aResponse = $this->yel->getRow($sql);

        return $aResponse;
    }

    public function getVictimAssumedInfoByCaseId($aParam) {
        $sql = "
                SELECT cv.*, vi.* 
                FROM 
                `icms_case_victim` `cv`, 
                `icms_victim_info` `vi` 
                WHERE 
                `cv`.`victim_id` = `vi`.`victim_id` 
                AND 
                `cv`.`case_id` = '" . $aParam['case_id'] . "' 
                AND 
                `vi`.`victim_info_is_assumed` = '1' 
               ";

        $aResponse = $this->yel->getRow($sql);

        return $aResponse;
    }

    public function updateVictimInfoByVictimId($aParam) {
        $sql = "
                UPDATE `icms_victim_info` 
                SET 
                `victim_info_first_name`='" . $aParam['victim_info_first_name'] . "', 
                `victim_info_middle_name`='" . $aParam['victim_info_middle_name'] . "', 
                `victim_info_last_name`='" . $aParam['victim_info_last_name'] . "', 
                `victim_info_suffix`='" . $aParam['victim_info_suffix'] . "', 
                `victim_info_dob`='" . date("Y-m-d", strtotime($aParam['victim_info_dob'])) . "', 
                `victim_info_city_pob`='" . $aParam['victim_info_city_pob'] . "', 
                `victim_info_date_modified`=now(), 
                `victim_info_modified_by`='" . $this->session->userdata('userData')['user_id'] . "' 
                WHERE 
               `victim_id` = '" . $aParam['victim_id'] . "' 
                AND 
                `victim_info_is_assumed` = '0' 
               ";

        $aResponse = $this->yel->exec($sql);

        $sql = "
                UPDATE `icms_victim` 
                SET 
                `victim_civil_status`='" . $aParam['victim_civil_status'] . "', 
                `victim_gender`='" . $aParam['victim_gender'] . "', 
                `victim_religion`='" . $aParam['victim_religion'] . "', 
                `victim_date_modified`=now(), 
                `victim_modified_by`='" . $this->session->userdata('userData')['user_id'] . "' 
                WHERE 
               `victim_id` = '" . $aParam['victim_id'] . "' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function updateAssumedVictimInfoByVictimId($aParam) {
        $sql = "
                UPDATE `icms_victim_info` 
                SET 
                `victim_info_first_name`='" . $aParam['assumed_victim_info_first_name'] . "', 
                `victim_info_middle_name`='" . $aParam['assumed_victim_info_middle_name'] . "', 
                `victim_info_last_name`='" . $aParam['assumed_victim_info_last_name'] . "', 
                `victim_info_dob`='" . date("Y-m-d", strtotime($aParam['assumed_victim_info_dob'])) . "', 
                `victim_info_date_modified`=now(), 
                `victim_info_modified_by`='" . $this->session->userdata('userData')['user_id'] . "' 
                WHERE 
                `victim_id` = '" . $aParam['victim_id'] . "' 
                AND 
                `victim_info_is_assumed` = '1' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function getVictimListEmploymentDetailsbyVictimId($aParam) {
        $sql = "
                SELECT cve.*, vi.* 
                FROM 
                `icms_case_victim_employment` `cve`, 
                `icms_victim_info` `vi` 
                WHERE 
                `cv`.`victim_id` = `vi`.`victim_id` 
                AND 
                `cv`.`case_id` = '" . $aParam['case_id'] . "' 
                AND 
                `vi`.`victim_info_is_assumed` = '1' 
               ";

        $aResponse = $this->yel->getRow($sql);

        return $aResponse;
    }

    public function addVictimContactByVictimId($aParam) {

        $sql = "
                INSERT INTO 
                `icms_victim_contact_details` 
                SET 
                `victim_id`='" . $aParam['victim_id'] . "', 
                `victim_contact_detail_type`='" . $aParam['contact_type'] . "', 
                `victim_contact_detail_content`='" . $aParam['contact_content'] . "', 
                `victim_contact_details_added_date`=now(),
                `victim_contact_details_added_by`='" . $this->session->userdata('userData')['user_id'] . "', 
                `victim_contact_details_is_active`='1' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function addVictimEducationByVictimId($aParam) {

        $sql = "
                INSERT INTO 
                `icms_victim_education` 
                SET 
                `victim_id`='" . $aParam['victim_id'] . "', 
                `victim_education_type`='" . $aParam['education_type'] . "', 
                `victim_education_grade_year`='" . $aParam['education_grade_year'] . "', 
                `victim_education_school`='" . $aParam['education_school'] . "', 
                `victim_education_course`='" . $aParam['education_course'] . "', 
                `victim_education_start`='" . $aParam['education_start'] . "', 
                `victim_education_end`='" . $aParam['education_end'] . "', 
                `victim_education_added_date`=now(),
                `victim_education_added_by`='" . $this->session->userdata('userData')['user_id'] . "', 
                `victim_education_is_active`='1' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function addVictimAddressByVictimId($aParam) {

        $sql = "
                INSERT INTO 
                `icms_victim_address_list` 
                SET 
                `victim_id`='" . $aParam['victim_id'] . "', 
                `country_id`='173', 
                `victim_address_list_region_id`='" . $aParam['address_region'] . "', 
                `victim_address_list_province_id`='" . $aParam['address_province'] . "', 
                `victim_address_list_city_id`='" . $aParam['address_city'] . "', 
                `victim_address_list_brgy_id`='" . $aParam['address_barangay'] . "', 
                `victim_address_list_address`='" . $aParam['address_complete'] . "', 
                `victim_address_list_date_added`=now(),
                `victim_address_list_added_by`='" . $this->session->userdata('userData')['user_id'] . "', 
                `victim_address_list_date_modified`=now(), 
                `victim_address_list_updated_by`='" . $this->session->userdata('userData')['user_id'] . "', 
                `victim_address_list_is_active`='1' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function addVictimRelativeByVictimId($aParam) {

        $sql = "
                INSERT INTO 
                `icms_victim_relative` 
                SET 
                `victim_id`='" . $aParam['victim_id'] . "', 
                `victim_relative_fullname`='" . $aParam['relative_name'] . "', 
                `victim_relative_type`='" . $aParam['relative_type'] . "', 
                `victim_relative_primary_contact_number`='" . $aParam['relative_primary_contact_number'] . "', 
                `victim_relative_second_contact_number`='" . $aParam['relative_secondary_contact_number'] . "',
                `victim_relative_type_other`='" . $aParam['victim_relative_type_other'] . "', 
                `victim_relative_email`='" . $aParam['relative_email'] . "', 
                `victim_relative_added_date`=now(),
                `victim_relative_added_by`='" . $this->session->userdata('userData')['user_id'] . "', 
                `victim_relative_is_active`='1' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function removeVictimContactInfoById($aParam) {

        $sql = "
                UPDATE  
                `icms_victim_contact_details` 
                SET 
                `victim_contact_details_is_active`='0' 
                WHERE 
                `victim_contact_details_id` = '" . $aParam['victim_contact_details_id'] . "' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function removeVictimEducationInfoById($aParam) {

        $sql = "
                UPDATE  
                `icms_victim_education` 
                SET 
                `victim_education_is_active`='0' 
                WHERE 
                `victim_education_id` = '" . $aParam['victim_education_id'] . "' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function removeVictimAddressInfoById($aParam) {

        $sql = "
                UPDATE  
                `icms_victim_address_list` 
                SET 
                `victim_address_list_is_active`='0' 
                WHERE 
                `victim_address_list_id` = '" . $aParam['victim_address_list_id'] . "' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function removeVictimRelativeInfoById($aParam) {

        $sql = "
                UPDATE  
                `icms_victim_relative` 
                SET 
                `victim_relative_is_active`='0' 
                WHERE 
                `victim_relative_id` = '" . $aParam['victim_relative_id'] . "' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function getVictimContactInfoById($aParam) {
        $sql = "
                SELECT * FROM 
                `icms_victim_contact_details` 
                WHERE 
                `victim_contact_details_id` = '" . $aParam['victim_contact_details_id'] . "' 
               ";

        $aResponse = $this->yel->getRow($sql);

        return $aResponse;
    }

    public function updateVictimContactInfoById($aParam) {
        $sql = "
                UPDATE  
                `icms_victim_contact_details` 
                SET 
                `victim_contact_detail_type`='" . $aParam['victim_contact_detail_type'] . "', 
                `victim_contact_detail_content` = '" . $aParam['victim_contact_detail_content'] . "' 
                WHERE 
                `victim_contact_details_id` = '" . $aParam['victim_contact_details_id'] . "' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function getVictimContactInfoByContactId($aParam) {
        $sql = "
                SELECT
                    `ivcd`.`victim_contact_detail_content` as `contact_info`,
                    (SELECT `transaction_parameter_name` FROM `icms_transaction_parameter` WHERE `transaction_parameter_type_id`='6' AND `transaction_parameter_count_id`=`ivcd`.`victim_contact_detail_type` LIMIT 1) as `contact_type`
                FROM
                    `icms_victim_contact_details` `ivcd`
                WHERE 
                    `ivcd`.`victim_contact_details_id` = '" . $aParam['victim_contact_details_id'] . "' 
               ";

        $aResponse = $this->yel->GetRow($sql);

        return $aResponse;
    }

    public function getVictimIdByVictimContactID($aParam) {
        $sql = "
                SELECT
                    `victim_id`
                FROM
                    `icms_victim_contact_details` 
                WHERE 
                `victim_contact_details_id` = '" . $aParam['victim_contact_details_id'] . "' 
               ";

        $aResponse = $this->yel->GetOne($sql);

        return $aResponse;
    }

    public function getVictimEducationInfoById($aParam) {
        $sql = "
                SELECT * FROM 
                    `icms_victim_education` 
                WHERE 
                    `victim_education_id` = '" . $aParam['victim_education_id'] . "' 
               ";

        $aResponse = $this->yel->getRow($sql);

        return $aResponse;
    }

    public function getVictimIDByVictimEducationID($aParam) {
        $sql = "
                SELECT
                    `victim_id`
                FROM
                    `icms_victim_education` 
                WHERE 
                    `victim_education_id` = '" . $aParam['victim_education_id'] . "' 
                LIMIT 1
                ";

        $aResponse = $this->yel->GetOne($sql);

        return $aResponse;
    }

    public function updateVictimEducationInfoById($aParam) {
        $sql = "
                UPDATE  
                `icms_victim_education` 
                SET 
                `victim_education_type`='" . $aParam['victim_education_type'] . "', 
                `victim_education_grade_year` = '" . $aParam['victim_education_grade_year'] . "' ,
                `victim_education_school`='" . $aParam['victim_education_school'] . "', 
                `victim_education_course` = '" . $aParam['victim_education_course'] . "' ,
                `victim_education_start`='" . $aParam['victim_education_start'] . "', 
                `victim_education_end` = '" . $aParam['victim_education_end'] . "' 
                WHERE 
                `victim_education_id` = '" . $aParam['victim_education_id'] . "' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function getVictimAddressInfoById($aParam) {
        $sql = "
                SELECT * FROM 
                `icms_victim_address_list` 
                WHERE 
                `victim_address_list_id` = '" . $aParam['victim_address_list_id'] . "' 
               ";

        $aResponse = $this->yel->getRow($sql);

        return $aResponse;
    }

    public function getVictimAddressInfoByAddressId($aParam) {
        $sql = "
                SELECT `vad`.`victim_address_list_address`,
                   (SELECT `country_name` FROM `icms_global_country` WHERE `country_id`=`vad`.`country_id`) as country,
                   (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`vad`.`victim_address_list_region_id` AND `location_type_id`='3') as region,
                   (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`vad`.`victim_address_list_province_id` AND `location_type_id`='4') as province,
                   (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`vad`.`victim_address_list_city_id` AND `location_type_id`='5') as city,
                   (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`vad`.`victim_address_list_brgy_id` AND `location_type_id`='6') as brgy
                FROM 
                    `icms_victim_address_list` `vad` 
                WHERE  
                    `vad`.`victim_address_list_id`='" . $aParam['victim_address_list_id'] . "' 
                LIMIT 1
               ";
        $aResponse = $this->yel->getRow($sql);
        return $aResponse;
    }

    public function getVictimIDByVictimAddressID($aParam) {
        $sql = "
                SELECT 
                    `victim_id`
                FROM 
                    `icms_victim_address_list` ` 
                WHERE  
                    `victim_address_list_id`='" . $aParam['victim_address_list_id'] . "' 
                LIMIT 1
               ";
        $aResponse = $this->yel->getOne($sql);
        return $aResponse;
    }

    public function updateVictimAddressInfoById($aParam) {
        $sql = "
                UPDATE  
                `icms_victim_address_list` 
                SET 
                `victim_address_list_region_id`='" . $aParam['victim_address_list_region_id'] . "', 
                `victim_address_list_province_id` = '" . $aParam['victim_address_list_province_id'] . "' , 
                `victim_address_list_city_id`='" . $aParam['victim_address_list_city_id'] . "', 
                `victim_address_list_brgy_id` = '" . $aParam['victim_address_list_brgy_id'] . "', 
                `victim_address_list_address`='" . $aParam['victim_address_list_address'] . "', 
                `victim_address_list_updated_by` = '" . $this->session->userdata('userData')['user_id'] . "' 
                WHERE 
                `victim_address_list_id` = '" . $aParam['victim_address_list_id'] . "' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function getVictimRelativeInfoById($aParam) {
        $sql = "
                SELECT * FROM 
                `icms_victim_relative` 
                WHERE 
                `victim_relative_id` = '" . $aParam['victim_relative_id'] . "' 
               ";

        $aResponse = $this->yel->getRow($sql);

        return $aResponse;
    }

    public function getVictimRelativeInfoByRelativeId($aParam) {
        $sql = "
                SELECT 
                    `vr`.`victim_relative_fullname`,
                    `vr`.`victim_relative_primary_contact_number`,
                    `vr`.`victim_relative_second_contact_number`,
                    `vr`.`victim_relative_email`,
                    `vr`.`victim_relative_type_other`,
                    (SELECT `parameter_name` FROM `icms_global_parameter` WHERE `parameter_type_id`='8' AND `parameter_count_id`=`vr`.`victim_relative_type` LIMIT 1) as `victim_relation`
                FROM 
                    `icms_victim_relative` `vr`
                WHERE 
                    `vr`.`victim_relative_id` = '" . $aParam['victim_relative_id'] . "' 
               ";
        $aResponse = $this->yel->getRow($sql);

        return $aResponse;
    }

    public function updateVictimRelativeInfoById($aParam) {
        $sql = "
                UPDATE  
                `icms_victim_relative` 
                SET 
                `victim_relative_fullname`='" . $aParam['victim_relative_fullname'] . "', 
                `victim_relative_type` = '" . $aParam['victim_relative_type'] . "' , 
                `victim_relative_primary_contact_number`='" . $aParam['victim_relative_primary_contact_number'] . "', 
                `victim_relative_second_contact_number` = '" . $aParam['victim_relative_second_contact_number'] . "', 
                `victim_relative_type_other` = '" . $aParam['victim_relative_type_other'] . "', 
                `victim_relative_email`='" . $aParam['victim_relative_email'] . "' 
                WHERE 
                `victim_relative_id` = '" . $aParam['victim_relative_id'] . "' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function getVictimIDByRelativeId($aParam) {
        $sql = "
                SELECT
                    `victim_id`
                FROM  
                    `icms_victim_relative` 
                WHERE 
                    `victim_relative_id` = '" . $aParam['victim_relative_id'] . "' 
                LIMIT 1
               ";

        $aResponse = $this->yel->GetOne($sql);

        return $aResponse;
    }

    public function getVitimInfoById($aParam) {

        $sql = "
                SELECT  
                   `iv`.`victim_id`,
                   `iv`.`victim_number`, 
                   (SELECT 
                        `parameter_name`
                     FROM 
                        `icms_global_parameter`
                     WHERE
                        `parameter_type_id` = 3 
                     AND `parameter_count_id` = `iv`.`victim_civil_status`
                     LIMIT 1
                     ) as `civil_status_name`, 
                   (SELECT 
                        `parameter_name`
                     FROM 
                        `icms_global_parameter`
                     WHERE
                        `parameter_type_id` = 9
                     AND `parameter_count_id` = `iv`.`victim_gender`
                     LIMIT 1                    
                    ) as `gender_name`, 
                    (SELECT 
                        `parameter_name`
                     FROM 
                        `icms_global_parameter`
                     WHERE
                        `parameter_type_id` = 4
                     AND `parameter_count_id` = `iv`.`victim_religion`
                     LIMIT 1                    
                    ) as `region_name`, 
                   (SELECT 
                      CONCAT(`vi`.`victim_info_first_name`, ' ', `vi`.`victim_info_middle_name`, ' ', `vi`.`victim_info_last_name`)
                    FROM 
                       `icms_victim_info` `vi`
                    WHERE 
                        `vi`.`victim_info_is_assumed` = 0
                    AND 
                        `vi`.`victim_id` = `iv`.`victim_id`
                    LIMIT 1 
                   ) as `real_full_name`, 
                   (SELECT 
                      CONCAT(`vi`.`victim_info_first_name`, ' ', `vi`.`victim_info_middle_name`, ' ', `vi`.`victim_info_last_name`)
                    FROM 
                       `icms_victim_info` `vi`
                    WHERE 
                        `vi`.`victim_info_is_assumed` = 1 
                    AND 
                        `vi`.`victim_id` = `iv`.`victim_id`
                    LIMIT 1 
                   ) as `assumed_full_name`, 
                   (
                    SELECT 
                         DATE_FORMAT(`victim_info_dob`, '%M %d, %Y')
                     FROM 
                        `icms_victim_info` `vi`
                     WHERE 
                         `vi`.`victim_info_is_assumed` = 0
                     AND 
                         `vi`.`victim_id` = `iv`.`victim_id`
                     LIMIT 1 
                   ) as `real_dob`, 
                   (
                    SELECT 
                         DATE_FORMAT(`victim_info_dob`, '%M %d, %Y')
                     FROM 
                        `icms_victim_info` `vi`
                     WHERE 
                         `vi`.`victim_info_is_assumed` = 1
                     AND 
                         `vi`.`victim_id` = `iv`.`victim_id`
                     LIMIT 1 
                   ) as `assumed_dob`
                FROM 
                   `icms_victim` as `iv`       
                WHERE 
                    `iv`.`victim_id` = " . $aParam['victim_id'] . "
                LIMIT  1
               ";

        $aResponse = $this->yel->getRow($sql);

        return $aResponse;
    }

    // victim case list
    public function getVictimCaseList($aParam) {
        $sql = "SELECT `a`.`case_victim_id`, `a`.`case_id`,
		(SELECT `case_number` FROM `icms_case` WHERE `case_id` = `a`.`case_id` LIMIT 1) as `case_number`,
                (SELECT `case_offender_name` FROM `icms_case_offender` WHERE `case_id` = `a`.`case_id` LIMIT 1) as `case_offender_name`,
                (SELECT `employer_name` FROM `icms_employer` WHERE `employer_id` = (SELECT `employer_id` FROM `icms_case_victim_employment` WHERE `case_victim_id` = `a`.`case_victim_id` LIMIT 1)) as `employer_name`,
                (SELECT `recruitment_agency_name` FROM `icms_recruitment_agency` WHERE `recruitment_agency_id` = (SELECT `recruitment_agency_id_local` FROM `icms_case_victim_employment` WHERE `case_victim_id` = `a`.`case_victim_id` LIMIT 1)) as `agency_name`,
                (SELECT `case_victim_deployment_date` FROM `icms_case_victim_deployment` WHERE `case_victim_id` = `a`.`case_victim_id` LIMIT 1) as `case_victim_deployment_date`,
                (SELECT `country_name` FROM `icms_global_country` WHERE `country_id` = (SELECT `case_victim_deployment_country_destination` FROM `icms_case_victim_deployment` WHERE `case_victim_id` = `a`.`case_victim_id` LIMIT 1)) as `country`,
                (SELECT `case_victim_deployment_country_destination` FROM `icms_case_victim_deployment` WHERE `case_victim_id` = `a`.`case_victim_id` LIMIT 1) as `case_victim_deployment_country_destination`,
                (SELECT `recruitment_agency_id_local` FROM `icms_case_victim_employment` WHERE `case_victim_id` = `a`.`case_victim_id` LIMIT 1) as `recruitment_agency_id_local`,
                (SELECT `employer_id` FROM `icms_case_victim_employment` WHERE `case_victim_id` = `a`.`case_victim_id` LIMIT 1) as `employer_id`
                FROM `icms_case_victim` `a` WHERE `a`.`victim_id` = '" . $aParam . "' AND `a`.`case_victim_is_active` = '1' ORDER BY `a`.`case_victim_date_added` DESC";

        $aResponse = $this->yel->GetAll($sql);

        return $aResponse;
    }

    public function getVictimInfoByID($victim_id) {
        $sql = "SELECT `a`.*,
                (SELECT `victim_civil_status` FROM `icms_victim` WHERE `victim_id` = `a`.`victim_id`) as `victim_civil_status`,
                (SELECT `victim_gender` FROM `icms_victim` WHERE `victim_id` = `a`.`victim_id`) as `victim_gender`,
                (SELECT `victim_religion` FROM `icms_victim` WHERE `victim_id` = `a`.`victim_id`) as `victim_religion`,
                (SELECT `parameter_name` FROM `icms_global_parameter` WHERE `parameter_type_id` = '3' AND `parameter_count_id` = (SELECT `victim_civil_status` FROM `icms_victim` WHERE `victim_id` = `a`.`victim_id`)) as `civil_status`,
                (SELECT `parameter_name` FROM `icms_global_parameter` WHERE `parameter_type_id` = '9' AND `parameter_count_id` = (SELECT `victim_gender` FROM `icms_victim` WHERE `victim_id` = `a`.`victim_id`)) as `gender`,
                (SELECT `parameter_name` FROM `icms_global_parameter` WHERE `parameter_type_id` = '4' AND `parameter_count_id` = (SELECT `victim_religion` FROM `icms_victim` WHERE `victim_id` = `a`.`victim_id`)) as `religion`,
                (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`= `a`.`victim_info_city_pob` AND `location_type_id`='5') as `city`
                FROM `icms_victim_info` `a` WHERE `a`.`victim_id` = '" . $victim_id . "' 
                AND  `a`.`victim_info_is_assumed` = 0
                ";
        $aResponse = $this->yel->GetRow($sql);

        return $aResponse;
    }

    public function getVictimPassportByCaseVictimID($aParam) {
        $sql = "SELECT * FROM `icms_victim_passport` WHERE `case_victim_id` = '" . $aParam . "'";

        $aResponse = $this->yel->GetRow($sql);

        return $aResponse;
    }

//    public function updateVictimInfo($aParam) {
//        $sql = "UPDATE `icms_victim_info` SET 
//                `victim_info_first_name` = '" . $aParam['victim_info_first_name'] . "',
//                `victim_info_middle_name` = '" . $aParam['victim_info_middle_name'] . "',
//                `victim_info_last_name` = '" . $aParam['victim_info_last_name'] . "',   
//                `victim_info_suffix` = '" . $aParam['victim_info_suffix'] . "', 
//                `victim_info_dob` = '" . $aParam['victim_info_dob'] . "',
//                `victim_info_city_pob` = '" . $aParam['victim_info_city_pob'] . "'
//                WHERE `victim_info_id` = '" . $aParamp['victim_info_id'] . "'";
//
//        $aResponse = $this->yel->exec($sql);
//
//        return $aResponse;
//    }
//
//    public function updateVictimAddress($aParam) {
//        $sql = "UPDATE `icms_victim_address_list` SET 
//                `country_id` = '" . $aParam['country_id'] . "',
//                `victim_address_list_region_id` = '" . $aParam['victim_address_list_region_id'] . "',
//                `victim_address_list_province_id` = '" . $aParam['victim_address_list_province_id'] . "',   
//                `victim_address_list_city_id` = '" . $aParam['victim_address_list_city_id'] . "', 
//                `victim_address_list_brgy_id` = '" . $aParam['victim_address_list_brgy_id'] . "',
//                `victim_address_list_address` = '" . $aParam['victim_address_list_address'] . "'
//                WHERE `victim_id` = '" . $aParamp['victim_id'] . "'";
//
//        $aResponse = $this->yel->exec($sql);
//
//        return $aResponse;
//    }
//
//    public function updateVictimContact($aParam) {
//        $sql = "UPDATE `icms_victim_contact_details` SET 
//                `victim_contact_detail_type` = '" . $aParam['victim_contact_detail_type'] . "',
//                `victim_contact_detail_content` = '" . $aParam['victim_contact_detail_content'] . "'
//                WHERE `victim_id` = '" . $aParamp['victim_id'] . "'";
//
//        $aResponse = $this->yel->exec($sql);
//
//        return $aResponse;
//    }
//
//    public function updateVictimEducation($aParam) {
//        $sql = "UPDATE `icms_victim_education` SET 
//                `victim_education_type` = '" . $aParam['victim_education_type'] . "',
//                `victim_education_grade_year` = '" . $aParam['victim_education_grade_year'] . "',
//                `victim_education_school` = '" . $aParam['victim_education_school'] . "',
//                `victim_education_course` = '" . $aParam['victim_education_course'] . "',
//                `victim_education_start` = '" . $aParam['victim_education_start'] . "',
//                `victim_education_end` = '" . $aParam['victim_education_end'] . "'
//                WHERE `victim_id` = '" . $aParamp['victim_id'] . "'";
//
//        $aResponse = $this->yel->exec($sql);
//
//        return $aResponse;
//    }
//
//    public function updateVictimRelative($aParam) {
//        $sql = "UPDATE `icms_victim_relative` SET 
//                `victim_relative_fullname` = '" . $aParam['victim_relative_fullname'] . "',
//                `victim_relative_type` = '" . $aParam['victim_relative_type'] . "',
//                `victim_relative_type_other` = '" . $aParam['victim_relative_type_other'] . "',
//                `victim_relative_primary_contact_number` = '" . $aParam['victim_relative_primary_contact_number'] . "',
//                `victim_relative_second_contact_number` = '" . $aParam['victim_relative_second_contact_number'] . "',
//                `victim_relative_email` = '" . $aParam['victim_relative_email'] . "',
//                `victim_relative_region` = '" . $aParam['victim_relative_region'] . "',
//                `victim_relative_province` = '" . $aParam['victim_relative_province'] . "',
//                `victim_relative_city` = '" . $aParam['victim_relative_city'] . "',
//                `victim_relative_brgy` = '" . $aParam['victim_relative_brgy'] . "',
//                `victim_relative_address` = '" . $aParam['victim_relative_address'] . "'
//                WHERE `victim_id` = '" . $aParamp['victim_id'] . "'";
//
//        $aResponse = $this->yel->exec($sql);
//
//        return $aResponse;
//    }

    public function getVictimAddressByID($aParam) {
        $sql = "SELECT * FROM `icms_victim_address_list` WHERE `victim_address_list_id` = '" . $aParam['victim_address_list_id'] . "' AND `victim_id` = '" . $aParam['victim_id'] . "'";

        $aResponse = $this->yel->GetRow($sql);

        return $aResponse;
    }

    public function addVictimAddrById($aParam) {
        $sql = "
                INSERT INTO  
                `icms_victim_address_list` 
                SET 
                `victim_id` = '" . $aParam['victim_id'] . "',
                `victim_address_list_region_id`='" . $aParam['victim_address_list_region_id'] . "',
                `country_id` = '173',
                `victim_address_list_province_id` = '" . $aParam['victim_address_list_province_id'] . "' , 
                `victim_address_list_city_id`='" . $aParam['victim_address_list_city_id'] . "', 
                `victim_address_list_brgy_id` = '" . $aParam['victim_address_list_brgy_id'] . "', 
                `victim_address_list_address`='" . $aParam['victim_address_list_address'] . "', 
                `victim_address_list_added_by` = '" . $this->session->userdata('userData')['user_id'] . "' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function addVictimContactById($aParam) {
        $sql = "
                INSERT INTO  
                `icms_victim_contact_details` 
                SET 
                `victim_id` = '" . $aParam['victim_id'] . "',
                `victim_contact_detail_type`='" . $aParam['victim_contact_detail_type'] . "', 
                `victim_contact_detail_content` = '" . $aParam['victim_contact_detail_content'] . "' ,
                `victim_contact_details_added_by` = '" . $this->session->userdata('userData')['user_id'] . "' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function addVictimEducationById($aParam) {
        $sql = "
                INSERT INTO  
                `icms_victim_education` 
                SET
                `victim_id` = '" . $aParam['victim_id'] . "',
                `victim_education_type`='" . $aParam['victim_education_type'] . "', 
                `victim_education_grade_year` = '" . $aParam['victim_education_grade_year'] . "' ,
                `victim_education_school`='" . $aParam['victim_education_school'] . "', 
                `victim_education_course` = '" . $aParam['victim_education_course'] . "' ,
                `victim_education_start`='" . $aParam['victim_education_start'] . "', 
                `victim_education_end` = '" . $aParam['victim_education_end'] . "',
                `victim_education_added_by` = '" . $this->session->userdata('userData')['user_id'] . "'
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function addVictimRelativeById($aParam) {
        $sql = "
                INSERT INTO  
                `icms_victim_relative` 
                SET 
                `victim_id` = '" . $aParam['victim_id'] . "',
                `victim_relative_fullname`='" . $aParam['victim_relative_fullname'] . "', 
                `victim_relative_type` = '" . $aParam['victim_relative_type'] . "' , 
                `victim_relative_primary_contact_number`='" . $aParam['victim_relative_primary_contact_number'] . "', 
                `victim_relative_second_contact_number` = '" . $aParam['victim_relative_second_contact_number'] . "', 
                `victim_relative_type_other` = '" . $aParam['victim_relative_type_other'] . "', 
                `victim_relative_email`='" . $aParam['victim_relative_email'] . "',
                `victim_relative_added_by` = '" . $this->session->userdata('userData')['user_id'] . "'
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function getVictimDetailById($aParam) {
        $sql = "SELECT * FROM `icms_victim` WHERE `victim_id` = '" . $aParam['victim_id'] . "'";

        $aResponse = $this->yel->getRow($sql);

        return $aResponse;
    }

    public function updateVictimInfoById($aParam) {
        $sql = "
                UPDATE `icms_victim_info` 
                SET 
                `victim_info_first_name`='" . $aParam['victim_info_first_name'] . "', 
                `victim_info_middle_name`='" . $aParam['victim_info_middle_name'] . "', 
                `victim_info_last_name`='" . $aParam['victim_info_last_name'] . "', 
                `victim_info_suffix`='" . $aParam['victim_info_suffix'] . "', 
                `victim_info_dob`='" . date("Y-m-d", strtotime($aParam['victim_info_dob'])) . "', 
                `victim_info_city_pob`='" . $aParam['victim_info_city_pob'] . "', 
                `victim_info_date_modified`=now(), 
                `victim_info_modified_by`='" . $this->session->userdata('userData')['user_id'] . "' 
                WHERE 
               `victim_id` = '" . $aParam['victim_id'] . "' 
                AND 
                `victim_info_is_assumed` = '0' 
               ";

        $aResponse = $this->yel->exec($sql);
    }

    public function updateVictimDetailById($aParam) {
        $sql = "
                UPDATE `icms_victim` 
                SET 
                `victim_civil_status`='" . $aParam['victim_civil_status'] . "', 
                `victim_gender`='" . $aParam['victim_gender'] . "', 
                `victim_religion`='" . $aParam['victim_religion'] . "', 
                `victim_date_modified`=now(), 
                `victim_modified_by`='" . $this->session->userdata('userData')['user_id'] . "' 
                WHERE 
               `victim_id` = '" . $aParam['victim_id'] . "' 
               ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    /*
     * by:dev_andy
     */

    public function getVictimIdByCaseId($aParam) {

        $sql = " 
                SELECT 
                    `victim_id`
                FROM 
                    `icms_case_victim` 
                WHERE 
                   `case_id`='" . $aParam['case_id'] . "'              
                LIMIT 1
              ";

        $aResponse = $this->yel->getOne($sql);
        return $aResponse;
    }

    /*
     * by:dev_andy
     */

    public function setVictimDetailsByVictimId($aParam) {

        $sql = " 
                UPDATE 
                    `icms_victim_info`
                SET 
                    `victim_info_first_name`='" . $aParam['fname'] . "',
                    `victim_info_middle_name`='" . $aParam['mname'] . "',
                    `victim_info_last_name`='" . $aParam['lname'] . "',
                    `victim_info_suffix`='" . $aParam['xtname'] . "',
                    `victim_info_dob`=" . $this->yel->checkDateIfExist($aParam['dob']) . ",
                    `victim_info_city_pob`='" . $aParam['pob'] . "',
                    `victim_info_modified_by`='" . $_SESSION['userData']['user_id'] . "'
                WHERE 
                    `victim_id`=" . $aParam['victim_id'] . "
                AND `victim_info_is_assumed`=0
              ";


        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    /*
     * by:dev_andy
     */

    public function setVictimInfoByVictimID($aParam) {

        $sql = " 
                UPDATE 
                    `icms_victim`
                SET 
                    `victim_civil_status`= " . $this->yel->checkifStringExist($aParam['civilStat']) . ",
                    `victim_gender`= " . $this->yel->checkifStringExist($aParam['gender']) . ",
                    `victim_religion`= " . $this->yel->checkifStringExist($aParam['religion']) . ",
                    `victim_info_nickname`= " . $this->yel->checkifStringExist($aParam['nickname']) . ",
                    `victim_ethnic_group`= " . $this->yel->checkifStringExist($aParam['ethnicgroup']) . ",
                    `victim_modified_by`='" . $_SESSION['userData']['user_id'] . "'
                WHERE 
                    `victim_id`=" . $aParam['victim_id'] . "
              ";
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    /*
     * by:dev_andy
     */

    public function getVictimInfoByVictimID($aParam) {
        $sql = " 
                SELECT 
                    (SELECT `parameter_name` FROM `icms_global_parameter` WHERE `parameter_type_id`='3' AND `parameter_count_id`=`cv`.`victim_civil_status` LIMIT 1) as `Civil_status`,
                    (SELECT `parameter_name` FROM `icms_global_parameter` WHERE `parameter_type_id`='9' AND `parameter_count_id`=`cv`.`victim_gender` LIMIT 1) as `Sex`,
                    (SELECT `parameter_name` FROM `icms_global_parameter` WHERE `parameter_type_id`='4' AND `parameter_count_id`=`cv`.`victim_religion` LIMIT 1) as `Religion`
                FROM 
                    `icms_victim` `cv`
                WHERE 
                    `cv`.`victim_id`=" . $aParam['victim_id'] . "
                AND `cv`.`victim_info_is_assumed`=0
                LIMIT 1
              ";


        $aResponse = $this->yel->getRow($sql);
        return $aResponse;
    }

    public function getVictimDetailsByVictimID($aParam, $isAssumed) {
        $sql = " 
                SELECT 
                    `vi`.`victim_info_first_name`,
                    `vi`.`victim_info_middle_name`,
                    `vi`.`victim_info_last_name`,
                    `vi`.`victim_info_suffix`,
                    `vi`.`victim_info_dob`,
                   (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`vi`.`victim_info_city_pob` AND `location_type_id`='4')  as `place_of_birth`
                FROM 
                    `icms_victim_info` `vi`
                WHERE 
                    `vi`.`victim_id`='" . $aParam['victim_id'] . "' 
                AND `victim_info_is_assumed`='" . $isAssumed . "'
                LIMIT 1
              ";

        $aResponse = $this->yel->getRow($sql);
        return $aResponse;
    }

    public function setAssumedVictimDetailsByVictimId($aParam) {
        $sql = " 
                UPDATE 
                    `icms_victim_info`
                SET 
                    `victim_info_first_name`= " . $this->yel->checkifStringExist($aParam['fname']) . ",
                    `victim_info_middle_name`= " . $this->yel->checkifStringExist($aParam['mname']) . ",
                    `victim_info_last_name`= " . $this->yel->checkifStringExist($aParam['lname']) . ",
                    `victim_info_dob`=" . $this->yel->checkifStringExist($aParam['dob']) . ",
                    `victim_info_modified_by`='" . $_SESSION['userData']['user_id'] . "'
                WHERE 
                    `victim_id`=" . $aParam['victim_id'] . "
                AND `victim_info_is_assumed`=1
              ";
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

}
