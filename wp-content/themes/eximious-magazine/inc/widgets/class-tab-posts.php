<?php

if (!defined('ABSPATH')) {
    exit;
}

class Eximious_Magazine_Tab_Posts extends Eximious_Magazine_Widget_Base{

    /**
     * Constructor.
     */
    public function __construct(){

        $this->widget_cssclass = 'eximious_magazine widget_tab_posts';
        $this->widget_description = __("Displays posts in tab", 'eximious-magazine');
        $this->widget_id = 'eximious_magazine_tab_posts';
        $this->widget_name = __('EM: Tab Posts', 'eximious-magazine');
        $this->settings = array(
            'post_settings' => array(
                'type' => 'heading',
                'label' => __('Post Settings', 'eximious-magazine'),
            ),
            'number' => array(
                'type' => 'number',
                'step' => 1,
                'min' => 1,
                'max' => '',
                'std' => 3,
                'label' => __('Number of posts to show', 'eximious-magazine'),
            ),
            'image_size' => array(
                'type' => 'select',
                'label' => __('Image Size', 'eximious-magazine'),
                'options' => eximious_magazine_get_all_image_sizes(true),
                'std' => 'thumbnail',
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
            'date_format' => array(
                'type' => 'select',
                'label' => __('Date Format', 'eximious-magazine'),
                'options' => array(
                    'format_1' => __('Format 1', 'eximious-magazine'),
                    'format_2' => __('Format 2', 'eximious-magazine'),
                ),
                'std' => 'format_1',
            ),
            'comment_settings' => array(
                'type' => 'heading',
                'label' => __('Comment Settings', 'eximious-magazine'),
            ),
            'show_comment_tab' => array(
                'type' => 'checkbox',
                'label' => __('Show Comment Tab', 'eximious-magazine'),
                'std' => true,
            ),
            'comments_number' => array(
                'type' => 'number',
                'step' => 1,
                'min' => 1,
                'max' => '',
                'std' => 5,
                'label' => __('Number of comments to show', 'eximious-magazine'),
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
    public function get_posts($args, $instance, $type)
    {
        $number = !empty($instance['number']) ? absint($instance['number']) : $this->settings['number']['std'];

        switch ($type) {
            case 'popular':
                $query_args = array(
                    'post_type' => 'post',
                    'posts_per_page' => $number,
                    'post_status' => 'publish',
                    'no_found_rows' => 1,
                    'ignore_sticky_posts' => 1,
                    'orderby' => 'comment_count',
                );
                return new WP_Query(apply_filters('eximious_magazine_popular_posts_query_args', $query_args));
                break;
            case 'recent':
                $query_args = array(
                    'post_type' => 'post',
                    'posts_per_page' => $number,
                    'post_status' => 'publish',
                    'no_found_rows' => 1,
                    'ignore_sticky_posts' => 1,
                );
                return new WP_Query(apply_filters('eximious_magazine_recent_posts_query_args', $query_args));
                break;
            default:
                break;
        }
    }

    /**
     * Outputs the tab posts
     *
     * @param array $instance
     */
    public  function render_post($instance){
        ?>
        <div class="article-block-wrapper clearfix">
            <?php
            if('no-image' !== $instance['image_size'] ){
                if (has_post_thumbnail()) {
                    ?>
                    <div class="entry-image">
                        <a href="<?php the_permalink() ?>">
                            <?php
                            the_post_thumbnail( esc_attr($instance['image_size']), array(
                                'alt' => the_title_attribute( array(
                                    'echo' => false,
                                ) ),
                            ) );
                            ?>
                        </a>
                    </div>
                    <?php
                }
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
                        if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
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
            </div>
        </div>
        <?php
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

        static $counter_instance = 0;
        $counter_instance++;

        ob_start();

        $before_widget = $args['before_widget'];
        $after_widget = $args['after_widget'];

        echo wp_kses_post( $before_widget );

        do_action( 'eximious_magazine_before_tab_posts');
        ?>

        <div class="eximious_magazine_tab_posts">
            <div class="tabbed-container">
                <div class="tabbed-head">
                    <ul class="nav nav-tabs primary-background secondary-font" role="tablist">
                        <li role="presentation" class="tab tab-popular active">
                            <a href="#em-popular-<?php echo esc_attr($counter_instance);?>" aria-controls="<?php esc_html_e('Popular', 'eximious-magazine'); ?>" role="tab" data-toggle="tab" class="primary-bgcolor">
                                <i class="fas fa-fire"></i>
                                <?php esc_html_e('Popular', 'eximious-magazine'); ?>
                            </a>
                        </li>
                        <li class="tab tab-recent">
                            <a href="#em-recent-<?php echo esc_attr($counter_instance);?>" aria-controls="<?php esc_html_e('Recent', 'eximious-magazine'); ?>" role="tab" data-toggle="tab" class="primary-bgcolor">
                                <i class="fas fa-clock"></i>
                                <?php esc_html_e('Recent', 'eximious-magazine'); ?>
                            </a>
                        </li>
                        <?php
                        if($instance['show_comment_tab']){
                            ?>
                            <li class="tab tab-comment">
                                <a href="#em-comment-<?php echo esc_attr($counter_instance);?>" aria-controls="<?php esc_html_e('Comments', 'eximious-magazine'); ?>" role="tab" data-toggle="tab" class="primary-bgcolor">
                                    <i class="fas fa-comments"></i>
                                    <?php esc_html_e('Comments', 'eximious-magazine'); ?>
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
                <div class="tab-content">
                    <div id="em-popular-<?php echo esc_attr($counter_instance);?>" role="tabpanel" class="tab-pane active">
                        <?php
                        $popular_posts = $this->get_posts($args, $instance, 'popular' );
                        if($popular_posts->have_posts()){
                            while($popular_posts->have_posts()):$popular_posts->the_post();
                                $this->render_post($instance);
                            endwhile;wp_reset_postdata();
                        }
                        ?>
                    </div>
                    <div id="em-recent-<?php echo esc_attr($counter_instance);?>" role="tabpanel" class="tab-pane">
                        <?php
                        $recent_posts = $this->get_posts($args, $instance,'recent');
                        if($recent_posts->have_posts()){
                            while($recent_posts->have_posts()):$recent_posts->the_post();
                                $this->render_post($instance);
                            endwhile;wp_reset_postdata();
                        }
                        ?>
                    </div>
                    <?php
                    if($instance['show_comment_tab']){
                        ?>
                        <div id="em-comment-<?php echo esc_attr($counter_instance);?>" role="tabpanel" class="tab-pane">
                            <?php
                            $comments = get_comments( apply_filters( 'widget_comments_args', array(
                                'number'      => absint($instance['comments_number']),
                                'status'      => 'approve',
                                'post_status' => 'publish'
                            ), $instance ) );
                            $output = '<ul id="em-recent-comments" class="em-recent-comments">';
                            if ( is_array( $comments ) && $comments ) {
                                // Prime cache for associated posts. (Prime post term cache if we need it for permalinks.)
                                $post_ids = array_unique( wp_list_pluck( $comments, 'comment_post_ID' ) );
                                _prime_post_caches( $post_ids, strpos( get_option( 'permalink_structure' ), '%category%' ), false );

                                foreach ( (array) $comments as $comment ) {

                                    $avatar	 = get_avatar( $comment, 60 );
                                    $comment_text = get_comment_excerpt( $comment->comment_ID );
                                    $comment_date = get_comment_date( 'M j, H:i', $comment->comment_ID  );

                                    $output .= '<li class="recentcomments">';
                                    $output .= '<div class="comment-wrapper clearfix">';

                                    $output .= '<div class="comment-author">'.wp_kses_post($avatar).'</div>';
                                    $output .= '<div class="comment-info">';
                                    $output .= '<span class="comment-author-link">' . get_comment_author_link( $comment ) . '</span>';
                                    $output .= '<span class="comment-on">'.__('comments on', 'eximious-magazine').'</span>';
                                    $output .= '<a href="' . esc_url( get_comment_link( $comment ) ) . '">' . get_the_title( $comment->comment_post_ID ) . '</a>';
                                    $output .= '<span class="comment-excerpt">'.wp_kses_post($comment_text).'</span>';
                                    $output .= '<span class="comment-date">'.esc_html($comment_date).'</span>';
                                    $output .= '</div>';

                                    $output .= '</div>';
                                    $output .= '</li>';
                                }
                            }
                            $output .= '</ul>';
                            echo wp_kses_post($output);
                            ?>
                        </div>
                        <?php
                        }
                    ?>
                </div>
            </div>
        </div>
        <?php

        do_action( 'eximious_magazine_after_tab_posts');

        echo wp_kses_post( $after_widget );

        echo ob_get_clean();
    }

}