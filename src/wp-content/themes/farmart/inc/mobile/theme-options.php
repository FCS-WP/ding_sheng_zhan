<?php
/**
 * Theme options of Mobile.
 *
 * @package Famart
 */

/**
 * Adds theme options panels of Mobile.
 *
 * @param array $sections Theme options sections.
 *
 * @return array
 */
function farmart_mobile_customize_panels( $panels ) {
	$panels = array_merge(
		$panels, array(
			'mobile' => array(
				'title'    => esc_html__( 'Mobile', 'farmart' ),
				'priority' => 200,
			),
		)
	);

	return $panels;
}

/**
 * Adds theme options sections of Mobile.
 *
 * @param array $sections Theme options sections.
 *
 * @return array
 */
function farmart_mobile_customize_sections( $sections ) {
	$sections = array_merge(
		$sections, array(
			'general_mobile'         => array(
				'title'       => esc_html__( 'General', 'farmart' ),
				'description' => '',
				'priority'    => 20,
				'capability'  => 'edit_theme_options',
				'panel'       => 'mobile',
			),
			'homepage_mobile'        => array(
				'title'       => esc_html__( 'Homepage Settings', 'farmart' ),
				'description' => '',
				'priority'    => 20,
				'capability'  => 'edit_theme_options',
				'panel'       => 'mobile',
			),
			'inner_page_mobile'          => array(
				'title'       => esc_html__( 'Inner Page Settings', 'farmart' ),
				'description' => '',
				'priority'    => 20,
				'capability'  => 'edit_theme_options',
				'panel'       => 'mobile',
			),
			'navigation_mobile'          => array(
				'title'       => esc_html__( 'Navigation', 'farmart' ),
				'description' => '',
				'priority'    => 20,
				'capability'  => 'edit_theme_options',
				'panel'       => 'mobile',
			),
			'catalog_mobile'          => array(
				'title'       => esc_html__( 'Catalog Page', 'farmart' ),
				'description' => '',
				'priority'    => 20,
				'capability'  => 'edit_theme_options',
				'panel'       => 'mobile',
			),
			'single_product_mobile'          => array(
				'title'       => esc_html__( 'Product Page', 'farmart' ),
				'description' => '',
				'priority'    => 20,
				'capability'  => 'edit_theme_options',
				'panel'       => 'mobile',
			),
		)
	);

	return $sections;
}

add_filter( 'farmart_customize_sections', 'farmart_mobile_customize_sections' );

/**
 * Adds theme options of Mobile.
 *
 * @param array $settings Theme options.
 *
 * @return array
 */
function farmart_mobile_customize_fields( $fields ) {
	$fields = array_merge(
		$fields, array(
			'enable_mobile_version'             => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Mobile Version', 'farmart' ),
				'section'  => 'general_mobile',
				'default'  => 0,
				'priority' => 10,
			),

			'homepage_mobile'                   => array(
				'type'     => 'select',
				'label'    => esc_html__( 'Homepage', 'farmart' ),
				'section'  => 'homepage_mobile',
				'default'  => '',
				'priority' => 10,
				'choices'  => class_exists( 'Kirki_Helper' ) && is_admin() ? Kirki_Helper::get_posts( array(
					'posts_per_page' => -1,
					'post_type'      => 'page',
				) ) : '',
			),

			// Catalog Page
			'mobile_catalog_toolbar_elements'             => array(
				'type'    => 'multicheck',
				'label'   => esc_html__( 'Catalog Toolbar Elements', 'farmart' ),
				'default' => array( 'sort_by', 'view' ),
				'choices' => array(
					'sort_by'       => esc_attr__( 'Sort by', 'farmart' ),
					'view'          => esc_attr__( 'View', 'farmart' ),
				),
				'section' => 'catalog_mobile',
			),
			'catalog_custom_1'        => array(
				'type'     => 'custom',
				'section'  => 'catalog_mobile',
				'default'  => '<hr>',
				'priority' => 40,
			),
			'catalog_toolbar_els_filter_mobile'          => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Sidebar Title', 'farmart' ),
				'default'         => '',
				'section'         => 'catalog_mobile',
				'priority'        => 40,
			),
			'catalog_custom_2'        => array(
				'type'     => 'custom',
				'section'  => 'catalog_mobile',
				'default'  => '<hr>',
				'priority' => 40,
			),
			'catalog_nav_type_mobile'           => array(
				'type'     => 'radio',
				'section'  => 'catalog_mobile',
				'label'    => esc_html__( 'Navigation Type', 'farmart' ),
				'default'  => 'infinite',
				'priority' => 40,
				'choices'  => array(
					'numeric'  => esc_attr__( 'Numeric', 'farmart' ),
					'loadmore' => esc_attr__( 'Load More', 'farmart' ),
					'infinite' => esc_attr__( 'Infinite Scroll', 'farmart' ),
				),
			),

			// Single Product
			'product_add_to_cart_fixed_mobile'  => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Add to cart fixed', 'farmart' ),
				'section'     => 'single_product_mobile',
				'default'     => 0,
				'priority'    => 10,
				'description' => esc_html__( 'Check this option to enable add to cart button fixed on mobile.', 'farmart' ),
			),
			'product_layout_custom_1'        => array(
				'type'     => 'custom',
				'section'  => 'single_product_mobile',
				'default'  => '<hr>',
				'priority' => 10,
			),
			'sticky_product_info_mobile'        => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Sticky Product Info', 'farmart' ),
				'section'     => 'single_product_mobile',
				'default'     => 0,
				'priority'    => 10,
				'description' => esc_html__( 'Check this option to enable sticky product info on the product page.', 'farmart' ),
			),
			'sticky_product_info_offset_mobile'     => array(
				'type'        => 'number',
				'label'       => esc_html__( 'Sticky Product Info Offset', 'farmart' ),
				'section'     => 'single_product_mobile',
				'default'     => 0,
				'priority'    => 10,
			),
			'product_layout_custom_2'        => array(
				'type'     => 'custom',
				'section'  => 'single_product_mobile',
				'default'  => '<hr>',
				'priority' => 10,
			),
			'product_sidebar_enable'              => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Product Sidebar', 'farmart' ),
				'section'     => 'single_product_mobile',
				'default'     => 0,
				'priority'    => 10,
				'description' => esc_html__( 'Check this option to show the product sidebar on product page.', 'farmart' ),
			),
			'product_layout_custom_3'        => array(
				'type'     => 'custom',
				'section'  => 'single_product_mobile',
				'default'  => '<hr>',
				'priority' => 10,
			),
			'product_collapse_tab'              => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Product Tabs Collapse', 'farmart' ),
				'section'     => 'single_product_mobile',
				'default'     => 0,
				'priority'    => 10,
				'description' => esc_html__( 'Check this option to show the product tabs collapse on product page.', 'farmart' ),
			),
			'product_collapse_tab_status'       => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Collapse Status', 'farmart' ),
				'section'         => 'single_product_mobile',
				'default'         => 'close',
				'priority'        => 10,
				'choices'         => array(
					'close' => esc_html__( 'Close', 'farmart' ),
					'open'  => esc_html__( 'Open', 'farmart' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'product_collapse_tab',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
		)
	);

	return $fields;
}

add_filter( 'farmart_customize_fields', 'farmart_mobile_customize_fields' );