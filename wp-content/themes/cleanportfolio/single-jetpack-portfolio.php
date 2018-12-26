<?php
/**
 * The Template for displaying all single portfolio posts
 *
 * @package Clean_Portfolio
 */

get_header(); ?>

	<div id="primary" class="content-area">

		<main id="main" class="site-main" role="main">

			<div class="singular-content-wrap">
				<?php
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/portfolio/content', 'portfolio-single' );

					get_template_part( 'template-parts/content/content', 'comment' );

				endwhile; // End of the loop.
				?>
			</div><!-- #single-content-wrap -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
