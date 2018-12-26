<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Blog_Elite
 */

?>

	</div><!-- #content -->

    <?php
    /**
     * Functions hooked in to blog_elite_before_footer
     *
     * @hooked blog_elite_before_footer_widget_region - 10
     */
    do_action( 'blog_elite_before_footer' );
    ?>

    <?php
    $heading_style = blog_elite_get_footer_heading_style();
    $heading_align = blog_elite_get_footer_heading_align();
    ?>
	<footer id="colophon" class="site-footer <?php echo esc_attr($heading_style).' '.esc_attr($heading_align);?>" role="contentinfo">
            <?php
            /**
             * Functions hooked into blog_elite_footer action
             *
             * @hooked blog_elite_footer_start - 10
             * @hooked blog_elite_footer_content - 20
             * @hooked blog_elite_footer_end - 30
             */
            do_action( 'blog_elite_footer');
            ?>
	</footer>

    <?php
    /**
     * Functions hooked in to blog_elite_after_footer
     *
     * @hooked blog_elite_after_footer_widget_region - 10
     * @hooked blog_elite_sub_footer - 20
     */
    do_action( 'blog_elite_after_footer' );
    ?>

</div><!-- #page -->
<a id="scroll-up" class="primary-bg"><i class="fas fa-angle-double-up"></i></a>
<?php wp_footer(); ?>

</body>
</html>