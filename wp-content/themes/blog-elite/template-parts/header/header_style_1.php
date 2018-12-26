<?php
/*Top Bar*/
$enable_top_bar = blog_elite_get_option('enable_top_bar');
if ($enable_top_bar) {
    blog_elite_top_bar();
}
?>
<div id="be-header-menu" class="be-header-menu-wrap">
    <div class="saga-container">
        <div class="main-navigation">
            <?php blog_elite_primary_menu();?>
        </div>
        <div class="secondary-navigation">
            <div class="cart-search">
                <?php
                if (blog_elite_is_wc_active()) {
                    blog_elite_woocommerce_header_cart();
                }
                $enable_search = blog_elite_get_option('enable_search_on_header');
                if($enable_search){
                    blog_elite_search_icon();
                }
                ?>
            </div>
        </div>
    </div>
</div>
<div <?php blog_elite_header_styles(); ?>>
    <div class="saga-container site-brand-add">
        <?php blog_elite_site_brand();?>
    </div>
</div>