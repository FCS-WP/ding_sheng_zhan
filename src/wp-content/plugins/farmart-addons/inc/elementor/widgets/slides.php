<?php

namespace FarmartAddons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon Box widget
 */
class Slides extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'farmart-slides';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Farmart - Slides', 'farmart-addons' );
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
		$this->section_content();
		$this->section_style();
	}

	// Tab Content
	protected function section_content() {
		$this->section_content_slides();
		$this->section_content_option();
	}

	protected function section_content_slides() {
		$this->start_controls_section(
			'section_slides',
			[
				'label' => esc_html__( 'Slides', 'farmart-addons' ),
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->start_controls_tabs( 'slides_repeater' );

		$repeater->start_controls_tab( 'background', [ 'label' => esc_html__( 'Background', 'farmart-addons' ) ] );

		$repeater->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'banners_background',
				'label'    => __( 'Background', 'farmart-addons' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .farmart-slides {{CURRENT_ITEM}} .slick-slide-bg',
				'fields_options'  => [
					'background' => [
						'default' => 'classic',
					],
					'color' => [
						'default'   => '#f5f5f5',
					],
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'content', [ 'label' => esc_html__( 'Content', 'farmart-addons' ) ] );

		$repeater->add_control(
			'subtitle',
			[
				'label'       => esc_html__( 'Subtitle', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Slide Subtitle', 'farmart-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'heading',
			[
				'label'       => esc_html__( 'Title', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Slide Heading', 'farmart-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'description',
			[
				'label'   => esc_html__( 'Description', 'farmart-addons' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'I am slide content. Click edit button to change this text.
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'farmart-addons' ),
			]
		);

		$repeater->add_control(
			'button_text',
			[
				'label'   => esc_html__( 'Button Text', 'farmart-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Click Here', 'farmart-addons' ),
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'       => esc_html__( 'Link', 'farmart-addons' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'farmart-addons' ),
			]
		);

		$repeater->add_control(
			'link_click',
			[
				'label'      => esc_html__( 'Apply Link On', 'farmart-addons' ),
				'type'       => Controls_Manager::SELECT,
				'options'    => [
					'button' => esc_html__( 'Button Only', 'farmart-addons' ),
					'slide'  => esc_html__( 'Whole Slide', 'farmart-addons' ),
				],
				'default'    => 'button',
				'conditions' => [
					'terms' => [
						[
							'name'     => 'link[url]',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'price_box', [ 'label' => esc_html__( 'Price', 'farmart-addons' ) ] );

		$repeater->add_control(
			'price_box_text',
			[
				'label'     => esc_html__( 'Price', 'farmart-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '',
			]
		);

		$repeater->add_control(
			'price_box_unit',
			[
				'label'     => esc_html__( 'Unit', 'farmart-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '',
			]
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'price_box_image',
				// Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default'   => 'full',
				'condition' => [
					'price_box_type' => [ 'image' ],
				],
			]
		);
		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'style', [ 'label' => esc_html__( 'Style', 'farmart-addons' ) ] );

		$repeater->add_control(
			'custom_style',
			[
				'label'       => esc_html__( 'Custom', 'farmart-addons' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'Set custom style that will only affect this specific slide.', 'farmart-addons' ),
			]
		);

		$repeater->add_responsive_control(
			'slide_margin',
			[
				'label'      => esc_html__( 'Margin', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-slides {{CURRENT_ITEM}} .farmart-slide-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_responsive_control(
			'slide_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-slides {{CURRENT_ITEM}} .farmart-slide-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_responsive_control(
			'horizontal_position',
			[
				'label'                => esc_html__( 'Horizontal Position', 'farmart-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
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
				'default'              => '',
				'selectors'            => [
					'{{WRAPPER}} .farmart-slides {{CURRENT_ITEM}} .slick-slide-inner .farmart-slide-content' => '{{VALUE}}',
				],
				'selectors_dictionary' => [
					'left'   => 'margin-right: auto',
					'center' => 'margin: 0 auto',
					'right'  => 'margin-left: auto',
				],
				'conditions'           => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_responsive_control(
			'vertical_position',
			[
				'label'                => esc_html__( 'Vertical Position', 'farmart-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
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
				'selectors'            => [
					'{{WRAPPER}} .farmart-slides {{CURRENT_ITEM}} .slick-slide-inner' => 'align-items: {{VALUE}}',
				],
				'selectors_dictionary' => [
					'top'    => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'conditions'           => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_responsive_control(
			'text_align',
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
				'selectors'   => [
					'{{WRAPPER}} .farmart-slides {{CURRENT_ITEM}} .slick-slide-inner' => 'text-align: {{VALUE}}',
				],
				'conditions'  => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'subtitle_custom_color',
			[
				'label'      => esc_html__( 'Subtitle Color', 'farmart-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .farmart-slides {{CURRENT_ITEM}} .slick-slide-inner .farmart-slide-subtitle' => 'color: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
				'separator'  => 'before',
			]
		);

		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle_custom_typography',
				'selector' => '{{WRAPPER}} .farmart-slides {{CURRENT_ITEM}} .slick-slide-inner .farmart-slide-subtitle',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_responsive_control(
			'subtitle_cus_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-slides {{CURRENT_ITEM}} .slick-slide-inner .farmart-slide-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$repeater->add_control(
			'heading_custom_color',
			[
				'label'      => esc_html__( 'Heading Color', 'farmart-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .farmart-slides {{CURRENT_ITEM}} .slick-slide-inner .farmart-slide-heading' => 'color: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
				'separator'  => 'before',
			]
		);

		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_custom_typography',
				'selector' => '{{WRAPPER}} .farmart-slides {{CURRENT_ITEM}} .slick-slide-inner .farmart-slide-heading',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_responsive_control(
			'heading_cus_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-slides {{CURRENT_ITEM}} .slick-slide-inner .farmart-slide-heading' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$repeater->add_control(
			'content_custom_color',
			[
				'label'      => esc_html__( 'Description Color', 'farmart-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .farmart-slides {{CURRENT_ITEM}} .slick-slide-inner .farmart-slide-description' => 'color: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
				'separator'  => 'before',
			]
		);

		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_custom_typography',
				'selector' => '{{WRAPPER}} .farmart-slides {{CURRENT_ITEM}} .slick-slide-inner .farmart-slide-description',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_responsive_control(
			'desc_cus_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-slides {{CURRENT_ITEM}} .slick-slide-inner .farmart-slide-description' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$repeater->add_responsive_control(
			'price_cus_spacing',
			[
				'label'     => esc_html__( 'Price Spacing', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-slides {{CURRENT_ITEM}} .slick-slide-inner .farmart-slide-price-box' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
				'separator'  => 'before',
			]
		);

		$repeater->add_control(
			'price_cus_size',
			[
				'label'     => esc_html__( 'Price Size', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-slides {{CURRENT_ITEM}} .slick-slide-inner .farmart-slide-price-box' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$repeater->add_control(
			'price_cus_color',
			[
				'label'      => esc_html__( 'Price Color', 'farmart-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .farmart-slides {{CURRENT_ITEM}} .slick-slide-inner .farmart-slide-price-box' => 'color: {{VALUE}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'button_custom_color',
			[
				'label'      => esc_html__( 'Button Color', 'farmart-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .farmart-slides {{CURRENT_ITEM}} .slick-slide-inner .farmart-slide-button' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
				'separator'  => 'before',
			]
		);

		$repeater->add_control(
			'button_custom_bg_color',
			[
				'label'      => esc_html__( 'Button Background Color', 'farmart-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .farmart-slides {{CURRENT_ITEM}} .slick-slide-inner .farmart-slide-button' => 'background-color: {{VALUE}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'slides',
			[
				'label'      => esc_html__( 'Slides', 'farmart-addons' ),
				'type'       => Controls_Manager::REPEATER,
				'show_label' => true,
				'fields'     => $repeater->get_controls(),
				'default'    => [
					[
						'subtitle'         => esc_html__( 'Slide 1 Subtitle', 'farmart-addons' ),
						'heading'          => esc_html__( 'Slide 1 Heading', 'farmart-addons' ),
						'description'      => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'farmart-addons' ),
						'button_text'      => esc_html__( 'Click Here', 'farmart-addons' ),
						'background_color' => '#f4f5f5',
					],
					[
						'subtitle'         => esc_html__( 'Slide 2 Subtitle', 'farmart-addons' ),
						'heading'          => esc_html__( 'Slide 2 Heading', 'farmart-addons' ),
						'description'      => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'farmart-addons' ),
						'button_text'      => esc_html__( 'Click Here', 'farmart-addons' ),
						'background_color' => '#f4f5f5',
					],
					[
						'subtitle'         => esc_html__( 'Slide 3 Subtitle', 'farmart-addons' ),
						'heading'          => esc_html__( 'Slide 3 Heading', 'farmart-addons' ),
						'description'      => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'farmart-addons' ),
						'button_text'      => esc_html__( 'Click Here', 'farmart-addons' ),
						'background_color' => '#f4f5f5',
					],
				],
			]
		);

		$this->add_responsive_control(
			'slides_height',
			[
				'label'      => esc_html__( 'Height', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
					'vh' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => 420,
				],
				'size_units' => [ 'px', 'vh', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-slides .slick-slide' => 'height: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();
	}

	protected function section_content_option() {
		$this->start_controls_section(
			'section_slider_options',
			[
				'label' => esc_html__( 'Slider Options', 'farmart-addons' ),
				'type'  => Controls_Manager::SECTION,
			]
		);

		$this->add_responsive_control(
			'navigation',
			[
				'label'   => esc_html__( 'Navigation', 'farmart-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'both',
				'options' => [
					'both'   => esc_html__( 'Arrows and Dots', 'farmart-addons' ),
					'arrows' => esc_html__( 'Arrows', 'farmart-addons' ),
					'dots'   => esc_html__( 'Dots', 'farmart-addons' ),
					'none'   => esc_html__( 'None', 'farmart-addons' ),
				],
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label'   => esc_html__( 'Pause on Hover', 'farmart-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'   => esc_html__( 'Autoplay', 'farmart-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Speed', 'farmart-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'condition' => [
					'autoplay' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-slides .slick-slide-bg' => 'animation-duration: calc({{VALUE}}ms*1.2); transition-duration: calc({{VALUE}}ms)',
				],
			]
		);

		$this->add_control(
			'infinite',
			[
				'label'   => esc_html__( 'Infinite Loop', 'farmart-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'transition_speed',
			[
				'label'   => esc_html__( 'Transition Speed', 'farmart-addons' ) . ' (ms)',
				'type'    => Controls_Manager::NUMBER,
				'default' => 300,
			]
		);

		$this->add_control(
			'bk_animation',
			[
				'label'   => esc_html__( 'Transition', 'farmart-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'fade',
				'options' => [
					'fade'         => esc_html__( 'Fade', 'farmart-addons' ),
					'slide'        => esc_html__( 'Slide', 'farmart-addons' ),
				],
				'separator' => 'after'
			]
		);

		$this->end_controls_section();

	}

	// Tab Style
	protected function section_style() {
		$this->section_style_slides();

		// Tab
		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__( 'Content Text', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->start_controls_tabs( 'slides_tab_content' );

		$this->start_controls_tab( 'slides_tab_sub', [ 'label' => esc_html__( 'Subtitle', 'farmart-addons' ) ] );
		$this->section_style_subtitle();
		$this->end_controls_tab();

		$this->start_controls_tab( 'slides_tab_title', [ 'label' => esc_html__( 'Title', 'farmart-addons' ) ] );
		$this->section_style_title();
		$this->end_controls_tab();

		$this->start_controls_tab( 'slides_tab_desc', [ 'label' => esc_html__( 'Desc', 'farmart-addons' ) ] );
		$this->section_style_desc();
		$this->end_controls_tab();

		$this->end_controls_tabs();
		$this->end_controls_section();
		// End tab

		$this->section_style_button();
		$this->section_style_box();
		$this->section_style_arrow();
		$this->section_style_dot();
	}

	protected function section_style_slides() {
		$this->start_controls_section(
			'section_style_slides',
			[
				'label' => esc_html__( 'Slides', 'farmart-addons' ),
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
				'default'        => [
					'size' => '72',
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'selectors'      => [
					'{{WRAPPER}} .farmart-slides .farmart-slide-content' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'slides_margin',
			[
				'label'      => esc_html__( 'Margin', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-slides .farmart-slide-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'slides_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-slides .farmart-slide-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'banner_border',
				'label'     => esc_html__( 'Border', 'farmart-addons' ),
				'selector'  => '{{WRAPPER}} .farmart-slides',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sliders_border_radius',
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
					'{{WRAPPER}} .farmart-slides' => 'border-radius: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .farmart-slides .slick-slide-bg' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'slides_horizontal_position',
			[
				'label'        => esc_html__( 'Horizontal Position', 'farmart-addons' ),
				'type'         => Controls_Manager::CHOOSE,
				'label_block'  => false,
				'default'      => 'center',
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
			'slides_vertical_position',
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

		$this->add_control(
			'slides_text_align',
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
				'default'     => 'left',
				'selectors'   => [
					'{{WRAPPER}} .farmart-slides .slick-slide-inner' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function section_style_subtitle() {
		// Subtitle
		$this->add_responsive_control(
			'subtitle_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-slides .slick-slide-inner .farmart-slide-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-slides .farmart-slide-subtitle' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .farmart-slide-subtitle',
			]
		);
	}

	protected function section_style_title() {
		// Title
		$this->add_responsive_control(
			'heading_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-slides .slick-slide-inner .farmart-slide-heading' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-slides .farmart-slide-heading' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .farmart-slides .farmart-slide-heading',
			]
		);
	}

	protected function section_style_desc() {
		// Description
		$this->add_responsive_control(
			'description_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-slides .slick-slide-inner .farmart-slide-description:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-slides .farmart-slide-description' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .farmart-slides .farmart-slide-description',
			]
		);
	}

	protected function section_style_button() {
		$this->start_controls_section(
			'section_style_button',
			[
				'label' => esc_html__( 'Button', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'button_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-slides .farmart-slide-button' => 'color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}} .farmart-slides .farmart-svg-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .farmart-slides .farmart-svg-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .farmart-slides .farmart-slide-button',
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
					'{{WRAPPER}} .farmart-slides .farmart-slide-button' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-slides .farmart-slide-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'button_tabs' );

		$this->start_controls_tab( 'normal', [ 'label' => esc_html__( 'Normal', 'farmart-addons' ) ] );

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-slides .farmart-slide-button' => 'color: {{VALUE}};',
					'{{WRAPPER}} .farmart-slides .farmart-svg-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .farmart-slides .farmart-svg-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-slides .farmart-slide-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-slides .farmart-slide-button' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .farmart-slides .farmart-slide-button:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .farmart-slides .farmart-slide-button:focus' => 'color: {{VALUE}};',
					'{{WRAPPER}} .farmart-slides .farmart-slide-button:hover .farmart-svg-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .farmart-slides .farmart-slide-button:hover .farmart-svg-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-slides .farmart-slide-button:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .farmart-slides .farmart-slide-button:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-slides .farmart-slide-button:hover' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .farmart-slides .farmart-slide-button:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'heading_style_icon',
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
				'default'          => [],
				'condition' => [
					'icon_button' => 'yes',
				],
			]
		);
		$this->add_control(
			'icon_position',
			[
				'label'     => esc_html__( 'Icon Position', 'farmart-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'left'  => esc_html__( 'Left', 'farmart-addons' ),
					'right' => esc_html__( 'Right', 'farmart-addons' ),
				],
				'default'   => 'right',
				'toggle'    => false,
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
						'min' => 5,
					],
				],
				'default'   => [
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}}  .farmart-slides-wrapper.align-icon-left .farmart-slide-button .farmart-svg-icon' => 'padding-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .farmart-slides-wrapper.align-icon-right .farmart-slide-button .farmart-svg-icon' => 'padding-left: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .farmart-slides .farmart-slide-button .farmart-svg-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .farmart-slides .farmart-slide-button .farmart-svg-icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'icon_button' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function section_style_box() {
		// Price Box
		$this->start_controls_section(
			'section_style_price_box',
			[
				'label' => esc_html__( 'Price Box', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'sale_tabs' );

		$this->start_controls_tab( 'sale_after_unit', [ 'label' => esc_html__( 'Text', 'farmart-addons' ) ] );

		$this->add_control(
			'sale_afunit_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-slide-price-box .field-price' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'sale_text_typography',
				'selector' => '{{WRAPPER}} .farmart-slide-price-box .field-price',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'sale_unit', [ 'label' => esc_html__( 'Unit', 'farmart-addons' ) ] );

		$this->add_control(
			'position_y',
			[
				'label'     => esc_html__( 'Left', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ '%' ,'px'],
				'range'     => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-slide-price-box .unit' => 'left: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'position_x',
			[
				'label'     => esc_html__( 'Top', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ '%' ,'px' ],
				'range'     => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-slide-price-box .unit' => 'top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'sale_unit_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-slide-price-box .unit' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'sale_unit_typography',
				'selector' => '{{WRAPPER}} .farmart-slide-price-box .unit',

			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function section_style_arrow() {
		// Arrows
		$this->start_controls_section(
			'section_style_arrows',
			[
				'label' => esc_html__( 'Arrows', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'style_arrows',
			[
				'label'        => __( 'Setting', 'farmart-addons' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'farmart-addons' ),
				'label_on'     => __( 'Custom', 'farmart-addons' ),
				'return_value' => 'yes',
			]
		);
		$this->start_popover();

		$this->add_control(
			'arrows_position',
			[
				'label'   => esc_html__( 'Position', 'farmart-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'inside'  => esc_html__( 'Inside Container', 'farmart-addons' ),
					'outside' => esc_html__( 'Outside Container', 'farmart-addons' ),
					'bottom' => esc_html__( 'Bottom Right', 'farmart-addons' ),
				],
				'default' => 'inside',
				'toggle'  => false,
			]
		);

		$this->add_control(
			'arrows_size',
			[
				'label'     => esc_html__( 'Arrows Size', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 10,
						'max' => 60,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-slides-wrapper .arrows-wrapper .slick-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-slides-wrapper .slick-prev-arrow' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .farmart-slides-wrapper .slick-next-arrow' => 'right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .farmart-slides-wrapper.farmart-arrow-bottom .slick-prev-arrow' => 'left: auto; right: calc({{SIZE}}{{UNIT}} + 32px);',
					'{{WRAPPER}} .farmart-slides-wrapper.farmart-arrow-bottom .slick-next-arrow' => 'left: auto; right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'arrows_width',
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
					'{{WRAPPER}} .farmart-slides-wrapper .slick-arrow' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'arrows_height',
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
					'{{WRAPPER}} .farmart-slides-wrapper .slick-arrow' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'arrows_line_height',
			[
				'label'      => esc_html__( 'Line Height', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-slides-wrapper .slick-arrow' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'arrows_border_radius',
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
					'{{WRAPPER}} .farmart-slides-wrapper .slick-arrow' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'arrows_border_width',
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
					'{{WRAPPER}} .farmart-slides-wrapper .slick-arrow' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_popover();

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'arrows_border_shadow',
				'selector' => '{{WRAPPER}} .farmart-slides-wrapper .slick-arrow',
			]
		);

		$this->start_controls_tabs( 'arrows_tabs' );

		$this->start_controls_tab( 'arrows_normal', [ 'label' => esc_html__( 'Normal', 'farmart-addons' ) ] );

		$this->add_control(
			'arrows_color',
			[
				'label'     => esc_html__( 'Arrows Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-slides-wrapper .arrows-wrapper .slick-arrow' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrows_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-slides-wrapper .arrows-wrapper .slick-arrow' => 'background-color: {{VALUE}};',
				],
				'default'   => '',
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab( 'arrows_hover', [ 'label' => esc_html__( 'Hover', 'farmart-addons' ) ] );

		$this->add_control(
			'arrows_hover_color',
			[
				'label'     => esc_html__( 'Arrows Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-slides-wrapper .arrows-wrapper .slick-arrow:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrows_hover_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-slides-wrapper .arrows-wrapper .slick-arrow:hover' => 'background-color: {{VALUE}};',
				],
				'default'   => '',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function section_style_dot() {
		// Dots
		$this->start_controls_section(
			'section_style_dots',
			[
				'label' => esc_html__( 'Dots', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'style_dots',
			[
				'label'        => __( 'Setting', 'farmart-addons' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'farmart-addons' ),
				'label_on'     => __( 'Custom', 'farmart-addons' ),
				'return_value' => 'yes',
			]
		);
		$this->start_popover();

		$this->add_control(
			'dots_position',
			[
				'label'     => esc_html__( 'Position', 'farmart-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
				'options'   => [
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
				'selectors' => [
					'{{WRAPPER}} .farmart-slides .slick-dots' => 'text-align: {{VALUE}};',
				],
				'toggle'    => false,
			]
		);

		$this->add_responsive_control(
			'dots_vertical_offset',
			[
				'label'      => esc_html__( 'Vertical Offset', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-slides .slick-dots' => 'bottom:{{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'dots_horizontal_offset',
			[
				'label'      => esc_html__( 'Horizontal Offset', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-slides .slick-dots' => 'left: {{SIZE}}{{UNIT}}; right: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'dots_position' => [ 'left', 'right' ],
				],
			]
		);

		$this->add_responsive_control(
			'dots_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-slides .slick-dots li'            => 'padding-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .farmart-slides .slick-dots li:last-child' => 'padding-right: 0;',
				],
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'dots_border_radius',
			[
				'label'     => esc_html__( 'Border Radius', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-slides .slick-dots li button:before' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_popover();

		$this->start_controls_tabs( 'dots_tabs' );

		$this->start_controls_tab( 'dots_normal', [ 'label' => esc_html__( 'Normal', 'farmart-addons' ) ] );

		$this->add_control(
			'dots_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-slides-wrapper .slick-dots li button:before' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'dots_width',
			[
				'label'      => esc_html__( 'Width', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-slides .slick-dots li button,{{WRAPPER}} .farmart-slides .slick-dots li button:before' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'dots_height',
			[
				'label'      => esc_html__( 'Height', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-slides .slick-dots li button,{{WRAPPER}} .farmart-slides .slick-dots li button:before' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'dots_hover', [ 'label' => esc_html__( 'Hover', 'farmart-addons' ) ] );

		$this->add_control(
			'dots_hover_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-slides-wrapper .slick-dots li button:hover:before' => 'background-color: {{VALUE}};',
				],
				'default'   => '',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'dots_active', [ 'label' => esc_html__( 'Active', 'farmart-addons' ) ] );

		$this->add_control(
			'dots_active_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-slides-wrapper .slick-dots li.slick-active button:before' => 'background-color: {{VALUE}};'
				],
				'default'   => '',
			]
		);

		$this->add_control(
			'dots_active_width',
			[
				'label'      => esc_html__( 'Width', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-slides .slick-dots li.slick-active button,{{WRAPPER}} .farmart-slides .slick-dots li.slick-active button:before' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'dots_active_height',
			[
				'label'      => esc_html__( 'Height', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-slides .slick-dots li.slick-active button,{{WRAPPER}} .farmart-slides .slick-dots li.slick-active button:before' => 'height: {{SIZE}}{{UNIT}};',
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

		if ( empty( $settings['slides'] ) ) {
			return;
		}

		$nav        = $settings['navigation'];
		$nav_tablet = empty( $settings['navigation_tablet'] ) ? $nav : $settings['navigation_tablet'];
		$nav_mobile = empty( $settings['navigation_mobile'] ) ? $nav : $settings['navigation_mobile'];

		$classes = [
			'farmart-slides-wrapper',
			'align-icon-' . $settings['icon_position'],
			'navigation-' . $nav,
			'navigation-tablet-' . $nav_tablet,
			'navigation-mobile-' . $nav_mobile,
			$settings['arrows_position'] == 'bottom' ? 'farmart-arrow-bottom' : '',
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		$this->add_render_attribute( 'button', 'class', [ 'farmart-button', 'farmart-slide-button' ] );

		$slides      = [];
		$slide_count = 0;

		foreach ( $settings['slides'] as $slide ) {
			$slide_html       = '';
			$btn_attributes   = '';
			$slide_attributes = '';
			$slide_element    = 'div';
			$btn_element      = 'div';
			$slide_url        = $slide['link']['url'];

			if ( ! empty( $slide_url ) ) {
				$this->add_render_attribute( 'slide_link' . $slide_count, 'href', $slide_url );

				if ( $slide['link']['is_external'] ) {
					$this->add_render_attribute( 'slide_link' . $slide_count, 'target', '_blank' );
				}

				if ( 'button' === $slide['link_click'] ) {
					$btn_element    = 'a';
					$btn_attributes = $this->get_render_attribute_string( 'slide_link' . $slide_count );
				} else {
					$slide_element    = 'a';
					$slide_attributes = $this->get_render_attribute_string( 'slide_link' . $slide_count );
				}
			}

			if ( $slide['price_box_text'] ) {
				$price_box_html = sprintf('<div class="field-price">%s <span class="unit">%s</span></div>',$slide['price_box_text'],$slide['price_box_unit']);
			}

			$slide_html .= '<div class="farmart-slide-content">';

			if ( $slide['subtitle'] ) {
				$slide_html .= '<div class="farmart-slide-subtitle">' . $slide['subtitle'] . '</div>';
			}

			if ( $slide['heading'] ) {
				$slide_html .= '<div class="farmart-slide-heading">' . $slide['heading'] . '</div>';
			}

			if ( $slide['description'] ) {
				$slide_html .= '<div class="farmart-slide-description">' . $slide['description'] . '</div>';
			}

			if ( $slide['price_box_text'] ) {
				$slide_html .= '<div class="farmart-slide-price-box">' . $price_box_html . '</div>';
			}

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

			if ( $slide['button_text'] ) {
				$slide_html .= '<' . $btn_element . ' ' . $btn_attributes . ' ' . $this->get_render_attribute_string( 'button' ) . '>' . $slide['button_text'] . $icon . '</' . $btn_element . '>';
			}

			$slide_html .= '</div>';
			$slide_html = '<div class="slick-slide-bg"></div><' . $slide_element . ' ' . $slide_attributes . ' class="slick-slide-inner">' . $slide_html . '</' . $slide_element . '>';
			$slides[]   = '<div class="elementor-repeater-item-' . $slide['_id'] . ' item-slider">' . $slide_html . '</div>';
			$slide_count ++;
		}

		$is_rtl    = is_rtl();
		$direction = $is_rtl ? 'rtl' : 'ltr';

		$slick_options = [
			'slidesToShow'  => absint( 1 ),
			'autoplaySpeed' => 'yes' === $settings['autoplay'] ? absint( $settings['autoplay_speed'] ) : '',
			'autoplay'      => ( 'yes' === $settings['autoplay'] ),
			'infinite'      => ( 'yes' === $settings['infinite'] ),
			'pauseOnHover'  => ( 'yes' === $settings['pause_on_hover'] ),
			'speed'         => absint( $settings['transition_speed'] ),
			'arrows'        => true,
			'dots'          => true,
			'rtl'           => $is_rtl,
			'fade'          => $settings['bk_animation'] == 'fade' ? true : false
		];

		$carousel_classes = [
			'farmart-slides'
		];

		$this->add_render_attribute(
			'slides', [
				'class'               => $carousel_classes,
				'data-slider_options' => wp_json_encode( $slick_options )
			]
		);

		$this->add_render_attribute( 'wrapper', 'dir', $direction );

		$arrows_container = $settings['arrows_position'] == 'inside' ? 'container' : 'container-fluid';

		echo sprintf(
			'<div %s>
				<div class="arrows-wrapper"><div class="arrows-inner arrows-%s"></div></div>
				<div %s>%s</div>
			</div>',
			$this->get_render_attribute_string( 'wrapper' ),
			esc_attr( $arrows_container ),
			$this->get_render_attribute_string( 'slides' ),
			implode( '', $slides )
		);
	}
}