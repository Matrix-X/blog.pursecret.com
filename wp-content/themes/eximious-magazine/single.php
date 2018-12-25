<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Eximious_Magazine
 */

get_header();
?>
<div class="container">
	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

			the_post_navigation();

            if ( 'post' === get_post_type() ) :
                /*Add WP Post Author Info Box*/
                if(eximious_magazine_is_wp_post_author_active()){
                    $enable_author_info_box = eximious_magazine_get_option('enable_author_info_box');
                    if($enable_author_info_box){
                        $author_info_box_position = eximious_magazine_get_option('author_info_box_position');
                        if('theme_position' == $author_info_box_position ){
                            $options = get_option('awpa_setting_options');
                            if(!isset($options['hide_from_post_content'])){
                                $title = esc_attr( $options['awpa_global_title'] );
                                $align = esc_attr( $options['awpa_global_align'] );
                                $image_layout = esc_attr( $options['awpa_global_image_layout'] );
                                $show_role = esc_attr( $options['awpa_global_show_role'] );
                                $show_email = esc_attr( $options['awpa_global_show_email'] );
                                echo do_shortcode('[wp-post-author title="'.$title.'" align="'.$align.'" image-layout="'.$image_layout.'" show-role="'.$show_role.'" show-email="'.$show_email.'"]');
                            }
                        }
                    }
                }
                /**/
            endif;

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php
	$page_layout = eximious_magazine_get_page_layout();
	if ('no-sidebar' != $page_layout) {
	    get_sidebar();
	}
	?>
</div>
<?php
get_footer();