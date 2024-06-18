<!-- #### IACAT ORIGINAL CODE COMMENT START ##### -->

<!-- <?php

defined('BASEPATH') OR exit('No direct script access allowed');
?> -->
<!-- 
<form id="form-update_employment_info" onSubmit="return false;" >
    <input type="hidden" class="vi-session_id">

    <div class="form-content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class=" card-sub-title txt-W-500"> Employment Information<br> 
                    <small class="card-desc"> Indicate both contract and out of contract details. </small> 
                    <hr class="card-sub-title_border">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="fake-info-content padding_15 mgn-B-20 " style="display:block;    background-color: #FFE28C;">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group form-check">
                                <input type="radio" class="form-check-input emp-is_documented" value="1" name="is_employment_documented" id="rdo-documented">
                                <label class="form-check-label employment_documented" for="rdo-documented" style="color:#e88f13 !important;">Regular Victim<br>
                                    <small class="card-desc"> Victim's employment is regular. </small>

                                </label>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group form-check">
                                <input type="radio" class="form-check-input emp-is_documented" value="0" name="is_employment_documented" id="rdo-undocumented">
                                <label class="form-check-label employment_documented" for="rdo-undocumented" style="color:#e88f13 !important;">Irregular Victim<br>
                                    <small class="card-desc"> Victim's employment is irregular. </small>

                                </label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="form-row row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="bg-form-grey py-2">
                    <div class="row px-3">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class=" card-sub-title txt-W-500 " style="color: #e88f15;"> Employer's Details
                            </div>
                        </div>
                    </div>
                    <div class=" px-3">
                        <div class="row ">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Employer's Name </label>
                                <input type="text" maxlength="50" class="form-control emp-employer_name inp_emp-employer_name"  name="inp_emp_employer_name" data-id="0" autocomplete="off">
                                <ul class="list-group c-out" style="width: 100%; overflow: scroll; max-height: 300px; display: none" id="employer-search">                        
                                </ul>
                            </div>
                        </div>
                        <div class="row div-employer_form">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Name of Representative </label>
                                <input type="text" maxlength="50" class="form-control emp-employer_representative">
                            </div>
                        </div>
                        <div class="row div-employer_form">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Contact Number</label>
                                <input type="text" maxlength="20" minlength="7" class="form-control numbersOnly emp-employer_telephone" name="employer_telephone">
                            </div>
                        </div>
                        <div class="row div-employer_form">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Email </label>
                                <input type="text" maxlength="50" class="form-control emp-employer_email" name="employer_email">
                            </div>
                        </div>
                        <div class="row div-employer_form">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Country </label>
                                <select class="form-control text-capital emp-employer_country employers_country">
                                </select>
                            </div>
                        </div>
                        <div class="row div-employer_form">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> City </label>
                                <input type="text" maxlength="50" class="form-control emp-employer_city" name="emp-employer_city">
                            </div>
                        </div>
                        <div class="row div-employer_form">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Detailed Address </label>
                                <textarea class="form-control valid noSpcStart emp-employer_address" rows="4" maxlength="100" aria-invalid="false"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <!--EMPLOYMENT  DETAILS BASED OF CONTRACT -->
            <!-- <div class="col-lg-8 col-md-8 col-sm-12 pl-5">
                <div class="row ">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class=" card-sub-title txt-W-500" > Employment Details
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                            <nav class="nav border-bottom nav-inner-tab">
                                <a class="nav-link txt-14  active " data-toggle="tab" href="#legal_cases"> 
                                    Based on contract   
                                </a>
                                <a class="nav-link txt-14"  data-toggle="tab" href="#batch_list">
                                    Not based on the contract
                                </a>
                            </nav>
                        </div>
                    </div>
                    <div class="tab-content tab-employment pl-0" >
                        <div class="tab-pane fade show active " id="legal_cases" role="tabpanel" aria-labelledby="recent-case-tab">
                            <div class="tab-content tab-inner px-0 pt-0 " >
                                <div class=" card-sub-title txt-14 bg-yellow"> Employment details based on the <span style="color:#0088cc;"> victim’s contract </span>
                                    <div class="help-tip">
                                        <p>Details that are all based on Victim's employment contract.</p>
                                    </div>
                                </div>
                                <div class="inner-form-body py-3">
                                    <div class="row">
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <label>  Position / Occupation</label>
                                            <select id="emp-act_position" class="form-control emp-act_position sel-occupations">
                                            </select> -->
                                            <!-- <input type="text" maxlength="100" class="form-control emp-act_position" id="emp-act_position"> -->
                                        <!-- </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                            <label> Country of Deployment  <font color="red"> <b>*</b> </font> </label>
                                            <select id="emp-sel-eer-country" name="emp_sel_eer_country" class="form-control text-capital emp-act_country">
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6  col-sm-12">
                                            <label>City </label> 
                                            <input type="text" maxlength="50" id="emp-sel-eer-city" class="form-control emp-city" name="emp_sel_eer_city">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-md-4 col-sm-12 form-currency">
                                            <label>Currency</label>
                                            <select id="emp-sel-eer-currency"  class="form-control text-capital emp-currency"></select>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-4 col-sm-12 form-salary">
                                            <label>Salary</label>
                                            <input type="text" maxlength="20" name="emp_act_salary" class="form-control decimal emp-act_salary">
                                        </div>
                                        <div class="form-group col-lg-4 col-md-4  col-sm-12">
                                            <label> Salary in Peso </label>
                                            <input type="text" maxlength="20" name="emp_act_salary_in_peso" class="form-control decimal emp-act_salary_in_peso" id="emp-act_salary">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                            <label> Days per week</label>
                                            <input type="text" maxlength="1" name="emp_act_days_of_work" class="form-control emp-act_days_of_work decimal" placeholder="No. of days / week">
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                            <label> Hours per day</label>
                                            <input type="text" maxlength="2" name="emp_act_working_hours" class="form-control emp-act_working_hours decimal" placeholder="No. of hours / day">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="batch_list" role="tabpanel" aria-labelledby="recent-case-tab"> 
                            <div class="tab-content tab-inner px-0 pt-0 " >
                                <div class=" card-sub-title txt-14 bg-yellow-light" style="background: #f5f6fa;"> Employment Details <span style="color:#ce6787;"> if different from Victim’s Contract </span>
                                    <div class="help-tip">
                                        <p>Details that is different on Victim's employment contract.</p>
                                    </div>
                                </div>
                                <div class="inner-form-body py-3">
                                    <div class="row">
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <label>  Position / Occupation</label>
                                            <select id="emp-position" class="form-control emp-position sel-occupations">
                                            </select> -->
                                            <!-- <input type="text" maxlength="100" class="form-control emp-position" id="emp-position"> -->
                                        <!-- </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                            <label> Country of Deployment </label>
                                            <select id="emp-sel-eet-country" class="form-control text-capital emp-country">
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6  col-sm-12">
                                            <label>Employment City  </label> 
                                            <input type="text" maxlength="50" class="form-control  emp-city" name="emp_city" id="emp-sel-eet-city">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12 form-currency">
                                            <label>Currency</label>
                                            <select id="emp-sel-eet-currency"  class="form-control text-capital emp-currency">
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12 form-salary">
                                            <label>Salary</label>
                                            <input type="text" maxlength="20" class="form-control decimal emp-salary" name="emp_salary" id="emp-salary">
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6  col-sm-12">
                                            <label> Salary in Peso </label>
                                            <input type="text" maxlength="20" class="form-control decimal  emp-salary_in_peso" name="emp_salary_in_peso" id="emp-salary_in_peso">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                            <label> Days per week</label>
                                            <input type="text" maxlength="1" class="form-control emp-days_of_work decimal" id="emp-days_of_work" name="emp_days_of_work" placeholder="No. of working days per week">
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                            <label> Hours per day</label>
                                            <input type="text" maxlength="2" id="emp-working_hours" class="form-control emp-working_hours decimal"  name="emp_working_hours" placeholder="No. of working hours per day">
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->


    <!-- <div class="form-content mt-5">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class=" card-sub-title txt-W-500 " >Local Recruitment Agency <br> 
                    <small class="card-desc"> Details of victim's local recruitment agency. </small> 
                    <hr class="card-sub-title_border">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="bg-form-grey py-2">
                    <div class="row px-3">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class=" card-sub-title txt-W-500 " style="color: #e88f15;"> Recruitment Agency's Details
                            </div>
                        </div>
                    </div>
                    <div class=" px-3">
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Agency's Name</label>
                                <input type="text" maxlength="50" class="form-control emp-local_agency_name" name="inp_emp_local_agency_name" autocomplete="off" data-id="0">
                                <ul class="list-group c-out" style="width: 100%; overflow: scroll; max-height: 300px; display: none" id="ra-local-search">                        
                                </ul>
                            </div>
                        </div> -->
                        <!--local_agency_country-->
                        <!-- <div class="row ">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Country </label>
                                <select class="form-control emp-local_agency_country" disabled><option value="173" selected>Philippines</option></select>
                            </div>
                        </div>
                        <div class="row div-agency_local_form">
                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <label> Region </label>
                                <select class="form-control sel-regions emp-local_agency_region"></select>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <label> Province </label>
                                <select class="form-control sel-provincesByRegionId emp-local_agency_province " disabled></select>
                            </div>
                        </div>
                        <div class="row div-agency_local_form">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Detailed Address </label>
                                <textarea class="form-control valid noSpcStart emp-local_agency_address" rows="4" maxlength="100" aria-invalid="false"></textarea>
                            </div>
                        </div>
                        <div class="row div-agency_local_form">
                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <label> Email Address </label>
                                <input type="text" maxlength="50" class="form-control emp-local_agency_email" name="local_recruitment_email">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-12 form-currency">
                                <label>Contact Number</label>
                                <input type="text" maxlength="20" minlength="7" class="form-control emp-local_agency_telephone numbersOnly" name="local_recruitment_phone">
                            </div>
                        </div>
                        <div class="row div-agency_local_form">
                            <div class="form-group col-lg-6 col-md-6 col-sm-12 form-salary">
                                <label> Fax Number </label>
                                <input type="text" maxlength="20" class="form-control emp-local_agency_fax numbersOnly">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <label> Website </label>
                                <input type="text" maxlength="100" class="form-control emp-local_agency_website">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-12 form-padding-left">
                <div class="row ">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class=" card-sub-title txt-W-500" > Other Agency's Details
                        </div>
                    </div>
                </div>
                <div class="div-agency_local_form">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

                            <nav class="nav border-bottom nav-inner-tab">
                                <a class="nav-link txt-14  active " data-toggle="tab" href="#owner_details"> 
                                    Owner's Details  

                                </a>
                                <a class="nav-link txt-14"  data-toggle="tab" href="#representative_details">
                                    Representative's Details
                                </a>
                                <a class="nav-link txt-14"  data-toggle="tab" href="#agent_details">
                                    Agent's Details
                                </a>
                            </nav>
                        </div>
                    </div>
                    <div class="tab-content tab-employment pl-0" >
                        <div class="tab-pane fade show active " id="owner_details" role="tabpanel" aria-labelledby="recent-case-tab">
                            <div class="tab-content tab-inner px-0 pt-0 " >
                                <div class="inner-form-body py-3">
                                    <div class="">
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Name </label>
                                                <input type="text" maxlength="50" class="form-control emp-local_agency_owner_name">
                                            </div>
                                        </div>
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Detailed Address  </label>
                                                <textarea class="form-control valid noSpcStart emp-local_agency_owner_address" rows="4" maxlength="100" aria-invalid="false"></textarea>
                                            </div>
                                        </div>
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Contact Number </label>
                                                <input type="text" maxlength="20" minlength="7" class="form-control emp-local_agency_owner_contact numbersOnly" name="emp_local_agency_owner_contact">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="representative_details" role="tabpanel" aria-labelledby="recent-case-tab"> 

                            <div class="tab-content tab-inner px-0 pt-0 " >

                                <div class="inner-form-body py-3">
                                    <div class="">


                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Name </label>
                                                <input type="text" maxlength="50" class="form-control emp-local_agency_rep_name">
                                            </div>
                                        </div>
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label>Detailed Address  </label>
                                                <textarea class="form-control valid noSpcStart emp-local_agency_rep_address" rows="4" maxlength="100" aria-invalid="false"></textarea>
                                            </div>
                                        </div>
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Contact Number </label>
                                                <input type="text" maxlength="20" minlength="7" class="form-control emp-local_agency_rep_contact numbersOnly " name="emp_local_agency_rep_contact">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="agent_details" role="tabpanel" aria-labelledby="recent-case-tab"> 
                            <div class="tab-content tab-inner px-0 pt-0 " >

                                <div class="inner-form-body py-3">
                                    <div class="">


                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Name </label>
                                                <input type="text" maxlength="50" class="form-control emp-local_agency_agent_name">
                                            </div>
                                        </div>
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Address  </label>
                                                <textarea class="form-control valid noSpcStart emp-local_agency_agent_address" rows="4" maxlength="100" aria-invalid="false"></textarea>
                                            </div>
                                        </div>
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Contact Number </label>
                                                <input type="text"maxlength="20" minlength="7" class="form-control emp-local_agency_agent_contact numbersOnly " name="emp_local_agency_agent_contact" >
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
    </div> -->
    <!------------------->
    <!-- <div class="form-content mt-5">

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class=" card-sub-title txt-W-500 " >Foreign Recruitment Agency<br> 
                    <small class="card-desc"> Details of victim's foreign recruitment agency. </small> 
                    <hr class="card-sub-title_border">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="bg-form-grey py-2">
                    <div class="row px-3">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class=" card-sub-title txt-W-500 " style="color: #e88f15;"> Recruitment Agency's Details
                            </div>
                        </div>
                    </div>
                    <div class=" px-3">
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">                        
                                <label> Agency's Name</label>
                                <input type="text" maxlength="50" class="form-control emp-foreign_agency_name" name="inp_emp_foreign_agency_name" data-id="0" autocomplete="off">
                                <ul class="list-group c-out" style="width: 100%; overflow: scroll; max-height: 300px; display: none" id="ra-foreign-search">                        
                                </ul>                        
                            </div>
                        </div>
                        <div class="row div-agency_foreign_form">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Country </label>
                                <select class="form-control sel-country emp-foreign_agency_country"></select>
                            </div>
                        </div>
                        <div class="row div-agency_foreign_form">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Detailed Address </label>
                                <textarea class="form-control valid noSpcStart emp-foreign_agency_address" rows="4" maxlength="100" aria-invalid="false"></textarea>
                            </div>
                        </div>
                        <div class="row div-agency_foreign_form">
                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <label> Email Address </label>
                                <input type="text" maxlength="50" class="form-control emp-foreign_agency_email" name="foreign_recruitment_email">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-12 form-currency">
                                <label> Contact Number </label>
                                <input type="text" maxlength="20" minlength="5" class="form-control emp-foreign_agency_telephone numbersOnly " name="foreign_recruitment_phone">
                            </div>
                        </div>
                        <div class="row div-agency_foreign_form">
                            <div class="form-group col-lg-6 col-md-6 col-sm-12 form-salary">
                                <label> Fax Number </label>
                                <input type="text" maxlength="20" class="form-control emp-foreign_agency_fax numbersOnly">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <label> Website </label>
                                <input type="text" maxlength="100" class="form-control emp-foreign_agency_website">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-12 form-padding-left">
                <div class="row ">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class=" card-sub-title txt-W-500" > Other Agency's Details
                        </div>
                    </div>
                </div>
                <div class="div-agency_foreign_form">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

                            <nav class="nav border-bottom nav-inner-tab">
                                <a class="nav-link txt-14  active " data-toggle="tab" href="#F_owner_details"> 
                                    Owner's Details  

                                </a>
                                <a class="nav-link txt-14"  data-toggle="tab" href="#F_representative_details">
                                    Representative's Details
                                </a>
                            </nav>
                        </div>
                    </div>
                    <div class="tab-content tab-employment pl-0" >
                        <div class="tab-pane fade show active " id="F_owner_details" role="tabpanel" aria-labelledby="recent-case-tab">
                            <div class="tab-content tab-inner px-0 pt-0 " >


                                <div class="inner-form-body py-3">
                                    <div class="">
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Name </label>
                                                <input type="text" maxlength="50" class="form-control emp-foreign_agency_owner_name">
                                            </div>
                                        </div>
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label>Detailed Address </label>
                                                <textarea class="form-control valid noSpcStart emp-foreign_agency_owner_address" rows="4" maxlength="100" aria-invalid="false"></textarea>
                                            </div>
                                        </div>
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Contact Number </label>
                                                <input type="text" maxlength="20" class="form-control emp-foreign_agency_owner_contact numbersOnly " name="emp_foreign_agency_owner_contact">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="F_representative_details" role="tabpanel" aria-labelledby="recent-case-tab"> 

                            <div class="tab-content tab-inner px-0 pt-0 " >

                                <div class="inner-form-body py-3">
                                    <div class="">
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Name </label>
                                                <input type="text" maxlength="50" class="form-control emp-foreign_agency_rep_name">
                                            </div>
                                        </div>
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Address </label>
                                                <textarea class="form-control valid noSpcStart emp-foreign_agency_rep_address" rows="4" maxlength="100" aria-invalid="false"></textarea>
                                            </div>
                                        </div>
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Contact Number </label>
                                                <input type="text" maxlength="20" class="form-control emp-foreign_agency_rep_contact numbersOnly " name="emp_foreign_agency_rep_contact">
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
    </div> -->

    <!-- <div class="form-content mt-5 ">
        <div class="employment-info-sub_forms">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class=" card-sub-title txt-W-500 " >Other Employment Details<br> 
                        <small class="card-desc"> You may add other employment details of the report. </small> 
                        <hr class="card-sub-title_border">
                    </div>
                </div>
            </div>


            <div class="row ">
                <div class="col-lg-4 col-md-5 col-sm-12"> 
                    <div class="list-group sub-form-list" id="list-tab" role="tablist">
                        <a class="list-group-item list-group-item-action active" id="list-contact_info" data-toggle="list" href="#tab-deployment_details" role="tab" aria-controls="deployment_details">Deployment Details <span class="float-right hide"> <i class="fa fa-caret-right" aria-hidden="true"></i></span></a>
                        <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#tab-passport_info" role="tab" aria-controls="passport_info">Passport Information <span class="float-right hide"> <i class="fa fa-caret-right" aria-hidden="true"></i></span></a>
                        <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#tab-flight_details" role="tab" aria-controls="flight_details">Transit Details <span class="float-right hide"> <i class="fa fa-caret-right" aria-hidden="true"></i></span></a>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7 col-sm-12">
                    <div class="tab-content tab-sub-info-content px-2" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="tab-deployment_details" role="tabpanel" aria-labelledby="list-home-list">
                            <br><div class=" card-sub-title" > Deployment Details<br> 
                                <small class="card-desc"> Additional details of victim's deployment. </small> 
                                <hr class="card-sub-title_border">
                            </div>
                            <div class="fake-info-content padding_15 mgn-B-20">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">


                                        <div class="form-group form-check">
                                            <input type="checkbox" class="form-check-input emp-deployment_document_is_falsified" id="emp-deployment_document_is_falsified" >
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
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="row">
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                        <label> Departure Type <font color="red"> <b>*</b> </font> </label>
                                                        <select id="emp-sel-departure" name="emp_sel_departure" class="form-control text-capital emp-deployment_departure_type">

                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 f-escort_name" style="display: none;">
                                                        <label> Escort Name/s </label>
                                                        <input type="text" maxlength="50" class="form-control emp-deployment_escort_name" >
                                                    </div>
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 f-escort_description" style="display: none;">
                                                        <label> Escort Description </label>
                                                        <textarea class="form-control noSpcStart emp-deployment_escort_description" maxlength="500" row="30"></textarea>
                                                    </div>
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 f-dp_type_others" style="display: none;">
                                                        <label> Departure Description </label>
                                                        <textarea class="form-control noSpcStart emp-deployment_remark " maxlength="200" row="30"></textarea>
                                                    </div>
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                        <label> Port of Exit </label>
                                                        <select id="emp-sel-port_of_exit" class="form-control text-capital emp-port_of_exit">
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 hide f-poe_description">
                                                        <label> Port of Exit Description </label>
                                                        <textarea class="form-control noSpcStart emp-port_of_exit_description" maxlength="200" row="30"></textarea>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="row">
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                        <label> Visa Category </label>
                                                        <select id="emp-sel-visa" class="form-control text-capital emp-deployment_visa_category">

                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                        <label> Country of Destination </label>
                                                        <select id="emp-sel-country-dest" class="form-control text-capital emp-deployment_country" name="emp-deployment_country">

                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                        <label> <span class="lbl-emp_deployment_date">Deployment Date </span> <font color="red"> <b>*</b> </font> </label>
                                                        <input type="text" class="form-control datepicker emp-deployment_date" name="emp_deployment_date" id="emp_deployment_date" name="emp_deployment_date" placeholder="MM/DD/YYYY" >
                                                    </div>
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 div-deployment_arrival_date"> -->
                                                        <!--<label> Arrival Date <font color="red"> <b>*</b> </font> </label>-->
                                                        <!-- <label> Arrival Date </label>
                                                        <input type="text" class="form-control datepicker emp-deployment_arrival_date" name="emp_deployment_arrival_date"  id="emp_deployment_arrival_date" placeholder="MM/DD/YYYY" >
                                                    </div>                                                   
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-passport_info" role="tabpanel" aria-labelledby="list-profile-list">
                            <br> <div class=" card-sub-title" > Passport Details<br> 
                                <small class="card-desc">Victim's passport details.</small>  
                                <hr class="card-sub-title_border">
                            </div>
                            <div class="fake-info-content padding_15 mgn-B-20">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">


                                        <div class="form-group form-check">
                                            <input type="checkbox" class="form-check-input emp-similar_to_victim" id="emp_similar_to_victim">
                                            <label class="form-check-label employment_documented" for="emp_similar_to_victim" style='color: #e88f15 !important;'>Check if the victim's passport details are similar to victim's personal information.
                                                <br> -->
                                                <!--<small class="card-desc"> Passport details will be auto populated.  </small>-->

                                            <!-- </label>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row form-row">

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="card card_tbl-container">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="row">
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                        <label> Passport Number </label>
                                                        <input type="text" maxlength="50" id=emp-txt-passport" class="form-control emp-passport_no">
                                                    </div>
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                        <label> First Name </label>
                                                        <input type="text" maxlength="50" id="emp-txt-fname" class="form-control emp-passport_first_name">
                                                    </div>
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                        <label> Middle Name </label>
                                                        <input type="text" maxlength="50" id="emp-txt-mname" class="form-control emp-passport_middle_name">
                                                    </div>
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                        <label> Last Name </label>
                                                        <input type="text" maxlength="50" id="emp-txt-lname" class="form-control emp-passport_last_name">
                                                    </div>
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                        <label> Suffix </label>
                                                        <input type="text" maxlength="10" id="emp-txt-suffix" class="form-control emp-passport_suffix">
                                                    </div>
                                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                                        <label> Sex </label>
                                                        <select  class="form-control sel-sex text-capital emp-passport_sex">
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-6 col-md-12 col-sm-12" style="display: none;">
                                                        <label> Civil Status </label>
                                                        <select class="form-control sel-civil text-capital emp-passport_civil"></select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="row">
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                        <label> Date of Birth </label>
                                                        <input type="text" class="form-control datepicker emp-passport_dob" name="emp_passport_dob" placeholder="MM/DD/YYYY" >
                                                    </div>
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                        <label> Place of Birth (Province) </label>
                                                        <select id="emp-sel-province" class="form-control text-capital emp-passport_province">

                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                        <label> Place of Birth (City)</label>
                                                        <select id="emp-sel-city" class="form-control text-capital emp-passport_city">

                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                        <label> Passport place of issued/ released</label>
                                                         <div class="input-group-prepend">
                                                                <span class="input-group-text pb-0">DFA</span>
                                                                <input type="text" maxlength="50" class="form-control emp-passport_place_issue">
                                                         </div>
                                                    </div>
                                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                                        <label> Date issued </label>
                                                        <input type="text" class="form-control datepicker emp-passport_date_issued" id="emp_passport_date_issued" name="emp_passport_date_issued" placeholder="MM/DD/YYYY" >
                                                    </div>
                                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                                        <label> Date Expired </label>
                                                        <input type="text" class="form-control datepicker emp-passport_date_expired" id="emp_passport_date_expired" name="emp_passport_date_expired" placeholder="MM/DD/YYYY" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-flight_details" role="tabpanel" aria-labelledby="list-messages-list">
                            <br><div class=" card-sub-title" > Transit Details <span class="txt-orange"> (Maximum of 10 entries) </span><br> 
                                <small class="card-desc"> Indicate victim's transit details. </small> 
                                <hr class="card-sub-title_border">
                            </div>
                            <div class="row form-row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="card card_tbl-container">
                                        <div class="card_tbl-action">
                                            <div class="tbl_info card-sub-title">
                                                <span class="" >Transit List</span>
                                            </div>
                                            <div class='float-right'>
                                                <button type="button" class="btn btn-secondary-light_blue  btn-add_layover"><i class="fa fa-plus"></i> Add Transit</button>
                                            </div>  </div>
                                        <table class="table">
                                            <thead class="thead-grey row-header-border">
                                                <tr>
                                                    <th scope="col">Country</th>
                                                    <th scope="col">City</th>
                                                    <th scope="col">Arrival Date</th>
                                                    <th scope="col">Departure Date</th>                                                  
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbl-transit-list"></tbody>
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
        <div class="content-footer float-right  match-buttons">
            <button type="button" class="btn btn-previous_tab return-top" data-tab="victims">Previous</button>
            <button type="submit" class="btn btn-primary-orange btn-next " data-tab="case-details-tab1" style="margin-left:0px;">Next</button>
        </div>
    </div>
</form>
 -->

<!--Start Modal Transit--> 

<!-- <div class="modal fade" id="modal-transit-country"  role="dialog" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title  msgmodal-header modal-header_title ">Transit Details</h5>
            </div>
            <div class="modal-body msgmodal-body">
                <form id="form-add_layover_info" class="col-12" onsubmit="return false;">
                    <div class="col-12">

                        <div class="row">
                            <div class="form-group col-12">
                                <label> Country <font color="red">*</font> </label>
                                <select id="emp-sel-Transit-country" name="country" class="form-control">
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label> City </label>
                                <input type="text" maxlength="30" class="form-control emp-txt-tansit-city">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label> Arrival Date </label>
                                <input type="text" class="form-control emp-txt-tansit-arrival-date datepicker " name="emp_txt_tansit_arrival_date" id="date_timepicker_start" placeholder="MM/DD/YYYY">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label> Departure Date </label>
                                <input type="text" class="form-control emp-txt-tansit-depart-date datepicker "  name="emp_txt_tansit_depart_date" id="date_timepicker_end"   placeholder="MM/DD/YYYY">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label> Remarks </label>
                                <textarea class="form-control valid noSpcStart emp-txt-transit-remarks" rows="4" maxlength="100" aria-invalid="false" placeholder="e.g. airline details"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="content-footer float-right  match-buttons">
                        <button type="button" class="btn btn-cancel" data-dismiss="modal" >Close</button>
                        <button type="submit" class="btn btn-secondary-light_blue emp-btn-transit-save" style="margin-left:0px;" >Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> -->

<!--End Modal Transit-->

<!-- #### IACAT ORIGINAL CODE COMMENT END ##### -->




<!--#### OSAEC EMPLOYMENT DETAILS PAGE START ####-->
<?php
/**
 * Page Security
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script type="text/javascript">
    function showIsEmployed(){
        var container = document.getElementById("employment_container");
        var formInfo = document.getElementById("form-update_employment_info");
        //var formUnemployed = document.getElementById("form-update_employment_info_unemployed");

        if(document.getElementById("rdo-employed").checked == true){
            container.style.display = "block";
            var elements = formInfo.elements;
            for (var i = 0, len = elements.length; i < len; ++i) {
                elements[i].disabled = false;
            }
        }else{
            //container.style.display = "none";
            var elements = formInfo.elements;
            for (var i = 0, len = elements.length; i < len; ++i) {
                if(elements[i].nodeName != "BUTTON"){
                    elements[i].disabled = true;
                }
            }
        }
    }
</script>

<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="fake-info-content padding_15 mgn-B-20 " style="display:block;    background-color: #FFE28C;">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group form-check">
                        <input type="radio" class="form-check-input emp-is_employed" value="0" name="is_employment_employed" id="rdo-employed" onchange="showIsEmployed();">
                        <label class="form-check-label employment_employed" for="rdo-employed" style="color:#e88f13 !important;">
                            <small class="card-desc"> EMPLOYED </small>

                        </label>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group form-check">
                        <input type="radio" class="form-check-input emp-is_unemployed" value="1" name="is_employment_employed" id="rdo-unemployed" onchange="showIsEmployed();">
                        <label class="form-check-label employment_unemployed" for="rdo-unemployed" style="color:#e88f13 !important;">
                            <small class="card-desc"> UNEMPLOYED </small>
                        </label>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div id="employment_container">
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <nav class="nav border-bottom nav-inner-tab">
                <a class="nav-link txt-14 active "  data-toggle="tab" href="#employment_local">
                    Local Employment
                </a>
                <!-- ##### OSAEC COMMENT START ##### -->
                <a class="nav-link txt-14" data-toggle="tab" href="#employment_international"> 
                    International Employment   
                </a>
                <!-- ##### OSAEC COMMENT END ##### -->
            </nav>
        </div>
    </div>
    <div class="tab-content tab-employment_main pl-0">
        <div class="tab-pane fade show active" id="employment_local" role="tabpanel" aria-labelledby="recent-case-tab">
            <div class="tab-content tab-inner px-0 pt-0 " >
                <form id="form-update_employment_info" onSubmit="return false;" >
                    <input type="hidden" class="vi-session_id">

                    <div class="form-content">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class=" card-sub-title txt-W-500"> Employment Information<br> 
                                    <small class="card-desc"> Indicate both contract and out of contract details. </small> 
                                    <hr class="card-sub-title_border">

                                    <div>
                                        <div class="inner-form-body py-3">
                                            <div class="row">
                                                <div class="form-group col-lg-6 col-md-6 col-sm-6" style="display: none;">
                                                    <label>  Employed or Unemployed</label>
                                                    <select id="emp-act_employed_unemployed" class="form-control emp-employed_unemployed sel-employed_unemployed">
                                                        <option selected disabled>Select Status</option>
                                                        <option>Employed</option>
                                                        <option>Unemployed</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                                    <label>Type of Employment</label>
                                                    <select id="emp-act_type_of_employment" class="form-control emp-type_of_employment sel-type_of_employment">
                                                        <option selected disabled>Select Employment Type</option>
                                                        <option value="Formal">Formal</option>
                                                        <option value="Informal">Informal</option>
                                                        <option value="Part-time employment">Part-time employment</option>
                                                        <option value="Apprenticeship">Apprenticeship</option>
                                                        <option value="Traineeship">Traineeship</option>
                                                        <option value="Internship">Internship</option>
                                                        <option value="Casual employment">Casual employment</option>
                                                        <option value="Employment on commission">Employment on commission</option>
                                                        <option value="Contract employment">Contract employment</option>
                                                        <option value="Probation"> Probation</option>
                                                        <option value="Seasonal employment">Seasonal employment</option>
                                                        <option value="Leased employment">Leased employment</option>
                                                        <option value="Contingent employment">Contingent employment</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-lg-6 col-md-6 col-sm-12 form-currency">
                                                    <label>Type of Child Cases</label>
                                                    <select id="emp-act_type_of_child_cases" class="form-control emp-type_of_child_cases sel-type_of_child_cases">
                                                        <option selected disabled>Select Type of Case</option>
                                                        <option value="Local Cases">Local Cases</option>
                                                        <option value="International Cases">International Cases</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                                    <label> Region  <font color="red">*</font> </label>
                                                    <select class="form-control sel-regions emp-type_agency_region a-vi-address_region " name="region">
                                                    </select>
                                                </div>
                                                <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                                    <label> Province </label>
                                                    <select class="form-control sel-provincesByRegionId local-type_agency_region a-vi-address_province" name="province" disabled>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                                    <label> City </label>
                                                    <select class="form-control local-type_agency_city sel-cities a-vi-address_city" name="city" disabled>
                                                    </select>
                                                </div>
                                                <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                                    <label> Barangay </label>
                                                    <select class="form-control local-type_agency_barangay sel-barangay a-vi-address_barangay" disabled>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-lg-4 col-md-4 col-sm-12 form-salary">
                                                    <label>Age Started Working</label>
                                                    <input type="text" maxlength="2" name="emp_act_age_started_working" class="form-control number emp-act_age_started_working">
                                                </div>
                                                <div class="form-group col-lg-4 col-md-4 col-sm-12">
                                                    <label> Salary per Hour</label>
                                                    <input type="text" maxlength="20" name="emp_act_salary_per_hour" class="form-control emp-act_salary_per_hour decimal" placeholder="Salary per hour">
                                                </div>
                                                <div class="form-group col-lg-4 col-md-4  col-sm-12">
                                                    <label>Reasons for Employment</label>
                                                    <input type="text" maxlength="20" name="emp_act_reasons_for_employment" class="form-control emp-act_reasons_for_employment">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr/>
                        <div class="content-footer float-right  match-buttons">
                            <button type="button" class="btn btn-previous_tab return-top" data-tab="victims">Previous</button>
                            <button type="submit" class="btn btn-primary-orange btn-next " data-tab="case-details-tab1" style="margin-left:0px;">Next</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="tab-pane fade" id="employment_international" role="tabpanel" aria-labelledby="recent-case-tab">
            <div class="tab-content tab-inner px-0 pt-0 " >
            <form id="form-update_employment_info" onSubmit="return false;" >
    <input type="hidden" class="vi-session_id">

    <div class="form-content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class=" card-sub-title txt-W-500"> Employment Information<br> 
                    <small class="card-desc"> Indicate both contract and out of contract details. </small> 
                    <hr class="card-sub-title_border">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="fake-info-content padding_15 mgn-B-20 " style="display:block;    background-color: #FFE28C;">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group form-check">
                                <input type="radio" class="form-check-input emp-is_documented" value="1" name="is_employment_documented" id="rdo-documented">
                                <label class="form-check-label employment_documented" for="rdo-documented" style="color:#e88f13 !important;">Regular Victim<br>
                                    <small class="card-desc"> Victim's employment is regular. </small>

                                </label>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group form-check">
                                <input type="radio" class="form-check-input emp-is_documented" value="0" name="is_employment_documented" id="rdo-undocumented">
                                <label class="form-check-label employment_documented" for="rdo-undocumented" style="color:#e88f13 !important;">Irregular Victim<br>
                                    <small class="card-desc"> Victim's employment is irregular. </small>

                                </label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="form-row row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="bg-form-grey py-2">
                    <div class="row px-3">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class=" card-sub-title txt-W-500 " style="color: #e88f15;"> Employer's Details
                            </div>
                        </div>
                    </div>
                    <div class=" px-3">
                        <div class="row ">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Employer's Name </label>
                                <input type="text" maxlength="50" class="form-control emp-employer_name inp_emp-employer_name"  name="inp_emp_employer_name" data-id="0" autocomplete="off">
                                <ul class="list-group c-out" style="width: 100%; overflow: scroll; max-height: 300px; display: none" id="employer-search">                        
                                </ul>
                            </div>
                        </div>
                        <div class="row div-employer_form">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Name of Representative </label>
                                <input type="text" maxlength="50" class="form-control emp-employer_representative">
                            </div>
                        </div>
                        <div class="row div-employer_form">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Contact Number</label>
                                <input type="text" maxlength="20" minlength="7" class="form-control numbersOnly emp-employer_telephone" name="employer_telephone">
                            </div>
                        </div>
                        <div class="row div-employer_form">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Email </label>
                                <input type="text" maxlength="50" class="form-control emp-employer_email" name="employer_email">
                            </div>
                        </div>
                        <div class="row div-employer_form">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Country </label>
                                <select class="form-control text-capital emp-employer_country employers_country">
                                </select>
                            </div>
                        </div>
                        <div class="row div-employer_form">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> City </label>
                                <input type="text" maxlength="50" class="form-control emp-employer_city" name="emp-employer_city">
                            </div>
                        </div>
                        <div class="row div-employer_form">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Detailed Address </label>
                                <textarea class="form-control valid noSpcStart emp-employer_address" rows="4" maxlength="100" aria-invalid="false"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--EMPLOYMENT  DETAILS BASED OF CONTRACT -->
            <div class="col-lg-8 col-md-8 col-sm-12 pl-5">
                <div class="row ">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class=" card-sub-title txt-W-500" > Employment Details
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                            <nav class="nav border-bottom nav-inner-tab">
                                <a class="nav-link txt-14  active " data-toggle="tab" href="#legal_cases"> 
                                    Based on contract   
                                </a>
                                <a class="nav-link txt-14"  data-toggle="tab" href="#batch_list">
                                    Not based on the contract
                                </a>
                            </nav>
                        </div>
                    </div>
                    <div class="tab-content tab-employment pl-0" >
                        <div class="tab-pane fade show active " id="legal_cases" role="tabpanel" aria-labelledby="recent-case-tab">
                            <div class="tab-content tab-inner px-0 pt-0 " >
                                <div class=" card-sub-title txt-14 bg-yellow"> Employment details based on the <span style="color:#0088cc;"> victim’s contract </span>
                                    <div class="help-tip">
                                        <p>Details that are all based on Victim's employment contract.</p>
                                    </div>
                                </div>
                                <div class="inner-form-body py-3">
                                    <div class="row">
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <label>  Position / Occupation</label>
                                            <select id="emp-act_position" class="form-control emp-act_position sel-occupations">
                                            </select>
                                            <!--<input type="text" maxlength="100" class="form-control emp-act_position" id="emp-act_position">-->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                            <label> Country of Deployment  <font color="red"> <b>*</b> </font> </label>
                                            <select id="emp-sel-eer-country" name="emp_sel_eer_country" class="form-control text-capital emp-act_country">
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6  col-sm-12">
                                            <label>City </label> 
                                            <input type="text" maxlength="50" id="emp-sel-eer-city" class="form-control emp-city" name="emp_sel_eer_city">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-md-4 col-sm-12 form-currency">
                                            <label>Currency</label>
                                            <select id="emp-sel-eer-currency"  class="form-control text-capital emp-currency"></select>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-4 col-sm-12 form-salary">
                                            <label>Salary</label>
                                            <input type="text" maxlength="20" name="emp_act_salary" class="form-control decimal emp-act_salary">
                                        </div>
                                        <div class="form-group col-lg-4 col-md-4  col-sm-12">
                                            <label> Salary in Peso </label>
                                            <input type="text" maxlength="20" name="emp_act_salary_in_peso" class="form-control decimal emp-act_salary_in_peso" id="emp-act_salary">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                            <label> Days per week</label>
                                            <input type="text" maxlength="1" name="emp_act_days_of_work" class="form-control emp-act_days_of_work decimal" placeholder="No. of days / week">
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                            <label> Hours per day</label>
                                            <input type="text" maxlength="2" name="emp_act_working_hours" class="form-control emp-act_working_hours decimal" placeholder="No. of hours / day">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="batch_list" role="tabpanel" aria-labelledby="recent-case-tab"> 
                            <div class="tab-content tab-inner px-0 pt-0 " >
                                <div class=" card-sub-title txt-14 bg-yellow-light" style="background: #f5f6fa;"> Employment Details <span style="color:#ce6787;"> if different from Victim’s Contract </span>
                                    <div class="help-tip">
                                        <p>Details that is different on Victim's employment contract.</p>
                                    </div>
                                </div>
                                <div class="inner-form-body py-3">
                                    <div class="row">
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <label>  Position / Occupation</label>
                                            <select id="emp-position" class="form-control emp-position sel-occupations">
                                            </select>
                                            <!--<input type="text" maxlength="100" class="form-control emp-position" id="emp-position">-->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                            <label> Country of Deployment </label>
                                            <select id="emp-sel-eet-country" class="form-control text-capital emp-country">
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6  col-sm-12">
                                            <label>Employment City  </label> 
                                            <input type="text" maxlength="50" class="form-control  emp-city" name="emp_city" id="emp-sel-eet-city">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12 form-currency">
                                            <label>Currency</label>
                                            <select id="emp-sel-eet-currency"  class="form-control text-capital emp-currency">
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12 form-salary">
                                            <label>Salary</label>
                                            <input type="text" maxlength="20" class="form-control decimal emp-salary" name="emp_salary" id="emp-salary">
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6  col-sm-12">
                                            <label> Salary in Peso </label>
                                            <input type="text" maxlength="20" class="form-control decimal  emp-salary_in_peso" name="emp_salary_in_peso" id="emp-salary_in_peso">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                            <label> Days per week</label>
                                            <input type="text" maxlength="1" class="form-control emp-days_of_work decimal" id="emp-days_of_work" name="emp_days_of_work" placeholder="No. of working days per week">
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                            <label> Hours per day</label>
                                            <input type="text" maxlength="2" id="emp-working_hours" class="form-control emp-working_hours decimal"  name="emp_working_hours" placeholder="No. of working hours per day">
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


    <div class="form-content mt-5">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class=" card-sub-title txt-W-500 " >Local Recruitment Agency <br> 
                    <small class="card-desc"> Details of victim's local recruitment agency. </small> 
                    <hr class="card-sub-title_border">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="bg-form-grey py-2">
                    <div class="row px-3">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class=" card-sub-title txt-W-500 " style="color: #e88f15;"> Recruitment Agency's Details
                            </div>
                        </div>
                    </div>
                    <div class=" px-3">
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Agency's Name</label>
                                <input type="text" maxlength="50" class="form-control emp-local_agency_name" name="inp_emp_local_agency_name" autocomplete="off" data-id="0">
                                <ul class="list-group c-out" style="width: 100%; overflow: scroll; max-height: 300px; display: none" id="ra-local-search">                        
                                </ul>
                            </div>
                        </div>
                        <!--local_agency_country-->
                        <div class="row ">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Country </label>
                                <select class="form-control emp-local_agency_country" disabled><option value="173" selected>Philippines</option></select>
                            </div>
                        </div>
                        <div class="row div-agency_local_form">
                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <label> Region </label>
                                <select class="form-control sel-regions emp-local_agency_region"></select>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <label> Province </label>
                                <select class="form-control sel-provincesByRegionId emp-local_agency_province " disabled></select>
                            </div>
                        </div>
                        <div class="row div-agency_local_form">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Detailed Address </label>
                                <textarea class="form-control valid noSpcStart emp-local_agency_address" rows="4" maxlength="100" aria-invalid="false"></textarea>
                            </div>
                        </div>
                        <div class="row div-agency_local_form">
                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <label> Email Address </label>
                                <input type="text" maxlength="50" class="form-control emp-local_agency_email" name="local_recruitment_email">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-12 form-currency">
                                <label>Contact Number</label>
                                <input type="text" maxlength="20" minlength="7" class="form-control emp-local_agency_telephone numbersOnly" name="local_recruitment_phone">
                            </div>
                        </div>
                        <div class="row div-agency_local_form">
                            <div class="form-group col-lg-6 col-md-6 col-sm-12 form-salary">
                                <label> Fax Number </label>
                                <input type="text" maxlength="20" class="form-control emp-local_agency_fax numbersOnly">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <label> Website </label>
                                <input type="text" maxlength="100" class="form-control emp-local_agency_website">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-12 form-padding-left">
                <div class="row ">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class=" card-sub-title txt-W-500" > Other Agency's Details
                        </div>
                    </div>
                </div>
                <div class="div-agency_local_form">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

                            <nav class="nav border-bottom nav-inner-tab">
                                <a class="nav-link txt-14  active " data-toggle="tab" href="#owner_details"> 
                                    Owner's Details  

                                </a>
                                <a class="nav-link txt-14"  data-toggle="tab" href="#representative_details">
                                    Representative's Details
                                </a>
                                <a class="nav-link txt-14"  data-toggle="tab" href="#agent_details">
                                    Agent's Details
                                </a>
                            </nav>
                        </div>
                    </div>
                    <div class="tab-content tab-employment pl-0" >
                        <div class="tab-pane fade show active " id="owner_details" role="tabpanel" aria-labelledby="recent-case-tab">
                            <div class="tab-content tab-inner px-0 pt-0 " >
                                <div class="inner-form-body py-3">
                                    <div class="">
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Name </label>
                                                <input type="text" maxlength="50" class="form-control emp-local_agency_owner_name">
                                            </div>
                                        </div>
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Detailed Address  </label>
                                                <textarea class="form-control valid noSpcStart emp-local_agency_owner_address" rows="4" maxlength="100" aria-invalid="false"></textarea>
                                            </div>
                                        </div>
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Contact Number </label>
                                                <input type="text" maxlength="20" minlength="7" class="form-control emp-local_agency_owner_contact numbersOnly" name="emp_local_agency_owner_contact">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="representative_details" role="tabpanel" aria-labelledby="recent-case-tab"> 

                            <div class="tab-content tab-inner px-0 pt-0 " >

                                <div class="inner-form-body py-3">
                                    <div class="">


                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Name </label>
                                                <input type="text" maxlength="50" class="form-control emp-local_agency_rep_name">
                                            </div>
                                        </div>
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label>Detailed Address  </label>
                                                <textarea class="form-control valid noSpcStart emp-local_agency_rep_address" rows="4" maxlength="100" aria-invalid="false"></textarea>
                                            </div>
                                        </div>
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Contact Number </label>
                                                <input type="text" maxlength="20" minlength="7" class="form-control emp-local_agency_rep_contact numbersOnly " name="emp_local_agency_rep_contact">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="agent_details" role="tabpanel" aria-labelledby="recent-case-tab"> 
                            <div class="tab-content tab-inner px-0 pt-0 " >

                                <div class="inner-form-body py-3">
                                    <div class="">


                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Name </label>
                                                <input type="text" maxlength="50" class="form-control emp-local_agency_agent_name">
                                            </div>
                                        </div>
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Address  </label>
                                                <textarea class="form-control valid noSpcStart emp-local_agency_agent_address" rows="4" maxlength="100" aria-invalid="false"></textarea>
                                            </div>
                                        </div>
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Contact Number </label>
                                                <input type="text"maxlength="20" minlength="7" class="form-control emp-local_agency_agent_contact numbersOnly " name="emp_local_agency_agent_contact" >
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
    </div>
    <!------------------->
    <div class="form-content mt-5">

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class=" card-sub-title txt-W-500 " >Foreign Recruitment Agency<br> 
                    <small class="card-desc"> Details of victim's foreign recruitment agency. </small> 
                    <hr class="card-sub-title_border">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="bg-form-grey py-2">
                    <div class="row px-3">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class=" card-sub-title txt-W-500 " style="color: #e88f15;"> Recruitment Agency's Details
                            </div>
                        </div>
                    </div>
                    <div class=" px-3">
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">                        
                                <label> Agency's Name</label>
                                <input type="text" maxlength="50" class="form-control emp-foreign_agency_name" name="inp_emp_foreign_agency_name" data-id="0" autocomplete="off">
                                <ul class="list-group c-out" style="width: 100%; overflow: scroll; max-height: 300px; display: none" id="ra-foreign-search">                        
                                </ul>                        
                            </div>
                        </div>
                        <div class="row div-agency_foreign_form">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Country </label>
                                <select class="form-control sel-country emp-foreign_agency_country"></select>
                            </div>
                        </div>
                        <div class="row div-agency_foreign_form">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Detailed Address </label>
                                <textarea class="form-control valid noSpcStart emp-foreign_agency_address" rows="4" maxlength="100" aria-invalid="false"></textarea>
                            </div>
                        </div>
                        <div class="row div-agency_foreign_form">
                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <label> Email Address </label>
                                <input type="text" maxlength="50" class="form-control emp-foreign_agency_email" name="foreign_recruitment_email">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-12 form-currency">
                                <label> Contact Number </label>
                                <input type="text" maxlength="20" minlength="5" class="form-control emp-foreign_agency_telephone numbersOnly " name="foreign_recruitment_phone">
                            </div>
                        </div>
                        <div class="row div-agency_foreign_form">
                            <div class="form-group col-lg-6 col-md-6 col-sm-12 form-salary">
                                <label> Fax Number </label>
                                <input type="text" maxlength="20" class="form-control emp-foreign_agency_fax numbersOnly">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <label> Website </label>
                                <input type="text" maxlength="100" class="form-control emp-foreign_agency_website">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-12 form-padding-left">
                <div class="row ">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class=" card-sub-title txt-W-500" > Other Agency's Details
                        </div>
                    </div>
                </div>
                <div class="div-agency_foreign_form">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

                            <nav class="nav border-bottom nav-inner-tab">
                                <a class="nav-link txt-14  active " data-toggle="tab" href="#F_owner_details"> 
                                    Owner's Details  

                                </a>
                                <a class="nav-link txt-14"  data-toggle="tab" href="#F_representative_details">
                                    Representative's Details
                                </a>
                            </nav>
                        </div>
                    </div>
                    <div class="tab-content tab-employment pl-0" >
                        <div class="tab-pane fade show active " id="F_owner_details" role="tabpanel" aria-labelledby="recent-case-tab">
                            <div class="tab-content tab-inner px-0 pt-0 " >


                                <div class="inner-form-body py-3">
                                    <div class="">
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Name </label>
                                                <input type="text" maxlength="50" class="form-control emp-foreign_agency_owner_name">
                                            </div>
                                        </div>
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label>Detailed Address </label>
                                                <textarea class="form-control valid noSpcStart emp-foreign_agency_owner_address" rows="4" maxlength="100" aria-invalid="false"></textarea>
                                            </div>
                                        </div>
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Contact Number </label>
                                                <input type="text" maxlength="20" class="form-control emp-foreign_agency_owner_contact numbersOnly " name="emp_foreign_agency_owner_contact">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="F_representative_details" role="tabpanel" aria-labelledby="recent-case-tab"> 

                            <div class="tab-content tab-inner px-0 pt-0 " >

                                <div class="inner-form-body py-3">
                                    <div class="">
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Name </label>
                                                <input type="text" maxlength="50" class="form-control emp-foreign_agency_rep_name">
                                            </div>
                                        </div>
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Address </label>
                                                <textarea class="form-control valid noSpcStart emp-foreign_agency_rep_address" rows="4" maxlength="100" aria-invalid="false"></textarea>
                                            </div>
                                        </div>
                                        <div class="row  ">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label> Contact Number </label>
                                                <input type="text" maxlength="20" class="form-control emp-foreign_agency_rep_contact numbersOnly " name="emp_foreign_agency_rep_contact">
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
    </div>

    <div class="form-content mt-5 ">
        <div class="employment-info-sub_forms">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class=" card-sub-title txt-W-500 " >Other Employment Details<br> 
                        <small class="card-desc"> You may add other employment details of the report. </small> 
                        <hr class="card-sub-title_border">
                    </div>
                </div>
            </div>


            <div class="row ">
                <div class="col-lg-4 col-md-5 col-sm-12"> 
                    <div class="list-group sub-form-list" id="list-tab" role="tablist">
                        <a class="list-group-item list-group-item-action active" id="list-contact_info" data-toggle="list" href="#tab-deployment_details" role="tab" aria-controls="deployment_details">Deployment Details <span class="float-right hide"> <i class="fa fa-caret-right" aria-hidden="true"></i></span></a>
                        <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#tab-passport_info" role="tab" aria-controls="passport_info">Passport Information <span class="float-right hide"> <i class="fa fa-caret-right" aria-hidden="true"></i></span></a>
                        <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#tab-flight_details" role="tab" aria-controls="flight_details">Transit Details <span class="float-right hide"> <i class="fa fa-caret-right" aria-hidden="true"></i></span></a>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7 col-sm-12">
                    <div class="tab-content tab-sub-info-content px-2" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="tab-deployment_details" role="tabpanel" aria-labelledby="list-home-list">
                            <br><div class=" card-sub-title" > Deployment Details<br> 
                                <small class="card-desc"> Additional details of victim's deployment. </small> 
                                <hr class="card-sub-title_border">
                            </div>
                            <div class="fake-info-content padding_15 mgn-B-20">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">


                                        <div class="form-group form-check">
                                            <input type="checkbox" class="form-check-input emp-deployment_document_is_falsified" id="emp-deployment_document_is_falsified" >
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
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="row">
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                        <label> Departure Type <font color="red"> <b>*</b> </font> </label>
                                                        <select id="emp-sel-departure" name="emp_sel_departure" class="form-control text-capital emp-deployment_departure_type">

                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 f-escort_name" style="display: none;">
                                                        <label> Escort Name/s </label>
                                                        <input type="text" maxlength="50" class="form-control emp-deployment_escort_name" >
                                                    </div>
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 f-escort_description" style="display: none;">
                                                        <label> Escort Description </label>
                                                        <textarea class="form-control noSpcStart emp-deployment_escort_description" maxlength="500" row="30"></textarea>
                                                    </div>
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 f-dp_type_others" style="display: none;">
                                                        <label> Departure Description </label>
                                                        <textarea class="form-control noSpcStart emp-deployment_remark " maxlength="200" row="30"></textarea>
                                                    </div>
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                        <label> Port of Exit </label>
                                                        <select id="emp-sel-port_of_exit" class="form-control text-capital emp-port_of_exit">
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 hide f-poe_description">
                                                        <label> Port of Exit Description </label>
                                                        <textarea class="form-control noSpcStart emp-port_of_exit_description" maxlength="200" row="30"></textarea>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="row">
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                        <label> Visa Category </label>
                                                        <select id="emp-sel-visa" class="form-control text-capital emp-deployment_visa_category">

                                                        </select>
                                                    </div>
                                                    <!--                                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                                                                                <label> Country of Destination </label>
                                                                                                                <select id="emp-sel-country-dest" class="form-control text-capital emp-deployment_country">
                                                    
                                                                                                                </select>
                                                                                                            </div>-->
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                        <label> <span class="lbl-emp_deployment_date">Deployment Date </span> <font color="red"> <b>*</b> </font> </label>
                                                        <input type="text" class="form-control datepicker emp-deployment_date" name="emp_deployment_date" id="emp_deployment_date" name="emp_deployment_date" placeholder="MM/DD/YYYY" >
                                                    </div>
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 div-deployment_arrival_date">
                                                         <!--<label> Arrival Date <font color="red"> <b>*</b> </font> </label>-->
                                                        <label> Arrival Date </label>
                                                        <input type="text" class="form-control datepicker emp-deployment_arrival_date" name="emp_deployment_arrival_date"  id="emp_deployment_arrival_date" placeholder="MM/DD/YYYY" >
                                                    </div>                                                   
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-passport_info" role="tabpanel" aria-labelledby="list-profile-list">
                            <br> <div class=" card-sub-title" > Passport Details<br> 
                                <small class="card-desc">Victim's passport details.</small>  
                                <hr class="card-sub-title_border">
                            </div>
                            <div class="fake-info-content padding_15 mgn-B-20">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">


                                        <div class="form-group form-check">
                                            <input type="checkbox" class="form-check-input emp-similar_to_victim" id="emp_similar_to_victim">
                                            <label class="form-check-label employment_documented" for="emp_similar_to_victim" style='color: #e88f15 !important;'>Check if the victim's passport details are similar to victim's personal information.
                                                <br>
                                                <!--<small class="card-desc"> Passport details will be auto populated.  </small>-->

                                            </label>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row form-row">

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="card card_tbl-container">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="row">
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                        <label> Passport Number </label>
                                                        <input type="text" maxlength="50" id=emp-txt-passport" class="form-control emp-passport_no">
                                                    </div>
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                        <label> First Name </label>
                                                        <input type="text" maxlength="50" id="emp-txt-fname" class="form-control emp-passport_first_name">
                                                    </div>
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                        <label> Middle Name </label>
                                                        <input type="text" maxlength="50" id="emp-txt-mname" class="form-control emp-passport_middle_name">
                                                    </div>
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                        <label> Last Name </label>
                                                        <input type="text" maxlength="50" id="emp-txt-lname" class="form-control emp-passport_last_name">
                                                    </div>
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                        <label> Suffix </label>
                                                        <input type="text" maxlength="10" id="emp-txt-suffix" class="form-control emp-passport_suffix">
                                                    </div>
                                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                                        <label> Sex </label>
                                                        <select  class="form-control sel-sex text-capital emp-passport_sex">
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-6 col-md-12 col-sm-12" style="display: none;">
                                                        <label> Civil Status </label>
                                                        <select class="form-control sel-civil text-capital emp-passport_civil"></select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="row">
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                        <label> Date of Birth </label>
                                                        <input type="text" class="form-control datepicker emp-passport_dob" name="emp_passport_dob" placeholder="MM/DD/YYYY" >
                                                    </div>
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                        <label> Place of Birth (Province) </label>
                                                        <select id="emp-sel-province" class="form-control text-capital emp-passport_province">

                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                        <label> Place of Birth (City)</label>
                                                        <select id="emp-sel-city" class="form-control text-capital emp-passport_city">

                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                        <label> Passport place of issued/ released</label>
                                                         <div class="input-group-prepend">
                                                                <span class="input-group-text pb-0">DFA</span>
                                                                <input type="text" maxlength="50" class="form-control emp-passport_place_issue">
                                                         </div>
                                                    </div>
                                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                                        <label> Date issued </label>
                                                        <input type="text" class="form-control datepicker emp-passport_date_issued" id="emp_passport_date_issued" name="emp_passport_date_issued" placeholder="MM/DD/YYYY" >
                                                    </div>
                                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                                        <label> Date Expired </label>
                                                        <input type="text" class="form-control datepicker emp-passport_date_expired" id="emp_passport_date_expired" name="emp_passport_date_expired" placeholder="MM/DD/YYYY" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-flight_details" role="tabpanel" aria-labelledby="list-messages-list">
                            <br><div class=" card-sub-title" > Transit Details <span class="txt-orange"> (Maximum of 10 entries) </span><br> 
                                <small class="card-desc"> Indicate victim's transit details. </small> 
                                <hr class="card-sub-title_border">
                            </div>
                            <div class="row form-row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="card card_tbl-container">
                                        <div class="card_tbl-action">
                                            <div class="tbl_info card-sub-title">
                                                <span class="" >Transit List</span>
                                            </div>
                                            <div class='float-right'>
                                                <button type="button" class="btn btn-secondary-light_blue  btn-add_layover"><i class="fa fa-plus"></i> Add Transit</button>
                                            </div>  </div>
                                        <table class="table">
                                            <thead class="thead-grey row-header-border">
                                                <tr>
                                                    <th scope="col">Country</th>
                                                    <th scope="col">City</th>
                                                    <th scope="col">Arrival Date</th>
                                                    <th scope="col">Departure Date</th>                                                  
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbl-transit-list"></tbody>
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
        <div class="content-footer float-right  match-buttons">
            <button type="button" class="btn btn-previous_tab return-top" data-tab="victims">Previous</button>
            <button type="submit" class="btn btn-primary-orange btn-next " data-tab="case-details-tab1" style="margin-left:0px;">Next</button>
        </div>
    </div>
</form>
            </div>
        </div>
    </div>
</div>

<!--Start Modal Transit--> 

<div class="modal fade" id="modal-transit-country"  role="dialog" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title  msgmodal-header modal-header_title ">Transit Details</h5>
            </div>
            <div class="modal-body msgmodal-body">
                <form id="form-add_layover_info" class="col-12" onsubmit="return false;">
                    <div class="col-12">

                        <div class="row">
                            <div class="form-group col-12">
                                <label> Country <font color="red">*</font> </label>
                                <select id="emp-sel-Transit-country" name="country" class="form-control">
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label> City </label>
                                <input type="text" maxlength="30" class="form-control emp-txt-tansit-city">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label> Arrival Date </label>
                                <input type="text" class="form-control emp-txt-tansit-arrival-date datepicker " name="emp_txt_tansit_arrival_date" id="date_timepicker_start" placeholder="MM/DD/YYYY">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label> Departure Date </label>
                                <input type="text" class="form-control emp-txt-tansit-depart-date datepicker "  name="emp_txt_tansit_depart_date" id="date_timepicker_end"   placeholder="MM/DD/YYYY">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label> Remarks </label>
                                <textarea class="form-control valid noSpcStart emp-txt-transit-remarks" rows="4" maxlength="100" aria-invalid="false" placeholder="e.g. airline details"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="content-footer float-right  match-buttons">
                        <button type="button" class="btn btn-cancel" data-dismiss="modal" >Close</button>
                        <button type="submit" class="btn btn-secondary-light_blue emp-btn-transit-save" style="margin-left:0px;" >Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--End Modal Transit-->


<!--#### OSAEC EMPLOYMENT DETAILS PAGE END ####-->
