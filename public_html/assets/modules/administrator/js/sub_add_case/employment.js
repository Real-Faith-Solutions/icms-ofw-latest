// #### ICMS IACAT START ####
// function getCountryISO() {
//     $.post(sAjaxGlobalData, {
//         type: "getCountryISO"
//     }, function (rs) {
//         l = "<option value='' selected>Select Country</option>";
//         $.each(rs.data.country, function (key, val) {
//             l += "<option value='" + val.country_id + "' data-currency='" + val.currency_iso + "' data-name='" + val.country_name + "'>" + val.country_name + " </option>";
//         });
//         $('#emp-sel-eet-country').html(l);
//         $('#emp-sel-eer-country').html(l);
//         $('#emp-sel-actual-country').html(l);
//         $('#emp-sel-country-dest').html(l);
//         $('#emp-sel-Transit-country').html(l);
//         $('#up-emp-sel-Transit-country').html(l);

//         // inserted class 
//         $('.employers_country').html(l);

//         var iso = l = "<option value='' selected>Select Currency</option>";
//         $.each(rs.data.currency, function (key, val) {
//             iso += "<option value='" + val.currency_iso + "'>" + val.currency_iso + " </option>";
//         });
//         $('#emp-sel-eet-currency').html(iso);
//         $('#emp-sel-eer-currency').html(iso);
//         $('#emp-sel-actual-currency').html(iso);

//     }, 'json');
// }

// function getEmploymentType() {
//     $.post(sAjaxGlobalData, {
//         type: "getEmploymentType"
//     }, function (rs) {
//         l = "<option value='0' selected>Select Employment</option>";
//         $.each(rs.data, function (key, val) {
//             l += "<option value='" + val.parameter_count_id + "' data-name='" + val.parameter_name + "'>" + val.parameter_name + " </option>";
//         });
//         $('#emp-sel-employment-type').html(l);
//     }, 'json');
// }

// function getDepartureType() {
//     $.post(sAjaxGlobalData, {
//         type: "getDepartureType"
//     }, function (rs) {
//         l = "<option class='pl' value='0' selected>Select Departure Type</option>",
//                 other = "";
//         $.each(rs.data, function (key, val) {
//             var x = val.parameter_name;
//             if (x.toLowerCase() == "other") {
//                 other = "<option value='" + val.parameter_count_id + "' data-name='" + val.parameter_name + "'>" + val.parameter_name + " </option>";
//             } else {
//                 l += "<option value='" + val.parameter_count_id + "' data-name='" + val.parameter_name + "'>" + val.parameter_name + " </option>";
//             }
//         });
//         if (other != "") {
//             l += other;
//         }
//         $('#emp-sel-departure').html(l);
//         $('#v_emp-sel-departure').html(l);
//         $('#v_emp-sel-departure .pl').attr("value", "");
//     }, 'json');
// }

// function getPortOfExit() {
//     $.post(sAjaxGlobalData, {
//         type: "getPhilippinePort"
//     }, function (rs) {
//         l = "<option value='0' selected>Select Port</option>", other = "";
//         $.each(rs.data, function (key, val) {
//             var x = val.port_name;
//             if (x) {
//                 if (x.toLowerCase() == "other") {
//                     other = "<option value='" + val.port_id + "' data-name='" + val.port_name + "'>" + val.port_name + " </option>";
//                 } else {
//                     l += "<option value='" + val.port_id + "' data-name='" + val.port_name + "'>" + val.port_name + " </option>";
//                 }
//             }
//         });
//         if (other != "") {
//             l += other;
//         }
//         $('#emp-sel-port_of_exit').html(l);
//     }, 'json');
// }

// function getVisaCategory() {
//     $.post(sAjaxGlobalData, {
//         type: "getVisaCategory"
//     }, function (rs) {
//         l = "<option value='0' selected>Select Visa Category</option>";
//         $.each(rs.data, function (key, val) {
//             l += "<option value='" + val.parameter_count_id + "' data-name='" + val.parameter_name + "'>" + val.parameter_name + " </option>";
//         });
//         $('#emp-sel-visa').html(l);
//     }, 'json');
// }

// function getGender() {
//     $.post(sAjaxGlobalData, {
//         type: "getSex"
//     }, function (rs) {
//         l = "<option value='' selected>Select Sex</option>";
//         $.each(rs.data, function (key, val) {
//             l += "<option value='" + val.parameter_count_id + "' data-name='" + val.parameter_name + "'>" + val.parameter_name + " </option>";
//         });

//         $('#emp-sel-sex').html(l);
//     }, 'json');
// }

// function getCvlStatus() {
//     $.post(sAjaxGlobalData, {
//         type: "getCivilStatus"
//     }, function (rs) {
//         l = "<option value='' selected>Select Civil Status</option>";
//         $.each(rs.data, function (key, val) {
//             l += "<option value='" + val.parameter_count_id + "' data-name='" + val.parameter_name + "'>" + val.parameter_name + " </option>";
//         });
//         $('#emp-sel-civil').html(l);
//     }, 'json');
// }

// function getProvinceList() {
//     $.post(sAjaxGlobalData, {
//         type: "getProvinces"
//     }, function (rs) {

//         l = "<option value='' selected>Select Province</option>";
//         $.each(rs.data, function (key, val) {
//             l += "<option value='" + val.location_count_id + "' data-name='" + val.location_name + "'>" + val.location_name + " </option>";
//         });
//         $('#emp-sel-province').html(l);
//     }, 'json');
// }

// function getCitiesByProvinceID(id) {
//     $.post(sAjaxGlobalData, {
//         type: "getCityByProvinceID",
//         province_id: id
//     }, function (rs) {
//         l = "<option value='' selected>Select City</option>";
//         $.each(rs.data, function (key, val) {
//             if (val.location_count_id) {
//                 l += "<option value='" + val.location_count_id + "' data-name='" + val.location_name + "'>" + val.location_name + " </option>";
//             }
//         });
//         $('#emp-sel-city').html(l);
//     }, 'json');
// }


// function storeVictimTransitInfoById() {
//     var storage = _getStorageData('victim_transit_info');
//     if (!storage) {

//         var victim_transit_info = [{
//                 'country_id': $('#emp-sel-Transit-country').val(),
//                 'country': $('#emp-sel-Transit-country option:selected').text(),
//                 'city': $('.emp-txt-tansit-city').val(),
//                 'departure': $('.emp-txt-tansit-depart-date').val(),
//                 'arrival': $('.emp-txt-tansit-arrival-date').val(),
//                 'remarks': $('.emp-txt-transit-remarks').val()
//             }];

//         _setStorageData(victim_transit_info, 'victim_transit_info');
//     } else {
//         var victim_transit_info = {
//             'country_id': $('#emp-sel-Transit-country').val(),
//             'country': $('#emp-sel-Transit-country option:selected').text(),
//             'city': $('.emp-txt-tansit-city').val(),
//             'departure': $('.emp-txt-tansit-depart-date').val(),
//             'arrival': $('.emp-txt-tansit-arrival-date').val(),
//             'remarks': $('.emp-txt-transit-remarks').val()
//         };

//         storage.push(victim_transit_info);

//         _setStorageData(storage, 'victim_transit_info');

//     }
//     $('#modal-transit-country').modal('hide');
//     $("#modal-msgmodal").modal('hide');
//     $('#form-add_layover_info')[0].reset();

//     getTransitCountryInfoList();

// }

// function getTransitCountryInfoList() {

//     var transit = _getStorageData('victim_transit_info');

//     var cnt = 0;
//     var t = '';
//     if (transit.length > 0) {
//         $.each(transit, function (key, val) {

//             t += '<tr>';
//             t += '<td data-country-id="' + val.country_id + '">' + val.country + '</td>';
//             t += '<td>' + val.city + '</td>';
//             t += '<td>' + val.arrival + '</td>';
//             t += '<td>' + val.departure + '</td>';
//             t += '<td> <div class="btn-group ellipse-action" data-id="vi-address_info_list2' + cnt + '" data-tab="">';
//             t += '<a class="a-ellipse a-ellipse-vi-address_info_list2' + cnt + ' " >  <i class="fa fa-ellipsis-v" aria-hidden="true"></i> </a>';
//             t += '<div class="action-menu" id="vi-address_info_list2' + cnt + '">';
//             t += '<a class="dropdown-item disabled action-title" href="#">Select Action</a>';
//             t += '<a class="dropdown-item up-victim_transit_info" data-id="' + cnt + '" >Update</a>';
//             t += '<a class="dropdown-item rm-victim_transit_info" data-id="' + cnt + '" >Remove</a>';
//             t += '</div>';
//             t += '</div> </td>';
//             t += '</tr>';

//             cnt++;
//         });
//     } else {
//         t += '<tr>';
//         t += '  <td colspan="5" style="text-align: center !important;">No transit info added to list.</td>';
//         t += '</tr>';
//     }

//     if (transit.length >= 10) {
//         $('.btn-add_layover').attr('disabled', true);
//     } else {
//         $('.btn-add_layover').attr('disabled', false);
//     }

//     $('.tbl-transit-list').html(t);
// }

// function storeEmploymentDetails() {

    //store victim employment information
    // var victim_employment_info = {
    //     'is_documented': $("input[name='is_employment_documented']:checked").val(),
    //     'employment_type': $("input[name='is_employment_documented']:checked").val(),
    //     'employment_type_value': $('.emp-employment_type option:selected').attr('data-name'),
    //     'country': $('#emp-sel-eet-country').val(),
    //     'city': $('#emp-sel-eet-city').val(),
    //     'currency': $('#emp-sel-eet-currency').val(),
    //     'salary': $('#emp-salary').val(),
    //     'salary_in_peso': $('#emp-salary_in_peso').val(),
    //     'position': $('#emp-position').val(),
    //     'days_of_work': $('#emp-days_of_work').val(),
    //     'working_hours': $('#emp-working_hours').val(),
    //     'act_country': $('#emp-sel-eer-country').val(),
    //     'act_city': $('#emp-sel-eer-city').val(),
    //     'act_currency': $('#emp-sel-eer-currency').val(),
    //     'act_salary': $('.emp-act_salary').val(),
    //     'act_salary_in_peso': $('.emp-act_salary_in_peso').val(),
    //     'act_position': $('.emp-act_position').val(),
    //     'act_days_of_work': $('.emp-act_days_of_work').val(),
    //     'act_working_hours': $('.emp-act_working_hours').val()
    // };

    // var victim_employer_details = {
    //     'employer_id': $('.emp-employer_name ').attr('data-id'),
    //     'employer_name': $('.emp-employer_name').val(),
    //     'employer_representative': $('.emp-employer_representative').val(),
    //     'employer_telephone': $('.emp-employer_telephone').val(),
    //     'employer_email': $('.emp-employer_email').val(),
    //     'employer_country': $('.emp-employer_country').val(),
    //     'employer_city': $('.emp-employer_city').val(),
    //     'employer_address': $('.emp-employer_address').val()
    // };

    // var victim_recruitment_details = {

        // Local Recruitment Information 
        // 'local_agency_id': $('.emp-local_agency_name').attr('data-id'),
        // 'local_agency_name': $('.emp-local_agency_name').val(),
        // 'local_agency_region': $('.emp-local_agency_region').val(),
        // 'local_agency_province': $('.emp-local_agency_province').val(),
        // 'local_agency_country': '173',
        // 'local_agency_address': $('.emp-local_agency_address').val(),
        // 'local_agency_telephone': $('.emp-local_agency_telephone').val(),
        // 'local_agency_email': $('.emp-local_agency_email').val(),
        // 'local_agency_fax': $('.emp-local_agency_fax').val(),
        // 'local_agency_website': $('.emp-local_agency_website').val(),

        // Local Recruitment Owner Information 
        // 'local_agency_owner_name': $('.emp-local_agency_owner_name').val(),
        // 'local_agency_owner_address': $('.emp-local_agency_owner_address').val(),
        // 'local_agency_owner_contact': $('.emp-local_agency_owner_contact').val(),

        // Local Recruitment Agent Information 
        // 'local_agency_agent_name': $('.emp-local_agency_agent_name').val(),
        // 'local_agency_agent_address': $('.emp-local_agency_agent_address').val(),
        // 'local_agency_agent_contact': $('.emp-local_agency_agent_contact').val(),

        // Local Recruitment Representative Information 
        // 'local_agency_rep_name': $('.emp-local_agency_rep_name').val(),
        // 'local_agency_rep_address': $('.emp-local_agency_rep_address').val(),
        // 'local_agency_rep_contact': $('.emp-local_agency_rep_contact').val(),

        // Foreign Recruitment Information 
        // 'foreign_agency_id': $('.emp-foreign_agency_name').attr('data-id'),
        // 'foreign_agency_name': $('.emp-foreign_agency_name').val(),
        // 'foreign_agency_country': $('.emp-foreign_agency_country').val(),
        // 'foreign_agency_address': $('.emp-foreign_agency_address').val(),
        // 'foreign_agency_telephone': $('.emp-foreign_agency_telephone').val(),
        // 'foreign_agency_email': $('.emp-foreign_agency_email').val(),
        // 'foreign_agency_fax': $('.emp-foreign_agency_fax').val(),
        // 'foreign_agency_website': $('.emp-foreign_agency_website').val(),

        // Foreign Recruitment Owner Information 
        // 'foreign_agency_owner_name': $('.emp-foreign_agency_owner_name').val(),
        // 'foreign_agency_owner_address': $('.emp-foreign_agency_owner_address').val(),
        // 'foreign_agency_owner_contact': $('.emp-foreign_agency_owner_contact').val(),

        // Foreign Recruitment Representative Information 
    //     'foreign_agency_rep_name': $('.emp-foreign_agency_rep_name').val(),
    //     'foreign_agency_rep_address': $('.emp-foreign_agency_rep_address').val(),
    //     'foreign_agency_rep_contact': $('.emp-foreign_agency_rep_contact').val()

    // };

    // var victim_passport_details = {
    //     'passport_no': $('.emp-passport_no').val(),
    //     'passport_first_name': $('.emp-passport_first_name').val(),
    //     'passport_middle_name': $('.emp-passport_middle_name').val(),
    //     'passport_last_name': $('.emp-passport_last_name').val(),
    //     'passport_suffix': $('.emp-passport_suffix').val(),
    //     'passport_sex': $('.emp-passport_sex').val(),
    //     'passport_civil': $('.emp-passport_civil').val(),
    //     'passport_dob': $('.emp-passport_dob').val(),
    //     'passport_province': $('.emp-passport_province').val(),
    //     'passport_city': $('.emp-passport_city').val(),
    //     'passport_place_issue': $('.emp-passport_place_issue').val(),
    //     'passport_date_issued': $('.emp-passport_date_issued').val(),
    //     'passport_date_expired': $('.emp-passport_date_expired').val()
    // };

    // var victim_deployment_details = {
    //     'deployment_document_is_falsified': $('.emp-deployment_document_is_falsified').prop("checked"),
    //     'deployment_departure_type': $('.emp-deployment_departure_type').val(),
    //     'deployment_departure_type_value': $('.emp-deployment_departure_type option:selected').attr('data-name'),
    //     'deployment_escort_name': $('.emp-deployment_escort_name').val(),
    //     'deployment_escort_description': $('.emp-deployment_escort_description').val(),
    //     'port_of_exit': $('.emp-port_of_exit').val(),
    //     'port_of_exit_value': $('.emp-port_of_exit option:selected').attr('data-name'),
    //     'port_of_exit_description': $('.emp-port_of_exit_description').val(),
    //     'deployment_visa_category': $('.emp-deployment_visa_category').val(),
    //     'deployment_visa_category_value': $('.emp-deployment_visa_category option:selected').attr('data-name'),
    //     'deployment_country': $('.emp-deployment_country').val(),
    //     'deployment_country_value': $('.emp-deployment_country option:selected').attr('data-name'),
    //     'deployment_date': $('.emp-deployment_date').val(),
    //     'deployment_arrival_date': $('.emp-deployment_arrival_date').val(),
    //     'deployment_remark': $('.emp-deployment_remark').val()
    // };



    // _setStorageData(victim_employment_info, 'victim_employment_info');

    // _setStorageData(victim_employer_details, 'victim_employer_details');

    // _setStorageData(victim_recruitment_details, 'victim_recruitment_details');

    // _setStorageData(victim_passport_details, 'victim_passport_details');

    // _setStorageData(victim_deployment_details, 'victim_deployment_details');

//    $('#case-details-tab1').trigger('click');
//
//    //enable case details tab
//    $('#case-details-tab1').attr('disabled', false);

// }

// function getVictimEmploymentInfo() {

//     var storages = ['victim_employment_info',
//         'victim_employer_details',
//         'victim_recruitment_details',
//         'victim_passport_details',
//         'victim_deployment_details'];

//     $.each(storages, function (key, val) {
//         var data = _getStorageData(val);
//         $.each(data, function (key, val) {
//             $(".emp-" + key).val(val);
//         });
//     });

//     //set attr data-id 
//     var aEmpDetail = _getStorageData('victim_employer_details');
//     var aAgencyDetail = _getStorageData('victim_recruitment_details');
//     $('.emp-foreign_agency_name').attr('data-id', aAgencyDetail.foreign_agency_id);
//     $('.emp-local_agency_name').attr('data-id', aAgencyDetail.local_agency_id);
//     $('.emp-employer_name ').attr('data-id', aEmpDetail.employer_id);

//     $('.emp-deployment_departure_type').change();
//     $('.emp-port_of_exit').change();

//     var data = _getStorageData('victim_deployment_details');

//     if (data.deployment_document_is_falsified) {
//         $('.emp-deployment_document_is_falsified').click();
//     }

//     var data = _getStorageData('victim_employment_info');

//     if (data.is_documented) {
//         $('.emp-is_documented').click();
//     }

// }

// function getStatesByCountryID(id) {
//     var type = "getProvinces";
//     if (id !== "173") {
//         type = "getStatesByCountryID";
//     }
//     $.post(sAjaxGlobalData, {
//         type: type,
//         id: id,
//     }, function (rs) {
//         l = "";
//         l += "<option value='' selected disabled>Select State/City </option>";
//         $.each(rs.data, function (key, val) {
//             l += "<option value='" + val.location_count_id + "'>" + val.location_name + " </option>";
//         });

//         return l;

//     }, 'json');
// }

// function getLocalRecruitmentByKeyword() {

//     $('.emp-local_agency_name').attr('data-id', 0);

//     var keyword = $('.emp-local_agency_name').val();

//     $.post(sAjaxRecruitment, {
//         type: 'getLocalRecruitmentByKeyword',
//         keyword: keyword,
//     }, function (rs) {

//         if (rs.data.flag != '0') {
//             $('#ra-local-search').show();
//             var l = '';
//             $.each(rs.data.list, function (key, val) {
//                 l += " <li class='list-group-item' data-id='" + val.recruitment_agency_id + "'> " + val.recruitment_agency_name + "</li>";
//             });
//             $('#ra-local-search').html(l);
//         } else {
//             $('#ra-local-search').hide();
//         }
//     }, 'json');
// }

// function getForeignRecruitmentByKeyword() {

//     $('.emp-foreign_agency_name').attr('data-id', 0);

//     var keyword = $('.emp-foreign_agency_name').val();
//     $.post(sAjaxRecruitment, {
//         type: 'getForeignRecruitmentByKeyword',
//         keyword: keyword,
//     }, function (rs) {

//         if (rs.data.flag != '0') {
//             $('#ra-foreign-search').show();
//             var l = '';
//             $.each(rs.data.list, function (key, val) {
//                 l += " <li class='list-group-item' data-id='" + val.recruitment_agency_id + "'> " + val.recruitment_agency_name + "</li>";
//             });
//             $('#ra-foreign-search').html(l);
//         } else {
//             $('#ra-foreign-search').hide();
//         }
//     }, 'json');
// }


// function getRecruitmentDetailsByID(id, type_id) {

//     $.post(sAjaxRecruitment, {
//         type: 'getRecruitmentDetailsByID',
//         id: id,
//     }, function (rs) {
//         var res = rs.data.details;
//         if (rs.data.result != '0') {
//             var sType = 'foreign';

//             if (type_id == '1') {

                // for local only
                // sType = 'local';

                // for region id 
                // $('.emp-local_agency_region').val(res.region_id).change();

                // set time for half second 
                // setTimeout(function () {
                //     $('.emp-local_agency_province').val(res.province_id).change();
                // }, 500);

            //     $('.emp-local_agency_name').attr('data-id', res.recruitment_agency_id);
            // } else {
                // for foreign only 
            //     $('.emp-' + sType + '_agency_country').val(res.country_id);
            //     $('.emp-foreign_agency_name').attr('data-id', res.recruitment_agency_id);
            // }

            // agencies information 
            // $('.emp-' + sType + '_agency_name').val(res.recruitment_agency_name);
            // $('.emp-' + sType + '_agency_address').val(res.recruitment_agency_address);
            // $('.emp-' + sType + '_agency_email').val(res.recruitment_agency_email);
            // $('.emp-' + sType + '_agency_telephone').val(res.recruitment_agency_tel_no);
            // $('.emp-' + sType + '_agency_fax').val(res.recruitment_agency_fax_no);
            // $('.emp-' + sType + '_agency_website').val(res.recruitment_agency_website);


            // owners information 
            // if (res.owner_details !== "") {
            //     $('.emp-' + sType + '_agency_owner_name').val(res.owner_details.recruitment_agency_info_name);
            //     $('.emp-' + sType + '_agency_owner_address').val(res.owner_details.recruitment_agency_info_address);
            //     $('.emp-' + sType + '_agency_owner_contact').val(res.owner_details.recruitment_agency_info_contact_number);
            // }

            //agent information 
            // if (res.agent_details !== "") {
            //     $('.emp-' + sType + '_agency_agent_name').val(res.agent_details.recruitment_agency_info_name);
            //     $('.emp-' + sType + '_agency_agent_address').val(res.agent_details.recruitment_agency_info_address);
            //     $('.emp-' + sType + '_agency_agent_contact').val(res.agent_details.recruitment_agency_info_contact_number);
            // }

            // representative information 
//             if (res.rep_details !== "") {
//                 $('.emp-' + sType + '_agency_rep_name').val(res.rep_details.recruitment_agency_info_name);
//                 $('.emp-' + sType + '_agency_rep_address').val(res.rep_details.recruitment_agency_info_address);
//                 $('.emp-' + sType + '_agency_rep_contact').val(res.rep_details.recruitment_agency_info_contact_number);
//             }
//         }

//     }, 'json');
// }

// function clearRecruitmentAgency(type_id) {

//     var sType = 'foreign';

//     if (type_id == '1') {

        // for local only
        // sType = 'local';

        // for region id 
        // $('.emp-local_agency_region').val('').change();
        // $('.emp-local_agency_province').val('').change();
        // $('.emp-local_agency_province').prop('disabled', 'disabled');

        // $('.emp-local_agency_name').val('');
        // $('.emp-local_agency_name').attr('data-id', '0');

    // } else {
        // for foreign only 
    //     $('.emp-' + sType + '_agency_country').val('').change();
    //     $('.emp-foreign_agency_name').val('');
    //     $('.emp-foreign_agency_name').attr('data-id', '0');
    // }

    // agencies information 
    // $('.emp-' + sType + '_agency_name').val('');
    // $('.emp-' + sType + '_agency_address').val('');
    // $('.emp-' + sType + '_agency_email').val('');
    // $('.emp-' + sType + '_agency_telephone').val('');
    // $('.emp-' + sType + '_agency_fax').val('');
    // $('.emp-' + sType + '_agency_website').val('');


    // owners information 
    // $('.emp-' + sType + '_agency_owner_name').val('');
    // $('.emp-' + sType + '_agency_owner_address').val('');
    // $('.emp-' + sType + '_agency_owner_contact').val('');


    //agent information 
    // $('.emp-' + sType + '_agency_agent_name').val('');
    // $('.emp-' + sType + '_agency_agent_address').val('');
    // $('.emp-' + sType + '_agency_agent_contact').val('');


    // representative information 
//     $('.emp-' + sType + '_agency_rep_name').val('');
//     $('.emp-' + sType + '_agency_rep_address').val('');
//     $('.emp-' + sType + '_agency_rep_contact').val('');


// }


// function getEmployerByKeyword() {
//     $('.emp-employer_name').attr('data-id', 0);
//     var keyword = $('.emp-employer_name').val();
//     $.post(sAjaxEmployer, {
//         type: 'getEmployerByKeyword',
//         keyword: keyword,
//     }, function (rs) {

//         if (rs.data.flag != '0') {
//             $('#employer-search').show();
//             var l = '';
//             $.each(rs.data.list, function (key, val) {
//                 l += " <li class='list-group-item' data-id='" + val.employer_id + "'> " + val.employer_name + "</li>";
//             });
//             $('#employer-search').html(l);
//         } else {
//             $('#employer-search').hide();
//         }
//     }, 'json');
// }

// function getEmployerDetailsByID(id) {

//     $('.emp-employer_name').attr('data-id', id);

//     $.post(sAjaxEmployer, {
//         type: 'getEmployerDetailsByID',
//         employer_id: id,
//     }, function (rs) {
//         var res = rs.data.details;
//         if (rs.data.result != '0') {
//             $('.emp-employer_name').val(res.employer_name);
//             $('.emp-employer_representative ').val(res.employer_representative_name);
//             $('.emp-employer_telephone').val(res.employer_tel_no);
//             $('.emp-employer_email').val(res.employer_email);
//             $('.emp-employer_country').val(res.employer_country_id).change();
//             $('.emp-employer_city').val(res.employer_city);
//             $('.emp-employer_address').val(res.employer_full_address);
//         }
//     }, 'json');
// }

// function validateEmployerName() {
//     var bol = false;
//     $('.emp-employer_name').prop("required", false);
//    $('.error').remove();
//     var v_name = $('.emp-employer_name').val();
//     var inputs = $(".div-employer_form :input").map(function () {
//         return $(this).val();
//     }).get();

//     $.each(inputs, function (key, val) {
//         if ((val != "") && (v_name == "")) {
//             $('.emp-employer_name').prop("required", true);
//             bol = true;
//         }
//     });

//     return bol;
// }

// function validateLocalRecName() {
//     var bol = false;
//     $('.emp-local_agency_name').prop("required", false);
//    $('.error').remove();
//     var v_name = $('.emp-local_agency_name').val();
//     var inputs = $(".div-agency_local_form :input").map(function () {
//         return $(this).val();
//     }).get();
//     $.each(inputs, function (key, val) {
//         if ((val != "") && (v_name == "")) {
//             $('.emp-local_agency_name').prop("required", true);
//             bol = true;
//         }
//     });
//     return bol;
// }

// function validateForeignRecName() {
//     var bol = false;
//     $('.emp-foreign_agency_name').prop("required", false);
//    $('.error').remove();
//     var v_name = $('.emp-foreign_agency_name').val();
//     var inputs = $(".div-agency_foreign_form :input").map(function () {
//         return $(this).val();
//     }).get();
//     $.each(inputs, function (key, val) {
//         if ((val != "") && (v_name == "")) {
//             $('.emp-foreign_agency_name').prop("required", true);
//             bol = true;
//         }
//     });
//     return bol;
// }

// function validateEmploymentNames() {

//     $message = "";
//     $message = (validateEmployerName() == true) ? "" : "Employer name is required";
//     if ((validateEmployerName() == true) || (validateLocalRecName() == true) || (validateForeignRecName() == true)) {
//         return false
//     } else {
//         return true
//     }
// }

// function clearEmployerDetails() {
//     $('.emp-employer_name').attr('data-id', '0');
//     $('.emp-employer_name').val('');
//     $('.emp-employer_representative ').val('');
//     $('.emp-employer_telephone').val('');
//     $('.emp-employer_email').val('');
//     $('.emp-employer_country').val('');
//     $('.emp-employer_city').val('');
//     $('.emp-employer_address').val('');
// }


// $(document).ready(function () {

//     getCountryISO();
//     getEmploymentType();
//     getDepartureType();
//     getPortOfExit();
//     getVisaCategory();
//     getGender();
//     getCvlStatus();
//     getProvinceList();
//     getTransitCountryInfoList();
//     getActiveOccupations();     

    // ***** disable forms *****
    // employer 
    // $(".div-employer_form :input").prop("disabled", true);
    // local agency 
    // $(".div-agency_local_form :input").prop("disabled", true);
    // recruitment agency 
    // $(".div-agency_foreign_form :input").prop("disabled", true);

    // $(".emp-similar_to_victim").click(function () {
    //     var is_checked = $(this).is(":checked");
    //     if (is_checked) {
    //         var data = _getStorageData('victim_personal_info');
    //         if (data) {
    //             $.each(data, function (k, v) {
    //                 $('.emp-passport_' + k).val(v);
    //             });
    //             $('.emp-passport_province').val(data.pob);
    //             $('.emp-passport_province').change();
    //         }
    //     }
    // });
    // $('.emp-deployment_departure_type').change(function () {

    //     var o = $(this).val();
        // reset fields 
        // $('.f-dp_type_others').hide();
        // $('.emp-deployment_remark').val('');
        // $('.f-escort_name').hide();
        // $('.emp-deployment_escort_name').val('');
        // $('.f-escort_description').hide();
        // $('.emp-deployment_escort_description').val('');
        // $('.lbl-emp_deployment_date').html("Date of Deployment");
        // $('.div-deployment_arrival_date').show();
        // switch (o) {
        //     case '2':
                // escorted
            //     $('.f-escort_name').show();
            //     $('.f-escort_description').show();
            //     break;
            // case '4':
                // others
            //     $('.f-dp_type_others').show();
            //     $('.lbl-emp_deployment_date').html("Date");
            //     $('.div-deployment_arrival_date').hide();
            //     break;
            // case '3':
                // Deffered
    //             $('.lbl-emp_deployment_date').html("Date of deferred departure");
    //             $('.div-deployment_arrival_date').hide();
    //             break;
    //     }
    // });
    // $('.emp-port_of_exit').change(function () {
    //     var o = $(this).val();
    //     //other
    //     if (o == 1) {
    //         $('.f-poe_description').show();
    //     } else {
    //         $('.f-poe_description').hide();
    //         $('.emp-port_of_exit_description').val('');
    //     }
    // });


    // $.validator.addMethod("checkDeployment", function (value, element) {
    //     var a = new Date(value);
    //     var b = new Date($("#emp_deployment_date").val());
    //     if (a >= b) {
    //         return true;
    //     }
    //     if (!value) {
    //         return true;
    //     }
    // }, "Arrival date cannot be less than deployment date");

    // $.validator.addMethod("checkDeploymentTransit", function (value, element) {
    //     var a = new Date(value);
    //     var b = new Date($("#date_timepicker_start").val());
    //     if (a >= b) {
    //         return true;
    //     }
    //     if (!value) {
    //         return true;
    //     }
    // }, "Departure date cannot be less than arrival date");


    // $.validator.addMethod("checkPDateExpired", function (value, element) {
    //     var a = new Date(value);
    //     var b = new Date($("#emp_passport_date_issued").val());
    //     if (a > b) {
    //         return true;
    //     }
    //     if (!value) {
    //         return true;
    //     }

    // }, "Expiration cannot be less than the date issued.");


    // $("#form-update_employment_info").validate({
    //     rules: {
    //         employer_telephone: {minlength: 7},
    //         employer_email: {email: true},
    //         local_recruitment_email: {email: true},
    //         local_recruitment_phone: {minlength: 7},
    //         local_recruitment_owner_contact: {minlength: 7},
    //         foreign_recruitment_email: {email: true},
    //         foreign_recruitment_phone: {minlength: 7},
    //         foregin_recruitment_owner_contact: {minlength: 7},
    //         emp_passport_dob: {pastDateOptional: true},
    //         emp_passport_date_issued: {pastDateOptional: true},
            //emp_deployment_arrival_date: {pastDateNow: true, checkDeployment: true},
        //     emp_deployment_date: {pastDateNow: true},
        //     emp_passport_date_expired: {checkPDateExpired: true},
        //     emp_act_salary: {number: true},
        //     emp_act_salary_in_peso: {number: true},
        //     emp_act_days_of_work: {number: true},
        //     emp_act_working_hours: {number: true},
        //     emp_salary: {number: true},
        //     emp_salary_in_peso: {number: true},
        //     emp_days_of_work: {number: true},
        //     emp_working_hours: {number: true},
        //     emp_salary: {number: true},
        //     emp_local_agency_owner_contact: {number: true},
        //     emp_local_agency_rep_contact: {number: true},
        //     emp_local_agency_agent_contact: {number: true},
        //     emp_foreign_agency_owner_contact: {number: true},
        //     emp_foreign_agency_rep_contact: {number: true},
        //     emp_foreign_agency_owner_contact: {number: true},
        //     emp_foreign_agency_owner_contact: {number: true},
        //     emp_sel_departure: {required: true},
        //     emp_sel_eer_country: {required: true},
        // },
        // errorElement: 'div',
        // errorPlacement: function (error, element) {
        //     var placement = $(element).data('error');
        //     if (placement) {
        //         $(placement).append(error);
        //     } else {
        //         error.insertAfter(element);
        //     }
        // },
        // submitHandler: function (form) {

//            if (validateEmploymentNames() == true) {
//            storeEmploymentDetails();
//            $('.step-trigger').attr('disabled', true);
//            $('#case-details-tab1').attr('disabled', false);
//            $('#case-details-tab1').trigger('click');
//            returnTop();
//            } else {
//                $("#form-update_employment_info").submit();
//            }validateEmploymentNames


    //         var departure = $("#emp-sel-departure").val();
    //         var emp_sel_eer_country = $("#emp-sel-eer-country").val();
    //         if (departure == "0") {
    //             icmsMessage({
    //                 type: 'msgWarning',
    //                 body: '<center> Departure type is required. </center>',
    //                 caption: 'Close',
    //             });
    //         } else {

    //             if (emp_sel_eer_country == "") {
    //                 icmsMessage({
    //                     type: 'msgWarning',
    //                     body: '<center>Country of deployment (Based on contract) in employment details is required.</center>',
    //                     caption: 'Close',
    //                 });
    //             } else {
    //                 storeEmploymentDetails();
    //                 $('.step-trigger').attr('disabled', true);
    //                 $('#case-details-tab1').attr('disabled', false);
    //                 $('#case-details-tab1').trigger('click');
    //                 returnTop();
    //             }

    //         }

    //     }

    // });
    // $("#form-add_layover_info").validate({
    //     rules: {
    //         country: {required: true},
    //         emp_txt_tansit_arrival_date: {
    //             pastDateOptional: true,
    //         },
    //         emp_txt_tansit_depart_date: {
    //             pastDateOptional: true,
    //             checkDeploymentTransit: true
    //         }
    //     },
    //     errorElement: 'div',
    //     errorPlacement: function (error, element) {
    //         var placement = $(element).data('error');
    //         if (placement) {
    //             $(placement).append(error);
    //         } else {
    //             error.insertAfter(element);
    //         }
    //     },
    //     submitHandler: function (form) {
    //         var id = $('#form-add_layover_info').attr('stored-id');
    //         if (id == "") {
    //             storeVictimTransitInfoById();
    //         } else {
                // remove existing
                // var storage = _getStorageData('victim_transit_info');
                // _rmStorageDataById(storage, storage[id]);
                // _setStorageData(storage, 'victim_transit_info');
                //add new transit details
                // getTransitCountryInfoList();
                //load list
                // storeVictimTransitInfoById();
    //         }
    //     }

    // });
    // $('#emp-sel-eet-country').change(function () {
    //     var curr = $(this).find(':selected').attr('data-currency');
    //     var country_id = $(this).val();
    //     $('#emp-sel-eet-currency').val(curr).change();
    //     $('#emp-sel-eet-currency').find(':selected').attr('country_id', country_id);
    //     var l = getStatesByCountryID(country_id);
    //     $('#emp-sel-eet-city').html(l);
    // });
    // $('#emp-sel-eer-country').change(function () {
    //     var curr = $(this).find(':selected').attr('data-currency');
    //     var country_id = $(this).val();
    //     $('#emp-sel-eer-currency').val(curr).change();
    //     $('#emp-sel-eer-currency').find(':selected').attr('country_id', country_id);
    //     var l = getStatesByCountryID(country_id);
    //     $('#emp-sel-eer-city').html(l);
    // });
    // $('#emp-sel-actual-country').change(function () {
    //     var curr = $(this).find(':selected').attr('data-currency');
    //     var country_id = $(this).val();
    //     $('#emp-sel-actual-currency').val(curr).change();
    //     $('#emp-sel-actual-currency').find(':selected').attr('country_id', country_id);
    //     var l = getStatesByCountryID(country_id);
    //     $('#emp-sel-eet-city').html(l);
    // });
    // $('.btn-add_layover').click(function () {
    //     $('#form-add_layover_info').attr('stored-id', "");
    //     $("#modal-transit-country").modal('show');
    //     $('#modal-transit-country .modal-header_title').text('Add Transit Details');
    // });
    // $('#emp-sel-province').change(function () {
    //     var id = $(this).val();
    //     getCitiesByProvinceID(id);
    // });

    // $('.tbl-transit-list').delegate('.rm-victim_transit_info', 'click', function () {
    //     var id = $(this).attr('data-id');
    //     var storage = _getStorageData('victim_transit_info');
    //     icmsMessage({
    //         type: 'msgConfirmation',
    //         title: 'You are about to remove an transit detail.',
    //         body: 'Click continue button if you wish to continue.',
    //         LblBtnConfirm: 'Continue',
    //         LblBtnCancel: 'Cancel',
    //         onConfirm: function () {
    //             _rmStorageDataById(storage, storage[id]);
    //             _setStorageData(storage, 'victim_transit_info');
    //             getTransitCountryInfoList();
    //         },
    //     });
    // });

    // $('.tbl-transit-list').delegate('.up-victim_transit_info', 'click', function () {
    //     $('#modal-transit-country .modal-header_title').text('Manage Transit Details');
    //     var id = $(this).attr('data-id');
    //     $('#form-add_layover_info').attr('stored-id', id);
    //     var x = _getStorageData('victim_transit_info');
    //     $.each(x[id], function (k, v) {
    //         if (k == "country_id") {
    //             $('#emp-sel-Transit-country').val(v).change();
    //         }
    //         if (k == "city") {
    //             $('.emp-txt-tansit-city').val(v);
    //         }
    //         if (k == "departure") {
    //             $('.emp-txt-tansit-depart-date').val(v);
    //         }
    //         if (k == "arrival") {
    //             $('.emp-txt-tansit-arrival-date').val(v);
    //         }
    //         if (k == "remarks") {
    //             $('.emp-txt-transit-remarks').val(v);
    //         }
    //     });
    //     $('#modal-transit-country').modal('show');
    // });
    // $('.employers_country').change(function () {
    //     var curr = $(this).find(':selected').attr('data-currency');
    //     var country_id = $(this).val();
    //     var l = getStatesByCountryID(country_id);
    //     $('.employers_city').html(l);
    // });
    // $('.emp-local_agency_region').change(function () {
    //     var region_id = $(this).val();
    //     getProvincesByRegionId(region_id);
    //     $('.emp-local_agency_province').removeAttr('disabled');
    // });

    // for search local recruitment 
    // $('.emp-local_agency_name').on('keyup', function (e) {
    //     var keyword = $(this).val();
    //     validateLocalRecName();
    //     setTimeout(function () {
    //         if (keyword.length) {
    //             getLocalRecruitmentByKeyword();
    //             $(".div-agency_local_form :input").prop("disabled", false);
    //         } else {
    //             $(".div-agency_local_form :input").prop("disabled", true);
    //         }
    //     }, 1000);
    // });

    // $(".emp-local_agency_name").focusout(function () {
    //     validateLocalRecName();
    // });

    // clear local recruitment details 
    // $('.emp-local_agency_name').click(function () {
    //     var id = $(this).attr('data-id');
    //     if (id != '0') {
    //         clearRecruitmentAgency(1);
    //     }
    // });
    // select local list list 
    // $('#ra-local-search').delegate('.list-group-item', 'click', function () {
    //     var id = $(this).attr('data-id');
    //     getRecruitmentDetailsByID(id, '1');
    // });
    // for search foreign recruitment 
    // $('.emp-foreign_agency_name').on('keyup', function (e) {
    //     var keyword = $(this).val();
    //     setTimeout(function () {
    //         if (keyword.length) {
    //             getForeignRecruitmentByKeyword();
    //             $(".div-agency_foreign_form :input").prop("disabled", false);
    //         } else {
    //             $(".div-agency_foreign_form :input").prop("disabled", true);
    //         }
    //     }, 1000);

    // });

    // $(".emp-foreign_agency_name").focusout(function () {
    //     validateForeignRecName();
    // });

    // clear local recruitment details 
    // $('.emp-foreign_agency_name').click(function () {
    //     var id = $(this).attr('data-id');
    //     if (id != '0') {
    //         clearRecruitmentAgency(2);
    //     }
    // });
    // select foreign list list 
    // $('#ra-foreign-search').delegate('.list-group-item', 'click', function () {
    //     var id = $(this).attr('data-id');
    //     getRecruitmentDetailsByID(id, '2');
    // });
    // for search employer 
    // $('.emp-employer_name').on('keyup', function (e) {
        // var keyword = $(this).val();
//        delay(function () {
//            if (keyword.length) {
//                getEmployerByKeyword();
//            }
//        }, 1000);
    //     setTimeout(function () {
    //         if (keyword.length) {
    //             getEmployerByKeyword();
    //             $(".div-employer_form :input").prop("disabled", false);
    //         } else {
    //             $(".div-employer_form :input").prop("disabled", true);
    //         }
    //     }, 1000);
    // });

    // $(".emp-employer_name").focusout(function () {
    //     validateEmployerName();
    // });

    // clear employer details 
    // $('.emp-employer_name').click(function () {
    //     var id = $(this).attr('data-id');
    //     if (id != '0') {
    //         clearEmployerDetails();
    //     }
    // });
    // select employer list 
//     $('#employer-search').delegate('.list-group-item', 'click', function () {
//         var id = $(this).attr('data-id');
//         getEmployerDetailsByID(id);
//     });
// });

// #### ICMS IACAT END ####

// -----####ICMS OSAEC START####-----

function getCountryISO() {
    $.post(sAjaxGlobalData, {
        type: "getCountryISO"
    }, function (rs) {
        l = "<option value='' selected>Select Country</option>";
        $.each(rs.data.country, function (key, val) {
            l += "<option value='" + val.country_id + "' data-currency='" + val.currency_iso + "' data-name='" + val.country_name + "'>" + val.country_name + " </option>";
        });
        $('#emp-sel-eet-country').html(l);
        $('#emp-sel-eer-country').html(l);
        $('#emp-sel-actual-country').html(l);
        $('#emp-sel-country-dest').html(l);
        $('#emp-sel-Transit-country').html(l);
        $('#up-emp-sel-Transit-country').html(l);

        // inserted class 
        $('.employers_country').html(l);

        var iso = l = "<option value='' selected>Select Currency</option>";
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
        l = "<option value='0' selected>Select Employment</option>";
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
        l = "<option class='pl' value='0' selected>Select Departure Type</option>",
                other = "";
        $.each(rs.data, function (key, val) {
            var x = val.parameter_name;
            if (x.toLowerCase() == "other") {
                other = "<option value='" + val.parameter_count_id + "' data-name='" + val.parameter_name + "'>" + val.parameter_name + " </option>";
            } else {
                l += "<option value='" + val.parameter_count_id + "' data-name='" + val.parameter_name + "'>" + val.parameter_name + " </option>";
            }
        });
        if (other != "") {
            l += other;
        }
        $('#emp-sel-departure').html(l);
        $('#v_emp-sel-departure').html(l);
        $('#v_emp-sel-departure .pl').attr("value", "");
    }, 'json');
}

function getPortOfExit() {
    $.post(sAjaxGlobalData, {
        type: "getPhilippinePort"
    }, function (rs) {
        l = "<option value='0' selected>Select Port</option>", other = "";
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
        if (other != "") {
            l += other;
        }
        $('#emp-sel-port_of_exit').html(l);
    }, 'json');
}

function getVisaCategory() {
    $.post(sAjaxGlobalData, {
        type: "getVisaCategory"
    }, function (rs) {
        l = "<option value='0' selected>Select Visa Category</option>";
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
        l = "<option value='' selected>Select Gender</option>";
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
        l = "<option value='' selected>Select Civil Status</option>";
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

        l = "<option value='' selected>Select Province</option>";
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
        l = "<option value='' selected>Select City</option>";
        $.each(rs.data, function (key, val) {
            if (val.location_count_id) {
                l += "<option value='" + val.location_count_id + "' data-name='" + val.location_name + "'>" + val.location_name + " </option>";
            }
        });
        $('#emp-sel-city').html(l);
    }, 'json');
}


function storeVictimTransitInfoById() {
    var storage = _getStorageData('victim_transit_info');
    if (!storage) {

        var victim_transit_info = [{
                'country_id': $('#emp-sel-Transit-country').val(),
                'country': $('#emp-sel-Transit-country option:selected').text(),
                'city': $('.emp-txt-tansit-city').val(),
                'departure': $('.emp-txt-tansit-depart-date').val(),
                'arrival': $('.emp-txt-tansit-arrival-date').val(),
                'remarks': $('.emp-txt-transit-remarks').val()
            }];

        _setStorageData(victim_transit_info, 'victim_transit_info');
    } else {
        var victim_transit_info = {
            'country_id': $('#emp-sel-Transit-country').val(),
            'country': $('#emp-sel-Transit-country option:selected').text(),
            'city': $('.emp-txt-tansit-city').val(),
            'departure': $('.emp-txt-tansit-depart-date').val(),
            'arrival': $('.emp-txt-tansit-arrival-date').val(),
            'remarks': $('.emp-txt-transit-remarks').val()
        };

        storage.push(victim_transit_info);

        _setStorageData(storage, 'victim_transit_info');

    }
    $('#modal-transit-country').modal('hide');
    $("#modal-msgmodal").modal('hide');
    $('#form-add_layover_info')[0].reset();

    getTransitCountryInfoList();

}

function getTransitCountryInfoList() {

    var transit = _getStorageData('victim_transit_info');

    var cnt = 0;
    var t = '';
    if (transit.length > 0) {
        $.each(transit, function (key, val) {

            t += '<tr>';
            t += '<td data-country-id="' + val.country_id + '">' + val.country + '</td>';
            t += '<td>' + val.city + '</td>';
            t += '<td>' + val.arrival + '</td>';
            t += '<td>' + val.departure + '</td>';
            t += '<td> <div class="btn-group ellipse-action" data-id="vi-address_info_list2' + cnt + '" data-tab="">';
            t += '<a class="a-ellipse a-ellipse-vi-address_info_list2' + cnt + ' " >  <i class="fa fa-ellipsis-v" aria-hidden="true"></i> </a>';
            t += '<div class="action-menu" id="vi-address_info_list2' + cnt + '">';
            t += '<a class="dropdown-item disabled action-title" href="#">Select Action</a>';
            t += '<a class="dropdown-item up-victim_transit_info" data-id="' + cnt + '" >Update</a>';
            t += '<a class="dropdown-item rm-victim_transit_info" data-id="' + cnt + '" >Remove</a>';
            t += '</div>';
            t += '</div> </td>';
            t += '</tr>';

            cnt++;
        });
    } else {
        t += '<tr>';
        t += '  <td colspan="5" style="text-align: center !important;">No transit info added to list.</td>';
        t += '</tr>';
    }

    if (transit.length >= 10) {
        $('.btn-add_layover').attr('disabled', true);
    } else {
        $('.btn-add_layover').attr('disabled', false);
    }

    $('.tbl-transit-list').html(t);
}

function storeEmploymentDetails() {

    //store victim employment information
    var victim_employment_info = {
        'is_documented': $("input[name='is_employment_documented']:checked").val(),
        'employment_type': $("input[name='is_employment_documented']:checked").val(),
        'employment_type_value': $('.emp-employment_type option:selected').attr('data-name'),
        'country': $('#emp-sel-eet-country').val(),
        'city': $('#emp-sel-eet-city').val(),
        'currency': $('#emp-sel-eet-currency').val(),
        'salary': $('#emp-salary').val(),
        'salary_in_peso': $('#emp-salary_in_peso').val(),
        'position': $('#emp-position').val(),
        'days_of_work': $('#emp-days_of_work').val(),
        'working_hours': $('#emp-working_hours').val(),
        'act_country': $('#emp-sel-eer-country').val(),
        'act_city': $('#emp-sel-eer-city').val(),
        'act_currency': $('#emp-sel-eer-currency').val(),
        'act_salary': $('.emp-act_salary').val(),
        'act_salary_in_peso': $('.emp-act_salary_in_peso').val(),
        'act_position': $('.emp-act_position').val(),
        'act_days_of_work': $('.emp-act_days_of_work').val(),
        'act_working_hours': $('.emp-act_working_hours').val()
    };

    var victim_employer_details = {
        'employer_id': $('.emp-employer_name ').attr('data-id'),
        'employer_name': $('.emp-employer_name').val(),
        'employer_representative': $('.emp-employer_representative').val(),
        'employer_telephone': $('.emp-employer_telephone').val(),
        'employer_email': $('.emp-employer_email').val(),
        'employer_country': $('.emp-employer_country').val(),
        'employer_city': $('.emp-employer_city').val(),
        'employer_address': $('.emp-employer_address').val()
    };

    var victim_recruitment_details = {

        // Local Recruitment Information 
        'local_agency_id': $('.emp-local_agency_name').attr('data-id'),
        'local_agency_name': $('.emp-local_agency_name').val(),
        'local_agency_region': $('.emp-local_agency_region').val(),
        'local_agency_province': $('.emp-local_agency_province').val(),
        'local_agency_country': '173',
        'local_agency_address': $('.emp-local_agency_address').val(),
        'local_agency_telephone': $('.emp-local_agency_telephone').val(),
        'local_agency_email': $('.emp-local_agency_email').val(),
        'local_agency_fax': $('.emp-local_agency_fax').val(),
        'local_agency_website': $('.emp-local_agency_website').val(),

        // Local Recruitment Owner Information 
        'local_agency_owner_name': $('.emp-local_agency_owner_name').val(),
        'local_agency_owner_address': $('.emp-local_agency_owner_address').val(),
        'local_agency_owner_contact': $('.emp-local_agency_owner_contact').val(),

        // Local Recruitment Agent Information 
        'local_agency_agent_name': $('.emp-local_agency_agent_name').val(),
        'local_agency_agent_address': $('.emp-local_agency_agent_address').val(),
        'local_agency_agent_contact': $('.emp-local_agency_agent_contact').val(),

        // Local Recruitment Representative Information 
        'local_agency_rep_name': $('.emp-local_agency_rep_name').val(),
        'local_agency_rep_address': $('.emp-local_agency_rep_address').val(),
        'local_agency_rep_contact': $('.emp-local_agency_rep_contact').val(),

        // Foreign Recruitment Information 
        'foreign_agency_id': $('.emp-foreign_agency_name').attr('data-id'),
        'foreign_agency_name': $('.emp-foreign_agency_name').val(),
        'foreign_agency_country': $('.emp-foreign_agency_country').val(),
        'foreign_agency_address': $('.emp-foreign_agency_address').val(),
        'foreign_agency_telephone': $('.emp-foreign_agency_telephone').val(),
        'foreign_agency_email': $('.emp-foreign_agency_email').val(),
        'foreign_agency_fax': $('.emp-foreign_agency_fax').val(),
        'foreign_agency_website': $('.emp-foreign_agency_website').val(),

        // Foreign Recruitment Owner Information 
        'foreign_agency_owner_name': $('.emp-foreign_agency_owner_name').val(),
        'foreign_agency_owner_address': $('.emp-foreign_agency_owner_address').val(),
        'foreign_agency_owner_contact': $('.emp-foreign_agency_owner_contact').val(),

        // Foreign Recruitment Representative Information 
        'foreign_agency_rep_name': $('.emp-foreign_agency_rep_name').val(),
        'foreign_agency_rep_address': $('.emp-foreign_agency_rep_address').val(),
        'foreign_agency_rep_contact': $('.emp-foreign_agency_rep_contact').val(),

        // employment local addLocalRecruitmentAgencyByManagePhilippines agency
        'employement_local_employment_type': $('.emp-type_of_employment').val(),
        'employement_local_child_case_type': $('.emp-type_of_child_cases').val(),
        'employement_local_agency_region': $('.emp-type_agency_region').val(),
        'employement_local_agency_region_type_value': $('.emp-type_agency_region').val(),
        'employement_local_agency_province': $('.local-type_agency_region').val(),
        'employement_local_agency_province_type_value': $('.local-type_agency_region').val(),
        'employement_local_agency_city': $('.local-type_agency_city').val(),
        'employement_local_agency_city_type_value': $('.local-type_agency_city').val(),
        


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
        'deployment_arrival_date': $('.emp-deployment_arrival_date').val(),
        'deployment_remark': $('.emp-deployment_remark').val()
    };



    _setStorageData(victim_employment_info, 'victim_employment_info');

    _setStorageData(victim_employer_details, 'victim_employer_details');

    _setStorageData(victim_recruitment_details, 'victim_recruitment_details');

    _setStorageData(victim_passport_details, 'victim_passport_details');

    _setStorageData(victim_deployment_details, 'victim_deployment_details');

//    $('#case-details-tab1').trigger('click');
//
//    //enable case details tab
//    $('#case-details-tab1').attr('disabled', false);

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

    //set attr data-id 
    var aEmpDetail = _getStorageData('victim_employer_details');
    var aAgencyDetail = _getStorageData('victim_recruitment_details');
    $('.emp-foreign_agency_name').attr('data-id', aAgencyDetail.foreign_agency_id);
    $('.emp-local_agency_name').attr('data-id', aAgencyDetail.local_agency_id);
    $('.emp-employer_name ').attr('data-id', aEmpDetail.employer_id);

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

function getStatesByCountryID(id) {
    var type = "getProvinces";
    if (id !== "173") {
        type = "getStatesByCountryID";
    }
    $.post(sAjaxGlobalData, {
        type: type,
        id: id,
    }, function (rs) {
        l = "";
        l += "<option value='' selected disabled>Select State/City </option>";
        $.each(rs.data, function (key, val) {
            l += "<option value='" + val.location_count_id + "'>" + val.location_name + " </option>";
        });

        return l;

    }, 'json');
}

function getLocalRecruitmentByKeyword() {

    $('.emp-local_agency_name').attr('data-id', 0);

    var keyword = $('.emp-local_agency_name').val();

    $.post(sAjaxRecruitment, {
        type: 'getLocalRecruitmentByKeyword',
        keyword: keyword,
    }, function (rs) {

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

    $('.emp-foreign_agency_name').attr('data-id', 0);

    var keyword = $('.emp-foreign_agency_name').val();
    $.post(sAjaxRecruitment, {
        type: 'getForeignRecruitmentByKeyword',
        keyword: keyword,
    }, function (rs) {

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


function getRecruitmentDetailsByID(id, type_id) {

    $.post(sAjaxRecruitment, {
        type: 'getRecruitmentDetailsByID',
        id: id,
    }, function (rs) {
        var res = rs.data.details;
        if (rs.data.result != '0') {
            var sType = 'foreign';

            if (type_id == '1') {

                // for local only
                sType = 'local';

                // for region id 
                $('.emp-local_agency_region').val(res.region_id).change();

                // set time for half second 
                setTimeout(function () {
                    $('.emp-local_agency_province').val(res.province_id).change();
                }, 500);

                $('.emp-local_agency_name').attr('data-id', res.recruitment_agency_id);
            } else {
                // for foreign only 
                $('.emp-' + sType + '_agency_country').val(res.country_id);
                $('.emp-foreign_agency_name').attr('data-id', res.recruitment_agency_id);
            }

            // agencies information 
            $('.emp-' + sType + '_agency_name').val(res.recruitment_agency_name);
            $('.emp-' + sType + '_agency_address').val(res.recruitment_agency_address);
            $('.emp-' + sType + '_agency_email').val(res.recruitment_agency_email);
            $('.emp-' + sType + '_agency_telephone').val(res.recruitment_agency_tel_no);
            $('.emp-' + sType + '_agency_fax').val(res.recruitment_agency_fax_no);
            $('.emp-' + sType + '_agency_website').val(res.recruitment_agency_website);


            // owners information 
            if (res.owner_details !== "") {
                $('.emp-' + sType + '_agency_owner_name').val(res.owner_details.recruitment_agency_info_name);
                $('.emp-' + sType + '_agency_owner_address').val(res.owner_details.recruitment_agency_info_address);
                $('.emp-' + sType + '_agency_owner_contact').val(res.owner_details.recruitment_agency_info_contact_number);
            }

            //agent information 
            if (res.agent_details !== "") {
                $('.emp-' + sType + '_agency_agent_name').val(res.agent_details.recruitment_agency_info_name);
                $('.emp-' + sType + '_agency_agent_address').val(res.agent_details.recruitment_agency_info_address);
                $('.emp-' + sType + '_agency_agent_contact').val(res.agent_details.recruitment_agency_info_contact_number);
            }

            // representative information 
            if (res.rep_details !== "") {
                $('.emp-' + sType + '_agency_rep_name').val(res.rep_details.recruitment_agency_info_name);
                $('.emp-' + sType + '_agency_rep_address').val(res.rep_details.recruitment_agency_info_address);
                $('.emp-' + sType + '_agency_rep_contact').val(res.rep_details.recruitment_agency_info_contact_number);
            }
        }

    }, 'json');
}

function clearRecruitmentAgency(type_id) {

    var sType = 'foreign';

    if (type_id == '1') {

        // for local only
        sType = 'local';

        // for region id 
        $('.emp-local_agency_region').val('').change();
        $('.emp-local_agency_province').val('').change();
        $('.emp-local_agency_province').prop('disabled', 'disabled');

        $('.emp-local_agency_name').val('');
        $('.emp-local_agency_name').attr('data-id', '0');

    } else {
        // for foreign only 
        $('.emp-' + sType + '_agency_country').val('').change();
        $('.emp-foreign_agency_name').val('');
        $('.emp-foreign_agency_name').attr('data-id', '0');
    }

    // agencies information 
    $('.emp-' + sType + '_agency_name').val('');
    $('.emp-' + sType + '_agency_address').val('');
    $('.emp-' + sType + '_agency_email').val('');
    $('.emp-' + sType + '_agency_telephone').val('');
    $('.emp-' + sType + '_agency_fax').val('');
    $('.emp-' + sType + '_agency_website').val('');


    // owners information 
    $('.emp-' + sType + '_agency_owner_name').val('');
    $('.emp-' + sType + '_agency_owner_address').val('');
    $('.emp-' + sType + '_agency_owner_contact').val('');


    //agent information 
    $('.emp-' + sType + '_agency_agent_name').val('');
    $('.emp-' + sType + '_agency_agent_address').val('');
    $('.emp-' + sType + '_agency_agent_contact').val('');


    // representative information 
    $('.emp-' + sType + '_agency_rep_name').val('');
    $('.emp-' + sType + '_agency_rep_address').val('');
    $('.emp-' + sType + '_agency_rep_contact').val('');


}


function getEmployerByKeyword() {
    $('.emp-employer_name').attr('data-id', 0);
    var keyword = $('.emp-employer_name').val();
    $.post(sAjaxEmployer, {
        type: 'getEmployerByKeyword',
        keyword: keyword,
    }, function (rs) {

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
        var res = rs.data.details;
        if (rs.data.result != '0') {
            $('.emp-employer_name').val(res.employer_name);
            $('.emp-employer_representative ').val(res.employer_representative_name);
            $('.emp-employer_telephone').val(res.employer_tel_no);
            $('.emp-employer_email').val(res.employer_email);
            $('.emp-employer_country').val(res.employer_country_id).change();
            $('.emp-employer_city').val(res.employer_city);
            $('.emp-employer_address').val(res.employer_full_address);
        }
    }, 'json');
}

function validateEmployerName() {
    var bol = false;
    $('.emp-employer_name').prop("required", false);
//    $('.error').remove();
    var v_name = $('.emp-employer_name').val();
    var inputs = $(".div-employer_form :input").map(function () {
        return $(this).val();
    }).get();

    $.each(inputs, function (key, val) {
        if ((val != "") && (v_name == "")) {
            $('.emp-employer_name').prop("required", true);
            bol = true;
        }
    });

    return bol;
}

function validateLocalRecName() {
    var bol = false;
    $('.emp-local_agency_name').prop("required", false);
//    $('.error').remove();
    var v_name = $('.emp-local_agency_name').val();
    var inputs = $(".div-agency_local_form :input").map(function () {
        return $(this).val();
    }).get();
    $.each(inputs, function (key, val) {
        if ((val != "") && (v_name == "")) {
            $('.emp-local_agency_name').prop("required", true);
            bol = true;
        }
    });
    return bol;
}

function validateForeignRecName() {
    var bol = false;
    $('.emp-foreign_agency_name').prop("required", false);
//    $('.error').remove();
    var v_name = $('.emp-foreign_agency_name').val();
    var inputs = $(".div-agency_foreign_form :input").map(function () {
        return $(this).val();
    }).get();
    $.each(inputs, function (key, val) {
        if ((val != "") && (v_name == "")) {
            $('.emp-foreign_agency_name').prop("required", true);
            bol = true;
        }
    });
    return bol;
}

function validateEmploymentNames() {

    $message = "";
    $message = (validateEmployerName() == true) ? "" : "Employer name is required";
    if ((validateEmployerName() == true) || (validateLocalRecName() == true) || (validateForeignRecName() == true)) {
        return false
    } else {
        return true
    }
}

function clearEmployerDetails() {
    $('.emp-employer_name').attr('data-id', '0');
    $('.emp-employer_name').val('');
    $('.emp-employer_representative ').val('');
    $('.emp-employer_telephone').val('');
    $('.emp-employer_email').val('');
    $('.emp-employer_country').val('');
    $('.emp-employer_city').val('');
    $('.emp-employer_address').val('');
}


$(document).ready(function () {

    getCountryISO();
    getEmploymentType();
    getDepartureType();
    getPortOfExit();
    getVisaCategory();
    getGender();
    getCvlStatus();
    getProvinceList();
    getTransitCountryInfoList();
    getActiveOccupations();     

    // ***** disable forms *****
    // employer 
    $(".div-employer_form :input").prop("disabled", true);
    // local agency 
    $(".div-agency_local_form :input").prop("disabled", true);
    // recruitment agency 
    $(".div-agency_foreign_form :input").prop("disabled", true);

    $(".emp-similar_to_victim").click(function () {
        var is_checked = $(this).is(":checked");
        if (is_checked) {
            var data = _getStorageData('victim_personal_info');
            if (data) {
                $.each(data, function (k, v) {
                    $('.emp-passport_' + k).val(v);
                });
                $('.emp-passport_province').val(data.pob);
                $('.emp-passport_province').change();
            }
        }
    });
    $('.emp-deployment_departure_type').change(function () {

        var o = $(this).val();
        // reset fields 
        $('.f-dp_type_others').hide();
        $('.emp-deployment_remark').val('');
        $('.f-escort_name').hide();
        $('.emp-deployment_escort_name').val('');
        $('.f-escort_description').hide();
        $('.emp-deployment_escort_description').val('');
        $('.lbl-emp_deployment_date').html("Date of Deployment");
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
    $('.emp-port_of_exit').change(function () {
        var o = $(this).val();
        //other
        if (o == 1) {
            $('.f-poe_description').show();
        } else {
            $('.f-poe_description').hide();
            $('.emp-port_of_exit_description').val('');
        }
    });


    $.validator.addMethod("checkDeployment", function (value, element) {
        var a = new Date(value);
        var b = new Date($("#emp_deployment_date").val());
        if (a >= b) {
            return true;
        }
        if (!value) {
            return true;
        }
    }, "Arrival date cannot be less than deployment date");

    $.validator.addMethod("checkDeploymentTransit", function (value, element) {
        var a = new Date(value);
        var b = new Date($("#date_timepicker_start").val());
        if (a >= b) {
            return true;
        }
        if (!value) {
            return true;
        }
    }, "Departure date cannot be less than arrival date");


    $.validator.addMethod("checkPDateExpired", function (value, element) {
        var a = new Date(value);
        var b = new Date($("#emp_passport_date_issued").val());
        if (a > b) {
            return true;
        }
        if (!value) {
            return true;
        }

    }, "Expiration cannot be less than the date issued.");


    $("#form-update_employment_info").validate({
        rules: {
            employer_telephone: {minlength: 7},
            employer_email: {email: true},
            local_recruitment_email: {email: true},
            local_recruitment_phone: {minlength: 7},
            local_recruitment_owner_contact: {minlength: 7},
            foreign_recruitment_email: {email: true},
            foreign_recruitment_phone: {minlength: 7},
            foregin_recruitment_owner_contact: {minlength: 7},
            emp_passport_dob: {pastDateOptional: true},
            emp_passport_date_issued: {pastDateOptional: true},
            //emp_deployment_arrival_date: {pastDateNow: true, checkDeployment: true},
            emp_deployment_date: {pastDateNow: true},
            emp_passport_date_expired: {checkPDateExpired: true},
            emp_act_salary: {number: true},
            emp_act_salary_in_peso: {number: true},
            emp_act_days_of_work: {number: true},
            emp_act_working_hours: {number: true},
            emp_salary: {number: true},
            emp_salary_in_peso: {number: true},
            emp_days_of_work: {number: true},
            emp_working_hours: {number: true},
            emp_salary: {number: true},
            emp_local_agency_owner_contact: {number: true},
            emp_local_agency_rep_contact: {number: true},
            emp_local_agency_agent_contact: {number: true},
            emp_foreign_agency_owner_contact: {number: true},
            emp_foreign_agency_rep_contact: {number: true},
            emp_foreign_agency_owner_contact: {number: true},
            emp_foreign_agency_owner_contact: {number: true},
            emp_sel_departure: {required: true},
            emp_sel_eer_country: {required: true},
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

//            if (validateEmploymentNames() == true) {
//            storeEmploymentDetails();
//            $('.step-trigger').attr('disabled', true);
//            $('#case-details-tab1').attr('disabled', false);
//            $('#case-details-tab1').trigger('click');
//            returnTop();
//            } else {
//                $("#form-update_employment_info").submit();
//            }validateEmploymentNames


            // var departure = $("#emp-sel-departure").val();
            // var emp_sel_eer_country = $("#emp-sel-eer-country").val();
            // if (departure == "0") {
            //     icmsMessage({
            //         type: 'msgWarning',
            //         body: '<center> Departure type is required. </center>',
            //         caption: 'Close',
            //     });
            // } else {

            //     if (emp_sel_eer_country == "") {
            //         icmsMessage({
            //             type: 'msgWarning',
            //             body: '<center>Country of deployment (Based on contract) in employment details is required.</center>',
            //             caption: 'Close',
            //         });
            //     } else {
            //         storeEmploymentDetails();
            //         $('.step-trigger').attr('disabled', true);
            //         $('#case-details-tab1').attr('disabled', false);
            //         $('#case-details-tab1').trigger('click');
            //         returnTop();
            //     }

            // }
            storeEmploymentDetails();
            $('.step-trigger').attr('disabled', true);
            $('#case-details-tab1').attr('disabled', false);
            $('#case-details-tab1').trigger('click');
            returnTop();
        }

    });
    $("#form-add_layover_info").validate({
        rules: {
            country: {required: true},
            emp_txt_tansit_arrival_date: {
                pastDateOptional: true,
            },
            emp_txt_tansit_depart_date: {
                pastDateOptional: true,
                checkDeploymentTransit: true
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
            var id = $('#form-add_layover_info').attr('stored-id');
            if (id == "") {
                storeVictimTransitInfoById();
            } else {
                // remove existing
                var storage = _getStorageData('victim_transit_info');
                _rmStorageDataById(storage, storage[id]);
                _setStorageData(storage, 'victim_transit_info');
                //add new transit details
                getTransitCountryInfoList();
                //load list
                storeVictimTransitInfoById();
            }
        }

    });
    $('#emp-sel-eet-country').change(function () {
        var curr = $(this).find(':selected').attr('data-currency');
        var country_id = $(this).val();
        $('#emp-sel-eet-currency').val(curr).change();
        $('#emp-sel-eet-currency').find(':selected').attr('country_id', country_id);
        var l = getStatesByCountryID(country_id);
        $('#emp-sel-eet-city').html(l);
    });
    $('#emp-sel-eer-country').change(function () {
        var curr = $(this).find(':selected').attr('data-currency');
        var country_id = $(this).val();
        $('#emp-sel-eer-currency').val(curr).change();
        $('#emp-sel-eer-currency').find(':selected').attr('country_id', country_id);
        var l = getStatesByCountryID(country_id);
        $('#emp-sel-eer-city').html(l);
    });
    $('#emp-sel-actual-country').change(function () {
        var curr = $(this).find(':selected').attr('data-currency');
        var country_id = $(this).val();
        $('#emp-sel-actual-currency').val(curr).change();
        $('#emp-sel-actual-currency').find(':selected').attr('country_id', country_id);
        var l = getStatesByCountryID(country_id);
        $('#emp-sel-eet-city').html(l);
    });
    $('.btn-add_layover').click(function () {
        $('#form-add_layover_info').attr('stored-id', "");
        $("#modal-transit-country").modal('show');
        $('#modal-transit-country .modal-header_title').text('Add Transit Details');
    });
    $('#emp-sel-province').change(function () {
        var id = $(this).val();
        getCitiesByProvinceID(id);
    });

    $('.tbl-transit-list').delegate('.rm-victim_transit_info', 'click', function () {
        var id = $(this).attr('data-id');
        var storage = _getStorageData('victim_transit_info');
        icmsMessage({
            type: 'msgConfirmation',
            title: 'You are about to remove an transit detail.',
            body: 'Click continue button if you wish to continue.',
            LblBtnConfirm: 'Continue',
            LblBtnCancel: 'Cancel',
            onConfirm: function () {
                _rmStorageDataById(storage, storage[id]);
                _setStorageData(storage, 'victim_transit_info');
                getTransitCountryInfoList();
            },
        });
    });

    $('.tbl-transit-list').delegate('.up-victim_transit_info', 'click', function () {
        $('#modal-transit-country .modal-header_title').text('Manage Transit Details');
        var id = $(this).attr('data-id');
        $('#form-add_layover_info').attr('stored-id', id);
        var x = _getStorageData('victim_transit_info');
        $.each(x[id], function (k, v) {
            if (k == "country_id") {
                $('#emp-sel-Transit-country').val(v).change();
            }
            if (k == "city") {
                $('.emp-txt-tansit-city').val(v);
            }
            if (k == "departure") {
                $('.emp-txt-tansit-depart-date').val(v);
            }
            if (k == "arrival") {
                $('.emp-txt-tansit-arrival-date').val(v);
            }
            if (k == "remarks") {
                $('.emp-txt-transit-remarks').val(v);
            }
        });
        $('#modal-transit-country').modal('show');
    });
    $('.employers_country').change(function () {
        var curr = $(this).find(':selected').attr('data-currency');
        var country_id = $(this).val();
        var l = getStatesByCountryID(country_id);
        $('.employers_city').html(l);
    });
    $('.emp-local_agency_region').change(function () {
        var region_id = $(this).val();
        getProvincesByRegionId(region_id);
        $('.emp-local_agency_province').removeAttr('disabled');
    });

    // for search local recruitment 
    $('.emp-local_agency_name').on('keyup', function (e) {
        var keyword = $(this).val();
        validateLocalRecName();
        setTimeout(function () {
            if (keyword.length) {
                getLocalRecruitmentByKeyword();
                $(".div-agency_local_form :input").prop("disabled", false);
            } else {
                $(".div-agency_local_form :input").prop("disabled", true);
            }
        }, 1000);
    });

    $(".emp-local_agency_name").focusout(function () {
        validateLocalRecName();
    });

    // clear local recruitment details 
    $('.emp-local_agency_name').click(function () {
        var id = $(this).attr('data-id');
        if (id != '0') {
            clearRecruitmentAgency(1);
        }
    });
    // select local list list 
    $('#ra-local-search').delegate('.list-group-item', 'click', function () {
        var id = $(this).attr('data-id');
        getRecruitmentDetailsByID(id, '1');
    });
    // for search foreign recruitment 
    $('.emp-foreign_agency_name').on('keyup', function (e) {
        var keyword = $(this).val();
        setTimeout(function () {
            if (keyword.length) {
                getForeignRecruitmentByKeyword();
                $(".div-agency_foreign_form :input").prop("disabled", false);
            } else {
                $(".div-agency_foreign_form :input").prop("disabled", true);
            }
        }, 1000);

    });

    $(".emp-foreign_agency_name").focusout(function () {
        validateForeignRecName();
    });

    // clear local recruitment details 
    $('.emp-foreign_agency_name').click(function () {
        var id = $(this).attr('data-id');
        if (id != '0') {
            clearRecruitmentAgency(2);
        }
    });
    // select foreign list list 
    $('#ra-foreign-search').delegate('.list-group-item', 'click', function () {
        var id = $(this).attr('data-id');
        getRecruitmentDetailsByID(id, '2');
    });
    // for search employer 
    $('.emp-employer_name').on('keyup', function (e) {
        var keyword = $(this).val();
//        delay(function () {
//            if (keyword.length) {
//                getEmployerByKeyword();
//            }
//        }, 1000);
        setTimeout(function () {
            if (keyword.length) {
                getEmployerByKeyword();
                $(".div-employer_form :input").prop("disabled", false);
            } else {
                $(".div-employer_form :input").prop("disabled", true);
            }
        }, 1000);
    });

    $(".emp-employer_name").focusout(function () {
        validateEmployerName();
    });

    // clear employer details 
    $('.emp-employer_name').click(function () {
        var id = $(this).attr('data-id');
        if (id != '0') {
            clearEmployerDetails();
        }
    });
    // select employer list 
    $('#employer-search').delegate('.list-group-item', 'click', function () {
        var id = $(this).attr('data-id');
        getEmployerDetailsByID(id);
    });
});



// -----####ICMS OSAEC END####-----
