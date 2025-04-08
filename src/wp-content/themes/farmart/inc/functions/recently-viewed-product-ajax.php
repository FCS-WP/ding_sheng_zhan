<?php
/**
 * Recently viewed product ajax
 */

/**
 * get_recently_viewed_products
 */
if ( function_exists('recently_viewed_products') ) :
	function recently_viewed_products() {

		$numbers = 15;
		$output  = recently_viewed_products_content( $numbers );
		wp_send_json_success( $output );
		die();
	}
	add_action( 'wc_ajax_farmart_recently_viewed_products', 'recently_viewed_products' );
endif;

if ( function_exists('recently_viewed_products_content') ) :
	function recently_viewed_products_content( $numbers ) {

		$viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
		$viewed_products = array_reverse( array_filter( array_map( 'absint', $viewed_products ) ) );

		$output = array();

		if ( empty( $viewed_products ) ) {

			$output[] = sprintf(
				'<ul class="product-list no-products">' .
				'<li class="text-center">%s <br><a href="%s" class="btn-secondary">%s</a></li>' .
				'</ul>',
				esc_html__( 'Recently Viewed Products is a function which helps you keep track of your recent viewing history.', 'farmart' ),
				esc_url( get_permalink( get_option( 'woocommerce_shop_page_id' ) ) ),
				esc_html__( 'Shop Now', 'farmart' )
			);

		} else {
			if ( ! function_exists( 'wc_get_product' ) ) {
				$output[] = sprintf(
					'<ul class="product-list no-products">' .
					'<li class="text-center">%s <br><a href="%s" class="btn-secondary">%s</a></li>' .
					'</ul>',
					esc_html__( 'Recently Viewed Products is a function which helps you keep track of your recent viewing history.', 'farmart' ),
					esc_url( get_permalink( get_option( 'woocommerce_shop_page_id' ) ) ),
					esc_html__( 'Shop Now', 'farmart' )
				);
			}

			$thumbnail_size = 'thumbnail';
			if ( function_exists( 'wc_get_image_size' ) ) {
				$gallery_thumbnail = wc_get_image_size( 'shop_catalog' );
				$thumbnail_size    = apply_filters( 'woocommerce_gallery_thumbnail_size', array(
					$gallery_thumbnail['width'],
					$gallery_thumbnail['height']
				) );
			}

			$number = intval( $numbers );

			$output[] = '<ul class="product-list">';
			$index    = 1;

			foreach ( $viewed_products as $product_id ) {
				if ( $index > $number ) {
					break;
				}

				$product = wc_get_product( $product_id );

				if ( empty( $product ) ) {
					continue;
				}
				$output[] = sprintf(
					'<li class="product">' .
					'<a href="%s">%s</a>' .
					'</li>',
					esc_url( $product->get_permalink() ),
					$product->get_image( $thumbnail_size )
				);

				$index ++;
			}
			$output[] = '</ul>';
		}

		return '<div class="recently-product-wrapper">' . implode( ' ', $output ). '<div>';
	}
endif;