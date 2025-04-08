<?php
global $product;
$tabs            = apply_filters( 'woocommerce_product_tabs', array() );
$i               = 0;
if ( farmart_get_option( 'product_layout' ) == 3 && intval( farmart_get_option( 'product_full_width' ) ) ) {
    $container_class =  'farmart-container';
} else {
    $container_class =  'container';
}
$thumbnail_size = 'thumbnail';
if ( function_exists( 'wc_get_image_size' ) ) {
	$gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
	$thumbnail_size    = apply_filters( 'woocommerce_gallery_thumbnail_size', array(
		$gallery_thumbnail['width'],
		$gallery_thumbnail['height']
	) );
}

$top_offset = apply_filters( 'farmart_sticky_product_info_offset', farmart_get_option( 'sticky_product_info_offset' ) );
?>
<div class="sticky-product-info-wapper" id="sticky-product-info-wapper" data-top_offset="<?php echo absint( $top_offset ) ?>">
    <div class="<?php echo esc_attr( $container_class ); ?>">
        <div class="sticky-product-inner">
            <div class="sc-product-info">
                <div class="product-thumb">
					<?php
                        $thumbnail_size = $product->get_image( $thumbnail_size );
                        echo ! empty( $thumbnail_size ) ? $thumbnail_size : '';
                    ?>
                </div>
                <div class="product-name">
                    <h2><?php echo esc_html( $product->get_title() ); ?></h2>
                    <ul class="sc-tabs">
						<?php foreach ( $tabs as $key => $tab ) :
							$css_class = 'tab-' . $key;
							if ( $i == 0 ) {
								$css_class .= ' active';
							}
							$i ++;
							?>
                            <li class="<?php echo esc_attr( $key ); ?>_tab">
                                <a class="<?php echo esc_attr( $css_class ); ?>"
                                   data-tab="<?php echo esc_attr( $key ); ?>"
                                   href="#tab-<?php echo esc_attr( $key ); ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
                            </li>
						<?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="sc-product-cart">
                <p class="price"><?php
                        $price_html = $product->get_price_html();
                        echo ! empty( $price_html ) ? $price_html : ''
                    ?></p>
				<?php if ( $product->get_stock_status() != 'outofstock' ) : ?>
                    <a href="#" class="button">
						<?php
						echo apply_filters( 'farmart_product_info_add_to_cart_text', esc_html__( 'Add to Cart', 'farmart' ) );
						?>
                    </a>
				<?php endif; ?>
            </div>
        </div>
    </div>
</div>