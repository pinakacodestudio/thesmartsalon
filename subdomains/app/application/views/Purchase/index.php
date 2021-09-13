<?php
$managePage = 'Purchase From Vendor / Add Stock';
$mainPage = base_url() . "Purchase/";
$editPage = base_url() . "Purchase/index/";
$addPurchasePage = base_url() . "Purchase/addPurchase/";
$saveItemPage = base_url() . "Purchase/savePurchaseData/";
$savePage = base_url() . "Purchase/savePurchase/";
$deletePageItem = base_url() . "Purchase/deleteItem/";
$deletePage = base_url() . "Purchase/delete/";

$val_billdate = date("Y-m-d");

$val_discount = 0;
$val_totalamt = 0;
$val_finalamt = 0;
$val_price = 0;
$val_tax_amt = 0;
$val_shipping_charges = 0;
$val_amount_paid = 0;
$val_amount = 0;
$val_qty = 1;
$val_paid = "checked";
$val_sendmsg = "checked";
$style = "display:none";
$styleadd = "display:block";
if ($id != 0 && is_numeric($id)) {
    $style = "";
    $styleadd = "display:none;";
    $val_billno = $purchase->billno;
    $val_billdate = $purchase->billdate;
    $val_vendorid = $purchase->vendorid;
    $val_totalamt = $purchase->total_amt;
    $val_discount = $purchase->discount_amt;
    $val_tax_amt = $purchase->tax_amt;
    $val_shipping_charges = $purchase->shipping_charges;
    $val_amount_paid = $purchase->amount_paid;
    $val_finalamt = $purchase->final_amt;
    $val_paymod = $purchase->paymod;
}

?>
<!DOCTYPE html>
<html>

<head>
    <?php $this->load->view("Includes/head.php"); ?>
</head>
<style type="text/css">
    .dropdown-menu {
        min-width: auto;
        width: 100%;
        height: auto;
        text-align: center;
        border-radius: 0;
        border-width: 0px;
        margin-top: -1px;
        padding: 0 0;
        max-height: 700px;
        overflow: auto;
    }

    @media(max-width: 770px) {
        .custompanel {
            height: 10%;
        }

    }

    .loadcontainer {
        background: rgba(0, 0, 0, 0.5);
        height: 100%;
        width: 100%;
        z-index: 99999;
        position: absolute;
    }

    .loader {
        position: absolute;
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 120px;
        height: 120px;
        left: 47%;
        top: 45%;
        -webkit-animation: spin 2s linear infinite;
        /* Safari */
        animation: spin 2s linear infinite;
    }

    /* Safari */
    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<body class="dashboard-page sb-l-o sb-l-m">
    <!-- Start: Main -->
    <div class="loadcontainer" style="display:none;">
        <div class="loader"></div>
    </div>
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
                    <div class="col-md-8" id="spy2">
                        <div class="panel  panel-default">
                            <div class="panel-heading custompanel">
                                <b><?= $managePage; ?></b>
                            </div>
                            <div class="clearfix"></div>
                            <div class="panel-body admin-form">
                                <form action="<?= $savePage; ?>" method="post">
                                    <input type="hidden" name="id" id="id" value="<?= $id; ?>">
                                    <input type="hidden" name="finalamt" id="finalamt" value="<?= $val_finalamt; ?>">
                                    <input type="hidden" name="totalamt" id="totalamt" value="<?= $val_totalamt; ?>">
                                    <?php

                                    echo '<div class="col-md-4">';
                                    editbox("Bill No.*", 'billno', 'Enter Bill No.', $val_billno);
                                    echo '</div><div class="col-md-4">';
                                    datepicker("Bill Date*", "billdate", "Enter Bill Date", $val_billdate);
                                    echo '</div><div class="col-md-4">';
                                    dropdownbox("Vendor*", "vendorid", $vendorlist, $val_vendorid);
                                    echo '</div>';
                                    ?>
                                    <div class="col-md-12 mb20">
                                        <button class="btn btn-info btn-sm addPurchase" id="addPurchase" style="<?= $styleadd; ?>"><i class="fa fa-plus"></i> Add Products</button>
                                    </div>
                                    <div class="clearfix"></div>
                                    <table id="producttable" style="width:100%; <?= $style; ?>" class="table table-striped table-bordered mb20">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Qty</th>
                                                <th>Amount</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="addTarget">
                                            <?php
                                            if (count($itemlist)) {
                                                foreach ($itemlist as $post) {
                                                    $date = new DateTime($post->sdate);
                                                    $tdate = $date->format('d/m/Y');

                                                    echo '   <tr id="item_' . $post->id . '">
                                                    <td>' . $post->description . '</td>
                                                    <td>' . $post->price . '</td>
                                                    <td>' . $post->qty . '</td>
                                                    <td>' . $post->amount . '</td>
                                                    <td width="10%">
                                                    <a href="javascript:deleteRecord(' . $post->id . ')" class="btn btn-danger btn-xs" style="margin-top: 1px;"><span class="fa fa-trash"> </span></a></td>
                                                    </tr>';
                                                }
                                            }
                                            ?>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" style="text-align:right;">Total</td>
                                                <td colspan="2" id="tblTotal"><?= $val_totalamt; ?></td>

                                            </tr>
                                        </tfoot>
                                    </table>

                                    <?php
                                    echo '<div class="col-md-4">';
                                    numberbox("Discount", 'discount', 'Enter Discount', $val_discount, 'onblur="javascript:calTotal();"');
                                    echo '</div><div class="col-md-4">';
                                    numberbox("Tax Amount", 'tax', 'Enter Tax Amount', $val_tax_amt, 'onblur="javascript:calTotal();"');
                                    echo '</div><div class="col-md-4">';
                                    numberbox("Shipping Charges", 'shipping', 'Enter Shipping', $val_shipping_charges, 'onblur="javascript:calTotal();"');
                                    echo '</div>';
                                    echo '<div class="col-md-4">';
                                    numberbox("Final Amount", 'finamt', 'Enter Final Amount', $val_finalamt, 'disabled');
                                    echo '</div><div class="col-md-4">';
                                    numberbox("Amount Paid", 'amountpaid', 'Enter Amount Paid', $val_amount_paid);
                                    echo '</div><div class="col-md-4">';
                                    dropdownbox("Payment Mode", "paymod", $paymodlist, $val_paymod);
                                    echo '</div>';
                                    echo '<div class="col-md-12" id="subbox" style="' . $style . '">';
                                    echo submitbutton($mainPage);
                                    echo '</div>';

                                    ?>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel">
                            <div class="panel-heading">
                                <b>Add Product</b>
                            </div>
                            <div class="panel-body">

                                <div class="row">
                                    <div class="col-md-12">
                                        <form action="">
                                            <?php
                                            dropdownbox("Product*", "productdata", $prodlist, $val_product);
                                            numberbox("Product Price*", 'price', 'Enter Product Price', $val_price, 'onblur="javascript:calAmount();"');
                                            numberbox("Product Qty*", 'qty', 'Enter Product Qty', $val_qty, 'onblur="javascript:calAmount();"');
                                            numberbox("Amount*", 'amt', 'Enter Amount', $val_amount, 'disabled');
                                            ?>
                                            <button class="btn btn-info btn-sm addProduct" style="<?= $style; ?>"><i class="fa fa-plus"></i> Add Product</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12  col-sm-12">
                        <div class="panel" id="spy2">
                            <div class="panel-heading">
                                <div class="panel-title hidden-xs">
                                    <span class="fa fa-group"></span>
                                    Purchase Details
                                </div>
                            </div>

                            <table class="table table-striped table-hover table-responsive " id="datatable2" style="width:100%; ">
                                <thead>
                                    <tr>
                                        <th>Vendor Name</th>
                                        <th>Bill No.</th>
                                        <th>Bill Date</th>
                                        <th>Amount</th>
                                        <th>Paymod</th>
                                        <th style="width: 20%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($purchaselist)) : ?>
                                        <?php
                                            $i = 0;
                                            $i = $page;
                                            foreach ($purchaselist as $post) : $i++;

                                                $date = new DateTime($post->billdate);
                                                $billdate = $date->format('d/m/Y');

                                                ?>
                                            <tr>
                                                <td>
                                                    <?= $post->vendor_name; ?>
                                                </td>
                                                <td>
                                                    <?= $post->billno;   ?>
                                                </td>
                                                <td>
                                                    <?= $billdate;   ?>
                                                </td>
                                                <td>
                                                    <?= $post->final_amt; ?>
                                                </td>
                                                <td>
                                                    <?= $post->paymod;   ?>
                                                </td>

                                                <td>
                                                    <?php
                                                            echo form_open($deletePage . $post->id, [
                                                                'id' => 'fd' . $post->id,
                                                                'style' => 'float:left;margin-right:5px;'
                                                            ]);
                                                            ?>


                                                    <?php
                                                            if (check_role_assigned('purchase', 'edit')) {
                                                                ?>
                                                        <a href="<?= $editPage . $post->id; ?>" class=" label label-success label-sm"><span class="fa fa-edit" style="valign:center"></span></a>
                                                        </<a>
                                                    <?php
                                                            }

                                                            if (check_role_assigned('purchase', 'delete')) {
                                                                ?>

                                                        <a href="#" class="cancel label label-danger label-sm" onclick="javascript:deleteBox('<?= $post->id ?>')"><span class="fa fa-close"></span></a>

                                                    <?php
                                                            }
                                                            ?>
                                                    </ul>
                        </div>
                        <?php echo form_close(); ?>

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
            <div id='myModal' class='modal'>
                <div class="modal-dialog panel  panel-default panel-border">
                    <div class="modal-content">
                        <div id='myModalContent'>
                            <div class="modal-body" id='modaltext'>
                                This is a box
                            </div>
                        </div>
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
        <?php if ($id == 0) { ?>

            function disableData() {
                $("#addPurchase").show();
                $("#producttable").hide();
                $("#discount").attr('disabled', 'disabled');
                $("#tax").attr('disabled', 'disabled');
                $("#shipping").attr('disabled', 'disabled');
                $("#amountpaid").attr('disabled', 'disabled');
                $("#paymod").attr('disabled', 'disabled');
                $("#productdata").attr('disabled', 'disabled');
                $("#price").attr('disabled', 'disabled');
                $("#qty").attr('disabled', 'disabled');
                $("#amt").attr('disabled', 'disabled');
                $("#subbox").hide();

            }
        <?php } ?>

        function calTotal() {

            var total = parseInt($("#totalamt").val());
            var discount = parseInt($("#discount").val());
            var tax = parseInt($("#tax").val());
            var charges = parseInt($("#shipping").val());
            total = total + tax + charges;
            $('#finalamt').val(total - discount);
            $('#finamt').val(total - discount);
        }

        function calAmount() {
            var price = parseInt($("#price").val());
            var qty = parseInt($("#qty").val());
            $("#amt").val(price * qty);
        }

        $(document).ready(function() {

            $('.loadcontainer').hide();

            <?php if ($id == 0) { ?>
                disableData();
            <?php } ?>
            $(".addPurchase").click(function(e) {
                e.preventDefault();

                $('.loadcontainer').show();

                var tdate = $('#billdate').val();
                var billno = $('#billno').val();
                var vendor = $("#vendorid option:selected").val();
                if (billno == "") {
                    validBox("Enter Bill No.");
                    $("#billno").focus();
                    return false;
                } else if (vendor == "") {
                    validBox("Select a Vendor");
                    $("#vendorid").focus();
                    return false;
                }

                $.ajax({
                    url: '<?= $addPurchasePage; ?>',
                    data: {
                        billdate: tdate,
                        billno: billno,
                        vendorid: vendor
                    },
                    type: "post",
                    success: function(data) {
                        if (data.status == 1) {
                            $("#id").val(data.billid);
                            $("#addPurchase").hide();
                            $("#producttable").show();
                            $("#discount").removeAttr('disabled');
                            $("#tax").removeAttr('disabled');
                            $("#shipping").removeAttr('disabled');
                            $("#amountpaid").removeAttr('disabled');
                            $("#paymod").removeAttr('disabled');
                            $("#productdata").removeAttr('disabled');
                            $("#price").removeAttr('disabled');
                            $("#qty").removeAttr('disabled');
                            $("#amt").removeAttr('disabled');
                            $("#subbox").show();
                            $(".addProduct").show();
                            $("#productdata").focus();
                            $('.loadcontainer').hide();
                        } else {
                            $('.loadcontainer').hide();
                            alert("Error Submitting Data Try Again!");
                        }
                    }
                });
            });

            $(".addProduct").click(function(e) {
                e.preventDefault();
                $('.loadcontainer').show();
                var product = $("#productdata option:selected").val();
                var id = $("#id").val();
                var price = $('#price').val();
                var qty = $('#qty').val();
                var amt = $('#amt').val();

                if (product == "") {
                    validBox("Select a Product");
                    $("#productdata").focus();
                    return false;
                } else if (price == "0" || price == "") {
                    validBox("Enter Price For Product");
                    $("#price").focus();
                    return false;
                } else if (qty == "0" || qty == "") {
                    validBox("Enter Quantity For Product");
                    $("#qty").focus();
                    return false;
                } else if (amt == "0" || amt == "") {
                    validBox("Enter Amount");
                    $("#amt").focus();
                    return false;
                }


                $.ajax({
                    url: '<?= $saveItemPage; ?>',
                    data: {
                        id: id,
                        product: product,
                        price: price,
                        qty: qty,
                        amt: amt
                    },
                    type: "post",
                    success: function(data) {
                        if (data.status == 1) {
                            $("#totalamt").val(data.total);
                            $("#tblTotal").html(data.total);
                            $("#addTarget").append(data.tabledata);
                            $("#productdata").val(0);
                            $("#price").val(0);
                            $("#qty").val(1);
                            $("#amt").val(0);
                            calTotal();
                            $('.loadcontainer').hide();
                        } else {
                            $('.loadcontainer').hide();
                            alert("Error Submitting Data Try Again!");
                        }
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        function deleteRecord(val) {
            var id = $("#id").val();
            swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this Records!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: true,
                    closeOnCancel: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        $('.loadcontainer').show();
                        $.ajax({
                            url: '<?= $deletePageItem; ?>',
                            data: {
                                id: id,
                                delid: val,
                            },
                            type: "post",
                            success: function(data) {
                                if (data.status == 1) {
                                    $("#item_" + val).remove();
                                    $("#totalamt").val(data.total);
                                    $("#tblTotal").html(data.total);
                                    calTotal();
                                    $('.loadcontainer').hide();
                                }
                            }
                        });

                    } else {
                        swal({
                            title: "Cancelled",
                            text: "Your Records are safe :)",
                            type: "error",
                            confirmButtonClass: "btn-danger"
                        });
                    }
                });
        }
        jQuery(document).ready(function() {
            "use strict";
            // Init Theme Core      
            Core.init();
            $('#datatable2').dataTable({
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

        function validBox(msg) {
            $('.loadcontainer').hide();
            $('#modaltext').html(msg);
            $('#myModal').modal('show');
            setTimeout(function() {
                $('#myModal').modal('hide')
            }, 3000);
        }
    </script>
    <!-- END: PAGE SCRIPTS -->

</body>

</html>

<?php /*
$managePage = 'Service Invoice';
$editPage = base_url() . "Invoice/addInvoice/";
$deletePage = base_url() . "Invoice/delete/";
$mainPage = base_url() . "Invoice/";
$invoicePage = base_url() . "Invoice/addInvoice/";

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
                        <div class="col-lg-12 col-sm-12">
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
                                            <th>Name</th>
                                            <th style="text-align:center;">Bill</th>
                                            <th>Bill Date</th>
                                            <th style="width: 20%;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($invoicelist)) : ?>
                                            <?php
                                                $i = 0;
                                                $i = $page;
                                                foreach ($invoicelist as $post) : $i++;

                                                    $date = new DateTime($post->billdate);
                                                    $billdate = $date->format('d-m-Y');

                                                    ?>
                                                <tr>
                                                    <td>
                                                        <?= $post->fname . " " . $post->lname; ?>
                                                        <br>
                                                        <a href="tel:<?= $post->mobile; ?>">
                                                            <?= $post->mobile; ?></a>
                                                    </td>

                                                    <td style="text-align:center;">
                                                        <?= $post->final_amt; ?><br>
                                                        <span class=" label label-success <?php if ($post->paid != "1") echo "label-warning"; ?>"><?= ($post->paid == "1") ? "Paid" : "Pending"; ?></span>
                                                    </td>
                                                    <td>
                                                        <?= $billdate;   ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                                echo form_open($deletePage . $post->id, [
                                                                    'id' => 'fd' . $post->id,
                                                                    'style' => 'float:left;margin-right:5px;'
                                                                ]);
                                                                ?>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-sm btn-primary fs12 fw500 dropdown-toggle ph10" data-toggle="dropdown">
                                                                <span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu pull-right" role="menu">

                                                                <?php
                                                                        if (check_role_assigned('invoice', 'edit')) {
                                                                            ?>
                                                                    <li><a href="<?= $editPage . $post->custid . "/" . $post->id; ?>"><span class="fa fa-edit" style="valign:center"></span> Edit</a>
                                                                    </li>
                                                                <?php
                                                                        }
                                                                        if (check_role_assigned('invoice', 'add')) {
                                                                            ?>
                                                                    <li><a href="<?= $invoicePage . $post->custid; ?>"><span class="fa fa-edit" style="valign:center"></span> Bill</a>
                                                                    </li>
                                                                <?php
                                                                        }
                                                                        if (check_role_assigned('invoice', 'delete')) {
                                                                            ?>
                                                                    <li>
                                                                        <a href="#" class="cancel" onclick="javascript:deleteBox('<?= $post->id ?>')"><span class="fa fa-close"></span> Delete</a>
                                                                    </li>
                                                                <?php
                                                                        }

                                                                        ?>
                                                            </ul>
                                                        </div>
                                                        <?php echo form_close(); ?>

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
*/ ?>