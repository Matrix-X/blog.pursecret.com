<?php

if (!defined('ABSPATH')) {
    exit;
}

class Blog_Elite_Social_Menu extends Blog_Elite_Widget_Base
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->widget_cssclass = 'blog_elite widget_social_menu';
        $this->widget_description = __("Displays social menu if you have set it(social menu)", 'blog-elite');
        $this->widget_id = 'blog_elite_social_menu';
        $this->widget_name = __('BE: Social Menu', 'blog-elite');
        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'label' => __('Title', 'blog-elite'),
            ),
        );

        parent::__construct();
    }

    /**
     * Output widget.
     *
     * @see WP_Widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance)
    {
        ob_start();

        $this->widget_start($args, $instance);

        do_action( 'blog_elite_before_social_menu');

        ?>
        <div class="blog_elite_social_menu_widget social-widget-menu">
            <?php

            if ( has_nav_menu( 'social-menu' ) ) {
                wp_nav_menu(array(
                    'theme_location' => 'social-menu',
                    'link_before' => '<span class="screen-reader-text">',
                    'link_after' => '</span>',
                    'fallback_cb' => false,
                    'depth' => 1,
                    'menu_class' => false
                ) );
            }else{
                esc_html_e( 'Social menu is not set. You need to create menu and assign it to Social Menu on Menu Settings.', 'blog-elite' );

            }
            ?>
        </div>
        <?php

        do_action( 'blog_elite_after_social_menu');

        $this->widget_end($args);

        echo ob_get_clean();
    }
}