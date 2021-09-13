<?php
$managePage = 'Role';
$addPage = base_url() . "Role/index/";
$deletePage = base_url() . "Role/delete/";
$mainPage = base_url() . "Role/";
$pageSave = base_url() . "Role/save/";
$pageBack = base_url() . "Role/";
// --------------------- Edit -----------------------//
$activate = "checked";
$id = $role->id;
if ($id != "" && $id != 0) {
    $val_role_name = StringRepair3($role->user_role);
    $val_role_details = json_decode($role->role_details);
}


$sidebar_menu = array(
    array("name" => "Dashboard", "role" => "dashboard", "role_type" => "view"),
    array("name" => "Customer", "role" => "customer", "role_type" => "view,add,edit,delete"),
    array("name" => "Income", "role" => "income", "role_type" => "view,add,edit,delete"),
    array("name" => "Income Services", "role" => "incomeservices", "role_type" => "view,add,edit,delete"),
    array("name" => "Income Products", "role" => "incomeproducts", "role_type" => "view,add,edit,delete"),
    array("name" => "Treatment", "role" => "treatment", "role_type" => "view,add,edit,delete"),
    array("name" => "Product", "role" => "product", "role_type" => "view,add,edit,delete"),
    array("name" => "User", "role" => "user", "role_type" => "view,add,edit,delete"),
    array("name" => "Report", "role" => "report", "role_type" => "view")
);

define("MENU_LIST_JSON", json_encode($sidebar_menu));
?>
<!DOCTYPE html>
<html>

<head>
    <?php $this->load->view("Includes/head.php"); ?>
    <style>
        .role_ul {
            padding-left: 0px;
            border: 1px solid #dddddd;
            margin-bottom: 0px;
        }

        .role_ul li ul {
            padding-left: 0px;
        }

        .role_ul li ul li {
            border: 1px solid #dddddd;
        }


        .role_ul li {
            display: inline-block;
            width: 100%;
            padding: 5px;
            line-height: 20px;
        }

        .switcher {
            float: right;
            width: 50px;
            text-align: center;
        }

        .role_ul ul li:hover {
            background-color: #70829a;
            color: #fff;
        }

        .maintop span {
            width: 50px;
            text-align: center;
            display: inline-block;
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
                <?php alertbox(); ?>
                <div class="fade-onload">
                    <div class="row">
                        <div class="col-lg-4 col-sm-12">
                            <div class="panel " id="spy2">
                                <div class="panel-heading">
                                    <div class="panel-title hidden-xs">
                                        <?= $managePage; ?>
                                    </div>
                                </div>
                                <table class="table table-striped table-hover" id="datatable2" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Sr.</th>
                                            <th>Role Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($rolelist)) : ?>

                                            <?php
                                            $i = 0;
                                            $i = $page;
                                            foreach ($rolelist as $post) : $i++;
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?= $i ?>
                                                    </td>
                                                    <td>
                                                        <?= $post->user_role; ?></a></td>
                                                    <td>
                                                        <?php
                                                        if (check_role_assigned('team', 'edit')) {
                                                            echo anchor($addPage . $post->id, '<span class="fa fa-edit" style="valign:center"></span>', ['class' => 'label label-success', 'style' => 'float:left;margin-right:5px;']);
                                                        } ?>
                                                        <?php if (check_role_assigned('team', 'delete')) {
                                                            echo form_open($deletePage . $post->id, [
                                                                'id' => 'fd' . $post->id,
                                                                'style' => 'float:left;'
                                                            ]);
                                                            echo '<a href="#" onclick="javascript:deleteBox(' . $post->id . ')" class="label label-danger cancel" >X</a>';
                                                            echo form_close();
                                                        } ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach;
                                        endif; ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div class="col-lg-8 col-sm-12">
                            <div class="admin-form theme-primary">

                                <div class="panel heading-border panel-primary">
                                    <div class="panel-body bg-light">
                                        <?php echo form_open($pageSave, ['name' => 'frm1', 'id' => 'customform', 'enctype' => 'multipart/form-data', 'class' => 'stdform']); ?>

                                        <div class="section-divider mb40" id="spy1">
                                            <span>Manage Role</span>
                                        </div>
                                        <input type="hidden" name="id" value="<?= $id; ?>">
                                        <!-- .section-divider -->
                                        <div class="section">
                                            <label for="role_name" class="field prepend-icon">
                                                <input type="text" name="role_name" id="role_name" class="gui-input" placeholder="Role Name" value="<?= $val_role_name; ?>" autocomplete="off">
                                                <label for="role_name" class="field-icon">
                                                    <i class="fa fa-edit"></i>
                                                </label>
                                            </label>
                                        </div>
                                        <div class="section">

                                            <?php $menu_list_arr = json_decode(MENU_LIST_JSON);
                                            echo '<ul class="role_ul maintop">';
                                            echo '<li>Menu <div class="pull-right">
        <span>Delete</span>
        <span>Edit</span>
        <span>Add</span>
        <span>View</span>
        </div></li>';
                                            echo '</ul>';
                                            foreach ($menu_list_arr as $m) {
                                                echo '<ul class="role_ul">';
                                                echo set_menu_role($m, $val_role_details);
                                                echo '</ul>';
                                            }

                                            ?>

                                        </div>

                                        <div class="panel-footer">
                                            <?php submitbutton($pageBack); ?>
                                        </div>
                                        <br><br>
                                        <div>
                                            <?php
                                            if ($image != "") { ?>
                                                <img src="<?php echo base_url() . $image ?>" height="100" />
                                            <?php
                                            }
                                            ?>
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
            $("#customform").validate({
                /* @validation states + elements 
                ------------------------------------------- */
                errorClass: "state-error",
                validClass: "state-success",
                errorElement: "em",
                rules: {
                    user_role: {
                        required: true
                    }
                },
                /* @validation error messages 
                ---------------------------------------------- */

                messages: {
                    user_role: {
                        required: 'Role name is required'
                    }
                },
                /* @validation highlighting + error placement  
                ---------------------------------------------------- */

                highlight: function(element, errorClass, validClass) {
                    $(element).closest('.field').addClass(errorClass).removeClass(validClass);
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).closest('.field').removeClass(errorClass).addClass(validClass);
                }
            });

            // Form Validation code
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