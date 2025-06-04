<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<script type="application/javascript">
		var DOMAIN_URL = '<?php echo DOMAIN_URL ?>';
	</script>
	<meta charset="utf-8"/>
	<title>Login Form</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta content="" name="description"/>
	<meta content="" name="author"/>
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
	      type="text/css"/>
	<link href="<?php echo DOMAIN_URL ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"
	      type="text/css"/>
	<link href="<?php echo DOMAIN_URL ?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css"
	      rel="stylesheet" type="text/css"/>
	<link href="<?php echo DOMAIN_URL ?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"
	      type="text/css"/>
	<link href="<?php echo DOMAIN_URL ?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet"
	      type="text/css"/>
	<!-- END GLOBAL MANDATORY STYLES -->
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link href="<?php echo DOMAIN_URL ?>assets/global/plugins/select2/select2.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo DOMAIN_URL ?>assets/admin/pages/css/login-soft.css" rel="stylesheet" type="text/css"/>
	<!-- END PAGE LEVEL SCRIPTS -->
	<!-- BEGIN THEME STYLES -->
	<link href="<?php echo DOMAIN_URL ?>assets/global/css/components-rounded.css" id="style_components" rel="stylesheet"
	      type="text/css"/>
	<link href="<?php echo DOMAIN_URL ?>assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo DOMAIN_URL ?>assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
	<link id="style_color" href="<?php echo DOMAIN_URL ?>assets/admin/layout/css/themes/default.css" rel="stylesheet"
	      type="text/css"/>
	<link href="<?php echo DOMAIN_URL ?>assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo DOMAIN_URL ?>assets/css/custom.css" rel="stylesheet" type="text/css"/>
	<!-- END THEME STYLES -->
	<link rel="shortcut icon" href="<?php echo DOMAIN_URL ?>assets/images/favicon.ico"/>
	<link href="<?php echo DOMAIN_URL ?>assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN LOGO -->
<div class="logo">
	<a href="<?php echo DOMAIN_URL ?>">
		<img src="<?php echo DOMAIN_URL ?>assets/images/logo.png" alt="Property Display" width="100px"/>
	</a>
</div>
<!-- END LOGO -->
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGIN -->
<div class="content">
	<!-- BEGIN LOGIN FORM -->
	<form id="form1" class="login-form validate" action="<?php echo DOMAIN_URL ?>login/login_validation" method="post">
		<h3 class="form-title">Login to your account</h3>
		<div class="alert alert-danger display-hide">
			<button class="close" data-close="alert"></button>
			<span class="message">
			Enter any email and password. </span>
		</div>
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9">Username</label>
			<div class="input-icon">
				<i class="fa fa-user"></i>
				<input class="form-control placeholder-no-fix" type="email" autocomplete="off"
				       placeholder="Email Address" name="email" required="required"
				       title="Please type your email address..."/>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Password</label>
			<div class="input-icon">
				<i class="fa fa-lock"></i>
				<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password"
				       name="password" required="required" title="Please type your password..."/>
			</div>
		</div>
		<div class="form-actions" style="padding-bottom: 5px">
			<label class="checkbox">
				<input type="checkbox" name="remember" value="1"/> Remember me </label>
			<button type="submit" class="btn blue pull-right">
				Login <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>
		<div class="forget-password" style="margin-top: 5px">
			<h4>Forgot your password ?</h4>
			<p>
				no worries, click <a id="forget-password" style="color: yellow;">
					here </a>
				to reset your password.
			</p>
		</div>
	</form>
	<!-- END LOGIN FORM -->
	<!-- BEGIN FORGOT PASSWORD FORM -->
	<form id="form2" class="forget-form validate" action="<?php echo DOMAIN_URL ?>login/forgetpassword" method="post">
		<input type="reset" class="hidden" id="reset_btn">
		<h3>Forget Password ?</h3>
		<p>
			Enter your e-mail address below to reset your password.
		</p>
		<div class="form-group">
			<div class="input-icon">
				<i class="fa fa-envelope"></i>
				<input class="form-control placeholder-no-fix" type="email" required="required" autocomplete="off"
				       placeholder="Email" name="email"/>
			</div>
		</div>
		<div class="form-actions">
			<button type="button" id="back-btn" class="btn">
				<i class="m-icon-swapleft"></i> Back
			</button>
			<button type="submit" class="btn blue pull-right">
				Submit <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>
	</form>
	<!-- END FORGOT PASSWORD FORM -->
</div>
<!-- END LOGIN -->
<!-- BEGIN COPYRIGHT -->
<div class="copyright">
	<?php echo date( 'Y' ) ?> &copy; Property - Admin Dashboard Template.
</div>
<!-- END COPYRIGHT -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo DOMAIN_URL ?>assets/global/plugins/respond.min.js"></script>
<script src="<?php echo DOMAIN_URL ?>assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
<script src="<?php echo DOMAIN_URL ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo DOMAIN_URL ?>assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="<?php echo DOMAIN_URL ?>assets/global/plugins/bootstrap/js/bootstrap.min.js"
        type="text/javascript"></script>
<script src="<?php echo DOMAIN_URL ?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo DOMAIN_URL ?>assets/global/plugins/uniform/jquery.uniform.min.js"
        type="text/javascript"></script>
<script src="<?php echo DOMAIN_URL ?>assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo DOMAIN_URL ?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js"
        type="text/javascript"></script>
<script src="<?php echo DOMAIN_URL ?>assets/global/plugins/backstretch/jquery.backstretch.min.js"
        type="text/javascript"></script>

<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo DOMAIN_URL ?>assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo DOMAIN_URL ?>assets/admin/layout/scripts/layout.js" type="text/javascript"></script>

<!-- Library -->
<script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.6/dist/loadingoverlay.min.js"></script>
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/additional-methods.min.js"></script>
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<!-- custom js files -->
<script src="<?php echo DOMAIN_URL ?>assets/js/scripts.js?<?php echo md5_file( ROOT_PATH . 'assets/js/scripts.js' ) ?>"
        type="text/javascript"></script>

<script src="<?php echo DOMAIN_URL ?>assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script type="application/javascript">

	function Error( text ) {
		toastr.options = {
			"closeButton": true,
			"debug": false,
			"positionClass": "toast-top-center",
			"onclick": null,
			"showDuration": "1000",
			"hideDuration": "1000",
			"timeOut": "5000",
			"extendedTimeOut": "1000",
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		}
		var $toast = toastr[ 'error' ]( text, 'Error' );
	}

	function Success( text ) {
		toastr.options = {
			"closeButton": true,
			"debug": false,
			"positionClass": "toast-top-center",
			"onclick": null,
			"showDuration": "1000",
			"hideDuration": "1000",
			"timeOut": "5000",
			"extendedTimeOut": "1000",
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		}
		var $toast = toastr[ 'success' ]( text, 'Success' );
	}

	$( function() {
		$( 'form.validate' ).each( function() {
			$( this ).validate();
		} );

		$( document ).on( 'click', '#forget-password', function( e ) {
			e.preventDefault();
			$( '.login-form' ).hide();
			$( '.forget-form' ).show();
		} );
		$( document ).on( 'click', '#back-btn', function( e ) {
			e.preventDefault();
			$( '.login-form' ).show();
			$( '.forget-form' ).hide();
		} );

		Metronic.init(); // init metronic core components
		Layout.init(); // init current layout

		// init background slide images
		$.backstretch( [
				DOMAIN_URL + "assets/admin/pages/media/bg/1.jpg",
				DOMAIN_URL + "assets/admin/pages/media/bg/2.jpg",
				DOMAIN_URL + "assets/admin/pages/media/bg/3.jpg",
				DOMAIN_URL + "assets/admin/pages/media/bg/4.jpg"
			], {
				fade: 1000,
				duration: 5000
			}
		);

		$( document ).on( 'submit', '#form1', function( e ) {
			e.preventDefault();
			$.LoadingOverlay( "show" );
			$( '#form1' ).ajaxSubmit( {
				success: function( data ) {
					$.LoadingOverlay( "hide" );
					if ( isset( data ) && data == 'OK' ) {
						window.location.href = DOMAIN_URL + 'dashboard';
					} else {
						$( '.display-hide' ).show();
						$( '.message' ).html( data );
					}
				},
			} );
		} );

		$( document ).on( 'submit', '#form2', function( e ) {
			e.preventDefault();
			$.LoadingOverlay( "show" );
			$( '#form2' ).ajaxSubmit( {
				success: function( data ) {
					$.LoadingOverlay( "hide" );
					console.log( data );
					if ( data == 'OK' ) {
						Success( 'Your password have been reset. Goto you email account thnaks.' );
						$( '#form2 #reset_btn' ).trigger( 'click' );
					} else {
						Error( data );
					}
				},
			} );
		} );

	} );
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>