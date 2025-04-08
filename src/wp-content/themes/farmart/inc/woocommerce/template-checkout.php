<?php
/**
 * Hooks of checkout.
 *
 * @package Farmart
 */

/**
 * Class of checkout template.
 */
class Farmart_WooCommerce_Template_Checkout {
	/**
	 * Initialize.
	 */
	public static function init() {
		add_action( 'woocommerce_checkout_order_review', array( __CLASS__, 'open_review_order_table' ), 8 );
		add_action( 'woocommerce_checkout_order_review', array( __CLASS__, 'close_review_order_table' ), 12 );
	}

	public static function open_review_order_table() {
		echo '<div class="fm-review-order-table">';
	}

	public static function close_review_order_table() {
		echo '</div>';
	}
}