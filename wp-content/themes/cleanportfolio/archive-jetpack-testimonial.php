<?php
/**
 * The template for displaying the Testimonials archive page.
 *
  * @package Clean_Portfolio
 */

get_header();

$jetpack_options = get_theme_mod( 'jetpack_testimonials' ); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<div class="archive-posts-wrapper testimonial-wrapper">

			<div class="archive-heading-wrapper">
				<header class="page-header">
					<h1 class="page-title">
						<?php
						if ( isset( $jetpack_options['page-title'] ) && '' !== $jetpack_options['page-title'] ) {
							echo esc_html( $jetpack_options['page-title'] );
						} else {
							esc_html_e( 'Testimonials', 'cleanportfolio' );
						}
						?>
					</h1>
				</header>
				<div class="square"><?php echo cleanportfolio_get_svg( array( 'icon' => 'square' ) ); ?><span class="screen-reader-text"><?php esc_html_e( 'Square', 'cleanportfolio' ); ?></span></div>

				<?php
				if ( isset( $jetpack_options['page-content'] ) && '' !== $jetpack_options['page-content'] ) { ?>
					<div class="archive-description">
						<?php echo convert_chars( convert_smilies( wptexturize( stripslashes( wp_kses_post( addslashes( $jetpack_options['page-content'] ) ) ) ) ) ); ?>
					</div>
				<?php
				}
				?>
			</div><!-- .archive-heading-wrapper -->

			<?php if ( have_posts() ) : ?>

				<div id="infinite-post-wrap" class="archive-post-testimonials archive-post-wrap layout-three">

					<?php
						while ( have_posts() ) : the_post();
							get_template_part( 'template-parts/testimonial/content', 'testimonial' );
						endwhile;
					?>

				</div><!-- #infinite-post-wrap -->

				<?php
				cleanportfolio_content_nav();

			endif;
			wp_reset_postdata();
			?>

		</div><!-- .archive-posts-wrapper -->

	</main><!-- #main -->
</div><!-- #primary -->
<?php
get_sidebar();
get_footer();
