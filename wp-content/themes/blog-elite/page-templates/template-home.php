<?php
/**
 * The template for displaying the homepage.
 *
 * Template Name: Home Page
 *
 * @package Blog_Elite
 * @since 1.0.0
 */

get_header();


/*If latest post is enabled on homepage and is paged then bail out other sections on homepage*/
$enable_posts_in_front_page = blog_elite_get_option('enable_posts_in_front_page');
if($enable_posts_in_front_page){
    if(is_paged()){
        ?>
        <div class="saga-container site-main-wrap">
            <div id="primary" class="content-area">
                <main id="main" class="site-main" role="main">
                    <?php blog_elite_front_page_posts();?>
                </main><!-- #main -->
            </div><!-- #primary -->
            <?php get_sidebar();?>
        </div>
        <?php
        get_footer();
        return;
    }
}
/**/
?>

<?php
/**
 * Functions hooked into blog_elite_home_before_widget_area action
 *
 * @hooked blog_elite_home_banner - 10
 * @hooked blog_elite_above_homepage_widget_region - 20
 *
 */
do_action('blog_elite_home_before_widget_area');
?>
    <div class="saga-container site-main-wrap">
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">
                <?php
                /*Home page widget area*/
                if (is_active_sidebar('home-page-widget-area')) {
                    $heading_style = blog_elite_get_general_heading_style();
                    $heading_align = blog_elite_get_general_heading_align();
                    ?>
                    <div class="homepage-widgetarea general-widget-area <?php echo esc_attr($heading_style).' '.esc_attr($heading_align);?>">
                        <?php dynamic_sidebar('home-page-widget-area'); ?>
                    </div>
                    <?php
                }
                ?>
                <?php
                global $post;
                $wrapper_start = '<section class="section-block be-page-content">';
                $wrapper_end = '</section>';
                if (is_front_page()):
                    if( $post->post_content == '') {
                        $wrapper_start = '<section class="section-block be-page-content empty-content">';
                    }
                endif;
                while ( have_posts() ) :  the_post(); ?>
                    <?php echo wp_kses_post($wrapper_start);?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <?php blog_elite_post_thumbnail(); ?>
                            <div class="entry-content">
                                <?php
                                the_content();
                                wp_link_pages( array(
                                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'blog-elite' ),
                                    'after'  => '</div>',
                                ) );
                                ?>
                            </div><!-- .entry-content -->
                            <?php if ( get_edit_post_link() ) : ?>
                                <footer class="entry-footer">
                                    <?php
                                    edit_post_link(
                                        sprintf(
                                            wp_kses(
                                            /* translators: %s: Name of current post. Only visible to screen readers */
                                                __( 'Edit <span class="screen-reader-text">%s</span>', 'blog-elite' ),
                                                array(
                                                    'span' => array(
                                                        'class' => array(),
                                                    ),
                                                )
                                            ),
                                            get_the_title()
                                        ),
                                        '<span class="edit-link">',
                                        '</span>'
                                    );
                                    ?>
                                </footer><!-- .entry-footer -->
                            <?php endif; ?>
                        </article><!-- #post-<?php the_ID(); ?> -->
                    <?php echo wp_kses_post($wrapper_end);?>
                <?php endwhile; wp_reset_postdata();/*End of the loop.*/ ?>

                <?php
                /*Latest Posts*/
                $enable_posts_in_front_page = blog_elite_get_option('enable_posts_in_front_page');
                if($enable_posts_in_front_page){
                    blog_elite_front_page_posts();
                }
                /**/
                ?>
            </main><!-- #main -->
        </div><!-- #primary -->
        <?php get_sidebar();?>
    </div>
<?php
/**
 * Functions hooked into blog_elite_home_after_widget_area action
 *
 * @hooked blog_elite_below_homepage_widget_region - 10
 *
 */
do_action('blog_elite_home_after_widget_area');

get_footer();