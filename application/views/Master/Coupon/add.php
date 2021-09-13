<?php
$managePage = 'Manage Coupon';
$addPage = base_url() . "Master/Coupon/index/";
$deletePage = base_url() . "Master/Coupon/delete/";
$mainPage = base_url() . "Master/Coupon/";
$pageSave = base_url() . "Master/Coupon/saveCoupon/";
$pageBack = base_url() . "Master/Coupon/";
$operation = "Add Coupon";
// --------------------- Edit -----------------------//
$val_managername = $this->session->userdata['logged_in']['managerid'];
$checked = "";
$id = $coupon->id;
if ($id != "" && $id != 0) {
    $operation = "Edit Coupon";
    $val_coupon_code = $coupon->coupon_code;
    $val_discount = $coupon->discount;
    $val_dis_type = $coupon->dis_type;
    $val_min_dis_amt = $coupon->min_dis_amt;
    $val_max_dis_amt = $coupon->max_dis_amt;
    $val_peruser = $coupon->peruser;
    $val_description = $coupon->description;
    $val_managername = $coupon->managerid;
    $val_valid_till = $coupon->valid_till;
    $val_selected_services1 = $coupon->selected_services;
    $val_coupon_type = $coupon->coupon_type;
    $val_member_type = $coupon->member_type;
    $val_selected_services = explode(",", $coupon->selected_services);
    if ($val_valid_till != "0000-00-00") {
        $date = DateTime::createFromFormat('Y-m-d', $val_valid_till);
        $val_valid_till = $date->format('d-m-Y');
    } else {
        $val_valid_till = "";
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
    <style type="text/css">
        .admin-form .switch>label {
            color: #fff;
            border-color: #C7C7C7;
            background: #C7C7C7;
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
                                        if ($operation == "Edit Coupon") {
                                            $auto = "autofocus";
                                        }
                                        echo "<div class='row'><div class='col-md-3'>";
                                        editbox("Coupon Code", "code", "Enter Coupon Code", $val_coupon_code, 'required ' . $auto);
                                        echo "</div><div class='col-md-3'>";
                                        editbox("Discount", "discount_amt", "Enter Discount", $val_discount, 'required');
                                        echo "</div> <div class='col-md-3'>";
                                        dropdownbox("Discount Type", "discount_type", $dis_type, $val_dis_type);
                                        echo "</div> <div class='col-md-3'>";
                                        editbox("Minimum Bill Amount", "minimum_discount", "Enter Minimum Bill Amount", $val_min_dis_amt, 'required');
                                        echo "</div></div><div class='row'> <div class='col-md-3'>";
                                        editbox("Maximum Discount", "maximum_discount", "Enter Maximum Discount", $val_max_dis_amt, 'required');
                                        echo "</div><div class='col-md-3'>";
                                        editbox("Coupon Per User", "per_user", "Enter Coupon Per User", $val_peruser, 'required');
                                        echo "</div><div class='col-md-3'>";
                                        editbox("Coupon Description", "cupdescription", "Enter Coupon Description", $val_description, 'required');
                                        echo "</div> <div class='col-md-3'>";
                                        datepicker("Valid Till", "validdate", "Enter Valid Till", $val_valid_till);
                                        echo "</div> <div class='col-md-3'>";
                                        dropdownbox("Coupon Type", "coupontype", $coupon_type, $val_coupon_type);
                                        echo "</div> <div class='col-md-3'>";
                                        dropdownbox("Member Type", "membertype", $member_type, $val_member_type);
                                        if ($this->session->userdata['logged_in']['user_type'] < 3) :
                                            echo "</div> <div class='col-md-3'>";
                                            dropdownbox('Manager Name', 'managername', $managername, $val_managername, 'required onchange="javascript:managerchange(this.value);"');
                                            echo '</div></div>';
                                        else : echo '</div></div>';
                                        endif;

                                        echo " <div class='row'>
                                         <div class='col-md-12'>
                                         <fieldset class='form-group'>
                                    <label class='form-label semibold'> Select Services</label></div>";
                                        if (count($treatmentlist)) :
                                            $i = 0;
                                            foreach ($treatmentlist as $post) : $i++;
                                                if (in_array($post->id, $val_selected_services)) :
                                                    $check = 1;
                                                else :
                                                    $check = 0;
                                                endif;
                                                echo "<div class='col-md-3'>";
                                                checkbox1($check, $post->treatment, 'chk_' . $i, $post->id, 'treatment');
                                                echo "</div>";
                                            endforeach;
                                        endif;
                                        echo "
                                    </fieldset>
                                        </div>";
                                        echo " <div class='col-md-3 pt20'>";
                                        submitbutton($pageBack);
                                        echo "</div>";
                                        ?>
                                        <input type="hidden" id="dloop" name="dloop" value="<?= $i; ?>">

                                        <?php
                                        echo form_close(); ?>
                                    </div>

                                </div>
                            </div>
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
    <script type="text/javascript">
        var array = [];

        jQuery(document).ready(function() {
            "use strict";
            // Init Theme Core      
            Core.init();

            $('#datatable2').dataTable({
                order: [],
                // dom: "Bfrtip",
                // dom: "rtip",
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
                    setTimeout(function() {}, 300)
                },
                onSave: function() {
                    $(window).trigger('resize');
                }
            });

        });

        function managerchange(val) {
            $("#dropmanagerid").val(val).change();
        }
    </script>

    <!-- END: PAGE SCRIPTS -->

</body>

</html>