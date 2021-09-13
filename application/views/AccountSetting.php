<?php
$pageSave = "AccountSetting/savepass";
$pageBack = "Dashboard";
$managePage = "Change Password";
?>
<!DOCTYPE html>
<html>

<head>
    <?php $this->load->view('Includes/head'); ?>
</head>

<body class="dashboard-page sb-l-o sb-l-m">
    <!-- Start: Main -->
    <div id="main">
        <?php $this->load->view('Includes/header'); ?>
        <!-- Start: Content-Wrapper -->
        <section id="content_wrapper">

            <!-- Start: Topbar -->
            <header id="topbar">
                <div class="topbar-left">
                    <ol class="breadcrumb">
                        <li class="crumb-icon">
                            <a href="home.php">
                                <span class="glyphicon glyphicon-home"></span>
                            </a>
                        </li>
                        <li class="crumb-trail">Account Settings</li>
                    </ol>
                </div>
            </header>
            <!-- End: Topbar -->
            <!-- Begin: Content -->
            <section id="content" class="animated fadeIn admin-form">

                

                <div class="col-md-4">
                    <div class="panel panel-default panel-border top">
                        <?php echo form_open($pageSave, ['name' => 'frm1', 'onsubmit' => 'return onSubmitBox()', 'enctype' => 'multipart/form-data', 'class' => 'stdform']); ?>
                        <div class="panel-heading">
                            <span class="panel-title">
                                <?= $managePage; ?></span>
                        </div>
                        <div class="panel-body">
                            <?php
                            passwordbox('Old Password', 'oldpass', 'Enter Old Password', "");
                            passwordbox('New Password', 'newpass', 'Enter New Password', "");
                            passwordbox('Confirm Password', 'confirmpass', 'Enter Confirm Pass', "");
                            ?>
                        </div>
                        <div class="panel-footer">
                            <?php submitbutton($pageBack); ?>
                        </div>
                        <?php form_close(); ?>
                    </div>
                </div>


                <div class="clearfix"></div>
            </section>
            <!-- End: Content -->

            <?php $this->load->view('Includes/footer'); ?>
        </section>
        <!-- End: Content-Wrapper -->
    </div>
    <!-- End: Main -->
    <?php $this->load->view('Includes/footerscript'); ?>
    <script>
        function onSubmitBox() {

            var title = "";
            var ttext = "";

            var oldpass = $("#oldpass").val();
            var newpass = $("#newpass").val();
            var confirmpass = $("#confirmpass").val();

            if (oldpass == "") {
                title = "Old Password";
                ttext = "Please Enter Old Password";
                document.frm1.oldpass.focus();
            } else if (newpass == "") {
                title = "New Password";
                ttext = "Please Enter New Password";
                document.frm1.newpass.focus();
            } else if (confirmpass == "") {
                title = "Confirm Password";
                ttext = "Please Enter Confirm Password";
                document.frm1.confirmpass.focus();
            } else if (newpass != confirmpass) {
                title = "Password";
                ttext = "New Password and Confirm Password Didn't Match";
                document.frm1.newpass.focus();
            }
            if (title != "" && ttext != "") {
                swal({
                    title: title,
                    text: ttext,
                    type: "error",
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Ok"
                });
                return false;
            } else {
                return true;
            }
        }
        jQuery(document).ready(function() {
            "use strict";
            // Init Theme Core      
            Core.init();

            $('#customers').dataTable({
                // dom: "Bfrtip",
                // dom: "rtip",
                order: [],
                dom: '<"top"fl>rt<"bottom"ip>'
                // select: true
            });


            // Form Validation code
            $("#customform").validate({
                /* @validation states + elements 
                ------------------------------------------- */
                errorClass: "state-error",
                validClass: "state-success",
                errorElement: "em",
                rules: {
                    fname: {
                        required: true
                    },
                    lname: {
                        required: true
                    },
                    mobile: {
                        required: true,
                        number: true,
                        minlength: 10,
                        maxlength: 10,
                    }

                },
                /* @validation error messages 
                ---------------------------------------------- */
                messages: {
                    fname: {
                        required: 'Enter First Name'
                    },
                    lname: {
                        required: 'Enter Last Name'
                    },
                    customer_phone: {
                        required: 'Enter Mobile No.',
                        minlength: 'Minimum Length 10',
                        maxlength: 'Maximum Length 10'

                    }
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
</body>

</html>