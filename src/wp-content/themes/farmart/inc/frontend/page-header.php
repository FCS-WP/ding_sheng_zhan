<?php
function farmart_the_archive_title( $title ) {

	if ( is_search() ) {
		$title = sprintf( esc_html__( 'Search Results', 'farmart' ) );
	} elseif ( is_404() ) {
		$title = sprintf( esc_html__( 'Page Not Found', 'farmart' ) );
	} elseif ( is_page() ) {
		$title = get_the_title();
	} elseif ( is_home() && is_front_page() ) {
		$title = esc_html__( 'The Latest Posts', 'farmart' );
	} elseif ( is_home() && ! is_front_page() ) {
		$title = get_the_title( intval(get_option( 'page_for_posts' )) );
	} elseif ( function_exists( 'is_shop' ) && is_shop() ) {
		$title = get_the_title( intval(get_option( 'woocommerce_shop_page_id' )) );
	}  elseif ( is_single() ) {
		$title = get_the_title();
	} elseif ( is_tax() || is_category() ) {
		$title = single_term_title( '', false );
	}

	return $title;
}

add_filter( 'get_the_archive_title', 'farmart_the_archive_title', 30 );