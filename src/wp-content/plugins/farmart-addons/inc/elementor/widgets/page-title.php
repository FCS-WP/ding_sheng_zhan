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
class Page_Title extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'farmart-page-title';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Farmart - Page Title', 'farmart-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-archive-title';
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
			[ 'label' => esc_html__( 'Title', 'farmart-addons' ) ]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'farmart-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'farmart-addons' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'farmart-addons' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'farmart-addons' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-page-title h1' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'title_length',
			[
				'label'   => __( 'Number of words', 'farmart-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'default' => 55,
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Section Style
	 */
	protected function section_style() {
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => __( 'Title', 'farmart-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );
        $this->add_control(
			'title_color',
			[
				'label' => __( 'Text Color', 'farmart-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-page-title h1' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'selector' => '{{WRAPPER}} .farmart-page-title h1',
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
				'farmart-page-title',
			]
		);

		$titie = get_the_archive_title();
		// Dokan Vendor
		if ( function_exists( 'dokan_is_store_page' ) && dokan_is_store_page() ) {
			$author    = get_user_by( 'id', get_query_var( 'author' ) );
			$shop_info = get_user_meta( get_query_var( 'author' ), 'dokan_profile_settings', true );
			$shop_name = $author->display_name;
			if ( $shop_info && isset( $shop_info['store_name'] ) && $shop_info['store_name'] ) {
				$shop_name = $shop_info['store_name'];
			}
			$titie = $shop_name;

		} // Wcfm Vendor
		elseif ( function_exists( 'wcfm_is_store_page' ) && wcfm_is_store_page() ) {
			$author    = get_user_by( 'id', get_query_var( 'author' ) );
			$shop_name = $author->display_name;
			if ( function_exists( 'wcfmmp_get_store' ) ) {
				$store_user = wcfmmp_get_store( get_query_var( 'author' ) );
				$store_info = $store_user->get_shop_info();
				$shop_name  = $store_info['store_name'];
			}
			$titie = $shop_name;

		}

		echo sprintf(
            '<div %s><h1>%s</h1></div>',
            $this->get_render_attribute_string( 'wrapper' ),
			wp_trim_words( $titie, absint( $settings['title_length'] ) )
		);

	}
}