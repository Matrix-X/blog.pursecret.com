<?php

$widgets_link = admin_url( 'widgets.php' );

$wp_customize->add_section(
    'footer_options' ,
    array(
        'title' => __( 'Footer Options', 'blog-elite' ),
        'panel' => 'theme_option_panel',
    )
);

/*Option to choose footer column layout*/
$wp_customize->add_setting(
    'theme_options[footer_column_layout]',
    array(
        'default'           => $default_options['footer_column_layout'],
        'sanitize_callback' => 'blog_elite_sanitize_radio',
    )
);
$wp_customize->add_control(
    new Blog_Elite_Radio_Image_Control(
        $wp_customize,
        'theme_options[footer_column_layout]',
        array(
            'label'       => __( 'Footer Column Layout', 'blog-elite' ),
            'description' => sprintf( __( 'Footer widgetareas used will vary based on the footer column layout chosen. Head over to  <a href="%s" target="_blank">widgets</a> to see which footer widgetareas are used if you change the layout.', 'blog-elite' ), $widgets_link ),
            'section'     => 'footer_options',
            'choices' => blog_elite_get_footer_layouts()
        )
    )
);
/**/

/* Footer widget heading style */
$wp_customize->add_setting(
    'theme_options[footer_widget_heading_style]',
    array(
        'default'           => $default_options['footer_widget_heading_style'],
        'sanitize_callback' => 'blog_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[footer_widget_heading_style]',
    array(
        'label'       => __( 'Footer Widget Heading Style', 'blog-elite' ),
        'section'     => 'footer_options',
        'type'        => 'select',
        'choices'     => array(
            'style_1' => __('Style 1', 'blog-elite'),
            'style_2' => __('Style 2', 'blog-elite'),
        ),
    )
);

/* Footer widget heading Align */
$wp_customize->add_setting(
    'theme_options[footer_widget_heading_align]',
    array(
        'default'           => $default_options['footer_widget_heading_align'],
        'sanitize_callback' => 'blog_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[footer_widget_heading_align]',
    array(
        'label'       => __( 'Footer Widget Heading Align', 'blog-elite' ),
        'section'     => 'footer_options',
        'type'        => 'select',
        'choices'     => array(
            'left' => __('Left', 'blog-elite'),
            'center' => __('Center', 'blog-elite'),
            'right' => __('Right', 'blog-elite'),
        ),
    )
);

/*Sub Footer Background Image*/
$wp_customize->add_setting(
    'theme_options[sub_footer_bg_image]',
    array(
        'default'           => $default_options['sub_footer_bg_image'],
        'sanitize_callback' => 'blog_elite_sanitize_image',
    )
);
$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'theme_options[sub_footer_bg_image]',
        array(
            'label'           => __( 'Sub Footer Background Image', 'blog-elite' ),
            'section'         => 'footer_options',
        )
    )
);

/*Footer Logo*/
$wp_customize->add_setting(
    'theme_options[footer_logo]',
    array(
        'default'           => $default_options['footer_logo'],
        'sanitize_callback' => 'blog_elite_sanitize_image',
    )
);
$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'theme_options[footer_logo]',
        array(
            'label'           => __( 'Sub Footer Logo', 'blog-elite' ),
            'section'         => 'footer_options',
        )
    )
);

/*Footer Logo Link.*/
$wp_customize->add_setting(
    'theme_options[footer_logo_link]',
    array(
        'default'           => $default_options['footer_logo_link'],
        'sanitize_callback' => 'esc_url_raw'
    )
);
$wp_customize->add_control(
    'theme_options[footer_logo_link]',
    array(
        'label'    => __( 'Footer Logo Link', 'blog-elite' ),
        'section'  => 'footer_options',
        'type'     => 'text',
        'description'     => __('Leave empty if you don\'t want the image to have a link', 'blog-elite'),
    )
);

/*Enable Sub Footer Logo Link in New Tab*/
$wp_customize->add_setting(
    'theme_options[footer_logo_link_new_tab]',
    array(
        'default'           => $default_options['footer_logo_link_new_tab'],
        'sanitize_callback' => 'blog_elite_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[footer_logo_link_new_tab]',
    array(
        'label'    => __( 'Open footer logo link in new tab', 'blog-elite' ),
        'section'  => 'footer_options',
        'type'     => 'checkbox',
    )
);

/*Enable Footer Nav*/
$wp_customize->add_setting(
    'theme_options[enable_footer_nav]',
    array(
        'default'           => $default_options['enable_footer_nav'],
        'sanitize_callback' => 'blog_elite_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[enable_footer_nav]',
    array(
        'label'    => __( 'Show Footer Nav Menu', 'blog-elite' ),
        'description' => sprintf( __( 'You can add/edit footer nav menu from <a href="%s">here</a>.', 'blog-elite' ), "javascript:wp.customize.control( 'nav_menu_locations[footer-menu]' ).focus();" ),
        'section'  => 'footer_options',
        'type'     => 'checkbox',
    )
);

/*Copyright Text.*/
$wp_customize->add_setting(
    'theme_options[copyright_text]',
    array(
        'default'           => $default_options['copyright_text'],
        'sanitize_callback' => 'sanitize_text_field',
        'transport'           => 'postMessage',
    )
);
$wp_customize->add_control(
    'theme_options[copyright_text]',
    array(
        'label'    => __( 'Copyright Text', 'blog-elite' ),
        'section'  => 'footer_options',
        'type'     => 'text',
    )
);