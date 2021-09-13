<!DOCTYPE html>
<html>
	<head>
		<!-- Meta, title, CSS, favicons, etc. -->
		<meta charset="utf-8">
		<title>Customer's Lead</title>
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
							<li class="crumb-trail">Leads</li>
						</ol>
					</div>
				</header>
				<!-- End: Topbar -->
				<section id="content" class="animated fadeIn">
					<!-- Admin-panels -->
                    <div class="admin-panels fade-onload">
						<div class="row">
							<div class="col-lg-8 col-md-12 col-sm-12">
								<div class="panel">
									<div class="panel-body">
										<h2 class="mt0">Ramraj Pvt. Ltd.</h2>
										<h4>Person: <small>Rajesh Pipaliya</small></h4>
										<h4>Contact  : <small><a href="tel://9987456321">9987456321</a></small></h4>
										<h4>Email : <small><a href="mailto://info@ramrajpvtltd.com">info@ramrajpvtltd.com</a></small></h4>
										<h4>Address : <small>Address of his company in max 2 line</small></h4>
									</div>
								</div>
								<div class="" id="sp2">
									<div class="panel-heading">
										<div class="panel-title hidden-xs">
											<span class="fa fa-group"></span> Manage Leads
										</div>
									</div>
									<table class="table table-striped table-hover" id="datatable2" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th>Sr.</th>
												<th>Date</th>
												<th>Product</th>
												<th>Description</th>
												<th>Cost</th>
												<th>Status</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>1</td>
												<td>02/05/2018</td>
												<td>Product 01</td>
												<td>Product 01 Description</td>
												<td>2,45,000</td>
												<td><span class="label label-success">Active</span></td>
												<td>
													<a href="#" class="label label-danger" onClick="return confirm('Do you want to delete this team?');"><span class="fa fa-trash-o"></span></a>
													<a href="#" class="label label-success" style=""><span class="fa fa-edit"></span></a>
													<a href="customer_followup.php" class="label label-warning" style=""><span class="fa fa-phone"></span></a>
													<a href="#" class="label label-primary" style=""><span class="fa fa-truck"></span> Inquiry</a>
												</td>
											</tr>
											<tr>
												<td>2</td>
												<td>12/05/2018</td>
												<td>Product 02</td>
												<td>Product 02 Description</td>
												<td>1,12,000</td>
												<td><span class="label label-danger">Closed</span></td>
												<td>
													<a href="#" class="label label-danger" onClick="return confirm('Do you want to delete this team?');"><span class="fa fa-trash-o"></span></a>
													<a href="customer_followup.php" class="label label-success" style=""><span class="fa fa-edit"></span></a>
													<a href="#" class="label label-warning" style=""><span class="fa fa-phone"></span></a>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="col-lg-4 col-sm-12">
								<div class="admin-form theme-primary">
									<div class="panel heading-border panel-primary">
										<div class="panel-body bg-light">
											<form method="post" action="#" id="customform" enctype="multipart/form-data">
												<div class="section-divider mb40" id="spy1">
													<span>Manage Leads</span>
												</div>
												<!-- .section-divider -->
												<div class="section">
													<label for="leaddate" class="field prepend-icon">
														<input type="text" name="leaddate" id="leaddate" class="gui-input" placeholder="Select Lead Date" readonly>
														<label for="leaddate" class="field-icon">
															<i class="fa fa-calendar-o"></i>
														</label>
													</label>
												</div>
												<div class="section">
													<label class="field select">
														<select id="productname" name="productname">
															<option value="">Select Product Name</option>
															<option value="1">Product 1</option>
															<option value="2">Product 2</option>
															<option value="3">Product 3</option>
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
													<label for="remark" class="field prepend-icon">
														<input type="text" name="remark" id="remark" class="gui-input" placeholder="Enter Remark">
														<label for="remark" class="field-icon">
															<i class="fa fa-edit"></i>
														</label>
													</label>
												</div>
												<div class="section">
													<label class="field select">
														<select id="status" name="status">
															<option value="">Update Lead Status</option>
															<option value="">Active</option>
															<option value="">Inquiry</option>
															<option value="">Quotation</option>
															<option value="">Sales Order</option>
															<option value="">Done</option>
														</select>
														<i class="arrow"></i>
													</label>
												</div>
												<div class="panel-footer">
													<input type="submit" class="button btn-primary" value="Save Lead" />
													<button type="reset" class="button btn-primary"> Cancel </button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
							
						</div>
						<div class="row hidden">
							<div class="col-lg-8 col-sm-12">
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
