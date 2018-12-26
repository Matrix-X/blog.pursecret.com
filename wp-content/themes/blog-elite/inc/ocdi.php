<?php
/**
 * OCDI support.
 *
 * @package Blog_Elite
 */

/*Disable PT branding.*/
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

/**
 * OCDI files.
 *
 * @since 1.0.0
 *
 * @return array Files.
 */
function blog_elite_import_files() {
    return apply_filters( 'blog_elite_demo_files', array(
        array(
            'import_file_name'             => esc_html__( 'V1 - Default', 'blog-elite' ),
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'demo-content/v1/blog-elite.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'demo-content/v1/blog-elite.wie',
            'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'demo-content/v1/blog-elite.dat',
            'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ) . 'demo-content/images/v1.jpg',
            'preview_url'                  => 'https://demo.themesaga.com/blog-elite/',
        ),
        array(
            'import_file_name'             => esc_html__( 'V2 - Nature', 'blog-elite' ),
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'demo-content/v2/blog-elite.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'demo-content/v2/blog-elite.wie',
            'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'demo-content/v2/blog-elite.dat',
            'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ) . 'demo-content/images/v2.jpg',
            'preview_url'                  => 'https://demo.themesaga.com/blog-elite/v2',
        ),
        array(
            'import_file_name'             => esc_html__( 'V3 - Sports', 'blog-elite' ),
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'demo-content/v3/blog-elite.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'demo-content/v3/blog-elite.wie',
            'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'demo-content/v3/blog-elite.dat',
            'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ) . 'demo-content/images/v3.jpg',
            'preview_url'                  => 'https://demo.themesaga.com/blog-elite/v3',
        ),
    ));
}
add_filter( 'pt-ocdi/import_files', 'blog_elite_import_files' );

/**
 * OCDI after import.
 *
 * @since 1.0.0
 */

function blog_elite_after_import_setup() {
    // Assign front page and posts page (blog page).
    $front_page_id = null;
    $blog_page_id  = null;

    $front_page = get_page_by_title( 'Home Page' );

    if ( $front_page ) {
        if ( is_array( $front_page ) ) {
            $first_page = array_shift( $front_page );
            $front_page_id = $first_page->ID;
        } else {
            $front_page_id = $front_page->ID;
        }
    }

    $blog_page = get_page_by_title( 'Blog' );

    if ( $blog_page ) {
        if ( is_array( $blog_page ) ) {
            $first_page = array_shift( $blog_page );
            $blog_page_id = $first_page->ID;
        } else {
            $blog_page_id = $blog_page->ID;
        }
    }

    if ( $front_page_id && $blog_page_id ) {
        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $front_page_id );
        update_option( 'page_for_posts', $blog_page_id );
    }

    // Assign navigation menu locations.
    $menu_location_details = array(
        'primary-menu' => 'primary-menu',
        'footer-menu' => 'footer-menu',
        'social-menu' => 'social-menu',
    );

    if ( ! empty( $menu_location_details ) ) {
        $navigation_settings = array();
        $current_navigation_menus = wp_get_nav_menus();
        if ( ! empty( $current_navigation_menus ) && ! is_wp_error( $current_navigation_menus ) ) {
            foreach ( $current_navigation_menus as $menu ) {
                foreach ( $menu_location_details as $location => $menu_slug ) {
                    if ( $menu->slug === $menu_slug ) {
                        $navigation_settings[ $location ] = $menu->term_id;
                    }
                }
            }
        }
        set_theme_mod( 'nav_menu_locations', $navigation_settings );
    }
}
add_action( 'pt-ocdi/after_import', 'blog_elite_after_import_setup' );