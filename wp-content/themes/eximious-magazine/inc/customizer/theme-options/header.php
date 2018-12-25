<?php
$wp_customize->add_section(
    'header_options' ,
    array(
        'title' => __( 'Header Options', 'eximious-magazine' ),
        'panel' => 'theme_option_panel',
    )
);

/*Enable Top Bar*/
$wp_customize->add_setting(
    'theme_options[enable_top_bar]',
    array(
        'default'           => $default_options['enable_top_bar'],
        'sanitize_callback' => 'eximious_magazine_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[enable_top_bar]',
    array(
        'label'    => __( 'Enable Top Bar', 'eximious-magazine' ),
        'section'  => 'header_options',
        'type'     => 'checkbox',
    )
);

/*Enable Top Nav*/
$wp_customize->add_setting(
    'theme_options[enable_top_nav]',
    array(
        'default'           => $default_options['enable_top_nav'],
        'sanitize_callback' => 'eximious_magazine_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[enable_top_nav]',
    array(
        'label'    => __( 'Show Top Nav Menu', 'eximious-magazine' ),
        'description' => sprintf( __( 'You can add/edit top nav menu from <a href="%s">here</a>.', 'eximious-magazine' ), "javascript:wp.customize.control( 'nav_menu_locations[top-menu]' ).focus();" ),
        'section'  => 'header_options',
        'type'     => 'checkbox',
        'active_callback' => 'eximious_magazine_is_top_bar_enabled',
    )
);

/*Enable Social Nav*/
$wp_customize->add_setting(
    'theme_options[enable_social_nav]',
    array(
        'default'           => $default_options['enable_social_nav'],
        'sanitize_callback' => 'eximious_magazine_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[enable_social_nav]',
    array(
        'label'    => __( 'Show Social Nav Menu', 'eximious-magazine' ),
        'description' => sprintf( __( 'You can add/edit social nav menu from <a href="%s">here</a>.', 'eximious-magazine' ), "javascript:wp.customize.control( 'nav_menu_locations[social-menu]' ).focus();" ),
        'section'  => 'header_options',
        'type'     => 'checkbox',
        'active_callback' => 'eximious_magazine_is_top_bar_enabled',
    )
);

/*Show Ad Banner*/
$wp_customize->add_setting(
    'theme_options[show_ad_banner]',
    array(
        'default'           => $default_options['show_ad_banner'],
        'sanitize_callback' => 'eximious_magazine_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[show_ad_banner]',
    array(
        'label'    => __( 'Show Ad Banner', 'eximious-magazine' ),
        'section'  => 'header_options',
        'type'     => 'checkbox',
    )
);

/*Ad Banner Image*/
$wp_customize->add_setting(
    'theme_options[ad_banner_image]',
    array(
        'default'           => $default_options['ad_banner_image'],
        'sanitize_callback' => 'eximious_magazine_sanitize_image',
    )
);
$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'theme_options[ad_banner_image]',
        array(
            'label'           => __( 'Ad Banner Image', 'eximious-magazine' ),
            'description'	  => sprintf( esc_html__( 'Recommended Size %1$s px X %2$s px', 'eximious-magazine' ), 750, 90 ),
            'section'         => 'header_options',
            'active_callback' => 'eximious_magazine_is_ad_banner_enabled',
        )
    )
);

/*Ad Banner Link.*/
$wp_customize->add_setting(
    'theme_options[ad_banner_link]',
    array(
        'default'           => $default_options['ad_banner_link'],
        'sanitize_callback' => 'esc_url_raw'
    )
);
$wp_customize->add_control(
    'theme_options[ad_banner_link]',
    array(
        'label'    => __( 'Ad Banner Link', 'eximious-magazine' ),
        'section'  => 'header_options',
        'type'     => 'text',
        'description'     => __('Leave empty if you don\'t want the image to have a link', 'eximious-magazine'),
        'active_callback' => 'eximious_magazine_is_ad_banner_enabled',
    )
);

/*Enable Search on Header Area*/
$wp_customize->add_setting(
    'theme_options[enable_search]',
    array(
        'default'           => $default_options['enable_search'],
        'sanitize_callback' => 'eximious_magazine_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[enable_search]',
    array(
        'label'    => __( 'Enable Search Form on Header', 'eximious-magazine' ),
        'section'  => 'header_options',
        'type'     => 'checkbox',
    )
);