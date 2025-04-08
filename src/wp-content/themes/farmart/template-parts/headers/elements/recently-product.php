<?php
/**
 * Recently viewed product
 */
if ( ! function_exists( 'WC' ) ) {
	return;
}

?>

<div class="fm-header-recently-viewed fm-recently-viewed woocommerce hide-icon-dropdown products-loaded">
	<h3 class="recently-title">
		<?php
			echo Farmart\Icon::get_svg( 'sync', 'farmart-icon farmart-recent-icon', 'shop');
			echo esc_html( farmart_get_option('header_recently_product_text') );
		?>
	</h3>
	<div class="recently-viewed-inner <?php echo esc_attr( farmart_get_option( 'header_width' ) ) ?>">
		<div class="recently-viewed-content">
			<div class="farmart-loading--wrapper">
				<div class="farmart-loading"></div>
			</div>
			<div class="recently-empty-products text-center">
				<div class="empty-desc"><?php echo esc_html__( 'Recently Viewed Products is a function which helps you keep track of your recent viewing history.', 'farmart' ); ?></div>
				<a class="btn-primary" href="<?php echo wc_get_page_permalink( 'shop' ); ?>"><?php echo esc_html__( 'Shop Now', 'farmart' ); ?></a>
			</div>
			<div class="recently-viewed-products">
				<div class="recently-has-products"></div>
			</div>
		</div>
	</div>
</div>
