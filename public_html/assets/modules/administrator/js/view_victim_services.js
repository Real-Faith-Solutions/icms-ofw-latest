
var aInitialValues = [];

function confirmSave() {
    if (document.getElementById("cd-doc-file").files.length == 0) {
        var hashId = "";
        saveNewServiceUpdate(hashId);
    } else {
        uploadDocuments();
    }
}

function saveNewServiceUpdate(hashId) {
    icmsMessage({
        type: "msgPreloader",
        visible: true
    });

    var cvsid = $('.btn-modal-save').attr('data-cvsid');
    var subj = $('#txt_subject').val();
    var remarks = $('#area_remarks').val();
    var date_remind = $('#txt_reminder').val();
    var reminder_remarks = $('#area_reminderremarks').val();
    var docs = hashId;
    var case_id = $('.spn_case').attr('datacaseid');
    var dataloglnk = $('.div_case_victim').attr('dataloglnk');
    var service_title = $('.btn-modal-save').attr('data-cvstitle');
    var tagged_id = $('.btn-modal-save').attr('data-tagged-id');
    var service_stats = $('#sel_service_stat').val();
    var stat_change = 0;
    if (service_stats !== $('#sel_service_stat').attr('oldstat')) {
        stat_change = 1;
    }

    $.post(sAjaxVictimServices, {
        type: "saveNewServiceUpdate",
        subj: subj,
        cvsid: cvsid,
        remarks: remarks,
        date_remind: date_remind,
        reminder_remarks: reminder_remarks,
        document_hash: docs,
        case_id: case_id,
        dataloglnk: dataloglnk,
        service_title: service_title,
        service_stats: service_stats,
        stat_change: $('#sel_service_stat').attr('oldstat'),
        tagged_id: tagged_id,
    }, function (rs) {
        icmsMessage({
            type: "msgPreloader",
            visible: false
        });
        icmsMessage({
            type: "msgSuccess"
        });
        $('#txt_subject').val("");
        $('#area_remarks').val("");
        $('#txt_reminder').val("");
        $('#area_reminderremarks').val("");
        $("#cd-doc-file").val(null);
        $('#mdl-add_new_remarks').modal('hide');
        getVictimServices();
    }, 'json');

}

function  uploadDocuments() {
    var data = new FormData();
    var file = document.getElementById("cd-doc-file").files;
    var uploadURL = window.location.origin + '/ajax/drive/ajax';
    data.append('file', file[0]);
    data.append('type', 'uploadFile');
    $.ajax({
        xhr: function ()
        {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function (evt) {

                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    var total = percentComplete * 100;
                    var num = Math.round(total);
                    var percentVal = num + '%';
                    // progress bar 
                    progress = $('.upload-progress');
                    progress.removeClass('hide');
                    progress.find('.determinate').css('width', percentVal);
                    progress.find('.upload-progress-caption').html(" " + percentVal + " uploading file.");
                }
            }, false);
            return xhr;
        },
        url: uploadURL,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        type: 'POST',
        success: function (rs) {
            var fileHash = rs.data.output.hash;
            saveNewServiceUpdate(fileHash);
        },
        error: function () {
            //something went wrong
        }

    });
}

function getVictimServices() {
    setTimeout(function(){
        var case_id = $('.spn_case').attr('datacaseid');
        var victim_id = $('.spn_victim').attr('datavictimid');
        var case_victim_id = $('.div_case_victim').attr('datacasevictimid');
        $.post(sAjaxVictimServices, {
            type: "getVictimServices",
            case_id: case_id,
            victim_id: victim_id,
            case_victim_id: case_victim_id,
        }, function (rset) {
            var rs = rset.data.service_details;
            if (rset.data.result == "1") {
                var list = "";
                $.each(rs, function (key, val) {
                    var dttagged = val.case_victim_services_agency_tag_added_date.split(" ");
                    var dtupdate = val.case_victim_services_agency_tag_date_modified.split(" ");
                    list += '<div class="row mb-4  list-services">';
                    list += '   <div class="col-2 text-center date-services">';
                    if (val.case_victim_services_agency_tag_date_modified == "") {
                        list += '       <span class="s_month">' + dateViewingFormat(dttagged[0]).toUpperCase() + '</span><br>';
                    } else {
                        list += '       <span class="s_month">' + dateViewingFormat(dtupdate[0]).toUpperCase() + '</span><br>';
                    }

                    list += '   </div>';
                    list += '   <div class="col-7">';
                    list += '       <div class="agency_details mb-2"> <span class="content-title ">' + val.service_name + ' - ' + val.service_duration + ' </span> ';
                    list += '           <br> <span>Tagged to: </span><span class="label-details" title="' + val.tagged_to.agency_name + '">' + val.tagged_to.agency_abbr + ' - ' + val.tagged_to.agency_branch_name + '</span>';
                    list += '           <br> <span>Added by: </span><span class="label-details" title="' + val.tagged_by.agency_name + '">' + val.tagged_by.agency_abbr + ' - ' + val.tagged_by.agency_branch_name + '</span>';
                    list += '           <br> <span>Date Tagged: </span><span class="label-details">' + dateViewingFormat(dttagged[0]) + ' ' + localTime(dttagged[1]) + '</span> ';
                    list += '           <br>';
                    list += '       </div>';
                
                    if (rset.data.user_branch_id  == val.tagged_to.agency_branch_id) {
                        var brid = $('.div-title').attr('data-brid');
                        var mnid = $('.div-title').attr('data-mnid');
                        if (brid == val.tagged_to.agency_branch_id || mnid == "iZb0XWIqBZQwFs5XJsRXJH0U85Ew87sM9M5GPC0bVusQiCY3Q5l") {
                            list += '       <a class="mt-2 lvl-ce lvl-ce lvl-ra btn-show_service" href="' + sAjaxUrl + '/legal_services_logs/' + val.lnk + '"  role="button">Show remarks</a>';

                            var status = val.case_victim_services_agency_tag_status;
                            if ((status == "2") || (status == "3")) {
                                list += '       <a class="mt-2 lvl-ce lvl-ch lvl-ca lvl-ra btn-show_service btn-add-update-log " service-tag-id="' + val.case_victim_services_agency_tag_id + '" service-stat="' + val.case_victim_services_agency_tag_status + '" data-cvsid="' + val.case_victim_services_id + '" data-service-name="' + val.service_name + ' - ' + val.service_duration + '" data-toggle="modal" data-target="#mdl-add_new_remarks"> Add new update</a>';
                            } else {
                                list += '       <a class="mt-2 lvl-ce lvl-ra btn-show_service btn-add-update-log " service-tag-id="' + val.case_victim_services_agency_tag_id + '" service-stat="' + val.case_victim_services_agency_tag_status + '" data-cvsid="' + val.case_victim_services_id + '" data-service-name="' + val.service_name + ' - ' + val.service_duration + '" data-toggle="modal" data-target="#mdl-add_new_remarks"> Add new update</a>';
                            }

                        }
                    }

                    list += '   </div>';
                    list += '   <div class="col-3">';
                    if (val.case_victim_services_agency_tag_status == "4") {
                        list += '       <div class="step completed">';
                        list += '           <div class="v-stepper">';
                        list += '               <div class="circle">';
                        list += '                   <i class="fa fa-check" aria-hidden="true" style="color:#fff;"></i>';
                        list += '               </div>';
                        list += '               <div class="s_status ml-2">';
                        list += '                   <span class="">' + val.service_status + '</span>';
                        list += '               </div>';
                        list += '           </div>';
                        list += '       </div>';
                    } else if (val.case_victim_services_agency_tag_status == "3") {
                        list += '       <div class="step inapplicable">';
                        list += '           <div class="v-stepper">';
                        list += '               <div class="circle"></div>';
                        list += '               <div class="s_status ml-2">';
                        list += '                   <span class="">' + val.service_status + '</span>';
                        list += '               </div>';
                        list += '           </div>';
                        list += '       </div>';
                    } else {
                        if(val.is_removable == "1"){
                            list += '       <button class="btn btn-secondary-light_blue remove float-right mt-4" data-id="'+val.case_victim_services_id+'"> <i class="fa fa-trash mr-1"></i> Remove</button>';
                        }
                        list += '       <div class="step pending">';
                        list += '           <div class="v-stepper">';
                        list += '               <div class="circle">';
                        list += '               </div>';
                        list += '               <div class="s_status ml-2">';
                        list += '                   <span class="">' + val.service_status + '</span>';
                        list += '               </div>';
                        list += '           </div>';
                        list += '       </div>';
                    }
                    list += '   </div>';
                    list += '</div>';
                });
                $('.container-services').html(list);
                $('.initial-loading').hide();
            } else {

                var list = "<div class=''><center >No services found!</center></div>";
                $('.container-services').html(list);
                $('.initial-loading').hide();
            }
            grantLevel();
        }, 'json');
    }, 1000);
}

function deleteService(id) {
    $.post(sAjaxVictimServices, {
        type: "deleteService",
        case_victim_services_id: id
    }, function (rset) {
        var rs = rset.data;
        getVictimServices();
        icmsMessage({
            type: "msgSuccess",
            body: "Processing Done!",
        });
    }, 'json');
}

function getAssessmentType() {
    $.post(sAjaxGlobalData, {
        type: "getAssessmentType",
    }, function (rs) {
        l = "<option value='' selected >Select Assessment</option>";
        $.each(rs.data, function (key, val) {
            l += "<option value='" + val.transaction_parameter_count_id + "'>" + val.transaction_parameter_name + " </option>";
        });
        $('#cd-mdl-sel-assmnt-type').html(l);
    }, 'json');
}


function getServiceStatus() {
    $.post(sAjaxGlobalData, {
        type: "getServiceStatus",
    }, function (rs) {
        console.log(rs);
        var l = "";
        $.each(rs.data, function (key, val) {
            l += "<option value='" + val.transaction_parameter_count_id + "'>" + val.transaction_parameter_name + " </option>";
        });
        $('#sel_service_stat').html(l);
    }, 'json');
}

function  getServicesByAssessmentID(id) {
    $.post(sAjaxGlobalData, {
        type: "getServicesByAssessmentID",
        assmntID: id,
    }, function (rs) {
        var a = "";
        a += "<option selected disabled >Select Services</option>";
        $.each(rs.data, function (key, val) {
            a += "<option value='" + val.services_id + "' data-days='" + val.service_days + "'>" + val.service_name + " </option>";
        });
        $('#cd-mdl-sel-service').html(a);
        var selectd = $('#form-add_assessment_info').attr('data-service');
        $('#cd-mdl-sel-service').val(selectd).change();

    }, 'json');
}



function getAgenciesWhichOfferServices(id) {

    $.post(sAjaxGlobalData, {
        type: "getAgenciesWhichOfferServices",
        serviceID: id,
    }, function (rs) {

        console.log(" im here");
        var a = "";
        $.each(rs.data, function (key, val) {
            if (typeof val.agency_branch_id !== "undefined") {
                a += "<option value='" + val.agency_branch_id + "'>" + val.agency_abbr + " - " + val.agency_branch_name + " </option>";
            }
        });
        if (a == "") {
            a = "<option value=''>No  Agency Available</option>";
            $('.btn-save-assessment').attr("disabled", "disabled");
        } else {
            $('.btn-save-assessment').removeAttr("disabled");
        }

        $('#cd-mdl-sel-agncy').html(a);

    }, 'json');
}

$(document).ready(function () {

    getServiceStatus();
    getAssessmentType();
    getVictimServices();

    $('.datetimepicker').datetimepicker({});

    // on hide modal 
    $('#mdl-add-services .btn-cancel').click(function () {
        var x = getFormValues('form-add_assessment_info');
        if (x !== "") {
            icmsMessage({
                type: "msgConfirmation",
                title: "Do you want to disregard your details?",
                body: "Click yes button if you want to continue",
                LblBtnConfirm: "Yes",
                onConfirm: function () {
                    $('#form-add_assessment_info')[0].reset();
                    $('#cd-mdl-txt-set-age').val('');
                    resetFormJQueryValidation('form-add_assessment_info');
                    $('#cd-mdl-sel-agncy').html('');
                },
                onCancel: function () {
                    $('#mdl-add-services').modal('show');
                }
            });
        }
    });

    $('#mdl-add_new_remarks .btn-cancel').click(function () {
        var x = getFormValues('form-new-service-update');
        if (x !== aInitialValues['form_service_update']) {
            icmsMessage({
                type: "msgConfirmation",
                title: "Do you want to disregard your details?",
                body: "Click yes button if you want to continue",
                LblBtnConfirm: "Yes",
                onConfirm: function () {
                    $('#form-new-service-update')[0].reset();
                    resetFormJQueryValidation('form-new-service-update');
                },
                onCancel: function () {
                    $('#mdl-add_new_remarks').modal('show');
                }
            });
        }
    });

    // Remove Tags
    $(".victim_list_container").on("click", ".tag > span", function () {
        $(this).parent().remove();
    });
    $('#add-updates').tooltip({boundary: 'window'});


    $('#cd-mdl-sel-assmnt-type').change(function () {
        var id = $(this).val();
        getServicesByAssessmentID(id);
    });

    $('#cd-mdl-sel-service').change(function () {

        $('#cd-mdl-txt-set-age_label').val();
        $('#cd-mdl-txt-set-age').val();

        var id = $(this).val();

        switch (id) {
            case "9":
            case "15":
            case "42":
            case "43":
            case "2":
            case "3":
            case "14":
            case "44":
                $('.row-cd-arrival').show();
                $('.row-cd-departure').show();
                break;
            default:
                $('.row-cd-arrival').css("display", "none");
                $('.row-cd-departure').css("display", "none");
        }

        var days = $('#cd-mdl-sel-service option:selected').attr('data-days');

        var monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        var nowDate = new Date();
        var numberOfDaysToAdd = parseInt(days);
        nowDate.setDate(nowDate.getDate() + numberOfDaysToAdd);
        var dd = nowDate.getDate();
        var mm = nowDate.getMonth();
        var y = nowDate.getFullYear();

        if (days) {
            $('#cd-mdl-txt-set-age_label').val(monthNames[mm] + ' ' + dd + ', ' + y + ' or  within ' + days + ' day/s.');
            $('#cd-mdl-txt-set-age').val((mm + 1) + '/' + dd + '/' + y);
        }

        getAgenciesWhichOfferServices(id);

    });

    $('.btn-save-assessment').click(function () {
        $('#mdl-add-services').modal('hide');
        icmsMessage({
            type: "msgPreloader",
            visible: true,
        });
        setTimeout(function(){
            $.post(sAjaxCaseDetails, {
                type: "addServiceInformation",
                deliveryService: $('#cd-mdl-txt-set-age').val(),
                services_id: $('#cd-mdl-sel-service').val(),
                service_name: $('#cd-mdl-sel-service option:selected').text(),
                remark: $('#cd-mdl-txt-remarks').val(),
                agency_id: $('#cd-mdl-sel-agncy').val(),
                case_id: $('.spn_case').attr('datacaseid'),
            }, function (rs) {
                $('#form-add_assessment_info')[0].reset();
                $('#cd-mdl-txt-set-age').val('');
                resetFormJQueryValidation('form-add_assessment_info');
                $('#cd-mdl-sel-agncy').html('');
                getVictimServices();
                icmsMessage({
                    type: "msgSuccess",
                    body: "Processing Done!",
                });
            }, 'json');
        }, 1000);
    });


    $('.container-services').delegate('.btn-add-update-log', 'click', function () {
        var mdlTitle = $(this).attr('data-service-name');
        $('#mdl-add-new-update').html("<center><b>Add New Update</b><br><small>" + mdlTitle + "</small></center>");
        $('.btn-modal-save').attr('data-cvsid', $(this).attr('data-cvsid'));
        $('.btn-modal-save').attr('data-cvstitle', mdlTitle);
        $('.btn-modal-save').attr('data-tagged-id', $(this).attr('service-tag-id'));
        $('#sel_service_stat').attr('oldStat', $(this).attr('service-stat'));
        $('#sel_service_stat').val($(this).attr('service-stat')).change();
        aInitialValues['form_service_update'] = getFormValues('form-new-service-update');
    });

    $('.container-services').delegate('.remove', 'click', function () {
        var id = $(this).attr('data-id');
        icmsMessage({
            type: "msgConfirmation",
            title: "Do you want to remove this service?",
            LblBtnConfirm: 'Submit',
            onConfirm: function () {
               deleteService(id); 
            },
        });
    });

    $('.btn-modal-save').click(function () {
        $('#form-new-service-update').submit();
    });

    $('#form-new-service-update').validate({
        rules: {
            txt_subject: {required: true},
            area_remarks: {required: true},
            reminder: {futureDate: true}
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

            var service_title = $('.btn-modal-save').attr('data-cvstitle');
            icmsMessage({
                type: "msgConfirmation",
                title: "You are about add new updates for " + service_title,
                onConfirm: function () {
                    confirmSave();
                },
                onShow: function () {
                    $('#mdl-add_new_remarks').modal('hide');
                },
                onCancel: function () {
                    $('#mdl-add_new_remarks').modal('show');
                }
            });
        }
    });

    $('#cd-doc-file').change(function (event) {
        // 52428800 = 20mb
        checkFileFormat(event, 52428800, 'cd-doc-file', 'mdl-add-new-update');
    });

});