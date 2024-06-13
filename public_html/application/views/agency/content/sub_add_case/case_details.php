<?php
/**
 * Page Security
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<form id="form-update_case_info" onSubmit="return false;" >
    <div class="form-content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class=" card-sub-title txt-W-500"> Incident Details<br> 
                    <small class="card-desc"> Indicate information of the report. </small> 
                    <hr class="card-sub-title_border">
                </div>
            </div>
        </div>
        <div class="form-row row">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="bg-form-grey py-2">
                    <div class="row px-3">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class=" card-sub-title txt-W-500 " style="color: #e88f15;"> Complainant's Information
                            </div>
                        </div>
                    </div>
                    <div class=" px-3">
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Date Complained </label>
                                <input type="text" class="form-control case-date_complained datepicker" name="case_date_complained" placeholder="MM/DD/YYYY" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Source of case/report <font color="red"> <b>*</b> </font>  </label>
                                <select id="cd-sel-source" class="form-control case-complainant_source" name="case_complainant_source">
                                </select>
                            </div>
                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <label>Relationship to victim </label>
                                <select class="form-control sel-relation case-complainant_relation">
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Complainant's Name </label>
                                <input type="text" maxlength="100" id="cd-txt-name" class="form-control case-complainant_name" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Contact Number</label>
                                <input type="text" maxlength="20" minlength="7" class="form-control case-complainant_contact numbersOnly" name="complainant_contact"> 
                            </div>
                        </div>
                        <div class="row div-case-complainant_relation_other" style="display: none;">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Other:</label>
                                <input type="text" maxlength="50" class="form-control case-complainant_relation_other"> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Address</label>
                                <textarea class="form-control valid noSpcStart case-complainant_address" rows="4" maxlength="100" aria-invalid="false"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Place of Incident</label>
                                <textarea class="form-control valid noSpcStart case-complainant_place_of_incident" rows="4" maxlength="100" aria-invalid="false"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Place of Origin</label>
                                <textarea class="form-control valid noSpcStart case-complainant_place_of_origin" rows="4" maxlength="100" aria-invalid="false"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Place of Destination</label>
                                <input type="text" maxlength="20" minlength="7" class="form-control case_place_of_destination"> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Date/Time of Incident</label>
                                <input type="text" class="form-control case-date_time_of_incident datetimepicker" name="date_time_of_incident" placeholder="MM/DD/YYYY" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Other possible sources of information</label>
                                <textarea class="form-control valid noSpcStart case-other_possible_source_info" rows="4" maxlength="100" aria-invalid="false"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-12 ">
                <div class="form-padding-left py-2">
                    <div class="row px-3">
                        <div class=" card-sub-title txt-W-500 " style="color: #e88f15;"> Type of Complaint
                            <br>
                            <small class="card-desc"> Traffic in Persons Elements. </small>
                        </div>
                    </div>
                    <div class=" px-3">
                        <div class="row">
                            <div class="form-group col-lg-10 col-md-12 col-sm-12">
                                <label> Acts</label>
                                <select id="cd-sel-acts" name="s_acts" class="select sel-filter chosen-select" data-acts="0" data-placeholder="" tabindex="-1" multiple="multiple" required="true">
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-10 col-md-12 col-sm-12">
                                <label> Means</label>
                                <select id="cd-sel-means" name="s_means" class="select sel-filter chosen-select" data-placeholder="" tabindex="-1" multiple="multiple" required="true">
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-10 col-md-12 col-sm-12">
                                <label> Purpose</label>
                                <select id="cd-sel-purposes" name="s_purpose" class="select sel-filter chosen-select" data-placeholder="" tabindex="-1" multiple="multiple" required="true">
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input case-is_illegal_rec noSpcStart" id="ch1">
                                    <label class="form-check-label " for="ch1" style="color: #e88f15 !important;">Illegal Recruitment
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input case-is_other_law noSpcStart" id="ch2">
                                    <label class="form-check-label " for="ch2" style="color: #e88f15 !important;">Other law/s violated
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row div-other_law_desc" style="display: none;">
                            <div class="form-group col-lg-10 col-md-12 col-sm-12">
                                <label> Other Law Description </label>
                                <textarea class="form-control case-other_law_desc noSpcStart" maxlength="2000" style="height: unset !important;" rows="5" cols="150" placeholder="Other Law Description..."></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-10 col-md-12 col-sm-12">
                                <label> Brief facts of the case </label>
                                <textarea class="form-control case-facts noSpcStart" maxlength="2000" style="height: unset !important;"  rows="5" cols="150" placeholder="Summarize report or remarks of the case..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row pt-5 mt-5">
        <div class="col-lg-12">
            <div class="employment-info-sub_forms">
                <div class="card-sub-title txt-W-500">Other report details<br>
                    <small class="card-desc"> Add other report details </small> 
                    <hr class="card-sub-title_border">
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-5 col-sm-12">
                        <div class="list-group sub-form-list" id="list-tab" role="tablist">
                            <a class="list-group-item list-group-item-action active" id="list-contact_info" data-toggle="list" href="#tab-case_evaluation" role="tab" aria-controls="deployment_details">Evaluation <span class="float-right hide"> <i class="fa fa-caret-right" aria-hidden="true"></i></span></a>
                            <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#tab-services" role="tab" aria-controls="passport_info">Victim's needs / Type of Services <span class="float-right hide"> <i class="fa fa-caret-right" aria-hidden="true"></i></span></a>
                            <a class="list-group-item list-group-item-action" id="list-offender-list" data-toggle="list" href="#tab-offender" role="tab" aria-controls="offender_info">Alleged Offender's Details <span class="float-right hide"> <i class="fa fa-caret-right" aria-hidden="true"></i></span></a>
                            <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#tab-document_attachment" role="tab" aria-controls="flight_details">Pictures attachments <span class="float-right hide"> <i class="fa fa-caret-right" aria-hidden="true"></i></span></a>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-7 col-sm-12 ">
                        <div class="tab-content tab-sub-info-content pl-5" id="nav-tabContent" >
                            <div class="tab-pane fade show active" id="tab-case_evaluation" role="tabpanel" aria-labelledby="list-home-list">
                                <div class=" card-sub-title" > Case evaluation and risk assessment <br> 
                                    <small class="card-desc"> Summary of evaluation and assessment based on case details.  </small> 
                                    <hr class="card-sub-title_border">
                                </div>
                                <div class="row form-row">

                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <div class=" card card_tbl-container ">
                                            <div class="row">
                                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                    <label>Case evaluation</label>
                                                    <textarea class="form-control case-evaluation noSpcStart" maxlength="5000" style="height: 150px !important;"  placeholder="Case evaluation..." ></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <div class=" card card_tbl-container ">
                                            <div class="row">
                                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                    <label>Risk assessment</label>
                                                    <textarea class="form-control case-risk_assessment noSpcStart" maxlength="5000" style="height: 150px !important;"  placeholder="Risk assessment..."></textarea>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade " id="tab-offender" role="tabpanel" aria-labelledby="list-offender-list">
                                <div class=" card-sub-title txt-W-500"> Alleged offender's information <span class="txt-orange"> (Maximum of 10 entries) </span> <br> 
                                    <small class="card-desc"> You can add multiple alleged offenders. </small> 
                                    <hr class="card-sub-title_border">
                                </div>
                                <div class="row form-row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 "> 
                                        <div class="card card_tbl-container">
                                            <div class="card_tbl-action">
                                                <div class="tbl_info card-sub-title">
                                                    <span class="" >Alleged offender's information list</span>
                                                </div>

                                                <button type="button" class="btn btn-secondary-light_blue btn-add_offender float-right tbl_info" data-target="#modal-add_case_offender" data-toggle="modal"><i class="fa fa-plus"></i>  Add Alleged Offender</button>
                                                <br>
                                                <div class="row">
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                        <div class="row">
                                                            <table class="table">
                                                                <thead class="thead-grey row-header-border">
                                                                    <tr>
                                                                        <th scope="col">Alleged offender's name</th>
                                                                        <th scope="col">Type of offender</th>
                                                                        <th scope="col">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="victim-offender_info_list">
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-services" role="tabpanel" aria-labelledby="list-profile-list">
                                <br><div class=" card-sub-title" >Services list <span class="txt-orange"> (Maximum of 10 entries) </span><br> 
                                    <small class="card-desc">Services for victim.</small>  
                                    <hr class="card-sub-title_border">
                                </div>
                                <div class="row form-row">

                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="card card_tbl-container">
                                            <div class="card_tbl-action">
                                                <div class="tbl_info card-sub-title">
                                                    <span class="" >Needs / Service list</span>
                                                </div>

                                                <div class='float-right'>
                                                    <button type="button" class="btn btn-secondary-light_blue btn-add_assessment"><i class="fa fa-plus"></i> Add Service</button>
                                                </div>
                                            </div>
                                            <table class="table">
                                                <thead class="thead-grey row-header-border">
                                                    <tr>
                                                        <th scope="col">Service</th>
                                                        <th scope="col">Tagged agency</th>
                                                        <th scope="col">Number of Days</th>
                                                        <th scope="col">Remarks</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbl-services-list">
                                                    <tr>
                                                        <td scope="row">Repatriation</td>
                                                        <td>Ople Center</td>
                                                        <td>4 Days</td>
                                                        <td> This is a sample assessement.</td>
                                                        <td>
                                                            <div class="btn-group ellipse-action">
                                                                <a class="a-ellipse a-ellipse-" >  <i class="fa fa-ellipsis-v" aria-hidden="true"></i> </a>
                                                                <div class="action-menu">
                                                                    <a class="dropdown-item disabled action-title" href="#">Select Action</a>
                                                                    <a class="dropdown-item" href="#">View Account Details</a>
                                                                    <a class="dropdown-item" href="#">Manage Account</a>
                                                                    <a class="dropdown-item" href="#">Reset Password</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td scope="row">Medical</td>
                                                        <td>OWWA</td>
                                                        <td>12 Days</td>
                                                        <td> This is a sample assessment.</td>
                                                        <td>
                                                            <div class="btn-group ellipse-action">
                                                                <a class="a-ellipse a-ellipse-" >  <i class="fa fa-ellipsis-v" aria-hidden="true"></i> </a>
                                                                <div class="action-menu">
                                                                    <a class="dropdown-item disabled action-title" href="#">Select Action</a>
                                                                    <a class="dropdown-item" href="#">View Account Details</a>
                                                                    <a class="dropdown-item" href="#">Manage Account</a>
                                                                    <a class="dropdown-item" href="#">Reset Password</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td scope="row">Legal</td>
                                                        <td>PNP</td>
                                                        <td>22 Days</td>
                                                        <td> This is a sample assessment.</td>
                                                        <td>
                                                            <div class="btn-group ellipse-action">
                                                                <a class="a-ellipse a-ellipse-" >  <i class="fa fa-ellipsis-v" aria-hidden="true"></i> </a>
                                                                <div class="action-menu">
                                                                    <a class="dropdown-item disabled action-title" href="#">Select Action</a>
                                                                    <a class="dropdown-item" href="#">View Account Details</a>
                                                                    <a class="dropdown-item" href="#">Manage Account</a>
                                                                    <a class="dropdown-item" href="#">Reset Password</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-document_attachment" role="tabpanel" aria-labelledby="list-messages-list">
                                <br> <div class=" card-sub-title" > Picture attachment <span class="txt-orange"> (1 attachment)</span> <br> 
                                    <small class="card-desc"> Only upload victims' picture for identification.  </small> 
                                    <hr class="card-sub-title_border">
                                </div>
                                <div class="row form-row">

                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="card card_tbl-container">
                                            <div class="card_tbl-action">
                                                <div class="tbl_info card-sub-title">
                                                    <span class="" >Attachment list</span>
                                                </div>
                                                <div class='float-right'>
                                                    <button type="button" class="btn btn-secondary-light_blue btn-add_document"><i class="fa fa-plus"></i> Add attachment</button>
                                                </div>
                                            </div>
                                            <table class="table">
                                                <thead class="thead-grey row-header-border">
                                                    <tr>
                                                        <!--<th scope="col">Document category</th>-->
                                                        <!--<th scope="col">Document type</th>-->
                                                        <!--<th width="40%" scope="col">File Name</th>-->
                                                        <th width="80%" scope="col">Remarks</th>
                                                        <th width="20%" scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody-document-list">


                                                    <tr>
                                                        <td scope="row">COE</td>
                                                        <td>Certificate of Employment</td>
                                                        <td>POLO</td>
                                                        <td>March 13, 2019</td>
                                                        <td>
                                                            <div class="btn-group ellipse-action">
                                                                <a class="a-ellipse a-ellipse-" >  <i class="fa fa-ellipsis-v" aria-hidden="true"></i> </a>
                                                                <div class="action-menu">
                                                                    <a class="dropdown-item disabled action-title" href="#">Select Action</a>
                                                                    <a class="dropdown-item" href="#">View account details</a>
                                                                    <a class="dropdown-item" href="#">Manage account</a>
                                                                    <a class="dropdown-item" href="#">Reset password</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <hr>
    <div class="content-footer float-right  match-buttons">

        <button type="button" class="btn btn-previous_tab return-top" data-tab="employment">Previous</button>
        <button type="submit" class="btn btn-primary-orange btn-next" data-tab="case-details-tab1" style="margin-left:0px;">Next</button>

    </div>

</form>



<div class="modal fade" id="modal-Initial-asssessment"  role="dialog" data-backdrop="static"> 
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title  msgmodal-header modal-header_title "> Add Services Information</h5>
            </div>
            <div class="modal-body msgmodal-body">
                <form id="form-add_assessment_info" class="col-lg-12 col-md-12 col-sm-12"  data-assessmecol-12nt ="0" data-service ="0"  data-agencies ="0" onSubmit="return false;">
                    <div class="col-lg-12 col-md-12 col-sm-12">

                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Assessment Type <font color="red">*</font></label>
                                <select id="cd-mdl-sel-assmnt-type" name="assessment_type" class="form-control">
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Services <font color="red">*</font></label>
                                <select id="cd-mdl-sel-service" name="sel_service" class="form-control">
                                    <option selected disabled="true">Choose </option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Agencies <font color="red">*</font></label>
                                <br>
                                <select id="cd-mdl-sel-agncy" name="sel_agency" tabindex="-1" style="width: 100%; border-radius: 5px; height: 32px;" required="true">
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Expected delivery of service </label>
                                <input type="text" id="cd-mdl-txt-set-age_label" class="form-control" disabled="true">
                                <input type="hidden" id="cd-mdl-txt-set-age" class="form-control datepicker" placeholder="MM/DD/YYYY">
                            </div>
                        </div>
                        <div class="row row-cd-departure" style="display: none;">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Departure Date </label>
                                <input type="text" id="cd-mdl-txt-departure-date" class="form-control datetimepicker" placeholder="MM/DD/YYYY">
                            </div>
                        </div>
                        <div class="row row-cd-arrival" style="display: none;">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Arrival Date </label>
                                <input type="text" id="cd-mdl-txt-arrival-date"  class="form-control datetimepicker" placeholder="MM/DD/YYYY">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Remarks </label>
                                <textarea type="text" id="cd-mdl-txt-remarks"  maxlength="1000" class="form-control noSpcStart" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="content-footer float-right  match-buttons">
                        <button type="button" class="btn btn-cancel btn-modal-cancel" data-dismiss="modal" >Cancel</button>
                        <button type="submit" class="btn btn-primary-orange btn-next btn-save-assessment" style="margin-left:0px;" >Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!--<div class="modal fade" id="modalcontent-add_document"  role="dialog" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title " id="">Add attachment</h5>
            </div>
            <div class="modal-body msgmodal-body">
                <form id="form-add_document_info" class="col-lg-12 col-md-12 col-sm-12" onSubmit="return false;">
                    <div class="col-lg-12 col-md-12 col-sm-12">

                        <div class="row" style="display: none">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Document Category <font color="red">*</font> </label>
                                <select id="cd-sel-document-cat" name="cdSelDocumentCat" class="form-control">
                                    <option value="0" selected disabled="true">Document Category </option>
                                    <option value="1"> General  </option>
                                    <option  value="2"> Services </option>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="display: none">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Type of Document <font color="red">*</font></label>
                                <select id="cd-sel-document-type" name="cdSelDocumentType" class="form-control">
                                    <option value="0" selected disabled="true">Document type </option>
                                    <option value="1"> General </option>
                                    <option  value="2"> Services </option>

                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Choose file to upload <font color="red">*</font></label>
                                <input type="file" name="cdDocFile" required data-action="0" id="cd-doc-file" accept="image/x-png,image/gif,image/jpeg,application/pdf,application/vnd.ms-excel,application/doc,application/docx,application/xls,application/xlsx,application/csv" class="form-control-file" id="documentselect" >
                                <input type="file" name="cdDocFile" data-action="0" id="cd-doc-file" accept="image/x-png,image/gif,image/jpeg" class="form-control-file" id="documentselect">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Remarks <font color="red">*</font></label>
                                <textarea class="form-control noSpcStart" name="cdTxtDocumentRemark"  maxlength="1000" id="cd-txt-doc-remarks" rows="3"></textarea>
                            </div>
                        </div>                       
                    </div>
                    <div class="content-footer float-right  match-buttons">
                        <button type="button" class="btn btn-cancel btn-modal-cancel" data-dismiss="modal" >Cancel</button>
                        <button type="submit" class="btn btn-primary-orange btn-next btn-save-document" style="margin-left:0px;" >Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>-->



<!--Upload DOCUMENT-->
<div class="modal fade" id="modalcontent-add_document" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add picture attachment</h5>
            </div> 
            <div class="modal-body ">
                <form id="form-add_document_info" class="col-lg-12 col-md-12 col-sm-12" onSubmit="return false;">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="row" style="display: none">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Document Category  <font color="red">*</font> </label>
                                <select id="cd-sel-document-cat" name="cdSelDocumentCat" class="form-control">
                                    <option value="0" selected disabled="true">Document Category </option>
                                    <option value="1"> General </option>
                                    <option value="2"> Services </option>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="display: none">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Type of Document  <font color="red">*</font> </label>
                                <select id="cd-sel-document-type" name="cdSelDocumentType" class="form-control">
                                </select>
                            </div>
                        </div>                      
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Choose photo to upload  <font color="red">* Max size is 5MB</font></label>
                                <div class="card border-0" id="mng-picture_attachment">
                                    <div class="row" >
                                        <div class="form-group col-lg-12  div-image">
                                            <div class="form-group col-lg-12  div-image shadow-sm">
                                                <div class="card-body  modal-div-image text-center div-cfu">
                                                    <i class="fas fa-upload text-gray-500"></i><br>
                                                    <span class="small text-gray-500 mgn-T-18">Choose file to upload.</span>
                                                </div>
                                                <a href="#" class="img-uploaded" target="_blank"> 
                                                    <div class="card-body  modal-div-image text-center">
                                                        <img src="" class="img-uploaded" style="height: auto;width: 10vh; margin: 0 auto" alt="">
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 px-0">
                                            <input type="file" id="cd-doc-file"  name="cdDocFile"  accept="image/x-png,image/gif,image/jpeg" class="form-control-file badge-light" required="">
                                        </div>
                                    </div>
                                </div>
                                    <!--<input type="file" name="cdDocFile" data-action="0" id="cd-doc-file" accept="image/x-png,image/gif,image/jpeg,application/pdf,application/vnd.ms-excel,application/doc,application/docx,application/xls,application/xlsx,application/csv" class="form-control-file" id="documentselect">-->
                                    <!--<input type="file" name="cdDocFile" data-action="0" id="cd-doc-file" accept="image/x-png,image/gif,image/jpeg" class="form-control-file" id="documentselect">-->
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Remarks  <font color="red">*</font> </label>
                                <textarea class="form-control" name="cdTxtDocumentRemark" id="cd-txt-doc-remarks" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="content-footer float-right  match-buttons">
                        <button type="button" class="btn btn-cancel btn-modal-cancel" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary-orange btn-next btn-save-document" style="margin-left:0px;">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--End Document-->

<div class="modal fade bd-example-modal-lg" id="modal-add_case_offender" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title " id="">Add Alleged Offender</h5>
            </div>
            <div class="modal-body msgmodal-body">
                <form id="form-add_offender" class="col-lg-12 col-md-12 col-sm-12" onSubmit="return false;">
                    <div class="col-lg-12 col-md-12 col-sm-12">

                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Offender Type <font color="red">*</font> </label>
                                <select class="form-control sel-offender_type a-case-offender_type" name="offender_type" >

                                </select>
                            </div>
                        </div>
                        <div class="offender_field_other" style="display: none;">
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label>Name of Offender  <font color="red">*</font> </label>
                                    <input type="text" class="form-control a-case-offender_name" name="offender_name" maxlength="100">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label>Nationality</label>
                                    <select class="form-control sel-nationality a-case-offender_nationality" >
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label>Relation</label>
                                    <input type="text" class="form-control a-case-offender_relation" maxlength="100">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label>Address</label>
                                    <textarea class="form-control a-case-offender_address noSpcStart" maxlength="1000" rows="5" cols="150" ></textarea>

                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label>Contact Number</label>
                                    <input type="text" class="form-control numbersOnly a-case-offender_contact" maxlength="20" minlength="7"  name="offender_contact" >
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label>Alias</label>
                                    <input type="text" class="form-control a-case-offender_alias" name="offender_alias" maxlength="100">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label>Place of Birth</label>
                                    <input type="text" class="form-control a-case-offender_place_of_birth" maxlength="100">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label>Date of Birth</label>
                                    <input type="text" class="form-control a-case-offender_date_of_birth datepicker" maxlength="100">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label>Occupation</label>
                                    <input type="text" class="form-control a-case-offender_occupation" maxlength="100">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label>Principal Place of Business</label>
                                    <input type="text" class="form-control a-case-offender_principal_place_of_business" maxlength="100">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label>Gender</label>
                                    <select class="form-control sel-sex a-case-offender_gender">
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label>Religion</label>
                                    <select class="form-control a-case-offender_religion sel-religion">
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label>Race/ethnicity</label>
                                    <input type="text" class="form-control a-case-offender_race_ethnicity" maxlength="100">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label>Civil Status</label>
                                    <select class="form-control sel-civil a-case-offender_civil_status" >
                                        <option selected="">Civil Status</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label>Previous case/Violation committed</label>
                                    <input type="text" class="form-control a-case-offender_previous_case_committed" maxlength="100">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label>Name of Parents</label>
                                    <input type="text" class="form-control a-case-offender_name_of_parents" maxlength="100">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label>Name of Spouse if Married</label>
                                    <input type="text" class="form-control a-case-offender_name_of_spouse" maxlength="100">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label>Social Media Account/Platform</label>
                                    <input type="text" class="form-control a-case-offender_social_media_account" maxlength="100">
                                </div>
                            </div>

                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label>Remarks</label>
                                    <textarea class="form-control a-case-offender_remarks noSpcStart" maxlength="1000" rows="5" cols="150" ></textarea>
                                </div>
                            </div>
                            
                            

                    </div>
                    <div class="content-footer float-right  match-buttons">
                        <button type="button" class="btn btn-cancel btn-modal-cancel" data-dismiss="modal" >Cancel</button>
                        <button type="submit" class="btn btn-primary-orange btn-next btn-save-document" style="margin-left:0px;" >Save</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer msgmodal-footer">
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="modal-update_case_offender" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title " id="">Update Alleged Offender</h5>
            </div>
            <div class="modal-body msgmodal-body">
                <form id="form-update_offender" class="col-lg-12 col-md-12 col-sm-12" onSubmit="return false;">
                    <input type="hidden" class="stored-offender_id">
                    <div class="col-lg-12 col-md-12 col-sm-12">

                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Offender Type</label>
                                <select class="form-control sel-offender_type u-case-offender_type" disabled="true" name="offender_type" >
                                </select>
                            </div>
                        </div>
                        <div class="offender_field_other" style="display: none;">
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label> Offender Name</label>
                                    <input type="text" class="form-control u-case-offender_name" name="offender_name">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label>Name of Owner </label>
                                    <input type="text" class="form-control " name="" maxlength="100">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label>Name of Representative</label>
                                    <input type="text" class="form-control " name="" maxlength="100" >
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label>Nationality</label>
                                    <select class="form-control sel-nationality u-case-offender_nationality" >
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label>Relation</label>
                                    <input type="text" class="form-control u-case-offender_relation" maxlength="100" >
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label>Address</label>
                                    <textarea class="form-control u-case-offender_address noSpcStart" rows="5"  maxlength="100" cols="150" ></textarea>

                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label>Contact Number</label>
                                    <input type="text" class="form-control numbersOnly u-case-offender_contact" maxlength="20" minlength="7"  name="offender_contact" >

                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label>Sub Agent </label>
                                    <input type="text" class="form-control"  maxlength="100" name="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Remarks</label>
                                <textarea class="form-control u-case-offender_remarks noSpcStart"  maxlength="1000" rows="5" cols="150" ></textarea>

                            </div>
                        </div>

                    </div>
                    <div class="content-footer float-right  match-buttons">
                        <button type="button" class="btn btn-cancel " data-dismiss="modal" >Cancel</button>
                        <button type="submit" class="btn btn-secondary-light_blue btn-save-document" style="margin-left:0px;" >Update</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer msgmodal-footer">
            </div>
        </div>
    </div>
</div>


<!--Update DOCUMENT-->
<div class="modal fade" id="modalcontent-update_document" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update picture attachment</h5>
            </div>
            <div class="modal-body ">
                <form id="form-update_document_info" class="col-lg-12 col-md-12 col-sm-12" onSubmit="return false;">
                    <div class="col-lg-12 col-md-12 col-sm-12">                  
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Choose photo to upload  <font color="red">* Max size is 5MB</font></label>
                                <div class="card border-0" id="mng-picture_attachment">
                                    <div class="row" >
                                        <div class="form-group col-lg-12  div-image shadow-sm">
                                            <a href="#" class="img-uploaded" target="_blank"> 
                                                <div class="card-body  modal-div-image text-center">
                                                    <img src="" class="img-uploaded" style="height: auto;width: 10vh; margin: 0 auto" alt="">
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 px-0">
                                            <input type="file" id="ucd-doc-file"  name="cdDocFile"  accept="image/x-png,image/gif,image/jpeg" class="form-control-file badge-light">
                                        </div>
                                    </div>
                                </div>
                                    <!--<input type="file" name="cdDocFile" data-action="0" id="cd-doc-file" accept="image/x-png,image/gif,image/jpeg,application/pdf,application/vnd.ms-excel,application/doc,application/docx,application/xls,application/xlsx,application/csv" class="form-control-file" id="documentselect">-->
                                    <!--<input type="file" name="cdDocFile" data-action="0" id="cd-doc-file" accept="image/x-png,image/gif,image/jpeg" class="form-control-file" id="documentselect">-->
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Remarks  <font color="red">*</font> </label>
                                <textarea class="form-control" name="cdTxtDocumentRemark" id="ucd-txt-doc-remarks" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="content-footer float-right  match-buttons">
                        <button type="button" class="btn btn-cancel btn-modal-cancel" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary-orange btn-next" style="margin-left:0px;">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Update Document-->

<!-- Modal -->
<div id="cropImagePop" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body m-5">
                <div class="col-xs-12 col-sm-4 col-sm-offset-4" style="display: contents">
                    <div  class="container" style="display: block; width: 300px; height: 300px;">
                        <div id="upload-demo"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel"  data-dismiss="modal" >Cancel</button>
                <button type="button" id="cropImageBtn" class="btn btn-save">Crop</button>
            </div>
        </div>
    </div>
</div>
<!--End Modal-->


