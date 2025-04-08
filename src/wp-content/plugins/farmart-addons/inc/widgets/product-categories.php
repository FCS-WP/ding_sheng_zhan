<?php
/**
 * Product Categories Widget
 *
 * @author   Automattic
 * @category Widgets
 * @package  WooCommerce/Widgets
 * @version  2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Farmart_Widget_Product_Categories' ) ) {
	/**
	 * Product categories widget class.
	 *
	 * @extends WC_Widget
	 */
	class Farmart_Widget_Product_Categories extends WC_Widget {

		/**
		 * Category ancestors.
		 *
		 * @var array
		 */
		public $cat_ancestors;

		/**
		 * Current Category.
		 *
		 * @var bool
		 */
		public $current_cat;

		/**
		 * Constructor.
		 */
		public function __construct() {
			$this->widget_cssclass    = 'woocommerce fm_widget_product_categories';
			$this->widget_description = esc_html__( 'A list of product categories.', 'farmart-addons' );
			$this->widget_id          = 'fm_product_categories';
			$this->widget_name        = esc_html__( 'Farmart - Product Categories', 'farmart-addons' );
			$this->settings           = array(
				'title'                     => array(
					'type'  => 'text',
					'std'   => esc_html__( 'Product categories', 'farmart-addons' ),
					'label' => esc_html__( 'Title', 'farmart-addons' ),
				),
				'orderby'                   => array(
					'type'    => 'select',
					'std'     => 'name',
					'label'   => esc_html__( 'Order by', 'farmart-addons' ),
					'options' => array(
						'order' => esc_html__( 'Category order', 'farmart-addons' ),
						'title' => esc_html__( 'Name', 'farmart-addons' ),
					),
				),
				'show_dropdown'                     => array(
					'type'  => 'checkbox',
					'std'   => 0,
					'label' => esc_html__( 'Show dropdown widget', 'farmart-addons' ),
				),
				'count'                     => array(
					'type'  => 'checkbox',
					'std'   => 0,
					'label' => esc_html__( 'Show product counts', 'farmart-addons' ),
				),
				'hide_empty'                => array(
					'type'  => 'checkbox',
					'std'   => 0,
					'label' => esc_html__( 'Hide empty categories', 'farmart-addons' ),
				),
				'show_all_cats'             => array(
					'type'  => 'checkbox',
					'std'   => 1,
					'label' => esc_html__( 'Only show children of the current category', 'farmart-addons' ),
					'class' => 'fm_categories_show_children_only'
				),
				'show_first_level_children' => array(
					'type'  => 'checkbox',
					'std'   => 0,
					'label' => esc_html__( 'Only show the first level children of the current category', 'farmart-addons' ),
					'class' => 'fm_categories_show_children_only_els'
				),
				'max_depth'                 => array(
					'type'  => 'text',
					'std'   => '',
					'label' => esc_html__( 'Maximum depth', 'farmart-addons' ),
				),
			);

			parent::__construct();
			add_action( 'admin_print_scripts', array( $this, 'admin_scripts' ) );

			add_filter( 'wp_list_categories', array( $this, 'change_cat_count_html' ) );
		}

		/**
		 * Enqueue scripts in the backend.
		 */
		public function admin_scripts() {
			global $pagenow;

			if ( 'widgets.php' != $pagenow && 'customize.php' != $pagenow ) {
				return;
			}

			wp_enqueue_script( 'farmart-widget-admin', FARMART_ADDONS_URL . '/assets/js/product-categories-admin.js', array(), '20201029' );

		}

		/**
		 * Change Category Count Html
		 */
		public function change_cat_count_html( $links ) {
			$links = str_replace('</a> (', ' <span class="count">', $links);
			$links = str_replace(')', '</span></a>', $links);

			return $links;
		}

		/**
		 * Output widget.
		 *
		 * @see WP_Widget
		 *
		 * @param array $args Widget arguments.
		 * @param array $instance Widget instance.
		 */
		public function widget( $args, $instance ) {
			global $wp_query, $post;

			$show_dropdown             = isset( $instance['show_dropdown'] ) ? $instance['show_dropdown'] : '';
			$count                     = isset( $instance['count'] ) ? $instance['count'] : $this->settings['count']['std'];
			$orderby                   = isset( $instance['orderby'] ) ? $instance['orderby'] : $this->settings['orderby']['std'];
			$hide_empty                = isset( $instance['hide_empty'] ) ? $instance['hide_empty'] : $this->settings['hide_empty']['std'];
			$show_children_only        = isset( $instance['show_all_cats'] ) ? $instance['show_all_cats'] : $this->settings['show_all_cats']['std'];
			$show_first_level_children = isset( $instance['show_first_level_children'] ) ? $instance['show_first_level_children'] : $this->settings['show_first_level_children']['std'];

			$list_args = array(
				'show_count'   => $count,
				'hierarchical' => 1,
				'taxonomy'     => 'product_cat',
				'hide_empty'   => $hide_empty,
			);
			$max_depth = absint( isset( $instance['max_depth'] ) ? $instance['max_depth'] : $this->settings['max_depth']['std'] );

			$list_args['menu_order'] = false;
			$list_args['depth']      = $max_depth;

			if ( 'order' === $orderby ) {
				$list_args['menu_order'] = 'asc';
			} else {
				$list_args['orderby'] = $orderby;
				if ( $orderby === 'count' ) {
					$list_args['order'] = 'desc';
				}
			}

			$this->current_cat   = false;
			$this->cat_ancestors = array();

			if ( is_tax( 'product_cat' ) ) {
				$this->current_cat   = $wp_query->queried_object;
				$this->cat_ancestors = get_ancestors( $this->current_cat->term_id, 'product_cat' );

			} elseif ( is_singular( 'product' ) ) {
				if ( apply_filters( 'farmart_yoast_get_primary_term_id', function_exists( 'yoast_get_primary_term_id' ) ) ) {
					if ( $primary_id = yoast_get_primary_term_id( 'product_cat' ) ) {
						$term                = get_term( $primary_id, 'product_cat' );
						$this->current_cat   = $term;
						$this->cat_ancestors = get_ancestors( $primary_id, 'product_cat' );
					}

				} else {
					$terms = wc_get_product_terms(
						$post->ID,
						'product_cat',
						apply_filters(
							'woocommerce_product_categories_widget_product_terms_args',
							array(
								'orderby' => 'parent',
								'order'   => 'DESC',
							)
						)
					);

					if ( $terms ) {
						$main_term           = apply_filters( 'woocommerce_product_categories_widget_main_term', $terms[0], $terms );
						$this->current_cat   = $main_term;
						$this->cat_ancestors = get_ancestors( $main_term->term_id, 'product_cat' );
					}
				}

			}
			// Show Siblings and Children Only.
			if ( $show_children_only && $this->current_cat ) {
				if ( $show_first_level_children ) {
					// Direct children.
					$include = get_terms(
						'product_cat',
						array(
							'fields'       => 'ids',
							'hierarchical' => true,
							'parent'       => $this->current_cat->term_id,
							'hide_empty'   => false,
						)
					);

					if ( empty( $include ) ) {
						$list_args['child_of'] = $this->current_cat->term_id;
					} else {
						$list_args['include'] = implode( ',', $include );
					}
				} else {
					$list_args['child_of'] = $this->current_cat->term_id;
				}


			} elseif ( $show_children_only ) {
				$list_args['child_of']     = 0;
				$list_args['hierarchical'] = 1;
			}

			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			echo wp_kses_post( $args['before_widget'] );
			if ( ! empty( $title ) ) {
				$icon = $show_dropdown ? '<span class="toggle-widget-btn"></span>' : '';
				echo wp_kses_post( $args['before_title'] ) . $title . $icon . wp_kses_post( $args['after_title'] );
			}

			$list_args['title_li']                   = '';
			$list_args['pad_counts']                 = 1;
			$list_args['show_option_none']           = '';
			$list_args['current_category']           = ( $this->current_cat ) ? $this->current_cat->term_id : '';
			$list_args['current_category_ancestors'] = $this->cat_ancestors;
			$list_args['max_depth']                  = $max_depth;

			$class_list     = 'fm-widget-vertical-item';
			$class_list 	.= $show_children_only ? ' show-children-only' : '';
			$class_list 	.= $this->current_cat ? ' show-current-cat' : '';
			echo '<ul class="product-categories ' . esc_attr( $class_list ) . '">';

			if ( $this->current_cat && $show_children_only ) {
				$product_count = wp_count_posts( 'product' );
				$count_html = '';
				if ( $count == 1 ) {
					$count_html = '<span class="count">'. $product_count->publish .'</span>';
				}

				$back_shop     = sprintf( '<li class="fm-back-shop"><a href="%s">%s %s</a></li>', esc_url( get_post_type_archive_link( 'product' ) ), esc_html__( 'All', 'farmart-addons' ), $count_html );
				$cat_ancestors = array_reverse( $this->cat_ancestors );
				array_push( $cat_ancestors, $this->current_cat->term_id );
				foreach ( $cat_ancestors as $parent_id ) {
					$query_parentID = new WP_Query( array(
						'tax_query' => array(
							array(
								'taxonomy' => 'product_cat',
								'field' => 'id',
								'terms' => $parent_id, // Replace with the parent category ID
								'include_children' => true,
							),
						),
						'nopaging' => true,
						'fields' => 'ids',
					) );

					if ( $count == 1 ) {
						$count_html = '<span class="count">'. $query_parentID->post_count .'</span>';
					}

					$parent_term  = get_term_by( 'id', $parent_id, 'product_cat' );
					$active_class = $parent_id == $this->current_cat->term_id ? 'fm-current-tax' : '';
					$back_shop    .= sprintf( '<li class="fm-back-shop %s"><a href="%s">%s %s</a></li>', esc_attr( $active_class ), esc_url( get_term_link( $parent_id, 'product_cat' ) ), $parent_term->name, $count_html );
				}

				echo $back_shop;
			}

			wp_list_categories( apply_filters( 'woocommerce_product_categories_widget_args', $list_args ) );

			echo '</ul>';

			$this->widget_end( $args );
		}
	}
}