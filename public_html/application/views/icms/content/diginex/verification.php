<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    
    <!-- <link rel="stylesheet" href="<?= MAIN_SITE_URL ?>assets/global/template/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= MAIN_SITE_URL ?>assets/library/fonts/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?= MAIN_SITE_URL ?>assets/library/fonts/fontawesome/css/fontawesome.css">
    <link rel="stylesheet" href="<?= SITE_ASSETS ?>library/fonts/fontawesome/css/all.css">
    <link rel="stylesheet" href="<?= MAIN_SITE_URL ?>assets/modules/icms/css/verification.css"> -->

    <link rel="stylesheet" href="http://iacat-icms.com/assets/global/template/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://iacat-icms.com/assets/library/fonts/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="http://iacat-icms.com/assets/library/fonts/fontawesome/css/fontawesome.css">
    <link rel="stylesheet" href="<?= SITE_ASSETS ?>library/fonts/fontawesome/css/all.css">
    <link rel="stylesheet" href="http://iacat-icms.com/assets/modules/icms/css/result_page.css">
</head>

<body>
    <img src="assets/global/images/public_bg.jpg" alt="Girl in a jacket" width="100%" height="100%" class="bg-landing">

    <!-- <div class="masthead">
    </div> -->

    <div class="masthead">
        <div class="masthead-content- masthead_inner text-white">
            <div class="container-fluid px-4 px-lg-0">
                <div class="card pb-0">

                    <div class="card-body card-verify card-email p-5 hidden">
                        <h4 class="card-title text-dark">OTP Verification</h4><br>
                        <form>
                            <div class="form-group">
                                <label for="">Email address</label><span class="text-danger"> *</span>
                                <input type="email" class="form-control" id="" aria-describedby=""
                                    placeholder="Enter email">
                            </div>
                            <button type="" class="btn btn-primary d-flex m-auto px-5 btn-send">Send</button>
                        </form>
                        <br>
                        <!-- <a href="#" class="text-blue btn-send_via_mobile d-flex justify-content-end">
                            <small>Send OTP via mobile number</small></a> -->
                    </div>
                    <!-- <div class="card-body card-verify card-mobile p-5 hidden">
                        <h4 class="card-title text-dark">OTP Verification</h4><br>
                        <form>
                            <div class="form-group">
                                <label for="">Mobile Number</label><span class="text-danger"> *</span>
                                <input type="text" class="form-control" id="" aria-describedby=""
                                    placeholder="Enter mobile number">
                            </div>
                            <button type="" class="btn btn-primary d-flex m-auto px-5 btn-send">Send</button>
                        </form>
                        <br>
                        <a href="#" class="text-blue btn-send_via_email d-flex justify-content-end">
                            <small>Send OTP via email address</small></a>
                    </div> -->
                    <div class="card-body card-otp p-5 ">
                        <h4 class="card-title text-dark">OTP Sending</h4>
                        <small>Please enter the 6-digit verification code we sent</small><br>
                        <form class="mt-1">
                            <div class="d-flex">
                                <div class="m-auto">
                                    <input class="inp-code-1 inp-cd mr-1" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                                    <input class="inp-code-2 inp-cd mr-1" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                                    <input class="inp-code-3 inp-cd mr-1" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                                    <input class="inp-code-4 inp-cd mr-1" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                                    <input class="inp-code-5 inp-cd mr-1" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                                    <input class="inp-code-6 inp-cd mb-3 mr-1" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                                </div>
                            </div>


                            <br>
                            <button type="button"
                                class="btn btn-primary mt-3 d-flex m-auto px-5 btn-send-verify">Verify</button>
                        </form>
                        <br>
                        <!-- <a href="#" class="text-blue btn-send_via_email d-flex justify-content-end">
                            <small>Send OTP via email address</small></a> -->

                        <div>
                            <p id="otp_count"></p>
                        </div>


                        <div class="text-center">
                            Didn't receive the code?<br />
                            <button class="btn btn-resend btn-link"><small>Send code again</small></a><br />
                                <!-- <a href="#"><small>Change phone number</small></a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>