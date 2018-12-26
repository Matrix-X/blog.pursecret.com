<?php
/**
 * Blog Elite Theme Customizer
 *
 * @package Blog_Elite
 */

/**
 * Customizer default values.
 */
require get_template_directory() . '/inc/customizer/defaults.php';

/*Load customizer callback.*/
require get_template_directory() . '/inc/customizer/callback.php';

/**
 * Add Theme Customizer Options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function blog_elite_customize_register( $wp_customize ) {

    /*Load custom controls for customizer.*/
    require get_template_directory() . '/inc/customizer/controls.php';

    /*Load sanitization functions.*/
    require get_template_directory() . '/inc/customizer/sanitize.php';

    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

    if ( isset( $wp_customize->selective_refresh ) ) {
        $wp_customize->selective_refresh->add_partial( 'blogname', array(
            'selector'        => '.site-title a',
            'render_callback' => 'blog_elite_customize_partial_blogname',
        ) );
        $wp_customize->selective_refresh->add_partial( 'blogdescription', array(
            'selector'        => '.site-description',
            'render_callback' => 'blog_elite_customize_partial_blogdescription',
        ) );
    }

    /*Get default values to set while building customizer elements*/
    $default_options = blog_elite_get_default_customizer_values();

    /*Get image sizes*/
    $image_sizes = blog_elite_get_all_image_sizes(true);

    /*Load customizer options.*/
    require_once get_template_directory() . '/inc/customizer/theme-options/upsell.php';
    require_once get_template_directory() . '/inc/customizer/theme-options/front-page.php';
    require_once get_template_directory() . '/inc/customizer/theme-options/top-bar.php';
    require_once get_template_directory() . '/inc/customizer/theme-options/header.php';
    require_once get_template_directory() . '/inc/customizer/theme-options/theme-options.php';
    require_once get_template_directory() . '/inc/customizer/theme-options/archive.php';
    require_once get_template_directory() . '/inc/customizer/theme-options/single-post.php';
    require_once get_template_directory() . '/inc/customizer/theme-options/footer.php';
}
add_action( 'customize_register', 'blog_elite_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function blog_elite_customize_partial_blogname() {
    bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function blog_elite_customize_partial_blogdescription() {
    bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function blog_elite_customize_preview_js() {
    wp_enqueue_script( 'blog-elite-customizer', get_template_directory_uri() . '/assets/saga/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'blog_elite_customize_preview_js' );

/**
 * Customizer control scripts and styles.
 *
 * @since 1.0.0
 */
function blog_elite_customizer_control_scripts(){
    wp_enqueue_style('blog-elite-customizer-css', get_template_directory_uri() . '/assets/saga/css/customizer.css');
    wp_enqueue_script('blog-elite-customizer-controls', get_template_directory_uri() . '/assets/saga/js/customizer-admin.js', array('customize-controls'));
}
add_action('customize_controls_enqueue_scripts', 'blog_elite_customizer_control_scripts', 0);