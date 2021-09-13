<?php
$managePage = 'Customer Wallet ';
$mainPage = base_url() . "CustomerWallet/";
$editPage = base_url() . "CustomerWallet/index/";
$savePage = base_url() . "CustomerWallet/save/";
$deletePage = base_url() . "CustomerWallet/delete/";
$operation = "Add  Customer Wallet";
// --------------------- Edit -----------------------// 
$id = $wallet->id;
if ($id != "" && $id != 0) {
    $operation = "Edit Customer Wallet ";
    $val_wallet_amt = $wallet->w_amt;
    $val_customername = $wallet->custid;
    $val_actual_amt = $wallet->actual_amt;
    $val_desc = $wallet->description;
}

?>
<!DOCTYPE html>
<html>

<head>
    <?php $this->load->view("Includes/head.php"); ?>
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

                <div class="row">
                    <div class="col-lg-4 col-sm-12">
                        <div class="admin-form theme-primary">

                            <div class="panel heading-border panel-primary">
                                <div class="panel-body bg-light">
                                    <?php echo form_open($savePage, ['name' => 'frm1', 'id' => 'customform',  'enctype' => 'multipart/form-data', 'class' => 'stdform']); ?>
                                    <div class="section-divider mb40" id="spy1">
                                        <span><?= $operation; ?></span>
                                    </div>
                                    <input type="hidden" name="id" value="<?= $id ?>">

                                    <?php
                                    $auto = "";
                                    if ($operation == "Edit Customer Wallet") {
                                        $auto = "autofocus";
                                    }


                                    dropdownbox("Customer Name", "customername", $customerlist, $val_customername, 'required');
                                    numberbox('Actual Amount', 'actual_amt', 'Enter Actual Amount', $val_actual_amt, 'required');
                                    numberbox('Wallet Amount', 'wallet_amt', 'Enter Wallet Amount', $val_wallet_amt, 'required');
                                    editbox("Description", "description", "Enter Description", $val_desc, '');
                                    dropdownbox("Coupon Code", "couponcode", $couponlist, $val_couponid);


                                    submitbutton($pageBack);

                                    ?>

                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 col-md-8  col-sm-12">
                        <div class="panel" id="spy2">
                            <div class="panel-heading">
                                <div class="panel-title hidden-xs">
                                    <span class="fa fa-group"></span>
                                    Customer Wallet Details
                                </div>
                            </div>

                            <table class="table table-striped table-hover" id="datatable2" style="width:100%; ">
                                <thead>
                                    <tr>
                                        <th>Cusotmer Name</th>
                                        <th>Wallet Amount</th>
                                        <th>Actual Amount</th>
                                        <th>Coupon (If any)</th>
                                        <th>Description</th>
                                        <th style="width: 20%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($walletlist)) : ?>
                                        <?php
                                            $i = 0;
                                            $i = $page;
                                            foreach ($walletlist as $post) : $i++;
                                                ?>
                                            <tr>
                                                <td>
                                                    <?= $post->fname . " " . $post->lname ?>
                                                </td>
                                                <td>
                                                    <?= $post->w_amt ?>
                                                </td>
                                                <td>
                                                    <?= $post->actual_amt ?>
                                                </td>
                                                <td>
                                                    <?= $post->couponcode; ?>
                                                </td>
                                                <td>
                                                    <?= $post->description; ?>
                                                </td>
                                                <td>
                                                    <?php
                                                            if (check_role_assigned('customerwallet', 'edit')) {
                                                                echo anchor($editPage . $post->id, '<span class="fa fa-pencil" style="valign:center"></span>', ['class' => 'label label-success', 'style' => 'float:left;margin-right:5px;']);
                                                            }
                                                            if (check_role_assigned('customerwallet', 'delete')) {
                                                                echo form_open($deletePage . $post->id, [
                                                                    'id' => 'fd' . $post->id,
                                                                    'style' => 'float:left;margin-right:5px;'
                                                                ]);
                                                                echo '<a href="#" onclick="javascript:deleteBox(' . $post->id . ')" class="label label-danger cancel" ><span class="fa fa-close"></span></a>';
                                                                echo form_close();
                                                            }
                                                            ?>


                                                </td>
                                                </ul>
                        </div>


                        </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
                </table>

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

    <script>
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