<?php
/**
 * Header Bar
 */

?>
<div class="header-element header-element--header-bar">
	<?php if( ! empty( $icon = farmart_get_option( 'header_bar_icon' ) ) ): ?>
		<div class="header-bar__box-icon farmart-svg-icon">
			<?php echo Farmart\Icon::sanitize_svg( $icon ); ?>
		</div>
	<?php endif; ?>
	<div class="header-bar__box-content">
		<?php
			$html = farmart_get_option( 'header_bar_text' );
			echo ! empty( $html ) ? $html : '';
		?>
	</div>
</div>
