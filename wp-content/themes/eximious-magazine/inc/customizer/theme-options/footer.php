<?php

$wp_customize->add_section(
    'footer_options' ,
    array(
        'title' => __( 'Footer Options', 'eximious-magazine' ),
        'panel' => 'theme_option_panel',
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
        'label'    => __( 'Copyright Text', 'eximious-magazine' ),
        'section'  => 'footer_options',
        'type'     => 'text',
    )
);

/*Enable Footer Nav*/
$wp_customize->add_setting(
    'theme_options[enable_footer_nav]',
    array(
        'default'           => $default_options['enable_footer_nav'],
        'sanitize_callback' => 'eximious_magazine_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[enable_footer_nav]',
    array(
        'label'    => __( 'Show Footer Nav Menu', 'eximious-magazine' ),
        'description' => sprintf( __( 'You can add/edit footer nav menu from <a href="%s">here</a>.', 'eximious-magazine' ), "javascript:wp.customize.control( 'nav_menu_locations[footer-menu]' ).focus();" ),
        'section'  => 'footer_options',
        'type'     => 'checkbox',
    )
);