<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

do_action( 'farmart_before_quickview_product' );

$add_classes = '';

if ( intval( farmart_get_option( 'product_buy_now' ) ) && $product->get_type() != 'external' ) {
	$add_classes = 'enable-buy-now';
}

?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( $classes, $product ); ?>>
    <div class="farmart-product-detail clearfix <?php echo esc_attr( $add_classes ) ?>">

		<?php
		/**
		 * Hook: woocommerce_before_single_product_summary.
		 *
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'farmart_before_single_product_quickview_summary' );
		?>
        <div class="summary entry-summary">
			<?php
			/**
			 * Hook: woocommerce_single_product_summary.
			 *
			 * @hooked get_quickview_product_header - 10
			 * @hooked single_product_brand - 15
			 * @hooked woocommerce_template_single_price - 15
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 * @hooked WC_Structured_Data::generate_product_data() - 60
			 */
			do_action( 'farmart_single_product_quickview_summary' );
			?>
        </div>
    </div>
</div>