<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<script type='application/javascript'>
		var DOMAIN_URL = '<?php echo DOMAIN_URL ?>';
		var MAIN_DOMAIN_URL = '<?php echo DOMAIN_URL ?>';
		var $_GET = <?php echo json_encode( $_GET ) ?>;
		var CONTENT_PATH = '<?php echo CONTENT_PATH ?>';
		var is_admin = <?php echo Users::is_admin() ? 'true' : 'false' ?>;
		var is_client = <?php echo Users::is_client() ? 'true' : 'false' ?>;
		var localhost = <?php echo General::localhost() ? 'true' : 'false' ?>;
		var is_mobile = <?php echo Users::is_mobile() ? 'true' : 'false'; ?>;
		var is_login = <?php echo Users::is_login() ? 'true' : 'false'; ?>;
		var platform = '<?php echo Users::platform() ? Users::platform() : 'ROBORT'; ?>';
		var function_name = '<?php echo isset( $function_name ) ? $function_name : '' ?>';
		var username = '<?php echo _USERNAME_;?>';
	</script>
	<meta charset="utf-8" />
	<title>Admin <?php echo isset( $title ) ? $title : 'Dashboard'; ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport" />
	<meta content="" name="Property Display" />
	<meta content="" name="Nasir" />
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<script type='application/javascript' src="<?php echo DOMAIN_URL ?>assets/js/staff.js?<?php echo md5_file( ROOT_PATH . "assets/js/staff.js" ); ?>"></script>
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
	<link href="<?php echo DOMAIN_URL ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="<?php echo DOMAIN_URL ?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo DOMAIN_URL ?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo DOMAIN_URL ?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
	<!-- END GLOBAL MANDATORY STYLES -->
	<!-- BEGIN THEME STYLES -->
	<link type="text/css" href="<?php echo DOMAIN_URL ?>assets/global/plugins/select2/select2.css" rel="stylesheet" />
	<link type="text/css" href="<?php echo DOMAIN_URL ?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" rel="stylesheet" />
	<link type="text/css" href="<?php echo DOMAIN_URL ?>assets/global/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
	<link type="text/css" href="<?php echo DOMAIN_URL ?>assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
	<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
	<link href="<?php echo DOMAIN_URL ?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo DOMAIN_URL ?>assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo DOMAIN_URL ?>assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo DOMAIN_URL ?>assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css">
	<!-- END PAGE LEVEL PLUGIN STYLES -->
	<!-- BEGIN PAGE STYLES -->
	<link href="<?php echo DOMAIN_URL ?>assets/admin/pages/css/tasks.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo DOMAIN_URL ?>assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css" />
	<!-- BEGIN THEME STYLES -->
	<link href="<?php echo DOMAIN_URL ?>assets/global/css/plugins.css" rel="stylesheet" type="text/css">
	<link href="<?php echo DOMAIN_URL ?>assets/global/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css">
	<link href="<?php echo DOMAIN_URL ?>assets/admin/layout4/css/layout.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo DOMAIN_URL ?>assets/admin/layout4/css/themes/light.css" rel="stylesheet" type="text/css" id="style_color" />
	<link href="<?php echo DOMAIN_URL ?>assets/admin/layout4/css/custom.css" rel="stylesheet" type="text/css" />
	<!-- END THEME STYLES -->
	<link href="<?php echo DOMAIN_URL ?>assets/images/favicon.ico" rel="shortcut icon" />
	<!-- custom library	-->
	<link href="<?php echo DOMAIN_URL ?>assets/global/tablesaw/tablesaw.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo DOMAIN_URL ?>assets/css/custom.css?<?php echo md5_file( ROOT_PATH . 'assets/css/custom.css' ) ?>" rel="stylesheet" type="text/css" />
	<link href="https://cdnjs.cloudflare.com/ajax/libs/Uniform.js/2.1.2/themes/default/css/uniform.default.min.css" rel="stylesheet">
	<!-- Jquery Template Engine -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-JavaScript-Templates/3.11.0/js/tmpl.min.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" rel="stylesheet" type="text/css">
	<link href="https://printjs-4de6.kxcdn.com/print.min.css" rel="stylesheet" type="text/css">
	<style type="text/css" media="print">
		@page {
			size: auto;   /* auto is the initial value */
			margin: 0mm;  /* this affects the margin in the printer settings */
		}
	</style>
</head>