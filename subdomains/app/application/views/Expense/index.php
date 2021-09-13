<?php
$managePage = 'Manage Expense';
$addPage = base_url() . "Expense/index/";
$deletePage = base_url() . "Expense/delete/";
$mainPage = base_url() . "Expense/";
$pageSave = base_url() . "Expense/save/";
$pageBack = base_url() . "Expense/";
$val_exp_date = date("Y-m-d");
$operation = "Add Expense";
// --------------------- Edit -----------------------//
$id = $expense->id;
if ($id != "" && $id != 0) {
    $operation = "Edit Expense";
    $val_catid = $expense->catid;
    $val_exp_date = $expense->exp_date;
    $val_exp_type = $expense->exp_type;
    $val_amount_paid = $expense->amount_paid;
    $val_paymod = $expense->paymod;
    $val_recipient_name = $expense->recipient_name;
    $val_description = $expense->description;
    $val_userid = $expense->userid;
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
                    <?php alertbox(); ?>
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
                                        if ($operation == "Edit Expense") {
                                            $auto = "autofocus";
                                        }
                                        echo "<div class='row'>
                                        <div class='col-md-3'>";
                                        datepicker("Expense Date", "expense_date", "Enter Expense Date", $val_exp_date);
                                        echo "</div> <div class='col-md-3'>";
                                        $catlist = array("1" => "Shop Expense", "2" => "Staff Payment");
                                        dropdownbox("Expense Category", "exp_cat", $catlist, $val_catid, 'required');
                                        echo "</div> <div class='col-md-3'>";
                                        editbox("Expense Type", "expense_type", "Enter Expense Type", $val_exp_type, 'required ' . $auto);
                                        echo "</div><div class='col-md-3'>";
                                        numberbox('Amount Paid', 'amount', 'Enter Amount Paid', $val_amount_paid, 'required');
                                        echo "</div></div><div class='row'> <div class='col-md-3'>";

                                        dropdownbox("Payment Mode", "paytype", $paymodlist, $val_paymod);

                                        echo "</div> <div class='col-md-3'>";
                                        editbox("Recipient Name", "recipient", "Enter Recipient Name", $val_recipient_name, 'required');
                                        echo "</div> <div class='col-md-3'>";
                                        dropdownbox("Expense By", "expid", $userlist, $val_userid, 'required');
                                        echo "</div> <div class='col-md-3 pt20'>";
                                        submitbutton($pageBack);
                                        echo "</div></div> ";

                                        ?>

                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                                            <th>Date</th>
                                            <th>Category</th>
                                            <th>Expense Description</th>
                                            <th>Amount Paid</th>
                                            <th>Payment Mode</th>
                                            <th>Recipient Name</th>
                                            <th>Expense By</th>
                                            <th style="width: 20%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($expenselist)) : ?>
                                            <?php
                                                $i = 0;
                                                $i = $page;
                                                foreach ($expenselist as $post) : $i++;
                                                    $date = new DateTime($post->exp_date);
                                                    $expensedate = $date->format('d-m-Y');
                                                    $category = "";
                                                    if ($post->catid == 1) {
                                                        $category = "Shop Expense";
                                                    } else if ($post->catid == 2) {
                                                        $category = "Staff Payment";
                                                    }
                                                    ?>
                                                <tr>
                                                    <td>
                                                        <?= $expensedate; ?>
                                                    </td>
                                                    <td>
                                                        <?= $category; ?>
                                                    </td>
                                                    <td>
                                                        <?= $post->exp_type; ?>
                                                    </td>
                                                    <td>
                                                        <?= $post->amount_paid; ?>
                                                    </td>
                                                    <td>
                                                        <?= $post->paymod; ?>
                                                    </td>
                                                    <td>
                                                        <?= $post->recipient_name; ?>
                                                    </td>
                                                    <td>
                                                        <?= $post->person_name; ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                                if (check_role_assigned('expense', 'edit')) {
                                                                    echo anchor($addPage . $post->id, '<span class="fa fa-edit" style="valign:center"></span>', ['class' => 'label label-success', 'style' => 'float:left;margin-right:5px;']);
                                                                }

                                                                if (check_role_assigned('expense', 'delete')) {
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
        var TeamDetailPostBackURL = '<?= $detailPage; ?>';
        $(function() {
            $(".anchorDetail").click(function() {
                debugger;
                var $buttonClicked = $(this);
                var id = $buttonClicked.attr('data-id');
                var options = {
                    "backdrop": "static",
                    keyboard: true
                };
                $.ajax({
                    type: "GET",
                    url: TeamDetailPostBackURL + '/' + id,
                    contentType: "application/json; charset=utf-8",
                    datatype: "json",
                    success: function(data) {
                        $('#myModalContent').html(data);
                        $('#myModal').modal(options);
                        $('#myModal').modal('show');

                    },
                    error: function() {
                        alert("Dynamic content load failed.");
                    }
                });
            });

            $("#closbtn").click(function() {
                $('#myModal').modal('hide');
            });
        });
    </script>
    <!-- END: PAGE SCRIPTS -->
</body>

</html>