<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class Settings_model extends CI_Model {

    public function setOccupationNameInEmploymentDetails($aParam)
    {
        $aResponse = [];

        $sql = " 
            UPDATE 
                `icms_case_victim_employment_details`
            SET 
                `case_victim_employment_details_job_title` = '" . $aParam['name'] . "'
            WHERE
                UPPER(`case_victim_employment_details_job_title`) = '" . $aParam['prev_name'] . "'
        ";
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }


    public function getListOccupation() {
        $aResponse = [];
        $sql = " 
            SELECT * FROM `icms_occupation` 
            WHERE `is_active`  = '1'
            GROUP BY `name` 
            ORDER BY `icms_occupation`.`name` ASC
        ";
        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getOccupationNameById($aParam) {
        $sql = " 
            SELECT `name` FROM `icms_occupation` 
            WHERE `id`  = '".$aParam['paramer_count_id']."'
        ";
        return $this->yel->GetOne($sql);
    }
    //--------This is the Original Code for Fetching Global Parameters------
    // public function getListGlobalParamType() {
    //     $aResponse = [];

    //     $sql = " 
    //         SELECT 
    //             `global_parameter_type_id`, 
    //             `global_parameter_type_name`, 
    //             `global_parameter_description`
    //         FROM 
    //             `icms_global_parameter_type`
    //         WHERE 
    //             `global_parameter_type_is_show`  = '1'
    //         ORDER BY `global_parameter_type_name` ASC
    //     ";

    //     $aResponse = $this->yel->GetAll($sql);
    //     return $aResponse;
    // }


    /*--------- We add the a query to exclude the showing of preffered contact method: AND `global_parameter_type_id` != 30 */

                // 30 = Preferred Contact Method
    public function getListGlobalParamType() {
        $aResponse = [];
    
        $sql = " 
            SELECT 
                `global_parameter_type_id`, 
                `global_parameter_type_name`, 
                `global_parameter_description`
            FROM 
                `icms_global_parameter_type`
            WHERE 
                `global_parameter_type_is_show`  = '1'
                AND `global_parameter_type_id` != 30
            ORDER BY `global_parameter_type_name` ASC
        ";
    
        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getListTransactionParamType() {
        $aResponse = [];

        $sql = " 
            SELECT 
                `transaction_parameter_type_id`, 
                `transaction_parameter_type_name`, 
                `transaction_parameter_description`
            FROM 
                `icms_transaction_parameter_type`
            WHERE 
                `transaction_parameter_type_is_show`  = '1'
        ";

        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getListGlobalParameterByID($aParam) {
        $aResponse = [];

        $sql = " 
            SELECT 
                `parameter_id`, 
                `parameter_type_id`,
                `parameter_count_id`,
                `parameter_status`, 
                `parameter_name`
            FROM 
                `icms_global_parameter`
            WHERE 
                `parameter_type_id` = " . $aParam['parameter_type_id'] . "
           ORDER BY `parameter_name` ASC
        ";

        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getListGlobalParamTypeByID($aParam) {

        $aResponse = [];

        $sql = " 
            SELECT 
                `global_parameter_type_id`, 
                `global_parameter_type_name`,
                `global_parameter_description`
            FROM 
                `icms_global_parameter_type`
            WHERE
                `global_parameter_type_id` = " . $aParam['parameter_type_id'] . "
            ORDER BY `global_parameter_type_name` ASC
        ";

        $aResponse = $this->yel->GetRow($sql);
        return $aResponse;
    }

    public function getListTransactionParameterByID($aParam) {
        $aResponse = [];

        $sql = " 
            SELECT 
                `transaction_parameter_id`, 
                `transaction_parameter_type_id`,
                `transaction_parameter_count_id`,
                `transaction_parameter_status`, 
                `transaction_parameter_name`, 
                `transaction_parameter_description`
            FROM 
                `icms_transaction_parameter`
            WHERE 
                `transaction_parameter_type_id` = " . $aParam['transaction_parameter_type_id'] . "
                 " . $aParam['sCondition'] . "
            ORDER BY `transaction_parameter_name` ASC
        ";

        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getListTransactionParamTypeByID($aParam) {

        $aResponse = [];

        $sql = " 
            SELECT 
                `transaction_parameter_type_id`, 
                `transaction_parameter_type_name`,
                `transaction_parameter_description`
            FROM 
                `icms_transaction_parameter_type`
            WHERE
                `transaction_parameter_type_id` = " . $aParam['transaction_parameter_type_id'] . "
        ";

        $aResponse = $this->yel->GetRow($sql);
        return $aResponse;
    }

    public function setGlobalParameterTypebyId($aParam) {
        $aResponse = [];

        $sql = " 
            UPDATE `icms_global_parameter_type`
            SET 
                `global_parameter_type_name` = '" . $aParam['sTitle'] . "', 
                `global_parameter_description` = '" . $aParam['sDesc'] . "'
            WHERE
                `global_parameter_type_id` = " . $aParam['id'] . "
        ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function setTransactionParameterTypebyId($aParam) {
        $aResponse = [];

        $sql = " 
            UPDATE `icms_transaction_parameter_type`
            SET 
                `transaction_parameter_type_name` = '" . $aParam['sTitle'] . "', 
                `transaction_parameter_description` = '" . $aParam['sDesc'] . "'
            WHERE
                `transaction_parameter_type_id` = " . $aParam['id'] . "
        ";

        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function addGlobalParamaterData($aParam) {
        $aResponse = [];

        $sqlCount = " SELECT MAX(`parameter_count_id`)+1 FROM `icms_global_parameter` WHERE `parameter_type_id` = " . $aParam['id'] . "";
        $iCount = $this->yel->getOne($sqlCount);

        $sql = " 
            INSERT INTO `icms_global_parameter`
            (`parameter_type_id`,
            `parameter_count_id`,
            `parameter_name`, 
            `parameter_status`) 
            VALUES
            (" . $aParam['id'] . ", 
            " . $iCount . ", 
            '" . $aParam['name'] . "', 
            '" . $aParam['status'] . "'
            )
        ";
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }
    
    public function addOccupation($aParam) {
        $aResponse = [];

        $sql = " 
            INSERT INTO `icms_occupation`
            (`name`) 
            VALUES
            ('" . strtoupper($aParam['name']) . "')
        ";
        
        $aResponse = $this->yel->exec($sql);
        
        return $aResponse;
    }
    
    public function addTransasctionParamaterData($aParam) {
        $aResponse = [];

        $sqlCount = " SELECT MAX(`transaction_parameter_count_id`)+1 FROM `icms_transaction_parameter` WHERE `transaction_parameter_type_id` = " . $aParam['id'] . "";
        $iCount = $this->yel->getOne($sqlCount);

        $sql = " 
            INSERT INTO `icms_transaction_parameter`
            (`transaction_parameter_type_id`,
            `transaction_parameter_count_id`,
            `transaction_parameter_name`, 
            `transaction_parameter_status`) 
            VALUES
            (" . $aParam['id'] . ", 
            " . $iCount . ", 
            '" . $aParam['name'] . "', 
            '" . $aParam['status'] . "'
            )
        ";
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function setTransasctionParamaterStatus($aParam) {

        $aResponse = [];

        $sql = "
            UPDATE
                `icms_transaction_parameter`
            SET
                `transaction_parameter_status` = '" . $aParam['nStat'] . "'
            WHERE
                `transaction_parameter_type_id` = " . $aParam['parameter_type_id'] . " AND 
                `transaction_parameter_count_id` = " . $aParam['paramer_count_id'] . "    
        ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function setGlobalParamaterStatus($aParam) {

        $aResponse = [];

        $sql = "
            UPDATE
                `icms_global_parameter`
            SET
                `parameter_status` = '" . $aParam['nStat'] . "'
            WHERE
                `parameter_type_id` = " . $aParam['parameter_type_id'] . " AND 
                `parameter_count_id` = " . $aParam['paramer_count_id'] . "    
        ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }
    
    public function setOccupation($aParam) {
        
        $aResponse = [];

        $sql = "
            UPDATE
                `icms_occupation`
            SET
                `is_active` = '" . $aParam['status'] . "', 
                `name` = '" . $aParam['name'] . "'
            WHERE
                `id` = " . $aParam['paramer_count_id'] . " 
        ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }
    
    public function setGlobalParamaterData($aParam) {

        $aResponse = [];

        $sql = "
            UPDATE
                `icms_global_parameter`
            SET
                `parameter_status` = '" . $aParam['status'] . "', 
                `parameter_name` = '" . $aParam['name'] . "'
            WHERE
                `parameter_type_id` = " . $aParam['parameter_type_id'] . " AND 
                `parameter_count_id` = " . $aParam['paramer_count_id'] . "    
        ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function setTransasctionParamaterData($aParam) {

        $aResponse = [];

        $sql = "
            UPDATE
                `icms_transaction_parameter`
            SET
                `transaction_parameter_status` = '" . $aParam['status'] . "', 
                `transaction_parameter_name` = '" . $aParam['name'] . "'
            WHERE
                `transaction_parameter_type_id` = " . $aParam['parameter_type_id'] . " AND 
                `transaction_parameter_count_id` = " . $aParam['paramer_count_id'] . "    
        ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function getPhPort($aParam) {

        $aResponse = [];

        $sql = "
            SELECT `gpp`.*, `gp`.`parameter_name`,
                (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`gpp`.`province_id` AND `location_type_id`='4') as province,
                (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`gpp`.`city_id` AND `location_type_id`='5') as city
                " . $aParam['sRelevance'] . "
            FROM 
                `icms_global_ph_port` `gpp`, `icms_global_parameter` `gp`                
            WHERE 
                `gp`.`parameter_type_id` = 2
            AND
                `gpp`.`port_type` = `gp`.`parameter_count_id` 
            " . $aParam['cRelevance'] . "
            ORDER BY `parameter_name` ASC
            LIMIT  " . $aParam['start'] . "," . $aParam['limit'] . " 
        ";

        $aResponse['list'] = $this->yel->GetAll($sql);

        $sCount = "
                SELECT
                    COUNT(1)
                FROM
                    `icms_global_ph_port` `gpp`, `icms_global_parameter` `gp` 
                WHERE 
                    `gp`.`parameter_type_id` = 2
                AND
                    `gpp`.`port_type` = `gp`.`parameter_count_id` 
                " . $aParam['cRelevance'] . "                
               ";
        $aResponse['count'] = $this->yel->GetOne($sCount);

        return $aResponse;
    }

    public function addPort($aParam) {

        $aResponse = [];

        $sql = " 
                    INSERT INTO `icms_global_ph_port`
                    (`port_name`,
                    `province_id`,
                    `city_id`,
                    `port_type`, 
                    `port_is_active`) 
                    VALUES
                    ('" . $aParam['port_name'] . "', 
                    '" . $aParam['port_province'] . "',
                    '" . $aParam['port_city'] . "', 
                    '" . $aParam['global_port_type'] . "',
                    '" . $aParam['global_port_status'] . "'
                    )
                ";
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function setPort($aParam) {

        $aResponse = [];

        $sql = "
            UPDATE
                `icms_global_ph_port`
            SET
                `port_name` = '" . $aParam['port_name'] . "', 
                `province_id` = " . $aParam['province_id'] . ", 
                `city_id` = " . $aParam['city_id'] . ", 
                `port_type` = '" . $aParam['global_port_type'] . "',
                `port_is_active` = '" . $aParam['global_port_status'] . "'
            WHERE
                `port_id` = " . $aParam['port_id'] . "     
        ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function getDataDictionary($aParam) {

        $aResponse = [];

        $sqlList = "
            SELECT
                    *
                " . $aParam['sRelevance'] . "
            FROM
                `icms_dictionary` 
            " . $aParam['cRelevance'] . "
            ORDER BY `dictionary_name` ASC
            LIMIT  " . $aParam['start'] . "," . $aParam['limit'] . "             
        ";
        $aResponse['list'] = $this->yel->GetAll($sqlList);

        $sqlCount = "
                SELECT 
                    COUNT(1)
                FROM
                    `icms_dictionary`  
                " . $aParam['cRelevance'] . "
        ";
        $aResponse['count'] = $this->yel->GetOne($sqlCount);

        return $aResponse;
    }

    public function addDictionary($aParam) {

        $aResponse = [];

        $sql = " 
                    INSERT INTO `icms_dictionary`
                    (`dictionary_name`,
                    `dictionary_description`,
                    `dictionary_is_active`) 
                    
                    VALUES
                    ('" . $aParam['term'] . "', 
                    '" . $aParam['term_description'] . "', 
                    '" . $aParam['term_status'] . "')

                ";
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function setDictionary($aParam) {

        $aResponse = [];

        $sql = "
            UPDATE
                `icms_dictionary`
            SET
                `dictionary_name` = '" . $aParam['term'] . "', 
                `dictionary_description` = '" . $aParam['term_description'] . "',
                `dictionary_is_active` = '" . $aParam['term_status'] . "'
            WHERE
                `dictionary_id` = " . $aParam['dictionary_id'] . "     
        ";

        $aResponse = $this->yel->exec($sql);

        return $aResponse;
    }

    public function getListTIPCategory() {
        $aResponse = [];
        $sql = " 
            SELECT 
                * 
            FROM 
                `icms_transaction_parameter` 
            WHERE 
                `transaction_parameter_type_id` = 4 
            AND `transaction_parameter_status` = '1'
            ORDER BY `transaction_parameter_name` ASC
        ";
        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getListTIPCategoryByID($aParam) {
        $aResponse = [];
        $sql = " 
            SELECT 
                `tip_details_id`, 
                `tip_details_count`, 
                `tip_details_name`, 
                `tip_details_is_active`
            FROM 
                `icms_tip_details` 
            WHERE 
                `tip_form_type_id` = '" . $aParam['id'] . "'
            " . $aParam['cRelevance'] . "  
            ORDER BY `tip_details_name` ASC
            LIMIT  " . $aParam['start'] . "," . $aParam['limit'] . " 
        ";

        $aResponse['list'] = $this->yel->GetAll($sql);

        $sCount = "
                SELECT
                    COUNT(1)
                FROM
                    `icms_tip_details` 
                WHERE 
                    `tip_form_type_id` = '" . $aParam['id'] . "'
                " . $aParam['cRelevance'] . "                
               ";

        $aResponse['count'] = $this->yel->GetOne($sCount);

        return $aResponse;
    }

    public function getListServicesTypeById($aParam) {
        $aResponse = [];
        $sql = " 
            SELECT 
                `services_id`, 
                `service_type_id`, 
                `service_category`,
                `service_days`,
                 (SELECT `transaction_parameter_name` FROM `icms_transaction_parameter` WHERE `transaction_parameter_type_id` = 8 AND `transaction_parameter_count_id` = `service_type_id` LIMIT 1)   as `service_type_name`,
                `service_name`, 
                `service_description`,
                `service_is_active`
            FROM 
                `icms_services` 
            WHERE 
                `service_category` = '" . $aParam['id'] . "'
            " . $aParam['cRelevance'] . "  
            ORDER BY `service_name` ASC
            LIMIT  " . $aParam['start'] . "," . $aParam['limit'] . " 
        ";

        $aResponse['list'] = $this->yel->GetAll($sql);

        $sCount = "
                SELECT
                    COUNT(1)
                FROM
                    `icms_services` 
                WHERE 
                    `service_category` = '" . $aParam['id'] . "'
                " . $aParam['cRelevance'] . "                
               ";

        $aResponse['count'] = $this->yel->GetOne($sCount);

        return $aResponse;
    }

    public function addTIPDetails($aParam) {
        $aResponse = [];

        $sqlCount = " SELECT MAX(`tip_details_count`)+1 FROM `icms_tip_details` WHERE `tip_form_type_id` = " . $aParam['tip_form_type_id'] . "";
        $iCount = $this->yel->getOne($sqlCount);

        $sql = " 
            INSERT INTO `icms_tip_details`
            (`tip_form_type_id`,
            `tip_details_count`,
            `tip_details_name`, 
            `tip_details_is_active`) 
            VALUES
            (" . $aParam['tip_form_type_id'] . ", 
            " . $iCount . ", 
            '" . $aParam['tip_details_name'] . "', 
            '" . $aParam['tip_details_is_active'] . "'
            )
        ";
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function setTIPDetailsPerCategoryId($aParam) {
        $sql = "             
            UPDATE
                 `icms_tip_details`
             SET
                 `tip_details_name` = '" . $aParam['tip_details_name'] . "', 
                 `tip_details_is_active` = '" . $aParam['tip_details_is_active'] . "'
             WHERE
                 `tip_details_id` = " . $aParam['tip_details_id'] . " 
        ";
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function addService($aParam) {
        $sql = "
                INSERT INTO 
                    `icms_services`
                SET 
                    `service_type_id` ='" . $aParam['service_type_id'] . "',
                    `service_category` ='" . $aParam['service_category'] . "',
                    `service_days` ='" . $aParam['service_days'] . "',
                    `service_name` ='" . $aParam['service_name'] . "',
                    `service_description` = '1',
                    `service_is_active` ='" . $aParam['service_is_active'] . "'
                ";
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

    public function setServiceById($aParam) {
        $sql = "
                UPDATE  
                    `icms_services`
                SET 
                    `service_type_id` ='" . $aParam['service_type_id'] . "',
                    `service_category` ='" . $aParam['service_category'] . "',
                    `service_days` ='" . $aParam['service_days'] . "',
                    `service_name` ='" . $aParam['service_name'] . "',
                    `service_is_active` ='" . $aParam['service_is_active'] . "'
                WHERE 
                    `services_id` = " . $aParam['services_id'] . "
                ";
        $aResponse = $this->yel->exec($sql);
        return $aResponse;
    }

}
