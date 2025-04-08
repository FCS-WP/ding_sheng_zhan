<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see           https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       9.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$upsell_title = farmart_get_option( 'product_upsells_title' );
$position     = farmart_get_option( 'products_upsells_position' );
$columns      = intval( farmart_get_option( 'upsells_products_columns' ) );

if ( $position == 1 ) {
	$section_class   = 'fm-position-above';
	$container_class = 'upsell-container container';
	if ( farmart_get_product_layout() != 1 ) {
		$container_class = 'fm-product-upsell';
	}
	if ( farmart_get_product_layout() == 4 && intval( farmart_get_option( 'product_full_width' ) ) ) {
		$container_class .= ' farmart-container';
	}
} else {
	$section_class   = 'fm-position-under';
	$container_class = farmart_get_product_layout() == '6' ? 'farmart-container' : 'container';
}


if ( $upsells ) : ?>

    <section class="related-products up-sells upsells products <?php echo esc_attr( $section_class ) ?>"
             data-columns="<?php echo esc_attr( $columns ); ?>">
        <div class="<?php echo esc_attr( $container_class ); ?>">
            <div class="up-sells-content">

                <h2 class="related-title"><?php echo esc_html( $upsell_title ); ?></h2>

				<?php woocommerce_product_loop_start(); ?>

				<?php foreach ( $upsells as $upsell ) : ?>

					<?php
					$post_object = get_post( $upsell->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object );

					wc_get_template_part( 'content', 'product' ); ?>

				<?php endforeach; ?>

				<?php woocommerce_product_loop_end(); ?>
            </div>
        </div>

    </section>

<?php endif;

wp_reset_postdata();
