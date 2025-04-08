<?php
/**
 * Template part for displaying footer main
 *
 * @package Farmart
 */

$bg_image = '';

if ( farmart_get_option( 'footer_newsletter_bg' ) ) {
	$bg_image = "background-image: url(" . farmart_get_option( 'footer_newsletter_bg' ) . "); ";
}

?>
<div class="footer-newsletter" style="<?php echo esc_attr( $bg_image ); ?>">
	<div class="<?php echo esc_attr( farmart_get_option( 'footer_width' ) ) ?>">
		<div class="footer-newsletter__wrapper">
		<?php
			if ( farmart_get_option( 'footer_newsletter_text' ) ) {
				echo sprintf('<div class="footer-newsletter__title">%s %s</div>', Farmart\Icon::get_svg( 'envelope' ), farmart_get_option( 'footer_newsletter_text' ) );
			}
			if ( farmart_get_option( 'footer_newsletter_form' ) ) {
				$newsletter_form = farmart_get_option( 'footer_newsletter_form' );
				echo do_shortcode( $newsletter_form );
			}
		?>
		</div>
	</div>
</div>
