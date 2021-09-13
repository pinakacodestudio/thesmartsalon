<!DOCTYPE html>
<html>

<head>
    <?php $this->load->view("Includes/head.php"); ?>
    <style>
        p {
            margin-bottom: 0px;
        }
    </style>
</head>

<body class="external-page sb-l-c sb-r-c">
    <!-- Start: Main -->
    <div id="main" class="animated fadeIn">
        <!-- Start: Content-Wrapper -->
        <section id="content_wrapper">
            <!-- Begin: Content -->
            <!-- begin canvas animation bg -->
            <div id="canvas-wrapper">
                <canvas id="demo-canvas"></canvas>
            </div>

            <section id="content">
                <div class="admin-form theme-info mw500" id="login" style="max-width:500px;">

                    <div class="row mb15 table-layout">

                        <div class="col-xs-6 va-m pln">
                            <a href="<?= base_url(); ?>" title="Return to Dashboard">
                                <img src="<?= base_url(); ?>assets/assets/img/logos/logo_white.png" title="AdminDesigns Logo" class="img-responsive w250">
                            </a>
                        </div>

                        <div class="col-xs-6 text-right va-b pr5">
                            <div class="login-links">
                                <a class="active" title="Sign In">Sign In</a>
                            </div>

                        </div>

                    </div>
                    <div class="panel panel-info mt10 br-n">
                        <div class="panel-heading heading-border bg-white ">                            
                        </div>
                        <?php echo form_open('Auth/login', ['name' => 'login', 'id' => 'loginform']); ?>
                        <div class="panel-body bg-light p25 pb15">

                            <!-- Username Input -->
                            <div class="section">
                                <label for="username" class="field-label text-muted fs18 mb10">Username</label>
                                <label for="username" class="field prepend-icon">
                                    <input type="text" name="identity" value="" id="identity" placeholder="Enter Username" class="gui-input" required>
                                    <label for="username" class="field-icon">
                                        <i class="fa fa-user"></i>
                                    </label>
                                </label>
                            </div>
                            <!-- Password Input -->
                            <div class="section">
                                <label for="username" class="field-label text-muted fs18 mb10">Password</label>
                                <label for="password" class="field prepend-icon">
                                    <input type="password" name="password" value="" id="password" placeholder="Enter Password" class="gui-input" required>
                                    <label for="password" class="field-icon">
                                        <i class="fa fa-lock"></i>
                                    </label>
                                </label>
                            </div>
                            <div class="section" style="margin-bottom:0px;">
                                <?php echo lang('login_remember_label', 'remember'); ?>
                                <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"'); ?>
                            </div>

                        </div>

                        <div class="panel-footer clearfix">
                            <?php echo form_submit(['value' => 'Sign In', 'class' => 'button btn-primary mr10 pull-right']); ?>
                            <?php echo anchor('Auth/forgot_password', 'Forgot Password? Click here to reset.', ['class' => 'switch ib switch-primary pull-left input-align mt10']); ?>
                        </div>
                        <?php echo form_close(); ?>

                    </div>
                </div>
            </section>
            <!-- End: Content -->
        </section>
        <!-- End: Content-Wrapper -->
    </div>
    <!-- End: Main -->
    <!-- BEGIN: PAGE SCRIPTS -->
    <!-- jQuery -->

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

    <?php
    $this->load->view('Includes/footerscript.php');
    ?>

    <!-- CanvasBG Plugin(creates mousehover effect) -->
    <script src="<?= base_url(); ?>assets/vendor/plugins/canvasbg/canvasbg.js"></script>

    <!-- Page Javascript -->
    <script type="text/javascript">
        jQuery(document).ready(function() {
            "use strict";
            // Init Theme Core      
            Core.init();
            // Init CanvasBG and pass target starting location
            CanvasBG.init({
                Loc: {
                    x: window.innerWidth / 2,
                    y: window.innerHeight / 3.3
                },
            });

        });
    </script>
    <!-- END: PAGE SCRIPTS -->
</body>

</html>