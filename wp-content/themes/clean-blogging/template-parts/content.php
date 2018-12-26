<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package clean-blogging
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( ! is_single() && has_post_thumbnail( $post->ID ) ) : ?>
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

	<?php elseif ( ! is_single() && ! has_post_thumbnail( $post->ID ) ) : ?>

			<header class="entry-header">
				<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

				<?php if ( 'post' === get_post_type() ) : ?>
					<div class="entry-meta">
						<?php clean_blogging_posted_on(); ?>
					</div><!-- .entry-meta -->
				<?php endif; ?>
			</header>

	<?php else : ?>

		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

			<?php if ( 'post' === get_post_type() ) : ?>
				<div class="entry-meta">
					<?php clean_blogging_posted_on(); ?>
				</div><!-- .entry-meta -->
			<?php endif; ?>
		</header>

	<?php endif; ?>
	<!-- Enclosure 1 ends here -->

	<div class="entry-content">
		<?php
		if ( is_single() ) :
			the_content();
		else :
			the_excerpt();

		endif;
			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'clean-blogging' ),
					'after'  => '</div>',
				)
			);
		?>
	</div><!-- .entry-content -->
	<?php if ( is_single() ) : ?>
		<footer class="entry-footer">
			<?php clean_blogging_entry_footer(); ?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
