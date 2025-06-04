<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Finance extends MY_Controller {

	public function __construct() {
		parent::__construct();
		if ( ! Users::is_login() ) {
			redirect( DOMAIN_URL . 'dashboard' );
			exit();
		}
	}

	public function index() {
		$html = $this->load->view( 'job_print', '', true );
		echo $html;
		exit();
	}

}