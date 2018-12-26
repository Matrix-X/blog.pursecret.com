<?php

if ( ! function_exists( 'blog_elite_preloader' ) ) {
    /**
     * Show/Hide Preloader
     */
    function blog_elite_preloader() {
        $show_preloader = blog_elite_get_option('show_preloader');
        if($show_preloader) {
            ?>
            <div class="preloader">
                <div class="be-spinner">
                    <div class="bounce1"></div>
                    <div class="bounce2"></div>
                    <div class="bounce3"></div>
                </div>
            </div>
            <?php
        }
    }
}

if ( ! function_exists( 'blog_elite_header_start' ) ) {
    /**
     * Header Start
     */
    function blog_elite_header_start() {
        ?>
        <div class="saga-header">
            <a class="skip-link screen-reader-text" href="#site-navigation"><?php esc_attr_e( 'Skip to navigation', 'blog-elite' ); ?></a>
            <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'blog-elite' ); ?></a>
        <?php
    }
}

if ( ! function_exists( 'blog_elite_header_content' ) ) {
    /**
     * Header Content
     *
     * @param string $header_style Header Style.
     */
    function blog_elite_header_content($header_style) {
        get_template_part('template-parts/header/'.$header_style);
    }
}

if ( ! function_exists( 'blog_elite_header_end' ) ) {
    /**
     * Header End
     */
    function blog_elite_header_end() {
        ?>
        </div>
        <?php
    }
}

if ( ! function_exists( 'blog_elite_header_widget_region' ) ) {
    /**
     * Display header widget region
     *
     * @since  1.0.0
     */
    function blog_elite_header_widget_region() {
        if ( is_active_sidebar( 'below-header-widget-area' ) ) {
            $heading_style = blog_elite_get_general_heading_style();
            $heading_align = blog_elite_get_general_heading_align();
            ?>
            <div class="header-widget-region general-widget-area <?php echo esc_attr($heading_style).' '.esc_attr($heading_align);?>" role="complementary">
                <div class="saga-container">
                    <?php dynamic_sidebar( 'below-header-widget-area' ); ?>
                </div>
            </div>
            <?php
        }
    }
}

/* Display Breadcrumbs */
if ( ! function_exists( 'blog_elite_breadcrumb' ) ) :
    /**
     * Simple breadcrumb.
     *
     * @since 1.0.0
     */
    function blog_elite_breadcrumb() {
        $enable_breadcrumb = blog_elite_get_option('enable_breadcrumb');
        if($enable_breadcrumb){
            if ( ! function_exists( 'breadcrumb_trail' ) ) {
                require_once get_template_directory() . '/lib/breadcrumbs/breadcrumbs.php';
            }
            $breadcrumb_args = array(
                'container'   => 'div',
                'before'   => '<div class="saga-container">',
                'after'   => '</div>',
                'show_browse' => false,
                'show_on_front' => false,
            );
            breadcrumb_trail( $breadcrumb_args );
        }
    }
endif;