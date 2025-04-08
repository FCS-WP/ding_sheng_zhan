<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Farmart
 */

if ( farmart_get_layout() == 'full-content' ) {
	return;
}

$sidebar = 'blog-sidebar';
$columns = 'col-md-3 col-sm-12 col-xs-12 ';
$classes = '';

if ( farmart_is_catalog() ) {
	$sidebar = 'catalog-sidebar';
	$columns = '';
} elseif ( is_singular( 'product' ) ) {
	$sidebar = 'product-sidebar';
}

if ( farmart_is_catalog() || is_singular( 'product' ) ) {
	if ( farmart_get_option( 'catalog_sidebar_style' ) == 2 ) {
		$classes .= ' farmart-sidebar-style-2 ';
	}
}

if ( ! is_active_sidebar( $sidebar ) ) {
	return;
}

$sidebar = apply_filters( 'farmart_dynamic_sidebar', $sidebar );

$classes .= $columns . $sidebar;
?>

<aside id="primary-sidebar"
       class="widget-area primary-sidebar <?php echo esc_attr( $classes ); ?>">
	<?php if ( farmart_is_catalog() ): ?>
    <div class="backdrop"></div>
    <div class="catalog-sidebar--inner <?php echo farmart_get_option('catalog_header_layout') == '3' ? 'side-left' : '' ?>">
		<?php do_action( 'catalog_filter_mobile_before' ) ?>
		<?php endif; ?>

		<?php dynamic_sidebar( $sidebar ); ?>

		<?php if ( farmart_is_catalog() ): ?>
		<?php do_action( 'catalog_filter_mobile_after' ) ?>
    </div>
<?php endif; ?>

</aside><!-- #secondary -->
