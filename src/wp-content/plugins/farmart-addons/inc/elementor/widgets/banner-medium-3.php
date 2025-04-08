<?php

namespace FarmartAddons\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Banner Medium widget
 */
class Banner_Medium_3 extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'farmart-banner-medium-3';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Farmart - Banner Medium', 'farmart-addons' );
	}


	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-banner';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'farmart' ];
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

	// Tab Content
	protected function section_content() {
		$this->section_content_banner();
	}

	protected function section_content_banner() {
		$this->start_controls_section(
			'section_banner',
			[ 'label' => esc_html__( 'Content', 'farmart-addons' ) ]
		);

		$this->add_responsive_control(
			'height',
			[
				'label'     => esc_html__( 'Height', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [],
				'range'     => [
					'px' => [
						'min' => 100,
						'max' => 600,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-banner-medium-3 .banner-content' => 'height: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'elements',
			[
				'label' => esc_html__( 'Elements', 'farmart-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'banner_content_settings' );

		$this->start_controls_tab( 'content_text', [ 'label' => esc_html__( 'Text', 'farmart-addons' ) ] );

		$this->add_control(
			'highlight',
			[
				'label'       => esc_html__( 'Highlight', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'This is the highlight', 'farmart-addons' ),
				'placeholder' => esc_html__( 'Enter your highlight', 'farmart-addons' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'after_highlight',
			[
				'label'       => esc_html__( 'After Highlight', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Enter your after highlight', 'farmart-addons' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'position_highlight',
			[
				'label'       => esc_html__( 'Highlight Position', 'farmart-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'above' => esc_html__( 'Above the title', 'farmart-addons' ),
					'under' => esc_html__( 'Under the title', 'farmart-addons' ),
				],
				'default'   => 'above',
				'label_block' => true,
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter your text', 'farmart-addons' ),
				'label_block' => true,
				'default'     => __( 'This is the title', 'farmart-addons' ),
			]
		);

		$this->add_control(
			'desc',
			[
				'label'       => esc_html__( 'Description', 'farmart-addons' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => __( 'This is the desc', 'farmart-addons' ),
				'placeholder' => esc_html__( 'Enter your description', 'farmart-addons' ),
				'label_block' => true,
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'content_btn', [ 'label' => esc_html__( 'Button', 'farmart-addons' ) ] );

		$this->add_control(
			'button_text', [
				'label'         => esc_html__( 'Button Text', 'farmart-addons' ),
				'type'          => Controls_Manager::TEXT,
				'show_external' => true,
				'default'       => esc_html__( 'Shop Now', 'farmart-addons' ),
			]
		);

		$this->add_control(
			'button_link', [
				'label'         => esc_html__( 'Link URL', 'farmart-addons' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'farmart-addons' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'content_sale', [ 'label' => esc_html__( 'Sale', 'farmart-addons' ) ] );

		$this->add_control(
			'price_box',
			[
				'label'       => esc_html__( 'Price Box', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your content', 'farmart-addons' ),
				'label_block' => true,
				'default'     => __( '-25%', 'farmart-addons' ),
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'background', [ 'label' => esc_html__( 'Background', 'farmart-addons' ) ] );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'banners_background',
				'label'    => __( 'Background', 'farmart-addons' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .farmart-banner-medium-3 .banner-featured-image',
				'fields_options'  => [
					'background' => [
						'default' => 'classic',
					],
					'image' => [
						'default'   => [
							'url' => 'https://via.placeholder.com/1170X240/3d2a28?text=600x240+Image',
						],
					],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	// Tab Style
	protected function section_style(){
		$this->section_style_banner();
		$this->section_style_title();
		$this->section_style_button();
		$this->section_style_sale();
	}

	protected function section_style_banner(){
		// Banner
		$this->start_controls_section(
			'section_style_banner',
			[
				'label' => esc_html__( 'Content', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_max_width',
			[
				'label'          => esc_html__( 'Content Width', 'farmart-addons' ),
				'type'           => Controls_Manager::SLIDER,
				'range'          => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units'     => [ '%', 'px' ],
				'default'        => [],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'selectors'      => [
					'{{WRAPPER}} .farmart-banner-medium-3 .banner-content' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'banner_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-banner-medium-3 .banner-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'banner_horizontal_position',
			[
				'label'        => esc_html__( 'Horizontal Position', 'farmart-addons' ),
				'type'         => Controls_Manager::CHOOSE,
				'label_block'  => false,
				'default'      => '',
				'options'      => [
					'left'   => [
						'title' => esc_html__( 'Left', 'farmart-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'farmart-addons' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'farmart-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'farmart--h-position-',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'banner_vertical_position',
			[
				'label'        => esc_html__( 'Vertical Position', 'farmart-addons' ),
				'type'         => Controls_Manager::CHOOSE,
				'label_block'  => false,
				'default'      => 'middle',
				'options'      => [
					'top'    => [
						'title' => esc_html__( 'Top', 'farmart-addons' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => esc_html__( 'Middle', 'farmart-addons' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'farmart-addons' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'prefix_class' => 'farmart--v-position-',
			]
		);

		$this->add_responsive_control(
			'banner_text_align',
			[
				'label'       => esc_html__( 'Text Align', 'farmart-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'left'   => [
						'title' => esc_html__( 'Left', 'farmart-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'farmart-addons' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'farmart-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .farmart-banner-medium-3 .banner-content' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'banner_border_radius',
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
					'{{WRAPPER}} .farmart-banner-medium-3 .banner-content' => 'border-radius: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .farmart-banner-medium-3 .banner-featured-image' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function section_style_title(){

		// Title
		$this->start_controls_section(
			'section_style_title',
			[
				'label' => esc_html__( 'Text', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'style_text' );

		$this->start_controls_tab( 'hightlight_text', [ 'label' => esc_html__( 'Hightlight', 'farmart-addons' ) ] );

		$this->add_responsive_control(
			'hightlight_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'  => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .farmart-banner-medium-3 .highlight' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'hightlight_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-banner-medium-3 .highlight' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'hightlight_typography',
				'selector' => '{{WRAPPER}} .farmart-banner-medium-3 .highlight',
			]
		);

		$this->add_control(
			'after_hightlight_heading',
			[
				'label'     => esc_html__( 'After Hightlight', 'farmart-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'after_hightlight_position',
			[
				'label'              => esc_html__( 'Position ', 'farmart-addons' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px', '%' ],
				'default'            => [],
				'selectors'          => [
					'{{WRAPPER}} .farmart-banner-medium-3 .after_highlight' => 'position:relative; top:{{TOP}}{{UNIT}};right: {{RIGHT}}{{UNIT}};bottom:{{BOTTOM}}{{UNIT}};left: {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'after_hightlight_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-banner-medium-3 .after_highlight' => 'color: {{VALUE}}; text-shadow: 0 0 {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'after_hightlight_typography',
				'selector' => '{{WRAPPER}} .farmart-banner-medium-3 .after_highlight',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'title_text', [ 'label' => esc_html__( 'Title', 'farmart-addons' ) ] );

		$this->add_responsive_control(
			'heading_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'  => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .farmart-banner-medium-3 .banner-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-banner-medium-3 .banner-title' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .farmart-banner-medium-3 .banner-title',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'desc_text', [ 'label' => esc_html__( 'Desc', 'farmart-addons' ) ] );

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-banner-medium-3 .banner-desc' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .farmart-banner-medium-3 .banner-desc',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();



		$this->end_controls_section();
	}

	protected function section_style_sale(){

		// Title
		$this->start_controls_section(
			'section_style_sale',
			[
				'label' => esc_html__( 'Sale', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'price_box_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-banner-medium-3 .price-box' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_control(
			'price_box_bkcolor',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-banner-medium-3 .price-box' => 'background-color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'price_box_typography',
				'selector' => '{{WRAPPER}} .farmart-banner-medium-3 .price-box',
			]
		);

		$this->add_responsive_control(
			'price_box_position_left',
			[
				'label'              => esc_html__( 'Position ', 'farmart-addons' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px', '%' ],
				'default'            => [],
				'selectors'          => [
					'{{WRAPPER}} .farmart-banner-medium-3 .price-box' => ' top:{{TOP}}{{UNIT}};right: {{RIGHT}}{{UNIT}};bottom:{{BOTTOM}}{{UNIT}};left: {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'price_box_width',
			[
				'label'      => esc_html__( 'Width', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-banner-medium-3 .price-box' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'price_box_height',
			[
				'label'      => esc_html__( 'Height', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-banner-medium-3 .price-box' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function section_style_button(){
		// Button
		$this->start_controls_section(
			'section_style_button',
			[
				'label' => esc_html__( 'Button', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'btn_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-banner-medium-3 .btn-button' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-banner-medium-3 .btn-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .farmart-banner-medium-3 .btn-button',
			]
		);

		$this->add_control(
			'btn_border',
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
			'button_border_style',
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
					'{{WRAPPER}} .farmart-banner-medium-3 .banner-button .btn-button' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_border_width',
			[
				'label'     => esc_html__( 'Border Width', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-banner-medium-3 .banner-button .btn-button' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_border_radius',
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
					'{{WRAPPER}} .farmart-banner-medium-3 .banner-button .btn-button' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);

		$this->end_popover();

		$this->start_controls_tabs( 'button_tabs' );

		$this->start_controls_tab( 'normal', [ 'label' => esc_html__( 'Normal', 'farmart-addons' ) ] );

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-banner-medium-3 .btn-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-banner-medium-3 .btn-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-banner-medium-3 .btn-button' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover', [ 'label' => esc_html__( 'Hover', 'farmart-addons' ) ] );

		$this->add_control(
			'button_hover_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-banner-medium-3 .btn-button:hover' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_control(
			'button_hover_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-banner-medium-3 .btn-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-banner-medium-3 .btn-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'style_icon',
			[
				'label'     => esc_html__( 'Icon', 'farmart-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'icon_button',
			[
				'label'        => esc_html__( 'Show Icon', 'farmart-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			]
		);
		$this->add_control(
			'icon',
			[
				'label'     => esc_html__( 'Icon', 'farmart-addons' ),
				'type'      => Controls_Manager::ICONS,
				'default'          => [
					'value'   => 'icon-chevron-right',
					'library' => 'linearicons',
				],
				'condition' => [
					'icon_button' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'icon_spacing',
			[
				'label'     => esc_html__( 'Icon Spacing', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
						'min' => 0,
					],
				],
				'default'   => [],
				'selectors' => [
					'{{WRAPPER}}  .farmart-banner-medium-3 .farmart-svg-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'icon_button' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'icon_font_size',
			[
				'label'     => esc_html__( 'Font Size', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [],
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-banner-medium-3 .farmart-svg-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .farmart-banner-medium-3 .farmart-svg-icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'icon_button' => 'yes',
				],
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

		$this->add_render_attribute( 'wrapper', 'class', [
			'farmart-banner-medium-3',
		] );

		if ( $settings['button_link']['is_external'] ) {
			$this->add_render_attribute( 'link', 'target', '_blank' );
		}

		if ( $settings['button_link']['nofollow'] ) {
			$this->add_render_attribute( 'link', 'rel', 'nofollow' );
		}

		if ( $settings['button_link']['url'] ) {
			$this->add_render_attribute( 'link', 'href', $settings['button_link']['url'] );
		}

		$class_hightlight = $settings['after_highlight'] ? 'banner-display' : '';
		$title = $settings['title'] ? sprintf('<h3 class="banner-title">%s</h3>',$settings['title']) : '';
		$after_highlight    = $settings['after_highlight'] ? sprintf('<span class="after_highlight">%s</span>',$settings['after_highlight']) : '';
		$bf_unit    		= $settings['highlight'] ? sprintf('<span class="highlight %s">%s</span>',$class_hightlight, $settings['highlight']) : '';
		$bf_unit			= $bf_unit . $after_highlight;

		$box_title = $settings['position_highlight'] == 'above' ? $bf_unit.$title : $title.$bf_unit ;
		$desc = $settings['desc'] ? sprintf('<div class="banner-desc">%s</div>',$settings['desc']) : '';

		$html_text =  $bf_unit == '' && $title == ''&& $desc == ''? '' : sprintf('%s %s</div>',$box_title,$desc);

		$box_sale = $settings['price_box'] ? sprintf('<div class="price-box">%s</div>',$settings['price_box']) : '';

		$icon = '';
		if ( $settings['icon_button'] == 'yes' ) {
			if ( $settings['icon'] && \Elementor\Icons_Manager::is_migration_allowed() ) {
				ob_start();
				\Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
				$icon_svg = ob_get_clean();
				if( $icon_svg ) {
					$icon = '<span class="farmart-svg-icon">' . $icon_svg . '</span>';
				}
			}

			if( empty( $icon ) ) {
				$icon = '<span class="farmart-svg-icon"><svg viewBox="0 0 32 32"><path d="M8 32c-0.205 0-0.409-0.078-0.566-0.234-0.312-0.312-0.312-0.819 0-1.131l13.834-13.834-13.834-13.834c-0.312-0.312-0.312-0.819 0-1.131s0.819-0.312 1.131 0l14.4 14.4c0.312 0.312 0.312 0.819 0 1.131l-14.4 14.4c-0.156 0.156-0.361 0.234-0.566 0.234z"></path></svg></span>';
			}
		}
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div class="banner-featured-image"></div>
			<?php if ( $settings['button_link']['url'] ) : ?>
				<a class="link" <?php echo $this->get_render_attribute_string( 'link' ); ?>></a>
			<?php endif; ?>
			<div class="banner-content">
				<?php echo $box_sale?>
				<div class="banner-content__inner">
				<?php echo $box_title.$desc?>
				<?php if ( ! empty( $settings['button_text'] ) ) : ?>
					<a class="btn-button" <?php echo $this->get_render_attribute_string( 'link' ); ?>><?php echo $settings['button_text'].$icon; ?></a>
				<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}
}