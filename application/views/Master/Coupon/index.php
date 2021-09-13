<?php
$managePage = 'Manage Coupon';
$addPage = base_url() . "Master/Coupon/add/";
$deletePage = base_url() . "Master/Coupon/delete/";
$mainPage = base_url() . "Master/Coupon/";
$pageBack = base_url() . "Master/Coupon/";
// --------------------- Edit -----------------------//

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

                        <div class="col-lg-12 col-sm-12">
                            <div class="" id="spy2">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <span class="fa fa-group"></span>
                                        <?= $managePage; ?>
                                        <button class="btn btn-primary btn-sm pull-right mt5" onclick="window.location.href='<?= $addPage ?>'"> <i class="ti-plus"></i> Add Coupon</button>
                                    </div>

                                </div>

                                <table class="table table-striped table-hover" id="datatable2" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Coupon Code</th>
                                            <th>Discount</th>
                                            <th>Minimum Bill Amount</th>
                                            <th>Maximum Discount</th>
                                            <th>Valid Till</th>
                                            <th>Description</th>
                                            <th>Coupons per user</th>
                                            <th style="width: 20%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($couponlist)) : ?>
                                            <?php
                                                $i = 0;
                                                $i = $page;
                                                foreach ($couponlist as $post) : $i++;

                                                    $valid_till = "";
                                                    if ($post->valid_till != "0000-00-00") {
                                                        $date = new DateTime($post->valid_till);
                                                        $valid_till = $date->format('d-m-Y');
                                                    }
                                                    $distype = " Fixed Amount";
                                                    if ($post->dis_type == 2) {
                                                        $distype = "%";
                                                    }

                                                    ?>
                                                <tr>
                                                    <td>
                                                        <?= $post->coupon_code; ?>
                                                    </td>

                                                    <td>
                                                        <?= $post->discount . "" . $distype; ?>
                                                    </td>
                                                    <td>
                                                        <?= $post->min_dis_amt; ?>
                                                    </td>
                                                    <td>
                                                        <?= $post->max_dis_amt; ?>
                                                    </td>

                                                    <td>
                                                        <?= $valid_till; ?>
                                                    </td>
                                                    <td>
                                                        <?= $post->description; ?>
                                                    </td>
                                                    <td>
                                                        <?= $post->peruser; ?>
                                                    </td>

                                                    <td>
                                                        <?php
                                                                if (check_role_assigned('coupon', 'edit')) {

                                                                    echo anchor($addPage . $post->id, '<span class="fa fa-edit" style="valign:center"></span>', ['class' => 'label label-success', 'style' => 'float:left;margin-right:5px;']);
                                                                }

                                                                if (check_role_assigned('coupon', 'delete')) {
                                                                    echo form_open($deletePage . $post->id, [
                                                                        'id' => 'fd' . $post->id,
                                                                        'style' => 'float:left;margin-right:5px;'
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