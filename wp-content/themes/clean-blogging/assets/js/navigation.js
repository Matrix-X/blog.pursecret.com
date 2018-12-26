/**
 * Theme functions file.
 *
 * Contains handlers for navigation and widget area.
 *
 * @package clean-blogging
 */

(function( $ ) {
	var masthead, menuToggle, siteNavContain, siteNavigation;

	function initMainNavigation( container ) {

		// Add dropdown toggle that displays child menu items.
		var dropdownToggle = $( '<button />', { 'class': 'dropdown-toggle', 'aria-expanded': false } )
			.append( $( '<i />', { 'class': 'icon-down dropdownsymbol', text: '' } ) )
			.append( $( '<span />', { 'class': 'screen-reader-text', text: clean_blogging_ScreenReaderText.expand } ) );

		container.find( '.menu > li.menu-item-has-children > a, .menu > li.page_item_has_children > a' ).after( dropdownToggle );
		container.find( '.menu > li.menu-item-has-children > a, .menu > li.page_item_has_children > a' ).after( '<i class="icon-down desktop-dropdownsymbol"></i>' );

		// Set the active submenu dropdown toggle button initial state.
		container.find( '.current-menu-ancestor > button' )
			.addClass( 'toggled-on' )
			.attr( 'aria-expanded', 'true' )
			.find( '.screen-reader-text' )
			.text( clean_blogging_ScreenReaderText.collapse );
		// Set the active submenu initial state.
		container.find( '.current-menu-ancestor > .sub-menu' ).addClass( 'toggled-on' );

		container.find( '.dropdown-toggle' ).click(
			function( e ) {
					var _this        = $( this ),
					screenReaderSpan = _this.find( '.screen-reader-text' );
					dropdownSymbol   = _this.find( '.dropdownsymbol' );

					e.preventDefault();
					_this.toggleClass( 'toggled-on' );
					_this.next( '.children, .sub-menu' ).toggleClass( 'toggled-on' );

					_this.attr( 'aria-expanded', _this.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );

					dropdownSymbol.attr( 'class', dropdownSymbol.attr( 'class' ) === 'icon-down dropdownsymbol' ? 'icon-angle-up dropdownsymbol' : 'icon-down dropdownsymbol' );

					screenReaderSpan.text( screenReaderSpan.text() === clean_blogging_ScreenReaderText.expand ? clean_blogging_ScreenReaderText.collapse : clean_blogging_ScreenReaderText.expand );
			}
		);
	}

	initMainNavigation( $( '.main-navigation' ) );

	masthead       = $( '#masthead' );
	menuToggle     = masthead.find( '.menu-toggle' );
	siteNavContain = masthead.find( '.main-navigation' );
	siteNavigation = masthead.find( '.main-navigation > div > ul' );

	// Enable menuToggle.
	(function() {

		// Return early if menuToggle is missing.
		if ( ! menuToggle.length ) {
			return;
		}

		// Add an initial value for the attribute.
		menuToggle.attr( 'aria-expanded', 'false' );

		menuToggle.on(
			'click.clean-blogging', function() {
				siteNavContain.toggleClass( 'toggled-on' );

				$( this ).attr( 'aria-expanded', siteNavContain.hasClass( 'toggled-on' ) );
			}
		);
	})();

	// Fix sub-menus for touch devices and better focus for hidden submenu items for accessibility.
	(function() {
		if ( ! siteNavigation.length || ! siteNavigation.children().length ) {
			return;
		}

		// Toggle `focus` class to allow submenu access on tablets.
		function toggleFocusClassTouchScreen() {
			if ( 'none' === $( '.menu-toggle' ).css( 'display' ) ) {

				$( document.body ).on(
					'touchstart.clean-blogging', function( e ) {
						if ( ! $( e.target ).closest( '.main-navigation li' ).length ) {
							$( '.main-navigation li' ).removeClass( 'focus' );
						}
					}
				);

				siteNavigation.find( '.menu-item-has-children > a, .page_item_has_children > a' )
					.on(
						'touchstart.clean-blogging', function( e ) {
							var el = $( this ).parent( 'li' );

							if ( ! el.hasClass( 'focus' ) ) {
								e.preventDefault();
								el.toggleClass( 'focus' );
								el.siblings( '.focus' ).removeClass( 'focus' );
							}
						}
					);

			} else {
				siteNavigation.find( '.menu-item-has-children > a, .page_item_has_children > a' ).unbind( 'touchstart.clean-blogging' );
			}
		}

		if ( 'ontouchstart' in window ) {
			$( window ).on( 'resize.clean-blogging', toggleFocusClassTouchScreen );
			toggleFocusClassTouchScreen();
		}

		siteNavigation.find( 'a' ).on(
			'focus.clean-blogging blur.clean-blogging', function() {
				$( this ).parents( '.menu-item, .page_item' ).toggleClass( 'focus' );
			}
		);
	})();
})( jQuery );
