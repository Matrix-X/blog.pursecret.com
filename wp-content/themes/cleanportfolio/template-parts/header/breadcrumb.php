<?php
/**
 * Displays Jetpack Breadcrumb
 *
 * @package Clean_Portfolio
 */

$enable_breadcrumb = get_theme_mod( 'cleanportfolio_breadcrumb_option', 1 );

if ( $enable_breadcrumb ) :
	cleanportfolio_breadcrumb();
endif; ?>
