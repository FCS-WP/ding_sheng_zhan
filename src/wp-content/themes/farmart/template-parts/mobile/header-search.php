<?php
/**
 * Header mobile search
 */

?>
<div class="fm-search-form fm-search-form--mobile fm-search-form--mobile-right search-panel">
	<a href="#" class="open-search-panel">
		<?php echo Farmart\Icon::get_svg( 'search' ); ?>
	</a>

	<div class="search-panel-content">
		<div class="top-content">
			<form method="get" class="form-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<div class="search-inner-content">
					<div class="text-search">
						<div class="search-wrapper">
							<input type="text" name="s" class="search-field" autocomplete="off" placeholder="<?php echo esc_attr( farmart_get_option('header_search_placeholder') ); ?>">
							<?php if ( farmart_get_option('header_search_type') === 'product' ) : ?>
								<input type="hidden" name="post_type" value="product">
							<?php endif; ?>
							<a href="#" class="close-search-results"><?php echo Farmart\Icon::get_svg( 'close' ); ?> </a>
							<button type="submit"><?php echo Farmart\Icon::get_svg( 'search' ); ?></button>
						</div>
						<a href="#" class="close-search-panel"><?php echo esc_html__( 'Cancel', 'farmart' ); ?></a>
					</div>
					<div class="box-search-results">
						<div class="field-notice"><span class="count-results"></span><?php echo esc_html__( 'Search results', 'farmart' ); ?></div>
						<div class="search-results woocommerce"></div>
					</div>
				</div>
			</form>
		</div>
		<?php
			$output = array();

			$items = farmart_get_option( 'header_search_trending_items' );
			if ( $items ) {
				$output[] = '<ul class="hot-words">';
				foreach ( (array) $items as $item ) {
					$text = '';
					if ( $item['text' ] ) {
						$text = $item['text'];
					}

					if ( isset( $item['link'] ) && ! empty( $item['link'] ) ) {
						$output[] = sprintf( '<li><a href="%s">%s</a></li>', esc_url( $item['link'] ), $text );
					} else {
						$output[] = sprintf( '<li>%s</li>', $text );
					}

				}
				$output[] = '</ul>';
			}

			if ( $output ) {
				printf( '<div class="box-search-trending"><h6 class="title-words"><span class="farmart-icon">%s</span>%s</h6>%s</div>',
						Farmart\Icon::get_svg( 'power' ),
						esc_html__( 'Trending search', 'farmart' ),
						implode( ' ', $output )
					);
			}
		?>
	</div>
	<div class="fm-off-canvas-layer"></div>
</div>