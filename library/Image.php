<?php
require_once( ROOT_PATH . 'library/Wideimage/lib/WideImage.php' );
const METHOD    = 'aes-256-ctr';
const CRYPT_KEY = '000102030405060708090a0b0c0d0e0f101112131415161718191a1b1c1d1e1f';

/**
 * @param string $name
 * @param string $path
 * @param int    $width
 * @param int    $height
 * @param string $method
 *
 * @return string
 */

function save_images( $name = "", $path = "", $width = 150, $height = 150, $method = 'fit' ) {
	if ( empty( $name ) ) {
		return 'Please upload image file.';
	}
	if ( empty( $path ) ) {
		return 'Invalid image file path. Please insert valid image file path.';
	}
	if ( ! is_dir( $path ) ) {
		mkdir( $path );
	}
	try {
		$image = WideImage::load( $path . "/" . $name );
	} catch ( Exception $e ) {
		echo "Image isn't valid";
	}
	$image->crop( 'center', 'center' )->resize( $width, $height )->saveToFile( $path . '/' . $width . '___' . $name );

	return 'OK';
}

function get_profile_image( $id, $width = '150', $height = '150' ) {
	if ( empty( $id ) || ! is_numeric( $id ) ) {
		return false;
	}

	$folder_path = CONTENT_PATH . 'admins/' . $id . '/';
	if ( empty( $folder_path ) ) {
		return get_file_url( ROOT_PATH . 'assets/images/male.jpg' );
	}
	$path = glob( $folder_path . "*.*", GLOB_BRACE );

	if ( empty( $path ) ) {
		return get_file_url( ROOT_PATH . 'assets/images/male.jpg' );
	}
	$file = pathinfo( $path[0] );

	// create folder width size
	if ( ! is_dir( $folder_path . $width ) ) {
		mkdir( $folder_path . $width );
	}

	if ( empty( $file['basename'] ) ) {
		return get_file_url( ROOT_PATH . 'assets/images/male.jpg' );
	}

	try {
		$image = WideImage::load( $folder_path . $file['basename'] );
	} catch ( Exception $e ) {
		echo "Image isn't valid";
	}

	// previous file remove
	$image->crop( 'center', 'center' )
	      ->resize( $width, $height )
	      ->saveToFile( $folder_path . $width . '/' . $file['basename'] );

	return get_file_url( $folder_path . $width . '/' . $file['basename'] );
}

function get_file_url( $filepath, $authenticated = false, $download = false ) {
	if ( ! is_file( $filepath ) ) {
		return "#";
	}

	$url = DOMAIN_URL . "server_file.php?";

	$download = (bool) $download;
	if ( $download ) {
		$url .= 'download&';
	}

	if ( $authenticated ) {
		$url .= "file=PROPERTY*y" . encrypt( $filepath );
	} else {
		$url .= "file=" . encrypt( $filepath ); // strtr( base64_encode( $filepath ), '+/', '-_' );
	}

	$ext = pathinfo( $filepath, PATHINFO_EXTENSION );
	$url .= '.' . $ext;

	return $url;
}

/**
 * Encrypts (but does not authenticate) a message
 *
 * @param string  $message - plaintext message
 * @param string  $key     - encryption key (raw binary expected)
 * @param boolean $encode  - set to TRUE to return a base64-encoded
 *
 * @return string (raw binary)
 */
function encrypt( $message, $key = '', $encode = true ) {
	if ( $key == '' ) {
		$key = hex2bin( CRYPT_KEY );
	}
	$nonceSize = openssl_cipher_iv_length( METHOD );
	$nonce     = openssl_random_pseudo_bytes( $nonceSize );

	$ciphertext = openssl_encrypt( $message, METHOD, $key, OPENSSL_RAW_DATA, $nonce );

	// Now let's pack the IV and the ciphertext together
	// Naively, we can just concatenate
	if ( $encode ) {
		return General::base64_url_encode( $nonce . $ciphertext );
	}

	return $nonce . $ciphertext;
}

/**
 * Decrypts (but does not verify) a message
 *
 * @param string  $message - ciphertext message
 * @param string  $key     - encryption key (raw binary expected)
 * @param boolean $encoded - are we expecting an encoded string?
 *
 * @return string
 */
function decrypt( $message, $key = '', $encoded = true ) {
	if ( $key == '' ) {
		$key = hex2bin( CRYPT_KEY );
	}
	if ( $encoded ) {
		$message = General::base64_url_decode( $message, true );
		if ( $message === false ) {
			throw new Exception( 'Encryption failure' );
		}
	}

	$nonceSize  = openssl_cipher_iv_length( METHOD );
	$nonce      = mb_substr( $message, 0, $nonceSize, '8bit' );
	$ciphertext = mb_substr( $message, $nonceSize, null, '8bit' );

	$plaintext = openssl_decrypt( $ciphertext, METHOD, $key, OPENSSL_RAW_DATA, $nonce );

	return $plaintext;
}

?>