<?php
$title = 'Profile';
require_once( __DIR__ . '/header.php' );
?>
<link href="<?php echo DOMAIN_URL ?>assets/admin/pages/css/profile.css" rel="stylesheet" type="text/css" />
<body class="page-header-fixed page-sidebar-closed page-sidebar-closed-hide-logo">
<?php require_once( __DIR__ . '/top_menu.php' ); ?>
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
	<?php require_once( __DIR__ . '/left_menu.php' ); ?>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEAD -->
			<div class="page-head">
				<!-- BEGIN PAGE TITLE -->
				<div class="page-title">
					<h1>User Account
						<small>edit user account</small>
					</h1>
				</div>
			</div>
			<!-- END PAGE HEAD -->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PROFILE SIDEBAR -->
					<div class="profile-sidebar" style="width:250px;">
						<!-- PORTLET MAIN -->
						<div class="portlet light profile-sidebar-portlet load_div">
							<!-- SIDEBAR USERPIC -->
							<div class="profile-userpic">
								<img id="load_img" src="<?php echo get_profile_image( Users::get_my_id(), 125, 125 ); ?>" class="img-responsive" alt="">
							</div>
							<!-- END SIDEBAR USERPIC -->
							<!-- SIDEBAR USER TITLE -->
							<div class="profile-usertitle">
								<div class="profile-usertitle-name">
									<?php echo Users::get_username( Users::get_my_id() ); ?>
								</div>
							</div>
							<!-- END SIDEBAR USER TITLE -->
							<!-- SIDEBAR BUTTONS -->
							<div class="profile-userbuttons">
								<div class="hidden">
									<form id="form3" action="<?php echo DOMAIN_URL ?>profile/upload_image" class="validate" method="post" enctype="multipart/form-data">
										<input type="text" name="id" value="<?php echo Users::get_my_id(); ?>">
										<input type="file" name="profile_image" id="profile_image" accept="image/*">
										<input type="reset" id="file_reset">
									</form>
								</div>
								<button type="button" class="btn btn-circle green-haze btn-sm change_image">Change Image</button>
							</div>
							<!-- END SIDEBAR BUTTONS -->
							<!-- SIDEBAR MENU -->
							<div class="profile-usermenu"></div>
							<!-- END MENU -->
						</div>
						<!-- END PORTLET MAIN -->
					</div>
					<!-- END BEGIN PROFILE SIDEBAR -->
					<!-- BEGIN PROFILE CONTENT -->
					<div class="profile-content">
						<div class="row">
							<div class="col-md-12">
								<div class="portlet light">
									<div class="portlet-title tabbable-line">
										<div class="caption caption-md">
											<i class="icon-globe theme-font hide"></i>
											<span class="caption-subject font-blue-madison bold uppercase">Profile Account</span>
										</div>
										<ul class="nav nav-tabs">
											<li class="active">
												<a href="#tab_1_1" data-toggle="tab">Personal Info</a>
											</li>
											<li>
												<a href="#tab_1_2" data-toggle="tab">Change Password</a>
											</li>
										</ul>
									</div>
									<div class="portlet-body">
										<div class="tab-content">
											<!-- PERSONAL INFO TAB -->
											<div class="tab-pane active" id="tab_1_1">
												<form role="form" id="form1" class="validate" action="<?php echo DOMAIN_URL ?>staff/save" method="post">
													<input class="hidden" type="text" name="profile" value="1">
													<input class="hidden" type="text" name="id" value="<?php echo $u['id']; ?>">
													<input class="hidden" type="text" name="type" value="<?php echo $u['type']; ?>">
													<div class="form-group">
														<label class="control-label bold">Username
															<span class="required">*</span></label>
														<input type="text" name="username" value="<?php echo $u['username']; ?>" required="required" readonly placeholder="Username" class="form-control" />
													</div>
													<div class="form-group">
														<label class="control-label bold">Email
															<span class="required">*</span></label>
														<input type="email" name="email" value="<?php echo $u['email']; ?>" required="required" placeholder="Email" class="form-control" />
													</div>
													<div class="form-group">
														<label class="control-label bold">Mobile Number
															<span class="required">*</span></label>
														<input type="tel" name="phone" value="<?php echo $u['phone']; ?>" placeholder="Phone Number" required="required" class="form-control" />
													</div>
													<div class="form-group">
														<label class="control-label bold">About You</label>
														<textarea class="form-control" name="about" rows="3" placeholder="About you!!!"><?php echo $u['about']; ?></textarea>
													</div>
													<div class="margiv-top-10">
														<button type="submit" class="btn green-haze">
															Save Changes
														</button>
													</div>
												</form>
											</div>
											<!-- END PERSONAL INFO TAB -->
											<!-- CHANGE PASSWORD TAB -->
											<div class="tab-pane" id="tab_1_2">
												<form id="form2" class="validate" method="post" action="<?php echo DOMAIN_URL ?>profile/change_password">
													<input class="hidden" type="reset" id="reset_btn">
													<input class="hidden" type="text" name="id" value="<?php echo $u['id']; ?>">
													<div class="form-group">
														<label class="control-label bold">Old Password
															<span class="required">*</span></label>
														<input type="password" name="old_password" class="form-control" required="required" placeholder="Old password is required." title="Old password is required" />
													</div>
													<div class="form-group">
														<label class="control-label bold">New Password
															<span class="required">*</span></label>
														<input type="password" name="password" class="form-control" required="required" placeholder="Please provide new password" title="Please provide new password" />
													</div>
													<div class="margin-top-10">
														<button type="submit" class="btn green-haze">
															Change Password
														</button>
													</div>
												</form>
											</div>
											<!-- END CHANGE PASSWORD TAB -->
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- END PROFILE CONTENT -->
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
	</div>
	<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php
require_once( __DIR__ . '/footer.php' );
General::insert_js_file( 'profile' );
?>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>