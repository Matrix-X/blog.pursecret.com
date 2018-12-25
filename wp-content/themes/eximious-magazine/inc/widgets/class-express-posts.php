<?php

if (!defined('ABSPATH')) {
    exit;
}

class Eximious_Magazine_Express_Posts extends Eximious_Magazine_Widget_Base{

    public $image_sizes;

    /**
     * Constructor.
     */
    public function __construct(){

        $this->widget_cssclass = 'eximious_magazine widget_express_posts';
        $this->widget_description = __("Displays posts in express column style", 'eximious-magazine');
        $this->widget_id = 'eximious_magazine_express_posts';
        $this->widget_name = __('EM: Express Posts', 'eximious-magazine');

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
                'label' => __('Express Post Image Size', 'eximious-magazine'),
                'options' => $this->image_sizes,
                'std' => 'eximious-magazine-medium-img',
            ),
            'excerpt_length' => array(
                'type' => 'number',
                'step' => 1,
                'min' => 1,
                'max' => '',
                'std' => 20,
                'label' => __('Express Post Excerpt Length', 'eximious-magazine'),
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
        $orderby = !empty($instance['orderby']) ? sanitize_title($instance['orderby']) : $this->settings['orderby']['std'];
        $order = !empty($instance['order']) ? sanitize_title($instance['order']) : $this->settings['order']['std'];

        $query_args = array(
            'posts_per_page' => 5,
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
                'terms' => $instance['category'],
            );
        }

        return new WP_Query(apply_filters('eximious_magazine_express_posts_query_args', $query_args));
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

            do_action( 'eximious_magazine_before_express_posts');
            ?>

            <div class="eximious_magazine_express_posts clearfix">
                <?php
                $total_posts = $posts->post_count;
                $counter = 1;
                while ($posts->have_posts()): $posts->the_post();
                    $wrapper_class_start = $wrapper_class_end = '';
                    if(1 == $counter){
                        $wrapper_class_start = '<div class="col-2 big-express float-l">';
                        $wrapper_class_end = '</div>';
                        $image_size = ($instance['image_size']) ? esc_attr($instance['image_size']) : 'eximious-magazine-medium-img';
                    }else{
                        $image_size = 'thumbnail';
                        if(2 == $counter){
                            $wrapper_class_start = '<div class="col-2 float-l">';
                        }
                        if($counter == $total_posts){
                            $wrapper_class_end = '</div>';
                        }
                    }
                    ?>
                    <?php echo wp_kses_post($wrapper_class_start);?>
                    <div class="article-block-wrapper clearfix">
                        <?php if (has_post_thumbnail()) { ?>
                            <div class="entry-image">
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
                        <?php } ?>
                        <div class="article-details">
                            <h3 class="entry-title">
                                <a href="<?php the_permalink() ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h3>
                            <div class="em-meta-info">
                                <div class="em-author-name">
                                    <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php the_author(); ?></a>
                                </div>
                                <div class="em-post-date">
                                    <?php
                                    $date_format = $instance['date_format'];
                                    if('format_1' == $date_format){
                                        echo esc_html(human_time_diff(get_the_time('U'), current_time('timestamp')) .' '.__( 'ago', 'eximious-magazine' ));
                                    }else{
                                        echo esc_html(get_the_date());
                                    }
                                    ?>
                                </div>
                                <div class="em-comment-link">
                                    <?php
                                    $number = get_comments_number(get_the_ID());
                                    if (0 == $number) {
                                        $respond_link = get_permalink() . '#respond';
                                        $comment_link = apply_filters('respond_link', $respond_link, get_the_ID());
                                    } else {
                                        $comment_link = get_comments_link();
                                    }
                                    ?>
                                    <a href="<?php echo esc_url($comment_link) ?>">
                                        <i class="far fa-comments"></i>
                                        <?php echo esc_html($number); ?>
                                    </a>
                                </div>
                            </div>
                            <?php
                            if(1 == $counter){
                                if ($instance['excerpt_length'] > 0) {
                                    ?>
                                    <div class="em-excerpt">
                                        <?php
                                        $content = wp_trim_words( get_the_excerpt(), $instance['excerpt_length'], '...' );
                                        echo wpautop(esc_html($content));
                                        ?>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <?php echo wp_kses_post($wrapper_class_end);?>
                    <?php $counter++; endwhile;wp_reset_postdata();?>
            </div>
            <?php

            do_action( 'eximious_magazine_after_express_posts');

            $this->widget_end($args);
        }

        echo ob_get_clean();
    }

}