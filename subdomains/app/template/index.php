<!DOCTYPE html>
<html>
	<head>
		<!-- Meta, title, CSS, favicons, etc. -->
		<meta charset="utf-8">
		<title>Dashboard</title>
		<?php include "include/headerscript.php";?>
	</head>

	<body class="dashboard-page sb-l-o sb-l-m sb-r-c">
		<!-- Start: Main -->
		<div id="main">
			<!-- Start: Header -->
			<?php include "include/header.php";?>
			<!-- End: Header -->
			<?php include "include/aside.php";?>
			<!-- Start: Content-Wrapper -->
			<section id="content_wrapper">
				<!-- Start: Topbar -->
				<header id="topbar">
					<div class="topbar-left">
						<ol class="breadcrumb">
							<li class="crumb-active">
								<a href="index.php">
									Home
									<span class="glyphicon glyphicon-home"></span> 
								</a>
							</li>
						</ol>
					</div>
					<div class="topbar-right">
						<div class="ib topbar-dropdown">
							<label for="topbar-multiple" class="control-label pr10 fs11 text-muted">Reporting Period</label>
							<select id="topbar-multiple" class="hidden">
								<optgroup label="Filter By:">
									<option value="1-1">Last 30 Days</option>
									<option value="1-2" selected="selected">Last 60 Days</option>
									<option value="1-3">Last Year</option>
								</optgroup>
							</select>
						</div>
						<div class="ml15 ib va-m" id="toggle_sidemenu_r">
							<a href="#" class="pl5">
								<i class="fa fa-sign-in fs22 text-primary"></i>
								<span class="badge badge-danger badge-hero">3</span>
							</a>
						</div>
					</div>
				</header>
				<!-- End: Topbar -->

				<section id="content" class="animated fadeIn">
					<!-- Short Cut Widget -->
					<div class="row mb20">
						<div class="col-sm-6 col-md-2">
							<a href="customers.php">
								<div class="panel bg-alert light of-h" style="margin:0">
									<div class="pn pl20 p5">
										<div class="icon-bg">
											<i class="fa fa-group"></i>
										</div>
										<h2 class="mt15 lh15">
											<b>523</b>
										</h2>
										<h5 class="text-muted">Customers</h5>
									</div>
								</div>
							</a>
						</div>
						<div class="col-sm-6 col-md-2">
							<div class="panel bg-info light of-h" style="margin:0">
								<div class="pn pl20 p5">
									<div class="icon-bg">
										<i class="fa fa-user"></i>
									</div>
									<h2 class="mt15 lh15">
										<b>348</b>
									</h2>
									<h5 class="text-muted">Leads</h5>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-2">
							<div class="panel bg-danger light of-h" style="margin:0">
							<div class="pn pl20 p5">
									<div class="icon-bg">
										<i class="fa fa-columns"></i>
									</div>
									<h2 class="mt15 lh15">
										<b>267</b>
									</h2>
									<h5 class="text-muted">Inquiry</h5>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-2">
							<div class="panel bg-warning light of-h" style="margin:0">
								<div class="pn pl20 p5">
									<div class="icon-bg">
										<i class="fa fa-calendar"></i>
									</div>
									<h2 class="mt15 lh15">
										<b>714</b>
									</h2>
									<h5 class="text-muted">Quotation</h5>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-2">
							<div class="panel bg-alert light of-h" style="margin:0">
								<div class="pn pl20 p5">
									<div class="icon-bg">
										<i class="fa fa-gamepad"></i>
									</div>
									<h2 class="mt15 lh15">
										<b>523</b>
									</h2>
									<h5 class="text-muted">Sales Order</h5>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-2">
							<div class="panel bg-info light of-h" style="margin:0">
								<div class="pn pl20 p5">
									<div class="icon-bg">
										<i class="fa fa-bullhorn"></i>
									</div>
									<h2 class="mt15 lh15">
										<b>348</b>
									</h2>
									<h5 class="text-muted">News</h5>
								</div>
							</div>
						</div>
					</div>
					<!-- Admin-panels -->
					<div class="row">
						<!-- Task Widget -->
						<div class="col-lg-6 col-sm-12">
							<!-- Task Widget -->
							<div class="" id="sp2">
								<div class="panel-heading cursor">
									<span class="panel-icon">
										<i class="fa fa-cog"></i>
									</span>
									<span class="panel-title"> Customer List</span>
								</div>
								<table class="table table-striped table-hover" id="customers" >
									<thead>
										<tr>
											<th>Sr.</th>
											<th>Customer</th>
											<th colspan=2>Contact</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>1</td>
											<td><b>Rajesh Pipaliya,</b><br/>Ramraj Pvt. Ltd.</td>
											<td>
												<a href="tel://9987456321">9987456321</a><br/>
												<a href="mailto://info@ramrajpvtltd.com">info@ramrajpvtltd.com</a>
											</td>
											<td>
												<div class="btn-group">
													<button type="button" class="btn btn-sm fs12 fw500 dropdown-toggle ph10" data-toggle="dropdown">
														<span class="caret"></span>
													</button>
													<ul class="dropdown-menu pull-right" role="menu">
														<li>
															<a href="customer_followup.php">Follow up</a>
														</li>
														<li class="divider"></li>
														<li>
															<a href="customer_leads.php">Leads</a>
														</li>
														<li>
															<a href="#">Edit</a>
														</li>
													</ul>
												</div>
												<!-- 
												<a href="customer_leads.php" class="label label-warning" style="margin-right:5px;"><span class="fa fa-truck"></span></a>
												<a href="#" class="label label-success" style="margin-right:5px;"><span class="fa fa-edit"></span></a>
												<a href="#" class="label label-danger" onClick="return confirm('Do you want to delete this team?');"><span class="fa fa-trash-o"></span></a>

												-->
											</td>
										</tr>
										<tr>
											<td>1</td>
											<td><b>Rajesh Pipaliya,</b><br/>Ramraj Pvt. Ltd.</td>
											<td>
												<a href="tel://9987456321">9987456321</a><br/>
												<a href="mailto://info@ramrajpvtltd.com">info@ramrajpvtltd.com</a>
											</td>
											<td>
												<div class="btn-group">
													<button type="button" class="btn btn-sm fs12 fw500 dropdown-toggle ph10" data-toggle="dropdown">
														<span class="caret"></span>
													</button>
													<ul class="dropdown-menu pull-right" role="menu">
														<li>
															<a href="customer_followup.php">Follow up</a>
														</li>
														<li class="divider"></li>
														<li>
															<a href="customer_leads.php">Leads</a>
														</li>
														<li>
															<a href="#">Edit</a>
														</li>
													</ul>
												</div>
											</td>
										</tr>
										<tr>
											<td>1</td>
											<td><b>Rajesh Pipaliya,</b><br/>Ramraj Pvt. Ltd.</td>
											<td>
												<a href="tel://9987456321">9987456321</a><br/>
												<a href="mailto://info@ramrajpvtltd.com">info@ramrajpvtltd.com</a>
											</td>
											<td>
												<div class="btn-group">
													<button type="button" class="btn btn-sm fs12 fw500 dropdown-toggle ph10" data-toggle="dropdown">
														<span class="caret"></span>
													</button>
													<ul class="dropdown-menu pull-right" role="menu">
														<li>
															<a href="customer_followup.php">Follow up</a>
														</li>
														<li class="divider"></li>
														<li>
															<a href="customer_leads.php">Leads</a>
														</li>
														<li>
															<a href="#">Edit</a>
														</li>
													</ul>
												</div>
											</td>
										</tr>
										<tr>
											<td>1</td>
											<td><b>Rajesh Pipaliya,</b><br/>Ramraj Pvt. Ltd.</td>
											<td>
												<a href="tel://9987456321">9987456321</a><br/>
												<a href="mailto://info@ramrajpvtltd.com">info@ramrajpvtltd.com</a>
											</td>
											<td>
												<div class="btn-group">
													<button type="button" class="btn btn-sm fs12 fw500 dropdown-toggle ph10" data-toggle="dropdown">
														<span class="caret"></span>
													</button>
													<ul class="dropdown-menu pull-right" role="menu">
														<li>
															<a href="customer_followup.php">Follow up</a>
														</li>
														<li class="divider"></li>
														<li>
															<a href="customer_leads.php">Leads</a>
														</li>
														<li>
															<a href="#">Edit</a>
														</li>
													</ul>
												</div>
											</td>
										</tr>
										<tr>
											<td>1</td>
											<td><b>Rajesh Pipaliya,</b><br/>Ramraj Pvt. Ltd.</td>
											<td>
												<a href="tel://9987456321">9987456321</a><br/>
												<a href="mailto://info@ramrajpvtltd.com">info@ramrajpvtltd.com</a>
											</td>
											<td>
												<div class="btn-group">
													<button type="button" class="btn btn-sm fs12 fw500 dropdown-toggle ph10" data-toggle="dropdown">
														<span class="caret"></span>
													</button>
													<ul class="dropdown-menu pull-right" role="menu">
														<li>
															<a href="customer_followup.php">Follow up</a>
														</li>
														<li class="divider"></li>
														<li>
															<a href="customer_leads.php">Leads</a>
														</li>
														<li>
															<a href="#">Edit</a>
														</li>
													</ul>
												</div>
											</td>
										</tr>
										<tr>
											<td>1</td>
											<td><b>Rajesh Pipaliya,</b><br/>Ramraj Pvt. Ltd.</td>
											<td>
												<a href="tel://9987456321">9987456321</a><br/>
												<a href="mailto://info@ramrajpvtltd.com">info@ramrajpvtltd.com</a>
											</td>
											<td>
												<div class="btn-group">
													<button type="button" class="btn btn-sm fs12 fw500 dropdown-toggle ph10" data-toggle="dropdown">
														<span class="caret"></span>
													</button>
													<ul class="dropdown-menu pull-right" role="menu">
														<li>
															<a href="customer_followup.php">Follow up</a>
														</li>
														<li class="divider"></li>
														<li>
															<a href="customer_leads.php">Leads</a>
														</li>
														<li>
															<a href="#">Edit</a>
														</li>
													</ul>
												</div>
											</td>
										</tr>
										<tr>
											<td>1</td>
											<td><b>Rajesh Pipaliya,</b><br/>Ramraj Pvt. Ltd.</td>
											<td>
												<a href="tel://9987456321">9987456321</a><br/>
												<a href="mailto://info@ramrajpvtltd.com">info@ramrajpvtltd.com</a>
											</td>
											<td>
												<div class="btn-group">
													<button type="button" class="btn btn-sm fs12 fw500 dropdown-toggle ph10" data-toggle="dropdown">
														<span class="caret"></span>
													</button>
													<ul class="dropdown-menu pull-right" role="menu">
														<li>
															<a href="customer_followup.php">Follow up</a>
														</li>
														<li class="divider"></li>
														<li>
															<a href="customer_leads.php">Leads</a>
														</li>
														<li>
															<a href="#">Edit</a>
														</li>
													</ul>
												</div>
											</td>
										</tr>
										<tr>
											<td>1</td>
											<td><b>Rajesh Pipaliya,</b><br/>Ramraj Pvt. Ltd.</td>
											<td>
												<a href="tel://9987456321">9987456321</a><br/>
												<a href="mailto://info@ramrajpvtltd.com">info@ramrajpvtltd.com</a>
											</td>
											<td>
												<div class="btn-group">
													<button type="button" class="btn btn-sm fs12 fw500 dropdown-toggle ph10" data-toggle="dropdown">
														<span class="caret"></span>
													</button>
													<ul class="dropdown-menu pull-right" role="menu">
														<li>
															<a href="customer_followup.php">Follow up</a>
														</li>
														<li class="divider"></li>
														<li>
															<a href="customer_leads.php">Leads</a>
														</li>
														<li>
															<a href="#">Edit</a>
														</li>
													</ul>
												</div>
											</td>
										</tr>
										<tr>
											<td>1</td>
											<td><b>Rajesh Pipaliya,</b><br/>Ramraj Pvt. Ltd.</td>
											<td>
												<a href="tel://9987456321">9987456321</a><br/>
												<a href="mailto://info@ramrajpvtltd.com">info@ramrajpvtltd.com</a>
											</td>
											<td>
												<div class="btn-group">
													<button type="button" class="btn btn-sm fs12 fw500 dropdown-toggle ph10" data-toggle="dropdown">
														<span class="caret"></span>
													</button>
													<ul class="dropdown-menu pull-right" role="menu">
														<li>
															<a href="customer_followup.php">Follow up</a>
														</li>
														<li class="divider"></li>
														<li>
															<a href="customer_leads.php">Leads</a>
														</li>
														<li>
															<a href="#">Edit</a>
														</li>
													</ul>
												</div>
											</td>
										</tr>
										<tr>
											<td>1</td>
											<td><b>Rajesh Pipaliya,</b><br/>Ramraj Pvt. Ltd.</td>
											<td>
												<a href="tel://9987456321">9987456321</a><br/>
												<a href="mailto://info@ramrajpvtltd.com">info@ramrajpvtltd.com</a>
											</td>
											<td>
												<div class="btn-group">
													<button type="button" class="btn btn-sm fs12 fw500 dropdown-toggle ph10" data-toggle="dropdown">
														<span class="caret"></span>
													</button>
													<ul class="dropdown-menu pull-right" role="menu">
														<li>
															<a href="customer_followup.php">Follow up</a>
														</li>
														<li class="divider"></li>
														<li>
															<a href="customer_leads.php">Leads</a>
														</li>
														<li>
															<a href="#">Edit</a>
														</li>
													</ul>
												</div>
											</td>
										</tr>
										<tr>
											<td>1</td>
											<td><b>Rajesh Pipaliya,</b><br/>Ramraj Pvt. Ltd.</td>
											<td>
												<a href="tel://9987456321">9987456321</a><br/>
												<a href="mailto://info@ramrajpvtltd.com">info@ramrajpvtltd.com</a>
											</td>
											<td>
												<div class="btn-group">
													<button type="button" class="btn btn-sm fs12 fw500 dropdown-toggle ph10" data-toggle="dropdown">
														<span class="caret"></span>
													</button>
													<ul class="dropdown-menu pull-right" role="menu">
														<li>
															<a href="customer_followup.php">Follow up</a>
														</li>
														<li class="divider"></li>
														<li>
															<a href="customer_leads.php">Leads</a>
														</li>
														<li>
															<a href="#">Edit</a>
														</li>
													</ul>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</section>
				<!-- End: Content -->
				<!-- Begin: Page Footer -->
				<footer id="content-footer">
					<div class="row">
						<div class="col-xs-6">
							<span class="footer-legal">© 2019 Jasmin Jasani</span>
						</div>
						<!--
						<div class="col-xs-6 text-right">
							<span class="footer-meta">10GB of
								<b>250GB</b> Free</span>
							<a href="#content" class="footer-return-top">
								<span class="fa fa-arrow-up"></span>
							</a>
						</div>
						-->
					</div>
				</footer>
				<!-- End: Page Footer -->
			</section>
			<!-- End: Content-Wrapper -->
			<aside id="sidebar_right" class="nano affix">

				<!-- Start: Sidebar Right Content -->
				<div class="sidebar-right-content nano-content">

					<div class="tab-block sidebar-block br-n">
						<ul class="nav nav-tabs tabs-border nav-justified hidden">
							<li class="active">
								<a href="#sidebar-right-tab1" data-toggle="tab">Tab 1</a>
							</li>
							<li>
								<a href="#sidebar-right-tab2" data-toggle="tab">Tab 2</a>
							</li>
							<li>
								<a href="#sidebar-right-tab3" data-toggle="tab">Tab 3</a>
							</li>
						</ul>
						<div class="tab-content br-n">
							<div id="sidebar-right-tab1" class="tab-pane active">

								<h5 class="title-divider text-muted mb20"> Server Statistics
									<span class="pull-right"> 2013
										<i class="fa fa-caret-down ml5"></i>
									</span>
								</h5>
								<div class="progress mh5">
									<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 44%">
										<span class="fs11">DB Request</span>
									</div>
								</div>
								<div class="progress mh5">
									<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 84%">
										<span class="fs11 text-left">Server Load</span>
									</div>
								</div>
								<div class="progress mh5">
									<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 61%">
										<span class="fs11 text-left">Server Connections</span>
									</div>
								</div>

								<h5 class="title-divider text-muted mt30 mb10">Traffic Margins</h5>
								<div class="row">
									<div class="col-xs-5">
										<h3 class="text-primary mn pl5">132</h3>
									</div>
									<div class="col-xs-7 text-right">
										<h3 class="text-success-dark mn">
											<i class="fa fa-caret-up"></i> 13.2% </h3>
									</div>
								</div>

								<h5 class="title-divider text-muted mt25 mb10">Database Request</h5>
								<div class="row">
									<div class="col-xs-5">
										<h3 class="text-primary mn pl5">212</h3>
									</div>
									<div class="col-xs-7 text-right">
										<h3 class="text-success-dark mn">
											<i class="fa fa-caret-up"></i> 25.6% </h3>
									</div>
								</div>

								<h5 class="title-divider text-muted mt25 mb10">Server Response</h5>
								<div class="row">
									<div class="col-xs-5">
										<h3 class="text-primary mn pl5">82.5</h3>
									</div>
									<div class="col-xs-7 text-right">
										<h3 class="text-danger mn">
											<i class="fa fa-caret-down"></i> 17.9% </h3>
									</div>
								</div>

								<h5 class="title-divider text-muted mt40 mb20"> User Activity
									<span class="pull-right text-primary fw600">1 Hour</span>
								</h5>

								<div class="media">
									<a class="media-left" href="#">
										<img src="assets/img/avatars/6.jpg" class="mw40 br64" alt="holder-img">
									</a>
									<div class="media-body">
										<h5 class="media-heading">Article
											<small class="text-muted">- 08/16/22</small>
										</h5>Updated 36 days ago by
										<a class="text-system" href="#"> Max </a>
									</div>
								</div>
								<div class="media">
									<a class="media-left" href="#">
										<img src="assets/img/avatars/4.jpg" class="mw40 br64" alt="holder-img">
									</a>
									<div class="media-body">
										<h5 class="media-heading">Richard
											<small class="text-muted">@cloudesigns</small>
											<small class="pull-right text-muted">6h</small>
										</h5>Updated 36 days ago by
										<a class="text-system" href="#"> Max </a>
									</div>
								</div>
								<div class="media">
									<a class="media-left" href="#">
										<img src="assets/img/avatars/3.jpg" class="mw40 br64" alt="holder-img">
									</a>
									<div class="media-body">
										<h5 class="media-heading">1,610 kcal
											<span class="fa fa-caret-down text-primary pl5"></span>
										</h5>Updated 36 days ago by
										<a class="text-system" href="#"> Max </a>
									</div>
								</div>
								<div class="media">
									<a class="media-left" href="#">
										<img src="assets/img/avatars/2.jpg" class="mw40 br64" alt="holder-img">
									</a>
									<div class="media-body">
										<h5 class="media-heading">1,610 kcal
											<span class="label label-xs label-system ml5">Featured</span>
										</h5>Updated 36 days ago by
										<a class="text-system" href="#"> Max </a>
									</div>
								</div>
								<div class="media">
									<a class="media-left" href="#">
										<img src="assets/img/avatars/5.jpg" class="mw40 br64" alt="holder-img">
									</a>
									<div class="media-body">
										<h5 class="media-heading">1,610 kcal</h5> Updated ago by
										<a class="text-system" href="#"> Max </a>
									</div>
									<a class="media-right pl30" href="#">
										<span class="fa fa-pencil text-muted mb5"></span>
										<br>
										<span class="fa fa-remove text-danger-light"></span>
									</a>
								</div>
							</div>
							<div id="sidebar-right-tab2" class="tab-pane"></div>
							<div id="sidebar-right-tab3" class="tab-pane"></div>
						</div>
						<!-- end: .tab-content -->
					</div>

				</div>
			</aside>
			
		</div>
		<!-- End: Main -->

		<!-- BEGIN: PAGE SCRIPTS -->

		<!-- jQuery -->
		<script src="vendor/jquery/jquery-3.1.1.min.js"></script>
		<script src="vendor/jquery/jquery_migrate/jquery-migrate-3.0.0.min.js"></script>
		<script src="vendor/jquery/jquery_ui/jquery-ui.min.js"></script>

		<!-- Datatables -->
		<script src="vendor/plugins/datatables/media/js/datatables.min.js"></script>

		
		<!-- Theme Javascript -->
		<script src="assets/js/utility/utility.js"></script>
		<script src="assets/js/main.js"></script>

		<script type="text/javascript">
		jQuery(document).ready(function() {
			"use strict";
			// Init Theme Core      
			Core.init();

			$('#customers').dataTable({
				// dom: "Bfrtip",
				// dom: "rtip",
				dom: '<"top"fl>rt<"bottom"ip>'
				// select: true
			});

			// Init Widget Demo JS
			// demoHighCharts.init();

			// Because we are using Admin Panels we use the OnFinish 
			// callback to activate the demoWidgets. It's smoother if
			// we let the panels be moved and organized before 
			// filling them with content from various plugins

			// Init plugins used on this page
			// HighCharts, JvectorMap, Admin Panels

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
					},300)
				},
				onSave: function() {
					$(window).trigger('resize');
				}
			});
		});
		</script>
		<!-- END: PAGE SCRIPTS -->

	</body>
</html>
