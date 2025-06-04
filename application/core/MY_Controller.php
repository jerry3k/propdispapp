<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class MY_Controller extends CI_Controller {

	function __construct() {
		parent::__construct();
		// ************** Create content folder **************
		if ( ! is_dir( CONTENT_PATH ) ) {
			mkdir( CONTENT_PATH );
		}
		// ************** End content folder *****************
		// ************** Create invoice folder **************
		$invoice = CONTENT_PATH . 'invoice';
		if ( ! is_dir( $invoice ) ) {
			mkdir( $invoice );
		}
		// ********** Migration run **********
		if ( $this->migration->current() === false ) {
			show_error( $this->migration->error_string() );
			exit();
		}
		// define global variables
		if ( ! empty( $_SESSION['admin_row'] ) ) {
			define( '_ID_', $_SESSION['admin_row']['id'] );
			define( '_EMAIL_', $_SESSION['admin_row']['email'] );
			define( '_USERNAME_', $_SESSION['admin_row']['username'] );
		}
	}
}
