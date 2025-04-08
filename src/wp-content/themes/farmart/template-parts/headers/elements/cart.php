<?php
/**
 * Header Cart Template
 */
if ( ! function_exists( 'WC' ) ) {
	return;
}

if ( ! function_exists( 'woocommerce_mini_cart' ) ) {
	return '';
}

ob_start();
woocommerce_mini_cart();
$mini_cart    = ob_get_clean();
$mini_content = sprintf( '<div class="mini-cart-content"><div class="widget_shopping_cart_content">%s</div></div>', $mini_cart );

$cart_count = WC()->cart->cart_contents_count;
$cart_price = WC()->cart->get_cart_subtotal();

?>
<div class="header-element header-element--cart">
	<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ) ?>" data-toggle="<?php echo 'panel' === farmart_get_option('header_cart_behaviour') ? 'modal' : 'link'; ?>" data-target="cart-panel">
		<span class="cart-content">
			<span class="cart-icon">
				<?php if ( farmart_get_option('header_cart_counter') ): ?>
					<span class="mini-item-counter fm-mini-cart-counter"><?php echo intval( $cart_count ) ?></span>
				<?php endif; ?>
				<?php echo Farmart\Icon::get_svg('cart', '', 'shop'); ?>
			</span>
			<?php if ( farmart_get_option('header_cart_total') ): ?>
				<span class="cart-text">
					<span class="title"><?php echo esc_html__( 'Your Cart', 'farmart' ); ?></span>
					<span class="cart-price-total">
						<?php echo WC()->cart->get_cart_total(); ?>
					</span>
				</span>
			<?php endif; ?>
		</span>
	</a>
	<?php if ( farmart_get_option('header_cart_behaviour') === 'page' ): ?>
		<span class="dropdown"></span>
		<?php echo ! empty( $mini_content ) ? $mini_content : '' ?>
	<?php endif; ?>
</div>
