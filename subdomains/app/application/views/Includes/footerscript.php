<script src="<?php echo base_url('assets/vendor/jquery/jquery-3.1.1.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery/jquery_migrate/jquery-migrate-3.0.0.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery/jquery_ui/jquery-ui.min.js'); ?>"></script>

<!-- Theme Javascript -->
<script src="<?php echo base_url('assets/assets/js/utility/utility.js'); ?>"></script>
<script src="<?php echo base_url('assets/assets/js/main.js'); ?>"></script>

<script src="<?php echo base_url('assets/assets/admin-tools/admin-forms/js/jquery-ui-datepicker.min.js'); ?>"></script>
<!-- Datatables -->
<script src="<?php echo base_url('assets/vendor/plugins/datatables/media/js/datatables.min.js'); ?>"></script>
<!-- jQuery Validate Plugin-->
<script src="<?php echo base_url('assets/assets/admin-tools/admin-forms/js/jquery.validate.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/sweetalert.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/plugins/select2/js/select2.min.js'); ?>"></script>

<script>
    jQuery(document).ready(function() {
        setTimeout(function() {
            $(".alert-dismissable").fadeTo(2000, 500).slideUp(500, function() {
                $(".alert-dismissable").slideUp(500);
            });
        }, 1000);
        $(".select2-single").select2({
            allowClear: true
        });
    });
</script>