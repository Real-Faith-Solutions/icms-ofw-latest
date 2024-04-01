<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<head>
    <link rel="stylesheet" href="<?= MAIN_SITE_URL ?>assets/global/template/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= MAIN_SITE_URL ?>assets/library/fonts/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?= MAIN_SITE_URL ?>assets/library/fonts/fontawesome/css/fontawesome.css">
    <link rel="stylesheet" href="<?= SITE_ASSETS ?>library/fonts/fontawesome/css/all.css">
    <link rel="stylesheet" href="<?= MAIN_SITE_URL ?>assets/modules/icms/css/file_complaint.css">
    <!-- <link rel="stylesheet" href="<?= MAIN_SITE_URL ?>assets/modules/icms/css/global.css"> -->
</head>

<body>
    <img src="assets/global/images/public_bg.jpg" alt="Girl in a jacket" width="100%" height="100%" class="bg-landing">

    <div class="masthead">
    </div>
    <div class="masthead_inner">
        <div class="masthead-content text-white hidden">
            <div class="container-fluid px-4 px-lg-0">
                <div class="card card-file_complaint_ pb-0">

                    <div class="card-body p-5 ">
                        <div class="row">
                            <div class="col-lg-6 col-sm-9 col-xs-12">
                                <div class="bg-white">
                                    <div class=" bg-white header-navigation ">
                                        <div class="d-flex justify-content-between">
                                            <a class="site-logo-public">
                                                <img src="<?php echo SITE_ASSETS ?>global/images/iacat_logo.png"
                                                    height="70px" alt="INTEGRATED CASE MANAGEMENT SYSTEM">
                                            </a>
                                            <h6 class="header-title_ icms m-auto">INTEGRATED CASE MANAGEMENT SYSTEM</h6>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="d-flex justify-content-between">
                                    <h4 class="card-title text-dark">File Complaint</h4>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" value="1" id="is_victim">
                                        <label class="form-check-label" for="exampleCheck1">Are you the victim?</label>
                                    </div>
                                </div> -->
                            </div>
                            <div class="col-6">
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-6">
                                <h6 class="header-title"> Complainant Details</h6>
                            </div>
                            <div class="col-6">
                                <h6 class="header-title"> Victim Details</h6>
                            </div>
                        </div> -->
                        <form id="file_complaint_form">
                            <div class="row mt-2">
                                <div class="col-lg-6 col-sm-12 ">
                                    <h6 class="header-title text-left p-0"> Victim Details</h6>
                                    <div class="row mt-2">
                                        <div class="col-lg-6 col-sm-12 ">
                                            <div class="form-group">
                                                <label for="">First Name</label><span class="text-danger"> *</span>
                                                <input type="text" class="form-control"
                                                    id="inp-temporary_victim_firstname"
                                                    name="temporary_victim_firstname" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Last Name</label><span class="text-danger"> *</span>
                                                <input type="text" class="form-control"
                                                    id="inp-temporary_victim_lastname" name="temporary_victim_lastname"
                                                    placeholder="">
                                            </div>
                                               <!---Adding <span class="text-danger"> *</span> to show to the user it is required-->
                                            <div class="form-group">
                                                <label for="">Contact Number </label><span class="text-danger"> *</span>
                                                <input type="text" class="form-control"
                                                    id="inp-temporary_victim_mobile_number"
                                                    name="temporary_victim_mobile_number" placeholder="e.g. +639394567128">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Sex </label><span class="text-danger"> *</span>
                                                <select class="form-control" name="temporary_victim_sex">
                                                    <option value="">Select Sex</option>
                                                    <?php foreach ($sex as $key => $val) { ?>
                                                    <option value="<?php echo $val['parameter_count_id'] ?>">
                                                        <?php echo $val['parameter_name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Departure Type </label><span class="text-danger"> *</span>
                                                <select class="form-control" name="temporary_victim_departure_type">
                                                    <option value="">Select Departure Type</option>
                                                    <?php foreach ($dep_type as $key => $val) { ?>
                                                    <option value="<?php echo $val['parameter_count_id'] ?>">
                                                        <?php echo $val['parameter_name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12 ">
                                            <div class="form-group">
                                                <label for="">Middle Name</label>
                                                <input type="text" class="form-control"
                                                    id="inp-temporary_victim_middlename"
                                                    name="temporary_victim_middlename" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Email Address</label><span class="text-danger"> *</span>
                                                <input type="email" class="form-control"
                                                    id="inp-temporary_victim_email_address"
                                                    name="temporary_victim_email_address" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Date of Birth </label><span class="text-danger"> *</span>
                                                <input type="text" class="form-control datepicker"
                                                    name="temporary_victim_dob" placeholder="MM/DD/YYYY">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Civil Status </label><span class="text-danger"> *</span>
                                                <select class="form-control" name="temporary_victim_civil_status">
                                                    <option value="">Select Civil Status</option>
                                                    <?php foreach ($civil_status as $key => $val) { ?>
                                                    <option value="<?php echo $val['parameter_count_id'] ?>">
                                                        <?php echo $val['parameter_name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Country of Deployment </label><span class="text-danger">
                                                    *</span>
                                                <select class="form-control" name="temporary_victim_country_deployment">
                                                    <option value="">Select Country</option>
                                                    <?php foreach ($country as $key => $val) { ?>
                                                    <option value="<?php echo $val['country_id'] ?>">
                                                        <?php echo $val['country_name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Address in Philippines </label><span class="text-danger">
                                            *</span>
                                        <input type="text" class="form-control" name="temporary_victim_address"
                                            placeholder="">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-12 ">
                                    <h6 class="header-title text-left p-0"> Complainant Details</h6>
                                    <div class="row mt-3">
                                        <div class="col-lg-6 col-sm-12 ">
                                            <div class="form-group">
                                                <label for="">First Name</label><span class="text-danger"> *</span>
                                                <input type="text" class="form-control c-dt"
                                                    id="inp-temporary_complainant_firstname"
                                                    name="temporary_complainant_firstname" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Last Name</label><span class="text-danger"> *</span>
                                                <input type="text" class="form-control c-dt"
                                                    id="inp-temporary_complainant_lastname"
                                                    name="temporary_complainant_lastname" placeholder="">
                                            </div>
                                            <!---Adding <span class="text-danger"> *</span> to show to the user it is required-->
                                            <div class="form-group">
                                                <label for="">Contact Number </label><span class="text-danger"> *</span>
                                                <input type="text" class="form-control c-dt"
                                                    id="inp-temporary_complainant_mobile_number"
                                                    name="temporary_complainant_mobile_number" placeholder="e.g. +639394567128">
                                            </div>
                                               <!---Adding <span class="text-danger"> *</span> to show to the user it is required-->
                                            <div class="form-group">
                                                <label for="">Preferred Contact Method </label><span class="text-danger"> *</span>
                                                <select class="form-control"
                                                    name="temporary_complainant_preffered_contact_method">
                                                    <option value="">Select Preferred Contact Method</option>
                                                    <?php foreach ($pref_cont_meth as $key => $val) { ?>
                                                    <option value="<?php echo $val['parameter_count_id'] ?>">
                                                        <?php echo $val['parameter_name'] ?></option>
                                                    <?php } ?>
                                                </select>

                                            </div>



                                        </div>
                                        <div class="col-lg-6 col-sm-12 ">
                                            <div class="form-group">
                                                <label for="">Middle Name</label>
                                                <input type="text" class="form-control c-dt"
                                                    id="inp-temporary_complainant_middlename"
                                                    name="temporary_complainant_middlename" placeholder="">
                                            </div>
                                               <!---Adding <span class="text-danger"> *</span> to show to the user it is required-->
                                            <div class="form-group">
                                                <label for="">Email Address</label><span class="text-danger"> *</span>
                                                <input type="email" class="form-control c-dt"
                                                    id="inp-temporary_complainant_email_address"
                                                    name="temporary_complainant_email_address" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Relationship to Victim </label><span class="text-danger">
                                                    *</span>
                                                <select class="form-control c-dt"
                                                    id="inp-temporary_complainant_relation"
                                                    name="temporary_complainant_relation">
                                                    <option value="">Select relationship</option>
                                                    <?php foreach ($rel_to_victim as $key => $val) { ?>
                                                    <option value="<?php echo $val['parameter_count_id'] ?>">
                                                        <?php echo $val['parameter_name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>



                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="">Complain Details</label><span class="text-danger">
                                            *</span>
                                        <textarea type="text" class="form-control" rows="4" maxlength="5000"
                                            id="inp-temporary_complainant_complain"
                                            name="temporary_complainant_complain" placeholder=""></textarea>
                                    </div>

                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit"
                                        class="btn btn-submit_complaint d-flex m-auto px-5">Submit</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="modal fade" id="q_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you filing a case as the victim?<br>
                        <i style="font-size: 16px;">(Ikaw ba mismo ang biktima? )</i>
                    </h5>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger px-3" id="q_modal_n">No</button>
                    <button type="button" class="btn btn-primary" id="q_modal_y">Yes</button>
                </div>
            </div>
        </div>
    </div>