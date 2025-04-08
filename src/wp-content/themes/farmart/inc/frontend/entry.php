<?php

/**
 * Get post format image
 *
 * @since  1.0
 */

if ( ! function_exists( 'farmart_blog_cats_filter' ) ) :
	function farmart_blog_cats_filter() {
		if ( ! farmart_is_blog() && ! is_singular( 'post' ) ) {
			return;
		}

		farmart_taxs_list();

	}
endif;

add_action( 'farmart_before_post_loop', 'farmart_blog_cats_filter' );