<?php
/**
 * Template for displaying search forms in Clean Portfolio
 *
 * @package Clean_Portfolio
 */
?>

<?php $search_text = get_theme_mod( 'cleanportfolio_search_text', esc_html__( 'Search ...', 'cleanportfolio' ) ); ?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'cleanportfolio' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr( $search_text ); ?>" value="<?php the_search_query(); ?>" name="s" />
	</label>
	<button type="submit" class="search-submit"><?php echo cleanportfolio_get_svg( array( 'icon' => 'search' ) ); ?><span class="screen-reader-text"><?php echo esc_html_x( 'Search', 'submit button', 'cleanportfolio' ); ?></span></button>
</form>
