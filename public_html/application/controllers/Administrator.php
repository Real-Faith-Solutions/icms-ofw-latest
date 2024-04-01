<?php

/*
 *  All function that was define private is not valid in this panel
 */

// page security
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends CI_Controller {

    const SUCCESS_RESPONSE = 1;
    const FAILED_RESPONSE = 0;

    public function __construct() {
        parent::__construct();
        // load models
        $this->load->model('User_access_model');
        $this->load->model('administrator/Case_model');
        $this->load->model('administrator/Victims_model');
        $this->load->model('administrator/Users_model');
        $this->load->model('Notif_model');
        $this->load->model('Global_data_model');
    }

    /**
     * Session Checker
     *
     * For Development use only
     */
    public function sessionChecker() {
        echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';
    }

    /**
     * Session Checker
     *
     * For Development use only
     */
    public function codeChecker() {
//        echo date("F d, y");
//        print_r($this->api->getUsers());
//        echo sha1("b");
//       $pw=$this->yel->getOne("select user_password from  icms_user where user_id=32 limit 1");
//       echo $this->yel->_decryptor($pw);
        echo $this->yel->encrypt_param("1");
//        echo $this->yel->encrypt_param("personal");
//        echo "<pre>";
        //create
//        $aNotif = [];
//        $aNotif['recvr'] = "2,7,20,21";
//        $aNotif['notif_type'] = 1";
//        $link_sender="agency_branch/".$this->yel->encrypt_param($_SESSION['userData']['agency_branch_id']);
//        $aNotif['msg'] = "<a href='".$link_sender."'>".$_SESSION['userData']['agency_abbr']."</a> sent a sample notification for the case number <a href='cases/CN11901004'>CN11901004 </a>";
//        $test = $this->notif->create($aNotif);
//        print_r($test);
        //get header count
//        $aParam = [];
//        $aParam['limit_start'] = 0;
//        $aParam['limit_count'] = 10;
//        $test = $this->notif->getUserNotification($aParam);
//        print_r($test);
        //get unread header count
//      
//        $test = $this->notif->getUnreadNotification();
//        print_r($test);
//        
//        
//        
        //set notif read
//        $notif_id = "2";
        //set notification read single
//        $test = $this->notif->setUserNotificationAsRead('1', '1');
//        //set notification read all
//        $test = $this->notif->setUserNotificationAsRead($notif_id, '1');
    }

    /**
     * Session Destruct
     *
     * For Development use only
     */
    public function sessionDestruct() {
        // session destroy
        $this->sessionPushLogout('administrator');
    }

    private function testinglang() {
        $oldval = array("id" => "1", "name" => "sample");
        $newval = array("id" => "1", "name" => "sample again");

        $diff = array_diff($oldval, $newval);
        foreach ($diff as $key => $val) {
            echo$key . "-- old val : " . $oldval[$key] . "  ------ " . "New val : " . $newval[$key];
        }
    }

    public function index() {
        
        $this->user_login();
    }

    /*
     * 
     * @param  array User level 
     * 
     */

    private function validateUserPage($aLevel, $condition) {

        $count_level = count($aLevel);
        $user_level = $_SESSION['userData']['user_level_id'];
        $user_grand = (in_array($user_level, $aLevel));

        if ($count_level > 0) {
            if ($user_grand <= 0) {
                redirect('access_denied');
                //die('Access denied');
            }
        }
    }

    /**
     * Validate User Session
     *
     * @param string $sIndex
     * @return state logon
     */
    private function validateSession() {
        if (empty($_SESSION['userData']) == true) {
            redirect(SITE_URL . 'user_login');
            exit();
        } else {
            $userID = $this->yel->getUserIDByAccessKey($_SESSION['userData']['accessKey']);
            if (empty($userID) == true) {
                redirect('user_login');
                exit();
            } else {
                $stillActive = $this->yel->getUserAccessIsStillActive($userID);
                if ($stillActive['user_is_active'] == 0 || $stillActive['agency_is_active'] == 0 || $stillActive['agency_branch_is_active'] == 0 || $stillActive['user_level_is_active'] == 0) {
                    redirect('user_login');
                    exit();
                } else {
                    if (isset($_SESSION['userData']['loginFrom']) == true) {
                        if ($_SESSION['panel'] !== $_SESSION['userData']['loginFrom']) {
                            redirect('user_login');
                            exit();
                        }
                    } else {
                        redirect('user_login');
                        exit();
                    }
                }
            }
        }
    }

    public function email_template_maker() {
        $this->setTemplate('email_template_maker', null, null, false, false, false, false, false, false, false);
    }

    public function email_template_viewer() {
        $aEmail = [];
//            $aEmail['data']['username'] = $aParam['username'];
//            $aEmail['data']['recipient_name'] =$aParam['fname'];
//            $aEmail['data']['link'] = $link;
//            $aEmail['to'] = $aParam['email'];
//            $aEmail['subject'] = 'Set Password';
        $aEmail['data']['username'] = "kim123";
        $aEmail['data']['recipient_name'] = "Kimberly";
        $aEmail['data']['link'] = "https://agency.icmstech.org/";
        $aEmail['to'] = "kimberly.bado@s2-tech.com";
        $aEmail['subject'] = 'Set Password';
        $aSendMail = $this->mailbox->sendEmailWithTemplate('tagged_case', $aEmail);
    }

    public function dashboard() {
        if (isset($_GET['q']) == true) {
            $json = $this->yel->decrypt_param($_GET['q']);
            $_SESSION['userData'] = json_decode($json);
            redirect(SITE_URL . 'dashboard');
        }

        $this->validateSession();
        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Dashboard',
            'page_description' => '',
            'page_keyword' => ''
        );
        $aLibraries = array(
            'plugin' => array('datepicker/bootstrap-datepicker.js', 'datepicker/datepicker.css', 'jquery.validate.min.js', 'Chart.js', 'amcharts4/core.js', 'amcharts4/charts.js', 'amcharts4/themes/animated.js'),
            'css' => array('pagination'),
            'js' => array('pagination', 'global_methods', 'icms_message')
        );
        $this->setTemplate('dashboard', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    public function profile_info() {
        $this->validateSession();
        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Profile',
            'page_description' => '',
            'page_keyword' => ''
        );
        $aLibraries = array(
            'plugin' => '',
            'css' => '',
            'js' => array('global_methods', 'icms_message')
        );
        $this->setTemplate('profile_info', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    private function newsfeed() {
        $this->validateSession();
        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Newsfeed',
            'page_description' => '',
            'page_keyword' => ''
        );
        $aLibraries = array(
            'plugin' => '',
            'css' => '',
            'js' => array('global_methods', 'icms_message')
        );
        $this->setTemplate('newsfeed', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    public function users() {
        $this->validateSession();
        // 1 - admin, 2 - case encoder, 3 - case handler , 4 - case administrator, 5 - report and analytics
        $aUserLevel = array(1);
        $this->validateUserPage($aUserLevel, false);

        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Users',
            'page_description' => '',
            'page_keyword' => ''
        );

        $aLibraries = array(
            'plugin' => array('jquery.validate.min.js', 'chosen/chosen.min.css', 'chosen/chosen.jquery.min.js'),
            'css' => array('pagination'),
            'js' => array('pagination', 'global_methods', 'icms_message')
        );

        $this->Notif_model->setUserNotificationByMethodName("users");
        $this->setTemplate('users', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    public function agencies() {

        $this->validateSession();
        // 1 - admin, 2 - case encoder, 3 - case handler , 4 - case administrator, 5 - report and analytics
        $aUserLevel = array(1);
        $this->validateUserPage($aUserLevel, false);

        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Agencies',
            'page_description' => '',
            'page_keyword' => ''
        );

        $aLibraries = array(
            'plugin' => array('jquery.validate.min.js', 'chosen/chosen.min.css', 'chosen/chosen.jquery.min.js'),
            'css' => array('croppie', 'pagination'),
            'js' => array('pagination', 'croppie', 'global_methods', 'icms_message')
        );

        $this->Notif_model->setUserNotificationByMethodName("agencies");
        $this->setTemplate('agencies', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    public function agency_branch() {
        $this->validateSession();
        // 1 - admin, 2 - case encoder, 3 - case handler , 4 - case administrator, 5 - report and analytics
        $aUserLevel = array(1);
        $this->validateUserPage($aUserLevel, false);

        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Agency Branch',
            'page_description' => '',
            'page_keyword' => ''
        );

        $aLibraries = array(
            'plugin' => array('chosen/chosen.min.css', 'chosen/chosen.jquery.min.js', 'jquery.validate.min.js'),
            'css' => array('pagination'),
            'js' => array('pagination', 'global_methods', 'icms_message')
        );

        $this->Notif_model->setUserNotificationByMethodName("agency_branch");
        $this->setTemplate('agency_branch', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    public function cases() {
        $this->validateSession();
        // 1 - admin, 2 - case encoder, 3 - case handler , 4 - case administrator, 5 - report and analytics
        $aUserLevel = array(1, 2, 3, 4);
        $this->validateUserPage($aUserLevel, false);

        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Cases',
            'page_description' => '',
            'page_keyword' => ''
        );

        $aLibraries = array(
            'plugin' => array('jquery.validate.min.js',
                'dateFormat.js',
                'report_datepicker/daterangepicker.css',
                'report_datepicker/vendor.js',
                'report_datepicker/daterangepicker.js',
                'case_datepicker/jquery.datetimepicker.full.js',
                'case_datepicker/jquery.datetimepicker.css',
                'select2_/select2.full.js',
                'select2_/select2.full.min.js',
                'select2_/select2.js',
                'chosen/chosen.min.css', 
                'chosen/chosen.jquery.min.js',
                'select2_/select2.min.js'),
            'css' => array('pagination',
                'select2_/select2.css'),
            'js' => array('pagination', 'global_methods', 'icms_message')
        );
        $this->Notif_model->setUserNotificationByMethodName("cases");

        $this->setTemplate('cases', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    public function reports() {
        $this->validateSession();
        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Reports and Analytics',
            'page_description' => '',
            'page_keyword' => ''
        );
        $aLibraries = array(
            'plugin' => array('jquery.validate.min.js', 'icheck.js', 'Chart.js'),
            'css' => array(''),
            'js' => array('global_methods', 'icms_message')
        );
        $this->setTemplate('reports', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    public function add_case() {

        $this->validateSession();
        // 1 - admin, 2 - case encoder, 3 - case handler , 4 - case administrator, 5 - report and analytics
        $aUserLevel = array(1, 2, 3, 4);
        $this->validateUserPage($aUserLevel, false);
        
        $aRecordSet = [];
        $aRecordSet['temp_details'] = [];
        $aRecordSet['temp_details']['flag'] = self::FAILED_RESPONSE;
        
        $aSEO = array(
            'page_title' => 'Add case page',
            'page_description' => '',
            'page_keyword' => ''
        );
        $aLibraries = array(
            'plugin' => array('case_datepicker/jquery.datetimepicker.full.js', 'jquery.validate.min.js', 'chosen/chosen.min.css', 'chosen/chosen.jquery.min.js', 'Bs-stepper/css/bs-stepper.min.css', 'Bs-stepper/js/index.js', 'case_datepicker/jquery.datetimepicker.css'),
            'css' => array('pagination', 'croppie'),
            'js' => array('pagination', 'croppie', 'global_methods', 'icms_message'),
            'sub_js' => true
        );
        
        if (!empty($this->uri->rsegments[3]) !== false) {

            $aParam['temporary_case_id'] = $this->yel->decrypt_param($this->uri->rsegments[3]);
            $aRecordSet['temp_details'] = $this->Global_data_model->getTemporaryCase($aParam);
            $aRecordSet['temp_details']['flag'] = self::FAILED_RESPONSE;
            if(isset($aRecordSet['temp_details']['temporary_case_id'])){
                $aRecordSet['temp_details']['flag'] =  self::SUCCESS_RESPONSE;
                $aRecordSet['temp_details']['temporary_case_id'] = $this->uri->rsegments[3]; 
                unset($aRecordSet['temp_details']['temporary_case_updated_by'], $aRecordSet['temp_details']['case_id']); 
            }

        }

        $aRecordSet['temp_details'] = json_encode($aRecordSet['temp_details']); 
        
        $this->setTemplate('add_case', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    public function directory() {
        $this->validateSession();
        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Directory Page',
            'page_description' => '',
            'page_keyword' => ''
        );
        $aLibraries = array(
            'plugin' => '',
            'css' => '',
            'js' => array('global_methods', 'icms_message')
        );
        $this->setTemplate('directory', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    private function checkSession() {
        if (empty($_SESSION['userData']) == true) {
            $val = false;
        } else {
            $userID = $this->yel->getUserIDByAccessKey($_SESSION['userData']['accessKey']);
            if (empty($userID) == true) {
                $val = false;
            } else {
                $stillActive = $this->yel->getUserAccessIsStillActive($userID);
                if ($stillActive['user_is_active'] == 0 || $stillActive['agency_is_active'] == 0 || $stillActive['agency_branch_is_active'] == 0 || $stillActive['user_level_is_active'] == 0) {
                    $val = false;
                } else {
                    if (isset($_SESSION['userData']['loginFrom']) == true) {
                        if ($_SESSION['panel'] !== $_SESSION['userData']['loginFrom']) {
                            $val = false;
                        } else {
                            $val = true;
                        }
                    } else {
                        $val = false;
                    }
                }
            }
        }
        return $val;
    }

    public function user_login() {
        $sess = $this->checkSession();
        if ($sess) {
            redirect(SITE_URL . 'dashboard');
            exit();
        } else {
            session_destroy();
            $aRecordSet = [];
            $aSEO = array(
                'page_title' => 'ICMS:Login',
                'page_description' => 'User Validation',
                'page_keyword' => 'login'
            );
            $aLibraries = array(
                'plugin' => '',
                'css' => '',
                'js' => array('global_methods', 'icms_message')
            );
            $this->setTemplate('user_login', $aRecordSet, null, false, false, false, false, false, $aLibraries, $aSEO);
        }
    }

    public function twofactorauth() {
        session_destroy();
        $aRecordSet = [];
        $aSEO = array(
            'page_title' => 'ICMS:twofactorauth',
            'page_description' => 'User Validation',
            'page_keyword' => 'Two-factor Authentication'
        );
        $aLibraries = array(
            'plugin' => '',
            'css' => '',
            'js' => array('global_methods', 'icms_message')
        );
        $this->setTemplate('user_twofactor_authentication', $aRecordSet, null, false, false, false, false, false, $aLibraries, $aSEO);
    }
    

    public function settings() {

        $this->validateSession();
        // 1 - admin, 2 - case encoder, 3 - case handler , 4 - case administrator, 5 - report and analytics
        $aUserLevel = array(1);
        $this->validateUserPage($aUserLevel, false);

        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Settings',
            'page_description' => '',
            'page_keyword' => ''
        );
        $aLibraries = array(
            'plugin' => array('jquery.validate.min.js' , 'datatable/datatables.min.js' , 'datatable/datatables.min.css'),
            'css' => array('pagination'),
            'js' => array('pagination', 'global_methods', 'icms_message')
        );

        $this->setTemplate('settings', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    public function add_agency() {

        $this->validateSession();
        // 1 - admin, 2 - case encoder, 3 - case handler , 4 - case administrator, 5 - report and analytics
        $aUserLevel = array(1);
        $this->validateUserPage($aUserLevel, false);

        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Agencies',
            'page_description' => '',
            'page_keyword' => ''
        );

        $aLibraries = array(
            'plugin' => array('jquery.validate.min.js'),
            'css' => array('croppie'),
            'js' => array('croppie', 'global_methods', 'icms_message')
        );

        $this->setTemplate('add_agency', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    public function add_agency_branch() {

        $this->validateSession();
        // 1 - admin, 2 - case encoder, 3 - case handler , 4 - case administrator, 5 - report and analytics
        $aUserLevel = array(1);
        $this->validateUserPage($aUserLevel, false);

        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Agencies',
            'page_description' => '',
            'page_keyword' => ''
        );

        $aLibraries = array(
            'plugin' => array('jquery.validate.min.js', 'chosen/chosen.min.css', 'chosen/chosen.jquery.min.js', 'icheck.js'),
            'css' => array(''),
            'js' => array('global_methods', 'icms_message')
        );

        $this->setTemplate('add_agency_branch', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    public function manage_agency_branch() {

        $this->validateSession();
        // 1 - admin, 2 - case encoder, 3 - case handler , 4 - case administrator, 5 - report and analytics
        $aUserLevel = array(1);
        $this->validateUserPage($aUserLevel, false);

        $this->validateSession();

        if (!empty($this->uri->rsegments[3]) !== false) {
            $agencyid = $this->yel->decrypt_param($this->yel->clean($this->uri->rsegments[3]));
            if ($agencyid >= 1) {

                $this->Notif_model->setUserNotificationByMethodAndId("manage_agency_branch", $agencyid);

                $aRecordSet = [];
                $aParam = [];
                $aParam['agency_id'] = $agencyid;
                $this->load->model('administrator/Agencies_model');
                $aRecordSet['agency_details'] = $this->Agencies_model->getAgencyInformationbyId($aParam);
                $aRecordSet['agency_details']['agency_branch_id'] = $this->yel->encrypt_param($aRecordSet['agency_details']['agency_branch_id']);
                $aRecordSet['agency_address'] = $this->Agencies_model->getGovernmentAddressByID($agencyid);

                if (isset($aRecordSet['agency_address']['address_list_id']) == false) {
                    $aRecordSet['agency_address']['address_list_id'] = "0";
                    $aRecordSet['agency_address']['address_list_address_type'] = "0";
                    $aRecordSet['agency_address']['address_list_origin_id'] = "0";
                    $aRecordSet['agency_address']['address_list_country'] = "0";
                    $aRecordSet['agency_address']['address_list_region'] = "0";
                    $aRecordSet['agency_address']['address_list_province'] = "0";
                    $aRecordSet['agency_address']['address_list_city'] = "0";
                    $aRecordSet['agency_address']['address_list_address'] = "";
                    $aRecordSet['agency_address']['address_list_origin_address'] = "0";
                    $aRecordSet['agency_address']['country'] = "";
                    $aRecordSet['agency_address']['region'] = "";
                    $aRecordSet['agency_address']['province'] = "";
                    $aRecordSet['agency_address']['state'] = "";
                    $aRecordSet['agency_address']['city'] = "";
                    $aRecordSet['agency_address']['brgy'] = "";
                } else {
                    $aRecordSet['agency_address']['address_list_id'] = $this->yel->encrypt_param($aRecordSet['agency_address']['address_list_id']);
                }


                $aRecordSet['agency_services'] = $this->Agencies_model->getAgencyServicesOfferedByAgencyBranchID($agencyid);

                $aSEO = array(
                    'page_title' => 'Branch',
                    'page_description' => 'Modify agency branch details ',
                    'page_keyword' => 'Manage Branch'
                );

                $aLibraries = array(
                    'plugin' => array('jquery.validate.min.js', 'chosen/chosen.min.css', 'chosen/chosen.jquery.min.js', 'icheck.js'),
                    'css' => array(''),
                    'js' => array('global_methods', 'icms_message')
                );

                $this->setTemplate('manage_agency_branch', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
            } else {
                redirect('agency_branch');
                exit();
            }
        } else {
            redirect('agency_branch');
            exit();
        }
    }

    public function add_users() {

        $this->validateSession();
        // 1 - admin, 2 - case encoder, 3 - case handler , 4 - case administrator, 5 - report and analytics
        $aUserLevel = array(1);
        $this->validateUserPage($aUserLevel, false);

        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Users',
            'page_description' => '',
            'page_keyword' => ''
        );

        $aLibraries = array(
            'plugin' => array('jquery.validate.min.js'),
            'css' => array(''),
            'js' => array('global_methods', 'icms_message')
        );

        $this->setTemplate('add_users', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    private function try_upload() {
        $this->validateSession();
        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'try_upload',
            'page_description' => 'upload try',
            'page_keyword' => ''
        );
        $aLibraries = array(
            'plugin' => array(''),
            'css' => array(''),
            'js' => array('global_methods', 'icms_message')
        );

        $this->setTemplate('try_upload', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    public function notification() {
        $this->validateSession();
        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Notification',
            'page_description' => '',
            'page_keyword' => ''
        );

        $aLibraries = array(
            'plugin' => array('jquery.validate.min.js'),
            'css' => array(''),
            'js' => array('global_methods', 'icms_message')
        );

        $this->setTemplate('notification', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    public function account_setting() {
        $this->validateSession();
        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Account Settings',
            'page_description' => '',
            'page_keyword' => ''
        );

        $aLibraries = array(
            'plugin' => array('jquery.validate.min.js', 'password_strength.js'),
            'css' => array(''),
            'js' => array('global_methods', 'icms_message')
        );
        $this->Notif_model->setUserNotificationByMethodName("account_setting");

        $this->setTemplate('account_setting', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    public function logout() {

        if (isset($_SESSION['userData']['accessKey']) == true) {
            $aLog = [];
            $aLog['log_event_type'] = 2; // base on table : icms_user_event_type
            $aLog['log_message'] = "logged out an account";
            $aLog['log_link'] = 'users/' . $this->yel->encrypt_param($_SESSION['userData']['user_id']);
            $aLog['log_action'] = 1; // 1= new insert table 2=update table
            $aResponse['log'] = $this->audit->create($aLog);
        }
        session_destroy();
        redirect('user_login');
        exit();
    }

    private function victim_list() {
        $this->validateSession();
        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Victim List',
            'page_description' => '',
            'page_keyword' => ''
        );

        $aLibraries = array(
            'plugin' => array('datepicker/bootstrap-datepicker.js', 'datepicker/datepicker.css', 'jquery.validate.min.js'),
            'css' => array('pagination'),
            'js' => array('pagination', 'global_methods', 'icms_message')
        );

        $this->Notif_model->setUserNotificationByMethodName("victim_list");
        $this->setTemplate('victim_list', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    public function recruitment_and_employer() {
        $this->validateSession();
        // 1 - admin, 2 - case encoder, 3 - case handler , 4 - case administrator, 5 - report and analytics
        $aUserLevel = array(1, 2, 3, 4);
        $this->validateUserPage($aUserLevel, false);

        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Recruitment and Employer',
            'page_description' => '',
            'page_keyword' => ''
        );

        $aLibraries = array(
            'plugin' => array('jquery.validate.min.js'),
            'css' => array('pagination'),
            'js' => array('pagination', 'global_methods', 'icms_message')
        );

        $this->Notif_model->setUserNotificationByMethodName("recruitment_and_employer");
        $this->setTemplate('recruitment_and_employer', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    public function update_case() {
        $this->validateSession();
        // 1 - admin, 2 - case encoder, 3 - case handler , 4 - case administrator, 5 - report and analytics
        $aUserLevel = array(1, 2, 3, 4);
        $this->validateUserPage($aUserLevel, false);

        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Update Case',
            'page_description' => '',
            'page_keyword' => ''
        );

        $aLibraries = array(
            'plugin' => array('case_datepicker/jquery.datetimepicker.full.js', 'jquery.validate.min.js', 'chosen/chosen.min.css', 'chosen/chosen.jquery.min.js', 'Bs-stepper/css/bs-stepper.min.css', 'Bs-stepper/js/index.js', 'case_datepicker/jquery.datetimepicker.css'),
            'css' => array('croppie', 'pagination'),
            'js' => array('pagination', 'croppie', 'global_methods', 'icms_message'),
            'sub_js' => true
        );

        if (!empty($this->uri->rsegments[3]) !== false) {
            $aParam = [];
            $this->load->model('administrator/Case_details_model');
            $aRecordSet['case_id'] = $this->uri->rsegments[3];
            $aParam['caseid'] = $this->yel->decrypt_param($aRecordSet['case_id']);

            // Validate Case Url by User 
            $this->checkCaseUrl($aParam['caseid']);

            $aRecordSet['case_number'] = $this->Case_details_model->getCaseNumberByCaseId($aParam);
            $aRecordSet['victim_id'] = $this->yel->encrypt_param($this->Case_model->getVictimIDByCaseId($aParam['caseid']));

            $this->Notif_model->setUserNotificationByMethodAndId("update_case", $aParam['caseid']);

            $this->setTemplate('update_case', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
        } else {
            redirect('cases');
            exit();
        }
    }

    private function checkCaseUrl($caseid) {
        $user_level = $_SESSION['userData']['user_level_id'];
        if ($user_level !== '1') {
            $count = $this->yel->checkUserIsTag($caseid);
            if ($count <= 0) {
                redirect('access_denied');
                //die('Sorry you are not allowed in this case');
            }
        }
    }

    private function testEmail() {
        $aEmail['to'] = array('kimberly.bado@s2-tech.com');
        $aEmail['subject'] = 'Subject';
        $aEmail['message'] = ' Hi,  <br><br> Welcome to ICMS System.  <br>';
        $aEmail['message'] .= '<br> Here is your Username: Test <br>';
        $aEmail['message'] .= 'To Activate your account and Set your Password, use this <a href="' . __buildLink('account_activation', "?access_code=" . 'test') . '">link </a> .';
        $aEmail['message'] .= 'Navigate to this <a href="' . __buildLink('account_activation', "?access_code=" . 'test') . '">link </a> : ' . __buildLink('account_activation', "?access_code=" . 'test') . '<br><br>';
        $aEmail['message'] .= '<br> Job opps  <br> Support Team <br> ';
        $aResponse['mail'] = $this->mailbox->sendMail($aEmail);

        print_r($aResponse);
    }

    private function testEmailWithTemplate() {
        $aEmail['to'] = array('kimberly.bado@s2-tech.com');
        $aEmail['subject'] = 'Account Verified';
        $aEmail['data']['recipient_name'] = 'Jaycee';
        $aEmail['data']['login_link'] = ' <a href="' . COMPANY_SITE_URL . 'login' . '" style="background-color:#dcb026;color:#ffffff;text-decoration:none;padding:7px 30px;border-radius:30px;text-transform:uppercase">Login</a>';
        $this->mailbox->sendEmailWithTemplate('email_verification', $aEmail);

        print_r($aResponse);
    }

    private function developers_page() {
        $this->validateSession();
        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Developers Page',
            'page_description' => '',
            'page_keyword' => ''
        );

        $aLibraries = array(
            'plugin' => array('jquery.validate.min.js', 'icheck.js'),
            'css' => array(''),
            'js' => array('global_methods', 'icms_message')
        );

        $this->setTemplate('developers_page', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    public function generate_report() {
        $this->validateSession();
        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Generate Report',
            'page_description' => '',
            'page_keyword' => ''
        );

        $aLibraries = array(
            'plugin' => array('jquery.validate.min.js', 'icheck.js', 'Chart.js', 'moment.min.js', 'report_datepicker/daterangepicker.css', 'report_datepicker/vendor.js', 'report_datepicker/daterangepicker.js', 'amcharts4/core.js', 'amcharts4/charts.js', 'amcharts4/themes/animated.js'),
            'css' => array('pagination'),
            'js' => array('pagination', 'global_methods', 'icms_message', 'xlsx.core.min', 'jhxlsx', 'FileSaver')
        );

        $this->setTemplate('generate_report', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    private function messages() {
        $this->validateSession();
        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Messages',
            'page_description' => '',
            'page_keyword' => ''
        );

        $aLibraries = array(
            'plugin' => array('jquery.validate.min.js'),
            'css' => array(''),
            'js' => array('global_methods', 'icms_message')
        );

        $this->setTemplate('messages', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    private function testEmailAgency() {
        $aNewParam['case_number'] = 'CN13123123123';
        $aParam['agency_branch_id'] = 34;
        $adminBranchUsers = $this->Users_model->getAdminUsersByAgencyBranchId($aParam);
        foreach ($adminBranchUsers as $k => $v) {

            $aEmail['to'] = $v['user_email'];
            $aEmail['subject'] = 'New case added';
            $aEmail['message'] = 'Hi ' . $v['user_firstname'] . ',  <br><br> A new case has been added in the system with case number (' . $aNewParam['case_number'] . ') by ' . $this->session->userdata('user_firstname') . ' ' . $this->session->userdata('user_lastname') . ' of ' . $this->session->userdata('agency_name') . ' (' . $this->session->userdata('agency_branch_name') . ').  <br>';
            $aEmail['message'] .= '<br>To view details of the case, login to ICMS using your account and search using the case number.<br>';
            $aResponse['mail'] = $this->mailbox->sendMail($aEmail);
        }

        $taggedAgencyBranches = array('9', '34');

        foreach ($taggedAgencyBranches as $k => $v) {
            $aParam['agency_branch_id'] = $v;
            echo $v . '<br>';
            $taggedAgencyBranchesAdmin = $this->Users_model->getAdminUsersByAgencyBranchId($aParam);
            foreach ($taggedAgencyBranchesAdmin as $k => $vv) {
                echo $vv['user_email'] . '<br>';
                $aEmail['to'] = $vv['user_email'];
                $aEmail['subject'] = 'New tagged case added';
                $aEmail['message'] = 'Hi ' . $vv['user_firstname'] . ',  <br><br>Your agency has been tagged in a new case filed by ' . $this->session->userdata('user_firstname') . ' ' . $this->session->userdata('user_lastname') . ' of ' . $this->session->userdata('agency_name') . ' (' . $this->session->userdata('agency_branch_name') . '). A trafficked person with case number (' . $aNewParam['case_number'] . ') is in need of your help. ';
                $aEmail['message'] .= 'You may login to ICMS using your account to see more details about the case.';
                $aResponse['mail'] = $this->mailbox->sendMail($aEmail);
            }
        }
    }

    private function test() {
        $a = $this->yel->encrypt('1010');
        echo $a . '<br>' . $this->yel->_decryptor($a);
    }

    public function view_victim_services() {
        $this->validateSession();
        $aRecordSet = [];
        $aParam = [];
        $aParam['case_id'] = $this->yel->decrypt_param($this->uri->rsegments[3]);
        $aParam['victim_id'] = $this->yel->decrypt_param($this->uri->rsegments[4]);

        // Validate Case Url by User 
        $this->checkCaseUrl($aParam['case_id']);

        $this->Notif_model->setUserNotificationByMethodAndId("view_victim_services", $aParam['case_id']);
        $this->Notif_model->setUserNotificationByMethodAndId("view_victim_services", $aParam['victim_id']);

        if (empty($aParam['case_id']) == true || empty($aParam['victim_id']) == true) {
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $aSEO = array(
                'page_title' => 'Services provided to victim',
                'page_description' => '',
                'page_keyword' => ''
            );

            $aLibraries = array(
                'plugin' => array('case_datepicker/jquery.datetimepicker.full.js', 'case_datepicker/jquery.datetimepicker.css', 'jquery.validate.min.js'),
                'css' => array(''),
                'js' => array('global_methods', 'icms_message')
            );
            $aRecordSet['userLogLink'] = $this->uri->rsegments[3] . "/" . $this->uri->rsegments[4];
            $aRecordSet['case_details'] = $this->Case_model->getCaseDetailsByCaseID($aParam['case_id']);
            $aRecordSet['case_details']['case_id'] = $this->uri->rsegments[3];
            $aRecordSet['victim_details'] = $this->Case_model->getVictimDetailsByVictimID($aParam['victim_id']);
            $aRecordSet['victim_details']['victim_id'] = $this->uri->rsegments[4];
            $aRecordSet['case_victim'] = $this->Case_model->getCaseVictimDetails($aParam);
            $aRecordSet['case_victim']['case_victim_id'] = $this->yel->encrypt_param($aRecordSet['case_victim']['case_victim_id']);
            $this->setTemplate('view_victim_services', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
        }
    }

    public function activity_logs() {
        $this->validateSession();
        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Activity Logs',
            'page_description' => '',
            'page_keyword' => ''
        );

        $aLibraries = array(
            'plugin' => array('jquery.validate.min.js'),
            'css' => array(''),
            'js' => array('global_methods', 'icms_message')
        );

        $this->setTemplate('activity_logs', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    public function criminal_case_list() {
        $this->validateSession();
        // 1 - admin, 2 - case encoder, 3 - case handler , 4 - case administrator, 5 - report and analytics
        $aUserLevel = array(1, 2, 3, 4);
        $this->validateUserPage($aUserLevel, false);

        $aRecordSet = [];
        $aSEO = array(
            'page_title' => 'Criminal Case',
            'page_description' => '',
            'page_keyword' => ''
        );

        $aLibraries = array(
            'plugin' => array('jquery.validate.min.js', 'case_datepicker/jquery.datetimepicker.full.js', 'case_datepicker/jquery.datetimepicker.css'),
            'css' => array('pagination'),
            'js' => array('pagination', 'global_methods', 'icms_message')
        );

        $this->setTemplate('legal_services', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    public function legal_services_logs() {
        $this->validateSession();
        // 1 - admin, 2 - case encoder, 3 - case handler , 4 - case administrator, 5 - report and analytics
        $aUserLevel = array(1, 2, 3, 4);
        $this->validateUserPage($aUserLevel, false);

        $decrypted = [];
        if (isset($this->uri->rsegments[3]) == true) {
            $json = $this->yel->decrypt_param($this->uri->rsegments[3]);

            if (empty($json) == true) {
                redirect('cases');
            } else {
                $decrypted = json_decode($json);
            }
        } else {
            redirect('cases');
        }

        $aRecordSet = [];
        $aRecordSet['log_details']['case_services'] = (array) $decrypted;

        $aRecordSet['log_details']['case_details'] = $this->Case_model->getCaseDetailsByCaseID($decrypted->case_id);
        $victim = $this->Victims_model->getVictimRealNamebyId($decrypted->victim_id);
        if (empty($victim) == true) {
            $victim = $this->Victims_model->getVictimAssumedNamebyId($decrypted->victim_id);
        }
        $aRecordSet['log_details']['victim_details'] = $victim;

        // Validate Case Url by User 
        $this->checkCaseUrl($decrypted->case_id);

        $aSEO = array(
            'page_title' => 'Services Logs',
            'page_description' => '',
            'page_keyword' => ''
        );

        $aLibraries = array(
            'plugin' => array('jquery.validate.min.js'),
            'css' => array(''),
            'js' => array('global_methods', 'icms_message')
        );

        $this->setTemplate('legal_services_logs', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    public function trial_logs() {
        $this->validateSession();
        // 1 - admin, 2 - case encoder, 3 - case handler , 4 - case administrator, 5 - report and analytics
        $aUserLevel = array(1, 2, 3, 4);
        $this->validateUserPage($aUserLevel, false);

        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Trial Logs',
            'page_description' => '',
            'page_keyword' => ''
        );

        $aLibraries = array(
            'plugin' => array('jquery.validate.min.js'),
            'css' => array(''),
            'js' => array('global_methods', 'icms_message')
        );

        $this->setTemplate('trial_logs', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    public function legal_services_archived() {
        $this->validateSession();
        // 1 - admin, 2 - case encoder, 3 - case handler , 4 - case administrator, 5 - report and analytics
        $aUserLevel = array(1);
        $this->validateUserPage($aUserLevel, false);

        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Legal Sevices Archived',
            'page_description' => '',
            'page_keyword' => ''
        );

        $aLibraries = array(
            'plugin' => array('jquery.validate.min.js'),
            'css' => array('pagination'),
            'js' => array('pagination', 'global_methods', 'icms_message')
        );

        $this->setTemplate('legal_services_archived', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    public function admin_case() {
        $this->validateSession();
        // 1 - admin, 2 - case encoder, 3 - case handler , 4 - case administrator, 5 - report and analytics
        $aUserLevel = array(1, 2, 3, 4);
        $this->validateUserPage($aUserLevel, false);

        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Administrative Case',
            'page_description' => '',
            'page_keyword' => ''
        );


        $this->Notif_model->setUserNotificationByMethodName("admin_case");

        $aLibraries = array(
            'plugin' => array('case_datepicker/jquery.datetimepicker.full.js', 'case_datepicker/jquery.datetimepicker.css', 'jquery.validate.min.js'),
            'css' => array('pagination'),
            'js' => array('pagination', 'global_methods', 'icms_message')
        );

        $this->setTemplate('admin_case', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    private function admin_case_stages_old() {
        $this->validateSession();
        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'administrative case stages',
            'page_description' => '',
            'page_keyword' => ''
        );

        $aLibraries = array(
            'plugin' => array('jquery.validate.min.js'),
            'css' => array(''),
            'js' => array('global_methods', 'icms_message')
        );

        $this->setTemplate('admin_case_stages', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    private function blank_() {
        $this->validateSession();
        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Blank',
            'page_description' => '',
            'page_keyword' => ''
        );

        $aLibraries = array(
            'plugin' => array('jquery.validate.min.js'),
            'css' => array(''),
            'js' => array('global_methods', 'icms_message')
        );

        $this->setTemplate('blank_', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    public function reintegration_archived() {
        $this->validateSession();
        // 1 - admin, 2 - case encoder, 3 - case handler , 4 - case administrator, 5 - report and analytics
        $aUserLevel = array(1);
        $this->validateUserPage($aUserLevel, false);

        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Reintegration Service Archived',
            'page_description' => '',
            'page_keyword' => ''
        );

        $aLibraries = array(
            'plugin' => array('jquery.validate.min.js'),
            'css' => array('pagination'),
            'js' => array('pagination', 'global_methods', 'icms_message')
        );

        $this->setTemplate('reintegration_archived', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    public function download_case() {

        $this->validateSession();
        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Download',
            'page_description' => 'Download ',
            'page_keyword' => ''
        );

        $aLibraries = array(
            'plugin' => array('jspdf.js', 'jquery.validate.min.js'),
            'css' => array(''),
            'js' => array('global_methods', 'icms_message')
        );

        $this->setTemplate('download_case', $aRecordSet, null, false, false, false, false, false, $aLibraries, $aSEO);
    }

    public function criminal_case_stages() {
        $this->validateSession();
        // 1 - admin, 2 - case encoder, 3 - case handler , 4 - case administrator, 5 - report and analytics
        $aUserLevel = array(1, 2, 3, 4);
        $this->validateUserPage($aUserLevel, false);

        $aRecordSet = [];
        $aSEO = array(
            'page_title' => 'Criminal Case Stages',
            'page_description' => '',
            'page_keyword' => ''
        );

        $aLibraries = array(
            'plugin' => array('case_datepicker/jquery.datetimepicker.full.js', 'jquery.validate.min.js', 'case_datepicker/jquery.datetimepicker.css'),
            'css' => array(''),
            'js' => array('global_methods', 'icms_message')
        );

        $this->setTemplate('trial_logs_new', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    public function admin_case_stages() {
        $this->validateSession();
        // 1 - admin, 2 - case encoder, 3 - case handler , 4 - case administrator, 5 - report and analytics
        $aUserLevel = array(1, 2, 3, 4);
        $this->validateUserPage($aUserLevel, false);

        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Administrative Case Stages',
            'page_description' => '',
            'page_keyword' => ''
        );

        $aLibraries = array(
            'plugin' => array('case_datepicker/jquery.datetimepicker.full.js', 'case_datepicker/jquery.datetimepicker.css', 'jquery.validate.min.js'),
            'css' => array(''),
            'js' => array('global_methods', 'icms_message')
        );

        $this->Notif_model->setUserNotificationByMethodName("admin_case_stages");

        $this->setTemplate('admin_case_stages_new', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    public function report_details() {
        $this->validateSession();
        // 1 - admin, 2 - case encoder, 3 - case handler , 4 - case administrator, 5 - report and analytics
        $aUserLevel = array(1, 2, 3, 4);
        $this->validateUserPage($aUserLevel, false);

        if (!empty($this->uri->rsegments[3]) !== false) {
            $aParam['case_id'] = $this->yel->decrypt_param($this->uri->rsegments[3]);

            // Validate Case Url by User 
            $this->checkCaseUrl($aParam['case_id']);

            $this->Notif_model->setUserNotificationByMethodAndId("report_details", $aParam['case_id']);

            $aSEO = array(
                'page_title' => 'Report Details',
                'page_description' => '',
                'page_keyword' => ''
            );
            $aRecordSet = [];
            $aLibraries = array(
                'plugin' => array(''),
                'css' => array(''),
                'js' => array('global_methods', 'icms_message')
            );
            $aRecordSet['case_id'] = $this->uri->rsegments[3];
            $this->setTemplate('report_details', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
        } else {
            redirect('cases');
            exit();
        }
    }

    public function access_denied() {

        $this->validateSession();
        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Access Denied',
            'page_description' => 'Access Denied ',
            'page_keyword' => ''
        );
        $aLibraries = [];

        $this->setTemplate('access_denied', $aRecordSet, null, false, false, false, false, false, $aLibraries, $aSEO);
    }
    
    public function backend_tester(){
        $this->validateSession();
        // 1 - admin, 2 - case encoder, 3 - case handler , 4 - case administrator, 5 - report and analytics
        $aUserLevel = array(1);
        $this->validateUserPage($aUserLevel, false);

        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Backend Tester',
            'page_description' => '',
            'page_keyword' => ''
        );

        $aLibraries = array(
            'plugin' => array('jquery.validate.min.js', 'chosen/chosen.min.css', 'chosen/chosen.jquery.min.js'),
            'css' => array('croppie', 'pagination'),
            'js' => array('pagination', 'croppie', 'global_methods', 'icms_message')
        );

        $this->setTemplate('backend_tester', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }

    public function temporary_cases() {

        $this->validateSession();
        // 1 - admin, 2 - case encoder, 3 - case handler , 4 - case administrator, 5 - report and analytics
        $aUserLevel = array(1, 2, 3, 4);
        $this->validateUserPage($aUserLevel, false);

        $aRecordSet = [];

        $aSEO = array(
            'page_title' => 'Temporary Cases',
            'page_description' => '',
            'page_keyword' => ''
        );

        $aLibraries = array(
            'plugin' => array('jquery.validate.min.js',
                'dateFormat.js',
                'report_datepicker/daterangepicker.css',
                'report_datepicker/vendor.js',
                'report_datepicker/daterangepicker.js',
                'case_datepicker/jquery.datetimepicker.full.js',
                'case_datepicker/jquery.datetimepicker.css',
                'select2_/select2.full.js',
                'select2_/select2.full.min.js',
                'select2_/select2.js',
                'report_datepicker/daterangepicker.css', 
                'report_datepicker/daterangepicker.js',
                'chosen/chosen.min.css', 
                'chosen/chosen.jquery.min.js',
                'select2_/select2.min.js'),
            'css' => array('pagination',
                'select2_/select2.css'),
            'js' => array('pagination', 'global_methods', 'icms_message', 'dg')
        );
        
        $this->setTemplate('temporary_cases', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
    }
    
    public function temporary_case() {
        $aParam = [];
        $this->validateSession();
        // 1 - admin, 2 - case encoder, 3 - case handler , 4 - case administrator, 5 - report and analytics
        $aUserLevel = array(1, 2, 3, 4);
        $this->validateUserPage($aUserLevel, false);
        
        if (!empty($this->uri->rsegments[3]) !== false) {
            $aParam['temporary_case_id'] = $this->yel->decrypt_param($this->uri->rsegments[3]);

            if(!$aParam['temporary_case_id']){
                // invalid url 
                redirect('temporary_cases');
                exit();
            }

            // Validate Case Url by User 
            $temp_case = $this->Global_data_model->getTemporaryCase($aParam);

            if(!isset($temp_case['temporary_case_id'])){
                // invalid temporary case id  
                redirect('temporary_cases');
                exit();
            }

            $aSEO = array(
                'page_title' => 'Temporary Case Details',
                'page_description' => '',
                'page_keyword' => ''
            );
            $aRecordSet = [];
            $aLibraries = array(
//                'plugin' => array('jquery.validate.min.js'),

              'plugin' => array('jquery.validate.min.js',
                'dateFormat.js',
                'case_datepicker/jquery.datetimepicker.full.js',
                'case_datepicker/jquery.datetimepicker.css',
            ),
              'css' => array(''),
              'js' => array('global_methods', 'icms_message', 'dg')
          );
            $aRecordSet['id'] = $this->uri->rsegments[3];
            $this->setTemplate('temporary_case', $aRecordSet, null, true, true, true, false, false, $aLibraries, $aSEO);
        } else {
            redirect('temporary_cases');
            exit();
        }
    }


    

}