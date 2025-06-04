<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Dashboard extends MY_Controller {

	public function __construct() {
		parent::__construct();
		if ( empty( Users::is_login() ) ) {
			echo "You'r not authorized to view this page. Please click to <a href='" . DOMAIN_URL . "login'>logged in!</a> ";
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
		$data['function_name'] = $this->uri->segment( 1 );
		$this->load->view( 'dashboard', $data );
	}

	public function db_download() {
		if ( ! Users::is_login() ) {
			redirect( DOMAIN_URL );
			exit();
		}
		if ( ! General::is_localhost() ) {
			$ip = General::myip();
			if ( isset( $ip ) && $ip != '119.155.41.200' ) {
				redirect( DOMAIN_URL );
				exit();
			}
		}
		// Download DB
		$this->load->dbutil();

		$prefs  = array(
			'format'   => 'zip',
			'filename' => 'property_display_db_backup.sql',
		);
		$dbname = 'property_display_db_backup-' . date( "Y-m-d-H-i-s" ) . '.zip';
		// Backup your entire database and assign it to a variable
		$backup    = $this->dbutil->backup( $prefs );
		$save_path = CONTENT_PATH . $dbname;
		// Load the file helper and write the file to your server
		$this->load->helper( 'file' );
		write_file( $save_path, $backup );
		// Load the download helper and send the file to your desktop
		$this->load->helper( 'download' );
		force_download( $dbname, $backup );
	}
}