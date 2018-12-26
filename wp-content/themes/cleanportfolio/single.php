<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
  * @package Clean_Portfolio
 */

get_header(); ?>

	<div id="primary" class="content-area">

		<main id="main" class="site-main" role="main">

			<div class="singular-content-wrap">
				<?php
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/content/content', 'single' );

					get_template_part( 'template-parts/content/content', 'comment' );

				endwhile; // End of the loop.
				?>
			</div><!-- #single-content-wrap -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
