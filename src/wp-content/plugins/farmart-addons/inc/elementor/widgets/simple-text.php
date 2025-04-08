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
class Simple_Text extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'farmart-simple-text ';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Farmart - Simple Text', 'farmart-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-animation-text';
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
			[ 'label' => esc_html__( 'Content', 'farmart-addons' ) ]
		);

		$this->add_responsive_control(
			'content_alignment',
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
					'{{WRAPPER}} .farmart-simple-text a' => 'flex-direction: {{VALUE}}',
				],
				'required'        => true,
			]
		);

		$this->add_control(
			'icon',
			[
				'label'     => esc_html__( 'Icon', 'farmart-addons' ),
				'type'      => Controls_Manager::ICONS,
				'default'          => [
					'value'   => 'fas fa-star',
					'library' => 'fa-solid',
				],
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'This is the title', 'farmart-addons' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'af_title',
			[
				'label'       => esc_html__( 'Highlight', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
			]
		);

		$this->add_control(
			'position_highlight',
			[
				'label'       => esc_html__( 'Highlight Position', 'farmart-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'after' => esc_html__( 'After the title', 'farmart-addons' ),
					'under' => esc_html__( 'Under the title', 'farmart-addons' ),
				],
				'default'   => 'after',
				'label_block' => true,
			]
		);

		$this->add_control(
			'link', [
				'label'         => esc_html__( 'Link', 'farmart-addons' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'farmart-addons' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				],
				'separator'   => 'before',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Section Style
	 */
	protected function section_style() {
		$this->section_general_style();
		$this->section_icon_style();
		$this->section_title_style();
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

		$this->add_control(
			'general_align',
			[
				'label'     => esc_html__( 'Align', 'farmart-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'' => [
						'title' => esc_html__( 'Left', 'farmart-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'farmart-addons' ),
						'icon'  => 'eicon-h-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'farmart-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'   => '',
				'toggle'    => false,
				'selectors' => [
					'{{WRAPPER}} .farmart-simple-text ' => 'justify-content: {{VALUE}};',
					'{{WRAPPER}} .farmart-simple-text a ' => 'justify-content: {{VALUE}};',
				],
				'separator'   => 'after',
			]
		);

		$this->add_responsive_control(
			'general_spacing',
			[
				'label'     => __( 'Spacing Left', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 200,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .farmart-simple-text' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'general_spacing_ri',
			[
				'label'     => __( 'Spacing Right', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 200,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .farmart-simple-text' => 'margin-right: {{SIZE}}{{UNIT}};',
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
	protected function section_icon_style() {
		$this->start_controls_section(
			'section_icon_style',
			[
				'label' => __( 'Icon', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'icon_margin',
			[
				'label'              => esc_html__( 'Margin', 'farmart-addons' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'allowed_dimensions' => [ 'top', 'right' ],
				'size_units'         => [ 'px', '%' ],
				'default'            => [],
				'selectors'          => [
					'{{WRAPPER}} .farmart-simple-text .farmart-svg-icon' => 'margin-top: {{TOP}}{{UNIT}};margin-right: {{RIGHT}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'icon_font_size',
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
					'{{WRAPPER}} .farmart-simple-text .farmart-svg-icon' => 'font-size: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-simple-text .farmart-svg-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .farmart-simple-text .farmart-svg-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_hover_color',
			[
				'label'     => __( 'Hover Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-simple-text:hover .farmart-svg-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .farmart-simple-text:hover .farmart-svg-icon svg' => 'fill: {{VALUE}};',
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
	protected function section_title_style() {
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => __( 'Title', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->start_controls_tabs( 'style_text' );

		$this->start_controls_tab( 'style_title', [ 'label' => esc_html__( 'Title', 'farmart-addons' ) ] );

		$this->add_responsive_control(
			'title_spacing',
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
					'{{WRAPPER}} .farmart-simple-text.highlight-after .title' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .farmart-simple-text.highlight-under .title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-simple-text .title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label'     => __( 'Hover Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-simple-text:hover .title' => 'color: {{VALUE}};',
					'{{WRAPPER}} .farmart-simple-text a:hover .box-title .title:after, .farmart-simple-text a:hover .box-title .highlight:after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .farmart-simple-text .title',
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab( 'style_af_title', [ 'label' => esc_html__( 'Highlight', 'farmart-addons' ) ] );

		$this->add_control(
			'aftitle_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-simple-text .highlight' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'aftitle_typography',
				'selector' => '{{WRAPPER}} .farmart-simple-text .highlight',
			]
		);
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Element in Tab Style
	 *
	 * Line
	 */
	protected function section_line_style() {
		$this->start_controls_section(
			'section_line_style',
			[
				'label' => __( 'Line', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'line_spacing',
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
					'{{WRAPPER}} .farmart-simple-text .line' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
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
					'{{WRAPPER}} .farmart-simple-text .line' => 'width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .farmart-simple-text .line' => 'height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .farmart-simple-text .line' => 'background-color: {{VALUE}};',
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
				'farmart-simple-text',
				'highlight-'.$settings['position_highlight'],
			]
		);

		$icon = $title  = '';

		if ( $settings['icon'] && ! empty($settings['icon']['value'])  && \Elementor\Icons_Manager::is_migration_allowed() ) {
			ob_start();
			\Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
			$icon = '<span class="farmart-svg-icon">' . ob_get_clean() . '</span>';
		}

		if( empty( $icon ) ) {
			$icon = '<span class="farmart-svg-icon"><svg viewBox="0 0 32 32"><path d="M8 32c-0.205 0-0.409-0.078-0.566-0.234-0.312-0.312-0.312-0.819 0-1.131l13.834-13.834-13.834-13.834c-0.312-0.312-0.312-0.819 0-1.131s0.819-0.312 1.131 0l14.4 14.4c0.312 0.312 0.312 0.819 0 1.131l-14.4 14.4c-0.156 0.156-0.361 0.234-0.566 0.234z"></path></svg></span>';
		}

		$line = '<span class="line"></span>';

		if ( $settings['title'] ) {
			$title = '<span class="title">' . $settings['title'] . '</span>';
		}

		if ( $settings['af_title'] ) {
			$tag = $settings['position_highlight'] == 'after' ? 'span' : 'div';
			$title .= sprintf('<%s class ="highlight"> %s </%s>',$tag,$settings['af_title'],$tag);
		}
		$title_html = sprintf('<span class="box-title">%s </span>',$title);

		$output = $icon. $title_html. $line;

		$output_html = $settings['link']['url'] ? $this->get_link_control( 'link', $settings['link'], $output, '' ) : $output;

		echo sprintf(
			'<div %s>%s</div>',
			$this->get_render_attribute_string( 'wrapper' ),
			$output_html
		);

	}

	protected function get_link_control( $link_key, $url, $content, $attr = [] ) {
		$attr_default = [
			'href' => $url['url'] ? $url['url'] : '#',
		];

		if ( $url['is_external'] ) {
			$attr_default['target'] = '_blank';
		}

		if ( $url['nofollow'] ) {
			$attr_default['rel'] = 'nofollow';
		}

		$attr = wp_parse_args( $attr, $attr_default );

		$this->add_render_attribute( $link_key, $attr );

		return sprintf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( $link_key ), $content );
	}
}