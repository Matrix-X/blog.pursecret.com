<?php
$wp_customize->add_section(
    'topbar_options' ,
    array(
        'title' => __( 'Topbar Options', 'blog-elite' ),
        'panel' => 'theme_option_panel',
    )
);

/*Enable Top Bar*/
$wp_customize->add_setting(
    'theme_options[enable_top_bar]',
    array(
        'default'           => $default_options['enable_top_bar'],
        'sanitize_callback' => 'blog_elite_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[enable_top_bar]',
    array(
        'label'    => __( 'Enable Top Bar', 'blog-elite' ),
        'section'  => 'topbar_options',
        'type'     => 'checkbox',
    )
);

/*Top Bar layout*/
$wp_customize->add_setting(
    'theme_options[top_bar_layout]',
    array(
        'default'           => $default_options['top_bar_layout'],
        'sanitize_callback' => 'blog_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[top_bar_layout]',
    array(
        'label'       => __( 'Top Bar Layout', 'blog-elite' ),
        'section'     => 'topbar_options',
        'type'        => 'select',
        'choices' => array(
            'boxed' => __('Boxed', 'blog-elite'),
            'wide' => __('Wide', 'blog-elite'),
        ),
        'active_callback'  =>  'blog_elite_is_top_bar_enabled'
    )
);
/**/

/*Enable Trending Posts Section*/
$wp_customize->add_setting(
    'theme_options[enable_trending_posts]',
    array(
        'default'           => $default_options['enable_trending_posts'],
        'sanitize_callback' => 'blog_elite_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[enable_trending_posts]',
    array(
        'label'    => __( 'Enable Trending Posts', 'blog-elite' ),
        'section'  => 'topbar_options',
        'type'     => 'checkbox',
        'active_callback'  => 'blog_elite_is_top_bar_enabled'
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
        'label'    => __( 'Trending Post Text', 'blog-elite' ),
        'section'  => 'topbar_options',
        'type'     => 'text',
        'active_callback'  =>  function( $control ) {
            return (
                blog_elite_is_top_bar_enabled( $control )
                &&
                blog_elite_is_trending_posts_enabled( $control )
            );
        }
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
    new Blog_Elite_Dropdown_Taxonomies_Control(
        $wp_customize,
        'theme_options[trending_post_cat]',
        array(
            'label'    => __( 'Trending Post Category', 'blog-elite' ),
            'section'  => 'topbar_options',
            'description'  => __( 'Leave Empty if you don\'t want the posts to be category specific', 'blog-elite' ),
            'active_callback'  =>  function( $control ) {
                return (
                    blog_elite_is_top_bar_enabled( $control )
                    &&
                    blog_elite_is_trending_posts_enabled( $control )
                );
            }
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
        'label'       => __( 'Number of Trending Posts', 'blog-elite' ),
        'section'     => 'topbar_options',
        'type'        => 'number',
        'active_callback'  =>  function( $control ) {
            return (
                blog_elite_is_top_bar_enabled( $control )
                &&
                blog_elite_is_trending_posts_enabled( $control )
            );
        }
    )
);

/*Orderby*/
$wp_customize->add_setting(
    'theme_options[trending_orderby]',
    array(
        'default'           => $default_options['trending_orderby'],
        'sanitize_callback' => 'blog_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[trending_orderby]',
    array(
        'label'       => __( 'Orderby', 'blog-elite' ),
        'section'     => 'topbar_options',
        'type'        => 'select',
        'choices' => array(
            'date' => __('Date', 'blog-elite'),
            'ID' => __('ID', 'blog-elite'),
            'title' => __('Title', 'blog-elite'),
            'rand' => __('Random', 'blog-elite'),
        ),
        'active_callback'  =>  function( $control ) {
            return (
                blog_elite_is_top_bar_enabled( $control )
                &&
                blog_elite_is_trending_posts_enabled( $control )
            );
        }
    )
);
/**/

/*Order*/
$wp_customize->add_setting(
    'theme_options[trending_order]',
    array(
        'default'           => $default_options['trending_order'],
        'sanitize_callback' => 'blog_elite_sanitize_select',
    )
);
$wp_customize->add_control(
    'theme_options[trending_order]',
    array(
        'label'       => __( 'Orderby', 'blog-elite' ),
        'section'     => 'topbar_options',
        'type'        => 'select',
        'choices' => array(
            'asc' => __('ASC', 'blog-elite'),
            'desc' => __('DESC', 'blog-elite'),
        ),
        'active_callback'  =>  function( $control ) {
            return (
                blog_elite_is_top_bar_enabled( $control )
                &&
                blog_elite_is_trending_posts_enabled( $control )
            );
        }
    )
);
/**/

/*Enable Social Nav*/
$wp_customize->add_setting(
    'theme_options[enable_top_bar_social_nav]',
    array(
        'default'           => $default_options['enable_top_bar_social_nav'],
        'sanitize_callback' => 'blog_elite_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[enable_top_bar_social_nav]',
    array(
        'label'    => __( 'Enable Top Bar Social Nav Menu', 'blog-elite' ),
        'description' => sprintf( __( 'You can add/edit social nav menu from <a href="%s">here</a>.', 'blog-elite' ), "javascript:wp.customize.control( 'nav_menu_locations[social-menu]' ).focus();" ),
        'section'  => 'topbar_options',
        'type'     => 'checkbox',
        'active_callback'  => 'blog_elite_is_top_bar_enabled'
    )
);