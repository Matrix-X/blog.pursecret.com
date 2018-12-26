<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Blog_Elite
 */

get_header();
?>
<div class="saga-container site-main-wrap">
    <main id="main" class="site-main">
        <section class="error-404 not-found">
            <header class="page-header">
                <h1 class="page-title">
                    <?php esc_html_e( '404', 'blog-elite' ); ?>
                </h1>
            </header><!-- .page-header -->

            <div class="page-content">
                <p>
                <?php esc_html_e( 'Oops! That page can&rsquo;t be found.Maybe try search?', 'blog-elite' ); ?>
                <?php get_search_form();?>
                <div class="go-back">
                    <a href="<?php echo esc_url( home_url('/'))?>" rel="home">
                        <i class="fas fa-home"></i>
                        <?php _e('Return to Homepage','blog-elite');?>
                    </a>
                </div>
            </div><!-- .page-content -->
        </section><!-- .error-404 -->
    </main><!-- #main -->
</div>
<?php
get_footer();