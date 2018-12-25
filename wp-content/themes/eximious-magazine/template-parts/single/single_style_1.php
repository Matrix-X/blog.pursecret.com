<?php
if ( 'post' === get_post_type() ) :
    $categories = wp_get_post_categories(get_the_ID());
    if(!empty($categories)){
        ?>
        <div class="cat-info">
            <?php
            foreach($categories as $c){
                $style = '';
                $cat = get_category( $c );
                $color = get_term_meta($cat->term_id, 'category_color', true);
                if($color){
                    $style = "background-color:".esc_attr($color);
                }
                ?>
                <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" style="<?php echo esc_attr($style);?>">
                    <?php echo esc_html($cat->cat_name);?>
                </a>
                <?php
            }
            ?>
        </div>
        <?php
    }
endif;
?>
<header class="entry-header">
    <?php
    the_title( '<h1 class="entry-title">', '</h1>' );
    if ( 'post' === get_post_type() ) :
        ?>
        <div class="entry-meta">
            <?php
            eximious_magazine_posted_by();
            eximious_magazine_posted_on();
            ?>
        </div><!-- .entry-meta -->
    <?php endif; ?>
</header><!-- .entry-header -->

<div class="post-thumbnail">
    <?php
    the_post_thumbnail( 'full', array(
        'alt' => the_title_attribute( array(
            'echo' => false,
        ) ),
    ) );
    ?>
</div><!-- .post-thumbnail -->

<div class="entry-content">
    <?php
    the_content( sprintf(
        wp_kses(
        /* translators: %s: Name of current post. Only visible to screen readers */
            __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'eximious-magazine' ),
            array(
                'span' => array(
                    'class' => array(),
                ),
            )
        ),
        get_the_title()
    ) );

    wp_link_pages( array(
        'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'eximious-magazine' ),
        'after'  => '</div>',
    ) );
    ?>
</div><!-- .entry-content -->

<footer class="entry-footer">
    <?php eximious_magazine_entry_footer(false,true,false); ?>
</footer><!-- .entry-footer -->