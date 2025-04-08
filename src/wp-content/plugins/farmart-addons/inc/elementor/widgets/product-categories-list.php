<?php

namespace FarmartAddons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon Box widget
 */
class Product_Categories_List extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'farmart-product-categories-list';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Farmart - Product Categories List', 'farmart-addons' );
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
		$this->_register_heading_settings_controls();
		$this->_register_categories_settings_controls();
	}

	protected function _register_heading_settings_controls() {
		// Heading Content
		$this->start_controls_section(
			'heading_content',
			[ 'label' => esc_html__( 'Heading', 'farmart-addons' ) ]
		);

		$this->start_controls_tabs(
			'heading_tabs'
		);

		$this->start_controls_tab(
			'title_tab',
			[
				'label' => __( 'Title', 'farmart-addons' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'This is the title', 'farmart-addons' ),
				'placeholder' => esc_html__( 'Enter your title', 'farmart-addons' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'title_icon',
			[
				'label'   => esc_html__( 'Icon', 'farmart-addons' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => '',
					'library' => 'fa-solid',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'link_tab',
			[
				'label' => __( 'Link', 'farmart-addons' ),
			]
		);

		$this->add_control(
			'link_text',
			[
				'label'       => esc_html__( 'Link Text', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'See all', 'farmart-addons' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'link', [
				'label'         => esc_html__( 'Link', 'farmart-addons' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'farmart-addons' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$this->add_control(
			'link_icon',
			[
				'label'   => esc_html__( 'Icon', 'farmart-addons' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'icon-chevron-right',
					'library' => 'linearicons',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section(); // End Heading Content

		// Heading Style
		$this->start_controls_section(
			'heading_style',
			[
				'label' => esc_html__( 'Heading', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'heading_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-product-categories-list .cat-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'heading_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-categories-list .cat-header' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'heading_border',
				'label'    => __( 'Border', 'farmart-addons' ),
				'selector' => '{{WRAPPER}} .farmart-product-categories-list .cat-header',
			]
		);

		$this->start_controls_tabs( 'heading_style_tabs', [ 'separator' => 'before', ] );

		$this->start_controls_tab(
			'heading_title_style_tab',
			[
				'label' => __( 'Title', 'farmart-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .farmart-product-categories-list .cat-header h3',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-categories-list .cat-header h3' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'title_icon_style',
			[
				'label'        => __( 'Icon', 'farmart-addons' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'farmart-addons' ),
				'label_on'     => __( 'Custom', 'farmart-addons' ),
				'return_value' => 'yes',
			]
		);
		$this->start_popover();

		$this->add_control(
			'title_icon_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}   .farmart-product-categories-list .cat-header h3 .farmart-svg-icon' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'title_icon_font_size',
			[
				'label'      => esc_html__( 'Font size', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}}  .farmart-product-categories-list .cat-header h3 .farmart-svg-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'title_icon_right_spacing',
			[
				'label'      => esc_html__( 'Right Spacing', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}}  .farmart-product-categories-list .cat-header h3 .farmart-svg-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'heading_link_style_tab',
			[
				'label' => __( 'Link', 'farmart-addons' ),
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'link_typography',
				'selector' => '{{WRAPPER}} .farmart-product-categories-list .cat-header .header-link',
			]
		);

		$this->add_control(
			'link_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-categories-list .cat-header .header-link span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'link_color_hover',
			[
				'label'     => __( 'Hover Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-categories-list .cat-header .header-link:hover .link-text'    => 'color: {{VALUE}}; text-shadow: 0 0 {{VALUE}};',
					'{{WRAPPER}} .farmart-product-categories-list .cat-header .header-link:hover .farmart-svg-icon' => 'color: {{VALUE}};',
				],
			]
		);

		// Icon
		$this->add_control(
			'icon_style',
			[
				'label'        => __( 'Icon', 'farmart-addons' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'farmart-addons' ),
				'label_on'     => __( 'Custom', 'farmart-addons' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'icon_font_size',
			[
				'label'     => __( 'Font Size', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-product-categories-list .cat-header .header-link .farmart-svg-icon'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .farmart-product-categories-list .cat-header .header-link .farmart-svg-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_responsive_control(
			'icon_spacing',
			[
				'label'     => __( 'Spacing', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 20,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-product-categories-list .cat-header .header-link .farmart-svg-icon' => 'padding-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_popover();

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section(); // End Heading Style
	}

	protected function _register_categories_settings_controls() {

		// Cats Content
		$this->start_controls_section(
			'cats_content',
			[
				'label' => esc_html__( 'Categories', 'farmart-addons' ),
			]
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
				'default'     => 9,
				'condition'   => [
					'cats_source' => 'default',
				],
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

		$this->start_controls_tabs('content_subtext',[ 'separator' => 'before']);

		$this->start_controls_tab(
			'content_size_big',
			[
				'label'         => esc_html__( 'First element', 'farmart-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				// Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default'   => 'thumbnail',
				'separator' => 'none',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'content_size_list',
			[
				'label'         => esc_html__( 'Other element', 'farmart-addons' ),
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image_list',
				// Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default'   => 'thumnail',
				'separator' => 'none',
			]
		);
		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->end_controls_section(); // End Cats Content

		// Cats Style
		$this->start_controls_section(
			'cats_style',
			[
				'label' => esc_html__( 'Categories', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'cats_box_divider',
			[
				'label' => __( 'Categories Box', 'farmart-addons' ),
				'type'  => Controls_Manager::HEADING,
			]
		);
		$this->add_control(
			'categories_box_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-categories-list .product-cats' => 'background-color: {{VALUE}}',
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
					'{{WRAPPER}} .farmart-product-categories-list .product-cats' => 'border-style: {{VALUE}};',
					'{{WRAPPER}} .farmart-product-categories-list .product-cats li' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_border_width',
			[
				'label'     => esc_html__( 'Border Width', 'farmart-addons' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-categories-list .product-cats' => 'border-width: {{TOP}}{{UNIT}} 0 0 {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .farmart-product-categories-list .product-cats li' => 'border-width: 0 {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} 0;',
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
					'{{WRAPPER}} .farmart-product-categories-list .product-cats' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .farmart-product-categories-list .product-cats li' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .farmart-product-categories-list .product-cats li:hover:before' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_border_width_hover',
			[
				'label'     => esc_html__( 'Border Width', 'farmart-addons' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-categories-list .product-cats li:hover:before' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .farmart-product-categories-list .product-cats li:hover:before' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .farmart-product-categories-list .product-cats .cat-name' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'cat_name_typography',
				'selector' => '{{WRAPPER}} .farmart-product-categories-list .product-cats .cat-text .cat-name',
			]
		);
		$this->start_controls_tabs(
			'cat_name_style_tabs'
		);

		$this->start_controls_tab(
			'cat_name_normal_style_tab',
			[
				'label' => __( 'Normal', 'farmart-addons' ),
			]
		);

		$this->add_control(
			'cat_name_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-categories-list .product-cats .cat-text .cat-name' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'cat_name_hover_style_tab',
			[
				'label' => __( 'Hover', 'farmart-addons' ),
			]
		);

		$this->add_control(
			'cat_name_hover_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-categories-list .product-cats a:hover .cat-name' => 'color: {{VALUE}}; box-shadow: inset 0 0 0 transparent, inset 0 -1px 0 {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

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
				'selector' => '{{WRAPPER}} .farmart-product-categories-list .product-cats .cat-text .cat-count',
			]
		);
		$this->add_control(
			'cat_count_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-categories-list .product-cats .cat-text .cat-count' => 'color: {{VALUE}}',
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

		$this->start_controls_tabs( 'item_style_tabs' );

		$this->start_controls_tab(
			'item_big_style',
			[
				'label' => __( 'First element', 'farmart-addons' ),
			]
		);

		$this->add_responsive_control(
			'first_els_width',
			[
				'label'      => __( 'Width', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'default'    => [ ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-product-categories-list .product-cats--big' => 'flex-basis: {{SIZE}}%;',
				],
			]
		);

		$this->add_responsive_control(
			'cats_items_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-product-categories-list .product-cats--big .cat-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'img_spacing',
			[
				'label'      => __( 'Image spacing', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [ ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-product-categories-list .product-cats--big .cat-thumb' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'item_list_style',
			[
				'label' => __( 'Other element', 'farmart-addons' ),
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
				'default'      => '4',
				'toggle'       => false,
				'prefix_class' => 'columns-%s',
			]
		);

		$this->add_responsive_control(
			'img_width',
			[
				'label'      => __( 'Image Width', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [ ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-product-categories-list .product-cats--lists .cat-item .cat-thumb' => 'flex-basis: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'cats_items_other_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-product-categories-list .product-cats--lists .cat-item > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'list_img_spacing',
			[
				'label'      => __( 'Image spacing', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [ ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-product-categories-list .product-cats--lists .cat-thumb' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();


		$this->end_controls_section(); // End Cats Style
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
				'farmart-product-categories-list woocommerce',
			]
		);

		$title = $link = $icon = $title_icon = '';

		if ( $settings['title_icon'] && ! empty( $settings['title_icon']['value'] ) && \Elementor\Icons_Manager::is_migration_allowed() ) {
			ob_start();
			\Elementor\Icons_Manager::render_icon( $settings['title_icon'], [ 'aria-hidden' => 'true' ] );
			$title_icon = '<span class="farmart-svg-icon">' . ob_get_clean() . '</span>';
		}

		if ( $settings['title'] ) {
			$title = '<h3>' . $title_icon . $settings['title'] . '</h3>';
		}

		if ( $settings['link_icon'] ) {
			if ( $settings['link_icon'] && ! empty( $settings['link_icon']['value'] ) && \Elementor\Icons_Manager::is_migration_allowed() ) {
				ob_start();
				\Elementor\Icons_Manager::render_icon( $settings['link_icon'], [ 'aria-hidden' => 'true' ] );
				$icon_svg = ob_get_clean();
				if( $icon_svg ) {
					$icon = '<span class="farmart-svg-icon">' . $icon_svg . '</span>';
				}
			}

			if( empty( $icon ) ) {
				$icon = '<span class="farmart-svg-icon"><svg viewBox="0 0 32 32"><path d="M8 32c-0.205 0-0.409-0.078-0.566-0.234-0.312-0.312-0.312-0.819 0-1.131l13.834-13.834-13.834-13.834c-0.312-0.312-0.312-0.819 0-1.131s0.819-0.312 1.131 0l14.4 14.4c0.312 0.312 0.312 0.819 0 1.131l-14.4 14.4c-0.156 0.156-0.361 0.234-0.566 0.234z"></path></svg></span>';
			}
		}

		if ( $settings['link_text'] ) {
			$text = '<span class="link-text">' . $settings['link_text'] . '</span>' . $icon;
			$link = $this->get_link_control( 'header_link', $settings['link'], $text, [ 'class' => 'header-link' ] );
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div class="cat-header">
				<?php echo $title . $link; ?>
			</div>
			<div class="categories-box">
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

		$output = $item_big = $item_list = [];
		$i      = 0;

		if ( ! is_wp_error( $terms ) && $terms ) {

			$output[] = '<div class="product-cats">';

			foreach ( $terms as $term ) {

				$thumbnail_id = absint( get_term_meta( $term->term_id, 'thumbnail_id', true ) );

				$settings['image']['url'] = wp_get_attachment_image_src( $thumbnail_id );
				$settings['image']['id']  = $thumbnail_id;

				if ( $i != 0 ) {
					$settings['image_size']   = $settings['image_list_size'];

					if ( $settings['image_list_size'] == 'custom' ) {
						$settings['image_custom_dimension']['width']  = $settings['image_list_custom_dimension']['width'];
						$settings['image_custom_dimension']['height'] = $settings['image_list_custom_dimension']['height'];
					}
				}
				$image = Group_Control_Image_Size::get_attachment_image_html( $settings );

				$thumbnail_html = $thumbnail_id ? '<div class="cat-thumb">' . $image . '</div>' : '';
				$count          = '';

				if ( $settings['cats_count'] == 'yes' ) {
					$count = '<div class="cat-count">';
					$count .= sprintf( _n( '%s Item', '%s Items', $term->count, 'farmart-addons' ), number_format_i18n( $term->count ) );
					$count .= '</div>';
				}

				$item = sprintf(
					'<div class="cat-item">
						<a href="%s">
							%s
							<div class="cat-text">
								<div class="cat-name">%s</div>
								%s
							</div>
						</a>
					</div>',
					esc_url( get_term_link( $term->term_id, 'product_cat' ) ),
					$thumbnail_html,
					esc_html( $term->name ),
					$count
				);

				if ( $i == 0 ) {
					$item_big[] = $item;
				} else {
					$item_list[] = $item;
				}

				$i ++;
			}
			$output[] = sprintf( '<div class="product-cats--big">%s</div>', implode( '', $item_big ) );
			$output[] = sprintf( '<div class="product-cats--lists">%s</div>', implode( '', $item_list ) );

			$output[] = '</div>';


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