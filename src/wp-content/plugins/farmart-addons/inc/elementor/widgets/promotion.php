<?php

namespace FarmartAddons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon Box widget
 */
class Promotion extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'fm-promotion';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Farmart - Promotion', 'farmart-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-image';
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
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'promotion', 'gallery' ];
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

		$this->add_control(
			'background', [
				'label' => esc_html__( 'Background Image', 'farmart-addons' ),
				'type'  => Controls_Manager::MEDIA,
			]
		);

		$this->add_control(
			'percent',
			[
				'label'     => esc_html__( 'Percent', 'farmart-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '50',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'unit',
			[
				'label'   => esc_html__( 'Unit', 'farmart-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '%',
			]
		);

		$this->add_control(
			'text',
			[
				'label'   => esc_html__( 'Text', 'farmart-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Off', 'farmart-addons' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label'     => esc_html__( 'Title', 'farmart-addons' ),
				'type'      => Controls_Manager::TEXTAREA,
				'default'   => esc_html__( 'get your own daily big & best deals.', 'farmart-addons' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'description',
			[
				'label'   => esc_html__( 'Description', 'farmart-addons' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Update at 12 AM everyday.', 'farmart-addons' ),
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Section Style
	 */
	protected function section_style() {
		$this->section_general_style();
		$this->section_left_box_style();
		$this->section_right_box_style();
		$this->section_line_style();
	}

	protected function section_general_style() {
		$this->start_controls_section(
			'style_general',
			[
				'label' => __( 'General', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'margin',
			[
				'label'      => esc_html__( 'Margin', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .fm-promotion .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'after',
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .fm-promotion .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'after',
			]
		);

		$this->end_controls_section();
	}

	protected function section_left_box_style() {
		$this->start_controls_section(
			'style_left_box',
			[
				'label' => __( 'Left Box', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'left_box_margin',
			[
				'label'      => esc_html__( 'Margin', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .fm-promotion .left-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'after',
			]
		);

		$this->add_responsive_control(
			'left_box_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .fm-promotion .left-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'after',
			]
		);

		$this->add_control(
			'style_left_box_percent',
			[
				'label' => esc_html__( 'Percent', 'farmart-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'percent_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-promotion .percent' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'percent_typography',
				'selector' => '{{WRAPPER}} .fm-promotion .percent',
			]
		);

		$this->add_control(
			'style_left_box_unit',
			[
				'label' => esc_html__( 'Unit', 'farmart-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'unit_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-promotion .unit' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'unit_typography',
				'selector' => '{{WRAPPER}} .fm-promotion .unit',
			]
		);

		$this->add_control(
			'style_left_box_text',
			[
				'label' => esc_html__( 'Text', 'farmart-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-promotion .text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typography',
				'selector' => '{{WRAPPER}} .fm-promotion .text',
			]
		);

		$this->end_controls_section();
	}

	protected function section_right_box_style() {
		$this->start_controls_section(
			'style_right_box',
			[
				'label' => __( 'Right Box', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'right_box_margin',
			[
				'label'      => esc_html__( 'Margin', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .fm-promotion .right-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'after',
			]
		);

		$this->add_responsive_control(
			'right_box_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .fm-promotion .left-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'after',
			]
		);

		$this->add_control(
			'style_left_box_title',
			[
				'label' => esc_html__( 'Title', 'farmart-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-promotion .title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .fm-promotion .title',
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'      => __( 'Spacing', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
					'%'  => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default'    => [ ],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .fm-promotion .title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'style_left_box_desc',
			[
				'label' => esc_html__( 'Description', 'farmart-addons' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-promotion .description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typography',
				'selector' => '{{WRAPPER}} .fm-promotion .description',
			]
		);

		$this->end_controls_section();
	}

	protected function section_line_style() {
		$this->start_controls_section(
			'section_line_style',
			[
				'label' => __( 'Line', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'line_width',
			[
				'label'      => __( 'Width', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 5,
					],
				],
				'default'    => [ ],
				'selectors'  => [
					'{{WRAPPER}} .fm-promotion .right-content:before' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'line_height',
			[
				'label'     => __( 'Height', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [ ],
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
					'%'  => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .fm-promotion .right-content:before' => 'height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .fm-promotion .right-content:before' => 'background-color: {{VALUE}};',
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
				'fm-promotion'
			]
		);

		if ( $settings['percent'] ) {
			$percent = '<div class="percent">' . $settings['percent'] . '</div>';
		}

		if ( $settings['unit'] ) {
			$unit = '<div class="unit">' . $settings['unit'] . '</div>';
		}

		if ( $settings['text'] ) {
			$text = '<div class="text">' . $settings['text'] . '</div>';
		}

		if ( $settings['title'] ) {
			$title = '<h2 class="title">' . $settings['title'] . '</h2>';
		}

		if ( $settings['description'] ) {
			$description = '<div class="description">' . $settings['description'] . '</div>';
		}

		$image = '';
		if ( ! empty($settings['background']['url'])){
			$image = sprintf( 'style="background-image: url(%s)"', $settings['background']['url'] );
		}

		$left_content = sprintf(
			'<div class="left-content">
							%s
							<div class="box">%s%s
							</div>
						</div>',
						$percent,
						$unit,
						$text
					);

		$right_content = sprintf( '<div class="right-content">%s%s</div>', $title, $description );

		echo sprintf(
			'<div %s %s><div class="content">%s%s</div></div>',
			$this->get_render_attribute_string( 'wrapper' ),
			$image,
			$left_content,
			$right_content
		);
	}
}