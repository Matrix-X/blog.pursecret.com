<?php

/* Theme Widget sidebars. */
require get_template_directory() . '/inc/widgets/widget-sidebars.php';
require get_template_directory() . '/inc/widgets/widget-base/abstract-widget-base.php';

require get_template_directory() . '/inc/widgets/class-recent-posts-with-image.php';
require get_template_directory() . '/inc/widgets/class-social-menu.php';
require get_template_directory() . '/inc/widgets/class-author-info.php';
require get_template_directory() . '/inc/widgets/class-recent-comments.php';

/* Register site widgets */
if ( ! function_exists( 'blog_elite_widgets' ) ) :
    /**
     * Load widgets.
     *
     * @since 1.0.0
     */
    function blog_elite_widgets() {
        register_widget( 'Blog_Elite_Recent_Posts_With_Image' );
        register_widget( 'Blog_Elite_Social_Menu' );
        register_widget( 'Blog_Elite_Author_Info' );
        register_widget( 'Blog_Elite_Recent_Comments' );
    }
endif;
add_action( 'widgets_init', 'blog_elite_widgets' );