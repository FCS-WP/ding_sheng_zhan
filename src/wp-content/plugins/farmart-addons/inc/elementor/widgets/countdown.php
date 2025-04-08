<?php

namespace FarmartAddons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon Box widget
 */
class Countdown extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'farmart-countdown';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Farmart - Countdown', 'farmart-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-countdown';
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

		$this->add_control(
			'due_date',
			[
				'label'   => esc_html__( 'Date', 'farmart-addons' ),
				'type'    => Controls_Manager::DATE_TIME,
				'default' => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Section Style
	 */
	protected function section_style() {
		$this->section_general_style();
		$this->section_digit_style();
		$this->section_text_style();
		$this->section_divider_style();
	}

	/**
	 * Element in Tab Style
	 *
	 * General
	 */
	protected function section_general_style() {
		$this->start_controls_section(
			'section_general_style',
			[
				'label' => __( 'General', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'general_width',
			[
				'label'     => __( 'Min Width', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [ ],
				'range'     => [
					'px' => [
						'min' => 50,
						'max' => 250,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-time-countdown .timer' => 'min-width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'general_padding',
			[
				'label'      => __( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-time-countdown .timer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Element in Tab Style
	 *
	 * Digit
	 */
	protected function section_digit_style() {
		$this->start_controls_section(
			'section_digit_style',
			[
				'label' => __( 'Digit', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'digit_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-time-countdown .timer .digits' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'digit_typography',
				'selector' => '{{WRAPPER}} .farmart-time-countdown .timer .digits',
			]
		);
		$this->add_responsive_control(
			'digit_spacing',
			[
				'label'     => __( 'Bottom Spacing', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 30,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .farmart-time-countdown .timer .digits' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Element in Tab Style
	 *
	 * Text
	 */
	protected function section_text_style() {
		$this->start_controls_section(
			'section_text_style',
			[
				'label' => __( 'Text', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-time-countdown .timer .text' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typography',
				'selector' => '{{WRAPPER}} .farmart-time-countdown .timer .text',
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Element in Tab Style
	 *
	 * Divider
	 */
	protected function section_divider_style() {
		$this->start_controls_section(
			'section_divider_style',
			[
				'label' => __( 'Divider', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'divider_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-time-countdown .timer .divider' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'divider_font_size',
			[
				'label'     => __( 'Font Size', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 60,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .farmart-time-countdown .timer .divider' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'divider_position_left',
			[
				'label'              => esc_html__( 'Position ', 'farmart-addons' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'allowed_dimensions' => [ 'top', 'right' ],
				'size_units'         => [ 'px', '%' ],
				'default'            => [],
				'selectors'          => [
					'{{WRAPPER}} .farmart-time-countdown .timer .divider' => ' top:{{TOP}}{{UNIT}};right: {{RIGHT}}{{UNIT}}',
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
				'farmart-time-countdown farmart-countdown',
			]
		);

		$second = 0;
		if ( $settings['due_date'] ) {
			$second_current  = strtotime( date_i18n( 'Y/m/d H:i:s' ) );
			$second_discount = strtotime( $this->get_settings( 'due_date' ) );
			if ( $second_discount > $second_current ) {
				$second = $second_discount - $second_current;
			}
		}

		$this->add_render_attribute(
			'wrapper', 'data-expire', [
				$second
			]
		);
		?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <div <?php echo $this->get_render_attribute_string( 'wrapper_inner' ); ?>>
            </div>
        </div>
		<?php
	}
}