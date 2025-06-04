<?php
if ( ! defined( 'BASEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class Jobtype_model extends CI_Model {

	var $Table = 'jobtype';

	public function __construct() {
		parent::__construct();
	}

	/**
	 * @param string $params
	 * Get staff data
	 *
	 * @return mixed
	 */
	public function get_jobtype( $params = '' ) {
		$default = [
			'id'       => '',
			'name'     => '',
			'price'    => '',
			'status'   => '',
			'orderby'  => 'name',
			'order'    => 'ASC',
			'search'   => '',
			'page'     => '1',
			'pagesize' => '5',
		];
		$params  = General::set_args( $params, $default );

		if ( ! empty( $params['id'] ) ) {
			$this->db->where( 'id', $params['id'] );
		}
		if ( ! empty( $params['name'] ) ) {
			$this->db->where( 'name', $params['name'] );
		}
		if ( ! empty( $params['price'] ) ) {
			$this->db->where( 'price', $params['price'] );
		}
		if ( isset( $params['status'] ) && $params['status'] <> '' ) {
			$this->db->where( 'status', $params['status'] );
		}
		if ( isset( $params['search'] ) && $params['search'] <> '' ) {
			$search = $this->security->xss_clean( $params['search'] );
			if ( strtolower( substr( $search, 0, 3 ) ) == "id:" ) {
				$ids = General::make_array( substr( $search, 3 ) );
				$this->db->where_in( 'id', $ids );
			} else {
				$this->db->group_start();
				$this->db->like( 'name', $search );
				$this->db->or_like( 'description', $search );
				$this->db->or_like( 'price_a', $search );
				$this->db->or_like( 'price_b', $search );
				$this->db->or_like( 'status', $search );
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
			if ( ! empty( $params['name'] ) ) {
				$this->db->where( 'name', $params['name'] );
			}
			if ( ! empty( $params['status'] ) ) {
				$this->db->where( 'status', $params['status'] );
			}
			if ( isset( $params['search'] ) && $params['search'] <> '' ) {
				$search = $this->security->xss_clean( $params['search'] );
				if ( strtolower( substr( $search, 0, 3 ) ) == "id:" ) {
					$ids = General::make_array( substr( $search, 3 ) );
					$this->db->where_in( 'id', $ids );
				} else {
					$this->db->group_start();
					$this->db->like( 'name', $search );
					$this->db->or_like( 'description', $search );
					$this->db->or_like( 'price_a', $search );
					$this->db->or_like( 'price_b', $search );
					$this->db->or_like( 'status', $search );
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
	 * Save jobtype data
	 *
	 * @return string
	 */
	public function save( $params = '' ) {
		$default = [
			'id'         => '0',
			'name'       => '',
			'price_a'    => '0',
			'price_b'    => '0',
			'discount'   => '0',
			'print_name' => 'N',
			'position'   => 'N',
		];
		$params  = General::set_args( $params, $default );
		$last_id = 0;

//		General::show_array( $params );
//		die;

		if ( empty( $params['name'] ) ) {
			return 'Name field is required.';
		} else {
			$array = [
				'id <>' => $params['id'],
				'name'  => $params['name'],
			];
			// check duplicate name
			$check_name = $this->db->where( $array )->get( $this->Table )->num_rows();
			if ( ! empty( $check_name ) ) {
				return 'Job type name already exits (' . $params['name'] . ')';
			}
		}
		if ( ! isset( $params['price_a'] ) ) {
			return 'Price A field is required.';
		}
		if ( ! isset( $params['price_a'] ) ) {
			return 'Price A field is required.';
		}

		$params['added_ip']   = General::myip();
		$params['added_by']   = Users::get_my_id();
		$params['added_time'] = MyDateTime::mysql_datetime();

		if ( empty( $params['id'] ) ) {
			unset( $params['id'] );
			$params['status'] = 1;
			// insert data into database
			$this->db->insert( $this->Table, $params );
			$last_id = $this->db->insert_id();
		} else {
			// update data into database
			$last_id = $params['id'];
			$this->db->update( $this->Table, $params, [ 'id' => $params['id'] ] );
		}

		return ( $this->db->affected_rows() != 1 ) ? $this->db->last_query() : 'OK.' . $last_id;
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
			'id'     => '0',
			'status' => '0',
		];
		$params  = General::set_args( $params, $default );

		if ( empty( $params['id'] ) ) {
			return 'Id missing.';
		}

		// General::show_array( $params );

		$this->db->update( $this->Table, $params, [ 'id' => $params['id'] ] );

		return ( $this->db->affected_rows() != 1 ) ? $this->db->last_query() : 'OK';
	}

}