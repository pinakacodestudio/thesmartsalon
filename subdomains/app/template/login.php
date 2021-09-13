<!DOCTYPE html>
<html>

<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <title>Login</title>
    <?php include "include/headerscript.php"; ?>
</head>

<body class="external-page sb-l-c sb-r-c">

    <!-- Start: Main -->
    <div id="main" class="animated fadeIn">

        <!-- Start: Content-Wrapper -->
        <section id="content_wrapper">

            <!-- begin canvas animation bg -->
            <div id="canvas-wrapper">
                <canvas id="demo-canvas"></canvas>
            </div>

            <!-- Begin: Content -->
            <section id="content">

                <div class="admin-form theme-info" id="login1" style="max-width:500px;">

                    <div class="row mb15 table-layout">

                        <div class="col-xs-6 va-m pln">
                            <a href="dashboard.html" title="Return to Dashboard">
                                <img src="assets/img/logos/logo_white.png" title="AdminDesigns Logo" class="img-responsive w250">
                            </a>
                        </div>

                        <div class="col-xs-6 text-right va-b pr5">
                            <div class="login-links">
                                <a class="active" title="Sign In">Sign In</a>
                            </div>

                        </div>

                    </div>

                    <div class="panel panel-info mt10 br-n">

                        <div class="panel-heading heading-border bg-white">

                        </div>

                        <!-- end .form-header section -->
                        <form method="post" action="index.php" id="contact">
                            <div class="panel-body bg-light p30">
                                <div class="row">
                                    <div class="col-sm-12 pr30">
                                        <div class="section">
                                            <label for="username" class="field-label text-muted fs18 mb10">Username</label>
                                            <label for="username" class="field prepend-icon">
                                                <input type="text" name="username" id="username" class="gui-input" placeholder="Enter username">
                                                <label for="username" class="field-icon">
                                                    <i class="fa fa-user"></i>
                                                </label>
                                            </label>
                                        </div>
                                        <!-- end section -->

                                        <div class="section">
                                            <label for="username" class="field-label text-muted fs18 mb10">Password</label>
                                            <label for="password" class="field prepend-icon">
                                                <input type="password" name="password" id="password" class="gui-input" placeholder="Enter password">
                                                <label for="password" class="field-icon">
                                                    <i class="fa fa-lock"></i>
                                                </label>
                                            </label>
                                        </div>
                                        <!-- end section -->
                                    </div>
                                </div>
                            </div>
                            <!-- end .form-body section -->
                            <div class="panel-footer clearfix p10 ph15">
                                <button type="submit" class="button btn-primary mr10 pull-right">Sign In</button>
                                <a class="switch ib switch-primary pull-left input-align mt10">
                                    <span>Forgot Password? Click here to reset.</span>
                                </a>
                            </div>
                            <!-- end .form-footer section -->
                        </form>
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
    <script src="vendor/jquery/jquery-3.1.1.min.js"></script>
    <script src="vendor/jquery/jquery_migrate/jquery-migrate-3.0.0.min.js"></script>
    <script src="vendor/jquery/jquery_ui/jquery-ui.min.js"></script>

    <!-- CanvasBG Plugin(creates mousehover effect) -->
    <script src="vendor/plugins/canvasbg/canvasbg.js"></script>

    <!-- Theme Javascript -->
    <script src="assets/js/utility/utility.js"></script>
    <script src="assets/js/demo/demo.js"></script>
    <script src="assets/js/main.js"></script>

    <!-- Page Javascript -->
    <script type="text/javascript">
        jQuery(document).ready(function() {
            "use strict";
            // Init Theme Core      
            Core.init();
            // Init Demo JS
            Demo.init();
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