<?php
/**
 * Page Security
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<div class="card col-md-12" >
    <div class="card-header card-sub-title bg-white">
        Validate Victim's Details<br> 
        <small class="card-desc"> Provide the required details to validate if there exists the same case or report. </small> 
    </div>
    <div class=" card-validate">
        <form id="form-validate_victim" class="col-lg-12 col-md-12 col-sm-12" onSubmit="return false;">
            <div class="form-row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="row mx-2">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                            <label>First Name <font color="red"> <b>*</b> </font> </label>
                            <input type="text" maxlength="50" class="form-control v-first_name letNumDash" name="first_name" value="">
                        </div>
                    </div>
                    <div class="row mx-2">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                            <label>Middle Name </label>
                            <input type="text" maxlength="50" class="form-control v-middle_name lettersOnly" >
                        </div>
                    </div>
                    <div class="row mx-2">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                            <label> Last Name <font color="red"> <b>*</b> </font></label>
                            <input type="text" maxlength="50" class="form-control v-last_name lettersOnly" name="last_name" value="">
                        </div>
                    </div>
                    <div class="row mx-2">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                            <label> Date of Birth    
                            <!-- <font color="red"> <b>*</b> </font>  -->
                            </label>
                            <input type="text" class="form-control v-dob datepicker" name="v_dob" placeholder="MM/DD/YYYY">
                        </div>
                    </div>
                    <div class="row mx-2">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                            <label> Place of Birth </label>
                            <select class="form-control v-pob sel-provinces" >
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="row mx-2">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                            <label>Alleged Offender's Name</label>
                            <input type="text" maxlength="50" class="form-control v-offender_name" >
                        </div>
                    </div>
                    <div class="row mx-2">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                            <label>Employer's Name / Company Name</label>
                            <input type="text" maxlength="50" class="form-control v-employer_name" >
                            <ul class="list-group c-out"  id="validate-employer-search">                        
                            </ul>
                        </div>
                    </div>
                    <div class="row mx-2">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                            <label>Local Recruitment Agency</label>
                            <input type="text" maxlength="50" class="form-control v-local_recruitment_agency" >
                            <ul class="list-group c-out"  id="validate-local-search">                        
                            </ul>
                        </div>
                    </div>
                    <div class="row mx-2" >
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 form-currency hide">
                            <label>Date of Deployment <font color="red"> <b>*</b> </font> </label>
                            <input type="text" name="v_deployed_date" class="form-control datepicker v-deployed_date" placeholder="MM/DD/YYYY">
                        </div>
                        <!--<div class="form-group col-lg-6 col-md-6 col-sm-6 form-salary">-->
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 form-salary hide">
                            <label>Country of  Deployment </label>
                            <select class="form-control v-deployment_country sel-country">
                                <option value="173" data-currency="PHP" data-name="Philippines" selected>Philippines</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mx-2">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                            <label>Type of Complaint</label>
                            <select class="form-control sel-traffic_purpose v-traffic_purpose">
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="card col-md-12 ">
                        <div >
                            <button type="submit" class="btn btn-secondary-light_blue  btn-validate float-right">Validate</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row  card-validate" id="div-match_result">
    <div class="card col-md-12">

        <!--SHOW MATCHES IN VALIDATING CASE-->
        <!--note: don't erase inline style it's for js function-->
        <div class="inner-box m-0 matched_contents" >
            <div class="row form-row">

                <div class="col-lg-12 col-md-12 col-sm-12 card-sub-title blue pl-3"> Matched Results <span class="matched_count"></span><br> 
                    <small class="card-desc">Please see matched results from the list </small> 
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12">

                    <div class="inner-box matched_results" >                        
                        <table class="table">
                            <thead class="thead-grey row-header-border">
                                <tr>
                                    <th>Victim</th>
                                    <th>No.of Cases</th>
                                    <th>Match</th>
                                </tr>
                            </thead>
                            <tbody class="match-result-content">
                            </tbody>
                        </table>

                        <div class="pagination-wrapper rs-list px-3">
                            <div class="row">
                                <div class="col m12 s12 l4">
                                    <p class="pagination-details rs-info"></p>
                                </div>
                                <div class="col m12 s12 l8 text-right">
                                    <ul class="pagination rs-pagination">
                                    </ul>
                                </div>
                            </div>
                        </div> 
                    </div>

                    <div class="inner-box matched_none" >                        
                        <div class="no-contact_person">
                            <div class="container-fluid text-center" id="no-data_found">
                                <div class="nd-header">
                                    <div> <i class="fas fa-exclamation-triangle"></i> </div>
                                </div>
                                <div class="nd-body">
                                    <h5 class="nd-body-content ">NO MATCHED REPORT/VICTIM FOUND</h5> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="form-actions">
    <div class="row">
        <div class="card col-md-12">
            <div >
                <button type="submit" class="btn btn-primary-orange btn-next btn-next_tab float-right btn-fr_validate" >Add new report</button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade bd-example-modal-lg" id="mdl-victim-details1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="vic-name mt-5 ml-5">
                <span class="content-title "></span> <i class="fas fa-check-circle text-success" hidden></i>
            </div>

            <div class="vic-victim_info_dob ml-5">
            </div>
            <div class="modal-body">
                <div class="row">    
                    <div class="col-lg-8 col-md-8 col-sm-8 "> 

                    </div>
                    <div class="col-lg-4 col-md-4col-sm-4 "> 
                        <div class="card-title">
                            <button type="button" class="btn btn-secondary-light_blue float-right mrg-t-n-10 validate-add-new-btn"><i class="fa fa-plus"></i> Add New Case</button>
                        </div>
                    </div>
                </div>

                <div class="container-inner bg-white">
                    <div class="container-match-result1 validation-case-list1">
                        <div class="row case-item" data-cvid="1505" data-vinfid="302">
                            <div class="col-md-2 col-sm-2 col-lg-2 "> <img src="assets/modules/administrator/img/1_1.png" class="pull-right agency-validation_case"> </div>
                            <div class="col-md-6 col-sm-6 col-lg-6">
                                <p class="case-agency_name">Agency Name: Local Agency </p>
                                <p class="case-employer_name">Employer Name: Employer Name</p>
                                <p class="case-case_victim_deployment_date">Deplyment Date: 2018-07-18</p>
                                <p class="case-case_offender_name">Offender Name: asdas</p>
                                <p class="case-country">Country: </p>
                            </div>
                            <div class="col-md-3 col-sm-3 col-lg-3"> <b class="pull-right"></b></div>
                        </div>
                        <hr>
                        <div class="row case-item" data-cvid="1505" data-vinfid="302">
                            <div class="col-md-2 col-sm-2 col-lg-2 "> <img src="assets/modules/administrator/img/1_1.png" class="pull-right agency-validation_case"> </div>
                            <div class="col-md-6 col-sm-6 col-lg-6">
                                <p class="case-agency_name">Agency Name: Local Agency </p>
                                <p class="case-employer_name">Employer Name: Employer Name</p>
                                <p class="case-case_victim_deployment_date">Deplyment Date: 2018-07-18</p>
                                <p class="case-case_offender_name">Offender Name: asdas</p>
                                <p class="case-country">Country: </p>
                            </div>
                            <div class="col-md-3 col-sm-3 col-lg-3"> <b class="pull-right"></b></div>
                        </div>

                    </div>


                    <div class="container-match-result1 validation-case-list1">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-close float-right" data-dismiss="modal"> Close </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade  modal-manage " id="mdl-victim-details" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-details shadow-sm" role="document">
        <div class="modal-content ">
            <div class="modal-header p-0 modal-left d-block">
                <h5 class="modal-title h5-title msgmodal-header text-normal">
                    List of case for <span class="spn_victim">victim : <span class="content-title vic-name">-</span> </span>
                </h5>
                <div class="row mb-2 vic-personal-info pl-3">
                </div>
            </div>
            <div class="modal-body">
                <div class="mdl-body_view_agency" id="v-case-list">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary-orange validate-add-new-btn" data-dismiss="modal">Add new report for this victim</button>
                <button type="button" class="btn  btn-cancel btn-close" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
