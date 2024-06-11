$(document).ready(function () {
    getGlobalComplainSource();
    getGlobalParameterTypeIdAndStatus();
    getActPurposeMeans();
    getNationality();
    getOffenderTypes();
    getAssessmentType();
    getCaseOffenderList();
    getServicesInfoList();
    getDocumentAttachmentInfoList();

    $('#form-add_offender').validate({
        rules: {
            offender_type: {required: true},
            offender_name: {required: true},
            offender_contact: {minlength: 7, number: true}
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
            storeCaseOffender();
        }
    });

    $('#form-update_offender').validate({
        rules: {
            offender_type: {required: true},
            offender_name: {required: true},
            offender_contact: {minlength: 7}
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
            storeCaseOffenderById();
        }
    });

    //offender info actions
    $('.victim-offender_info_list').delegate('.rm-victim_case_offender', 'click', function () {
        var id = $(this).attr('data-id');
        var storage = _getStorageData('victim_case_offender');
        icmsMessage({
            type: 'msgConfirmation',
            title: 'You are about to remove an incident offender.',
            body: 'Click continue button if you wish to continue.',
            LblBtnConfirm: 'Continue',
            LblBtnCancel: 'Cancel',
            onConfirm: function () {
                _rmStorageDataById(storage, storage[id]);
                _setStorageData(storage, 'victim_case_offender');
                getCaseOffenderList();
            },
        });
    });

    $('.victim-offender_info_list').delegate('.up-victim_case_offender', 'click', function () {
        var id = $(this).attr('data-id');
        $('.stored-offender_id').val(id);

        var x = _getStorageData('victim_case_offender');

        $.each(x[id], function (key, val) {
            $('.u-case-' + key).val(val);
        });

        getCaseOffenderList();
        $(".u-case-offender_type option[value=" + x[id]['offender_type'] + "]").removeAttr("disabled");

        var id = $('.u-case-offender_type').val();
        $('.offender_field_other').hide();
        if (id == '4') {
            $('.offender_field_other').show();
        }

        $('#modal-update_case_offender').modal('show');

    });

    $("#form-update_case_info").validate({
        rules: {
            complainant_contact: {minlength: 7, number: true},
            case_date_complained: {pastDateOptional: true},
            case_complainant_source: {required: true}
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
            storeCaseDetails();
            $('.step-trigger').attr('disabled', true);
            //enable summary tab trigger click
            $('#summary-details-tab1').attr('disabled', false);
            $('#summary-details-tab1').trigger('click');
            returnTop();
        }
    });

    $('#cd-mdl-sel-assmnt-type').change(function () {

        // reset set age 
        $('#cd-mdl-txt-set-age_label').val('');
        $('#cd-mdl-txt-set-age').val('');

        var id = $(this).val();
        getServicesByAssessmentID(id);
    });

    $('.btn-add_assessment').click(function () {
        $('#modal-Initial-asssessment .modal-header_title').text('Add Services Information');
        // reset form
        $('#form-add_assessment_info').attr("stored-id", "");
        $('#form-add_assessment_info').attr("data-assessment", "0");
        $('#form-add_assessment_info').attr("data-service", "0");
        $('#form-add_assessment_info').attr("data-agencies", "0");

        // reset set age 
        $('#cd-mdl-txt-set-age_label').val('');
        $('#cd-mdl-txt-set-age').val('');

        getServicesByAssessmentID('');

        $('#modal-Initial-asssessment').modal('show');
    });

    $('#cd-doc-file').change(function (event) {
        $(this).attr('data-action', '1');
        // 20997976 = 20mb
        checkFileFormat(event, 20997976, 'cd-doc-file', 'modalcontent-add_document');
    });

    $('.btn-add_offender').click(function () {
        getCaseOffenderList();
        $('#modal-add_case_offender').show();
    });

//    $('.btn-modal-cancel').click(function(){
//        $('#modal-add_case_offender').hide();
//    });


    $('.btn-add_document').click(function () {
        
        // reset forms 
        $('#cd-txt-doc-remarks').val("");
        $('#cd-doc-file').val("");
        
        // set modal 
        $('#modalcontent-add_document .modal-content').show();
        $('#form-add_document_info').attr('stored-id', "");
        $('#cd-doc-file').attr('data-hash', "0");
        $('#cd-doc-file').attr('data-action', "add");
        $('#modalcontent-add_document').modal('show');
        $('#cd-doc-file').css('color', '');
        $('#cd-doc-file').attr('required', '');
        $('#modalcontent-add_document img.img-uploaded').hide();
        $('.modal-div-image').show();
    });

    $('#cd-sel-document-cat').change(function () {
        var id = $(this).val();
        getDocumentTypesByDocumentCategoryID(id);
    });


    $('.btn-save-document').click(function () {
        $('#form-add_document_info').valid();
    });

    $('#form-add_document_info').validate({
        rules: {
            cdTxtDocumentRemark: {required: true},
            cdDocFile: {required: true},
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

            var fileHash = $('#cd-doc-file').attr('data-hash'),
                    display_name = "";
            storeDocumentAttachment(fileHash, display_name);
        }
    });

    $('#form-update_document_info').validate({
        rules: {
            cdTxtDocumentRemark: {required: true}
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
            updateDocumentAttachment();
        }
    });


    $('#form-add_assessment_info').validate({
        rules: {
            assessment_type: {required: true},
            sel_service: {required: true},
            sel_agency: {required: true}
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
            var id = $('#form-add_assessment_info').attr("stored-id");

            if (id == "") {
                saveVictimeAssessment();
            } else {

                var storedId = id;
                var current = _getStorageData('victim_services_info');

                var agencies_val = $('#cd-mdl-sel-agncy').val();
                var arr_agency = [];
                $("#cd-mdl-sel-agncy option:selected").each(function () {
                    var newx = $(this).text().replace(",", " ");
                    arr_agency.push({"agency": newx});
                });

                var arr_agency_id = [];
                //    $.each(agencies_val, function (key, val) {
                arr_agency_id.push({"agency_id": agencies_val});
                //    });

                var combine_arr = [];
                $.each(arr_agency_id, function (k, v) {
                    $.each(arr_agency, function (kk, vv) {
                        if (k == kk) {
                            combine_arr.push({"agency_id": v.agency_id, "agency_name": vv.agency});
                        }
                    });
                });

                var agency_json = JSON.stringify(combine_arr);
                var agency_tagged_id = $("#cd-mdl-sel-agncy").chosen().val();
                var assessment_type = $("#cd-mdl-sel-assmnt-type").val();
                var assessment_type_name = $("#cd-mdl-sel-assmnt-type option:selected").text();
                var services = $("#cd-mdl-sel-service").val();
                var services_name = $("#cd-mdl-sel-service option:selected").text();
                var aging = $("#cd-mdl-txt-set-age").val();
                var departure = $("#cd-mdl-txt-departure-date").val();
                var arrival = $("#cd-mdl-txt-arrival-date").val();
                var remarks = $("#cd-mdl-txt-remarks").val();

                current[storedId]['agency_json'] = agency_json;
                current[storedId]['agency_tagged_id'] = agency_tagged_id;
                current[storedId]['assessment_type'] = assessment_type;
                current[storedId]['services'] = services;
                current[storedId]['aging'] = aging;
                current[storedId]['departure'] = departure;
                current[storedId]['arrival'] = arrival;
                current[storedId]['remarks'] = remarks;
                current[storedId]['assessment_type_name'] = assessment_type_name;
                current[storedId]['services_name'] = services_name;

                _setStorageData(current, 'victim_services_info');

                $('#form-add_assessment_info')[0].reset();
                $('#modal-Initial-asssessment').modal('hide');
                getServicesInfoList();

            }
        }
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

    $('#tbody-document-list').delegate('.rm-victim_document_info', 'click', function () {
        var id = $(this).attr('data-id');
        var storage = _getStorageData('document_attachment_info');
        icmsMessage({
            type: 'msgConfirmation',
            title: 'You are about to remove an victim document attachment.',
            body: 'Click continue button if you wish to continue.',
            LblBtnConfirm: 'Continue',
            LblBtnCancel: 'Cancel',
            onConfirm: function () {
                _rmStorageDataById(storage, storage[id]);
                _setStorageData(storage, 'document_attachment_info');
                getDocumentAttachmentInfoList();
            },
        });
    });

    $('#tbody-document-list').delegate('.upd-victim_document_info', 'click', function () {
        var id = $(this).attr('data-id');
        var hash = $(this).attr('data-hash');
        var remarks = $(this).attr('data-remarks');

        // set inputs  
        $('#modalcontent-update_document img.img-uploaded').attr('src', sDriveViewer + hash);
        $('#modalcontent-update_document a.img-uploaded').attr('href', sDriveViewer + hash);
        
        $('#ucd-txt-doc-remarks').val(remarks);
        $('#ucd-doc-file').attr('data-hash', hash);
        $('#form-update_document_info').attr('data-id', id);

        // set picture 
        $('#modalcontent-update_document img.img-uploaded').show();

        // open modal 
        $('#modalcontent-update_document').modal('show');

    });


    $('#tbody-document-list').delegate('.up-victim_document_info', 'click', function () {
        var id = $(this).attr('data-id');
        $('#form-add_document_info').attr('stored-id', id);
        var x = _getStorageData('document_attachment_info');
        $('#cd-doc-file').css('color', 'transparent');
        $('#cd-doc-file').attr('data-action', 'update');
        $.each(x[id], function (k, v) {
            if (k == "doc_category") {
                $('#cd-sel-document-cat').val(v).change();
            }
            if (k == "doc_type") {
                $('#cd-sel-document-type').attr('data-id', v);
            }

            if (k == "doc_remark") {
                $('#cd-txt-doc-remarks').val(v);
            }

            if (k == "document_hash") {
                $('#cd-doc-file').attr('data-hash', v);
            }
        });

        $('#modalcontent-add_document').modal('show');
    });


    $('#tbl-services-list').delegate('.rm-victim_service_info', 'click', function () {
        var id = $(this).attr('data-id');
        var storage = _getStorageData('victim_services_info');
        icmsMessage({
            type: 'msgConfirmation',
            title: 'You are about to remove an victim needs/services.',
            body: 'Click continue button if you wish to continue.',
            LblBtnConfirm: 'Continue',
            LblBtnCancel: 'Cancel',
            onConfirm: function () {
                _rmStorageDataById(storage, storage[id]);
                _setStorageData(storage, 'victim_services_info');
                getServicesInfoList();
            },
        });
    });

    $('#tbl-services-list').delegate('.up-victim_service_info', 'click', function () {
        $('#modal-Initial-asssessment .modal-header_title').text('Manage Services Information');
        var id = $(this).attr('data-id');
        $('#form-add_assessment_info').attr("stored-id", id);
        var x = _getStorageData('victim_services_info');
        $('#form-add_assessment_info').attr("data-assessment", x[id].assessment_type);
        $('#form-add_assessment_info').attr("data-service", x[id].services);
        $('#form-add_assessment_info').attr("data-agencies", x[id].agency_json);

        $('#cd-mdl-sel-assmnt-type').val(x[id].assessment_type).change();
        $('#cd-mdl-txt-set-age').val(x[id].aging);
        $('#cd-mdl-txt-departure-date').val(x[id].departure);
        $('#cd-mdl-txt-arrival-date').val(x[id].arrival);
        $('#cd-mdl-txt-remarks').val(x[id].remarks);

        $('#modal-Initial-asssessment').modal('show');

    });


    // Select offender type 
    // in add 
    $('.a-case-offender_type').click(function () {
        var id = $(this).val();
        $('.offender_field_other').hide();
        if (id == '4') {
            $('.offender_field_other').show();
        }
    });
    // in update
    $('.u-case-offender_type').click(function () {
        var id = $(this).val();
        $('.offender_field_other').hide();
        if (id == '4') {
            $('.offender_field_other').show();
        }
    });

    // click other complainant relationship
    $('.case-complainant_relation').change(function () {
        // reset complainant other input
        $('.case-complainant_relation_other').val('');
        var selected = $(".case-complainant_relation option:selected").text().toLowerCase().replace(" ", "");
        if (selected === "other") {
            $('.div-case-complainant_relation_other').show();
        } else {
            $('.div-case-complainant_relation_other').hide();
        }
    });

    // other law 
    $(".case-is_other_law").click(function () {
        if ($(this).is(':checked')) {
            $('.div-other_law_desc').show();
        } else {
            $('.div-other_law_desc').hide();
            $('.case-other_law_desc').val('');
        }
    });



    /*
     * Cropping Image
     */

    var $uploadCrop,
            tempFilename,
            rawImg,
            imageId;

    function readFile(x) {
        var input = $(x);
        if (input[0].files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.upload-demo').addClass('ready');
                $('#cropImagePop').modal('show');
                rawImg = e.target.result;
            }
            reader.readAsDataURL(input[0].files[0]);
        } else {
            console.log("Sorry - you're browser doesn't support the FileReader API");
        }
    }

    $uploadCrop = $('#upload-demo').croppie({
        viewport: {
            width: 250,
            height: 250,
        }
    });

    $('#cropImagePop').on('shown.bs.modal', function () {
        $uploadCrop.croppie('bind', {
            url: rawImg
        }).then(function () {
        });
    });


    $('#cropImageBtn').on('click', function (ev) {
        $uploadCrop.croppie('result', {
            type: 'base64',
            format: 'jpeg',
            size: {width: 1000, height: 1000}
        }).then(function (imgSrc) {

            icmsMessage({
                type: 'msgConfirmation',
                title: 'You are about to upload this picture.',
                onConfirm: function () {

                    icmsMessage({
                        type: 'msgPreloader',
                        visible: true
                    });

                    $.post(sDriveAPI, {
                        type: 'uploadCropImage',
                        image_source: imgSrc
                    }, function (rs) {
                        if (rs.data.flag == 1) {
                            var image_hash = rs.data.output.hash;

                            $('#cd-doc-file').attr('data-hash', image_hash);
                            $('#cd-doc-file').removeAttr('required');

                            $('#ucd-doc-file').attr('data-hash', image_hash);

                            // hide upload logo 
                            $('.div-cfu').hide();

                            // src 
                            $('#form-add_document_info img.img-uploaded').attr('src', sDriveViewer + image_hash);
                            $('#form-update_document_info img.img-uploaded').attr('src', sDriveViewer + image_hash);

                            //href 
                            $('#form-add_document_info a.img-uploaded').attr('href', sDriveViewer + image_hash);
                            $('#form-update_document_info a.img-uploaded').attr('href', sDriveViewer + image_hash);

                            // hide choose file to upload 
                            $('img.img-uploaded').show();

                            var mdl = $('#cropImagePop').attr('data-prev_modal');

                            icmsMessage({
                                type: 'msgPreloader',
                                visible: false
                            });

                            $('#' + mdl).modal('show');

                        } else {
                            alert('Something went wrong. Kindly try to reupload your picture');
                            location.reload();
                        }
                    }, 'json');


                },
                onShow: function () {
                    $('#cropImagePop').modal('hide');
                    $('img.cr-image').attr('src', '');
                },
                onCancel: function () {
                    $('#cropImagePop').modal('show');
                }
            });
        });
    });

    // crop image pop on close 
    $('#cropImagePop .btn-cancel').click(function () {
        var x = $('#cropImagePop').attr('data-prev_modal');
        $('#' + x).modal('show');
        $('img.cr-image').attr('src', '');
    });

    // add document  
    $('#cd-doc-file').on('change', function () {
        imageId = $(this).data('id');
        tempFilename = $(this).val();
        $('#cropImagePop').attr('data-prev_modal', 'modalcontent-add_document');
        readFile('#cd-doc-file');
        // hide modal
        $('#modalcontent-add_document').modal('hide');
    });

    // update document 
    $('#ucd-doc-file').on('change', function () {
        imageId = $(this).data('id');
        tempFilename = $(this).val();
        $('#cropImagePop').attr('data-prev_modal', 'modalcontent-update_document');
        readFile('#ucd-doc-file');
        // hide modal
        $('#modalcontent-update_document').modal('hide');
    });

});


function updateUploadedDocument() {
    var action = $('#cd-doc-file').attr('data-action');
    if (action == "add") {
        uploadDocuments();
    } else {
        //remove old data
        var id = $('#form-add_document_info').attr('stored-id');
        var storage = _getStorageData('document_attachment_info');
        _rmStorageDataById(storage, storage[id]);
        _setStorageData(storage, 'document_attachment_info');
        //add new transit details
        //getDocumentAttachmentInfoList();
        var hash = $('#cd-doc-file').attr('data-hash');
        storeDocumentAttachment(hash);
    }

}

function  uploadDocuments() {

    var data = new FormData();
    var file = document.getElementById("cd-doc-file").files;
    var uploadURL = window.location.origin + '/ajax/drive/ajax';
    data.append('file', file[0]);
    data.append('type', 'uploadFile');

    $('#modalcontent-add_document .modal-content').hide();

    icmsMessage({
        type: "msgPreloader",
        visible: true
    });

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
            var display_name = rs.data.output.display_name;
            storeDocumentAttachment(fileHash, display_name);

            icmsMessage({
                type: "msgPreloader",
                visible: false
            });


        },
        error: function () {
            //something went wrong
            icmsMessage({
                type: "msgWarning",
                visible: false
            });
        }

    });

}

function storeDocumentAttachment(hash, display_name) {
    var doc_category = $('#cd-sel-document-cat').val();
    var doc_type = $('#cd-sel-document-type').val();
    var doc_category_name = $('#cd-sel-document-cat option:selected').text();
    var doc_type_name = $('#cd-sel-document-type option:selected').text();
    var doc_remark = $('#cd-txt-doc-remarks').val();

    var storage = _getStorageData('document_attachment_info');
    if (!storage) {

        var document_attachment_info = [{
                'document_hash': hash,
                'document_display_name': display_name,
                'doc_category': doc_category,
                'doc_type': doc_type,
                'doc_category_name': doc_category_name,
                'doc_type_name': doc_type_name,
                'doc_remark': doc_remark
            }];

        _setStorageData(document_attachment_info, 'document_attachment_info');
    } else {
        var document_attachment_info = {
            'document_hash': hash,
            'document_display_name': display_name,
            'doc_category': doc_category,
            'doc_type': doc_type,
            'doc_category_name': doc_category_name,
            'doc_type_name': doc_type_name,
            'doc_remark': doc_remark
        };

        storage.push(document_attachment_info);

        _setStorageData(storage, 'document_attachment_info');

    }

    $("#modalcontent-add_document").modal('hide');
    $('#form-add_document_info')[0].reset();

    getDocumentAttachmentInfoList();
}

function updateDocumentAttachment() {
    var fileHash = $('#ucd-doc-file').attr('data-hash');
    var doc_remark = $('#ucd-txt-doc-remarks').val();
    var storedId = $('#form-update_document_info').attr('data-id');
    var current = _getStorageData('document_attachment_info');

    current[storedId]['document_hash'] = fileHash;
    current[storedId]['doc_remark'] = doc_remark;

    _setStorageData(current, 'document_attachment_info');

    $("#modalcontent-update_document").modal('hide');
    $('#form-update_document_info')[0].reset();

    getDocumentAttachmentInfoList();
}

function getDocumentAttachmentInfoList() {

    var documents = _getStorageData('document_attachment_info');

    var cnt = 0;
    var t = '';
    if (documents.length > 0) {
        $.each(documents, function (key, val) {
            //console.log('key->' + key + ' val->' + val);
            t += '<tr>';
//            t += '<td data-doc-hash-id="' + val.document_hash + '" data-doc-type-id="' + val.doc_type + '" data-doc-cat-id="' + val.doc_category + '">' + val.doc_category_name + '</td>';
//            t += '  <td width="40%" data-doc-hash-id="' + val.document_hash + '" data-doc-type-id="' + val.doc_type + '" data-doc-cat-id="' + val.doc_category + '">' + val.document_display_name + '</td>';
            t += '  <td width="80%">' + val.doc_remark + '</td>';
//            t += '<td>' + val.doc_remark + '</td>';
            t += '  <td width="20%" >';
            t += '       <div class="btn-group ellipse-action" data-id="vi-document_info_list' + cnt + '" data-tab="">';
            t += '          <a class="a-ellipse a-ellipse-' + cnt + ' " >  <i class="fa fa-ellipsis-v" aria-hidden="true"></i> </a>';
            t += '          <div class="action-menu" id="vi-document_info_list' + cnt + '">';
            t += '              <a class="dropdown-item disabled action-title" href="#">Select Action</a>';
            //t += '<a class="dropdown-item up-victim_document_info" data-id="' + cnt + '" >Update</a>';
//            t += '              <a class="dropdown-item" href="' + sDriveViewer + val.document_hash + '" target="_blank" data-id="' + cnt + '" >View</a>';
            t += '              <a class="dropdown-item upd-victim_document_info" data-id="' + cnt + '" data-remarks="' + val.doc_remark + '" data-hash="' + val.document_hash + '" >Manage</a>';
            t += '              <a class="dropdown-item rm-victim_document_info" data-id="' + cnt + '" >Remove</a>';
            t += '          </div>';
            t += '      </div>';
            t += '    </td>';
            t += '</tr>';

            cnt++;
        });

    } else {
        t += '<tr>';
        t += '<td colspan="5" class="text-center" style="text-align: center !important;">No picture attachments added to list.</td>';
        t += '</tr>';
    }

    $('#tbody-document-list').html(t);

    if (parseInt(documents.length) >= 1) {
        $('.btn-add_document').attr('disabled', true);
    } else {
        $('.btn-add_document').attr('disabled', false);
    }

}

function getGlobalComplainSource() {
    $.post(sAjaxGlobalData, {
        type: "getGlobalComplainSource"
    }, function (rs) {
        var l = "<option selected disabled >Select Source </option>",
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
        $('#cd-sel-source').html(l);
    }, 'json');
}

function getGlobalParameterTypeIdAndStatus() {
    $.post(sAjaxGlobalData, {
        type: "getGlobalParameter",
        parameter_type: "nextofkin",
    }, function (rs) {
        var other = "";
        l = "<option selected disabled >Select Relationship</option>";
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

        $('#cd-sel-relation').html(l);
    }, 'json');
}

function  getDocumentTypesByDocumentCategoryID(id) {
    $.post(sAjaxGlobalData, {
        type: "getDocumentTypesByDocumentCategoryID",
        id: id,
    }, function (rs) {

        l = "<option  selected  disabled> Select Document Type</option>";
        $.each(rs.data, function (key, val) {
            l += "<option value='" + val.id + "' data-name='" + val.document + "'>" + val.document + " </option>";
        });
        $('#cd-sel-document-type').html(l);
    }, 'json');
}

function getNationality() {
    $.post(sAjaxGlobalData, {
        type: "getNationality",
    }, function (rs) {
        var l = "<option selected disabled >Select Nationality</option>";
        $.each(rs.data, function (key, val) {
            l += "<option value='" + val.country_id + "' data-name='" + val.nationality + "'>" + val.nationality + " (" + val.country_name + ")" + " </option>";
        });
        $('.sel-nationality').html(l);
    }, 'json');
}

function getAssessmentType() {
    $.post(sAjaxGlobalData, {
        type: "getAssessmentType",
    }, function (rs) {
        l = "<option selected disabled >Select Assessment</option>";
        $.each(rs.data, function (key, val) {
            l += "<option value='" + val.transaction_parameter_count_id + "'>" + val.transaction_parameter_name + " </option>";
        });
        $('#cd-mdl-sel-assmnt-type').html(l);

    }, 'json');
}

function getActPurposeMeans() {

    $.post(sAjaxGlobalData, {
        type: "getActPurposeMeans",
    }, function (rs) {

        $('#cd-sel-acts').chosen("destroy");
        $('#cd-sel-means').chosen("destroy");
        $('#cd-sel-purposes').chosen("destroy");

        var a = "";
        var p = "";
        var m = "";
        $.each(rs.data.act, function (key, val) {
            a += "<option value='" + val.tip_details_count + "'>" + val.tip_details_name + " </option>";
        });

        $.each(rs.data.purpose, function (key, val) {
            p += "<option value='" + val.tip_details_count + "'>" + val.tip_details_name + " </option>";
        });

        $.each(rs.data.means, function (key, val) {
            m += "<option value='" + val.tip_details_count + "'>" + val.tip_details_name + " </option>";
        });

        $('#cd-sel-acts').html(a);
        $('#cd-sel-means').html(m);
        $('#cd-sel-purposes').html(p);


        $('#cd-sel-acts').chosen();
        $('#cd-sel-means').chosen();
        $('#cd-sel-purposes').chosen();

        $('#cd_sel_acts_chosen').css("width", "100%");
        $('#cd_sel_means_chosen').css("width", "100%");
        $('#cd_sel_purposes_chosen').css("width", "100%");
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
            if (val.services_id) {
                a += "<option value='" + val.services_id + "' data-days='" + val.service_days + "'>" + val.service_name + " </option>";
            }
        });
        $('#cd-mdl-sel-service').html(a);
        var selectd = $('#form-add_assessment_info').attr('data-service');
        $('#cd-mdl-sel-service').val(selectd).change();

    }, 'json');
}

function  getAgenciesWhichOfferServices(id) {
    $.post(sAjaxGlobalData, {
        type: "getAgenciesWhichOfferServices",
        serviceID: id,
    }, function (rs) {

        var a = "";
        $('#cd-mdl-sel-agncy').html(a);

        $.each(rs.data, function (key, val) {
            if (typeof val.agency_branch_id !== "undefined") {
                var services = _getStorageData('victim_services_info');
                if (services.length > 0) {
                    var is_check = 0;
                    $.each(services, function (sKey, sVal) {
                        if ((sVal.services == id) && (sVal.agency_tagged_id == val.agency_branch_id)) {
                            is_check = 1;
                        }
                    });
                    if (is_check == 0) {
                        a += "<option value='" + val.agency_branch_id + "'>" + val.agency_abbr + " - " + val.agency_branch_name + " </option>";
                    } else {
                        var storeServiceID = $('#form-add_assessment_info').attr('data-service');
                        if (storeServiceID == id) {
                            a += "<option value='" + val.agency_branch_id + "'>" + val.agency_abbr + " - " + val.agency_branch_name + " </option>";
                        }
                    }
                } else {
                    a += "<option value='" + val.agency_branch_id + "'>" + val.agency_abbr + " - " + val.agency_branch_name + " </option>";
                }
            }
        });

        if (a == "") {
            a = "<option>No  Agency Available</option>";
            $('.btn-save-assessment').attr("disabled", "disabled");
        } else {
            $('.btn-save-assessment').removeAttr("disabled");
        }

        $('#cd-mdl-sel-agncy').html(a);

        if ($('#cd-mdl-sel-agncy').chosen()) {
            $('#cd-mdl-sel-agncy').chosen('destroy');
        }

    }, 'json');
}

function saveVictimeAssessment() {
    var agencies_val = $('#cd-mdl-sel-agncy').val();
    var arr_agency = [];
    $("#cd-mdl-sel-agncy option:selected").each(function () {
        var newx = $(this).text().replace(",", " ");
        arr_agency.push({"agency": newx});
    });

    var arr_agency_id = [];
//    $.each(agencies_val, function (key, val) {
    arr_agency_id.push({"agency_id": agencies_val});
//    });

    var combine_arr = [];
    $.each(arr_agency_id, function (k, v) {
        $.each(arr_agency, function (kk, vv) {
            if (k == kk) {
                combine_arr.push({"agency_id": v.agency_id, "agency_name": vv.agency});
            }
        });
    });

    var agency_json = JSON.stringify(combine_arr);
    var agency_tagged_id = $("#cd-mdl-sel-agncy").chosen().val();
    var assessment_type = $("#cd-mdl-sel-assmnt-type").val();
    var assessment_type_name = $("#cd-mdl-sel-assmnt-type option:selected").text();
    var services = $("#cd-mdl-sel-service").val();
    var services_name = $("#cd-mdl-sel-service option:selected").text();
    var aging = $("#cd-mdl-txt-set-age").val();
    var departure = $("#cd-mdl-txt-departure-date").val();
    var arrival = $("#cd-mdl-txt-arrival-date").val();
    var remarks = $("#cd-mdl-txt-remarks").val();

    var storage = _getStorageData('victim_services_info');
    if (!storage) {
        var victim_services_info = [{
                'agency_json': agency_json,
                'agency_tagged_id': agency_tagged_id,
                'assessment_type': assessment_type,
                'services': services,
                'aging': aging,
                'departure': departure,
                'arrival': arrival,
                'remarks': remarks,
                'assessment_type_name': assessment_type_name,
                'services_name': services_name
            }];

        _setStorageData(victim_services_info, 'victim_services_info');
    } else {
        var victim_services_info = {
            'agency_json': agency_json,
            'agency_tagged_id': agency_tagged_id,
            'assessment_type': assessment_type,
            'services': services,
            'aging': aging,
            'departure': departure,
            'arrival': arrival,
            'remarks': remarks,
            'assessment_type_name': assessment_type_name,
            'services_name': services_name
        };

        storage.push(victim_services_info);

        _setStorageData(storage, 'victim_services_info');

    }

    $('#form-add_assessment_info')[0].reset();
    $('#modal-Initial-asssessment').modal('hide');
    getServicesInfoList();
}

function getServicesInfoList() {

    var services = _getStorageData('victim_services_info');
    var cnt = 0;
    var t = '';
    if (services.length > 0) {
        $.each(services, function (key, val) {

            t += '<tr>';
            t += '<td data-country-id="' + val.agency_json + '">' + val.services_name + '</td>';
            var arr_agency = JSON.parse(val.agency_json);
            var agn_name = "";
            $.each(arr_agency, function (k, v) {
                if (agn_name == "") {
                    agn_name += v.agency_name;
                } else {
                    agn_name += ", " + v.agency_name;
                }
            });

            t += '<td>' + agn_name + '</td>';

            var datetoday = new Date();
            var dateAge = parseDate(val.aging);
            var remainingday = datediff(datetoday, dateAge);
            if (parseInt(remainingday) < 1) {
                remainingday = "0";
            }
            t += '<td>' + remainingday + '</td>';
            t += '<td>' + val.remarks + '</td>';
            t += '<td> <div class="btn-group ellipse-action" data-id="vi-victim_service_info' + cnt + '" data-tab="">';
            t += '<a class="a-ellipse a-ellipse-victim_service_info' + cnt + ' " >  <i class="fa fa-ellipsis-v" aria-hidden="true"></i> </a>';
            t += '<div class="action-menu" id="vi-victim_service_info' + cnt + '">';
            t += '<a class="dropdown-item disabled action-title" href="#">Select Action</a>';
            t += '<a class="dropdown-item up-victim_service_info" data-id="' + cnt + '" >Update</a>';
            t += '<a class="dropdown-item rm-victim_service_info" data-id="' + cnt + '" >Remove</a>';
            t += '</div>';
            t += '</div> </td>';
            t += '</tr>';
            cnt++;
        });
    } else {
        t += '<tr>';
        t += '<td colspan="5" class="text-center" style="text-align: center !important;">No transit info added to list.</td>';
        t += '</tr>';
    }

    $('#tbl-services-list').html(t);
}

function parseDate(str) {
    var mdy = str.split('/');
    return new Date(mdy[2], mdy[0] - 1, mdy[1]);
}

function datediff(first, second) {
    // Take the difference between the dates and divide by milliseconds per day.
    // Round to nearest whole number to deal with DST.
    return Math.round((second - first) / (1000 * 60 * 60 * 24)) + 1;
}

function storeCaseDetails() {

    var victim_complainant_details = {
        'date_complained': $('.case-date_complained').val(),
        'complainant_source': $('.case-complainant_source').val(),
        'complainant_source_value': $('.case-complainant_source option:selected').attr('data-name'),
        'complainant_name': $('.case-complainant_name').val(),
        'complainant_relation': $('.case-complainant_relation').val(),
        'complainant_relation_value': $('.case-complainant_relation option:selected').attr('data-name'),
        'complainant_relation_other': $('.case-complainant_relation_other').val(),
        'complainant_address': $('.case-complainant_address').val(),
        'complainant_place_of_incident': $('.case-complainant_place_of_incident').val(),
        'complainant_place_of_origin': $('.case-complainant_place_of_origin').val(),
        'complainant_contact': $('.case-complainant_contact').val(),
        'complainant_remarks': $('.case-complainant_remarks').val(),
        'complainant_place_of_destination': $('.case_place_of_destination').val(),
        'complainant_date_time_of_incident': $('.case-date_time_of_incident').val(),
        'complainant_other_possible_source_info': $('.case-other_possible_source_info').val()
        
    };

    //Acts
    var act = $('#cd-sel-acts').chosen().val();
    var arr_act = [];
    $("#cd-sel-acts option:selected").each(function () {
        var newx = $(this).text().replace(",", " ");
        arr_act.push({"act": newx});
    });

    var arr_act_id = [];
    $.each(act, function (key, val) {
        arr_act_id.push({"act_id": val});
    });

    var act_combine_arr = [];
    $.each(arr_act_id, function (k, v) {
        $.each(arr_act, function (kk, vv) {
            if (k == kk) {
                act_combine_arr.push({"act_id": v.act_id, "act": vv.act});
            }
        });
    });

    //Means
    var mean = $('#cd-sel-means').chosen().val();
    var arr_mean = [];
    $("#cd-sel-means option:selected").each(function () {
        var newx = $(this).text().replace(",", " ");
        arr_mean.push({"mean": newx});
    });

    var arr_mean_id = [];
    $.each(mean, function (key, val) {
        arr_mean_id.push({"mean_id": val});
    });

    var mean_combine_arr = [];
    $.each(arr_mean_id, function (k, v) {
        $.each(arr_mean, function (kk, vv) {
            if (k == kk) {
                mean_combine_arr.push({"mean_id": v.mean_id, "mean": vv.mean});
            }
        });
    });

    //Purpose
    var purpose = $('#cd-sel-purposes').chosen().val();
    var arr_purpose = [];
    $("#cd-sel-purposes option:selected").each(function () {
        var newx = $(this).text().replace(",", " ");
        arr_purpose.push({"purpose": newx});
    });

    var arr_purpose_id = [];
    $.each(purpose, function (key, val) {
        arr_purpose_id.push({"purpose_id": val});
    });

    var purpose_combine_arr = [];
    $.each(arr_purpose_id, function (k, v) {
        $.each(arr_purpose, function (kk, vv) {
            if (k == kk) {
                purpose_combine_arr.push({"purpose_id": v.purpose_id, "purpose": vv.purpose});
            }
        });
    });

//
    var acts = JSON.stringify(act_combine_arr);
    var means = JSON.stringify(mean_combine_arr);
    var purposes = JSON.stringify(purpose_combine_arr);

    var victim_case_details = {
        'facts': $('.case-facts').val(),
        'evaluation': $('.case-evaluation').val(),
        'risk_assessment': $('.case-risk_assessment').val(),
        'is_illegal_rec': $('.case-is_illegal_rec ').is(':checked') ? '1' : '0',
        'is_other_law': $('.case-is_other_law').is(':checked') ? '1' : '0',
        'other_law_desc': $('.case-other_law_desc').val(),
        'acts': acts,
        'means': means,
        'purposes': purposes
    };

    var victim_case_evaluation_details = {
        'evaluation': $('.case-evaluation').val()
    };
    var victim_case_risk_assessment = {
        'risk-assessment': $('.case-risk_assessment').val()
    };

    _setStorageData(victim_complainant_details, 'victim_complainant_details');

    _setStorageData(victim_case_details, 'victim_case_details');

    _setStorageData(victim_case_evaluation_details, 'victim_case_evaluation_details');
    _setStorageData(victim_case_risk_assessment, 'victim_case_risk_assessment');

//    $('#summary-details-tab1').trigger('click');
//
//    //enable summary tab
//    $('#summary-details-tab1').attr('disabled', false);
}

function getVictimCaseInfo() {

    var storages = ['victim_complainant_details',
        'victim_case_details',
        'victim_case_evaluation_details'
    ];

    $.each(storages, function (key, val) {
        var data = _getStorageData(val);
        $.each(data, function (key, val) {
            $(".case-" + key).val(val);
        });
    });

    var details_vcd = _getStorageData('victim_case_details');
    details_vcd['is_illegal_rec'] == '1' ? $('.case-is_illegal_rec').click() : "";
    details_vcd['is_other_law'] == '1' ? $('.case-is_other_law').click() : "";

    $('.emp-passport_province').change();
    $('.emp-deployment_departure_type').change();
    $('.emp-port_of_exit').change();

    //act means purpose
    var arr_selected = _getStorageData('victim_case_details');

    if (arr_selected) {
        var amps = ['acts', 'means', 'purposes'];

        $.each(amps, function (k, v) {

            var data = JSON.parse(arr_selected[v]);

            $.each(data, function (kk, vv) {
                if (v == 'acts') {
                    var id = vv.act_id;
                } else if (v == 'means') {
                    var id = vv.mean_id;
                } else if (v == 'purposes') {
                    var id = vv.purpose_id;
                }
                $("#cd-sel-" + v + " option[value=" + id + "]").prop("selected", true);
            });
            $('#cd-sel-' + v).chosen();
            $('#cd-sel-' + v).trigger("chosen:updated");
        });
    }
}

function storeCaseOffender() {

    var storage = _getStorageData('victim_case_offender');

    if (!storage) {

        var victim_case_offender = [{
                'offender_type': $('.a-case-offender_type').val(),
                'offender_type_name': $('.a-case-offender_type option:selected').text(),
                'offender_name': $('.a-case-offender_name').val(),
                'offender_nationality': $('.a-case-offender_nationality').val(),
                'offender_nationality_name': $('.a-case-offender_nationality option:selected').text(),
                'offender_relation': $('.a-case-offender_relation').val(),
                'offender_address': $('.a-case-offender_address').val(),
                'offender_contact': $('.a-case-offender_contact').val(),
                'offender_alias': $('.a-case-offender_alias').val(),
                'offender_pob': $('.a-case-offender_place_of_birth').val(),
                'offender_remarks': $('.a-case-offender_remarks').val(),
                'offender_dob': $('.a-case-offender_date_of_birth').val(),
                'offender_occupation': $('.a-case-offender_occupation').val(),
                'offender_principal_place_of_business': $('.a-case-offender_principal_place_of_business').val(),
                'offender_gender': $('.a-case-offender_gender').val(),
                'offender_gender_type_value': $('.a-case-offender_gender option:selected').val(),
                'offender_religion': $('.a-case-offender_religion').val(),
                'offender_religion_type_value': $('.a-case-offender_religion').val()
                
            }];

        _setStorageData(victim_case_offender, 'victim_case_offender');
    } else {

        var victim_case_offender = {
            'offender_type': $('.a-case-offender_type').val(),
            'offender_type_name': $('.a-case-offender_type option:selected').text(),
            'offender_name': $('.a-case-offender_name').val(),
            'offender_nationality': $('.a-case-offender_nationality').val(),
            'offender_nationality_name': $('.a-case-offender_nationality option:selected').text(),
            'offender_relation': $('.a-case-offender_relation').val(),
            'offender_address': $('.a-case-offender_address').val(),
            'offender_contact': $('.a-case-offender_contact').val(),
            'offender_remarks': $('.a-case-offender_remarks').val()
        };

        storage.push(victim_case_offender);

        _setStorageData(storage, 'victim_case_offender');

    }

    $('#form-add_offender')[0].reset();
    $('#modal-add_case_offender').modal('hide');

    //show list
    getCaseOffenderList();

}

function getCaseOffenderList() {

    var aOffender = [
        {
            name: "inp_emp-employer_name",
            id: 1
        },
        {
            name: "emp-local_agency_name",
            id: 2
        },
        {
            name: "emp-foreign_agency_name",
            id: 3
        }
    ];

    $.each(aOffender, function (key, val) {

        var sName = $('.' + val.name).val();
        $(".a-case-offender_type option[value=" + val.id + "]").attr("disabled", "true");
        $(".u-case-offender_type option[value=" + val.id + "]").attr("disabled", "true");

        if (sName) {
            $(".a-case-offender_type option[value=" + val.id + "]").removeAttr("disabled");
            $(".u-case-offender_type option[value=" + val.id + "]").removeAttr("disabled");
        }
    });




    var offenders = _getStorageData('victim_case_offender');

    var cnt = 0;
    var t = '';
    if (offenders.length > 0) {
        $.each(offenders, function (key, val) {

            switch (val.offender_type) {
                case '1':
                    sOffenderName = $('.inp_emp-employer_name').val();
                    break;
                case '2':
                    sOffenderName = $('.emp-local_agency_name').val();
                    break;
                case '3':
                    sOffenderName = $('.emp-foreign_agency_name').val();
                    break;
                default:
                    sOffenderName = val.offender_name;
            }

            // disabled option that exist
            $(".a-case-offender_type option[value=" + val.offender_type + "]").attr("disabled", "true");
            $(".u-case-offender_type option[value=" + val.offender_type + "]").attr("disabled", "true");

            // other
            $(".u-case-offender_type option[value='4']").removeAttr("disabled");
            $(".a-case-offender_type option[value='4']").removeAttr("disabled");

            t += '<tr>';
            t += '  <td>' + sOffenderName + '</td>';
            t += '  <td>' + val.offender_type_name + '</td>';
            t += '  <td> <div class="btn-group ellipse-action" data-id="vi-offender_info_list' + cnt + '" data-tab="">';
            t += '      <a class="a-ellipse a-ellipse-offender_info_list' + cnt + ' " >  <i class="fa fa-ellipsis-v" aria-hidden="true"></i> </a>';
            t += '      <div class="action-menu" id="vi-offender_info_list' + cnt + '">';
            t += '      <a class="dropdown-item disabled action-title" href="#">Select Action</a>';
            t += '      <a class="dropdown-item up-victim_case_offender" data-id="' + cnt + '" >Update</a>';
            t += '      <a class="dropdown-item rm-victim_case_offender" data-id="' + cnt + '" >Remove</a>';
            t += '      </div>';
            t += '      </div> </td>';
            t += '</tr>';

            cnt++;
        });
    } else {
        t += '<tr>';
        t += '<td colspan="3" class="text-center" style="text-align: center !important;">No offender added to list.</td>';
        t += '</tr>';
    }

    $('.victim-offender_info_list').html(t);
}

function storeCaseOffenderById() {
    var storedId = $('.stored-offender_id').val();

    var current = _getStorageData('victim_case_offender');

    $.each(current[storedId], function (key, val) {
        current[storedId][key] = $('.u-case-' + key).val();
    });

    //get name of type
    current[storedId]['offender_type_name'] = $('.u-case-offender_type option:selected').text();

    _setStorageData(current, 'victim_case_offender');

    $("#modal-update_case_offender").modal('hide');
    $('#form-update_offender')[0].reset();

    getCaseOffenderList();

}
