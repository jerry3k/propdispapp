// This file is generated by Nasir Scripts
var Page = 1;
var Rows = '';
var is_loading = true;
$( function() {
	//load_data();
	load_fitter();
	$( window ).on( 'load', function() {
		let d = new Date();
		let n = d.getMonth();
		$( '#select_month' ).val( n ).change();
	} );

	var start = moment().subtract( 29, 'days' );
	var end = moment().endOf( 'month' );
	$( '#reportrange span' ).html( '' );
	$( '#reportrange' ).daterangepicker( {
		opens: (Metronic.isRTL() ? 'left' : 'right'),
		startDate: start,
		endDate: end,
		minDate: '01/01/2016',
		maxDate: date( "m/t/Y" ),
		dateLimit: {
			days: 9999
		},
		showDropdowns: true,
		showWeekNumbers: true,
		timePicker: false,
		timePickerIncrement: 1,
		timePicker12Hour: true,
		applyClass: 'green',
		format: 'DD-MM-YYYY',
		separator: ' to ',
		locale: {
			applyLabel: 'Search',
			fromLabel: 'From',
			toLabel: 'To',
			customRangeLabel: 'Custom Range',
			daysOfWeek: [ 'Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa' ],
			monthNames: [
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
				'December'
			],
			firstDay: 1
		},
		ranges: {
			'Today': [ moment(), moment() ],
			'Yesterday': [ moment().subtract( 1, 'days' ), moment().subtract( 1, 'days' ) ],
			'Last 7 Days': [ moment().subtract( 6, 'days' ), moment() ],
			'Last 30 Days': [ moment().subtract( 29, 'days' ), moment() ],
			'This Month': [ moment().startOf( 'month' ), moment().endOf( 'month' ) ],
			'Last Month': [
				moment().subtract( 1, 'month' ).startOf( 'month' ),
				moment().subtract( 1, 'month' ).endOf( 'month' )
			]
		},
	}, function( start, end ) {
		$( '#reportrange span' ).html( '' );
	} );
	$( '#reportrange' ).on( 'apply.daterangepicker', function( ev, picker ) {
		let fromtDate = picker.startDate;
		let toDate = picker.endDate;
		$( '#time_to' ).val( toDate );
		$( '#time_from' ).val( fromtDate );
		Page = 1;
		$( "#page" ).val( Page );
		load_data();
	} );

	window.addEventListener( "wheel", function( e ) {
		if ( Page >= Rows.pages ) {
			return false;
		}
		let windowHeight = $( window ).height();
		let windowScrooll = $( window ).scrollTop();
		let documentHeight = $( document ).height();
		if ( Page < Rows.pages && !is_loading && windowHeight + windowScrooll >= documentHeight - 400 ) { //if user scrolled to bottom of the page
			Page++;
			is_loading = true;
			$( '#page' ).val( Page );

			if ( Page > 1 ) {
				$( "#tbody" ).append( "<tr id='temp_row'><td class='center' colspan='8'><i class='fa fa-spin fa-spinner'></i> Loading ....</td></tr>" );
			}
			load_data();
		}
	} );

	// window scroll pagenation
	$( document ).on( 'scroll', function() {
		if ( Page >= Rows.pages ) {
			return false;
		}
		if ( Page < Rows.pages && !is_loading && $( window ).scrollTop() + $( window ).height() >= $( document ).height() - 400 ) { //if user scrolled to bottom of the page
			Page++;
			is_loading = true;
			$( '#page' ).val( Page );

			if ( Page > 1 ) {
				$( "#tbody" ).append( "<tr id='temp_row'><td class='center' colspan='8'><i class='fa fa-spin fa-spinner'></i> Loading ....</td></tr>" );
			}
			load_data();
		}
	} );

	// Reset search
	$( document ).on( 'click', '.reset_search', function( e ) {
		e.preventDefault();
		Page = 1;
		$( '#page' ).val( '1' );
		$( '#order' ).val( 'DESC' );
		$( '#filter_search' ).val( '' );
		$( '#time_to' ).val( '' );
		$( '#time_from' ).val( '' );
		$( '#job_status' ).val( 1 );
		$( '#tbody' ).unmark( markjs_options );
		load_data();
	} );

	$( document ).on( 'click', '.print', function( e ) {
		e.preventDefault();
		$( '#print_div' ).removeClass( "hidden" ).print().addClass( "hidden" );
	} );

	$( document ).on( 'change', '#select_month', function( e ) {
		e.preventDefault();
		let month = this.value;
		let year = $( this ).find( ':selected' ).attr( 'data-year' );
		getMonthDateRange( year, month );
	} );

	$( document ).on( 'change', '#fitterid', function( e ) {
		e.preventDefault();
		$( '#fitter_id' ).val( '' );
		if ( !empty( this.value ) ) {
			$( '#fitter_id' ).val( this.value );
		}
		let month = $( '#select_month' ).find( ':selected' ).val();
		let year = $( '#select_month' ).find( ':selected' ).attr( 'data-year' );
		getMonthDateRange( year, month );
	} );

} );

function load_data() {
	if ( Page == 1 ) {
		Block();
	}
	$.ajax( {
		url: DOMAIN_URL + 'payfitter/load_data',
		method: 'post',
		data: $( '.form-filter' ).serialize(),
		success: function( data ) {
			UnBlock();
			Rows = data;
			make_html();
			$( "#temp_row" ).remove();
		}
	} );
}

function make_html() {
	$( "#total_records" ).html( Rows.total_records );
	HTML = tmpl( 'load_data', Rows.rows );
	if ( Page > 1 ) {
		$( "#tbody" ).append( HTML );
		$( "#tbody2" ).append( HTML );
	} else {
		$( "#tbody" ).html( HTML );
		$( "#tbody2" ).html( HTML );
	}
	is_loading = false;
	if ( !empty( $( '#filter_search' ).val() ) ) {
		$( '#tbody' ).mark( $( '#filter_search' ).val(), markjs_options );
	}
	UnBlock();
}

function getMonthDateRange( year, month ) {
	// month in moment is 0 based, so 9 is actually october, subtract 1 to compensate
	// array is 'year', 'month', 'day', etc
	var startDate = moment( [ year, month ] );
	// Clone the value before .endOf()
	var endDate = moment( startDate ).endOf( 'month' );
	let start = startDate.toDate();
	let end = endDate.toDate();
	start = moment( start ).format( 'LLL' );
	end = moment( end ).format( 'LLL' );
	$( '#time_to' ).val( end );
	$( '#time_from' ).val( start );
	Page = 1;
	$( "#page" ).val( Page );
	load_data();
}

function load_fitter() {
	$.ajax( {
		url: DOMAIN_URL + 'staff/load_data',
		method: 'post',
		data: {
			type: 'fitter',
			pagesize: 999999
		},
		success: function( data ) {
			if ( !empty( data.rows ) ) {
				let option = '<option value="">All Fitter</option>';
				$( data.rows ).each( function( k, v ) {
					if ( !empty( v.username ) ) {
						option += '<option value="' + v.id + '">' + v.username + '</option>';
					}
				} );
				$( '#fitterid' ).html( option );
			}
		}
	} );
}