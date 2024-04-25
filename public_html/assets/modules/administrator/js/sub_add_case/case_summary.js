//   ####---- IACAT CASE SUMMARY START ----####
// var checker_id = '', flag_error = 0;

// function checkFlagError(err, callback, cb_1) {
//     flag_error++;
//     if (flag_error >= 5) {
//         icmsMessage({
//             type: 'msgWarning',
//             body: 'Too many error occured, please contact the administrator for the support.',
//             caption: 'Close',
//             onHide: function () {
//                 refreshAddCase();
//             },
//             onShow: function () {
//                 $('#msgAddCasePreloader').modal('hide');
//             }
//         });
//     } else {

//         if (isObject(err) == true) {
//             //err = JSON.stringify(err);
//             err = 'Failed connection';
//         }

//         icmsMessage({
//             type: 'msgWarning',
//             body: '<p>Something went wrong due of <p>  <code>' + err + '</code>',
//             caption: 'Retry',
//             onHide: function () {
//                 callback(cb_1);
//                 setTimeout(function () {
//                     $('#msgAddCasePreloader').modal('show');
//                 }, 500);

//             },
//             onShow: function () {
//                 $('#msgAddCasePreloader').modal('hide');
//             }
//         });
//     }

// }

// function getSummaryDetails() {

//     var data = _getStorageData('victim_personal_info');

//     $.each(data, function (key, val) {

//         $('.lbl-victim_' + key).html(val);
//     });

//     var vn = data.first_name + ' ' + data.middle_name + ' ' + data.last_name + ' ' + data.suffix;
//     $('.lbl-victim_name').html(vn);
//     var avn = data.assumed_first_name + ' ' + data.assumed_middle_name + ' ' + data.assumed_last_name;
//     $('.lbl-victim_assumed_name').html(avn);

//     //employment info
//     var storages = ['victim_employment_info',
//         'victim_employer_details',
//         'victim_recruitment_details',
//         'victim_passport_details',
//         'victim_deployment_details',
//         'employment_type_value'
//     ];

//     $.each(storages, function (key, val) {
//         var data = _getStorageData(val);

//         $.each(data, function (key, val) {
//             $('.lbl-emp-' + key).html(val);
//         });

//     });

//     // Employer address
//     var country = $('.emp-employer_country option:selected').attr('data-name') != undefined ? $('.emp-employer_country option:selected').attr('data-name') : "";
//     var city = $('.emp-employer_city').val() != "" ? $('.emp-employer_city').val() : "";
//     var details = $('.emp-employer_address').val() != "" ? $('.emp-employer_address').val() : "";

//     $('.lbl-emp-employer_address').text(country + ' ' + city + ' ' + details);

//     // Foreign Recruitment Agency 
//     var country = $('.emp-foreign_agency_country').val();
//     var sCountry = "";
//     if (country != undefined) {
//         sCountry = (($('.emp-foreign_agency_country option:selected').text() != undefined) && ($('.emp-foreign_agency_country option:selected').val() != '')) ? $('.emp-foreign_agency_country option:selected').text() : "";
//     }
//     var details = $('.emp-foreign_agency_address').val() != "" ? $('.emp-foreign_agency_address').val() : "";
//     $('.lbl-emp-foreign_agency_address').text(sCountry + ' ' + details);


//     // Employment Place 
//     var country = $('#emp-sel-eet-country ').val();
//     var sCountry = "";
//     if (country != undefined) {
//         var sCountry = (($('#emp-sel-eet-country option:selected').text() != undefined) && ($('#emp-sel-eet-country').val() != '')) ? $('#emp-sel-eet-country option:selected').text() : "";
//     }
//     var details = $('#emp-sel-eet-city').val() != "" ? $('#emp-sel-eet-city').val() : "";
//     $('.lbl-emp-deployment_place').text(sCountry + ' ' + details);

//     //case info
//     var storages = ['victim_complainant_details',
//         'victim_case_evaluation_details', 'victim_case_risk_assessment'];

//     $.each(storages, function (key, val) {
//         var data = _getStorageData(val);
//         $.each(data, function (key, val) {
//             $('.lbl-case-' + key).html(val);
//         });
//     });

//     var aDetails = _getStorageData('victim_complainant_details');
//     if (aDetails['complainant_relation_value'] == 'Other') {
//         $('.lbl-case-complainant_relation_value').html(aDetails['complainant_relation_value'] + ': ' + aDetails['complainant_relation_other']);
//     }

//     //brief facts and act means purpose
//     var arr_selected = _getStorageData('victim_case_details');

//     $('.lbl-case-facts').html(arr_selected.facts);
//     $('.lbl-case-other_law_desc').html(arr_selected.other_law_desc);

//     var amps = ['acts', 'means', 'purposes'];
//     var act = '';
//     var mean = '';
//     var purpose = '';

//     if (arr_selected) {
//         $.each(amps, function (k, v) {
//             var value = '';
//             var data = JSON.parse(arr_selected[v]);
//             $.each(data, function (kk, vv) {
//                 if (v == 'acts') {
//                     act += vv.act + ', ';
//                     value = act;
//                 } else if (v == 'means') {
//                     mean += vv.mean + ', ';
//                     value = mean;
//                 } else if (v == 'purposes') {
//                     purpose += vv.purpose + ', ';
//                     value = purpose;
//                 }
//             });
//             value = value.substring(0, value.length - 2);
//             $('.lbl-case-' + v).html(value);
//         });
//     }

//     //case victim services
//     var services = _getStorageData('victim_services_info');
//     var cnt = 0;
//     var t = '';
//     if (services.length > 0) {
//         $.each(services, function (key, val) {
//             var arr_agency = JSON.parse(val.agency_json);
//             var agn_name = "";
//             $.each(arr_agency, function (k, v) {
//                 if (agn_name == "") {
//                     agn_name += v.agency_name;
//                 } else {
//                     agn_name += ", " + v.agency_name;
//                 }
//             });

//             var datetoday = new Date();
//             var dateAge = parseDate(val.aging);
//             var remainingday = datediff(datetoday, dateAge);
//             if (parseInt(remainingday) < 1) {
//                 remainingday = "0";
//             }

//             t += '  <div class="row ">';
//             t += '     <div class="col-3 summary-lbl">';
//             t += '     ' + val.services_name + '';
//             t += '     </div>';
//             t += '     <div class="col-4 summary-details">';
//             t += '           <label class="lbl-case-">Tagged to ' + agn_name + '</label><br>';
//             t += '           <label>' + remainingday + ' days to complete service</label><br>';
//             t += '     </div>';
//             t += '     <div class="col-5 summary-details">';
//             t += '           <label class="lbl-case-">' + val.remarks + '</label>';
//             t += '           </div>';
//             t += '        </div>';
//             cnt++;
//         });
//         $('.lbl-case-victim_services').html(t);
//     } else {
//         $('.lbl-case-victim_services').html('<div class="row"><div class="col-3 summary-lbl">No services added</div></div>');
//     }

//     // do ellipes 
//     $("label.text-ellipse").html(function (index, currentText) {
//         var newText = currentText;
//         if (currentText.length >= 200) {
//             newText = '<span class="more" data-content="more" style="display:none">' + newText + '  <a class="see_details blue font-weight-normal" data-seemore ="0" >see less</a> </span>';
//             newText += '<span class="less" data-content="less">' + currentText.substr(0, 200) + '...  <a class = "see_details blue font-weight-normal" data-seemore ="1" >see more</a> </span>';
//         }
//         return newText;
//     });


//     $('.see_details').click(function () {
//         var lbl = $(this).attr('data-seemore');
//         if (lbl == 1) {
//             var content = $(this).parent().attr('data-content');
//             if (content == 'less') {
//                 $(this).parent().hide();
//                 $(this).parent().prev().show();
//             }
//         } else {
//             var content = $(this).parent().attr('data-content');
//             if (content == 'more') {
//                 $(this).parent().hide();
//                 $(this).parent().next().show();
//             }
//         }
//     });

//     // Is Falsified 
//     var is_check = $('.emp-deployment_document_is_falsified:checkbox:checked').length;
//     is_check > 0 ? $('#s-lbl-is_falsified').show() : $('#s-lbl-is_falsified').hide();

//     // Is Illegal 
//     var is_check = $('.case-is_illegal_rec:checkbox:checked').length;
//     is_check > 0 ? $('.i-illegal_rec').show() : $('.i-illegal_rec').hide();

//     // Is Other Law 
//     var is_check = $('.case-is_other_law:checkbox:checked').length;
//     is_check > 0 ? $('.i-other_law').show() : $('.i-other_law').hide();
//     is_check > 0 ? $('.lbl-other_law_desc').show() : $('.lbl-other_law_desc').hide();

// }

// function addCase() {

//     storeVictimDetails();
//     storeEmploymentDetails();
//     storeCaseDetails();
//     getSummaryDetails();

//     var recommended_priority_level = $("input[name='recommendedLevel']:checked").val();
//     var victim_id = localStorage.getItem('victim_id');
//     var victim_personal_info = localStorage.getItem('victim_personal_info');
//     var victim_personal_contact_info = localStorage.getItem('victim_personal_contact_info');
//     var victim_personal_relative_info = localStorage.getItem('victim_personal_relative_info');
//     var victim_personal_education_info = localStorage.getItem('victim_personal_education_info');
//     var victim_personal_address_info = localStorage.getItem('victim_personal_address_info');

//     var victim_employment_info = localStorage.getItem('victim_employment_info');
//     var victim_employer_details = localStorage.getItem('victim_employer_details');
//     var victim_recruitment_details = localStorage.getItem('victim_recruitment_details');
//     var victim_passport_details = localStorage.getItem('victim_passport_details');
//     var victim_deployment_details = localStorage.getItem('victim_deployment_details');
//     var victim_transit_info = localStorage.getItem('victim_transit_info');

//     var victim_complainant_details = localStorage.getItem('victim_complainant_details');
//     var victim_offender_details = localStorage.getItem('victim_case_offender');
//     var victim_case_details = _getStorageData('victim_case_details');
//     var victim_case_evaluation_details = localStorage.getItem('victim_case_evaluation_details');
//     var victim_services_info = _getStorageData('victim_services_info');
//     var document_attachment_info = localStorage.getItem('document_attachment_info');

//     var caseData = {
//         'victim_exist_victim_id': victim_id,
//         'victim_personal_info': victim_personal_info,
//         'victim_personal_contact_info': victim_personal_contact_info,
//         'victim_personal_relative_info': victim_personal_relative_info,
//         'victim_personal_education_info': victim_personal_education_info,
//         'victim_personal_address_info': victim_personal_address_info,
//         'victim_employment_info': victim_employment_info,
//         'victim_employer_details': victim_employer_details,
//         'victim_recruitment_details': victim_recruitment_details,
//         'victim_passport_details': victim_passport_details,
//         'victim_deployment_details': victim_deployment_details,
//         'victim_transit_info': victim_transit_info,
//         'victim_complainant_details': victim_complainant_details,
//         'victim_offender_details': victim_offender_details,
//         'victim_case_details': victim_case_details,
//         'victim_case_evaluation_details': victim_case_evaluation_details,
//         'victim_services_info': victim_services_info,
//         'document_attachment_info': document_attachment_info,
//         'recommended_priority_level': recommended_priority_level
//     };

//     icmsMessage({
//         type: 'msgPreloader',
//         visible: true,
//         body: "Please wait while saving your report."
//     });

//     $.post(sAjaxCase, {
//         type: "addCase",
//         'temporary_case_id' : (temp_data.flag == 1) ? temp_data.temporary_case_id : 0, 
//         caseParameters: caseData
//     }, function (rs) {

//         icmsMessage({
//             type: 'msgPreloader',
//             visible: false
//         });

//         // show modal preloader 
//         $('#msgAddCasePreloader').modal('show');
//         if (rs.data.flag == 1) {
//             setTimeout(function () {
//                 move(12);
//                 checker_id = rs.data.checker_id;
//                 //addCaseNumber();
//                 addVictim();
//             }, 500);
//         }

//         // flag = 0 
//         else {
//             var err = rs.data.stat_info;
//             checkFlagError(err, addCase, false);
//         }

//     }, 'json').fail(function (err) {
//         checkFlagError(err, addCase, false);
//     });

// }

// function __addCaseNumber() {
//     $.post(sAjaxCase, {
//         type: "addCaseNumber",
//         case_checker_id: checker_id
//     }, function (rs) {
//         $('#details-loading').text('Creating Report Number');
//         if (rs.data.flag == 1) {
//             setTimeout(function () {
//                 move(8);
//                 addVictim();
//             }, 500);
//         } else {
//             var err = rs.data.stat_info;
//             checkFlagError(err, addCase, false);
//         }
//     }, 'json').fail(function (err) {
//         checkFlagError(err, addCase, false);
//     });
// }

// function addVictim() {
//     $.post(sAjaxCase, {
//         type: "addVictim",
//         case_checker_id: checker_id
//     }, function (rs) {
//         $('#details-loading').text('Saving Victim Information');
//         if (rs.data.flag == 1) {
//             setTimeout(function () {
//                 move(14);
//                 //addVictimNumber();
//                 savingDetailsFromChecker({
//                     stage: 1
//                 });
//             }, 500);
//         } else {
//             var err = rs.data.stat_info;
//             checkFlagError(err, addVictim, false);
//         }
//     }, 'json').fail(function (err) {
//         checkFlagError(err, addVictim, false);
//     });

// }

// function addVictimNumber() {
//     $.post(sAjaxCase, {
//         type: "addVictimNumber",
//         case_checker_id: checker_id
//     }, function (rs) {
//         $('#details-loading').text('Creating Victim Number');
//         if (rs.data.flag == 1) {
//             setTimeout(function () {
//                 move(7);
//                 savingDetailsFromChecker({
//                     stage: 1
//                 });
//             }, 500);
//         } else {
//             var err = rs.data.stat_info;
//             checkFlagError(err, addVictimNumber, false);
//         }
//     }, 'json').fail(function (err) {
//         checkFlagError(err, addVictimNumber, false);
//     });
// }

// function renameLoadingDetails(x, data_case_number, data_victim_number) {
//     switch (x) {
//         case 1:
//             $('#details-loading').text('Adding Victim to Information.');
//             break;
//         case 2:
//             $('#details-loading').text('Adding Victim to Report.');
//             $('#tab1-0').hide();
//             $('#tab1-1').show();
//             break;
//         case 3:
//             $('#details-loading').text('Saving Local Recruitment Agency Details.');
//         case 4:
//             $('#details-loading').text('Saving Local Foreign Agency Details.');
//         case 5:
//             $('#details-loading').text('Saving Employer Details.');
//         case 6:
//             $('#details-loading').text('Saving Employment Details.');
//             break;
//         case 7:
//             $('#details-loading').text('Saving Employment.');
//             break;
//         case 8:
//             $('#details-loading').text('Saving Employment Details.');
//             break;
//         case 9:
//             $('#details-loading').text('Saving Passport Details.');
//             break;
//         case 10:
//             $('#details-loading').text('Saving Transit Details.');
//             $('#tab2-0').hide();
//             $('#tab2-1').show();
//             break;
//         case 11:
//             $('#details-loading').text('Saving Complainant Details.');
//             break;
//         case 12:
//             $('#details-loading').text('Saving Offender Details.');
//             break;
//         case 13:
//             $('#details-loading').text('Saving TIP Details.');
//             break;
//         case 14:
//             $('#details-loading').text('Saving Services Details.');
//             break;
//         case 15:
//             $('#details-loading').text('Saving Documents Details.');
//             break;
//         case 16:
//             $('#details-loading').text('Saving Tagged Details.');
//             $('#tab3-0').hide();
//             $('#tab3-1').show();

//             setTimeout(function () {
//                 icmsMessage({
//                     type: 'msgSuccess',
//                     body: "New case successfully added. <br> <br> Report Id: <b>" + data_case_number + "</b><br>" + "Victim No: <b>" + data_victim_number + "</b>",
//                     link: {
//                         content: 'Go to report list',
//                         link: 'cases'
//                     },
//                     onShow: function () {
//                         // delete stored data 
//                         clearStoredData();
//                         //hide preloader modal
//                         $('#msgAddCasePreloader').modal('hide');
//                     },
//                     onHide: function () {
//                         refreshAddCase();
//                     },
//                 });
//             }, 2000);

//             break;
//         default:
//     }
// }

// function savingDetailsFromChecker(x) {

//     if (x.stage < 17) {
//         $.post(sAjaxCase, {
//             type: "savingDetailsFromChecker",
//             case_checker_id: checker_id,
//             stage: x.stage
//         }, function (rs) {

//             if (rs.data.flag == 1) {
//                 setTimeout(function () {
//                     renameLoadingDetails(x.stage, rs.data.case_number, rs.data.victim_number);
//                     move(4);
//                     savingDetailsFromChecker({
//                         stage: x.stage + 1
//                     });
//                 }, 500);
//             } else {
//                 var err = rs.data.stat_info;
//                 checkFlagError(err, savingDetailsFromChecker, x);
//             }
//         }, 'json').fail(function (err) {
//             checkFlagError(err, savingDetailsFromChecker, x);
//         });

//     }
// }

// var i = 0;
// var iniPer = 10;
// function move(percent) {
//     iniPer += percent;
//     if (i == 0) {
//         i = 1;
//         var elem = document.getElementById("myBar");
//         var width = 10;
//         var id = setInterval(frame, 10);
//         function frame() {
//             if (width >= iniPer) {
//                 clearInterval(id);
//                 i = 0;
//             } else {
//                 width++;
//                 elem.style.width = width + "%";
//                 elem.innerHTML = width + "%";
//             }
//         }
//     }
// }

// function refreshAddCase() {
//     clearStoredData();
//     window.location.reload();
// }

// function goToCaseList() {
//     clearStoredData();
//     window.location.href = window.location.origin + '/cases';
// }

// $(document).ready(function () {



//     $('#summary-details-tab1').click(function () {
//         storeVictimDetails();
//         storeEmploymentDetails();
//         storeCaseDetails();
//         getSummaryDetails();
//     });

//     // save changes 
//     $('form').on('keyup change paste', 'input, select, textarea', function (e) {
//         var storage = _getStorageData('victim_personal_info');
//         if (storage) {
//             setTimeout(function () {
//                 storeVictimDetails();
//                 storeEmploymentDetails();
//                 storeCaseDetails();
//                 getSummaryDetails();
//             }, 200);
//         }
//     });

//     // form validation 
//     $("#form-add_case").validate({
//         rules: {
// //            recommendedLevel: {required: true}
//         },
//         errorElement: 'div',
//         errorPlacement: function (error, element) {
//             var placement = $(element).data('error');
//             if (placement) {
//                 $(placement).append(error);
//             } else {
//                 error.insertAfter(element);
//             }
//         },
//         submitHandler: function (form) {
//             var recommended_priority_level = $("input[name='recommendedLevel']:checked").val();
//             if (recommended_priority_level) {

//                 icmsMessage({
//                     type: 'msgConfirmation',
//                     title: 'You are about to add new report.',
//                     body: 'Click submit button if you wish to continue',
//                     LblBtnConfirm: 'Submit',
//                     onConfirm: function () {
//                         addCase();
//                     }
//                 });

//             } else {
//                 icmsMessage({
//                     type: 'msgWarning',
//                     body: 'Please choose priority level.',
//                     onHide: function () {
//                         $('html, body').animate({scrollTop: $(document).height()}, '300');
//                     }
//                 });
//             }
//         }
//     });


// });

//   ####---- IACAT CASE SUMMARY END ----####  

//   ####---- OSAEC CASE SUMMARY START ----####
var checker_id = '', flag_error = 0;

function checkFlagError(err, callback, cb_1) {
    flag_error++;
    if (flag_error >= 5) {
        icmsMessage({
            type: 'msgWarning',
            body: 'Too many error occured, please contact the administrator for the support.',
            caption: 'Close',
            onHide: function () {
                refreshAddCase();
            },
            onShow: function () {
                $('#msgAddCasePreloader').modal('hide');
            }
        });
    } else {

        if (isObject(err) == true) {
            //err = JSON.stringify(err);
            err = 'Failed connection';
        }

        icmsMessage({
            type: 'msgWarning',
            body: '<p>Something went wrong due of <p>  <code>' + err + '</code>',
            caption: 'Retry',
            onHide: function () {
                callback(cb_1);
                setTimeout(function () {
                    $('#msgAddCasePreloader').modal('show');
                }, 500);

            },
            onShow: function () {
                $('#msgAddCasePreloader').modal('hide');
            }
        });
    }

}

function getSummaryDetails() {

    var data = _getStorageData('victim_personal_info');

    $.each(data, function (key, val) {

        $('.lbl-victim_' + key).html(val);
    });

    var vn = data.first_name + ' ' + data.middle_name + ' ' + data.last_name + ' ' + data.suffix;
    $('.lbl-victim_name').html(vn);
    var avn = data.assumed_first_name + ' ' + data.assumed_middle_name + ' ' + data.assumed_last_name;
    $('.lbl-victim_assumed_name').html(avn);

    //employment info
    var storages = ['victim_employment_info',
        'victim_employer_details',
        'victim_recruitment_details',
        'victim_passport_details',
        'victim_deployment_details',
        'employment_type_value'
    ];

    $.each(storages, function (key, val) {
        var data = _getStorageData(val);

        $.each(data, function (key, val) {
            $('.lbl-emp-' + key).html(val);
        });

    });

    // Employer address
    var country = $('.emp-employer_country option:selected').attr('data-name') != undefined ? $('.emp-employer_country option:selected').attr('data-name') : "";
    var city = $('.emp-employer_city').val() != "" ? $('.emp-employer_city').val() : "";
    var details = $('.emp-employer_address').val() != "" ? $('.emp-employer_address').val() : "";

    $('.lbl-emp-employer_address').text(country + ' ' + city + ' ' + details);

    // Foreign Recruitment Agency 
    var country = $('.emp-foreign_agency_country').val();
    var sCountry = "";
    if (country != undefined) {
        sCountry = (($('.emp-foreign_agency_country option:selected').text() != undefined) && ($('.emp-foreign_agency_country option:selected').val() != '')) ? $('.emp-foreign_agency_country option:selected').text() : "";
    }
    var details = $('.emp-foreign_agency_address').val() != "" ? $('.emp-foreign_agency_address').val() : "";
    $('.lbl-emp-foreign_agency_address').text(sCountry + ' ' + details);


    // Employment Place 
    var country = $('#emp-sel-eet-country ').val();
    var sCountry = "";
    if (country != undefined) {
        var sCountry = (($('#emp-sel-eet-country option:selected').text() != undefined) && ($('#emp-sel-eet-country').val() != '')) ? $('#emp-sel-eet-country option:selected').text() : "";
    }
    var details = $('#emp-sel-eet-city').val() != "" ? $('#emp-sel-eet-city').val() : "";
    $('.lbl-emp-deployment_place').text(sCountry + ' ' + details);

    //case info
    var storages = ['victim_complainant_details',
        'victim_case_evaluation_details', 'victim_case_risk_assessment'];

    $.each(storages, function (key, val) {
        var data = _getStorageData(val);
        $.each(data, function (key, val) {
            $('.lbl-case-' + key).html(val);
        });
    });

    var aDetails = _getStorageData('victim_complainant_details');
    if (aDetails['complainant_relation_value'] == 'Other') {
        $('.lbl-case-complainant_relation_value').html(aDetails['complainant_relation_value'] + ': ' + aDetails['complainant_relation_other']);
    }

    //brief facts and act means purpose
    var arr_selected = _getStorageData('victim_case_details');

    $('.lbl-case-facts').html(arr_selected.facts);
    $('.lbl-case-other_law_desc').html(arr_selected.other_law_desc);

    var amps = ['acts', 'means', 'purposes'];
    var act = '';
    var mean = '';
    var purpose = '';

    if (arr_selected) {
        $.each(amps, function (k, v) {
            var value = '';
            var data = JSON.parse(arr_selected[v]);
            $.each(data, function (kk, vv) {
                if (v == 'acts') {
                    act += vv.act + ', ';
                    value = act;
                } else if (v == 'means') {
                    mean += vv.mean + ', ';
                    value = mean;
                } else if (v == 'purposes') {
                    purpose += vv.purpose + ', ';
                    value = purpose;
                }
            });
            value = value.substring(0, value.length - 2);
            $('.lbl-case-' + v).html(value);
        });
    }

    //case victim services
    var services = _getStorageData('victim_services_info');
    var cnt = 0;
    var t = '';
    if (services.length > 0) {
        $.each(services, function (key, val) {
            var arr_agency = JSON.parse(val.agency_json);
            var agn_name = "";
            $.each(arr_agency, function (k, v) {
                if (agn_name == "") {
                    agn_name += v.agency_name;
                } else {
                    agn_name += ", " + v.agency_name;
                }
            });

            var datetoday = new Date();
            var dateAge = parseDate(val.aging);
            var remainingday = datediff(datetoday, dateAge);
            if (parseInt(remainingday) < 1) {
                remainingday = "0";
            }

            t += '  <div class="row ">';
            t += '     <div class="col-3 summary-lbl">';
            t += '     ' + val.services_name + '';
            t += '     </div>';
            t += '     <div class="col-4 summary-details">';
            t += '           <label class="lbl-case-">Tagged to ' + agn_name + '</label><br>';
            t += '           <label>' + remainingday + ' days to complete service</label><br>';
            t += '     </div>';
            t += '     <div class="col-5 summary-details">';
            t += '           <label class="lbl-case-">' + val.remarks + '</label>';
            t += '           </div>';
            t += '        </div>';
            cnt++;
        });
        $('.lbl-case-victim_services').html(t);
    } else {
        $('.lbl-case-victim_services').html('<div class="row"><div class="col-3 summary-lbl">No services added</div></div>');
    }

    // do ellipes 
    $("label.text-ellipse").html(function (index, currentText) {
        var newText = currentText;
        if (currentText.length >= 200) {
            newText = '<span class="more" data-content="more" style="display:none">' + newText + '  <a class="see_details blue font-weight-normal" data-seemore ="0" >see less</a> </span>';
            newText += '<span class="less" data-content="less">' + currentText.substr(0, 200) + '...  <a class = "see_details blue font-weight-normal" data-seemore ="1" >see more</a> </span>';
        }
        return newText;
    });


    $('.see_details').click(function () {
        var lbl = $(this).attr('data-seemore');
        if (lbl == 1) {
            var content = $(this).parent().attr('data-content');
            if (content == 'less') {
                $(this).parent().hide();
                $(this).parent().prev().show();
            }
        } else {
            var content = $(this).parent().attr('data-content');
            if (content == 'more') {
                $(this).parent().hide();
                $(this).parent().next().show();
            }
        }
    });

    // Is Falsified 
    var is_check = $('.emp-deployment_document_is_falsified:checkbox:checked').length;
    is_check > 0 ? $('#s-lbl-is_falsified').show() : $('#s-lbl-is_falsified').hide();

    // Is Illegal 
    var is_check = $('.case-is_illegal_rec:checkbox:checked').length;
    is_check > 0 ? $('.i-illegal_rec').show() : $('.i-illegal_rec').hide();

    // Is Other Law 
    var is_check = $('.case-is_other_law:checkbox:checked').length;
    is_check > 0 ? $('.i-other_law').show() : $('.i-other_law').hide();
    is_check > 0 ? $('.lbl-other_law_desc').show() : $('.lbl-other_law_desc').hide();

}

function addCase() {

    storeVictimDetails();
    storeEmploymentDetails();
    storeCaseDetails();
    getSummaryDetails();

    var recommended_priority_level = $("input[name='recommendedLevel']:checked").val();
    var victim_id = localStorage.getItem('victim_id');
    var victim_personal_info = localStorage.getItem('victim_personal_info');
    var victim_personal_contact_info = localStorage.getItem('victim_personal_contact_info');
    var victim_personal_relative_info = localStorage.getItem('victim_personal_relative_info');
    var victim_personal_education_info = localStorage.getItem('victim_personal_education_info');
    var victim_personal_address_info = localStorage.getItem('victim_personal_address_info');

    var victim_employment_info = localStorage.getItem('victim_employment_info');
    var victim_employer_details = localStorage.getItem('victim_employer_details');
    var victim_recruitment_details = localStorage.getItem('victim_recruitment_details');
    var victim_passport_details = localStorage.getItem('victim_passport_details');
    var victim_deployment_details = localStorage.getItem('victim_deployment_details');
    var victim_transit_info = localStorage.getItem('victim_transit_info');

    var victim_complainant_details = localStorage.getItem('victim_complainant_details');
    var victim_offender_details = localStorage.getItem('victim_case_offender');
    var victim_case_details = _getStorageData('victim_case_details');
    var victim_case_evaluation_details = localStorage.getItem('victim_case_evaluation_details');
    var victim_services_info = _getStorageData('victim_services_info');
    var document_attachment_info = localStorage.getItem('document_attachment_info');

    var caseData = {
        'victim_exist_victim_id': victim_id,
        'victim_personal_info': victim_personal_info,
        'victim_personal_contact_info': victim_personal_contact_info,
        'victim_personal_relative_info': victim_personal_relative_info,
        'victim_personal_education_info': victim_personal_education_info,
        'victim_personal_address_info': victim_personal_address_info,
        'victim_employment_info': victim_employment_info,
        'victim_employer_details': victim_employer_details,
        'victim_recruitment_details': victim_recruitment_details,
        'victim_passport_details': victim_passport_details,
        'victim_deployment_details': victim_deployment_details,
        'victim_transit_info': victim_transit_info,
        'victim_complainant_details': victim_complainant_details,
        'victim_offender_details': victim_offender_details,
        'victim_case_details': victim_case_details,
        'victim_case_evaluation_details': victim_case_evaluation_details,
        'victim_services_info': victim_services_info,
        'document_attachment_info': document_attachment_info,
        'recommended_priority_level': recommended_priority_level
    };

    icmsMessage({
        type: 'msgPreloader',
        visible: true,
        body: "Please wait while saving your report."
    });

    $.post(sAjaxCase, {
        type: "addCase",
        caseParameters: caseData
    }, function (rs) {

        icmsMessage({
            type: 'msgPreloader',
            visible: false
        });

        // show modal preloader 
        $('#msgAddCasePreloader').modal('show');
        if (rs.data.flag == 1) {
            setTimeout(function () {
                move(12);
                checker_id = rs.data.checker_id;
                //addCaseNumber();
                addVictim();
            }, 500);
        }

        // flag = 0 
        else {
            var err = rs.data.stat_info;
            checkFlagError(err, addCase, false);
        }

    }, 'json').fail(function (err) {
        checkFlagError(err, addCase, false);
    });

}

function __addCaseNumber() {
    $.post(sAjaxCase, {
        type: "addCaseNumber",
        case_checker_id: checker_id
    }, function (rs) {
        $('#details-loading').text('Creating Report Number');
        if (rs.data.flag == 1) {
            setTimeout(function () {
                move(8);
                addVictim();
            }, 500);
        } else {
            var err = rs.data.stat_info;
            checkFlagError(err, addCase, false);
        }
    }, 'json').fail(function (err) {
        checkFlagError(err, addCase, false);
    });
}

function addVictim() {
    $.post(sAjaxCase, {
        type: "addVictim",
        case_checker_id: checker_id
    }, function (rs) {
        $('#details-loading').text('Saving Victim Information');
        if (rs.data.flag == 1) {
            setTimeout(function () {
                move(14);
                //addVictimNumber();
                savingDetailsFromChecker({
                    stage: 1
                });
            }, 500);
        } else {
            var err = rs.data.stat_info;
            checkFlagError(err, addVictim, false);
        }
    }, 'json').fail(function (err) {
        checkFlagError(err, addVictim, false);
    });

}

function addVictimNumber() {
    $.post(sAjaxCase, {
        type: "addVictimNumber",
        case_checker_id: checker_id
    }, function (rs) {
        $('#details-loading').text('Creating Victim Number');
        if (rs.data.flag == 1) {
            setTimeout(function () {
                move(7);
                savingDetailsFromChecker({
                    stage: 1
                });
            }, 500);
        } else {
            var err = rs.data.stat_info;
            checkFlagError(err, addVictimNumber, false);
        }
    }, 'json').fail(function (err) {
        checkFlagError(err, addVictimNumber, false);
    });
}

function renameLoadingDetails(x, data_case_number, data_victim_number) {
    switch (x) {
        case 1:
            $('#details-loading').text('Adding Victim to Information.');
            break;
        case 2:
            $('#details-loading').text('Adding Victim to Report.');
            $('#tab1-0').hide();
            $('#tab1-1').show();
            break;
        case 3:
            $('#details-loading').text('Saving Local Recruitment Agency Details.');
        case 4:
            $('#details-loading').text('Saving Local Foreign Agency Details.');
        case 5:
            $('#details-loading').text('Saving Employer Details.');
        case 6:
            $('#details-loading').text('Saving Employment Details.');
            break;
        case 7:
            $('#details-loading').text('Saving Employment.');
            break;
        case 8:
            $('#details-loading').text('Saving Employment Details.');
            break;
        case 9:
            $('#details-loading').text('Saving Passport Details.');
            break;
        case 10:
            $('#details-loading').text('Saving Transit Details.');
            $('#tab2-0').hide();
            $('#tab2-1').show();
            break;
        case 11:
            $('#details-loading').text('Saving Complainant Details.');
            break;
        case 12:
            $('#details-loading').text('Saving Offender Details.');
            break;
        case 13:
            $('#details-loading').text('Saving TIP Details.');
            break;
        case 14:
            $('#details-loading').text('Saving Services Details.');
            break;
        case 15:
            $('#details-loading').text('Saving Documents Details.');
            break;
        case 16:
            $('#details-loading').text('Saving Tagged Details.');
            $('#tab3-0').hide();
            $('#tab3-1').show();

            setTimeout(function () {
                icmsMessage({
                    type: 'msgSuccess',
                    body: "New case successfully added. <br> <br> Report Id: <b>" + data_case_number + "</b><br>" + "Victim No: <b>" + data_victim_number + "</b>",
                    link: {
                        content: 'Go to report list',
                        link: 'cases'
                    },
                    onShow: function () {
                        // delete stored data 
                        clearStoredData();
                        //hide preloader modal
                        $('#msgAddCasePreloader').modal('hide');
                    },
                    onHide: function () {
                        refreshAddCase();
                    },
                });
            }, 2000);

            break;
        default:
    }
}

function savingDetailsFromChecker(x) {

    if (x.stage < 17) {
        $.post(sAjaxCase, {
            type: "savingDetailsFromChecker",
            case_checker_id: checker_id,
            stage: x.stage
        }, function (rs) {

            if (rs.data.flag == 1) {
                setTimeout(function () {
                    renameLoadingDetails(x.stage, rs.data.case_number, rs.data.victim_number);
                    move(4);
                    savingDetailsFromChecker({
                        stage: x.stage + 1
                    });
                }, 500);
            } else {
                var err = rs.data.stat_info;
                checkFlagError(err, savingDetailsFromChecker, x);
            }
        }, 'json').fail(function (err) {
            checkFlagError(err, savingDetailsFromChecker, x);
        });

    }
}

var i = 0;
var iniPer = 10;
function move(percent) {
    iniPer += percent;
    if (i == 0) {
        i = 1;
        var elem = document.getElementById("myBar");
        var width = 10;
        var id = setInterval(frame, 10);
        function frame() {
            if (width >= iniPer) {
                clearInterval(id);
                i = 0;
            } else {
                width++;
                elem.style.width = width + "%";
                elem.innerHTML = width + "%";
            }
        }
    }
}

function refreshAddCase() {
    clearStoredData();
    window.location.reload();
}

function goToCaseList() {
    clearStoredData();
    window.location.href = window.location.origin + '/cases';
}

$(document).ready(function () {



    $('#summary-details-tab1').click(function () {
        storeVictimDetails();
        storeEmploymentDetails();
        storeCaseDetails();
        getSummaryDetails();
    });

    // save changes 
    $('form').on('keyup change paste', 'input, select, textarea', function (e) {
        var storage = _getStorageData('victim_personal_info');
        if (storage) {
            setTimeout(function () {
                storeVictimDetails();
                storeEmploymentDetails();
                storeCaseDetails();
                getSummaryDetails();
            }, 200);
        }
    });

    // form validation 
    $("#form-add_case").validate({
        rules: {
//            recommendedLevel: {required: true}
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
            // var recommended_priority_level = $("input[name='recommendedLevel']:checked").val();
            // if (recommended_priority_level) {

            //     icmsMessage({
            //         type: 'msgConfirmation',
            //         title: 'You are about to add new report.',
            //         body: 'Click submit button if you wish to continue',
            //         LblBtnConfirm: 'Submit',
            //         onConfirm: function () {
            //             addCase();
            //         }
            //     });

            // } else {
            //     icmsMessage({
            //         type: 'msgWarning',
            //         body: 'Please choose priority level.',
            //         onHide: function () {
            //             $('html, body').animate({scrollTop: $(document).height()}, '300');
            //         }
            //     });
            // }

            icmsMessage({
                type: 'msgConfirmation',
                title: 'You are about to add new report.',
                body: 'Click submit button if you wish to continue',
                LblBtnConfirm: 'Submit',
                onConfirm: function () {
                    addCase();
                }
            });
        }
    });


});



//   ####---- OSAEC CASE SUMMARY END ----####