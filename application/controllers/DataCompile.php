<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class DataCompile extends MY_Controller {

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

	public function create_staff_users_js() {
		$file_path = ROOT_PATH . 'assets/js/';
		if ( ! is_dir( $file_path ) ) {
			mkdir( $file_path );
		}

		$newLine = ";\n";
		$rows    = $this->db->select( 'id,username,email,phone,pricing_system,address1' )
		                    ->order_by( 'id,username,email,phone,pricing_system,address1', 'ASC' )
		                    ->get( 'admins' )
		                    ->result_array();
		if ( ! empty( $rows ) ) {
			$_users        = [];
			$_email        = [];
			$_phone        = [];
			$_address      = [];
			$_price_system = [];

			foreach ( $rows as $row ) {
				$_email[ $row["id"] ]        = $row["email"];
				$_phone[ $row["id"] ]        = $row["phone"];
				$_users[ $row["id"] ]        = $row["username"];
				$_address[ $row["id"] ]      = $row["address1"];
				$_price_system[ $row["id"] ] = $row["pricing_system"];
			}
			// Client Username
			$js_content = "var Usersname=";
			$string     = json_encode( $_users );
			$js_content .= $string . $newLine;

			// Client Email
			$js_content .= "var UserEmail=";
			$string     = json_encode( $_email );
			$js_content .= $string . $newLine;

			// Client Phone
			$js_content .= "var UserPhone=";
			$string     = json_encode( $_phone );
			$js_content .= $string . $newLine;

			// Client pricing_system
			$js_content .= "var ClientPriceType=";
			$string     = json_encode( $_price_system );
			$js_content .= $string . $newLine;

			// Client address
			$js_content .= "var ClientAddress=";
			$string     = json_encode( $_address );
			$js_content .= $string . $newLine;
		}

		// load job type data
		$rows = $this->db->select( 'id,name,description' )
		                 ->order_by( 'id,name', 'ASC' )
		                 ->get( 'jobtype' )
		                 ->result_array();
		if ( ! empty( $rows ) ) {
			$_type             = [];
			$_type_description = [];

			foreach ( $rows as $row ) {
				$_type[ $row["id"] ]             = $row["name"];
				$_type_description[ $row["id"] ] = $row["description"];
			}

			$js_content .= "var Jobtype=";
			$string     = json_encode( $_type );
			$js_content .= $string . $newLine;

			$js_content .= "var JobtypeDescription=";
			$string     = json_encode( $_type_description );
			$js_content .= $string . $newLine;
		}

		// get job Sticker
		$rows = $this->db->select( 'id,jobcode,address1,postcode' )
		                 ->order_by( 'id', 'ASC' )
		                 ->get( 'jobs' )
		                 ->result_array();
		if ( ! empty( $rows ) ) {
			$_jobcode      = [];
			$_job_address  = [];
			$_job_postcode = [];

			foreach ( $rows as $row ) {
				$_jobcode[ $row["id"] ]      = $row["jobcode"];
				$_job_address[ $row["id"] ]  = $row["address1"];
				$_job_postcode[ $row["id"] ] = $row["postcode"];
			}

			// get job address
			$js_content .= "var JobAddress=";
			$string     = json_encode( $_job_address );
			$js_content .= $string . $newLine;

			// get job postcode
			$js_content .= "var JobPostCode=";
			$string     = json_encode( $_job_postcode );
			$js_content .= $string . $newLine;

			// get jobcode
			$js_content .= "var JobCode=";
			$string     = json_encode( $_jobcode );
			$js_content .= $string . $newLine;
		}

		if ( is_file( ROOT_PATH . "assets/js/staff.js" ) ) {
			@unlink( ROOT_PATH . "assets/js/staff.js" );
		}
		if ( file_put_contents( ROOT_PATH . "assets/js/staff.js", $js_content ) === false ) {
			debug( "staff.js not created!" );
		}

		exit();
	}

}