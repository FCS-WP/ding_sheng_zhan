<?php
/**
 * Cross-sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cross-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title   = farmart_get_option( 'cross_sells_products_title' );
$columns = intval( farmart_get_option( 'cross_sells_products_columns' ) );

$carousel_settings = array(
	'slidesToShow'   => $columns,
	'slidesToScroll' => $columns,
	'responsive'     => array(
		array(
			'breakpoint' => 1200,
			'settings'   => array(
				'dots'   => true,
				'arrows' => false,
				'slidesToShow'   => 5,
				'slidesToScroll' => 5,
			)
		),
		array(
			'breakpoint' => 992,
			'settings'   => array(
				'dots'   => true,
				'arrows' => false,
				'slidesToShow'   => 3,
				'slidesToScroll' => 1,
			)
		),
		array(
			'breakpoint' => 768,
			'settings'   => array(
				'dots'   => true,
				'arrows' => false,
				'slidesToShow'   => 2,
				'slidesToScroll' => 1,
			)
		)
	)
);

$carousel_settings = apply_filters( 'farmart_cross_sells_products_carousel_settings', $carousel_settings );

if ( $cross_sells ) : ?>

	<div class="related-products farmart-cross-sells-products farmart-wc-products-carousel cross-sells" data-columns="<?php echo esc_attr($columns)?>">

		<div class="container">
			<h2 class="section-title"><?php echo esc_html( $title ); ?></h2>

			<?php woocommerce_product_loop_start(); ?>

			<?php foreach ( $cross_sells as $cross_sell ) : ?>

				<?php
				$post_object = get_post( $cross_sell->get_id() );

				setup_postdata( $GLOBALS['post'] =& $post_object );

				wc_get_template_part( 'content', 'product' ); ?>

			<?php endforeach; ?>

			<?php woocommerce_product_loop_end(); ?>

		</div>
	</div>

<?php endif;

wp_reset_postdata();
