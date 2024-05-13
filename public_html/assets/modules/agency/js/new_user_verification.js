function verifyInfo() {
    var xp = $('.crd-cnt').attr('data-xp');
    var lnk = $('.crd-cnt').attr('data-lnk');

    if (lnk == "0") {
        $('.py-5').html("");
        $(".modal-body").html("Sorry! this link is no longer available");
        $('#warning_modal').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
    } else {
        if (xp == "1") {
            $('.py-5').html("");
            $(".modal-body").html("Sorry! this link is already expired");
            $('#warning_modal').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        }
    }
}

function redirectToLogin() {
    var user = $('.crd-cnt').attr('data-un');
    var pass = $('#pwd').val();
    $.post(sAjaxAccess, {
        type: "getUserlogin",
        user: user,
        pass: pass,
    }, function (rs) {
        if (rs.data.result == "0") {
            $(".modal-title-conf").html("Access Denied");
            $(".modal-body-conf").html(rs.data.access_msg);
            $(".modal-footer-conf").html('  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>');
            $('#save_confirm_modal').modal('show');
        } else if (rs.data.aResponse.php_validation.flag == "0") {
            $(".modal-title-conf").html("Access Denied");
            $(".modal-body-conf").html("Incomplete Values");
            $(".modal-footer-conf").html('  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>');
            $('#save_confirm_modal').modal('show');
        } else {
            $(".modal-title-conf").html("Result");
            $(".modal-body-conf").html("<p>Congratulations!<br> Setting up of password was successful</p>");
            $(".modal-footer-conf").html('<a href="' + rs.data.link + '"><button type="button" class="btn btn-secondary btn-proceed">Proceed</button>');
            $('#save_confirm_modal').modal('show');
        }

    }, 'json');
}


$(document).ready(function () {

    verifyInfo();

    $("#pwd").passwordStrength();

    jQuery("form").submit(function (e) {
        e.preventDefault();
    });

    $('.btn-login').click(function () {
        var lnk = sAjaxUrl + '/user_login';
        location.assign(lnk); // to dash board/homepage
    });


    $('#formLogin').validate({
        rules: {
            create_password: {
                required: true,
                maxlength: 48,
                minlength: 8,
            },
            confirm_password: {
                required: true,
                maxlength: 48,
                minlength: 8,
                equalTo: "#pwd"
            }
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $(".modal-title-conf").html("Processing");
            $(".modal-body-conf").html("<p>Please wait . . .</p>");
            $(".modal-footer-conf").html('');
            $('#save_confirm_modal').modal('show');

            var id = $('.crd-cnt').attr('data-id');
            var pwd = $('#pwd').val();
            $.post(sAjaxAccess, {
                type: "setNewUserPassword",
                id: id,
                pwd: pwd,
            }, function (rs) {

                if (rs.data.result == "0") {
                    $(".modal-title-conf").html("Access Denied");
                    $(".modal-body-conf").html("Something went wrong, please try again.");
                    $(".modal-footer-conf").html('<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>');
                    $('#save_confirm_modal').modal('show');
                } else {
                    redirectToLogin();
                }
            }, 'json');
        }
    });

    $('.spn_show').click(function () {

        var stat = $(this).attr('data-s-h');
        var inp_id = $(this).attr('data-id');
        if (stat == "1") {
            $(this).text("show");
            $(this).attr('data-s-h', '0');
            $(inp_id).attr("type", "password");
            $(inp_id).attr("placeholder", "• • • • • • • • ");

        } else {
            $(this).text("hide");
            $(this).attr('data-s-h', '1');
            $(inp_id).attr("type", "text");
            $(inp_id).attr("placeholder", "p a s s w o r d ");
        }
    });
});
