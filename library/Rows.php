<?php
function get_rows( $table = "", $page = "1", $pagesize = "5", $Q = '' ) {
	if ( empty( $table ) ) {
		return "Database Table name missing...";
	}
	$ci     = get_instance();
	$offset = ( $page * $pagesize );
	$limit  = ( $offset - $pagesize ) + 1;
	if ( isset( $limit ) && $limit <= 1 ) {
		$limit = 0;
	} else {
		$offset = $offset - 1; // page row display 1-10
		$limit  = $limit - 1; // start which number to load data
	}
	$query["rows"] = $ci->db->get( $table, $pagesize, $limit )->result_array();
	if ( ! empty( $query ) ) {
		$total_records = $ci->db->get( $table )->num_rows();
		$pages         = ceil( $total_records / $pagesize );
		if ( $pages == 0 ) {
			$pages = 1;
		}
		if ( count( $query["rows"] ) == 0 ) {
			$total_records = 1;
		}
		$query["page"]          = $page;
		$query["pages"]         = $pages;
		$query["pagesize"]      = $offset;
		$query["total_records"] = $total_records;
		$query["last_query"]    = $ci->db->last_query();
	}

	return $query;
}

function table_rows_count( $table = "" ) {
	if ( empty( $table ) ) {
		return 0;
	}
	$ci   = get_instance();
	$rows = $ci->db->get( $table )->num_rows();

	return $rows;
}