<?php
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function blog_elite_widgets_init() {
    $sidebar_args['sidebar'] = array(
        'name'          => __( 'Sidebar', 'blog-elite' ),
        'id'            => 'sidebar-1',
        'description'   => ''
    );

    $sidebar_args['below_header'] = array(
        'name'        => __( 'Below Header', 'blog-elite' ),
        'id'          => 'below-header-widget-area',
        'description' => __( 'Widgets added to this region will appear beneath the header and above the main content.', 'blog-elite' ),
    );

    $sidebar_args['above_homepage'] = array(
        'name'        => __( 'Above Homepage', 'blog-elite' ),
        'id'          => 'above-homepage-widget-area',
        'description' => __( 'Widgets added to this region will appear above the homepage content. Basically useful if you want to have sidebar on homepage but want some content on top without the sidebar too.', 'blog-elite' ),
    );

    $sidebar_args['homepage'] = array(
        'name'        => __( 'Homepage', 'blog-elite' ),
        'id'          => 'home-page-widget-area',
        'description' => __( 'Widgets added to this region will appear on the homepage.', 'blog-elite' ),
    );

    $sidebar_args['homepage_sidebar'] = array(
        'name'        => __( 'Homepage Sidebar', 'blog-elite' ),
        'id'          => 'home-page-sidebar',
        'description' => __( 'Widgets added to this region will appear on the homepage sidebar.', 'blog-elite' ),
    );

    $sidebar_args['below_homepage'] = array(
        'name'        => __( 'Below Homepage', 'blog-elite' ),
        'id'          => 'below-homepage-widget-area',
        'description' => __( 'Widgets added to this region will appear below the homepage content. Basically useful if you want to have sidebar on homepage but want some content on bottom without the sidebar too.', 'blog-elite' ),
    );

    $sidebar_args['above_footer'] = array(
        'name'        => __( 'Above Footer', 'blog-elite' ),
        'id'          => 'before-footer-widgetarea',
        'description' => __( 'Widgets added to this region will appear above the footer.', 'blog-elite' ),
    );

    /*Get the footer column from the customizer*/
    $footer_column_layout = blog_elite_get_option('footer_column_layout');
    if($footer_column_layout){
        switch ($footer_column_layout) {
            case "footer_layout_1":
                $footer_column = 4;
                break;
            case "footer_layout_2":
                $footer_column = 3;
                break;
            case "footer_layout_3":
                $footer_column = 2;
                break;
            default:
                $footer_column = 4;
        }
    }else{
        $footer_column = 4;
    }

    $rows = intval( apply_filters( 'blog_elite_footer_widget_rows', 1 ) );
    $cols = intval( apply_filters( 'blog_elite_footer_widget_columns', $footer_column ) );

    for ( $i = 1; $i <= $rows; $i++ ) {
        for ( $j = 1; $j <= $cols; $j++ ) {
            $footer_n = $j + $cols * ( $i - 1 ); // Defines footer sidebar ID.
            $footer   = sprintf( 'footer_%d', $footer_n );

            if ( 1 == $rows ) {
                $footer_region_name = sprintf( __( 'Footer Column %1$d', 'blog-elite' ), $j );
                $footer_region_description = sprintf( __( 'Widgets added here will appear in column %1$d of the footer.', 'blog-elite' ), $j );
            } else {
                $footer_region_name = sprintf( __( 'Footer Row %1$d - Column %2$d', 'blog-elite' ), $i, $j );
                $footer_region_description = sprintf( __( 'Widgets added here will appear in column %1$d of footer row %2$d.', 'blog-elite' ), $j, $i );
            }

            $sidebar_args[ $footer ] = array(
                'name'        => $footer_region_name,
                'id'          => sprintf( 'footer-%d', $footer_n ),
                'description' => $footer_region_description,
            );
        }
    }

    $sidebar_args = apply_filters( 'blog_elite_sidebar_args', $sidebar_args );

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
         * 'blog_elite_sidebar_widget_tags'
         * 'blog_elite_below_header_widget_tags'
         * 'blog_elite_above_homepage_widget_tags'
         * 'blog_elite_homepage_widget_tags'
         * 'blog_elite_homepage_sidebar_widget_tags'
         * 'blog_elite_below_homepage_widget_tags'
         * 'blog_elite_above_footer_widget_tags'
         *
         * 'blog_elite_footer_1_widget_tags'
         * 'blog_elite_footer_2_widget_tags'
         * 'blog_elite_footer_3_widget_tags'
         * 'blog_elite_footer_4_widget_tags'
         *
         */
        $filter_hook = sprintf( 'blog_elite_%s_widget_tags', $sidebar );
        $widget_tags = apply_filters( $filter_hook, $widget_tags );

        if ( is_array( $widget_tags ) ) {
            register_sidebar( $args + $widget_tags );
        }
    }
}
add_action( 'widgets_init', 'blog_elite_widgets_init' );