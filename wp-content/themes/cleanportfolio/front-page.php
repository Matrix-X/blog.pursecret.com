<?php
/**
 * The static front page template
 *
  * @package Clean_Portfolio
 */

if ( 'posts' === get_option( 'show_on_front' ) ) :

	get_template_part( 'index' );

else :

	get_header(); ?>

		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

				<?php
					while ( have_posts() ) : the_post();

						get_template_part( 'template-parts/content/content', 'page' );

						get_template_part( 'template-parts/content/content', 'comment' );

					endwhile; // End of the loop.
				if ( get_theme_mod( 'cleanportfolio_enable_static_page_posts' ) ) { ?>
					<div class="archive-posts-wrapper section">
						<div class="section-heading-wrap">
							<h2 class="section-title"><?php esc_html_e( 'Recent Posts', 'cleanportfolio' ); ?></h2>
						</div><!-- .section-heading-wrap -->

						<?php get_template_part( 'template-parts/recent-posts/front-recent', 'posts' ); ?>
					</div><!-- .archive-posts-wrapper -->
				<?php
				} ?>

			</main><!-- #main -->
		</div><!-- #primary -->

		<?php get_sidebar();

get_footer();

endif;
