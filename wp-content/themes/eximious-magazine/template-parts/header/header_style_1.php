<?php
/*Top Bar*/
$enable_top_bar = eximious_magazine_get_option('enable_top_bar');
if ($enable_top_bar) {
    ?>
    <div class="saga-topnav">
        <div class="container">

            <?php
            $enable_top_nav = eximious_magazine_get_option('enable_top_nav');
            if($enable_top_nav){
                ?>
                <div class="top-bar-left">
                    <?php wp_nav_menu(array(
                        'theme_location' => 'top-menu',
                        'container_class' => 'top-navigation',
                        'depth' => 1,
                        'fallback_cb' => false,
                        'menu_class' => false
                    ) )?>
                </div>
            <?php } ?>

            <?php
            $enable_social_nav = eximious_magazine_get_option('enable_social_nav');
            if($enable_social_nav){
                ?>
                <div class="top-bar-right">
                    <?php wp_nav_menu(array(
                        'theme_location' => 'social-menu',
                        'container_class' => 'social-navigation',
                        'link_before' => '<span class="screen-reader-text">',
                        'link_after' => '</span>',
                        'fallback_cb' => false,
                        'depth' => 1,
                        'menu_class' => false
                    ) )?>
                </div>
            <?php } ?>

        </div>
    </div>
<?php } ?>

<div class="container site-brand-add">
    <div class="site-branding">
        <?php
        the_custom_logo();
        if ( is_front_page() ) :
            ?>
            <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <?php
        else :
            ?>
            <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            <?php
        endif;
        $eximious_magazine_description = get_bloginfo( 'description', 'display' );
        if ( $eximious_magazine_description || is_customize_preview() ) :
            ?>
            <p class="site-description"><?php echo $eximious_magazine_description; /* WPCS: xss ok. */ ?></p>
        <?php endif; ?>
    </div>
    <?php
    $show_ad_banner = eximious_magazine_get_option('show_ad_banner');
    if ($show_ad_banner) {
        ?>
        <div class="saga-ad-space">
            <?php
            $ad_banner_image = eximious_magazine_get_option('ad_banner_image');
            $ad_banner_link = eximious_magazine_get_option('ad_banner_link');
            if ($ad_banner_image) {
                $ad_banner_image_html = '<img src="' . esc_url($ad_banner_image) . '">';
                $ad_banner_link_open = $ad_banner_link_close = '';
                if ($ad_banner_link) {
                    $ad_banner_link_open = '<a href="' . esc_url($ad_banner_link) . '" target="_blank" class="border-overlay">';
                    $ad_banner_link_close = '</a>';
                }
                echo wp_kses_post($ad_banner_link_open . $ad_banner_image_html . $ad_banner_link_close);
            }
            ?>
        </div>
        <?php
    }
    ?>
</div>

<div id="em-header-menu" class="em-header-menu-wrap">
    <div class="container">
        <div class="main-navigation">
            <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_html_e( 'Primary Navigation', 'eximious-magazine' ); ?>">
                <span class="toggle-menu" aria-controls="primary-menu" aria-expanded="false">
                     <span class="screen-reader-text">
                        <?php esc_html_e('Primary Menu', 'eximious-magazine'); ?>
                     </span>
                     <i class="ham"></i>
                </span>
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary-menu',
                    'menu_id' => 'primary-menu',
                    'container' => 'div',
                    'container_class' => 'menu primary-navigation',
                ) );
                ?>
            </nav>
        </div>
        <div class="cart-search">
        <?php
        if (eximious_magazine_is_wc_active()) {
            eximious_magazine_woocommerce_header_cart();
        }
        $enable_search = eximious_magazine_get_option('enable_search');
        if($enable_search){
            ?>
            <div class="saga-search-wrap">
                <div class="search-overlay">
                    <a href="#" title="Search" class="search-icon">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="saga-search-form">
                        <?php get_search_form();?>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        </div>
    </div>
</div>