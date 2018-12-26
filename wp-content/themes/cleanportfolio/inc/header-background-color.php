<?php
/**
 * Customizer functionality
 *
 * @package Clean_Portfolio
 */

/**
 * Sets up the WordPress core custom header and custom background features.
 *
 * @since Clean Portfolio 0.1
 *
 * @see cleanportfolio_header_style()
 */
function cleanportfolio_custom_header_and_background() {
	/**
	 * Filter the arguments used when adding 'custom-background' support in Clean Portfolio.
	 *
	 * @since Clean Portfolio 0.1
	 *
	 * @param array $args {
	 *     An array of custom-background support arguments.
	 *
	 *     @type string $default-color Default color of the background.
	 * }
	 */
	add_theme_support( 'custom-background', apply_filters( 'cleanportfolio_custom_background_args', array(
		'default-color' => '#f2f2f2',
	) ) );


	/**
	 * Filter the arguments used when adding 'custom-header' support in Clean Portfolio.
	 *
	 * @since Clean Portfolio 0.1
	 *
	 */
	add_theme_support( 'custom-header', apply_filters( 'cleanportfolio_custom_header_args', array(
		'default-text-color'     => '#555555',
		'width'                  => 1920,
		'height'                 => 1080,
		'flex-height'            => true,
		'flex-height'            => true,
		'wp-head-callback'       => 'cleanportfolio_header_style',
		'video'                  => true,
	) ) );
}
add_action( 'after_setup_theme', 'cleanportfolio_custom_header_and_background' );

/**
 * Customize video play/pause button in the custom header.
 */
function cleanportfolio_video_controls( $settings ) {
	$settings['l10n']['play'] = '<span class="screen-reader-text">' . esc_html__( 'Play background video', 'cleanportfolio' ) . '</span>' . cleanportfolio_get_svg( array( 'icon' => 'play' ) );
	$settings['l10n']['pause'] = '<span class="screen-reader-text">' . esc_html__( 'Pause background video', 'cleanportfolio' ) . '</span>' . cleanportfolio_get_svg( array( 'icon' => 'pause' ) );
	return $settings;
}
add_filter( 'header_video_settings', 'cleanportfolio_video_controls' );

if ( ! function_exists( 'cleanportfolio_header_style' ) ) :
/**
 * Styles the header text displayed on the site.
 *
 * Create your own cleanportfolio_header_style() function to override in a child theme.
 *
 * @since Clean Portfolio 0.1
 *
 * @see cleanportfolio_custom_header_and_background().
 */
function cleanportfolio_header_style() {
    $header_image = get_header_image();

    if ( $header_image ) : ?>
        <style type="text/css">
            .custom-header:before {
                background-image: url( <?php echo esc_url( $header_image ); ?>);
				background-position: center;
				background-repeat: no-repeat;
				background-size: cover;
				content: "";
				display: block;
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				z-index: -1;
            }
        </style>
    <?php
    endif;

	// If the header text option is untouched, let's bail.
	if ( display_header_text() ) {
		return;
	}

	// If the header text has been hidden.
	?>
	<style type="text/css" id="cleanportfolio-header-css">
		.site-branding {
			margin: 0 auto 0 0;
		}

		.site-branding-text {
			clip: rect(1px, 1px, 1px, 1px);
			position: absolute;
		}
	</style>
	<?php
}
endif; // cleanportfolio_header_style
