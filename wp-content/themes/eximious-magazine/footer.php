<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Eximious_Magazine
 */

?>

	</div><!-- #content -->

    <?php
    /**
     * Functions hooked in to eximious_magazine_before_footer
     *
     * @hooked eximious_magazine_before_footer_widget_region - 10
     */
    do_action( 'eximious_magazine_before_footer' );
    ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
            <?php
            /**
             * Functions hooked into eximious_magazine_footer action
             *
             * @hooked eximious_magazine_footer_start - 10
             * @hooked eximious_magazine_footer_content - 20
             * @hooked eximious_magazine_footer_end - 30
             */
            do_action( 'eximious_magazine_footer');
            ?>
	</footer>

    <?php do_action( 'eximious_magazine_after_footer' ); ?>

</div><!-- #page -->
<a id="scroll-up" class="primary-bg"><i class="fas fa-angle-double-up"></i></a>
<?php wp_footer(); ?>

</body>
</html>