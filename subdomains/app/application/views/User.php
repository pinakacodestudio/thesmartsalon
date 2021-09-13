<?php
$managePage = 'Users';
$addPage = base_url() . "User/index/";
$deletePage = base_url() . "User/delete/";
$mainPage = base_url() . "User/";
$pageSave = base_url() . "User/save/";
$pageBack = base_url() . "User/";
// --------------------- Edit -----------------------//
$val_userid = 0;
$operation = "Add User";
$activate = "checked";
$id = $user->id;
if ($id != "" && $id != 0) {
    $operation = "Edit User";
    $val_person_name = $user->person_name;
    $val_user_name = $user->user_name;
    $val_phone = $user->user_phone;
    $val_email = $user->user_email;
    $val_user_role = $user->user_type;
    $val_share_per = $user->share_per;
    if ($user->status == 1) {
        $activate = "checked";
    } else if ($status->status == 0) {
        $activate = "";
    }
    if ($user->gender == 1) {
        $gender = "checked";
    } else if ($status->gender == 0) {
        $gender = "";
    }
    if ($user->isbarber == 1) {
        $isbarber = "checked";
    } else if ($status->isbarber == 0) {
        $isbarber = "";
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
                                            <th>Sr.</th>
                                            <th>Person Name</th>
                                            <th>Username</th>
                                            <th>Phone No.</th>
                                            <th>Email Id</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th style="width: 20%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($userlist)) : ?>
                                            <?php
                                                $i = 0;
                                                $i = $page;
                                                foreach ($userlist as $post) : $i++;
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
                                                        <?= $post->person_name ?>
                                                    </td>
                                                    <td>
                                                        <?= $post->user_name ?>
                                                    </td>
                                                    <td><a href="tel:<?= $post->user_phone; ?>">
                                                            <?= $post->user_phone; ?></a></td>
                                                    <td>
                                                        <a href="mailto:<?= $post->user_email; ?>"><?= $post->user_email ?></a>
                                                    </td>
                                                    <td>
                                                        <?= $post->user_role ?>
                                                    </td>
                                                    <td>
                                                        <?= $status ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                                if (check_role_assigned('user', 'edit')) {

                                                                    echo anchor($addPage . $post->id, '<span class="fa fa-edit" style="valign:center"></span>', ['class' => 'label label-success', 'style' => 'float:left;margin-right:5px;']);
                                                                }
                                                                if (check_role_assigned('user', 'delete')) {
                                                                    echo form_open($deletePage . $post->id, [
                                                                        'id' => 'fd' . $post->id,
                                                                        'style' => 'float:left;margin-right:5px;;'
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

                                        editbox('Person Name', 'person', 'Enter Person Name', $val_person_name, 'required');
                                        editbox('Username', 'username', 'Enter User Name', $val_user_name, 'required');
                                        passwordbox('Password', 'password', 'Enter Password', '');
                                        editbox('Phone', 'phone', 'Enter Phone No.', $val_phone, 'required pattern="[6789][0-9]{9}"');
                                        emailbox('Email Id', 'email', 'Enter Email Id', $val_email, 'required');
                                        dropdownbox('User Role', 'utype', $userrole, $val_user_role, 'required');
                                        editbox('Sharing Percentage', 'share', 'Enter Sharing Percentage', $val_share_per);
                                        ?>

                                        <div class="section">
                                            <label class="switch block mt15 switch-primary genderlbl">
                                                <input type="checkbox" name="checkgender" id="checkgender" value="1" <?= $gender ?>>
                                                <label for="checkgender" id="genderlabel" data-on="M" data-off="F"></label>
                                                <span>Gender</span>
                                            </label>

                                        </div>
                                        <div class="section">
                                            <label class="switch block mt15 switch-primary">
                                                <input type="checkbox" name="userstatus" id="userstatus" value="1" <?= $activate ?>>
                                                <label for="userstatus" data-on="ON" data-off="OFF"></label>
                                                <span>Active Status</span>
                                            </label>

                                        </div>
                                        <div class="section">
                                            <label class="switch block mt15 switch-primary">
                                                <input type="checkbox" name="barber" id="barber" value="1" <?= $isbarber ?>>
                                                <label for="isbarber" data-on="YES" data-off="NO"></label>
                                                <span>Is Barber</span>
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