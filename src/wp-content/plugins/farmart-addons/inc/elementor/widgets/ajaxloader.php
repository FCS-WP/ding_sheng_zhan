<?php

namespace FarmartAddons;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Elementor_Widgets_AjaxLoader {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'wc_ajax_farmart_instance_search_form', [ $this, 'instance_search_form' ] );
		add_action( 'wc_ajax_farmart_recently_viewed_products', [ $this, 'recently_viewed_products' ] );
	}

	/**
	 * Search products
	 *
	 * @since 1.0
	 */
	public function instance_search_form() {
		$response = array();

		if ( isset( $_POST['search_type'] ) && empty( $_POST['search_type'] ) ) {
			$response = $this->instance_search_every_things_result();
		} else {
			$response = $this->instance_search_products_result();
		}

		if ( empty( $response ) ) {
			$response[] = sprintf( '<li>%s</li>', esc_html__( 'Nothing found', 'farmart-addons' ) );
		}

		$output = sprintf( '<ul>%s</ul>', implode( ' ', $response ) );

		wp_send_json_success( $output );
		die();
	}

	function instance_search_products_result() {
		$response      = array();
		$result_number = isset( $_POST['search_type'] ) ? intval( $_POST['ajax_search_number'] ) : 0;
		$args_sku      = array(
			'post_type'        => 'product',
			'posts_per_page'   => $result_number,
			'meta_query'       => array(
				array(
					'key'     => '_sku',
					'value'   => trim( $_POST['term'] ),
					'compare' => 'like',
				),
			),
			'suppress_filters' => 0,
		);

		$args_variation_sku = array(
			'post_type'        => 'product_variation',
			'posts_per_page'   => $result_number,
			'meta_query'       => array(
				array(
					'key'     => '_sku',
					'value'   => trim( $_POST['term'] ),
					'compare' => 'like',
				),
			),
			'suppress_filters' => 0,
		);

		$args = array(
			'post_type'        => 'product',
			'posts_per_page'   => $result_number,
			's'                => trim( $_POST['term'] ),
			'suppress_filters' => 0,
		);

		if ( function_exists( 'wc_get_product_visibility_term_ids' ) ) {
			$product_visibility_term_ids = wc_get_product_visibility_term_ids();
			$args['tax_query'][]         = array(
				'taxonomy' => 'product_visibility',
				'field'    => 'term_taxonomy_id',
				'terms'    => $product_visibility_term_ids['exclude-from-search'],
				'operator' => 'NOT IN',
			);
		}
		if ( isset( $_POST['cat'] ) && $_POST['cat'] != '0' ) {
			$args['tax_query'][] = array(
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => $_POST['cat'],
			);

			$args_sku['tax_query'] = array(
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => $_POST['cat'],
				),

			);
		}

		$products_sku           = get_posts( $args_sku );
		$products_s             = get_posts( $args );
		$products_variation_sku = get_posts( $args_variation_sku );

		$products    = array_merge( $products_sku, $products_s, $products_variation_sku );
		$product_ids = array();
		foreach ( $products as $product ) {
			$id = $product->ID;
			if ( ! in_array( $id, $product_ids ) ) {
				$product_ids[] = $id;

				$productw   = wc_get_product( $id );
				$response[] = sprintf(
					'<li>' .
					'<a class="image-item" href="%s">' .
					'%s' .
					'</a>' .
					'<div class="content-item">' .
					'<a class="title-item" href="%s">' .
					'%s' .
					'</a>' .
					'<div class="rating-item">%s</div>' .
					'<div class="price-item">%s</div>' .
					'</div>' .
					'</li>',
					esc_url( $productw->get_permalink() ),
					$productw->get_image( 'shop_catalog' ),
					esc_url( $productw->get_permalink() ),
					$productw->get_title(),
					wc_get_rating_html( $productw->get_average_rating() ),
					$productw->get_price_html()
				);
			}
		}

		return $response;
	}

	function instance_search_every_things_result() {
		$response      = array();
		$result_number = isset( $_POST['search_type'] ) ? intval( $_POST['ajax_search_number'] ) : 0;
		$args          = array(
			'post_type'        => 'any',
			'posts_per_page'   => $result_number,
			's'                => trim( $_POST['term'] ),
			'suppress_filters' => 0,
		);

		$posts    = get_posts( $args );
		$post_ids = array();
		foreach ( $posts as $post ) {
			$id = $post->ID;
			if ( ! in_array( $id, $post_ids ) ) {
				$post_ids[] = $id;
				$response[] = sprintf(
					'<li>' .
					'<a class="image-item" href="%s">' .
					'%s' .
					'</a>' .
					'<div class="content-item">' .
					'<a class="title-item" href="%s">' .
					'%s' .
					'</a>' .
					'</li>',
					esc_url( get_the_permalink( $id ) ),
					get_the_post_thumbnail( $id ),
					esc_url( get_the_permalink( $id ) ),
					$post->post_title
				);
			}
		}

		return $response;
	}

	/**
	 * get_recently_viewed_products
	 */
	public function recently_viewed_products() {

		$numbers = $_POST['numbers'];
		$output          = $this->recently_viewed_products_content( $numbers );
		wp_send_json_success( $output );
		die();
	}

	public function recently_viewed_products_content( $numbers ) {

		$viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
		$viewed_products = array_reverse( array_filter( array_map( 'absint', $viewed_products ) ) );

		$output = array();

		if ( empty( $viewed_products ) ) {

			$output[] = sprintf(
				'<ul class="product-list no-products">' .
				'<li class="text-center">%s <br><a href="%s" class="btn-secondary">%s</a></li>' .
				'</ul>',
				esc_html__( 'Recently Viewed Products is a function which helps you keep track of your recent viewing history.', 'farmart-addons' ),
				esc_url( get_permalink( get_option( 'woocommerce_shop_page_id' ) ) ),
				esc_html__( 'Shop Now', 'farmart-addons' )
			);

		} else {
			if ( ! function_exists( 'wc_get_product' ) ) {
				$output[] = sprintf(
					'<ul class="product-list no-products">' .
					'<li class="text-center">%s <br><a href="%s" class="btn-secondary">%s</a></li>' .
					'</ul>',
					esc_html__( 'Recently Viewed Products is a function which helps you keep track of your recent viewing history.', 'farmart-addons' ),
					esc_url( get_permalink( get_option( 'woocommerce_shop_page_id' ) ) ),
					esc_html__( 'Shop Now', 'farmart-addons' )
				);
			}

			$thumbnail_size = 'thumbnail';
			if ( function_exists( 'wc_get_image_size' ) ) {
				$gallery_thumbnail = wc_get_image_size( 'shop_catalog' );
				$thumbnail_size    = apply_filters( 'woocommerce_gallery_thumbnail_size', array(
					$gallery_thumbnail['width'],
					$gallery_thumbnail['height']
				) );
			}

			$number = intval( $numbers );

			$output[] = '<ul class="product-list">';
			$index    = 1;

			foreach ( $viewed_products as $product_id ) {
				if ( $index > $number ) {
					break;
				}

				$product = wc_get_product( $product_id );

				if ( empty( $product ) ) {
					continue;
				}
				$output[] = sprintf(
					'<li class="product">' .
					'<a href="%s">%s</a>' .
					'</li>',
					esc_url( $product->get_permalink() ),
					$product->get_image( $thumbnail_size )
				);

				$index ++;
			}
			$output[] = '</ul>';
		}


		return '<div class="recently-product-wrapper">' . implode( ' ', $output ). '<div>';
	}
}

new Elementor_Widgets_AjaxLoader();