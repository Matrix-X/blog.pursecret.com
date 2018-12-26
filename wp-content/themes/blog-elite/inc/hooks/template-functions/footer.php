<?php

if ( ! function_exists( 'blog_elite_before_footer_widget_region' ) ) {
    /**
     * Display above footer widget region
     *
     * @since  1.0.0
     */
    function blog_elite_before_footer_widget_region() {
        if ( is_active_sidebar( 'before-footer-widgetarea' ) ) {
            $heading_style = blog_elite_get_general_heading_style();
            $heading_align = blog_elite_get_general_heading_align();
            ?>
            <div class="before-footer-widget-region general-widget-area <?php echo esc_attr($heading_style).' '.esc_attr($heading_align);?>" role="complementary">
                <div class="saga-container">
                    <?php dynamic_sidebar( 'before-footer-widgetarea' ); ?>
                </div>
            </div>
            <?php
        }
    }
}

if ( ! function_exists( 'blog_elite_footer_start' ) ) {
    /**
     * Footer Start
     */
    function blog_elite_footer_start() {
        ?>
        <div class="saga-footer">
        <?php
    }
}

if ( ! function_exists( 'blog_elite_footer_content' ) ) {
    /**
     * Footer Content
     */
    function blog_elite_footer_content() {
        get_template_part('template-parts/footer/footer_style_1');
    }
}

if ( ! function_exists( 'blog_elite_footer_end' ) ) {
    /**
     * Footer End
     */
    function blog_elite_footer_end() {
        ?>
        </div>
        <?php
    }
}

if ( ! function_exists( 'blog_elite_sub_footer' ) ) {
    /**
     * Display site sub footer
     *
     * @since  1.0.0
     */
    function blog_elite_sub_footer() {
        get_template_part('template-parts/footer/sub','footer');
    }
}