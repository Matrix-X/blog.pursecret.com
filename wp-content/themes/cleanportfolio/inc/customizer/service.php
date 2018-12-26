<?php
/**
* The template for adding Service Settings in Customizer
*
 * @package Clean_Portfolio
*/

function cleanportfolio_service_options( $wp_customize ) {
	// Add note to Jetpack Portfolio Section
    cleanportfolio_register_option( $wp_customize, array(
            'name'              => 'cleanportfolio_ect_service_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'CleanportfolioNoteControl',
            'label'             => sprintf( esc_html__( 'For Service Options for this Theme, go %1$shere%2$s', 'cleanportfolio' ),
                 '<a href="javascript:wp.customize.section( \'cleanportfolio_service\' ).focus();">',
                 '</a>'
            ),
            'section'           => 'ect_service',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

	$wp_customize->add_section( 'cleanportfolio_service', array(
			'panel'    => 'cleanportfolio_theme_options',
			'title'    => esc_html__( 'Service', 'cleanportfolio' ),
		)
	);

	cleanportfolio_register_option( $wp_customize, array(
            'name'              => 'cleanportfolio_service_note_1',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'CleanportfolioNoteControl',
			'active_callback'   => 'cleanportfolio_is_ect_service_inactive',
            'label'             => sprintf( esc_html__( 'For Services, install %1$sEssential Content Types%2$s Plugin with Service Content Type Enabled', 'cleanportfolio' ),
                '<a target="_blank" href="https://wordpress.org/plugins/essential-content-types/">',
                '</a>'
            ),
            'section'           => 'cleanportfolio_service',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

	cleanportfolio_register_option( $wp_customize, array(
			'name'              => 'cleanportfolio_service_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'cleanportfolio_sanitize_select',
			'active_callback'   => 'cleanportfolio_is_ect_service_active',
			'choices'           => cleanportfolio_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'cleanportfolio' ),
			'section'           => 'cleanportfolio_service',
			'type'              => 'select',
		)
	);

	cleanportfolio_register_option( $wp_customize, array(
            'name'              => 'cleanportfolio_service_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'CleanportfolioNoteControl',
            'active_callback'   => 'cleanportfolio_is_service_active',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
			'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'cleanportfolio' ),
                 '<a href="javascript:wp.customize.control( \'ect_service_title\' ).focus();">',
                 '</a>'
            ),
            'section'           => 'cleanportfolio_service',
            'type'              => 'description',
        )
    );

	cleanportfolio_register_option( $wp_customize, array(
			'name'              => 'cleanportfolio_service_number',
			'default'           => 3,
			'sanitize_callback' => 'cleanportfolio_sanitize_number_range',
			'active_callback'   => 'cleanportfolio_is_service_active',
			'description'       => esc_html__( 'Save and refresh the page if No. of Service is changed', 'cleanportfolio' ),
			'input_attrs'       => array(
				'style' => 'width: 45px;',
				'min'   => 0,
			),
			'label'             => esc_html__( 'No of Service', 'cleanportfolio' ),
			'section'           => 'cleanportfolio_service',
			'type'              => 'number',
		)
	);

	$number = get_theme_mod( 'cleanportfolio_service_number', '3' );

	for ( $i = 1; $i <= $number ; $i++ ) {
		cleanportfolio_register_option( $wp_customize, array(
				'name'              => 'cleanportfolio_service_cpt_' . $i,
				'sanitize_callback' => 'cleanportfolio_sanitize_post',
				'default'           => 0,
				'active_callback'   => 'cleanportfolio_is_service_active',
				'label'             => esc_html__( 'Service ', 'cleanportfolio' ) . ' ' . $i ,
				'section'           => 'cleanportfolio_service',
				'type'              => 'select',
				'choices'           => cleanportfolio_generate_post_array( 'ect-service' ),
			)
		);
	} // End for().
}
add_action( 'customize_register', 'cleanportfolio_service_options' );

if ( ! function_exists( 'cleanportfolio_is_service_active' ) ) :
	/**
	* Return true if service is active
	*
	* @since Clean Portfolio 1.0
	*/
	function cleanportfolio_is_service_active( $control ) {
		$enable = $control->manager->get_setting( 'cleanportfolio_service_option' )->value();

		//return true only if previwed page on customizer matches the type of content option selected
		return ( cleanportfolio_check_section( $enable ) && ( class_exists( 'Essential_Content_Service' ) || class_exists( 'Essential_Content_Pro_Service' ) ) );
	}
endif;

if ( ! function_exists( 'cleanportfolio_is_ect_service_active' ) ) :
    /**
    * Return true if testimonial is active
    *
    * @since Clean Portfolio 1.0
    */
    function cleanportfolio_is_ect_service_active( $control ) {
        return ( class_exists( 'Essential_Content_Service' ) || class_exists( 'Essential_Content_Pro_Service' ) );
    }
endif;

if ( ! function_exists( 'cleanportfolio_is_ect_service_inactive' ) ) :
    /**
    * Return true if testimonial is active
    *
    * @since Clean Portfolio 1.0
    */
    function cleanportfolio_is_ect_service_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Service' ) || class_exists( 'Essential_Content_Pro_Service' ) );
    }
endif;
