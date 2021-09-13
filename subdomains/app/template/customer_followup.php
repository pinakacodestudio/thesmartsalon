<!DOCTYPE html>
<html>
	<head>
		<!-- Meta, title, CSS, favicons, etc. -->
		<meta charset="utf-8">
		<title>Follow ups</title>
		<?php include "include/headerscript.php";?>
		<style>
			
		</style>
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
							<li class="crumb-trail">Follow ups</li>
						</ol>
					</div>
					<div class="topbar-right">
						<div class="ml15 ib va-m" id="toggle_sidemenu_r">
							<a href="#" class="btn btn-primary mr10"> + Follow-Up </a>
						</div>
					</div>
				</header>
				<!-- End: Topbar -->
				<section id="content" class="animated fadeIn">
					<!-- Admin-panels -->
                    <div class="admin-panels fade-onload">
						<div class="row">
							<div class="col-lg-6 col-md-12 col-sm-12">
								<div class="admin-form theme-primary">
									<div class="panel heading-border panel-primary">
										<div class="section-divider mt40" id="spy1">
											<span>Follow Ups</span>
										</div>
										<div class="panel-body ptn pbn p10">
											<ol class="timeline-list">
												<li class="timeline-item pr15">
													<div class="timeline-icon bg-dark light">
														<span class="fa fa-tags"></span>
													</div>
													<div class="timeline-desc">
														<b>15/05/2019</b>
														<p>He will think and plan for quotation from other company.</p>
													</div>
													<div class="timeline-date"><span class="fa fa-plus-circle timeline_toggle"></span></div>
													<div class="timeline-desc text-right timeline-nextdate" style="display:none">
														follow up on <b> 20/05/2019 </b>
														<p>Ask for his budget & other company quotation.</p>
													</div>
												</li>
												<li class="timeline-item pr15">
													<div class="timeline-icon bg-dark light">
														<span class="fa fa-tags"></span>
													</div>
													<div class="timeline-desc">
														<b>15/05/2019</b>
														<p>He will think and plan for quotation from other company.</p>
													</div>
													<div class="timeline-date"><span class="fa fa-plus-circle timeline_toggle"></span></div>
													<div class="timeline-desc text-right timeline-nextdate" style="display:none">
														follow up on <b> 20/05/2019 </b>
														<p>Ask for his budget & other company quotation.</p>
													</div>
												</li>
												<li class="timeline-item">
													<div class="timeline-icon bg-dark light">
														<span class="fa fa-tags"></span>
													</div>
													<div class="timeline-desc">
														<b>Sara</b> Added his store:
														<a href="#">Notebook</a>
													</div>
													<div class="timeline-date">3:05am</div>
												</li>
												<li class="timeline-item">
													<div class="timeline-icon bg-success">
														<span class="fa fa-usd"></span>
													</div>
													<div class="timeline-desc">
														<b>Admin</b> created invoice for:
														<a href="#">Software</a>
													</div>
													<div class="timeline-date">4:15am</div>
												</li>
												<li class="timeline-item">
													<div class="timeline-icon bg-success">
														<span class="fa fa-usd"></span>
													</div>
													<div class="timeline-desc">
														<b>Admin</b> created invoice for:
														<a href="#">Apple</a>
													</div>
													<div class="timeline-date">7:45am</div>
												</li>
												<li class="timeline-item">
													<div class="timeline-icon bg-success">
														<span class="fa fa-usd"></span>
													</div>
													<div class="timeline-desc">
														<b>Admin</b> created invoice for:
														<a href="#">Software</a>
													</div>
													<div class="timeline-date">4:15am</div>
												</li>
												<li class="timeline-item">
													<div class="timeline-icon bg-success">
														<span class="fa fa-usd"></span>
													</div>
													<div class="timeline-desc">
														<b>Admin</b> created invoice for:
														<a href="#">Apple</a>
													</div>
													<div class="timeline-date">7:45am</div>
												</li>
												<li class="timeline-item">
													<div class="timeline-icon bg-dark light">
														<span class="fa fa-tags"></span>
													</div>
													<div class="timeline-desc">
														<b>Michael</b> Added his store:
														<a href="#">Ipod</a>
													</div>
													<div class="timeline-date">8:25am</div>
												</li>
												<li class="timeline-item">
													<div class="timeline-icon bg-system">
														<span class="fa fa-fire"></span>
													</div>
													<div class="timeline-desc">
														<b>Admin</b> created invoice for:
														<a href="#">Software</a>
													</div>
													<div class="timeline-date">4:15am</div>
												</li>
												<li class="timeline-item">
													<div class="timeline-icon bg-dark light">
														<span class="fa fa-tags"></span>
													</div>
													<div class="timeline-desc">
														<b>Sara</b> Added to his store:
														<a href="#">Notebook</a>
													</div>
													<div class="timeline-date">3:05am</div>
												</li>
											</ol>
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-lg-6 col-md-12 col-sm-12">
								<div class="admin-form theme-primary">
									<div class="panel heading-border panel-primary">
										<div class="panel-body bg-light">
											<form class="form-horizontal">
												<div class="section-divider mb40" id="spy1">
													<span>Add Follow Up</span>
												</div>
												<div class="row">
													
													<div class="col-lg-12 mb10">
														<label class="field select">
															<select id="status" name="status">
																<option value="">Status</option>
																<option value="">Lead</option>
																<option value="">Inquiry</option>
																<option value="">Quotation</option>
																<option value="">Sales Order</option>
																<option value="">Delivery</option>
																<option value="">Payment</option>
																<option value="">Done</option>
																<option value="">Close</option>
															</select>
															<i class="arrow"></i>
														</label>
													</div>
													<div class="col-lg-12 mb10">
														<label for="followupdate" class="field prepend-icon">
															<input type="text" name="followupdate" id="followupdate" class="gui-input" placeholder="Follow-Up Date dd/mm/yyyy" readonly>
															<label for="followupdate" class="field-icon">
																<i class="fa fa-calendar-o"></i>
															</label>
														</label>
													</div>
													<div class="col-lg-12 mb10">
														<label for="followup" class="field prepend-icon">
															<input type="text" name="followup" id="followup" class="gui-input" placeholder="Enter Followup Discussion" readonly>
															<label for="followup" class="field-icon">
																<i class="fa fa-bullhorn"></i>
															</label>
														</label>
													</div>
													<div class="col-lg-12 mb10">
														<label for="nextfollowupdate" class="field prepend-icon">
															<input type="text" name="nextfollowupdate" id="nextfollowupdate" class="gui-input" placeholder="Next Follow-Up Date dd/mm/yyyy" readonly>
															<label for="nextfollowupdate" class="field-icon">
																<i class="fa fa-calendar-o"></i>
															</label>
														</label>
													</div>
													<div class="col-lg-12 mb10">
														<label for="comment" class="field prepend-icon">
															<input type="text" name="comment" id="comment" class="gui-input" placeholder="Comment" readonly>
															<label for="comment" class="field-icon">
																<i class="fa fa-bullhorn"></i>
															</label>
														</label>
													</div>
													<div class="col-lg-2">
														<button type="submit" class="btn btn-primary btn-block">Save</button>
													</div>
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
			
			$("#followupdate").datepicker({
				prevText: '<i class="fa fa-chevron-left"></i>',
				nextText: '<i class="fa fa-chevron-right"></i>',
				showButtonPanel: false,
				beforeShow: function(input, inst) {
					var newclass = 'admin-form';
					var themeClass = $(this).parents('.admin-form').attr('class');
					var smartpikr = inst.dpDiv.parent();
					if (!smartpikr.hasClass(themeClass)) {
						inst.dpDiv.wrap('<div class="' + themeClass + '"></div>');
					}
				}
			});
			$("#nextfollowupdate").datepicker({
				prevText: '<i class="fa fa-chevron-left"></i>',
				nextText: '<i class="fa fa-chevron-right"></i>',
				showButtonPanel: false,
				beforeShow: function(input, inst) {
					var newclass = 'admin-form';
					var themeClass = $(this).parents('.admin-form').attr('class');
					var smartpikr = inst.dpDiv.parent();
					if (!smartpikr.hasClass(themeClass)) {
						inst.dpDiv.wrap('<div class="' + themeClass + '"></div>');
					}
				}
			});


			//#followupdate
			
			//Timeline timeline-nextdate
			$(".timeline_toggle").click(function(){
				var timeline_toggle = $(this);
				var ele = $(this).parent().siblings(".timeline-nextdate");
				$(ele).toggle(function(){
					if($(timeline_toggle).hasClass("fa-plus-circle")){
						$(timeline_toggle).removeClass("fa-plus-circle");
						$(timeline_toggle).addClass("fa-minus-circle");
					}else{
						$(timeline_toggle).removeClass("fa-minus-circle");
						$(timeline_toggle).addClass("fa-plus-circle");
					}
				});
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
