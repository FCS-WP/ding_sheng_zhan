<?php
/**
 * Load and register widgets
 *
 * @package Farmart
 */

require_once FARMART_ADDONS_DIR . '/inc/widgets/latest-posts.php';

/**
 * Register widgets
 *
 * @return void
 */
function farmart_register_widgets() {
	register_widget( 'Farmart_Latest_Post_Widget' );

	if ( class_exists( 'WC_Widget' ) ) {
		require_once FARMART_ADDONS_DIR . '/inc/widgets/group.php';
		require_once FARMART_ADDONS_DIR . '/inc/widgets/widget-layered-nav.php';
		require_once FARMART_ADDONS_DIR . '/inc/widgets/product-categories.php';
		require_once FARMART_ADDONS_DIR . '/inc/widgets/product-tag.php';
		require_once FARMART_ADDONS_DIR . '/inc/widgets/widget-brands-nav.php';
		require_once FARMART_ADDONS_DIR . '/inc/widgets/widget-rating-filter.php';
		require_once FARMART_ADDONS_DIR . '/inc/widgets/widget-products.php';
		require_once FARMART_ADDONS_DIR . '/inc/widgets/widget-products-carousel.php';
		require_once FARMART_ADDONS_DIR . '/inc/widgets/widget-layered-nav-filters.php';
		require_once FARMART_ADDONS_DIR . '/inc/widgets/widget-price-list.php';
		require_once FARMART_ADDONS_DIR . '/inc/widgets/languages.php';
		require_once FARMART_ADDONS_DIR . '/inc/widgets/currency.php';
		require_once FARMART_ADDONS_DIR . '/inc/widgets/account.php';


		register_widget( 'Farmart_Group_Widget' );
		register_widget( 'Farmart_Widget_Brands_Nav' );
		register_widget( 'Farmart_Widget_Product_Categories' );
		register_widget( 'Farmart_Widget_Product_Tag_Cloud' );
		register_widget( 'Farmart_Widget_Rating_Filter' );
		register_widget( 'Farmart_Widget_Layered_Nav' );
		register_widget( 'Farmart_Widget_Products' );
		register_widget( 'Farmart_Widget_Products_Carousel' );
		register_widget( 'Farmart_Widget_Layered_Nav_Filters' );
		register_widget( 'Farmart_Price_Filter_List_Widget' );
		register_widget( 'Farmart_Language_Switcher_Widget' );
		register_widget( 'Farmart_Currency_Switch_Widget' );
		register_widget( 'Farmart_Account_Widget' );
	}
}

add_action( 'widgets_init', 'farmart_register_widgets' );

/**
 * Get catalog layout
 *
 * @since 1.0
 */
if ( ! function_exists( 'farmart_get_filtered_term_product_counts' ) ) :
	function farmart_get_filtered_term_product_counts( $term_ids, $taxonomy = false, $query_type = false ) {
		global $wpdb;

		if ( ! class_exists( 'WC_Query' ) ) {
			return false;
		}

		$tax_query  = WC_Query::get_main_tax_query();
		$meta_query = WC_Query::get_main_meta_query();

		if ( 'or' === $query_type ) {
			foreach ( $tax_query as $key => $query ) {
				if ( is_array( $query ) && $taxonomy === $query['taxonomy'] ) {
					unset( $tax_query[ $key ] );
				}
			}
		}

		if ( 'product_brand' === $taxonomy ) {
			foreach ( $tax_query as $key => $query ) {
				if ( is_array( $query ) ) {
					if ( $query['taxonomy'] === 'product_brand' ) {
						unset( $tax_query[ $key ] );

						if ( preg_match( '/pa_/', $query['taxonomy'] ) ) {
							unset( $tax_query[ $key ] );
						}
					}
				}
			}
		}

		$meta_query     = new WP_Meta_Query( $meta_query );
		$tax_query      = new WP_Tax_Query( $tax_query );
		$meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
		$tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

		// Generate query
		$query           = array();
		$query['select'] = "SELECT COUNT( DISTINCT {$wpdb->posts}.ID ) as term_count, terms.term_id as term_count_id";
		$query['from']   = "FROM {$wpdb->posts}";
		$query['join']   = "
			INNER JOIN {$wpdb->term_relationships} AS term_relationships ON {$wpdb->posts}.ID = term_relationships.object_id
			INNER JOIN {$wpdb->term_taxonomy} AS term_taxonomy USING( term_taxonomy_id )
			INNER JOIN {$wpdb->terms} AS terms USING( term_id )
			" . $tax_query_sql['join'] . $meta_query_sql['join'];

		$query['where'] = "
			WHERE {$wpdb->posts}.post_type IN ( 'product' )
			AND {$wpdb->posts}.post_status = 'publish'
			" . $tax_query_sql['where'] . $meta_query_sql['where'] . "
			AND terms.term_id IN (" . implode( ',', array_map( 'absint', $term_ids ) ) . ")
		";

		if ( $search = WC_Query::get_main_search_query_sql() ) {
			$query['where'] .= ' AND ' . $search;
		}

		$query['group_by'] = "GROUP BY terms.term_id";
		$query             = apply_filters( 'woocommerce_get_filtered_term_product_counts_query', $query );
		$query             = implode( ' ', $query );

		// We have a query - let's see if cached results of this query already exist.
		$query_hash = md5( $query );
		$cache      = apply_filters( 'woocommerce_layered_nav_count_maybe_cache', true );
		if ( true === $cache ) {
			$cached_counts = (array) get_transient( 'wc_layered_nav_counts_' . sanitize_title( $taxonomy ) );
		} else {
			$cached_counts = array();
		}

		if ( ! isset( $cached_counts[ $query_hash ] ) ) {
			$results                      = $wpdb->get_results( $query, ARRAY_A );
			$counts                       = array_map( 'absint', wp_list_pluck( $results, 'term_count', 'term_count_id' ) );
			$cached_counts[ $query_hash ] = $counts;
			set_transient( 'wc_layered_nav_counts_' . sanitize_title( $taxonomy ), $cached_counts, DAY_IN_SECONDS );
		}

		return array_map( 'absint', (array) $cached_counts[ $query_hash ] );
	}
endif;