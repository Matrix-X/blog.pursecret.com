<?php
/**
 * The template for displaying featured posts on the front page
 *
  * @package Clean_Portfolio
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="featured-content-thumbnail post-thumbnail">
		<a class="post-thumbnail" href="<?php the_permalink(); ?>">
			<?php
			$layout = 'layout-three';

			$image = '<img src="' . trailingslashit( esc_url( get_template_directory_uri() ) ) . 'assets/images/no-thumb.jpg"/>';

			// Output the featured image.
			if ( has_post_thumbnail() ) {
				$thumbnail = 'cleanportfolio-featured';

				the_post_thumbnail( $thumbnail );
			} else {
				echo '<a href=' . esc_url( get_permalink() ) .'>' . $image . '</a>';
			}
			?>
		</a>
	</div><!-- .portfolio-thumbnail -->

	<div class="entry-container">
		<header class="entry-header featured-content-entry-header">
			<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' ); ?>
			<?php cleanportfolio_entry_categories(); ?>
		</header>
	</div><!-- .entry-container -->

</article>
