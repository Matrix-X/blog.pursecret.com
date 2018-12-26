<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
  * @package Clean_Portfolio
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<div class="archive-posts-wrapper section">
				<?php
				if ( have_posts() ) : ?>
					<div class="section-heading-wrap">
						<h2 class="section-title"><?php esc_html_e( 'Recent Posts', 'cleanportfolio' ); ?></h2>
					</div><!-- .archive-heading-wrapper -->

					<div id="infinite-post-wrap" class="archive-post-wrap layout-three">
						<?php
						/* Start the Loop */
						while ( have_posts() ) : the_post();

							get_template_part( 'template-parts/content/content', 'archive' );

						endwhile;
						?>
					</div><!-- .archive-post-wrap -->

					<?php
					cleanportfolio_content_nav();

				else :

					get_template_part( 'template-parts/content/content', 'none' );

				endif; ?>
			</div><!-- .archive-posts-wrapper -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
