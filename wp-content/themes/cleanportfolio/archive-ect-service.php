<?php
/**
* The template for displaying the Service archive page.
 *
  * @package Clean_Portfolio
 */
get_header();
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>
			<div class="archive-posts-wrapper service-wrapper">
				<?php
				$headline       = get_option( 'ect_service_title', esc_html__( 'Services', 'cleanportfolio' ) );
				$subheadline    = get_option( 'ect_service_content' );
				?>
				<?php if ( ! empty( $headline ) || ! empty( $subheadline ) ) : ?>
					<div class="archive-heading-wrapper">
						<?php if ( ! empty( $headline ) ) { ?>
							<header class="page-header">
								<h1 class="page-title">
									<?php echo esc_html( $headline ); ?>
								</h1>
							</header>
						<?php
						} ?>

						<div class="square"><?php echo cleanportfolio_get_svg( array( 'icon' => 'square' ) ); ?><span class="screen-reader-text"><?php esc_html_e( 'Square', 'cleanportfolio' ); ?></span></div>
						<?php if ( ! empty( $subheadline ) ) { ?>
							<div class="archive-description">
								<?php echo wp_kses_post( $subheadline ); ?>
							</div>
						<?php 
						} ?>
					</div><!-- .archive-heading-wrapper -->
				<?php endif; ?>

				<div id="infinite-post-wrap" class="archive-post-service archive-post-wrap <?php  echo esc_attr( get_theme_mod( 'cleanportfolio_archive_column_layout', 'layout-three' ) ); ?>">

					<?php
					while ( have_posts() ) : the_post();
						get_template_part( 'template-parts/service/content-archive', 'service' );
					endwhile;
					?>

				</div><!-- #infinite-post-wrap -->

				<?php cleanportfolio_content_nav(); ?>

			</div><!-- .archive-posts-wrapper -->

			<?php else :

				get_template_part( 'template-parts/content/content', 'none' );

			endif; ?>

	</main><!-- #main -->
</div><!-- #primary -->
<?php
get_sidebar();
get_footer();
