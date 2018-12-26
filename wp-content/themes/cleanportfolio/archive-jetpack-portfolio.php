<?php
/**
* The template for displaying the Portfolio archive page.
 *
  * @package Clean_Portfolio
 */
get_header();
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>
			<div class="archive-posts-wrapper portfolio-wrapper">

				<div class="archive-heading-wrapper">
					<header class="page-header">
						<?php cleanportfolio_portfolio_title( '<h1 class="page-title">', '</h1>' ); ?>
					</header>
					<div class="square"><?php echo cleanportfolio_get_svg( array( 'icon' => 'square' ) ); ?><span class="screen-reader-text"><?php esc_html_e( 'Square', 'cleanportfolio' ); ?></span></div>
					<?php cleanportfolio_portfolio_content( '<div class="archive-description">', '</div>' ); ?>
				</div><!-- .archive-heading-wrapper -->

				<div id="infinite-post-wrap" class="archive-post-portfolio archive-post-wrap layout-three">

					<?php
					while ( have_posts() ) : the_post();
						get_template_part( 'template-parts/portfolio/content', 'portfolio' );
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
