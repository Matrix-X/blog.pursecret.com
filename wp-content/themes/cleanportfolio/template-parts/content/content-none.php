<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
  * @package Clean_Portfolio
 */

?>

<section class="no-results not-found">
	<div class="singular-content-wrap">
		<div class="entry-container">
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'cleanportfolio' ); ?></h1>
			</header><!-- .page-header -->
			<div class="square"><?php echo cleanportfolio_get_svg( array( 'icon' => 'square' ) ); ?><span class="screen-reader-text"><?php esc_html_e( 'Square', 'cleanportfolio' ); ?></span></div>

			<div class="page-content">
				<?php
				if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

					<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'cleanportfolio' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

				<?php elseif ( is_search() ) : ?>

					<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'cleanportfolio' ); ?></p>
					<?php
						get_search_form();

				else : ?>

					<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'cleanportfolio' ); ?></p>
					<?php
						get_search_form();

				endif; ?>
			</div><!-- .page-content -->
		</div><!-- .entry-container -->
	</div><!-- .singular-content-wrap -->
</section><!-- .no-results -->
