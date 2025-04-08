<?php

namespace FarmartAddons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Image List Box widget
 */
class Image_Box extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'farmart-image-box';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Farmart - Image Box', 'farmart-addons' );
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
		$this->section_content();
		$this->section_style();
	}

	/**
	 * Section Content
	 */
	protected function section_content() {
		$this->start_controls_section(
			'section_content',
			[ 'label' => esc_html__( 'Content', 'farmart-addons' ) ]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'image',
			[
				'label'   => esc_html__( 'Image', 'farmart-addons' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [],
			]
		);
		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'This is the title', 'farmart-addons' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'desc',
			[
				'label'       => esc_html__( 'Description', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'This is the desc', 'farmart-addons' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'elements',
			[
				'label'         => '',
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [
					[
						'image'  => [],
						'title' => esc_html__( 'Free Shipping', 'farmart-addons' ),
						'desc' => esc_html__( 'For all orders over $200', 'farmart-addons' ),
					],
					[
						'image'  => [],
						'title' => esc_html__( '1 & 1 Returns', 'farmart-addons' ),
						'desc' => esc_html__( 'Cancellation after 1 day', 'farmart-addons' ),
					],
					[
						'image'  => [],
						'title' => esc_html__( '100% Secure Payment', 'farmart-addons' ),
						'desc' => esc_html__( 'Gurantee secure payments', 'farmart-addons' ),
					],
				],
				'title_field'   => '{{{ title }}}',
				'prevent_empty' => false
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Section Style
	 */
	protected function section_style() {
		$this->item_section_style();
	}

	/**
	 * Element in Tab Style
	 *
	 *
	 */
	protected function item_section_style() {
		$this->start_controls_section(
			'section_item_style',
			[
				'label' => __( 'Items', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label'      =>esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-image-box__items' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Image
		$this->add_control(
			'image_style',
			[
				'label'     => esc_html__( 'Image', 'farmart-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'image_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'   => [],
				'selectors' => [
					'{{WRAPPER}} .farmart-image-box__image' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Title
		$this->add_control(
			'title_style',
			[
				'label'     => esc_html__( 'Title', 'farmart-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .farmart-image-box__content--title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-image-box__content--title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'   => [],
				'selectors' => [
					'{{WRAPPER}} .farmart-image-box__content--title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Description
		$this->add_control(
			'desc_style',
			[
				'label'     => esc_html__( 'Description', 'farmart-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typography',
				'selector' => '{{WRAPPER}} .farmart-image-box__content--desc',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-image-box__content--desc' => 'color: {{VALUE}};',
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

		$this->add_render_attribute(
			'wrapper', 'class', [
				'farmart-image-box',
			]
		);

		$els = $settings['elements'];

		$output = [ ];
		if ( ! empty ( $els ) ) {
			$output[] = '<div class="farmart-image-box__wrapper">';

			foreach ( $els as $index => $item ) {
				$image = $desc = $title  = '';
				$settings['image']      = $item['image'];
				$image = Group_Control_Image_Size::get_attachment_image_html( $settings );

				if ( $item['title'] ) {
					$title = '<h6 class="farmart-image-box__content--title">' . $item['title'] . '</h6>';
				}

				if ( $item['desc'] ) {
					$desc = '<div class="farmart-image-box__content--desc">' . $item['desc'] . '</div>';
				}

				$output[] = sprintf(
					'<div class="farmart-image-box__items">
						<div class="farmart-image-box__image">%s</div>
						<div class="farmart-image-box__content">%s%s</div>
					</div>',
					$image,$title,$desc
				);
			}

			$output[] = '</div>';
		}

		echo sprintf(
			'<div %s>%s</div>',
			$this->get_render_attribute_string( 'wrapper' ),
			implode( '', $output )
		);

	}
}