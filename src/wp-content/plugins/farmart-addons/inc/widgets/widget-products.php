<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Farmart_Widget_Products' ) ) {
	/**
	 * List products. One widget to rule them all.
	 *
	 * @author   WooThemes
	 * @category Widgets
	 * @package  WooCommerce/Widgets
	 * @version  2.3.0
	 * @extends  WC_Widget
	 */
	class Farmart_Widget_Products extends WC_Widget {

		/**
		 * Constructor.
		 */
		public function __construct() {
			$this->widget_cssclass    = 'woocommerce widget_products fm-widget-products';
			$this->widget_description = esc_html__( "A list of your store's products.", 'farmart-addons' );
			$this->widget_id          = 'fm_woocommerce_products';
			$this->widget_name        = esc_html__( 'Farmart - Products', 'farmart-addons' );
			$this->settings           = array(
				'title'    => array(
					'type'  => 'text',
					'std'   => esc_html__( 'Products', 'farmart-addons' ),
					'label' => esc_html__( 'Title', 'farmart-addons' ),
				),
				'number'   => array(
					'type'  => 'number',
					'step'  => 1,
					'min'   => 1,
					'max'   => '',
					'std'   => 5,
					'label' => esc_html__( 'Number of products to show', 'farmart-addons' ),
				),
				'show'     => array(
					'type'    => 'select',
					'std'     => '',
					'label'   => esc_html__( 'Show', 'farmart-addons' ),
					'options' => array(
						''         => esc_html__( 'All products', 'farmart-addons' ),
						'featured' => esc_html__( 'Featured products', 'farmart-addons' ),
						'onsale'   => esc_html__( 'On-sale products', 'farmart-addons' ),
					),
				),
				'orderby'  => array(
					'type'    => 'select',
					'std'     => 'date',
					'label'   => esc_html__( 'Order by', 'farmart-addons' ),
					'options' => array(
						'date'  => esc_html__( 'Date', 'farmart-addons' ),
						'price' => esc_html__( 'Price', 'farmart-addons' ),
						'rand'  => esc_html__( 'Random', 'farmart-addons' ),
						'sales' => esc_html__( 'Sales', 'farmart-addons' ),
					),
				),
				'order'    => array(
					'type'    => 'select',
					'std'     => 'desc',
					'label'   => _x( 'Order', 'Sorting order', 'farmart-addons' ),
					'options' => array(
						'asc'  => esc_html__( 'ASC', 'farmart-addons' ),
						'desc' => esc_html__( 'DESC', 'farmart-addons' ),
					),
				),
				'taxonomy' => array(
					'type'    => 'select',
					'std'     => 'desc',
					'label'   => esc_html__( 'Condition', 'farmart-addons' ),
					'options' => array(
						''         => esc_html__( 'Default', 'farmart-addons' ),
						'category' => esc_html__( 'Same Current Category', 'farmart-addons' ),
						'brand'    => esc_html__( 'Same Current Brand', 'farmart-addons' ),
						'vendor'   => esc_html__( 'Same Current Vendor', 'farmart-addons' ),
					),
				),

				'hide_outofstock' => array(
					'type'  => 'checkbox',
					'std'   => 0,
					'label' => esc_html__( 'Hide out of stock products', 'farmart-addons' ),
				),
				'hide_free'       => array(
					'type'  => 'checkbox',
					'std'   => 0,
					'label' => esc_html__( 'Hide free products', 'farmart-addons' ),
				),
				'show_hidden'     => array(
					'type'  => 'checkbox',
					'std'   => 0,
					'label' => esc_html__( 'Show hidden products', 'farmart-addons' ),
				),
			);

			parent::__construct();
		}

		/**
		 * Query the products and return them.
		 *
		 * @param  array $args
		 * @param  array $instance
		 *
		 * @return WP_Query
		 */
		public function get_products( $args, $instance ) {
			$number                      = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : $this->settings['number']['std'];
			$show                        = ! empty( $instance['show'] ) ? sanitize_title( $instance['show'] ) : $this->settings['show']['std'];
			$orderby                     = ! empty( $instance['orderby'] ) ? sanitize_title( $instance['orderby'] ) : $this->settings['orderby']['std'];
			$order                       = ! empty( $instance['order'] ) ? sanitize_title( $instance['order'] ) : $this->settings['order']['std'];
			$product_visibility_term_ids = wc_get_product_visibility_term_ids();

			$query_args = array(
				'posts_per_page' => $number,
				'post_status'    => 'publish',
				'post_type'      => 'product',
				'no_found_rows'  => 1,
				'order'          => $order,
				'meta_query'     => array(),
				'tax_query'      => array(
					'relation' => 'AND',
				),
			);

			if ( empty( $instance['show_hidden'] ) ) {
				$query_args['tax_query'][] = array(
					'taxonomy' => 'product_visibility',
					'field'    => 'term_taxonomy_id',
					'terms'    => is_search() ? $product_visibility_term_ids['exclude-from-search'] : $product_visibility_term_ids['exclude-from-catalog'],
					'operator' => 'NOT IN',
				);
				$query_args['post_parent'] = 0;
			}

			if ( ! empty( $instance['hide_free'] ) ) {
				$query_args['meta_query'][] = array(
					'key'     => '_price',
					'value'   => 0,
					'compare' => '>',
					'type'    => 'DECIMAL',
				);
			}

			if ( intval( $instance['hide_outofstock'] ) ) {
				$query_args['meta_query'][] = array(
					array(
						'key'     => '_stock_status',
						'value'   => 'outofstock',
						'compare' => '!='
					),
				);
			}

			if ( ! empty( $instance['taxonomy'] ) ) {
				$term_ids = array();

				if ( $instance['taxonomy'] == 'vendor' ) {
					$vendor_id = 0;
					if ( is_singular( 'product' ) ) {
						$vendor_id = get_post_field( 'post_author', get_the_ID() );
					}

					if ( $vendor_id ) {
						$query_args['post__not_in'] = array( get_the_ID() );

						if ( class_exists( 'WCMp' ) ) {
							global $product;
							if ( function_exists( 'get_wcmp_product_vendors' ) ) {
								$vendor = get_wcmp_product_vendors( $product->get_id() );
								if ( $vendor ) {
									$query_args['author__in'] = $vendor->id;
								}
							}

						} elseif ( class_exists( 'WeDevs_Dokan' ) || class_exists( 'WC_Vendors' ) || class_exists( 'WCFMmp' ) ) {
							$query_args['author'] = (int) $vendor_id;
						}
					}

				} else {
					$taxonomy = 'product_cat';
					if ( $instance['taxonomy'] == 'brand' ) {
						$taxonomy = 'product_brand';
					}

					if ( is_singular( 'product' ) ) {
						$term_ids                   = wp_get_post_terms( get_the_ID(), $taxonomy, array( "fields" => "ids" ) );
						$query_args['post__not_in'] = array( get_the_ID() );
					}

					if ( $term_ids && is_array( $term_ids ) ) {
						$query_args['tax_query'] = array(
							array(
								'taxonomy' => $taxonomy,
								'field'    => 'term_id',
								'terms'    => $term_ids,
							),
						);
					}
				}
			}

			switch ( $show ) {
				case 'featured' :
					$query_args['tax_query'][] = array(
						'taxonomy' => 'product_visibility',
						'field'    => 'term_taxonomy_id',
						'terms'    => $product_visibility_term_ids['featured'],
					);
					break;
				case 'onsale' :
					$product_ids_on_sale    = wc_get_product_ids_on_sale();
					$product_ids_on_sale[]  = 0;
					$query_args['post__in'] = $product_ids_on_sale;
					break;
			}

			switch ( $orderby ) {
				case 'price' :
					$query_args['meta_key'] = '_price';
					$query_args['orderby']  = 'meta_value_num';
					break;
				case 'rand' :
					$query_args['orderby'] = 'rand';
					break;
				case 'sales' :
					$query_args['meta_key'] = 'total_sales';
					$query_args['orderby']  = 'meta_value_num';
					break;
				default :
					$query_args['orderby'] = 'date';
			}

			return new WP_Query( apply_filters( 'woocommerce_products_widget_query_args', $query_args ) );
		}

		/**
		 * Output widget.
		 *
		 * @see WP_Widget
		 *
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) {
			if ( $this->get_cached_widget( $args ) ) {
				return;
			}

			ob_start();

			if ( ( $products = $this->get_products( $args, $instance ) ) && $products->have_posts() ) {
				$this->widget_start( $args, $instance );

				echo apply_filters( 'woocommerce_before_widget_product_list', '<ul class="products product_list_widget">' );

				$template_args = array(
					'widget_id'   => isset( $args['widget_id'] ) ? $args['widget_id'] : $this->widget_id,
					'show_rating' => true,
				);

				while ( $products->have_posts() ) {
					$products->the_post();
					wc_get_template( 'content-widget-product.php', $template_args );
				}

				echo apply_filters( 'woocommerce_after_widget_product_list', '</ul>' );

				$this->widget_end( $args );
			}

			wp_reset_postdata();

			echo $this->cache_widget( $args, ob_get_clean() );
		}
	}
}