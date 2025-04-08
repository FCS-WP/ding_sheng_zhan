<?php
/**
 * Template file for displaying mobile menu
 */
?>

<div class="fm-menu-mobile farmart-menu-mobile">
	<div class="menu-box-title">
		<div class="fm-icon menu-icon menu-icon-js">
			<?php echo Farmart\Icon::get_svg('menu'); ?>
		</div>
	</div>
	<div class="menu-mobile-wrapper">
		<div class="primary-menu-mobile">
			<div class="menu-box">
				<div class="top-content">
					<?php echo Farmart\Icon::get_svg('arrow-left', 'go-back close-canvas-mobile-panel'); ?>
					<div class="author">
						<?php
							$account_text 	= esc_html__( 'Login/Register', 'farmart' );
							$text = $login_id = '';
							if ( is_user_logged_in() ) {
								$login_id 		= 'fm-login';
								$user_id   		= get_current_user_id();
								$author       	= get_user_by( 'id', $user_id );
								$account_text 	= $author->display_name;
							}

							$text = sprintf(
								'<span class="header-account--text">
									<span>%s</span>
									<b>%s</b>
								</span>',
								is_user_logged_in() ? esc_html__( 'Hello,' , 'farmart' ) : '',
								$account_text
							);

							echo sprintf(
								'<a id="%s" href="%s">%s %s</a>',
								esc_attr( $login_id ),
								esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ),
								Farmart\Icon::get_svg('user', '', 'shop'),
								$text
							);
						?>
					</div>
				</div>
				<nav class="menu-content">
					<?php
						if ( has_nav_menu( 'mobile' ) ) {
							wp_nav_menu( apply_filters( 'farmart_navigation_mobile_content', array(
								'theme_location' => 'mobile',
								'container'      => false,
								'menu_class'     => 'fm-nav-mobile-menu menu',
							) ) );
						} else {
							wp_nav_menu( apply_filters( 'farmart_navigation_mobile_content', array(
								'theme_location' => 'primary',
								'container'      => false,
								'menu_class'     => 'fm-nav-mobile-menu menu',
							) ) );
						}
					?>
				</nav>
			</div>
			<?php
				$output = array();
				$img = '';
				$items = farmart_get_option( 'header_primary_menu_items' );
				if ( $items ) {
					foreach ( (array) $items as $item ) {

						if ( $item['image'] ) {
							$image_id = $item['image'];
							if( is_numeric($image_id) ) {
								$img = wp_get_attachment_image( $image_id, 'full' );
							} else {
								$img = sprintf('<img src="%s" alt="%s">', $image_id, esc_html__( 'Menu Image', 'farmart' ) );
							}
						}

						if ( $item['svg'] ) {
							$img = '<span class="farmart-svg-icon">' . $item['svg'] . '</span>';
						}

						if ( $item['text' ] ) {
							$text = $item['text'];
						}

						if ( isset( $item['link'] ) && ! empty( $item['link'] ) ) {
							if ( $img ) {
								$output[] = sprintf( '<div class="bottom-content--item"><a href="%s">%s %s</a></div>', esc_url( $item['link'] ), $img, $text );
							}
						} else {
							if ( $img ) {
								$output[] = sprintf( '<div class="bottom-content--item">%s %s</div>', $img, $text );
							}
						}

					}
				}

				if ( $output ) {
					printf( '<div class="bottom-content">%s</div>', implode( ' ', $output ) );
				}
			?>
		</div>
	</div>
	<div class="fm-off-canvas-layer"></div>
</div>