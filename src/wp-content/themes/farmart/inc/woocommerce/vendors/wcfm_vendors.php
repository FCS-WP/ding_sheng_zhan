<?php

/**
 * Class for all Vendor template modification
 *
 * @version 1.0
 */
class Farmart_WCFMVendors {

	/**
	 * Construction function
	 *
	 * @since  1.0
	 * @return Farmart_WCFMVendors
	 */
	function __construct() {
		// Check if Woocomerce plugin is actived
		if ( ! class_exists( 'WCFMmp' ) ) {
			return;
		}

		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'farmart_wcfm_vendor_scripts' ), 20 );

		add_filter( 'body_class', array( $this, 'body_classes' ) );

		// Sold by catalog page
		add_action( 'woocommerce_shop_loop_item_title', array( $this, 'template_loop_sold_by' ), 9 );
		add_action( 'farmart_product_list_details', array( $this, 'template_loop_sold_by' ), 20 );
		add_action( 'farmart_product_details_2', array( $this, 'template_loop_sold_by' ), 20 );
		add_action( 'farmart_single_product_deal_summary', array( $this, 'template_loop_sold_by' ), 8 );
		add_action( 'farmart_single_product_deal_2_content', array( $this, 'template_loop_sold_by' ), 8 );

		// Remove sold by default catalog page
		add_filter( 'wcfmmp_is_allow_archive_product_sold_by', '__return_false' );

		// Remove sold by default single page
		add_filter( 'wcfmmp_is_allow_sold_by', '__return_false' );


		if ( farmart_get_option( 'wcfm_vendor_store_header' ) == 'themes' ) {

			// Change position store name header
			add_filter( 'wcfm_is_allow_store_name_on_header', '__return_true' );
			add_filter( 'wcfm_is_allow_store_name_on_banner', '__return_false' );

			// Add box address store header
			add_filter( 'wcfmmp_store_before_address', array( $this, 'add_box_address_before' ) );
			add_filter( 'wcfmmp_store_after_address', array( $this, 'add_box_store_header_end_after' ) );

			// Add box phone store header
			add_filter( 'wcfmmp_store_before_phone', array( $this, 'add_box_phone_before' ) );
			add_filter( 'wcfmmp_store_after_phone', array( $this, 'add_box_store_header_end_after' ) );

			// Add box email store header
			add_filter( 'wcfmmp_store_before_email', array( $this, 'add_box_email_before' ) );
			add_filter( 'wcfmmp_store_after_email', array( $this, 'add_box_store_header_end_after' ) );
		}

		// Add box product
		add_filter( 'wcfmmp_before_store_product', array( $this, 'add_box_before_store_product' ) );
		add_filter( 'wcfmmp_after_store_product', array( $this, 'add_box_after_store_product' ) );

		// Mobile
		add_action( 'woocommerce_before_shop_loop', array( $this,'mobile_products_found'), 29 );
		add_action( 'wcfmmp_store_before_sidabar', array( $this, 'add_before_box_sidebar' ) );
		add_action( 'wcfmmp_store_after_sidebar', array( $this, 'add_after_box_sidebar' ), 4 );
		add_action( 'wcfmmp_store_after_sidebar', array( $this, 'mobile_close_sidebar' ), 4 );

		// Change vendor columns product
		add_filter( 'farmart_shop_columns', array( $this, 'shop_columns' ), 20 );

	}

	public static function farmart_wcfm_vendor_scripts( ) {
		wp_enqueue_style(  'farmart-wcfm-vendor-style', get_template_directory_uri() . '/css/wcfm-vendor.css' );
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
		// Adds a class template header layout
		$header_layout = farmart_get_option( 'wcfm_vendor_store_header' );
		if ( farmart_is_vendor_page() ) {
			$shop_view = isset( $_COOKIE['shop_view'] ) ? $_COOKIE['shop_view'] : farmart_get_option( 'catalog_vendor_view' );
			$classes[] = 'catalog-view-' . $shop_view;

			$classes[] = 'wcfm-template-' . $header_layout;
		}

		if ( is_singular( 'product' ) ) {
			$classes[] = 'wcfm-template-' . $header_layout;
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

		if ( ! class_exists( 'WCFM' ) ) {
			return;
		}

		global $WCFM, $post;

		$vendor_id = $WCFM->wcfm_vendor_support->wcfm_get_vendor_id_from_product( $post->ID );

		if ( ! $vendor_id ) {
			return;
		}

		$sold_by_text = apply_filters( 'wcfmmp_sold_by_label', Farmart\Icon::get_svg( 'store', '', 'shop' ) );
		$store_name   = $WCFM->wcfm_vendor_support->wcfm_get_vendor_store_by_vendor( absint( $vendor_id ) );

		echo '<div class="sold-by-meta">';
		echo '<span class="sold-by-label">' . $sold_by_text . ' ' . '</span>';
		echo ! empty( $store_name ) ? $store_name : '';
		echo '</div>';
	}

	/**
	 * Adds box address after header store
	 */
	function add_box_address_before() {
		echo '<div class="wcfm-store-address"><label>' . esc_html__( 'Address: ', 'farmart' ) . '</label>';
	}

	/**
	 * Adds box phone after header store
	 */
	function add_box_phone_before() {
		echo '<div class="wcfm-store-address"><label>' . esc_html__( 'Phone: ', 'farmart' ) . '</label>';
	}

	/**
	 * Adds box email after header store
	 */
	function add_box_email_before() {
		echo '<div class="wcfm-store-address"><label>' . esc_html__( 'Email: ', 'farmart' ) . '</label>';
	}

	/**
	 * Adds box address before header store
	 */
	function add_box_store_header_end_after() {
		echo '</div>';
	}

	/**
	 * Adds box email after header store
	 */
	function add_box_before_store_product() {
		echo '<div class="fm-shop-content">';
	}

	/**
	 * Adds box address before header store
	 */
	function add_box_after_store_product() {
		echo '</div>';
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
	 * Wcfm add before box sidebar
	 */
	function add_before_box_sidebar() {
		if ( ! intval( farmart_is_mobile() ) ) {
			return;
		}

		if ( ! intval( farmart_get_option( 'enable_mobile_version' ) ) ) {
			return;
		}

		echo '<div class="wcfm-widget-area">';
	}

	/**
	 * Wcfm add before box sidebar
	 */
	function add_after_box_sidebar() {
		if ( ! intval( farmart_is_mobile() ) ) {
			return;
		}

		if ( ! intval( farmart_get_option( 'enable_mobile_version' ) ) ) {
			return;
		}

		echo '</div>';
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