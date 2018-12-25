<?php
/**
 * Recommended plugins
 *
 * @package Eximious_Magazine
 */
if ( ! function_exists( 'eximious_magazine_recommended_plugins' ) ) :
	/**
	 * Recommend plugins.
	 *
	 * @since 1.0.0
	 */
	function eximious_magazine_recommended_plugins() {
		$plugins = array(
			array(
				'name'     => esc_html__( 'One Click Demo Import', 'eximious-magazine' ),
				'slug'     => 'one-click-demo-import',
				'required' => false,
			),
            array(
                'name'     => esc_html__( 'WP Post Author', 'eximious-magazine' ),
                'slug'     => 'wp-post-author',
                'required' => false,
            ),
		);
		tgmpa( $plugins );
	}
endif;
add_action( 'tgmpa_register', 'eximious_magazine_recommended_plugins' );