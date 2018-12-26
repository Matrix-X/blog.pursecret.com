<?php
/**
 * The template for displaying the Slider
 *
 * @package Clean_Portfolio
 */

if( !function_exists( 'cleanportfolio_featured_slider' ) ) :
/**
 * Add slider.
 *
 * @uses action hook cleanportfolio_before_content.
 *
 * @since Clean Portfolio 0.1
 */
function cleanportfolio_featured_slider() {
	$enable_slider = get_theme_mod( 'cleanportfolio_slider_option', 'disabled' );


	if ( cleanportfolio_check_section( $enable_slider ) ) {
		$slider_type       = get_theme_mod( 'cleanportfolio_slider_type', 'demo' );
		$transition_effect = get_theme_mod( 'cleanportfolio_slider_transition_effect', 'fade' );
		$transition_length = get_theme_mod( 'cleanportfolio_slider_transition_length', 1 );
		$transition_delay  = get_theme_mod( 'cleanportfolio_slider_transition_delay', 4 );
		$image_loader      = get_theme_mod( 'cleanportfolio_slider_image_loader', true );

		$output = '
			<div id="feature-slider" class="section">
				<div class="wrapper">
					<div class="cycle-slideshow"
					    data-cycle-log="false"
					    data-cycle-pause-on-hover="true"
					    data-cycle-swipe="true"
					    data-cycle-auto-height=container
					    data-cycle-fx="'. esc_attr( $transition_effect ) .'"
						data-cycle-speed="'. esc_attr( $transition_length * 1000 ) .'"
						data-cycle-timeout="'. esc_attr( $transition_delay * 1000 ) .'"
						data-cycle-loader=false
						data-cycle-slides="> article"
						>

					    <!-- prev/next links -->
					    <button class="cycle-prev" aria-label="Previous">' .cleanportfolio_get_svg( array( 'icon' => 'angle-down' ) ) . '</button>
					    <button class="cycle-next" aria-label="Next">' .cleanportfolio_get_svg( array( 'icon' => 'angle-down' ) ) . '</button>

					    <!-- empty element for pager links -->
    					<div class="cycle-pager"></div>';
						// Select Slider
						if ( 'demo' == $slider_type ) {
							$output .= cleanportfolio_demo_slider();
						} elseif ( 'page' == $slider_type ) {
							$output .= cleanportfolio_post_page_category_slider();
						}

		$output .= '
					</div><!-- .cycle-slideshow -->
				</div><!-- .wrapper -->
			</div><!-- #feature-slider -->';

		echo $output;
	}
}
endif;
add_action( 'cleanportfolio_slider', 'cleanportfolio_featured_slider', 10 );


if ( ! function_exists( 'cleanportfolio_demo_slider' ) ) :
	/**
	 * This function to display featured posts slider
	 *
	 * @get the data value from customizer options
	 *
	 * @since Clean Portfolio 0.1
	 *
	 */
	function cleanportfolio_demo_slider() {
		return '
		<article class="post demo-image-1 hentry slides displayblock">
			<div class="slider-image-wrapper">
				<div class="slider-image-thumbnail" style="background-image: url(' .esc_url( get_template_directory_uri() ).'/assets/images/slider1-1920x1080.jpg);"></div>
			</div>
			<div class="slider-content-wrapper">
				<div class="entry-container">
					<header class="entry-header">
						<h2 class="entry-title">
							<a href="#"><span>Mountain</span></a>
						</h2>
						<p class="entry-meta screen-reader-text">
							<span class="cat-links">
								<span class="screen-reader-text">Categories</span>
								<a rel="category tag" href="#">Travel</a>
							</span>
							<span class="posted-on">
								<span class="screen-reader-text">Posted on</span>

								<a rel="bookmark" href="#">
									<time datetime="2016-05-15T04:29:55+00:00" class="entry-date published">May 7, 2016</time>

									<time datetime="2016-05-08T08:47:27+00:00" class="updated">May 7, 2016</time>
								</a>
							</span>
						</p><!-- .entry-meta -->
					</header>
					<div class="entry-summary">
						<p><a href="#" class="more-link"><span>Continue reading</span></a></p>
					</div><!-- .entry-summary -->
				</div><!-- .entry-container -->
			</div><!-- .slider-content-wrapper -->
		</article><!-- .slides -->

		<article class="post demo-image-2 hentry slides displaynone">
			<div class="slider-image-wrapper">
				<div class="slider-image-thumbnail" style="background-image: url(' .esc_url( get_template_directory_uri() ).'/assets/images/slider2-1920x1080.jpg);"></div>
			</div>
			<div class="slider-content-wrapper">
				<div class="entry-container">
					<header class="entry-header">
						<h2 class="entry-title">
							<a href="#"><span>Ocean</span></a>
						</h2>
						<p class="entry-meta screen-reader-text">
							<span class="cat-links">
								<span class="screen-reader-text">Categories</span>
								<a rel="category tag" href="#">Travel</a>
							</span>
							<span class="posted-on">
								<span class="screen-reader-text">Posted on</span>

								<a rel="bookmark" href="#">
									<time datetime="2016-05-15T04:29:55+00:00" class="entry-date published">May 7, 2016</time>

									<time datetime="2016-05-08T08:47:27+00:00" class="updated">May 7, 2016</time>
								</a>
							</span>
						</p><!-- .entry-meta -->
					</header>
					<div class="entry-summary">
						<p><a href="#" class="more-link"><span>Continue reading</span></a></p>
					</div><!-- .entry-summary -->
				</div><!-- .entry-container -->
			</div><!-- .slider-content-wrapper -->
		</article><!-- .slides -->';
	}
endif; // cleanportfolio_demo_slider


if ( ! function_exists( 'cleanportfolio_post_page_category_slider' ) ) :
	/**
	 * This function to display featured posts/page/category slider
	 *
	 * @param $options: cleanportfolio_theme_options from customizer
	 *
	 * @since Clean Portfolio 0.1
	 */
	function cleanportfolio_post_page_category_slider() {
		$quantity     = get_theme_mod( 'cleanportfolio_slider_number', 4 );
		$no_of_post   = 0; // for number of posts
		$post_list    = array();// list of valid post/page ids
		$type         = get_theme_mod( 'cleanportfolio_slider_type' );
		$show_content = get_theme_mod( 'cleanportfolio_slider_content_show', 'excerpt' );
		$output     = '';

		$args = array(
			'post_type'           => 'page',
			'orderby'             => 'post__in',
			'ignore_sticky_posts' => 1 // ignore sticky posts
		);

		//Get valid number of posts
		for( $i = 1; $i <= $quantity; $i++ ){
			$post_id = get_theme_mod( 'cleanportfolio_slider_page_' . $i );

			if ( $post_id && '' != $post_id ) {
				$post_list = array_merge( $post_list, array( $post_id ) );

				$no_of_post++;
			}
		}

		$args['post__in'] = $post_list;

		if ( 0 == $no_of_post ) {
			return;
		}

		$args['posts_per_page'] = $no_of_post;

		$loop = new WP_Query( $args );

		while ( $loop->have_posts() ) :
			$loop->the_post();

			$title_attribute = the_title_attribute( 'echo=0' );

			if ( 0 == $loop->current_post ) {
				$classes = 'post post-' . esc_attr( get_the_ID() ) . ' hentry slides displayblock';
			} else {
				$classes = 'post post-' . esc_attr( get_the_ID() ) . ' hentry slides displaynone';
			}

			//Default value if there is no featurd image or first image
			$image_url = esc_url( get_template_directory_uri() ). '/assets/images/no-thumb-1920x1080.jpg';

			if ( has_post_thumbnail() ) {
				$image_url = get_the_post_thumbnail_url( get_the_ID(), 'post-thumbnail' );
			} else {
				//Get the first image in page, returns false if there is no image
				$first_image_url = cleanportfolio_get_first_image( get_the_ID(), 'post-thumbnail', '', true );

				//Set value of image as first image if there is an image present in the page
				if ( $first_image_url ) {
					$image_url = $first_image_url;
				}
			}

			$output .= '
			<article class="' . $classes . '">';
				$output .= '
				<div class="slider-image-wrapper">
					<div class="slider-image-thumbnail" style="background-image: url(' . esc_url( $image_url ) . ');"></div>
				</div><!-- .slider-image-wrapper -->

				<div class="slider-content-wrapper">
					<div class="entry-container">
						<header class="entry-header">
							<h2 class="entry-title">
								<a title="' . $title_attribute . '" href="' . esc_url( get_permalink() ) . '">'.the_title( '<span>','</span>', false ).'</a>
							</h2>
						</header>
							';

						if ( 'excerpt' == $show_content ) {
							$excerpt = get_the_excerpt();

							$output .= '<div class="entry-summary"><p>' . $excerpt . '</p></div><!-- .entry-summary -->';
						} elseif ( 'full-content' == $show_content ) {
							$content = apply_filters( 'the_content', get_the_content() );
							$content = str_replace( ']]>', ']]&gt;', $content );
							$output .= '<div class="entry-content">' . $content . '</div><!-- .entry-content -->';
						}

						$output .= '
					</div><!-- .entry-container -->
				</div><!-- .slider-content-wrapper -->
			</article><!-- .slides -->';
		endwhile;

		wp_reset_postdata();

		return $output;
	}
endif; // cleanportfolio_post_page_category_slider
