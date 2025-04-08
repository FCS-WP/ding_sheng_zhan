<?php

namespace FarmartAddons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Widget_Base;
use Elementor\Controls_Stack;
use FarmartAddons\Elementor;
use FarmartAddons\Elementor_AjaxLoader;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon Box widget
 */
class Products_Tab_Carousel_3 extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'farmart-product-tab-carousel-3';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Farmart - Product Tab Carousel 3', 'farmart-addons' );
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
		$this->_register_heading_settings_controls();
		$this->_register_products_settings_controls();
		$this->_register_carousel_settings_controls();
		$this->_register_lazy_load_controls();
	}

	protected function _register_heading_settings_controls() {
		// Heading Content
		$this->start_controls_section(
			'section_heading',
			[ 'label' => esc_html__( 'Heading', 'farmart-addons' ) ]
		);

		$this->add_responsive_control(
			'header_alignment',
			[
				'label'           => esc_html__( 'Content Align', 'farmart-addons' ),
				'type'            => Controls_Manager::CHOOSE,
				'options'         => [
					'row'    => [
						'title' => esc_html__( 'Horizontal', 'farmart-addons' ),
						'icon'  => 'fa fa-ellipsis-h',
					],
					'column' => [
						'title' => esc_html__( 'Vertical', 'farmart-addons' ),
						'icon'  => 'fa fa-ellipsis-v',
					],
				],
				'desktop_default' => 'row',
				'tablet_default'  => 'row',
				'mobile_default'  => 'column',
				'toggle'          => false,
				'selectors'       => [
					'{{WRAPPER}} .fm-product-tab-carousel-3 .tabs-header' => 'flex-direction: {{VALUE}}',
				],
				'required'        => true,
			]
		);
		$this->add_responsive_control(
			'content_position',
			[
				'label'           => __( 'Vertical Align', 'farmart-addons' ),
				'type'            => Controls_Manager::SELECT,
				'options'         => [
					''              => __( 'Default', 'farmart-addons' ),
					'flex-start'    => __( 'Start', 'farmart-addons' ),
					'center'        => __( 'Center', 'farmart-addons' ),
					'flex-end'      => __( 'End', 'farmart-addons' ),
					'stretch' 		=> __( 'Stretch', 'farmart-addons' ),
					'baseline'  	=> __( 'Baseline', 'farmart-addons' ),
				],
				'desktop_default' => '',
				'tablet_default'  => 'center',
				'mobile_default'  => 'center',
				'selectors'       => [
					'{{WRAPPER}} .fm-product-tab-carousel-3 .tabs-header' => 'align-items: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'           => __( 'Horizontal Align', 'farmart-addons' ),
				'type'            => Controls_Manager::SELECT,
				'options'         => [
					''              => __( 'Default', 'farmart-addons' ),
					'flex-start'    => __( 'Start', 'farmart-addons' ),
					'center'        => __( 'Center', 'farmart-addons' ),
					'flex-end'      => __( 'End', 'farmart-addons' ),
					'space-between' => __( 'Space Between', 'farmart-addons' ),
					'space-around'  => __( 'Space Around', 'farmart-addons' ),
					'space-evenly'  => __( 'Space Evenly', 'farmart-addons' ),
				],
				'desktop_default' => '',
				'tablet_default'  => 'space-between',
				'mobile_default'  => 'space-between',
				'selectors'       => [
					'{{WRAPPER}} .fm-product-tab-carousel-3 .tabs-header' => 'justify-content: {{VALUE}}',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_heading' );
		$this->start_controls_tab(
			'tab_title',
			[
				'label' => esc_html__( 'Title', 'farmart-addons' ),
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

		$this->end_controls_tab();

		// Product Tabs

		$this->start_controls_tab(
			'tab_product_tabs',
			[
				'label' => esc_html__( 'Product Tabs', 'farmart-addons' ),
			]
		);

		$this->add_control(
			'product_tabs_source',
			[
				'label'   => esc_html__( 'Source', 'farmart-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'special_products' => esc_html__( 'Special Products', 'farmart-addons' ),
					'product_cats'     => esc_html__( 'Product Categories', 'farmart-addons' ),
				],
				'default'   => 'special_products',
				'toggle'    => false,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title', [
				'label'       => esc_html__( 'Title', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'This is heading', 'farmart-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'tab_products',
			[
				'label'   => esc_html__( 'Products', 'farmart-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'recent'       => esc_html__( 'Recent', 'farmart-addons' ),
					'featured'     => esc_html__( 'Featured', 'farmart-addons' ),
					'best_selling' => esc_html__( 'Best Selling', 'farmart-addons' ),
					'top_rated'    => esc_html__( 'Top Rated', 'farmart-addons' ),
					'sale'         => esc_html__( 'On Sale', 'farmart-addons' ),
				],
				'default' => 'recent',
				'toggle'  => false,
			]
		);

		$repeater->add_control(
			'tab_orderby',
			[
				'label'     => esc_html__( 'Order By', 'farmart-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''           => esc_html__( 'Default', 'farmart-addons' ),
					'date'       => esc_html__( 'Date', 'farmart-addons' ),
					'title'      => esc_html__( 'Title', 'farmart-addons' ),
					'menu_order' => esc_html__( 'Menu Order', 'farmart-addons' ),
					'rand'       => esc_html__( 'Random', 'farmart-addons' ),
				],
				'default'   => '',
				'toggle'    => false,
				'condition' => [
					'tab_products' => [ 'recent', 'top_rated', 'sale', 'featured' ],
				],
			]
		);

		$repeater->add_control(
			'tab_order',
			[
				'label'     => esc_html__( 'Order', 'farmart-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''     => esc_html__( 'Default', 'farmart-addons' ),
					'asc'  => esc_html__( 'Ascending', 'farmart-addons' ),
					'desc' => esc_html__( 'Descending', 'farmart-addons' ),
				],
				'default'   => '',
				'toggle'    => false,
				'condition' => [
					'tab_products' => [ 'recent', 'top_rated', 'sale', 'featured' ],
				],
			]
		);

		$this->add_control(
			'special_products_tabs',
			[
				'label'         => '',
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [
					[
						'title'        => esc_html__( 'New Arrivals', 'farmart-addons' ),
						'tab_products' => 'recent'
					],
					[
						'title'        => esc_html__( 'Best Seller', 'farmart-addons' ),
						'tab_products' => 'best_selling'
					],
					[
						'title'        => esc_html__( 'Sale', 'farmart-addons' ),
						'tab_products' => 'sale'
					]
				],
				'title_field'   => '{{{ title }}}',
				'prevent_empty' => false,
				'condition'     => [
					'product_tabs_source' => 'special_products',
				],
			]
		);

		$product_cats = Elementor::get_taxonomy();
		$repeater     = new \Elementor\Repeater();

		$repeater->add_control(
			'product_cat', [
				'label'       => esc_html__( 'Category Tab', 'farmart-addons' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => $product_cats,
				'label_block' => true,
			]
		);

		$this->add_control(
			'product_cats_tabs',
			[
				'label'         => esc_html__( 'Category Tabs', 'farmart-addons' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [ ],
				'prevent_empty' => false,
				'condition'     => [
					'product_tabs_source' => 'product_cats',
				],
				'title_field'   => '{{{ product_cat }}}',
			]
		);

		$this->end_controls_tab();

		// View All
		$this->start_controls_tab(
			'tab_view_all',
			[
				'label' => esc_html__( 'View All', 'farmart-addons' ),
			]
		);

		$this->add_control(
			'view_all',
			[
				'label'       => esc_html__( 'Text', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'All', 'farmart-addons' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'view_all_url', [
				'label'         => esc_html__( 'URL', 'farmart-addons' ),
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

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section(); // End Heading Content

		// Heading Style
		$this->start_controls_section(
			'section_heading_style',
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
					'{{WRAPPER}} .fm-product-tab-carousel-3 .tabs-header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .fm-product-tab-carousel-3 .tabs-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-tab-carousel-3 .tabs-header' => 'background-color: {{VALUE}};',
				],
				'default'   => '',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'heading_border',
				'label'    => esc_html__( 'Border', 'farmart-addons' ),
				'selector' => '{{WRAPPER}} .fm-product-tab-carousel-3 .tabs-header',
			]
		);

		$this->add_control(
			'product_tabs_heading_style_divider',
			[
				'label' => '',
				'type'  => Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'product_tab_options_line',
			[
				'label'        => __( 'Line Options', 'farmart-addons' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'farmart-addons' ),
				'label_on'     => __( 'Custom', 'farmart-addons' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'line_width',
			[
				'label'      => __( 'Width', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 5,
					],
				],
				'default'    => [],
				'selectors'  => [
					'{{WRAPPER}} .fm-product-tab-carousel-3 .header-link:after, {{WRAPPER}} .fm-product-tab-carousel-3 .tabs-nav li:after' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'line_background_color',
			[
				'label'     => __( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-product-tab-carousel-3 .header-link:after, {{WRAPPER}} .fm-product-tab-carousel-3 .tabs-nav li:after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_popover();

		$this->start_controls_tabs( 'heading_style_settings' );

		$this->start_controls_tab( 'heading_title', [ 'label' => esc_html__( 'Title', 'farmart-addons' ) ] );

		$this->add_responsive_control(
			'title_margin',
			[
				'label'      => esc_html__( 'Margin', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .fm-product-tab-carousel-3 .tabs-header .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-product-tab-carousel-3 .tabs-header .title'   => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .fm-product-tab-carousel-3 .tabs-header .title',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'tabs_title', [ 'label' => esc_html__( 'Product Tabs', 'farmart-addons' ) ] );

		$this->add_responsive_control(
			'items_spacing',
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
					'{{WRAPPER}} .fm-product-tab-carousel-3 .tabs-nav li a' => 'margin: 0 {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'product_tab_typography',
				'selector' => '{{WRAPPER}} .fm-product-tab-carousel-3 .tabs-header .tabs-nav a',
			]
		);

		$this->add_control(
			'product_tab_options',
			[
				'label'        => __( 'More Options', 'farmart-addons' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'farmart-addons' ),
				'label_on'     => __( 'Custom', 'farmart-addons' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		$this->add_control(
			'product_tab_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-product-tab-carousel-3 .tabs-header .tabs-nav li a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_tab_active_color',
			[
				'label'     => esc_html__( 'Active Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-tab-carousel-3 .tabs-header .tabs-nav li a.active' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_tab_active_border_color',
			[
				'label'     => esc_html__( 'Active Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-tab-carousel-3 .tabs-header .tabs-nav li a.active' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_popover();

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function _register_products_settings_controls() {
		// Products Content
		$this->start_controls_section(
			'section_products',
			[ 'label' => esc_html__( 'Products', 'farmart-addons' ) ]
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
					'product_tabs_source' => 'special_products',
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
					'product_tabs_source' => 'special_products',
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
						'product_tabs_source' => 'special_products',
					],
				]
			);
		}

		$this->add_control(
			'per_page',
			[
				'label'   => esc_html__( 'Total Products', 'farmart-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 12,
				'min'     => 2,
				'max'     => 50,
				'step'    => 1,
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
					'product_tabs_source' => 'product_cats',
				],
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'     => esc_html__( 'Order By', 'farmart-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''           => esc_html__( 'Default', 'farmart-addons' ),
					'date'       => esc_html__( 'Date', 'farmart-addons' ),
					'title'      => esc_html__( 'Title', 'farmart-addons' ),
					'menu_order' => esc_html__( 'Menu Order', 'farmart-addons' ),
					'rand'       => esc_html__( 'Random', 'farmart-addons' ),
				],
				'default'   => '',
				'condition' => [
					'products'            => [ 'recent', 'top_rated', 'sale', 'featured' ],
					'product_tabs_source' => 'product_cats',
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'     => esc_html__( 'Order', 'farmart-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''     => esc_html__( 'Default', 'farmart-addons' ),
					'asc'  => esc_html__( 'Ascending', 'farmart-addons' ),
					'desc' => esc_html__( 'Descending', 'farmart-addons' ),
				],
				'default'   => '',
				'condition' => [
					'products'            => [ 'recent', 'top_rated', 'sale', 'featured' ],
					'product_tabs_source' => 'product_cats',
				],
			]
		);

		$this->add_control(
			'divider_1',
			[
				'label'     => esc_html__( 'Item', 'farmart-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'product_title_length',
			[
				'label'     => esc_html__( 'Title Length', 'farmart-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'default' => esc_html__( 'Default', 'farmart-addons' ),
					'custom'  => esc_html__( '1 Line', 'farmart-addons' ),
				],
				'default'   => 'default',
				'selectors_dictionary' => [
					'custom'  => 'overflow: hidden;
									text-overflow: ellipsis;
									display: -webkit-box;
									-webkit-line-clamp: 1;
									-webkit-box-orient: vertical;
									line-height: 16px;
									max-height: 18px;',
				],
				'selectors' => [
					'{{WRAPPER}} ul.products li.product .woocommerce-loop-product__title a' => '{{VALUE}}',
				],
			]
		);

		$this->end_controls_section(); // End Product Content

		// Products Style
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_background',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-product-tab-carousel-3 .tabs-content' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-product-tab-carousel-3 .slick-slide > div:not(:last-child) li.product:after ' => 'background-color: {{VALUE}}',

				],
			]
		);

		$this->add_control(
			'divider_width',
			[
				'label'      => esc_html__( 'Height', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .fm-product-tab-carousel-3 .slick-slide > div:not(:last-child) li.product:after' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'divider_spacing',
			[
				'label'      => esc_html__( 'Horizontal Spacing', 'farmart-addons' ),
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
					'{{WRAPPER}} .fm-product-tab-carousel-3 .slick-slide > div:not(:last-child) li.product:after' => 'left: {{SIZE}}{{UNIT}};right: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .fm-product-tab-carousel-3 .tabs-content' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'border_color',
			[
				'label'     => esc_html__( 'Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-tab-carousel-3 .tabs-content' => 'border-color: {{VALUE}}',

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
					'{{WRAPPER}} .fm-product-tab-carousel-3 .tabs-content' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_popover();

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => esc_html__( 'Content Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .fm-product-tab-carousel-3 ul.products' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'products_list_padding',
			[
				'label'     => esc_html__( 'Padding Content List', 'farmart-addons' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .fm-product-tab-carousel-3 .slick-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .fm-product-tab-carousel-3 .slick-list' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'section_item',
			[
				'label'   => esc_html__( 'Item', 'farmart-addons' ),
				'type'    => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'content_item_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .fm-product-tab-carousel-3 li.product .product-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'item_sep',
			[
				'label'     => __( 'Separator', 'farmart-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'farmart-addons' ),
				'label_on'  => __( 'Show', 'farmart-addons' ),
				'default'   => 'yes',
				'selectors_dictionary' => [
					'' => 'display: none',
				],
				'selectors' => [
					'{{WRAPPER}} .fm-product-tab-carousel-3 .slick-slide > div:not(:last-child) li.product:after' => '{{VALUE}}',
				],
			]
		);

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
				'default' => 3,
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
			'rows',
			[
				'label'   => esc_html__( 'Rows', 'farmart-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 5,
				'default' => 3,
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
				'step'        => 50,
				'description' => esc_html__( 'Slide animation speed (in ms)', 'farmart-addons' ),
			]
		);

		// Additional Settings
		$this->_register_responsive_settings_controls();

		$this->end_controls_section();

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
		$this->add_responsive_control(
			'sliders_arrows_size',
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
					'{{WRAPPER}} .fm-product-tab-carousel-3 .slick-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .fm-product-tab-carousel-3 .slick-arrow' => 'width: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .fm-product-tab-carousel-3 .slick-arrow' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .fm-product-tab-carousel-3 .slick-prev-arrow' => 'left: {{VALUE}}px;',
					'{{WRAPPER}} .fm-product-tab-carousel-3 .slick-next-arrow' => 'right: {{VALUE}}px;',
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
					'{{WRAPPER}} .fm-product-tab-carousel-3 .slick-prev-arrow, .fm-product-tab-carousel-3 .slick-next-arrow' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-product-tab-carousel-3 .slick-prev-arrow, .fm-product-tab-carousel-3 .slick-next-arrow' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-product-tab-carousel-3 .slick-prev-arrow, .fm-product-tab-carousel-3 .slick-next-arrow' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-product-tab-carousel-3 .slick-prev-arrow:hover, .fm-product-tab-carousel-3 .slick-next-arrow:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-product-tab-carousel-3 .slick-prev-arrow:hover, .fm-product-tab-carousel-3 .slick-next-arrow:hover' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-product-tab-carousel-3 .slick-prev-arrow:hover, .fm-product-tab-carousel-3 .slick-next-arrow:hover' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-product-tab-carousel-3 .slick-dots li' => 'margin: 0 {{SIZE}}{{UNIT}};',
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
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-product-tab-carousel-3 .slick-dots li button'        => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .fm-product-tab-carousel-3 .slick-dots li button:before' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .fm-product-tab-carousel-3 .slick-dots' => 'bottom: {{VALUE}}px;',
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
					'{{WRAPPER}} .fm-product-tab-carousel-3 .slick-dots li button:before' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-product-tab-carousel-3 .slick-dots li.slick-active button:before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .fm-product-tab-carousel-3 .slick-dots li button:hover:before' => 'background-color: {{VALUE}};',
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
			'responsive_rows',
			[
				'label'           => esc_html__( 'Rows', 'farmart-addons' ),
				'type'            => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 5,
				'default' => 3,
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
	 * Lazy Load
	 */
	protected function _register_lazy_load_controls() {
		// Content
		$this->start_controls_section(
			'section_lazy_load',
			[
				'label' => esc_html__( 'Lazy Load', 'farmart-addons' )
			]
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
			'fm-product-tab-carousel-3',
			'fm-elementor-product-carousel',
			'farmart-tabs woocommerce',
			$settings['lazy_load'] == 'yes' ? '' : 'no-infinite',
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );
		$this->add_render_attribute( 'wrapper', 'data-settings', wp_json_encode( Elementor::get_data_slick( $settings ) ) );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( $settings['lazy_load'] == 'yes' ) : ?>
				<?php
				// AJAX settings
				$this->add_render_attribute(
					'ajax_wrapper', 'class', [
						'fm-product-tab-carousel-3-loading fm-elementor-ajax-wrapper'
					]
				);
				$ajax_settings = [
					'lazy_load'             => $settings['lazy_load'],
					'title'                 => $settings['title'],
					'view_all'              => $settings['view_all'],
					'view_all_url'          => $settings['view_all_url'],
					'product_tabs_source'   => $settings['product_tabs_source'],
					'special_products_tabs' => $settings['special_products_tabs'],
					'product_cats_tabs'     => $settings['product_cats_tabs'],
					'slidesToShow'          => $settings['slidesToShow'],
					'products'              => $settings['products'],
					'product_cats'          => $settings['product_cats'],
					'product_brands'        => $settings['product_brands'],
					'product_collections'   => $settings['product_collections'],
					'per_page'              => $settings['per_page'],
					'orderby'               => $settings['orderby'],
					'order'                 => $settings['order'],
				];
				$this->add_render_attribute( 'ajax_wrapper', 'data-settings', wp_json_encode( $ajax_settings ) );
				?>
                <div <?php echo $this->get_render_attribute_string( 'ajax_wrapper' ); ?>>
                    <div class="farmart-loading-wrapper"><div class="farmart-loading"></div></div>
                </div>
			<?php else : ?>
				<?php Elementor_AjaxLoader::get_products_tab_carousel( $settings ); ?>
			<?php endif; ?>
		</div>
		<?php
	}
}