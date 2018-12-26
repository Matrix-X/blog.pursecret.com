<?php
/**
 * Jetpack Compatibility File
 *
 * @link https://jetpack.com/
 *
  * @package Clean_Portfolio
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.com/support/infinite-scroll/
 * See: https://jetpack.com/support/responsive-videos/
 */
function cleanportfolio_jetpack_setup() {
	/**
	 * Setup Infinite Scroll using JetPack if navigation type is set
	 */
	$def_pagination = 'default';

    if ( class_exists( 'Jetpack' ) ) {
        $def_pagination = 'infinite-scroll';
    }

	$pagination_type = get_theme_mod( 'cleanportfolio_pagination_type', $def_pagination );

	if( 'infinite-scroll' == $pagination_type ) {
		add_theme_support( 'infinite-scroll', array(
			'container'      => '#infinite-post-wrap',
			'posts_per_page' => 12,
			'wrapper'        => false,
			'render'         => 'cleanportfolio_infinite_scroll_render',
			'footer'         => false,
			'footer_widgets' => array( 'sidebar-2', 'sidebar-3', 'sidebar-4', ),
		) );
	}

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );

	/*
	 * Adding theme support for Jetpack Portfolio CPT.
	 * Not essential to add this but this does a few nice things.
	 * 1. Turns the CPT on when the theme is activated.
	 * 2. Displays an admin notice if the option is turned off, but the theme is activated.
	 * 3. When the theme is switched away, if no CPTs are populated, it turns it back off.
	 */
	add_theme_support( 'jetpack-portfolio', array(
		'title'          => true,
		'content'        => true,
		'featured-image' => true,
	) );

	// Add theme support for testimonials.
	add_theme_support( 'jetpack-testimonial' );
}
add_action( 'after_setup_theme', 'cleanportfolio_jetpack_setup' );

/**
 * JetPack
 * @param  [type] $wp_customize [description]
 * @return [type]               [description]
 */
function cleanportfolio_jetpack_options( $wp_customize ) {
	if( class_exists( 'Jetpack' ) && current_theme_supports( 'jetpack-content-options' ) ) {
		$wp_customize->get_setting( 'jetpack_content_blog_display' )->transport = 'refresh';
	}
}
add_action( 'customize_register', 'cleanportfolio_jetpack_options', 200 );

/**
 * Custom render function for Infinite Scroll.
 */
function cleanportfolio_infinite_scroll_render() {
	$blog_display	= get_option( 'jetpack_content_blog_display');

	while ( have_posts() ) {
		the_post();

		if ( is_search() ) :
			get_template_part( 'template-parts/content/content', 'search' );
		elseif ( is_post_type_archive( 'jetpack-portfolio' ) ) :
			get_template_part( 'template-parts/portfolio/content', 'portfolio' );
		else :
			if ( 'content' == $blog_display ) :
				get_template_part( 'template-parts/content/content' );
			else :
				get_template_part( 'template-parts/content/content', 'archive' );
			endif;
		endif;
	}
}

/**
 * Return early if Author Bio is not available.
 */
function cleanportfolio_author_bio() {
	if ( ! function_exists( 'jetpack_author_bio' ) ) {
		return;
	} else {
		jetpack_author_bio();
	}
}

/**
 * Author Bio Avatar Size.
 */
function cleanportfolio_author_bio_avatar_size() {
	return 90;
}
add_filter( 'jetpack_author_bio_avatar_size', 'cleanportfolio_author_bio_avatar_size' );


/**
 * Portfolio Title.
 */
function cleanportfolio_portfolio_title( $before = '', $after = '' ) {
	$jetpack_portfolio_title = get_option( 'jetpack_portfolio_title' );
	$title = '';

	if ( is_post_type_archive( 'jetpack-portfolio' ) ) {
		if ( isset( $jetpack_portfolio_title ) && '' != $jetpack_portfolio_title ) {
			$title = esc_html( $jetpack_portfolio_title );
		} else {
			$title = post_type_archive_title( '', false );
		}
	} elseif ( is_tax( 'jetpack-portfolio-type' ) || is_tax( 'jetpack-portfolio-tag' ) ) {
		$title = single_term_title( '', false );
	}

	echo $before . $title . $after;
}

/**
 * Portfolio Content.
 */
function cleanportfolio_portfolio_content( $before = '', $after = '' ) {
	$jetpack_portfolio_content = get_option( 'jetpack_portfolio_content' );

	if ( is_tax() && get_the_archive_description() ) {
		echo $before . get_the_archive_description() . $after;
	} else if ( isset( $jetpack_portfolio_content ) && '' != $jetpack_portfolio_content ) {
		$content = convert_chars( convert_smilies( wptexturize( stripslashes( wp_kses_post( addslashes( $jetpack_portfolio_content ) ) ) ) ) );
		echo $before . $content . $after;
	}
}


/**
 * Show/Hide Featured Image outside of the loop.
 */
function cleanportfolio_jetpack_featured_image_display() {
	$id = null;

	/**
	 * Disable header image if page/post does not have featured image
	 * Check $id for shop page
	 */
	if ( ! has_post_thumbnail( $id ) ) {
		return false;
	}

	/**
	 * Disable header image if not in singular page or shop page
	 */
	if ( ! is_singular() ) {
		return false;
	}

	/**
	 * Disable header image on front page
	 */
	if ( cleanportfolio_is_frontpage() ) {
		return false;
	}

	/**
	 * Disable header image on WooCommerce Products page
	 */
	if ( function_exists( 'is_product' ) && is_product() ) {
		return false;
	}

	if ( ! function_exists( 'jetpack_featured_images_remove_post_thumbnail' ) ) {
        return true;
    } else {
        $options         = get_theme_support( 'jetpack-content-options' );
        $featured_images = ( ! empty( $options[0]['featured-images'] ) ) ? $options[0]['featured-images'] : null;

        $settings = array(
            'post-default' => ( isset( $featured_images['post-default'] ) && false === $featured_images['post-default'] ) ? '' : 1,
            'page-default' => ( isset( $featured_images['page-default'] ) && false === $featured_images['page-default'] ) ? '' : 1,
        );

        $settings = array_merge( $settings, array(
            'post-option'  => get_option( 'jetpack_content_featured_images_post', $settings['post-default'] ),
            'page-option'  => get_option( 'jetpack_content_featured_images_page', $settings['page-default'] ),
        ) );

        if ( ( ! $settings['post-option'] && is_single() )
            || ( ! $settings['page-option'] && is_singular() && is_page() ) ) {
            return false;
        } else {
            return true;
        }
    }
}
