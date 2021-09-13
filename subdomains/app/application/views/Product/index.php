<?php
$managePage = 'Manage Product';
$addPage = base_url() . "Product/index/";
$deletePage = base_url() . "Product/delete/";
$deleteCompanyPage = base_url() . "Product/deleteCompany/";
$mainPage = base_url() . "Product/";
$editCompany = base_url() . "Product/editCompany/";
$pageSaveProduct = base_url() . "Product/saveProduct/";
$pageSaveCompany = base_url() . "Product/saveCompany/";
$pageBack = base_url() . "Product/";
$operation = "Add Product";
$val_min_stock = 0;
$val_sale_price = 0;
$val_prod_vol = 0;
// --------------------- Edit -----------------------//
if ($productid != "" && $productid > 0) {
    $operation = "Edit Product";
    $val_cid = $product->company;
    $val_product = $product->product;
    $val_prod_vol = $product->prod_vol;
    $val_prod_unit = $product->prod_unit;
    $val_sale_price = $product->sale_price;
    $val_min_stock = $product->minstock;
}
if ($companyid != "" && $companyid > 0) {
    $val_company = $company->company;
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
                <div class="admin-panels fade-onload">
                    <?php alertbox(); ?>

                    <div class="row">
                        <?php if ($productid != -1) { ?>
                            <div class="col-lg-4 col-sm-12">
                                <div class="admin-form theme-primary">

                                    <div class="panel heading-border panel-primary">
                                        <div class="panel-body bg-light">
                                            <?php echo form_open($pageSaveProduct, ['name' => 'frm1', 'id' => 'customform',  'enctype' => 'multipart/form-data', 'class' => 'stdform']); ?>
                                            <div class="section-divider mb40" id="spy1">
                                                <span><?= $operation; ?></span>
                                            </div>
                                            <input type="hidden" name="id" value="<?= $productid ?>">
                                            <?php
                                                $auto = "";
                                                if ($operation == "Edit Product") {
                                                    $auto = "autofocus";
                                                }
                                                dropdownbox("Company", "catid", $complist, $val_cid, 'required ' . $auto);
                                                editbox("Product Name", "productname", "Enter Product Name", $val_product, 'required');
                                                numberbox("Selling Price", "saleprice", "Enter Selling Price", $val_sale_price, 'required');
                                                numberbox("Minimum Stock", "min_stock", "Enter Minimum Stock", $val_min_stock, 'required');
                                                numberbox("Volume", "prodvol", "Enter Volume", $val_prod_vol, 'required');
                                                $unitlist = array("ml" => "ML", "l" => "L", "mg" => "MG", "gram" => "Gram",);
                                                dropdownbox("Unit Type", "produnit", $unitlist, $val_prod_unit);
                                                ?>
                                            <div class="panel-footer">
                                                <?php submitbutton($pageBack); ?>
                                            </div>
                                            <?php echo form_close(); ?>
                                        </div>
                                    </div>
                                </div>


                            </div>
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
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Min Qty</th>
                                                <th style="width: 20%;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (count($productlist)) : ?>
                                                <?php
                                                        $i = 0;
                                                        $i = $page;
                                                        foreach ($productlist as $post) : $i++;
                                                            ?>
                                                    <tr>
                                                        <td>
                                                            <?= $i ?>
                                                        </td>
                                                        <td>
                                                            <?= $post->prodname; ?>
                                                        </td>
                                                        <td>
                                                            &#8377; <?= $post->sale_price; ?>
                                                        </td>
                                                        <td>
                                                            <?= $post->minstock; ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                                        if (check_role_assigned('product', 'edit')) {

                                                                            echo anchor($addPage . $post->id, '<span class="fa fa-edit" style="valign:center"></span>', ['class' => 'label label-success', 'style' => 'float:left;margin-right:5px;']);
                                                                        }
                                                                        if (check_role_assigned('product', 'delete')) {
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

                        <?php }

                        if ($companyid != -1) { ?>
                            <div class="col-lg-8 col-sm-12">
                                <div class="mt20" id="spy2">
                                    <div class="panel-heading">
                                        <div class="panel-title hidden-xs">
                                            <span class="fa fa-group"></span>
                                            Manage Company
                                        </div>
                                    </div>
                                    <div class="panel-body bg-white">
                                        <?php echo form_open($pageSaveCompany, ['name' => 'frm1', 'id' => 'customform',  'enctype' => 'multipart/form-data', 'class' => 'stdform']); ?>

                                        <input type="hidden" name="id" value="<?= $companyid ?>">
                                        <input type="text" name="comp_name" id="comp_name" class="form-control" placeholder="Enter Company Name" value="<?= $val_company; ?>" autocomplete="off" style="float:left; width:75%; margin-right:3%" required>
                                        <input type="submit" class="btn btn-primary btn-xs" value="Save" style="float:left; width:20%; padding:9px;">
                                        <?php echo form_close(); ?>
                                    </div>

                                    <table class="table table-striped table-hover  table-responsive" id="datatable3" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Sr.</th>
                                                <th>Company</th>
                                                <th style="width: 20%;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (count($companylist)) : ?>
                                                <?php
                                                        $i = 0;
                                                        $i = $page;
                                                        foreach ($companylist as $post) : $i++;

                                                            ?>
                                                    <tr>
                                                        <td>
                                                            <?= $i ?>
                                                        </td>
                                                        <td>
                                                            <?= $post->company; ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                                        if (check_role_assigned('product', 'edit')) {

                                                                            echo anchor($editCompany . $post->id, '<span class="fa fa-edit" style="valign:center"></span>', ['class' => 'label label-success', 'style' => 'float:left;margin-right:5px;']);
                                                                        }
                                                                        if (check_role_assigned('product', 'delete')) {
                                                                            echo form_open($deleteCompanyPage . $post->id, [
                                                                                'id' => 'fdc' . $post->id,
                                                                                'style' => 'float:left;margin-right:5px;'
                                                                            ]);
                                                                            echo '<a href="#" onclick="javascript:deleteCompanyBox(' . $post->id . ')" class="label label-danger cancel" ><span class="fa fa-close"></span></a>';
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

                        <?php } ?>

                    </div>
                </div>
            </section>
            <input type="hidden" name="delid" id="delid" value="0">
            <div id='myModal' class='modal'>
                <div class="modal-dialog panel  panel-default panel-border top">
                    <div class="modal-content">
                        <div id='myModalContent'></div>
                    </div>
                </div>

            </div>
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
                // dom: "Bfrtip",
                // dom: "rtip",
                "order": [],
                dom: '<"top"fl>rt<"bottom"ip>'
                // select: true
            });
            $('#datatable3').dataTable({
                // dom: "Bfrtip",
                // dom: "rtip",
                "order": [],
                dom: '<"top"fl>rt<"bottom"ip>'
                // select: true
            });

            $('#datatable4').dataTable({
                // dom: "Bfrtip",
                // dom: "rtip",
                "order": [],
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
    <script type="text/javascript">
        function deleteBox(frmname) {
            $("#delid").val(frmname);
        }

        function deleteCompanyBox(frmname) {
            $("#delid").val('c' + frmname);
        }

        function deleteCategoryBox(frmname) {
            $("#delid").val('ct' + frmname);
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