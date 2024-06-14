<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class Case_details_model extends CI_Model {

    public function getComplainantDetailsByCaseId($aParam) {
        $sql = "
                SELECT 
                    `cv`.`victim_id`,
                    `cc`.`case_complainant_id`,
                    `cc`.`case_complainant_name`,
                    `cc`.`case_complainant_source_id`,
                    (SELECT `transaction_parameter_name` FROM `icms_transaction_parameter` WHERE `transaction_parameter_type_id` = '9' AND `transaction_parameter_count_id`=`cc`.`case_complainant_source_id` LIMIT 1) as `complainant_source`,
                    `cc`.`case_complainant_contact_number`,
                    `cc`.`case_complainant_alternate_contact_number`,
                    `cc`.`case_complainant_relation`,
                    (SELECT `parameter_name` FROM `icms_global_parameter` WHERE `parameter_type_id` = '8' AND `parameter_count_id`=`cc`.`case_complainant_relation` LIMIT 1) as `complainant_relation`,
                    `cc`.`case_complainant_relation_other`,
                    `cc`.`case_complainant_address`,
                    `cc`.`case_complainant_place_of_incident`,
                    `cc`.`case_complainant_place_of_origin`,
                    `cc`.`case_complainant_place_of_destination`,
                    `cc`.`case_complainant_date_time_of_incident`,
                    `cc`.`case_complainant_other_possible_source`,
                    `cc`.`case_complainant_remarks`,
                    `cc`.`case_complainant_date_complained`
                FROM
                    `icms_case_victim` `cv`,
                    `icms_case_complainant` `cc`
                WHERE
                    `cv`.`case_id` = '" . $aParam['caseid'] . "'
                AND `cc`.`case_victim_id`= `cv`.`case_victim_id`
            ";
        $result = $this->yel->GetRow($sql);
        return $result;
    }

    public function getComplainantDetails($aParam) {
        $sql = "
            SELECT
                `cc`.`case_complainant_name`,
                `cc`.`case_complainant_contact_number`,
                `cc`.`case_complainant_alternate_contact_number`,
                (SELECT `transaction_parameter_name` FROM `icms_transaction_parameter` WHERE `transaction_parameter_type_id` = '9' AND `transaction_parameter_count_id`=`cc`.`case_complainant_source_id` LIMIT 1) as `complainant_source`,
                (SELECT `parameter_name` FROM `icms_global_parameter` WHERE `parameter_type_id` = '8' AND `parameter_count_id`=`cc`.`case_complainant_relation` LIMIT 1) as `complainant_relation`,
                `cc`.`case_complainant_relation_other` as `relation_desc`,
                `cc`.`case_complainant_address`,
                `cc`.`case_complainant_place_of_incident`,
                `cc`.`case_complainant_place_of_origin`,
                `cc`.`case_complainant_place_of_destination`,
                `cc`.`case_complainant_date_time_of_incident`,
                `cc`.`case_complainant_other_possible_source`,
                `cc`.`case_complainant_remarks`
            FROM
                `icms_case_complainant` `cc`
            WHERE
                `cc`.`case_complainant_id`='" . $aParam['complainantid'] . "'
            LIMIT 1
            ";

        $aResponse = $this->yel->GetRow($sql);
        return $aResponse;
    }

    public function setComplainantDetails($aParam) {
        $sql = "
            UPDATE 
                `icms_case_complainant`
            SET
                `case_complainant_source_id`='" . $aParam['complainsource'] . "',
                `case_complainant_name`= " .$this->yel->checkifStringExist($aParam['complainantname']) . ",  
                `case_complainant_contact_number`=" .$this->yel->checkifStringExist($aParam['contact']) . ",
                `case_complainant_alternate_contact_number`=" .$this->yel->checkifStringExist($aParam['alternatecontact']) . ",  
                `case_complainant_relation`= " .$this->yel->checkifStringExist($aParam['relation']) . ",  
                `case_complainant_relation_other`= " .$this->yel->checkifStringExist($aParam['relationother']) . ", 
                `case_complainant_address`= " .$this->yel->checkifStringExist($aParam['address']) . ",
                `case_complainant_place_of_incident`=" .$this->yel->checkifStringExist($aParam['placeofincident']) . ",
                `case_complainant_place_of_origin`=" .$this->yel->checkifStringExist($aParam['placeoforigin']) . ",
                `case_complainant_place_of_destination`=" .$this->yel->checkifStringExist($aParam['placeofdestination']) . ",
                `case_complainant_date_time_of_incident`=" .$this->yel->checkifStringExist($aParam['datetimeofincident']) . ",
                `case_complainant_other_possible_source`=" .$this->yel->checkifStringExist($aParam['othersourceinfo']) . ", 
                `case_complainant_date_complained`= " . $this->yel->checkDateIfExist($aParam['datecomplained']) . ",
                `case_complainant_modified_by`='" . $_SESSION['userData']['user_id'] . "'
            WHERE
                `case_complainant_id`='" . $aParam['complainantid'] . "'
            ";
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function addComplainantDetails($aParam) {
        $sql = "
            INSERT INTO 
                `icms_case_complainant`
            SET
                `case_victim_id`='" . $aParam['case_victim_id'] . "',
                `case_complainant_source_id`='" . $aParam['complainsource'] . "',
                `case_complainant_name`='" . $aParam['complainantname'] . "',
                `case_complainant_contact_number`='" . $aParam['contact'] . "',
                `case_complainant_alternate_contact_number`='" . $aParam['alternatecontact'] . "',
                `case_complainant_relation`='" . $aParam['relation'] . "',
                `case_complainant_relation_other`='" . $aParam['relationother'] . "',
                `case_complainant_address`='" . $aParam['address'] . "',
                `case_complainant_place_of_incident`='" . $aParam['placeofincident'] . "',
                `case_complainant_place_of_origin`='" . $aParam['placeoforigin'] . "',
                `case_complainant_place_of_destination`='" . $aParam['placeofdestination'] . "',
                `case_complainant_date_time_of_incident`='" . $aParam['datetimeofincident'] . "',
                `case_complainant_other_possible_source`='" . $aParam['othersourceinfo'] . "',
                `case_complainant_remarks`='" . $aParam['remarks'] . "',
                `case_complainant_added_by`='" . $_SESSION['userData']['user_id'] . "',
                `case_complainant_date_complained`='" . $aParam['datecomplained'] . "'
            ";
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function getCaseVictimsDetailsByCaseID($aParam) {
        $sql = "
                SELECT 
                    `case_victim_id`,
                    `case_id`,
                    `victim_id`,
                   (SELECT `case_facts` FROM `icms_case` WHERE `case_id` = '" . $aParam['caseid'] . "' LIMIT 1 ) as  `case_facts` 
                FROM
                    `icms_case_victim` 
                WHERE
                   `case_id` = '" . $aParam['caseid'] . "' LIMIT 1
            ";
        $result = $this->yel->GetRow($sql);
        return $result;
    }

    public function getActsMeansPurposeByCaseID($aParam, $type) {
        $sql = "
                SELECT 
                    `cv`.`case_victim_id`,
                    `cvt`.`case_victim_tip_type_content_id`
                FROM
                    `icms_case_victim`  `cv`,
                    `icms_case_victim_tip` `cvt`
                WHERE
                    `cv`.`case_id` = '" . $aParam['caseid'] . "'
                AND `cv`.`victim_id`='" . $aParam['victim_id'] . "'
                AND `cvt`.`case_victim_id`=`cv`.`case_victim_id`
                AND `cvt`.`case_victim_tip_type_id`='" . $type . "'
                AND `cvt`.`case_victim_tip_is_active`='1'
            ";

        $result = $this->yel->GetAll($sql);
        return $result;
    }

    public function setBriefFactOfTheCase($aParam) {
        $sql = "
                UPDATE 
                    `icms_case`
                SET
                    `case_facts`='" . $aParam['remarks'] . "'
                WHERE
                    `case_id` = '" . $aParam['caseid'] . "'
            ";
        $result = $this->yel->exec($sql);
        return $result;
    }

    public function getBriefFactOfTheCase($aParam) {
        $sql = "
                SELECT 
                    `case_facts`
                FROM
                    `icms_case_victim`
                WHERE
                    `case_victim_id` = '" . $aParam['casevictimid'] . "'
            ";
        $result = $this->yel->GetOne($sql);
        return $result;
    }

    public function setActMeansPurposeInactive($aParam) {
        $sql = "
                UPDATE 
                    `icms_case_victim_tip`
                SET
                    `case_victim_tip_is_active`='0'
                WHERE
                    `case_victim_id` = '" . $aParam['casevictimid'] . "'
            ";
        $result = $this->yel->exec($sql);
        return $result;
    }

    public function checkTIPIfExist($aParam, $type) {
        $sql = "
                SELECT  
                    COUNT(1)
               FROM
                    `icms_case_victim_tip`
               WHERE
                    `case_victim_id` = '" . $aParam['casevictimid'] . "'
               AND  `case_victim_tip_type_id`='" . $type . "'
               AND  `case_victim_tip_type_content_id`='" . $aParam['tip_id'] . "'
                   
            ";
        $result = $this->yel->GetOne($sql);
        return $result;
    }

    public function getActsForLogs($aParam, $type) {
        $sql = "
               SELECT  
                    `td`.`tip_details_name`
               FROM
                    `icms_case_victim_tip` `cvt`,
                    `icms_tip_details` `td`
               WHERE
                    `cvt`.`case_victim_id`='" . $aParam['casevictimid'] . "'
               AND  `cvt`.`case_victim_tip_type_id`='" . $type . "'
               AND  `td`.`tip_details_count`=`cvt`.`case_victim_tip_type_content_id`
               AND  `td`.`tip_form_type_id`='" . $type . "'
               AND  `cvt`.`case_victim_tip_is_active`='1'
               ORDER BY `td`.`tip_details_name` ASC
            ";
        $result = $this->yel->GetAll($sql);
        return $result;
    }

    public function updateTIPtoActive($aParam, $type) {
        $sql = "
                UPDATE 
                    `icms_case_victim_tip` 
                SET  
                    `case_victim_tip_is_active`='1' 
                WHERE  
                    `case_victim_id` = '" . $aParam['casevictimid'] . "'
                AND  `case_victim_tip_type_id`='" . $type . "'
                AND  `case_victim_tip_type_content_id`='" . $aParam['tip_id'] . "'
            ";
        $this->yel->exec($sql);

        $qry = "SELECT 
                `case_victim_tip_id` 
              FROM 
                `icms_case_victim_tip`
              WHERE  
                    `case_victim_id` = '" . $aParam['casevictimid'] . "'
                AND  `case_victim_tip_type_id`='" . $type . "'
                AND  `case_victim_tip_type_content_id`='" . $aParam['tip_id'] . "'
            ";
        $result = $this->yel->GetOne($qry);
        return $result;
    }

    public function addNewVictimTIP($aParam, $type) {
        $sql = "
               INSERT INTO
                    `icms_case_victim_tip`
               SET 
                    `case_victim_tip_is_active`='1',
                    `case_victim_id` = '" . $aParam['casevictimid'] . "',
                    `case_victim_tip_type_id`='" . $type . "',
                    `case_victim_tip_type_content_id`='" . $aParam['tip_id'] . "',
                    `case_victim_tip_type_added_by`='" . $_SESSION['userData']['user_id'] . "'
            ";
        $result = $this->yel->exec($sql);
        return $result;
    }

    public function getCaseEvaluation($aParam) {
        $sql = "
                SELECT
                    `case_evaluation`,
                    `case_risk_assessment`, 
                    `case_is_illegal_rec`, 
                    `case_is_other_law`, 
                    `case_is_other_law_desc`, 
                    `case_priority_level_id`
                FROM
                    `icms_case`
                WHERE
                    `case_id` = '" . $aParam['caseid'] . "'
            ";

        $result = $this->yel->GetRow($sql);
        return $result;
    }

    public function setCaseEvaluation($aParam) {
        $sql = "
                Update
                    `icms_case`
                SET
                    `case_evaluation`='" . $aParam['evaluation'] . "',
                    `case_risk_assessment`='" . $aParam['risk_assessment'] . "'
                WHERE
                    `case_id` = '" . $aParam['caseid'] . "'";
        $result = $this->yel->exec($sql);
        return $result;
    }

    public function setCaseOtherDetails($aParam) {
        $sql = "
                Update
                    `icms_case`
                SET
                    `case_is_illegal_rec`='" . $aParam['is_illegal_rec'] . "',
                    `case_is_other_law`='" . $aParam['is_other_law'] . "',
                    `case_is_other_law_desc`='" . $aParam['other_law_desc'] . "'
                WHERE
                    `case_id` = '" . $aParam['caseid'] . "'";
        $result = $this->yel->exec($sql);
        return $result;
    }

    public function getCaseAllegedOffender($aParam) {
        $sql = "
                SELECT
                    `co`.`case_offender_id`,
                    `co`.`case_offender_name`,
                    `co`.`case_offender_nationality`,
                    `co`.`case_offender_other`,
                    `co`.`case_offender_address`,
                    `co`.`case_offender_contact_details`,
                    `co`.`case_offender_remarks`,
                    `co`.`case_offender_type_id`, 
                    (SELECT `transaction_parameter_name` FROM `icms_transaction_parameter` WHERE `transaction_parameter_type_id` = '10' AND `transaction_parameter_count_id` = `co`.`case_offender_type_id`) as `offender_type`
                FROM
                    `icms_case_offender` `co`
                WHERE
                    `co`.`case_id` = '" . $aParam['caseid'] . "'
                AND `case_offender_is_active`='1'
            ";

        $result = $this->yel->GetAll($sql);

        return $result;
    }

    public function getCaseAllegedOffenderByOffenderID($aParam) {
        $sql = "
                SELECT
                   *
                FROM
                    `icms_case_offender` 
                WHERE
                 `case_offender_id` = '" . $aParam['id'] . "'
            ";
        $result = $this->yel->GetRow($sql);
        return $result;
    }

    public function addOffenderInfo($aParam) {
        $sql = "
                INSERT INTO
                    `icms_case_offender`
                SET
                    `case_id`='" . $aParam['caseid'] . "',
                    `case_offender_type_id`='" . $aParam['offender_type'] . "',
                    `case_offender_name`='" . $aParam['offender_name'] . "',
                    `case_offender_nationality`='" . $aParam['offender_nationality'] . "',
                    `case_offender_address`='" . $aParam['offender_address'] . "',
                    `case_offender_contact_details`= '" . $aParam['offender_contact'] . "',
                    `case_offender_other`= " . $this->yel->checkifStringExist($aParam['offender_relation']) . ",
                    `case_offender_remarks`='" . $aParam['offender_remarks'] . "'";
        $result = $this->yel->exec($sql);
        return $result;
    }

    public function setOffenderInfo($aParam) {
        $sql = "
                Update
                    `icms_case_offender`
                SET
                    `case_offender_type_id`='" . $aParam['offender_type'] . "',
                    `case_offender_name`='" . $aParam['offender_name'] . "',
                    `case_offender_nationality`='" . $aParam['offender_nationality'] . "',
                    `case_offender_address`='" . $aParam['offender_address'] . "',
                    `case_offender_contact_details`= '" . $aParam['offender_contact'] . "',
                    `case_offender_other`= " . $this->yel->checkifStringExist($aParam['offender_relation']) . ",
                    `case_offender_remarks`='" . $aParam['offender_remarks'] . "'
                WHERE
                    `case_offender_id` = '" . $aParam['offenderid'] . "'";
        $result = $this->yel->exec($sql);
        return $result;
    }

    public function removeOffender($aParam) {
        $sql = "
                Update
                    `icms_case_offender`
                SET
                    `case_offender_is_active`='0'
                WHERE
                    `case_offender_id` = '" . $aParam['offenderid'] . "'";
        $result = $this->yel->exec($sql);
        return $result;
    }

    public function removeDocument($aParam) {
        $sql = "
                Update
                    `icms_case_file_upload`
                SET
                    `case_file_upload_is_active`='0'
                WHERE
                    `case_file_upload_id` = '" . $aParam['docid'] . "'";
        $result = $this->yel->exec($sql);
        return $result;
    }

    public function getUploadedDocuments($aParam) {
        $sql = "
                SELECT 
                   `cfu`.`case_file_upload_id`,
                   `cfu`.`document_hash`,
                   `cfu`.`case_file_upload_category`,
                   `cfu`.`case_file_upload_date_added`,
                   (SELECT `parameter_name` FROM `icms_global_parameter` WHERE `parameter_type_id` = '17' AND `parameter_count_id`=`cfu`.`case_file_upload_category`) as `document_category`,
                   `cfu`.`case_file_upload_type`,
                   (CASE WHEN  `cfu`.`case_file_upload_category`='1' THEN
                    (SELECT `parameter_name` FROM `icms_global_parameter` WHERE `parameter_type_id`= '18' AND `parameter_count_id`= `cfu`.`case_file_upload_type` LIMIT 1)
                   ELSE
                    (SELECT `service_name` FROM `icms_services` WHERE `services_id`= `cfu`.`case_file_upload_type` LIMIT 1)
                   END
                    ) as `document_type`,
                   `cfu`.`case_file_upload_remarks`,
                   `id`.`documents_name`,
                   `id`.`documents_display_name`,
                   `id`.`documents_mime_type`,
                   `id`.`documents_size`
                FROM 
                    `icms_case_file_upload` `cfu`,
                    `icms_documents` `id`
                WHERE
                    `cfu`.`case_id` = '" . $aParam['caseid'] . "'
                AND `id`.`documents_hash`=`cfu`.`document_hash`
                AND `cfu`.`case_file_upload_is_active`='1'
            ";
        $result = $this->yel->GetAll($sql);
        return $result;
    }

    public function addNewDocument($aParam) {
        $__sql = "
                INSERT INTO
                    `icms_case_file_upload`
                SET
                    `case_id`='" . $aParam['caseid'] . "',
                    `document_hash`='" . $aParam['fileHash'] . "',
                    `case_file_upload_category`='" . $aParam['doc_category'] . "',
                    `case_file_upload_type`='" . $aParam['doc_type'] . "',
                    `case_file_upload_remarks`='" . $aParam['doc_remark'] . "',
                    `case_file_upload_added_by`='" . $_SESSION['userData']['user_id'] . "'";

        $sql = "
                INSERT INTO
                    `icms_case_file_upload`
                SET
                    `case_id`='" . $aParam['caseid'] . "',
                    `document_hash`='" . $aParam['fileHash'] . "',
                    `case_file_upload_remarks`='" . $aParam['doc_remark'] . "',
                    `case_file_upload_added_by`='" . $_SESSION['userData']['user_id'] . "'";

        $result = $this->yel->exec($sql);
        return $result;
    }

    public function updateDocument($aParam) {
        $sql = "
                 UPDATE
                    `icms_case_file_upload`
                SET
                    `document_hash`='" . $aParam['fileHash'] . "',
                    `case_file_upload_remarks`='" . $aParam['doc_remark'] . "',
                    `case_file_upload_added_by`='" . $_SESSION['userData']['user_id'] . "' 
                WHERE
                    `case_file_upload_id`='" . $aParam['document_id'] . "'
        ";

        $result = $this->yel->exec($sql);
        return $result;
    }

    public function getCaseNumberByCaseId($aParam) {
        $sql = "
                SELECT 
                    `case_number`
               FROM
                    `icms_case`
                WHERE
                    `case_id` = '" . $aParam['caseid'] . "'
                LIMIT 1";
        $result = $this->yel->GetOne($sql);
        return $result;
    }

    public function getOffernderNameByOffenderID($aParam) {
        $sql = "
                SELECT 
                    `case_offender_name`
               FROM
                    `icms_case_offender`
                WHERE
                    `case_offender_id` = '" . $aParam['offenderid'] . "'
                LIMIT 1";
        $result = $this->yel->GetOne($sql);
        return $result;
    }

    public function getOffenderInfo($aParam) {
        $sql = "
                SELECT 
                    `co`.`case_offender_name`,
                    (SELECT `transaction_parameter_name` FROM `icms_transaction_parameter` WHERE `transaction_parameter_type_id` = '10' AND `transaction_parameter_count_id`=`co`.`case_offender_type_id` LIMIT 1) as `ofender_type`,
                    (SELECT `nationality` FROM `icms_global_country` WHERE `country_id` = `co`.`case_offender_nationality` LIMIT 1) as `nationality`,
                    `co`.`case_offender_other`,
                    `co`.`case_offender_address`,
                    `co`.`case_offender_contact_details`,
                    `co`.`case_offender_remarks`
               FROM
                    `icms_case_offender` `co`
                WHERE
                    `case_offender_id` = '" . $aParam['offenderid'] . "'
                LIMIT 1";
        $result = $this->yel->GetRow($sql);
        return $result;
    }

    public function addNewCaseVictimPassport($aParam) {
        $sql = "
                INSERT INTO
                    `icms_victim_passport`
                SET
                    `case_victim_id`='" . $aParam['case_victim_id'] . "',
                    `victim_passport_number`='" . $aParam['passportnumber'] . "',
                    `victim_passport_last_name`='" . $aParam['lname'] . "',
                    `victim_passport_middle_name`='" . $aParam['mname'] . "',
                    `victim_passport_first_name`='" . $aParam['fname'] . "',
                    `victim_passport_suffix_name`='" . $aParam['suffix'] . "',
                    `victim_passport_dob`='" . $aParam['dob'] . "',
                    `victim_passport_province_pob`='" . $aParam['province'] . "',
                    `victim_passport_city_pob`='" . $aParam['city'] . "',
                    `victim_passport_gender`='" . $aParam['gender'] . "',
                    `victim_passport_civil_status`='" . $aParam['civil_status'] . "',
                    `victim_passport_date_issued`='" . $aParam['date_issued'] . "',
                    `victim_passport_date_expired`='" . $aParam['date_xp'] . "',
                    `victim_passport_place_issue`='" . $aParam['place_issued'] . "',
                    `victim_passport_added_by`='" . $_SESSION['userData']['user_id'] . "'
            ";
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function setCaseVictimPassport($aParam) {
        $sql = "
                UPDATE
                    `icms_victim_passport`
                SET
                    `case_victim_id`='" . $aParam['case_victim_id'] . "',
                    `victim_passport_number`='" . $aParam['passportnumber'] . "',
                    `victim_passport_last_name`='" . $aParam['lname'] . "',
                    `victim_passport_middle_name`='" . $aParam['mname'] . "',
                    `victim_passport_first_name`='" . $aParam['fname'] . "',
                    `victim_passport_suffix_name`='" . $aParam['suffix'] . "',
                    `victim_passport_dob`='" . $aParam['dob'] . "',
                    `victim_passport_province_pob`='" . $aParam['province'] . "',
                    `victim_passport_city_pob`='" . $aParam['city'] . "',
                    `victim_passport_gender`='" . $aParam['gender'] . "',
                    `victim_passport_civil_status`='" . $aParam['civil_status'] . "',
                    `victim_passport_date_issued`='" . $aParam['date_issued'] . "',
                    `victim_passport_date_expired`='" . $aParam['date_xp'] . "',
                    `victim_passport_place_issue`='" . $aParam['place_issued'] . "'
                WHERE
                    `victim_passport_id`='" . $aParam['passport_id'] . "'
            ";
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function getCaseVictimPassport($aParam) {
        $sql = "
                SELECT
                    `vp`.`victim_passport_number`,
                    `vp`.`victim_passport_last_name`,
                    `vp`.`victim_passport_middle_name`,
                    `vp`.`victim_passport_first_name`,
                    `vp`.`victim_passport_dob`,         
                    `vp`.`victim_passport_suffix_name`,      
                    (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`vp`.`victim_passport_province_pob` AND `location_type_id`='4') as province,
                    (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`vp`.`victim_passport_city_pob` AND `location_type_id`='5') as city,
                    (SELECT `parameter_name` FROM `icms_global_parameter` WHERE `parameter_type_id` = '9' AND `parameter_count_id`=`vp`.`victim_passport_gender`) as `sex`,
                    (SELECT `parameter_name` FROM `icms_global_parameter` WHERE `parameter_type_id` = '3' AND `parameter_count_id`=`vp`.`victim_passport_civil_status`) as `civil_status`,
                    `vp`.`victim_passport_date_issued`,
                    `vp`.`victim_passport_date_expired`,
                    `vp`.`victim_passport_place_issue`
                FROM
                    `icms_victim_passport` `vp`
                WHERE
                    `vp`.`victim_passport_id`='" . $aParam['passport_id'] . "'
            ";
        $aResponse = $this->yel->getRow($sql);
        return $aResponse;
    }

    public function getTransitList($aParam) {
        $sql = "
                SELECT 
                    `cvt`.*,
                    (SELECT `country_name` FROM `icms_global_country` WHERE `country_id`=`cvt`.`case_victim_transit_departure_country`) as country,
                    (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`cvt`.`case_victim_transit_departure_city` AND `location_type_id`='2' AND `location_prerequisite_id`=`cvt`.`case_victim_transit_departure_country`) as state
                FROM 
                    `icms_case_victim_transit` `cvt`
                WHERE 
                    `cvt`.`case_victim_id`='" . $aParam['case_victim_id'] . "'
                AND `cvt`.`case_victim_transit_is_active`='1'
            ";

        $aResponse = $this->yel->getAll($sql);
        return $aResponse;
    }

    public function getTransitDetailsByTransitID($aParam) {
        $sql = "
                SELECT 
                    `cvt`.`case_victim_transit_departure_date`,
                    `cvt`.`case_victim_transit_arrival_date`,
                    `cvt`.`case_victim_transit_remarks`,
                    (SELECT `country_name` FROM `icms_global_country` WHERE `country_id`=`cvt`.`case_victim_transit_departure_country`) as country,
                    (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`cvt`.`case_victim_transit_departure_city` AND `location_type_id`='2' AND `location_prerequisite_id`=`cvt`.`case_victim_transit_departure_country`) as state
                FROM 
                    `icms_case_victim_transit` `cvt`
                WHERE 
                    `case_victim_transit_id` = '" . $aParam['transid'] . "' 
            ";
        $aResponse = $this->yel->getRow($sql);
        return $aResponse;
    }

    public function addTransitDetails($aParam) {
        $sql = "
                INSERT INTO 
                    `icms_case_victim_transit`
                SET
                    `case_victim_id`='" . $aParam['case_victim_id'] . "',
                    `case_victim_transit_departure_country`='" . $aParam['country_id'] . "',
                    `case_victim_transit_departure_city`='" . $aParam['city'] . "',
                    `case_victim_transit_departure_date`= " . $this->yel->checkDateIfExist($aParam['depdate']) . ",
                    `case_victim_transit_arrival_date`= " . $this->yel->checkDateIfExist($aParam['arrdate']) . ",
                    `case_victim_transit_remarks`='" . $aParam['remark'] . "'
                ";
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function addServiceInformation($aParam) {
        $aResponse = [];
        $sql = "
                INSERT INTO 
                    `icms_case_victim_services`
                SET
                    `case_victim_id`='" . $aParam['case_victim_id'] . "',
                    `services_id`='" . $aParam['services_id'] . "',
                    `case_victim_services_remarks`='" . $aParam['remark'] . "',
                    `case_victim_services_aging_date`='" . $aParam['deliveryService'] . "'
                ";
        $aResponse['victim_service'] = $this->yel->exec($sql);


        $qry = "
                INSERT INTO 
                    `icms_case_victim_services_agency_tag`
                SET
                    `case_victim_services_id`='" . $aResponse['victim_service']['insert_id'] . "',
                    `agency_branch_id`='" . $aParam['agency_id'] . "',
                    `case_victim_services_agency_tag_remarks`='" . $aParam['remark'] . "',
                    `case_victim_services_agency_tag_added_by`='" . $_SESSION['userData']['user_id'] . "'
                ";
        $aResponse['tagged_agency'] = $this->yel->exec($qry);


        return $aResponse;
    }

    public function checkServiceInformation($aParam)
    {
        $sql = "
                SELECT 
                    COUNT(1)
                FROM 
                    `icms_case_victim_services`
                WHERE
                    `case_victim_id`='" . $aParam['case_victim_id'] . "'
                    AND `case_victim_services_is_active` = 1
                    AND `services_id`='" . $aParam['services_id'] . "' 
                    AND IN(3,4,7)
                ";
        return $this->yel->getOne($sql);
    }
}
