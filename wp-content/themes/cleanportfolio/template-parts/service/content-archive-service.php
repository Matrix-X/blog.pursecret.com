<?php
/**
 * The template used for displaying projects on index view
 *
 * @package Clean_Portfolio
 */
?>

<?php
$show_content = get_theme_mod( 'cleanportfolio_service_show', 'hide-content' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> class="hentry">
	<div class="portfolio-thumbnail post-thumbnail">
		<a class="post-thumbnail" href="<?php the_permalink(); ?>">
			<?php
			$layout = get_theme_mod( 'cleanportfolio_portfolio_content_layout', 'layout-three' );

			$image = '<img src="' . trailingslashit( esc_url( get_template_directory_uri() ) ) . 'assets/images/no-thumb.jpg"/>';

			if ( 'layout-two' === $layout ) {
				$image     = '<img class="wp-post-image" src="' . trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/images/no-thumb-960x960.jpg" >';
			}

			// Output the featured image.
			if ( has_post_thumbnail() ) {
				$thumbnail = 'cleanportfolio-featured';

				if ( 'layout-two' === $layout ) {
					$thumbnail = 'cleanportfolio-featured-large';
				}

				the_post_thumbnail( $thumbnail );
			} else {
				echo '<a href=' . esc_url( get_permalink() ) .'>' . $image . '</a>';
			}
			?>
		</a>
	</div><!-- .portfolio-thumbnail -->

	<div class="entry-container">
		<header class="entry-header portfolio-entry-header">
			<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

			<?php
			if ( 'ect-service' === get_post_type() ) {
				$portfolio_categories_list = get_the_term_list( get_the_ID(), 'ect-service-type', '<span class="entry-meta service-entry-meta">', esc_html_x(', ', 'Used between list items, there is a space after the comma.', 'cleanportfolio' ), '</span>' );

				if ( ! is_wp_error( $portfolio_categories_list ) ) {
				    echo $portfolio_categories_list;
				}
			} else {
				$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'cleanportfolio' ) );
				if ( $categories_list && cleanportfolio_categorized_blog() ) {
					printf( '<span class="entry-meta portfolio-entry-meta">%1$s%2$s</span>',
						sprintf( _x( '<span class="screen-reader-text">Categories: </span>', 'Used before category names.', 'cleanportfolio' ) ),
						$categories_list
					);
				}
			}
			?>
		</header>

		<?php
		if ( 'excerpt' === $show_content ) {
			$excerpt = get_the_excerpt();

			echo '<div class="entry-summary"><p>' . $excerpt . '</p></div><!-- .entry-summary -->';
		} elseif ( 'full-content' === $show_content ) {
			$content = apply_filters( 'the_content', get_the_content() );
			$content = str_replace( ']]>', ']]&gt;', $content );
			echo '<div class="entry-content">' . $content . '</div><!-- .entry-content -->';
		} ?>
	</div><!-- .entry-container -->
</article>
