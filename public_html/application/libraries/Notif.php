<?php

/**
 * Page Security
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Notification 
 *
 * @author eBusiness Team
 */
class Notif extends CI_Controller
{

    // constant
    const SUCCESS_RESPONSE = 1;
    const FAILED_RESPONSE = 0;

    // load yel framework
    private $yel;
    private $CI;

    // form load 
    public function __construct()
    {

        // load yel for sanitization
        $this->yel = new Yel();

        // instance loader
        $this->CI = &get_instance();

        // load models
        $this->CI->load->model('Notif_model');
        $this->CI->load->model('administrator/Temporary_case_model');
    }

    /**
     * Create notification
     * 
     * @param string $aParam
     * @return array $aResponse
     */
    public function create($aParam)
    {

        // global
        $aResponse = [];

        // initial flag 
        $aResponse['flag'] = self::FAILED_RESPONSE;

        // sanitize 
        $aParam = $this->yel->safe_mode_clean_array($aParam);


        if (empty($aParam['msg']) !== false) {
            $aResponse['message'] = '[LOG] message is required';
            return $aResponse;
        }

        // recvr must be csv format
        if (empty($aParam['receiver']) !== false) {
            $aResponse['message'] = '[LOG] receiver id is required';
            return $aResponse;
        }

        if (isset($aParam['method']) == false) {
            $aParam['method'] = "";
        }
        if (isset($aParam['tbl_id']) == false) {
            $aParam['tbl_id'] = "";
        }


        //set value for sender
        $aParam['sender_branch_id'] = $_SESSION['userData']['agency_branch_id'];
        $aParam['sender_id'] = $_SESSION['userData']['user_id'];
        $aResponse = $this->CI->Notif_model->createNotification($aParam);
        return $aResponse;
    }

    /**
     * fetch unread notification limit to 5
     * @return array $aResponse
     */
    public function getUnreadNotification()
    {
        $aResponse = [];
        $user_id = $_SESSION['userData']['user_id'];
        $aResponse = $this->CI->Notif_model->getUnreadNotification($user_id);

        foreach ($aResponse['list'] as $key => $val) {
            $aResponse['list'][$key]['notification_id'] = $this->yel->encrypt_param($val['notification_id']);
        }
        return $aResponse;
    }

    /**
     * fetch all  notifications
     * 
     * @param string $aParam
     * @return array $aResponse
     */
    public function getUserNotification($aParam)
    {
        $aResponse = [];
        $aParam['user_id'] = $_SESSION['userData']['user_id'];
        $aResponse = $this->CI->Notif_model->getUserNotification($aParam);
        foreach ($aResponse['list'] as $key => $val) {
            $aResponse['list'][$key]['notification_id'] = $this->yel->encrypt_param($val['notification_id']);
        }
        return $aResponse;
    }

    /**
     * set  notification as read
     * 
     * @notif_id string $notif_id =unique id of a notification
     * @readType string $notif_id =1 for read single // 2 for  read all
     * 
     * @return array $aResponse
     */
    public function setUserNotificationAsRead($notif_id, $readType)
    {
        $aResponse = [];
        if ($readType == "1") {
            $notif_id = $this->yel->decrypt_param($notif_id);
            $aResponse = $this->CI->Notif_model->setUserNotificationAsRead($notif_id);
        } else {
            $user_id = $_SESSION['userData']['user_id'];
            $aResponse = $this->CI->Notif_model->setAllUserNotificationAsRead($user_id);
        }

        return $aResponse;
    }

    /**
     * Send Notification to Victim
     * 
     * @notif_id string $notif_id =unique id of a notification
     * @readType string $notif_id =1 for read single // 2 for  read all
     * 
     * @return array $aResponse
     */
    public function sendNotificationToVictim($aParam)
    {
        $msg = "";
        $case_info = [];
        $case_info['track_number'] = "";

        if ($aParam['id_type'] == "temporary_case_id") {
            // Get Temporary Case Info
            $case_info =  $this->CI->Temporary_case_model->getTemporaryCaseByTemporaryCaseId(["temporary_case_id" => $aParam["id"]]);
            if (!isset($case_info['temporary_case_id'])) {
                return array("message" => "No data found using temporary_case_id :" . $aParam["id"]);
            }
            $case_info['track_number'] = $case_info['temporary_case_number'];
            $case_info['created_at'] = convert_date_format($case_info['temporary_case_date_added'], 'F j, Y', 'date');
            $case_info['mobile_no'] = $case_info['temporary_complainant_mobile_number'];
            $case_info['email'] = $case_info['temporary_complainant_email_address'];
            $case_info['source'] = "complainant - temporary case";
        } else if ($aParam['id_type'] == "case_id") {
            // Get Case Info
            $case_info =  $this->CI->Temporary_case_model->getTemporaryCaseByCaseId(["case_id" => $aParam["id"]]);
            if (!isset($case_info['case_id'])) {
                // 3 email // 1 cellphone 
                $case_info =  $this->CI->Notif_model->getVictimContactInformation(["case_id" => $aParam["id"]]);
                $case_info['track_number'] = $this->CI->Temporary_case_model->getCaseNumberByCaseID(["case_id" => $aParam["id"]]); 
                $case_info['source'] = "victim - case";
            } else {
                $case_info['track_number'] = $case_info['temporary_case_number'];
                $case_info['source'] = "complainant - temporary case";
            }
            $case_info['created_at'] = convert_date_format($case_info['temporary_case_date_added'], 'F j, Y', 'date');
            $case_info['mobile_no'] = $case_info['temporary_complainant_mobile_number'];
            $case_info['email'] = $case_info['temporary_complainant_email_address'];
        } else if ($aParam['id_type'] == "case_victim_id") {
            // Get Case Info
            $case_info =  $this->CI->Temporary_case_model->getTemporaryCaseByCaseVictimId(["case_victim_id" => $aParam["id"]]);
            if (!isset($case_info['case_id'])) {
                // 3 email // 1 cellphone 
                $case_info =  $this->CI->Notif_model->getVictimContactInformation(["case_id" => $case_info["case_id"]]);
                $case_info['track_number'] = $this->CI->Temporary_case_model->getCaseNumberByCaseID(["case_id" => $case_info["case_id"]]); 
                $case_info['source'] = "victim - case";
            } else {
                $case_info['track_number'] = $case_info['temporary_case_number'];
                $case_info['source'] = "complainant - temporary case";
            }
            $case_info['created_at'] = convert_date_format($case_info['temporary_case_date_added'], 'F j, Y', 'date');
            $case_info['mobile_no'] = $case_info['temporary_complainant_mobile_number'];
            $case_info['email'] = $case_info['temporary_complainant_email_address'];
        }

        switch ($aParam['notif_type']) {
            case "temp-status":
                if (isset($case_info['created_at'])) {
                    $msg = "The status of the case you have filed on " . $case_info['created_at'] . " with the number (TN/CN) has been updated. Please go to (public website) for more information. Thank you.";
                }
                break;
            case "add-service":
                $msg = "A service has been added to your case with the number (TN/CN). Please go to (public website) for more information. Thank you.";
                break;
            case "service-status":
                $msg = "A service being provided to your case with the number (TN/CN) has changed status. Please go to (public website) for more information. Thank you.";
                break;
            case "create-temp":
                $msg = "You have successfully filed a complaint. IACAT will conduct further verification for this case. Your reference number is  (TN/CN). Please keep your line open. Thank you.";
                break;
            case "add-temp":
                $msg = "You have successfully filed a complaint. IACAT will conduct further verification for this case. Your reference number is  (TN/CN). Please keep your line open. Thank you";
                break;
            case "add-remarks";
                $msg = "Your case with reference number (TN/CN) has a new remark. Please check online at (public website) to know more. Thank you.";
                break;
            
        } 

        $case_info['content'] = [];

        $check = []; 
        $check['email'] = self::SUCCESS_RESPONSE; 
        $check['sms'] = self::SUCCESS_RESPONSE;  

        if ($case_info['source'] == "complainant - temporary case") {
            // 1 = mobile, 2 = email
            if ($case_info['temporary_complainant_preffered_contact_method'] == "1") {
                $check['email'] = self::FAILED_RESPONSE;  
            }else if ($case_info['temporary_complainant_preffered_contact_method'] == "2") {
                $check['sms'] = self::FAILED_RESPONSE;  
            }
        }

        // Send Email
        if (isset($case_info['email']) && $check['email'] == self::SUCCESS_RESPONSE) {

            //prepare email content and template 
            
            $content = include(MAIL_TEMPLATE . 'notification' . ".php");
            $msg = str_replace(""," Thank you.", $msg);
            $msg = str_replace("(TN/CN)", $case_info['track_number'], $msg);
            $msg = str_replace("(public website)", ICMS_SITE_URL, $msg);
            
            $content = str_replace("{{title}}","ICMS CASE UPDATE", $content);
            $content = str_replace("{{content}}", $msg, $content);
            $content = str_replace("{{content-footer}}","You can view and access your case/report information by this link " . ICMS_SITE_URL. ". Please use the case/report number above for the verification.", $content);
            
            $mail['to'] = array($case_info['email']);
            $mail['subject'] = '[CASE NOTIFICATION] INTEGRATED CASE MANAGEMENT SYSTEM';
            $mail['message'] = $content;
            $email_result = $this->CI->mailbox->sendMail($mail);
            $case_info['content']['email'] = $mail;
        }

        // Send SMS 
        if (isset($case_info['mobile_no']) && $check['sms'] == self::SUCCESS_RESPONSE) {
            $msg = str_replace("(TN/CN)", $case_info['track_number'], $msg);
            $msg = str_replace("(public website)", ICMS_SITE_URL, $msg);
            $number = $case_info['mobile_no'];
            $sms = $this->CI->smsbox->send($number,$msg);
            $case_info['content']['sms'] = $sms;
        }

        $response = array(
            "message_content" => $case_info['content'],
            "source" => $case_info['source'],
        );

        

        return $response;
    }
}
