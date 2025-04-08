<?php
/**
 * General template hooks.
 *
 * @package Farmart
 */

/**
 * Class of general template.
 */
class Farmart_WooCommerce_Template {
	/**
	 * Initialize.
	 */
	public static function init() {
		// Remove breadcrumb, use theme's instead
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

		// Add catalog ajax loader after #page
		add_action( 'farmart_before_header', array( __CLASS__, 'catalog_ajax_loader' ) );

		// Disable the default WooCommerce stylesheet.
		add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'farmart_woocommerce_scripts' ), 10 );
		add_filter( 'body_class', array( __CLASS__, 'body_class' ) );

		// Remove default WooCommerce wrapper.
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
		add_action( 'woocommerce_before_main_content', array( __CLASS__, 'wrapper_before' ) );
		add_action( 'woocommerce_after_main_content', array( __CLASS__, 'wrapper_after' ) );

		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash' );
		add_action( 'woocommerce_before_shop_loop_item_title', array( __CLASS__, 'product_ribbons' ) );

		// Orders account
		add_action( 'woocommerce_account_dashboard', 'woocommerce_account_orders', 5 );
		add_action( 'woocommerce_account_dashboard', 'woocommerce_account_edit_address', 15 );

		// Change position cross sell
		remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
		if ( intval( farmart_get_option( 'cross_sells_products' ) ) ) {
			add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display' );
		}

		// Change columns and total of cross sell
		add_filter( 'woocommerce_cross_sells_columns', array( __CLASS__, 'cross_sells_columns' ) );
		add_filter( 'woocommerce_cross_sells_total', array( __CLASS__, 'cross_sells_numbers' ) );

		// Wishlist
		add_filter( 'yith_wcwl_add_to_cart_label', array( __CLASS__, 'farmart_wishlist_add_to_cart_label' ) );

		add_action( 'yith_wcwl_before_wishlist_share', array( __CLASS__, 'farmart_before_wishlist_share' ), 50 );
		add_action( 'yith_wcwl_after_wishlist_share', array( __CLASS__, 'farmart_after_wishlist_share' ) );

		add_filter( 'yith_wcwl_loop_positions', array( __CLASS__, 'wcwl_loop_positions' ) );
		add_filter( 'yith_wcwl_button_icon', array( __CLASS__, 'wcwl_button_icon' ) );
		add_filter( 'yith_wcwl_button_added_icon', array( __CLASS__, 'wcwl_button_added_icon' ) );
		add_filter( 'yith_wcwl_remove_from_wishlist_label', array( __CLASS__, 'wcwl_remove_from_wishlist_label' ) );
		add_filter( 'yith_wcwl_add_to_wishlist_options', array( __CLASS__, 'replace_default_wishlist_label' ) );

		// Get login social
		add_action( 'woocommerce_login_form_end', array( __CLASS__, 'get_social_login' ) );
		if ( class_exists( 'NextendSocialLogin' ) ) {
			add_action( 'woocommerce_login_form_end', 'NextendSocialLogin::addLoginFormButtons' );
			add_action( 'woocommerce_register_form_end', 'NextendSocialLogin::addLoginFormButtons' );
		}

		// Custom Login Form Layout
		add_action( 'farmart_after_login_form', array( __CLASS__, 'login_form_promotion' ) );

		// Change star rating HTML.
		add_filter( 'woocommerce_get_star_rating_html', 'farmart_star_rating_html', 10, 3 );

		add_filter( 'woocommerce_shortcode_products_query', array(
			__CLASS__,
			'shortcode_products_orderby'
		), 20, 2 );
	}

	public static function farmart_woocommerce_scripts( ) {
		if ( wp_script_is( 'wc-add-to-cart-variation', 'registered' ) ) {
			wp_enqueue_script( 'wc-add-to-cart-variation' );
		}
		wp_enqueue_style(  'farmart-woocommerce-style', get_template_directory_uri() . '/woocommerce.css', array(), '20220204' );
		wp_add_inline_style( 'farmart-woocommerce-style', self::get_inline_style() );

		// Add js ajax add to cart
		wp_enqueue_script( 'wc-cart-fragments' );
	}

	/**
	 * Add 'woocommerce-active' class to the body tag.
	 *
	 * @param  array $classes CSS classes applied to the body tag.
	 *
	 * @return array $classes modified to include 'woocommerce-active' class.
	 */
	public static function body_class( $classes ) {
		$classes[] = 'woocommerce-active';

		if ( farmart_is_catalog() ) {
			$catalog_layout = farmart_get_option( 'catalog_layout' );
			$catalog_view   = isset( $_COOKIE['catalog_view'] ) ? $_COOKIE['catalog_view'] : farmart_get_option( 'catalog_type' )[0];
			$catalog_nav_class   = 'catalog-nav-' . farmart_get_option( 'catalog_nav_type' );

			$classes[] = 'catalog-view-' . apply_filters( 'farmart_catalog_view', $catalog_view );

			$classes[] = 'fm-catalog-page';
			$classes[] =  $catalog_layout;
			$classes[] = 'catalog-view-' . apply_filters( 'farmart_catalog_view', $catalog_view );
			$classes[] = apply_filters( 'farmart_catalog_nav_type_class', $catalog_nav_class );

			if ( farmart_get_catalog_full_width() ) {
				$classes[] = 'catalog-full-width';
			} else {
				$classes[] = 'catalog-standard';
			}

			if ( ! is_active_sidebar( 'catalog-sidebar' ) ) {
				$classes[] = 'catalog-full-content';
			} else {
				$classes[] = 'catalog-' . $catalog_layout;
			}

			if ( intval( farmart_get_option( 'catalog_ajax_filter' ) ) ) {
				$classes[] = 'catalog-ajax-filter';
			}
		} elseif ( function_exists( 'is_product' ) && is_product() ) {
			$product_layout = farmart_get_option( 'product_layout' );
			$classes[] = 'fm-product-layout-' . $product_layout;

			if ( intval( farmart_get_option( 'product_full_width' ) ) ) {
				$classes[] = 'fm-product-full-width';
			}

			$sticky_product = apply_filters( 'farmart_sticky_product_info', farmart_get_option( 'sticky_product_info' ) );
			if ( intval( $sticky_product ) ) {
				$classes[] = 'sticky-header-info';
			}
		}

		if ( function_exists( 'is_account_page' ) && is_account_page() ) {
			$classes[] = 'account-page-' . farmart_get_option( 'login_register_layout' );
		}

		if ( ! is_user_logged_in() ) {
			$classes[] = 'farmart-not-login';
		}

		return $classes;
	}

	public static function catalog_ajax_loader() {
		if ( ! farmart_is_catalog() ) {
			return;
		}

		if ( ! intval( farmart_get_option( 'catalog_ajax_filter' ) ) ) {
			return;
		}

		?>
		<div id="fm-catalog-ajax-loader" class="fm-catalog-ajax-loader fade-in"><div class="farmart-loading"></div></div>
		<?php
	}

	/**
	 * Before Content.
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 */
	public static function wrapper_before() {
		?>
		<div id="primary" class="content-area <?php farmart_content_columns(); ?>">
		<main id="main" class="site-main">
		<?php
	}

	/**
	 * After Content.
	 * Closes the wrapping divs.
	 */
	public static function wrapper_after() {
		?>
		</main><!-- #main -->
		</div><!-- #primary -->
		<?php
	}

	public static function product_ribbons() {
		global $product;

		$badges = farmart_get_option( 'catalog_badges_els' );

		if ( empty( $badges ) || !farmart_get_option( 'catalog_badges' ) ) {
			return;
		}
		$output              = array();
		$custom_badges       = maybe_unserialize( get_post_meta( $product->get_id(), 'custom_badges_text', true ) );

		if ( $custom_badges ) {

			$output[] = '<span class="custom ribbon">' . esc_html( $custom_badges ) . '</span>';

		} else {
			if ( ! $product->is_in_stock() && in_array( 'outofstock', $badges ) ) {
				$outofstock = farmart_get_option( 'catalog_badges_outofstock_text' );
				if ( ! $outofstock ) {
					$outofstock = esc_html__( 'Out Of Stock', 'farmart' );
				}
				$output[] = '<span class="out-of-stock ribbon">' . esc_html( $outofstock ) . '</span>';
			} elseif ( $product->is_on_sale() && in_array( 'sale', $badges ) ) {
				$percentage = 0;
				$save       = 0;
				if ( $product->get_type() == 'variable' ) {
					$available_variations = $product->get_available_variations();
					$percentage           = 0;
					$save                 = 0;

					for ( $i = 0; $i < count( $available_variations ); $i ++ ) {
						$variation_id     = $available_variations[ $i ]['variation_id'];
						$variable_product = new WC_Product_Variation( $variation_id );
						$regular_price    = $variable_product->get_regular_price();
						$sales_price      = $variable_product->get_sale_price();
						if ( empty( $sales_price ) ) {
							continue;
						}
						$max_percentage = $regular_price ? round( ( ( ( $regular_price - $sales_price ) / $regular_price ) * 100 ) ) : 0;
						$max_save       = $regular_price ? $regular_price - $sales_price : 0;

						if ( $percentage < $max_percentage ) {
							$percentage = $max_percentage;
						}

						if ( $save < $max_save ) {
							$save = $max_save;
						}
					}
				} elseif ( $product->get_type() == 'simple' || $product->get_type() == 'external' ) {
					$percentage = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );
					$save       = $product->get_regular_price() - $product->get_sale_price();
				}
				if ( $percentage ) {
					if ( ( time() - ( 60 * 60 * 24 * farmart_get_option( 'catalog_badges_product_newness' ) ) ) < strtotime( get_the_time( 'Y-m-d' ) ) && in_array( 'new', $badges ) ||
					     get_post_meta( $product->get_id(), '_is_new', true ) == 'yes'
					) {
						$new = farmart_get_option( 'catalog_badges_sale_text' );
						if ( ! $new ) {
							$new = esc_html__( 'Sale', 'farmart' );
						}
						$output[] = '<span class="onsale ribbon">' . esc_html( $new ) . '</span>';
					} else {
						$output[] = '<span class="onsale ribbon">' . $percentage . '% ' . esc_html__( 'off', 'farmart' ) . '</span>';
					}
				}

			} elseif ( $product->is_featured() && in_array( 'hot', $badges ) ) {
				$hot = farmart_get_option( 'catalog_badges_hot_text' );
				if ( ! $hot ) {
					$hot = esc_html__( 'Hot', 'farmart' );
				}
				$output[] = '<span class="featured ribbon">' . esc_html( $hot ) . '</span>';
			} elseif ( ( time() - ( 60 * 60 * 24 * farmart_get_option( 'catalog_badges_product_newness' ) ) ) < strtotime( get_the_time( 'Y-m-d' ) ) && in_array( 'new', $badges ) ||
			           get_post_meta( $product->get_id(), '_is_new', true ) == 'yes'
			) {
				$new = farmart_get_option( 'catalog_badges_new_text' );
				if ( ! $new ) {
					$new = esc_html__( 'New', 'farmart' );
				}
				$output[] = '<span class="newness ribbon">' . esc_html( $new ) . '</span>';
			}
		}

		if ( $output ) {
			echo sprintf( '<span class="ribbons">%s</span>', implode( '', $output ) );
		}
	}

	/**
	 * Get inline style
	 */
	public static function get_inline_style() {

		$inline_css = '';
		// Custom
		$custom_badges_bg    = farmart_get_option( 'catalog_badge_custom_bg_color' );
		$custom_badges_color = farmart_get_option( 'catalog_badge_custom_color' );

		if ( ! empty( $custom_badges_bg ) ) {
			$inline_css .= '.woocommerce .ribbons .ribbon.custom {background-color:' . $custom_badges_bg . ';}';
		}

		if ( ! empty( $custom_badges_color ) ) {
			$inline_css .= '.woocommerce .ribbons .ribbon.custom {color:' . $custom_badges_color . ';}';
		}

		// Hot
		$hot_bg_color = farmart_get_option( 'catalog_badges_hot_bg_color' );
		$hot_color    = farmart_get_option( 'catalog_badges_hot_color' );
		if ( ! empty( $hot_bg_color ) ) {
			$inline_css .= '.woocommerce .ribbons .ribbon.featured {background-color:' . $hot_bg_color . ';}';
		}

		if ( ! empty( $hot_color ) ) {
			$inline_css .= '.woocommerce .ribbons .ribbon.featured {color:' . $hot_color . ';}';
		}

		// Out of stock
		$outofstock_bg_color = farmart_get_option( 'catalog_badges_outofstock_bg_color' );
		$outofstock_color    = farmart_get_option( 'catalog_badges_outofstock_color' );

		if ( ! empty( $outofstock_bg_color ) ) {
			$inline_css .= '.woocommerce .ribbons .ribbon.out-of-stock {background-color:' . $outofstock_bg_color . ';}';
		}

		if ( ! empty( $outofstock_color ) ) {
			$inline_css .= '.woocommerce .ribbons .ribbon.out-of-stock {color:' . $outofstock_color . ';}';
		}

		// New
		$new_bg_color = farmart_get_option( 'catalog_badges_new_bg_color' );
		$new_color    = farmart_get_option( 'catalog_badges_new_color' );

		if ( ! empty( $new_bg_color ) ) {
			$inline_css .= '.woocommerce .ribbons .ribbon.newness {background-color:' . $new_bg_color . ';}';
		}

		if ( ! empty( $new_color ) ) {
			$inline_css .= '.woocommerce .ribbons .ribbon.newness {color:' . $new_color . ';}';
		}

		// Sale
		$sale_bg_color = farmart_get_option( 'catalog_badges_sale_bg_color' );
		$sale_color    = farmart_get_option( 'catalog_badges_sale_color' );

		if ( ! empty( $sale_bg_color ) ) {
			$inline_css .= '.woocommerce .ribbons .ribbon.onsale {background-color:' . $sale_bg_color . ';}';
		}

		if ( ! empty( $sale_color ) ) {
			$inline_css .= '.woocommerce .ribbons .ribbon.onsale {color:' . $sale_color . ';}';
		}

		// Single Product Buy Now Button
		$buy_now_button_color            = farmart_get_option( 'product_buy_now_color' );
		$buy_now_button_background_color = farmart_get_option( 'product_buy_now_bg_color' );

		if ( $buy_now_button_color ) {
			$inline_css .= '.woocommerce div.product form.cart .buy_now_button {color:' . $buy_now_button_color . ' !important;}';
		}

		if ( $buy_now_button_background_color ) {
			$inline_css .= '.woocommerce div.product form.cart .buy_now_button {background-color:' . $buy_now_button_background_color . ' !important;}';
		}

		// Catalog Banner
		if ( ( $padding_top = farmart_get_option( 'catalog_banners_margin_top' ) ) != 0 ) {
			$inline_css .= '.catalog-banners-carousel.banner-header-layout-' . farmart_get_option( 'catalog_header_layout' ) . '{ margin-top: '. $padding_top .'px }';
		}
		if ( ( $padding_bottom = farmart_get_option( 'catalog_banners_margin_bottom' ) ) != 0 ) {
			$inline_css .= '.catalog-banners-carousel.banner-header-layout-' . farmart_get_option( 'catalog_header_layout' ) . '{ margin-bottom: '. $padding_bottom .'px }';
		}

		return $inline_css;
	}

	/**
	 * Change number of columns when display cross sells products
	 *
	 * @param  int $cross_columns
	 *
	 * @return int
	 */
	public static function cross_sells_columns( $cross_columns ) {
		return intval( farmart_get_option( 'cross_sells_products_columns' ) );
	}

	/**
	 * Change number of columns when display cross sells products
	 *
	 * @param  int $cross_numbers
	 *
	 * @return int
	 */
	public static function cross_sells_numbers( $cross_numbers ) {
		return intval( farmart_get_option( 'cross_sells_products_numbers' ) );
	}

	// Wishlist

	public static function farmart_before_wishlist_share() {
		echo '<div class="socials-with-background socials-with-content">';
	}

	public static function farmart_after_wishlist_share() {
		echo '</div>';
	}

	public static function farmart_wishlist_add_to_cart_label( $label ) {
		global $product;
		if ( $product->get_stock_status() == 'outofstock' || $product->get_type() == 'grouped' ) {

			$label = esc_html__( 'Read More', 'farmart' );
		}

		if ( $product->get_type() == 'external' ) {
			$label = esc_html__( 'Buy Product', 'farmart' );
		}

		return $label;
	}

	public static function wcwl_loop_positions() {
		return 'shortcode';
	}

	public static function wcwl_button_icon( $icon ) {
		if ( ! $icon ) {
			$icon = 'icon-heart';
		}

		return $icon;
	}

	public static function wcwl_button_added_icon( $icon ) {
		if ( ! $icon ) {
			$icon = 'fa-heart';
		}

		return $icon;
	}

	public static function wcwl_remove_from_wishlist_label( $label ) {
		$label = esc_html__( 'Remove', 'farmart' );

		return $label;
	}

	public static function replace_default_wishlist_label( $options ) {
		$options['add_to_wishlist']['add_to_wishlist_text']['default'] = esc_html__( 'Wishlist', 'farmart' );
		$options['add_to_wishlist']['browse_wishlist_text']['default'] = esc_html__( 'Wishlist', 'farmart' );

		return $options;
	}

	public static function get_social_login() {
		if ( ! shortcode_exists( 'nextend_social_login' ) ) {
			return;
		}

		echo sprintf(
			'<div class="fm-social-login">
			<div class="login-text">%s</div>
			</div>',
			esc_html__('Or login width', 'farmart')
		);
	}

	public static function login_form_promotion() {
		if ( farmart_get_option( 'login_register_layout' ) != 'promotion' ) {
			return;
		}

		$output    = array();
		$pro_title = farmart_get_option( 'login_promotion_title' );
		if ( ! empty( $pro_title ) ) {
			$output[] = sprintf( '<h2 class="pro-title">%s</h2>', $pro_title );
		}
		$pro_text = farmart_get_option( 'login_promotion_text' );
		if ( ! empty( $pro_text ) ) {
			$output[] = sprintf( '<p class="pro-text">%s</p>', $pro_text );
		}
		$pro_list = farmart_get_option( 'login_promotion_list' );
		if ( ! empty( $pro_list ) ) {
			$output[] = sprintf( '<div class="pro-list">%s</div>', $pro_list );
		}
		$ads_title = farmart_get_option( 'login_ads_title' );
		$ads_text  = farmart_get_option( 'login_ads_text' );

		if ( ! empty( $ads_title ) || ! empty( $ads_text ) ) {
			$output[] = '<div class="promotion-ads-content">';
			if ( ! empty( $ads_title ) ) {
				$output[] = sprintf( '<h2 class="promotion-ads-title">%s</h2>', $ads_title );
			}
			if ( ! empty( $ads_text ) ) {
				$output[] = sprintf( '<div class="promotion-ads-text">%s</div>', $ads_text );
			}
			$output[] = '</div>';
		}

		if ( ! empty( $output ) ) {
			echo sprintf( '<div class="col-md-6 col-sm-12 col-md-offset-1 col-login-promotion"><div class="login-promotion">%s</div></div>', implode( ' ', $output ) );
		}
	}

	/**
	 * Changes shortcode products orderby
	 *
	 * @since 1.0.0
	 *
	 * @param array $args The query.
	 * @param array $attributes The attributes.
	 *
	 * @return array
	 */
	public static function shortcode_products_orderby( $args, $attributes ) {
		if ( ! empty( $attributes['class'] ) ) {
			$classes = explode( ',', $attributes['class'] );

			if ( in_array( 'sc_brand', $classes ) ) {
				$args['tax_query'][] = array(
					'taxonomy' => 'product_brand',
					'terms'    => array_map( 'sanitize_title', $classes ),
					'field'    => 'slug',
					'operator' => 'IN',
				);
			}

			if ( in_array( 'sc_collection', $classes ) ) {
				$args['tax_query'][] = array(
					'taxonomy' => 'product_collection',
					'terms'    => array_map( 'sanitize_title', $classes ),
					'field'    => 'slug',
					'operator' => 'IN',
				);
			}
		}

		return $args;
	}
}
