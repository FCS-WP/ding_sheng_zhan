<?php
/**
 * Functions of stylesheets and CSS
 *
 * @package Kreative
 */

if ( ! function_exists( 'farmart_get_inline_style' ) ) :
	/**
	 * Get inline style data
	 */
	function farmart_get_inline_style() {
		$css = '';

		/* Typography */
		$css .= farmart_typography_css();
		$css .= farmart_get_heading_typography_css();

		/* Dynamic Css */
		$css .= farmart_dynamic_css();

		/* Color Scheme */
		$color_scheme_option = farmart_get_option( 'color_scheme' );
		if ( ! empty( $color_scheme_option ) ) {
			if ( ! empty( farmart_get_option( 'custom_color_scheme' ) ) ) {
				$color_scheme_option = farmart_get_option( 'custom_color' );
			}

			$css .= ' :root {--fm-background-color-primary: '. $color_scheme_option .'; --fm-color-primary: '. $color_scheme_option .';}';
		}

		$color_scheme_skin_option = farmart_get_option( 'color_scheme_skin' );
		$color_scheme_skin = '#fff';
		if ( $color_scheme_skin_option == 'dark' ) {
			$color_scheme_skin = '#000';
		} elseif( $color_scheme_skin_option == 'custom' ) {
			if ( ! empty( $color_scheme_skin_custom = farmart_get_option( 'color_scheme_skin_custom' ) ) ) {
				$color_scheme_skin = $color_scheme_skin_custom;
			}
		}

		$css .= ' :root {--fm-background-text-color-primary: '. $color_scheme_skin .';}';

		/* Secondary Color Scheme */
		$secondary_color_scheme_option = farmart_get_option( 'secondary_color_scheme' );
		if ( ! empty( $secondary_color_scheme_option ) ) {
			if ( ! empty( farmart_get_option( 'custom_secondary_color_scheme' ) ) ) {
				$secondary_color_scheme_option = farmart_get_option( 'custom_secondary_color' );
			}

			$css .= ' :root {--fm-background-color-secondary: '. $secondary_color_scheme_option .'; --fm-color-secondary: '. $secondary_color_scheme_option .';}';
		}

		$secondary_color_scheme_skin_option = farmart_get_option( 'secondary_color_scheme_skin' );
		$secondary_color_scheme_skin = '#fff';
		if ( $secondary_color_scheme_skin_option == 'dark' ) {
			$secondary_color_scheme_skin = '#000';
		} elseif ( $secondary_color_scheme_skin_option == 'custom' ) {
			if ( ! empty( $secondary_color_scheme_skin_custom = farmart_get_option( 'secondary_color_scheme_skin_custom' ) ) ) {
				$secondary_color_scheme_skin = $secondary_color_scheme_skin_custom;
			}
		}

		$css .= ' :root {--fm-background-text-color-secondary: '. $secondary_color_scheme_skin .';}';

		// Compare
		$css .= 'body.loading {background: url("'. get_theme_file_uri("/images/loading.gif") .'") no-repeat scroll center center transparent}';

		// Content page
		$css .= farmart_header_css();
		$css .= farmart_page_static_css();
		$css .= farmart_footer_css();

		return apply_filters( 'farmart_inline_style', $css );
	}
endif;

if ( ! function_exists( 'farmart_header_css' ) ) :
	function farmart_header_css() {
		$static_css = '';

		// Header Background Main
		if ( intval( farmart_get_option( 'header_main_background' ) ) ) {
			if ( $bg_color = farmart_get_option( 'header_main_background_color' ) ) {
				$static_css .= '.header-main, .header-v5 .header-main, .header-v6 .header-main { background-color: ' . esc_attr(  $bg_color ) . ';
												--farmart-header-background-color-primary: ' . esc_attr( $bg_color ) . ';
												--farmart-header-background-color-secondary: ' . esc_attr( $bg_color ) . '; }';
			}

			if ( $color = farmart_get_option( 'header_main_background_text_color' ) ) {
				$static_css .= '.header-main, .header-v5 .header-main, .header-v6 .header-main { --farmart-header-text-color: ' . esc_attr(  $color ) . ';
												--farmart-header-background-text-color-primary: ' . esc_attr( $color ) . ';
												--farmart-header-background-text-color-secondary: ' . esc_attr( $color ) . '; }';
			}

			if ( $hover_color = farmart_get_option( 'header_main_color_hover' ) ) {
				$static_css .= '.header-main { --farmart-header-text-hover-color: ' . esc_attr( $hover_color ) . ' }';
			}
		}

		// Header Background Bottom
		if ( intval( farmart_get_option( 'header_bottom_background' ) ) ) {
			if ( $bg_color = farmart_get_option( 'header_bottom_background_color' ) ) {
				$static_css .= '.header-bottom { background-color: ' . esc_attr(  $bg_color ) . ';
												--farmart-header-background-color-primary: ' . esc_attr( $bg_color ) . ';
												--farmart-header-background-color-secondary: ' . esc_attr( $bg_color ) . '; }';
			}

			if ( $color = farmart_get_option( 'header_bottom_background_text_color' ) ) {
				$static_css .= '.header-bottom { --farmart-header-text-color: ' . esc_attr(  $color ) . ';
												--farmart-header-background-text-color-primary: ' . esc_attr( $color ) . ';
												--farmart-header-background-text-color-secondary: ' . esc_attr( $color ) . '; }';
			}

			if ( $hover_color = farmart_get_option( 'header_bottom_color_hover' ) ) {
				$static_css .= '.header-bottom { --farmart-header-text-hover-color: ' . esc_attr( $hover_color ) . ' }';
			}
		}

		// Header Button Primary
		if ( $bg_color = farmart_get_option( 'header_button_primary_bg_color' ) ) {
			$static_css .= '.header-element--primary-button a { --farmart-header-background-color-secondary: ' . esc_attr( $bg_color ) . ' }';
		}
		if ( $color = farmart_get_option( 'header_button_primary_color' ) ) {
			$static_css .= '.header-element--primary-button a { --farmart-header-background-text-color-secondary: ' . esc_attr( $color ) . ' }';
		}
		if ( $border_color = farmart_get_option( 'header_button_primary_border_color' ) ) {
			$static_css .= '.header-element--primary-button a { border-color: ' . esc_attr( $border_color ) . ' }';
		}

		// Header Button Secondary
		if ( $bg_color = farmart_get_option( 'header_button_secondary_bg_color' ) ) {
			$static_css .= '.header-element--secondary-button a { --farmart-header-background-color-secondary: ' . esc_attr( $bg_color ) . ' }';
		}
		if ( $color = farmart_get_option( 'header_button_secondary_color' ) ) {
			$static_css .= '.header-element--secondary-button a, .header-element--secondary-button a:hover { --farmart-header-background-text-color-secondary: ' . esc_attr( $color ) . '; color: '. esc_attr( $color ) .' }';
		}
		if ( $border_color = farmart_get_option( 'header_button_secondary_border_color' ) ) {
			$static_css .= '.header-element--secondary-button a { border-color: ' . esc_attr( $border_color ) . ' }';
		}

		// Header Button Search
		if ( intval( farmart_get_option( 'header_search_button_custom_color' ) ) ) {
			if ( $bg_color = farmart_get_option( 'header_search_button_custom_color_background' ) ) {
				$static_css .= '.farmart-products-search .search-submit { --farmart-header-background-color-secondary: ' . esc_attr( $bg_color ) . ' }';
			}
			if ( $color = farmart_get_option( 'header_search_button_custom_color_text' ) ) {
				$static_css .= '.farmart-products-search .search-submit { --farmart-header-background-text-color-secondary: ' . esc_attr( $color ) . ' }';
			}
		}

		return $static_css;
	}
endif;

if ( ! function_exists( 'farmart_page_static_css' ) ) :
	function farmart_page_static_css() {
		$static_css = '';

		// Page content spacings
		if ( is_page() || farmart_is_blog() || farmart_is_catalog() ) {

			if ( $top = get_post_meta( farmart_get_post_ID(), 'farmart_content_top_padding', true ) ) {
				$static_css .= '.site-content.custom-top-spacing { padding-top: ' . $top . 'px; }';
			}

			if ( $bottom = get_post_meta( farmart_get_post_ID(), 'farmart_content_bottom_padding', true ) ) {
				$static_css .= '.site-content.custom-bottom-spacing{ padding-bottom: ' . $bottom . 'px; }';
			}
		}

		if ( ! is_home() || ! is_front_page() ) {
			$static_css .= '.footer-infor:not(:first-child){ border-top: 1px solid #dcdcdc; }';
		}

		return $static_css;
	}
endif;

if ( ! function_exists( 'farmart_footer_css' ) ) :
	function farmart_footer_css() {
		$static_css = '';

		if ( ! empty( $bg_color = farmart_get_option( 'footer_background_color' ) ) ) {
			$static_css .= '.site-footer { background-color: ' . $bg_color . '; }';
		}

		if ( farmart_get_option( 'footer_padding_top' ) != 0 ) {
			$static_css .= '.site-footer { padding-top: ' . farmart_get_option( 'footer_padding_top' ) . 'px; }';
		}

		if ( farmart_get_option( 'footer_padding_bottom' ) != 0 ) {
			$static_css .= '.site-footer { padding-bottom: ' . farmart_get_option( 'footer_padding_bottom' ) . 'px; }';
		}

		if ( $heading = farmart_get_option( 'footer_background_heading' ) ) {
			$static_css .= '.site-footer { --farmart-footer-heading-color: ' . esc_attr( $heading ) . '; }';
		}

		if ( $color = farmart_get_option( 'footer_background_text' ) ) {
			$static_css .= '.site-footer { --farmart-footer-text-color: ' . esc_attr( $color ) . '; }';
		}

		if ( $hover_color = farmart_get_option( 'footer_background_text_hover' ) ) {
			$static_css .= '.site-footer { --farmart-footer-hover-color: ' . esc_attr( $hover_color ) . '; }';
		}

		return $static_css;
	}
endif;

/**
 * Get typography CSS base on settings
 *
 * @since 1.1.6
 */
if ( ! function_exists( 'farmart_typography_css' ) ) :
	function farmart_typography_css() {
		$css        = '';
		$properties = array(
			'font-family'    => 'font-family',
			'font-size'      => 'font-size',
			'variant'        => 'font-weight',
			'line-height'    => 'line-height',
			'letter-spacing' => 'letter-spacing',
			'color'          => 'color',
			'text-transform' => 'text-transform',
			'text-align'     => 'text-align',
		);

		$settings = array(
			'body_typo'        => 'body',
			'heading1_typo'    => 'h1',
			'heading2_typo'    => 'h2',
			'heading3_typo'    => 'h3',
			'heading4_typo'    => 'h4',
			'heading5_typo'    => 'h5',
			'heading6_typo'    => 'h6',
		);

		foreach ( $settings as $setting => $selector ) {
			$typography = farmart_get_option( $setting );
			$default    = (array) farmart_get_option_default( $setting );
			$style      = '';

			foreach ( $properties as $key => $property ) {
				if ( isset( $typography[ $key ] ) && ! empty( $typography[ $key ] ) ) {
					if ( isset( $default[ $key ] ) && strtoupper( $default[ $key ] ) == strtoupper( $typography[ $key ] ) ) {
						continue;
					}

					$value = 'font-family' == $key ? '"' . rtrim( trim( $typography[ $key ] ), ',' ) . '"' : $typography[ $key ];
					$value = 'variant' == $key ? str_replace( 'regular', '400', $value ) : $value;

					if ( $value ) {
						$style .= $property . ': ' . $value . ';';
					}
				}
			}

			if ( ! empty( $style ) ) {
				$css .= $selector . '{' . $style . '}';
			}
		}

		return $css;
	}
endif;

/**
 * Dynamic css
 *
 * @return string dynamic CSS.
 */
if ( ! function_exists( 'farmart_dynamic_css' ) ) :
	function farmart_dynamic_css() {
		$css = '';
		/* Header Wishlist */
		if (  intval( farmart_get_option('header_wishlist_custom_color') ) ) {
			if ( $color = farmart_get_option('header_wishlist_custom_color_text') ) {
				$css .= '.header-element--wishlist .mini-item-counter { color: ' . $color . '}';
			}
			if ( $bg_color = farmart_get_option('header_wishlist_custom_color_background') ) {
				$css .= '.header-element--wishlist .mini-item-counter { background-color: ' . $bg_color . '}';
			}
		}

		/* Header Compare */
		if (  intval( farmart_get_option('header_compare_custom_color') ) ) {
			if ( $color = farmart_get_option('header_compare_custom_color_text') ) {
				$css .= '.header-element--compare .mini-item-counter { color: ' . $color . '}';
			}
			if ( $bg_color = farmart_get_option('header_compare_custom_color_background') ) {
				$css .= '.header-element--compare .mini-item-counter { background-color: ' . $bg_color . '}';
			}
		}

		/* Header Cart */
		if (  intval( farmart_get_option('header_cart_counter_custom_color') ) ) {
			if ( $color = farmart_get_option('header_cart_counter_custom_color_text') ) {
				$css .= '.header-element--cart .cart-contents .fm-mini-cart-counter { color: ' . $color . '}';
			}
			if ( $bg_color = farmart_get_option('header_cart_counter_custom_color_background') ) {
				$css .= '.header-element--cart .cart-contents .fm-mini-cart-counter { background-color: ' . $bg_color . '}';
			}
		}

		/* Menu Department */
		if (  $bg_color = farmart_get_option('header_menu_department_bg_color') ) {
			$css .= '.site-header .farmart-menu-department { background-color: ' . $bg_color . '}';
		}

		if (  $color = farmart_get_option('header_menu_department_color') ) {
			$css .= '.site-header .farmart-menu-department { color: ' . $color . '}';
		}

		/* Footer Newsletter */
		if (  $bg_color = farmart_get_option('footer_newsletter_bg_color') ) {
			$css .= '.footer-newsletter { --fm-newsletter-background-color: ' . $bg_color . '}';
		}

		if (  $color = farmart_get_option('footer_newsletter_text_color') ) {
			$css .= '.footer-newsletter { --fm-newsletter-text-color: ' . $color . '}';
		}

		return $css;
	}
endif;

/**
 * Returns CSS for the typography.
 *
 * @return string typography CSS.
 */
function farmart_get_heading_typography_css() {

	$headings   = array(
		'h1' => 'heading1_typo',
		'h2' => 'heading2_typo',
		'h3' => 'heading3_typo',
		'h4' => 'heading4_typo',
		'h5' => 'heading5_typo',
		'h6' => 'heading6_typo'
	);
	$inline_css = '';
	foreach ( $headings as $heading ) {
		$keys = array_keys( $headings, $heading );
		if ( $keys ) {
			$inline_css .= farmart_get_heading_font( $keys[0], $heading );
		}
	}

	return $inline_css;

}

/**
 * Returns CSS for the typography.
 *
 *
 * @param array $body_typo Color scheme body typography.
 *
 * @return string typography CSS.
 */
function farmart_get_heading_font( $key, $heading ) {

	$inline_css   = '';
	$heading_typo = farmart_get_option( $heading );

	if ( $heading_typo ) {
		if ( isset( $heading_typo['font-family'] ) && strtolower( $heading_typo['font-family'] ) !== 'Lato' ) {
			$inline_css .= $key . '{font-family:' . rtrim( trim( $heading_typo['font-family'] ), ',' ) . ', Arial, sans-serif}';
		}
	}

	if ( empty( $inline_css ) ) {
		return;
	}

	return <<<CSS
	{$inline_css}
CSS;
}