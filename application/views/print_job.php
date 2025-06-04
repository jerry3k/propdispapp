<?php
if ( empty( $rows ) ) {
	echo 'No record found.';
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<!-- BEGIN HEAD -->
<head>
	<meta charset="utf-8"/>
	<title>Print | Job | Invoice</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport"/>
	<meta content="<?php $rows['jobcode']; ?>" name="description"/>
	<meta content="" name="author"/>
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
	      type="text/css"/>
	<link href="<?php echo $DOMAIN_URL; ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"
	      type="text/css"/>
	<link href="<?php echo $DOMAIN_URL; ?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css"
	      rel="stylesheet"
	      type="text/css"/>
	<link href="<?php echo $DOMAIN_URL; ?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"
	      type="text/css"/>
	<link href="<?php echo $DOMAIN_URL; ?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"
	      rel="stylesheet"
	      type="text/css"/>
	<link href="<?php echo $DOMAIN_URL; ?>assets/global/css/components.min.css" rel="stylesheet" id="style_components"
	      type="text/css"/>
	<link href="<?php echo $DOMAIN_URL; ?>assets/global/css/plugins.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo $DOMAIN_URL; ?>assets/css/invoice.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo $DOMAIN_URL; ?>assets/layouts/layout4/css/layout.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo $DOMAIN_URL; ?>assets/layouts/layout4/css/themes/default.min.css" rel="stylesheet"
	      type="text/css"
	      id="style_color"/>
	<link href="<?php echo $DOMAIN_URL; ?>assets/layouts/layout4/css/custom.min.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<!-- BEGIN CONTAINER -->
<div class="page-container">
	<div class="invoice">
		<div class="row invoice-lcogo">
			<div class="col-xs-6 invoice-logo-space">
				<img style="width: 100px;" src="<?php echo $DOMAIN_URL; ?>assets/images/logo.png" class="img-responsive"
				     alt=""/></div>
			<div class="col-xs-6">
				<p> #<?php echo $rows['jobcode']; ?> / <?php echo MyDateTime::mysql_date( $rows['job_date'] ); ?>
<!--					<span class="muted"> Consectetuer adipiscing elit </span>-->
				</p>
			</div>
		</div>
		<hr/>
		<div class="row">
			<div class="col-xs-4">
				<h3>Client:</h3>
				<ul class="list-unstyled">
					<li> John Doe</li>
					<li> Mr Nilson Otto</li>
					<li> FoodMaster Ltd</li>
					<li> Madrid</li>
					<li> Spain</li>
					<li> 1982 OOP</li>
				</ul>
			</div>
			<div class="col-xs-4">
				<h3>About:</h3>
				<ul class="list-unstyled">
					<li> Drem psum dolor sit amet</li>
					<li> Laoreet dolore magna</li>
					<li> Consectetuer adipiscing elit</li>
					<li> Magna aliquam tincidunt erat volutpat</li>
					<li> Olor sit amet adipiscing eli</li>
					<li> Laoreet dolore magna</li>
				</ul>
			</div>
			<div class="col-xs-4 invoice-payment">
				<h3>Payment Details:</h3>
				<ul class="list-unstyled">
					<li>
						<strong>V.A.T Reg #:</strong> 542554(DEMO)78
					</li>
					<li>
						<strong>Account Name:</strong> FoodMaster Ltd
					</li>
					<li>
						<strong>SWIFT code:</strong> 45454DEMO545DEMO
					</li>
					<li>
						<strong>Account Name:</strong> FoodMaster Ltd
					</li>
					<li>
						<strong>SWIFT code:</strong> 45454DEMO545DEMO
					</li>
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<table class="table table-striped table-hover">
					<thead>
					<tr>
						<th> #</th>
						<th> Item</th>
						<th class="hidden-xs"> Description</th>
						<th class="hidden-xs"> Quantity</th>
						<th class="hidden-xs"> Unit Cost</th>
						<th> Total</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td> 1</td>
						<td> Hardware</td>
						<td class="hidden-xs"> Server hardware purchase</td>
						<td class="hidden-xs"> 32</td>
						<td class="hidden-xs"> $75</td>
						<td> $2152</td>
					</tr>
					<tr>
						<td> 2</td>
						<td> Furniture</td>
						<td class="hidden-xs"> Office furniture purchase</td>
						<td class="hidden-xs"> 15</td>
						<td class="hidden-xs"> $169</td>
						<td> $4169</td>
					</tr>
					<tr>
						<td> 3</td>
						<td> Foods</td>
						<td class="hidden-xs"> Company Anual Dinner Catering</td>
						<td class="hidden-xs"> 69</td>
						<td class="hidden-xs"> $49</td>
						<td> $1260</td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-4">
				<div class="well">
					<address>
						<strong>Loop, Inc.</strong>
						<br/> 795 Park Ave, Suite 120
						<br/> San Francisco, CA 94107
						<br/>
						<abbr title="Phone">P:</abbr> (234) 145-1810
					</address>
					<address>
						<strong>Full Name</strong>
						<br/>
						<a href="mailto:#"> first.last@email.com </a>
					</address>
				</div>
			</div>
			<div class="col-xs-8 invoice-block">
				<ul class="list-unstyled amounts">
					<li>
						<strong>Sub - Total amount:</strong> $9265
					</li>
					<li>
						<strong>Discount:</strong> 12.9%
					</li>
					<li>
						<strong>VAT:</strong> -----
					</li>
					<li>
						<strong>Grand Total:</strong> $12489
					</li>
				</ul>
				<br/>
				<a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();">
					Print
					<i class="fa fa-print"></i>
				</a>
				<a class="btn btn-lg green hidden-print margin-bottom-5"> Submit Your Invoice
					<i class="fa fa-check"></i>
				</a>
			</div>
		</div>
	</div>
</div>
</body>
</html>