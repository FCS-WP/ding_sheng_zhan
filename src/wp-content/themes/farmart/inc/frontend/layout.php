<?php
/**
 * Custom layout functions  by hooking templates
 *
 * @package Farmart
 */


/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function farmart_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	$classes[] = farmart_get_layout();

	if ( farmart_is_blog() ) {
		$blog_view = farmart_get_option( 'blog_view' );

		$classes[] = 'farmart-blog-page';
		$classes[] = 'farmart-blog-page--' . $blog_view;

	} elseif ( is_singular( 'post' ) ) {
		$layout_content = '';
		$layout         = farmart_get_option( 'single_post_layout' );
		$custom_layout  = get_post_meta( get_the_ID(), 'post_layout_settings', true );
		if ( $custom_layout != '' ) {
			$layout_content = $custom_layout;
		} else {
			$layout_content = $layout;
		}
		if ( $layout_content != 'full-content' ) {
			$classes[] = 'farmart-single-post__new';
		}

		if ( intval( farmart_get_option( 'show_post_cats' ) ) ) {
			$classes[] = 'farmart-show-categories-filter';
		}
	} elseif (is_search() && get_post_type()  == 'post'){
		$classes[] = 'farmart-blog-page--small-thumb farmart-search-page';
	}

	if ( intval( farmart_get_option( 'preloader' ) ) ) {
		$classes[] = 'fm-preloader';
	}

	if ( intval( farmart_get_option( 'catalog_product_loop_show_qty' ) ) ) {
		$classes[] = 'fm-show-qty';
	}

	if ( function_exists('is_cart') && is_cart() ) {
		$classes[] = 'fm-cart-page';
	}

	if ( is_page() && ( $background = get_post_meta( farmart_get_post_ID(), 'farmart_header_background', true ) ) ) {
		if ( 'transparent' == $background ) {
			$classes[] = 'header-' . $background;
		}
	}

	if( is_page() && get_post_meta( get_the_ID(), '_elementor_edit_mode', true ) ) {
		$classes[] = 'elementor-width-farmart-' . get_post_meta( farmart_get_post_ID(), 'farmart_content_width', true );
	}

	return $classes;
}

add_filter( 'body_class', 'farmart_body_classes' );

/**
 * Print the open tags of site content container
 */

if ( ! function_exists( 'farmart_open_site_content_container' ) ) :
	function farmart_open_site_content_container() {
		if( is_page() && get_post_meta( get_the_ID(), '_elementor_edit_mode', true ) ) {
			return;
		}

		printf( '<div class="%s"><div class="row">', esc_attr( apply_filters( 'farmart_site_content_container_class', farmart_content_container_class() ) ) );
	}
endif;

add_action( 'farmart_after_site_content_open', 'farmart_open_site_content_container', 30 );

/**
 * Print the close tags of site content container
 */

if ( ! function_exists( 'farmart_close_site_content_container' ) ) :
	function farmart_close_site_content_container() {
		if( is_page() && get_post_meta( get_the_ID(), '_elementor_edit_mode', true ) ) {
			return;
		}

		print( '</div></div>' );
	}

endif;

add_action( 'farmart_before_site_content_close', 'farmart_close_site_content_container', 30 );

if ( ! function_exists( 'farmart_add_comment_single_post' ) ) :
	function farmart_add_comment_single_post() {
		if ( ! is_single() || is_singular('product') ) {
			return;
		}

		echo '<div class="farmart-comment"><div class="container">';

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;

		echo '</div></div>';
	}

endif;

add_action( 'farmart_before_site_content_close', 'farmart_add_comment_single_post', 40 );

/**
 * Add classed to site content
 *
 * @since 1.0.0
 *
 * @return string
 */
if ( ! function_exists( 'farmart_site_content_class' ) ) :
	function farmart_site_content_class($classes) {
		if( is_page() || farmart_is_catalog() || farmart_is_blog() ) {
			$top_spacing = get_post_meta( farmart_get_post_ID(), 'farmart_content_top_spacing', true );
			if ( ! empty($top_spacing) && $top_spacing != 'default' ) {
				$classes .= sprintf( ' %s-top-spacing', $top_spacing );
			}
			$bottom_spacing = get_post_meta( farmart_get_post_ID(), 'farmart_content_bottom_spacing', true );
			if ( ! empty($bottom_spacing) && $bottom_spacing != 'default' ) {
				$classes .= sprintf( ' %s-bottom-spacing', $bottom_spacing );
			}
		}

		if( farmart_is_catalog() ) {
			if( farmart_get_option( 'catalog_banners_enable' ) != 0 && ! empty( farmart_get_option( 'catalog_banners_els' ) ) ) {
				$classes .= ' no-top-spacing';
			}
		}

		return $classes;
	}
endif;

add_filter( 'farmart_site_content_class', 'farmart_site_content_class' );

function register_elementor_locations( $elementor_theme_manager ) {
	$elementor_theme_manager->register_all_core_location();
}

add_action( 'elementor/theme/register_locations', 'register_elementor_locations' );