<?php
/**
 * Hooks for template footer
 *
 * @package Farmart
 */

 /**
 * Site footer
 *
 * @since 1.0.0
 *
 * @return void
 */
function show_footer() {
    if ( ! apply_filters( 'famart_get_footer', true ) ) {
        return;
    }

    $sections = farmart_get_option( 'footer_sections' );

    if ( empty( $sections ) ) {
        return;
    }

    foreach ( (array) $sections as $section ) {
        get_template_part( 'template-parts/footers/footer', $section );
    }

}

add_action( 'farmart_footer', 'show_footer', 10 );

 /**
 * Site footer
 *
 * @since 1.0.0
 *
 * @return void
 */
function footer_background_image() {
    if ( ! apply_filters( 'famart_get_footer', true ) ) {
        return;
    }

    if ( empty( $image = farmart_get_option( 'footer_background_image' ) ) ) {
        return;
    }

    echo '<div class="footer-background" style="background-image: url('. $image .');"></div>';

}

add_action( 'farmart_footer', 'footer_background_image', 9 );

/**
 * Display back to top
 *
 * @since 1.0.0
 */
function farmart_back_to_top() {
	if ( ! intval( farmart_get_option( 'back_to_top' ) ) ) {
		return;
	}

	?>

    <a id="scroll-top" class="backtotop" href="#page-top">
        <?php echo Farmart\Icon::get_svg( 'chevron-up' ); ?>
    </a>
	<?php
}

add_action( 'wp_footer', 'farmart_back_to_top', 20 );

/**
 * Add page loader
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'farmart_loader' ) ) :
	function farmart_loader() {
        if ( ! intval( farmart_get_option( 'preloader' ) ) ) {
            return;
        }

		echo '<div id="farmart-preloader" class="farmart-preloader"><div class="farmart-loading"></div></div>';
	}
endif;

add_action( 'wp_footer', 'farmart_loader' );

/**
 * Adds quick view modal to footer
 */
if ( ! function_exists( 'farmart_quick_view_modal' ) ) :
	function farmart_quick_view_modal() {
		if ( is_404() ) {
			return;
		}

		?>

        <div id="fm-quick-view-modal" class="fm-quick-view-modal fm-modal woocommerce" tabindex="-1">
            <div class="fm-modal-overlay"></div>
            <div class="modal-content container">
                <a href="#" class="close-modal">
                    <?php echo Farmart\Icon::get_svg( 'cross' ) ?>
                </a>

                <div class="product-modal-content"></div>
            </div>
            <div class="fm-loading"></div>
        </div>

		<?php
	}

endif;

add_action( 'wp_footer', 'farmart_quick_view_modal' );

/**
 * Woocommerce Catalog Ordering Popup
 */
function fm_mobile_catalog_sorting_popup() {
	if ( ! function_exists( 'woocommerce_catalog_ordering' ) ) {
		return;
	}

	if ( farmart_is_vendor_page() ) {
		return;
	}

	$els = (array) farmart_get_option( 'catalog_toolbar_elements' );

	if ( empty( $els ) ) {
		return;
	}

	if ( ! in_array( 'sort_by', $els ) ) {
		return;
	}

	echo '<div class="fm-catalog-sorting-mobile" id="fm-catalog-sorting-mobile">';
	woocommerce_catalog_ordering();
	echo '</div>';
}

add_action( 'wp_footer', 'fm_mobile_catalog_sorting_popup' );

/**
 * Adds photoSwipe dialog element
 */
function farmart_gallery_images_lightbox() {

	if ( ! is_singular() ) {
		return;
	}

	?>
    <div id="pswp" class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

        <div class="pswp__bg"></div>

        <div class="pswp__scroll-wrap">

            <div class="pswp__container">
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
            </div>

            <div class="pswp__ui pswp__ui--hidden">

                <div class="pswp__top-bar">


                    <div class="pswp__counter"></div>

                    <button class="pswp__button pswp__button--close"
                            title="<?php esc_attr_e( 'Close (Esc)', 'farmart' ) ?>"></button>

                    <button class="pswp__button pswp__button--share"
                            title="<?php esc_attr_e( 'Share', 'farmart' ) ?>"></button>

                    <button class="pswp__button pswp__button--fs"
                            title="<?php esc_attr_e( 'Toggle fullscreen', 'farmart' ) ?>"></button>

                    <button class="pswp__button pswp__button--zoom"
                            title="<?php esc_attr_e( 'Zoom in/out', 'farmart' ) ?>"></button>

                    <div class="pswp__preloader">
                        <div class="pswp__preloader__icn">
                            <div class="pswp__preloader__cut">
                                <div class="pswp__preloader__donut"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                    <div class="pswp__share-tooltip"></div>
                </div>

                <button class="pswp__button pswp__button--arrow--left"
                        title="<?php esc_attr_e( 'Previous (arrow left)', 'farmart' ) ?>">
                </button>

                <button class="pswp__button pswp__button--arrow--right"
                        title="<?php esc_attr_e( 'Next (arrow right)', 'farmart' ) ?>">
                </button>

                <div class="pswp__caption">
                    <div class="pswp__caption__center"></div>
                </div>

            </div>

        </div>

    </div>
	<?php
}

add_action( 'wp_footer', 'farmart_gallery_images_lightbox' );

/**
 * Adds photoSwipe dialog element
 */
function farmart_product_images_degree_lightbox() {
	if ( ! is_singular( 'product' ) ) {
		return;
	}

	$images_dg = get_post_meta( get_the_ID(), 'product_360_view', true );
	if ( empty( $images_dg ) ) {
		return;
	}

	?>
    <div id="product-degree-pswp" class="product-degree-pswp">
        <div class="degree-pswp-bg"></div>
        <div class="fm-product-gallery-degree">
            <div class="degree-pswp-close"><?php echo Farmart\Icon::get_svg( 'cross' ) ?></div>
            <div class="fm-gallery-degree-spinner"></div>
            <ul class="product-degree-images"></ul>
        </div>
    </div>
	<?php
}

add_action( 'wp_footer', 'farmart_product_images_degree_lightbox' );