// This file is generated by Nasir Scripts
$( function() {

	$( document ).on( 'submit', '#form1', function( e ) {
		e.preventDefault();
		$( '#form1' ).LoadingOverlay( 'show' );
		$( '#form1' ).ajaxSubmit( {
			success: function( data ) {
				$( '#form1' ).LoadingOverlay( 'hide' );
				if ( data.substr( 0, 2 ) == 'OK' ) {
					Success( 'Profile updated successfully.' );
				} else {
					Error( data );
				}
			},
		} );
	} );

	$( document ).on( 'submit', '#form2', function( e ) {
		e.preventDefault();
		$( '#form2' ).LoadingOverlay( 'show' );
		$( '#form2' ).ajaxSubmit( {
			success: function( data ) {
				$( '#form2' ).LoadingOverlay( 'hide' );
				if ( data == 'OK' ) {
					$( '#form2 #reset_btn' ).trigger( 'click' );
					Success( 'Password updated successfully.' );
				} else {
					Error( data );
				}
			},
		} );
	} );

	$( document ).on( 'click', '.change_image', function( e ) {
		e.preventDefault();
		$( '#profile_image' ).trigger( 'click' );
	} );

	$( '#profile_image' ).change( function() {
		$( '.load_div' ).LoadingOverlay( 'show' );
		$( '#form3' ).ajaxSubmit( {
			success: function( data ) {
				$( '.load_div' ).LoadingOverlay( 'hide' );
				if ( data == 'OK' ) {
					let id = $( '#form3 input[name=id]' ).val();
					if ( !empty( id ) ) {
						load_images( id );
					}
					Success( 'Image updated successfully.' );
				} else {
					Error( data );
				}
			},
		} );
	} );

} );

function load_images( id = '' ) {
	if ( empty( id ) ) {
		return false;
	}
	$.ajax( {
		url: DOMAIN_URL + 'profile/get_profile_images',
		method: 'post',
		data: { id: id },
		success: function( d ) {
			$( '#form3 #profile_image' ).val( '' );
			$( '#form3 #file_reset' ).click();
			$( '#form3 #file_reset' ).trigger( 'click' );
			if ( !empty( d[ 0 ] ) ) {
				if ( d[ 0 ] == '#' ) {
					$( '#small_img' ).attr( 'src', DOMAIN_URL + 'assets/images/male.jpg' );
				} else {
					$( '#small_img' ).attr( 'src', d[ 0 ] );
				}
			}
			if ( !empty( d[ 1 ] ) ) {
				if ( d[ 1 ] == '#' ) {
					$( '#small_img' ).attr( 'src', DOMAIN_URL + 'assets/images/male.jpg' );
				} else {
					$( '#load_img' ).attr( 'src', d[ 1 ] );
				}
			}
		}
	} );
}

