<?php
/**
 * Default customizer values.
 *
 * @package Eximious_Magazine
 */
if ( ! function_exists( 'eximious_magazine_get_default_customizer_values' ) ) :
	/**
	 * Get default customizer values.
	 *
	 * @since 1.0.0
	 *
	 * @return array Default customizer values.
	 */
	function eximious_magazine_get_default_customizer_values() {

		$defaults = array();

		$defaults['enable_trending_posts'] = false;
		$defaults['trending_post_cat'] = 1;
		$defaults['no_of_trending_posts'] = 5;
		$defaults['trending_post_text'] = __('Trending Now', 'eximious-magazine');

		$defaults['enable_slider_posts'] = false;
		$defaults['slider_layout'] = 'full-width';
		$defaults['slider_post_cat'] = 1;
		$defaults['no_of_slider_posts'] = 3;
		$defaults['enable_slider_description'] = true;
		$defaults['slider_desc_length'] = 25;
		$defaults['enable_slider_read_more_btn'] = false;
		$defaults['slider_read_more_btn_text'] = __('Read More', 'eximious-magazine');

		$defaults['home_page_layout'] = 'right-sidebar';
        $defaults['enable_front_page_content'] = true;
        $defaults['front_page_content_title'] = '';

		$defaults['enable_top_bar'] = false;
		$defaults['enable_top_nav'] = false;
		$defaults['enable_social_nav'] = false;
		$defaults['show_ad_banner'] = false;
		$defaults['ad_banner_image'] = '';
		$defaults['ad_banner_link'] = '';
		$defaults['enable_search'] = true;

		$defaults['show_preloader'] = false;
		$defaults['enable_breadcrumb'] = true;
		$defaults['pagination_type'] = 'default';
        $defaults['global_layout'] = 'right-sidebar';
        $defaults['sticky_sidebar'] = 'whole';

        $defaults['excerpt_length'] = 40;
        $defaults['excerpt_read_more_text'] = __('Read More', 'eximious-magazine');

        $defaults['enable_author_info_box'] = true;
        $defaults['author_info_box_position'] = 'theme_position';

        $defaults['archive_style'] = 'archive_style_1';
        $defaults['archive_image'] = 'eximious-magazine-medium-img';
        $defaults['archive_excerpt_length'] = 40;

        /*Footer*/
        $defaults['copyright_text'] = esc_html__( 'Copyright &copy; All rights reserved.', 'eximious-magazine' );
        $defaults['enable_footer_nav'] = false;
        /**/

		$defaults = apply_filters( 'eximious_magazine_default_customizer_values', $defaults );
		return $defaults;
	}
endif;