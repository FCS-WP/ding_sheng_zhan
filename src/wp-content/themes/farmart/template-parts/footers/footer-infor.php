<?php
/**
 * Template part for displaying footer infor
 *
 * @package farmart
 */

if( ! intval( farmart_get_option( 'footer_infor' ) ) ) {
	return;
}

$items = farmart_get_option( 'footer_infor_items' );

if ( empty( $items ) ) {
	return;
}

?>

<div class="footer-infor">
	<div class="<?php echo esc_attr( farmart_get_option( 'footer_width' ) ) ?>">
		<div class="footer-infor__wrapper">
			<?php
				foreach( (array) $items as $item ) {
					$image = farmart_get_image_html( $item['image'], 'full' );
					if ( empty( $image ) && ! empty( $item['svg'] ) ) {
						$image = '<span class="farmart-svg-icon">' .Farmart\Icon::sanitize_svg( $item['svg'] ) . '</span>';
					}

					echo sprintf(
						'<div class="footer-infor__item">
							<div class="footer-infor__image">%s</div>
							<div class="footer-infor__content">
								<div class="footer-infor__content--title">%s</div>
								<div class="footer-infor__content--desc">%s</div>
							</div>
						</div>',
						$image,
						esc_html( $item['title'] ),
						esc_html( $item['description'] )
					);
				}

			?>
		</div>
	</div>
</div>