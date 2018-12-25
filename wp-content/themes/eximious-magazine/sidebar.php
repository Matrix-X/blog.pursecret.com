<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Eximious_Magazine
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
    return;
}
?>

<div id="secondary" class="sidebar-area">
    <div class="theiaStickySidebar">
        <aside class="widget-area">
            <?php dynamic_sidebar( 'sidebar-1' ); ?>
        </aside>
    </div>
</div>