<?php
$managePage = 'Manage Package';
$addPage = base_url() . "Master/Package/index/";
$deletePage = base_url() . "Master/Package/delete/";
$mainPage = base_url() . "Master/Package/";
$pageSave = base_url() . "Master/Package/savePackage/";
$pageBack = base_url() . "Master/Package/";
$operation = "Add Package";
// --------------------- Edit -----------------------//
$val_managername = $this->session->userdata['logged_in']['managerid'];
$checked = "";
$id = $package->id;
if ($id != "" && $id != 0) {
    $operation = "Edit Package";
    $val_package_name = $package->package_name;
    $val_package_amt = $package->total_amt;
    $val_packagedesc = $package->description;
    $val_managername = $package->managerid;
    $val_selected_services1 = $package->selected_services;
    $val_selected_services = explode(",", $package->selected_services);
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

        .admin-form .switch>label+span {
            width: 75%;
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
                                        <input type="hidden" class="selected_services" name="selected_services" value="<?= $val_selected_services1 ?>">
                                        <?php
                                        $auto = "";
                                        if ($operation == "Edit Package") {
                                            $auto = "autofocus";
                                        }
                                        echo "<div class='row'><div class='col-md-3'>";
                                        editbox("Package Name*", "package_name", "Enter Package Name", $val_package_name, 'required ' . $auto);
                                        echo "</div><div class='col-md-3'>";

                                        editbox(" Package Amount*", "package_amt", "Enter Package Amount", $val_package_amt, 'required');
                                        echo "</div> <div class='col-md-3'>";
                                        editbox("Package Description", "packagedesc", "Enter Package Description", $val_packagedesc, 'required');
                                        echo "</div> <div class='col-md-3'>";
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

            var selected_services = $('.selected_services').val().split(',');
            <?php
            if ($id != 0) {
                ?>
                array = selected_services;

            <?php } ?>
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


        function managerchange(val) {
            $("#dropmanagerid").val(val).change();
        }
    </script>

    <!-- END: PAGE SCRIPTS -->

</body>

</html>