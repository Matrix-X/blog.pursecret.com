<?php
/**
 * The template for displaying portfolio items
 *
 * @package Clean_Portfolio
 */
?>

<?php
$enable = get_theme_mod( 'cleanportfolio_portfolio_option', 'disabled' );

if ( ! cleanportfolio_check_section( $enable ) ) {
	// Bail if portfolio section is disabled.
	return;
}

$headline    = get_option( 'jetpack_portfolio_title', esc_html__( 'Projects', 'cleanportfolio' ) );
$subheadline = get_option( 'jetpack_portfolio_content' );
?>
	<div class="portfolio-wrapper section layout-three">
		<?php if ( $headline || $subheadline  ) : ?>
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

		<div class="section-content-wrap layout-three">
			<?php get_template_part( 'template-parts/portfolio/post-types', 'portfolio' ); ?>
		</div><!-- .section-content-wrap -->
	</div><!-- .portfolio-wrapper -->
