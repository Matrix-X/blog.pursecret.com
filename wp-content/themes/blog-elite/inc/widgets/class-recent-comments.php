<?php

if (!defined('ABSPATH')) {
    exit;
}

class Blog_Elite_Recent_Comments extends Blog_Elite_Widget_Base{

    /**
     * Constructor.
     */
    public function __construct(){

        $this->widget_cssclass = 'blog_elite widget_recent_comments';
        $this->widget_description = __("Displays recent comments", 'blog-elite');
        $this->widget_id = 'blog_elite_recent_comments';
        $this->widget_name = __('BE: Recent Comments', 'blog-elite');
        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'label' => __('Title', 'blog-elite'),
            ),
            'comments_number' => array(
                'type' => 'number',
                'step' => 1,
                'min' => 1,
                'max' => '',
                'std' => 5,
                'label' => __('Number of comments to show', 'blog-elite'),
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
    public function widget($args, $instance){

        ob_start();

        $this->widget_start($args, $instance);

        do_action( 'blog_elite_before_recent_comments');
        ?>

        <div class="blog_elite_tab_posts">
            <?php
            $comments = get_comments( apply_filters( 'widget_comments_args', array(
                'number'      => absint($instance['comments_number']),
                'status'      => 'approve',
                'post_status' => 'publish'
            ), $instance ) );
            $output = '<ul id="be-recent-comments" class="be-recent-comments">';
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
                    $output .= '<span class="comment-on">'.__('comments on', 'blog-elite').'</span>';
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

        do_action( 'blog_elite_after_recent_comments');

        $this->widget_end($args);

        echo ob_get_clean();
    }

}