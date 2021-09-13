<?php
$mainPage = base_url() . "Report/Enquiry/";

$ses_source = $this->session->userdata['enquiryreport']['source'];
$ses_start = $this->session->userdata['enquiryreport']['start'];
$ses_end = $this->session->userdata['enquiryreport']['end'];
$managePage = "Enquiry Report";
?>
<!DOCTYPE html>
<html>

<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <title><?= $managePage ?></title>
    <?php $this->load->view("Includes/head.php"); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js">
    <style>
        div.dataTables_wrapper .dt-buttons .btn-danger {
            background-color: #e5391d !important;
        }

        div.dataTables_wrapper .dt-buttons .btn-success {
            background-color: #56c046 !important;
        }


        div.dataTables_wrapper .dt-buttons .btn-primary {
            background-color: #4a89dc !important;
        }
    </style>
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
                            <?= $managePage; ?>
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
                                dropdownbox("Lead Of Source", "source", $sourcelist, $ses_source);
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
                    <div class="col-lg-9 col-md-9">
                        <!-- Task Widget -->
                        <div class="panel panel-default panel-border top" id="sp2">
                            <div class="panel-heading cursor">
                                <span class="panel-icon">
                                    <i class="fa fa-cog"></i>
                                </span>
                                <span class="panel-title"><?= $managePage; ?></span>
                            </div>
                            <table class="table table-striped table-hover" id="report" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Enquiry for</th>
                                        <th>Lead type</th>
                                        <th>Source</th>
                                        <th>Date to Follow</th>
                                        <th>Status</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    foreach ($enquirylist as $post) {
                                        $date = new DateTime($post->date);
                                        $enquirydate = $date->format('d/m/Y');


                                        ?>
                                        <tr>
                                            <td>
                                                <?= $post->customername; ?>
                                                <br>
                                                <a href="tel:<?= $post->mobile; ?>"><?= $post->mobile; ?></a>
                                            </td>
                                            <td>
                                                <?= $post->enquiryfor; ?>
                                            </td>
                                            <td>
                                                <?= $post->type; ?>
                                            </td>
                                            <td>
                                                <?= $post->leadsource; ?>
                                            </td>
                                            <td>
                                                <?= $enquirydate; ?>
                                            </td>
                                            <td>
                                                <?php if ($post->leadstatus == 0) {
                                                        echo "Pending";
                                                    } else if ($post->leadstatus == 1) {
                                                        echo "Converted";
                                                    } else if ($post->leadstatus == 2) {
                                                        echo "Close";
                                                    }; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

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
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"> </script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"> </script>

    <script type="text/javascript">
        jQuery(document).ready(function() {
            "use strict";
            // Init Theme Core      
            Core.init();


            $('#report').dataTable({
                dom: "Bfrtip",
                // dom: "rtip",
                order: [],
                "scrollY":        "420px",
                "scrollCollapse": true,
                "paging":         false,
                "scrollX": true,
                buttons: [{
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o"></i> Excel',
                        titleAttr: 'Excel',
                        title: 'Services Report',
                        className: 'button btn btn-success btn-sm',
                        footer: true
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa fa-file-pdf-o"></i> Pdf',
                        titleAttr: 'PDF',
                        title: 'Services Report',
                        className: 'button btn btn-danger',
                        footer: true
                    }
                ]
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