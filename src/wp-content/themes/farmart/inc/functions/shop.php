<?php

/**
 * Get catalog layout
 *
 * @since 1.0
 */
if ( ! function_exists( 'farmart_get_catalog_full_width' ) ) :
	function farmart_get_catalog_full_width() {

		if ( ! farmart_is_catalog() || ! is_search() ) {
			return false;
		}

		if ( intval( farmart_get_option( 'catalog_full_width' ) ) ) {
			return true;
		}

		if( get_post_meta( farmart_get_post_ID(), 'farmart_content_width', true ) == 'large' || get_post_meta( farmart_get_post_ID(), 'farmart_content_width', true ) == 'full-width' ) {
			return true;
		}

		return false;

	}
endif;