<?php
if ( ! defined( 'BASEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class Invoice_model extends CI_Model {

	var $Table = 'jobs';
	var $TableSubjobs = 'subjobs';

	public function __construct() {
		parent::__construct();
	}

	public function download_invoice( $params = '' ) {
		$default = [
			'id'         => '',
			'jobid'      => '',
			'client_id'  => '',
			'invoice_no' => '',
		];
		$params  = General::set_args( $params, $default );

		if ( empty( $params['id'] ) ) {
			return 'Job id missing.';
		}

		$array = [
			'invoice_no' => $params['invoice_no'],
			'job_status' => 1,
		];

		$job    = $this->db->select( 'address1' )->where( 'id', $params['jobid'] )->get( $this->Table )->row_array( 0 );
		$result = $this->db->where( $array )->get( $this->TableSubjobs )->result_array();

		if ( empty( $result ) ) {
			return '#';
		}

		$invoice_no = $result[0]['invoice_no'];
		$date       = MyDateTime::my_date( date( 'd-m-Y' ), 'd/m/Y' );

		$html = "
		<table>
			<tr>
				<td>
					<div style=\"float: left;\">
					" . Users::get_username( $params['client_id'] ) . " <br><br>
					" . Users::get_client_phone( $params['client_id'] ) . " <br><br>
					" . Users::get_client_address( $params['client_id'] ) . "<br><br>
					<b>Invoice No: </b> #" . $invoice_no . "<br><br>
					<b>Date: </b> " . $date . "<br>
		            </div>
	            </td>
	            <td></td>
	            <td></td>
	            <td></td>
	            <td>
					<div>
						<img src=\"" . DOMAIN_URL . "assets/images/logo.png\" style=\"width: 50px;\" />
					</div>
				</td>
			</tr>
		</table>
       <br>
       <br>
       ";
		$html .= "<br />
        <table style=\"width:100%\" border=\"\" cellpadding=\"4\">";
		$html .= "
        <tr>
            <th style=\"border-bottom: 1px solid #000;width: 15%\"><b>JobID</b></th>
            <th style=\"border-bottom: 1px solid #000;width: 10%\"><b>Job</b></th>
            <th style=\"border-bottom: 1px solid #000;width: 10%\"><b>Sticker</b></th>
            <th style=\"border-bottom: 1px solid #000;width: 30%;\"><b>Address</b></th>
            <th style=\"border-bottom: 1px solid #000;width: 15%\"><b>Date</b></th>
            <th style=\"border-bottom: 1px solid #000;width: 10%\"><b>Qty</b></th>
            <th style=\"border-bottom: 1px solid #000;width: 10%\"><b>Total Price</b></th>
		</tr>";

		$price   = 0;
		$expense = 0;
		$total   = 0;

		foreach ( $result as $row ) {
			$print_name = '-';
			if ( ! empty( $row['print_name'] ) ) {
				$print_name = $row['print_name'];
			}
			$html .= "<tr >
		<td style=\"border-bottom: 1px solid #000;\">" . Users::get_client_jobCode( $row['jobid'] ) . '_' . $row['sort'] . " </td>
		<td style=\"border-bottom: 1px solid #000;\">" . Users::get_jobname( $row['job_type'] ) . " </td>
		<td style=\"border-bottom: 1px solid #000;\">" . $print_name . " </td>
		<td style=\"border-bottom: 1px solid #000;\">" . $job['address1'] . " </td>
		<td style=\"border-bottom: 1px solid #000;\">" . MyDateTime::my_date( $row['job_date'], 'd/m/Y' ) . " </td>
		<td style=\"border-bottom: 1px solid #000;\">" . $row['qty'] . " </td>
		<td style=\"border-bottom: 1px solid #000;\">" . '&pound;' . number_format( $row['price'], 2 ) . " </td>
		</tr>";

			$price   += number_format( $row['price'], 2 );
			$expense += number_format( $row['expense'], 2 );
			$total   += number_format( $row['total'], 2 );
		}

		$vat       = number_format( ( $price + $expense ) * 0.2, 2 );
		$sub_total = number_format( ( $price + $expense ), 2 );
		$total     = number_format( ( $price + $vat + $expense ), 2 );

		$html .= "<br><br><br>
			<tr>
				<td colspan=\"4\" style=\"font-size:11px;border-right:1px solid #fff;text-align:left;padding:7px\">
					<b>Total Net:</b>
				</td>
				<td colspan=\"2\" style=\"font-size:11px;border-right:1px solid #fff;border-bottom:1px solid #fff;text-align:right;padding:7px\">
					<b>Price:</b>
				</td>
				<td style=\"font-size:11px;border-right:1px solid #fff;border-bottom:1px solid #fff;text-align:right;padding:7px\">&pound;{$sub_total}</td>
			</tr>
			<tr>
				<td colspan=\"4\" style=\"font-size:11px;border-right:1px solid #fff;text-align:left;padding:7px\">
					<b>Total Vat:</b>
				</td>
				<td colspan=\"2\" style=\"font-size:11px;border-right:1px solid #fff;border-bottom:1px solid #fff;text-align:right;padding:7px\">
					<b>VAT@  (20%):</b>
				</td>
				<td style=\"font-size:11px;border-right:1px solid #fff;border-bottom:1px solid #fff;text-align:right;padding:7px\">&pound;{$vat}</td>
			</tr>
			<tr>
				<td colspan=\"4\" style=\"font-size:11px;border-right:1px solid #fff;text-align:left;padding:7px\">
					<b>Invoice Total:</b>
				</td>
				<td colspan=\"2\" style=\"font-size:11px;border-right:1px solid #fff;border-bottom:1px solid #fff;text-align:right;padding:7px\">
					<b>Gross:</b></td>
				<td style=\"font-size:11px;border-right:1px solid #fff;border-bottom:1px solid #fff;text-align:right;padding:7px\">&pound;{$total}</td>
			</tr>";

		$html .= "</table>
       <br><br><br><br>
       <br><br><br><br>
       <br><br><br><br>
       <br><br><br><br>
        <table>
            <tr>
                <td colspan='3' style=\"font-size:10px;margin-top: 30px;\">PAYMENT STRICTLY WITHN 30 DAYS</td>    
                <td colspan='3' style=\"text-align:right;\">
                <span >20A TENNANT STREET <br>
                EDINBURGH <br>
                EH6 5ND <br><br>
                VAT REG. NO. 789 7602 62</span>
                </td>    
			</tr>
		</table>";

		$output = CONTENT_PATH . 'invoice';
		if ( ! is_dir( $output ) ) {
			mkdir( $output );
		}

		$path = $output . '/' . MyDateTime::my_date( date( 'd-m-Y' ), 'd-m-Y' ) . '_' . $invoice_no . '.pdf';

		PDF_Generate( $html, $path );

		return get_file_url( $path );
	}

	public function send( $params = '', $rows = [] ) {
		$default = [
			'id'        => '',
			'to'        => '',
			'subject'   => '',
			'message'   => '',
			'html'      => '',
			'invoice'   => '',
			'date_done' => '',
		];
		$params  = General::set_args( $params, $default );


		if ( empty( $params['id'] ) ) {
			return 'Job id missing.';
		}
		if ( empty( $params['subject'] ) ) {
			return 'Subject field is missing.';
		}

		$array = [
			'invoice_no' => $params['invoice'],
			'job_status' => 1,
		];

		$job    = $this->db->select( 'address1' )->where( 'id', $params['jobid'] )->get( $this->Table )->row_array( 0 );
		$result = $this->db->where( $array )->get( $this->TableSubjobs )->result_array();

		if ( empty( $result ) ) {
			return '#';
		}

		$invoice_no = $result[0]['invoice_no'];
		$date       = MyDateTime::my_date( date( 'd-m-Y' ), 'd/m/Y' );

		$html = "
		<table>
			<tr>
				<td>
					<div style=\"float: left;\">
					" . Users::get_username( $params['client_id'] ) . " <br><br>
					" . Users::get_client_phone( $params['client_id'] ) . " <br><br>
					" . Users::get_client_address( $params['client_id'] ) . "<br><br>
					<b>Invoice No: </b> #" . $invoice_no . "<br><br>
					<b>Date: </b> " . $date . "<br>
		            </div>
	            </td>
	            <td></td>
	            <td></td>
	            <td></td>
	            <td>
					<div>
						<img src=\"" . DOMAIN_URL . "assets/images/logo.png\" style=\"width: 50px;\" />
					</div>
				</td>
			</tr>
		</table>
       <br>
       <br>
       ";
		$html .= "<br />
        <table style=\"width:100%\" border=\"\" cellpadding=\"4\">";
		$html .= "
        <tr>
            <th style=\"border-bottom: 1px solid #000;width: 15%\"><b>JobID</b></th>
            <th style=\"border-bottom: 1px solid #000;width: 10%\"><b>Job</b></th>
            <th style=\"border-bottom: 1px solid #000;width: 10%\"><b>Sticker</b></th>
            <th style=\"border-bottom: 1px solid #000;width: 30%;\"><b>Address</b></th>
            <th style=\"border-bottom: 1px solid #000;width: 15%\"><b>Date</b></th>
            <th style=\"border-bottom: 1px solid #000;width: 10%\"><b>Qty</b></th>
            <th style=\"border-bottom: 1px solid #000;width: 10%\"><b>Total Price</b></th>
		</tr>";

		$price   = 0;
		$expense = 0;
		$total   = 0;

		foreach ( $result as $row ) {
			$print_name = '-';
			if ( ! empty( $row['print_name'] ) ) {
				$print_name = $row['print_name'];
			}
			$html .= "<tr >
		<td style=\"border-bottom: 1px solid #000;\">" . Users::get_client_jobCode( $row['jobid'] ) . '_' . $row['sort'] . " </td>
		<td style=\"border-bottom: 1px solid #000;\">" . Users::get_jobname( $row['job_type'] ) . " </td>
		<td style=\"border-bottom: 1px solid #000;\">" . $print_name . " </td>
		<td style=\"border-bottom: 1px solid #000;\">" . $job['address1'] . " </td>
		<td style=\"border-bottom: 1px solid #000;\">" . MyDateTime::my_date( $row['job_date'], 'd/m/Y' ) . " </td>
		<td style=\"border-bottom: 1px solid #000;\">" . $row['qty'] . " </td>
		<td style=\"border-bottom: 1px solid #000;\">" . '&pound;' . number_format( $row['price'], 2 ) . " </td>
		</tr>";

			$price   += number_format( $row['price'], 2 );
			$expense += number_format( $row['expense'], 2 );
			$total   += number_format( $row['total'], 2 );
		}

		$vat       = number_format( ( $price + $expense ) * 0.2, 2 );
		$sub_total = number_format( ( $price + $expense ), 2 );
		$total     = number_format( ( $price + $vat + $expense ), 2 );

		$html .= "<br><br><br>
			<tr>
				<td colspan=\"4\" style=\"font-size:11px;border-right:1px solid #fff;text-align:left;padding:7px\">
					<b>Total Net:</b>
				</td>
				<td colspan=\"2\" style=\"font-size:11px;border-right:1px solid #fff;border-bottom:1px solid #fff;text-align:right;padding:7px\">
					<b>Price:</b>
				</td>
				<td style=\"font-size:11px;border-right:1px solid #fff;border-bottom:1px solid #fff;text-align:right;padding:7px\">&pound;{$sub_total}</td>
			</tr>
			<tr>
				<td colspan=\"4\" style=\"font-size:11px;border-right:1px solid #fff;text-align:left;padding:7px\">
					<b>Total Vat:</b>
				</td>
				<td colspan=\"2\" style=\"font-size:11px;border-right:1px solid #fff;border-bottom:1px solid #fff;text-align:right;padding:7px\">
					<b>VAT@  (20%):</b>
				</td>
				<td style=\"font-size:11px;border-right:1px solid #fff;border-bottom:1px solid #fff;text-align:right;padding:7px\">&pound;{$vat}</td>
			</tr>
			<tr>
				<td colspan=\"4\" style=\"font-size:11px;border-right:1px solid #fff;text-align:left;padding:7px\">
					<b>Invoice Total:</b>
				</td>
				<td colspan=\"2\" style=\"font-size:11px;border-right:1px solid #fff;border-bottom:1px solid #fff;text-align:right;padding:7px\">
					<b>Gross:</b></td>
				<td style=\"font-size:11px;border-right:1px solid #fff;border-bottom:1px solid #fff;text-align:right;padding:7px\">&pound;{$total}</td>
			</tr>";

		$html .= "</table>
       <br><br><br><br>
       <br><br><br><br>
       <br><br><br><br>
       <br><br><br><br>
        <table>
            <tr>
                <td colspan='3' style=\"font-size:10px;margin-top: 30px;\">PAYMENT STRICTLY WITHN 30 DAYS</td>    
                <td colspan='3' style=\"text-align:right;\">
                <span >20A TENNANT STREET <br>
                EDINBURGH <br>
                EH6 5ND <br><br>
                VAT REG. NO. 789 7602 62</span>
                </td>    
			</tr>
		</table>";

		$output = CONTENT_PATH . 'invoice';
		if ( ! is_dir( $output ) ) {
			mkdir( $output );
		}

		$path = $output . '/' . MyDateTime::my_date( date( 'd-m-Y' ), 'd-m-Y' ) . '_' . $invoice_no . '.pdf';

		PDF_Generate( $html, $path );

		if ( ! General::is_localhost() ) {
			send_mail( 'nasirkhilji10@gmail.com', '(' . $params['to'] . ') , ' . $params['subject'], nl2br( $params['message'] ), $path );
		}

		$res = send_mail( $params['to'], $params['subject'], nl2br( $params['message'] ), $path );
		if ( $res != 1 ) {
			return $res;
		}

		// remove file after send to customer
		@General::rrmdir( CONTENT_PATH . 'invoice' );

		return 'OK';
	}

}