<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
	<!-- BEGIN HEADER INNER -->
	<div class="page-header-inner">
		<!-- BEGIN LOGO -->
		<div class="page-logo">
			<a href="<?php echo DOMAIN_URL ?>dashboard">
				<img src="<?php echo DOMAIN_URL ?>assets/images/logo.png" style="margin-top: 4px;width: 60px;"
				     alt="logo" class="logo-default"/>
			</a>
			<div class="menu-toggler sidebar-toggler">
				<!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
			</div>
		</div>
		<!-- END LOGO -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"
		   data-target=".navbar-collapse"></a>
		<!-- END RESPONSIVE MENU TOGGLER -->
		<!-- BEGIN PAGE ACTIONS -->
		<!-- DOC: Remove "hide" class to enable the page header actions -->
		<div class="page-actions">
			<div class="btn-group">
				<div class="clock"></div>
			</div>
			<?php if ( General::is_localhost() || General::myip() == '119.155.41.200' ) { ?>
				<div class="btn-group">
					<a class="btn btn-lg yellow-gold tooltips" data-placement="right" title="Download Database"
							href="<?php echo DOMAIN_URL ?>dashboard/db_download" class="white"><i class="fa fa-database"></i> Db
							Download</a>

				</div>
			<?php } ?>
		</div>
		<!-- END PAGE ACTIONS -->
		<!-- BEGIN PAGE TOP -->
		<div class="page-top">
			<!-- BEGIN HEADER SEARCH BOX -->
			<!-- BEGIN TOP NAVIGATION MENU -->
			<div class="top-menu">
				<ul class="nav navbar-nav pull-right">
					<li class="separator hide">
					</li>
					<!-- BEGIN NOTIFICATION DROPDOWN -->
					<li class="separator hide">
					</li>
					<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
					<li class="dropdown dropdown-user dropdown-dark">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
						   data-close-others="true">
						<span class="username username-hide-on-mobile">Hello,
							<?php echo Users::get_username( Users::get_my_id() ) ?> </span>
							<!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
							<img alt="" id="small_img" class="img-circle"
							     src="<?php echo get_profile_image( Users::get_my_id(), 39, 39 ); ?>"/>
						</a>
						<ul class="dropdown-menu dropdown-menu-default">
							<li>
								<a href="<?php echo DOMAIN_URL ?>profile">
									<i class="icon-user"></i> My Profile </a>
							</li>
							<li class="divider">
							</li>
							<li>
								<a href="<?php echo DOMAIN_URL ?>logout">
									<i class="fa fa-unlock-alt"></i> Log Out </a>
							</li>
						</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
			</div>
			<!-- END TOP NAVIGATION MENU -->
		</div>
		<!-- END PAGE TOP -->
	</div>
	<!-- END HEADER INNER -->
</div>
<!-- END HEADER -->