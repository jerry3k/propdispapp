<?php
if ( ! defined( 'BASEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class Profile_model extends CI_Model {

	var $Table = 'admins';

	public function __construct() {
		parent::__construct();
	}

	public function change_password( $params = '' ) {
		$default = [
			"id"           => "0",
			"old_password" => "",
			"password"     => "",
		];
		$params  = General::set_args( $params, $default );

		if ( empty( $params['id'] ) ) {
			return 'Please provide user id.';
		}
		if ( empty( $params['old_password'] ) ) {
			return 'Please provide old password.';
		}
		if ( empty( $params['password'] ) ) {
			return 'Please provide New password.';
		}
		// get user old password
		$row = $this->db->select( 'password' )->where( 'id', $params['id'] )->get( $this->Table )->row_array();
		if ( ! password_verify( $params['old_password'], $row['password'] ) ) {
			return ( "Invalid old password, Please provide correct password or contact management." );
		}

		unset( $params['old_password'] );

		$params["password"] = password_hash( $params["password"], PASSWORD_BCRYPT );

		$this->db->update( $this->Table, $params, [ 'id' => $params['id'] ] );

		return ( $this->db->affected_rows() != 1 ) ? $this->db->last_query() : 'OK';
	}

	public function upload_profile_image( $params = '', $files = [] ) {
		$default = [
			"id" => "0",
		];
		$image   = [];
		$params  = General::set_args( $params, $default );

		if ( empty( $params['id'] ) ) {
			return 'Please provide user id.';
		}
		if ( empty( $files['profile_image'] ) ) {
			return 'Please provide correct image file.';
		} else {
			$image = $files['profile_image'];
		}
		if ( ! empty( $image['error'] ) || $image['error'] > 0 ) {
			return 'Invalid file upload only image file are uploaded.';
		}

		if ( ! empty( $image ) ) {
			$folder_path = ROOT_PATH . 'contents/admins/';
			if ( ! is_dir( $folder_path ) ) {
				mkdir( $folder_path );
			}
			$folder_path = $folder_path . $params['id'];
			if ( ! is_dir( $folder_path ) ) {
				mkdir( $folder_path );
			}
		}

		if ( isset( $image['error'] ) && $image['error'] == 0 ) {
			// remove all previous file
			General::rrmdir( $folder_path );
			$name = trim( str_replace( '_', ' ', $image['name'] ) );
			$name = preg_replace( '!\s+!', ' ', $name );
			$name = str_replace( ' ', '_', $name );
			if ( ! is_dir( $folder_path ) ) {
				mkdir( $folder_path );
			}
			move_uploaded_file( $image['tmp_name'], $folder_path . '/' . $name );
		}

		return 'OK';
	}


}