<?php
if ( ! function_exists( 'eximious_magazine_is_trending_posts_enabled' ) ) :
    /**
     * Check if Trending Posts is active.
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function eximious_magazine_is_trending_posts_enabled( $control ) {
        if ( $control->manager->get_setting( 'theme_options[enable_trending_posts]' )->value() === true ) {
            return true;
        } else {
            return false;
        }
    }
endif;

if ( ! function_exists( 'eximious_magazine_is_banner_slider_enabled' ) ) :
    /**
     * Check if Banner slider is active.
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function eximious_magazine_is_banner_slider_enabled( $control ) {
        if ( $control->manager->get_setting( 'theme_options[enable_slider_posts]' )->value() === true ) {
            return true;
        } else {
            return false;
        }
    }
endif;

if ( ! function_exists( 'eximious_magazine_is_banner_desc_enabled' ) ) :
    /**
     * Check if Slider Description is enabled
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function eximious_magazine_is_banner_desc_enabled( $control ) {
        if ( $control->manager->get_setting( 'theme_options[enable_slider_description]' )->value() === true ) {
            return true;
        } else {
            return false;
        }
    }
endif;

if ( ! function_exists( 'eximious_magazine_is_banner_read_btn_enabled' ) ) :
    /**
     * Check if Static Button is enabled
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function eximious_magazine_is_banner_read_btn_enabled( $control ) {

        if ( $control->manager->get_setting( 'theme_options[enable_slider_read_more_btn]' )->value() === true ) {
            return true;
        } else {
            return false;
        }
    }
endif;

if ( ! function_exists( 'eximious_magazine_is_top_bar_enabled' ) ) :
    /**
     * Check if Top Bar is enabled
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function eximious_magazine_is_top_bar_enabled( $control ) {

        if ( $control->manager->get_setting( 'theme_options[enable_top_bar]' )->value() === true ) {
            return true;
        } else {
            return false;
        }
    }
endif;

if ( ! function_exists( 'eximious_magazine_is_ad_banner_enabled' ) ) :
    /**
     * Check if Ad Banner is enabled
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function eximious_magazine_is_ad_banner_enabled( $control ) {

        if ( $control->manager->get_setting( 'theme_options[show_ad_banner]' )->value() === true ) {
            return true;
        } else {
            return false;
        }
    }
endif;

if ( ! function_exists( 'eximious_magazine_is_author_enabled' ) ) :
    /**
     * Check if Author Box is enabled
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function eximious_magazine_is_author_enabled( $control ) {

        if ( $control->manager->get_setting( 'theme_options[enable_author_info_box]' )->value() === true ) {
            return true;
        } else {
            return false;
        }
    }
endif;