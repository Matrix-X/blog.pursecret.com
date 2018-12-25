<?php
/**
 * Eximious Magazine hooks
 *
 * @package Eximious_Magazine
 */

/**
 * Before Site
 *
 * @see  eximious_magazine_preloader()
 *
 */
add_action( 'eximious_magazine_before_site', 'eximious_magazine_preloader', 10 );

/**
 * Header
 *
 * @see  eximious_magazine_header_start()
 * @see  eximious_magazine_header_content()
 * @see  eximious_magazine_header_end()
 *
 */
add_action( 'eximious_magazine_header', 'eximious_magazine_header_start', 10 );
add_action( 'eximious_magazine_header', 'eximious_magazine_header_content', 20 );
add_action( 'eximious_magazine_header', 'eximious_magazine_header_end', 30 );

/**
 * Before Content
 *
 * @see  eximious_magazine_header_widget_region()
 * @see  eximious_magazine_breadcrumb()
 */
add_action( 'eximious_magazine_before_content', 'eximious_magazine_header_widget_region', 10 );
add_action( 'eximious_magazine_before_content', 'eximious_magazine_breadcrumb', 20 );

/**
 * Homepage
 *
 * @see  eximious_magazine_home_trending_items()
 * @see  eximious_magazine_home_banner_slider()
 * @see  eximious_magazine_above_homepage_widget_region()
 */
add_action( 'eximious_magazine_home_before_widget_area', 'eximious_magazine_home_trending_items', 10 );
add_action( 'eximious_magazine_home_before_widget_area', 'eximious_magazine_home_banner_slider', 20 );
add_action( 'eximious_magazine_home_before_widget_area', 'eximious_magazine_above_homepage_widget_region', 30 );

add_action( 'eximious_magazine_home_after_widget_area', 'eximious_magazine_below_homepage_widget_region', 10 );

/**
 * Before Footer
 *
 * @see  eximious_magazine_before_footer_widget_region()
 */
add_action( 'eximious_magazine_before_footer', 'eximious_magazine_before_footer_widget_region', 10 );

/**
 * Footer
 *
 * @see  eximious_magazine_footer_start()
 * @see  eximious_magazine_footer_content()
 * @see  eximious_magazine_footer_end()
 */
add_action( 'eximious_magazine_footer', 'eximious_magazine_footer_start', 10 );
add_action( 'eximious_magazine_footer', 'eximious_magazine_footer_content', 20 );
add_action( 'eximious_magazine_footer', 'eximious_magazine_footer_end', 30 );