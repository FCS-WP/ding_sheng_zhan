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
class Quotes extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'farmart-quotes';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Farmart - Quote', 'farmart-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-blockquote';
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

	/**
	 * Section Content
	 */
	protected function section_content() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon',
			[
				'label'   => esc_html__( 'Icon', 'farmart-addons' ),
				'type'    => Controls_Manager::ICONS,
				'default'          => [
					'value'   => 'fas fa-quote-left',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'name',
			[
				'label'       => esc_html__( 'Name', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'This is name', 'farmart-addons' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'job',
			[
				'label'       => esc_html__( 'Job', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'This is job', 'farmart-addons' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'content',
			[
				'label'       => esc_html__( 'Content', 'farmart-addons' ),
				'type'        => Controls_Manager::WYSIWYG ,
				'default'     => esc_html__( 'This is content', 'farmart-addons' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Section Style
	 */
	protected function section_style() {
		$this->icon_section_style();
		$this->section_name_style();
		$this->section_job_style();
		$this->section_content_style();
	}

	/**
	 * Element in Tab Style
	 *
	 * Tab Title
	 */
	protected function icon_section_style() {
		$this->start_controls_section(
			'section_icon_style',
			[
				'label' => __( 'Icon', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label'           => esc_html__( 'Align', 'farmart-addons' ),
				'type'            => Controls_Manager::SELECT,
				'options'         => [
					'horizontal'  	=> esc_html__( 'Horizontal', 'farmart-addons' ),
					'vertical' 		=> esc_html__( 'Vertical', 'farmart-addons' ),
				],
				'default' 			=> 'horizontal',
				'toggle'          => false,
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
					'{{WRAPPER}}  .farmart-quotes .farmart-svg-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}  .farmart-quotes.farmart-icon-vertical .farmart-svg-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .farmart-quotes .farmart-svg-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .farmart-quotes .farmart-svg-icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-quotes .farmart-svg-icon' => 'color: {{VALUE}}',
					'{{WRAPPER}} .farmart-quotes .farmart-svg-icon svg' => 'fill: {{VALUE}};',

				],
			]
		);
		$this->end_controls_section();
	}

	protected function section_name_style() {
		$this->start_controls_section(
			'style_name',
			[
				'label' => __( 'Name', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'style_name_typography',
				'selector' => '{{WRAPPER}} .farmart-quotes .name',
			]
		);

		$this->add_control(
			'name_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-quotes .name' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();

	}

	/**
	 * Element in Tab Style
	 *
	 * Button
	 */
	protected function section_job_style() {
		$this->start_controls_section(
			'style_job',
			[
				'label' => __( 'Job', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'style_job_typography',
				'selector' => '{{WRAPPER}} .farmart-quotes .job',
			]
		);

		$this->add_control(
			'job_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-quotes .job' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();

	}

	/**
	 * Element in Tab Style
	 *
	 * Item
	 */
	protected function section_content_style() {
		$this->start_controls_section(
			'section_desc_style',
			[
				'label' => __( 'Description', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_spacing',
			[
				'label'     => __( 'Margin Bottom', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .farmart-quotes .box-content' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .farmart-quotes .box-content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typography',
				'selector' => '{{WRAPPER}} .farmart-quotes .box-contemt',
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
				'farmart-quotes',
				$settings["icon_align"] == 'vertical' ? 'farmart-icon-vertical' : ''
			]
		);

		if ( $settings['icon'] && ! empty($settings['icon']['value']) && \Elementor\Icons_Manager::is_migration_allowed() ) {
			ob_start();
			\Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
			$icon = '<span class="farmart-svg-icon">' . ob_get_clean() . '</span>';
		}

		if( empty( $icon ) ) {
			$icon = '<span class="farmart-svg-icon"><svg viewBox="0 0 32 32"><path d="M8 32c-0.205 0-0.409-0.078-0.566-0.234-0.312-0.312-0.312-0.819 0-1.131l13.834-13.834-13.834-13.834c-0.312-0.312-0.312-0.819 0-1.131s0.819-0.312 1.131 0l14.4 14.4c0.312 0.312 0.312 0.819 0 1.131l-14.4 14.4c-0.156 0.156-0.361 0.234-0.566 0.234z"></path></svg></span>';
		}

		$name  = $settings["name"] ? '<h6 class="name">' . $settings["name"] . '</h6>' : '';
		$job  = $settings["job"] ? '<span class="job">' . $settings["job"] . '</span>' : '';

		$box_author = $name == '' && $job == '' ? '' : sprintf('<div class="author">%s %s</div>',$name,$job) ;

		$desc = $settings['content'] ? sprintf( '<div class="box-content">%s</div>', $settings["content"]  ) : '';

		if ( $settings["icon_align"] == 'vertical' ) {
			echo sprintf(
				'<div %s>%s<div class="farmart-quotes-content">%s%s</div></div>',
				$this->get_render_attribute_string( 'wrapper' ),
				$icon,
				$desc,
				$box_author
			);
		} else {
			echo sprintf(
				'<div %s>%s%s%s</div>',
				$this->get_render_attribute_string( 'wrapper' ),
				$icon,
				$desc,
				$box_author
			);
		}
	}
}