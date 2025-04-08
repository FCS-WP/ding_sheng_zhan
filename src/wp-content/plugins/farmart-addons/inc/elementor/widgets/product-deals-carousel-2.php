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
class Product_Deals_Carousel_2 extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'fm-product-deals-carousel-2';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Product Deals Carousel 2', 'farmart-addons' );
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

		// Content
		$this->register_heading_settings_controls();
		$this->register_product_settings_controls();
		$this->register_carousel_settings_controls();

		// Style
		$this->register_heading_style_controls();
		$this->register_products_style_controls();
		$this->register_carousel_style_controls();
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
			'countdown_enable',
			[
				'label'     => __( 'Countdown', 'farmart-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'farmart-addons' ),
				'label_on'  => __( 'Show', 'farmart-addons' ),
				'default'   => 'yes'
			]
		);

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

		// View all
		$this->start_controls_tab( 'view_all', [ 'label' => esc_html__( 'View All', 'farmart-addons' ) ] );

		$this->add_control(
			'view_all_text',
			[
				'label'   => esc_html__( 'View All Text', 'farmart-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'View all', 'farmart-addons' ),
			]
		);

		$this->add_control(
			'view_all_link', [
				'label'         => esc_html__( 'View All Link', 'farmart-addons' ),
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
			'view_all_icon',
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
			'product_cats',
			[
				'label'       => esc_html__( 'Product Categories', 'farmart-addons' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => Elementor::get_taxonomy(),
				'default'     => '',
				'multiple'    => true,
				'label_block' => true,
			]
		);

		$this->add_control(
			'product_brands',
			[
				'label'       => esc_html__( 'Product Brands', 'farmart-addons' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => Elementor::get_taxonomy( 'product_brand' ),
				'default'     => '',
				'multiple'    => true,
				'label_block' => true,
			]
		);

		if ( taxonomy_exists( 'product_collection' ) ) {
			$this->add_control(
				'product_collections',
				[
					'label'       => esc_html__( 'Product Collections', 'farmart-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'options'     => Elementor::get_taxonomy( 'product_collection' ),
					'default'     => '',
					'multiple'    => true,
					'label_block' => true,
				]
			);
		}

		$this->add_control(
			'per_page',
			[
				'label'   => esc_html__( 'Products per view', 'farmart-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 12,
				'min'     => 2,
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

	/**
	 * Register the widget carousel settings controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_carousel_settings_controls() {

		$this->start_controls_section(
			'section_carousel_settings',
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
				'default' => 2,
			]
		);
		$this->add_responsive_control(
			'rows',
			[
				'label'   => esc_html__( 'Rows', 'farmart-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 5,
				'default' => 2,
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

		$this->end_controls_section();
	}

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
					'{{WRAPPER}} .fm-product-deals-day .products-content:after' => 'background-color: {{VALUE}}',
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
			'products_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-elementor-product-deals-carousel-2 ul.products' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'products_style_divider',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_responsive_control(
			'products_item_space',
			[
				'label'      => esc_html__( 'Items Space', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-elementor-product-deals-carousel-2 ul.products li.product'   => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'products_item_padding',
			[
				'label'      => esc_html__( 'Padding Items', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .fm-elementor-product-deals-carousel-2 ul.products li.product .product-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
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

		$this->end_controls_section();
	}

	/**
	 * Register the widget carousel style controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_carousel_style_controls() {

		$this->start_controls_section(
			'section_style_carousel',
			[
				'label' => esc_html__( 'Carousel Style', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'arrows_style_divider',
			[
				'label'     => __( 'Arrows', 'farmart-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
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

		$this->add_responsive_control(
			'sliders_arrows_size',
			[
				'label'     => __( 'Size', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .fm-product-deals-day .slick-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'sliders_arrow_width',
			[
				'label'      => esc_html__( 'Width', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-product-deals-day .slick-arrow' => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'sliders_arrow_height',
			[
				'label'      => esc_html__( 'Height', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-product-deals-day .slick-arrow' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'sliders_arrows_offset',
			[
				'label'     => esc_html__( 'Horizontal Offset', 'farmart-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'step'      => 1,
				'selectors' => [
					'{{WRAPPER}} .fm-product-deals-day .slick-prev-arrow' => 'left: {{VALUE}}px;',
					'{{WRAPPER}} .fm-product-deals-day .slick-next-arrow' => 'right: {{VALUE}}px;',
				],
			]
		);
		$this->end_popover();

		$this->start_controls_tabs( 'sliders_normal_settings' );

		$this->start_controls_tab( 'sliders_normal', [ 'label' => esc_html__( 'Normal', 'farmart-addons' ) ] );

		$this->add_control(
			'sliders_arrow_background',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-product-deals-day .slick-prev-arrow, .fm-product-deals-day .slick-next-arrow' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sliders_arrow_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-product-deals-day .slick-prev-arrow, .fm-product-deals-day .slick-next-arrow' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sliders_arrow_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-product-deals-day .slick-prev-arrow, .fm-product-deals-day .slick-next-arrow' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'sliders_hover', [ 'label' => esc_html__( 'Hover', 'farmart-addons' ) ] );

		$this->add_control(
			'sliders_arrow_hover_background',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-product-deals-day .slick-prev-arrow:hover, .fm-product-deals-day .slick-next-arrow:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sliders_arrow_hover_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-product-deals-day .slick-prev-arrow:hover, .fm-product-deals-day .slick-next-arrow:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sliders_arrow_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-product-deals-day .slick-prev-arrow:hover, .fm-product-deals-day .slick-next-arrow:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
		$this->add_control(
			'dots_style_divider',
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
		$this->add_responsive_control(
			'sliders_dots_gap',
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
					'{{WRAPPER}} .fm-product-deals-day .slick-dots li' => 'margin: 0 {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'sliders_dots_width',
			[
				'label'      => esc_html__( 'Size', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-product-deals-day .slick-dots li button'        => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .fm-product-deals-day .slick-dots li button:before' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}}',
				],
				'separator'  => 'before',
			]
		);
		$this->add_responsive_control(
			'sliders_dots_offset',
			[
				'label'     => esc_html__( 'Vertical Offset', 'farmart-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'step'      => 1,
				'selectors' => [
					'{{WRAPPER}} .fm-product-deals-day .slick-dots' => 'bottom: {{VALUE}}px;',
				],
			]
		);
		$this->add_control(
			'sliders_dots_background',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-product-deals-day .slick-dots li button:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sliders_dots_active_background',
			[
				'label'     => esc_html__( 'Active Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-product-deals-day .slick-dots li.slick-active button:before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .fm-product-deals-day .slick-dots li button:hover:before'        => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->end_popover();
		$this->end_controls_section();
	}

	protected function _register_responsive_settings_controls() {
		$this->add_control(
			'responsive_settings_divider',
			[
				'label' => __( 'Additional Settings', 'farmart-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'responsive_breakpoint', [
				'label' => __( 'Breakpoint', 'farmart-addons' ) . ' (px)',
				'description' => __( 'Below this breakpoint the options below will be triggered', 'farmart-addons' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 1200,
				'min'             => 320,
				'max'             => 1920,
			]
		);
		$repeater->add_control(
			'responsive_slidesToShow',
			[
				'label'           => esc_html__( 'Slides to show', 'farmart-addons' ),
				'type'            => Controls_Manager::NUMBER,
				'min'             => 1,
				'max'             => 7,
				'default' => 1,
			]
		);
		$repeater->add_control(
			'responsive_slidesToScroll',
			[
				'label'           => esc_html__( 'Slides to scroll', 'farmart-addons' ),
				'type'            => Controls_Manager::NUMBER,
				'min'             => 1,
				'max'             => 7,
				'default' => 1,
			]
		);
		$repeater->add_control(
			'responsive_navigation',
			[
				'label'           => esc_html__( 'Navigation', 'farmart-addons' ),
				'type'            => Controls_Manager::SELECT,
				'options'         => [
					'both'   => esc_html__( 'Arrows and Dots', 'farmart-addons' ),
					'arrows' => esc_html__( 'Arrows', 'farmart-addons' ),
					'dots'   => esc_html__( 'Dots', 'farmart-addons' ),
					'none'   => esc_html__( 'None', 'farmart-addons' ),
				],
				'default' => 'dots',
				'toggle'          => false,
			]
		);

		$this->add_control(
			'carousel_responsive_settings',
			[
				'label' => __( 'Settings', 'farmart-addons' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default' => [

				],
				'title_field' => '{{{ responsive_breakpoint }}}' . 'px',
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
				'fm-product-deals-day fm-elementor-product-deals-carousel-2 fm-elementor-product-carousel woocommerce',
				'fm-product-deals-query-' . $settings['product_type']
			]
		);

		$icon = $view_all_icon = $link = '';

		if ( $settings['icon'] && ! empty( $settings['icon']['value'] ) && \Elementor\Icons_Manager::is_migration_allowed() ) {
			ob_start();
			\Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
			$icon = '<span class="farmart-svg-icon">' . ob_get_clean() . '</span>';
		}

		if ( $settings['view_all_icon'] && ! empty( $settings['view_all_icon']['value'] ) && \Elementor\Icons_Manager::is_migration_allowed() ) {
			ob_start();
			\Elementor\Icons_Manager::render_icon( $settings['view_all_icon'], [ 'aria-hidden' => 'true' ] );
			$icon_svg = ob_get_clean();
			if( $icon_svg ) {
				$view_all_icon = '<span class="farmart-svg-icon">' . $icon_svg . '</span>';
			}
		}

		if( empty( $view_all_icon ) ) {
			$view_all_icon = '<span class="farmart-svg-icon"><svg viewBox="0 0 32 32"><path d="M8 32c-0.205 0-0.409-0.078-0.566-0.234-0.312-0.312-0.312-0.819 0-1.131l13.834-13.834-13.834-13.834c-0.312-0.312-0.312-0.819 0-1.131s0.819-0.312 1.131 0l14.4 14.4c0.312 0.312 0.312 0.819 0 1.131l-14.4 14.4c-0.156 0.156-0.361 0.234-0.566 0.234z"></path></svg></span>';
		}

		if ( $settings['view_all_text'] ) {
			$text = '<span class="link-text">' . $settings['view_all_text'] . '</span>' . $view_all_icon;
			$link = $this->get_link_control( 'header_link', $settings['view_all_link'], $text, [ 'class' => 'header-link' ] );
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

		$this->add_render_attribute( 'wrapper', 'data-settings', wp_json_encode( Elementor::get_data_slick( $settings ) ) );

		$deals = array(
			'days'    => esc_html__( 'days', 'farmart-addons' ),
			'hours'   => esc_html__( 'hours', 'farmart-addons' ),
			'minutes' => esc_html__( 'mins', 'farmart-addons' ),
			'seconds' => esc_html__( 'secs', 'farmart-addons' ),
		);

		$settings['columns']    = intval( $settings['slidesToShow'] );
		$settings['pagination'] = '';
		$product_deals          = Elementor::get_product_deals( $settings, $template = 'product', $other_type = false, $other_product_cats = true  );

		if ( empty( $product_deals ) ) {
			return;
		}
		?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <div class="cat-header">
                <div class="header-content">
                    <h3 class="cat-title"><?php echo $icon . esc_html( $settings['title'] ); ?></h3>

		            <?php if ( $settings['countdown_enable'] ) : ?>
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
                     <?php endif; ?>
                </div>
				<?php echo $link; ?>
            </div>
            <div class="products-content">
				<?php echo $product_deals; ?>
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
}