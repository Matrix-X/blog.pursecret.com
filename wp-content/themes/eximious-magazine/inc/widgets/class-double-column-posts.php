<?php

if (!defined('ABSPATH')) {
    exit;
}

class Eximious_Magazine_Double_Column_Posts extends Eximious_Magazine_Widget_Base{

    /**
     * Constructor.
     */
    public function __construct(){

        $this->widget_cssclass = 'eximious_magazine widget_double_column_posts';
        $this->widget_description = __("Displays posts in double column style", 'eximious-magazine');
        $this->widget_id = 'eximious_magazine_double_column_posts';
        $this->widget_name = __('EM: Double Column Posts', 'eximious-magazine');
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
                'std' => 8,
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
            'excerpt_length' => array(
                'type' => 'number',
                'step' => 1,
                'min' => 1,
                'max' => '',
                'std' => 20,
                'label' => __('Excerpt Length', 'eximious-magazine'),
            ),
            'image_size' => array(
                'type' => 'select',
                'label' => __('Image Size', 'eximious-magazine'),
                'options' => eximious_magazine_get_all_image_sizes(true),
                'std' => 'eximious-magazine-medium-img',
            ),
            'show_category' => array(
                'type' => 'checkbox',
                'label' => __('Show Category', 'eximious-magazine'),
                'std' => true,
            ),
            'show_author' => array(
                'type' => 'checkbox',
                'label' => __('Show Author', 'eximious-magazine'),
                'std' => true,
            ),
            'show_date' => array(
                'type' => 'checkbox',
                'label' => __('Show Date', 'eximious-magazine'),
                'std' => true,
            ),
            'show_comment' => array(
                'type' => 'checkbox',
                'label' => __('Show Comment', 'eximious-magazine'),
                'std' => true,
            ),
            'show_read_more' => array(
                'type' => 'checkbox',
                'label' => __('Show Read More', 'eximious-magazine'),
                'std' => false,
            ),
            'read_more_text' => array(
                'type' => 'text',
                'label' => __('Read More Text', 'eximious-magazine'),
                'std' => __('Read More', 'eximious-magazine'),
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
                'terms' => $instance['category'],
            );
        }
        return new WP_Query(apply_filters('eximious_magazine_double_column_posts_query_args', $query_args));
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

            do_action( 'eximious_magazine_before_double_column_posts');

            $image_size = ($instance['image_size']) ? esc_attr($instance['image_size']) : 'eximious-magazine-medium-img';
            ?>

            <div class="eximious_magazine_double_column_posts saga-row clearfix">
                <?php while ($posts->have_posts()): $posts->the_post(); ?>
                    <div class="article-block-wrapper clearfix" data-mh="double-col-posts">
                        <?php
                        if( 'no-image' != $image_size ){
                            ?>
                            <div class="entry-image">
                                <?php
                                if (has_post_thumbnail()) {
                                    ?>
                                    <a href="<?php the_permalink() ?>">
                                        <?php
                                        the_post_thumbnail( $image_size, array(
                                            'alt' => the_title_attribute( array(
                                                'echo' => false,
                                            ) ),
                                        ) );
                                        ?>
                                    </a>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="article-details">
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
                                            <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" style="<?php echo esc_attr($style);?>">
                                                <?php echo esc_html($cat->cat_name);?>
                                            </a>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                            <h3 class="entry-title">
                                <a href="<?php the_permalink() ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h3>
                            <div class="em-meta-info">
                                <?php
                                if($instance['show_author']){
                                    ?>
                                    <div class="em-author-name">
                                        <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php the_author(); ?></a>
                                    </div>
                                    <?php
                                }
                                if($instance['show_date']){
                                    ?>
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
                                    <?php
                                }
                                if($instance['show_comment']){
                                    if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
                                        ?>
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
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                            <?php
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
                            if ($instance['show_read_more']) {
                                if($instance['read_more_text']) {
                                    ?>
                                    <div class="em-read-more">
                                        <a href="<?php the_permalink();?>" class="readmore-btn">
                                            <?php echo esc_html($instance['read_more_text']);?>
                                        </a>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                <?php endwhile;wp_reset_postdata();?>
            </div>
            <?php

            do_action( 'eximious_magazine_after_double_column_posts');

            $this->widget_end($args);
        }

        echo ob_get_clean();
    }

}