<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class Global_data_model extends CI_Model {

    public function getAgencyTypes($aParam) {

        $aResponse = [];

        $sql = "
                SELECT 
                    * 
                FROM 
                    `icms_govt_agency_type`
                WHERE 
                    `is_active`=1
                ORDER BY
                    `govt_agency_type_name` ASC 
                ";

        $aResponse = $this->yel->GetAll($sql);  
        return $aResponse;
    }

    public function getAgencyTypesCategory($aParam) {

        $aResponse = [];

        $sql = "
                SELECT 
                    `parameter_name`,
                    `parameter_count_id`
                FROM 
                    `icms_global_parameter`
                WHERE 
                    `parameter_status`='1'
                AND `parameter_type_id`='12'
                ORDER BY
                    `parameter_name` ASC
                ";

        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getCountries($aParam) {

        $aResponse = [];

        $sql = "
                  SELECT 
                       `country_id`,`country_name`
                  FROM 
                        `icms_global_country` 
                  WHERE 
                        `is_active` = 1 
                  ORDER BY 
                        `country_name` ASC
               ";

        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getActiveOccupations() {
        $aResponse = [];
        $sql = "
                  SELECT 
                       `name`
                  FROM 
                        `icms_occupation` 
                  WHERE 
                        `is_active` = 1 
                  GROUP BY `name` 
                  ORDER BY `name` ASC
               ";

        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getRegions($aParam) {
        $aResponse = [];

        $sql = "
                    SELECT 
                        `location_count_id`,`location_name`
                    FROM 
                        `icms_global_location`
                    WHERE 
                        `location_is_active`='1'
                    AND `location_type_id`='3'
                    AND `location_prerequisite_id`='173'
                    ORDER BY `location_name` ASC
                ";

        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getStateByCountryID($aParam) {
        $aResponse = [];

        $sql = "
                    SELECT 
                         `location_count_id`,`location_name`
                    FROM 
                         `icms_global_location`
                    WHERE
                       `location_is_active`='1'
                    AND `location_type_id`='2'
                    AND `location_prerequisite_id`='" . $aParam['country_id'] . "'
                    ORDER BY `location_name` ASC
                ";

        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getProvinces($aParam) {
        $aResponse = [];
        $sql = "
                    SELECT 
                         `location_count_id`,`location_name`
                    FROM 
                         `icms_global_location`
                    WHERE
                       `location_is_active`='1' 
                    AND `location_type_id`='4' 
                    ORDER BY `location_name` ASC
                ";

        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getStatesByCountryID($aParam) {
        $aResponse = [];
        $sql = "
                    SELECT 
                         `location_count_id`,`location_name`
                    FROM 
                         `icms_global_location`
                    WHERE
                       `location_is_active`='1' 
                    AND `location_type_id`='2' 
                    AND `location_prerequisite_id`='" . $aParam['id'] . "'
                    ORDER BY `location_name` ASC
                ";

        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getProvinceByRegionID($aParam) {
        $aResponse = [];
        $sql = "
                    SELECT 
                         `location_count_id`,`location_name`
                    FROM 
                         `icms_global_location`
                    WHERE
                       `location_is_active`='1'
                    AND `location_type_id`='4'
                    AND `location_prerequisite_id`='" . $aParam['region_id'] . "'
                    ORDER BY `location_name` ASC
                ";

        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getCities($aParam) {
        $aResponse = [];
        $sql = "
                    SELECT 
                         `location_count_id`,`location_name`
                    FROM 
                         `icms_global_location`
                    WHERE
                       `location_is_active`='1' 
                    AND `location_type_id`='5' 
                    ORDER BY `location_name` ASC
                ";

        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getBarangay($aParam) {
        $aResponse = [];
        $sql = "
                    SELECT 
                         `location_count_id`,`location_name`
                    FROM 
                         `icms_global_location`
                    WHERE
                       `location_is_active`='1' 
                    AND `location_type_id`='6' 
                    ORDER BY `location_name` ASC
                ";

        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getCityByProvinceID($aParam) {
        $aResponse = [];

        $sql = "
                    SELECT 
                         `location_count_id`,`location_name`
                    FROM 
                         `icms_global_location`
                    WHERE
                       `location_is_active`='1'
                    AND `location_type_id`='5'
                    AND `location_prerequisite_id`='" . $aParam['province_id'] . "'
                    ORDER BY `location_name` ASC
                ";


        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getBrgyByCityID($aParam) {
        $aResponse = [];

        $sql = "
                    SELECT 
                         `location_count_id`,`location_name`
                    FROM 
                         `icms_global_location`
                    WHERE
                       `location_is_active`='1'
                    AND `location_type_id`='6'
                    AND `location_prerequisite_id`='" . $aParam['city_id'] . "'
                    ORDER BY `location_name` ASC
                ";

        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getSex() {


        $sql = " 
            SELECT 
                `parameter_count_id`, 
                `parameter_name`
            FROm 
                `icms_global_parameter`
            WHERE 
                `parameter_status` = '1' 
            AND `parameter_type_id`='9'
            ORDER BY `parameter_name` ASC
        ";

        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getGovtAgencyAndType() {
        $aResponse = [];

        $sql = " 
            SELECT 
                `iga`.*,
                `igat`.*,

            FROm 
                `icms_govt_agency` as `iga`, 
                `icms_govt_agency_type` as `igat`
            WHERE 
                `iga`.`is_active` = '1' AND 
                `igat`.`govt_agency_type_id` = `iga`.`govt_agency_type_id` AND
                `igat`.`is_active` = '1'
        ";

        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getAgencyBranchByAgencyTypeID($aParam) {
        $sql = " 
                SELECT 
                    `agency_branch_id`,
                    `agency_branch_name`
                FROM 
                    `icms_agency_branch`
                WHERE 
                    `agency_branch_is_active` = '1'
                AND `agency_id`='" . $aParam['agencytypeid'] . "'
                ORDER BY `agency_branch_name` ASC
        ";
        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getUserLevel() {
        $sql = " 
                SELECT 
                    * 
                FROM 
                    `icms_user_level`
                WHERE 
                    `is_active` = '1'
        ";

        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getUserRoles() {
        $sql = " 
                SELECT 
                    * 
                FROM 
                    `icms_user_role_type`
                WHERE 
                    `is_active` = '1'
        ";

        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getGlobalParameter($aParam) {
        $sql = "
                SELECT 
                    `parameter_count_id`, `parameter_name`  
                FROM 
                    `icms_global_parameter` 
                WHERE 
                    `parameter_type_id`='" . $aParam['type_id'] . "' 
                AND 
                    `parameter_status`='" . $aParam['status'] . "' 
                " . $aParam['order_by'] . "
                ";

        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getTransactionParameter($aParam) {
        $sql = "
                SELECT 
                `transaction_parameter_count_id`, `transaction_parameter_name`  
                FROM 
                `icms_transaction_parameter` 
                WHERE 
                `transaction_parameter_type_id`='" . $aParam['type_id'] . "' 
                AND 
                `transaction_parameter_status`='" . $aParam['status'] . "' 
                ORDER BY `transaction_parameter_name` ASC
                ";

        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getCaseTipDetails($aParam) {
        $sql = "
                SELECT 
                `tip_details_id`, `tip_details_count`, `tip_details_name`  
                FROM 
                `icms_tip_details` 
                WHERE 
                `tip_form_type_id`='" . $aParam['type_id'] . "' 
                AND 
                `tip_details_is_active`='" . $aParam['status'] . "' 
                ORDER BY `tip_details_name` ASC
                ";

        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getCountryISO($aParam) {
        $sql = "
                SELECT * FROM `icms_global_country`
                WHERE `is_active`='1'
              ";
        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getCurrencyISO($aParam) {
        $sql = "
                SELECT `country_id`,`currency_iso` FROM `icms_global_country`
                WHERE `is_active`='1'
                GROUP BY `currency_iso`
              ";
        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getNationality($aParam) {
        $sql = "
                SELECT `country_id`,`nationality`,`country_name` FROM `icms_global_country`
                WHERE `is_active`='1'
                ORDER BY `nationality` ASC
              ";
        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getEmploymentType($aParam) {
        $sql = "
              SELECT `parameter_count_id`,`parameter_name` FROM `icms_global_parameter` 
              WHERE `parameter_type_id` = '7' AND `parameter_status`='1'
              ORDER BY `parameter_name` ASC
              ";
        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getDepartureType($aParam) {
        $sql = "
             SELECT `parameter_count_id`,`parameter_name` FROM `icms_global_parameter` 
             WHERE `parameter_type_id` = '5' AND `parameter_status`='1'
             ORDER BY `parameter_name` ASC
              ";
        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getPortType($aParam) {
        $sql = "
             SELECT `parameter_count_id`,`parameter_name` FROM `icms_global_parameter` 
             WHERE `parameter_type_id` = '2' AND `parameter_status`='1'
             ORDER BY `parameter_name` ASC
              ";
        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getVisaCategory($aParam) {
        $sql = "
             SELECT `parameter_count_id`,`parameter_name` FROM `icms_global_parameter` 
             WHERE `parameter_type_id` = '11' AND `parameter_status`='1'
              ORDER BY `parameter_name` ASC
              ";
        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getCivilStatus($aParam) {
        $sql = "
             SELECT `parameter_count_id`,`parameter_name` FROM `icms_global_parameter` 
             WHERE `parameter_type_id` = '3' AND `parameter_status`='1'
              ORDER BY `parameter_name` ASC
              ";
        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getGlobalComplainSource($aParam) {
        $sql = "
             SELECT `parameter_count_id`,`parameter_name` FROM `icms_global_parameter` 
             WHERE `parameter_type_id` = '13' AND `parameter_status`='1'
              ORDER BY `parameter_name` ASC
              ";
        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getTraficInPerson_Act() {
        $sql = "
             SELECT `tip_details_name`,`tip_details_count` FROM `icms_tip_details` 
             WHERE `tip_form_type_id` = '1' AND `tip_details_is_active`='1'
              ORDER BY `tip_details_name` ASC
              ";
        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getTraficInPerson_means() {
        $sql = "
                SELECT `tip_details_name`,`tip_details_count` FROM `icms_tip_details` 
                WHERE `tip_form_type_id` = '3' AND `tip_details_is_active`='1'
                 ORDER BY `tip_details_name` ASC
              ";
        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getTraficInPerson_purpose() {
        $sql = "
                SELECT `tip_details_name`,`tip_details_count` FROM `icms_tip_details` 
                WHERE `tip_form_type_id` = '2' AND `tip_details_is_active`='1'
                ORDER BY `tip_details_name` ASC
              ";
        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getAssessmentType() {
        $sql = "
                SELECT `transaction_parameter_count_id`,`transaction_parameter_name` FROM `icms_transaction_parameter` 
                WHERE `transaction_parameter_type_id` = '8' AND `transaction_parameter_status`='1'
                ORDER BY `transaction_parameter_count_id` ASC
              ";
        $aResponse = $this->yel->GetAll($sql);

        return $aResponse;
    }

    public function getServiceStatus() {
        $sql = "
                SELECT `transaction_parameter_count_id`,`transaction_parameter_name` FROM `icms_transaction_parameter` 
                WHERE `transaction_parameter_type_id` = '1' AND `transaction_parameter_status`='1'
                ORDER BY `transaction_parameter_count_id` ASC
              ";
        $aResponse = $this->yel->GetAll($sql);

        return $aResponse;
    }

    public function getServiceStatusNameById($id) {
        $sql = "
                SELECT 
                    `transaction_parameter_name`
                FROM `icms_transaction_parameter` 
                WHERE `transaction_parameter_type_id` = '1' AND `transaction_parameter_status`='1'
                AND `transaction_parameter_count_id` = " . $id . "
              ";
        $aResponse = $this->yel->GetOne($sql);
        return $aResponse;
    }

    public function getServicesByAssessmentID($aParam) {
        $sql = "
                SELECT `services_id`,`service_name`,`service_days` FROM `icms_services` 
                WHERE `service_type_id` = '" . $aParam['assmntID'] . "' AND `service_is_active`='1'
                ORDER BY `service_name` ASC 
              ";
        $aResponse = $this->yel->GetAll($sql);

        return $aResponse;
    }

    public function getAgenciesWhichOfferServices($aParam) {
        $sql = "
                SELECT 
                    `iaso`.`agency_branch_id`,
                    `iab`.`agency_branch_name`,
                    `ia`.`agency_abbr`,
                    `usr`.`user_id`                    
                FROM 
                    `icms_agency_services_offered` `iaso`,
                    `icms_agency_branch` `iab`,
                    `icms_agency` `ia`,
                    `icms_user` `usr`
                WHERE 
                    `iaso`.`services_id` = '" . $aParam['serviceID'] . "'
                AND `iaso`.`agency_services_offered_is_active`='1'
                AND `iab`.`agency_branch_id`=`iaso`.`agency_branch_id` AND `iab`.`agency_branch_is_active`='1'
                AND `ia`.`agency_id`=`iab`.`agency_id`
                AND `usr`.`agency_branch_id`=`iab`.`agency_branch_id` AND `usr`.`user_level_id`=1 AND `usr`.`user_is_active`=1
                GROUP BY   `iab`.`agency_branch_name`
                ORDER BY `iab`.`agency_branch_name` ASC
              ";
//        echo '<pre>';        echo $sql; exit();
        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getAgenciesWhichOfferServices_bak($aParam) {
        $sql = "
                SELECT 
                    `iaso`.`agency_branch_id`,
                    `iab`.`agency_branch_name`,
                    `ia`.`agency_abbr`
                    
                FROM 
                    `icms_agency_services_offered` `iaso`,
                    `icms_agency_branch` `iab`,
                    `icms_agency` `ia`
                WHERE 
                    `iaso`.`services_id` = '" . $aParam['serviceID'] . "'
                AND `iaso`.`agency_services_offered_is_active`='1'
                AND `iab`.`agency_branch_id`=`iaso`.`agency_branch_id` 
                AND `iab`.`agency_branch_is_active`='1'
                AND `ia`.`agency_id`=`iab`.`agency_id`
                ORDER BY `iab`.`agency_branch_name` ASC
              ";
        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getAllServices($aParam) {
        $sql = "
                SELECT 
                    `s`.`services_id` as `id`, 
                    CONCAT(                       
                        ( SELECT 
                            `t`.`transaction_parameter_name` 
                          FROM 
                            `icms_transaction_parameter` `t` 
                          WHERE 
                            `t`.`transaction_parameter_type_id` = '8'
                          AND `t`.`transaction_parameter_count_id` = `s`.`service_type_id`
                          LIMIT 1), 
                        ' - ',  `s`.`service_name`
                    ) as `document` 
                FROM `icms_services` `s`
                WHERE `s`.`service_is_active`='1'
                ORDER BY `document` ASC 
              ";
        $aResponse = $this->yel->GetAll($sql);

        return $aResponse;
    }

    public function getGeneralDocuments($aParam) {
        $sql = "
                SELECT `parameter_count_id` as `id`,`parameter_name` as `document` FROM `icms_global_parameter` 
                WHERE `parameter_status`='1' AND `parameter_type_id`='18'
                ORDER BY `parameter_name` ASC 
              ";
        $aResponse = $this->yel->GetAll($sql);

        return $aResponse;
    }

    public function getPhilippinePort($aParam) {
        $sql = "
                SELECT `port_id`, `port_name` 
                FROM `icms_global_ph_port` 
                WHERE `port_is_active`='1' 
                ORDER BY `port_name` ASC 
               ";

        $aResponse = $this->yel->getAll($sql);

        return $aResponse;
    }

    public function getServices() {
        $sql = "
                SELECT 
                    `s`.`services_id`, 
                    `s`.`service_name`, 
                    `s`.`service_type_id`,
                    (SELECT `transaction_parameter_name` FROM `icms_transaction_parameter` WHERE `transaction_parameter_type_id` = 8 AND `transaction_parameter_count_id` = `s`.`service_type_id` LIMIT 1 ) as `service_type_name`
                FROM 
                    `icms_services` `s`
                WHERE 
                    `service_is_active` = 1 
                ORDER BY `s`.`service_type_id` ASC
        ";
        $aResponse = $this->yel->getAll($sql);
        return $aResponse;
    }

    public function findInDataDictionary_conditional($aParam) {
        $sql = "
                SELECT 
                    `dictionary_name`,
                    `dictionary_description`,
                    MATCH (`dictionary_name`,`dictionary_description`) AGAINST ('+" . $aParam['keyword'] . "*' IN BOOLEAN MODE) as `relevance`
                FROM `icms_dictionary`
                WHERE 
                    MATCH (`dictionary_name`,`dictionary_description`) AGAINST ('+" . $aParam['keyword'] . "*' IN BOOLEAN MODE)
                AND `dictionary_is_active`='1'
                ORDER BY `relevance` DESC LIMIT 50 
               ";
        $aResponse = $this->yel->getAll($sql);

        return $aResponse;
    }

    public function findInDataDictionary() {
        $sql = "
                SELECT 
                    `dictionary_name`,
                    `dictionary_description`
                FROM `icms_dictionary`
                ORDER BY  `dictionary_name` ASC  LIMIT 50
               ";
        $aResponse = $this->yel->getAll($sql);
        return $aResponse;
    }

    public function getAllAgenciesByKeyword($aParam) {
        $sql = "
                SELECT
                    `a`.`agency_id`,
                    `a`.`agency_name`,
                    `a`.`agency_abbr`,
                    (SELECT `parameter_name` FROM `icms_global_parameter` WHERE `parameter_type_id` = '12' AND `parameter_count_id`=`a`.`agency_category_id`) as `category`
                FROM
                    `icms_agency` `a`
                WHERE
                  MATCH ( `a`.`agency_name`, `a`.`agency_abbr`) AGAINST ('+" . $aParam['keyword'] . "*' IN BOOLEAN MODE)
                AND  `a`.`agency_is_active`='1'
               ";
        $aResponse = $this->yel->getAll($sql);
        return $aResponse;
    }

    public function getAllAgenciesNoKeyword($aParam) {
        $sql = "
                SELECT
                    `a`.`agency_id`,
                    `a`.`agency_name`,
                    `a`.`agency_abbr`,
                    (SELECT `parameter_name` FROM `icms_global_parameter` WHERE `parameter_type_id` = '12' AND `parameter_count_id`=`a`.`agency_category_id`) as `category`
                FROM
                    `icms_agency` `a`
                WHERE `a`.`agency_is_active`='1'
                ORDER BY `a`.`agency_name`
               ";
        $aResponse = $this->yel->getAll($sql);
        return $aResponse;
    }

    public function getAgencyBranchesByAgencyID($agency_id) {
        $sql = "
                SELECT 
                    `agency_branch_id`,
                    `agency_branch_name`,
                    `agency_branch_email`,
                    `agency_branch_telephone_number`,
                    `agency_branch_mobile_number`,
                    `agency_branch_is_main`
                FROM 
                    `icms_agency_branch`
                WHERE   
                    `agency_id`='" . $agency_id . "' AND `agency_branch_is_active`='1'
               ";
        $aResponse = $this->yel->getAll($sql);
        return $aResponse;
    }

    public function getAllAgencyIDInBranchByKeyword($aParam) {
        $sql = "
                SELECT 
                    `ab`.`agency_id`,
                    `a`.`agency_name`,
                    `a`.`agency_abbr`,
                    (SELECT `parameter_name` FROM `icms_global_parameter` WHERE `parameter_type_id` = '12' AND `parameter_count_id`=`a`.`agency_category_id`) as `category`
                FROM 
                    `icms_agency_branch` `ab`,
                    `icms_agency` `a`
                WHERE   
                    MATCH (`agency_branch_name`) AGAINST ('+" . $aParam['keyword'] . "*' IN BOOLEAN MODE)
                AND `ab`.`agency_branch_is_active`='1' AND `a`.`agency_id`=`ab`.`agency_id`
                GROUP BY `ab`.`agency_id`
               
               ";
        $aResponse = $this->yel->getAll($sql);
        return $aResponse;
    }

    public function getAgencyBranchesByAgencyAndAgencyBranchID($agency_id, $aParam) {
        $sql = "
                SELECT 
                    `agency_branch_id`,
                    `agency_branch_name`,
                    `agency_branch_email`,
                    `agency_branch_telephone_number`,
                    `agency_branch_mobile_number`,
                    `agency_branch_is_main`
                FROM 
                    `icms_agency_branch`
                WHERE   
                     MATCH (`agency_branch_name`) AGAINST ('+" . $aParam['keyword'] . "*' IN BOOLEAN MODE) AND `agency_id`='" . $agency_id . "' AND `agency_branch_is_active`='1'
               ";

        $aResponse = $this->yel->getAll($sql);
        return $aResponse;
    }

    public function getBranchAddressByAgencyBranchID($agency_branch_id) {
        $sql = "
                SELECT 
                   `al`.`address_list_country`,
                   `al`.`address_list_region`,
                   `al`.`address_list_province`,
                   `al`.`address_list_city`,
                   `al`.`address_list_brgy`,
                   `al`.`address_list_address`,
                   (SELECT `country_name` FROM `icms_global_country` WHERE `country_id`=`al`.`address_list_country`) as country,
                   (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`al`.`address_list_region` AND `location_type_id`='3') as region,
                   (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`al`.`address_list_province` AND `location_type_id`='4') as province,
                   (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`al`.`address_list_province` AND `location_type_id`='2' AND `location_prerequisite_id`=`al`.`address_list_country`) as state,
                   (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`al`.`address_list_city` AND `location_type_id`='5') as city,
                   (SELECT `location_name` FROM `icms_global_location` WHERE `location_count_id`=`al`.`address_list_brgy` AND `location_type_id`='6') as brgy
               FROM 
                    `icms_address_list` `al`
                WHERE   
                    `al`.`address_list_address_type`='1' AND `al`.`address_list_origin_id`='" . $agency_branch_id . "'
               ";
        $aResponse = $this->yel->GetRow($sql);
        return $aResponse;
    }
    
    public function getBranchContactDetailsPrimary($agency_branch_id) {
        $sql = "
               SELECT
                    `agency_contact_firstname`,
                    `agency_contact_middle_name`,
                    `agency_contact_lastname`,
                    `agency_contact_mobile_number`,
                    `agency_contact_telephone_number`,
                    `agency_contact_email`
                FROM
                    `icms_agency_contact`
                WHERE
                    `agency_branch_id`='" . $agency_branch_id . "' 
                AND
                    `agency_contact_is_primary` = '1' 
                LIMIT 1 
               ";
        $aResponse = $this->yel->GetRow($sql);
        return $aResponse;
    }
    
    
    public function getIssueStatus() {


        $sql = " 
            SELECT 
                `parameter_count_id`, 
                `parameter_name`
            FROm 
                `icms_global_parameter`
            WHERE 
                `parameter_status` = '1' 
            AND `parameter_type_id`='29'
            ORDER BY `parameter_name` ASC
        ";

        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }


    public function getJobs() {
        $sql = " 
            SELECT 
                `id`, 
                `name`
            FROm 
                `icms_occupation`
            WHERE 
                `is_active` = '1' 
            ORDER BY `name` ASC
        ";
        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }
    
    public function getAgenciesBranches() {
        $sql = " 
            SELECT 
                `iab`.`agency_branch_id`, 
                UPPER(CONCAT(
                    (SELECT `ia`.`agency_abbr` 
                     FROM `icms_agency` `ia` 
                     WHERE `ia`.`agency_id` = `iab`.`agency_id` AND `agency_is_active` = 1 
                     LIMIT 1), ' - ' , `iab`.`agency_branch_name`
                )) as `name`
            FROm 
                `icms_agency_branch` `iab`
            WHERE 
                `iab`.`agency_is_active` = '1' 
            ORDER BY `name` ASC
        ";
        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }
    
    public function getAssessmentServices() {
        $sql = " 
            SELECT 
                `is`.`services_id`, 
                UPPER(CONCAT(
                 (SELECT `itp`.`transaction_parameter_name` 
                 FROM `icms_transaction_parameter` `itp`
                 WHERE `itp`.`transaction_parameter_type_id` = 8 
                 AND `itp`.`transaction_parameter_count_id` = `is`.`service_type_id`
                 )
                  , ' - ', `is`.`service_name`
                )) as `name`, 
                (SELECT `itp`.`transaction_parameter_name` 
                 FROM `icms_transaction_parameter` `itp`
                 WHERE `itp`.`transaction_parameter_type_id` = 8 
                 AND `itp`.`transaction_parameter_count_id` = `is`.`service_type_id`
                 ) as `service_type_id`
            FROM 
            `icms_services` `is`
            ORDER BY `service_type_id` ASC
        ";
        $aResponse = $this->yel->GetAll($sql);
        return $aResponse;
    }

    public function getTemporaryCase($aParam) {

        $sql = "
                SELECT 
                    * 
                FROM 
                    `icms_temporary_case`
                WHERE 
                    `temporary_case_id`= ".$aParam['temporary_case_id']."
                LIMIT 1
                ";
                // exit($sql); 
        $aResponse = $this->yel->GetRow($sql);  
        return $aResponse;
    }

    public function getGlobalParamaterNameByTypeAndCountId($aParam){
        $sql = "
                SELECT 
                    `parameter_name`  
                FROM 
                    `icms_global_parameter` 
                WHERE 
                    `parameter_type_id`='" . $aParam['parameter_type_id'] . "' 
                AND 
                    `parameter_count_id`='" . $aParam['parameter_count_id'] . "' 
                ";

        $aResponse = $this->yel->GetOne($sql);
        return $aResponse;
    
    }

    public function getTransactionParamaterNameByTypeAndCountId($aParam){
        $sql = "
                SELECT 
                    `transaction_parameter_name`  
                FROM 
                    `icms_transaction_parameter` 
                WHERE 
                    `transaction_parameter_type_id`='" . $aParam['transaction_parameter_type_id'] . "' 
                AND 
                    `transaction_parameter_count_id`='" . $aParam['transaction_parameter_count_id'] . "' 
                ";

        $aResponse = $this->yel->GetOne($sql);
        return $aResponse;
    
    }

    // i add this code
    
    public function getGlobalDataVictimInformation($aParam) {
        $sql = "
                SELECT  
                   `iv`.`victim_id`,
                   `iv`.`victim_number`, 
                   (SELECT 
                        `parameter_count_id`
                     FROM 
                        `icms_global_parameter`
                     WHERE
                        `parameter_type_id` = 3 
                     AND `parameter_count_id` = `iv`.`victim_civil_status`
                     LIMIT 1
                     ) as `civil_status_name`, 
                   (SELECT 
                        `parameter_count_id`
                     FROM 
                        `icms_global_parameter`
                     WHERE
                        `parameter_type_id` = 9
                     AND `parameter_count_id` = `iv`.`victim_gender`
                     LIMIT 1                    
                    ) as `gender_name`, 
                    (SELECT 
                        `parameter_count_id`
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
    
}
