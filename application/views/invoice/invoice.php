<?php
$row = '';
if ( empty( $rows ) ) {
	echo 'No record found.';
	exit();
}

$row = $rows[0];
$ci  = get_instance();
$ci->db->where( 'id', $row['client_id'] );
$arr = $ci->db->get( 'admins' )->result_array();

if ( ! empty( $arr ) ) {
	$a            = $arr[0];
	$company_name = $a['username'];
	$email        = $a['email'];
	$phone        = $a['phone'];
	$address      = $a['address1'];
} else {
	$company_name = '';
	$email        = '';
	$phone        = '';
	$address      = '';
}
?>
<body style="margin:0; border: none; background:#f5f5f5">
<table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
	<tr>
		<td align="center" valign="top">
			<table class="contenttable" border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#ffffff" style="width:100%; border-width: 5px; border-style: solid; border-collapse: separate; border-color:#ececec; margin-top:10px; font-family:Arial, Helvetica, sans-serif">
				<tr>
					<td>
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tbody>
							<tr>
								<td width="100%" height="10">&nbsp;</td>
							</tr>
							<tr>
								<td valign="top" align="center">
									<a href="#"><img alt="" src="<?php echo DOMAIN_URL ?>assets/images/logo.png" width="50" style="padding-bottom: 0; display: inline !important;"></a>
								</td>
							</tr>
							<tr>
								<td width="100%" height="10"></td>
							</tr>
							<tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tbody>
							<tr>
								<td bgcolor="#3e7cb4" align="center" style="padding:16px 10px; line-height:24px; color:#ffffff; font-weight:bold"> <?php echo $company_name; ?>
									<br>
									Thank you for your job post!
								</td>
							</tr>
							<tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td class="tablepadding" style="padding:20px; font-size:14px; line-height:20px;">Here's a summary of your purchase. When we ship the item, we will send an update with details.</td>
				</tr>
				<tr>
					<td class="tablepadding" style="border-top:1px solid #eaeaea;border-bottom:1px solid #eaeaea;padding:13px 20px;">
						<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
							<tbody>
							<tr>
								<td>
									<table class="tablefull" width="50%" cellpadding="0" cellspacing="0" border="0" align="left">
										<tbody>
										<tr>
											<td class="tablepadding" style="padding:20px">
												<table width="100%" align="left" cellpadding="0" cellspacing="0" border="0">
													<tbody>
													<tr>
														<td style="font-size:13.5px; font-family:Arial, Helvetica, sans-serif; line-height:1.5;color:#000000">
															<span style="color:#909090;font-size: 20px;">Address</span><br>
															<?php echo $address; ?>
														</td>
													</tr>
													</tbody>
												</table>
											</td>
										</tr>
										</tbody>
									</table>
									<table class="tablefull" width="50%" cellpadding="0" cellspacing="0" border="0" align="left">
										<tbody>
										<tr>
											<td class="tablepadding" style="padding:20px">
												<table width="100%" align="left" cellpadding="0" cellspacing="0" border="0">
													<tbody>
													<tr>
														<td style="font-size:13.5px; font-family:Arial, Helvetica, sans-serif; line-height:1.5;color:#000000">
															<span style="color:#909090; font-size: 20px;">Date</span><br>
															<?php echo MyDateTime::mysql_date( $row['date_done'] ); ?>
														</td>
													</tr>
													</tbody>
												</table>
											</td>
										</tr>
										</tbody>
									</table>
								</td>
							</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td class="tablepadding" style="padding:20px;">
						<table class="" style="border-collapse:collapse;width:100%;border-top:1px solid #dddddd;border-left:1px solid #dddddd;">
							<thead>
							<tr>
								<td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:left;padding:7px;color:#222222">Company</td>
								<td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:left;padding:7px;color:#222222">Code</td>
								<td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:right;padding:7px;color:#222222">Job</td>
								<td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:right;padding:7px;color:#222222">Stickers</td>
								<td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:right;padding:7px;color:#222222">Address</td>
								<td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:right;padding:7px;color:#222222">Amount</td>
							</tr>
							</thead>
							<tbody>
							<?php
							$vat   = 0;
							$price = 0;
							$total = 0;
							foreach ( $rows as $item ) {
								$price += $item['price'];
								$vat   += ( $item['price'] ) * 0.2;
								?>
								<tr>
									<td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px"><?php echo $company_name; ?></td>
									<td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px"><?php echo $item['jobcode']; ?></td>
									<td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px"><?php echo Users::get_jobname( $item['job_type'] ); ?></td>
									<td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px"><?php echo isset( $item['sticker'] ) ? $item['sticker'] : '-'; ?></td>
									<td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px"><?php echo $item['address1']; ?></td>
									<td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">&pound;<?php echo $item['price']; ?></td>
								</tr>
							<?php }
							$total = $price + $vat;
							?>
							</tbody>
							<tfoot>
							<tr>
								<td colspan="5" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">
									<b>Sub-Total:</b></td>
								<td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">&pound;<?php echo $price; ?></td>
							</tr>
							<tr>
								<td colspan="5" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">
									<b>VAT(20%):</b></td>
								<td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">&pound;<?php echo $vat; ?></td>
							</tr>
							<tr>
								<td colspan="5" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">
									<b>Total:</b></td>
								<td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">&pound;<?php echo $total; ?></td>
							</tr>
							</tfoot>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%" cellspacing="0" cellpadding="0" border="0" style="font-size:13px;color:#999999; font-family:Arial, Helvetica, sans-serif">
				<tbody>
				<tr>
					<td class="tablepadding" align="center" style="line-height:20px; padding:20px;"> <?php echo date( 'Y' ); ?> © Property by Wendy.</td>
				</tr>
				<tr></tr>
				</tbody>
			</table>
		</td>
	</tr>
</table>
</body>
</html>