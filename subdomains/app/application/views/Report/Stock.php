<?php
$mainPage = base_url() . "Report/Stock/";
$ses_compid = $this->session->userdata['stockreport']['compid'];
$ses_start = $this->session->userdata['stockreport']['start'];
$ses_end = $this->session->userdata['stockreport']['end'];
$managePage = "Stock Report";
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
                <?php alertbox(); ?>

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
                                dropdownbox("Company", "comp", $complist, $ses_compid);
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
                            <table class="table table-striped table-hover" id="report">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Current Stock</th>
                                        <th>Minimum Stock</th>
                                        <th>Status</th>
                                        <th>Sale Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($stocklist as $post) {
                                        $stocktype = '<span class="label label-success label-sm"> In Stock </span>';
                                        if ($post->currentstock == 0) {
                                            $stocktype = '<span class="label label-danger label-sm"> Out of Stock </span>';
                                        } else if ($post->currentstock < $post->minstock) {
                                            $stocktype = '<span class="label label-warning label-sm"> Low Stock </span>';
                                        }
                                        ?>
                                        <tr>
                                            <td><?= $post->prodname; ?></td>
                                            <td><?= $post->currentstock; ?></td>
                                            <td><?= $post->minstock; ?></td>
                                            <td><?= $stocktype; ?></td>
                                            <td><?= $post->sale_price; ?></td>

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
                "order": [
                    [3, "desc"]
                ],
                buttons: [{
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o"></i> Excel',
                        titleAttr: 'Excel',
                        title: 'Invoices Bill Report',
                        className: 'button btn btn-success btn-sm',
                        footer: true
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa fa-file-pdf-o"></i> Pdf',
                        titleAttr: 'PDF',
                        title: 'Invoices Bill Report',
                        className: 'button btn btn-danger',
                        footer: true
                    }
                ]
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