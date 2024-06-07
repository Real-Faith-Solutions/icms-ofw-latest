<?php
/**
 * Page Security
 */
defined('BASEPATH') or exit('No direct script access allowed');
?>
<form id="form-add_case" onSubmit="return false;">
    <div class="victim_details_summary ">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class=" card-sub-title txt-W-500"> Victim's details<br>
                    <!--<small class="card-desc"> Summary of victim details. </small>-->
                    <hr class="card-sub-title_border">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 ">
                <div class="padding-l-15">

                    <div class="row">
                        <div class="col-lg-12">
                            <!--<div class="card-sub-title blue" > Personal Information</div>-->
                            <div class="row ">
                                <div class="col-5 summary-lbl">
                                    Victim's Name:
                                </div>
                                <div class="col-7 summary-details ">
                                    <label class="lbl-victim_name"></label>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-5 summary-lbl">
                                    Date of Birth:
                                </div>
                                <div class="col-7 summary-details">
                                    <label class="lbl-victim_dob"></label>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-5 summary-lbl">
                                    Place of Birth:
                                </div>
                                <div class="col-7 summary-details ">
                                    <label class="lbl-victim_pob_value"></label>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-5 summary-lbl">
                                    Sex:
                                </div>
                                <div class="col-7 summary-details">
                                    <label class="lbl-victim_sex_value"></label>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-5 summary-lbl">
                                    Civil Status:
                                </div>
                                <div class="col-7 summary-details">
                                    <label class="lbl-victim_civil_value"></label>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-5 summary-lbl">
                                    Religion:
                                </div>
                                <div class="col-7 summary-details">
                                    <label class="lbl-victim_religion_value"></label>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>


            </div>
            <div class="col-lg-6">
                <div class="fake-info-content bg-transparent">
                    <div class=" card-sub-title mgn-b-5 txt-orange"> Victim's Assumed Information 
                    </div>
                    <div class="fake-info-content_form pt-0">
                        <div class="row ">
                            <div class="col-5 summary-lbl">
                                Name:
                            </div>
                            <div class="col-7 summary-details">
                                <label class="lbl-victim_assumed_name"></label>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-5 summary-lbl">
                                Date of Birth:
                            </div>
                            <div class="col-7 summary-details">
                                <label class="lbl-victim_assumed_dob"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="employment_details_summary mgn-t-35">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class=" card-sub-title txt-W-500"> Employment Details<br>
                    <!--<small class="card-desc"> Summary of employment details. </small>-->
                    <hr class="card-sub-title_border">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="padding-l-15">

                    <div class="row">
                        <div class="col-lg-12">
                            <!--<div class="card-sub-title blue" > Personal Information</div>-->
                            <!--<div class="row ">
                                <div class="col-5 summary-lbl">
                                    Employment type:
                                </div>
                                <div class="col-7 summary-details">
                                    <label class="lbl-emp-employment_type_value"></label>
                                </div>
                            </div>-->
                            <div class="row ">
                                <div class="col-5 summary-lbl">
                                    Employment Position:
                                </div>
                                <div class="col-7 summary-details">
                                    <label class="lbl-emp-position"></label>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-5 summary-lbl">
                                    Place of Deployment:
                                </div>
                                <div class="col-7 summary-details">
                                    <label class="lbl-emp-deployment_place"></label>
                                </div>
                            </div>

                            <div class="fake-info-content bg-transparent">
                                <div class=" card-sub-title mgn-b-5 txt-orange"> Employer's Details </div>
                                <div class="fake-info-content_form pt-0">
                                    <div class="row">
                                        <div class="col-5 summary-lbl">
                                            Name:
                                        </div>
                                        <div class="col-7 summary-details">
                                            <label class="lbl-emp-employer_name"></label>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-5 summary-lbl">
                                            Address:
                                        </div>
                                        <div class="col-7 summary-details">
                                            <label class="lbl-emp-employer_address"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="fake-info-content bg-transparent">
                                <div class=" card-sub-title mgn-b-5 txt-orange"> Local Recruitment Agency's Details </div>
                                <div class="fake-info-content_form pt-0">
                                    <div class="row ">
                                        <div class="col-5 summary-lbl">
                                            Name:
                                        </div>
                                        <div class="col-7 summary-details">
                                            <label class="lbl-emp-local_agency_name"></label>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-5 summary-lbl">
                                            Address:
                                        </div>
                                        <div class="col-7 summary-details">
                                            <label class="lbl-emp-local_agency_address"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="fake-info-content bg-transparent">
                                <div class=" card-sub-title mgn-b-5 txt-orange"> Foreign Recruitment Agency's/Principal Details </div>
                                <div class=" pt-0">
                                    <div class="row ">
                                        <div class="col-5 summary-lbl">
                                            Name:
                                        </div>
                                        <div class="col-7 summary-details">
                                            <label class="lbl-emp-foreign_agency_name"></label>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-5 summary-lbl">
                                            Address:
                                        </div>
                                        <div class="col-7 summary-details">
                                            <label class="lbl-emp-foreign_agency_address"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!--<div class="card-sub-title blue" > Personal Information</div>-->

            </div>
            <div class="col-lg-6">
                <div class="padding-l-15">
                    <div class="fake-info-content bg-transparent">
                        <div class=" card-sub-title mgn-b-5 txt-orange"> 
                            Deployment Details <span id="s-lbl-is_falsified" > (Falsified travel document) </span>
                        </div>
                        <div class="row ">
                            <div class="col-5 summary-lbl">
                                Departure type:
                            </div>
                            <div class="col-7 summary-details">
                                <label class="lbl-emp-deployment_departure_type_value"></label>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-5 summary-lbl">
                                Port of exit:
                            </div>
                            <div class="col-7 summary-details">
                                <label class="lbl-emp-port_of_exit_value"></label>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-5 summary-lbl">
                                Visa Category:
                            </div>
                            <div class="col-7 summary-details">
                                <label class="lbl-emp-deployment_visa_category_value"></label>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-5 summary-lbl">
                                Deployment date:
                            </div>
                            <div class="col-7 summary-details">
                                <label class="lbl-emp-deployment_date"></label>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-5 summary-lbl">
                                Arrival date:
                            </div>
                            <div class="col-7 summary-details">
                                <label class="lbl-emp-deployment_arrival_date"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="case_details_summary mgn-t-35">
        <div class="row">
            <div class="col-12">
                <div class=" card-sub-title txt-W-500"> Incident Details<br>
                    <!--<small class="card-desc"> Summary of incident details. </small>-->
                    <hr class="card-sub-title_border">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10 col-offset-2">
                <div class="fake-info-content bg-transparent">
                    <div class=" card-sub-title mgn-b-5 txt-orange"> Incident Information </div>
                    <div class="fake-info-content_form pt-0">
                        <div class="row ">
                            <div class="col-4 summary-lbl">
                                Acts:
                            </div>
                            <div class="col-8 summary-details">
                                <label class="lbl-case-acts"></label>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-4 summary-lbl">
                                Means:
                            </div>
                            <div class="col-8 summary-details">
                                <label class="lbl-case-means"></label>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-4 summary-lbl">
                                Purpose:
                            </div>
                            <div class="col-8 summary-details">
                                <label class="lbl-case-purposes"></label>
                            </div>
                        </div>
                        <div class="row i-illegal_rec">
                            <div class="col-4 summary-lbl">
                                <i class="fas fa-check-circle text-success i-illegal_rec"></i>
                                Illegal Recruitment
                            </div>
                        </div>
                        <div class="row i-other_law">
                            <div class="col-4 summary-lbl">
                                <i class="fas fa-check-circle text-success i-other_law"></i>
                                Other Law
                            </div>
                        </div>
                        <div class="row lbl-other_law_desc">
                            <div class="col-4 summary-lbl">
                                Other Law Description: 
                            </div>
                            <div class="col-8 summary-details">
                                <label class='txt-justify lbl-case-other_law_desc text-ellipse'></label>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-4 summary-lbl">
                                Brief facts of the Case:
                            </div>
                            <div class="col-8 summary-details">
                                <label class='txt-justify lbl-case-facts text-ellipse'></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-10 col-offset-2">
                <div class="fake-info-content bg-transparent">
                    <div class=" card-sub-title mgn-b-5 txt-orange"> Complainant information
                    </div>
                    <div class="pl-2 m-1">
                        <div class="row ">
                            <div class="col-5 summary-lbl">
                                Date complained:
                            </div>
                            <div class="col-7 summary-details">
                                <label class="lbl-case-date_complained"></label>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-5 summary-lbl">
                                Source:
                            </div>
                            <div class="col-7 summary-details">
                                <label class="lbl-case-complainant_source_value"></label>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-5 summary-lbl">
                                Complainant:
                            </div>
                            <div class="col-7 summary-details">
                                <label class="lbl-case-complainant_name"></label>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-5 summary-lbl">
                                Relationship to victim:
                            </div>
                            <div class="col-7 summary-details">
                                <label class="lbl-case-complainant_relation_value"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="case_details_summary mgn-t-35">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class=" card-sub-title txt-W-500"> Incident Evaluation<br>
                    <!--<small class="card-desc"> Summary of case evaluation. </small>-->
                    <hr class="card-sub-title_border">
                </div>
            </div>
        </div>

        <div class='row'>
            <div class="col-lg-8 col-offset-4">
                <div class="fake-info-content bg-transparent">
                    <div class="row mb-2">
                        <div class="col-4 summary-lbl txt-orange">
                            Case Evaluation
                        </div>
                        <div class="col-8 summary-details">
                            <label class='txt-justify lbl-case-evaluation text-ellipse'></label>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-4 summary-lbl txt-orange">
                            Risk Assessment
                        </div>
                        <div class="col-8 summary-details">
                            <label class='txt-justify lbl-case-risk-assessment text-ellipse'></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-lg-10 col-lg-offset-2'>
                <div class="fake-info-content bg-transparent">
                    <div class=" card-sub-title mgn-b-5 txt-orange"> Victim needs/services
                    </div>
                    <div class="fake-info-content bg-transparent lbl-case-victim_services">
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="priority_summary mgn-t-35">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class=" card-sub-title txt-W-500"> Priority Level<br> 
                    <small class="card-desc"> Set priority level for this case.</small> 
                    <hr class="card-sub-title_border">
                </div>
            </div>
        </div>
        <div class='row'>
            <div class="col-lg-8 col-md-12 col-sm-12">
                <div class="fake-info-content bg-transparent padding-l-15">
                    <div class="row">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="recommendedLevel" id="inlineRadio1" value="3">
                            <label class="form-check-label" for="inlineRadio1">High priority <small class=" icms-text-default ">( should be addressed within one or two work days. )</small></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="recommendedLevel" id="inlineRadio2" value="2">
                            <label class="form-check-label" for="inlineRadio2">Medium priority <small class=" icms-text-default ">( should be addressed between three work days and three weeks. )</small></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="recommendedLevel" id="inlineRadio3" value="1">
                            <label class="form-check-label" for="inlineRadio3">Low priority <small class=" icms-text-default ">( will be addressed, but will likely take more than three weeks. )</small></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-footer float-right  match-buttons">

        <button type="button" class="btn btn-previous_tab return-top" data-tab="case">Previous</button>

        <button type="submit" class="btn btn-primary-orange btn-next btn-next_tab" style="margin-left: 0px; ">Save</button>
    </div>
</form>
