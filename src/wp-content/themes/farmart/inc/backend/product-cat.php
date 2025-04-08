<?php
/**
 * Register post types
 *
 * @package Farmart
 */

/**
 * Class Product Categtory
 */
class Farmart_Product_Cat {

	/**
	 * Construction function
	 *
	 * @since 1.0.0
	 *
	 * @return farmart_Product_Cat
	 */

	/**
	 * @var string placeholder image
	 */
	public $placeholder_img_src;

	/**
	 * Category Layout
	 *
	 * @var array
	 */
	private $cat_layout = array();

	function __construct() {

		if ( ! function_exists( 'is_woocommerce' ) ) {
			return false;
		}

		// Register custom post type and custom taxonomy
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );

		$this->placeholder_img_src = get_template_directory_uri() . '/images/placeholder.png';
		// Add form
		add_action( 'product_cat_add_form_fields', array( $this, 'add_category_fields' ), 30 );
		add_action( 'product_cat_edit_form_fields', array( $this, 'edit_category_fields' ), 20 );
		add_action( 'created_term', array( $this, 'save_category_fields' ), 20, 3 );
		add_action( 'edit_term', array( $this, 'save_category_fields' ), 20, 3 );
	}

	function register_admin_scripts( $hook ) {
		$screen = get_current_screen();
		if ( ( $hook == 'edit-tags.php' && ( $screen->taxonomy == 'product_cat' || $screen->taxonomy == 'product_brand' ) ) || ( $hook == 'term.php' && $screen->taxonomy == 'product_cat' ) ) {
			wp_enqueue_media();
			wp_enqueue_script( 'farmart_product_cat_js', get_template_directory_uri() . "/js/backend/product-cat.js", array( 'jquery' ), '20190407', true );
		}
	}

	/**
	 * Category thumbnail fields.
	 */
	function add_category_fields() {
		?>

		<div class="form-field fm-cat-banners-group fm-custom-banner-hidden-in-layout-2 fm-custom-banner-hidden-in-layout-10">
			<label><?php esc_html_e( 'Banners Carousel', 'farmart' ); ?></label>

			<div id="fm_cat_banners" class="fm-cat-banners">
				<ul class="fm-cat-images"></ul>
				<input type="hidden" id="fm_cat_banners_id" class="fm_cat_banners_id" name="fm_cat_banners_id" />
				<button type="button" data-multiple="1" data-delete="<?php esc_attr_e( 'Delete image', 'farmart' ); ?>"
						data-text="<?php esc_attr_e( 'Delete', 'farmart' ); ?>"
						class="upload_images_button button"><?php esc_html_e( 'Upload/Add Images', 'farmart' ); ?></button>
			</div>
			<div class="clear"></div>
		</div>
		<div class="form-field fm-cat-banners-group fm-custom-banner-hidden-in-layout-2 fm-custom-banner-hidden-in-layout-10">
			<label><?php esc_html_e( 'Banners Carousel Link', 'farmart' ); ?></label>

			<div id="fm_cat_banners_link" class="fm-cat-banners_link">
				<textarea id="fm_cat_banners_link" cols="50" rows="3" name="fm_cat_banners_link"></textarea>

				<p class="description"><?php esc_html_e( 'Enter links for each banner here. Divide links with linebreaks (Enter).', 'farmart' ); ?></p>
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
	function edit_category_fields( $term ) {
		$thumbnail_ids       = get_term_meta( $term->term_id, 'fm_cat_banners_id', true );
		$banners_link        = get_term_meta( $term->term_id, 'fm_cat_banners_link', true );

		?>


		<tr class="form-field fm-cat-banners-group fm-custom-banner-hidden-in-layout-2 fm-custom-banner-hidden-in-layout-10">
			<th scope="row" valign="top"><label><?php esc_html_e( 'Banners Carousel', 'farmart' ); ?></label></th>
			<td>
				<div id="fm_cat_banners" class="fm-cat-banners">
					<ul class="fm-cat-images">
						<?php

						if ( $thumbnail_ids ) {
							$thumbnails = explode( ',', $thumbnail_ids );
							foreach ( $thumbnails as $thumbnail_id ) {
								if ( empty( $thumbnail_id ) ) {
									continue;
								}
								$image = wp_get_attachment_thumb_url( $thumbnail_id );
								if ( empty( $image ) ) {
									continue;
								}
								?>
								<li class="image" data-attachment_id="<?php echo esc_attr( $thumbnail_id ); ?>">
									<img src="<?php echo esc_url( $image ); ?>" width="100px" height="100px" />
									<ul class="actions">
										<li>
											<a href="#" class="delete"
											   title="<?php esc_attr_e( 'Delete image', 'farmart' ); ?>"><?php esc_html_e( 'Delete', 'farmart' ); ?></a>
										</li>
									</ul>
								</li>
								<?php
							}
						}

						?>
					</ul>
					<input type="hidden" id="fm_cat_banners_id" class="fm_cat_banners_id" name="fm_cat_banners_id"
						   value="<?php echo esc_attr( $thumbnail_ids ); ?>" />
					<button type="button" data-multiple="1"
							data-delete="<?php esc_attr_e( 'Delete image', 'farmart' ); ?>"
							data-text="<?php esc_attr_e( 'Delete', 'farmart' ); ?>"
							class="upload_images_button button"><?php esc_html_e( 'Upload/Add Images', 'farmart' ); ?></button>
				</div>
				<div class="clear"></div>
			</td>
		</tr>
		<tr class="form-field fm-cat-banners-group fm-custom-banner-hidden-in-layout-2 fm-custom-banner-hidden-in-layout-10">
			<th scope="row" valign="top"><label><?php esc_html_e( 'Banners Carousel Link', 'farmart' ); ?></label></th>
			<td>
				<div id="fm_cat_banners_link" class="fm-cat-banners-link">
                    <textarea id="fm_cat_banners_link" cols="50" rows="4"
							  name="fm_cat_banners_link"><?php echo esc_html( $banners_link ); ?></textarea>

					<p class="description"><?php esc_html_e( 'Enter links for each banner here. Divide links with linebreaks (Enter).', 'farmart' ); ?></p>
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
	function save_category_fields( $term_id, $tt_id = '', $taxonomy = '' ) {

		if ( 'product_cat' === $taxonomy && function_exists( 'update_term_meta' ) ) {

			if ( isset( $_POST['fm_cat_banners_id'] ) ) {
				update_term_meta( $term_id, 'fm_cat_banners_id', $_POST['fm_cat_banners_id'] );
			}

			if ( isset( $_POST['fm_cat_banners_link'] ) ) {
				update_term_meta( $term_id, 'fm_cat_banners_link', $_POST['fm_cat_banners_link'] );
			}

		}
	}

}

function farmart_product_cat_init() {
	new Farmart_Product_Cat;
}

add_action( 'init', 'farmart_product_cat_init' );