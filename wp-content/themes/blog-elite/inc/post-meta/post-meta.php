<?php
/**
 * Implement posts metabox.
 *
 * @package Blog_Elite
 */

if ( ! function_exists( 'blog_elite_add_theme_meta_box' ) ) :

	/**
	 * Add the Meta Box
	 *
	 * @since 1.0.0
	 */
	function blog_elite_add_theme_meta_box() {

		$post_types = array( 'post', 'page');

		foreach ( $post_types as $post_type ) {
			add_meta_box(
				'blog-elite-meta-box',
                sprintf( esc_html__( '%1s Settings', 'blog-elite' ), ucwords($post_type) ),
				'blog_elite_meta_box_html',
                $post_type
			);
		}

	}

endif;
add_action( 'add_meta_boxes', 'blog_elite_add_theme_meta_box' );

if ( ! function_exists( 'blog_elite_meta_box_html' ) ) :

	/**
	 * Render theme settings meta box.
	 *
	 * @since 1.0.0
	 */
	function blog_elite_meta_box_html( $post ) {

        wp_nonce_field( basename( __FILE__ ), 'blog_elite_meta_box_nonce' );
        
        $page_layout = get_post_meta($post->ID,'blog_elite_page_layout',true);

        $layouts = blog_elite_get_general_layouts();
        ?>
        <div id="blog-elite-settings-metabox-container" class='inside be-meta-box'>
            <h3><label for="page-layout"><?php echo __( 'Page Layout', 'blog-elite' ); ?></label></h3>
            <div class="be-post-meta-image-select-wrap be-radio-image">
                <?php
                if(!empty($layouts) && is_array($layouts)){
                    foreach ( $layouts as $value => $option ) : ?>
                        <input class="image-select" type="radio" id="<?php echo esc_attr( $value ); ?>" name="blog_elite_page_layout" value="<?php echo esc_attr( $value ); ?>" <?php checked( $value, $page_layout ); ?>>
                        <label for="<?php echo esc_attr( $value ); ?>">
                            <img src="<?php echo esc_html( $option['url'] ); ?>" alt="<?php echo esc_attr( $option['label'] ); ?>" title="<?php echo esc_attr( $option['label'] ); ?>">
                        </label>
                    <?php endforeach;
                }
                ?>
            </div>
            <hr/>
        </div>
        <?php
	}

endif;


if ( ! function_exists( 'blog_elite_save_postdata' ) ) :

	/**
	 * Save posts meta box value.
	 *
	 * @since 1.0.0
	 *
	 * @param int  $post_id Post ID.
	 */
	function blog_elite_save_postdata( $post_id ) {

		// Verify nonce.
		if ( ! isset( $_POST['blog_elite_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['blog_elite_meta_box_nonce'], basename( __FILE__ ) ) ) {
			  return; }

		// Bail if auto save or revision.
		if ( defined( 'DOING_AUTOSAVE' ) || is_int( wp_is_post_revision( $post_id ) ) || is_int( wp_is_post_autosave( $post_id ) ) ) {
			return;
		}

		// Check the post being saved == the $post_id to prevent triggering this call for other save_post events.
		if ( empty( $_POST['post_ID'] ) || $_POST['post_ID'] != $post_id ) {
			return;
		}

		// Check permission.
		if ( 'page' === $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
        }else if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

        if ( isset( $_POST['blog_elite_page_layout'] )){
            $valid_layout_values = array(
                'left-sidebar',
                'right-sidebar',
                'no-sidebar',
                'no-sidebar-boxed',
            );
            $layout_value = sanitize_text_field( $_POST['blog_elite_page_layout'] );
            if( in_array( $layout_value, $valid_layout_values ) ) {
                update_post_meta($post_id, 'blog_elite_page_layout', $layout_value);
            }else{
                delete_post_meta($post_id,'blog_elite_page_layout');
            }
        }
	}

endif;
add_action( 'save_post', 'blog_elite_save_postdata' );

if(!function_exists('blog_elite_post_meta_admin_scripts')):
    /**
     * Styles and Scripts for meta box
     *
     * @since 1.0.0
     *
     */
    function blog_elite_post_meta_admin_scripts($hook) {
        global $post_type;

        if($hook != 'post-new.php' && $hook != 'post.php') {
            return;
        }
        if($post_type != 'post' && $post_type != 'page'){
            return;
        }
        wp_enqueue_style( 'post_meta_css', get_template_directory_uri().'/inc/post-meta/post-meta.css' );
    }
endif;
add_action( 'admin_enqueue_scripts', 'blog_elite_post_meta_admin_scripts' );