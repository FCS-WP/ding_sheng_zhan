<?php
/**
 * Header Cart Mobile
 */
if ( ! function_exists( 'WC' ) ) {
	return;
}

if ( ! function_exists( 'woocommerce_mini_cart' ) ) {
	return '';
}

$cart_count = WC()->cart->cart_contents_count;

?>
<div class="header-element header-element--cart">
	<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ) ?>" data-toggle="modal" data-target="cart-panel">
		<span class="cart-content">
			<span class="cart-icon">
				<?php if ( farmart_get_option('header_cart_counter') ): ?>
					<span class="mini-item-counter fm-mini-cart-counter"><?php echo intval( $cart_count ) ?></span>
				<?php endif; ?>
				<?php echo Farmart\Icon::get_svg('cart', '', 'shop'); ?>
			</span>
		</span>
	</a>
</div>
