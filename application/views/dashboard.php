<?php
$title = 'Dashboard';
require_once( __DIR__ . '/header.php' ); ?>
<style type="text/css">
	.dashboard-stat2 .display .number {
		float: left;
		display: inline-block;
		padding-right: 15px;
	}

	.font-green-sharp {
		font-size: 24px !important;
	}
</style>
<body class="page-header-fixed page-sidebar-closed-hide-logo page-sidebar-closed-hide-logo">
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
					<h1>Dashboard
						<small>statistics & reports</small>
					</h1>
				</div>
				<!-- END PAGE TITLE -->
				<!-- END PAGE TOOLBAR -->
			</div>
			<!-- END PAGE HEAD -->
			<!-- BEGIN PAGE BREADCRUMB -->
			<ul class="page-breadcrumb breadcrumb hide">
				<li>
					<a href="#">Home</a><i class="fa fa-circle"></i>
				</li>
				<li class="active">
					Dashboard
				</li>
			</ul>
			<!-- END PAGE BREADCRUMB -->
			<div class="row">
				<div class="col-md-8">
					<div class="portlet light">
						<div id="chartContainer" style="height: 450px; width: 100%;">
							<h2>No record Found This Month</h2>
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs"></i>Statistic
							</div>
						</div>
						<div class="portlet-body">
							<h3 class="block">Sale of this month</h3>
							<table class="table table-bordered table-striped">
								<thead>
								<tr>
									<th>
										Price
									</th>
									<th>
										Adjustment
									</th>
									<th>
										Total Price
									</th>
								</tr>
								</thead>
								<tbody>
								<tr>
									<td>
										<span class="label label-primary" id="price">&pound;0.00</span>
									</td>
									<td>
										<span class="label label-primary" id="charges">&pound;0.00</span>
									</td>
									<td>
										<span class="label label-primary" id="total">&pound;0.00</span>
									</td>
								</tr>
								</tbody>
							</table>
							<h3 class="block">Total Job of this month</h3>
							<table class="table table-bordered table-striped">
								<thead>
								<tr>
									<th>
										Pending
									</th>
									<th>
										Completed
									</th>
								</tr>
								</thead>
								<tbody>
								<tr>
									<td>
										<span class="label label-danger" id="pending">0</span>
									</td>
									<td>
										<span class="label label-success" id="completed">0</span>
									</td>
								</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php include_once( __DIR__ . '/footer.php' ); ?>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script type="text/javascript">
	load_data();

	function load_data() {
		let m = moment().month();
		let y = moment().format( 'YYYY' );
		let startDate = moment( [y, m] );
		let endDate = moment( startDate ).endOf( 'month' );
		let start = startDate.toDate();
		let end = endDate.toDate();
		start = moment( start ).format( 'LLL' );
		end = moment( end ).format( 'LLL' );
		Block();
		$.ajax( {
			url: DOMAIN_URL + 'jobs/generate_monthly_report',
			method: 'post',
			data: {
				page: 1,
				time_to: end,
				time_from: start,
				pagesize: 999999,
			},
			success: function( data ) {
				UnBlock();
				let array = [];
				let price = 0;
				let expense = 0;
				let total = 0;
				let completed = 0;
				$( data.rows ).each( function( k, v ) {
					array.push( { y: v.count, name: get_username( v.client_id ) } );
					let data = v.data;
					completed += parseFloat( v.count );
					if ( isset( data ) && !empty( data ) ) {
						for ( var i = 0; i < count( data ); i++ ) {
							price += parseFloat( data[ i ].price );
							expense += parseFloat( data[ i ].expense );
							total += parseFloat( data[ i ].total );
						}
					}
				} );
				$( '#price' ).html( '£' + number_format( price, 2 ) );
				$( '#charges' ).html( '£' + number_format( expense, 2 ) );
				$( '#total' ).html( '£' + number_format( total, 2 ) );
				$( '#completed' ).html( completed );
				$( '#pending' ).html( data.pending );
				load_chart( array );
			}
		} );
	}

	function load_chart( object ) {
		let month = moment().month();
		month = moment().month( month ).format( "MMMM" );
		var chart = new CanvasJS.Chart( "chartContainer", {
			exportEnabled: true,
			animationEnabled: true,
			title: {
				text: "Graph Charts of " + month + ""
			},
			legend: {
				cursor: "pointer",
				itemclick: explodePie
			},
			data: [
				{
					type: "pie",
					showInLegend: true,
					toolTipContent: "{name}: <strong>{y}</strong>",
					indexLabel: "{name} ({y})",
					dataPoints: object
				}
			]
		} );
		chart.render();
	}

	function explodePie( e ) {
		if ( typeof (e.dataSeries.dataPoints[ e.dataPointIndex ].exploded) === "undefined" || !e.dataSeries.dataPoints[ e.dataPointIndex ].exploded ) {
			e.dataSeries.dataPoints[ e.dataPointIndex ].exploded = true;
		} else {
			e.dataSeries.dataPoints[ e.dataPointIndex ].exploded = false;
		}
		e.chart.render();
	}
</script>
</body>
</html>