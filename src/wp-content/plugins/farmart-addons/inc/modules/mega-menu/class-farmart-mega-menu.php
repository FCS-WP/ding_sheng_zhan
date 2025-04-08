<?php

namespace Farmart\Addons\Modules;

class Mega_Menu {
	/**
	 * Instance
	 *
	 * @var $instance
	 */
	protected static $instance = null;

	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
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
		$this->load();
	}

	/**
	 * Load files
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function load() {
		require_once FARMART_ADDONS_DIR . 'inc/modules/mega-menu/class-farmart-mega-menu-walker.php';
		require_once FARMART_ADDONS_DIR . 'inc/modules/mega-menu/class-farmart-mega-menu-socials-walker.php';
	}
}