<?php
/*Add Home Page Options Panel.*/
$wp_customize->add_panel(
    'theme_home_option_panel',
    array(
        'title' => __( 'Front Page Options', 'eximious-magazine' ),
        'description' => __( 'Contains all front page settings', 'eximious-magazine')
    )
);
/**/

/* ========== Home Page Trending Posts Section ========== */
$wp_customize->add_section(
    'home_trending_posts_options' ,
    array(
        'title' => __( 'Trending Posts Options', 'eximious-magazine' ),
        'panel' => 'theme_home_option_panel',
    )
);

/*Enable Trending Posts Section*/
$wp_customize->add_setting(
    'theme_options[enable_trending_posts]',
    array(
        'default'           => $default_options['enable_trending_posts'],
        'sanitize_callback' => 'eximious_magazine_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[enable_trending_posts]',
    array(
        'label'    => __( 'Enable Trending Posts', 'eximious-magazine' ),
        'section'  => 'home_trending_posts_options',
        'type'     => 'checkbox',
    )
);

/*Trending Posts Category.*/
$wp_customize->add_setting(
    'theme_options[trending_post_cat]',
    array(
        'default'           => $default_options['trending_post_cat'],
        'sanitize_callback' => 'absint'
    )
);
$wp_customize->add_control(
    new eximious_magazine_Dropdown_Taxonomies_Control(
        $wp_customize,
        'theme_options[trending_post_cat]',
        array(
            'label'    => __( 'Choose Category', 'eximious-magazine' ),
            'section'  => 'home_trending_posts_options',
            'description'  => __( 'Choose Trending Post Category', 'eximious-magazine' ),
            'active_callback' => 'eximious_magazine_is_trending_posts_enabled'
        )
    )
);

/* Number of Posts */
$wp_customize->add_setting(
    'theme_options[no_of_trending_posts]',
    array(
        'default'           => $default_options['no_of_trending_posts'],
        'sanitize_callback' => 'absint',
    )
);
$wp_customize->add_control(
    'theme_options[no_of_trending_posts]',
    array(
        'label'       => __( 'Number of Trending Posts', 'eximious-magazine' ),
        'section'     => 'home_trending_posts_options',
        'type'        => 'number',
        'active_callback' => 'eximious_magazine_is_trending_posts_enabled'
    )
);

/*Trending Post Text.*/
$wp_customize->add_setting(
    'theme_options[trending_post_text]',
    array(
        'default'           => $default_options['trending_post_text'],
        'sanitize_callback' => 'sanitize_text_field',
        'transport'           => 'postMessage',
    )
);
$wp_customize->add_control(
    'theme_options[trending_post_text]',
    array(
        'label'    => __( 'Trending Post Text', 'eximious-magazine' ),
        'section'  => 'home_trending_posts_options',
        'type'     => 'text',
        'active_callback' => 'eximious_magazine_is_trending_posts_enabled'
    )
);

/* ========== Home Page Trending Posts Section Close ========== */

/* ========== Home Page Slider Section ========== */
$wp_customize->add_section(
    'home_banner_options' ,
    array(
        'title' => __( 'Slider Options', 'eximious-magazine' ),
        'panel' => 'theme_home_option_panel',
    )
);

/*Enable Slider Section*/
$wp_customize->add_setting(
    'theme_options[enable_slider_posts]',
    array(
        'default'           => $default_options['enable_slider_posts'],
        'sanitize_callback' => 'eximious_magazine_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[enable_slider_posts]',
    array(
        'label'    => __( 'Enable Banner Slider', 'eximious-magazine' ),
        'section'  => 'home_banner_options',
        'type'     => 'checkbox',
    )
);

/*Option to choose slider layout*/
$wp_customize->add_setting(
    'theme_options[slider_layout]',
    array(
        'default'           => $default_options['slider_layout'],
        'sanitize_callback' => 'eximious_magazine_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[slider_layout]',
    array(
        'label'       => __( 'Slider Layout', 'eximious-magazine' ),
        'section'     => 'home_banner_options',
        'type'        => 'select',
        'choices'     => array(
            'full-width' => __('FullWidth', 'eximious-magazine'),
            'boxed' => __('Boxed', 'eximious-magazine'),
        ),
        'active_callback' => 'eximious_magazine_is_banner_slider_enabled'
    )
);
/**/

/*Slider Posts Category.*/
$wp_customize->add_setting(
    'theme_options[slider_post_cat]',
    array(
        'default'           => $default_options['slider_post_cat'],
        'sanitize_callback' => 'absint'
    )
);
$wp_customize->add_control(
    new eximious_magazine_Dropdown_Taxonomies_Control(
        $wp_customize,
        'theme_options[slider_post_cat]',
        array(
            'label'    => __( 'Choose Category', 'eximious-magazine' ),
            'section'  => 'home_banner_options',
            'active_callback' => 'eximious_magazine_is_banner_slider_enabled'
        )
    )
);

/* Number of Posts */
$wp_customize->add_setting(
    'theme_options[no_of_slider_posts]',
    array(
        'default'           => $default_options['no_of_slider_posts'],
        'sanitize_callback' => 'absint',
    )
);
$wp_customize->add_control(
    'theme_options[no_of_slider_posts]',
    array(
        'label'       => __( 'Number of Posts', 'eximious-magazine' ),
        'section'     => 'home_banner_options',
        'type'        => 'number',
        'active_callback' => 'eximious_magazine_is_banner_slider_enabled'
    )
);

/*Enable Slider Description*/
$wp_customize->add_setting(
    'theme_options[enable_slider_description]',
    array(
        'default'           => $default_options['enable_slider_description'],
        'sanitize_callback' => 'eximious_magazine_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[enable_slider_description]',
    array(
        'label'    => __( 'Enable Description', 'eximious-magazine' ),
        'section'  => 'home_banner_options',
        'type'     => 'checkbox',
        'active_callback' => 'eximious_magazine_is_banner_slider_enabled'
    )
);

/* Description Length */
$wp_customize->add_setting(
    'theme_options[slider_desc_length]',
    array(
        'default'           => $default_options['slider_desc_length'],
        'sanitize_callback' => 'absint',
    )
);
$wp_customize->add_control(
    'theme_options[slider_desc_length]',
    array(
        'label'       => __( 'Description Length', 'eximious-magazine' ),
        'section'     => 'home_banner_options',
        'type'        => 'number',
        'active_callback'  =>  function( $control ) {
            return (
                eximious_magazine_is_banner_slider_enabled( $control )
                &&
                eximious_magazine_is_banner_desc_enabled( $control )
            );
        }
    )
);

/*Enable Read More Button*/
$wp_customize->add_setting(
    'theme_options[enable_slider_read_more_btn]',
    array(
        'default'           => $default_options['enable_slider_read_more_btn'],
        'sanitize_callback' => 'eximious_magazine_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[enable_slider_read_more_btn]',
    array(
        'label'    => __( 'Enable Read More Button', 'eximious-magazine' ),
        'section'  => 'home_banner_options',
        'type'     => 'checkbox',
        'active_callback' => 'eximious_magazine_is_banner_slider_enabled'
    )
);

/*Read More Button text*/
$wp_customize->add_setting(
    'theme_options[slider_read_more_btn_text]',
    array(
        'default'           => $default_options['slider_read_more_btn_text'],
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    'theme_options[slider_read_more_btn_text]',
    array(
        'label'    => __( 'Button Text', 'eximious-magazine' ),
        'section'  => 'home_banner_options',
        'type'     => 'text',
        'active_callback'  =>  function( $control ) {
            return (
                eximious_magazine_is_banner_slider_enabled( $control )
                &&
                eximious_magazine_is_banner_read_btn_enabled( $control )
            );
        }
    )
);

/* ========== Home Page Slider Section Close ========== */

/* ========== Home Page Layout Section ========== */
$wp_customize->add_section(
    'home_page_layout_options',
    array(
        'title'      => __( 'Front Page Layout Options', 'eximious-magazine' ),
        'panel'      => 'theme_home_option_panel',
    )
);

/* Home Page Layout */
$wp_customize->add_setting(
    'theme_options[home_page_layout]',
    array(
        'default'           => $default_options['home_page_layout'],
        'sanitize_callback' => 'eximious_magazine_sanitize_select',
    )
);
$wp_customize->add_control(
    new Eximious_Magazine_Radio_Image_Control(
        $wp_customize,
        'theme_options[home_page_layout]',
        array(
            'label'	=> __( 'Front Page Layout', 'eximious-magazine' ),
            'section' => 'home_page_layout_options',
            'choices' => eximious_magazine_get_general_layouts()
        )
    )
);
/* ========== Home Page Layout Section Close ========== */

/* ========== Home Page Content Section ========== */
$wp_customize->add_section(
    'home_page_content_options',
    array(
        'title'      => __( 'Front Page Content Options', 'eximious-magazine' ),
        'panel'      => 'theme_home_option_panel',
    )
);
/*Enable Trending Posts Section*/
$wp_customize->add_setting(
    'theme_options[enable_front_page_content]',
    array(
        'default'           => $default_options['enable_front_page_content'],
        'sanitize_callback' => 'eximious_magazine_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[enable_front_page_content]',
    array(
        'label'    => __( 'Enable Latest Posts Listings/Static Page Content', 'eximious-magazine' ),
        'description' => sprintf( __( 'This will either show latest post listing or a static page content based on the option chosen on <a href="%s">homepage settings</a>.', 'eximious-magazine' ), "javascript:wp.customize.control( 'show_on_front' ).focus();" ),
        'section'  => 'home_page_content_options',
        'type'     => 'checkbox',
    )
);

/*Title text for homepage content*/
$wp_customize->add_setting(
    'theme_options[front_page_content_title]',
    array(
        'default'           => $default_options['front_page_content_title'],
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    'theme_options[front_page_content_title]',
    array(
        'label'    => __( 'Title Text', 'eximious-magazine' ),
        'description'=> __( 'Enter if you want to show a title for this section', 'eximious-magazine' ),
        'section'  => 'home_page_content_options',
        'type'     => 'text',
    )
);

/* ========== Home Page Content section Close ========== */