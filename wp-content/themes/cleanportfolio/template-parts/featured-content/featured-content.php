<?php
/**
 * The template for displaying featured content
 *
  * @package Clean_Portfolio
 */

$def_content = 'disabled';
$def_type    = 'category';

if ( class_exists( 'Jetpack' ) ) {
	$def_content = 'homepage';
	$def_type    = 'tag';
}

$enable_content = get_theme_mod( 'cleanportfolio_featured_content_option', $def_content );

if ( ! cleanportfolio_check_section( $enable_content ) ) {
	// Bail if featured content is disabled.
	return;
}

$featured_posts = cleanportfolio_get_featured_posts();

if ( empty( $featured_posts ) ) {
	return;
}

$title     = get_option( 'featured_content_title', esc_html__( 'Featured', 'cleanportfolio' ) );
$sub_title = get_option( 'featured_content_content' );
?>

<div class="featured-content-wrapper section layout-three">

	<?php if ( '' != $title || $sub_title ) : ?>
		<div class="section-heading-wrap">
			<?php if ( '' != $title ) : ?>
			<h2 class="section-title"><?php echo wp_kses_post( $title ); ?></h2>
			<?php endif; ?>

			<?php if ( $sub_title ) : ?>
				<div class="section-subtitle"><?php echo wp_kses_post( $sub_title ); ?></div>
			<?php endif; ?>
		</div><!-- .section-heading-wrap -->
	<?php endif; ?>

	<div class="section-content-wrap">
		<?php
		foreach ( $featured_posts as $post ) {
			setup_postdata( $post );

			// Include the featured content template.
			get_template_part( 'template-parts/featured-content/content', 'featured-content' );
		}

		wp_reset_postdata();
		?>
	</div><!-- .section-content-wrap -->
</div><!-- .section -->
