<?php
/**
 * Created by PhpStorm.
 * User: NASIR
 * MyDate: 23-Sep-18
 * Time: 12:06 PM
 */
// application root path define

ini_set( 'memory_limit', '1000M' );
date_default_timezone_set( 'Europe/Berlin' );

$ROOT_PATH = rtrim( dirname( __FILE__ ), '/' ) . '/';
$ROOT_PATH = str_replace( '\\', '/', $ROOT_PATH );
defined( 'ROOT_PATH' ) OR define( 'ROOT_PATH', $ROOT_PATH );
defined( 'APP_PATH' ) OR define( 'APP_PATH', $ROOT_PATH . 'application/' );
defined( 'CONTENT_PATH' ) OR define( 'CONTENT_PATH', $ROOT_PATH . 'contents/' );
defined( 'LIBRARY_PATH' ) OR define( 'LIBRARY_PATH', $ROOT_PATH . 'library/' );
defined( 'MASTER_PASSWORD' ) OR define( 'MASTER_PASSWORD', 'welcome' );
// ROOT URL PATH
if ( ! defined( 'ROOT_URL' ) ) {
	define( 'ROOT_URL', substr( $_SERVER['PHP_SELF'], 0, - ( strlen( $_SERVER['SCRIPT_FILENAME'] ) - strlen( ROOT_PATH ) ) ) );
}

// load custom classes
require_once( LIBRARY_PATH . '__auto_load.php' );

if ( General::is_localhost() ) {
	define( 'DOMAIN_URL', 'http' . ( isset( $_SERVER['HTTPS'] ) ? 's' : '' ) . '://' . @$_SERVER['HTTP_HOST'] . ROOT_URL );
} else {
	define( 'DOMAIN_URL', 'http' . ( isset( $_SERVER['HTTPS'] ) ? 's' : '' ) . '://' . @$_SERVER['HTTP_HOST'] . ROOT_URL . '/' );
}
// Database configration  migration
defined( 'Migration_Enabled' ) OR define( 'Migration_Enabled', true );
defined( 'Migration_Type' ) OR define( 'Migration_Type', 'sequential' );
defined( 'Migration_Table' ) OR define( 'Migration_Table', 'migrations' );
defined( 'Migration_Version' ) OR define( 'Migration_Version', 7 );

if ( General::is_localhost() ) {
	// Databse credentional localhost
	defined( 'DBhostname' ) OR define( 'DBhostname', 'localhost' );
	defined( 'DBusername' ) OR define( 'DBusername', 'root' );
	defined( 'DBpassword' ) OR define( 'DBpassword', '' );
	defined( 'DBdatabase' ) OR define( 'DBdatabase', 'property' );

	// Email Configration
	defined( 'SMTP_Protocol' ) OR define( 'SMTP_Protocol', 'smtp' );
	defined( 'SMTP_Host' ) OR define( 'SMTP_Host', 'ssl://smtp.gmail.com' );
	defined( 'SMTP_Port' ) OR define( 'SMTP_Port', 465 );

	defined( 'SMTP_User' ) OR define( 'SMTP_User', 'devcodian@gmail.com' );
	defined( 'SMTP_Password' ) OR define( 'SMTP_Password', 'devcodian1@@2@1@45' );

} else {
	// Databse credentional Live Server
	defined( 'DBhostname' ) OR define( 'DBhostname', 'db763817850.hosting-data.io' );
	defined( 'DBusername' ) OR define( 'DBusername', 'dbo763817850' );
	defined( 'DBpassword' ) OR define( 'DBpassword', 'iamtheadmin' );
	defined( 'DBdatabase' ) OR define( 'DBdatabase', 'db763817850' );

	// Email Configration
	defined( 'SMTP_Protocol' ) OR define( 'SMTP_Protocol', 'smtp' );
	defined( 'SMTP_Host' ) OR define( 'SMTP_Host', 'ssl://smtp.gmail.com' );
	defined( 'SMTP_Port' ) OR define( 'SMTP_Port', 465 );
	defined( 'SMTP_User' ) OR define( 'SMTP_User', 'no.reply.propertydisplayed@gmail.com' );
	defined( 'SMTP_Password' ) OR define( 'SMTP_Password', 'ga73waypa$$w0rd' );
}

// Add htaccess to protected classes
if ( is_dir( LIBRARY_PATH ) && ! file_exists( LIBRARY_PATH . '.htaccess' ) ) {
	$text = '<Files ~ ".*\..*">
order allow,deny
deny from all
</Files>';
	@file_put_contents( LIBRARY_PATH . ".htaccess", $text );
}