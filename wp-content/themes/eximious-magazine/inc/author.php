<?php
$author_info_box_position = eximious_magazine_get_option('author_info_box_position');
if('theme_position' == $author_info_box_position ){
    /*Remove post author content from the default plugin position*/
    remove_filter('the_content', 'awpa_add_author');
}