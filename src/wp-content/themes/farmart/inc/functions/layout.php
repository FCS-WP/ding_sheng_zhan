<?php
/**
 * Custom layout functions
 *
 * @package Farmart
 */


/**
 * Get classes for content area
 *
 * @since  1.0
 *
 * @return string of classes
 */

if ( ! function_exists( 'farmart_content_container_class' ) ) :
	function farmart_content_container_class() {

		if ( farmart_is_catalog() ) {
			if ( intval( farmart_get_option( 'catalog_full_width' ) ) ) {
				return 'farmart-container';
			}
		} elseif ( is_singular( 'product' ) ) {
			if ( intval( farmart_get_option( 'product_full_width' ) ) ) {
				if ( farmart_get_option( 'product_layout' ) == 4 ) {
					return 'container-fluid';
				} else {
					return 'farmart-container';
				}
			}
		} elseif ( farmart_is_vendor_page() ) {
			if ( intval( farmart_get_option( 'catalog_vendor_full_width' ) ) ) {
				return 'farmart-container';
			}
		} elseif( is_page() || farmart_is_blog() || farmart_is_catalog() ) {
			if( get_post_meta( farmart_get_post_ID(), 'farmart_content_width', true ) == 'large' ) {
				return 'farmart-container';
			} elseif( get_post_meta( farmart_get_post_ID(), 'farmart_content_width', true ) == 'full-width' ) {
				return 'container-fluid';
			}
		}

		return 'container';
	}

endif;


if ( ! function_exists( 'farmart_get_layout' ) ) :
	function farmart_get_layout() {
		$layout        = 'full-content';
		$custom_layout = get_post_meta( get_the_ID(), 'post_layout_settings', true );

		if ( is_singular( 'post' ) ) {
			if ( ! is_active_sidebar( 'blog-sidebar' ) ) {
				$layout = 'full-content';
			} else {
				if ( $custom_layout != '' ) {
					$layout = $custom_layout;
				} else {
					$layout = farmart_get_option( 'single_post_layout' );
				}
			}

		} elseif ( farmart_is_blog() || (is_search() && get_post_type()  == 'post') ) {
			$blog_view = farmart_get_option( 'blog_view' );
			$layout    = farmart_get_option( 'blog_layout' );

			if ( $blog_view == 'grid' || $blog_view == 'list' || ! is_active_sidebar( 'blog-sidebar' ) ) {
				$layout = 'full-content';
			}
		} elseif ( farmart_is_catalog() ) {
			$layout = farmart_get_option( 'catalog_layout' );
		} elseif ( function_exists( 'is_product' ) && is_product() ) {
			$product_layout = farmart_get_option( 'product_layout' );
			if ( $product_layout == '1' ) {
				$layout = 'full-content';
			} else {
				$layout = farmart_get_option( 'product_sidebar' );
			}
		}


		return apply_filters( 'farmart_site_layout', $layout );
	}

endif;

/**
 * Get Bootstrap column classes for content area
 *
 * @since  1.0
 *
 * @return array Array of classes
 */

if ( ! function_exists( 'farmart_get_content_columns' ) ) :
	function farmart_get_content_columns( $layout = null ) {
		$layout = $layout ? $layout : farmart_get_layout();

		$classes = array( 'col-md-9', 'col-sm-12', 'col-xs-12' );

		if ( $layout == 'full-content' ) {
			$classes = array( 'col-md-12' );
		}

		if ( farmart_is_catalog() ) {
			$classes = array();
		}

		return $classes;
	}

endif;

/**
 * Echos Bootstrap column classes for content area
 *
 * @since 1.0
 */

if ( ! function_exists( 'farmart_content_columns' ) ) :
	function farmart_content_columns( $layout = null ) {
		echo implode( ' ', farmart_get_content_columns( $layout ) );
	}
endif;

if ( ! function_exists( 'farmart_get_product_layout' ) ) :
	function farmart_get_product_layout() {
		$product_layout = farmart_get_option( 'product_layout' );

		return apply_filters( 'farmart_get_product_layout', $product_layout );
	}
endif;