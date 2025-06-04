<?php
$title = 'Staff';
require_once( __DIR__ . '/header.php' );
General::insert_tpl_file( 'jobtype' );
?>
<body class="page-header-fixed page-sidebar-closed-hide-logo">
<div class="hidden">
	<input class="form-filter" name="orderby" id="orderby" value="name">
	<input class="form-filter" name="order" id="order" value="ASC">
	<input class="form-filter" name="status" id="status" value="">
	<input class="form-filter" name="page" id="page" value="1">
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
					<h1>All Job Types
						<small>create & edit job types
							<div class="btn btn-group margin0">
								<button class="btn btn-xs purple-color tooltips" title="Total Record">
									Total Record: <span id="total_records">0</span>
								</button>
								<button class="btn btn-xs blue-madison tooltips" title="ASC"
								        onclick="Page=1;$('#page').val('1');$('#order').val('ASC');$('#status').val('');load_data();Block();">
									ASC <i class="fa fa-sort-numeric-asc"></i></button>
								<button class="btn btn-xs blue-madison tooltips" title="DESC"
								        onclick="Page=1;$('#page').val('1');$('#order').val('DESC');$('#status').val('');load_data();Block();">
									DESC <i class="fa fa-sort-numeric-desc"></i></button>
								<button class="btn btn-xs green-haze tooltips" title="Active"
								        onclick="Page=1;$('#page').val('1');$('#status').val('1');load_data();Block();">
									Active
								</button>
								<button class="btn btn-xs red-sunglo tooltips" title="Deactive"
								        onclick="Page=1;$('#page').val('1');$('#status').val('0');load_data();Block();">
									Deactive
								</button>
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
						<div class="portlet-body">
							<table class="table new_table table_alter">
								<tr>
									<th colspan="7">
										<div class="input-group margin0 w100">
											<input placeholder="🔎 Search Job Name." class="form-control form-filter"
											       name="search" id="filter_search" type="search">
											<span class="input-group-btn">
												<button class="btn blue tooltips add" type="button"
												        title="Add"><i class="fa fa-plus"></i> Add Job Type</button>
												<button class="btn red tooltips reset_search" type="button"
												        title="Clear"><i class="fa fa-times"></i> Clear</button>
											</span>
										</div>
									</th>
								</tr>

								<tr class="heading2">
									<th>Name
										<div class="btn btn-group margin0">
											<button class="btn btn-xs blue-madison tooltips" title="ASC"
											        onclick="Page=1;$('#page').val('1');$('#order').val('ASC');$('#orderby').val('name');$('#status').val('');load_data();Block();">
												<i class="fa fa-sort-numeric-asc"></i></button>
											<button class="btn btn-xs blue-madison tooltips" title="DESC"
											        onclick="Page=1;$('#page').val('1');$('#order').val('DESC');$('#orderby').val('name');$('#status').val('');load_data();Block();">
												<i class="fa fa-sort-numeric-desc"></i></button>
										</div>
									</th>
									<th>Description</th>
									<th>Price A
										<div class="btn btn-group margin0">
											<button class="btn btn-xs blue-madison tooltips" title="ASC"
											        onclick="Page=1;$('#page').val('1');$('#order').val('ASC');$('#orderby').val('price_a');$('#status').val('');load_data();Block();">
												<i class="fa fa-sort-numeric-asc"></i></button>
											<button class="btn btn-xs blue-madison tooltips" title="DESC"
											        onclick="Page=1;$('#page').val('1');$('#order').val('DESC');$('#orderby').val('price_a');$('#status').val('');load_data();Block();">
												<i class="fa fa-sort-numeric-desc"></i></button>
										</div>
									</th>
									<th>Price B
										<div class="btn btn-group margin0">
											<button class="btn btn-xs blue-madison tooltips" title="ASC"
											        onclick="Page=1;$('#page').val('1');$('#order').val('ASC');$('#orderby').val('price_a');$('#status').val('');load_data();Block();">
												<i class="fa fa-sort-numeric-asc"></i></button>
											<button class="btn btn-xs blue-madison tooltips" title="DESC"
											        onclick="Page=1;$('#page').val('1');$('#order').val('DESC');$('#orderby').val('price_a');$('#status').val('');load_data();Block();">
												<i class="fa fa-sort-numeric-desc"></i></button>
										</div>
									</th>
									<th>Discount</th>
									<th>Status</th>
									<th><i class="fa fa-gear"></i></th>
								</tr>
								<tbody id="tbody">
								<tr id='temp_row'>
									<td class='center' colspan="7"><i class='fa fa-spin fa-spinner'></i> Loading ....
									</td>
								</tr>
								</tbody>
							</table>
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

<div class="modal fade" id="add_job_type" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
	<div class="modal-dialog modal-full">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
				        aria-hidden="true"></button>
				<h4 class="modal-title">Add Job Type</h4>
			</div>

			<form id="form1" class="validate" action="<?php echo DOMAIN_URL ?>jobtype/save" method="post"
			      enctype="multipart/form-data">
				<div class="hidden">
					<input class="hidden" type="text" name="id" value="0">
					<input class="hidden" type="reset" id="btn_reset" value="reset">
				</div>
				<div class="modal-body">
					<div class="form-body">
						<table class="table new_table2 table_alter">
							<tr>
								<td class="center">
									<label class="control-label bold">Name <span class="required">*</span></label>
									<input class="form-control" type="text" placeholder="Name" name="name"
									       required="required" title="Name field is required."/>
								</td>
								<td class="center">
									<label class="control-label bold">Price A <span class="required">*</span></label>
									<input class="form-control" type="number" onkeypress="return isNumber(event)"
									       placeholder="Price A" name="price_a" required="required"
									       title="Price A field is required."/>
								</td>
								<td class="center">
									<label class="control-label bold">Price B<span class="required">*</span></label>
									<input class="form-control" type="number" onkeypress="return isNumber(event)"
									       placeholder="Price B" name="price_b" required="required"
									       title="Price B field is required."/>
								</td>
								<td class="center">
									<label class="control-label bold">Discount(%)</label>
									<input type="number" name="discount" class="form-control"
									       onkeypress="return isNumber(event)"
									       placeholder="Discount (%)" value="0">
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<textarea class="form-control" name="description" cols="5"
									          placeholder="Description"></textarea>
								</td>
								<td colspan="2">
									<div class="btn btn-group">
										<label class="mb0 pointer" title="This is input field.">
											<input type="checkbox" name="print_name" value="Y"> Name
										</label>
										<label class="mb0 pointer" title="This is input field.">
											<input type="checkbox" name="position" value="Y"> Position
										</label>
									</div>
								</td>
							</tr>
						</table>
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
General::insert_js_file( 'jobtype' );
?>
<!-- END BODY -->
</html>