<?php
/**
 * Template Product hooks.
 *
 * @package Farmart
 */

/**
 * Class of general template.
 */
class Farmart_WooCommerce_Template_Product {
	/**
	 * Initialize.
	 */
	public static function init() {
		add_action( 'template_redirect', array( __CLASS__, 'track_product_view' ) );

		add_action( 'wc_ajax_farmart_fbt_add_to_cart', array( __CLASS__, 'fbt_add_to_cart' ) );

		add_filter( 'post_class', array( __CLASS__, 'product_class' ), 20, 3 );

		// Layout
		add_action( 'woocommerce_before_single_product_summary', array( __CLASS__, 'wrapper_before_summary' ), 5 );
		add_action( 'woocommerce_after_single_product_summary', array( __CLASS__, 'wrapper_after_summary' ), 5 );

		add_action( 'woocommerce_after_single_product_summary', array( __CLASS__, 'wrapper_open_after_summary' ), 5 );
		add_action( 'woocommerce_after_single_product_summary', array(
			__CLASS__,
			'wrapper_close_after_summary'
		), 999 );

		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );

		add_action( 'woocommerce_single_product_summary', array(
			__CLASS__,
			'woocommerce_get_unit_price_box'
		), 10 );
		add_action( 'woocommerce_single_product_summary', array(
			__CLASS__,
			'woocommerce_get_stock_html'
		), 15 );
		// Change availability text in single product
		add_filter( 'woocommerce_get_availability_text', array( __CLASS__, 'get_product_availability_text' ), 20, 2 );

		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
		add_action( 'woocommerce_single_product_summary', array( __CLASS__, 'woocommerce_get_entry_meta' ), 40 );

		add_action( 'woocommerce_before_add_to_cart_button', array( __CLASS__, 'open_button_group' ), 10 );
		add_action( 'woocommerce_before_single_product', array( __CLASS__, 'group_elements' ), 10 );
		add_action( 'woocommerce_after_add_to_cart_button', array( __CLASS__, 'button_group' ), 50 );
		add_action( 'woocommerce_after_add_to_cart_button', array( __CLASS__, 'close_action_button' ), 70 );
		add_action( 'woocommerce_after_add_to_cart_button', array( __CLASS__, 'close_button_group' ), 100 );

		add_filter( 'yith_wcwl_show_add_to_wishlist', '__return_empty_string' );
		add_filter( 'woocommerce_better_compare_show_add_to_compare_button', '__return_empty_string' );

		add_filter( 'woocommerce_single_product_zoom_enabled', array( __CLASS__, 'single_product_zoom_enabled' ) );

		// Instagram
		add_action( 'woocommerce_after_single_product_summary', array( __CLASS__, 'product_instagram_photos' ), 12 );

		add_action( 'woocommerce_after_single_product_summary', array( __CLASS__, 'fbt_product' ), 5 );

		add_filter( 'woocommerce_add_to_cart_redirect', array( __CLASS__, 'buy_now_redirect' ), 99 );

		add_filter( 'woocommerce_product_description_heading', '__return_null' );

		if ( farmart_get_product_layout() == '1' ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 4 );

			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );

			add_action(
				'woocommerce_single_product_summary', array(
				__CLASS__,
				'open_single_product_summary_content'
			), 1
			);
			add_action(
				'woocommerce_single_product_summary', array(
				__CLASS__,
				'close_single_product_summary_content'
			), 70
			);

			add_action(
				'woocommerce_single_product_summary', array(
				__CLASS__,
				'open_single_product_summary_sidebar'
			), 100
			);
			add_action(
				'woocommerce_single_product_summary', array(
				__CLASS__,
				'close_single_product_summary_sidebar'
			), 100
			);
		}

		if ( farmart_get_product_layout() == '2' || farmart_get_product_layout() == '3' || farmart_get_product_layout() == '4' ) {
			add_action( 'woocommerce_single_product_summary', array( __CLASS__, 'single_product_socials' ), 40 );
		}

		if ( farmart_get_product_layout() == '4' ) {
			add_action( 'woocommerce_single_product_summary', array( __CLASS__, 'woocommerce_template_single_breadcrumb'), 3 );

			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );

			remove_action( 'woocommerce_single_product_summary', array(
				__CLASS__,
				'woocommerce_get_unit_price_box'
			), 10 );
			add_action( 'woocommerce_single_product_summary', array(
				__CLASS__,
				'woocommerce_get_unit_price_box'
			), 9 );

			add_action(
				'woocommerce_single_product_summary', array(
				__CLASS__,
				'open_single_product_summary_content'
			), 1
			);
			add_action(
				'woocommerce_single_product_summary', array(
				__CLASS__,
				'close_single_product_summary_content'
			), 70
			);

			add_action(
				'woocommerce_single_product_summary', array(
				__CLASS__,
				'open_single_product_summary_sidebar'
			), 100
			);
			add_action(
				'woocommerce_single_product_summary', array(
				__CLASS__,
				'close_single_product_summary_sidebar'
			), 100
			);
		}

		add_filter( 'woocommerce_product_thumbnails_columns', array( __CLASS__, 'get_product_thumbnails_columns' ) );

		// Add single product header
		add_action( 'woocommerce_before_single_product_summary', array( __CLASS__, 'single_product_header' ), 9 );
		add_action( 'woocommerce_single_product_summary', array( __CLASS__, 'single_product_entry_header' ), 8 );

		// Change template qty
		add_action( 'woocommerce_before_quantity_input_field', array( __CLASS__, 'open_template_qty' ), 10 );
		add_action( 'woocommerce_after_quantity_input_field', array( __CLASS__, 'close_template_qty' ), 10 );

		// single product deal
		add_filter( 'tawc_deals_l10n_text', array( __CLASS__, 'fm_deals_l10n_text' ) );
		add_filter( 'tawc_deals_expire_text', array( __CLASS__, 'fm_deals_expire_text' ) );
		add_filter( 'tawc_deals_sold_text', array( __CLASS__, 'fm_deals_sold_text' ) );

		// Review Section
		remove_action( 'woocommerce_review_before_comment_meta', 'woocommerce_review_display_rating', 10 );
		add_action( 'woocommerce_review_meta', 'woocommerce_review_display_rating', 30 );

		// Remove Up-Seller & Related Product
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
		add_action( 'woocommerce_after_single_product_summary', array( __CLASS__, 'products_full_width_upsell' ), 5 );
		add_action( 'farmart_before_footer', array( __CLASS__, 'products_upsell_display' ), 10 );
		add_action( 'farmart_before_footer', array( __CLASS__, 'related_products_output' ), 15 );
		add_filter( 'woocommerce_upsells_total', array( __CLASS__, 'upsells_total' ) );

		// Related options
		add_filter( 'woocommerce_product_related_posts_relate_by_category', array(
			__CLASS__,
			'related_posts_relate_by_category'
		) );
		add_filter( 'woocommerce_get_related_product_cat_terms', array(
			__CLASS__,
			'related_posts_relate_by_parent_category'
		), 20, 2 );
		add_filter( 'woocommerce_product_related_posts_relate_by_tag', array(
			__CLASS__,
			'related_posts_relate_by_tag'
		) );

		// Quick View
		add_action( 'farmart_before_single_product_quickview_summary', 'woocommerce_show_product_images', 20 );
		add_action( 'farmart_before_quickview_product', array( __CLASS__, 'group_elements' ), 10 );
		add_action( 'farmart_single_product_quickview_summary', array(
			__CLASS__,
			'get_quickview_product_header'
		), 10 );
		add_action( 'farmart_single_product_quickview_summary', 'woocommerce_template_single_price', 15 );
		add_action( 'farmart_single_product_quickview_summary', 'woocommerce_template_single_excerpt', 20 );
		add_action( 'farmart_single_product_quickview_summary', 'woocommerce_template_single_add_to_cart', 30 );
		remove_action( 'farmart_single_product_quickview_summary', 'woocommerce_template_single_meta', 40 );
		add_action( 'farmart_single_product_quickview_summary', array( __CLASS__, 'single_product_socials' ), 40 );
		add_action( 'farmart_single_product_quickview_summary', array(
			__CLASS__,
			'template_single_summary_header'
		), 15 );

		// Sticky Product
		add_action( 'wp_footer', array( __CLASS__, 'sticky_product_info' ) );
	}

	/**
	 * Add classes for product
	 *
	 * @since 1.0
	 *
	 * @param array $classes
	 * @param string $class
	 * @param string $post_id
	 *
	 * @return array
	 */
	public static function product_class( $classes, $class = '', $post_id = '' ) {
		if( intval( farmart_get_option('product_add_to_cart_ajax') ) ) {
			$classes[] = 'add-to-cart-ajax';
		}

		return $classes;
	}

	/**
	 * Track product views.
	 */
	public static function track_product_view() {
		if ( ! is_singular( 'product' ) ) {
			return;
		}

		global $post;

		if ( empty( $_COOKIE['woocommerce_recently_viewed'] ) ) {
			$viewed_products = array();
		} else {
			$viewed_products = (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] );
		}

		if ( ! in_array( $post->ID, $viewed_products ) ) {
			$viewed_products[] = $post->ID;
		}

		if ( sizeof( $viewed_products ) > 15 ) {
			array_shift( $viewed_products );
		}

		// Store for session only
		wc_setcookie( 'woocommerce_recently_viewed', implode( '|', $viewed_products ), time() + 60 * 60 * 24 * 30 );
	}

	/**
	 * Before Summary
	 *
	 * @return void
	 */
	public static function wrapper_before_summary() {
		global $product;

		$classes = 'fm-product-thumbnail-' . farmart_get_option( 'product_thumbnail_layout' );

		$video_image = get_post_meta( $product->get_id(), 'video_thumbnail', true );
		if ( $product->get_gallery_image_ids() || $video_image ) {
			$classes .= ' has-gallery-image';
		}

		if ( intval( farmart_get_option( 'product_buy_now' ) ) && $product->get_type() != 'external' ) {
			$classes .= ' enable-buy-now';
		}

		if ( ! $product->managing_stock() && ! $product->is_in_stock() ) {
			$classes .= ' has-out-of-stock';
		}

		if ( intval( farmart_get_option( 'product_full_width' ) ) ) {
			$classes .= ' fm-product-bg-full-width';
		}

		?>
        <div class="fm-product-detail clearfix <?php echo esc_attr( $classes ) ?>">
		<?php

		$layout = farmart_get_product_layout();
		if ( in_array( $layout, array( '1', '4') ) && intval( farmart_get_option( 'product_full_width' ) ) ) {
			echo '<div class="farmart-container">';
		}

	}

	/**
	 * After Summary
	 *
	 * @return void
	 */
	public static function wrapper_after_summary() {
		?>
        </div>
		<?php

		$layout = farmart_get_product_layout();
		if ( in_array( $layout, array( '1', '4') ) && intval( farmart_get_option( 'product_full_width' ) ) ) {
			echo '</div>';
		}
	}

	/**
	 * Before Summary
	 *
	 * @return void
	 */
	public static function wrapper_open_after_summary() {
		?>
        <div class="fm-product-summary">
		<?php
	}

	/**
	 * After Summary
	 *
	 * @return void
	 */
	public static function wrapper_close_after_summary() {
		?>
        </div>
		<?php
	}

	public static function open_single_product_summary_content() {
		$class = ! is_active_sidebar( 'product-sidebar' ) ? 'without-sidebar' : '';
		echo '<div class="entry-summary-content ' . esc_attr( $class ) . '">';
	}

	public static function close_single_product_summary_content() {
		echo '</div>';
	}

	/**
	 * Wrap button group
	 * Open a div
	 *
	 * @since 1.0
	 */
	public static function open_button_group() {
		echo '<div class="single-button-wrapper">';
	}

	/**
	 * Wrap button group
	 * Close a div
	 *
	 * @since 1.0
	 */
	public static function close_button_group() {
		echo '</div>';
	}

	/**
	 * Before Summary
	 *
	 * @return void
	 */
	public static function open_single_product_summary_sidebar() {
		?>
        <div class="entry-summary-sidebar product-sidebar">
		<?php

		ob_start();
		if ( is_active_sidebar( 'product-sidebar' ) ) {
			dynamic_sidebar( 'product-sidebar' );
		}
		$output = ob_get_clean();

		echo apply_filters( "farmart_product_sidebar", $output );
	}

	/**
	 * After Summary
	 *
	 * @return void
	 */
	public static function close_single_product_summary_sidebar() {
		?>
        </div>
		<?php
	}

	/**
	 * Add Breadcrumb product layout 4
	 *
	 * @return void
	 */
	public static function woocommerce_template_single_breadcrumb() {
		farmart_breadcrumbs(
			array(
				'taxonomy' => function_exists( 'is_woocommerce' ) && is_woocommerce() ? 'product_cat' : 'category',
			)
		);
	}

	public static function single_product_zoom_enabled() {
		return farmart_get_option( 'product_images_zoom' );
	}

	public static function button_group() {

		echo '<div class="group-buttons">';
		self::yith_button();
		echo '<div class="divider"></div>';
		self::compare_button();
		echo '</div>';
	}

	/**
	 * Display wishlist button
	 *
	 * @since 1.0
	 */
	public static function yith_button() {

		if ( shortcode_exists( 'wcboost_wishlist_button' ) ) {
			echo '<div class="fm-wishlist-button">';
				echo do_shortcode( '[wcboost_wishlist_button]' );
			echo '</div>';
		} else if ( shortcode_exists( 'yith_wcwl_add_to_wishlist' ) ) {
			echo '<div class="fm-wishlist-button">';
				echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
			echo '</div>';
		}
	}

	/**
	 * Display compare button
	 *
	 * @since 1.0
	 */
	public static function compare_button() {
		if ( get_option( 'yith_woocompare_compare_button_in_product_page', 'yes' ) == 'no' ) {
			return;
		}

		Farmart_WooCommerce_Template_Catalog::product_compare();
	}

	/**
	 * Product thumbnails columns
	 *
	 * @return int
	 */
	public static function get_product_thumbnails_columns() {
		return intval( farmart_get_option( 'product_thumbnail_numbers' ) );
	}

	/**
	 * Add single product header
	 */
	public static function single_product_entry_header() {
		$layout = farmart_get_product_layout();
		if ( ! in_array( $layout, array( '2', '3', '4') ) ) {
			return;
		}

		if ( in_array( $layout, array( '4') ) ) {
			echo '<div class="fm-header-vendor">'. self::get_sold_by_vendor() .'</div>';
		}

		self::get_single_product_header( $layout );
	}

	/**
	 * Add single product header
	 */
	public static function single_product_header() {
		$layout = farmart_get_product_layout();
		if ( ! in_array( $layout, array( '1') ) ) {
			return;
		}
		self::get_single_product_header( $layout );
	}

	/**
	 * Add single product header
	 */
	public static function get_single_product_header( $layout ) {
		?>

        <div class="fm-entry-product-header">
            <div class="entry-left">
				<?php
				if ( function_exists( 'woocommerce_template_single_title' ) ) {
					woocommerce_template_single_title();
				}
				?>

                <ul class="entry-meta">
					<?php

					global $product;
					if ( function_exists( 'woocommerce_template_single_rating' ) && $product->get_rating_count() ) {
						echo '<li>';
						woocommerce_template_single_rating();
						echo '</li>';
					}
					if ( ! in_array( $layout, array( '4' ) ) ) {
						self::single_product_sku();
					}
					?>

                </ul>
            </div>
			<?php
			if ( in_array( $layout, array( '1', '5' ) ) ) {
				self::single_product_socials();
			}

			do_action( 'farmart_after_single_product_header' );
			?>
        </div>
		<?php
	}

	/**
	 * Get product SKU
	 */
	public static function single_product_socials() {

		if ( ! function_exists( 'farmart_addons_share_link_socials' ) ) {
			return;
		}
		if ( ! intval( farmart_get_option( 'show_product_socials' ) ) ) {
			return;
		}

		$image   = get_the_post_thumbnail_url( get_the_ID(), 'full' );
		$socials = farmart_get_option( 'product_social_icons' );
		echo '<div class="product_socials socials-with-background">';
		echo farmart_addons_share_link_socials( $socials, get_the_title(), get_the_permalink(), $image, true );
		echo '</div>';

	}

	/**
	 * Open template qty
	 */
	public static function open_template_qty() {

		echo '<label class="label">' . esc_html__( 'Quantity:', 'farmart' ) . '</label>';
		echo '<div class="qty-box">';
		echo Farmart\Icon::get_svg( 'minus', 'decrease' );
	}

	/**
	 * Close template qty
	 */
	public static function close_template_qty() {

		echo Farmart\Icon::get_svg( 'plus', 'increase' );
		echo '</div>';
	}

	public static function fm_deals_l10n_text( $deals ) {
		if ( is_product() ) {
			$deals = array(
				'days'    => esc_html__( 'days', 'farmart' ),
				'hours'   => esc_html__( 'hours', 'farmart' ),
				'minutes' => esc_html__( 'mins', 'farmart' ),
				'seconds' => esc_html__( 'secs', 'farmart' ),
			);
		}

		return $deals;
	}

	public static function fm_deals_expire_text( $text ) {
		$text = '<strong>' . esc_html__( 'Hurry up!', 'farmart' ) . '</strong>' . esc_html__( ' Sale end in ', 'farmart' );

		return $text;
	}

	public static function fm_deals_sold_text( $text ) {
		$text = esc_html__( 'Sold:', 'farmart' );

		return $text;
	}

	/**
	 * AJAX add to cart.
	 */
	public static function fbt_add_to_cart() {
		$product_ids = $_POST['product_ids'];
		$quantity    = 1;
		$product_ids = explode( ',', $product_ids );
		if ( is_array( $product_ids ) ) {
			foreach ( $product_ids as $product_id ) {
				if ( $product_id == 0 ) {
					continue;
				}
				$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );
				$product_status    = get_post_status( $product_id );

				if ( $passed_validation && false !== WC()->cart->add_to_cart( $product_id, $quantity ) && 'publish' === $product_status ) {

					do_action( 'woocommerce_ajax_added_to_cart', $product_id );

					if ( 'yes' === get_option( 'woocommerce_cart_redirect_after_add' ) ) {
						wc_add_to_cart_message( array( $product_id => $quantity ), true );
					}


				} else {

					// If there was an error adding to the cart, redirect to the product page to show any errors
					$data = array(
						'error'       => true,
						'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id ),
					);

					wp_send_json( $data );
				}
			}
		}
	}

	/**
	 * Get Unit Text Box
	 */
	public static function woocommerce_get_unit_price_box() {
		global $product;
		$unit_text = maybe_unserialize( get_post_meta( $product->get_id(), 'custom_unit_price', true ) );

		if ( $unit_text ) {
			echo '<div class="unit-text">' . $unit_text . '</div>';
		}
	}

	/**
	 * Get Stock Html
	 */
	public static function woocommerce_get_stock_html() {
		global $product;

		if ( $product->get_type() != 'simple' ) {
			return;
		}

		echo '<div class="fm-stock">' . wc_get_stock_html( $product ) . '</div>';
	}

	/**
	 * Get Stock Availability Text
	 */
	public static function get_product_availability_text( $availability, $product ) {

		if ( $product->get_type() != 'simple' ) {
			return $availability;
		}

		if ( ! $product->managing_stock() && $product->get_stock_status() == 'instock' ) {
			$availability = esc_html__( 'In stock', 'farmart' );
		}

		return $availability;
	}

	/**
	 * Get Entry Meta
	 */
	public static function woocommerce_get_entry_meta() {
		global $product;

		$terms = get_the_terms( $product->get_id(), 'product_brand' );

		$meta_brand = '';

		if ( ! is_wp_error( $terms ) && $terms ) {
			$meta_brand = sprintf(
				'<div class="meta meta-brand">%s
                    <a href="%s" class="meta-value">%s</a>
                </div>',
				apply_filters( 'farmarts_product_brand_text', esc_html__( 'Brand:', 'farmart' ) ),
				esc_url( get_term_link( $terms[0] ), 'product_brand' ),
				esc_html( $terms[0]->name )

			);
		}

		$metas = $meta_brand . self::get_sold_by_vendor();
		if ( farmart_get_product_layout() == '4' ) {
			$metas .= self::single_product_sku();
		}

		echo sprintf(
			'<div class="fm-entry-meta">
                  %s
                  <div class="meta meta-category">%s</div>
                  <div class="meta meta-tags">%s</div>
                </div>',
			$metas,
			wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'farmart' ) . ' ', '</span>' ),
			wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'farmart' ) . ' ', '</span>' )
		);
	}


	/**
	 * Get sold by vendor
	 */
	public static function get_sold_by_vendor() {

		if ( ! intval( farmart_get_option( 'single_product_sold_by' ) ) ) {
			return;
		}

		global $product;
		$output = $sold_by_label = $sold_by_name = '';
		if ( function_exists( 'dokan_get_store_url' ) ) {
			$author_id = get_post_field( 'post_author', $product->get_id() );
			$author    = get_user_by( 'id', $author_id );
			$shop_info = get_user_meta( $author_id, 'dokan_profile_settings', true );
			$shop_name = $author->display_name;
			if ( $shop_info && isset( $shop_info['store_name'] ) && $shop_info['store_name'] ) {
				$shop_name = $shop_info['store_name'];
			}

			$sold_by_label = esc_html__( 'Vendor: ', 'farmart' );
			$sold_by_name  = '<a href="' . esc_url( dokan_get_store_url( $author_id ) ) . '">' . $shop_name . '</a>';
		}

        elseif ( class_exists( 'WCFMmp' ) ) {
			global $WCFM, $post;

			$vendor_id    = $WCFM->wcfm_vendor_support->wcfm_get_vendor_id_from_product( $post->ID );
			$sold_by_text = apply_filters( 'wcfmmp_sold_by_label', esc_html__( 'Vendor: ', 'farmart' ) );
			$store_name   = $WCFM->wcfm_vendor_support->wcfm_get_vendor_store_by_vendor( absint( $vendor_id ) );

			$sold_by_label = $sold_by_text;
			$sold_by_name  = $store_name;
		}

		$output = sprintf(
			'<div class="meta meta-sold-by">' .
			'%s' .
			'%s' .
			'</div>',
			$sold_by_label,
			$sold_by_name
		);

		return $output;
	}

	/**
	 * Wrap button group
	 * Open a div
	 *
	 * @since 1.0
	 */
	public static function open_action_button() {
		if ( farmart_get_product_layout() == '4' ) {
			return;
		}

		echo '<div class="action-buttons">';
	}

	/**
	 * Wrap button group
	 * Close a div
	 *
	 * @since 1.0
	 */
	public static function close_action_button() {
		if ( farmart_get_product_layout() == '4' ) {
			return;
		}

		echo '</div>';
	}

	/**
	 * Wrap button box
	 * Open a div
	 *
	 * @since 1.0
	 */
	public static function open_button_box() {
		echo '<div class="buttons-box">';
	}

	/**
	 * Wrap button box
	 * Close a div
	 *
	 * @since 1.0
	 */
	public static function close_button_box() {
		echo '</div>';
	}

	/**
	 * @since 1.0
	 */
	public static function group_elements() {
		global $product;

		if ( $product->get_type() == 'grouped' || $product->get_type() == 'external' ) {
			add_action( 'woocommerce_before_add_to_cart_button', array( __CLASS__, 'open_action_button' ), 10 );
			add_action( 'woocommerce_before_add_to_cart_button', array( __CLASS__, 'open_button_box' ), 10 );
			add_action( 'woocommerce_before_add_to_cart_button', array( __CLASS__, 'product_vendor_button' ), 10 );
			add_action( 'woocommerce_before_add_to_cart_button', array( __CLASS__, 'product_buy_now_button' ), 20 );
			add_action( 'woocommerce_after_add_to_cart_button', array( __CLASS__, 'close_button_box' ), 45 );

		} else {
			add_action( 'woocommerce_after_add_to_cart_quantity', array( __CLASS__, 'open_action_button' ), 10 );
			add_action( 'woocommerce_after_add_to_cart_quantity', array( __CLASS__, 'open_button_box' ), 10 );
			add_action( 'woocommerce_after_add_to_cart_quantity', array( __CLASS__, 'product_vendor_button' ), 10 );
			add_action( 'woocommerce_after_add_to_cart_quantity', array( __CLASS__, 'product_buy_now_button' ), 20 );
			add_action( 'woocommerce_after_add_to_cart_button', array( __CLASS__, 'close_button_box' ), 45 );
		}
	}

	/**
	 * Display button vendor
	 *
	 * @since 1.0
	 */
	public static function product_vendor_button() {
		if ( ! intval( farmart_get_option( 'single_product_sold_by' ) ) ) {
			return;
		}

		global $product;
		$sold_by_url = '';
		if ( function_exists( 'dokan_get_store_url' ) ) {
			$author_id = get_post_field( 'post_author', $product->get_id() );
			$sold_by_url  = esc_url( dokan_get_store_url( $author_id ) );
		}

        elseif ( class_exists( 'WCFMmp' ) ) {
			global $WCFM, $post;

			$vendor_id    = $WCFM->wcfm_vendor_support->wcfm_get_vendor_id_from_product( $post->ID );
			$shop_link     = wcfmmp_get_store_url( $vendor_id );
			$sold_by_url   = apply_filters( 'wcfmmp_vendor_shop_permalink', $shop_link, $vendor_id );
		}

		echo sprintf(
			'<div class="button-vendor">
			<a href="%s">%s</i>%s</a>
			</div>',
			$sold_by_url,
			Farmart\Icon::get_svg( 'store', '', 'shop' ),
			esc_html__('Store', 'farmart')
		);
	}

	/**
	 * Display buy now button
	 *
	 * @since 1.0
	 */
	public static function product_buy_now_button() {
		global $product;
		if ( ! intval( farmart_get_option( 'product_buy_now' ) ) ) {
			return;
		}

		if ( $product->get_type() == 'external' ) {
			return;
		}

		echo sprintf( '<button class="buy_now_button button">%s %s</button>', Farmart\Icon::get_svg( 'power' ), farmart_get_option( 'product_buy_now_text' ) );
	}

	public static function buy_now_redirect( $url ) {

		if ( ! isset( $_REQUEST['buy_now'] ) || $_REQUEST['buy_now'] == false ) {
			return $url;
		}

		if ( empty( $_REQUEST['quantity'] ) ) {
			return $url;
		}

		if ( is_array( $_REQUEST['quantity'] ) ) {
			$quantity_set = false;
			foreach ( $_REQUEST['quantity'] as $item => $quantity ) {
				if ( $quantity <= 0 ) {
					continue;
				}
				$quantity_set = true;
			}

			if ( ! $quantity_set ) {
				return $url;
			}
		}


		$redirect = farmart_get_option( 'product_buy_now_link' );
		if ( empty( $redirect ) ) {
			return wc_get_checkout_url();
		} else {
			wp_safe_redirect( $redirect );
			exit;
		}
	}

	/**
	 * Frequently Bought Together
	 */
	public static function fbt_product() {
		global $product;
		if ( ! intval( farmart_get_option( 'product_fbt' ) ) ) {
			return;
		}

		$product_ids = maybe_unserialize( get_post_meta( $product->get_id(), 'fm_pbt_product_ids', true ) );
		$product_ids = apply_filters( 'farmart_pbt_product_ids', $product_ids, $product );
		if ( empty( $product_ids ) || ! is_array( $product_ids ) ) {
			return;
		}


		$current_product = array( $product->get_id() );
		$product_ids     = array_merge( $current_product, $product_ids );
		$title           = farmart_get_option( 'product_fbt_title' );
		$columns         = farmart_get_option( 'product_fbt_columns' );

		$total_price = 0;

		$containerWidth = farmart_get_option( 'product_full_width' );

		$classes = intval( farmart_get_option( 'product_full_width' ) ) ? 'fm-product-bg-full-width' : '';

		?>
        <div class="fm-product-fbt <?php echo esc_attr( $classes ) ?>" id="fm-product-fbt">
			<?php if ( intval( $containerWidth ) ) : ?>
					<div class="farmart-container">
			<?php endif; ?>
				<h3 class="fbt-title"><?php echo esc_html( $title ); ?></h3>
				<div class="fbt-box fbt-columns-<?php echo esc_attr( $columns ) ?>">
					<ul class="products">
						<?php
						$dupplicate_id = 0;
						foreach ( $product_ids as $product_id ) {
							$product_id = apply_filters( 'wpml_object_id', $product_id, 'product' );
							$item       = wc_get_product( $product_id );
							$price_html = $item->get_price_html();

							if ( empty( $item ) ) {
								continue;
							}

							if ( $item->is_type( 'variable' ) ) {
								$key = array_search( $product_id, $product_ids );
								if ( $key !== false ) {
									unset( $product_ids[ $key ] );
								}
								continue;
							}

							if ( $item->get_stock_status() == 'outofstock' ) {
								$key = array_search( $product_id, $product_ids );
								if ( $key !== false ) {
									unset( $product_ids[ $key ] );
								}
								continue;
							}

							$unit_text = maybe_unserialize( get_post_meta( $item->get_id(), 'custom_unit_price', true ) );

							$rating_count = $item->get_rating_count();
							$average      = $item->get_average_rating();
							$label        = sprintf( esc_html__( 'Rated %s out of 5', 'farmart' ), $average );

							$data_id = $item->get_id();
							if ( $item->get_parent_id() > 0 ) {
								$data_id = $item->get_parent_id();
							}
							$total_price += $item->get_price();

							$product_name = $item->get_title() . self::fbt_product_variation( $item );
							?>
							<li class="product" data-id="<?php echo esc_attr( $data_id ); ?>"
								id="fbt-product-<?php echo esc_attr( $item->get_id() ); ?>">
								<div class="product-content">
									<a class="thumbnail" href="<?php echo esc_url( $item->get_permalink() ) ?>">
										<?php echo farmart_get_image_html( $item->get_image_id(), 'shop_catalog' ); ?>
									</a>

									<?php echo self::get_sold_by_vendor() ?>

									<h3 class="woocommerce-loop-product__title">
										<a href="<?php echo esc_url( $item->get_permalink() ) ?>">
											<?php echo esc_html( $product_name ); ?>
										</a>
									</h3>

									<div class="fm-rating">
										<div class="star-rating" role="img"
											aria-label="<?php echo esc_attr( $label ) ?>">
											<?php echo wc_get_star_rating_html( $average, $rating_count ); ?>
										</div>
										<span class="count">(<?php echo esc_html( $rating_count ) ?>)</span>
									</div>

									<?php if ( $unit_text ): ?>
										<div class="unit-text"><?php echo esc_html( $unit_text ) ?></div>
									<?php endif; ?>

									<div class="price">
										<?php echo ! empty( $price_html ) ? $price_html : ''; ?>
									</div>
									<?php
									if ( $dupplicate_id != $data_id ) {
										if ( shortcode_exists( 'wcboost_wishlist_button' ) ) {
											echo do_shortcode( '[wcboost_wishlist_button class="fbt-wishlist add_to_wishlist single_add_to_wishlist" product_id="' . $data_id . '"]' );
										} else if ( shortcode_exists( 'yith_wcwl_add_to_wishlist' ) ) {
											echo do_shortcode( '[yith_wcwl_add_to_wishlist link_classes="fbt-wishlist add_to_wishlist single_add_to_wishlist" product_id ="' . $data_id . '"]' );
										}

										$dupplicate_id = $data_id;
									}
									?>
								</div>
								<ul class="products-list">
									<li>
										<a href="<?php echo esc_url( $item->get_permalink() ) ?>"
										data-id="<?php echo esc_attr( $item->get_id() ) ?>"
										data-title="<?php echo esc_attr( $product_name ) ?>">
										<?php echo Farmart\Icon::get_svg( 'check' ) ?>
										</a>
										<span class="s-price"
											data-price="<?php echo esc_attr( $item->get_price() ) ?>">(<?php echo ! empty( $price_html ) ? $price_html : '' ?>
											)</span>
									</li>
								</ul>
								<?php ?>
							</li>
							<?php
						}
						?>
						<li class="product product-buttons">
							<div class="price-box">
								<span class="label"><?php esc_html_e( 'Total Price: ', 'farmart' ); ?></span>
								<span class="s-price fm-total-price"><?php echo wc_price( $total_price ); ?></span>
								<input type="hidden" data-price="<?php echo esc_attr( $total_price ); ?>"
									id="fm-data_price">
							</div>
							<?php
							$product_ids = implode( ',', $product_ids );
							?>
							<form class="fbt-cart" action="<?php echo esc_url( $product->get_permalink() ); ?>"
								method="post"
								enctype="multipart/form-data">
								<button type="submit" name="fm-add-to-cart" value="<?php echo esc_attr( $product_ids ); ?>"
										class="fm_add_to_cart_button ajax_add_to_cart">
									<span class="p-icon" data-rel="tooltip"><?php echo Farmart\Icon::get_svg( 'cart', '', 'shop' ) ?></span>
									<?php esc_html_e( 'Add All To Cart', 'farmart' ); ?>
								</button>
							</form>
							<?php if ( function_exists( 'YITH_WCWL' ) ) : ?>
								<a href="<?php echo esc_url( $product->get_permalink() ); ?>"
								class="btn-add-to-wishlist fm-wishlist-button"><span> <?php esc_html_e( 'Add All To Wishlist', 'farmart' ); ?></span></a>
								<a href="<?php echo esc_url( self::get_wishlist_url() ); ?>"
								class="btn-view-to-wishlist fm-wishlist-button"><span><?php esc_html_e( 'Browse Wishlist', 'farmart' ); ?></span></a>
							<?php endif; ?>
							<?php if ( function_exists( 'wcboost_wishlist' ) ) : ?>
								<a href="<?php echo esc_url( $product->get_permalink() ); ?>"
								class="btn-add-to-wishlist fm-wishlist-button"><span> <?php esc_html_e( 'Add All To Wishlist', 'farmart' ); ?></span></a>
								<a href="<?php echo esc_url( self::get_wishlist_url( 'wcboost_wishlist' ) ); ?>"
								class="btn-view-to-wishlist fm-wishlist-button"><span><?php esc_html_e( 'Browse Wishlist', 'farmart' ); ?></span></a>
							<?php endif; ?>
						</li>
					</ul>
					<div class="clear"></div>
				</div>
			<?php if ( intval( $containerWidth ) ) : ?>
			</div>
			<?php endif; ?>
        </div>
		<?php
	}

	public static function fbt_product_variation( $product ) {
		$current_product_is_variation = $product->is_type( 'variation' );
		if ( ! $current_product_is_variation ) {
			return;
		}
		$attributes = $product->get_variation_attributes();
		$variations = array();

		foreach ( $attributes as $key => $attribute ) {
			$key = str_replace( 'attribute_', '', $key );

			$terms = get_terms( array(
				'taxonomy'   => sanitize_title( $key ),
				'menu_order' => 'ASC',
				'hide_empty' => false
			) );

			foreach ( $terms as $term ) {
				if ( ! is_object( $term ) || ! in_array( $term->slug, array( $attribute ) ) ) {
					continue;
				}
				$variations[] = $term->name;
			}
		}

		if ( ! empty( $variations ) ) {
			return ' &ndash; ' . implode( ', ', $variations );
		}

	}

	public static function get_wishlist_url( $plugin = '' ) {
		if( $plugin == 'wcboost_wishlist' ) {
			if ( function_exists( 'wcboost_wishlist' ) ) {
				return wc_get_page_permalink( 'wishlist' );
			}
		} else {
			if ( function_exists( 'YITH_WCWL' ) ) {
				return YITH_WCWL()->get_wishlist_url();
			} else {
				$wishlist_page_id = get_option( 'yith_wcwl_wishlist_page_id' );

				return get_the_permalink( $wishlist_page_id );
			}
		}
	}

	/**
	 * Display products related
	 *
	 * @return string
	 */
	public static function related_products_output() {

		if ( ! is_singular( 'product' ) ) {
			return;
		}

		if ( get_query_var( 'edit' ) && is_singular( 'product' ) ) {
			return;
		}

		if ( ! intval( farmart_get_option( 'product_related' ) ) ) {
			return;
		}


		if ( function_exists( 'woocommerce_related_products' ) ) {
			$args = array(
				'posts_per_page' => intval( farmart_get_option( 'related_products_numbers' ) ),
				'columns'        => intval( farmart_get_option( 'related_products_columns' ) ),
				'orderby'        => 'rand',
			);
			woocommerce_related_products( apply_filters( 'woocommerce_output_related_products_args', $args ) );
		}
	}

	public static function related_posts_relate_by_category() {
		return farmart_get_option( 'related_product_by_categories' );
	}

	public static function related_posts_relate_by_parent_category( $term_ids, $product_id ) {
		if ( ! intval( farmart_get_option( 'related_product_by_categories' ) ) ) {
			return $term_ids;
		}

		if ( ! intval( farmart_get_option( 'related_product_by_parent_category' ) ) ) {
			return $term_ids;
		}

		$terms = wc_get_product_terms(
			$product_id, 'product_cat', array(
				'orderby' => 'parent',
			)
		);

		$term_ids = array();

		if ( ! is_wp_error( $terms ) && $terms ) {
			$current_term = end( $terms );
			$term_ids[]   = $current_term->term_id;
		}

		return $term_ids;

	}

	public static function related_posts_relate_by_tag() {
		return farmart_get_option( 'related_product_by_tags' );
	}

	/**
	 * Display products upsell
	 *
	 * @return string
	 */
	public static function products_upsell_display() {

		if ( ! is_singular( 'product' ) ) {
			return;
		}

		if ( get_query_var( 'edit' ) && is_singular( 'product' ) ) {
			return;
		}

		if ( ! intval( farmart_get_option( 'product_upsells' ) ) ) {
			return;
		}


		if ( farmart_get_option( 'products_upsells_position' ) == '1' ) {
			return;
		}

		if ( farmart_get_product_layout() == '1' && farmart_get_option( 'products_upsells_position' ) == '1' ) {
			return;
		}


		if ( function_exists( 'woocommerce_upsell_display' ) ) {
			woocommerce_upsell_display();
		}
	}

	/**
	 * Display products upsell
	 *
	 * @return string
	 */
	public static function products_full_width_upsell() {
		if ( ! is_singular( 'product' ) ) {
			return;
		}

		if ( get_query_var( 'edit' ) && is_singular( 'product' ) ) {
			return;
		}

		if ( ! intval( farmart_get_option( 'product_upsells' ) ) ) {
			return;
		}

		if ( farmart_get_option( 'products_upsells_position' ) == '2' ) {
			return;
		}


		if ( function_exists( 'woocommerce_upsell_display' ) ) {
			woocommerce_upsell_display();
		}
	}

	public static function upsells_total() {
		return intval( farmart_get_option( 'upsells_products_numbers' ) );
	}

	/**
	 * Product Header
	 *
	 * @return void
	 */
	public static function get_quickview_product_header() {
		global $product;
		?>
        <div class="fm-entry-product-header">
            <div class="product-header-left">
				<?php
				if ( function_exists( 'woocommerce_template_single_title' ) ) {
					woocommerce_template_single_title();
				}
				?>
                <div class="product-entry-meta">
					<?php

					if ( function_exists( 'woocommerce_template_single_rating' ) && $product->get_rating_count() ) {
						echo '<div class="meta-rating">';
						woocommerce_template_single_rating();
						echo '</div>';
					}

					self::single_product_condition();
					self::single_product_sku();
					?>
                </div>
            </div>
        </div>
		<?php
	}

	/**
	 * Get product condition
	 */
	public static function single_product_condition() {
		global $product;
		$tax  = 'product_condition';
		$id   = $product->get_id();
		$term = get_the_terms( $id, $tax );

		if ( is_wp_error( $term ) || ! $term ) {
			return;
		}

		?>
        <div class="meta-product_condition">
			<span class="meta-label">
				<?php echo apply_filters( 'farmart_product_condition_meta_label', esc_html__( 'Condition:', 'farmart' ) ); ?>
			</span>
            <span class="meta-value">
				<?php printf( '<a href="%s">%s</a>', esc_url( get_term_link( $term[0]->term_id, $tax ) ), esc_html( $term[0]->name ) ); ?>
			</span>
        </div>
		<?php
	}

	/**
	 * Get product SKU
	 */
	public static function single_product_sku() {
		global $product;

		$box_style = 'div';
		if ( is_singular( 'product' ) && farmart_get_product_layout() != '4' ) {
			$box_style = 'li';
		}
		if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
            <<?php echo esc_html( $box_style ) ?> class="meta-sku">
                <span class="meta-label">
                    <?php echo apply_filters( 'farmart_product_sku_meta_label', esc_html__( 'SKU:', 'farmart' ) ); ?>
                    </span>
                <span class="meta-value">
                    <?php
                    if ( $sku = $product->get_sku() ) {
	                    echo ! empty( $sku ) ? $sku : '';
                    } else {
	                    esc_html_e( 'N/A', 'farmart' );
                    }
                    ?>
                </span>
            </<?php echo esc_html( $box_style ) ?>>
		<?php endif;
	}

	/**
	 *
	 */
	public static function template_single_summary_header() {
		global $product;
		$output = array();

		ob_start();
		do_action( 'farmart_single_product_header' );
		$output[] = ob_get_clean();

		//$output[] = self::get_sold_by_vendor();

		if ( farmart_get_product_layout() != '3' ) {
			if ( in_array( $product->get_type(), array( 'simple', 'variable' ) ) ) {
				$output[] = sprintf( '<div class="fm-summary-meta">%s</div>', wc_get_stock_html( $product ) );
			}
		}

		echo implode( ' ', $output );
	}

	/**
	 * Sticky Product Page
	 */
	public static function sticky_product_info() {

		if ( ! is_singular( 'product' ) ) {
			return;
		}
		$sticky_product = apply_filters( 'farmart_sticky_product_info', farmart_get_option( 'sticky_product_info' ) );
		if ( ! intval( $sticky_product ) ) {
			return;
		}

		wc_get_template( 'single-product/sticky-product-info.php' );
	}

	/**
	 * Display instagram photos
	 *
	 * @return string
	 */
	public static function product_instagram_photos() {

		if ( ! intval( farmart_get_option( 'product_instagram' ) ) ) {
			return;
		}

		if ( ! is_singular( 'product' ) ) {
			return;
		}

		if ( get_query_var( 'edit' ) && is_singular( 'product' ) ) {
			return;
		}

		$numbers    = farmart_get_option( 'product_instagram_numbers' );
		$title      = farmart_get_option( 'product_instagram_title' );
		$columns    = farmart_get_option( 'product_instagram_columns' );

		$instagram_array = self::instagram_get_photos_by_token($numbers);

		$columns = intval( $columns );

		$carousel_settings = array(
			'slidesToShow'   => $columns,
			'slidesToScroll' => $columns,
			'responsive'     => array(
				array(
					'breakpoint' => 1750,
					'settings'   => array(
						'dots'   => intval( farmart_get_option( 'product_full_width' ) ) ? true : false,
						'arrows' => intval( farmart_get_option( 'product_full_width' ) ) ? false : true,
					)
				),
				array(
					'breakpoint' => 1200,
					'settings'   => array(
						'dots'   => true,
						'arrows' => false,
					)
				),
				array(
					'breakpoint' => 992,
					'settings'   => array(
						'dots'   => true,
						'arrows' => false,
						'slidesToShow'   => 3,
						'slidesToScroll' => 3,
					)
				),
				array(
					'breakpoint' => 768,
					'settings'   => array(
						'dots'           => true,
						'arrows'         => false,
						'slidesToShow'   => 2,
						'slidesToScroll' => 2,
					)
				)
			)
		);

		$carousel_settings = apply_filters( 'farmart_instagram_products_carousel_settings', $carousel_settings );

		echo '<div class="farmart-wc-products-carousel farmart-product-instagram" data-settings="' . esc_attr( wp_json_encode( $carousel_settings ) ) . '">';
		echo sprintf( '<h2>%s</h2>', wp_kses( $title, wp_kses_allowed_html( 'post' ) ) );
		echo '<ul class="products">';

		$output = array();

		if ( is_wp_error( $instagram_array ) ) {
			$message = $instagram_array->get_error_message();
			echo ! empty( $message ) ? $message : '';
		} elseif ( $instagram_array ) {
			$count = 0;
			foreach ( $instagram_array as $instagram_item ) {

				$image_html = sprintf( '<img src="%s" alt="%s">', esc_url( $instagram_item['images']['thumbnail'] ), esc_html__( 'Instagram Image', 'farmart' ) );

				$output[] = '<li class="product">' .
				            '<a class="insta-item" href="' . esc_url( $instagram_item['link'] ) . '" target="_blank">' .
				            $image_html . '<i class="icon_social_instagram social_instagram"></i>'  . '</a>' .
				            '</li>' . "\n";

				$count ++;
				$numbers = intval( $numbers );
				if ( $numbers > 0 ) {
					if ( $count == $numbers ) {
						break;
					}
				}
			}

			if ( ! empty( $output ) ) {
				echo implode( '', $output );
			} else {
				esc_html_e( 'Instagram did not return any images.', 'farmart' );
			}
		} else {
			esc_html_e( 'Instagram did not return any images.', 'farmart' );
		}

		echo '</ul></div>';
	}

	/**
	 * Get Instagram images
	 *
	 * @param int $limit
	 *
	 * @return array|WP_Error
	 */
	public static function instagram_get_photos_by_token( $limit ) {
		$access_token = farmart_get_option( 'instagram_token' );

		if ( empty( $access_token ) ) {
			return new WP_Error( 'instagram_no_access_token', esc_html__( 'No access token', 'farmart' ) );
		}
		$user = self::farmart_get_instagram_user();
		if ( ! $user || is_wp_error( $user ) ) {
			return $user;
		}
		if (isset($user['error'])) {
			return new WP_Error( 'instagram_no_images', esc_html__( 'Instagram did not return any images. Please check your access token', 'farmart' ) );
		} else {
			$transient_key = 'farmart_instagram_photos_' . sanitize_title_with_dashes( $user['username'] . '__' . $limit );
			$images = get_transient( $transient_key );

			$images = array();
			$next = false;
			while ( count( $images ) < $limit ) {
				if ( ! $next ) {
					$fetched = self::farmart_fetch_instagram_media( $access_token );
				} else {
					$fetched = self::farmart_fetch_instagram_media( $next );
				}
				if ( is_wp_error( $fetched ) ) {
					break;
				}

				$images = array_merge( $images, $fetched['images'] );
				$next = $fetched['paging']['cursors']['after'];
			}

			if ( ! empty( $images ) ) {
				set_transient( $transient_key, $images, 2 * 3600 ); // Cache for 2 hours.
			}
			if ( ! empty( $images ) ) {

				return $images;

			} else {
				return new WP_Error( 'instagram_no_images', esc_html__( 'Instagram did not return any images.', 'farmart' ) );
			}
		}
	}
	/**
	 * Fetch photos from Instagram API
	 *
	 * @param  string $access_token
	 * @return array
	 */
	public static function farmart_fetch_instagram_media( $access_token ) {
		$url = add_query_arg( array(
			'fields'       => 'id,caption,media_type,media_url,permalink,thumbnail_url',
			'access_token' => $access_token,
		), 'https://graph.instagram.com/me/media' );

		$remote = wp_remote_retrieve_body( wp_remote_get( $url ) );
		$data   = json_decode( $remote, true );

		$images = array();
		if ( isset( $data['error'] ) ) {
			return new WP_Error( 'instagram_error', $data['error']['message'] );
		} else {
			foreach ( $data['data'] as $media ) {

				 $images[] = array(
					'type'    => $media['media_type'],
					'caption' => isset( $media['caption'] ) ? $media['caption'] : $media['id'],
					'link'    => $media['permalink'],
					'images'  => array(
						'thumbnail' => $media['media_url'],
						'original'  => $media['media_url'],
					),
				);

			}
		}
		return array(
			'images' => $images,
			'paging' => $data['paging'],
		);
	}
	/**
	 * Get user data
	 *
	 * @return bool|WP_Error|array
	 */
	public static function farmart_get_instagram_user() {
		$access_token = farmart_get_option( 'instagram_token' );
		if ( empty( $access_token ) ) {
			return new WP_Error( 'no_access_token', esc_html__( 'No access token', 'farmart' ) );
		}
		$user = get_transient( 'farmart_instagram_user_' . $access_token );
		if ( false === $user ) {
			$url  = add_query_arg( array( 'fields' => 'id,username', 'access_token' => $access_token ), 'https://graph.instagram.com/me' );
			$data = wp_remote_get( $url );
			$data = wp_remote_retrieve_body( $data );
			if ( ! $data ) {
				return new WP_Error( 'no_user_data', esc_html__( 'No user data received', 'farmart' ) );
			}
			$user = json_decode( $data, true );
			if ( ! empty( $data ) ) {
				set_transient( 'farmart_instagram_user', $user, 2592000 ); // Cache for one month.
			}
		}
		return $user;
	}
}