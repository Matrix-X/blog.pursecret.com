<?php
/**
 * The template for displaying testimonial items
 *
 * @package Clean_Portfolio
 */
?>

<?php
$enable = get_theme_mod( 'cleanportfolio_testimonial_option', 'disabled' );

if ( ! cleanportfolio_check_section( $enable ) ) {
	// Bail if featured content is disabled
	return;
}

$type = get_theme_mod( 'cleanportfolio_testimonial_type', 'demo' );

// Get Jetpack options for testimonial.
$jetpack_defaults = array(
	'page-title' => esc_html__( 'Testimonials', 'cleanportfolio' ),
);

// Get Jetpack options for testimonial.
$jetpack_options = get_theme_mod( 'jetpack_testimonials', $jetpack_defaults );

$headline = isset( $jetpack_options['page-title'] ) ? $jetpack_options['page-title'] : '';

$subheadline = isset( $jetpack_options['page-content'] ) ? $jetpack_options['page-content'] : '';

$classes[] = 'section testimonial-wrapper';

$classes[] = 'layout-three';

if ( ! $headline && ! $subheadline ) {
	$classes[] = 'no-headline';
}

?>

<div class="<?php echo esc_attr( implode( ' ', $classes ) ) ?>">
	<?php if ( $headline || $subheadline ) : ?>
		<div class="section-heading-wrap">
			<?php if ( $headline ) : ?>
				<h2 class="section-title"><?php echo wp_kses_post( $headline ); ?></h2>
			<?php endif; ?>
			<?php if ( $subheadline ) : ?>
				<div class="taxonomy-description-wrapper section-subtitle">
					<?php echo wp_kses_post( $subheadline ); ?>
				</div><!-- .taxonomy-description-wrapper -->
			<?php endif; ?>
		</div><!-- .section-heading-wrap -->
	<?php endif; ?>

	<div class="section-content-wrap">
		<?php get_template_part( 'template-parts/testimonial/post-types', 'testimonial' ); ?>
	</div><!-- .section-content-wrap -->
</div><!-- .testimonial-wrapper -->
