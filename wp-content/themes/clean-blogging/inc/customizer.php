<?php
/**
 * Clean Blogging Theme Customizer
 *
 * @package clean-blogging
 */

/**
 * Initialize the Clean Blogging customizer.
 *
 * @param WPCustomize $wp_customize - Extending the WordPress customizer functionality.
 */
function clean_blogging_customizer_changes( $wp_customize ) {

	// =============================================================
	// Removing the default - Not so awesome settings.
	// =============================================================
	$wp_customize->remove_control( 'display_header_text' );
	$wp_customize->remove_control( 'header_textcolor' );
	$wp_customize->remove_control( 'background_color' );

	// =============================================================
	// Making the changes to Name of Settings.
	// =============================================================
	$wp_customize->get_section( 'colors' )->priority       = 30;
	$wp_customize->get_section( 'header_image' )->priority = 20;

	$wp_customize->get_section( 'colors' )->title       = __( 'Manage Theme Colors', 'clean-blogging' );
	$wp_customize->get_section( 'header_image' )->title = __( 'Featured Hero Image', 'clean-blogging' );

}
add_action( 'customize_register', 'clean_blogging_customizer_changes' );

/**
 * Adding options to Clean Blogging customizer.
 *
 * @param WPCustomize $wp_customize - Extending the WordPress customizer functionality.
 */
function clean_blogging_customizer( $wp_customize ) {

	// Color Definations Starting From Here.   ---------------------------------->
	// Only Color Related Settings Below Plz.  ---------------------------------->
		// Accent Color.
		$wp_customize->add_setting(
			'clean_blogging_accent_color',
			array(
				'default'           => '#FF5722',
				'sanitize_callback' => 'wp_strip_all_tags',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'clean_blogging_accent_color',
				array(
					'label'       => esc_html__( 'Accent Color', 'clean-blogging' ),
					'description' => esc_html__( 'Control color of hyperlinks, buttons, on:focus elements.', 'clean-blogging' ),
					'section'     => 'colors',
					'settings'    => 'clean_blogging_accent_color',
					'priority'    => 1,
				)
			)
		);

		// Accent Hover Color.
		$wp_customize->add_setting(
			'clean_blogging_accent_hover_color',
			array(
				'default'           => '#FF5722',
				'sanitize_callback' => 'wp_strip_all_tags',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'clean_blogging_accent_hover_color',
				array(
					'label'       => esc_html__( 'Accent on:hover Colors', 'clean-blogging' ),
					'description' => esc_html__( 'Change the on:hover color of various elements.', 'clean-blogging' ),
					'section'     => 'colors',
					'settings'    => 'clean_blogging_accent_hover_color',
					'priority'    => 2,
				)
			)
		);

		// Header Background Color.
		$wp_customize->add_setting(
			'clean_blogging_header_bg_color',
			array(
				'default'           => '#fff',
				'sanitize_callback' => 'wp_strip_all_tags',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'clean_blogging_header_bg_color',
				array(
					'label'       => esc_html__( 'Header Background', 'clean-blogging' ),
					'description' => esc_html__( 'Change the background color of Header.', 'clean-blogging' ),
					'section'     => 'colors',
					'settings'    => 'clean_blogging_header_bg_color',
					'priority'    => 3,
				)
			)
		);

		// Header Text Colors.
		$wp_customize->add_setting(
			'clean_blogging_header_text_color',
			array(
				'default'           => '#222',
				'sanitize_callback' => 'wp_strip_all_tags',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'clean_blogging_header_text_color',
				array(
					'label'       => esc_html__( 'Header Text Color', 'clean-blogging' ),
					'description' => esc_html__( 'Change the color of Text on Header Area.', 'clean-blogging' ),
					'section'     => 'colors',
					'settings'    => 'clean_blogging_header_text_color',
					'priority'    => 4,
				)
			)
		);

		// Header Text on:hover Color.
		$wp_customize->add_setting(
			'clean_blogging_header_text_hover_color',
			array(
				'default'           => '#dddddd',
				'sanitize_callback' => 'wp_strip_all_tags',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'clean_blogging_header_text_hover_color',
				array(
					'label'       => esc_html__( 'Header Text on:hover Color', 'clean-blogging' ),
					'description' => esc_html__( 'Change the on:hover color of Text on Header Area.', 'clean-blogging' ),
					'section'     => 'colors',
					'settings'    => 'clean_blogging_header_text_hover_color',
					'priority'    => 5,
				)
			)
		);

		// Footer Background Color.
		$wp_customize->add_setting(
			'clean_blogging_footerbg_color',
			array(
				'default'           => '#ececec',
				'sanitize_callback' => 'wp_strip_all_tags',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'clean_blogging_footerbg_color',
				array(
					'label'       => esc_html__( 'Footer Background Color', 'clean-blogging' ),
					'description' => esc_html__( 'Change the color of the footer area.', 'clean-blogging' ),
					'section'     => 'colors',
					'settings'    => 'clean_blogging_footerbg_color',
					'priority'    => 6,
				)
			)
		);

		// Footer Background Color.
		$wp_customize->add_setting(
			'clean_blogging_footertext_color',
			array(
				'default'           => '#404040',
				'sanitize_callback' => 'wp_strip_all_tags',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'clean_blogging_footertext_color',
				array(
					'label'       => esc_html__( 'Footer Text Color', 'clean-blogging' ),
					'description' => esc_html__( 'Change the color of text in footer area.', 'clean-blogging' ),
					'section'     => 'colors',
					'settings'    => 'clean_blogging_footertext_color',
					'priority'    => 7,
				)
			)
		);

}
add_action( 'customize_register', 'clean_blogging_customizer' );




/**
 * Output our custom Accent Color setting CSS Style.
 */
function clean_blogging_custom_css() {
	?>
	<style type="text/css">
		a, .site-header a:hover, .main-navigation li a:hover, .entry-content a, .main-navigation li:hover .desktop-dropdownsymbol { color:<?php echo esc_attr( get_theme_mod( 'clean_blogging_accent_color', '#FF5722' ) ); ?>; }
		a.readmore{
			border-color:  <?php echo esc_attr( get_theme_mod( 'clean_blogging_accent_color', '#FF5722' ) ); ?>;
		}
		.arrow-right.icon{
			color: <?php echo esc_attr( get_theme_mod( 'clean_blogging_accent_color', '#FF5722' ) ); ?>;
		}
		.entry-content a.readmore:hover{
			background-color: <?php echo esc_attr( get_theme_mod( 'clean_blogging_accent_hover_color', '#FF5722' ) ); ?>;
		}
		.comment-reply-link {
			color:<?php echo esc_attr( get_theme_mod( 'clean_blogging_accent_color', '#FF5722' ) ); ?>;
			border-color: <?php echo esc_attr( get_theme_mod( 'clean_blogging_accent_color', '#FF5722' ) ); ?>;
	 		}
			.comment-reply-title small a:hover, .comment-reply-title small a:focus, .comment-reply-title small a:active, .comment-reply-link:hover, .comment-reply-link:focus, .comment-reply-link:active {
				border-color: <?php echo esc_attr( get_theme_mod( 'clean_blogging_accent_hover_color', '#FF5722' ) ); ?>;
			}
		.comment-reply-link:hover { background-color:<?php echo esc_attr( get_theme_mod( 'clean_blogging_accent_color', '#FF5722' ) ); ?>; }
		.pagination ul li a { border: 1px solid <?php echo esc_attr( get_theme_mod( 'clean_blogging_accent_color', '#FF5722' ) ); ?>; }

		a:hover, .entry-content a:hover, h2.entry-title a:hover, footer#colophon a:hover { color:<?php echo esc_attr( get_theme_mod( 'clean_blogging_accent_hover_color', '#FF5722' ) ); ?>; }
		.comment-reply-link:hover, .pagination ul li a:hover, .form-submit input:hover { background-color:<?php echo esc_attr( get_theme_mod( 'clean_blogging_accent_hover_color', '#FF5722' ) ); ?>; }
		.pagination ul li a:hover { border: 1px solid <?php echo esc_attr( get_theme_mod( 'clean_blogging_accent_color', '#FF5722' ) ); ?>; }

		.site-header, .main-navigation ul ul a { background-color:<?php echo esc_attr( get_theme_mod( 'clean_blogging_header_bg_color', '#fff' ) ); ?>; }

		.site-header a, .main-navigation .desktop-dropdownsymbol { color:<?php echo esc_attr( get_theme_mod( 'clean_blogging_header_text_color', '#222' ) ); ?>; }

		.main-navigation li li a:hover { color:<?php echo esc_attr( get_theme_mod( 'clean_blogging_header_text_hover_color', '#222' ) ); ?>; }

		footer#colophon { background-color:<?php echo esc_attr( get_theme_mod( 'clean_blogging_footerbg_color', '#ececec' ) ); ?>; }

		footer#colophon a, footer#colophon { color:<?php echo esc_attr( get_theme_mod( 'clean_blogging_footertext_color', '#404040' ) ); ?>; }
	</style>
	<?php
}
add_action( 'wp_head', 'clean_blogging_custom_css' );
