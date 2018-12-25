<?php
$rows = intval( apply_filters( 'eximious_magazine_footer_widget_rows', 1 ) );
$cols = intval( apply_filters( 'eximious_magazine_footer_widget_columns', 4 ) );

for ( $i = 1; $i <= $rows; $i++ ) :

    // Defines the number of active columns in this footer row.
    for ( $j = $cols; 0 < $j; $j-- ) {
        if ( is_active_sidebar( 'footer-' . strval( $j + $cols * ( $i - 1 ) ) ) ) {
            $columns = $j;
            break;
        }
    }

    if ( isset( $columns ) ) : ?>
        <div class=<?php echo '"footer-widgets row-' . strval( $i ) . ' column-' . strval( $columns ) . '"'; ?>>
            <div class="container">
            <?php
            for ( $column = 1; $column <= $columns; $column++ ) :
                $footer_n = $column + $cols * ( $i - 1 );
                if ( is_active_sidebar( 'footer-' . strval( $footer_n ) ) ) : ?>
                    <div class="footer-common-widget footer-widget-<?php echo strval( $column ); ?>">
                        <?php dynamic_sidebar( 'footer-' . strval( $footer_n ) ); ?>
                    </div>
                    <?php
                endif;
            endfor;
            ?>
            </div>
        </div><!-- .footer-widgets.row-<?php echo strval( $i ); ?> -->
        <?php
        unset( $columns );
    endif;

endfor;
?>

<?php
$copyright_text = eximious_magazine_get_option('copyright_text');
$enable_footer_nav = eximious_magazine_get_option('enable_footer_nav');
?>
<div class="saga-sub-footer clearfix">
    <div class="container">
    <?php
    if($enable_footer_nav){
        ?>
        <div class="site-footer-menu col-md-6 col-md-push-6">
            <?php wp_nav_menu(array(
                'theme_location' => 'footer-menu',
                'container_class' => 'footer-navigation',
                'fallback_cb' => false,
                'depth' => 1,
                'menu_class' => false
            ) )?>
        </div>
        <?php
    }
    ?>
    <div class="site-copyright col-md-6 col-md-pull-6">
        <span>
            <?php
            if($copyright_text){
                echo wp_kses_post($copyright_text);
            }
            ?>
        </span>
        <?php printf(esc_html__('Theme: %1$s by %2$s', 'eximious-magazine'), '<a href="http://themesaga.com/theme/eximious-magazine" target = "_blank" rel="designer">Eximious Magazine</a>', '<a href="http://themesaga.com/" target = "_blank" rel="designer">Themesaga</a>'); ?>
    </div>
    </div>
</div>