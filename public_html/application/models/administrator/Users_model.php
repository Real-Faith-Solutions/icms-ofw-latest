<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class Users_model extends CI_Model {

    const DEFAULT_PASSWORD = 'oplecenter';

    public function getAllUsers($aParam) {

        $aResponse = [];

        $sql = "
            SELECT 
                `u`.`user_id`,
                `u`.`user_firstname`,
                `u`.`user_middlename`,
                `u`.`user_lastname`,
                `u`.`user_phone_number`,
                `u`.`user_mobile_number`,
                `u`.`user_job_title`,
        	`u`.`user_email`,
                `u`.`agency_branch_id`,
                `u`.`user_level_id`,
                `u`.`user_is_active`,
                `u`.`agency_is_active`,
                `u`.`agency_branch_is_active`,
                `u`.`user_level_is_active`,
                `u`.`user_date_added`,
                `u`.`user_date_modified`,
                `gat`.`agency_name`,
                `gat`.`agency_abbr`,
                `ga`.`agency_branch_name`,
                `ga`.`agency_branch_is_main`,
                (SELECT `document_hash` FROM `icms_image_upload` WHERE `photo_type_id`='1' AND `panel_id`='1' AND `image_upload_is_active`='1' AND `image_upload_is_primary`='1' AND `user_Id`=`u`.`user_id`) as `photo`,
                (SELECT `transaction_parameter_name`  FROM `icms_transaction_parameter` 
                WHERE `transaction_parameter_type_id` = 5 
                AND `transaction_parameter_count_id` = `u`.`user_level_id` LIMIT 1 ) as `user_level_description`
            FROM
                `icms_user` `u`,
                `icms_agency_branch` `ga`,
                `icms_agency` `gat`
            WHERE 
            " . $aParam['filter'] . "
                (`ga`.`agency_branch_id`= `u`.`agency_branch_id`
            AND `gat`.`agency_id`=`ga`.`agency_id` )" . $aParam['orderby'] . " LIMIT  " . $aParam['page'] . "," . $aParam['limit']
        ;

        $aResponse['list'] = $this->yel->GetAll($sql);
        $qry = "
            SELECT 
               COUNT(1)
            FROM
                `icms_user` `u`,
                `icms_agency_branch` `ga`,
                `icms_agency` `gat`
            WHERE 
            " . $aParam['filter'] . "
                (`ga`.`agency_branch_id`= `u`.`agency_branch_id`
            AND `gat`.`agency_id`=`ga`.`agency_id` )";
        $aResponse['count'] = $this->yel->GetOne($qry);

        return $aResponse;
    }

    public function getMyUsers($aParam) {

        $aResponse = [];

        $sql = "
            SELECT 
                `u`.`user_id`,
                `u`.`user_firstname`,
                `u`.`user_middlename`,
                `u`.`user_lastname`,
                `u`.`user_phone_number`,
                `u`.`user_mobile_number`,
                `u`.`user_job_title`,
        	`u`.`user_email`,
                `u`.`agency_branch_id`,
                `u`.`user_level_id`,
                `u`.`user_is_active`,
                `u`.`agency_is_active`,
                `u`.`agency_branch_is_active`,
                `u`.`user_level_is_active`,
                `u`.`user_date_added`,
                `u`.`user_date_modified`,
                `gat`.`agency_name`,
                `gat`.`agency_abbr`,
                `ga`.`agency_branch_name`,
                `ga`.`agency_branch_is_main`,
                (SELECT `document_hash` FROM `icms_image_upload` WHERE `photo_type_id`='1' AND `panel_id`='1' AND `image_upload_is_active`='1' AND `image_upload_is_primary`='1' AND `user_Id`=`u`.`user_id`) as `photo`,
                (SELECT `transaction_parameter_name`  FROM `icms_transaction_parameter` 
                WHERE `transaction_parameter_type_id` = 5 
                AND `transaction_parameter_count_id` = `u`.`user_level_id` LIMIT 1 ) as `user_level_description`
            FROM
                `icms_user` `u`,
                `icms_agency_branch` `ga`,
                `icms_agency` `gat`
            WHERE 
            " . $aParam['filter'] . "
                (`ga`.`agency_branch_id`= `u`.`agency_branch_id`
            AND `gat`.`agency_id`=`ga`.`agency_id` )
            AND `u`.`agency_branch_id`='" . $_SESSION['userData']['agency_branch_id'] . "'
            " . $aParam['orderby'] . " LIMIT  " . $aParam['page'] . "," . $aParam['limit']
        ;

        $aResponse['list'] = $this->yel->GetAll($sql);
        $qry = "
            SELECT 
               COUNT(1)
            FROM
                `icms_user` `u`,
                `icms_agency_branch` `ga`,
                `icms_agency` `gat`
            WHERE 
            " . $aParam['filter'] . "
                (`ga`.`agency_branch_id`= `u`.`agency_branch_id`
            AND `gat`.`agency_id`=`ga`.`agency_id` )
            AND `u`.`agency_branch_id`='" . $_SESSION['userData']['agency_branch_id'] . "'";
        $aResponse['count'] = $this->yel->GetOne($qry);

        return $aResponse;
    }

    public function getUserIDByFilter_username($aParam) {

        $sql = "
                SELECT 
                    `user_id`
                FROM 
                    `icms_user` 
                WHERE 
                     MATCH (`user_firstname`,`user_lastname`)AGAINST('+" . $aParam['keyword'] . "*' IN BOOLEAN MODE)  limit 50
             ";
        $result = $this->yel->GetAll($sql);
        return $result;
    }

    public function getUserIDByFilter_branch($aParam) {
        $sql = "
                SELECT 
                    `u`.`user_id`
                FROM 
                    `icms_user` `u`,
                    `icms_agency_branch` `iga`
                WHERE 
                     MATCH (`iga`.`agency_branch_name`)AGAINST('+" . $aParam['keyword'] . "*' IN BOOLEAN MODE)
                AND `u`.`agency_branch_id`=`iga`.`agency_branch_id` limit 50
             ";
        $result = $this->yel->GetAll($sql);
        return $result;
    }

    public function getUserIDByFilter_agencyname($aParam) {
        $sql = "
                SELECT 
                    `u`.`user_id`
                FROM 
                    `icms_user` `u`,
                    `icms_agency_branch` `iga`,
                    `icms_agency` `igat`
                WHERE 
                     MATCH (`igat`.`agency_name`,`igat`.`agency_abbr`,`igat`.`agency_description`)AGAINST('+" . $aParam['keyword'] . "*' IN BOOLEAN MODE)
                AND `iga`.`agency_id`=`igat`.`agency_id`
                AND `u`.`agency_branch_id`=`iga`.`agency_branch_id`  limit 50
             ";

        $result = $this->yel->GetAll($sql);
        return $result;
    }

    public function getUsersInfobyID($aParam) {
        $sql = "
               SELECT 
                `iu`.*
               FROM 
                `icms_user` `iu`
               WHERE 
                `iu`.`user_id` = " . $aParam['user_id'] . "
               LIMIT 1
             ";
        $aResponse = $this->yel->GetRow($sql);
        return $aResponse;
    }

    public function getAgencyTypeIDByKeyword($keyword) {
        $sql = "
             SELECT 
                `govt_agency_type_id` 
             FROM 
                `icms_agency` 
             WHERE 
                MATCH (`agency_name`)AGAINST('+" . $keyword . "*' IN BOOLEAN MODE)
             ";
        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getAgencyBranchByKeyword($keyword) {
        $sql = "
             SELECT 
                `govt_agency_id` 
             FROM 
                `icms_agency_branch` 
             WHERE 
                MATCH (`agency_branch_name`)AGAINST('+" . $keyword . "*' IN BOOLEAN MODE)
             ";
        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getAgencyIDByFilteredID($ids) {
        $sql = "
             SELECT 
                `govt_agency_id` 
             FROM 
                `icms_agency_branch` 
             WHERE 
                (`govt_agency_type_id`) IN (" . $ids . ")
             ";
        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getAgencyIDFilterByName($aParam) {
        $sql = "
             SELECT 
                `u`.`govt_agency_id` 
             FROM 
                `icms_user`  `u`
             WHERE 
               MATCH (`u`.`user_firstname`,`u`.`user_lastname`)AGAINST('+" . $aParam['keyword'] . "*' IN BOOLEAN MODE) 
             ";
        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getAgencyAbbreviation($aParam) {
        $sql = "
            SELECT 
               `agency_abbr`
            FROM
               `icms_agency`
            WHERE
               `agency_id`='" . $aParam['agencytype'] . "'";

        $result = $this->yel->GetOne($sql);
        return $result;
    }

    public function getUserCount($aParam) {
        $sql = "
            SELECT 
                COUNT(1)
            FROM
               `icms_user` `u`,
               `icms_agency_branch` `ga`
            WHERE
                `u`.`agency_branch_id`= `ga`.`agency_branch_id`
            AND `ga`.`agency_id`='" . $aParam['agencytype'] . "'";

        $result = $this->yel->GetOne($sql);
        return $result;
    }

    public function addNewAgencyUser($aParam) {
        $sql = "
            INSERT INTO 
                `icms_user`
            SET
               `user_firstname` ='" . $aParam['fname'] . "',
               `user_middlename`='" . $aParam['mname'] . "',
               `user_lastname`='" . $aParam['lname'] . "',
               `user_phone_number`='" . $aParam['tel'] . "',
               `user_mobile_number`='" . $aParam['mob'] . "',
               `user_gender`='" . $aParam['sex'] . "',
               `user_job_title`='" . $aParam['area_desc'] . "',
               `user_username`='" . $aParam['username'] . "',
               `user_access_code`='" . $aParam['accessCode'] . "',
               `user_email`='" . $aParam['email'] . "',
               `agency_branch_id`='" . $aParam['agencyid'] . "',
               `user_password`='" . $this->yel->encrypt(self::DEFAULT_PASSWORD) . "',
               `user_level_id`='" . $aParam['userlevel'] . "'";

        $result = $this->yel->exec($sql);
        return $result['insert_id'];
    }

    public function addUserAddress($aParam) {
        if (isset($aParam['newuserid']) == true) {
            $sql = "
                INSERT INTO 
                    `icms_address_list`
                SET
                    `address_list_address_type`='3',
                    `address_list_origin_id`='" . $aParam['newuserid'] . "',
                    `address_list_country`='" . $aParam['country'] . "',
                    `address_list_region`='" . $aParam['region'] . "',
                    `address_list_province`='" . $aParam['prov'] . "',
                    `address_list_city`='" . $aParam['city'] . "',
                    `address_list_brgy`='" . $aParam['brgy'] . "',
                    `address_list_address`='" . $aParam['address'] . "',
                    `address_list_origin_address`='1'
             ";
        } else {
            $sql = "
                INSERT INTO
                    `icms_address_list`
                SET
                    `address_list_country`='" . $aParam['country'] . "',
                    `address_list_region`='" . $aParam['region'] . "',
                    `address_list_province`='" . $aParam['state_prov'] . "',
                    `address_list_city`='" . $aParam['city'] . "',
                    `address_list_brgy`='" . $aParam['brgy'] . "',
                    `address_list_address`='" . $aParam['area_detailed'] . "',
                    `address_list_address_type`='3',
                    `address_list_origin_id`='" . $aParam['user_id'] . "',
                    `address_list_origin_address`='1'
               ";
        }


        $result = $this->yel->exec($sql);
        return $result;
    }

    public function setUserStatus($aParam) {
        $sql = "
                UPDATE  
                    `icms_user`
                SET
                    `user_is_active`='" . $aParam['newStat'] . "'
                WHERE
                    `user_id`='" . $aParam['user_id'] . "'
             ";

        $result = $this->yel->exec($sql);
        return $result;
    }

    public function getUserDetails($aParam) {
        $sql = "
            SELECT 
                `u`.*,
                (SELECT `parameter_name` FROM `icms_global_parameter` WHERE `parameter_type_id`='9' AND `parameter_count_id`=`u`.`user_gender`) as gender,
                (SELECT `transaction_parameter_name` FROM `icms_transaction_parameter` WHERE `transaction_parameter_type_id`='5' AND `transaction_parameter_count_id`=`u`.`user_level_id`) as userlevel
                
            FROM
               `icms_user` `u`
            WHERE
               `u`.`user_id`='" . $aParam['user_id'] . "'";

        $result = $this->yel->GetRow($sql);
        return $result;
    }

    public function getUserAddressUserID($aParam) {
        $sql = "
                SELECT
                   `al`.*,
                   (SELECT `country_name` FROM `icms_global_country` WHERE `country_id`=`al`.`address_list_country`) as country,
                   (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`al`.`address_list_region` AND `location_type_id`='3') as region,
                   (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`al`.`address_list_province` AND `location_type_id`='4') as province,
                   (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`al`.`address_list_province` AND `location_type_id`='2' AND `location_prerequisite_id`=`al`.`address_list_country`) as state,
                   (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`al`.`address_list_city` AND `location_type_id`='5') as city,
                   (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`al`.`address_list_brgy` AND `location_type_id`='6') as brgy
                FROM 
                    `icms_address_list` `al`
                WHERE
                    `al`.`address_list_origin_id`='" . $aParam . "'
                AND
                    `al`.`address_list_address_type`='3'
                ";

        $result = $this->yel->GetRow($sql);
        return $result;
    }

    public function setUserDetails($aParam) {
        $sql = "
                UPDATE
                    `icms_user`
                SET
                    `user_firstname`='" . $aParam['fname'] . "',
                    `user_middlename`='" . $aParam['mname'] . "',
                    `user_lastname`='" . $aParam['lname'] . "',
                    `user_email`='" . $aParam['txt_email'] . "',
                    `user_phone_number`='" . $aParam['tel'] . "',
                    `user_mobile_number`='" . $aParam['mob'] . "',
                    `user_gender`='" . $aParam['sex'] . "',
                    `user_job_title`='" . $aParam['area_desc'] . "',
                    `user_level_id`='" . $aParam['userLevel'] . "',
                    `user_is_active`='" . $aParam['user_stats'] . "'                       
                WHERE
                    `user_id`='" . $aParam['user_id'] . "'
               ";

        $result = $this->yel->exec($sql);

        if ($aParam['user_stats'] == '1') {
            $sql = "                        
                UPDATE
                    `icms_user`
                SET
                    `user_is_verified`='" . $aParam['user_stats'] . "'                       
                WHERE
                    `user_id`='" . $aParam['user_id'] . "'
               ";
            $this->yel->exec($sql);
        }

        return $result;
    }

    public function getUserDetails_logs($aParam) {
        $sql = "
                SELECT
                    `user_firstname`,
                    `user_middlename`,
                    `user_lastname`,
                    `user_phone_number`,
                    `user_mobile_number`,
                    `user_email`,
                    `user_gender`,
                    CASE WHEN `user_gender`='1' THEN 'Male' ELSE 'Female' END as Sex,
                    CASE WHEN `user_is_active`='1' THEN 'Active' ELSE 'Inactive' END as Status,
                    `user_job_title`
                FROM  
                    `icms_user`
                WHERE
                    `user_id`='" . $aParam['user_id'] . "'
               ";

        $result = $this->yel->GetRow($sql);
        return $result;
    }

    public function setUserAddress($aParam) {
        $sql = "
                UPDATE
                    `icms_address_list`
                SET
                    `address_list_country`='" . $aParam['country'] . "',
                    `address_list_region`='" . $aParam['region'] . "',
                    `address_list_province`='" . $aParam['state_prov'] . "',
                    `address_list_city`='" . $aParam['city'] . "',
                    `address_list_brgy`='" . $aParam['brgy'] . "',
                    `address_list_address`='" . $aParam['area_detailed'] . "'
                WHERE
                    `address_list_origin_id`='" . $aParam['user_id'] . "'
                AND `address_list_address_type`='3'
               ";

        $result = $this->yel->exec($sql);
        return $result;
    }

    public function getUserAddress_logs($aParam) {
        $sql = "
            SELECT
                `al`.`address_list_id`,
                `al`.`address_list_address` as detailed_address,
                   (SELECT `country_name` FROM `icms_global_country` WHERE `country_id`=`al`.`address_list_country`) as country,
                   (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`al`.`address_list_region` AND `location_type_id`='3') as region,
                   (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`al`.`address_list_province` AND `location_type_id`='4') as province,
                   (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`al`.`address_list_province` AND `location_type_id`='2' AND `location_prerequisite_id`=`al`.`address_list_country`) as state,
                   (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`al`.`address_list_city` AND `location_type_id`='5') as city,
                   (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`al`.`address_list_brgy` AND `location_type_id`='6') as brgy
                FROM
                    `icms_address_list` `al`
                WHERE
                   `al`.`address_list_origin_id`='" . $aParam['user_id'] . "'
                AND `al`.`address_list_address_type`='3'
               ";

        $result = $this->yel->GetRow($sql);
        return $result;
    }

    public function getUserEmailAvailability($aParam) {
        $sql = "
                SELECT  
                    COUNT(1)
               FROM
                    `icms_user`
               WHERE
                    `user_email`='" . $aParam['email'] . "'
             ";
        //exit($sql);
        $result = $this->yel->GetOne($sql);
        return $result;
    }

    // public function getUserEmailAvailability($aParam) {
    //     $sql = "
    //             SELECT  
    //                 COUNT(1)
    //            FROM
    //                 `icms_user`
    //            WHERE
    //                 `user_email`= '" . $aParam['email'] . "' AND 
    //                 `agency_branch_id`='" . $aParam['agencyid'] . "'
    //          ";

    //     $result = $this->yel->GetOne($sql);
    //     return $result;
    // }

    public function getResetPasswordStatus($aParam) {
        $sql = "
                SELECT  
                    `user_date_modified`,
                    `user_access_code`
               FROM
                    `icms_user`
               WHERE
                    `user_id`='" . $aParam['user_id'] . "'
               LIMIT 1
             ";

        $result = $this->yel->GetRow($sql);
        return $result;
    }

    public function setResetPasswordAccessCode($aParam) {
        $sql = "
                UPDATE
                    `icms_user`
                SET
                    `user_access_code`='" . $aParam['accessCode'] . "'
                WHERE
                     `user_id`='" . $aParam['user_id'] . "'
               ";

        $result = $this->yel->exec($sql);
        return $result;
    }

    public function getAdminUsersByAgencyBranchId($aParam) {
        $sql = "
                SELECT 
                * 
                FROM `icms_user` 
                WHERE 
                `agency_branch_id` = '" . $aParam['agency_branch_id'] . "' 
                AND 
                `user_is_active` = '1' 
                AND 
                `user_level_id`='1'
             ";
        $result = $this->yel->GetRow($sql);

        return $result;
    }

    public function getSuperAdminUserId() {
        $sql = "
                SELECT 
                   *
                FROM 
                    `icms_user` 
                WHERE 
                    `agency_branch_id`='1'
                AND `user_level_id`='1'
                AND `user_is_active`='1'
                AND `agency_is_active`='1'
                AND `agency_branch_is_active`='1'
                AND `user_level_is_active`='1'
                AND `user_is_verified`='1'
             ";
        $aResponse = $this->yel->getRow($sql);
        return $aResponse;
    }

    public function changePassword($aParam) {
        $sql = "
             UPDATE
                    `icms_user`
                SET
                   `user_password`='" . $this->yel->encrypt($aParam['password']) . "'
                WHERE
                     `user_id`='" . $aParam['user_id'] . "'
        ";
        
        return $this->yel->exec($sql);
    }

}
