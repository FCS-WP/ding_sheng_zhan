<?php
/**
 * Template part for displaying footer main
 *
 * @package farmart
 */

$sections = array(
	'left'   => farmart_get_option( 'footer_main_left' ),
	'center' => farmart_get_option( 'footer_main_center' ),
	'right'  => farmart_get_option( 'footer_main_right' ),
);

/**
 * Hook: farmart_footer_main_sections
 *
 * @hooked: farmart_split_content_custom_footer - 10
 */
$sections = apply_filters( 'farmart_footer_main_sections', $sections );

$sections = array_filter( $sections );

if ( empty( $sections ) ) {
	return;
}

?>
<div class="footer-main site-info">
	<div class="<?php echo esc_attr( farmart_get_option( 'footer_width' ) ) ?>">
		<?php foreach ( $sections as $section => $items ) : ?>

			<div class="footer-items footer-<?php echo esc_attr( $section ); ?>">
				<?php
				foreach ( $items as $item ) {
					$item['item'] = $item['item'] ? $item['item'] : key( famart_footer_items_option() );
					farmart_footer_item( $item['item'] );
				}
				?>
			</div>

		<?php endforeach; ?>
	</div>
</div>
