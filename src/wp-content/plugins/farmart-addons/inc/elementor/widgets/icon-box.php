<?php

namespace FarmartAddons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon Box Box widget
 */
class Icon_Box extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'farmart-icon-box';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Farmart - Icon Box', 'farmart-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-posts-grid';
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
			'title',
			[
				'label'       => esc_html__( 'Title', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'desc',
			[
				'label'       => esc_html__( 'Description', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => '',
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
						'icon'  => [
							'value'   => 'icon-bubbles',
						],
						'title' => esc_html__( 'This is the title', 'farmart-addons' ),
						'desc' => esc_html__( 'This is the description', 'farmart-addons' ),
					],[
						'icon'  => [
							'value'   => 'icon-map-marker',
						],
						'title' => esc_html__( 'This is the title', 'farmart-addons' ),
						'desc' => esc_html__( 'This is the description', 'farmart-addons' ),
					],[
						'icon'  => [
							'value'   => 'icon-self-timer',
						],
						'title' => esc_html__( 'This is the title', 'farmart-addons' ),
						'desc' => esc_html__( 'This is the description', 'farmart-addons' ),
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
		$this->item_section_style();
	}

	/**
	 * Element in Tab Style
	 *
	 * General
	 */
	protected function general_section_style() {

		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'General', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'content_position',
			[
				'label'     => esc_html__( 'Align', 'farmart-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					''   => [
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
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-icon-box .box-item' => 'text-align: {{VALUE}};',
				],
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
				],
				'default'      => '3',
				'toggle'       => false,
				'prefix_class' => 'columns-%s',
			]
		);

		$this->add_control(
			'heading_item_setting',
			[
				'label'     => esc_html__( 'Item', 'farmart-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label'      =>esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-icon-box .box-item__inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

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
					'{{WRAPPER}} .farmart-icon-box .box-item__inner' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'border_color',
			[
				'label'     => esc_html__( 'Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-icon-box .box-item__inner' => 'border-color: {{VALUE}}',
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
					'{{WRAPPER}} .farmart-icon-box .box-item__inner' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_popover();

		$this->add_control(
			'item_background_color',
			[
				'label'     => __( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-icon-box .box-item__inner' => 'background-color: {{VALUE}};',
				],
				'default'   => '',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'item_shadow',
				'selector' => '{{WRAPPER}} .farmart-icon-box .box-item__inner',
			]
		);

		$this->add_responsive_control(
			'item_spacing',
			[
				'label'     => __( 'Spacing', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 200,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .farmart-icon-box .box-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Element in Tab Style
	 *
	 * Icon
	 */
	protected function item_section_style() {
		$this->start_controls_section(
			'section_item_style',
			[
				'label' => __( 'Elements', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'text_style_tabs', [ 'separator' => 'before', ] );

		$this->start_controls_tab(
			'heading_title_style',
			[
				'label' => __( 'Title', 'farmart-addons' ),
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .farmart-icon-box .title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-icon-box .title' => 'color: {{VALUE}};',
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
						'max' => 50,
						'min' => 5,
					],
				],
				'default'   => [],
				'selectors' => [
					'{{WRAPPER}} .farmart-icon-box .title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'desc_style',
			[
				'label' => __( 'Desc', 'farmart-addons' ),
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typography',
				'selector' => '{{WRAPPER}} .farmart-icon-box .desc',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-icon-box .desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'icon_style',
			[
				'label' => __( 'Icon', 'farmart-addons' ),
			]
		);

		$this->add_responsive_control(
			'icon_position_left',
			[
				'label'              => esc_html__( 'Position ', 'farmart-addons' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'allowed_dimensions' => [ 'bottom', 'right' ],
				'size_units'         => [ 'px', '%' ],
				'default'            => [],
				'selectors'          => [
					'{{WRAPPER}} .farmart-icon -box .farmart-svg-icon' => ' bottom:{{BOTTOM}}{{UNIT}};right: {{RIGHT}}{{UNIT}}',
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
					'{{WRAPPER}} .farmart-icon-box .farmart-svg-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .farmart-icon-box .farmart-svg-icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-icon-box .farmart-svg-icon' => 'color: {{VALUE}}',
					'{{WRAPPER}} .farmart-icon-box .farmart-svg-icon svg' => 'fill: {{VALUE}};',

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

		$this->add_render_attribute(
			'wrapper', 'class', [
				'farmart-icon-box',
			]
		);

		$els = $settings['elements'];

		$output = [ ];

		if ( ! empty ( $els ) ) {
			$output[] = '<div class="farmart-icon-box__wrapper row-flex">';
			$i = 0;

			foreach ( $els as $index => $item ) {
				$i ++;
				$icon = $desc = $title  = '';
				if ( $item['icon']  && ! empty($item['icon']['value']) && \Elementor\Icons_Manager::is_migration_allowed() ) {
					ob_start();
					\Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] );
					$icon = '<span class="farmart-svg-icon">' . ob_get_clean() . '</span>';
				}

				if ( $item['title'] ) {
					$title = '<h4 class="title">' . $item['title'] . '</h4>';
				}

				if ( $item['desc'] ) {
					$desc = '<div class="desc">' . $item['desc'] . '</div>';
				}

				$output[] = sprintf(
					'<div class="box-item">
						<div class="box-item__inner">
							%s%s%s
						</div>
					</div>',
					$icon,$title,$desc
				);
			}

			$output[] = '</div>';
		}

		if ($i > $settings['columns']){
			$this->add_render_attribute(
				'wrapper', 'class', [
					'add-space',
				]
			);
		}

		echo sprintf(
			'<div %s>%s</div>',
			$this->get_render_attribute_string( 'wrapper' ),
			implode( '', $output )
		);

	}
}