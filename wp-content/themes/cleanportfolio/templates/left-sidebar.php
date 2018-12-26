<?php
/*
 * Template Name: Left Sidebar ( Primary Sidebar, Content )
 *
 * Template Post Type: post, page
 *
 * The template for displaying Page/Post with Sidebar on Left
 *
  * @package Clean_Portfolio
 */

get_header(); ?>

    <div id="primary" class="content-area">

        <main id="main" class="site-main" role="main">

            <div class="singular-content-wrap">
                <?php
                while ( have_posts() ) : the_post();

                    if ( 'page' === get_post_type() ) {
                        get_template_part( 'template-parts/content/content', 'page' );
                    } else {
                        get_template_part( 'template-parts/content/content', 'single' );
                    }

                    get_template_part( 'template-parts/content/content', 'comment' );

                endwhile; // End of the loop.
                ?>
            </div><!-- #single-content-wrap -->
        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_sidebar();
get_footer();
