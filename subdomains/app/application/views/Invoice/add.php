<?php
$managePage = 'Invoice';
$mainPage = base_url() . "Invoice/";
$savePage = base_url() . "Invoice/saveInvoice/";
$saveItemPage = base_url() . "Invoice/saveInvoiceData/";
$checkCode = base_url() . "Invoice/checkCode/";
$deletePage = base_url() . "Invoice/deleteItem/";

$val_treatdate = date("Y-m-d");
$val_selldate = date("Y-m-d");

$val_discount = 0;
$val_totalamt = 0;
$val_finalamt = 0;
$val_qty = 1;
$val_amount = 0;
$val_amount_paid = 0;
$val_price = 0;
$val_charges = 0;
$val_paid = "checked";
$val_sendmsg = "checked";
$val_paymod = 1;
$operation = "Add";

if ($invid != 0 && is_numeric($invid)) {
    $operation = "Edit";
    $val_billno = $invoice->billno;
    $val_discount_amt = $invoice->discount_amt;
    $val_couponid = $invoice->couponid;
    $val_amount_paid = $invoice->amount_paid;
    $val_totalamt = $invoice->total_amt;
    $val_finalamt = $invoice->final_amt;
    $val_paymod = $invoice->paymod;
    if ($invoice->paid == 0) {
        $val_paid = "";
    }
    $val_sendmsg = "";
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
                    <div class="col-md-6">
                        <div class="panel">
                            <div class="panel-heading">
                                <ul class="nav panel-tabs-border panel-tabs panel-tabs-left">
                                    <li class="active">
                                        <a href="#tab1_1" data-toggle="tab" aria-expanded="true">Service</a>
                                    </li>
                                    <li class="">
                                        <a href="#tab1_2" data-toggle="tab" aria-expanded="false">Product</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="panel-body">
                                <div class="tab-content pn br-n">
                                    <div id="tab1_1" class="tab-pane active">
                                        <div class="row">
                                            <?php
                                            echo '<div class="col-md-6">';
                                            datepicker("Treatment Date*", "treatdate", "Enter Treatment Date", $val_treatdate);
                                            echo '</div><div class="col-md-6">';
                                            dropdownbox('Staff', 'userid', $userlist, $val_userid);
                                            echo '</div>
                                                <div class="clearfix"></div>
                                                <div class="col-md-6">';
                                            dropdownbox('Treatment', 'treatment', $treatlist, $val_treatment);
                                            echo '</div><div class="col-md-6">';
                                            numberbox("Price*", 'charges', 'Enter Price', $val_charges, 'onblur="javascript:calAmount2();"');
                                            echo '</div><div class="col-md-6">';
                                            numberbox("Qty*", 'qty2', 'Enter Qty', $val_qty, 'onblur="javascript:calAmount2();"');
                                            echo '</div><div class="col-md-6">';
                                            numberbox("Amount*", 'amt2', 'Enter Amount', $val_amount, 'disabled');
                                            echo '</div><div class="col-md-6">';
                                            textareabox('Comment', 'Comment', 'comment', 'Enter comment');
                                            echo '</div>';
                                            ?>
                                            <div class="col-md-6 pt30">
                                                <button class="btn btn-info btn-sm addService"><i class="fa fa-plus"></i> Add Service</button>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <div id="tab1_2" class="tab-pane">
                                        <div class="row">
                                            <div class="col-md-12">

                                                <?php
                                                echo '<div class="col-md-6">';
                                                datepicker("Sell Date*", "selldate", "Enter Sell Date", $val_selldate);
                                                echo '</div><div class="col-md-6">';
                                                dropdownbox('Staff', 'puserid', $userlist, $val_selluserid);
                                                echo '</div>
                                                <div class="clearfix"></div>
                                                <div class="col-md-6">';
                                                dropdownbox("Product*", "productdata", $prodlist, $val_product);
                                                echo '</div><div class="col-md-6">';
                                                numberbox("Product Price*", 'price', 'Enter Product Price', $val_price, 'onblur="javascript:calAmount();"');
                                                echo '</div><div class="col-md-6">';
                                                numberbox("Qty*", 'qty', 'Enter Qty', $val_qty, 'onblur="javascript:calAmount();"');
                                                echo '</div><div class="col-md-6">';
                                                numberbox("Amount*", 'amt', 'Enter Amount', $val_amount, 'disabled');
                                                echo '</div><div class="col-md-6">';
                                                textareabox('Comment', 'Comment', 'comment2', 'Enter comment');
                                                echo '</div>';
                                                ?>
                                                <div class="col-md-6 pt30">
                                                    <button class="btn btn-info btn-sm addProduct"><i class="fa fa-plus"></i> Add Product</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6" id="spy2">
                        <div class="panel  panel-default">
                            <div class="panel-heading custompanel">
                                <span class="pull-left"><i class="fa fa-user-circle"></i> <?= $customer->fname . " " . $customer->lname; ?></span>
                                <span class="pull-right"><i class="fa fa-phone-square"></i>
                                    <?php
                                    if ($operation == "Edit") {
                                        echo '<a href="tel:' . $customer->mobile . '">' . $customer->mobile . '</a>';
                                    } else {
                                        echo $customer->mobile;
                                    } ?>
                                </span>
                            </div>
                            <div class="clearfix"></div>
                            <div class="panel-body">
                                <form action="<?= $savePage; ?>" method="post">
                                    <input type="hidden" name="invid" id="invid" value="<?= $invid; ?>">
                                    <input type="hidden" name="finalamt" id="finalamt" value="<?= $val_finalamt; ?>">
                                    <input type="hidden" name="totalamt" id="totalamt" value="<?= $val_totalamt; ?>">
                                    <input type="hidden" name="discount_amount" id="discount_amount" value="<?= $val_discount_amt; ?>">

                                    <table class="table table-striped table-bordered ">
                                        <thead>
                                            <tr>
                                                <th colspan="3">Bill No: <span id="billno"><?= $val_billno ?></span></th>
                                            </tr>
                                            <tr>
                                                <th>Date - Service / Product </th>
                                                <th>Price </th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="addTarget">
                                            <?php
                                            if (count($itemlist)) {
                                                foreach ($itemlist as $post) {
                                                    $date = new DateTime($post->sdate);
                                                    $tdate = $date->format('d/m/Y');

                                                    echo '  <tr id="item_' . $post->id . '">
                                                        <td>' . $tdate . ' <br> ' . $post->description . ' | Qty - ' . $post->qty . '</td>
                                                        <td>' . $post->amount . '<br>' . $post->comment . '</td>
                                                        <td width="10%">
                                                        <a href="javascript:deleteRecord(' . $post->id . ')" class="btn btn-danger btn-xs" style="margin-top: 1px;"><span class="fa fa-trash"> </span></a></td>
                                                        </tr>';
                                                }
                                            }
                                            ?>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td>Total</td>
                                                <td colspan="2" id="tblTotal"><?= $val_totalamt; ?></td>

                                            </tr>
                                        </tfoot>
                                    </table>

                                    <div class="admin-form" style="margin-top: 10px;">
                                        <div class="row">
                                            <?php

                                            echo '<div class="col-md-6">';
                                            dropdownbox("Coupon Code", 'code', $couponcodelist, $val_couponid, 'onchange="javascript:checkCouponCode();"');
                                            echo '</div><div class="col-md-6">';
                                            numberbox("Discount*", 'discount', 'Enter Discount Price', $val_discount_amt, 'disabled');
                                            echo '</div>';
                                            echo '<div class="col-md-6">';
                                            numberbox("Final Amount*", 'finamt', 'Enter Final Amount', $val_finalamt, 'disabled');
                                            echo '</div><div class="col-md-6">';
                                            numberbox("Amount Paid*", 'amtpaid', 'Enter Amount Paid', $val_amount_paid, 'required');
                                            echo '</div><div class="col-md-4">';
                                            dropdownbox("Payment Mode", 'pay_mod', $paylist, $val_paymod, 'required');
                                            echo '</div>';
                                            ?>

                                            <div class="col-md-3 pt20">
                                                <label class="switch block mt15 switch-primary">
                                                    <input type="checkbox" name="paid" id="paid" <?= $val_paid; ?> value="1">
                                                    <label for="paid" data-on="Yes" data-off="No"></label>
                                                    <span>Paid</span>
                                                </label>
                                            </div>
                                            <div class="col-md-5 pt20">
                                                <label class="switch block mt15 switch-primary">
                                                    <input type="checkbox" name="sendmsg" id="sendmsg" <?= $val_sendmsg; ?> value="1">
                                                    <label for="sendmsg" data-on="Yes" data-off="No"></label>
                                                    <span>Send Message</span>
                                                </label>
                                            </div>
                                            <div class="col-md-12">
                                                <button class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
            </section>

            <input type="hidden" name="disamt" id="disamt" value="0">
            <input type="hidden" name="distype" id="distype" value="0">
            <input type="hidden" name="minamt" id="minamt" value="0">
            <input type="hidden" name="maxamt" id="maxamt" value="0">

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
        function calAmount() {
            var price = parseInt($("#price").val());
            var qty = parseInt($("#qty").val());
            $("#amt").val(price * qty);
        }

        function calAmount2() {
            var price = parseInt($("#charges").val());
            var qty = parseInt($("#qty2").val());
            $("#amt2").val(price * qty);
        }

        function calTotal() {
            var invid = parseInt($("#invid").val());
            var total = parseInt($("#totalamt").val());
            var disamt = $("#disamt").val();
            var distype = $("#distype").val();
            var minamt = $("#minamt").val();
            var maxamt = $("#maxamt").val();
            var discount = 0;
            if (distype == 1) {
                if (total >= minamt) {
                    discount = disamt;
                }
            } else if (distype == 2) {
                if (total >= minamt) {
                    discount = (total * disamt) / 100;
                }
                if (discount >= maxamt && maxamt != 0) {
                    discount = maxamt;
                }
            }
            $('#discount').val(discount);
            $('#discount_amount').val(discount);
            $('#finalamt').val(total - discount);
            $('#finamt').val(total - discount);
            $('.loadcontainer').hide();
        }

        function checkCouponCode() {
            $('.loadcontainer').show();
            var invid = parseInt($("#invid").val());
            var code = $("#code").val();
            var custid = <?= $custid; ?>;
            var total = parseInt($("#totalamt").val());
            var discount = parseInt($("#discount").val());
            $('#finalamt').val(total - discount);
            $('#finamt').val(total - discount);

            $.ajax({
                url: '<?= $checkCode; ?>',
                data: {
                    invid: invid,
                    custid: custid,
                    code: code,
                },
                type: "post",
                success: function(data) {
                    if (data.status == 1) {
                        $("#disamt").val(data.disamt);
                        $("#distype").val(data.distype);
                        $("#minamt").val(data.minamt);
                        $("#maxamt").val(data.maxamt);
                        calTotal();
                    }
                }
            });
            $('.loadcontainer').hide();
        }

        $(document).ready(function() {
            $(".addService").click(function(e) {
                e.preventDefault();
                $('.loadcontainer').show();

                var custid = <?= $custid; ?>;
                var tdate = $('#treatdate').val();
                var userid = $('#userid').val();
                var treatment = $("#treatment option:selected").val();
                var invid = $("#invid").val();
                var qty = $("#qty2").val();
                var charges = $('#charges').val();
                var comment = $('#comment').val();

                if (userid == "") {
                    validBox("Select a Shop Person");
                    $("#userid").focus();
                    return false;
                } else if (treatment == "") {
                    validBox("Select a Treatment");
                    $("#treatment").focus();
                    return false;
                } else if (charges == "0" || charges == "") {
                    validBox("Enter Price For Service");
                    $("#charges").focus();
                    return false;
                } else if (qty == "0" || qty == "") {
                    validBox("Enter Quantity For Service");
                    $("#qty2").focus();
                    return false;
                }

                $.ajax({
                    url: '<?= $saveItemPage; ?>',
                    data: {
                        custid: custid,
                        invid: invid,
                        tdate: tdate,
                        userid: userid,
                        qty: qty,
                        ctype: 1,
                        treatment: treatment,
                        charges: charges,
                        comment: comment
                    },
                    type: "post",
                    success: function(data) {
                        if (data.status == 1) {
                            $("#invid").val(data.invid);
                            $("#totalamt").val(data.total);
                            $("#tblTotal").html(data.total);
                            $("#billno").html(data.billno);
                            $("#addTarget").append(data.tabledata);
                            $("#treatment").val('').change();
                            $("#userid").val('').change();
                            $("#charges").val(0);
                            $("#amt2").val(0);
                            $("#qty2").val(1);
                            $("#comment").val("");
                            calTotal();

                        }
                    }
                });
            });

            $(".addProduct").click(function(e) {
                e.preventDefault();
                $('.loadcontainer').show();
                var custid = <?= $custid; ?>;
                var tdate = $('#selldate').val();
                var userid = $('#puserid').val();
                var product = $("#productdata option:selected").val();
                var invid = $("#invid").val();
                var charges = $('#price').val();
                var qty = $('#qty').val();
                var comment = $('#comment2').val();

                if (userid == "") {
                    validBox("Select a Shop Person");
                    $("#userid").focus();
                    return false;
                } else if (product == "") {
                    validBox("Select a Product");
                    $("#productdata").focus();
                    return false;
                } else if (charges == "0" || charges == "") {
                    validBox("Enter Price For Product");
                    $("#price").focus();
                    return false;
                } else if (qty == "0" || qty == "") {
                    validBox("Enter Quantity For Product");
                    $("#qty").focus();
                    return false;
                }

                $.ajax({
                    url: '<?= $saveItemPage; ?>',
                    data: {
                        custid: custid,
                        invid: invid,
                        tdate: tdate,
                        userid: userid,
                        qty: qty,
                        ctype: 2,
                        treatment: product,
                        charges: charges,
                        comment: comment
                    },
                    type: "post",
                    success: function(data) {
                        if (data.status == 1) {
                            $("#invid").val(data.invid);
                            $("#totalamt").val(data.total);
                            $("#tblTotal").html(data.total);
                            $("#billno").html(data.billno);
                            $("#addTarget").append(data.tabledata);
                            $("#price").val(0);
                            $("#productdata").val('').change();
                            $("#puserid").val('').change();
                            $("#amt").val(0);
                            $("#qty").val(1);
                            $("#comment2").val("");
                            calTotal();
                        }
                    }
                });
            });
        });
    </script>
    <script src="<?php echo base_url('assets/vendor/plugins/select2/js/select2.min.js'); ?>"></script>
    <script type="text/javascript">
        $(".select2-single").select2({
            allowClear: true
        });

        function deleteRecord(val) {
            var invid = $("#invid").val();
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
                            url: '<?= $deletePage; ?>',
                            data: {
                                invid: invid,
                                delid: val,
                            },
                            type: "post",
                            success: function(data) {
                                if (data.status == 1) {
                                    $("#item_" + val).remove();
                                    $("#totalamt").val(data.total);
                                    $("#tblTotal").html(data.total);
                                    calTotal();
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