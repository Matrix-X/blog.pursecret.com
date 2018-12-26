<?php
/**
 * Default customizer values.
 *
 * @package Blog_Elite
 */
if ( ! function_exists( 'blog_elite_get_default_customizer_values' ) ) :
	/**
	 * Get default customizer values.
	 *
	 * @since 1.0.0
	 *
	 * @return array Default customizer values.
	 */
	function blog_elite_get_default_customizer_values() {

		$defaults = array();

		$defaults['enable_home_banner'] = false;
		$defaults['banner_display_as'] = 'slider';
		$defaults['banner_slider_style'] = 'style_1';
		$defaults['banner_carousel_style'] = 'style_1';
		$defaults['banner_layout'] = 'full-width';
		$defaults['banner_content_from'] = 'category';
		$defaults['banner_post_cat'] = 1;
		$defaults['no_of_banner_posts'] = 4;
		$defaults['banner_posts_orderby'] = 'date';
		$defaults['banner_posts_order'] = 'desc';
		$defaults['banner_post_ids'] = '';

        $defaults['banner_excerpt_length'] = 40;
        $defaults['banner_read_more_text'] = __('Read More', 'blog-elite');
		$defaults['show_banner_category'] = true;
		$defaults['show_banner_meta'] = true;

		$defaults['home_page_layout'] = 'right-sidebar';
		$defaults['front_page_sticky_sidebar'] = true;
		$defaults['home_sidebar_widget_heading_style'] = 'style_1';
		$defaults['home_sidebar_widget_heading_align'] = 'left';
        $defaults['enable_posts_in_front_page'] = true;
        $defaults['front_blog_style'] = 'archive_style_1';
        $defaults['front_page_pagination_type'] = 'numeric';
        $defaults['home_numeric_pagination_align'] = 'center';

		$defaults['enable_top_bar'] = false;
		$defaults['top_bar_layout'] = 'boxed';
		$defaults['enable_trending_posts'] = false;
		$defaults['trending_post_cat'] = 1;
		$defaults['no_of_trending_posts'] = 5;
		$defaults['trending_orderby'] = 'date';
		$defaults['trending_order'] = 'desc';
		$defaults['trending_post_text'] = __('Trending Now', 'blog-elite');
		$defaults['enable_top_bar_social_nav'] = false;

		$defaults['site_slogan_text'] = '';
		$defaults['site_slogan_color'] = '#000000';
		$defaults['site_tagline_style'] = 'style_1';
		$defaults['header_style'] = 'header_style_1';
		$defaults['ad_banner_image'] = '';
		$defaults['ad_banner_link'] = '';
		$defaults['enable_search_on_header'] = true;

		$defaults['show_preloader'] = false;
		$defaults['enable_breadcrumb'] = true;

        $defaults['site_layout'] = 'wide';

        $defaults['global_sidebar_layout'] = 'right-sidebar';
        $defaults['sticky_sidebar'] = true;
        $defaults['sidebar_widget_heading_style'] = 'style_1';
        $defaults['sidebar_widget_heading_align'] = 'left';

        $defaults['general_widget_heading_style'] = 'style_1';
        $defaults['general_widget_heading_align'] = 'left';

        $defaults['excerpt_length'] = 40;
        $defaults['excerpt_read_more_text'] = __('Read More', 'blog-elite');

        $defaults['enable_author_info_box'] = true;
        $defaults['author_info_box_position'] = 'theme_position';

        $defaults['archive_style'] = 'archive_style_1';
        $defaults['archive_excerpt_length'] = 40;
        $defaults['archive_pagination_type'] = 'default';
        $defaults['archive_numeric_pagination_align'] = 'center';

        /*Footer*/
        $defaults['footer_column_layout'] = 'footer_layout_1';
        $defaults['footer_widget_heading_style'] = 'style_1';
        $defaults['footer_widget_heading_align'] = 'left';
        $defaults['sub_footer_bg_image'] = '';
        $defaults['footer_logo'] = '';
        $defaults['footer_logo_link'] = '';
        $defaults['footer_logo_link_new_tab'] = false;
        $defaults['enable_footer_nav'] = false;
        $defaults['copyright_text'] = esc_html__( 'Copyright &copy; All rights reserved.', 'blog-elite' );
        /**/

		$defaults = apply_filters( 'blog_elite_default_customizer_values', $defaults );
		return $defaults;
	}
endif;