<?php

/**
 * Class for all wcboost wishlist template modification
 *
 * @version 1.0
 */

/**
 * Ajaxify update count wishlist
 *
 * @since 1.0
 *
 * @param array $fragments
 *
 * @return array
 */
function update_wishlist_count($data) {
	$data['.header-element--wishlist .mini-item-counter'] = '<span class="mini-item-counter">'.\WCBoost\Wishlist\Helper::get_wishlist()->count_items() . '</span>';

	return $data;
}

add_filter( 'wcboost_wishlist_add_to_wishlist_fragments', 'update_wishlist_count', 10, 1 );

/**
 * Change button add text
 *
 * @return void
 */
function wishlist_button_add_text() {
	return esc_html__( 'Wishlist', 'farmart' );
}

add_filter( 'wcboost_wishlist_button_add_text', 'wishlist_button_add_text' );

/**
 * Change button view text
 *
 * @return void
 */
function wishlist_button_view_text() {
	return esc_html__( 'Wishlist', 'farmart' );
}

add_filter( 'wcboost_wishlist_button_view_text', 'wishlist_button_view_text' );

/**
 * Wishlist icon
 *
 * @since 1.0.0
 *
 * @return void
 */
function wishlist_svg_icon($svg, $icon) {
	if( $icon == 'heart' ) {
		$svg = '<svg viewBox="0 0 32 32"><path d="M15.2 30.4c-0.134 0-0.267-0.034-0.389-0.101-0.15-0.083-3.722-2.082-7.347-5.355-2.146-1.936-3.858-3.917-5.093-5.888-1.574-2.514-2.371-5.022-2.371-7.456 0-4.632 3.768-8.4 8.4-8.4 1.568 0 3.234 0.587 4.69 1.654 0.851 0.624 1.576 1.376 2.11 2.174 0.534-0.798 1.259-1.55 2.11-2.174 1.456-1.067 3.122-1.654 4.69-1.654 4.632 0 8.4 3.768 8.4 8.4 0 2.434-0.798 4.942-2.371 7.456-1.234 1.971-2.947 3.952-5.091 5.888-3.626 3.274-7.197 5.272-7.347 5.355-0.122 0.067-0.254 0.101-0.389 0.101zM8.4 4.8c-3.749 0-6.8 3.051-6.8 6.8 0 4.864 3.76 9.283 6.914 12.136 2.816 2.547 5.67 4.333 6.686 4.939 1.016-0.606 3.87-2.392 6.686-4.939 3.154-2.851 6.914-7.272 6.914-12.136 0-3.749-3.051-6.8-6.8-6.8-2.725 0-5.371 2.242-6.042 4.253-0.109 0.326-0.414 0.547-0.758 0.547s-0.65-0.221-0.758-0.547c-0.67-2.011-3.317-4.253-6.042-4.253z"></path></svg>';
	}

	return $svg;
}

add_filter( 'wcboost_wishlist_svg_icon', 'wishlist_svg_icon', 20, 3 );

/**
 * Wishlist array
 *
 * @since 1.0.0
 *
 * @return array
 */
function wishlist_args($args) {
	if( $key = array_search( 'button', $args['class'] ) ) {
		unset( $args['class'][$key] );
	}

	return $args;
}

add_filter( 'wcboost_wishlist_button_template_args', 'wishlist_args', 20, 3 );

/**
 * Wishlist table
 *
 * @return void
 */
function wishlist_table( $item, $item_key, $wishlist ) {
	$_product = $item->get_product();
	$default_columns  = [
		'price'    => 'yes',
		'stock'    => 'yes',
		'quantity' => 'no',
		'date'     => 'no',
		'purchase' => 'yes',
	];

	$columns = get_option( 'wcboost_wishlist_table_columns' , $default_columns );
	$columns = wp_parse_args( $columns, $default_columns );
	?>
		<?php if( isset( $columns['price'] ) && $columns['price'] == 'yes' ) : ?>
			<div class="product-price hidden-lg hidden-md">
				<span class="label"><?php esc_html_e( 'Price', 'farmart' ); ?></span>
				<span class="price"><?php echo wp_kses_post( $_product->get_price_html() ); ?></span>
			</div>
		<?php endif; ?>

		<?php if( isset( $columns['stock'] ) && $columns['stock'] == 'yes' ) : ?>
			<div class="product-stock-status hidden-lg hidden-md">
				<span class="label"><?php esc_html_e( 'Stock', 'farmart' ); ?></span>
				<?php
				$availability = $_product->get_availability();
				printf( '<span class="%s">%s</span>', esc_attr( $availability['class'] ), $availability['availability'] ? esc_html( $availability['availability'] ) : esc_html__( 'In Stock', 'farmart' ) );
				?>
			</div>
		<?php endif; ?>

		<?php if ( isset( $columns['date'] ) && $columns['date'] == 'yes' ) : ?>
			<div class="product-date hidden-lg hidden-md">
				<?php echo esc_html( $item->get_date_added()->format( get_option( 'date_format' ) ) ); ?>
			</div>
		<?php endif; ?>
	<?php
}

add_action( 'wcboost_wishlist_after_item_name', 'wishlist_table', 10, 3 );