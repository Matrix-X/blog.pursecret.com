<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
  * @package Clean_Portfolio
 */
$layout = cleanportfolio_get_theme_layout();

if ( 'no-sidebar-full-width' == $layout || 'no-sidebar' == $layout  ) {
	return;
}

$sidebar = cleanportfolio_get_sidebar_id();

if ( '' == $sidebar ) {
    return;
}

?>

<aside id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( $sidebar ); ?>
</aside><!-- #secondary -->
