<?php
$managePage = 'Manage Vendor';
$addPage = base_url() . "Vendor/index/";
$deletePage = base_url() . "Vendor/delete/";
$mainPage = base_url() . "Vendor/";
$pageSave = base_url() . "Vendor/save/";
$pageBack = base_url() . "Vendor/";
$operation = "Add Vendor";
// --------------------- Edit -----------------------//
$id = $vendor->id;
if ($id != "" && $id != 0) {
    $operation = "Edit Vendor";
    $val_vendor_name = $vendor->vendor_name;
    $val_address = $vendor->address;
    $val_mobile = $vendor->mobile;
    $val_email = $vendor->email;
    $val_gstno = $vendor->gstno;
    $val_comment = $vendor->comment;
}
?>
<!DOCTYPE html>
<html>

<head>
    <?php $this->load->view("Includes/head.php"); ?>
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
                                            <th>Vendor Name</th>
                                            <th>Address</th>
                                            <th>Gstno</th>
                                            <th style="width: 20%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($vendorlist)) : ?>
                                            <?php
                                                $i = 0;
                                                $i = $page;
                                                foreach ($vendorlist as $post) : $i++;
                                                    ?>
                                                <tr>
                                                    <td>
                                                        <?= $post->vendor_name; ?>
                                                        <br>
                                                        <a href="tel:<?= $post->mobile; ?>">
                                                            <?= $post->mobile; ?></a>

                                                    </td>
                                                    <td>
                                                        <?= $post->address; ?>
                                                        <br>
                                                        <a href="mailto:<?= $post->email; ?>">
                                                            <?= $post->email; ?></a>
                                                    </td>
                                                    <td>
                                                        <?= $post->gstno;   ?><br><?= $post->comment; ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                                if (check_role_assigned('vendor', 'edit')) {

                                                                    echo anchor($addPage . $post->id, '<span class="fa fa-edit" style="valign:center"></span>', ['class' => 'label label-success', 'style' => 'float:left;margin-right:5px;']);
                                                                }
                                                                if (check_role_assigned('vendor', 'delete')) {
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
                                        if ($operation == "Edit Vendor") {
                                            $auto = "autofocus";
                                        }
                                        editbox("Vendor Name", "vendor_name", "Enter Vendor Name", $val_vendor_name, 'required ' . $auto);
                                        editbox("Vendor Email", "email", "Enter Vendor Email", $val_vendor_email, 'required');
                                        editbox("Mobile", "mobile", "Enter Mobile No.", $val_mobile, 'required pattern="[6789][0-9]{9}" ');
                                        editbox("Phone", "phone", "Enter Phone No.", $val_mobile, ' pattern="\d*"');
                                        editbox("GST No.", "gstno", "Enter GST No.", $val_gstno);
                                        textareabox("Address", "address", "Enter Address", $val_address);
                                        textareabox("Description", "comment", "Enter Description", $val_comment);

                                        ?>

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