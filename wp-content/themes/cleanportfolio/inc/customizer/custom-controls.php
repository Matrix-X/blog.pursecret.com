<?php
/**
 * Custom Controls
 *
 * @package Clean_Portfolio
 */

/**
 * Add Custom Controls
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function cleanportfolio_custom_controls( $wp_customize ) {
	//Important Links
    class CleanportfolioImportantLinks extends WP_Customize_Control {
        public $type = 'important-links';

        public function render_content() {
            //Add Theme instruction, Support Forum, Changelog, Donate link, Review, Facebook, Twitter, Google+, Pinterest links
            $important_links = array(
                'theme_instructions' => array(
                    'link'  => esc_url( 'https://catchthemes.com/theme-instructions/cleanportfolio/' ),
                    'text'  => esc_html__( 'Theme Instructions', 'cleanportfolio' ),
                    ),
                'support' => array(
                    'link'  => esc_url( 'https://catchthemes.com/support/' ),
                    'text'  => esc_html__( 'Support', 'cleanportfolio' ),
                    ),
                'changelog' => array(
                    'link'  => esc_url( 'https://catchthemes.com/changelogs/cleanportfolio-theme/' ),
                    'text'  => esc_html__( 'Changelog', 'cleanportfolio' ),
                    ),
                'facebook' => array(
                    'link'  => esc_url( 'https://www.facebook.com/catchthemes/' ),
                    'text'  => esc_html__( 'Facebook', 'cleanportfolio' ),
                    ),
                'twitter' => array(
                    'link'  => esc_url( 'https://twitter.com/catchthemes/' ),
                    'text'  => esc_html__( 'Twitter', 'cleanportfolio' ),
                    ),
                'gplus' => array(
                    'link'  => esc_url( 'https://plus.google.com/+Catchthemes/' ),
                    'text'  => esc_html__( 'Google+', 'cleanportfolio' ),
                    ),
                'pinterest' => array(
                    'link'  => esc_url( 'http://www.pinterest.com/catchthemes/' ),
                    'text'  => esc_html__( 'Pinterest', 'cleanportfolio' ),
                    ),
            );

            foreach ( $important_links as $important_link) {
                echo '<p><a target="_blank" href="' . $important_link['link'] .'" >' . $important_link['text'] .' </a></p>'; // WPCS: XSS OK.
            }
        }
    }

    //Custom control for dropdown category multiple select
    class CleanportfolioMultiCategoriesControl extends WP_Customize_Control {
        public $type = 'dropdown-categories';

        public $name;

        public function render_content() {
            $dropdown = wp_dropdown_categories(
                array(
                    'name'             => $this->name,
                    'echo'             => 0,
                    'hide_empty'       => false,
                    'show_option_none' => false,
                    'hide_if_empty'    => false,
                    'show_option_all'  => esc_html__( 'All Categories', 'cleanportfolio' )
                )
            );

            $dropdown = str_replace('<select', '<select multiple = "multiple" style = "height:95px;" ' . $this->get_link(), $dropdown );

            printf(
                '<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>',
                $this->label,
                $dropdown
            );

            echo '<p class="description">'. esc_html__( 'Hold down the Ctrl (windows) / Command (Mac) button to select multiple options.', 'cleanportfolio' ) . '</p>';
        }
    }

    //Custom control for any note, use label as output description
    class CleanportfolioNoteControl extends WP_Customize_Control {
        public $type = 'description';

        public function render_content() {
            echo '<h2 class="description">' . $this->label . '</h2>'; // WPCS: XSS OK.
        }
    }
}
add_action( 'customize_register', 'cleanportfolio_custom_controls', 1 );
