<?php
/**
 * The template for displaying product widget entries
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( ! is_a( $product, 'WC_Product' ) ) {
	return;
}
$unit_text =  get_post_meta( $product->get_id(), 'custom_unit_price', true );
$get_image = $product->get_image( 'shop_catalog' );
$get_name = $product->get_name();
$price_html = $product->get_price_html();

?>
<li class="product">
	<?php do_action( 'woocommerce_widget_product_item_start', $args ); ?>
	<a class="product-thumbnail" href="<?php echo esc_url( $product->get_permalink() ); ?>">
		<?php echo ! empty( $get_image ) ? $get_image : ''; ?>

	</a>
	<div class="product-details">
		<h3 class="woocommerce-loop-product__title">
			<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
				<?php echo ! empty( $get_name ) ? $get_name : ''; ?>
			</a>
		</h3>
		<?php if ( $unit_text ) : ?>
			<span class="unit-text"><?php echo ! empty($unit_text) ? $unit_text : '' ;?> </span>
		<?php endif; ?>
		<?php echo wc_get_rating_html( $product->get_average_rating() ); ?>
		<span class="price">
			<?php echo ! empty( $price_html ) ? $price_html : ''; ?>
		</span>
	</div>


	<?php do_action( 'woocommerce_widget_product_item_end', $args ); ?>
</li>
