<?php
/**
 * Add Portfolio Settings in Customizer
 *
 * @package Clean_Portfolio
 */

/**
 * Add portfolio options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function cleanportfolio_portfolio_options( $wp_customize ) {
    // Add note to Jetpack Portfolio Section
    cleanportfolio_register_option( $wp_customize, array(
            'name'              => 'cleanportfolio_jetpack_portfolio_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'CleanportfolioNoteControl',
            'label'             => sprintf( esc_html__( 'For Portfolio Options for this Theme, go %1$shere%2$s', 'cleanportfolio' ),
                 '<a href="javascript:wp.customize.section( \'cleanportfolio_portfolio\' ).focus();">',
                 '</a>'
            ),
            'section'           => 'jetpack_portfolio',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

	$wp_customize->add_section( 'cleanportfolio_portfolio', array(
            'panel' => 'cleanportfolio_theme_options',
            'title' => esc_html__( 'Portfolio', 'cleanportfolio' ),
        )
    );

    cleanportfolio_register_option( $wp_customize, array(
            'name'              => 'cleanportfolio_portfolio_note_1',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'CleanportfolioNoteControl',
            'active_callback'   => 'cleanportfolio_is_ect_portfolio_inactive',
            'label'             => sprintf( esc_html__( 'For Portfolio, install %1$sEssential Content Types%2$s Plugin with Portfolio Content Type Enabled', 'cleanportfolio' ),
                '<a target="_blank" href="https://wordpress.org/plugins/essential-content-types/">',
                '</a>'
            ),
            'section'           => 'cleanportfolio_portfolio',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

    cleanportfolio_register_option( $wp_customize, array(
			'name'              => 'cleanportfolio_portfolio_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'cleanportfolio_sanitize_select',
            'active_callback'   => 'cleanportfolio_is_ect_portfolio_active',
			'choices'           => cleanportfolio_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'cleanportfolio' ),
			'section'           => 'cleanportfolio_portfolio',
			'type'              => 'select',
		)
	);

    cleanportfolio_register_option( $wp_customize, array(
            'name'              => 'cleanportfolio_portfolio_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'CleanportfolioNoteControl',
            'active_callback'   => 'cleanportfolio_is_portfolio_active',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
			'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'cleanportfolio' ),
                 '<a href="javascript:wp.customize.control( \'jetpack_portfolio_title\' ).focus();">',
                 '</a>'
            ),
            'section'           => 'cleanportfolio_portfolio',
            'type'              => 'description',
        )
    );

    cleanportfolio_register_option( $wp_customize, array(
            'name'              => 'cleanportfolio_portfolio_number',
            'default'           => '3',
            'sanitize_callback' => 'cleanportfolio_sanitize_number_range',
            'active_callback'   => 'cleanportfolio_is_portfolio_active',
            'label'             => esc_html__( 'Number of items to show', 'cleanportfolio' ),
            'section'           => 'cleanportfolio_portfolio',
            'type'              => 'number',
            'input_attrs'       => array(
                'style'             => 'width: 100px;',
                'min'               => 0,
            ),
        )
    );

    $number = get_theme_mod( 'cleanportfolio_portfolio_number', 3 );

    for ( $i = 1; $i <= $number ; $i++ ) {
        //for CPT
        cleanportfolio_register_option( $wp_customize, array(
                'name'              => 'cleanportfolio_portfolio_cpt_' . $i,
                'sanitize_callback' => 'cleanportfolio_sanitize_post',
                'active_callback'   => 'cleanportfolio_is_portfolio_active',
                'label'             => esc_html__( 'Portfolio', 'cleanportfolio' ) . ' ' . $i ,
                'section'           => 'cleanportfolio_portfolio',
                'type'              => 'select',
                'choices'           => cleanportfolio_generate_post_array( 'jetpack-portfolio' ),
            )
        );
    } // End for().
}
add_action( 'customize_register', 'cleanportfolio_portfolio_options' );

/**
 * Active Callback Functions
 */
if ( ! function_exists( 'cleanportfolio_is_portfolio_active' ) ) :
    /**
    * Return true if portfolio is active
    *
    * @since Clean Portfolio 1.0
    */
    function cleanportfolio_is_portfolio_active( $control ) {
        $enable = $control->manager->get_setting( 'cleanportfolio_portfolio_option' )->value();

        //return true only if previwed page on customizer matches the type of content option selected
        return ( cleanportfolio_check_section( $enable ) && ( class_exists( 'Essential_Content_Jetpack_Portfolio' ) || class_exists( 'JetPack' ) || class_exists( 'Essential_Content_Pro_Jetpack_Portfolio' ) ) );
    }
endif;

/**
 * Active Callback Functions
 */
if ( ! function_exists( 'cleanportfolio_is_ect_portfolio_active' ) ) :
    /**
    * Return true if portfolio is active
    *
    * @since Clean Portfolio 1.0
    */
    function cleanportfolio_is_ect_portfolio_active( $control ) {
        return ( class_exists( 'Essential_Content_Jetpack_Portfolio' ) || class_exists( 'JetPack' ) || class_exists( 'Essential_Content_Pro_Jetpack_Portfolio' ) );
    }
endif;

if ( ! function_exists( 'cleanportfolio_is_ect_portfolio_inactive' ) ) :
    /**
    * Return true if portfolio is active
    *
    * @since Clean Portfolio 1.0
    */
    function cleanportfolio_is_ect_portfolio_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Jetpack_Portfolio' ) || class_exists( 'JetPack' ) || class_exists( 'Essential_Content_Pro_Jetpack_Portfolio' ) );
    }
endif;

