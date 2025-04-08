<?php

namespace FarmartAddons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use FarmartAddons\Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon Box widget
 */
class Product_Deals_Grid extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'fm-product-deals-grid';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Product Deals Grid', 'farmart-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-tabs';
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

		// Content
		$this->register_heading_settings_controls();
		$this->register_product_settings_controls();
		$this->register_pagination_settings_controls();

		// Style
		$this->register_heading_style_controls();
		$this->register_products_style_controls();
	}

	/**
	 * Register the widget content controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_heading_settings_controls() {
		$this->start_controls_section(
			'section_heading',
			[ 'label' => esc_html__( 'Heading', 'farmart-addons' ) ]
		);

		$this->start_controls_tabs( 'deals_heading_settings' );

		// Title
		$this->start_controls_tab( 'tab_title', [ 'label' => esc_html__( 'Title', 'farmart-addons' ) ] );
		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Flash Deals', 'farmart-addons' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'icon',
			[
				'label'   => esc_html__( 'Icon', 'farmart-addons' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'icon-power',
					'library' => 'linearicons',
				],
			]
		);

		$this->end_controls_tab();

		// Countdown
		$this->start_controls_tab( 'countdown', [ 'label' => esc_html__( 'Countdown', 'farmart-addons' ) ] );

		$this->add_control(
			'ends_in',
			[
				'label'       => esc_html__( 'Ends In Text', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Ends in', 'farmart-addons' ),
				'label_block' => true,
			]
		);

		$this->end_controls_tab();

		// Product Tabs
		$this->start_controls_tab(
			'tab_product_tabs',
			[
				'label' => esc_html__( 'Product Grid', 'farmart-addons' ),
			]
		);

		$product_cats = Elementor::get_taxonomy();
		$repeater     = new \Elementor\Repeater();

		$repeater->add_control(
			'product_cat', [
				'label'       => esc_html__( 'Category Grid', 'farmart-addons' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => $product_cats,
				'label_block' => true,
			]
		);

		$this->add_control(
			'product_cats_tabs',
			[
				'label'         => esc_html__( 'Category Grid', 'farmart-addons' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [ ],
				'prevent_empty' => false,
				'title_field'   => '{{{ product_cat }}}',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_product_settings_controls() {
		$this->start_controls_section(
			'section_product',
			[ 'label' => esc_html__( 'Products', 'farmart-addons' ) ]
		);

		$this->add_control(
			'product_type',
			[
				'label'   => esc_html__( 'Products', 'farmart-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'day'   => esc_html__( 'Deals of the day', 'farmart-addons' ),
					'week'  => esc_html__( 'Deals of the week', 'farmart-addons' ),
					'month' => esc_html__( 'Deals of the month', 'farmart-addons' ),
					'sale'  => esc_html__( 'On Sale', 'farmart-addons' ),
					'deals' => esc_html__( 'Product Deals', 'farmart-addons' ),
				],
				'default' => 'deals',
				'toggle'  => false,
			]
		);

		$this->add_control(
			'columns',
			[
				'label'   => esc_html__( 'Columns', 'farmart-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'3'   => esc_html__( '3 Columns', 'farmart-addons' ),
					'4'   => esc_html__( '4 Columns', 'farmart-addons' ),
					'5'   => esc_html__( '5 Columns', 'farmart-addons' ),
					'6'   => esc_html__( '6 Columns', 'farmart-addons' ),
				],
				'default' => '5',
				'toggle'  => false,
			]
		);

		$this->add_control(
			'per_page',
			[
				'label'   => esc_html__( 'Products per view', 'farmart-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 12,
				'min'     => 1,
				'max'     => 50,
				'step'    => 1,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order By', 'farmart-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''           => esc_html__( 'Default', 'farmart-addons' ),
					'date'       => esc_html__( 'Date', 'farmart-addons' ),
					'title'      => esc_html__( 'Title', 'farmart-addons' ),
					'menu_order' => esc_html__( 'Menu Order', 'farmart-addons' ),
					'rand'       => esc_html__( 'Random', 'farmart-addons' ),
				],
				'default' => '',
				'toggle'  => false,
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'farmart-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''     => esc_html__( 'Default', 'farmart-addons' ),
					'asc'  => esc_html__( 'Ascending', 'farmart-addons' ),
					'desc' => esc_html__( 'Descending', 'farmart-addons' ),
				],
				'default' => '',
				'toggle'  => false,
			]
		);

		$this->end_controls_section();
	}

	protected function register_pagination_settings_controls() {
		$this->start_controls_section(
			'section_pagination',
			[ 'label' => esc_html__( 'Pagination', 'farmart-addons' ) ]
		);

		$this->add_control(
			'pagination',
			[
				'label'        => __( 'Pagination', 'farmart-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'farmart-addons' ),
				'label_off'    => __( 'Hide', 'farmart-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'load_more_text',
			[
				'label'       => esc_html__( 'Text Pagination', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'LOAD MORE', 'farmart-addons' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'load_more_text_loading',
			[
				'label'       => esc_html__( 'Text Loading', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Loading', 'farmart-addons' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register the widget carousel settings controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */

	/**
	 * Register the widget heading style controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_heading_style_controls() {
		$this->start_controls_section(
			'section_style_heading',
			[
				'label' => esc_html__( 'Heading', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'heading_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-product-deals-day .cat-header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'heading_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .fm-product-deals-day .cat-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-deals-day .cat-header' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'heading_border',
				'label'    => __( 'Border', 'farmart-addons' ),
				'selector' => '{{WRAPPER}} .fm-product-deals-day .cat-header',
			]
		);

		$this->add_control(
			'heading_style_divider',
			[
				'label' => '',
				'type'  => Controls_Manager::DIVIDER,
			]
		);

		$this->start_controls_tabs( 'heading_title_style_settings' );

		$this->start_controls_tab( 'heading_title_style_tab', [ 'label' => esc_html__( 'Title', 'farmart-addons' ) ] );

		$this->add_responsive_control(
			'heading_title_margin',
			[
				'label'     => esc_html__( 'Margin', 'farmart-addons' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .fm-product-deals-day .header-content .cat-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-deals-day .header-content .cat-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_title_typography',
				'selector' => '{{WRAPPER}} .fm-product-deals-day .header-content .cat-title',
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
			'icon_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .fm-product-deals-day .cat-header .cat-title .farmart-svg-icon' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'icon_font_size',
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
					'{{WRAPPER}} .fm-product-deals-day .cat-header .cat-title .farmart-svg-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'icon_right_spacing',
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
					'{{WRAPPER}} .fm-product-deals-day .cat-header .cat-title .farmart-svg-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_popover();

		$this->end_controls_tab();

		// Countdown
		$this->start_controls_tab( 'heading_countdown_style_tab', [ 'label' => esc_html__( 'Countdown', 'farmart-addons' ) ] );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'countdown_typography',
				'label'    => esc_html__( 'Text Typography', 'farmart-addons' ),
				'selector' => '{{WRAPPER}} .fm-product-deals-day .cat-header .farmart-countdown',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'countdown_number_typography',
				'label'    => esc_html__( 'Number Typography', 'farmart-addons' ),
				'selector' => '{{WRAPPER}} .fm-product-deals-day .cat-header .farmart-countdown .digits',
			]
		);

		$this->add_control(
			'countdown_options',
			[
				'label'        => __( 'More Options', 'farmart-addons' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'farmart-addons' ),
				'label_on'     => __( 'Custom', 'farmart-addons' ),
				'return_value' => 'yes',
			]
		);
		$this->start_popover();
		$this->add_responsive_control(
			'countdown_padding',
			[
				'label'     => esc_html__( 'Padding', 'farmart-addons' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .fm-product-deals-day .cat-header .header-countdown' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'countdown_left_spacing',
			[
				'label'      => esc_html__( 'Left Spacing', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-product-deals-day .cat-header .countdown-wrapper' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'countdown_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-deals-day .cat-header .header-countdown' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'countdown_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-deals-day .cat-header .farmart-countdown' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'show_countdown_text',
			[
				'label'     => esc_html__( 'Countdown Text', 'farmart-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'inline-block' => esc_html__( 'Show', 'farmart-addons' ),
					'none'         => esc_html__( 'Hide', 'farmart-addons' ),
				],
				'default'   => 'inline-block',
				'selectors' => [
					'{{WRAPPER}} .fm-product-deals-day .cat-header .farmart-countdown .text' => 'display: {{VALUE}}',
				],
			]
		);
		$this->end_popover();

		// End In
		$this->add_control(
			'ends_in_style',
			[
				'label'     => __( 'Ends In', 'farmart-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'ends_text_typography',
				'selector' => '{{WRAPPER}} .fm-product-deals-day .cat-header .ends-text',
			]
		);
		$this->add_control(
			'ends_in_more_options',
			[
				'label'        => __( 'More Options', 'farmart-addons' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'farmart-addons' ),
				'label_on'     => __( 'Custom', 'farmart-addons' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();
		$this->add_responsive_control(
			'show_ends_in',
			[
				'label'     => esc_html__( 'Ends In Text', 'farmart-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'inline-block' => esc_html__( 'Show', 'farmart-addons' ),
					'none'         => esc_html__( 'Hide', 'farmart-addons' ),
				],
				'default'   => 'inline-block',
				'selectors' => [
					'{{WRAPPER}} .fm-product-deals-day .cat-header .ends-text' => 'display: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'ends_in_position',
			[
				'label'   => esc_html__( 'Position', 'farmart-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'outside' => esc_html__( 'Outside', 'farmart-addons' ),
					'inside'  => esc_html__( 'Inside', 'farmart-addons' ),
				],
				'default' => 'outside',
				'toggle'  => false,
			]
		);

		$this->add_responsive_control(
			'ends_in_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-product-deals-day .cat-header .ends-text' => 'margin-right: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_control(
			'ends_in_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-deals-day .cat-header .ends-text' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_popover();
		$this->end_controls_tab();

		// View All
		$this->start_controls_tab( 'heading_view_all_style_tab', [ 'label' => esc_html__( 'View All', 'farmart-addons' ) ] );

		$this->add_responsive_control(
			'show_heading_view_all',
			[
				'label'     => esc_html__( 'Display', 'farmart-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'flex' => esc_html__( 'Show', 'farmart-addons' ),
					'none' => esc_html__( 'Hide', 'farmart-addons' ),
				],
				'default'   => 'flex',
				'selectors' => [
					'{{WRAPPER}} .fm-product-deals-day .cat-header .header-link' => 'display: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_view_all_typography',
				'selector' => '{{WRAPPER}} .fm-product-deals-day .header-link',
			]
		);

		$this->add_control(
			'heading_view_all_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-deals-day .header-link span' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'heading_view_all_hover_color',
			[
				'label'     => esc_html__( 'Hover Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-deals-day .header-link:hover span'       => 'color: {{VALUE}}',
					'{{WRAPPER}} .fm-product-deals-day .header-link:hover .link-text' => 'text-shadow: 0 0 {{VALUE}};',
				],
			]
		);

		// Icon
		$this->add_control(
			'header_link_icon_style',
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
			'header_link_icon_font_size',
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
					'{{WRAPPER}} .fm-product-deals-day .cat-header .header-link .farmart-svg-icon'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .fm-product-deals-day .cat-header .header-link .farmart-svg-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_responsive_control(
			'header_link_icon_spacing',
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
					'{{WRAPPER}} .fm-product-deals-day .cat-header .header-link .farmart-svg-icon' => 'padding-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_popover();

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Register the widget heading style controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_products_style_controls() {
		$this->start_controls_section(
			'section_style_products',
			[
				'label' => esc_html__( 'Content', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'hide_icon_button',
			[
				'label'     => __( 'Hide Icon Button', 'farmart-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Disable', 'farmart-addons' ),
				'label_on'  => __( 'Enable', 'farmart-addons' ),
				'default'   => '',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'border_content_setting',
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
			'border_content_style',
			[
				'label'     => esc_html__( 'Border Style', 'farmart-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'dotted' => esc_html__( 'Dotted', 'farmart-addons' ),
					'dashed' => esc_html__( 'Dashed', 'farmart-addons' ),
					'solid'  => esc_html__( 'Solid', 'farmart-addons' ),
					'none'   => esc_html__( 'None', 'farmart-addons' ),
				],
				'default'   => '',
				'toggle'    => false,
				'selectors' => [
					'{{WRAPPER}} .fm-product-deals-day .products-content' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'border_content_color',
			[
				'label'     => esc_html__( 'Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-deals-day .products-content' => 'border-color: {{VALUE}}',

				],
			]
		);

		$this->add_control(
			'border_content_width',
			[
				'label' => __( 'Border Width', 'farmart-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .fm-product-deals-day .products-content' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_popover();

		$this->add_responsive_control(
			'products_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .fm-product-deals-day .products-content ul.products' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'products_style_divider',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->start_controls_tabs( 'more_options_tabs' );

		$this->start_controls_tab(
			'progress_bar_tab',
			[
				'label' => __( 'Progress Bar', 'farmart-addons' ),
			]
		);

		$this->add_control(
			'show_progress_bar',
			[
				'label'     => esc_html__( 'Progress Bar', 'farmart-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'block' => esc_html__( 'Show', 'farmart-addons' ),
					'none'  => esc_html__( 'Hide', 'farmart-addons' ),
				],
				'default'   => 'block',
				'selectors' => [
					'{{WRAPPER}} ul.products li.product .deal-progress' => 'display: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'progress_bar_height',
			[
				'label'      => esc_html__( 'Height', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-product-deals-day ul.products li.product .deal-progress .progress-bar'   => 'height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .fm-product-deals-day ul.products li.product .deal-progress .progress-value' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'progress_bar_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-deals-day .deal-progress .progress-bar' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'progress_bar_active_bg_color',
			[
				'label'     => esc_html__( 'Active Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-deals-day .deal-progress .progress-value' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'more_options_tab',
			[
				'label' => __( 'More Options', 'farmart-addons' ),
			]
		);
		$this->add_responsive_control(
			'action_button',
			[
				'label'       => esc_html__( 'Wishlist/Compare Text', 'farmart-addons' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'inline-block' => esc_html__( 'Show', 'farmart-addons' ),
					'none'         => esc_html__( 'Hide', 'farmart-addons' ),
				],
				'default'     => 'inline-block',
				'selectors'   => [
					'{{WRAPPER}} .fm-product-deals-day ul.products li.product .product-button .group a span' => 'display: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'swatches',
			[
				'label'       => esc_html__( 'Swatches', 'farmart-addons' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'block' => esc_html__( 'Show', 'farmart-addons' ),
					'none'  => esc_html__( 'Hide', 'farmart-addons' ),
				],
				'default'     => 'block',
				'selectors'   => [
					'{{WRAPPER}} .fm-product-deals-day ul.products li.product .product-thumbnail .fm-attr-swatches' => 'display: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
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
				'fm-product-deals-grid fm-product-deals-day woocommerce farmart-tabs',
				'fm-product-deals-query-' . $settings['product_type'],
				$settings['hide_icon_button'] == 'yes' ? 'hide-icon-button' : ''
			]
		);

		$icon = $view_all_icon = $link = '';

		if ( $settings['icon'] && ! empty( $settings['icon']['value'] ) && \Elementor\Icons_Manager::is_migration_allowed() ) {
			ob_start();
			\Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
			$icon = '<span class="farmart-svg-icon">' . ob_get_clean() . '</span>';
		}

		if( empty( $icon ) ) {
			$icon = '<span class="farmart-svg-icon"><svg viewBox="0 0 32 32"><path d="M8 32c-0.205 0-0.409-0.078-0.566-0.234-0.312-0.312-0.312-0.819 0-1.131l13.834-13.834-13.834-13.834c-0.312-0.312-0.312-0.819 0-1.131s0.819-0.312 1.131 0l14.4 14.4c0.312 0.312 0.312 0.819 0 1.131l-14.4 14.4c-0.156 0.156-0.361 0.234-0.566 0.234z"></path></svg></span>';
		}

		$is_rtl    = is_rtl();
		$direction = $is_rtl ? 'rtl' : 'ltr';
		$this->add_render_attribute( 'wrapper', 'dir', $direction );

		$now         = strtotime( current_time( 'Y-m-d H:i:s' ) );
		$expire_date = strtotime( '00:00 +1 day' );
		if ( $settings['product_type'] == 'week' ) {
			$expire_date = strtotime( '00:00 next monday' );
		} elseif ( $settings['product_type'] == 'month' ) {
			$expire_date = strtotime( '00:00 first day of next month' );
		}
		$expire = $expire_date - $now;

		$deals = array(
			'days'    => esc_html__( 'days', 'farmart-addons' ),
			'hours'   => esc_html__( 'hours', 'farmart-addons' ),
			'minutes' => esc_html__( 'mins', 'farmart-addons' ),
			'seconds' => esc_html__( 'secs', 'farmart-addons' ),
		);

		$settings['page'] = 1;

		$content_tabs = [ ];
		$header_tabs = [ ];
		$cats = $settings['product_cats_tabs'];

		if ( ! empty($cats) ) {

		$header_tabs[] =  '<ul class="tabs-nav">';
		$header_tabs[] =  '<li><a href="#" data-href="recent" data-key="key-all" class="active">'.esc_html__('All','farmart-addons').'</a></li>';
		$header_tabs[] =  implode( '', $this->get_tab_custom($settings, $check = false)[0] );
		$header_tabs[] =  '</ul>' ;

		}

		// Content all item
		$cat = [];
		foreach ( $cats as $tab ) {
			$cat[] = $tab['product_cat'];
		}

		$settings['product_cats'] = implode(' , ',$cat) ;

		$content_tabs[] = '<div class="tabs-content">';
		$content_tabs[] = sprintf( '<div class="tabs-panel key-all tab-loaded">%s</div>',Elementor::get_product_deals( $settings, $template = 'product', $other_type = false, $other_product_cats = false ) );
		$content_tabs[] =  implode( '', $this->get_tab_custom($settings)[1] );
		$content_tabs[] = '</div>';

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div class="cat-header">
				<div class="header-content">
					<h3 class="cat-title"><?php echo $icon . esc_html( $settings['title'] ); ?></h3>

					<div class="countdown-wrapper">
						<?php if ( $settings['ends_in_position'] == 'outside' ) : ?>
							<span class="ends-text"><?php echo esc_html( $settings['ends_in'] ) ?></span>
						<?php endif; ?>
						<div class="header-countdown">
							<?php if ( $settings['ends_in_position'] == 'inside' ) : ?>
								<span class="ends-text"><?php echo esc_html( $settings['ends_in'] ) ?></span>
							<?php endif; ?>

							<div class="farmart-countdown" data-expire="<?php echo esc_attr( $expire ); ?>" data-text="<?php echo esc_attr( wp_json_encode( $deals ) ) ?>"></div>
						</div>
					</div>
				</div>
				<?php echo $link; ?>
			</div>
			<div class="products-content">
				<?php
				echo 	implode( '', $header_tabs );
				echo 	implode( '', $content_tabs );
				?>
			</div>
		</div>
		<?php

	}

	/**
	 * Get the link control
	 *
	 * @return string.
	 */
	protected function get_link_control( $link_key, $url, $content, $attr = [ ] ) {
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

	protected function get_tab_custom ($settings, $check = true) {
		$cats = $settings['product_cats_tabs'];

		$tab_content = $header_tabs = [];

		if ( isset( $settings['quicklink_title'] ) ) {
			$header_link = sprintf( '<h6 class="title-tab">%s</h6>', esc_html( $settings['quicklink_title'] ) );

			$header_tabs[] = $header_link;
		}
		if ( $cats ) {
			$i = 0;

			foreach ( $cats as $tab ) {

				$term = get_term_by( 'slug', $tab['product_cat'], 'product_cat' );

				$key_tab = 'key'.esc_attr( $tab['product_cat'] ).' ';

				if ( ! is_wp_error( $term ) && $term ) {
					$header_tabs[] = sprintf( '<li><a href="#" data-href="%s" data-key="%s">%s</a></li>', esc_attr( $tab['product_cat'] ), esc_attr($key_tab),esc_html( $term->name ) );
				}

				if ($check == true){
					$tab_atts = array(
						'columns'           => $settings['columns'],
						'order'             => $settings['order'],
						'orderby'           => $settings['orderby'],
						'per_page'          => intval( $settings['per_page'] ),
						'product_cats'      => $tab['product_cat'],
						'load_more_text'    => $settings['load_more_text'],
						'load_more_text_loading'    => $settings['load_more_text_loading'],
						'page'              => '1',
						'product_type'      => $settings['product_type'],
						'pagination'        => $settings['pagination'],
					);

					$tab_key = 'wrapper_tab_products_' . $tab['product_cat'].$i;
					$this->add_render_attribute( $tab_key, 'data-settings', wp_json_encode( $tab_atts ) );

					$i++;
					$tab_content[] = sprintf(
						'<div class="tabs-panel tabs-%s %s" %s><div class="farmart-loading"></div></div>',
						esc_attr( $tab['product_cat'] ),
						esc_attr($key_tab),
						$this->get_render_attribute_string( $tab_key )
					);
				}
			}
		}

		return array($header_tabs,$tab_content);

	}

}