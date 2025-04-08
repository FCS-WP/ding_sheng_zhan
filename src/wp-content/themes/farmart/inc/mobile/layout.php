<?php

/**
 * Hooks for template mobile
 *
 * @package Farmart
 */
Class Farmart_Mobile {

	public static function init() {

		if ( ! intval( farmart_is_mobile() ) ) {
			return;
		}

		if ( ! intval( farmart_get_option( 'enable_mobile_version' ) ) ) {
			return;
		}

		add_filter( 'pre_option_page_on_front', array( __CLASS__, 'homepage_mobile_init' ) );

		add_filter( 'body_class', array( __CLASS__, 'body_classes' ) );

		remove_action( 'farmart_header', 'farmart_show_header' );
		remove_action( 'farmart_header', 'farmart_show_header_mobile' );
		remove_action( 'farmart_after_header', 'farmart_show_page_header', 20 );

		// Catalog Page
		remove_action( 'woocommerce_archive_description', array('Farmart_WooCommerce_Template_Catalog','catalog_products_header_content'), 8 );
		remove_action( 'woocommerce_before_main_content', array('Farmart_WooCommerce_Template_Catalog','catalog_products_banners_top'), 5 );

		add_filter( 'farmart_catalog_toolbar_elements', array( __CLASS__, 'mobile_catalog_toolbar_elements' ) );
		add_action( 'woocommerce_before_shop_loop', array( __CLASS__, 'mobile_catalog_products_found' ), 29 );

		add_filter( 'farmart_catalog_nav_type', array( __CLASS__, 'catalog_pagination' ) );
		add_filter( 'farmart_catalog_nav_type_class', array( __CLASS__, 'farmart_catalog_nav_type_class' ) );

		// Product Page
		add_action( 'farmart_sticky_product_info', array( __CLASS__, 'sticky_product_info' ) );
		add_filter( 'farmart_sticky_product_info_offset', array( __CLASS__, 'sticky_product_info_offset' ) );

		add_filter( 'farmart_product_tabs_layout', array( __CLASS__, 'product_tabs_layout' ) );

		add_filter( 'farmart_get_product_layout', array( __CLASS__, 'mobile_get_product_layout' ) );

		remove_action( 'woocommerce_single_product_summary', array( 'Farmart_WooCommerce_Template_Product','open_single_product_summary_sidebar'), 100 );
		remove_action( 'woocommerce_single_product_summary', array( 'Farmart_WooCommerce_Template_Product','close_single_product_summary_sidebar'), 100 );
		add_action( 'woocommerce_single_product_summary', array(__CLASS__,'open_single_product_summary_sidebar_mobile'), 100 );
		add_action( 'woocommerce_single_product_summary', array(__CLASS__,'close_single_product_summary_sidebar_mobile'), 100);
	}

	public static function body_classes( $classes ) {
		$classes[] = 'mobile-version';

		if( intval( farmart_get_option( 'sticky_product_info_mobile' ) ) ){
			$classes[] = 'product-info-enable';
		}

		if ( is_product() ) {
			if ( intval( farmart_get_option( 'product_add_to_cart_fixed_mobile' ) ) ) {
				$classes[] = 'fm-add-to-cart-fixed';
			}
		}

		return $classes;
	}

	/**
	 * Display homepage mobile
	 *
	 * @since 1.0.0
	 *
	 *  return string
	 */

	public static function homepage_mobile_init( $value ) {
		$homepage = farmart_get_option( 'homepage_mobile' );
		$value    = ! empty( $homepage ) ? $homepage : $value;

		return $value;
	}

	public static function mobile_catalog_toolbar_elements( $els ) {
		if ( farmart_is_catalog() ) {
			$els = ( array ) farmart_get_option( 'mobile_catalog_toolbar_elements' );
		}

		return $els;
	}

	public static function mobile_catalog_products_found() {
		global $wp_query;
		$total = $wp_query->found_posts;

		echo '<div class="products-found"><span>' . $total . '</span>' . esc_html__( ' Products found', 'farmart' ) . '</div>';
	}

	public static function catalog_pagination(){
		return farmart_get_option('catalog_nav_type_mobile');
	}

	public static function farmart_catalog_nav_type_class(){
		return 'catalog-nav-' . farmart_get_option('catalog_nav_type_mobile');
	}

	public static function sticky_product_info() {
		return farmart_get_option( 'sticky_product_info_mobile' );
	}

	public static function sticky_product_info_offset() {
		return farmart_get_option( 'sticky_product_info_offset_mobile' );
	}

	public static function product_tabs_layout( $layout ) {
		$layout = 2;

		return $layout;
	}

	public static function mobile_get_product_layout( $layout ) {
		return 2;
	}

	public static function mobile_remove_product_sidebar( $output ) {
		if( is_singular( 'product' ) ){
			return;
		}
	}

	public static function open_single_product_summary_sidebar_mobile( $output ) {
		if( ! intval( farmart_get_option('product_sidebar_enable')  ) ){
			return;
		}
		?>
        <div class="entry-summary-sidebar product-sidebar">
		<?php

		ob_start();
		if ( is_active_sidebar( 'product-sidebar-mobile' ) ) {
			dynamic_sidebar( 'product-sidebar-mobile' );
		}
		$output = ob_get_clean();

		echo apply_filters( "farmart_product_sidebar_mobile", $output );
	}

	public static function close_single_product_summary_sidebar_mobile() {
		if( ! intval( farmart_get_option('product_sidebar_enable')  ) ){
			return;
		}
		?>
        </div>
		<?php
	}


}

/**
 * WooCommerce initialize.
 */
function farmart_mobile_init() {
	Farmart_Mobile::init();
}

add_action( 'wp_loaded', 'farmart_mobile_init' );