<?php
$mainPage = base_url() . "Report/General/";
$ses_userid = $this->session->userdata['generalreport']['userid'];
$ses_start = $this->session->userdata['generalreport']['start'];
$ses_end = $this->session->userdata['generalreport']['end'];
?>
<!DOCTYPE html>
<html>

<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <title>General Report</title>
    <?php $this->load->view("Includes/head.php"); ?>
</head>

<body class="dashboard-page sb-l-o sb-l-m">
    <!-- Start: Main -->
    <div id="main">
        <!-- Start: Header -->
        <?php $this->load->view("Includes/header"); ?>

        <!-- End: Header -->

        <!-- Start: Content-Wrapper -->
        <section id="content_wrapper">
            <!-- Start: Topbar -->
            <header id="topbar">
                <div class="topbar-left">
                    <ol class="breadcrumb">
                        <li class="crumb-active">
                            <a href="index.php">
                                Home
                                <span class="glyphicon glyphicon-home"></span>
                            </a>
                        </li>
                        <li>
                            General Report
                        </li>
                    </ol>
                </div>
            </header>
            <!-- End: Topbar -->

            <!-- Begin: Content -->
            <section id="content" class="animated fadeIn ">
                

                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <div class="panel panel-default panel-border top">
                            <?php echo form_open($mainPage, ['name' => 'frm1', 'enctype' => 'multipart/form-data', 'class' => 'stdform']); ?>
                            <div class="panel-heading cursor">
                                <span class="panel-icon">
                                    <i class="fa fa-cog"></i>
                                </span>
                                <span class="panel-title"> Search Report</span>
                            </div>
                            <div class="panel-body admin-form">

                                <?php
                                datepicker("Start Date", "start", "Enter Start Date", $ses_start);
                                datepicker("End Date", "end", "Enter End Date", $ses_end);
                                echo submitbutton($pageBack);
                                ?>
                            </div>
                            <div class="panel-footer">
                                <?php  ?>
                            </div>
                            <?php form_close(); ?>
                        </div>
                    </div>
                    <!-- Task Widget -->
                    <div class="col-lg-9 col-sm-9">
                        <!-- Task Widget -->
                        <div class="panel panel-default panel-border top" id="sp2">
                            <div class="panel-heading cursor">
                                <span class="panel-icon">
                                    <i class="fa fa-cog"></i>
                                </span>
                                <span class="panel-title">General Report</span>
                            </div>
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Criteria</th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Total Customers</th>
                                        <th><?= $total_customers; ?></th>
                                    </tr>
                                    <tr>
                                        <th>New Customers</th>
                                        <th><?= $total_new_customers; ?></th>
                                    </tr>
                                    <tr style="border-top:5px solid #ececec; ">
                                        <th>Total Sales</th>
                                        <th><?= $total_sales; ?></th>
                                    </tr>
                                    <tr>
                                        <th>Product Sales</th>
                                        <th><?= $total_product_sales; ?></th>
                                    </tr>
                                    <tr>
                                        <th>Service Sales</th>
                                        <th><?= $total_service_sales; ?></th>
                                    </tr>
                                    <tr>
                                        <th>Package Sales</th>
                                        <th><?= $total_package_sales; ?></th>
                                    </tr>
                                    <tr>
                                        <th>Discount Given</th>
                                        <th><?= $total_discount; ?></th>
                                    </tr>

                                    <tr>
                                        <th>Final Amount After Discount</th>
                                        <th><?= $total_amount; ?></th>
                                    </tr>
                                    <tr style="border-top:5px solid #ececec; ">
                                        <th>Wallet Amount Used</th>
                                        <th><?= $wallet_amount; ?></th>
                                    </tr>
                                    <tr>
                                        <th>Payment Collection</th>
                                        <th><?= $total_payment; ?></th>
                                    </tr>

                                    <tr style="border-top:3px solid #ececec;">
                                        <th>Cash Collection</th>
                                        <th><?= $total_cash; ?></th>
                                    </tr>
                                    <tr>
                                        <th>Credit/Debit Card Sales</th>
                                        <th><?= $total_crdb; ?></th>
                                    </tr>
                                    <tr>
                                        <th>Mobile Wallet Sales</th>
                                        <th><?= $total_wallet; ?></th>
                                    </tr>
                                    <tr style="border-top:5px solid #ececec; ">
                                        <th>Purchase Done</th>
                                        <th><?= $total_purchase; ?></th>
                                    </tr>
                                    <tr>
                                        <th>Expense Done</th>
                                        <th><?= $total_expense; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Software Wallet Income</th>
                                        <th><?= $total_soft_wallet; ?></th>
                                    </tr>
                                    <tr style="border-top:5px solid #ececec; ">
                                        <th>Total Profit</th>
                                        <th><?= $total_soft_wallet . " + " . $total_payment . " - " . $total_purchase . " - " . $total_expense . " = " . ($total_soft_wallet + $total_payment - $total_purchase - $total_expense); ?></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </section>

            <!-- End: Content -->
            <?php $this->load->view("Includes/footer"); ?>
        </section>
        <!-- End: Content-Wrapper -->
    </div>
    <!-- End: Main -->

 

    <!-- BEGIN: PAGE SCRIPTS -->

    <!-- jQuery -->
    <?php $this->load->view("Includes/footerscript"); ?>

    <script type="text/javascript">
        jQuery(document).ready(function() {
            "use strict";
            // Init Theme Core      
            Core.init();


            $('#customers').dataTable({
                // dom: "Bfrtip",
                // dom: "rtip",
                order: [],
                "scrollX": true,
                dom: '<"top"fl>rt<"bottom"ip>'
                // select: true
            });

            // Init Admin Panels on widgets inside the ".admin-panels" container
            $('.admin-panels').adminpanel({
                grid: '.admin-grid',
                draggable: true,
                preserveGrid: true,
                mobile: false,
                onStart: function() {
                    // Do something before AdminPanels runs
                },
                onFinish: function() {
                    $('.admin-panels').addClass('animated fadeIn').removeClass('fade-onload');

                    // Init the rest of the plugins now that the panels
                    // have had a chance to be moved and organized.
                    // It's less taxing to organize empty panels
                    setTimeout(function() {

                    }, 300)

                },
                onSave: function() {
                    $(window).trigger('resize');
                }
            });
        });
    </script>

</body>

</html>