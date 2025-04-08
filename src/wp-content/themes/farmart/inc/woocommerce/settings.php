<?php
/**
 * Functions and Hooks for product meta box data
 *
 * @package Farmart
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Farmart_WooCommerce_Settings class.
 */
class Farmart_WooCommerce_Settings {

	/**
	 * Constructor.
	 */
	public static function init() {
		if ( ! function_exists( 'is_woocommerce' ) ) {
			return false;
		}
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );

		// Add form
		add_action( 'woocommerce_product_data_panels', array( __CLASS__, 'product_meta_fields' ) );
		add_action( 'woocommerce_product_data_tabs', array( __CLASS__, 'product_meta_tab' ) );
		add_action( 'woocommerce_process_product_meta', array( __CLASS__, 'product_meta_fields_save' ) );

		add_action( 'wp_ajax_product_meta_fields', array( __CLASS__, 'instance_product_meta_fields' ) );
		add_action( 'wp_ajax_nopriv_product_meta_fields', array( __CLASS__, 'instance_product_meta_fields' ) );
	}

	public static function  enqueue_scripts( $hook ) {
		$screen = get_current_screen();
		if ( in_array( $hook, array( 'post.php', 'post-new.php' ) ) && $screen->post_type == 'product' ) {
			wp_enqueue_script( 'farmart_wc_settings_js', get_template_directory_uri() . '/js/backend/woocommerce.js', array( 'jquery' ), '20190717', true );
			wp_enqueue_style( 'farmart_wc_settings_style', get_template_directory_uri() . "/css/woocommerce-settings.css", array(), '20190717' );
		}
	}

	/**
	 * Get product data fields
	 *
	 */
	public static function instance_product_meta_fields() {
		$post_id = $_POST['post_id'];
		ob_start();
		self::create_product_extra_fields( $post_id );
		$response = ob_get_clean();
		wp_send_json_success( $response );
		die();
	}

	/**
	 * Product data tab
	 */
	public static function product_meta_tab( $product_data_tabs ) {
		$product_data_tabs['farmart_attributes_extra'] = array(
			'label'  => esc_html__( 'Extra', 'farmart' ),
			'target' => 'product_attributes_extra',
			'class'  => 'product-attributes-extra'
		);

		$product_data_tabs['farmart_pbt_product'] = array(
			'label'  => esc_html__( 'Frequently Bought Together', 'farmart' ),
			'target' => 'farmart_pbt_product_data',
			'class'  => array( 'hide_if_grouped', 'hide_if_external', 'hide_if_bundle' ),
		);

		return $product_data_tabs;
	}

	/**
	 * Add product data fields
	 *
	 */
	public static function product_meta_fields() {
		global $post;
		self::create_product_extra_fields( $post->ID );
	}

	/**
	 * product_meta_fields_save function.
	 *
	 * @param mixed $post_id
	 */
	public static function product_meta_fields_save( $post_id ) {

		if ( isset( $_POST['attributes_extra'] ) ) {
			$woo_data = $_POST['attributes_extra'];
			update_post_meta( $post_id, 'attributes_extra', $woo_data );
		}

		if ( isset( $_POST['custom_unit_price'] ) ) {
			$woo_data = $_POST['custom_unit_price'];
			update_post_meta( $post_id, 'custom_unit_price', $woo_data );
		}

		if ( isset( $_POST['custom_badges_text'] ) ) {
			$woo_data = $_POST['custom_badges_text'];
			update_post_meta( $post_id, 'custom_badges_text', $woo_data );
		}

		if ( isset( $_POST['custom_badges_bg'] ) ) {
			$woo_data = $_POST['custom_badges_bg'];
			update_post_meta( $post_id, 'custom_badges_bg', $woo_data );
		}

		if ( isset( $_POST['custom_badges_color'] ) ) {
			$woo_data = $_POST['custom_badges_color'];
			update_post_meta( $post_id, 'custom_badges_color', $woo_data );
		}

		if ( isset( $_POST['_is_new'] ) ) {
			$woo_data = $_POST['_is_new'];
			update_post_meta( $post_id, '_is_new', $woo_data );
		} else {
			update_post_meta( $post_id, '_is_new', 0 );
		}

		if ( isset( $_POST['fm_pbt_product_ids'] ) ) {
			$woo_data = $_POST['fm_pbt_product_ids'];
			update_post_meta( $post_id, 'fm_pbt_product_ids', $woo_data );
		} else {
			update_post_meta( $post_id, 'fm_pbt_product_ids', 0 );
		}
	}

	/**
	 * Create product meta fields
	 *
	 * @param $post_id
	 */
	public static function create_product_extra_fields( $post_id ) {
		global $post;

		$post_custom = get_post_custom( $post_id );


		echo '<div id="product_attributes_extra" class="panel woocommerce_options_panel">';

		woocommerce_wp_text_input(
			array(
				'id'       => 'custom_unit_price',
				'label'    => esc_html__( 'Custom Unit Price', 'farmart' ),
				'desc_tip' => esc_html__( 'Enter this optional to show your unit text box.', 'farmart' ),
			)
		);

		woocommerce_wp_text_input(
			array(
				'id'       => 'custom_badges_text',
				'label'    => esc_html__( 'Custom Badge Text', 'farmart' ),
				'desc_tip' => esc_html__( 'Enter this optional to show your badges.', 'farmart' ),
			)
		);

		woocommerce_wp_checkbox(
			array(
				'id'          => '_is_new',
				'label'       => esc_html__( 'New product?', 'farmart' ),
				'description' => esc_html__( 'Enable to set this product as a new product. A "New" badge will be added to this product.', 'farmart' ),
			)
		);
		echo '</div>';

		?>
		<div id="farmart_pbt_product_data" class="panel woocommerce_options_panel">

			<div class="options_group">

				<p class="form-field">
					<label for="fm_pbt_product_ids"><?php esc_html_e( 'Select Products', 'farmart' ); ?></label>
					<select class="wc-product-search short" multiple="multiple" id="fm_pbt_product_ids" name="fm_pbt_product_ids[]" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', 'farmart' ); ?>" data-action="woocommerce_json_search_products_and_variations" data-exclude="<?php echo intval( $post->ID ); ?>">
						<?php
						$product_ids = maybe_unserialize( get_post_meta( $post->ID, 'fm_pbt_product_ids', true ) );

						if( $product_ids && is_array( $product_ids ) ) {
							foreach ( $product_ids as $product_id ) {
								$product = wc_get_product( $product_id );
								if ( is_object( $product ) ) {
									echo '<option value="' . esc_attr( $product_id ) . '"' . selected( true, true, false ) . '>' . $product->get_formatted_name() . '</option>';
								}
							}
						}

						?>
					</select> <?php echo wc_help_tip( __( 'Select products for "Frequently bought together" group.', 'farmart' ) ); ?>
				</p>

			</div>

		</div>
		<?php
	}

}