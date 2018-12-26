<?php
/**
 * Clean Portfolio Hero Content Options
  * @package Clean_Portfolio
 */

/**
 * Add hero content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function cleanportfolio_slider_options( $wp_customize ) {
	$wp_customize->add_section( 'cleanportfolio_featured_slider', array(
			'panel' => 'cleanportfolio_theme_options',
			'title' => esc_html__( 'Featured Slider', 'cleanportfolio' ),
		)
	);

	cleanportfolio_register_option( $wp_customize, array(
			'name'              => 'cleanportfolio_slider_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'cleanportfolio_sanitize_select',
			'choices'           => cleanportfolio_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'cleanportfolio' ),
			'section'           => 'cleanportfolio_featured_slider',
			'type'              => 'select',
		)
	);

	cleanportfolio_register_option( $wp_customize, array(
			'name'              => 'cleanportfolio_slider_transition_effect',
			'default'           => 'fade',
			'sanitize_callback' => 'cleanportfolio_sanitize_select',
			'active_callback'   => 'cleanportfolio_is_slider_active',
			'choices'           => cleanportfolio_slider_transition_effects(),
			'label'             => esc_html__( 'Transition Effect', 'cleanportfolio' ),
			'section'           => 'cleanportfolio_featured_slider',
			'type'              => 'select',
		)
	);

	cleanportfolio_register_option( $wp_customize, array(
			'name'              => 'cleanportfolio_slider_transition_delay',
			'default'           => '4',
			'sanitize_callback' => 'absint',
			'active_callback'   => 'cleanportfolio_is_slider_active',
			'description'       => esc_html__( 'seconds(s)', 'cleanportfolio' ),
			'input_attrs'       => array(
				'style' => 'width: 40px;'
			),
			'label'             => esc_html__( 'Transition Delay', 'cleanportfolio' ),
			'section'           => 'cleanportfolio_featured_slider',
		)
	);

	cleanportfolio_register_option( $wp_customize, array(
            'name'              => 'cleanportfolio_slider_transition_length',
			'default'           => '1',
			'sanitize_callback' => 'absint',
			'active_callback'   => 'cleanportfolio_is_slider_active',
			'description'       => esc_html__( 'seconds(s)', 'cleanportfolio' ),
			'input_attrs'       => array(
			'style'             => 'width: 100px;'
			),
			'label'             => esc_html__( 'Transition Length', 'cleanportfolio' ),
			'section'           => 'cleanportfolio_featured_slider',
		)
	);

	cleanportfolio_register_option( $wp_customize, array(
            'name'              => 'cleanportfolio_slider_image_loader',
			'default'           => 'false',
			'sanitize_callback' => 'cleanportfolio_sanitize_select',
			'active_callback'   => 'cleanportfolio_is_slider_active',
			'choices'           => cleanportfolio_slider_image_loader(),
			'label'             => esc_html__( 'Image Loader', 'cleanportfolio' ),
			'section'           => 'cleanportfolio_featured_slider',
			'type'              => 'select',
		)
	);

	cleanportfolio_register_option( $wp_customize, array(
            'name'              => 'cleanportfolio_slider_type',
			'default'           => 'demo',
			'sanitize_callback' => 'cleanportfolio_sanitize_select',
			'active_callback'   => 'cleanportfolio_is_slider_active',
			'choices'           => cleanportfolio_section_type_options(),
			'label'             => esc_html__( 'Select Slider Type', 'cleanportfolio' ),
			'section'           => 'cleanportfolio_featured_slider',
			'type'              => 'select',
		)
	);

	cleanportfolio_register_option( $wp_customize, array(
            'name'              => 'cleanportfolio_slider_number',
			'default'           => '4',
			'sanitize_callback' => 'cleanportfolio_sanitize_number_range',
			'active_callback'   => 'cleanportfolio_is_demo_slider_inactive',
			'description'       => esc_html__( 'Save and refresh the page if No. of Slides is changed (Max no of slides is 20)', 'cleanportfolio' ),
			'input_attrs'       => array(
			'style'             => 'width: 45px;',
			'min'               => 0,
			'max'               => 20,
			'step'              => 1,
			),
			'label'             => esc_html__( 'No of Slides', 'cleanportfolio' ),
			'section'           => 'cleanportfolio_featured_slider',
			'type'              => 'number',
			'transport'         => 'postMessage'
		)
	);

	cleanportfolio_register_option( $wp_customize, array(
            'name'              => 'cleanportfolio_slider_content_show',
			'default'           => 'excerpt',
			'sanitize_callback' => 'cleanportfolio_sanitize_select',
			'active_callback'   => 'cleanportfolio_is_demo_slider_inactive',
			'choices'           => cleanportfolio_content_show(),
			'label'             => esc_html__( 'Display Content', 'cleanportfolio' ),
			'section'           => 'cleanportfolio_featured_slider',
			'type'              => 'select',
		)
	);

	$slider_number = get_theme_mod( 'cleanportfolio_slider_number', 4 );

	for ( $i=1; $i <= $slider_number ; $i++ ) {
		// Page Sliders
		cleanportfolio_register_option( $wp_customize, array(
				'name'              =>'cleanportfolio_slider_page_' . $i,
				'sanitize_callback' => 'cleanportfolio_sanitize_post',
				'active_callback'   => 'cleanportfolio_is_demo_slider_inactive',
				'label'             => esc_html__( 'Page', 'cleanportfolio' ) . ' # ' . $i,
				'section'           => 'cleanportfolio_featured_slider',
				'type'              => 'dropdown-pages',
			)
		);
	}
}
add_action( 'customize_register', 'cleanportfolio_slider_options' );

/**
 * Returns an array of feature slider transition effects
 *
 * @since Clean Portfolio 0.1
 */
function cleanportfolio_slider_transition_effects() {
	$options = array(
		'fade'       => esc_html__( 'Fade', 'cleanportfolio' ),
		'fadeout'    => esc_html__( 'Fade Out', 'cleanportfolio' ),
		'none'       => esc_html__( 'None', 'cleanportfolio' ),
		'scrollHorz' => esc_html__( 'Scroll Horizontal', 'cleanportfolio' ),
		'scrollVert' => esc_html__( 'Scroll Vertical', 'cleanportfolio' ),
		'flipHorz'   => esc_html__( 'Flip Horizontal', 'cleanportfolio' ),
		'flipVert'   => esc_html__( 'Flip Vertical', 'cleanportfolio' ),
		'tileSlide'  => esc_html__( 'Tile Slide', 'cleanportfolio' ),
		'tileBlind'  => esc_html__( 'Tile Blind', 'cleanportfolio' ),
		'shuffle'    => esc_html__( 'Shuffle', 'cleanportfolio' ),
	);

	return apply_filters( 'cleanportfolio_slider_transition_effects', $options );
}

/**
 * Returns an array of featured slider image loader options
 *
 * @since Clean Portfolio 0.1
 */
function cleanportfolio_slider_image_loader() {
	$options = array(
		'true'  => esc_html__( 'True', 'cleanportfolio' ),
		'wait'  => esc_html__( 'Wait', 'cleanportfolio' ),
		'false' => esc_html__( 'False', 'cleanportfolio' ),
	);

	return apply_filters( 'cleanportfolio_slider_image_loader', $options );
}

if( ! function_exists( 'cleanportfolio_is_slider_active' ) ) :
	/**
	* Return true if slider is active
	*
	* @since Clean Portfolio 0.1
	*/
	function cleanportfolio_is_slider_active( $control ) {
		global $wp_query;

		$page_id = $wp_query->get_queried_object_id();

		// Front page display in Reading Settings
		$page_for_posts = get_option('page_for_posts');

		$enable = $control->manager->get_setting( 'cleanportfolio_slider_option' )->value();

		//return true only if previwed page on customizer matches the type of slider option selected
		return ( 'entire-site' == $enable || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable ) );
	}
endif;


if( ! function_exists( 'cleanportfolio_is_demo_slider_inactive' ) ) :
	/**
	* Return true if demo slider is inactive
	*
	* @since Clean Portfolio 0.1
	*/
	function cleanportfolio_is_demo_slider_inactive( $control ) {
		$type = $control->manager->get_setting( 'cleanportfolio_slider_type' )->value();

		//return true only if previwed page on customizer matches the type of slider option selected and is or is not selected type
		return ( cleanportfolio_is_slider_active( $control ) && 'demo' !== $type );
	}
endif;
