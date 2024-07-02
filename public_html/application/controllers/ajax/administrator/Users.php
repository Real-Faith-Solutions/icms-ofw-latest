<?php

/**
 * Users Internal Ajax
 * 
 * @module Ajax Loader
 * @author LBS eBusiness Solutions Corp. 
 * @since 2017
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    const SUCCESS_RESPONSE = 1;
    const FAILED_RESPONSE = 0;

    public function __construct() {
        parent::__construct();

        // load models
        $this->load->model('administrator/Users_model');
        $this->load->model('User_access_model');
        $this->load->model('Global_data_model');
        $this->load->model('administrator/Agencies_model');
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

    public function getAllUsers($aParam) {
        $aReponse = [];

        //get session id
        $aResult['session'] = $_SESSION['userData'];
        // set page start
        $aParam['page'] = ($aParam['page'] * $aParam['limit']) - $aParam['limit'];
        // set sorting condition
        if ($aParam['orderby'] == '1') {
            $aParam['orderby'] = " ORDER BY `gat`.`agency_name`";
        } elseif ($aParam['orderby'] == '2') {
            $aParam['orderby'] = " ORDER BY  `u`.`user_firstname`";
        } elseif ($aParam['orderby'] == '3') {
            $aParam['orderby'] = " ORDER BY `u`.`user_is_active`";
        } elseif ($aParam['orderby'] == '4') {
            $aParam['orderby'] = " ORDER BY `user_level_description`";
        } else {
            $aParam['orderby'] = "";
        }

        // set filter where clause
        $aParam['filter'] = "";
        if ($aParam['keyword'] !== "" || empty($aParam['keyword']) == false) {

            if ($aParam['filter'] == '1') { // agencyname
                $userid = $this->Users_model->getUserIDByFilter_agencyname($aParam);
            } elseif ($aParam['filter'] == '2') { //fullname
                $userid = $this->Users_model->getUserIDByFilter_username($aParam);
            } elseif ($aParam['filter'] == '3') { // branch 
                $userid = $this->Users_model->getUserIDByFilter_branch($aParam);
            } else {
                $userid_agn = $this->Users_model->getUserIDByFilter_agencyname($aParam);
                $userid_usr = $this->Users_model->getUserIDByFilter_username($aParam);
                $userid_bch = $this->Users_model->getUserIDByFilter_branch($aParam);
                $userid = array_merge($userid_agn, $userid_usr, $userid_bch);
            }
            $id = array();
            foreach ($userid as $key => $val) {
                array_push($id, $val['user_id']);
            }
            $filterid = implode(',', $id);
            if ($filterid == "") {
                $filterid = $aParam['filter'] = "  `u`.`user_id` IN ('') AND ";
            } else {
                $aParam['filter'] = "  `u`.`user_id` IN (" . $filterid . ") AND ";
            }
        }

        if ($aParam['aStatus'] !== "" || empty($aParam['aStatus']) == false) {
            $aParam['filter'] .= '  `u`.`user_is_active` IN  (' . $aParam['aStatus'] . ') AND ';
        }

        if ($aParam['aUserRole'] !== "" || empty($aParam['aUserRole']) == false) {
            $aParam['filter'] .= '  `u`.`user_level_id` IN (' . $aParam['aUserRole'] . ') AND ';
        }

        $aList = $this->Users_model->getAllUsers($aParam);

        //encrypt id
        foreach ($aList['list'] as $key => $val) {
            $aList['list'][$key]['user_id'] = $this->yel->encrypt_param($val['user_id']);
            $aList['list'][$key]['address'] = $this->Users_model->getUserAddressUserID($val['user_id']);
        }

        $aReponse['list'] = $aList['list'];
        $aReponse['count'] = $aList['count'];
        return $aReponse;
    }

    public function getMyUsers($aParam) {
        $aReponse = [];

        //get session id
        $aResult['session'] = $_SESSION['userData'];
        // set page start
        $aParam['page'] = ($aParam['page'] * $aParam['limit']) - $aParam['limit'];
        // set sorting condition
        if ($aParam['orderby'] == '1') {
            $aParam['orderby'] = " ORDER BY `gat`.`agency_name`";
        } elseif ($aParam['orderby'] == '2') {
            $aParam['orderby'] = " ORDER BY  `u`.`user_firstname`";
        } elseif ($aParam['orderby'] == '3') {
            $aParam['orderby'] = " ORDER BY `u`.`user_is_active`";
        } elseif ($aParam['orderby'] == '4') {
            $aParam['orderby'] = " ORDER BY `user_level_description`";
        } else {
            $aParam['orderby'] = "";
        }

        // set filter where clause
        $aParam['filter'] = "";
        if ($aParam['keyword'] !== "" || empty($aParam['keyword']) == false) {

            if ($aParam['filter'] == '1') { // agencyname
                $userid = $this->Users_model->getUserIDByFilter_agencyname($aParam);
            } elseif ($aParam['filter'] == '2') { //fullname
                $userid = $this->Users_model->getUserIDByFilter_username($aParam);
            } elseif ($aParam['filter'] == '3') { // branch 
                $userid = $this->Users_model->getUserIDByFilter_branch($aParam);
            } else {
                $userid_agn = $this->Users_model->getUserIDByFilter_agencyname($aParam);
                $userid_usr = $this->Users_model->getUserIDByFilter_username($aParam);
                $userid_bch = $this->Users_model->getUserIDByFilter_branch($aParam);
                $userid = array_merge($userid_agn, $userid_usr, $userid_bch);
            }
            $id = array();
            foreach ($userid as $key => $val) {
                array_push($id, $val['user_id']);
            }
            $filterid = implode(',', $id);
            if ($filterid == "") {
                $filterid = $aParam['filter'] = "  `u`.`user_id` IN ('') AND ";
            } else {
                $aParam['filter'] = "  `u`.`user_id` IN (" . $filterid . ") AND ";
            }
        }

        if ($aParam['aStatus'] !== "" || empty($aParam['aStatus']) == false) {
            $aParam['filter'] .= '  `u`.`user_is_active` IN  (' . $aParam['aStatus'] . ') AND ';
        }

        if ($aParam['aUserRole'] !== "" || empty($aParam['aUserRole']) == false) {
            $aParam['filter'] .= '  `u`.`user_level_id` IN (' . $aParam['aUserRole'] . ') AND ';
        }

        $aList = $this->Users_model->getMyUsers($aParam);

        //encrypt id
        foreach ($aList['list'] as $key => $val) {
            $aList['list'][$key]['user_id'] = $this->yel->encrypt_param($val['user_id']);
            $aList['list'][$key]['address'] = $this->Users_model->getUserAddressUserID($val['user_id']);
        }

        $aReponse['list'] = $aList['list'];
        $aReponse['count'] = $aList['count'];
        return $aReponse;
    }

    public function getAgencyListForDropDown($aParam) {
        $aAgencies = $this->Agencies_model->getAgencies($aParam);
        $aResponse = [];
        foreach ($aAgencies as $key => $val) {
            $aAgenciesaddress = $this->Agencies_model->getGovernmentAddressByID($val['govt_agency_id']);
            $aResponse[$key]['agency_name'] = $val['agency_name'];
            $aResponse[$key]['branch'] = "";
            $aResponse[$key]['branch_id'] = $val['govt_agency_id'];
            if (isset($aAgenciesaddress['country_id']) == true && $aAgenciesaddress['country_id'] == "173") {
                if (isset($aAgenciesaddress['province_id']) == true) {
                    $prov = $this->Global_data_model->getProvinceByID($aAgenciesaddress['province_id']);
                    if (!empty($prov) == TRUE) {
                        $aResponse[$key]['branch'] = " : " . $prov;
                    }
                }
            } else {
                if (isset($aAgenciesaddress['province_id']) == true) {
                    $prov = $this->Global_data_model->getStateByID($aAgenciesaddress['province_id']);
                    if (!empty($prov) == TRUE) {
                        $aResponse[$key]['branch'] = " : " . $prov;
                    }
                }
            }
        }
        return $aResponse;
    }

    public function validateUsername($aParam) {
        $response = [];
        $response['userCount'] = $this->Users_model->validateUsername($aParam);

        if ($response['userCount'] >= 1) {
            $response['result'] = 1;
        } else {
            $response['result'] = 0;
        }
        return $response;
    }

    public function addUsers($aParam) {

        $aResponse = [];

        $aResponse['flag'] = self::FAILED_RESPONSE;

        $aParam = $this->yel->clean_array($aParam);

        if (!empty($aParam) !== false) {

            //Insert Users 
            $aParam['newUserID'] = $this->Users_model->addUsers($aParam);

            //Insert Address 
            $addUserAddres = $this->Users_model->addUserAddress($aParam);

            $roles = explode(",", $aParam['user_role']);
            // Insert role 
            foreach ($roles as $key => $val) {
                $aParamRole['userRoleId'] = $val;
                $aParamRole['newUserID'] = $aParam['newUserID'];
                $addUserUserRole = $this->Users_model->addUserUserRole($aParamRole);
            }

            $aResponse['flag'] = self::SUCCESS_RESPONSE;
        }

        return $aResponse;
    }

    public function getUsersInfobyID($aParam) {

        $aResponse = [];

        $aResponse['flag'] = self::FAILED_RESPONSE;

        if (!empty($aParam) !== false) {

            $aParam['user_id'] = $this->yel->decrypt_param($aParam['user_id']);
            $aResult['detail'] = $this->Users_model->getUsersInfobyID($aParam);
            $aResult['address'] = $this->Users_model->getUserAddressUserID($aParam['user_id']);
            if (!empty($aResult['response']) !== false) {
                $aResponse['detail'] = $aResult['detail'];

                $aResponse['flag'] = self::SUCCESS_RESPONSE;
            }
        }

        return $aResult;
    }

    public function addNewAgencyUser($aParam) {
        $aResponse = [];
        $aResult['flag'] = self::FAILED_RESPONSE;
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        //validation rules
        $aRules = array(
//            'country' => 'required',
//            'prov' => 'required',
//            'address' => 'required',
            'fname' => 'required',
            'lname' => 'required',
            'sex' => 'required',
            'email' => 'required',
            'agencytype' => 'required',
            'agencyid' => 'required',
            'userlevel' => 'required',
            'area_desc' => 'required',
        );


        /**
         * Parameter Validation
         */
        $aAssert = $this->assert->formValidate($aParam, $aRules);

        $aResponse['php_validation'] = $aAssert;
        if ($aAssert['flag'] != self::ACTIVE_STATUS) {
            return $aResponse;
        }

        $aResponse['flag'] = self::ACTIVE_STATUS;

        $abbr = $this->Users_model->getAgencyAbbreviation($aParam);
        $usercount = $this->Users_model->getUserCount($aParam);
        $aParam['username'] = strtoupper($abbr) . sprintf("%03d", $usercount + 1) . strtoupper(substr($aParam['fname'], 0, 1)) . strtoupper(substr($aParam['lname'], 0, 1));
        $aParam['accessCode'] = $this->yel->generateAcessCode(6);

        //check email availability
        $availability = $this->Users_model->getUserEmailAvailability($aParam);
        if ($availability == "0") {

            $aParam['newuserid'] = $newUserId = $this->Users_model->addNewAgencyUser($aParam);
            if (empty($aParam['region']) == true) {
                $aParam['region'] = '0';
            }
            if (empty($aParam['city']) == true) {
                $aParam['city'] = '0';
            }
            if (empty($aParam['brgy']) == true) {
                $aParam['brgy'] = '0';
            }

            /*
             * Insert User Address
             */
            //$aResponse['result'] = $this->Users_model->addUserAddress($aParam);

            $accessCode = $this->yel->encrypt_param($aParam['accessCode']);
            $userId = $this->yel->encrypt_param($aParam['newuserid']);
            $dateTime = $this->yel->encrypt_param(date("Y-m-d H:i:s"));
            $link = AGENCY_SITE_URL . "snuavve/" . $userId . "/" . $accessCode . "/" . $dateTime;
            // the param $link will serve as add password link
            $aEmail = [];
            $aEmail['data']['username'] = $aParam['username'];
            $aEmail['data']['recipient_name'] = $aParam['fname'];
            $aEmail['data']['link'] = $link;
            $aEmail['to'] = $aParam['email'];
            $aEmail['subject'] = 'Set Password';
            $aSendMail = $this->mailbox->sendEmailWithTemplate('new_user', $aEmail);

            //add user logs
            $aLog = [];
            $aLog['log_event_type'] = 12; // base on table : icms_user_event_type
            $aLog['log_message'] = "added " . $aParam['fname'] . " " . $aParam['lname'] . " as new user for " . $aParam['agencytype_name'] . " - " . $aParam['agency_branch_name'];
            $aLog['log_link'] = 'agency_branch/' . $this->yel->encrypt_param($aParam['agencyid']);
            $aLog['log_action'] = 1; // 1= new insert table 2=update table
            $aResponse['log'] = $this->audit->create($aLog);

            $aNotif = [];
            $aNotif['receiver'] = $_SESSION['userData']['user_id'];
            $aNotif['notif_type'] = "3";
            $aNotif['method'] = "users";
            $aNotif['tbl_id'] = $aParam['newuserid'];
            $aNotif['msg'] = "You have successfully created a new user account for  for " . $aParam['agencytype_name'] . " - " . $aParam['agency_branch_name'];
            $this->notif->create($aNotif);
            if ($_SESSION['userData']['user_level_id'] !== 1) {
                $adminDetails = $this->Users_model->getSuperAdminUserId();
                $aNotif = [];
                $aNotif['receiver'] = $adminDetails['user_id'];
                $aNotif['notif_type'] = "3";
                $aNotif['method'] = "users";
                $aNotif['tbl_id'] = $aParam['newuserid'];
                $aNotif['msg'] = $_SESSION['userData']['user_firstname'] . " has created an account for " . $aParam['agencytype_name'] . " - " . $aParam['agency_branch_name'];
                $this->notif->create($aNotif);
            }
        } else {
            $aResponse['result'] = "1";
            //unavailable email
        }

        return $aResponse;
    }

    public function setUserStatus($aParam) {
        $aResponse = [];

        $aResult['flag'] = self::FAILED_RESPONSE;
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        //validation rules
        $aRules = array(
            'uid' => 'required',
        );

        /**
         * Parameter Validation
         */
        $aAssert = $this->assert->formValidate($aParam, $aRules);

        $aResponse['php_validation'] = $aAssert;
        if ($aAssert['flag'] != self::ACTIVE_STATUS) {
            return $aResponse;
        }


        $aParam['user_id'] = $this->yel->decrypt_param($aParam['uid']);
        unset($aParam['uid']);
        $aResponse['result'] = $this->Users_model->setUserStatus($aParam);

        //userlogs
        //get userdetails
        $userInfo = $this->Users_model->getUsersInfobyID($aParam);
        $aParam['agency_id'] = $userInfo['agency_branch_id'];
        $agency_details = $this->Agencies_model->getAgencyInformationbyId($aParam);
        $aLog = [];
        if ($aParam['newStat'] == "1") {
            $aLog['old_data'] = array("status" => "Inactive");
            $aLog['new_data'] = array("status" => "Active");
        } else {
            $aLog['old_data'] = array("status" => "Active");
            $aLog['new_data'] = array("status" => "Inactive");
        }

        $aLog['log_event_type'] = 14; // base on table : icms_user_event_type
        $aLog['log_message'] = "changed user account status of " . $userInfo['user_firstname'] . "  " . $userInfo['user_lastname'] . " from " . $agency_details['agency_abbr'] . " - " . $agency_details['agency_branch_name'];
        $aLog['log_link'] = 'users/' . $this->yel->encrypt_param($userInfo['user_id']);
        $aLog['log_action'] = 2; // 1= new insert table 2=update table
        $aLog['new_data'] = $this->yel->encrypt_param(json_encode($aLog['new_data']));
        $aLog['old_data'] = $this->yel->encrypt_param(json_encode($aLog['old_data']));
        $aResponse['log'] = $this->audit->create($aLog);

        return $aResponse;
    }

    public function getUserDetails($aParam) {
        $aParam['user_id'] = $this->yel->decrypt_param($aParam['user_id']);
        $aResult = $this->Users_model->getUserDetails($aParam);
        $aResult['address'] = $this->Users_model->getUserAddressUserID($aParam['user_id']);
        $aResult['user_date_added'] = date("F d, Y", strtotime($aResult['user_date_added']));
        unset($aResult['govt_agency_id'], $aResult['user_id'], $aResult['user_password']);

        return $aResult;
    }

    public function setUserDetails($aParam) {

        $aResponse = [];
        $aResult['flag'] = self::FAILED_RESPONSE;
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        //validation rules
        $aRules = array(
            'user_id' => 'required',
            'fname' => 'required',
            'lname' => 'required',
            'sex' => 'required',
            'userLevel' => 'required',
            'txt_email' => 'required',
        );

        /**
         * Parameter Validation
         */
        $aAssert = $this->assert->formValidate($aParam, $aRules);

        $aResponse['php_validation'] = $aAssert;
        if ($aAssert['flag'] != self::ACTIVE_STATUS) {
            return $aResponse;
        }
        $aResponse['flag'] = self::ACTIVE_STATUS;
        $aLog_info = [];
        $aLog_address = [];

        //decrypt id
        $aParam['user_id'] = $this->yel->decrypt_param($aParam['user_id']);
        //get old details before update
        $aLog_info['old_data'] = $this->Users_model->getUserDetails_logs($aParam);
        $aLog_address['old_data'] = $this->Users_model->getUserAddress_logs($aParam);
        //update details
        $userInfo = $this->Users_model->setUserDetails($aParam);
        if($aParam['user_stats'] == '1'){
            // reset login_attempt
            $this->User_access_model->resetLoginAttempt($aParam);
        }
        // Manage Address
        //$aLog_address['old_data'] = $this->Users_model->getUserAddress_logs($aParam);
        //$userAddress = $this->Users_model->setUserAddress($aParam);
        //if ($userAddress['stat'] !== "1") {
        //    $userAddress = $this->Users_model->addUserAddress($aParam);
        //}
        //get old details after update
        $aLog_info['new_data'] = $this->Users_model->getUserDetails_logs($aParam);
        $aLog_address['new_data'] = $this->Users_model->getUserAddress_logs($aParam);

        //saving logs for user details
        $result = "0";
        if ($userInfo['stat'] == "1") {
            $result = "1";
            $aLog_info['log_event_type'] = 15; // base on table : icms_user_event_type
            if ($aParam['user_id'] == $_SESSION['userData']['user_id']) {
                $aLog_info['log_message'] = "changed own account details";
            } else {
                $user_details = $this->Users_model->getUserDetails($aParam);
                $aParam['agency_id'] = $user_details['agency_branch_id'];
                $agency_details = $this->Agencies_model->getAgencyInformationbyId($aParam);
                $aLog_info['log_message'] = "changed " . $agency_details['agency_abbr'] . " - " . $agency_details['agency_branch_name'] . " user account details";
            }
            $aLog_info['log_link'] = 'users/' . $this->yel->encrypt_param($aParam['user_id']);
            $aLog_info['log_action'] = 2; // 1= new insert table 2=update table
            $aLog_info['new_data'] = $this->yel->encrypt_param(json_encode($aLog_info['new_data']));
            $aLog_info['old_data'] = $this->yel->encrypt_param(json_encode($aLog_info['old_data']));
            $aResponse['log'] = $this->audit->create($aLog_info);
        }
        //saving logs for user address
//        if ($userAddress['stat'] == "1") {
//            $result = "1";
//            $aLog_address['log_event_type'] = 16; // base on table : icms_user_event_type
//            if ($aParam['user_id'] == $_SESSION['userData']['user_id']) {
//                $aLog_address['log_message'] = "changed own address details";
//            } else {
//                $user_details = $this->Users_model->getUserDetails($aParam);
//                $aParam['agency_id'] = $user_details['agency_branch_id'];
//                $agency_details = $this->Agencies_model->getAgencyInformationbyId($aParam);
//                $aLog_address['log_message'] = "changed " . $agency_details['agency_abbr'] . " - " . $agency_details['agency_branch_name'] . " user address details";
//            }
//            $aLog_address['log_link'] = 'users/' . $this->yel->encrypt_param($aParam['user_id']);
//            $aLog_address['log_action'] = 2; // 1= new insert table 2=update table
//            $aLog_address['new_data'] = $this->yel->encrypt_param(json_encode($aLog_address['new_data']));
//            $aLog_address['old_data'] = $this->yel->encrypt_param(json_encode($aLog_address['old_data']));
//            $aResponse['log'] = $this->audit->create($aLog_address);
//        }
        $aResponse['result'] = $result;
        return $aResponse;
    }

    public function sendResetPasswordLink($aParam) {
        $aResponse = [];
        $aResult['flag'] = self::FAILED_RESPONSE;
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        //validation rules
        $aRules = array(
            'user_id' => 'required',
            'email' => 'required',
            'fname' => 'required',
        );

        /**
         * Parameter Validation
         */
        $aAssert = $this->assert->formValidate($aParam, $aRules);

        $aResponse['php_validation'] = $aAssert;
        if ($aAssert['flag'] != self::ACTIVE_STATUS) {
            return $aResponse;
        }



        $aParam['user_id'] = $this->yel->decrypt_param($aParam['user_id']);
        $aParam['accessCode'] = $this->yel->generateAcessCode(6);
        $accessCode = $this->yel->encrypt_param($aParam['accessCode']);
        $userId = $this->yel->encrypt_param($aParam['user_id']);

        $dateNow = date("Y-m-d H:i:s");
        $dateTime = $this->yel->encrypt_param($dateNow);
        //get user reset Password status
        $stat = $this->Users_model->getResetPasswordStatus($aParam);
        $allowToSend = 0;
        if (empty($stat['user_access_code']) == true) {
            // allow send
            $allowToSend = 1;
        } else {
            $todayLess24Hrs = date("Y-m-d H:i:s", strtotime('-24 hours', time()));
            if (strtotime($stat['user_date_modified']) <= strtotime($todayLess24Hrs)) { // this is more than 24 hrs
                // allow send
                $allowToSend = 1;
            }
        }
        if ($allowToSend == 1) {
            $aResponse['result'] = "1";
            $aResponse['msg'] = "email sent";
            //update user access code
            $this->Users_model->setResetPasswordAccessCode($aParam);
            $link = AGENCY_SITE_URL . "rstpwd/" . $userId . "/" . $accessCode . "/" . $dateTime;
            // the param $link will serve as add password link
            $aEmail = [];
            $aEmail['data']['recipient_name'] = $aParam['fname'];
            $aEmail['data']['link'] = $link;
            $aEmail['to'] = $aParam['email'];
            $aEmail['subject'] = 'Reset Password';
            $aSendMail = $this->mailbox->sendEmailWithTemplate('reset_password', $aEmail);

            //add userlog
            $aLog = [];
            $aLog['log_event_type'] = 13; // base on table : icms_user_event_type
            $aLog['log_message'] = "sent a reset password link email to <b>" . $aParam['email'] . "</b>";
            $aLog['log_link'] = 'users/' . $this->yel->encrypt_param($aParam['user_id']);
            $aLog['log_action'] = 1; // 1= new inserted // 2=update table
            $aResponse['log'] = $this->audit->create($aLog);

            //add system notif
            if ($_SESSION['userData']['user_level_id'] !== "1") {
                $adminDetails = $this->Users_model->getSuperAdminUserId();
                $aNotif = [];
                $aNotif['method'] = "users";
                $aNotif['tbl_id'] = $aParam['user_id'];
                $aNotif['receiver'] = $adminDetails['user_id'];
                $aNotif['notif_type'] = "3";
                $aNotif['msg'] = $_SESSION['userData']['user_firstname'] . " " . $_SESSION['userData']['user_lastname'] . " sent a reset the password link for " . $aParam['fname'] . " " . $aParam['lname'] . " of " . $aParam['abbr'] . "-" . $aParam['branchname'];
                $this->notif->create($aNotif);
            }
            $aNotif = [];
            $aNotif['method'] = "users";
            $aNotif['tbl_id'] = $aParam['user_id'];
            $aNotif['receiver'] = $_SESSION['userData']['user_id'];
            $aNotif['notif_type'] = "3";
            $aNotif['msg'] = "You have successfully sent a reset the password link for " . $aParam['fname'] . " " . $aParam['lname'] . " of " . $aParam['abbr'] . "-" . $aParam['branchname'];
            $this->notif->create($aNotif);
        } else {
            $aResponse['result'] = "0";
            $aResponse['msg'] = "unable to send";
            $modAdd24Hrs = strtotime($stat['user_date_modified']) + 86400;
            $remSecs = $modAdd24Hrs - strtotime(date("Y-m-d H:i:s"));
            $aResponse['rem_hrs'] = floor($remSecs / 3600);
            $aResponse['rem_mins'] = floor(($remSecs - (3600 * $aResponse['rem_hrs'])) / 60);
        }

        return $aResponse;
    }

    public function getAdminUsersByAgency($aParam) {
        $aResponse = [];
        $aResult['flag'] = self::FAILED_RESPONSE;
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        $aResponse = $this->Users_model->getAdminUsersByAgency($aParam);

        return $aResponse;
    }

    public function getEmailAvailability($aParam) {

        $aParam['user_id'] = $this->yel->decrypt_param($aParam['user_id']);
        $aParam['agencyid'] = $this->Users_model->getUserEmailAgencyIdByUserId($aParam);
        $aResult = $this->Users_model->getUserEmailAvailability($aParam);
        return $aResult;
    }

    public function changePassword($aParam) {
        $aResponse = [];
        $aResult['flag'] = self::FAILED_RESPONSE;
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        //validation rules
        $aRules = array(
            'user_id' => 'required',
            'password' => 'required',
        );

        /**
         * Parameter Validation
         */
        $aAssert = $this->assert->formValidate($aParam, $aRules);

        $aResponse['php_validation'] = $aAssert;
        if ($aAssert['flag'] != self::ACTIVE_STATUS) {
            return $aResponse;
        }

        //decrypt id
        $aParam['user_id'] = $this->yel->decrypt_param($aParam['user_id']);

        $this->Users_model->changePassword($aParam);

        $aResponse['flag'] = self::ACTIVE_STATUS;
        return $aResponse;
    }

}
