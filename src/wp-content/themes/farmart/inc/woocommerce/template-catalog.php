<?php
/**
 * Template Product hooks.
 *
 * @package Farmart
 */

/**
 * Class of general template.
 */
Class Farmart_WooCommerce_Template_Catalog {
	/**
	 * @var string shop view
	 */
	public static $catalog_view;


	/**
	 * @var array elements of current page
	 */
	public static $catalog_elements = array();

	/**
	 * Initialize.
	 */
	public static function init() {
		self::general_hooks();
		self::product_loop_content_hooks();
		self::catalog_hooks();
	}

	protected static function general_hooks() {
		add_filter( 'farmart_site_content_container_class', array( __CLASS__, 'catalog_content_container_class' ) );

		// Need an early hook to ajaxify update mini shop cart
		add_filter( 'woocommerce_add_to_cart_fragments', array( __CLASS__, 'add_to_cart_fragments' ) );

		// Remove shop page title
		add_filter( 'woocommerce_show_page_title', '__return_false' );

		// Change shop columns
		add_filter( 'loop_shop_columns', array( __CLASS__, 'shop_columns' ), 20 );

		// Add Bootstrap classes
		add_filter( 'post_class', array( __CLASS__, 'product_class' ), 20, 3 );

		// Parse query for shop products per page.
		add_action( 'parse_request', array( __CLASS__, 'parse_request' ) );
		if( farmart_get_option('catalog_header_layout') != '3' ) {
			add_filter( 'loop_shop_per_page', array( __CLASS__, 'products_per_page' ) );
		}

		add_action( 'template_redirect', array( __CLASS__, 'farmart_template_redirect' ) );

		add_action( 'wp_ajax_farmart_product_quick_view', array( __CLASS__, 'product_quick_view' ) );
		add_action( 'wp_ajax_nopriv_farmart_product_quick_view', array( __CLASS__, 'product_quick_view', ) );
		add_action( 'wc_ajax_product_quick_view', array( __CLASS__, 'product_quick_view' ) );

	}

	protected static function product_loop_content_hooks() {

		// Remove product title link
		remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

		// Remove product link
		remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

		// Remove add to cart link
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );


		/*------------------
		Product loop
		-------------------*/
		add_action( 'woocommerce_before_shop_loop_item', array( __CLASS__, 'open_product_inner' ), 5 );

		add_action( 'woocommerce_before_shop_loop_item', array( __CLASS__, 'open_product_thumbnail' ), 5 );
		add_action( 'woocommerce_before_shop_loop_item', array( __CLASS__, 'product_link_open' ), 7 );
		add_action( 'woocommerce_before_shop_loop_item_title', array( __CLASS__, 'product_link_close' ), 30 );
		add_action( 'woocommerce_before_shop_loop_item_title', array( __CLASS__, 'product_loop_buttons_hover' ), 35 );
		add_action( 'woocommerce_before_shop_loop_item_title', array( __CLASS__, 'close_product_thumbnail' ), 50 );

		add_action( 'woocommerce_before_shop_loop_item_title', array( __CLASS__, 'open_product_details' ), 100 );

		add_action( 'woocommerce_shop_loop_item_title', array( __CLASS__, 'open_product_content_box' ), 3 );
		add_action( 'woocommerce_shop_loop_item_title', array( __CLASS__, 'template_loop_product_title' ), 10 );
		add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_single_excerpt', 30 );
		add_action( 'woocommerce_after_shop_loop_item', array( __CLASS__, 'close_product_content_box' ), 45 );

		add_action( 'woocommerce_after_shop_loop_item_title', array( __CLASS__, 'template_product_unit_text' ), 7 );

		add_action( 'woocommerce_after_shop_loop_item', array( __CLASS__, 'open_product_bottom_box' ), 50 );
		add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 60 );
		add_action( 'woocommerce_after_shop_loop_item', array( __CLASS__, 'product_loop_button' ), 90 );
		add_action( 'woocommerce_after_shop_loop_item', array( __CLASS__, 'close_product_bottom_box' ), 100 );

		add_action( 'woocommerce_after_shop_loop_item', array( __CLASS__, 'close_product_details' ), 250 );

		add_action( 'woocommerce_after_shop_loop_item', array( __CLASS__, 'close_product_inner' ), 300 );

		// Change HTML
		add_filter( 'woocommerce_product_get_rating_html', array( __CLASS__, 'product_get_rating_html' ), 20, 2 );
		add_filter( 'woocommerce_get_price_html', array( __CLASS__, 'product_get_price_html' ), 20, 2 );

		// Product deal loop
		add_action( 'woocommerce_after_shop_loop_item', array( __CLASS__, 'product_deals_progress_bar' ), 25 );

	}

	protected static function catalog_hooks() {
		// Remove catalog ordering
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

		/*-----------------------
			Catalog content
		-----------------------*/

		// Add Catalog Banners Top
		add_action( 'farmart_after_header', array(  __CLASS__, 'catalog_banners_carousel' ), 25 );

		// Add Box HTML Woocommerce Ordering
		add_filter( 'farmart_before_woocommerce_ordering_html', array( __CLASS__, 'catalog_before_woocommerce_ordering_html' ), 5 );
		add_filter( 'farmart_after_woocommerce_ordering_html', array( __CLASS__, 'catalog_after_woocommerce_ordering_html' ), 5 );

		if ( farmart_get_option('catalog_header_layout') != '3' ) {
			add_action( 'woocommerce_before_shop_loop', array( __CLASS__, 'catalog_top_categories' ), 10 );
			add_action( 'woocommerce_before_shop_loop', array( __CLASS__, 'catalog_products_carousel' ), 10 );

			// Catalog Toolbar
			add_action( 'woocommerce_before_shop_loop', array( __CLASS__, 'shop_toolbar' ), 20 );
		} else {
			// Catalog Toolbar
			add_action( 'woocommerce_before_main_content', array(  __CLASS__, 'catalog_toolbar_v3' ), 5 );
		}

		if ( farmart_get_option('catalog_header_layout') == '1' ) {
			remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
			remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );
			add_action( 'woocommerce_after_main_content', 'woocommerce_taxonomy_archive_description', 5 );
			add_action( 'woocommerce_after_main_content', 'woocommerce_product_archive_description', 5 );

		} elseif ( farmart_get_option('catalog_header_layout') == '2' ) {
			// Catalog Header
			add_action( 'woocommerce_archive_description', array( __CLASS__, 'catalog_page_header_layout_2' ), 8 );
		}

		add_action( 'woocommerce_before_shop_loop', array( __CLASS__, 'before_shop_loop' ), 40 );
		add_action( 'woocommerce_before_shop_loop', array( __CLASS__, 'shop_loading' ), 60 );
		add_action( 'woocommerce_after_shop_loop', array( __CLASS__, 'after_shop_loop' ), 100 );
		add_filter( 'woocommerce_pagination_args', array( __CLASS__, 'loop_pagination_args' ) );

		// Header Filter Mobile
		add_action( 'catalog_filter_mobile_before', array( __CLASS__, 'catalog_close_sidebar' ));
		add_action( 'catalog_filter_mobile_before', array( __CLASS__, 'catalog_filter_mobile_before_content' ));
		add_action( 'catalog_filter_mobile_after', array( __CLASS__, 'catalog_filter_mobile_after_content' ));

		// Catalog Pagination
		remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination' );
		add_action( 'woocommerce_after_shop_loop', array( __CLASS__, 'fm_pagination' ) );
		add_filter( 'woocommerce_pagination_args', array( __CLASS__, 'fm_pagination_args' ) );

		add_filter( 'farmart_inline_style', array( __CLASS__, 'catalog_inline_style' ) );
	}

	public static function open_product_inner() {
		echo '<div class="product-inner">';
	}

	public static function close_product_inner() {
		echo '</div>';
	}

	public static function open_product_thumbnail() {
		echo '<div class="product-thumbnail fm-product-thumbnail">';
	}

	public static function product_link_open() {
		echo '<a href="' . esc_url( get_the_permalink() ) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">';
	}

	public static function product_link_close() {
		echo '</a>';
	}

	public static function close_product_thumbnail() {
		echo '</div>';
	}

	public static function open_product_details() {
		echo '<div class="product-details">';
	}

	public static function close_product_details() {
		echo '</div>';
	}

	public static function open_product_content_box() {
		echo '<div class="product-content-box">';
	}

	public static function close_product_content_box() {
		echo '</div>';
	}

	public static function open_product_bottom_box() {
		echo '<div class="product-bottom-box">';
	}

	public static function close_product_bottom_box() {
		echo '</div>';
	}

	public static function catalog_toolbar_v2_desc_hidden_open() {
		echo '<div class="fm-catalog-desc--hidden hidden">';
	}

	public static function catalog_toolbar_v2_desc_hidden_close() {
		echo '</div>';
	}

	public static function catalog_content_container_class( $class ) {

		if ( farmart_get_catalog_full_width() ) {
			return 'farmart-container';
		}

		return $class;
	}

	public static function catalog_inline_style( $css ) {
		$catalog_bg = farmart_get_option( 'catalog_banners_bg_image' );

		if ( $catalog_bg && farmart_get_option('catalog_header_layout') == '3' ) {
			$css .= '.catalog-banners-carousel{ background-image: url("'. $catalog_bg .'") }';
		}

		return $css;
	}

	public static function catalog_close_sidebar() {
		if ( ! farmart_is_catalog() ) {
			return;
		}

		$filter_text = farmart_get_option('catalog_toolbar_els_filter_mobile');

		$filter_text = empty($filter_text) ? esc_html__( 'Filter Products', 'farmart' ) : $filter_text;

		echo sprintf(
			'<div class="fm-catalog-close-sidebar hidden-lg hidden-md" id="fm-catalog-close-sidebar"> <h2>%s</h2> <a href="#" class="close-sidebar">%s</a></div>',
			esc_html($filter_text),
			Farmart\Icon::get_svg( 'arrow-right' )
		);
	}

	public static function catalog_filter_mobile_before_content() {
		if ( ! farmart_is_catalog() ) {
			return;
		}

		echo '<div class="fm-catalog-filter-sidebar-content">';
	}

	public static function catalog_filter_mobile_after_content() {
		if ( ! farmart_is_catalog() ) {
			return;
		}

		echo '</div>';
	}

	/**
	 * Show the product title in the product loop. By default this is an H2.
	 */
	public static function template_loop_product_title() {
		$title = get_the_title();
		$amount = apply_filters( 'farmart_amount_number_product_title', 28 );
		if ( is_home() || is_front_page() ) {
			$title = strlen($title) > $amount ? substr($title,0,$amount)."..." : $title;
		}
		echo '<h2 class="woocommerce-loop-product__title"><a href="' . get_the_permalink() . '">' . $title . '</a></h2>';
	}

	public static function farmart_template_redirect() {
		self::$catalog_view     = isset( $_COOKIE['catalog_view'] ) ? $_COOKIE['catalog_view'] : farmart_get_option( 'catalog_type' )[0];
		self::$catalog_view =	 apply_filters('farmart_catalog_product_view', self::$catalog_view );
	}

	public static function template_product_unit_text() {
		global $product;
		$unit_text = maybe_unserialize( get_post_meta( $product->get_id(), 'custom_unit_price', true ) );

		if ( $unit_text ) {
			echo '<span class="unit-text">' . $unit_text . '</span>';
		}
	}

	/**
	 * Change the shop columns
	 *
	 * @since  1.0.0
	 *
	 * @param  int $columns The default columns
	 *
	 * @return int
	 */
	public static function shop_columns( $columns ) {
		if( farmart_get_option('catalog_header_layout') != '3' ) {
			$columns = intval( farmart_get_option( 'catalog_products_columns' ) );
		}

		return apply_filters( 'farmart_shop_columns', $columns );

	}

	/**
	 * Add Bootstrap's column classes for product
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
	    global $product;

		if ( ! $post_id || ( get_post_type( $post_id ) !== 'product' && get_post_type( $post_id ) != 'product_variation' ) ) {
			return $classes;
		}

		if ( is_admin() && function_exists( 'get_current_screen' ) ) {
			$screen = get_current_screen();
			if ( $screen && $screen->parent_file == 'edit.php?post_type=product' && $screen->post_type == 'product' ) {
				return $classes;
			}
		}

		if ( $product->is_on_sale() && self::check_product_type_get_price( $product ) == false ) {
			$classes[] = 'fm-hide-badges';
		}


		return $classes;
	}

	/**
	* Get category level
	*
	* @since 1.0
	*/
	public static function farmart_get_product_category_level() {
		global $wp_query;
		$current_cat = $wp_query->get_queried_object();
		if ( empty( $current_cat ) ) {
			return 0;
		}

		$term_id = $current_cat->term_id;

		return count( get_ancestors( $term_id, 'product_cat' ) );
	}

	/**
	 * Parse request to change the shop columns and products per page
	 */
	public static function parse_request() {
		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
			return;
		}

		if ( isset( $_REQUEST['products_per_page'] ) ) {
			wc_setcookie( 'products_per_page', intval( $_REQUEST['products_per_page'] ) );
		}
	}

	/**
	 * Shop loading
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public static function before_shop_loop() {
		if ( ! farmart_is_catalog() ) {
			return;
		}
		echo '<div id="fm-shop-content" class="fm-shop-content">';
	}

	/**
	 * Shop loading
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public static function after_shop_loop() {
		if ( ! farmart_is_catalog() ) {
			return;
		}
		echo '</div>';
	}

	/**
	 * Shop loading
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public static function shop_loading() {
		if ( ! farmart_is_catalog() ) {
			return;
		}
		echo '<div class="fm-catalog-loading">
				<span class="fm-loader"></span>
			</div>';
	}

	/**
	 * Change the products per page.
	 *
	 * @param  int $per_page The default value.
	 *
	 * @return int
	 */
	public static function products_per_page( $per_page ) {
		if ( is_search() ) {
			if ( isset( $_POST['search_per_page'] ) ) {
				$per_page = intval( $_REQUEST['search_per_page'] );
			}
		} else {
			if ( ! empty( $_REQUEST['products_per_page'] ) ) {
				$per_page = intval( $_REQUEST['products_per_page'] );
			} elseif ( ! empty( $_COOKIE['products_per_page'] ) ) {
				$per_page = intval( $_COOKIE['products_per_page'] );
			} else {
				$per_page = farmart_get_option( 'catalog_per_page' );
				$per_page = $per_page ? $per_page[0]['number'] : wc_get_loop_prop( 'per_page' );
			}
		}

		return $per_page;
	}



	/**
	 * WooCommerce product quickview
	 *
	 * @since  1.0
	 *
	 * @return string
	 */
	public static function product_loop_buttons_hover() {
		echo '<div class="product-loop__buttons">';

		self::product_quickview();

		if ( shortcode_exists( 'wcboost_wishlist_button' ) ) {
			echo do_shortcode( '[wcboost_wishlist_button]' );
		} else if ( shortcode_exists( 'yith_wcwl_add_to_wishlist' ) ) {
			echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
		}

		self::product_compare();

		echo '</div>';
	}

	/**
	 * WooCommerce product quickview
	 *
	 * @since  1.0
	 *
	 * @return string
	 */
	public static function product_quickview() {
		global $product;

		echo '<a href="' . $product->get_permalink() . '" data-id="' . esc_attr( $product->get_id() ) . '"  class="fm-product-quick-view button fm-loop_button hidden-sm hidden-xs">
		<span title="' . esc_attr__( 'Quick View', 'farmart' ) . '" data-rel="tooltip">'. Farmart\Icon::get_svg( 'expand' ) .'</span>
		</a>';
	}

	/**
	 *product_quick_view
	 */
	public static function product_quick_view() {
		if ( apply_filters( 'farmart_check_ajax_referer', true ) ) {
			check_ajax_referer( '_farmart_nonce', 'nonce' );
		}
		ob_start();
		if ( isset( $_POST['product_id'] ) && ! empty( $_POST['product_id'] ) ) {
			$product_id      = $_POST['product_id'];
			$original_post   = $GLOBALS['post'];
			$GLOBALS['post'] = get_post( $product_id ); // WPCS: override ok.
			setup_postdata( $GLOBALS['post'] );
			wc_get_template_part( 'content', 'product-quick-view' );
			$GLOBALS['post'] = $original_post; // WPCS: override ok.

		}
		$output = ob_get_clean();
		wp_send_json_success( $output );
		die();
	}


	/**
	 * Ajaxify update cart viewer
	 *
	 * @since 1.0
	 *
	 * @param array $fragments
	 *
	 * @return array
	 */
	public static function add_to_cart_fragments( $fragments ) {
		global $woocommerce;

		if ( empty( $woocommerce ) ) {
			return $fragments;
		}

		ob_start();

		?>

        <span class="mini-item-counter fm-mini-cart-counter"><?php echo WC()->cart->get_cart_contents_count(); ?></span>

		<?php
		$fragments['.fm-mini-cart-counter'] = ob_get_clean();

		ob_start();

		?>

        <span class="fm-price-total"><?php echo WC()->cart->get_cart_total(); ?></span>

		<?php
		$fragments['.fm-price-total'] = ob_get_clean();

		ob_start();

		?>

        <span class="cart-price-total"><?php echo WC()->cart->get_cart_total(); ?></span>

		<?php
		$fragments['.cart-price-total'] = ob_get_clean();

		return $fragments;
	}

	/**
	 * HTML for rating
	 *
	 * @since 1.0
	 */
	public static function product_get_rating_html( $html, $rating ) {

		global $product;

		if ( empty( $product ) ) {
			return $html;
		}

		$count = $product->get_rating_count();

		$label = sprintf( __( 'Rated %s out of 5', 'farmart' ), $rating );
		$html  = '<div class="star-rating" role="img" aria-label="' . esc_attr( $label ) . '">' . wc_get_star_rating_html( $rating, $count ) . '</div>';

		$rating = '<div class="fm-rating">';
		$rating .= $html;
		$rating .= '<span class="count">(' . $count . ')</span>';
		$rating .= '</div>';

		return $rating;
	}

	/**
	 * HTML for price
	 *
	 * @since 1.0
	 */
	public static function product_get_price_html( $price, $product ) {
		if ( is_admin() ) {
			return $price;
		}

		if ( $product->get_type() == 'variable' || $product->get_type() == 'grouped' ) {
			return $price;
		}

		return $price;
	}

	public static function check_product_type_get_price( $product ) {
		$badges = farmart_get_option( 'catalog_badges_els' );

		if (
			( ! $product->is_in_stock() && in_array( 'outofstock', $badges ) ) ||
			( ( time() - ( 60 * 60 * 24 * farmart_get_option( 'catalog_badges_product_newness' ) ) ) < strtotime( get_the_time( 'Y-m-d' ) ) && in_array( 'new', $badges ) ||
			  get_post_meta( $product->get_id(), '_is_new', true ) == 'yes' || is_singular( 'product' ) )
		) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * WooCommerce product compare
	 *
	 * @since  1.0
	 *
	 * @return string
	 */
	public static function product_compare() {
		global $product;

		if( function_exists('wcboost_products_compare') ) {
			echo do_shortcode('[wcboost_compare_button]');
		} else if ( class_exists( 'YITH_Woocompare' ) ) {
			$button_text = get_option( 'yith_woocompare_button_text', esc_html__( 'Compare', 'farmart' ) );
			$product_id  = $product->get_id();
			$url_args    = array(
				'action' => 'yith-woocompare-add-product',
				'id'     => $product_id,
			);
			$lang        = defined( 'ICL_LANGUAGE_CODE' ) ? ICL_LANGUAGE_CODE : false;
			if ( $lang ) {
				$url_args['lang'] = $lang;
			}

			$css_class   = 'compare';
			$cookie_name = 'yith_woocompare_list';
			if ( function_exists( 'is_multisite' ) && is_multisite() ) {
				$cookie_name .= '_' . get_current_blog_id();
			}
			$the_list = isset( $_COOKIE[ $cookie_name ] ) ? json_decode( $_COOKIE[ $cookie_name ] ) : array();
			if ( in_array( $product_id, $the_list ) ) {
				$css_class          .= ' added';
				$url_args['action'] = 'yith-woocompare-view-table';
				$button_text        = apply_filters( 'yith_woocompare_compare_added_label', esc_html__( 'Added', 'farmart' ) );
			}

			$url = esc_url_raw( add_query_arg( $url_args, site_url() ) );
			echo '<div class="compare-button fm-compare-button fm-loop_button">';
				printf( '<a href="%s" class="%s" title="%s" data-product_id="%d">%s<span class="text">%s</span></a>', esc_url( $url ), esc_attr( $css_class ), esc_attr( $button_text ), $product_id, Farmart\Icon::get_svg( 'repeat', '', 'shop' ), $button_text );
			echo '</div>';
		} else {
			return;
		}
	}

	public static function product_loop_quantity() {
		global $product;

		if ( ! intval( farmart_get_option( 'catalog_product_loop_show_qty' ) ) ) {
			return;
		}

		if ( ! $product || ! $product->is_type( 'simple' ) || ! $product->is_purchasable() || ! $product->is_in_stock() ||  $product->is_sold_individually() ) {
			return;
		}

		if ( $product->get_price() == '' ) {
			return;
		}

		woocommerce_quantity_input( array(
			'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
			'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
			'input_value' => $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
		) );
		$args = array(
			'decimal_separator'  => wc_get_price_decimal_separator(),
			'thousand_separator' => wc_get_price_thousand_separator(),
			'decimals'           => wc_get_price_decimals(),
		);
		$price = $product->get_price();
		$price_format = number_format( $price, $args['decimals'], $args['decimal_separator'], $args['thousand_separator'] );
		?>
        <div class="box-price">
            <span class="title-price">
            	<?php
	            echo esc_html__( 'Total:', 'farmart' );
	            ?>
			</span>
            <span class="price-symbol"><?php echo get_woocommerce_currency_symbol() ?></span>
            <span class="price-current" data-current='<?php echo esc_attr( $price ); ?>'
			data-decimals='<?php echo esc_attr( $args['decimals'] );?>'
			data-decimal_separator='<?php echo esc_attr( $args['decimal_separator'] );?>'
			data-thousand_separator='<?php echo esc_attr( $args['thousand_separator'] );?>'>
				<?php echo esc_html( $price_format ); ?>
			</span>
        </div>
		<?php
	}

	public static function product_loop_button() {
		global $product;

		echo '<div class="product-button">';

		self::product_loop_quantity();

		woocommerce_template_loop_add_to_cart();

		echo '</div>';

	}

	public static function product_deals_progress_bar() {
		global $product, $woocommerce_loop;

		if ( ! isset( $woocommerce_loop['name'] ) ) {
			return;
		}

		if ( 'farmart_product_deals' != $woocommerce_loop['name'] ) {
			return;
		}

		if ( ! function_exists( 'tawc_is_deal_product' ) ) {
			return;
		}

		if ( ! tawc_is_deal_product( $product ) ) {
			return;
		}


		$limit = get_post_meta( $product->get_id(), '_deal_quantity', true );
		$sold  = intval( get_post_meta( $product->get_id(), '_deal_sales_counts', true ) );


		?>
        <div class="tawc-deal deal">
            <div class="deal-sold">
                <div class="deal-progress">
                    <div class="progress-bar">
                        <div class="progress-value" style="width: <?php echo esc_attr( $sold / $limit * 100 ) ?>%"></div>
                    </div>
                </div>
                <div class="deal-text">
					<span class="sold">
						<span class="text"><?php esc_html_e( 'Sold: ', 'farmart' ) ?></span>
						<span class="value"><?php echo esc_html( $sold ) ?>/<?php echo esc_html( $limit ) ?></span>
					</span>
                </div>
            </div>
        </div>
		<?php
	}

	public static function product_deals_price() {
		global $product, $woocommerce_loop;

		if ( ! isset( $woocommerce_loop['name'] ) ) {
			return;
		}

		if ( 'farmart_product_deals' != $woocommerce_loop['name'] ) {
			return;
		}

		if ( ! function_exists( 'woocommerce_template_loop_price' ) ) {
			return;
		}

		echo '<div class="product-deals-price">';
		woocommerce_template_loop_price();
		echo '</div>';

	}


	/**
	 * Catalog Layout
	 */
	public static function catalog_toolbar_v3() {
		if ( ! farmart_is_catalog() ) {
			return;
		}

		echo sprintf(
			'<div class="fm-catalog-header__title col-md-12 hidden-lg hidden-md">%s</div>',
			get_the_archive_title()
		);

		echo '<div class="fm-catalog-header col-md-12">';

		echo sprintf(
			'<div class="fm-catalog-header__left">
				<h1 class="fm-catalog-header__title hidden-sm hidden-xs">%s</h1>
				<a href="#" class="hidden-lg hidden-md fm-filter-mobile" id="fm-filter-mobile">%s<span>%s</span></a>
			</div>',
			get_the_archive_title(),
			Farmart\Icon::get_svg( 'equalizer' ),
			esc_html__('Filter','farmart')
		);

		echo '<div class="fm-catalog-header__right catalog-toolbar">';
		woocommerce_catalog_ordering();
		echo '<div class="shop-view">';
		echo self::shop_view();
		echo '</div>';
		echo '</div>';
		echo '</div>';
	}

	/**
	 * Woocommerce Ordering before html
	 */
	public static function catalog_before_woocommerce_ordering_html() {
		if ( ! farmart_is_catalog() ) {
			return;
		}


		echo '<div class="fm-catalog-ordering">';

		if ( farmart_get_option('catalog_header_layout') == '3' ) {
			echo '<span class="text">' . esc_html__('Sort by:', 'farmart') . '</span>';
		}
	}

	/**
	 * Woocommerce Ordering after html
	 */
	public static function catalog_after_woocommerce_ordering_html() {
		if ( ! farmart_is_catalog() ) {
			return;
		}

		echo '</div>';
	}

	/**
	 * Catalog Header
	 */
	public static function catalog_page_header_layout_2() {
		if ( ! farmart_is_catalog() ) {
			return;
		}

		$catalog_page_header = (array) farmart_get_option( 'catalog_page_header_els' ) ;

		if ( empty( $catalog_page_header ) ) {
			return;
		}

		if ( in_array( 'title', $catalog_page_header) ||  in_array( 'search', $catalog_page_header )  )  {
			echo '<div class="fm-catalog-header">';
		}

		if ( in_array( 'title', $catalog_page_header ) ) {
			the_archive_title( '<h1 class="fm-catalog-header__title">', '</h1>' );
		}

		if ( in_array( 'search', $catalog_page_header ) ) {
			self::categories_box_content_search();
		}

		if ( in_array( 'title', $catalog_page_header) ||  in_array( 'search', $catalog_page_header )  )  {
			echo '</div>';
		}

		if ( ! in_array( 'description', $catalog_page_header ) ) {
			add_action( 'woocommerce_archive_description', array(
				__CLASS__,
				'catalog_toolbar_v2_desc_hidden_open'
			), 9 );
			add_action( 'woocommerce_archive_description', array(
				__CLASS__,
				'catalog_toolbar_v2_desc_hidden_close'
			), 12 );
		}


	}

	public static function categories_box_content_search() {
		$categories = get_queried_object();

		?>
        <form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <input type="text" name="s" class="search-field" autocomplete="off"
                   placeholder="<?php echo esc_attr__( 'Search in ', 'farmart' ) . $categories->name . '...' ?>">
            <input type="hidden" name="post_type" value="product">

			<?php if ( function_exists('is_product_category') && is_product_category() ): ?>
                <input type="hidden" name="product_cat" value="<?php echo esc_attr( $categories->slug ) ?>">
			<?php endif ?>

			<?php if ( function_exists('is_product_tag') && is_product_tag() ): ?>
                <input type="hidden" name="product_tag" value="<?php echo esc_attr( $categories->slug ) ?>">
			<?php endif ?>

			<?php if ( is_tax( 'product_brand' ) ): ?>
                <input type="hidden" name="product_brand" value="<?php echo esc_attr( $categories->slug ) ?>">
			<?php endif ?>

            <input type="submit" class="search-submit" value="<?php esc_attr_e( 'Search ', 'farmart' ) ?>">
        </form>

		<?php
	}

	/**
	 * Catalog Filter
	 */
	public static function categories_box_content_filters() {
		if ( ! is_post_type_archive( 'product' ) && ! is_tax( get_object_taxonomies( 'product' ) ) ) {
			return;
		}

		$_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
		$min_price          = isset( $_GET['min_price'] ) ? wc_clean( $_GET['min_price'] ) : 0;
		$max_price          = isset( $_GET['max_price'] ) ? wc_clean( $_GET['max_price'] ) : 0;
		$rating_filter      = isset( $_GET['rating_filter'] ) ? array_filter( array_map( 'absint', explode( ',', $_GET['rating_filter'] ) ) ) : array();
		$product_brands     = isset( $_GET['product_brand'] ) ? array_filter( explode( ',', wc_clean( $_GET['product_brand'] ) ) ) : array();

		$product_tag = isset( $_GET['product_tag'] ) ? array_filter( explode( ',', wc_clean( $_GET['product_tag'] ) ) ) : array();
		$base_link   = self::get_page_base_url();

		$item = $item_title = '';

		if ( 0 < count( $_chosen_attributes ) || 0 < $min_price || 0 < $max_price || ! empty( $rating_filter ) || ! empty( $product_brands ) || ! empty( $product_tag ) ) {

			$item_title = sprintf( '<h6 class="filter-title">%s</h6>', esc_html__( 'Your filters:', 'farmart' ) );

			$item .= '<ul>';

			// Attributes
			if ( ! empty( $_chosen_attributes ) ) {
				foreach ( $_chosen_attributes as $taxonomy => $data ) {
					foreach ( $data['terms'] as $term_slug ) {
						if ( ! $term = get_term_by( 'slug', $term_slug, $taxonomy ) ) {
							continue;
						}

						$filter_name    = 'filter_' . sanitize_title( str_replace( 'pa_', '', $taxonomy ) );
						$current_filter = isset( $_GET[ $filter_name ] ) ? explode( ',', wc_clean( $_GET[ $filter_name ] ) ) : array();
						$current_filter = array_map( 'sanitize_title', $current_filter );
						$new_filter     = array_diff( $current_filter, array( $term_slug ) );

						$link = remove_query_arg( array( 'add-to-cart', $filter_name ), $base_link );

						if ( sizeof( $new_filter ) > 0 ) {
							$link = add_query_arg( $filter_name, implode( ',', $new_filter ), $link );
						}

						$item .= sprintf( '<li class="chosen"><a rel="nofollow" aria-label="%s" href="%s">%s</a></li>', esc_attr__( 'Remove filter', 'farmart' ), esc_url( $link ), esc_html( $term->name ) );
					}
				}
			}

			if ( $min_price ) {
				$link = remove_query_arg( 'min_price', $base_link );

				$item .= sprintf( '<li class="chosen"><a rel="nofollow" aria-label="%s" href="%s">%s</a></li>', esc_attr__( 'Remove filter', 'farmart' ), esc_url( $link ), sprintf( __( 'Min %s', 'farmart' ), wc_price( $min_price ) ) );
			}

			if ( $max_price ) {
				$link = remove_query_arg( 'max_price', $base_link );

				$item .= sprintf( '<li class="chosen"><a rel="nofollow" aria-label="%s" href="%s">%s</a></li>', esc_attr__( 'Remove filter', 'farmart' ), esc_url( $link ), sprintf( __( 'Max %s', 'farmart' ), wc_price( $max_price ) ) );

			}

			if ( ! empty( $rating_filter ) ) {
				foreach ( $rating_filter as $rating ) {
					$link_ratings = implode( ',', array_diff( $rating_filter, array( $rating ) ) );
					$link         = $link_ratings ? add_query_arg( 'rating_filter', $link_ratings ) : remove_query_arg( 'rating_filter', $base_link );

					$item .= sprintf( '<li class="chosen"><a rel="nofollow" aria-label="%s" href="%s">%s</a></li>', esc_attr__( 'Remove filter', 'farmart' ), esc_url( $link ), sprintf( __( 'Rated %s out of 5', 'farmart' ), esc_html( $rating ) ) );
				}
			}

			if ( ! empty( $product_brands ) ) {
				foreach ( $product_brands as $brand ) {
					if ( ! $term = get_term_by( 'slug', $brand, 'product_brand' ) ) {
						continue;
					}
					$link_brands = implode( ',', array_diff( $product_brands, array( $brand ) ) );
					$link        = $link_brands ? add_query_arg( 'product_brand', $link_brands ) : remove_query_arg( 'product_brand', $base_link );

					$item .= sprintf( '<li class="chosen"><a rel="nofollow" aria-label="%s" href="%s">%s</a></li>', esc_attr__( 'Remove filter', 'farmart' ), esc_url( $link ), esc_html( $term->name ) );
				}
			}

			if ( ! empty( $product_tag ) ) {
				foreach ( $product_tag as $tag ) {
					if ( ! $term = get_term_by( 'slug', $tag, 'product_tag' ) ) {
						continue;
					}
					$link_tag = implode( ',', array_diff( $product_tag, array( $tag ) ) );
					$link     = $link_tag ? add_query_arg( 'product_tag', $link_tag ) : remove_query_arg( 'product_tag', $base_link );

					$item .= sprintf( '<li class="chosen"><a rel="nofollow" aria-label="%s" href="%s">%s</a></li>', esc_attr__( 'Remove filter', 'farmart' ), esc_url( $link ), esc_html( $term->name ) );
				}
			}

			$link = self::get_page_current_url();

			$item .= sprintf( '<li class="chosen"><a rel="nofollow" aria-label="%s" href="%s">%s</a></li>', esc_attr__( 'Remove all filters', 'farmart' ), esc_url( $link ), esc_html__( 'Clear all', 'farmart' ) );

			$item .= '</ul>';

			return sprintf(
				'<div class="widget_layered_nav_filters">
                %s%s
			</div>',
				$item_title, $item
			);
		}
	}

	public static function get_page_base_url() {

		$link = self::get_page_current_url();

		// Min/Max
		if ( isset( $_GET['min_price'] ) ) {
			$link = add_query_arg( 'min_price', wc_clean( $_GET['min_price'] ), $link );
		}

		if ( isset( $_GET['max_price'] ) ) {
			$link = add_query_arg( 'max_price', wc_clean( $_GET['max_price'] ), $link );
		}

		// Order by
		if ( isset( $_GET['orderby'] ) ) {
			$link = add_query_arg( 'orderby', wc_clean( $_GET['orderby'] ), $link );
		}

		// Min Rating Arg
		if ( isset( $_GET['product_brand'] ) ) {
			$link = add_query_arg( 'product_brand', wc_clean( $_GET['product_brand'] ), $link );
		}

		// Tag
		if ( isset( $_GET['product_tag'] ) ) {
			$link = add_query_arg( 'product_tag', wc_clean( $_GET['product_tag'] ), $link );
		}

		/**
		 * Search Arg.
		 * To support quote characters, first they are decoded from &quot; entities, then URL encoded.
		 */
		if ( get_search_query() ) {
			$link = add_query_arg( 's', rawurlencode( wp_specialchars_decode ( get_search_query() ) ), $link );
		}

		// Post Type Arg
		if ( isset( $_GET['post_type'] ) ) {
			$link = add_query_arg( 'post_type', wc_clean( $_GET['post_type'] ), $link );
		}


		// Min Rating Arg
		if ( isset( $_GET['rating_filter'] ) ) {
			$link = add_query_arg( 'rating_filter', wc_clean( $_GET['rating_filter'] ), $link );
		}

		// All current filters
		if ( $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes() ) {
			foreach ( $_chosen_attributes as $name => $data ) {
				$filter_name = sanitize_title( str_replace( 'pa_', '', $name ) );
				if ( ! empty( $data['terms'] ) ) {
					$link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
				}
				if ( 'or' == $data['query_type'] ) {
					$link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
				}
			}
		}

		return $link;
	}

	public static function get_page_current_url() {
		if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
			$link = home_url();
		} elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id( 'shop' ) ) ) {
			$link = get_post_type_archive_link( 'product' );
		} elseif ( is_product_category() ) {
			$link = get_term_link( get_query_var( 'product_cat' ), 'product_cat' );
		} elseif ( is_product_tag() ) {
			$link = get_term_link( get_query_var( 'product_tag' ), 'product_tag' );
		} else {
			$queried_object = get_queried_object();
			$link           = get_term_link( $queried_object->slug, $queried_object->taxonomy );
		}

		return $link;
	}


	/**
	 * Catalog Banners
	 */
	public static function catalog_banners_carousel() {
		if ( ! farmart_is_catalog() ) {
			return;
		}

		if( ! intval( farmart_get_option('catalog_banners_enable') ) ) {
			return;
		}

		$output =  array();

		if ( function_exists( 'is_product_category' ) && is_product_category() ) {
			$queried_object = get_queried_object();
			$term_id        = $queried_object->term_id;
			$banners_ids    = get_term_meta( $term_id, 'fm_cat_banners_id', true );
			$banners_links  = get_term_meta( $term_id, 'fm_cat_banners_link', true );

			if ( $banners_ids ) {
				$thumbnail_ids = explode( ',', $banners_ids );
				$banners_links = explode( "\n", $banners_links );
				$i             = 0;
				foreach ( $thumbnail_ids as $thumbnail_id ) {
					if ( empty( $thumbnail_id ) ) {
						continue;
					}

					$image = farmart_get_image_html( $thumbnail_id, 'full' );

					if ( empty( $image ) ) {
						continue;
					}
					if ( $image ) {
						$link = $link_html = '';

						if ( $banners_links && isset( $banners_links[ $i ] ) ) {
							$link = preg_replace( '/<br \/>/iU', '', $banners_links[ $i ] );
						}

						$output[] = sprintf(
							'<li><a href="%s">%s</a></li>',
							esc_url( $link ),
							$image
						);
					}

					$i ++;
				}
			}
		}

		$autoplay = intval( farmart_get_option( 'catalog_banners_autoplay' ) );

		if( empty( $output ) ) {
			$banners  = (array) farmart_get_option( 'catalog_banners_els' );

			if ($banners) {
				foreach ( $banners as $banner ) {
					if ( ! isset( $banner['image'] ) && ! $banner['image'] ) {
						continue;
					}

					$banner_id = $banner['image'];

					if( is_numeric($banner_id) ) {
						$image = wp_get_attachment_image( $banner_id, 'full' );
					} else {
						$image = sprintf('<img src="%s" alt="%s">', $banner_id, esc_html__( 'Banner Image', 'farmart' ) );
					}

					if ( isset( $banner['link_url'] ) && ! empty( $banner['link_url'] ) ) {
						if ( $image ) {
							$output[] = sprintf( '<li><a href="%s">%s</a></li>', esc_url( $banner['link_url'] ), $image );
						}
					} else {
						if ( $image ) {
							$output[] = sprintf( '<li>%s</li>', $image );
						}
					}
				}
			}
		}

		$container_class = intval( farmart_get_option( 'catalog_full_width' ) ) ? 'farmart-container' : 'container';

		if ( $output  ) {
			$has_bg = farmart_get_option( 'catalog_header_layout' ) == '3' && farmart_get_option( 'catalog_banners_bg_image' ) ? 'banner-has-bg' : '';
			echo sprintf(
				'<div id="catalog-banners-carousel" class="catalog-banners-carousel banner-header-layout-%s %s"><div class="%s"><ul id="fm-catalog-banners" class="fm-catalog-banners-carousel" data-autoplay="%s">%s</ul></div></div>',
				esc_attr( farmart_get_option( 'catalog_header_layout' ) ),
				esc_attr( $has_bg ),
				esc_attr( $container_class ),
				esc_attr( $autoplay ),
				implode( ' ', $output )
			);
		}

	}

	/**
	 * Catalog Categories
	 */
	public static function catalog_top_categories() {
		if ( ! farmart_is_catalog() ) {
			return;
		}

		if ( ! intval(farmart_get_option('catalog_top_categories_enable')) ) {
			return;
		}

		$cats_number     = farmart_get_option( 'catalog_top_categories_numbers' );
		$subcats_number  = apply_filters( 'farmart_categories_box_number_subcats', 5 );
		$cats_order      = farmart_get_option( 'catalog_top_categories_orderby' );
		$columns         = farmart_get_option( 'catalog_top_categories_columns' );
		$cat_title       = farmart_get_option( 'catalog_top_categories_title');
		$cat_icon        = Farmart\Icon::get_svg('chart-bars', '', 'shop');
		$cat_link_text   = farmart_get_option( 'catalog_top_categories_link_text');
		$cat_link_url    = farmart_get_option( 'catalog_top_categories_link_url');
		$cat_header_html = $cat_link_box = '';

		if ( ! empty( $cat_link_text ) ) {
			$cat_link_box = '<a class="cat-all" href="' . esc_url( $cat_link_url ) . '" target="_blank" rel="nofollow"><span class="link-text">' . $cat_link_text . '</span>'. Farmart\Icon::get_svg( 'chevron-right' ) .'</a>';
		}

		if ( ! empty( $cat_title ) ) {
			$cat_header_html = sprintf(
				'<div class="carousel-header">
                        <h3 class="title">%s%s</h3>
                        %s
                    </div>',
				$cat_icon,
				$cat_title,
				$cat_link_box
			);
		}

		if ( intval( $cats_number ) < 1 ) {
			return;
		}

		$atts = array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => 1,
			'number'     => $cats_number,
			'parent'     => 0,
		);

		$atts['menu_order'] = false;
		if ( $cats_order == 'order' ) {
			$atts['menu_order'] = 'asc';
		} else {
			$atts['orderby'] = $cats_order;
			if ( $cats_order == 'count' ) {
				$atts['order'] = 'desc';
			}
		}

		$parent = 0;
		$custom_class = '';
		if ( function_exists( 'is_product_category' ) && is_product_category() ) {
			global $wp_query;
			$current_cat = $wp_query->get_queried_object();
			if ( $current_cat ) {
				$parent = $current_cat->term_id;
			}
			$custom_class = 'fm-catalog-categories--other-style';
		}

		$atts['parent'] = $parent;

		$terms = get_terms( $atts );

		if ( is_wp_error( $terms ) || ! $terms ) {
			return;
		}

		$output = array();
		foreach ( $terms as $term ) {

			$term_list = array();
			$item_css  = '';

			if ( $subcats_number && ! is_product_category()) {

				$atts        = array(
					'taxonomy'   => 'product_cat',
					'hide_empty' => 1,
					'orderby'    => $cats_order,
					'number'     => $subcats_number,
					'parent'     => $term->term_id,
				);
				$child_terms = get_terms( $atts );
				if ( ! is_wp_error( $child_terms ) && $child_terms ) {
					$term_list[] = '<ul class="child-list">';
					foreach ( $child_terms as $child ) {
						$term_list[] = sprintf(
							'<li><a href="%s">%s</a></li>',
							esc_url( get_term_link( $child->term_id, 'product_cat' ) ),
							$child->name
						);
					}

					$term_list[] = sprintf(
						'<li class="parent"><a href="%s">%s %s</a></li>',
						esc_url( get_term_link( $term->term_id, 'product_cat' ) ),
						apply_filters( 'farmart_catalog_categories_parent_text', esc_html__( 'View all', 'farmart' ) ),
						Farmart\Icon::get_svg( 'chevron-right' )
					);

					$term_list[] = '</ul>';

				} else {
					$item_css .= 'no-child';
				}

			}
			$count_html = '';
			if ( function_exists( 'is_product_category' ) && is_product_category() ) {
				$count_text_before = $term->count <= 1 ? esc_html__('Item','farmart') : esc_html__( 'Items', 'farmart' );

				$count_html = sprintf('<div class="count-category">%s %s</div>',$term->count,apply_filters( 'farmart_catalog_categories_count_text', $count_text_before));
			}


			$thumbnail_id         = absint( get_term_meta( $term->term_id, 'thumbnail_id', true ) );
			$small_thumbnail_size = apply_filters( 'farmart_category_archive_thumbnail_size', 'shop_catalog' );

			$image_html = '';
			if ( $thumbnail_id ) {
				$image_html = sprintf(
					'<a class="cat-thumbnail" href="%s">%s</a>',
					esc_url( get_term_link( $term->term_id, 'product_cat' ) ),
					farmart_get_image_html( $thumbnail_id, $small_thumbnail_size )
				);
			} else {
				$item_css .= ' no-thumb';
			}

			$cat_content = sprintf(
				'<a href="%s" class="box-title">%s</a>',
				esc_url( get_term_link( $term->term_id, 'product_cat' ) ),
				esc_html( $term->name )
			);

			$output[] = sprintf(
				'<li class="cat-item %s">' .
				'<div class="cat-item__wrapper">' .
				'<div class="cat-content">' .
				'%s%s%s' .
				'</div>' .
				'%s' .
				'</div>' .
				'</li>',
				esc_attr( $item_css ),
				$image_html,
				$cat_content,
				$count_html,
				implode( '', $term_list )
			);
		}

		if ( $output ) {
			printf(
				'<div id="fm-catalog-categories" class="fm-catalog-carousel fm-catalog-categories %s">%s<ul class="catalog-carousel__wrapper catalog-categories__wrapper" data-columns="%s">%s</ul></div>',
				esc_attr($custom_class),
				$cat_header_html,
				esc_attr( absint( $columns ) ),
				implode( ' ', $output )
			);
		}
	}

	/**
	 * Catalog Products Carousel
	 */
	public static function catalog_products_carousel() {
		if ( ! farmart_is_catalog() ) {
			return;
		}

		if ( ! intval(farmart_get_option('catalog_products_carousel_enable')) ) {
			return;
		}

		$carousels = (array)farmart_get_option( 'catalog_products_carousel_els' );

		if ( empty( $carousels ) ) {
			return;
		}

		$title = $icon_box = $link_box = '';

		foreach ( $carousels as $carousel ) {
			if ( ! empty( $carousel['icons'] ) ) {
				$icon_box = '<span class="farmart-svg-icon">'. Farmart\Icon::sanitize_svg( $carousel['icons'] ) .'</span>';
			}

			if ( ! empty( $carousel['title'] ) ) {
				$title = sprintf( '<h3 class="title">%s%s</h3>', $icon_box, esc_html( $carousel['title'] ) );
			}

			if ( ! empty( $carousel['link_text'] ) ) {
				$link_box = '<a class="cat-all" href="' . esc_url( $carousel['link_url'] ) . '" target="_blank" rel="nofollow"><span class="link-text">' . $carousel['link_text'] . '</span>'. Farmart\Icon::get_svg( 'chevron-right' ) .'</a>';
			}

			$columns       = isset( $carousel['columns'] ) ? absint( $carousel['columns'] ) : 5;
			$autoplaySpeed = absint( $carousel['autoplay'] );
			$autoplay      = $autoplaySpeed > 0 ? true : false;

			$slug = '';

			$atts = array(
				'per_page' => intval( $carousel['number'] ),
				'type'     => $carousel['type'],
				'columns'  => $columns,
				'category' => $slug,
			);

			$carousel_settings = array(
				'slidesToShow'   => $columns,
				'slidesToScroll' => $columns,
				'autoplay'       => $autoplay,
				'infinite'       => $autoplay,
				'autoplaySpeed'  => $autoplaySpeed,
				'speed'          => 800,
				'responsive'     => array(
					array(
						'breakpoint' => 1200,
						'settings'   => array(
							'slidesToShow'   => 4,
							'slidesToScroll' => 4,
						)
					),
					array(
						'breakpoint' => 992,
						'settings'   => array(
							'slidesToShow'   => 3,
							'slidesToScroll' => 3,
						)
					),
					array(
						'breakpoint' => 768,
						'settings'   => array(
							'slidesToShow'   => 2,
							'slidesToScroll' => 2,
						)
					)
				)
			);

			printf(
				'<div class="fm-catalog-carousel fm-catalog-products catalog-view-grid">
 					<div class="carousel-header">%s%s</div>
 					<div class="catalog-carousel__wrapper fm-elementor-product-carousel" data-settings="%s">%s</div>
				</div>',
				$title,
				$link_box,
				esc_attr( wp_json_encode( $carousel_settings ) ),
				self::product_loop( $atts )
			);
		}
	}

	/**
	 * Get shop toolbar
	 *
	 */
	public static function shop_toolbar() {
		if ( ! farmart_is_catalog() && ! farmart_is_vendor_page() ) {
			return;
		}

		global $wp_query;

		$els = farmart_get_option( 'catalog_toolbar_elements' );
		if ( farmart_is_vendor_page() ) {
			$els = farmart_get_option( 'catalog_vendor_toolbar_els' );
		}

		$els = apply_filters( 'farmart_catalog_toolbar_elements', $els );

		if ( empty( $els ) ) {
			return;
		}

		$css_class = array( 'fm-catalog-toolbar catalog-toolbar' );

		if ( count( $els ) > 1 ) {
			$css_class[] = 'multiple';
		}

		$products_found = $page = $sort_by = $per_page = $view = '';

		if ( in_array( 'total_product', $els ) ) {
			if ( intval( farmart_is_mobile() ) ) {
				if ( intval( farmart_get_option( 'enable_mobile_version' ) ) ) {
					if ( farmart_is_vendor_page() ) {
						$products_found = '<a href="#" class="hidden-lg hidden-md fm-filter-mobile fm-vendor-infor-mobile" id="fm-vendor-infor-mobile">'. Farmart\Icon::get_svg( 'equalizer' ) .'<span>Info</span></a>';
					}
				}
			} else {
				$total          = $wp_query->found_posts;
				$products_found = '<div class="products-found"><span>' . $total . '</span>' . esc_html__( ' Products Found', 'farmart' ) . '</div>';
			}
		}

		if ( in_array( 'page', $els ) ) {
			$total_page = $wp_query->max_num_pages;
			$paged      = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

			$pages_url = [];
			for ( $x = 1; $x <= $total_page; $x ++ ) {
				$pages_url[] = '<input id="fm-catalog-url-page-' . esc_attr( $x ) . '" type="hidden" value="' . esc_attr( esc_url( get_pagenum_link( $x ) ) ) . '">';
			}

			$paged_html = '<form class="fm-toolbar-pagination" method="post">' .
			              '<input id="fm-catalog-page-number" type="number" value="' . esc_attr( $paged ) . '" min="1" max="' . esc_attr( $total_page ) . '" step="1">' .
			              implode( "\n", $pages_url ) .
			              '</form>';
			$page       = '<div class="current-page">' . esc_html__( 'Page ', 'farmart' ) . $paged_html . esc_html__( ' of ', 'farmart' ) . $total_page . '</div>';
		}

		if ( in_array( 'sort_by', $els ) ) {
			ob_start();
			woocommerce_catalog_ordering();
			$sort_by = ob_get_clean();
		}

		if ( in_array( 'per_page', $els ) ) {
			$per_page = self::shop_per_page();
		}

		$show_filter = farmart_is_catalog() && ! woocommerce_products_will_display() ? false : true;
		if ( $show_filter ) {
			$filter_html = sprintf( '<a href="#" class="hidden-lg hidden-md fm-filter-mobile" id="fm-filter-mobile">%s<span>%s</span></a>', Farmart\Icon::get_svg( 'equalizer' ), esc_html__('Filter','farmart') );
		}

		if ( in_array( 'view', $els ) ) {
			$view = self::shop_view();
		}

		$top = $bottom = '';

		if ( ! farmart_is_vendor_page() ) {
			if ( ! empty( $products_found ) || ! empty( $page ) ) {
				$top = sprintf( '<div class="catalog-toolbar__top">%s%s</div>', $products_found, $page );
			}
			$top .= self::categories_box_content_filters();
		}

		if ( ! empty( $sort_by ) || ! empty( $per_page ) || ! empty( $view ) || ! empty( $filter_html ) ) {
			$bottom = sprintf( '<div class="catalog-toolbar__bottom"><div class="shop-view">%s%s%s</div>%s</div>',$filter_html, $per_page, $view, $sort_by );
		}

		if ( farmart_is_vendor_page() ) {
			if ( ! empty( $products_found ) || ! empty( $view ) ) {
				$bottom = sprintf( '<div class="catalog-toolbar__bottom">%s%s</div>', $products_found, $view );
			}
		}

		printf(
			'<div id="fm-catalog-toolbar" class="%s">%s%s</div>',
			esc_attr( implode( ' ', $css_class ) ),
			$top,
			$bottom
		);
	}

	public static function shop_per_page() {
		$per_page = farmart_get_option( 'catalog_per_page' );
		$per_page = apply_filters( 'farmart_shop_view_per_page', $per_page );

		if ( ! empty( $_REQUEST['products_per_page'] ) ) {
			$current = intval( $_REQUEST['products_per_page'] );
		} elseif ( ! empty( $_COOKIE['products_per_page'] ) ) {
			$current = intval( $_COOKIE['products_per_page'] );
		} else {
			$current = $per_page ? $per_page[0]['number'] : wc_get_loop_prop( 'per_page' );
		}

		$label = apply_filters( 'farmart_shop_view_label', esc_html__( 'View:', 'farmart' ) );

		foreach ( $per_page as $per_pages ) {
			$per_page_number = $per_pages['number'];
		}
		$per_page_number = $current;
		$per_page_number = array_filter( $per_page );
		asort( $per_page_number );

		$output = array();
		foreach ( $per_page as $value ) {
			$class    = $value['number'] == $current ? 'active' : '';
			$output[] = sprintf(
				'<li><a href="%s" class="%s">%s%s</a></li>',
				esc_url( add_query_arg( array( 'products_per_page' => $value['number'] ) ) ),
				esc_attr( $class ),
				esc_html( $value['number'] ),
				esc_html__( ' per page', 'farmart' )
			);
		}

		$add_class = empty( $per_page ) ? 'empty-drop' : '';

		$html = '<ul>' . implode( '', $output ) . '</ul>';

		$per_page_view = '<label>' . esc_html__( 'View:', 'farmart' ) . '</label>';
		if ( ! farmart_is_vendor_page() ) {
			$per_page_view = sprintf(
				'<label>%s</label>
				<ul class="per-page %s"><li class="current">%s%s%s</li></ul>',
				$label,
				$add_class,
				$current . esc_html__( ' per page', 'farmart' ),
				$html,
				Farmart\Icon::get_svg( 'chevron-bottom' )
			);
		}

		return sprintf(
			'<div id="fm-shop-per-page" class="shop-view hidden-md hidden-xs hidden-sm">
                %s
			</div>',
			! empty( $per_page_view ) ? $per_page_view : ''
		);
	}

	public static function shop_view() {
		$list_current     = self::$catalog_view == 'list' ? 'current' : '';
		$grid_current     = self::$catalog_view == 'grid' ? 'current' : '';
		$extended_current = self::$catalog_view == 'extended' ? 'current' : '';

		$catalog_type = farmart_get_option( 'catalog_type' );
		$output_type  = array();

		foreach ( $catalog_type as $type ) {
			$current_class = $name_icon = '';
			if ( $type == 'grid' ) {
				$current_class = $grid_current;
				$name_icon     = 'icons';
			} elseif ( $type == 'list' ) {
				$current_class = $list_current;
				$name_icon     = 'menu';
			} elseif ( $type == 'extended' ) {
				$current_class = $extended_current;
				$name_icon     = 'grid';
			}

			$output_type[] = sprintf(
				'<a href="#" class="%1$s %2$s" data-view="%1$s" data-type="%1$s">%3$s</a>',
				esc_attr( $type ),
				esc_attr( $current_class ),
				Farmart\Icon::get_svg( $name_icon )
			);
		}

		$view_text = farmart_get_option('catalog_header_layout') == '3' ? esc_html__( 'View', 'farmart' ) : '';
		$view_text = $view_text ? '<div class="text">'. $view_text .'</div>' : '';

		return sprintf(
			'<div id="fm-shop-view" class="fm-shop-view">
				%s
				<div class="shop-view__icon">
					%s
				</div>
			</div>',
			$view_text,
			implode( $output_type )
		);
	}

	public static function loop_pagination_args( $args ) {
		if ( ! farmart_is_catalog() ) {
			return $args;
		}

		$args['prev_text'] = Farmart\Icon::get_svg( 'chevron-left' );
		$args['next_text'] = Farmart\Icon::get_svg( 'chevron-right' );

		return $args;
	}

	protected static function product_loop( $atts ) {
		global $woocommerce_loop;
		$query_args = self::get_query_args( $atts );

		$products = new WP_Query( $query_args );

		$columns = isset( $atts['columns'] ) ? absint( $atts['columns'] ) : null;

		if ( $columns ) {
			$woocommerce_loop['columns'] = $columns;
		}

		ob_start();

		if ( $products->have_posts() ) {
			woocommerce_product_loop_start();

			while ( $products->have_posts() ) : $products->the_post();
				wc_get_template_part( 'content', 'product' );
			endwhile; // end of the loop.

			woocommerce_product_loop_end();
		}

		$html = '<div class="woocommerce">' . ob_get_clean() . '</div>';

		woocommerce_reset_loop();
		wp_reset_postdata();

		return $html;
	}

	protected static function get_query_args( $atts ) {
		$args = array(
			'post_type'              => 'product',
			'post_status'            => 'publish',
			'orderby'                => get_option( 'woocommerce_default_catalog_orderby' ),
			'order'                  => 'DESC',
			'ignore_sticky_posts'    => 1,
			'posts_per_page'         => $atts['per_page'],
			'meta_query'             => WC()->query->get_meta_query(),
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
		);

		if ( version_compare( WC()->version, '3.0.0', '>=' ) ) {
			$args['tax_query'] = WC()->query->get_tax_query();
		}

		// Ordering
		if ( 'menu_order' == $args['orderby'] || 'price' == $args['orderby'] ) {
			$args['order'] = 'ASC';
		}

		if ( 'price-desc' == $args['orderby'] ) {
			$args['orderby'] = 'price';
		}

		if ( method_exists( WC()->query, 'get_catalog_ordering_args' ) ) {
			$ordering_args   = WC()->query->get_catalog_ordering_args( $args['orderby'], $args['order'] );
			$args['orderby'] = $ordering_args['orderby'];
			$args['order']   = $ordering_args['order'];

			if ( $ordering_args['meta_key'] ) {
				$args['meta_key'] = $ordering_args['meta_key'];
			}
		}

		if ( ! empty( $atts['category'] ) ) {
			$args['tax_query'][] = array(
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'slug', //This is optional, as it defaults to 'term_id'
					'terms'    => $atts['category'],
					'operator' => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
				),
			);
		}

		if ( isset( $atts['brand'] ) && $atts['brand'] ) {
			$args['tax_query'][] = array(
				array(
					'taxonomy' => 'product_brand',
					'field'    => 'slug', //This is optional, as it defaults to 'term_id'
					'terms'    => $atts['brand'],
					'operator' => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
				),
			);
		}

		if ( isset( $atts['type'] ) ) {
			switch ( $atts['type'] ) {
				case 'recent':
					$args['order']   = 'DESC';
					$args['orderby'] = 'date';

					unset( $args['update_post_meta_cache'] );
					break;

				case 'featured':
					if ( version_compare( WC()->version, '3.0.0', '<' ) ) {
						$args['meta_query'][] = array(
							'key'   => '_featured',
							'value' => 'yes',
						);
					} else {
						$args['tax_query'][] = array(
							'taxonomy' => 'product_visibility',
							'field'    => 'name',
							'terms'    => 'featured',
							'operator' => 'IN',
						);
					}

					unset( $args['update_post_meta_cache'] );
					break;

				case 'sale':
					$args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
					break;

				case 'best_selling':
					$args['meta_key'] = 'total_sales';
					$args['orderby']  = 'meta_value_num';
					$args['order']    = 'DESC';
					break;

				case 'top_rated':
					$args['meta_key'] = '_wc_average_rating';
					$args['orderby']  = 'meta_value_num';
					$args['order']    = 'DESC';
					break;
			}
		}

		return $args;
	}

	public static function product_deals_countdown() {
		global $product;

		if ( ! function_exists( 'tawc_is_deal_product' ) ) {
			return;
		}

		if ( ! tawc_is_deal_product( $product ) ) {
			return;
		}

		$expire_date = ! empty( $product->get_date_on_sale_to() ) ? $product->get_date_on_sale_to()->getOffsetTimestamp() : '';

		if ( empty( $expire_date ) ) {
			return;
		}

		$now = strtotime( current_time( 'Y-m-d H:i:s' ) );

		$expire = $expire_date - $now;

		if ( $expire <= 0 ) {
			return;
		}

		$deals = array(
			'days'    => esc_html__( 'days', 'farmart' ),
			'hours'   => esc_html__( 'hrs', 'farmart' ),
			'minutes' => esc_html__( 'mins', 'farmart' ),
			'seconds' => esc_html__( 'secs', 'farmart' ),
		);

		?>
        <div class="tawc-deal deal">
			<?php if ( $expire ) : ?>
                <div class="deal-expire-date">
                    <div class="deal-expire-countdown" data-expire="<?php echo esc_attr( $expire ) ?>"
                         data-text="<?php echo esc_attr( wp_json_encode( $deals ) ) ?>"></div>
                </div>
			<?php endif; ?>
        </div>
		<?php
	}

	function fm_child_product_categories_widget_args( $args ) {
		$args['use_desc_for_title'] = 0;

		return $args;
	}

	public static function fm_pagination() {
		$nav_type = apply_filters( 'farmart_catalog_nav_type', farmart_get_option( 'catalog_nav_type' ) );

		if ( 'numeric' == $nav_type ) {
			woocommerce_pagination();
		} elseif ( 'numeric-short' == $nav_type ) {
			global $wp_query;

			$total_page = $wp_query->max_num_pages;
			$paged      = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

			$pages_url = [];
			for ( $x = 1; $x <= $total_page; $x ++ ) {
				$pages_url[] = '<input id="fm-catalog-url-page-' . esc_attr( $x ) . '" type="hidden" value="' . esc_attr( esc_url( get_pagenum_link( $x ) ) ) . '">';
			}

			$paged_html = '<form class="fm-toolbar-pagination" method="post">' .
							'<input id="fm-catalog-page-number" type="number" value="' . esc_attr( $paged ) . '" min="1" max="' . esc_attr( $total_page ) . '" step="1">' .
							implode( "\n", $pages_url ) .
							'</form>';
			$prev_html = get_previous_posts_link( Farmart\Icon::get_svg( 'chevron-left' ) );
			$next_html = get_next_posts_link( Farmart\Icon::get_svg( 'chevron-right' ) );
			echo '<div class="fm-pagination-numeric-short">' . $prev_html . $paged_html . ' / ' . $total_page . $next_html .'</div>';
		} elseif ( get_next_posts_link() ) {
			$classes = array(
				'woocommerce-navigation',
				'next-posts-navigation',
				'ajax-navigation',
				'ajax-' . $nav_type,
			);

			$button_html = sprintf(
				'<span class="load-more-text">%s</span>
				<span class="loading-icon">
					<span class="loading-text">%s</span>
					<span class="loading-bubbles">
						<span class="bubble"><span class="dot"></span></span>
						<span class="bubble"><span class="dot"></span></span>
						<span class="bubble"><span class="dot"></span></span>
					</span>
				</span>',
				esc_html__( 'Load More', 'farmart' ),
				esc_html__( 'Loading', 'farmart' )
			);

			echo '<nav class="' . esc_attr( implode( ' ', $classes ) ) . '">';
			echo '<div class="nav-links">';
			next_posts_link( $button_html );
			echo '</div>';
			echo '</nav>';
		}
	}

	public static function fm_pagination_args( $args ) {
		if ( ! farmart_is_catalog() ) {
			return $args;
		}

		$args['prev_text'] = Farmart\Icon::get_svg( 'chevron-left' );
		$args['next_text'] = Farmart\Icon::get_svg( 'chevron-right' );

		return $args;
	}

}