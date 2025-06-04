<div class="page-sidebar-wrapper">
	<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
	<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
	<div class="page-sidebar navbar-collapse collapse">
		<ul class="page-sidebar-menu
		<?php if ( isset( $function_name ) && $function_name == 'profile' ) {
			echo 'page-sidebar-menu-closed';
		} ?>" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
			<li class="start <?php if ( isset( $function_name ) && $function_name == 'dashboard' ) {
				echo 'active';
			} ?>">
				<a href="<?php echo DOMAIN_URL ?>dashboard">
					<i class="icon-home"></i>
					<span class="title">Dashboard</span>
				</a>
			</li>

			<?php if ( Users::is_admin() ) { ?>
				<li class="start <?php if ( isset( $function_name ) && $function_name == 'staff' ) {
					echo 'active';
				} ?>">
					<a href="<?php echo DOMAIN_URL ?>staff">
						<i class="icon-users"></i>
						<span class="title">All Staff</span>
					</a>
				</li>
				<li class="start <?php if ( isset( $function_name ) && $function_name == 'jobtype' ) {
					echo 'active';
				} ?>">
					<a href="<?php echo DOMAIN_URL ?>jobtype">
						<i class="fa fa-database"></i>
						<span class="title">Job Type</span>
					</a>
				</li>
			<?php } ?>
			<li class="start <?php if ( isset( $function_name ) && $function_name == 'jobs' ) {
				echo 'active';
			} ?>">
				<a href="<?php echo DOMAIN_URL ?>jobs">
					<i class="icon-briefcase"></i>
					<span class="title">Jobs</span>
				</a>
			</li>

			<?php if ( Users::is_admin() ) { ?>
			<li class="start <?php if ( isset( $function_name ) && $function_name == 'invoice' ) {
				echo 'active';
			} ?>">
				<a href="<?php echo DOMAIN_URL ?>invoice">
					<i class="icon-paper-plane"></i>
					<span class="title">Invoice</span>
				</a>
			</li>
			<?php } ?>

			<li class="divider">
			</li>

			<li class="start <?php if ( isset( $function_name ) && $function_name == 'logout' ) {
				echo 'active';
			} ?>">
				<a href="<?php echo DOMAIN_URL ?>logout">
					<i class="fa fa-unlock-alt"></i>
					<span class="title">Logout</span>
				</a>
			</li>

		</ul>
	</div>
</div>