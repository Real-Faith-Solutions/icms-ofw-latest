<?php

/**
 * Reports Internal Ajax
 * 
 * @module Ajax Loader
 * @author LBS eBusiness Solutions Corp. 
 * @since 2017
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Global_data extends CI_Controller {

    const SUCCESS_RESPONSE = 1;
    const FAILED_RESPONSE = 0;

    public function __construct() {
        parent::__construct();

        // load models
        $this->load->model('Global_data_model');
        $this->load->model('notif_model');
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
        $this->sessionPushLogout('');
    }

    public function getPermission() {
//        $_SESSION['userData']['is_super_admin'] = 0;
        return $_SESSION['userData'];
    }

    public function getUserRoles() {
        $aResponse = $this->Global_data_model->getUserRoles();
        return $aResponse;
    }

    public function getAgencyTypes($aParam) {
        $aResponse = $this->Global_data_model->getAgencyTypes($aParam);
        return $aResponse;
    }

    public function getAgencyTypesCategory($aParam) {
        $aResponse = $this->Global_data_model->getAgencyTypesCategory($aParam);
        return $aResponse;
    }

    public function getCountries($aParam) {
        $aResponse = $this->Global_data_model->getCountries($aParam);
        return $aResponse;
    }

    public function getActiveOccupations($aParam) {
        $aResponse = $this->Global_data_model->getActiveOccupations($aParam);
        return $aResponse;
    }

    public function getRegions($aParam) {
        $aResponse = $this->Global_data_model->getRegions($aParam);
        return $aResponse;
    }

    public function getStateByCountryID($aParam) {
        $aResponse = $this->Global_data_model->getStateByCountryID($aParam);
        return $aResponse;
    }

    public function getProvinces($aParam) {
        $aResponse = $this->Global_data_model->getProvinces($aParam);
        return $aResponse;
    }

    public function getStatesByCountryID($aParam) {
        $aResponse = $this->Global_data_model->getStatesByCountryID($aParam);
        return $aResponse;
    }

    public function getProvinceByRegionID($aParam) {
        $aResponse = $this->Global_data_model->getProvinceByRegionID($aParam);
        return $aResponse;
    }

    public function getCities($aParam) {
        $aResponse = $this->Global_data_model->getCities($aParam);
        return $aResponse;
    }

    public function getBarangay($aParam) {
        $aResponse = $this->Global_data_model->getBarangay($aParam);
        return $aResponse;
    }

    public function getCityByProvinceID($aParam) {
        $aResponse = $this->Global_data_model->getCityByProvinceID($aParam);
        return $aResponse;
    }

    public function getBrgyByCityID($aParam) {
        $aResponse = $this->Global_data_model->getBrgyByCityID($aParam);
        return $aResponse;
    }

    public function getSex($aParam) {
        $aResponse = $this->Global_data_model->getSex($aParam);
        return $aResponse;
    }

    public function getJobs() {
        $aResponse = $this->Global_data_model->getJobs();
        return $aResponse;
    }
    
    public function getAgenciesBranches() {
        $aResponse = $this->Global_data_model->getAgenciesBranches();
        return $aResponse;
    }
    
    public function getAssessmentServices($param) {
         $aResponse = $this->Global_data_model->getAssessmentServices();
        return $aResponse;
    }

    public function getGovtAgencyAndType() {
        $aResponse = [];
        $aResponse = $this->Global_data_model->getGovtAgencyAndType();
        return $aResponse;
    }

    public function getUserLevel() {
        $aResponse = [];
        $aResponse = $this->Global_data_model->getUserLevel();
        return $aResponse;
    }

    public function getGlobalParameter($aParam) {
        $aResponse = [];

        $aParam = $this->getGlobalParameterTypeIdAndStatus($aParam);

        $aResponse = $this->Global_data_model->getGlobalParameter($aParam);

        return $aResponse;
    }

    public function getUnreadNotification() {
        $aResponse = [];
        $aResponse = $this->notif->getUnreadNotification();
        return $aResponse;
    }

    public function getAllNotifications($aParam) {
        $aResponse = [];
        $aResponse = $this->notif->getUserNotification($aParam);
        return $aResponse;
    }

    public function setNotificationAsRead($aParam) {
        $aResponse = [];
        $aResponse = $this->notif->setUserNotificationAsRead($aParam['id'], 1);
        return $aResponse;
    }

    private function getGlobalParameterTypeIdAndStatus($aParam) {

        $aParam['order_by'] = "ORDER BY  `parameter_name`  REGEXP   '%[^a-zA-Z0-9]%' ASC";

        switch ($aParam['parameter_type']) {
            case 'sex':
                $aParam['type_id'] = '9';
                $aParam['status'] = '1';
                break;
            case 'civil':
                $aParam['type_id'] = '3';
                $aParam['status'] = '1';
                break;
            case 'religion':
                $aParam['type_id'] = '4';
                $aParam['status'] = '1';
                break;
            case 'education':
                $aParam['type_id'] = '6';
                $aParam['status'] = '1';
                 $aParam['order_by'] = " ORDER BY  CAST(`parameter_description` as unsigned) DESC";
                break;
            case 'nextofkin':
                $aParam['type_id'] = '8';
                $aParam['status'] = '1';
                break;
        }

        return $aParam;
    }

    public function getTransactionParameter($aParam) {

        $aParam = $this->getTransactionParameterTypeIdAndStatus($aParam);
        $aResponse = [];
        $aResponse = $this->Global_data_model->getTransactionParameter($aParam);

        return $aResponse;
    }

    private function getTransactionParameterTypeIdAndStatus($aParam) {

        switch ($aParam['transaction_type']) {
            case 'contact':
                $aParam['type_id'] = '6';
                $aParam['status'] = '1';
                break;
            case 'offender_type':
                $aParam['type_id'] = '10';
                $aParam['status'] = '1';
                break;
        }

        return $aParam;
    }

    public function getCaseTipDetails($aParam) {

        $aParam = $this->getCaseTipDetailTypeIdAndStatus($aParam);
        $aResponse = [];
        $aResponse = $this->Global_data_model->getCaseTipDetails($aParam);

        return $aResponse;
    }

    private function getCaseTipDetailTypeIdAndStatus($aParam) {

        switch ($aParam['case_tip']) {
            case 'act':
                $aParam['type_id'] = '1';
                $aParam['status'] = '1';
                break;
            case 'mean':
                $aParam['type_id'] = '3';
                $aParam['status'] = '1';
                break;
            case 'purpose':
                $aParam['type_id'] = '2';
                $aParam['status'] = '1';
                break;
        }

        return $aParam;
    }

    public function getCountryISO($aParam) {
        $aResponse['country'] = $this->Global_data_model->getCountryISO($aParam);
        $aResponse['currency'] = $this->Global_data_model->getCurrencyISO($aParam);
        return $aResponse;
    }

    public function getEmploymentType($aParam) {
        $aResponse = $this->Global_data_model->getEmploymentType($aParam);
        return $aResponse;
    }

    public function getDepartureType($aParam) {
        $aResponse = $this->Global_data_model->getDepartureType($aParam);
        return $aResponse;
    }

    public function getPortType($aParam) {
        $aResponse = $this->Global_data_model->getPortType($aParam);
        return $aResponse;
    }

    public function getVisaCategory($aParam) {
        $aResponse = $this->Global_data_model->getVisaCategory($aParam);
        return $aResponse;
    }

    public function getCivilStatus($aParam) {
        $aResponse = $this->Global_data_model->getCivilStatus($aParam);
        return $aResponse;
    }

    public function getGlobalComplainSource($aParam) {
        $aResponse = $this->Global_data_model->getGlobalComplainSource($aParam);
        return $aResponse;
    }

    public function getNationality($aParam) {
        $aResponse = $this->Global_data_model->getNationality($aParam);
        return $aResponse;
    }

    public function getActPurposeMeans() {
        $aResponse = [];
        $aResponse['act'] = $this->Global_data_model->getTraficInPerson_Act();
        $aResponse['means'] = $this->Global_data_model->getTraficInPerson_means();
        $aResponse['purpose'] = $this->Global_data_model->getTraficInPerson_purpose();
        return $aResponse;
    }

    public function getAssessmentType() {
        $aResponse = $this->Global_data_model->getAssessmentType();
        return $aResponse;
    }

    public function getServiceStatus() {
        $aResponse = $this->Global_data_model->getServiceStatus();
        return $aResponse;
    }
    
    public function getServiceStatusById($aParam) {
        $aResponse = $this->Global_data_model->getServiceStatusById($aParam);
        return $aResponse;
    }

    public function getServicesByAssessmentID($aParam) {
        $aResponse = $this->Global_data_model->getServicesByAssessmentID($aParam);
        return $aResponse;
    }

    public function getAgenciesWhichOfferServices($aParam) {
        $aResponse = $this->Global_data_model->getAgenciesWhichOfferServices($aParam);
        return $aResponse;
    }

    public function getDocumentTypesByDocumentCategoryID($aParam) {

        if ($aParam['id'] == "1") {
            $aResponse = $this->Global_data_model->getGeneralDocuments($aParam);
        } else {

            $aResponse = $this->Global_data_model->getAllServices($aParam);
        }

        return $aResponse;
    }

    public function getPhilippinePort($aParam) {
        $aResponse = $this->Global_data_model->getPhilippinePort($aParam);
        return $aResponse;
    }

    public function findInDataDictionary($aParam) {
        $aParam = $this->yel->safe_mode_clean_array($aParam);
        $aResponse = [];
        if ($aParam['keyword'] !== "") {
            $aResponse['result'] = self::FAILED_RESPONSE;
            $aResponse['details'] = $this->Global_data_model->findInDataDictionary_conditional($aParam);
            if (!empty($aResponse['details']) == true) {
                $aResponse['result'] = self::SUCCESS_RESPONSE;
            }
        } else {
            $aResponse['result'] = self::SUCCESS_RESPONSE;
            $aResponse['details'] = $this->Global_data_model->findInDataDictionary();
        }
        return $aResponse;
    }

    public function findInDirectory($aParam) {
        $aParam = $this->yel->safe_mode_clean_array($aParam);
        $aResponse = [];
        $aResponse['result'] = self::FAILED_RESPONSE;
        if ($aParam['keyword'] !== "") {
            //search from agency list
            $agencies = $this->Global_data_model->getAllAgenciesByKeyword($aParam);
            if (empty($agencies) == false) {
                $aResponse['result'] = self::SUCCESS_RESPONSE;
                //get all branches under agency
                foreach ($agencies as $key => $val) {

                    $agencies[$key]['branches'] = $this->Global_data_model->getAgencyBranchesByAgencyID($val['agency_id']);
                    foreach ($agencies[$key]['branches'] as $k => $v) {
                        $agencies[$key]['branches'][$k]['address'] = $this->Global_data_model->getBranchAddressByAgencyBranchID($v['agency_branch_id']);
                        $agencies[$key]['branches'][$k]['contact_details_primary'] = $this->Global_data_model->getBranchContactDetailsPrimary($v['agency_branch_id']);
                        $agencies[$key]['branches'][$k]['agency_branch_id'] = $this->yel->encrypt_param($v['agency_branch_id']);
                    }
                    $agencies[$key]['agency_id'] = $this->yel->encrypt_param($val['agency_id']);
                }
            } else {
                //search from agency branch
                $agencies = $this->Global_data_model->getAllAgencyIDInBranchByKeyword($aParam);
                if (empty($agencies) == false) {
                    $aResponse['result'] = self::SUCCESS_RESPONSE;
                    foreach ($agencies as $key => $val) {
                        $agencies[$key]['branches'] = $this->Global_data_model->getAgencyBranchesByAgencyAndAgencyBranchID($val['agency_id'], $aParam);
                        foreach ($agencies[$key]['branches'] as $k => $v) {
                            $agencies[$key]['branches'][$k]['address'] = $this->Global_data_model->getBranchAddressByAgencyBranchID($v['agency_branch_id']);
                            $agencies[$key]['branches'][$k]['contact_details_primary'] = $this->Global_data_model->getBranchContactDetailsPrimary($v['agency_branch_id']);
                            $agencies[$key]['branches'][$k]['agency_branch_id'] = $this->yel->encrypt_param($v['agency_branch_id']);
                        }
                        $agencies[$key]['agency_id'] = $this->yel->encrypt_param($val['agency_id']);
                    }
                } else {
                    //no record found
                    $aResponse['result'] = self::FAILED_RESPONSE;
                    $agencies = [];
                }
            }

            $aResponse['list'] = $agencies;
        } else {
            $agencies = $this->Global_data_model->getAllAgenciesNoKeyword($aParam);
            $aResponse['result'] = self::SUCCESS_RESPONSE;
            //get all branches under agency
            foreach ($agencies as $key => $val) {

                $agencies[$key]['branches'] = $this->Global_data_model->getAgencyBranchesByAgencyID($val['agency_id']);
                foreach ($agencies[$key]['branches'] as $k => $v) {
                    $agencies[$key]['branches'][$k]['address'] = $this->Global_data_model->getBranchAddressByAgencyBranchID($v['agency_branch_id']);
                    $agencies[$key]['branches'][$k]['contact_details_primary'] = $this->Global_data_model->getBranchContactDetailsPrimary($v['agency_branch_id']);
                    $agencies[$key]['branches'][$k]['agency_branch_id'] = $this->yel->encrypt_param($v['agency_branch_id']);
                }
                $agencies[$key]['agency_id'] = $this->yel->encrypt_param($val['agency_id']);
            }
            $aResponse['list'] = $agencies;
        }

        return $aResponse;
    }
    
    public function getIssueStatus($aParam) {
        
        $aResponse = $this->Global_data_model->getIssueStatus($aParam);
        return $aResponse;
        
    }
    
    public function readAllNotifications($aParam) {
        $aResponse = [];
        $user_id = $_SESSION['userData']['user_id'];
        $aResponse = $this->notif_model->setAllUserNotificationAsRead($user_id);
        return $aResponse;
    }
}
