function validateVictim() {

    //validate function

    //no matched results
    $('.matched_results').show();
    $('.matched_contents').hide();
    $('.matched_none').show();

    $('.btn-next_tab').show();

}

function initialVictimTabFunctions() {

    var victim_validation_data = {
        'first_name': $('.v-first_name').val(),
        'middle_name': $('.v-middle_name').val(),
        'last_name': $('.v-last_name').val(),
        'dob': $('.v-dob').val(),
        'pob': $('.v-pob').val(),
        'offender_name': $('.v-offender_name').val(),
        'employer_name': $('.v-employer_name').val(),
        'local_recruitment_agency': $('.v-local_recruitment_agency').val(),
        'deployed_date': $('.v-deployed_date').val(),
        'deployment_country': $('.v-deployment_country').val(),
        'traffic_purpose': $('.v-traffic_purpose').val()
    };

    _setStorageData(victim_validation_data, 'victim_validation_data');

    $.each(victim_validation_data, function (key, val) {
        $(".vi-" + key).val(val);
    });

}


function getVictimValidationInfo() {
    var victimValidationInfo = _getStorageData('victim_validation_data');

    if (victimValidationInfo) {
        $.each(victimValidationInfo, function (key, val) {
            $(".v-" + key).val(val);
        });
    }
}

function getVictimPersonalInfo() {
    var victimPersonalInfo = _getStorageData('victim_personal_info');
    if (victimPersonalInfo) {
        $.each(victimPersonalInfo, function (key, val) {
            $(".vi-" + key).val(val);
        });
    }
}

function storeVictimContactInfo() {
    var storage = _getStorageData('victim_personal_contact_info');
    if (!storage) {
        var victim_personal_contact_info = [{
                'contact_type': $('.a-vi-contact_type').val(),
                'contact_type_name': $('.a-vi-contact_type option:selected').attr('data-name'),
                'contact_content': $('.a-vi-contact_content').val()
            }];
        _setStorageData(victim_personal_contact_info, 'victim_personal_contact_info');
    } else {
        var victim_personal_contact_info = {
            'contact_type': $('.a-vi-contact_type').val(),
            'contact_type_name': $('.a-vi-contact_type option:selected').attr('data-name'),
            'contact_content': $('.a-vi-contact_content').val()
        };
        storage.push(victim_personal_contact_info);
        _setStorageData(storage, 'victim_personal_contact_info');
    }
    $('#form-add_contact_info')[0].reset();
    //show list
    getVictimContactInfoList();
}

function getVictimContactInfoList() {

    var contacts = _getStorageData('victim_personal_contact_info');
    var cnt = 0;
    var t = '';
    var l = '';
    var r = 0;

    // Non Data Content
    l += '<tr>';
    l += '<td colspan="3" class="text-center" style="text-align: center !important">No contact info added to list.</td>';
    l += '</tr>';

    if (contacts.length > 0) {
        $.each(contacts, function (key, val) {

            var conctact_details_id = '';

            if (val.conctact_details_id) {
                conctact_details_id = 'data-conctact_details_id = "' + val.conctact_details_id + '"';
            }

            if ((val.status === undefined) || ((val.status !== undefined) && (val.status == '1'))) {
                t += '<tr>';
                t += '<td>' + val.contact_type_name + '</td>';
                t += '<td>' + val.contact_content + '</td>';
                t += '<td> <div class="btn-group ellipse-action" data-id="vi-contact_info_list' + cnt + '" data-tab="">';
                t += '<a class="a-ellipse a-ellipse-' + cnt + ' " >  <i class="fa fa-ellipsis-v" aria-hidden="true"></i> </a>';
                t += '<div class="action-menu" id="vi-contact_info_list' + cnt + '">';
                t += '<a class="dropdown-item disabled action-title" href="#">Select Action</a>';
                t += '<a class="dropdown-item up-victim_contact_info" data-id="' + cnt + '" >Update</a>';
                t += '<a class="dropdown-item rm-victim_contact_info" data-id="' + cnt + '" ' + conctact_details_id + '>Remove</a>';
                t += '</div>';
                t += '</div> </td>';
                t += '</tr>';
                r += 1;
            }

            cnt++;
        });

        if (r == 0) {
            // No Data
            t += l;
        }
    } else {
        // No Data
        t += l;
    }

    if (contacts.length >= 10) {
        $('.btn-add_contact').attr('disabled', true);
    } else {
        $('.btn-add_contact').attr('disabled', false);
    }

    $('.victim-contact_info_list').html(t);
}

function storeVictimContactInfoById() {
    var storedId = $('.stored-contact_id').val();
    var current = _getStorageData('victim_personal_contact_info');
    $.each(current[storedId], function (key, val) {
        current[storedId][key] = $('.u-vi-' + key).val();
    });

    //get name of type
    current[storedId]['contact_type_name'] = $('.u-vi-contact_type option:selected').attr('data-name');

    var address_id = $('#form-update_contact_info').attr('data-id');
    if (address_id) {
        current[storedId]['conctact_details_id'] = address_id;
        current[storedId]['status'] = '1';
    }

    _setStorageData(current, 'victim_personal_contact_info');

    $("#modal-update_contact_info").modal('hide');
    $('#form-update_contact_info')[0].reset();

    getVictimContactInfoList();

}

function storeVictimEducationInfo() {

    var storage = _getStorageData('victim_personal_education_info');

    if (!storage) {

        var victim_personal_education_info = [{
                'education_type': $('.a-vi-education_type').val(),
                'education_type_name': $('.a-vi-education_type option:selected').attr('data-name'),
                'education_school': $('.a-vi-education_school').val(),
                'education_grade_year': $('.a-vi-education_grade_year').val(),
                'education_course': $('.a-vi-education_course').val(),
                'education_start': $('.a-vi-education_start').val(),
                'education_end': $('.a-vi-education_end').val()
            }];

        _setStorageData(victim_personal_education_info, 'victim_personal_education_info');
    } else {

        var victim_personal_education_info = {
            'education_type': $('.a-vi-education_type').val(),
            'education_type_name': $('.a-vi-education_type option:selected').attr('data-name'),
            'education_school': $('.a-vi-education_school').val(),
            'education_grade_year': $('.a-vi-education_grade_year').val(),
            'education_course': $('.a-vi-education_course').val(),
            'education_start': $('.a-vi-education_start').val(),
            'education_end': $('.a-vi-education_end').val()
        };

        storage.push(victim_personal_education_info);

        _setStorageData(storage, 'victim_personal_education_info');

    }

    $('#form-add_education_info')[0].reset();

    //show list
    getVictimEducationInfoList();

}

function getVictimEducationInfoList() {

    var educations = _getStorageData('victim_personal_education_info');

    var cnt = 0;
    var r = 0;
    var t = '';
    var l = '';

    // Non Data Content
    l += '<tr>';
    l += '<td colspan="4" class="text-center"  style="text-align: center !important">No education info added to list.</td>';
    l += '</tr>';

    if (educations.length > 0) {
        $.each(educations, function (key, val) {
            var victim_education_id = '';
            if (val.victim_education_id) {
                victim_education_id = 'data-victim_education_id = "' + val.victim_education_id + '"';
            }
            if ((val.status === undefined) || ((val.status !== undefined) && (val.status == '1'))) {
                t += '<tr>';
                t += '<td>' + val.education_type_name + '</td>';
                t += '<td>' + val.education_school + '</td>';
                //t += '<td>' + val.education_end + '</td>';
                t += '<td> <div class="btn-group ellipse-action" data-id="vi-education_info_list' + cnt + '" data-tab="">';
                t += '<a class="a-ellipse a-ellipse-' + cnt + ' " >  <i class="fa fa-ellipsis-v" aria-hidden="true"></i> </a>';
                t += '<div class="action-menu" id="vi-education_info_list' + cnt + '">';
                t += '<a class="dropdown-item disabled action-title" href="#">Select Action</a>';
                t += '<a class="dropdown-item up-victim_education_info" data-edname="' + val.education_type_name + '" data-id="' + cnt + '" >Update</a>';
                t += '<a class="dropdown-item rm-victim_education_info" data-id="' + cnt + '" ' + victim_education_id + '>Remove</a>';
                t += '</div>';
                t += '</div> </td>';
                t += '</tr>';
                r += 1;
            }
            cnt++;
        });
        if (r == 0) {
            // No Data
            t += l;
        }
    } else {
        // No Data
        t += l;
    }

    if (educations.length >= 10) {
        $('.btn-add_education ').attr('disabled', true);
    } else {
        $('.btn-add_education ').attr('disabled', false);
    }

    $('.victim-education_info_list').html(t);
}

function storeVictimEducationInfoById() {
    var storedId = $('.stored-education_id').val();

    var current = _getStorageData('victim_personal_education_info');

    var etype = $('.u-vi-education_type').val();

    $.each(current[storedId], function (key, val) {
        if (etype == "13") {
            current[storedId][key] = "";
        } else {
            current[storedId][key] = $('.u-vi-' + key).val();
        }
    });

    current[storedId]['education_type'] = $('.u-vi-education_type').val();

    //get name of type
    current[storedId]['education_type_name'] = $('.u-vi-education_type option:selected').attr('data-name');

    var victim_education_id = $('#form-update_education_info').attr('data-id');
    if (victim_education_id) {
        current[storedId]['victim_education_id'] = victim_education_id;
        current[storedId]['status'] = '1';
    }

    _setStorageData(current, 'victim_personal_education_info');

    $("#modal-update_education_info").modal('hide');
    $('#form-update_education_info')[0].reset();

    getVictimEducationInfoList();

}

function storeVictimAddressInfo() {

    var storage = _getStorageData('victim_personal_address_info');
    var l = "";
    l += $('.a-vi-address_region option:selected').attr('data-name') ? $('.a-vi-address_region option:selected').attr('data-name') + ", " : "";
    l += $('.a-vi-address_province option:selected').attr('data-name') ? $('.a-vi-address_province option:selected').attr('data-name') + ", " : "";
    l += $('.a-vi-address_city option:selected').attr('data-name') ? $('.a-vi-address_city option:selected').attr('data-name') + ", " : "";
    l += $('.a-vi-address_barangay option:selected').attr('data-name') ? $('.a-vi-address_barangay option:selected').attr('data-name') + ", " : "";
    l += $('.a-vi-address_complete').val() ? $('.a-vi-address_complete').val() + " " : "";

    if (!storage) {

        var victim_personal_address_info = [{
                'address_region': $('.a-vi-address_region').val(),
                'address_province': $('.a-vi-address_province').val(),
                'address_city': $('.a-vi-address_city').val(),
                'address_barangay': $('.a-vi-address_barangay').val(),
                'address_complete': $('.a-vi-address_complete').val(),
                'address_overview': l,
            }];

        _setStorageData(victim_personal_address_info, 'victim_personal_address_info');
    } else {

        var victim_personal_address_info = {
            'address_region': $('.a-vi-address_region').val(),
            'address_province': $('.a-vi-address_province').val(),
            'address_city': $('.a-vi-address_city').val(),
            'address_barangay': $('.a-vi-address_barangay').val(),
            'address_complete': $('.a-vi-address_complete').val(),
            'address_overview': l,
        };

        storage.push(victim_personal_address_info);

        _setStorageData(storage, 'victim_personal_address_info');

    }

    $('#form-add_address_info')[0].reset();

    //show list
    getVictimAddressInfoList();

}

function getVictimAddressInfoList() {

    var address = _getStorageData('victim_personal_address_info');

    var cnt = 0;
    var r = 0;
    var t = '';
    var l = '';

    // Non Data Content
    l += '<tr>';
    l += '<td colspan="2" class="text-center"  style="text-align: center !important">No address info added to list.</td>';
    l += '</tr>';

    if (address.length > 0) {

        $.each(address, function (key, val) {

            var address_id = '';

            if (val.address_id) {
                address_id = 'data-address_id = "' + val.address_id + '"';
            }

            var l_address = val.address_overview
            if (!l_address) {
                l_address = val.address_complete;
            }

            if ((val.status === undefined) || ((val.status !== undefined) && (val.status == '1'))) {
                t += '<tr>';
                t += '<td>' + l_address + '</td>';
                t += '<td> <div class="btn-group ellipse-action" data-id="vi-address_info_list' + cnt + '" data-tab="">';
                t += '<a class="a-ellipse a-ellipse-' + cnt + ' " >  <i class="fa fa-ellipsis-v" aria-hidden="true"></i> </a>';
                t += '<div class="action-menu" id="vi-address_info_list' + cnt + '">';
                t += '<a class="dropdown-item disabled action-title" href="#">Select Action</a>';
                t += '<a class="dropdown-item up-victim_address_info" data-id="' + cnt + '" >Update</a>';
                t += '<a class="dropdown-item rm-victim_address_info" data-id="' + cnt + '" ' + address_id + '>Remove</a>';
                t += '</div>';
                t += '</div> </td>';
                t += '</tr>';
                r += 1;
            }
            cnt++;
        });
        if (r == 0) {
            // No Data
            t = l;
        }
    } else {
        // No Data  
        t = l;
    }

    if (address.length >= 1) {
        $('.btn-add_address').attr('disabled', true);
    } else {
        $('.btn-add_address').attr('disabled', false);
    }

    $('.victim-address_info_list').html(t);
}

function storeVictimAddressInfoById() {
    var storedId = $('.stored-address_id').val();

    var current = _getStorageData('victim_personal_address_info');

    var l = '';
    l += $('.u-vi-address_region option:selected').attr('data-name') ? $('.u-vi-address_region option:selected').attr('data-name') + ", " : "";
    l += $('.u-vi-address_province option:selected').attr('data-name') ? $('.u-vi-address_province option:selected').attr('data-name') + ", " : "";
    l += $('.u-vi-address_city option:selected').attr('data-name') ? $('.u-vi-address_city option:selected').attr('data-name') + ", " : "";
    l += $('.u-vi-address_barangay option:selected').attr('data-name') ? $('.u-vi-address_barangay option:selected').attr('data-name') + ", " : "";
    l += $('.u-vi-address_complete').val() ? $('.u-vi-address_complete').val() + " " : "";

    $.each(current[storedId], function (key, val) {
        current[storedId][key] = $('.u-vi-' + key).val();
        if (key == 'address_overview') {
            current[storedId]['address_overview'] = l;
        }
    });

    //get name of type
    current[storedId]['address_type_name'] = $('.u-vi-address_type option:selected').attr('data-name');

    var address_id = $('#form-update_address_info').attr('data-id');
    if (address_id) {
        current[storedId]['address_id'] = address_id;
        current[storedId]['status'] = '1';
    }

    _setStorageData(current, 'victim_personal_address_info');

    $("#modal-update_address_info").modal('hide');
    $('#form-update_address_info')[0].reset();

    getVictimAddressInfoList();

}

function storeVictimRelativeInfo() {

    var storage = _getStorageData('victim_personal_relative_info');
    var type_name = $('.a-vi-relative_type option:selected').attr('data-name');
    if ($('.a-vi-relative_type option:selected').attr('data-name') == 'Other') {
        type_name = $('.a-vi-relative_type option:selected').attr('data-name');
        if ($('.a-vi-relative_other').val() != '') {
            type_name = type_name + ': ' + $('.a-vi-relative_other').val();
        }
    }

    if (!storage) {

        var victim_personal_relative_info = [{
                'relative_type': $('.a-vi-relative_type').val(),
                'relative_type_name': type_name,
                'relative_name': $('.a-vi-relative_name').val(),
                'relative_primary_contact_number': $('.a-vi-relative_primary_contact_number').val(),
                'relative_secondary_contact_number': $('.a-vi-relative_secondary_contact_number').val(),
                'relative_email': $('.a-vi-relative_email').val(),
                'relative_other': $('.a-vi-relative_type option:selected').attr('data-name') == 'Other' ? $('.a-vi-relative_other').val() : ''
            }];

        _setStorageData(victim_personal_relative_info, 'victim_personal_relative_info');
    } else {

        var victim_personal_relative_info = {
            'relative_type': $('.a-vi-relative_type').val(),
            'relative_type_name': type_name,
            'relative_name': $('.a-vi-relative_name').val(),
            'relative_primary_contact_number': $('.a-vi-relative_primary_contact_number').val(),
            'relative_secondary_contact_number': $('.a-vi-relative_secondary_contact_number').val(),
            'relative_email': $('.a-vi-relative_email').val(),
            'relative_other': $('.a-vi-relative_type option:selected').attr('data-name') == 'Other' ? $('.a-vi-relative_other').val() : ''
        };

        storage.push(victim_personal_relative_info);

        _setStorageData(storage, 'victim_personal_relative_info');

    }

    $('#form-add_relative_info')[0].reset();

    //show list
    getVictimRelativeInfoList();

}

function getVictimRelativeInfoList() {

    var relatives = _getStorageData('victim_personal_relative_info');

    var cnt = 0;
    var r = 0;
    var t = '';
    var l = '';

    // Non Data Content
    l += '<tr>';
    l += '<td colspan="4" class="text-center" style="text-align: center !important">No relative info added to list.</td>';
    l += '</tr>';

    if (relatives.length > 0) {
        $.each(relatives, function (key, val) {
            var relative_id = '';

            if (val.relative_id) {
                relative_id = 'data-relative_id = "' + val.relative_id + '"';
            }

            if ((val.status === undefined) || ((val.status !== undefined) && (val.status == '1'))) {
                t += '<tr>';
                t += '<td>' + val.relative_type_name + '</td>';
                t += '<td>' + val.relative_name + '</td>';
                t += '<td>' + val.relative_primary_contact_number + '</td>';
                t += '<td> <div class="btn-group ellipse-action" data-id="vi-relative_info_list' + cnt + '" data-tab="">';
                t += '<a class="a-ellipse a-ellipse-' + cnt + ' " >  <i class="fa fa-ellipsis-v" aria-hidden="true"></i> </a>';
                t += '<div class="action-menu" id="vi-relative_info_list' + cnt + '">';
                t += '<a class="dropdown-item disabled action-title" href="#">Select Action</a>';
                t += '<a class="dropdown-item up-victim_relative_info" data-id="' + cnt + '" >Update</a>';
                t += '<a class="dropdown-item rm-victim_relative_info" data-id="' + cnt + '" ' + relative_id + '>Remove</a>';
                t += '</div>';
                t += '</div> </td>';
                t += '</tr>';
                r += 1;
            }
            cnt++;
        });

        if (r == 0) {
            // No Data
            t += l;
        }
    } else {
        // No Data
        t += l;
    }

    if (relatives.length >= 10) {
        $('.btn-add_relative').attr('disabled', true);
    } else {
        $('.btn-add_relative').attr('disabled', false);
    }

    $('.victim-relative_info_list').html(t);
}

function storeVictimRelativeInfoById() {
    var storedId = $('.stored-relative_id').val();

    var current = _getStorageData('victim_personal_relative_info');

    $.each(current[storedId], function (key, val) {
        current[storedId][key] = $('.u-vi-' + key).val();
    });

    var type_name = $('.u-vi-relative_type option:selected').attr('data-name');
    if ($('.u-vi-relative_type option:selected').attr('data-name') == 'Other') {
        type_name = $('.u-vi-relative_type option:selected').attr('data-name');
        if ($('.u-vi-relative_other').val() != '') {
            type_name = type_name + ': ' + $('.u-vi-relative_other').val();
        }
    }

    //get name of type
    current[storedId]['relative_type_name'] = type_name;

    var relative_id = $('#form-update_relative_info').attr('data-id');
    if (relative_id) {
        current[storedId]['relative_id'] = relative_id;
        current[storedId]['status'] = '1';
    }

    _setStorageData(current, 'victim_personal_relative_info');

    $("#modal-update_relative_info").modal('hide');
    $('#form-update_relative_info')[0].reset();

    getVictimRelativeInfoList();

}

function checkStoredData() {

    var storage = _getStorageData('victim_personal_info');

    if (storage) {


        icmsMessage({
            type: 'msgConfirmation',
            title: 'You have unfinished report encoded.',
            body: 'Do you want to retrieve the unfinished case encoded?',
            LblBtnConfirm: 'Yes',
            LblBtnCancel: 'No',
            onConfirm: function () {
                viewStoredData();
            },
            onCancel: function () {
                clearStoredData();
            }
        });

    } else {
        // Disabled Tabs
        $('.step-trigger').attr('disabled', true);
        // Enable validate tab
        $('#validate-details-tab1').attr('disabled', false);
        localStorage.clear();
    }
}

function checkIfStringExist(sString, sReturn = '-') {
    sReturn = sReturn;
    if (sString) {
        sReturn = sString;
    }
    return sReturn;
}

function viewStoredData() {

    //validation
    getVictimValidationInfo();

    //victim
    getVictimPersonalInfo();
    getVictimContactInfoList();
    getVictimRelativeInfoList();
    getVictimEducationInfoList();
    getVictimAddressInfoList();


    // if victim exist
    var victim_id = localStorage.getItem('victim_id');
    if (victim_id) {
        loadVictimInfoIfExist();
    }



    //employment
    getVictimEmploymentInfo();
    getTransitCountryInfoList();

    //case details
    getVictimCaseInfo();
    getCaseOffenderList();
    getServicesInfoList();
    getDocumentAttachmentInfoList();

    //case summary
    getSummaryDetails();

    $('.btn-next_tab').show();

    // Disabled Tabs
    $('.step-trigger').attr('disabled', true);
    // Enable validate tab
    $('#victims-details-tab1').attr('disabled', false);
    $("#victims-details-tab1").trigger("click");

    icmsModalClose();
}

function clearStoredData() {
    $('.vi-first_name').val('');
    $('.vi-last_name').val('');
    localStorage.clear();
    icmsModalClose();
    // Disabled Tabs
    $('.step-trigger').attr('disabled', true);
    // Enable validate tab
    $('#validate-details-tab1').attr('disabled', false);
}


function initialLoad() {
    getCountries();
    getRegions();
    getProvinces();

    getSex();
    getEthnicGroup();
    getDisabilities();
    getAllergies();
    getIllness();
    getCivilStatus();
    getCasePurposes();
    getContactTypes();
    getReligions();
    getEducationalAttainments();
    getFamilyRelations();
    getOffenderDescription();

    if(temp_data.flag == 1){
        temp_data.is_address = 1;

        icmsMessage({
            type: 'msgPreloader',
            visible: true,
            body: "Please wait while loading."
        });
        
        setTimeout(function () {
            $(".v-first_name").val(temp_data.temporary_victim_firstname);
            $(".v-middle_name").val(temp_data.temporary_victim_middlename);
            $(".v-last_name").val(temp_data.temporary_victim_lastname);
            $(".v-dob").val(temp_data.temporary_victim_dob);
            $(".v-deployment_country").val(temp_data.temporary_victim_country_deployment);
            
            $(".a-vi-contact_type").val(3).change();
            $(".a-vi-contact_content").val(temp_data.temporary_victim_email_address);
            storeVictimContactInfo();

            $(".a-vi-contact_type").val(1).change();
            $(".a-vi-contact_content").val(temp_data.temporary_victim_mobile_number);
            storeVictimContactInfo();

            $(".vi-sex").val(temp_data.temporary_victim_sex).change();
            $(".vi-civil").val(temp_data.temporary_victim_civil_status).change();

            $(".emp-deployment_departure_type").val(temp_data.temporary_victim_departure_type);

            $(".case-complainant_name").val(temp_data.temporary_complainant_firstname + " " + temp_data.temporary_complainant_middlename  + " " + temp_data.temporary_complainant_lastname );
            $(".case-complainant_contact").val(temp_data.temporary_complainant_mobile_number);

            $(".case-complainant_relation").val(temp_data.temporary_complainant_relation);
            $(".case-complainant_relation_other").val(temp_data.temporary_complainant_relation_other);

            $(".case-complainant_address").val(temp_data.temporary_complainant_address);

            $(".btn-validate").click();
        }, 3000);

    }   

//    getVictimsFromValidation();

}

function loadVictimInfoIfExist() {

    var victim_id = localStorage.getItem('victim_id');

    // hide modal
    $('#mdl-victim-details').modal('hide');

    // show preloader
    icmsMessage({
        type: 'msgPreloader',
        visible: true,
        body: "Please wait while loading."
    });

    // Disabled Form for Victim infomation: real name and assumed name 
    $("#container-victim_personal_information :input").prop("disabled", true);

    $.post(sAjaxVictims, {
        type: 'getVictimInformationById',
        victim_id: victim_id,
        include_all: 1
    }, function (rs) {

        if (rs.data.flag == '1') {

            // hide preloader
            icmsMessage({
                type: 'msgPreloader',
                visible: false
            });

            var aVContent = rs.data.content;
            var aVDetails = rs.data.victim_details;
            var globalData = rs.data.Global_data;

            // console.log(aVDetails);
            
            $('.vi-first_name').val(aVContent.real.victim_info_first_name);
            $('.vi-middle_name').val(aVContent.real.victim_info_middle_name);
            $('.vi-last_name').val(aVContent.real.victim_info_last_name);
            $('.vi-suffix').val(aVContent.real.victim_info_suffix);

            $('.vi-dob').val(aVContent.real.victim_info_dob);
            $('.vi-pob').val(aVContent.real.victim_info_city_pob).change();
            // $('.vi-sex').val(aVDetails.victim_gender).change();
            // $('.vi-civil').val(aVDetails.victim_civil_status).change();
            // $('.vi-religion').val(aVDetails.victim_religion).change();
            $('.vi-sex').val(aVDetails.gender_name == aVDetails.gender_name ? globalData.gender_name : "").change();
            $('.vi-civil').val(aVDetails.civil_status_name == aVDetails.civil_status_name ? globalData.civil_status_name : "").change();
            $('.vi-religion').val(aVDetails.region_name == aVDetails.region_name ? globalData.region_name : "").change();

            $('.vi-assumed_first_name ').val(aVContent.assumed.victim_info_first_name);
            $('.vi-assumed_middle_name').val(aVContent.assumed.victim_info_middle_name);
            $('.vi-assumed_last_name').val(aVContent.assumed.victim_info_last_name);
            $('.vi-assumed_dob').val(aVContent.assumed.victim_info_dob);


            // store victim personal contact info to local storage 
            if (aVContent.contact_details.length > 0) {
                var aStorage = [];
                $.each(aVContent.contact_details, function (key, val) {
                    var victim_personal_contact_info = {
                        'conctact_details_id': val.victim_contact_details_id,
                        'contact_type': val.victim_contact_detail_type,
                        'contact_type_name': val.contact_type,
                        'contact_content': val.victim_contact_detail_content,
                        'status': '1'
                    };
                    aStorage.push(victim_personal_contact_info);
                });
                // save to local storage 
                _setStorageData(aStorage, 'victim_personal_contact_info');
                // load in list view 
                getVictimContactInfoList();
            }

            //store educational background to local storage 
            if (aVContent.victim_education_info.length > 0) {
                var aStorage = [];
                $.each(aVContent.victim_education_info, function (key, val) {
                    var victim_personal_education_info = {
                        'victim_education_id': val.victim_education_id,
                        'education_type': val.victim_education_type,
                        'education_type_name': val.education_type_name,
                        'education_school': val.victim_education_school,
                        'education_grade_year': val.victim_education_grade_year,
                        'education_course': val.victim_education_course,
                        'education_start': val.victim_education_start,
                        'education_end': val.victim_education_end,
                        'status': '1'
                    };
                    aStorage.push(victim_personal_education_info);
                });
                // save to local storage 
                _setStorageData(aStorage, 'victim_personal_education_info');
                // load in list view 
                getVictimEducationInfoList();
            }


            //store address information to local storage 
            if (aVContent.victim_address_list.length > 0) {
                var aStorage = [];
                $.each(aVContent.victim_address_list, function (key, val) {

                    var victim_personal_address_info = {
                        'address_id': val.victim_address_list_id,
                        'address_region': val.victim_address_list_region_id,
                        'address_province': val.victim_address_list_province_id,
                        'address_city': val.victim_address_list_city_id,
                        'address_barangay': val.victim_address_list_brgy_id,
                        'address_complete': val.victim_address_list_address,
                        'status': '1'
                    };

                    aStorage.push(victim_personal_address_info);
                });
                // save to local storage 
                _setStorageData(aStorage, 'victim_personal_address_info');
                // load in list view 
                getVictimAddressInfoList();
            }

            //store next of kin 
            if (aVContent.victim_relatives_info.length > 0) {
                var aStorage = [];
                $.each(aVContent.victim_relatives_info, function (key, val) {
                    var victim_personal_relative_info = {
                        'relative_id': val.victim_relative_id,
                        'relative_type': val.victim_relative_type,
                        'relative_type_name': val.victim_relative_type_name,
                        'relative_name': val.victim_relative_fullname,
                        'relative_primary_contact_number': val.victim_relative_primary_contact_number,
                        'relative_secondary_contact_number': val.victim_relative_second_contact_number,
                        'relative_email': val.victim_relative_email,
                        'relative_other': val.victim_relative_type_other,
                        'status': '1'
                    };
                    aStorage.push(victim_personal_relative_info);
                });
                // save to local storage 
                _setStorageData(aStorage, 'victim_personal_relative_info');
                // load in list view 
                getVictimRelativeInfoList();
            }


            $('#mdl-victim-details').modal('hide');
            $('#victims-details-tab1').trigger('click');
        }
    }, 'json');

}

function confirmReloading() {

    // confirmation in reloading/exiting site 
    window.addEventListener('beforeunload', (event) => {
        var storage = _getStorageData('victim_personal_info');
        var f_name = $('.vi-first_name').val();
        var l_name = $('.vi-last_name').val();
        if ((storage) || (f_name) || (l_name)) {
            event.returnValue = `Changes you made may not be saved.`;
        }
    });
}

function setDetailsBasedOnValidate() {

    $('#validate-details-tab1').attr('disabled', true);

    $('.vi-first_name').val(localStorage.getItem('victim_info_first_name'));
    $('.vi-middle_name').val(localStorage.getItem('victim_info_middle_name'));
    $('.vi-last_name').val(localStorage.getItem('victim_info_last_name'));
    $('.vi-dob').val(localStorage.getItem('victim_info_dob'));
    $('.vi-pob').val(localStorage.getItem('victim_info_city_pob'));
    //offender_name: localStorage.getItem('offender_name'))

    $('.emp-employer_name').val(localStorage.getItem('employer_name'));
    $('.emp-local_agency_name').val(localStorage.getItem('local_recruitment_agency'));

    $('.emp-deployment_date').val(localStorage.getItem('deployed_date'));
    $('#emp-sel-eer-country').val(localStorage.getItem('deployment_country')).change();
    $('#cd-sel-purposes').val(localStorage.getItem('traffic_purpose')).trigger("chosen:updated");

    storeVictimDetails();
}

function returnTop() {
    $('html, body').animate({scrollTop: 0}, '300');
}

function getProvincesByRegionId_report(id) {
    $.post(sAjaxGlobalData, {
        type: "getProvinceByRegionID",
        region_id: id
    }, function (rs) {
        var l = "<option selected disabled >Select Province</option>";
        $('.sel-provincesByRegionId').html(l);
        if (rs.data) {
            $.each(rs.data, function (key, val) {
                l += "<option value='" + val.location_count_id + "' data-name='" + val.location_name + "'>" + val.location_name + "</option>";
            });
            $('.sel-provincesByRegionId').html(l);
            var iVal = $('.u-vi-address_province').attr('data-id');
            if (iVal) {
                $('.u-vi-address_province').val(iVal).change();
            }
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
                l += "<option value='" + val.location_count_id + "' data-name='" + val.location_name + "'>" + val.location_name + "</option>";
            });
            $('.sel-cities').html(l);
            var iVal = $('.u-vi-address_city').attr('data-id');
            if (iVal) {
                $('.u-vi-address_city').val(iVal).change();
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
        $('.sel-barangay').html(l);
        if (rs.data) {
            $.each(rs.data, function (key, val) {
                l += "<option value='" + val.location_count_id + "' data-name='" + val.location_name + "'>" + val.location_name + "</option>";
            });
            $('.sel-barangay').html(l);
            var iVal = $('.u-vi-address_barangay').attr('data-id');
            if (iVal) {
                $('.u-vi-address_barangay').val(iVal).change();
            }
        }
    }, 'json');
}

$(document).ready(function () {

    // return top 
    returnTop();
    //check if there is unfinish case encoded 
    //checkStoredData();

    //get global, location and transaction data
    initialLoad();

    // delete stored data 
    clearStoredData();

    // confirmation in reloading/exiting site 
    confirmReloading();


    //------------PRELOADER_----------//
//    $('#loadMeloader').modal('show');
//    setTimeout(function () {
//        $('#loadMeloader').modal('hide');
//    }, 1000);
    //-----------end of preloader-------//

    // date picker 
    $('.datepicker').datetimepicker({
        timepicker: false,
        format: 'm/d/Y',
        scrollMonth: false,
        scrollInput: false
    });

    // date time picker 
    $('.datetimepicker').datetimepicker({
        scrollMonth: false,
        scrollInput: false
    });

    // bring/eturn to top 
    $('.return-top').click(function () {
        returnTop();
    });

    jQuery(function () {

        // start datepicker
        jQuery('#__date_timepicker_start').datetimepicker({
            format: 'm/d/Y',
            timepicker: false,
            scrollMonth: false
        });

        // end datepicker 
        jQuery('#__date_timepicker_end').datetimepicker({
            format: 'm/d/Y',
            onShow: function (ct) {
                this.setOptions({
                    minDate: jQuery('#date_timepicker_start').val() ? jQuery('#date_timepicker_start').val() : false
                })
            },
            timepicker: false,
            scrollMonth: false
        });
    });

    $('#msgmodal').delegate('.a-vi-contact_province', 'change', function () {
        var province_id = $(this).val();
        getCityByProvinceID(province_id);
    });

    $('.btn-next_tab').click(function () {
        var tab = $(this).attr('data-tab');
        $('.step-trigger').attr('disabled', true);
        $('#' + tab + '-details-tab1').attr('disabled', false);
        $('#' + tab + '-details-tab1').trigger('click');

        switch (tab) {
            case 'victims':
                initialVictimTabFunctions();
                break;
            case 'employment':

                break;
            case 'case':

                break;
            case 'summary':

                break;
            default:
                break;
        }

    });

    $('.btn-previous_tab').click(function () {
        var tab = $(this).attr('data-tab');
        $('#' + tab + '-details-tab1').trigger('click');
        $('.step-trigger').attr('disabled', true);
        $('#' + tab + '-details-tab1').attr('disabled', false);
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


    //contact info actions
    $('.victim-contact_info_list').delegate('.rm-victim_contact_info', 'click', function () {

        var id = $(this).attr('data-id');
        var conctact_details_id = $(this).attr('data-conctact_details_id');

        icmsMessage({
            type: 'msgConfirmation',
            title: 'You are about to remove an victim contact information.',
            body: 'Click continue button if you wish to continue.',
            LblBtnConfirm: 'Continue',
            LblBtnCancel: 'Cancel',
            onConfirm: function () {

                if (conctact_details_id) {
                    var storedId = id;
                    var current = _getStorageData('victim_personal_contact_info');
                    current[storedId]['status'] = '0';
                    _setStorageData(current, 'victim_personal_contact_info');
                } else {
                    var storage = _getStorageData('victim_personal_contact_info');
                    _rmStorageDataById(storage, storage[id]);
                    _setStorageData(storage, 'victim_personal_contact_info');
                }

                getVictimContactInfoList();

            },
        });
    });

    $('.victim-contact_info_list').delegate('.up-victim_contact_info', 'click', function () {
        // remove data-id for conctact_details_id
        $('#form-update_contact_info').removeAttr('data-id');

        // index 
        var id = $(this).attr('data-id');
        $('.stored-contact_id').val(id);
        var x = _getStorageData('victim_personal_contact_info');

        $('.lbl-contact-type').text(x[id]['contact_type_name']);
        $.each(x[id], function (key, val) {
            $('.u-vi-' + key).val(val);
        });

        // conctact_details_id
        if (x[id]['conctact_details_id']) {
            $('#form-update_contact_info').attr('data-id', x[id]['conctact_details_id']);
        }

        $('#modal-update_contact_info').modal('show');

    });

    //education info actions
    $('.victim-education_info_list').delegate('.rm-victim_education_info', 'click', function () {
        var id = $(this).attr('data-id');
        var victim_education_id = $(this).attr('data-victim_education_id');
        icmsMessage({
            type: 'msgConfirmation',
            title: 'You are about to remove an victim education information.',
            body: 'Click continue button if you wish to continue.',
            LblBtnConfirm: 'Continue',
            LblBtnCancel: 'Cancel',
            onConfirm: function () {
                if (victim_education_id) {
                    var storedId = id;
                    var current = _getStorageData('victim_personal_education_info');
                    current[storedId]['status'] = '0';
                    _setStorageData(current, 'victim_personal_education_info');
                } else {
                    var storage = _getStorageData('victim_personal_education_info');
                    _rmStorageDataById(storage, storage[id]);
                    _setStorageData(storage, 'victim_personal_education_info');
                }
                getVictimEducationInfoList();
            },
        });
    });

    $('.victim-education_info_list').delegate('.up-victim_education_info', 'click', function () {

        // remove data-id for victim_education_id
        $('#form-update_education_info').removeAttr('data-id');

        var id = $(this).attr('data-id');
        var educ_type = $(this).attr('data-edname');

        $('.stored-education_id').val(id);

        var x = _getStorageData('victim_personal_education_info');



        $.each(x[id], function (key, val) {
            $('.u-vi-' + key).val(val);
        });

        var n = educ_type.includes('Undergraduate');
        var f = educ_type.includes('Elementary');

        if ($('.u-vi-education_type').val() == "13") {
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
                $('.u-vi-education_grade_year').val('');
            } else {
                $('.field-education_grade_year').show();
            }

            if ((f) || (educ_type == 'High School Graduate') || (educ_type == 'High School Undergraduate')) {
                $('.field-education_course').hide();
            } else {
                $('.field-education_course').show();
            }
        }

        // conctact_details_id
        if (x[id]['victim_education_id']) {
            $('#form-update_education_info').attr('data-id', x[id]['victim_education_id']);
        }

        $('#modal-update_education_info').modal('show');
    });

    // select update education 
    $('.u-vi-education_type').change(function () {
        var str = $('.u-vi-education_type option:selected').attr('data-name');
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
                $('.u-vi-education_grade_year').val('');
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

    //address info actions
    $('.victim-address_info_list').delegate('.rm-victim_address_info', 'click', function () {
        var id = $(this).attr('data-id');
        var address_id = $(this).attr('data-address_id');

        icmsMessage({
            type: 'msgConfirmation',
            title: 'You are about to remove an victim address information.',
            body: 'Click continue button if you wish to continue.',
            LblBtnConfirm: 'Continue',
            LblBtnCancel: 'Cancel',
            onConfirm: function () {
                if (address_id) {
                    var storedId = id;
                    var current = _getStorageData('victim_personal_address_info');
                    current[storedId]['status'] = '0';
                    _setStorageData(current, 'victim_personal_address_info');
                } else {
                    var storage = _getStorageData('victim_personal_address_info');
                    _rmStorageDataById(storage, storage[id]);
                    _setStorageData(storage, 'victim_personal_address_info');
                }
                getVictimAddressInfoList();
            },
        });
    });

    $('.victim-address_info_list').delegate('.up-victim_address_info', 'click', function () {

        // remove data-id for conctact_details_id
        $('#form-update_address_info').removeAttr('data-id');

        var l = "";
        $('.u-vi-address_province').html(l);
        $('.u-vi-address_city').html(l);
        $('.u-vi-address_barangay').html(l);
        $('.u-vi-address_province').prop("disabled", true);
        $('.u-vi-address_city').prop("disabled", true);
        $('.u-vi-address_barangay').prop("disabled", true);

        var id = $(this).attr('data-id');
        $('.stored-address_id').val(id);

        var x = _getStorageData('victim_personal_address_info');

        $('.u-vi-address_complete').val(x[id]['address_complete']);

        // new 
        var p_id = x[id]['address_region'];
        $('.u-vi-address_region').val(p_id).change();

        var p_id = x[id]['address_province'];
        if (p_id) {
            $('.u-vi-address_province').attr('data-id', p_id);
        }

        var p_id = x[id]['address_city'];
        if (p_id) {
            $('.u-vi-address_city').attr('data-id', p_id);
        }

        var p_id = x[id]['address_barangay'];
        if (p_id) {
            $('.u-vi-address_barangay').attr('data-id', p_id);
        }

        $('#modal-update_address_info').modal('show');

//        // here 
//        setTimeout(function () {
//            var p_id = x[id]['address_region'];
//            $('.u-vi-address_region').val(p_id).change();
//            setTimeout(function () {
//                var p_id = x[id]['address_province'];
//                console.log('address_province->' + p_id);               
//                $('.u-vi-address_province').attr('data-id',p_id);
//                setTimeout(function () {
//                    var p_id = x[id]['address_city'];
//                    console.log('address_city->' + p_id);
//                    $('.u-vi-address_city').val(p_id).change();
//                    setTimeout(function () {
//                        var p_id = x[id]['address_barangay'];
//                        console.log('address_barangay->' + p_id);
//                        $('.u-vi-address_barangay').val(p_id).change();
//                        icmsMessage({
//                            type: 'msgPreloader',
//                            visible: false,
//                        });
//                        // modal 
//                        $('#modal-update_address_info').modal('show');
//                    }, 1000);
//                }, 1000);
//            }, 1000);
//        }, 100);

        // conctact_details_id
        if (x[id]['address_id']) {
            $('#form-update_address_info').attr('data-id', x[id]['address_id']);
        }

    });

    //relative info actions
    $('.victim-relative_info_list').delegate('.rm-victim_relative_info', 'click', function () {
        var id = $(this).attr('data-id');
        var relative_id = $(this).attr('data-relative_id');

        icmsMessage({
            type: 'msgConfirmation',
            title: 'You are about to remove an victim relative information.',
            body: 'Click continue button if you wish to continue.',
            LblBtnConfirm: 'Continue',
            LblBtnCancel: 'Cancel',
            onConfirm: function () {
                if (relative_id) {
                    var storedId = id;
                    var current = _getStorageData('victim_personal_relative_info');
                    current[storedId]['status'] = '0';
                    _setStorageData(current, 'victim_personal_relative_info');
                } else {
                    var storage = _getStorageData('victim_personal_relative_info');
                    _rmStorageDataById(storage, storage[id]);
                    _setStorageData(storage, 'victim_personal_relative_info');
                }
                getVictimRelativeInfoList();
            },
        });
    });

    $('.victim-relative_info_list').delegate('.up-victim_relative_info', 'click', function () {

        // remove data-id for update_relative_info
        $('#form-update_relative_info').removeAttr('data-id');

        var id = $(this).attr('data-id');
        $('.stored-relative_id').val(id);

        var x = _getStorageData('victim_personal_relative_info');

        $.each(x[id], function (key, val) {
            $('.u-vi-' + key).val(val);
        });

        // relative_id
        if (x[id]['relative_id']) {
            $('#form-update_relative_info').attr('data-id', x[id]['relative_id']);
        }

        var selected = $(".u-vi-relative_type option:selected").text().toLowerCase().replace(" ", "");
        if (selected === "other") {
            $('.row-other-u').removeClass("hide");
        } else {
            $('.row-other-u').addClass("hide");
        }

        $('#modal-update_relative_info').modal('show');
    });

    //open modals
    $('.btn-add_contact').click(function () {
        $("#modal-add_contact_info").modal('show');
        $('.lbl-contact-type').text('Value');
    });

    $('.btn-add_education').click(function () {
        $("#modal-add_education_info").modal('show');
        $('.field-education_grade_year').show();
        $('.field-education_course').show();
        $('.field-education_school_name').show();
        $('.field-education_start-end').show();
        $('.field-education_grade_year').hide();
    });

    $('.btn-add_address').click(function () {

        var l = "";
        $('.a-vi-address_province').html(l);
        $('.a-vi-address_province').prop("disabled", true);
        $('.a-vi-address_city').html(l);
        $('.a-vi-address_city').prop("disabled", true);
        $('.a-vi-address_barangay').html(l);
        $('.a-vi-address_barangay').prop("disabled", true);

        if(temp_data){
            temp_data.is_address = 0; 
            $(".a-vi-address_complete").val(temp_data.temporary_victim_address);
        }

        $("#modal-add_address_info").modal('show');

      
    });

    $('.btn-add_relative').click(function () {
        $("#modal-add_relative_info").modal('show');
    });


    $("#form-update_victim_details").validate({
        rules: {
            first_name: {required: true},
            last_name: {required: true},
            // v_dob: {
            //     required: true,
            //     pastDateOptional: true
            // },
            vi_sex: {
                required: true
            },
            vi_civil_status: {
                required: true
            },  
            // v_adob: {pastDateOptional: true}
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

            var address = _getStorageData('victim_personal_address_info');
            if (isNull(address) == true) {
                icmsMessage({
                    type: 'msgWarning',
                    body: '<center> At least one address information is required. </center>',
                    caption: 'Close',
                });
            } else {
                storeVictimDetails();
                $('.step-trigger').attr('disabled', true);
                $('#employment-details-tab1').trigger('click');
                $('#employment-details-tab1').attr('disabled', false);
                returnTop();

                let is_set = $("#form-update_employment_info").attr('data-chosen'); 
                if(!is_set){
                    $("#form-update_employment_info").attr('data-chosen','1'); 
                    // set up chosen js 
                    $("#emp-act_position").chosen(); 
                    $("#emp-position").chosen(); 
                    $("#emp_position_chosen").removeAttr('style');
                    $("#emp_act_position_chosen").removeAttr('style');
                    $("#emp_position_chosen").addClass('w-100');
                    $("#emp_act_position_chosen").addClass('w-100');
                }
                
            }

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
            storeVictimContactInfo();
            $('#modal-add_contact_info').modal('hide');
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
            storeVictimContactInfoById();
            $('#modal-update_contact_info').modal('hide');
        }
    });

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
            year_end: {
                year_end_educ: true,
                pastYearOption: true,
                number: true,
            },
            year_start: {
                number: true,
                pastYearOption: true,
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
            storeVictimEducationInfo();
            $('#modal-add_education_info').modal('hide');
        }
    });

    $('#form-update_education_info').validate({
        rules: {
            education_type: {required: true},
            year_end: {
                year_end_educ: true
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
            storeVictimEducationInfoById();
            $('#modal-update_education_info').modal('hide');
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
            storeVictimAddressInfo();
            $('#modal-add_address_info').modal('hide');
        }
    });

    $('#form-update_address_info').validate({
        rules: {
            region: {required: true},
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
            storeVictimAddressInfoById();
            $('#modal-update_address_info').modal('hide');
        }
    });

    $('#form-add_relative_info').validate({
        rules: {
            relative_type: {required: true},
            relative_name: {required: true},
            email: {email: true},
            primary_contact: {
                maxlength: 20,
                minlength: 7,
                number: true,
            },
            secondary_contact: {
                maxlength: 20,
                minlength: 7,
                number: true,
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
            storeVictimRelativeInfo();
            $('#modal-add_relative_info').modal('hide');
        }
    });

    $('#form-update_relative_info').validate({
        rules: {
            relative_type: {required: true},
            relative_name: {required: true},
            email: {email: true},
            primary_contact: {maxlength: 20, minlength: 7},
            secondary_contact: {maxlength: 20, minlength: 7}
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
            storeVictimRelativeInfoById();
            $('#modal-update_relative_info').modal('hide');
        }
    });

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

    // for update 
    $('.u-vi-address_region').change(function () {
        getProvincesByRegionId_report(this.value);
        $('.u-vi-address_province').attr('disabled', false);
    });

    $('.u-vi-address_province').change(function () {
        getCityByProvinceId_report(this.value);
        $('.u-vi-address_city').attr('disabled', false);
    });

    $('.u-vi-address_city').change(function () {
        getBrgyByCityID_report(this.value);
        $('.u-vi-address_barangay').attr('disabled', false);
    });

    $('.vi-assumed_dob').on('input', function () {
//        alert('in0uadsa');
    });


    $('.validate-add-new-btn').click(function () {

        var victim_id = $(this).attr('data-victim_id');

        icmsMessage({
            type: 'msgConfirmation',
            title: 'You are about to add new rerpot to <br> <em>' + $('.msgmodal-header .vic-name').text() + '</em>',
            body: 'Click continue button if you wish to continue.',
            LblBtnConfirm: 'Continue',
            onConfirm: function () {
                // set victim_id in local storage
                localStorage.setItem('victim_id', victim_id);
                $('.vi-first_name').val(localStorage.getItem('victim_info_first_name'));
                $('.vi-middle_name').val(localStorage.getItem('victim_info_middle_name'));
                $('.vi-last_name').val(localStorage.getItem('victim_info_last_name'));
                $('.vi-dob').val(localStorage.getItem('victim_info_dob'));
                $('.vi-pob').val(localStorage.getItem('victim_info_city_pob'));
                //offender_name: localStorage.getItem('offender_name'))
                $('.emp-employer_name').val(localStorage.getItem('employer_name'));
                $('.emp-local_agency_name').val(localStorage.getItem('local_recruitment_agency'));
                $('.emp-deployment_date').val(localStorage.getItem('deployed_date'));
                $('.emp-deployment_country').val(localStorage.getItem('deployment_country'));
                loadVictimInfoIfExist();
            },
            onCancel: function () {
                $('#mdl-victim-details').modal('show');
            },
            onShow: function () {
                $('#mdl-victim-details').modal('hide');
            }
        });

    });


    // disable enter in submit 
    $('form input').on('keypress', function (e) {
        return e.which !== 13;
    });


    // validate victim details local recruitment name 
    $('.v-local_recruitment_agency').on('keyup', function (e) {
        var keyword = $('.v-local_recruitment_agency').val();
        setTimeout(function () {
            if (keyword.length) {
                // enable 
                $(".div-agency_local_form :input").prop("disabled", false);

                $.post(sAjaxRecruitment, {
                    type: 'getLocalRecruitmentByKeyword',
                    keyword: keyword,
                }, function (rs) {
                    if (rs.data.flag != '0') {
                        $('#validate-local-search').show();
                        var l = '';
                        $.each(rs.data.list, function (key, val) {
                            l += " <li class='list-group-item' data-id='" + val.recruitment_agency_id + "'>" + val.recruitment_agency_name + "</li>";
                        });
                        $('#validate-local-search').html(l);
                    } else {
                        $('#validate-local-search').hide();
                    }
                }, 'json');
            } else {
                //disable
                $(".div-agency_local_form :input").prop("disabled", true);
            }
        }, 1000);
    });

    // click choices shown in local recruiter agency 
    $('#validate-local-search').delegate('.list-group-item', 'click', function () {
        var name = $(this).text();
        $('.v-local_recruitment_agency').val(name);
    });


    // validate victim details employer name 
    $('.v-employer_name').on('keyup', function (e) {
        var keyword = $('.v-employer_name').val();
        setTimeout(function () {
            if (keyword.length) {

                // enable
                $(".div-employer_form :input").prop("disabled", false);

                $.post(sAjaxEmployer, {
                    type: 'getEmployerByKeyword',
                    keyword: keyword,
                }, function (rs) {
                    if (rs.data.flag != '0') {
                        $('#validate-employer-search').show();
                        var l = '';
                        $.each(rs.data.list, function (key, val) {
                            l += " <li class='list-group-item' data-id='" + val.employer_id + "'>" + val.employer_name + "</li>";
                        });
                        $('#validate-employer-search').html(l);
                    } else {
                        $('#validate-employer-search').hide();
                    }
                }, 'json');
            } else {

                // disable 
                $(".div-employer_form :input").prop("disabled", true);
            }

        }, 1000);
    });

    // click choices shown in employer
    $('#validate-employer-search').delegate('.list-group-item', 'click', function () {
        var name = $(this).text();
        $('.v-employer_name').val(name);
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


    $('.u-vi-relative_type').change(function () {
        var selected = $(".u-vi-relative_type option:selected").text().toLowerCase().replace(" ", "");

        if (selected === "other") {
            $('.row-other-u').removeClass("hide");
        } else {
            $('.row-other-u').addClass("hide");
        }
        $(".u-vi-relative_other").val("");
    });


    // Validate Victim Pagination 
    $('.rs-list').delegate('.page-link', 'click', function () {
        var page = parseInt($(this).attr('data-page'));
        getVictimsFromValidation(page);
    });


    // reset form when modal close 
    $(".modal").on('hide.bs.modal', function () {
        var f_id = $(this).attr('id');
        f_id = $('#' + f_id + ' form').attr('id');

        if (f_id) {
            switch (f_id) {
                case 'form-add_document_info':
                case 'form-update_document_info':
                    // do nothing 
                    break;
                default:
                    $('.modal form input').val('');
                    $('#' + f_id)[0].reset();
                    var validator = $("#" + f_id).validate();
                    validator.resetForm();
            }
        }
    });

    //  continue to add new report 
   $('.btn-fr_validate').click(function () {
       icmsMessage({
           type: 'msgConfirmation',
           title: 'There is no existing report and victim, you are about to file a new report. ',
           body: 'Click continue button if you wish to continue.',
           LblBtnConfirm: 'Continue',
           LblBtnCancel: 'Cancel',
           onConfirm: function () {
               $('#victims-details-tab1').click();
               $('#victims-details-tab1').attr('disabled', false);
               setDetailsBasedOnValidate();
           },
       });
   });

    // change label in add victim contact type
    $('.a-vi-contact_type').change(function () {
        $('.lbl-contact-type').html($('.a-vi-contact_type option:selected').text());

        $('.a-vi-contact_content').attr('type', 'text');
        $('.a-vi-contact_content').attr('minlength', '5');
        $('.a-vi-contact_content').removeClass('numbersOnly');

        var c_val = parseInt($(this).val());
        switch (c_val) {
            case 1:
                // phone 
                $('.a-vi-contact_content').attr('maxlength', '20');
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
                $('.a-vi-contact_content').attr('maxlength', '1000');
                break;
            case 2:
                // telephone 
                $('.a-vi-contact_content').attr('maxlength', '20');
                $('.a-vi-contact_content').addClass('numbersOnly');
                $('.a-vi-contact_content').attr('type', 'number');
                break;
        }
        resetFormJQueryValidation('form-add_contact_info');
    });

    // change label in update victim contact type
    $('.u-vi-contact_type').change(function () {
        $('.lbl-contact-type').html($('.u-vi-contact_type option:selected').text());

        $('.u-vi-contact_content').attr('type', 'text');
        $('.u-vi-contact_content').attr('minlength', '5');

        var c_val = parseInt($(this).val());
        switch (c_val) {
            case 1:
                // phone 
                $('.u-vi-contact_content').attr('maxlength', '20');
                $('.u-vi-contact_content').addClass('numbersOnly');
                $('.u-vi-contact_content').attr('type', 'number');
                break;
            case 3:
                // email
                $('.u-vi-contact_content').attr('type', 'email');
                $('.u-vi-contact_content').attr('maxlength', '100');
                break;
            case 4:
                // facebooklink
                $('.u-vi-contact_content').attr('maxlength', '1000');
                $('.u-vi-contact_content').attr('type', 'text');
                break;
            case 2:
                // telephone 
                $('.u-vi-contact_content').attr('maxlength', '20');
                $('.u-vi-contact_content').addClass('numbersOnly');
                $('.u-vi-contact_content').attr('type', 'number');
                break;
        }
        resetFormJQueryValidation('form-update_contact_info');
    });



    $('#validate-local-search').delegate('.list-group-item', 'click', function () {
        var id = $(this).attr('data-id');
        getRecruitmentDetailsByID(id, '1');
        $('#form-validate_victim .v-local_recruitment_agency').attr('data-id', id);
        $('.emp-local_agency_name').attr('data-id', id);
    });

    $('#validate-employer-search').delegate('.list-group-item', 'click', function () {
        var id = $(this).attr('data-id');
        getEmployerDetailsByID(id);
        $('#form-validate_victim .v-employer_name').attr('data-id', id);
        $('.emp-employer_name').attr('data-id', id);
    });

    $('#form-validate_victim .v-employer_name').click(function () {
        var id = $(this).attr('data-id');
        if (id != '0') {
            $('#form-validate_victim .v-employer_name').val('');
            $(this).attr('data-id', '0');
            $('.emp-employer_name').attr('data-id', '0');
            clearEmployerDetails();
            $(".div-employer_form :input").prop("disabled", true);
        }
    });

    $('#form-validate_victim .v-local_recruitment_agency').click(function () {
        var id = $(this).attr('data-id');
        if (id != '0') {
            $('#form-validate_victim .v-local_recruitment_agency').val('');
            $(this).attr('data-id', '0');
            $('.emp-local_agency_name').attr('data-id', '0');
            clearRecruitmentAgency(1);
            $(".div-agency_local_form :input").prop("disabled", true);
        }
    });

});
