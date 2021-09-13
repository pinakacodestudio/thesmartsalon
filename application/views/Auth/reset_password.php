<!DOCTYPE html>
<html>

<head>
	<?php $this->load->view('Includes/head'); ?>
</head>

<body class="external-page sb-l-c sb-r-c">
	<!-- Start: Main -->
	<div id="main" class="animated fadeIn">
		<!-- Start: Content-Wrapper -->
		<section id="content_wrapper">
			<!-- Begin: Content -->
			<section id="content">

				<div class="admin-form theme-info mw500" id="login1" style="max-width:500px;">

					<div class="row mb15">
						<div class="va-m pln">
							<a href="<?= base_url(); ?>" title="Return to Dashboard">
								<img src="<?php echo base_url(); ?>assets/assets/img/logos/logo_white.png" title="" class="img-responsive w250">
							</a>
						</div>
					</div>

					<div class="panel panel-default heading-border mt10 br-n">

						<!-- end .form-header section -->
						<?php echo form_open('auth/reset_password/' . $code, ['name' => 'loginForm', 'id' => 'loginForm']); ?>
						<div class="panel-body bg-light p30">
							<div class="row">
								<div class="col-sm-12">
									<?php
									if ($msg = $this->session->flashdata('error_msg')) :
										echo '  <div class="alert alert-danger dark alert-dismissable p5">' . $msg . '</div>';
									endif;
									if ($msg = $this->session->flashdata('success_msg')) :
										echo '  <div class="alert alert-info dark alert-dismissable p5">' . $msg . '</div>';
									endif;
									?>
									<div class="section">
										<h4 class="text-center"><?php echo lang('reset_password_heading'); ?></h4>
										<label for="new" class="field-label text-muted fs18 mb10">New Password (at least 6 characters long)</label>
										<label for="username" class="field prepend-icon">
											<?php echo form_password(['name' => 'new', 'id' => 'new', 'placeholder' => 'Enter New Password', 'class' => 'gui-input', 'pattern' => '^.{6}.*$']); ?>
										</label>
									</div>
									<div class="section">
										<label for="new" class="field-label text-muted fs18 mb10">Confirm Password </label>
										<label for="username" class="field prepend-icon">
											<?php echo form_password(['name' => 'new_confirm', 'id' => 'new_confirm', 'placeholder' => 'Enter Confirm Password', 'class' => 'gui-input', 'pattern' => '^.{6}.*$']); ?>
										</label>
									</div>
									<?php echo form_input($user_id); ?>
									<?php echo form_hidden($csrf); ?>
									<!-- end section -->
								</div>
							</div>
						</div>
						<!-- end .form-body section -->
						<div class="panel-footer clearfix p10 ph15">
							<?php echo form_submit(['value' => lang('reset_password_submit_btn'), 'class' => 'button btn-primary mr10 pull-right']); ?>
						</div>
						<!-- end .form-footer section -->
						<?php echo form_close(); ?>
					</div>
				</div>
			</section>
			<!-- End: Content -->
		</section>
		<!-- End: Content-Wrapper -->

	</div>
	<!-- End: Main -->

	<?php $this->load->view('Includes/footerscript'); ?>
</body>

</html>