<?php $archive_image = esc_attr( eximious_magazine_get_option('archive_image')); ?>
<div class="article-block-wrapper clearfix">
    <header class="entry-header">
        <?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );?>
    </header><!-- .entry-header -->

    <?php
    if ( 'post' === get_post_type() ) {
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
    }

    if (has_post_thumbnail()) {
        ?>
        <div class="entry-image">
            <a href="<?php the_permalink() ?>">
                <?php
                the_post_thumbnail( $archive_image, array(
                    'alt' => the_title_attribute( array(
                        'echo' => false,
                    ) ),
                ) );
                ?>
            </a>
        </div>
        <?php
    }
    ?>
    <div class="article-details">
        <div class="em-meta-info">
            <div class="em-author-name">
                <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>">
                    <?php the_author(); ?>
                </a>
            </div>
            <div class="em-post-date">
                <?php echo esc_html(get_the_date());?>
            </div>
            <div class="em-comment-link">
                <?php
                $number = get_comments_number(get_the_ID());
                if (0 == $number) {
                    $respond_link = get_permalink() . '#respond';
                    $comment_link = apply_filters('respond_link', $respond_link, get_the_ID());
                } else {
                    $comment_link = get_comments_link();
                }
                ?>
                <a href="<?php echo esc_url($comment_link) ?>">
                    <i class="far fa-comments"></i>
                    <?php echo esc_html($number); ?>
                </a>
            </div>
        </div>
        <div class="entry-content">
            <?php

            $excerpt_read_more_text = eximious_magazine_get_option('excerpt_read_more_text');
            $excerpt_length = eximious_magazine_get_option('archive_excerpt_length');

            $content = wp_trim_words( get_the_excerpt(), $excerpt_length, '...' );
            echo apply_filters( 'the_excerpt', $content );

            wp_link_pages( array(
                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'eximious-magazine' ),
                'after'  => '</div>',
            ) );
            ?>
            <?php if($excerpt_read_more_text){ ?>
                <a class="readmore-btn" href="<?php the_permalink();?>">
                    <?php echo esc_html($excerpt_read_more_text);?>
                </a>
            <?php } ?>
        </div>
    </div>
</div>