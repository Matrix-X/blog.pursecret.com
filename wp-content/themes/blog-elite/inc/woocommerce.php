<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package Blog_Elite
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
function blog_elite_woocommerce_setup() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'blog_elite_woocommerce_setup' );

if (!function_exists('blog_elite_remove_wc_breadcrumbs')) {
    /**
     * Removes Default WooCommerce breadcrumb.
     *
     * @return  void
     */
    function blog_elite_remove_wc_breadcrumbs()
    {
        remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
    }
}
add_action('init', 'blog_elite_remove_wc_breadcrumbs');

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function blog_elite_woocommerce_scripts() {
	wp_enqueue_style( 'blog-elite-woocommerce-style', get_template_directory_uri() . '/woocommerce.css' );

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'blog-elite-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'blog_elite_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
//add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function blog_elite_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'blog_elite_woocommerce_active_body_class' );

/**
 * Add Container wrapper class
 *
 */
function blog_elite_woocommerce_content_wrapper_start(){
    echo '<div class="saga-container">';
}
add_action( 'woocommerce_before_main_content', 'blog_elite_woocommerce_content_wrapper_start', 9 );

/**
 * Close container wrapper class after sidebar
 *
 */
function blog_elite_woocommerce_content_wrapper_end(){
    echo '</div><!--container-->';
}
add_action( 'woocommerce_sidebar', 'blog_elite_woocommerce_content_wrapper_end', 50 );

/**
 * Products per page.
 *
 * @return integer number of products.
 */
function blog_elite_woocommerce_products_per_page() {
	return 12;
}
add_filter( 'loop_shop_per_page', 'blog_elite_woocommerce_products_per_page' );

/**
 * Product gallery thumnbail columns.
 *
 * @return integer number of columns.
 */
function blog_elite_woocommerce_thumbnail_columns() {
	return 4;
}
add_filter( 'woocommerce_product_thumbnails_columns', 'blog_elite_woocommerce_thumbnail_columns' );

/**
 * Default loop columns on product archives.
 *
 * @return integer products per row.
 */
function blog_elite_woocommerce_loop_columns() {
	return 3;
}
add_filter( 'loop_shop_columns', 'blog_elite_woocommerce_loop_columns' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function blog_elite_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'blog_elite_woocommerce_related_products_args' );

if ( ! function_exists( 'blog_elite_woocommerce_product_columns_wrapper' ) ) {
	/**
	 * Product columns wrapper.
	 *
	 * @return  void
	 */
	function blog_elite_woocommerce_product_columns_wrapper() {
		$columns = blog_elite_woocommerce_loop_columns();
		echo '<div class="columns-' . absint( $columns ) . '">';
	}
}
add_action( 'woocommerce_before_shop_loop', 'blog_elite_woocommerce_product_columns_wrapper', 40 );

if ( ! function_exists( 'blog_elite_woocommerce_product_columns_wrapper_close' ) ) {
	/**
	 * Product columns wrapper close.
	 *
	 * @return  void
	 */
	function blog_elite_woocommerce_product_columns_wrapper_close() {
		echo '</div>';
	}
}
add_action( 'woocommerce_after_shop_loop', 'blog_elite_woocommerce_product_columns_wrapper_close', 40 );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'blog_elite_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function blog_elite_woocommerce_wrapper_before() {
		?>
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
			<?php
	}
}
add_action( 'woocommerce_before_main_content', 'blog_elite_woocommerce_wrapper_before' );

if ( ! function_exists( 'blog_elite_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function blog_elite_woocommerce_wrapper_after() {
			?>
			</main><!-- #main -->
		</div><!-- #primary -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'blog_elite_woocommerce_wrapper_after' );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'blog_elite_woocommerce_header_cart' ) ) {
			blog_elite_woocommerce_header_cart();
		}
	?>
 */

if ( ! function_exists( 'blog_elite_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function blog_elite_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		blog_elite_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'blog_elite_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'blog_elite_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function blog_elite_woocommerce_cart_link() {
		?>
		<a class="cart-contents" href="javascript:void(0)">
            <i class="fas fa-shopping-cart"></i>
            <span class="saga-woo-counter"><?php echo wp_kses_data(WC()->cart->get_cart_contents_count()); ?></span>
        </a>
		<?php
	}
}

if ( ! function_exists( 'blog_elite_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function blog_elite_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="cart-with-icon <?php echo esc_attr( $class ); ?>">
				<?php blog_elite_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget( 'WC_Widget_Cart', $instance );
				?>
			</li>
		</ul>
		<?php
	}
}