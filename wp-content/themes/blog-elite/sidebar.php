<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Blog_Elite
 */

$page_layout = blog_elite_get_page_layout();
if( 'no-sidebar' != $page_layout && 'no-sidebar-boxed' != $page_layout){
    $heading_style = blog_elite_get_sidebar_heading_style();
    $heading_align = blog_elite_get_sidebar_heading_align();
    ?>
    <div id="secondary" class="sidebar-area <?php echo esc_attr($heading_style).' '.esc_attr($heading_align);?>">
        <div class="theiaStickySidebar">
            <?php
            if(is_front_page()){
                if( is_active_sidebar( 'home-page-sidebar' ) ) {
                    ?>
                    <aside class="widget-area">
                        <?php dynamic_sidebar('home-page-sidebar'); ?>
                    </aside>
                    <?php
                }
            }else{
                if(is_active_sidebar('sidebar-1')){
                    ?>
                    <aside class="widget-area">
                        <?php dynamic_sidebar( 'sidebar-1' ); ?>
                    </aside>
                    <?php
                }
            }
            ?>
        </div>
    </div>
    <?php
}