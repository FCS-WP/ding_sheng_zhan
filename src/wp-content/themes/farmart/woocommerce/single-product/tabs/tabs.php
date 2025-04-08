<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 9.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );
$layout = apply_filters( 'farmart_product_tabs_layout', 1 );
$classes = '';

if ( farmart_get_option( 'product_layout' ) == 4 && intval( farmart_get_option( 'product_full_width' ) ) ) {
	$classes = 'farmart-container';
}

$tab_class = $ch_down = '';
if ( intval( farmart_is_mobile() ) && intval( farmart_get_option( 'product_collapse_tab' ) ) ) {
	$tab_class = 'product-collapse-tab-enable';
	$tab_class .= ' product-collapse-tab-' . farmart_get_option( 'product_collapse_tab_status' );
	$ch_down  = Farmart\Icon::get_svg( 'chevron-bottom', 'tab-toggle' );
}

if ( ! empty( $product_tabs ) ) : ?>
	<?php if ( $layout == '1' ) : ?>

		<div class="woocommerce-tabs wc-tabs-wrapper clear <?php echo esc_attr( $classes ) ?>">
			<ul class="tabs wc-tabs" role="tablist">
				<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
					<li class="<?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
						<a href="#tab-<?php echo esc_attr( $key ); ?>">
							<?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
			<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
				<div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
					<?php
					if ( isset( $product_tab['callback'] ) ) {
						call_user_func( $product_tab['callback'], $key, $product_tab );
					}
					?>
				</div>
			<?php endforeach; ?>

			<?php do_action( 'woocommerce_product_after_tabs' ); ?>
		</div>

	<?php else : ?>
		<div class="fm-woo-tabs wc-tabs-wrapper <?php echo esc_attr( $tab_class ) ?>">
			<?php foreach ( $product_tabs as $key => $tab ) : ?>
                <div class="fm-Tabs-panel fm-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content"
                     id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel"
                     aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
					<h3 class="tab-title"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?><?php echo '' . $ch_down ?></h3>
					<?php if ( isset( $tab['callback'] ) ) {
						echo '<div class="tab-content-wrapper">';
						call_user_func( $tab['callback'], $key, $tab );
						echo '</div>';
					} ?>
                </div>
			<?php endforeach; ?>
        </div>
	<?php endif; ?>

<?php endif; ?>
