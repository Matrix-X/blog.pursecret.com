<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package clean-blogging
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( has_post_thumbnail( $post->ID ) ) : ?>
		<!-- Enclosure 1 if_condition -->
		<div class="entry-header-wrapper">
			<?php
				echo '<figure class="post-thumbnail"><a href=" ' . esc_url( get_permalink( $post->ID ) ) . '">';
				the_post_thumbnail( 'clean_blogging_home_featured' );
				echo '</a></figure>';
			?>
			<header class="entry-header has-thumb">
				<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

				<?php if ( 'post' === get_post_type() ) : ?>
					<div class="entry-meta">
						<?php clean_blogging_posted_on(); ?>
					</div><!-- .entry-meta -->
				<?php endif; ?>
			</header>
		</div>

	<?php else : ?>

			<header class="entry-header">
				<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

				<?php if ( 'post' === get_post_type() ) : ?>
					<div class="entry-meta">
						<?php clean_blogging_posted_on(); ?>
					</div><!-- .entry-meta -->
				<?php endif; ?>
			</header>

	<?php endif; ?>

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
</article><!-- #post-## -->
