<?php
if ( ! defined( 'BASEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class Staff_model extends CI_Model {

	var $Table = 'admins';

	public function __construct() {
		parent::__construct();
	}

	/**
	 * @param string $params
	 * Get staff data
	 *
	 * @return mixed
	 */
	public function get_staff( $params = '' ) {
		$default = [
			'id'        => '',
			'email'     => '',
			'username'  => '',
			'is_active' => '',
			'type'      => '',
			'orderby'   => 'id',
			'order'     => 'DESC',
			'search'    => '',
			'page'      => '1',
			'pagesize'  => '5',
		];
		$params  = General::set_args( $params, $default );

		if ( ! empty( $params['id'] ) ) {
			$this->db->where( 'id', $params['id'] );
		}
		if ( ! empty( $params['email'] ) ) {
			$this->db->where( 'email', $params['email'] );
		}
		if ( ! empty( $params['username'] ) ) {
			$this->db->where( 'username', $params['username'] );
		}
		if ( isset( $params['is_active'] ) && $params['is_active'] <> '' ) {
			$this->db->where( 'is_active', $params['is_active'] );
		}
		if ( isset( $params['type'] ) && $params['type'] <> '' ) {
			$this->db->where( 'type', $params['type'] );
		}
		if ( ! empty( $params['search'] ) ) {
			$search = $this->security->xss_clean( $params['search'] );
			if ( strtolower( substr( $search, 0, 3 ) ) == "id:" ) {
				$ids = General::make_array( substr( $search, 3 ) );
				$this->db->where_in( 'id', $ids );
			} else {
				$this->db->group_start();
				$this->db->like( 'username', $search );
				$this->db->or_like( 'phone', $search );
				$this->db->or_like( 'email', $search );
				$this->db->or_like( 'type', $search );
				$this->db->group_end();
			}
		}

		$this->db->order_by( $params['orderby'], $params['order'] );

		// get page and pagesize
		$offset = ( $params['page'] * $params['pagesize'] );
		$limit  = ( $offset - $params['pagesize'] ) + 1;
		if ( isset( $limit ) && $limit <= 1 ) {
			$limit = 0;
		} else {
			$offset = $offset - 1; // page row display 1-10
			$limit  = $limit - 1; // start which number to load data
		}

		// get query result
		$query["rows"] = $this->db->get( $this->Table, $params['pagesize'], $limit )->result_array();

		if ( ! empty( $query ) ) {
			if ( ! empty( $params['type'] ) ) {
				$this->db->where( 'type', $params['type'] );
			}
			if ( isset( $params['is_active'] ) && $params['is_active'] <> '' ) {
				$this->db->where( 'is_active', $params['is_active'] );
			}
			if ( ! empty( $params['search'] ) ) {
				$search = $this->security->xss_clean( $params['search'] );
				if ( strtolower( substr( $search, 0, 3 ) ) == "id:" ) {
					$ids = General::make_array( substr( $search, 3 ) );
					$this->db->where_in( 'id', $ids );
				} else {
					$this->db->group_start();
					$this->db->like( 'username', $search );
					$this->db->or_like( 'phone', $search );
					$this->db->or_like( 'email', $search );
					$this->db->or_like( 'type', $search );
					$this->db->group_end();
				}
			}
			// get total number of record
			$total_records = $this->db->get( $this->Table )->num_rows();
			$pages         = ceil( $total_records / $params['pagesize'] );
			if ( $pages == 0 ) {
				$pages = 1;
			}
			if ( empty( $query["rows"] ) ) {
				$total_records = 0;
			}
			$query["page"]          = $params['page'];
			$query["pages"]         = $pages;
			$query["pagesize"]      = $offset;
			$query["total_records"] = $total_records;
		} else {
			$query["page"]          = 1;
			$query["pages"]         = 1;
			$query["pagesize"]      = 10;
			$query["total_records"] = 0;
		}

		return $query;
	}

	/**
	 * @param string $params
	 * Save staff data
	 *
	 * @return string
	 */
	public function save( $params = '' ) {
		$default = [
			'id'       => '0',
			'username' => '',
			'email'    => '',
			'phone'    => '',
			'type'     => '',
			'is_admin' => '0',
			'profile'  => '',
		];
		$params  = General::set_args( $params, $default );
		$last_id = 0;
		$array   = [];
		if ( empty( $params['type'] ) ) {
			return 'Please choose user type.';
		}
		if ( isset( $params['type'] ) && $params['type'] == 'fitter' ) {
			$params['username'] = $params['email'];
			unset( $params['email'] );
		} else {
			if ( empty( $params['email'] ) ) {
				return 'Email field is required.';
			} else {
				if ( ! filter_var( $params['email'], FILTER_VALIDATE_EMAIL ) ) {
					return ( $params['email'] . " is not a valid email address." );
				}
				$array = [
					'id <>' => $params['id'],
					'email' => $params['email'],
				];
				// check duplicate email name
				$check_email = $this->db->where( $array )->get( $this->Table )->num_rows();
				if ( ! empty( $check_email ) ) {
					return 'Email already exits (' . $params['email'] . ')';
				}
			}
			if ( empty( $params['phone'] ) ) {
				return 'Please type your phone number.';
			}
		}
		// client area section
		if ( ! empty( $params['type'] ) && $params['type'] == 'client' && empty( $params['profile'] ) ) {
			if ( empty( $params['telephone'] ) ) {
				return 'Telephone number field is required.';
			}
			if ( empty( $params['email_contact'] ) ) {
				return 'Email Contact field is required.';
			} else {
				if ( ! filter_var( $params['email_contact'], FILTER_VALIDATE_EMAIL ) ) {
					return ( 'Email Contact ' . $params['email_contact'] . ' is not a valid email address.' );
				}
			}
			if ( empty( $params['fsb_let_bd'] ) ) {
				return 'FSB / TO LET BD field is required.';
			}
			if ( empty( $params['address1'] ) ) {
				return 'Address field is required.';
			}
			if ( empty( $params['country'] ) ) {
				return 'Please select a country.';
			}
			if ( empty( $params['city'] ) ) {
				return 'Please select a city.';
			}
			if ( empty( $params['pricing_system'] ) ) {
				return 'Pricing System field is required.';
			}
		} else {
			unset( $params['fsb_let_bd'], $params['country'] );
		}

		unset( $params['profile'] , $params['latitude'] , $params['longitude'] );
		$params['added_by']   = Users::get_my_id();
		$params['added_time'] = MyDateTime::mysql_datetime();
		$params['added_ip']   = General::myip();

		if ( empty( $params['id'] ) ) {
			unset( $params['id'] );
			$params['is_active'] = 1;
			$params["password"]  = password_hash( General::make_password(), PASSWORD_BCRYPT );
			// insert data into database
			$this->db->insert( $this->Table, $params );
			$last_id = $this->db->insert_id();
		} else {
			// update data into database
			$last_id = $params['id'];
			$this->db->update( $this->Table, $params, [ 'id' => $params['id'] ] );
		}

		return ( $this->db->affected_rows() != 1 ) ? $this->db->last_query() : 'OK,' . $last_id;
	}

	/**
	 * @param string $params
	 * Delete staff data
	 *
	 * @return string
	 */
	public function delete( $params = '' ) {
		$default = [
			'id' => '0',
		];
		$params  = General::set_args( $params, $default );

		if ( empty( $params['id'] ) ) {
			return 'User id missing.';
		}

		$this->db->delete( $this->Table, [ 'id' => $params['id'] ] );

		return ( $this->db->affected_rows() != 1 ) ? $this->db->last_query() : 'OK';
	}

	/**
	 * @param string $params
	 * Status change active or deactive
	 *
	 * @return string
	 */
	public function status( $params = '' ) {
		$default = [
			'id'        => '0',
			'is_active' => 0,
		];
		$params  = General::set_args( $params, $default );

		if ( empty( $params['id'] ) ) {
			return 'User id missing.';
		}

		$this->db->update( $this->Table, $params, [ 'id' => $params['id'] ] );

		return ( $this->db->affected_rows() != 1 ) ? $this->db->last_query() : 'OK';
	}


	public function send_email( $params = '' ) {
		$default = [
			'id'      => '0',
			'email'   => '',
			'subject' => '',
			'message' => '',
		];
		$params  = General::set_args( $params, $default );

		if ( empty( $params['id'] ) ) {
			return 'User id missing.';
		}
		if ( empty( $params['email'] ) ) {
			return 'Email field is required.';
		}
		if ( empty( $params['subject'] ) ) {
			return 'Subject field is required.';
		}

		$make_password = General::make_password();
		$update        = [
			'password' => password_hash( $make_password, PASSWORD_BCRYPT ),
		];
		$this->db->update( $this->Table, $update, [ 'id' => $params['id'] ] );

		$html = 'Hi ' . Users::get_username( $params['id'] ) . ',';
		$html .= '<br>';
		$html .= $params['message'];
		$html .= '<br><br>';
		$html .= 'Here is your login information:';
		$html .= '<br>';
		$html .= 'Username: ' . $params['email'];
		$html .= '<br>';
		$html .= 'Password: ' . $make_password;
		$html .= '<br><br>';
		$html .= 'Login URL <a href="' . DOMAIN_URL . 'login">PropertyDisplay</a>';

		send_mail( $params['email'], $params['subject'], $html );

		return 'OK';
	}

}