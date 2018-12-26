<?php
/**
 * Default search form.
 *
 * @package clean-blogging
 */

?>
<form role="search" method="get" id="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="search-wrap">
		<label class="screen-reader-text" for="s"><?php esc_html_e( 'Search for:', 'clean-blogging' ); ?></label>
		<input type="search" placeholder="<?php echo esc_attr( 'Search this site', 'clean-blogging' ); ?>" name="s" id="search-input" value="<?php echo esc_attr( get_search_query() ); ?>" />
		<span class="search icon"></span>
		<input class="screen-reader-text" type="submit" id="search-submit" value="Search" />
	</div>
</form>
