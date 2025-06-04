<?php
$row = [];
if ( ! empty( $rows ) ) {
	$row = $rows[0];
}
if ( empty( $row ) ) {
	echo 'Empty Record not found.';
	exit();
}
?>
<html>
<head>
	<title>Job Report</title>
	<style>
		@page {
			size: auto;
			margin: 5mm;
		}
	</style>
</head>
<body>
<h3>
	<b>Job Information (<?php echo $row['jobcode']; ?>)</b>
</h3>
<div class="page-container">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="data">
					<b>UniqueID: </b><?php echo $row['jobcode']; ?>
				</div>
				<div class="data">
					<b>Job Date: </b><?php echo MyDateTime::mysql_date( $row['job_date'] ); ?>
				</div>
				<div class="data">
					<b>Client Name: </b><?php Users::get_username( $row['client_id'] ); ?>
				</div>
				<div class="data">
					<b>Customer Name: </b><?php echo $row['customer_name']; ?>
				</div>
				<div class="data">
					<b>Job Type: </b><?php echo Users::get_jobname( $row['job_type'] ); ?>
				</div>
			</div>
			<div class="col-md-12">
				<div class="data">
					<b>Address 1: </b><?php echo $row['address1']; ?>
				</div>
				<div class="data">
					<b>Street Address: </b><?php echo $row['address2']; ?>
				</div>
				<div class="data">
					<b>Route Address: </b><?php echo $row['address3']; ?>
				</div>
				<div class="data">
					<b>PostCode: </b> <?php echo $row['postcode']; ?>
				</div>
				<div class="data">
					<b>LatLng: </b> <?php echo $row['latitude']; ?> , <?php echo $row['longitude']; ?>
				</div>
				<div class="data">
					<b>Country/City: </b> <?php echo $row['country']; ?> / <?php echo $row['city']; ?>
				</div>
			</div>
			<div class="col-md-12">
				<div class="data">
					<b>Sticker: </b> <?php echo $row['sticker']; ?>
				</div>
				<div class="data">
					<b>Comment: </b><?php echo $row['comments']; ?>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>