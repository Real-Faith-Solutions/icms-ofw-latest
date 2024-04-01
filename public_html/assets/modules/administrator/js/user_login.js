function checkCapsLock(e) {
  e.addEventListener("keyup", function (event) {
    if (event.getModifierState("CapsLock")) {
      var sMessage = "*WARNING! Caps lock is ON.";
      $(".lbl-capslock").html(sMessage);
    } else {
      var sMessage = "";
      $(".lbl-capslock").html(sMessage);
    }
  });

  e.addEventListener("mousedown", function (event) {
    if (event.getModifierState("CapsLock")) {
      var sMessage = "*WARNING! Caps lock is ON.";
      $(".lbl-capslock").html(sMessage);
    } else {
      var sMessage = "";
      $(".lbl-capslock").html(sMessage);
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
      let data = rs.data;

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
        if (parseInt(rs.data.link_type) === 1) {
          var lnk = rs.data.link + "twofactorauth";
          if (typeof rs.data.__session.userData.user_id !== "undefined") {
            location.assign(lnk); // to dash board/homepage
          }
        } else if (parseInt(rs.data.link_type) === 2) {
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

function validateCaptcha() {
  let captcha = grecaptcha.getResponse();
  if (captcha.length <= 0) {
    $("#recaptcha-error").html("This field is required.");
    $("#recaptcha-error").show();
    return false;
  }
  $("#recaptcha-error").hide();
  return true;
}

$(document).ready(function () {
  $(".toggle-password_icon").hover(function () {
    $(".input_pass").attr("type", "text");
  });
  $(".toggle-password_icon").mouseout(function () {
    $(".input_pass").attr("type", "password");
  });

  $("#frm_login").validate({
    rules: {
      txt_user: { required: true },
      txt_pass: { required: true },
    },
    errorElement: "div",
    errorElement: "div",
    errorPlacement: function (error, element) {
      var placement = $(element).data("error");
      if (placement) {
        $(placement).append(error);
      } else {
        error.insertAfter(element);
      }
    },
    submitHandler: function (form) {
      var resCaptcha = validateCaptcha();
      if(resCaptcha){
      icmsMessage({
        type: "msgPreloader",
        body: "Trying to log in... Please wait!",
        visible: true,
      });
      loginUser();
      }
    },
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

  $("footer").delegate(".a-agn-lnk", "click", function () {
    var link = window.location.protocol + "//agency." + sBaseURL;
    window.location.assign(link);
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

    if (code1.length > 0 && code2.length > 0 && code3.length > 0 && code4.length > 0 && code5.length > 0 && code6.length > 0 ) {
        var code = code1 + code2 + code3 + code4 + code5 + code6;
        
        $.post(
            sAjaxAccess,
            {
                type: "searchTwoFactorAuth",
            },
            function (rs) {
                console.log(rs);
                console.log(code);
                if (rs.data) {
                    if (rs.data == code) {
                      console.log("success");
                      var lnk = "dashboard";
                      location.assign(lnk);
                    } else {
                        console.error("errors");
                    }
                } else {
                    console.log("try again");
                }
            },
            "json"
        );
    } else {
        icmsMessage({
            type: 'msgError'
        });
    }
}

$('.btn-verify-twofa').click(verifyTwoFactorAuth);



