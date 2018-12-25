<?php
array_shift($image_sizes);
$wp_customize->add_section(
    'archive_options' ,
    array(
        'title' => __( 'Archive Options', 'eximious-magazine' ),
        'panel' => 'theme_option_panel',
    )
);

/* Archive Style */
$wp_customize->add_setting(
    'theme_options[archive_style]',
    array(
        'default'           => $default_options['archive_style'],
        'sanitize_callback' => 'eximious_magazine_sanitize_radio',
    )
);
$wp_customize->add_control(
    new Eximious_Magazine_Radio_Image_Control(
        $wp_customize,
        'theme_options[archive_style]',
        array(
            'label'	=> __( 'Archive Style', 'eximious-magazine' ),
            'section' => 'archive_options',
            'choices' => eximious_magazine_get_archive_layouts()
        )
    )
);

/* Archive Image */
$wp_customize->add_setting(
    'theme_options[archive_image]',
    array(
        'default'           => $default_options['archive_image'],
        'sanitize_callback' => 'eximious_magazine_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[archive_image]',
    array(
        'label'    => __( 'Archive Image', 'eximious-magazine' ),
        'section'  => 'archive_options',
        'type'  => 'select',
        'choices'     => $image_sizes
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
        'label'       => __( 'Archive Excerpt Length', 'eximious-magazine' ),
        'section'     => 'archive_options',
        'type'        => 'number',
    )
);