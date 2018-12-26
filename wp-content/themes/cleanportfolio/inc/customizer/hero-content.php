<?php
/**
 * Clean Portfolio Pro Hero Content Options
  * @package Clean_Portfolio
 */

/**
 * Add hero content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function cleanportfolio_hero_content_options( $wp_customize ) {
	$wp_customize->add_section( 'cleanportfolio_hero_content_options', array(
			'title' => esc_html__( 'Hero Content', 'cleanportfolio' ),
			'panel' => 'cleanportfolio_theme_options'
		)
	);

	cleanportfolio_register_option( $wp_customize, array(
			'name'              => 'cleanportfolio_hero_content_visibility',
			'default'           => 'homepage',
			'sanitize_callback' => 'cleanportfolio_sanitize_select',
			'choices'           => cleanportfolio_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'cleanportfolio' ),
			'section'           => 'cleanportfolio_hero_content_options',
			'type'              => 'select',
		)
	);

	cleanportfolio_register_option( $wp_customize, array(
			'name'              => 'cleanportfolio_hero_content',
			'default'           => '0',
			'sanitize_callback' => 'cleanportfolio_sanitize_post',
			'active_callback'   => 'cleanportfolio_is_hero_content_active',
			'label'             => esc_html__( 'Page', 'cleanportfolio' ),
			'section'           => 'cleanportfolio_hero_content_options',
			'type'              => 'dropdown-pages'
		)
	);
}
add_action( 'customize_register', 'cleanportfolio_hero_content_options' );

if ( ! function_exists( 'cleanportfolio_is_hero_content_active' ) ) :
	/**
	* Return true if hero content is active
	*
	* @since Clean Portfolio 0.1
	*/
	function cleanportfolio_is_hero_content_active( $control ) {
		global $wp_query;

		$page_id = $wp_query->get_queried_object_id();

		// Front page display in Reading Settings
		$page_for_posts = get_option( 'page_for_posts' );

		$enable = $control->manager->get_setting( 'cleanportfolio_hero_content_visibility' )->value();

		//return true only if previwed page on customizer matches the type of content option selected
		return ( 'entire-site' === $enable  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable ) );
	}
endif;
