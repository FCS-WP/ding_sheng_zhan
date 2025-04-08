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
 * Tab List widget
 */
class Faq extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'farmart-faq';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Farmart - FAQ', 'farmart-addons' );
	}

	/**
	 * Retrieve the widget circle.
	 *
	 * @return string Widget circle.
	 */
	public function get_icon() {
		return 'eicon-info-circle-o';
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
			'title',
			[
				'label'       => esc_html__( 'Title', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'This is title', 'farmart-addons' ),
				'label_block' => true,
			]
		);

		$repeater -> add_control(
			'desc',
			[
				'label'       => esc_html__( 'Content', 'farmart-addons' ),
				'type'        => Controls_Manager::WYSIWYG ,
				'default'     => esc_html__( 'Event Note', 'farmart-addons' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'element',
			[
				'label'   => '',
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater->get_controls(),
				'default' => [
					[
						'title'                 => esc_html__( 'This is title', 'farmart-addons' ),
						'desc'                  => esc_html__( 'This is description', 'farmart-addons' ),
					],
					[
						'title'         => esc_html__( 'This is title', 'farmart-addons' ),
						'desc'                  => esc_html__( 'This is description', 'farmart-addons' ),
					],
					[
						'title'         => esc_html__( 'This is title', 'farmart-addons' ),
						'desc'                  => esc_html__( 'This is description', 'farmart-addons' ),
					],
					[
						'title'         => esc_html__( 'This is title', 'farmart-addons' ),
						'desc'                  => esc_html__( 'This is description', 'farmart-addons' ),
					],
					[
						'title'         => esc_html__( 'This is title', 'farmart-addons' ),
						'desc'                  => esc_html__( 'This is description', 'farmart-addons' ),
					],
				],
				'title_field'   => '{{{ title }}}',

			]
		);

		$this->add_control(
			'icon',
			[
				'label'   => esc_html__( 'Icons Normal', 'farmart-addons' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'icon-chevron-down',
					'library' => 'linearicons',
				],
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'icon_active',
			[
				'label'   => esc_html__( 'Icons Active', 'farmart-addons' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'icon-chevron-up',
					'library' => 'linearicons',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Section Style
	 */
	protected function section_style() {
		$this->section_content_style();
		$this->section_icon_style();
	}

	/**
	 * Element in Tab Style
	 *
	 * Title
	 */
	protected function section_content_style() {
		// Content
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => __( 'Content', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'general_padding',
			[
				'label'      => __( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-faq .box-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'content_bk_color',
			[
				'label'        => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'         => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-faq .box-content' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'border_style',
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
			'content_border_style',
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
					'{{WRAPPER}} .farmart-faq .box-content' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_border_width',
			[
				'label'     => __( 'Border Width', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 7,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .farmart-faq .box-content' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_border_color',
			[
				'label'     => __( 'Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-faq .box-content' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_popover();

		$this->start_controls_tabs(
			'style_tabs_icons'
		);

		// Title
		$this->start_controls_tab(
			'content_style_title',
			[
				'label' => __( 'Title', 'farmart-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .farmart-faq .title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-faq .title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_spacing_right',
			[
				'label'     => __( 'Space', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 200,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .farmart-faq .title' => 'padding-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		// Desc
		$this->start_controls_tab(
			'content_desc',
			[
				'label' => __( 'Description', 'farmart-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'note_typography',
				'selector' => '{{WRAPPER}} .farmart-faq .desc',
			]
		);

		$this->add_responsive_control(
			'note_spacing',
			[
				'label'     => __( 'Margin Top', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .farmart-faq .desc' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'note_spacing_right',
			[
				'label'     => __( 'Space', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 200,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .farmart-faq .desc' => 'padding-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-faq .desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'active_style',
			[
				'label'     => esc_html__( 'Active', 'farmart-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'tit_ac_color',
			[
				'label'     => __( 'Title Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-faq .box-content.active .title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'arrows_border_shadow',
				'selector' => '{{WRAPPER}} .farmart-faq .box-content.active',
			]
		);

		$this->add_control(
			'divi_color',
			[
				'label'     => __( 'Divider Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-faq .box-content.active:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'divi_width',
			[
				'label'     => __( 'Divider Width', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
					'%' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'size_units'         => [ 'px', '%' ],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .farmart-faq .box-content.active:before' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function section_icon_style() {
		// Content
		$this->start_controls_section(
			'section_icon_style',
			[
				'label' => __( 'Icons', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'icon_width',
			[
				'label'     => __( 'Width', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .farmart-faq .title .fm-icon .box-icon' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_height',
			[
				'label'     => __( 'Height', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .farmart-faq .title .fm-icon .box-icon' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_line_height',
			[
				'label'     => __( 'Line Height', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .farmart-faq .title .fm-icon .box-icon' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_border_radius',
			[
				'label'     => __( 'Border-radius', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'%' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .farmart-faq .title .fm-icon .box-icon' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'style_tabs'
		);

		// Title
		$this->start_controls_tab(
			'content_style_normal',
			[
				'label' => __( 'Normal', 'farmart-addons' ),
			]
		);

		$this->add_control(
			'icon_normal_bk_color',
			[
				'label'        => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'         => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-faq .title .fm-icon .box-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_normal_color',
			[
				'label'        => esc_html__( 'Color', 'farmart-addons' ),
				'type'         => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-faq .title .fm-icon .box-icon i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Active
		$this->start_controls_tab(
			'content_style_active',
			[
				'label' => __( 'Active', 'farmart-addons' ),
			]
		);

		$this->add_control(
			'icon_active_bk_color',
			[
				'label'        => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'         => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-faq .box-content.active .title .fm-icon .box-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_active_color',
			[
				'label'        => esc_html__( 'Color', 'farmart-addons' ),
				'type'         => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-faq .box-content.active .title .fm-icon .box-icon i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	/**
	 * Render circle box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$classes = [
			'farmart-faq'
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		$output_events = array();

		$icon = $icon_active = '';
		if ( $settings['icon'] && ! empty( $settings['icon']['value'] ) && \Elementor\Icons_Manager::is_migration_allowed() ) {
			ob_start();
			\Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
			$icon = '<span class="farmart-svg-icon box-icon icon-normal">' . ob_get_clean() . '</span>';
		}
		if ( $settings['icon_active'] && ! empty( $settings['icon_active']['value'] ) && \Elementor\Icons_Manager::is_migration_allowed() ) {
			ob_start();
			\Elementor\Icons_Manager::render_icon( $settings['icon_active'], [ 'aria-hidden' => 'true' ] );
			$icon_active = '<span class="farmart-svg-icon box-icon icon-active">' . ob_get_clean() . '</span>';
		}

		$icon = sprintf('<span class="fm-icon">%s%s</span>', $icon, $icon_active);

		foreach (  $settings["element"]  as $index => $item ) {

			$title     = $item["title"] ? '<h5 class="title">' . $item["title"] . $icon . '</h5>' : '';
			$desc = $item['desc'] ? sprintf( '<div class="desc">%s</div>', $item["desc"]  ) : '';

			$output_events[] = $title == '' && $desc == '' ? '' : sprintf( '<div class="box-content">%s %s</div>',$title ,$desc  );
		}

		echo sprintf(
			'<div %s>%s</div>',
			$this->get_render_attribute_string( 'wrapper' ),
			implode( '', $output_events )
		);
	}
}