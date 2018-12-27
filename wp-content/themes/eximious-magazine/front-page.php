<?php
/**
 * The template for displaying the homepage.
 *
 * @package Eximious_Magazine
 */

get_header();

$enable_front_page_content = eximious_magazine_get_option('enable_front_page_content');

/*If latest post is enabled on homepage and is paged then bail out other sections on homepage*/
$show_on_front = get_option('show_on_front');
if($enable_front_page_content){
    if('posts' == $show_on_front ){
        if(is_paged()){
            ?>
            <div class="container">
                <div id="primary" class="content-area">
                    <main id="main" class="site-main" role="main">
                        <?php eximious_magazine_front_page_content();?>
                    </main><!-- #main -->
                </div><!-- #primary -->
                <?php
                $page_layout = eximious_magazine_get_page_layout();
                if( 'no-sidebar' != $page_layout ){
                    if( is_active_sidebar( 'home-page-sidebar' ) ) {
                        ?>
                        <div id="secondary" class="sidebar-area">
                            <div class="theiaStickySidebar">
                                <aside class="widget-area">
                                    <?php dynamic_sidebar('home-page-sidebar'); ?>
                                </aside>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <?php
            get_footer();
            return;
        }
    }
}
/**/
?>

<?php
/**
 * Functions hooked into eximious_magazine_home_before_widget_area action
 *
 * @hooked eximious_magazine_home_trending_items - 10
 * @hooked eximious_magazine_home_banner_slider - 20
 * @hooked eximious_magazine_above_homepage_widget_region - 30
 *
 */
do_action('eximious_magazine_home_before_widget_area');
?>
<div class="container">
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <?php
            /*Home page widget area*/
            if (is_active_sidebar('home-page-widget-area')) {
                ?>
                <div class="homepage-widgetarea general-widget-area">
                    <?php dynamic_sidebar('home-page-widget-area'); ?>
                </div>
                <?php
            }
            ?>
            <?php
            if($enable_front_page_content){
                eximious_magazine_front_page_content();
            }
            ?>
        </main><!-- #main -->
    </div><!-- #primary -->
    <?php
    $page_layout = eximious_magazine_get_page_layout();
    if( 'no-sidebar' != $page_layout ){
        if( is_active_sidebar( 'home-page-sidebar' ) ) {
            ?>
            <div id="secondary" class="sidebar-area">
                <div class="theiaStickySidebar">
                    <aside class="widget-area">
                        <?php dynamic_sidebar('home-page-sidebar'); ?>
                    </aside>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>
<?php
/**
 * Functions hooked into eximious_magazine_home_after_widget_area action
 *
 * @hooked eximious_magazine_below_homepage_widget_region - 10
 *
 */
do_action('eximious_magazine_home_after_widget_area');

get_footer();