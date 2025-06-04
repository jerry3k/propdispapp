<?php
if ( ! defined( 'BASEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class PayFitter_model extends CI_Model {

	var $Table = 'jobs';
	var $Table2 = 'invoice';

	public function __construct() {
		parent::__construct();
	}

	/**
	 * @param string $params
	 * Get staff data
	 *
	 * @return mixed
	 */
	public function get_invoice( $params = '' ) {
		$default = [
			'id'        => '',
			'orderby'   => 'id',
			'order'     => 'DESC',
			'search'    => '',
			'page'      => '1',
			'pagesize'  => '5',
			'client_id' => '',
			'time_from' => '',
			'time_to'   => '',
			'fitter_id' => '',
		];
		$params  = General::set_args( $params, $default );

//		General::show_array( $params );
//		die;

		if ( ! empty( $params['id'] ) ) {
			$this->db->where_in( 'id', General::make_array( $params['id'] ) );
		}
		if ( ! empty( $params['fitter_id'] ) ) {
			$this->db->where( 'fitter_id', $params['fitter_id'] );
		}
		if ( ! empty( $params['client_id'] ) ) {
			$this->db->where( 'client_id', $params['client_id'] );
		}
		if ( isset( $params['time_from'] ) && $params['time_from'] <> '' ) {
			$from = MyDateTime::mysql_date( $params['time_from'] );
			$to   = MyDateTime::mysql_date( $params['time_to'] );
			$this->db->where( "DATE(`invoice_date`) BETWEEN '$from' AND '$to'" );
		}
		if ( ! empty( $params['search'] ) ) {
			$search = $this->security->xss_clean( $params['search'] );
			if ( strtolower( substr( $search, 0, 3 ) ) == "id:" ) {
				$ids = General::make_array( substr( $search, 3 ) );
				$this->db->where_in( 'id', $ids );
			} else {
				$this->db->group_start();
				$this->db->like( 'invoice_no', $search );
				$this->db->or_like( 'invoice_date', $search );
				$this->db->group_end();
			}
		}

		$this->db->order_by( $params['orderby'], $params['order'] );

		// get page and pagesize
		$offset = ( $params['page'] * $params['pagesize'] );
		$limit  = ( $offset - $params['pagesize'] ) + 1;
		if ( isset( $limit ) && $limit <= 1 ) {
			$limit = 0;
		} else {
			$offset = $offset - 1; // page row display 1-10
			$limit  = $limit - 1; // start which number to load data
		}

		$query["rows"] = $this->db->get( $this->Table2, $params['pagesize'], $limit )->result_array();

		if ( ! empty( $query['rows'] ) ) {
			foreach ( $query['rows'] as $k => $row ) {
				$array                        = [
					'fitter_id' => $row['fitter_id'],
					'job_id'    => $row['job_type'],
				];
				$price                        = $this->db->select( 'price' )
				                                         ->where( $array )
				                                         ->get( 'fitterprice' )
				                                         ->row_array()['price'];
				$query['rows'][ $k ]['price'] = $price;
			}
		}

		if ( ! empty( $query ) ) {
			if ( ! empty( $params['id'] ) ) {
				$this->db->where_in( 'id', General::make_array( $params['id'] ) );
			}
			if ( ! empty( $params['fitter_id'] ) ) {
				$this->db->where( 'fitter_id', $params['fitter_id'] );
			}
			if ( ! empty( $params['client_id'] ) ) {
				$this->db->where( 'client_id', $params['client_id'] );
			}
			if ( isset( $params['time_from'] ) && $params['time_from'] <> '' ) {
				$from = MyDateTime::mysql_date( $params['time_from'] );
				$to   = MyDateTime::mysql_date( $params['time_to'] );
				$this->db->where( "DATE(`invoice_date`) BETWEEN '$from' AND '$to'" );
			}
			if ( ! empty( $params['search'] ) ) {
				$search = $this->security->xss_clean( $params['search'] );
				if ( strtolower( substr( $search, 0, 3 ) ) == "id:" ) {
					$ids = General::make_array( substr( $search, 3 ) );
					$this->db->where_in( 'id', $ids );
				} else {
					$this->db->group_start();
					$this->db->like( 'invoice_no', $search );
					$this->db->or_like( 'invoice_date', $search );
					$this->db->group_end();
				}
			}

			$total_records = $this->db->get( $this->Table2 )->num_rows();

			$pages = ceil( $total_records / $params['pagesize'] );
			if ( $pages == 0 ) {
				$pages = 1;
			}
			if ( empty( $query['rows'] ) ) {
				$total_records = 0;
			}
			$query["page"]          = $params['page'];
			$query["pages"]         = $pages;
			$query["pagesize"]      = $offset;
			$query["total_records"] = $total_records;
		} else {
			$query["page"]          = 1;
			$query["pages"]         = 1;
			$query["pagesize"]      = 10;
			$query["total_records"] = 0;
		}

		return $query;
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


		$html = "
		<table>
			<tr>
				<td>
					<div style=\"float: left;\">
					<b>Company: </b> " . Users::get_username( $params['client_id'] ) . " <br>
					<b>Phone: </b> " . Users::get_client_phone( $params['client_id'] ) . " <br>
					<b>Address: </b> " . Users::get_client_address( $params['client_id'] ) . "<br>
					<b>Date: </b> " . MyDateTime::mysql_datetime( $params['date_done'], 'M-Y' ) . "<br>
					<b>Invoice No: </b> #" . $params['invoice'] . "<br>
		            </div>
	            </td>
				<td style=\"float: right;\">
					<div style=\"margin-left: 200px;\">
						<img src=\"" . DOMAIN_URL . "assets/images/logo.png\" style=\"float:right;width: 50px;margin-left: 100px\" />
					</div>
				</td>
			</tr>
		</table>
        <h3>Here are the Detail</h3>";
		$html .= "<br />
        <table style=\"width:500px\" border=\"1\" cellpadding=\"5\">";
		$html .= "
         <tr>
            <th>Company</th>
            <th>Code</th>
            <th>Job</th>
            <th>Stickers</th>
            <th>Address</th>
            <th>Price + Expence</th>
		</tr>";

		$vat       = 0;
		$price     = 0;
		$total     = 0;
		$expense   = 0;
		$sub_total = 0;

		foreach ( $rows['rows'] as $item ) {
			$price   += $item['price'];
			$expense += $item['expense'];
			$vat     += $item['price'] * 0.2;

			$job_type       = Users::get_jobname( $item['job_type'] );
			$sticker        = isset( $item['sticker'] ) ? $item['sticker'] : '-';
			$plus_price_exp = $item['price'] + $item['expense'];

			$company_name = str_replace( '_', null, $item['jobcode'] );
			$company_name = preg_replace( '/\d+/', '', $company_name );
			$html         .= "<tr>
            <td>{$company_name}</td>
            <td>{$item['jobcode']}</td>
            <td>{$job_type}</td>
            <td>{$sticker}</td>
            <td>{$item['address1']}</td>
            <td>&pound;{$item['price']} + &pound;{$item['expense']} = &pound;{$plus_price_exp}</td>
        </tr>";
		}

		$sub_total = $price + $expense;
		$total     = $price + $vat + $expense;

		$html .= "<tr>
				<td colspan=\"5\" style=\"font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px\">
					<b>Sub-Total:</b></td>
				<td style=\"font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px\">&pound;{$sub_total}</td>
			</tr>
			<tr>
				<td colspan=\"5\" style=\"font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px\">
					<b>VAT(20%):</b></td>
				<td style=\"font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px\">&pound;{$vat}</td>
			</tr>
			<tr>
				<td colspan=\"5\" style=\"font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px\">
					<b>Total:</b></td>
				<td style=\"font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px\">&pound;{$total}</td>
			</tr>";


		$html .= "</table>
        <br>
        <h4>If you have any questions, contact us at <a href='mailto:wendy@gmail.com'>wendy@gmail.com</a></h4>
        <br>
        <h5 style=\"vertical-align: middle;color: #8898aa;font-size: 8px;line-height: 16px;\">You're receiving this email because you made a job post at Propertydisplayed.co.uk. to provide secure invoicing and payments processing.
        </h5>
        <br><br>
        <h5>&nbsp;</h5>
        <table>
            <tr>
                <td style=\"font-size:10px;margin-top: 30px;\">PAYMENT STRICTLY WITHN 30 DAYS</td>    
                <td style=\"float: left !important;\">
                20A TENNANT STREET <br>
                EDINBURGH <br>
                EH6 5NO <br>
                VAT REG. NO.789 7602 62
                </td>    
			</tr>
		</table>";

		$output = CONTENT_PATH . 'invoice/' . Users::get_my_id();
		if ( ! is_dir( $output ) ) {
			mkdir( $output );
		}
		$output = $output . '/';
		if ( ! is_dir( $output ) ) {
			mkdir( $output );
		}

		$output = CONTENT_PATH . 'invoice/' . Users::get_my_id() . '/' . $company_name . '.pdf';
		PDF_Generate( $html, $output );

		$message = 'Hi, ' . Users::get_username( Users::get_my_id() ) . '<br><br>';
		$message .= "You're receiving this email because you made a job post at Propertydisplayed.co.uk. to provide secure invoicing and payments processing.";

		$return = send_mail( $params['to'], $params['subject'], nl2br( $params['message'] ), $output );
		if ( empty( $return ) ) {
			return $return;
		}

		return 'OK';
	}


	public function download_invoice( $params = '' ) {
		$default = [
			'date'      => '',
			'jobid'     => '',
			'invoice'   => '',
			'client_id' => '',

		];
		$params  = General::set_args( $params, $default );

		if ( empty( $params['jobid'] ) ) {
			return 'Job id missing.';
		}
		if ( empty( $params['client_id'] ) ) {
			return 'Client id missing.';
		}

		$month = MyDateTime::mysql_datetime( $params['date'], 'M' );
		$year  = MyDateTime::mysql_datetime( $params['date'], 'Y' );
		$rows  = $this->db->where_in( "id", General::make_array( $params['jobid'] ) )
		                  ->get( $this->Table )
		                  ->result_array();

		$html = "
		<table>
			<tr>
				<td>
					<div style=\"float: left;\">
					<b>Company: </b> " . Users::get_username( $params['client_id'] ) . " <br>
					<b>Phone: </b> " . Users::get_client_phone( $params['client_id'] ) . " <br>
					<b>Address: </b> " . Users::get_client_address( $params['client_id'] ) . "<br>
					<b>Date: </b> " . MyDateTime::mysql_datetime( $params['date'], 'M-Y' ) . "<br>
					<b>Invoice No: </b> #" . $params['invoice'] . "<br>
		            </div>
	            </td>
				<td style=\"float: right;\">
					<div style=\"margin-left: 200px;\">
						<img src=\"" . DOMAIN_URL . "assets/images/logo.png\" style=\"float:right;width: 50px;margin-left: 100px\" />
					</div>
				</td>
			</tr>
		</table>
        <h3>Here are the Detail</h3>";
		$html .= "<br />
        <table style=\"width:500px\" border=\"1\" cellpadding=\"5\">";
		$html .= "
        <tr>
            <th>Company</th>
            <th>Code</th>
            <th>Job</th>
            <th>Stickers</th>
            <th>Address</th>
            <th>Price + Expence</th>
		</tr>";

		$vat       = 0;
		$price     = 0;
		$total     = 0;
		$expense   = 0;
		$sub_total = 0;

		foreach ( $rows as $item ) {
			$price   += $item['price'];
			$expense += $item['expense'];
			$vat     += $item['price'] * 0.2;

			$job_type       = Users::get_jobname( $item['job_type'] );
			$sticker        = isset( $item['sticker'] ) ? $item['sticker'] : '-';
			$plus_price_exp = $item['price'] + $item['expense'];

			$company_name = str_replace( '_', null, $item['jobcode'] );
			$company_name = preg_replace( '/\d+/', '', $company_name );
			$html         .= "<tr>
            <td>{$company_name}</td>
            <td>{$item['jobcode']}</td>
            <td>{$job_type}</td>
            <td>{$sticker}</td>
            <td>{$item['address1']}</td>
            <td>&pound;{$item['price']} + &pound;{$item['expense']} = &pound;{$plus_price_exp}</td>
        </tr>";
		}

		$sub_total = $price + $expense;
		$total     = $price + $vat + $expense;

		$html .= "<tr>
				<td colspan=\"5\" style=\"font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px\">
					<b>Sub-Total:</b></td>
				<td style=\"font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px\">&pound;{$sub_total}</td>
			</tr>
			<tr>
				<td colspan=\"5\" style=\"font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px\">
					<b>VAT(20%):</b></td>
				<td style=\"font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px\">&pound;{$vat}</td>
			</tr>
			<tr>
				<td colspan=\"5\" style=\"font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px\">
					<b>Total:</b></td>
				<td style=\"font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px\">&pound;{$total}</td>
			</tr>";


		$html .= "</table>
        <br>
        <h4>If you have any questions, contact us at <a href='mailto:wendy@gmail.com'>wendy@gmail.com</a></h4>
        <br>
        <h5 style=\"vertical-align: middle;color: #8898aa;font-size: 8px;line-height: 16px;\">You're receiving this email because you made a job post at Propertydisplayed.co.uk. to provide secure invoicing and payments processing.
        </h5>
        <br><br>
        <h5>&nbsp;</h5>
        <table>
            <tr>
                <td style=\"font-size:10px;margin-top: 30px;\">PAYMENT STRICTLY WITHN 30 DAYS</td>    
                <td style=\"float: left !important;\">
                20A TENNANT STREET <br>
                EDINBURGH <br>
                EH6 5NO <br>
                VAT REG. NO.789 7602 62
                </td>    
			</tr>
		</table>";

		$output = CONTENT_PATH . 'invoice/' . $month . '_' . $year;
		if ( ! is_dir( $output ) ) {
			mkdir( $output );
		}

		$path = $output . '/' . $params['client_id'];

		if ( ! is_dir( $path ) ) {
			mkdir( $path );
		}

		$path = $path . '/invoice_' . $month . '_' . $year . '.pdf';

		PDF_Generate( $html, $path );

		return get_file_url( $path );
	}

	public function view_invoice( $params = '' ) {
		$default = [
			'client_id'  => '',
			'date_done'  => '',
			'job_status' => '1',
		];
		$params  = General::set_args( $params, $default );

		if ( empty( $params['client_id'] ) ) {
			return 'Client id missing.';
		}
		if ( empty( $params['date_done'] ) ) {
			return 'Job date missing.';
		}

		$from = MyDateTime::mysql_date( $params['date_done'] );
		$to   = MyDateTime::mysql_date( $params['date_done'] );

		$this->db->select( '*,DATE(`date_done`) as date' );
		$this->db->where( "DATE(`date_done`) BETWEEN '$from' AND '$to'" );
		$this->db->where( 'client_id', (int) $params['client_id'] );
		$rows = $this->db->get( $this->Table )->result_array();

		return $rows;
	}


}