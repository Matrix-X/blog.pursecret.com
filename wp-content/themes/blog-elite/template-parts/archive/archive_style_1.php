<div class="article-block-wrapper clearfix">
    <?php
    if (has_post_thumbnail()) {
        blog_elite_post_image('blog-elite-carousel-boxed', true);
    }
    ?>
    <div class="article-details">
        <?php
        if ( 'post' === get_post_type() ) {
            blog_elite_post_cat_info();
        }
        ?>
        <header class="entry-header">
            <?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );?>
        </header><!-- .entry-header -->
        <?php blog_elite_post_meta_info();?>
        <?php blog_elite_post_excerpt_info();?>
    </div>
</div>