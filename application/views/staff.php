<?php
$title = 'Staff';
require_once( __DIR__ . '/header.php' );
General::insert_tpl_file( 'staff' );
?>

<body class="page-header-fixed page-sidebar-closed-hide-logo">
<div class="hidden">
	<input class="form-filter" name="orderby" id="orderby" value="id">
	<input class="form-filter" name="order" id="order" value="DESC">
	<input class="form-filter" name="type" id="type" value="client">
	<input class="form-filter" name="page" id="page" value="1">
	<input class="form-filter" name="is_active" id="is_active" value="">
	<input class="form-filter" name="pagesize" id="pagesize" value="10">
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
					<h1>All Staff / Clients
						<small>create & edit staff users</small>
					</h1>
				</div>
				<!-- END PAGE TITLE -->
			</div>
			<!-- END PAGE HEAD -->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div style="margin: 0px" class="portlet-title">
							<table class="table new_table table_alter" style="margin-bottom: 0px">
								<tr class="heading">
									<th style="width: 50%">
										<div>
											Total Records :
											<span id="total_records">0</span>
										</div>
										<div class="btn btn-group margin0 padding0">
											<button class="btn btn-xs blue-madison tooltips" title="ASC"
											        onclick="Page=1;$('#page').val('1');$('#order').val('ASC');$('#orderby').val('username');$('#type').val('');$('#is_active').val('');load_data();Block();">
												<i class="fa fa-sort-numeric-asc"></i></button>
											<button class="btn btn-xs blue-madison tooltips" title="DESC"
											        onclick="Page=1;$('#page').val('1');$('#order').val('DESC');$('#orderby').val('username');$('#type').val('');$('#is_active').val('');load_data();Block();">
												<i class="fa fa-sort-numeric-desc"></i></button>
											<button class="btn btn-xs green-haze tooltips" title="Active"
											        onclick="Page=1;$('#page').val('1');$('#type').val('');$('#is_active').val('1');load_data();Block();">
												Active
											</button>
											<button class="btn btn-xs red-sunglo tooltips" title="Deactive"
											        onclick="Page=1;$('#page').val('1');$('#type').val('');$('#is_active').val('0');load_data();Block();">
												Deactive
											</button>
										</div>

										<div class="btn btn-group margin0 padding0">
											<button class="btn btn-xs blue-hoki tooltips" title="All"
											        onclick="Page=1;$('#page').val('1');$('#type').val('');$('#is_active').val('');load_data();Block();">
												All
											</button>
											<button class="btn btn-xs grey-gallery tooltips" title="Admin"
											        onclick="Page=1;$('#page').val('1');$('#type').val('admin');$('#is_active').val('');load_data();Block();">
												Admin
											</button>
											<button class="btn btn-xs purple tooltips" title="Semi Admin"
											        onclick="Page=1;$('#page').val('1');$('#type').val('semi');$('#is_active').val('');load_data();Block();">
												Semi Admin
											</button>
											<button class="btn btn-xs green-seagreen tooltips" title="Fitter"
											        onclick="Page=1;$('#page').val('1');$('#type').val('fitter');$('#is_active').val('');load_data();Block();">
												Fitter</i></button>
											<button class="btn btn-xs yellow-casablanca tooltips" title="Client"
											        onclick="Page=1;$('#page').val('1');$('#type').val('client');$('#is_active').val('');load_data();Block();">
												Client</i></button>
										</div>

									</th>
									<th style="width: 50%">
										<div class="input-group margin0">
											<input placeholder="🔎 Name, Phone, Email, Type etc."
											       class="form-control form-filter" name="search" id="filter_search"
											       type="search">
											<span class="input-group-btn">
												<button class="btn blue tooltips add_user" type="button"
												        title="Add User"><i class="fa fa-plus"></i> Add User</button>
												<button class="btn red tooltips reset_search" type="button"
												        title="Clear"><i class="fa fa-times"></i> Clear</button>
											</span>
										</div>
									</th>
								</tr>
							</table>
						</div>
						<div style="padding-top: 0px;" class="portlet-body">
							<div class='scroll_div' style="width:100%; overflow-x: auto;">
								<table class="table new_table table_alter marginb0">
									<tr class="hidden-xs heading2">
										<th>Company
											<div class="btn-group margin0 padding0">
												<button class="btn btn-xs blue-madison tooltips" data-placement="bottom"
												        title="ASC"
												        onclick="Page=1;$('#page').val('1');$('#order').val('ASC');$('#orderby').val('username');$('#type').val('');$('#is_active').val('');load_data();Block();">
													<i class="fa fa-sort-alpha-asc"></i></button>
												<button class="btn btn-xs blue-madison tooltips" data-placement="bottom"
												        title="DESC"
												        onclick="Page=1;$('#page').val('1');$('#order').val('DESC');$('#orderby').val('username');$('#type').val('');$('#is_active').val('');load_data();Block();">
													<i class="fa fa-sort-alpha-desc"></i></button>
											</div>
										</th>
										<th>Username/Email
											<div class="btn btn-group margin0 padding0">
												<button class="btn btn-xs blue-madison tooltips" data-placement="bottom"
												        title="ASC"
												        onclick="Page=1;$('#page').val('1');$('#order').val('ASC');$('#orderby').val('email');$('#type').val('');$('#is_active').val('');load_data();Block();">
													<i class="fa fa-sort-alpha-asc"></i></button>
												<button class="btn btn-xs blue-madison tooltips" data-placement="bottom"
												        title="DESC"
												        onclick="Page=1;$('#page').val('1');$('#order').val('DESC');$('#orderby').val('email');$('#type').val('');$('#is_active').val('');load_data();Block();">
													<i class="fa fa-sort-alpha-desc"></i></button>
											</div>
										</th>
										<th>Phone
											<div class="btn-group margin0 padding0">
												<button class="btn btn-xs blue-madison tooltips" data-placement="bottom"
												        title="ASC"
												        onclick="Page=1;$('#page').val('1');$('#order').val('ASC');$('#orderby').val('phone');$('#type').val('');$('#is_active').val('');load_data();Block();">
													<i class="fa fa-sort-alpha-asc"></i></button>
												<button class="btn btn-xs blue-madison tooltips" data-placement="bottom"
												        title="DESC"
												        onclick="Page=1;$('#page').val('1');$('#order').val('DESC');$('#orderby').val('phone');$('#type').val('');$('#is_active').val('');load_data();Block();">
													<i class="fa fa-sort-alpha-desc"></i></button>
											</div>
										</th>
										<th>Type</th>
										<th>Status</th>
									</tr>
									<tbody id="tbody">
									<tr id='temp_row'>
										<td colspan="5" class='center'>
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
<!-- full width -->

<div class="modal fade" id="add_user" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
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
									class="caption-subject font-purple-soft bold uppercase">Add User</span>
							</div>
							<div class="actions">
								<a class="btn btn-circle btn-icon-only btn-default" data-dismiss="modal"
								   aria-hidden="true">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>
						<div class="portlet-body">

							<form id="form1" class="validate" action="<?php echo DOMAIN_URL ?>staff/save" method="post"
							      enctype="multipart/form-data">
								<div class="hidden">
									<div id="map"></div>s
									<input type="text" name="id" value="0">
									<input type="reset" id="btn_reset" value="reset">
									<input type="text" id="latitude" name="latitude">
									<input type="text" id="longitude" name="longitude">
									<input type="text" id="administrative_area_level_1" disabled="disabled">
									<input type="text" autocomplete="off" id="route" name="address3">
									<input type="text" name="country" value="United Kingdom" id="country">
								</div>
								<div class="modal-body">
									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<label class="control-label bold">Username / Email <span
														class="required">*</span></label>
												<input class="form-control" id="userinfo" type="email"
												       placeholder="Username/Email"
												       name="email" required="required" title="Please type your email"/>
											</div>
											<div class="col-md-6">
												<label class="control-label bold">User Type <span
														class="required">*</span></label>
												<div class="radio-list">
													<label class="radio-inline">
														<input type="radio" name="type" required="required" value="semi"
														       class="change_type"/> Semi Admin
													</label>
													<label class="radio-inline">
														<input type="radio" name="type" value="fitter"
														       class="change_type"/> Fitter
													</label>
													<label class="radio-inline">
														<input type="radio" name="type" value="client"
														       class="change_type"/> Client
													</label>
												</div>
											</div>
										</div>
										<div class="row phone_field" style="display: none;">
											<div class="col-md-6">
												<label class="control-label bold">Phone <span class="required">*</span></label>
												<input class="form-control" type="tel" placeholder="Phone Number"
												       name="phone"
												       required="required" title="Please type your phone number"/>
											</div>
										</div>
									</div>

									<div id="client_div" style="display: none;">
										<div class="form-group header-bg-color">
											<div class="modal-header">
												<h4 class="modal-title bold">Client Info</h4>
											</div>
										</div>

										<div class="form-group">
											<div class="row">
												<div class="col-md-3">
													<label class="control-label bold">Email Address (Contact)<span
															class="required">*</span></label>
													<input class="form-control" type="email"
													       placeholder="Email Address (Email address where the invoices are sent)"
													       name="email_contact" required="required"
													       title="Please type your email"/>
												</div>
												<div class="col-md-3">
													<label class="control-label bold">Company Name</label>
													<input class="form-control" type="text" placeholder="Company Name"
													       name="username"/>
												</div>
												<div class="col-md-3">
													<label class="control-label bold">Telephone <span
															class="required">*</span></label>
													<input class="form-control" type="tel" placeholder="Telephone"
													       name="telephone"
													       required="required"/>
												</div>
												<div class="col-md-3">
													<label class="control-label bold">Fax Number</label>
													<input class="form-control" type="tel" placeholder="Fax Number"
													       name="fax"/>
												</div>
												<div class="col-md-12">
													<label class="control-label bold">FSB/TO LET BD
														<span class="required">*</span></label>
													<div class="radio-list">
														<label class="radio-inline">
															<input type="radio" name="fsb_let_bd" required="required"
															       value="FSB"
															       checked> FSB
														</label>
														<label class="radio-inline">
															<input type="radio" name="fsb_let_bd" required="required"
															       value="TO LET BD">
															TO LET BD</label>
													</div>
												</div>
											</div>
										</div>

										<div class="form-group header-bg-color">
											<div class="modal-header">
												<h4 class="modal-title bold">Address</h4>
											</div>
										</div>

										<div class="form-group">
											<div class="row">
												<div class="col-md-3">
													<label class="control-label bold">Address
														<span class="required">*</span></label>
													<input class="form-control" type="text"
													       name="address1" id="autocomplete"
													       onfocus="geolocate()"
													       onblur="geolocate()"
													       autocomplete="off"
													       placeholder="Enter your address"
													       required="required"
													       title="Enter your address."/>
												</div>
												<div class="col-md-3">
													<label class="control-label bold">Street Address</label>
													<input class="form-control" type="text" id="street_number"
													       name="address2"
													       placeholder="Street Address"/>
												</div>
												<div class="col-md-6 hidden">
													<label class="control-label bold">Route Address</label>
													<input class="form-control" type="text" id="route" name="address3"
													       placeholder="Street Address 3"/>
												</div>
												<div class="col-md-3">
													<label class="control-label bold">Postcode</label>
													<input class="form-control" type="text" id="postal_code"
													       name="postcode"
													       placeholder="Post Code"/>
												</div>
												<div class="col-md-3">
													<label class="control-label bold">City <span
															class="required">*</span></label>
													<input class="form-control" type="text" name="city" id="locality"
													       placeholder="City"
													       required="required"/>
												</div>
											</div>
										</div>
										<div class="form-group header-bg-color">
											<div class="modal-header">
												<h4 class="modal-title bold">Other</h4>
											</div>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-md-4">
													<label class="control-label bold">Company Website</label>
													<input class="form-control" type="url" placeholder="Company Website"
													       name="website"/>
												</div>
												<div class="col-md-4">
													<label class="control-label bold">Sticker Type</label>
													<input class="form-control" type="text" placeholder="Sticker Type"
													       name="sticker"/>
												</div>
												<div class="col-md-4">
													<label class="control-label bold">Pricing System
														<span class="required">*</span></label>
													<select class="form-control" id="pricing_system"
													        name="pricing_system"
													        required="required">
														<option value="A">PriceA</option>
														<option value="B">PriceB</option>
														<option value="Supply only">Supply only</option>
													</select>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-md-12">
													<label class="control-label bold">Notes</label>
													<textarea class="form-control" name="note" cols="5" rows="5"
													          placeholder="Notes"></textarea>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<div class="btn btn-group margin0">
										<button type="button" class="btn dark btn-outline"
										        data-dismiss="modal">
											Close
										</button>
										<button type="submit" class="btn blue">Save</button>
									</div>
								</div>
							</form>

						</div>
					</div>

				</div>
			</div>
		</div>

	</div>
	<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="sendEmail" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
	<div class="modal-dialog modal-full">
		<div class="modal-content">
			<div class="modal-header header-bg-color">
				<button type="button" class="close" data-dismiss="modal"
				        aria-hidden="true"></button>
				<h4 class="modal-title">Send Email</h4>
			</div>
			<form id="form2" class="validate" action="<?php echo DOMAIN_URL ?>staff/send_email" method="post"
			      enctype="multipart/form-data">
				<div class="hidden">
					<input type="text" name="id" value="0">
					<input type="reset" id="btn_reset" value="reset">
				</div>
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label class="control-label bold">Email <span class="required">*</span></label>
								<input class="form-control" type="email" placeholder="Email" name="email"
								       required="required">
							</div>
							<div class="col-md-6">
								<label class="control-label bold">Subject <span class="required">*</span></label>
								<input class="form-control" type="text" placeholder="Subject" name="subject"
								       required="required" value="Activate your account">
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<label class="control-label bold">Message <span class="required">*</span></label>
								<textarea class="form-control" rows="5" placeholder="Type your message" name="message"
								          required="required">Please login and activate your account thanks.</textarea>
							</div>

						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="btn btn-group margin0">
						<button type="button" class="btn dark btn-outline"
						        data-dismiss="modal">
							Close
						</button>
						<button type="submit" class="btn blue">Save</button>
					</div>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<?php
require_once( __DIR__ . '/footer.php' );
General::insert_js_file( 'staff' );
?>

<script
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALtf8vQux4gEiDEeoG0nkZROKYOsvSwmk&libraries=places&callback=initAutocomplete"
	async defer></script>

<!-- END BODY -->
</html>