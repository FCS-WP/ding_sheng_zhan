<?php
/**
 * Header Compare Template
 */


if( class_exists( '\WCBoost\ProductsCompare\Plugin' ) ) {
	$class = 'wcboost-compare';
	$count = intval( \WCBoost\ProductsCompare\Plugin::instance()->list->count_items() );
	$link = wc_get_page_permalink( 'compare' );
} else if ( class_exists( 'YITH_Woocompare' ) ) {
	global $yith_woocompare;
	$class = 'yith-contents yith-woocompare-open';
	if ( is_admin() ) {
		$count = [];
	} else {
		$count = sizeof( $yith_woocompare->obj->products_list );
	}
	$link = '#';
} else {
	return;
}

?>
<div class="header-element header-element--compare">
	<a class="<?php echo esc_attr( $class ); ?>" href="<?php echo esc_url( $link ); ?>">
		<?php echo Farmart\Icon::get_svg( 'repeat', '', 'shop' ); ?>
		<?php if( intval( farmart_get_option( 'header_compare_counter' ) ) ): ?>
			<span class="mini-item-counter" id="mini-compare-counter"><?php echo ! empty( $count ) ? $count : ''; ?></span>
		<?php endif; ?>
	</a>
</div>
