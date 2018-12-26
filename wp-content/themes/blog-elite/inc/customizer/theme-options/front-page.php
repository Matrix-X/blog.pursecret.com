<?php
/*Add Home Page Options Panel.*/
$wp_customize->add_panel(
    'theme_home_option_panel',
    array(
        'title' => __( 'Front Page Options', 'blog-elite' ),
        'description' => __( 'Contains all front page settings', 'blog-elite')
    )
);
/**/

/* ========== Home Page Banner Section ========== */
$wp_customize->add_section(
    'home_banner_options' ,
    array(
        'title' => __( 'Front Page Banner Options', 'blog-elite' ),
        'panel' => 'theme_home_option_panel',
    )
);

/*Enable Banner Section*/
$wp_customize->add_setting(
    'theme_options[enable_home_banner]',
    array(
        'default'           => $default_options['enable_home_banner'],
        'sanitize_callback' => 'blog_elite_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[enable_home_banner]',
    array(
        'label'    => __( 'Enable Home Banner', 'blog-elite' ),
        'section'  => 'home_banner_options',
        'type'     => 'checkbox',
    )
);

/*Option to choose banner layout*/
$wp_customize->add_setting(
    'theme_options[banner_layout]',
    array(
        'default'           => $default_options['banner_layout'],
        'sanitize_callback' => 'blog_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[banner_layout]',
    array(
        'label'       => __( 'Banner Layout', 'blog-elite' ),
        'section'     => 'home_banner_options',
        'type'        => 'select',
        'choices'     => array(
            'full-width' => __('FullWidth', 'blog-elite'),
            'boxed' => __('Boxed', 'blog-elite'),
        ),
        'active_callback'  =>  'blog_elite_is_home_banner_enabled'
    )
);
/**/

/*Banner Display As*/
$wp_customize->add_setting(
    'theme_options[banner_display_as]',
    array(
        'default'           => $default_options['banner_display_as'],
        'sanitize_callback' => 'blog_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[banner_display_as]',
    array(
        'label'       => __( 'Banner Display As', 'blog-elite' ),
        'section'     => 'home_banner_options',
        'type'        => 'select',
        'choices'     => array(
            'slider' => __('Slider', 'blog-elite'),
            'carousel' => __('Carousel', 'blog-elite'),
        ),
        'active_callback' => 'blog_elite_is_home_banner_enabled'
    )
);
/**/

/*Banner Slider Style*/
$wp_customize->add_setting(
    'theme_options[banner_slider_style]',
    array(
        'default'           => $default_options['banner_slider_style'],
        'sanitize_callback' => 'blog_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[banner_slider_style]',
    array(
        'label'       => __( 'Banner Slider Style', 'blog-elite' ),
        'section'     => 'home_banner_options',
        'type'        => 'select',
        'choices'     => array(
            'style_1' => __('Style 1', 'blog-elite'),
            'style_2' => __('Style 2', 'blog-elite'),
        ),
        'active_callback'  =>  function( $control ) {
            return (
                blog_elite_is_home_banner_enabled( $control )
                &&
                blog_elite_is_home_banner_as_slider( $control )
            );
        }
    )
);
/**/

/*Banner Carousel Style*/
$wp_customize->add_setting(
    'theme_options[banner_carousel_style]',
    array(
        'default'           => $default_options['banner_carousel_style'],
        'sanitize_callback' => 'blog_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[banner_carousel_style]',
    array(
        'label'       => __( 'Banner Carousel Style', 'blog-elite' ),
        'section'     => 'home_banner_options',
        'type'        => 'select',
        'choices'     => array(
            'style_1' => __('Style 1', 'blog-elite'),
            'style_2' => __('Style 2', 'blog-elite'),
        ),
        'active_callback'  =>  function( $control ) {
            return (
                blog_elite_is_home_banner_enabled( $control )
                &&
                blog_elite_is_home_banner_as_carousel( $control )
            );
        }
    )
);
/**/

/*Banner Content From*/
$wp_customize->add_setting(
    'theme_options[banner_content_from]',
    array(
        'default'           => $default_options['banner_content_from'],
        'sanitize_callback' => 'blog_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[banner_content_from]',
    array(
        'label'       => __( 'Get Banner Content From', 'blog-elite' ),
        'section'     => 'home_banner_options',
        'type'        => 'select',
        'choices'     => array(
            'category' => __('Category', 'blog-elite'),
            'post_ids' => __('Post ID\'s', 'blog-elite'),
        ),
        'active_callback' => 'blog_elite_is_home_banner_enabled'
    )
);
/**/

/*Banner Posts Category.*/
$wp_customize->add_setting(
    'theme_options[banner_post_cat]',
    array(
        'default'           => $default_options['banner_post_cat'],
        'sanitize_callback' => 'absint'
    )
);
$wp_customize->add_control(
    new Blog_Elite_Dropdown_Taxonomies_Control(
        $wp_customize,
        'theme_options[banner_post_cat]',
        array(
            'label'    => __( 'Choose Category', 'blog-elite' ),
            'description'  => __( 'Leave Empty if you don\'t want the posts to be category specific', 'blog-elite' ),
            'section'  => 'home_banner_options',
            'active_callback'  =>  function( $control ) {
                return (
                    blog_elite_is_home_banner_enabled( $control )
                    &&
                    blog_elite_banner_content_from_category( $control )
                );
            }
        )
    )
);

/* Number of banner posts */
$wp_customize->add_setting(
    'theme_options[no_of_banner_posts]',
    array(
        'default'           => $default_options['no_of_banner_posts'],
        'sanitize_callback' => 'absint',
    )
);
$wp_customize->add_control(
    'theme_options[no_of_banner_posts]',
    array(
        'label'       => __( 'Number of Posts', 'blog-elite' ),
        'section'     => 'home_banner_options',
        'type'        => 'number',
        'active_callback'  =>  function( $control ) {
            return (
                blog_elite_is_home_banner_enabled( $control )
                &&
                blog_elite_banner_content_from_category( $control )
            );
        }
    )
);

/*Banner Posts Orderby*/
$wp_customize->add_setting(
    'theme_options[banner_posts_orderby]',
    array(
        'default'           => $default_options['banner_posts_orderby'],
        'sanitize_callback' => 'blog_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[banner_posts_orderby]',
    array(
        'label'       => __( 'Orderby', 'blog-elite' ),
        'section'     => 'home_banner_options',
        'type'        => 'select',
        'choices' => array(
            'date' => __('Date', 'blog-elite'),
            'ID' => __('ID', 'blog-elite'),
            'title' => __('Title', 'blog-elite'),
            'rand' => __('Random', 'blog-elite'),
        ),
        'active_callback'  =>  function( $control ) {
            return (
                blog_elite_is_home_banner_enabled( $control )
                &&
                blog_elite_banner_content_from_category( $control )
            );
        }
    )
);
/**/

/*Banner Posts Order*/
$wp_customize->add_setting(
    'theme_options[banner_posts_order]',
    array(
        'default'           => $default_options['banner_posts_order'],
        'sanitize_callback' => 'blog_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[banner_posts_order]',
    array(
        'label'       => __( 'Order', 'blog-elite' ),
        'section'     => 'home_banner_options',
        'type'        => 'select',
        'choices' => array(
            'asc' => __('ASC', 'blog-elite'),
            'desc' => __('DESC', 'blog-elite'),
        ),
        'active_callback'  =>  function( $control ) {
            return (
                blog_elite_is_home_banner_enabled( $control )
                &&
                blog_elite_banner_content_from_category( $control )
            );
        }
    )
);
/**/

/*Banner Posts ID's*/
$wp_customize->add_setting(
    'theme_options[banner_post_ids]',
    array(
        'default'           => $default_options['banner_post_ids'],
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    'theme_options[banner_post_ids]',
    array(
        'label'    => __( 'Post ID\'s', 'blog-elite' ),
        'description'=> __( 'Comma ( , ) separated posts ids. Ex: 1, 2, 3', 'blog-elite' ),
        'section'  => 'home_banner_options',
        'type'     => 'text',
        'active_callback'  =>  function( $control ) {
            return (
                blog_elite_is_home_banner_enabled( $control )
                &&
                blog_elite_banner_content_from_post_ids( $control )
            );
        }
    )
);

/*Enable Banner Category*/
$wp_customize->add_setting(
    'theme_options[show_banner_category]',
    array(
        'default'           => $default_options['show_banner_category'],
        'sanitize_callback' => 'blog_elite_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[show_banner_category]',
    array(
        'label'    => __( 'Show Category', 'blog-elite' ),
        'section'  => 'home_banner_options',
        'type'     => 'checkbox',
        'active_callback'  =>  'blog_elite_is_home_banner_enabled'
    )
);

/*Enable Banner Meta*/
$wp_customize->add_setting(
    'theme_options[show_banner_meta]',
    array(
        'default'           => $default_options['show_banner_meta'],
        'sanitize_callback' => 'blog_elite_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[show_banner_meta]',
    array(
        'label'    => __( 'Show Meta Info', 'blog-elite' ),
        'section'  => 'home_banner_options',
        'type'     => 'checkbox',
        'active_callback'  =>  'blog_elite_is_home_banner_enabled'
    )
);

/* ========== Home Page Banner Section Section ========== */


/* ========== Home Page Sidebar Options ========== */
$wp_customize->add_section(
    'home_page_layout_options',
    array(
        'title'      => __( 'Front Page Sidebar Options', 'blog-elite' ),
        'panel'      => 'theme_home_option_panel',
    )
);

/* Home Page Layout */
$wp_customize->add_setting(
    'theme_options[home_page_layout]',
    array(
        'default'           => $default_options['home_page_layout'],
        'sanitize_callback' => 'blog_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    new Blog_Elite_Radio_Image_Control(
        $wp_customize,
        'theme_options[home_page_layout]',
        array(
            'label'	=> __( 'Front Page Sidebar Layout', 'blog-elite' ),
            'section' => 'home_page_layout_options',
            'choices' => blog_elite_get_general_layouts()
        )
    )
);

/* Front Page Sticky enable/disable */
$wp_customize->add_setting(
    'theme_options[front_page_sticky_sidebar]',
    array(
        'default'           => $default_options['front_page_sticky_sidebar'],
        'sanitize_callback' => 'blog_elite_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[front_page_sticky_sidebar]',
    array(
        'label'       => __( 'Enable Front Page Sticky Sidebar', 'blog-elite' ),
        'section'     => 'home_page_layout_options',
        'type'        => 'checkbox',
    )
);

/* Homepage Sidebar widget heading style */
$wp_customize->add_setting(
    'theme_options[home_sidebar_widget_heading_style]',
    array(
        'default'           => $default_options['home_sidebar_widget_heading_style'],
        'sanitize_callback' => 'blog_elite_sanitize_radio',
    )
);
$wp_customize->add_control(
    'theme_options[home_sidebar_widget_heading_style]',
    array(
        'label'       => __( 'Front Page Sidebar Widget Heading Style', 'blog-elite' ),
        'section'     => 'home_page_layout_options',
        'type'        => 'select',
        'choices'     => array(
            'style_1' => __('Style 1', 'blog-elite'),
            'style_2' => __('Style 2', 'blog-elite'),
        ),
    )
);

/* Homepage Sidebar  widget heading Align */
$wp_customize->add_setting(
    'theme_options[home_sidebar_widget_heading_align]',
    array(
        'default'           => $default_options['home_sidebar_widget_heading_align'],
        'sanitize_callback' => 'blog_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[home_sidebar_widget_heading_align]',
    array(
        'label'       => __( 'Home Sidebar Widget Heading Align', 'blog-elite' ),
        'section'     => 'home_page_layout_options',
        'type'        => 'select',
        'choices'     => array(
            'left' => __('Left', 'blog-elite'),
            'center' => __('Center', 'blog-elite'),
            'right' => __('Right', 'blog-elite'),
        ),
    )
);
/* ========== Home Page Layout Section Close ========== */

/* ========== Home Page Post Section ========== */
$wp_customize->add_section(
    'home_page_post_options',
    array(
        'title'      => __( 'Front Page Post Options', 'blog-elite' ),
        'panel'      => 'theme_home_option_panel',
    )
);
/*Enable Front Page Content Section*/
$wp_customize->add_setting(
    'theme_options[enable_posts_in_front_page]',
    array(
        'default'           => $default_options['enable_posts_in_front_page'],
        'sanitize_callback' => 'blog_elite_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[enable_posts_in_front_page]',
    array(
        'label'    => __( 'Enable Latest Posts in Homepage', 'blog-elite' ),
        'description' => __( 'This setting is applicable if you have static homepage template enabled for the homepage. It will show latest post listing on homepage.', 'blog-elite' ),
        'section'  => 'home_page_post_options',
        'type'     => 'checkbox',
    )
);

/* Front Blog Style */
$wp_customize->add_setting(
    'theme_options[front_blog_style]',
    array(
        'default'           => $default_options['front_blog_style'],
        'sanitize_callback' => 'blog_elite_sanitize_radio',
    )
);
$wp_customize->add_control(
    new Blog_Elite_Radio_Image_Control(
        $wp_customize,
        'theme_options[front_blog_style]',
        array(
            'label'	=> __( 'Homepage Latest Posts Style', 'blog-elite' ),
            'section' => 'home_page_post_options',
            'choices' => blog_elite_get_archive_layouts(),
            'active_callback' => 'blog_elite_is_home_posts_enabled',
        )
    )
);

/*Front Page Blog Pagination Type*/
$wp_customize->add_setting(
    'theme_options[front_page_pagination_type]',
    array(
        'default'           => $default_options['front_page_pagination_type'],
        'sanitize_callback' => 'blog_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[front_page_pagination_type]',
    array(
        'label'       => __( 'Homepage Latest Posts Pagination Type', 'blog-elite' ),
        'section'     => 'home_page_post_options',
        'type'        => 'select',
        'choices'     => array(
            '' => esc_html__( 'No Pagination', 'blog-elite' ),
            'numeric' => esc_html__( 'Numeric', 'blog-elite' ),
        ),
        'active_callback' => 'blog_elite_is_home_posts_enabled',
    )
);

/*Front Page Blog Numeric Pagination Align*/
$wp_customize->add_setting(
    'theme_options[home_numeric_pagination_align]',
    array(
        'default'           => $default_options['home_numeric_pagination_align'],
        'sanitize_callback' => 'blog_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[home_numeric_pagination_align]',
    array(
        'label'       => __( 'Homepage Numeric Pagination Align', 'blog-elite' ),
        'section'     => 'home_page_post_options',
        'type'        => 'select',
        'choices'     => array(
            'left' => esc_html__( 'Left', 'blog-elite' ),
            'center' => esc_html__( 'Center', 'blog-elite' ),
            'right' => esc_html__( 'Right', 'blog-elite' ),
        ),
        'active_callback'  =>  function( $control ) {
            return (
                blog_elite_is_home_posts_enabled( $control )
                &&
                blog_elite_is_home_numeric_pagination( $control )
            );
        }
    )
);
/* ========== Home Page Content section Close ========== */