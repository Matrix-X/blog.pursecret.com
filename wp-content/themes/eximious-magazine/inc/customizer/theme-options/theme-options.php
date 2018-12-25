<?php
/*Add Theme Options Panel.*/
$wp_customize->add_panel(
    'theme_option_panel',
    array(
        'title' => __( 'Theme Options', 'eximious-magazine' ),
        'description' => __( 'Contains all theme settings', 'eximious-magazine')
    )
);
/**/

/* ========== Preloader Section. ==========*/
$wp_customize->add_section(
    'preloader_options',
    array(
        'title'      => __( 'Preloader Options', 'eximious-magazine' ),
        'panel'      => 'theme_option_panel',
    )
);
/*Show Preloader*/
$wp_customize->add_setting(
    'theme_options[show_preloader]',
    array(
        'default'           => $default_options['show_preloader'],
        'sanitize_callback' => 'eximious_magazine_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[show_preloader]',
    array(
        'label'    => __( 'Show Preloader', 'eximious-magazine' ),
        'section'  => 'preloader_options',
        'type'     => 'checkbox',
    )
);
/* ========== Preloader Section Close========== */

/* ========== Breadcrumb Section ========== */
$wp_customize->add_section(
    'breadcrumb_options',
    array(
        'title'      => __( 'Breadcrumb Options', 'eximious-magazine' ),
        'panel'      => 'theme_option_panel',
    )
);
/*Show Breadcrumb*/
$wp_customize->add_setting(
    'theme_options[enable_breadcrumb]',
    array(
        'default'           => $default_options['enable_breadcrumb'],
        'sanitize_callback' => 'eximious_magazine_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[enable_breadcrumb]',
    array(
        'label'    => __( 'Enable Breadcrumb', 'eximious-magazine' ),
        'section'  => 'breadcrumb_options',
        'type'     => 'checkbox',
    )
);
/* ========== Breadcrumb Section Close ========== */

/* ========== Pagination Section ========== */
$wp_customize->add_section(
    'pagination_options',
    array(
        'title'      => __( 'Pagination Options', 'eximious-magazine' ),
        'panel'      => 'theme_option_panel',
    )
);

/*Pagination Type*/
$wp_customize->add_setting(
    'theme_options[pagination_type]',
    array(
        'default'           => $default_options['pagination_type'],
        'sanitize_callback' => 'eximious_magazine_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[pagination_type]',
    array(
        'label'       => __( 'Pagination Type', 'eximious-magazine' ),
        'section'     => 'pagination_options',
        'type'        => 'select',
        'choices'     => array(
            'default' => esc_html__( 'Default (Older / Newer Post)', 'eximious-magazine' ),
            'numeric' => esc_html__( 'Numeric', 'eximious-magazine' ),
        ),
    )
);
/* ========== Pagination Section Close========== */

/* ========== Layout Section ========== */
$wp_customize->add_section(
    'layout_options',
    array(
        'title'      => __( 'Layout Options', 'eximious-magazine' ),
        'panel'      => 'theme_option_panel',
    )
);

/* Global Layout*/
$wp_customize->add_setting(
    'theme_options[global_layout]',
    array(
        'default'           => $default_options['global_layout'],
        'sanitize_callback' => 'eximious_magazine_sanitize_radio',
    )
);
$wp_customize->add_control(
    new Eximious_Magazine_Radio_Image_Control(
        $wp_customize,
        'theme_options[global_layout]',
        array(
            'label'	=> __( 'Global Layout', 'eximious-magazine' ),
            'section' => 'layout_options',
            'choices' => eximious_magazine_get_general_layouts()
        )
    )
);
/* ========== Layout Section Close ========== */

/* ========== Sticky Sidebar Section ========== */
$wp_customize->add_section(
    'sticky_sidebar_options',
    array(
        'title'      => __( 'Sticky Sidebar Options', 'eximious-magazine' ),
        'panel'      => 'theme_option_panel',
    )
);
/* Sticky enable/disable */
$wp_customize->add_setting(
    'theme_options[sticky_sidebar]',
    array(
        'default'           => $default_options['sticky_sidebar'],
        'sanitize_callback' => 'eximious_magazine_sanitize_radio',
    )
);
$wp_customize->add_control(
    'theme_options[sticky_sidebar]',
    array(
        'label'       => __( 'Sticky Sidebar', 'eximious-magazine' ),
        'section'     => 'sticky_sidebar_options',
        'type'        => 'select',
        'choices'     => array(
            '' => __('Disable', 'eximious-magazine'),
            'home' => __('Home Page Only', 'eximious-magazine'),
            'whole' => __('Whole Site', 'eximious-magazine'),
        ),
    )
);
/* ========== Sticky Sidebar Section Close ========== */

/* ========== Excerpt Section ========== */
$wp_customize->add_section(
    'excerpt_options',
    array(
        'title'      => __( 'Excerpt Options', 'eximious-magazine' ),
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
        'label'       => __( 'Max Excerpt Length', 'eximious-magazine' ),
        'description' => __( 'Remember this will affect other areas that shows excerpt too. So if you have excerpt with more length on other areas but is not working on front-end, be sure to increase the length here too.', 'eximious-magazine'),
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
        'label'       => __( 'Read More Text', 'eximious-magazine' ),
        'section'     => 'excerpt_options',
        'type'        => 'text',
    )
);
/* ========== Excerpt Section Close ========== */