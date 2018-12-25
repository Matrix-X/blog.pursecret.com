<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Eximious_Magazine
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
/**
 * Functions hooked into eximious_magazine_before_site
 *
 * @hooked eximious_magazine_preloader - 10
 */
do_action( 'eximious_magazine_before_site' );
?>

<div id="page" class="site">

    <?php do_action( 'eximious_magazine_before_header' ); ?>

	<header id="masthead" class="site-header" style="<?php eximious_magazine_header_styles(); ?>">

        <?php
        /**
         * Functions hooked into eximious_magazine_header action
         *
         * @hooked eximious_magazine_header_start - 10
         * @hooked eximious_magazine_header_content - 20
         * @hooked eximious_magazine_header_end - 30
         */
        do_action( 'eximious_magazine_header');
        ?>

	</header><!-- #masthead -->

    <?php
    /**
     * Functions hooked in to eximious_magazine_before_content
     *
     * @hooked eximious_magazine_header_widget_region - 10
     * @hooked eximious_magazine_breadcrumb - 20
     */
    do_action( 'eximious_magazine_before_content' );
    ?>

	<div id="content" class="site-content">
    <?php
    do_action( 'eximious_magazine_content_top' );