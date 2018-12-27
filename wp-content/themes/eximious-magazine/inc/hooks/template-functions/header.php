<?php

if ( ! function_exists( 'eximious_magazine_preloader' ) ) {
    /**
     * Show/Hide Preloader
     */
    function eximious_magazine_preloader() {
        $show_preloader = eximious_magazine_get_option('show_preloader');
        if($show_preloader) {
            ?>
            <div class="preloader">
                <div class="em-folding-cube">
                    <div class="em-cube1 em-cube"></div>
                    <div class="em-cube2 em-cube"></div>
                    <div class="em-cube4 em-cube"></div>
                    <div class="em-cube3 em-cube"></div>
                </div>
            </div>
            <?php
        }
    }
}

if ( ! function_exists( 'eximious_magazine_header_start' ) ) {
    /**
     * Header Start
     */
    function eximious_magazine_header_start() {
        ?>
        <div class="saga-header">
            <a class="skip-link screen-reader-text" href="#site-navigation"><?php esc_attr_e( 'Skip to navigation', 'eximious-magazine' ); ?></a>
            <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'eximious-magazine' ); ?></a>
        <?php
    }
}

if ( ! function_exists( 'eximious_magazine_header_content' ) ) {
    /**
     * Header Content
     */
    function eximious_magazine_header_content() {
        get_template_part('template-parts/header/header_style_1');
    }
}

if ( ! function_exists( 'eximious_magazine_header_end' ) ) {
    /**
     * Header End
     */
    function eximious_magazine_header_end() {
        ?>
        </div>
        <?php
    }
}

if ( ! function_exists( 'eximious_magazine_header_widget_region' ) ) {
    /**
     * Display header widget region
     *
     * @since  1.0.0
     */
    function eximious_magazine_header_widget_region() {
        if ( is_active_sidebar( 'header-1' ) ) {
            ?>
            <div class="header-widget-region general-widget-area" role="complementary">
                <div class="container">
                    <?php dynamic_sidebar( 'header-1' ); ?>
                </div>
            </div>
            <?php
        }
    }
}

/* Display Breadcrumbs */
if ( ! function_exists( 'eximious_magazine_breadcrumb' ) ) :
    /**
     * Simple breadcrumb.
     *
     * @since 1.0.0
     */
    function eximious_magazine_breadcrumb() {
        $enable_breadcrumb = eximious_magazine_get_option('enable_breadcrumb');
        if($enable_breadcrumb){
            if ( ! function_exists( 'breadcrumb_trail' ) ) {
                require_once get_template_directory() . '/lib/breadcrumbs/breadcrumbs.php';
            }
            $breadcrumb_args = array(
                'container'   => 'div',
                'before'   => '<div class="container">',
                'after'   => '</div>',
                'show_browse' => false,
                'show_on_front' => false,
            );
            breadcrumb_trail( $breadcrumb_args );
        }
    }
endif;