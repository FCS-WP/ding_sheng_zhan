<?php
/**
 * Vendors Compatibility File
 *
 * @package Farmart
 */

/**
 * Vendors setup function.
 *
 * @return void
 */
function farmart_vendors_setup() {
	if ( class_exists( 'WeDevs_Dokan' ) ) {
		global $farmart_dokan;
		$farmart_dokan = new Farmart_Dokan;
	}

	if ( class_exists( 'WCFMmp' ) ) {
		global $farmart_wcfmvendors;
		$farmart_wcfmvendors = new Farmart_WCFMVendors;
	}
}

add_action( 'after_setup_theme', 'farmart_vendors_setup' );

require get_theme_file_path( '/inc/woocommerce/vendors/theme-options.php' );

if ( class_exists( 'WeDevs_Dokan' ) ) {
	require get_theme_file_path( '/inc/woocommerce/vendors/dokan.php' );
}

if ( class_exists( 'WCFMmp' ) ) {
	require get_theme_file_path( '/inc/woocommerce/vendors/wcfm_vendors.php' );
}