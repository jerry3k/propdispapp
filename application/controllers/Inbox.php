<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Inbox extends MY_Controller {

	public function __construct() {
		parent::__construct();
		if ( empty( Users::is_login() ) ) {
			echo "You'r not authorized to view this page. Please click to <a href='" . DOMAIN_URL . "login'>logged in!</a> ";
			redirect( DOMAIN_URL . 'login' );
			exit();
		}
		$segment = $this->uri->segment( 2 );
		if ( isset( $segment ) && $segment == 'index' ) {
			redirect( DOMAIN_URL . 'inbox' );
			exit();
		}
	}i

	public function index() {
		$data['function_name'] = $this->uri->segment( 1 );
		$this->load->view( 'inbox', $data );
	}

}