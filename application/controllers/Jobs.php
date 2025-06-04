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
	}

	public function index() {
		if ( ! Users::is_admin() ) {
			redirect( DOMAIN_URL . 'jobs/client' );
		}
		$data['function_name'] = $this->uri->segment( 1 );
		$this->load->view( 'jobs', $data );
	}

	public function save() {
		$this->load->model( 'Jobs_model' );
		$xss_clean = $this->security->xss_clean( $this->input->post() );
		echo $this->Jobs_model->save( $xss_clean );
		exit();
	}

	public function get_jobs() {
		$this->load->model( 'Jobs_model' );
		$xss_clean = '';
		if ( ! empty( $this->input->post() ) ) {
			$xss_clean = $this->security->xss_clean( $this->input->post() );
		}
		$rows = $this->Jobs_model->get_jobs( $xss_clean );
		header( 'Content-Type: application/json' );
		echo json_encode( $rows );
		exit();
	}

	public function get_print_jobs() {
		$this->load->model( 'Jobs_model' );
		$xss_clean = '';
		if ( ! empty( $this->input->post() ) ) {
			$xss_clean = $this->security->xss_clean( $this->input->post() );

		}
		$rows = $this->Jobs_model->get_jobs( $xss_clean );
		echo $this->load->view( 'print_fitter', $rows, true );
		exit();
	}

	public function get_print_sticker() {
		$this->load->model( 'Jobs_model' );
		$xss_clean = '';
		if ( ! empty( $this->input->post() ) ) {
			$xss_clean = $this->security->xss_clean( $this->input->post() );

		}
		$rows = $this->Jobs_model->get_jobs( $xss_clean );
		echo $this->load->view( 'print_sticker', $rows, true );
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

	public function delete_subjobs() {
		if ( ! Users::is_admin() ) {
			echo 'you have not authorized to delete this job.';
			exit();
		}
		$this->load->model( 'Jobs_model' );
		$xss_clean = '';
		if ( ! empty( $this->input->post() ) ) {
			$xss_clean = $this->security->xss_clean( $this->input->post() );
		}
		$result = $this->Jobs_model->delete_subjobs( $xss_clean );
		echo $result;
		exit();
	}

	public function print_job() {
		if ( ! Users::is_admin() ) {
			echo 'you have not authorized to print this job.';
			exit();
		}

		$array = [
			'id'    => $this->uri->segment( 3 ),
			'jobid' => $this->uri->segment( 4 ),
		];
		$this->load->model( 'Jobs_model' );
		$rows['DOMAIN_URL'] = DOMAIN_URL;
		$rows['rows']       = $this->Jobs_model->get_job_print( $array );
		echo $this->load->view( 'print_job', $rows, true );
		exit();
	}

	public function update_job_status() {
		if ( ! Users::is_admin() ) {
			echo 'you have not authorized to print this job.';
			exit();
		}

		$xss_clean = '';
		if ( ! empty( $this->input->post() ) ) {
			$xss_clean = $this->security->xss_clean( $this->input->post() );
		}

		$this->load->model( 'Jobs_model' );
		$rows = $this->Jobs_model->update_job_status( $xss_clean );
		header( 'Content-Type: application/json' );
		echo json_encode( $rows );
		exit();
	}

	public function get_jobtype_fields() {
		$jobid = '';
		if ( ! empty( $this->input->post() ) ) {
			$jobid = $this->security->xss_clean( $this->input->post() )['id'];

		}

		if ( ! empty( $jobid ) ) {
			$rows = $this->db->select( 'name,print_name,position' )
			                 ->where( 'id', $jobid )
			                 ->get( 'jobtype' )
			                 ->row_array( 0 );
			header( 'Content-Type: application/json' );
			echo json_encode( $rows );
		} else {
			echo 'No record found.';
		}

		exit();
	}

	public function generate_monthly_report() {
		$array = [];
		if ( ! empty( $this->input->post() ) ) {
			$array = $this->security->xss_clean( $this->input->post() );
		}
		if ( ! Users::is_admin( Users::get_my_id() ) ) {
			$array['client_id'] = Users::get_my_id();
		}

		$this->load->model( 'Jobs_model' );
		$rows = $this->Jobs_model->generate_monthly_report( $array );
		header( 'Content-Type: application/json' );
		echo json_encode( $rows );
		exit();
	}

	//*************************************************
	//*************************************************
	//*************************************************
	//*************************************************
	//*************************************************

	public function client() {
		$client_id = $this->uri->segment( 3 );
		if ( empty( $client_id ) && Users::is_admin() ) {
			echo 'Client id missing.';
			exit();
		}
		if ( Users::is_admin() ) {
			$data['client_id'] = $client_id;
		} else {
			$data['client_id'] = Users::get_my_id();
		}
		$data['function_name'] = $this->uri->segment( 1 );
		$this->load->view( 'client_view', $data );
	}

	public function get_jobs_client() {
		$xss_clean = '';
		$this->load->model( 'Jobs_model' );
		if ( ! empty( $this->input->post() ) ) {
			$xss_clean = $this->security->xss_clean( $this->input->post() );
		}
		//		General::show_array($xss_clean);
		//		die;
		$rows = $this->Jobs_model->get_jobs_client( $xss_clean );
		header( 'Content-Type: application/json' );
		echo json_encode( $rows );
		exit();
	}

	public function client_map_view() {
		if ( empty( Users::get_my_id() ) ) {
			exit();
		}
		$id = $this->uri->segment( 3 );
		if ( empty( $id ) ) {
			echo 'Client id missing.';
			exit();
		}

		$array = [];
		$this->load->model( 'Jobs_model' );
		$rows = $this->Jobs_model->get_client_map_view( 'id=' . $id );

		if ( ! empty( $rows ) ) {
			foreach ( $rows as $k => $row ) {
				$icon = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
				//				if ( ! empty( $row['job_status'] ) ) {
				//					$icon = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
				//				}
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

	public function save2() {
		$xss_clean = '';
		$this->load->model( 'Jobs_model' );
		if ( ! empty( $this->input->post() ) ) {
			$xss_clean = $this->security->xss_clean( $this->input->post() );
		}

		$rows = $this->Jobs_model->save2( $xss_clean );
		header( 'Content-Type: application/json' );
		echo json_encode( $rows );
		exit();
	}

	public function get_postcode() {
		$this->load->model( 'Jobs_model' );
		$rows = $this->Jobs_model->get_all_postcode_from_jobs();
		header( 'Content-Type: application/json' );
		echo json_encode( $rows );
		exit();
	}

}