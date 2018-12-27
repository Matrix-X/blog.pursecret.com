<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Eximious_Magazine
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php
    if(is_singular()){
        get_template_part('template-parts/single/single_style_1');
    }else{
        get_template_part('template-parts/archive/'.esc_attr($archive_style));
    }
    ?>
</article><!-- #post-<?php the_ID(); ?> -->