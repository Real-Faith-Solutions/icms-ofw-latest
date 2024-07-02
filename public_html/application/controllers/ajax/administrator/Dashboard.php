<?php

/**
 * Agencies Internal Ajax
 * 
 * @module Ajax Loader
 * @author LBS eBusiness Solutions Corp. 
 * @since 2017
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    const SUCCESS_RESPONSE = 1;
    const FAILED_RESPONSE = 0;

    public function __construct() {
        parent::__construct();

        // load models
        $this->load->model('Dashboard_model');
        $this->load->model('Global_data_model');
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
        $this->sessionPushLogout('admininistrator');
    }

    public function getDashboardHeaderStat($aParam) {

        $aResponse = [];

        $aResponse['total_case'] = $this->Dashboard_model->getTotalCaseCount();

        $aResponse['on_going_case'] = $this->Dashboard_model->getOnGoingCaseCount();

        $aResponse['closed_case'] = $this->Dashboard_model->getClosedCaseCount();

        $aResponse['stagnant_case'] = $this->Dashboard_model->getStagnantCaseCount();
        
        $aResponse['tip_case'] = $this->Dashboard_model->getTIPReportCount();
                
        $aResponse['non_tip_case'] = $this->Dashboard_model->getNonTIPReportCount();

        // Code OSAEC Added START
        $aResponse['case_csec'] = $this->Dashboard_model->getCaseViolatedCount('csec');
        $aResponse['case_csaem'] = $this->Dashboard_model->getCaseViolatedCount('csaem');
        $aResponse['case_osaec'] = $this->Dashboard_model->getCaseViolatedCount('osaec');
        $aResponse['case_others'] = $this->Dashboard_model->getCaseViolatedCount('Other law/s violated');
        // Code OSAEC Added END

        return $aResponse;
    }

    public function getCaseFilingActivity() {
        $aResponse = [];
        $aResponse['recent_case'] = $this->Dashboard_model->getRecentCase();
        $aResponse['high_priority_case'] = $this->Dashboard_model->getHighPriorityCase();
        $aResponse['for_review_case'] = $this->Dashboard_model->getForReviewCasePriorityLevel();
        return $aResponse;
    }

    public function getTopActiveAgency() {
        $aResponse = [];
        $aResponse['top_active_agency'] = $this->Dashboard_model->getTopFiveActiveAgencyBranch();
        return $aResponse;
    }

    public function getTopTipPerCountry() {

        $aResponse = [];
        $aResponse ['TopTipPerCountry'] = $this->Dashboard_model->getTopTipPerCountry();
        return $aResponse;
    }

    public function getTopNatureOfCase() {

        $aResponse = [];
        $aResult = [];
        $aResponse['getTopNatureOfCase'] = $this->Dashboard_model->getTopNatureOfCase();

        $aResult['total'] = 0;
        $countIndex = 0;
        $countOthers = 0;

        foreach ($aResponse['getTopNatureOfCase'] as $key => $val) {
            $aResult['total'] += $val['purpose_count'];
            if ($countIndex <= 3) {
                $aResponse['top_5'][$countIndex]['purpose'] = $val['purpose'];
                $aResponse['top_5'][$countIndex]['count'] = $val['purpose_count'];
                $countIndex++;
            } else {
                $countOthers += $val['purpose_count'];
                $aResponse['top_5'][$countIndex]['purpose'] = 'Others';
                $aResponse['top_5'][$countIndex]['count'] = $countOthers;
            }
        }
        
        $countIndex = 0;
        foreach ($aResponse['top_5'] as $key => $value) {
             $aResponse['top_5'][$countIndex]['percentage'] = round((($value['count'] / $aResult['total']) *100),2);
             $countIndex++;
        }
        
       
        return $aResponse;
    }

    public function getActivityLogs_adminUser($aParam) {
        $aLog = [];
        $aLog['limit_start'] = $aParam['limit_start'];
        $aLog['limit_count'] = $aParam['limit_count'];
        $aResult = $this->audit->getActivityLogs_adminUser($aLog);
        foreach ($aResult['result']['list'] as $key => $val) {

            if ($_SESSION['userData']['user_level_id'] == "1") {  //this is admin
                if ($val['user_id'] == $_SESSION['userData']['user_id']) {
                    $aResult['result']['list'][$key]['user_log_fullname'] = "You";
                }
                unset($aResult['result']['list'][$key]['user_log_event_type_id']);
                unset($aResult['result']['list'][$key]['user_id']);
            } else { // non-admin account / get only own logs
                if ($val['user_id'] == $_SESSION['userData']['user_id']) {
                    //rename user name
                    $aResult['result']['list'][$key]['user_log_fullname'] = "You";
                    unset($aResult['result']['list'][$key]['user_log_event_type_id']);
                    unset($aResult['result']['list'][$key]['user_id']);
                } else {
                    //remove  from list
                    unset($aResult['result']['list'][$key]);
                }
            }
        }

        return $aResult;
    }

}
