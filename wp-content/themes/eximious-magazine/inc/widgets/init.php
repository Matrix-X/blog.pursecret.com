<?php

/* Theme Widget sidebars. */
require get_template_directory() . '/inc/widgets/widget-sidebars.php';
require get_template_directory() . '/inc/widgets/widget-base/abstract-widget-base.php';

require get_template_directory() . '/inc/widgets/class-post-ids-special-grid.php';
require get_template_directory() . '/inc/widgets/class-single-column-posts.php';
require get_template_directory() . '/inc/widgets/class-double-column-posts.php';
require get_template_directory() . '/inc/widgets/class-posts-slider.php';
require get_template_directory() . '/inc/widgets/class-posts-carousel.php';
require get_template_directory() . '/inc/widgets/class-recent-posts-with-image.php';
require get_template_directory() . '/inc/widgets/class-tab-posts.php';
require get_template_directory() . '/inc/widgets/class-express-posts.php';
require get_template_directory() . '/inc/widgets/class-social-menu.php';

/* Register site widgets */
if ( ! function_exists( 'eximious_magazine_widgets' ) ) :
    /**
     * Load widgets.
     *
     * @since 1.0.0
     */
    function eximious_magazine_widgets() {
        register_widget( 'Eximious_Magazine_Post_Ids_Special_Grid' );
        register_widget( 'Eximious_Magazine_Single_Column_Posts' );
        register_widget( 'Eximious_Magazine_Double_Column_Posts' );
        register_widget( 'Eximious_Magazine_Posts_Slider' );
        register_widget( 'Eximious_Magazine_Posts_Carousel' );
        register_widget( 'Eximious_Magazine_Recent_Posts_With_Image' );
        register_widget( 'Eximious_Magazine_Tab_Posts' );
        register_widget( 'Eximious_Magazine_Express_Posts' );
        register_widget( 'Eximious_Magazine_Social_Menu' );
    }
endif;
add_action( 'widgets_init', 'eximious_magazine_widgets' );