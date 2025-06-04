<?php
/**
 * Created by PhpStorm.
 * User: NASIR
 * Date: 22-Jan-19
 * Time: 11:19 PM
 */
function send_mail( $to, $subject = '', $message = '', $attachedFiles = '', $replyTo = '', $replyToName = 'PropertyDisplayed', $fromEmail = 'no.reply.propertydisplayed@gmail.com', $fromName = 'Property Display', $CC = '', $BCC = '' ) {
	$ci =& get_instance();
	$ci->load->library( 'email' );

	if ( General::localhost() ) {
		$config['protocol']  = SMTP_Protocol;
		$config['smtp_host'] = SMTP_Host;
		$config['smtp_port'] = SMTP_Port;
		$config['smtp_user'] = SMTP_User;
		$config['smtp_pass'] = SMTP_Password;
		$fromName            = 'Developer (Nasir Computer)';
		$fromEmail           = 'devcodian@gmail.com';
		$to                  = 'nasirkhilji10@gmail.com';
	} else {
		$config['protocol']  = SMTP_Protocol;
		$config['smtp_host'] = SMTP_Host;
		$config['smtp_port'] = SMTP_Port;
		$config['smtp_user'] = SMTP_User;
		$config['smtp_pass'] = SMTP_Password;
	}

	$config['charset'] = 'utf-8';
	$ci->email->initialize( $config );
	$ci->email->set_mailtype( "html" );
	$ci->email->set_newline( "\r\n" );

	//Email content
	if ( isset( $message ) && empty( $message ) ) {
		$message = '<h1>Sending email via SMTP server</h1>';
		$message .= '<p>This email has sent via SMTP server from Property Display application.</p><br>';
	}
	if ( ! empty( $CC ) ) {
		$ci->email->cc( $CC );
	}
	if ( ! empty( $BCC ) ) {
		$ci->email->bcc( $BCC );
	}
	// sending information
	$ci->email->to( $to );
	$ci->email->subject( $subject );
	$ci->email->message( $message );
	$ci->email->from( $fromEmail, $fromName );
	$ci->email->reply_to( $replyTo, $replyToName );

	// Email attached files
	if ( ! empty( $attachedFiles ) ) {
		$attachedFiles = General::make_array( $attachedFiles, " " );
		if ( is_array( $attachedFiles ) ) {
			foreach ( $attachedFiles as $File ) {
				$ci->email->attach( $File );
			}
		} else if ( is_file( $attachedFiles ) ) {
			$ci->email->attach( $attachedFiles );
		}
	}

	if ( $ci->email->send() ) {
		return true;
	}

	show_error( $ci->email->print_debugger() );

	return false;

}