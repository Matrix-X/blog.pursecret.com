<?php

/**
 * Function to register control and setting
 */
function cleanportfolio_register_option( $wp_customize, $option ) {

    // Initialize Setting.
    $wp_customize->add_setting( $option['name'], array(
        'sanitize_callback'    => $option['sanitize_callback'],
        'default'              => isset( $option['default'] ) ? $option['default'] : '',
        'transport'            => isset( $option['transport'] ) ? $option['transport'] : 'refresh',
        'theme_supports'       => isset( $option['theme_supports'] ) ? $option['theme_supports'] : '',
    ) );

    $control = array(
        'label'    => $option['label'],
        'section'  => $option['section'],
        'settings' => $option['name'],
    );

    if ( isset( $option['active_callback'] ) ) {
        $control['active_callback'] = $option['active_callback'];
    }

    if ( isset( $option['priority'] ) ) {
        $control['priority'] = $option['priority'];
    }

    if ( isset( $option['choices'] ) ) {
        $control['choices'] = $option['choices'];
    }

    if ( isset( $option['type'] ) ) {
        $control['type'] = $option['type'];
    }

    if ( isset( $option['input_attrs'] ) ) {
        $control['input_attrs'] = $option['input_attrs'];
    }

    if ( isset( $option['description'] ) ) {
        $control['description'] = $option['description'];
    }

    if ( isset( $option['custom_control'] ) ) {
        $wp_customize->add_control( new $option['custom_control']( $wp_customize, $option['name'], $control ) );
    } else {
        $wp_customize->add_control( $option['name'], $control );
    }
}

/**
 * Function to reset date with respect to condition
 */
function cleanportfolio_reset_data() {
    if ( get_theme_mod( 'cleanportfolio_reset_all_settings' ) ) {
        remove_theme_mods();

        return;
    }
}
add_action( 'customize_save_after', 'cleanportfolio_reset_data' );

function cleanportfolio_sort_sections_list( $wp_customize ) {
    foreach ( $wp_customize->sections() as $section_key => $section_object ) {
        if ( false !== strpos( $section_key, 'cleanportfolio_') && 'cleanportfolio_reset_all' != $section_key && 'cleanportfolio_important_links' != $section_key ) {
            $options[] = $section_key;
        }
    }

    sort( $options );

    $priority = 1;
    foreach ( $options as  $option ) {
        $wp_customize->get_section( $option )->priority = $priority++;
    }
}
add_action( 'customize_register', 'cleanportfolio_sort_sections_list', 100 );

/**
 * Returns an array of visibility options for featured sections
 *
 * @since Clean Portfolio 0.1
 */
function cleanportfolio_section_visibility_options() {
    $options = array(
        'homepage'    => esc_html__( 'Homepage / Frontpage', 'cleanportfolio' ),
        'entire-site' => esc_html__( 'Entire Site', 'cleanportfolio' ),
        'disabled'    => esc_html__( 'Disabled', 'cleanportfolio' ),
    );

    return apply_filters( 'cleanportfolio_section_visibility_options', $options );
}

/**
 * Returns an array of section types
 *
 * @since Clean Portfolio 0.1
 */
function cleanportfolio_section_type_options() {
    $options = array(
        'demo'     => esc_html__( 'Demo', 'cleanportfolio' ),
        'page'     => esc_html__( 'Page', 'cleanportfolio' ),
    );

    return apply_filters( 'cleanportfolio_section_type_options', $options );
}

/**
 * Returns an array of color schemes registered
 *
 * @since Clean Portfolio 0.1
 */
function cleanportfolio_get_pagination_types() {
    $pagination_types = array(
        'default'         => esc_html__( 'Default(Older Posts/Newer Posts)', 'cleanportfolio' ),
        'numeric'         => esc_html__( 'Numeric', 'cleanportfolio' ),
        'infinite-scroll' => esc_html__( 'Infinite Scroll', 'cleanportfolio' ),
    );

    return apply_filters( 'cleanportfolio_get_pagination_types', $pagination_types );
}

/**
 * Returns an array of featured content show registered
 *
 * @since Clean Portfolio 0.1
 */
function cleanportfolio_content_show() {
    $options = array(
        'excerpt'      => esc_html__( 'Show Excerpt', 'cleanportfolio' ),
        'full-content' => esc_html__( 'Show Full Content', 'cleanportfolio' ),
        'hide-content' => esc_html__( 'Hide Content', 'cleanportfolio' ),
    );

    return apply_filters( 'cleanportfolio_content_show', $options );
}

/**
 * Returns an array of featured content show
 *
 * @since Clean Portfolio 0.1
 */
function cleanportfolio_meta_show() {
    $options = array(
        'show-meta' => esc_html__( 'Show Meta', 'cleanportfolio' ),
        'hide-meta' => esc_html__( 'Hide Meta', 'cleanportfolio' ),
    );
    return apply_filters( 'cleanportfolio_content_show', $options );
}

/**
 * Generate a list of all available post array
 *
 * @param  string $post_type post type.
 * @return post_array
 */
function cleanportfolio_generate_post_array( $post_type = 'post' ) {
    $output = array();
    $posts = get_posts( array(
        'post_type'        => $post_type,
        'post_status'      => 'publish',
        'suppress_filters' => false,
        'posts_per_page'   => -1,
        )
    );

    $output['0']= esc_html__( '-- Select --', 'cleanportfolio' );

    foreach ( $posts as $post ) {
        /* translators: 1: post id. */
		$output[ $post->ID ] = ! empty( $post->post_title ) ? $post->post_title : sprintf( __( '#%d (no title)', 'cleanportfolio' ), $post->ID );
    }

    return $output;
}
