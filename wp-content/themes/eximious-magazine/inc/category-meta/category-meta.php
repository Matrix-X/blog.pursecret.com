<?php
/*Category add form fields*/
if(!function_exists('eximious_magazine_add_category_fields')):
    function eximious_magazine_add_category_fields() {
        ?>
        <div class="form-field term-color-wrap">
            <label for="term-colorpicker"><?php _e( 'Category Color', 'eximious-magazine' ); ?></label>
            <input name="category_color" class="colorpicker" id="term-colorpicker" />
            <p><?php _e('Select color for this category that will be displayed on the front end on many sections.','eximious-magazine');?></p>
        </div>
        <?php
    }
endif;
add_action( 'category_add_form_fields', 'eximious_magazine_add_category_fields'  );

/*Category edit form fields*/
if(!function_exists('eximious_magazine_edit_category_fields')):
    function eximious_magazine_edit_category_fields($term) {
        $color = get_term_meta( $term->term_id, 'category_color', true );
        ?>
        <tr class="form-field term-color-wrap">
            <th scope="row"><label for="term-colorpicker"><?php _e( 'Category Color', 'eximious-magazine' ); ?></label></th>
            <td>
                <input name="category_color" value="<?php echo esc_attr($color); ?>" class="colorpicker" id="term-colorpicker" />
                <p class="description"><?php _e('Select color for this category that will be displayed on the front end on many sections.','eximious-magazine');?></p>
            </td>
        </tr>
        <?php
    }
endif;
add_action( 'category_edit_form_fields', 'eximious_magazine_edit_category_fields' , 10 );

/*Save Category fields*/
if(!function_exists('eximious_magazine_save_category_fields')):
    function eximious_magazine_save_category_fields($term_id) {
        if ( isset( $_POST['category_color'] ) && ! empty( $_POST['category_color']) ) {
            update_term_meta( $term_id, 'category_color', sanitize_hex_color( $_POST['category_color'] ) );
        }else{
            delete_term_meta( $term_id, 'category_color' );
        }
    }
endif;
add_action( 'created_category', 'eximious_magazine_save_category_fields' , 10, 3 );
add_action( 'edited_category', 'eximious_magazine_save_category_fields' , 10, 3 );

/* Category Js */
if(!function_exists('eximious_magazine_category_js')):
    function eximious_magazine_category_js(){
        if( null !== ( $screen = get_current_screen() ) && 'edit-category' !== $screen->id ) {
            return;
        }
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
    }
endif;
add_action( 'admin_enqueue_scripts', 'eximious_magazine_category_js' );

if(!function_exists('eximious_magazine_colorpicker_init_inline')):
    function eximious_magazine_colorpicker_init_inline() {
        if( null !== ( $screen = get_current_screen() ) && 'edit-category' !== $screen->id ) {
            return;
        }
        ?>
        <script>
            jQuery( document ).ready( function( $ ) {
                jQuery( '.colorpicker' ).wpColorPicker();
            } );

        </script>
        <?php
    }
endif;
add_action( 'admin_print_scripts', 'eximious_magazine_colorpicker_init_inline', 20 );