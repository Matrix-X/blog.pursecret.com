<div class="article-block-wrapper clearfix">
    <header class="entry-header">
        <?php 
        if ( 'post' === get_post_type() ) {
            blog_elite_post_cat_info();
        }?>
        <?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );?>
        <?php
        blog_elite_post_meta_info();
        ?>
    </header><!-- .entry-header -->
    <?php
    if (has_post_thumbnail()) {
        blog_elite_post_image('blog-elite-slide-boxed');
    }
    ?>
    <div class="article-details">
        <?php blog_elite_post_excerpt_info();?>
    </div>
</div>