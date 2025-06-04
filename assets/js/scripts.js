var is_chrome = !!window.chrome && !is_opera;
var is_explorer = typeof document !== 'undefined' && !!document.documentMode && !isEdge;
var is_firefox = typeof window.InstallTrigger !== 'undefined';
var is_safari = /^((?!chrome|android).)*safari/i.test( navigator.userAgent );
var is_opera = !!window.opera || navigator.userAgent.indexOf( ' OPR/' ) >= 0;
var noImageURL = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
var markjs_options = {
	"diacritics": true,
	"separateWordSearch": true,
	"element": "span",
	"className": "highlight highlighter"
};

//
function empty( mixedVar ) {
	//  discuss at: http://locutus.io/php/empty/
	// original by: Philippe Baumann
	//    input by: Onno Marsman (https://twitter.com/onnomarsman)
	//    input by: LH
	//    input by: Stoyan Kyosev (http://www.svest.org/)
	// bugfixed by: Kevin van Zonneveld (http://kvz.io)
	// improved by: Onno Marsman (https://twitter.com/onnomarsman)
	// improved by: Francesco
	// improved by: Marc Jansen
	// improved by: Rafał Kukawski (http://blog.kukawski.pl)
	//   example 1: empty(null)
	//   returns 1: true
	//   example 2: empty(undefined)
	//   returns 2: true
	//   example 3: empty([])
	//   returns 3: true
	//   example 4: empty({})
	//   returns 4: true
	//   example 5: empty({'aFunc' : function () { alert('humpty'); } })
	//   returns 5: false

	var undef
	var key
	var i
	var len
	var emptyValues = [undef, null, false, 0, '', '0']

	for ( i = 0, len = emptyValues.length; i < len; i++ ) {
		if ( mixedVar === emptyValues[ i ] ) {
			return true
		}
	}

	if ( typeof mixedVar === 'object' ) {
		for ( key in mixedVar ) {
			if ( mixedVar.hasOwnProperty( key ) ) {
				return false
			}
		}
		return true
	}

	return false
}

function is_float( mixedVar ) { // eslint-disable-line camelcase
	//  discuss at: http://locutus.io/php/is_float/
	// original by: Paulo Freitas
	// bugfixed by: Brett Zamir (http://brett-zamir.me)
	// improved by: WebDevHobo (http://webdevhobo.blogspot.com/)
	// improved by: Rafał Kukawski (http://blog.kukawski.pl)
	//      note 1: 1.0 is simplified to 1 before it can be accessed by the function, this makes
	//      note 1: it different from the PHP implementation. We can't fix this unfortunately.
	//   example 1: is_float(186.31)
	//   returns 1: true

	return +mixedVar === mixedVar && (!isFinite( mixedVar ) || !!(mixedVar % 1))
}

function is_int( mixedVar ) { // eslint-disable-line camelcase
	//  discuss at: http://locutus.io/php/is_int/
	// original by: Alex
	// improved by: Kevin van Zonneveld (http://kvz.io)
	// improved by: WebDevHobo (http://webdevhobo.blogspot.com/)
	// improved by: Rafał Kukawski (http://blog.kukawski.pl)
	//  revised by: Matt Bradley
	// bugfixed by: Kevin van Zonneveld (http://kvz.io)
	//      note 1: 1.0 is simplified to 1 before it can be accessed by the function, this makes
	//      note 1: it different from the PHP implementation. We can't fix this unfortunately.
	//   example 1: is_int(23)
	//   returns 1: true
	//   example 2: is_int('23')
	//   returns 2: false
	//   example 3: is_int(23.5)
	//   returns 3: false
	//   example 4: is_int(true)
	//   returns 4: false

	return mixedVar === +mixedVar && isFinite( mixedVar ) && !(mixedVar % 1)
}

function is_null( mixedVar ) { // eslint-disable-line camelcase
	//  discuss at: http://locutus.io/php/is_null/
	// original by: Kevin van Zonneveld (http://kvz.io)
	//   example 1: is_null('23')
	//   returns 1: false
	//   example 2: is_null(null)
	//   returns 2: true

	return (mixedVar === null)
}

function is_numeric( mixedVar ) { // eslint-disable-line camelcase
	//  discuss at: http://locutus.io/php/is_numeric/
	// original by: Kevin van Zonneveld (http://kvz.io)
	// improved by: David
	// improved by: taith
	// bugfixed by: Tim de Koning
	// bugfixed by: WebDevHobo (http://webdevhobo.blogspot.com/)
	// bugfixed by: Brett Zamir (http://brett-zamir.me)
	// bugfixed by: Denis Chenu (http://shnoulle.net)
	//   example 1: is_numeric(186.31)
	//   returns 1: true
	//   example 2: is_numeric('Kevin van Zonneveld')
	//   returns 2: false
	//   example 3: is_numeric(' +186.31e2')
	//   returns 3: true
	//   example 4: is_numeric('')
	//   returns 4: false
	//   example 5: is_numeric([])
	//   returns 5: false
	//   example 6: is_numeric('1 ')
	//   returns 6: false

	var whitespace = [
		' ',
		'\n',
		'\r',
		'\t',
		'\f',
		'\x0b',
		'\xa0',
		'\u2000',
		'\u2001',
		'\u2002',
		'\u2003',
		'\u2004',
		'\u2005',
		'\u2006',
		'\u2007',
		'\u2008',
		'\u2009',
		'\u200a',
		'\u200b',
		'\u2028',
		'\u2029',
		'\u3000'
	].join( '' )

	// @todo: Break this up using many single conditions with early returns
	return (typeof mixedVar === 'number' ||
	        (typeof mixedVar === 'string' &&
	         whitespace.indexOf( mixedVar.slice( -1 ) ) === -1)) &&
	       mixedVar !== '' &&
	       !isNaN( mixedVar )
}

function explode( delimiter, string, limit ) {
	//  discuss at: http://locutus.io/php/explode/
	// original by: Kevin van Zonneveld (http://kvz.io)
	//   example 1: explode(' ', 'Kevin van Zonneveld')
	//   returns 1: [ 'Kevin', 'van', 'Zonneveld' ]

	if ( arguments.length < 2 ||
	     typeof delimiter === 'undefined' ||
	     typeof string === 'undefined' ) {
		return null
	}
	if ( delimiter === '' ||
	     delimiter === false ||
	     delimiter === null ) {
		return false
	}
	if ( typeof delimiter === 'function' ||
	     typeof delimiter === 'object' ||
	     typeof string === 'function' ||
	     typeof string === 'object' ) {
		return {
			0: ''
		}
	}
	if ( delimiter === true ) {
		delimiter = '1'
	}

	// Here we go...
	delimiter += ''
	string += ''

	var s = string.split( delimiter )

	if ( typeof limit === 'undefined' ) {
		return s
	}

	// Support for limit
	if ( limit === 0 ) {
		limit = 1
	}

	// Positive limit
	if ( limit > 0 ) {
		if ( limit >= s.length ) {
			return s
		}
		return s
			.slice( 0, limit - 1 )
			.concat( [
				s.slice( limit - 1 )
					.join( delimiter )
			] )
	}

	// Negative limit
	if ( -limit >= s.length ) {
		return []
	}

	s.splice( s.length + limit )
	return s
}

function implode( glue, pieces ) {
	//  discuss at: http://locutus.io/php/implode/
	// original by: Kevin van Zonneveld (http://kvz.io)
	// improved by: Waldo Malqui Silva (http://waldo.malqui.info)
	// improved by: Itsacon (http://www.itsacon.net/)
	// bugfixed by: Brett Zamir (http://brett-zamir.me)
	//   example 1: implode(' ', ['Kevin', 'van', 'Zonneveld'])
	//   returns 1: 'Kevin van Zonneveld'
	//   example 2: implode(' ', {first:'Kevin', last: 'van Zonneveld'})
	//   returns 2: 'Kevin van Zonneveld'

	var i = ''
	var retVal = ''
	var tGlue = ''

	if ( arguments.length === 1 ) {
		pieces = glue
		glue = ''
	}

	if ( typeof pieces === 'object' ) {
		if ( Object.prototype.toString.call( pieces ) === '[object Array]' ) {
			return pieces.join( glue )
		}
		for ( i in pieces ) {
			retVal += tGlue + pieces[ i ]
			tGlue = glue
		}
		return retVal
	}

	return pieces
}

function nl2br( str, isXhtml ) {
	//  discuss at: http://locutus.io/php/nl2br/
	// original by: Kevin van Zonneveld (http://kvz.io)
	// improved by: Philip Peterson
	// improved by: Onno Marsman (https://twitter.com/onnomarsman)
	// improved by: Atli Þór
	// improved by: Brett Zamir (http://brett-zamir.me)
	// improved by: Maximusya
	// bugfixed by: Onno Marsman (https://twitter.com/onnomarsman)
	// bugfixed by: Kevin van Zonneveld (http://kvz.io)
	// bugfixed by: Reynier de la Rosa (http://scriptinside.blogspot.com.es/)
	//    input by: Brett Zamir (http://brett-zamir.me)
	//   example 1: nl2br('Kevin\nvan\nZonneveld')
	//   returns 1: 'Kevin<br />\nvan<br />\nZonneveld'
	//   example 2: nl2br("\nOne\nTwo\n\nThree\n", false)
	//   returns 2: '<br>\nOne<br>\nTwo<br>\n<br>\nThree<br>\n'
	//   example 3: nl2br("\nOne\nTwo\n\nThree\n", true)
	//   returns 3: '<br />\nOne<br />\nTwo<br />\n<br />\nThree<br />\n'
	//   example 4: nl2br(null)
	//   returns 4: ''

	// Some latest browsers when str is null return and unexpected null value
	if ( typeof str === 'undefined' || str === null ) {
		return ''
	}

	// Adjust comment to avoid issue on locutus.io display
	var breakTag = (isXhtml || typeof isXhtml === 'undefined') ? '<br ' + '/>' : '<br>'

	return (str + '')
		.replace( /(\r\n|\n\r|\r|\n)/g, breakTag + '$1' )
}

function trim( str, charlist ) {
	//  discuss at: http://locutus.io/php/trim/
	// original by: Kevin van Zonneveld (http://kvz.io)
	// improved by: mdsjack (http://www.mdsjack.bo.it)
	// improved by: Alexander Ermolaev (http://snippets.dzone.com/user/AlexanderErmolaev)
	// improved by: Kevin van Zonneveld (http://kvz.io)
	// improved by: Steven Levithan (http://blog.stevenlevithan.com)
	// improved by: Jack
	//    input by: Erkekjetter
	//    input by: DxGx
	// bugfixed by: Onno Marsman (https://twitter.com/onnomarsman)
	//   example 1: trim('    Kevin van Zonneveld    ')
	//   returns 1: 'Kevin van Zonneveld'
	//   example 2: trim('Hello World', 'Hdle')
	//   returns 2: 'o Wor'
	//   example 3: trim(16, 1)
	//   returns 3: '6'

	var whitespace = [
		' ',
		'\n',
		'\r',
		'\t',
		'\f',
		'\x0b',
		'\xa0',
		'\u2000',
		'\u2001',
		'\u2002',
		'\u2003',
		'\u2004',
		'\u2005',
		'\u2006',
		'\u2007',
		'\u2008',
		'\u2009',
		'\u200a',
		'\u200b',
		'\u2028',
		'\u2029',
		'\u3000'
	].join( '' )
	var l = 0
	var i = 0
	str += ''

	if ( charlist ) {
		whitespace = (charlist + '').replace( /([[\]().?/*{}+$^:])/g, '$1' )
	}

	l = str.length
	for ( i = 0; i < l; i++ ) {
		if ( whitespace.indexOf( str.charAt( i ) ) === -1 ) {
			str = str.substring( i )
			break
		}
	}

	l = str.length
	for ( i = l - 1; i >= 0; i-- ) {
		if ( whitespace.indexOf( str.charAt( i ) ) === -1 ) {
			str = str.substring( 0, i + 1 )
			break
		}
	}

	return whitespace.indexOf( str.charAt( 0 ) ) === -1 ? str : ''
}

function ucfirst( str ) {
	//  discuss at: http://locutus.io/php/ucfirst/
	// original by: Kevin van Zonneveld (http://kvz.io)
	// bugfixed by: Onno Marsman (https://twitter.com/onnomarsman)
	// improved by: Brett Zamir (http://brett-zamir.me)
	//   example 1: ucfirst('kevin van zonneveld')
	//   returns 1: 'Kevin van zonneveld'

	str += ''
	var f = str.charAt( 0 )
		.toUpperCase()
	return f + str.substr( 1 )
}

function base64_decode( encodedData ) { // eslint-disable-line camelcase
	//  discuss at: http://locutus.io/php/base64_decode/
	// original by: Tyler Akins (http://rumkin.com)
	// improved by: Thunder.m
	// improved by: Kevin van Zonneveld (http://kvz.io)
	// improved by: Kevin van Zonneveld (http://kvz.io)
	//    input by: Aman Gupta
	//    input by: Brett Zamir (http://brett-zamir.me)
	// bugfixed by: Onno Marsman (https://twitter.com/onnomarsman)
	// bugfixed by: Pellentesque Malesuada
	// bugfixed by: Kevin van Zonneveld (http://kvz.io)
	// improved by: Indigo744
	//   example 1: base64_decode('S2V2aW4gdmFuIFpvbm5ldmVsZA==')
	//   returns 1: 'Kevin van Zonneveld'
	//   example 2: base64_decode('YQ==')
	//   returns 2: 'a'
	//   example 3: base64_decode('4pyTIMOgIGxhIG1vZGU=')
	//   returns 3: '✓ à la mode'

	// decodeUTF8string()
	// Internal function to decode properly UTF8 string
	// Adapted from Solution #1 at https://developer.mozilla.org/en-US/docs/Web/API/WindowBase64/Base64_encoding_and_decoding
	var decodeUTF8string = function( str ) {
		// Going backwards: from bytestream, to percent-encoding, to original string.
		return decodeURIComponent( str.split( '' ).map( function( c ) {
			return '%' + ('00' + c.charCodeAt( 0 ).toString( 16 )).slice( -2 )
		} ).join( '' ) )
	}

	if ( typeof window !== 'undefined' ) {
		if ( typeof window.atob !== 'undefined' ) {
			return decodeUTF8string( window.atob( encodedData ) )
		}
	} else {
		return new Buffer( encodedData, 'base64' ).toString( 'utf-8' )
	}

	var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/='
	var o1
	var o2
	var o3
	var h1
	var h2
	var h3
	var h4
	var bits
	var i = 0
	var ac = 0
	var dec = ''
	var tmpArr = []

	if ( !encodedData ) {
		return encodedData
	}

	encodedData += ''

	do {
		// unpack four hexets into three octets using index points in b64
		h1 = b64.indexOf( encodedData.charAt( i++ ) )
		h2 = b64.indexOf( encodedData.charAt( i++ ) )
		h3 = b64.indexOf( encodedData.charAt( i++ ) )
		h4 = b64.indexOf( encodedData.charAt( i++ ) )

		bits = h1 << 18 | h2 << 12 | h3 << 6 | h4

		o1 = bits >> 16 & 0xff
		o2 = bits >> 8 & 0xff
		o3 = bits & 0xff

		if ( h3 === 64 ) {
			tmpArr[ ac++ ] = String.fromCharCode( o1 )
		} else if ( h4 === 64 ) {
			tmpArr[ ac++ ] = String.fromCharCode( o1, o2 )
		} else {
			tmpArr[ ac++ ] = String.fromCharCode( o1, o2, o3 )
		}
	} while ( i < encodedData.length )

	dec = tmpArr.join( '' )

	return decodeUTF8string( dec.replace( /\0+$/, '' ) )
}

function base64_encode( stringToEncode ) { // eslint-disable-line camelcase
	//  discuss at: http://locutus.io/php/base64_encode/
	// original by: Tyler Akins (http://rumkin.com)
	// improved by: Bayron Guevara
	// improved by: Thunder.m
	// improved by: Kevin van Zonneveld (http://kvz.io)
	// improved by: Kevin van Zonneveld (http://kvz.io)
	// improved by: Rafał Kukawski (http://blog.kukawski.pl)
	// bugfixed by: Pellentesque Malesuada
	// improved by: Indigo744
	//   example 1: base64_encode('Kevin van Zonneveld')
	//   returns 1: 'S2V2aW4gdmFuIFpvbm5ldmVsZA=='
	//   example 2: base64_encode('a')
	//   returns 2: 'YQ=='
	//   example 3: base64_encode('✓ à la mode')
	//   returns 3: '4pyTIMOgIGxhIG1vZGU='

	// encodeUTF8string()
	// Internal function to encode properly UTF8 string
	// Adapted from Solution #1 at https://developer.mozilla.org/en-US/docs/Web/API/WindowBase64/Base64_encoding_and_decoding
	var encodeUTF8string = function( str ) {
		// first we use encodeURIComponent to get percent-encoded UTF-8,
		// then we convert the percent encodings into raw bytes which
		// can be fed into the base64 encoding algorithm.
		return encodeURIComponent( str ).replace( /%([0-9A-F]{2})/g,
			function toSolidBytes( match, p1 ) {
				return String.fromCharCode( '0x' + p1 )
			} )
	}

	if ( typeof window !== 'undefined' ) {
		if ( typeof window.btoa !== 'undefined' ) {
			return window.btoa( encodeUTF8string( stringToEncode ) )
		}
	} else {
		return new Buffer( stringToEncode ).toString( 'base64' )
	}

	var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/='
	var o1
	var o2
	var o3
	var h1
	var h2
	var h3
	var h4
	var bits
	var i = 0
	var ac = 0
	var enc = ''
	var tmpArr = []

	if ( !stringToEncode ) {
		return stringToEncode
	}

	stringToEncode = encodeUTF8string( stringToEncode )

	do {
		// pack three octets into four hexets
		o1 = stringToEncode.charCodeAt( i++ )
		o2 = stringToEncode.charCodeAt( i++ )
		o3 = stringToEncode.charCodeAt( i++ )

		bits = o1 << 16 | o2 << 8 | o3

		h1 = bits >> 18 & 0x3f
		h2 = bits >> 12 & 0x3f
		h3 = bits >> 6 & 0x3f
		h4 = bits & 0x3f

		// use hexets to index into b64, and append result to encoded string
		tmpArr[ ac++ ] = b64.charAt( h1 ) + b64.charAt( h2 ) + b64.charAt( h3 ) + b64.charAt( h4 )
	} while ( i < stringToEncode.length )

	enc = tmpArr.join( '' )

	var r = stringToEncode.length % 3

	return (r ? enc.slice( 0, r - 3 ) : enc) + '==='.slice( r || 3 )
}

function isset() {
	//  discuss at: http://locutus.io/php/isset/
	// original by: Kevin van Zonneveld (http://kvz.io)
	// improved by: FremyCompany
	// improved by: Onno Marsman (https://twitter.com/onnomarsman)
	// improved by: Rafał Kukawski (http://blog.kukawski.pl)
	//   example 1: isset( undefined, true)
	//   returns 1: false
	//   example 2: isset( 'Kevin van Zonneveld' )
	//   returns 2: true

	var a = arguments
	var l = a.length
	var i = 0
	var undef

	if ( l === 0 ) {
		throw new Error( 'Empty isset' )
	}

	while ( i !== l ) {
		if ( a[ i ] === undef || a[ i ] === null ) {
			return false
		}
		i++
	}

	return true
}

function is_object( mixedVar ) { // eslint-disable-line camelcase
	//  discuss at: http://locutus.io/php/is_object/
	// original by: Kevin van Zonneveld (http://kvz.io)
	// improved by: Legaev Andrey
	// improved by: Michael White (http://getsprink.com)
	//   example 1: is_object('23')
	//   returns 1: false
	//   example 2: is_object({foo: 'bar'})
	//   returns 2: true
	//   example 3: is_object(null)
	//   returns 3: false

	if ( Object.prototype.toString.call( mixedVar ) === '[object Array]' ) {
		return false
	}
	return mixedVar !== null && typeof mixedVar === 'object'
}

function basename( path, suffix ) {
	//  discuss at: http://locutus.io/php/basename/
	// original by: Kevin van Zonneveld (http://kvz.io)
	// improved by: Ash Searle (http://hexmen.com/blog/)
	// improved by: Lincoln Ramsay
	// improved by: djmix
	// improved by: Dmitry Gorelenkov
	//   example 1: basename('/www/site/home.htm', '.htm')
	//   returns 1: 'home'
	//   example 2: basename('ecra.php?p=1')
	//   returns 2: 'ecra.php?p=1'
	//   example 3: basename('/some/path/')
	//   returns 3: 'path'
	//   example 4: basename('/some/path_ext.ext/','.ext')
	//   returns 4: 'path_ext'

	var b = path
	var lastChar = b.charAt( b.length - 1 )

	if ( lastChar === '/' || lastChar === '\\' ) {
		b = b.slice( 0, -1 )
	}

	b = b.replace( /^.*[/\\]/g, '' )

	if ( typeof suffix === 'string' && b.substr( b.length - suffix.length ) === suffix ) {
		b = b.substr( 0, b.length - suffix.length )
	}

	return b
}

function dirname( path ) {
	//  discuss at: http://locutus.io/php/dirname/
	// original by: Ozh
	// improved by: XoraX (http://www.xorax.info)
	//   example 1: dirname('/etc/passwd')
	//   returns 1: '/etc'
	//   example 2: dirname('c:/Temp/x')
	//   returns 2: 'c:/Temp'
	//   example 3: dirname('/dir/test/')
	//   returns 3: '/dir'

	return path.replace( /\\/g, '/' )
		.replace( /\/[^/]*\/?$/, '' )
}

function realpath( path ) {
	//  discuss at: http://locutus.io/php/realpath/
	// original by: mk.keck
	// improved by: Kevin van Zonneveld (http://kvz.io)
	//      note 1: Returned path is an url like e.g. 'http://yourhost.tld/path/'
	//   example 1: realpath('some/dir/.././_supporters/pj_test_supportfile_1.htm')
	//   returns 1: 'some/_supporters/pj_test_supportfile_1.htm'

	if ( typeof window === 'undefined' ) {
		var nodePath = require( 'path' )
		return nodePath.normalize( path )
	}

	var p = 0
	var arr = [] // Save the root, if not given
	var r = this.window.location.href // Avoid input failures

	// Check if there's a port in path (like 'http://')
	path = (path + '').replace( '\\', '/' )
	if ( path.indexOf( '://' ) !== -1 ) {
		p = 1
	}

	// Ok, there's not a port in path, so let's take the root
	if ( !p ) {
		path = r.substring( 0, r.lastIndexOf( '/' ) + 1 ) + path
	}

	// Explode the given path into it's parts
	arr = path.split( '/' ) // The path is an array now
	path = [] // Foreach part make a check
	for ( var k in arr ) { // This is'nt really interesting
		if ( arr[ k ] === '.' ) {
			continue
		}
		// This reduces the realpath
		if ( arr[ k ] === '..' ) {
			/* But only if there more than 3 parts in the path-array.
			 * The first three parts are for the uri */
			if ( path.length > 3 ) {
				path.pop()
			}
		} else {
			// This adds parts to the realpath
			// But only if the part is not empty or the uri
			// (the first three parts ar needed) was not
			// saved
			if ( (path.length < 2) || (arr[ k ] !== '') ) {
				path.push( arr[ k ] )
			}
		}
	}

	// Returns the absloute path as a string
	return path.join( '/' )
}

function count( mixedVar, mode ) {
	var key
	var cnt = 0

	if ( mixedVar === null || typeof mixedVar === 'undefined' ) {
		return 0
	} else if ( mixedVar.constructor !== Array && mixedVar.constructor !== Object ) {
		return 1
	}

	if ( mode === 'COUNT_RECURSIVE' ) {
		mode = 1
	}
	if ( mode !== 1 ) {
		mode = 0
	}

	for ( key in mixedVar ) {
		if ( mixedVar.hasOwnProperty( key ) ) {
			cnt++
			if ( mode === 1 && mixedVar[ key ] &&
			     (mixedVar[ key ].constructor === Array ||
			      mixedVar[ key ].constructor === Object) ) {
				cnt += count( mixedVar[ key ], 1 )
			}
		}
	}

	return cnt
}

function strtoupper( str ) {
	return (str + '')
		.toUpperCase();
}

function ucwords( str ) {
	return (str + '')
		.replace( /^(.)|\s+(.)/g, function( $1 ) {
			return $1.toUpperCase()
		} )
}

function str_replace( search, replace, subject, countObj ) {
	var i = 0
	var j = 0
	var temp = ''
	var repl = ''
	var sl = 0
	var fl = 0
	var f = [].concat( search )
	var r = [].concat( replace )
	var s = subject
	var ra = Object.prototype.toString.call( r ) === '[object Array]'
	var sa = Object.prototype.toString.call( s ) === '[object Array]'
	s = [].concat( s )

	var $global = (typeof window !== 'undefined' ? window : global)
	$global.$locutus = $global.$locutus || {}
	var $locutus = $global.$locutus
	$locutus.php = $locutus.php || {}

	if ( typeof (search) === 'object' && typeof (replace) === 'string' ) {
		temp = replace
		replace = []
		for ( i = 0; i < search.length; i += 1 ) {
			replace[ i ] = temp
		}
		temp = ''
		r = [].concat( replace )
		ra = Object.prototype.toString.call( r ) === '[object Array]'
	}

	if ( typeof countObj !== 'undefined' ) {
		countObj.value = 0
	}

	for ( i = 0, sl = s.length; i < sl; i++ ) {
		if ( s[ i ] === '' ) {
			continue
		}
		for ( j = 0, fl = f.length; j < fl; j++ ) {
			temp = s[ i ] + ''
			repl = ra ? (r[ j ] !== undefined ? r[ j ] : '') : r[ 0 ]
			s[ i ] = (temp).split( f[ j ] ).join( repl )
			if ( typeof countObj !== 'undefined' ) {
				countObj.value += ((temp.split( f[ j ] )).length - 1)
			}
		}
	}
	return sa ? s : s[ 0 ]
}

// ***********************
// ***********************
// ***********************
function strtotime( text, now ) {
	var parsed, match, today, year, date, days, ranges, len, times, regex, i, fail = false;

	if ( !text ) {
		return fail;
	}

	// Unecessary spaces
	text = text.replace( /^\s+|\s+$/g, '' )
		.replace( /\s{2,}/g, ' ' )
		.replace( /[\t\r\n]/g, '' )
		.toLowerCase();

	// in contrast to php, js Date.parse function interprets:
	// dates given as yyyy-mm-dd as in timezone: UTC,
	// dates with "." or "-" as MDY instead of DMY
	// dates with two-digit years differently
	// etc...etc...
	// ...therefore we manually parse lots of common date formats
	match = text.match(
		/^(\d{1,4})([\-\.\/\:])(\d{1,2})([\-\.\/\:])(\d{1,4})(?:\s(\d{1,2}):(\d{2})?:?(\d{2})?)?(?:\s([A-Z]+)?)?$/ );

	if ( match && match[ 2 ] === match[ 4 ] ) {
		if ( match[ 1 ] > 1901 ) {
			switch ( match[ 2 ] ) {
				case '-': {
					// YYYY-M-D
					if ( match[ 3 ] > 12 || match[ 5 ] > 31 ) {
						return fail;
					}

					return new Date( match[ 1 ], parseInt( match[ 3 ], 10 ) - 1, match[ 5 ],
						match[ 6 ] || 0, match[ 7 ] || 0, match[ 8 ] || 0, match[ 9 ] || 0 ) / 1000;
				}
				case '.': {
					// YYYY.M.D is not parsed by strtotime()
					return fail;
				}
				case '/': {
					// YYYY/M/D
					if ( match[ 3 ] > 12 || match[ 5 ] > 31 ) {
						return fail;
					}

					return new Date( match[ 1 ], parseInt( match[ 3 ], 10 ) - 1, match[ 5 ],
						match[ 6 ] || 0, match[ 7 ] || 0, match[ 8 ] || 0, match[ 9 ] || 0 ) / 1000;
				}
			}
		} else if ( match[ 5 ] > 1901 ) {
			switch ( match[ 2 ] ) {
				case '-': {
					// D-M-YYYY
					if ( match[ 3 ] > 12 || match[ 1 ] > 31 ) {
						return fail;
					}

					return new Date( match[ 5 ], parseInt( match[ 3 ], 10 ) - 1, match[ 1 ],
						match[ 6 ] || 0, match[ 7 ] || 0, match[ 8 ] || 0, match[ 9 ] || 0 ) / 1000;
				}
				case '.': {
					// D.M.YYYY
					if ( match[ 3 ] > 12 || match[ 1 ] > 31 ) {
						return fail;
					}

					return new Date( match[ 5 ], parseInt( match[ 3 ], 10 ) - 1, match[ 1 ],
						match[ 6 ] || 0, match[ 7 ] || 0, match[ 8 ] || 0, match[ 9 ] || 0 ) / 1000;
				}
				case '/': {
					// M/D/YYYY
					if ( match[ 1 ] > 12 || match[ 3 ] > 31 ) {
						return fail;
					}

					return new Date( match[ 5 ], parseInt( match[ 1 ], 10 ) - 1, match[ 3 ],
						match[ 6 ] || 0, match[ 7 ] || 0, match[ 8 ] || 0, match[ 9 ] || 0 ) / 1000;
				}
			}
		} else {
			switch ( match[ 2 ] ) {
				case '-': {
					// YY-M-D
					if ( match[ 3 ] > 12 || match[ 5 ] > 31 || (match[ 1 ] < 70 && match[ 1 ] > 38) ) {
						return fail;
					}

					year = match[ 1 ] >= 0 && match[ 1 ] <= 38 ? +match[ 1 ] + 2000 : match[ 1 ];
					return new Date( year, parseInt( match[ 3 ], 10 ) - 1, match[ 5 ],
						match[ 6 ] || 0, match[ 7 ] || 0, match[ 8 ] || 0, match[ 9 ] || 0 ) / 1000;
				}
				case '.': {
					// D.M.YY or H.MM.SS
					if ( match[ 5 ] >= 70 ) {
						// D.M.YY
						if ( match[ 3 ] > 12 || match[ 1 ] > 31 ) {
							return fail;
						}

						return new Date( match[ 5 ], parseInt( match[ 3 ], 10 ) - 1, match[ 1 ],
							match[ 6 ] || 0, match[ 7 ] || 0, match[ 8 ] || 0, match[ 9 ] || 0 ) / 1000;
					}
					if ( match[ 5 ] < 60 && !match[ 6 ] ) {
						// H.MM.SS
						if ( match[ 1 ] > 23 || match[ 3 ] > 59 ) {
							return fail;
						}

						today = new Date();
						return new Date( today.getFullYear(), today.getMonth(), today.getDate(),
							match[ 1 ] || 0, match[ 3 ] || 0, match[ 5 ] || 0, match[ 9 ] || 0 ) / 1000;
					}

					// invalid format, cannot be parsed
					return fail;
				}
				case '/': {
					// M/D/YY
					if ( match[ 1 ] > 12 || match[ 3 ] > 31 || (match[ 5 ] < 70 && match[ 5 ] > 38) ) {
						return fail;
					}

					year = match[ 5 ] >= 0 && match[ 5 ] <= 38 ? +match[ 5 ] + 2000 : match[ 5 ];
					return new Date( year, parseInt( match[ 1 ], 10 ) - 1, match[ 3 ],
						match[ 6 ] || 0, match[ 7 ] || 0, match[ 8 ] || 0, match[ 9 ] || 0 ) / 1000;
				}
				case ':': {
					// HH:MM:SS
					if ( match[ 1 ] > 23 || match[ 3 ] > 59 || match[ 5 ] > 59 ) {
						return fail;
					}

					today = new Date();
					return new Date( today.getFullYear(), today.getMonth(), today.getDate(),
						match[ 1 ] || 0, match[ 3 ] || 0, match[ 5 ] || 0 ) / 1000;
				}
			}
		}
	}

	// other formats and "now" should be parsed by Date.parse()
	if ( text === 'now' ) {
		return now === null || isNaN( now ) ? new Date()
			                                      .getTime() / 1000 | 0 : now | 0;
	}
	if ( !isNaN( parsed = Date.parse( text ) ) ) {
		return parsed / 1000 | 0;
	}
	// Browsers != Chrome have problems parsing ISO 8601 date strings, as they do
	// not accept lower case characters, space, or shortened time zones.
	// Therefore, fix these problems and try again.
	// Examples:
	//   2015-04-15 20:33:59+02
	//   2015-04-15 20:33:59z
	//   2015-04-15t20:33:59+02:00
	if ( match = text.match(
		/^([0-9]{4}-[0-9]{2}-[0-9]{2})[ t]([0-9]{2}:[0-9]{2}:[0-9]{2}(\.[0-9]+)?)([\+-][0-9]{2}(:[0-9]{2})?|z)/ ) ) {
		// fix time zone information
		if ( match[ 4 ] == 'z' ) {
			match[ 4 ] = 'Z';
		} else if ( match[ 4 ].match( /^([\+-][0-9]{2})$/ ) ) {
			match[ 4 ] = match[ 4 ] + ':00';
		}

		if ( !isNaN( parsed = Date.parse( match[ 1 ] + 'T' + match[ 2 ] + match[ 4 ] ) ) ) {
			return parsed / 1000 | 0;
		}
	}

	date = now ? new Date( now * 1000 ) : new Date();
	days = {
		'sun': 0,
		'mon': 1,
		'tue': 2,
		'wed': 3,
		'thu': 4,
		'fri': 5,
		'sat': 6
	};
	ranges = {
		'yea': 'FullYear',
		'mon': 'Month',
		'day': 'Date',
		'hou': 'Hours',
		'min': 'Minutes',
		'sec': 'Seconds'
	};

	function lastNext( type, range, modifier ) {
		var diff, day = days[ range ];

		if ( typeof day !== 'undefined' ) {
			diff = day - date.getDay();

			if ( diff === 0 ) {
				diff = 7 * modifier;
			} else if ( diff > 0 && type === 'last' ) {
				diff -= 7;
			} else if ( diff < 0 && type === 'next' ) {
				diff += 7;
			}

			date.setDate( date.getDate() + diff );
		}
	}

	function process( val ) {
		var splt = val.split( ' ' ), // Todo: Reconcile this with regex using \s, taking into account browser issues with split and regexes
			type = splt[ 0 ],
			range = splt[ 1 ].substring( 0, 3 ),
			typeIsNumber = /\d+/.test( type ),
			ago = splt[ 2 ] === 'ago',
			num = (type === 'last' ? -1 : 1) * (ago ? -1 : 1);

		if ( typeIsNumber ) {
			num *= parseInt( type, 10 );
		}

		if ( ranges.hasOwnProperty( range ) && !splt[ 1 ].match( /^mon(day|\.)?$/i ) ) {
			return date[ 'set' + ranges[ range ] ]( date[ 'get' + ranges[ range ] ]() + num );
		}

		if ( range === 'wee' ) {
			return date.setDate( date.getDate() + (num * 7) );
		}

		if ( type === 'next' || type === 'last' ) {
			lastNext( type, range, num );
		} else if ( !typeIsNumber ) {
			return false;
		}

		return true;
	}

	times = '(years?|months?|weeks?|days?|hours?|minutes?|min|seconds?|sec' +
	        '|sunday|sun\\.?|monday|mon\\.?|tuesday|tue\\.?|wednesday|wed\\.?' +
	        '|thursday|thu\\.?|friday|fri\\.?|saturday|sat\\.?)';
	regex = '([+-]?\\d+\\s' + times + '|' + '(last|next)\\s' + times + ')(\\sago)?';

	match = text.match( new RegExp( regex, 'gi' ) );
	if ( !match ) {
		return fail;
	}

	for ( i = 0, len = match.length; i < len; i++ ) {
		if ( !process( match[ i ] ) ) {
			return fail;
		}
	}

	// ECMAScript 5 only
	// if (!match.every(process))
	//    return false;

	return (date.getTime() / 1000);
}

function date( format, timestamp ) {
	var that = this;
	var jsdate, f;
	// Keep this here (works, but for code commented-out below for file size reasons)
	// var tal= [];
	var txt_words = [
		'Sun', 'Mon', 'Tues', 'Wednes', 'Thurs', 'Fri', 'Satur',
		'January', 'February', 'March', 'April', 'May', 'June',
		'July', 'August', 'September', 'October', 'November', 'December'
	];
	// trailing backslash -> (dropped)
	// a backslash followed by any character (including backslash) -> the character
	// empty string -> empty string
	var formatChr = /\\?(.?)/gi;
	var formatChrCb = function( t, s ) {
		return f[ t ] ? f[ t ]() : s;
	};
	var _pad = function( n, c ) {
		n = String( n );
		while ( n.length < c ) {
			n = '0' + n;
		}
		return n;
	};
	f = {
		// Day
		d: function() {
			// Day of month w/leading 0; 01..31
			return _pad( f.j(), 2 );
		},
		D: function() {
			// Shorthand day name; Mon...Sun
			return f.l()
				.slice( 0, 3 );
		},
		j: function() {
			// Day of month; 1..31
			return jsdate.getDate();
		},
		l: function() {
			// Full day name; Monday...Sunday
			return txt_words[ f.w() ] + 'day';
		},
		N: function() {
			// ISO-8601 day of week; 1[Mon]..7[Sun]
			return f.w() || 7;
		},
		S: function() {
			// Ordinal suffix for day of month; st, nd, rd, th
			var j = f.j();
			var i = j % 10;
			if ( i <= 3 && parseInt( (j % 100) / 10, 10 ) == 1 ) {
				i = 0;
			}
			return ['st', 'nd', 'rd'][ i - 1 ] || 'th';
		},
		w: function() {
			// Day of week; 0[Sun]..6[Sat]
			return jsdate.getDay();
		},
		z: function() {
			// Day of year; 0..365
			var a = new Date( f.Y(), f.n() - 1, f.j() );
			var b = new Date( f.Y(), 0, 1 );
			return Math.round( (a - b) / 864e5 );
		},

		// Week
		W: function() {
			// ISO-8601 week number
			var a = new Date( f.Y(), f.n() - 1, f.j() - f.N() + 3 );
			var b = new Date( a.getFullYear(), 0, 4 );
			return _pad( 1 + Math.round( (a - b) / 864e5 / 7 ), 2 );
		},

		// Month
		F: function() {
			// Full month name; January...December
			return txt_words[ 6 + f.n() ];
		},
		m: function() {
			// Month w/leading 0; 01...12
			return _pad( f.n(), 2 );
		},
		M: function() {
			// Shorthand month name; Jan...Dec
			return f.F()
				.slice( 0, 3 );
		},
		n: function() {
			// Month; 1...12
			return jsdate.getMonth() + 1;
		},
		t: function() {
			// Days in month; 28...31
			return (new Date( f.Y(), f.n(), 0 ))
				.getDate();
		},

		// Year
		L: function() {
			// Is leap year?; 0 or 1
			var j = f.Y();
			return j % 4 === 0 & j % 100 !== 0 | j % 400 === 0;
		},
		o: function() {
			// ISO-8601 year
			var n = f.n();
			var W = f.W();
			var Y = f.Y();
			return Y + (n === 12 && W < 9 ? 1 : n === 1 && W > 9 ? -1 : 0);
		},
		Y: function() {
			// Full year; e.g. 1980...2010
			return jsdate.getFullYear();
		},
		y: function() {
			// Last two digits of year; 00...99
			return f.Y()
				.toString()
				.slice( -2 );
		},

		// Time
		a: function() {
			// am or pm
			return jsdate.getHours() > 11 ? 'pm' : 'am';
		},
		A: function() {
			// AM or PM
			return f.a()
				.toUpperCase();
		},
		B: function() {
			// Swatch Internet time; 000..999
			var H = jsdate.getUTCHours() * 36e2;
			// Hours
			var i = jsdate.getUTCMinutes() * 60;
			// Minutes
			// Seconds
			var s = jsdate.getUTCSeconds();
			return _pad( Math.floor( (H + i + s + 36e2) / 86.4 ) % 1e3, 3 );
		},
		g: function() {
			// 12-Hours; 1..12
			return f.G() % 12 || 12;
		},
		G: function() {
			// 24-Hours; 0..23
			return jsdate.getHours();
		},
		h: function() {
			// 12-Hours w/leading 0; 01..12
			return _pad( f.g(), 2 );
		},
		H: function() {
			// 24-Hours w/leading 0; 00..23
			return _pad( f.G(), 2 );
		},
		i: function() {
			// Minutes w/leading 0; 00..59
			return _pad( jsdate.getMinutes(), 2 );
		},
		s: function() {
			// Seconds w/leading 0; 00..59
			return _pad( jsdate.getSeconds(), 2 );
		},
		u: function() {
			// Microseconds; 000000-999000
			return _pad( jsdate.getMilliseconds() * 1000, 6 );
		},

		// Timezone
		e: function() {
			// Timezone identifier; e.g. Atlantic/Azores, ...
			// The following works, but requires inclusion of the very large
			// timezone_abbreviations_list() function.
			/*              return that.date_default_timezone_get();
			 */
			throw 'Not supported (see source code of date() for timezone on how to add support)';
		},
		I: function() {
			// DST observed?; 0 or 1
			// Compares Jan 1 minus Jan 1 UTC to Jul 1 minus Jul 1 UTC.
			// If they are not equal, then DST is observed.
			var a = new Date( f.Y(), 0 );
			// Jan 1
			var c = Date.UTC( f.Y(), 0 );
			// Jan 1 UTC
			var b = new Date( f.Y(), 6 );
			// Jul 1
			// Jul 1 UTC
			var d = Date.UTC( f.Y(), 6 );
			return ((a - c) !== (b - d)) ? 1 : 0;
		},
		O: function() {
			// Difference to GMT in hour format; e.g. +0200
			var tzo = jsdate.getTimezoneOffset();
			var a = Math.abs( tzo );
			return (tzo > 0 ? '-' : '+') + _pad( Math.floor( a / 60 ) * 100 + a % 60, 4 );
		},
		P: function() {
			// Difference to GMT w/colon; e.g. +02:00
			var O = f.O();
			return (O.substr( 0, 3 ) + ':' + O.substr( 3, 2 ));
		},
		T: function() {
			// Timezone abbreviation; e.g. EST, MDT, ...
			// The following works, but requires inclusion of the very
			// large timezone_abbreviations_list() function.
			/*              var abbr, i, os, _default;
			 if (!tal.length) {
			 tal = that.timezone_abbreviations_list();
			 }
			 if (that.php_js && that.php_js.default_timezone) {
			 _default = that.php_js.default_timezone;
			 for (abbr in tal) {
			 for (i = 0; i < tal[abbr].length; i++) {
			 if (tal[abbr][i].timezone_id === _default) {
			 return abbr.toUpperCase();
			 }
			 }
			 }
			 }
			 for (abbr in tal) {
			 for (i = 0; i < tal[abbr].length; i++) {
			 os = -jsdate.getTimezoneOffset() * 60;
			 if (tal[abbr][i].offset === os) {
			 return abbr.toUpperCase();
			 }
			 }
			 }
			 */
			return 'UTC';
		},
		Z: function() {
			// Timezone offset in seconds (-43200...50400)
			return -jsdate.getTimezoneOffset() * 60;
		},

		// Full Date/Time
		c: function() {
			// ISO-8601 date.
			return 'Y-m-d\\TH:i:sP'.replace( formatChr, formatChrCb );
		},
		r: function() {
			// RFC 2822
			return 'D, d M Y H:i:s O'.replace( formatChr, formatChrCb );
		},
		U: function() {
			// Seconds since UNIX epoch
			return jsdate / 1000 | 0;
		}
	};
	this.date = function( format, timestamp ) {
		that = this;
		jsdate = (timestamp === undefined ? new Date() : // Not provided
		          (timestamp instanceof Date) ? new Date( timestamp ) : // JS Date()
		          new Date( timestamp * 1000 ) // UNIX timestamp (auto-convert to int)
		);
		return format.replace( formatChr, formatChrCb );
	};
	return this.date( format, timestamp );
}

my_date = function( date_val ) {
	if ( typeof date_val == "undefined" ) {
		return date( "d-m-Y" );
	} else if ( empty( date_val ) ) {
		return "";
	} else {
		return date( "d-m-Y", strtotime( date_val ) );
	}
}
get_calender_date = function( date_val, formate = 'd-m-Y' ) {
	if ( typeof date_val == "undefined" ) {
		return date( formate );
	} else if ( date_val == "0000-00-00" ) {
		return "-";
	} else if ( empty( date_val ) ) {
		return "-";
	} else {
		return date( formate, strtotime2( date_val ) );
	}
}
mysql_date = function( date_val, formate = 'd-m-Y' ) {
	if ( typeof date_val == "undefined" ) {
		return date( formate );
	} else if ( date_val == "0000-00-00" ) {
		return "-";
	} else if ( empty( date_val ) ) {
		return "-";
	} else {
		return date( formate, strtotime( date_val ) );
	}
}
my_datetime = function( date_val ) {
	if ( typeof date_val == "undefined" ) {
		return date( "d-m-Y H:i" );
	} else if ( empty( date_val ) ) {
		return "";
	} else {
		return date( "d-m-Y H:i", strtotime( date_val ) );
	}
}
mysql_datetime = function( date_val ) {
	if ( typeof date_val == "undefined" ) {
		return date( "d-m-Y H:i:s" );
	} else if ( empty( date_val ) ) {
		return "";
	} else {
		return date( "d-m-Y H:i:s", strtotime( date_val ) );
	}
}
my_time = function( date_val ) {
	if ( typeof date_val == "undefined" ) {
		return date( "h:i:s A" );
	} else if ( empty( date_val ) ) {
		return "";
	} else {
		return date( "h:i:s A", strtotime( date_val ) );
	}
}

my_datetime_formate = function( date_val, formate = 'd-m-Y H:i' ) {
	if ( typeof date_val == "undefined" ) {
		return date( formate );
	} else if ( empty( date_val ) ) {
		return "";
	} else {
		return date( formate, strtotime( date_val ) );
	}
}

function is_past_date( ddate ) {
	var d = my_date( ddate );

	return strtotime( d ) < strtotime( my_date() );
}

function isNumber( evt ) {
	evt = (evt) ? evt : window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if ( charCode == 46 && $( this ).indexOf( '.' ) != -1 ) {
		return true;
	} else if ( charCode > 31 && (charCode < 48 || charCode > 57) ) {
		return false;
	}
	return true;
}

function number_format( number, decimals, decPoint, thousandsSep ) {
	number = (number + '').replace( /[^0-9+\-Ee.]/g, '' )
	var n = !isFinite( +number ) ? 0 : +number
	var prec = !isFinite( +decimals ) ? 0 : Math.abs( decimals )
	var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
	var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
	var s = ''

	var toFixedFix = function( n, prec ) {
		if ( ('' + n).indexOf( 'e' ) === -1 ) {
			return +(Math.round( n + 'e+' + prec ) + 'e-' + prec)
		} else {
			var arr = ('' + n).split( 'e' )
			var sig = ''
			if ( +arr[ 1 ] + prec > 0 ) {
				sig = '+'
			}
			return (+(Math.round( +arr[ 0 ] + 'e' + sig + (+arr[ 1 ] + prec) ) + 'e-' + prec)).toFixed( prec )
		}
	}

	// @todo: for IE parseFloat(0.55).toFixed(0) = 0;
	s = (prec ? toFixedFix( n, prec ).toString() : '' + Math.round( n )).split( '.' )
	if ( s[ 0 ].length > 3 ) {
		s[ 0 ] = s[ 0 ].replace( /\B(?=(?:\d{3})+(?!\d))/g, sep )
	}
	if ( (s[ 1 ] || '').length < prec ) {
		s[ 1 ] = s[ 1 ] || ''
		s[ 1 ] += new Array( prec - s[ 1 ].length + 1 ).join( '0' )
	}

	return s.join( dec )
}

function json_decode( strJson ) {

	var $global = (typeof window !== 'undefined' ? window : global)
	$global.$locutus = $global.$locutus || {}
	var $locutus = $global.$locutus
	$locutus.php = $locutus.php || {}

	var json = $global.JSON
	if ( typeof json === 'object' && typeof json.parse === 'function' ) {
		try {
			return json.parse( strJson )
		} catch ( err ) {
			if ( !(err instanceof SyntaxError) ) {
				throw new Error( 'Unexpected error type in json_decode()' )
			}

			// usable by json_last_error()
			$locutus.php.last_error_json = 4
			return null
		}
	}

	var chars = [
		'\u0000',
		'\u00ad',
		'\u0600-\u0604',
		'\u070f',
		'\u17b4',
		'\u17b5',
		'\u200c-\u200f',
		'\u2028-\u202f',
		'\u2060-\u206f',
		'\ufeff',
		'\ufff0-\uffff'
	].join( '' )
	var cx = new RegExp( '[' + chars + ']', 'g' )
	var j
	var text = strJson

	// Parsing happens in four stages. In the first stage, we replace certain
	// Unicode characters with escape sequences. JavaScript handles many characters
	// incorrectly, either silently deleting them, or treating them as line endings.
	cx.lastIndex = 0
	if ( cx.test( text ) ) {
		text = text.replace( cx, function( a ) {
			return '\\u' + ('0000' + a.charCodeAt( 0 )
				.toString( 16 ))
				.slice( -4 )
		} )
	}

	// In the second stage, we run the text against regular expressions that look
	// for non-JSON patterns. We are especially concerned with '()' and 'new'
	// because they can cause invocation, and '=' because it can cause mutation.
	// But just to be safe, we want to reject all unexpected forms.
	// We split the second stage into 4 regexp operations in order to work around
	// crippling inefficiencies in IE's and Safari's regexp engines. First we
	// replace the JSON backslash pairs with '@' (a non-JSON character). Second, we
	// replace all simple value tokens with ']' characters. Third, we delete all
	// open brackets that follow a colon or comma or that begin the text. Finally,
	// we look to see that the remaining characters are only whitespace or ']' or
	// ',' or ':' or '{' or '}'. If that is so, then the text is safe for eval.

	var m = (/^[\],:{}\s]*$/)
		.test( text.replace( /\\(?:["\\/bfnrt]|u[0-9a-fA-F]{4})/g, '@' )
			.replace( /"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+-]?\d+)?/g, ']' )
			.replace( /(?:^|:|,)(?:\s*\[)+/g, '' ) )

	if ( m ) {
		// In the third stage we use the eval function to compile the text into a
		// JavaScript structure. The '{' operator is subject to a syntactic ambiguity
		// in JavaScript: it can begin a block or an object literal. We wrap the text
		// in parens to eliminate the ambiguity.
		j = eval( '(' + text + ')' ) // eslint-disable-line no-eval
		return j
	}

	// usable by json_last_error()
	$locutus.php.last_error_json = 4
	return null
}

function json_encode( mixedVal ) {
	var $global = (typeof window !== 'undefined' ? window : global)
	$global.$locutus = $global.$locutus || {}
	var $locutus = $global.$locutus
	$locutus.php = $locutus.php || {}

	var json = $global.JSON
	var retVal
	try {
		if ( typeof json === 'object' && typeof json.stringify === 'function' ) {
			// Errors will not be caught here if our own equivalent to resource
			retVal = json.stringify( mixedVal )
			if ( retVal === undefined ) {
				throw new SyntaxError( 'json_encode' )
			}
			return retVal
		}

		var value = mixedVal

		var quote = function( string ) {
			var escapeChars = [
				'\u0000-\u001f',
				'\u007f-\u009f',
				'\u00ad',
				'\u0600-\u0604',
				'\u070f',
				'\u17b4',
				'\u17b5',
				'\u200c-\u200f',
				'\u2028-\u202f',
				'\u2060-\u206f',
				'\ufeff',
				'\ufff0-\uffff'
			].join( '' )
			var escapable = new RegExp( '[\\"' + escapeChars + ']', 'g' )
			var meta = {
				// table of character substitutions
				'\b': '\\b',
				'\t': '\\t',
				'\n': '\\n',
				'\f': '\\f',
				'\r': '\\r',
				'"': '\\"',
				'\\': '\\\\'
			}

			escapable.lastIndex = 0
			return escapable.test( string ) ? '"' + string.replace( escapable, function( a ) {
				var c = meta[ a ]
				return typeof c === 'string' ? c : '\\u' + ('0000' + a.charCodeAt( 0 )
					.toString( 16 ))
					.slice( -4 )
			} ) + '"' : '"' + string + '"'
		}

		var _str = function( key, holder ) {
			var gap = ''
			var indent = '    '
			// The loop counter.
			var i = 0
			// The member key.
			var k = ''
			// The member value.
			var v = ''
			var length = 0
			var mind = gap
			var partial = []
			var value = holder[ key ]

			// If the value has a toJSON method, call it to obtain a replacement value.
			if ( value && typeof value === 'object' && typeof value.toJSON === 'function' ) {
				value = value.toJSON( key )
			}

			// What happens next depends on the value's type.
			switch ( typeof value ) {
				case 'string':
					return quote( value )

				case 'number':
					// JSON numbers must be finite. Encode non-finite numbers as null.
					return isFinite( value ) ? String( value ) : 'null'

				case 'boolean':
				case 'null':
					// If the value is a boolean or null, convert it to a string. Note:
					// typeof null does not produce 'null'. The case is included here in
					// the remote chance that this gets fixed someday.
					return String( value )

				case 'object':
					// If the type is 'object', we might be dealing with an object or an array or
					// null.
					// Due to a specification blunder in ECMAScript, typeof null is 'object',
					// so watch out for that case.
					if ( !value ) {
						return 'null'
					}

					// Make an array to hold the partial results of stringifying this object value.
					gap += indent
					partial = []

					// Is the value an array?
					if ( Object.prototype.toString.apply( value ) === '[object Array]' ) {
						// The value is an array. Stringify every element. Use null as a placeholder
						// for non-JSON values.
						length = value.length
						for ( i = 0; i < length; i += 1 ) {
							partial[ i ] = _str( i, value ) || 'null'
						}

						// Join all of the elements together, separated with commas, and wrap them in
						// brackets.
						v = partial.length === 0 ? '[]' : gap
						                                  ? '[\n' + gap + partial.join( ',\n' + gap ) + '\n' + mind + ']'
						                                  : '[' + partial.join( ',' ) + ']'
						gap = mind
						return v
					}

					// Iterate through all of the keys in the object.
					for ( k in value ) {
						if ( Object.hasOwnProperty.call( value, k ) ) {
							v = _str( k, value )
							if ( v ) {
								partial.push( quote( k ) + (gap ? ': ' : ':') + v )
							}
						}
					}

					// Join all of the member texts together, separated with commas,
					// and wrap them in braces.
					v = partial.length === 0 ? '{}' : gap
					                                  ? '{\n' + gap + partial.join( ',\n' + gap ) + '\n' + mind + '}'
					                                  : '{' + partial.join( ',' ) + '}'
					gap = mind
					return v
				case 'undefined':
				case 'function':
				default:
					throw new SyntaxError( 'json_encode' )
			}
		}

		// Make a fake root object containing our value under the key of ''.
		// Return the result of stringifying the value.
		return _str( '', {
			'': value
		} )
	} catch ( err ) {
		// @todo: ensure error handling above throws a SyntaxError in all cases where it could
		// (i.e., when the JSON global is not available and there is an error)
		if ( !(err instanceof SyntaxError) ) {
			throw new Error( 'Unexpected error type in json_encode()' )
		}
		// usable by json_last_error()
		$locutus.php.last_error_json = 4
		return null
	}
}

var uniqueID = function( len = 9 ) {
	if ( empty( len ) ) {
		len = 9;
	}
	// Math.random should be unique because of its seeding algorithm.
	// Convert it to base 36 (numbers + letters), and grab the first 9 characters
	// after the decimal.
	return Math.random().toString( 36 ).substr( 2, len );
}

// This function sets new URL of browser without refreshing page.
function set_new_url( $new_url, title ) {
	window.history.pushState( {}, title, $new_url );
	if ( title ) {
		document.title = title;
	}
}

function in_array( needle, haystack, argStrict ) { // eslint-disable-line camelcase
	//  discuss at: https://locutus.io/php/in_array/
	// original by: Kevin van Zonneveld (https://kvz.io)
	// improved by: vlado houba
	// improved by: Jonas Sciangula Street (Joni2Back)
	//    input by: Billy
	// bugfixed by: Brett Zamir (https://brett-zamir.me)
	//   example 1: in_array('van', ['Kevin', 'van', 'Zonneveld'])
	//   returns 1: true
	//   example 2: in_array('vlado', {0: 'Kevin', vlado: 'van', 1: 'Zonneveld'})
	//   returns 2: false
	//   example 3: in_array(1, ['1', '2', '3'])
	//   example 3: in_array(1, ['1', '2', '3'], false)
	//   returns 3: true
	//   returns 3: true
	//   example 4: in_array(1, ['1', '2', '3'], true)
	//   returns 4: false

	var key = ''
	var strict = !!argStrict

	// we prevent the double check (strict && arr[key] === ndl) || (!strict && arr[key] === ndl)
	// in just one for, in order to improve the performance
	// deciding wich type of comparation will do before walk array
	if ( strict ) {
		for ( key in haystack ) {
			if ( haystack[ key ] === needle ) {
				return true
			}
		}
	} else {
		for ( key in haystack ) {
			if ( haystack[ key ] == needle ) { // eslint-disable-line eqeqeq
				return true
			}
		}
	}

	return false
}