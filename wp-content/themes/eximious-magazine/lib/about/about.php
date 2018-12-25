<?php
/**
 * About setup
 *
 * @package Eximious_Magazine
 */

if ( ! function_exists( 'eximious_magazine_about_setup' ) ) :

	/**
	 * About setup.
	 *
	 * @since 1.0.0
	 */
	function eximious_magazine_about_setup() {

        $config = array(

			// Welcome content.
			'welcome_content' => sprintf( esc_html__( '%1$s is now installed and ready to use. We want to make sure you have the best experience using the theme and that is why we gathered here all the necessary information for you. Thanks for using our theme!', 'eximious-magazine' ), 'Eximious Magazine' ),

			// Tabs.
			'tabs' => array(
				'getting-started' => esc_html__( 'Getting Started', 'eximious-magazine' ),
				'useful-plugins'  => esc_html__( 'Useful Plugins', 'eximious-magazine' ),
                'free-vs-pro'  => esc_html__( 'Free Vs Pro', 'eximious-magazine' ),
            ),

			// Quick links.
			'quick_links' => array(
                'theme_url' => array(
                    'text' => esc_html__( 'Theme Details', 'eximious-magazine' ),
                    'url'  => 'https://themesaga.com/theme/eximious-magazine/',
                ),
                'demo_url' => array(
                    'text' => esc_html__( 'View Demo', 'eximious-magazine' ),
                    'url'  => 'https://themesaga.com/eximious-magazine-demos/',
                ),
                'documentation_url' => array(
                    'text'   => esc_html__( 'View Documentation', 'eximious-magazine' ),
                    'url'    => 'https://docs.themesaga.com/eximious-magazine/',
                ),
                'view_pro' => array(
                    'text'   => esc_html__( 'View Pro', 'eximious-magazine' ),
                    'url'    => 'http://themesaga.com/eximious-magazine-pro',
                    'button' => 'primary',
                ),
                'rate_url'  => array(
                    'text' => __('Rate This Theme','eximious-magazine'),
                    'url' => 'https://wordpress.org/support/theme/eximious-magazine/reviews/?filter=5'
                ),
            ),

			// Getting started.
			'getting_started' => array(
				'one' => array(
					'title'       => esc_html__( 'Theme Documentation', 'eximious-magazine' ),
					'icon'        => 'dashicons dashicons-format-aside',
					'description' => esc_html__( 'Please check our full documentation for detailed information on how to setup and customize the theme.', 'eximious-magazine' ),
					'button_text' => esc_html__( 'View Documentation', 'eximious-magazine' ),
					'button_url'  => 'https://docs.themesaga.com/eximious-magazine/',
					'button_type' => 'link',
					'is_new_tab'  => true,
                ),
                'two' => array(
                    'title'       => esc_html__( 'Widget Options', 'eximious-magazine' ),
                    'icon'        => 'dashicons dashicons-admin-customizer',
                    'description' => esc_html__( 'Theme uses widgetareas and widget to display content on homepage. Different combination of widgets and widgetareas will make your site unique.', 'eximious-magazine' ),
                    'button_text' => esc_html__( 'Get Started', 'eximious-magazine' ),
                    'button_url'  => admin_url('widgets.php'),
                    'button_type' => 'primary',
                ),
				'three' => array(
					'title'       => esc_html__( 'Theme Options', 'eximious-magazine' ),
					'icon'        => 'dashicons dashicons-admin-customizer',
					'description' => esc_html__( 'Theme uses Customizer API for theme options. Using the Customizer you can easily customize different aspects of the theme.', 'eximious-magazine' ),
					'button_text' => esc_html__( 'Customize', 'eximious-magazine' ),
					'button_url'  => wp_customize_url(),
					'button_type' => 'primary',
                ),
				'four' => array(
					'title'       => esc_html__( 'Demo Content', 'eximious-magazine' ),
					'icon'        => 'dashicons dashicons-layout',
					'description' => sprintf( esc_html__( 'To import sample demo content, %1$s plugin should be installed and activated. After plugin is activated, visit Import Demo Data menu under Appearance.', 'eximious-magazine' ), esc_html__( 'One Click Demo Import', 'eximious-magazine' ) ),
                ),
				'five' => array(
					'title'       => esc_html__( 'Theme Preview', 'eximious-magazine' ),
					'icon'        => 'dashicons dashicons-welcome-view-site',
					'description' => esc_html__( 'You can check out the theme demos for reference to find out what you can achieve using the theme and how it can be customized.', 'eximious-magazine' ),
					'button_text' => esc_html__( 'View Demo', 'eximious-magazine' ),
					'button_url'  => 'https://themesaga.com/eximious-magazine-demos/',
					'button_type' => 'link',
					'is_new_tab'  => true,
                ),
                'six' => array(
                    'title'       => esc_html__( 'Contact Support', 'eximious-magazine' ),
                    'icon'        => 'dashicons dashicons-sos',
                    'description' => esc_html__( 'Got theme support question or found bug or got some feedbacks? Best place to ask your query is the dedicated Support forum for the theme.', 'eximious-magazine' ),
                    'button_text' => esc_html__( 'Contact Support', 'eximious-magazine' ),
                    'button_url'  => 'https://themesaga.com/support/',
                    'button_type' => 'link',
                    'is_new_tab'  => true,
                ),
            ),

			// Useful plugins.
			'useful_plugins' => array(
				'description' => esc_html__( 'Theme supports some helpful WordPress plugins to enhance your site. But, please enable only those plugins which you need in your site. For example, enable WooCommerce only if you are using e-commerce.', 'eximious-magazine' ),
            ),

            // Free vs Pro
            'free_vs_pro' => array(
                array(
                    'title'=> __( 'Slider Animation', 'eximious-magazine' ),
                    'desc' => __( 'Homepage Banner Slider Animation and Settings Plus Cateogry, Title, Description and Buttons Animation', 'eximious-magazine' ),
                    'free_text' => '<span class="dashicons dashicons-no-alt"></span>',
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>',
                ),
                array(
                    'title'=> __( 'Banner as Carousel', 'eximious-magazine' ),
                    'desc' => __( 'Option to show homepage carousel instead of slider', 'eximious-magazine' ),
                    'free_text' => '<span class="dashicons dashicons-no-alt"></span>',
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>',
                ),
                array(
                    'title'=> __( 'Typography Options', 'eximious-magazine' ),
                    'desc' => __( 'Options to change the fonts family and font sizes of the site', 'eximious-magazine' ),
                    'free_text' => '<span class="dashicons dashicons-no-alt"></span>',
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>'.__('(100+ Google Fonts)','eximious-magazine'),
                ),
                array(
                    'title'=> __( 'Color Options', 'eximious-magazine' ),
                    'desc' => __( 'Options to change the colors of multiple sections of the site ', 'eximious-magazine' ),
                    'free_text' => '<span class="dashicons dashicons-no-alt"></span>',
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>',
                ),
                array(
                    'title'=> __( 'Archive Layout', 'eximious-magazine' ),
                    'desc' => __( 'Options to change the layout of archive pages', 'eximious-magazine' ),
                    'free_text' => '<span class="dashicons dashicons-yes"></span>'.__('2 Layouts','eximious-magazine'),
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>'.__('6 Layouts','eximious-magazine'),
                ),
                array(
                    'title'=> __( 'Archive Layout option on each category and tag', 'eximious-magazine' ),
                    'desc' => __( 'Options to select different archive style for each category and tag', 'eximious-magazine' ),
                    'free_text' => '<span class="dashicons dashicons-no-alt"></span>',
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>',
                ),
                array(
                    'title'=> __( 'Ajax Load Posts', 'eximious-magazine' ),
                    'desc' => __( 'Options to load archive posts by ajax on click or on scroll', 'eximious-magazine' ),
                    'free_text' => '<span class="dashicons dashicons-no-alt"></span>',
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>',
                    ),
                array(
                    'title'=> __( 'Widget Options', 'eximious-magazine' ),
                    'desc' => __( 'Provides Multiple Theme Widgets', 'eximious-magazine' ),
                    'free_text' => '<span class="dashicons dashicons-yes"></span>'.__('9+ Widgets','eximious-magazine'),
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>'.__('19+ Widgets','eximious-magazine'),
                ),
                array(
                    'title'=> __( 'Mailchimp Options', 'eximious-magazine' ),
                    'desc' => __( 'Supports mailchimp plugin providing a clean desing for the newsletter form', 'eximious-magazine' ),
                    'free_text' => '<span class="dashicons dashicons-no-alt"></span>',
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>',
                ),
                array(
                    'title'=> __( 'Instagram Options', 'eximious-magazine' ),
                    'desc' => __( 'Show your instagram images in grid', 'eximious-magazine' ),
                    'free_text' => '<span class="dashicons dashicons-no-alt"></span>',
                    'pro_text'  => '<span class="dashicons dashicons-yes"></span>',
                ),
            ),

        );

        Eximious_Magazine_About::init( $config );
	}

endif;

add_action( 'after_setup_theme', 'eximious_magazine_about_setup' );
