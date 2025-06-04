<?php
if ( ! defined( 'BASEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class Jobs_model extends CI_Model {

	var $Table = 'jobs';
	var $TableJobType = 'jobtype';
	var $TableUsers = 'admins';
	var $TableSubJob = 'subjobs';

	public function __construct() {
		parent::__construct();
	}

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
			'time_from'     => '',
			'time_to'       => '',

			'jobid'        => '',
			'job_status'   => '',
			'fitter_id'    => '',
			'job_type'     => '',
			'overplate'    => '',
			'lost_type'    => '',
			'espc'         => '',
			'postcode'     => '',
			'questionmark' => '',
			'contact_type' => '',
			'print_name'   => '',
		];
		$params  = General::set_args( $params, $default );

		//				echo 'i am here...';
		//				General::show_array( $params );
		//				die;

		$fitterids  = [];
		$jobtypeids = [];
		if ( ! empty( $params['search'] ) ) {
			$rows = $this->db->select( 'id' )
			                 ->like( 'name', $params['search'] )
			                 ->get( $this->TableJobType )
			                 ->result_array();
			if ( ! empty( $rows ) ) {
				foreach ( $rows as $row ) {
					$jobtypeids[] = $row['id'];
				}
			}

			$rows = $this->db->select( 'id' )
			                 ->like( 'username', $params['search'] )
			                 ->where( 'type', 'fitter' )
			                 ->get( $this->TableUsers )
			                 ->result_array();
			if ( ! empty( $rows ) ) {
				foreach ( $rows as $row ) {
					$fitterids[] = $row['id'];
				}
			}
		}

		$this->db->select( '
		j.client_id,j.jobcode,j.customer_name,
		j.address1,j.address2,j.address3,
		j.city,j.country,j.postcode, 
		j.latitude,j.longitude,
		s.*' )->from( 'subjobs as s' )->join( 'jobs j', 'j.id = s.jobid' );


		if ( ! empty( $params['id'] ) ) {
			$this->db->where_in( '`s.id`', General::make_array( $params['id'] ) );
		}
		if ( ! empty( $params['client_id'] ) ) {
			$this->db->where_in( '`j.client_id`', General::make_array( $params['client_id'] ) );
		}
		if ( ! empty( $params['jobid'] ) ) {
			$this->db->where_in( '`s.jobid`', General::make_array( $params['jobid'] ) );
		}
		if ( isset( $params['job_status'] ) && $params['job_status'] <> '' ) {
			$this->db->where( '`s.job_status`', $params['job_status'] );
		}
		if ( isset( $params['fitter_id'] ) && $params['fitter_id'] <> '' ) {
			$this->db->where( '`s.fitter_id`', $params['fitter_id'] );
		}
		if ( isset( $params['job_type'] ) && $params['job_type'] <> '' ) {
			$this->db->where( '`s.job_type`', $params['job_type'] );
		}
		if ( isset( $params['overplate'] ) && $params['overplate'] <> '' ) {
			$this->db->where( '`s.overplate`', $params['overplate'] );
		}
		if ( isset( $params['lost_type'] ) && $params['lost_type'] <> '' ) {
			$this->db->where( '`s.lost_type`', $params['lost_type'] );
		}
		if ( isset( $params['espc'] ) && $params['espc'] <> '' ) {
			$this->db->where( '`s.espc`', $params['espc'] );
		}
		if ( isset( $params['postcode'] ) && $params['postcode'] <> '' ) {
			$this->db->where( '`j.postcode`', $params['postcode'] );
		}
		if ( isset( $params['questionmark'] ) && $params['questionmark'] <> '' ) {
			$this->db->where( '`s.questionmark`', $params['questionmark'] );
		}
		if ( isset( $params['contact_type'] ) && $params['contact_type'] <> '' ) {
			$this->db->where( '`s.contact_type`', $params['contact_type'] );
		}
		if ( isset( $params['print_name'] ) && $params['print_name'] <> '' ) {
			$this->db->where( '`s.print_name`<>', '' );
		}
		if ( isset( $params['time_from'] ) && $params['time_from'] <> '' ) {
			$from = MyDateTime::mysql_date( $params['time_from'] );
			$to   = MyDateTime::mysql_date( $params['time_to'] );
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
				$this->db->or_like( '`j.city`', $search );
				$this->db->or_like( '`j.client_id`', $search );
				$this->db->or_like( '`j.address1`', $search );
				$this->db->or_like( '`j.postcode`', $search );
				$this->db->group_end();
			}
		}
		if ( ! empty( $jobtypeids ) ) {
			$this->db->or_where_in( '`s.job_type`', $jobtypeids );
		}
		if ( ! empty( $fitterids ) ) {
			$this->db->or_where_in( '`s.fitter_id`', $fitterids );
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

		//										echo $this->db->last_query();
		//										die;

		if ( ! empty( $query ) ) {

			$this->db->select( '
		j.client_id,j.jobcode,j.customer_name,
		j.address1,j.address2,j.address3,
		j.city,j.country,j.postcode, 
		j.latitude,j.longitude,
		s.*' )->from( 'subjobs as s' )->join( 'jobs j', 'j.id = s.jobid' );

			if ( ! empty( $params['id'] ) ) {
				$this->db->where_in( '`s.id`', General::make_array( $params['id'] ) );
			}
			if ( ! empty( $params['client_id'] ) ) {
				$this->db->where_in( '`j.client_id`', General::make_array( $params['client_id'] ) );
			}
			if ( ! empty( $params['jobid'] ) ) {
				$this->db->where_in( '`s.jobid`', General::make_array( $params['jobid'] ) );
			}
			if ( isset( $params['job_status'] ) && $params['job_status'] <> '' ) {
				$this->db->where( '`s.job_status`', $params['job_status'] );
			}
			if ( isset( $params['fitter_id'] ) && $params['fitter_id'] <> '' ) {
				$this->db->where( '`s.fitter_id`', $params['fitter_id'] );
			}
			if ( isset( $params['job_type'] ) && $params['job_type'] <> '' ) {
				$this->db->where( '`s.job_type`', $params['job_type'] );
			}
			if ( isset( $params['overplate'] ) && $params['overplate'] <> '' ) {
				$this->db->where( '`s.overplate`', $params['overplate'] );
			}
			if ( isset( $params['lost_type'] ) && $params['lost_type'] <> '' ) {
				$this->db->where( '`s.lost_type`', $params['lost_type'] );
			}
			if ( isset( $params['espc'] ) && $params['espc'] <> '' ) {
				$this->db->where( '`s.espc`', $params['espc'] );
			}
			if ( isset( $params['postcode'] ) && $params['postcode'] <> '' ) {
				$this->db->where( '`j.postcode`', $params['postcode'] );
			}
			if ( isset( $params['questionmark'] ) && $params['questionmark'] <> '' ) {
				$this->db->where( '`s.questionmark`', $params['questionmark'] );
			}
			if ( isset( $params['contact_type'] ) && $params['contact_type'] <> '' ) {
				$this->db->where( '`s.contact_type`', $params['contact_type'] );
			}
			if ( isset( $params['print_name'] ) && $params['print_name'] <> '' ) {
				$this->db->where( '`s.print_name`<>', '' );
			}
			if ( isset( $params['time_from'] ) && $params['time_from'] <> '' ) {
				$from = MyDateTime::mysql_date( $params['time_from'] );
				$to   = MyDateTime::mysql_date( $params['time_to'] );
				$this->db->where( "`s.added_time` BETWEEN '$from' AND '$to'" );
			}
			if ( ! empty( $params['search'] ) ) {
				$search = $this->security->xss_clean( $params['search'] );
				if ( strtolower( substr( $search, 0, 3 ) ) == "id:" ) {
					$ids = General::make_array( substr( $search, 3 ) );
					$this->db->where_in( '`j.id`', $ids );
				} else {
					$this->db->group_start();
					$this->db->like( '`j.jobcode`', $search );
					$this->db->or_like( '`j.city`', $search );
					$this->db->or_like( '`j.client_id`', $search );
					$this->db->or_like( '`j.address1`', $search );
					$this->db->or_like( '`j.postcode`', $search );
					$this->db->group_end();
				}
			}
			if ( ! empty( $jobtypeids ) ) {
				$this->db->or_where_in( '`s.job_type`', $jobtypeids );
			}
			if ( ! empty( $fitterids ) ) {
				$this->db->or_where_in( '`s.fitter_id`', $fitterids );
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
	 * Save staff data
	 *
	 * @return string
	 */
	public function save( $params = '' ) {
		$last_id = 0;
		$array   = [];
		$default = [
			'id'        => '0',
			'city'      => '',
			'rowid'     => [],
			'country'   => '',
			'address1'  => '',
			'client_id' => '',
			//'jobcode'   => '',
		];
		$params  = General::set_args( $params, $default );

		//		General::show_array( $params );
		//		die;

		if ( empty( $params['rowid'] ) ) {
			return 'Please select at least one job.';
		}
		if ( empty( $params['client_id'] ) ) {
			return 'Please select a client name.';
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
		// ********************************************************
		// *********** These array save into jobs table ***********
		// ********************************************************
		$array = [
			//'id'            => $params['id'],
			'city'          => $params['city'],
			'latitude'      => $params['latitude'],
			'longitude'     => $params['longitude'],
			'address1'      => $params['address1'],
			'address2'      => $params['address2'],
			'address3'      => $params['address3'],
			'postcode'      => $params['postcode'],
			'country'       => $params['country'],
			'customer_name' => $params['customer_name'],
		];

		// ********************************************************
		// *********** These array save into jobs table ***********
		// ********************************************************

		if ( ! isset( $params['client_id'] ) ) {
			$array['client_id'] = Users::get_my_id();
		} else {
			$array['client_id'] = $params['client_id'];
		}

		//		General::show_array( $params );
		//		die;

		if ( empty( $params['id'] ) ) {
			unset( $params['id'] );
			$array['jobcode']    = self::get_next_jobcode( $array['client_id'] );
			$array['added_by']   = Users::get_my_id();
			$array['added_time'] = MyDateTime::mysql_datetime();
			$array['added_ip']   = General::myip();
			// insert data into database
			$this->db->insert( $this->Table, $array );
			$last_id = $this->db->insert_id();
		} else {
			// update data into database
			$last_id = $params['id'];
			$this->db->update( $this->Table, $array, [ 'id' => $params['id'] ] );
		}

		// Sub job values insert or updates
		if ( isset( $params['rowid'] ) ) {
			$data = [];
			$k    = 1;
			foreach ( $params['rowid'] as $id ) {
				$_total        = 0;
				$position      = '';
				$print_name    = '';
				$date_done     = null;
				$lost_type     = null;
				$lost_property = 'false';
				$sub_jobid     = $params['eid'][ $id ];
				if ( isset( $params['print_name'][ $id ] ) && ! empty( $params['print_name'][ $id ] ) ) {
					$print_name = $params['print_name'][ $id ];
				}
				if ( isset( $params['position'][ $id ] ) && ! empty( $params['position'][ $id ] ) ) {
					$position = $params['position'][ $id ];
				}
				if ( ! empty( $params['job_status'][ $id ] ) ) {
					$date_done = MyDateTime::mysql_date( $params['date_done'][ $id ] );
				}
				if ( ! empty( $params['lost_property'][ $id ] ) ) {
					$lost_type     = $params['lost'][ $id ];
					$lost_property = $params['lost_property'][ $id ];
				}

				$qty      = $params['qty'][ $id ];
				$price    = (float) ( $params['price'][ $id ] );
				$expense  = (float) ( $params['expense'][ $id ] );
				$discount = (float) ( $params['discount'][ $id ] );
				$_total   = $price + ( ( $qty - 1 ) * ( $price ) * ( $discount / 100 ) );
				$_total   = General::number_formate( ( $_total + $expense ) );

				// create sub job value array
				$data = [
					'jobid'             => $last_id,
					'client_id'         => $array['client_id'],
					'job_type'          => $params['job_type'][ $id ],
					'fitter_id'         => $params['fitter_id'][ $id ],
					'print_name'        => $print_name,
					'position'          => $position,
					'price'             => $params['price'][ $id ],
					'qty'               => $params['qty'][ $id ],
					'expense'           => $params['expense'][ $id ],
					'discount'          => $params['discount'][ $id ],
					'total'             => $_total,
					'job_date'          => MyDateTime::mysql_date( $params['job_date'][ $id ] ),
					//'enter_date'        => MyDateTime::mysql_datetime( $params['enter_date'][ $id ] ),
					'access'            => $params['access'][ $id ],
					'keys_text'         => $params['keys_text'][ $id ],
					'appointment'       => $params['appointment'][ $id ],
					'board'             => $params['board'][ $id ],
					'client_contact'    => $params['client_contact'][ $id ],
					'job_status'        => $params['job_status'][ $id ],
					'date_done'         => $date_done,
					'contact_type'      => $params['contact_type'][ $id ],
					'charge'            => $params['charge'][ $id ],
					'pay'               => $params['pay'][ $id ],
					'comments'          => $params['comments'][ $id ],
					'date_to_be_done'   => MyDateTime::mysql_datetime( $params['date_to_be_done'][ $id ] ),
					'poref'             => $params['poref'][ $id ],
					'espc'              => $params['espc'][ $id ],
					'lost_type'         => $lost_type,
					'lost_property'     => $lost_property,
					'overplate'         => $params['overplate'][ $id ],
					'questionmark'      => $params['questionmark'][ $id ],
					'internal_comments' => $params['internal_comments'][ $id ],
				];

				if ( empty( $sub_jobid ) ) {
					// insert value into subjob table
					$data['added_by']   = Users::get_my_id();
					$data['added_time'] = MyDateTime::mysql_datetime();
					$data['added_ip']   = General::myip();
					$data['sort']       = self::generate_max_subjob_number( $last_id );
					// insert data into database
					$this->db->insert( $this->TableSubJob, $data );
				} else {
					// update value subjob table
					$this->db->update( $this->TableSubJob, $data, [ 'id' => $sub_jobid ] );
				}
			}
		}

		return 'OK,' . $last_id;
	}

	public function generate_max_subjob_number( $jobid = 0 ) {
		if ( empty( $jobid ) ) {
			return 0;
		}

		return $this->db->where( 'jobid', $jobid )->get( $this->TableSubJob )->num_rows() + 1;
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

	public function delete_subjobs( $params = '' ) {
		$default = [
			'id'    => '0',
			'jobid' => '0',
		];
		$params  = General::set_args( $params, $default );

		if ( empty( $params['id'] ) ) {
			return 'Job id missing';
		}
		if ( empty( $params['jobid'] ) ) {
			return 'Job id missing invalid record not found.';
		}
		// delete subjob id
		$this->db->delete( $this->TableSubJob, [ 'id' => $params['id'] ] );
		// Check if all subjob delete then delete parent job from 'Jobs' table
		$numrows = $this->db->where( 'jobid', $params['jobid'] )->get( $this->TableSubJob )->num_rows();
		if ( empty( $numrows ) ) {
			$this->db->delete( $this->Table, [ 'id' => $params['jobid'] ] );
		}

		return 'OK,' . $params['id'];
	}

	public function get_job_print( $params = '' ) {
		$default = [
			'id'    => '',
			'jobid' => '',
		];
		$params  = General::set_args( $params, $default );

		if ( empty( $params['id'] ) ) {
			return 'Job Id Missing Try Again.';
		}
		if ( empty( $params['jobid'] ) ) {
			return 'Job not found.';
		}

		$this->db->select( '
		j.client_id,j.jobcode,j.customer_name,
		j.address1,j.address2,j.address3,
		j.city,j.country,j.postcode, 
		j.latitude,j.longitude,
		s.*' )->from( 'subjobs as s' )->join( 'jobs j', 'j.id = s.jobid' );
		$this->db->where( '`s.id`', $params['id'] );

		return $this->db->get( $this->TableSubJob )->row_array( 0 );
	}

	public function update_job_status( $params = '' ) {
		$default    = [
			'id'        => '',
			'jobid'     => '',
			'status'    => 0,
			'client_id' => 0,
		];
		$date_done  = null;
		$invoice_no = null;
		$params     = General::set_args( $params, $default );

		if ( empty( $params['id'] ) ) {
			return 'Job id missing';
		}
		if ( empty( $params['jobid'] ) ) {
			return 'Job not found in system';
		}
		if ( empty( $params['client_id'] ) ) {
			return 'Client id missing';
		}
		if ( ! empty( $params['status'] ) ) {
			$date_done = MyDateTime::mysql_date();
		}

		// get invoice no
		$invoice_no = $this->db->select( 'invoice_no' )->where( [
			'client_id'        => $params['client_id'],
			'job_status'       => 1,
			'MONTH(date_done)' => date( 'm' ),
			'YEAR(date_done)'  => date( 'Y' ),
		] )->get( 'subjobs' )->row_array()['invoice_no'];

		if ( empty( $invoice_no ) ) {
			$invoice_no = self::get_invoice_no( [
				'id'     => $params['id'],
				'jobid'  => $params['jobid'],
				'status' => $params['status'],
			] );
		}

		$update = $this->db->update( $this->TableSubJob, [
			'date_done'  => $date_done,
			'invoice_no' => $invoice_no,
			'job_status' => $params['status'],
		], [ 'id' => $params['id'] ] );

		if ( $update ) {
			return [
				'id'     => $params['id'],
				'status' => $params['status'],
			];
		}

		return $this->db->last_query();
	}

	public function get_invoice_no( $params = '' ) {
		$default = [
			'id'     => '',
			'jobid'  => '',
			'status' => '',
		];
		$params  = General::set_args( $params, $default );
		if ( empty( $params['status'] ) ) {
			return null;
		}

		$result = (int) $this->db->select_max( 'invoice_no' )
		                         ->where( 'job_status', 1 )
		                         ->get( $this->TableSubJob )
		                         ->row_array()['invoice_no'];

		$max_invoice_number = (int) ( $result + 1 );

		return str_pad( $max_invoice_number, 5, "0", STR_PAD_LEFT );
	}

	public function print_sticker() {
		if ( ! ( Users::is_login() ) ) {
			return 'Please login your account';
		}
		$this->db->select( '
		j.client_id,j.jobcode,j.customer_name,
		j.address1,j.address2,j.address3,
		j.city,j.country,j.postcode, 
		j.latitude,j.longitude,
		s.*' )->from( 'subjobs as s' )->join( 'jobs j', 'j.id = s.jobid' );
		// check condition
		$this->db->where( [
			'`s.print_name`<>' => '',
			'`s.job_status`'   => 0,
		] );

		return $this->db->group_by( 'id' )->get( $this->TableSubJob )->result_array();
	}

	public function print_fitter( $params = '' ) {
		$default = [
			'id' => '',
		];
		$params  = General::set_args( $params, $default );
		if ( ! ( Users::is_login() ) ) {
			return 'Please login your account';
		}
		if ( empty( $params['id'] ) ) {
			return 'Fitter id missing.';
		}

		$this->db->select( '
		j.client_id,j.jobcode,j.customer_name,
		j.address1,j.address2,j.address3,
		j.city,j.country,j.postcode, 
		j.latitude,j.longitude,
		s.*' )->from( 'subjobs as s' )->join( 'jobs j', 'j.id = s.jobid' );
		// check condition
		$this->db->where( [
			'`s.job_status`' => 0,
			'`s.fitter_id`'  => $params['id'],
		] );

		return $this->db->group_by( 'id' )->get( $this->TableSubJob )->result_array();
	}

	// *********************************************
	// *********************************************
	// *********************************************
	// *********************************************
	// *********************************************

	public function save2( $params = '' ) {
		$default = [
			'id'        => '',
			'jobid'     => '0',
			'job_date'  => '0',
			'job_type'  => '',
			'client_id' => '',
		];
		$params  = General::set_args( $params, $default );

		if ( empty( $params['id'] ) ) {
			return 'Job id missing.';
		}
		if ( empty( $params['job_date'] ) ) {
			return 'Job date field is required.';
		}
		if ( empty( $params['job_type'] ) ) {
			return 'Please select a job type first.';
		}
		if ( empty( $params['client_id'] ) ) {
			return 'Client id missing.';
		}

		//		General::show_array( $params );
		//		die;

		$qty      = $params['qty'];
		$price    = (float) ( $params['price'] );
		$expense  = (float) ( $params['expense'] );
		$discount = (float) ( $params['discount'] );
		$_total   = $price + ( ( $qty - 1 ) * ( $price ) * ( $discount / 100 ) );
		$_total   = General::number_formate( ( $_total + $expense ) );

		$array = [
			'jobid'       => $params['id'],
			'enter_date'  => MyDateTime::mysql_date( $params['enter_date'] ),
			'client_id'   => $params['client_id'],
			'job_type'    => $params['job_type'],
			'discount'    => $discount,
			'qty'         => $qty,
			'price'       => $price,
			'expense'     => $expense,
			'total'       => $_total,
			'job_date'    => MyDateTime::mysql_date( $params['job_date'] ),
			'print_name'  => $params['print_name'],
			'position'    => $params['position'],
			'poref'       => $params['poref'],
			'access'      => $params['access'],
			'keys_text'   => $params['keys_text'],
			'appointment' => $params['appointment'],
			'board'       => $params['board'],
			'comments'    => $params['comments'],
			'added_by'    => Users::get_my_id(),
			'added_time'  => MyDateTime::mysql_datetime(),
			'added_ip'    => General::myip(),
		];

		if ( empty( $params['jobid'] ) ) {
			unset( $params['jobid'] );
			$array['sort'] = self::generate_max_subjob_number( $params['id'] );
			// insert data into database
			$this->db->insert( $this->TableSubJob, $array );
			$last_id = $this->db->insert_id();
		} else {
			// insert data into database
			$last_id = $params['jobid'];
			$this->db->update( $this->TableSubJob, $array, [ 'id' => $params['jobid'] ] );
		}

		return ( $this->db->affected_rows() != 1 ) ? $this->db->last_query() : 'OK,' . $last_id;
	}

	public function get_jobs_client( $params = '' ) {
		$default = [
			'id'        => '',
			'orderby'   => 'id',
			'order'     => 'DESC',
			'search'    => '',
			'page'      => '1',
			'pagesize'  => '999999',
			'postcode'  => '',
			'time_to'   => '',
			'time_from' => '',
			'client_id' => '',
		];
		$params  = General::set_args( $params, $default );

		if ( ! empty( $params['id'] ) ) {
			$this->db->where_in( 'id', General::make_array( $params['id'] ) );
		}
		if ( ! empty( $params['client_id'] ) ) {
			$this->db->where( 'client_id', $params['client_id'] );
		}
		if ( isset( $params['time_from'] ) && $params['time_from'] <> '' ) {
			$from = MyDateTime::mysql_date( $params['time_from'] );
			$to   = MyDateTime::mysql_date( $params['time_to'] );
			$this->db->where( "DATE (`added_time`) BETWEEN '$from' AND '$to'" );
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

		//						echo $this->db->last_query();
		//						General::show_array( $query );
		//						die;

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
			if ( isset( $params['time_from'] ) && $params['time_from'] <> '' ) {
				$from = MyDateTime::mysql_date( $params['time_from'] );
				$to   = MyDateTime::mysql_date( $params['time_to'] );
				$this->db->where( "DATE (`added_time`) BETWEEN '$from' AND '$to'" );
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

	public function get_client_map_view( $params = '' ) {
		$default = [
			'id' => '0',
		];
		$params  = General::set_args( $params, $default );

		if ( empty( $params['id'] ) ) {
			return 'User id missing.';
		}

		$rows = $this->db->select( 'address1,latitude,longitude' )
		                 ->where( 'client_id', $params['id'] )
		                 ->get( $this->Table )
		                 ->result_array();

		if ( empty( $rows ) ) {
			return false;
		}

		return $rows;
	}

	public function generate_monthly_report( $params = '' ) {
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
			'search'     => '',
		];
		$params  = General::set_args( $params, $default );

		$this->db->select( 'id,invoice_no,jobid,job_type,client_id, GROUP_CONCAT(job_type) as job_type_id , GROUP_CONCAT(id) as concat_id , COUNT(client_id) as count' );

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
			$this->db->where( "DATE(date_done) BETWEEN '$from' AND '$to'" );
		}
		if ( ! empty( $params['search'] ) ) {
			$search = $this->security->xss_clean( $params['search'] );
			if ( strtolower( substr( $search, 0, 3 ) ) == "id:" ) {
				$ids = General::make_array( substr( $search, 3 ) );
				$this->db->where_in( 'id', $ids );
			} else {
				$this->db->group_start();
				$this->db->like( 'invoice_no', $search );
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

		$query['rows'] = $this->db->group_by( 'client_id' )
		                          ->order_by( $params['orderby'], $params['order'] )
		                          ->get( $this->TableSubJob, $params['pagesize'], $limit )
		                          ->result_array();

		if ( ! empty( $query ) ) {
			foreach ( $query['rows'] as $k => $row ) {
				$query['rows'][ $k ]['data'] = $this->db->select( 'id,invoice_no,jobid,job_type,job_status,date_done,qty,price,expense,discount,total,sort' )
				                                        ->where_in( 'id', General::make_array( $row['concat_id'] ) )
				                                        ->get( $this->TableSubJob )
				                                        ->result_array();
			}

			$this->db->select( 'id,invoice_no,jobid,job_type,client_id, GROUP_CONCAT(job_type) as job_type_id , GROUP_CONCAT(id) as concat_id , COUNT(client_id) as count' );

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
				$this->db->where( "DATE(date_done) BETWEEN '$from' AND '$to'" );
			}
			if ( ! empty( $params['search'] ) ) {
				$search = $this->security->xss_clean( $params['search'] );
				if ( strtolower( substr( $search, 0, 3 ) ) == "id:" ) {
					$ids = General::make_array( substr( $search, 3 ) );
					$this->db->where_in( 'id', $ids );
				} else {
					$this->db->group_start();
					$this->db->like( 'invoice_no', $search );
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

		// get pending jobs
		$query['pending'] = self::get_pending_jobs( $params );

		return $query;
	}

	public function get_pending_jobs( $params = '' ) {
		$default = [
			'id'        => '',
			'orderby'   => 'id',
			'order'     => 'DESC',
			'page'      => '1',
			'pagesize'  => '9999999',
			'client_id' => '',
			'time_from' => '',
			'time_to'   => '',
		];
		$params  = General::set_args( $params, $default );

		if ( ! empty( $params['id'] ) ) {
			$this->db->where_in( 'id', General::make_array( $params['id'] ) );
		}
		if ( ! empty( $params['client_id'] ) ) {
			$this->db->where( 'client_id', $params['client_id'] );
		}
		if ( isset( $params['time_from'] ) && $params['time_from'] <> '' ) {
			$from = MyDateTime::mysql_date( $params['time_from'] );
			$to   = MyDateTime::mysql_date( $params['time_to'] );
			$this->db->where( "DATE(job_date) BETWEEN '$from' AND '$to'" );
		}

		$rows = $this->db->group_start()
		                 ->where( 'job_status', 0 )
		                 ->or_where( 'job_status', null )
		                 ->group_end()
		                 ->get( $this->TableSubJob )
		                 ->num_rows();

		return $rows;
	}


	public function get_all_postcode_from_jobs() {

		return $this->db->select( 'id,postcode' )->group_by( 'postcode' )->get( $this->Table )->result_array();
	}

}