<?php
/**
 * Page Security
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<!-- BEGIN PAGE CONTENT BODY -->
<!-- <div class="page-content">

    BEGIN PAGE CONTENT INNER
    <div class="page-content-inner" >
        <div class="div-agency-container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4  px-2">
                    <div class=" card-stats shadow-sm p-3  bg-white rounded" >
                        <div class="row no-gutters case">
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                <p class="stat-header">Total Reports </p>
                                <span class="header-total_case header-count">-</span>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 float-right stats-icon">
                                <i class="fa fa-briefcase dashboard-icon-total" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4  px-2">
                    <div class=" card-stats shadow-sm p-3  bg-white rounded" >
                        <div class="row no-gutters case">
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                <p class="stat-header">TIP Reports</p>
                                <span class="header-tip_case header-count">-</span>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 float-right stats-icon">
                                <i class="fas fa-business-time dashboard-icon-on_going"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4  px-2">
                    <div class=" card-stats shadow-sm p-3  bg-white rounded" >
                        <div class="row no-gutters case">
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                <p class="stat-header">Non TIP Reports</p>
                                <span class="header-non_tip_case header-count">-</span>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 float-right stats-icon">
                                <i class="fa fa-lock dashboard-icon-closed" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 pr-2">
                    <div class=" shadow-sm p-3 bg-white rounded m-l-20  mgn-T-18 h500">
                        <div>
                            <p class="stat-header mb-0">Reports</p>
                            <span class="small text-gray-500 achievement">Recently added reports.</span>
                        </div>
                        <div class="card-nav m-x-0 padding-T-15" >
                            <ul class="nav nav-pills nav-fill card-nav-ul" id="myTab" >

                            </ul>
                            <div class="tab-content" id="myTabContent" >
                                <div class="tab-pane fade show active tab-list-content" id="recent" role="tabpanel" aria-labelledby="recent-case-tab" style=" height: 380px;">
                                    <ul class="div-all  list_content" id="list-recent_cases">
                                    </ul>   
                                </div>
                                <div class="tab-pane fade tab-list-content" id="highPriority" role="tabpanel" aria-labelledby="high-prio-tab">
                                    <ul class="div-all  list_content" id="list-high_priority_cases">
                                    </ul>   
                                </div>
                            </div>
                        </div><br>
                        <a class="dropdown-item text-center small text-gray-500 lvl-ra"  href="<?php echo SITE_URL ?>cases" style="margin-top:44px;">See all Reports</a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 px-2">
                    <div class=" shadow-sm p-3 bg-white rounded m-l-20  mgn-T-18 h500">
                        <div>
                            <p class="stat-header mb-0">Top 5 Agency</p>
                            <span class="small text-gray-500 achievement">Based on most cases updated</span>
                        </div>
                        <div class="card-nav m-x-0 padding-T-15" >

                            <ul class="div-all  list_content list-achievement" id="top-branch_agency">

                            </ul>   
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 px-2">
                    <div class=" shadow-sm p-3 bg-white rounded m-l-20 mgn-T-18 h500">
                        <p class="stat-header">Top Nature of report</p>
                        <div class="card-nav m-x-0 pb-0" >
                            <div class="" >
                                <div id="piegraph" style="position:relative;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 px-2">
                    <div class=" shadow-sm p-3 bg-white rounded m-l-20 mt-3 " >
                        <p class="stat-header">Trafficked Persons per Country</p>
                        <div class="card-nav m-x-0 padding-T-15" >
                            <div class="columnchart" >
                                <div id="columnchart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12 col-sm-12 px-2 float-right">
                    <div class=" shadow-sm p-3 bg-white rounded m-l-20  mt-3">
                        <div>
                            <p class="stat-header">Activity Logs</p>
                        </div>
                        <div id="act-log-container">
                            <div class="card-nav act-logs m-x-0 padding-T-15" id="act-logs-content" datapage="1" datapageend="0">
                                <ul class="div-all list_content" id="list-all_logs">

                                </ul>   
                            </div>
                            <a class="dropdown-item text-center small text-gray-500 lvl-ra lvl-ca lvl-ce lvl-ch"  href="<?php echo SITE_URL ?>activity_logs">View all Activity Logs</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div> -->


<!------##### OSAEC DASHBOARD START #####------>
<div class="page-content">

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner" >
    <div class="div-agency-container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4  px-2">
                <div class=" card-stats shadow-sm p-3  bg-white rounded" >
                    <div class="row no-gutters case">
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <p class="stat-header">Total Reports </p>
                            <span class="header-total_case header-count">-</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 float-right stats-icon">
                            <i class="fa fa-briefcase dashboard-icon-total" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4  px-2">
                <div class=" card-stats shadow-sm p-3  bg-white rounded" >
                    <div class="row no-gutters case">
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <p class="stat-header">TIP Reports</p>
                            <span class="header-tip_case header-count">-</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 float-right stats-icon">
                            <i class="fas fa-business-time dashboard-icon-on_going"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4  px-2">
                <div class=" card-stats shadow-sm p-3  bg-white rounded" >
                    <div class="row no-gutters case">
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <p class="stat-header">Non TIP Reports</p>
                            <span class="header-non_tip_case header-count">-</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 float-right stats-icon">
                            <i class="fa fa-lock dashboard-icon-closed" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12 pr-2">
                <div class=" shadow-sm p-3 bg-white rounded m-l-20  mgn-T-18 h500">
                    <div>
                        <p class="stat-header mb-0">Reports</p>
                        <span class="small text-gray-500 achievement">Recently added reports.</span>
                    </div>
                    <div class="card-nav m-x-0 padding-T-15" >
                        <ul class="nav nav-pills nav-fill card-nav-ul" id="myTab" >

                        </ul>
                        <div class="tab-content" id="myTabContent" >
                            <div class="tab-pane fade show active tab-list-content" id="recent" role="tabpanel" aria-labelledby="recent-case-tab" style=" height: 380px;">
                                <ul class="div-all  list_content" id="list-recent_cases">
                                </ul>   
                            </div>
                            <div class="tab-pane fade tab-list-content" id="highPriority" role="tabpanel" aria-labelledby="high-prio-tab">
                                <ul class="div-all  list_content" id="list-high_priority_cases">
                                </ul>   
                            </div>
                        </div>
                    </div><br>
                    <a class="dropdown-item text-center small text-gray-500 lvl-ra"  href="<?php echo SITE_URL ?>cases" style="margin-top:44px;">See all Reports</a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12 px-2">
                <div class=" shadow-sm p-3 bg-white rounded m-l-20  mgn-T-18 h500">
                    <div>
                        <p class="stat-header mb-0">Top 5 Agency</p>
                        <span class="small text-gray-500 achievement">Based on most cases updated</span>
                    </div>
                    <div class="card-nav m-x-0 padding-T-15" >

                        <ul class="div-all  list_content list-achievement" id="top-branch_agency">

                        </ul>   
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 px-2">
                <div class=" shadow-sm p-3 bg-white rounded m-l-20 mgn-T-18 h500">
                    <p class="stat-header">Top Nature of report</p>
                    <div class="card-nav m-x-0 pb-0" >
                        <div class="" >
                            <div id="piegraph" style="position:relative;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 px-2">
                <div class=" shadow-sm p-3 bg-white rounded m-l-20 mt-3 " >
                    <p class="stat-header">OSAEC Cases Per Region</p>
                    <div class="card-nav m-x-0 padding-T-15" >
                        <div class="columnchart" >
                            <div id="columnchart"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-12 col-sm-12 px-2 float-right">
                <div class=" shadow-sm p-3 bg-white rounded m-l-20  mt-3">
                    <div>
                        <p class="stat-header">Activity Logs</p>
                    </div>
                    <div id="act-log-container">
                        <div class="card-nav act-logs m-x-0 padding-T-15" id="act-logs-content" datapage="1" datapageend="0">
                            <ul class="div-all list_content" id="list-all_logs">

                            </ul>   
                        </div>
                        <a class="dropdown-item text-center small text-gray-500 lvl-ra lvl-ca lvl-ce lvl-ch"  href="<?php echo SITE_URL ?>activity_logs">View all Activity Logs</a>
                    </div>
                </div>
            </div>
        </div>

        <br/>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4  px-2">
                <div class=" card-stats shadow-sm p-3  bg-white rounded" >
                    <div class="row no-gutters case">
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <p class="stat-header">CSEC Reports </p>
                            <span class="header-case_csec header-count">-</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 float-right stats-icon">
                            <i class="fa fa-briefcase dashboard-icon-total" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4  px-2">
                <div class=" card-stats shadow-sm p-3  bg-white rounded" >
                    <div class="row no-gutters case">
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <p class="stat-header">OSAEC Reports</p>
                            <span class="header-case_osaec header-count">-</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 float-right stats-icon">
                            <i class="fas fa-business-time dashboard-icon-on_going"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4  px-2">
                <div class=" card-stats shadow-sm p-3  bg-white rounded" >
                    <div class="row no-gutters case">
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <p class="stat-header">Others Reports</p>
                            <span class="header-case_others header-count">-</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 float-right stats-icon">
                            <i class="fa fa-lock dashboard-icon-closed" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<!------##### OSAEC DASHBOARD END #####------>