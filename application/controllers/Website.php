<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Website extends MY_Controller {

	function __construct() {
		parent::__construct();
		if ( ! Users::is_login() ) {
			redirect( DOMAIN_URL . 'login' );
			exit();
		}
		$segment = $this->uri->segment( 2 );
		if ( isset( $segment ) && $segment == 'index' ) {
			redirect( DOMAIN_URL . 'dashboard' );
			exit();
		}
	}

	public function index() {
		redirect( DOMAIN_URL . 'dashboard' );
	}

}
