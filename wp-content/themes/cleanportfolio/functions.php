<?php
/**
 * Clean Portfolio functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
  * @package Clean_Portfolio
 */

if ( ! function_exists( 'cleanportfolio_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function cleanportfolio_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Clean Portfolio, use a find and replace
		 * to change 'cleanportfolio' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'cleanportfolio', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		set_post_thumbnail_size( 1920, 1080, true );

		add_image_size( 'cleanportfolio-featured-large', 960, 960, true );
		add_image_size( 'cleanportfolio-featured', 640, 640, true );
		add_image_size( 'cleanportfolio-thumbnail-avatar', 90, 90, true );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1'      => esc_html__( 'Primary', 'cleanportfolio' ),
			'social-menu' => esc_html__( 'Social Menu', 'cleanportfolio' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add theme support for Custom Logo
		add_theme_support( 'custom-logo', array(
			'height'     => 100,
			'width'      => 100,
			'flex-width' => true,
		) );

		if ( class_exists( 'To_Top' ) ) {
			// Disable Scroll Up option if To Top plugin is activated
			set_theme_mod( 'cleanportfolio_disable_scrollup', 1 );
		}
	}
endif;
add_action( 'after_setup_theme', 'cleanportfolio_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function cleanportfolio_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'cleanportfolio_content_width', 792 );
}
add_action( 'after_setup_theme', 'cleanportfolio_content_width', 0 );

if ( ! function_exists( 'cleanportfolio_template_redirect' ) ) :
	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet for different value other than the default one
	 *
	 * @global int $content_width
	 */
	function cleanportfolio_template_redirect() {
		$layout = cleanportfolio_get_theme_layout();

		if ( 'no-sidebar-full-width' === $layout ) {
			$GLOBALS['content_width'] = 1711;

			if ( 'boxed' === get_theme_mod( 'cleanportfolio_layout_type', 'full-width' ) ) {
				$GLOBALS['content_width'] = 1826;
			}
		}
	}
endif;
add_action( 'template_redirect', 'cleanportfolio_template_redirect' );

/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 *
 * @since Clean Portfolio 0.1
 */
function cleanportfolio_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-2' ) ) {
		$count++;
	}

	if ( is_active_sidebar( 'sidebar-3' ) ) {
		$count++;
	}

	if ( is_active_sidebar( 'sidebar-4' ) ) {
		$count++;
	}

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
		case '4':
			$class = 'four';
			break;
	}

	if ( $class ) {
		echo 'class="widget-area footer-widget-area ' . $class . '"';
	}
}


if ( ! function_exists( 'cleanportfolio_fonts_url' ) ) :
	/**
	 * Register Google fonts for CleanPortfolio.
	 *
	 * Create your own cleanportfolio_fonts_url() function to override in a child theme.
	 *
	 * @since Clean Portfolio 0.1
	 *
	 * @return string Google fonts URL for the theme.
	 */
	function cleanportfolio_fonts_url() {
		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';

		/* translators: If there are characters in your language that are not supported by Lato, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== _x( 'on', 'Lato font: on or off', 'cleanportfolio' ) ) {
			$fonts[] = 'Lato:400,700,900,400italic,700italic,900italic';
		}

		/* translators: If there are characters in your language that are not supported by Playfair Display, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== _x( 'on', 'Playfair Display font: on or off', 'cleanportfolio' ) ) {
			$fonts[] = 'Playfair Display:400,700,400italic,700italic';
		}

		if ( $fonts ) {
			$fonts_url = add_query_arg( array(
				'family' => urlencode( implode( '|', $fonts ) ),
				'subset' => urlencode( $subsets ),
			), 'https://fonts.googleapis.com/css' );
		}

		return esc_url( $fonts_url );
	}
endif;

/**
 * Enqueue scripts and styles.
 */
function cleanportfolio_scripts() {

	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'cleanportfolio-fonts', cleanportfolio_fonts_url(), array(), null );

	// Theme stylesheet.
	wp_enqueue_style( 'cleanportfolio-style', get_stylesheet_uri() );

	// Load the html5 shiv.
	wp_enqueue_script( 'cleanportfolio-html5', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/html5.min.js', array(), '3.7.3' );
	wp_script_add_data( 'cleanportfolio-html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'cleanportfolio-skip-link-focus-fix', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/skip-link-focus-fix.min.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'cleanportfolio-keyboard-image-navigation', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/keyboard-image-navigation.min.js', array( 'jquery' ), '20160816' );
	}

	wp_register_script( 'jquery-match-height', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/jquery.matchHeight.min.js', array( 'jquery' ), '20151215', true );

	wp_enqueue_script( 'cleanportfolio-script', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/functions.min.js', array( 'jquery', 'jquery-match-height' ), '20150507', true );

	wp_localize_script( 'cleanportfolio-script', 'cleanportfolioScreenReaderText', array(
		'expand'   => esc_html__( 'expand child menu', 'cleanportfolio' ),
		'collapse' => esc_html__( 'collapse child menu', 'cleanportfolio' ),
		'icon'     => cleanportfolio_get_svg( array( 'icon' => 'angle-down', 'fallback' => true ) ),
	) );

	//Slider Scripts
	if( 'disabled' !== get_theme_mod( 'cleanportfolio_slider_option', 'disabled' ) ) {
		wp_enqueue_script( 'jquery-cycle2', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/jquery.cycle/jquery.cycle2.min.js', array( 'jquery' ), '2.1.5', true );

		$transition_effects = array(
			get_theme_mod( 'cleanportfolio_slider_transition_effects', 'fade' ),
		);

		/**
		 * Condition checks for additional slider transition plugins
		 */
		// Scroll Vertical transition plugin addition.
		if ( in_array( 'scrollVert', $transition_effects ) ){
			wp_enqueue_script( 'jquery-cycle2-scrollVert', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/jquery.cycle/jquery.cycle2.scrollVert.min.js', array( 'jquery-cycle2' ), '2.1.5', true );
		}

		// Flip transition plugin addition.
		if ( in_array( 'flipHorz', $transition_effects ) || in_array( 'flipVert', $transition_effects ) ){
			wp_enqueue_script( 'jquery-cycle2-flip', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/jquery.cycle/jquery.cycle2.flip.min.js', array( 'jquery-cycle2' ), '2.1.5', true );
		}

		// Shuffle transition plugin addition.
		if ( in_array( 'tileSlide', $transition_effects ) || in_array( 'tileBlind', $transition_effects ) ){
			wp_enqueue_script( 'jquery-cycle2-tile', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/jquery.cycle/jquery.cycle2.tile.min.js', array( 'jquery-cycle2' ), '2.1.5', true );
		}

		// Shuffle transition plugin addition.
		if ( in_array( 'shuffle', $transition_effects ) ){
			wp_enqueue_script( 'jquery-cycle2-shuffle', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/jquery.cycle/jquery.cycle2.shuffle.min.js', array( 'jquery-cycle2' ), '2.1.5', true );
		}
	}

	// Enqueue fitvid if JetPack is not installed.
	if ( ! class_exists( 'Jetpack' ) ) {
		wp_enqueue_script( 'jquery-fitvids', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/fitvids.min.js', array( 'jquery' ), '1.1', true );
	}

}
add_action( 'wp_enqueue_scripts', 'cleanportfolio_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Custom functions that act independently of the theme templates.
 */
require get_parent_theme_file_path( '/inc/extras.php' );

/**
 * Customizer additions.
 */
require get_parent_theme_file_path( '/inc/customizer/customizer.php' );

/**
 * Include Header Background Color Options
 */
require get_parent_theme_file_path( 'inc/header-background-color.php' );

/**
 * Load Jetpack compatibility file.
 */
require get_parent_theme_file_path( '/inc/jetpack.php' );

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path( '/inc/icon-functions.php' );

/**
 * Include Breadcrumb
 */
require get_parent_theme_file_path( '/inc/breadcrumb.php' );

/**
 * Include Slider
 */
require get_parent_theme_file_path( '/inc/featured-slider.php' );

/**
 * Include Service
 */
require get_parent_theme_file_path( '/inc/service.php' );

/**
 * Include Widgets
 */
require get_parent_theme_file_path( '/inc/widgets/widgets.php' );

/**
 * Include the TGM_Plugin_Activation class.
 */
require get_parent_theme_file_path( '/inc/class-tgm-plugin-activation.php' );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function cleanportfolio_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		// Catch Web Tools.
		array(
			'name' => 'Catch Web Tools', // Plugin Name, translation not required.
			'slug' => 'catch-web-tools',
		),
		// Catch IDs
		array(
			'name' => 'Catch IDs', // Plugin Name, translation not required.
			'slug' => 'catch-ids',
		),
		// To Top.
		array(
			'name' => 'To top', // Plugin Name, translation not required.
			'slug' => 'to-top',
		),
		// Catch Gallery.
		array(
			'name' => 'Catch Gallery', // Plugin Name, translation not required.
			'slug' => 'catch-gallery',
		),
	);

	if ( ! class_exists( 'Catch_Infinite_Scroll_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Catch Infinite Scroll', // Plugin Name, translation not required.
			'slug' => 'catch-infinite-scroll',
		);
	}

	if ( ! class_exists( 'Essential_Content_Types_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Essential Content Types', // Plugin Name, translation not required.
			'slug' => 'essential-content-types',
		);
	}

	if ( ! class_exists( 'Essential_Widgets_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Essential Widgets', // Plugin Name, translation not required.
			'slug' => 'essential-widgets',
		);
	}

	if ( ! class_exists( 'Catch_Instagram_Feed_Gallery_Widget_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Catch Instagram Feed Gallery & Widget', // Plugin Name, translation not required.
			'slug' => 'catch-instagram-feed-gallery-widget',
		);
	}

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'cleanportfolio',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'cleanportfolio_register_required_plugins' );

