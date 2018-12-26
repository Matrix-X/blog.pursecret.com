<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
  * @package Clean_Portfolio
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function cleanportfolio_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( is_singular() ) {
		$classes[] = 'singular';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	if ( has_custom_header() && is_front_page() ) {
		$classes[] = 'has-header-media';
	}

	// Adds a class of navigation-(default|classic) to blogs.
	$classes[] = 'navigation-classic';

	// Adds a class of (full-width|box) to blogs.
	if ( 'boxed' === get_theme_mod( 'cleanportfolio_layout_type' ) ) {
		$classes[] = 'boxed-layout';
	} else {
		$classes[] = 'full-width-layout';
	}

	// Adds a class with respect to layout selected.
	$layout  = cleanportfolio_get_theme_layout();
	$sidebar = cleanportfolio_get_sidebar_id();

	if ( 'no-sidebar-full-width' === $layout ) {
		$classes[] = 'no-sidebar full-width';
	} elseif ( 'left-sidebar' === $layout ) {
		if ( '' !== $sidebar ) {
			$classes[] = 'two-columns content-right';
		}
	} elseif ( 'right-sidebar' === $layout ) {
		if ( '' !== $sidebar ) {
			$classes[] = 'two-columns content-left';
		}
	}

	return $classes;
}
add_filter( 'body_class', 'cleanportfolio_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function cleanportfolio_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'cleanportfolio_pingback_header' );

/**
 * Checks to see if we're on the homepage or not.
 */
function cleanportfolio_is_frontpage() {
	return ( is_front_page() && ! is_home() );
}

/**
 * Remove first post from blog as it is already show via recent post template
 */
function cleanportfolio_alter_home( $query ) {
	if ( ( $query->is_home() && is_front_page() ) && $query->is_main_query() ) {
		$cats = get_theme_mod( 'cleanportfolio_front_page_category' );

		if ( is_array( $cats ) && ! in_array( '0', $cats ) ) {
			$query->query_vars['category__in'] = $cats;
		}
	}
}
add_action( 'pre_get_posts', 'cleanportfolio_alter_home' );

/**
 * Function to add Scroll Up icon
 */
function cleanportfolio_scrollup() {
	if ( class_exists( 'To_Top' ) ) {
		// Bail early if To Top plugin is activated
		return;
	}

	$cleanportfolio_disable_scrollup = get_theme_mod( 'cleanportfolio_disable_scrollup' );

	if ( $cleanportfolio_disable_scrollup ) {
		return;
	}

	echo '<a href="#masthead" id="scrollup">' .cleanportfolio_get_svg( array( 'icon' => 'angle-down' ) ) . '<span class="screen-reader-text">' . esc_html__( 'Scroll Up', 'cleanportfolio' ) . '</span></a>' ;

}
add_action( 'wp_footer', 'cleanportfolio_scrollup', 1 );

function cleanportfolio_get_sidebar_id() {
	$sidebar = '';

	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$sidebar = 'sidebar-1'; // Primary Sidebar
	}

	return $sidebar;
}

function cleanportfolio_get_theme_layout() {
	$layout = '';

	if ( is_page_template( 'templates/no-sidebar.php' ) ) {
		 $layout = 'no-sidebar';
	} elseif ( is_page_template( 'templates/full-width-page.php' ) ) {
		 $layout = 'no-sidebar-full-width';
	} elseif ( is_page_template( 'templates/left-sidebar.php' ) ) {
		$layout = 'left-sidebar';
	} elseif ( is_page_template( 'templates/right-sidebar.php' ) ) {
		$layout = 'right-sidebar';
	} else {
		$layout = get_theme_mod( 'cleanportfolio_default_layout', 'right-sidebar' );

		if ( is_home() || is_archive() ) {
			$layout = get_theme_mod( 'cleanportfolio_homepage_archive_layout', 'no-sidebar-full-width' );
		}
	}

	return $layout;
}

if ( ! function_exists( 'cleanportfolio_excerpt_length' ) ) :
	/**
	 * Sets the post excerpt length to n words.
	 *
	 * function tied to the excerpt_length filter hook.
	 * @uses filter excerpt_length
	 *
	 * @since Clean Portfolio 0.1
	 */
	function cleanportfolio_excerpt_length( $length ) {
		if ( is_admin() ) {
			return $length;
		}

		// Getting data from Customizer Options
		$length	= get_theme_mod( 'cleanportfolio_excerpt_length', 30 );
		return absint( $length );
	}
endif; //cleanportfolio_excerpt_length
add_filter( 'excerpt_length', 'cleanportfolio_excerpt_length' );


/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and a option from customizer.
 * @return string option from customizer prepended with an ellipsis.
 */
if ( ! function_exists( 'cleanportfolio_excerpt_more' ) ) :
	function cleanportfolio_excerpt_more( $more ) {
		if ( is_admin() ) {
			return $more;
		}

		$more_tag_text	= get_theme_mod( 'cleanportfolio_excerpt_more_text',  esc_html__( 'Continue reading', 'cleanportfolio' ) );

		$link = sprintf( '<a href="%1$s" class="more-link"><span>%2$s</span></a>',
			esc_url( get_permalink( get_the_ID() ) ),
			/* translators: %s: Name of current post */
			wp_kses_data( $more_tag_text ). '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span>'
			);

		return ' &hellip; ' . $link;
	}
endif;
add_filter( 'excerpt_more', 'cleanportfolio_excerpt_more' );


if ( ! function_exists( 'cleanportfolio_custom_excerpt' ) ) :
	/**
	 * Adds Continue reading link to more tag excerpts.
	 *
	 * function tied to the get_the_excerpt filter hook.
	 *
	 * @since Clean Portfolio 0.1
	 */
	function cleanportfolio_custom_excerpt( $output ) {

		if ( has_excerpt() && ! is_attachment() ) {
			$more_tag_text = get_theme_mod( 'cleanportfolio_excerpt_more_text', esc_html__( 'Continue reading', 'cleanportfolio' ) );

			$link = sprintf( '<a href="%1$s" class="more-link"><span>%2$s</span></a>',
			esc_url( get_permalink( get_the_ID() ) ),
			/* translators: %s: Name of current post */
			wp_kses_data( $more_tag_text ). '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span>'
			);

			$link = ' &hellip; ' . $link;

			$output .= $link;
		}

		return $output;
	}
endif; //cleanportfolio_custom_excerpt
add_filter( 'get_the_excerpt', 'cleanportfolio_custom_excerpt' );


if ( ! function_exists( 'cleanportfolio_more_link' ) ) :
	/**
	 * Replacing Continue reading link to the_content more.
	 *
	 * function tied to the the_content_more_link filter hook.
	 *
	 * @since Clean Portfolio 0.1
	 */
	function cleanportfolio_more_link( $more_link, $more_link_text ) {
		$more_tag_text = get_theme_mod( 'cleanportfolio_excerpt_more_text', esc_html__( 'Continue reading', 'cleanportfolio' ) );

		return ' &hellip; ' . str_replace( $more_link_text, wp_kses_data( $more_tag_text ), $more_link );
	}
endif; //cleanportfolio_more_link
add_filter( 'the_content_more_link', 'cleanportfolio_more_link', 10, 2 );


if ( ! function_exists( 'cleanportfolio_content_nav' ) ) :
	/**
	 * Display navigation/pagination when applicable
	 *
	 * @since Clean Portfolio 0.1
	 */
	function cleanportfolio_content_nav() {
		global $wp_query, $post;

		// Don't print empty markup on single pages if there's nowhere to navigate.
		if ( is_single() ) {
			$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
			$next = get_adjacent_post( false, '', false );

			if ( ! $next && ! $previous )
				return;
		}

		// Don't print empty markup in archives if there's only one page.
		if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) ) {
			return;
		}

		$def_pagination = 'default';

		if ( class_exists( 'Jetpack' ) ) {
			$def_pagination = 'infinite-scroll';
		}

		$pagination_type = get_theme_mod( 'cleanportfolio_pagination_type', $def_pagination );

		/**
		 * Check if navigation type is Jetpack Infinite Scroll and if it is enabled, else goto default pagination
		 * if it's active then disable pagination
		 */
		if ( 'infinite-scroll' == $pagination_type && class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) {
			return false;
		}

		/**
		 * Check if navigation type is numeric and if Wp-PageNavi Plugin is enabled
		 */
		if ( 'numeric' == $pagination_type && function_exists( 'the_posts_pagination' ) ) {
			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => esc_html__( 'Previous', 'cleanportfolio' ),
				'next_text'          => esc_html__( 'Next', 'cleanportfolio' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'cleanportfolio' ) . ' </span>',
			) );
		}
		else {
			the_posts_navigation();
		}
	}
endif; // cleanportfolio_content_nav


/**
 * Check if a section is enabled or not based on the $value parameter
 * @param  string $value Value of the section that is to be checked
 * @return boolean return true if section is enabled otherwise false
 */
function cleanportfolio_check_section( $value ) {
	global $wp_query;

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();

	// Front page displays in Reading Settings
	$page_for_posts = get_option('page_for_posts');

	return ( 'entire-site' == $value  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $value ) );
}

/**
 * Return the first image in a post. Works inside a loop.
 * @param [integer] $post_id [Post or page id]
 * @param [string/array] $size Image size. Either a string keyword (thumbnail, medium, large or full) or a 2-item array representing width and height in pixels, e.g. array(32,32).
 * @param [string/array] $attr Query string or array of attributes.
 * @return [string] image html
 *
 * @since Clean Portfolio 0.1
 */

function cleanportfolio_get_first_image( $postID, $size, $attr ) {
	ob_start();

	ob_end_clean();

	$image 	= '';

	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_post_field('post_content', $postID ) , $matches);

	if( isset( $matches [1] [0] ) ) {
		//Get first image
		$first_img = $matches [1] [0];

		return '<img class="pngfix wp-post-image" src="'. esc_url( $first_img ) .'">';
	}

	return false;
}

if ( ! function_exists( 'cleanportfolio_truncate_phrase' ) ) :
	/**
	 * Return a phrase shortened in length to a maximum number of characters.
	 *
	 * Result will be truncated at the last white space in the original string. In this function the word separator is a
	 * single space. Other white space characters (like newlines and tabs) are ignored.
	 *
	 * If the first `$max_characters` of the string does not contain a space character, an empty string will be returned.
	 *
	 * @since Clean Portfolio 0.1
	 *
	 * @param string $text            A string to be shortened.
	 * @param integer $max_characters The maximum number of characters to return.
	 *
	 * @return string Truncated string
	 */
	function cleanportfolio_truncate_phrase( $text, $max_characters ) {

		$text = trim( $text );

		if ( mb_strlen( $text ) > $max_characters ) {
			//* Truncate $text to $max_characters + 1
			$text = mb_substr( $text, 0, $max_characters + 1 );

			//* Truncate to the last space in the truncated string
			$text = trim( mb_substr( $text, 0, mb_strrpos( $text, ' ' ) ) );
		}

		return $text;
	}
endif; //cleanportfolio_truncate_phrase


if ( ! function_exists( 'cleanportfolio_get_the_content_limit' ) ) :
	/**
	 * Return content stripped down and limited content.
	 *
	 * Strips out tags and shortcodes, limits the output to `$max_char` characters, and appends an ellipsis and more link to the end.
	 *
	 * @since Clean Portfolio 0.1
	 *
	 * @param integer $max_characters The maximum number of characters to return.
	 * @param string  $more_link_text Optional. Text of the more link. Default is "(more...)".
	 * @param bool    $stripteaser    Optional. Strip teaser content before the more text. Default is false.
	 *
	 * @return string Limited content.
	 */
	function cleanportfolio_get_the_content_limit( $max_characters, $more_link_text = '(more...)', $stripteaser = false ) {

		$content = get_the_content( '', $stripteaser );

		//* Strip tags and shortcodes so the content truncation count is done correctly
		$content = strip_tags( strip_shortcodes( $content ), apply_filters( 'get_the_content_limit_allowedtags', '<script>,<style>' ) );

		//* Remove inline styles / scripts
		$content = trim( preg_replace( '#<(s(cript|tyle)).*?</\1>#si', '', $content ) );

		//* Truncate $content to $max_char
		$content = cleanportfolio_truncate_phrase( $content, $max_characters );

		//* More link?
		if ( $more_link_text ) {
			$link   = apply_filters( 'get_the_content_more_link', sprintf( '<span class="more-button"><a href="%s" class="more-link">%s</a></span>', esc_url( get_permalink() ), $more_link_text ), $more_link_text );
			$output = sprintf( '<p>%s %s</p>', $content, $link );
		} else {
			$output = sprintf( '<p>%s</p>', $content );
			$link = '';
		}

		return apply_filters( 'cleanportfolio_get_the_content_limit', $output, $content, $link, $max_characters );

	}
endif; //cleanportfolio_get_the_content_limit

/**
 * Featured Content Getter Function
 */
function cleanportfolio_get_featured_posts() {
	$number = get_theme_mod( 'cleanportfolio_featured_content_number', 3 );

	$post_list    = array();

	$args = array(
		'posts_per_page'      => $number,
		'post_type'           => 'featured-content',
		'orderby'             => 'post__in',
		'ignore_sticky_posts' => 1 // ignore sticky posts
	);

	// Get valid number of posts.
	for ( $i = 1; $i <= $number; $i++ ) {
		$post_id = get_theme_mod( 'cleanportfolio_featured_content_cpt_' . $i );

		if ( $post_id && '' !== $post_id ) {
			$post_list = array_merge( $post_list, array( $post_id ) );
		}
	}

	$args['post__in'] = $post_list;

	$featured_posts = get_posts( $args );

	return $featured_posts;
}


/**
 * Converts a HEX value to RGB.
 *
 * @since Clean Portfolio 0.1
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
function cleanportfolio_hex2rgb( $color ) {
	$color = trim( $color, '#' );

	if ( strlen( $color ) === 3 ) {
		$r = hexdec( substr( $color, 0, 1 ).substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ).substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ).substr( $color, 2, 1 ) );
	} else if ( strlen( $color ) === 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}

	return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}
