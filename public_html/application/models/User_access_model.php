<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class User_access_model extends CI_Model {

    public function updateLoginAttemptByUserName($aParam){
        $aResponse = [];
        $sql = "
                UPDATE
                    `icms_user`
                SET
                    `login_attempt` = (`login_attempt` + 1)
                WHERE
                    `user_username`='" . $aParam['user'] . "'
            ";
            // exit($sql);
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function resetLoginAttempt($aParam){
        $aResponse = [];
        $sql = "
                UPDATE
                    `icms_user`
                SET
                    `login_attempt` = 0
                WHERE
                    `user_id`='" . $aParam['user_id'] . "'
            ";
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function inactiveUser($aParam){
        $aResponse = [];
        $sql = "
                UPDATE
                    `icms_user`
                SET
                    `user_is_active` = 0
                WHERE
                    `user_username`='" . $aParam['user'] . "'
            ";
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function getLoginAttemptByUserName($aParam){
        $aResponse = [];
        $sql = "
                SELECT
                    `user_id`, 
                    `login_attempt`
                FROM `icms_user`
                WHERE `user_username`='" . $aParam['user'] . "'
                LIMIT 1
            ";
            // exit($sql);
        $aResponse = $this->yel->GetRow($sql); 
        return $aResponse;
    }

    public function getUserlogin($aParam) {

        $aResponse = [];
        $pw = $this->yel->encrypt($aParam['pass']);
        $sql = "
                    SELECT 
                        `user`.`user_id`,
                        `user`.`user_firstname`,
                        `user`.`user_lastname`,
                        `user`.`user_username`,
                        `user`.`agency_branch_id`,
                        `user`.`user_level_id`,
                        `user`.`user_is_active`,
                        `user`.`agency_is_active`,
                        `user`.`agency_branch_is_active`,
                        `user`.`user_level_is_active`,
                        `user`.`user_phone_number`,
                        `user`.`user_mobile_number`,
                        `user`.`user_email`,
                        `ga`.`agency_id`,
                        `ga`.`agency_branch_id`,
                        `ga`.`agency_branch_is_main`,
                        `ga`.`agency_branch_name`,
                        `gat`.`agency_name`,
                        `gat`.`agency_abbr`,
                        `gat`.`agency_is_admin`,
                        `gat`.`agency_description`,
                        (SELECT `transaction_parameter_name` FROM `icms_transaction_parameter` WHERE `transaction_parameter_type_id`='5' AND `transaction_parameter_count_id`=`user`.`user_level_id`) as `user_level`,
                        (SELECT `document_hash` FROM `icms_image_upload` WHERE `photo_type_id`='1' AND `panel_id`='1' AND `image_upload_is_active`='1' AND `image_upload_is_primary`='1' AND `user_Id`=`user`.`user_id`) as `profile_pic`
                    FROM
                        `icms_user` `user`,
                        `icms_agency_branch` `ga`,
                        `icms_agency` `gat`
                    WHERE
                        ( `user`.`user_username`=  '" . $aParam['user'] . "' OR  `user`.`user_email`='" . $aParam['user'] . "')
                    AND `user`.`user_password`=  '" . $pw . "'
                    AND `ga`.`agency_branch_id`=`user`.`agency_branch_id`
                    AND `gat`.`agency_id`=`ga`.`agency_id`
                    LIMIT 1
                ";

        $aResponse = $this->yel->GetRow($sql);

        return $aResponse;
    }

    public function addAppAccess($aParam) {
        $aResponse = [];

        $ip = $this->yel->getUserIP();
        $sql = "
                INSERT INTO
                    `icms_user_app_access`
                SET
                    `user_app_access_key`='" . $aParam['accessKey'] . "',
                    `user_id`='" . $aParam['user_id'] . "',
                    `user_app_ip`='" . $ip . "'
            ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function setAppAccess_inactive($aParam) {
        $aResponse = [];
        $sql = "
                UPDATE
                    `icms_user_app_access`
                SET
                    `user_app_access_is_active`='0'
                WHERE
                    `user_id`='" . $aParam['user_id'] . "'
            ";
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function validateNewUserInfo($aParam) {

        $sql = "
                SELECT 
                   `user_username`,
                   `user_email`,
                   `user_access_code`,
                   `user_is_verified`
                FROM
                    `icms_user`
                WHERE
                    `user_id`='" . $aParam . "'
            ";
        $aResponse = $this->yel->GetRow($sql);
        return $aResponse;
    }

    public function getUserInfoForChangingPassword($user_id) {
        $sql = "
                SELECT 
                    `user`.*,
                    `ga`.`agency_id`,
                    `ga`.`agency_branch_id`,
                    `ga`.`agency_branch_is_main`,
                    `ga`.`agency_branch_name`,
                    `gat`.`agency_name`,
                    `gat`.`agency_abbr`,
                    `gat`.`agency_is_admin`,
                    `gat`.`agency_description`                   
                FROM
                    `icms_user` `user`,
                    `icms_agency_branch` `ga`,
                    `icms_agency` `gat`
                WHERE
                    `user_id`='" . $user_id . "'
                AND `ga`.`agency_branch_id`=`user`.`agency_branch_id`
                AND `gat`.`agency_id`=`ga`.`agency_id`                    
            ";
        $aResponse = $this->yel->GetRow($sql);
        return $aResponse;
    }

    public function setNewUserPassword($aParam) {
        $aResponse = [];
        $sql = "
                UPDATE
                    `icms_user`
                SET
                    `user_is_active`='1',
                    `user_is_verified`='1',
                    `user_access_code`='',
                    `user_password`='" . $aParam['new_pwd'] . "'
                WHERE
                    `user_id`='" . $aParam['user_id'] . "'
            ";
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function getPasswordComparison($aParam) {
        $sql = "
             SELECT 
                COUNT(1) 
             FROM 
                `icms_user` 
             WHERE 
                `user_password`='" . $aParam['old_pwd'] . "'
             AND `user_id`='" . $aParam['user_id'] . "'
             LIMIT 1
             ";
        $aResponse = $this->yel->GetOne($sql);
        return $aResponse;
    }

    public function validateViewLegalServices($aParam) {
        $sql = "
             SELECT 
                COUNT(1) as `result`                
             FROM 
                `icms_agency_services_offered` `aso`,
                `icms_services` `s`
             WHERE 
                `aso`.`agency_branch_id`='" . $aParam['agency_branch_id'] . "'
             AND `aso`.`agency_services_offered_is_active`='1'
             AND `s`.`services_id`=`aso`.`services_id`
             AND `s`.`service_is_active`='1'
             AND `s`.`service_category`='1'
             ";
        $aResponse = $this->yel->GetOne($sql);
        return $aResponse;
    }

    // adding of two factor authentication - in the login pages of the icms.

    public function addTwoFactorAuto($param){
        
        $sql = "
        INSERT INTO `icms_user_case_twofa` SET
        `user_id`='" . $param['user_id'] . "',
        `twofa_type`='" . $param['twofa_type'] . "',
        `twofa_portal`='" . $param['twofa_portal'] . "',
        `twofa_code`='" . $param['twofa_code'] . "'
        ";

        $data = $this->yel->exec($sql);

        return $data;
    }

    public function getTwoFactorAuthentication($param) {
        $data = $param;
        $sql = "SELECT user_id,twofa_code FROM icms_user_case_twofa WHERE user_id='".$data."' ORDER BY twofa_added DESC LIMIT 1";
        
        $result = $this->yel->GetAll($sql);
        return $result;
        
    }
}
