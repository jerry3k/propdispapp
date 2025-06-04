<?php
$title = 'Pay Fitter';
require_once( __DIR__ . '/header.php' );
General::insert_tpl_file( 'pay_fitter' );
?>
<style type="text/css">
	.pac-container, .pac-logo {
		z-index: 9999999;
	}
</style>

<body class="page-header-fixed page-sidebar-closed-hide-logo">
<div class="hidden">
	<input type="text" class="form-filter" name="id" id="id" value="">
	<input type="text" class="form-filter" name="page" id="page" value="1">
	<input type="text" class="form-filter" name="order" id="order" value="DESC">
	<input type="text" class="form-filter" name="orderby" id="orderby" value="id">
	<input type="text" class="form-filter" name="pagesize" id="pagesize" value="10">
	<input type="text" class="form-filter" name="time_to" id="time_to">
	<input type="text" class="form-filter" name="time_from" id="time_from">
	<input type="text" class="form-filter" name="fitter_id" id="fitter_id">
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
					<h1>Pay Fitters
						<small>create & edit invoices</small>
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
										Total Records :
										<span id="total_records">0</span>
										<div class="btn btn-group margin0 padding0">
											<button class="btn btn-xs blue-madison tooltips" title="ASC" onclick="Page=1;$('#page').val('1');$('#order').val('ASC');$('#orderby').val('id');$('#type').val('');$('#is_active').val('');load_data();Block();">
												<i class="fa fa-sort-numeric-asc"></i></button>
											<button class="btn btn-xs blue-madison tooltips" title="DESC" onclick="Page=1;$('#page').val('1');$('#order').val('DESC');$('#orderby').val('id');$('#type').val('');$('#is_active').val('');load_data();Block();">
												<i class="fa fa-sort-numeric-desc"></i></button>
											<button id="reportrange" class="btn btn-xs green tooltips" title="Date">
												<i class="fa fa-calendar"></i>&nbsp;
												<span></span> <i class="fa fa-caret-down"></i>
											</button>
											<button class="btn btn-xs print yellow-casablanca tooltips" title="Print">
												<i class="fa fa-print"></i></i>
											</button>
										</div>
										<div class="btn btn-group margin0 padding0">
											<select name="select_month" id="select_month" style="border-radius: 5px;height: 30px;border: solid 1px mediumseagreen;">
												<option value="">Select Month</option>
												<option value="0" data-year="<?php echo date( 'Y' ) ?>">January <?php echo date( 'Y' ) ?></option>
												<option value="1" data-year="<?php echo date( 'Y' ) ?>">February <?php echo date( 'Y' ) ?></option>
												<option value="2" data-year="<?php echo date( 'Y' ) ?>">March <?php echo date( 'Y' ) ?></option>
												<option value="3" data-year="<?php echo date( 'Y' ) ?>">April <?php echo date( 'Y' ) ?></option>
												<option value="4" data-year="<?php echo date( 'Y' ) ?>">May <?php echo date( 'Y' ) ?></option>
												<option value="5" data-year="<?php echo date( 'Y' ) ?>">June <?php echo date( 'Y' ) ?></option>
												<option value="6" data-year="<?php echo date( 'Y' ) ?>">July <?php echo date( 'Y' ) ?></option>
												<option value="7" data-year="<?php echo date( 'Y' ) ?>">August <?php echo date( 'Y' ) ?></option>
												<option value="8" data-year="<?php echo date( 'Y' ) ?>">September <?php echo date( 'Y' ) ?></option>
												<option value="9" data-year="<?php echo date( 'Y' ) ?>">October <?php echo date( 'Y' ) ?></option>
												<option value="10" data-year="<?php echo date( 'Y' ) ?>">November <?php echo date( 'Y' ) ?></option>
												<option value="11" data-year="<?php echo date( 'Y' ) ?>">December <?php echo date( 'Y' ) ?></option>
											</select>
										</div>
										<div class="btn btn-group margin0 padding0">
											<select name="fitterid" id="fitterid" style="border-radius: 5px;height: 30px;border: solid 1px mediumseagreen;">
											</select>
										</div>
									</th>
								</tr>
							</table>
						</div>
						<div style="padding-top: 0px;" class="portlet-body">
							<div class='scroll_div' style="width:100%; overflow-x: auto; white-space: nowrap;">
								<table class="table new_table table_alter" style="margin-bottom: 0px">
									<tr class="heading2">
										<th>Fitter/Name</th>
										<th>Company</th>
										<th>Job</th>
										<th>Date Done</th>
										<th>Sticker</th>
										<th>Address</th>
										<th>PostCode</th>
										<th>Amount</th>
									</tr>
									<tbody id="tbody">
									<tr id='temp_row'>
										<td colspan="8" class='center'>
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

<div id="invoice_modal" class="modal container fade" data-backdrop="static" data-keyboard="false" tabindex="-1">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		<h4 class="modal-title">Send Invoice</h4>
	</div>
	<form id="form_sbt" class="validate" method="post" action="<?php echo DOMAIN_URL ?>invoice/send_email">
		<input class="hidden" type="text" name="id" value="0">
		<input class="hidden" type="text" name="invoice" value="">
		<input class="hidden" type="text" name="client_id" value="0">
		<input class="hidden" type="text" name="date_done" value="0">
		<input class="hidden" type="reset" id="btn_reset" value="reset">
		<div class="modal-body">
			<div class="form-group">
				<div class="row">
					<div class="col-md-6">
						<label class="control-label bold">To <span class="required">*</span></label>
						<input type="email" name="to" id="to" readonly required="required" class="form-control" placeholder="To (Email)" />
					</div>
					<div class="col-md-6">
						<label class="control-label bold">Subject <span class="required">*</span></label>
						<input type="text" name="subject" required="required" class="form-control" placeholder="Subject" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-12">
						<label class="control-label bold">Message</label>
						<textarea class="form-control" name="message" cols="5" rows="10" placeholder="Message"></textarea>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<div class="btn-group">
				<button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
				<button type="submit" class="btn blue">Save</button>
			</div>
		</div>
	</form>
</div>

<div class="hidden" id="print_div">
	<table class="custom_table">
		<tr>
			<th>Fitter/Name</th>
			<th>Company</th>
			<th>Job</th>
			<th>Date Done</th>
			<th>Sticker</th>
			<th>Address</th>
			<th>PostCode</th>
			<th>Amount</th>
		</tr>
		<tbody id="tbody2">
		<tr id='temp_row'>
			<td colspan="8" class='center'>
				<i class='fa fa-spin fa-spinner'></i> Loading ....
			</td>
		</tr>
		</tbody>
		<tbody>
		<tr>
			<td colspan="7" style="text-align: right;"><b>Total</b></td>
			<td id="total_price">0</td>
		</tr>
		</tbody>
	</table>
</div>
<!-- full width -->
<?php
require_once( __DIR__ . '/footer.php' );
General::insert_js_file( 'pay_fitter' );
?>
<!-- END BODY -->
</html>