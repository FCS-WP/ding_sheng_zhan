<?php

namespace FarmartAddons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon Box widget
 */
class Banner_Video extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'fm-banner-video';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Farmart - Banner Video', 'farmart-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-youtube';
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
		return [ 'video', 'banner' ];
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
			'image', [
				'label' => esc_html__( 'Icon', 'farmart-addons' ),
				'type'  => Controls_Manager::MEDIA,
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'default'   => 'thumbnail',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => esc_html__( 'Link Video', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
				'label_block' => true,
			]
		);

		$this->add_control(
			'title',
			[
				'label'     => esc_html__( 'Title', 'farmart-addons' ),
				'type'      => Controls_Manager::TEXTAREA,
				'default'   => esc_html__( 'Advantages you can expect when you sign up for our equipment leasing vendor program.', 'farmart-addons' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'   => esc_html__( 'Button', 'farmart-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Read the article', 'farmart-addons' ),
			]
		);

		$this->add_control(
			'button_link',
			[
				'label'       => esc_html__( 'Button Link', 'farmart-addons' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'Enter your URL', 'farmart-addons' ),
				'label_block' => true,
				'default'     => [
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				],
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
		$this->section_button_style();
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
					'{{WRAPPER}} .fm-banner-video' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'   => 'after',
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .fm-banner-video' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'   => 'after',
			]
		);

		$this->end_controls_section();
	}

	protected function section_icon_style() {
		$this->start_controls_section(
			'style_icon',
			[
				'label' => __( 'Icon', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'icon_spacing',
			[
				'label'     => __( 'Icon Spacing', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [],
				'range'     => [
					'px' => [
						'min' => 30,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .fm-banner-video .banner-icon'     => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .fm-banner-video .banner-icon .video-play-button .icon-triangle' => 'border-left-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_bg_color',
			[
				'label'     => __( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-banner-video .banner-icon .video-play-button' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .fm-banner-video .banner-icon .video-play-button .animation-ripple' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-banner-video .box-content .title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .fm-banner-video .box-content .title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .fm-banner-video .box-content .title',
			]
		);

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function section_button_style() {
		$this->start_controls_section(
			'section_button_style',
			[
				'label' => __( 'Button', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => __( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-banner-video .box-content .button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => __( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-banner-video .box-content .button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .fm-banner-video .box-content .button',
			]
		);
		$this->add_responsive_control(
			'button_width',
			[
				'label'      => __( 'Width', 'farmart-addons' ),
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
					'{{WRAPPER}} .fm-banner-video .box-content .button' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'     => 'button_border',
				'selector' => '{{WRAPPER}} .fm-banner-video .box-content .button',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'      => __( 'Border Radius', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .fm-banner-video .box-content .button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_text_padding',
			[
				'label'      => __( 'Text Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .fm-banner-video .box-content .button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'fm-banner-video'
			]
		);

		$icon = '<span class="play-banner video-play-button">
                    <span class="icon-triangle"></span>
                    <span class="animation-ripple ripple-1"></span>
                    <span class="animation-ripple ripple-2"></span>
                </span>';

		if ( ! empty( $settings['image']['url'] ) ) {
			$icon = Group_Control_Image_Size::get_attachment_image_html( $settings );
			$icon = $icon ? sprintf( '<span class="box-img">%s</span>', $icon ) : '';
		}

		$box_icon = '<a href="' . $settings['link'] . '">' . $icon . '</a>';

		$button = $this->get_link_control( 'button_link', $settings['button_link'], $settings['button_text'], [ 'class' => 'button' ] );

		$desc = $settings['title'] ? sprintf( '<div class="box-content"><div class="title">%s</div>%s</div>', $settings["title"], $button ) : '';

		echo sprintf(
			'<div %s><div class="banner-icon">%s</div>%s</div>',
			$this->get_render_attribute_string( 'wrapper' ),
			$box_icon,
			$desc
		);
	}

	/**
	 * Render link control output
	 *
	 * @param       $link_key
	 * @param       $url
	 * @param       $content
	 * @param array $attr
	 *
	 * @return string
	 */
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