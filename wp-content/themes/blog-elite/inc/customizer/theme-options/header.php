<?php
/*Header Options*/
$wp_customize->add_section(
    'header_options' ,
    array(
        'title' => __( 'Header Options', 'blog-elite' ),
        'panel' => 'theme_option_panel',
    )
);

/* Header Style */
$wp_customize->add_setting(
    'theme_options[header_style]',
    array(
        'default'           => $default_options['header_style'],
        'sanitize_callback' => 'blog_elite_sanitize_radio',
    )
);
$wp_customize->add_control(
    new Blog_Elite_Radio_Image_Control(
        $wp_customize,
        'theme_options[header_style]',
        array(
            'label'    => __( 'Header Style', 'blog-elite' ),
            'section'  => 'header_options',
            'choices' => blog_elite_get_header_layouts()
        )
    )
);

/*============Add ad banner image option to required header styles=====*/

/*Ad Banner Image*/
$wp_customize->add_setting(
    'theme_options[ad_banner_image]',
    array(
        'default'           => $default_options['ad_banner_image'],
        'sanitize_callback' => 'blog_elite_sanitize_image',
    )
);
$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'theme_options[ad_banner_image]',
        array(
            'label'           => __( 'Ad Banner Image', 'blog-elite' ),
            'description'	  => sprintf( esc_html__( 'Recommended Size %1$s px X %2$s px', 'blog-elite' ), 750, 90 ),
            'section'         => 'header_options',
            'active_callback' => 'blog_elite_is_ad_banner_enabled',
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
        'label'    => __( 'Ad Banner Link', 'blog-elite' ),
        'section'  => 'header_options',
        'type'     => 'text',
        'description'     => __('Leave empty if you don\'t want the image to have a link', 'blog-elite'),
        'active_callback' => 'blog_elite_is_ad_banner_enabled',
    )
);
/*============== Ad banner Close ==================*/

/*Enable Search on Header Area*/
$wp_customize->add_setting(
    'theme_options[enable_search_on_header]',
    array(
        'default'           => $default_options['enable_search_on_header'],
        'sanitize_callback' => 'blog_elite_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[enable_search_on_header]',
    array(
        'label'    => __( 'Enable Search on Header', 'blog-elite' ),
        'section'  => 'header_options',
        'type'     => 'checkbox',
    )
);