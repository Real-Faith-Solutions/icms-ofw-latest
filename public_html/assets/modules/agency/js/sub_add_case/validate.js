/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function validateVictim() {

    //validate function

    //no matched results
    $('.matched_results').show();
    $('.matched_contents').hide();
    $('.matched_none').show();

    $('.btn-next_tab').show();

}

function storeVictimDetails() {

    //store victim details personal information
    var victim_personal_info = {
        'first_name': $('.vi-first_name').val(),
        'middle_name': $('.vi-middle_name').val(),
        'last_name': $('.vi-last_name').val(),
        'nickname': $('.vi-nickname').val(),
        'dob': $('.vi-dob').val(),
        'pob': $('.vi-pob').val(),
        'pob_value': $('.vi-pob option:selected').attr('data-name'),
        'suffix': $('.vi-suffix').val(),
        'sex': $('.vi-sex').val(),
        'sex_value': $('.vi-sex option:selected').attr('data-name'),
        'civil': $('.vi-civil').val(),
        'civil_value': $('.vi-civil option:selected').attr('data-name'),
        'religion': $('.vi-religion').val(),
        'ethnic_group': $('.vi-ethnic_group').val(),
        'ethnic_group_value': $('.vi-ethnic_group option:selected').attr('data-name'),
        'religion_value': $('.vi-religion option:selected').attr('data-name'),
        'assumed_first_name': $('.vi-assumed_first_name').val(),
        'assumed_middle_name': $('.vi-assumed_middle_name').val(),
        'assumed_last_name': $('.vi-assumed_last_name').val(),
        'assumed_dob': $('.vi-assumed_dob').val(),
        'disability': $('.vi-disability').val(),
        'disability_value': $('.vi-disability option:selected').attr('data-name'),
        
    };

    _setStorageData(victim_personal_info, 'victim_personal_info');


}

// Validate Victim Details
function validationForVictim() {

    icmsMessage({
        type: 'msgPreloader',
        visible: true,
        body: "Please wait while loading."
    });

    // get value from fields
    var victim_info_first_name = $('.v-first_name').val();
    var victim_info_middle_name = $('.v-middle_name').val();
    var victim_info_last_name = $('.v-last_name').val();
    var victim_info_dob = $('.v-dob').val();
    var victim_info_city_pob = $('.v-pob').val();
    var offender_name = $('.v-offender_name').val();
    var employer_name = $('.v-employer_name').val();
    var local_recruitment_agency = $('.v-local_recruitment_agency').val();
    var deployed_date = $('.v-deployed_date').val();
    var deployment_country = $('.v-deployment_country').val();
    var traffic_purpose = $('.v-traffic_purpose').val();
    var victim_info_city_pob_text = $(".v-pob option:selected").text();
    var deployment_country_text = $(".v-deployment_country option:selected").text();
    var traffic_purpose_text = $(".v-traffic_purpose option:selected").text();

    // Set local storage
    localStorage.setItem('victim_info_first_name', victim_info_first_name);
    localStorage.setItem('victim_info_middle_name', victim_info_middle_name);
    localStorage.setItem('victim_info_last_name', victim_info_last_name);
    localStorage.setItem('victim_info_dob', victim_info_dob);
    localStorage.setItem('victim_info_city_pob', victim_info_city_pob);
    localStorage.setItem('offender_name', offender_name);
    localStorage.setItem('employer_name', employer_name);
    localStorage.setItem('local_recruitment_agency', local_recruitment_agency);
    localStorage.setItem('deployed_date', deployed_date);
    localStorage.setItem('deployment_country', deployment_country);
    localStorage.setItem('traffic_purpose', traffic_purpose);

    $.post(sAjaxValidate, {
        type: 'validate',
        victim_info_first_name: localStorage.getItem('victim_info_first_name'),
        victim_info_middle_name: localStorage.getItem('victim_info_middle_name'),
        victim_info_last_name: localStorage.getItem('victim_info_last_name'),
        victim_info_dob: localStorage.getItem('victim_info_dob'),
        victim_info_city_pob: localStorage.getItem('victim_info_city_pob'),
        offender_name: localStorage.getItem('offender_name'),
        employer_name: localStorage.getItem('employer_name'),
        local_recruitment_agency: localStorage.getItem('local_recruitment_agency'),
        deployed_date: localStorage.getItem('deployed_date'),
        deployment_country: localStorage.getItem('deployment_country'),
        traffic_purpose: localStorage.getItem('traffic_purpose'),
        victim_info_city_pob_text: victim_info_city_pob_text,
        deployment_country_text: deployment_country_text,
        traffic_purpose_text: traffic_purpose_text
    }, function (rs) {
        rs = html_entity_decode(rs);
        $('.card-validate').show();
        $('.matched_contents').show();

        if (rs.data.flag == '1') {
            $('.matched_none').hide();
            $('.matched_results').show();
            localStorage.setItem('v_count', rs.data.count);
//            localStorage.setItem('v_total_fields', rs.data.total_fields);
            localStorage.setItem('v_total_fields', rs.data.tf);
            getVictimsFromValidation();
        } else {
            $('.matched_none').show();
            $('.matched_results').hide();

            icmsMessage({
                type: 'msgConfirmation',
                title: 'There is no pre-existing record of case/report found. ',
                body: 'Click continue to proceed in adding a report or cancel to revalidate.',
                LblBtnConfirm: 'Continue',
                LblBtnCancel: 'Cancel',
                onConfirm: function () {
                    $('#victims-details-tab1').click();
                    setDetailsBasedOnValidate();
                },
            });
        }

        // next tab show 
        $('.btn-next_tab').show();

        // enable victim detail tab
        $('#victims-details-tab1').attr('disabled', false);

        // scroll to match result div
        $('html, body').animate({
            scrollTop: $("div#div-match_result").offset().top
        }, 1000)

    }, 'json');

}

//Old View Details of the Validation Result 
function _getVictimsFromValidation(page = 1) {
    var count = localStorage.getItem('v_count'),
            total_fields = localStorage.getItem('v_total_fields'),
            type = 'getAllStoredVictims',
            limit = 10;

    $.post(sAjaxValidate, {
        type: type,
        count: count,
        total_fields: total_fields,
        limit: limit,
        page: page
    }, function (rs) {
        rs = html_entity_decode(rs);
        var t = '';
        $('.match-result-content').html(t);
        if (rs.data.total_rel_by_info_id.length > 0) {
            $.each(rs.data.total_rel_by_info_id, function (key, val) {

                t += '    <tr class="match-result-details"  data-vid="' + val.icms_validation_victim_id + '"  data-vinfid="' + val.icms_validation_victim_info_id + '" data-count="' + count + '">';
                t += '        <td>';
                t += '            <b>' + val.full_name + ' </b><br>';
                t += '            Birthday : ' + val.victim_info_dob + '<br>';
                t += '            Place of Birth : ' + val.city + '';
                t += '        </td>';
                t += '        <td>' + val.cases + '</td>';
                t += '        <td><b>' + val.final_rel + '</b></td>';
                t += '    </tr><hr>';
            });
        }

        $('.match-result-content').html(t);
        $('.matched_contents').show();

        // pagination
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
        setTimeout(function () {
            icmsMessage({
                type: 'msgPreloader',
                visible: false
            });
        }, 1000);

    }, 'json');
}

//New View Details of the Validation Result 
function getVictimsFromValidation(page = 1) {
    var count = localStorage.getItem('v_count'),
            total_fields = localStorage.getItem('v_total_fields'),
            type = 'getAllStoredVictims',
            limit = 10;

    $.post(sAjaxValidate, {
        type: type,
        count: count,
        total_fields: total_fields,
        limit: limit,
        page: page
    }, function (rs) {
        rs = html_entity_decode(rs);
        var t = '';
        $('.match-result-content').html(t);
        if (rs.data.total_rel_by_info_id.list.length > 0) {
            $.each(rs.data.total_rel_by_info_id.list, function (key, val) {

                t += '    <tr class="match-result-details"  data-vid="' + val.icms_validation_victim_id + '"  data-vinfid="' + val.victim_info_id + '" data-count="' + count + '">';
                t += '        <td>';
                t += '            <b>' + val.full_name + ' </b><br>';
                t += '            Birthday : ' + val.victim_info_dob + '<br>';
                t += '            Place of Birth : ' + val.city + '';
                t += '        </td>';
                t += '        <td>' + val.cases + '</td>';
                t += '        <td><b>' + val.final_rel + '%</b></td>';
                t += '    </tr><hr>';
            });
        }

        $('.match-result-content').html(t);
        $('.matched_contents').show();

        // pagination
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
        setTimeout(function () {
            icmsMessage({
                type: 'msgPreloader',
                visible: false
            });
        }, 1000);

    }, 'json');
}

function setDetailsBasedOnValidate() {

    $('#validate-details-tab1').attr('disabled', true);

    $('.vi-first_name').val(localStorage.getItem('victim_info_first_name'));
    $('.vi-middle_name').val(localStorage.getItem('victim_info_middle_name'));
    $('.vi-last_name').val(localStorage.getItem('victim_info_last_name'));
    $('.vi-dob').val(localStorage.getItem('victim_info_dob'));
    $('.vi-pob').val(localStorage.getItem('victim_info_city_pob'));
    //offender_name: localStorage.getItem('offender_name'))
    //$('.emp-employer_name').val(localStorage.getItem('employer_name'));
    //$('.emp-local_agency_name').val(localStorage.getItem('local_recruitment_agency'));
    $('.emp-deployment_date').val(localStorage.getItem('deployed_date'));
    $('.emp-deployment_country').val(localStorage.getItem('deployment_country'));

    storeVictimDetails();
}

$(document).ready(function () {


    //forms validation and submit
    $("#form-validate_victim").validate({
        rules: {
            first_name: {required: true},
            last_name: {required: true},
            //v_dob: {pastDateOptional: true, required: true},
            v_deployed_date: {pastDateOptional: true, required: true},
            v_deployment_country: {required: true},
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
            validationForVictim();
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

    $('.match-result-content').delegate('.match-result-details', 'click', function () {

        icmsMessage({
            type: 'msgPreloader',
            visible: true,
            body: 'Please wait while loading.'
        });

        var victim_id = $(this).attr('data-vid');
        var victim_info_id = $(this).attr('data-vinfid');
        var count = $(this).attr('data-count');
        var type = 'getVictimCaseList';
        $.post(sAjaxValidate, {
            type: type,
            victim_id: victim_id,
            victim_info_id: victim_info_id,
            count: count,
            victim_info_first_name: localStorage.getItem('victim_info_first_name'),
            victim_info_middle_name: localStorage.getItem('victim_info_middle_name'),
            victim_info_last_name: localStorage.getItem('victim_info_last_name'),
            victim_info_dob: localStorage.getItem('victim_info_dob'),
            victim_info_city_pob: localStorage.getItem('victim_info_city_pob'),
            offender_name: localStorage.getItem('offender_name'),
            employer_name: localStorage.getItem('employer_name'),
            local_recruitment_agency: localStorage.getItem('local_recruitment_agency'),
            deployed_date: localStorage.getItem('deployed_date'),
            deployment_country: localStorage.getItem('deployment_country'),
            traffic_purpose: localStorage.getItem('traffic_purpose')
        }, function (rs) {
            rs = html_entity_decode(rs);
            $('.fa-check-circle').attr('hidden', 'true');

            $('.validate-add-new-btn').attr('data-victim_id', victim_id);
            $('.vic-name .fa-check-circle').attr('hidden', true);
            $('.vic-victim_info_dob .fa-check-circle').attr('hidden', true);
            $('.vic-city .fa-check-circle').attr('hidden', true);

            if (rs.data.victim_info) {
                var rName = '';
                var rDob = '';
                var rPob = '';
                if (rs.data.rel_desc.length > 0) {
                    $.each(rs.data.rel_desc, function (key, val) {

                        if (val.icms_validation_relevance_desc == 'rel_name') {
                            rName = rs.data.victim_info.victim_info_first_name + ' ' + rs.data.victim_info.victim_info_middle_name + ' ' + rs.data.victim_info.victim_info_last_name + '<i class="fas fa-check-circle text-success"></i>';
                        } else {
                            rName = rs.data.victim_info.victim_info_first_name + ' ' + rs.data.victim_info.victim_info_middle_name + ' ' + rs.data.victim_info.victim_info_last_name;
                        }

                        if (val.icms_validation_relevance_desc == 'rel_dob') {
                            rDob = checkIfStringExist(rs.data.victim_info.victim_info_dob) + '<i class="fas fa-check-circle text-success"></i>';
                        } else {
                            rDob = checkIfStringExist(rs.data.victim_info.victim_info_dob);
                        }

                        if (val.icms_validation_relevance_desc == 'rel_pob') {
                            rPob = checkIfStringExist(rs.data.victim_info.city) + '<i class="fas fa-check-circle text-success"></i>';
                        } else {
                            rPob = checkIfStringExist(rs.data.victim_info.city);
                        }

                    });
                }

                $('.vic-name').html(rName);
                var vic_info = '';
                vic_info += '                <div class="col-md-6">';
                vic_info += '                    <span class="input-tite">Date of Birth: </span>';
                vic_info += '                    <span  class="case-agency_name vic-victim_info_dob pl-1">' + rDob + ' </span>';
                vic_info += '                </div>';
                vic_info += '                <div class="col-md-6">';
                vic_info += '                    <span class="input-tite"> Place of Birth:</span>';
                vic_info += '                    <span  class="case-agency_name vic-city pl-1">' + rPob + ' </span>';
                vic_info += '                </div>';
                $('.vic-personal-info').html(vic_info);


            }


            if (rs.data.test.length > 0) {
                var l = '';
                $('.validation-case-list').html(l);


                $.each(rs.data.test, function (key, val) {

                    l += '<div class="card">';
                    l += '    <figure class="figure">';
                    l += '        <figcaption class="figure-caption">Report ID: ' + checkIfStringExist(val.case_number) + '</figcaption>';
                    l += '        <div class="figure-content p-3">';

                    l += '            <div class="row">';
                    l += '                <div class="col-3">';
                    l += '                    <span class="input-tite">Employer Name:</span>';
                    l += '                </div>';
                    l += '                <div class="col-9">';
                    if (val.rel_emp_check == '1') {
                        l += '                    <span  class="case-agency_name pl-1">' + checkIfStringExist(val.employer_name) + ' <i class="fas fa-check-circle text-success"></i> </span>';
                    } else {
                        l += '                    <span  class="case-agency_name pl-1">' + checkIfStringExist(val.employer_name) + ' </span>';
                    }
                    l += '                </div>';
                    l += '            </div>';

                    l += '            <div class="row">';
                    l += '                <div class="col-3">';
                    l += '                    <span class="input-tite">Local Agency Name:</span>';
                    l += '                </div>';
                    l += '                <div class="col-9">';
                    if (val.rel_agency_check == '1') {
                        l += '                    <span  class="case-agency_name pl-1">' + checkIfStringExist(val.recruitment_agency_local_name) + ' <i class="fas fa-check-circle text-success"></i> </span>';
                    } else {
                        l += '                    <span  class="case-agency_name pl-1">' + checkIfStringExist(val.recruitment_agency_local_name) + ' </span>';
                    }
                    l += '                </div>';
                    l += '            </div>';

                    l += '            <div class="row">';
                    l += '                <div class="col-3">';
                    l += '                    <span class="input-tite">Foreign Agency Name:</span>';
                    l += '                </div>';
                    l += '                <div class="col-9">';
                    l += '                    <span  class="case-agency_name pl-1">' + checkIfStringExist(val.recruitment_agency_foreign_name) + ' </span>';
                    l += '                </div>';
                    l += '            </div>';


                    l += '            <div class="row mt-2">';
                    l += '                <div class="col-6">';
                    l += '                    <span class="input-tite">Deployment Country: </span><br>';
                    if (val.rel_deployed_country_check == '1') {
                        l += '                    <span  class="case-agency_name pl-1">' + checkIfStringExist(val.country) + ' <i class="fas fa-check-circle text-success"> </i> </span>';
                    } else {
                        l += '                    <span  class="case-agency_name pl-1">' + checkIfStringExist(val.country) + ' </span>';
                    }
                    l += '                </div>';
                    l += '                <div class="col-6">';
                    l += '                    <span class="input-tite">Deployed Date:</span><br>';
                    if (val.rel_deployed_check == '1') {
                        l += '                    <span  class="case-agency_name pl-1">' + checkIfStringExist(val.case_victim_deployment_date) + '  <i class="fas fa-check-circle text-success"> </i></span>';
                    } else {
                        l += '                    <span  class="case-agency_name pl-1">' + checkIfStringExist(val.case_victim_deployment_date) + '  </span>';
                    }
                    l += '                </div>';
                    l += '            </div>';


                    l += '            <div class="row mt-2">';
                    l += '                <div class="col-6">';
                    l += '                    <span class="input-tite">Date Filed: </span><br>';
                    l += '                    <span  class="case-agency_name pl-1">' + checkIfStringExist(val.case_filled_date) + '  </span>';
                    l += '                </div>';
                    l += '                <div class="col-6">';
                    l += '                    <span class="input-tite">Filed by:</span><br>';
                    l += '                    <span  class="case-agency_name pl-1">' + checkIfStringExist(val.filed_by_agency) + '  </span>';
                    l += '                </div>';
                    l += '            </div>';

                    l += '            <div class="row mt-2">';
                    l += '                <div class="col-6">';
                    l += '                    <span class="input-tite">Date Complained: </span><br>';
                    l += '                    <span  class="case-agency_name pl-1">' + checkIfStringExist(val.case_complainant_date_complained) + '  </span>';
                    l += '                </div>';
                    l += '                <div class="col-6">';
                    l += '                    <span class="input-tite">Complained by:</span><br>';
                    l += '                    <span  class="case-agency_name pl-1">' + checkIfStringExist(val.case_complainant_name) + '  </span>';
                    l += '                </div>';
                    l += '            </div>';

                    l += '            <div class="row mt-2">';
                    l += '                <div class="col-12">';
                    l += '                    <span class="input-tite">Filing Agency: </span><br>';
                    l += '                    <span  class="case-agency_name pl-1">' + checkIfStringExist(val.encoded_agency_name) + ' (' + checkIfStringExist(val.encoded_agency_branch_name) + ')  </span>';
                    l += '                </div>';
                    l += '            </div>';

                    l += '        </div>';
                    l += '    </figure>';
                    l += '</div>   ';
                });
                $('#v-case-list').html(l);

            }

            icmsMessage({
                type: 'msgPreloader',
                visible: false
            });

            // open modal
            $('#mdl-victim-details').modal('show');

        }, 'json');
    });


});

