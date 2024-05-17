 <html lang="en">

 <head>

<!-- <link rel="stylesheet" href="<?= MAIN_SITE_URL ?>assets/global/template/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= MAIN_SITE_URL ?>assets/library/fonts/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?= MAIN_SITE_URL ?>assets/library/fonts/fontawesome/css/fontawesome.css">
    <link rel="stylesheet" href="<?= SITE_ASSETS ?>library/fonts/fontawesome/css/all.css">
    <link rel="stylesheet" href="<?= MAIN_SITE_URL ?>assets/modules/icms/css/verification.css"> -->

    <link rel="stylesheet" href="https://iacat-icms.com/assets/global/template/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://iacat-icms.com/assets/library/fonts/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://iacat-icms.com/assets/library/fonts/fontawesome/css/fontawesome.css">
    <link rel="stylesheet" href="<?= SITE_ASSETS ?>library/fonts/fontawesome/css/all.css">
    <link rel="stylesheet" href="https://iacat-icms.com/assets/modules/icms/css/result_page.css">

 </head>

 <body class="page-content">
     <img src="assets/global/images/public_bg.jpg" alt="Girl in a jacket" width="100%" height="100%" class="bg-landing">

     <div class="masthead">
         <div class="masthead-content- masthead_inner text-white">
             <div class="container-fluid_ mb-5">
                 <div class="card card-icms px-5 pb-5 shadow-lg">
                     <div class="d-flex justify-content-end">
                         <button class="btn btn-primary btn-end-session px-5" type="button">
                             <i class="fas fa-arrow-left"></i> Back</button>
                     </div>
                     <div class="page-content-inner">
                         <div class="row">
                             <div class="col-12">
                                 <div class="bg-white">
                                     <div class=" bg-white header-navigation ">
                                         <div class="d-flex justify-content-start">
                                             <a class="site-logo pt-3">
                                                 <img src="<?php echo SITE_ASSETS ?>global/images/iacat_logo.png"
                                                     height="75px" alt="">
                                                 <h4 class="header-title">INTEGRATED CASE MANAGEMENT SYSTEM</h4>
                                             </a>
                                         </div>
                                     </div>
                                 </div>
                                 <div class=" card-stats shadow-sm p-3 mb-2  bg-white rounded">
                                     <div class="row flex-column flex-md-row px-3">
                                         <div class="col-md-12 col-lg-6 col-xl-6 col-sm-12 mb-10">
                                             <p class="mb-1 fs-18 text-dark"> Date of Complaint:
                                                 <span class="icms-btn-secondary"><?= $resp['date_of_complaint'] ?>
                                                 </span>
                                             </p>
                                         </div>
                                         <div class="col-md-12 col-lg-6 col-xl-6 col-sm-12 mb-10">
                                             <p class="mb-1 fs-18 text-dark"> Complainant :
                                                 <span
                                                     class="icms-btn-secondary"><?= $resp['complainant_name'] ?></span>
                                             </p>
                                         </div>
                                         <div class="col-md-12 col-lg-6 col-xl-6 col-sm-12 mb-10">
                                             <p class="mb-1 fs-18 text-dark"> Victim Name :
                                                 <span class="icms-btn-secondary"> <?= $resp['victim_name'] ?></span>
                                             </p>
                                         </div>
                                         <div class="col-md-12 col-lg-6 col-xl-6 col-sm-12 mb-10">
                                             <p class="mb-1 fs-18 text-dark"> Complaint Status :
                                                 <span class="badge badge-stats"> <?= $resp['status'] ?></span>
                                             </p>
                                         </div>
                                         <div class="col-md-12 col-lg-6 col-xl-6 col-sm-12 mb-10">
                                             <p class="mb-1 fs-18 text-dark"> Last Updated :
                                                 <span class="icms-btn-secondary"> <?= $resp['last_updated'] ?></span>
                                             </p>
                                         </div>
                                         <div class="col-md-12 col-lg-6 col-xl-6 col-sm-12 mb-10">
                                             <p class="mb-1 fs-18 text-dark"> Last Tracked :
                                                 <span class="icms-btn-secondary"> <?= $resp['last_tracked'] ?> </span>
                                             </p>
                                         </div>
                                     </div>

                                 </div>
                                 <div
                                     class=" card-stats shadow-sm p-3 mb-2  bg-white rounded d-flex justify-content-lg-between">
                                     <p class="mb-0 fs-18 text-dark">Tracking Number : <span
                                             class="icms-btn-secondary t-num"><?= $resp['tracking_number'] ?></span>
                                     </p>
                                     <button class="btn btn-set_notif btn-select-notif_method" hidden>
                                         <i class="fas fa-cogs"></i>
                                     </button>
                                 </div>
                                 <div class=" card-stats shadow-sm p-3  bg-white rounded">
                                     <h6 class="header-title"> Updates </h6>
                                     <!-- new ui  -->
                                     <div class="box">
                                         <ul id="first-list">
                                             <?php if(count($listing) > 0) { ?>
                                             <?php foreach($listing as $key => $val) { ?>
                                             <?php if($val['log_type'] == 'remarks')  { ?>
                                             <li>
                                                 <span></span>
                                                 <div class="info"><?= $val['temporary_case_remarks'] ?></div>
                                                 <div class="time">
                                                     <span><?= $val['temporary_case_remarks_date_added'] ?> </span>
                                                     <span></span>
                                                 </div>
                                             </li>
                                             <?php  } else if($val['log_type'] == 'service')  { ?>
                                             <li>
                                                 <span></span>
                                                 <div class="title"><?= $val['service_name'] ?> -
                                                     <?= $val['service_duration'] ?></div>
                                                 <div class="info"><?= $val['agency'] ?></div>
                                                 <div class="info">Status: <span
                                                         class="badge badge-stats"><?= $val['service_status'] ?> </span>
                                                 </div>
                                                 <div class="time">
                                                     <span><?= $val['temporary_case_remarks_date_added'] ?> </span>
                                                     <span></span>
                                                 </div>
                                             </li>
                                             <?php } else if($val['log_type'] == 'legal')  { ?>
                                             <li>
                                                 <span></span>
                                                 <div class="title"><?= $val['service_name'] ?> -
                                                     <?= $val['service_duration'] ?></div>
                                                 <div class="info"><?= $val['agency'] ?></div>
                                                 <div class="info">Status: <span
                                                         class="badge badge-stats"><?= $val['service_status'] ?> </span>
                                                 </div>
                                                 <div class="time">
                                                     <span><?= $val['temporary_case_remarks_date_added'] ?> </span>
                                                     <span></span>
                                                 </div>


                                                 <?php if($val['service_type'] == 'criminal_case')  { ?>
                                                 <div class="info">Slip Investigation Number:
                                                     <?= $val['slip_investigation_no'] ?></div>
                                                 <div class="info">Docket Number: <?= $val['docket_number'] ?></div>
                                                 <div class="time">
                                                     <span><?= $val['temporary_case_remarks_date_added'] ?> </span>
                                                     <span></span>
                                                 </div>
                                             </li>
                                             <?php } else { ?>
                                             <div class="info">Slip Investigation Number: <?= $val['case_no'] ?></div>
                                             <div class="info">Docket Number: <?= $val['docket_number'] ?></div>
                                             <div class="time">
                                                 <span><?= $val['temporary_case_remarks_date_added'] ?> </span>
                                                 <span></span>
                                             </div>
                                             </li>
                                             <?php } ?>

                                             <?php } ?>

                                             <?php } ?>

                                             <?php } else { ?>
                                             <h4 class="text-center text-dark"> No Updates Found. </h4>
                                             <?php } ?>


                                             <!-- <li>
                                                 <span></span>
                                                 <div class="title">Medical Immediate</div>
                                                 <div class="info">Date Added: Sept 5, 2021</div>
                                                 <div class="info">Provided By: OPLE Manila</div>
                                                 <div class="info">Last Updated: Sept 7, 2021</div>
                                                 <div class="info">Status:
                                                     <span class="badge badge-stats">Completed</span>
                                                 </div>
                                                 <div class="time">
                                                     <span>Sept 2, 2021 </span>
                                                     <span>2:12 PM</span>
                                                 </div>
                                             </li>
                                             <li>
                                                 <span></span>
                                                 <div class="info">Your Complain has turned into case.</div>
                                                 <div class="time">
                                                     <span>Sept 1, 2021 </span>
                                                     <span>2:12 PM</span>
                                                 </div>
                                             </li>
                                             <li>
                                                 <span></span>
                                                 <div class="info">Your Complain is <b>For review</b>.</div>
                                                 <div class="time">
                                                     <span>Sept 1, 2021 </span>
                                                     <span>1:33 PM</span>
                                                 </div>
                                             </li>
                                             <li>
                                                 <span></span>
                                                 <div class="info">Your Complain was successfully submitted.</div>
                                                 <div class="time">
                                                     <span>Aug 31, 2021 </span>
                                                     <span>10:30 AM</span>
                                                 </div>
                                             </li>
                                             <li>
                                                 <span></span>
                                                 <div class="title">Legal Service</div>
                                                 <div class="info">Date Added: Sept 5, 2021</div>
                                                 <div class="info">Provided By: OPLE Manila</div>
                                                 <div class="info">Last Updated: Sept 7, 2021</div>
                                                 <div class="info">Status:
                                                     <span class="badge badge-stats">Pending</span>
                                                 </div>
                                                 <div class="time">
                                                     <span>Sept 5, 2021 </span>
                                                     <span>5:30 PM</span>
                                                 </div>
                                             </li>
                                             <li>
                                                 <span></span>
                                                 <div class="info">Your Complain is <b>For review</b>.</div>
                                                 <div class="time">
                                                     <span>Sept 1, 2021 </span>
                                                     <span>1:33 PM</span>
                                                 </div>
                                             </li>
                                             <li>
                                                 <span></span>
                                                 <div class="info">Your Complain was successfully submitted.</div>
                                                 <div class="time">
                                                     <span>Aug 31, 2021 </span>
                                                     <span>10:30 AM</span>
                                                 </div>
                                             </li> -->
                                         </ul>

                                         <!-- <script src="JavaScript/timeline-V2.js"></script> -->
                                     </div>
                                 </div>


                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>

 </body>

 </html>

 <!------------ Add Services Modal ------------->
 <div class="modal fade" id="mdl-view_notes" role="dialog" data-backdrop="static">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title  msgmodal-header modal-header_title "> Notes</h5>
             </div>

             <table width="100%;">
                 <thead class="col-header">
                     <tr>
                         <th>Date Modified</th>
                         <th>Tagged Agency</th>
                         <th>Service Status</th>
                         <th>Action</th>
                     </tr>
                 </thead>
                 <tbody>
                     <tr>
                         <td>
                             <span class="">SEP 11, 2021</span>
                         </td>
                         <td>
                             <span class="">
                                 Browsers can use these elements to enable scrolling of the table body independently of
                                 the header and footer. Also, when printing a large table that spans multiple pages,
                                 these elements can enable the table header and footer to be printed at the top and
                                 bottom of each page
                             </span>
                         </td>
                     </tr>
                 </tbody>
             </table>
         </div>
     </div>
 </div>

 <!-- Modal -->
 <div class="modal fade" id="mdl-set_notif" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 ...
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                 <button type="button" class="btn btn-primary">Save changes</button>
             </div>
         </div>
     </div>
 </div>