<?php
/**
 * Register post types
 *
 * @package Farmart
 */

/**
 * Class Farmart_Taxonomies
 */
class Farmart_Product_Collection {

	/**
	 * Construction function
	 *
	 * @since 1.0.0
	 *
	 * @return Farmart_Product_Collection
	 */

	/**
	 * Check if active collection
	 *
	 * @var bool
	 */
	private $active_collection = true;
	private $option = 'product_collection_slug';

	/**
	 * @var string placeholder image
	 */
	public $placeholder_img_src;


	public function __construct() {

		if ( ! function_exists( 'is_woocommerce' ) ) {
			return false;
		}

		add_action( 'admin_init', array( $this, 'settings_api_init' ) );
		add_action( 'current_screen', array( $this, 'settings_save' ) );

		$this->active_collection = apply_filters( 'farmart_register_collection', true );

		if ( ! $this->active_collection ) {
			return false;
		}

		if ( get_option( $this->option ) ) {
			return false;
		}

		// Register custom post type and custom taxonomy
		add_action( 'init', array( $this, 'register_collection' ), 100 );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );

		$this->placeholder_img_src = FARMART_ADDONS_URL . '/img/placeholder.png';
		// Add form
		add_action( 'product_collection_add_form_fields', array( $this, 'add_category_fields' ) );
		add_action( 'product_collection_edit_form_fields', array( $this, 'edit_category_fields' ), 20 );
		add_action( 'created_term', array( $this, 'save_category_fields' ), 20, 3 );
		add_action( 'edit_term', array( $this, 'save_category_fields' ), 20, 3 );

		// Add columns
		add_filter( 'manage_edit-product_collection_columns', array( $this, 'product_collection_columns' ) );
		add_filter( 'manage_product_collection_custom_column', array( $this, 'product_collection_column' ), 10, 3 );

		add_filter( 'woocommerce_sortable_taxonomies', array( $this, 'product_collection_sortable' ) );

	}


	/**
	 * Register custom post type for testimonails
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function register_collection() {
		// Return if post type is exists
		if ( post_type_exists( 'fm-collection' ) ) {
			return;
		}

		if ( ! post_type_exists( 'product' ) ) {
			return;
		}

		$labels = array(
			'name'                       => esc_html__( 'Product Collections', 'farmart-addons' ),
			'singular_name'              => esc_html__( 'Collection', 'farmart-addons' ),
			'search_items'               => esc_html__( 'Search Collection', 'farmart-addons' ),
			'popular_items'              => esc_html__( 'Popular Collections', 'farmart-addons' ),
			'all_items'                  => esc_html__( 'All Collections', 'farmart-addons' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => esc_html__( 'Edit Collection', 'farmart-addons' ),
			'update_item'                => esc_html__( 'Update Collection', 'farmart-addons' ),
			'add_new_item'               => esc_html__( 'Add New Collection', 'farmart-addons' ),
			'new_item_name'              => esc_html__( 'New Collection Name', 'farmart-addons' ),
			'separate_items_with_commas' => esc_html__( 'Separate collections with commas', 'farmart-addons' ),
			'add_or_remove_items'        => esc_html__( 'Add or remove collections', 'farmart-addons' ),
			'choose_from_most_used'      => esc_html__( 'Choose from the most used collections', 'farmart-addons' ),
			'not_found'                  => esc_html__( 'No collections found.', 'farmart-addons' ),
			'menu_name'                  => esc_html__( 'Collections', 'farmart-addons' ),
		);

		$permalinks              = get_option( 'product_collection_permalinks' );
		$product_collection_base = empty( $permalinks['product_collection_base'] ) ? _x( 'product-collection', 'slug', 'farmart-addons' ) : $permalinks['product_collection_base'];

		$args = array(
			'hierarchical'          => false,
			'update_count_callback' => '_wc_term_recount',
			'labels'                => $labels,
			'show_ui'               => true,
			'query_var'             => true,
			'rewrite'               => array(
				'slug'    => $product_collection_base,
				'ep_mask' => EP_PERMALINK
			)
		);

		register_taxonomy( 'product_collection', array( 'product' ), $args );
	}

	public function register_admin_scripts( $hook ) {
		$screen = get_current_screen();
		if ( $hook == 'edit-tags.php' && $screen->taxonomy == 'product_collection' || $hook == 'term.php' && $screen->taxonomy == 'product_collection' ) {
			wp_enqueue_media();

			wp_enqueue_style( 'fm_product_collection_css', FARMART_ADDONS_URL . "/assets/css/admin/collection-taxes.css", array(), '20190715' );
			wp_enqueue_script( 'fm_product_collection_js', FARMART_ADDONS_URL . "/assets/js/admin/collection-taxes.js", array( 'jquery' ), '20190715', true );
		}
	}

	public function product_collection_sortable( $taxonomy ) {
		$taxonomy[] = 'product_collection';

		return $taxonomy;

	}

	/**
	 * Add  field in 'Settings' > 'Reading'
	 * for enabling CPT functionality.
	 */
	public function settings_api_init() {
		add_settings_section(
			'farmart_collection_section',
			'<span id="collection-options">' . esc_html__( 'Product collection', 'farmart-addons' ) . '</span>',
			array( $this, 'writing_section_html' ),
			'writing'
		);

		add_settings_field(
			$this->option,
			'<span class="collection-options">' . esc_html__( 'Product collection', 'farmart-addons' ) . '</span>',
			array( $this, 'disable_field_html' ),
			'writing',
			'farmart_collection_section'
		);
		register_setting(
			'writing',
			$this->option,
			'intval'
		);

		add_settings_field(
			'product_collection_slug',
			'<label for="product_collection_slug">' . esc_html__( 'Product collection base', 'farmart-addons' ) . '</label>',
			array( $this, 'product_collection_slug_input' ),
			'permalink',
			'optional'
		);

		register_setting(
			'permalink',
			'product_collection_slug',
			'sanitize_text_field'
		);
	}

	/**
	 * Show a slug input box.
	 */
	public function product_collection_slug_input() {
		$permalinks      = get_option( 'product_collection_permalinks' );
		$collection_base = isset( $permalinks['product_collection_base'] ) ? $permalinks['product_collection_base'] : '';
		?>
		<input name="product_collection_slug" type="text" class="regular-text code" value="<?php echo esc_attr( $collection_base ); ?>" placeholder="<?php echo esc_attr_x( 'product-collection', 'slug', 'farmart-addons' ) ?>" />
		<?php
	}

	/**
	 * Save the settings.
	 */
	public function settings_save() {
		if ( ! is_admin() ) {
			return;
		}

		if ( ! $screen = get_current_screen() ) {
			return;
		}

		if ( 'options-permalink' != $screen->id ) {
			return;
		}

		$permalinks = get_option( 'product_collection_permalinks' );

		if ( isset( $_POST['product_collection_slug'] ) ) {
			$permalinks['product_collection_base'] = $this->sanitize_permalink( trim( $_POST['product_collection_slug'] ) );
		}

		update_option( 'product_collection_permalinks', $permalinks );
	}

	/**
	 * Sanitize permalink
	 *
	 * @param string $value
	 *
	 * @return string
	 */
	private function sanitize_permalink( $value ) {
		global $wpdb;

		$value = $wpdb->strip_invalid_text_for_column( $wpdb->options, 'option_value', $value );

		if ( is_wp_error( $value ) ) {
			$value = '';
		}

		$value = esc_url_raw( $value );
		$value = str_replace( 'http://', '', $value );

		return untrailingslashit( $value );
	}

	/**
	 * Category thumbnail fields.
	 */
	public function add_category_fields() {
		?>
		<div class="form-field" id="product-collection-thumb-box">
			<label><?php esc_html_e( 'Thumbnail', 'farmart-addons' ); ?></label>

			<div id="product_collection_thumb" class="product-collection-thumb" data-rel="<?php echo esc_url( $this->placeholder_img_src ); ?>">
				<img src="<?php echo esc_url( $this->placeholder_img_src ); ?>" width="60px" height="60px" /></div>
			<div class="product-collection-thumb-box">
				<input type="hidden" id="product_collection_thumb_id" name="product_collection_thumb_id" />
				<button type="button" class="upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'farmart-addons' ); ?></button>
				<button type="button" class="remove_image_button button"><?php esc_html_e( 'Remove image', 'farmart-addons' ); ?></button>
			</div>
			<div class="clear"></div>
		</div>
		<?php
	}

	/**
	 * Edit category thumbnail field.
	 *
	 * @param mixed $term Term (category) being edited
	 */
	public function edit_category_fields( $term ) {

		$thumbnail_id = $gallery_link = '';
		$gallery_id = array();
		if ( function_exists( 'get_term_meta' ) ) {
			$thumbnail_id = absint( get_term_meta( $term->term_id, 'collection_thumbnail_id', true ) );
			$gallery_id   = get_term_meta( $term->term_id, 'product_collection_gallery_id', true );
			$gallery_link = get_term_meta( $term->term_id, 'product_collection_gallery_link', true );
		}

		if ( $thumbnail_id ) {
			$image = wp_get_attachment_thumb_url( $thumbnail_id );
		} else {
			$image = $this->placeholder_img_src;
		}
		?>
		<tr class="form-field product-collection-thumb" id="product-collection-thumb-box">
			<th scope="row" valign="top"><label><?php esc_html_e( 'Thumbnail', 'farmart-addons' ); ?></label></th>
			<td>
				<div id="product_collection_thumb" class="product-collection-thumb" data-rel="<?php echo esc_url( $this->placeholder_img_src ); ?>">
					<img src="<?php echo esc_url( $image ); ?>" width="60px" height="60px" />
				</div>
				<div class="product-collection-thumb-box">
					<input type="hidden" id="product_collection_thumb_id" name="product_collection_thumb_id" value="<?php echo esc_attr( $thumbnail_id ); ?>" />
					<button type="button" class="upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'farmart-addons' ); ?></button>
					<button type="button" class="remove_image_button button"><?php esc_html_e( 'Remove image', 'farmart-addons' ); ?></button>
				</div>
				<div class="clear"></div>
			</td>
		</tr>
		<?php
	}

	/**
	 * save_category_fields function.
	 *
	 * @param mixed  $term_id Term ID being saved
	 * @param mixed  $tt_id
	 * @param string $taxonomy
	 */
	public function save_category_fields( $term_id, $tt_id = '', $taxonomy = '' ) {
		if ( 'product_collection' === $taxonomy && function_exists( 'update_woocommerce_term_meta' ) ) {
			if ( isset( $_POST['product_collection_thumb_id'] ) ) {
				update_woocommerce_term_meta( $term_id, 'collection_thumbnail_id', absint( $_POST['product_collection_thumb_id'] ) );
			}

			if ( isset( $_POST['product_collection_gallery_id'] ) ) {
				update_woocommerce_term_meta( $term_id, 'product_collection_gallery_id', $_POST['product_collection_gallery_id'] );
			}

			if ( isset( $_POST['product_collection_gallery_link'] ) ) {
				update_woocommerce_term_meta( $term_id, 'product_collection_gallery_link', $_POST['product_collection_gallery_link'] );
			}
		}
	}

	/**
	 * Thumbnail column added to category admin.
	 *
	 * @param mixed $columns
	 *
	 * @return array
	 */
	public function product_collection_columns( $columns ) {
		$new_columns = array();

		if ( isset( $columns['cb'] ) ) {
			$new_columns['cb'] = $columns['cb'];
			unset( $columns['cb'] );
		}

		$new_columns['thumb'] = esc_html__( 'Image', 'farmart-addons' );

		return array_merge( $new_columns, $columns );
	}

	/**
	 * Thumbnail column value added to category admin.
	 *
	 * @param string $columns
	 * @param string $column
	 * @param int    $id
	 *
	 * @return string
	 */
	public function product_collection_column( $columns, $column, $id ) {

		if ( 'thumb' == $column ) {

			$thumbnail_id = get_term_meta( $id, 'collection_thumbnail_id', true );

			if ( $thumbnail_id ) {
				$image = wp_get_attachment_thumb_url( $thumbnail_id );
			} else {
				$image = $this->placeholder_img_src;
			}

			// Prevent esc_url from breaking spaces in urls for image embeds
			// Ref: https://core.trac.wordpress.org/ticket/23605
			$image = str_replace( ' ', '%20', $image );

			$columns .= '<img src="' . esc_url( $image ) . '" alt="' . esc_attr__( 'Thumbnail', 'farmart-addons' ) . '" class="wp-post-image" height="48" width="48" />';

		}

		return $columns;
	}

	/**
	 * Add writing setting section
	 */
	public function writing_section_html() {
		?>
		<p>
			<?php esc_html_e( 'Use these settings to disable custom types of content on your site', 'farmart-addons' ); ?>
		</p>
		<?php
	}

	/**
	 * HTML code to display a checkbox true/false option
	 * for the Services CPT setting.
	 */
	public function disable_field_html() {
		?>

		<label for="<?php echo esc_attr( $this->option ); ?>">
			<input name="<?php echo esc_attr( $this->option ); ?>"
				   id="<?php echo esc_attr( $this->option ); ?>" <?php checked( get_option( $this->option ), true ); ?>
				   type="checkbox" value="1" />
			<?php esc_html_e( 'Disable Collection for this site.', 'farmart-addons' ); ?>
		</label>

		<?php
	}

}
