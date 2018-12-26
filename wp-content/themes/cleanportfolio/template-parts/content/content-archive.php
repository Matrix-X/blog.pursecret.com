<?php
/**
 * Template part for displaying Posts in the front page template and archive pages
 *
  * @package Clean_Portfolio
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="post-thumbnail archive-thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'cleanportfolio-featured' ); ?>
			</a>
			<?php if ( 'post' === get_post_type() ) :
				get_template_part( 'template-parts/content/content', 'meta' );
			endif; ?>
		</div>
	<?php endif; ?>

	<div class="entry-container">

		<header class="entry-header">
			<?php
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			?>
		</header>

		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div>

		<?php cleanportfolio_entry_footer(); ?>

	</div><!-- .entry-container -->

</article><!-- #post-## -->
