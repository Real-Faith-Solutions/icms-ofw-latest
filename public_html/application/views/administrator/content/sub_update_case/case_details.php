<?php
/**
 * Page Security
 */
defined('BASEPATH') or exit('No direct script access allowed');
?>

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
                        <div class=" card-sub-title txt-W-500 " style="color: #e88f15;"> Complainant Information
                        </div>
                    </div>
                </div>
                <form id="frm-complainant"> 
                    <div class=" px-3">
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Date Complained</label>
                                <input type="text" class="form-control case-date_complained datepicker" name="datecomplained" id="date-complained" placeholder="MM/DD/YYYY">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Source <font color="red">*</font> </label>
                                <select id="cd-sel-source" class="form-control case-complainant_source" name="complainantsource"></select>
                            </div>
                        </div> 
                        <div class="row">                            
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Relationship to victim</label>
                                <select class="form-control case-complainant_relation" id="sel-relation-to-victim" name="selrelationtovictim"></select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Name of Complainant</label>
                                <input type="text" id="cd-txt-name" class="form-control case-complainant_name" name="complainantname">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Contact Number</label>
                                <input type="text" class="form-control numbersOnly case-complainant_contact" id="complainant_contact" name="complainantcontact">
                            </div>
                        </div>
                        <div class="row div-case-complainant_relation_other" style="display: none">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Other:</label>
                                <input type="text" maxlength="50" class="form-control case-complainant_relation_other noSpcStart" id="complainant_relation_other"> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Address</label>
                                <textarea class="form-control valid noSpcStart case-complainant_address" id="complainant_address" rows="4" maxlength="200" aria-invalid="false" name="complainantaddress"></textarea>
                            </div>
                        </div>
                    </div>
                </form> 
                <div class="content-footer float-right">
                    <button class="btn btn-update pull-left hide" id="btn-complain-cancel">Cancel</button>
                    <button class="btn btn-update pull-left" id="btn-complain" dataction="todisabled">Update</button>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-6 col-sm-12">
            <div class="form-padding-left py-2">
                <div class="row px-3">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class=" card-sub-title txt-W-500 " style="color: #e88f15;"> Type of Complaint
                            <br>
                            <small class="card-desc"> Traffic in Persons Elements. </small>
                        </div>
                    </div>
                </div>
                <div class=" px-3">
                    <form id="frm-act-means-purpose">
                        <div class="row">
                            <div class="form-group col-lg-10 col-md-12 col-sm-12">
                                <label> Acts</label>
                                <div class="div-cd-sel-amp" style="display: none">
                                    <select id="cd-sel-acts" name="selectActs" class="select sel-filter chosen-select" data-acts="0" data-placeholder="Filter" tabindex="-1" multiple="multiple">
                                    </select>
                                </div>
                                <ul id="ul-cd-sel-acts-label" class="ul-cd-sel-amp p-2 mb-0"></ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-10 col-md-12 col-sm-12">
                                <label> Means</label>
                                <div class="div-cd-sel-amp" style="display: none">
                                    <select id="cd-sel-means" name="selectMeans" class="select sel-filter chosen-select" data-placeholder="Filter" tabindex="-1" multiple="multiple">
                                    </select>
                                </div>
                                <ul id="ul-cd-sel-means-label" class="ul-cd-sel-amp p-2 mb-0"></ul>

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-10 col-md-12 col-sm-12">
                                <label> Purpose</label>
                                <div class="div-cd-sel-amp" style="display: none">
                                    <select id="cd-sel-purposes" name="selectPurpose" class="select sel-filter chosen-select" data-placeholder="Filter" tabindex="-1" multiple="multiple">
                                    </select>
                                </div>
                                <ul id="ul-cd-sel-purposes-label" class="ul-cd-sel-amp p-2 mb-0"></ul>

                            </div>
                        </div>
                        <!-- <div class="row">
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
                        </div> -->
                        <fieldset><div class="col-lg-2 col-md-2 col-sm-2">
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="form-group form-check">
                                    <input type="radio" class="form-check-input case-violated noSpcStart" id="ch1" name="s_violated">
                                    <label class="form-check-label " for="ch1" style="color: #e88f15 !important;">CSEC 
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="form-group form-check">
                                    <input type="radio" class="form-check-input case-violated noSpcStart" id="ch4" name="s_violated">
                                    <label class="form-check-label " for="ch4" style="color: #e88f15 !important;">CSAEM
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="form-group form-check">
                                    <input type="radio" class="form-check-input case-violated noSpcStart" id="ch2" name="s_violated">
                                    <label class="form-check-label" for="ch2" style="color: #e88f15 !important;">OSAEC
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="form-group form-check">
                                    <input type="radio" class="form-check-input case-violated noSpcStart" id="ch3" name="s_violated">
                                    <label class="form-check-label " for="ch3" style="color: #e88f15 !important;">Other law/s violated
                                    </label>
                                </div>
                            </div>
                        </div></fieldset>
                        <div class="row div-other_law_desc" style="display: none;">
                            <div class="form-group col-lg-10 col-md-12 col-sm-12">
                                <label> Other Law Description </label>
                                <textarea class="form-control case-other_law_desc noSpcStart" maxlength="2000" style="height: unset !important;" rows="5" cols="150" placeholder="Other Law Description..."></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-10 col-md-12 col-sm-12">
                                <label> Brief facts of the case </label>
                                <textarea class="form-control case-facts noSpcStart" maxlength="2000" style="height: unset !important;" rows="5" cols="150" placeholder="Summarize report or remarks of the case..." id="area-brief-facts"></textarea>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-lg-10 col-md-12 col-sm-12">
                            <div class="content-footer float-right">
                                <button class="btn btn-update pull-left hide" id="btn-fact-cancel">Cancel</button>
                                <button class="btn btn-update pull-left" id="btn-facts" dataction="1">Update</button>
                            </div>
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
                        <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#tab-services" role="tab" aria-controls="passport_info">Victim's needs / Services <span class="float-right hide"> <i class="fa fa-caret-right" aria-hidden="true"></i></span></a>
                        <a class="list-group-item list-group-item-action" id="list-offender-list" data-toggle="list" href="#tab-offender" role="tab" aria-controls="offender_info">Alleged Offender's Details <span class="float-right hide"> <i class="fa fa-caret-right" aria-hidden="true"></i></span></a>
                        <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#tab-document_attachment" role="tab" aria-controls="flight_details">Picture attachment <span class="float-right hide"> <i class="fa fa-caret-right" aria-hidden="true"></i></span></a>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7 col-sm-12">
                    <div class="tab-content tab-sub-info-content" id="nav-tabContent" style=" padding: 17px 20px;">
                        <div class="tab-pane fade show active" id="tab-case_evaluation" role="tabpanel" aria-labelledby="list-home-list">

                            <div class=" card-sub-title"> Case evaluation and risk assessment <br>
                                <small class="card-desc"> Summary of evaluation and assessment based on case details. </small>
                                <hr class="card-sub-title_border">
                            </div>


                            <form id="fmr-manage-evaluation">
                                <div class="row form-row">
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                        <label>Case evaluation</label>
                                        <textarea class="form-control case-evaluation noSpcStart" disabled id="area-evaluation" maxlength="5000" style="height: 150px !important;" placeholder="Case evaluation..."></textarea>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                        <label>Risk assessment</label>
                                        <textarea class="form-control case-risk_assessment noSpcStart" disabled id="area-case-risk-assessment" maxlength="5000" style="height: 150px !important;" placeholder="Risk assessment..."></textarea>
                                    </div>
                                </div>
                            </form>
                            <!-- <form id="fmr-manage-evaluation">
                                <div class="col-lg-10 col-md-12 col-sm-12">
                                    <div class=" card card_tbl-container ">
                                        <div class="row">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label>Case evaluation</label>
                                                <textarea class="form-control case-evaluation noSpcStart" disabled id="area-evaluation" maxlength="5000" style="height: 150px !important;" placeholder="Case evaluation..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-10 col-md-12 col-sm-12">
                                    <div class=" card card_tbl-container ">
                                        <div class="row">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label>Risk assessment</label>
                                                <textarea class="form-control case-risk_assessment noSpcStart" disabled id="area-case-risk-assessment" maxlength="5000" style="height: 150px !important;" placeholder="Risk assessment..."></textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form> -->
                            <div class="col-lg-10 col-md-12 col-sm-12">
                                <div class="content-footer float-right">
                                    <button class="btn btn-update pull-left " id="btn-manage-evaluation">Manage</button>
                                    <button class="btn btn-update pull-left hide" id="btn-save-evaluation">Save</button>
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
                                                <span class="">Alleged Offender's Information</span>
                                            </div>
                                            <div class='float-right'>
                                                <button type="button" class="btn btn-secondary-light_blue" id="btn-add-offender"><i class="fa fa-plus"></i> Add Alleged Offender</button>
                                            </div>
                                        </div>
                                        <table class="table">
                                            <thead class="thead-grey">
                                                <tr>
                                                    <th scope="col">Alleged's Offender</th>
                                                    <th scope="col">Remarks</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbl-offender-list" id="tbl-offender-list">
                                                <tr>
                                                    <td colspan='3' class='text-center'>Please wait . . .</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-services" role="tabpanel" aria-labelledby="list-profile-list">

                            <div class=" card-sub-title">
                                Services list <br>
                                <small class="card-desc">Services for victim.</small>

                                <hr class="card-sub-title_border">
                            </div>
                            <div class="row form-row">

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="card card_tbl-container">
                                        <div class="card_tbl-action">
                                            <div class="tbl_info card-sub-title">
                                                <span class="">Needs / Service list</span>
                                            </div>
                                            <div class='float-right lvl-ce lvl-ra'>
                                                <a href="#" target="_blank" class="a-manage_services float-right">Go to service monitoring </a>
                                                    <!-- <button type="button" class="btn btn-secondary-light_blue btn-add_assessment"><i class="fa fa-plus"></i> Add Service</button> -->
                                            </div>
                                        </div>
                                        <table class="table">
                                            <thead class="thead-grey row-header-border">
                                                <tr>
                                                    <th scope="col">Service / Assistance</th>
                                                    <th scope="col">Service Term</th>
                                                    <th scope="col">Tagged Agency</th>
                                                    <th scope="col">Number of Days</th>
                                                    <th scope="col">Date Tagged</th>
                                                    <th scope="col">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbl-services-list">
                                                <tr>
                                                    <td colspan="5" class="text-center" style="text-align: center !important;">No transit info added to list.</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-document_attachment" role="tabpanel" aria-labelledby="list-messages-list">
                            <br> <div class=" card-sub-title" > Picture attachment <span class="txt-orange"> (1 attachment) </span> <br> 
                                <small class="card-desc"> Only upload victims' picture for identification.</small> 
                                <hr class="card-sub-title_border">
                            </div>
                            <div class="row form-row">

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="card card_tbl-container">
                                        <div class="card_tbl-action">
                                            <div class="tbl_info card-sub-title">
                                                <span class="">Attachment list</span>
                                            </div>
                                            <div class='float-right'>
                                                <button type="button" class="btn btn-secondary-light_blue btn-add_document"><i class="fa fa-plus"></i> Add attachment</button>
                                            </div>
                                        </div>
                                        <table class="table">
                                            <thead class="thead-grey row-header-border">
                                                <tr>
                                                    <!--<th width="15%" scope="col">Category</th>
                                                    <th width="15%" scope="col">Type</th>-->
                                                    <!--<th width="30%" scope="col">File Name</th>-->
                                                    <th width="70%" scope="col">Remarks</th>
                                                    <th width="20%" scope="col">Date</th>
                                                    <th width="10%" scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody-document-list">
                                                <tr>
                                                    <td colspan='6' class='text-center'>Loading please wait . . </td>
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

        <div class="fake-info-content bg-transparent padding-l-15 div-priority_level lvl-ce lvl-ch lvl-ra">
            <form id="frm-priority_level">
                <div class="row">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="recommendedLevel" id="tagged-h" value="3">
                        <label class="form-check-label" for="tagged-h">High priority <small class=" icms-text-default ">( should be addressed within one or two work days. )</small></label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="recommendedLevel" id="tagged-m" value="2">
                        <label class="form-check-label" for="tagged-m">Medium priority <small class=" icms-text-default ">( should be addressed between three work days and three weeks. )</small></label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="recommendedLevel" id="tagged-l" value="1">
                        <label class="form-check-label" for="tagged-l">Low priority <small class=" icms-text-default ">( will be addressed, but will likely take more than three weeks. )</small></label>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>

<!--SERVICE LOGS PER SERVICE MODAL-->
<div class="modal fade bd-example-modal-lg" id="mdl-case-details" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content mdl-case-details">
            <div class="modal-header">
                <h5 class="modal-title " id="">Service Details</h5>
            </div>
            <div class="modal-body">

                <div class="container div-view-details">
                    <!-- <div class="row">
                        <div class=" col col-lg-12">
                            <small class="content-sub-title" style="margin-bottom:  10%;" id="div-service-remarks">Brief details of the case.</small>
                            <br> <br>
                        </div>
                    </div> -->
                    <div class="row">
                        <div class=" col col-lg-3 p-2 font-weight-bold">
                            Agency :
                        </div>
                        <div class=" col col-lg-9 p-2" id="div-agency">

                        </div>
                    </div>
                    <div class="row">
                        <div class=" col col-lg-3 p-2 font-weight-bold">
                            Service :
                        </div>
                        <div class=" col col-lg-9 p-2" id="div-service">

                        </div>
                    </div>
                    <div class="row">
                        <div class=" col col-lg-3 p-2 font-weight-bold">
                            Assessment Term :
                        </div>
                        <div class=" col col-lg-9 p-2" id="div-service-term">

                        </div>
                    </div>
                    <div class="row">
                        <div class=" col col-lg-3 p-2 font-weight-bold">
                            Date Tagged :
                        </div>
                        <div class=" col col-lg-9 p-2" id="div-date-tagged">
                        </div>
                    </div>
                    <div class="row">
                        <div class=" col col-lg-3 p-2 font-weight-bold">
                            No of days  : 
                        </div>
                        <div class=" col col-lg-9 p-2" id="div-days-number">
                        </div>
                    </div>
                    <div class="row">
                        <div class=" col col-lg-3 p-2 font-weight-bold">
                            Remarks :
                        </div>
                        <div class=" col col-lg-9 p-2 " id="div-tagged-remarks">

                        </div>
                    </div>
                    <div class="row">
                        <div class=" col col-lg-3 p-2 font-weight-bold">
                            Status :
                        </div>
                        <div class=" col col-lg-5 p-2 " id="div-tagged-status">

                        </div>
                        <!--// for updating services status //-->
                        <div class=" col col-lg-4 p-2 font-weight-bold" style="display:none">
                            <u style='color: #0088cc; cursor: pointer;' id='lnk-change-stats' class=" lvl-ce lvl-ra">Update status</u>
                        </div>
                    </div>
                </div>



                <div class="div-update p-4 hide">

                    <form id="frm-update-status">
                        <div class="form-group">
                            <label for="sel-new-stat">Status</label>
                            <select class="form-control" name="selNewStat" id="sel-new-stat">

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="area-new-tagged-remarks">Remarks</label>
                            <textarea class="form-control" name="areaNewTaggedRemarks" id="area-new-tagged-remarks" rows="3"></textarea>
                        </div>
                    </form>
                    <div class="form-group float-right mt-3">
                        <button class="btn-update btn ml-0" id="btn-stat-update">Update</button>
                        <button class="btn-update btn" id="btn-stat-cancel">Cancel</button>
                    </div>

                </div>

            </div>
            <div class="modal-footer float-right">
                <button type="button" class="btn btn-cancel btn-modal-cancel" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-Initial-asssessment" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title  msgmodal-header modal-header_title "> Add Services Information</h5>
            </div>
            <div class="modal-body msgmodal-body">
                <form id="form-add_assessment_info" class="col-lg-12 col-md-12 col-sm-12" data-assessmecol-12nt="0" data-service="0" data-agencies="0" onSubmit="return false;">
                    <div class="col-lg-12 col-md-12 col-sm-12">

                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Assessment Type <font color="red">*</font></label>
                                <select id="cd-mdl-sel-assmnt-type" class="form-control" name="assessment_type">
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Services  <font color="red">*</font> </label>
                                <select id="cd-mdl-sel-service" class="form-control" name="service">
                                    <option selected disabled="true">Choose </option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Agencies  <font color="red">*</font></label>
                                <br>
                                <select id="cd-mdl-sel-agncy" name="agencies" class="select sel-filter chosen-select" tabindex="-1" style="width: 100%; border-radius: 5px; height: 32px;">
                                    <option> </option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Expected delivery of service </label>
                                <input type="text" id="cd-mdl-txt-set-age_label" class="form-control" placeholder="" disabled="true" >
                            </div>
                        </div>
                        <div class="row ">
                            <div class=" col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group row-cd-departure" style="display: none;">
                                    <label> Departure Date </label>
                                    <input type="text" id="cd-mdl-txt-departure-date" name="departure_date" class="form-control datetimepicker" placeholder="MM/DD/YYYY">
                                </div>
                            </div>
                            <div class=" col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group row-cd-arrival" style="display: none;">
                                    <label> Arrival Date </label>
                                    <input type="text" id="cd-mdl-txt-arrival-date" name="arrival_date" class="form-control datetimepicker" placeholder="MM/DD/YYYY">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Remarks </label>
                                <textarea type="text" id="cd-mdl-txt-remarks" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="content-footer float-right  match-buttons">
                        <button type="button" class="btn btn-cancel btn-modal-cancel" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary-orange btn-next btn-save-assessment" style="margin-left:0px;">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!--UPDATE DOCUMENT-->
<div class="modal fade" id="modalcontent-add_offender" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alleged Offender</h5>
            </div>
            <div class="modal-body ">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <form id="form-add_update_offender" class="col-lg-12 col-md-12 col-sm-12">
                        <div class="col-lg-12 col-md-12 col-sm-12">

                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label> Alleged Offender Type <font color="red">*</font> </label>
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
                            <button type="submit" id="btn-save-offender"  class="btn btn-primary-orange btn-next btn-save-offender" style="margin-left:0px;" >Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Upload DOCUMENT-->
<div class="modal fade" id="modalcontent-add_document" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add attachment</h5>
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
                                <label>Choose photo to upload  <font color="red">*</font></label>
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
                                            <input type="file" id="cd-doc-file"  name="cdDocFile"  accept="image/x-png,image/gif,image/jpeg" class="form-control-file badge-light">
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

<!--Update DOCUMENT-->
<div class="modal fade" id="modalcontent-update_document" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update attachment</h5>
            </div>
            <div class="modal-body ">
                <form id="form-update_document_info" class="col-lg-12 col-md-12 col-sm-12" onSubmit="return false;">
                    <div class="col-lg-12 col-md-12 col-sm-12">                  
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Choose photo to upload  <font color="red">*</font></label>
                                <div class="card border-0" id="mng-picture_attachment">
                                    <div class="row" >
                                        <div class="form-group col-lg-12  div-image shadow-sm">
                                            <div class="card-body  modal-div-image text-center div-cfu" style="display:none">
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
