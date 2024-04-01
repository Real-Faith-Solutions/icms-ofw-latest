<?php
//echo "<pre>";
//print_r($_SESSION);
/**
 * Page Security
 */
//echo $this->yel->encrypt("a");
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Administrator|Login</title>
    <!--    <link rel="stylesheet" href="<?= MAIN_SITE_URL ?>assets/global/template/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= MAIN_SITE_URL ?>assets/library/fonts/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?= MAIN_SITE_URL ?>assets/library/fonts/fontawesome/css/fontawesome.css">
    <link rel="stylesheet" href="<?= SITE_ASSETS ?>library/fonts/fontawesome/css/all.css">
    <link rel="stylesheet" href="<?= MAIN_SITE_URL ?>assets/modules/administrator/css/user_login.css">-->

    <link rel="stylesheet" href="<?= SITE_ASSETS ?>global/template/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= SITE_ASSETS ?>library/fonts/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?= SITE_ASSETS ?>library/fonts/fontawesome/css/fontawesome.css">
    <link rel="stylesheet" href="<?= SITE_ASSETS ?>library/fonts/fontawesome/css/all.css">
    <link rel="stylesheet" href="<?= SITE_ASSETS ?>modules/administrator/css/user_login.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body class="bg-white overflow-hidden row">
    <!-- start of UI design modal for 2 factor auth -->
    <!-- OTP Modal -->
        <div class="container d-flex align-items-center justify-content-center" style="height: 100vh;">
        <div class="text-center">
                <h4 class="card-title text-dark text-center">Two-Factor Authentication</h4>
                <p>Please enter the 6-digit verification code we sent via email</p>
                <small></small><br>
                <form class="mt-1" id="twofactorauth">
                    <div class="d-flex">
                        <div class="m-auto">
                            <input class="inp-code-1 inp-cd mr-1 text-center py-3" type="text" maxLength="1" size="5" min="0"
                                max="9" pattern="[0-9]{1}" />
                            <input class="inp-code-2 inp-cd mr-1 text-center py-3" type="text" maxLength="1" size="5" min="0"
                                max="9" pattern="[0-9]{1}" />
                            <input class="inp-code-3 inp-cd mr-1 text-center py-3" type="text" maxLength="1" size="5" min="0"
                                max="9" pattern="[0-9]{1}" />
                            <input class="inp-code-4 inp-cd mr-1 text-center py-3" type="text" maxLength="1" size="5" min="0"
                                max="9" pattern="[0-9]{1}" />
                            <input class="inp-code-5 inp-cd mr-1 text-center py-3" type="text" maxLength="1" size="5" min="0"
                                max="9" pattern="[0-9]{1}" />
                            <input class="inp-code-6 inp-cd mb-3 mr-1 text-center py-3" type="text" maxLength="1" size="5"
                                min="0" max="9" pattern="[0-9]{1}" />
                        </div>
                    </div>
                    <br>
                    <button type="button"
                        class="btn btn-primary mt-3 d-flex m-auto px-5 btn-verify-twofa">Verify</button>
                </form>
                <br>
                <!-- <a href="#" class="text-blue btn-send_via_email d-flex justify-content-end">
                    <small>Send OTP via email address</small></a> -->

                <div>
                    <p id="otp_count"></p>
                </div>


                <div class="text-center">
                    Didn't receive the code?<br />
                    <button class="btn btn-resend-twofa btn-link"><small>Send code again</small></a><br />
                        <!-- <a href="#"><small>Change phone number</small></a> -->
                </div>
        </div>
        </div>



</body>

<footer>
    <div class="modal" id="msgmodal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h5-title"> Please wait...</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="p-msg">
                    </p>
                </div>
            </div>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // i add auto next input if the input fill was inputed
    $(document).ready(function () {
        $('.inp-cd').on('input', function () {
            var maxLength = parseInt($(this).attr('maxLength'));
            var inputValue = $(this).val();
            if (inputValue.length >= maxLength) {
                $(this).next('.inp-cd').focus();
            }
        });
    });
</script>


    <script src="<?= SITE_ASSETS ?>global/jquery/jquery.js"></script>
    <script src="<?= SITE_ASSETS ?>global/jquery/jquery.min.js"></script>
    <script src="<?= SITE_ASSETS ?>global/template/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= SITE_EXT_LIBRARY_PLUGIN ?>jquery.validate.min.js"></script>
    <script src="<?= SITE_ASSETS ?>library/js/global_methods.js" type="text/javascript"></script>
    <script src="<?= SITE_ASSETS ?>library/js/icms_message.js" type="text/javascript"></script>
    <script src="<?= SITE_ASSETS ?>modules/administrator/js/config.js"></script>
    <script src="<?= SITE_ASSETS ?>modules/administrator/js/user_login.js"></script>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
</footer>

</html>