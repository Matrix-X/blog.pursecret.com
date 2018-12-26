<?php
/*Get customizer values.*/
if ( ! function_exists( 'blog_elite_get_option' ) ) :
    /**
     * Get customizer value by key.
     *
     * @since 1.0.0
     *
     * @param string $key Option key.
     * @return mixed Option value.
     */
    function blog_elite_get_option($key) {
        $key_value = '';
        if(!$key){
            return $key_value;
        }
        $default_values = blog_elite_get_default_customizer_values();
        $customizer_values = get_theme_mod( 'theme_options' );
        $customizer_values = wp_parse_args( $customizer_values, $default_values );

        $key_value = ( isset( $customizer_values[ $key ] ) ) ? $customizer_values[ $key ] : '';
        return $key_value;
    }
endif;

/* Check if is WooCommerce is active */
if ( ! function_exists( 'blog_elite_is_wc_active' ) ) :
    /**
     * Check WooCommerce Status
     *
     * @since 1.0.0
     *
     * return boolean true/false
     */
    function blog_elite_is_wc_active() {
        return class_exists( 'WooCommerce' ) ? true : false;
    }
endif;

/* Check if is WP Post Author is active */
if ( ! function_exists( 'blog_elite_is_wp_post_author_active' ) ) :
    /**
     * Check WP Post Author Status
     *
     * @since 1.0.0
     *
     * return boolean true/false
     */
    function blog_elite_is_wp_post_author_active() {
        return class_exists( 'WP_Post_Author' ) ? true : false;
    }
endif;

/* Change default excerpt length */
if ( ! function_exists( 'blog_elite_excerpt_length' ) ) :
    /**
     * Change excerpt Length.
     *
     * @since 1.0.0
     */
    function blog_elite_excerpt_length($excerpt_length) {
        if( is_admin() && !wp_doing_ajax() ){
            return $excerpt_length;
        }
        $excerpt_length = blog_elite_get_option('excerpt_length');
        return absint($excerpt_length);
    }
endif;
add_filter( 'excerpt_length', 'blog_elite_excerpt_length', 999 );

/* Modify Excerpt Read More text */
if ( ! function_exists( 'blog_elite_excerpt_more' ) ) :
    /**
     * Modify Excerpt Read More text.
     *
     * @since 1.0.0
     */
    function blog_elite_excerpt_more($more) {
        if(is_admin()){
            return $more;
        }
        return '...';
    }
endif;
add_filter('excerpt_more', 'blog_elite_excerpt_more');

/* Get Page layout */
if ( ! function_exists( 'blog_elite_get_page_layout' ) ) :
    /**
     * Get Page Layout based on the post meta or customizer value
     *
     * @since 1.0.0
     *
     * @return string Page Layout.
     */
    function blog_elite_get_page_layout() {
        global $post;
        $page_layout = '';

        /*Fetch for homepage*/
        if( is_front_page() && is_home()){
            $page_layout = blog_elite_get_option('home_page_layout');
            return $page_layout;
        }elseif ( is_front_page() ) {
            $page_layout = blog_elite_get_option('home_page_layout');
            return $page_layout;
        }elseif ( is_home() ) {
            $page_layout_meta = get_post_meta( get_option( 'page_for_posts' ), 'blog_elite_page_layout', true );
            if(!empty($page_layout_meta)){
                return $page_layout_meta;
            }else{
                $page_layout = blog_elite_get_option('global_sidebar_layout');
                return $page_layout;
            }
        }
        /**/

        /*Fetch from Post Meta*/
        if ( $post && is_singular() ) {
            $page_layout = get_post_meta( $post->ID, 'blog_elite_page_layout', true );
        }
        /*Fetch from customizer*/
        if(empty($page_layout)){
            $page_layout = blog_elite_get_option('global_sidebar_layout');
        }
        return $page_layout;
    }
endif;

if ( ! function_exists( 'blog_elite_get_all_image_sizes' ) ) :
    /**
     * Returns all image sizes available.
     *
     * @since 1.0.0
     *
     * @param bool $for_choice True/False to construct the output as key and value choice
     * @return array Image Size Array.
     */
    function blog_elite_get_all_image_sizes( $for_choice = false ) {

        global $_wp_additional_image_sizes;

        $sizes = array();

        if( true == $for_choice ){
            $sizes['no-image'] = __( 'No Image', 'blog-elite' );
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
            $sizes['full'] = __( 'Full Image', 'blog-elite' );
        }

        return $sizes;
    }
endif;

if ( ! function_exists( 'blog_elite_get_header_layouts' ) ) :
    /**
     * Returns header layout options.
     *
     * @since 1.0.0
     *
     * @return array Options array.
     */
    function blog_elite_get_header_layouts() {
        $options = apply_filters( 'blog_elite_header_layouts', array(
            'header_style_1'  => array(
                'url'   => get_template_directory_uri().'/assets/images/header1.png',
                'label' => esc_html__( 'Header Style 1', 'blog-elite' ),
            ),
            'header_style_2' => array(
                'url'   => get_template_directory_uri().'/assets/images/header2.png',
                'label' => esc_html__( 'Header Style 2', 'blog-elite' ),
            ),
        ) );
        return $options;
    }
endif;

if ( ! function_exists( 'blog_elite_get_footer_layouts' ) ) :
    /**
     * Returns footer layout options.
     *
     * @since 1.0.0
     *
     * @return array Options array.
     */
    function blog_elite_get_footer_layouts() {
        $options = apply_filters( 'blog_elite_footer_layouts', array(
            'footer_layout_1'  => array(
                'url'   => get_template_directory_uri().'/assets/images/footer-col-4.png',
                'label' => esc_html__( 'Four Columns', 'blog-elite' ),
            ),
            'footer_layout_2' => array(
                'url'   => get_template_directory_uri().'/assets/images/footer-col-3.png',
                'label' => esc_html__( 'Three Columns', 'blog-elite' ),
            ),
            'footer_layout_3' => array(
                'url'   => get_template_directory_uri().'/assets/images/footer-col-2.png',
                'label' => esc_html__( 'Two Columns', 'blog-elite' ),
            ),
        ) );
        return $options;
    }
endif;

if ( ! function_exists( 'blog_elite_get_general_layouts' ) ) :
    /**
     * Returns general layout options.
     *
     * @since 1.0.0
     *
     * @return array Options array.
     */
    function blog_elite_get_general_layouts() {
        $options = apply_filters( 'blog_elite_general_layouts', array(
            'left-sidebar'  => array(
                'url'   => get_template_directory_uri().'/assets/images/left_sidebar.png',
                'label' => esc_html__( 'Left Sidebar', 'blog-elite' ),
            ),
            'right-sidebar' => array(
                'url'   => get_template_directory_uri().'/assets/images/right_sidebar.png',
                'label' => esc_html__( 'Right Sidebar', 'blog-elite' ),
            ),
            'no-sidebar'    => array(
                'url'   => get_template_directory_uri().'/assets/images/no_sidebar.png',
                'label' => esc_html__( 'No Sidebar', 'blog-elite' ),
            ),
            'no-sidebar-boxed'    => array(
                'url'   => get_template_directory_uri().'/assets/images/no-sidebar-boxed.png',
                'label' => esc_html__( 'No Sidebar - Boxed', 'blog-elite' ),
            )
        ) );
        return $options;
    }
endif;

if ( ! function_exists( 'blog_elite_get_archive_layouts' ) ) :
    /**
     * Returns archive layout options.
     *
     * @since 1.0.0
     *
     * @return array Options array.
     */
    function blog_elite_get_archive_layouts() {
        $options = apply_filters( 'blog_elite_archive_layouts', array(
            'archive_style_1'  => array(
                'url'   => get_template_directory_uri().'/assets/images/single_column.png',
                'label' => esc_html__( 'Single Column', 'blog-elite' ),
            ),
            'archive_style_2' => array(
                'url'   => get_template_directory_uri().'/assets/images/full_column.png',
                'label' => esc_html__( 'Full Column', 'blog-elite' ),
            ),
        ) );
        return $options;
    }
endif;

if ( ! function_exists( 'blog_elite_header_styles' ) ) :
    /**
     * Display classes and inline style to the Blog Elite header.
     *
     * @uses  get_header_image()
     * @since  1.0.0
     */
    function blog_elite_header_styles() {
        $is_header_image = get_header_image();
        $header_bg_image = '';

        if ( $is_header_image ) {
            $header_bg_image = 'url(' . esc_url( $is_header_image ) . ')';
        }

        $classes = '';
        $final_styles = $styles = array();

        if ( '' !== $header_bg_image ) {
            $classes = 'be-site-brand-wrap';
            $styles['background-image'] = $header_bg_image;
        }

        $classes = apply_filters( 'blog_elite_header_classes', $classes );
        $styles = apply_filters( 'blog_elite_header_styles', $styles );

        foreach ( $styles as $style => $value ) {
            $final_styles[] = esc_attr( $style . ': ' . $value . '; ' );
        }

        if(!empty($final_styles) || !empty($classes)){
            echo 'class="'.esc_attr($classes).'" style="'.join('', $final_styles).'"';
        }

    }
endif;

if ( ! function_exists( 'blog_elite_top_bar' ) ) :
    /**
     * Display top bar
     *
     * @since 1.0.0
     *
     */
    function blog_elite_top_bar() {
        $container_class = '';
        $top_bar_layout = blog_elite_get_option('top_bar_layout');
        if('boxed' == $top_bar_layout){
            $container_class = 'saga-container';
        }
        ?>
        <div class="saga-topnav">
            <div class="saga-topnav-wrap <?php echo esc_attr($container_class);?>">
                <?php
                $enable_trending_posts = blog_elite_get_option('enable_trending_posts');
                $enable_top_bar_social_nav = blog_elite_get_option('enable_top_bar_social_nav');

                if($enable_trending_posts){

                    $trending_post_cat = blog_elite_get_option('trending_post_cat');
                    $no_of_trending_posts = absint(blog_elite_get_option('no_of_trending_posts'));
                    $trending_orderby = esc_attr(blog_elite_get_option('trending_orderby'));
                    $trending_order = esc_attr(blog_elite_get_option('trending_order'));
                    $trending_post_text = blog_elite_get_option('trending_post_text');

                    $post_args = array(
                        'post_type' => 'post',
                        'post_status' => 'publish',
                        'posts_per_page' => $no_of_trending_posts,
                        'orderby' => $trending_orderby,
                        'order' => $trending_order,
                        'no_found_rows' => 1,
                        'ignore_sticky_posts' => 1,
                    );
                    if(!empty($trending_post_cat)){
                        $post_args['tax_query'][] = array(
                            'taxonomy' => 'category',
                            'field' => 'term_id',
                            'terms' => absint($trending_post_cat),
                        );
                    }

                    $trending_posts = new WP_Query($post_args);
                    if($trending_posts->have_posts()){
                        ?>
                        <div class="be-trending-posts">
                            <?php
                            if($trending_post_text){
                                ?>
                                <span class="trending-now-title">
                                        <?php echo esc_html($trending_post_text);?>
                                    </span>
                                <?php
                            }

                            /*show top nav if enabled*/
                            if($enable_top_bar_social_nav){
                                blog_elite_social_menu();
                            }
                            ?>
                            <div class="be-owl-carousel-slider be-trending-now-posts owl-carousel owl-theme">
                                <?php while ($trending_posts->have_posts()):$trending_posts->the_post();?>
                                    <div class="item">
                                        <a href="<?php the_permalink()?>">
                                            <span class="trent-title"><?php the_title();?></span>
                                        </a>
                                    </div>
                                <?php endwhile;wp_reset_postdata();?>
                            </div>
                        </div>
                        <?php
                    }
                }else{
                    if($enable_top_bar_social_nav){
                        blog_elite_social_menu();
                    }
                }
                ?>
            </div>
        </div>
        <?php
    }
endif;

if ( ! function_exists( 'blog_elite_social_menu' ) ) :
    /**
     * Display social menu.
     *
     * @since 1.0.0
     *
     */
    function blog_elite_social_menu() {
        wp_nav_menu(array(
            'theme_location' => 'social-menu',
            'container_class' => 'social-navigation',
            'link_before' => '<span class="screen-reader-text">',
            'link_after' => '</span>',
            'fallback_cb' => false,
            'depth' => 1,
            'menu_class' => false
        ) );
    }
endif;

if ( ! function_exists( 'blog_elite_primary_menu' ) ) :
    /**
     * Display primary menu.
     *
     * @since 1.0.0
     *
     */
    function blog_elite_primary_menu() {
        ?>
        <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_html_e( 'Primary Navigation', 'blog-elite' ); ?>">
                <span class="toggle-menu" aria-controls="primary-menu" aria-expanded="false">
                     <span class="screen-reader-text">
                        <?php esc_html_e('Primary Menu', 'blog-elite'); ?>
                     </span>
                     <i class="ham"></i>
                </span>
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary-menu',
                'menu_id' => 'primary-menu',
                'container' => 'div',
                'container_class' => 'menu primary-navigation',
            ) );
            ?>
        </nav>
        <?php
    }
endif;

if ( ! function_exists( 'blog_elite_search_icon' ) ) :
    /**
     * Display search icon.
     *
     * @since 1.0.0
     *
     */
    function blog_elite_search_icon() {
        ?>
        <div class="saga-search-wrap">
            <div class="search-overlay">
                <a href="#" title="Search" class="search-icon">
                    <i class="fas fa-search"></i>
                </a>
                <div class="saga-search-form">
                    <?php get_search_form();?>
                </div>
            </div>
        </div>
        <?php
    }
endif;

if ( ! function_exists( 'blog_elite_site_brand' ) ) :
    /**
     * Display site logos and title & tagline.
     *
     * @since 1.0.0
     *
     */
    function blog_elite_site_brand() {
        $site_tagline_style = blog_elite_get_option('site_tagline_style');
        ?>
        <div class="site-branding <?php echo esc_attr($site_tagline_style);?>">
            <?php

            the_custom_logo();

            $site_slogan_text = blog_elite_get_option('site_slogan_text');
            if(!empty($site_slogan_text)){
                ?>
                <div class="be-site-slogan">
                    <?php echo esc_html($site_slogan_text);?>
                </div>
                <?php
            }

            if ( is_front_page() ) :
                ?>
                <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <?php
            else :
                ?>
                <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                <?php
            endif;
            $blog_elite_description = get_bloginfo( 'description', 'display' );
            if ( $blog_elite_description || is_customize_preview() ) :
                ?>
                <p class="site-description">
                    <span class="be-site-desc-wrap"><?php echo $blog_elite_description; /* WPCS: xss ok. */ ?></span>
                </p>
            <?php endif; ?>

        </div>
        <?php
    }
endif;

if ( ! function_exists( 'blog_elite_posts_navigation' ) ) :
    /**
     * Display Pagination.
     *
     * @since 1.0.0
     */
    function blog_elite_posts_navigation() {
        $pagination_type = blog_elite_get_option( 'archive_pagination_type' );
        switch ( $pagination_type ) {
            case 'default':
                the_posts_navigation();
                break;
            case 'numeric':
                if(is_front_page()){
                    $pagination_align = blog_elite_get_option( 'home_numeric_pagination_align' );
                }else{
                    $pagination_align = blog_elite_get_option( 'archive_numeric_pagination_align' );
                }
                ?>
                <div class="be-nav-pagination <?php echo esc_attr($pagination_align);?>">
                    <?php the_posts_pagination();?>
                </div>
                <?php
                break;
            default:
                break;
        }
        return;
    }
endif;

if ( ! function_exists( 'blog_elite_post_image' ) ) :
    /**
     * Display post image.
     *
     * @param string $image_size Image Size to fetch
     * @param boolean $bg Image in background
     *
     * @since 1.0.0
     */
    function blog_elite_post_image($image_size = 'thumbnail', $bg = false) {
        $class = '';
        if(true == $bg){
            $class = 'be-bg-image';
        }
        ?>
        <div class="entry-image <?php echo esc_attr($class);?>">
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
        <?php
    }
endif;

if ( ! function_exists( 'blog_elite_post_cat_info' ) ) :
    /**
     * Display post category info
     *
     * @since 1.0.0
     */
    function blog_elite_post_cat_info() {
        ?>
        <div class="be-cat-info">
            <?php the_category(' '); ?>
        </div>
        <?php
    }
endif;

if ( ! function_exists( 'blog_elite_post_meta_info' ) ) :
    /**
     * Display post meta info.
     *
     * @param boolean $author Show author
     * @param boolean $date Show date
     * @param boolean $comment Show comment link
     *
     * @since 1.0.0
     */
    function blog_elite_post_meta_info($author = true, $date = true, $comment = true) {
        ?>
        <div class="be-meta-info">
            <?php
            if($author){
                ?>
                <div class="author-name">
                    <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>">
                        <?php the_author(); ?>
                    </a>
                </div>
                <?php
            }

            if($date){
                ?>
                <div class="post-date"><?php echo esc_html(get_the_date()); ?></div>
                <?php
            }

            if($comment){
                if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
                    ?>
                    <div class="post-comment">
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
    }
endif;

if ( ! function_exists( 'blog_elite_post_excerpt_info' ) ) :
    /**
     * Display post excerpt info
     *
     * @since 1.0.0
     */
    function blog_elite_post_excerpt_info() {
        ?>
        <div class="entry-content">
            <?php
            $excerpt_read_more_text = blog_elite_get_option('excerpt_read_more_text');
            $excerpt_length = blog_elite_get_option('archive_excerpt_length');

            $content = wp_trim_words( get_the_excerpt(), $excerpt_length, '...' );
            echo apply_filters( 'the_excerpt', $content );

            wp_link_pages( array(
                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'blog-elite' ),
                'after'  => '</div>',
            ) );
            ?>
            <?php if($excerpt_read_more_text){ ?>
                <div class="be-read-more">
                    <a class="readmore-btn" href="<?php the_permalink();?>">
                        <?php echo esc_html($excerpt_read_more_text);?>
                    </a>
                </div>
            <?php } ?>
        </div>
        <?php
    }
endif;

if ( ! function_exists( 'blog_elite_front_page_posts' ) ) :
    /**
     * Displays posts on front page
     *
     * @since 1.0.0
     *
     */
    function blog_elite_front_page_posts() {

        /*Set paged attribute for pagination*/
        if ( get_query_var('paged') ) {
            $paged = absint(get_query_var('paged'));
        } elseif ( get_query_var('page') ) {
            $paged = absint(get_query_var('page'));
        } else {
            $paged = 1;
        }

        $front_blog_style = blog_elite_get_option('front_blog_style');
        $posts_args = array(
            'post_status' => 'publish',
            'post_type' => 'post',
            'paged' => $paged,
        );
        $latest_posts = new WP_Query($posts_args);
        if($latest_posts->have_posts()):
            set_query_var('archive_style', $front_blog_style);
            ?>
            <section class="blog-elite-latest-posts em-front-page-content <?php echo esc_attr($front_blog_style);?>">
                <?php
                while($latest_posts->have_posts()):$latest_posts->the_post();
                    get_template_part('template-parts/content', get_post_type());
                endwhile;
                $front_page_pagination_type = blog_elite_get_option('front_page_pagination_type');
                if('numeric' == $front_page_pagination_type){
                    $big = 999999999;
                    $links = paginate_links( array(
                        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                        'format' => '?paged=%#%',
                        'current' => max( 1, $paged ),
                        'total' => $latest_posts->max_num_pages,
                        'prev_text'          => _x( 'Previous', 'previous set of posts', 'blog-elite' ),
                        'next_text'          => _x( 'Next', 'next set of posts', 'blog-elite' ),
                    ) );
                    if ( $links ) {
                        $pagination_align = blog_elite_get_option( 'home_numeric_pagination_align' );
                        ?>
                        <div class="be-nav-pagination <?php echo esc_attr($pagination_align);?>">
                            <?php echo _navigation_markup( $links, 'pagination' );?>
                        </div>
                        <?php
                    }
                }
                wp_reset_postdata();
                ?>
            </section>
            <?php
        endif;
    }
endif;

if ( ! function_exists( 'blog_elite_get_sidebar_heading_style' ) ) :
    /**
     * Returns sidebar widget heading style
     *
     * @since 1.0.0
     *
     * @return string heading_style
     */
    function blog_elite_get_sidebar_heading_style() {
        if(is_front_page()){
            $heading_style = blog_elite_get_option('home_sidebar_widget_heading_style');
        }else{
            $heading_style = blog_elite_get_option('sidebar_widget_heading_style');
        }
        return $heading_style;
    }
endif;

if ( ! function_exists( 'blog_elite_get_sidebar_heading_align' ) ) :
    /**
     * Returns sidebar widget heading align
     *
     * @since 1.0.0
     *
     * @return string heading_align
     */
    function blog_elite_get_sidebar_heading_align() {
        if(is_front_page()){
            $heading_align = blog_elite_get_option('home_sidebar_widget_heading_align');
        }else{
            $heading_align = blog_elite_get_option('sidebar_widget_heading_align');
        }
        return 'be-'.$heading_align;
    }
endif;

if ( ! function_exists( 'blog_elite_get_general_heading_style' ) ) :
    /**
     * Returns general widget heading style
     *
     * @since 1.0.0
     *
     * @return string heading_style
     */
    function blog_elite_get_general_heading_style() {
        $heading_style = blog_elite_get_option('general_widget_heading_style');
        return $heading_style;
    }
endif;

if ( ! function_exists( 'blog_elite_get_general_heading_align' ) ) :
    /**
     * Returns genral widget heading align
     *
     * @since 1.0.0
     *
     * @return string heading_align
     */
    function blog_elite_get_general_heading_align() {
        $heading_align = blog_elite_get_option('general_widget_heading_align');
        return 'be-'.$heading_align;
    }
endif;

if ( ! function_exists( 'blog_elite_get_footer_heading_style' ) ) :
    /**
     * Returns footer widget heading style
     *
     * @since 1.0.0
     *
     * @return string heading_style
     */
    function blog_elite_get_footer_heading_style() {
        $heading_style = blog_elite_get_option('footer_widget_heading_style');
        return $heading_style;
    }
endif;

if ( ! function_exists( 'blog_elite_get_footer_heading_align' ) ) :
    /**
     * Returns footer widget heading align
     *
     * @since 1.0.0
     *
     * @return string heading_align
     */
    function blog_elite_get_footer_heading_align() {
        $heading_align = blog_elite_get_option('footer_widget_heading_align');
        return 'be-'.$heading_align;
    }
endif;