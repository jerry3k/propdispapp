<?php

class MyDateTime {

	public static function my_date( $d = "", $format = "d-m-Y" ) {
		if ( $d == "0000-00-00" || $d == "0000-00-00 00:00:00" || is_null( $d ) ) {
			return "";
		}

		if ( $d == "" ) {
			return date( $format );
		} else {
			return date( $format, strtotime( $d ) );
		}
	}

	public static function my_datetime( $d = "", $format = "d-m-Y H:i" ) {
		if ( $d == "" ) {
			return date( $format );
		} else if ( $d == "0000-00-00 00:00:00" ) {
			return "";
		} else {
			return date( $format, strtotime( $d ) );
		}
	}

	public static function mysql_date( $date = null, $format = "Y-m-d" ) {
		if ( $date == "0000-00-00" ) {
			return "0000-00-00";
		} else if ( General::xtrim( $date ) == null ) {
			return Date( $format );
		} else if ( General::xtrim( $date ) == "-" ) {
			return "0000-00-00";
		} else {
			return date( $format, strtotime( $date ) );
		}
	}

	public static function mysql_datetime( $date = null, $format = "Y-m-d H:i:s" ) {
		if ( ! is_null( $date ) ) {
			$date = strip_tags( $date );
		}
		if ( $date == null ) {
			return Date( $format );
		} else if ( General::xtrim( $date ) == "-" ) {
			return "0000-00-00 00:00:00";
		} else {
			return date( $format, strtotime( $date ) );
		}
	}
}
