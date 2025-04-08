<?php
/**
 * Farmart Addons Modules functions and definitions.
 *
 * @package Farmart
 */

namespace Farmart\Addons\Modules\Product_Tabs;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Addons Modules
 */
class Module {

	/**
	 * Instance
	 *
	 * @var $instance
	 */
	private static $instance;


	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		$this->includes();
		add_action('init', array( $this, 'actions'));
		add_action('current_screen', array( $this, 'product_meta'));
		add_action('template_redirect', array( $this, 'product_single'));
	}

	/**
	 * Includes files
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function includes() {
		\Farmart\Addons\Auto_Loader::register( [
			'Farmart\Addons\Modules\Product_Tabs\FrontEnd'     => FARMART_ADDONS_DIR . 'inc/modules/product-tabs/frontend.php',
			'Farmart\Addons\Modules\Product_Tabs\Settings'     => FARMART_ADDONS_DIR . 'inc/modules/product-tabs/settings.php',
			'Farmart\Addons\Modules\Product_Tabs\Product_Meta' => FARMART_ADDONS_DIR . 'inc/modules/product-tabs/product-meta.php',
			'Farmart\Addons\Modules\Product_Tabs\Post_Type'    => FARMART_ADDONS_DIR . 'inc/modules/product-tabs/post-type.php',
		] );
	}

	/**
	 * Single Product
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function product_single() {
		if ( get_option( 'farmart_product_tab' ) == 'yes' && is_singular('product') ) {
			\Farmart\Addons\Modules\Product_Tabs\FrontEnd::instance();
		}
	}

	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function actions() {
		if ( get_option( 'farmart_product_tab' ) == 'yes' ) {
			\Farmart\Addons\Modules\Product_Tabs\Post_Type::instance();
		}

		if( is_admin() ) {
			\Farmart\Addons\Modules\Product_Tabs\Settings::instance();
		}
	}


	/**
	 * Product Meta
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function product_meta() {
		if ( ! is_admin() ) {
			return;
		}

		if ( get_option( 'farmart_product_tab' ) != 'yes' ) {
			return;
		}

		$screen = get_current_screen();
		if($screen->post_type == 'product') {
			\Farmart\Addons\Modules\Product_Tabs\Product_Meta::instance();
		}
	}

}
