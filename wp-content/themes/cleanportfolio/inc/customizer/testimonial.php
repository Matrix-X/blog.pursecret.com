<?php
/**
 * Add Testimonial Settings in Customizer
 *
 * @package Clean_Portfolio
*/

/**
 * Add testimonial options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function cleanportfolio_testimonial_options( $wp_customize ) {
    // Add note to Jetpack Testimonial Section
    cleanportfolio_register_option( $wp_customize, array(
            'name'              => 'cleanportfolio_jetpack_testimonial_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'CleanportfolioNoteControl',
            'label'             => sprintf( esc_html__( 'For Testimonial Options for this Theme, go %1$shere%2$s', 'cleanportfolio' ),
                '<a href="javascript:wp.customize.section( \'cleanportfolio_testimonials\' ).focus();">',
                 '</a>'
            ),
           'section'            => 'jetpack_testimonials',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

    $wp_customize->add_section( 'cleanportfolio_testimonials', array(
            'panel'    => 'cleanportfolio_theme_options',
            'title'    => esc_html__( 'Testimonials', 'cleanportfolio' ),
        )
    );

    cleanportfolio_register_option( $wp_customize, array(
            'name'              => 'cleanportfolio_testimonial_note_1',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'CleanportfolioNoteControl',
            'active_callback'   => 'cleanportfolio_is_ect_testimonial_inactive',
            'label'             => sprintf( esc_html__( 'For Testimonial, install %1$sEssential Content Types%2$s Plugin with Testimonial Content Type Enabled', 'cleanportfolio' ),
                '<a target="_blank" href="https://wordpress.org/plugins/essential-content-types/">',
                '</a>'
            ),
            'section'           => 'cleanportfolio_testimonials',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

    cleanportfolio_register_option( $wp_customize, array(
            'name'              => 'cleanportfolio_testimonial_option',
            'default'           => 'disabled',
            'sanitize_callback' => 'cleanportfolio_sanitize_select',
            'active_callback'   => 'cleanportfolio_is_ect_testimonial_active',
            'choices'           => cleanportfolio_section_visibility_options(),
            'label'             => esc_html__( 'Enable on', 'cleanportfolio' ),
            'section'           => 'cleanportfolio_testimonials',
            'type'              => 'select',
            'priority'          => 1,
        )
    );

    cleanportfolio_register_option( $wp_customize, array(
            'name'              => 'cleanportfolio_testimonial_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'CleanportfolioNoteControl',
            'active_callback'   => 'cleanportfolio_is_testimonial_active',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
			'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'cleanportfolio' ),
                '<a href="javascript:wp.customize.section( \'jetpack_testimonials\' ).focus();">',
                '</a>'
            ),
            'section'           => 'cleanportfolio_testimonials',
            'type'              => 'description',
        )
    );

    cleanportfolio_register_option( $wp_customize, array(
            'name'              => 'cleanportfolio_testimonial_number',
            'default'           => '3',
            'sanitize_callback' => 'cleanportfolio_sanitize_number_range',
            'active_callback'   => 'cleanportfolio_is_testimonial_active',
            'label'             => esc_html__( 'Number of items to show', 'cleanportfolio' ),
            'section'           => 'cleanportfolio_testimonials',
            'type'              => 'number',
            'input_attrs'       => array(
                'style'             => 'width: 100px;',
                'min'               => 0,
            ),
        )
    );

    $number = get_theme_mod( 'cleanportfolio_testimonial_number', 3 );

    for ( $i = 1; $i <= $number ; $i++ ) {
        //for CPT
        cleanportfolio_register_option( $wp_customize, array(
                'name'              => 'cleanportfolio_testimonial_cpt_' . $i,
                'sanitize_callback' => 'cleanportfolio_sanitize_post',
                'active_callback'   => 'cleanportfolio_is_testimonial_active',
                'label'             => esc_html__( 'Testimoial', 'cleanportfolio' ) . ' ' . $i ,
                'section'           => 'cleanportfolio_testimonials',
                'type'              => 'select',
                'choices'           => cleanportfolio_generate_post_array( 'jetpack-testimonial' ),
            )
        );
    } // End for().
}
add_action( 'customize_register', 'cleanportfolio_testimonial_options' );

/**
 * Active Callback Functions
 */
if ( ! function_exists( 'cleanportfolio_is_testimonial_active' ) ) :
    /**
    * Return true if testimonial is active
    *
    * @since Clean Portfolio 1.0
    */
    function cleanportfolio_is_testimonial_active( $control ) {
        $enable = $control->manager->get_setting( 'cleanportfolio_testimonial_option' )->value();

        //return true only if previwed page on customizer matches the type of content option selected
        return ( cleanportfolio_check_section( $enable ) && ( class_exists( 'Essential_Content_Jetpack_Testimonial' ) || class_exists( 'JetPack' ) || class_exists( 'Essential_Content_Pro_Jetpack_Testimonial' ) ) );
    }
endif;

if ( ! function_exists( 'cleanportfolio_is_ect_testimonial_active' ) ) :
    /**
    * Return true if testimonial is active
    *
    * @since Clean Portfolio 1.0
    */
    function cleanportfolio_is_ect_testimonial_active( $control ) {
        return ( class_exists( 'Essential_Content_Jetpack_Testimonial' ) || class_exists( 'JetPack' ) || class_exists( 'Essential_Content_Pro_Jetpack_Testimonial' ) );
    }
endif;

if ( ! function_exists( 'cleanportfolio_is_ect_testimonial_inactive' ) ) :
    /**
    * Return true if testimonial is active
    *
    * @since Clean Portfolio 1.0
    */
    function cleanportfolio_is_ect_testimonial_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Jetpack_Testimonial' ) || class_exists( 'JetPack' ) || class_exists( 'Essential_Content_Pro_Jetpack_Testimonial' ) );
    }
endif;

