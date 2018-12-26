<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
  * @package Clean_Portfolio
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-container">
		<header class="entry-header">
			<?php if ( 'post' === get_post_type() ) : ?>
				<?php get_template_part( 'template-parts/content/content', 'meta' ); ?>
			<?php endif; ?>

			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header><!-- .entry-header -->
		<div class="square"><?php echo cleanportfolio_get_svg( array( 'icon' => 'square' ) ); ?><span class="screen-reader-text"><?php esc_html_e( 'Square', 'cleanportfolio' ); ?></span></div>

		<div class="entry-content">
			<?php
				the_content( sprintf(
					/* translators: %s: Name of current post. */
					wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'cleanportfolio' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );

				wp_link_pages( array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'cleanportfolio' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span class="page-number">',
					'link_after'  => '</span>',
					'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'cleanportfolio' ) . ' </span>%',
					'separator'   => '<span class="screen-reader-text">, </span>',
				) );
			?>
		</div><!-- .entry-content -->

	</div><!-- .entry-container -->

</article><!-- #post-## -->


<div class="single-footer-meta-wrapper">
	<div class="footer-meta-area">
		<div id="footer-meta" class="footer-meta-columns">
			<?php cleanportfolio_entry_footer(); ?>
		</div>

		<div id="footer-author-bio" class="footer-meta-columns">
			<?php cleanportfolio_author_bio(); ?>
		</div>

		<div id="footer-nagivation" class="footer-meta-columns">
			<?php
			// Previous/next post navigation.
			the_post_navigation( array(
				'next_text' => '<span class="meta-nav">' . esc_html__( 'Next Post ', 'cleanportfolio' ) . '</span><span class="post-title">%title</span>',
				'prev_text' => '<span class="meta-nav">' . esc_html__( 'Previous Post ', 'cleanportfolio' ) . '</span> ' . '<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'cleanportfolio' ) . '</span><span class="post-title">%title</span>',
			) );
			?>
		</div>

	</div><!-- .footer-meta-area -->
</div><!-- .singular-footer-meta -->
