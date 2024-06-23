
function getVictimTransitInfoById(id) {
    $.post(sAjaxCaseDetails, {
        type: "getVictimTransitInfoById",
        case_victim_transit_id: id,
        case_id: $('#case_id').val(),
    }, function (rs) {

        rs = html_entity_decode(rs);

        if (rs.data.flag == 1) {
            $.each(rs.data.victim_transit_info, function (key, val) {
                $('.u-emp-' + key).val(val);
            });
            var vti = rs.data.victim_transit_info;


            $('.u-emp-case_victim_transit_departure_date').val(dateFormatToPicker(vti.case_victim_transit_departure_date));
            $('.u-emp-case_victim_transit_arrival_date').val(dateFormatToPicker(vti.case_victim_transit_arrival_date));
            $('.emp-txt-tansit-city').val(vti.case_victim_transit_departure_city);

            aInitialValues["layover_details"] = getFormValues('form-update_layover_info');

            $('#update-modal-transit-country').modal('show');
        }
    }, 'json');
}

function addTransitDetails() {
    icmsMessage({
        type: "msgPreloader",
        body: "Saving... Please wait!",
        visible: true
    });

    $.post(sAjaxCaseDetails, {
        type: "addTransitDetails",
        case_id: $('#case_id').val(),
        country_id: $('#emp-sel-Transit-country').val(),
        city: $('.emp-txt-tansit-city').val(),
        depdate: $('.emp-txt-tansit-depart-date').val(),
        arrdate: $('.emp-txt-tansit-arrival-date').val(),
        remark: $('.a-emp-case_victim_transit_remarks').val(),
    }, function (rs) {
        $('#modal-transit-country').modal('hide');
        getTransitList();
        notifyChangesInReport();
    }, 'json');
}

function getPassportDetails(isAction) {
    $.post(sAjaxCase, {
        type: "getPassportDetails",
        case_id: $('#case_id').val(),
    }, function (rset) {

        rset = html_entity_decode(rset);

        if (rset.data.result == "1") {
            var rs = rset.data.passport;
            $('#emp-txt-passport').val(rs.victim_passport_number);
            $('#emp-txt-fname').val(rs.victim_passport_first_name);
            $('#emp-txt-mname').val(rs.victim_passport_middle_name);
            $('#emp-txt-lname').val(rs.victim_passport_last_name);
            $('#emp-txt-suffix').val(rs.victim_passport_suffix_name);
            $('.emp-victim_passport_gender').val(rs.victim_passport_gender);
            $('.emp-victim_passport_civil_status').val(rs.victim_passport_civil_status);
            $('.emp-victim_passport_dob').val(rs.victim_passport_dob);

            $('.emp-victim_passport_province_pob').attr('data-id', rs.victim_passport_province_pob);
            $('.emp-victim_passport_province_pob').val(rs.victim_passport_province_pob).change();

            $('.emp-victim_passport_city_pob').attr('data-id', rs.victim_passport_city_pob);
            $('.emp-victim_passport_city_pob').val(rs.victim_passport_city_pob).change();

            $('.emp-victim_passport_place_issue').val(rs.victim_passport_place_issue);
            $('.emp-victim_passport_date_issued').val(rs.victim_passport_date_issued);
            $('.emp-victim_passport_date_expired').val(rs.victim_passport_date_expired);
            $('#btn-save-passport').attr('ppid', rs.victim_passport_id);
        } else {
            $('#btn-save-passport').attr('ppid', '0');
        }
        $('#btn-save-passport').attr('cvid', rset.data.case_victim_id);


        aInitialValues["passport_details"] = '';
        aInitialValues["passport_details"] = getFormValues('frm-passport');

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

function getDeploymentDetails(isAction) {
    $.post(sAjaxCase, {
        type: "getDeploymentDetails",
        case_id: $('#case_id').val(),
    }, function (rs) {

        rs = html_entity_decode(rs);

        $('#emp-sel-departure').val(rs.data.case_victim_deployment_type).change();
        $('#emp-sel-port_of_exit').val(rs.data.port_id).change();
        $('#emp-sel-visa').val(rs.data.case_victim_visa_category_id).change();
        $('#emp-sel-country-dest').val(rs.data.case_victim_deployment_country_destination);
        $('.emp-case_victim_deployment_date').val(rs.data.case_victim_deployment_date);
        $('.emp-case_victim_deployment_arrival_date').val(rs.data.case_victim_deployment_arrival_date);
        $('.emp-case_victim_deployment_other_port_details').val(rs.data.case_victim_deployment_other_port_details);
        $('.emp-deployment_remark').val(rs.data.case_victim_deployment_remark);
        $('.emp-deployment_escort_name').val(rs.data.case_victim_deployment_escorted_person_name);
        $('.emp-deployment_escort_description').val(rs.data.case_victim_deployment_escorted_details);
        $('#emp-deployment_document_is_falsified').prop("checked", false);
        if (rs.data.case_victim_deployment_document_is_falsified == "1") {
            $('#emp-deployment_document_is_falsified').prop("checked", true);
        }
        $('#btn-save-deployment').attr("depid", rs.data.case_victim_deployment_id);

        var chk = 0;
        if ($('#emp-deployment_document_is_falsified').is(':checked') == true) {
            chk = 1;
        }

        aInitialValues["deployment_details"] = '';
        aInitialValues["deployment_details"] = getFormValues('frm-deployment') + chk;

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

function getRecruitmentInformation(rect_type) {
    $.post(sAjaxCase, {
        type: "getRecruitmentInformation",
        case_id: $('#case_id').val(),
        rect_type: rect_type,
    }, function (rset) {
        rs = rset.data;
        rs = html_entity_decode(rs);

        if (rect_type == "1") {
            // local rect
            $.each(rs.details, function (key, val) {
                $('.emp-local-' + key).val(val);
            });

            $.each(rs.owner, function (key, val) {
                $('.emp-local_agency_owner_' + key).val(val);
            });

            $.each(rs.representative, function (key, val) {
                $('.emp-local_agency_rep_' + key).val(val);
            });

            $.each(rs.agent, function (key, val) {
                $('.emp-local_agency_agent_' + key).val(val);
            });

            // for region id 
            $('.emp-local_agency_region').val(rs.details.region_id).change();

            // set time for half second 
            setTimeout(function () {
                $('.emp-local_agency_province').val(rs.details.province_id).change();
            }, 500);


            $('#btn-save-local-rect').attr("rectid", rs.recruitment_agency_id);
            $('.emp-local-recruitment_agency_name').attr("rectid", rs.recruitment_agency_id);
            aInitialValues["local_rec_details"] = getFormValues('frm-local-rect');

        } else {
            //foreign
            $.each(rs.details, function (key, val) {
                $('.emp-foreign-' + key).val(val);
            });

            $.each(rs.owner, function (key, val) {
                $('.emp-foreign-recruitment_agency_owner_' + key).val(val);
            });

            $.each(rs.representative, function (key, val) {
                $('.emp-foreign-recruitment_agency_rep_' + key).val(val);
            });

            $('#btn-save-foreign-rect').attr("rectid", rs.recruitment_agency_id);

            aInitialValues["foreign_rec_details"] = getFormValues('frm-foreign-rect');

        }

    }, 'json');
}

function getRecruitmentDetailsByID(id, type_id) {

    $.post(sAjaxRecruitment, {
        type: 'getRecruitmentDetailsByID',
        id: id,
    }, function (rs) {
        rs = html_entity_decode(rs);
        var res = rs.data.details;
        if (rs.data.result != '0') {
            var sType = 'foreign';

            if (type_id == '1') {

                // for local only
                sType = 'local';

                // for foreign only 
                $('.emp-' + sType + '-country_id').val(res.country_id);

                // for region id 
                $('.emp-local_agency_region').val(res.region_id).change();

                // set time for half second 
                setTimeout(function () {
                    $('.emp-local_agency_province').val(res.province_id).change();
                }, 500);

                $('.emp-local-recruitment_agency_name').attr('rectid', res.recruitment_agency_id);
                $('#btn-save-local-rect').attr('rectid', res.recruitment_agency_id);

            } else {
                // for foreign only 
                $('.emp-' + sType + '-country_id').val(res.country_id);
                $('.emp-foreign-recruitment_agency_name').attr('rectid', res.recruitment_agency_id);
                $('#btn-save-foreign-rect').attr('rectid', res.recruitment_agency_id);
            }

            // agencies information 
            $('.emp-' + sType + '-recruitment_agency_name ').val(res.recruitment_agency_name);
            $('.emp-' + sType + '-recruitment_agency_address').val(res.recruitment_agency_address);
            $('.emp-' + sType + '-recruitment_agency_email ').val(res.recruitment_agency_email);
            $('.emp-' + sType + '-recruitment_agency_tel_no').val(res.recruitment_agency_tel_no);
            $('.emp-' + sType + '-recruitment_agency_fax_no').val(res.recruitment_agency_fax_no);
            $('.emp-' + sType + '-recruitment_agency_website ').val(res.recruitment_agency_website);


            // owners information 
            if (res.owner_details !== "") {
                $('.emp-' + sType + '_agency_owner_name').val(res.owner_details.recruitment_agency_info_name);
                $('.emp-' + sType + '_agency_owner_address').val(res.owner_details.recruitment_agency_info_address);
                $('.emp-' + sType + '_agency_owner_contact').val(res.owner_details.recruitment_agency_info_contact_number);

                $('.emp-' + sType + '-recruitment_agency_owner_name ').val(res.owner_details.recruitment_agency_info_name);
                $('.emp-' + sType + '-recruitment_agency_owner_address').val(res.owner_details.recruitment_agency_info_address);
                $('.emp-' + sType + '-recruitment_agency_owner_contact').val(res.owner_details.recruitment_agency_info_contact_number);
            }

            //agent information 
            if (res.agent_details !== "") {
                $('.emp-' + sType + '_agency_agent_name').val(res.agent_details.recruitment_agency_info_name);
                $('.emp-' + sType + '_agency_agent_address').val(res.agent_details.recruitment_agency_info_address);
                $('.emp-' + sType + '_agency_agent_contact').val(res.agent_details.recruitment_agency_info_contact_number);

                $('.emp-' + sType + '-recruitment_agency_agent_name').val(res.agent_details.recruitment_agency_info_name);
                $('.emp-' + sType + '-recruitment_agency_agent_address').val(res.agent_details.recruitment_agency_info_address);
                $('.emp-' + sType + '-recruitment_agency_agent_contact').val(res.agent_details.recruitment_agency_info_contact_number);
            }

            // representative information 
            if (res.rep_details !== "") {
                $('.emp-' + sType + '_agency_rep_name').val(res.rep_details.recruitment_agency_info_name);
                $('.emp-' + sType + '_agency_rep_address').val(res.rep_details.recruitment_agency_info_address);
                $('.emp-' + sType + '_agency_rep_contact').val(res.rep_details.recruitment_agency_info_contact_number);

                $('.emp-' + sType + '-recruitment_agency_rep_name').val(res.rep_details.recruitment_agency_info_name);
                $('.emp-' + sType + '-recruitment_agency_rep_address').val(res.rep_details.recruitment_agency_info_address);
                $('.emp-' + sType + '-recruitment_agency_rep_contact').val(res.rep_details.recruitment_agency_info_contact_number);
            }
        }

    }, 'json');
}

function getEmployerInformation() {
    $.post(sAjaxCase, {
        type: "getEmployerInformation",
        case_id: $('#case_id').val(),
    }, function (rset) {
        rs = rset.data;
        rs = html_entity_decode(rs);

        $('.emp-employer-employer_name').val(rs.employer_name);
        $('.emp-employer-employer_name').attr('data-empid', rs.employer_id);
        $('.emp-employer-employer_representative_name').val(rs.employer_representative_name);
        $('.emp-employer-employer_tel_no').val(rs.employer_tel_no);
        $('.emp-employer-employer_email').val(rs.employer_email);
        $('#emp-sel-eer-country').val(rs.employer_country_id).change();
        $('.emp-employer-employer_city').val(rs.employer_city);
        $('.emp-employer-employer_full_addres').val(rs.employer_full_address);
        $('.emp-employer-employer_full_address').val(rs.employer_full_address);
        $('#btn-save-employer').attr('dataempid', rs.employer_id);

        aInitialValues["employmer_details"] = getFormValues('frm-employer_details');
    }, 'json');
}

function getEmploymentInformation(is_contract) {
    $.post(sAjaxCase, {
        type: "getEmploymentInformation",
        case_id: $('#case_id').val(),
        is_contract: is_contract,
    }, function (rset) {
        var rs = rset.data;
        rs = html_entity_decode(rs);

        if (is_contract == "1") {
            loadEmployment_contract(rs);
            // loadLocal_Employment(rs);
            aInitialValues["employment_actual_work"] = getFormValues('frm-emp-contract');
            aInitialValues["employmer_details"] = getFormValues('form-update_employment_info_local');
        } else {
            loadEmployment_actual(rs);
            aInitialValues["employment_diff_contract"] = getFormValues('frm-emp-noncontract');
        }
    }, 'json');
}


function loadEmployment_contract(rs) {

    if (rs.case_victim_employment_is_documented == "1") {
        $('#rdo_documented_employment').attr('checked', true);
        $('#rdo_undocumented_employment').attr('checked', false);
    } else {
        $('#rdo_documented_employment').attr('checked', false);
        $('#rdo_undocumented_employment').attr('checked', true);
    }

    if (rs.country_id >= 1) {
        $('#emp-sel-eet-country').val(rs.country_id).change();
    }
    $('.emp-case_victim_employment_city').val(rs.case_victim_employment_city);
    $('.emp-case_victim_employment_details_salary_foreign_iso').val(rs.case_victim_employment_details_salary_foreign_iso);
    $('.emp-case_victim_employment_details_salary_in_foreign').val(rs.case_victim_employment_details_salary_in_foreign);
    $('.emp-case_victim_employment_details_salary_in_local').val(rs.case_victim_employment_details_salary_in_local);
    $('.emp-case_victim_employment_details_job_title').val(rs.case_victim_employment_details_job_title);
    $('.emp-case_victim_employment_details_working_days').val(rs.case_victim_employment_details_working_days);
    $('.emp-case_victim_employment_details_working_hours').val(rs.case_victim_employment_details_working_hours);

    $('.region_local_id, .a-vi-address_region').val(rs.employee_local_region);
    $('.a-vi-address_region').change(function() {
        $('.region_local_id').val($(this).val());
    });

    $('.province_local_id, .a-vi-address_province').attr("option","selected").val(rs.employee_local_province);
    $('.a-vi-address_province').change(function() {
        $('.province_local_id').val($(this).val());
    });

    $('.city_local_id, .a-vi-address_city').attr("option","selected").val(rs.employee_local_city);
    $('.a-vi-address_city').change(function() {
        $('.city_local_id').val($(this).val());
    });

    $('.barangay_local_id, .a-vi-address_barangay').attr("option","selected").val(rs.employee_local_barangay);
    $('.a-vi-address_barangay').change(function() {
        $('.barangay_local_id').val($(this).val());
    });

    var employement = rs.employee_local_employed_or_unemployed;
    $('.fetch_employed').val();
    if (employement === "EMPLOYED") {
        $('#rdo-employed').prop('checked', true);
        $('.fetch_employed').val("0");
    } else {
        $('#rdo-unemployed').prop('checked', true);
        $('.fetch_employed').val("1");
    }



    $('.emp-type_of_employment').val(rs.employee_local_type_of_employment);
    $('.emp-type_of_child_cases').val(rs.employee_local_type_of_child_cases);
    $('.emp-act_age_started_working').val(rs.employee_local_age_started_working);
    $('.emp-act_salary_per_hour').val(rs.employee_local_salary_per_hour);
    $('.emp-act_reasons_for_employment').val(rs.employee_local_reason_for_employment);
    $('#btn-save-contract').attr('datacveid', rs.case_victim_employment_id);
    $('#btn-save-contract').attr('datacvedetid', rs.case_victim_employment_details_id);

}

function loadEmployment_actual(rs) {
    if (rs.case_victim_employment_is_documented == "1") {
        $('#rdo_documented_employment').attr('checked', true);
        $('#rdo_undocumented_employment').attr('checked', false);
    } else {
        $('#rdo_documented_employment').attr('checked', false);
        $('#rdo_undocumented_employment').attr('checked', true);
    }
    if (rs.country_id >= 1) {
        $('#emp-sel-actual-country').val(rs.country_id).change();
    }
    $('.emp-act-case_victim_employment_city').val(rs.case_victim_employment_city);
    $('.emp-act-case_victim_employment_details_salary_foreign_iso').val(rs.case_victim_employment_details_salary_foreign_iso);
    $('.emp-act-case_victim_employment_details_salary_in_foreign').val(rs.case_victim_employment_details_salary_in_foreign);
    $('.emp-act-case_victim_employment_details_salary_in_local').val(rs.case_victim_employment_details_salary_in_local);
    $('.emp-act-case_victim_employment_details_job_title').val(rs.case_victim_employment_details_job_title);
    $('.emp-act-case_victim_employment_details_working_days').val(rs.case_victim_employment_details_working_days);
    $('.emp-act-case_victim_employment_details_working_hours').val(rs.case_victim_employment_details_working_hours);
    $('#btn-save-contract-diff').attr('datacveid', rs.case_victim_employment_id);
    $('#btn-save-contract-diff').attr('datacvedetid', rs.case_victim_employment_details_id);
}

function  disabledInputs() {
    $("#frm-emp-contract :input").attr("disabled", true);
    $("#frm-emp-noncontract :input").attr("disabled", true);
    $(".div-emp :input").attr("disabled", true);
    $("#frm-local-rect :input").attr("disabled", true);
    $("#frm-foreign-rect :input").attr("disabled", true);

    $('#btn-save-contract').addClass("hide");
    $('#btn-save-contract-diff').addClass("hide");
    $('#btn-save-employer').addClass("hide");
    $('#btn-save-local-rect').addClass("hide");
    $('#btn-save-foreign-rect').addClass("hide");

    $('#btn-update-contract').text("Manage");
    $('#btn-update-contract-diff').text("Manage");
    $('#btn-update-employer').text("Manage");
    $('#btn-update-local-rect').text("Manage");
    $('#btn-update-foreign-rect').text("Manage");
}

function removeVictimTransitInfoById(id) {
    icmsMessage({
        type: "msgPreloader",
        body: "Removing... Please wait!",
        visible: true
    });

    $.post(sAjaxCaseDetails, {
        type: "removeVictimTransitInfoById",
        case_victim_transit_id: id,
        case_id: $('#case_id').val(),
    }, function (rs) {

        if (rs.data.flag == 1) {
            getTransitList();
            notifyChangesInReport();
        }

    }, 'json');
}

function updateVictimTransitInfoById() {

    icmsMessage({
        type: "msgPreloader",
        body: "Saving... Please wait!",
        visible: true
    });
    $.post(sAjaxCaseDetails, {
        type: "updateVictimTransitInfoById",
        case_id: $('#case_id').val(),
        transid: $('.emp-btn-transit-save').attr("transid"),
        case_victim_transit_departure_country: $('.u-emp-case_victim_transit_departure_country').val(),
        case_victim_transit_departure_city: $('.u-emp-case_victim_transit_departure_state').val(),
        case_victim_transit_departure_date: $('.u-emp-case_victim_transit_departure_date').val(),
        case_victim_transit_arrival_date: $('.u-emp-case_victim_transit_arrival_date').val(),
        case_victim_transit_remarks: $('.u-emp-case_victim_transit_remarks').val()
    }, function (rs) {
        getTransitList();
        $('#update-modal-transit-country').modal('hide');

        notifyChangesInReport();

    }, 'json');
}

function getCountryISO() {
    $.post(sAjaxGlobalData, {
        type: "getCountryISO"
    }, function (rs) {
        l = "<option value='' selected >Select Country</option>";
        $.each(rs.data.country, function (key, val) {
            l += "<option value='" + val.country_id + "' data-currency='" + val.currency_iso + "' data-name='" + val.country_name + "'>" + val.country_name + " </option>";
        });
        $('#emp-sel-eet-country').html(l);
        $('#emp-sel-eer-country').html(l);
        $('.emp-foreign-country_id').html(l);
        $('#emp-sel-actual-country').html(l);
        $('#emp-sel-country-dest').html(l);
        $('#emp-sel-Transit-country').html(l);
        $('#up-emp-sel-Transit-country').html(l);
        $('.u-emp-case_victim_transit_departure_country').html(l);

        var iso = l = "<option value='' selected >Select Currency</option>";
        $.each(rs.data.currency, function (key, val) {
            iso += "<option value='" + val.currency_iso + "'>" + val.currency_iso + " </option>";
        });
        $('#emp-sel-eet-currency').html(iso);
        $('#emp-sel-eer-currency').html(iso);
        $('#emp-sel-actual-currency').html(iso);

    }, 'json');
}

function getEmploymentType() {
    $.post(sAjaxGlobalData, {
        type: "getEmploymentType"
    }, function (rs) {
        l = "<option value='' selected >Select Employment</option>";
        $.each(rs.data, function (key, val) {
            l += "<option value='" + val.parameter_count_id + "' data-name='" + val.parameter_name + "'>" + val.parameter_name + " </option>";
        });
        $('#emp-sel-employment-type').html(l);
    }, 'json');
}

function getDepartureType() {
    $.post(sAjaxGlobalData, {
        type: "getDepartureType"
    }, function (rs) {
        l = "<option value='0' selected >Select Departure Type</option>";
        $.each(rs.data, function (key, val) {
            l += "<option value='" + val.parameter_count_id + "' data-name='" + val.parameter_name + "'>" + val.parameter_name + " </option>";
        });
        $('#emp-sel-departure').html(l);
    }, 'json');
}

function getPortOfExit() {
    $.post(sAjaxGlobalData, {
        type: "getPhilippinePort"
    }, function (rs) {
        l = "<option value='0' selected >Select Port</option>";
        $.each(rs.data, function (key, val) {
            var x = val.port_name;
            if (x) {
                if (x.toLowerCase() == "other") {
                    other = "<option value='" + val.port_id + "' data-name='" + val.port_name + "'>" + val.port_name + " </option>";
                } else {
                    l += "<option value='" + val.port_id + "' data-name='" + val.port_name + "'>" + val.port_name + " </option>";
                }
            }
        });
        $('#emp-sel-port_of_exit').html(l);
    }, 'json');
}

function getVisaCategory() {
    $.post(sAjaxGlobalData, {
        type: "getVisaCategory"
    }, function (rs) {
        l = "<option value='0' selected >Select Visa Category</option>";
        $.each(rs.data, function (key, val) {
            l += "<option value='" + val.parameter_count_id + "' data-name='" + val.parameter_name + "'>" + val.parameter_name + " </option>";
        });
        $('#emp-sel-visa').html(l);
    }, 'json');
}

function getGender() {
    $.post(sAjaxGlobalData, {
        type: "getSex"
    }, function (rs) {
        l = "<option value='0' selected >Select Sex</option>";
        $.each(rs.data, function (key, val) {
            l += "<option value='" + val.parameter_count_id + "' data-name='" + val.parameter_name + "'>" + val.parameter_name + " </option>";
        });

        $('#emp-sel-sex').html(l);
    }, 'json');
}

function getCvlStatus() {
    $.post(sAjaxGlobalData, {
        type: "getCivilStatus"
    }, function (rs) {
        l = "<option value='0' selected >Select Civil Status</option>";
        $.each(rs.data, function (key, val) {
            l += "<option value='" + val.parameter_count_id + "' data-name='" + val.parameter_name + "'>" + val.parameter_name + " </option>";
        });
        $('#emp-sel-civil').html(l);
    }, 'json');
}

function getProvinceList() {
    $.post(sAjaxGlobalData, {
        type: "getProvinces"
    }, function (rs) {

        l = "<option value='0' selected >Select Province</option>";
        $.each(rs.data, function (key, val) {
            l += "<option value='" + val.location_count_id + "' data-name='" + val.location_name + "'>" + val.location_name + " </option>";
        });
        $('#emp-sel-province').html(l);
    }, 'json');
}

function getCitiesByProvinceID(id) {
    $.post(sAjaxGlobalData, {
        type: "getCityByProvinceID",
        province_id: id
    }, function (rs) {
        l = "<option value='0' selected>Select City</option>";
        $.each(rs.data, function (key, val) {
            if (val.location_count_id) {
                l += "<option value='" + val.location_count_id + "' data-name='" + val.location_name + "'>" + val.location_name + " </option>";
            }
        });
        var id = $('#emp-sel-city').attr('data-id');
        $('#emp-sel-city').html(l);
        $('#emp-sel-city').val(id).change();
    }, 'json');
}

function getTransitList() {
    $.post(sAjaxCaseDetails, {
        type: "getTransitList",
        case_id: $('#case_id').val(),
    }, function (rs) {
        rs = html_entity_decode(rs);
        t = "";
        if (rs.data.length > 0) {
            $.each(rs.data, function (key, val) {
                t += '<tr data-remarks="' + val.case_victim_transit_remarks + '">';
                t += '<td data-country-id="' + val.case_victim_transit_departure_country + '">' + val.country + '</td>';
                t += '<td>' + val.case_victim_transit_departure_city + '</td>';
                t += '<td>' + val.case_victim_transit_departure_date + '</td>';
                t += '<td>' + val.case_victim_transit_arrival_date + '</td>';
                t += '<td> <div class="btn-group ellipse-action" data-id="vi-address_info_list2' + val.case_victim_transit_id + '" data-tab="">';
                t += '<a class="a-ellipse a-ellipse-vi-address_info_list2' + val.case_victim_transit_id + ' " >  <i class="fa fa-ellipsis-v" aria-hidden="true"></i> </a>';
                t += '<div class="action-menu" id="vi-address_info_list2' + val.case_victim_transit_id + '">';
                t += '<a class="dropdown-item disabled action-title" href="#">Select Action</a>';
                t += '<a class="dropdown-item up-victim_transit_info" data-id="' + val.case_victim_transit_id + '" >Update</a>';
                t += '<a class="dropdown-item rm-victim_transit_info" data-id="' + val.case_victim_transit_id + '" >Remove</a>';
                t += '</div>';
                t += '</div> </td>';
                t += '</tr>';
            });

            parseInt(rs.data.length) >= 10 ? $('.btn-add_layover').prop('disabled', true) : $('.btn-add_layover').prop('disabled', false);

        } else {
            t += '<tr>';
            t += '<td colspan="5" class="text-center">No transit info added to list.</td>';
            t += '</tr>';
        }

        $('.tbl-transit-list').html(t);

    }, 'json');
}

function storeEmploymentDetails() {

    //store victim employment information
    var victim_employment_info = {
        'is_documented': $('.emp-is_documented').prop("checked"),
        'employment_type': $('.emp-employment_type').val(),
        'employment_type_value': $('.emp-employment_type option:selected').attr('data-name'),
        'country': $('.emp-country').val(),
        'city': $('.emp-city').val(),
        'currency': $('.emp-currency').val(),
        'salary': $('.emp-salary').val(),
        'salary_in_peso': $('.emp-salary_in_peso').val(),
        'position': $('.emp-position').val(),
        'days_of_work': $('.emp-days_of_work').val(),
        'working_hours': $('.emp-working_hours').val(),
        'act_country': $('.emp-act_country').val(),
        'act_city': $('.emp-act_city').val(),
        'act_currency': $('.emp-act_currency').val(),
        'act_salary': $('.emp-act_salary').val(),
        'act_salary_in_peso': $('.emp-act_salary_in_peso').val(),
        'act_position': $('.emp-act_position').val(),
        'act_days_of_work': $('.emp-act_days_of_work').val(),
        'act_working_hours': $('.emp-act_working_hours').val()
    };

    var victim_employer_details = {
        'employer_name': $('.emp-employer_name').val(),
        'employer_representative': $('.emp-employer_representative').val(),
        'employer_telephone': $('.emp-employer_telephone').val(),
        'employer_email': $('.emp-employer_email').val(),
        'employer_country': $('.emp-employer_country').val(),
        'employer_city': $('.emp-employer_city').val(),
        'employer_address': $('.emp-employer_address').val()
    };

    var victim_recruitment_details = {
        'local_agency_name': $('.emp-local_agency_name').val(),
        'local_agency_country': $('.emp-local_agency_country').val(),
        'local_agency_address': $('.emp-local_agency_address').val(),
        'local_agency_telephone': $('.emp-local_agency_telephone').val(),
        'local_agency_email': $('.emp-local_agency_email').val(),
        'local_agency_fax': $('.emp-local_agency_fax').val(),
        'local_agency_website': $('.emp-local_agency_website').val(),
        'local_agency_owner_name': $('.emp-local_agency_owner_name').val(),
        'local_agency_owner_address': $('.emp-local_agency_owner_address').val(),
        'local_agency_owner_contact': $('.emp-local_agency_owner_contact').val(),
        'foreign_agency_name': $('.emp-foreign_agency_name').val(),
        'foreign_agency_country': $('.emp-foreign_agency_country').val(),
        'foreign_agency_address': $('.emp-foreign_agency_address').val(),
        'foreign_agency_telephone': $('.emp-foreign_agency_telephone').val(),
        'foreign_agency_email': $('.emp-foreign_agency_email').val(),
        'foreign_agency_fax': $('.emp-foreign_agency_fax').val(),
        'foreign_agency_website': $('.emp-foreign_agency_website').val(),
        'foreign_agency_owner_name': $('.emp-foreign_agency_owner_name').val(),
        'foreign_agency_owner_address': $('.emp-foreign_agency_owner_address').val(),
        'foreign_agency_owner_contact': $('.emp-foreign_agency_owner_contact').val()
    };

    var victim_passport_details = {
        'passport_no': $('.emp-passport_no').val(),
        'passport_first_name': $('.emp-passport_first_name').val(),
        'passport_middle_name': $('.emp-passport_middle_name').val(),
        'passport_last_name': $('.emp-passport_last_name').val(),
        'passport_suffix': $('.emp-passport_suffix').val(),
        'passport_sex': $('.emp-passport_sex').val(),
        'passport_civil': $('.emp-passport_civil').val(),
        'passport_dob': $('.emp-passport_dob').val(),
        'passport_province': $('.emp-passport_province').val(),
        'passport_city': $('.emp-passport_city').val(),
        'passport_place_issue': $('.emp-passport_place_issue').val(),
        'passport_date_issued': $('.emp-passport_date_issued').val(),
        'passport_date_expired': $('.emp-passport_date_expired').val()
    };

    var victim_deployment_details = {
        'deployment_document_is_falsified': $('.emp-deployment_document_is_falsified').prop("checked"),
        'deployment_departure_type': $('.emp-deployment_departure_type').val(),
        'deployment_departure_type_value': $('.emp-deployment_departure_type option:selected').attr('data-name'),
        'deployment_escort_name': $('.emp-deployment_escort_name').val(),
        'deployment_escort_description': $('.emp-deployment_escort_description').val(),
        'port_of_exit': $('.emp-port_of_exit').val(),
        'port_of_exit_value': $('.emp-port_of_exit option:selected').attr('data-name'),
        'port_of_exit_description': $('.emp-port_of_exit_description').val(),
        'deployment_visa_category': $('.emp-deployment_visa_category').val(),
        'deployment_visa_category_value': $('.emp-deployment_visa_category option:selected').attr('data-name'),
        'deployment_country': $('.emp-deployment_country').val(),
        'deployment_country_value': $('.emp-deployment_country option:selected').attr('data-name'),
        'deployment_date': $('.emp-deployment_date').val(),
        'deployment_arrival_date': $('.emp-deployment_arrival_date').val()
    };

    _setStorageData(victim_employment_info, 'victim_employment_info');

    _setStorageData(victim_employer_details, 'victim_employer_details');

    _setStorageData(victim_recruitment_details, 'victim_recruitment_details');

    _setStorageData(victim_passport_details, 'victim_passport_details');

    _setStorageData(victim_deployment_details, 'victim_deployment_details');

    $('#case-details-tab1').trigger('click');

}

function getVictimEmploymentInfo() {

    var storages = ['victim_employment_info',
        'victim_employer_details',
        'victim_recruitment_details',
        'victim_passport_details',
        'victim_deployment_details'];

    $.each(storages, function (key, val) {
        var data = _getStorageData(val);

        $.each(data, function (key, val) {
            $(".emp-" + key).val(val);
        });

    });

    $('.emp-passport_province').change();
    $('.emp-deployment_departure_type').change();
    $('.emp-port_of_exit').change();

    var data = _getStorageData('victim_deployment_details');

    if (data.deployment_document_is_falsified) {
        $('.emp-deployment_document_is_falsified').click();
    }

    var data = _getStorageData('victim_employment_info');

    if (data.is_documented) {
        $('.emp-is_documented').click();
    }

}

function getEmployerByKeyword() {

    // remove attr 
    $('.emp-employer-employer_name').removeAttr('data-empid');
    $('#btn-save-employer').removeAttr('dataempid');

    // reset 
    $('.emp-employer-employer_representative_name').val('');
    $('.emp-employer-employer_tel_no').val('');
    $('.emp-employer-employer_email').val('');
    $('#emp-sel-eer-country').val('').change();
    $('.emp-employer-employer_city').val('');
    $('.emp-employer-employer_full_addres').val('');
    resetFormJQueryValidation('frm-employer_details');

    var keyword = $('.emp-employer-employer_name').val();
    $.post(sAjaxEmployer, {
        type: 'getEmployerByKeyword',
        keyword: keyword,
    }, function (rs) {
        rs = html_entity_decode(rs);
        if (rs.data.flag != '0') {
            $('#employer-search').show();
            var l = '';
            $.each(rs.data.list, function (key, val) {
                l += " <li class='list-group-item' data-id='" + val.employer_id + "'> " + val.employer_name + "</li>";
            });
            $('#employer-search').html(l);
        } else {
            $('#employer-search').hide();

        }
    }, 'json');
}

function getEmployerDetailsByID(id) {
    $('.emp-employer_name').attr('data-id', id);
    $.post(sAjaxEmployer, {
        type: 'getEmployerDetailsByID',
        employer_id: id,
    }, function (rs) {
        rs = html_entity_decode(rs);
        if (rs.data.result != '0') {
            var rs = rs.data.details;
            $('.emp-employer-employer_name').val(rs.employer_name);
            $('.emp-employer-employer_name').attr('data-empid', rs.employer_id);
            $('.emp-employer-employer_representative_name').val(rs.employer_representative_name);
            $('.emp-employer-employer_tel_no').val(rs.employer_tel_no);
            $('.emp-employer-employer_email').val(rs.employer_email);
            $('#emp-sel-eer-country').val(rs.employer_country_id).change();
            $('.emp-employer-employer_city').val(rs.employer_city);
            $('.emp-employer-employer_full_addres').val(rs.employer_full_address);
            $('.emp-employer-employer_full_address').val(rs.employer_full_address);
            $('#btn-save-employer').attr('dataempid', rs.employer_id);
        }
    }, 'json');
}

function getLocalRecruitmentByKeyword() {
    // remove attr 
    $('.emp-local-recruitment_agency_name').removeAttr('rectid');
    $('#btn-save-local-rect').removeAttr('rectid');
    $('#frm-local-rect :input:not(".ignore")').val('');
    $('.emp-local-country_id').val('173').change();
    var keyword = $('.emp-local-recruitment_agency_name').val();
    $.post(sAjaxRecruitment, {
        type: 'getLocalRecruitmentByKeyword',
        keyword: keyword,
    }, function (rs) {
        rs = html_entity_decode(rs);
        if (rs.data.flag != '0') {
            $('#ra-local-search').show();
            var l = '';
            $.each(rs.data.list, function (key, val) {
                l += " <li class='list-group-item' data-id='" + val.recruitment_agency_id + "'> " + val.recruitment_agency_name + "</li>";
            });
            $('#ra-local-search').html(l);
        } else {
            $('#ra-local-search').hide();
        }
    }, 'json');
}

function getForeignRecruitmentByKeyword() {
    // remove attr
    $('.emp-foreign-recruitment_agency_name').removeAttr('rectid');
    $('#btn-save-foreign-rect').removeAttr('rectid');
    $('#frm-foreign-rect :input:not(".ignore")').val('');
    var keyword = $('.emp-foreign-recruitment_agency_name').val();
    $.post(sAjaxRecruitment, {
        type: 'getForeignRecruitmentByKeyword',
        keyword: keyword,
    }, function (rs) {
        rs = html_entity_decode(rs);
        if (rs.data.flag != '0') {
            $('#ra-foreign-search').show();
            var l = '';
            $.each(rs.data.list, function (key, val) {
                l += " <li class='list-group-item' data-id='" + val.recruitment_agency_id + "'> " + val.recruitment_agency_name + "</li>";
            });
            $('#ra-foreign-search').html(l);
        } else {
            $('#ra-foreign-search').hide();
        }
    }, 'json');
}

$(document).ready(function () {

    // occupation list
    getActiveOccupations(1);
    
    $("#frm-passport :input").prop("disabled", true);

    $('.btn-add_layover').click(function () {
        $("#modal-transit-country").modal('show');
        resetFormById('form-add_layover_info');
    });

    // cancel modal 
    $('#modal-transit-country .btn-modal-cancel').click(function () {
        var sValues = getFormValues('form-add_layover_info');
        if (sValues != '0') {
            icmsMessage({
                type: "msgConfirmation",
                title: "Do you want to disregard your inputs.",
                body: "Click YES button if you wish to continue.",
                LblBtnConfirm: "Yes",
                onConfirm: function () {
                    $('#modal-transit-country').modal('hide');
                },
                onCancel: function () {
                    $('#modal-transit-country').modal('show');
                }
            });
        }
    });

    $('.tbl-transit-list').delegate('.rm-victim_transit_info', 'click', function () {
        var id = $(this).attr('data-id');

        icmsMessage({
            type: "msgConfirmation",
            title: "You are about to remove transit details",
            body: "Click remove button if you wish to continue.",
            LblBtnConfirm: "Remove",
            onConfirm: function () {
                removeVictimTransitInfoById(id);
            }
        });
    });

    $('.tbl-transit-list').delegate('.up-victim_transit_info', 'click', function () {
        var id = $(this).attr('data-id');
        $('.emp-btn-transit-save').attr("transid", id);
        getVictimTransitInfoById(id);
    });

    $('#form-add_layover_info').validate({
        rules: {
            country: {min: 1, required: true},
            emp_txt_tansit_arrival_date: {
                pastDateOptional: true,
            },
            emp_txt_tansit_depart_date: {
                pastDateOptional: true,
                checkDeploymentTransit: true
            }
        },
        messages: {
            country: 'This field is required'
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
                title: "You are about to add transit details ",
                onConfirm: function () {
                    addTransitDetails();
                },
                onShow: function () {
                    $('#modal-transit-country').modal('hide');
                },
                onCancel: function () {
                    $('#modal-transit-country').modal('show');
                }
            });
        }
    });


    $.validator.addMethod("checkDeploymentTransit", function (value, element) {
        var a = new Date(value);
        var b = new Date($(".modal.show .emp-txt-tansit-arrival-date").val());
        if (a >= b) {
            return true;
        }
        if (!value) {
            return true;
        }
    }, "Departure date cannot be less than arrival date");

    $('#form-update_layover_info').validate({
        rules: {
            country: {min: 1, required: true},
            emp_txt_tansit_arrival_date: {
                pastDateOptional: true,
            },
            emp_txt_tansit_depart_date: {
                pastDateOptional: true,
                checkDeploymentTransit: true
            }
        },
        messages: {
            country: 'This field is required'
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

            sCurrentVal = getFormValues('form-update_layover_info');
            if (sCurrentVal != aInitialValues["layover_details"]) {
                icmsMessage({
                    type: "msgConfirmation",
                    title: "You are about to update transit details ",
                    onConfirm: function () {
                        updateVictimTransitInfoById();
                    },
                    onShow: function () {
                        $('#update-modal-transit-country').modal('hide');
                    },
                    onCancel: function () {
                        $('#update-modal-transit-country').modal('show');
                    }
                });
            } else {

                icmsMessage({
                    type: "msgWarning",
                    body: "No changes has been made.",
                    onShow: function () {
                        $('#update-modal-transit-country').modal('hide');
                    },
                    onHide: function () {
                        $('#update-modal-transit-country').modal('show');
                    }
                });
            }

        }
    });


    // cancel update 
    $('#form-update_layover_info').delegate('.btn-modal-cancel', 'click', function () {

        // hide modal
        $('#update-modal-transit-country').modal('hide');

        sCurrentVal = getFormValues('form-update_layover_info');
        if (sCurrentVal != aInitialValues["layover_details"]) {
            icmsMessage({
                type: "msgConfirmation",
                title: "You made some changes. Do you want to disregard changes?",
                body: "Click yes button if you want to continue",
                LblBtnConfirm: "Yes",
                onConfirm: function () {
                    $('#update-modal-transit-country').modal('hide');
                },
                onCancel: function () {
                    $('#update-modal-transit-country').modal('show');
                }
            });
        }

    });

    $('#btn-update-contract').click(function () {
        var caption = $(this).text();
        if (caption.toLowerCase() == "manage") {
            disabledInputs();
            $('#sel_occupationsemp_case_victim_employment_details_job_title').hide();
            $("#sel_occupationsemp_case_victim_employment_details_job_title_chosen").show();
            
            $(this).text("Cancel");
            $('#btn-save-contract').removeClass("hide");
            $("#frm-emp-contract :input").attr("disabled", false);
        } else {
            sCurrent = getFormValues('frm-emp-contract');
            if (sCurrent != aInitialValues["employment_actual_work"]) {
                icmsMessage({
                    type: "msgConfirmation",
                    title: "You made some changes. Do you want to disregard changes?",
                    body: "Click yes button if you want to continue",
                    LblBtnConfirm: "Yes",
                    onConfirm: function () {
                        $('#sel_occupationsemp_case_victim_employment_details_job_title').show();
                        $("#sel_occupationsemp_case_victim_employment_details_job_title_chosen").hide();
                        disabledInputs();
                        removeErrorClass('frm-emp-contract');
                        getEmploymentInformation(1);
                    }
                });
            } else {
                $('#sel_occupationsemp_case_victim_employment_details_job_title').show();
                $("#sel_occupationsemp_case_victim_employment_details_job_title_chosen").hide();
                disabledInputs();
            }
        }
        $("#sel_occupationsemp_case_victim_employment_details_job_title").trigger("chosen:updated");
    });

    $('#btn-update-contract-diff').click(function () {
        var caption = $(this).text();
        if (caption.toLowerCase() == "manage") {
            disabledInputs();
            $('#sel_emp_act_case_victim_employment_details_job_title').hide();
            $("#sel_emp_act_case_victim_employment_details_job_title_chosen").show();

            $(this).text("Cancel");
            $('#btn-save-contract-diff').removeClass("hide");
            $("#frm-emp-noncontract :input").attr("disabled", false);
            
        } else {
            sCurrent = getFormValues('frm-emp-noncontract');
            if (sCurrent != aInitialValues["employment_diff_contract"]) {
                icmsMessage({
                    type: "msgConfirmation",
                    title: "You made some changes. Do you want to disregard changes?",
                    body: "Click yes button if you want to continue",
                    LblBtnConfirm: "Yes",
                    onConfirm: function () {
                        disabledInputs();
                        removeErrorClass('frm-emp-noncontract');
                        getEmploymentInformation(0);
                    }
                });
                $('#sel_emp_act_case_victim_employment_details_job_title').show();
                $("#sel_emp_act_case_victim_employment_details_job_title_chosen").hide();
            } else {
                $('#sel_emp_act_case_victim_employment_details_job_title').show();
                $("#sel_emp_act_case_victim_employment_details_job_title_chosen").hide();
                disabledInputs();
            }
        }
        $("#sel_emp_act_case_victim_employment_details_job_title").trigger("chosen:updated");
    });

    $('#btn-update-employer').click(function () {
        var caption = $(this).text();
        var item = $('.emp-employer-employer_name').val();
        if (caption.toLowerCase() == "manage") {
            disabledInputs();
            $(this).text("Cancel");
            $('#btn-save-employer').removeClass("hide");
            $(".div-emp :input").attr("disabled", false);

            if (item.length > 1) {
                $('.emp-employer-change_emp').show();
                $(".emp-employer-employer_name").attr("disabled", true);
            } else {
                $('.emp-employer-change_emp').hide();
                $(".emp-employer-employer_name").attr("disabled", false);
            }

        } else {
            sCurrent = getFormValues('frm-employer_details');
            if (sCurrent != aInitialValues["employmer_details"]) {
                icmsMessage({
                    type: "msgConfirmation",
                    title: "You made some changes. Do you want to disregard changes?",
                    body: "Click yes button if you want to continue",
                    LblBtnConfirm: "Yes",
                    onConfirm: function () {
                        $('#frm-employer_details :input').attr("disabled", true);
                        removeErrorClass('frm-employer_details');
                        disabledInputs();
                        getEmployerInformation();
                        $('.emp-employer-change_emp').hide();
                    }
                });
            } else {
                disabledInputs();
                $('.emp-employer-change_emp').hide();
            }
        }
    });

    $('.emp-employer-change_emp').click(function () {
        $('.emp-employer-employer_name').val('');
        $("#frm-employer_details")[0].reset();
        resetFormJQueryValidation('frm-employer_details');
        $('.emp-employer-employer_name').removeAttr('data-empid');
        $('#btn-save-employer').removeAttr('dataempid');
        $('#frm-employer_details :input').attr("disabled", true);
        $(".emp-employer-employer_name").attr("disabled", false);
    });

    // for searching
    $('.emp-employer-employer_name').on('keyup', function (e) {
        var keyword = $(this).val();
        setTimeout(function () {
            if (keyword.length) {
                getEmployerByKeyword();
            }
        }, 1000);
    });

    // select employer list  
    $('#employer-search').delegate('.list-group-item', 'click', function () {
        var id = $(this).attr('data-id');
        getEmployerDetailsByID(id);
    });

    // click change local rect 
    $('.emp-localrec-change').click(function () {
        $('.emp-local-recruitment_agency_name').val('');
        $("#frm-local-rect")[0].reset();
        resetFormJQueryValidation('frm-local-rect');

        $('#btn-save-local-rect').removeAttr('rectid');
        $('.emp-local-recruitment_agency_name').removeAttr('rectid');

        $('#frm-local-rect :input').attr("disabled", true);
        $(".emp-local-recruitment_agency_name").attr("disabled", false);

    });


    // click update local rect 
    $('#btn-update-local-rect').click(function () {
        var caption = $(this).text();
        var item = $('.emp-local-recruitment_agency_name').val();

        if (caption.toLowerCase() == "manage") {
            disabledInputs();
            $(this).text("Cancel");
            $('#btn-save-local-rect').removeClass("hide");
            $("#frm-local-rect :input").attr("disabled", false);
            $(".emp-local-recruitment_agency_name").attr("disabled", true);

            if (item.length > 1) {
                $('.emp-localrec-change').show();
                $('.emp-local-recruitment_agency_name').attr("disabled", true);
            } else {
                $('.emp-localrec-change').hide();
                $('.emp-local-recruitment_agency_name').attr("disabled", false);
            }

        } else {
            sCurrent = getFormValues('frm-local-rect');
            if (sCurrent != aInitialValues["local_rec_details"]) {
                icmsMessage({
                    type: "msgConfirmation",
                    title: "You made some changes. Do you want to disregard changes?",
                    body: "Click yes button if you want to continue",
                    LblBtnConfirm: "Yes",
                    onConfirm: function () {
                        $('#frm-local-rect :input').attr("disabled", true);
                        $(".emp-local-recruitment_agency_name").attr("disabled", true);

                        removeErrorClass('frm-local-rect');
                        $("#frm-local-rect")[0].reset();
                        $('.emp-local_agency_province').html('');

                        disabledInputs();
                        getRecruitmentInformation(1);
                        $('.emp-localrec-change').hide();
                    }
                });
            } else {
                disabledInputs();
                $('.emp-localrec-change').hide();
            }
        }

    });

    // for search local recruitment 
    $('.emp-local-recruitment_agency_name').on('keyup', function (e) {
        var keyword = $(this).val();
        setTimeout(function () {
            if (keyword.length) {
                getLocalRecruitmentByKeyword();
            }
        }, 1000);
    });

    // select local list list 
    $('#ra-local-search').delegate('.list-group-item', 'click', function () {
        var id = $(this).attr('data-id');
        getRecruitmentDetailsByID(id, 1);
    });

    $('.emp-foreignrec-change').click(function () {
        $('.emp-foreign-recruitment_agency_name').val('');
        $("#frm-foreign-rect")[0].reset();
        resetFormJQueryValidation('frm-foreign-rect');
        $('#btn-save-foreign-rect').removeAttr('rectid');
        $('.emp-foreign-recruitment_agency_name').removeAttr('rectid');
        $('#frm-foreign-rect :input:not(".ignore")').attr("disabled", true);
        $('.emp-foreign-recruitment_agency_name').attr("disabled", false);
    });

    $('#btn-update-foreign-rect').click(function () {
        var caption = $(this).text();
        var item = $('.emp-foreign-recruitment_agency_name').val();

        if (caption.toLowerCase() == "manage") {
            disabledInputs();
            $(this).text("Cancel");
            $('#btn-save-foreign-rect').removeClass("hide");
            $("#frm-foreign-rect :input:not('.ignore')").attr("disabled", false);

            if (item.length > 1) {
                $('.emp-foreignrec-change').show();
                $('.emp-foreign-recruitment_agency_name').attr("disabled", true);
            } else {
                $('.emp-foreignrec-change').hide();
                $('.emp-foreign-recruitment_agency_name').attr("disabled", false);
            }

        } else {
            sCurrent = getFormValues('frm-foreign-rect');
            if (sCurrent != aInitialValues["foreign_rec_details"]) {
                icmsMessage({
                    type: "msgConfirmation",
                    title: "You made some changes. Do you want to disregard changes?",
                    body: "Click yes button if you want to continue",
                    LblBtnConfirm: "Yes",
                    onConfirm: function () {
                        $('#frm-foreign-rect :input').attr("disabled", true);
                        removeErrorClass('frm-foreign-rectt');
                        $("#frm-foreign-rect")[0].reset();
                        disabledInputs();
                        getRecruitmentInformation(0);
                        $('.emp-foreignrec-change').hide();
                    }
                });
            } else {
                $('.emp-foreignrec-change').hide();
                disabledInputs();
            }

        }
    });

    $('#frm-emp-contract').validate({
        rules: {
            emp_sel_eet_country : {required: true}
        },
        messages: {},
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

            sCurrent = getFormValues('frm-emp-contract');

            if (sCurrent != aInitialValues["employment_actual_work"]) {
                icmsMessage({
                    type: "msgConfirmation",
                    title: "You are about to update employment details (Employment Details Based on Victim’s contract) ",
                    onConfirm: function () {
                        icmsMessage({
                            type: "msgPreloader",
                            body: "Saving... Please wait!",
                            visible: true
                        });

                        var is_documented = $("input[name='rdo_doc_employment']:checked").val();
                        var country_id = $('#emp-sel-eet-country').val();
                        var city = $('.emp-case_victim_employment_city').val();
                        var foreign_iso = $('.emp-case_victim_employment_details_salary_foreign_iso').val();
                        var salary_foreign = $('.emp-case_victim_employment_details_salary_in_foreign').val();
                        var salary_local = $('.emp-case_victim_employment_details_salary_in_local').val();
                        var jobtitle = $('.emp-case_victim_employment_details_job_title').val();
                        var working_days = $('.emp-case_victim_employment_details_working_days').val();
                        var working_hours = $('.emp-case_victim_employment_details_working_hours').val();
                        var type_employment_local = $('.emp-type_of_employment').val();
                        var type_child_case_local = $('.emp-type_of_child_cases').val();
                        var region_local = $('.region_local_id').val();
                        var province_local = $('.province_local_id').val();
                        var city_local = $('.city_local_id').val();
                        var barangay_local = $('.barangay_local_id').val();
                        var age_started_working_local = $('.emp-act_age_started_working').val();
                        var salary_per_hour_local = $('.emp-act_salary_per_hour').val();
                        var reasons_for_employment_local = $('.emp-act_reasons_for_employment').val();
                        var employee_local_employed_or_unemployed = $('.fetch_employed').val() === "0" ? "EMPLOYED" : "UNEMPLOYED";
                        var datacveid = $('#btn-save-contract').attr('datacveid');
                        var datacvedetid = $('#btn-save-contract').attr('datacvedetid');
                        $.post(sAjaxCase, {
                            type: "setCaseVictimEmploymentDetails",
                            case_id: $('#case_id').val(),
                            is_documented: is_documented,
                            country_id: country_id,
                            city: city,
                            foreign_iso: foreign_iso,
                            salary_foreign: salary_foreign,
                            salary_local: salary_local,
                            jobtitle: jobtitle,
                            working_days: working_days,
                            working_hours: working_hours,
                            type_employment_local:type_employment_local,
                            type_child_case_local:type_child_case_local,
                            region_local:region_local,
                            province_local:province_local,
                            city_local:city_local,
                            barangay_local:barangay_local,
                            age_started_working_local: age_started_working_local,
                            salary_per_hour_local:salary_per_hour_local,
                            reasons_for_employment_local:reasons_for_employment_local,
                            employee_local_employed_or_unemployed:employee_local_employed_or_unemployed,
                            datacveid: datacveid,
                            datacvedetid: datacvedetid,
                        }, function (rs) {
                            getEmploymentInformation(1);
                            disabledInputs();
                            notifyChangesInReport();
                            $('#sel_occupationsemp_case_victim_employment_details_job_title').show();
                            $("#sel_occupationsemp_case_victim_employment_details_job_title_chosen").hide();
                        }, 'json');
                    }
                });
            } else {
                icmsMessage({
                    type: "msgWarning",
                    body: "No changes has been made.",
                });
            }
        }
    });

    $("#btn-save-contract").click(function () {
        $('#frm-emp-contract').submit();
    });


        // local start 
        $('#form-update_employment_info_local').validate({
            rules: {
                emp_sel_eet_country : {required: true}
            },
            messages: {},
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
    
                sCurrent = getFormValues('form-update_employment_info_local');
    
                if (sCurrent != aInitialValues["employment_actual_work"]) {
                    icmsMessage({
                        type: "msgConfirmation",
                        title: "You are about to update local employment details (Employment Details Based on Victim’s contract) ",
                        onConfirm: function () {
                            icmsMessage({
                                type: "msgPreloader",
                                body: "Saving... Please wait!",
                                visible: true
                            });
    
                            var is_documented = $("input[name='rdo_doc_employment']:checked").val();
                            var country_id = $('#emp-sel-eet-country').val();
                            var city = $('.emp-case_victim_employment_city').val();
                            var foreign_iso = $('.emp-case_victim_employment_details_salary_foreign_iso').val();
                            var salary_foreign = $('.emp-case_victim_employment_details_salary_in_foreign').val();
                            var salary_local = $('.emp-case_victim_employment_details_salary_in_local').val();
                            var jobtitle = $('.emp-case_victim_employment_details_job_title').val();
                            var working_days = $('.emp-case_victim_employment_details_working_days').val();
                            var working_hours = $('.emp-case_victim_employment_details_working_hours').val();
                            var type_employment_local = $('.emp-type_of_employment').val();
                            var type_child_case_local = $('.emp-type_of_child_cases').val();
                            var region_local = $('.region_local_id').val();
                            var province_local = $('.province_local_id').val();
                            var city_local = $('.city_local_id').val();
                            var barangay_local = $('.barangay_local_id').val();
                            var age_started_working_local = $('.emp-act_age_started_working').val();
                            var salary_per_hour_local = $('.emp-act_salary_per_hour').val();
                            var reasons_for_employment_local = $('.emp-act_reasons_for_employment').val();
                            var employee_local_employed_or_unemployed = $('.fetch_employed').val() === "0" ? "EMPLOYED" : "UNEMPLOYED";
                            var datacveid = $('#btn-save-contract').attr('datacveid');
                            var datacvedetid = $('#btn-save-contract').attr('datacvedetid');
                            $.post(sAjaxCase, {
                                type: "setCaseVictimEmploymentDetails",
                                case_id: $('#case_id').val(),
                                is_documented: is_documented,
                                country_id: country_id,
                                city: city,
                                foreign_iso: foreign_iso,
                                salary_foreign: salary_foreign,
                                salary_local: salary_local,
                                jobtitle: jobtitle,
                                working_days: working_days,
                                working_hours: working_hours,
                                type_employment_local:type_employment_local,
                                type_child_case_local:type_child_case_local,
                                region_local:region_local,
                                province_local:province_local,
                                city_local:city_local,
                                barangay_local:barangay_local,
                                age_started_working_local: age_started_working_local,
                                salary_per_hour_local:salary_per_hour_local,
                                reasons_for_employment_local:reasons_for_employment_local,
                                employee_local_employed_or_unemployed:employee_local_employed_or_unemployed,
                                datacveid: datacveid,
                                datacvedetid: datacvedetid,
                            }, function (rs) {
                                getEmploymentInformation(1);
                                disabledInputs();
                                notifyChangesInReport();
                                $('#sel_occupationsemp_case_victim_employment_details_job_title').show();
                                $("#sel_occupationsemp_case_victim_employment_details_job_title_chosen").hide();
                            }, 'json');
                        }
                    });
                } else {
                    icmsMessage({
                        type: "msgWarning",
                        body: "No changes has been made.",
                    });
                }
            }
        });
    
        $("#btn-save-local_employer").click(function () {
            $('#form-update_employment_info_local').submit();
        });

        // end

    $('#frm-emp-noncontract').validate({
        rules: {},
        messages: {},
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

            sCurrent = getFormValues('frm-emp-noncontract');

            if (sCurrent != aInitialValues["employment_diff_contract"]) {
                icmsMessage({
                    type: "msgConfirmation",
                    title: "You are about to update employment details (Different from Victim’s contract) ",
                    onConfirm: function () {
                        icmsMessage({
                            type: "msgPreloader",
                            body: "Saving... Please wait!",
                            visible: true
                        });

                        var is_documented = $("input[name='rdo_doc_employment']:checked").val();
                        var country_id = $('#emp-sel-actual-country').val();
                        var city = $('.emp-act-case_victim_employment_city').val();
                        var foreign_iso = $('.emp-act-case_victim_employment_details_salary_foreign_iso').val();
                        var salary_foreign = $('.emp-act-case_victim_employment_details_salary_in_foreign').val();
                        var salary_local = $('.emp-act-case_victim_employment_details_salary_in_local').val();
                        var jobtitle = $('.emp-act-case_victim_employment_details_job_title').val();
                        var working_days = $('.emp-act-case_victim_employment_details_working_days').val();
                        var working_hours = $('.emp-act-case_victim_employment_details_working_hours').val();
                        var datacveid = $('#btn-save-contract-diff').attr('datacveid');
                        var datacvedetid = $('#btn-save-contract-diff').attr('datacvedetid');
                        $.post(sAjaxCase, {
                            type: "setCaseVictimEmploymentDetails",
                            case_id: $('#case_id').val(),
                            is_documented: is_documented,
                            country_id: country_id,
                            city: city,
                            foreign_iso: foreign_iso,
                            salary_foreign: salary_foreign,
                            salary_local: salary_local,
                            jobtitle: jobtitle,
                            working_days: working_days,
                            working_hours: working_hours,
                            datacveid: datacveid,
                            datacvedetid: datacvedetid,
                        }, function (rs) {
                            disabledInputs();
                            notifyChangesInReport();
                            getEmploymentInformation(0);
                            $('#sel_emp_act_case_victim_employment_details_job_title').show();
                            $("#sel_emp_act_case_victim_employment_details_job_title_chosen").hide();
                        }, 'json');
                    }
                });
            } else {
                icmsMessage({
                    type: "msgWarning",
                    body: "No changes has been made.",
                });
            }
        }
    });

    $("#btn-save-contract-diff").click(function () {
        $('#frm-emp-noncontract').submit();
    });

    $('.emp-local_agency_region').change(function () {
        var region_id = $(this).val();
        getProvincesByRegionId(region_id);
    });

    $('#employment_details_tab').click(function () {
        if($(this).attr('data-choosen') == 0){
            $(this).attr('data-choosen', 1);
              // based on contract 
            setTimeout(function () {
                $('#sel_occupationsemp_case_victim_employment_details_job_title').chosen();
                $('#sel_occupationsemp_case_victim_employment_details_job_title').removeAttr('style'); 
                $('#sel_occupationsemp_case_victim_employment_details_job_title').attr('disabled','disabled');
                $("#sel_occupationsemp_case_victim_employment_details_job_title_chosen").removeAttr('style');
                $("#sel_occupationsemp_case_victim_employment_details_job_title_chosen").addClass('w-100');
                $("#sel_occupationsemp_case_victim_employment_details_job_title_chosen").hide();
            }, 300);
            // not based on contract 
            setTimeout(function () {
                $('#sel_emp_act_case_victim_employment_details_job_title').chosen();
                $('#sel_emp_act_case_victim_employment_details_job_title').removeAttr('style'); 
                $('#sel_emp_act_case_victim_employment_details_job_title').attr('disabled','disabled');
                $("#sel_emp_act_case_victim_employment_details_job_title_chosen").removeAttr('style');
                $("#sel_emp_act_case_victim_employment_details_job_title_chosen").addClass('w-100');
                $("#sel_emp_act_case_victim_employment_details_job_title_chosen").hide();
            }, 300);
        }
        aInitialValues['employment_is_documented'] = $("input[name='rdo_doc_employment']:checked").val();
    });

    $('#frm-employment_documented .rdo_de').click(function () {
        var x = $(this).val();

        if (x != aInitialValues['employment_is_documented']) {
            icmsMessage({
                type: "msgConfirmation",
                title: "You are about to update employment details",
                onConfirm: function () {

                    icmsMessage({
                        type: "msgPreloader",
                        body: "Saving... Please wait!",
                        visible: true
                    });

                    var is_documented = $("input[name='rdo_doc_employment']:checked").val();
                    var country_id = $('#emp-sel-eet-country').val();
                    var city = $('.emp-case_victim_employment_city').val();
                    var foreign_iso = $('.emp-case_victim_employment_details_salary_foreign_iso').val();
                    var salary_foreign = $('.emp-case_victim_employment_details_salary_in_foreign').val();
                    var salary_local = $('.emp-case_victim_employment_details_salary_in_local').val();
                    var jobtitle = $('.emp-case_victim_employment_details_job_title').val();
                    var working_days = $('.emp-case_victim_employment_details_working_days').val();
                    var working_hours = $('.emp-case_victim_employment_details_working_hours').val();
                    var datacveid = $('#btn-save-contract').attr('datacveid');
                    var datacvedetid = $('#btn-save-contract').attr('datacvedetid');

                    $.post(sAjaxCase, {
                        type: "setCaseVictimEmploymentDetails",
                        case_id: $('#case_id').val(),
                        is_documented: is_documented,
                        country_id: country_id,
                        city: city,
                        foreign_iso: foreign_iso,
                        salary_foreign: salary_foreign,
                        salary_local: salary_local,
                        jobtitle: jobtitle,
                        working_days: working_days,
                        working_hours: working_hours,
                        datacveid: datacveid,
                        datacvedetid: datacvedetid,
                    }, function (rs) {
                        disabledInputs();
                        notifyChangesInReport();
                        aInitialValues['employment_is_documented'] = x;
                    }, 'json');
                },

                onCancel: function () {
                    aInitialValues['employment_is_documented'] == '1' ? $('#rdo_documented_employment').click() : $('#rdo_undocumented_employment').click();
                }
            });
        }
    });


    $('#frm-employer_details').validate({
        rules: {
            employer_email: {email: true},
            employer_name: {required: true}
        },
        messages: {},
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

            sCurrent = getFormValues('frm-employer_details');

            if (sCurrent != aInitialValues["employmer_details"]) {
                icmsMessage({
                    type: "msgConfirmation",
                    title: "You are about to update employer's details",
                    onConfirm: function () {
                        icmsMessage({
                            type: "msgPreloader",
                            body: "Saving... Please wait!",
                            visible: true
                        });
                        var emp_name = $('.emp-employer-employer_name').val();
                        var rep_name = $('.emp-employer-employer_representative_name').val();
                        var telno = $('.emp-employer-employer_tel_no').val();
                        var email = $('.emp-employer-employer_email').val();
                        var country = $('#emp-sel-eer-country').val();
                        var city = $('.emp-employer-employer_city').val();
                        var emp_address = $('.emp-employer-employer_full_address').val();
                        var emp_id = $('#btn-save-employer').attr('dataempid');
                        $.post(sAjaxCase, {
                            type: "setCaseVictimEmployerDetails",
                            case_id: $('#case_id').val(),
                            emp_name: emp_name,
                            rep_name: rep_name,
                            telno: telno,
                            email: email,
                            country: country,
                            city: city,
                            emp_address: emp_address,
                            emp_id: emp_id,
                        }, function (rs) {
                            getEmployerInformation();
                            disabledInputs();
                            $('.emp-employer-change_emp').hide();
                            notifyChangesInReport();
                        }, 'json');
                    }
                });

            } else {
                icmsMessage({
                    type: "msgWarning",
                    body: "No changes has been made.",
                });
            }
        }
    });

    $('#btn-save-employer').click(function () {
        $('#frm-employer_details').submit();
    });

    $('#frm-foreign-rect').validate({
        rules: {
            foreign_recruitment_email: {email: true},
            agency_name: {required: true}
        },
        messages: {},
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
            sCurrent = getFormValues('frm-foreign-rect');
            if (sCurrent != aInitialValues["foreign_rec_details"]) {
                icmsMessage({
                    type: "msgConfirmation",
                    title: "You are about to update the foreign recruitment details",
                    onConfirm: function () {
                        icmsMessage({
                            type: "msgPreloader",
                            body: "Saving... Please wait!",
                            visible: true
                        });
                        var id = $('#btn-save-foreign-rect').attr("rectid");
                        var agn_name = $('.emp-foreign-recruitment_agency_name').val();
                        var country = $('.emp-foreign-country_id').val();
                        var agn_address = $('.emp-foreign-recruitment_agency_address').val();
                        var agn_email = $('.emp-foreign-recruitment_agency_email').val();
                        var agn_tel = $('.emp-foreign-recruitment_agency_tel_no').val();
                        var agn_fax = $('.emp-foreign-recruitment_agency_fax_no').val();
                        var agn_web = $('.emp-foreign-recruitment_agency_website').val();

                        // owner
                        var agn_owner = $('.emp-foreign-recruitment_agency_owner_name').val();
                        var owner_address = $('.emp-foreign-recruitment_agency_owner_address').val();
                        var owner_contact = $('.emp-foreign-recruitment_agency_owner_contact').val();

                        // representative 
                        var agn_rep = $('.emp-foreign-recruitment_agency_rep_name').val();
                        var rep_address = $('.emp-foreign-recruitment_agency_rep_address').val();
                        var rep_contact = $('.emp-foreign-recruitment_agency_rep_contact').val();

                        $.post(sAjaxCase, {
                            type: "setRecruitmentDetails",
                            rec_type: '2',
                            case_id: $('#case_id').val(),
                            agn_id: id,
                            agn_name: agn_name,
                            country: country,
                            agn_address: agn_address,
                            agn_email: agn_email,
                            agn_tel: agn_tel,
                            agn_fax: agn_fax,
                            agn_web: agn_web,

                            agn_owner: agn_owner,
                            owner_address: owner_address,
                            owner_contact: owner_contact,

                            agn_rep: agn_rep,
                            rep_address: rep_address,
                            rep_contact: rep_contact

                        }, function (rs) {
                            disabledInputs();
                            notifyChangesInReport();
                            getRecruitmentInformation(0);
                            $('.emp-foreignrec-change').hide();
                        }, 'json');
                    }
                });
            } else {
                icmsMessage({
                    type: "msgWarning",
                    body: "No changes has been made.",
                });
            }
        }
    });


    $('#btn-save-foreign-rect').click(function () {
        $('#frm-foreign-rect').submit();
    });

    $('#frm-local-rect').validate({
        rules: {
            local_recruitment_email: {email: true},
            agency_name: {required: true}
        },
        messages: {},
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

            sCurrent = getFormValues('frm-local-rect');

            if (sCurrent != aInitialValues["local_rec_details"]) {
                icmsMessage({
                    type: "msgConfirmation",
                    title: "You are about to update the local recruitment details. ",
                    onConfirm: function () {
                        icmsMessage({
                            type: "msgPreloader",
                            body: "Saving... Please wait!",
                            visible: true
                        });

                        var id = $('#btn-save-local-rect').attr("rectid");
                        var agn_name = $('.emp-local-recruitment_agency_name').val();
                        var country = $('.emp-local-country_id').val();
                        var agn_address = $('.emp-local-recruitment_agency_address').val();
                        var agn_email = $('.emp-local-recruitment_agency_email').val();
                        var agn_tel = $('.emp-local-recruitment_agency_tel_no').val();
                        var agn_fax = $('.emp-local-recruitment_agency_fax_no').val();
                        var agn_web = $('.emp-local-recruitment_agency_website').val();
                        var agn_region = $('.emp-local_agency_region').val();
                        var agn_province = $('.emp-local_agency_province ').val();

                        // owner 
                        var agn_owner = $('.emp-local_agency_owner_name ').val();
                        var owner_address = $('.emp-local_agency_owner_address').val();
                        var owner_contact = $('.emp-local_agency_owner_contact ').val();

                        // representative 
                        var agn_rep = $('.emp-local_agency_rep_name').val();
                        var rep_address = $('.emp-local_agency_rep_address').val();
                        var rep_contact = $('.emp-local_agency_rep_contact').val();

                        // agent 
                        var agn_agent = $('.emp-local_agency_agent_name').val();
                        var agent_address = $('.emp-local_agency_agent_address').val();
                        var agent_contact = $('.emp-local_agency_agent_contact').val();

                        $.post(sAjaxCase, {
                            type: "setRecruitmentDetails",
                            case_id: $('#case_id').val(),
                            agn_id: id,

                            rec_type: '1',

                            agn_name: agn_name,
                            country: country,
                            agn_address: agn_address,
                            agn_email: agn_email,
                            agn_tel: agn_tel,
                            agn_fax: agn_fax,
                            agn_web: agn_web,
                            agn_region: agn_region,
                            agn_province: agn_province,

                            local_agency_owner_name: agn_owner,
                            local_agency_owner_address: owner_address,
                            local_agency_owner_contact: owner_contact,

                            local_agency_rep_name: agn_rep,
                            local_agency_rep_address: rep_address,
                            local_agency_rep_contact: rep_contact,

                            local_agency_agent_name: agn_agent,
                            local_agency_rep_address: agent_address,
                            local_agency_rep_contact: agent_contact

                        }, function (rs) {
                            disabledInputs();
                            notifyChangesInReport();
                            getRecruitmentInformation(1);
                            $('.emp-localrec-change').hide();
                        }, 'json');
                    }
                });
            } else {
                icmsMessage({
                    type: "msgWarning",
                    body: "No changes has been made.",
                });
            }
        }
    });

    $('#btn-save-local-rect').click(function () {
        $('#frm-local-rect').submit();
    });

    // for search foreign recruitment 
    $('.emp-foreign-recruitment_agency_name').on('keyup', function (e) {
        var keyword = $(this).val();
        setTimeout(function () {
            if (keyword.length) {
                getForeignRecruitmentByKeyword();
            }
        }, 1000);
    });

    // select foreign list list 
    $('#ra-foreign-search').delegate('.list-group-item', 'click', function () {
        var id = $(this).attr('data-id');
        getRecruitmentDetailsByID(id, '2');
    });


    $('#btn-update-deployment').click(function () {

        var chk = 0;
        if ($('#emp-deployment_document_is_falsified').is(':checked') == true) {
            chk = 1;
        }
        var caption = $(this).text();
        if (caption == "Manage") {
            $(this).text("Cancel");
            $('#btn-save-deployment').removeClass("hide");
            $('.emp-case_victim_deployment_type').prop("disabled", false);
            $('.emp-port_id').prop("disabled", false);
            $('.emp-case_victim_visa_category_id').prop("disabled", false);
            $('.emp-case_victim_deployment_country_destination').prop("disabled", false);
            $('.emp-case_victim_deployment_date').prop("disabled", false);
            $('.emp-case_victim_deployment_arrival_date').prop("disabled", false);
            $('.emp-deployment_document_is_falsified').prop("disabled", false);
            $('.emp-case_victim_deployment_other_port_details').prop("disabled", false);
            $('.emp-deployment_remark').prop("disabled", false);
            $('.emp-deployment_escort_name').prop("disabled", false);
            $('.emp-deployment_escort_description').prop("disabled", false);
        } else {
            sCurrent = getFormValues('frm-deployment') + chk;
            if (sCurrent != aInitialValues["deployment_details"]) {
                icmsMessage({
                    type: "msgConfirmation",
                    title: "You made some changes. Do you want to disregard changes?",
                    body: "Click yes button if you want to continue",
                    LblBtnConfirm: "Yes",
                    onConfirm: function () {
                        $('#btn-update-deployment').text("Manage");
                        $('#btn-save-deployment').addClass("hide");
                        $('.emp-case_victim_deployment_type').prop("disabled", true);
                        $('.emp-port_id').prop("disabled", true);
                        $('.emp-case_victim_visa_category_id').prop("disabled", true);
                        $('.emp-case_victim_deployment_country_destination').prop("disabled", true);
                        $('.emp-case_victim_deployment_date').prop("disabled", true);
                        $('.emp-case_victim_deployment_arrival_date').prop("disabled", true);
                        $('.emp-deployment_document_is_falsified').prop("disabled", true);
                        $('.emp-case_victim_deployment_other_port_details').prop("disabled", true);
                        $('.emp-deployment_remark').prop("disabled", true);
                        $('.emp-deployment_escort_name').prop("disabled", true);
                        $('.emp-deployment_escort_description').prop("disabled", true);
                        removeErrorClass('frm-deployment');
                        getDeploymentDetails(0);
                    }
                });
            } else {
                $('#btn-update-deployment').text("Manage");
                $('#btn-save-deployment').addClass("hide");
                $('.emp-case_victim_deployment_type').prop("disabled", true);
                $('.emp-port_id').prop("disabled", true);
                $('.emp-case_victim_visa_category_id').prop("disabled", true);
                $('.emp-case_victim_deployment_country_destination').prop("disabled", true);
                $('.emp-case_victim_deployment_date').prop("disabled", true);
                $('.emp-case_victim_deployment_arrival_date').prop("disabled", true);
                $('.emp-deployment_document_is_falsified').prop("disabled", true);
                $('.emp-case_victim_deployment_other_port_details').prop("disabled", true);
                $('.emp-deployment_remark').prop("disabled", true);
                $('.emp-deployment_escort_name').prop("disabled", true);
                $('.emp-deployment_escort_description').prop("disabled", true);

                removeErrorClass('frm-deployment');
                getDeploymentDetails(0);
            }
        }
    });


    $.validator.addMethod("checkDeployment", function (value, element) {
        var a = new Date(value);
        var b = new Date($(".emp-case_victim_deployment_date").val());
        if (a >= b) {
            return true;
        }
        if (!value) {
            return true;
        }
    }, "Arrival date cannot be less than deployment date");


    $('#frm-deployment').validate({
        rules: {
            case_victim_deployment_date: {pastDate: true},
//            case_victim_deployment_arrival_date: {
//                pastDate: true,
//                checkDeployment: true
//            },
        },
        messages: {
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
            var departure = $("#emp-sel-departure").val();
            if (departure == "0") {
                icmsMessage({
                    type: 'msgWarning',
                    body: '<center> Departure type is required. </center>',
                    caption: 'Close',
                });
            } else {

                var chk = 0;
                if ($('#emp-deployment_document_is_falsified').is(':checked') == true) {
                    chk = 1;
                }
                sCurrent = getFormValues('frm-deployment') + chk;

                if (sCurrent != aInitialValues["deployment_details"]) {
                    icmsMessage({
                        type: "msgConfirmation",
                        title: "You are about to update the deployment details ",
                        onConfirm: function () {
                            icmsMessage({
                                type: "msgPreloader",
                                body: "Saving... Please wait!",
                                visible: true
                            });

                            var chk = 0;
                            if ($('#emp-deployment_document_is_falsified').is(':checked') == true) {
                                chk = 1;
                            }

                            $.post(sAjaxCase, {
                                type: "setDeploymentDetails",
                                case_id: $('#case_id').val(),
                                departure_type: $('#emp-sel-departure').val(),
                                portofexit: $('#emp-sel-port_of_exit').val(),
                                visacat: $('#emp-sel-visa').val(),
                                destination: $('#emp-sel-country-dest').val(),
                                deployment_date: $('.emp-case_victim_deployment_date').val(),
                                arrival_date: $('.emp-case_victim_deployment_arrival_date').val(),
                                other_port_details: $('.emp-case_victim_deployment_other_port_details').val(),
                                deployment_remark: $('.emp-deployment_remark').val(),
                                deployment_escort_name: $('.emp-deployment_escort_name').val(),
                                deployment_escort_description: $('.emp-deployment_escort_description').val(),
                                is_falsified: chk,
                                deployment_id: $('#btn-save-deployment').attr("depid"),
                            }, function (rs) {

                                getDeploymentDetails(1);
                                notifyChangesInReport();

                                $('#btn-update-deployment').text("Manage");
                                $('#btn-save-deployment').addClass("hide");
                                $('.emp-case_victim_deployment_type').prop("disabled", true);
                                $('.emp-port_id').prop("disabled", true);
                                $('.emp-case_victim_visa_category_id').prop("disabled", true);
                                $('.emp-case_victim_deployment_country_destination').prop("disabled", true);
                                $('.emp-case_victim_deployment_date').prop("disabled", true);
                                $('.emp-case_victim_deployment_arrival_date').prop("disabled", true);
                                $('.emp-deployment_document_is_falsified').prop("disabled", true);
                                $('.emp-case_victim_deployment_other_port_details').prop("disabled", true);
                                $('.emp-deployment_remark').prop("disabled", true);
                                $('.emp-deployment_escort_name').prop("disabled", true);
                                $('.emp-deployment_escort_description').prop("disabled", true);

                            }, 'json');
                        }
                    });
                } else {
                    icmsMessage({
                        type: "msgWarning",
                        body: "No changes has been made.",
                    });
                }
            }
        }
    });

    $('#btn-save-deployment').click(function () {
        $('#frm-deployment').submit();
    });

    $('#emp-sel-eet-country').change(function () {
        var curr = $(this).find(':selected').attr('data-currency');
        var country_id = $(this).val();
        $('#emp-sel-eet-currency').val(curr).change();
        $('#emp-sel-eet-currency').find(':selected').attr('country_id', country_id);
    });

    $('#emp-sel-actual-country').change(function () {
        var curr = $(this).find(':selected').attr('data-currency');
        var country_id = $(this).val();
        $('#emp-sel-actual-currency').val(curr).change();
        $('#emp-sel-actual-currency').find(':selected').attr('country_id', country_id);
    });

    $("#btn-update-passport").click(function () {
        var caption = $(this).text();
        if (caption == "Manage") {
            $("#btn-update-passport").text("Cancel");
            $("#btn-save-passport").removeClass("hide");
            $("#frm-passport :input").prop("disabled", false);
        } else {

            sCurrent = getFormValues('frm-passport');
            if (sCurrent != aInitialValues["passport_details"]) {
                icmsMessage({
                    type: "msgConfirmation",
                    title: "You made some changes. Do you want to disregard changes?",
                    body: "Click yes button if you want to continue",
                    LblBtnConfirm: "Yes",
                    onConfirm: function () {
                        $("#btn-update-passport").text("Manage");
                        $("#frm-passport :input").prop("disabled", true);
                        $("#btn-save-passport").addClass("hide");
                        resetFormJQueryValidation('frm-passport');
                        getPassportDetails(0);
                    }
                });
            } else {
                $("#btn-update-passport").text("Manage");
                $("#frm-passport :input").prop("disabled", true);
                $("#btn-save-passport").addClass("hide");
            }

        }
    });


    $('#frm-passport').validate({
        rules: {
            ppassport_number: "required",
            pfname: "required",
            pmname: "required",
            plname: "required",
//            pselsex: {
//                required: true,
//                selectNotDefault: true,
//            },
//            pselcivil: {
//                required: true,
//                selectNotDefault: true,
//            },
            pdob: {
                dateOfBirth: true,
//                required: true,
            },
//            pselprov: {
//                required: true,
//                selectNotDefault: true,
//            },
//            pselcity: {
//                required: true,
//                selectNotDefault: true,
//            },
//            pplaceissued: "required",
            pdateissued: {
                pastDateOptional: true,
//                required: true,
            },
//            pdateissued: "required",
        },
        messages: {
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

            sCurrent = getFormValues('frm-passport');
            if (sCurrent != aInitialValues["passport_details"]) {
                icmsMessage({
                    type: "msgConfirmation",
                    title: "You are about to update the victim's passport details",
                    onConfirm: function () {
                        setPassportDetails();
                    }
                });
            } else {
                icmsMessage({
                    type: "msgWarning",
                    body: "No changes has been made.",
                });
            }

        }
    });

    $('#btn-save-passport').click(function () {
        $('#frm-passport').submit();
    });
    function setPassportDetails() {
        icmsMessage({
            type: "msgPreloader",
            body: "Saving... Please wait!",
            visible: true
        });
        $.post(sAjaxCaseDetails, {
            type: "setPassportDetails",
            case_id: $('#case_id').val(),
            passportnumber: $('#emp-txt-passport').val(),
            fname: $('#emp-txt-fname').val(),
            mname: $('#emp-txt-mname').val(),
            lname: $('#emp-txt-lname').val(),
            suffix: $('.emp-victim_passport_suffix').val(),
            gender: $('.emp-victim_passport_gender').val(),
            civil_status: $('.emp-victim_passport_civil_status').val(),
            dob: $('.emp-victim_passport_dob').val(),
            province: $('.emp-victim_passport_province_pob').val(),
            city: $('.emp-victim_passport_city_pob').val(),
            place_issued: $('.emp-victim_passport_place_issue').val(),
            date_issued: $('.emp-victim_passport_date_issued').val(),
            date_xp: $('.emp-victim_passport_date_expired').val(),
            passport_id: $('#btn-save-passport').attr('ppid'),
        }, function (rs) {

            $("#btn-update-passport").text("Manage");
            $("#frm-passport :input").prop("disabled", true);
            $("#btn-save-passport").addClass("hide");

            notifyChangesInReport();

            getPassportDetails(1);

        }, 'json');
    }

    // change sel port of exit 
    $('#emp-sel-port_of_exit').change(function () {
        var o = $(this).val();
        //other
        if (o == 1) {
            $('.f-poe_description').show();
        } else {
            $('.f-poe_description').hide();
            $('.emp-case_victim_deployment_other_port_details').val('');
        }
    });

    // change employment details 
    $('#emp-sel-departure').change(function () {
        var o = $(this).val();
        // reset fields 
        $('.f-dp_type_others').hide();
        $('.emp-deployment_remark').val('');
        $('.f-escort_name').hide();
        $('.emp-deployment_escort_name').val('');
        $('.f-escort_description').hide();
        $('.emp-deployment_escort_description').val('');
        $('.lbl-emp_deployment_date').html("Deployment Date");
        $('.div-deployment_arrival_date').show();
        switch (o) {
            case '2':
                // escorted
                $('.f-escort_name').show();
                $('.f-escort_description').show();
                break;
            case '4':
                // others
                $('.f-dp_type_others').show();
                $('.lbl-emp_deployment_date').html("Date");
                $('.div-deployment_arrival_date').hide();
                break;
            case '3':
                // Deffered
                $('.lbl-emp_deployment_date').html("Date of deferred departure");
                $('.div-deployment_arrival_date').hide();
                break;
        }
    });

    // for place of birth in passport info 
    $('#emp-sel-province').change(function () {
        var id = $(this).val();
        getCitiesByProvinceID(id);
    });

    // local employment convert

    $('input[type=radio][name=is_employment_employed]').change(function(){
        $('#fetch_employed').val(this.value);
    });

});// end of doc ready
