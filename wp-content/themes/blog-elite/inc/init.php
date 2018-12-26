<?php
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';
/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';
/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';
/**
 * Load libraries for this theme
 */
require get_template_directory() . '/lib/tgm/class-tgm-plugin-activation.php';
/**
 * Load OCDI Support.
 */
require get_template_directory() . '/inc/ocdi.php';
/**
 * Load helper functions for theme.
 */
require get_template_directory() . '/inc/helpers.php';
/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/init.php';
/**
 * Widgets and Sidebars for this theme
 */
require get_template_directory() . '/inc/widgets/init.php';
/**
 * Hooked files for this theme
 */
require get_template_directory() . '/inc/hooks/init.php';
/**
 * Load about page
 */
if ( is_admin() ) {
    require_once trailingslashit( get_template_directory() ) . 'lib/about/class.about.php';
    require_once trailingslashit( get_template_directory() ) . 'lib/about/about.php';
}

/*Posts meta fields*/
require_once trailingslashit( get_template_directory() ) . 'inc/post-meta/post-meta.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
    require get_template_directory() . '/inc/jetpack.php';
}
/**
 * Load WooCommerce compatibility file.
 */
if ( blog_elite_is_wc_active() ) {
    require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Load WP Post Author compatibility file.
 */
if ( blog_elite_is_wp_post_author_active() ) {
    require get_template_directory() . '/inc/author.php';
}