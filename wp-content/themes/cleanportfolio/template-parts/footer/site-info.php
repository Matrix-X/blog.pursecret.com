<?php
/**
 * Displays footer site info
 *
  * @package Clean_Portfolio
 */

?>
<div class="site-info">
	<?php
        $theme_data = wp_get_theme();

        $footer_text = sprintf( _x( 'Copyright &copy; %1$s %2$s. All Rights Reserved. %3$s', '1: Year, 2: Site Title with home URL, 3: Privacy Policy Link', 'cleanportfolio' ), esc_attr( date_i18n( __( 'Y', 'cleanportfolio' ) ) ), '<a href="'. esc_url( home_url( '/' ) ) .'">'. esc_attr( get_bloginfo( 'name', 'display' ) ) . '</a>', get_the_privacy_policy_link() ) . ' &#124; ' . esc_html( $theme_data->get( 'Name') ) . '&nbsp;' . esc_html__( 'by', 'cleanportfolio' ). '&nbsp;<a target="_blank" href="'. esc_url( $theme_data->get( 'AuthorURI' ) ) .'">'. esc_html( $theme_data->get( 'Author' ) ) .'</a>';

        echo wp_kses_data( $footer_text );
    ?>
</div><!-- .site-info -->

