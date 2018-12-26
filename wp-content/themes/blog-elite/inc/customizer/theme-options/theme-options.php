<?php

/*Add some fields to default site identity section*/

/*Site Slogan Text.*/
$wp_customize->add_setting(
    'theme_options[site_slogan_text]',
    array(
        'default'           => $default_options['site_slogan_text'],
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    'theme_options[site_slogan_text]',
    array(
        'label'    => __( 'Site Slogan Text', 'blog-elite' ),
        'description' => __( 'This text will appear beneath the site logo. Leave this empty if you don\'t want to show any text. This text is best suited with logo if you uncheck the "Display site title & tagline" setting below.', 'blog-elite' ),
        'section'  => 'title_tagline',
        'type'     => 'text',
        'priority' => 8,
    )
);
/**/

/*Site Slogan Color*/
$wp_customize->add_setting(
    'theme_options[site_slogan_color]',
    array(
        'default' => $default_options['site_slogan_color'],
        'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'theme_options[site_slogan_color]',
        array(
            'label' => __('Slogan Color', 'blog-elite'),
            'section' => 'title_tagline',
            'type' => 'color',
            'priority' => 9,
        )
    )
);
/**/

/*Site Slogan/Tagline Style.*/
$wp_customize->add_setting(
    'theme_options[site_tagline_style]',
    array(
        'default'           => $default_options['site_tagline_style'],
        'sanitize_callback' => 'blog_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[site_tagline_style]',
    array(
        'label'    => __( 'Site Slogan/Tagline Style', 'blog-elite' ),
        'section'  => 'title_tagline',
        'type'        => 'select',
        'choices'     => array(
            'style_1' => __('Style 1', 'blog-elite'),
            'style_2' => __('Style 2', 'blog-elite'),
            'style_3' => __('Style 3', 'blog-elite'),
        ),
        'priority' => 10,
    )
);
/**/

/*Add Theme Options Panel.*/
$wp_customize->add_panel(
    'theme_option_panel',
    array(
        'title' => __( 'Theme Options', 'blog-elite' ),
        'description' => __( 'Contains all theme settings', 'blog-elite')
    )
);
/**/

/* ========== Preloader Section. ==========*/
$wp_customize->add_section(
    'preloader_options',
    array(
        'title'      => __( 'Preloader Options', 'blog-elite' ),
        'panel'      => 'theme_option_panel',
    )
);
/*Show Preloader*/
$wp_customize->add_setting(
    'theme_options[show_preloader]',
    array(
        'default'           => $default_options['show_preloader'],
        'sanitize_callback' => 'blog_elite_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[show_preloader]',
    array(
        'label'    => __( 'Show Preloader', 'blog-elite' ),
        'section'  => 'preloader_options',
        'type'     => 'checkbox',
    )
);
/* ========== Preloader Section Close========== */

/* ========== Breadcrumb Section ========== */
$wp_customize->add_section(
    'breadcrumb_options',
    array(
        'title'      => __( 'Breadcrumb Options', 'blog-elite' ),
        'panel'      => 'theme_option_panel',
    )
);
/*Show Breadcrumb*/
$wp_customize->add_setting(
    'theme_options[enable_breadcrumb]',
    array(
        'default'           => $default_options['enable_breadcrumb'],
        'sanitize_callback' => 'blog_elite_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[enable_breadcrumb]',
    array(
        'label'    => __( 'Enable Breadcrumb', 'blog-elite' ),
        'section'  => 'breadcrumb_options',
        'type'     => 'checkbox',
    )
);
/* ========== Breadcrumb Section Close ========== */

/* ========== Layout Section. ==========*/
$wp_customize->add_section(
    'layout_options',
    array(
        'title'      => __( 'Layout Options', 'blog-elite' ),
        'panel'      => 'theme_option_panel',
    )
);

/* Site Layout */
$wp_customize->add_setting(
    'theme_options[site_layout]',
    array(
        'default'           => $default_options['site_layout'],
        'sanitize_callback' => 'blog_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[site_layout]',
    array(
        'label'       => __( 'Site Layout', 'blog-elite' ),
        'section'     => 'layout_options',
        'type'        => 'select',
        'choices'     => array(
            'boxed' => __('Boxed', 'blog-elite'),
            'wide' => __('Wide', 'blog-elite'),
        ),
    )
);

/* ========== Layout Section Close========== */

/* ========== Sidebar Section ========== */
$wp_customize->add_section(
    'sidebar_options',
    array(
        'title'      => __( 'Sidebar Options', 'blog-elite' ),
        'panel'      => 'theme_option_panel',
    )
);

/* Global Layout*/
$wp_customize->add_setting(
    'theme_options[global_sidebar_layout]',
    array(
        'default'           => $default_options['global_sidebar_layout'],
        'sanitize_callback' => 'blog_elite_sanitize_radio',
    )
);
$wp_customize->add_control(
    new Blog_Elite_Radio_Image_Control(
        $wp_customize,
        'theme_options[global_sidebar_layout]',
        array(
            'label'	=> __( 'Global Sidebar Layout', 'blog-elite' ),
            'section' => 'sidebar_options',
            'choices' => blog_elite_get_general_layouts()
        )
    )
);

/* Sticky enable/disable */
$wp_customize->add_setting(
    'theme_options[sticky_sidebar]',
    array(
        'default'           => $default_options['sticky_sidebar'],
        'sanitize_callback' => 'blog_elite_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[sticky_sidebar]',
    array(
        'label'       => __( 'Enable Sticky Sidebar', 'blog-elite' ),
        'section'     => 'sidebar_options',
        'type'        => 'checkbox',
    )
);

/* Sidebar widget heading style */
$wp_customize->add_setting(
    'theme_options[sidebar_widget_heading_style]',
    array(
        'default'           => $default_options['sidebar_widget_heading_style'],
        'sanitize_callback' => 'blog_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[sidebar_widget_heading_style]',
    array(
        'label'       => __( 'Sidebar Widget Heading Style', 'blog-elite' ),
        'section'     => 'sidebar_options',
        'type'        => 'select',
        'choices'     => array(
            'style_1' => __('Style 1', 'blog-elite'),
            'style_2' => __('Style 2', 'blog-elite'),
        ),
    )
);

/* Sidebar widget heading Align */
$wp_customize->add_setting(
    'theme_options[sidebar_widget_heading_align]',
    array(
        'default'           => $default_options['sidebar_widget_heading_align'],
        'sanitize_callback' => 'blog_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[sidebar_widget_heading_align]',
    array(
        'label'       => __( 'Sidebar Widget Heading Align', 'blog-elite' ),
        'section'     => 'sidebar_options',
        'type'        => 'select',
        'choices'     => array(
            'left' => __('Left', 'blog-elite'),
            'center' => __('Center', 'blog-elite'),
            'right' => __('Right', 'blog-elite'),
        ),
    )
);

/* ========== Sidebar Section Close ========== */

/* ========== General Widget area Section ========== */
$wp_customize->add_section(
    'general_widgetarea_options',
    array(
        'title'      => __( 'General Widgetarea Options', 'blog-elite' ),
        'panel'      => 'theme_option_panel',
    )
);

/* General Widget widget heading style */
$wp_customize->add_setting(
    'theme_options[general_widget_heading_style]',
    array(
        'default'           => $default_options['general_widget_heading_style'],
        'sanitize_callback' => 'blog_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[general_widget_heading_style]',
    array(
        'label'       => __( 'General Widget Heading Style', 'blog-elite' ),
        'section'     => 'general_widgetarea_options',
        'type'        => 'select',
        'choices'     => array(
            'style_1' => __('Style 1', 'blog-elite'),
            'style_2' => __('Style 2', 'blog-elite'),
        ),
    )
);

/* General widget heading Align */
$wp_customize->add_setting(
    'theme_options[general_widget_heading_align]',
    array(
        'default'           => $default_options['general_widget_heading_align'],
        'sanitize_callback' => 'blog_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[general_widget_heading_align]',
    array(
        'label'       => __( 'General Widget Heading Align', 'blog-elite' ),
        'section'     => 'general_widgetarea_options',
        'type'        => 'select',
        'choices'     => array(
            'left' => __('Left', 'blog-elite'),
            'center' => __('Center', 'blog-elite'),
            'right' => __('Right', 'blog-elite'),
        ),
    )
);

/* ========== General Widget area Section Close ========== */

/* ========== Excerpt Section ========== */
$wp_customize->add_section(
    'excerpt_options',
    array(
        'title'      => __( 'Excerpt Options', 'blog-elite' ),
        'panel'      => 'theme_option_panel',
    )
);

/* Excerpt Length */
$wp_customize->add_setting(
    'theme_options[excerpt_length]',
    array(
        'default'           => $default_options['excerpt_length'],
        'sanitize_callback' => 'absint',
    )
);
$wp_customize->add_control(
    'theme_options[excerpt_length]',
    array(
        'label'       => __( 'Max Excerpt Length', 'blog-elite' ),
        'description' => __( 'Remember this will affect other areas that shows excerpt too. So if you have excerpt with more length on other areas but is not working on front-end, be sure to increase the length here too.', 'blog-elite'),
        'section'     => 'excerpt_options',
        'type'        => 'number',
    )
);

/* Excerpt Read More Text */
$wp_customize->add_setting(
    'theme_options[excerpt_read_more_text]',
    array(
        'default'           => $default_options['excerpt_read_more_text'],
        'sanitize_callback' => 'wp_filter_nohtml_kses',
    )
);
$wp_customize->add_control(
    'theme_options[excerpt_read_more_text]',
    array(
        'label'       => __( 'Read More Text', 'blog-elite' ),
        'section'     => 'excerpt_options',
        'type'        => 'text',
    )
);
/* ========== Excerpt Section Close ========== */