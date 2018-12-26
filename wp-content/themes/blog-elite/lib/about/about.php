<?php
/**
 * About setup
 *
 * @package Blog_Elite
 */

if ( ! function_exists( 'blog_elite_about_setup' ) ) :

	/**
	 * About setup.
	 *
	 * @since 1.0.0
	 */
	function blog_elite_about_setup() {

        $config = array(

			// Welcome content.
			'welcome_content' => sprintf( esc_html__( '%1$s is now installed and ready to use. We want to make sure you have the best experience using the theme and that is why we gathered here all the necessary information for you. Thanks for using our theme!', 'blog-elite' ), 'Blog Elite' ),

			// Tabs.
			'tabs' => array(
				'getting-started' => esc_html__( 'Getting Started', 'blog-elite' ),
				'useful-plugins'  => esc_html__( 'Useful Plugins', 'blog-elite' ),
                'free-vs-pro'  => esc_html__( 'Free Vs Pro', 'blog-elite' ),
            ),

			// Quick links.
			'quick_links' => array(
                'theme_url' => array(
                    'text' => esc_html__( 'Theme Details', 'blog-elite' ),
                    'url'  => 'https://themesaga.com/theme/blog-elite/',
                ),
                'demo_url' => array(
                    'text' => esc_html__( 'View Demo', 'blog-elite' ),
                    'url'  => 'https://themesaga.com/blog-elite-demos/',
                ),
                'documentation_url' => array(
                    'text'   => esc_html__( 'View Documentation', 'blog-elite' ),
                    'url'    => 'https://docs.themesaga.com/blog-elite/',
                ),
                'view_pro' => array(
                    'text'   => esc_html__( 'View Pro', 'blog-elite' ),
                    'url'    => 'http://themesaga.com/blog-elite-pro',
                    'button' => 'primary',
                ),
                'rate_url'  => array(
                    'text' => __('Rate This Theme','blog-elite'),
                    'url' => 'https://wordpress.org/support/theme/blog-elite/reviews/?filter=5'
                ),
            ),

			// Getting started.
			'getting_started' => array(
				'one' => array(
					'title'       => esc_html__( 'Theme Documentation', 'blog-elite' ),
					'icon'        => 'dashicons dashicons-format-aside',
					'description' => esc_html__( 'Please check our full documentation for detailed information on how to setup and customize the theme.', 'blog-elite' ),
					'button_text' => esc_html__( 'View Documentation', 'blog-elite' ),
					'button_url'  => 'https://docs.themesaga.com/blog-elite/',
					'button_type' => 'link',
					'is_new_tab'  => true,
                ),
                'two' => array(
                    'title'       => esc_html__( 'Widget Options', 'blog-elite' ),
                    'icon'        => 'dashicons dashicons-admin-customizer',
                    'description' => esc_html__( 'Theme uses widgetareas and widget to display content on homepage. Different combination of widgets and widgetareas will make your site unique.', 'blog-elite' ),
                    'button_text' => esc_html__( 'Get Started', 'blog-elite' ),
                    'button_url'  => admin_url('widgets.php'),
                    'button_type' => 'primary',
                ),
				'three' => array(
					'title'       => esc_html__( 'Theme Options', 'blog-elite' ),
					'icon'        => 'dashicons dashicons-admin-customizer',
					'description' => esc_html__( 'Theme uses Customizer API for theme options. Using the Customizer you can easily customize different aspects of the theme.', 'blog-elite' ),
					'button_text' => esc_html__( 'Customize', 'blog-elite' ),
					'button_url'  => wp_customize_url(),
					'button_type' => 'primary',
                ),
				'four' => array(
					'title'       => esc_html__( 'Demo Content', 'blog-elite' ),
					'icon'        => 'dashicons dashicons-layout',
					'description' => sprintf( esc_html__( 'To import sample demo content, %1$s plugin should be installed and activated. After plugin is activated, visit Import Demo Data menu under Appearance.', 'blog-elite' ), esc_html__( 'One Click Demo Import', 'blog-elite' ) ),
                ),
				'five' => array(
					'title'       => esc_html__( 'Theme Preview', 'blog-elite' ),
					'icon'        => 'dashicons dashicons-welcome-view-site',
					'description' => esc_html__( 'You can check out the theme demos for reference to find out what you can achieve using the theme and how it can be customized.', 'blog-elite' ),
					'button_text' => esc_html__( 'View Demo', 'blog-elite' ),
					'button_url'  => 'https://themesaga.com/blog-elite-demos/',
					'button_type' => 'link',
					'is_new_tab'  => true,
                ),
                'six' => array(
                    'title'       => esc_html__( 'Contact Support', 'blog-elite' ),
                    'icon'        => 'dashicons dashicons-sos',
                    'description' => esc_html__( 'Got theme support question or found bug or got some feedbacks? Best place to ask your query is the dedicated Support forum for the theme.', 'blog-elite' ),
                    'button_text' => esc_html__( 'Contact Support', 'blog-elite' ),
                    'button_url'  => 'https://themesaga.com/support/',
                    'button_type' => 'link',
                    'is_new_tab'  => true,
                ),
            ),

			// Useful plugins.
			'useful_plugins' => array(
				'description' => esc_html__( 'Theme supports some helpful WordPress plugins to enhance your site. But, please enable only those plugins which you need in your site. For example, enable WooCommerce only if you are using e-commerce.', 'blog-elite' ),
            ),

            // Free vs Pro
            'free_vs_pro' => array(
                array(
                    'title'=> __( 'Header Style', 'blog-elite' ),
                    'desc' => __( 'Header Options and Styles', 'blog-elite' ),
                    'free_text' => '<span class="dashicons dashicons-yes"></span>'.__('2 Styles','blog-elite'),
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>'.__('4 Styles','blog-elite'),
                ),
                array(
                    'title'=> __( 'Banner slider and Carousel', 'blog-elite' ),
                    'desc' => __( 'Option to show homepage carousel or slider', 'blog-elite' ),
                    'free_text' => '<span class="dashicons dashicons-yes"></span>',
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>'.__('More features & Control Options','blog-elite'),
                ),
                array(
                    'title'=> __( 'Site layout Options', 'blog-elite' ),
                    'desc' => __( 'Options to change site layout ', 'blog-elite' ),
                    'free_text' => '<span class="dashicons dashicons-yes"></span>',
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>'.__('Features like site width, sidebar width, sidebar gutter & more','blog-elite'),
                ),
                array(
                    'title'=> __( 'Menu Styles', 'blog-elite' ),
                    'desc' => __( 'Options to change primary menu styles', 'blog-elite' ),
                    'free_text' => '<span class="dashicons dashicons-no-alt"></span>',
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>',
                ),
                array(
                    'title'=> __( 'Widget title styles', 'blog-elite' ),
                    'desc' => __( 'Options to change widget title styles', 'blog-elite' ),
                    'free_text' => '<span class="dashicons dashicons-yes"></span>'.__('2 styles','blog-elite'),
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>'.__('9 styles','blog-elite'),
                ),
                array(
                    'title'=> __( 'Typography Options', 'blog-elite' ),
                    'desc' => __( 'Options to change the fonts family and font sizes of the site', 'blog-elite' ),
                    'free_text' => '<span class="dashicons dashicons-no-alt"></span>',
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>'.__('(100+ Google Fonts)','blog-elite'),
                ),
                array(
                    'title'=> __( 'Color Options', 'blog-elite' ),
                    'desc' => __( 'Options to change the colors of multiple sections of the site ', 'blog-elite' ),
                    'free_text' => '<span class="dashicons dashicons-no-alt"></span>',
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>',
                ),
                array(
                    'title'=> __( 'Single Post Options', 'blog-elite' ),
                    'desc' => __( 'Multiple single post styles plus related and author posts options', 'blog-elite' ),
                    'free_text' => '<span class="dashicons dashicons-no-alt"></span>',
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>',
                ),
                array(
                    'title'=> __( 'Archive Layout', 'blog-elite' ),
                    'desc' => __( 'Options to change the layout of archive pages', 'blog-elite' ),
                    'free_text' => '<span class="dashicons dashicons-yes"></span>'.__('2 Layouts','blog-elite'),
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>'.__('6 Layouts','blog-elite'),
                ),
                array(
                    'title'=> __( 'Archive Layout option on each category and tag', 'blog-elite' ),
                    'desc' => __( 'Options to select different archive style for each category and tag', 'blog-elite' ),
                    'free_text' => '<span class="dashicons dashicons-no-alt"></span>',
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>',
                ),
                array(
                    'title'=> __( 'Archive First post special styles', 'blog-elite' ),
                    'desc' => __( 'Special style for the first post on archive page', 'blog-elite' ),
                    'free_text' => '<span class="dashicons dashicons-no-alt"></span>',
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>'.__('4 Styles','blog-elite'),
                ),
                array(
                    'title'=> __( 'Ajax Load Posts', 'blog-elite' ),
                    'desc' => __( 'Options to load archive posts by ajax on click or on scroll', 'blog-elite' ),
                    'free_text' => '<span class="dashicons dashicons-no-alt"></span>',
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>',
                    ),
                array(
                    'title'=> __( 'Widget Options', 'blog-elite' ),
                    'desc' => __( 'Provides Multiple Theme Widgets', 'blog-elite' ),
                    'free_text' => '<span class="dashicons dashicons-yes"></span>'.__('4+ Widgets','blog-elite'),
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>'.__('13+ Widgets','blog-elite'),
                ),
                array(
                    'title'=> __( 'Instagram Options', 'blog-elite' ),
                    'desc' => __( 'Show your instagram images in grid', 'blog-elite' ),
                    'free_text' => '<span class="dashicons dashicons-no-alt"></span>',
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>',
                ),
            ),

        );

        Blog_Elite_About::init( $config );
	}

endif;

add_action( 'after_setup_theme', 'blog_elite_about_setup' );
