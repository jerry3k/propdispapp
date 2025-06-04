$( function() {
	// clock
	clock();
	// here is code ...
	$( 'form.validate' ).each( function() {
		$( this ).validate();
	} );
	// tablesaw implement
	$( '.table' ).table();
	// uniform
	$( 'input[type=radio]' ).uniform();

	$( document ).on( 'focus', ".date-picker", function() {
		if ( $( this ).hasClass( 'hasDatepicker' ) === false ) {
			$( this ).datepicker( {
				weekStart: 1,
				orientation: "left",
				autoclose: true,
				format: "dd-mm-yyyy",
				clearBtn: true
			} );
		}
	} );

	if ( $( "#filter_div" ).length == 1 ) {
		var Label = $( "#filter_div" ).data( "label" );
		if ( !Label ) {
			Label = "<i class='fa fa-search'></i> Search Filters";
		}

		HTML = "<label class='bg-green' id='filter_label' title='Open/Close Filters'>" + Label + "</label>";
		$( "#filter_div" ).prepend( HTML );
	}

	if ( is_mobile ) {
		$( document ).on( "hover", "label#filter_label", function() {
			if ( $( "#filter_div" ).css( 'left' ) == "-308px" ) {
				show_filter();
			} else {
				hide_filter();
			}
		} );
	} else {
		$( document ).on( "click", "label#filter_label", function() {
			if ( $( "#filter_div" ).css( 'left' ) == "-308px" ) {
				show_filter();
			} else {
				hide_filter();
			}
		} );
	}
} );

function show_filter() {
	$( "#filter_div" ).animate( {
		'left': '0px'
	} );
}

function hide_filter() {
	$( "#filter_div" ).animate( {
		'left': '-308px'
	} );
}

function loading( id = '' ) {
	if ( !empty( id ) ) {
		$( '#' + id ).LoadingOverlay( 'show' );
	} else {
		$.LoadingOverlay( 'show' );
	}
}

function unloading( id = '' ) {
	if ( !empty( id ) ) {
		$( '#' + id ).LoadingOverlay( 'hide' );
	} else {
		$.LoadingOverlay( 'hide' );
	}
}

Block = function( targetDiv, simple ) {
	if ( targetDiv ) {
		if ( simple === true ) {
			$( '#' + targetDiv ).block( { message: null } );
		} else {
			Metronic.blockUI( {
				target: "#" + targetDiv,
				animate: true
			} );
		}
	} else {
		Metronic.blockUI( {
			boxed: true
		} );
	}
}

function UnBlock( targetDiv ) {
	if ( targetDiv ) {
		Metronic.unblockUI( "#" + targetDiv );
	} else {
		Metronic.unblockUI();
	}
}

function Error( text ) {
	toastr.options = {
		"closeButton": true,
		"debug": false,
		"positionClass": "toast-top-center",
		"onclick": null,
		"showDuration": "1000",
		"hideDuration": "1000",
		"timeOut": "5000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}
	var $toast = toastr[ 'error' ]( text, 'Error' );
}

function Success( text ) {
	toastr.options = {
		"closeButton": true,
		"debug": false,
		"positionClass": "toast-top-center",
		"onclick": null,
		"showDuration": "1000",
		"hideDuration": "1000",
		"timeOut": "5000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}
	var $toast = toastr[ 'success' ]( text, 'Success' );
}

function Warning( text ) {
	toastr.options = {
		"closeButton": true,
		"debug": false,
		"positionClass": "toast-top-center",
		"onclick": null,
		"showDuration": "1000",
		"hideDuration": "1000",
		"timeOut": "5000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}
	var $toast = toastr[ 'warning' ]( text, 'Warning' );
}

function Info( text, title, position ) {
	if ( position == null ) {
		position = "toast-top-left";
	}
	toastr.options = {
		"closeButton": true,
		"debug": false,
		"positionClass": position,
		"onclick": null,
		"showDuration": "1000",
		"hideDuration": "1000",
		"timeOut": "5000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}
	if ( title == null ) {
		title = "Info";
	}
	var $toast = toastr[ 'info' ]( text, title );
}

function generate_key( n = 6 ) {
	var text = '';
	var possible = '!@#$%^&*()_+=[]<>ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

	for ( var i = 0; i < n; i++ ) {
		text += possible.charAt( Math.floor( Math.random() * possible.length ) );
	}

	return text;
}

function clock() {
	// 24 hour clock
	setInterval( function() {
		var monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
		var currentTime = new Date();
		var hours = currentTime.getHours();
		var minutes = currentTime.getMinutes();
		var seconds = currentTime.getSeconds();
		var AmPm = hours >= 12 ? 'PM' : 'AM';

		hours = hours % 12;
		hours = hours ? hours : 12; // the hour '0' should be '12'

		var day = currentTime.getDate();
		var month = monthNames[ (currentTime.getMonth()) ];
		var year = currentTime.getFullYear();

		// Add leading zeros
		hours = (hours < 10 ? "0" : "") + hours;
		minutes = (minutes < 10 ? "0" : "") + minutes;
		seconds = (seconds < 10 ? "0" : "") + seconds;

		var clock = '<i class="fa fa-clock-o"></i>';
		var calender = '<i class="fa fa-calendar"></i>';

		// Compose the string for display
		var currentTimeString = calender + ' ' + day + '-' + month + '-' + year + ' | ' + clock + ' ' + hours + ":" + minutes + ":" + seconds + " " + AmPm;
		$( ".clock" ).html( currentTimeString );

	}, 1000 );
}

get_JobCode = function( id ) {
	if ( typeof JobCode != "object" ) {
		console.log( "id is not a objecct" );
		return "";
	} else {
		if ( JobCode.hasOwnProperty( id ) ) {
			return JobCode[ id ];
		} else {
			return "";
		}
	}
};

get_username = function( id ) {
	if ( typeof Usersname != "object" ) {
		console.log( "id is not a objecct" );
		return "";
	} else {
		if ( Usersname.hasOwnProperty( id ) ) {
			return Usersname[ id ];
		} else {
			return "";
		}
	}
};

get_email = function( id ) {
	if ( typeof UserEmail != "object" ) {
		console.log( "id is not a objecct" );
		return "";
	} else {
		if ( UserEmail.hasOwnProperty( id ) ) {
			return UserEmail[ id ];
		} else {
			return "";
		}
	}
};

get_phone = function( id ) {
	if ( typeof UserPhone != "object" ) {
		console.log( "id is not a objecct" );
		return "";
	} else {
		if ( UserPhone.hasOwnProperty( id ) ) {
			return UserPhone[ id ];
		} else {
			return "";
		}
	}
};

get_jobtype = function( id ) {
	if ( typeof Jobtype != "object" ) {
		console.log( "JobType is not a objecct" );
		return "";
	} else {
		if ( Jobtype.hasOwnProperty( id ) ) {
			return Jobtype[ id ];
		} else {
			return "";
		}
	}
};

get_jobtype_description = function( id ) {
	if ( typeof JobtypeDescription != "object" ) {
		console.log( "JobType id is not a objecct" );
		return "";
	} else {
		if ( JobtypeDescription.hasOwnProperty( id ) ) {
			return JobtypeDescription[ id ];
		} else {
			return "";
		}
	}
};

get_ClientPriceType = function( id ) {
	if ( typeof ClientPriceType != "object" ) {
		console.log( "id is not a objecct" );
		return "";
	} else {
		if ( ClientPriceType.hasOwnProperty( id ) ) {
			return ClientPriceType[ id ];
		} else {
			return "";
		}
	}
};

getClientAddress = function( id ) {
	if ( typeof ClientAddress != "object" ) {
		console.log( "id is not a objecct" );
		return "";
	} else {
		if ( ClientAddress.hasOwnProperty( id ) ) {
			return ClientAddress[ id ];
		} else {
			return "";
		}
	}
};

getSticker = function( id ) {
	if ( typeof Sticker != "object" ) {
		console.log( "id is not a objecct" );
		return "";
	} else {
		if ( Sticker.hasOwnProperty( id ) ) {
			return Sticker[ id ];
		} else {
			return "";
		}
	}
};

getJobAddress = function( id ) {
	if ( typeof JobAddress != "object" ) {
		console.log( "id is not a objecct" );
		return "";
	} else {
		if ( JobAddress.hasOwnProperty( id ) ) {
			return JobAddress[ id ];
		} else {
			return "";
		}
	}
};

getJobPostCode = function( id ) {
	if ( typeof JobPostCode != "object" ) {
		console.log( "id is not a objecct" );
		return "";
	} else {
		if ( JobPostCode.hasOwnProperty( id ) ) {
			return JobPostCode[ id ];
		} else {
			return "";
		}
	}
};

getJobPrice = function( id ) {
	if ( typeof JobPrice != "object" ) {
		console.log( "id is not a objecct" );
		return "";
	} else {
		if ( JobPrice.hasOwnProperty( id ) ) {
			return JobPrice[ id ];
		} else {
			return "";
		}
	}
};

getJobExpense = function( id ) {
	if ( typeof JobExpense != "object" ) {
		console.log( "id is not a objecct" );
		return "";
	} else {
		if ( JobExpense.hasOwnProperty( id ) ) {
			return JobExpense[ id ];
		} else {
			return "";
		}
	}
};