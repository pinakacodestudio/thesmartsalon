<?php

$saveItemPage = base_url() . "Invoice/saveInvoiceData/";
$checkCode = base_url() . "Invoice/checkCode/";
$deletePage = base_url() . "Invoice/deleteItem/";
$getServicePrice = base_url() . "Invoice/getServicePrice/";
$getProductPrice = base_url() . "Invoice/getProductPrice/";
$getPackagePrice = base_url() . "Invoice/getPackagePrice/";
$saveBilldatePage = base_url() . "Invoice/saveInvoiceBillDate/";

$editPage = base_url() . "Invoice/editItem";
$editPage1 = base_url() . "Invoice/editItem1";
?>
<script type="text/javascript">
    function SubmitBox() {
        return true;
    }

    function calAmount() {
        var price = parseInt($("#price").val());
        var qty = parseInt($("#qty").val());
        $("#amt").val(price * qty);
    }

    function calAmount2() {
        var price = parseInt($("#charges").val());
        var qty = parseInt($("#qty2").val());
        $("#amt2").val(price * qty);
    }

    function calTotal() {
        var invid = parseInt($("#invid").val());
        var total = parseInt($("#totalamt").val());
        var disamt = $("#discount").val();
        var wltamt = $("#wltamt").val();
        var discountedtotal = 0;

        discountedtotal = total - disamt;
        if (discountedtotal < 0)
            discountedtotal = 0;

        $('#finalamt').val(discountedtotal);
        $('#finamt').val(discountedtotal);
        var amtpaid = discountedtotal - wltamt;
        if (amtpaid < 0) {
            amtpaid = 0;
        }
        $('#amtpaid').val(amtpaid);

        $('.loadcontainer').hide();
    }

    function checkCouponCode() {
        $('.loadcontainer').show();
        var invid = parseInt($("#invid").val());
        var code = $("#code").val();
        var custid = <?= $custid; ?>;
        var total = parseInt($("#totalamt").val());
        var discount = parseInt($("#discount").val());

        discountedtotal = total - discount;
        if (discountedtotal < 0)
            discountedtotal = 0;

        $('#finalamt').val(discountedtotal);
        $('#finamt').val(discountedtotal);
        if (code != "") {
            $.ajax({
                url: '<?= $checkCode; ?>',
                data: {
                    invid: invid,
                    custid: custid,
                    code: code,
                },
                type: "post",
                success: function(data) {
                    if (data.status == 1) {
                        $('#discount').val(data.discount);
                        $('#discount_amount').val(data.discount);
                        if (data.chkwallet == 1) {
                            var wallet_amount = data.available_wallet;
                            $('#wall_amount').val(wallet_amount);
                            var atm = wallet_amount;
                            if (atm > discountedtotal) {
                                atm = discountedtotal;
                            }
                            $('#wltamt').val(atm);
                            $('#availamt').html('( Available Rs. ' + wallet_amount + ' )');
                            $("#usewallet").prop("checked", true);
                        }
                        $('#promodesc').html(data.cdescription);
                        calTotal();
                    }
                }
            });
        } else {
            $('#discount').val(0);
            $('#discount_amount').val(0);
            discountedtotal = total - 0;
            if (discountedtotal < 0)
                discountedtotal = 0;

            $('#finalamt').val(discountedtotal);
            $('#finamt').val(discountedtotal);
            $('#promodesc').html("Choose Coupon and Click Apply Promo");
            var wallet_amount = $("#oldwall_amount").val();
            var currentwallet = $("#currentwallet").val();
            $('#wall_amount').val(wallet_amount);
            $('#wltamt').val(0);
            if (currentwallet == "") {
                currentwallet = 0;
            }
            $('#availamt').html('( Available Rs. ' + currentwallet + ' )');
            calTotal();
        }
        $('.loadcontainer').hide();
    }

    $(document).ready(function() {
        $('#usewallet').change(function() {
            var wallet_amount = parseInt($('#wall_amount').val());
            var wltamt = parseInt($('#wltamt').val());
            var oldwall_amount = parseInt($('#oldwall_amount').val());
            var finamt = parseInt($('#finamt').val());
            if (this.checked) {
                if (oldwall_amount > finamt) {
                    wallet_amount = finamt;
                }
                var amtpaid = finamt - wallet_amount;
                $('#wltamt').val(wallet_amount);
                $('#amtpaid').val(amtpaid);
            } else {
                oldwall_amount = oldwall_amount + wltamt;
                $('#wltamt').val(0);
                $('#oldwall_amount').val(oldwall_amount);
                $('#amtpaid').val(finamt);
            }
        });
        $('#discount').change(function() {
            calTotal();
        });

        $(".addService").click(function(e) {
            e.preventDefault();
            $('.loadcontainer').show();

            var custid = <?= $custid; ?>;
            var tdate = $('#treatdate').val();
            var userid = $('#userid').val();
            var treatment = $("#treatment option:selected").val();
            var invid = $("#invid").val();
            var qty = $("#qty2").val();
            var charges = $('#charges').val();
            var comment = $('#comment').val();

            if (userid == "") {
                validBox("Select a Shop Person");
                $("#userid").focus();
                return false;
            } else if (treatment == "") {
                validBox("Select a Treatment");
                $("#treatment").focus();
                return false;
            } else if (charges == "0" || charges == "") {
                validBox("Enter Price For Service");
                $("#charges").focus();
                return false;
            } else if (qty == "0" || qty == "") {
                validBox("Enter Quantity For Service");
                $("#qty2").focus();
                return false;
            }

            $.ajax({
                url: '<?= $saveItemPage; ?>',
                data: {
                    custid: custid,
                    invid: invid,
                    tdate: tdate,
                    userid: userid,
                    qty: qty,
                    ctype: 1,
                    treatment: treatment,
                    charges: charges,
                    comment: comment
                },
                type: "post",
                success: function(data) {
                    if (data.status == 1) {
                        $("#invid").val(data.invid);
                        $("#totalamt").val(data.total);
                        $("#tblTotal").html(data.total);
                        $("#billno").html(data.billno);
                        $("#addTarget").append(data.tabledata);
                        $("#treatment").val('').change();
                        $("#userid").val('').change();
                        $("#charges").val(0);
                        $("#amt2").val(0);
                        $("#qty2").val(1);
                        $("#comment").val("");
                        calTotal();

                    }
                }
            });
        });

        $(".billEdit").click(function(e){
           e.preventDefault(); 
           $("#BillShow").hide(); 
           $("#BillEditShow").show();
        });
        $(".billdatesave").click(function(e) {
            e.preventDefault();
             var invid = $("#invid").val();
             var billdate = $("#billdate").val();
             $.ajax({
                url: '<?= $saveBilldatePage; ?>',
                data: {
                    invid: invid,
                    billdate: billdate
                },
                type: "post",
                success: function(data) {
                    if (data.status == 1) {
                        $("#billdate").val(data.billdate);
                        $("#showbillDate").html(data.tdate);
                        $("#BillShow").show(); 
                        $("#BillEditShow").hide();
                    }
                }
            });
        });

        $(".addProduct").click(function(e) {
            e.preventDefault();
            $('.loadcontainer').show();
            var custid = <?= $custid; ?>;
            var tdate = $('#selldate').val();
            var userid = $('#puserid').val();
            var product = $("#productdata option:selected").val();
            var invid = $("#invid").val();
            var charges = $('#price').val();
            var qty = $('#qty').val();
            var comment = $('#comment2').val();

            if (userid == "") {
                validBox("Select a Shop Person");
                $("#userid").focus();
                return false;
            } else if (product == "") {
                validBox("Select a Product");
                $("#productdata").focus();
                return false;
            } else if (charges == "0" || charges == "") {
                validBox("Enter Price For Product");
                $("#price").focus();
                return false;
            } else if (qty == "0" || qty == "") {
                validBox("Enter Quantity For Product");
                $("#qty").focus();
                return false;
            }

            $.ajax({
                url: '<?= $saveItemPage; ?>',
                data: {
                    custid: custid,
                    invid: invid,
                    tdate: tdate,
                    userid: userid,
                    qty: qty,
                    ctype: 2,
                    treatment: product,
                    charges: charges,
                    comment: comment
                },
                type: "post",
                success: function(data) {
                    if (data.status == 1) {
                        $("#invid").val(data.invid);
                        $("#totalamt").val(data.total);
                        $("#tblTotal").html(data.total);
                        $("#billno").html(data.billno);
                        $("#addTarget").append(data.tabledata);
                        $("#price").val(0);
                        $("#productdata").val('').change();
                        $("#puserid").val('').change();
                        $("#amt").val(0);
                        $("#qty").val(1);
                        $("#comment2").val("");
                        calTotal();
                    }
                }
            });
        });

        $(".addPackage").click(function(e) {
            e.preventDefault();
            $('.loadcontainer').show();

            var custid = <?= $custid; ?>;
            var pdate = $('#packagedate').val();
            var package = $("#package option:selected").val();
            var invid = $("#invid").val();
            var qty = 1;
            var pricepack = $('#pricepack').val();
            var comment = $('#comment').val();

            if (package == "") {
                validBox("Select a Package");
                $("#pakcage").focus();
                return false;
            } else if (pricepack == "0" || pricepack == "") {
                validBox("Enter Price For Package");
                $("#pricepack").focus();
                return false;
            }

            $.ajax({
                url: '<?= $saveItemPage; ?>',
                data: {
                    custid: custid,
                    invid: invid,
                    tdate: pdate,
                    userid: 0,
                    qty: qty,
                    ctype: 3,
                    treatment: package,
                    charges: pricepack,
                    comment: comment
                },
                type: "post",
                success: function(data) {
                    if (data.status == 1) {
                        $("#invid").val(data.invid);
                        $("#totalamt").val(data.total);
                        $("#tblTotal").html(data.total);
                        $("#billno").html(data.billno);
                        $("#addTarget").append(data.tabledata);
                        $("#package").val('').change();
                        $("#pricepack").val(0);
                        $("#comment").val("");
                        calTotal();

                    }
                }
            });
        });
    });
</script>
<script src="<?php echo base_url('assets/vendor/plugins/select2/js/select2.min.js'); ?>"></script>
<script type="text/javascript">
    $(".select2-single").select2({
        allowClear: true
    });

    function deleteRecord(val) {
        var invid = $("#invid").val();
        swal({
                title: "Are you sure?",
                text: "You will not be able to recover this Records!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: true,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $('.loadcontainer').show();
                    $.ajax({
                        url: '<?= $deletePage; ?>',
                        data: {
                            invid: invid,
                            delid: val,
                        },
                        type: "post",
                        success: function(data) {
                            if (data.status == 1) {
                                $("#item_" + val).remove();
                                $("#totalamt").val(data.total);
                                $("#tblTotal").html(data.total);
                                calTotal();
                            }else{
                                swal({
                                    title: "Permission Issue",
                                    text: "You Don't Have Right to Delete the Records",
                                    type: "error",
                                    confirmButtonClass: "btn-danger"
                                });
                                $('.loadcontainer').hide();
                            }
                        }
                    });

                } else {
                    swal({
                        title: "Cancelled",
                        text: "Your Records are safe :)",
                        type: "error",
                        confirmButtonClass: "btn-danger"
                    });
                }
            });
    }
    jQuery(document).ready(function() {
        "use strict";
        // Init Theme Core      
        Core.init();
        $('#datatable2').dataTable({
            order: [],
            "scrollY": "580px",
            "scrollCollapse": true,
            "paging": false,
            "scrollX": true,
            dom: '<"top"fl>rt<"bottom"ip>'
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

    function validBox(msg) {
        $('.loadcontainer').hide();
        $('#modaltext').html(msg);
        $('#myModal').modal('show');
        setTimeout(function() {
            $('#myModal').modal('hide')
        }, 1000);
    }

    function getServicePrice(val) {
        $('.loadcontainer').show();
        var serviceid = val;

        if (serviceid != "") {
            $.ajax({
                url: '<?= $getServicePrice; ?>',
                data: {
                    serviceid: serviceid,
                },
                type: "post",
                success: function(data) {
                    if (data.status == 1) {
                        $('#charges').val(data.price);
                        calAmount2();
                    }
                }
            });
        } else {
            $('#charges').val(0);
            calAmount2();
        }
        $('.loadcontainer').hide();
    }

    function getProductPrice(val) {
        $('.loadcontainer').show();
        var productid = val;


        if (productid != "") {
            $.ajax({
                url: '<?= $getProductPrice; ?>',
                data: {
                    productid: productid
                },
                type: "post",
                success: function(data) {
                    if (data.status == 1) {
                        $('#price').val(data.price);
                        calAmount();
                    }
                }
            });
        } else {
            $('#price').val(0);
            calAmount();
        }
        $('.loadcontainer').hide();
    }

    function getPackagePrice(val) {
        $('.loadcontainer').show();
        var packid = val;

        if (packid != "") {
            $.ajax({
                url: '<?= $getPackagePrice; ?>',
                data: {
                    packid: packid,
                },
                type: "post",
                success: function(data) {
                    if (data.status == 1) {
                        $('#pricepack').val(data.price);
                        $('#packdescription').html(data.description);
                    }
                }
            });
        } else {
            $('#pricepack').val(0);
            $('#packdescription').html("");
        }
        $('.loadcontainer').hide();
    }
</script>
<!-- END: PAGE SCRIPTS -->