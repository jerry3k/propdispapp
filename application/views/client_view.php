<?php
$title = 'Client Jobs';
require_once( __DIR__ . '/header.php' );
General::insert_tpl_file( 'jobs_client_view' );
General::insert_css_file( 'jobs' );
?>
<body class="page-header-fixed page-sidebar-closed-hide-logo">
<div class="hidden">
	<input class="form-filter" name="orderby" id="orderby" value="id">
	<input class="form-filter" name="order" id="order" value="DESC">
	<input class="form-filter" name="page" id="page" value="1">
	<input class="form-filter" name="pagesize" id="pagesize" value="10">
	<input class="form-filter" name="time_to" id="time_to">
	<input class="form-filter" name="time_from" id="time_from">
	<input class="form-filter" name="client_id" id="client_id"
	       value="<?php echo isset( $client_id ) ? $client_id : '0'; ?>">
</div>
<!-- BEGIN HEADER -->
<?php require_once( __DIR__ . '/top_menu.php' ); ?>
<!-- END HEADER -->
<div class="clearfix"></div>
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
							<div class="btn btn-group">
								<button class="btn btn-xs purple-color tooltips" title="Total Record">
									Total Record: <span id="total_records">0</span>
								</button>
								<button id="reportrange" class="btn btn-xs dark_purple tooltips"
								        title="Date">
									<i class="fa fa-calendar"></i>&nbsp;
									<span></span> <i class="fa fa-caret-down"></i>
								</button>
								<button class="btn btn-xs blue-madison tooltips" title="ASC"
								        onclick="Page=1;$('#page').val('1');$('#order').val('ASC');$('#orderby').val('jobcode');load_job_with_subtypes();Block();">
									<i class="fa fa-sort-alpha-asc"></i></button>
								<button class="btn btn-xs blue-madison tooltips" title="DESC"
								        onclick="Page=1;$('#page').val('1');$('#order').val('DESC');$('#orderby').val('jobcode');load_job_with_subtypes();Block();">
									<i class="fa fa-sort-alpha-desc"></i></button>
							</div>
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
						<div style="padding-top: 0px;" class="portlet-body">
							<div id="map2" style="width:100%;height:300px;"></div>
						</div>
						<table class="table new_table2 table_alter mb0">
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
												<button class="btn red tooltips reset_search" type="button"
												        title="Clear"><i class="fa fa-times"></i> Clear</button>
											</span>
									</div>
								</th>
							</tr>
						</table>
						<div style="padding-top: 0px;" class="portlet-body">
							<div class='scroll_div hs' style="width:100%; overflow-x: auto; white-space: nowrap;">
								<table class="table new_table2 table_alter table_font" style="margin-bottom: 5px">
									<tr class="heading2">
										<th class="center">UniqueID</th>
										<th class="center">Properties</th>
										<th class="center">Date Added</th>
										<th class="center">Jobs</th>
									</tr>
									<tbody id="tbody">
									<tr id='temp_row'>
										<td class='center' colspan="4">
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
				<input type="text" name="id" value="0">
				<input type="text" id="latitude" name="latitude">
				<input type="text" id="longitude" name="longitude">
				<input type="text" id="administrative_area_level_1" disabled="disabled">
				<input type="text" autocomplete="off" id="route" name="address3">
				<input type="text" name="country" id="country" value="United Kingdom">
				<input type="reset" id="btn_reset" value="reset">
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
													<select name="client_id" id="client_id2" class="form-control"
													        required="required">
														<option
															value="<?php echo $client_id; ?>"><?php echo Users::get_username( $client_id ); ?></option>
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
											<h2 class="lmsg center">Click the button to "Add Job" for more jobs
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

<div class="modal fade" id="add_subjob" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
	<div class="modal-dialog modal-full">
		<form id="form2" method="post" class="validate"
		      action="<?php echo DOMAIN_URL ?>jobs/save2"
		      enctype="multipart/form-data">

			<div class="hidden">
				<input type="text" name="id" value="0">
				<input type="text" name="jobid" value="0">
				<input type="reset" id="btn_reset2" value="reset">
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

								<div class="col-md-12">
									<div class="job-box">

										<div class="col-md-4">
											<label class="tl-color">Job Type <span
													class="rfield">*</span>
											</label>
											<select class="form-control" name="job_type" id="subjob_type"
											        required="required"></select>
										</div>
										<div class="subjob-field"></div>
										<div class="col-md-12 clearfix margin-tb-20 line-sperator"></div>

										<div class="col-md-4">
											<div class="form-group form-md-line-input has-success">
												<input type="text" name="enter_date"
												       class="form-control edited input-sm readonly valid"
												       value="<?php echo MyDateTime::my_date() ?>"
												       placeholder="Date Entered" required="required"
												       readonly="readonly"><label>Date
													Entered <span class="rfield">*</span></label>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group form-md-line-input has-success">
												<input type="text" class="form-control input-sm edited" name="poref"
												       value="" placeholder="PO/Ref Number"><label>PO/Ref
													Number</label></div>
										</div>
										<div class="col-md-4">
											<div class="form-group form-md-line-input has-success">
												<input type="text" name="access" value=""
												       class="form-control input-sm edited" placeholder="Access"><label>Access</label>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group form-md-line-input has-success">
												<input type="text" name="keys_text" value=""
												       class="form-control input-sm edited" placeholder="Keys"><label>Keys</label>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group form-md-line-input has-success">
												<input type="text" name="appointment" value=""
												       placeholder="Appointment"
												       class="form-control input-sm edited"><label>Appointment</label>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group form-md-line-input pt0 has-success">
												<textarea class="form-control" name="comments" rows="4"
												          placeholder="Your Comments..."></textarea>
											</div>
										</div>
									</div>
								</div>

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

<?php
require_once( __DIR__ . '/footer.php' );
General::insert_js_file( 'jobs_client_view' );
?>
<script
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALtf8vQux4gEiDEeoG0nkZROKYOsvSwmk&libraries=places&callback=initAutocomplete"
	async defer></script>

<script type="application/javascript">
	if ( !is_admin ) {
		set_new_url( DOMAIN_URL + 'jobs/client/', 'Client View Page' )
	}
</script>
<!-- END BODY -->
</html>