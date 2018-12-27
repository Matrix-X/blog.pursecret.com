<?php
/*Register custom section and control types for upselling.*/
$wp_customize->register_section_type( 'Eximious_Magazine_Customize_Section_Upsell' );

/*Register sections.*/
$wp_customize->add_section(
    new Eximious_Magazine_Customize_Section_Upsell(
        $wp_customize,
        'theme_upsell',
        array(
            'title'    => esc_html__( 'Eximious Magazine Pro', 'eximious-magazine' ),
            'pro_text' => esc_html__( 'Buy Pro', 'eximious-magazine' ),
            'pro_url'  => 'https://themesaga.com/theme/eximious-magazine-pro/',
            'priority'  => 1,
        )
    )
);