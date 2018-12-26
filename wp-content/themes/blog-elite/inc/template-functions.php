<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Blog_Elite
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function blog_elite_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	if( is_front_page() ){
        $classes[] = 'be-home';
    }

    $site_layout = blog_elite_get_option('site_layout');
    if( 'wide' == $site_layout){
        $classes[] = 'saga-full-layout';
    }else{
        $classes[] = 'saga-boxed-layout';
    }

    $page_layout = blog_elite_get_page_layout();
    if('no-sidebar' != $page_layout && 'no-sidebar-boxed' != $page_layout){
        $classes[] = 'has-sidebar '.esc_attr($page_layout);
    }else{
        $classes[] = esc_attr($page_layout);
    }

	return $classes;
}
add_filter( 'body_class', 'blog_elite_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function blog_elite_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'blog_elite_pingback_header' );
