<?php
$imageurl = "";
$username = "";
$pageSave = "main/companyselect";
$pageSave1 = "main/managerselect";
$selected = "";
$disabled = "";


if (!empty($this->session->userdata['logged_in']['user_image'])) {
    $imageurl = base_url() . $this->session->userdata['logged_in']['user_image'];
}
if (!empty($this->session->userdata['logged_in']['user_fullname'])) {
    $username = $this->session->userdata['logged_in']['user_fullname'];
}


if (!empty($this->session->userdata['logged_in']['companyid'])) {
    $companyid = $this->session->userdata['logged_in']['companyid'];
}

if (!empty($this->session->userdata['logged_in']['managerid'])) {
    $managerid = $this->session->userdata['logged_in']['managerid'];
}

$companyname = $this->Queries->getcompanylist();

$managername = $this->Queries->getmanagerlist();


?>

<header class="navbar navbar-fixed-top bg-primary">
    <div class="navbar-branding">
        <a href="<?= base_url("Dashboard"); ?>" class="navbar-brand">
            <i class="ti-infinite navbar-logo text-gradient bg-gradient-blue-purple"></i>
            <b><?= SITETITLE; ?></b>
        </a>
        <span id="toggle_sidemenu_l" class="ad ad-lines"></span>
    </div>
    <ul class="nav navbar-nav navbar-right">

        <li class="menu-divider hidden-xs"></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle fw600 p15" data-toggle="dropdown">
                <img src="<?= $imageurl; ?>" alt="" class="mw30 br64 mr15" />
                <span>
                    <?= $username; ?> <b class="caret"></b></span>
            </a>
            <ul class="dropdown-menu list-group dropdown-persist w250" role="menu">
                <?php

                if (!empty($company_disable == 1)) : $disabled = " disabled";
                else :
                    $disabled = " ";
                endif;

                if ($this->session->userdata['logged_in']['user_type'] == 1 && $companyhide == "") {
                    ?>
                    <li class="dropdown-header clearfix">
                        <div>
                            <?php echo form_open($pageSave, ['name' => 'frm2', 'id' => 'customform2',  'enctype' => 'multipart/form-data', 'class' => 'stdform']); ?>
                            <select id="cdropid" name="companyname" <?= $disabled ?> onChange="document.form.submit();">
                                <optgroup label="Company">
                                    <?php
                                        $i = 0;
                                        foreach ($companyname as $key => $value) {
                                            if ($companyid == $key) : $selected = "selected";
                                            else :
                                                $selected = "";
                                            endif;
                                            $i++;
                                            ?>
                                        <option value="<?= $key; ?>" <?= $selected; ?>><?= $companyname[$key] ?></option>
                                    <?php } ?>

                                </optgroup>
                            </select>
                            <?php echo form_close(); ?>
                        </div>
                    </li>
                <?php }

                if ($this->session->userdata['logged_in']['user_type'] < 3 && $managerhide == "") {

                    ?>
                    <li class="dropdown-header clearfix">
                        <div style="width:100%">
                            <?php echo form_open($pageSave1, ['name' => 'frm3', 'id' => 'customform3',  'enctype' => 'multipart/form-data', 'class' => 'stdform']); ?>
                            <select id="dropmanagerid" name="managername" <?= $disabled ?> onChange="document.form.submit();">
                                <optgroup label="Manager">
                                    <?php

                                        foreach ($managername as $key => $value) {
                                            if ($managerid == $key) :
                                                $selected = "selected";
                                            else :
                                                $selected = "";
                                            endif;
                                            ?>
                                        <option value="<?= $key; ?>" <?= $selected; ?>><?= $managername[$key] ?></option>
                                    <?php } ?>
                                </optgroup>
                            </select>
                            <?php echo form_close(); ?>
                        </div>
                    </li>
                <?php } ?>

                <li class="list-group-item">
                    <a href="<?= base_url('AccountSetting'); ?>" class="animated animated-short fadeInUp">
                        <span class="fa fa-gear"></span> Account Settings
                    </a>
                </li>

                <li class="dropdown-footer">
                    <a href="<?php echo base_url(); ?>Auth/logout" class="">
                        <span class="fa fa-power-off pr5"></span> Logout
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</header>
<!-----------------------------------------------------------------+ 
   "#sidebar_left" Helper Classes: 
-------------------------------------------------------------------+ 
   * Positioning Classes: 
	'.affix' - Sets Sidebar Left to the fixed position 

   * Available Skin Classes:
	 .sidebar-dark (default no class needed)
	 .sidebar-light  
	 .sidebar-light.light   
-------------------------------------------------------------------+
   Example: <aside id="sidebar_left" class="affix sidebar-light">
   Results: Fixed Left Sidebar with light/white background
------------------------------------------------------------------->
<?php

$url = $this->uri->segment(1);
$suburl = $this->uri->segment(2);
if($url == "Dashboard"){
    $menu_dashboard = 'class="active"';
}else if($url == "Company"){
    $menu_company = 'class="active"';
}else if($url == "Customer"){
    $menu_customer = 'class="active"';
}else if($url == "CustomerWallet"){
    $menu_customer_wallet = 'class="active"';
}else if($url == "Invoice"){
    $menu_invoice = 'class="active"';
}else if($url == "Enquiry"){
    $menu_enquiry = 'menu-open';
    if($suburl == "Source"){
        $submenu_enquirysource = 'class="active"';
    }else{
        $submenu_enquiry = 'class="active"';
    }
}else if($url == "Purchase" || $url == "Stock"){
    $menu_product = 'menu-open';
    if($url == "Purchase"){
        $submenu_purchase = 'class="active"';
    }else if($url == "Stock"){
        $submenu_stock = 'class="active"';
    }
}else if($url == "Expense" || $url == "StaffSalary"){
    $menu_expense = 'menu-open';
    if($url == "Expense"){
        $submenu_expense = 'class="active"';
    }else if($url == "StaffSalary"){
        $submenu_staffsalary = 'class="active"';
    }
}else if($url == "Report" || $url == "SendMessage"){
    $menu_report = 'menu-open';
    if($suburl == "General"){
        $submenu_generalreport = 'class="active"';
    }else if($suburl == "Bill"){
        $submenu_billreport = 'class="active"';
    }else if($suburl == "Treatment"){
        $submenu_treatmentreport = 'class="active"';
    }else if($suburl == "Product"){
        $submenu_productreport = 'class="active"';
    }else if($suburl == "Package"){
        $submenu_packagereport = 'class="active"';
    }else if($suburl == "Purchase"){
        $submenu_purchasereport = 'class="active"';
    }else if($suburl == "Stock"){
        $submenu_stockreport = 'class="active"';
    }else if($suburl == "Expense"){
        $submenu_expensereport = 'class="active"';
    }else if($suburl == "Enquiry"){
        $submenu_enquiryreport = 'class="active"';
    }else if($url == "SendMessage"){
        $submenu_sendmsg = 'class="active"';
    }
}else if($url == "Master"){
    $menu_master = 'menu-open';
    if($suburl == "Treatment"){
        $submenu_treatment = 'class="active"';
    }else if($suburl == "Package"){
        $submenu_package = 'class="active"';
    }else if($suburl == "Product"){
        $submenu_product = 'class="active"';
    }else if($suburl == "Vendor"){
        $submenu_vendor = 'class="active"';
    }else if($suburl == "Coupon"){
        $submenu_coupon = 'class="active"';
    }else if($suburl == "User"){
        $submenu_user = 'class="active"';
    }
}else if($url == "ImportData"){
    $menu_importdata = 'menu-open';
    if($suburl == "Customer"){
        $submenu_importcustomer = 'class="active"';
    }else if($suburl == "Treatment"){
        $submenu_importtreatment = 'class="active"';
    }else if($suburl == "Product"){
        $submenu_importproduct = 'class="active"';
    }else if($suburl == "Enquiry"){
        $submenu_importenquiry = 'class="active"';
    }
}

?>

<!-- Start: Sidebar Left -->
<aside id="sidebar_left" class="nano nano-primary affix">
    <!-- Start: Sidebar Left Content -->
    <div class="sidebar-left-content nano-content">
        <!-- Start: Sidebar Left Menu -->
        <ul class="nav sidebar-menu">

            <li class="sidebar-label pt20">Menu</li>
            <li <?= $menu_dashboard; ?>>
                <a href="<?= base_url('Dashboard'); ?>">
                    <span class="glyphicon glyphicon-home"></span>
                    <span class="sidebar-title">Dashboard</span>
                </a>
            </li>
            <?php if (check_role_assigned('company', 'view')) { ?>
            <li <?= $menu_company; ?>>
                    <a href="<?= base_url('Company'); ?>">
                        <span class="fa fa-building-o"></span>
                        <span class="sidebar-title">Manage Companies</span>
                    </a>
                </li>
            <?php } ?>
            <?php if (check_role_assigned('customer', 'view')) { ?>
            <li <?= $menu_customer; ?>>
                    <a href="<?= base_url('Customer'); ?>">
                        <span class="fa fa-users"></span>
                        <span class="sidebar-title">Manage Customers</span>
                    </a>
                </li>
            <?php } ?>
            <?php if (check_role_assigned('customerwallet', 'view')) { ?>
            <li <?= $menu_customer_wallet; ?>>
                    <a href="<?= base_url('CustomerWallet'); ?>">
                        <span class="fa fa-google-wallet"></span>
                        <span class="sidebar-title">Customer Wallet</span>
                    </a>
                </li>
            <?php } ?>
            <?php if (check_role_assigned('invoice', 'view')) { ?>
            <li <?= $menu_invoice; ?>>
                    <a href="<?= base_url('Invoice'); ?>">
                        <span class="fa fa-rupee"></span>
                        <span class="sidebar-title">Manage Invoice</span>
                    </a>
                </li>
            <?php } ?>

            <?php if (check_role_assigned('enquiry', 'view')) { ?>
                <li>
                    <a class="accordion-toggle <?= $menu_enquiry ?>" href="#">
                        <span class="fa fa-info-circle"></span>
                        <span class="sidebar-title">Enquiry</span>
                        <span class="caret"></span>
                    </a>
                    <ul class="nav sub-nav" style="">
                        <?php if (check_role_assigned('enquiry', 'view')) { ?>
                            <li <?= $submenu_enquiry ?>>
                                <a href="<?= base_url('Enquiry'); ?>">
                                    <span class="fa fa-info-circle"></span>
                                    <span class="sidebar-title">Manage Enquiry</span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (check_role_assigned('enquirysource', 'view')) { ?>
                            <li <?= $submenu_enquirysource ?>>
                                <a href="<?= base_url('Enquiry/Source'); ?>">
                                    <span class="fa fa-info-circle"></span>
                                    <span class="sidebar-title">Enquiry Source</span>
                                </a>
                            </li>
                        <?php } ?>

                    </ul>
                </li>
            <?php } ?>


            <?php if (check_role_assigned('purchase', 'view') || check_role_assigned('stock', 'view')) { ?>
                <li>
                    <a class="accordion-toggle  <?= $menu_product ?>" href="#">
                        <span class="fa fa-shopping-basket"></span>
                        <span class="sidebar-title">Purchase Stock</span>
                        <span class="caret"></span>
                    </a>
                    <ul class="nav sub-nav" style="">
                        <?php
                            if (check_role_assigned('purchase', 'view')) { ?>
                            <li <?= $submenu_purchase ?>>
                                <a href="<?= base_url('Purchase'); ?>">
                                    <span class="fa fa-shopping-bag"></span> Purchase Stock
                                </a>
                            </li>
                        <?php }
                            if (check_role_assigned('stock', 'view')) { ?>
                            <li  <?= $submenu_stock ?>>
                                <a href="<?= base_url('Stock'); ?>">
                                    <span class="fa fa-shopping-basket"></span> View Stocks
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>
            <?php if (check_role_assigned('expense', 'view') || check_role_assigned('staffsalary', 'view')) { ?>
                <li>
                    <a class="accordion-toggle <?= $menu_expense ?>" href="#">
                        <span class="fa fa-money"></span>
                        <span class="sidebar-title">Salary & Expense</span>
                        <span class="caret"></span>
                    </a>
                    <ul class="nav sub-nav" style="">
                        <?php if (check_role_assigned('staffsalary', 'view')) { ?>
                            <li <?= $submenu_staffsalary ?>>
                                <a href="<?= base_url('StaffSalary'); ?>">
                                    <span class="fa fa-money"></span>
                                    <span class="sidebar-title">Manage Staff Salary</span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (check_role_assigned('expense', 'view')) { ?>
                            <li <?= $submenu_expense ?>>
                                <a href="<?= base_url('Expense'); ?>">
                                    <span class="fa fa-money"></span>
                                    <span class="sidebar-title">Manage Expense</span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>

            <?php if (check_role_assigned('report', 'view')) { ?>
                <li>
                    <a class="accordion-toggle <?= $menu_report ?>" href="#">
                        <span class="fa fa-bar-chart"></span>
                        <span class="sidebar-title">Reports</span>
                        <span class="caret"></span>
                    </a>
                    <ul class="nav sub-nav" style="">
                        <?php if (check_role_assigned('generalreport', 'view')) { ?>
                            <li <?= $submenu_generalreport ?>>
                                <a href="<?= base_url('Report/General'); ?>">
                                    <span class="fa fa-black-tie"></span> General Report
                                </a>
                            </li>
                        <?php }
                            if (check_role_assigned('billreport', 'view')) { ?>
                            <li <?= $submenu_billreport ?>>
                                <a href="<?= base_url('Report/Bill'); ?>">
                                    <span class="fa fa-rupee"></span> Bill Report
                                </a>
                            </li>
                        <?php }
                            if (check_role_assigned('treatmentreport', 'view')) { ?>
                            <li <?= $submenu_treatmentreport ?>>
                                <a href="<?= base_url('Report/Treatment'); ?>">
                                    <span class="fa fa-cut"></span> Treatment Report
                                </a>
                            </li>
                        <?php }
                            if (check_role_assigned('productreport', 'view')) { ?>
                            <li <?= $submenu_productreport ?>>
                                <a href="<?= base_url('Report/Product'); ?>">
                                    <span class="fa fa-shopping-cart"></span> Product Report
                                </a>
                            </li>
                        <?php }
                            if (check_role_assigned('packagereport', 'view')) { ?>
                            <li <?= $submenu_packagereport ?>>
                                <a href="<?= base_url('Report/Package'); ?>">
                                    <span class="fa fa-shopping-cart"></span> Package Report
                                </a>
                            </li>
                        <?php }
                            if (check_role_assigned('purchasereport', 'view')) { ?>
                            <li <?= $submenu_purchasereport ?>>
                                <a href="<?= base_url('Report/Purchase'); ?>">
                                    <span class="fa fa-shopping-bag"></span> Purchase Report
                                </a>
                            </li>
                        <?php }
                            if (check_role_assigned('stockreport', 'view')) { ?>
                            <li <?= $submenu_stockreport ?>>
                                <a href="<?= base_url('Report/Stock'); ?>">
                                    <span class="fa fa-cart-plus"></span> Stock Report
                                </a>
                            </li>
                        <?php }
                            if (check_role_assigned('expensereport', 'view')) { ?>
                            <li <?= $submenu_expensereport ?>>
                                <a href="<?= base_url('Report/Expense'); ?>">
                                    <span class="fa fa-credit-card"></span> Expense Report
                                </a>
                            </li>
                        <?php }
                            if (check_role_assigned('enquiryreport', 'view')) { ?>
                            <li <?= $submenu_enquiryreport ?>>
                                <a href="<?= base_url('Report/Enquiry'); ?>">
                                    <span class="fa fa-credit-card"></span> Enquiry Report
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (check_role_assigned('sendmsg', 'view')) { ?>
                            <li <?= $submenu_sendmsg ?>>
                                <a href="<?= base_url('SendMessage'); ?>">
                                    <span class="fa fa-envelope"></span>
                                    <span class="sidebar-title">Message Report</span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>
            <?php if (check_role_assigned('masters', 'view')) { ?>
                <li>
                    <a class="accordion-toggle <?= $menu_master ?>" href="#">
                        <span class="fa fa-cogs"></span>
                        <span class="sidebar-title">Masters</span>
                        <span class="caret"></span>
                    </a>
                    <ul class="nav sub-nav" style="">
                        <?php if (check_role_assigned('treatment', 'view')) { ?>
                            <li <?= $submenu_treatment ?>>
                                <a href="<?= base_url('Master/Treatment'); ?>">
                                    <span class="fa fa-cut"></span>
                                    <span class="sidebar-title">Manage Treatment</span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (check_role_assigned('package', 'view')) { ?>
                            <li <?= $submenu_package ?>>
                                <a href="<?= base_url('Master/Package'); ?>">
                                    <span class="fa fa-gift"></span>
                                    <span class="sidebar-title">Manage Package</span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (check_role_assigned('product', 'view')) { ?>
                            <li <?= $submenu_product ?>>
                                <a href="<?= base_url('Master/Product'); ?>">
                                    <span class="fa fa-shopping-cart"></span> Manage Product
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (check_role_assigned('vendor', 'view')) { ?>
                            <li <?= $submenu_vendor ?>>
                                <a href="<?= base_url('Master/Vendor'); ?>">
                                    <span class="fa fa-user-circle-o"></span> Manage Vendors
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (check_role_assigned('coupon', 'view')) { ?>
                            <li <?= $submenu_coupon ?>>
                                <a href="<?= base_url('Master/Coupon'); ?>">
                                    <span class="fa fa-gift"></span>
                                    <span class="sidebar-title">Manage Coupons</span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (check_role_assigned('user', 'view')) { ?>
                            <li <?= $submenu_user ?>>
                                <a href="<?= base_url('Master/User'); ?>">
                                    <span class="fa fa-user-plus"></span>
                                    <span class="sidebar-title">Manage Users</span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>

            <?php if (check_role_assigned('importdata', 'view')) { ?>
                <li>
                    <a class="accordion-toggle <?= $menu_importdata ?>" href="#">
                        <span class="fa fa-cogs"></span>
                        <span class="sidebar-title">Import Data</span>
                        <span class="caret"></span>
                    </a>
                    <ul class="nav sub-nav" style="">
                        <?php if (check_role_assigned('importcustomer', 'view')) { ?>
                            <li <?= $submenu_importcustomer ?>>
                                <a href="<?= base_url('ImportData/Customer/'); ?>">
                                    <span class="fa fa-users"></span>
                                    <span class="sidebar-title">Import Customers</span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (check_role_assigned('importtreatment', 'view')) { ?>
                            <li <?= $submenu_importtreatment ?>>
                                <a href="<?= base_url('ImportData/Treatment/'); ?>">
                                    <span class="fa fa-cut"></span>
                                    <span class="sidebar-title">Import Treatments</span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (check_role_assigned('importproduct', 'view')) { ?>
                            <li <?= $submenu_importproduct ?>>
                                <a href="<?= base_url('ImportData/Product/'); ?>">
                                    <span class="fa fa-shopping-cart"></span> Import Products
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (check_role_assigned('importenquiry', 'view')) { ?>
                            <li <?= $submenu_importenquiry ?>>
                                <a href="<?= base_url('ImportData/Enquiry/'); ?>">
                                    <span class="fa fa-info-circle"></span> Import Enquiries
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>
        </ul>
        <!-- End: Sidebar Menu -->
    </div>
    <!-- End: Sidebar Left Content -->
</aside>
<!-- End: Sidebar Left -->