<?php
/**
* Add Featured Content options
*
* @package Clean_Portfolio
*/

/**
 * Add featured content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function cleanportfolio_featured_content_options( $wp_customize ) {
	// Add note to ECT Featured Content Section
	cleanportfolio_register_option( $wp_customize, array(
			'name'              => 'cleanportfolio_featured_content_jetpack_note',
			'sanitize_callback' => 'sanitize_text_field',
			'custom_control'    => 'CleanportfolioNoteControl',
			'label'             => sprintf( esc_html__( 'For all Featured Content Options for this Theme, go %1$shere%2$s', 'cleanportfolio' ),
				'<a href="javascript:wp.customize.section( \'cleanportfolio_featured_content\' ).focus();">',
				'</a>'
			),
			'section'           => 'ect_featured_content',
			'type'              => 'description',
			'priority'          => 1,
		)
	);

	$wp_customize->add_section( 'cleanportfolio_featured_content', array(
			'title' => esc_html__( 'Featured Content', 'cleanportfolio' ),
			'panel' => 'cleanportfolio_theme_options',
		)
	);

	cleanportfolio_register_option( $wp_customize, array(
            'name'              => 'cleanportfolio_featured_content_note_1',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'CleanportfolioNoteControl',
            'active_callback'   => 'cleanportfolio_is_ect_featured_content_inactive',
            'label'             => sprintf( esc_html__( 'For Featured Content, install %1$sEssential Content Types%2$s Plugin with Testimonial Content Type Enabled', 'cleanportfolio' ),
                '<a target="_blank" href="https://wordpress.org/plugins/essential-content-types/">',
                '</a>'
            ),
            'section'           => 'cleanportfolio_featured_content',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

	cleanportfolio_register_option( $wp_customize, array(
			'name'              => 'cleanportfolio_featured_content_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'cleanportfolio_sanitize_select',
			'active_callback'   => 'cleanportfolio_is_ect_featured_content_active',
			'choices'           => cleanportfolio_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'cleanportfolio' ),
			'section'           => 'cleanportfolio_featured_content',
			'type'              => 'select',
		)
	);

	cleanportfolio_register_option( $wp_customize, array(
			'name'              => 'cleanportfolio_featured_content_cpt_note',
			'sanitize_callback' => 'sanitize_text_field',
			'custom_control'    => 'CleanportfolioNoteControl',
			'active_callback'   => 'cleanportfolio_is_featured_content_active',
			/* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
			'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'cleanportfolio' ),
				 '<a href="javascript:wp.customize.control( \'featured_content_title\' ).focus();">',
				 '</a>'
			),
			'section'           => 'cleanportfolio_featured_content',
			'type'              => 'description',
		)
	);

	cleanportfolio_register_option( $wp_customize, array(
			'name'              => 'cleanportfolio_featured_content_number',
			'default'           => 3,
			'sanitize_callback' => 'cleanportfolio_sanitize_number_range',
			'active_callback'   => 'cleanportfolio_is_featured_content_active',
			'description'       => esc_html__( 'Save and refresh the page if No. of Featured Content is changed (Max no of Featured Content is 20)', 'cleanportfolio' ),
			'input_attrs'       => array(
				'style' => 'width: 100px;',
				'min'   => 0,
				'max'   => 20,
				'step'  => 1,
			),
			'label'             => esc_html__( 'No of Featured Content', 'cleanportfolio' ),
			'section'           => 'cleanportfolio_featured_content',
			'type'              => 'number',
			'transport'         => 'postMessage'
		)
	);

	$number = get_theme_mod( 'cleanportfolio_featured_content_number', 3 );

	//loop for featured post content
	for ( $i=1; $i <=  $number ; $i++ ) {
		cleanportfolio_register_option( $wp_customize, array(
				'name'              => 'cleanportfolio_featured_content_cpt_' . $i,
				'sanitize_callback' => 'cleanportfolio_sanitize_post',
				'active_callback'   => 'cleanportfolio_is_featured_content_active',
				'label'             => esc_html__( 'Featured Content', 'cleanportfolio' ) . ' ' . $i ,
				'section'           => 'cleanportfolio_featured_content',
				'type'              => 'select',
				'choices'           => cleanportfolio_generate_post_array( 'featured-content' ),
			)
		);
	}
}
add_action( 'customize_register', 'cleanportfolio_featured_content_options' );

/** Active Callback Functions **/
if( ! function_exists( 'cleanportfolio_is_featured_content_active' ) ) :
	/**
	* Return true if featured content is active
	*
	* @since Clean Portfolio 0.1
	*/
	function cleanportfolio_is_featured_content_active( $control ) {
		 $enable = $control->manager->get_setting( 'cleanportfolio_featured_content_option' )->value();

        //return true only if previwed page on customizer matches the type of content option selected
        return ( cleanportfolio_check_section( $enable ) && ( class_exists( 'Essential_Content_Featured_Content' ) || class_exists( 'Essential_Content_Pro_Featured_Content' ) ) );
	}
endif;

if ( ! function_exists( 'cleanportfolio_is_ect_featured_content_active' ) ) :
    /**
    * Return true if featured_content is active
    *
    * @since Clean Portfolio 1.0
    */
    function cleanportfolio_is_ect_featured_content_active( $control ) {
        return ( class_exists( 'Essential_Content_Featured_Content' ) || class_exists( 'Essential_Content_Pro_Featured_Content' ) );
    }
endif;

if ( ! function_exists( 'cleanportfolio_is_ect_featured_content_inactive' ) ) :
    /**
    * Return true if featured_content is active
    *
    * @since Clean Portfolio 1.0
    */
    function cleanportfolio_is_ect_featured_content_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Featured_Content' ) || class_exists( 'Essential_Content_Pro_Featured_Content' ) );
    }
endif;
