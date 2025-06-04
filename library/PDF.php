<?php
/**
 * Created by PhpStorm.
 * User: NASIR
 * Date: 11-Feb-19
 * Time: 11:54 AM
 */
function PDF_Generate( $html = '', $output = '' ) {
	require_once( 'TCPDF/tcpdf.php' );
	$pdf = new TCPDF;
	// set font
	$pdf->SetFont( 'helvetica', '', 10 );
	$pdf->setPrintHeader( false );
	$pdf->setPrintFooter( false );
	// add a page
	$pdf->AddPage();

	// Download
	$pdf->writeHTML( $html, true, false, false, false, '' );
	$pdf->Output( $output, 'F' );

	//  View
	//	$pdf->writeHTML($html, true, false, true, false, '');
	//	$pdf->Output('prueba.pdf', 'I');

	return;
}