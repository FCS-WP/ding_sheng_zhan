<?php

namespace FarmartAddons;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Elementor_Controls {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->init();
	}

	public function init() {

		// Include plugin files
		$this->includes();

		// Register controls
		add_action( 'elementor/controls/controls_registered', [ $this, 'register_controls' ] );


	}

	public function includes() {
		require_once( FARMART_ADDONS_DIR . 'inc/elementor/controls/ajaxloader.php' );
		require_once( FARMART_ADDONS_DIR . 'inc/elementor/controls/fmautocomplete.php' );
	}

	public function register_controls() {
		$controls_manager = \Elementor\Plugin::$instance->controls_manager;
		$controls_manager->register_control( 'fmautocomplete', new FMautocomplete() );

	}
}

new Elementor_Controls();