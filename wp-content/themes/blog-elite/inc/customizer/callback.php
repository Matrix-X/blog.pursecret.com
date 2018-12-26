<?php
if ( ! function_exists( 'blog_elite_is_home_banner_enabled' ) ) :
    /**
     * Check if Home Banner is active.
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function blog_elite_is_home_banner_enabled( $control ) {
        if ( $control->manager->get_setting( 'theme_options[enable_home_banner]' )->value() === true ) {
            return true;
        } else {
            return false;
        }
    }
endif;

if ( ! function_exists( 'blog_elite_is_home_banner_as_slider' ) ) :
    /**
     * Check if Home Banner is display as slider.
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function blog_elite_is_home_banner_as_slider( $control ) {
        if ( $control->manager->get_setting( 'theme_options[banner_display_as]' )->value() === 'slider' ) {
            return true;
        } else {
            return false;
        }
    }
endif;

if ( ! function_exists( 'blog_elite_is_home_banner_as_carousel' ) ) :
    /**
     * Check if Home Banner is display as carousel.
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function blog_elite_is_home_banner_as_carousel( $control ) {
        if ( $control->manager->get_setting( 'theme_options[banner_display_as]' )->value() === 'carousel' ) {
            return true;
        } else {
            return false;
        }
    }
endif;

if ( ! function_exists( 'blog_elite_banner_content_from_category' ) ) :
    /**
     * Check if Banner content is from category
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function blog_elite_banner_content_from_category( $control ) {
        if ( $control->manager->get_setting( 'theme_options[banner_content_from]' )->value() === 'category' ) {
            return true;
        } else {
            return false;
        }
    }
endif;

if ( ! function_exists( 'blog_elite_banner_content_from_post_ids' ) ) :
    /**
     * Check if Banner content is from post IDs
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function blog_elite_banner_content_from_post_ids( $control ) {
        if ( $control->manager->get_setting( 'theme_options[banner_content_from]' )->value() === 'post_ids' ) {
            return true;
        } else {
            return false;
        }
    }
endif;

if ( ! function_exists( 'blog_elite_is_top_bar_enabled' ) ) :
    /**
     * Check if Top Bar is enabled
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function blog_elite_is_top_bar_enabled( $control ) {

        if ( $control->manager->get_setting( 'theme_options[enable_top_bar]' )->value() === true ) {
            return true;
        } else {
            return false;
        }
    }
endif;

if ( ! function_exists( 'blog_elite_is_trending_posts_enabled' ) ) :
    /**
     * Check if Trending Posts is enabled
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function blog_elite_is_trending_posts_enabled( $control ) {

        if ( $control->manager->get_setting( 'theme_options[enable_trending_posts]' )->value() === true ) {
            return true;
        } else {
            return false;
        }
    }
endif;

if ( ! function_exists( 'blog_elite_is_ad_banner_enabled' ) ) :
    /**
     * Check if Ad banner is enabled for appropriate header style
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function blog_elite_is_ad_banner_enabled( $control ) {

        $header_style = $control->manager->get_setting( 'theme_options[header_style]' )->value();
        $allowed_styles = array('header_style_2');

        if ( in_array($header_style,$allowed_styles) ) {
            return true;
        } else {
            return false;
        }
    }
endif;

if ( ! function_exists( 'blog_elite_is_archive_numeric_pagination' ) ) :
    /**
     * Check if Numeric pagination is enabled for archive
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function blog_elite_is_archive_numeric_pagination( $control ) {

        if ( $control->manager->get_setting( 'theme_options[archive_pagination_type]' )->value() === 'numeric' ) {
            return true;
        } else {
            return false;
        }
    }
endif;

if ( ! function_exists( 'blog_elite_is_home_numeric_pagination' ) ) :
    /**
     * Check if Numeric pagination is enabled for home page
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function blog_elite_is_home_numeric_pagination( $control ) {

        if ( $control->manager->get_setting( 'theme_options[front_page_pagination_type]' )->value() === 'numeric' ) {
            return true;
        } else {
            return false;
        }
    }
endif;

if ( ! function_exists( 'blog_elite_is_author_enabled' ) ) :
    /**
     * Check if Author Box is enabled
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function blog_elite_is_author_enabled( $control ) {

        if ( $control->manager->get_setting( 'theme_options[enable_author_info_box]' )->value() === true ) {
            return true;
        } else {
            return false;
        }
    }
endif;


if ( ! function_exists( 'blog_elite_is_home_posts_enabled' ) ) :
    /**
     * Check if Latest posts is enabled on home page
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function blog_elite_is_home_posts_enabled( $control ) {

        if ( $control->manager->get_setting( 'theme_options[enable_posts_in_front_page]' )->value() === true ) {
            return true;
        } else {
            return false;
        }
    }
endif;