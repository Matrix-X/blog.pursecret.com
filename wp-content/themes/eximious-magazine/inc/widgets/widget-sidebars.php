<?php
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function eximious_magazine_widgets_init() {
    $sidebar_args['sidebar'] = array(
        'name'          => __( 'Sidebar', 'eximious-magazine' ),
        'id'            => 'sidebar-1',
        'description'   => ''
    );

    $sidebar_args['header'] = array(
        'name'        => __( 'Below Header', 'eximious-magazine' ),
        'id'          => 'header-1',
        'description' => __( 'Widgets added to this region will appear beneath the header and above the main content.', 'eximious-magazine' ),
    );

    $sidebar_args['above_homepage'] = array(
        'name'        => __( 'Above Homepage', 'eximious-magazine' ),
        'id'          => 'above-homepage-widget-area',
        'description' => __( 'Widgets added to this region will appear above the homepage content. Basically useful if you want to have sidebar on homepage but want some content on top without the sidebar too.', 'eximious-magazine' ),
    );

    $sidebar_args['homepage'] = array(
        'name'        => __( 'Homepage', 'eximious-magazine' ),
        'id'          => 'home-page-widget-area',
        'description' => __( 'Widgets added to this region will appear on the homepage.', 'eximious-magazine' ),
    );

    $sidebar_args['homepage_sidebar'] = array(
        'name'        => __( 'Homepage Sidebar', 'eximious-magazine' ),
        'id'          => 'home-page-sidebar',
        'description' => __( 'Widgets added to this region will appear on the homepage sidebar.', 'eximious-magazine' ),
    );

    $sidebar_args['below_homepage'] = array(
        'name'        => __( 'Below Homepage', 'eximious-magazine' ),
        'id'          => 'below-homepage-widget-area',
        'description' => __( 'Widgets added to this region will appear below the homepage content. Basically useful if you want to have sidebar on homepage but want some content on bottom without the sidebar too.', 'eximious-magazine' ),
    );

    $sidebar_args['footer'] = array(
        'name'        => __( 'Above Footer', 'eximious-magazine' ),
        'id'          => 'before-footer-widgetarea',
        'description' => __( 'Widgets added to this region will appear above the footer.', 'eximious-magazine' ),
    );

    $rows = intval( apply_filters( 'eximious_magazine_footer_widget_rows', 1 ) );
    $cols = intval( apply_filters( 'eximious_magazine_footer_widget_columns', 4 ) );

    for ( $i = 1; $i <= $rows; $i++ ) {
        for ( $j = 1; $j <= $cols; $j++ ) {
            $footer_n = $j + $cols * ( $i - 1 ); // Defines footer sidebar ID.
            $footer   = sprintf( 'footer_%d', $footer_n );

            if ( 1 == $rows ) {
                $footer_region_name = sprintf( __( 'Footer Column %1$d', 'eximious-magazine' ), $j );
                $footer_region_description = sprintf( __( 'Widgets added here will appear in column %1$d of the footer.', 'eximious-magazine' ), $j );
            } else {
                $footer_region_name = sprintf( __( 'Footer Row %1$d - Column %2$d', 'eximious-magazine' ), $i, $j );
                $footer_region_description = sprintf( __( 'Widgets added here will appear in column %1$d of footer row %2$d.', 'eximious-magazine' ), $j, $i );
            }

            $sidebar_args[ $footer ] = array(
                'name'        => $footer_region_name,
                'id'          => sprintf( 'footer-%d', $footer_n ),
                'description' => $footer_region_description,
            );
        }
    }

    $sidebar_args = apply_filters( 'eximious_magazine_sidebar_args', $sidebar_args );

    foreach ( $sidebar_args as $sidebar => $args ) {
        $widget_tags = array(
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<span class="widget-title"><span>',
            'after_title'   => '</span></span>',
        );

        /**
         * Dynamically generated filter hooks. Allow changing widget wrapper and title tags. See the list below.
         *
         * 'eximious_magazine_header_widget_tags'
         * 'eximious_magazine_sidebar_widget_tags'
         * 'eximious_magazine_above_homepage_widget_tags'
         * 'eximious_magazine_homepage_widget_tags'
         * 'eximious_magazine_homepage_sidebar_widget_tags'
         * 'eximious_magazine_below_homepage_widget_tags'
         *
         * 'eximious_magazine_footer_1_widget_tags'
         * 'eximious_magazine_footer_2_widget_tags'
         * 'eximious_magazine_footer_3_widget_tags'
         * 'eximious_magazine_footer_4_widget_tags'
         */
        $filter_hook = sprintf( 'eximious_magazine_%s_widget_tags', $sidebar );
        $widget_tags = apply_filters( $filter_hook, $widget_tags );

        if ( is_array( $widget_tags ) ) {
            register_sidebar( $args + $widget_tags );
        }
    }
}
add_action( 'widgets_init', 'eximious_magazine_widgets_init' );