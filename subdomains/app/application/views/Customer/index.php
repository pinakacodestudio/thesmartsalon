<?php
$managePage = 'Manage Customer';
$addPage = base_url() . "Customer/index/";
$incomePage = base_url() . "Invoice/addInvoice/";
$deletePage = base_url() . "Customer/delete/";
$mainPage = base_url() . "Customer/";
$pageSave = base_url() . "Customer/save/";
$pageBack = base_url() . "Customer/";
$operation = "Add Customer";
// --------------------- Edit -----------------------//
$val_userid = 0;
$val_gender = "checked";
$id = $customer->id;
if ($id != "" && $id != 0) {
    $operation = "Edit Customer";
    $val_fname = $customer->fname;
    $val_lname = $customer->lname;
    $val_mobile = $customer->mobile;
    $val_gender = $customer->gender;
    $val_birthdate = $customer->birthdate;
    $val_anniversary = $customer->anniversary;
    if ($val_birthdate != "0000-00-00") {
        $date = DateTime::createFromFormat('Y-m-d', $val_birthdate);
        $val_birthdate = $date->format('d-m-Y');
    } else {
        $val_birthdate = "";
    }
    if ($val_anniversary != "0000-00-00") {
        $date = DateTime::createFromFormat('Y-m-d', $val_anniversary);
        $val_anniversary = $date->format('d-m-Y');
    } else {
        $val_anniversary = "";
    }
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
                    <?php alertbox(); ?>
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
                                            <th>Customer Name</th>
                                            <th>Total</th>
                                            <th>Times</th>
                                            <th style="width: 20%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($customerlist)) : ?>
                                            <?php
                                                $i = 0;
                                                $i = $page;
                                                foreach ($customerlist as $post) : $i++;


                                                    ?>
                                                <tr>
                                                    <td>
                                                        <?= $post->fname . " " . $post->lname; ?>
                                                        <br>
                                                        <a href="tel:<?= $post->mobile; ?>">
                                                            <?= $post->mobile; ?></a>
                                                    </td>

                                                    <td>
                                                        <?= $post->total; ?>
                                                    </td>
                                                    <td>
                                                        <?= $post->times;   ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                                if (check_role_assigned('customer', 'edit')) {

                                                                    echo anchor($addPage . $post->id, '<span class="fa fa-edit" style="valign:center"></span>', ['class' => 'label label-success', 'style' => 'float:left;margin-right:5px;']);
                                                                }
                                                                if (check_role_assigned('income', 'add')) {

                                                                    echo anchor($incomePage . $post->id, '<span class="fa fa-edit" style="valign:center"></span> Bill', ['class' => 'label label-warning', 'style' => 'float:left;margin-right:5px;']);
                                                                }
                                                                if (check_role_assigned('customer', 'delete')) {
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
                                        if ($operation == "Edit Customer") {
                                            $auto = "autofocus";
                                        }
                                        editbox("Firstname", "first_name", "Enter First Name", $val_fname, 'required ' . $auto);
                                        editbox("Lastname", "last_name", "Enter Last Name", $val_lname, 'required');
                                        editbox("Mobile", "mobileno", "Enter Mobile No.", $val_mobile, 'required pattern="[6789][0-9]{9}"');
                                        datepicker("Birthdate", "cust_birthdate", "Enter Birthdate", $val_birthdate);
                                        datepicker("Anniversary Date", "cust_anniversary", "Enter Anniversary", $val_anniversary);
                                        ?>
                                        <div class="section">
                                            <label class="switch block mt15 switch-primary">
                                                <input type="checkbox" name="checkgender" id="checkgender" value="1" <?= $val_gender; ?>>
                                                <label for="checkgender" data-on="M" data-off="F"></label>
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