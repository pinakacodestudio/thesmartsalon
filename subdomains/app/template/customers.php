<!DOCTYPE html>
<html>
	<head>
		<!-- Meta, title, CSS, favicons, etc. -->
		<meta charset="utf-8">
		<title>Customers</title>
		<?php include "include/headerscript.php";?>
	</head>

	<body class="dashboard-page sb-l-o sb-l-m">
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
							<li class="crumb-trail">Customers</li>
						</ol>
					</div>
				</header>
				<!-- End: Topbar -->
				<section id="content" class="animated fadeIn">
					<!-- Admin-panels -->
                    <div class="admin-panels fade-onload">
						<div class="row">
							<div class="col-lg-12 col-sm-12">
								<div class="" id="sp2">
									<div class="panel-heading">
										<div class="panel-title hidden-xs">
											<span class="fa fa-group"></span> Manage Customers
										</div>
									</div>
									<table class="table table-striped table-hover" id="datatable2" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th>Sr.</th>
												<th>Customer</th>
												<th>Company</th>
												<th>Mobile</th>
												<th>Email</th>
												<th>Address</th>
												<th>City</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>1</td>
												<td>Rajesh Pipaliya</td>
												<td>Ramraj Pvt. Ltd.</td>
												<td><a href="tel://9987456321">9987456321</a></td>
												<td><a href="mailto://info@ramrajpvtltd.com">info@ramrajpvtltd.com</a></td>
												<td>Address of his company in max 2 line</td>
												<td>Rajkot</td>
												<td>
													<a href="customer_leads.php" class="label label-warning" style="margin-right:5px;"><span class="fa fa-truck"></span></a>
													<a href="#" class="label label-success" style="margin-right:5px;"><span class="fa fa-edit"></span></a>
													<a href="#" class="label label-danger" onClick="return confirm('Do you want to delete this team?');"><span class="fa fa-trash-o"></span></a>
												</td>
											</tr>
											<tr>
												<td>2</td>
												<td>Rajesh Pipaliya</td>
												<td>Ramraj Pvt. Ltd.</td>
												<td><a href="tel://9987456321">9987456321</a></td>
												<td><a href="mailto://info@ramrajpvtltd.com">info@ramrajpvtltd.com</a></td>
												<td>Address of his company in max 2 line</td>
												<td>Rajkot</td>
												<td>
													<a href="#" class="label label-warning" style="margin-right:5px;"><span class="fa fa-truck"></span></a>
													<a href="#" class="label label-success" style="margin-right:5px;"><span class="fa fa-edit"></span></a>
													<a href="#" class="label label-danger" onClick="return confirm('Do you want to delete this team?');"><span class="fa fa-trash-o"></span></a>
												</td>
											</tr>
											<tr>
												<td>3</td>
												<td>Rajesh Pipaliya</td>
												<td>Ramraj Pvt. Ltd.</td>
												<td><a href="tel://9987456321">9987456321</a></td>
												<td><a href="mailto://info@ramrajpvtltd.com">info@ramrajpvtltd.com</a></td>
												<td>Address of his company in max 2 line</td>
												<td>Rajkot</td>
												<td>
													<a href="#" class="label label-warning" style="margin-right:5px;"><span class="fa fa-truck"></span></a>
													<a href="#" class="label label-success" style="margin-right:5px;"><span class="fa fa-edit"></span></a>
													<a href="#" class="label label-danger" onClick="return confirm('Do you want to delete this team?');"><span class="fa fa-trash-o"></span></a>
												</td>
											</tr>
											<tr>
												<td>4</td>
												<td>Rajesh Pipaliya</td>
												<td>Ramraj Pvt. Ltd.</td>
												<td><a href="tel://9987456321">9987456321</a></td>
												<td><a href="mailto://info@ramrajpvtltd.com">info@ramrajpvtltd.com</a></td>
												<td>Address of his company in max 2 line</td>
												<td>Rajkot</td>
												<td>
													<a href="#" class="label label-warning" style="margin-right:5px;"><span class="fa fa-truck"></span></a>
													<a href="#" class="label label-success" style="margin-right:5px;"><span class="fa fa-edit"></span></a>
													<a href="#" class="label label-danger" onClick="return confirm('Do you want to delete this team?');"><span class="fa fa-trash-o"></span></a>
												</td>
											</tr>
											<tr>
												<td>5</td>
												<td>Rajesh Pipaliya</td>
												<td>Ramraj Pvt. Ltd.</td>
												<td><a href="tel://9987456321">9987456321</a></td>
												<td><a href="mailto://info@ramrajpvtltd.com">info@ramrajpvtltd.com</a></td>
												<td>Address of his company in max 2 line</td>
												<td>Rajkot</td>
												<td>
													<a href="#" class="label label-warning" style="margin-right:5px;"><span class="fa fa-truck"></span></a>
													<a href="#" class="label label-success" style="margin-right:5px;"><span class="fa fa-edit"></span></a>
													<a href="#" class="label label-danger" onClick="return confirm('Do you want to delete this team?');"><span class="fa fa-trash-o"></span></a>
												</td>
											</tr>
											<tr>
												<td>6</td>
												<td>Rajesh Pipaliya</td>
												<td>Ramraj Pvt. Ltd.</td>
												<td><a href="tel://9987456321">9987456321</a></td>
												<td><a href="mailto://info@ramrajpvtltd.com">info@ramrajpvtltd.com</a></td>
												<td>Address of his company in max 2 line</td>
												<td>Rajkot</td>
												<td>
													<a href="#" class="label label-warning" style="margin-right:5px;"><span class="fa fa-truck"></span></a>
													<a href="#" class="label label-success" style="margin-right:5px;"><span class="fa fa-edit"></span></a>
													<a href="#" class="label label-danger" onClick="return confirm('Do you want to delete this team?');"><span class="fa fa-trash-o"></span></a>
												</td>
											</tr>
											<tr>
												<td>7</td>
												<td>Rajesh Pipaliya</td>
												<td>Ramraj Pvt. Ltd.</td>
												<td><a href="tel://9987456321">9987456321</a></td>
												<td><a href="mailto://info@ramrajpvtltd.com">info@ramrajpvtltd.com</a></td>
												<td>Address of his company in max 2 line</td>
												<td>Rajkot</td>
												<td>
													<a href="#" class="label label-warning" style="margin-right:5px;"><span class="fa fa-truck"></span></a>
													<a href="#" class="label label-success" style="margin-right:5px;"><span class="fa fa-edit"></span></a>
													<a href="#" class="label label-danger" onClick="return confirm('Do you want to delete this team?');"><span class="fa fa-trash-o"></span></a>
												</td>
											</tr>
											<tr>
												<td>8</td>
												<td>Rajesh Pipaliya</td>
												<td>Ramraj Pvt. Ltd.</td>
												<td><a href="tel://9987456321">9987456321</a></td>
												<td><a href="mailto://info@ramrajpvtltd.com">info@ramrajpvtltd.com</a></td>
												<td>Address of his company in max 2 line</td>
												<td>Rajkot</td>
												<td>
													<a href="#" class="label label-warning" style="margin-right:5px;"><span class="fa fa-truck"></span></a>
													<a href="#" class="label label-success" style="margin-right:5px;"><span class="fa fa-edit"></span></a>
													<a href="#" class="label label-danger" onClick="return confirm('Do you want to delete this team?');"><span class="fa fa-trash-o"></span></a>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="row hidden">
							<div class="col-lg-6 col-sm-12">
								<div class="admin-form theme-primary">
									<div class="panel heading-border panel-primary">
										<div class="panel-body bg-light">
											<form method="post" action="#" id="customform" enctype="multipart/form-data">
												<div class="section-divider mb40" id="spy1">
													<span>Manage Match</span>
												</div>
												<!-- .section-divider -->
												<div class="section">
													<label class="field select">
														<select id="seriesname" name="seriesname">
															<option value="">Select Series Name</option>
															<option value="1">Series 1</option>
															<option value="2">Series 2</option>
															<option value="3">Series 3</option>
														</select>
														<i class="arrow"></i>
													</label>
												</div>
												<div class="section">
													<label class="field select">
														<select id="team1" name="team1">
															<option value="">Select Team 1</option>
															<option value="1">Team 1</option>
															<option value="2">Team 2</option>
														</select>
														<i class="arrow"></i>
													</label>
												</div>
												<div class="section">
													<label class="field select">
														<select id="team2" name="team2">
															<option value="">Select Team 2</option>
															<option value="1">Team 1</option>
															<option value="2">Team 2</option>
														</select>
														<i class="arrow"></i>
													</label>
												</div>
												<div class="section">
													<label for="price" class="field prepend-icon">
														<input type="number" name="price" id="price" class="gui-input" placeholder="Enter Price">
														<label for="price" class="field-icon">
															<i class="fa fa-edit"></i>
														</label>
													</label>
												</div>
												<div class="section">
													<label for="matchdate" class="field prepend-icon">
														<input type="text" name="matchdate" id="matchdate" class="gui-input" placeholder="Select Match Date" readonly>
														<label for="matchdate" class="field-icon">
															<i class="fa fa-calendar-o"></i>
														</label>
													</label>
												</div>
												<div class="section">
													<label for="venue" class="field prepend-icon">
														<input type="text" name="venue" id="venue" class="gui-input" placeholder="Enter Venue of Match">
														<label for="venue" class="field-icon">
															<i class="fa fa-edit"></i>
														</label>
													</label>
												</div>
												<div class="section">
													<label class="field select">
														<select id="matchstatus" name="matchstatus">
															<option value="">Update Match Status</option>
															<option value="">Upcoming</option>
															<option value="">Running</option>
															<option value="">Complete</option>
															<option value="">Tie</option>
															<option value="">Suspended</option>
														</select>
														<i class="arrow"></i>
													</label>
												</div>
												<div class="section">
													<label class="switch switch-round block mt15 switch-primary">
														<input type="radio" name="winnerteam" id="fr1" value="Team 1 id">
														<label for="fr1" data-on="Yes" data-off="No"></label>
														<span>Team 1 Win</span>
													</label>
													<label class="switch switch-round block mt15 switch-primary">
														<input type="radio" name="winnerteam" id="fr2" value="Team 2 id">
														<label for="fr2" data-on="Yes" data-off="No"></label>
														<span>Team 2 Win</span>
													</label>
													<label class="switch switch-round block mt15 switch-primary">
														<input type="radio" name="winnerteam" id="fr3" value="0">
														<label for="fr3" data-on="Yes" data-off="No"></label>
														<span>Tie</span>
													</label>
												</div>
												<div class="section">
													<label for="remark" class="field prepend-icon">
														<input type="text" name="remark" id="remark" class="gui-input" placeholder="Enter Remark">
														<label for="remark" class="field-icon">
															<i class="fa fa-edit"></i>
														</label>
													</label>
												</div>
												<div class="panel-footer">
													<input type="submit" class="button btn-primary" value="Save Match" />
													<button type="reset" class="button btn-primary"> Cancle </button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
                        </div>
					</div>
                </section>
               
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
						
				<!-- Begin: Page Footer -->
				<footer id="content-footer">
					<div class="row">
						<div class="col-xs-6">
							<span class="footer-legal">© 2019 Jasmin Jasani</span>
						</div>
						<div class="col-xs-6 text-right">
							<!--<span class="footer-meta">10GB of
								<b>250GB</b> Free</span>-->
							<a href="#content" class="footer-return-top">
								<span class="fa fa-arrow-up"></span>
							</a>
						</div>
					</div>
				</footer>
				<!-- End: Page Footer -->
			</section>
			<!-- End: Content-Wrapper -->
		</div>
		<!-- End: Main -->

		<!-- BEGIN: PAGE SCRIPTS -->

		<!-- jQuery -->
		<script src="vendor/jquery/jquery-3.1.1.min.js"></script>
		<script src="vendor/jquery/jquery_migrate/jquery-migrate-3.0.0.min.js"></script>
		<script src="vendor/jquery/jquery_ui/jquery-ui.min.js"></script>
		<script src="assets/admin-tools/admin-forms/js/jquery-ui-datepicker.min.js"></script>

		<!-- Datatables -->
		<script src="vendor/plugins/datatables/media/js/datatables.min.js"></script>

		<!-- jQuery Validate Plugin-->
		<script src="assets/admin-tools/admin-forms/js/jquery.validate.min.js"></script>

		<!-- Theme Javascript -->
		<script src="assets/js/utility/utility.js"></script>
		<script src="assets/js/main.js"></script>

		<script type="text/javascript">
		jQuery(document).ready(function() {
			"use strict";
			// Init Theme Core      
			Core.init();

			$('#datatable2').dataTable({
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
					seriesname: {
						required: true
					},
					team1: {
						required: true
					},
					team2: {
						required: true
					},
					price:{
						required: true
					},
					matchdate:{
						required: true
					},
					venue:{
						required: true
					}
				},
				/* @validation error messages 
				---------------------------------------------- */
				messages: {
					seriesname: {
						required: 'Select series name'
					},
					team1: {
						required: 'Select team 1'
					},
					team2: {
						required: 'Select team 2'
					},
					price: {
						required: 'Enter match price'
					},
					matchdate: {
						required: 'Select match date & time'
					},
					venue: {
						required: 'Enter match venue'
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
			
			/* @date time picker
			------------------------------------------------------------------ */
			$('#matchdate').datetimepicker({
				prevText: '<i class="fa fa-chevron-left"></i>',
				nextText: '<i class="fa fa-chevron-right"></i>',
				beforeShow: function(input, inst) {
					var newclass = 'admin-form';
					var themeClass = $(this).parents('.admin-form').attr('class');
					var smartpikr = inst.dpDiv.parent();
					if (!smartpikr.hasClass(themeClass)) {
						inst.dpDiv.wrap('<div class="' + themeClass + '"></div>');
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
