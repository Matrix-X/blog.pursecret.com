<?php
/**
 * The template used for displaying testimonial on front page
 *
 * @package Clean_Portfolio
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="testimonial-thumbnail post-thumbnail">
			<?php the_post_thumbnail( 'cleanportfolio-testimonial' ); ?>
		</div>
	<?php endif; ?>

	<div class="entry-content">
		<?php the_excerpt(); ?>
	</div>

	<?php $position = get_post_meta( get_the_id(), 'ect_testimonial_position', true ); ?>

	<header class="entry-header">
		<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' ); ?>

		<?php if ( $position ) : ?>
			<p class="entry-meta"><span class="position"><?php echo esc_html( $position ); ?></span></p>
		<?php endif; ?>
	</header>
</article>
