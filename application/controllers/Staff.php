<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Staff extends MY_Controller {

	public function __construct() {
		parent::__construct();
		if ( empty( Users::is_login() ) ) {
			echo "You'r not authorized to view this page. Please click to <a href='" . DOMAIN_URL . "login'>logged in!</a> ";
			redirect( DOMAIN_URL . 'login' );
			exit();
		}
		$segment = $this->uri->segment( 2 );
		if ( isset( $segment ) && $segment == 'index' ) {
			redirect( DOMAIN_URL . 'staff' );
			exit();
		}
	}

	public function index() {
		if ( ! Users::is_admin() ) {
			echo "You'r not authorized to view this page. Please click to <a href='" . DOMAIN_URL . "login'>logged in!</a> ";
			redirect( DOMAIN_URL . 'login' );
			exit();
		}
		$data['function_name'] = $this->uri->segment( 1 );
		$this->load->view( 'staff', $data );
	}

	public function save() {
		$this->load->model( 'Staff_model' );
		$xss_clean = $this->security->xss_clean( $this->input->post() );
		echo $this->Staff_model->save( $xss_clean );
		exit();
	}

	public function load_data() {
		$this->load->model( 'Staff_model' );
		$xss_clean = '';
		if ( ! empty( $this->input->post() ) ) {
			$xss_clean = $this->security->xss_clean( $this->input->post() );
		}
		$rows = $this->Staff_model->get_staff( $xss_clean );
		header( 'Content-Type: application/json' );
		echo json_encode( $rows );
		exit();
	}

	public function delete() {
		if ( empty( $this->input->post() ) ) {
			echo "You'r not authorized.";
			exit();
		}
		$this->load->model( 'Staff_model' );
		$xss_clean = $this->security->xss_clean( $this->input->post() );
		echo $this->Staff_model->delete( $xss_clean );
		exit();
	}

	public function status() {
		if ( empty( $this->input->post() ) ) {
			echo "You'r not authorized.";
			exit();
		}
		$this->load->model( 'Staff_model' );
		$xss_clean = $this->security->xss_clean( $this->input->post() );
		echo $this->Staff_model->status( $xss_clean );
		exit();
	}

	public function send_email() {
		if ( empty( $this->input->post() ) ) {
			echo "You'r not authorized.";
			exit();
		}
		$this->load->model( 'Staff_model' );
		$xss_clean = $this->security->xss_clean( $this->input->post() );
		echo $this->Staff_model->send_email( $xss_clean );
		exit();
	}
}