<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Jobs extends MY_Controller {

	public function __construct() {
		parent::__construct();
		if ( empty( Users::is_login() ) ) {
			echo "You'r not authorized to view this page. Please click to <a href='" . DOMAIN_URL . "login'>logged in!</a> ";
			redirect( DOMAIN_URL . 'login' );
			exit();
		}
		$segment = $this->uri->segment( 2 );
		if ( isset( $segment ) && $segment == 'index' ) {
			redirect( DOMAIN_URL . 'jobs' );
			exit();
		}

		//		echo password_hash( 'nasir', PASSWORD_BCRYPT );
		//		die;

	}

	public function index() {
		if ( ! Users::is_admin() ) {
			redirect( DOMAIN_URL . 'jobs/clientview' );
		}
		$data['function_name'] = $this->uri->segment( 1 );
		$this->load->view( 'jobs', $data );
	}

	public function get_jobs_with_subtypes() {
		$this->load->model( 'Jobs_model' );
		$xss_clean = '';
		if ( ! empty( $this->input->post() ) ) {
			$xss_clean = $this->security->xss_clean( $this->input->post() );
		}
		$rows = $this->Jobs_model->get_jobs_with_subtypes( $xss_clean );
		header( 'Content-Type: application/json' );
		echo json_encode( $rows );
		exit();
	}

	public function save() {
		$this->load->model( 'Jobs_model' );
		$xss_clean = $this->security->xss_clean( $this->input->post() );
		echo $this->Jobs_model->save( $xss_clean );
		exit();
	}


	// ************** Client view Submit ****************** \\
	// ************** Client view Submit ****************** \\
	// ************** Client view Submit ****************** \\

	public function clientview() {
		$data['function_name'] = $this->uri->segment( 1 );
		$this->load->view( 'client_view', $data );
	}

	public function save2() {
		$this->load->model( 'Jobs_model' );
		$xss_clean = $this->security->xss_clean( $this->input->post() );
		echo $this->Jobs_model->save2( $xss_clean );
		exit();
	}

	public function load_data_with_client_view() {
		$this->load->model( 'Jobs_model' );
		$xss_clean = '';
		if ( ! empty( $this->input->post() ) ) {
			$xss_clean = $this->security->xss_clean( $this->input->post() );
		}
		$rows = $this->Jobs_model->get_jobs_with_client_view( $xss_clean );
		header( 'Content-Type: application/json' );
		echo json_encode( $rows );
		exit();
	}

	// ************** Client view Submit ****************** \\
	// ************** Client view Submit ****************** \\
	// ************** Client view Submit ****************** \\


	public function load_data() {
		$this->load->model( 'Jobs_model' );
		$xss_clean = '';
		if ( ! empty( $this->input->post() ) ) {
			$xss_clean = $this->security->xss_clean( $this->input->post() );
		}
		if ( ! Users::is_admin( Users::get_my_id() ) ) {
			$xss_clean['client_id'] = Users::get_my_id();
		}
		$rows = $this->Jobs_model->get_jobs( $xss_clean );
		header( 'Content-Type: application/json' );
		echo json_encode( $rows );
		exit();
	}

	public function delete() {
		if ( empty( $this->input->post() ) ) {
			echo "You'r not authorized.";
			exit();
		}
		$this->load->model( 'Jobs_model' );
		$xss_clean = $this->security->xss_clean( $this->input->post() );
		echo $this->Jobs_model->delete( $xss_clean );
		exit();
	}

	public function status() {
		if ( empty( $this->input->post() ) ) {
			echo "You'r not authorized.";
			exit();
		}
		$this->load->model( 'Staff_model' );
		$xss_clean = $this->security->xss_clean( $this->input->post() );
		echo $this->Jobs_model->status( $xss_clean );
		exit();
	}

	public function printjob() {
		if ( empty( $this->input->post() ) ) {
			echo "You'r not authorized.";
			exit();
		}
		$this->load->model( 'Jobs_model' );
		$xss_clean = '';
		if ( ! empty( $this->input->post() ) ) {
			$xss_clean = $this->security->xss_clean( $this->input->post() );
		}
		$rows = $this->Jobs_model->get_jobs( $xss_clean );
		if ( ! empty( $rows ) ) {
			$html = $this->load->view( 'job_print', $rows, true );
		} else {
			$html = 'Record not found';
		}

		echo $html;
		exit();
	}

	public function client_locations() {
		if ( Users::is_admin() ) {
			exit();
		}
		if ( empty( Users::get_my_id() ) ) {
			exit();
		}
		$id = Users::get_my_id();

		$this->load->model( 'Jobs_model' );
		$rows  = $this->Jobs_model->get_client_location( 'id=' . $id );
		$array = [];
		if ( ! empty( $rows ) ) {
			foreach ( $rows as $k => $row ) {
				$icon = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
				if ( ! empty( $row['job_status'] ) ) {
					$icon = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
				}
				$array[] = [
					$row['address1'],
					(float) $row['latitude'],
					(float) $row['longitude'],
					( $k + 1 ),
					$icon,
				];
			}
		}
		header( 'Content-Type: application/json' );
		echo json_encode( $array );
		exit();
	}

	public function download_sticker() {
		$check = $this->uri->segment( 3 );
		if ( ! isset( $check ) ) {
			die();
		}
		$post      = [
			'page'       => 1,
			'pagesize'   => 99999999,
			'job_status' => $this->uri->segment( 3 ),
			'sticker'    => $this->uri->segment( 4 ),
		];
		$Q         = [];
		$column    = 0;
		$excel_row = 2;
		$xss_clean = $this->security->xss_clean( $post );
		$this->load->model( 'Jobs_model' );
		$rows = $this->Jobs_model->get_jobs( $xss_clean );
		if ( isset( $rows['rows'] ) && ! empty( $rows['rows'] ) ) {
			$Q = $rows['rows'];
		} else {
			echo 'No record found. <a href="' . DOMAIN_URL . 'jobs">Back to Page</a>';
			exit();
		}
		$this->load->library( 'excel' );
		$obj = new PHPExcel();
		$obj->setActiveSheetIndex( 0 );
		$table_column = [
			'Sticker',
			'Client',
			'Address',
			'*Post Code',
		];
		foreach ( $table_column as $field ) {
			$obj->getActiveSheet()->setCellValueByColumnAndRow( $column, 1, $field );
			$column ++;
		}
		foreach ( $Q as $row ) {
			$obj->getActiveSheet()->setCellValueByColumnAndRow( 0, $excel_row, $row['sticker'] );
			$obj->getActiveSheet()
			    ->setCellValueByColumnAndRow( 1, $excel_row, str_replace( '_', ' ', $row['jobcode'] ) );
			$obj->getActiveSheet()->setCellValueByColumnAndRow( 2, $excel_row, $row['address1'] );
			$obj->getActiveSheet()->setCellValueByColumnAndRow( 3, $excel_row, $row['postcode'] );
			$excel_row ++;
		}

		$file_name     = 'PrintSticker-' . date( 'M' ) . '-' . date( 'Y' ) . '.xls';
		$object_writer = PHPExcel_IOFactory::createWriter( $obj, 'Excel5' );
		header( 'Content-Type: application/vnd.ms-excel' );
		header( 'Content-Disposition: attachment;filename="' . $file_name . '"' );
		$object_writer->save( 'php://output' );
		exit();
	}

	public function download_fitter() {
		$check = $this->uri->segment( 3 );
		if ( ! isset( $check ) ) {
			die();
		}
		$post      = [
			'page'       => 1,
			'pagesize'   => 99999999,
			'fitter_id'  => $this->uri->segment( 3 ),
			'job_status' => 0,
		];
		$Q         = [];
		$column    = 0;
		$excel_row = 2;
		$xss_clean = $this->security->xss_clean( $post );
		$this->load->model( 'Jobs_model' );
		$rows = $this->Jobs_model->get_jobs( $xss_clean );
		if ( isset( $rows['rows'] ) && ! empty( $rows['rows'] ) ) {
			$Q = $rows['rows'];
		} else {
			echo 'No record found. <a href="' . DOMAIN_URL . 'jobs">Back to Page</a>';
			exit();
		}
		$this->load->library( 'excel' );
		$obj = new PHPExcel();
		$obj->setActiveSheetIndex( 0 );
		$table_column = [
			'Company',
			'Job',
			'Sticker',
			'Address',
			'Post Code',
			'Name',
			'Access',
			'Keys',
			'Comments',
			'Done',
		];
		foreach ( $table_column as $field ) {
			$obj->getActiveSheet()->setCellValueByColumnAndRow( $column, 1, $field );
			$column ++;
		}
		foreach ( $Q as $row ) {
			$str = str_replace( '_', ' ', $row['jobcode'] );
			$str = preg_replace( '/\d+/u', '', $str );
			$obj->getActiveSheet()->setCellValueByColumnAndRow( 0, $excel_row, $str );
			$obj->getActiveSheet()->setCellValueByColumnAndRow( 1, $excel_row, Users::get_jobname( $row['job_type'] ) );
			$obj->getActiveSheet()->setCellValueByColumnAndRow( 2, $excel_row, $row['sticker'] );
			$obj->getActiveSheet()->setCellValueByColumnAndRow( 3, $excel_row, $row['address1'] );
			$obj->getActiveSheet()->setCellValueByColumnAndRow( 4, $excel_row, $row['postcode'] );
			$obj->getActiveSheet()->setCellValueByColumnAndRow( 5, $excel_row, $row['customer_name'] );
			$obj->getActiveSheet()->setCellValueByColumnAndRow( 6, $excel_row, $row['access'] );
			$obj->getActiveSheet()->setCellValueByColumnAndRow( 7, $excel_row, $row['key'] );
			$obj->getActiveSheet()->setCellValueByColumnAndRow( 8, $excel_row, $row['comments'] );
			$obj->getActiveSheet()->setCellValueByColumnAndRow( 9, $excel_row, $row['job_date'] );
			$excel_row ++;
		}

		$file_name     = 'PrintFitter-' . date( 'M' ) . '-' . date( 'Y' ) . '.xls';
		$object_writer = PHPExcel_IOFactory::createWriter( $obj, 'Excel5' );
		header( 'Content-Type: application/vnd.ms-excel' );
		header( 'Content-Disposition: attachment;filename="' . $file_name . '"' );
		$object_writer->save( 'php://output' );
		exit();
	}

	public function get_jobtype_price() {
		$xss_clean = '';
		if ( ! empty( $this->input->post() ) ) {
			$xss_clean = $this->security->xss_clean( $this->input->post() );
		}
		$this->load->model( 'Jobs_model' );
		$row = $this->Jobs_model->get_jobtype_price( $xss_clean );
		header( 'Content-Type: application/json' );
		echo json_encode( $row );
		exit();
	}

	public function monthly_report() {
		$xss_clean = '';
		if ( ! empty( $this->input->post() ) ) {
			$xss_clean = $this->security->xss_clean( $this->input->post() );
		}
		if ( ! Users::is_admin( Users::get_my_id() ) ) {
			$xss_clean['client_id'] = Users::get_my_id();
		}
		$this->load->model( 'Jobs_model' );
		$rows = $this->Jobs_model->get_monthly_report( $xss_clean );
		header( 'Content-Type: application/json' );
		echo json_encode( $rows );
		exit();
	}

	public function jobStatusUpdate() {
		if ( empty( $_POST ) ) {
			echo 'Job id missing.';
			exit();
		}
		$this->db->update( 'jobs', $_POST, [ 'id' => $_POST['id'] ] );
		echo $return = ( $this->db->affected_rows() != 1 ) ? $this->db->last_query() : 'OK';
		exit();
	}

	public function print_sticker() {
		if ( ! ( Users::is_login() ) ) {
			echo 'Please login your account';
			exit();
		}

		$array = [
			'page'       => 1,
			'pagesize'   => 99999999,
			'job_status' => 0,
			'sticker'    => 1,
		];
		if ( ! Users::is_admin() ) {
			$array['client_id'] = Users::get_my_id();
		}
		$this->load->model( 'Jobs_model' );
		$data['rows'] = $this->Jobs_model->get_jobs( $array );
		$this->load->view( 'print_sticker', $data );
	}

	public function print_fitter() {
		if ( ! ( Users::is_login() ) ) {
			echo 'Please login your account';
			exit();
		}

		$array = [
			'page'       => 1,
			'pagesize'   => 99999999,
			'fitter_id'  => base64_decode( $this->uri->segment( 3 ) ),
			'job_status' => 0,
		];

		if ( ! Users::is_admin() ) {
			$array['client_id'] = Users::get_my_id();
		}

		$this->load->model( 'Jobs_model' );
		$data['rows'] = $this->Jobs_model->get_jobs( $array );
		$this->load->view( 'print_fitter', $data );
	}


	public function search_client_for_job() {
		if ( ! ( Users::is_login() ) ) {
			echo 'Please login your account';
			exit();
		}

		$this->load->model( 'Jobs_model' );
		$rows = $this->Jobs_model->search_client_for_job();
		header( 'Content-Type: application/json' );
		echo json_encode( $rows );
		exit();
	}

}