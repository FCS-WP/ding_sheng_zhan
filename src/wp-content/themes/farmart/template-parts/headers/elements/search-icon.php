<?php
/**
 * Header Search Template
 */
?>
<div class="header-element header-element--search fm-search-form search-panel">
	<a class="open-search-panel farmart-search-icon" href="#">
		<?php echo Farmart\Icon::get_svg( 'search' ); ?>
	</a>
	<div class="search-panel-content">
		<div class="farmart-container">
			<div class="top-content">
				<label class="label-search-panel"><?php esc_html_e( 'Search', 'farmart' ); ?></label>
				<a href="#" class="close-search-panel">
					<?php echo Farmart\Icon::get_svg( 'cross' ); ?>
				</a>
			</div>
			<div class="content-panel">
				<form method="get" class="form-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<div class="search-inner-content">
						<?php if ( farmart_get_option('header_search_type') === 'product' ) : ?>
							<?php taxs_list_search(); ?>
						<?php endif; ?>
						<div class="text-search">
							<div class="search-wrapper">
								<input type="text" name="s" class="search-field" autocomplete="off" placeholder="<?php echo esc_attr( farmart_get_option('header_search_placeholder') ); ?>">
								<?php if ( farmart_get_option('header_search_type') === 'product' ) : ?>
									<input type="hidden" name="post_type" value="product">
									<input type="hidden" name="product_cat" value="0">
								<?php endif; ?>
								<a href="#" class="close-search-results"><?php echo Farmart\Icon::get_svg( 'close' ); ?> </a>
							</div>
						</div>
						<div class="box-search-results">
							<div class="field-notice"><span class="count-results"></span><?php echo esc_html__( 'Search results', 'farmart' ); ?></div>
							<div class="search-results woocommerce"></div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>