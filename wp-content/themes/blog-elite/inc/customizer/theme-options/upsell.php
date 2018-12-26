<?php
/*Register custom section and control types for upselling.*/
$wp_customize->register_section_type( 'Blog_Elite_Customize_Section_Upsell' );

/*Register sections.*/
$wp_customize->add_section(
    new Blog_Elite_Customize_Section_Upsell(
        $wp_customize,
        'theme_upsell',
        array(
            'title'    => esc_html__( 'Blog Elite Pro', 'blog-elite' ),
            'pro_text' => esc_html__( 'Buy Pro', 'blog-elite' ),
            'pro_url'  => 'https://themesaga.com/theme/blog-elite-pro/',
            'priority'  => 1,
        )
    )
);