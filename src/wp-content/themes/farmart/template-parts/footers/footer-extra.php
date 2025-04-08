<?php
/**
 * Template part for displaying footer extra
 *
 * @package farmart
 */

$items = farmart_get_option( 'footer_extra_items' );

if ( empty( $items ) ) {
	return;
}

?>

<div class="footer-extra">
	<div class="<?php echo esc_attr( farmart_get_option( 'footer_width' ) ) ?>">
		<div class="footer-extra__wrapper">
			<?php
				foreach( (array) $items as $item ) {
					echo sprintf(
						'<div class="footer-extra__item">
							<div class="footer-extra__content">
								<div class="footer-extra__content--title">%s</div>
								<div class="footer-extra__content--desc">%s</div>
							</div>
							<div class="footer-extra__icon"><span class="farmart-svg-icon">%s</span></div>
						</div>',
						esc_html( $item['title'] ),
						$item['description'],
						$item['svg']
					);
				}

			?>
		</div>
	</div>
</div>