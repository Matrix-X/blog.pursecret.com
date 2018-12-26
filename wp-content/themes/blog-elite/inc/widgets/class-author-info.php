<?php
/**
 * Adds Blog_Elite_Author_Info widget.
 */
class Blog_Elite_Author_Info extends WP_Widget {

    public $social_networks;

    /**
     * Sets up a new widget instance.
     *
     * @since 1.0.0
     */
    function __construct() {
        parent::__construct(
            'blog_elite_author_info_widget',
            esc_html__( 'BE: Author Info', 'blog-elite' ),
            array( 'description' => esc_html__( 'Displays author short info.', 'blog-elite' ), )
        );

        $this->social_networks = apply_filters( 'blog_elite_author_widget_social_networks', array(
                'facebook' => '<i class="fab fa-facebook-f"></i>',
                'twitter' => '<i class="fab fa-twitter"></i>',
                'gplus' => '<i class="fab fa-google-plus-g"></i>',
                'linkedin' => '<i class="fab fa-linkedin"></i>',
                'instagram' => '<i class="fab fa-instagram"></i>',
                'pinterest' => '<i class="fab fa-pinterest"></i>',
                'youtube' => '<i class="fab fa-youtube"></i>',
        ));
    }

    /**
     * Outputs the content for the current widget instance.
     *
     * @since 1.0.0
     *
     * @param array $args  Display arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        if ( $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        do_action( 'blog_elite_before_author_info');
        ?>
        <div class="be-author-info">
            <?php
            if($instance['author_img']){
                ?>
                <div class="author-image be-bg-image">
                    <?php echo wp_get_attachment_image( absint($instance['author_img']), 'full', "", array( "class" => "img-responsive" ) );  ?>
                </div>
                <?php
            }
            ?>
            <div class="author-details">
                <?php
                if($instance['author_name']){
                    ?>
                    <h3 class="author-name"><?php echo esc_html($instance['author_name']); ?></h3>
                    <?php
                }
                ?>
                <div class="author-social">
                    <?php
                    $social_networks = $this->social_networks;
                    if(!empty($social_networks) && is_array($social_networks)){
                        foreach($social_networks as $network => $icon){
                            if(!empty($instance[$network])){
                                ?>
                                <a href="<?php echo esc_url($instance[$network]); ?>" target="_blank">
                                    <?php echo $icon;?>
                                </a>
                                <?php
                            }
                        }
                    }
                    ?>
                </div>
                <div class="author-desc">
                    <?php
                    if($instance['author_desc']){
                        echo wpautop(wp_kses_post($instance['author_desc']));
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php

        do_action( 'blog_elite_after_author_info');

        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @since 1.0.0
     *
     * @param array $instance Previously saved values from database.
     *
     * @return void
     */
    public function form( $instance ) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $author_name = !empty($instance['author_name']) ? $instance['author_name'] : '';
        $author_desc = !empty($instance['author_desc']) ? $instance['author_desc'] : '';
        $author_img = !empty($instance['author_img']) ? $instance['author_img'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php esc_attr_e('Title:', 'blog-elite'); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('author_name')); ?>">
                <?php esc_attr_e('Author Name:', 'blog-elite'); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('author_name')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('author_name')); ?>" type="text"
                   value="<?php echo esc_attr($author_name); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('author_desc')); ?>">
                <?php esc_attr_e('Short Description:', 'blog-elite'); ?>
            </label>
            <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('author_desc')); ?>"
                      name="<?php echo esc_attr($this->get_field_name('author_desc')); ?>" rows="10"><?php echo esc_textarea($author_desc);?></textarea>
        </p>
        <div>
            <label for="<?php echo esc_attr( $this->get_field_id( 'author_img' ) ); ?>">
                <?php esc_attr_e('Author Image:', 'blog-elite'); ?>
            </label>
            <?php
            $remove_button_style = ($author_img) ? 'display:inline-block' : 'display:none;';?>
            <div class="image-field">
                <div class="image-preview">
                    <?php
                    if ( ! empty( $author_img ) ) {
                        $image_attributes = wp_get_attachment_image_src( $author_img );
                        if($image_attributes){
                            ?>
                            <img src="<?php echo esc_url( $image_attributes[0] ); ?>" />
                            <?php
                        }
                    }
                    ?>
                </div>
                <p>
                    <input type="hidden" class="img" name="<?php echo esc_attr( $this->get_field_name( 'author_img' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'author_img' ) ); ?>" value="<?php echo esc_attr( $author_img ); ?>" />
                    <button type="button" class="upload_image_button button" data-uploader-title-txt="<?php esc_attr_e( 'Use Image', 'blog-elite' ); ?>" data-uploader-btn-txt="<?php esc_attr_e( 'Choose an Image', 'blog-elite' ); ?>">
                        <?php _e( 'Upload/Add image', 'blog-elite' ); ?>
                    </button>
                    <button type="button" class="remove_image_button button" style="<?php echo esc_attr($remove_button_style);?>"><?php _e( 'Remove image', 'blog-elite' ); ?></button>
                </p>
            </div>
        </div>
        <?php
        $social_networks = $this->social_networks;
        if(!empty($social_networks) && is_array($social_networks)){
            foreach ($social_networks as $network => $icon){
                $social_link = !empty($instance[$network]) ? $instance[$network] : '';
                ?>
                <p class="be-social-link">
                    <label for="<?php echo esc_attr($this->get_field_id($network)); ?>">
                        <?php echo esc_html(ucfirst($network)); ?>
                    </label>
                    <input class="widefat" id="<?php echo esc_attr($this->get_field_id($network)); ?>"
                           name="<?php echo esc_attr($this->get_field_name($network)); ?>" type="text"
                           value="<?php echo esc_url($social_link); ?>">
                </p>
                <?php
            }
        }
        ?>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @since 1.0.0
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();

        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['author_name'] = (!empty($new_instance['author_name'])) ? sanitize_text_field($new_instance['author_name']) : '';
        $instance['author_desc'] = (!empty($new_instance['author_desc'])) ? wp_kses_post($new_instance['author_desc']) : '';
        $instance['author_img'] = (!empty($new_instance['author_img'])) ? absint($new_instance['author_img']) : '';

        $social_networks = $this->social_networks;
        if(!empty($social_networks) && is_array($social_networks)){
            foreach($social_networks as $network => $icon){
                $instance[$network] = (!empty($new_instance[$network])) ? esc_url_raw($new_instance[$network]) : '';
            }
        }

        return $instance;
    }

}