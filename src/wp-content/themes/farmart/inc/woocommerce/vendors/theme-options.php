<?php
/**
 * Theme options of Vendors.
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
function farmart_vendors_customize_panels( $panels ) {
	$panels['vendors'] = array(
		'priority' => 200,
		'title'    => esc_html__( 'Vendors', 'farmart' ),
	);

	return $panels;
}

add_filter( 'farmart_customize_panels', 'farmart_vendors_customize_panels' );

/**
 * Adds theme options sections of Farmart.
 *
 * @param array $sections Theme options sections.
 *
 * @return array
 */
function farmart_vendors_customize_sections( $sections ) {
	$sections = array_merge(
		$sections, array(
			'vendor_catalog_page' => array(
				'title'       => esc_html__( 'Catalog Page', 'farmart' ),
				'description' => '',
				'priority'    => 45,
				'panel'       => 'vendors',
				'capability'  => 'edit_theme_options',
			),

			'vendor_single_product' => array(
				'title'       => esc_html__( 'Single Product', 'farmart' ),
				'description' => '',
				'priority'    => 45,
				'panel'       => 'vendors',
				'capability'  => 'edit_theme_options',
			),

			'vendor_page' => array(
				'title'       => esc_html__( 'Vendor Page', 'farmart' ),
				'description' => '',
				'priority'    => 45,
				'panel'       => 'vendors',
				'capability'  => 'edit_theme_options',
			),
		)
	);

	return $sections;
}

add_filter( 'farmart_customize_sections', 'farmart_vendors_customize_sections' );

/**
 * Adds theme options of vendors.
 *
 * @param array $settings Theme options.
 *
 * @return array
 */
function farmart_vendors_customize_settings( $fields ) {

	if ( ! class_exists( 'WeDevs_Dokan' ) && ! class_exists( 'WCFMmp' )) {
		return $fields;
	}

	$fields = array_merge(
		$fields, array(
			// Catalog Vendor
			'catalog_sold_by' => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Vendor Sold By', 'farmart' ),
				'section'     => 'vendor_catalog_page',
				'default'     => 1,
				'priority'    => 10,
				'description' => esc_html__( 'Check this option to show sold by vendor.', 'farmart' ),
			),

			// Single Vendor
			'single_product_sold_by' => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Vendor Sold By', 'farmart' ),
				'section'     => 'vendor_single_product',
				'default'     => 1,
				'priority'    => 10,
				'description' => esc_html__( 'Check this option to show sold by vendor.', 'farmart' ),
			),

			// Vendor Page
			'catalog_vendor_full_width'  => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Full Width', 'farmart' ),
				'section'  => 'vendor_page',
				'default'  => 0,
				'priority' => 10,
			),
			'page_header_vendor_els' => array(
				'type'     => 'multicheck',
				'label'    => esc_html__( 'Page Header Element', 'farmart' ),
				'section'  => 'vendor_page',
				'default'  => array( 'breadcrumb' ),
				'priority' => 10,
				'choices'  => array(
					'breadcrumb' => esc_html__( 'Breadcrumb', 'farmart' ),
				),
			),
			'catalog_vendor_toolbar_els' => array(
				'type'        => 'multicheck',
				'label'       => esc_html__( 'ToolBar Elements', 'farmart' ),
				'section'     => 'vendor_page',
				'default'     => array( 'total_product', 'view' ),
				'priority'    => 10,
				'choices'     => array(
					'total_product' => esc_html__( 'Products Found', 'farmart' ),
					'view'  => esc_html__( 'View', 'farmart' ),
				),
				'description' => esc_html__( 'Select which elements you want to show.', 'farmart' ),
			),
			'catalog_vendor_view'        => array(
				'type'     => 'select',
				'label'    => esc_html__( 'View', 'farmart' ),
				'section'  => 'vendor_page',
				'default'  => 'grid',
				'priority' => 10,
				'choices'  => array(
					'grid' => esc_html__( 'Grid', 'farmart' ),
					'list' => esc_html__( 'List', 'farmart' ),
				),
			),
			'catalog_vendor_columns'    => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Product Columns', 'farmart' ),
				'section'     => 'vendor_page',
				'default'     => '4',
				'priority'    => 10,
				'choices'     => array(
					'4' => esc_html__( '4 Columns', 'farmart' ),
					'6' => esc_html__( '6 Columns', 'farmart' ),
					'5' => esc_html__( '5 Columns', 'farmart' ),
					'3' => esc_html__( '3 Columns', 'farmart' ),
				),
				'description' => esc_html__( 'Specify how many product columns you want to show.', 'farmart' ),
			),
			'catalog_vendor_sidebar_title'         => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Sidebar Title', 'farmart' ),
				'default'         => esc_html__( 'Filter Products', 'farmart' ),
				'section'         => 'vendor_page',
				'priority'        => 10,
			),
		)
	);

	if ( class_exists( 'WCFMmp' ) ) {
		$fields = array_merge(
			$fields, array(
				'wcfm_vendor_store_header'        => array(
					'type'     => 'select',
					'label'    => esc_html__( 'Store Header Template', 'farmart' ),
					'section'  => 'vendor_page',
					'default'  => 'themes',
					'priority' => 10,
					'choices'  => array(
						'plugin' => esc_html__( 'Plugin', 'farmart' ),
						'themes' => esc_html__( 'Themes', 'farmart' ),
					),
				),
			)
		);
	}

	return $fields;
}

add_filter( 'farmart_customize_fields', 'farmart_vendors_customize_settings', 30 );