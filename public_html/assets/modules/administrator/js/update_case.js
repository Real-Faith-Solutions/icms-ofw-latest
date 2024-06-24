
var aVictimInfoByCaseId = [];
var aInitialValues = [];
var aCurrentValues = [];

function getUpdateCaseGlobalParameter() {

    icmsMessage({
        type: "msgPreloader",
        body: "Please wait while loading information",
        visible: true
    });

    $.post(sAjaxCaseDetails, {
        type: "getUpdateCaseGlobalParameter",
    }, function (rs) {

        icmsMessage({
            type: "msgPreloader",
            visible: false
        });

        var info = rs.data.info;

        // Sex 
        buildOptionDetailsParameter({
            aData: info.sex,
            sLabel: 'Select sex',
            sClass: 'sel-sex',
            sId: '',
        });

        // Civil Civil Status
        buildOptionDetailsParameter({
            aData: info.civil_status,
            sLabel: 'Select civil status',
            sClass: 'sel-civil',
            sId: '',
        });

        // Contact Type 
        buildOptionDetailsTransaction({
            aData: info.contact_type,
            sLabel: 'Select contact type',
            sClass: 'sel-contact_type',
            sId: '',
        });

        // Education Type 
        buildOptionDetailsParameter({
            aData: info.educational_attainment,
            sLabel: 'Select education attainment',
            sClass: 'sel-education',
            sId: '',
        });


        // Religion 
        buildOptionDetailsParameter({
            aData: info.religion,
            sLabel: 'Select religion',
            sClass: 'sel-religion',
            sId: '',
        });

         // ethic 
         buildOptionDetailsParameter({
            aData: info.ethnicgroup,
            sLabel: 'Select Ethic',
            sClass: 'sel-ethnic_group',
            sId: '',
        });

        // disabilities 
        buildOptionDetailsParameter({
            aData: info.disabilities,
            sLabel: 'Select Disabilties',
            sClass: 'vi-disability',
            sId: '',
        });

        // illness 
        buildOptionDetailsParameter({
            aData: info.illness,
            sLabel: 'Select History of Illness/Hospitalization',
            sClass: 'vi-history_of_illness',
            sId: '',
        });


        // Next of Kin 
        buildOptionDetailsParameter({
            aData: info.family_relation,
            sLabel: 'Select next of kin',
            sClass: 'sel-relation',
            sId: '',
        });

        var location = rs.data.location;

        // Place of Birth // Province
        buildOptionDetailsLocation({
            aData: location.province,
            sLabel: 'Select province',
            sClass: 'sel-provinces',
            sId: '',
        });

        // City 
        buildOptionDetailsLocation({
            aData: location.city,
            sLabel: 'Select city',
            sClass: 'sel-city',
            sId: '',
        });

        // Region 
        buildOptionDetailsLocation({
            aData: location.regions,
            sLabel: 'Select region',
            sClass: 'sel-regions',
            sId: '',
        });

        // Complainant Relationship to worker 
        buildOptionDetailsParameter({
            aData: info.family_relation,
            sLabel: 'Select relationship',
            sClass: 'case-complainant_relation',
            sId: '',
        });

        var sCase = rs.data.case;

        // Complainant Source 
        buildOptionDetailsParameter({
            aData: sCase.complainant_source,
            sLabel: 'Select complainant source',
            sClass: 'case-complainant_source',
            sId: '',
        });

        // Acts 
        buildOptionDetailsTIP({
            aData: sCase.acts,
            sLabel: 'Select acts',
            sClass: '',
            sId: 'cd-sel-acts',
        });

        // Means 
        buildOptionDetailsTIP({
            aData: sCase.means,
            sLabel: 'Select means',
            sClass: '',
            sId: 'cd-sel-means',
        });

        // Purposes
        buildOptionDetailsTIP({
            aData: sCase.purposes,
            sLabel: 'Select purposes',
            sClass: '',
            sId: 'cd-sel-purposes',
        });

        // Assessment type
        buildOptionDetailsTransaction({
            aData: sCase.assessment_type,
            sLabel: 'Select assessment type',
            sClass: '',
            sId: 'cd-mdl-sel-assmnt-type',
        });

        // Alleged Offender 
        buildOptionDetailsTransaction({
            aData: sCase.offender_type,
            sLabel: 'Select alleged offender type',
            sClass: 'sel-offender_type',
            sId: '',
        });

        var emp = rs.data.employment;

        // Employment Type 
        buildOptionDetailsParameter({
            aData: emp.employment_type,
            sLabel: 'Select employment type',
            sClass: '',
            sId: 'emp-sel-employment-type',
        });

        // Departure Type 
        buildOptionDetailsParameter({
            aData: emp.departure_type,
            sLabel: 'Select departure type',
            sClass: 'emp-case_victim_deployment_type',
            sId: '',
        });

        // Visa Category 
        buildOptionDetailsParameter({
            aData: emp.visa_category,
            sLabel: 'Select visa category',
            sClass: 'emp-case_victim_visa_category_id',
            sId: '',
        });

        // Port of exit 
        getPortOfExit();

        // Global Country 
        getNationality();

        // After loading global parameter 

        // load Victim Info 
        getVictimInfoByCaseId();

        // Assignee 
        loadListUsers();

        // Employment Details 
        getCountryISO();
        getEmploymentInformation(1); //actual work
        getEmploymentInformation(0); //different from contract
        getEmployerInformation();
        getRecruitmentInformation(1); // local
        getRecruitmentInformation(0); // foreign
        getDeploymentDetails(0);
        getPassportDetails(0);
        getTransitList();

        // Incident Details 
        getComplainantDetails();
        getCaseTIP();
        getCaseEvaluation();
        getCaseAllegedOffender();
        getServiceDetails();
        getUploadedDocuments();

    }, 'json');
}

function buildOptionDetailsParameter(x) {
    var l = "<option value='' selected>" + x.sLabel + "</option>";
    var other = "";
    $.each(x.aData, function (key, val) {
        var y = val.parameter_name;
        if (y.toLowerCase() == "other") {
            other = "<option value='" + val.parameter_count_id + "' data-name='" + val.parameter_name + "'>" + val.parameter_name + " </option>";
        } else {
            l += "<option value='" + val.parameter_count_id + "' data-name='" + val.parameter_name + "'>" + val.parameter_name + " </option>";
        }
    });
    l += other;
    if (x.sClass) {
        $('.' + x.sClass).html(l);
    }
    if (x.sId) {
        $('#' + x.sId).html(l);
    }
}

function buildOptionDetailsTransaction(x) {
    l = "<option value='' selected>" + x.sLabel + "</option>";
    $.each(x.aData, function (key, val) {
        l += "<option value='" + val.transaction_parameter_count_id + "' data-name='" + val.transaction_parameter_name + "'>" + val.transaction_parameter_name + " </option>";
    });
    if (x.sClass) {
        $('.' + x.sClass).html(l);
    }
    if (x.sId) {
        $('#' + x.sId).html(l);
    }
}

function buildOptionDetailsTIP(x) {

    if (x.sId) {
        $('#' + x.sId).chosen("destroy");
    }
    if (x.sClass) {
        $('.' + x.sClass).chosen("destroy");
    }

    l = "";
    $.each(x.aData, function (key, val) {
        l += "<option value='" + val.tip_details_count + "' data-name='" + val.tip_details_name + "'>" + val.tip_details_name + " </option>";
    });
    if (x.sClass) {
        $('.' + x.sClass).html(l);
    }
    if (x.sId) {
        $('#' + x.sId).html(l);
        $('#' + x.sId).chosen();
    }
}


function buildOptionDetailsLocation(x) {
    l = "<option value='' selected>" + x.sLabel + "</option>";
    $.each(x.aData, function (key, val) {
        l += "<option value='" + val.location_count_id + "'>" + val.location_name + " </option>";
    });
    if (x.sClass) {
        $('.' + x.sClass).html(l);
    }
    if (x.sId) {
        $('#' + x.sId).html(l);
    }
}

function notifyChangesInReport() {
    icmsMessage({
        type: "msgPreloader",
        visible: false
    });
    icmsMessage({
        type: "msgSuccess",
        body: "Processing Done!",
    });

    $.post(sAjaxCaseDetails, {
        type: "notifyChangesInReport",
        case_id: $('#case_id').val(),
    }, function (rs) {
        // do nothing
    }, 'json');
}

function printExportCase() {

    //personal info
    $('#personal-fname').text($('.vi-victim_info_first_name').val());
    $('#personal-mname').text($('.vi-victim_info_middle_name').val());
    $('#personal-lname').text($('.vi-victim_info_last_name').val());
    $('#personal-suffix').text($('.vi-victim_info_suffix').val());
    if ($('.vi-victim_religion').val() >= 1) {
        $('#personal-religion').text($('.vi-victim_religion option:selected').text());
    } else {
        $('#personal-religion').text("");
    }
    $('#personal-dob').text($('.vi-victim_info_dob').val());

    if ($('.vi-victim_info_city_pob').val() >= 1) {
        $('#personal-pob').text($('.vi-victim_info_city_pob option:selected').text());
    } else {
        $('#personal-pob').text("");
    }

    if ($('.vi-victim_gender').val() >= 1) {
        $('#personal-sex').text($('.vi-victim_gender option:selected').text());
    } else {
        $('#personal-sex').text("");
    }

    if ($('.vi-victim_civil_status').val() >= 1) {
        $('#personal-civil').text($('.vi-victim_civil_status option:selected').text());
    } else {
        $('#personal-civil').text("");
    }




    //assumed info
    $('#assumed-fname').text($('.vi-assumed-victim_info_first_name').val());
    $('#assumed-mname').text($('.vi-assumed-victim_info_middle_name').val());
    $('#assumed-lname').text($('.vi-assumed-victim_info_last_name').val());
    $('#assumed-dob').text($('.vi-assumed-victim_info_dob').val());

    //contact info
    var contact_list = ""
    $('.victim-contact_info_list tr').each(function () {
        contact_list += "<tr>";
        contact_list += "     <td  width='30%'style='padding-left: 10px'>" + $(this).find("td").eq(0).text() + "</td> ";
        contact_list += "     <td width='1%'>:</td>";
        contact_list += "     <td width='69%'>" + $(this).find("td").eq(1).text() + "</td>";
        contact_list += "</tr>";
    });
    $('#tbody-contact').html(contact_list);

    // education
    var eduction_list = "";
    $('.victim-education_info_list tr').each(function () {
        eduction_list += "<tr>";
        eduction_list += "     <td width='30%'>" + $(this).find("td").eq(0).text() + "</td> ";
        eduction_list += "     <td width='55%'>" + $(this).find("td").eq(1).text() + "</td>  ";
        eduction_list += "     <td width='15%'>" + $(this).find("td").eq(2).text() + "</td>";
        eduction_list += "</tr>";
    });
    $('#tbody-education').html(eduction_list);

    // address
    var address_list = "";
    $('.victim-address_info_list tr').each(function () {
        address_list += "<tr>";
        address_list += "     <td>" + $(this).find("td").eq(0).text() + "</td> ";
        address_list += "</tr>";
    });
    $('#tbody-address').html(address_list);

    // Next of Kin
    var next_kin_list = "";
    $('.victim-relative_info_list tr').each(function () {
        next_kin_list += "<tr>";
        next_kin_list += '  <td width="30%">' + $(this).find("td").eq(0).text() + '</td>  ';
        next_kin_list += '  <td width="35%">' + $(this).find("td").eq(1).text() + '</td>  ';
        next_kin_list += '  <td width="35%">' + $(this).find("td").eq(2).text() + '</td>  ';
        next_kin_list += "</tr>";
    });
    $('#tbody-next-kin').html(next_kin_list);

    //documented fields
    var is_docd = $('input[name=rdo_doc_employment]:checked').val();
    if (is_docd == "0") {
        is_docd = "( Irregular )";
    } else {
        is_docd = "( Regular )";
    }
    $('.is_documented').text(is_docd);

    if ($('#emp-sel-eet-country').val() >= 1) {
        $('#empt-country').text($('#emp-sel-eet-country option:selected').text());
    } else {
        $('#empt-country').text("");
    }
    if ($('.emp-case_victim_employment_city').val() >= 1) {
        $('#empt-city').text($('.emp-case_victim_employment_city').val());
    } else {
        $('#empt-city').text("");
    }

    $('#empt-occupation').text($('.emp-case_victim_employment_details_job_title').val());
    $('#empt-salary-peso').text("PHP" + $('.emp-case_victim_employment_details_salary_in_local').val());

    $('#empt-per-week').text($('.emp-case_victim_employment_details_working_days').val());
    $('#empt-per-day').text($('.emp-case_victim_employment_details_working_hours').val());
    if ($('#emp-sel-eet-currency').val() >= 1) {
        $('#empt-per-f-currency').text($('#emp-sel-eet-currency option:selected').text());
    } else {
        $('#empt-per-f-currency').text("");
    }

    $('#empt-per-f-amount').text($('.emp-case_victim_employment_details_salary_in_foreign').val());


    //undocumented fields
    if ($('#emp-sel-actual-country').val() >= 1) {
        $('#empt-u-country').text($('#emp-sel-actual-country option:selected').text());
    } else {
        $('#empt-u-country').text("");
    }

    $('#empt-u-city').text($('.emp-act-case_victim_employment_city').val());
    $('#empt-u-occupation').text($('.emp-act-case_victim_employment_details_job_title').val());
    $('#empt-u-salary-peso').text("PHP" + $('.emp-act-case_victim_employment_details_salary_in_local').val());

    $('#empt-u-per-week').text($('.emp-act-case_victim_employment_details_working_days').val());
    $('#empt-u-per-day').text($('.emp-act-case_victim_employment_details_working_hours').val());

    if ($('#emp-sel-actual-currency').val() >= 1) {
        $('#empt-u-per-f-currency').text($('#emp-sel-actual-currency option:selected').text());
    } else {
        $('#empt-u-per-f-currency').text("");
    }

    $('#empt-u-per-f-amount').text($('.emp-act-case_victim_employment_details_salary_in_foreign').val());


    //employer
    $('#empr-name').text($('.emp-employer-employer_name').val());
    if ($('#emp-sel-actual-currency').val() >= 1) {
        $('#empr-country').text($('#emp-sel-actual-currency option:selected').text());
    } else {
        $('#empr-country').text("");
    }
    $('#empr-rep-name').text($('.emp-employer-employer_representative_name').val());
    $('#empr-city').text($('.emp-employer-employer_city').val());
    $('#empr-telno').text($('.emp-employer-employer_tel_no').val());
    $('#empr-email').text($('.emp-employer-employer_email').val());
    $('#empr-address').text($('.emp-employer-employer_full_address').val());


    //local recruitment
    $('#l-agn-name').text($('.emp-local-recruitment_agency_name').val());
    $('#l-agn-phone').text($('.emp-local-recruitment_agency_tel_no').val());
    $('#l-agn-fax').text($('.emp-local-recruitment_agency_fax_no').val());
    $('#l-agn-email').text($('.emp-local-recruitment_agency_email').val());
    $('#l-agn-website').text($('.emp-local-recruitment_agency_website').val());
    if ($('.emp-local-country_id').val() >= 1) {
        $('#l-agn-country').text($('.emp-local-country_id option:selected').text());
    } else {
        $('#l-agn-country').text("");
    }
    $('#l-agn-address').text($('.emp-local-recruitment_agency_address').val());
    $('#l-agn-rep').text($('.emp-local-recruitment_agency_owner_name').val());
    $('#l-agn-rep-cont').text($('.emp-local-recruitment_agency_owner_contact_no').val());
    $('#l-agn-rep-address').text($('.emp-local-recruitment_agency_owner_address').val());

    //foreign recruitment
    $('#f-agn-name').text($('.emp-foreign-recruitment_agency_name').val());
    $('#f-agn-phone').text($('.emp-foreign-recruitment_agency_tel_no').val());
    $('#f-agn-fax').text($('.emp-foreign-recruitment_agency_fax_no').val());
    $('#f-agn-email').text($('.emp-foreign-recruitment_agency_email').val());
    $('#f-agn-website').text($('.emp-foreign-recruitment_agency_website').val());
    if ($('.emp-foreign-country_id').val() >= 1) {
        $('#f-agn-country').text($('.emp-foreign-country_id option:selected').text());
    } else {
        $('#f-agn-country').text("");
    }
    $('#f-agn-address').text($('.emp-foreign-recruitment_agency_address').val());
    $('#f-agn-rep').text($('.emp-foreign-recruitment_agency_owner_name').val());
    $('#f-agn-rep-cont').text($('.emp-foreign-recruitment_agency_owner_contact_no').val());
    $('#f-agn-rep-address').text($('.emp-foreign-recruitment_agency_owner_address').val());


    //deployment details
    $('.is_falsified').text("( Unfalsified travel Documents )");
    if ($('#emp-deployment_document_is_falsified').prop('checked') == true) {
        $('.is_falsified').text("( Falsified travel Documents )");
    }
    if ($('#emp-sel-departure').val() >= 1) {
        $('#dept-type').text($('#emp-sel-departure option:selected').text());
    } else {
        $('#dept-type').text("");
    }
    if ($('#emp-sel-port_of_exit').val() >= 1) {
        $('#port-of-exit').text($('#emp-sel-port_of_exit option:selected').text());
    } else {
        $('#port-of-exit').text("");
    }
    if ($('#emp-sel-country-dest').val() >= 1) {
        $('#country-destination').text($('#emp-sel-country-dest option:selected').text());
    } else {
        $('#country-destination').text("");
    }
    if ($('#emp-sel-visa').val() >= 1) {
        $('#visa-cat').text($('#emp-sel-visa option:selected').text());
    } else {
        $('#visa-cat').text("");
    }




    $('#deploy-date').text($('.emp-case_victim_deployment_date').val());
    $('#arrival-date').text($('.emp-case_victim_deployment_arrival_date').val());


    //passport
    $('#pp-number').text($('#emp-txt-passport').val());
    $('#pp-fname').text($('.emp-victim_passport_first_name').val());
    $('#pp-mname').text($('.emp-victim_passport_middle_name').val());
    $('#pp-lname').text($('.emp-victim_passport_last_name').val());
    if ($('#psel-sex').val() >= 1) {
        $('#pp-sex').text($('#psel-sex option:selected').text());
    } else {
        $('#pp-sex').text("");
    }
    if ($('#psel-civil').val() >= 1) {
        $('#pp-civil').text($('#psel-civil option:selected').text());
    } else {
        $('#pp-civil').text("");
    }

    $('#pp-dob').text($('.emp-victim_passport_dob').val());
    if ($('.emp-victim_passport_province_pob').val() >= 1) {
        $('#pp-pob-prov').text($('.emp-victim_passport_province_pob option:selected').text());
    } else {
        $('#pp-pob-prov').text("");
    }
    if ($('.emp-victim_passport_city_pob').val() >= 1) {
        $('#pp-pob-city').text($('.emp-victim_passport_city_pob option:selected').text());
    } else {
        $('#pp-pob-city').text("");
    }

    $('#pp-p-issued').text($('.emp-victim_passport_place_issue').val());
    $('#pp-d-issued').text($('.emp-victim_passport_date_issued').val());
    $('#pp-xp').text($('.emp-victim_passport_date_expired').val());


    //transit info
    var transit_list = ""
    $('.tbl-transit-list tr').each(function () {
        transit_list += '<tr>';
        transit_list += '    <td width="20%" style="padding-left: 10px;">Country</td><td width="1%"> : </td>  <td width="29%">' + $(this).find("td").eq(0).text() + '</td>';
        transit_list += '    <td width="20%">City</td>    <td width="1%">:</td>  <td width="29%">' + $(this).find("td").eq(1).text() + '</td>';
        transit_list += '</tr>';
        transit_list += '<tr>';
        transit_list += '    <td width="20%" style="padding-left: 10px;">Departure Date</td><td width="1%"> : </td>  <td width="29%">' + $(this).find("td").eq(3).text() + '</td>';
        transit_list += '    <td width="20%">Arrival Date</td>    <td width="1%">:</td>  <td width="29%">' + $(this).find("td").eq(4).text() + '</td>';
        transit_list += '</tr>';
        transit_list += '<tr>';
        transit_list += '    <td style="border-bottom: 1px solid rgba(0,0,0,0.1); padding-left: 10px;" width="20%">Remarks</td>';
        transit_list += '    <td style="border-bottom: 1px solid rgba(0,0,0,0.1);" width="1%"> : </td>';
        transit_list += '    <td style="border-bottom: 1px solid rgba(0,0,0,0.1);"colspan="4">' + $(this).attr('data-remarks') + '</td>';
        transit_list += '</tr>';
    });
    $('#tbody-transit').html(transit_list);


    //complainant
    $('#comp-date').text($('#date-complained').val());
    $('#comp-name').text($('#cd-txt-name').val());
    if ($('#sel-relation-to-victim').val() >= 1) {
        $('#comp-relation').text($('#sel-relation-to-victim option:selected').text());
    } else {
        $('#comp-relation').text("");
    }

    var relation = $('#sel-relation-to-victim').val();
    if (relation == "0") {
        $('#comp-relation').text("");
    }
    $('#comp-remarks').text($('#complainant_remarks').val());
    if ($('.case-complainant_source').val() >= 1) {
        $('#comp-source').text($('.case-complainant_source option:selected').text());
    } else {
        $('#comp-source').text("");
    }

    $('#comp-contact').text($('.case-complainant_contact').val());
    $('#comp-address').text($('.case-complainant_address').val());


    //report info
    $('#rep-fact').text($('.case-facts').val());

    var acts = "";
    $.each($("#cd-sel-acts option:selected"), function (key, val) {
        if (acts == "") {
            acts = $(this).text();
        } else {
            acts += ", " + $(this).text();
        }
    });
    $('#rep-act').text(acts);

    var purpose = "";
    $.each($("#cd-sel-purposes option:selected"), function (key, val) {
        if (purpose == "") {
            purpose = $(this).text();
        } else {
            purpose += ", " + $(this).text();
        }
    });
    $('#rep-purpose').text(purpose);

    var means = "";
    $.each($("#cd-sel-means option:selected"), function (key, val) {
        if (means == "") {
            means = $(this).text();
        } else {
            means += ", " + $(this).text();
        }
    });
    $('#rep-means').text(means);


    // alleged offender
    if ($("#tbl-offender-list").attr('content') == "1") {
        var offnd = "";
        $('#tbl-offender-list tr').each(function () {
            offnd += '<tr> ';
            offnd += '  <td width="20%" style="padding-left:10px;">Name</td><td width="1%"> : </td>  <td width="29%">' + $(this).attr('alg-name') + '</td>';
            offnd += '  <td width="20%" style="border-bottom: 1px solid rgba(0,0,0,0.1);" valign="top" rowspan="5">' + $(this).attr('alg-remarks') + '</td>  ';
            offnd += '</tr>';
            offnd += '<tr> ';
            offnd += '  <td width="20%" style="padding-left:10px;">Position</td><td width="1%"> : </td>  <td width="29%" >' + $(this).attr('alg-position') + '</td>'
            offnd += '</tr>';
            offnd += '<tr> ';
            offnd += '  <td width="20%" style="padding-left:10px;">Nationality     </td><td width="1%"> : </td>  <td width="29%" id="alg-nationality">' + $(this).attr('alg-nationality') + '</td>';
            offnd += '</tr>';
            offnd += '<tr> ';
            offnd += '  <td width="20%" style="padding-left:10px;">Contact </td><td width="1%"> : </td>  <td width="29%" id="alg-contact">' + $(this).attr('alg-contact') + '</td>';
            offnd += '</tr>';
            offnd += '<tr> ';
            offnd += '  <td width="20%" style="padding-left:10px;border-bottom: 1px solid rgba(0,0,0,0.1);">Address </td><td style="border-bottom: 1px solid rgba(0,0,0,0.1);" width="1%"> : </td>  <td style="border-bottom: 1px solid rgba(0,0,0,0.1);" width="29%" id="alg-address">' + $(this).attr('alg-address') + '</td>';
            offnd += '</tr>';
        });
        $('#tbody-offender').html(offnd);
    } else {
        $('#tbody-offender').html("<tr><td colspan='4'><center>No alleged offender</center></td></tr>");
    }

    //risk assessment and evaluation
    $('#print-evaluation').text($('#area-evaluation').val());
    $('#print-riskasses').text($('#area-case-risk-assessment').val());

    var divToPrint = document.getElementById('content-print');
    var newWin = window.open('', 'Print-Window');
    newWin.document.open();
    newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');
    newWin.document.close();
    setTimeout(function () {
        newWin.close();
    }, 10);

}

$(document).ready(function () {

    // Get Global Parameters
    getUpdateCaseGlobalParameter();

    // export 
    $('#export_print_report').click(function () {
        confirmPassword({
            onSubmit: function () {
                printExportCase();
            }
        });
    });

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



    $('#employment_details_tab').click(function () {
//        getEmploymentInfoByCaseVictimId();
    });

    $('#victim_details_tab').click(function () {

        // getVictimInfoByCaseId();
    });


    $('#btn_back_list').click(function () {
        location.assign(window.location.origin + '/cases');
    });

    // reset add modal when click cancel
    $('.add_modal .btn-modal-cancel').click(function () {
        var x = $(this).closest("form").attr('id');
        console.log('form->' + x);
        if (x) {
            resetFormById(x);
        }
    });


});
