<?php

namespace FarmartAddons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Widget_Base;
use FarmartAddons\Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon Box widget
 */
class Trending_Search_Carousel extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'farmart-trending-search-carousel';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Farmart - Trending Search Carousel', 'farmart-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-search';
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
		$this->_register_content_settings_controls();
		$this->_register_carousel_settings_controls();
	}

	protected function _register_heading_settings_controls() {
		// Heading Content
		$this->start_controls_section(
			'heading_content',
			[ 'label' => esc_html__( 'Heading', 'farmart-addons' ) ]
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
				'placeholder' => [
					'top'    => '35',
					'right'  => '20',
					'bottom' => '5',
					'left'   => '20',
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-trending-search-carousel .trending-search__header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'heading_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-trending-search-carousel .trending-search__header' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'heading_border',
				'label'    => __( 'Border', 'farmart-addons' ),
				'selector' => '{{WRAPPER}} .fm-trending-search-carousel .trending-search__header',
			]
		);

		$this->add_control(
			'heading_title_style',
			[
				'label'     => __( 'Title', 'farmart-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .fm-trending-search-carousel .trending-search__header h2',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-trending-search-carousel .trending-search__header h2' => 'color: {{VALUE}};',
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
					'{{WRAPPER}}  .fm-trending-search-carousel .trending-search__header h2 .farmart-svg-icon' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .fm-trending-search-carousel .trending-search__header h2 .farmart-svg-icon' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .fm-trending-search-carousel .trending-search__header h2 .farmart-svg-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_popover();

		$this->end_controls_section(); // End Heading Style
	}

	protected function _register_content_settings_controls() {
		// Content Settings
		$this->start_controls_section(
			'content_settings',
			[ 'label' => esc_html__( 'Content', 'farmart-addons' ) ]
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
			'number',
			[
				'label'       => esc_html__( 'Number to show', 'farmart-addons' ),
				'description' => esc_html__( 'Set 0 to show all', 'farmart-addons' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 18,
				'condition'   => [
					'source' => 'default',
				],
			]
		);
		$this->add_control(
			'orderby',
			[
				'label'       => esc_html__( 'Order by', 'farmart-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'name'  => esc_html__( 'Name', 'farmart-addons' ),
					'id'    => esc_html__( 'ID', 'farmart-addons' ),
					'count' => esc_html__( 'Count', 'farmart-addons' ),
				],
				'default'     => 'name',
				'label_block' => true,
				'condition'   => [
					'source' => 'default',
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'       => esc_html__( 'Order', 'farmart-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'ASC'  => esc_html__( 'ASC', 'farmart-addons' ),
					'DESC' => esc_html__( 'DESC', 'farmart-addons' ),
				],
				'default'     => 'ASC',
				'label_block' => true,
				'condition'   => [
					'source' => 'default',
				],
			]
		);

		$this->add_control(
			'product_collection',
			[
				'label'       => esc_html__( 'Product Collection', 'farmart-addons' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'farmart-addons' ),
				'type'        => 'fmautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_collection',
				'sortable'    => true,
				'condition'   => [
					'source' => 'custom',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'label' => esc_html__( 'Collection Image Size', 'farmart-addons' ),
				'name'      => 'image',
				// Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default'   => 'full',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'unit',
			[
				'label'       => esc_html__( 'Unit', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '#',
				'description' => esc_html__( 'Unit next to item name', 'farmart-addons' ),
				'label_block' => true,
				'separator'   => 'before',
			]
		);
		$this->end_controls_section(); // End Heading Content

		// Content Style
		$this->start_controls_section(
			'content_style',
			[
				'label' => esc_html__( 'Content', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'content_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-trending-search-carousel .trending-search__content' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'placeholder' => [
					'top'    => '20',
					'right'  => '20',
					'bottom' => '20',
					'left'   => '20',
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-trending-search-carousel .trending-search__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'content_border',
				'label'    => __( 'Border', 'farmart-addons' ),
				'selector' => '{{WRAPPER}} .fm-trending-search-carousel .trending-search__content',
			]
		);
		$this->add_control(
			'content_item_style',
			[
				'label'     => __( 'Items', 'farmart-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'content_item_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'placeholder' => [
					'top'    => '10',
					'right'  => '',
					'bottom' => '10',
					'left'   => '',
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-trending-search-carousel ul.collection-list a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'item_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-trending-search-carousel ul.collection-list a:hover .thumb' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_divider_color',
			[
				'label'     => esc_html__( 'Divider Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-trending-search-carousel .slick-slide > div li' => 'border-top-color: {{VALUE}};',
				],
			]
		);

		// Tabs
		$this->start_controls_tabs( 'item_style_tabs' );

		$this->start_controls_tab(
			'item_name_style',
			[
				'label' => __( 'Name', 'farmart-addons' ),
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_name_typography',
				'selector' => '{{WRAPPER}} .fm-trending-search-carousel ul.collection-list .collection-item__name',
			]
		);
		$this->add_control(
			'item_name_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-trending-search-carousel ul.collection-list .collection-item__name' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'item_name_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-trending-search-carousel ul.collection-list a:hover .collection-item__name' => 'color: {{VALUE}};box-shadow: inset 0 0 0 transparent, inset 0 -1px 0 {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'item_count_style',
			[
				'label' => __( 'Count', 'farmart-addons' ),
			]
		);
		$this->add_control(
			'count',
			[
				'label'     => __( 'Count', 'farmart-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'farmart-addons' ),
				'label_on'  => __( 'On', 'farmart-addons' ),
				'default'   => 'yes'
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_count_typography',
				'selector' => '{{WRAPPER}} .fm-trending-search-carousel ul.collection-list .collection-item__count',
			]
		);
		$this->add_control(
			'item_count_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-trending-search-carousel ul.collection-list .collection-item__count' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'item_count_spacing',
			[
				'label'     => __( 'Spacing', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .fm-trending-search-carousel ul.collection-list .collection-item__count' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function _register_carousel_settings_controls() {
		// Carousel Settings
		$this->start_controls_section(
			'section_carousel_settings',
			[ 'label' => esc_html__( 'Carousel Settings', 'farmart-addons' ) ]
		);
		$this->add_control(
			'slidesToShow',
			[
				'label'   => esc_html__( 'Slides to show', 'farmart-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 7,
				'default' => 1,
			]
		);
		$this->add_control(
			'slidesToScroll',
			[
				'label'   => esc_html__( 'Slides to scroll', 'farmart-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 7,
				'default' => 1,
			]
		);
		$this->add_control(
			'rows',
			[
				'label'           => esc_html__( 'Rows', 'farmart-addons' ),
				'type'            => Controls_Manager::NUMBER,
				'min'             => 1,
				'max'             => 10,
				'default' => 5,
			]
		);
		$this->add_control(
			'navigation',
			[
				'label'           => esc_html__( 'Navigation', 'farmart-addons' ),
				'type'            => Controls_Manager::SELECT,
				'options'         => [
					'both'   => esc_html__( 'Arrows and Dots', 'farmart-addons' ),
					'arrows' => esc_html__( 'Arrows', 'farmart-addons' ),
					'dots'   => esc_html__( 'Dots', 'farmart-addons' ),
					'none'   => esc_html__( 'None', 'farmart-addons' ),
				],
				'default' => 'arrows',
				'toggle'          => false,
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

		//Responsive Settings
		$this->_register_responsive_settings_controls();

		$this->end_controls_section(); // End Carousel Settings

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
					'{{WRAPPER}} .fm-trending-search-carousel .slick-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .fm-trending-search-carousel .slick-arrow' => 'width: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .fm-trending-search-carousel .slick-arrow' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_popover();

		$this->start_controls_tabs( 'sliders_normal_settings' );

		$this->start_controls_tab( 'sliders_normal', [ 'label' => esc_html__( 'Normal', 'farmart-addons' ) ] );
		$this->add_control(
			'sliders_arrow_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-trending-search-carousel .slick-prev-arrow, .fm-trending-search-carousel .slick-next-arrow' => 'color: {{VALUE}};',
				],
			]
		);
		// $this->add_control(
		// 	'sliders_arrow_background',
		// 	[
		// 		'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
		// 		'type'      => Controls_Manager::COLOR,
		// 		'default'   => '',
		// 		'selectors' => [
		// 			'{{WRAPPER}} .fm-trending-search-carousel .slick-prev-arrow, .fm-trending-search-carousel .slick-next-arrow' => 'background-color: {{VALUE}};',
		// 		],
		// 	]
		// );
		// $this->add_control(
		// 	'sliders_arrow_border_color',
		// 	[
		// 		'label'     => esc_html__( 'Border Color', 'farmart-addons' ),
		// 		'type'      => Controls_Manager::COLOR,
		// 		'default'   => '',
		// 		'selectors' => [
		// 			'{{WRAPPER}} .fm-trending-search-carousel .slick-prev-arrow, .fm-trending-search-carousel .slick-next-arrow' => 'border-color: {{VALUE}};',
		// 		],
		// 	]
		// );

		$this->end_controls_tab();

		$this->start_controls_tab( 'sliders_hover', [ 'label' => esc_html__( 'Hover', 'farmart-addons' ) ] );
		$this->add_control(
			'sliders_arrow_hover_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-trending-search-carousel .slick-prev-arrow:hover, .fm-trending-search-carousel .slick-next-arrow:hover' => 'color: {{VALUE}};',
				],
			]
		);

		// $this->add_control(
		// 	'sliders_arrow_hover_background',
		// 	[
		// 		'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
		// 		'type'      => Controls_Manager::COLOR,
		// 		'default'   => '',
		// 		'selectors' => [
		// 			'{{WRAPPER}} .fm-trending-search-carousel .slick-prev-arrow:hover, .fm-trending-search-carousel .slick-next-arrow:hover' => 'background-color: {{VALUE}};',
		// 		],
		// 	]
		// );
		// $this->add_control(
		// 	'sliders_arrow_hover_border_color',
		// 	[
		// 		'label'     => esc_html__( 'Border Color', 'farmart-addons' ),
		// 		'type'      => Controls_Manager::COLOR,
		// 		'default'   => '',
		// 		'selectors' => [
		// 			'{{WRAPPER}} .fm-trending-search-carousel .slick-prev-arrow:hover, .fm-trending-search-carousel .slick-next-arrow:hover' => 'border-color: {{VALUE}};',
		// 		],
		// 	]
		// );

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
					'{{WRAPPER}} .fm-trending-search-carousel .slick-dots li' => 'margin: 0 {{SIZE}}{{UNIT}};',
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
						'max' => 50,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-trending-search-carousel .slick-dots li button'        => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .fm-trending-search-carousel .slick-dots li button:before' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}}',
				],
				'separator'  => 'before',
			]
		);
		$this->add_responsive_control(
			'sliders_dots_offset',
			[
				'label'      => esc_html__( 'Margin', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'allowed_dimensions' => 'vertical',
				'size_units' => [ 'px', 'em', '%' ],
				'placeholder' => [
					'top'    => '25',
					'right'  => esc_html__( 'Auto', 'farmart-addons' ),
					'bottom' => '25',
					'left'   => esc_html__( 'Auto', 'farmart-addons' )
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-trending-search-carousel .slick-dots' => 'margin-top: {{TOP}}{{UNIT}};margin-bottom:{{BOTTOM}}{{UNIT}};',
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
					'{{WRAPPER}} .fm-trending-search-carousel .slick-dots li button:before' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-trending-search-carousel .slick-dots li.slick-active button:before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .fm-trending-search-carousel .slick-dots li button:hover:before'        => 'background-color: {{VALUE}};',
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
				'label' => __( 'Responsive Settings', 'farmart-addons' ),
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
				'min'             => 1,
				'max'             => 10,
				'default' => 5,
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
				'default' => [],
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
			'fm-trending-search-carousel farmart-elementor-trending-search-carousel',
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		$icon = '';
		if ( $settings['title_icon'] && ! empty( $settings['title_icon']['value'] ) && \Elementor\Icons_Manager::is_migration_allowed() ) {
			ob_start();
			\Elementor\Icons_Manager::render_icon( $settings['title_icon'], [ 'aria-hidden' => 'true' ] );
			$icon = '<span class="farmart-svg-icon">' . ob_get_clean() . '</span>';
		}

		if( empty( $icon ) ) {
			$icon = '<span class="farmart-svg-icon"><svg viewBox="0 0 32 32"><path d="M8 32c-0.205 0-0.409-0.078-0.566-0.234-0.312-0.312-0.312-0.819 0-1.131l13.834-13.834-13.834-13.834c-0.312-0.312-0.312-0.819 0-1.131s0.819-0.312 1.131 0l14.4 14.4c0.312 0.312 0.312 0.819 0 1.131l-14.4 14.4c-0.156 0.156-0.361 0.234-0.566 0.234z"></path></svg></span>';
		}

		$title = $settings['title'] ? sprintf( '<h2>%s%s</h2>', $icon, $settings['title'] ) : '';

		$args = [
			'taxonomy' => 'product_collection',
		];

		$source = $settings['source'];

		if ( $source == 'default' ) {
			$args['orderby'] = $settings['orderby'];
			$args['order']   = $settings['order'];
			$args['number']  = $settings['number'];

		} else {
			$cats            = explode( ',', $settings['product_collection'] );
			$args['slug']    = $cats;
			$args['orderby'] = 'slug__in';
		}

		$terms = get_terms( $args );

		if ( is_wp_error( $terms ) || ! $terms ) {
			return;
		}

		$this->add_render_attribute( 'slides-wrapper', 'class', [ 'collection-list' ] );
		$this->add_render_attribute( 'slides-wrapper', 'data-slick', wp_json_encode( Elementor::get_data_slick( $settings ) ) );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div class="trending-search__header">
				<?php echo $title; ?>
				<div class="slick-arrows-wrapper"></div>
			</div>
			<div class="trending-search__content">
				<ul <?php echo $this->get_render_attribute_string( 'slides-wrapper' ); ?>>
					<?php
					foreach ( $terms as $term ) {
						$thumbnail_id = absint( get_term_meta( $term->term_id, 'collection_thumbnail_id', true ) );
						$count        = $unit = '';

						if ( $settings['count'] == 'yes' ) {
							$count = '<span class="collection-item__count">' . sprintf( _n( '%s Item', '%s Items', $term->count, 'farmart-addons' ), number_format_i18n( $term->count ) ) . '</span>';
						}

						if ( $settings['unit'] ) {
							$unit = '<span class="unit">' . $settings['unit'] . '</span>';
						}

						// Image Size
						if ( $settings['image_size'] != 'custom' ) {
							$image_size = $settings['image_size'];
						} else {
							$image_size = [
								$settings['image_custom_dimension']['width'],
								$settings['image_custom_dimension']['height'],
							];
						}

						echo sprintf(
							'<li class="collection-item">
								<a href="%s">
									<span class="thumb">%s</span>
									<span class="info">
										<span class="collection-item__name">%s%s</span>
										%s
									</span>
								</a>
							</li>',
							esc_url( get_term_link( $term->term_id, 'product_collection' ) ),
							wp_get_attachment_image( $thumbnail_id, $image_size ),
							$unit,
							esc_html( $term->name ),
							$count
						);
					}
					?>
				</ul>
			</div>
		</div>
		<?php
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
	protected function get_link_control( $link_key, $url, $content, $attr = [ ] ) {
		$attr_default = [ ];
		if ( isset( $url['url'] ) && $url['url'] ) {
			$attr_default['href'] = $url['url'];
		}

		if ( isset( $url['is_external'] ) && $url['is_external'] ) {
			$attr_default['target'] = '_blank';
		}

		if ( isset( $url['nofollow'] ) && $url['nofollow'] ) {
			$attr_default['rel'] = 'nofollow';
		}

		$tag = 'a';

		if ( empty( $attr_default['href'] ) ) {
			$tag = 'span';
		}

		$attr = wp_parse_args( $attr, $attr_default );

		$this->add_render_attribute( $link_key, $attr );

		return sprintf( '<%1$s %2$s>%3$s</%1$s>', $tag, $this->get_render_attribute_string( $link_key ), $content );
	}
}