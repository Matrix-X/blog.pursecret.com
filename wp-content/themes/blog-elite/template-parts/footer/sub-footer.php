<?php
$class = $style = '';
$sub_footer_bg_image = blog_elite_get_option('sub_footer_bg_image');
if(!empty($sub_footer_bg_image)){
    $style = "background-image:url('".esc_url($sub_footer_bg_image)."')";
    $class = 'footer-bg-image';
}
?>
<div class="saga-sub-footer <?php echo esc_attr($class);?>" style="<?php echo esc_attr($style)?>">
    <div class="saga-container">
        <?php

        $enable_footer_nav = blog_elite_get_option('enable_footer_nav');
        if($enable_footer_nav){
            wp_nav_menu(array(
                'theme_location' => 'footer-menu',
                'container_class' => 'footer-navigation',
                'fallback_cb' => false,
                'depth' => 1,
                'menu_class' => false
            ) );
        }

        $footer_logo = blog_elite_get_option('footer_logo');
        if($footer_logo){
            $img_wrapper_start = $img_wrapper_end = '';
            $footer_logo_link = blog_elite_get_option('footer_logo_link');
            if($footer_logo_link){
                $footer_logo_link_new_tab = blog_elite_get_option('footer_logo_link_new_tab');
                $target = $footer_logo_link_new_tab ? '_blank' : '_self';
                $img_wrapper_start = '<a href="'.esc_url($footer_logo_link).'" target="'. esc_attr($target).'">';
                $img_wrapper_end = '</a>';
            }
            ?>
            <div class="footer-logo">
                <?php echo wp_kses_post($img_wrapper_start); ?>
                    <img src="<?php echo esc_url($footer_logo);?>">
                <?php echo wp_kses_post($img_wrapper_end); ?>
            </div>
            <?php
        }
        ?>
        <div class="site-copyright">
            <span>
                <?php
                $copyright_text = blog_elite_get_option('copyright_text');
                if($copyright_text){
                    echo wp_kses_post($copyright_text);
                }
                ?>
            </span>
            <?php printf(esc_html__('Theme: %1$s by %2$s', 'blog-elite'), '<a href="http://themesaga.com/theme/blog-elite" target = "_blank" rel="designer">Blog Elite</a>', '<a href="http://themesaga.com/" target = "_blank" rel="designer">Themesaga</a>'); ?>
        </div>
    </div>
</div>