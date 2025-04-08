<?php
/**
* Custom functions for the maintenance mode.
*
* @package Farmart
*/


/**
 * Redirect to the target page if the maintenance mode is enabled.
 */
function farmart_maintenance_redirect() {
	if ( ! farmart_get_option( 'maintenance_enable' ) ) {
		return;
	}

	if ( current_user_can( 'super admin' ) ) {
		return;
	}

	$mode     = farmart_get_option( 'maintenance_mode' );
	$page_id  = farmart_get_option( 'maintenance_page' );
	$code     = 'maintenance' == $mode ? 503 : 200;
	$page_url = $page_id ? get_page_link( $page_id ):  '';

	// Use default message.
	if ( ! $page_id || ! $page_url ) {
		if ( 'coming_soon' == $mode ) {
			$message = sprintf( '<h1>%s</h1><p>%s</p>', esc_html__( 'Coming Soon', 'farmart' ), esc_html__( 'Our website is under construction. We will be here soon with our new awesome site.', 'farmart' ) );
		} else {
			$message = sprintf( '<h1>%s</h1><p>%s</p>', esc_html__( 'Website Under Maintenance', 'farmart' ), esc_html__( 'Our website is currently undergoing scheduled maintenance. Please check back soon.', 'farmart' ) );
		}

		wp_die( $message, get_bloginfo( 'name' ), array( 'response' => $code ) );
	}

	// Add body classes.
	add_filter( 'body_class', 'farmart_maintenance_page_body_class' );

	// Redirect to the correct page.
	if ( ! is_page( $page_id ) ) {
		wp_redirect( $page_url );
		exit;
	} else {
		if ( ! headers_sent() ) {
			status_header( $code );
		}
		remove_action( 'farmart_before_header', 'farmart_topbar' );
		remove_action( 'farmart_header', 'farmart_header' );
	}
}

add_action( 'template_redirect', 'farmart_maintenance_redirect', 1 );

/**
 * Add classes for maintenance mode.
 *
 * @param array $classes
 * @return array
 */
function farmart_maintenance_page_body_class( $classes ) {
	if ( ! farmart_get_option( 'maintenance_enable' ) ) {
		return $classes;
	}

	if ( current_user_can( 'super admin' ) ) {
		return $classes;
	}

	$classes[] = 'maintenance-mode';

	if ( farmart_is_maintenance_page() ) {
		$classes[] = 'maintenance-page';
	}

	return $classes;
}