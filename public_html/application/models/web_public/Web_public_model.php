<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class Web_public_model extends CI_Model {

    public function generateTempCaseNumber($last_id) {
        $year = date("y");
        $tempCnt = str_pad($last_id, 5, '0', STR_PAD_LEFT);
        $vn = 'TCN' . $year . $tempCnt;
        return $vn;
    }

    public function addFileComplaint($aParam){

        $result = [];

        $sql = "
            INSERT 
                `icms_temporary_case` 
            SET 
                `temporary_complainant_firstname` = '" . $aParam['temporary_complainant_firstname'] . "', 
                `temporary_complainant_middlename` = '" . $aParam['temporary_complainant_middlename'] . "', 
                `temporary_complainant_lastname` = '" . $aParam['temporary_complainant_lastname'] . "', 
                `temporary_complainant_mobile_number` = '" . $aParam['temporary_complainant_mobile_number'] . "', 
                `temporary_complainant_email_address` = '" . $aParam['temporary_complainant_email_address'] . "', 
                `temporary_complainant_relation` = '" . $aParam['temporary_complainant_relation'] . "', 
                `temporary_complainant_preffered_contact_method` = '" . $aParam['temporary_complainant_preffered_contact_method'] . "', 
                `temporary_complainant_complain` = '" . $aParam['temporary_complainant_complain'] . "',

                `temporary_complainant_is_victim` = '" . $aParam['is_victim'] . "', 
                `temporary_victim_firstname` = '" . $aParam['temporary_victim_firstname'] . "', 
                `temporary_victim_middlename` = '" . $aParam['temporary_victim_middlename'] . "', 
                `temporary_victim_lastname` = '" . $aParam['temporary_victim_lastname'] . "', 
                `temporary_victim_dob` = '".$aParam['temporary_victim_dob']."', 
                `temporary_victim_email_address` = '" . $aParam['temporary_victim_email_address'] . "', 
                `temporary_victim_mobile_number` = '" . $aParam['temporary_victim_mobile_number'] . "', 
                `temporary_victim_country_deployment` = '" . $aParam['temporary_victim_country_deployment'] . "', 
                `temporary_victim_civil_status` = '" . $aParam['temporary_victim_civil_status'] . "', 
                `temporary_victim_departure_type` = '" . $aParam['temporary_victim_departure_type'] . "', 
                `temporary_victim_sex` = '" . $aParam['temporary_victim_sex'] . "', 
                `temporary_victim_address` = '" . $aParam['temporary_victim_address'] . "',
                `temporary_case_date_added` = now(), 
                `temporary_case_status_id` = '1'
            ";
            
        $result[0] = $this->yel->exec($sql);

        $aParam['temporary_case_number'] = $this->generateTempCaseNumber($result[0]['insert_id']);

        // update data
        $sql2 = "
            UPDATE  
                `icms_temporary_case` 
            SET 
                `temporary_case_number`='" . $aParam['temporary_case_number'] . "'
            WHERE 
                `temporary_case_id` = '" . $result[0]['insert_id'] . "' 
        ";

        $result[1] = $this->yel->exec($sql2);
        $result[1]['temporary_case_number'] = $this->yel->encrypt_param($aParam['temporary_case_number']);
        return $result;
    }

    public function addTempCaseLog($aParam){

        $result = [];

        $sql = "
            INSERT INTO 
                `icms_temporary_case_access_logs` 
            SET 
                `temporary_case_id` = '" . $aParam['temporary_case_id'] . "', 
                `temporary_case_access_log_description` = '" . $aParam['temporary_case_access_log_description'] . "', 
                `temporary_case_access_log_date_added` = now() 
        ";

        $result = $this->yel->exec($sql);
        return $result;
    }

    public function getTempCaseInfoByCaseTempNumber($aParam) {
        $result = [];

        $sql = "
            SELECT
                *
            FROM `icms_temporary_case`
            WHERE `temporary_case_number` = '" . $aParam['temporary_case_number'] . "'
        ";

        $result = $this->yel->GetRow($sql);
        return $result;

    }

    public function getCaseInfoByCaseNumber($aParam) {
        $result = [];

        $sql = "
            SELECT
                *
            FROM `icms_case`
            WHERE `case_number` = '" . $aParam['temporary_case_number'] . "'
        ";

        $result = $this->yel->GetRow($sql);
        return $result;

    }

    public function getCaseInfoByCaseID($aParam) {
        $result = [];

        $sql = "
            SELECT
                *
            FROM `icms_case`
            WHERE `case_id` = '" . $aParam . "'
        ";

        $result = $this->yel->GetRow($sql);
        return $result;

    }

    public function getTemporaryCaseDetailsByTempCaseID($param) {
        $result = [];

        $sql = "
            SELECT
                *
            FROM `icms_temporary_case`
            WHERE `temporary_case_id` = '" . $param['temporary_case_id'] . "'
        ";

        $result = $this->yel->GetRow($sql);

        return $result;

    }

    public function getTemporaryCaseDetailsByCaseID($param) {
        $result = [];

        $sql = "
            SELECT
                *
            FROM `icms_temporary_case`
            WHERE `case_id` = '" . $param['case_id'] . "'
        ";

        $result = $this->yel->GetRow($sql);

        return $result;

    }

    public function getTempCaseAccessLogs($param) {
        $result = [];

        $sql = "
            SELECT 
             `itcal`.`temporary_case_access_log_date_added` as `date_added` 
            FROM
            `icms_temporary_case_access_logs` `itcal` 
            WHERE
            `itcal`.`temporary_case_id`= '" . $param['temporary_case_id'] . "'
            ORDER BY `temporary_case_access_log_id` DESC LIMIT 1
            ";

        $result = $this->yel->GetRow($sql);
        return $result;

    }

    public function getTempCaseAccessLogsByCaseID($param) {
        $result = [];

        $sql = "
            SELECT 
             `itcal`.`temporary_case_access_log_date_added` as `date_added` 
            FROM
            `icms_temporary_case_access_logs` `itcal` 
            WHERE
            `itcal`.`temporary_case_id`= '" . $param . "'
            ORDER BY `temporary_case_access_log_id` DESC LIMIT 1
            ";

        $result = $this->yel->GetRow($sql);
        return $result;

    }

    public function getLatestOtpVerifiedCode($param) {
        $result = [];
    
        $sql = "
            SELECT
                *
            FROM `icms_temporary_case_otp`
            WHERE 
                `temporary_case_id` = '" . $param['temporary_case_id'] . "' AND
                `otp_status` = '1' AND
                `otp_code` = '" . $param['otp_v_code'] . "'
            ORDER BY `otp_id` DESC
            LIMIT 1
        ";
    
        $result = $this->yel->GetRow($sql);
        return $result;
    }
    

    //For testing fetching OTP from database 
    public function getOTPByTemporaryCaseId($temporaryCaseId) {
        // Assuming you have a database table named 'otp_table'
        $this->db->where('temporary_case_id', $temporaryCaseId);
        $this->db->order_by('otp_id', 'DESC'); // Order by otp_id in descending order
        $query = $this->db->get('icms_temporary_case_otp');
        
        // Check if a row with the given temporary case ID exists
        if ($query->num_rows() > 0) {
            // Return the first row (assuming unique OTPs for each temporary case ID)
            return $query->row_array();
        } else {
            // No OTP found for the given temporary case ID
            return false;
        }
    }


    public function getLastOtpRequestDetails($param) {
        $rs = [];
        $sql = "
                SELECT
                    `otp_code`,
                    `otp_last_update`,
                    `otp_status`,
                    `otp_try`,
                    (SELECT COUNT(1) FROM `icms_temporary_case_otp` WHERE `otp_portal`='" . $param['otp_portal'] . "'
                    AND `temporary_case_id`='" . $param['temp_case_info']['temporary_case_id'] . "'
                    AND `is_active`=1 LIMIT 1)as `resend_count`
                FROM `icms_temporary_case_otp`
                WHERE
                    `otp_portal`='" . $param['otp_portal'] . "'
                    AND `temporary_case_id`='" . $param['temp_case_info']['temporary_case_id'] . "'
                    AND `is_active`= 1
                ORDER BY `otp_last_update` DESC LIMIT 1
                ";

        $rs = $this->yel->GetRow($sql);
        return $rs;
    }

    public function saveOTP($param) {
        $sql = "
                INSERT INTO `icms_temporary_case_otp` SET
                `temporary_case_id`='" . $param['temporary_case_id'] . "',
                `otp_type`='" . $param['otp_type'] . "',
                `otp_portal`='" . $param['otp_portal'] . "',
                `otp_code`='" . $param['otp_code'] . "'
            ";

        $rs = $this->yel->exec($sql);

        return $rs;
    }

    public function submitOTP($param) {
        $rs = [];

        $sql = "SELECT `otp_id` FROM `icms_temporary_case_otp` WHERE `temporary_case_id`='" . $param['temporary_case_id'] . "' ORDER BY `otp_id` DESC LIMIT 1";
        $otp_id = $this->yel->GetOne($sql);

        $qry = "UPDATE `icms_temporary_case_otp` SET `otp_try` = `otp_try` + 1    WHERE `otp_id` = '" . $otp_id . "'";
        $this->yel->exec($qry);

        $seql = "SELECT `otp_try`,`otp_code` FROM `icms_temporary_case_otp` WHERE `temporary_case_id`='" . $param['temporary_case_id'] . "' ORDER BY `otp_id` DESC LIMIT 1";
       
        $rs = $this->yel->GetRow($seql);
        return $rs;
    }

    public function updateOTPStatusSuccess($param) {
        $rs = [];

        $qry = "UPDATE `icms_temporary_case_otp` SET `otp_status` = '1'  WHERE `temporary_case_id`='" . $param['temporary_case_id'] . "' ORDER BY `otp_id` DESC LIMIT 1";

        $rs = $this->yel->exec($qry);

        return $rs;
    }

    public function resetOTPSuspension($param) {
        $rs = [];
        $qry = "UPDATE `icms_temporary_case_otp` SET `is_active` = '0' WHERE `temporary_case_id`='" . $param['temporary_case_id'] . "'";
        $rs = $this->yel->exec($qry);
        return $rs;
    }

    public function getTempCaseId($param) {
        $rs = [];

        $sql = "SELECT `temporary_case_id` FROM `icms_temporary_case` WHERE `temporary_case_number` = '" . $param . "'";

        $rs = $this->yel->GetOne($sql);
        
        return $rs;
    }

    public function getCaseId($param) {
        $rs = [];

        $sql = "SELECT `case_id` FROM `icms_case` WHERE `case_number` = '" . $param . "'";

        $rs = $this->yel->GetOne($sql);
        
        return $rs;
    }

    public function getVictimIDByCaseID($param) {
        $rs = [];

        $sql = "SELECT `victim_id`, `case_victim_id` FROM `icms_case_victim` WHERE `case_id` = '" . $param . "' AND `case_victim_is_active` = '1'";

        $rs = $this->yel->GetRow($sql);
        
        return $rs;
    }

    public function getVictimInfoByVictimID($param) {
        $rs = [];

        $sql = "SELECT * FROM `icms_victim_info` WHERE `victim_id` = '" . $param . "' AND `victim_info_is_assumed` = '0' AND `victim_info_is_active` = '1'";

        $rs = $this->yel->GetRow($sql);
        
        return $rs;
    }

    public function getComplainantInfoByVictimID($param) {
        $rs = [];

        $sql = "SELECT * FROM `icms_case_complainant` WHERE `case_victim_id` = '" . $param . "' AND `case_complainant_is_active` = '1'";

        $rs = $this->yel->GetRow($sql);
        
        return $rs;
    }

    public function getServices($case_id) {

        $sql = "
            SELECT
                `cvs`.`case_victim_services_id`,
                `cvs`.`services_id`,
                (SELECT `service_name` FROM `icms_services` WHERE `services_id`=`cvs`.`services_id` LIMIT 1) as `service_name`,
                (SELECT `transaction_parameter_name` FROM `icms_transaction_parameter` `itp`,`icms_services` `is` WHERE `itp`.`transaction_parameter_type_id`='8' AND `itp`.`transaction_parameter_count_id`=`is`.`service_type_id` AND `is`.`services_id`=`cvs`.`services_id` LIMIT 1) as `service_duration`,
                `cvsat`.`case_victim_services_agency_tag_id`,
                `cvsat`.`case_victim_services_id`,
                `cvsat`.`agency_branch_id`,
                (
                    SELECT CONCAT(`ia`.`agency_name`, ' - ' , `iab`.`agency_branch_name`)
                    FROM `icms_agency_branch` `iab`, `icms_agency` `ia` 
                    WHERE  `iab`.`agency_id` = `ia`.`agency_id`
                    AND `iab`.`agency_branch_id` = `cvsat`.`agency_branch_id`
                    LIMIT 1
                ) as agency_branch_name,
                `cvsat`.`case_victim_services_agency_tag_status`,
                (SELECT `transaction_parameter_name` FROM `icms_transaction_parameter` WHERE `transaction_parameter_type_id`='1' AND `transaction_parameter_count_id`=`cvsat`.`case_victim_services_agency_tag_status` LIMIT 1) as `service_status`,
                `cvsat`.`case_victim_services_agency_tag_added_by`,
                `cvsat`.`case_victim_services_agency_tag_added_date`, 
                `cvsat`.`case_victim_services_agency_tag_added_date` as temporary_case_remarks_date_added, 
                `cvsat`.`case_victim_services_agency_tag_date_modified`,
                `cvsat`.`case_victim_services_agency_tag_date_completed`, 
                `cvs`.`case_victim_services_id` as temporary_case_remarks_id, 
                
                'service' as log_type, 
                (SELECT 
                `is`.`service_category` 
                FROM `icms_services` `is`
                WHERE `is`.`services_id` = `cvs`.`services_id`
                LIMIT 1 ) as `service_category_type`
            FROM
                `icms_case_victim_services` `cvs`,
                `icms_case_victim_services_agency_tag` `cvsat`
            WHERE
                `cvs`.`case_victim_id` =  (SELECT
                                                `case_victim_id`
                                            FROM `icms_case_victim`
                                            WHERE `case_id` =  '" . $case_id . "'
                                            LIMIT 1)
            AND `cvs`.`case_victim_services_is_active` = 1
            AND `cvsat`.`case_victim_services_agency_tag_is_active` = 1
            AND `cvsat`.`case_victim_services_id`=`cvs`.`case_victim_services_id`
        ";
        // exit($sql);
        $result = $this->yel->GetAll($sql);

        return $result;
    }

    public function sessionToInactive($param) {
        $rs = [];
        $qry = "UPDATE `icms_temporary_case_otp` SET `session_status` = '0' WHERE `temporary_case_id`='" . $param['temporary_case_id'] . "' AND `otp_code` = '" . $param['otp_v_code'] . "'";
        $rs = $this->yel->exec($qry);
        return $rs;
    }

    public function getOTPByTemporaryCaseIdEmail($otpPortal) {
        // Assuming you have a database table named 'otp_table'
        $this->db->where('otp_portal', $otpPortal);
        $this->db->order_by('otp_id', 'DESC'); // Order by otp_id in descending order
        $query = $this->db->get('icms_temporary_case_otp');
        
        // Check if a row with the given OTP portal exists
        if ($query->num_rows() > 0) {
            // Return the first row (assuming unique OTPs for each OTP portal)
            return $query->row_array();
        } else {
            // No OTP found for the given OTP portal
            return false;
        }
    }

    public function getAllTemporaryCases() {
        // Assuming you have a database table named 'icms_temporary_case' and 'icms_temporary_case_otp'
        $this->db->select('icms_temporary_case.temporary_complainant_preffered_contact_method,icms_temporary_case.temporary_complainant_mobile_number ,icms_temporary_case.temporary_complainant_email_address, icms_temporary_case.temporary_case_number, icms_temporary_case.temporary_complainant_firstname, icms_temporary_case.temporary_complainant_lastname, icms_temporary_case_otp.otp_code, icms_temporary_case_otp.otp_id, icms_temporary_case_otp.temporary_case_id');
        $this->db->from('icms_temporary_case');
        $this->db->join('icms_temporary_case_otp', 'icms_temporary_case_otp.temporary_case_id = icms_temporary_case.temporary_case_id', 'left');
        $this->db->order_by('icms_temporary_case_otp.otp_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
    
        // Check if any rows exist in the table
        if ($query->num_rows() > 0) {
            // Return all rows from the table
            return $query->result_array();
        } else {
            // No data found in the table
            return false;
        }
    }
    
    

}
