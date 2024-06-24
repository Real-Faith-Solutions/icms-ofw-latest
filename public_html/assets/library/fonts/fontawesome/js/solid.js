$(document).ready(function () {
    getCountries();
    getRegions();
    getProvinces();
    getCities();
    getBarangay();
    getSex();
    getCivilStatus();
    getCasePurposes();
    getContactTypes();
    getReligions();
    getEducationalAttainments();
    getFamilyRelations();

    var cid = $('#case_id').val();
    localStorage.setItem('cid', cid);
    getVictimInfoByCaseId();

    $("#frm-personal :input").prop("disabled", true);
    $("#frm-assumed :input").prop("disabled", true);

    //remove and update
    //contact info actions
    $('.victim-contact_info_list').delegate('.rm-victim_contact_info', 'click', function () {
        var id = $(this).attr('data-id');
        icmsMessage({
            type: "msgConfirmation",
            title: "You are about to remove victim contact information",
            LblBtnConfirm: "Remove",
            body: "Click Remove button if you wish to continue.",
            onConfirm: function () {
                removeVictimContactInfoById(id);
            }
        });


    });

    $('.victim-contact_info_list').delegate('.up-victim_contact_info', 'click', function () {
        var id = $(this).attr('data-id');
        $('.stored-contact_id').val(id);
        getVictimContactInfoById(id);
    });

    //education info actions
    $('.victim-education_info_list').delegate('.rm-victim_education_info', 'click', function () {
        var id = $(this).attr('data-id');

        icmsMessage({
            type: "msgConfirmation",
            title: "You are about to remove victim education",
            body: "Click remove button if you wish to continue.",
            LblBtnConfirm: "Remove",
            onConfirm: function () {
                removeVictimEducationInfoById(id);
            }
        });


    });

    $('.victim-education_info_list').delegate('.up-victim_education_info', 'click', function () {
        var id = $(this).attr('data-id');
        $('.stored-education_id').val(id);
        getVictimEducationInfoById(id);
    });

    //address info actions
    $('.victim-address_info_list').delegate('.rm-victim_address_info', 'click', function () {
        var id = $(this).attr('data-id');

        icmsMessage({
            type: "msgConfirmation",
            title: "You are about to remove victim address information",
            body: "Click remove button if you wish to continue.",
            LblBtnConfirm: "Remove",
            onConfirm: function () {
                removeVictimAddressInfoById(id);
            }
        });
    });

    $('.a-vi-relative_type').change(function () {
        var selected = $(".a-vi-relative_type option:selected").text().toLowerCase().replace(" ", "");

        if (selected === "other") {
            $('.row-other').removeClass("hide");
        } else {
            $('.row-other').addClass("hide");
        }
        $(".a-vi-relative_other").val("");
    });

    $('.u-vi-victim_relative_type').change(function () {
        var selected = $(".u-vi-victim_relative_type option:selected").text().toLowerCase().replace(" ", "");

        if (selected === "other") {
            $('.row-other-u').removeClass("hide");
        } else {
            $('.row-other-u').addClass("hide");
        }
        $(".u-vi-relative_other").val("");
    });

    $('.victim-address_info_list').delegate('.up-victim_address_info', 'click', function () {
        var id = $(this).attr('data-id');
        $('.stored-address_id').val(id);

        getVictimAddressInfoById(id);
    });

    //relative info actions
    $('.victim-relative_info_list').delegate('.rm-victim_relative_info', 'click', function () {
        var id = $(this).attr('data-id');

        icmsMessage({
            type: "msgConfirmation",
            title: "You are about to remove Next of Kin",
            body: "Click remove button if you wish to continue.",
            LblBtnConfirm: "Remove",
            onConfirm: function () {
                removeVictimRelativeInfoById(id);
            }
        });

    });

    $('.victim-relative_info_list').delegate('.up-victim_relative_info', 'click', function () {
        var id = $(this).attr('data-id');
        $('.stored-relative_id').val(id);

        getVictimRelativeInfoById(id);
    });

    //open modals
    $('.btn-add_contact').click(function () {
        $("#modal-add_contact_info").modal('show');
    });

    $('.btn-add_education').click(function () {
        $("#modal-add_education_info").modal('show');
    });

    $('.btn-add_address').click(function () {
        $("#modal-add_address_info").modal('show');
    });

    $('.btn-add_relative').click(function () {
        $("#modal-add_relative_info").modal('show');
    });


    //show hide, enable disabled
    $('.a-vi-education_type').change(function () {
        var str = $('.a-vi-education_type option:selected').attr('data-name');
        var n = str.includes('Undergraduate');
        if (!n) {
            $('.field-education_grade_year').hide();
            $('.a-vi-education_grade_year').val('');
        } else {
            $('.field-education_grade_year').show();
        }
    });

    $('.a-vi-address_region').change(function () {

        getProvincesByRegionId(this.value);
        $('.a-vi-address_province').attr('disabled', false);
    });

    $('.a-vi-address_province').change(function () {
        getCityByProvinceId(this.value);
        $('.a-vi-address_city').attr('disabled', false);
    });

    $('.a-vi-address_city').change(function () {
        getBrgyByCityID(this.value);
        $('.a-vi-address_barangay').attr('disabled', false);
    });

    $('.u-vi-victim_address_list_region_id').change(function () {

        getProvincesByRegionId(this.value);
        $('.u-vi-victim_address_list_province_id').attr('disabled', false);
    });

    $('.u-vi-victim_address_list_province_id').change(function () {
        getCityByProvinceId(this.value);
        $('.u-vi-victim_address_list_city_id').attr('disabled', false);
    });

    $('.u-vi-victim_address_list_city_id').change(function () {
        getBrgyByCityID(this.value);
        $('.u-vi-victim_address_list_brgy_id').attr('disabled', false);
    });

    //form actions
    $("#form-update_victim_details").validate({
        rules: {
            first_name: {required: true},
            last_name: {required: true}
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error);
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            updateCaseVictimInfoByVictimId();
        }
    });

    $('#form-add_contact_info').validate({
        rules: {
            contact_type: {required: true},
            contact_content: {required: true}
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error);
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {

            icmsMessage({
                type: "msgConfirmation",
                title: "You are about to add new victim contact information",
                onConfirm: function () {
                    addContactInfoByVictimId();
                },
                onShow: function () {
                    $('#modal-add_contact_info').modal('hide');
                },
                onCancel: function () {
                    $('#modal-add_contact_info').modal('show');
                }
            });


        }
    });

    $('#form-update_contact_info').validate({
        rules: {
            contact_type: {required: true},
            contact_content: {required: true}
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error);
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {

            icmsMessage({
                type: "msgConfirmation",
                title: "You are about update contact details",
                onConfirm: function () {
                    updateVictimContactInfoById();
                },
                onShow: function () {
                    $('#modal-update_contact_info').modal('hide');
                },
                onCancel: function () {
                    $('#modal-update_contact_info').modal('show');
                }
            });

        }
    });

    $('#form-add_education_info').validate({
        rules: {
            education_type: {required: true},
            education_school: {required: true},
            yearStart: {required: true, pastYear: true, },
            yearEnd: {required: true, pastYear: true, },
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error);
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $('#modal-add_education_info').modal('hide');
            icmsMessage({
                type: "msgConfirmation",
                title: "You are about to add victim's education",
                onConfirm: function () {
                    addEducationInfoByVictimId();
                },
                onCancel: function () {
                    $('#modal-add_education_info').modal('show');
                }
            });
        }
    });

    $('#form-update_education_info').validate({
        rules: {
            education_type: {required: true},
            education_school: {required: true}
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error);
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {

            icmsMessage({
                type: "msgConfirmation",
                title: "You are about to update education",
                onConfirm: function () {
                    updateVictimEducationInfoById();
                },
                onShow: function () {
                    $('#modal-update_education_info').modal('hide');
                },
                onCancel: function () {
                    $('#modal-update_education_info').modal('show');
                }
            });


        }
    });

    $('#form-add_address_info').validate({
        rules: {
            region: {required: true},
            province: {required: true},
            city: {required: true},
            address: {required: true}
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error);
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {

            icmsMessage({
                type: "msgConfirmation",
                title: "You are about to add new victim address information",
                onConfirm: function () {
                    addAddressInfoByVictimId();
                },
                onShow: function () {
                    $('#modal-add_address_info').modal('hide');
                },
                onCancel: function () {
                    $('#modal-add_address_info').modal('show');
                }
            });

        }
    });

    $('#form-update_address_info').validate({
        rules: {
            region: {required: true},
            province: {required: true},
            city: {required: true},
            address: {required: true}
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error);
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {


            icmsMessage({
                type: "msgConfirmation",
                title: "You are about to update address information ",
                onConfirm: function () {
                    updateVictimAddressInfoById();
                },
                onShow: function () {
                    $('#modal-update_address_info').modal('hide');
                },
                onCancel: function () {
                    $('#modal-update_address_info').modal('show');
                }
            });




        }
    });

    $('#form-add_relative_info').validate({
        rules: {
            relative_type: {required: true},
            relative_name: {required: true},
            email: {email: true},
            primary_contact: {maxlength: 13, minlength: 7},
            secondary_contact: {maxlength: 13, minlength: 7}
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error);
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {

            icmsMessage({
                type: "msgConfirmation",
                title: "You are about to add next of kin information ",
                onConfirm: function () {
                    addRelativeInfoByVictimId();
                },
                onShow: function () {
                    $('#modal-add_relative_info').modal('hide');
                },
                onCancel: function () {
                    $('#modal-add_relative_info').modal('show');
                }
            });


        }
    });

    $('#form-update_relative_info').validate({
        rules: {
            relative_type: {required: true},
            relative_name: {required: true},
            email: {email: true},
            primary_contact: {maxlength: 13, minlength: 7},
            secondary_contact: {maxlength: 13, minlength: 7}
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error);
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {

            icmsMessage({
                type: "msgConfirmation",
                title: "You are about to update Next of Kin information ",
                onConfirm: function () {
                    updateVictimRelativeInfoById();
                },
                onShow: function () {
                    $('#modal-update_relative_info').modal('hide');
                },
                onCancel: function () {
                    $('#modal-update_relative_info').modal('show');
                }
            });
        }
    });

    //show actions
    $('.card_tbl-container').delegate('.ellipse-action', 'click', function (e) {
        var id = $(this).attr('data-id');
        if ($('#' + id).is(":visible")) {
            $('#' + id).hide();
            $('.a-ellipse').removeClass('ellipse-selected');
        } else {
            $('.action-menu').hide();
            $('.a-ellipse').removeClass('ellipse-selected');
            $('#' + id).show();
            $('.a-ellipse-' + id).addClass('ellipse-selected');
        }
    });

    $('.a-vi-contact_type').change(function () {
        var caption = $('.a-vi-contact_type option:selected').text();
        $('.lbl-contact-value').text(caption);
    });

    $('#btn-manage-assumed').click(function () {
        var caption = $(this).text();
        if (caption == "Manage") {
            $(this).text("Cancel");
            $('#btn-save-assumed').removeClass("hide");
            $("#frm-assumed :input").prop("disabled", false);
        } else {
            $(this).text("Manage");
            $('#btn-save-assumed').addClass("hide");
            $("#frm-assumed :input").prop("disabled", true);
        }
    });

    $('#btn-manage-personal').click(function () {
        var caption = $(this).text();
        if (caption == "Manage") {
            $(this).text("Cancel");
            $('#btn-save-personal').removeClass("hide");
            $("#frm-personal :input").prop("disabled", false);
        } else {
            $(this).text("Manage");
            $('#btn-save-personal').addClass("hide");
            $("#frm-personal :input").prop("disabled", true);
        }
    });

    $('#btn-save-personal').click(function () {

        icmsMessage({
            type: "msgConfirmation",
            title: "You are about to update victim's personal information",
            onConfirm: function () {

                icmsMessage({
                    type: "msgPreloader",
                    body: "Saving... Please wait!",
                    visible: true
                });

                $.post(sAjaxVictims, {
                    type: "setVictimInfoByCaseId",
                    case_id: $('#case_id').val(),
                    fname: $('.vi-victim_info_first_name').val(),
                    mname: $('.vi-victim_info_middle_name').val(),
                    lname: $('.vi-victim_info_last_name').val(),
                    xtname: $('.vi-victim_info_suffix').val(),
                    dob: $('.vi-victim_info_dob').val(),
                    pob: $('.vi-victim_info_city_pob').val(),
                    gender: $('.vi-victim_gender').val(),
                    civilStat: $('.vi-victim_civil_status').val(),
                    religion: $('.vi-victim_religion').val(),
                    nickname: $('.vi-victim_info_nickname').val(),
                    ethnic_group: $('.vi-victim_ethnic_group').val(),
                }, function (rs) {
                    $('#btn-manage-personal').click();
                    notifyChangesInReport();

                }, 'json');
            }
        });

    });


    $('#btn-save-assumed').click(function () {
        icmsMessage({
            type: "msgConfirmation",
            title: "You are about to update the assumed victim information",
            onConfirm: function () {
                icmsMessage({
                    type: "msgPreloader",
                    body: "Saving... Please wait!",
                    visible: true
                });

                $.post(sAjaxVictims, {
                    type: "setAssumedVictimInfoByCaseId",
                    case_id: $('#case_id').val(),
                    fname: $('.vi-assumed-victim_info_first_name').val(),
                    mname: $('.vi-assumed-victim_info_middle_name').val(),
                    lname: $('.vi-assumed-victim_info_last_name').val(),
                    dob: $('.vi-assumed-victim_info_dob').val(),
                    disabilities: $('.vi-disability').val(),
                    allergy: $('.vi-allergies').val(),
                    illness: $('.vi-history_of_illness').val(),
                    other_history_hospitalization:  $('.vi-other_info_hospitalization').val(),
                }, function (rs) {
                    //modal for incorect param
                    $('#btn-manage-assumed').click();
                    notifyChangesInReport();
                }, 'json');
            }
        });
    });


}); // end of document



function getVictimInfoByCaseId() {

    icmsMessage({
        type: "msgPreloader",
        visible: true,
        body: "Please wait while loading details.",
    });

    $.post(sAjaxVictims, {
        type: "getVictimInfoByCaseId",
        case_id: localStorage.getItem('cid')
    }, function (rs) {
        localStorage.setItem('vid', rs.data.victim_id);
        localStorage.setItem('cvid', rs.data.case_victim_id);

        var vi = rs.data.victim_info;
        $.each(vi, function (key, val) {
            $('.vi-' + key).val(val);
        });


        if (vi.victim_info_dob !== null && vi.victim_info_dob != "") {
            $('.vi-victim_info_dob').val(dateFormatToPicker(vi.victim_info_dob));
        }

        var vi_assumed = rs.data.victim_info_assumed;
        $.each(vi_assumed, function (key, val) {
            $('.vi-assumed-' + key).val(val);
        });

        if (typeof vi_assumed.victim_info_dob !== "undefined" && vi_assumed.victim_info_dob !== null && vi_assumed.victim_info_dob != "") {
            $('.vi-assumed-victim_info_dob').val(dateFormatToPicker(vi_assumed.victim_info_dob));
        }

        var victim_contacts = rs.data.victim_contact_info;

        var t = '';
        if (victim_contacts.length > 0) {
            $.each(victim_contacts, function (key, val) {

                t += '<tr>';
                t += '<td>' + val.contact_type + '</td>';
                t += '<td>' + val.victim_contact_detail_content + '</td>';
                t += '<td> <div class="btn-group ellipse-action" data-id="vi-contact_info_list' + val.victim_contact_details_id + '" data-tab="">';
                t += '<a class="a-ellipse a-ellipse-' + val.victim_contact_details_id + ' " >  <i class="fa fa-ellipsis-v" aria-hidden="true"></i> </a>';
                t += '<div class="action-menu" id="vi-contact_info_list' + val.victim_contact_details_id + '">';
                t += '<a class="dropdown-item disabled action-title" href="#">Select Action</a>';
                t += '<a class="dropdown-item up-victim_contact_info" data-id="' + val.victim_contact_details_id + '" >Update</a>';
                t += '<a class="dropdown-item rm-victim_contact_info" data-id="' + val.victim_contact_details_id + '" >Remove</a>';
                t += '</div>';
                t += '</div> </td>';
                t += '</tr>';


            });
        } else {
            t += '<tr>';
            t += '<td colspan="3" class="text-center">No contact info added to list.</td>';
            t += '</tr>';
        }

        $('.victim-contact_info_list').html(t);

        var victim_educations = rs.data.victim_education_info;
        var t = '';
        if (victim_educations.length > 0) {
            $.each(victim_educations, function (key, val) {

                t += '<tr>';
                t += '<td>' + val.education_type_name + '</td>';
                t += '<td>' + val.victim_education_school + '</td>';
                t += '<td>' + val.victim_education_end + '</td>';
                t += '<td> <div class="btn-group ellipse-action" data-id="vi-education_info_list' + val.victim_education_id + '" data-tab="">';
                t += '<a class="a-ellipse a-ellipse-' + val.victim_education_id + ' " >  <i class="fa fa-ellipsis-v" aria-hidden="true"></i> </a>';
                t += '<div class="action-menu" id="vi-education_info_list' + val.victim_education_id + '">';
                t += '<a class="dropdown-item disabled action-title" href="#">Select Action</a>';
                t += '<a class="dropdown-item up-victim_education_info" data-id="' + val.victim_education_id + '" >Update</a>';
                t += '<a class="dropdown-item rm-victim_education_info" data-id="' + val.victim_education_id + '" >Remove</a>';
                t += '</div>';
                t += '</div> </td>';
                t += '</tr>';


            });
        } else {
            t += '<tr>';
            t += '<td colspan="4" class="text-center">No education info added to list.</td>';
            t += '</tr>';
        }

        $('.victim-education_info_list').html(t);

        var victim_address = rs.data.victim_address_info;
        var t = '';

        if (victim_address.length > 0) {
//            console.log(victim_address);
            $.each(victim_address, function (key, val) {
                var attribs = "";
//                attribs = 'dta-address="' + val.victim_address_list_address + '" dta-brgy="' + val.brgy + '" dta-city="' + val.city + '" dta-prov="' + val.province + '" dta-region="' + val.region + '" dta-cntry="' + val.country + '"';

                t += '<tr ' + attribs + '>';
                t += '<td>';
                t += val.victim_address_list_address + ' ' + val.brgy + ' ' + val.city + ', ' + val.province + ', ' + val.region + ' ' + val.country;
                t += '</td>';
                t += '<td> <div class="btn-group ellipse-action" data-id="vi-address_info_list' + val.victim_address_list_id + '" data-tab="">';
                t += '<a class="a-ellipse a-ellipse-' + val.victim_address_list_id + ' " >  <i class="fa fa-ellipsis-v" aria-hidden="true"></i> </a>';
                t += '<div class="action-menu" id="vi-address_info_list' + val.victim_address_list_id + '">';
                t += '<a class="dropdown-item disabled action-title" href="#">Select Action</a>';
                t += '<a class="dropdown-item up-victim_address_info" data-id="' + val.victim_address_list_id + '" >Update</a>';
                t += '<a class="dropdown-item rm-victim_address_info" data-id="' + val.victim_address_list_id + '" >Remove</a>';
                t += '</div>';
                t += '</div> </td>';
                t += '</tr>';

            });
        } else {
            t += '<tr>';
            t += '<td colspan="2" class="text-center">No address info added to list.</td>';
            t += '</tr>';
        }

        $('.victim-address_info_list').html(t);

        var victim_relatives = rs.data.victim_relatives_info;
        var t = '';

        if (victim_relatives.length > 0) {
            $.each(victim_relatives, function (key, val) {

                t += '<tr>';
                t += '<td>' + val.victim_relative_type_name + '</td>';
                t += '<td>' + val.victim_relative_fullname + '</td>';
                t += '<td>' + val.victim_relative_primary_contact_number + '</td>';
                t += '<td> <div class="btn-group ellipse-action" data-id="vi-relative_info_list' + val.victim_relative_id + '" data-tab="">';
                t += '<a class="a-ellipse a-ellipse-' + val.victim_relative_id + ' " >  <i class="fa fa-ellipsis-v" aria-hidden="true"></i> </a>';
                t += '<div class="action-menu" id="vi-relative_info_list' + val.victim_relative_id + '">';
                t += '<a class="dropdown-item disabled action-title" href="#">Select Action</a>';
                t += '<a class="dropdown-item up-victim_relative_info" data-id="' + val.victim_relative_id + '" >Update</a>';
                t += '<a class="dropdown-item rm-victim_relative_info" data-id="' + val.victim_relative_id + '" >Remove</a>';
                t += '</div>';
                t += '</div> </td>';
                t += '</tr>';

            });
        } else {
            t += '<tr>';
            t += '<td colspan="4" class="text-center">No relative info added to list.</td>';
            t += '</tr>';
        }

        $('.victim-relative_info_list').html(t);

        icmsMessage({
            type: "msgPreloader",
            visible: false
        });

    }, 'json');
}

function updateCaseVictimInfoByVictimId() {

    icmsModal({
        title: 'Processing Request.....',
        body: '<center>Please wait while loading <div class="spinner-border text-warning"></div><center>',
        footer_button: true
    });

    $.post(sAjaxCase, {
        type: "updateCaseVictimInfoByVictimId",
        victim_id: localStorage.getItem('vid'),
        victim_info_first_name: $('.vi-victim_info_first_name').val(),
        victim_info_middle_name: $('.vi-victim_info_middle_name').val(),
        victim_info_last_name: $('.vi-victim_info_last_name').val(),
        victim_info_suffix: $('.vi-victim_info_suffix').val(),
        victim_info_dob: $('.vi-victim_info_dob').val(),
        victim_info_city_pob: $('.vi-victim_info_city_pob').val(),
        assumed_victim_info_first_name: $('.vi-assumed-victim_info_first_name').val(),
        assumed_victim_info_middle_name: $('.vi-assumed-victim_info_middle_name').val(),
        assumed_victim_info_last_name: $('.vi-assumed-victim_info_last_name').val(),
        assumed_victim_info_dob: $('.vi-assumed-victim_info_dob').val(),
        victim_gender: $('.vi-victim_gender').val(),
        victim_civil_status: $('.vi-victim_civil_status').val(),
        victim_religion: $('.vi-victim_religion').val()
    }, function (rs) {
        if (rs.data.flag == 1) {
            icmsModal({
                title: 'Success',
                body: 'Case victim has been successfully updated.',
                footer_button: true
            });

            getVictimInfoByCaseId();
            notifyChangesInReport();
        }


    }, 'json');



}

//add
function addContactInfoByVictimId() {

    icmsMessage({
        type: "msgPreloader",
        body: "Please wait while adding new contact",
        visible: true
    });

    $.post(sAjaxVictims, {
        type: "addVictimContactByVictimId",
        victim_id: localStorage.getItem('vid'),
        case_id: $('#case_id').val(),
        contact_type: $('.a-vi-contact_type').val(),
        contact_content: $('.a-vi-contact_content').val()
    }, function (rs) {
        if (rs.data.flag == 1) {

            $('#form-add_contact_info')[0].reset();
            getVictimInfoByCaseId();

            notifyChangesInReport();
        }

    }, 'json');

}

function addEducationInfoByVictimId() {
    icmsMessage({
        type: "msgPreloader",
        body: "Saving... Please wait!",
        visible: true
    });

    $.post(sAjaxVictims, {
        type: "addVictimEducationByVictimId",
        victim_id: localStorage.getItem('vid'),
        education_type: $('.a-vi-education_type').val(),
        education_school: $('.a-vi-education_school').val(),
        education_grade_year: $('.a-vi-education_grade_year').val(),
        education_course: $('.a-vi-education_course').val(),
        education_start: $('.a-vi-education_start').val(),
        education_end: $('.a-vi-education_end').val(),
        case_id: $('#case_id').val(),
    }, function (rs) {
        if (rs.data.flag == 1) {
            $('#form-add_education_info')[0].reset();
            getVictimInfoByCaseId();
            notifyChangesInReport();

        }

    }, 'json');

}

function addAddressInfoByVictimId() {
    icmsMessage({
        type: "msgPreloader",
        body: "Saving... Please wait!",
        visible: true
    });

    $.post(sAjaxVictims, {
        type: "addVictimAddressByVictimId",
        victim_id: localStorage.getItem('vid'),
        address_region: $('.a-vi-address_region').val(),
        address_province: $('.a-vi-address_province').val(),
        address_city: $('.a-vi-address_city').val(),
        address_barangay: $('.a-vi-address_barangay').val(),
        address_complete: $('.a-vi-address_complete').val(),
        case_id: $('#case_id').val(),
    }, function (rs) {
        if (rs.data.flag == 1) {

            $('#form-add_address_info')[0].reset();
            getVictimInfoByCaseId();
            notifyChangesInReport();
        }

    }, 'json');

}

function addRelativeInfoByVictimId() {
    icmsMessage({
        type: "msgPreloader",
        body: "Saving... Please wait!",
        visible: true
    });

    $.post(sAjaxVictims, {
        type: "addVictimRelativeByVictimId",
        victim_id: localStorage.getItem('vid'),
        relative_type: $('.a-vi-relative_type').val(),
        relative_name: $('.a-vi-relative_name').val(),
        relative_primary_contact_number: $('.a-vi-relative_primary_contact_number').val(),
        relative_secondary_contact_number: $('.a-vi-relative_secondary_contact_number').val(),
        relative_email: $('.a-vi-relative_email').val(),
        case_id: $('#case_id').val(),
        victim_relative_type_other: $('.a-vi-relative_other').val(),
    }, function (rs) {
        if (rs.data.flag == 1) {

            getVictimInfoByCaseId();
            notifyChangesInReport();
            $('#form-add_relative_info')[0].reset();

        }

    }, 'json');

}

//remove
function removeVictimContactInfoById(id) {

    icmsMessage({
        type: "msgPreloader",
        body: "Removing... Please wait!",
        visible: true
    });

    $.post(sAjaxVictims, {
        type: "removeVictimContactInfoById",
        victim_contact_details_id: id,
        case_id: $('#case_id').val(),
    }, function (rs) {

        if (rs.data.flag == 1) {
            getVictimInfoByCaseId();
            notifyChangesInReport();
        }

    }, 'json');

}

function removeVictimEducationInfoById(id) {

    icmsMessage({
        type: "msgPreloader",
        body: "Saving... Please wait!",
        visible: true
    });

    $.post(sAjaxVictims, {
        type: "removeVictimEducationInfoById",
        victim_education_id: id,
        case_id: $('#case_id').val(),
    }, function (rs) {

        if (rs.data.flag == 1) {
            getVictimInfoByCaseId();
            notifyChangesInReport();
        }

    }, 'json');

}

function removeVictimAddressInfoById(id) {

    icmsMessage({
        type: "msgPreloader",
        body: "Removing... Please wait!",
        visible: true
    });

    $.post(sAjaxVictims, {
        type: "removeVictimAddressInfoById",
        victim_address_list_id: id,
        case_id: $('#case_id').val(),
    }, function (rs) {

        if (rs.data.flag == 1) {

            getVictimInfoByCaseId();
            notifyChangesInReport();
        }

    }, 'json');

}

function removeVictimRelativeInfoById(id) {

    icmsMessage({
        type: "msgPreloader",
        body: "Removing... Please wait!",
        visible: true
    });

    $.post(sAjaxVictims, {
        type: "removeVictimRelativeInfoById",
        victim_relative_id: id,
        case_id: $('#case_id').val(),
    }, function (rs) {

        if (rs.data.flag == 1) {
           
            getVictimInfoByCaseId();
            notifyChangesInReport();
        }

    }, 'json');

}

//get
function getVictimContactInfoById(id) {

    $.post(sAjaxVictims, {
        type: "getVictimContactInfoById",
        victim_contact_details_id: id
    }, function (rs) {

        if (rs.data.flag == 1) {
            $.each(rs.data.victim_contact_info, function (key, val) {
                $('.u-vi-' + key).val(val);
            });
            $('#modal-update_contact_info').modal('show');

        }

    }, 'json');


}

function updateVictimContactInfoById() {

    icmsMessage({
        type: "msgPreloader",
        body: "Saving... Please wait!",
        visible: true
    });


    $.post(sAjaxVictims, {
        type: "updateVictimContactInfoById",
        case_id: $('#case_id').val(),
        victim_contact_details_id: $('.stored-contact_id').val(),
        victim_contact_detail_type: $('.u-vi-victim_contact_detail_type').val(),
        victim_contact_detail_content: $('.u-vi-victim_contact_detail_content').val()
    }, function (rs) {

        if (rs.data.flag == 1) {
            icmsMessage({
                type: "msgSuccess",
                body: "Victim contact info has been updated",
                onShow: function () {
                    getVictimInfoByCaseId();
                    $('#modal-update_contact_info').modal('hide');
                    notifyChangesInReport();
                }
            });

        }

    }, 'json');
}

function getVictimEducationInfoById(id) {

    $.post(sAjaxVictims, {
        type: "getVictimEducationInfoById",
        victim_education_id: id
    }, function (rs) {

        if (rs.data.flag == 1) {
            $.each(rs.data.victim_education_info, function (key, val) {
                $('.u-vi-' + key).val(val);
            });
            $('#modal-update_education_info').modal('show');

        }

    }, 'json');


}

function updateVictimEducationInfoById() {

    icmsMessage({
        type: "msgPreloader",
        body: "Saving... Please wait!",
        visible: true
    });

    $.post(sAjaxVictims, {
        type: "updateVictimEducationInfoById",
        victim_education_id: $('.stored-education_id').val(),
        victim_education_type: $('.u-vi-victim_education_type').val(),
        victim_education_grade_year: $('.u-vi-victim_education_grade_year').val(),
        victim_education_school: $('.u-vi-victim_education_school').val(),
        victim_education_course: $('.u-vi-victim_education_course').val(),
        victim_education_start: $('.u-vi-victim_education_start').val(),
        victim_education_end: $('.u-vi-victim_education_end').val(),
        case_id: $('#case_id').val(),
    }, function (rs) {

        if (rs.data.flag == 1) {
            getVictimInfoByCaseId();
            $('#modal-update_education_info').modal('hide');
            notifyChangesInReport();

        }

    }, 'json');
}

function getVictimAddressInfoById(id) {

    $.post(sAjaxVictims, {
        type: "getVictimAddressInfoById",
        victim_address_list_id: id
    }, function (rs) {

        if (rs.data.flag == 1) {
            $.each(rs.data.victim_address_info, function (key, val) {
                $('.u-vi-' + key).val(val);
            });
            $('#modal-update_address_info').modal('show');

        }

    }, 'json');


}

function updateVictimAddressInfoById() {

    icmsMessage({
        type: "msgPreloader",
        body: "Saving... Please wait!",
        visible: true
    });

    $.post(sAjaxVictims, {
        type: "updateVictimAddressInfoById",
        victim_address_list_id: $('.stored-address_id').val(),
        victim_address_list_region_id: $('.u-vi-victim_address_list_region_id').val(),
        victim_address_list_province_id: $('.u-vi-victim_address_list_province_id').val(),
        victim_address_list_city_id: $('.u-vi-victim_address_list_city_id').val(),
        victim_address_list_brgy_id: $('.u-vi-victim_address_list_brgy_id').val(),
        victim_address_list_address: $('.u-vi-victim_address_list_address').val(),
        case_id: $('#case_id').val(),
    }, function (rs) {

        if (rs.data.flag == 1) {

            getVictimInfoByCaseId();
            $('#modal-update_address_info').modal('hide');
            notifyChangesInReport();

        }

    }, 'json');
}

function getVictimRelativeInfoById(id) {

    $.post(sAjaxVictims, {
        type: "getVictimRelativeInfoById",
        victim_relative_id: id
    }, function (rs) {
        if (rs.data.flag == 1) {
            $.each(rs.data.victim_relative_info, function (key, val) {
                $('.u-vi-' + key).val(val);
            });


            $('#modal-update_relative_info').modal('show');
            var selected = $(".u-vi-victim_relative_type option:selected").text().toLowerCase().replace(" ", "");
            if (selected === "other") {
                $('.row-other-u').removeClass("hide");
            } else {
                $('.row-other-u').addClass("hide");
            }

        }

    }, 'json');


}

function updateVictimRelativeInfoById() {

    icmsMessage({
        type: "msgPreloader",
        body: "Saving... Please wait!",
        visible: true
    });

    $.post(sAjaxVictims, {
        type: "updateVictimRelativeInfoById",
        victim_relative_id: $('.stored-relative_id').val(),
        victim_relative_fullname: $('.u-vi-victim_relative_fullname').val(),
        victim_relative_type: $('.u-vi-victim_relative_type').val(),
        victim_relative_primary_contact_number: $('.u-vi-victim_relative_primary_contact_number').val(),
        victim_relative_second_contact_number: $('.u-vi-victim_relative_second_contact_number').val(),
        victim_relative_email: $('.u-vi-victim_relative_email').val(),
        case_id: $('#case_id').val(),
        victim_relative_type_other: $('.u-vi-relative_other').val(),
    }, function (rs) {

        if (rs.data.flag == 1) {

            getVictimInfoByCaseId();
            $('#modal-update_relative_info').modal('hide');
            notifyChangesInReport();

        }

    }, 'json');
}