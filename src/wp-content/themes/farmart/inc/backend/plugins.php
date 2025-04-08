<?php
/**
 * Register required, recommended plugins for theme
 *
 * @package Farmart
 */

/**
 * Register required plugins
 *
 * @since  1.0
 */
function farmart_register_required_plugins() {
	$plugins = array(
		array(
			'name'               => esc_html__( 'Meta Box', 'farmart' ),
			'slug'               => 'meta-box',
			'required'           => true,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => esc_html__( 'Kirki', 'farmart' ),
			'slug'               => 'kirki',
			'required'           => true,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => esc_html__( 'WooCommerce', 'farmart' ),
			'slug'               => 'woocommerce',
			'required'           => true,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => esc_html__( 'Elementor Page Builder', 'farmart' ),
			'slug'               => 'elementor',
			'required'           => true,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => esc_html__( 'Farmart Addons', 'farmart' ),
			'slug'               => 'farmart-addons',
			'source'             => esc_url( 'https://github.com/drfuri/plugins/raw/main/farmart-addons.zip' ),
			'required'           => true,
			'force_activation'   => false,
			'force_deactivation' => false,
			'version'            => '1.3.0',
		),
		array(
			'name'               => esc_html__( 'Contact Form 7', 'farmart' ),
			'slug'               => 'contact-form-7',
			'required'           => false,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => esc_html__( 'MailChimp for WordPress', 'farmart' ),
			'slug'               => 'mailchimp-for-wp',
			'required'           => false,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => esc_html__( 'WCBoost - Wishlist', 'farmart' ),
			'slug'               => 'wcboost-wishlist',
			'required'           => false,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => esc_html__( 'WCBoost - Products Compare', 'farmart' ),
			'slug'               => 'wcboost-products-compare',
			'required'           => false,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => esc_html__( 'WooCommerce Deals', 'farmart' ),
			'slug'               => 'woocommerce-deals',
			'source'             => esc_url( 'https://github.com/drfuri/plugins/raw/main/woocommerce-deals.zip' ),
			'required'           => false,
			'force_activation'   => false,
			'force_deactivation' => false,
			'version'            => '1.0.9',
		),
	);

	if( ! defined( 'TAWC_VS_PRO' ) ) {
		$plugins[] = array(
			'name'               => esc_html__( 'WCBoost - Variation Swatches', 'farmart' ),
			'slug'               => 'wcboost-variation-swatches',
			'required'           => false,
			'force_activation'   => false,
			'force_deactivation' => false,
		);
	} else {
		$plugins[] = array(
			'name'               => esc_html__( 'Variation Swatches for WooCommerce Pro', 'farmart' ),
			'slug'               => 'variation-swatches-for-woocommerce-pro',
			'source'             => esc_url( 'https://github.com/drfuri/plugins/raw/main/variation-swatches-for-woocommerce-pro.zip' ),
			'required'           => false,
			'force_activation'   => false,
			'force_deactivation' => false,
			'version'            => '1.0.7',
		);
	}

	$config  = array(
		'domain'       => 'farmart',
		'default_path' => '',
		'menu'         => 'install-required-plugins',
		'has_notices'  => true,
		'is_automatic' => false,
		'message'      => '',
		'strings'      => array(
			'page_title'                      => esc_html__( 'Install Required Plugins', 'farmart' ),
			'menu_title'                      => esc_html__( 'Install Plugins', 'farmart' ),
			'installing'                      => esc_html__( 'Installing Plugin: %s', 'farmart' ),
			'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'farmart' ),
			'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'farmart' ),
			'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'farmart' ),
			'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'farmart' ),
			'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'farmart' ),
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'farmart' ),
			'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'farmart' ),
			'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'farmart' ),
			'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'farmart' ),
			'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'farmart' ),
			'activate_link'                   => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'farmart' ),
			'return'                          => esc_html__( 'Return to Required Plugins Installer', 'farmart' ),
			'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'farmart' ),
			'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'farmart' ),
			'nag_type'                        => 'updated',
		),
	);

	tgmpa( $plugins, $config );
}

add_action( 'tgmpa_register', 'farmart_register_required_plugins' );
