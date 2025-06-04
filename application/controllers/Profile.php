<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Profile extends MY_Controller {

	public function __construct() {
		parent::__construct();
		if ( empty( Users::is_login() ) ) {
			echo "You'r not authorized to view this page. Please click to <a href='" . DOMAIN_URL . "login'>logged in!</a> ";
			redirect( DOMAIN_URL . 'login' );
			exit();
		}
		$segment = $this->uri->segment( 2 );
		if ( isset( $segment ) && $segment == 'index' ) {
			redirect( DOMAIN_URL . 'profile' );
			exit();
		}
	}

	public function index() {
		$id = Users::get_my_id();
		if ( empty( $id ) ) {
			redirect( DOMAIN_URL . 'dashboard' );
			exit();
		}
		$this->load->model( 'Staff_model' );
		$return = $this->Staff_model->get_staff( 'id=' . $id );
		if ( ! empty( $return ) ) {
			$data['u'] = $return['rows'][0];
		}
		$data['function_name'] = $this->uri->segment( 1 );
		$this->load->view( 'profile', $data );
	}

	public function change_password() {
		if ( empty( $this->input->post() ) ) {
			echo "You'r not authorized.";
			exit();
		}
		$this->load->model( 'Profile_model' );
		echo $this->Profile_model->change_password( $this->input->post() );
		exit();
	}

	public function upload_image() {
		if ( empty( $this->input->post() ) ) {
			echo "You'r not authorized.";
			exit();
		}
		if ( empty( $_FILES ) ) {
			echo "Please upload your image.";
			exit;
		}
		$this->load->model( 'Profile_model' );
		echo $this->Profile_model->upload_profile_image( $this->input->post(), $_FILES );
		exit();
	}

	public function get_profile_images() {
		if ( empty( $this->input->post() ) ) {
			echo "You'r not authorized.";
			exit();
		}

		$id = $this->input->post( 'id' );
		header( 'Content-Type: application/json' );
		echo json_encode( [
			get_profile_image( $id, 39, 39 ),
			get_profile_image( $id, 125, 125 ),
		] );
		exit();
	}


}