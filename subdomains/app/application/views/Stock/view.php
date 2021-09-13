<?php
$managePage = 'Current Stock For : ' . $productname;
$mainPage = base_url() . "Stock/index/";
$invoicePage = base_url() . "Invoice/addInvoice/";
$purchasePage = base_url() . "Purchase/index/";

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
                        <li>
                            <a href="<?= base_url('Stock') ?>">
                                Stock
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
                                            <th>Date</th>
                                            <th>Invoice</th>
                                            <th>Type</th>
                                            <th>Vendor / Service Provider</th>
                                            <th>Credit</th>
                                            <th>Debit</th>
                                            <th style="width: 20%;">View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($producthistory)) : ?>
                                            <?php
                                                $i = 0;
                                                $i = $page;
                                                $balance = 0;
                                                foreach ($producthistory as $post) : $i++;

                                                    $balance += $post->qty;
                                                    $date = new DateTime($post->billdate);
                                                    $billdate = $date->format('d-m-Y');
                                                    if ($post->ctype == 1) {
                                                        $invoictype = "Inventory Purchase";
                                                        $credit = $post->qty;
                                                        $debit = 0;
                                                        $mainPage = $purchasePage . $post->billid;
                                                    } else if ($post->ctype == 2) {
                                                        $invoictype = "Product Sell";
                                                        $credit = 0;
                                                        $debit = $post->qty;
                                                        $mainPage = $invoicePage . $post->custid . "/" . $post->billid;
                                                    }


                                                    ?>
                                                <tr>
                                                    <td>
                                                        <?= $billdate; ?>
                                                    </td>
                                                    <td>
                                                        <?= $post->billno; ?>
                                                    </td>
                                                    <td>
                                                        <?= $invoictype; ?>
                                                    </td>
                                                    <td>
                                                        <?= $post->username; ?>
                                                    </td>
                                                    <td>
                                                        <?= $credit; ?>
                                                    </td>
                                                    <td>
                                                        <?= $debit; ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                                if (check_role_assigned('stock', 'view')) {

                                                                    echo '<a href="' . $mainPage . '" class="label label-primary" target="_blank"><span class="fa fa-search" style="valign:center"> View</span></a>';
                                                                }
                                                                ?>

                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4">&nbsp;</td>
                                            <td colspan="2"><b>Current Stock : <?= $balance; ?></b></td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </tfoot>
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