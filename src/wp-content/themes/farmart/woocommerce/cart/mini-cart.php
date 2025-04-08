<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_mini_cart' ); ?>

<?php if ( ! WC()->cart->is_empty() ) : ?>

    <ul class="woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr( $args['list_class'] ); ?>">
		<?php
		do_action( 'woocommerce_before_mini_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				/**
				 * This filter is documented in woocommerce/templates/cart/cart.php.
				 *
				 * @since 2.1.0
				 */
				$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
				$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
				$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
                <li class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">

                    <div class="product-image">
						<?php if ( empty( $product_permalink ) ) : echo ! empty( $thumbnail ) ? $thumbnail : '';
						else: ?><a href="<?php echo esc_url( $product_permalink ); ?>"><?php echo ! empty( $thumbnail ) ? $thumbnail : '' ?> </a>
						<?php endif; ?>
                    </div>
                    <div class="product-content">
                        <div class="product-name">
							<?php if ( ! $_product->is_visible() ) : ?>
								<?php echo ! empty( $product_name ) ? $product_name : ''; ?>
							<?php else : ?>
                                <a href="<?php echo esc_url( $product_permalink ); ?>">
									<?php echo ! empty( $product_name ) ? $product_name : ''; ?>
                                </a>
							<?php endif; ?>
                        </div>

						<?php
							if ( function_exists( 'dokan_get_store_url' ) ) :
							$author_id = get_post_field( 'post_author', $product_id );
							$author    = get_user_by( 'id', $author_id );
							if ( empty( $author ) ) {
								return;
							}

							$shop_info = get_user_meta( $author_id, 'dokan_profile_settings', true );
							$shop_name = $author->display_name;
							if ( $shop_info && isset( $shop_info['store_name'] ) && $shop_info['store_name'] ) {
								$shop_name = $shop_info['store_name'];
							}
							?>
							<dl class="variation">
								<div class="variation-group">
									<dt class="variation-Vendor"><?php echo esc_html__( 'Vendor:', 'farmart' ); ?></dt>
									<dd class="variation-Vendor">
										<p><a href="<?php echo esc_url( dokan_get_store_url( $author_id ) ); ?>"><?php echo esc_html( $shop_name ); ?></a></p>
									</dd>
								</div>
							</dl>
							<?php endif; ?>
						<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s ( x%s)', $product_price, $cart_item['quantity'] ) . '</span>', $cart_item, $cart_item_key ); ?>
					</div>

					<?php
					echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
						'<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">%s</a>',
						esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
						esc_html__( 'Remove this item', 'farmart' ),
						esc_attr( $product_id ),
						esc_attr( $cart_item_key ),
						esc_attr( $_product->get_sku() ),
						Farmart\Icon::get_svg( 'trash', '', 'shop' )
					), $cart_item_key );
					?>
                </li>

				<?php
			}
		}

		do_action( 'woocommerce_mini_cart_contents' );
		?>
    </ul>

    <div class="control-button">
		<p class="woocommerce-mini-cart__total total">
			<?php
			/**
			 * Hook: woocommerce_widget_shopping_cart_total.
			 *
			 * @hooked woocommerce_widget_shopping_cart_subtotal - 10
			 */
			do_action( 'woocommerce_widget_shopping_cart_total' );
			?>
		</p>

		<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

        <p class="woocommerce-mini-cart__buttons buttons"><?php do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?></p>

		<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>

    </div>
<?php else : ?>

    <p class="woocommerce-mini-cart__empty-message"><?php esc_html_e( 'No products in the cart.', 'farmart' ); ?></p>

<?php endif; ?>


<?php do_action( 'woocommerce_after_mini_cart' ); ?>
