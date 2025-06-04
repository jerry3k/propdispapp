<?php

class WkHTML {

	/**
	 * @param        $html
	 * @param string $output_file
	 * @param array  $options
	 *
	 * @return bool|string
	 *
	 * This method gets HTML, generates a PDF file and returns created PDF file path.
	 * It will return false if PDF file is not generated.
	 */
	public static function create_pdf_file_from_html( $html, $output_file = '', $options = [] ) {
		$temp_path = CONTENT_PATH . 'temp_pdf.html';
		if ( is_file( $temp_path ) ) {
			@unlink( $temp_path );
		}
		file_put_contents( $temp_path, $html );
		$url = DOMAIN_URL . 'contents/temp_pdf.html?' . time();

		return self::create_pdf_file( $url, $output_file, $options );
	}

	/**
	 * @param        $html
	 * @param string $output_file
	 * @param array  $options
	 *
	 * @return bool|string
	 *
	 * This method gets URL, generates a PDF file and returns created PDF file path.
	 * It will return false if PDF file is not generated.
	 */
	public static function create_pdf_file( $url, $output_file = '', $options = [] ) {
		$default = [
			# Generate Table of Contents page at start of PDF file
			'toc'                    => false,

			# Do not use dotted lines in the toc
			'disable_dotted_lines'   => false,

			# The header text of the toc (default Table of Contents)
			'toc_header_text'        => '',

			# For each level of headings in the toc indent by this length (default 1em)
			'toc_level_indentation'  => 1,

			# Do not link from toc to sections
			'disable_toc_links'      => false,

			# For each level of headings in the toc the font is scaled by this factor (default 0.8)
			'toc_text_size_shrink'   => 0.8,

			# Number of copies to print into the pdf
			'copies'                 => 1,

			# Change the dpi explicitly (this has no effect on X11 based systems)
			'dpi'                    => 96,

			# PDF will be generated in grayscale (if set to true)
			'grayscale'              => false,

			# When embedding images scale them down to this dpi
			'image_dpi'              => 600,

			# When jpeg compressing images use this quality
			'image_quality'          => 94,

			# Generates lower quality pdf. Useful to shrink the result document space (if set to true)
			'lowquality'             => false,

			# Set the page bottom margin
			'margin_bottom'          => 10,

			# Set the page left margin
			'margin_left'            => 10,

			# Set the page right margin
			'margin_right'           => 10,

			# Set the page right margin
			'margin_top'             => 10,

			# Set orientation to Landscape or Portrait
			'orientation'            => 'Portrait',

			# Set paper size to: A3, Legal, A4, Letter, etc.
			# For a full list of supported pages sizes please see
			# http://qt-project.org/doc/qt-4.8/qprinter.html#PaperSize-enum
			'page_size'              => 'A4',

			# Do not use lossless compression on pdf objects
			'no_pdf_compression'     => false,

			# Turn HTML form fields into pdf form fields
			'enable_forms'           => false,

			# Do not make links to remote web pages
			'disable_external_links' => false,

			# Do not make local links
			'disable_internal_links' => false,

			# Do not load or print images
			'no_images'              => false,

			# Set the starting page number
			'page_offset'            => 0,

			# Use this zoom factor
			'zoom'                   => 1,

			# Adds a html footer <url>
			'footer_html'            => '',

			# Left aligned footer text
			'footer_left'            => '',

			# Center aligned footer text
			'footer_center'          => '',

			# Right aligned footer text
			'footer_right'           => '',

			# Set footer font size
			'footer_font_size'       => 12,

			# Display line above the footer
			'footer_line'            => false,

			# Spacing between footer and content in mm
			'footer_spacing'         => 0,

			# Adds a html header <url>
			'header_html'            => '',

			# Left aligned header text
			'header_left'            => '',

			# Center aligned header text
			'header_center'          => '',

			# Right aligned header text
			'header_right'           => '',

			# Set header font size
			'header_font_size'       => 12,

			# Display line below the header
			'header_line'            => false,

			# Spacing between header and content in mm
			'header_spacing'         => 0,
		];
		$options = General::set_args( $options, $default );
		extract( $options );

		$output_file = (string) $output_file;
		if ( empty( $output_file ) ) {
			@mkdir( CONTENT_PATH . 'pdf_temp' );
			$output_file = CONTENT_PATH . 'pdf_temp' . str_replace( '.pdf', '', basename( $output_file ) ) . '.pdf';
		}
		if ( substr( strtolower( $output_file ), - 4 ) <> '.pdf' ) {
			$output_file .= '.pdf';
		}

		if ( is_file( $output_file ) ) {
			@unlink( $output_file );
		}

		//C:/Program Files/wkhtmltopdf/bin
		if ( is_file( '/usr/local/bin/wkhtmltopdf' ) ) {
			$wkhtml_file_path = '/usr/local/bin/wkhtmltopdf';
		} else if ( is_file( 'C:/Program Files/wkhtmltopdf/bin/wkhtmltopdf.exe' ) ) {
			$wkhtml_file_path = '"C:/Program Files/wkhtmltopdf/bin/wkhtmltopdf.exe"';
		} else {
			$wkhtml_file_path = 'wkhtmltopdf';
		}

		$command = $wkhtml_file_path . ' --copies ' . $copies;
		$command .= ' --dpi ' . $dpi;
		$command .= ' --image-dpi ' . $image_dpi;
		$command .= ' --image-quality ' . $image_quality;

		$margin_bottom = (int) $margin_bottom;
		$command       .= ' --margin-bottom ' . $margin_bottom . 'mm';

		$margin_left = (int) $margin_left;
		$command     .= ' --margin-left ' . $margin_left . 'mm';

		$margin_right = (int) $margin_right;
		$command      .= ' --margin-right ' . $margin_right . 'mm';

		$margin_top = (int) $margin_top;
		$command    .= ' --margin-top ' . $margin_top . 'mm';

		$command .= ' --orientation ' . $orientation;
		$command .= ' --page-size ' . $page_size;

		$zoom    = (int) $zoom;
		$command .= ' --zoom ' . $zoom;

		$footer_spacing = (int) $footer_spacing;
		$command        .= ' --footer-spacing ' . $footer_spacing;
		if ( trim( $footer_html ) <> '' ) {
			$command .= ' --footer-html "' . $footer_html . '"';
		}
		$footer_font_size = (int) $footer_font_size;
		$command          .= ' --footer-font-size ' . $footer_font_size;
		$footer_line      = (bool) $footer_line;
		if ( $footer_line ) {
			$command .= ' --footer-line ';
		}
		if ( trim( $footer_left ) <> '' ) {
			$command .= ' --footer-left "' . $footer_left . '"';
		}
		if ( trim( $footer_right ) <> '' ) {
			$command .= ' --footer-right "' . $footer_right . '"';
		}
		if ( trim( $footer_center ) <> '' ) {
			$command .= ' --footer-center "' . $footer_center . '"';
		}

		$header_spacing = (int) $header_spacing;
		$command        .= ' --header-spacing ' . $header_spacing;
		if ( trim( $header_html ) <> '' ) {
			$command .= ' --header-html "' . $header_html . '"';
		}
		$header_font_size = (int) $header_font_size;
		$command          .= ' --header-font-size ' . $header_font_size;
		$header_line      = (bool) $header_line;
		if ( $header_line ) {
			$command .= ' --header-line ';
		}
		if ( trim( $header_left ) <> '' ) {
			$command .= ' --header-left "' . $header_left . '"';
		}
		if ( trim( $header_right ) <> '' ) {
			$command .= ' --header-right "' . $header_right . '"';
		}
		if ( trim( $header_center ) <> '' ) {
			$command .= ' --header-center "' . $header_center . '"';
		}

		$no_images = (int) $no_images;
		if ( $no_images ) {
			$command .= ' --no-images ' . $no_images;
		}

		$page_offset = (int) $page_offset;
		$command     .= ' --page-offset ' . $page_offset;

		$disable_internal_links = (bool) $disable_internal_links;
		if ( $disable_internal_links ) {
			$command .= ' --disable-internal-links';
		}

		$disable_external_links = (bool) $disable_external_links;
		if ( $disable_external_links ) {
			$command .= ' --disable-external-links';
		}

		$enable_forms = (bool) $enable_forms;
		if ( $enable_forms ) {
			$command .= ' --enable-forms';
		}

		$no_pdf_compression = (bool) $no_pdf_compression;
		if ( $no_pdf_compression ) {
			$command .= ' --no-pdf-compression';
		}

		$lowquality = (bool) $lowquality;
		if ( $lowquality ) {
			$command .= ' --lowquality ';
		}
		$grayscale = (bool) $grayscale;
		if ( $grayscale ) {
			$command .= ' --grayscale';
		}

		$toc = (bool) $toc;
		if ( $toc ) {
			$command              .= ' toc';
			$disable_dotted_lines = (bool) $disable_dotted_lines;
			if ( $disable_dotted_lines ) {
				$command .= ' --disable-dotted-lines';
			}
			if ( trim( $toc_header_text ) <> '' ) {
				$command .= ' --toc-header-text "' . $toc_header_text . '"';
			}
			$toc_level_indentation = (int) $toc_level_indentation;
			$command               .= ' --toc-level-indentation ' . $toc_level_indentation . 'em';
			$disable_toc_links     = (bool) $disable_toc_links;
			if ( $disable_toc_links ) {
				$command .= ' --disable-toc-links';
			}
			$toc_text_size_shrink = (real) $toc_text_size_shrink;
			$command              .= ' --toc-text-size-shrink ' . $toc_text_size_shrink;
		}
		$command .= ' --disable-forms ';
		$command .= ' "' . $url . '" "' . $output_file . '"';
		//		return $command;

		$r = exec( $command, $output );

		$response = is_file( $output_file ) ? $output_file : false;

		return $response;
	}


	/**
	 * @param        $url
	 * @param string $output_file
	 * @param array  $options
	 *
	 * @return string
	 *
	 * Create PDF file and return it's URL
	 */
	public static function create_pdf_file_url( $url, $output_file = '', $options = [] ) {
		$array = [
			'url'         => $url,
			'output_file' => $output_file,
			'options'     => $options,
		];

		return DOMAIN_URL . 'pdf_print.php?token=' . urlencode( base64_encode( json_encode( $array ) ) );
	}
}