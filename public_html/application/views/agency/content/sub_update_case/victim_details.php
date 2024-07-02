<?php
/**
 * Page Security
 */
defined('BASEPATH') or exit('No direct script access allowed');
?>

<input type="hidden" id="victim_id">

<div class="form-content">
    <div class="row mb-5">
        <div class="col-lg-8 col-md-6 col-sm-12">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class=" card-sub-title txt-W-500"> Personal Information<br>
                        <small class="card-desc"> Victim's personal information. </small>
                    </div>
                </div>
            </div>

            <form id="frm-personal">
                <div class="form-row mgn-L-15">
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="row">
                            <div class="form-group col-12">
                                <label>First Name <font color="red">*</font> </label>
                                <input type="text" class="form-control vi-victim_info_first_name" name="first_name" maxlength="50">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label>Middle Name </label>
                                <input type="text" class="form-control vi-victim_info_middle_name" maxlength="20">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label> Last Name <font color="red">*</font> </label>
                                <input type="text" class="form-control vi-victim_info_last_name" name="last_name" maxlength="20">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label>Suffix </label>
                                <input type="text" class="form-control vi-victim_info_suffix" name="suffix" maxlength="20">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Nickname </label>
                                <input type="text" maxlength="10" class="form-control vi-victim_info_nickname" name="nickname" >
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="row">
                            <div class="form-group col-12">
                                <label> Date of Birth </label>
                                <input type="text" class="form-control vi-victim_info_dob datepicker" name="dob" placeholder="MM/DD/YYYY">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label> Place of Birth <font color="red">*</font>  </label>
                                <select class="form-control vi-victim_info_city_pob sel-provinces" name="pob">
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6 col-md-12 col-sm-12 form-currency">
                                <label>Sex <font color="red">*</font> </label>
                                <select  class="form-control sel-sex vi-victim_gender" name="sex">
                                    <option selected="">Sex</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-6 col-md-12 col-sm-12 form-salary">
                                <label>Civil Status <font color="red">*</font>  </label>
                                <select  class="form-control  sel-civil vi-victim_civil_status" name="civil_status">
                                    <option selected="">Civil Status</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-12">
                                <label>Religion </label>
                                <select  class="form-control sel-religion vi-victim_religion" name="religion">
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label>Member of Ethnic Group</label>
                                <select class="form-control sel-ethnic_group vi-victim_ethnic_group" name="victim_ethnic_group">
                                </select>
                            </div>
                        </div>

                    </div>
                </div>              
            </form>

            <div class="content-footer float-right mt-0">
                <button class="btn btn-update" id="btn-manage-personal">Manage</button>
                <button class="btn btn-update hide" id="btn-save-personal">Save</button>
            </div>

        </div>
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="fake-info-content pb-0">
                        <div class="fake-info-content">
                            <div class=" card-sub-title" style="font-size:14px;color:#333C48;"> <span style="color:#0088cc;">Assumed information of Victim</span><br>
                                <small class="card-desc"> Fill in the details in case the victim has used assumed information in the documents. </small>
                            </div>
                            <div class="fake-info-content_form ">
                                <form id="frm-assumed">
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label>Assumed First Name </label>
                                            <input type="text" class="form-control vi-assumed-victim_info_first_name" maxlength="50">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label>Assumed Middle Name </label>
                                            <input type="text" class="form-control vi-assumed-victim_info_middle_name" maxlength="20">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label> Assumed Last Name</label>
                                            <input type="text" class="form-control vi-assumed-victim_info_last_name" maxlength="20">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label> Assumed Date of Birth </label>
                                            <input type="text" class="form-control datepicker vi-assumed-victim_info_dob" name="dob" placeholder="MM/DD/YYYY">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class=" card-sub-title txt-W-500">Health Status<br> 
                                                <small class="card-desc"> Fill in Health Status information. </small> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="fake-info-content_form">
                                        <div class="row">
                                            <div class="form-group col-12">           
                                                <label>Disability</label>
                                                <select class="form-control vi-disability" name="disability" >
                                                </select>
                                            </div>
                                            <div class="form-group col-12">           
                                                <label>History of Illness</label>
                                                <select class="form-control vi-history_of_illness" name="history_of_illness" >
                                                </select>
                                            </div>
                                            <div class="form-group col-12">
                                                <label>Hospitalization</label>
                                                <input type="text" maxlength="50" class="form-control vi-other_info_hospitalization" >
                                            </div>

                                        </div>
                                    </div>

                                </form>
                                <div class="content-footer float-right mt-0">
                                    <button class="btn btn-update" id="btn-manage-assumed">Manage</button>
                                    <button class="btn btn-update hide" id="btn-save-assumed">Save</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12">
            <div class="list-group sub-form-list" id="list-tab" role="tablist">
                <a class="list-group-item list-group-item-action active" id="list-contact_info" data-toggle="list" href="#tab-contact_info" role="tab" aria-controls="home">Contact Information<span class="float-right hide"> <i class="fa fa-caret-right" aria-hidden="true"></i></span></a>
                <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#tab-education" role="tab" aria-controls="profile">Educational Background<span class="float-right hide"> <i class="fa fa-caret-right" aria-hidden="true"></i></span></a>
                <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#tab-address_info" role="tab" aria-controls="messages">Address Information<font color="red"> <b>*</b> </font><span class="float-right hide"> <i class="fa fa-caret-right" aria-hidden="true"></i></span></a>
                <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list" href="#tab-next_kin" role="tab" aria-controls="settings">Next of Kin<span class="float-right hide"> <i class="fa fa-caret-right" aria-hidden="true"></i></span></a>
            </div>
        </div>
        <div class="col-lg-9 col-md-12 col-sm-12">
            <div class="tab-content tab-sub-info-content" id="nav-tabContent" style=" padding: 0px 20px;">

                <div class="tab-pane fade show active" id="tab-contact_info" role="tabpanel" aria-labelledby="list-home-list">
                    <div class="row form-row">
                        <div class="col-lg-12 col-md-12 col-sm-12 ">
                            <br>
                            <div class="card card_tbl-container">
                                <div class="card_tbl-action">

                                    <div class=" card-sub-title"> Contact Information <span class="txt-orange"> (Maximum of 10 entries) </span> <br> 
                                        <small class="card-desc"> List of all contact information that the victim can provide..  </small> 
                                        <hr class="card-sub-title_border">
                                    </div>

                                    <div class="tbl_info card-sub-title">
                                        <span class="">Contact Information List</span>
                                    </div>
                                    <button type="button" class="btn btn-secondary-light_blue btn-add_contact float-right tbl_info"><i class="fa fa-plus"></i> Add Contact Information</button>
                                </div>
                                <table class="table">
                                    <thead class="thead-grey">
                                        <tr>
                                            <th scope="col">Contact Type</th>
                                            <th scope="col">Value</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="victim-contact_info_list">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-education" role="tabpanel" aria-labelledby="list-profile-list">

                    <div class="row form-row">
                        <div class="col-lg-12 col-md-12 col-sm-12 ">
                            <br>
                            <div class="card card_tbl-container">
                                <div class="card_tbl-action">

                                    <div class=" card-sub-title"> Educational Background <span class="txt-orange"> (Highest educational attainment) </span> <br> 
                                        <small class="card-desc"> Victim's level of education completed.  </small> 
                                        <hr class="card-sub-title_border">
                                    </div>

                                    <div class="tbl_info card-sub-title">
                                        <span class="">Educational Attainment List</span>
                                    </div>

                                    <button type="button" class="btn btn-secondary-light_blue btn-add_education float-right tbl_info"><i class="fa fa-plus"></i> Add Educational Attainment</button>
                                </div>
                                <table class="table">
                                    <thead class="thead-grey">
                                        <tr>
                                            <th scope="col">Educational Attainment</th>
                                            <th scope="col">School Name</th>
                                            <th scope="col">Year End</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="victim-education_info_list">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade" id="tab-address_info" role="tabpanel" aria-labelledby="list-messages-list">

                    <div class="row form-row">
                        <div class="col-12 ">
                            <br>
                            <div class="card card_tbl-container">
                                <div class="card_tbl-action">

                                    <div class=" card-sub-title"> Victim's Address Information 
                                        <!--<span class="txt-orange"> (Maximum of 1 entries) </span> <br>--> 
                                        <!--<small class="card-desc"> Victim's list of addresses.  </small>--> 
                                        <hr class="card-sub-title_border">
                                    </div>

                                    <div class="tbl_info card-sub-title">
                                        <span class="">Address Information List</span>
                                    </div>

                                    <button type="button" class="btn  btn-secondary-light_blue   btn-add_address float-right tbl_info"><i class="fa fa-plus"></i> Add Address Information</button>
                                </div>
                                <table class="table">
                                    <thead class="thead-grey">
                                        <tr>
                                            <th scope="col">Complete Address</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="victim-address_info_list">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-next_kin" role="tabpanel" aria-labelledby="list-settings-list">

                    <div class="row form-row">
                        <div class="col-12 ">
                            <br>
                            <div class="card card_tbl-container">
                                <div class="card_tbl-action">

                                    <div class=" card-sub-title"> Victim's Next of Kin <span class="txt-orange"> (Maximum of 10 entries) </span><br> 
                                        <small class="card-desc"> Victim’s closest living relative/s or closest relation.  </small> 
                                        <hr class="card-sub-title_border">
                                    </div>

                                    <div class="tbl_info card-sub-title">
                                        <span class="">Next of Kin List</span>
                                    </div>
                                    <button type="button" class="btn  btn-secondary-light_blue  btn-add_relative float-right tbl_info"><i class="fa fa-plus"></i> Add Next of kin</button>
                                </div>
                                <table class="table">
                                    <thead class="thead-grey">
                                        <tr>
                                            <th scope="col">Relationship</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Contact Number</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="victim-relative_info_list">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <hr>
    <div class="content-footer float-right  match-buttons">

        <!--<button type="button" class="btn btn-previous_tab" data-tab="employment">Previous</button>-->
        <!--<button type="submit" class="btn btn-primary-orange btn-next " data-tab="case-details-tab1" style="margin-left:0px;">Save</button>-->
    </div>
</div>

<div class="modal fade add_modal" id="modal-add_contact_info" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title  msgmodal-header modal-header_title ">Add Contact Info</h5>

            </div>
            <div class="modal-body msgmodal-body">
                <form class=" mx-2 px-2" id="form-add_contact_info" onSubmit="return false;">
                    <div class="div">

                        <div class="row ">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Contact type <font color="red">*</font> </label>
                                <select class="form-control sel-contact_type a-vi-contact_type" name="contact_type">
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label class="lbl-contact-value"> Value <font color="red">*</font> </label>
                                <input type="text" class="form-control a-vi-contact_content" name="contact_content">
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
<!--//------- MANAGE CONTACT INFO ----//-->
<div class="modal fade" id="modal-update_contact_info" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title  msgmodal-header modal-header_title ">Manage Contact Info</h5>

            </div>
            <div class="modal-body msgmodal-body">
                <form class=" mx-2 px-2" id="form-update_contact_info" onSubmit="return false;">
                    <input type="hidden" class="stored-contact_id">
                    <div class="div">

                        <div class="row ">
                            <div class="form-group col-12 ">
                                <label>Contact type <font color="red">*</font> </label>
                                <select class="form-control sel-contact_type u-vi-victim_contact_detail_type" name="contact_type">
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label class="lbl-contact-value"> Value <font color="red">*</font> </label>
                                <input type="text" class="form-control u-vi-victim_contact_detail_content" name="contact_content">
                            </div>
                        </div>
                    </div>
                    <div class="content-footer float-right  match-buttons">
                        <button type="button" class="btn btn-cancel btn-modal-cancel">Cancel</button>
                        <button type="submit" class="btn btn-primary-orange btn-next" style="margin-left:0px;">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--ADD EDUCATION INOFRMATION-->
<div class="modal fade" id="modal-add_education_info"  role="dialog" data-backdrop="static">
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title  msgmodal-header modal-header_title "> Add Education Info</h5>
            </div>
            <div class="modal-body msgmodal-body">
                <form id="form-add_education_info" class="col-lg-12 col-md-12 col-sm-12 ">
                    <div class="col-lg-12 col-md-12 col-sm-12 ">
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 ">
                                <label>Education Type  <font color="red">*</font></label>
                                <select class="form-control sel-education a-vi-education_type" name="education_type">
                                </select>
                            </div>
                        </div>
                        <div class="row field-education_grade_year">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 ">
                                <label> Grade or Year level </label>
                                <input type="text" maxlength="20" class="form-control a-vi-education_grade_year">
                            </div>
                        </div>
                        <div class="row field-education_school_name">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 ">
                                <label>School Name</label>
                                <input type="text" maxlength="50" class="form-control a-vi-education_school" name="education_school">
                            </div>
                        </div>
                        <div class="row field-education_course">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 ">
                                <label> Course </label>
                                <input type="text" maxlength="50" class="form-control a-vi-education_course">
                            </div>
                        </div>
                        <div class="row field-education_start-end">
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 ">
                                <label> School Year </label>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 ">
                                <label> </label>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <input type="text" name="year_start" minlength="4" maxlength="4" id="inp-year_start" class="form-control numbersOnly a-vi-education_start" placeholder="Start e.g. 2000">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <input type="text" name="year_end" minlength="4" maxlength="4" id="inp-year_end" class="form-control numbersOnly a-vi-education_end"  placeholder="End e.g. 2005">
                            </div>
                        </div>
                    </div>
                    <div class="content-footer float-right  match-buttons">
                        <button type="button" class="btn btn-cancel btn-modal-cancel" data-dismiss="modal" >Cancel</button>
                        <button type="submit" class="btn btn-primary-orange btn-next" style="margin-left:0px;" >Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!--UPDATE EDUCATION INFORMATION-->
<div class="modal fade" id="modal-update_education_info"  role="dialog" data-backdrop="static">
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title  msgmodal-header modal-header_title "> Update Education Info</h5>
            </div>
            <div class="modal-body msgmodal-body">
                <form id="form-update_education_info" class="col-lg-12 col-md-12 col-sm-12">
                    <input type="hidden" class="stored-education_id">
                    <div class="col-12">

                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>Education Type <font color="red">*</font></label>
                                <select class="form-control sel-education u-vi-victim_education_type" name="education_type">
                                </select>
                            </div>
                        </div>
                        <div class="row field-education_grade_year">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Grade or Year level </label>
                                <input type="text" class="form-control u-vi-victim_education_grade_year">
                            </div>
                        </div>
                        <div class="row field-education_school_name">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> School Name </label>
                                <input type="text" class="form-control u-vi-victim_education_school" name="education_school">
                            </div>
                        </div>
                        <div class="row field-education_course">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label> Course </label>
                                <input type="text" class="form-control u-vi-victim_education_course">
                            </div>
                        </div>
                        <div class="row field-education_start-end">
                            <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                <label> Year Start </label>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                <label> School Year </label>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                <input type="text" name="year_start" minlength="4" maxlength="4" class="form-control u-vi-victim_education_start numbersOnly" placeholder="Start">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                <input type="text" name="year_end" minlength="4" maxlength="4"  class="form-control u-vi-victim_education_end numbersOnly" placeholder="End">
                            </div>
                        </div>
                    </div>
                    <div class="content-footer float-right  match-buttons">
                        <button type="button" class="btn btn-cancel" data-dismiss="modal" >Cancel</button>
                        <button type="submit" class="btn btn-secondary-light_blue" style="margin-left:0px;" >Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--ADD ADDRESS INFORMATION-->
<div class="modal fade add_modal" id="modal-add_address_info" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title  msgmodal-header modal-header_title "> Add Address Info</h5>

            </div>
            <div class="modal-body msgmodal-body">
                <form id="form-add_address_info" class="col-12">
                    <div class="col-12">

                        <div class="row">
                            <div class="form-group col-12">
                                <label> Region <font color="red">*</font> </label>
                                <select class="form-control sel-regions a-vi-address_region" name="region">
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label> Province / State </label>
                                <select class="form-control sel-provincesByRegionId a-vi-address_province" name="province" disabled>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label> City </label>
                                <select class="form-control sel-cities sel-citiesByProvinceId a-vi-address_city" name="city" disabled>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label> Barangay </label>
                                <select class="form-control sel-barangay sel-barangayByCityId a-vi-address_barangay" disabled>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label> Unit No.,House No.,Bldg, Street Name </label>
                                <textarea class="form-control a-vi-address_complete" name="address" rows="3" maxlength="500"></textarea>
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

<!--UPDATE ADDRESS INFOR-->
<div class="modal fade" id="modal-update_address_info" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title  msgmodal-header modal-header_title "> Update Address Info</h5>

            </div>
            <div class="modal-body msgmodal-body">
                <form id="form-update_address_info" class="col-12">
                    <input type="hidden" class="stored-address_id">
                    <div class="col-12">

                        <div class="row">
                            <div class="form-group col-12">
                                <label> Region <font color="red">*</font> </label>
                                <select class="form-control sel-regions u-vi-victim_address_list_region_id" name="region">
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label> Province / State </label>
                                <select class="form-control sel-provinces sel-provincesByRegionId u-vi-victim_address_list_province_id" name="province">
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label> City </label>
                                <select class="form-control sel-cities sel-citiesByProvinceId u-vi-victim_address_list_city_id" name="city">
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label> Barangay </label>
                                <select class="form-control sel-barangay sel-barangayByCityId u-vi-victim_address_list_brgy_id">
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label> Complete Address </label>
                                <textarea class="form-control u-vi-victim_address_list_address" name="address" rows="3" maxlength="500"></textarea>
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

<!--ADD RELATIVE INFO-->
<div class="modal fade add_modal" id="modal-add_relative_info" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title  msgmodal-header modal-header_title "> Add Relative Info</h5>

            </div>
            <div class="modal-body msgmodal-body">
                <form id="form-add_relative_info" class="col-12">
                    <div class="col-12">

                        <div class="row">
                            <div class="form-group col-12">
                                <label> Relationship <font color="red">*</font></label>
                                <select class="form-control sel-relation a-vi-relative_type" name="relative_type">
                                </select>
                            </div>
                        </div>
                        <div class="row row-other hide">
                            <div class="form-group col-12">
                                <label> Other </label>
                                <input type="text" class="form-control a-vi-relative_other" maxlength="50" name="relative_name_other">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-12">
                                <label> Name <font color="red">*</font></label>
                                <input type="text" class="form-control a-vi-relative_name" maxlength="50" name="relative_name">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-12">
                                <label> Primary Contact Number </label>
                                <input type="text" class="form-control a-vi-relative_primary_contact_number numbersOnly" name="primary_contact">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-12">
                                <label> Secondary Contact Number </label>
                                <input type="text" class="form-control a-vi-relative_secondary_contact_number numbersOnly" name="secondary_contact">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-12">
                                <label> Email </label>
                                <input type="text" class="form-control a-vi-relative_email" name="email">
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

<!--UPDATE RELATIVE INFO-->
<div class="modal fade" id="modal-update_relative_info" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title  msgmodal-header modal-header_title "> Update Relative Info</h5>

            </div>
            <div class="modal-body msgmodal-body">
                <form id="form-update_relative_info" class="col-12">
                    <input type="hidden" class="stored-relative_id">
                    <div class="col-12">

                        <div class="row">
                            <div class="form-group col-12">
                                <label> Family Relation  <font color="red">*</font> </label>
                                <select class="form-control sel-relation u-vi-victim_relative_type" name="relative_type">
                                </select>
                            </div>
                        </div>
                        <div class="row row-other-u hide">
                            <div class="form-group col-12">
                                <label> Other </label>
                                <input type="text" maxlength="50" class="form-control u-vi-relative_other u-vi-victim_relative_type_other" name="urelative_name_other">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label> Name  <font color="red">*</font> </label>
                                <input type="text" maxlength="50" class="form-control u-vi-victim_relative_fullname" name="relative_name">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-12">
                                <label> Primary Contact Number </label>
                                <input type="text" class="form-control u-vi-victim_relative_primary_contact_number numbersOnly " name="primary_contact">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-12">
                                <label> Secondary Contact Number </label>
                                <input type="text" class="form-control u-vi-victim_relative_second_contact_number numbersOnly " name="secondary_contact">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-12">
                                <label> Email </label>
                                <input type="text" class="form-control u-vi-victim_relative_email" name="email">
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