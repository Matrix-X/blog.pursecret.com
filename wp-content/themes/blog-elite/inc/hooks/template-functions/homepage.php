<?php

if (!function_exists('blog_elite_home_banner')) {
    /**
     * Display homepage banner
     *
     * @since  1.0.0
     */
    function blog_elite_home_banner()
    {

        $enable_home_banner = blog_elite_get_option('enable_home_banner');
        if ($enable_home_banner) {

            $post_args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'no_found_rows' => 1,
                'ignore_sticky_posts' => 1,
            );

            $banner_content_from = blog_elite_get_option('banner_content_from');
            if ('category' == $banner_content_from) {

                $banner_post_cat = blog_elite_get_option('banner_post_cat');
                $no_of_banner_posts = absint(blog_elite_get_option('no_of_banner_posts'));
                $banner_posts_orderby = esc_attr(blog_elite_get_option('banner_posts_orderby'));
                $banner_posts_order = esc_attr(blog_elite_get_option('banner_posts_order'));

                $post_args['posts_per_page'] = $no_of_banner_posts;
                $post_args['orderby'] = $banner_posts_orderby;
                $post_args['order'] = $banner_posts_order;

                if (!empty($banner_post_cat)) {
                    $post_args['tax_query'][] = array(
                        'taxonomy' => 'category',
                        'field' => 'term_id',
                        'terms' => absint($banner_post_cat),
                    );
                }

            } else {
                $banner_post_ids = blog_elite_get_option('banner_post_ids');
                if (!empty($banner_post_ids)) {
                    $post_ids = explode(',', esc_attr($banner_post_ids));
                    $post_args['post__in'] = $post_ids;
                    $post_args['orderby'] = 'post__in';
                    $post_args['posts_per_page'] = count($post_ids);
                }
            }

            $banner_posts = new WP_Query($post_args);
            if ($banner_posts->have_posts()):

                $banner_class = 'be-owl-banner-carousel';
                $items = 2;
                $margin = 0;
                $container_class = '';

                $banner_layout = blog_elite_get_option('banner_layout');
                $banner_display_as = blog_elite_get_option('banner_display_as');

                if('boxed' == $banner_layout){
                    $container_class = 'saga-container';
                }

                if ('slider' == $banner_display_as) {

                    $slider_style = blog_elite_get_option('banner_slider_style');

                    $banner_class = 'be-owl-carousel-slider';
                    $items = 1;

                    $image_size = 'blog-elite-slide-boxed';
                    if('full-width' == $banner_layout){
                        $image_size = 'blog-elite-slide-full';
                    }

                    $banner_style = 'be-banner-slider-'.$slider_style;
                }else{

                    $carousel_style = blog_elite_get_option('banner_carousel_style');
                    $margin = 10;
                    $image_size = 'blog-elite-carousel-boxed';
                    if('full-width' == $banner_layout){
                        $image_size = 'blog-elite-carousel-full';
                    }

                    $banner_style = 'be-banner-carousel-'.$carousel_style;
                }

                $show_banner_category = blog_elite_get_option('show_banner_category');
                $show_banner_meta = blog_elite_get_option('show_banner_meta');
                ?>
                <div class="be-banner-wrapper <?php echo esc_attr($container_class).' '.esc_attr($banner_style); ?>">
                    <div class="be-owl-carousel <?php echo esc_attr($banner_class); ?> be-banner owl-carousel owl-theme"
                         data-items="<?php echo esc_attr($items) ?>" data-desktop="<?php echo esc_attr($items) ?>"
                         data-tab="<?php echo esc_attr($items) ?>" data-margin="<?php echo esc_attr($margin) ?>">
                        <?php while ($banner_posts->have_posts()):$banner_posts->the_post();?>
                            <div class="item">
                                <div class="banner-wrapper be-bg-image">
                                    <?php
                                    if (has_post_thumbnail()) {
                                        the_post_thumbnail($image_size, array(
                                            'alt' => the_title_attribute(array(
                                                'echo' => false,
                                            )),
                                        ));
                                    }
                                    ?>
                                    <div class="banner-caption">
                                        <div class="banner-caption-inner">
                                            <div class="banner-caption-inner-overlay"></div>
                                            <?php
                                            if ($show_banner_category) {
                                                blog_elite_post_cat_info();
                                            }
                                            ?>
                                            <h3>
                                                <a href="<?php the_permalink() ?>">
                                                    <?php the_title(); ?>
                                                </a>
                                            </h3>
                                            <?php
                                            if ($show_banner_meta) {
                                                blog_elite_post_meta_info();
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile;
                        wp_reset_postdata(); ?>
                    </div>
                </div>
            <?php endif;
        }
    }
}

if (!function_exists('blog_elite_above_homepage_widget_region')) {
    /**
     * Display widgets before the homepage contents
     *
     * @since  1.0.0
     */
    function blog_elite_above_homepage_widget_region()
    {
        if (is_active_sidebar('above-homepage-widget-area')) {
            $heading_style = blog_elite_get_general_heading_style();
            $heading_align = blog_elite_get_general_heading_align();
            ?>
            <div class="above-homepage-widget-area general-widget-area <?php echo esc_attr($heading_style).' '.esc_attr($heading_align);?>">
                <div class="saga-container">
                    <?php dynamic_sidebar('above-homepage-widget-area'); ?>
                </div>
            </div>
            <?php
        }
    }
}

if (!function_exists('blog_elite_below_homepage_widget_region')) {
    /**
     * Display widgets after the homepage contents
     *
     * @since  1.0.0
     */
    function blog_elite_below_homepage_widget_region()
    {
        if (is_active_sidebar('below-homepage-widget-area')) {
            $heading_style = blog_elite_get_general_heading_style();
            $heading_align = blog_elite_get_general_heading_align();
            ?>
            <div class="below-homepage-widget-area general-widget-area <?php echo esc_attr($heading_style).' '.esc_attr($heading_align);?>">
                <div class="saga-container">
                    <?php dynamic_sidebar('below-homepage-widget-area'); ?>
                </div>
            </div>
            <?php
        }
    }
}