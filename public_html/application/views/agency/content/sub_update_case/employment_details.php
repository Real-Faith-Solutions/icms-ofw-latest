<?php
/**
 * Page Security
 */
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!-- ================= EMPLOYMENT Details NEW CODE  =============== -->
<div class="form-content mt-3">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class=" card-sub-title txt-W-500"> Update Employment Information<br>
                <small class="card-desc"> Update details such as the name of the company, company address, designation, salary, job type, etc. </small>
                <hr class="card-sub-title_border">
                <div class="padding_15" style="color:#e88f13 !important;">
                    Note: Leave if not applicable and proceed to next step.
                </div>
            </div>
        </div>
    </div>

    <div class="row hide">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="fake-info-content padding_15 mgn-B-20 " style="display:block;    background-color: #FFE28C;">
                <form id="frm-employment_documented">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group form-check">
                                <input type="radio" class="form-check-input emp-is_documented rdo_de" value="1" name="rdo_doc_employment" id="rdo_documented_employment">
                                <label class="form-check-label employment_documented" for="rdo_documented_employment" style="color:#e88f13 !important;">Employed<br>
                                    <small class="card-desc"> Victim is employed. </small>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group form-check">
                                <input type="radio" class="form-check-input emp-case_victim_employment_is_documented rdo_de" value="0" name="rdo_doc_employment" id="rdo_undocumented_employment">
                                <label class="form-check-label employment_documented" for="rdo_undocumented_employment" style="color:#e88f13 !important;">Unemployed<br>
                                    <small class="card-desc"> Victim is unemployed. </small>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="form-row row">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="bg-form-grey py-2">
                <div class="row px-3">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class=" card-sub-title txt-W-500 " style="color: #e88f15;"> 
                            Employer's Details 
                        </div>
                    </div>
                </div>
                <form id="frm-employer_details"> 
                    <div class=" px-3">                    
                        <div class='div-emp'>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label> 
                                        Employer's Name 
                                        <a style="color: #007bff; display: none" class="emp-employer-change_emp ml-1">change employer</a> 
                                    </label>
                                    <input type="text" class="form-control emp-employer-employer_name" name="employer_name" maxlength="50" disabled="true" autocomplete="off">
                                    <ul class="list-group c-out" style="width: 100%; overflow: scroll; max-height: 300px; display: none;" id="employer-search"></ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label> Name of Employer's Representative  </label>
                                    <input type="text" class="form-control emp-employer-employer_representative_name" maxlength="50" disabled="true">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label> Contact Number</label>
                                    <input type="text" class="form-control numbersOnly emp-employer-employer_tel_no" minlength="7" maxlength="20" name="employer_telephone" disabled="true">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label> Email </label>
                                    <input type="text" class="form-control emp-employer-employer_email" name="employer_email" disabled="true">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12" style="display: none;">
                                    <label> Employer Country </label>
                                    <select id="emp-sel-eer-country" class="form-control text-capital emp-employer-employer_country_id" disabled="true">
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label> Employer City </label>
                                    <input type="text" class="form-control emp-employer-employer_city" maxlength="50" disabled="true">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label> Detailed Address </label>
                                    <textarea class="form-control valid  emp-employer-employer_full_address" rows="4" maxlength="100" aria-invalid="false" disabled="disabled"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
                <div class="content-footer float-right">
                    <button type="button" class="btn btn-update" id="btn-update-employer">Manage</button>
                    <button type="submit" class="btn btn-update hide" id="btn-save-employer">Save</button>
                </div>

            </div>
        </div>

        <!--EMPLOYMENT  DETAILS BASED OF CONTRACT -->
        <div class="col-lg-8 col-md-8 col-sm-12 form-padding-left">
            <div class="row ">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class=" card-sub-title txt-W-500"> Employment Details</div>
                </div>
            </div>
            <div class="">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <nav class="nav border-bottom nav-inner-tab">
                            <a class="nav-link txt-14  active " data-toggle="tab" href="#legal_cases">
                                Based on contract
                            </a>
                            <a class="nav-link txt-14" data-toggle="tab" href="#batch_list">
                                Not based on the contract
                            </a>
                        </nav>
                    </div>
                </div>
                <div class="tab-content tab-employment pl-0">
                    <div class="tab-pane fade show active " id="legal_cases" role="tabpanel" aria-labelledby="recent-case-tab">
                        <div class="tab-content tab-inner px-0 pt-0 ">
                            <div class=" card-sub-title txt-14 bg-yellow"> Employment details based on the <span style="color:#0088cc;"> victim’s contract </span>
                                <div class="help-tip">
                                    <p>Details that are all based on Victim's employment contract.</p>
                                </div>
                            </div>
                            <div class="inner-form-body p-3">
                                <input type="hidden" class="emp-case_victim_employment_details_id">
                                <form id="frm-emp-contract">
                                    <div class="row">
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <label> Position / Occupation</label>
                                            <select  class="form-control text-capital sel-occupations emp-case_victim_employment_details_job_title" 
                                                     id="sel_occupationsemp_case_victim_employment_details_job_title">
                                            </select>
                                            <!--<input type="text" class="form-control emp-case_victim_employment_details_job_title" maxlength="100" disabled="true">-->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                            <label> Country of Deployment </label>
                                            <select id="emp-sel-eet-country" name="emp_sel_eet_country" class="form-control text-capital emp-country_id" disabled="true"></select>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6  col-sm-12">
                                            <label> City </label>
                                            <input type="text" class="form-control emp-case_victim_employment_city" disabled="true">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-md-4 col-sm-12 form-currency">
                                            <label>Currency</label>
                                            <select id="emp-sel-eet-currency" class="form-control text-capital emp-case_victim_employment_details_salary_foreign_iso" disabled="true"></select>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-4 col-sm-12 form-salary">
                                            <label>Salary per hour</label>
                                            <input type="text" class="form-control decimal emp-case_victim_employment_details_salary_in_foreign" disabled="true">
                                        </div>
                                        <div class="form-group col-lg-4 col-md-4  col-sm-12 hide">
                                            <label> Salary per hour in Peso</label>
                                            <input type="text" class="form-control decimal emp-case_victim_employment_details_salary_in_local" disabled="true">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                            <label> Days per week</label>
                                            <input type="text" maxlength="1" class="form-control emp-case_victim_employment_details_working_days numbersOnly" placeholder=" No. of days / week" disabled="true">
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                            <label> Hours per day</label>
                                            <input type="text" maxlength="2" class="form-control numbersOnly emp-case_victim_employment_details_working_hours" placeholder="No. of hours / day" disabled="true">
                                        </div>
                                    </div>
                                </form>
                                <div class="content-footer float-right">
                                    <button class="btn btn-update" id="btn-update-contract">Manage</button>
                                    <button class="btn btn-update hide" id="btn-save-contract">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="batch_list" role="tabpanel" aria-labelledby="recent-case-tab">
                        <div class="tab-content tab-inner px-0 pt-0 ">
                            <div class=" card-sub-title txt-14  col-12" style="background: #f5f6fa;"> Employment Details <span style="color:#ce6787;"> if different from Victim’s Contract </span>
                                <div class="help-tip">
                                    <p>Details that is different on Victim's employment contract.</p>
                                </div>
                            </div>
                            <!-- ---------------------------- -->
                            <div class="inner-form-body p-3">
                                <form id="frm-emp-noncontract">
                                    <div class="row">
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <label> Position / Occupation</label>
                                            <select  class="form-control text-capital sel-occupations emp-act-case_victim_employment_details_job_title" 
                                                     id="sel_emp_act_case_victim_employment_details_job_title">
                                            </select>
                                            <!--<input type="text" class="form-control emp-act-case_victim_employment_details_job_title" maxlength="100" disabled="true">-->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                            <label> Country of Deployment </label>
                                            <select id="emp-sel-actual-country" class="form-control text-capital emp-act-country_id" disabled="true"></select>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6  col-sm-12">
                                            <label> City </label>
                                            <input type="text" class="form-control emp-act-case_victim_employment_city" disabled="true">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-md-4 col-sm-12 form-currency">
                                            <label>Currency</label>
                                            <select id="emp-sel-actual-currency" class="form-control text-capital emp-act-case_victim_employment_details_salary_foreign_iso" disabled="true"> </select>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-4 col-sm-12 form-salary">
                                            <label>Salary per hour</label>
                                            <input type="text" class="form-control decimal emp-act-case_victim_employment_details_salary_in_foreign" disabled="true">
                                        </div>
                                        <div class="form-group col-lg-4 col-md-4  col-sm-12 hide">
                                            <label> Salary per hour in Peso</label>
                                            <input type="text" class="form-control decimal emp-act-case_victim_employment_details_salary_in_local" disabled="true">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                            <label> Days per week</label>
                                            <input type="text" maxlength="1" class="form-control emp-act-case_victim_employment_details_working_days numbersOnly " placeholder=" No. of days / week" disabled="true">
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                            <label> Hours per day</label>
                                            <input type="text" maxlength="2" class="form-control numbersOnly emp-act-case_victim_employment_details_working_hours" placeholder="No. of hours / day" disabled="true">
                                        </div>
                                    </div>
                                </form>
                                <div class="content-footer float-right">
                                    <button class="btn btn-update" id="btn-update-contract-diff">Manage</button>
                                    <button class="btn btn-update hide" id="btn-save-contract-diff">Save</button>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- ================= EMPLOYMENT Details NEW CODE  =============== -->
<!--//-->


<!-- ================= LOCAL Recruitment Details NEW CODE  =============== -->
<div class="form-content mt-5 border ">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class=" card-sub-title txt-W-500 mx-3">Local Recruitment Agency <br>
                <small class="card-desc"> Details of victim's local recruitment agency. </small>
                <hr class="card-sub-title_border">
            </div>
        </div>
    </div>

    <!-- =================== -->
    <form class=""  id="frm-local-rect">
        <div class="row bg-form-grey p-3 mx-3">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="py-2 bg-white">
                    <div class="row px-3">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class=" card-sub-title txt-W-500 " style="color: #e88f15;"> Recruitment Agency's Details </div>
                        </div>
                    </div>
                    <div class=" px-3">
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> 
                                    Agency's Name
                                    <a style="color: #007bff; display: none" class="emp-localrec-change ml-1">change agency</a> 
                                </label>
                                <input type="text" class="form-control emp-local-recruitment_agency_name ignore" name="agency_name" disabled="true" autocomplete="off">
                                <ul class="list-group c-out" style="width: 100%; overflow: scroll; max-height: 300px; display: none" id="ra-local-search"></ul>
                            </div>
                        </div>
                        <!--local_agency_country-->
                        <div class="row ">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12" style="display: none;">
                                <label> Country </label>
                                <select class="form-control emp-local-country_id" disabled="true">
                                    <option value="173" selected>Philippines</option>
                                </select>
                            </div>
                        </div>
                        <div class="row div-agency_local_form">
                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <label> Region </label>
                                <select class="form-control sel-regions emp-local_agency_region" disabled="true">
                                    <option selected="" disabled="">Select Region</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <label> Province </label>
                                <select class="form-control sel-provincesByRegionId emp-local_agency_province" disabled="true"></select>
                            </div>
                        </div>
                        <div class="row div-agency_local_form">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Detailed Address </label>
                                <textarea class="form-control valid noSpcStart emp-local-recruitment_agency_address" rows="4" maxlength="100" aria-invalid="false"disabled="true"></textarea>
                            </div>
                        </div>
                        <div class="row div-agency_local_form">
                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <label> Email Address </label>
                                <input type="text" maxlength="50" class="form-control emp-local-recruitment_agency_email noSpcStart" name="local_recruitment_email" disabled="true">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-12 form-currency">
                                <label>Contact Number</label>
                                <input type="text" maxlength="20" minlength="7" class="form-control numbersOnly noSpcStart emp-local-recruitment_agency_tel_no" name="local_recruitment_phone" disabled="true">
                            </div>
                        </div>
                        <div class="row div-agency_local_form">
                            <div class="form-group col-lg-6 col-md-6 col-sm-12 form-salary">
                                <label> Fax Number </label>
                                <input type="text" maxlength="20" class="form-control emp-local-recruitment_agency_fax_no numbersOnly noSpcStart" disabled="true">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <label> Website </label>
                                <input type="text" maxlength="100" class="form-control emp-local-recruitment_agency_website noSpcStart" disabled="true">
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-lg-8 col-md-6 col-sm-12 form-padding-left bg-white">
                <div class="row ">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class=" card-sub-title txt-W-500"> Other Agency's details
                        </div>
                    </div>
                </div>
                <div class="div-agency_local_form">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

                            <nav class="nav border-bottom nav-inner-tab">
                                <a class="nav-link txt-14 active" data-toggle="tab" href="#owner_details">
                                    Owner's Details
                                </a>
                                <a class="nav-link txt-14" data-toggle="tab" href="#representative_details">
                                    Representative's Details
                                </a>
                                <a class="nav-link txt-14" data-toggle="tab" href="#agent_details">
                                    Agent's Details
                                </a>
                            </nav>
                        </div>
                    </div>
                    <div class="tab-content tab-employment pl-0">
                        <div class="tab-pane fade active show" id="owner_details" role="tabpanel" aria-labelledby="recent-case-tab">
                            <div class="tab-content tab-inner px-0 pt-0 ">
                                <div class="inner-form-body p-3">
                                    <div class="">
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Name </label>
                                                <input type="text" maxlength="50" class="form-control emp-local_agency_owner_name noSpcStart" disabled="true">
                                            </div>
                                        </div>
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Detailed Address </label>
                                                <textarea class="form-control valid noSpcStart emp-local_agency_owner_address" rows="4" maxlength="100" aria-invalid="false" disabled="true"></textarea>
                                            </div>
                                        </div>
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Contact Number </label>
                                                <input type="text" maxlength="20" minlength="7" class="form-control emp-local_agency_owner_contact numbersOnly noSpcStart" disabled="true">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="representative_details" role="tabpanel" aria-labelledby="recent-case-tab">
                            <div class="tab-content tab-inner px-0 pt-0 ">
                                <div class="inner-form-body p-3">
                                    <div class="">
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Name </label>
                                                <input type="text" maxlength="50" class="form-control emp-local_agency_rep_name noSpcStart" disabled="">
                                            </div>
                                        </div>
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label>Detailed Address </label>
                                                <textarea class="form-control valid noSpcStart  emp-local_agency_rep_address" rows="4" maxlength="100" aria-invalid="false" disabled=""></textarea>
                                            </div>
                                        </div>
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Contact Number </label>
                                                <input type="text" class="form-control numbersOnly emp-local_agency_rep_contact" name="local_recruitment_owner_contact" disabled="true">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="agent_details" role="tabpanel" aria-labelledby="recent-case-tab">
                            <div class="tab-content tab-inner px-0 pt-0 ">

                                <div class="inner-form-body p-3">
                                    <div class="">
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Name </label>
                                                <input type="text" maxlength="50" class="form-control emp-local_agency_agent_name noSpcStart" disabled="true">
                                            </div>
                                        </div>
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Address </label>
                                                <textarea class="form-control valid noSpcStart emp-local_agency_agent_address" rows="4" maxlength="100" aria-invalid="false" disabled="true"></textarea>
                                            </div>
                                        </div>
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Contact Number </label>
                                                <input type="text" maxlength="20" minlength="7" class="form-control emp-local_agency_agent_contact numbersOnly noSpcStart" disabled="true">
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
    </form>
    <div class="row p-3 px-5 mx-3 bg-form-grey">
        <div class="col-12">
            <div class="content-footer float-right mt-0">
                <button class="btn btn-update " type="button" id="btn-update-local-rect">Manage</button>
                <button class="btn btn-update hide" type="button" id="btn-save-local-rect">Save</button>
            </div>
        </div>
    </div>
    <!-- =================== -->
</div><!-- ================= LOCAL Recruitment Details NEW CODE  =============== -->
<!--//-->


<!-- ================= FOREIGN Recruitment Details NEW CODE  =============== -->
<!-- 
<div class="form-content mt-5 border">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class=" card-sub-title txt-W-500 mx-3">Foreign Recruitment Agency <br>
                <small class="card-desc"> Details of victim's foreign recruitment agency. </small>
                <hr class="card-sub-title_border">
            </div>
        </div>
    </div>
    <form class=""  id="frm-foreign-rect">
        <div class="row bg-form-grey p-3 mx-3">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="py-2 bg-white">
                    <div class="row px-3">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class=" card-sub-title txt-W-500 " style="color: #e88f15;"> Recruitment Agency's Details
                            </div>
                        </div>
                    </div>
                    <div class=" px-3">
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> 
                                    Agency's Name 
                                    <a style="color: #007bff; display: none" class="emp-foreignrec-change ml-1">change agency</a> 
                                </label>
                                <input type="text" class="form-control emp-foreign-recruitment_agency_name ignore" name="agency_name" disabled="true" autocomplete="off">
                                <ul class="list-group c-out" style="width: 100%; overflow: scroll; max-height: 300px; display: none;" id="ra-foreign-search"></ul> 
                            </div>
                        </div>
                        <div class="row ">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Country </label>
                                <select class="form-control sel-country emp-foreign-country_id" disabled="true"></select>
                            </div>
                        </div>
                        <div class="row div-agency_local_form">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Detailed Address </label>
                                <textarea class="form-control valid noSpcStart emp-foreign-recruitment_agency_address" rows="4" maxlength="100" aria-invalid="false" disabled="true"></textarea>
                            </div>
                        </div>
                        <div class="row div-agency_local_form">
                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <label> Email Address </label>
                                <input type="text" class="form-control emp-foreign-recruitment_agency_email" name="foreign_recruitment_email" disabled="true">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-12 form-currency">
                                <label>Contact Number</label>
                                <input type="text" class="form-control emp-foreign-recruitment_agency_tel_no" name="foreign_recruitment_phone" disabled="true">
                            </div>
                        </div>
                        <div class="row div-agency_local_form">
                            <div class="form-group col-lg-6 col-md-6 col-sm-12 form-salary">
                                <label> Fax Number </label>
                                <input type="text" maxlength="20" class="form-control  emp-foreign-recruitment_agency_fax_no numbersOnly noSpcStart" disabled="true">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <label> Website </label>
                                <input type="text" maxlength="100" class="form-control emp-foreign-recruitment_agency_website noSpcStart" disabled="true">
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-lg-8 col-md-6 col-sm-12 form-padding-left bg-white">
                <div class="row ">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class=" card-sub-title txt-W-500"> Other Agency's details
                        </div>
                    </div>
                </div>
                <div class="div-agency_local_form">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

                            <nav class="nav border-bottom nav-inner-tab">
                                <a class="nav-link txt-14  active " data-toggle="tab" href="#F_owner_details">
                                    Owner's Details

                                </a>
                                <a class="nav-link txt-14" data-toggle="tab" href="#F_representative_details">
                                    Representative's Details
                                </a>
                            </nav>
                        </div>
                    </div>
                    <div class="tab-content tab-employment pl-0">
                        <div class="tab-pane fade active show" id="F_owner_details" role="tabpanel" aria-labelledby="recent-case-tab">
                            <div class="tab-content tab-inner px-0 pt-0 ">
                                <div class="inner-form-body p-3">
                                    <div class="">
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Name </label>
                                                <input type="text" class="form-control emp-foreign-recruitment_agency_owner_name" disabled="true">
                                            </div>
                                        </div>
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Detailed Address </label>
                                                <textarea class="form-control valid noSpcStart  emp-foreign-recruitment_agency_owner_address " rows="4" maxlength="100" aria-invalid="false" disabled="true"></textarea>
                                            </div>
                                        </div>
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Contact Number </label>
                                                <input type="text" class="form-control numbersOnly emp-foreign-recruitment_agency_owner_contact" name="foregin_recruitment_owner_contact" disabled="true">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="F_representative_details" role="tabpanel" aria-labelledby="recent-case-tab">
                            <div class="tab-content tab-inner px-0 pt-0 ">
                                <div class="inner-form-body p-3">
                                    <div class="">
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Name </label>
                                                <input type="text" maxlength="50" class="form-control emp-foreign-recruitment_agency_rep_name noSpcStart" disabled="true">
                                            </div>
                                        </div>
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label>Detailed Address </label>
                                                <textarea class="form-control valid noSpcStart  emp-foreign-recruitment_agency_rep_address" rows="4" maxlength="100" aria-invalid="false" disabled="true"></textarea>
                                            </div>
                                        </div>
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Contact Number </label>
                                                <input type="text" class="form-control numbersOnly emp-foreign-recruitment_agency_rep_contact" name="local_recruitment_owner_contact" disabled="true">
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
    </form>
    <div class="row p-3 px-5 mx-3 bg-form-grey">
        <div class="col-12">
            <div class="content-footer float-right mt-0">
                <button class="btn btn-update" type="button" id="btn-update-foreign-rect">Manage</button>
                <button class="btn btn-update hide" type="button" id="btn-save-foreign-rect">Save</button>
            </div>
        </div>
    </div>
</div>
 -->
<!-- ================= FOREIGN Recruitment Details NEW CODE  =============== -->
<!--//-->


<!-- Update Other Employment Details -->
<!--
<div class="row mt-5 ">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="employment-info-sub_forms">

            <div class=" card-sub-title txt-W-500">Update Other Employment Details<br>
                <small class="card-desc"> Update other employment details </small>
                <hr class="card-sub-title_border">
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-12 col-sm-12">
                    <div class="list-group sub-form-list" id="list-tab" role="tablist">
                        <a class="list-group-item list-group-item-action active" id="list-contact_info" data-toggle="list" href="#tab-deployment_details" role="tab" aria-controls="deployment_details">Deployment Details <span class="float-right hide"> <i class="fa fa-caret-right" aria-hidden="true"></i></span></a>
                        <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#tab-passport_info" role="tab" aria-controls="passport_info">Passport Information <span class="float-right hide"> <i class="fa fa-caret-right" aria-hidden="true"></i></span></a>
                        <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#tab-flight_details" role="tab" aria-controls="flight_details">Transit Details <span class="float-right hide"> <i class="fa fa-caret-right" aria-hidden="true"></i></span></a>
                    </div>
                </div>
                <div class="col-lg-9 col-md-12 col-sm-12">
                    <div class="tab-content tab-sub-info-content" id="nav-tabContent" style=" padding: 17px 20px;">
                        <div class="tab-pane fade show active" id="tab-deployment_details" role="tabpanel" aria-labelledby="list-home-list">
                            <div class=" card-sub-title"> Deployment Details<br>
                                <small class="card-desc"> Additional details of victim's deployment </small>
                                <hr class="card-sub-title_border">
                            </div>
                            <form id="frm-deployment">
                                <div class="fake-info-content padding_15 mgn-B-20">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group form-check">
                                                <input type="checkbox" class="form-check-input emp-deployment_document_is_falsified" id="emp-deployment_document_is_falsified" disabled="true">
                                                <label class="form-check-label " for="emp-deployment_document_is_falsified" style='color: #e88f15 !important;'>Falsified travel document
                                                    <br>
                                                    <small class="card-desc"> Check if the travel documents used by the victim are fake or falsified.  </small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class=" card card_tbl-container ">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                            <label> Departure Type <font color="red"> <b>*</b> </font> </label>
                                                            <select id="emp-sel-departure" disabled class="form-control text-capital emp-case_victim_deployment_type">
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 f-escort_name" style="display: none;">
                                                            <label> Escort Name/s </label>
                                                            <input type="text" maxlength="50" class="form-control emp-deployment_escort_name" disabled="true">
                                                        </div>
                                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 f-escort_description" style="display: none;">
                                                            <label> Escort Description </label>
                                                            <textarea class="form-control noSpcStart emp-deployment_escort_description" maxlength="500" row="30" disabled="true"></textarea>
                                                        </div>
                                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 f-dp_type_others" style="">
                                                            <label> Departure Description </label>
                                                            <textarea class="form-control noSpcStart emp-deployment_remark " maxlength="200" row="30" disabled="true" ></textarea>
                                                        </div>
                                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                            <label> Port of Exit </label>
                                                            <select id="emp-sel-port_of_exit" disabled class="form-control text-capital emp-port_id">
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 hide f-poe_description">
                                                            <label> Port of Exit Description </label>
                                                            <textarea class="form-control  noSpcStart emp-case_victim_deployment_other_port_details" maxlength="200" row="30" disabled="true"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                            <label> Visa Category </label>
                                                            <select id="emp-sel-visa" disabled class="form-control text-capital emp-case_victim_visa_category_id">

                                                            </select>
                                                        </div>
                                                        <div class="form-group col-lg-12 col-md-12 col-sm-12" style="display: none;">
                                                            <label> Country of Destination </label>
                                                            <select id="emp-sel-country-dest" disabled class="form-control text-capital emp-case_victim_deployment_country_destination">
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                            <label> <span class="lbl-emp_deployment_date">Deployment Date </span> <font color="red"> <b>*</b> </font> </label>
                                                            <input type="text" class="form-control  datepicker emp-case_victim_deployment_date" name="case_victim_deployment_date" disabled placeholder="MM/DD/YYYY">
                                                        </div>
                                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 div-deployment_arrival_date">
                                                            <label> Arrival Date </label>
                                                            <input type="text" class="form-control  datepicker emp-case_victim_deployment_arrival_date" name="case_victim_deployment_arrival_date" disabled placeholder="MM/DD/YYYY">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-12">
                                                    <div class="content-footer float-right mt-0">
                                                        <button type="button" class="btn btn-update" id="btn-update-deployment">Manage</button>
                                                        <button type="button"  class="btn btn-update hide" id="btn-save-deployment">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="tab-passport_info" role="tabpanel" aria-labelledby="list-profile-list">
                            <div class=" card-sub-title"> Update Passport Details<br>
                                <small class="card-desc">Update victim's passport details.</small>
                                <hr class="card-sub-title_border">
                            </div>
                            <div class="row form-row">

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="card card_tbl-container">
                                        <form id="frm-passport">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="row">

                                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                            <label> Passport Number </label>
                                                            <input type="text" id="emp-txt-passport" name="ppassport_number" class="form-control emp-victim_passport_number">
                                                        </div>
                                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                            <label> First Name </label>
                                                            <input type="text" id="emp-txt-fname" name="pfname" class="form-control emp-victim_passport_first_name">
                                                        </div>
                                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                            <label> Middle Name </label>
                                                            <input type="text" id="emp-txt-mname" name="pmname" class="form-control emp-victim_passport_middle_name">
                                                        </div>
                                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                            <label> Last Name </label>
                                                            <input type="text" id="emp-txt-lname" name="plname" class="form-control emp-victim_passport_last_name">
                                                        </div>
                                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                            <label> Suffix </label>
                                                            <input type="text" id="emp-txt-suffix" name="plsuffix" class="form-control emp-victim_passport_suffix">
                                                        </div>
                                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                            <label> Sex </label>
                                                            <select id="psel-sex" name="pselsex" class="form-control sel-sex text-capital emp-victim_passport_gender">
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-lg-6 col-md-6 col-sm-12" style="display: none;">
                                                            <label> Civil Status </label>
                                                            <select id="psel-civil" name="pselcivil" class="form-control sel-civil text-capital emp-victim_passport_civil_status">
                                                            </select>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="row">
                                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                            <label> Date of Birth </label>
                                                            <input type="text" name="pdob" class="form-control datepicker emp-victim_passport_dob" placeholder="MM/DD/YYYY">
                                                        </div>
                                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                            <label> Place of Birth (Province) </label>
                                                            <select id="emp-sel-province" name="pselprov" class="form-control text-capital emp-victim_passport_province_pob sel-provinces">
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                            <label> Place of Birth (City)</label>
                                                            <select id="emp-sel-city" name="pselcity" class="form-control text-capital sel-cities emp-victim_passport_city_pob">

                                                            </select>
                                                        </div>
                                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                            <label> Passport place of issued/ released</label>
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text pb-0">DFA</span>
                                                                <input type="text" name="pplaceissued" class="form-control emp-victim_passport_place_issue">
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                            <label> Date issued </label>
                                                            <input type="text" name="pdateissued" class="form-control datepicker emp-victim_passport_date_issued" placeholder="MM/DD/YYYY">
                                                        </div>
                                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                            <label> Passport Expiry </label>
                                                            <input type="text" name="pdateexp" class="form-control datepicker emp-victim_passport_date_expired" placeholder="MM/DD/YYYY">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <div class="content-footer float-right mt-0">
                                                    <button class="btn btn-update" id="btn-update-passport">Manage</button>
                                                    <button class="btn btn-update hide" id="btn-save-passport">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="tab-flight_details" role="tabpanel" aria-labelledby="list-messages-list">
                            <div class=" card-sub-title">Update Transit Details <span class="txt-orange"> (Maximum of 10 entries) </span> <br>
                                <small class="card-desc">Update Victim’s Flight information, including destination, departure and arrival time and additional information. </small>
                                <hr class="card-sub-title_border">
                            </div>
                            <div class="row form-row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="card card_tbl-container">
                                        <div class="card_tbl-action">
                                            <div class="tbl_info card-sub-title">
                                                <span class="">Transit Details List</span>
                                            </div>

                                            <div class='float-right'>
                                                <button type="button" class="btn btn-secondary-light_blue btn-add_layover"><i class="fa fa-plus"></i> Add Transit</button>
                                            </div>
                                        </div>
                                        <table class="table">
                                            <thead class="thead-grey">
                                                <tr>
                                                    <th scope="col">Country</th>
                                                    <th scope="col">City</th>
                                                    <th scope="col">Departure Date</th>
                                                    <th scope="col">Arrival Date</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbl-transit-list">

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
        <hr>
    </div>
</div>
-->


<div class="modal fade" id="modal-transit-country" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title   modal-header_title "> Add Transit Information</h5>
            </div>
            <div class="modal-body">
                <form id="form-add_layover_info" class="col-12" onsubmit="return false;">
                    <div class="col-12">

                        <div class="row">
                            <div class="form-group col-12">
                                <label> Country </label>
                                <select id="emp-sel-Transit-country" class="form-control a-emp-case_victim_transit_departure_country" name="country">

                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label> City </label>
                                <input type="text" class="form-control emp-txt-tansit-city a-emp-case_victim_transit_departure_state" name="city">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label> Arrival Date </label>
                                <input type="text" name="emp_txt_tansit_arrival_date" class="form-control datepicker emp-txt-tansit-arrival-date a-emp-case_victim_transit_arrival_date" placeholder="MM/DD/YYYY">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label> Departure Date </label>
                                <input type="text" name="emp_txt_tansit_depart_date"class="form-control emp-txt-tansit-depart-date datepicker a-emp-case_victim_transit_departure_date" placeholder="MM/DD/YYYY">
                            </div>
                        </div>                        
                        <div class="row">
                            <div class="form-group col-12">
                                <label> Remarks </label>
                                <textarea class="form-control emp-address_complete a-emp-case_victim_transit_remarks" rows="3"></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="content-footer float-right  match-buttons">
                        <button type="button" class="btn btn-cancel btn-modal-cancel mt-0" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary-orange emp-btn-transit-save" style="margin-left:0px;">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="update-modal-transit-country" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title  msgmodal-header modal-header_title "> Update Transit Info</h5>
            </div>
            <div class="modal-body msgmodal-body">
                <form id="form-update_layover_info" class="col-12" onsubmit="return false;">
                    <input type="hidden" class="stored-transit_id">
                    <div class="col-12">

                        <div class="row">
                            <div class="form-group col-12">
                                <label> Country </label>
                                <select class="form-control sel-country u-emp-case_victim_transit_departure_country" name="country">

                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label> City </label>
                                <input type="text" class="form-control emp-txt-tansit-city u-emp-case_victim_transit_departure_state" name="city">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label> Arrival Date </label>
                                <input type="text" name="emp_txt_tansit_arrival_date" class="form-control datepicker emp-txt-tansit-arrival-date u-emp-case_victim_transit_arrival_date" id="date_timepicker_start" placeholder="MM/DD/YYYY">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label> Departure Date </label>
                                <input type="text" name="emp_txt_tansit_depart_date" class="form-control emp-txt-tansit-depart-date datepicker u-emp-case_victim_transit_departure_date" placeholder="MM/DD/YYYY">
                            </div>
                        </div>                       
                        <div class="row">
                            <div class="form-group col-12">
                                <label> Remarks </label>
                                <textarea class="form-control emp-address_complete u-emp-case_victim_transit_remarks" rows="3"></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="content-footer float-right  match-buttons">
                        <button type="button" class="btn btn-cancel btn-modal-cancel mt-0">Close</button>
                        <button type="submit" class="btn btn-primary-orange emp-btn-transit-save" style="margin-left:0px;">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
