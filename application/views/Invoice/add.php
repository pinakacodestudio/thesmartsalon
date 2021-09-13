<?php
$managePage = 'Invoice';
$mainPage = base_url() . "Invoice/";
$savePage = base_url() . "Invoice/saveInvoice/";
$editPage = base_url() . "Invoice/addInvoice/";

$val_treatdate = date("Y-m-d");
$val_selldate = date("Y-m-d");
$val_packdate = date("Y-m-d");

$val_discount = 0;
$val_totalamt = 0;
$val_finalamt = 0;
$val_qty = 1;
$val_amount = 0;
$val_amount_paid = 0;
$val_wallet_amt = 0;
$val_discount_amt = 0;
$val_price = 0;
$val_charges = 0;
$val_paid = "checked";
$val_sendmsg = "checked";
$val_paymod = 1;
$operation = "Add";

if ($invid != 0 && is_numeric($invid)) {
    $operation = "Edit";
    $val_billno = $invoice->billno;
    $val_billdate = $invoice->billdate;
    $val_discount_amt = $invoice->discount_amt;
    $val_couponid = $invoice->couponid;
    $val_amount_paid = $invoice->amount_paid;
    $val_wallet_amt = abs($invoice->wallet_amount);
    $val_totalamt = $invoice->total_amt;
    $val_finalamt = $invoice->final_amt;
    $val_paymod = $invoice->paymod;
    $val_comment = $invoice->comment;
    $date = new DateTime($val_billdate);
    $val_billdate = $date->format('d/m/Y');
    if ($invoice->paid == 0) {
        $val_paid = "";
    }
    if ($invoice->usewallet == 1) {
        $val_usewallet = "checked";
    }
    $val_sendmsg = "";
}
if ($val_paymod == 0) {
    $val_paymod = 1;
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
                                        <a href="#tab1_1" data-toggle="tab" aria-expanded="true">Treatment</a>
                                    </li>
                                    <li class="">
                                        <a href="#tab1_2" data-toggle="tab" aria-expanded="false">Product</a>
                                    </li>
                                    <li class="">
                                        <a href="#tab1_3" data-toggle="tab" aria-expanded="false">Package</a>
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
                                            dropdownbox('Treatment', 'treatment', $treatlist, $val_treatment, 'onchange="javascript: getServicePrice(this.value);"');
                                            echo '</div><div class="col-md-6">';
                                            numberbox("Price*", 'charges', 'Enter Price', $val_charges, 'onblur="javascript:calAmount2();"');
                                            echo '</div><div class="col-md-6">';
                                            numberbox("Qty*", 'qty2', 'Enter Qty', $val_qty, 'onblur="javascript:calAmount2();"');
                                            echo '</div><div class="col-md-6">';
                                            numberbox("Amount*", 'amt2', 'Enter Amount', $val_amount, 'disabled');
                                            echo '</div><div class="col-md-6">';
                                            textareabox('Comment', 'comment', 'Enter comment', $val_comment);
                                            echo '</div>';
                                            ?>
                                            <div class="col-md-6 pt30">
                                                <button class="btn btn-info btn-sm addService"><i class="fa fa-plus"></i> Add Treatment</button>
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
                                                dropdownbox("Product*", "productdata", $prodlist, $val_product, 'onchange="javascript: getProductPrice(this.value);"');
                                                echo '</div><div class="col-md-6">';
                                                numberbox("Product Price*", 'price', 'Enter Product Price', $val_price, 'onblur="javascript:calAmount();"');
                                                echo '</div><div class="col-md-6">';
                                                numberbox("Qty*", 'qty', 'Enter Qty', $val_qty, 'onblur="javascript:calAmount();"');
                                                echo '</div><div class="col-md-6">';
                                                numberbox("Amount*", 'amt', 'Enter Amount', $val_amount, 'disabled');
                                                echo '</div><div class="col-md-6">';
                                                textareabox('Comment', 'comment2', 'Enter comment', $val_comment);
                                                echo '</div>';
                                                ?>
                                                <div class="col-md-6 pt30">
                                                    <button class="btn btn-info btn-sm addProduct"><i class="fa fa-plus"></i> Add Product</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tab1_3" class="tab-pane">
                                        <div class="row">
                                            <?php
                                            echo '<div class="col-md-6">';
                                            datepicker("Package Used Date*", "packagedate", "Enter Package Taken Date", $val_packdate);
                                            echo '</div>
                                               <div class="col-md-6">';
                                            dropdownbox('Package', 'package', $packlist, $val_package, 'onchange="javascript: getPackagePrice(this.value);"');
                                            echo '</div>
                                            <div class="clearfix"></div>
                                            <div class="col-md-6">';
                                            numberbox("Price*", 'pricepack', 'Enter Price', $val_charges);
                                            echo '</div><div class="col-md-6">';
                                            echo '<label>Package Description : </label>';
                                            echo '<label id="packdescription"></label>';
                                            echo '</div>
                                            <div class="clearfix"></div>
                                            <div class="col-md-6">';
                                            textareabox('Comment', 'comment', 'Enter comment', $val_comment);
                                            echo '</div>';
                                            ?>
                                            <div class="col-md-6 pt30">
                                                <button class="btn btn-info btn-sm addPackage"><i class="fa fa-plus"></i> Add Package</button>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6" id="spy2">
                        <div class="panel  panel-default">
                            <div class="panel-heading custompanel">
                                <span class="pull-left"><i class="fa fa-user-circle"></i>
                                    <?php echo $customer->fname . " " . $customer->lname . "  ";
                                    if ($customer->customerid != "") {
                                        echo "( " . $customer->customerid . " )";
                                    } ?></span>
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
                                <form action="<?= $savePage; ?>" method="post" onsubmit="return SubmitBox()">
                                    <input type="hidden" name="currentwallet" id="currentwallet" value="<?= $currentwallet; ?>">
                                    <input type="hidden" name="invid" id="invid" value="<?= $invid; ?>">
                                    <input type="hidden" name="customerid" id="customerid" value="<?= $custid; ?>">
                                    <input type="hidden" name="mobileno" id="mobileno" value="<?= $customer->mobile; ?>">
                                    <input type="hidden" name="finalamt" id="finalamt" value="<?= $val_finalamt; ?>">
                                    <input type="hidden" name="totalamt" id="totalamt" value="<?= $val_totalamt; ?>">
                                    <input type="hidden" name="discount_amount" id="discount_amount" value="<?= $val_discount_amt; ?>">
                                    <input type="hidden" name="wall_amount" id="wall_amount" value="<?= $wallet_amount; ?>">
                                    <input type="hidden" name="wltamt" id="wltamt" value="<?= $val_wallet_amt; ?>">
                                    <input type="hidden" name="oldwall_amount" id="oldwall_amount" value="<?= $wallet_amount; ?>">

                                    <table class="table table-striped table-bordered ">
                                        <thead>
                                            <tr>
                                                <th style="width:70%;">Bill No: <span id="billno"><?= $val_billno ?></span></th>
                                                <th colspan="2" id="BillShow" ><span id="showbillDate"><?= $val_billdate; ?></span> <button class="btn btn-default btn-xs billEdit" style="float:right;"><i class="fa fa-pencil"></i></button></th>
                                                <th colspan="2" id="BillEditShow" style="display:none;">
                                                <fieldset class="form-group" style="margin-bottom:0px;">
                                                    <div class="input-group date" style="float:left;">
                                                        <input type="date" class="form-control" id="billdate" name="billdate" value="<?= $invoice->billdate; ?>" style="padding:0 10px; height:30px; line-height:30px;">  
                                                    </div>
                                                     <button class="btn btn-default btn-sm billdatesave" style="float:left;"><i class="fa fa-save"></i></button>
                                                </fieldset>
                                               
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Date - Service / Product </th>
                                                <th>Price </th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="addTarget">
                                            <?php
                                            $coupondisabled = "'disabled required'";
                                            if ($val_couponid == 0) {
                                                $coupondisabled = "required";
                                            }
                                            if (count($itemlist)) {
                                                foreach ($itemlist as $post) {
                                                    $date = new DateTime($post->sdate);
                                                    $tdate = $date->format('d/m/Y');

                                                    echo '  <tr id="item_' . $post->id . '">
                                                        <td>' . $tdate . ' - ' . $post->user_code . ' <br> ' . $post->description . ' | Qty - ' . $post->qty . '</td>
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
                                            echo '<div class="col-md-4">';
                                            dropdownbox("Coupon Code", 'code', $couponcodelist, $val_couponid, '');
                                            echo '</div><div class="col-md-2">';
                                            echo '<button type="button" class="btn btn-xs btn-primary mt25" onclick="javascript:checkCouponCode();">Apply Promo</button>';
                                            echo '</div><div class="col-md-6">';
                                            echo '<label id="promodesc" class="mt20" style="font-size:1rem; text-align:center; width:100%;">Choose Coupon and Click Apply Promo </label>';
                                            echo '</div> <div class="clearfix"></div><div class="col-md-6">';
                                            numberbox("Discount*", 'discount', 'Enter Discount Price', $val_discount_amt, $coupondisabled);
                                            echo '</div>';
                                            echo '<div class="col-md-6">';
                                            numberbox("Final Amount*", 'finamt', 'Enter Final Amount', $val_finalamt, 'disabled');
                                            echo '</div><div class="col-md-6">';
                                            numberbox("Amount Paid*", 'amtpaid', 'Enter Amount Paid', $val_amount_paid, 'required');
                                            echo '</div><div class="col-md-6">';
                                            ?>
                                            <label class="switch block mt15 switch-primary" style="margin-top:30px !important;">
                                                <input type="checkbox" name="usewallet" id="usewallet" <?= $val_usewallet; ?> value="1">
                                                <label for="usewallet" data-on="Yes" data-off="No"></label>
                                                <span>Use Wallet Amount <span style="font-size:10px;" id="availamt">( Rs. <?= ($wallet_amount + $val_wallet_amt) ?> )</span></span>
                                            </label>
                                            <?php
                                            echo '</div>
                                            <div class="clearfix"></div>
                                            <div class="col-md-4">';
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
                                                <button class="btn btn-primary">Save Bill</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <div class="" id="spy2">
                            <div class="panel-heading">
                                <div class="panel-title hidden-xs">
                                    <span class="fa fa-group"></span>
                                    Other Invoices
                                </div>
                            </div>

                            <table class="table table-striped table-hover" id="datatable2" cellspacing="0" width="100%">
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
                                            $billdate = $date->format('d/m/Y');

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
                                                    if (check_role_assigned('invoice', 'edit')) {

                                                        echo anchor($editPage . $post->custid . "/" . $post->id, '<span class="fa fa-edit" style="valign:center" title="Edit Bill"></span>', ['class' => 'label label-success', 'style' => 'float:left;margin-right:5px;']);
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
            </section>



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
    <?php $this->load->view("Invoice/invoicejs"); ?>


</body>

</html>