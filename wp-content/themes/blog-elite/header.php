<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Blog_Elite
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
 * Functions hooked into blog_elite_before_site
 *
 * @hooked blog_elite_preloader - 10
 */
do_action( 'blog_elite_before_site' );
?>

<div id="page" class="site saga-wrapper">

    <?php do_action( 'blog_elite_before_header' ); ?>

    <?php $header_style = blog_elite_get_option('header_style');?>

	<header id="masthead" class="site-header <?php echo esc_attr($header_style);?>">

        <?php
        /**
         * Functions hooked into blog_elite_header action
         *
         * @hooked blog_elite_header_start - 10
         * @hooked blog_elite_header_content - 20
         * @hooked blog_elite_header_end - 30
         */
        do_action( 'blog_elite_header', $header_style);
        ?>

	</header><!-- #masthead -->

    <?php
    /**
     * Functions hooked in to blog_elite_before_content
     *
     * @hooked blog_elite_header_widget_region - 10
     * @hooked blog_elite_breadcrumb - 20
     */
    do_action( 'blog_elite_before_content' );
    ?>

	<div id="content" class="site-content">
    <?php
    do_action( 'blog_elite_content_top' );