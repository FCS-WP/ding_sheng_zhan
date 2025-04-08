<?php

/**
 * Class for all Vendor template modification
 *
 * @version 1.0
 */
class Farmart_Dokan {

	/**
	 * Construction function
	 *
	 * @since  1.0
	 * @return Farmart_Dokan
	 */
	function __construct() {
		if ( ! class_exists( 'WeDevs_Dokan' ) ) {
			return;
		}

		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'farmart_dokan_scripts' ), 20 );

		// Define all hook
		add_filter( 'dokan_settings_fields', array( $this, 'dokan_settings_fields' ) );
		add_filter( 'pre_get_posts', array( $this, 'store_query_filter' ) );

		add_action( 'woocommerce_shop_loop_item_title', array( $this, 'template_loop_sold_by' ), 9 );
		add_action( 'farmart_product_list_details', array( $this, 'template_loop_sold_by' ), 20 );
		add_action( 'farmart_product_details_2', array( $this, 'template_loop_sold_by' ), 20 );
		add_action( 'farmart_single_product_deal_summary', array( $this, 'template_loop_sold_by' ), 8 );
		add_action( 'farmart_single_product_deal_2_content', array( $this, 'template_loop_sold_by' ), 8 );

		add_filter( 'body_class', array( $this, 'body_classes' ) );

		// Vendor Page
		add_action( 'dokan_store_profile_frame_after', array(
			'Farmart_WooCommerce_Template_Catalog',
			'shop_toolbar'
		), 20 );

		// Mobile
		add_action( 'dokan_store_profile_frame_after', array( $this,'mobile_products_found'), 20 );
		add_action( 'woocommerce_after_main_content', array( $this, 'mobile_close_sidebar' ), 4 );

		// Add box vendor page
		add_action( 'woocommerce_before_main_content', array( $this, 'vendor_content_before' ), 20 );
		add_action( 'woocommerce_after_main_content', array( $this, 'vendor_content_after' ), 4 );

		// Change vendor columns product
		add_filter( 'farmart_shop_columns', array( $this, 'shop_columns' ), 20 );

		// Define all hook
		add_action( 'template_redirect', array( $this, 'hooks' ) );

	}

	public static function farmart_dokan_scripts( ) {
		wp_enqueue_style(  'farmart-dokan-style', get_template_directory_uri() . '/css/dokan.css' );
	}


	public static function hooks() {

		if ( function_exists( 'dokan_is_store_page' ) && dokan_is_store_page() ) {
			add_filter( 'dokan_get_template_part', array( __CLASS__, 'template_part_store_header' ), 20, 3);
		}
	}

	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @since 1.0
	 *
	 * @param array $classes Classes for the body element.
	 *
	 * @return array
	 */
	function body_classes( $classes ) {
		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( farmart_is_vendor_page() ) {
			$shop_view = isset( $_COOKIE['shop_view'] ) ? $_COOKIE['shop_view'] : farmart_get_option( 'catalog_vendor_view' );
			$classes[] = 'catalog-view-' . $shop_view;
		}

		return $classes;
	}


	/**
	 * Add sold by
	 */
	function template_loop_sold_by() {
		if ( ! intval( farmart_get_option( 'catalog_sold_by' ) ) ) {
			return;
		}

		get_template_part( 'template-parts/vendor/loop', 'sold-by' );
	}

	/**
	 * Dokan Settings Fields
	 */
	function dokan_settings_fields( $settings_fields ) {
		$settings_fields['dokan_appearance']['store_header_template']['options']['fm_custom'] = get_template_directory_uri() . '/images/vendor.jpg';

		return $settings_fields;
	}

	/**
	 * Store query filter
	 *
	 * Handles the product filtering by category in store page
	 *
	 * @param object $query
	 *
	 * @return void
	 */
	function store_query_filter( $query ) {
		global $wp_query;

		if ( ! is_admin() && $query->is_main_query() && farmart_is_vendor_page() ) {
			$post_per_page = isset( $store_info['store_ppp'] ) && ! empty( $store_info['store_ppp'] ) ? $store_info['store_ppp'] : intval( farmart_get_option( 'catalog_vendor_per_page' ) );
			set_query_var( 'posts_per_page', $post_per_page );
		}
	}

	/**
	 * Add open dokan vendor page
	 */
	function vendor_content_before() {
		if ( farmart_is_vendor_page() ) {
			echo '<div class="fm-shop-content">';
		}
	}

	/**
	 * Add close dokan vendor page
	 */
	function vendor_content_after() {
		if ( farmart_is_vendor_page() ) {
			echo '</div>';
		}
	}

	/**
	 * Change columns dokan vendor page
	 */
	function shop_columns( $columns ) {
		if ( farmart_is_vendor_page() ) {
			$columns = intval( farmart_get_option( 'catalog_vendor_columns' ) );
		}

		return $columns;
	}

	/**
	 * Change columns dokan vendor page
	 */
	public static function template_part_store_header( $template, $slug, $name ) {

		$dokan_appearance         = get_option( 'dokan_appearance' );
		$profile_layout           = empty( $dokan_appearance['store_header_template'] ) ? 'default' : $dokan_appearance['store_header_template'];

		if ( $profile_layout != 'fm_custom') {
			return $template;
		}


		if( $slug != 'store-header' ) {
			return $template;
		}

		return get_template_part('dokan/store-header-custom');

	}

	/**
	 * Vendor Mobile Product Found
	 */
	function mobile_products_found() {
		if ( ! intval( farmart_is_mobile() ) ) {
			return;
		}

		if ( ! intval( farmart_get_option( 'enable_mobile_version' ) ) ) {
			return;
		}

		global $wp_query;
		$total = $wp_query->found_posts;

		echo '<div class="products-found"><span>' . $total . '</span>' . esc_html__( ' Products found', 'farmart' ) . '</div>';
	}

	/**
	 * Vendor Mobile Close Sidebar
	 */
	function mobile_close_sidebar() {
		if ( ! intval( farmart_is_mobile() ) ) {
			return;
		}

		if ( ! intval( farmart_get_option( 'enable_mobile_version' ) ) ) {
			return;
		}

		$title = farmart_get_option('catalog_vendor_sidebar_title');

		echo '<div href="#" class="fm-vendor-close-sidebar" id="fm-vendor-close-sidebar"> <h2>'. esc_html( $title ) .'</h2> <a class="close-sidebar">'. Farmart\Icon::get_svg( 'cross' ) .'</a></div>';
	}
}