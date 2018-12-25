<?php
/*Get customizer values.*/
if ( ! function_exists( 'eximious_magazine_get_option' ) ) :
    /**
     * Get customizer value by key.
     *
     * @since 1.0.0
     *
     * @param string $key Option key.
     * @return mixed Option value.
     */
    function eximious_magazine_get_option($key) {
        $key_value = '';
        if(!$key){
            return $key_value;
        }
        $default_values = eximious_magazine_get_default_customizer_values();
        $customizer_values = get_theme_mod( 'theme_options' );
        $customizer_values = wp_parse_args( $customizer_values, $default_values );

        $key_value = ( isset( $customizer_values[ $key ] ) ) ? $customizer_values[ $key ] : '';
        return $key_value;
    }
endif;

/* Check if is WooCommerce is active */
if ( ! function_exists( 'eximious_magazine_is_wc_active' ) ) :
    /**
     * Check WooCommerce Status
     *
     * @since 1.0.0
     *
     * return boolean true/false
     */
    function eximious_magazine_is_wc_active() {
        return class_exists( 'WooCommerce' ) ? true : false;
    }
endif;

/* Check if is WP Post Author is active */
if ( ! function_exists( 'eximious_magazine_is_wp_post_author_active' ) ) :
    /**
     * Check WP Post Author Status
     *
     * @since 1.0.0
     *
     * return boolean true/false
     */
    function eximious_magazine_is_wp_post_author_active() {
        return class_exists( 'WP_Post_Author' ) ? true : false;
    }
endif;

/* Change default excerpt length */
if ( ! function_exists( 'eximious_magazine_excerpt_length' ) ) :
    /**
     * Change excerpt Length.
     *
     * @since 1.0.0
     */
    function eximious_magazine_excerpt_length($excerpt_length) {
        if( is_admin() && !wp_doing_ajax() ){
            return $excerpt_length;
        }
        $excerpt_length = eximious_magazine_get_option('excerpt_length');
        return absint($excerpt_length);
    }
endif;
add_filter( 'excerpt_length', 'eximious_magazine_excerpt_length', 999 );

/* Modify Excerpt Read More text */
if ( ! function_exists( 'eximious_magazine_excerpt_more' ) ) :
    /**
     * Modify Excerpt Read More text.
     *
     * @since 1.0.0
     */
    function eximious_magazine_excerpt_more($more) {
        if(is_admin()){
            return $more;
        }
        return '...';
    }
endif;
add_filter('excerpt_more', 'eximious_magazine_excerpt_more');

/* Get Page layout */
if ( ! function_exists( 'eximious_magazine_get_page_layout' ) ) :
    /**
     * Get Page Layout based on the post meta or customizer value
     *
     * @since 1.0.0
     *
     * @return string Page Layout.
     */
    function eximious_magazine_get_page_layout() {
        global $post;
        $page_layout = '';

        /*Fetch for homepage*/
        if( is_front_page() && is_home()){
            $page_layout = eximious_magazine_get_option('home_page_layout');
            return $page_layout;
        }elseif ( is_front_page() ) {
            $page_layout = eximious_magazine_get_option('home_page_layout');
            return $page_layout;
        }elseif ( is_home() ) {
            $page_layout_meta = get_post_meta( get_option( 'page_for_posts' ), 'eximious_magazine_page_layout', true );
            if(!empty($page_layout_meta)){
                return $page_layout_meta;
            }else{
                return $page_layout;
            }
        }
        /**/

        /*Fetch from Post Meta*/
        if ( $post && is_singular() ) {
            $page_layout = get_post_meta( $post->ID, 'eximious_magazine_page_layout', true );
        }
        /*Fetch from customizer*/
        if(empty($page_layout)){
            $page_layout = eximious_magazine_get_option('global_layout');
        }
        return $page_layout;
    }
endif;

if ( ! function_exists( 'eximious_magazine_get_all_image_sizes' ) ) :
    /**
     * Returns all image sizes available.
     *
     * @since 1.0.0
     *
     * @param bool $for_choice True/False to construct the output as key and value choice
     * @return array Image Size Array.
     */
    function eximious_magazine_get_all_image_sizes( $for_choice = false ) {

        global $_wp_additional_image_sizes;

        $sizes = array();

        if( true == $for_choice ){
            $sizes['no-image'] = __( 'No Image', 'eximious-magazine' );
        }

        foreach ( get_intermediate_image_sizes() as $_size ) {
            if ( in_array( $_size, array('thumbnail', 'medium', 'large') ) ) {

                $width = get_option( "{$_size}_size_w" );
                $height = get_option( "{$_size}_size_h" );

                if( true == $for_choice ){
                    $sizes[$_size] = ucfirst($_size) . ' (' . $width . 'x' . $height . ')';
                }else{
                    $sizes[ $_size ]['width']  = $width;
                    $sizes[ $_size ]['height'] = $height;
                    $sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
                }
            } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {

                $width = $_wp_additional_image_sizes[ $_size ]['width'];
                $height = $_wp_additional_image_sizes[ $_size ]['height'];

                if( true == $for_choice ){
                    $sizes[$_size] = ucfirst($_size) . ' (' . $width . 'x' . $height . ')';
                }else{
                    $sizes[ $_size ] = array(
                        'width'  => $width,
                        'height' => $height,
                        'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
                    );
                }
            }
        }

        if( true == $for_choice ){
            $sizes['full'] = __( 'Full Image', 'eximious-magazine' );
        }

        return $sizes;
    }
endif;

if ( ! function_exists( 'eximious_magazine_get_general_layouts' ) ) :
    /**
     * Returns general layout options.
     *
     * @since 1.0.0
     *
     * @return array Options array.
     */
    function eximious_magazine_get_general_layouts() {
        $options = apply_filters( 'eximious_magazine_general_layouts', array(
            'left-sidebar'  => array(
                'url'   => get_template_directory_uri().'/assets/images/left_sidebar.png',
                'label' => esc_html__( 'Left Sidebar', 'eximious-magazine' ),
            ),
            'right-sidebar' => array(
                'url'   => get_template_directory_uri().'/assets/images/right_sidebar.png',
                'label' => esc_html__( 'Right Sidebar', 'eximious-magazine' ),
            ),
            'no-sidebar'    => array(
                'url'   => get_template_directory_uri().'/assets/images/no_sidebar.png',
                'label' => esc_html__( 'No Sidebar', 'eximious-magazine' ),
            )
        ) );
        return $options;
    }
endif;

if ( ! function_exists( 'eximious_magazine_get_archive_layouts' ) ) :
    /**
     * Returns archive layout options.
     *
     * @since 1.0.0
     *
     * @return array Options array.
     */
    function eximious_magazine_get_archive_layouts() {
        $options = apply_filters( 'eximious_magazine_archive_layouts', array(
            'archive_style_1'  => array(
                'url'   => get_template_directory_uri().'/assets/images/single_column.png',
                'label' => esc_html__( 'Single Column', 'eximious-magazine' ),
            ),
            'archive_style_2' => array(
                'url'   => get_template_directory_uri().'/assets/images/full_column.png',
                'label' => esc_html__( 'Full Column', 'eximious-magazine' ),
            ),
        ) );
        return $options;
    }
endif;

if ( ! function_exists( 'eximious_magazine_header_styles' ) ) :
    /**
     * Apply inline style to the Eximious Magazine header.
     *
     * @uses  get_header_image()
     * @since  1.0.0
     */
    function eximious_magazine_header_styles() {
        $is_header_image = get_header_image();
        $header_bg_image = '';

        if ( $is_header_image ) {
            $header_bg_image = 'url(' . esc_url( $is_header_image ) . ')';
        }

        $styles = array();

        if ( '' !== $header_bg_image ) {
            $styles['background-image'] = $header_bg_image;
        }

        $styles = apply_filters( 'eximious_magazine_header_styles', $styles );

        foreach ( $styles as $style => $value ) {
            echo esc_attr( $style . ': ' . $value . '; ' );
        }
    }
endif;

if ( ! function_exists( 'eximious_magazine_posts_navigation' ) ) :
    /**
     * Display Pagination.
     *
     * @since 1.0.0
     */
    function eximious_magazine_posts_navigation() {
        $pagination_type = eximious_magazine_get_option( 'pagination_type' );
        switch ( $pagination_type ) {
            case 'default':
                the_posts_navigation();
                break;
            case 'numeric':
                the_posts_pagination();
                break;
            default:
                break;
        }
        return;
    }
endif;