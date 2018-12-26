<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
  * @package Clean_Portfolio
 */

?>
			</div><!-- #content -->

			<footer id="colophon" class="site-footer" role="contentinfo">

				<?php get_template_part( 'template-parts/footer/footer', 'widgets' ); ?>
				<?php get_template_part( 'template-parts/footer/site', 'info' ); ?>

			</footer><!-- #colophon -->

		</div><!-- .below-site-header -->
	</div><!-- .site-inner -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
