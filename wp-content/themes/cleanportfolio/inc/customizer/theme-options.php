<?php
/**
 * Clean Portfolio Theme Options
 *
  * @package Clean_Portfolio
 */

/**
 * Add theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function cleanportfolio_theme_options( $wp_customize ) {
	$wp_customize->add_panel( 'cleanportfolio_theme_options', array(
			'title'    => esc_html__( 'Theme Options', 'cleanportfolio' ),
			'priority' => 130,
		)
	);

	// Breadcrumb Option
	$wp_customize->add_section( 'cleanportfolio_breadcrumb_options', array(
			'description' => esc_html__( 'Breadcrumbs are a great way of letting your visitors find out where they are on your site with just a glance. You can enable/disable them on homepage and entire site.', 'cleanportfolio' ),
			'panel'       => 'cleanportfolio_theme_options',
			'title'       => esc_html__( 'Breadcrumb', 'cleanportfolio' ),
		)
	);

	cleanportfolio_register_option( $wp_customize, array(
			'name'              => 'cleanportfolio_breadcrumb_option',
			'default'           => 1,
			'sanitize_callback' => 'cleanportfolio_sanitize_checkbox',
			'label'             => esc_html__( 'Check to enable Breadcrumb', 'cleanportfolio' ),
			'section'           => 'cleanportfolio_breadcrumb_options',
			'type'              => 'checkbox',
		)
	);
	// Breadcrumb Option End

	$def_header_text = esc_html__( 'This is Header Media Text.', 'cleanportfolio' );

	if ( current_user_can( 'edit_theme_options' ) ) {
		$def_header_text .= '&nbsp;' . esc_html__( 'Edit this from Appearance - Customize - Header Media - Header Media Text.', 'cleanportfolio' );
	}

	cleanportfolio_register_option( $wp_customize, array(
			'name'              => 'cleanportfolio_header_media_text',
			'default'           => $def_header_text,
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Header Media Text', 'cleanportfolio' ),
			'section'           => 'header_image',
			'type'              => 'textarea',
		)
	);

	$wp_customize->add_section( 'cleanportfolio_layout_options', array(
			'title' => esc_html__( 'Layout Options', 'cleanportfolio' ),
			'panel' => 'cleanportfolio_theme_options'
		)
	);

	/* Layout Type */
	cleanportfolio_register_option( $wp_customize, array(
			'name'              => 'cleanportfolio_layout_type',
			'default'           => 'full-width',
			'sanitize_callback' => 'cleanportfolio_sanitize_select',
			'label'             => esc_html__( 'Site Layout', 'cleanportfolio' ),
			'section'           => 'cleanportfolio_layout_options',
			'type'              => 'radio',
			'choices'           => array(
				'full-width' => esc_html__( 'Full Width', 'cleanportfolio' ),
				'boxed'      => esc_html__( 'Boxed', 'cleanportfolio' ),
			),
		)
	);

	/* Default Layout */
	cleanportfolio_register_option( $wp_customize, array(
			'name'              => 'cleanportfolio_default_layout',
			'default'           => 'right-sidebar',
			'sanitize_callback' => 'cleanportfolio_sanitize_select',
			'description'       => esc_html__( 'Layout for Singular Post Types like Post, Page', 'cleanportfolio' ),
			'label'             => esc_html__( 'Singular Content Layout', 'cleanportfolio' ),
			'section'           => 'cleanportfolio_layout_options',
			'type'              => 'radio',
			'choices'           => array(
				'right-sidebar'         => esc_html__( 'Right Sidebar ( Content, Primary Sidebar )', 'cleanportfolio' ),
				'no-sidebar-full-width' => esc_html__( 'No Sidebar: Full Width', 'cleanportfolio' ),
			),
		)
	);

	cleanportfolio_register_option( $wp_customize, array(
			'name'              => 'cleanportfolio_homepage_archive_layout',
			'default'           => 'no-sidebar-full-width',
			'sanitize_callback' => 'cleanportfolio_sanitize_select',
			'description'       => esc_html__( 'Layout for Blog/Archive Pages', 'cleanportfolio' ),
			'label'             => esc_html__( 'Homepage/Archive Layout', 'cleanportfolio' ),
			'section'           => 'cleanportfolio_layout_options',
			'type'              => 'radio',
			'choices'           => array(
				'right-sidebar'         => esc_html__( 'Right Sidebar ( Content, Primary Sidebar )', 'cleanportfolio' ),
				'no-sidebar-full-width' => esc_html__( 'No Sidebar: Full Width', 'cleanportfolio' ),
			),
		)
	);

	// Excerpt Options
	$wp_customize->add_section( 'cleanportfolio_excerpt_options', array(
			'panel'     => 'cleanportfolio_theme_options',
			'title'     => esc_html__( 'Excerpt Options', 'cleanportfolio' ),
		)
	);

	cleanportfolio_register_option( $wp_customize, array(
			'name'              => 'cleanportfolio_excerpt_length',
			'default'           => '30',
			'sanitize_callback' => 'absint',
			'description'       => esc_html__('Excerpt length. Default is 30 words', 'cleanportfolio'),
			'input_attrs'       => array(
				'min'   => 10,
				'max'   => 200,
				'step'  => 5,
				'style' => 'width: 60px;'
			),
			'label'             => esc_html__( 'Excerpt Length (words)', 'cleanportfolio' ),
			'section'           => 'cleanportfolio_excerpt_options',
			'type'              => 'number',
		)
	);

	cleanportfolio_register_option( $wp_customize, array(
			'name'              => 'cleanportfolio_excerpt_more_text',
			'default'           => esc_html__( 'Continue reading', 'cleanportfolio' ),
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => esc_html__( 'Read More Text', 'cleanportfolio' ),
			'section'           => 'cleanportfolio_excerpt_options',
			'type'              => 'text',
		)
	);
	// Excerpt Options End

	$wp_customize->add_section( 'cleanportfolio_search_options', array(
		'panel'     => 'cleanportfolio_theme_options',
		'title'     => esc_html__( 'Search Options', 'cleanportfolio' ),
	) );

	cleanportfolio_register_option( $wp_customize, array(
			'name'              => 'cleanportfolio_search_text',
			'default'           => esc_html__( 'Search &hellip;', 'cleanportfolio' ),
			'sanitize_callback' => 'wp_kses_data',
			'label'             => esc_html__( 'Search Text', 'cleanportfolio' ),
			'section'           => 'cleanportfolio_search_options',
			'type'              => 'text',
		)
	);

	//Homepage / Frontpage Options
	$wp_customize->add_section( 'cleanportfolio_homepage_options', array(
			'description' => esc_html__( 'Only posts that belong to the categories selected here will be displayed on the front page', 'cleanportfolio' ),
			'panel'       => 'cleanportfolio_theme_options',
			'title'       => esc_html__( 'Homepage / Frontpage Options', 'cleanportfolio' ),
		)
	);

	cleanportfolio_register_option( $wp_customize, array(
			'name'              => 'cleanportfolio_front_page_category',
			'default'           => array(),
			'sanitize_callback' => 'cleanportfolio_sanitize_category_list',
			'custom_control'    => 'CleanportfolioMultiCategoriesControl',
			'label'             => esc_html__( 'Select Categories', 'cleanportfolio' ),
			'name'              => 'cleanportfolio_front_page_category',
			'section'           => 'cleanportfolio_homepage_options',
			'type'              => 'dropdown-categories',
		)
	);

	// Disable Recent post in static frontpage
    $wp_customize->add_setting( 'cleanportfolio_enable_static_page_posts', array(
        'sanitize_callback' => 'cleanportfolio_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'cleanportfolio_enable_static_page_posts', array(
        'label'           => esc_html__( 'Check to enable Recent Posts on Static Frontpage', 'cleanportfolio' ),
        'section'         => 'cleanportfolio_homepage_options',
        'type'            => 'checkbox',
    ) );
	//Homepage / Frontpage Settings End

	// Pagination Options
	$nav_desc = sprintf( esc_html__( 'Infinite Scroll Options requires %1$sJetPack Plugin%2$s with Infinite Scroll module Enabled.', 'cleanportfolio' ), '<a target="_blank" href="' . esc_url( 'https://wordpress.org/plugins/jetpack/' ) . '">', '</a>' );

	$wp_customize->add_section( 'cleanportfolio_pagination_options', array(
		'description'   => $nav_desc,
			'panel'         => 'cleanportfolio_theme_options',
			'title'         => esc_html__( 'Pagination Options', 'cleanportfolio' ),
		)
	);

	$def_pagination = 'default';

	if ( class_exists( 'Jetpack' ) ) {
		$def_pagination = 'infinite-scroll';
	}

	cleanportfolio_register_option( $wp_customize, array(
			'name'              => 'cleanportfolio_pagination_type',
			'default'           => $def_pagination,
			'sanitize_callback' => 'cleanportfolio_sanitize_select',
			'choices'           => cleanportfolio_get_pagination_types(),
			'label'             => esc_html__( 'Pagination type', 'cleanportfolio' ),
			'section'           => 'cleanportfolio_pagination_options',
			'type'              => 'select',
		)
	);
	// Pagination Options End

	if ( ! class_exists( 'To_Top' ) ) {
		/* Scrollup Options */
		$wp_customize->add_section( 'cleanportfolio_scrollup', array(
				'panel'    => 'cleanportfolio_theme_options',
				'title'    => esc_html__( 'Scrollup Options', 'cleanportfolio' ),
			)
		);

		cleanportfolio_register_option( $wp_customize, array(
				'name'              => 'cleanportfolio_disable_scrollup',
				'sanitize_callback' => 'cleanportfolio_sanitize_checkbox',
				'label'             => esc_html__( 'Check to disable Scroll Up', 'cleanportfolio' ),
				'section'           => 'cleanportfolio_scrollup',
				'type'              => 'checkbox',
			)
		);
	}
}
add_action( 'customize_register', 'cleanportfolio_theme_options' );
