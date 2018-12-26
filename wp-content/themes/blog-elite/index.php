<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Blog_Elite
 */

get_header();
$archive_style = blog_elite_get_option('archive_style');
set_query_var( 'archive_style', $archive_style );

if(!is_paged() && is_front_page()){
    /**
     * Functions hooked into blog_elite_home_before_widget_area action
     *
     * @hooked blog_elite_home_banner - 10
     * @hooked blog_elite_above_homepage_widget_region - 20
     *
     */
    do_action('blog_elite_home_before_widget_area');
}
?>
<div class="saga-container site-main-wrap">
	<div id="primary" class="content-area <?php echo esc_attr($archive_style);?>">
		<main id="main" class="site-main">

        <?php
        if(!is_paged() && is_front_page()){
            /*Home page widget area*/
            if (is_active_sidebar('home-page-widget-area')) {
                ?>
                <div class="homepage-widgetarea general-widget-area">
                    <?php dynamic_sidebar('home-page-widget-area'); ?>
                </div>
                <?php
            }
        }
        ?>
		<?php
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) :
				?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
				<?php
			endif;

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_type() );

			endwhile;

            blog_elite_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

    <?php get_sidebar();?>
</div>
<?php

if(!is_paged() && is_front_page()){
    /**
     * Functions hooked into blog_elite_home_after_widget_area action
     *
     * @hooked blog_elite_below_homepage_widget_region - 10
     *
     */
    do_action('blog_elite_home_after_widget_area');
}
get_footer();