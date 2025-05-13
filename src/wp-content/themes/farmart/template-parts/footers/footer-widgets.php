<?php
/**
 * Template part for displaying footer widgets
 *
 * @package farmart
 */

$layout      = farmart_get_option( 'footer_widgets_layout' );
$columns     = intval( $layout );
$has_widgets = false;
$column_class_1 = 'col-flex-md-3';
$column_class_2 = 'col-flex-md-6';

for ( $i = 1; $i <= $columns; $i++ ) {
	$has_widgets = $has_widgets || is_active_sidebar( 'footer-' . $i );
	if ( $columns == 4 ) {
		$column_class_1 = $column_class_2 = 'col-flex-md-4';
	}
}

if ( ! $has_widgets ) {
	return;
}

if ( ! apply_filters( 'farmart_footer_widget_section', true ) ) {
	return;
}

?>

<div class="footer-widgets widgets-area">
	<div class="<?php echo esc_attr( farmart_get_option( 'footer_width' ) ) ?>">
		<div class="row-flex ">
			<?php if( farmart_get_option( 'footer_widgets_style' ) == 2 ) : ?>
				<div class="footer-widgets-area-1 footer-widgets-area col-flex col-flex-xs-12 col-flex-sm-6 col-flex-md-6">
					<?php
						ob_start();
						dynamic_sidebar( 'footer-1');
						$output = ob_get_clean();

						echo apply_filters( 'farmart_footer_widgets_1', $output );
					?>
				</div>
				<div class="footer-widgets-area-diff footer-widgets-area col-flex col-flex-xs-12 col-flex-sm-6 col-flex-md-6">
					<div class="row-flex">
					<?php
						for ( $i = 2; $i <= $columns; $i++ ) {

							?>
							<div class="footer-widgets-diff-item footer-widgets-diff-<?php echo esc_attr( $i ) ?>">
								<?php
									ob_start();
									dynamic_sidebar( 'footer-' . $i );
									$output = ob_get_clean();

									echo apply_filters( 'farmart_footer_widgets_' . $i, $output );
								?>
							</div>
							<?php
						}
					?>
					</diV>
				</div>
			<?php else : ?>
				<?php
					if($columns != '5' && $columns != '4'){
						for ( $i = 1; $i <= $columns; $i++ ) {
							$column_class = 'col-flex col-flex-xs-12 col-flex-sm-6 col-flex-md-' . 12 / $columns;
							?>

							<div class="footer-widgets-area-<?php echo esc_attr( $i ) ?> footer-widgets-area <?php echo esc_attr( $column_class ) ?>">
								<?php
									ob_start();
									dynamic_sidebar( 'footer-' . $i );
									$output = ob_get_clean();

									echo apply_filters( 'farmart_footer_widgets_' . $i, $output );
								?>
							</div>
							<?php
						}
					} else {
				?>
					<div class="footer-widgets-area-1 footer-widgets-area col-flex col-flex-xs-12 col-flex-sm-5 <?php echo esc_attr( $column_class_1 ) ?>">
						<?php
							ob_start();
							dynamic_sidebar( 'footer-1');
							$output = ob_get_clean();

							echo apply_filters( 'farmart_footer_widgets_1', $output );
						?>
					</div>
					<div class="footer-widgets-area-diff footer-widgets-area col-flex col-flex-xs-12 col-flex-sm-7">
						<div class="row-flex flex-sm-column">
						<?php
							for ( $i = 2; $i <= $columns - 1; $i++ ) {

								?>
								<div class="footer-widgets-diff-item footer-widgets-diff-<?php echo esc_attr( $i ) ?>">
									<?php
										ob_start();
										dynamic_sidebar( 'footer-' . $i );
										$output = ob_get_clean();

										echo apply_filters( 'farmart_footer_widgets_' . $i, $output );
									?>
								</div>
								<?php
							}
						?>
						</diV>
					</div>
				<?php } ?>
			<?php endif; ?>
		</div>
	</div>
</div>