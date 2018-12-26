<?php
/**
 * Blog Elite hooks
 *
 * @package Blog_Elite
 */

/**
 * Before Site
 *
 * @see  blog_elite_preloader()
 *
 */
add_action( 'blog_elite_before_site', 'blog_elite_preloader', 10 );

/**
 * Header
 *
 * @see  blog_elite_header_start()
 * @see  blog_elite_header_content()
 * @see  blog_elite_header_end()
 *
 */
add_action( 'blog_elite_header', 'blog_elite_header_start', 10 );
add_action( 'blog_elite_header', 'blog_elite_header_content', 20 );
add_action( 'blog_elite_header', 'blog_elite_header_end', 30 );

/**
 * Before Content
 *
 * @see  blog_elite_header_widget_region()
 * @see  blog_elite_breadcrumb()
 */
add_action( 'blog_elite_before_content', 'blog_elite_header_widget_region', 10 );
add_action( 'blog_elite_before_content', 'blog_elite_breadcrumb', 20 );

/**
 * Homepage
 *
 * @see  blog_elite_home_banner()
 * @see  blog_elite_above_homepage_widget_region()
 */
add_action( 'blog_elite_home_before_widget_area', 'blog_elite_home_banner', 10 );
add_action( 'blog_elite_home_before_widget_area', 'blog_elite_above_homepage_widget_region', 20 );

add_action( 'blog_elite_home_after_widget_area', 'blog_elite_below_homepage_widget_region', 10 );

/**
 * Before Footer
 *
 * @see  blog_elite_before_footer_widget_region()
 */
add_action( 'blog_elite_before_footer', 'blog_elite_before_footer_widget_region', 10 );

/**
 * Footer
 *
 * @see  blog_elite_footer_start()
 * @see  blog_elite_footer_content()
 * @see  blog_elite_footer_end()
 */
add_action( 'blog_elite_footer', 'blog_elite_footer_start', 10 );
add_action( 'blog_elite_footer', 'blog_elite_footer_content', 20 );
add_action( 'blog_elite_footer', 'blog_elite_footer_end', 30 );

/**
 * After Footer
 *
 * @see  blog_elite_sub_footer()
 */
add_action( 'blog_elite_after_footer', 'blog_elite_sub_footer', 20 );