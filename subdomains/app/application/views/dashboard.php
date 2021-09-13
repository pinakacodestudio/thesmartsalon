<?php
$pageSave = base_url() . "Dashboard/save/";
$incomePage = base_url() . "Invoice/addInvoice/";
$editCustomer = base_url() . "Customer/index/";

?>
<!DOCTYPE html>
<html>

<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <title>Dashboard</title>
    <?php $this->load->view("Includes/head.php"); ?>
    <style>
        .admin-form .switch>label {
            background: #FF0090;
            border-color: #FF0090;
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
                    </ol>
                </div>
            </header>
            <!-- End: Topbar -->

            <!-- Begin: Content -->
            <section id="content" class="animated fadeIn">
                <?php alertbox(); ?>

                <?php if (check_role_assigned('customer', 'view')) { ?>
                    <div class="row">
                        <!-- Task Widget -->
                        <div class="col-lg-8 col-sm-12">
                            <!-- Task Widget -->
                            <div class="panel" id="sp2">
                                <div class="panel-heading cursor">
                                    <span class="panel-icon">
                                        <i class="fa fa-cog"></i>
                                    </span>
                                    <span class="panel-title"> Customer List</span>
                                </div>
                                <table class="table table-striped table-hover" id="customers">
                                    <thead>
                                        <tr>
                                            <th>Customer</th>
                                            <th>Contact</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($customerlist)) : ?>
                                            <?php
                                                    $i = 0;
                                                    $i = $page;
                                                    foreach ($customerlist as $post) : $i++;
                                                        $blabel = "label-default";
                                                        if ($post->birthdate != "1970-01-01" && $post->birthdate != "0000-00-00") {
                                                            $blabel = "label-success";
                                                        }
                                                        $alabel = "label-default";
                                                        if ($post->anniversary != "1970-01-01" && $post->anniversary != "0000-00-00") {
                                                            $alabel = "label-success";
                                                        }
                                                        ?>
                                                <tr>
                                                    <td><label class="label <?= $blabel; ?> label-xs">B</label> <label class="label <?= $alabel; ?> label-xs">A</label> <b><a href="<?= $editCustomer . $post->id; ?>"><?= $post->fname . " " . $post->lname; ?></a></b> </td>
                                                    <td>
                                                        <a href="tel://<?= $post->mobile; ?>"><?= $post->mobile; ?></a>


                                                        <?php
                                                                    echo anchor($incomePage . $post->id, '<span class="fa fa-edit" style="valign:center"></span>', ['class' => 'label label-success', 'style' => 'margin-left:10px;']);
                                                                    ?>
                                                    </td>
                                                </tr>
                                        <?php endforeach;
                                            endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="admin-form theme-primary">

                                <div class="panel heading-border panel-primary">
                                    <div class="panel-body bg-light">
                                        <?php echo form_open($pageSave, ['name' => 'frm1', 'id' => 'customform',  'enctype' => 'multipart/form-data', 'class' => 'stdform']); ?>
                                        <div class="section-divider mb40" id="spy1">
                                            <span>Add / Edit Customer</span>
                                        </div>
                                        <input type="hidden" name="id" value="<?= $id ?>">
                                        <?php
                                            editbox("Firstname", "first_name", "Enter First Name", $val_fname, 'required');
                                            editbox("Lastname", "last_name", "Enter Last Name", $val_lname, 'required');
                                            editbox("Mobile", "mobileno", "Enter Mobile No.", $val_mobile, 'required pattern="[6789][0-9]{9}"');
                                            datepicker("Birthdate", "cust_birthdate", "Enter Birthdate", $val_birthdate);
                                            datepicker("Anniversary Date", "cust_anniversary", "Enter Anniversary", $val_anniversary);
                                            ?>
                                        <div class="section">
                                            <label class="switch block mt15 switch-primary">
                                                <input type="checkbox" name="checkgender" id="checkgender" value="1" checked>
                                                <label for="checkgender" data-on="M" data-off="F"></label>
                                                <span>Gender</span>
                                            </label>

                                        </div>

                                        <div class="panel-footer">
                                            <?php submitbutton($pageBack); ?>
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

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