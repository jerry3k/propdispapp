<?php
if ( ! Users::is_admin() ) {
	redirect( DOMAIN_URL . 'jobs/clientview' );
}
$title = 'Jobs';
require_once( __DIR__ . '/header.php' );
General::insert_tpl_file( 'jobs' );
General::insert_css_file( 'jobs' );
?>
<body class="page-header-fixed page-sidebar-closed-hide-logo">
<div class="hidden">
	<input class="form-filter" name="id" id="id" value="<?php echo isset( $_GET['id'] ) ? 'id:' . $_GET['id'] : '' ?>">
	<input class="form-filter" name="orderby" id="orderby" value="id">
	<input class="form-filter" name="order" id="order" value="DESC">
	<input class="form-filter" name="page" id="page" value="1">
	<input class="form-filter" name="pagesize" id="pagesize" value="10">
	<input class="form-filter" name="time_to" id="time_to">
	<input class="form-filter" name="time_from" id="time_from">
	<input class="form-filter" name="espc" id="espc" value="">
	<input class="form-filter" name="questionmark" id="questionmark" value="">
	<?php if ( ! Users::is_admin() ) { ?>
		<input class="form-filter" name="client_id" id="client_id" value="<?php echo Users::get_my_id(); ?>">
	<?php } ?>
</div>
<!-- BEGIN HEADER -->
<?php require_once( __DIR__ . '/top_menu.php' ); ?>
<!-- END HEADER -->

<div style="display: none;" id="filter_div" data-label="<i class='fa fa-search'></i>">
	<div style="margin-bottom: 5px" class="hidden-sm hidden-xs hidden-print">
	</div>
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
					<h1>Jobs
						<small>create & edit jobs
						</small>
					</h1>
				</div>
				<!-- END PAGE TITLE -->
			</div>
			<!-- END PAGE HEAD -->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">

						<table class="table new_table2 table_alter mb0">
							<tr class="heading">
								<th colspan="4">
									<div class="btn btn-group padding0">
										<button id="reportrange" class="btn btn-xs tooltips" title="Date">
											<div class="cal-icon pointer">
												<input type="text" class="form-control" id="show_daterange"
												       placeholder="Select Date">
												<i class="fa fa-calendar"></i>
											</div>
										</button>
										<select name="client_id" id="changeclientid"
										        class="btn btn-sm select2me form-filter"
										        title="Job Type">
										</select>
										<select name="job_type" id="changejobtype"
										        class="btn btn-sm select2me form-filter"
										        title="Job Type">
										</select>
										<select name="fitter_id" id="changefitter"
										        class="btn btn-sm select2me form-filter"
										        title="Fitter">
										</select>
										<select name="job_status" id="changejobstatus"
										        class="btn btn-sm select2me form-filter"
										        title="Job Status">
											<option value="" selected>Select Job Status</option>
											<option value="0">Pending</option>
											<option value="1">Completed</option>
										</select>
										<select name="overplate" id="changeoverplate"
										        class="btn btn-sm select2me form-filter"
										        title="Deliver Own Over Plate">
											<option value="" selected>Deliver Own Over Plate</option>
											<option value="blank">Blank</option>
											<option value="yes">Yes</option>
											<option value="delivered">Delivered</option>
										</select>
									</div>
									<div class="btn btn-group padding0">
										<select name="postcode" id="changepostcode"
										        class="btn btn-sm select2me form-filter"
										        title="Deliver Own Over Plate">
											<option value="" selected>Deliver Own Over Plate</option>
										</select>
										<select name="lost_type" id="changeloasttype"
										        class="btn btn-sm select2me form-filter"
										        title="Lost Type">
											<option value="" selected>Lost Type</option>
											<option value="pole">Pole</option>
											<option value="board">Board</option>
											<option value="both">Both</option>
										</select>
										<select name="contact_type" id="change_contact_type"
										        class="btn btn-sm select2me form-filter"
										        title="Contact Type">
											<option value="" selected>Contact Type</option>
											<option value="email">Email</option>
											<option value="phone">Phone</option>
										</select>
										<label style="margin-top: 8px;">
											<input class="btn btn-xs" id="checkespc" type="checkbox">Espc</label>
										<label>
											<input class="btn btn-xs" id="checkquestionmark" type="checkbox">?</label>
									</div>

									<div class="btn btn-group width100p">
										<button class="btn btn-sm green-dark search_filter tooltips" title="Search"><i class="fa fa-search"></i> Search
										</button>
										<button class="btn btn-sm red reset_search tooltips" type="button"
										        title="Clear"><i class="fa fa-times"></i> Clear
										</button>
										<div class="btn btn-group pull-right top7">
											<button class="btn btn-sm purple-color tooltips" title="Total Record">
												Total Record: <span id="total_records">0</span>
											</button>
											<button class="btn btn-sm blue-madison tooltips" title="ASC"
											        onclick="Page=1;$('#page').val('1');$('#order').val('ASC');$('#orderby').val('jobcode');load_data();Block();">
												ASC
											</button>
											<button class="btn btn-sm blue-madison tooltips" title="DESC"
											        onclick="Page=1;$('#page').val('1');$('#order').val('DESC');$('#orderby').val('jobcode');load_data();Block();">
												DESC
											</button>
											<button class="btn btn-sm purple-studio tooltips print_sticker"
											        title="Sticker Print">
												<i class="fa fa-print"></i> Print Sticker
											</button>
											<select class="btn btn-sm yellow" name="fit-name" id="fitter"
											        title="Job Print"></select>
										</div>
									</div>
								</th>
							</tr>
							<tr class="heading">
								<th colspan="4">
									<div class="input-group margin0 w100">
										<input placeholder="🔎 UniqueID, Address, PostCode etc."
										       class="form-control form-filter" name="search" id="filter_search"
										       type="search"
										       value="<?php echo isset( $_GET['id'] ) ? 'id:' . $_GET['id'] : '' ?>">
										<span class="input-group-btn">
											<button class="btn blue tooltips add_job" type="button" title="Add Job"><i
													class="fa fa-plus"></i> Add Job</button>
											</span>
									</div>
								</th>
							</tr>
						</table>
						<div style="padding-top: 0px;" class="portlet-body">
							<div class='scroll_div hs' style="width:100%; overflow-x: auto; white-space: nowrap;">
								<table class="table new_table table_alter table_font" style="margin-bottom: 5px">
									<tr class="hidden-xs heading2">
										<th class="center">UniqueID</th>
										<th class="center">Job Type</th>
										<th class="center">Sticker</th>
										<th class="center">Position</th>
										<th class="center">Date</th>
										<th class="center">Fitter</th>
										<th class="center">PostCode</th>
										<th class="center">Address / City</th>
										<th class="center">Qty</th>
									</tr>
									<tbody id="tbody">
									<tr id='temp_row'>
										<td class='center' colspan="9">
											<i class='fa fa-spin fa-spinner'></i> Loading ....
										</td>
									</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
	</div>
	<!-- END CONTENT -->
</div>
<!-- END JAVASCRIPTS -->
</body>

<div class="modal fade" id="add_job" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
	<div class="modal-dialog modal-full">
		<form id="form1" method="post" class="validate"
		      action="<?php echo DOMAIN_URL ?>jobs/save"
		      enctype="multipart/form-data">
			<div class="hidden">
				<input type="reset" id="btn_reset" value="reset">
				<input type="text" name="id" value="0">
				<input type="text" id="latitude" name="latitude">
				<input type="text" id="longitude" name="longitude">
				<input type="text" id="administrative_area_level_1" disabled="disabled">
				<input type="text" autocomplete="off" id="route" name="address3">
				<input type="text" name="country" id="country" value="United Kingdom">
			</div>

			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="portlet light bordered">
							<div class="portlet-title">
								<div class="caption">
									<i class="icon-social-dribbble font-purple-soft"></i>
									<span
										class="caption-subject font-purple-soft bold uppercase">Job Information</span>
								</div>
								<div class="actions">
									<a class="btn btn-circle btn-icon-only btn-default" data-dismiss="modal"
									   aria-hidden="true">
										<i class="fa fa-times"></i>
									</a>
								</div>
							</div>
							<div class="portlet-body">
								<ul class="nav nav-tabs">
									<li class="active">
										<a href="#tab_property" class="ptab" data-toggle="tab"> Property </a>
									</li>
									<li>
										<a href="#tab_jobs" data-toggle="tab"> Jobs </a>
									</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane fade active in" id="tab_property">
										<div class="col-md-12 cf-layout4">
											<div class="row">
												<div class="col-md-2">
													<label class="tl-color">Client Name <span
															class="rfield">*</span></label>
													<select name="client_id" class="form-control" id="client_id"
													        required="required">
													</select>
												</div>
												<div class="col-md-2">
													<div class="form-group form-md-line-input has-success">
														<input type="text" name="customer_name" id="customer_name"
														       class="form-control edited input-sm"
														       placeholder="Customer Name">
														<label for="customer_name">Customer Name</label>
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group form-md-line-input has-success">
														<input type="text"
														       class="form-control input-sm edited"
														       name="address1" id="autocomplete"
														       onfocus="geolocate()"
														       onblur="geolocate()"
														       autocomplete="off"
														       required="required">
														<label>Enter your address <span
																class="rfield">*</span></label>
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group form-md-line-input has-success">
														<input type="text" name="address2"
														       autocomplete="off"
														       id="street_number"
														       placeholder="Street Address"
														       class="form-control input-sm edited"
														>
														<label>Street Address</label>
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group form-md-line-input has-success">
														<input type="text" name="city"
														       id="locality"
														       class="form-control input-sm edited"
														       autocomplete="off"
														       required="required"
														       placeholder="City"
														>
														<label>City</label>
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group form-md-line-input has-success">
														<input type="text" name="postcode"
														       id="postal_code"
														       class="form-control input-sm edited"
														       autocomplete="off"
														       placeholder="Post Code">
														<label>Postcode</label>
													</div>
												</div>

												<div class="col-md-12">
													<div id="map"
													     style="width:100%;height:350px;"></div>
												</div>
											</div>
										</div>
									</div>
									<!-- Job Tab -->
									<div class="tab-pane fade" id="tab_jobs">
										<div class="row">
											<div class="col-md-12 center margin-tb-20">
												<button type="button" class="btn green add_subjob">Add Job</button>
											</div>
										</div>
										<!-- Add sub jobs -->
										<div class="load_subjob">
											<h2 class="lmsg center">Click the "Add Job" button to add more jobs to the
												property
												create.</h2>
										</div>
										<div class="get-sub-jobs">
										</div>
										<!-- END SAMPLE FORM PORTLET-->
									</div>
								</div>
								<div class="clearfix margin-bottom-20"></div>
								<div class="tab-content">
									<div class="modal-footer">
										<div class="btn btn-group margin0">
											<button type="button" class="btn dark btn-outline"
											        data-dismiss="modal">
												Close
											</button>
											<button type="submit" class="btn blue">Save</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="print_job_html_modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
     role="dialog"
     aria-hidden="true">
	<div class="modal-dialog modal-full">
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-social-dribbble font-purple-soft"></i>
								<span
									class="caption-subject font-purple-soft bold uppercase">Job Print</span>
							</div>
							<div class="actions">
								<a class="btn btn-circle btn-icon-only btn-default" data-dismiss="modal"
								   aria-hidden="true">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>
						<div class="portlet-body" id="fitter_html"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="print_sticker_html_modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
     role="dialog"
     aria-hidden="true">
	<div class="modal-dialog modal-full">
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-social-dribbble font-purple-soft"></i>
								<span
									class="caption-subject font-purple-soft bold uppercase">Print Sticker</span>
							</div>
							<div class="actions">
								<a class="btn btn-circle btn-icon-only btn-default" data-dismiss="modal"
								   aria-hidden="true">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>
						<div class="portlet-body" id="print_sticker_html"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
require_once( __DIR__ . '/footer.php' );
General::insert_js_file( 'jobs' );
?>
<script
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALtf8vQux4gEiDEeoG0nkZROKYOsvSwmk&libraries=places&callback=initAutocomplete"
	async defer></script>

<!-- END BODY -->
</html>