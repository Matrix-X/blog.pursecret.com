/**
 * Live-update changed settings in real time in the Customizer preview.
 */

( function( $ ) {
	var style = $( '#cleanportfolio-color-scheme-css' ),
		api = wp.customize;

	if ( ! style.length ) {
		style = $( 'head' ).append( '<style type="text/css" id="cleanportfolio-color-scheme-css" />' )
		                    .find( '#cleanportfolio-color-scheme-css' );
	}

	// Site title.
	api( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );

	// Site tagline.
	api( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Add custom-background-image body class when background image is added.
	api( 'background_image', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).toggleClass( 'custom-background-image', '' !== to );
		} );
	} );

	// Color Scheme CSS.
	api.bind( 'preview-ready', function() {
		api.preview.bind( 'update-color-scheme-css', function( css ) {
			style.html( css );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-branding-text' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-branding-text' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-branding-text' ).css( {
					'color': to
				} );
			}
		} );
	} );
} )( jQuery );
