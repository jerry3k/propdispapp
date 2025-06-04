<?php
$title = 'Staff';
require_once( __DIR__ . '/header.php' ); ?>
<link href="<?php echo DOMAIN_URL ?>assets/admin/pages/css/coming-soon.css" rel="stylesheet" type="text/css" />
<body class="page-header-fixed page-sidebar-closed-hide-logo">
<!-- BEGIN HEADER -->
<?php require_once( __DIR__ . '/top_menu.php' ); ?>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
	<?php require_once( __DIR__ . '/left_menu.php' ); ?>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Modal title</h4>
						</div>
						<div class="modal-body">
							Widget settings form goes here
						</div>
						<div class="modal-footer">
							<button type="button" class="btn blue">Save changes</button>
							<button type="button" class="btn default" data-dismiss="modal">Close</button>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
			<!-- /.modal -->
			<!-- END PAGE HEAD -->
			<!-- BEGIN PAGE CONTENT-->
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<a class="brand" href="<?php echo DOMAIN_URL ?>">
							<img src="<?php echo DOMAIN_URL ?>assets/admin/layout4/img/logo-big.png" alt="logo">
						</a>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 coming-soon-content">
						<h1>Coming Soon!</h1>
						<p>
							At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi vehicula sem ut volutpat. Ut non libero magna fusce condimentum eleifend enim a feugiat.
						</p>
						<br>
						<form class="form-inline" action="#">
							<div class="input-group input-large">
								<input type="text" class="form-control">
								<span class="input-group-btn">
					<button class="btn blue" type="button">
					<span>
					Subscribe </span>
					<i class="m-icon-swapright m-icon-white"></i></button>
					</span>
							</div>
						</form>
						<ul class="social-icons margin-top-20">
							<li>
								<a href="#" data-original-title="Feed" class="rss">
								</a>
							</li>
							<li>
								<a href="#" data-original-title="Facebook" class="facebook">
								</a>
							</li>
							<li>
								<a href="#" data-original-title="Twitter" class="twitter">
								</a>
							</li>
							<li>
								<a href="#" data-original-title="Goole Plus" class="googleplus">
								</a>
							</li>
							<li>
								<a href="#" data-original-title="Pinterest" class="pintrest">
								</a>
							</li>
							<li>
								<a href="#" data-original-title="Linkedin" class="linkedin">
								</a>
							</li>
							<li>
								<a href="#" data-original-title="Vimeo" class="vimeo">
								</a>
							</li>
						</ul>
					</div>
					<div class="col-md-6 coming-soon-countdown">
						<div id="defaultCountdown" class="hasCountdown">
							<span class="countdown_row countdown_show4"><span class="countdown_section"><span class="countdown_amount">61</span><br>Days</span><span class="countdown_section"><span class="countdown_amount">7</span><br>Hours</span><span class="countdown_section"><span class="countdown_amount">4</span><br>Minutes</span><span class="countdown_section"><span class="countdown_amount">32</span><br>Seconds</span></span>
						</div>
					</div>
				</div>
				<!--/end row-->
			</div>
			<!-- END PAGE CONTENT-->
		</div>
	</div>
	<!-- END CONTENT -->
</div>
<!-- END JAVASCRIPTS -->
</body>
<?php require_once( __DIR__ . '/footer.php' ); ?>
<script src="<?php echo DOMAIN_URL ?>assets/global/plugins/countdown/jquery.countdown.min.js" type="text/javascript"></script>
<script src="<?php echo DOMAIN_URL ?>assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
<script src="<?php echo DOMAIN_URL ?>assets/admin/pages/scripts/coming-soon.js" type="text/javascript"></script>
<script>
	jQuery( document ).ready( function() {
		ComingSoon.init();
		// init background slide images
		$.backstretch( [
			DOMAIN_URL + "assets/admin/pages/media/bg/1.jpg",
			DOMAIN_URL + "assets/admin/pages/media/bg/2.jpg",
			DOMAIN_URL + "assets/admin/pages/media/bg/3.jpg",
			DOMAIN_URL + "assets/admin/pages/media/bg/4.jpg"
		], {
			fade: 1000,
			duration: 10000
		} );
	} );
</script>

<!-- END BODY -->
</html>