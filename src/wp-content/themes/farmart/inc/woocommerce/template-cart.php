<?php
/**
 * Hooks of cart.
 *
 * @package Farmart
 */

/**
 * Class of cart template.
 */
class Farmart_WooCommerce_Template_Cart {
	/**
	 * Initialize.
	 */
	public static function init() {
		// Empty cart.
		add_action( 'template_redirect', array( __CLASS__, 'empty_cart_action' ) );

	}

	/**
	 * Empty cart.
	 */
	public static function empty_cart_action() {
		if ( ! intval( farmart_get_option( 'clear_cart_button' ) ) ) {
			return;
		}

		if ( ! empty( $_POST['empty_cart'] ) && wp_verify_nonce( wc_get_var( $_REQUEST['woocommerce-cart-nonce'] ), 'woocommerce-cart' ) ) {
			WC()->cart->empty_cart();
			wc_add_notice( esc_html__( 'Cart is cleared.', 'farmart' ) );

			$referer = wp_get_referer() ? remove_query_arg( array(
				'remove_item',
				'add-to-cart',
				'added-to-cart',
			), add_query_arg( 'cart_emptied', '1', wp_get_referer() ) ) : wc_get_cart_url();
			wp_safe_redirect( $referer );
			exit;
		}
	}
}