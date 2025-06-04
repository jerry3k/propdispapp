<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Logout extends MY_Controller {

	public function __construct() {
		parent::__construct();
		if ( empty( Users::is_login() ) ) {
			echo "You'r not authorized to view this page. Please click to <a href='" . DOMAIN_URL . "login'>logged in!</a> ";
			redirect( DOMAIN_URL . 'login' );
			exit();
		}
		$segment = $this->uri->segment( 2 );
		if ( isset( $segment ) && $segment == 'index' ) {
			redirect( DOMAIN_URL . 'logout' );
			exit();
		}
	}

	public function index() {
		// check and delete admin cookie data id
		$cookie = $this->input->cookie( 'admin_cookie_id' );
		if ( isset( $cookie ) ) {
			$cookie = array(
				'name'   => 'admin_cookie_id',
				'value'  => '',
				'expire' => '0',
			);
			delete_cookie( $cookie );
		}
		// check and delete admin session data
		unset( $_SESSION );
		$this->cache->clean();
		$this->session->sess_destroy();
		$this->session->unset_userdata( [ 'id', 'username', 'email' ] );
		unset( $GLOBALS['_myid_'], $GLOBALS['_email_'], $GLOBALS['_username_'] );
		redirect( DOMAIN_URL . 'login' );
		exit();
	}

}