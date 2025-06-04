<?php
if ( ! defined( 'BASEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class Jobs_model extends CI_Model {

	var $Table = 'jobs';
	var $Table2 = 'invoice';
	var $TableSubJob = 'subjobs';

	public function __construct() {
		parent::__construct();
	}

	public function get_jobs_with_client_view( $params = '' ) {
		$default = [
			'id'        => '',
			'orderby'   => 'id',
			'order'     => 'DESC',
			'search'    => '',
			'page'      => '1',
			'pagesize'  => '10',
			'postcode'  => '',
			'time_to'   => '',
			'time_from' => '',
			'client_id' => '',
		];
		$params  = General::set_args( $params, $default );

		//  General::show_array( $params );
		//  die;

		if ( ! empty( $params['id'] ) ) {
			$this->db->where_in( 'id', General::make_array( $params['id'] ) );
		}
		if ( ! empty( $params['client_id'] ) ) {
			$this->db->where( 'client_id', $params['client_id'] );
		}
		if ( ! empty( $params['postcode'] ) ) {
			$this->db->where_in( 'postcode', General::make_array( $params['postcode'] ) );
		}
		if ( isset( $params['time_from'] ) && $params['time_from'] <> '' ) {
			$from = MyDateTime::mysql_date( $params['time_from'] );
			$to   = MyDateTime::mysql_date( $params['time_to'] );
			$this->db->where( "DATE(`date_done`) BETWEEN '$from' AND '$to'" );
		}
		if ( ! empty( $params['search'] ) ) {
			$search = $this->security->xss_clean( $params['search'] );
			if ( strtolower( substr( $search, 0, 3 ) ) == "id:" ) {
				$ids = General::make_array( substr( $search, 3 ) );
				$this->db->where_in( 'id', $ids );
			} else {
				$this->db->group_start();
				$this->db->like( 'customer_name', $search );
				$this->db->or_like( 'jobcode', $search );
				$this->db->or_like( 'address1', $search );
				$this->db->or_like( 'address2', $search );
				$this->db->or_like( 'address3', $search );
				$this->db->or_like( 'country', $search );
				$this->db->or_like( 'city', $search );
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

		//		echo $this->db->last_query();
		//		die;

		if ( ! empty( $query ) ) {
			foreach ( $query["rows"] as $k => $row ) {
				$query["rows"][ $k ]['subjobs'] = $this->db->where( 'jobid', $row['id'] )
				                                           ->get( $this->TableSubJob )
				                                           ->result_array();
			}
			if ( ! empty( $params['id'] ) ) {
				$this->db->where_in( 'id', General::make_array( $params['id'] ) );
			}
			if ( ! empty( $params['client_id'] ) ) {
				$this->db->where( 'client_id', $params['client_id'] );
			}
			if ( ! empty( $params['postcode'] ) ) {
				$this->db->where_in( 'postcode', General::make_array( $params['postcode'] ) );
			}
			if ( isset( $params['time_from'] ) && $params['time_from'] <> '' ) {
				$from = MyDateTime::mysql_date( $params['time_from'] );
				$to   = MyDateTime::mysql_date( $params['time_to'] );
				$this->db->where( "DATE(`date_done`) BETWEEN '$from' AND '$to'" );
			}
			if ( ! empty( $params['search'] ) ) {
				$search = $this->security->xss_clean( $params['search'] );
				if ( strtolower( substr( $search, 0, 3 ) ) == "id:" ) {
					$ids = General::make_array( substr( $search, 3 ) );
					$this->db->where_in( 'id', $ids );
				} else {
					$this->db->group_start();
					$this->db->like( 'customer_name', $search );
					$this->db->or_like( 'jobcode', $search );
					$this->db->or_like( 'address1', $search );
					$this->db->or_like( 'address2', $search );
					$this->db->or_like( 'address3', $search );
					$this->db->or_like( 'country', $search );
					$this->db->or_like( 'city', $search );
					$this->db->group_end();
				}
			}

			// get total number of record
			$total_records = $this->db->get( $this->Table )->num_rows();
			$pages         = ceil( $total_records / $params['pagesize'] );
			if ( $pages == 0 ) {
				$pages = 1;
			}
			if ( empty( $query['rows'] ) ) {
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

	public function get_jobs_with_subtypes( $params = '' ) {
		$default = [
			'id'        => '',
			'orderby'   => 'id',
			'order'     => 'DESC',
			'search'    => '',
			'page'      => '1',
			'pagesize'  => '10',
			'postcode'  => '',
			'time_to'   => '',
			'time_from' => '',
			'job_type'  => '',
			'client_id' => '',
			'fitter_id' => '',
		];
		$params  = General::set_args( $params, $default );
		//		General::show_array( $params );
		//		die;

		$this->db->select( '
		j.client_id,
		j.jobcode,
		j.address1,
		j.address2,
		j.address3,
		j.sticker,
		j.city,
		j.country,
		j.postcode, 
		s.*' )->from( 'subjobs as s' )->join( 'jobs j', 'j.id = s.jobid' );

		if ( ! empty( $params['id'] ) ) {
			$this->db->where_in( '`s.id`', General::make_array( $params['id'] ) );
		}
		if ( ! empty( $params['client_id'] ) ) {
			$this->db->where_in( '`j.client_id`', General::make_array( $params['client_id'] ) );
		}
		if ( isset( $params['fitter_id'] ) && $params['fitter_id'] <> '' ) {
			$this->db->where_in( '`s.fitter_id`', General::make_array( $params['fitter_id'] ) );
		}
		if ( isset( $params['job_type'] ) && $params['job_type'] <> '' ) {
			$this->db->where_in( '`s.jobtypeid`', General::make_array( $params['job_type'] ) );
		}

		if ( isset( $params['time_from'] ) && $params['time_from'] <> '' ) {
			$to   = MyDateTime::mysql_date( $params['time_to'] );
			$from = MyDateTime::mysql_date( $params['time_from'] );
			$this->db->where( "`s.job_date` BETWEEN '$from' AND '$to'" );
		}

		if ( ! empty( $params['search'] ) ) {
			$search = $this->security->xss_clean( $params['search'] );
			if ( strtolower( substr( $search, 0, 3 ) ) == "id:" ) {
				$ids = General::make_array( substr( $search, 3 ) );
				$this->db->where_in( '`s.id`', $ids );
			} else {
				$this->db->group_start();
				$this->db->like( '`j.jobcode`', $search );
				$this->db->or_like( '`j.city`', $search );
				$this->db->or_like( '`s.name`', $search );
				$this->db->or_like( '`j.sticker`', $search );
				$this->db->or_like( '`j.address1`', $search );
				$this->db->or_like( '`s.position`', $search );
				$this->db->or_like( '`j.postcode`', $search );
				$this->db->group_end();
			}
		}

		// get page and pagesize
		$offset = ( $params['page'] * $params['pagesize'] );
		$limit  = ( $offset - $params['pagesize'] ) + 1;
		if ( isset( $limit ) && $limit <= 1 ) {
			$limit = 0;
		} else {
			$offset = $offset - 1; // page row display 1-10
			$limit  = $limit - 1; // start which number to load data
		}

		// combine two table `jobs` , `subjobs`
		$query['rows'] = $this->db->group_by( 'id' )
		                          ->order_by( $params['orderby'], $params['order'] )
		                          ->get( $this->TableSubJob, $params['pagesize'], $limit )
		                          ->result_array();
		//
		//				echo $this->db->last_query();
		//				die;

		if ( ! empty( $query ) ) {

			$this->db->select( '
		j.client_id,
		j.jobcode,
		j.address1,
		j.address2,
		j.address3,
		j.sticker,
		j.city,
		j.country,
		j.postcode, 
		s.*' )->from( 'subjobs as s' )->join( 'jobs j', 'j.id = s.jobid' );

			if ( ! empty( $params['id'] ) ) {
				$this->db->where_in( '`s.id`', General::make_array( $params['id'] ) );
			}
			if ( ! empty( $params['client_id'] ) ) {
				$this->db->where_in( '`j.client_id`', General::make_array( $params['client_id'] ) );
			}
			if ( isset( $params['fitter_id'] ) && $params['fitter_id'] <> '' ) {
				$this->db->where_in( '`s.fitter_id`', General::make_array( $params['fitter_id'] ) );
			}
			if ( isset( $params['job_type'] ) && $params['job_type'] <> '' ) {
				$this->db->where_in( '`s.jobtypeid`', General::make_array( $params['job_type'] ) );
			}
			if ( isset( $params['time_from'] ) && $params['time_from'] <> '' ) {
				$to   = MyDateTime::mysql_date( $params['time_to'] );
				$from = MyDateTime::mysql_date( $params['time_from'] );
				$this->db->where( "`s.added_time` BETWEEN '$from' AND '$to'" );
			}
			if ( ! empty( $params['search'] ) ) {
				$search = $this->security->xss_clean( $params['search'] );
				if ( strtolower( substr( $search, 0, 3 ) ) == "id:" ) {
					$ids = General::make_array( substr( $search, 3 ) );
					$this->db->where_in( '`s.id`', $ids );
				} else {
					$this->db->group_start();
					$this->db->like( '`j.jobcode`', $search );
					$this->db->or_like( '`j.sticker`', $search );
					$this->db->or_like( '`j.address1`', $search );
					$this->db->or_like( '`j.city`', $search );
					$this->db->or_like( '`j.postcode`', $search );
					$this->db->group_end();
				}
			}

			$this->db->group_by( 'id' )->order_by( $params['orderby'], $params['order'] );

			// get total number of record
			$total_records = $this->db->get( $this->TableSubJob )->num_rows();
			$pages         = ceil( $total_records / $params['pagesize'] );
			if ( $pages == 0 ) {
				$pages = 1;
			}
			if ( empty( $query['rows'] ) ) {
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
	 * Get staff data
	 *
	 * @return mixed
	 */
	public function get_jobs( $params = '' ) {
		$default = [
			'id'            => '',
			'customer_name' => '',
			'orderby'       => 'id',
			'order'         => 'DESC',
			'search'        => '',
			'page'          => '1',
			'pagesize'      => '5',
			'client_id'     => '',
			'job_status'    => '',
			'time_from'     => '',
			'time_to'       => '',
			'select'        => '',
			'group_by'      => '',
			'sticker'       => '',
			'fitter_id'     => '',
			'added_time'    => '',
			'job_type'      => '',
			'postcode'      => '',
		];
		$params  = General::set_args( $params, $default );

		//		General::show_array($params);
		//		die;
		$jobids    = '';
		$rowjobids = $this->db->select( 'id' )->like( 'name', $params['search'] )->get( 'jobtype' )->result_array();
		if ( ! empty( $rowjobids ) ) {
			$jobids = [];
			foreach ( $rowjobids as $jbid ) {
				$jobids[] = $jbid['id'];
			}
		}

		$fittersids   = '';
		$rowfitterids = $this->db->select( 'id' )
		                         ->like( 'username', $params['search'] )
		                         ->get( 'admins' )
		                         ->result_array();
		if ( ! empty( $rowfitterids ) ) {
			$fittersids = [];
			foreach ( $rowfitterids as $fitterid ) {
				$fittersids[] = $fitterid['id'];
			}
		}

		if ( isset( $params['select'] ) && $params['select'] <> '' ) {
			$this->db->select( $params['select'] );
		}
		if ( isset( $params['group_by'] ) && $params['group_by'] <> '' ) {
			$this->db->group_by( $params['group_by'] );
		}
		if ( ! empty( $params['id'] ) ) {
			$this->db->where_in( 'id', General::make_array( $params['id'] ) );
		}
		if ( isset( $params['job_status'] ) && $params['job_status'] <> '' ) {
			$this->db->where( 'job_status', $params['job_status'] );
		}

		if ( ! empty( $params['client_id'] ) ) {
			$this->db->where_in( 'client_id', General::make_array( $params['client_id'] ) );
		}
		if ( isset( $params['fitter_id'] ) && $params['fitter_id'] <> '' ) {
			$this->db->where_in( 'fitter_id', General::make_array( $params['fitter_id'] ) );
		}
		if ( ! empty( $params['job_type'] ) ) {
			$this->db->where_in( 'job_type', General::make_array( $params['job_type'] ) );
		}
		if ( ! empty( $params['postcode'] ) ) {
			$this->db->where_in( 'postcode', General::make_array( $params['postcode'] ) );
		}

		if ( isset( $params['sticker'] ) && $params['sticker'] <> '' ) {
			//$this->db->group_start()->where( 'sticker <>', null )->or_where( 'sticker <>', '' )->group_end();
			//$this->db->group_start()->where( 'sticker <>', null )->group_end();
			$this->db->where( 'sticker <>', '' );
		}
		if ( isset( $params['time_from'] ) && $params['time_from'] <> '' ) {
			$from = MyDateTime::mysql_date( $params['time_from'] );
			$to   = MyDateTime::mysql_date( $params['time_to'] );
			if ( isset( $params['added_time'] ) && $params['added_time'] <> '' ) {
				$this->db->where( "DATE(`added_time`) BETWEEN '$from' AND '$to'" );
			} else {
				$this->db->where( "DATE(`date_done`) BETWEEN '$from' AND '$to'" );
			}
		}
		if ( ! empty( $params['search'] ) ) {
			$search = $this->security->xss_clean( $params['search'] );
			if ( strtolower( substr( $search, 0, 3 ) ) == "id:" ) {
				$ids = General::make_array( substr( $search, 3 ) );
				$this->db->where_in( 'id', $ids );
			} else {
				$this->db->group_start();
				$this->db->like( 'customer_name', $search );
				$this->db->or_like( 'jobcode', $search );
				$this->db->or_like( 'address1', $search );
				$this->db->or_like( 'address2', $search );
				$this->db->or_like( 'address3', $search );
				$this->db->or_like( 'country', $search );
				$this->db->or_like( 'city', $search );
				// find job type
				$this->db->or_where_in( 'job_type', $jobids );
				// find fitter ids
				$this->db->or_where_in( 'fitter_id', $fittersids );
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

		//		echo $this->db->last_query();
		//		die;

		if ( ! empty( $query ) ) {
			if ( ! empty( $params['id'] ) ) {
				$this->db->where( 'id', $params['id'] );
			}
			if ( isset( $params['job_status'] ) && $params['job_status'] <> '' ) {
				$this->db->where( 'job_status', $params['job_status'] );
			}
			if ( isset( $params['sticker'] ) && $params['sticker'] <> '' ) {
				$this->db->group_start()->where( 'sticker <>', null )->or_where( 'sticker <>', '' )->group_end();
			}

			if ( ! empty( $params['client_id'] ) ) {
				$this->db->where_in( 'client_id', General::make_array( $params['client_id'] ) );
			}
			if ( isset( $params['fitter_id'] ) && $params['fitter_id'] <> '' ) {
				$this->db->where_in( 'fitter_id', General::make_array( $params['fitter_id'] ) );
			}
			if ( ! empty( $params['job_type'] ) ) {
				$this->db->where_in( 'job_type', General::make_array( $params['job_type'] ) );
			}

			if ( isset( $params['time_from'] ) && $params['time_from'] <> '' ) {
				$from = MyDateTime::mysql_date( $params['time_from'] );
				$to   = MyDateTime::mysql_date( $params['time_to'] );
				if ( isset( $params['added_time'] ) && $params['added_time'] <> '' ) {
					$this->db->where( "DATE(`added_time`) BETWEEN '$from' AND '$to'" );
				} else {
					$this->db->where( "DATE(`date_done`) BETWEEN '$from' AND '$to'" );
				}
			}
			if ( ! empty( $params['search'] ) ) {
				$search = $this->security->xss_clean( $params['search'] );
				if ( strtolower( substr( $search, 0, 3 ) ) == "id:" ) {
					$ids = General::make_array( substr( $search, 3 ) );
					$this->db->where_in( 'id', $ids );
				} else {
					$this->db->group_start();
					$this->db->like( 'customer_name', $search );
					$this->db->or_like( 'jobcode', $search );
					$this->db->or_like( 'address1', $search );
					$this->db->or_like( 'address2', $search );
					$this->db->or_like( 'address3', $search );
					$this->db->or_like( 'country', $search );
					$this->db->or_like( 'city', $search );
					$this->db->group_end();
				}
			}
			// get total number of record
			$total_records = $this->db->get( $this->Table )->num_rows();
			$pages         = ceil( $total_records / $params['pagesize'] );
			if ( $pages == 0 ) {
				$pages = 1;
			}
			if ( empty( $query['rows'] ) ) {
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
			'id'            => '0',
			'city'          => '',
			'country'       => '',
			'address1'      => '',
			'job_date'      => '',
			'job_status'    => '',
			'fitter_id'     => '',
			'espc'          => 'false',
			'pay'           => 'false',
			'charge'        => 'false',
			'lost_property' => 'false',
		];

		$last_id   = 0;
		$last_id2  = 0;
		$array     = [];
		$sub_array = [];
		$params    = General::set_args( $params, $default );

		//	unset( $params['sub_job_type'] );
		//		$array = $params['eid'];
		//		$temp  = array_filter( $array, function ( $value ) {
		//			return $value > 0;
		//		} );
		//		echo count( $temp ) >= 1 ? "true" : "false";
		//
		//		General::show_array( $params );
		//		die;

		if ( Users::is_admin() ) {
			if ( isset( $params['client_id'] ) && empty( $params['client_id'] ) ) {
				return 'Please select a client name.';
			}

			if ( isset( $params['contact_type'] ) && empty( $params['contact_type'] ) ) {
				return 'Please select a contact type';
			}
			if ( isset( $params['job_status'] ) && $params['job_status'] == 1 ) {
				$array['date_done'] = MyDateTime::mysql_date();
			}

		}

		if ( empty( $params['id'] ) ) {
			if ( ! isset( $params['rowid'] ) || empty( $params['rowid'] ) ) {
				return 'Please select at least one job.';
			}
		}

		if ( empty( $params['address1'] ) ) {
			return 'Address field is required.';
		}
		if ( empty( $params['country'] ) ) {
			return 'Country field is required.';
		}
		if ( empty( $params['city'] ) ) {
			return 'City field is required.';
		}

		// custom array value assign
		$array['id']                = $params['id'];
		$array['latitude']          = $params['latitude'];
		$array['longitude']         = $params['longitude'];
		$array['address1']          = $params['address1'];
		$array['address2']          = $params['address2'];
		$array['address3']          = $params['address3'];
		$array['city']              = $params['city'];
		$array['country']           = $params['country'];
		$array['customer_name']     = $params['customer_name'];
		$array['sticker']           = $params['sticker'];
		$array['client_id']         = $params['client_id'];
		$array['contact_type']      = $params['contact_type'];
		$array['client_contact']    = $params['client_contact'];
		$array['board']             = $params['board'];
		$array['problems']          = $params['problems'];
		$array['appointment']       = $params['appointment'];
		$array['job_status']        = $params['job_status'];
		$array['date_done']         = $params['date_done'];
		$array['charge']            = $params['charge'];
		$array['pay']               = $params['pay'];
		$array['postcode']          = $params['postcode'];
		$array['access']            = $params['access'];
		$array['key']               = $params['key'];
		$array['comments']          = $params['comments'];
		$array['poref']             = $params['poref'];
		$array['lost_property']     = $params['lost_property'];
		$array['overplate']         = $params['overplate'];
		$array['questionmark']      = $params['questionmark'];
		$array['internal_comments'] = $params['internal_comments'];
		//$array['job_date']       = MyDateTime::mysql_date( $params['job_date'] );
		if ( ! isset( $params['client_id'] ) ) {
			$array['client_id'] = Users::get_my_id();
		}

		if ( empty( $params['id'] ) ) {
			unset( $params['id'] );
			$array['jobcode']     = self::get_next_jobcode( $array['client_id'] );
			$array['added_by']    = Users::get_my_id();
			$array['added_time']  = MyDateTime::mysql_datetime();
			$array['added_ip']    = General::myip();
			$array['server_info'] = json_encode( $_SERVER );

			// insert data into database
			$this->db->insert( $this->Table, $array );
			$last_id = $this->db->insert_id();

		} else {
			// update data into database
			$last_id = $array['id'];
			$this->db->update( $this->Table, $array, [ 'id' => $array['id'] ] );
		}

		// sub job data save
		if ( isset( $params['rowid'] ) && ! empty( $params['rowid'] ) ) {
			$rows = $params['rowid'];
			$no   = 1;
			foreach ( $rows as $k => $row ) {
				$sub_array = [
					'name'       => $params['name'][ $row ],
					'jobid'      => $last_id,
					'jobtypeid'  => $params['jobtypeid'][ $row ],
					'fitter_id'  => $params['fitter_id'][ $row ],
					'price'      => $params['price'][ $row ],
					'expense'    => $params['expense'][ $row ],
					'total'      => $params['total'][ $row ],
					'job_date'   => MyDateTime::mysql_date( $params['job_date'][ $row ] ),
					'position'   => $params['position'][ $row ],
					'added_ip'   => General::myip(),
					'added_by'   => Users::get_my_id(),
					'added_time' => MyDateTime::mysql_datetime(),
					'sort'       => $no ++,
				];
				if ( isset( $params['is_return'][ $row ] ) && $params['is_return'][ $row ] == 'on' ) {
					$sub_array['is_return'] = 1;
				} else {
					$sub_array['is_return'] = 0;
				}
				if ( empty( $params['eid'][ $row ] ) ) {
					// insert
					$this->db->insert( $this->TableSubJob, $sub_array );
					$last_id2 = $this->db->insert_id();
				} else {
					// update
					$last_id2 = $params['eid'][ $row ];
					$this->db->update( $this->TableSubJob, $sub_array, [ 'id' => $last_id2 ] );
				}
			}
		}

		return 'OK,' . $last_id;
	}

	/**
	 * @param string $params
	 * Insert invoice no
	 *
	 * @return string
	 */
	public function insert_invoice( $params = '' ) {
		$default = [
			'job_id' => '',
		];
		$params  = General::set_args( $params, $default );
		if ( empty( $params['job_id'] ) ) {
			return 'Job id missing.';
		}

		$row = $this->db->where( 'job_id', $params['job_id'] )->get( $this->Table2 )->row_array();

		if ( empty( $row ) ) {
			$params['added_by']   = Users::get_my_id();
			$params['added_time'] = MyDateTime::mysql_datetime();
			$params['added_ip']   = General::myip();
			// insert data into database
			$this->db->insert( $this->Table2, $params );
		} else {
			unset( $params['invoice_date'] );
			$this->db->update( $this->Table2, $params, [ 'job_id' => $params['job_id'] ] );
		}

		return 'OK';
	}

	/**
	 * @return int|string
	 * Generate new invoice no
	 */
	public function generate_invoice_no( $params = '' ) {
		$default = [
			'type'      => '',
			'client_id' => '',
			'to'        => '',
			'from'      => '',
		];
		$params  = General::set_args( $params, $default );

		if ( empty( $params['client_id'] ) ) {
			return '001';
		}

		$to   = $params['to'];
		$from = $params['from'];

		$number = $this->db->select( 'invoice_no' )
		                   ->where( 'client_id', $params['client_id'] )
		                   ->where( "DATE(`invoice_date`) BETWEEN '$from' AND '$to'" )
		                   ->get( 'invoice' )
		                   ->row_array()['invoice_no'];
		//echo $this->db->last_query();
		if ( ! empty( $number ) ) {
			if ( ! empty( $params['type'] ) && $params['type'] == 'U' ) {
				return $number;
			}
		}

		// Get max number
		$number = $this->db->select_max( 'invoice_no' )->get( 'invoice' )->row_array()['invoice_no'];
		if ( empty( $number ) ) {
			return '001';
		}

		$number = (int) $number;
		if ( isset( $number ) && $number > 0 && $number <= 9 ) {
			$number = '00' . ( $number + 1 );
		} else if ( isset( $number ) && $number > 9 && $number <= 99 ) {
			$number = '0' . ( $number + 1 );
		} else if ( isset( $number ) && $number > 99 ) {
			$number = ( $number + 1 );
		} else {
			$number = '00' . ( $number + 1 );
		}

		return $number;
	}

	public function getInvoiceNo( $client_id = '' ) {
		if ( empty( $client_id ) ) {
			return false;
		}

		$number = $this->db->select( 'invoice_no' )
		                   ->group_start()
		                   ->where( 'client_id', $client_id )
		                   ->where( 'invoice_no <>', '' )
		                   ->where( 'invoice_no <>', null )
		                   ->group_end()
		                   ->get( 'jobs' )
		                   ->row_array()['invoice_no'];

		if ( isset( $number ) && ! empty( $number ) ) {
			return $number;
		}

		$number = $this->db->select_max( 'invoice_no' )->get( 'jobs' )->row_array()['invoice_no'];
		$number = (int) $number;

		if ( isset( $number ) && $number > 0 && $number <= 9 ) {
			$number = '00' . ( $number + 1 );
		} else if ( isset( $number ) && $number > 9 && $number <= 99 ) {
			$number = '0' . ( $number + 1 );
		} else if ( isset( $number ) && $number > 99 ) {
			$number = ( $number + 1 );
		} else {
			$number = '00' . ( $number + 1 );
		}

		return $number;
	}

	public function getClientJobPrice( $client_id = '', $jobtype = '' ) {
		if ( empty( $client_id ) ) {
			return 0;
		}
		$price = 0;
		$row   = $this->db->select( 'pricing_system' )->where( 'id', $client_id )->get( 'admins' )->row_array();
		if ( ! empty( $row ) ) {
			$p = $this->db->select( 'price_a,price_b' )->where( 'id', $jobtype )->get( 'jobtype' )->row_array();
			if ( $row['pricing_system'] == 'A' ) {
				$price = $p['price_a'];
			} else if ( $row['pricing_system'] == 'B' ) {
				$price = $p['price_b'];
			} else {
				$price = $row['pricing_system'];
			}
		}

		return $price;
	}

	/**
	 * @param int $id
	 * Get next number
	 *
	 * @return bool|int|string
	 */
	public function get_next_jobcode( $id = 0 ) {
		if ( empty( $id ) ) {
			return false;
		}
		$username = Users::get_username( $id );
		$username = preg_replace( '/[^A-Za-z0-9\-]/', ' ', $username );
		$username = preg_replace( '/\s+/', ' ', $username );
		$username = trim( str_replace( ' ', '_', $username ) );
		// count total job this client id
		$number = $this->db->select( 'client_id' )->where( 'client_id', $id )->get( $this->Table )->num_rows();

		if ( isset( $number ) && $number > 0 && $number < 9 ) {
			$number = $username . '_00' . ( $number + 1 );
		} else if ( isset( $number ) && $number > 9 && $number <= 99 ) {
			$number = $username . '_0' . ( $number + 1 );
		} else if ( isset( $number ) && $number > 99 ) {
			$number = $username . '_' . ( $number + 1 );
		} else {
			$number = $username . '_00' . ( $number + 1 );
		}

		return $number;
	}

	/**
	 * @param string $params
	 * Delete staff data
	 *
	 * @return string
	 */
	public function delete( $params = '' ) {
		$default = [
			'id'        => '0',
			'client_id' => '',
		];
		$params  = General::set_args( $params, $default );

		if ( empty( $params['id'] ) ) {
			return 'User id missing.';
		}

		$this->db->delete( $this->Table, [ 'id' => $params['id'] ] );
		$return = ( $this->db->affected_rows() != 1 ) ? $this->db->last_query() : 'OK';

		if ( ! empty( $return ) && $return == 'OK' ) {
			if ( isset( $params['client_id'] ) && $params['client_id'] <> '' ) {
				$username = Users::get_username( $params['client_id'] );
				$username = preg_replace( '/[^A-Za-z0-9\-]/', ' ', $username );
				$username = preg_replace( '/\s+/', ' ', $username );
				$username = trim( str_replace( ' ', '_', $username ) );

				$rows = $this->db->select( 'id,jobcode' )
				                 ->where( 'client_id', $params['client_id'] )
				                 ->order_by( 'id', 'ASC' )
				                 ->get( $this->Table )
				                 ->result_array();
				if ( ! empty( $rows ) ) {
					foreach ( $rows as $number => $row ) {
						$jobcode = '';
						$number  = $number + 1;
						if ( isset( $number ) && $number > 0 && $number < 9 ) {
							$jobcode = $username . '_00' . $number;
						} else if ( isset( $number ) && $number > 9 && $number <= 99 ) {
							$jobcode = $username . '_0' . $number;
						} else if ( isset( $number ) && $number > 99 ) {
							$jobcode = $username . '_' . $number;
						} else {
							$jobcode = $username . '_00' . $number;
						}
						$arr = [
							'jobcode' => $jobcode,
						];
						$this->db->update( $this->Table, $arr, [ 'id' => $row['id'] ] );
					}
				}
			}
		}

		return $return;
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

	public function get_client_location( $params = '' ) {
		$default = [
			'id' => '0',
		];
		$params  = General::set_args( $params, $default );

		if ( empty( $params['id'] ) ) {
			return 'User id missing.';
		}

		$rows = $this->db->select( 'address1,latitude,longitude,job_status' )
		                 ->where( 'client_id', $params['id'] )
		                 ->get( $this->Table )
		                 ->result_array();

		if ( empty( $rows ) ) {
			return false;
		}

		return $rows;
	}

	public function get_jobtype_price( $params = '' ) {
		$default = [
			'client_id' => '',
			'type_id'   => '',
		];
		$params  = General::set_args( $params, $default );

		if ( empty( $params['client_id'] ) ) {
			return 'Please select a client name.';
		}
		if ( empty( $params['type_id'] ) ) {
			return 'Please select a Job type.';
		}
		$price        = 0;
		$price_system = '';
		$row          = $this->db->select( 'pricing_system' )
		                         ->where( 'id', $params['client_id'] )
		                         ->get( 'admins' )
		                         ->row_array();
		if ( ! empty( $row ) ) {
			//			$p            = $this->db->select( 'price_a,price_b' )
			//			                         ->where( 'id', $params['type_id'] )
			//			                         ->get( 'jobtype' )
			//			                         ->row_array();
			//

			$p            = $this->db->where( 'id', $params['type_id'] )->get( 'jobtype' )->row_array();
			$price_system = $row['pricing_system'];
			if ( $price_system == 'A' ) {
				$price = $p['price_a'];
			} else if ( $price_system == 'B' ) {
				$price = $p['price_b'];
			} else {
				$price = $price_system;
			}
		}

		$array = [
			'price' => $price,
			'type'  => $price_system,
			'rows'  => $p,
		];

		return $array;
	}


	public function get_monthly_report( $params = '' ) {
		$default = [
			'id'         => '',
			'orderby'    => 'id',
			'order'      => 'DESC',
			'page'       => '1',
			'pagesize'   => '9999999',
			'client_id'  => '',
			'job_status' => '',
			'time_from'  => '',
			'time_to'    => '',
		];
		$params  = General::set_args( $params, $default );

		if ( ! empty( $params['id'] ) ) {
			$this->db->where_in( 'id', General::make_array( $params['id'] ) );
		}
		if ( ! empty( $params['client_id'] ) ) {
			$this->db->where( 'client_id', $params['client_id'] );
		}
		if ( isset( $params['job_status'] ) && $params['job_status'] <> '' ) {
			$this->db->where( 'job_status', $params['job_status'] );
		}
		if ( isset( $params['time_from'] ) && $params['time_from'] <> '' ) {
			$from = MyDateTime::mysql_date( $params['time_from'] );
			$to   = MyDateTime::mysql_date( $params['time_to'] );
			$this->db->where( "DATE(`invoice_date`) BETWEEN '$from' AND '$to'" );
		}

		$rows = $this->db->select( '*,GROUP_CONCAT(job_id) as jobid , COUNT(`client_id`) as total_invoice' )
		                 ->group_by( "DATE_FORMAT(invoice.invoice_date,'%Y-%m') , client_id" )
		                 ->get( 'invoice' )
		                 ->result_array();

		return $rows;
	}


	/**
	 * @param string $params
	 * Search Client for job
	 *
	 * @return string
	 */
	public function search_client_for_job( $params = '' ) {
		$default = [
			'orderby'  => 'client_id',
			'order'    => 'DESC',
			'page'     => '1',
			'pagesize' => '999999999',
		];

		$params = General::set_args( $params, $default );

		$return = $this->db->select( 'id,jobcode,client_id' )
		                   ->group_by( 'client_id' )
		                   ->order_by( $params['orderby'], $params['order'] )
		                   ->get( $this->Table )
		                   ->result_array();

		return $return;
	}

}