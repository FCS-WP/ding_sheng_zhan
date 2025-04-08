<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package Farmart
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
function farmart_woocommerce_setup() {
	add_theme_support( 'woocommerce', array(
		'product_grid' => array(
			'default_rows'    => 4,
			'min_rows'        => 2,
			'max_rows'        => 20,
			'default_columns' => 4,
			'min_columns'     => 2,
			'max_columns'     => 7,
		),
		'wishlist' => array(
			'single_button_position' => 'theme',
			'loop_button_position'   => 'theme',
			'button_type'            => 'theme',
		),
	) );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme',  'farmart_woocommerce_setup' );

/**
 * WooCommerce initialize.
 */
function farmart_woocommerce_init() {
	if ( is_admin() ) {
		Farmart_WooCommerce_Settings::init();
	}

	Farmart_WooCommerce_Template_Product::init();
	Farmart_WooCommerce_Template_Catalog::init();
	Farmart_WooCommerce_Template_Cart::init();
	Farmart_WooCommerce_Template_Checkout::init();
	Farmart_WooCommerce_Template::init();
}

add_action( 'wp_loaded', 'farmart_woocommerce_init' );

require get_theme_file_path( '/inc/woocommerce/settings.php' );
require get_theme_file_path( '/inc/woocommerce/template-product.php' );
require get_theme_file_path( '/inc/woocommerce/template-catalog.php' );
require get_theme_file_path( '/inc/woocommerce/template-cart.php' );
require get_theme_file_path( '/inc/woocommerce/template-checkout.php' );
require get_theme_file_path( '/inc/woocommerce/theme-options.php' );
require get_theme_file_path( '/inc/woocommerce/template.php' );

if( function_exists( 'wcboost_wishlist' ) ) {
	require get_theme_file_path( '/inc/woocommerce/wcboost-wishlist.php' );
}

if( function_exists( 'wcboost_products_compare' ) ) {
	require get_theme_file_path( '/inc/woocommerce/wcboost-products-compare.php' );
}
