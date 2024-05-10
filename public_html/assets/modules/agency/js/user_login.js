
function checkCapsLock(e) {

    e.addEventListener("keyup", function (event) {
        if (event.getModifierState("CapsLock")) {
            var sMessage = '*WARNING! Caps lock is ON.';
            $('.lbl-capslock').html(sMessage);
        } else {
            var sMessage = '';
            $('.lbl-capslock').html(sMessage);
        }
    });

    e.addEventListener("mousedown", function (event) {
        if (event.getModifierState("CapsLock")) {
            var sMessage = '*WARNING! Caps lock is ON.';
            $('.lbl-capslock').html(sMessage);
        } else {
            var sMessage = '';
            $('.lbl-capslock').html(sMessage);
        }
    });

}

function loginUser() {
    var user = $(".input_user").val();
    var pass = $(".input_pass").val();
    $.post(
      sAjaxAccess,
      {
        type: "getUserlogin",
        user: user,
        pass: pass,
      },
      function (rs) {
        sessionStorage.setItem('loginResponse', JSON.stringify(rs));
        let data = rs.data.aResponse;
  
        icmsMessage({
          type: "msgPreloader",
          visible: false,
        });
  
        if (data.flag == "0") {
          if (data.php_validation.flag == "0") {
            icmsMessage({
              type: "msgWarning",
              body: "<br>Validation Failed",
              caption: "Try Again",
            });
            return;
          }
          if (data.login_attempt_user_is_exist == "0") {
            icmsMessage({
              type: "msgWarning",
              body: `<br> Your username/password is incorrect.`,
              caption: "Try Again",
            });
          }
          if (
            data.login_attempt_user_is_exist == "1" &&
            parseInt(data.login_attempt) <= 3
          ) {
            icmsMessage({
              type: "msgWarning",
              body: `<br> Your username/password is incorrect. You have ${
                3 - parseInt(data.login_attempt)
              }  attempt/s remaining.`,
              caption: "Try Again",
            });
          }
  
          if (
            data.login_attempt_user_is_exist == "1" &&
            parseInt(data.login_attempt) >= 3
          ) {
            icmsMessage({
              type: "msgWarning",
              body: "<br>You’ve reached the maximum logon attempts. Your account has been block please contact your administrator to reactivate of account.",
              caption: "Close",
            });
          }
        } else {
  
          if (parseInt(rs.data.aResponse.link_type) === 2) {
            var lnk = rs.data.aResponse.link + "twofactorauth?user=" + user;
              location.assign(lnk);
              getNotificationEmailTwofa();
          } else if (parseInt(rs.data.aResponse.link_type) === 1) {
  
            var body = "<br>Access Denied! <br><br>";
            body += "Your account is not registered as administrator<br><br>";
            body += "<a class='a-agn-lnk' href='#'>Try Agency Panel</a>";
            icmsMessage({
              type: "msgWarning",
              body: body,
              caption: "Try Again",
            });
          } else {
            icmsMessage({
              type: "msgWarning",
              body: "<br>Your account has been blocked. Please contact your administrator to reactivate your account.",
              caption: "Try Again",
            });
          }
        }
      },
      "json"
    );
  }

// function loginUser() {
   
//     var user = $('.input_user').val();
//     var pass = $('.input_pass').val();
//     $.post(sAjaxAccess, {
//         type: "getUserlogin",
//         user: user,
//         pass: pass,
//     }, function (rs) {
//         let data = rs.data;

//         icmsMessage({
//             type: "msgPreloader",
//             visible: false,
//         });

//         if(data.flag == "0"){
//             if (data.php_validation.flag == "0") {
//                 icmsMessage({
//                     type: "msgWarning",
//                     body: "<br>Validation Failed",
//                     caption: "Try Again",
//                 });
//                 return; 
//             } 
//             if ((data.login_attempt_user_is_exist == "0")){
//                 icmsMessage({
//                     type: "msgWarning",
//                     body: `<br> Your username/password is incorrect.`,
//                     caption: "Try Again",
//                 });
//             }
//             if ((data.login_attempt_user_is_exist == "1") && ((parseInt(data.login_attempt) <= 3)) ){
//                 icmsMessage({
//                     type: "msgWarning",
//                     body: `<br> Your username/password is incorrect. You have ${3 - parseInt(data.login_attempt)}  attempt/s remaining.`,
//                     caption: "Try Again",
//                 });
//             }

//             if ((data.login_attempt_user_is_exist == "1") && ( parseInt(data.login_attempt) >= 3 ) ){
//                 icmsMessage({
//                     type: "msgWarning",
//                     body: "<br>You’ve reached the maximum logon attempts. Your account has been block please contact your administrator to reactivate of account.",
//                     caption: "Close"
//                 });
//             }
//         }else{
//             if (parseInt(rs.data.link_type) === 2) {
//                 var lnk = rs.data.link + 'dashboard';
//                 if (typeof rs.data.__session.userData.user_id !== 'undefined') {
//                     location.assign(lnk); // to dash board/homepage
//                 }
//             } else if (parseInt(rs.data.link_type) === 1) {
//                 icmsMessage({
//                     type: "msgWarning",
//                     body: "<br>Access Denied! <br>Your account is not registered in agency panel, you will be directed to Admin Panel",
//                     caption: "Try Again",
//                     onShow: function () {
//                         $('.btn-close-warning-modal').hide();
//                         setTimeout(function () {
//                             var lnk = rs.data.link + 'user_login';
//                             location.assign(lnk); // to dash board/homepage
//                         }, 2000);
//                     }

//                 });
//             }else{
//                 icmsMessage({
//                     type: "msgWarning",
//                     body: "<br>Your account has been blocked. Please contact your administrator to reactivate your account.",
//                     caption: "Try Again"
//                 });
//             }
//         }  

//         // if (rs.data.result == "0") {
//         //     icmsMessage({
//         //         type: "msgPreloader",
//         //         visible: false,
//         //     });
//         //     icmsMessage({
//         //         type: "msgWarning",
//         //         body: "<br>Invalid Username or Password",
//         //         caption: "Try Again"
//         //     });

//         // } else if (rs.data.php_validation.flag == "0") {
//         //     icmsMessage({
//         //         type: "msgPreloader",
//         //         visible: false,
//         //     });
//         //     icmsMessage({
//         //         type: "msgWarning",
//         //         body: "<br>Validation Failed",
//         //         caption: "Try Again"
//         //     });
//         // } else {

//         //     if (parseInt(rs.data.link_type) === 2) {
//         //         var lnk = rs.data.link + 'dashboard';
//         //         console.log(rs);
//         //         if (typeof rs.data.__session.userData.user_id !== 'undefined') {
//         //             location.assign(lnk); // to dash board/homepage
//         //         }
//         //     } else {
//         //         icmsMessage({
//         //             type: "msgPreloader",
//         //             visible: false,
//         //         });


//         //         icmsMessage({
//         //             type: "msgWarning",
//         //             body: "<br>Access Denied! <br>Your account is not registered in agency panel, you will be directed to Admin Panel",
//         //             caption: "Try Again",
//         //             onShow: function () {
//         //                 $('.btn-close-warning-modal').hide();
//         //                 setTimeout(function () {
//         //                     var lnk = rs.data.link + 'user_login';
//         //                     location.assign(lnk); // to dash board/homepage
//         //                 }, 2000);
//         //             }

//         //         });

//         //     }

//         // }

//     }, 'json');
// }

function validateCaptcha(){
    let captcha =  grecaptcha.getResponse();
    if(captcha.length <= 0){
        $("#recaptcha-error").html("This field is required."); 
        $("#recaptcha-error").show();  
        return false;
    }
    $("#recaptcha-error").hide();  
    return true; 
}

$(document).ready(function () {


    $('.toggle-password_icon').hover(function () {
        $('.input_pass').attr('type', 'text');
    });

    $(".toggle-password_icon").mouseout(function () {
        $('.input_pass').attr('type', 'password');
    });


    $('#frm_login').validate({
        rules: {
            txt_user: {required: true},
            txt_pass: {required: true}
        },
        errorElement: 'div',
        errorElement: 'div',
        errorPlacement: function (error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element);
            }
            validateCaptcha(); 
        },
        submitHandler: function (form) {
            var resCaptcha = validateCaptcha(); 
            if(resCaptcha){
                icmsMessage({
                    type: "msgPreloader",
                    body: "Trying to log in... Please wait!",
                    visible: true
                });
                loginUser();
            }
        }
    });

    $(".toggle-password_icon").hover(function () {

        $(this).toggleClass("fa-eye fa-eye-slash");
        $(this).toggleClass("show-color");

        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });

    // for capslock 
    $("input[type='password']").keyup(function (event) {
        checkCapsLock($(this)[0]);
    });

    $("input[type='password']").mousedown(function (event) {
        checkCapsLock($(this)[0]);
    });

});


function verifyTwoFactorAuth() {
  
  var code1 = $('.inp-code-1').val().trim();
  var code2 = $('.inp-code-2').val().trim();
  var code3 = $('.inp-code-3').val().trim();
  var code4 = $('.inp-code-4').val().trim();
  var code5 = $('.inp-code-5').val().trim();
  var code6 = $('.inp-code-6').val().trim();
  var code = code1 + code2 + code3 + code4 + code5 + code6;
  var user = $('.user').val();

  $.post(
    sAjaxAccess,
    {
      type: "searchTwoFactorAuth",
      user: user,
      code: code,

    },
    function (rs) {
      if (rs.data.flag != 0) {
        var lnk = rs.data.link + "dashboard";
        location.assign(lnk);
      }else {
        $('#twofa_error_msg').text("Wrong Code!");
        $('.inp-code-1').val('');
        $('.inp-code-2').val('');
        $('.inp-code-3').val('');
        $('.inp-code-4').val('');
        $('.inp-code-5').val('');
        $('.inp-code-6').val('');
      }

    },
    "json"
  );

}

$('.btn-verify-twofa').click(verifyTwoFactorAuth);


// Function to reset resendAttempts array to 0 on page reload
function resetResendAttempts() {
  sessionStorage.removeItem('resendAttempts');
}

// Listen for page reload event
window.addEventListener('beforeunload', resetResendAttempts);

// Function to resend 2FA code
function resendTwofaCode() {
  var rs = JSON.parse(sessionStorage.getItem('loginResponse'));

  if (!rs) {
    console.error('Login response not found');
    return;
  }

  var id = rs.data.access.user_id;

  // console.log(rs.data.access.user_id);

  // Retrieve resendAttempts from sessionStorage
  var storedAttempts = sessionStorage.getItem('resendAttempts');
  var resendAttempts = storedAttempts ? JSON.parse(storedAttempts) : [];

  // Increment resendAttempts
  if (resendAttempts.length === 0) {
    resendAttempts.push(0);
  } else {
    var lastAttemptIndex = resendAttempts.length - 1;
    resendAttempts[lastAttemptIndex]++;
  }

  // Update resendAttempts in sessionStorage
  sessionStorage.setItem('resendAttempts', JSON.stringify(resendAttempts));

  var countdownSeconds = (resendAttempts[resendAttempts.length - 1] <= 2) ? 180 : 1800;
  var timerElement = $('#twofa_count');
  var timer = countdownSeconds;

  // Disable resend button and start countdown
  $('.btn-resend-twofa').prop('disabled', true);

  var countdown = setInterval(function() {
    timer--;
    timerElement.text("Resend Code in: " + timer + " seconds");
    $('#twofa_count').show();

    if (timer <= 0) {
      clearInterval(countdown);
      $('.btn-resend-twofa').prop('disabled', false);
      $('#twofa_count').hide();
    }
  }, 1000);

  // Send AJAX request to resend 2FA code
  $.post(
    sAjaxAccess,
    {
      type: "ResendTwoFactorAuth",
      id: id,
    },
    function (rs) {
      if (rs.data) {
        console.log(rs.data);
      } else {
        console.log("try again");
      }
    },
    "json"
  );

  // Clear countdown interval if button clicked again
  $('.btn-resend-twofa').unbind('click').click(function() {
    clearInterval(countdown);
    resendTwofaCode();
  });
}

// Attach click event listener to resend button
$('.btn-resend-twofa').click(resendTwofaCode);


function getNotificationEmailTwofa() {
  var rs = JSON.parse(sessionStorage.getItem('loginResponse'));
  var id = rs.data.access.user_id;

  $.post(
    sAjaxAccess,
    {
      type: "NotificationEmailTwofa",
      user_id: id
    },
    function (rs) {
          console.log('email was send');
    },
    "json"
  );
}


