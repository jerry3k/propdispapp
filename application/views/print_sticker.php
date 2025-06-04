<?php
if ( isset( $rows ) && empty( $rows ) ) {
	echo '<center><h2>No record found on "Sticker".</h2></center>';
	exit();
}
?>
<html>
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport"/>
	<style type="text/css">
		.print_btn_div {
			width: 100%;
			text-align: center;
			padding-top: 10px;
			padding-bottom: 10px;
		}

		.print_btn_div button {
			background: mediumpurple;
			border: 1px solid mediumpurple;
			border-radius: 5px;
			padding: 5px;
			color: #fff;
		}
	</style>
</head>

<body>

<div class="print_btn_div">
	<button type="button" onclick="printJS('table_print_sticker', 'html')">
		<i class="fa fa-print"></i> Print Sticker
	</button>
</div>

<table id="table_print_sticker" class="table new_table2 table_alter mb0" cellspacing="2" cellpadding="2" border="1">
	<tr>
		<th>JobCode</th>
		<th>Job Type</th>
		<th>Sticker</th>
		<th>Address</th>
		<th>PostCode</th>
	</tr>
	<?php foreach ( $rows as $row ) { ?>
		<tr>
			<td><?php echo $row['jobcode'] . '_' . $row['sort']; ?></td>
			<td><?php echo Users::get_jobname( $row['job_type'] ); ?></td>
			<td><?php echo $row['print_name']; ?></td>
			<td><?php echo $row['address1']; ?></td>
			<td><?php echo $row['postcode']; ?></td>
		</tr>
	<?php } ?>
</table>

</body>
</html>