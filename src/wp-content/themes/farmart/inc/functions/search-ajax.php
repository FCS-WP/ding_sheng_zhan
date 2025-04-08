<?php
/**
 * Ajax search
 */

/**
 * Search products
 *
 * @since 1.0
 */
function instance_search_form() {
	$response = array();

	if ( isset( $_POST['search_type'] ) && empty( $_POST['search_type'] ) ) {
		$response = instance_search_every_things_result();
	} else {
		$response = instance_search_products_result();
	}

	if ( empty( $response ) ) {
		$response[] = sprintf( '<li>%s</li>', esc_html__( 'Nothing found', 'farmart' ) );
	}

	$output = sprintf( '<ul>%s</ul>', implode( ' ', $response ) );

	wp_send_json_success( $output );
	die();
}

add_action( 'wc_ajax_farmart_instance_search_form', 'instance_search_form' );

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
 * Get blog taxonomy list
 *
 * @since 1.0.0
 *
 * @return void
 */
function taxs_list_search( $taxonomy = 'product_cat' ) {
		$view_all = 'All';
		$cats   = '';
		$output = array();
		$args = array(
			'number' => 5,
			'parent' => 0
		);
		if ( farmart_get_option('header_search_category_include') ) {
			$args['include'] = farmart_get_option('header_search_category_include');
		}

		if ( farmart_get_option('header_search_category_exclude') ) {
			$args['exclude'] = farmart_get_option('header_search_category_exclude');
		}
		$term_id = 0;
		if ( is_tax( $taxonomy ) || is_category() ) {

			$queried_object = get_queried_object();
			if ( $queried_object ) {
				$term_id = $queried_object->term_id;
			}
		}
		$found       = false;
		$categories = get_terms( $taxonomy, $args );
		if ( ! is_wp_error( $categories ) && $categories ) {
			foreach ( $categories as $cat ) {
				$cat_selected = '';
				if ( $cat->term_id == $term_id ) {
					$cat_selected = 'actived';
					$found        = true;
				}
				$cats .= sprintf( '<li class="%s"><a data-catslug="%s" href="%s">%s</a></li>',  esc_attr( $cat_selected ), $cat->slug, esc_url( get_term_link( $cat ) ), esc_html( $cat->name ) );
			}
		}
		$cat_selected = $found ? '' : 'actived';
		if ( $cats ) {
			$blog_url = get_page_link( get_option( 'page_for_posts' ) );
			if ( 'posts' == get_option( 'show_on_front' ) ) {
				$blog_url = home_url();
			}
			$view_all_box = '';
			if ( ! empty( $view_all ) ) {
				$view_all_box = sprintf(
					'<li class="%s"><a href="%s">%s</a></li>',
					esc_attr( $cat_selected ),
					esc_url( $blog_url ),
					esc_html( $view_all )
				);
			}
			$output[] = sprintf(
				'<div class="product-cat"><ul class="product-cat-click">%s%s</ul></div>',
				$view_all_box,
				$cats
			);
		}
		if ( $output ) {
			$output = apply_filters( 'farmart_taxs_list', $output );
			echo implode( "\n", $output );
		}
	}