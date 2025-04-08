<?php
/**
 * Hooks for template header
 *
 * @package Farmart
 */


/**
 * Enqueue scripts and styles.
 */
function farmart_scripts() {

	/**
	 * Register and enqueue styles
	 */
	wp_register_style( 'farmart-fonts', farmart_fonts_url(), array(), '20190930' );
	wp_register_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.7' );
	wp_register_style( 'farmartIcon', get_template_directory_uri() . '/css/farmartIcon.css', array(), '1.0.0' );
	wp_register_style( 'photoswipe', get_template_directory_uri() . '/css/photoswipe.css', array(), '4.7.0' );
	wp_register_style( 'magnific', get_template_directory_uri() . '/css/magnific-popup.css', array(), '2.0' );
	wp_enqueue_style( 'farmart', get_template_directory_uri() . '/style.css', array(
		'farmart-fonts',
		'farmartIcon',
		'bootstrap',
		'photoswipe',
		'magnific',
	), '20220304' );

	/**
	 * Register and enqueue scripts
	 */
	wp_add_inline_style( 'farmart', apply_filters( 'farmart_inline_style', $css = '' ) );

	wp_enqueue_script( 'html5shiv', get_template_directory_uri() . '/js/plugins/html5shiv.min.js', array(), '3.7.2' );
	wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'respond', get_template_directory_uri() . '/js/plugins/respond.min.js', array(), '1.4.2' );
	wp_script_add_data( 'respond', 'conditional', 'lt IE 9' );

	wp_register_script( 'photoswipe', get_template_directory_uri() . '/js/plugins/photoswipe.min.js', array(), '4.1.1', true );
	wp_register_script( 'photoswipe-ui', get_template_directory_uri() . '/js/plugins/photoswipe-ui.min.js', array( 'photoswipe' ), '4.1.1', true );
	wp_register_script( 'slick', get_template_directory_uri() . '/js/plugins/slick.min.js', array(), '1.0', true );
	wp_register_script( 'isInViewport', get_template_directory_uri() . '/js/plugins/isInViewport.min.js', array(), '1.1.0', true );
	wp_register_script( 'counterup', get_template_directory_uri() . '/js/plugins/jquery.counterup.min.js', array(), '1.0.0', true );
	wp_register_script( 'waypoints', get_template_directory_uri() . '/js/plugins/waypoints.min.js', array(), '2.0.2', true );
	wp_register_script( 'coundown', get_template_directory_uri() . '/js/plugins/jquery.coundown.js', array(), '1.0.0', true );
	wp_register_script( 'magnific', get_template_directory_uri() . '/js/plugins/jquery.magnific-popup.js', array(), '1.0', true );
	wp_register_script( 'notify', get_template_directory_uri() . '/js/plugins/notify.min.js', array(), '1.0.0', true );
	wp_register_script( 'nprogress', get_template_directory_uri() . '/js/plugins/nprogress.js', array(), '1.0.0', true );


	wp_enqueue_style( 'photoswipe' );
	wp_enqueue_script( 'photoswipe-ui' );

	$photoswipe_skin = 'photoswipe-default-skin';
	if ( wp_style_is( $photoswipe_skin, 'registered' ) && ! wp_style_is( $photoswipe_skin, 'enqueued' ) ) {
		wp_enqueue_style( $photoswipe_skin );
	}

	wp_enqueue_script( 'farmart', get_template_directory_uri() . "/js/scripts.js", array(
		'jquery',
		'slick',
		'photoswipe',
		'isInViewport',
		'imagesloaded',
		'counterup',
		'waypoints',
		'coundown',
		'magnific',
		'notify',
		'nprogress',
	), '20220304', true );

	wp_add_inline_style( 'farmart', farmart_get_inline_style() );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	$farmart_data = array(
		'ajax_url'        	   => class_exists( 'WC_AJAX' ) ? WC_AJAX::get_endpoint( '%%endpoint%%' ) : '',
		'nonce'          	   => wp_create_nonce( '_farmart_nonce' ),
		'search_content_type'  => farmart_get_option( 'header_search_type' ),
		'header_search_number' => farmart_get_option( 'header_search_number' ),
		'header_ajax_search'   => intval( farmart_get_option( 'header_search_ajax' ) ),
		'days'            	   => esc_html__( 'days', 'farmart' ),
		'hours'         	   => esc_html__( 'hours', 'farmart' ),
		'minutes'     	       => esc_html__( 'minutes', 'farmart' ),
		'seconds'      		   => esc_html__( 'seconds', 'farmart' ),
		'product_gallery'	   => intval( farmart_get_option( 'product_images_lightbox' ) ),
		'sticky_header'        => intval( farmart_get_option( 'header_sticky' ) ),
	);

	if ( is_singular( 'product' ) ) {
		$farmart_data['currency_param'] = array(
			'currency_pos'    => get_option( 'woocommerce_currency_pos' ),
			'currency_symbol' => function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '',
			'thousand_sep'    => function_exists( 'wc_get_price_thousand_separator' ) ? wc_get_price_thousand_separator() : '',
			'decimal_sep'     => function_exists( 'wc_get_price_decimal_separator' ) ? wc_get_price_decimal_separator() : '',
			'price_decimals'  => function_exists( 'wc_get_price_decimals' ) ? wc_get_price_decimals() : '',
		);
	}

	if ( intval( farmart_get_option( 'added_to_cart_notice' ) ) ) {
		$farmart_data['added_to_cart_notice'] = array(
			'added_to_cart_text'    => esc_html__( 'has been added to your cart.', 'farmart' ),
			'added_to_cart_texts'   => esc_html__( 'have been added to your cart.', 'farmart' ),
			'cart_view_text'        => esc_html__( 'View Cart', 'farmart' ),
			'cart_view_link'        => function_exists( 'wc_get_cart_url' ) ? esc_url( wc_get_cart_url() ) : '',
			'cart_notice_auto_hide' => intval( farmart_get_option( 'cart_notice_auto_hide' ) ) > 0 ? intval( farmart_get_option( 'cart_notice_auto_hide' ) ) * 1000 : 0,
			'noticeFaildQuantity'   => esc_html__( 'The quantity number does not match', 'farmart' ),
			'noticeQuantityMax'     => esc_html__( 'Its maximum quantity', 'farmart' ),
			'noticeQuantityMin'     => esc_html__( 'Its minimum quantity', 'farmart' ),
			'header_cart_behaviour' => farmart_get_option( 'header_cart_behaviour' ),
			'open_cart_panel_added_to_cart_notice'   => intval( farmart_get_option( 'open_cart_panel_added_to_cart_notice' ) ),
		);
	}

	if ( intval( farmart_get_option( 'added_to_wishlist_notice' ) ) && defined( 'YITH_WCWL' ) ) {
		$farmart_data['added_to_wishlist_notice'] = array(
			'added_to_wishlist_text'    => esc_html__( 'has been added to your wishlist.', 'farmart' ),
			'added_to_wishlist_texts'   => esc_html__( 'have been added to your wishlist.', 'farmart' ),
			'wishlist_view_text'        => esc_html__( 'View Wishlist', 'farmart' ),
			'wishlist_view_link'        => esc_url( get_permalink( get_option( 'yith_wcwl_wishlist_page_id' ) ) ),
			'wishlist_notice_auto_hide' => intval( farmart_get_option( 'wishlist_notice_auto_hide' ) ) > 0 ? intval( farmart_get_option( 'wishlist_notice_auto_hide' ) ) * 1000 : 0,
		);
	}

	if ( farmart_is_mobile() && is_singular( 'product' ) ) {
		if ( intval( farmart_get_option( 'product_collapse_tab' ) ) ) {
			$farmart_data['product_collapse_tab'] = array(
				'status' => farmart_get_option( 'product_collapse_tab_status' )
			);
		}
	}

	wp_localize_script(
		'farmart', 'farmartData', $farmart_data
	);

}

add_action( 'wp_enqueue_scripts', 'farmart_scripts', 20 );

/**
 * Show header
 *
 * @since 1.0.0
 */
function farmart_show_header() {
	if ( 'default' == farmart_get_option( 'header_type' ) ) {
		prebuild_header( farmart_get_option( 'header_layout_version' ) );
	} else {
		// Header main.
		$sections = array(
			'left'   => farmart_get_option( 'header_main_left' ),
			'center' => farmart_get_option( 'header_main_center' ),
			'right'  => farmart_get_option( 'header_main_right' ),
		);

		$classes = array( 'header-main', 'header-main--custom' );

		get_header_contents( $sections, array( 'class' => $classes ) );

		// Header bottom.
		$sections = array(
			'left'   => farmart_get_option( 'header_bottom_left' ),
			'center' => farmart_get_option( 'header_bottom_center' ),
			'right'  => farmart_get_option( 'header_bottom_right' ),
		);

		$sticky_bottom = in_array( 'header_main', (array) farmart_get_option( 'header_sticky_el' ) ) ? 'farmart-sticky-main' : '';

		$classes = array( 'header-bottom', 'header-bottom--custom', $sticky_bottom );

		get_header_contents( $sections, array( 'class' => $classes ) );
	}
}

add_action( 'farmart_header', 'farmart_show_header' );

function farmart_site_header_classes( $classes ) {
	if ( intval( farmart_get_option( 'header_sticky' ) ) ) {
		$header_sticky_el = (array) farmart_get_option( 'header_sticky_el' );

		if ( ! in_array( 'header_main', $header_sticky_el ) ) {
			$classes .= ' header-main-no-sticky';
		}

		if ( ! in_array( 'header_bottom', $header_sticky_el ) ) {
			$classes .= ' header-bottom-no-sticky';
		}

		if ( ! farmart_get_option( 'mobile_header_sticky' ) ) {
			$classes .= ' header-mobile-no-sticky';
		}
	}

	return esc_attr( apply_filters( 'farmart_site_header_class', $classes ) );
}

function show_header_sticky_minimized() {
	if ( ! farmart_get_option( 'header_sticky' ) ) {
		return;
	}

	echo '<div id="site-header-minimized"></div>';
}

add_action( 'farmart_before_header', 'show_header_sticky_minimized' );

/**
 * Display pre-build header
 *
 * @since 1.0.0
 *
 * @return void
 */
function prebuild_header( $version = 'v1' ) {
	$classes[] = 'header-main';
	$classes_bottom[] = 'header-bottom';
	switch ( $version ) {
		case 'v1':
			$main_sections   = array(
				'left'   => array(
					array( 'item' => 'logo' ),
				),
				'center' => array(
					array( 'item' => 'search-form' ),
				),
				'right'  => array(
					array( 'item' => 'header-bar' ),
					array( 'item' => 'account' ),
					array( 'item' => 'wishlist' ),
					array( 'item' => 'cart' ),
				),
			);
			$bottom_sections = array(
				'left'   => array(
					array( 'item' => 'menu-department' ),
				),
				'center' => array(
					array( 'item' => 'menu-primary' ),
				),
				'right'  => array(
					array( 'item' => 'recently-product' ),
				),
			);
			$classes[] =  '';
			$classes_bottom[] =  '';
			break;

		case 'v2':
			$main_sections   = array(
				'left'   => array(
					array( 'item' => 'logo' ),
				),
				'center' => array(
					array( 'item' => 'menu-primary' ),
				),
				'right'  => array(
					array( 'item' => 'search-icon' ),
				),
			);
			$bottom_sections = array();
			$classes[] =  '';
			$classes_bottom[] =  '';
			break;

		case 'v3':
			$main_sections   = array(
				'left'   => array(
					array( 'item' => 'logo' ),
					array( 'item' => 'menu-department' ),
					array( 'item' => 'search-form' ),
				),
				'center' => array(
				),
				'right'  => array(
					array( 'item' => 'compare' ),
					array( 'item' => 'wishlist' ),
					array( 'item' => 'cart' ),
				),
			);
			$bottom_sections = array(
				'left'   => array(
					array( 'item' => 'menu-primary' ),
				),
				'center' => array(),
				'right'  => array(
					array( 'item' => 'recently-product' ),
				),
			);
			$classes[] =  '';
			$classes_bottom[] =  '';
			break;

		case 'v4':
			$main_sections   = array(
				'left'   => array(
					array( 'item' => 'logo' ),
					array( 'item' => 'menu-department' ),
					array( 'item' => 'search-form' ),
				),
				'center' => array(
				),
				'right'  => array(
					array( 'item' => 'header-bar' ),
					array( 'item' => 'wishlist' ),
					array( 'item' => 'cart' ),
					array( 'item' => 'account' ),
				),
			);
			$bottom_sections = array(
				'left'   => array(
					array( 'item' => 'menu-primary' ),
				),
				'center' => array(),
				'right'  => array(
					array( 'item' => 'recently-product' ),
				),
			);
			$classes[] =  '';
			$classes_bottom[] =  '';
			break;

		case 'v5':
			$main_sections   = array(
				'left'   => array(
					array( 'item' => 'logo' ),
				),
				'center' => array(
					array( 'item' => 'search-form' ),
				),
				'right'  => array(
					array( 'item' => 'wishlist' ),
					array( 'item' => 'cart' ),
				),
			);
			$bottom_sections = array(
				'left'   => array(
					array( 'item' => 'menu-department' ),
					array( 'item' => 'menu-primary' ),
				),
				'center' => array(),
				'right'  => array(
					array( 'item' => 'recently-product' ),
				),
			);
			$classes[] =  '';
			$classes_bottom[] =  '';
			break;

		case 'v6':
			$main_sections   = array(
				'left'   => array(
					array( 'item' => 'logo' ),
					array( 'item' => 'secondary-button' ),
				),
				'center' => array(
					array( 'item' => 'search-form' ),
				),
				'right'  => array(
					array( 'item' => 'compare' ),
					array( 'item' => 'wishlist' ),
					array( 'item' => 'cart' ),
					array( 'item' => 'account' ),
				),
			);
			$bottom_sections = array(
				'left'   => array(
					array( 'item' => 'menu-department' ),
				),
				'center' => array(
					array( 'item' => 'menu-primary' ),
				),
				'right'  => array(
					array( 'item' => 'primary-button' ),
				),
			);
			$classes[] =  '';
			$classes_bottom[] =  '';
			break;

		case 'v7':
			$main_sections   = array(
				'left'   => array(
					array( 'item' => 'logo' ),
				),
				'center' => array(
					array( 'item' => 'menu-primary' ),
					array( 'item' => 'search-icon' ),
				),
				'right'  => array(
					array( 'item' => 'header-bar' ),
				),
			);
			$bottom_sections = array();
			$classes[] =  '';
			$classes_bottom[] =  '';
			break;

		default:
			$main_sections   = array();
			$bottom_sections = array();
			$classes[] =  '';
			$classes_bottom[] =  '';
			break;
	}

	get_header_contents( $main_sections, array( 'class' => $classes ) );
	get_header_contents( $bottom_sections, array( 'class' => $classes_bottom ) );
}

/**
 * Display header items
 *
 * @since 1.0.0
 *
 * @return void
 */
function get_header_contents( $sections, $atts = array() ) {
	if ( false == array_filter( $sections ) ) {
		return;
	}

	$classes = array();
	if ( isset( $atts['class'] ) ) {
		$classes = (array) $atts['class'];
		unset( $atts['class'] );
	}

	if ( empty( $sections['left'] ) && empty( $sections['right'] ) ) {
		unset( $sections['left'] );
		unset( $sections['right'] );
	}

	if ( ! empty( $sections['center'] ) ) {
		$classes[]    = 'has-center';
		$center_items = wp_list_pluck( $sections['center'], 'item' );

		if ( in_array( 'logo', $center_items ) ) {
			$classes[] = 'logo-center';
		}

		if ( in_array( 'menu-primary', $center_items ) ) {
			$classes[] = 'menu-center';
		}

		if ( empty( $sections['left'] ) && empty( $sections['right'] ) ) {
			$classes[] = 'no-sides';
		}
	} else {
		$classes[] = 'no-center';
		unset( $sections['center'] );

		if ( empty( $sections['left'] ) ) {
			unset( $sections['left'] );
		}

		if ( empty( $sections['right'] ) ) {
			unset( $sections['right'] );
		}
	}
	$attr = '';
	$container_width = farmart_get_option( 'header_width' );
	if ( farmart_get_option( 'header_layout_version' ) == 'v7' ) {
		$container_width = '';
	}

	foreach ( $atts as $name => $value ) {
		$attr .= ' ' . $name . '=' . esc_attr( $value ) . '';
	}

	?>
	<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" <?php echo esc_attr( $attr ); ?>>
		<div class="header-container <?php echo esc_attr( apply_filters( 'farmart_header_container_class', $container_width ) ); ?>">
			<div class="header-wrapper">
				<?php foreach ( $sections as $section => $items ) : ?>

					<div class="header-items header-items--<?php echo esc_attr( $section ) ?>">
						<?php get_header_items( $items ); ?>
					</div>

				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Display header items
 *
 * @since 1.0.0
 *
 * @return void
 */
function get_header_items( $items ) {
	if ( empty( $items ) ) {
		return;
	}

	foreach ( $items as $item ) {
		if ( ! isset( $item['item'] ) ) {
			continue;
		}

		$item['item']  = $item['item'] ? $item['item'] : key( get_header_items_option() );
		$template_file = $item['item'];

		if ( 'default' != farmart_get_option( 'header_type' ) && $template_file == 'search' ) {
			$template_file = 'search-' . farmart_get_option('header_search_layout');
		}

		if ( $template_file ) {
			get_template_part( 'template-parts/headers/elements/' . $template_file );
		}
	}
}

function body_classes( $classes ) {

	if ( 'default' == farmart_get_option( 'header_type' ) ) {
		$classes[] = 'header-' . farmart_get_option( 'header_layout_version' );
	}else {
		$classes[] = 'header-custom';
	}

	if ( farmart_get_option( 'header_sticky' ) ) {
		$classes[] = 'header-sticky';
	}

	return $classes;
}
add_filter( 'body_class', 'body_classes' );

/**
 * Show header mobile
 *
 * @since 1.0.0
 */
function farmart_show_header_mobile() {
	$sections = array(
		'left'   => farmart_get_option( 'mobile_header_left' ),
		'center' => farmart_get_option( 'mobile_header_center' ),
		'right'  => farmart_get_option( 'mobile_header_right' ),
	);

	echo '<div class="header-mobile">';

	foreach ( $sections as $section => $items ) {

		echo '<div class="header-items-mobile header-items-mobile--'. esc_attr( $section ) .'">';

			foreach ( (array)$items as $item ) {
				$item['item'] = $item['item'] ? $item['item'] : key( farmart_mobile_header_option() );
				farmart_mobile_header_item( $item['item'] );
			}

		echo '</div>';

	}

	echo '</div>';
}

add_action( 'farmart_header', 'farmart_show_header_mobile' );

/**
 * Show page header
 *
 * @since 1.0.0
 */
function farmart_show_page_header() {
	if ( ! farmart_get_page_header() ) {
		return;
	}

	if ( is_page_template( 'template-coming-soon-page.php' ) ) {
		return;
	}

	get_template_part( 'template-parts/page-headers' );
}

add_action( 'farmart_after_header', 'farmart_show_page_header', 20 );

/**
 * Display topbar on top of site v1
 *
 * @since 1.0.0
 */
function farmart_show_topbar() {
	if ( ! intval( farmart_get_option( 'topbar_enable' ) ) ) {
		return;
	}

	if ( is_active_sidebar( 'topbar-left' ) == false &&
	     is_active_sidebar( 'topbar-right' ) == false
	) {
		return '';
	}

	$classes = '';

	if ( intval( farmart_get_option( 'topbar_mobile' ) ) ) {
		$classes = 'enable-topbar-mobile';
	}

	?>
    <div id="topbar" class="topbar <?php echo esc_attr( $classes )?>">
		<div class="<?php echo esc_attr( farmart_get_option( 'header_width' ) ) ?>">
			<div class="topbar--item topbar--left">
				<?php
					if ( is_active_sidebar( 'topbar-left' ) ) {
						ob_start();
						dynamic_sidebar( 'topbar-left' );
						$output = ob_get_clean();

						echo apply_filters( 'farmart_topbar_left', $output );
					}
				?>
			</div>
			<div class="topbar--item topbar--right">
				<?php
					if ( is_active_sidebar( 'topbar-right' ) ) {
						ob_start();
						dynamic_sidebar( 'topbar-right' );
						$output = ob_get_clean();

						echo apply_filters( 'farmart_topbar_right', $output );
					}
				?>
			</div>
		</div>
    </div>
	<?php
}

add_action( 'farmart_before_header', 'farmart_show_topbar', 10 );

/**
 * Display topbar on mobile
 *
 * @since 1.0.0
 */
function farmart_show_topbar_mobile() {
	if ( ! intval( farmart_get_option( 'topbar_mobile' ) ) ) {
		return;
	}

	if ( is_active_sidebar( 'topbar-mobile' ) == false ) {
		return '';
	}

	?>
    <div id="topbar_mobile" class="topbar topbar-mobile">
		<div class="<?php echo esc_attr( farmart_get_option( 'header_width' ) ) ?>">
            <div class="topbar-mobile-content">
				<?php dynamic_sidebar( 'topbar-mobile' ); ?>
            </div>
        </div>

    </div>
	<?php
}

add_action( 'farmart_before_header', 'farmart_show_topbar_mobile', 20 );

/**
 * Display panel cart
 *
 *
 * @return void
 */
function modal_panel_cart() {
	if ( ! function_exists( 'WC' ) ) {
		return;
	}

	?>
	<div id="cart-panel" class="cart-panel cart-panel-mobile offscreen-panel <?php echo esc_attr( farmart_get_option('header_cart_side_type') === 'side-left' ? 'side-right' : 'side-left' );  ?> ">
		<div class="fm-off-canvas-layer"></div>
		<div class="box-cart-wrapper">
			<div class="box-cart-content">
				<div class="top-content">
					<div class="text-cart">
						<span class="title"><?php echo esc_html__( 'Shopping Cart', 'farmart' ); ?></span>
						<span class="mini-item-counter fm-mini-cart-counter"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
					</div>
					<span class="go-back">
						<?php echo farmart_get_option('header_cart_side_type') === 'side-left' ? Farmart\Icon::get_svg('arrow-right') : Farmart\Icon::get_svg('arrow-left'); ?>
					</span>
				</div>
				<div class="mini-cart-content">
					<div class="widget_shopping_cart_content">
						<?php woocommerce_mini_cart(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}

add_action( 'wp_footer', 'modal_panel_cart' );