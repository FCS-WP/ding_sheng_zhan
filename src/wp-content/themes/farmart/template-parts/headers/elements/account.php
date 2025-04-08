<?php
/**
 * Header Account Template
 */
if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

$classes = [
	'header-element header-element--account',
	is_user_logged_in() ? 'logged' : 'login'
];

$login_id = '';

if ( ! is_user_logged_in() ) {
	$login_id = 'fm-login';
}

?>
<div class="<?php echo esc_attr( implode( ' ', $classes ) ) ?>">
	<?php
	$icon_acc = Farmart\Icon::get_svg('user', '', 'shop');

	$text = '';

	if ( intval( farmart_get_option( 'header_account_text' ) ) ) {
		$account_text 	= esc_html__( 'Login/Register', 'farmart' );

		if ( is_user_logged_in() ) {
			$user_id   		= get_current_user_id();
			$author       	= get_user_by( 'id', $user_id );
			$account_text 	= $author->display_name;
		}

		$text = sprintf(
			'<span class="header-account--text">
				<span>%s</span>
				<b>%s</b>
			</span>',
			esc_html__( 'Hello,' , 'farmart' ),
			$account_text
		);
	}

	echo sprintf(
		'<a id="%s" href="%s">%s %s</a>',
		esc_attr( $login_id ),
		esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ),
		$icon_acc,
		$text
	);
	if ( is_user_logged_in() ) :
		?>
			<span class="dropdown"></span>
			<div class="dropdown-submenu">
				<div class="wrapper">
				<div class="preamble"><?php echo esc_html__( 'My Account', 'farmart' ); ?></div>
					<ul>
						<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
							<li>
								<?php if ( $endpoint === 'customer-logout' ) : ?>
									<a class="logout" href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo Farmart\Icon::get_svg('logout'); echo esc_html( $label ); ?></a>
								<?php else : ?>
									<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		<?php
	endif;
	?>
</div>
