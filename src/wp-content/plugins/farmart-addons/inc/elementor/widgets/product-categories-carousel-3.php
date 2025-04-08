<?php

namespace FarmartAddons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use FarmartAddons\Elementor;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Mutil Categories widget
 */
class Product_Categories_Carousel_3 extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'farmart-product-mutil-categories-carousel';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Farmart - Product Categories Carousel 3', 'farmart-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-post-slider';
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
		$this->_register_carousel_settings_controls();
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
				'default'     => esc_html__( 'Best-Selling Categories', 'farmart-addons' ),
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
					'value'   => 'icon-chart-bars',
					'library' => 'linearicons',
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
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .cat-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'heading_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .cat-header' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'heading_border',
				'label'    => __( 'Border', 'farmart-addons' ),
				'selector' => '{{WRAPPER}} .farmart-product-mutil-categories-carousel .cat-header',
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
				'selector' => '{{WRAPPER}} .farmart-product-mutil-categories-carousel .cat-header h3',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .cat-header h3' => 'color: {{VALUE}};',
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
					'{{WRAPPER}}   .farmart-product-mutil-categories-carousel .cat-header h3 .farmart-svg-icon' => 'color: {{VALUE}}',
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
					'{{WRAPPER}}  .farmart-product-mutil-categories-carousel .cat-header h3 .farmart-svg-icon' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}}  .farmart-product-mutil-categories-carousel .cat-header h3 .farmart-svg-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .farmart-product-mutil-categories-carousel .cat-header .header-link',
			]
		);

		$this->add_control(
			'link_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .cat-header .header-link span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'link_color_hover',
			[
				'label'     => __( 'Hover Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .cat-header .header-link:hover .link-text'    => 'color: {{VALUE}}; text-shadow: 0 0 {{VALUE}};',
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .cat-header .header-link:hover .farmart-svg-icon' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .cat-header .header-link .farmart-svg-icon'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .cat-header .header-link .farmart-svg-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .cat-header .header-link .farmart-svg-icon' => 'padding-left: {{SIZE}}{{UNIT}};',
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
			'cats_parent_divider',
			[
				'label' => __( 'Parent Categories', 'farmart-addons' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'cats_number',
			[
				'label'   => esc_html__( 'Categories to show', 'farmart-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 5,
			]
		);
		$this->add_control(
			'cats_orderby',
			[
				'label'       => esc_html__( 'Order by', 'farmart-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'name'       => esc_html__( 'Name', 'farmart-addons' ),
					'id'         => esc_html__( 'ID', 'farmart-addons' ),
					'count'      => esc_html__( 'Count', 'farmart-addons' ),
					'menu_order' => esc_html__( 'Menu Order', 'farmart-addons' ),
				],
				'default'     => 'name',
				'label_block' => false,
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
				'default'     => 'ASC',
				'label_block' => false,
			]
		);

		$this->add_control(
			'cats_child_divider',
			[
				'label'     => __( 'Child Categories', 'farmart-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'cats_child_number',
			[
				'label'       => esc_html__( 'Categories to show', 'farmart-addons' ),
				'description' => esc_html__( 'Set 0 to remove children categories', 'farmart-addons' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 5,
			]
		);
		$this->add_control(
			'cats_child_orderby',
			[
				'label'       => esc_html__( 'Order by', 'farmart-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'name'       => esc_html__( 'Name', 'farmart-addons' ),
					'id'         => esc_html__( 'ID', 'farmart-addons' ),
					'count'      => esc_html__( 'Count', 'farmart-addons' ),
					'menu_order' => esc_html__( 'Menu Order', 'farmart-addons' ),
				],
				'default'     => 'name',
				'label_block' => false,
			]
		);

		$this->add_control(
			'cats_child_order',
			[
				'label'       => esc_html__( 'Order', 'farmart-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'ASC'  => esc_html__( 'ASC', 'farmart-addons' ),
					'DESC' => esc_html__( 'DESC', 'farmart-addons' ),
				],
				'default'     => 'ASC',
				'label_block' => false,
			]
		);

		$this->add_control(
			'cats_link_divider',
			[
				'label'     => __( 'Links', 'farmart-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'link_text_all',
			[
				'label'       => esc_html__( 'Link Text', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'View all ', 'farmart-addons' ),
				'label_block' => true,
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'link_icon_all',
			[
				'label'   => esc_html__( 'Icon', 'farmart-addons' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'icon-chevron-right',
					'library' => 'linearicons',
				],
			]
		);

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
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .categories-box' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'categories_box_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .categories-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .categories-box .box-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'cat_item_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .categories-box .box-item.slick-active:not(.slick-current)' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel.view-grid .categories-box .box-item'                        => 'border-color: {{VALUE}}',
				],
			]
		);

		// item
		$this->add_control(
			'cats_items_divider_3',
			[
				'label'     => __( 'Inside Items', 'farmart-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->start_controls_tabs(
			'element_style_tabs'
		);

		$this->start_controls_tab(
			'element_top_style_tab',
			[
				'label' => __( 'Top Cat', 'farmart-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'el_top_cat_name_typography',
				'selector' => '{{WRAPPER}} .farmart-product-mutil-categories-carousel .product-cats li:first-child .cat-name',
			]
		);

		$this->add_responsive_control(
			'el_top_spacing',
			[
				'label'      => __( 'Item Spacing', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [],
				'selectors'  => [
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .product-cats li:first-child' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'el_top_img_spacing',
			[
				'label'      => __( 'Image Spacing', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [],
				'selectors'  => [
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .product-cats li:first-child .cat-thumb' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'element_other_style_tab',
			[
				'label' => __( 'Other Cat', 'farmart-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'el_other_cat_name_typography',
				'selector' => '{{WRAPPER}} .farmart-product-mutil-categories-carousel .product-cats li:not(:first-child) .cat-name',
			]
		);

		$this->add_responsive_control(
			'el_other_name_spacing',
			[
				'label'      => __( 'Name Spacing', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [],
				'selectors'  => [
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .product-cats li:not(:first-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'cats_items_divider_2',
			[
				'label'     => __( 'Category Name', 'farmart-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
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
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .box-item .cat-name' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .product-cats li:hover .cat-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'cats_items_divider_4',
			[
				'label'     => __( 'Link all', 'farmart-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'link_all__spacing',
			[
				'label'      => __( 'Spacing', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [],
				'selectors'  => [
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .categories-box .cat-all' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'link_all_typography',
				'selector' => '{{WRAPPER}} .farmart-product-mutil-categories-carousel .categories-box .cat-all',
			]
		);

		$this->add_control(
			'link_all_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .categories-box .cat-all' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'link_all_color_hover',
			[
				'label'     => __( 'Hover Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .categories-box .cat-all:hover .link-text'    => 'color: {{VALUE}}',
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .categories-box .cat-all:hover .farmart-svg-icon' => 'color: {{VALUE}}',
				],
			]
		);

		// Icon
		$this->add_control(
			'link_all_icon_style',
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
			'link_all_icon_font_size',
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
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .categories-box .cat-all .farmart-svg-icon'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .categories-box .cat-all .farmart-svg-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_responsive_control(
			'link_all_icon_spacing',
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
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .categories-box .cat-all .farmart-svg-icon' => 'padding-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_popover();

		$this->end_controls_section(); // End Cats Style
	}

	protected function _register_carousel_settings_controls() {
		// Carousel Settings
		$this->start_controls_section(
			'carousel_settings',
			[
				'label' => esc_html__( 'Carousel Settings', 'farmart-addons' ),
			]
		);
		$this->add_responsive_control(
			'slidesToShow',
			[
				'label'   => esc_html__( 'Slides to show', 'farmart-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 10,
				'default' => 4,
			]
		);
		$this->add_responsive_control(
			'slidesToScroll',
			[
				'label'   => esc_html__( 'Slides to scroll', 'farmart-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 10,
				'default' => 1,
			]
		);
		$this->add_responsive_control(
			'navigation',
			[
				'label'   => esc_html__( 'Navigation', 'farmart-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'both'   => esc_html__( 'Arrows and Dots', 'farmart-addons' ),
					'arrows' => esc_html__( 'Arrows', 'farmart-addons' ),
					'dots'   => esc_html__( 'Dots', 'farmart-addons' ),
					'none'   => esc_html__( 'None', 'farmart-addons' ),
				],
				'default' => 'arrows',
				'toggle'  => false,
			]
		);

		$this->add_control(
			'infinite',
			[
				'label'     => __( 'Infinite Loop', 'farmart-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'farmart-addons' ),
				'label_on'  => __( 'On', 'farmart-addons' ),
				'default'   => 'yes'
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'     => __( 'Autoplay', 'farmart-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'farmart-addons' ),
				'label_on'  => __( 'On', 'farmart-addons' ),
				'default'   => 'yes'
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'   => __( 'Autoplay Speed (in ms)', 'farmart-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3000,
				'min'     => 100,
				'step'    => 100,
			]
		);

		$this->add_control(
			'speed',
			[
				'label'       => __( 'Speed', 'farmart-addons' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 800,
				'min'         => 100,
				'step'        => 100,
				'description' => esc_html__( 'Slide animation speed (in ms)', 'farmart-addons' ),
			]
		);

		// Additional Settings
		$this->_register_responsive_settings_controls();

		$this->end_controls_section(); // End Carousel Settings

		// Carousel Style
		$this->start_controls_section(
			'carousel_style',
			[
				'label' => esc_html__( 'Carousel Settings', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'carousel_style_divider',
			[
				'label' => __( 'Arrows', 'farmart-addons' ),
				'type'  => Controls_Manager::HEADING,
			]
		);
		$this->add_control(
			'arrows_style',
			[
				'label'        => __( 'Options', 'farmart-addons' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'farmart-addons' ),
				'label_on'     => __( 'Custom', 'farmart-addons' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		$this->add_control(
			'arrows_size',
			[
				'label'     => __( 'Size', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 150,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .categories-box .slick-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'arrows_width',
			[
				'label'      => __( 'Width', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'max' => 500,
						'min' => 0,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .categories-box .slick-arrow' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'arrows_height',
			[
				'label'      => __( 'Height', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'max' => 500,
						'min' => 0,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .categories-box .slick-arrow' => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'arrows_offset',
			[
				'label'     => esc_html__( 'Horizontal Offset', 'farmart-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'step'      => 1,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .categories-box .slick-prev-arrow' => 'left: {{VALUE}}px;',
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .categories-box .slick-next-arrow' => 'right: {{VALUE}}px;',
				],
			]
		);

		$this->end_popover();

		$this->start_controls_tabs( 'products_normal_settings' );

		$this->start_controls_tab( 'products_normal', [ 'label' => esc_html__( 'Normal', 'farmart-addons' ) ] );

		$this->add_control(
			'arrows_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .categories-box .slick-arrow' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'arrows_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .categories-box .slick-arrow' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'arrows_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .categories-box .slick-arrow' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'products_hover', [ 'label' => esc_html__( 'Hover', 'farmart-addons' ) ] );

		$this->add_control(
			'arrows_hover_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .categories-box .slick-arrow:hover' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'arrows_hover_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .categories-box .slick-arrow:hover' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'arrows_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .categories-box .slick-arrow:hover' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'carousel_style_divider_2',
			[
				'label'     => __( 'Dots', 'farmart-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'dots_style',
			[
				'label'        => __( 'Options', 'farmart-addons' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'farmart-addons' ),
				'label_on'     => __( 'Custom', 'farmart-addons' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		$this->add_control(
			'dots_gap',
			[
				'label'     => __( 'Gap', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .categories-box .slick-dots li' => 'margin: 0 {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'dots_size',
			[
				'label'     => __( 'Size', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 30,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .categories-box .slick-dots li button'        => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .categories-box .slick-dots li button:before' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'dots_offset',
			[
				'label'     => esc_html__( 'Vertical Offset', 'farmart-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'step'      => 1,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .categories-box .slick-dots' => 'bottom: {{VALUE}}px;',
				],
			]
		);
		$this->add_control(
			'dots_bg_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .categories-box .slick-dots li button:before' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'dots_active_bg_color',
			[
				'label'     => esc_html__( 'Active Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .categories-box .slick-dots li.slick-active button:before' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .farmart-product-mutil-categories-carousel .categories-box .slick-dots li button:hover:before'        => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_popover();
		$this->end_controls_section(); // End Carousel Style
	}

	protected function _register_responsive_settings_controls() {
		$this->add_control(
			'responsive_settings_divider',
			[
				'label'     => __( 'Additional Settings', 'farmart-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'responsive_breakpoint', [
				'label'       => __( 'Breakpoint', 'farmart-addons' ) . ' (px)',
				'description' => __( 'Below this breakpoint the options below will be triggered', 'farmart-addons' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 1200,
				'min'         => 320,
				'max'         => 1920,
			]
		);
		$repeater->add_control(
			'responsive_slidesToShow',
			[
				'label'   => esc_html__( 'Slides to show', 'farmart-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 7,
				'default' => 1,
			]
		);
		$repeater->add_control(
			'responsive_slidesToScroll',
			[
				'label'   => esc_html__( 'Slides to scroll', 'farmart-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 7,
				'default' => 1,
			]
		);
		$repeater->add_control(
			'responsive_navigation',
			[
				'label'   => esc_html__( 'Navigation', 'farmart-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'both'   => esc_html__( 'Arrows and Dots', 'farmart-addons' ),
					'arrows' => esc_html__( 'Arrows', 'farmart-addons' ),
					'dots'   => esc_html__( 'Dots', 'farmart-addons' ),
					'none'   => esc_html__( 'None', 'farmart-addons' ),
				],
				'default' => 'dots',
				'toggle'  => false,
			]
		);

		$this->add_control(
			'carousel_responsive_settings',
			[
				'label'         => __( 'Settings', 'farmart-addons' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [

				],
				'title_field'   => '{{{ responsive_breakpoint }}}' . 'px',
				'prevent_empty' => false,
			]
		);
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
				'farmart-product-mutil-categories-carousel woocommerce',
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
				$icon = '<span class="farmart-svg-icon">' . ob_get_clean() . '</span>';
			}
		}

		if( empty( $icon ) ) {
			$icon = '<span class="farmart-svg-icon"><svg viewBox="0 0 32 32"><path d="M8 32c-0.205 0-0.409-0.078-0.566-0.234-0.312-0.312-0.312-0.819 0-1.131l13.834-13.834-13.834-13.834c-0.312-0.312-0.312-0.819 0-1.131s0.819-0.312 1.131 0l14.4 14.4c0.312 0.312 0.312 0.819 0 1.131l-14.4 14.4c-0.156 0.156-0.361 0.234-0.566 0.234z"></path></svg></span>';
		}

		if ( $settings['link_text'] ) {
			$text = '<span class="link-text">' . $settings['link_text'] . '</span>' . $icon;
			$link = $this->get_link_control( 'header_link', $settings['link'], $text, [ 'class' => 'header-link' ] );
		}

		$this->add_render_attribute(
			'wrapper', 'data-show', [
				intval( $settings['slidesToShow'] )
			]
		);

		$outputs = [];

		$term_args = [
			'taxonomy'   => 'product_cat',
			'hide_empty' => 1,
			'number'     => $settings['cats_number'],
			'orderby'    => $settings['cats_orderby'],
			'order'      => $settings['cats_order'],
		];

		$parent = 0;
		if ( function_exists( 'is_product_category' ) && is_product_category() ) {
			global $wp_query;
			$current_cat = $wp_query->get_queried_object();
			if ( $current_cat ) {
				$parent = $current_cat->term_id;
			}
		}

		$term_args['parent'] = $parent;

		$terms = get_terms( $term_args );

		foreach ( $terms as $term ) {
			$term_list = array();
			if ( $settings['cats_child_number'] ) {
				$atts        = array(
					'taxonomy'   => 'product_cat',
					'hide_empty' => 1,
					'number'     => $settings['cats_child_number'],
					'orderby'    => $settings['cats_child_orderby'],
					'order'      => $settings['cats_child_order'],
					'parent'     => $term->term_id,
				);
				$child_terms = get_terms( $atts );
				if ( $child_terms ) {
					foreach ( $child_terms as $child ) {
						$term_list[] = sprintf(
							'<li class="cat-item"><a href="%s"><span class="cat-name">%s</span></a></li>',
							get_term_link( $child->term_id, 'product_cat' ),
							$child->name
						);
					}
				}
			}

			$thumbnail_id             = absint( get_term_meta( $term->term_id, 'thumbnail_id', true ) );
			$settings['image']['url'] = wp_get_attachment_image_src( $thumbnail_id );
			$settings['image']['id']  = $thumbnail_id;

			$image = Group_Control_Image_Size::get_attachment_image_html( $settings );

			$thumbnail_html = $thumbnail_id ? '<span class="cat-thumb">' . $image . '</span>' : '';

			if ( $settings['link_icon_all'] ) {
				if ( $settings['link_icon_all'] && ! empty( $settings['link_icon_all']['value'] ) && \Elementor\Icons_Manager::is_migration_allowed() ) {
					ob_start();
					\Elementor\Icons_Manager::render_icon( $settings['link_icon_all'], [ 'aria-hidden' => 'true' ] );
					$icon_all = '<span class="farmart-svg-icon">' . ob_get_clean() . '</span>';
				}
			}

			if ( $settings['link_text_all'] ) {
				$text_all = '<span class="link-text">' . $settings['link_text_all'] . '</span>' . $icon_all;
				$link_view_all = '<a class="cat-all" href="'.esc_url(get_term_link( $term->term_id, 'product_cat' )).'">'.$text_all.'</a>';
			}

			$outputs[] = sprintf(
				'<div class="box-item">
					<ul class="product-cats">
						<li class="cat-item">
						<a href="%s">
						%s
						<div class="cat-name">%s</div>
						</a>
						</li>
						%s
					</ul>
					%s
					</div>',
				esc_url( get_term_link( $term->term_id, 'product_cat' ) ),
				$thumbnail_html,
				esc_html( $term->name ),
				implode( ' ', $term_list ),
				$link_view_all
			);
		}


		$header_html = $title != '' ? sprintf( '<div class="cat-header">%s %s</div>', $title, $link ) : '';

		$this->add_render_attribute( 'slick', 'class', [ 'categories-box' ] );
		$this->add_render_attribute( 'slick', 'data-slick', wp_json_encode( Elementor::get_data_slick( $settings ) ) );

		$categories_box_html = sprintf( '<div %s>%s</div>', $this->get_render_attribute_string( 'slick' ), implode( '', $outputs ) );

		echo sprintf(
			'<div %s>%s%s</div>',
			$this->get_render_attribute_string( 'wrapper' ),
			$header_html, $categories_box_html
		);
	}

	/**
	 * Get Categories
	 */
	protected function get_categories_content( $settings ) {


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