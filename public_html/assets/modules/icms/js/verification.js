$(document).ready(function () {
  
     $(".btn-send").click(function(){
      $(".card-otp").removeClass("hidden");
      $(".card-email").addClass("hidden");
     });

     $('.inp-cd').on('keyup change', function () {
        $t = $(this);
        if ($t.val().length > 0) {
            $t.next().focus();
        }
    });    
});

function initializeLoopCounter(fx) {
    sessionStorage.setItem(fx, 0);
    return true;
}


$('.btn-send-verify').click(function () {
     var code1 = $('.inp-code-1').val().trim();
     var code2 = $('.inp-code-2').val().trim();
     var code3 = $('.inp-code-3').val().trim();
     var code4 = $('.inp-code-4').val().trim();
     var code5 = $('.inp-code-5').val().trim();
     var code6 = $('.inp-code-6').val().trim();

     if (code1.length > 0 && code2.length > 0 && code3.length > 0 && code4.length > 0 && code5.length > 0 && code6.length > 0 ) {
         var code = code1 + code2 + code3 + code4 + code5 + code6;

        //  swal({
        //      title: "Confirmation",
        //      text: "You are about to submit <h4>" + code + "</h4> Click confirm to submit",
        //      type: "info",
        //      html: true,
        //      showCancelButton: true,
        //      confirmButtonColor: "#DD6B55",
        //      confirmButtonText: "Confirm",
        //      closeOnConfirm: true
        //  }, function (isConfirm) {

        //   //    initializeLoopCounter('submitEmailOTP');
             submitEmailOTP(code);
        //  });

     } else {
        icmsMessage({
            type: 'msgError'
        });
     }
 });

 function submitEmailOTP(code) {
    // $('#btn-send').attr('disabled', 'disabled');
    // $('#btn-send').text('Please wait...');
    // axios.post(sAccountUrl, {
    //     type: 'submitEmailOTP',
    //     otp_code: parseInt(code)
    // }).then((rs) => {
    //     if (parseInt(rs.data.response.flag) == 1) {
    //         swal("Verified", rs.data.response.message, "success");
    //         window.location.reload();
    //     } else {
    //         if (parseInt(rs.data.response.result.otp_try) >= 5) {
    //             swal("Warning", "You've reach the maximum tries. \n Try again affter 30 minutes", "warning");
    //             window.location.reload();
    //         } else {
    //             $('.otp-code').val("");
    //             $('#btn-send').removeAttr('disabled');
    //             $('#btn-send').text('Send');
    //             swal("Warning", "Invalid OTP code", "error");
    //         }

    //     }

    // }).catch((err) => {
    //     var ctr = loopErrCounter('submitEmailOTP');
    //     if (parseInt(ctr) == 1) {
    //         submitEmailOTP(code);
    //     } else {
    //         $('#btn-send').removeAttr('disabled');
    //         $('#btn-send').text('Send');
    //     }
    // });


    // new code

    $('#btn-send-verify').attr('disabled', 'disabled');
    $('#btn-send-verify').text('Please wait...');
    var url = window.location.href;
    var tcn_code = url.substring(url.lastIndexOf('=') + 1);

    let data =  dg__objectAssign({
        type: 'submitEmailOTP',
        otp_code: parseInt(code),
        tcn: tcn_code
        
    });

    $.post(sAjaxWebPublic,data, function (rs) {
        console.log(rs);
        icmsMessage({
            type: 'msgPreloader',
            visible: true
        });

        if (parseInt(rs.data.flag) == 1) {
            // icmsMessage({
            //     type: 'msgSuccess'
            // });
            window.location.assign(window.location.protocol + '/result_page?tcid='+ rs.data.result.tcid + '&ovc='+ rs.data.result.otp_code);
        } else {
            console.log(rs.data.result.otp_try);
            if (parseInt(rs.data.result.otp_try) >= 3) {
                icmsMessage({
                    type: 'msgError'
                });
                // swal("Warning", "You've reach the maximum tries. \n Try again after 30 minutes", "warning");
                // window.location.reload();
            } else {
                $('.inp-cd').val('');
                $('.btn-send-verify').removeAttr('disabled');
                $('.btn-send-verify').text('Send');
                console.log("Invalid OTP code");
                icmsMessage({
                    type: 'msgError'
                });
            }
        }
    }, 'json');

}

$('.btn-resend').click(function () {
    $('.btn-resend').attr('disabled', 'disabled');
    $('.btn-resend').text('Please wait...');

    var url = window.location.href;
    var tcn_code = url.substring(url.lastIndexOf('=') + 1);

    let data =  dg__objectAssign({
        type: 'resendEmailOTP',
        tcn: tcn_code
    });

    $.post(sAjaxWebPublic,data, function (rs) {
        if (parseInt(rs.data.flag) == 1) {
            icmsMessage({
                type: 'msgSuccess'
            });
        } else {
            $('#otp_count').text(rs.data.err_msg);
            $('#otp_count').addClass('error-message');
            // Start countdown if there is remaining time
            if (rs.data.remaining_time > 0) {
                startCountdown(rs.data.remaining_time);
            }
            // icmsMessage({
            //     type: 'msgError'
            // });
        }

        $('.btn-resend').removeAttr('disabled');
        $('.btn-resend').text('Send code again');
        
    }, 'json');

});

function startCountdown(remainingTime) {
    var countdownInterval = setInterval(function() {
        remainingTime--;
        if (remainingTime <= 0) {
            clearInterval(countdownInterval);
            $('#otp_count').text('');
            $('#otp_count').removeClass('error-message');
        } else {
            $('#otp_count').text('Resend OTP in: ' + remainingTime + ' seconds');
        }
    }, 1000);
}

