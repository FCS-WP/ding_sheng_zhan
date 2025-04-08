<?php

namespace FarmartAddons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;
use FarmartAddons\Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon Box widget
 */
class Product_Categories_Grid extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'farmart-product-categories-grid';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Farmart - Product Categories Grid', 'farmart-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'farmart' ];
	}

	public function get_script_depends() {
		return [
			'farmart-elementor'
		];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */

	protected function register_controls() {
		$this->section_content();
		$this->section_style();
	}

	/**
	 * Section Content
	 */
	protected function section_content() {
		$this->content_settings_controls();
		$this->link_settings_controls();
	}

	protected function content_settings_controls() {
		$this->start_controls_section(
			'section_content',
			[ 'label' => esc_html__( 'Content', 'farmart-addons' ) ]
		);

		$this->add_control(
			'cats_source',
			[
				'label'       => esc_html__( 'Source', 'farmart-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'default' => esc_html__( 'Default', 'farmart-addons' ),
					'custom'  => esc_html__( 'Custom', 'farmart-addons' ),
				],
				'default'     => 'default',
				'label_block' => false,
			]
		);
		$this->add_control(
			'cats_display',
			[
				'label'       => esc_html__( 'Categories Display', 'farmart-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'all'    => esc_html__( 'All', 'farmart-addons' ),
					'parent' => esc_html__( 'Parent Categories Only', 'farmart-addons' ),
				],
				'default'     => 'parent',
				'label_block' => true,
				'condition'   => [
					'cats_source' => 'default',
				],
			]
		);
		$this->add_control(
			'cats_number',
			[
				'label'       => esc_html__( 'Categories to show', 'farmart-addons' ),
				'description' => esc_html__( 'Set 0 to show all categories', 'farmart-addons' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 8,
				'condition'   => [
					'cats_source' => 'default',
				],
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'        => esc_html__( 'Columns', 'farmart-addons' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => [
					'1' => esc_html__( '1 Column', 'farmart-addons' ),
					'2' => esc_html__( '2 Columns', 'farmart-addons' ),
					'3' => esc_html__( '3 Columns', 'farmart-addons' ),
					'4' => esc_html__( '4 Columns', 'farmart-addons' ),
					'5' => esc_html__( '5 Columns', 'farmart-addons' ),
				],
				'default'      => '3',
				'toggle'       => false,
				'prefix_class' => 'columns-%s',
			]
		);

		$this->add_control(
			'cats_orderby',
			[
				'label'       => esc_html__( 'Order by', 'farmart-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'name'  => esc_html__( 'Name', 'farmart-addons' ),
					'id'    => esc_html__( 'ID', 'farmart-addons' ),
					'count' => esc_html__( 'Count', 'farmart-addons' ),
					'menu_order' => esc_html__( 'Menu Order', 'farmart-addons' ),
				],
				'default'     => 'count',
				'label_block' => false,
				'condition'   => [
					'cats_source' => 'default',
				],
			]
		);

		$this->add_control(
			'cats_order',
			[
				'label'       => esc_html__( 'Order', 'farmart-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'ASC'  => esc_html__( 'ASC', 'farmart-addons' ),
					'DESC' => esc_html__( 'DESC', 'farmart-addons' ),
				],
				'default'     => 'DESC',
				'label_block' => false,
				'condition'   => [
					'cats_source' => 'default',
				],
			]
		);

		$this->add_control(
			'cats_selected',
			[
				'label'       => esc_html__( 'Categories', 'farmart-addons' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'farmart-addons' ),
				'type'        => 'fmautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_cat',
				'sortable'    => true,
				'condition'   => [
					'cats_source' => 'custom',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				// Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default'   => 'thumbnail',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'item_icon',
			[
				'label'   => esc_html__( 'Icon', 'farmart-addons' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'icon-chevron-right-circle',
					'library' => 'linearicons',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function link_settings_controls() {
		$this->start_controls_section(
			'section_link',
			[ 'label' => esc_html__( 'Link All', 'farmart-addons' ) ]
		);

		$this->add_control(
			'link_all_title',
			[
				'label'       => esc_html__( 'Title', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'This is the title', 'farmart-addons' ),
				'placeholder' => esc_html__( 'Enter your title', 'farmart-addons' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'link_all', [
				'label'         => esc_html__( 'Link', 'farmart-addons' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'farmart-addons' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => true,
					'nofollow'    => true,
				],
			]
		);

		$this->add_control(
			'link_all_icon',
			[
				'label'   => esc_html__( 'Icon', 'farmart-addons' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'icon-chevron-right-circle',
					'library' => 'linearicons',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Section Style
	 */
	protected function section_style() {
		$this->section_content_style();
		$this->section_link_style();
	}

	protected function section_content_style() {
		// Heading Style
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'categories_box_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-categories-grid .cat-item:not(.cat-item--link) .cat-item__inner' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'border_style',
			[
				'label'        => __( 'Border', 'farmart-addons' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'farmart-addons' ),
				'label_on'     => __( 'Custom', 'farmart-addons' ),
				'return_value' => 'yes',
			]
		);
		$this->start_popover();

		$this->add_control(
			'item_border_style',
			[
				'label'     => esc_html__( 'Border Style', 'farmart-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'dotted' => esc_html__( 'Dotted', 'farmart-addons' ),
					'dashed' => esc_html__( 'Dashed', 'farmart-addons' ),
					''  => esc_html__( 'Solid', 'farmart-addons' ),
					'none'   => esc_html__( 'None', 'farmart-addons' ),
				],
				'default'   => '',
				'toggle'    => false,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-categories-grid .cat-item__inner' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_border_width',
			[
				'label'     => esc_html__( 'Border Width', 'farmart-addons' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-categories-grid .cat-item__inner' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'item_border_color',
			[
				'label'     => __( 'Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-product-categories-grid .cat-item__inner' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_popover();


		$this->add_control(
			'border_style_hover',
			[
				'label'        => __( 'Border Hover', 'farmart-addons' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'farmart-addons' ),
				'label_on'     => __( 'Custom', 'farmart-addons' ),
				'return_value' => 'yes',
			]
		);
		$this->start_popover();

		$this->add_control(
			'item_border_style_hover',
			[
				'label'     => esc_html__( 'Border Style', 'farmart-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'dotted' => esc_html__( 'Dotted', 'farmart-addons' ),
					'dashed' => esc_html__( 'Dashed', 'farmart-addons' ),
					''  => esc_html__( 'Solid', 'farmart-addons' ),
					'none'   => esc_html__( 'None', 'farmart-addons' ),
				],
				'default'   => '',
				'toggle'    => false,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-categories-grid .cat-item__inner:hover' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_border_width_hover',
			[
				'label'     => esc_html__( 'Border Width', 'farmart-addons' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-categories-grid .cat-item__inner:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'item_border_color_hover',
			[
				'label'     => __( 'Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-product-categories-grid .cat-item__inner:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_popover();

		// Cat Name
		$this->add_control(
			'cats_items_divider_2',
			[
				'label'     => __( 'Category Name', 'farmart-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'name_spacing',
			[
				'label'      => __( 'Spacing', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [ ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-product-categories-grid .cat-item__inner .cat-name' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'cat_name_typography',
				'selector' => '{{WRAPPER}} .farmart-product-categories-grid .cat-item__inner .cat-name',
			]
		);

		$this->add_control(
			'cat_name_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-categories-grid .cat-item__inner .cat-name' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cats_items_divider_3',
			[
				'label'     => __( 'Category Count', 'farmart-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'cats_count',
			[
				'label'        => __( 'Count', 'farmart-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'farmart-addons' ),
				'label_off'    => __( 'Hide', 'farmart-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'cat_count_typography',
				'selector' => '{{WRAPPER}} .farmart-product-categories-grid .cat-item__inner .cat-count',
			]
		);
		$this->add_control(
			'cat_count_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-categories-grid .cat-item__inner .cat-count' => 'color: {{VALUE}}',
				],
			]
		);

		// Items
		$this->add_control(
			'cats_items_divider',
			[
				'label'     => __( 'Items', 'farmart-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'cats_items_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-product-categories-grid .cat-item__inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'text_spacing',
			[
				'label'      => __( 'Width Text', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [ ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-product-categories-grid .cat-item__inner .cat-text' => 'flex-basis: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this -> end_controls_section();
	}

	protected function section_link_style() {
		$this->start_controls_section(
			'section_link_style',
			[
				'label' => esc_html__( 'Link All', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'categories_box_link_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-product-categories-grid .cat-item--link .cat-item__inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'categories_box_link_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-categories-grid .cat-item--link .cat-item__inner' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'cat_name_typography_box_link',
				'selector' => '{{WRAPPER}} .farmart-product-categories-grid .cat-item--link .link-all--text',
			]
		);

		$this->add_control(
			'cat_name_color_box_link',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-categories-grid .cat-item--link .link-all--text' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'icon_font_size_box_link',
			[
				'label'      => esc_html__( 'Icon size', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}}  .farmart-product-categories-grid .cat-item--link .link-all--text .farmart-svg-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'icon_right_spacing_box_link',
			[
				'label'      => esc_html__( 'Icon Spacing', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}}  .farmart-product-categories-grid .cat-item--link .link-all--text .farmart-svg-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this -> end_controls_section();
	}

	/**
	 * Render icon box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$this->add_render_attribute(
			'wrapper', 'class', [
				'farmart-product-categories-grid woocommerce',
			]
		);

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div class="categories-box row-flex">
				<?php $this->get_categories_content( $settings ); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Get Categories
	 */
	protected function get_categories_content( $settings ) {
		$source = $settings['cats_source'];

		$term_args = [
			'taxonomy' => 'product_cat',
		];

		if ( $source == 'default' ) {
			$display = $settings['cats_display'];
			$parent  = '';
			if ( $display == 'parent' ) {
				$parent = 0;
			}

			$term_args['orderby'] = $settings['cats_orderby'];
			$term_args['order']   = $settings['cats_order'];
			$term_args['number']  = $settings['cats_number'];
			$term_args['parent']  = $parent;

		} else {
			$cats                 = explode( ',', $settings['cats_selected'] );
			$term_args['slug']    = $cats;
			$term_args['orderby'] = 'slug__in';
		}

		$terms = get_terms( $term_args );

		$output  = [];
		$i      = 0;

		if ( ! is_wp_error( $terms ) && $terms ) {

			foreach ( $terms as $term ) {

				$thumbnail_id = absint( get_term_meta( $term->term_id, 'thumbnail_id', true ) );

				$settings['image']['url'] = wp_get_attachment_image_src( $thumbnail_id );
				$settings['image']['id']  = $thumbnail_id;

				$image = Group_Control_Image_Size::get_attachment_image_html( $settings );

				$thumbnail_html = $thumbnail_id ? '<div class="cat-thumb">' . $image . '</div>' : '';
				$count          = '';

				if ( $settings['cats_count'] == 'yes' ) {
					$count = '<div class="cat-count">';
					$count .= sprintf( _n( '%s Item', '%s Items', $term->count, 'farmart-addons' ), number_format_i18n( $term->count ) );
					$count .= '</div>';
				}

				if ( $settings['item_icon'] ) {
					if ( $settings['item_icon'] && ! empty( $settings['item_icon']['value'] ) && \Elementor\Icons_Manager::is_migration_allowed() ) {
						ob_start();
						\Elementor\Icons_Manager::render_icon( $settings['item_icon'], [ 'aria-hidden' => 'true' ] );
						$icon = '<span class="farmart-svg-icon">' . ob_get_clean() . '</span>';
					}
				}

				if( empty( $icon ) ) {
					$icon = '<span class="farmart-svg-icon"><svg viewBox="0 0 32 32"><path d="M8 32c-0.205 0-0.409-0.078-0.566-0.234-0.312-0.312-0.312-0.819 0-1.131l13.834-13.834-13.834-13.834c-0.312-0.312-0.312-0.819 0-1.131s0.819-0.312 1.131 0l14.4 14.4c0.312 0.312 0.312 0.819 0 1.131l-14.4 14.4c-0.156 0.156-0.361 0.234-0.566 0.234z"></path></svg></span>';
				}

				$output[] = sprintf(
					'<div class="cat-item">
						<div class="cat-item__inner">
							<div class="cat-text">
								<div class="cat-text--inner">
									<h4 class="cat-name">%s</h4>
									%s
								</div>
								%s
							</div>
							%s
							<a href="%s"></a>
						</div>
					</div>',
					esc_html( $term->name ),
					$count,
					$icon,
					$thumbnail_html,
					esc_url( get_term_link( $term->term_id, 'product_cat' ) )
				);

			}

			$link_all_icon ='';
			if ( $settings['link_all_icon'] && ! empty( $settings['link_all_icon']['value'] ) && \Elementor\Icons_Manager::is_migration_allowed() ) {
				ob_start();
				\Elementor\Icons_Manager::render_icon( $settings['link_all_icon'], [ 'aria-hidden' => 'true' ] );
				$link_all_icon = '<span class="farmart-svg-icon">' . ob_get_clean() . '</span>';
			}

			if ( $settings['link_all_title'] ) {
				$link_title = '<h4 class="link-all--text">' . $settings['link_all_title'] . $link_all_icon . '</h4>';
				$link_html = $this->get_link_control( 'link', $settings['link_all'], '', [ 'class' => 'link-all' ] );
				$output[] = sprintf(
					'<div class="cat-item cat-item--link ">
					<div class="cat-item__inner">
						%s
						%s
					</div>
				</div>',
					$link_html,$link_title
				);
			}

		}

		echo implode( '', $output );
	}

	/**
	 * Render link control output
	 *
	 * @param       $link_key
	 * @param       $url
	 * @param       $content
	 * @param array $attr
	 *
	 * @return string
	 */
	protected function get_link_control( $link_key, $url, $content, $attr = [] ) {
		$attr_default = [
			'href' => $url['url'] ? $url['url'] : '#',
		];

		if ( $url['is_external'] ) {
			$attr_default['target'] = '_blank';
		}

		if ( $url['nofollow'] ) {
			$attr_default['rel'] = 'nofollow';
		}

		$attr = wp_parse_args( $attr, $attr_default );

		$this->add_render_attribute( $link_key, $attr );

		return sprintf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( $link_key ), $content );
	}
}