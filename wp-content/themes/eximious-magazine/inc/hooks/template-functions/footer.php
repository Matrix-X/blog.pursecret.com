<?php

if ( ! function_exists( 'eximious_magazine_before_footer_widget_region' ) ) {
    /**
     * Display footer widget region
     *
     * @since  1.0.0
     */
    function eximious_magazine_before_footer_widget_region() {
        if ( is_active_sidebar( 'before-footer-widgetarea' ) ) {
            ?>
            <div class="before-footer-widget-region general-widget-area" role="complementary">
                <div class="container">
                    <?php dynamic_sidebar( 'before-footer-widgetarea' ); ?>
                </div>
            </div>
            <?php
        }
    }
}

if ( ! function_exists( 'eximious_magazine_footer_start' ) ) {
    /**
     * Footer Start
     */
    function eximious_magazine_footer_start() {
        ?>
        <div class="saga-footer">
        <?php
    }
}

if ( ! function_exists( 'eximious_magazine_footer_content' ) ) {
    /**
     * Footer Content
     */
    function eximious_magazine_footer_content() {
        get_template_part('template-parts/footer/footer_style_1');
    }
}

if ( ! function_exists( 'eximious_magazine_footer_end' ) ) {
    /**
     * Footer End
     */
    function eximious_magazine_footer_end() {
        ?>
        </div>
        <?php
    }
}