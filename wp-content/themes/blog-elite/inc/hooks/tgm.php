<?php
/**
 * Recommended plugins
 *
 * @package Blog_Elite
 */
if ( ! function_exists( 'blog_elite_recommended_plugins' ) ) :
	/**
	 * Recommend plugins.
	 *
	 * @since 1.0.0
	 */
	function blog_elite_recommended_plugins() {
		$plugins = array(
			array(
				'name'     => esc_html__( 'One Click Demo Import', 'blog-elite' ),
				'slug'     => 'one-click-demo-import',
				'required' => false,
			),
            array(
                'name'     => esc_html__( 'WP Post Author', 'blog-elite' ),
                'slug'     => 'wp-post-author',
                'required' => false,
            ),
            array(
                'name'     => esc_html__( 'Contact Form by WPForms', 'blog-elite' ),
                'slug'     => 'wpforms-lite',
                'required' => false,
            ),
		);
		tgmpa( $plugins );
	}
endif;
add_action( 'tgmpa_register', 'blog_elite_recommended_plugins' );