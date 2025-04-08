<?php

namespace FarmartAddons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;
use Elementor\Controls_Stack;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Map widget
 */
class Map extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'farmart-map';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Farmart - Map', 'farmart-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-google-maps';
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
			'farmart-elementor',
			'mapbox',
			'mapboxgl',
			'mapbox-sdk'
		];
	}

	public function get_style_depends() {
		return [
			'mapbox',
			'mapboxgl'
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
			'access_token',
			[
				'label'       => esc_html__( 'Access Token', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Enter your access token', 'farmart-addons' ),
				'label_block' => true,
				'description' => sprintf(__('Please go to <a href="%s" target="_blank">Maps Box APIs</a> to get a key', 'farmart-addons'), esc_url('https://www.mapbox.com')),
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				// Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default'   => 'full',
				'separator' => 'none',
			]
		);

		$this->add_control(
			'image',
			[
				'label'   => esc_html__( 'Marker', 'farmart-addons' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/40x40/f5f5f5?text=40x40',
				],
			]
		);


		$this->add_control(
			'local',
			[
				'label'       => esc_html__( 'Local', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
			]
		);

		$this->add_control(
			'zoom',
			[
				'label'       => esc_html__( 'Zoom', 'farmart-addons' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => '13',
				'label_block' => true,
			]
		);

		$this->add_control(
			'mode',
			[
				'label'       => esc_html__( 'Mode', 'farmart-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'light' => esc_html__( 'Light', 'farmart-addons' ),
					'dark'  => esc_html__( 'Dark', 'farmart-addons' ),
				],
				'default'     => 'light',
				'label_block' => true,
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Section Style
	 */

	protected function section_style() {
		$this->start_controls_section(
			'style_general',
			[
				'label' => __( 'Content', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'item_padding',
			[
				'label'      => esc_html__( 'Padding Item', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-map' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'color_1',
			[
				'label'     => esc_html__( 'Color water', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'color_2',
			[
				'label'     => esc_html__( 'Color building', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label'     => esc_html__( 'Map Height', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .farmart-map' => 'height: {{SIZE}}{{UNIT}}',
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

		$id     = uniqid( 'farmart-map-' );

		$this->add_render_attribute(
			'wrapper', 'class', [
				'farmart-map',
			]
		);

		$this->add_render_attribute( 'wrapper', 'id', $id );

		$output    =  [];

		$image = $settings[ 'image' ];
		$src = Group_Control_Image_Size::get_attachment_image_src( $image['id'], 'image', $settings );

		// JS
		$local                       = empty( $settings['local'] ) ? 'New York, United States' : $settings['local'];
		$color_1                     = $settings['color_1'] ? $settings['color_1'] : '#c8d7d4';
		$color_2                     = $settings['color_2'] ? $settings['color_2'] : '#f0f0ec';

		 $output_map = array(
			'marker'  => $src,
			'token'   => $settings['access_token'],
			'zom'     => intval( $settings['zoom'] ),
			'color_1' => $color_1,
			'color_2' => $color_2,
			'local'   => $local,
			'mode'   => $settings['mode'],
		);

		$this->add_render_attribute('map','data-map',wp_json_encode($output_map) );

		echo sprintf(
			'<div %s %s><div id="map">%s</div></div>',
			$this->get_render_attribute_string( 'wrapper' ),
			$this->get_render_attribute_string( 'map' ),
			implode( '', $output )
		);

	}
}