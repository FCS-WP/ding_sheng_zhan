<?php
/**
 * Template part for displaying footer link
 *
 * @package farmart
 */

if ( ! is_active_sidebar( 'footer-link' ) ) {
	return;
}

?>

<div class="footer-link">
	<div class="<?php echo esc_attr( farmart_get_option( 'footer_width' ) ) ?>">
		<?php
			ob_start();
			dynamic_sidebar( 'footer-link');
			$output = ob_get_clean();

			echo apply_filters( 'farmart_footer_link', $output );
		?>
	</div>
</div>