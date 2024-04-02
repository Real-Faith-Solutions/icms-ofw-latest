<?php

/** 
 * Page Security
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * SMSbox Library
 * For Sending SMS Using Mari
 *
 * version 1.0.0
 * @author : LBS eBusiness
 */
class SMSbox
{

    // constants
    const SUCCESS = 1;
    const FAILED = 0;

    // create new object | load yel framework
    private $yel;

    public function __construct()
    {

        // load yel for sanitization
        $this->yel = new Yel();
    }

    public function send($mobile = "", $message = "")
    {
        $rs = [];
        $rs['flag'] = self::FAILED;
        if ($mobile == "") {
            $rs['message']['mobile_number'] = "Mobile number is required";
            return $rs;
        }

        if ($message == "") {
            $rs['message']['message'] = "Message is required";
            return $rs;
        }

        // check mobile number 
        $checkMobile = $this->checkMobile($mobile);
        if ($checkMobile['flag'] == self::FAILED) {
            $rs['message']['mobile_number'] = $checkMobile['log_msg'];
            return $rs;
        }

        $mobile = $checkMobile['mob_num'];
        $aSMSContent = [];
        $aSMSContent['sms_box_message'] = $message;
        $aSMSContent['sms_box_number'] = $mobile;

        return $this->addSMSBoxLog($aSMSContent);
    }

    /**
     * Add SMS Box to Database smsbox
     *
     * @param array $param
     * @var $param['sms_box_message']
     * @var $param['sms_box_number']
     *
     * @return array
     */
    private function addSMSBoxLog($param)
    {
        $rs = [];

        $sql = "
            INSERT INTO
            `sms_box`
            SET
            `sms_box_api_name` = 'MARI',
            `sms_box_relation_id` = '1',
            `sms_box_message` = '" . $param['sms_box_message'] . "',
            `sms_box_number` = '" . $param['sms_box_number'] . "',
            `sms_box_status` = '0',
            `sms_box_is_sent` = '0'
        ";
        $rs = $this->yel->exec($sql);

        return $rs;
    }

    public function checkMobile($mobile)
    {

        $rs = [];
        $number = substr($mobile, 0, 2);
        $rs['log_msg'] = 'Valid mobile number';

        if ($number == "09") {
            $rs['mob_num'] = "63" . substr($mobile, 1);
            $rs['flag'] = self::SUCCESS;
        } else if ($number === "+6") {
            $rs['mob_num'] = "63" . substr($mobile, 3);
            $rs['flag'] = self::SUCCESS;
        } else if ($number === "63") {
            $rs['mob_num'] = $mobile;
            $rs['flag'] = self::SUCCESS;
        } else {

            $rs['flag'] =    self::FAILED;
            $rs['log_msg'] = "number is unidentify and not valid ";

            $number = substr($mobile, 0, 1);
            if (($number == "9") && (strlen($mobile) == 10)) {
                $rs['mob_num'] = "63" . $mobile;
                $rs['flag'] =    self::SUCCESS;
            }
        }

        if ($rs['flag'] == self::SUCCESS) {

            if (strlen($rs['mob_num']) > 12) {
                $rs['flag'] = self::FAILED;
                $rs['log_msg'] = "number length is unappropriate, the number is longer than the standard";
            } else if (strlen($rs['mob_num']) < 12) {
                $rs['flag'] = self::FAILED;
                $rs['log_msg'] = "number length is unappropriate, the number is shorter that the standard";
            } else {
                $rs['flag'] = self::SUCCESS;
            }
        }

        return $rs;
    }
}


