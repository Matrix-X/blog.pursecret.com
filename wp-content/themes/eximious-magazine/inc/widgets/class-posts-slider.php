<?php

if (!defined('ABSPATH')) {
    exit;
}

class Eximious_Magazine_Posts_Slider extends Eximious_Magazine_Widget_Base{

    public $image_sizes;

    /**
     * Constructor.
     */
    public function __construct(){

        $this->widget_cssclass = 'eximious_magazine widget_posts_slider';
        $this->widget_description = __("Displays posts in slider", 'eximious-magazine');
        $this->widget_id = 'eximious_magazine_posts_slider';
        $this->widget_name = __('EM: Posts Slider', 'eximious-magazine');

        $this->image_sizes = eximious_magazine_get_all_image_sizes(true);
        array_shift($this->image_sizes);

        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'label' => __('Title', 'eximious-magazine'),
            ),
            'category' => array(
                'type' => 'dropdown-taxonomies',
                'label' => __('Select Category', 'eximious-magazine'),
                'desc' => __('Leave empty if you don\'t want the posts to be category specific', 'eximious-magazine'),
                'args' => array(
                    'taxonomy' => 'category',
                    'class' => 'widefat',
                    'hierarchical' => true,
                    'show_count' => 1,
                    'show_option_all' => __('&mdash; Select &mdash;', 'eximious-magazine'),
                ),
            ),
            'number' => array(
                'type' => 'number',
                'step' => 1,
                'min' => 1,
                'max' => '',
                'std' => 5,
                'label' => __('Number of posts to show', 'eximious-magazine'),
            ),
            'orderby' => array(
                'type' => 'select',
                'std' => 'date',
                'label' => __('Order by', 'eximious-magazine'),
                'options' => array(
                    'date' => __('Date', 'eximious-magazine'),
                    'ID' => __('ID', 'eximious-magazine'),
                    'title' => __('Title', 'eximious-magazine'),
                    'rand' => __('Random', 'eximious-magazine'),
                ),
            ),
            'order' => array(
                'type' => 'select',
                'std' => 'desc',
                'label' => __('Order', 'eximious-magazine'),
                'options' => array(
                    'asc' => __('ASC', 'eximious-magazine'),
                    'desc' => __('DESC', 'eximious-magazine'),
                ),
            ),
            'image_size' => array(
                'type' => 'select',
                'label' => __('Image Size', 'eximious-magazine'),
                'options' => $this->image_sizes,
                'std' => 'eximious-magazine-large-img',
            ),
            'show_category' => array(
                'type' => 'checkbox',
                'label' => __('Show Category', 'eximious-magazine'),
                'std' => true,
            ),
            'show_date' => array(
                'type' => 'checkbox',
                'label' => __('Show Date', 'eximious-magazine'),
                'std' => true,
            ),
            'date_format' => array(
                'type' => 'select',
                'label' => __('Date Format', 'eximious-magazine'),
                'options' => array(
                    'format_1' => __('Format 1', 'eximious-magazine'),
                    'format_2' => __('Format 2', 'eximious-magazine'),
                ),
                'std' => 'format_1',
            ),
        );

        parent::__construct();
    }

    /**
     * Query the posts and return them.
     * @param  array $args
     * @param  array $instance
     * @return WP_Query
     */
    public function get_posts($args, $instance)
    {
        $number = !empty($instance['number']) ? absint($instance['number']) : $this->settings['number']['std'];
        $orderby = !empty($instance['orderby']) ? esc_attr($instance['orderby']) : $this->settings['orderby']['std'];
        $order = !empty($instance['order']) ? esc_attr($instance['order']) : $this->settings['order']['std'];

        $query_args = array(
            'posts_per_page' => $number,
            'post_status' => 'publish',
            'no_found_rows' => 1,
            'orderby' => $orderby,
            'order' => $order,
            'ignore_sticky_posts' => 1
        );

        if (!empty($instance['category']) && -1 != $instance['category'] && 0 != $instance['category']) {
            $query_args['tax_query'][] = array(
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => absint($instance['category']),
            );
        }

        return new WP_Query(apply_filters('eximious_magazine_posts_slider_query_args', $query_args));
    }

    /**
     * Output widget.
     *
     * @see WP_Widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance){

        ob_start();

        if (($posts = $this->get_posts($args, $instance)) && $posts->have_posts()) {
            $this->widget_start($args, $instance);

            do_action( 'eximious_magazine_before_posts_slider');

            $image_size = ($instance['image_size']) ? esc_attr($instance['image_size']) : 'eximious-magazine-large-img';
            ?>

            <div class="eximious_magazine_posts_slider">
                <div class="owl-carousel owl-theme">
                    <?php
                    while ($posts->have_posts()): $posts->the_post();
                        if (has_post_thumbnail()) {
                            ?>
                            <div class="item">
                                <div class="item-single">
                                    <div class="entry-image bg-image">
                                        <a href="<?php the_permalink() ?>">
                                            <?php
                                            the_post_thumbnail( $image_size, array(
                                                'alt' => the_title_attribute( array(
                                                    'echo' => false,
                                                ) ),
                                            ) );
                                            ?>
                                        </a>
                                    </div>
                                    <div class="meta-info">
                                        <div class="meta-info-inner">
                                            <?php
                                            if($instance['show_category']){
                                                $categories = wp_get_post_categories(get_the_ID());
                                                if(!empty($categories)){
                                                    ?>
                                                    <div class="cat-info">
                                                        <?php
                                                        foreach($categories as $c){
                                                            $style = '';
                                                            $cat = get_category( $c );
                                                            $color = get_term_meta($cat->term_id, 'category_color', true);
                                                            if($color){
                                                                $style = "background-color:".esc_attr($color);
                                                            }
                                                            ?>
                                                            <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" style="<?php echo esc_attr($style);?>"><?php echo esc_html($cat->cat_name);?></a>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            if($instance['show_date']){
                                                $date_format = $instance['date_format'];
                                                ?>
                                                <div class="date-info">
                                                    <span class="saga-date">
                                                        <?php
                                                        if('format_1' == $date_format){
                                                            echo esc_html(human_time_diff(get_the_time('U'), current_time('timestamp')) .' '.__( 'ago', 'eximious-magazine' ));
                                                        }else{
                                                            echo esc_html(get_the_date());
                                                        }
                                                        ?>
                                                    </span>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <a href="<?php the_permalink()?>">
                                                <h3><?php the_title();?></h3>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    endwhile;wp_reset_postdata();
                    ?>
                </div>
            </div>
            <?php

            do_action( 'eximious_magazine_after_posts_slider');

            $this->widget_end($args);
        }

        echo ob_get_clean();
    }

}