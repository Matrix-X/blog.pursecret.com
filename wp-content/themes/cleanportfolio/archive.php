<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
  * @package Clean_Portfolio
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<div class="archive-posts-wrapper">
				<?php
				if ( have_posts() ) : ?>

					<div class="archive-heading-wrapper">
						<header class="page-header">
							<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
						</header><!-- .page-header -->
						<div class="square"><?php echo cleanportfolio_get_svg( array( 'icon' => 'square' ) ); ?><span class="screen-reader-text"><?php esc_html_e( 'Square', 'cleanportfolio' ); ?></span></div>
						<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
					</div><!-- .archive-heading-wrapper -->

					<?php
					$blog_display	= get_option( 'jetpack_content_blog_display');

					if ( 'content' == $blog_display ) : ?>

						<div id="infinite-post-wrap" class="singular-content-wrap">
							<?php
							/* Start the Loop */
							while ( have_posts() ) : the_post();

								get_template_part( 'template-parts/content/content' );

							endwhile;
							?>
						</div><!-- .singular-content-wrap -->

					<?php else : ?>

						<div id="infinite-post-wrap" class="archive-post-wrap layout-three">
							<?php
							/* Start the Loop */
							while ( have_posts() ) : the_post();

								get_template_part( 'template-parts/content/content', 'archive' );

							endwhile;
							?>
						</div><!-- .archive-post-wrap -->

					<?php endif;

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
