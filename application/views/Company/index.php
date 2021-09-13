<?php
$managePage = 'Manage Companies';
$addPage = base_url() . "Company/index";
$deletePage = base_url() . "Company/delete";
$mainPage = base_url() . "Company/";
$pageSave = base_url() . "Company/save/";
$pageBack = base_url() . "Company/";
$opration = "Add";
// --------------------- Edit -----------------------//
$val_id = 0;
$activate = "checked";
$id = $company->id;
if ($id != "" && $id != 0) {
    $opration = "Edit";
    $val_company_name = $company->companyname;
    $val_company_address = $company->address;
    $val_phone = $company->phone;
    $val_email = $company->email;

    if ($company->status == 1) {
        $activate = "checked";
    } else if ($company->status == 0) {
        $activate = "";
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <?php $this->load->view("Includes/head.php"); ?>
    <style>
        .admin-form #genderlbl>label {
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
                        <div class="col-lg-8 col-sm-12 mb20">
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
                                            <th>Sr.</th>
                                            <th>Company name</th>
                                            <th>Company address</th>

                                            <th>Email Id</th>
                                            <th>Phone </th>
                                            <th>Status</th>
                                            <th style="width: 20%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        foreach ($companylist as $post) {
                                            $i++;
                                            $status = "";
                                            if ($post->status == 1) {
                                                $status = "<span class='label label-primary'> Active</span>";
                                            } else if ($post->status == 0) {
                                                $status = "<span class='label label-dark'> Inactive</span>";
                                            }
                                            ?>
                                            <tr>
                                                <td>
                                                    <?= $i ?>
                                                </td>
                                                <td>
                                                    <?= $post->companyname; ?>
                                                </td>
                                                <td>

                                                    <?= $post->address; ?>
                                                </td>
                                                <td>
                                                    <?= $post->email; ?>
                                                </td>
                                                <td>
                                                    <?= $post->phone; ?>
                                                </td>

                                                <td>

                                                    <?= $status ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        if (check_role_assigned('user', 'edit')) {

                                                            echo anchor($addPage . "/" . $post->id, '<span class="fa fa-edit" style="valign:center"></span>', ['class' => 'label label-success', 'style' => 'float:left;margin-right:5px;']);
                                                        }
                                                        if (check_role_assigned('user', 'delete')) {
                                                            echo form_open($deletePage . "/" . $post->id, [
                                                                'id' => 'fd' . $post->id,
                                                                'style' => 'float:left;margin-right:5px;;'
                                                            ]);

                                                            echo '<a href="#" onclick="javascript:deleteBox(' . $post->id . ')" class="label label-danger cancel" ><span class="fa fa-close"></span></a>';
                                                            echo form_close();
                                                        }
                                                        ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                                <?php




                                ?>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="admin-form theme-primary">

                                <div class="panel heading-border panel-primary">
                                    <div class="panel-body bg-light">
                                        <?php echo form_open($pageSave, ['name' => 'frm1', 'id' => 'customform',  'enctype' => 'multipart/form-data', 'class' => 'stdform']); ?>
                                        <div class="section-divider mb40" id="spy1">
                                            <span><?= $opration ?> Company</span>
                                        </div>
                                        <input type="hidden" name="id" value="<?= $id ?>">

                                        <?php

                                        editbox('Company name', 'companyname', 'Enter company name', $val_company_name);
                                        textareabox('Company address', 'companyaddress', 'Enter Company address', $val_company_address);

                                        editbox('Phone', 'phone', 'Enter Phone No.', $val_phone);
                                        emailbox('Email Id', 'email', 'Enter Email Id', $val_email);

                                        ?>
                                        <div class="section">
                                            <label class="switch block mt15 switch-primary">
                                                <input type="checkbox" name="companystatus" id="companystatus" value="1" <?= $activate ?>>
                                                <label for="companystatus" data-on="ON" data-off="OFF"></label>
                                                <span>Company Status</span>
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
                "scrollY":        "390px",
                "scrollCollapse": true,
                "paging":         false,
                "scrollX": true,
                dom: '<"top"fl>rt<"bottom"ip>'
            });

            // Form Validation code
            $("#customform").validate({
                /* @validation states + elements 
                ------------------------------------------- */
                errorClass: "state-error",
                validClass: "state-success",
                errorElement: "em",
                rules: {
                    companyname: {
                        required: true
                    },
                    email: {
                        required: true
                    },
                    phone: {
                        required: true,
                        number: true,
                        minlength: 10,
                        maxlength: 10,
                    },
                    companyaddress: {
                        required: true

                    },
                    <?php
                    if ($id == "") {
                        ?>
                        password: {
                            required: true
                        }
                    <?php
                    } ?>

                },
                /* @validation error messages 
                ---------------------------------------------- */
                messages: {
                    username: {
                        required: 'Enter username'
                    },
                    email: {
                        required: 'Enter Email ID'
                    },
                    phone: {
                        required: 'Enter Mobile No.',
                        minlength: 'Minimum Length 10',
                        maxlength: 'Maximum Length 10'

                    },
                    share_per: {
                        required: 'Enter Sharing Percentage'
                    },
                    <?php
                    if ($id == "") {
                        ?>
                        password: {
                            required: 'Enter password'
                        }
                    <?php
                    } ?>

                },
                /* @validation highlighting + error placement  
                ---------------------------------------------------- */

                highlight: function(element, errorClass, validClass) {
                    $(element).closest('.field').addClass(errorClass).removeClass(validClass);
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).closest('.field').removeClass(errorClass).addClass(validClass);
                },
                errorPlacement: function(error, element) {
                    if (element.is(":radio") || element.is(":checkbox")) {
                        element.closest('.option-group').after(error);
                    } else {
                        error.insertAfter(element.parent());
                    }
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