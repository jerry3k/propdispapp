<?php
/*
 *---------------------------------------------------------------
 * SYSTEM CUSTOM public static function
 *---------------------------------------------------------------
 */

//date_default_timezone_set( 'Europe/London' );

class General {

	/**
	 * @return string
	 *
	 * Get current IP address.
	 * See details about IP address at
	 * http://whatismyipaddress.com/ip-address
	 */
	public static function myip() {
		if ( getenv( 'HTTP_CLIENT_IP' ) ) {
			$ip = getenv( 'HTTP_CLIENT_IP' );
		} elseif ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) {
			$ip = getenv( 'HTTP_X_FORWARDED_FOR' );
		} elseif ( getenv( 'HTTP_X_FORWARDED' ) ) {
			$ip = getenv( 'HTTP_X_FORWARDED' );
		} elseif ( getenv( 'HTTP_FORWARDED_FOR' ) ) {
			$ip = getenv( 'HTTP_FORWARDED_FOR' );
		} elseif ( getenv( 'HTTP_FORWARDED' ) ) {
			$ip = getenv( 'HTTP_FORWARDED' );
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		return $ip;
	}

	// get all countries
	public static function countires() {
		return array(
			"United Kingdom",
			"Afghanistan",
			"Albania",
			"Algeria",
			"American Samoa",
			"Andorra",
			"Angola",
			"Anguilla",
			"Antarctica",
			"Antigua and Barbuda",
			"Argentina",
			"Armenia",
			"Aruba",
			"Australia",
			"Austria",
			"Azerbaijan",
			"Bahamas",
			"Bahrain",
			"Bangladesh",
			"Barbados",
			"Belarus",
			"Belgium",
			"Belize",
			"Benin",
			"Bermuda",
			"Bhutan",
			"Bolivia",
			"Bosnia and Herzegowina",
			"Botswana",
			"Bouvet Island",
			"Brazil",
			"British Indian Ocean Territory",
			"Brunei Darussalam",
			"Bulgaria",
			"Burkina Faso",
			"Burundi",
			"Cambodia",
			"Cameroon",
			"Canada",
			"Cape Verde",
			"Cayman Islands",
			"Central African Republic",
			"Chad",
			"Chile",
			"China",
			"Christmas Island",
			"Cocos (Keeling) Islands",
			"Colombia",
			"Comoros",
			"Congo",
			"Congo, the Democratic Republic of the",
			"Cook Islands",
			"Costa Rica",
			"Cote d'Ivoire",
			"Croatia (Hrvatska)",
			"Cuba",
			"Cyprus",
			"Czech Republic",
			"Denmark",
			"Djibouti",
			"Dominica",
			"Dominican Republic",
			"East Timor",
			"Ecuador",
			"Egypt",
			"El Salvador",
			"Equatorial Guinea",
			"Eritrea",
			"Estonia",
			"Ethiopia",
			"Falkland Islands (Malvinas)",
			"Faroe Islands",
			"Fiji",
			"Finland",
			"France",
			"France Metropolitan",
			"French Guiana",
			"French Polynesia",
			"French Southern Territories",
			"Gabon",
			"Gambia",
			"Georgia",
			"Germany",
			"Ghana",
			"Gibraltar",
			"Greece",
			"Greenland",
			"Grenada",
			"Guadeloupe",
			"Guam",
			"Guatemala",
			"Guinea",
			"Guinea-Bissau",
			"Guyana",
			"Haiti",
			"Heard and Mc Donald Islands",
			"Holy See (Vatican City State)",
			"Honduras",
			"Hong Kong",
			"Hungary",
			"Iceland",
			"India",
			"Indonesia",
			"Iran (Islamic Republic of)",
			"Iraq",
			"Ireland",
			"Israel",
			"Italy",
			"Jamaica",
			"Japan",
			"Jordan",
			"Kazakhstan",
			"Kenya",
			"Kiribati",
			"Korea, Democratic People's Republic of",
			"Korea, Republic of",
			"Kuwait",
			"Kyrgyzstan",
			"Lao, People's Democratic Republic",
			"Latvia",
			"Lebanon",
			"Lesotho",
			"Liberia",
			"Libyan Arab Jamahiriya",
			"Liechtenstein",
			"Lithuania",
			"Luxembourg",
			"Macau",
			"Macedonia, The Former Yugoslav Republic of",
			"Madagascar",
			"Malawi",
			"Malaysia",
			"Maldives",
			"Mali",
			"Malta",
			"Marshall Islands",
			"Martinique",
			"Mauritania",
			"Mauritius",
			"Mayotte",
			"Mexico",
			"Micronesia, Federated States of",
			"Moldova, Republic of",
			"Monaco",
			"Mongolia",
			"Montserrat",
			"Morocco",
			"Mozambique",
			"Myanmar",
			"Namibia",
			"Nauru",
			"Nepal",
			"Netherlands",
			"Netherlands Antilles",
			"New Caledonia",
			"New Zealand",
			"Nicaragua",
			"Niger",
			"Nigeria",
			"Niue",
			"Norfolk Island",
			"Northern Mariana Islands",
			"Norway",
			"Oman",
			"Pakistan",
			"Palau",
			"Panama",
			"Papua New Guinea",
			"Paraguay",
			"Peru",
			"Philippines",
			"Pitcairn",
			"Poland",
			"Portugal",
			"Puerto Rico",
			"Qatar",
			"Reunion",
			"Romania",
			"Russian Federation",
			"Rwanda",
			"Saint Kitts and Nevis",
			"Saint Lucia",
			"Saint Vincent and the Grenadines",
			"Samoa",
			"San Marino",
			"Sao Tome and Principe",
			"Saudi Arabia",
			"Senegal",
			"Seychelles",
			"Sierra Leone",
			"Singapore",
			"Slovakia (Slovak Republic)",
			"Slovenia",
			"Solomon Islands",
			"Somalia",
			"South Africa",
			"South Georgia and the South Sandwich Islands",
			"Spain",
			"Sri Lanka",
			"St. Helena",
			"St. Pierre and Miquelon",
			"Sudan",
			"Suriname",
			"Svalbard and Jan Mayen Islands",
			"Swaziland",
			"Sweden",
			"Switzerland",
			"Syrian Arab Republic",
			"Taiwan, Province of China",
			"Tajikistan",
			"Tanzania, United Republic of",
			"Thailand",
			"Togo",
			"Tokelau",
			"Tonga",
			"Trinidad and Tobago",
			"Tunisia",
			"Turkey",
			"Turkmenistan",
			"Turks and Caicos Islands",
			"Tuvalu",
			"Uganda",
			"Ukraine",
			"United Arab Emirates",
			"United States",
			"United States Minor Outlying Islands",
			"Uruguay",
			"Uzbekistan",
			"Vanuatu",
			"Venezuela",
			"Vietnam",
			"Virgin Islands (British)",
			"Virgin Islands (U.S.)",
			"Wallis and Futuna Islands",
			"Western Sahara",
			"Yemen",
			"Yugoslavia",
			"Zambia",
			"Zimbabwe",
		);
	}

	// check if is localhost
	public static function is_localhost() {
		$whitelist = array( '127.0.0.1', '::1', '127.0.0.1:1017' );
		if ( in_array( $_SERVER['REMOTE_ADDR'], $whitelist ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * @return bool
	 *
	 * Check that current server is localhost or not.
	 */
	public static function localhost() {
		if ( ! isset( $_SERVER["HTTP_HOST"] ) ) {
			return false;
		}

		return ( $_SERVER["REMOTE_ADDR"] == "::1" || $_SERVER["REMOTE_ADDR"] == "127.0.0.1:3307" || $_SERVER["REMOTE_ADDR"] == "127.0.0.1" || $_SERVER["REMOTE_ADDR"] == "127.0.0.1:1017" || $_SERVER["HTTP_HOST"] == "localhost" || $_SERVER["HTTP_HOST"] == "127.0.0.1" || $_SERVER["HTTP_HOST"] == "127.0.0.1:1017" );
	}

	// Name string Replaces all spaces with hyphens.
	public static function clean( $name ) {
		$string = str_replace( ' ', ' ', $name ); // Replaces all spaces with hyphens.

		return preg_replace( '/[^A-Za-z0-9\-]/', ' ', $string ); // Removes special chars.
	}

	/**
	 * @param $date
	 *
	 * @return bool
	 *
	 * This public static function return true or false after check that provide date is empty or not.
	 * True against "", "0000-00-00", NULL, 0, "0000-00-00 00:00:00"
	 */
	public static function empty_date( $date ) {
		$date = trim( $date );
		if ( empty( $date ) || is_null( $date ) ) {
			return true;
		}
		if ( $date == "0000-00-00" ) {
			return true;
		}
		if ( $date == "0000-00-00 00:00:00" ) {
			return true;
		}

		$date = date( "Y-m-d", strtotime( $date ) );
		if ( $date == "1970-01-01" ) {
			return true;
		}

		return false;
	}

	/**
	 * @return string
	 *
	 * Get current web URL from browser.
	 */
	public static function my_url() {
		return "http" . ( ( ! empty( $_SERVER['HTTPS'] ) ) ? "s" : "" ) . "://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	}

	/**
	 * @param $email
	 *
	 * @return mixed
	 *
	 * This public static function returns TRUE/FALSE about string if it is an email address or not.
	 */
	public static function is_email( $email ) {
		return filter_var( $email, FILTER_VALIDATE_EMAIL );
	}


	/**
	 * @param string $format
	 *
	 * @return false|string
	 *
	 * This public static function will return current GMT time.
	 */
	public static function GMT_now( $format = "Y-m-d H:i:s" ) {
		return date( $format, time() - date( "Z", time() ) );
	}

	/**
	 * @param $datetime
	 *
	 * @return false|string
	 *
	 * This public static function will convert GMT time into current time of user.
	 */
	public static function GMT_to_UserTime( $datetime ) {
		$time = strtotime( $datetime );

		return date( "Y-m-d H:i:s", $time + date( "Z", $time ) );
	}

	/**
	 * @param string $format
	 *
	 * @return false|string
	 *
	 * Returns current date and time.. Same like my_datetime();
	 */
	public static function current_time( $format = 'Y-m-d H:i:s' ) {
		return Date( $format );
	}

	/**
	 * @return bool|mixed|null|string
	 *
	 * Get current timezone set in DB.
	 */
	public static function get_time_zone() {
		$tz = get_option( 'time_zone' );
		if ( $tz == "" ) {
			return '5';
		} else {
			return $tz;
		}
	}

	/**
	 * @param      $ar
	 * @param bool $return
	 *
	 * @return mixed
	 *
	 * Return array/object/boolean in human friendly form.
	 */
	public static function show_array( $ar, $return = false ) {
		if ( is_null( $ar ) ) {
			$ar = "NULL";
		}
		if ( is_bool( $ar ) && $ar ) {
			$ar = "true";
		} elseif ( is_bool( $ar ) && ! $ar ) {
			$ar = "false";
		}

		if ( $return ) {
			return print_r( $ar, true );
		} else {
			echo "<pre>\n";
			print_r( $ar );
			echo "</pre>\n";
		}
	}

	/**
	 * @param $string
	 *
	 * @return string
	 *
	 * Advanced trim()
	 */
	public static function xtrim( $string ) {
		$string = trim( $string, " \t\n\r\0\x0Bÿ" );

		return $string;
	}

	/**
	 * @param $str
	 *
	 * @return mixed
	 *
	 * Ready a string before saving into MySQL query.
	 * e.g. converts ' into ''.
	 */
	public static function strtodb( $str ) {
		//return rawurlencode($str);
		//return addslashes($str);
		return str_replace( "'", "''", $str );
	}

	/**
	 * @param $str
	 *
	 * @return string
	 *
	 * Same as strtodb.. only trim before conversion.
	 */
	public static function strtodbc( $str ) {
		$str = xtrim( $str );
		//$str = mb_convert_encoding($str, "UTF-8", "auto");
		//return $str;
		return str_replace( "'", "''", $str );
		//return addslashes( $str );
	}

	/**
	 * @param $str
	 *
	 * @return string
	 *
	 * Converts string got from MySQL and ready for application
	 */
	public static function strfromdb( $str ) {
		$ar1 = [
			"u00d8",
			"u00e0",
			"u00e5",
		];
		$ar2 = [
			"Ø",
			"à",
			"å",
		];
		$str = str_replace( $ar1, $ar2, $str );

		return rawurldecode( $str );
	}

	/**
	 * @param $string
	 *
	 * @return string
	 *
	 * Bindia version of utf8_decode();
	 */
	public static function _utf8_decode( $string ) {
		$tmp   = $string;
		$count = 0;
		while ( mb_detect_encoding( $tmp ) == "UTF-8" ) {
			$tmp = utf8_decode( $tmp );
			$count ++;
		}

		for ( $i = 0; $i < $count - 1; $i ++ ) {
			$string = utf8_decode( $string );

		}

		return $string;
	}

	/**
	 * @return bool
	 *
	 * Check that GD library is available or not on server.
	 */
	public static function get_gd_info() {
		if ( extension_loaded( 'gd' ) and imagetypes() & IMG_PNG and imagetypes() & IMG_GIF and imagetypes() & IMG_JPG and imagetypes() & IMG_WBMP ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * @return mixed
	 *
	 * Check server limit for upload a file.
	 */
	public static function get_upload_limit() {
		$max_upload   = (int) ( ini_get( 'upload_max_filesize' ) );
		$max_post     = (int) ( ini_get( 'post_max_size' ) );
		$memory_limit = (int) ( ini_get( 'memory_limit' ) );
		$upload_mb    = min( $max_upload, $max_post, $memory_limit );

		return $upload_mb;
	}

	/**
	 * @param $arg
	 *
	 * @return string
	 *
	 * Converts bytes into human read format.
	 * e.g. 1024 > 1Kb
	 */
	public static function formatsize( $arg ) {
		if ( $arg > 0 ) {
			$j   = 0;
			$ext = [ "b", "K", "M", "G", "T" ];
			while ( $arg >= pow( 1024, $j ) ) {
				++ $j;
			}

			return round( $arg / pow( 1024, $j - 1 ) * 100 ) / 100 . $ext[ $j - 1 ];
		} else {
			return "0b";
		}
	}

	/**
	 * @param        $from
	 * @param string $to
	 * @param bool   $show_time
	 * @param string $format
	 *
	 * @return false|string
	 *
	 * Converts a time into human read friendly.
	 * e.g. 1 mintue ago.
	 */
	public static function human_time_diff( $from, $to = '', $show_time = true, $format = "d-m-Y H:i" ) {
		if ( empty( $to ) ) {
			$to = my_datetime();
		}

		$from      = strtotime( $from );
		$to        = strtotime( $to );
		$ago_after = "ago";
		if ( $to == $from ) {
			$diff = (int) abs( $to - $from );
		} elseif ( $to < $from ) {
			$ago_after = "later";
			$diff      = (int) abs( $to - $from );
		} else {
			$diff = (int) ( $to - $from );
		}

		if ( $diff <= 3600 ) {
			$mins = round( $diff / 60 );
			if ( $mins <= 1 ) {
				$mins = 1;
			}

			if ( $mins < 2 ) {
				if ( $show_time ) {
					return $mins . " min $ago_after";
				} else {
					return $mins . " min";
				}
			}

			if ( $show_time ) {
				$since = $mins . " mins $ago_after";
			} else {
				$since = $mins . " mins";
			}
		} else if ( ( $diff <= 86400 ) && ( $diff > 3600 ) ) {
			$hours = round( $diff / 3600 );
			if ( $hours <= 1 ) {
				$hours = 1;
			}
			if ( $hours < 2 ) {
				if ( $show_time ) {
					return $hours . " hour $ago_after";
				} else {
					return $hours . " hour";
				}
			}
			if ( $show_time ) {
				$since = $hours . " hours $ago_after";
			} else {
				$since = $hours . " hours";
			}
		} elseif ( $diff >= 86400 ) {
			$days = round( $diff / 86400 );
			if ( $days <= 1 ) {
				$days = 1;
			}
			if ( $days > 20 ) {
				return date( $format, $from );
			}
			if ( $days < 2 ) {
				if ( $show_time ) {
					return $days . " day $ago_after";
				} else {
					return $days . " day";
				}
			}
			if ( $show_time ) {
				$since = $days . " days $ago_after";
			} else {
				$since = $days . " days";
			}
		} else {
			if ( $show_time ) {
				$since = date( 'd-M-Y', $from );
			} else {
				$since = date( 'd-M-Y', $from );
			}
		}

		return $since;
	}

	/**
	 * @param $url
	 *
	 * @return mixed|string
	 *
	 * Converts a url into a simple name.
	 * e.g. my_url > My Url
	 */
	public static function url_to_name( $url ) {
		$old = [ '_', '-' ];
		$new = [ " ", ' ' ];
		$url = str_replace( $old, $new, $url );
		$url = str_replace( '   ', ' ', $url );
		$url = str_replace( '  ', ' ', $url );

		$url = ucwords( strtolower( $url ) );

		return $url;
	}

	/**
	 * @param $str
	 *
	 * @return string
	 *
	 * String proper format.
	 * e.g. nasir khilji > Nasir Khilji
	 */
	public static function strtoproper( $str ) {
		return ucwords( strtolower( $str ) );
	}

	/**
	 * @param $dir
	 *
	 * Remove folder and all files/folders in it.
	 */
	public static function rrmdir( $dir ) {
		if ( is_dir( $dir ) ) {
			$objects = scandir( $dir );
			foreach ( $objects as $object ) {
				if ( $object != "." && $object != ".." ) {
					if ( is_dir( $dir . "/" . $object ) ) {
						self::rrmdir( $dir . "/" . $object );
					} else if ( is_file( $dir . "/" . $object ) ) {
						@unlink( $dir . "/" . $object );
					}
				}
			}
			reset( $objects );
			@rmdir( $dir );
		}
	}

	/**
	 * Bindia flush version and scroll at bottom.
	 */
	public static function my_flush() {
		echo( str_repeat( ' ', 256 ) );
		// check that buffer is actually set before flushing
		if ( ob_get_length() ) {
			@ob_flush();
			@flush();
			@ob_end_flush();
		}
		@ob_start();
		echo '<script language="javascript">window.scrollBy(0,1000);</script>';
	}

	/**
	 * @return string
	 *
	 * Get referrer URL.
	 */
	public static function referral_url() {
		return isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : '';
	}

	/**
	 * @param $val
	 *
	 * @return bool
	 *
	 * Check that provided number is integer or not.
	 */
	public static function is_really_int( &$val ) {
		if ( ! is_numeric( $val ) ) {
			return false;
		}
		$num = (int) $val;
		if ( $val == $num ) {
			$val = $num;

			return true;
		}

		return false;
	}

	/**
	 * @param int    $length
	 * @param string $possible
	 *
	 * @return string
	 *
	 * Generate a random password string.
	 */
	public static function make_password( $length = 8, $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ!@#$%^&*()-><{}[]=+?" ) {
		// start with a blank password
		$password = "";

		// define possible characters - any character in this string can be
		// picked for use in the password, so if you want to put vowels back in
		// or add special characters such as exclamation marks, this is where
		// you should do it

		// we refer to the length of $possible a few times, so let's grab it now
		$maxlength = strlen( $possible );

		// check for length overflow and truncate if necessary
		if ( $length > $maxlength ) {
			$length = $maxlength;
		}

		// set up a counter for how many characters are in the password so far
		$i = 0;

		// add random characters to $password until $length is reached
		while ( $i < $length ) {

			// pick a random character from the possible ones
			$char = substr( $possible, mt_rand( 0, $maxlength - 1 ), 1 );

			// have we already used this character in $password?
			if ( ! strstr( $password, $char ) ) {
				// no, so it's OK to add it onto the end of whatever we've already got...
				$password .= $char;
				// ... and increase the counter by one
				$i ++;
			}

		}

		// done!
		return $password;

	}

	/**
	 * @param string $U
	 * @param int    $length
	 *
	 * @return string
	 *
	 * Generate a random username
	 */
	public static function make_username( $U = 'user', $length = 5 ) {
		// start with a blank password
		$user = "";

		// define possible characters - any character in this string can be
		// picked for use in the password, so if you want to put vowels back in
		// or add special characters such as exclamation marks, this is where
		// you should do it
		$possible = "012346789";

		// we refer to the length of $possible a few times, so let's grab it now
		$maxlength = strlen( $possible );

		// check for length overflow and truncate if necessary
		if ( $length > $maxlength ) {
			$length = $maxlength;
		}

		// set up a counter for how many characters are in the password so far
		$i = 0;

		// add random characters to $password until $length is reached
		while ( $i < $length ) {

			// pick a random character from the possible ones
			$char = substr( $possible, mt_rand( 0, $maxlength - 1 ), 1 );

			// have we already used this character in $password?
			if ( ! strstr( $user, $char ) ) {
				// no, so it's OK to add it onto the end of whatever we've already got...
				$user .= $char;
				// ... and increase the counter by one
				$i ++;
			}

		}

		// done!
		return $U . $user;

	}

	/**
	 * @param $filename
	 *
	 * @return string
	 *
	 * Get only file extension from filename.
	 */
	public static function get_file_extension( $filename ) {
		$f = pathinfo( $filename );
		if ( isset( $f["extension"] ) ) {
			return strtolower( trim( $f["extension"] ) );
		} else {
			return "";
		}
		//return end(explode(".", $filename));
	}

	/**
	 * @param $filename
	 *
	 * @return string
	 *
	 * Get filename without extension from a string.
	 * e.g. bindia_filename.xlsx > bindia_filename
	 */
	public static function get_file_name_without_extension( $filename ) {
		$f = pathinfo( $filename );
		if ( isset( $f["filename"] ) ) {
			return $f["filename"];
		}

		return "";
	}

	/**
	 * @param     $month
	 * @param int $len
	 *
	 * @return mixed|string
	 *
	 * Convert month number into month name with specified length.
	 * e.g. 12 > Dec
	 */
	public static function month_name( $month, $len = 3 ) {
		$M = [
			'January',
			'February',
			'March',
			'April',
			'May',
			'June',
			'July',
			'August',
			'September',
			'October',
			'November',
			'December',
		];
		if ( $len == 0 ) {
			return $M[ $month - 1 ];
		} else {
			return substr( $M[ $month - 1 ], 0, $len );
		}
	}

	/**
	 * @param $arr
	 *
	 * @return bool
	 *
	 * Check if provided array is an index array.
	 */
	public static function is_indexed_array( $arr ) {
		return array_values( $arr ) === $arr;
	}

	/**
	 * @param $needle
	 * @param $haystack
	 *
	 * @return bool
	 *
	 * Case insesitive version of PHP's in_array();
	 */
	public static function in_arrayi( $needle, $haystack ) {
		for ( $h = 0; $h < count( $haystack ); $h ++ ) {
			$haystack[ $h ] = strtolower( $haystack[ $h ] );
		}

		return in_array( strtolower( $needle ), $haystack );
	}

	/**
	 * @param      $mon
	 * @param bool $full
	 *
	 * @return false|string
	 *
	 * Get month name from month number.
	 * e.g 12 > Dec
	 */
	public static function get_month_name( $mon, $full = false ) {
		if ( $full ) {
			return date( 'F', mktime( 0, 0, 0, $mon ) );
		} else {
			return date( 'M', mktime( 0, 0, 0, $mon ) );
		}
	}

	/**
	 * @param $str
	 *
	 * @return bool
	 *
	 * Check if provided string is valid date.
	 */
	public static function is_date( $str ) {
		$stamp = strtotime( $str );

		if ( ! is_numeric( $stamp ) ) {
			return false;
		}
		$month = date( 'm', $stamp );
		$day   = date( 'd', $stamp );
		$year  = date( 'Y', $stamp );

		if ( checkdate( $month, $day, $year ) ) {
			return true;
		}

		return false;
	}

	/**
	 * @param $elem
	 * @param $array
	 *
	 * @return bool
	 *
	 * Check if provided array is multi dimensional array or not.
	 */
	public static function in_multiarray( $elem, $array ) {
		$top    = sizeof( $array ) - 1;
		$bottom = 0;
		while ( $bottom <= $top ) {
			if ( $array[ $bottom ] == $elem ) {
				return true;
			} else if ( is_array( $array[ $bottom ] ) ) {
				if ( self::in_multiarray( $elem, ( $array[ $bottom ] ) ) ) {
					return true;
				}
			}

			$bottom ++;
		}

		return false;
	}


	/**
	 * @param $filename
	 *
	 * @return bool
	 *
	 * This public static function will return true if filename extension is doc, docx, xls, xlsx, pdf.
	 * @Note: This public static function doesn't check existance of file.
	 */
	public static function is_file_document( $filename ) {
		$filename = basename( $filename );
		$ext      = self::get_file_extension( $filename );       // Getting extension of file.

		switch ( $ext ) {
			case "doc":
			case "docx":
			case "xls":
			case "xlsx":
			case "pdf":
				return true;
			default:
				return false;
		}
	}

	/**
	 * @param $url
	 *
	 * @return string
	 *
	 * Get google's view URL of a file.
	 */
	public static function google_docs_view_url( $url, $embedded = true ) {
		//$url = str_replace( ",", "%2C", $url );

		if ( self::localhost() ) {
			return $url;
		}
		if ( ! self::is_file_document( $url ) ) {
			return $url;
		}
		if ( ! self::localhost() ) {
			//$url = utf8_decode( $url );
		}
		if ( $embedded ) {
			return "https://docs.google.com/viewer?url=" . urlencode( $url ) . "&embedded=true";
		}

		return "https://docs.google.com/viewerng/viewer?url=" . urlencode( $url );
	}

	/**
	 * @param $fileName
	 *
	 * @return bool
	 *
	 * This public static function will return true if provided filename is image type.
	 * @Note: This public static function doesn't check existence of file.
	 */
	public static function is_image( $fileName ) {
		$ext = substr( strrchr( basename( $fileName ), '.' ), 1 );

		if ( $ext <> "" ) {
			$ext = strtolower( $ext );
			switch ( $ext ) {
				case 'gif':
				case 'jpeg':
				case 'jpg':
				case 'png':
					#case 'psd':
					#case 'bmp':
					#case 'tiff':
					#case 'jp2'
					#case 'iff':
					#case 'ico':
					return true;
				default:
					return false;
			}
		} else {
			return false;
		}
	}

	/**
	 * @param $filepath
	 *
	 * @return bool
	 *
	 * Check if provide file is an image file.
	 */
	public static function is_image_file( $filepath ) {
		if ( ! isset( $filepath ) ) {
			return false;
		}
		$r = @getimagesize( $filepath );
		if ( $r === false ) {
			return false;
		}

		return true;
	}


	/**
	 * @param $a
	 *
	 * @return string
	 *
	 * Converts boolean into yes/no.
	 */
	public static function YesNo( $a ) {
		$a = (bool) $a;
		if ( $a ) {
			return "Yes";
		} else {
			return "No";
		}
	}


	/**
	 * @param $folderPath
	 *
	 * @return array
	 *
	 * Get array of only image files from a folder path.
	 */
	public static function get_images( $folderPath ) {
		$folderPath = rtrim( $folderPath, "/" ) . "/";
		$out        = [];
		if ( ! is_dir( $folderPath ) ) {
			return $out;
		}
		$files = glob( $folderPath . "*" );
		foreach ( $files as $file ) {
			if ( self::is_image( $file ) ) {
				$out[] = $file;
			}
		}

		return $out;
	}

	/**
	 * @param      $folderPath
	 * @param bool $ignore_indexhtml
	 *
	 * @return array
	 *
	 * Get array of files from a folder path.
	 */
	public static function get_files( $folderPath, $ignore_indexhtml = false ) {
		$out = [];

		if ( ! is_dir( $folderPath ) ) {
			return $out;
		}
		$folderPath = rtrim( $folderPath, "/" ) . "/";
		$files      = glob( $folderPath . "*" );
		foreach ( $files as $x => &$file ) {
			if ( is_dir( $file ) ) {
				unset( $files[ $x ] );
			}
			if ( $ignore_indexhtml && basename( $file ) == "index.html" ) {
				unset( $files[ $x ] );
			}
			$file = str_replace( "\\", "/", $file );
		}

		$files = array_values( $files );

		return $files;
	}

	/**
	 * @param      $folderPath
	 * @param bool $ignore_indexhtml
	 *
	 * @return array
	 *
	 * Get array of folders from folder path.
	 */
	public static function get_folders( $folderPath, $ignore_indexhtml = false ) {
		$out = [];
		if ( ! is_dir( $folderPath ) ) {
			return $out;
		}
		$folders = glob( $folderPath . "*" );
		foreach ( $folders as $x => $folder ) {
			if ( ! is_dir( $folder ) ) {
				unset( $folders[ $x ] );
			}
			//if ($ignore_indexhtml && basename($folder)=="index.html") unset($folders[$x]);
		}

		return $folders;
	}

	/**
	 * @param $str
	 *
	 * @return mixed
	 *
	 * Set a string HTML.
	 */
	public static function html( $str ) {
		$str = str_replace( "\n", "<br />", $str );
		$str = str_replace( '"', "&quot;", $str );
		$str = str_replace( "'", "&#39;", $str );

		return $str;
	}


	/**
	 * @param $args
	 * @param $default
	 *
	 * @return array|string
	 *
	 * Sets arguments. This public static function is mostly used in methods of classes in Bindia library.
	 */
	public static function set_args( $args, $default ) {
		if ( ! is_array( $args ) ) {
			$args = str_replace( " = ", "=", $args );
			$args = str_replace( " =", "=", $args );
			$args = str_replace( " =", "=", $args );
			$args = str_replace( " =", "=", $args );
			$args = stripslashes( $args );
			parse_str( $args, $args );
		}
		if ( ! is_array( $args ) ) {
			return [];
		}
		$default = self::make_array( $default );
		if ( ! is_array( $default ) ) {
			return $default;
		}
		foreach ( $default as $k => $v ) {
			if ( ! isset( $args[ $k ] ) ) {
				$args[ $k ] = $v;
			}
		}
		if ( get_magic_quotes_gpc() ) {
			$args = array_map( "stripslashes", $args );
		}

		return $args;
	}


	/**
	 * @param string $url
	 *
	 * @return bool
	 *
	 * Check if provided string is URL or not.
	 */
	public static function is_url( $url ) {
		if ( filter_var( $url, FILTER_VALIDATE_URL ) === false ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * @param string $ip_addr
	 *
	 * @return bool
	 *
	 * Check if provided string is valid IP address or not.
	 */
	public static function is_ip( $ip_addr ) {
		//first of all the format of the ip address is matched
		if ( preg_match( "/^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/", $ip_addr ) ) {
			//now all the intger values are separated
			$parts = explode( ".", $ip_addr );
			//now we need to check each part can range from 0-255
			foreach ( $parts as $ip_parts ) {
				if ( intval( $ip_parts ) > 255 || intval( $ip_parts ) < 0 ) {
					return false;
				} //if number is not within range of 0-255
			}

			return true;
		} else {
			return false;
		}
	}

	/**
	 * @param $string
	 *
	 * @return string
	 *
	 * Converts string into hexa code.
	 */
	public static function strToHex2( $string ) {
		$hex = '';
		for ( $i = 0; $i < strlen( $string ); $i ++ ) {
			$ord     = ord( $string[ $i ] );
			$hexCode = dechex( $ord );
			$hex     .= substr( '0' . $hexCode, - 2 );
		}

		return strToUpper( $hex );
	}

	/**
	 * @param $initial
	 *
	 * @return array
	 *
	 * Converts string into RGB array
	 */
	public static function strToHex( $initial ) {
		$checksum = md5( $initial );

		return [
			"R" => hexdec( substr( $checksum, 0, 2 ) ),
			"G" => hexdec( substr( $checksum, 2, 2 ) ),
			"B" => hexdec( substr( $checksum, 4, 2 ) ),
		];
	}

	/**
	 * @param $hex
	 *
	 * @return string
	 *
	 * Converts hexa into string
	 */
	public static function hexToStr( $hex ) {
		$string = '';
		for ( $i = 0; $i < strlen( $hex ) - 1; $i += 2 ) {
			$string .= chr( hexdec( $hex[ $i ] . $hex[ $i + 1 ] ) );
		}

		return $string;
	}

	/**
	 * @param $var
	 *
	 * @return string
	 *
	 * Debug public static function for Bindia system
	 */
	public static function debug( $var ) {
		if ( is_array( $var ) || is_object( $var ) ) {
			$str = "<pre>" . print_r( $var, true ) . "</pre>\n";
		} elseif ( is_null( $var ) ) {
			$str = "NULL\n";
		} elseif ( is_bool( $var ) ) {
			if ( $var ) {
				$str = "TRUE\n";
			} else {
				$str = "FALSE\n";
			}
		} else {
			$str = $var . "\n";
		}

		$bt   = debug_backtrace();
		$file = $bt[0]["file"];
		$line = $bt[0]["line"];

		if ( ! self::localhost() ) {
			$str .= "<br><br>debug public static function in file<br><b>" . $file;
			$str .= "GET:<pre>" . print_r( $_GET, true ) . "</pre>";
			$str .= "POST:<pre>" . print_r( $_POST, true ) . "</pre>";
			$str .= "</b><br>Line # <b>" . $line . "</b>\nTime: " . MyDateTime::my_datetime();

			return @mail( 'nasirkhilji10@gmail.com', 'Local Work Developer: Debug', $str );
		} else {
			$str = "File: $file, Line #{$line}" . PHP_EOL . $str;
			file_put_contents( ROOT_PATH . 'logs.txt', $str, FILE_APPEND );
		}
	}


	/**
	 * @param string $string
	 *
	 * @return bool
	 *
	 * Check if provided string is json or not.
	 */
	public static function is_json( $string ) {
		if ( is_numeric( $string ) ) {
			return false;
		}
		if ( is_bool( $string ) ) {
			return false;
		}
		if ( is_null( $string ) ) {
			return false;
		}
		if ( ! is_string( $string ) ) {
			return false;
		}
		if ( $string == "" || $string == " " ) {
			return false;
		}
		@json_decode( $string );

		return ( json_last_error() == JSON_ERROR_NONE );
	}


	/**
	 * @param      $str
	 * @param bool $assoc
	 *
	 * @return mixed|string
	 *
	 * Json decode version of Bindia.
	 */
	public static function json_decode_( $str, $assoc = false ) {
		$encoding = mb_detect_encoding( $str, "auto" );
		if ( $encoding == 'UTF-8' ) {
			$str = utf8_encode( $str );
		}
		$str = json_decode( $str, $assoc );

		return $str;
	}

	public static function json_encode_( $array, $options = 0 ) {
		$encoded = json_encode( $array, $options );

		if ( $encoded === false ) {
			foreach ( $array as &$value ) {
				$value = self::utf8_encode_( $value );
			}
		}

		$encoded = json_encode( $array, $options );

		return $encoded;
	}

	/**
	 * @param $str
	 *
	 * @return string
	 *
	 * utf8_encode version of Bindia.
	 */
	public static function utf8_encode_( $str ) {
		$encoding = mb_detect_encoding( $str, "auto" );
		if ( $encoding == 'UTF-8' ) {
			$str = utf8_encode( $str );
		} else {
			//$str = stripslashes($str);
		}

		return $str;
	}

	/**
	 * @param       $array
	 * @param int   $preserve_keys
	 * @param array $newArray
	 *
	 * @return array
	 *
	 * Converts associative array into number array
	 */
	public static function array_flatten( $array, $preserve_keys = 0, $newArray = [] ) {
		foreach ( $array as $key => $child ) {
			if ( is_array( $child ) ) {
				$newArray = array_flatten( $child, $preserve_keys, $newArray );
			} elseif ( $preserve_keys + is_string( $key ) > 1 ) {
				$newArray[ $key ] = $child;
			} else {
				$newArray[] = $child;
			}
		}

		return $newArray;
	}


	/**
	 * @param        $IP
	 * @param string $type
	 *
	 * @return string
	 *
	 * Get IP's information from Google's API.
	 */
	public static function get_ip_information( $IP, $type = "html" ) {
		if ( strtolower( $type ) == "html" ) {
			$details = json_decode( file_get_contents( "http://ipinfo.io/{$IP}/json" ), true );
			$html    = "";
			foreach ( $details as $k => $v ) {
				$html .= $k . " = " . $v . "<br />";
			}
			$html .= "<img src='https://maps.googleapis.com/maps/api/staticmap?center={$details["loc"]}&zoom=9&size=600x300&sensor=false' />";

			return $html;
		}
	}

	/**
	 * @param int $year
	 *
	 * @return int
	 *
	 * Get total number of weeks in an year.
	 */
	public static function getIsoWeeksInYear( $year ) {
		$date = new MyDateTime;
		$date->setISODate( $year, 53 );

		return ( $date->format( "W" ) === "53" ? 53 : 52 );
	}

	/**
	 * @param int    $length
	 * @param string $characters
	 *
	 * @return string
	 *
	 * This public static function will generate random password string.
	 */
	public static function generate_password( $length = 10, $characters = '0123456789asbcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ' ) {
		$randomString = '';
		for ( $i = 0; $i < $length; $i ++ ) {
			$randomString .= $characters[ rand( 0, strlen( $characters ) - 1 ) ];
		}

		return $randomString;
	}

	# Conver php array into javascript array.

	/**
	 * @param string $s
	 *
	 * @return string
	 */
	public static function js_str( $s ) {
		return '"' . addcslashes( $s, "\0..\37\"\\" ) . '"';
	}

	/**
	 * @param array $array
	 *
	 * @return string
	 */
	public static function js_array( $array ) {
		$temp = array_map( 'js_str', $array );

		return '[' . implode( ',', $temp ) . ']';
	}


	/**
	 * @return bool|int
	 *
	 * Check if current web browser is Internet Explorer.
	 */
	public static function is_ie() {
		if ( ! isset( $_SERVER['HTTP_USER_AGENT'] ) ) {
			return false;
		}

		return strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE' );
	}

	/**
	 * @param $string
	 *
	 * @return bool
	 *
	 * Check if a string is English string.
	 */
	public static function is_english( $string ) {
		return strlen( $string ) == strlen( utf8_decode( $string ) );
	}

	/**
	 * @param        $time
	 * @param string $what
	 * @param string $format
	 *
	 * @return false|string
	 */
	public static function time_pulse( $time, $what = "up", $format = "d-M-Y H:i" ) {
		$time = strip_tags( $time );
		$m    = date( "i", strtotime( $time ) );
		if ( strtolower( $what ) == "up" ) {
			if ( $m >= 0 && $m < 15 ) {
				$m = 15;
			} elseif ( $m >= 15 && $m < 30 ) {
				$m = 30;
			} elseif ( $m >= 30 && $m < 45 ) {
				$m = 45;
			} elseif ( $m >= 45 && $m <= 59 ) {
				$m = 00;
			}
			if ( $m == "00" ) {
				return date( $format, strtotime( date( "d-M-Y H:$m", strtotime( $time . " +1 Hour" ) ) ) );
			} else {
				return date( $format, strtotime( date( "d-M-Y H:$m", strtotime( $time ) ) ) );
			}
		} else if ( strtolower( $what ) == "down" ) {
			if ( $m <= 59 && $m > 45 ) {
				$m = 45;
			} elseif ( $m <= 46 && $m > 30 ) {
				$m = 30;
			} elseif ( $m <= 30 && $m > 15 ) {
				$m = 15;
			} elseif ( $m > 1 ) {
				$m = 0;
			} elseif ( $m == 0 ) {
				$m = - 45;
			}

			if ( $m == "-45" ) {
				return date( $format, strtotime( date( "d-M-Y H:45", strtotime( $time . " -1 Hour" ) ) ) );
			} else {
				return date( $format, strtotime( date( "d-M-Y H:$m", strtotime( $time ) ) ) );
			}
		} else {
			return date( $format, strtotime( $time ) );
		}
	}

	/**
	 * @param        $arr
	 * @param string $sep
	 * @param bool   $considerLineBreaks
	 *
	 * @return array|mixed
	 *
	 * Convert string or json data into an array
	 */
	public static function make_array( $arr, $sep = ",", $considerLineBreaks = false ) {
		if ( is_string( $arr ) && trim( $arr ) == "" ) {
			return [];
		}
		if ( is_array( $arr ) ) {
			return $arr;
		}
		if ( self::is_json( $arr ) ) {
			$arr = json_decode( $arr, true );

			return $arr;
		}
		if ( $considerLineBreaks ) {
			$arr = str_replace( "\n", $sep, $arr );
		}
		//$arr = str_replace("'", "''", $arr);            // To avoid error MySQL insertion/update.
		$arr = explode( $sep, $arr );
		$arr = array_map( 'trim', $arr );
		$arr = array_filter( $arr );

		return $arr;
	}

	/**
	 * @param $a
	 * @param $b
	 *
	 * @return int
	 */
	public static function my_cmp( $a, $b ) {
		if ( $a["order"] == $b["order"] ) {
			return 0;
		}

		return ( $a["order"] < $b["order"] ) ? - 1 : 1;
	}

	/**
	 * @param $url
	 *
	 * @return mixed
	 *
	 * file_get_contents public static function with CURL.
	 */
	public static function file_get_contents_curl( $url ) {
		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
		curl_setopt( $ch, CURLOPT_HEADER, 0 );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt( $ch, CURLOPT_VERBOSE, true );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );

		$data = curl_exec( $ch );
		curl_close( $ch );

		return $data;
	}


	/**
	 * @param $string
	 *
	 * @return bool|string
	 */
	public static function time_parse( $string ) {
		$result = date_parse( $string );
		if ( $result === false ) {
			return false;
		}
		if ( $result["hour"] === false ) {
			return false;
		}
		if ( $result["minute"] === false ) {
			return false;
		}
		if ( $result["hour"] < 10 ) {
			$result["hour"] = "0" . $result["hour"];
		}
		if ( $result["minute"] < 10 ) {
			$result["minute"] = "0" . $result["minute"];
		}

		return $result["hour"] . ":" . $result["minute"];
	}

	/**
	 * @return bool
	 *
	 * Check is current URL has https: (s)
	 */
	public static function is_ssl() {
		if ( isset( $_SERVER['HTTPS'] ) ) {
			if ( 'on' == strtolower( $_SERVER['HTTPS'] ) ) {
				return true;
			}
			if ( '1' == $_SERVER['HTTPS'] ) {
				return true;
			}
		} elseif ( isset( $_SERVER['SERVER_PORT'] ) && ( '443' == $_SERVER['SERVER_PORT'] ) ) {
			return true;
		}

		return false;
	}


	/**
	 * @param $number
	 * @param $decimals
	 *
	 * @return string
	 *
	 * Number format for danish rules.
	 */
	public static function number_format2( $number, $decimals ) {
		if ( ! is_numeric( $number ) ) {
			return "";
		}

		return number_format( $number, $decimals, ",", "." );
	}


	/**
	 * @param string $data
	 *
	 * @return bool
	 *
	 * Check is string is serialized or not.
	 */
	public static function is_serialized( $data ) {
		// if it isn't a string, it isn't serialized
		if ( ! is_string( $data ) ) {
			return false;
		}
		$data = trim( $data );
		if ( 'N;' == $data ) {
			return true;
		}
		if ( ! preg_match( '/^([adObis]):/', $data, $badions ) ) {
			return false;
		}
		switch ( $badions[1] ) {
			case 'a' :
			case 'O' :
			case 's' :
				if ( preg_match( "/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data ) ) {
					return true;
				}
				break;
			case 'b' :
			case 'i' :
			case 'd' :
				if ( preg_match( "/^{$badions[1]}:[0-9.E-]+;\$/", $data ) ) {
					return true;
				}
				break;
		}

		return false;
	}

	/**
	 * @param string $string
	 *
	 * @return string
	 *
	 * This public static function is for HTMl form object's attributs.
	 */
	public static function esc_attr( $string ) {
		$string = self::cleanUTF8( $string );
		$string = htmlspecialchars( $string, ENT_COMPAT, 'UTF-8' );

		return $string;
	}

	/**
	 * @param      $str
	 * @param bool $force_php
	 *
	 * @return string
	 *
	 * Clean UTF8 string.
	 */
	public static function cleanUTF8( $str, $force_php = false ) {
		// UTF-8 validity is checked since PHP 4.3.5
		// This is an optimization: if the string is already valid UTF-8, no
		// need to do PHP stuff. 99% of the time, this will be the case.
		// The regexp matches the XML char production, as well as well as excluding
		// non-SGML codepoints U+007F to U+009F
		if ( ! is_string( $str ) ) {
			return $str;
		}
		if ( preg_match( '/^[\x{9}\x{A}\x{D}\x{20}-\x{7E}\x{A0}-\x{D7FF}\x{E000}-\x{FFFD}\x{10000}-\x{10FFFF}]*$/Du', $str ) ) {
			return $str;
		}

		$mState = 0; // cached expected number of octets after the current octet
		// until the beginning of the next UTF8 character sequence
		$mUcs4  = 0; // cached Unicode character
		$mBytes = 1; // cached expected number of octets in the current sequence

		// original code involved an $out that was an array of Unicode
		// codepoints.  Instead of having to convert back into UTF-8, we've
		// decided to directly append valid UTF-8 characters onto a string
		// $out once they're done.  $char accumulates raw bytes, while $mUcs4
		// turns into the Unicode code point, so there's some redundancy.

		$out  = '';
		$char = '';

		$len = strlen( $str );
		for ( $i = 0; $i < $len; $i ++ ) {
			$in   = ord( $str[$i] );
			$char .= $str[ $i ]; // append byte to char
			if ( 0 == $mState ) {
				// When mState is zero we expect either a US-ASCII character
				// or a multi-octet sequence.
				if ( 0 == ( 0x80 & ( $in ) ) ) {
					// US-ASCII, pass straight through.
					if ( ( $in <= 31 || $in == 127 ) && ! ( $in == 9 || $in == 13 || $in == 10 ) // save \r\t\n
					) {
						// control characters, remove
					} else {
						$out .= $char;
					}
					// reset
					$char   = '';
					$mBytes = 1;
				} elseif ( 0xC0 == ( 0xE0 & ( $in ) ) ) {
					// First octet of 2 octet sequence
					$mUcs4  = ( $in );
					$mUcs4  = ( $mUcs4 & 0x1F ) << 6;
					$mState = 1;
					$mBytes = 2;
				} elseif ( 0xE0 == ( 0xF0 & ( $in ) ) ) {
					// First octet of 3 octet sequence
					$mUcs4  = ( $in );
					$mUcs4  = ( $mUcs4 & 0x0F ) << 12;
					$mState = 2;
					$mBytes = 3;
				} elseif ( 0xF0 == ( 0xF8 & ( $in ) ) ) {
					// First octet of 4 octet sequence
					$mUcs4  = ( $in );
					$mUcs4  = ( $mUcs4 & 0x07 ) << 18;
					$mState = 3;
					$mBytes = 4;
				} elseif ( 0xF8 == ( 0xFC & ( $in ) ) ) {
					// First octet of 5 octet sequence.
					//
					// This is illegal because the encoded codepoint must be
					// either:
					// (a) not the shortest form or
					// (b) outside the Unicode range of 0-0x10FFFF.
					// Rather than trying to resynchronize, we will carry on
					// until the end of the sequence and let the later error
					// handling code catch it.
					$mUcs4  = ( $in );
					$mUcs4  = ( $mUcs4 & 0x03 ) << 24;
					$mState = 4;
					$mBytes = 5;
				} elseif ( 0xFC == ( 0xFE & ( $in ) ) ) {
					// First octet of 6 octet sequence, see comments for 5
					// octet sequence.
					$mUcs4  = ( $in );
					$mUcs4  = ( $mUcs4 & 1 ) << 30;
					$mState = 5;
					$mBytes = 6;
				} else {
					// Current octet is neither in the US-ASCII range nor a
					// legal first octet of a multi-octet sequence.
					$mState = 0;
					$mUcs4  = 0;
					$mBytes = 1;
					$char   = '';
				}
			} else {
				// When mState is non-zero, we expect a continuation of the
				// multi-octet sequence
				if ( 0x80 == ( 0xC0 & ( $in ) ) ) {
					// Legal continuation.
					$shift = ( $mState - 1 ) * 6;
					$tmp   = $in;
					$tmp   = ( $tmp & 0x0000003F ) << $shift;
					$mUcs4 |= $tmp;

					if ( 0 == -- $mState ) {
						// End of the multi-octet sequence. mUcs4 now contains
						// the final Unicode codepoint to be output

						// Check for illegal sequences and codepoints.

						// From Unicode 3.1, non-shortest form is illegal
						if ( ( ( 2 == $mBytes ) && ( $mUcs4 < 0x0080 ) ) || ( ( 3 == $mBytes ) && ( $mUcs4 < 0x0800 ) ) || ( ( 4 == $mBytes ) && ( $mUcs4 < 0x10000 ) ) || ( 4 < $mBytes ) || // From Unicode 3.2, surrogate characters = illegal
						     ( ( $mUcs4 & 0xFFFFF800 ) == 0xD800 ) || // Codepoints outside the Unicode range are illegal
						     ( $mUcs4 > 0x10FFFF ) ) {

						} elseif ( 0xFEFF != $mUcs4 && // omit BOM
						           // check for valid Char unicode codepoints
						           ( 0x9 == $mUcs4 || 0xA == $mUcs4 || 0xD == $mUcs4 || ( 0x20 <= $mUcs4 && 0x7E >= $mUcs4 ) || // 7F-9F is not strictly prohibited by XML,
						             // but it is non-SGML, and thus we don't allow it
						             ( 0xA0 <= $mUcs4 && 0xD7FF >= $mUcs4 ) || ( 0x10000 <= $mUcs4 && 0x10FFFF >= $mUcs4 ) ) ) {
							$out .= $char;
						}
						// initialize UTF8 cache (reset)
						$mState = 0;
						$mUcs4  = 0;
						$mBytes = 1;
						$char   = '';
					}
				} else {
					// ((0xC0 & (*in) != 0x80) && (mState != 0))
					// Incomplete multi-octet sequence.
					// used to result in complete fail, but we'll reset
					$mState = 0;
					$mUcs4  = 0;
					$mBytes = 1;
					$char   = '';
				}
			}
		}

		return $out;
	}


	/**
	 * @param $minutes
	 *
	 * @return string
	 *
	 * Convert minutes into time format. e.g. 140 into 02:20
	 */
	public static function minutes_to_time( $minutes ) {
		$h    = intval( $minutes / 60 );
		$time = $h . ":";
		$m    = $minutes - ( $h * 60 );
		if ( $m < 10 ) {
			$m = "0" . $m;
		}
		$time .= $m;

		return $time;
	}


	/**
	 * @param bool $full
	 *
	 * @return string
	 *
	 * Get filename where this public static function is executed.
	 * e.g public static functions.php
	 */
	public static function filename( $full = false ) {
		$bt   = debug_backtrace();
		$file = $bt[0]["file"];
		if ( ! $full ) {
			return basename( $file );
		} else {
			return $file;
		}
	}


	/**
	 * @param string $filepath
	 *
	 * Set download headers
	 */
	public static function download_headers( $filepath = "" ) {
		header( 'Content-Description: File Download' );
		header( 'Content-Type: application/octet-stream' );
		header( 'Expires: 0' );
		header( 'Cache-Control: must-revalidate' );
		header( 'Pragma: public' );

		if ( $filepath <> "" && is_file( $filepath ) ) {
			header( "Content-Disposition: filename=\"" . basename( $filepath ) . "\"" );
			header( 'Content-Length: ' . strlen( $filepath ) );
			//header('Content-Disposition: attachment; filename="customers.txt"');

			readfile( $filepath );
		}
	}


	/**
	 * @param $zipfile
	 * @param $destination_path
	 *
	 * @return string
	 *
	 * Unzip a .zip file into a specific folder path.
	 */
	public static function unzip( $zipfile, $destination_path ) {
		$zip = new ZipArchive();

		if ( ! is_file( $zipfile ) ) {
			return "ZIP file not found.";
		}
		if ( $zip->open( $zipfile ) === true ) {
			$zip->extractTo( $destination_path );
			$zip->close();

			return "OK";
		} else {
			return "Can't open ZIP file";
		}
	}

	/**
	 * @param $date
	 *
	 * @return bool
	 *
	 * Check if provided date is past date
	 */
	public static function is_past_date( $date ) {
		$date = my_date( $date );

		return strtotime( $date ) < strtotime( my_date() );
	}


	/**
	 * @return bool
	 *
	 * Check if current web browser is Safari or not
	 */
	public static function is_safari() {
		if ( ! isset( $_SERVER['HTTP_USER_AGENT'] ) ) {
			return false;
		}
		if ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Safari' ) && ! strpos( $_SERVER['HTTP_USER_AGENT'], 'Chrome' ) ) {
			return true;
		}

		return false;
	}

	/**
	 * @param $key_name
	 *
	 * It will delete cookie from client's computer by cookie name
	 */
	public static function delete_cookie_data( $key_name ) {
		$expire = time() - 3600;

		$domain = $_SERVER['HTTP_HOST'];
		$domain = str_replace( "www.", "", $domain );

		#unset($_COOKIE[$key_name]);
		setcookie( $key_name, '', $expire );
		setcookie( $key_name, '', $expire, '/', $domain );
		setcookie( $key_name, '', $expire );
		setcookie( $key_name, '', $expire, '/' );
		setcookie( $key_name, null, $expire );
		setcookie( $key_name, null, $expire, '/', $domain );
		unset( $_COOKIE[ $key_name ] );
	}

	/**
	 * @param        $key
	 * @param        $value
	 * @param string $expire
	 *
	 * @return bool
	 *
	 * Set new cookie value.
	 */
	public static function set_cookie_data( $key, $value, $expire = "" ) {
		if ( $expire == "" ) {
			$expire = strtotime( "+1000 Days" );
		}

		$domain = $_SERVER['HTTP_HOST'];
		$domain = str_replace( "www.", "", $domain );

		$a               = @setcookie( $key, $value, $expire );
		$b               = @setcookie( $key, $value, $expire, '/' );
		$c               = @setcookie( $key, $value, $expire, '/', $domain );
		$_COOKIE[ $key ] = $value;

		return $c;
	}


	/**
	 * @param $date
	 * @param $year
	 *
	 * @return false|string
	 *
	 * This public static function will change year of a date.
	 * e.g. set_date_year("25-11-2016", "2020") will be >> 25-11-2020
	 */
	public static function set_date_year( $date, $year ) {
		$date = date( "d-m-", strtotime( $date ) ) . $year;
		$date = my_date( $date );

		return $date;
	}

	/**
	 * @param     $date
	 * @param int $year_add
	 *
	 * @return false|string
	 *
	 * Add year in a date e.g. add_year_in_date("25-11-2016") will be >> 25-11-2017
	 * add_year_in_date("25-11-2016", 3) will be >> 25-11-2019
	 */
	public static function add_year_in_date( $date, $year_add = 1 ) {
		$date = my_date( $date . " +{$year_add} Year" );

		return $date;
	}


	/**
	 * @param $str
	 *
	 * @return string
	 *
	 * Convert string into vertical string.
	 */
	public static function vertical_string( $str ) {
		$lines = preg_split( "/\n/", trim( $str ) );
		$len   = max( array_map( 'strlen', $lines ) );
		$rows  = array_fill( 0, $len, '' );
		foreach ( $lines as $k => $line ) {
			foreach ( str_split( str_pad( $line, $len, ' ', STR_PAD_LEFT ) ) as $row => $char ) {
				$rows[ $row ] = $char;
			}
		}
		$str = implode( "\n", $rows ) . "\n";

		return $str;
	}


	/**
	 * @return string
	 *
	 * Insert Javascript file script in admin and staff panel.
	 */
	public static function insert_js_file( $jsfile = "" ) {
		if ( ! empty( $jsfile ) ) {
			$path = ROOT_PATH . 'assets/js/scripts/';
			if ( ! is_dir( $path ) ) {
				mkdir( $path );
			}
			$path = ROOT_PATH . 'assets/js/scripts/' . $jsfile . '.js';
			$url  = DOMAIN_URL . 'assets/js/scripts/' . $jsfile . '.js';
			if ( $path <> "" && ! is_file( $path ) ) {
				file_put_contents( $path, "// This file is generated by Nasir Scripts\n\n" );
			}
			if ( is_file( $path ) ) {
				echo "<script type='application/javascript' src='" . $url . "?" . md5_file( $path ) . "'></script>\n";
			}
		}
	}

	/**
	 * @return string
	 *
	 * Insert Javascript file script in admin and staff panel.
	 */
	public static function insert_css_file( $cssfile = "" ) {
		if ( ! empty( $cssfile ) ) {
			$path = ROOT_PATH . 'assets/css/style/';
			if ( ! is_dir( $path ) ) {
				mkdir( $path );
			}
			$root_path = $path . $cssfile . '.css';
			$root_url  = DOMAIN_URL . 'assets/css/style/' . $cssfile . '.css';
			if ( $root_path <> "" && ! is_file( $root_path ) ) {
				file_put_contents( $root_path, "/* This file is generated by Nasir Scripts */ \n\n" );
			}
			if ( is_file( $root_path ) ) {
				echo "<link rel='stylesheet' type='text/css' href='" . $root_url . "?" . md5_file( $root_path ) . "'>\n";
			}
		}
	}


	/**
	 * @return string
	 *
	 * Insert Javascript TMPL file in assets folder.
	 */
	public static function insert_tpl_file( $tplfile = "" ) {
		if ( ! empty( $tplfile ) ) {
			$path = ROOT_PATH . 'assets/js/templates/';
			if ( ! is_dir( $path ) ) {
				mkdir( $path );
			}
			$root_path = $path . $tplfile . '.tpl';
			if ( $root_path <> "" && ! is_file( $root_path ) ) {
				file_put_contents( $root_path, "" );
			}
			if ( is_file( $root_path ) ) {
				require_once( __DIR__ . '/../assets/js/templates/' . $tplfile . '.tpl' );
			}
		}
	}


	/**
	 * @return bool
	 *
	 * This public static function will return true if code is running in admin panel.
	 */
	public static function is_admin_panel() {
		if ( defined( 'ADMIN_PANEL' ) && ( ADMIN_PANEL == 1 || ADMIN_PANEL === true ) ) {
			return true;
		}

		if ( isset( $_SERVER["HTTP_HOST"] ) && substr( $_SERVER["HTTP_HOST"], 0, 7 ) == "manage." ) {
			return true;
		}

		return false;
	}


	public static function gravatar_image( $email, $size = "" ) {
		return "https://www.gravatar.com/avatar/" . md5( $email ) . "?&s=" . $size;
	}


	public static function json_header() {
		header( 'Content-Type: application/json' );
	}

	public static function add_leading_zeros( $number, $zeros = 2 ) {
		if ( strlen( $number ) < $zeros ) {
			return str_repeat( "0", ( $zeros - strlen( $number ) ) ) . $number;
		}

		return $number;
	}

	public static function get_tiny_url( $url ) {
		$ch      = curl_init();
		$timeout = 5;
		curl_setopt( $ch, CURLOPT_URL, 'http://tinyurl.com/api-create.php?url=' . $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
		$data = curl_exec( $ch );
		curl_close( $ch );

		return $data;
	}

	public static function seconds_to_time( $seconds ) {
		$hours = floor( $seconds / 3600 );
		$mins  = floor( $seconds / 60 % 60 );
		$secs  = floor( $seconds % 60 );

		return sprintf( '%02d:%02d:%02d', $hours, $mins, $secs );
	}

	/**
	 * @param string $filename
	 *
	 * Generate headers for CSV files. Use this public static function when downloading CSV file.
	 */
	public static function csv_headers( $filename = "" ) {
		if ( empty( $filename ) ) {
			$filename = "csv_" . rand() . ".csv";
		}
		// output headers so that the file is downloaded rather than displayed
		header( 'Content-Encoding: UTF-8' );
		header( 'Content-Type: text/csv; charset=utf-8' );
		header( "Content-Disposition: attachment; filename=\"{$filename}\"" );

		if ( self::is_windows_os() ) {
			echo "\xEF\xBB\xBF"; // UTF-8 BOM
		}
	}

	/**
	 * @return bool
	 *
	 * Returns true if browser operating system is Winows
	 */
	public static function is_windows_os() {
		return strtoupper( substr( PHP_OS, 0, 3 ) ) === 'WIN';
	}

	/**
	 * @return string
	 * return current country name
	 */
	public static function current_country() {
		if ( self::myip() == "::1" || self::myip() == "127.0.0.1" ) {
			return "Pakistan";
		}
		if ( is_array( self::ip_details( self::myip() ) ) ) {
			return self::ip_details( self::myip(), "location" )["country"];
		}

		return "Pakistan";
	}

	/**
	 * @param $price
	 * return decimale number (.) after 2 number
	 *
	 * @return string
	 */
	public static function number_formate( $price ) {
		return number_format( (float) $price, 2, '.', '' );
	}


	public static function is_connected() {
		$connected = @fsockopen( "www.google.com", 80 );
		//website, port  (try 80 or 443)
		if ( $connected ) {
			$is_conn = true; //action when connected
			fclose( $connected );
		} else {
			$is_conn = false; //action in connection failure
		}

		return $is_conn;
	}

	public static function remove_all( $path = '' ) {
		if ( empty( $path ) ) {
			return false;
		}
		array_map( 'unlink', array_filter( (array) glob( $path . "/*" ) ) );
	}

	public static function base64_url_encode( $input ) {
		return strtr( base64_encode( $input ), '+/=', '._-' );
	}

	public static function base64_url_decode( $input ) {
		return base64_decode( strtr( $input, '._-', '+/=' ), true );
	}

	public static function cleanstr( $string ) {
		$string = str_replace( ' ', '-', $string ); // Replaces all spaces with hyphens.
		$string = preg_replace( '/[^A-Za-z0-9\-]/', '', $string ); // Removes special chars.

		return preg_replace( '/-+/', '-', $string ); // Replaces multiple hyphens with single one.
	}


}
