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
 * Recently Viewed Products widget
 */
class Recently_Viewed_Products extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'fm-content-recently-viewed';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Recently Viewed Products', 'farmart-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-product-images';
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
		$this->_register_product_settings_controls();
		$this->_register_empty_product_settings_controls();
		$this->_register_carousel_settings_controls();
	}

	protected function _register_heading_settings_controls() {
		// Heading Settings
		$this->start_controls_section(
			'section_heading',
			[ 'label' => esc_html__( 'Heading', 'farmart-addons' ) ]
		);

		$this->start_controls_tabs( 'heading_settings_tabs' );

		$this->start_controls_tab( 'title_tab', [ 'label' => esc_html__( 'Title', 'farmart-addons' ) ] );
		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Heading Name', 'farmart-addons' ),
				'placeholder' => esc_html__( 'Recent Viewed Products', 'farmart-addons' ),
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

		$this->start_controls_tab( 'view_all_tab', [ 'label' => esc_html__( 'View All', 'farmart-addons' ) ] );

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

		$this->end_controls_section(); // End

		$this->start_controls_section(
			'section_heading_style',
			[
				'label' => __( 'Heading', 'farmart-addons' ),
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
					'{{WRAPPER}} .fm-content-recently-viewed .recently-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'section_border_heading',
			[
				'label'        => __( 'Border', 'farmart-addons' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'farmart-addons' ),
				'label_on'     => __( 'Custom', 'farmart-addons' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'heading_border',
				'label'    => __( 'Border', 'farmart-addons' ),
				'selector' => '{{WRAPPER}} .fm-content-recently-viewed .recently-heading',
			]
		);

		$this->add_control(
			'heading_border_radius',
			[
				'label'     => esc_html__( 'Border Radius', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .fm-content-recently-viewed .recently-heading' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_popover();

		$this->start_controls_tabs( 'settings_heading' );

		$this->start_controls_tab( 'style_title', [ 'label' => esc_html__( 'Title', 'farmart-addons' ) ] );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'style_heading_typography',
				'selector' => '{{WRAPPER}} .fm-content-recently-viewed .recently-title',
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-content-recently-viewed .recently-title' => 'color: {{VALUE}};',
				],
			]
		);
		// Icon
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
					'{{WRAPPER}} .fm-content-recently-viewed .recently-title .farmart-svg-icon' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .fm-content-recently-viewed .recently-title .farmart-svg-icon' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .fm-content-recently-viewed .recently-title .farmart-svg-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_popover();
		$this->end_controls_tab();

		$this->start_controls_tab( 'style_link_all', [ 'label' => esc_html__( 'Link', 'farmart-addons' ) ] );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'style_link_all_typography',
				'selector' => '{{WRAPPER}} .fm-content-recently-viewed  .header-link',
			]
		);

		$this->add_control(
			'link_all_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-content-recently-viewed  .header-link span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'heading_links_hover_color',
			[
				'label'     => esc_html__( 'Hover Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-content-recently-viewed  .header-link:hover span'       => 'color: {{VALUE}}',
					'{{WRAPPER}} .fm-content-recently-viewed  .header-link:hover .link-text' => 'text-shadow: 0 0 {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'icon_link_all',
			[
				'label'      => __( 'Icon Size', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [],
				'selectors'  => [
					'{{WRAPPER}} .fm-content-recently-viewed  .farmart-svg-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_spacing',
			[
				'label'      => __( 'Spacing', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [],
				'selectors'  => [
					'{{WRAPPER}} .fm-content-recently-viewed  .farmart-svg-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	protected function _register_product_settings_controls() {
		$this->start_controls_section(
			'section_products',
			[ 'label' => esc_html__( 'Products', 'farmart-addons' ) ]
		);

		$this->add_control(
			'viewed_products_number',
			[
				'label'       => esc_html__( 'Total Products', 'farmart-addons' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => true,
				'default'     => 12,
			]
		);
		$this->end_controls_section(); // End

		$this->start_controls_section(
			'section_products_style',
			[
				'label' => __( 'Products', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .fm-content-recently-viewed .recently-viewed-products' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'after',
			]
		);
		$this->add_control(
			'content_background_color',
			[
				'label'     => __( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-content-recently-viewed .recently-viewed-products' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'section_border_content',
			[
				'label'        => __( 'Border', 'farmart-addons' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'farmart-addons' ),
				'label_on'     => __( 'Custom', 'farmart-addons' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'content_border',
				'label'    => __( 'Border', 'farmart-addons' ),
				'selector' => '{{WRAPPER}} .fm-content-recently-viewed .recently-viewed-inner',
			]
		);

		$this->add_control(
			'content_border_radius',
			[
				'label'     => esc_html__( 'Border Radius', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .fm-content-recently-viewed .recently-viewed-inner' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_popover();

		// Border Item
		$this->add_control(
			'section_border_item',
			[
				'label'        => __( 'Item Border', 'farmart-addons' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'farmart-addons' ),
				'label_on'     => __( 'Custom', 'farmart-addons' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'border_item',
				'label'    => __( 'Border', 'farmart-addons' ),
				'selector' => '{{WRAPPER}} .fm-content-recently-viewed .product-list a',
			]
		);

		$this->add_control(
			'border_item_radius',
			[
				'label'     => esc_html__( 'Border Radius', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .fm-content-recently-viewed .product-list a' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_popover();
		$this->end_controls_section();
	}

	protected function _register_empty_product_settings_controls() {
		$this->start_controls_section(
			'section_empty_product',
			[ 'label' => esc_html__( 'Empty Products', 'farmart-addons' ) ]
		);

		$this->add_control(
			'hide_empty_section',
			[
				'label'     => __( 'Hide Section Empty Product', 'farmart-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'farmart-addons' ),
				'label_on'  => __( 'On', 'farmart-addons' ),
				'default'   => ''
			]
		);

		$this->add_control(
			'empty_product_description',
			[
				'label'       => esc_html__( 'Description', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter your text', 'farmart-addons' ),
				'label_block' => true,
				'default'     => esc_html__( 'Recently Viewed Products is a function which helps you keep track of your recent viewing history.', 'farmart-addons' ),
			]
		);

		$this->add_control(
			'empty_product_text',
			[
				'label'       => esc_html__( 'Button Text', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your text', 'farmart-addons' ),
				'label_block' => true,
				'default'     => esc_html__( 'Shop Now', 'farmart-addons' ),
			]
		);

		$this->add_control(
			'empty_product_link',
			[
				'label'       => esc_html__( 'Button Link', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your text', 'farmart-addons' ),
				'label_block' => true,
				'default'     => '',
			]
		);
		$this->end_controls_section(); // End

		// Empty Style
		$this->start_controls_section(
			'section_empty_content',
			[
				'label' => __( 'Empty Products', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'empty_content_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .fm-content-recently-viewed .recently-empty-products' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'after',
			]
		);
		$this->add_control(
			'empty_content_background_color',
			[
				'label'     => __( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-content-recently-viewed .recently-empty-products' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'settings_empty_item' );

		$this->start_controls_tab( 'style_empty_desc', [ 'label' => esc_html__( 'Description', 'farmart-addons' ) ] );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'style_desc_typography',
				'selector' => '{{WRAPPER}} .fm-content-recently-viewed .recently-empty-products .empty-desc',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-content-recently-viewed .recently-empty-products .empty-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'style_empty_button', [ 'label' => esc_html__( 'Button', 'farmart-addons' ) ] );

		$this->add_responsive_control(
			'btn_padding',
			[
				'label'              => esc_html__( 'Padding', 'farmart-addons' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'allowed_dimensions' => [ 'left', 'right' ],
				'size_units'         => [ 'px', '%' ],
				'default'            => [],
				'selectors'          => [
					'{{WRAPPER}} .fm-content-recently-viewed .recently-empty-products .btn-primary' => 'padding-left: {{TOP}}{{UNIT}};padding-right: {{RIGHT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'btn_height',
			[
				'label'     => esc_html__( 'Height', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'unit' => 'px',
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .fm-content-recently-viewed .recently-empty-products .btn-primary' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'btn_spacing',
			[
				'label'     => esc_html__( 'Top Spacing', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'unit' => 'px',
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .fm-content-recently-viewed .recently-empty-products .btn-primary' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'btn_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-content-recently-viewed .recently-empty-products .btn-primary' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_bk_color',
			[
				'label'     => __( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-content-recently-viewed .recently-empty-products .btn-primary' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'btn_border_style',
			[
				'label'        => __( 'Button Border', 'farmart-addons' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'farmart-addons' ),
				'label_on'     => __( 'Custom', 'farmart-addons' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'style_btn_typography',
				'selector' => '{{WRAPPER}} .fm-content-recently-viewed .recently-empty-products .btn-primary',
			]
		);

		$this->add_control(
			'btn_border_radius',
			[
				'label'     => esc_html__( 'Border Radius', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .fm-content-recently-viewed .recently-empty-products .btn-primary' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_popover();
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function _register_carousel_settings_controls() {
		$this->start_controls_section(
			'section_carousel_settings',
			[ 'label' => esc_html__( 'Carousel Settings', 'farmart-addons' ) ]
		);
		$this->add_responsive_control(
			'slidesToShow',
			[
				'label'   => esc_html__( 'Slides to show', 'farmart-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 20,
				'default' => 10,
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
				'default'   => 'no'
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
				'step'        => 50,
				'description' => esc_html__( 'Slide animation speed (in ms)', 'farmart-addons' ),
			]
		);

		// Additional Settings
		$this->_register_responsive_settings_controls();

		$this->end_controls_section(); // End

		// Carousel Style
		$this->start_controls_section(
			'section_carousel_style',
			[
				'label' => esc_html__( 'Carousel Settings', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'arrows_style_divider',
			[
				'label' => esc_html__( 'Arrows', 'farmart-addons' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		// Arrows
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
					'{{WRAPPER}} .fm-content-recently-viewed .slick-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
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
					'{{WRAPPER}} .fm-content-recently-viewed .slick-arrow' => 'width: {{SIZE}}{{UNIT}}',
				],
				'separator'  => 'before',
			]
		);

		$this->add_control(
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
					'{{WRAPPER}} .fm-content-recently-viewed .slick-arrow' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .fm-content-recently-viewed .slick-prev-arrow' => 'left: {{VALUE}}px;',
					'{{WRAPPER}} .fm-content-recently-viewed .slick-next-arrow' => 'right: {{VALUE}}px;',
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
					'{{WRAPPER}} .fm-content-recently-viewed .slick-prev-arrow, .fm-content-recently-viewed .slick-next-arrow' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-content-recently-viewed .slick-prev-arrow, .fm-content-recently-viewed .slick-next-arrow' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-content-recently-viewed .slick-prev-arrow, .fm-content-recently-viewed .slick-next-arrow' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-content-recently-viewed .slick-prev-arrow:hover, .fm-content-recently-viewed .slick-next-arrow:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-content-recently-viewed .slick-prev-arrow:hover, .fm-content-recently-viewed .slick-next-arrow:hover' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-content-recently-viewed .slick-prev-arrow:hover, .fm-content-recently-viewed .slick-next-arrow:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'dots_style_divider',
			[
				'label'     => esc_html__( 'Dots', 'farmart-addons' ),
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
					'{{WRAPPER}} .fm-content-recently-viewed .slick-dots li' => 'margin: 0 {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'sliders_dots_width',
			[
				'label'      => esc_html__( 'Size', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-content-recently-viewed .slick-dots li button'        => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .fm-content-recently-viewed .slick-dots li button:before' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .fm-content-recently-viewed .slick-dots' => 'bottom: {{VALUE}}px;',
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
					'{{WRAPPER}} .fm-content-recently-viewed .slick-dots li button:before' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-content-recently-viewed .slick-dots li.slick-active button:before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .fm-content-recently-viewed .slick-dots li button:hover:before'        => 'background-color: {{VALUE}};',
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
				'default' => 1,
			]
		);
		$repeater->add_control(
			'responsive_slidesToScroll',
			[
				'label'           => esc_html__( 'Slides to scroll', 'farmart-addons' ),
				'type'            => Controls_Manager::NUMBER,
				'min'             => 1,
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

		$classes = [
			'fm-content-recently-viewed fm-recently-viewed woocommerce',
			$settings['hide_empty_section'] == 'yes' ? 'hide-empty-section' : ''
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		$number_settings = [
			'numbers' => $settings['viewed_products_number'],
		];

		$this->add_render_attribute( 'wrapper', 'data-settings', wp_json_encode( Elementor::get_data_slick( $settings ) ) );
		$this->add_render_attribute( 'wrapper', 'data-number', wp_json_encode( $number_settings ) );

		$title = $link = $title_icon = $icon = '';

		if ( $settings['title_icon'] && ! empty( $settings['title_icon']['value'] ) && \Elementor\Icons_Manager::is_migration_allowed() ) {
			ob_start();
			\Elementor\Icons_Manager::render_icon( $settings['title_icon'], [ 'aria-hidden' => 'true' ] );
			$title_icon = '<span class="farmart-svg-icon">' . ob_get_clean() . '</span>';
		}

		if ( $settings['title'] ) {
			$title = '<h3 class="recently-title">' . $title_icon . $settings['title'] . '</h3>';
		}

		if ( $settings['view_all_icon'] && ! empty( $settings['view_all_icon']['value'] ) && \Elementor\Icons_Manager::is_migration_allowed() ) {
			ob_start();
			\Elementor\Icons_Manager::render_icon( $settings['view_all_icon'], [ 'aria-hidden' => 'true' ] );
			$icon_svg = ob_get_clean();
			if( $icon_svg ) {
				$icon = '<span class="farmart-svg-icon">' . $icon_svg . '</span>';
			}
		}

		if( empty( $icon ) ) {
			$icon = '<span class="farmart-svg-icon"><svg viewBox="0 0 32 32"><path d="M8 32c-0.205 0-0.409-0.078-0.566-0.234-0.312-0.312-0.312-0.819 0-1.131l13.834-13.834-13.834-13.834c-0.312-0.312-0.312-0.819 0-1.131s0.819-0.312 1.131 0l14.4 14.4c0.312 0.312 0.312 0.819 0 1.131l-14.4 14.4c-0.156 0.156-0.361 0.234-0.566 0.234z"></path></svg></span>';
		}

		if ( $settings['view_all_text'] ) {
			$text = '<span class="link-text">' . $settings['view_all_text'] . '</span>' . $icon;
			$link = $this->get_link_control( 'header_link', $settings['view_all_link'], $text, [ 'class' => 'header-link' ] );
		}
		?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ) ?>>
            <div class="recently-heading">
				<?php echo $title ?>
				<?php echo $link ?>
            </div>

            <div class="recently-viewed-inner">
                <div class="recently-viewed-content">
                    <div class="farmart-loading--wrapper">
                        <div class="farmart-loading"></div>
                    </div>
                    <div class="recently-empty-products text-center">
                        <div class="empty-desc"><?php echo wp_kses( $settings['empty_product_description'], wp_kses_allowed_html( 'post' ) ) ?></div>
                        <a class="btn-primary"
                           href="<?php echo esc_url( $settings['empty_product_link'] ) ?>"><?php echo esc_html( $settings['empty_product_text'] ) ?></a>
                    </div>
                    <div class="recently-viewed-products">
                        <div class="recently-has-products">

                        </div>
                    </div>
                </div>
            </div>
        </div>
		<?php
	}

	/**
	 * Get the link control
	 *
	 * @return string.
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