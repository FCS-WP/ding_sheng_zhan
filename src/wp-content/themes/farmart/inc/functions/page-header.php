<?php
/**
 * Page Header
 *
 * @package Farmart
 */

/**
 * Get page header layout
 *
 * @return array
 */

if ( ! function_exists( 'farmart_get_page_header' ) ) :
	function farmart_get_page_header() {
		if ( is_404() || is_singular( 'post' ) ) {
			return false;
		}

		$page_header = array( 'title', 'breadcrumb' );
		if ( farmart_is_blog() ) {
			if ( ! intval( farmart_get_option( 'page_header_blog' ) ) ) {
				return false;
			}
			$page_header = farmart_get_option( 'page_header_blog_els' );
		} elseif ( is_page() ) {
			if ( ! intval( farmart_get_option( 'page_header_page' ) ) ) {
				return false;
			}

			$page_header_layout = get_post_meta( farmart_get_post_ID(), 'page_header_layout', true );

			if ( ! empty( $page_header_layout ) ) {
				$hide_title      = get_post_meta( farmart_get_post_ID(), 'hide_title', true );
				$hide_breadcrumb = get_post_meta( farmart_get_post_ID(), 'hide_breadcrumb', true );

				if ( intval( $hide_title ) && intval( $hide_breadcrumb ) ) {
					return false;
				}

				if ( intval( $hide_breadcrumb ) ) {

					$key = array_search( 'breadcrumb', $page_header );
					if ( $key !== false ) {
						unset( $page_header[ $key ] );
					}
				}

				if ( intval( $hide_title ) ) {

					$key = array_search( 'title', $page_header );
					if ( $key !== false ) {
						unset( $page_header[ $key ] );
					}
				}
			} else {
				$page_header = farmart_get_option( 'page_header_pages_els' );
			}

		} elseif ( farmart_is_catalog() ) {
			$page_header = array( 'breadcrumb' );
		} elseif ( is_singular( 'product' ) ) {
			if ( ! intval( farmart_get_option( 'product_breadcrumb' ) ) ) {
				return false;
			}

			if ( farmart_get_option( 'product_layout' ) == 4 ) {
				return false;
			}

			$page_header = array( 'breadcrumb' );
		} elseif ( farmart_is_vendor_page() ) {
			$catalog_elements = farmart_get_option( 'page_header_vendor_els' );

			if ( ! in_array( 'breadcrumb', $catalog_elements ) ) {
				return false;
			}

			$page_header = array( 'breadcrumb' );
		}

		$page_header = farmart_custom_page_header( $page_header );

		return $page_header;

	}

endif;

/**
 * Get custom page header layout
 *
 * @return array
 */
if ( ! function_exists( 'farmart_custom_page_header' ) ) :
	function farmart_custom_page_header( $page_header ) {

		if ( ! is_singular( 'page' ) && ! is_singular( 'post' ) && ! is_singular( 'product' ) && ! ( function_exists( 'is_shop' ) && is_shop() ) ) {
			return $page_header;
		}

		if ( empty( $page_header ) ) {
			return false;
		}

		$hide_page_header = get_post_meta( farmart_get_post_ID(), 'hide_page_header', true );
		if ( $hide_page_header ) {
			return false;
		}

		if ( get_post_meta( farmart_get_post_ID(), 'hide_breadcrumb', true ) ) {
			$key = array_search( 'breadcrumb', $page_header );
			if ( $key !== false ) {
				unset( $page_header[ $key ] );
			}
		}

		if ( get_post_meta( farmart_get_post_ID(), 'hide_title', true ) ) {
			$key = array_search( 'title', $page_header );
			if ( $key !== false ) {
				unset( $page_header[ $key ] );
			}
		}

		if ( get_post_meta( farmart_get_post_ID(), 'page_header_layout', true ) ) {
			$page_header['page_header_layout'] = get_post_meta( farmart_get_post_ID(), 'page_header_layout', true );
		}

		return $page_header;
	}
endif;

/**
 * Get breadcrumbs
 *
 * @since  1.0.0
 *
 * @return string
 */

if ( ! function_exists( 'farmart_get_breadcrumbs' ) ) :
	function farmart_get_breadcrumbs() {
		$page_header = farmart_get_page_header();
		if ( ! $page_header ) {
			return;
		}

		if ( ! in_array( 'breadcrumb', $page_header ) ) {
			return;
		}

		farmart_breadcrumbs(
			array(
				'taxonomy' => function_exists( 'is_woocommerce' ) && is_woocommerce() ? 'product_cat' : 'category',
			)
		);
	}

endif;

if ( ! function_exists( 'farmart_blog_single_breadcrumbs' ) ) :
	function farmart_blog_single_breadcrumbs() {
		$metas = (array) farmart_get_option( 'post_entry_meta' );

		if ( $metas[0] != 'breadcrumbs' ) {
			return;
		}

		?>
        <div class="farmart-post--breadcrumbs">
			<?php ob_start(); ?>
            <nav class="breadcrumbs">
				<?php farmart_breadcrumbs(); ?>
            </nav>
			<?php
			echo ob_get_clean();
			?>
        </div>
		<?php
	}
endif;