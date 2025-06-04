<?php
require_once( __DIR__ . '/library.php' );
$AllOK = true;

if ( empty( $_GET["file"] ) ) {
	$filepath = "";
	$AllOK    = false;
} else {
	$filepath = $_GET["file"];
}

if ( substr( $filepath, - 4, 1 ) == '.' ) {
	$filepath = substr( $filepath, 0, - 4 );
} else if ( substr( $filepath, - 5, 1 ) == '.' ) {
	$filepath = substr( $filepath, 0, - 5 );
} else if ( substr( $filepath, - 3, 1 ) == '.' ) {
	$filepath = substr( $filepath, 0, - 3 );
}

if ( substr( $filepath, 0, 10 ) == "PROPERTY*y" ) {
	//$filepath = base64_decode( substr( $filepath, 10 ) );
	//$filepath = base64_decode( strtr( substr( $filepath, 10 ), '-_', '+/' ) );
	$filepath = decrypt( substr( $filepath, 10 ) );
} else {
	//$filepath = base64_decode( strtr( $filepath, '-_', '+/' ) );
	$filepath = decrypt( $filepath );
}

if ( ! is_file( $filepath ) ) {
	$AllOK = false;
}


if ( $AllOK ) {
	header( 'Content-Description: File Transfer' );
	if ( isset( $_GET['download'] ) ) {
		header( 'Content-Type: application/octet-stream' );
	} else {
		header( 'Content-Type: ' . mime_content_type( $filepath ) );
	}
	header( 'Content-Disposition: inline; filename="' . basename( $filepath ) . '"' );
	header( 'Expires: 0' );
	header( 'Cache-Control: must-revalidate' );
	header( 'Pragma: public' );
	header( 'Content-Length: ' . filesize( $filepath ) );
	readfile( $filepath );
	exit;
}