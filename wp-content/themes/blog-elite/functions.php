<?php
/**
 * Blog Elite functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Blog_Elite
 */

if ( ! function_exists( 'blog_elite_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function blog_elite_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Blog Elite, use a find and replace
		 * to change 'blog-elite' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'blog-elite', get_template_directory() . '/languages' );

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

		register_nav_menus( array(
			'primary-menu' => esc_html__( 'Primary Menu', 'blog-elite' ),
			'social-menu' => esc_html__( 'Social Menu', 'blog-elite' ),
			'footer-menu' => esc_html__( 'Footer Menu', 'blog-elite' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'blog_elite_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 100,
			'width'       => 350,
			'flex-width'  => true,
			'flex-height' => true,
		) );

        add_image_size( 'blog-elite-slide-full', 1980, 800, true );
        add_image_size( 'blog-elite-slide-boxed', 1170, 600, true );

        add_image_size( 'blog-elite-carousel-full', 800, 450, true );
        add_image_size( 'blog-elite-carousel-boxed', 580, 400, true );
	}
endif;
add_action( 'after_setup_theme', 'blog_elite_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function blog_elite_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'blog_elite_content_width', 640 );
}
add_action( 'after_setup_theme', 'blog_elite_content_width', 0 );

/**
 * Get google fonts url
 */
if (!function_exists('blog_elite_fonts_url')) :

    /**
     * Return fonts URL.
     *
     * @since 1.0.0
     * @return string Fonts URL.
     */
    function blog_elite_fonts_url(){

        $fonts_url = '';
        $fonts = array();
        $subsets = 'latin,latin-ext';


        /* translators: If there are characters in your language that are not supported by Roboto Condensed, translate this to 'off'. Do not translate into your own language. */
        if ('off' !== _x('on', 'Montserrat: on or off', 'blog-elite')) {
            $fonts[] = 'Montserrat:400,400i,500';
        }

        /* translators: If there are characters in your language that are not supported by Open Sans, translate this to 'off'. Do not translate into your own language. */
        if ('off' !== _x('on', 'Open+Sans: on or off', 'blog-elite')) {
            $fonts[] = 'Open+Sans:400,700';
        }


        if ($fonts) {
            $fonts_url = add_query_arg(array(
                'family' => urldecode(implode('|', $fonts)),
                'subset' => urldecode($subsets),
            ), 'https://fonts.googleapis.com/css');
        }
        return $fonts_url;
    }
endif;

/**
 * Enqueue scripts and styles.
 */
function blog_elite_scripts() {

    $min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

    wp_enqueue_style('font-awesome-v5', get_template_directory_uri().'/assets/lib/font-awesome-v5/css/all.css');
    wp_enqueue_style('bootstrap', get_template_directory_uri().'/assets/lib/bootstrap/css/bootstrap'.$min.'.css');
    wp_enqueue_style('animate', get_template_directory_uri() . '/assets/lib/animate/animate'. $min . '.css');
    wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/assets/lib/owl/owl.carousel'. $min . '.css');
    wp_enqueue_style('owl-theme', get_template_directory_uri() . '/assets/lib/owl/owl.theme.default'. $min . '.css');

    if ( is_child_theme() ) {
        wp_enqueue_style( 'blog-elite-parent-style', trailingslashit( get_template_directory_uri() ) . 'style.css' );
    }

    wp_enqueue_style( 'blog-elite-style', get_stylesheet_uri() );

    $fonts_url = blog_elite_fonts_url();
    if (!empty($fonts_url)) {
        wp_enqueue_style('blog-elite-google-fonts', $fonts_url, array(), null);
    }

    wp_enqueue_script('bootstrap', get_template_directory_uri().'/assets/lib/bootstrap/js/bootstrap'.$min.'.js', array('jquery'), '', true);
    wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/assets/lib/owl/owl.carousel'.$min.'.js', array('jquery'), '', true );

    $global_sticky_sidebar = blog_elite_get_option('sticky_sidebar');
    $front_page_sticky_sidebar = blog_elite_get_option('front_page_sticky_sidebar');

    if($front_page_sticky_sidebar || $global_sticky_sidebar){
        if($front_page_sticky_sidebar && !$global_sticky_sidebar){
            if(is_front_page()){
                wp_enqueue_script('sticky-sidebar', get_template_directory_uri().'/assets/lib/theia-sticky-sidebar/theia-sticky-sidebar'.$min.'.js', array('jquery'), '', true);
            }
        }elseif(!$front_page_sticky_sidebar && $global_sticky_sidebar){
            if(!is_front_page()){
                wp_enqueue_script('sticky-sidebar', get_template_directory_uri().'/assets/lib/theia-sticky-sidebar/theia-sticky-sidebar'.$min.'.js', array('jquery'), '', true);
            }
        }else{
            wp_enqueue_script('sticky-sidebar', get_template_directory_uri().'/assets/lib/theia-sticky-sidebar/theia-sticky-sidebar'.$min.'.js', array('jquery'), '', true);
        }
    }

    wp_enqueue_script( 'blog-elite-skip-link-focus-fix', get_template_directory_uri() . '/assets/saga/js/skip-link-focus-fix.js', array(), '', true );

    wp_enqueue_script( 'blog-elite-script', get_template_directory_uri() . '/assets/saga/js/script' . $min . '.js', array( 'jquery'), '', true );
    wp_localize_script('blog-elite-script', 'blogElite',array(
        'stickySidebarGlobal' => $global_sticky_sidebar,
        'stickySidebarFrontPage' => $front_page_sticky_sidebar
    ));

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'blog_elite_scripts' );

/**
 * Load all required files.
 */
require get_template_directory() . '/inc/init.php';



