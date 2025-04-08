<?php

namespace FarmartAddons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Stack;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon Box widget
 */
class Counter extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'farmart-counter';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Farmart - Counter', 'farmart-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-counter-circle';
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
			'icon',
			[
				'label'   => esc_html__( 'Icon', 'farmart-addons' ),
				'type'    => Controls_Manager::ICONS,
				'default'          => [
					'value'   => 'fas fa-star',
					'library' => 'fa-solid',
				],
			]
		);
		$repeater->add_control(
			'value', [
				'label'   => esc_html__( 'Value', 'farmart-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
			]
		);
		$repeater->add_control(
			'unit',
			[
				'label'       => esc_html__( 'Unit', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
			]
		);
		$this->add_control(
			'counter',
			[
				'label'         => '',
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [
					[
						'icon'  => [
							'value'   => 'icon-group-work',
						],
						'value' => '30000',
						'unit'  => '+',
						'title' => esc_html__( 'Registed users', 'farmart-addons' ),
					],
					[
						'icon'  => [
							'value'   => 'icon-store',
						],
						'value' => '1949',
						'unit'  => '',
						'title' => esc_html__( 'Sellers', 'farmart-addons' ),
					],
					[
						'icon'  => [
							'value'   => 'icon-receipt',
						],
						'value' => '15000',
						'unit'  => '+',
						'title' => esc_html__( 'Daily ordered', 'farmart-addons' ),
					],
					[
						'icon'  => [
							'value'   => 'icon-users2',
						],
						'value' => '1',
						'unit'  => 'M',
						'title' => esc_html__( 'Daily page visits', 'farmart-addons' ),
					],
					[
						'icon'  => [
							'value'   => 'icon-chart-growth',
						],
						'value' => '45',
						'unit'  => '%',
						'title' => esc_html__( 'Growth per year', 'farmart-addons' ),
					],
					[
						'icon'  => [
							'value'   => 'icon-diamond4',
						],
						'value' => '89',
						'unit'  => '',
						'title' => esc_html__( 'Top global brands', 'farmart-addons' ),
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
		$this->general_section_style();
		$this->icon_section_style();
		$this->value_section_style();
		$this->title_section_style();
	}

	/**
	 * Element in Tab Style
	 *
	 * General
	 */
	protected function general_section_style() {

		$this->start_controls_section(
			'section_content_style',
			[
				'label' => __( 'General', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'columns',
			[
				'label'        => esc_html__( 'Columns', 'farmart-addons' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => [
					'1' => esc_html__( '1 Columns', 'farmart-addons' ),
					'2' => esc_html__( '2 Columns', 'farmart-addons' ),
					'3' => esc_html__( '3 Columns', 'farmart-addons' ),
					'4' => esc_html__( '4 Columns', 'farmart-addons' ),
					'5' => esc_html__( '5 Columns', 'farmart-addons' ),
				],
				'default'      => '3',
				'toggle'       => false,
				'prefix_class' => 'columns-%s',
			]
		);

		$this->add_responsive_control(
			'alignment',
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
				'mobile_default'  => 'row',
				'toggle'          => false,
				'selectors'       => [
					'{{WRAPPER}} .farmart-counter .counter-item' => 'flex-direction: {{VALUE}}',
				],
				'required'        => true,
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => __( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-counter .counter-item' => 'background-color: {{VALUE}};',
				],
				'default'   => '',
			]
		);

		$this->add_control(
			'border',
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
				'default'   => 'solid',
				'toggle'    => false,
				'selectors' => [
					'{{WRAPPER}} .farmart-counter .counter-item,{{WRAPPER}} .farmart-counter' => 'border-style: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'border_color',
			[
				'label'     => __( 'Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-counter .counter-item,{{WRAPPER}} .farmart-counter' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .farmart-counter .counter-item' => 'border-width: 0 {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} 0;',
					'{{WRAPPER}} .farmart-counter' => 'border-width: {{TOP}}{{UNIT}} 0 0 {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_popover();

		$this->add_responsive_control(
			'padding',
			[
				'label'      => __( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-counter .counter-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Element in Tab Style
	 *
	 * Icon
	 */
	protected function icon_section_style() {
		$prefix = 'icon';
		$this->start_controls_section(
			'section_' . $prefix . '_style',
			[
				'label' => __( 'Icon', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			$prefix . '_position',
			[
				'label'   => esc_html__( 'Position', 'farmart-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'left'   => esc_html__( 'Left', 'farmart-addons' ),
					'right'  => esc_html__( 'Right', 'farmart-addons' ),
					'center' => esc_html__( 'Top Center', 'farmart-addons' ),
				],
				'default' => 'left',
				'toggle'  => false,
			]
		);
		$this->add_responsive_control(
			$prefix . '_spacing',
			[
				'label'     => __( 'Spacing', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 200,
						'min' => 10,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .farmart-counter.farmart-counter--icon-left .counter-item__icon'   => 'padding-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .farmart-counter.farmart-counter--icon-right .counter-item__icon'  => 'padding-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .farmart-counter.farmart-counter--icon-center .counter-item__icon' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			$prefix . '_font_size',
			[
				'label'     => __( 'Font Size', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [ ],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-counter .farmart-svg-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .farmart-counter .farmart-svg-icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			$prefix . '_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-counter .farmart-svg-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .farmart-counter .farmart-svg-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Element in Tab Style
	 *
	 * Value
	 */
	protected function value_section_style() {
		$prefix = 'value';

		$this->start_controls_section(
			'section_' . $prefix . '_style',
			[
				'label' => __( 'Value', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			$prefix . '_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-counter .counter-value' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => $prefix . '_typography',
				'selector' => '{{WRAPPER}} .farmart-counter .counter-value',
			]
		);
		$this->add_responsive_control(
			$prefix . '_top_spacing',
			[
				'label'     => __( 'Top Spacing', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .farmart-counter .counter-value' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			$prefix . '_bottom_spacing',
			[
				'label'     => __( 'Bottom Spacing', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .farmart-counter .counter-value' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Element in Tab Style
	 *
	 * Title
	 */
	protected function title_section_style() {
		$prefix = 'title';

		$this->start_controls_section(
			'section_' . $prefix . '_style',
			[
				'label' => __( 'Title', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			$prefix . '_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-counter .title' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => $prefix . '_typography',
				'selector' => '{{WRAPPER}} .farmart-counter .title',
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
				'farmart-counter',
				'farmart-counter--icon-' . $settings['icon_position'],
			]
		);

		$counter = $settings['counter'];

		$output = [ ];

		if ( ! empty ( $counter ) ) {
			$output[] = '<div class="counter-row">';

			foreach ( $counter as $index => $item ) {

				$icon = $value = $title = $unit = '';
				if ( $item['icon'] && ! empty($item['icon']['value']) && \Elementor\Icons_Manager::is_migration_allowed() ) {
					ob_start();
					\Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] );
					$icon = '<div class="counter-item__icon"><span class="farmart-svg-icon">' . ob_get_clean() . '</span></div>';
				}

				if ( $item['unit'] ) {
					$unit = '<span class="unit">' . $item['unit'] . '</span>';
				}

				if ( $item['value'] ) {
					$value = '<span class="value">' . $item['value'] . '</span>';
					$value = '<div class="counter-value">' . $value . $unit . '</div>';
				}

				if ( $item['title'] ) {
					$title = '<div class="title">' . $item['title'] . '</div>';
				}

				$output[] = sprintf(
					'<div class="counter-item">
						%s
						<div class="counter-item__content">%s%s</div>
					</div>',
					$icon,
					$value,
					$title
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