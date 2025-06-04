<?php

/**
 * Created by PhpStorm.
 * User: NASIR
 * Date: 15-Nov-18
 * Time: 11:52 AM
 */
class Users {

	/**
	 * This public static function returns true if user is logged in admin panel
	 *
	 * @return bool
	 */
	public static function is_login() {
		if ( ! isset( $_SESSION['admin_row'] ) && ! empty( $_COOKIE['admin_cookie_id'] ) ) {
			$DB   = get_instance();
			$rows = $DB->db->select( 'id,username,email' )
			               ->where( "id", $_COOKIE['admin_cookie_id'] )
			               ->get( 'admins' )
			               ->result_array();
			if ( empty( $rows ) ) {
				return false;
			}
			$row = $rows[0];
			if ( isset( $row['username'] ) ) {
				$_SESSION['admin_row'] = $row;

				return true;
			}
		}

		if ( ! isset( $_SESSION['admin_row'] ) ) {
			return false;
		}
		if ( ! is_array( $_SESSION['admin_row'] ) ) {
			return false;
		}

		return isset( $_SESSION['admin_row'] );
	}


	/**
	 * @return bool
	 *
	 * Check if current device is mobile device or not.
	 */
	public static function is_mobile() {
		$DB     = get_instance();
		$mobile = $DB->agent->is_mobile();
		if ( $mobile ) {
			return true;
		}

		return false;
	}

	/**
	 * @return bool
	 *
	 * Check if plate form
	 */
	public static function platform() {
		$DB       = get_instance();
		$platform = $DB->agent->platform();
		if ( $platform ) {
			return $platform;
		}

		return false;
	}

	/**
	 * @param string $id
	 * Get admin username
	 *
	 * @return array|bool
	 */
	public static function get_username( $id = '' ) {
		if ( empty( $id ) ) {
			return false;
		}

		$DB = get_instance();

		$row = $DB->db->select( 'username' )->where( 'id', $id )->get( 'admins' )->row_array();
		if ( empty( $row ) ) {
			return false;
		}

		return $row['username'];
	}

	public static function get_email_name( $email = '' ) {
		if ( empty( $email ) ) {
			return false;
		}

		$DB = get_instance();

		$row = $DB->db->select( 'username' )->where( 'email', $email )->get( 'admins' )->row_array();
		if ( empty( $row ) ) {
			return false;
		}

		return $row['username'];
	}

	/**
	 * @param string $id
	 * Get admin email
	 *
	 * @return array|bool
	 */
	public static function get_email( $id = '' ) {
		if ( empty( $id ) ) {
			return false;
		}

		$DB = get_instance();

		$row = $DB->db->select( 'email' )->where( 'id', $id )->get( 'admins' )->row_array();
		if ( empty( $row ) ) {
			return false;
		}

		return $row['email'];
	}

	/**
	 * @return int
	 * Get admin login id
	 */
	public static function get_my_id() {
		if ( ! isset( $_SESSION['admin_row'] ) ) {
			return 0;
		}

		$session = $_SESSION['admin_row'];
		if ( ! empty( $session['id'] ) ) {
			return (int) $session['id'];
		}

		return 0;
	}


	/**
	 * @param int $id
	 *
	 * @return bool
	 *
	 * Check is admin account is administrator or not
	 */
	public static function is_admin( $id = 0 ) {
		$id = (int) $id;

		if ( empty( $id ) ) {
			$id = self::get_my_id();
		}

		$DB    = get_instance();
		$array = [
			'id'        => $id,
			'type'      => 'admin',
			'is_active' => 1,
		];
		$row   = $DB->db->select( 'is_admin' )->where( $array )->get( 'admins' )->row_array();

		if ( ! empty( $row ) && $row['is_admin'] == 1 ) {
			return true;
		}

		return false;
	}

	/**
	 * @param int $id
	 * Check is client account or not
	 *
	 * @return bool
	 */
	public static function is_client( $id = 0 ) {
		$id = (int) $id;

		if ( empty( $id ) ) {
			$id = self::get_my_id();
		}

		$DB    = get_instance();
		$array = [
			'id'        => $id,
			'type'      => 'client',
			'is_active' => 1,
		];
		$row   = $DB->db->select( 'type' )->where( 'id', $id )->get( 'admins' )->row_array();

		if ( ! empty( $row ) && $row['type'] == 'client' ) {
			return true;
		}

		return false;
	}

	/**
	 * @param string $id
	 * Get job name
	 *
	 * @return bool
	 */
	public static function get_jobname( $id = '' ) {
		if ( empty( $id ) ) {
			return false;
		}

		$DB = get_instance();

		$row = $DB->db->select( 'name' )->where( 'id', $id )->get( 'jobtype' )->row_array();
		if ( empty( $row ) ) {
			return false;
		}

		return $row['name'];
	}

	public static function get_client_phone( $id = '' ) {
		if ( empty( $id ) ) {
			return false;
		}

		$DB = get_instance();

		$row = $DB->db->select( 'phone' )->where( 'id', $id )->get( 'admins' )->row_array();
		if ( empty( $row ) ) {
			return false;
		}

		return $row['phone'];
	}

	public static function get_client_address( $id = '' ) {
		if ( empty( $id ) ) {
			return false;
		}

		$DB = get_instance();

		$row = $DB->db->select( 'address1' )->where( 'id', $id )->get( 'admins' )->row_array();
		if ( empty( $row ) ) {
			return false;
		}

		return $row['address1'];
	}

	public static function get_job_address( $id = '' ) {
		if ( empty( $id ) ) {
			return false;
		}

		$DB = get_instance();

		$row = $DB->db->select( 'address1' )->where( 'id', $id )->get( 'jobs' )->row_array();
		if ( empty( $row ) ) {
			return false;
		}

		return $row['address1'];
	}

	public static function get_client_jobCode( $id = '' ) {
		if ( empty( $id ) ) {
			return false;
		}

		$DB = get_instance();

		$row = $DB->db->select( 'jobcode' )->where( 'id', $id )->get( 'jobs' )->row_array();
		if ( empty( $row ) ) {
			return false;
		}

		return $row['jobcode'];
	}

	public static function get_user_account_type( $id = '' ) {
		if ( empty( $id ) ) {
			return false;
		}

		$DB = get_instance();

		$row = $DB->db->select( 'type' )->where( 'id', $id )->get( 'admins' )->row_array();
		if ( empty( $row ) ) {
			return false;
		}

		return $row['type'];
	}

}