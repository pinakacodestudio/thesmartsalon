<?php
$managePage = 'Manage Treatment';
$addPage = base_url() . "Master/Treatment/index/";
$deletePage = base_url() . "Master/Treatment/delete/";
$mainPage = base_url() . "Master/Treatment/";
$pageSave = base_url() . "Master/Treatment/save/";
$pageBack = base_url() . "Master/Treatment/";
$operation = "Add Treatment";
// --------------------- Edit -----------------------//
$val_priority = 0;
$val_price = 0;
$val_duration = 0;
if ($id != "" && $id != 0) {
    $operation = "Edit Treatment";
    $val_treatment = $treatment->treatment;
    $val_price = $treatment->price;
    $val_priority = $treatment->priority;
    $val_gender = $treatment->gender;
    $val_duration = $treatment->duration;
    $val_cid =  $treatment->cid;
    $val_managername =  $treatment->managerid;
    if ($val_gender == 1) {
        $val_gender = "checked";
    } else if ($val_gender == 0) {
        $val_gender = "";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
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
        <?php $this->load->view("Includes/header.php"); ?>
        <!-- Start: Content-Wrapper -->
        <section id="content_wrapper">
            <!-- Start: Topbar -->
            <header id="topbar">
                <div class="topbar-left">
                    <ol class="breadcrumb">
                        <li class="crumb-active">
                            <a href="<?= base_url('Dashboard') ?>">
                                Home
                                <span class="glyphicon glyphicon-home"></span>
                            </a>
                        </li>
                        <li class="crumb-trail">
                            <?= $managePage; ?>
                        </li>
                    </ol>
                </div>
            </header>

            <!-- End: Topbar -->
            <section id="content" class="animated fadeIn">
                <!-- Admin-panels -->
                <div class="admin-panels fade-onload">

                    <div class="row">
                        <div class="col-lg-8 col-sm-12">
                            <div class="" id="spy2">
                                <div class="panel-heading">
                                    <div class="panel-title hidden-xs">
                                        <span class="fa fa-group"></span>
                                        <?= $managePage; ?>
                                    </div>
                                </div>

                                <table class="table table-striped table-hover  table-responsive" id="datatable2" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Sr.</th>
                                            <th>Treatment Name</th>
                                            <th>Price</th>
                                            <th>Duration (in Mins)</th>
                                            <th>Gender</th>
                                            <th>Priority</th>
                                            <th style="width: 20%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($treatmentlist)) : ?>
                                            <?php
                                                $i = 0;
                                                $i = $page;
                                                foreach ($treatmentlist as $post) : $i++;
                                                    $gender = "Male";
                                                    if ($post->gender == 0) {
                                                        $gender = "Female";
                                                    }
                                                    ?>
                                                <tr>
                                                    <td>
                                                        <?= $i ?>
                                                    </td>
                                                    <td>
                                                        <?= $post->treatment; ?>
                                                    </td>
                                                    <td>
                                                        <?= $post->price; ?>
                                                    </td>
                                                    <td>
                                                        <?= $post->duration;   ?>
                                                    </td>
                                                    <td>
                                                        <?= $gender;   ?>
                                                    </td>
                                                    <td>
                                                        <?= $post->priority; ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                                if (check_role_assigned('treatment', 'edit')) {

                                                                    echo anchor($addPage . $post->id, '<span class="fa fa-edit" style="valign:center"></span>', ['class' => 'label label-success', 'style' => 'float:left;margin-right:5px;']);
                                                                }
                                                                if (check_role_assigned('treatment', 'delete')) {
                                                                    echo form_open($deletePage . $post->id, [
                                                                        'id' => 'fd' . $post->id,
                                                                        'style' => 'float:left;margin-right:px;'
                                                                    ]);
                                                                    echo '<a href="#" onclick="javascript:deleteBox(' . $post->id . ')" class="label label-danger cancel" ><span class="fa fa-close"></span></a>';
                                                                    echo form_close();
                                                                }

                                                                ?>

                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
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
                                            <span><?= $operation; ?></span>
                                        </div>
                                        <input type="hidden" name="id" value="<?= $id ?>">
                                        <?php
                                        $auto = "";
                                        if ($operation == "Edit Treatment") {
                                            $auto = "autofocus";
                                        }
                                        editbox("Treatment Name", "treat", "Enter Treatment Name", $val_treatment, 'required ' . $auto);
                                        numberbox("Price", "charges", "Enter Price", $val_price, 'required');
                                        numberbox("Duration ( in Mins )", "durat", "Enter Duration in Mins", $val_duration, 'required');
                                        editbox("Priority", "prior", "Enter Priority", $val_priority, 'required');
                                        if ($this->session->userdata['logged_in']['user_type'] < 3) :
                                            dropdownbox('Manager Name', 'managername', $managername, $val_managername, 'required');
                                        endif;

                                        ?>
                                        <div class="section">
                                            <label class="switch block mt15 switch-primary">
                                                <input type="checkbox" name="gender" id="gender" value="1" <?= $val_gender; ?>>
                                                <label for="gender" data-on="M" data-off="F"></label>
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
                </div>
            </section>
            <input type="hidden" name="delid" id="delid" value="0">

            <!-- Begin: Page Footer -->
            <?php $this->load->view("Includes/footer"); ?>
            <!-- End: Page Footer -->
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

            $('#datatable2').dataTable({
                order: [],
                "scrollY":        "420px",
                "scrollCollapse": true,
                "paging":         false,
                "scrollX": true,
                dom: '<"top"fl>rt<"bottom"ip>'
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
    <script type="text/javascript">
        function deleteBox(frmname) {
            $("#delid").val(frmname);
        }

        $('.cancel').click(function(e) {
            e.preventDefault();

            var delid = $("#delid").val();
            swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this Records!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm) {
                    if (isConfirm) {

                        $("#fd" + delid).submit();

                    } else {
                        swal({
                            title: "Cancelled",
                            text: "Your Records are safe :)",
                            type: "error",
                            confirmButtonClass: "btn-danger"
                        });
                    }
                });

        });
    </script>
    <!-- END: PAGE SCRIPTS -->

</body>

</html>