<?php

/**
 * Users Internal Ajax
 * 
 * @module Ajax Loader
 * @author LBS eBusiness Solutions Corp. 
 * @since 2017
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class User_access extends CI_Controller {

    const SUCCESS_RESPONSE = 1;
    const FAILED_RESPONSE = 0;

    public function __construct() {
        parent::__construct();

        // load models
        $this->load->model('User_access_model');
    }

    /**
     * Ajax Route :: Action Controller
     */
    public function ajax() {

        // route ajax api
        $this->base_action_ajax();
    }

    public function getUserlogin($aParam) {

        $aResponse = [];
        $aResponse['flag'] = self::FAILED_RESPONSE;
        $aResponse['login_attempt'] = 0; 

        // sanitize param
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        //validation rules
        $aRules = array(
            'user' => 'required',
            'pass' => 'required',
        );

        /**
         * Parameter Validation
         */
        $aAssert = $this->assert->formValidate($aParam, $aRules);
        
        $aResponse['php_validation'] = $aAssert;
        if ($aAssert['flag'] != self::ACTIVE_STATUS) {
            return $aResponse;
        }

        // get login attempt 
        $login_attempt_user = $this->User_access_model->getLoginAttemptByUserName($aParam); 
        $login_attempt = 0; 
        $aResponse['login_attempt_user_is_exist'] = 0;
        if(isset($login_attempt_user['login_attempt']) == true){
            // update user login attempt
            $this->User_access_model->updateLoginAttemptByUserName($aParam); 
            // get login attempt 
            $login_attempt_user = $this->User_access_model->getLoginAttemptByUserName($aParam); 
            $login_attempt = $login_attempt_user['login_attempt']; 
            $aResponse['login_attempt_user_is_exist'] = 1;
        }

        $aResponse['login_attempt'] =  $login_attempt;

        // check login attempt 
        if($login_attempt >= 3){
            // inactive use 
            $this->User_access_model->inactiveUser($aParam); 
            // too much attempt    
            return $aResponse; 
        }

        $access = $this->User_access_model->getUserlogin($aParam);

        if (isset($access['user_id']) == true) {
            $aResponse['flag'] = self::SUCCESS_RESPONSE;
            #Update Login Attempt 
            $this->User_access_model->resetLoginAttempt($access);

            // if (isset($_SESSION['login_ctr']) == true) {
            //     $aResponse['login_ctr'] = $_SESSION['login_ctr'] + 1;
            // } else {
            //     $aResponse['login_ctr'] = 1;
            // }
            // unset($_SESSION['login_ctr']);

            if ($access['user_is_active'] == 1 && $access['user_level_is_active'] == 1 && $access['agency_is_active'] == 1 && $access['agency_branch_is_active'] == 1) {
                
                $aResponse['result'] = self::SUCCESS_RESPONSE;

                // $access['accessKey'] = $this->yel->generateHASHID(12);
                // $aParam['user_id'] = $access['user_id'];
                // $aParam['accessKey'] = $access['accessKey'];
                // $access['view_legal'] = $this->User_access_model->validateViewLegalServices($access);
                // $this->session->set_userdata('userData', $access);


                // unset($access['user_id']);
                // unset($access['user_level_is_active']);
                // unset($access['user_is_active']);
                // unset($access['agency_is_active']);
                // unset($access['agency_branch_id']);
                // unset($access['agency_id']);
                // unset($access['agency_branch_is_active']);

                // $aResponse['json'] = $this->yel->encrypt_param(json_encode($_SESSION['userData']));

                if ($access['agency_is_admin'] == "1") {

                    // Call addTwoFactorAuth function after successful login
                    $aResponse['otp'] = $this->addTwoFactorAuth($access['user_id']);

                    // login page return UI
                    $aResponse['link'] = ADMIN_SITE_URL;
                    $aResponse['link_type'] = 1;
                    // $_SESSION['userData']['loginFrom'] = 'administrator';
                } else {
                    $aResponse['otp'] = $this->addTwoFactorAuth($access['user_id']);
                    $aResponse['link'] = AGENCY_SITE_URL;
                    $aResponse['link_type'] = 2;
                    // $_SESSION['userData']['loginFrom'] = 'agency';
                }

                // save user log

                // $aLog = [];
                // $aLog['log_event_type'] = 1; // base on table : icms_user_event_type
                // $aLog['log_message'] = "Logged in an account";
                // $aLog['log_link'] = 'users/' . $this->yel->encrypt_param($aParam['user_id']);
                // $aLog['log_action'] = 1; // 1= new insert table 2=update table
                // $aResponse['log'] = $this->audit->create($aLog);

                //save app access
                // $this->User_access_model->setAppAccess_inactive($aParam);
                // $this->User_access_model->addAppAccess($aParam);
            } else {
                $aResponse['access_msg'] = "";
                $aResponse['result'] = self::FAILED_RESPONSE;
                if ($access['agency_is_active'] == 0) {
                    $aResponse['access_msg'] = "Agency has been deactivated";
                }
                if ($access['agency_branch_is_active'] == 0) {
                    $aResponse['access_msg'] = "Branch agency has been deactivated";
                }
                if ($access['user_level_is_active'] == 0) {
                    $aResponse['access_msg'] = "User level has been deactivated";
                }
                if ($access['user_is_active'] == 0) {
                    $aResponse['access_msg'] = "Account has been deactivated";
                }
            }
        } else {
            $aResponse['result'] = self::FAILED_RESPONSE;
            if (isset($_SESSION['login_ctr']) == true) {
                $_SESSION['login_ctr'] = $_SESSION['login_ctr'] + 1;
            } else {
                $_SESSION['login_ctr'] = 1;
            }
            $aResponse['login_ctr'] = $_SESSION['login_ctr'];
            $aResponse['access_msg'] = "Incorrect username or password";
        }
        
        $aResponse['__session'] = $_SESSION;
        return [
            'aResponse' => $aResponse,
            'access' => $access,
        ];
    }

    public function checkAccountPassword($aParam){

        $aResponse['flag'] = self::FAILED_RESPONSE;
        
        $aParam['old_pwd'] = $this->yel->encrypt($aParam['old_pwd']);
        $aParam['user_id'] = $this->yel->getUserIDByAccessKey($_SESSION['userData']['accessKey']);
        
        $aResponse['flag'] = $this->User_access_model->getPasswordComparison($aParam);
       
        return $aResponse; 
    }

    public function setNewUserPassword($aParam) {

        // flag indicator
        $aResponse['flag'] = self::FAILED_RESPONSE;
        $aResponse['result'] = self::FAILED_RESPONSE;

        // sanitize param
        $aParam = $this->yel->safe_mode_clean_array($aParam);


        //validation rules
        $aRules = array(
            'id' => 'required',
            'pwd' => array('required', 'min_length[8]'),
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

        $aParam['user_id'] = $this->yel->decrypt_param($aParam['id']);
        $aParam['new_pwd'] = $this->yel->encrypt($aParam['pwd']);

        $aResponse['details'] = $this->User_access_model->setNewUserPassword($aParam);
        $aResponse['result'] = self::ACTIVE_STATUS;

        // set session for not logged in account only in change password
        $access = $this->User_access_model->getUserInfoForChangingPassword($aParam['user_id']);
        $this->session->set_userdata('userData', $access);
        $_SESSION['userData']['loginFrom'] = "Agency";

        $aLog = [];
        $aLog['log_action'] = 1; // 1= new inserted // 2=update table
        $aLog['log_event_type'] = 15; // base on table : icms_user_event_type
        $aLog['log_message'] = " change account password";
        $aLog['module_primary_id'] = $aParam['id'];
        $aLog['sub_module_primary_id'] = $aParam['id'];
        $aResponse['log'] = $this->audit->create($aLog);

        $aNotif = [];
        $aNotif['receiver'] = $aParam['user_id'];
        $aNotif['notif_type'] = "3";
        $aNotif['method'] = "account_setting";
        $aNotif['tbl_id'] = $aParam['id'];
        $aNotif['msg'] = "You have been successfully updated your password";
        $this->notif->create($aNotif);

        return $aResponse;
    }

    public function setPersonalPassword($aParam) {

        // flag indicator
        $aResponse['flag'] = self::FAILED_RESPONSE;

        // sanitize param
        $aParam = $this->yel->safe_mode_clean_array($aParam);

        //validation rules
        $aRules = array(
            'old_pwd' => 'required',
            'new_pwd' => array('required', 'min_length[8]'),
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
        $aParam['user_id'] = $this->yel->getUserIDByAccessKey($_SESSION['userData']['accessKey']);
        //check if old user is the same
        $aParam['old_pwd'] = $this->yel->encrypt($aParam['old_pwd']);
        $aParam['new_pwd'] = $this->yel->encrypt($aParam['new_pwd']);
        $stat = $this->User_access_model->getPasswordComparison($aParam);
        if ($stat == "1") {
            $aResponse['result'] = "1";
            $this->User_access_model->setNewUserPassword($aParam);

            //user log
            $aLog = [];
            $aLog['log_event_type'] = 17; // base on table : icms_user_event_type
            $aLog['log_message'] = "changed password";
            $aLog['log_link'] = 'user/' . $this->yel->encrypt_param($aParam['user_id']);
            $aLog['log_action'] = 1; // 1= new inserted // 2=update table- show changes
            $aResponse['log'] = $this->audit->create($aLog);
            $this->ForgotPasswordSendEmail();
        } else {
            $aResponse['result'] = "0";
        }

        return $aResponse;
    }

    public function addTwoFactorAuth($user_id) {
        $twofa_type = 2;
        $twofa_portal = 2;
        $twofactorcode = mt_rand(100000, 999999);

        $param = array(
            'user_id' => $user_id,
            'twofa_type' => $twofa_type,
            'twofa_portal' => $twofa_portal,
            'twofa_code' => $twofactorcode
        );
        $result = $this->User_access_model->addTwoFactorAuto($param);
        // $this->NotificationEmailTwofa($user_id);
        $response = 1;
        return $response;
    }

    public function ResendTwoFactorAuth() {
        $id = $this->input->post('id');
        $resend = $this->input->post('resend');
        $twofa_type = 2;
        $twofa_portal = 2;
        $twofactorcode = mt_rand(100000, 999999);

        $param = array(
            'user_id' => $id,
            'twofa_type' => $twofa_type,
            'twofa_portal' => $twofa_portal,
            'twofa_code' => $twofactorcode,
            'twofa_try' => $resend
        );
        $result = $this->User_access_model->resendingtwofactor($param);
        // $test = $this->User_access_model->searchCountdownID($id);

        $this->email($id);
        return $result;
    }

    public function searchTwoFactorAuth($aParam) {

        $user = $this->User_access_model->getUserIdUsingUsername($aParam);
        $otp = $this->User_access_model->getTwoFactorAuthentication($user);
        
        if($otp != $aParam['code']){ // kung yung otp is error
            // $aResponse = [];
            $aResponse['flag'] = self::FAILED_RESPONSE;
            $aResponse['result'] = self::FAILED_RESPONSE;
            // $aResponse['name'] = "Joshua";
            return $aResponse;
        }
        
        $access = $this->User_access_model->getUserloginUsingUsername($aParam);
        
        $aResponse['result'] = self::SUCCESS_RESPONSE;
        $access['accessKey'] = $this->yel->generateHASHID(12);
        $aParam['user_id'] = $access['user_id'];
        $aParam['accessKey'] = $access['accessKey'];
        $access['view_legal'] = $this->User_access_model->validateViewLegalServices($access);
        $this->session->set_userdata('userData', $access);

        # Update Login Attempt 
        $aResponse['flag'] = self::SUCCESS_RESPONSE;
        $this->User_access_model->resetLoginAttempt($access);



        unset($access['user_id']);
        unset($access['user_level_is_active']);
        unset($access['user_is_active']);
        unset($access['agency_is_active']);
        unset($access['agency_branch_id']);
        unset($access['agency_id']);
        unset($access['agency_branch_is_active']);

        $aResponse['json'] = $this->yel->encrypt_param(json_encode($_SESSION['userData']));

        // save user log

        $aLog = [];
        $aLog['log_event_type'] = 1; // base on table : icms_user_event_type
        $aLog['log_message'] = "Logged in an account";
        $aLog['log_link'] = 'users/' . $this->yel->encrypt_param($aParam['user_id']);
        $aLog['log_action'] = 1; // 1= new insert table 2=update table
        // $aResponse['log'] = $this->audit->create($aLog);

        //save app access
        $this->User_access_model->setAppAccess_inactive($aParam);
        $this->User_access_model->addAppAccess($aParam);

        
        

        if ($access['agency_is_admin'] == "1") {
            // login page return UI
            $aResponse['link'] = ADMIN_SITE_URL;
            $aResponse['link_type'] = 1;
            $_SESSION['userData']['loginFrom'] = 'administrator';
        } else {
            $aResponse['link'] = AGENCY_SITE_URL;
            $aResponse['link_type'] = 2;
            $_SESSION['userData']['loginFrom'] = 'agency';
        }

        $aResponse['__session'] = $_SESSION;

        return $aResponse;
    }

    public function NotificationEmailTwofa(){
        $user_id = $this->input->post('user_id');
        $CI = &get_instance();
        $CI->load->library('email');
        $TwofactorAuth = $this->User_access_model->sendTwoFactorAutoViaEmail($user_id);

        if ($TwofactorAuth) {
            foreach ($TwofactorAuth as $twofa) {
                $config = array(
                    'protocol' => EMAIL_FROM_PROTOCOL,
                    'smtp_host' => EMAIL_FROM_HOST,
                    'smtp_port' => EMAIL_FROM_PORT,
                    'smtp_user' => EMAIL_FROM_USER,
                    'smtp_pass' => EMAIL_FROM_PASS,
                    'mailtype' => EMAIL_FROM_mailtype,
                    'charset' => EMAIL_FROM_charset,
                    'smtp_crypto' => EMAIL_FROM_smtp_crypto,
                    'newline' => "\r\n"
                );

                $CI->email->initialize($config);

                $CI->email->from(EMAIL_FROM_EMAIL, EMAIL_FROM_NAME);
                $CI->email->to($twofa['user_email']); // Use the fetched email address
                $CI->email->subject('Your One Time Password');
                // Construct email message
                // Construct email message
                $message = '<div style="font-family: Arial, sans-serif; font-size:18px; max-width: 600px; margin: 0 auto; padding: 20px; text-align: left;">';
                $message .= '<p>Please confirm this email address so that we can update your Account. You may be asked to enter this confirmation code:</p>';
                $message .= '<p style="font-weight: bold; font-size: 24px; margin-bottom: 20px; text-align:center;">' . $twofa['twofa_code'] . '</p>';
                $message .= '<hr style="border: none; border-top: 1px solid #ccc; margin: 20px 0;">';
                $message .= '<p style="font-size: 12px;">';
                $message .= '<div style="text-align:center;">';
                $message .= 'from<br>';
                $message .= 'ICMS.OFW<br>';
                $message .= 'ICMS, Inc., Attention: Community Support, Philippines.<br>';
                $message .= 'This message was sent to <ICMS.OFW@gmail.com>.';
                $message .= '</p>';
                $message .= '<p style="font-size: 12px; text-align:center;">To help keep your account secure, please don\'t forward this email. Learn more</p>';
                $message .= '</div>';
                $message .= '</div>';
                $CI->email->message($message);

                // Send email
                if ($CI->email->send()) {

                } else {

                }
            }
        } else {
            // Handle case where no temporary cases are found
            $response = array("success" => false, "message" => "No temporary cases found");
            echo json_encode($response);
        }
    }

    public function email($id){
        $CI = &get_instance();
        $CI->load->library('email');
        $TwofactorAuth = $this->User_access_model->sendTwoFactorAutoViaEmail($id);

        if ($TwofactorAuth) {
            foreach ($TwofactorAuth as $twofa) {
                $config = array(
                    'protocol' => EMAIL_FROM_PROTOCOL,
                    'smtp_host' => EMAIL_FROM_HOST,
                    'smtp_port' => EMAIL_FROM_PORT,
                    'smtp_user' => EMAIL_FROM_USER,
                    'smtp_pass' => EMAIL_FROM_PASS,
                    'mailtype' => EMAIL_FROM_mailtype,
                    'charset' => EMAIL_FROM_charset,
                    'smtp_crypto' => EMAIL_FROM_smtp_crypto,
                    'newline' => "\r\n"
                );

                $CI->email->initialize($config);

                $CI->email->from(EMAIL_FROM_EMAIL, EMAIL_FROM_NAME);
                $CI->email->to($twofa['user_email']); // Use the fetched email address
                $CI->email->subject('Your One Time Password');
                // Construct email message
                // Construct email message
                $message = '<div style="font-family: Arial, sans-serif; font-size:18px; max-width: 600px; margin: 0 auto; padding: 20px; text-align: left;">';
                $message .= '<p>Please confirm this email address so that we can update your Account. You may be asked to enter this confirmation code:</p>';
                $message .= '<p style="font-weight: bold; font-size: 24px; margin-bottom: 20px; text-align:center;">' . $twofa['twofa_code'] . '</p>';
                $message .= '<hr style="border: none; border-top: 1px solid #ccc; margin: 20px 0;">';
                $message .= '<p style="font-size: 12px;">';
                $message .= '<div style="text-align:center;">';
                $message .= 'from<br>';
                $message .= 'ICMS.OFW<br>';
                $message .= 'ICMS, Inc., Attention: Community Support, Philippines.<br>';
                $message .= 'This message was sent to <ICMS.OFW@gmail.com>.';
                $message .= '</p>';
                $message .= '<p style="font-size: 12px; text-align:center;">To help keep your account secure, please don\'t forward this email. Learn more</p>';
                $message .= '</div>';
                $message .= '</div>';
                $CI->email->message($message);

                // Send email
                if ($CI->email->send()) {

                } else {

                }
            }
        } else {
            // Handle case where no temporary cases are found
            $response = array("success" => false, "message" => "No temporary cases found");
            echo json_encode($response);
        }
    }

    function ForgotPasswordSendEmail()
    {
        // Load CodeIgniter instance
        $CI = &get_instance();
        $CI->load->library('email');

        $userEmail = $_SESSION['userData']['user_email'];


        $config = array(
            'protocol' => EMAIL_FROM_PROTOCOL,
            'smtp_host' => EMAIL_FROM_HOST,
            'smtp_port' => EMAIL_FROM_PORT,
            'smtp_user' => EMAIL_FROM_USER,
            'smtp_pass' => EMAIL_FROM_PASS,
            'mailtype' => EMAIL_FROM_mailtype,
            'charset' => EMAIL_FROM_charset,
            'smtp_crypto' => EMAIL_FROM_smtp_crypto,
            'newline' => "\r\n"
        );

        $CI->email->initialize($config);

        $CI->email->from(EMAIL_FROM_EMAIL, EMAIL_FROM_NAME);
        $CI->email->to($userEmail);
        $CI->email->subject('RESET PASSWORD');

        // Construct email message
        $message = '<div style="font-family: Arial, sans-serif; font-size:18px; max-width: 600px; margin: 0 auto; padding: 20px; text-align: left;">';
        $message .= '<p>Hi '. $_SESSION['userData']['user_username'].'</p>';
        $message .= '<p><strong style="color:black;">Your password has been successfully changed!</strong></p>';
        $message .= '<hr style="border: none; border-top: 1px solid #ccc; margin: 20px 0;">';
        $message .= '<p style="font-size: 12px;">';
        $message .= '<div style="text-align:center;">';
        $message .= 'from<br>';
        $message .= 'ICMS.OFW<br>';
        $message .= 'ICMS, Inc., Attention: Community Support, Philippines.<br>';
        $message .= 'This message was sent to <ICMS.OFW@gmail.com>.';
        $message .= '</p>';
        $message .= '<p style="font-size: 12px; text-align:center;">To help keep your account secure, please don\'t forward this email. Learn more</p>';
        $message .= '</div>';
        $message .= '</div>';
        $CI->email->message($message);

        // Send email
        if ($CI->email->send()) {
            $response = array("success" => true, "message" => "message Sent");
        } else {
            $response = array("success" => false, "message" => "Not Sent");
        }
    }

}