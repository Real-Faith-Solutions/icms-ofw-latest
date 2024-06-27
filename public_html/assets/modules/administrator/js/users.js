function updateICMSUser() {
    var user_id = $('.btn-update').attr('data-id');
    var fname = $('#txt_fname').val();
    var mname = $('#txt_mname').val();
    var lname = $('#txt_lname').val();
    var sex = $('#sel_sex').val();
    var area_desc = $('#area_desc').val();
    var tel = $('#txt_tel').val();
    var mob = $('#txt_mob').val();
    var country = $('#sel_country').val();
    var region = $('#sel_region').val();
    var state_prov = $('#sel_state_prov').val();
    var city = $('#sel_city').val();
    var brgy = $('#sel_brgy').val();
    var area_detailed = $('#area_detailed').val();
    var txt_email = $('#txt_email').val();

    var cur_level = localStorage.getItem('cur_level');

    // && $('#sel_userlevel').val() !== "1"
    if ($('#sel_userlevel').val() !== cur_level && $('#sel_userlevel').val() !== "0" && $('#sel_userlevel').val() !== null) {
        var newLevel = $('#sel_userlevel').val();
    } else {
        var newLevel = cur_level;
    }

    $.post(sAjaxUsers, {
        type: "setUserDetails", // update details
        user_id: user_id,
        fname: fname,
        mname: mname,
        lname: lname,
        sex: sex,
        area_desc: area_desc,
        tel: tel,
        mob: mob,
        country: country,
        region: region,
        state_prov: state_prov,
        city: city,
        brgy: brgy,
        area_detailed: area_detailed,
        userLevel: newLevel,
        txt_email: txt_email,
        user_stats: $('#sel-status').val(),
    }, function (rs) {
        icmsMessage({
            type: "msgPreloader",
            visible: false
        });
        if (rs.data.php_validation.flag == "1") {
            if (rs.data.result == "1") {
                icmsMessage({
                    type: "msgSuccess",
                    body: "You have successfully updated user datails",
                    onShow: function () {
                        changeReset();
                        getAllUsers();
                        getMyUsers();
                    }
                });
            } else {
                icmsMessage({
                    type: "msgWarning",
                    body: "Please check your inputs"
                });
            }
        } else {
            icmsMessage({
                type: "msgWarning",
                body: "Please check your inputs"
            });
        }
    }, 'json');

}

function getSex() {
    $.post(sAjaxGlobalData, {
        type: "getSex"
    }, function (rs) {
        l = "<option  selected disabled>Select Sex</option>";
        $.each(rs.data, function (key, val) {
            l += "<option value='" + val.parameter_count_id + "'>" + val.parameter_name + " </option>";
        });
        $('#sel_sex').html(l);
    }, 'json');
}

function  getCountry() {
    $.post(sAjaxGlobalData, {
        type: "getCountries"
    }, function (rs) {
        l = "<option disabled>Select Country</option>";
        $.each(rs.data, function (key, val) {
            l += "<option value='" + val.country_id + "'>" + val.country_name + " </option>";
        });
        $('#sel_country').html(l);

    }, 'json');
}

function getRegions() {

    $.post(sAjaxGlobalData, {
        type: "getRegions"
    }, function (rs) {
        var extid = $('#sel_region').attr('ext-id');
        l = "<option >Select Region</option>";
        $.each(rs.data, function (key, val) {
            l += "<option value='" + val.location_count_id + "'>" + val.location_name + " </option>";
        });
        $('#sel_region').html(l);
        $('#sel_region').val(extid).change();
    }, 'json');

}

function  getStates(country_id) {

    $.post(sAjaxGlobalData, {
        type: "getStateByCountryID",
        country_id: country_id,
    }, function (rs) {
        var extid = $('#sel_state_prov').attr('ext-id');
        l = "<option   disabled>Select States</option>";
        $.each(rs.data, function (key, val) {
            l += "<option value='" + val.location_count_id + "'>" + val.location_name + " </option>";
        });
        $('#sel_state_prov').html(l);
        $('#sel_state_prov').val(extid).change();

    }, 'json');
}

function getProvinceByRegionID(region_id) {
    $.post(sAjaxGlobalData, {
        type: "getProvinceByRegionID",
        region_id: region_id,
    }, function (rs) {
        var extid = $('#sel_state_prov').attr('ext-id');
        l = "<option  disabled>Select States</option>";
        $.each(rs.data, function (key, val) {
            l += "<option value='" + val.location_count_id + "'>" + val.location_name + " </option>";
        });
        $('#sel_state_prov').html(l);
        $('#sel_state_prov').val(extid).change();

    }, 'json');
}

function getCities(province_id) {
    $.post(sAjaxGlobalData, {
        type: "getCityByProvinceID",
        province_id: province_id,
    }, function (rs) {
        var extid = $('#sel_city').attr('ext-id');
        l = "<option  disabled>Select City</option>";
        $.each(rs.data, function (key, val) {
            l += "<option  value='" + val.location_count_id + "'>" + val.location_name + "</option>";
        });
        $('#sel_city').html(l);
        $('#sel_city').val(extid).change();
    }, 'json');
}

function  getBrgy(city_id) {
    $.post(sAjaxGlobalData, {
        type: "getBrgyByCityID",
        city_id: city_id,
    }, function (rs) {
        var extid = $('#sel_brgy').attr('ext-id');
        l = "<option  disabled>Select Barangay</option>";
        $.each(rs.data, function (key, val) {
            l += "<option value='" + val.location_count_id + "'>" + val.location_name + " </option>";
        });
        $('#sel_brgy').html(l);
        $('#sel_brgy').val(extid).change();
    }, 'json');
}

function getMyUsers(page) {
    $("input[type=submit]").attr("disabled", "disabled");
    var page = $('#user_list-my_users').attr('datapage');
    localStorage.clear();
    var keyword = $('#txt_search_my_user').val();
    var filter = $('#searchby').val();
    var aStatus = [];
    var aUserRole = [];
    var orderby = [];
    var aStatus = [];
    var aUserRole = [];

    $.each($("input[name='mystatus']:checked"), function () {
        aStatus.push($(this).val());
    });
    $.each($("input[name='myUserRole']:checked"), function () {
        aUserRole.push($(this).val());
    });
    $.each($("input[name='myorderBy']:checked"), function () {
        orderby.push($(this).val());
    });
    orderby = orderby.join();

    aStatus = aStatus.join();
    aUserRole = aUserRole.join();

    var limit = 10;
    $.post(sAjaxUsers, {
        type: "getMyUsers",
        limit: limit,
        page: page,
        orderby: orderby,
        keyword: keyword,
        aUserRole: aUserRole,
        aStatus: aStatus,
        filter: filter,
        aUserRole: aUserRole
    }, function (rs) {
        getLoadingList();
        if (parseInt(rs.data.count) > 0) {
            $('#user_list').show();
            $('#user_list-no-content').remove();

            var l = buildUsersList(rs.data.list, "my");
            $('.filter_load_placeholder').hide();
            $('#div-my-user-list').html(l + "<br><br>");

            // prevent scroll up during 
            $("a[href='#']").click(function (e) {
                e.preventDefault();
            });

            if (parseInt(rs.data.count) <= parseInt(limit)) {
                limit = rs.data.count;
            }

            // pagination - library
            buildPagination({
                parent: 'my-rs-list',
                info: 'my-rs-info',
                pagination: 'my-rs-pagination',
                offset: 'rs-offset',
                data: {
                    page: page,
                    offset: limit,
                    count: rs.data.count
                }
            });
        } else {
            $('.filter_load_placeholder').hide();
            var sFooter = '<a href="' + sAjaxUrl + '/add_users"> <button type="button" class="btn" style="background-color: #e88f15; color: #fff;"> ADD USER </button> </a>';
            var sMessage = 'SORRY, WE COULDN\'T FIND ANY USERS RELATED TO <span class = "font-italic" >"<span>' + keyword + '</span>"</span>.';

            if (!(keyword)) {
                sMessage = 'NO USER FOUND.';
            }
            var l = getNoDataFound({
                message: sMessage,
                footer: sFooter
            });

            $('#myuser_list').hide();
            $('#user_list-no-content').remove();
            $('#div-my-user-list').html("<div id='user_list-no-content'>" + l + "</div>");
        }


    }, 'json');
}

function getAllUsers() {
    $("input[type=submit]").attr("disabled", "disabled");
    var page = $('#user_list').attr('datapage');
    localStorage.clear();
    var keyword = $('#txt_search_all_user').val();
    var filter = $('#searchby').val();
    var aStatus = [];
    var aUserRole = [];
    var orderby = [];
    var aStatus = [];
    var aUserRole = [];

    $.each($("input[name='status']:checked"), function () {
        aStatus.push($(this).val());
    });
    $.each($("input[name='UserRole']:checked"), function () {
        aUserRole.push($(this).val());
    });
    $.each($("input[name='orderBy']:checked"), function () {
        orderby.push($(this).val());
    });
    orderby = orderby.join();

    aStatus = aStatus.join();
    aUserRole = aUserRole.join();

    var limit = 10;
    $.post(sAjaxUsers, {
        type: "getAllUsers",
        limit: limit,
        page: page,
        orderby: orderby,
        keyword: keyword,
        aUserRole: aUserRole,
        aStatus: aStatus,
        filter: filter,
        aUserRole: aUserRole
    }, function (rs) {
        getLoadingList();
        if (parseInt(rs.data.count) > 0) {
            $('#user_list').show();
            $('#user_list-no-content').remove();

            var l = buildUsersList(rs.data.list, "all");
            $('.filter_load_placeholder').hide();
            $('.div-user-list').html(l + "<br><br>");

            // prevent scroll up during 
            $("a[href='#']").click(function (e) {
                e.preventDefault();
            });

            if (parseInt(rs.data.count) <= parseInt(limit)) {
                limit = rs.data.count;
            }

            // pagination - library
            buildPagination({
                parent: 'rs-list',
                info: 'rs-info',
                pagination: 'rs-pagination',
                offset: 'rs-offset',
                data: {
                    page: page,
                    offset: limit,
                    count: rs.data.count
                }
            });
        } else {
            $('.filter_load_placeholder').hide();
            var sFooter = '<a href="' + sAjaxUrl + '/add_users"> <button type="button" class="btn" style="background-color: #e88f15; color: #fff;"> ADD USER </button> </a>';
            var sMessage = 'SORRY, WE COULDN\'T FIND ANY USERS RELATED TO <span class = "font-italic" >"<span>' + keyword + '</span>"</span>.';

            if (!(keyword)) {
                sMessage = 'NO USER FOUND.';
            }
            var l = getNoDataFound({
                message: sMessage,
                footer: sFooter
            });

            $('#user_list').hide();
            $('#user_list-no-content').remove();
            $('#user_list').after("<div id='user_list-no-content'>" + l + "</div>");

        }


    }, 'json');
}

function buildUsersList(rs, fr) {
    var tbl = "";
    var forId = "id";
    if (fr == "my") {
        forId = "myid";
    }
    $.each(rs, function (key, val) {
        var stat = '<span class="badge_cc" data-id="' + val.user_id + '" data-stat="' + val.user_is_active + '"></span><span class="stat_">Active</span>';

        var show_change_stat = '1';
        if (val.user_is_active == '0') {
            // Uncomment this after 
            stat = '<span class="stat-change stat_inactive" style="cursor:pointer" data-id="' + val.user_id + '" data-stat="' + val.user_is_active + '">Inactive</span>';
            // Unverified
//            stat = '<span class="stat-change stat_inactive" style="cursor:pointer" data-id="' + val.user_id + '" data-stat="' + val.user_is_active + '">Unverified</span>';
        }
        if (val.agency_branch_is_active == '0') {
            stat = '<span class="stat_inactive">Inactive Agency Branch</span>';
            show_change_stat = '0';
        }
        if (val.agency_is_active == '0') {
            stat = '<span class="stat_inactive_agency">Inactive Agency</span>';
            show_change_stat = '0';
        }

        tbl += '  <li style="width:100%">';
        tbl += '                               <div class="card" style="   ">';
        tbl += '                                   <div class="row d-flex">';
        tbl += '                                       <div class="col-lg-8 col-md-8 col-sm-8  align-items-center ">';

        tbl += '                                           <div class="row nav-data_list">';
        tbl += '                                                <div class="col-lg-2 col-md-3 col-sm-4 data_list_img">';
        tbl += '                                                   <div class="img_content"> ';
        tbl += '                                                       <img src="' + sDriveViewer + val.photo + '" onerror="ifBrokenProfile(this);" >  ';
        tbl += '                                                   </div>';
        tbl += '                                               </div>';
        tbl += '                                                 <div class="col-lg-10 col-md-9 col-sm-8 test2 desc_content">';
        tbl += '                                                        <div class="agency_details"> <span class="content-title ">' + val.user_firstname + ' ' + val.user_middlename + ' ' + val.user_lastname + ' </span>';
        tbl += '                                                            <span style="color: #6c757d"> | ' + val.user_level_description + '   </span> <br> ';
        tbl += '                                                           <span style="color: #333c48;">  ' + val.agency_abbr;
        if (val.agency_branch_is_main == "1") {
            tbl += '<span> (' + val.agency_branch_name + ' - Main)</span>';
        } else {
            tbl += val.agency_branch_name + ' Branch';
        }
        tbl += '                                                       </span>  <br> ';
        tbl += '                                                        <small style="color: #6c757d !important;"> <span >' + val.user_email + ' </span></small>   <br>';
        tbl += '                                                           <small style="color: #6c757d !important;">' + val.user_mobile_number + ' | ' + val.user_phone_number + '</small>';

        tbl += '                                                         </div>';
        tbl += '                                                   </div>';
        tbl += '                                            </div>';

        tbl += '                                        </div>';
        tbl += '                                       <div class="col-lg-2 col-md-2 col-sm-2 txt-align_center d-flex align-items-center justify-content-center">';
        tbl += stat;
        tbl += '                                       </div>';
        tbl += '                                        <div class="col-lg-2 col-md-2 col-sm-2 txt-align_center d-flex align-items-center justify-content-center">';
        tbl += '                                             <div class="btn-group ellipse-action " data-id="' + val.user_id + '">';
        tbl += '                                                    <a class="a-ellipse a-ellipse-' + val.user_id + ' "  style="color: #8fafd1;">  <i class="fa fa-ellipsis-v" aria-hidden="true"></i> </a>';
        tbl += '                                                  <div class="action-menu" data-level ="' + val.user_level_id + '" id="' + forId + '-' + val.user_id + '" agn-type="' + val.govt_agency_type_name + '"  agn-brn="' + val.govt_agency_branch_name + '">';
        tbl += '                                                     <a class="dropdown-item disabled action-title" href="#">Select Action</a>';
        tbl += '                                                     <a class="dropdown-item a-manage-details" data-stats="' + val.user_is_active + '" href="#">Manage User</a>';
        tbl += '                                                     <a class="dropdown-item a-manage-password"  data-id="' + val.user_id + '" href="#">Reset Password</a>';
        if (show_change_stat == "1") {
            if (val.user_id !== "iZb0XWIqBZQwFs5XJsRXJH0U85Ew87sM9M5GPC0bVusQiCY3Q5l") {
                tbl += '              <a class="dropdown-item a-reset-pwd" dataid="' + val.user_id + '" data-branchname="' + val.agency_branch_name + '"  data-abbr="' + val.agency_abbr + '" data-lname="' + val.user_lastname + '" data-fname="' + val.user_firstname + '" data-email="' + val.user_email + '" href="#">Reset Password via email</a>';
            }
        }

        tbl += '                                                </div>';
        tbl += '                                         </div>';

        tbl += '                                   </div>';
        tbl += '                               </div>';
        tbl += '    </li>';
    });

    return tbl;
}

function getUserLevel() {
    $.post(sAjaxAgencies, {
        type: "getUserLevelWithCondition",
        agencyid: "1",
    }, function (rs) {
        l = "<option  selected disabled>Select level</option>";
        $.each(rs.data, function (key, val) {
            l += "<option value='" + val.transaction_parameter_count_id + "'>" + val.transaction_parameter_name + " </option>";
        });
        $("#sel_userlevel").html(l);
    }, 'json');
}

$(document).ready(function () {
    getLoadingList();
    getUserLevel();
    getSex();

    getCountry();
    getRegions();
    // load initial function
    getAllUsers();
    getMyUsers();

    // show pw
    $('.lbl-show-hide-new').click(function () {
        var stat = $(this).attr('data-stat');
        if (stat == "1") {
            $(this).text("hide");
            $(this).attr('data-stat', '0');
            $('#pw-new').attr("type", "text");
            $('#pw-new').attr("placeholder", "password")
        } else {
            $(this).text("show");
            $(this).attr('data-stat', '1');
            $('#pw-new').attr("type", "password")
            $('#pw-new').attr("placeholder", "••••••••")
        }
    });

    // reset user password
    $('#container-user-list').delegate('.a-manage-password', 'click', function () {
         // reset show hide password 
         $(".lbl-show-hide-new").text("show");
         $(".lbl-show-hide-new").attr('data-stat', '1');
         $('#pw-new').attr("type", "password")
         $('#pw-new').attr("placeholder", "••••••••")
         
         $("#pw-new").attr("data-id", $(this).attr('data-id'));
         $("#pw-new").val("");
         $('#pw-new').attr("type", "password");
         $('#pw-new').attr("placeholder", "••••••••");
         $('#mdl-change-pw').modal({
             backdrop: 'static',
             keyboard: false,
             show: true
         });
 
         // reset password 
         $("#pw-new-error-password-validate").text("");
    });


    $('#frm-change-password').validate({
        rules: {
            newpassword: {
                required: true,
                minlength: "8",
            },
        },
        messages: {},
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
            if($('#pw-new').attr('check_strength_is_valid') == '1'){
                $('#mdl-change-pw').modal('hide');
                icmsMessage({
                    type: 'msgConfirmation',
                    title: 'You are about to update your password.',
                    onConfirm: function () {
    
                        icmsMessage({
                            type: 'msgPreloader',
                            visible: true
                        });
    
                        $.post(sAjaxUsers, {
                            type: "changePassword",
                            user_id: $('#pw-new').attr('data-id'),
                            password: $('#pw-new').val(),
                        }, function (rs) {
                            if (rs.data.php_validation.flag == "1") {
                                if (rs.data.flag == "1") {
                                    icmsMessage({
                                        type: 'msgSuccess',
                                        body: 'Password was successfully reset.',
                                        onShow: function () {
                                            $('#pw-new').val("");
                                        }
                                    });
                                }
                            } else {
                                icmsMessage({
                                    type: 'msgWarning',
                                    body: 'Insufficient Values!',
                                    onHide: function () {
                                        $('#mdl-change-pw').modal('show');
                                    }
                                });
                            }
                        }, 'json');
    
                    },
                    onShow: function () {
                        $('#mdl-change-pw').modal('hide');
                    },
                    onCancel: function () {
                        $('#mdl-change-pw').modal('show');
                    }
                });
            }
        }
    });

    $('#modal-body-update input').change(function () {
        $('.closeUpdate').attr('changes', 1);
    });
//    $('#modal-body-update select').change(function () {
//        $('.closeUpdate').attr('changes', 1);
//    });
    $('#modal-body-update textarea').change(function () {
        $('.closeUpdate').attr('changes', 1);
    });


    $('#filterby').chosen({rtl: false});
    $('#filterby-all_users').chosen({rtl: false});

    $('.chosen-results').addClass('text-left');

    $('.div-user-list').delegate('.a-reset-pwd', 'click', function () {
        var email = $(this).attr('data-email');
        var user_id = $(this).attr('dataid');
        var fname = $(this).attr('data-fname');
        var lname = $(this).attr('data-lname');
        var branchname = $(this).attr('data-branchname');
        var abbr = $(this).attr('data-abbr');

        var body = '';
        body += ' <p class="msgmodal-confirm-header m-header " style=" padding-top: 22px;"> You are about to update user password.</p>';
        body += '  <span class="sub-content-confirm p2">Click <b>"Reset"</b> button to confirm<br> A link will be sent to <br><b>' + email + '</b></span>';
        $('.msgmodal-confirm-body').html(body);
        var footer = '   <button type="button" class="btn btn-close-confirm-modal btn-close-update-confirm " data-dismiss="modal">Cancel</button>';
        footer += '      <button type="button" class="btn btn-primary-orange modal-button-save  btn-modal-reset" data-lname="' + lname + '"  data-abbr="' + abbr + '"  data-branchname="' + branchname + '"   data-fname="' + fname + '" data-email="' + email + '" data-id="' + user_id + '" data-dismiss="modal">Reset</button></div>';
        $('.msgmodal-confirm-footer').html(footer);

        $('.close').hide();
        $('#msgmodal-confirm').modal('show');


    });

    $('#div-my-user-list').delegate('.a-reset-pwd', 'click', function () {
        var email = $(this).attr('data-email');
        var user_id = $(this).attr('dataid');
        var fname = $(this).attr('data-fname');
        var lname = $(this).attr('data-lname');
        var branchname = $(this).attr('data-branchname');
        var abbr = $(this).attr('data-abbr');
        var body = '';
        body += ' <p class="msgmodal-confirm-header m-header " style=" padding-top: 22px;"> You are about to update user password.</p>';
        body += '  <span class="sub-content-confirm p2">Click <b>"Reset"</b> button to confirm<br>Link will be sent to <br><b>' + email + '</b></span>';
        $('.msgmodal-confirm-body').html(body);
        var footer = '   <button type="button" class="btn btn-close-confirm-modal btn-close-update-confirm " data-dismiss="modal">Cancel</button>';
        footer += '      <button type="button" class="btn btn-primary-orange modal-button-save  btn-modal-reset" data-lname="' + lname + '"  data-abbr="' + abbr + '"  data-branchname="' + branchname + '"   data-fname="' + fname + '" data-email="' + email + '" data-id="' + user_id + '" data-dismiss="modal">Reset</button></div>';
        $('.msgmodal-confirm-footer').html(footer);

        $('.close').hide();
        $('#msgmodal-confirm').modal('show');


    });

    $('#msgmodal-confirm').delegate('.btn-modal-reset', 'click', function () {
        $('#msgmodal-saving').modal('show');
        var email = $(this).attr("data-email");
        var user_id = $(this).attr("data-id");
        var fname = $(this).attr("data-fname");
        var lname = $(this).attr("data-lname");
        var branchname = $(this).attr("data-branchname");
        var abbr = $(this).attr("data-abbr");

        $.post(sAjaxUsers, {
            type: "sendResetPasswordLink",
            user_id: user_id,
            email: email,
            fname: fname,
            lname: lname,
            branchname: branchname,
            abbr: abbr,
        }, function (rs) {
            if (rs.data.php_validation.flag == "0") {
                $('#msgmodal-saving').modal('hide');
                $('.msgmodal-header').html("Warning");
                $('.msgmodal-body').html('<center>Insufficient values </center>');
            } else {

                if (rs.data.result == "1") {
                    $('#msgmodal-saving').modal('hide');

                    $('#msgmodal-saving').modal('hide');
                    $('.h5-title').html("Result");
                    var body = '';
                    body += '<div class="success-checkmark">';
                    body += '    <div class="check-icon">';
                    body += '        <span class="icon-line line-tip"></span>';
                    body += '        <span class="icon-line line-long"></span>';
                    body += '        <div class="icon-circle"></div>';
                    body += '        <div class="icon-fix"></div>';
                    body += '    </div>';
                    body += '</div>';
                    body += '<p  class="sub-content-success p2">Reset password link is successfully sent to <br><small><b>' + email + '</b></small>.</p> ';
                    $('.msgmodal-success-body').html(body);

                    $('.close').hide();
                    $('#msgmodal-success').modal('show');

                } else {
                    $('#msgmodal-saving').modal('hide');

                    var body = '';

                    body += '   <div class="row">';
                    body += '     <div class="col-12">';
                    body += '         <div>';
                    body += '             <p class="notif-title text-align_center">WARNING</p<br> ';
                    body += '         </div>';
                    body += '         <p class="mt-3 text-center">  A password link was previously sent  to <br><span>\n\
                                        <small style="color: #6c757d;"><b>' + email + '</b></small> that will last for 24 hours.</span></p>';
                    body += '     </div>';
                    body += '  </div>';
                    $('.msgmodal-warning-body').html(body);
                    var footer = '    <button type="button" class="btn btn-close-warning-modal float-right" data-dismiss="modal">Back</button>';
                    $('.msgmodal-warning-footer').html(footer);

                    $('.close').hide();
                    $('#msgmodal-warning').modal('show');
                }

            }

            var footer = '<a type="button" class="btn  btn-close "  data-dismiss="modal" aria-label="Close">Close</a>';
            $('.msgmodal-footer').html(footer);
        }, 'json');

    });

    $('#sel_country').change(function () {
        var country_id = $(this).val();
        if (country_id == '173') {
            $('.grp-brgy').show();
            $('.grp-city').show();
            $('.grp-region').show();

            $('.grp-country').addClass;
            $('.grp-country').removeClass;
            $('.grp-prov-state').addClass;
            $('.grp-prov-state').removeClass;
            $('.grp-address').addClass;
            $('.grp-address').removeClass;

            getRegions();

        } else {
            $('#sel_brgy').val("0");
            $('#sel_city').val("0");
            $('#sel_region').val("0").change();
            $('.grp-brgy').css("display", "none");
            $('.grp-city').css("display", "none");
            $('.grp-region').css("display", "none");

            $('.grp-country').removeClass;
            $('.grp-country').addClass;

            $('.grp-prov-state').removeClass;
            $('.grp-prov-state').addClass;
            $('.grp-address').removeClass;
            getStates(country_id);
        }
    });


    $('#sel_region').change(function () {
        var country_id = $('#sel_country').val();
        if (country_id == '173') {
            var region_id = $(this).val();
            $('#sel_city').html("<option  selected disabled>Select City</option>");
            $('#sel_brgy').html("<option selected disabled>Select Barangay</option>");
            getProvinceByRegionID(region_id);
        }
    });

    $('#sel_state_prov').change(function () {
        var country_id = $('#sel_country').val();
        if (country_id == '173') {
            var province_id = $(this).val();
            getCities(province_id);
        }
        $('#sel_brgy').html("<option  selected disabled>Select Barangay</option>");
    });

    $('#sel_city').change(function () {
        var country_id = $('#sel_country').val();
        if (country_id == '173') {
            var city_id = $(this).val();
            getBrgy(city_id);
        }
    });

    $('.div-user-list').delegate('.a-manage-details', 'click', function (e) {

        var user_id = $(this).parent('div').attr('id').slice(3);
        if (user_id == "iZb0XWIqBZQwFs5XJsRXJH0U85Ew87sM9M5GPC0bVusQiCY3Q5l") {
            $('.div-access').css('display', 'none');
            $('.access-adj').removeClass;
            $('.access-adj').addClass;
        } else {
            $('.div-access').show();
            $('.access-adj').removeClass;
            $('.access-adj').addClass;
        }

        var level = $(this).parent('div').attr('data-level');
        localStorage.setItem('cur_level', level);
//        if (level != "1") {
        $('#sel_userlevel').val(level).change();
//        }

        $.post(sAjaxUsers, {
            type: "getUserDetails",
            user_id: user_id,
        }, function (rs) {
            $('#lbl-user_name').html(rs.data.user_username);
            $('#txt_fname').val(rs.data.user_firstname);
            $('#txt_mname').val(rs.data.user_middlename);
            $('#txt_lname').val(rs.data.user_lastname);
            $('#sel_sex').val(rs.data.user_gender).change();
            $('#area_desc').val(rs.data.user_job_title);
            $('#txt_tel').val(rs.data.user_phone_number);
            $('#txt_mob').val(rs.data.user_mobile_number);
            $('#txt_email').val(rs.data.user_email);
            $('#txt_email').attr("orgEmail", rs.data.user_email);
            $('.btn-update').attr('data-id', user_id);
            $('#sel-status').val(rs.data.user_is_active).change();            
            changeReset();
            $('#modalUpdateUser').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });

        }, 'json');
    });

    $('#div-my-user-list').delegate('.a-manage-details', 'click', function () {
        $('#sel-status').val($(this).attr('data-stats')).change();
        var user_id = $(this).parent('div').attr('id').slice(5);
        if (user_id == "iZb0XWIqBZQwFs5XJsRXJH0U85Ew87sM9M5GPC0bVusQiCY3Q5l") {
            $('.div-access').css('display', 'none');
            $('.access-adj').removeClass;
            $('.access-adj').addClass;
        } else {
            $('.div-access').show();
            $('.access-adj').removeClass;
            $('.access-adj').addClass;
        }

        var level = $(this).parent('div').attr('data-level');
        localStorage.setItem('cur_level', level);
//        if (level != "1") {
        $('#sel_userlevel').val(level).change();
//        }

        $.post(sAjaxUsers, {
            type: "getUserDetails",
            user_id: user_id,
        }, function (rs) {
            $('#lbl-user_name').html(rs.data.user_username);
            $('#txt_fname').val(rs.data.user_firstname);
            $('#txt_mname').val(rs.data.user_middlename);
            $('#txt_lname').val(rs.data.user_lastname);
            $('#sel_sex').val(rs.data.user_gender).change();
            $('#area_desc').val(rs.data.user_job_title);
            $('#txt_tel').val(rs.data.user_phone_number);
            $('#txt_mob').val(rs.data.user_mobile_number);
            $('#txt_email').val(rs.data.user_email);
            $('#txt_email').attr("orgEmail", rs.data.user_email);
            $('.btn-update').attr('data-id', user_id);
            $('#sel-status').val(rs.data.user_is_active).change();

            $('#modalUpdateUser').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        }, 'json');
    });

    $('#msgmodal').delegate('.btn-close-update-confirm', 'click', function () {
        $('#modalUpdateUser').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
    });

    $('.div-user-list').delegate('.a-chg-stat', 'click', function () {

        var uid = $(this).parent('div').attr('id');
        $('.msgmodal-header').html("Change Status");
        var cur_stat = $(this).attr('data-stat');
        var msg = "";
        if (cur_stat == "1") {
            msg += '<div class="div-rdo-active">';
            msg += '<input type="radio" name="rdo_stat" id="rdo_1" value="1" checked> <label for="rdo_1">Active</label>';
            msg += '</div>';
            msg += '<divclass="div-rdo-inactive">';
            msg += '<input type="radio" name="rdo_stat" id="rdo_0" value="0"> <label for="rdo_0">Inactive</label>';
            msg += '</div>';
        } else {
            msg += '<div>';
            msg += '<input type="radio" name="rdo_stat" id="rdo_1" value="1" > <label for="rdo_1">Active</label>';
            msg += '</div>';
            msg += '<div>';
            msg += '<input type="radio" name="rdo_stat" id="rdo_0" value="0" checked> <label for="rdo_0">Inactive</label>';
            msg += '</div>';
        }
        msg += '</div>';
        $('.msgmodal-body').html(msg);
        var footer = ' <a type="button" class="btn  btn-info  btn-modal-status-change" data-cur_stat="' + cur_stat + '" data-uid="' + uid + '" selected-role="0" data-dismiss="modal">Change</a>';
        footer += '<a type="button" class="btn  btn-info"  data-dismiss="modal" aria-label="Close">Cancel</a>';
        $('.msgmodal-footer').html(footer);
        $('#msgmodal').modal('show');
    });

    $('#msgmodal').delegate('.btn-modal-status-change', 'click', function () {
        var uid = $(this).attr('data-uid');
        var cur_stat = $(this).attr('data-cur_stat');
        var newStat = $('input[name=rdo_stat]:checked').val();
        if (cur_stat !== newStat) {
            $.post(sAjaxUsers, {
                type: "setUserStatus",
                uid: uid,
                newStat: newStat,
            }, function (rs) {
                if (rs.data.php_validation.flag == "0") {
                    $('.msgmodal-header').html("Warning");
                    $('.msgmodal-body').html("Insuficient values");
                    var footer = '  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
                    $('.msgmodal-footer').html(footer);
                    $('.close').hide();
                    $('#msgmodal').modal('show');
                } else {
                    $('.msgmodal-header').html("Result");
                    $('.msgmodal-body').html("User status was successfully changed");
                    var footer = '  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
                    $('.msgmodal-footer').html(footer);
                    $('.close').hide();
                    $('#msgmodal').modal('show');
                    getAllUsers();
                }

            }, 'json');
        }

    });

    $('.rs-pagination').delegate('.page-link', 'click', function () {
        var page = parseInt($(this).attr('data-page'));
        $('#user_list').attr('datapage', page);

        getAllUsers(page);
    });

    $('.my-rs-pagination').delegate('.page-link', 'click', function () {
        var page = parseInt($(this).attr('data-page'));
        $('#user_list-my_users').attr('datapage', page);

        getMyUsers(page);
    });

    $('.sel-orderby').change(function () {
        $('#user_list').attr('datapage', 1);
        getAllUsers();
    });

    $('.div-user-list').delegate('.ellipse-action', 'click', function (e) {
        var id = $(this).attr('data-id');
        if ($('#id-' + id).is(":visible")) {
            $('#id-' + id).hide();
            $('.a-ellipse').removeClass('ellipse-selected');
        } else {
            $('.action-menu').hide();
            $('.a-ellipse').removeClass('ellipse-selected');
            $('#id-' + id).show();
            $('.a-ellipse-' + id).addClass('ellipse-selected');
        }
    });
    $('#div-my-user-list').delegate('.ellipse-action', 'click', function (e) {
        var id = $(this).attr('data-id');
        if ($('#myid-' + id).is(":visible")) {
            $('#myid-' + id).hide();
            $('.a-ellipse').removeClass('ellipse-selected');
        } else {
            $('.action-menu').hide();
            $('.a-ellipse').removeClass('ellipse-selected');
            $('#myid-' + id).show();
            $('.a-ellipse-' + id).addClass('ellipse-selected');
        }
    });

    $('.alltxt_search').change(function () {
        setTimeout(function () {
            $('#user_list').attr('datapage', 1);
            getAllUsers();
        }, 200);
    });

    $('.mytxt_search').change(function () {
        setTimeout(function () {
            $('#user_list-my_users').attr('datapage', 1);
            getMyUsers();
        }, 200);
    });

    $('#searchby').change(function () {
        setTimeout(function () {
            $('#user_list').attr('datapage', 1);
            getAllUsers();
        }, 1000);
    });

    $('.txt_search').on('keypress', function (e) {
        if (e.which == 13) {
            $('#user_list').attr('datapage', 1);
            getAllUsers(1);
        }
    });

    $('#filterby').change(function () {
        $('#user_list').attr('datapage', 1);
        getAllUsers();
    });

    $('.div-user-list').delegate('.stat-change', 'click', function () {
        var id = $(this).attr('data-id');
        var stat = $(this).attr('data-stat');
        var newStat = "1";
        if (id !== "iZb0XWIqBZQwFs5XJsRXJH0U85Ew87sM9M5GPC0bVusQiCY3Q5l") {
            //change
            var msg = "Click change to set user status to <b>active</b>";
            if (stat == "1") {
                msg = "Click change to set user status to <b>inactive</b>";
                newStat = "0";
            }
            $('.msgmodal-header').html("Confirmation");
            $('.msgmodal-body').html(msg);
            var footer = '  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
            footer += '  <button type="button" class="btn btn-secondary btn-modal-change-status" dataid="' + id + '" datanewstat="' + newStat + '">Change</button>';
            $('.msgmodal-footer').html(footer);
            $('.close').hide();
            $('#msgmodal').modal('show');

        } else {
            //sorry
        }
    });

    $('#msgmodal').delegate('.btn-modal-change-status', 'click', function () {
        var id = $(this).attr('dataid');
        var stat = $(this).attr('datanewstat');
        $.post(sAjaxUsers, {
            type: "setUserStatus",
            uid: id,
            newStat: stat,
        }, function (rs) {
            if (rs.data.php_validation.flag == "0") {
                $('.msgmodal-header').html("Warning");
                $('.msgmodal-body').html("Insuficient values");
                var footer = '  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
                $('.msgmodal-footer').html(footer);
                $('.close').hide();
                $('#msgmodal').modal('show');
            } else {
                $('.msgmodal-header').html("Result");
                $('.msgmodal-body').html("User status was successfully changed");
                var footer = '  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
                $('.msgmodal-footer').html(footer);
                $('.close').hide();
                $('#msgmodal').modal('show');

                getAllUsers();
            }

        }, 'json');
    });

    //------------- filter function--------------//
    $('.btn-filter_list').click(function () {
        $('.filter_load_placeholder').show();
        getLoadingList();
        setTimeout(function () {
            getAllUsers();

        }, 100);
    });
    $('.btn-filter_clear').click(function () {
        $('.filter_load_placeholder').show();
        $('.chk-filter').prop('checked', false);
        getLoadingList();
        setTimeout(function () {
            getAllUsers();
        }, 100);

    });
    $('.mybtn-filter_list').click(function () {
        $('.myfilter_load_placeholder').show();
        getLoadingList();
        setTimeout(function () {
            getMyUsers();
        }, 100);
    });
    $('.mybtn-filter_clear').click(function () {
        $('.myfilter_load_placeholder').show();
        $('.mychk-filter').prop('checked', false);
        getLoadingList();
        setTimeout(function () {
            getMyUsers();
        }, 100);
    });
//---------- end of filter function--------//

    $('.btn-update-user').click(function () {
        $('#frm-user-details').submit();
    });



});


function proceedToUpdate() {
    icmsMessage({
        type: "msgConfirmation",
        title: "You are about to update user details.",
        onConfirm: function () {
            icmsMessage({
                type: "msgPreloader",
                visible: true
            });
            updateICMSUser();
        },
        onCancel: function () {
            $('#modalUpdateUser').modal('show');
        }
    });
}

$.validator.addMethod("validateRegion", function (value, element) {

    if ($('.grp-region:visible').length == 0) {
        return true;
    } else {
        if (parseInt($('#sel_region').val()) >= 1) {
            return true;
        }
    }

}, "This field is required.");

$('#frm-user-details').validate({

    rules: {
        txt_fname: {required: true},
        txt_lname: {required: true},
        sel_sex: {required: true},
        area_desc: {required: true},
        sel_country: {required: true},
        sel_state_prov: {required: true},
        area_detailed: {required: true},
        txt_mob: {required: true},
        sel_region: {
            validateRegion: true,
        },
        txt_email: {required: true, emailFormat: true, }
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
        $('#modalUpdateUser').modal('hide');
        var user_id = $('.btn-update').attr('data-id');

        if ($('#txt_email').val() == $('#txt_email').attr('orgemail')) {
            //proceed
            proceedToUpdate();
        } else {
            icmsMessage({
                type: "msgPreloader",
                body: "Checking email availability, Please wait . . .",
                visible: true
            });

            $.post(sAjaxUsers, {
                type: "getEmailAvailability", // update details
                email: $('#txt_email').val(),
                user_id: user_id,
            }, function (rs) {
                icmsMessage({
                    type: "msgPreloader",
                    visible: false
                });

                if (parseInt(rs.data) >= 1) {
                    icmsMessage({
                        type: "msgWarning",
                        body: "Email is already taken!",
                        caption: "Close",
                        onHide: function () {
                            $('#modalUpdateUser').modal('show');
                        }
                    });
                } else {
                    //proceed
                    proceedToUpdate();
                }
            }, 'json');
        }

    }

});

//---------- enable and disable update button--------//
$("input[type=submit]").attr("disabled", "disabled");
$('input').change(function () {
    $(".btn-update-user").removeAttr("disabled");
});

