<?php
$mainPage = base_url() . "Profile/index/";
$ses_start = $this->session->userdata['profile']['start'];
$ses_end = $this->session->userdata['profile']['end'];
?>
<!DOCTYPE html>
<html>

<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <title>Profile Report</title>
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
                            Profile - <?= $this->session->userdata['logged_in']['username']; ?>
                        </li>
                    </ol>
                </div>
            </header>
            <!-- End: Topbar -->

            <!-- Begin: Content -->
            <section id="content" class="animated fadeIn ">
                <?php alertbox(); ?>

                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <div class="panel panel-default panel-border top">
                            <?php echo form_open($mainPage, ['name' => 'frm1', 'onsubmit' => 'return onSubmitBox()', 'enctype' => 'multipart/form-data', 'class' => 'stdform']); ?>
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
                    <div class="col-lg-8 col-sm-12">
                        <!-- Task Widget -->
                        <div class="panel panel-default panel-border top" id="sp2">
                            <div class="panel-heading cursor">
                                <span class="panel-icon">
                                    <i class="fa fa-cog"></i>
                                </span>
                                <span class="panel-title">Profile Report</span>
                            </div>
                            <table class="table table-striped table-hover" id="customers">
                                <thead>
                                    <tr>
                                        <th>Criteria</th>
                                        <th>Value</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Total Customer</td>
                                        <td><?= $total_customers; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total New Customer</td>
                                        <td><?= $total_new_customers; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Income</td>
                                        <td><?= $total_income; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Discount</td>
                                        <td><?= $total_discount; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Pending Customer</td>
                                        <td><?= $total_pending_customers; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Pending Amount</td>
                                        <td><?= $total_pending_amount; ?></td>
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

    <div id='myModal' class='modal'>
        <div class="modal-dialog panel  panel-default panel-border top">
            <div class="modal-content">
                <div id='myModalContent'></div>
            </div>
        </div>

    </div>

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
                dom: '<"top"fl>rt<"bottom"ip>'
                // select: true
            });


            // Form Validation code
            $("#customform").validate({
                /* @validation states + elements 
                ------------------------------------------- */
                errorClass: "state-error",
                validClass: "state-success",
                errorElement: "em",
                rules: {
                    fname: {
                        required: true
                    },
                    lname: {
                        required: true
                    },
                    mobile: {
                        required: true,
                        number: true,
                        minlength: 10,
                        maxlength: 10,
                    }

                },
                /* @validation error messages 
                ---------------------------------------------- */
                messages: {
                    fname: {
                        required: 'Enter First Name'
                    },
                    lname: {
                        required: 'Enter Last Name'
                    },
                    customer_phone: {
                        required: 'Enter Mobile No.',
                        minlength: 'Minimum Length 10',
                        maxlength: 'Maximum Length 10'

                    }
                },
                /* @validation highlighting + error placement  
                ---------------------------------------------------- */

                highlight: function(element, errorClass, validClass) {
                    $(element).closest('.field').addClass(errorClass).removeClass(validClass);
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).closest('.field').removeClass(errorClass).addClass(validClass);
                },
                errorPlacement: function(error, element) {
                    if (element.is(":radio") || element.is(":checkbox")) {
                        element.closest('.option-group').after(error);
                    } else {
                        error.insertAfter(element.parent());
                    }
                }
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