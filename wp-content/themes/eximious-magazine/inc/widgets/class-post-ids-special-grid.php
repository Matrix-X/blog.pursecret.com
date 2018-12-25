<?php

if (!defined('ABSPATH')) {
    exit;
}

class Eximious_Magazine_Post_Ids_Special_Grid extends Eximious_Magazine_Widget_Base{

    /**
     * Constructor.
     */
    public function __construct(){

        $this->widget_cssclass = 'eximious_magazine widget_post_ids_special_grid';
        $this->widget_description = __("Displays posts in special grid style", 'eximious-magazine');
        $this->widget_id = 'eximious_magazine_post_ids_special_grid';
        $this->widget_name = __('EM: Special Grid Posts', 'eximious-magazine');

        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'label' => __('Title', 'eximious-magazine'),
            ),
            'post_ids' => array(
                'type' => 'text',
                'label' => __('Enter Post ID\'s', 'eximious-magazine'),
                'desc' => __('Post IDs, separated by commas. Eg: 1, 2, 3', 'eximious-magazine'),
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
            'special_grid_style' => array(
                'type' => 'select',
                'label' => __('Special Grid Style', 'eximious-magazine'),
                'options' => array(
                    '' => __('&mdash; None &mdash;', 'eximious-magazine'),
                    'grid_style_1' => __('Style 1', 'eximious-magazine'),
                    'grid_style_2' => __('Style 2', 'eximious-magazine'),
                ),
                'std' => 'grid_style_1',
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

        if (!empty($instance['post_ids'])) {

            $post_ids = explode(',', esc_attr($instance['post_ids']));

            $post_args = array(
                'post_type' => 'post',
                'post__in' => $post_ids,
                'orderby' => 'post__in',
                'posts_per_page' => count($post_ids),
                'ignore_sticky_posts' => 1
            );
            $query = new WP_Query($post_args);

            if($query->have_posts()){

                $this->widget_start($args, $instance);

                $counter = 1;

                $special_grid_style = '';

                if($instance['special_grid_style']){
                    $special_grid_style = esc_attr($instance['special_grid_style']);
                }

                do_action('eximious_magazine_before_post_ids_special_grid');
                ?>
                <div class="eximious_magazine_post_ids_special_grid_widget em-grid-posts clearfix <?php echo esc_attr($special_grid_style)?>">
                    <?php
                    while ($query->have_posts()):$query->the_post();
                        $image_size = 'eximious-magazine-medium-img';
                        if('' != $special_grid_style){
                            if('grid_style_1' == $special_grid_style){
                                if($counter > 4){
                                    $loop_counter = 'one-third col-3';
                                }else{
                                    $loop_counter = $counter.' col-2';
                                    if($counter == 2 || $counter == 3){
                                        $loop_counter = $counter.' col-4';
                                    }
                                    /*Add proper image size*/
                                    if($counter == 1){
                                        $image_size = 'eximious-magazine-large-img';
                                    }
                                    if($counter == 4){
                                        $image_size = 'eximious-magazine-horizontal-img';
                                    }
                                    /**/
                                }
                            }else{
                                if($counter > 5){
                                    $loop_counter = 'one-third col-3';
                                }else{
                                    $loop_counter = $counter.' col-4';
                                    if($counter == 1){
                                        $loop_counter = $counter.' col-2';
                                        $image_size = 'eximious-magazine-large-img';
                                    }
                                }
                            }
                        }else{
                            $loop_counter = 'one-third col-3';
                        }
                        ?>
                        <div class="posts-<?php echo esc_attr($loop_counter);?> common-grid">
                            <div class="gridbox">
                                <div class="post-thumbnail">
                                    <?php
                                    $style = '';
                                    if(has_post_thumbnail()){
                                        $image = get_the_post_thumbnail_url( get_the_ID(), $image_size );
                                        $style = "background-image: url( ".esc_url($image). ")";
                                    }?>
                                    <a href="<?php the_permalink()?>">
                                        <span class="bg-image" style="<?php echo esc_attr($style);?>"></span>
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
                    $counter++;
                    endwhile;wp_reset_postdata();
                    ?>
                </div>
                <?php
                do_action('eximious_magazine_after_post_ids_special_grid');

                $this->widget_end($args);
            }
        }
        echo ob_get_clean();
    }

}