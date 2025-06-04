<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Login extends MY_Controller {

	public function __construct() {
		parent::__construct();
		if ( Users::is_login() ) {
			redirect( DOMAIN_URL . 'dashboard' );
			exit();
		}

//		echo password_hash('nasir' , PASSWORD_BCRYPT);
//		die;
	}

	public function index() {
		$this->load->view( 'login' );
	}

	public function login_validation() {
		$this->load->model( 'Login_model' );
		$xss_clean = $this->security->xss_clean( $this->input->post() );
		echo $this->Login_model->login_validation_check( $xss_clean );
		array_map( 'unlink', array_filter( (array) glob( APP_PATH . "cache/*" ) ) );
		exit();
	}

	public function forgetpassword() {
		$this->load->model( 'Login_model' );
		$xss_clean = $this->security->xss_clean( $this->input->post() );
		echo $this->Login_model->forgetpassword( $xss_clean );
		exit();
	}

	public function resetpassword() {
		$segment = $this->uri->segment( 3 );
		if ( ! isset( $segment ) ) {
			redirect( DOMAIN_URL . 'login' );
			exit();
		}
		$data['email'] = base64_decode( $segment );
		$this->load->view( 'resetpassword', $data );
	}


	public function reset_password() {
		$this->load->model( 'Login_model' );
		$xss_clean = $this->security->xss_clean( $this->input->post() );
		echo $this->Login_model->update_password( $xss_clean );
		exit();
	}

}