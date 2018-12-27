<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Eximious_Magazine
 */

get_header();
?>
<div class="container">
	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'eximious-magazine' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p>
                    <?php _e( 'It looks like nothing was found at this location. Maybe try search?', 'eximious-magazine' ); ?></p>
					<?php get_search_form();?>
					<div class="go-back">
                        <?php printf(__('Go back to %s','eximious-magazine'),'<a href="'.esc_url( home_url('/')).'" rel="home">'.__('Homepage','eximious-magazine').'</a>');?>
                    </div>
				</div><!-- .page-content -->
                <?php
                $query_args = array(
                    'posts_per_page' => 6,
                    'post_status' => 'publish',
                    'no_found_rows' => 1,
                    'ignore_sticky_posts' => 1
                );
                $posts = new WP_Query($query_args);
                if($posts->have_posts()){
                    ?>
                    <div class="widget_recent_posts_with_image">
                        <span class="widget-title">
                            <span><?php _e('Some Recent Posts', 'eximious-magazine');?></span>
                        </span>
                        <div class="eximious_magazine_recent_posts">
                        <?php while ($posts->have_posts()):$posts->the_post();?>
                            <div class="article-block-wrapper clearfix">
                                <?php
                                if (has_post_thumbnail()) {
                                    ?>
                                    <div class="entry-image">
                                        <a href="<?php the_permalink() ?>">
                                            <?php
                                            the_post_thumbnail( 'thumbnail', array(
                                                'alt' => the_title_attribute( array(
                                                    'echo' => false,
                                                ) ),
                                            ) );
                                            ?>
                                        </a>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="article-details">
                                    <h3 class="entry-title">
                                        <a href="<?php the_permalink() ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h3>
                                    <div class="em-meta-info">
                                        <div class="em-post-date">
                                            <?php echo esc_html(get_the_date());?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile;wp_reset_postdata();?>
                        </div>
                    </div>
                <?php } ?>
			</section><!-- .error-404 -->
		</main><!-- #main -->
	</div><!-- #primary -->
</div>
<?php
get_footer();
