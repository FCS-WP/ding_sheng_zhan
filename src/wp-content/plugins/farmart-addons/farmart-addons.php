<?php
/**
 * Plugin Name: Farmart Addons
 * Plugin URI: http://drfuri.com/plugins/farmart-addons.zip
 * Description: Extra elements for Elementor. It was built for Farmart theme.
 * Version: 1.3.0
 * Author: Drfuri
 * Author URI: http://drfuri.com/
 * License: GPL2+
 * Text Domain: farmart-addons
 * Domain Path: lang/
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if ( ! defined( 'FARMART_ADDONS_DIR' ) ) {
	define( 'FARMART_ADDONS_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'FARMART_ADDONS_URL' ) ) {
	define( 'FARMART_ADDONS_URL', plugin_dir_url( __FILE__ ) );
}

require_once FARMART_ADDONS_DIR . 'farmart-autoloader.php';
require_once FARMART_ADDONS_DIR . '/inc/backend/brand-tax.php';
require_once FARMART_ADDONS_DIR . '/inc/backend/collection-tax.php';
require_once FARMART_ADDONS_DIR . 'inc/modules/mega-menu/class-farmart-mega-menu.php';
require_once FARMART_ADDONS_DIR . 'inc/modules/product-tabs/module.php';
require_once FARMART_ADDONS_DIR . '/inc/widgets/widget.php';
require_once FARMART_ADDONS_DIR . '/inc/frontend/socials.php';

if ( is_admin() ) {
	require_once FARMART_ADDONS_DIR . '/inc/backend/importer.php';
	require_once FARMART_ADDONS_DIR . 'inc/modules/mega-menu/class-farmart-mega-menu-settings.php';
}

/**
 * Init
 */
function farmart_vc_addons_init() {
	new Farmart_Product_Brands;
	new Farmart_Product_Collection;

	spl_autoload_register( '\Farmart\Addons\Auto_Loader::load' );
	\Farmart\Addons\Modules\Product_Tabs\Module::instance();

	if ( get_option( 'farmart_mega_menu' ) != '1' && is_admin() ) {
		return \Farmart\Addons\Modules\Mega_Menu\Settings::instance();
	}
	if ( get_option( 'farmart_mega_menu' ) != '1' ) {
		return \Farmart\Addons\Modules\Mega_Menu::instance();
	}
}

add_action( 'after_setup_theme', 'farmart_vc_addons_init', 20 );

/**
 * Undocumented function
 */
function farmart_init_elementor() {
	// Check if Elementor installed and activated
	if ( ! did_action( 'elementor/loaded' ) ) {
		return;
	}

	// Check for required Elementor version
	if ( ! version_compare( ELEMENTOR_VERSION, '2.0.0', '>=' ) ) {
		return;
	}

	// Check for required PHP version
	if ( version_compare( PHP_VERSION, '5.4', '<' ) ) {
		return;
	}

	// Once we get here, We have passed all validation checks so we can safely include our plugin
	include_once( FARMART_ADDONS_DIR . 'inc/elementor/elementor.php' );
	include_once( FARMART_ADDONS_DIR . 'inc/elementor/elementor-ajaxloader.php' );
	include_once( FARMART_ADDONS_DIR . 'inc/elementor/controls.php' );
}

add_action( 'plugins_loaded', 'farmart_init_elementor' );
