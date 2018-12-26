<?php
/**
 * The template used for displaying projects on index view
 *
 * @package Clean_Portfolio
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> class="hentry">
	<div class="portfolio-thumbnail post-thumbnail">
		<a class="post-thumbnail" href="<?php the_permalink(); ?>">
			<?php
			// Output the featured image.
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'cleanportfolio-featured' );
			} else {
				echo '<a href=' . esc_url( get_permalink() ) .'><img src="' . trailingslashit( esc_url( get_template_directory_uri() ) ) . 'assets/images/no-thumb.jpg"/></a>';
			}
			?>
		</a>
	</div><!-- .portfolio-thumbnail -->

	<div class="entry-container">
		<header class="entry-header portfolio-entry-header">
			<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

			<?php
			$portfolio_categories_list = get_the_term_list( get_the_ID(), 'jetpack-portfolio-type', '<span class="entry-meta portfolio-entry-meta">', esc_html_x(', ', 'Used between list items, there is a space after the comma.', 'cleanportfolio' ), '</span>' );

			if ( ! is_wp_error( $portfolio_categories_list ) ) {
			    echo $portfolio_categories_list;
			}
			?>
		</header>
	</div><!-- .entry-container -->
</article>
