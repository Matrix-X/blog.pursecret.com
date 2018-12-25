<?php

if (!defined('ABSPATH')) {
    exit;
}

class Eximious_Magazine_Social_Menu extends Eximious_Magazine_Widget_Base
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->widget_cssclass = 'eximious_magazine widget_social_menu';
        $this->widget_description = __("Displays social menu if you have set it(social menu)", 'eximious-magazine');
        $this->widget_id = 'eximious_magazine_social_menu';
        $this->widget_name = __('EM: Social Menu', 'eximious-magazine');
        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'label' => __('Title', 'eximious-magazine'),
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

        do_action( 'eximious_magazine_before_social_menu');

        ?>
        <div class="eximious_magazine_social_menu_widget social-widget-menu">
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
                esc_html_e( 'Social menu is not set. You need to create menu and assign it to Social Menu on Menu Settings.', 'eximious-magazine' );

            }
            ?>
        </div>
        <?php

        do_action( 'eximious_magazine_after_social_menu');

        $this->widget_end($args);

        echo ob_get_clean();
    }
}