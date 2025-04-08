<?php
/**
 * Page Header Default Layout 1
 */

$css_class = array( 'page-header page-header-layout-1 text-center' );

$page_header = farmart_get_page_header();

$layout = farmart_get_option( 'page_header_blog_layout' );
if ( $blog_layout = get_post_meta( farmart_get_post_ID(), 'page_header_layout', true ) != '') {
	$layout = $blog_layout;
}

if (is_page()) {
	$layout = farmart_get_option( 'page_header_page_layout' );

	if ( get_post_meta( farmart_get_post_ID(), 'page_header_layout', true ) != '') {
		$layout = $page_header['page_header_layout'];
	}
}

if( farmart_is_catalog() || is_singular( 'product' ) || farmart_is_vendor_page() || shortcode_exists('dokan-stores')) {
	$layout = 2;
}

if( farmart_is_catalog() && farmart_get_option('catalog_header_layout') == '3' ) {
	return;
}

if ( $layout != '1' ) {
	$css_class = array( 'page-header page-header-layout-2' );
}


if ( ! in_array( 'title', $page_header ) ) {
	$css_class[] = 'hide-title';
}

$container = apply_filters( 'farmart_page_header_container', farmart_content_container_class() );

?>
<div class="<?php echo esc_attr( implode( ' ', $css_class ) ); ?>">
	<?php if ( $layout != '1' ): ?>

		<?php if ( in_array( 'breadcrumb', $page_header ) ) : ?>
            <div class="page-breadcrumbs">
                <div class="<?php echo esc_attr( $container ); ?>">
					<?php farmart_get_breadcrumbs(); ?>
                </div>
            </div>
		<?php endif; ?>
        <div class="page-title text-center">
            <div class="container">
				<?php the_archive_title( '<h1>', '</h1>' ); ?>
            </div>
        </div>

	<?php else: ?>

        <div class="<?php echo esc_attr( $container ); ?>">
			<?php the_archive_title( '<h1>', '</h1>' ); ?>
			<?php farmart_get_breadcrumbs(); ?>
        </div>

	<?php endif; ?>
</div>