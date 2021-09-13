<?php
$pageSave = "Changepass/savepass";
$pageBack = "Dashboard";
$managePage = "Change Password";
?>
<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('Includes/head'); ?>
</head>

<body class="dashboard-page sb-l-o sb-r-c">
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
                    <li class="crumb-trail">Change Password</li>
                </ol>
            </div>
        </header>
        <!-- End: Topbar -->
        <!-- Begin: Content -->
        <section id="content" class="animated fadeIn">

            <?php alertbox(); ?>

            <div class="panel panel-default panel-border top">
                <?php echo form_open($pageSave,['name'=>'frm1','onsubmit'=>'return onSubmitBox()','enctype'=>'multipart/form-data','class'=>'stdform']); ?>
                <div class="panel-heading">
                    <span class="panel-title"> <?= $managePage; ?></span>
                </div>
                <div class="panel-body">
                    <?php
                    passwordbox('4','Old Password','oldpass','Enter Old Password',"");
                    passwordbox('4','New Password','newpass','Enter New Password',"");
                    passwordbox('4','Confirm Password','confirmpass','Enter Confirm Pass',"");
                    submitbutton($pageBack);
                    ?>
                </div>
                <?php form_close(); ?>
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
    function onSubmitBox(){

        var title="";
        var ttext="";

        var oldpass = $("#oldpass").val();
        var newpass = $("#newpass").val();
        var confirmpass = $("#confirmpass").val();

        if(oldpass == ""){
            title = "Old Password";
            ttext = "Please Enter Old Password";
            document.frm1.oldpass.focus();
        }else if(newpass == ""){
            title = "New Password";
            ttext = "Please Enter New Password";
            document.frm1.newpass.focus();
        }else if(confirmpass == ""){
            title = "Confirm Password";
            ttext = "Please Enter Confirm Password";
            document.frm1.confirmpass.focus();
        }else if(newpass != confirmpass){
            title = "Password";
            ttext = "New Password and Confirm Password Didn't Match";
            document.frm1.newpass.focus();
        }
        if(title != "" && ttext != "") {
            swal({
                title: title,
                text: ttext,
                type: "error",
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Ok"
            });
            return false;
        }else{
            return true;
        }
    }
</script>
</body>
</html>
