<?php

namespace FarmartAddons;

use Elementor\Core\Responsive\Responsive;
use Elementor\Group_Control_Image_Size;

/**
 * Integrate with Elementor.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Elementor {
	/**
	 * Instance
	 *
	 * @access private
	 */
	private static $_instance = null;

	/**
	 * Elementor modules
	 *
	 * @var array
	 */
	public $modules = [];


	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @return Farmart_Addons_Elementor An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Constructor
	 */
	public function __construct() {
		spl_autoload_register( [ $this, 'autoload' ] );

		$this->_includes();
		$this->add_actions();
	}

	/**
	 * Auto load widgets
	 */
	public function autoload( $class ) {
		if ( 0 !== strpos( $class, __NAMESPACE__ ) ) {
			return;
		}

		if ( false === strpos( $class, 'Widgets' ) ) {
			return;
		}

		$path     = explode( '\\', $class );
		$filename = strtolower( array_pop( $path ) );

		$folder = array_pop( $path );

		if ( ! in_array( $folder, array( 'Widgets', 'Modules' ) ) ) {
			return;
		}

		if ( 'Headers' == $folder || 'Footer' == $folder || 'Mobile' == $folder ) {
			$filename = strtolower( $folder ) . '/' . $filename;
		}

		$filename = str_replace( '_', '-', $filename );
		$filename = FARMART_ADDONS_DIR . 'inc/elementor/widgets/' . $filename . '.php';

		if ( is_readable( $filename ) ) {
			include( $filename );
		}
	}

	/**
	 * Includes files which are not widgets
	 */
	private function _includes() {
		include_once( FARMART_ADDONS_DIR . 'inc/elementor/widgets/ajaxloader.php' );
		include_once( FARMART_ADDONS_DIR . 'inc/elementor/modules/custom-css.php' );
	}

	/**
	 * Hooks to init
	 */
	protected function add_actions() {
		if ( ! empty( $_REQUEST['action'] ) && 'elementor' === $_REQUEST['action'] && is_admin() ) {
			add_action( 'init', [ $this, 'register_wc_hooks' ], 5 );
		}

		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'styles' ] );
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'scripts' ] );


		add_action( 'elementor/controls/controls_registered', [ $this, 'init_controls' ] );
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );

		add_action( 'elementor/elements/categories_registered', [ $this, 'add_category' ] );

		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'enqueue_editor_scripts' ] );
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'editor_styles' ] );

		add_action( 'post_class', [ $this, 'get_product_classes' ], 20, 3 );

		add_action( 'wc_ajax_nopriv_fm_elementor_load_products', [ $this, 'elementor_load_products' ] );
		add_action( 'wc_ajax_fm_elementor_load_products', [ $this, 'elementor_load_products' ] );

		add_action( 'wc_ajax_nopriv_fm_elementor_load_products_deals', [ $this, 'elementor_load_products_deals' ] );
		add_action( 'wc_ajax_fm_elementor_load_products_deals', [ $this, 'elementor_load_products_deals' ] );

		add_action( 'wp_footer', [ $this, 'farmart_vertical_tab' ]);

		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );

		add_action( 'elementor/init', [ $this, 'init_modules' ] );

	}

	public function enqueue_styles() {
		\Elementor\Plugin::$instance->frontend->enqueue_styles();
	}


	public function register_wc_hooks() {
		if( ! class_exists('WooCommerce') ) {
			return;
		}
		wc()->frontend_includes();
	}

	public function get_product_classes( $classes, $class, $post_id ) {
		if ( is_admin() && \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			$post      = get_post( $post_id );
			$classes[] = $post->post_type;
		}

		return $classes;
	}

	/**
	 * Register styles
	 */
	public function styles() {
		wp_register_style( 'mapbox', FARMART_ADDONS_URL . 'assets/css/mapbox.css', array(), '1.0' );
		wp_register_style( 'mapboxgl', FARMART_ADDONS_URL . 'assets/css/mapbox-gl.css', array(), '1.0' );
	}

	/**
	 * Register styles
	 */
	public function scripts() {
		wp_register_script( 'farmart-elementor', FARMART_ADDONS_URL . '/assets/js/elementor.js', array( 'jquery' ), '20170530', true );

		wp_register_script( 'mapbox', FARMART_ADDONS_URL  . '/assets/js/plugins/mapbox.min.js', array(), '1.0', true );
		wp_register_script( 'mapboxgl', FARMART_ADDONS_URL  . '/assets/js/plugins/mapbox-gl.min.js', array(), '1.0', true );
		wp_register_script( 'mapbox-sdk', FARMART_ADDONS_URL  . '/assets/js/plugins/mapbox-sdk.min.js', array(), '1.0', true );

		wp_localize_script(
			'farmart-elementor', 'fm_elementor_data', array(
			'ajax_url' => $this->get_endpoint( '%%endpoint%%' ),
		) );
	}

	public function get_endpoint( $request = '' ) {
		return esc_url_raw( apply_filters( 'woocommerce_ajax_get_endpoint', add_query_arg( 'wc-ajax', $request, remove_query_arg( array(
			'remove_item',
			'add-to-cart',
			'added-to-cart',
			'order_again',
			'_wpnonce'
		), home_url( '/', 'relative' ) ) ), $request ) );
	}


	/**
	 * Enqueue editor scripts
	 */
	public function enqueue_editor_scripts() {
		wp_enqueue_script(
			'farmart-elementor-modules',
			FARMART_ADDONS_URL . 'assets/js/elementor-modules.js',
			[
				'backbone-marionette',
				'elementor-common-modules',
				'elementor-editor-modules',
			],
			FARMART_ADDONS_URL,
			true
		);
	}

	/**
	 * Register styles
	 */
	public function editor_styles() {
		wp_enqueue_style( 'farmartIcon', get_template_directory_uri() . '/css/farmartIcon.css', array(), '1.0.0' );
	}

	/**
	 * Init Controls
	 */
	public function init_controls( $controls_registry ) {
		add_action( 'elementor/icons_manager/additional_tabs', [ $this, 'elementor_custom_icons' ] );
	}

	public function elementor_custom_icons( $additional_tabs ) {
		$additional_tabs['farmartIcon'] = [
			'name'          => 'farmartIcon',
			'label'         => esc_html__( 'Farmart Icon', 'farmart-addons' ),
			'url'           => get_template_directory_uri(). '/css/farmartIcon.css',
			'enqueue'       => [ get_template_directory_uri(). '/css/farmartIcon.css' ],
			'prefix'        => 'icon-',
			'displayPrefix' => 'icon',
			'labelIcon'     => 'icon-check',
			'ver'           => '1.0.0',
			'fetchJson'     => get_template_directory_uri(). '/js/farmartIcon.js',
			'native'        => true,
		];

		return $additional_tabs;
	}

	/**
	 * Init Widgets
	 */
	public function init_widgets() {
		$widgets_manager = \Elementor\Plugin::instance()->widgets_manager;

		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Simple_Text() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Slides() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Blog() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Icon_List_Box() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Service_Box() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Testimonial() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Testimonial_2() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Testimonial_3() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Testimonial_Banner() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Image_Grid() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Team_Grid() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Team_Carousel() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Counter() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Icon_List_Grid() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Quotes() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Tab_List() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Faq() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Faqs() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Heading() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Newsletter() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Icon_Box() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Banner_Carousel() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Banner_Medium_3() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Banner_Larger() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Banner_Video() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Promotion() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Icon_List_Box_2() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Countdown() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Contact_Form_7() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Image_Carousel() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Image_Box() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Product_Categories_Carousel() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Product_Categories_Carousel_2() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Product_Categories_Carousel_3() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Product_Categories_List() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Product_Categories_Grid() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Products_Tab_Carousel() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Products_Tab_Carousel_2() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Products_Tab_Carousel_3() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Products_Carousel() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Products_Carousel_2() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Products_List_Carousel() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Products_Carousel_With_Category() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Products_With_Category() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Recently_Viewed_Products() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Separator() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Product_Deals_Carousel() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Product_Deals_Grid() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Product_Deals_Carousel_2() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Product_Deals_Carousel_3() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Brands_Carousel() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Products_Brands() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Page_Title() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Map() );
		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Register_Form() );

		$widgets_manager->register_widget_type( new \FarmartAddons\Elementor\Widgets\Trending_Search_Carousel() );
	}

	/**
	 * Add Farmart category
	 */
	public function add_category( $elements_manager ) {
		$elements_manager->add_category(
			'farmart',
			[
				'title' => esc_html__( 'Farmart', 'farmart-addons' )
			]
		);
	}


	/**
	 * Retrieve the list of taxonomy
	 *
	 * @return array Widget categories.
	 */
	public static function get_taxonomy( $taxonomy = 'product_cat' ) {

		$output = array();

		$categories = get_categories(
			array(
				'taxonomy' => $taxonomy
			)
		);

		foreach ( $categories as $category ) {
			$output[$category->slug] = $category->name;
		}

		return $output;
	}

	public static function get_taxonomy_parent( $taxonomy = 'product_cat' ) {

		$output = array();

		$categories = get_categories(
			array(
				'taxonomy'  => $taxonomy,
				'parent'    => '0',
				"orderby"   => "count",
				"order"     => "DESC"
			)
		);

		foreach ( $categories as $category ) {
			$output[$category->slug] = $category->name;
		}

		return $output;
	}


	/**
	 * @param array $settings
	 *
	 * @return array Slick Options
	 */
	public static function get_data_slick( $settings = array() ) {
		$carousel_settings = [];

		if ( isset($settings['navigation']) ) {
			$show_dots   = ( in_array( $settings['navigation'], [ 'dots', 'both' ] ) );
			$show_arrows = ( in_array( $settings['navigation'], [ 'arrows', 'both' ] ) );

			$carousel_settings['arrows'] = $show_arrows;
			$carousel_settings['dots']   = $show_dots;
		}

		if ( isset($settings['autoplay']) ) {
			$carousel_settings['autoplay'] = ( 'yes' === $settings['autoplay'] );
		}

		if ( isset($settings['infinite']) ) {
			$carousel_settings['infinite'] = ( 'yes' === $settings['infinite'] );
		}

		if ( isset($settings['autoplay_speed']) ) {
			$carousel_settings['autoplaySpeed'] = absint( $settings['autoplay_speed'] );
		}

		if ( isset($settings['speed']) ) {
			$carousel_settings['speed'] = absint( $settings['speed'] );
		}

		if ( isset($settings['rows']) && $settings['rows'] ) {
			$carousel_settings['rows'] = absint( $settings['rows'] );
		}

		if ( isset($settings['slidesToShow']) && $settings['slidesToShow'] ) {
			$carousel_settings['slidesToShow'] = absint( $settings['slidesToShow'] );
		}

		if ( isset($settings['slidesToScroll']) && $settings['slidesToScroll'] ) {
			$carousel_settings['slidesToScroll'] = absint( $settings['slidesToScroll'] );
		}

		$is_rtl = is_rtl();
		$carousel_settings['rtl'] = $is_rtl;

		// Responsive
		$responsive_args = [];

		$breakpoints = Responsive::get_breakpoints();

		// Tablet Handler
		$tablet_params = [];
		$tablet_breakpoint = $breakpoints['lg'] - 1;
		if ( isset($settings['navigation_tablet']) && $settings['navigation_tablet'] ) {
			$show_dots_tablet = ( in_array( $settings['navigation_tablet'], [ 'dots', 'both' ] ) );
			$show_arrows_tablet = ( in_array( $settings['navigation_tablet'], [ 'arrows', 'both' ] ) );

			$tablet_params['arrows'] = $show_arrows_tablet;
			$tablet_params['dots']   = $show_dots_tablet;
		}

		if (isset($settings['slidesToShow_tablet']) && $settings['slidesToShow_tablet']) {
			$tablet_params['slidesToShow'] = absint( $settings['slidesToShow_tablet'] );
		}

		if (isset($settings['slidesToScroll_tablet']) && $settings['slidesToScroll_tablet']) {
			$tablet_params['slidesToScroll'] = absint( $settings['slidesToScroll_tablet'] );
		}

		if (isset($settings['rows_tablet']) && $settings['rows_tablet']) {
			$tablet_params['rows'] = absint( $settings['rows_tablet'] );
		}

		if ( ! empty($tablet_params) ) {
			$responsive_args[$tablet_breakpoint] = [
				'breakpoint' => absint($tablet_breakpoint),
				'settings'   => $tablet_params
			];
		}

		// Mobile Handler
		$mobile_params = [];
		$mobile_breakpoint = $breakpoints['md'] - 1;
		if ( isset($settings['navigation_mobile']) && $settings['navigation_mobile'] ) {
			$show_dots_mobile = ( in_array( $settings['navigation_mobile'], [ 'dots', 'both' ] ) );
			$show_arrows_mobile = ( in_array( $settings['navigation_mobile'], [ 'arrows', 'both' ] ) );

			$mobile_params['arrows'] = $show_arrows_mobile;
			$mobile_params['dots']   = $show_dots_mobile;
		}

		if (isset($settings['slidesToShow_mobile']) && $settings['slidesToShow_mobile']) {
			$mobile_params['slidesToShow'] = absint( $settings['slidesToShow_mobile'] );
		}

		if (isset($settings['slidesToScroll_mobile']) && $settings['slidesToScroll_mobile']) {
			$mobile_params['slidesToScroll'] = absint( $settings['slidesToScroll_mobile'] );
		}

		if (isset($settings['rows_mobile']) && $settings['rows_mobile']) {
			$mobile_params['rows'] = absint( $settings['rows_mobile'] );
		}

		if ( ! empty($mobile_params) ) {
			$responsive_args[$mobile_breakpoint] = [
				'breakpoint' => absint($mobile_breakpoint),
				'settings'   => $mobile_params
			];
		}

		// Advance Settings
		if ( isset($settings['carousel_responsive_settings']) && ! empty($settings['carousel_responsive_settings']) ) {

			$responsive_settings = $settings['carousel_responsive_settings'];

			foreach ($responsive_settings as $setting) {
				$params = [];

				if ( isset($setting['responsive_navigation']) && $setting['responsive_navigation'] ) {
					$show_dots_res = ( in_array( $setting['responsive_navigation'], [ 'dots', 'both' ] ) );
					$show_arrows_res = ( in_array( $setting['responsive_navigation'], [ 'arrows', 'both' ] ) );

					$params['arrows'] = $show_arrows_res;
					$params['dots']   = $show_dots_res;
				}

				if (isset($setting['responsive_slidesToShow']) && $setting['responsive_slidesToShow']) {
					$params['slidesToShow'] = absint( $setting['responsive_slidesToShow'] );
				}

				if (isset($setting['responsive_slidesToScroll']) && $setting['responsive_slidesToScroll']) {
					$params['slidesToScroll'] = absint( $setting['responsive_slidesToScroll'] );
				}

				if (isset($setting['responsive_rows']) && $setting['responsive_rows']) {
					$params['rows'] = absint( $setting['responsive_rows'] );
				}

				if ( isset($setting['responsive_breakpoint']) && $setting['responsive_breakpoint'] ) {
					$responsive_args[$setting['responsive_breakpoint']] = [
						'breakpoint' => absint($setting['responsive_breakpoint']),
						'settings'   => $params
					];
				}
			}
		}

		if ( ! empty($responsive_args) ) {
			krsort($responsive_args);

			foreach ($responsive_args as $value) {
				$carousel_settings['responsive'][] = $value;
			}
		}

		return $carousel_settings;
	}

	/**
	 * Get pagination numeric
	 *
	 * @return string.
	 */

	public static function pagination_numeric( $max_num_pages, $align_class ) {
		if ( $max_num_pages < 2 ) {
			return;
		}
		?>
		<nav class="navigation paging-navigation numeric-navigation <?php echo esc_attr( $align_class ); ?>">
			<?php
			$big  = 999999999;
			$args = array(
				'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'total'     => $max_num_pages,
				'current'   => max( 1, get_query_var( 'paged' ) ),
				'prev_text' => esc_html__( 'Previous', 'farmart-addons' ),
				'next_text' => esc_html__( 'Next', 'farmart-addons' ),
				'type'      => 'plain',
			);

			echo paginate_links( $args );
			?>
		</nav>
		<?php
	}

	public static function farmart_get_brand( $atts ) {

		$atts = array(
			'taxonomy'   	=> 'product_brand',
			'hide_empty' 	=> 1,
			'number'     	=> $atts['limit'],
			'orderby'     	=> $atts['orderby'],
			'order'     	=> $atts['order'],
		);

		$terms   = get_terms( $atts );

		$output  = array();

		if ( is_wp_error( $terms ) ) {
			return;
		}

		if ( empty( $terms ) || ! is_array( $terms ) ) {
			return;
		}

		foreach ( $terms as $term ) {

			$thumbnail_id = absint( get_term_meta( $term->term_id, 'brand_thumbnail_id', true ) );
			if ( $thumbnail_id ) {
				$output[] = sprintf(
					'<div class="brand-item">' .
					'<a href="%s">%s</a>' .
					'</div>',
					get_term_link( $term->term_id, 'product_brand' ),
					farmart_get_image_html( $thumbnail_id, 'full' )
				);
			}

		}

		return implode('', $output );
	}

	/**
	 * Brands Loop
	 */
	public static function brands_loop( $settings ) {
		$taxonomy = 'product_brand';

		$term_count    = get_terms( $taxonomy, [ 'fields' => 'count' ] );
		$max_num_pages = ceil( $term_count / $settings['perpage'] );

		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) {
			$paged = get_query_var( 'page' );
		} else {
			$paged = 1;
		}

		$offset = ( ( $paged - 1 ) * $settings['perpage'] );

		$terms = get_terms(
			array(
				'taxonomy' => $taxonomy,
				'orderby'  => $settings['brand_orderby'],
				'order'    => $settings['brand_orderby'] == 'menu_order'? 'asc' : $settings['brand_order'],
				'number'   => $settings['perpage'],
				'count'    => true,
				'offset'   => $offset
			)
		);

		if ( is_wp_error( $terms ) && ! $terms ) {
			return;
		}

		$output = [ ];

		foreach ( $terms as $term ) {
			$settings['product_brand'] = $term->slug;

			$thumbnail_id = absint( get_term_meta( $term->term_id, 'brand_thumbnail_id', true ) );
			$desc = !empty($term->description) ? sprintf('<div class = "brand-info__desc">%s</div>',esc_html($term->description)) : '';

			$thumbnail = '';
			if ( $thumbnail_id ) {
				$thumbnail = sprintf(
					'<a href="%s" class="brand-logo">%s</a>',
					esc_url( get_term_link( $term->term_id, 'product_brand' ) ),
					wp_get_attachment_image( $thumbnail_id, 'full' )
				);
			}

			$count = sprintf( _n( '%s item', '%s items', $term->count, 'farmart-addons' ), number_format_i18n( $term->count ) );

			$output[] = sprintf(
				'<div class="brand-item-wrapper">
					<div class="brand-item">
						<div class="brand-item__header">
							<div class="brand-info">
								%s
								<a href="%s" class="brand-info__name">%s</a>
								%s
							</div>
							<a href="%s" class="brand-btn">%s <span>%s</span> %s</a>
						</div>
						<div class="brand-item__content">%s</div>
					</div>
				</div>',
				$thumbnail,
				esc_url( get_term_link( $term->term_id, 'product_brand' ) ),
				esc_html( $term->name ),
				$desc,
				esc_url( get_term_link( $term->term_id, 'product_brand' ) ),
				esc_html__('View All', 'farmart-addons'),
				$count,
				\Farmart\Icon::get_svg( 'chevron-right' ),
				self::get_products_loop( $settings )
			);
		}

		$load_more = '';
		if ( $max_num_pages > 1 && $settings['load_more']) {
			$load_more .= '<div class="load-more text-center">';
			$load_more .= get_next_posts_link( esc_html__( 'Load More', 'farmart-addons' ), $max_num_pages );
			$load_more .= '</div>';
		}

		return sprintf( '<div class="product-brands">%s</div>%s', implode( '', $output ), $load_more );
	}

	/**
	 * Product Loop
	 */
	public static function get_products( $atts ) {
		$params   = '';
		$order    = $atts['order'];
		$order_by = $atts['orderby'];
		if ( $atts['products'] == 'featured' ) {
			$params = 'visibility="featured"';
		} elseif ( $atts['products'] == 'best_selling' ) {
			$params = 'best_selling="true"';
		} elseif ( $atts['products'] == 'sale' ) {
			$params = 'on_sale="true"';
		} elseif ( $atts['products'] == 'recent' ) {
			$order    = $order ? $order : 'desc';
			$order_by = $order_by ? $order_by : 'date';
		} elseif ( $atts['products'] == 'top_rated' ) {
			$params = 'top_rated="true"';
		}

		$params .= ' columns="' . intval( $atts['columns'] ) . '" limit="' . intval( $atts['per_page'] ) . '" order="' . $order . '" orderby ="' . $order_by . '"';
		if ( ! empty( $atts['product_cats'] ) ) {
			$cats = $atts['product_cats'];
			if ( is_array( $cats ) ) {
				$cats = implode( ',', $cats );
			}

			$params .= ' category="' . $cats . '" ';
		}

		if ( ! empty( $atts['product_tags'] ) ) {
			$params .= ' tag="' . implode( ',', $atts['product_tags'] ) . '" ';
		}

		if ( ! empty( $atts['ids'] ) ) {
			$params .= ' ids="' . $atts['ids'] . '" ';
		}

		$classes = '';
		if ( isset( $atts['product_brands'] ) && ! empty( $atts['product_brands'] ) ) {
			$classes = 'sc_brand,' . implode( ',', $atts['product_brands'] );
		}
		if ( isset( $atts['product_collections'] ) && ! empty( $atts['product_collections'] ) ) {
			$classes .= empty( $classes ) ? '' : ' ,';
			$classes .= 'sc_collection,' . implode( ',', $atts['product_collections'] );
		}
		if( ! empty( $classes ) ) {
			$params .= ' class="' . $classes . '" ';
		}

		return do_shortcode( '[products ' . $params . ']' );
	}

	/**
	 * Get the product deals
	 *
	 * @return string.
	 */
	public static function get_products_loop( $settings, $template = 'product' ) {
		$per_page   = intval( $settings['per_page'] );
		$query_args = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'posts_per_page'      => $per_page,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
			'meta_query'          => WC()->query->get_meta_query(),
			'tax_query'           => WC()->query->get_tax_query(),
			'orderby'             => $settings['orderby'],
			'order'               => $settings['order'],
			'fields'              => 'ids',
		);

		if ( isset( $settings['product_cats'] ) && $settings['product_cats'] ) {
			$query_args['tax_query'][] = array(
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => explode( ',', $settings['product_cats'] ),
				)
			);
		}

		if ( isset( $settings['product_brand'] ) && $settings['product_brand'] ) {
			$query_args['tax_query'][] = array(
				array(
					'taxonomy' => 'product_brand',
					'field'    => 'slug', //This is optional, as it defaults to 'term_id'
					'terms'    => explode( ',', $settings['product_brand'] ),
					'operator' => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
				),
			);
		}

		$products = new \WP_Query( $query_args );


		if ( ! $products->have_posts() ) {
			return '';
		}

		global $woocommerce_loop;

		$woocommerce_loop['columns'] = isset( $settings['columns'] ) && $settings['columns'] ? intval( $settings['columns'] ) : 1;

		ob_start();

		self::products_loop( $products->posts, $template );

		$output = '<div class="woocommerce">' . ob_get_clean() . '</div>';

		$total_page = $products->max_num_pages;

		$params = array(
			'per_page' 		=> intval( $settings['per_page'] ),
			'columns'  		=> isset( $settings['columns'] ) && $settings['columns'] ? intval( $settings['columns'] ) : 1,
			'product_cats' 	=> isset( $settings['product_cats'] ) && $settings['product_cats'] ? $settings['product_cats'] : '',
			'orderby'  		=> isset( $settings['orderby'] ) && $settings['orderby'] ? $settings['orderby'] : '',
			'order'    		=> isset( $settings['order'] ) && $settings['order'] ? $settings['order'] : '',
			'page'     		=> isset( $settings['page'] ) && $settings['page'] ? $settings['page'] : 1,
		);

		wp_reset_postdata();

		return $output;
	}

	/**
	 * Load products
	 */
	public static function elementor_load_products() {

		$atts = array(
			'columns'      => isset( $_POST['columns'] ) ? intval( $_POST['columns'] ) : '',
			'products'     => isset( $_POST['products'] ) ? $_POST['products'] : '',
			'order'        => isset( $_POST['order'] ) ? $_POST['order'] : '',
			'orderby'      => isset( $_POST['orderby'] ) ? $_POST['orderby'] : '',
			'per_page'     => isset( $_POST['per_page'] ) ? intval( $_POST['per_page'] ) : '',
			'product_cats' => isset( $_POST['product_cats'] ) ? $_POST['product_cats'] : '',
		);

		$products = self::get_products( $atts );

		wp_send_json_success( $products );
	}

	/**
	 * Load products
	 */
	public static function elementor_load_products_deals() {

		$settings = $_POST['product_deal'];

		$atts = array(
			'product_type'   => isset( $_POST['product_type'] ) ? $_POST['product_type'] : '',
			'pagination'     => isset( $_POST['pagination'] ) ? $_POST['pagination'] : '',
			'load_more_text' => isset( $_POST['text'] ) ? $_POST['text'] : '',
			'page'           => isset( $_POST['page'] ) ? $_POST['page'] : 1,

			'per_page'       => intval( $settings['per_page'] ),
			'columns'        => intval( $settings['columns'] ),
			'product_cats'   => $settings['product_cats'],
			'orderby'        => $settings['orderby'],
			'order'          => $settings['order'],
		);

		$products = self::get_product_deals( $atts );

		wp_send_json_success( $products );
	}

	/**
	 * Loop over products
	 *
	 * @param array $products_ids
	 */
	public static function get_loop_deals( $products_ids, $template ) {
		update_meta_cache( 'post', $products_ids );
		update_object_term_cache( $products_ids, 'product' );

		$original_post = $GLOBALS['post'];

		woocommerce_product_loop_start();

		foreach ( $products_ids as $product_id ) {
			$GLOBALS['post'] = get_post( $product_id ); // WPCS: override ok.
			setup_postdata( $GLOBALS['post'] );
			wc_get_template_part( 'content', $template );
		}

		$GLOBALS['post'] = $original_post; // WPCS: override ok.
		woocommerce_product_loop_end();

		wp_reset_postdata();
		woocommerce_reset_loop();
	}

	/**
	 * Get the product deals
	 *
	 * @return string.
	 */
	public static function get_product_deals( $settings, $template = 'product', $other_type = false, $other_product_cats = false ) {
		$per_page   = intval( $settings['per_page'] );
		$query_args = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'posts_per_page'      => $per_page,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
			'fields'              => 'ids',
			'post__in'            => (array) wc_get_product_ids_on_sale(),
			'meta_query'          => WC()->query->get_meta_query(),
			'tax_query'           => WC()->query->get_tax_query(),
			'orderby'             => $settings['orderby'],
			'order'               => $settings['order'],
		);

		if ( $settings['pagination'] == 'yes' ) {
			$query_args['paged']         = isset( $settings['page'] ) ? absint( $settings['page'] ) : 1;
			$query_args['no_found_rows'] = false;
		}

		if ( in_array( $settings['product_type'], array( 'day', 'week', 'month' ) ) ) {
			$date = '+1 day';
			if ( $settings['product_type'] == 'week' ) {
				$date = '+7 day';
			} else if ( $settings['product_type'] == 'month' ) {
				$date = '+1 month';
			}
			$query_args['meta_query'] = apply_filters(
				'farmart_product_deals_meta_query', array_merge(
					WC()->query->get_meta_query(), array(
						array(
							'key'     => '_deal_quantity',
							'value'   => 0,
							'compare' => '>',
						),
						array(
							'key'     => '_sale_price_dates_to',
							'value'   => 0,
							'compare' => '>',
						),
						array(
							'key'     => '_sale_price_dates_to',
							'value'   => strtotime( $date ),
							'compare' => '<=',
						),
					)
				)
			);
		} elseif ( $settings['product_type'] == 'deals' ) {
			$query_args['meta_query'] = apply_filters(
				'farmart_product_deals_meta_query', array_merge(
					WC()->query->get_meta_query(), array(
						array(
							'key'     => '_deal_quantity',
							'value'   => 0,
							'compare' => '>',
						)
					)
				)
			);
		}

		if ( $settings['product_cats'] ) {
			$query_args['tax_query'] = array_merge(
				WC()->query->get_tax_query(), array(
					array(
						'taxonomy' => 'product_cat',
						'field'    => 'slug',
						'terms'    =>  $other_product_cats == false ? explode(',',$settings['product_cats']) : $settings['product_cats'],
					),
				)
			);
		}

		if ( ! empty( $settings['product_brands'] ) ) {
			$query_args['tax_query'] = array_merge(
				WC()->query->get_tax_query(), array(
					array(
						'taxonomy' => 'product_brand',
						'field'    => 'slug',
						'terms'    => $settings['product_brands'],
					),
				)
			);
		}

		if ( ! empty( $settings['product_collections'] ) ) {
			$query_args['tax_query'] = array_merge(
				WC()->query->get_tax_query(), array(
					array(
						'taxonomy' => 'product_collection',
						'field'    => 'slug',
						'terms'    => $settings['product_collections'],
					),
				)
			);
		}

		$deals = new \WP_Query( $query_args );

		if ( ! $deals->have_posts() ) {
			return '';
		}

		global $woocommerce_loop;

		$woocommerce_loop['name'] = 'farmart_product_deals';

		$woocommerce_loop['columns'] = isset( $settings['columns'] ) && $settings['columns'] ? intval( $settings['columns'] ) : 1;

		if ($other_type == true){
			$item_big = $item_list = [];

			$products_ids = $deals->posts;
			update_meta_cache( 'post', $products_ids );
			update_object_term_cache( $products_ids, 'product' );

			$original_post = $GLOBALS['post'];

			woocommerce_product_loop_start();
			$i = 0 ;
			foreach ( $products_ids as $product_id ) {
				ob_start();
				$GLOBALS['post'] = get_post( $product_id ); // WPCS: override ok.
				setup_postdata( $GLOBALS['post'] );
				wc_get_template_part( 'content', $template );

				if ( $i == 0 ) {
					$item_big[] = '<div class="big-size"><ul class="products">' .ob_get_clean(). '</ul></div>';
				} else {
					$item_list[] =  ob_get_clean() ;
				}

				$i++;
			}

			$GLOBALS['post'] = $original_post; // WPCS: override ok.
			woocommerce_product_loop_end();

			wp_reset_postdata();
			woocommerce_reset_loop();

			$html = sprintf('<div class="woocommerce"><ul class="products">%s</ul></div>', implode('',$item_list));

		} else {
			ob_start();

			self::get_loop_deals( $deals->posts, $template );

			$total_page = $deals->max_num_pages;

			$html = '<div class="woocommerce">' . ob_get_clean() . '</div>';
		}



		$params = [
			'per_page'     => intval( $settings['per_page'] ),
			'columns'      => isset( $settings['columns'] ) && $settings['columns'] ? intval( $settings['columns'] ) : 1,
			'product_cats' => $settings['product_cats'],
			'orderby'      => $settings['orderby'],
			'order'        => $settings['order'],
		];

		if ( isset( $settings['page'] ) && $settings['page'] ) {
			$params['page'] = absint( $settings['page'] );
		}

		if ( isset( $settings['pagination'] ) && ( 'yes' == $settings['pagination'] ) && $total_page > 1 ) {
			if ( $params['page'] < $total_page ) {
				$html .= sprintf(
					'<div class="load-more">
						<a href="#" class="ajax-load-products" data-page="%s" data-settings="%s" data-product_type="%s" data-load_more="%s" data-text="%s" data-nonce="%s" rel="nofollow">
							<span class="button-text">
								<span class="button-text--before">%s</span>
								<span class="button-text--after">%s</span>
							</span>
							<div class="after-loading">
								<div class="farmart-blog-loading">
									<span class="loading-icon">
										<span class="bubble"><span class="dot"></span></span>
										<span class="bubble"><span class="dot"></span></span>
										<span class="bubble"><span class="dot"></span></span>
									</span>
								</div>
							</div>
						</a>
					</div>',
					esc_attr( $params['page'] + 1 ),
					esc_attr( json_encode( $params ) ),
					esc_attr( $settings['product_type'] ),
					esc_attr( $settings['pagination'] ),
					esc_attr( $settings['load_more_text'] ),
					esc_attr( wp_create_nonce( 'farmart_get_products_deal' ) ),
					$settings['load_more_text'],
					$settings['load_more_text_loading']
				);
			}
		}

		return $html;
	}

	public static function products_loop( $products_ids, $template = 'product' ) {
		update_meta_cache( 'post', $products_ids );
		update_object_term_cache( $products_ids, 'product' );

		$original_post = $GLOBALS['post'];

		woocommerce_product_loop_start();

		foreach ( $products_ids as $product_id ) {
			$GLOBALS['post'] = get_post( $product_id ); // WPCS: override ok.
			setup_postdata( $GLOBALS['post'] );
			wc_get_template_part( 'content', $template );
		}

		$GLOBALS['post'] = $original_post; // WPCS: override ok.
		woocommerce_product_loop_end();

		wp_reset_postdata();
		woocommerce_reset_loop();
	}

	public static function farmart_vertical_tab() {
		?>
		<div class="fm-vertical-tab" id="fm-vertical-tab"></div>
		<?php
	}

	/**
	 * Init modules
	 */
	public function init_modules() {
		if ( ! defined( 'ELEMENTOR_PRO_VERSION' ) ) {
			$this->modules['custom-css'] = \FarmartAddons\Elementor\Modules\Custom_CSS::instance();
		}
	}

	public function get_svg($svg_name) {
		if ( ! class_exists( '\Farmart\Icon' ) || method_exists( '\Farmart\Icon', 'get_svg' ) ) {
			return '';
		}

		return \Farmart\Icon::get_svg( $svg_name );
	}



}

Elementor::instance();