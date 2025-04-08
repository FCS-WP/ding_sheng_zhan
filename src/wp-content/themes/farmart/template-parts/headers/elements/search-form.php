<?php
/**
 * Header Search Template
 */
?>
<div class="farmart-products-search search-products no-margin">
	<form method="get" class="form-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<div class="search-inner-content product-cat--<?php echo esc_attr( farmart_get_option('header_search_category_position') ) ?>">
			<?php
				if ( farmart_get_option('header_search_type') === 'product' ) {
					$args = array(
						'name'            => 'product_cat',
						'taxonomy'        => 'product_cat',
						'orderby'         => 'NAME',
						'hierarchical'    => 1,
						'hide_empty'      => 1,
						'echo'            => 0,
						'value_field'     => 'slug',
						'class'           => 'product-cat-dd',
						'show_option_all' => esc_html__( 'All Categories', 'farmart' ),
						'id'              => 'product-cat',
						'depth'			  => farmart_get_option('header_search_category_depth'),
					);

					if ( farmart_get_option('header_search_category_include') ) {
						$args['include'] = farmart_get_option('header_search_category_include');
					}

					if ( farmart_get_option('header_search_category_exclude') ) {
						$args['exclude'] = farmart_get_option('header_search_category_exclude');
					}

					echo sprintf(
						'<div class="product-cat">' .
						'<div class="product-cat-label"><span class="label">%s</span>%s</div>' .
						'%s' .
						'</div>',
						esc_html__( 'All Categories', 'farmart' ),
						Farmart\Icon::get_svg( 'chevron-bottom' ),
						wp_dropdown_categories( $args )
					);
				}
			?>
			<div class="search-wrapper">
				<input type="text" name="s" class="search-field" autocomplete="off" placeholder="<?php echo esc_attr( farmart_get_option('header_search_placeholder') ); ?>">
				<?php if ( farmart_get_option('header_search_type') === 'product' ) : ?>
					<input type="hidden" name="post_type" value="product">
				<?php endif; ?>
				<div class="search-results woocommerce"></div>
				<a href="#" class="close-search-results">
					<?php echo Farmart\Icon::get_svg( 'close' ); ?>
				</a>
			</div>
		</div>
		<?php
			$button_type = farmart_get_option( 'header_search_button_type' );
		?>
		<button class="search-submit button-<?php echo esc_attr( $button_type ) ?>" type="submit">
			<?php
				if ( $button_type == 'icon' ) {
					echo Farmart\Icon::get_svg( 'search' );
				} else {
					if ( !empty( $button_text = farmart_get_option( 'header_search_button_text' ) ) ) {
						echo esc_html( $button_text );
					} else {
						echo esc_html__( 'Search', 'farmart' );
					}
				}
			?>
		</button>
	</form>
	<?php
		if( intval( farmart_get_option( 'header_search_hot_enable' ) ) ) {
			$items = (array) farmart_get_option( 'header_search_hot_items' );

			if ( ! empty( $items ) ) {
				echo '<ul class="farmart-search-hot-items">';
				echo '<li class="item__first">'. esc_html__( 'Trending search:', 'farmart' ) .'</li>';

				foreach( $items as $item ) {
					echo sprintf(
						'<li class="item__%s">
							<a href="%s">%s</a>
						</li>',
						str_replace( ' ', '-', $item['text'] ),
						esc_attr( $item['link'] ),
						esc_attr( $item['text'] )
					);
				}

				echo '</ul>';
			}

		}
	?>
</div>
