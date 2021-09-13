<?php
$managePage = 'Manage Staff Salary';
$addPage = base_url() . "StaffSalary/index/";
$deletePage = base_url() . "StaffSalary/delete/";
$mainPage = base_url() . "StaffSalary/";
$pageSave = base_url() . "StaffSalary/save/";
$pageBack = base_url() . "StaffSalry/";
$val_exp_date = date("Y-m-d");
$staffsalaryget = base_url() . "StaffSalary/Salaryget";
$staffInsetive = base_url() . "StaffSalary/staffInsetive";
$operation = "Add Staff Salary";
// --------------------- Edit -----------------------//
$val_iamount = 0;
$val_bonus = 0;
$val_staff_paid = 0;
$val_amount_paid = 0;
$val_paymod = 1;
$id = $staffsalary->id;
if ($id != "" && $id != 0) {
    $operation = "Edit Staff Salary";
    $val_startdate = $staffsalary->startdate;
    $date = new DateTime($val_startdate);
    $val_startdate = $date->format('d/m/Y');
    echo  $val_startdate;
    $val_enddate = $staffsalary->enddate;
    $val_staff_paid = $staffsalary->salary;
    $val_amount_paid = $staffsalary->amount_paid;
    $val_iamount = $staffsalary->iamount;
    $val_bonus = $staffsalary->bonus;
    $val_paymod = $staffsalary->paymod;
    $val_description = $staffsalary->description;
    $val_userid = $staffsalary->staff_name;
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

                        <div class="col-lg-6 col-sm-12">
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
                                        if ($operation == "Edit Staff Expense") {
                                            $auto = "autofocus";
                                        }
                                        echo "<div class='row'> 
                                              <div class='col-md-6'>";
                                        dropdownbox("Staff Name", "staff", $userlist, $val_userid, 'required');
                                        echo "</div><div class='col-md-6'>";
                                        numberbox('Staff Salary', 'salary', 'Enter Staff Salary', $val_staff_paid, 'required onchange="javascript:autoSum();"');
                                        echo "</div></div>";
                                        echo "<div class='row'> 
                                           <div class='col-md-6'>";
                                        datepicker("Start Date", "startdate", "Enter Start Date", $val_startdate);
                                        echo "</div><div class='col-md-6'>";
                                        datepicker("End Date", "enddate", "Enter End Date", $val_enddate);
                                        echo "</div></div>";
                                        echo "<div class='row'> 
                                           <div class='col-md-8'>";
                                        numberbox('Insentive amount', 'iamount', 'Enter Insentive Amount', $val_iamount, 'required disabled');
                                        echo "</div><div class='col-md-4 pt20'>";
                                        echo "<button id='getinsetive' type='button' class='btn btn-info'>Calculate Insentives</button>";
                                        echo "</div></div>";
                                        echo "<div class='row'> 
                                        <div class='col-md-6'>";
                                        numberbox('Bonus', 'bonus', 'Enter Bonus Amount', $val_bonus, 'required  onchange="javascript:autoSum();"');
                                        echo "</div>";
                                        echo "<div class='col-md-6'>";
                                        numberbox('Amount Paid', 'amount', 'Enter Amount Paid', $val_amount_paid, 'required');
                                        echo "</div>";
                                        echo "<div class='col-md-6'>";
                                        dropdownbox("Payment Mode", "paytype", $paymodlist, $val_paymod);
                                        echo "</div>";
                                        echo "<div class='col-md-6'>";
                                        editbox("Description", 'description', "Enter Description", $val_description, 'required');
                                        echo "</div> </div>";
                                        submitbutton($pageBack);
                                        ?>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <div class="" id="spy2">
                                <div class="panel-heading">
                                    <div class="panel-title hidden-xs">
                                        <span class="fa fa-group"></span>
                                        <?= $managePage; ?>
                                    </div>
                                </div>
                                <table class="table table-striped table-hover " id="datatable2" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Staff Name</th>
                                            <th>Amount Paid</th>
                                            <th>Payment Mode</th>
                                            <th>Description</th>
                                            <th style="width: 20%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($staffsalarylist)) : ?>
                                            <?php
                                                $i = 0;
                                                $i = $page;
                                                foreach ($staffsalarylist as $post) : $i++;
                                                    $date = new DateTime($post->exp_date);
                                                    $StaffExpensedate = $date->format('d-m-Y');
                                                    ?>
                                                <tr>

                                                    <td>
                                                        <?= $post->person_name; ?>
                                                    </td>
                                                    <td>
                                                        <?= $post->amount_paid; ?>
                                                    </td>
                                                    <td>
                                                        <?= $post->paymod; ?>
                                                    </td>

                                                    <td>
                                                        <?= $post->description; ?>
                                                    </td>

                                                    <td>
                                                        <?php
                                                                if (check_role_assigned('StaffExpense', 'edit')) {
                                                                    echo anchor($addPage . $post->id, '<span class="fa fa-edit" style="valign:center"></span>', ['class' => 'label label-success', 'style' => 'float:left;margin-right:5px;']);
                                                                }

                                                                if (check_role_assigned('StaffExpense', 'delete')) {
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
        var staffsalaryget = "<?= $staffsalaryget; ?>";
        var staffInsetive = "<?= $staffInsetive; ?>";
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



            $('#staff').on('change', function() {
                var staffid = $("#staff :selected").val();

                if (staffid > 0) {
                    $.ajax({
                        type: "POST",
                        data: {
                            staffid: staffid
                        },
                        url: staffsalaryget,
                        success: function(data) {
                            if (data.status == 1) {
                                $('#salary').val(data.salary);
                                autoSum();
                            }

                        },
                        error: function() {
                            alert("Dynamic content load failed.");
                            autoSum();
                            $('#salary').val(0);
                        }
                    });
                } else {
                    autoSum();
                    $('#salary').val(0);
                }

            });
            $('#getinsetive').on('click', function() {
                var startdate = $("#startdate").val();
                var enddate = $("#enddate").val();
                var staffid = $("#staff :selected").val();
                if (staffid > 0) {
                    $.ajax({
                        type: "POST",
                        data: {
                            staffid: staffid,
                            startdate: startdate,
                            enddate: enddate
                        },
                        url: staffInsetive,
                        success: function(data) {

                            if (data.status == 1) {
                                $('#iamount').val(data.insetiveamt);
                                autoSum();
                            }
                        },
                        error: function() {
                            alert("Dynamic content load failed.");
                            autoSum();
                            $('#iamount').val(0);
                        }
                    });
                } else {
                    autoSum();
                    $('#iamount').val(0);
                }
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

        function autoSum() {
            var sum = 0;
            var salary = parseInt($('#salary').val());
            var iamount = parseInt($('#iamount').val());
            var bonus = parseInt($('#bonus').val());
            sum = salary + iamount + bonus;
            $('#amount').val(sum);
        }
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