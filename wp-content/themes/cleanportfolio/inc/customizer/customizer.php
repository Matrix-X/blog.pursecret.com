<?php
/**
 * Clean Portfolio Theme Customizer
 *
  * @package Clean_Portfolio
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function cleanportfolio_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$wp_customize->get_setting( 'header_image' )->transport = 'refresh';

	// Reset all settings to default
	$wp_customize->add_section( 'cleanportfolio_reset_all', array(
			'description' => esc_html__( 'Caution: Reset all settings to default. Refresh the page after save to view full effects.', 'cleanportfolio' ),
			'title'       => esc_html__( 'Reset all settings', 'cleanportfolio' ),
			'priority'    => 998,
		)
	);

	cleanportfolio_register_option( $wp_customize, array(
			'name'              => 'cleanportfolio_reset_all_settings',
			'sanitize_callback' => 'cleanportfolio_sanitize_checkbox',
			'transport'         => 'postMessage',
			'label'             => esc_html__( 'Check to reset all settings to default', 'cleanportfolio' ),
			'section'           => 'cleanportfolio_reset_all',
			'type'              => 'checkbox',
		)
	);
	// Reset all settings to default end

	$wp_customize->add_section( 'cleanportfolio_important_links', array(
			'priority' => 999,
			'title'    => esc_html__( 'Important Links', 'cleanportfolio' ),
		)
	);

	/**
	 * Has dummy Sanitizaition function as it contains no value to be sanitized
	 */
	cleanportfolio_register_option( $wp_customize, array(
			'name'              => 'cleanportfolio_important_links',
			'sanitize_callback' => 'sanitize_text_field',
			'custom_control'    => 'CleanportfolioImportantLinks',
			'label'             => __( 'Important Links', 'cleanportfolio' ),
			'section'           => 'cleanportfolio_important_links',
			'type'              => 'cleanportfolio_important_links',
		)
	);
}
add_action( 'customize_register', 'cleanportfolio_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function cleanportfolio_customize_preview_js() {
	wp_enqueue_script( 'cleanportfolio-customizer', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/customizer.min.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'cleanportfolio_customize_preview_js' );


/**
 * Include Customizer Helper Functions
 */
require get_parent_theme_file_path( 'inc/customizer/helpers.php' );

/**
 * Include Custom Controls
 */
require get_parent_theme_file_path( 'inc/customizer/custom-controls.php' );

/**
 * Include Theme Options
 */
require get_parent_theme_file_path( 'inc/customizer/theme-options.php' );

/**
 * Include Hero Content
 */
require get_parent_theme_file_path( 'inc/customizer/hero-content.php' );

/**
 * Include Featured Slider
 */
require get_parent_theme_file_path( 'inc/customizer/featured-slider.php' );

/**
 * Include Featured Content
 */
require get_parent_theme_file_path( 'inc/customizer/featured-content.php' );

/**
 * Include Featured Content
 */
require get_parent_theme_file_path( 'inc/customizer/service.php' );

/**
 * Include Portfolio
 */
require get_parent_theme_file_path( 'inc/customizer/portfolio.php' );

/**
 * Include Testimonial
 */
require get_parent_theme_file_path( 'inc/customizer/testimonial.php' );

/**
 * Include Sanitization functions
 */
require get_parent_theme_file_path( 'inc/customizer/sanitize-functions.php' );

/**
 * Include Upgrade Button
 */
require get_parent_theme_file_path( 'inc/customizer/upgrade-button/class-customize.php' );
