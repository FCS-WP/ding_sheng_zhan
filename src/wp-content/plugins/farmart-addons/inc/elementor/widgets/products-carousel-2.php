<?php

namespace FarmartAddons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use FarmartAddons\Elementor;
use FarmartAddons\Elementor_AjaxLoader;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon Box widget
 */
class Products_Carousel_2 extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'farmart-products-carousel-2';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Farmart - Products Carousel 2', 'farmart-addons' );
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
		$this->_register_products_settings_controls();
		$this->_register_carousel_settings_controls();
		$this->_register_lazy_load_controls();
	}

	protected function _register_heading_settings_controls() {
		// Heading Settings
		$this->start_controls_section(
			'section_heading',
			[ 'label' => esc_html__( 'Heading', 'farmart-addons' ) ]
		);
		$this->start_controls_tabs( 'heading_settings_tabs' );
		$this->start_controls_tab(
			'heading_title_tab',
			[
				'label' => __( 'Title', 'farmart-addons' ),
			]
		);
		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Heading Name', 'farmart-addons' ),
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
					'value'   => 'icon-alarm-ringing',
					'library' => 'linearicons',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab( 'quick_links_tab', [ 'label' => esc_html__( 'Link All', 'farmart-addons' ) ] );

		$this->add_control(
			'link_text',
			[
				'label'       => esc_html__( 'Link Text', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'View all', 'farmart-addons' ),
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

		$this->end_controls_section(); // End Heading Settings

		// Heading Style
		$this->start_controls_section(
			'section_heading_style',
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
					'{{WRAPPER}} .-2 .products-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .-2 .products-header' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'heading_border',
				'label'    => esc_html__( 'Border', 'farmart-addons' ),
				'selector' => '{{WRAPPER}} .-2 .products-header',
			]
		);

		$this->start_controls_tabs( 'heading_style_tabs', [ 'separator' => 'before', ] );

		$this->start_controls_tab(
			'heading_title_style_tab',
			[
				'label' => __( 'Title', 'farmart-addons' ),
			]
		);
		$this->add_responsive_control(
			'title_margin',
			[
				'label'      => esc_html__( 'Margin', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .-2 .products-header h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .-2 .products-header h3',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .-2 .products-header h3' => 'color: {{VALUE}};',
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
					'{{WRAPPER}}  .-2 .products-header h3 .farmart-svg-icon' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .fm-products-carousel-2 .products-header h3 .farmart-svg-icon' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .fm-products-carousel-2 .products-header h3 .farmart-svg-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_popover();

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
				'selector' => '{{WRAPPER}} .fm-products-carousel-2 .products-header .header-link',
			]
		);

		$this->add_control(
			'link_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-products-carousel-2 .products-header .header-link span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'link_color_hover',
			[
				'label'     => __( 'Hover Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-products-carousel-2 .products-header .header-link:hover .link-text'     => 'color: {{VALUE}}; text-shadow: 0 0 {{VALUE}};',
					'{{WRAPPER}} .fm-products-carousel-2 .products-header .header-link:hover .farmart-svg-icon' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-products-carousel-2 .products-header .header-link .farmart-svg-icon'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .fm-products-carousel-2 .products-header .header-link .farmart-svg-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .fm-products-carousel-2 .products-header .header-link .farmart-svg-icon' => 'padding-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_popover();

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function _register_products_settings_controls() {
		// Products Settings
		$this->start_controls_section(
			'section_products',
			[ 'label' => esc_html__( 'Products', 'farmart-addons' ) ]
		);

		$this->add_control(
			'source',
			[
				'label'       => esc_html__( 'Source', 'farmart-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'default' => esc_html__( 'Default', 'farmart-addons' ),
					'custom'  => esc_html__( 'Custom', 'farmart-addons' ),
				],
				'default'     => 'default',
				'label_block' => true,
			]
		);
		$this->add_control(
			'ids',
			[
				'label'       => esc_html__( 'Products', 'farmart-addons' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'farmart-addons' ),
				'type'        => 'fmautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product',
				'sortable'    => true,
				'condition'   => [
					'source' => 'custom',
				],
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
				'condition'   => [
					'source' => 'default',
				],
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
				'condition'   => [
					'source' => 'default',
				],
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
					'condition'   => [
						'source' => 'default',
					],
				]
			);
		}

		$this->add_control(
			'per_page',
			[
				'label'     => esc_html__( 'Total Products', 'farmart-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 8,
				'min'       => 2,
				'max'       => 50,
				'step'      => 1,
				'condition' => [
					'source' => 'default',
				],
			]
		);

		$this->add_control(
			'products',
			[
				'label'     => esc_html__( 'Product', 'farmart-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'recent'       => esc_html__( 'Recent', 'farmart-addons' ),
					'featured'     => esc_html__( 'Featured', 'farmart-addons' ),
					'best_selling' => esc_html__( 'Best Selling', 'farmart-addons' ),
					'top_rated'    => esc_html__( 'Top Rated', 'farmart-addons' ),
					'sale'         => esc_html__( 'On Sale', 'farmart-addons' ),
				],
				'default'   => 'recent',
				'toggle'    => false,
				'condition' => [
					'source' => 'default',
				],
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'      => esc_html__( 'Order By', 'farmart-addons' ),
				'type'       => Controls_Manager::SELECT,
				'options'    => [
					''           => esc_html__( 'Default', 'farmart-addons' ),
					'date'       => esc_html__( 'Date', 'farmart-addons' ),
					'title'      => esc_html__( 'Title', 'farmart-addons' ),
					'menu_order' => esc_html__( 'Menu Order', 'farmart-addons' ),
					'rand'       => esc_html__( 'Random', 'farmart-addons' ),
				],
				'default'    => '',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'products',
							'value' => [ 'recent', 'top_rated', 'sale', 'featured' ],
						],
						[
							'name'  => 'source',
							'value' => 'default',
						]
					]
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'      => esc_html__( 'Order', 'farmart-addons' ),
				'type'       => Controls_Manager::SELECT,
				'options'    => [
					''     => esc_html__( 'Default', 'farmart-addons' ),
					'asc'  => esc_html__( 'Ascending', 'farmart-addons' ),
					'desc' => esc_html__( 'Descending', 'farmart-addons' ),
				],
				'default'    => '',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'products',
							'value' => [ 'recent', 'top_rated', 'sale', 'featured' ],
						],
						[
							'name'  => 'source',
							'value' => 'default',
						]
					]
				],
			]
		);

		$this->add_control(
			'product_type',
			[
				'label'      => esc_html__( 'Product Type', 'farmart-addons' ),
				'type'       => Controls_Manager::SELECT,
				'options'    => [
					'grid'     => esc_html__( 'Grid', 'farmart-addons' ),
					'carousel'  => esc_html__( 'Carousel', 'farmart-addons' ),
				],
				'default'    => 'carousel',
			]
		);

		$this->end_controls_section(); // End Products Settings

		// Products Style
		$this->start_controls_section(
			'section_products_style',
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

		$this->add_responsive_control(
			'products_padding',
			[
				'label'      => esc_html__( 'Padding Content', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .fm-products-carousel-2 .products-content ul.products' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'products_list_padding',
			[
				'label'     => esc_html__( 'Padding Content List', 'farmart-addons' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .fm-elementor-product-carousel .slick-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);
		$this->add_responsive_control(
			'products_list_margin',
			[
				'label'     => esc_html__( 'Margin Content List', 'farmart-addons' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .fm-elementor-product-carousel .slick-list' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'products_thumbnail_space',
			[
				'label'     => __( 'Thumbnail Space', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .fm-products-carousel-2 ul.products li.product .product-thumbnail' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_background',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-products-carousel-2 .products-content' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'line_setting',
			[
				'label'        => __( 'Divider', 'farmart-addons' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'farmart-addons' ),
				'label_on'     => __( 'Custom', 'farmart-addons' ),
				'return_value' => 'yes',
			]
		);
		$this->start_popover();

		$this->add_control(
			'divider_bkcolor',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-products-carousel-2 .products-content li.product:after' => 'background-color: {{VALUE}}',

				],
			]
		);

		$this->add_control(
			'divider_width',
			[
				'label'      => esc_html__( 'Width', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px','%' ],
				'selectors'  => [
					'{{WRAPPER}} .fm-products-carousel-2 .products-content li.product:after' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_popover();


		$this->add_control(
			'border_setting',
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
			'border_style',
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
					'{{WRAPPER}} .fm-products-carousel-2 .products-content ul.products' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'border_color',
			[
				'label'     => esc_html__( 'Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-products-carousel-2 .products-content ul.products' => 'border-color: {{VALUE}}',

				],
			]
		);

		$this->add_control(
			'border_width',
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
					'{{WRAPPER}} .fm-products-carousel-2 .products-content ul.products' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_popover();

		$this->end_controls_section();
	}

	protected function _register_carousel_settings_controls() {
		// Carousel Settings
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
				'max'     => 10,
				'default' => 5,
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
				'default' => 'both',
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
				'step'        => 50,
				'description' => esc_html__( 'Slide animation speed (in ms)', 'farmart-addons' ),
			]
		);

		// Additional Settings
		$this->_register_responsive_settings_controls();

		$this->end_controls_section(); // End Carousel Settings

		// Carousel Style
		// Carousel Settings
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
					'{{WRAPPER}} .fm-products-carousel-2 .slick-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .fm-products-carousel-2 .slick-arrow' => 'width: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .fm-products-carousel-2 .slick-arrow' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .fm-products-carousel-2 .slick-prev-arrow' => 'left: {{VALUE}}px;',
					'{{WRAPPER}} .fm-products-carousel-2 .slick-next-arrow' => 'right: {{VALUE}}px;',
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
					'{{WRAPPER}} .fm-products-carousel-2 .slick-prev-arrow, .fm-products-carousel-2 .slick-next-arrow' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-products-carousel-2 .slick-prev-arrow, .fm-products-carousel-2 .slick-next-arrow' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-products-carousel-2 .slick-prev-arrow, .fm-products-carousel-2 .slick-next-arrow' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-products-carousel-2 .slick-prev-arrow:hover, .fm-products-carousel-2 .slick-next-arrow:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-products-carousel-2 .slick-prev-arrow:hover, .fm-products-carousel-2 .slick-next-arrow:hover' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-products-carousel-2 .slick-prev-arrow:hover, .fm-products-carousel-2 .slick-next-arrow:hover' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-products-carousel-2 .slick-dots li' => 'margin: 0 {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .fm-products-carousel-2 .slick-dots li button'        => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .fm-products-carousel-2 .slick-dots li button:before' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .fm-products-carousel-2 .slick-dots' => 'bottom: {{VALUE}}px;',
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
					'{{WRAPPER}} .fm-products-carousel-2 .slick-dots li button:before' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-products-carousel-2 .slick-dots li.slick-active button:before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .fm-products-carousel-2 .slick-dots li button:hover:before' => 'background-color: {{VALUE}};',
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

	protected function _register_lazy_load_controls() {
		// Content
		$this->start_controls_section(
			'section_lazy_load',
			[ 'label' => esc_html__( 'Lazy Load', 'farmart-addons' ) ]
		);
		$this->add_control(
			'lazy_load',
			[
				'label'        => esc_html__( 'Enable', 'farmart-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'farmart-addons' ),
				'label_off'    => esc_html__( 'No', 'farmart-addons' ),
				'default'      => '',
			]
		);
		$this->add_responsive_control(
			'lazy_load_height',
			[
				'label'     => esc_html__( 'Height', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [],
				'range'     => [
					'px' => [
						'min' => 10,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .fm-elementor-ajax-wrapper .farmart-loading-wrapper' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section(); // End

		// Style
		$this->start_controls_section(
			'section_lazy_load_style',
			[
				'label' => esc_html__( 'Lazy Load', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'loading_width',
			[
				'label'      => esc_html__( 'Loading Width', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-elementor-ajax-wrapper .farmart-loading:after' => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'loading_height',
			[
				'label'      => esc_html__( 'Loading Height', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-elementor-ajax-wrapper .farmart-loading:after' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_control(
			'loading_border_color',
			[
				'label'     => esc_html__( 'Loading Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-elementor-ajax-wrapper .farmart-loading:after' => 'border-color: {{VALUE}} transparent {{VALUE}} transparent;',
				],
				'separator' => 'before',
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Render icon box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$classes = [
			'fm-products-carousel-2 fm-elementor-product-carousel woocommerce',
			$settings['lazy_load'] == 'yes' ? '' : 'no-infinite',
			$settings['hide_icon_button'] == 'yes' ? 'hide-icon-button' : '',
			'product-type-' . $settings['product_type']
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		$is_rtl    = is_rtl();
		$direction = $is_rtl ? 'rtl' : 'ltr';
		$this->add_render_attribute( 'wrapper', 'dir', $direction );

		$this->add_render_attribute( 'wrapper', 'data-settings', wp_json_encode( Elementor::get_data_slick( $settings ) ) );
		$this->add_render_attribute( 'wrapper', 'data-type', $settings['product_type'] );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( $settings['lazy_load'] == 'yes' ) : ?>
				<?php
				// AJAX settings
				$this->add_render_attribute(
					'ajax_wrapper', 'class', [
						'fm-product-carousel-2-loading fm-elementor-ajax-wrapper'
					]
				);
				$ajax_settings = [
					'slidesToShow'        => $settings['slidesToShow'],
					'title'               => $settings['title'],
					'title_icon'          => $settings['title_icon'],
					'link_text'           => $settings['link_text'],
					'link'                => $settings['link'],
					'link_icon'           => $settings['link_icon'],
					'ids'                 => $settings['ids'],
					'product_cats'        => $settings['product_cats'],
					'product_brands'      => $settings['product_brands'],
					'product_collections' => $settings['product_collections'],
					'per_page'            => $settings['per_page'],
					'products'            => $settings['products'],
					'orderby'             => $settings['orderby'],
					'order'               => $settings['order'],
				];
				$this->add_render_attribute( 'ajax_wrapper', 'data-settings', wp_json_encode( $ajax_settings ) );
				?>
                <div <?php echo $this->get_render_attribute_string( 'ajax_wrapper' ); ?>>
                    <div class="farmart-loading-wrapper"><div class="farmart-loading"></div></div>
                </div>
			<?php else : ?>
				<?php Elementor_AjaxLoader::get_products_carousel_2( $settings ); ?>
			<?php endif; ?>
		</div>
		<?php
	}
}