function activateComplain(action) {
    if (action == "toenabled") {
//enable element on page load
        $('#frm-complainant :input').prop("disabled", false);
        $('#cd-sel-source').prop("disabled", false);
        $('.case-complainant_relation').prop("disabled", false);
        $('#btn-complain').attr("dataaction", 'todisabled');
        $('#btn-complain-cancel').removeClass("hide");
        $('#btn-complain').text("Save");
    } else {
//disabled element on page load
        $('#frm-complainant :input').prop("disabled", true);
        $('#cd-sel-source').prop("disabled", true);
        $('.case-complainant_relation').prop("disabled", true);
        $('#btn-complain').attr("dataaction", "toenabled");
        $('#btn-complain-cancel').addClass("hide");
        $('#btn-complain').text("Manage");
    }
}
function activateAMP(action) {
    if (action == "1") {
        $('.ul-cd-sel-amp').hide();
        $('.div-cd-sel-amp').show();
        $('.chosen-disabled').removeClass("chosen-disabled");
        //$('#area-brief-facts').attr("disabled", false);
        $('#btn-facts').attr("dataaction", 1);
        $('#btn-fact-cancel').removeClass("hide");
        $('#btn-facts').text("Save");
        // enable 
        $("#frm-act-means-purpose :input").prop("disabled", false);
    } else {
        $('.ul-cd-sel-amp').show();
        $('.div-cd-sel-amp').hide();
        $('.chosen-disabled').addClass("chosen-disabled");
        //$('#area-brief-facts').attr("disabled", true);
        $('#btn-facts').attr("dataaction", 0);
        $('#btn-fact-cancel').addClass("hide");
        $('#btn-facts').text("Manage");
        // disabled 
        $("#frm-act-means-purpose :input").prop("disabled", true);
    }
}
function removeDocument(docid) {
    icmsMessage({
        type: "msgPreloader",
        body: "Removing... Please wait!",
        visible: true
    });
    var caseid = $('#case_id').val();
    $.post(sAjaxCaseDetails, {
        type: "removeDocument",
        docid: docid,
        caseid: caseid,
    }, function (rs) {
        //success
        getUploadedDocuments();
        notifyChangesInReport();
    }, 'json');
}
function removeOffenderDetails(offenderid) {
    icmsMessage({
        type: "msgPreloader",
        body: "Removing... Please wait!",
        visible: true
    });
    var caseid = $('#case_id').val();
    $.post(sAjaxCaseDetails, {
        type: "removeOffender",
        offenderid: offenderid,
        caseid: caseid,
    }, function (rset) {
        //success
        getCaseAllegedOffender();
        notifyChangesInReport();
    }, 'json');
}

// Complainant Details  SHOW
function getComplainantDetails(isAction) {
    var caseid = $('#case_id').val();
    $.post(sAjaxCaseDetails, {
        type: "getComplainantDetailsByCaseId",
        caseid: caseid,
    }, function (rs) {
        if (rs.data.result == "1") {
            rs = html_entity_decode(rs);
            var list = rs.data.list;
            $('#btn-complain').attr('complainid', list.case_complainant_id);
            $('#date-complained').val(dateFormatToPicker(list.case_complainant_date_complained));
            $('#cd-sel-source').val(list.case_complainant_source_id).change();
            $('#cd-txt-name').val(list.case_complainant_name);
            $('#sel-relation-to-victim').val(list.case_complainant_relation).change();
            $('#complainant_address').val(list.case_complainant_address);
            $('#complainant_contact').val(list.case_complainant_contact_number);
            $('#complainant_contact_alternate').val(list.case_complainant_alternate_contact_number);
            $('#case-complainant_place_of_incident').val(list.case_complainant_place_of_incident);
            $('#case-complainant_place_of_origin').val(list.case_complainant_place_of_origin);
            $('#case-place_of_destination').val(list.case_complainant_place_of_destination);
            $('#complainant_remarks').val(list.case_complainant_remarks);
            $('#complainant_relation_other').val(list.case_complainant_relation_other);
            var relation = list.complainant_relation;
            if (relation.toLowerCase() == "other") {
                $('.div-relation-other').show();
            } else {
                $('.div-relation-other').hide();
            }

            aInitialValues["complainant"] = '';
            aInitialValues["complainant"] = getFormValues('frm-complainant');
            // for add 
            if (isAction == '1') {
                notifyChangesInReport();
            } else {
                icmsMessage({
                    type: "msgPreloader",
                    visible: false,
                });
            }

        }
    }, 'json');
}
function  setActMeansPurpose() {
    var acts_arr = $('#cd-sel-acts').chosen().val();
    var means_arr = $('#cd-sel-means').chosen().val();
    var purpose_arr = $('#cd-sel-purposes').chosen().val();
    var act_ctr = 0;
    var acts = "";
    $.each(acts_arr, function (key, val) {
        if (act_ctr == 0) {
            acts = val;
        } else {
            acts += "," + val;
        }
        act_ctr++;
    });
    var means_ctr = 0;
    var means = "";
    $.each(means_arr, function (key, val) {
        if (means_ctr == 0) {
            means = val;
        } else {
            means += "," + val;
        }
        means_ctr++;
    });
    var purpose_ctr = 0;
    var purpose = "";
    $.each(purpose_arr, function (key, val) {
        if (purpose_ctr == 0) {
            purpose = val;
        } else {
            purpose += "," + val;
        }
        purpose_ctr++;
    });
    var caseid = $('#case_id').val();
    $.post(sAjaxCaseDetails, {
        type: "setActMeansPurpose",
        acts: acts,
        means: means,
        purpose: purpose,
        remarks: $('#area-brief-facts').val(),
        caseid: caseid,
        casevictimid: $('#btn-facts').attr('case-victim-id'),
        is_illegal_rec: $('.case-is_illegal_rec ').is(':checked') ? '1' : '0',
        is_other_law: $('.case-is_other_law').is(':checked') ? '1' : '0',
        other_law_desc: $('.case-other_law_desc').val(),

    }, function (rs) {
        // msg alert
        notifyChangesInReport();
    }, 'json');
    getLabelForTIPContent();
}
function addSetOffenderInfo() {
    var action = $('#btn-save-offender').attr('action');
    var offenderid = $('#btn-save-offender').attr('offenderid');
    var caseid = $('#case_id').val();
//    var fullname = $('#txtoffendername').val();
//    var position = $('#seloffenderposition').val();
//    var nationality = $('#seloffendernationality').val();
//    if (nationality == "0") {
//        nationality = "";
//    }
//    var contact = $('#txtoffendercontact').val();
//    var address = $('#offenderaddress').val();
//    var remarks = $('#offederremarks').val();

    var offender_type = $('.a-case-offender_type').val();
    var offender_type_name = $('.a-case-offender_type option:selected').text();
    var offender_name = $('.a-case-offender_name').val();
    var offender_nationality = $('.a-case-offender_nationality').val();
    var offender_nationality_name = $('.a-case-offender_nationality option:selected').text();
    var offender_relation = $('.a-case-offender_relation').val();
    var offender_address = $('.a-case-offender_address').val();
    var offender_contact = $('.a-case-offender_contact').val();
    var offender_remarks = $('.a-case-offender_remarks').val();
    $.post(sAjaxCaseDetails, {
        type: "addSetOffenderInfo",
        action: action,
        offenderid: offenderid,
        caseid: caseid,
        offender_type: offender_type,
        offender_type_name: offender_type_name,
        offender_name: offender_name,
        offender_nationality: offender_nationality,
        offender_nationality_name: offender_nationality_name,
        offender_relation: offender_relation,
        offender_address: offender_address,
        offender_contact: offender_contact,
        offender_remarks: offender_remarks

    }, function (rs) {
        getCaseAllegedOffender();
        $('#modalcontent-add_offender').modal("hide");
        $('#txtoffendername').val("");
        $('#seloffenderposition').val("").change();
        $('#seloffendernationality').val("").change();
        $('#txtoffendercontact').val("");
        $('#offenderaddress').val("");
        $('#offederremarks').val("");
        notifyChangesInReport();
    }, 'json');
}
function setComplainantDetails() {

    icmsMessage({
        type: "msgPreloader",
        body: "Saving... Please wait!",
        visible: true
    });
    var complainantid = $('#btn-complain').attr('complainid');
    var datecomplained = $('#date-complained').val();
    var complainsource = $('#cd-sel-source').val();
    var complainantname = $('#cd-txt-name').val();
    var relation = $('#sel-relation-to-victim').val();
    var address = $('#complainant_address').val();
    var contact = $('#complainant_contact').val();
    var alternatecontact = $('#complainant_contact_alternate').val();
    var placeofincident = $('#case-complainant_place_of_incident').val();
    var placeoforigin = $('#case-complainant_place_of_origin').val();
    var placeofdestination = $('#case-place_of_destination').val();
    var remarks = $('#complainant_remarks').val();
    var relationother = $('#complainant_relation_other').val();
    var caseid = $('#case_id').val();
    $.post(sAjaxCaseDetails, {
        type: "setComplainantDetails",
        case_id: $('#case_id').val(),
        complainantid: complainantid,
        datecomplained: datecomplained,
        complainsource: complainsource,
        complainantname: complainantname,
        relation: relation,
        address: address,
        contact: contact,
        alternatecontact: alternatecontact,
        placeofincident: placeofincident,
        placeoforigin: placeoforigin,
        placeofdestination: placeofdestination,
        remarks: remarks,
        relationother: relationother,
        caseid: caseid,
    }, function (rs) {
        if (rs.data.php_validation.flag == "0") {
            //modal for incorect param
            icmsMessage({
                type: "msgWarning",
                visible: false,
            });
        } else {
            activateComplain("todisabled");
            //modal for success
            getComplainantDetails('1');
        }
    }, 'json');
}
function getCaseEvaluation(isAction) {
    var caseid = $('#case_id').val();
    $.post(sAjaxCaseDetails, {
        type: "getCaseEvaluation",
        caseid: caseid,
    }, function (rs) {
        rs = html_entity_decode(rs);
        $('#area-evaluation').val(rs.data.evaluation.case_evaluation);
        $('#area-case-risk-assessment').val(rs.data.evaluation.case_risk_assessment);
        $('.div-priority_level .form-check-input[value="' + rs.data.evaluation.case_priority_level_id + '"]').attr('checked', true)
        aInitialValues["case_priority_level_id"] = rs.data.evaluation.case_priority_level_id;
        aInitialValues["case_evaluation"] = '';
        aInitialValues["case_evaluation"] = getFormValues('fmr-manage-evaluation');
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
function setCaseEvaluation() {
    var caseid = $('#case_id').val();
    var evaluation = $('#area-evaluation').val();
    var risk_assessment = $('#area-case-risk-assessment').val();
    $.post(sAjaxCaseDetails, {
        type: "setCaseEvaluation",
        evaluation: evaluation,
        risk_assessment: risk_assessment,
        caseid: caseid,
    }, function (rs) {
        getCaseEvaluation('1');
    }, 'json');
}
function getCaseAllegedOffender() {
    var caseid = $('#case_id').val();
    $.post(sAjaxCaseDetails, {
        type: "getCaseAllegedOffender",
        caseid: caseid,
    }, function (rs) {
        rs = html_entity_decode(rs);
        var list = "";
        if (rs.data.result >= 1) {
            //with content
            $.each(rs.data.offender, function (key, val) {
                var attribs = "";
                attribs += "alg-name='" + val.case_offender_name + "'";
                attribs += "alg-position='" + val.offender_type + "'";
                attribs += "alg-nationality='" + val.case_offender_nationality + "'";
                attribs += "alg-contact='" + val.case_offender_contact_details + "'";
                attribs += "alg-address='" + val.case_offender_address + "'";
                attribs += "alg-remarks='" + val.case_offender_remarks + "'";
                attribs += "alg-position='" + val.offender_type + "'";
                list += '<tr ' + attribs + ' >';
                list += '   <td width="50%">';
                var alleged_name = '';
                switch (val.case_offender_type_id) {
                    case  "1":
                        alleged_name = $('.emp-employer-employer_name').val();
                        break;
                    case  "2":
                        alleged_name = $('.emp-local-recruitment_agency_name').val();
                        break;
                    case  "3":
                        alleged_name = $('.emp-foreign-recruitment_agency_name').val();
                        break;
                    default:
                        alleged_name = val.case_offender_name;
                }
        //OSAEC CODE START        
                alleged_name = val.case_offender_name;
        //OSAEC CODE END        
                list += alleged_name;
//                list += '       <span class="icms-text-secondary">Name : </span><span>' + val.case_offender_name + '</span><br>';
//                list += '       <span class="icms-text-secondary">Position : </span><span>' + val.offender_type + '</span><br>';
//                list += '       <span class="icms-text-secondary">Nationality : </span><span>' + val.case_offender_nationality + '</span><br>';
//                list += '       <span class="icms-text-secondary">Contact : </span><span>' + val.case_offender_contact_details + '</span><br>';
//                list += '       <span class="icms-text-secondary">Address : </span><span>' + val.case_offender_address + '</span>';
                list += '   </td>';
                //list += '   <td  width="40%">' + val.case_offender_remarks + '</td>';
                list += '   <td  width="40%">' + val.offender_type + '</td>';
                list += '   <td width="10%">';
                list += '       <div class="btn-group ellipse-action" data-id="' + val.case_offender_id + '">';
                list += '           <a class="a-ellipse a-ellipse-' + val.case_offender_id + ' action_btn" >  <i class="fa fa-ellipsis-v" aria-hidden="true"></i> </a>';
                list += '           <div class="action-menu-offender c-out" id="id-' + val.case_offender_id + '">';
                list += '               <a class="dropdown-item disabled action-title" href="#">Select Action</a>';
                list += '               <a class="dropdown-item a-update-offender" data-id=' + val.case_offender_id + ' href="#">Update</a>';
                list += '               <a class="dropdown-item a-remove-offender" data-id=' + val.case_offender_id + ' href="#">Remove</a>';
                list += '           </div>';
                list += '       </div>';
                list += '   </td>';
                list += '</tr>';
            });
            $('#tbl-offender-list').attr('content', "1"); //data for printing report

            parseInt(rs.data.offender.length) >= 10 ? $('#btn-add-offender').prop('disabled', true) : $('#btn-add-offender').prop('disabled', false);
        } else {
            //no content
            list += "<tr><td colspan='3' class='text-center'>No Alleged Offender's Information added to list.</td></tr>";
            $('#tbl-offender-list').attr('content', "0"); //data for printing report   
        }
        $('#tbl-offender-list').html(list);
    }, 'json');
}
function getOffenderPosition() {
    $.post(sAjaxGlobalData, {
        type: "getTransactionParameter",
        transaction_type: 'offender_type'
    }, function (rs) {
        var l = "<option value='0' selected >Select Offender Type</option>";
        $.each(rs.data, function (key, val) {
            l += "<option value='" + val.transaction_parameter_count_id + "' data-name='" + val.transaction_parameter_name + "'>" + val.transaction_parameter_name + "</option>";
        });
        $('#seloffenderposition').html(l);
    }, 'json');
}
function getUploadedDocuments() {
    var caseid = $('#case_id').val();
    $.post(sAjaxCaseDetails, {
        type: "getUploadedDocuments",
        caseid: caseid,
    }, function (rs) {
        rs = html_entity_decode(rs);
        var docs = "";
        if (parseInt(rs.data.result) >= 1) {
            $.each(rs.data.docs, function (key, val) {
                docs += "<tr>";
//                docs += "   <td width='15%'>" + val.document_category + "</td>";
//                docs += "   <td width='15%'>" + val.document_type + "</td>";
//                docs += "   <td width='30%'>" + val.documents_display_name + "</td>";
                docs += "   <td width='70%'>" + val.case_file_upload_remarks + "</td>";
                docs += "   <td width='20%'>" + dateViewingFormat(val.case_file_upload_date_added) + "</td>";
                docs += "   <td width='10%'>";
                docs += '       <div class="btn-group ellipse-action" data-id="' + val.case_file_upload_id + '">';
                docs += '           <a class="a-ellipse a-ellipse-' + val.case_file_upload_id + ' action_btn" >  <i class="fa fa-ellipsis-v" aria-hidden="true"></i> </a>';
                docs += '           <div class="action-menu-docs c-out" id="id-doc' + val.case_file_upload_id + '" >';
                docs += '               <a class="dropdown-item disabled action-title" href="#">Select Action</a>';
                //docs += '               <a href="' + sDriveViewer + val.document_hash + '" target="_blank" class="dropdown-item a-update-docs"  data-id=' + val.case_file_upload_id + ' href="#">View</a>'; 
                docs += '               <a href="#" class="dropdown-item a-update-docs"  data-id=' + val.case_file_upload_id + ' data-hash=' + sDriveViewer + val.document_hash + ' data-remarks=' + val.case_file_upload_remarks + ' href="#">Manage</a>';
                docs += '               <a class="dropdown-item a-remove-docs" data-id=' + val.case_file_upload_id + ' href="#">Remove</a>';
                docs += '           </div>';
                docs += '       </div>';
                docs += "   </td>";
                docs += "</tr>";
            });
        } else {
            docs += "<tr><td colspan='6' class='text-center'>No document added on the list.</td></tr>";
        }
        $('#tbody-document-list').html(docs);
        parseInt(rs.data.docs.length) >= 1 ? $('.btn-add_document').prop('disabled', true) : $('.btn-add_document').prop('disabled', false);
    }, 'json');
}
function  getServicesByAssessmentID(id) {
    $.post(sAjaxGlobalData, {
        type: "getServicesByAssessmentID",
        assmntID: id,
    }, function (rs) {
        var a = "";
        a += "<option value=''>Select Services</option>";
        $.each(rs.data, function (key, val) {
            a += "<option value='" + val.services_id + "' data-days='" + val.service_days + "'>" + val.service_name + " </option>";
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
        $.each(rs.data, function (key, val) {
            if (typeof val.agency_branch_id !== "undefined") {
                a += "<option value='" + val.agency_branch_id + "'>" + val.agency_abbr + " - " + val.agency_branch_name + " </option>";
            }
        });
        if (a == "") {
            a = "<option>No  Agency Available</option>";
            $('.btn-save-assessment').attr("disabled", "disabled");
        } else {
            $('.btn-save-assessment').removeAttr("disabled");
        }

        $('#cd-mdl-sel-agncy').html(a);
    }, 'json');
}
function  uploadDocuments() {

    icmsMessage({
        type: "msgPreloader",
        visible: true,
    });
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
            addNewDocument(fileHash);
        },
        error: function () {
            //something went wrong
        }

    });
}
function addNewDocument(fileHash) {
    var doc_category = $('#cd-sel-document-cat').val();
    var doc_type = $('#cd-sel-document-type').val();
    var doc_remark = $('#cd-txt-doc-remarks').val();
    var caseid = $('#case_id').val();
    $.post(sAjaxCaseDetails, {
        type: "addNewDocument",
        doc_category: doc_category,
        doc_type: doc_type,
        doc_remark: doc_remark,
        caseid: caseid,
        fileHash: fileHash,
    }, function (rs) {
        //success
        getUploadedDocuments();
        $('#cd-sel-document-cat').val(0).change();
        $('#cd-sel-document-type').val(0).change();
        $('#cd-txt-doc-remarks').val("");
        notifyChangesInReport();
    }, 'json');
}
function updateDocument(fileHash) {
    var doc_remark = $('#ucd-txt-doc-remarks').val();
    var document_id = $('#ucd-txt-doc-remarks').attr('data-id');
    var caseid = $('#case_id').val();
    $.post(sAjaxCaseDetails, {
        type: "updateDocument",
        doc_remark: doc_remark,
        caseid: caseid,
        fileHash: fileHash,
        document_id: document_id
    }, function (rs) {
        //success
        getUploadedDocuments();
        notifyChangesInReport();
    }, 'json');
}
function getGlobalComplainSource() {
    $.post(sAjaxGlobalData, {
        type: "getGlobalComplainSource"
    }, function (rs) {
        l = "<option  selected >Select Source</option>";
        $.each(rs.data, function (key, val) {
            l += "<option value='" + val.parameter_count_id + "' data-name='" + val.parameter_name + "'>" + val.parameter_name + " </option>";
        });
        $('#cd-sel-source').html(l);
    }, 'json');
}
function getGlobalParameterTypeIdAndStatus() {
    $.post(sAjaxGlobalData, {
        type: "getGlobalParameter",
        parameter_type: "nextofkin",
    }, function (rs) {
        l = "<option value='0' selected >Select Relationship</option>";
        $.each(rs.data, function (key, val) {
            l += "<option value='" + val.parameter_count_id + "' data-name='" + val.parameter_name + "'>" + val.parameter_name + "</option>";
        });
        $('#cd-sel-relation').html(l);
        $('#sel-relation-to-victim').html(l);
    }, 'json');
}
function getDocumentTypesByDocumentCategoryID(id) {
    $.post(sAjaxGlobalData, {
        type: "getDocumentTypesByDocumentCategoryID",
        id: id,
    }, function (rs) {

        l = "<option selected > Select Document Type</option>";
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
        var l = "<option  selected >Select Nationality</option>";
        var nat_offender = "<option disabled selected >Select Nationality</option>";
        $.each(rs.data, function (key, val) {
            l += "<option value='" + val.country_id + "' data-name='" + val.nationality + "'>" + val.nationality + " (" + val.country_name + ")" + " </option>";
            nat_offender += "<option value='" + val.nationality + "'>" + val.nationality + " (" + val.country_name + ")" + " </option>";
        });
        $('.sel-nationality').html(l);
        $('#seloffendernationality').html(nat_offender);
    }, 'json');
}
function getAssessmentType() {
    $.post(sAjaxGlobalData, {
        type: "getAssessmentType",
    }, function (rs) {
        l = "<option  selected >Select Assessment</option>";
        $.each(rs.data, function (key, val) {
            l += "<option value='" + val.transaction_parameter_count_id + "'>" + val.transaction_parameter_name + " </option>";
        });
        $('#cd-mdl-sel-assmnt-type').html(l);
    }, 'json');
}
function getCaseTIP() {
    var caseid = $('#case_id').val();
    $.post(sAjaxCaseDetails, {
        type: "getCaseTIP",
        caseid: caseid,
    }, function (rs) {

        $("#cd-sel-acts option:selected").prop("selected", false);
        $("#cd-sel-means option:selected").prop("selected", false);
        $("#cd-sel-purposes option:selected").prop("selected", false);

        rs = html_entity_decode(rs);
        activateAMP('1');
        $('#cd-sel-acts').chosen("destroy");
        $('#cd-sel-means').chosen("destroy");
        $('#cd-sel-purposes').chosen("destroy");
        $.each(rs.data.acts, function (key, val) {
            $("#cd-sel-acts option[value=" + val.case_victim_tip_type_content_id + "]").prop("selected", true);
        });
        $.each(rs.data.means, function (key, val) {
            $("#cd-sel-means option[value=" + val.case_victim_tip_type_content_id + "]").prop("selected", true);
        });
        $.each(rs.data.purpose, function (key, val) {
            $("#cd-sel-purposes option[value=" + val.case_victim_tip_type_content_id + "]").prop("selected", true);
        });
        $('#btn-facts').attr('case-victim-id', rs.data.case_victim_id);
        $('#area-brief-facts').val(rs.data.case_victim_facts);
        $('#cd-sel-acts').chosen();
        $('#cd-sel-means').chosen();
        $('#cd-sel-purposes').chosen();
        $('#cd_sel_acts_chosen').css("width", "100%");
        $('#cd_sel_means_chosen').css("width", "100%");
        $('#cd_sel_purposes_chosen').css("width", "100%");
        if (rs.data.case_is_illegal_rec == "1") {
            $('.case-is_illegal_rec').prop("checked", true);
        }
        if (rs.data.case_is_other_law == "1") {
            $('.case-is_other_law').prop("checked", true);
            $('.div-other_law_desc').show();
        }

        // for 
        $('.case-other_law_desc').val(rs.data.case_is_other_law_desc);
        getLabelForTIPContent();
        activateAMP('0');
        aInitialValues["incident_details"] = "";
        aInitialValues["incident_details"] = getFormValues('frm-act-means-purpose');
    }, 'json');
}
function getLabelForTIPContent() {
// acts 
    var l = '';
    var aValues = $("#cd-sel-acts :selected").map(function () {
        return $(this).text();
    }).get();
    if (aValues.length >= 1) {
        $.each(aValues, function (key, val) {
            l += '<li>' + val + '</li>';
        });
    }
    $('#ul-cd-sel-acts-label').html(l);
    // means 
    var l = '';
    var aValues = $("#cd-sel-means :selected").map(function () {
        return $(this).text();
    }).get();
    if (aValues.length >= 1) {
        $.each(aValues, function (key, val) {
            l += '<li>' + val + '</li>';
        });
    }
    $('#ul-cd-sel-means-label').html(l);
    // purposes 
    var l = '';
    var aValues = $("#cd-sel-purposes :selected").map(function () {
        return $(this).text();
    }).get();
    if (aValues.length >= 1) {
        $.each(aValues, function (key, val) {
            l += '<li>' + val + '</li>';
        });
    }
    $('#ul-cd-sel-purposes-label').html(l);
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
        getCaseTIP();
    }, 'json');
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
function getVictimCaseInfo() {

    var storages = ['victim_complainant_details',
        'victim_case_details',
        'victim_case_evaluation_details'];
    $.each(storages, function (key, val) {
        var data = _getStorageData(val);
        $.each(data, function (key, val) {
            $(".case-" + key).val(val);
        });
    });
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
function getCaseOffenderList() {


    var offenders = _getStorageData('victim_case_offender');
    var cnt = 0;
    var t = '';
    if (offenders.length > 0) {
        $.each(offenders, function (key, val) {

            t += '<tr>';
            t += '<td>' + val.offender_name + '</td>';
            t += '<td>' + val.offender_type_name + '</td>';
            t += '<td> <div class="btn-group ellipse-action" data-id="vi-offender_info_list' + cnt + '" data-tab="">';
            t += '<a class="a-ellipse a-ellipse-offender_info_list' + cnt + ' " >  <i class="fa fa-ellipsis-v" aria-hidden="true"></i> </a>';
            t += '<div class="action-menu" id="vi-offender_info_list' + cnt + '">';
            t += '<a class="dropdown-item disabled action-title" href="#">Select Action</a>';
            t += '<a class="dropdown-item up-victim_case_offender" data-id="' + cnt + '" >Update</a>';
            t += '<a class="dropdown-item rm-victim_case_offender" data-id="' + cnt + '" >Remove</a>';
            t += '</div>';
            t += '</div> </td>';
            t += '</tr>';
            cnt++;
            parseInt(offenders.length) >= 10 ? $('#btn-add-offender').prop('disabled', true) : $('#btn-add-offender').prop('disabled', false);
        });
    } else {
        t += '<tr>';
        t += '<td colspan="3" class="text-center">No offender added to list.</td>';
        t += '</tr>';
    }

    $('.victim-offender_info_list').html(t);
}

$(document).ready(function () {

//    getGlobalComplainSource(); // X 
//    getGlobalParameterTypeIdAndStatus(); // X 
//    getActPurposeMeans(); // X 
//    getNationality(); // X 
//    getOffenderPosition(); // X 
//    getAssessmentType(); // X 

//    getCaseOffenderList();  // X 
//    getCaseEvaluation();  // X 
//    getCaseAllegedOffender();  // X 
//    getUploadedDocuments();  // X 

    activateComplain('todisabled');
    activateAMP(0);
    $('#form-add_update_offender').validate({
        rules: {
            offender_type: {
                required: true
            },
            offender_name: {
                required: true
            }
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
            var action = $('#btn-save-offender').attr('action');
            if (action == "add") {
                msg = "You are about to add new alleged offender details";
            } else {
                msg = "You are about to update  alleged offender details";
            }

            icmsMessage({
                type: "msgConfirmation",
                title: msg,
                onConfirm: function () {
                    addSetOffenderInfo();
                },
                onShow: function () {
                    $('#modalcontent-add_offender').modal('hide');
                },
                onCancel: function () {
                    $('#modalcontent-add_offender').modal('show');
                }
            });
        }
    });
    $('#frm-complainant').validate({
        rules: {
            //datecomplained: {required: true, pastDateOptional: true},
            complainantsource: {required: true},
            //complainantname: {required: true},
            //selrelationtovictim: {required: true},
            //complainantaddress: {required: true},
            //complainantcontact: {required: true, number: true},
            //complainantremarks: {required: true}
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


            aCurrentValues = '';
            aCurrentValues = getFormValues('frm-complainant');
            if (aCurrentValues == aInitialValues['complainant']) {
                icmsMessage({
                    type: "msgWarning",
                    body: "No changes has been made.",
                });
            } else {
                icmsMessage({
                    type: "msgConfirmation",
                    title: "You are about to update the complainant information",
                    onConfirm: function () {
                        activateComplain("todisabled");
                        setComplainantDetails();
                    }
                });
            }
        }
    });
    $('#frm-act-means-purpose').validate({
        rules: {
            AreaAMPRemarks: {required: true},
            selectPurpose: {required: true},
            selectMeans: {required: true},
            selectActs: {required: true}
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

            var aCurrentValues = "";
            aCurrentValues = getFormValues('frm-act-means-purpose');
            if (aCurrentValues == aInitialValues['incident_details']) {
                icmsMessage({
                    type: "msgWarning",
                    body: "No changes has been made.",
                });
            } else {
                icmsMessage({
                    type: "msgConfirmation",
                    title: "You are about to update Means, Act and Purpose",
                    onConfirm: function () {
                        setActMeansPurpose();
                        activateAMP(0);
                    }
                });
            }

        }
    });
    $('#tbl-offender-list').delegate('.ellipse-action', 'click', function (e) {
        var id = $(this).attr('data-id');
        if ($('#id-' + id).is(":visible")) {
            $('#id-' + id).hide();
            $('.a-ellipse').removeClass('ellipse-selected');
        } else {
            $('.action-menu-offender').hide();
            $('.a-ellipse').removeClass('ellipse-selected');
            $('#id-' + id).show();
            $('.a-ellipse-' + id).addClass('ellipse-selected');
        }
    });
    $('#tbody-document-list').delegate('.ellipse-action', 'click', function (e) {
        console.log('here');
        var id = $(this).attr('data-id');
        if ($('#id-doc' + id).is(":visible")) {
            $('#id-doc' + id).hide();
            $('.a-ellipse').removeClass('ellipse-selected');
        } else {
            $('.action-menu-docs').hide();
            $('.a-ellipse').removeClass('ellipse-selected');
            $('#id-doc' + id).show();
            $('.a-ellipse-' + id).addClass('ellipse-selected');
        }
    });
    $('#btn-save-offender').click(function () {
        $('#form-add_update_offender').submit();
    });
    $('#tbl-offender-list').delegate('.a-remove-offender', 'click', function () {
        var offenderid = $(this).attr('data-id');
        icmsMessage({
            type: "msgConfirmation",
            title: "You are about to remove alleged offender details",
            body: "Click remove button if you wish to continue.",
            LblBtnConfirm: "Remove",
            onConfirm: function () {
                removeOffenderDetails(offenderid);
            }
        });
    });

    // remove document 
    $('#tbody-document-list').delegate('.a-remove-docs', 'click', function () {
        var docid = $(this).attr('data-id');
        icmsMessage({
            type: "msgConfirmation",
            title: "You are about to remove document",
            body: "Click remove button if you wish to continue.",
            LblBtnConfirm: "Remove",
            onConfirm: function () {
                removeDocument(docid);
            }
        });
    });

    // update document 
    $('#tbody-document-list').delegate('.a-update-docs', 'click', function () {
        var link = $(this).attr('data-hash'),
                remarks = $(this).attr('data-remarks'),
                docid = $(this).attr('data-id');
        $('#ucd-txt-doc-remarks').val(remarks);
        $('#ucd-txt-doc-remarks').attr('data-id', docid);
        $('#form-update_document_info img.img-uploaded').attr('src', link);
        $('#form-update_document_info a.img-uploaded').attr('href', link);
        $('#modalcontent-update_document').modal('show');
    });


    // update offender 
    $('#tbl-offender-list').delegate('.a-update-offender', 'click', function () {

// disable type 
        $('.a-case-offender_type').prop('disabled', true);
        var employer = $('.emp-employer-employer_name').val();
        var local_rec = $('.emp-local-recruitment_agency_name').val();
        var foreign_rec = $('.emp-foreign-recruitment_agency_name').val();
        employer == "" ? $(".a-case-offender_type option[value='1']").attr("disabled", true) : $(".a-case-offender_type option[value='1']").attr("disabled", false);
        local_rec == "" ? $(".a-case-offender_type option[value='2']").attr("disabled", true) : $(".a-case-offender_type option[value='2']").attr("disabled", false);
        foreign_rec == "" ? $(".a-case-offender_type option[value='3']").attr("disabled", true) : $(".a-case-offender_type option[value='3']").attr("disabled", false);
        $('#modalcontent-add_offender').modal('show');
        $('#btn-save-offender').attr('action', "update");
        var offenderid = $(this).attr('data-id');
        $('#btn-save-offender').attr('offenderid', offenderid);
        $.post(sAjaxCaseDetails, {
            type: "getCaseAllegedOffenderByOffenderID",
            id: offenderid,
        }, function (rset) {
            //success
            var rs = rset.data.offender;
            $('.a-case-offender_name').val(rs.case_offender_name);
            $('.a-case-offender_type').val(rs.case_offender_type_id).change();
            $('.a-case-offender_nationality').val(rs.case_offender_nationality).change();
            $('.a-case-offender_contact').val(rs.case_offender_contact_details);
            $('.a-case-offender_address').val(rs.case_offender_address);
            $('.a-case-offender_remarks').val(rs.case_offender_remarks);
        }, 'json');
    });
    $('#btn-add-offender').click(function () {

// enable type 
        $('.a-case-offender_type').prop('disabled', false);
        $('#modalcontent-add_offender').modal('show');
        $('#btn-save-offender').attr('action', "add");
        $('#btn-save-offender').attr('offenderid', "0");
    });
    $('#sel-relation-to-victim').change(function () {
        var slctd = $("#sel-relation-to-victim option:selected").text();
        $('#complainant_relation_other').val("");
        if (slctd.toLowerCase() == "other") {
            $('.div-relation-other').removeClass("hide");
        } else {
            $('.div-relation-other').addClass("hide");
        }
    });
    $('#btn-complain').click(function () {
        var action = $(this).attr("dataaction");
        if (action == "toenabled") {
            activateComplain("toenabled");
            //road to save
        } else {
            $('#frm-complainant').submit();
        }
    });
    $('#btn-facts').click(function () {
        var action = $(this).attr("dataaction");
        if (action == "1") {
            $('#frm-act-means-purpose').submit();
            //road to save
        } else {
            activateAMP(1);
        }
    });
    $('#btn-complain-cancel').click(function () {

        aCurrentValues = '';
        aCurrentValues = getFormValues('frm-complainant');
        if (aCurrentValues == aInitialValues['complainant']) {
            // no update 
            $('#btn-complain-cancel').addClass("hide");
            $('#btn-complain').text("Manage");
            $('#btn-complain').attr("dataaction", 1);
            activateComplain("disabled");
        } else {
            // have an update
            icmsMessage({
                type: "msgConfirmation",
                title: "You made some changes. Do you want to disregard changes?",
                body: "Click yes button if you want to continue",
                LblBtnConfirm: "Yes",
                onConfirm: function () {
                    $('#btn-complain-cancel').addClass("hide");
                    $('#btn-complain').text("Manage");
                    $('#btn-complain').attr("dataaction", 1);
                    activateComplain("disabled");
                    resetFormJQueryValidation('frm-complainant');
                    getComplainantDetails();
                }
            });
        }


    });
    $('#btn-fact-cancel').click(function () {

        aCurrentValues = '';
        aCurrentValues = getFormValues('frm-act-means-purpose');
        if (aInitialValues["incident_details"] == aCurrentValues) {
// no update
            $('#btn-fact-cancel').addClass("hide");
            $('#btn-facts').text("Update");
            $('#btn-facts').attr("dataaction", 1);
            activateAMP(0);
        } else {
// have an update 
            icmsMessage({
                type: "msgConfirmation",
                title: "You made some changes. Do you want to disregard changes?",
                body: "Click yes button if you want to continue",
                LblBtnConfirm: "Yes",
                onConfirm: function () {
                    $('#btn-fact-cancel').addClass("hide");
                    $('#btn-facts').text("Update");
                    $('#btn-facts').attr("dataaction", 1);
                    activateAMP(0);
                    resetFormJQueryValidation('frm-complainant');
                    getCaseTIP();
                }
            });
        }

    });
    $('#btn-cancel-evaluation').click(function () {
        $(this).addClass("hide");
        $('#btn-update-evalution').text("Manage");
        $('#btn-update-evaluation').attr("dataaction", 'toenabled');
        $('#area-evaluation').prop('disabled', true);
    });
    $('#btn-manage-evaluation').click(function () {
        var caption = $('#btn-manage-evaluation').text();
        if (caption == "Manage") {

// for manage 
            $('#area-evaluation').prop('disabled', false);
            $('#area-case-risk-assessment').prop('disabled', false);
            $('#area-case-details_of_coordination').prop('disabled', false);
            $('#btn-save-evaluation').removeClass('hide');
            $('#btn-manage-evaluation').text("Cancel");
        } else {

// for cancel 

            aCurrentValues = '';
            aCurrentValues = getFormValues('fmr-manage-evaluation');
            if (aCurrentValues == aInitialValues['case_evaluation']) {
// no update 
                $('#area-evaluation').prop('disabled', true);
                $('#area-case-risk-assessment').prop('disabled', true);
            //OSAEC CODE START           
                $('#area-case-details_of_coordination').prop('disabled', true);
            //OSAEC CODE END    
                $('#btn-save-evaluation').addClass('hide');
                //save
                $('#btn-manage-evaluation').text("Manage");
            } else {
// have an update
                icmsMessage({
                    type: "msgConfirmation",
                    title: "You made some changes. Do you want to disregard changes?",
                    body: "Click yes button if you want to continue",
                    LblBtnConfirm: "Yes",
                    onConfirm: function () {

                        // no update 
                        $('#area-evaluation').prop('disabled', true);
                        $('#area-case-risk-assessment').prop('disabled', true);
                    //OSAEC CODE START
                        $('#area-case-details_of_coordination').prop('disabled', true);
                     //OSAEC CODE END
                        $('#btn-save-evaluation').addClass('hide');
                        //save
                        $('#btn-manage-evaluation').text("Manage");
                        resetFormJQueryValidation('fmr-manage-evaluation');
                        getCaseEvaluation();
                    }
                });
            }

        }
    });
    $('#btn-save-evaluation').click(function () {
        $('#fmr-manage-evaluation').submit();
    });
    // update form case evaluataion risk assessment 
    $('#fmr-manage-evaluation').validate({
        rules: {

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
            aCurrentValues = getFormValues('fmr-manage-evaluation');
            if (aCurrentValues == aInitialValues['case_evaluation']) {
                icmsMessage({
                    type: "msgWarning",
                    body: "No changes has been made.",
                });
            } else {
                icmsMessage({
                    type: "msgConfirmation",
                    title: "You are about to update Case Evaluation & Risk Assessment",
                    onConfirm: function () {

                        // no update 
                        $('#area-evaluation').prop('disabled', true);
                        $('#area-case-risk-assessment').prop('disabled', true);
                        $('#btn-save-evaluation').addClass('hide');
                        //save
                        $('#btn-manage-evaluation').text("Manage");
                        setCaseEvaluation();
                    }
                });
            }


        }
    });

//OSAEC CODE START
    $('#btn-cancel-local_employer').click(function () {
        $(this).addClass("hide");
        $('#btn-update-local_employer').text("Manage");
        $('#btn-update-local_employer').attr("dataaction", 'toenabled');
        $('#area-local_employer').prop('disabled', true);
    });
    $('#btn-manage-local_employer').click(function () {
        var caption = $('#btn-manage-local_employer').text();
        if (caption == "Manage") {

// for manage 
            $('#emp-act_employed_unemployed').prop('disabled', false);
            $('#emp-act_type_of_employment').prop('disabled', false);
            $('#emp-act_type_of_child_cases').prop('disabled', false);
            $('#emp-region').prop('disabled', false);
            $('#emp-age_started_working').prop('disabled', false);
            $('#emp-salary_per_hour').prop('disabled', false);
            $('#emp-reasons_for_employment').prop('disabled', false);
            $('#btn-save-local_employer').removeClass('hide');
            $('#btn-manage-local_employer').text("Cancel");
        } else {

// for cancel 

            aCurrentValues = '';
            aCurrentValues = getFormValues('fmr-manage-evaluation');
            if (aCurrentValues == aInitialValues['case_evaluation']) {
// no update 
                $('#emp-act_employed_unemployed').prop('disabled', true);
                $('#emp-act_type_of_employment').prop('disabled', true);
                $('#emp-act_type_of_child_cases').prop('disabled', true);
                $('#emp-region').prop('disabled', true);
                $('#emp-age_started_working').prop('disabled', true);
                $('#emp-salary_per_hour').prop('disabled', true);
                $('#emp-reasons_for_employment').prop('disabled', true);
                $('#btn-save-local_employer').addClass('hide');
                //save
                $('#btn-manage-local_employer').text("Manage");
            } else {
// have an update
                icmsMessage({
                    type: "msgConfirmation",
                    title: "You made some changes. Do you want to disregard changes?",
                    body: "Click yes button if you want to continue",
                    LblBtnConfirm: "Yes",
                    onConfirm: function () {

                        // no update 
                        $('#emp-act_employed_unemployed').prop('disabled', true);
                        $('#emp-act_type_of_employment').prop('disabled', true);
                        $('#emp-act_type_of_child_cases').prop('disabled', true);
                        $('#emp-region').prop('disabled', true);
                        $('#emp-age_started_working').prop('disabled', true);
                        $('#emp-salary_per_hour').prop('disabled', true);
                        $('#emp-reasons_for_employment').prop('disabled', true);
                        $('#btn-save-local_employer').addClass('hide');
                        //save
                        $('#btn-manage-local_employer').text("Manage");
                        resetFormJQueryValidation('fmr-manage-evaluation');
                        getCaseEvaluation();
                    }
                });
            }

        }
    });
    $('#btn-save-local_employer').click(function () {
        $('#fmr-manage-evaluation').submit();
    });
    // update form case evaluataion risk assessment 
    $('#fmr-manage-evaluation').validate({
        rules: {

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
            aCurrentValues = getFormValues('fmr-manage-evaluation');
            if (aCurrentValues == aInitialValues['case_evaluation']) {
                icmsMessage({
                    type: "msgWarning",
                    body: "No changes has been made.",
                });
            } else {
                icmsMessage({
                    type: "msgConfirmation",
                    title: "You are about to update Case Evaluation & Risk Assessment",
                    onConfirm: function () {

                        // no update 
                        $('#area-evaluation').prop('disabled', true);
                        $('#area-case-risk-assessment').prop('disabled', true);
                        $('#btn-save-evaluation').addClass('hide');
                        //save
                        $('#btn-manage-evaluation').text("Manage");
                        setCaseEvaluation();
                    }
                });
            }


        }
    });
//OSAEC CODE END
    $('#form-add_offender').validate({
        rules: {
            offender_type: {required: true},
            offender_name: {required: true},
            offender_contact: {minlength: 7}
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
        _rmStorageDataById(storage, storage[id]);
        _setStorageData(storage, 'victim_case_offender');
        getCaseOffenderList();
    });
    $('.victim-offender_info_list').delegate('.up-victim_case_offender', 'click', function () {
        var id = $(this).attr('data-id');
        $('.stored-offender_id').val(id);
        var x = _getStorageData('victim_case_offender');
        $.each(x[id], function (key, val) {
            $('.u-case-' + key).val(val);
        });
        $('#modal-update_case_offender').modal('show');
    });
    $("#form-update_case_info").validate({
        rules: {
            complainant_contact: {minlength: 7}
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
        }
    });
    $('#cd-mdl-sel-assmnt-type').change(function () {
        var id = $(this).val();
        getServicesByAssessmentID(id);
    });
    $('#cd-doc-file').change(function (event) {
        $(this).attr('data-action', '1');
        // 20997976 = 20mb
        checkFileFormat(event, 20997976, 'cd-doc-file', 'modalcontent-add_document');
    });

    $('.btn-add_offender').click(function () {
        $('#modal-add_case_offender').show();
    });
    $('.btn-add_document').click(function () {
        $('#form-add_document_info').attr('stored-id', "");
        $('#cd-doc-file').attr('data-hash', "0");
        $('#cd-doc-file').attr('data-action', "add");
        $('#modalcontent-add_document').modal('show');
        $('#cd-doc-file').css('color', '');
        resetFormById('form-add_document_info');
        $('#form-add_document_info .div-cfu').show();
        $('#form-add_document_info img.img-uploaded').hide();
    });
    $('#cd-sel-document-cat').change(function () {
        var id = $(this).val();
        getDocumentTypesByDocumentCategoryID(id);
    });
    $('.btn-save-document').click(function () {
        $('#form-add_document_info').valid();
    });

    // validate add document 
    $('#form-add_document_info').validate({
        rules: {
            cdSelDocumentCat: {required: true},
            cdSelDocumentType: {required: true},
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
            icmsMessage({
                type: "msgConfirmation",
                title: "You are about to add new attachment",
                onConfirm: function () {
                    //uploadDocuments();
                    var image_hash = $('#cd-doc-file').attr('data-hash');
                    addNewDocument(image_hash);
                },
                onShow: function () {
                    $('#modalcontent-add_document').modal('hide');
                },
                onCancel: function () {
                    $('#modalcontent-add_document').modal('show');
                }
            });
        }
    });

    // validate update document 
    $('#form-update_document_info').validate({
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
            icmsMessage({
                type: "msgConfirmation",
                title: "You are about to update this attachment ",
                onConfirm: function () {
                    //uploadDocuments();
                    var image_hash = $('#ucd-doc-file').attr('data-hash');
                    updateDocument(image_hash);
                },
                onShow: function () {
                    $('#modalcontent-update_document').modal('hide');
                },
                onCancel: function () {
                    $('#modalcontent-update_document').modal('show');
                }
            });
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
    $('#cd-sel-acts').chosen("destroy");
    $('#cd-sel-means').chosen("destroy");
    $('#cd-sel-purposes').chosen("destroy");
    // chosen js 
    $('#cd-sel-acts').chosen();
    $('#cd-sel-means').chosen();
    $('#cd-sel-purposes').chosen();
    $('#cd_sel_acts_chosen').css("width", "100%");
    $('#cd_sel_means_chosen').css("width", "100%");
    $('#cd_sel_purposes_chosen').css("width", "100%");
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
    $('#btn-add-offender').click(function () {
        var employer = $('.emp-employer-employer_name').val();
        var local_rec = $('.emp-local-recruitment_agency_name').val();
        var foreign_rec = $('.emp-foreign-recruitment_agency_name').val();
        employer == "" ? $(".a-case-offender_type option[value='1']").attr("disabled", true) : $(".a-case-offender_type option[value='1']").attr("disabled", false);
        local_rec == "" ? $(".a-case-offender_type option[value='2']").attr("disabled", true) : $(".a-case-offender_type option[value='2']").attr("disabled", false);
        foreign_rec == "" ? $(".a-case-offender_type option[value='3']").attr("disabled", true) : $(".a-case-offender_type option[value='3']").attr("disabled", false);
        resetFormById('form-add_update_offender');
    });
    $('.a-case-offender_type').change(function () {
        var offender_type = $(this).val();
        if (offender_type == "4") {
            $('.offender_field_other').show();
        } else {
            $('.offender_field_other').hide();
        }
//OSAEC CODE START
        $('.offender_field_other').show();
    });
//OSAEC CODE END    
    // set link to manage services 
//    $('.a-manage_services').attr('href', sAjaxUrl + '/view_victim_services/' + $('#case_id').val() + '/' + localStorage.getItem('vid'));
    $('.a-manage_services').attr('href', sAjaxUrl + '/view_victim_services/' + $('#case_id').val() + '/' + $('#victim_id').val());
    //div-priority_level

    $('.div-priority_level [name="recommendedLevel"]').click(function () {
        var x = $(this).val();
        $('.div-priority_level .form-check-input').removeAttr('checked');
        if (x != aInitialValues["case_priority_level_id"]) {
            icmsMessage({
                type: "msgConfirmation",
                title: "You are about to update priority level.",
                onConfirm: function () {
                    icmsMessage({
                        type: "msgPreloader",
                        body: "Saving... Please wait!",
                        visible: true
                    });
                    $.post(sAjaxCase, {
                        type: "setCasePriorityLevel",
                        case_id: $('#case_id').val(),
                        level_id: x,
                        old_level_id: aInitialValues['case_priority_level_id']
                    }, function (rs) {
                        disabledInputs();
                        notifyChangesInReport();
                        aInitialValues['case_priority_level_id'] = x;
                    }, 'json');
                },
                onCancel: function () {
                    $('.div-priority_level .form-check-input[value="' + x + '"]').prop('checked', false);
                    $('.div-priority_level .form-check-input[value="' + aInitialValues["case_priority_level_id"] + '"]').prop('checked', true);
                }
            });
        }
    });

    // trigger click as whole 
    $('#mng-picture_attachment').click(function () {
//        $('#cd-doc-file').click(); 
    });



    /*
     * Cropping Image
     */

    var $uploadCrop,
            tempFilename,
            rawImg,
            imageId;

    function readFile(input) {

        $('.cr-image').attr('src', '#');

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.upload-demo').addClass('ready');
                $('#cropImagePop').modal('show');
                rawImg = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            swal("Sorry - you're browser doesn't support the FileReader API");
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
            $('#mdl-manage_agency').modal('hide');
        });
    });


    $('#cropImagePop .btn-cancel').click(function () {
        var x = $('#cropImagePop').attr('data-prev_modal');
        $('#' + x).modal('show');
    });

    // add document  
    $('#cd-doc-file').on('change', function () {
        imageId = $(this).data('id');
        tempFilename = $(this).val();
        $('#cropImagePop').attr('data-prev_modal', 'modalcontent-add_document');
        $('#modalcontent-add_document').modal('hide');
        readFile(this);
    });

    // update document 
    $('#ucd-doc-file').on('change', function () {
        imageId = $(this).data('id');
        tempFilename = $(this).val();
        $('#cropImagePop').attr('data-prev_modal', 'modalcontent-update_document');
        $('#modalcontent-update_document').modal('hide');
        readFile(this);
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
                            $('#ucd-doc-file').attr('data-hash', image_hash);

                            // src 
                            $('#form-add_document_info img.img-uploaded').attr('src', sDriveViewer + image_hash);
                            $('#form-update_document_info img.img-uploaded').attr('src', sDriveViewer + image_hash);

                            //href 
                            $('#form-add_document_info a.img-uploaded').attr('href', sDriveViewer + image_hash);
                            $('#form-update_document_info a.img-uploaded').attr('href', sDriveViewer + image_hash);

                            // hide choose file to upload 
                            $('.div-cfu').hide();
                            $('#form-add_document_info img.img-uploaded').show();


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
                },
                onCancel: function () {
                    $('#cropImagePop').modal('show');
                }
            });
        });
    });

    $('#cropImagePop .btn-cancel').click(function () {
        setTimeout(function () {
            $('#mdl-manage_agency').modal('show');
        }, 500);
    });

});
