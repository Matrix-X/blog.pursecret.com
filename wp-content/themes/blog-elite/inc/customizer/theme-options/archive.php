<?php
array_shift($image_sizes);
$wp_customize->add_section(
    'archive_options' ,
    array(
        'title' => __( 'Archive Options', 'blog-elite' ),
        'panel' => 'theme_option_panel',
    )
);

/* Archive Style */
$wp_customize->add_setting(
    'theme_options[archive_style]',
    array(
        'default'           => $default_options['archive_style'],
        'sanitize_callback' => 'blog_elite_sanitize_radio',
    )
);
$wp_customize->add_control(
    new Blog_Elite_Radio_Image_Control(
        $wp_customize,
        'theme_options[archive_style]',
        array(
            'label'	=> __( 'Archive Style', 'blog-elite' ),
            'section' => 'archive_options',
            'choices' => blog_elite_get_archive_layouts()
        )
    )
);

/* Archive Excerpt Length */
$wp_customize->add_setting(
    'theme_options[archive_excerpt_length]',
    array(
        'default'           => $default_options['archive_excerpt_length'],
        'sanitize_callback' => 'absint',
    )
);
$wp_customize->add_control(
    'theme_options[archive_excerpt_length]',
    array(
        'label'       => __( 'Archive Excerpt Length', 'blog-elite' ),
        'section'     => 'archive_options',
        'type'        => 'number',
    )
);

/*Archive Pagination Type*/
$wp_customize->add_setting(
    'theme_options[archive_pagination_type]',
    array(
        'default'           => $default_options['archive_pagination_type'],
        'sanitize_callback' => 'blog_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[archive_pagination_type]',
    array(
        'label'       => __( 'Archive Pagination Type', 'blog-elite' ),
        'section'     => 'archive_options',
        'type'        => 'select',
        'choices'     => array(
            'default' => esc_html__( 'Default (Older / Newer Post)', 'blog-elite' ),
            'numeric' => esc_html__( 'Numeric', 'blog-elite' ),
        ),
    )
);

/*Numeric Pagination Align*/
$wp_customize->add_setting(
    'theme_options[archive_numeric_pagination_align]',
    array(
        'default'           => $default_options['archive_numeric_pagination_align'],
        'sanitize_callback' => 'blog_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[archive_numeric_pagination_align]',
    array(
        'label'       => __( 'Numeric Pagination Align', 'blog-elite' ),
        'section'     => 'archive_options',
        'type'        => 'select',
        'choices'     => array(
            'left' => esc_html__( 'Left', 'blog-elite' ),
            'center' => esc_html__( 'Center', 'blog-elite' ),
            'right' => esc_html__( 'Right', 'blog-elite' ),
        ),
        'active_callback' => 'blog_elite_is_archive_numeric_pagination'
    )
);