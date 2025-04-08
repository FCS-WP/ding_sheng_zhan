<?php

/**
 * Theme options of WooCommerce.
 *
 * @package Farmart
 */


/**
 * Adds theme options panels of WooCommerce.
 *
 * @param array $panels Theme options panels.
 *
 * @return array
 */
function farmart_woocommerce_customize_panels( $panels ) {
	$panels['shop'] = array(
		'priority' => 200,
		'title'    => esc_html__( 'Catalog Page', 'farmart' ),
	);

	$panels['single_product'] = array(
		'priority' => 200,
		'title'    => esc_html__( 'Single Product', 'farmart' ),
	);

	return $panels;
}

add_filter( 'farmart_customize_panels', 'farmart_woocommerce_customize_panels' );

/**
 * Adds theme options sections of WooCommerce.
 *
 * @param array $sections Theme options sections.
 *
 * @return array
 */
function farmart_woocommerce_customize_sections( $sections ) {
	$sections = array_merge(
		$sections, array(
			'product_notifications' => array(
				'title'    => esc_html__( 'Product Notifications', 'farmart' ),
				'priority' => 60,
				'panel'    => 'woocommerce',
			),
			'badge'                 => array(
				'title'       => esc_html__( 'Badges', 'farmart' ),
				'description' => '',
				'priority'    => 60,
				'panel'       => 'woocommerce',
				'capability'  => 'edit_theme_options',
			),

			'cart_page'                => array(
				'title'    => esc_html__( 'Cart Page', 'farmart' ),
				'priority' => 60,
				'panel'    => 'woocommerce',
			),
			'account_page'                => array(
				'title'       => esc_html__( 'Account Page', 'farmart' ),
				'description' => '',
				'priority'    => 60,
				'panel'       => 'woocommerce',
				'capability'  => 'edit_theme_options',
			),
			'catalog_header'            => array(
				'title'       => esc_html__( 'Catalog Header', 'farmart' ),
				'description' => '',
				'priority'    => 60,
				'panel'       => 'shop',
				'capability'  => 'edit_theme_options',
			),
			'catalog'               => array(
				'title'    => esc_html__( 'Catalog Layout', 'farmart' ),
				'priority' => 60,
				'panel'    => 'shop',
			),

			'catalog_page'          => array(
				'title'       => esc_html__( 'Shop Page', 'farmart' ),
				'description' => '',
				'priority'    => 60,
				'panel'       => 'shop',
			),

			'product_cat_level_1_page'    => array(
				'title'       => esc_html__( 'Category Level 1 Page', 'farmart' ),
				'description' => '',
				'priority'    => 60,
				'panel'       => 'shop',
				'capability'  => 'edit_theme_options',
			),

			'catalog_banners'    => array(
				'title'       => esc_html__( 'Banners', 'farmart' ),
				'description' => '',
				'priority'    => 60,
				'panel'       => 'shop',
				'capability'  => 'edit_theme_options',
			),

			// Single Product
			'product_general'      => array(
				'title'       => esc_html__( 'Product General', 'farmart' ),
				'description' => '',
				'priority'    => 10,
				'panel'       => 'single_product',
				'capability'  => 'edit_theme_options',
			),
			'product_page_images'  => array(
				'title'       => esc_html__( 'Product Images Gallery', 'farmart' ),
				'description' => '',
				'priority'    => 10,
				'panel'       => 'single_product',
				'capability'  => 'edit_theme_options',
			),
			'product_page_socials' => array(
				'title'       => esc_html__( 'Product Socials', 'farmart' ),
				'description' => '',
				'priority'    => 10,
				'panel'       => 'single_product',
				'capability'  => 'edit_theme_options',
			),
			'product_page_buy_now' => array(
				'title'       => esc_html__( 'Product Buy Now', 'farmart' ),
				'description' => '',
				'priority'    => 10,
				'panel'       => 'single_product',
				'capability'  => 'edit_theme_options',
			),
			'product_page_fbt'     => array(
				'title'       => esc_html__( 'Frequently Bought Together', 'farmart' ),
				'description' => '',
				'priority'    => 50,
				'panel'       => 'single_product',
				'capability'  => 'edit_theme_options',
			),
			'related_products'     => array(
				'title'       => esc_html__( 'Related Products', 'farmart' ),
				'description' => '',
				'priority'    => 10,
				'panel'       => 'single_product',
				'capability'  => 'edit_theme_options',
			),
			'instagram_photos'         => array(
				'title'    => esc_html__( 'Instagram Photos', 'farmart' ),
				'priority' => 10,
				'panel'    => 'single_product',
			),
			'upsells_products'     => array(
				'title'       => esc_html__( 'Up-Sells Products', 'farmart' ),
				'description' => '',
				'priority'    => 10,
				'panel'       => 'single_product',
				'capability'  => 'edit_theme_options',
			),
		)
	);

	return $sections;
}

add_filter( 'farmart_customize_sections', 'farmart_woocommerce_customize_sections' );

/**
 * Adds theme options of WooCommerce.
 *
 * @param array $settings Theme options.
 *
 * @return array
 */
function farmart_woocommerce_customize_fields( $fields ) {
	// Product page.
	$fields = array_merge(
		$fields, array(
			// Cart Page
			'clear_cart_button'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Clear Cart Button', 'farmart' ),
				'default'     => 0,
				'section'     => 'cart_page',
				'description' => esc_html__( 'Enable to show Clear Cart button on cart page.', 'farmart' ),
				'priority'    => 20,
			),
			// Cross Products
			'cart_page_custom'             => array(
				'type'     => 'custom',
				'label'    => '<hr/>',
				'default'  => '<h2>' . esc_html__( 'Cross Sells Products', 'farmart' ) . '</h2>',
				'section'  => 'cart_page',
				'priority' => 40,
			),
			'cross_sells_products'         => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Cross Sells Products', 'farmart' ),
				'section'     => 'cart_page',
				'default'     => 1,
				'priority'    => 40,
				'description' => esc_html__( 'Check this option to show cross-sells products in the cart page', 'farmart' ),
			),
			'cross_sells_products_title'   => array(
				'type'     => 'text',
				'label'    => esc_html__( 'Cross Sells Products Title', 'farmart' ),
				'section'  => 'cart_page',
				'default'  => esc_html__( 'You may be interested in...', 'farmart' ),
				'priority' => 40,
			),
			'cross_sells_products_columns' => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Cross Sells Products Columns', 'farmart' ),
				'section'     => 'cart_page',
				'default'     => '4',
				'priority'    => 40,
				'description' => esc_html__( 'Specify how many columns of cross-sells products you want to show on the cart page', 'farmart' ),
				'choices'     => array(
					'3' => esc_html__( '3 Columns', 'farmart' ),
					'4' => esc_html__( '4 Columns', 'farmart' ),
					'5' => esc_html__( '5 Columns', 'farmart' ),
					'6' => esc_html__( '6 Columns', 'farmart' ),
					'7' => esc_html__( '7 Columns', 'farmart' ),
				),
			),
			'cross_sells_products_numbers' => array(
				'type'        => 'number',
				'label'       => esc_html__( 'Cross Sells Products Numbers', 'farmart' ),
				'section'     => 'cart_page',
				'default'     => 6,
				'priority'    => 40,
				'description' => esc_html__( 'Specify how many numbers of cross-sells products you want to show on the cart page', 'farmart' ),
			),

			// Account Page
			'login_register_layout'              => array(
				'type'     => 'select',
				'label'    => esc_html__( 'Login & Register Layout', 'farmart' ),
				'section'  => 'account_page',
				'default'  => 'tabs',
				'priority' => 40,
				'choices'  => array(
					'tabs'      => esc_html__( 'Tabs', 'farmart' ),
					'promotion' => esc_html__( 'With Promotion', 'farmart' ),
				),
			),
			'login_promotion_title'              => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Promotion Title', 'farmart' ),
				'section'         => 'account_page',
				'default'         => esc_html__( 'Advantages Of Becoming A Member', 'farmart' ),
				'priority'        => 40,
				'active_callback' => array(
					array(
						'setting'  => 'login_register_layout',
						'operator' => '==',
						'value'    => 'promotion',
					),
				),
			),
			'login_promotion_text'               => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Promotion Text', 'farmart' ),
				'section'         => 'account_page',
				'default'         => '',
				'priority'        => 40,
				'active_callback' => array(
					array(
						'setting'  => 'login_register_layout',
						'operator' => '==',
						'value'    => 'promotion',
					),
				),
			),
			'login_promotion_list'               => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Promotion List', 'farmart' ),
				'section'         => 'account_page',
				'default'         => '',
				'priority'        => 40,
				'active_callback' => array(
					array(
						'setting'  => 'login_register_layout',
						'operator' => '==',
						'value'    => 'promotion',
					),
				),
			),
			'login_ads_title'                    => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Ads Title', 'farmart' ),
				'section'         => 'account_page',
				'default'         => '',
				'priority'        => 40,
				'active_callback' => array(
					array(
						'setting'  => 'login_register_layout',
						'operator' => '==',
						'value'    => 'promotion',
					),
				),
			),
			'login_ads_text'                     => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Ads Text', 'farmart' ),
				'section'         => 'account_page',
				'default'         => '',
				'priority'        => 40,
				'active_callback' => array(
					array(
						'setting'  => 'login_register_layout',
						'operator' => '==',
						'value'    => 'promotion',
					),
				),
			),

			'added_to_cart_notice'         => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Added to Cart Notification', 'farmart' ),
				'description' => esc_html__( 'Display a notification when a product is added to cart', 'farmart' ),
				'section'     => 'product_notifications',
				'priority'    => 70,
				'default'     => 1,
			),
			'cart_notice_auto_hide'        => array(
				'type'        => 'number',
				'label'       => esc_html__( 'Cart Notification Auto Hide', 'farmart' ),
				'description' => esc_html__( 'How many seconds you want to hide the notification.', 'farmart' ),
				'section'     => 'product_notifications',
				'priority'    => 70,
				'default'     => 3,
			),
			'open_cart_panel_added_to_cart_notice'         => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Auto open cart panel', 'farmart' ),
				'description' => esc_html__( 'Open cart panel after Added to Cart Notification', 'farmart' ),
				'section'     => 'product_notifications',
				'priority'    => 70,
				'default'     => false,
				'active_callback' => array(
					array(
						'setting'  => 'added_to_cart_notice',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'header_cart_behaviour',
						'operator' => '==',
						'value'    => 'panel',
					)
				),
			),
			'cart_notice_auto_hide_custom' => array(
				'type'     => 'custom',
				'section'  => 'product_notifications',
				'default'  => '<hr>',
				'priority' => 70,
			),

			'added_to_wishlist_notice'                    => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Added to Wislist Notification', 'farmart' ),
				'description' => esc_html__( 'Display a notification when a product is added to wishlist', 'farmart' ),
				'section'     => 'product_notifications',
				'priority'    => 70,
				'default'     => 1,
			),
			'wishlist_notice_auto_hide'                   => array(
				'type'        => 'number',
				'label'       => esc_html__( 'Wishlist Notification Auto Hide', 'farmart' ),
				'description' => esc_html__( 'How many seconds you want to hide the notification.', 'farmart' ),
				'section'     => 'product_notifications',
				'priority'    => 70,
				'default'     => 3,
			),

			// Catalog General
			'catalog_ajax_filter'                     => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'AJAX For Filtering', 'farmart' ),
				'section'     => 'catalog',
				'description' => esc_html__( 'Check this option to use AJAX for filtering in the catalog page.', 'farmart' ),
				'default'     => 1,
			),

			'catalog_layout'               => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Catalog Layout', 'farmart' ),
				'default'     => 'sidebar-content',
				'section'     => 'catalog',
				'description' => esc_html__( 'Select layout for catalog.', 'farmart' ),
				'choices'     => array(
					'sidebar-content' => esc_html__( 'Left Sidebar', 'farmart' ),
					'content-sidebar' => esc_html__( 'Right Sidebar', 'farmart' ),
					'full-content'    => esc_html__( 'Full Content', 'farmart' ),
				),
			),

			'catalog_full_width'           => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Full Width', 'farmart' ),
				'section'  => 'catalog',
				'default'  => 0,
				'description' => esc_html__('Check this option to enable full width in the catalog page.','farmart'),
			),

			'catalog_sidebar_style'               => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Catalog Sidebar Style', 'farmart' ),
				'default'     => '1',
				'section'     => 'catalog',
				'description' => esc_html__( 'Select style for catalog style.', 'farmart' ),
				'choices'     => array(
					'1' => esc_html__( 'Style 1', 'farmart' ),
					'2' => esc_html__( 'Style 2', 'farmart' ),
				),
			),

			'catalog_br_3'                  => array(
				'type'     => 'custom',
				'section'  => 'catalog',
				'default'  => '<hr>',
				'active_callback' => array(
					array(
						'setting'  => 'catalog_header_layout',
						'operator' => 'in',
						'value'    => array( '1', '2' ),
					),
				),
			),

			'catalog_toolbar_elements'                          => array(
				'type'    => 'multicheck',
				'label'   => esc_html__( 'ToolBar Elements', 'farmart' ),
				'default' => array( 'total_product', 'page', 'sort_by', 'per_page', 'view' ),
				'choices' => array(
					'total_product' => esc_attr__( 'Total Products', 'farmart' ),
					'page'          => esc_attr__( 'Page', 'farmart' ),
					'sort_by'       => esc_attr__( 'Sort by', 'farmart' ),
					'per_page'       => esc_attr__( 'Per Page', 'farmart' ),
					'view'          => esc_attr__( 'View', 'farmart' ),
				),
				'description' => esc_html__('Select which elements you want to show.','farmart'),
				'section' => 'catalog',
				'active_callback' => array(
					array(
						'setting'  => 'catalog_header_layout',
						'operator' => 'in',
						'value'    => array( '1', '2' ),
					),
				),
			),

			'catalog_per_page'                  => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Per Page', 'farmart' ),
				'section'         => 'catalog',
				'default'      => [
					[
						'number' => 8,
					],
					[
						'number' => 12,
					],
					[
						'number' => 16,
					],
				],
				'row_label'       => array(
					'type'  => 'text',
					'value' => esc_html__( 'Per Page', 'farmart' ),
				),
				'fields'          => array(
					'number'    => array(
						'type'    => 'number',
						'label'   => esc_html__( 'Number', 'farmart' ),
						'default' => '',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'catalog_toolbar_elements',
						'operator' => 'contains',
						'value'    => 'per_page',
					),
					array(
						'setting'  => 'catalog_header_layout',
						'operator' => 'in',
						'value'    => array( '1', '2' ),
					),
				),
			),

			'catalog_type' => array(
				'type'            => 'sortable',
				'label'           => esc_html__( 'Catalog Type', 'farmart' ),
				'section'         => 'catalog',
				'default'         => array( 'grid', 'extended', 'list' ),
				'choices'         => array(
					'grid'     => esc_attr__( 'Grid', 'farmart' ),
					'extended' => esc_attr__( 'Extended', 'farmart' ),
					'list'     => esc_attr__( 'List', 'farmart' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'catalog_toolbar_elements',
						'operator' => 'contains',
						'value'    => 'view',
					),
					array(
						'setting'  => 'catalog_header_layout',
						'operator' => 'in',
						'value'    => array( '1', '2' ),
					),
				),
				'description'	=> esc_html__('The first value will become the default type.','farmart')
			),

			'catalog_products_columns' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Product Columns', 'farmart' ),
				'default'         => '4',
				'section'         => 'catalog',
				'choices'         => array(
					'2' => esc_html__( '2 Columns', 'farmart' ),
					'3' => esc_html__( '3 Columns', 'farmart' ),
					'4' => esc_html__( '4 Columns', 'farmart' ),
					'5' => esc_html__( '5 Columns', 'farmart' ),
					'6' => esc_html__( '6 Columns', 'farmart' ),
					'7' => esc_html__( '7 Columns', 'farmart' ),
				),
				'description'     => esc_html__( 'Specify how many product columns you want to show. This option will display if you choose the grid view or extended view option', 'farmart' ),
				'active_callback' => array(
					array(
						'setting'  => 'catalog_type',
						'operator' => 'contains',
						'value'    => array('grid','extended'),
					),
					array(
						'setting'  => 'catalog_header_layout',
						'operator' => 'in',
						'value'    => array( '1', '2' ),
					),
				),
			),

			'catalog_product_loop'           => array(
				'type'     => 'custom',
				'section'  => 'catalog',
				'label'    => '<hr/>',
				'default'  => '<h2>' . esc_html__( 'Product Loop', 'farmart' ) . '</h2>',
			),

			'catalog_product_loop_show_qty'                 => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Show Qty', 'farmart' ),
				'section'  => 'catalog',
				'default'  => 0,
			),

			'shop_custom_5'                => array(
				'type'     => 'custom',
				'section'  => 'catalog',
				'default'  => '<hr>',
				'priority' => 70,
			),
			'catalog_nav_type'           => array(
				'type'     => 'radio',
				'section'  => 'catalog',
				'label'    => esc_html__( 'Navigation Type', 'farmart' ),
				'default'  => 'numeric',
				'priority' => 70,
				'choices'  => array(
					'numeric'  			=> esc_attr__( 'Numeric', 'farmart' ),
					'numeric-short'  	=> esc_attr__( 'Numeric Short', 'farmart' ),
					'loadmore' 			=> esc_attr__( 'Load More', 'farmart' ),
					'infinite' 			=> esc_attr__( 'Infinite Scroll', 'farmart' ),
				),
			),

			// Categories Box
			'catalog_header_layout'       => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Catalog Header Layout', 'farmart' ),
				'default'         => '3',
				'section'         => 'catalog_header',
				'choices'         => array(
					'1' => esc_html__( 'Layout 1', 'farmart' ),
					'2' => esc_html__( 'Layout 2', 'farmart' ),
					'3' => esc_html__( 'Layout 3', 'farmart' ),
				),
				'priority' => 10,
			),

			'catalog_br_1'                => array(
				'type'     => 'custom',
				'section'  => 'catalog_header',
				'default'  => '<hr>',
				'active_callback' => array(
					array(
						'setting'  => 'catalog_header_layout',
						'operator' => '==',
						'value'    => '2',
					),
				),
				'priority' => 15,
			),

			'catalog_page_header_els'                          => array(
				'type'    => 'multicheck',
				'label'   => esc_html__( 'Page Header', 'farmart' ),
				'section' => 'catalog_header',
				'default' => array( 'breadcrumb', 'title', 'description', 'search'),
				'choices' => array(
					'title'          	=> esc_attr__( 'Title', 'farmart' ),
					'description'       => esc_attr__( 'Description', 'farmart' ),
					'search'       		=> esc_attr__( 'Search', 'farmart' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'catalog_header_layout',
						'operator' => '==',
						'value'    => '2',
					),
				),
				'priority' => 20,
			),

			'catalog_banners_custom' => array(
				'type'            => 'custom',
				'label'           => '<hr/>',
				'default'         => '<h2>' . esc_html__( 'Banners Carousel', 'farmart' ) . '</h2>',
				'section'         => 'catalog_header',
				'priority' => 25,
			),

			'catalog_banners_enable'                 => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Enable', 'farmart' ),
				'section'  => 'catalog_header',
				'default'  => 0,
				'priority' => 30,
			),

			'catalog_banners_els'                  => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Banners', 'farmart' ),
				'section'         => 'catalog_header',
				'default'         => '',
				'row_label'       => array(
					'type'  => 'text',
					'value' => esc_html__( 'Banner', 'farmart' ),
				),
				'fields'          => array(
					'image'    => array(
						'type'    => 'image',
						'label'   => esc_html__( 'Image', 'farmart' ),
						'default' => '',
					),
					'link_url' => array(
						'type'    => 'text',
						'label'   => esc_html__( 'Link(URL)', 'farmart' ),
						'default' => '',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'catalog_banners_enable',
						'operator' => '==',
						'value'    => 1,
					),
				),
				'priority' => 35,

			),

			'catalog_banners_autoplay'         => array(
				'type'            => 'number',
				'label'           => esc_html__( 'Autoplay', 'farmart' ),
				'description'     => esc_html__( 'Duration of animation between slides (in ms). Enter the value is 0 or empty if you want the slider is not autoplay', 'farmart' ),
				'section'         => 'catalog_header',
				'default'         => '0',
				'active_callback' => array(
					array(
						'setting'  => 'catalog_banners_enable',
						'operator' => '==',
						'value'    => 1,
					),
				),
				'priority' => 40,

			),

			'catalog_banners_bg_image'    => array(
				'type'    => 'image',
				'label'   => esc_html__( 'Background Image', 'farmart' ),
				'section'         => 'catalog_header',
				'default' 		  => '',
				'active_callback' => array(
					array(
						'setting'  => 'catalog_banners_enable',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'catalog_header_layout',
						'operator' => '==',
						'value'    => '3',
					),
				),
				'priority' => 45,
			),

			'catalog_banners_margin_top'   => array(
				'type'      => 'slider',
				'label'     => esc_html__('Space Top', 'farmart'),
				'section'   => 'catalog_header',
				'default'   => 0,
				'transport' => 'postMessage',
				'choices'   => array(
					'min' => 0,
					'max' => 500,
				),
				'js_vars'         => array(
					array(
						'element'  => '.catalog-banners-carousel',
						'property' => 'margin-top',
						'units'    => 'px',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'catalog_banners_enable',
						'operator' => '==',
						'value'    => 1,
					),
				),
				'priority' => 50,
			),
			'catalog_banners_margin_bottom'   => array(
				'type'      => 'slider',
				'label'     => esc_html__('Space Bottom', 'farmart'),
				'section'   => 'catalog_header',
				'default'   => 0,
				'transport' => 'postMessage',
				'choices'   => array(
					'min' => 0,
					'max' => 500,
				),
				'js_vars'         => array(
					array(
						'element'  => '.catalog-banners-carousel',
						'property' => 'margin-bottom',
						'units'    => 'px',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'catalog_banners_enable',
						'operator' => '==',
						'value'    => 1,
					),
				),
				'priority' => 55,
			),

			'catalog_top_categories_custom' => array(
				'type'            => 'custom',
				'label'           => '<hr/>',
				'default'         => '<h2>' . esc_html__( 'Top Categories', 'farmart' ) . '</h2>',
				'section'         => 'catalog_header',
				'active_callback' => array(
					array(
						'setting'  => 'catalog_header_layout',
						'operator' => 'in',
						'value'    => array('1', '2'),
					),
				),
				'priority' => 60,

			),

			'catalog_top_categories_enable'                 => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Enable', 'farmart' ),
				'section'  => 'catalog_header',
				'default'  => 0,
				'active_callback' => array(
					array(
						'setting'  => 'catalog_header_layout',
						'operator' => 'in',
						'value'    => array('1', '2'),
					),
				),
				'priority' => 65,
			),

			'catalog_top_categories_title'         => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Title', 'farmart' ),
				'default'         => esc_html__( 'Top Featured Categories', 'farmart' ),
				'section'         => 'catalog_header',
				'active_callback' => array(
					array(
						'setting'  => 'catalog_header_layout',
						'operator' => 'in',
						'value'    => array('1', '2'),
					),
					array(
						'setting'  => 'catalog_top_categories_enable',
						'operator' => '==',
						'value'    => 1,
					),
				),
				'priority' => 70,
			),
			'catalog_top_categories_link_text'     => array(
				'type'            => 'text',
				'label'           => esc_html__( 'View All Text', 'farmart' ),
				'default'         => '',
				'section'         => 'catalog_header',
				'active_callback' => array(
					array(
						'setting'  => 'catalog_header_layout',
						'operator' => 'in',
						'value'    => array('1', '2'),
					),
					array(
						'setting'  => 'catalog_top_categories_enable',
						'operator' => '==',
						'value'    => 1,
					),
				),
				'priority' => 75,
			),
			'catalog_top_categories_link_url'      => array(
				'type'            => 'text',
				'label'           => esc_html__( 'View All Link', 'farmart' ),
				'default'         => '',
				'section'         => 'catalog_header',
				'active_callback' => array(
					array(
						'setting'  => 'catalog_header_layout',
						'operator' => 'in',
						'value'    => array('1', '2'),
					),
					array(
						'setting'  => 'catalog_top_categories_enable',
						'operator' => '==',
						'value'    => 1,
					),
				),
				'priority' => 80,
			),
			'catalog_top_categories_numbers'        => array(
				'type'            => 'number',
				'label'           => esc_html__( 'Category Numbers', 'farmart' ),
				'section'         => 'catalog_header',
				'default'         => 6,
				'active_callback' => array(
					array(
						'setting'  => 'catalog_header_layout',
						'operator' => 'in',
						'value'    => array('1', '2'),
					),
					array(
						'setting'  => 'catalog_top_categories_enable',
						'operator' => '==',
						'value'    => 1,
					),
				),
				'priority' => 85,
			),
			'catalog_top_categories_columns'       => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Columns', 'farmart' ),
				'default'         => '4',
				'section'         => 'catalog_header',
				'choices'         => array(
					'3' => esc_html__( '3 Columns', 'farmart' ),
					'4' => esc_html__( '4 Columns', 'farmart' ),
					'5' => esc_html__( '5 Columns', 'farmart' ),
					'6' => esc_html__( '6 Columns', 'farmart' ),
					'7' => esc_html__( '7 Columns', 'farmart' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'catalog_header_layout',
						'operator' => 'in',
						'value'    => array('1', '2'),
					),
					array(
						'setting'  => 'catalog_top_categories_enable',
						'operator' => '==',
						'value'    => 1,
					),
				),
				'priority' => 90,
			),
			'catalog_top_categories_orderby'       => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Order By', 'farmart' ),
				'section'         => 'catalog_header',
				'default'         => 'order',
				'choices'         => array(
					'order' => esc_html__( 'Category Order', 'farmart' ),
					'name'  => esc_html__( 'Name', 'farmart' ),
					'count' => esc_html__( 'Count', 'farmart' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'catalog_header_layout',
						'operator' => 'in',
						'value'    => array('1', '2'),
					),
					array(
						'setting'  => 'catalog_top_categories_enable',
						'operator' => '==',
						'value'    => 1,
					),
				),
				'priority' => 95,
			),

			// Product Carousel
			'catalog_products_carousel_custom' => array(
				'type'            => 'custom',
				'label'           => '<hr/>',
				'default'         => '<h2>' . esc_html__( 'Products Carousel', 'farmart' ) . '</h2>',
				'section'         => 'catalog_header',
				'active_callback' => array(
					array(
						'setting'  => 'catalog_header_layout',
						'operator' => 'in',
						'value'    => array('1', '2'),
					),
				),
				'priority' => 100,
			),
			'catalog_products_carousel_enable'                 => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Enable', 'farmart' ),
				'section'  => 'catalog_header',
				'default'  => 0,
				'active_callback' => array(
					array(
						'setting'  => 'catalog_header_layout',
						'operator' => 'in',
						'value'    => array('1', '2'),
					),
				),
				'priority' => 105,
			),
			'catalog_products_carousel_els'        => array(
				'type'            => 'repeater',
				'label'           => '',
				'section'         => 'catalog_header',
				'default'         => '',
				'row_label'       => array(
					'type'  => 'text',
					'value' => esc_html__( 'Products Carousel', 'farmart' ),
				),
				'fields'          => array(
					'title'     => array(
						'type'    => 'text',
						'label'   => esc_html__( 'Title', 'farmart' ),
						'default' => '',
					),
					'icons'                                  => array(
						'type'              => 'textarea',
						'label'             => esc_html__( 'Icons', 'farmart' ),
						'section'           => 'header_logo',
						'description'       => esc_html__( 'Paste SVG code of your icon here', 'farmart' ),
						'sanitize_callback' => 'Farmart\Icon::sanitize_svg',
						'output'            => array(
							array(
								'element' => '.fm-catalog-carousel .carousel-header',
							),
						),
					),
					'link_text' => array(
						'type'    => 'text',
						'label'   => esc_html__( 'Link Text', 'farmart' ),
						'default' => '',
					),
					'link_url'  => array(
						'type'    => 'text',
						'label'   => esc_html__( 'Link (URL)', 'farmart' ),
						'default' => '',
					),
					'number'    => array(
						'type'    => 'number',
						'label'   => esc_html__( 'Product Number', 'farmart' ),
						'default' => 6,
					),
					'columns'   => array(
						'type'    => 'select',
						'label'   => esc_html__( 'Columns', 'farmart' ),
						'default' => '4',
						'choices' => array(
							'3' => esc_html__( '3 Columns', 'farmart' ),
							'4' => esc_html__( '4 Columns', 'farmart' ),
							'5' => esc_html__( '5 Columns', 'farmart' ),
							'6' => esc_html__( '6 Columns', 'farmart' ),
							'7' => esc_html__( '7 Columns', 'farmart' ),
						),
					),
					'autoplay'  => array(
						'type'        => 'number',
						'label'       => esc_html__( 'Autoplay', 'farmart' ),
						'default'     => '',
						'description' => esc_html__( 'Duration of animation between slides (in ms). Enter the value is 0 or empty if you want the slider is not autoplay', 'farmart' ),
					),
					'type'      => array(
						'type'    => 'select',
						'label'   => esc_html__( 'Type', 'farmart' ),
						'default' => 'featured',
						'choices' => array(
							'featured'     => esc_html__( 'Featured Products', 'farmart' ),
							'best_selling' => esc_html__( 'Best Seller Products', 'farmart' ),
							'sale'         => esc_html__( 'Sale Products', 'farmart' ),
							'recent'       => esc_html__( 'Recent Products', 'farmart' ),
							'top_rated'    => esc_html__( 'Top Rated Products', 'farmart' ),
						),
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'catalog_header_layout',
						'operator' => 'in',
						'value'    => array('1', '2'),
					),
					array(
						'setting'  => 'catalog_products_carousel_enable',
						'operator' => '==',
						'value'    => 1,
					),
				),
				'priority' => 110,
			),

			/**
			 * End Elements Layout
			 */

			// Badge
			'catalog_badges'          => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Catalog Badges', 'farmart' ),
				'section'     => 'badge',
				'default'     => true,
				'priority'    => 20,
				'description' => esc_html__( 'Check this to show badges in the catalog page.', 'farmart' ),
			),
			'catalog_badges_els'                  => array(
				'type'        => 'multicheck',
				'label'       => esc_html__( 'Badge Elements', 'farmart' ),
				'section'     => 'badge',
				'default'     => array( 'hot', 'new', 'sale', 'outofstock' ),
				'priority'    => 20,
				'choices'     => array(
					'hot'        => esc_html__( 'Hot', 'farmart' ),
					'new'        => esc_html__( 'New', 'farmart' ),
					'sale'       => esc_html__( 'Sale', 'farmart' ),
					'outofstock' => esc_html__( 'Out Of Stock', 'farmart' ),
				),
				'description' => esc_html__( 'Select which badges you want to show', 'farmart' ),
			),

			'catalog_hot_badge_custom'        => array(
				'type'     => 'custom',
				'label'    => '<hr/>',
				'default'  => '<h2>' . esc_html__( 'Hot Badge', 'farmart' ) . '</h2>',
				'section'  => 'badge',
				'priority' => 20,
				'active_callback' => array(
					array(
						'setting'  => 'catalog_badges_els',
						'operator' => 'contains',
						'value'    => 'hot',
					),
				),
			),
			'catalog_badges_hot_text'                => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Text', 'farmart' ),
				'section'         => 'badge',
				'default'         => 'Hot',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'catalog_badges_els',
						'operator' => 'contains',
						'value'    => 'hot',
					),
				),
			),
			'catalog_badges_hot_color'               => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Color', 'farmart' ),
				'default'         => '',
				'section'         => 'badge',
				'priority'        => 20,
				'choices'         => array(
					'alpha' => true,
				),
				'active_callback' => array(
					array(
						'setting'  => 'catalog_badges_els',
						'operator' => 'contains',
						'value'    => 'hot',
					),
				),
			),
			'catalog_badges_hot_bg_color'            => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Background Color', 'farmart' ),
				'default'         => '',
				'section'         => 'badge',
				'priority'        => 20,
				'choices'         => array(
					'alpha' => true,
				),
				'active_callback' => array(
					array(
						'setting'  => 'catalog_badges_els',
						'operator' => 'contains',
						'value'    => 'hot',
					),
				),
			),
			'catalog_outofstock_badge_custom' => array(
				'type'     => 'custom',
				'label'    => '<hr/>',
				'default'  => '<h2>' . esc_html__( 'Out of stock Badge', 'farmart' ) . '</h2>',
				'section'  => 'badge',
				'priority' => 20,
				'active_callback' => array(
					array(
						'setting'  => 'catalog_badges_els',
						'operator' => 'contains',
						'value'    => 'outofstock',
					),
				),
			),
			'catalog_badges_outofstock_text'         => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Text', 'farmart' ),
				'section'         => 'badge',
				'default'         => 'Out Of Stock',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'catalog_badges_els',
						'operator' => 'contains',
						'value'    => 'outofstock',
					),
				),
			),
			'catalog_badges_outofstock_color'        => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Color', 'farmart' ),
				'default'         => '',
				'section'         => 'badge',
				'priority'        => 20,
				'choices'         => array(
					'alpha' => true,
				),
				'active_callback' => array(
					array(
						'setting'  => 'catalog_badges_els',
						'operator' => 'contains',
						'value'    => 'outofstock',
					),
				),
			),
			'catalog_badges_outofstock_bg_color'     => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Background Color', 'farmart' ),
				'default'         => '',
				'section'         => 'badge',
				'priority'        => 20,
				'choices'         => array(
					'alpha' => true,
				),
				'active_callback' => array(
					array(
						'setting'  => 'catalog_badges_els',
						'operator' => 'contains',
						'value'    => 'outofstock',
					),
				),
			),
			'catalog_new_badge_custom'        => array(
				'type'     => 'custom',
				'label'    => '<hr/>',
				'default'  => '<h2>' . esc_html__( 'New Badge', 'farmart' ) . '</h2>',
				'section'  => 'badge',
				'priority' => 20,
				'active_callback' => array(
					array(
						'setting'  => 'catalog_badges_els',
						'operator' => 'contains',
						'value'    => 'new',
					),
				),
			),
			'catalog_badges_new_text'                => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Text', 'farmart' ),
				'section'         => 'badge',
				'default'         => 'New',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'catalog_badges_els',
						'operator' => 'contains',
						'value'    => 'new',
					),
				),
			),
			'catalog_badges_new_color'               => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Color', 'farmart' ),
				'default'         => '',
				'section'         => 'badge',
				'priority'        => 20,
				'choices'         => array(
					'alpha' => true,
				),
				'active_callback' => array(
					array(
						'setting'  => 'catalog_badges_els',
						'operator' => 'contains',
						'value'    => 'new',
					),
				),
			),
			'catalog_badges_new_bg_color'            => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Background Color', 'farmart' ),
				'default'         => '',
				'section'         => 'badge',
				'priority'        => 20,
				'choices'         => array(
					'alpha' => true,
				),
				'active_callback' => array(
					array(
						'setting'  => 'catalog_badges_els',
						'operator' => 'contains',
						'value'    => 'new',
					),
				),
			),
			'catalog_badges_product_newness'         => array(
				'type'            => 'number',
				'label'           => esc_html__( 'Product Newness', 'farmart' ),
				'section'         => 'badge',
				'default'         => 3,
				'priority'        => 20,
				'description'     => esc_html__( 'Display the "New" badge for how many days?', 'farmart' ),
				'active_callback' => array(
					array(
						'setting'  => 'catalog_badges_els',
						'operator' => 'contains',
						'value'    => 'new',
					),
				),
			),
			'catalog_sale_badge_custom'       => array(
				'type'     => 'custom',
				'label'    => '<hr/>',
				'default'  => '<h2>' . esc_html__( 'Sale Badge', 'farmart' ) . '</h2>',
				'section'  => 'badge',
				'priority' => 20,
				'active_callback' => array(
					array(
						'setting'  => 'catalog_badges_els',
						'operator' => 'contains',
						'value'    => 'sale',
					),
				),
			),
			'catalog_badges_sale_color'              => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Color', 'farmart' ),
				'default'         => '',
				'section'         => 'badge',
				'priority'        => 20,
				'choices'         => array(
					'alpha' => true,
				),
				'active_callback' => array(
					array(
						'setting'  => 'catalog_badges_els',
						'operator' => 'contains',
						'value'    => 'sale',
					),
				),
			),
			'catalog_badges_sale_bg_color'           => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Background Color', 'farmart' ),
				'default'         => '',
				'section'         => 'badge',
				'priority'        => 20,
				'choices'         => array(
					'alpha' => true,
				),
				'active_callback' => array(
					array(
						'setting'  => 'catalog_badges_els',
						'operator' => 'contains',
						'value'    => 'sale',
					),
				),
			),

			'catalog_badge_custom'        => array(
				'type'     => 'custom',
				'label'    => '<hr/>',
				'default'  => '<h2>' . esc_html__( 'Custom Badge', 'farmart' ) . '</h2>',
				'section'  => 'badge',
				'priority' => 20,
			),

			'catalog_badge_custom_color'    => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Color', 'farmart' ),
				'default'         => '',
				'section'         => 'badge',
				'priority'        => 20,
				'choices'         => array(
					'alpha' => true,
				),
			),
			'catalog_badge_custom_bg_color' => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Background Color', 'farmart' ),
				'default'         => '',
				'section'         => 'badge',
				'priority'        => 20,
				'choices'         => array(
					'alpha' => true,
				),
			),

			// Single Product
			// Product Page
			'product_layout'            => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Product Page Layout', 'farmart' ),
				'section'     => 'product_general',
				'default'     => '4',
				'priority'    => 10,
				'choices'     => array(
					'1' => esc_html__( 'Layout 1', 'farmart' ),
					'2' => esc_html__( 'Layout 2', 'farmart' ),
					'3' => esc_html__( 'Layout 3', 'farmart' ),
					'4' => esc_html__( 'Layout 4', 'farmart' ),
				),
				'description' => esc_html__( 'Select default layout for product page.', 'farmart' ),
			),
			'product_full_width'        => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Full Width', 'farmart' ),
				'section'     => 'product_general',
				'default'     => 1,
				'priority'    => 10,
				'active_callback' => array(
					array(
						'setting'  => 'product_layout',
						'operator' => 'in',
						'value'    => array('1','3', '4'),
					),
				),
			),
			'product_sidebar'              => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Sidebar', 'farmart' ),
				'section'         => 'product_general',
				'default'         => 'full-content',
				'priority'        => 10,
				'choices'         => array(
					'full-content'    => esc_html__( 'No Sidebar', 'farmart' ),
					'content-sidebar' => esc_html__( 'Content Sidebar', 'farmart' ),
					'sidebar-content' => esc_html__( 'Sidebar Content', 'farmart' ),
				),
				'description'     => esc_html__( 'Select default sidebar for product page.', 'farmart' ),
				'active_callback' => array(
					array(
						'setting'  => 'product_layout',
						'operator' => 'in',
						'value'    => array( '2', '3', '4' ),
					),
				),
			),
			'product_breadcrumb'        => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Breadcrumb', 'farmart' ),
				'section'     => 'product_general',
				'default'     => 1,
				'description' => esc_html__( 'Check this option to show the breadcrumb in the single product', 'farmart' ),
				'priority'    => 10,
			),
			'sticky_product_info'                     => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Sticky Product Info', 'farmart' ),
				'section'     => 'product_general',
				'default'     => 0,
				'priority'    => 40,
				'description' => esc_html__( 'Check this option to enable sticky product info on the product page.', 'farmart' ),
			),
			'product_add_to_cart_ajax' => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Add to cart with AJAX', 'farmart' ),
				'section'     => 'product_general',
				'default'     => 1,
				'description' => esc_html__( 'Check this option to enable add to cart with AJAX on the product page.', 'farmart' ),
				'priority' => 45,
			),

			// Product Gallery
			'product_images_zoom'       => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Image Zoom', 'farmart' ),
				'section'     => 'product_page_images',
				'default'     => 1,
				'description' => esc_html__( 'Check this option to show a bigger size product image on mouseover', 'farmart' ),
				'priority'    => 10,
			),
			'product_images_lightbox'   => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Images Gallery', 'farmart' ),
				'section'     => 'product_page_images',
				'default'     => 1,
				'description' => esc_html__( 'Check this option to open product gallery images in a lightbox', 'farmart' ),
				'priority'    => 10,
			),
			'product_thumbnail_layout'     => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Product Thumbnail Layout', 'farmart' ),
				'section'     => 'product_page_images',
				'default'     => 'vertical',
				'priority'    => 10,
				'choices'     => array(
					'vertical'   => esc_html__( 'Vertical', 'farmart' ),
					'horizontal' => esc_html__( 'Horizontal', 'farmart' ),
				),
				'description' => esc_html__( 'Select layout for product page.', 'farmart' ),
			),
			'product_thumbnail_numbers' => array(
				'type'     => 'number',
				'label'    => esc_html__( 'Thumbnail Numbers', 'farmart' ),
				'section'  => 'product_page_images',
				'default'  => 5,
				'priority' => 10,
			),

			// Product Socials
			'show_product_socials'      => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Show Product Socials', 'farmart' ),
				'section'  => 'product_page_socials',
				'default'  => 1,
				'priority' => 40,
			),
			'product_social_icons'      => array(
				'type'     => 'multicheck',
				'label'    => esc_html__( 'Socials', 'farmart' ),
				'section'  => 'product_page_socials',
				'default'  => array( 'twitter', 'facebook', 'google', 'pinterest', 'linkedin', 'vkontakte' ),
				'priority' => 40,
				'choices'  => array(
					'twitter'   => esc_html__( 'Twitter', 'farmart' ),
					'facebook'  => esc_html__( 'Facebook', 'farmart' ),
					'google'    => esc_html__( 'Google Plus', 'farmart' ),
					'pinterest' => esc_html__( 'Pinterest', 'farmart' ),
					'linkedin'  => esc_html__( 'Linkedin', 'farmart' ),
					'vkontakte' => esc_html__( 'Vkontakte', 'farmart' ),
					'whatsapp'  => esc_html__( 'Whatsapp', 'farmart' ),
					'email'     => esc_html__( 'Email', 'farmart' ),
				),
			),

			// Product Buy Now

			'product_buy_now'                    => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Buy Now Button', 'farmart' ),
				'section'     => 'product_page_buy_now',
				'default'     => 0,
				'description' => esc_html__( 'Show buy now in the single product.', 'farmart' ),
				'priority'    => 10,
			),
			'product_buy_now_text'               => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Buy Now Text', 'farmart' ),
				'description'     => esc_html__( 'Enter Buy not button text.', 'farmart' ),
				'section'         => 'product_page_buy_now',
				'default'         => esc_html__( 'Buy Now', 'farmart' ),
				'priority'        => 10,
			),
			'product_buy_now_link'               => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Buy Now Link', 'farmart' ),
				'section'         => 'product_page_buy_now',
				'default'         => '',
				'priority'        => 10,
			),
			'product_buy_now_br'           => array(
				'type'            => 'custom',
				'label'           => '<hr/>',
				'section'         => 'product_page_buy_now',
				'priority'        => 10,
			),
			'product_buy_now_color'             => array(
				'type'        => 'color',
				'label'       => esc_html__( 'Color', 'farmart' ),
				'description' => esc_html__( 'Buy Now button color.', 'farmart' ),
				'default'     => '',
				'section'     => 'product_page_buy_now',
				'priority'    => 10,
			),
			'product_buy_now_bg_color'  => array(
				'type'        => 'color',
				'label'       => esc_html__( 'Background Color', 'farmart' ),
				'description' => esc_html__( 'Buy Now button background color.', 'farmart' ),
				'default'     => '',
				'section'     => 'product_page_buy_now',
				'priority'    => 10,
			),

			// Frequently Bought Together
			'product_fbt'                        => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Show Frequently Bought Together', 'farmart' ),
				'section'  => 'product_page_fbt',
				'default'  => 1,
				'priority' => 40,
			),
			'product_fbt_title'                  => array(
				'type'     => 'text',
				'label'    => esc_html__( 'Title', 'farmart' ),
				'section'  => 'product_page_fbt',
				'default'  => esc_html__( 'Frequently Bought Together', 'farmart' ),
				'priority' => 40,
			),
			'product_fbt_columns'            => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Columns', 'farmart' ),
				'section'     => 'product_page_fbt',
				'default'     => '4',
				'priority'    => 40,
				'choices'     => array(
					'3' => esc_html__( '3 Columns', 'farmart' ),
					'4' => esc_html__( '4 Columns', 'farmart' ),
					'5' => esc_html__( '5 Columns', 'farmart' ),
					'6' => esc_html__( '6 Columns', 'farmart' ),
					'7' => esc_html__( '7 Columns', 'farmart' ),
				),
				'description' => esc_html__( 'Select default layout for product page.', 'farmart' ),
			),

			// Related Products
			'product_related'                    => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Show Related Products', 'farmart' ),
				'section'     => 'related_products',
				'description' => esc_html__( 'Check this option to show instagram photos in single product page', 'farmart' ),
				'default'     => 0,
				'priority'    => 40,
			),
			'product_related_title'              => array(
				'type'     => 'text',
				'label'    => esc_html__( 'Related Products Title', 'farmart' ),
				'section'  => 'related_products',
				'default'  => esc_html__( 'Related products', 'farmart' ),
				'priority' => 40,
			),
			'related_product_by_categories'      => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Related Products By Categories', 'farmart' ),
				'section'  => 'related_products',
				'default'  => 1,
				'priority' => 40,
			),
			'related_product_by_parent_category' => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Related Products By Parent Category', 'farmart' ),
				'section'         => 'related_products',
				'default'         => 0,
				'priority'        => 40,
				'active_callback' => array(
					array(
						'setting'  => 'related_product_by_categories',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'related_product_by_tags'            => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Related Products By Tags', 'farmart' ),
				'section'  => 'related_products',
				'default'  => 1,
				'priority' => 40,
			),
			'related_products_columns'           => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Related Products Columns', 'farmart' ),
				'section'     => 'related_products',
				'default'     => '5',
				'priority'    => 40,
				'description' => esc_html__( 'Specify how many columns of related products you want to show on single product page', 'farmart' ),
				'choices'     => array(
					'3' => esc_html__( '3 Columns', 'farmart' ),
					'4' => esc_html__( '4 Columns', 'farmart' ),
					'5' => esc_html__( '5 Columns', 'farmart' ),
					'6' => esc_html__( '6 Columns', 'farmart' ),
					'7' => esc_html__( '7 Columns', 'farmart' ),
				),
			),
			'related_products_numbers'           => array(
				'type'        => 'number',
				'label'       => esc_html__( 'Related Products Numbers', 'farmart' ),
				'section'     => 'related_products',
				'default'     => 6,
				'priority'    => 40,
				'description' => esc_html__( 'Specify how many numbers of related products you want to show on single product page', 'farmart' ),
			),
			// Products Instagram
			'product_instagram'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Instagram Photos', 'farmart' ),
				'section'     => 'instagram_photos',
				'default'     => 0,
				'priority'    => 40,
				'description' => esc_html__( 'Check this option to show instagram photos in single product page', 'farmart' ),
			),
			'instagram_token'              => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Access Token', 'farmart' ),
				'section'         => 'instagram_photos',
				'default'         => '',
				'priority'        => 40,
				'description'     => esc_html__( 'Enter your Access Token', 'farmart' ),
			),
			'product_instagram_title'      => array(
				'type'     => 'textarea',
				'label'    => esc_html__( 'Product Instagram Title', 'farmart' ),
				'section'  => 'instagram_photos',
				'default'  => esc_html__( 'See It Styled On Instagram', 'farmart' ),
				'priority' => 40,
			),
			'product_instagram_columns'    => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Instagram Photos Columns', 'farmart' ),
				'section'     => 'instagram_photos',
				'default'     => '5',
				'priority'    => 40,
				'description' => esc_html__( 'Specify how many columns of Instagram Photos you want to show on single product page', 'farmart' ),
				'choices'     => array(
					'3' => esc_html__( '3 Columns', 'farmart' ),
					'4' => esc_html__( '4 Columns', 'farmart' ),
					'5' => esc_html__( '5 Columns', 'farmart' ),
					'6' => esc_html__( '6 Columns', 'farmart' ),
					'7' => esc_html__( '7 Columns', 'farmart' ),
				),
			),
			'product_instagram_numbers'    => array(
				'type'        => 'number',
				'label'       => esc_html__( 'Instagram Photos Numbers', 'farmart' ),
				'section'     => 'instagram_photos',
				'default'     => 10,
				'priority'    => 40,
				'description' => esc_html__( 'Specify how many Instagram Photos you want to show on single product page.', 'farmart' ),
			),

			// Product Upsell
			'product_upsells'                    => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Show Up-sells Products', 'farmart' ),
				'section'     => 'upsells_products',
				'default'     => 1,
				'description' => esc_html__( 'Check this option to show instagram photos in single product page', 'farmart' ),
				'priority'    => 40,
			),
			'products_upsells_position'          => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Up-sells Products Position', 'farmart' ),
				'section'         => 'upsells_products',
				'default'         => '1',
				'priority'        => 40,
				'choices'         => array(
					'1' => esc_html__( 'Above Product Tabs', 'farmart' ),
					'2' => esc_html__( 'Under Product Tabs', 'farmart' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'product_page_layout',
						'operator' => '==',
						'value'    => '1',
					),
				),
			),
			'product_upsells_title'              => array(
				'type'     => 'text',
				'label'    => esc_html__( 'Up-sells Products Title', 'farmart' ),
				'section'  => 'upsells_products',
				'default'  => esc_html__( 'You may also like', 'farmart' ),
				'priority' => 40,
			),
			'upsells_products_columns'           => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Up-sells Products Columns', 'farmart' ),
				'section'     => 'upsells_products',
				'default'     => '5',
				'priority'    => 40,
				'description' => esc_html__( 'Specify how many columns of up-sells products you want to show on single product page', 'farmart' ),
				'choices'     => array(
					'3' => esc_html__( '3 Columns', 'farmart' ),
					'4' => esc_html__( '4 Columns', 'farmart' ),
					'5' => esc_html__( '5 Columns', 'farmart' ),
					'6' => esc_html__( '6 Columns', 'farmart' ),
					'7' => esc_html__( '7 Columns', 'farmart' ),
				),
			),
			'upsells_products_numbers'           => array(
				'type'        => 'number',
				'label'       => esc_html__( 'Up-sells Products Numbers', 'farmart' ),
				'section'     => 'upsells_products',
				'default'     => 6,
				'priority'    => 40,
				'description' => esc_html__( 'Specify how many numbers of up-sells products you want to show on single product page', 'farmart' ),
			),
		)
	);

	return $fields;
}

add_filter( 'farmart_customize_fields', 'farmart_woocommerce_customize_fields' );