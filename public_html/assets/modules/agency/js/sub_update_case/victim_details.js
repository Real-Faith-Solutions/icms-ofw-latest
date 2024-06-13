function updateCaseVictimInfoByVictimId() {
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
            getVictimInfoByCaseId(1);
        }
    }, 'json');
}

//add
function addContactInfoByVictimId() {

    $.post(sAjaxVictims, {
        type: "addVictimContactByVictimId",
        victim_id: localStorage.getItem('vid'),
        case_id: $('#case_id').val(),
        contact_type: $('.a-vi-contact_type').val(),
        contact_content: $('.a-vi-contact_content').val()
    }, function (rs) {
        if (rs.data.flag == 1) {
            $('#form-add_contact_info')[0].reset();
            getVictimInfoByCaseId(1);
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
            getVictimInfoByCaseId(1);
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
            getVictimInfoByCaseId(1);
        }

    }, 'json');
}

function addRelativeInfoByVictimId() {

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
            $('#form-add_relative_info')[0].reset();
            getVictimInfoByCaseId(1);
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
            getVictimInfoByCaseId(1);
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
            getVictimInfoByCaseId(1);
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
            getVictimInfoByCaseId(1);
        }

    }, 'json');
}

function removeVictimRelativeInfoById(id) {

    icmsModal({
        title: 'Processing Request.....',
        body: '<center>Please wait while loading <div class="spinner-border text-warning"></div><center>',
        footer_button: true
    });
    $.post(sAjaxVictims, {
        type: "removeVictimRelativeInfoById",
        victim_relative_id: id,
        case_id: $('#case_id').val(),
    }, function (rs) {

        if (rs.data.flag == 1) {
            icmsModal({
                title: 'Success',
                body: 'Victim relative info has been removed.',
                footer_button: true
            });
            getVictimInfoByCaseId(1);
        }

    }, 'json');
}

//get
function getVictimContactInfoById(id) {

    $('#modal-update_contact_info').modal('show');

    $.post(sAjaxVictims, {
        type: "getVictimContactInfoById",
        victim_contact_details_id: id
    }, function (rs) {
        rs = html_entity_decode(rs);
        if (rs.data.flag == 1) {
            $.each(rs.data.victim_contact_info, function (key, val) {
                $('.u-vi-' + key).val(val);
                $('.u-vi-' + key).val(val).change();
            });
            aInitialValues["contact_info"] = '';
            aInitialValues["contact_info"] = getFormValues('form-update_contact_info');
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
            getVictimInfoByCaseId(1);
        }
    }, 'json');

}

function getVictimEducationInfoById(id) {

    $.post(sAjaxVictims, {
        type: "getVictimEducationInfoById",
        victim_education_id: id
    }, function (rs) {
        rs = html_entity_decode(rs);
        if (rs.data.flag == 1) {
            $.each(rs.data.victim_education_info, function (key, val) {
                $('.u-vi-' + key).val(val).change();
                $('.u-vi-' + key).val(val);
            });
            $('#modal-update_education_info').modal('show');

            aInitialValues["education_info"] = '';
            aInitialValues["education_info"] = getFormValues('form-update_education_info');

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
            getVictimInfoByCaseId(1);
        }

    }, 'json');
}

function getVictimAddressInfoById(id) {

    $.post(sAjaxVictims, {
        type: "getVictimAddressInfoById",
        victim_address_list_id: id
    }, function (rs) {
        rs = html_entity_decode(rs);
        if (rs.data.flag == 1) {
            $.each(rs.data.victim_address_info, function (key, val) {
                $('.u-vi-' + key).val(val);
                $('.u-vi-' + key).val(val).change();
                $('.u-vi-' + key).attr('data-id', val);
            });
            $('#modal-update_address_info').modal('show');

            aInitialValues["address_info"] = '';
            aInitialValues["address_info"] = getFormValues('form-update_address_info');

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
            getVictimInfoByCaseId(1);
        }

    }, 'json');
}

function getVictimRelativeInfoById(id) {

    $.post(sAjaxVictims, {
        type: "getVictimRelativeInfoById",
        victim_relative_id: id
    }, function (rs) {
        rs = html_entity_decode(rs);
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

            aInitialValues["family_relation_info"] = '';
            aInitialValues["family_relation_info"] = getFormValues('form-update_relative_info');

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
            getVictimInfoByCaseId(1);
        }
    }, 'json');
}

function getVictimInfoByCaseId(isAction) {

    if (isAction == '0') {
        icmsMessage({
            type: "msgPreloader",
            visible: true,
            body: "Please wait while loading details.",
        });
    }

    $.post(sAjaxVictims, {
        type: "getVictimInfoByCaseId",
        case_id: localStorage.getItem('cid')
    }, function (rs) {
        //console.log(rs); 
        rs = html_entity_decode(rs);
        //console.log(rs); 
        // set aVictimInfoByCaseId items
        aVictimInfoByCaseId = [];
        aVictimInfoByCaseId = rs.data;
        localStorage.setItem('vid', rs.data.victim_id);
        localStorage.setItem('cvid', rs.data.case_victim_id);
        getVictimInfoByStorage();
        // for add 
        if (isAction == '1') {
            notifyChangesInReport();
        } else {
            icmsMessage({
                type: "msgPreloader",
                visible: false,
            });
        }

    }, 'json');
}

// based on local storage 
function getVictimInfoByStorage() {

    var vi = aVictimInfoByCaseId.victim_info;
    $.each(vi, function (key, val) {
        $('.vi-' + key).val(val);
    });
    if (vi.victim_info_dob !== null && vi.victim_info_dob != "") {
        $('.vi-victim_info_dob').val(dateFormatToPicker(vi.victim_info_dob));
    }

    var vi_assumed = aVictimInfoByCaseId.victim_info_assumed;
    $.each(vi_assumed, function (key, val) {
        $('.vi-assumed-' + key).val(val);
    });
    if (typeof vi_assumed.victim_info_dob !== "undefined" && vi_assumed.victim_info_dob !== null && vi_assumed.victim_info_dob != "") {
        $('.vi-assumed-victim_info_dob').val(dateFormatToPicker(vi_assumed.victim_info_dob));
    }

    $('.vi-disability').val(vi_assumed.victim_info_disability);
    $('.vi-allergies').val(vi_assumed.victim_info_allergy);
    $('.vi-history_of_illness').val(vi_assumed.victim_info_hospitality);
    

    var victim_contacts = aVictimInfoByCaseId.victim_contact_info;
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
        parseInt(victim_contacts.length) >= 10 ? $('.btn-add_contact').prop('disabled', true) : $('.btn-add_contact').prop('disabled', false);
    } else {
        t += '<tr>';
        t += '<td colspan="3" class="text-center">No contact info added to list.</td>';
        t += '</tr>';
    }

    $('.victim-contact_info_list').html(t);
    var victim_educations = aVictimInfoByCaseId.victim_education_info;
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

            parseInt(victim_educations.length) >= 10 ? $('.btn-add_education').prop('disabled', true) : $('.btn-add_education').prop('disabled', false);

        });
    } else {
        t += '<tr>';
        t += '<td colspan="4" class="text-center">No education info added to list.</td>';
        t += '</tr>';
    }

    $('.victim-education_info_list').html(t);
    var victim_address = aVictimInfoByCaseId.victim_address_info;
    var t = '';
    if (victim_address.length > 0) {
        $.each(victim_address, function (key, val) {
            var attribs = "";
//                attribs = 'dta-address="' + val.victim_address_list_address + '" dta-brgy="' + val.brgy + '" dta-city="' + val.city + '" dta-prov="' + val.province + '" dta-region="' + val.region + '" dta-cntry="' + val.country + '"';

            t += '<tr ' + attribs + '>';
            t += '<td>';
            t += val.victim_address_list_address + ' ';
            t += val.brgy + ' ';
            t += val.city != "" ? val.city + ', ' : "";
            t += val.province != "" ? val.province + ', ' : "";
            t += val.region + ' ';
            t += val.country;
            t += '</td>';
            t += '<td> <div class="btn-group ellipse-action" data-id="vi-address_info_list' + val.victim_address_list_id + '" data-tab="">';
            t += '<a class="a-ellipse a-ellipse-' + val.victim_address_list_id + ' " >  <i class="fa fa-ellipsis-v" aria-hidden="true"></i> </a>';
            t += '<div class="action-menu" id="vi-address_info_list' + val.victim_address_list_id + '">';
            t += '<a class="dropdown-item disabled action-title" href="#">Select Action</a>';
            t += '<a class="dropdown-item up-victim_address_info" data-id="' + val.victim_address_list_id + '" >Update</a>';
            //t += '<a class="dropdown-item rm-victim_address_info" data-id="' + val.victim_address_list_id + '" >Remove</a>';
            t += '</div>';
            t += '</div> </td>';
            t += '</tr>';

            parseInt(victim_address.length) >= 1 ? $('.btn-add_address').prop('disabled', true) : $('.btn-add_address').prop('disabled', false);

        });
    } else {
        t += '<tr>';
        t += '<td colspan="2" class="text-center">No address info added to list.</td>';
        t += '</tr>';
    }

    $('.victim-address_info_list').html(t);
    var victim_relatives = aVictimInfoByCaseId.victim_relatives_info;
    var t = '';
    if (victim_relatives.length > 0) {
        $.each(victim_relatives, function (key, val) {
            var str = val.victim_relative_type_name;
            var f = str.includes('Other');
            var type_name = val.victim_relative_type_name;
            if (f) {
                type_name = type_name;
                if (val.victim_relative_type_other) {
                    type_name = type_name + ': ' + val.victim_relative_type_other;
                }
            }
            t += '<tr>';
            t += '  <td>' + type_name + '</td>';
            t += '  <td>' + val.victim_relative_fullname + '</td>';
            t += '  <td>' + val.victim_relative_primary_contact_number + '</td>';
            t += '  <td> <div class="btn-group ellipse-action" data-id="vi-relative_info_list' + val.victim_relative_id + '" data-tab="">';
            t += '  <a class="a-ellipse a-ellipse-' + val.victim_relative_id + ' " >  <i class="fa fa-ellipsis-v" aria-hidden="true"></i> </a>';
            t += '  <div class="action-menu" id="vi-relative_info_list' + val.victim_relative_id + '">';
            t += '  <a class="dropdown-item disabled action-title" href="#">Select Action</a>';
            t += '  <a class="dropdown-item up-victim_relative_info" data-id="' + val.victim_relative_id + '" >Update</a>';
            t += '  <a class="dropdown-item rm-victim_relative_info" data-id="' + val.victim_relative_id + '" >Remove</a>';
            t += '  </div>';
            t += '  </div> </td>';
            t += '</tr>';

            parseInt(victim_relatives.length) >= 10 ? $('.btn-add_relative').prop('disabled', true) : $('.btn-add_relative').prop('disabled', false);

        });
    } else {
        t += '<tr>';
        t += '<td colspan="4" class="text-center">No relative info added to list.</td>';
        t += '</tr>';
    }

    $('.victim-relative_info_list').html(t);
}

function getProvincesByRegionId_report(id) {
    $.post(sAjaxGlobalData, {
        type: "getProvinceByRegionID",
        region_id: id
    }, function (rs) {
        var l = "<option value ='' selected> Select Province </option>";
        $('.sel-provincesByRegionId').html(l);
        if (rs.data) {
            $.each(rs.data, function (key, val) {
                if (val.location_count_id) {
                    l += "<option value='" + val.location_count_id + "' data-name='" + val.location_name + "'>" + val.location_name + "</option>";
                }
            });
            $('.sel-provincesByRegionId').html(l);
            var iVal = $('.u-vi-victim_address_list_province_id').attr('data-id');
            $('.u-vi-victim_address_list_province_id').val(iVal).change();

        }
    }, 'json');
}

function getCityByProvinceId_report(id) {
    $.post(sAjaxGlobalData, {
        type: "getCityByProvinceId",
        province_id: id
    }, function (rs) {
        var l = "<option selected disabled >Select City</option>";
        $('.sel-cities').html(l);
        if (rs.data) {
            $.each(rs.data, function (key, val) {
                if (val.location_count_id) {
                    l += "<option value='" + val.location_count_id + "' data-name='" + val.location_name + "'>" + val.location_name + "</option>";
                }
            });
            $('.sel-cities').html(l);
            var iVal = $('.u-vi-victim_address_list_city_id').attr('data-id');
            if ((iVal) || (iVal != "undefined")) {
                $('.u-vi-victim_address_list_city_id').val(iVal).change();
            }
        }
    }, 'json');
}

function getBrgyByCityID_report(id) {
    $.post(sAjaxGlobalData, {
        type: "getBrgyByCityID",
        city_id: id
    }, function (rs) {
        var l = "<option selected disabled >Select Barangay</option>";
        $('.sel-barangayByCityId').html(l);
        if (rs.data) {
            $.each(rs.data, function (key, val) {
                if (val.location_count_id) {
                    l += "<option value='" + val.location_count_id + "' data-name='" + val.location_name + "'>" + val.location_name + "</option>";
                }
            });
            $('.sel-barangayByCityId').html(l);
            var iVal = $('.u-vi-victim_address_list_brgy_id').attr('data-id');
            if (iVal) {
                $('.u-vi-victim_address_list_brgy_id').val(iVal).change();
            }
        }
    }, 'json');
}

function updateVictimAssumed() {
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
    }, function (rs) {
        getVictimInfoByCaseId(1);
        $('#btn-manage-assumed').text("Manage");
        $('#btn-save-assumed').addClass("hide");
        $("#frm-assumed :input").prop("disabled", true);
    }, 'json');
}

function updateVictimPersonalInformation() {
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
        getVictimInfoByCaseId(1);
        $('#btn-manage-personal').text("Manage");
        $('#btn-save-personal').addClass("hide");
        $("#frm-personal :input").prop("disabled", true);
    }, 'json');
}

$(document).ready(function () {

    /*
     * Open Modals
     */
    $('.btn-add_contact').click(function () {
        $("#modal-add_contact_info").modal('show');
        $('.lbl-contact-value').html('Value');
    });
    $('.btn-add_education').click(function () {
        $("#modal-add_education_info").modal('show');
    });
    $('.btn-add_address').click(function () {
        var l = "";
        $('.a-vi-address_province').html(l);
        $('.a-vi-address_province').prop("disabled", true);
        $('.a-vi-address_city').html(l);
        $('.a-vi-address_city').prop("disabled", true);
        $('.a-vi-address_barangay').html(l);
        $('.a-vi-address_barangay').prop("disabled", true);

        $("#modal-add_address_info").modal('show');
    });
    $('.btn-add_relative').click(function () {
        $("#modal-add_relative_info").modal('show');
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

    /*
     * Declare case_id in local storage 
     */
    var cid = $('#case_id').val();
    localStorage.setItem('cid', cid);

    /*
     * Disabled 
     */
    $("#frm-personal :input").prop("disabled", true);
    $("#frm-assumed :input").prop("disabled", true);


    /*
     * Remove and updates buttons
     */

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
    $('.victim-address_info_list').delegate('.up-victim_address_info', 'click', function () {

        var l = "";
        $('.u-vi-address_province').html(l);
        $('.u-vi-address_city').html(l);
        $('.u-vi-address_barangay').html(l);
        $('.u-vi-address_province').prop("disabled", true);
        $('.u-vi-address_city').prop("disabled", true);
        $('.u-vi-address_barangay').prop("disabled", true);

        var id = $(this).attr('data-id');
        $('.stored-address_id').val(id);
        getVictimAddressInfoById(id);
    });

    //relative info actions
    $('.victim-relative_info_list').delegate('.rm-victim_relative_info', 'click', function () {
        var id = $(this).attr('data-id');
        removeVictimRelativeInfoById(id);
    });
    $('.victim-relative_info_list').delegate('.up-victim_relative_info', 'click', function () {
        var id = $(this).attr('data-id');
        $('.stored-relative_id').val(id);
        getVictimRelativeInfoById(id);
    });


    /*
     * Relative info others 
     */
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


    /*
     * Educational Attainment
     */
    $('.a-vi-education_type').change(function () {
        var str = $('.a-vi-education_type option:selected').attr('data-name');
        var n = str.includes('Undergraduate');
        var f = str.includes('Elementary');

        if ($(this).val() == "13") {
            $('.field-education_grade_year').hide();
            $('.field-education_course').hide();
            $('.field-education_school_name').hide();
            $('.field-education_start-end').hide();
        } else {
            $('.field-education_grade_year').show();
            $('.field-education_course').show();
            $('.field-education_school_name').show();
            $('.field-education_start-end').show();

            if (!n) {
                $('.field-education_grade_year').hide();
                $('.a-vi-education_grade_year').val('');
            } else {
                $('.field-education_grade_year').show();
            }

            if ((f) || (str == 'High School Graduate') || (str == 'High School Undergraduate')) {
                $('.field-education_course').hide();
            } else {
                $('.field-education_course').show();
            }
        }
    });

    $('.u-vi-victim_education_type').change(function () {
        var str = $('.u-vi-victim_education_type option:selected').attr('data-name');
        var n = str.includes('Undergraduate');
        var f = str.includes('Elementary');

        if ($(this).val() == "13") {
            $('.field-education_grade_year').hide();
            $('.field-education_course').hide();
            $('.field-education_school_name').hide();
            $('.field-education_start-end').hide();
        } else {
            $('.field-education_grade_year').show();
            $('.field-education_course').show();
            $('.field-education_school_name').show();
            $('.field-education_start-end').show();

            if (!n) {
                $('.field-education_grade_year').hide();
                $('.u-vi-victim_education_grade_year').val('');
            } else {
                $('.field-victim_education_grade_year').show();
            }

            if ((f) || (str == 'High School Graduate') || (str == 'High School Undergraduate')) {
                $('.field-education_course').hide();
            } else {
                $('.field-education_course').show();
            }
        }
    });

    /*
     * For location 
     */

    // Add 
    $('.a-vi-address_region').change(function () {
        getProvincesByRegionId_report(this.value);
        $('.a-vi-address_province').attr('disabled', false);
    });
    $('.a-vi-address_province').change(function () {
        getCityByProvinceId_report(this.value);
        $('.a-vi-address_city').attr('disabled', false);
    });
    $('.a-vi-address_city').change(function () {
        getBrgyByCityID_report(this.value);
        $('.a-vi-address_barangay').attr('disabled', false);
    });


    // Update 
    $('.u-vi-victim_address_list_region_id').change(function () {
        getProvincesByRegionId_report(this.value);
        $('.u-vi-victim_address_list_province_id').attr('disabled', false);
    });
    $('.u-vi-victim_address_list_province_id').change(function () {
        getCityByProvinceId_report(this.value);
        $('.u-vi-victim_address_list_city_id').attr('disabled', false);
    });
    $('.u-vi-victim_address_list_city_id').change(function () {
        getBrgyByCityID_report(this.value);
        $('.u-vi-victim_address_list_brgy_id').attr('disabled', false);
    });


    /*
     * Form Actions
     */

    // Personal victim details
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

    // Contact Details 
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

            aCurrentValues = '';
            aCurrentValues = getFormValues('form-update_contact_info');

            if (aInitialValues["contact_info"] == aCurrentValues) {

                icmsMessage({
                    type: "msgWarning",
                    body: "No changes has been made.",
                    onShow: function () {
                        $('#modal-update_contact_info').modal('hide');
                    },
                    onHide: function () {
                        $('#modal-update_contact_info').modal('show');
                    }
                });

            } else {
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



        }
    });

    // Educational Info 

    $.validator.addMethod("year_end_educ", function (value, element) {
        if (value == "") {
            return true;
        }
        var start = $('.modal.show input[name=year_start]').val();
        var end = $('.modal.show input[name=year_end]').val();
        if (parseInt(start) <= parseInt(end)) {
            return true;
        }

        if (!start) {
            return true;
        }

    }, "Invalid year");


    $('#form-add_education_info').validate({
        rules: {
            education_type: {required: true},
            year_start: {
                pastYearOption: true,
                number: true,
            },
            year_end: {
                pastYearOption: true,
                number: true,
                year_end_educ: true,
            },
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
            year_start: {
                pastYearOption: true,
                number: true,
            },
            year_end: {
                pastYearOption: true,
                number: true,
                year_end_educ: true,
            },
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

            aCurrentValues = '';
            aCurrentValues = getFormValues('form-update_education_info');

            if (aInitialValues["education_info"] == aCurrentValues) {

                icmsMessage({
                    type: "msgWarning",
                    body: "No changes has been made.",
                    onShow: function () {
                        $('#modal-update_education_info').modal('hide');
                    },
                    onHide: function () {
                        $('#modal-update_education_info').modal('show');
                    }
                });

            } else {
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





        }
    });

    // Address Information
    $('#form-update_address_info').validate({
        rules: {
            region: {required: true}
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
    $('#form-add_address_info').validate({
        rules: {
            region: {required: true}
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

    // Relative Information 
    $('#form-update_relative_info').validate({
        rules: {
            relative_type: {required: true},
            relative_name: {required: true},
            email: {email: true},
            primary_contact: {maxlength: 13, minlength: 7, number: true},
            secondary_contact: {maxlength: 13, minlength: 7, number: true}
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

            aCurrentValues = '';
            aCurrentValues = getFormValues('form-update_relative_info');


            if (aInitialValues["family_relation_info"] == aCurrentValues) {

                icmsMessage({
                    type: "msgWarning",
                    body: "No changes has been made.",
                    onShow: function () {
                        $('#modal-update_relative_info').modal('hide');
                    },
                    onHide: function () {
                        $('#modal-update_relative_info').modal('show');
                    }
                });

            } else {
                icmsMessage({
                    type: "msgConfirmation",
                    title: "You are about update contact details",
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

        }
    });
    $('#form-add_relative_info').validate({
        rules: {
            relative_type: {required: true},
            relative_name: {required: true},
            email: {email: true},
            primary_contact: {maxlength: 13, minlength: 7, number: true},
            secondary_contact: {maxlength: 13, minlength: 7, number: true}
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
            $('#modal-add_relative_info').modal('hide');
            addRelativeInfoByVictimId();
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

    $('.sel-contact_type').change(function () {

        var caption = $('.modal.show .sel-contact_type option:selected').text();
        if (caption) {
            $('.lbl-contact-value').text(caption);
        } else {
            var caption = $('#form-update_contact_info .sel-contact_type option:selected').text();
            if (caption) {
                $('.lbl-contact-value').text(caption);
            }
        }
        resetFormJQueryValidation('form-add_contact_info');
    });

    /*
     * Victim's personal information  
     */

    // Form 
    $("#frm-personal").validate({
        rules: {
            first_name: {
                required: true
            },
            last_name: {
                required: true
            },
            sex: {
                required: true
            },
            dob: {
                pastDate: true
            },
            civil_status: {
                required: true
            }
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

            aCurrentValues = '';
            aCurrentValues = getFormValues('frm-personal');
            if (aInitialValues == aCurrentValues) {
                icmsMessage({
                    type: "msgWarning",
                    body: "No changes has been made.",
                });
            } else {
                icmsMessage({
                    type: "msgConfirmation",
                    title: "You are about to update victim's personal information",
                    onConfirm: function () {
                        updateVictimPersonalInformation();
                    }
                });
            }

        }
    });

    // Manage 
    $('#btn-manage-personal').click(function () {
        var caption = $(this).text();
        if (caption == "Manage") {
            $('#btn-manage-personal').text("Cancel");
            $('#btn-save-personal').removeClass("hide");
            $("#frm-personal :input").prop("disabled", false);
            aInitialValues["personal"] = '';
            aInitialValues["personal"] = getFormValues('frm-personal');
        } else {

            aCurrentValues = '';
            aCurrentValues = getFormValues('frm-personal');
            if (aInitialValues["personal"] == aCurrentValues) {
                // no update 
                $('#btn-manage-personal').text("Manage");
                $('#btn-save-personal').addClass("hide");
                $("#frm-personal :input").prop("disabled", true);
                resetFormJQueryValidation('frm-personal');
            } else {
                // have an update  // load Victim Info 
                icmsMessage({
                    type: "msgConfirmation",
                    title: "You made some changes. Do you want to disregard changes?",
                    body: "Click yes button if you want to continue",
                    LblBtnConfirm: "Yes",
                    onConfirm: function () {
                        $('#btn-manage-personal').text("Manage");
                        $('#btn-save-personal').addClass("hide");
                        $("#frm-personal :input").prop("disabled", true);
                        resetFormJQueryValidation('frm-personal');
                        getVictimInfoByStorage();
                    }
                });
            }
        }
    });

    // Submit 
    $('#btn-save-personal').click(function () {
        $("#frm-personal").submit();
    });


    /*
     * Victim's personal information Assumed  
     */

    // Form 
    $("#frm-assumed").validate({
        rules: {
            dob: {
                pastDateOptional: true
            }
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
            aCurrentValues = '';
            aCurrentValues = getFormValues('frm-assumed');
            if (aInitialValues['assumed'] == aCurrentValues) {
                icmsMessage({
                    type: "msgWarning",
                    body: "No changes has been made.",
                });
            } else {
                icmsMessage({
                    type: "msgConfirmation",
                    title: "You are about to update the assumed victim information",
                    onConfirm: function () {
                        updateVictimAssumed();
                    }
                });
            }
        }
    });

    // Submit 
    $('#btn-save-assumed').click(function () {
        $('#frm-assumed').submit();
    });

    // Manage 
    $('#btn-manage-assumed').click(function () {
        var caption = $(this).text();
        if (caption == "Manage") {
            $(this).text("Cancel");
            $('#btn-save-assumed').removeClass("hide");
            $("#frm-assumed :input").prop("disabled", false);
            aInitialValues["assumed"] = '';
            aInitialValues["assumed"] = getFormValues('frm-assumed');
        } else {
            aCurrentValues = '';
            aCurrentValues = getFormValues('frm-assumed');
            if (aInitialValues["assumed"] == aCurrentValues) {
                // no update 
                $(this).text("Manage");
                $('#btn-save-assumed').addClass("hide");
                $("#frm-assumed :input").prop("disabled", true);
                resetFormJQueryValidation('frm-assumed');
            } else {
                // have an update  // load Victim Info 
                icmsMessage({
                    type: "msgConfirmation",
                    title: "You made some changes. Do you want to disregard changes?",
                    body: "Click yes button if you want to continue",
                    LblBtnConfirm: "Yes",
                    onConfirm: function () {
                        $('#btn-manage-assumed').text("Manage");
                        $('#btn-save-assumed').addClass("hide");
                        $("#frm-assumed :input").prop("disabled", true);
                        resetFormJQueryValidation('frm-assumed');
                        getVictimInfoByStorage();
                    }
                });
            }
        }
    });


    /*
     * Cancel button in modal 
     */

    // Contact Info 
    $('#form-update_contact_info').delegate('.btn-modal-cancel', 'click', function () {
        aCurrentValues = '';
        aCurrentValues = getFormValues('form-update_contact_info');
        var id = $('.stored-contact_id').val();
        if (aInitialValues["contact_info"] != aCurrentValues) {
            icmsMessage({
                type: "msgConfirmation",
                title: "You made some changes. Do you want to disregard changes?",
                body: "Click yes button if you want to continue",
                LblBtnConfirm: "Yes",
                onShow: function () {
                    $('#modal-update_contact_info').modal('hide');
                },
                onConfirm: function () {
                    $('#modal-update_contact_info').modal('hide');
                    resetFormById('form-update_contact_info');
                },
                onCancel: function () {
                    $('#modal-update_contact_info').modal('show');
                }
            });
        } else {
            $('#modal-update_contact_info').modal('hide');
            resetFormById('form-update_contact_info');
        }
    });

    // Address Info 
    $('#form-update_address_info').delegate('.btn-modal-cancel', 'click', function () {
        aCurrentValues = '';
        aCurrentValues = getFormValues('form-update_address_info');
        var id = $('.stored-address_id').val();
        if (aInitialValues["address_info"] != aCurrentValues) {
            icmsMessage({
                type: "msgConfirmation",
                title: "You made some changes. Do you want to disregard changes?",
                body: "Click yes button if you want to continue",
                LblBtnConfirm: "Yes",
                onShow: function () {
                    $('#modal-update_address_info').modal('hide');
                },
                onConfirm: function () {
                    $('#modal-update_address_info').modal('hide');
                    resetFormById('form-update_address_info');
                },
                onCancel: function () {
                    $('#modal-update_address_info').modal('show');
                }
            });
        } else {
            $('#modal-update_address_info').modal('hide');
            resetFormById('form-update_address_info');
        }
    });

    // Educational Background 
    $('#form-update_education_info').delegate('.btn-modal-cancel', 'click', function () {
        aCurrentValues = '';
        aCurrentValues = getFormValues('form-update_education_info');
        var id = $('.stored-education_id').val();
        if (aInitialValues["education_info"] != aCurrentValues) {
            icmsMessage({
                type: "msgConfirmation",
                title: "You made some changes. Do you want to disregard changes?",
                body: "Click yes button if you want to continue",
                LblBtnConfirm: "Yes",
                onShow: function () {
                    $('#modal-update_education_info').modal('hide');
                },
                onConfirm: function () {
                    $('#modal-update_education_info').modal('hide');
                    resetFormById('form-update_education_info');
                },
                onCancel: function () {
                    $('#modal-update_education_info').modal('show');
                }
            });
        } else {
            $('#modal-update_education_info').modal('hide');
            resetFormById('form-update_education_info');
        }
    });

    // Next of kin 
    $('#form-update_relative_info').delegate('.btn-modal-cancel', 'click', function () {
        aCurrentValues = '';
        aCurrentValues = getFormValues('form-update_relative_info');
        var id = $('.stored-relative_id').val();
        if (aInitialValues["family_relation_info"] != aCurrentValues) {
            icmsMessage({
                type: "msgConfirmation",
                title: "You made some changes. Do you want to disregard changes?",
                body: "Click yes button if you want to continue",
                LblBtnConfirm: "Yes",
                onShow: function () {
                    $('#modal-update_relative_info').modal('hide');
                },
                onConfirm: function () {
                    $('#modal-update_relative_info').modal('hide');
                    resetFormById('form-update_relative_info');
                },
                onCancel: function () {
                    $('#modal-update_relative_info').modal('show');
                }
            });
        } else {
            $('#modal-update_relative_info').modal('hide');
            resetFormById('form-update_relative_info');
        }
    });


    // change label in add victim contact type
    $('.a-vi-contact_type').change(function () {

        var c_val = parseInt($(this).val());
        switch (c_val) {
            case 1:
                // phone 
                $('.a-vi-contact_content').attr('maxlength', '20');
                $('.a-vi-contact_content').attr('minlength', '7');
                $('.a-vi-contact_content').addClass('numbersOnly');
                $('.a-vi-contact_content').attr('type', 'number');
                break;
            case 3:
                // email
                $('.a-vi-contact_content').attr('type', 'email');
                $('.a-vi-contact_content').attr('maxlength', '100');
                break;
            case 4:
                // facebooklink
                $('.a-vi-contact_content').attr('type', 'text');
                $('.a-vi-contact_content').attr('maxlength', '1000');
                break;
            case 2:
                // telephone 
                $('.a-vi-contact_content').attr('maxlength', '20');
                $('.a-vi-contact_content').attr('minlength', '7');
                $('.a-vi-contact_content').addClass('numbersOnly');
                $('.a-vi-contact_content').attr('type', 'text');
                break;
        }

    });

    // change label in update victim contact type
    $('.u-vi-victim_contact_detail_type').change(function () {

        var c_val = parseInt($(this).val());
        switch (c_val) {
            case 1:
                // phone 
                $('.u-vi-victim_contact_detail_content').attr('maxlength', '20');
                $('.u-vi-victim_contact_detail_content').attr('minlength', '7');
                $('.u-vi-victim_contact_detail_content').addClass('numbersOnly');
                $('.u-vi-victim_contact_detail_content').attr('type', 'number');
                break;
            case 3:
                // email
                $('.u-vi-victim_contact_detail_content').attr('type', 'email');
                $('.u-vi-victim_contact_detail_content').attr('maxlength', '100');
                break;
            case 4:
                // facebooklink
                $('.u-vi-victim_contact_detail_content').attr('maxlength', '1000');
                $('.u-vi-victim_contact_detail_content').attr('type', 'text');
                break;
            case 2:
                // telephone 
                $('.u-vi-victim_contact_detail_content').attr('maxlength', '20');
                $('.u-vi-victim_contact_detail_content').attr('minlength', '7');
                $('.u-vi-victim_contact_detail_content').addClass('numbersOnly');
                $('.u-vi-victim_contact_detail_content').attr('type', 'text');
                break;
        }

    });


});
