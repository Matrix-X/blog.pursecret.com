<?php

if ( ! function_exists( 'eximious_magazine_home_trending_items' ) ) {
    /**
     * Display homepage trending items
     *
     * @since  1.0.0
     */
    function eximious_magazine_home_trending_items() {

        $enable_trending_posts = eximious_magazine_get_option('enable_trending_posts');
        if ($enable_trending_posts) {
            $trending_cat = eximious_magazine_get_option('trending_post_cat');
            if(!empty($trending_cat)){
                $no_of_trending_posts = eximious_magazine_get_option('no_of_trending_posts');
                $post_args = array(
                    'post_type' => 'post',
                    'posts_per_page' => absint($no_of_trending_posts),
                    'post_status' => 'publish',
                    'no_found_rows' => 1,
                    'ignore_sticky_posts' => 1,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'category',
                            'field' => 'term_id',
                            'terms' => $trending_cat,
                        ),
                    ),
                );
                $trending_posts = new WP_Query($post_args);
                if ($trending_posts->have_posts()):
                    ?>
                    <div class="em-trending-posts">
                        <div class="container">
                            <?php
                            $trending_post_text = eximious_magazine_get_option('trending_post_text');
                            if($trending_post_text){
                                ?>
                                <div class="trending-now-title">
                                    <?php echo esc_html($trending_post_text);?>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="marquee-wrapper">
                            <div class="trending-now-posts marquee">
                                <?php while ($trending_posts->have_posts()):$trending_posts->the_post();?>
                                    <a href="<?php the_permalink()?>">
                                        <span class="trend-date"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) .' '.__( 'ago', 'eximious-magazine' ); ?></span>
                                        <span class="trent-title"><?php the_title();?></span>
                                    </a>
                                <?php endwhile;wp_reset_postdata();?>
                            </div>
                            </div>
                        </div>
                    </div>
                    <?php
                endif;
            }
        }
    }
}

if ( ! function_exists( 'eximious_magazine_home_banner_slider' ) ) {
    /**
     * Display homepage banner slider
     *
     * @since  1.0.0
     */
    function eximious_magazine_home_banner_slider() {

        $enable_banner_slider = eximious_magazine_get_option('enable_slider_posts');
        if ($enable_banner_slider) {
            $slider_cat = eximious_magazine_get_option('slider_post_cat');
            if(!empty($slider_cat)){
                $no_of_slider_posts = eximious_magazine_get_option('no_of_slider_posts');
                $post_args = array(
                    'post_type' => 'post',
                    'posts_per_page' => absint($no_of_slider_posts),
                    'post_status' => 'publish',
                    'no_found_rows' => 1,
                    'ignore_sticky_posts' => 1,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'category',
                            'field' => 'term_id',
                            'terms' => $slider_cat,
                        ),
                    ),
                );
                $slider_post = new WP_Query($post_args);
                if ($slider_post->have_posts()):

                    $slider_layout = eximious_magazine_get_option('slider_layout');
                    $enable_slider_description = eximious_magazine_get_option('enable_slider_description');
                    $enable_read_more = eximious_magazine_get_option('enable_slider_read_more_btn');

                    ?>
                    <div class="em-banner-slider-wrapper container <?php echo esc_attr($slider_layout);?>">
                    <div class="em-banner-slider owl-carousel owl-theme">
                        <?php 
                        while ($slider_post->have_posts()):$slider_post->the_post();
                            $style = '';
                            if(has_post_thumbnail()){
                                $image = get_the_post_thumbnail_url(get_the_ID(), 'full'); 
                                $style = "background-image:url('".esc_url($image)."')";
                            }
                            ?>
                            <div class="item">
                                <div class="slider-wrapper bg-image" style="<?php echo esc_attr($style)?>">
                                    <div class="banner-caption">
                                        <div class="banner-caption-inner">
                                            <?php
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
                                            ?>
                                            <h2>
                                                <a href="<?php the_permalink()?>">
                                                    <?php the_title(); ?>
                                                </a>
                                            </h2>
                                            <div class="hidden-xs">
                                                <?php
                                                if( $enable_slider_description ){
                                                    $slider_desc_length = eximious_magazine_get_option('slider_desc_length');
                                                    $content = wp_trim_words( get_the_content(), $slider_desc_length, '...' );
                                                    echo apply_filters( 'the_content', $content );
                                                }
                                                ?>
                                            </div>
                                            <?php
                                            if($enable_read_more){
                                                $read_more_text = eximious_magazine_get_option('slider_read_more_btn_text');
                                                if($read_more_text){
                                                    echo '<a href="' . esc_url(get_the_permalink(get_the_ID())) . '" class="main-btn main-btn-primary">' . esc_html($read_more_text) . '</a>';
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile;wp_reset_postdata(); ?>
                    </div>
                    </div>
                    <?php endif;
            }
        }
    }
}

if ( ! function_exists( 'eximious_magazine_above_homepage_widget_region' ) ) {
    /**
     * Display widgets before the homepage contents
     *
     * @since  1.0.0
     */
    function eximious_magazine_above_homepage_widget_region() {
        if (is_active_sidebar('above-homepage-widget-area')) {
            ?>
            <div class="above-homepage-widget-area general-widget-area">
                <div class="container">
                    <?php dynamic_sidebar('above-homepage-widget-area'); ?>
                </div>
            </div>
            <?php
        }
    }
}

if ( ! function_exists( 'eximious_magazine_below_homepage_widget_region' ) ) {
    /**
     * Display widgets after the homepage contents
     *
     * @since  1.0.0
     */
    function eximious_magazine_below_homepage_widget_region() {
        if (is_active_sidebar('below-homepage-widget-area')) {
            ?>
            <div class="below-homepage-widget-area general-widget-area">
                <div class="container">
                    <?php dynamic_sidebar('below-homepage-widget-area'); ?>
                </div>
            </div>
            <?php
        }
    }
}

if (!function_exists('eximious_magazine_front_page_content')) :
    /**
     * Front Page Content Posts
     *
     * @since 1.0.0
     */
    function eximious_magazine_front_page_content(){

        $front_page_title_html = '';
        $front_page_content_title = eximious_magazine_get_option('front_page_content_title');
        if($front_page_content_title){
            $front_page_title_html = '<span class="widget-title"><span>'.esc_html($front_page_content_title).'</span></span>';
        }

        if ('posts' == get_option('show_on_front')) {
            ?>
            <section class="eximious-magazine-latest-posts em-front-page-content">
                <?php
                echo wp_kses_post($front_page_title_html);
                set_query_var('archive_style', 'archive_style_1');
                set_query_var('archive_image', 'eximious-magazine-medium-img');
                if (have_posts()) :
                    while (have_posts()) : the_post();
                        get_template_part('template-parts/content', get_post_type());
                    endwhile;wp_reset_postdata();
                    the_posts_pagination();
                endif;
                ?>
            </section>
            <?php
        }else{
            while (have_posts()) : the_post();
                ?>
                <section class="eximious-magazine-static-page em-front-page-content">
                    <?php echo wp_kses_post($front_page_title_html);?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="entry-content">
                            <?php the_content();?>
                        </div>
                    </article>
                </section>
            <?php endwhile; wp_reset_postdata();
        }
    }
endif;