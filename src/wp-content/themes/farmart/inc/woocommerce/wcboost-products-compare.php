<?php

/**
 * Class for all wcboost products compare template modification
 *
 * @version 1.0
 */

function remove_compare_button() {
	// Compare button.
	remove_action( 'woocommerce_after_add_to_cart_form', [ \WCBoost\ProductsCompare\Frontend::instance(), 'single_add_to_compare_button' ] );
	remove_action( 'woocommerce_after_shop_loop_item', [ \WCBoost\ProductsCompare\Frontend::instance(), 'loop_add_to_compare_button' ], 15 );
}

add_action( 'wp', 'remove_compare_button' );

/**
 * Update a single cart item.
 *
 * @since 1.0.0
 *
 * @return void
 */
function products_compare_button_icon( $svg, $icon ) {
	if( $icon == 'arrows' ) {
		$svg = Farmart\Icon::get_svg( 'repeat', '', 'shop' );
	} else if ( $icon == 'check' ) {
		$svg = Farmart\Icon::get_svg( 'repeat-one', '', 'shop' );
	}

	return $svg;
}

add_filter( 'wcboost_products_compare_button_icon', 'products_compare_button_icon', 10, 2 );

/**
 * Show button compare.
 *
 * @since 1.0.0
 *
 * @return void
 */
function products_compare_button_template_args( $args, $product ) {
	$args['class'][] = 'fm-loop_button';

	return $args;
}

add_filter( 'wcboost_products_compare_button_template_args', 'products_compare_button_template_args', 10, 2 );

/**
 * Ajaxify update count compare
 *
 * @since 1.0
 *
 * @param array $fragments
 *
 * @return array
 */
function products_compare_add_to_compare_fragments( $data ) {
	$data['.header-element--compare .mini-item-counter'] = '<span class="mini-item-counter" id="mini-compare-counter">'. \WCBoost\ProductsCompare\Plugin::instance()->list->count_items() . '</span>';

	return $data;
}

add_filter( 'wcboost_products_compare_add_to_compare_fragments', 'products_compare_add_to_compare_fragments', 10, 1 );