<?php
if ( ! defined( 'BASEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class Login_model extends CI_Model {

	var $Table = 'admins';

	public function __construct() {
		parent::__construct();
	}

	public function login_validation_check( $params = '' ) {
		$default = [
			"email"    => "",
			"password" => "",
			"remember" => "0",
		];
		$params  = General::set_args( $params, $default );
		if ( empty( $params['email'] ) ) {
			return 'Please type your email address.';
		} else {
			if ( ! filter_var( $params['email'], FILTER_VALIDATE_EMAIL ) ) {
				return ( $params['email'] . " is not a valid email address." );
			}
		}
		if ( empty( $params['password'] ) ) {
			return 'Please type your password.';
		}
		// check email
		$row = $this->db->select( 'id,username,email,password,is_login' )
		                ->where( 'email', $params['email'] )
		                ->get( $this->Table )
		                ->result_array();
		if ( empty( $row ) ) {
			return 'User not found in our system';
		}
		$row = $row[0];
		// check user active
		$is_active = $this->db->select( 'is_active' )->where( 'is_active', 1 )->get( $this->Table )->num_rows();
		if ( empty( $is_active ) ) {
			return ( "User '" . $params['email'] . "' is not Activated by Administrator Please Contact your Administrator." );
		}
		if ( $params['password'] <> md5( $row['password'] ) ) {
			if ( ! password_verify( $params['password'], $row['password'] ) ) {
				return ( "Invalid password, Please provide correct password or contact management." );
			}
		}


		// delete previous cookie data.
		$cookie = $this->input->cookie( 'admin_cookie_id' );
		if ( isset( $cookie ) ) {
			$cookie = array(
				'name'   => 'admin_cookie_id',
				'value'  => '',
				'expire' => '0',
			);
			delete_cookie( $cookie );
		}
		if ( ! empty( $params['remember'] ) && $params['remember'] == 1 ) {
			//           seconds * minutes * hours * days + current time
			$expire = 60 * 60 * 24 * 1000;
			$this->input->set_cookie( 'admin_cookie_id', $row['id'], $expire );
		}
		// set user session id
		$array = [
			'id'       => $row['id'],
			'username' => $row['username'],
			'email'    => $row['email'],
		];
		$this->session->set_userdata( 'admin_row', $array );

		// check is login before
		if ( empty( $row['is_login'] ) ) {
			$this->db->update( $this->Table, [ 'is_login' => 1 ], [ 'id' => $row['id'] ] );
		}

		return 'OK';
	}

	public function forgetpassword( $params = '' ) {
		$default = [
			"email" => "",
		];
		$params  = General::set_args( $params, $default );
		if ( empty( $params['email'] ) ) {
			return 'Please type your email address.';
		} else {
			if ( ! filter_var( $params['email'], FILTER_VALIDATE_EMAIL ) ) {
				return ( $params['email'] . " is not a valid email address." );
			}
		}

		$md5  = base64_encode( $params['email'] );
		$name = Users::get_email_name( $params['email'] );

		$html = 'Hi ' . $name . ',<br><br>';
		$html .= "You've requested password reset request, Click on link below to reset your password.";
		$html .= "<br><br>";
		$html .= "<a href='" . DOMAIN_URL . "login/resetpassword/" . $md5 . "'>Reset Password?</a>";
		$html .= "<br><br>";
		$html .= "Regards";

		send_mail( $params['email'], 'Property Display: Reset your password', $html );

		return 'OK';
	}

	public function update_password( $params = '' ) {
		$default = [
			"email"    => "",
			"password" => "",
		];
		$params  = General::set_args( $params, $default );
		if ( empty( $params['password'] ) ) {
			return 'Password field is required.';
		}
		if ( empty( $params['email'] ) ) {
			return 'Please type your email address.';
		} else {
			if ( ! filter_var( $params['email'], FILTER_VALIDATE_EMAIL ) ) {
				return ( $params['email'] . " is not a valid email address." );
			}
		}

		// check if user exitx
		$check_email = $this->db->where( 'email', $params['emai'] )->get( $this->Table )->num_rows();

		if ( empty( $check_email ) ) {
			return 'Your email account not exist in our system';
		}

		$array["password"] = password_hash( $params['password'], PASSWORD_BCRYPT );

		$this->db->update( $this->Table, $array, [ 'email' => $params['email'] ] );

		return 'OK';
	}

}