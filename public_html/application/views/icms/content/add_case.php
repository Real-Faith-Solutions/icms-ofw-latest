<?php
/**
 * Page Security
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- BEGIN PAGE CONTENT BODY -->
<div class="page-content">

    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="page-content-inner">
        <div class="mt-content-body">

            <div class="card card-stats" >
                <div class="row" >
                    <div class="col-12">
                        <p class="case-title-header"> Create New Case | Intake Form <br><small> This will be as new case base from receipt of report. </small></p>
                        <div class=" intake-form-card" >
                            <ul class="nav nav-pills nav-fill intake-form-ul" >
                                <li class="nav-item">
                                    <a class="nav-link intake-nav active nav-tab" id="victims-details-tab" data-toggle="tab" href="#victims-details">Victim's Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link intake-nav nav-tab" id="employment-details-tab" data-toggle="tab" href="#employment-details">Employment Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link intake-nav nav-tab" id="case-details-tab" data-toggle="tab" href="#case-details">Case Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link intake-nav nav-tab" id="summary-tab" data-toggle="tab" href="#summary">Summary</a>
                                </li>
                            </ul>

                            <div class="tab-content" id="myTabContent">
                                <!--PERSONAL INFORMATION-->
                                <div class="tab-pane fade show active" id="victims-details" role="tabpanel" >

                                    <div class="row form-row">
                                        <div class="col-6">
                                            <p class="case-title"> Personal Information <br><small> Basic information of report </small></p>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label>First Name </label>
                                                    <input type="text" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label>Middle Name </label>
                                                    <input type="text" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label> Last Name</label>
                                                    <input type="text" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label>Suffix </label>
                                                    <input type="text" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label> Date of Birth </label>
                                                    <input type="text" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label> Place of Birth </label>
                                                    <input type="text" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label> Gender </label>
                                                    <input type="text" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label>Civil Status </label>
                                                    <select id="inputState" class="form-control">
                                                        <option selected>Choose...</option>
                                                        <option>...</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-6">
                                            <p class="case-title"> Contact Information <br><small> Contact information of the report </small></p>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label>City</label>
                                                    <select id="inputState" class="form-control">
                                                        <option selected>Choose...</option>
                                                        <option>...</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-12">
                                                    <label>Province</label>
                                                    <select id="inputState" class="form-control">
                                                        <option selected>Choose...</option>
                                                        <option>...</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-12">
                                                    <label>Complete Address</label>
                                                    <input type="text" class="form-control" >
                                                </div>
                                                <div class="form-group col-12">
                                                    <label>Telephone / Cellphone Number</label>
                                                    <input type="text" class="form-control" >
                                                </div>
                                                <div class="form-group col-12">
                                                    <label>Social Media Account</label>
                                                    <input type="text" class="form-control" >
                                                </div>
                                                <div class="form-group col-12">
                                                    <label>Social Media Account</label>
                                                    <input type="text" class="form-control" >
                                                </div>
                                                <div class="form-group col-12">
                                                    <label>Social Media Username/ID</label>
                                                    <input type="text" class="form-control" >
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <hr>

                                    <div class="row form-row">
                                        <div class="col-6">
                                            <p class="case-title"> Family or Relatives Information <br><small> Add relative information of the victim. </small></p>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label>Relationship </label>
                                                    <select id="inputState" class="form-control">
                                                        <option selected>Choose...</option>
                                                        <option>...</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-12">
                                                    <label>Full Name </label>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <div class="form-group col-12">
                                                    <label>Contact Number </label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <button class="btn btn-add-relative btn-sm pull-right" type="submit">Save</button>
                                        </div>
                                        <div class="col-6">
                                            <p class="case-title"> List of Relatives Information <br><small> Add relative information of the victim. </small></p>
                                            <table class="table">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">First</th>
                                                        <th scope="col">Last</th>
                                                        <th scope="col">Handle</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td>Mark</td>
                                                        <td>Otto</td>
                                                        <td>@mdo</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">2</th>
                                                        <td>Jacob</td>
                                                        <td>Thornton</td>
                                                        <td>@fat</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">3</th>
                                                        <td>Larry</td>
                                                        <td>the Bird</td>
                                                        <td>@twitter</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row form-row">
                                        <div class="col-4 ">
                                            <button type="button" class="btn btn-next">Next</button>
                                        </div>
                                    </div>
                                </div>
                                <!--END PERSONAL INFORMATION-->

                                <!--EMPLOYMENT DETAILS-->
                                <div class="tab-pane fade " id="employment-details" role="tabpanel" >
                                    <div class="row form-row">
                                        <div class="col-6">
                                            <p class="case-title"> Employment Information <br><small> Basic information of the report. </small></p>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label>Country of Destination </label>
                                                    <select id="inputState" class="form-control">
                                                        <option selected>Choose...</option>
                                                        <option>...</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label>Departure date from PH</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label> Immigration / Visa Category </label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label> Employment Type </label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label> Name of Recruiter</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label> Salary in USD </label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label> Salary per hour</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label> Occupation</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <button class="btn btn-add-relative btn-sm pull-right" type="submit">Save</button>
                                        </div>
                                        <div class="col-6">
                                            <p class="case-title"> Deployment Details <br><small> Basic information of the report. </small></p>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label> Departure</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <!--                                                <div class="form-group col-12">
                                                                                                    <label> Escorted </label>
                                                                                                    <input type="text" class="form-control">
                                                                                                </div>-->
                                                <div class="form-group col-12">
                                                    <label> Port of Exit </label>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <div class="form-group col-12">
                                                    <label> Deployment Date </label>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <div class="form-group col-12">
                                                    <label> Date of Arrival </label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row form-row">
                                        <div class="col-12">
                                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                                <div class="btn-group" role="group" >
                                                    <button type="button" class="btn btn-previous">Previous</button>
                                                    <button type="button" class="btn btn-next">Next</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--END EMPLOYMENT DETAILS-->


                                <!--CASE DETAILS-->
                                <div class="tab-pane fade " id="case-details" role="tabpanel" >
                                    <div class="row form-row">
                                        <div class="col-6">
                                            <p class="case-title"> Case Information <br><small> Basic information of the report. </small></p>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label> Acts</label>
                                                    <select id="inputState" class="form-control">
                                                        <option selected>Choose...</option>
                                                        <option>...</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label> Means</label>
                                                    <select id="inputState" class="form-control">
                                                        <option selected>Choose...</option>
                                                        <option>...</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label> Purpose</label>
                                                    <select id="inputState" class="form-control">
                                                        <option selected>Choose...</option>
                                                        <option>...</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label>Remarks</label>
                                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <p class="case-title"> Initial Assessment & Risk Assessment <br><small> Basic information of the report. </small></p>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label>Case Evaluation & Risk Assessment</label>
                                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label> Immediate Assessment </label>
                                                    <select id="inputState" class="form-control">
                                                        <option selected>Choose...</option>
                                                        <option>...</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label>other form of Support Services </label>
                                                    <select id="inputState" class="form-control">
                                                        <option selected>Choose...</option>
                                                        <option>...</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label> Referred to </label>
                                                    <select id="inputState" class="form-control">
                                                        <option selected>Choose...</option>
                                                        <option>...</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-row">
                                        <div class="col-12">
                                            <p class="case-title"> Brief facts of the case <br><small> Basic information of the report. </small></p>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <!--<label>Remarks</label>-->
                                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-row">
                                        <div class="col-6">
                                            <p class="case-title"> File Upload <br><small> Upload important documents that can help progress the case. </small></p>
                                            <div class="card" style="width: 18rem;">
                                                <div class="card-body">
                                                    <i class="fas fa-upload"></i><br>
                                                    <label style=" margin-left: 32%; margin-top: 13px;">Drag files here </label>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="input-group mb-3" style=" margin-left: 0px! important; width:74%;">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-row">
                                        <div class="col-12">
                                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                                <div class="btn-group" role="group" >
                                                    <button type="button" class="btn btn-previous">Previous</button>
                                                    <button type="button" class="btn btn-next">Next</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--END CASE DETAILS-->


                                <div class="tab-pane fade " id="summary" role="tabpanel">
                                    <div class="row form-row">
                                        <div class="col-12">
                                            <p class="case-title"> Victims Details <br><small> Summary of victims details. </small></p>
                                        </div>
                                    </div>
                                    <div class="row form-row">
                                        <div class="col-6">
                                            <p class="case-sub-title"> Basic Information</p>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Full Name</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Ople Center</label>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Assumed Name</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Agency Name</label>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Gender</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Secret</label>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Civil Status</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Single</label>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Place of Birth</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>July 29,1972</label>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Place of Birth</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Pangasinan</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <p class="case-sub-title"> Basic Information</p>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Complete Address</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</label>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Telephone Number</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>09876543456789</label>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Cellphone Number</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>45678988</label>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>facebook User ID</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Lorem Ipsum </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row form-row">
                                        <div class="col-6">
                                            <p class="case-sub-title"> Family and Relative's Information</p>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Mother's Name</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Lorem Ipsum </label>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Father's Name</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Lorem Ipsum </label>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Spouse Name</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Lorem Ipsum </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <p class="case-sub-title"> Child / Children </p>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Mother's Name</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Lorem Ipsum </label>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Father's Name</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Lorem Ipsum </label>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Child Name</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Lorem Ipsum </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row form-row">
                                        <div class="col-12">
                                            <p class="case-title"> Employment Details <br><small> Summary of victims details. </small></p>
                                        </div>
                                    </div>
                                    <div class="row form-row">
                                        <div class="col-6">
                                            <p class="case-sub-title"> Employment Information</p>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Country of Destination</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Lorem Ipsum </label>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Departure Date from PH</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Lorem Ipsum </label>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Immigration / Visa Category</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Lorem Ipsum </label>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Employment Type</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Lorem Ipsum </label>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Name of Recruiter</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Lorem Ipsum </label>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Name of Local Agency</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Lorem Ipsum </label>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Name of Foreign Agency</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Lorem Ipsum </label>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Actual place of work</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Lorem Ipsum </label>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Occupation</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Lorem Ipsum </label>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Salary per hour</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Lorem Ipsum </label>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-6">
                                            <p class="case-sub-title"> Destination Detail </p>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Type of Departure</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Lorem Ipsum </label>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Departure Date from PH</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Lorem Ipsum </label>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Immigration / Visa Category</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Lorem Ipsum </label>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Port of Exit</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Lorem Ipsum </label>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Name of Recruiter</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Lorem Ipsum </label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <hr>

                                    <div class="row form-row">
                                        <div class="col-12">
                                            <p class="case-title"> Case Details <br><small> Summary of case details. </small></p>
                                        </div>
                                    </div>
                                    <div class="row form-row">
                                        <div class="col-6">
                                            <p class="case-sub-title"> Case Information</p>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Acts</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Lorem Ipsum </label>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Means</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Lorem Ipsum </label>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Purpose</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Lorem Ipsum </label>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Remarks</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Lorem Ipsum </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <p class="case-sub-title"> Brief facts of the case</p>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="6">
                                                             Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                                             Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                                                             when an unknown printer took a galley of type and scrambled it to make a type
                                                             specimen book. It has survived not only five centuries, but also the leap into
                                                             electronic typesetting, remaining essentially unchanged. 
                                            </textarea>
                                        </div>
                                    </div>

                                    <div class="row form-row">
                                        <div class="col-6">
                                            <p class="case-sub-title"> Initial Assessment & Evaluation </p>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Immediate Assessment</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Lorem Ipsum </label>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Other form of support services</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Lorem Ipsum </label>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Referred to</label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Lorem Ipsum </label>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-6 summary-lbl">
                                                    <label>Case evaluation & Risk assessment </label>
                                                </div>
                                                <div class="col-6 summary-details">
                                                    <label>Lorem Ipsum </label>
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

    </div>
</div>