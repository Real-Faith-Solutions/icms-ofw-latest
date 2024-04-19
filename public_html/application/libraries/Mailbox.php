<?php

/** 
 * Page Security
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Mailbox Library
 * For Sending Email
 *
 * version 1.0.0
 * @author : LBS eBusiness
 */
class Mailbox {

    // constants
    const SUCCESS = 1;
    const FAILED = 0;
    const MATCHED = 1;
    const UNMATCHED = 0;
    const ACTIVE = 1;
    const NEW_RECORD = 0;

    // create new object | load yel framework
    private $yel;

    public function __construct() {

        // load yel for sanitization
        $this->yel = new Yel();
    }
    
    /**
     * Requires acceptable email formats
     * - white listing of email
     *
     * @param string $sEmail
     * @return  boolean $iState
     */
    private function whiteListingEmails($sEmail) {

        $iState = self::FAILED;

        $aWhiteListedExtensions = array(
            'gmail', 'google', 'yahoo', 'ymail', 'lbs', 'ebusiness', 'rocket', 'mail', '.ph', 'business', 'tech', 'cloud', '.org', '.net', '.edu', '.com'
        );

        foreach ($aWhiteListedExtensions as $sWhilteListed) {

            if (strpos(strtolower($sEmail), $sWhilteListed) !== false) {
                $iState = self::SUCCESS;
            }
        }
        return $iState;
    }

    /**
     * Load Mail Template
     *
     * @param string $sTemplateName
     * @param array $aMailContent
     * @return mixed $aMailContent
     */
    public function sendEmailWithTemplate($sTemplateName, $aMailContent = null) {
   
        if (file_exists(MAIL_TEMPLATE . $sTemplateName . ".php") !== false) {
            $aMailContent['message'] = include(MAIL_TEMPLATE . $sTemplateName . ".php");
            //echo $aMailContent['message']; exit();
            return $this->sendMail($aMailContent);
        } else {
            return self::FAILED;
        }
    }

    /**
     * Send An Email
     * A library to send an email
     *
     * @param array $aEmail
     *    @var  boolean $aEmail['include']     : true|false
     *    @var  string  $aEmail['template']    : template
     *    @var  string  $aEmail['from']        : sender email
     *    @var  string  $aEmail['sender']      : sender name
     *    @var  array   $aEmail['to']          : list of receiver
     *    @var  string  $aEmail['subject']     : email subject
     *    @var  string  $aEmail['title']       : email title
     *    @var  string  $aEmail['message']     : email message
     *    @var  array  $aEmail['custom_message']    : email message 2 [ server as array ]
     *
     * @return array $aResponse
     */
     public function sendMail($aEmail = null) {
        // Initialize
        $aResponse = [];

        // Email template
        $sTemplate = 'theme_default';
        $aResponse['flag'] = self::FAILED;
        if (!empty($aEmail['template']) !== false) {
            if (function_exists($aEmail['template']) === true) {
                $sTemplate = $aEmail['template'];
            }
        }

        // Send email
        if (EMAIL_INCLUDE === TRUE) {
            $CI = &get_instance();
            $CI->load->library('email');

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

            // Set sender and recipient
            $CI->email->from(EMAIL_FROM_USER, EMAIL_FROM_NAME);
            $CI->email->to($aEmail['to']);
        
            // Set email subject
            $CI->email->subject($aEmail['subject']);
        
            // Formulate email content
            $CI->email->set_mailtype('html'); // Set email format to HTML
            $CI->email->message($sTemplate($aEmail['message']));
        
            // Send email
            if (!$CI->email->send()) { // changed $mail to $CI->email
                $aResponse['status'] = $CI->email->print_debugger(); // changed ErrorInfo to print_debugger
            } else {
                $aResponse['flag'] = self::SUCCESS;
                $aResponse['status'] = 'Email sent successfully.';
            }
        }

        return $aResponse;
    }
    // public function sendMail($aEmail = null) {


    //     // initialize
    //     $aResponse = [];

    //     // Email template
    //     $sTemplate = 'theme_default';
    //     $aResponse['flag'] = self::FAILED;
    //     if (!empty($aEmail['template']) !== false) {

    //         if (function_exists($aEmail['template']) === true) {
    //             $sTemplate = $aEmail['template'];
    //         }
    //     }

    //     // send email
    //     if (EMAIL_INCLUDE === TRUE) {
            
    //         // initialize
    //         $sRecipient = '';

    //         // validate parameter
    //         if (empty($aEmail['subject']) === true) {
                
    //             $aResponse['status'] = emailMessage('invalid_email_parameter')['message'];
    //             return $aResponse;
    //         }

    //         if (empty($aEmail['from']) === true) {
    //             $aEmail['from'] = EMAIL_FROM_EMAIL;
    //         }

    //         if (empty($aEmail['sender']) === true) {
    //             $aEmail['sender'] = EMAIL_FROM_NAME;
    //         }

    //         if (empty($aEmail['title']) === true) {
    //             $aEmail['title'] = '';
    //         }

    //         if (empty($aEmail['custom_message']) === true) {
    //             $aEmail['custom_message'] = null;
    //         }

    //         if (!empty($aEmail['include']) !== false) {
    //             if ($aEmail['include'] == false) {
                    
    //                 $aResponse['status'] = emailMessage('exclude_mail')['message'];
    //                 return $aResponse;
    //             }
    //         }


    //         // formulation of template based on the template name
    //         $mEmailContent = trim(preg_replace('/\s\s+/', ' ', ($sTemplate($aEmail['title'], $aEmail['message'], $aEmail['custom_message']))));




    //         // check if recepient is in array
    //         if (is_array($aEmail['to']) !== true) {


                
    //             // if [to] is not array
    //             if (!filter_var($aEmail['to'], FILTER_VALIDATE_EMAIL) !== false) {
    //                 $aResponse['status'] = emailMessage('invalid_email')['message'];
    //                 return $aResponse;
    //             }

    //             // ready to send
    //             $sRecipient = trim($aEmail['to']);


    //             // another validation
    //             if ((int) $this->checkMail($sRecipient)['flag'] != self::SUCCESS) {
    //                 $aResponse['status'] = emailMessage('invalid_email')['message'];
    //                 return $aResponse;
    //             }

    //             // prepare to mailbox
    //             $sSequel = "
    //             INSERT IGNORE INTO `icms_mailbox` SET
    //             `mailbox_receiver` = '" . $sRecipient . "',
    //             `mailbox_sender_mail` = '" . $aEmail['from'] . "',
    //             `mailbox_sender_name` = '" . $aEmail['sender'] . "',
    //             `mailbox_subject` = '" . $aEmail['subject'] . "',
    //             `mailbox_message` = '" . $mEmailContent . "'
    //             ";


    //             $aResponse['status'] = $this->yel->exec($sSequel);
    //         } else {


    //             // explode array
    //             $i = 0;
    //             foreach ($aEmail['to'] as $key => $sEmail) {



    //                 // validate email
    //                 if (!filter_var($sEmail, FILTER_VALIDATE_EMAIL) !== true) {



    //                     // another validation
    //                     if ((int) $this->checkMail($sEmail)['flag'] != self::SUCCESS) {
    //                         $aResponse['status'][$i] = emailMessage('invalid_email')['message'];

                            
    //                     } else {

    //                         $sRecipient .= ',' . $sEmail;

    //                         // add to database
    //                         $sSequel = "
    //                         INSERT IGNORE INTO `icms_mailbox` SET
    //                         `mailbox_receiver` = '" . $sEmail . "',
    //                         `mailbox_sender_mail` = '" . $aEmail['from'] . "',
    //                         `mailbox_sender_name` = '" . $aEmail['sender'] . "',
    //                         `mailbox_subject` = '" . $aEmail['subject'] . "',
    //                         `mailbox_message` = '" . $mEmailContent . "'
    //                         ";

    //                         $aResponse['status'][$i] = $this->yel->exec($sSequel);
    //                     }
    //                 }

    //                 $i++;
    //             }

    //             // reinitialize, then maintain to string
    //             $sRecipient = ltrim($sRecipient, ',');
    //         }

    //         $aResponse['flag'] = self::SUCCESS;


    //         // preview || for debugging user
    //         // $aResponse['content'] = $mEmailContent;
    //         // template checker
    //         $aResponse['template'] = $sTemplate;
    //     }

    //     return $aResponse;
    // }

    /**
     * Load Mail Template - Newsletter
     *
     * @param string $sTemplateName
     * @param array $aMailContent
     * @return mixed $aMailContent
     */
    public function sendNewsletterWithTemplate($sTemplateName, $aMailContent = null) {

        if (file_exists(MAIL_TEMPLATE . $sTemplateName . ".php") !== false) {
            $aMailContent['message'] = include(MAIL_TEMPLATE . $sTemplateName . ".php");
            //echo  $aMailContent['message']; exit();
            return $this->sendNewsLetter($aMailContent);
        } else {
            return self::FAILED;
        }
    }

    /**
     * Load Mail Template - Newsletter 
     *
     * @param string $sTemplateName
     * @param array $aMailContent
     * @return mixed $aMailContent
     */
    public function createNewsletterWithTemplate($sTemplateName, $aMailContent = null) {

        if (file_exists(MAIL_TEMPLATE . $sTemplateName . ".php") !== false) {
            $aMailContent['message'] = include(MAIL_TEMPLATE . $sTemplateName . ".php");
            //echo $aMailContent['message']; exit();
            return $this->saveNewsLetterContent($aMailContent);
        } else {
            return self::FAILED;
        }
    }

    /**
     * Mail Checker Log
     * 
     * @param array $aMail
     * @return array $aResponse
     */
    private function mailCheckerCreateLog($aMail) {

        $aResponse = [];

        $sSequel = "
            INSERT INTO `icms_mail_checker` SET
            `mail_checker_value` = '" . $aMail['mail'] . "',
            `mail_checker_log` = '" . $aMail['message'] . "',
            `mail_checker_status` = '" . $aMail['flag'] . "'
            ";

        $aResponse = $this->yel->exec($sSequel);

        return $aResponse;
    }

    /**
     * Mail Checker : Check on DB
     * 
     * @param string $mMail
     * @return array $aResponse
     */
    private function mailCheckerDB($mMail) {

        $aResponse = [];

        // sanitize
        $mMail = $this->yel->clean($mMail);

        $sSequel = "
            SELECT 
                `mail_checker_status`,
                `mail_checker_log`
            FROM 
            `icms_mail_checker`
            WHERE 
            `mail_checker_value` = '" . $mMail . "'
            ORDER BY `mail_checker_id` DESC
            LIMIT 1
            ";

        // fetch from database
        $aRecentLog = $this->yel->GetRow($sSequel);

        if (empty($aRecentLog['mail_checker_status']) !== false) {
            $aResponse['status'] = self::NEW_RECORD;
            $aResponse['log'] = "New entry";
            return $aResponse;
        }

        // return
        $aResponse['status'] = $aRecentLog['mail_checker_status'];
        $aResponse['log'] = $aRecentLog['mail_checker_log'];

        return $aResponse;
    }

    /**
     * Check mailing address
     * 
     * @param string|mixed $mEmail
     * @return type
     */
    public function checkMail($mEmail) {

        // initialize
        $aResponse = [];

        // flag indicator
        $aResponse['flag'] = self::FAILED;

        // sanitize
        $mEmail = $this->yel->clean($mEmail);

        // email
        $aResponse['mail'] = $mEmail;

        // validate email
        if (!filter_var($mEmail, FILTER_VALIDATE_EMAIL) !== false) {
            $aResponse['message'] = "Invalid Email Format.";
            $aResponse['log'] = $this->mailCheckerCreateLog($aResponse);
            return $aResponse;
        }

        // check on existing database
        $aResponse['mail_checker_db'] = $this->mailCheckerDB($mEmail);
        if ((int) $aResponse['mail_checker_db']['status'] === self::MATCHED) {
            $aResponse['message'] = "OK";
            $aResponse['flag'] = self::SUCCESS; // no need to create log hence this log is stated as OK
            return $aResponse;
        }

        // check smtp availability
        // $sAccessToken = "b62365fa7e5860b45dc4488e355e12ef";
        // $iIsSMTP = self::ACTIVE;
        // $iIsJSONFormat = self::ACTIVE;
        // $oSMTPChecker = (array) json_decode(file_get_contents("https://apilayer.net/api/check?access_key=" . $sAccessToken . "&email=" . $mEmail . "&smtp=" . $iIsSMTP . "&format=" . $iIsJSONFormat));
        // if (empty($oSMTPChecker['smtp_check']) !== false) {

        //     $aResponse['message'] = "SMTP status is inactive.";
        //     $aResponse['log'] = $this->mailCheckerCreateLog($aResponse);
        //     return $aResponse;
        // }

        // whenever the result is success
        $aResponse['message'] = "OK";
        $aResponse['flag'] = self::SUCCESS;
        $aResponse['log'] = $this->mailCheckerCreateLog($aResponse);
        return $aResponse;
    }

}
