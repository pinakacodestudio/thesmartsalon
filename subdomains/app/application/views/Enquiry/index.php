<?php
$managePage = 'Manage Enquiry';
$addPage = base_url() . "Enquiry/index/";
$deletePage = base_url() . "Enquiry/delete/";
$mainPage = base_url() . "Enquiry/";
$pageSave = base_url() . "Enquiry/save/";
$pageBack = base_url() . "Enquiry/";
$operation = "Add Enquiry";
// --------------------- Edit -----------------------//
$id = $enquiry->id;
if ($id != "" && $id != 0) {
    $operation = "Edit Enquiry";
    $val_cname = $enquiry->customername;
    $val_mobile = $enquiry->mobile;
    $val_email = $enquiry->email;
    $val_address = $enquiry->address;
    $val_efor = $enquiry->enquiryfor;
    $val_type = $enquiry->type;
    $val_response = $enquiry->response;
    $val_enquirysource = $enquiry->leadsource;
    $val_leadstatus = $enquiry->leadstatus;
    $val_username = $enquiry->leaduser;
    $val_followdate = $enquiry->date;
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

                        <div class="col-lg-12 col-sm-12">
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
                                        if ($operation == "Edit Enquiry") {
                                            $auto = "autofocus";
                                        }
                                        echo "<div class='row'>
                                        <div class='col-md-3'>";
                                        editbox("Customer Name", "cname", "Enter Customer Name", $val_cname, 'required ' . $auto);
                                        echo "</div> <div class='col-md-3'>";
                                        editbox("Contact Number", "cnumber", "Enter Contact Number", $val_cnumber, 'required pattern="[6789][0-9]{9}"');
                                        echo "</div><div class='col-md-3'>";
                                        emailbox('Email Id', 'emailid', 'Enter Email Id', $val_email);
                                        echo "</div> <div class='col-md-3'>";
                                        editbox("Address", "addr", "Enter Address", $val_address);
                                        echo "</div></div><div class='row'> <div class='col-md-3'>";
                                        editbox("Enquiry For", "efor", "services / products / packages ", $val_efor, 'required');
                                        echo "</div> <div class='col-md-3'>";
                                        dropdownbox("Enquiry Type", "etype", $enquirytype, $val_type);
                                        echo "</div> <div class='col-md-3'>";
                                        editbox("Response", "resp", "Enter Response", $val_response);
                                        echo "</div> <div class='col-md-3'>";
                                        datepicker("Date to follow", "follow", "Enter follow date", $val_followdate);
                                        echo "</div></div><div class='row'> <div class='col-md-3'>";
                                        dropdownbox("Source of Lead", "sourcetype", $enquirysource, $val_enquirysource, 'required');
                                        echo "</div> <div class='col-md-3'>";
                                        dropdownbox("Lead reprensetative", "leaduser", $userlist, $val_username, 'required');
                                        echo "</div> <div class='col-md-3'>";
                                        dropdownbox("Lead Status", "leadstatus", $leadstatus, $val_leadstatus);
                                        echo "</div> <div class='col-md-3 pt20'>";
                                        submitbutton($pageBack);
                                        echo "</div></div> ";

                                        ?>

                                        <?php echo form_close(); ?>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="col-lg-12 col-sm-12">
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
                                            <th>Customer</th>
                                            <th>Enquiry for</th>
                                            <th>Lead type</th>
                                            <th>Source</th>
                                            <th>Date to Follow</th>
                                            <th>Reprsentative</th>
                                            <th>Status</th>
                                            <th style="width: 20%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($enquirylist)) : ?>
                                            <?php
                                                $i = 0;
                                                $i = $page;
                                                foreach ($enquirylist as $post) : $i++;

                                                    $date = new DateTime($post->date);
                                                    $enquirydate = $date->format('d/m/Y');

                                                    ?>
                                                <tr>
                                                    <td>
                                                        <?= $post->customername; ?>
                                                        <br>
                                                        <a href="tel:<?= $post->mobile; ?>"><?= $post->mobile; ?></a>
                                                    </td>
                                                    <td>
                                                        <?= $post->enquiryfor; ?>
                                                    </td>
                                                    <td>
                                                        <?= $post->type; ?>
                                                    </td>
                                                    <td>
                                                        <?= $post->leadsource; ?>
                                                    </td>
                                                    <td>
                                                        <?= $enquirydate; ?>
                                                    </td>
                                                    <td>
                                                        <?= $post->person_name; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($post->leadstatus == 0) {
                                                                    echo "Pending";
                                                                } else if ($post->leadstatus == 1) {
                                                                    echo "Converted";
                                                                } else if ($post->leadstatus == 2) {
                                                                    echo "Close";
                                                                }; ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                                if (check_role_assigned('enquiry', 'edit')) {

                                                                    echo anchor($addPage . $post->id, '<span class="fa fa-edit" style="valign:center"></span>', ['class' => 'label label-success', 'style' => 'float:left;margin-right:5px;']);
                                                                }

                                                                if (check_role_assigned('enquiry', 'delete')) {
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