<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Invoice extends MY_Controller {

	public function __construct() {
		parent::__construct();
		if ( empty( Users::is_login() ) ) {
			echo "You'r not authorized to view this page. Please click to <a href='" . DOMAIN_URL . "login'>logged in!</a> ";
			redirect( DOMAIN_URL . 'login' );
			exit();
		}
		$segment = $this->uri->segment( 2 );
		if ( isset( $segment ) && $segment == 'index' ) {
			redirect( DOMAIN_URL . 'invoice' );
			exit();
		}
		if ( ! Users::is_admin() ) {
			echo 'You are not authorized to view this page! <a href="' . DOMAIN_URL . '">Back to Dashboard</a>';
			exit();
		}

		if ( Users::get_user_account_type( Users::get_my_id() ) != 'admin' ) {
			redirect( DOMAIN_URL . 'dashboard' );
		}

//		$this->db->update( 'subjobs', [ 'invoice_no' => null ] );
	}

	public function index() {
		$this->load->model( 'Jobs_model' );
		$data['function_name'] = $this->uri->segment( 1 );
		$this->load->view( 'invoice', $data );
	}

	public function load_data() {
		$array = '';
		if ( ! empty( $this->input->post() ) ) {
			$array = $this->security->xss_clean( $this->input->post() );
		}
		if ( ! Users::is_admin() ) {
			$array['client_id'] = Users::get_my_id();
		}
		$this->load->model( 'Invoice_model' );
		$rows = $this->Invoice_model->get_invoice( $array );
		header( 'Content-Type: application/json' );
		echo json_encode( $rows );
		exit();
	}

	public function view() {
		$xss_clean = '';
		if ( ! empty( $this->input->post() ) ) {
			$xss_clean = $this->security->xss_clean( $this->input->post() );
		}
		$this->load->model( 'Jobs_model' );
		$rows = $this->Jobs_model->get_jobs( $xss_clean );
		header( 'Content-Type: application/json' );
		echo json_encode( $rows );
		exit();
	}

	public function send_email() {
		$jobid   = $this->input->post( 'id' );
		$invoice = $this->input->post( 'invoice' );
		$this->load->model( 'Jobs_model' );
		$rows = $this->Jobs_model->get_jobs( 'id=' . $jobid );
		if ( empty( $rows ) ) {
			echo 'No record found';
			exit();
		}
		$xss_clean = '';
		if ( ! empty( $this->input->post() ) ) {
			$xss_clean = $this->security->xss_clean( $this->input->post() );
		}
		$this->load->model( 'Invoice_model' );
		echo $this->Invoice_model->send( $xss_clean, $rows );
		exit();
	}

	public function download_invoice() {
		$xss_clean = '';
		if ( ! empty( $this->input->post() ) ) {
			$xss_clean = $this->security->xss_clean( $this->input->post() );
		}
		@General::rrmdir( CONTENT_PATH . 'invoice' );
		$this->load->model( 'Invoice_model' );
		$url = $this->Invoice_model->download_invoice( $xss_clean );
		if ( empty( $url ) || $url == '#' ) {
			echo 'error';
			exit();
		}
		echo $url;
		exit();
	}

	public function download_pdf() {
		echo $this->load->view( 'print_invoice', '', true );
		exit();
		$m          = $this->uri->segment( 3 ) + 1;
		$y          = $this->uri->segment( 4 );
		$month_name = date( "F", mktime( 0, 0, 0, $m, 10 ) );
		$start      = date_create( $month_name . '-' . $y )->modify( 'first day of this month' )->format( 'Y-m-d' );
		$end        = date_create( $month_name . '-' . $y )->modify( 'last day of this month' )->format( 'Y-m-d' );
		$post       = [
			'page'      => 1,
			'pagesize'  => 99999999,
			'time_to'   => $end,
			'time_from' => $start,
		];
		if ( ! Users::is_admin() ) {
			$post['client_id'] = Users::get_my_id();
		}
		$Q         = [];
		$column    = 0;
		$excel_row = 2;
		$xss_clean = $this->security->xss_clean( $post );
		$this->load->model( 'Invoice_model' );
		$rows = $this->Invoice_model->get_invoice( $xss_clean );


		foreach ( $rows['rows'] as $k => $item ) {
			$vat           = 0;
			$price         = 0;
			$total         = 0;
			$expense       = 0;
			$price_expense = 0;
			$sub_total     = 0;
			if ( ! empty( $item['array'] ) ) {
				foreach ( $item['array'] as $row ) {
					$price   += number_format( $row['price'], 2 );
					$expense += number_format( $row['expense'], 2 );
					$vat     += number_format( ( $row['price'] * 0.2 ), 2 );
				}
			}
			$total = number_format( $price + $expense + $vat, 2 );
		}

		General::show_array( $rows );
		die;

		if ( empty( $rows ) ) {
			echo 'No record found. <a href="' . DOMAIN_URL . 'invoice">Back to Page</a>';
			exit();
		}
		$this->load->library( 'excel' );
		$obj = new PHPExcel();
		$obj->setActiveSheetIndex( 0 );
		$table_column = [
			'*Invoice No',
			'*Customer',
			'*Invoice Date',
			'*Price',
			'*Expense',
			'*VAT(20%)',
			'*Total',
		];
		foreach ( $table_column as $field ) {
			$obj->getActiveSheet()->setCellValueByColumnAndRow( $column, 1, $field );
			$column ++;
		}
		if ( ! empty( $rows ) ) {
			foreach ( $rows['rows'] as $k => $item ) {
				$vat           = 0;
				$price         = 0;
				$total         = 0;
				$expense       = 0;
				$price_expense = 0;
				$sub_total     = 0;
				if ( ! empty( $item['array'] ) ) {
					foreach ( $item['array'] as $row ) {
						$price   += number_format( $row['price'], 2 );
						$expense += number_format( $row['expense'], 2 );
						$vat     += number_format( ( $row['price'] * 0.2 ), 2 );
					}
				}
				$total = number_format( $price + $expense + $vat, 2 );
				$obj->getActiveSheet()->setCellValueByColumnAndRow( 0, $excel_row, '#' . $item['invoice_no'] );
				$obj->getActiveSheet()
				    ->setCellValueByColumnAndRow( 1, $excel_row, Users::get_username( $item['client_id'] ) );
				$obj->getActiveSheet()->setCellValueByColumnAndRow( 2, $excel_row, $item['invoice_date'] );
				$obj->getActiveSheet()->setCellValueByColumnAndRow( 3, $excel_row, '£' . $price );
				$obj->getActiveSheet()->setCellValueByColumnAndRow( 4, $excel_row, '£' . $expense );
				$obj->getActiveSheet()->setCellValueByColumnAndRow( 5, $excel_row, '£' . $vat );
				$obj->getActiveSheet()->setCellValueByColumnAndRow( 6, $excel_row, '£' . $total );
				$excel_row ++;
			}
		}

		$file_name     = 'Invoice-' . $month_name . '-' . $y . '.xls';
		$object_writer = PHPExcel_IOFactory::createWriter( $obj, 'Excel5' );
		header( 'Content-Type: application/vnd.ms-excel' );
		header( 'Content-Disposition: attachment;filename="' . $file_name . '"' );
		$object_writer->save( 'php://output' );
		exit();
	}

	public function download_excel() {
		echo $this->load->view( 'print_invoice', '', true );
		exit();
		$m          = $this->uri->segment( 3 ) + 1;
		$y          = $this->uri->segment( 4 );
		$month_name = date( "F", mktime( 0, 0, 0, $m, 10 ) );
		$start      = date_create( $month_name . '-' . $y )->modify( 'first day of this month' )->format( 'Y-m-d' );
		$end        = date_create( $month_name . '-' . $y )->modify( 'last day of this month' )->format( 'Y-m-d' );
		$post       = [
			'page'      => 1,
			'pagesize'  => 99999999,
			'time_to'   => $end,
			'time_from' => $start,
		];
		if ( ! Users::is_admin() ) {
			$post['client_id'] = Users::get_my_id();
		}
		$Q         = [];
		$column    = 0;
		$excel_row = 2;
		$xss_clean = $this->security->xss_clean( $post );
		$this->load->model( 'Invoice_model' );
		$rows = $this->Invoice_model->get_invoice( $xss_clean );


		foreach ( $rows['rows'] as $k => $item ) {
			$vat           = 0;
			$price         = 0;
			$total         = 0;
			$expense       = 0;
			$price_expense = 0;
			$sub_total     = 0;
			if ( ! empty( $item['array'] ) ) {
				foreach ( $item['array'] as $row ) {
					$price   += number_format( $row['price'], 2 );
					$expense += number_format( $row['expense'], 2 );
					$vat     += number_format( ( $row['price'] * 0.2 ), 2 );
				}
			}
			$total = number_format( $price + $expense + $vat, 2 );
		}

		General::show_array( $rows );
		die;

		if ( empty( $rows ) ) {
			echo 'No record found. <a href="' . DOMAIN_URL . 'invoice">Back to Page</a>';
			exit();
		}
		$this->load->library( 'excel' );
		$obj = new PHPExcel();
		$obj->setActiveSheetIndex( 0 );
		$table_column = [
			'*Invoice No',
			'*Customer',
			'*Invoice Date',
			'*Price',
			'*Expense',
			'*VAT(20%)',
			'*Total',
		];
		foreach ( $table_column as $field ) {
			$obj->getActiveSheet()->setCellValueByColumnAndRow( $column, 1, $field );
			$column ++;
		}
		if ( ! empty( $rows ) ) {
			foreach ( $rows['rows'] as $k => $item ) {
				$vat           = 0;
				$price         = 0;
				$total         = 0;
				$expense       = 0;
				$price_expense = 0;
				$sub_total     = 0;
				if ( ! empty( $item['array'] ) ) {
					foreach ( $item['array'] as $row ) {
						$price   += number_format( $row['price'], 2 );
						$expense += number_format( $row['expense'], 2 );
						$vat     += number_format( ( $row['price'] * 0.2 ), 2 );
					}
				}
				$total = number_format( $price + $expense + $vat, 2 );
				$obj->getActiveSheet()->setCellValueByColumnAndRow( 0, $excel_row, '#' . $item['invoice_no'] );
				$obj->getActiveSheet()
				    ->setCellValueByColumnAndRow( 1, $excel_row, Users::get_username( $item['client_id'] ) );
				$obj->getActiveSheet()->setCellValueByColumnAndRow( 2, $excel_row, $item['invoice_date'] );
				$obj->getActiveSheet()->setCellValueByColumnAndRow( 3, $excel_row, '£' . $price );
				$obj->getActiveSheet()->setCellValueByColumnAndRow( 4, $excel_row, '£' . $expense );
				$obj->getActiveSheet()->setCellValueByColumnAndRow( 5, $excel_row, '£' . $vat );
				$obj->getActiveSheet()->setCellValueByColumnAndRow( 6, $excel_row, '£' . $total );
				$excel_row ++;
			}
		}

		$file_name     = 'Invoice-' . $month_name . '-' . $y . '.xls';
		$object_writer = PHPExcel_IOFactory::createWriter( $obj, 'Excel5' );
		header( 'Content-Type: application/vnd.ms-excel' );
		header( 'Content-Disposition: attachment;filename="' . $file_name . '"' );
		$object_writer->save( 'php://output' );
		exit();
	}

	public function get_invoice_no() {
		$xss_clean = '';
		$this->load->model( 'Jobs_model' );
		if ( ! empty( $this->input->post() ) ) {
			$xss_clean = $this->security->xss_clean( $this->input->post() );
		}

		$ids        = array_filter( explode( ',', $xss_clean['ids'] ) );
		$invoice_no = $this->Jobs_model->get_invoice_no( $xss_clean );
		if ( ! empty( $ids ) ) {
			for ( $i = 0; $i < count( $ids ); $i ++ ) {
				$this->db->update( 'subjobs', [ 'invoice_no' => $invoice_no ], [ 'id' => $ids[ $i ] ] );
			}
		}

		echo $invoice_no;
		exit();
	}


}