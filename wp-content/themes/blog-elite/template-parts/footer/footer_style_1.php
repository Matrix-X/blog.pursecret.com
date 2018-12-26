<?php

/*Get the footer column from the customizer*/
$footer_column_layout = blog_elite_get_option('footer_column_layout');
if($footer_column_layout){
    switch ($footer_column_layout) {
        case "footer_layout_1":
            $footer_column = 4;
            break;
        case "footer_layout_2":
            $footer_column = 3;
            break;
        case "footer_layout_3":
            $footer_column = 2;
            break;
        default:
            $footer_column = 4;
    }
}else{
    $footer_column = 4;
}

$rows = intval( apply_filters( 'blog_elite_footer_widget_rows', 1 ) );
$cols = intval( apply_filters( 'blog_elite_footer_widget_columns', $footer_column) );

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
            <div class="saga-container">
                <div class="saga-footer-bord">
                    <div class="saga-container-row">
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
                </div>
            </div>
        </div><!-- .footer-widgets.row-<?php echo strval( $i ); ?> -->
        <?php
        unset( $columns );
    endif;

endfor;