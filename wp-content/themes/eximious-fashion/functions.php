<?php
/*This file is part of eximious-fashion child theme.

All functions of this file will be loaded before of parent theme functions.
Learn more at https://codex.wordpress.org/Child_Themes.

Note: this function loads the parent stylesheet before, then child theme stylesheet
(leave it in place unless you know what you are doing.)
*/

/**
 * Get google fonts url
 */
function eximious_fashion_fonts_url(){

    $fonts_url = '';
    $fonts = array();
    $subsets = 'latin,latin-ext';


    /* translators: If there are characters in your language that are not supported by Handlee, translate this to 'off'. Do not translate into your own language. */
    if ('off' !== _x('on', 'Handlee: on or off', 'eximious-fashion')) {
        $fonts[] = 'Handlee';
    }

    /* translators: If there are characters in your language that are not supported by Lato, translate this to 'off'. Do not translate into your own language. */
    if ('off' !== _x('on', 'Lato: on or off', 'eximious-fashion')) {
        $fonts[] = 'Lato:400,300,400i,900,700';
    }


    if ($fonts) {
        $fonts_url = add_query_arg(array(
            'family' => urldecode(implode('|', $fonts)),
            'subset' => urldecode($subsets),
        ), 'https://fonts.googleapis.com/css');
    }
    return $fonts_url;
}

/*Enqueue child scripts and styles*/
function eximious_fashion_scripts() {

    $fonts_url = eximious_fashion_fonts_url();
    if (!empty($fonts_url)) {
        wp_enqueue_style('eximious-fashion-google-fonts', $fonts_url, array(), null);
    }
}
add_action( 'wp_enqueue_scripts', 'eximious_fashion_scripts');

/*Add the demo file*/
function eximious_fashion_add_demo_files($demos) {
    $demos[] = array(
        'import_file_name'             => esc_html__( 'Child - Fashion', 'eximious-fashion' ),
        'local_import_file'            => trailingslashit( get_stylesheet_directory() ) . 'demo-content/eximious-fashion.xml',
        'local_import_widget_file'     => trailingslashit( get_stylesheet_directory() ) . 'demo-content/eximious-fashion.wie',
        'local_import_customizer_file' => trailingslashit( get_stylesheet_directory() ) . 'demo-content/eximious-fashion.dat',
        'import_preview_image_url'     => trailingslashit( get_stylesheet_directory_uri() ) . 'demo-content/demo.png',
        'preview_url'                  => 'https://demo.themesaga.com/eximious-magazine/fashion',
    );
    return $demos;
}
add_filter( 'eximious_magazine_demo_files', 'eximious_fashion_add_demo_files');



/*Hide the Toolbar*/
//add_filter('show_admin_bar', '__return_false');


/*Change the style of Toolbar*/
// function style_tool_bar() {
//     echo '
//     <style type="text/css">
// 	#wpadminbar {
// 		background: blue;
// 	}
//     </style>';
// }
// add_action( 'admin_head', 'style_tool_bar' );
// add_action( 'wp_head', 'style_tool_bar' );



/*Remove toolbar itmes*/
function remove_toolbar_items($wp_adminbar) {
  $wp_adminbar->remove_node('wp-logo');
}
add_action('admin_bar_menu', 'remove_toolbar_items', 999);

/*Add toolbar itmes*/
//function add_toolbar_items($wp_admin_bar) {
//			$wp_admin_bar->add_node( array(
//			'id'		=> 'supportlink',
//			'title' => 'Contact support',
//			'href' => 'mailto:support@domain.com',
//		) );
//}
//add_action('admin_bar_menu', 'add_toolbar_items', 999);


