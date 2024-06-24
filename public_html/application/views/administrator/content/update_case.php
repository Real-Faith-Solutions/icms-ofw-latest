<?php
/**
 * Page Security
 */
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="page-content">
    <input type="hidden" id="case_id" value="<?= $case_id ?>">
    <input type="hidden" id="victim_id" value="<?= $victim_id ?>">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="page-content-inner">
        <div class="mt-content-body">
            <div class="row container-padding">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="card-title">
                                    <p> Manage Report</p>
                                    <small class="card-desc"> Manage report details </small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- <div class="col-lg-6 col-md-6 col-sm-6 pl-10">
                                <h6 class="case_no-title"><span>CASE NUMBER : <?= $case_number ?></span></h6>
                            </div> -->
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="float-right">
                                    <h6 class="case_no-title d-inline-block mb-0 mt-2  mr-3"><span>CASE NUMBER : <?= $case_number ?></span></h6>
                                    <button type="button" id="btn_back_list" class="btn btn-secondary">Back to List</button>
                                    <button type="button" id="export_print_report" class="btn btn-info lvl-ce lvl-ch lvl-ca lvl-ra">Export/Print</button>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="d-inline-flex bd-highlight">
                                <ul class="nav rec-ul" data-id="1">
                                    <li class="nav-item nav-inner-item ">
                                        <a class="nav-link active nav-tab" data-toggle="tab" href="#victim_details" id="victim_details_tab">Victim's Details</a>
                                    </li>
                                    <li class="nav-item nav-inner-item">
                                        <a class="nav-link  nav-tab" data-choosen="0" data-toggle="tab" href="#employment_details" id="employment_details_tab">Employment Details</a>
                                    </li>
                                    <li class="nav-item nav-inner-item ">
                                        <a class="nav-link nav-tab" data-toggle="tab" href="#case_details">Incident Details </a>
                                    </li>
                                    <li class="nav-item nav-inner-item lvl-ce lvl-ch lvl-ca lvl-ra">
                                        <a class="nav-link nav-tab" data-toggle="tab" href="#case_assignee">Assignee </a>
                                    </li>
                                </ul>
                            </div>

                            <div class=" card-stats-inner">
                                <div class="col-md-12 col-lg-12 col-sm-12">
                                    <div class="tab-content">

                                        <!--VICTIM DETAILS-->

                                        <div class="tab-pane fade show active" id="victim_details" role="tabpanel" aria-labelledby="recent-case-tab">
                                            <?= __loadPage('sub_update_case/victim_details'); ?>
                                        </div>



                                        <!--EMPLOYMENT DETAILS-->
                                        <div class="tab-pane fade  " id="employment_details" role="tabpanel" aria-labelledby="recent-case-tab">
                                            <?= __loadPage('sub_update_case/employment_details'); ?>
                                        </div>



                                        <!--CASE DETAILS-->
                                        <div class="tab-pane fade  " id="case_details" role="tabpanel" aria-labelledby="recent-case-tab">
                                            <?= __loadPage('sub_update_case/case_details'); ?>

                                        </div>

                                        <div class="tab-pane fade  " id="service_details" role="tabpanel" aria-labelledby="recent-case-tab">

                                            <div class="form-content">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="row">
                                                            <div class="col-lg-8 col-md-8 col-sm-8">
                                                                <div class=" card-sub-title txt-W-500">Update Services<br>
                                                                    <small class="card-desc"> Update services and logs</small>
                                                                </div>

                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                                <div class='float-right'>
                                                                    <button type="button" style="margin-bottom: -60px;" class="btn btn-secondary-light_blue" id="btn-add-offender"><i class="fa fa-plus"></i> Add Services</button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="card card_tbl-container card-height">

                                                            <table class="table">
                                                                <thead class="thead-grey">
                                                                    <tr>
                                                                        <th scope="col">Services</th>
                                                                        <th scope="col">Assigned Agency</th>
                                                                        <th scope="col">Assessment Term</th>
                                                                        <th scope="col">Date Reminder</th>
                                                                        <th scope="col">Date Tagged</th>
                                                                        <th scope="col">Status</th </tr> </thead> <tbody class="tbl-services-list" id="tbl-services-list">
                                                                    <tr>
                                                                        <td colspan='5'>
                                                                <center>Loading data. Please wait . . .</center>
                                                                </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--Start Assignee-->
                                        <div class="tab-pane fade  " id="case_assignee" role="tabpanel" aria-labelledby="recent-case-tab">
                                            <?= __loadPage('sub_update_case/assignee'); ?>

                                        </div>
                                        <!--End Assignee-->

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

<!--====================== export data section ======================-->

<div id="content-print" class="hide">
    <div style="text-align: center">
        <img src="https://www.1343actionline.ph/images/logos/iacat.png" style="width:75px; height:75px; margin-top: 5px;">
        <br>
        <span style=" margin-top: 17px; font-family: Microsoft Yahei, sans-serif;  font-size: 16px; color: #1e518a; text-transform: uppercase; font-weight: 600;">Integrated Case Management System</span>
        <br>
        <small>Case number : <?= $case_number ?></small>
        <br>
        <small><?= $_SESSION['userData']['agency_name'] ?> (<?= $_SESSION['userData']['agency_abbr'] ?>)</small>
        <br>
        <small><?= $_SESSION['userData']['agency_branch_name'] ?></small>

    </div>
    <br>
    <hr style="width: 2px solid rgba(0,0,0,0.3)">
    <br>

    <!--        personal-->
    <table width="100%" cellpadding="10" id="tbl-victim-info">
        <thead>
            <tr>
                <th valign="middle" colspan="4" style="background: #d8d6d6;" align="left"> I. Victim Information</th>
            </tr>
        <thead>
        <tbody>
            <tr>
                <td width="50%" valign="top">
                    <table>
                        <tr>
                            <td>First name</td>
                            <td>:</td>
                            <td id='personal-fname'></td>
                        </tr>
                        <tr>
                            <td>Middle name</td>
                            <td>:</td>
                            <td id='personal-mname'></td>
                        </tr>
                        <tr>
                            <td>Last name</td>
                            <td>:</td>
                            <td id='personal-lname'></td>
                        </tr>
                        <tr>
                            <td>Suffix </td>
                            <td>:</td>
                            <td id='personal-suffix'></td>
                        </tr>
                        <tr>
                            <td>Religion </td>
                            <td>:</td>
                            <td id='personal-religion'></td>
                        </tr>
                    </table>
                </td>
                <td width="50%" valign="top">
                    <table>
                        <tr>
                            <td>Date of Birth </td>
                            <td>:</td>
                            <td id='personal-dob'></td>
                        </tr>
                        <tr>
                            <td>Place of Birth</td>
                            <td>:</td>
                            <td id='personal-pob'></td>
                        </tr>
                        <tr>
                            <td>Sex</td>
                            <td>:</td>
                            <td id='personal-sex'></td>
                        </tr>
                        <tr>
                            <td>Civil Status</td>
                            <td>:</td>
                            <td id='personal-civil'>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <br><br>

    <!-- assumed name-->
    <table width="100%" cellpadding="10" id="assumed-info">
        <thead>
            <tr>
                <th valign="middle" colspan="4" style="background: #d8d6d6;" align="left">II. Assumed Information</th>
            </tr>
        <thead>
        <tbody>
            <tr>
                <td width="50%" valign="top">
                    <table>
                        <tr>
                            <td>First name</td>
                            <td>:</td>
                            <td id='assumed-fname'></td>
                        </tr>
                        <tr>
                            <td>Middle name</td>
                            <td>:</td>
                            <td id='assumed-mname'></td>
                        </tr>
                    </table>
                </td>
                <td width="50%" valign="top">
                    <table>
                        <tr>
                            <td>Last name</td>
                            <td>:</td>
                            <td id='assumed-lname'></td>
                        </tr>
                        <tr>
                            <td>Date of Birth </td>
                            <td>:</td>
                            <td id='assumed-dob'></td>
                        </tr>
                    </table>
                </td>
            </tr>

        </tbody>
    </table>
    <br><br>

    <!--contact-->
    <table width="100%" id="">
        <thead>
            <tr>
                <th valign="middle" colspan="3" style="background: #d8d6d6; padding:10px" align="left">
                    III. Contact Information
                </th>
            </tr>
        <thead>
        <tbody cellpadding="4" style='margin-top: 5px' id='tbody-contact'>
        </tbody>
    </table>
    <br><br>

    <!--education-->
    <table width="100%" cellpadding="10" id="">
        <thead>
            <tr>
                <th valign="middle" colspan="3" style="background: #d8d6d6;" align="left">
                    IV. Educational Background
                </th>
            </tr>
            <tr>
                <th valign="middle" style="border-bottom: 1px solid rgba(0,0,0,0.1);" align="left">
                    Level
                </th>
                <th valign="middle" style="border-bottom: 1px solid rgba(0,0,0,0.1);" align="left">
                    Name of school
                </th>
                <th valign="middle" style="border-bottom: 1px solid rgba(0,0,0,0.1);" align="left">
                    Year End
                </th>
            </tr>
        <thead>
        <tbody id='tbody-education'>

        </tbody>
    </table>
    <br><br>

    <!-- address -->
    <table width="100%" cellpadding="10" cellspacing="0" id="">
        <thead>
            <tr>
                <th valign="middle" colspan="4" style="background: #d8d6d6;" align="left"> V. Address Information</th>
            </tr>
        <thead>
        <tbody id='tbody-address'>
        </tbody>
    </table>
    <br><br>

    <!-- Next if Kin -->
    <table width="100%" cellpadding="10" id="assumed-info">
        <thead>
            <tr>
                <th valign="middle" colspan="3" style="background: #d8d6d6;padding:10px" align="left">
                    VI. Next of Kin
                </th>
            </tr>
            <tr>
                <th valign="middle" style="border-bottom: 1px solid rgba(0,0,0,0.1);" align="left">
                    Relationship
                </th>
                <th valign="middle" style="border-bottom: 1px solid rgba(0,0,0,0.1);" align="left">
                    Name
                </th>
                <th valign="middle" style="border-bottom: 1px solid rgba(0,0,0,0.1);" align="left">
                    Contact Number
                </th>
            </tr>
        <thead>
        <tbody id="tbody-next-kin">
        </tbody>
    </table>
    <br><br>

    <!-- contract-->
    <table width="100%" cellpadding="10" id="">
        <thead>
            <tr>
                <th valign="middle" colspan="4" style="background: #d8d6d6;" align="left">
                    VII. Employment Details Based on Victim’s contract<span style="float:right;"><small align='right'><i class="is_documented"></i></small></span>
                </th>
            </tr>
        <thead>
        <tbody>
            <tr>
                <td width="50%">
                    <table>
                        <tr>
                            <td>Country of Employment</td>
                            <td>:</td>
                            <td id="empt-country"></td>
                        </tr>
                        <tr>
                            <td>Employment City</td>
                            <td>:</td>
                            <td id="empt-city"></td>
                        </tr>
                        <tr>
                            <td>Position / Occupation</td>
                            <td>:</td>
                            <td id="empt-occupation"></td>
                        </tr>
                        <tr>
                            <td>Salary per hour</td>
                            <td>:</td>
                            <td id="empt-salary-peso"></td>
                        </tr>
                    </table>
                </td>
                <td width="50%">
                    <table>
                        <tr>
                            <td>Number of work per week</td>
                            <td>:</td>
                            <td id="empt-per-week"></td>
                        </tr>
                        <tr>
                            <td>Number of working hours per day</td>
                            <td>:</td>
                            <td id="empt-per-day"></td>
                        </tr>
                        <tr>
                            <td>Salary in Foreign Currency</td>
                            <td>:</td>
                            <td id="empt-per-f-currency"></td>
                        </tr>
                        <tr>
                            <td>Salary in Foreign Amount</td>
                            <td>:</td>
                            <td id="empt-per-f-amount"></td>
                        </tr>
                    </table>
                </td>
            </tr>

        </tbody>
    </table>
    <br><br>


    <!--  different from contract-->
    <table width="100%" cellpadding="10" id="">
        <thead>
            <tr>
                <th valign="middle" colspan="4" style="background: #d8d6d6;" align="left">
                    VIII. Employment Details if different from Victim’s Contract<span style="float:right;"><small align='right'><i class="is_documented"></i></small></span>
                </th>
            </tr>
        <thead>
        <tbody>
            <tr>
                <td width="50%">
                    <table>
                        <tr>
                            <td>Country of Employment</td>
                            <td>:</td>
                            <td id="empt-u-country"></td>
                        </tr>
                        <tr>
                            <td>Employment City</td>
                            <td>:</td>
                            <td id="empt-u-city"></td>
                        </tr>
                        <tr>
                            <td>Position / Occupation</td>
                            <td>:</td>
                            <td id="empt-u-occupation"></td>
                        </tr>
                        <tr>
                            <td>Salary per hour</td>
                            <td>:</td>
                            <td id="empt-u-salary-peso"></td>
                        </tr>
                    </table>
                </td>
                <td width="50%">
                    <table>
                        <tr>
                            <td>Number of work per week</td>
                            <td>:</td>
                            <td id="empt-u-per-week"></td>
                        </tr>
                        <tr>
                            <td>Number of working hours per day</td>
                            <td>:</td>
                            <td id="empt-u-per-day"></td>
                        </tr>
                        <tr>
                            <td>Salary in Foreign Currency</td>
                            <td>:</td>
                            <td id="empt-u-per-f-currency"></td>
                        </tr>
                        <tr>
                            <td>Salary in Foreign Amount</td>
                            <td>:</td>
                            <td id="empt-u-per-f-amount"></td>
                        </tr>
                    </table>
                </td>
            </tr>

        </tbody>
    </table>
    <br><br>


    <!-- employer-->
    <table width="100%" cellspacing="1" id="">
        <thead>
            <tr>
                <th valign="middle" colspan="6" style="background: #d8d6d6; padding:10px" align="left">
                    IX. Employer's Detail
                </th>
            </tr>
        <thead>
        <tbody>
            <tr>
                <td width="20%" style='padding-left: 10px'>Employer Name</td>
                <td width="1%">:</td>
                <td width="29%" id="empr-name"></td>
                <td width="20%">Employer Country</td>
                <td width="1%">:</td>
                <td width="29%" id="empr-country"></td>
            </tr>
            <tr>
                <td width="20%" style='padding-left: 10px'>Representative Name </td>
                <td width="1%">:</td>
                <td width="29%" id="empr-rep-name"></td>
                <td width="20%">Employer City</td>
                <td width="1%">:</td>
                <td width="29%" id="empr-city"></td>
            </tr>
            <tr>
                <td width="20%" style='padding-left: 10px'>Telephone Number</td>
                <td width="1%">:</td>
                <td width="29%" id="empr-telno"></td>
                <td width="20%">Email</td>
                <td width="1%">:</td>
                <td width="29%" id="empr-email"></td>
            </tr>
            <tr>
                <td width="20%" style='padding-left: 10px'>Last Known Address</td>
                <td width="1%"> : </td>
                <td colspan="4" id="empr-address"></td>
            </tr>


        </tbody>
    </table>
    <br><br>

    <!-- local recruitment-->
    <table width="100%" cellpadding="10" id="assumed-info">
        <thead>
            <tr>
                <th valign="middle" colspan="4" style="background: #d8d6d6;" align="left">X. Local Recruitment</th>
            </tr>
        <thead>
        <tbody>
            <tr>
                <td width="50%" valign="top">
                    <table>
                        <tr>
                            <td>Agency name</td>
                            <td>:</td>
                            <td id="l-agn-name"></td>
                        </tr>
                        <tr>
                            <td>Phone Number</td>
                            <td>:</td>
                            <td id="l-agn-phone"></td>
                        </tr>
                        <tr>
                            <td>Fax Number</td>
                            <td>:</td>
                            <td id="l-agn-fax"></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td id="l-agn-email"></td>
                        </tr>
                        <tr>
                            <td>Website</td>
                            <td>:</td>
                            <td id="l-agn-website"></td>
                        </tr>
                    </table>
                </td>
                <td width="50%">
                    <table>
                        <tr>
                            <td>Agency Country</td>
                            <td>:</td>
                            <td id="l-agn-country"></td>
                        </tr>
                        <tr>
                            <td>Agency Address</td>
                            <td>:</td>
                            <td id="l-agn-address"></td>
                        </tr>
                        <tr>
                            <td>Name of Representative</td>
                            <td>:</td>
                            <td id="l-agn-rep"></td>
                        </tr>
                        <tr>
                            <td>Contact Number of Representative</td>
                            <td>:</td>
                            <td id="l-agn-rep-cont"></td>
                        </tr>
                        <tr>
                            <td>Address of the Representative</td>
                            <td>:</td>
                            <td id="l-agn-rep-address"></td>
                        </tr>
                    </table>
                </td>
            </tr>

        </tbody>
    </table>
    <br><br>

    <!--  foreign recruitment-->
    <table width="100%" cellpadding="10" id="assumed-info">
        <thead>
            <tr>
                <th valign="middle" colspan="4" style="background: #d8d6d6;" align="left">XI. Foreign Recruitment</th>
            </tr>
        <thead>
        <tbody>
            <tr>
                <td width="50%" valign="top">
                    <table>
                        <tr>
                            <td>Agency name</td>
                            <td>:</td>
                            <td id="f-agn-name"></td>
                        </tr>
                        <tr>
                            <td>Phone Number</td>
                            <td>:</td>
                            <td id="f-agn-phone"></td>
                        </tr>
                        <tr>
                            <td>Fax Number</td>
                            <td>:</td>
                            <td id="f-agn-fax"></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td id="f-agn-email"></td>
                        </tr>
                        <tr>
                            <td>Website</td>
                            <td>:</td>
                            <td id="f-agn-website"></td>
                        </tr>
                    </table>
                </td>
                <td width="50%">
                    <table>
                        <tr>
                            <td>Agency Country</td>
                            <td>:</td>
                            <td id="f-agn-country"></td>
                        </tr>
                        <tr>
                            <td>Agency Address</td>
                            <td>:</td>
                            <td id="f-agn-address"></td>
                        </tr>
                        <tr>
                            <td>Name of Representative</td>
                            <td>:</td>
                            <td id="f-agn-rep"></td>
                        </tr>
                        <tr>
                            <td>Contact Number of Representative</td>
                            <td>:</td>
                            <td id="f-agn-rep-cont"></td>
                        </tr>
                        <tr>
                            <td>Address of the Representative</td>
                            <td>:</td>
                            <td id="f-agn-rep-address"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <br><br>


    <!--  deployment-->
    <table width="100%" cellpadding="10" id="">
        <thead>
            <tr>
                <th valign="middle" colspan="4" style="background: #d8d6d6;" align="left">
                    XII. Deployment Details
                    <span style="float:right;"><small align='right'><i class="is_falsified"></i></small>
                </th>
            </tr>
        <thead>
        <tbody>
            <tr>
                <td width="50%">
                    <table>
                        <tr>
                            <td>Departure Type</td>
                            <td>:</td>
                            <td id="dept-type"></td>
                        </tr>
                        <tr>
                            <td>Port of Exit</td>
                            <td>:</td>
                            <td id="port-of-exit"></td>
                        </tr>
                        <tr>
                            <td>Country of Destination</td>
                            <td>:</td>
                            <td id="country-destination"></td>
                        </tr>
                    </table>
                </td>
                <td width="50%">
                    <table>
                        <tr>
                            <td>Visa Category</td>
                            <td>:</td>
                            <td id="visa-cat"></td>
                        </tr>
                        <tr>
                            <td>Deployment Date</td>
                            <td>:</td>
                            <td id="deploy-date"></td>
                        </tr>
                        <tr>
                            <td>Arrival Date</td>
                            <td>:</td>
                            <td id="arrival-date"></td>
                        </tr>
                    </table>
                </td>
            </tr>

        </tbody>
    </table>
    <br><br>


    <!--  passport-->
    <table width="100%" cellpadding="10" id="">
        <thead>
            <tr>
                <th valign="middle" colspan="4" style="background: #d8d6d6;" align="left">
                    XIII. Passport Details
                </th>
            </tr>
        <thead>
        <tbody>
            <tr>
                <td width="50%">
                    <table>
                        <tr>
                            <td>Passport Number</td>
                            <td>:</td>
                            <td id="pp-number"></td>
                        </tr>
                        <tr>
                            <td>First Name</td>
                            <td>:</td>
                            <td id="pp-fname"></td>
                        </tr>
                        <tr>
                            <td>Middle Name</td>
                            <td>:</td>
                            <td id="pp-mname"></td>
                        </tr>
                        <tr>
                            <td>Last Name</td>
                            <td>:</td>
                            <td id="pp-lname"> </td>
                        </tr>
                        <tr>
                            <td>Sex</td>
                            <td>:</td>
                            <td id="pp-sex"></td>
                        </tr>
                        <tr>
                            <td>Civil Status</td>
                            <td>:</td>
                            <td id="pp-civil"></td>
                        </tr>
                    </table>
                </td>
                <td width="50%">
                    <table>
                        <tr>
                            <td>Date of Birth</td>
                            <td>:</td>
                            <td id="pp-dob"></td>
                        </tr>
                        <tr>
                            <td>Place of Birth (Province)</td>
                            <td>:</td>
                            <td id="pp-pob-prov"></td>
                        </tr>
                        <tr>
                            <td>Place of Birth (City)</td>
                            <td>:</td>
                            <td id="pp-pob-city"></td>
                        </tr>
                        <tr>
                            <td>Place of issued/ released</td>
                            <td>:</td>
                            <td id="pp-p-issued"></td>
                        </tr>
                        <tr>
                            <td>Date issued</td>
                            <td>:</td>
                            <td id="pp-d-issued"></td>
                        </tr>
                        <tr>
                            <td>Passport Expiry</td>
                            <td>:</td>
                            <td id="pp-xp"></td>
                        </tr>
                    </table>
                </td>
            </tr>

        </tbody>
    </table>
    <br><br>


    <!--  transit-->
    <table width="100%" id="">
        <thead>
            <tr>
                <th valign="middle" colspan="6" style="background: #d8d6d6;padding: 10px" align="left">
                    XIV. Transit Details
                </th>
            </tr>
        <thead>
        <tbody id="tbody-transit">

        </tbody>
    </table>
    <br><br>


    <!--  complainant-->
    <table width="100%" cellpadding="10" id="">
        <thead>
            <tr>
                <th valign="middle" colspan="4" style="background: #d8d6d6;" align="left">
                    XV. Complainant Information
                </th>
            </tr>
        <thead>
        <tbody>
            <tr>
                <td width="50%" valign="top">
                    <table>
                        <tr>
                            <td>Date Complained</td>
                            <td>:</td>
                            <td id="comp-date"></td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>:</td>
                            <td id="comp-name"></td>
                        </tr>
                        <tr>
                            <td>Relationship to worker</td>
                            <td>:</td>
                            <td id="comp-relation"></td>
                        </tr>
                        <tr>
                            <td>Remarks</td>
                            <td>:</td>
                            <td id="comp-remarks"></td>
                        </tr>
                    </table>
                </td>
                <td width="50%" valign="top">
                    <table>
                        <tr>
                            <td>Source</td>
                            <td>:</td>
                            <td id="comp-source"></td>
                        </tr>
                        <tr>
                            <td>Contact Number</td>
                            <td>:</td>
                            <td id="comp-contact"></td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>:</td>
                            <td id="comp-address"></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr>

        </tbody>
    </table>
    <br><br>

    <!--report details-->
    <table width="100%" cellspacing="0" id="">
        <thead>
            <tr>
                <th valign="middle" colspan="3" style="padding:10px;background: #d8d6d6;" align="left">
                    XVI. Report Details
                </th>
            </tr>
        <thead>
        <tbody>
            <tr>
                <td width="20%" style="padding-left:10px;">Act</td>
                <td width="1%"> : </td>
                <td id="rep-act"></td>
            </tr>
            <tr>
                <td width="20%" style="padding-left:10px;">Purpose</td>
                <td width="1%"> : </td>
                <td id="rep-purpose"></td>
            </tr>
            <tr>
                <td width="20%" style="padding-left:10px;">Means</td>
                <td width="1%"> : </td>
                <td id="rep-means"></td>
            </tr>
            <tr>
                <td width="20%" style="padding-left:10px;">Brief facts of the case</td>
                <td width="1%"> : </td>
                <td id="rep-fact"></td>
            </tr>

        </tbody>
    </table>
    <br>

    <!--alleged offender-->
    <table width="100%">
        <thead>
            <tr>
                <th valign="middle" colspan="6" style="padding:10px;background: #d8d6d6;" align="left">
                    XVII. Alleged Offender's Details
                </th>
            </tr>
            <tr>
                <th width="50%" align="left" colspan="3" style="padding-left:10px;border-bottom: 1px solid rgba(0,0,0,0.1);">Alleged Offender</th>
                <th style="border-bottom: 1px solid rgba(0,0,0,0.1);" align="left" width="50%">Remarks</th>
            <tr>
        <thead>
        <tbody id="tbody-offender">

        </tbody>
    </table>
    <br>

    <!--risk evaluation-->
    <table width="100%" cellpadding="10" cellspacing="0" id="">
        <thead>
            <tr>
                <th valign="middle" colspan="6" style="background: #d8d6d6;" align="left">
                    XVIII. Case Evaluation and Risk Assessment
                </th>
            </tr>

        <thead>
        <tbody>
            <tr>
                <th width="50%" align="left" valign="top"> Evaluation</th>
                <th valign="top" align="left" width="50%"> Risk Assessment</th>
            </tr>
            <tr>
                <td width="50%" align="left" valign="top" id="print-evaluation"></td>
                <td valign="top" align="left" width="50%" id="print-riskasses"></td>
            </tr>
        </tbody>
    </table>
    <br>

</div>