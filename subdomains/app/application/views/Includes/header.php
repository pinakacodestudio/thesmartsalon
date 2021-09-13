<?php
$imageurl = "";
$username = "";
if (!empty($this->session->userdata['logged_in']['user_image'])) {
    $imageurl = base_url() . $this->session->userdata['logged_in']['user_image'];
}
if (!empty($this->session->userdata['logged_in']['username'])) {
    $username = $this->session->userdata['logged_in']['username'];
}
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

        <li class="menu-divider hidden-xs">
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle fw600 p15" data-toggle="dropdown">
                <img src="<?= $imageurl; ?>" alt="" class="mw30 br64 mr15" />
                <span>
                    <?= $username; ?> <b class="caret"></b></span>
            </a>
            <ul class="dropdown-menu list-group dropdown-persist w250" role="menu">

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

<!-- Start: Sidebar Left -->
<aside id="sidebar_left" class="nano nano-primary affix">
    <!-- Start: Sidebar Left Content -->
    <div class="sidebar-left-content nano-content">
        <!-- Start: Sidebar Left Menu -->
        <ul class="nav sidebar-menu">

            <li class="sidebar-label pt20">Menu</li>
            <li class="active">
                <a href="<?= base_url('Dashboard'); ?>">
                    <span class="glyphicon glyphicon-home"></span>
                    <span class="sidebar-title">Dashboard</span>
                </a>
            </li>

            <?php if (check_role_assigned('customer', 'view')) { ?>
                <li>
                    <a href="<?= base_url('Customer'); ?>">
                        <span class="fa fa-users"></span>
                        <span class="sidebar-title">Manage Customers</span>
                    </a>
                </li>
            <?php } ?>
            <?php if (check_role_assigned('invoice', 'view')) { ?>
                <li>
                    <a href="<?= base_url('Invoice'); ?>">
                        <span class="fa fa-rupee"></span>
                        <span class="sidebar-title">Manage Invoice</span>
                    </a>
                </li>
            <?php } ?>
            <?php if (check_role_assigned('treatment', 'view')) { ?>
                <li>
                    <a href="<?= base_url('Treatment'); ?>">
                        <span class="fa fa-cut"></span>
                        <span class="sidebar-title">Manage Treatment</span>
                    </a>
                </li>
            <?php } ?>

            <?php if (check_role_assigned('product', 'view')) { ?>
                <li>
                    <a class="accordion-toggle" href="#">
                        <span class="fa fa-shopping-basket"></span>
                        <span class="sidebar-title">Product & Stock</span>
                        <span class="caret"></span>
                    </a>
                    <ul class="nav sub-nav" style="">
                        <?php if (check_role_assigned('product', 'view')) { ?>
                            <li>
                                <a href="<?= base_url('Product'); ?>">
                                    <span class="fa fa-shopping-cart"></span> Manage Product
                                </a>
                            </li>
                        <?php }
                            if (check_role_assigned('vendor', 'view')) { ?>
                            <li>
                                <a href="<?= base_url('Vendor'); ?>">
                                    <span class="fa fa-user-circle-o"></span> Manage Vendors
                                </a>
                            </li>
                        <?php }
                            if (check_role_assigned('product', 'view')) { ?>
                            <li>
                                <a href="<?= base_url('Purchase'); ?>">
                                    <span class="fa fa-shopping-bag"></span> Add Stock
                                </a>
                            </li>
                        <?php }
                            if (check_role_assigned('product', 'view')) { ?>
                            <li>
                                <a href="<?= base_url('Stock'); ?>">
                                    <span class="fa fa-shopping-basket"></span> View Stocks
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>
            <?php if (check_role_assigned('enquiry', 'view')) { ?>
                <li>
                    <a href="<?= base_url('Enquiry'); ?>">
                        <span class="fa fa-info-circle"></span>
                        <span class="sidebar-title">Manage Enquiry</span>
                    </a>
                </li>
            <?php } ?>
            <?php if (check_role_assigned('expense', 'view')) { ?>
                <li>
                    <a href="<?= base_url('Expense'); ?>">
                        <span class="fa fa-money"></span>
                        <span class="sidebar-title">Manage Expense</span>
                    </a>
                </li>
            <?php } ?>
            <?php if (check_role_assigned('coupon', 'view')) { ?>
                <li>
                    <a href="<?= base_url('Coupon'); ?>">
                        <span class="fa fa-gift"></span>
                        <span class="sidebar-title">Manage Coupons</span>
                    </a>
                </li>
            <?php } ?>
            <?php if (check_role_assigned('user', 'view')) { ?>
                <li>
                    <a href="<?= base_url('User'); ?>">
                        <span class="fa fa-user-plus"></span>
                        <span class="sidebar-title">Manage Users</span>
                    </a>
                </li>
            <?php } ?>
            <?php if (check_role_assigned('profilereport', 'view') && $this->session->userdata['logged_in']['username'] > 1) { ?>
                <li>
                    <a href="<?= base_url('Profile'); ?>">
                        <span class="fa fa-user-circle-o"></span>
                        <span class="sidebar-title">My Report </span>
                    </a>
                </li>
            <?php  }
            if (check_role_assigned('report', 'view')) { ?>
                <li>
                    <a class="accordion-toggle" href="#">
                        <span class="fa fa-bar-chart"></span>
                        <span class="sidebar-title">Reports</span>
                        <span class="caret"></span>
                    </a>
                    <ul class="nav sub-nav" style="">
                        <?php if (check_role_assigned('generalreport', 'view')) { ?>
                            <li>
                                <a href="<?= base_url('Report/General'); ?>">
                                    <span class="fa fa-black-tie"></span> General Report
                                </a>
                            </li>
                        <?php }
                            if (check_role_assigned('billreport', 'view')) { ?>
                            <li>
                                <a href="<?= base_url('Report/Bill'); ?>">
                                    <span class="fa fa-rupee"></span> Bill Report
                                </a>
                            </li>
                        <?php }
                            if (check_role_assigned('servicereport', 'view')) { ?>
                            <li>
                                <a href="<?= base_url('Report/Service'); ?>">
                                    <span class="fa fa-cut"></span> Service Report
                                </a>
                            </li>
                        <?php }
                            if (check_role_assigned('productreport', 'view')) { ?>
                            <li>
                                <a href="<?= base_url('Report/Product'); ?>">
                                    <span class="fa fa-shopping-cart"></span> Product Report
                                </a>
                            </li>
                        <?php }
                            if (check_role_assigned('purchasereport', 'view')) { ?>
                            <li>
                                <a href="<?= base_url('Report/Purchase'); ?>">
                                    <span class="fa fa-shopping-bag"></span> Purchase Report
                                </a>
                            </li>
                        <?php }
                            if (check_role_assigned('stockreport', 'view')) { ?>
                            <li>
                                <a href="<?= base_url('Report/Stock'); ?>">
                                    <span class="fa fa-cart-plus"></span> Stock Report
                                </a>
                            </li>
                        <?php }
                            if (check_role_assigned('expensereport', 'view')) { ?>
                            <li>
                                <a href="<?= base_url('Report/Expense'); ?>">
                                    <span class="fa fa-credit-card"></span> Expense Report
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>
            <?php if (check_role_assigned('sendmsg', 'view')) { ?>
                <li>
                    <a href="<?= base_url('SendMessage'); ?>">
                        <span class="fa fa-envelope"></span>
                        <span class="sidebar-title">Sent Message</span>
                    </a>
                </li>
            <?php } ?>

        </ul>
        <!-- End: Sidebar Menu -->
    </div>
    <!-- End: Sidebar Left Content -->
</aside>
<!-- End: Sidebar Left -->