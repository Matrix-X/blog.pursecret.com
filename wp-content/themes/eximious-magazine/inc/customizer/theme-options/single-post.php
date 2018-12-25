<?php
if(eximious_magazine_is_wp_post_author_active()){
    $wp_customize->add_section(
        'single_post_options' ,
        array(
            'title' => __( 'Single Post Options', 'eximious-magazine' ),
            'panel' => 'theme_option_panel',
        )
    );
    /*Show Author Info Box*/
    $wp_customize->add_setting(
        'theme_options[enable_author_info_box]',
        array(
            'default'           => $default_options['enable_author_info_box'],
            'sanitize_callback' => 'eximious_magazine_sanitize_checkbox',
        )
    );
    $wp_customize->add_control(
        'theme_options[enable_author_info_box]',
        array(
            'label'    => __( 'Show Author Info Box', 'eximious-magazine' ),
            'section'  => 'single_post_options',
            'type'     => 'checkbox',
        )
    );

    /* Author Box Position */
    $wp_customize->add_setting(
        'theme_options[author_info_box_position]',
        array(
            'default'           => $default_options['author_info_box_position'],
            'sanitize_callback' => 'eximious_magazine_sanitize_select',
        )
    );
    $wp_customize->add_control(
        'theme_options[author_info_box_position]',
        array(
            'label'    => __( 'Info Box Position', 'eximious-magazine' ),
            'section'  => 'single_post_options',
            'type'  => 'select',
            'description' => sprintf( __( 'You can find the plugin settings on <a href="%s" target="_blank">here</a>.', 'eximious-magazine' ),  admin_url( 'admin.php?page=wp-post-author' ) ),
            'choices'     => array(
                'theme_position' => __( 'Use theme position', 'eximious-magazine'),
                'plugin_position' => __( 'Use plugin position', 'eximious-magazine' ),
            ),
            'active_callback' => 'eximious_magazine_is_author_enabled',
        )
    );
}