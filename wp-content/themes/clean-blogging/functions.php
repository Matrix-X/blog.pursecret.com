<?php
/**
 * Clean Blogging functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package clean-blogging
 */

if ( ! function_exists( 'clean_blogging_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function clean_blogging_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on clean-blogging, use a find and replace
		 * to change 'clean-blogging' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'clean-blogging', get_template_directory() . '/languages' );

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

		// https://codex.wordpress.org/Function_Reference/add_image_size.
		if ( function_exists( 'add_image_size' ) ) {
			add_image_size( 'clean_blogging_home_featured', 791, 380, true );
		}

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary-menu' => esc_html__( 'Primary', 'clean-blogging' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5', array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background', apply_filters(
				'clean_blogging_custom_background_args', array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
	}
endif;
add_action( 'after_setup_theme', 'clean_blogging_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function clean_blogging_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'clean_blogging_content_width', 640 );
}
add_action( 'after_setup_theme', 'clean_blogging_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function clean_blogging_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'clean-blogging' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'clean-blogging' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'clean_blogging_widgets_init' );


/**
 * Enqueue scripts and styles.
 */
function clean_blogging_scripts() {
	wp_enqueue_style( 'clean-blogging-style', get_stylesheet_uri() );

	// Loading the font handpicked for minimal blogging.
	wp_enqueue_style( 'clean-blogging-font', get_stylesheet_directory_uri() . '/assets/css/minblogfont.css' );

	// Load Navigation.
	wp_enqueue_script( 'clean-blogging-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array( 'jquery' ), '20151215', true );

	wp_localize_script(
		'clean-blogging-navigation', 'clean_blogging_ScreenReaderText', array(
			'expand'   => __( 'Expand child menu', 'clean-blogging' ),
			'collapse' => __( 'Collapse child menu', 'clean-blogging' ),
		)
	);

	wp_enqueue_script( 'clean-blogging-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '007', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'clean_blogging_scripts' );

/**
 * Detects if javascript is enabled or not.
 */
function clean_blogging_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'clean_blogging_javascript_detection', 0 );


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load Custom recent post widget.
 */
require_once get_template_directory() . '/inc/class-clean-blogging-recent-posts.php';

/**
 * Replaces the excerpt "Read More" text by a link.
 *
 * @param MORE $more - Holds the post excerpt content.
 */
function clean_blogging_excerpt_more( $more ) {
	if ( is_admin() ) {
		return $more;
	}

	global $post;
	return '<p><a class="readmore" href="' . get_permalink( $post->ID ) . '"><span class="arrow-right icon"></span>Read More</a></p>';
}
add_filter( 'excerpt_more', 'clean_blogging_excerpt_more' );

/**
 * Delist the default WordPress widgets replaced by custom theme widgets.
 */
function clean_blogging_custom_recent_post_widget() {
	unregister_widget( 'WP_Widget_Recent_Posts' );
}
add_action( 'widgets_init', 'clean_blogging_custom_recent_post_widget', 11 );
