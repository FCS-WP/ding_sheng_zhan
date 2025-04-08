<?php

namespace FarmartAddons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Tab List widget
 */
class Tab_List extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'farmart-tab-list';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Farmrt - Tab List', 'farmart-addons' );
	}

	/**
	 * Retrieve the widget circle.
	 *
	 * @return string Widget circle.
	 */
	public function get_icon() {
		return 'eicon-tabs';
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
			[ 'label' => esc_html__( 'Tab List', 'farmart-addons' ) ]
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

		$repeater = new \Elementor\Repeater();

		$repeater->start_controls_tabs(
			'content_wrapper_tabs'
		);

		$repeater->start_controls_tab(
			'content_wrapper_tab',
			[
				'label' => __( 'Tab Content', 'farmart-addons' ),
			]
		);

		$repeater->add_control(
			'image',
			[
				'label'   => esc_html__( 'Image', 'farmart-addons' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/90x90/f5f5f5?text=90x90',
				],
			]
		);

		$repeater->add_control(
			'content_title',
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

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'content_tab',
			[
				'label' => __( 'Tab Nav', 'farmart-addons' ),
			]
		);

		$repeater->add_control(
			'nav_title',
			[
				'label'       => esc_html__( 'Title', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'This is title', 'farmart-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_responsive_control(
			'position',
			[
				'label' => __( 'Position', 'farmart-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-tab-list {{CURRENT_ITEM}}' => 'left: {{SIZE}}{{UNIT}};',
					'(tablet) {{WRAPPER}} .farmart-tab-list {{CURRENT_ITEM}}' => 'left: 0; top: {{SIZE}}{{UNIT}};',
					'(mobile) {{WRAPPER}} .farmart-tab-list {{CURRENT_ITEM}}' => 'left: 0; top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$repeater->add_responsive_control(
			'text_align',
			[
				'label'       => esc_html__( 'Text Align', 'farmart-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'left'   => [
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
				'selectors'   => [
					'{{WRAPPER}} .farmart-tab-list {{CURRENT_ITEM}}' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'element',
			[
				'label'   => '',
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater->get_controls(),
				'default' => [
					[
						'content_title'         => esc_html__( 'This is title', 'farmart-addons' ),
						'nav_title'             => esc_html__( 'This is title', 'farmart-addons' ),
						'desc'                  => esc_html__( 'This is description', 'farmart-addons' ),
						'position' 				=> [
													'unit' => '%',
													'size' => 0,
												],
					],
					[
						'content_title'         => esc_html__( 'This is title', 'farmart-addons' ),
						'nav_title'             => esc_html__( 'This is title', 'farmart-addons' ),
						'desc'                  => esc_html__( 'This is description', 'farmart-addons' ),
						'position' 				=> [
													'unit' => '%',
													'size' => 25,
												],
					],
					[
						'content_title'         => esc_html__( 'This is title', 'farmart-addons' ),
						'nav_title'             => esc_html__( 'This is title', 'farmart-addons' ),
						'desc'                  => esc_html__( 'This is description', 'farmart-addons' ),
						'position' 				=> [
													'unit' => '%',
													'size' => 50,
												],
					],
					[
						'content_title'         => esc_html__( 'This is title', 'farmart-addons' ),
						'nav_title'             => esc_html__( 'This is title', 'farmart-addons' ),
						'desc'                  => esc_html__( 'This is description', 'farmart-addons' ),
						'position' 				=> [
													'unit' => '%',
													'size' => 75,
												],
					],
					[
						'content_title'         => esc_html__( 'This is title', 'farmart-addons' ),
						'nav_title'             => esc_html__( 'This is title', 'farmart-addons' ),
						'desc'                  => esc_html__( 'This is description', 'farmart-addons' ),
						'position' 				=> [
													'unit' => '%',
													'size' => 100,
												],
					],
				],
				'title_field'   => '{{{ content_title }}}',

			]
		);

		$this->end_controls_section();

	}

	/**
	 * Section Style
	 */
	protected function section_style() {
		$this->section_content_style();
		$this->section_nav_style();
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
					'{{WRAPPER}} .farmart-tab-list .box-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .farmart-tab-list .box-content' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .farmart-tab-list .box-nav:after' => 'border-top-color: {{VALUE}};',
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
				'default'   => 'solid',
				'toggle'    => false,
				'selectors' => [
					'{{WRAPPER}} .farmart-tab-list .box-content' => 'border-style: {{VALUE}};',
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
					'{{WRAPPER}} .farmart-tab-list .box-content' => 'border-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .farmart-tab-list .box-nav:after' => 'margin-top: -{{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .farmart-tab-list .box-content' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .farmart-tab-list .box-nav:before' => 'border-top-color: {{VALUE}};',
				],
			]
		);

		$this->end_popover();

		$this->start_controls_tabs(
			'style_tabs'
		);

		// Number
		$this->start_controls_tab(
			'content_number',
			[
				'label' => __( 'Image', 'farmart-addons' ),
			]
		);

		$this->add_responsive_control(
			'img_author_spacing',
			[
				'label'      => __( 'Spacing', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [],
				'selectors'  => [
					'{{WRAPPER}} .farmart-tab-list .box-img img' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'img_author_width',
			[
				'label'      => esc_html__( 'Width', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .farmart-tab-list .box-img img' => 'max-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'img_author_height',
			[
				'label'      => esc_html__( 'Height', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .farmart-tab-list .box-img img' => 'max-height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_tab();

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
				'selector' => '{{WRAPPER}} .farmart-tab-list .box-content .title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-tab-list .box-content .title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'note_spacing',
			[
				'label'     => __( 'Spacing', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .farmart-tab-list .title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .farmart-tab-list .box-note',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-tab-list .box-note' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	protected function section_nav_style() {

		$this->start_controls_section(
			'section_nav_style',
			[
				'label' => __( 'Nav', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs(
			'style_nav_tabs'
		);

		// Title
		$this->start_controls_tab(
			'nav_title',
			[
				'label' => __( 'Title', 'farmart-addons' ),
			]
		);

		$this->add_responsive_control(
			'box_nav_top',
			[
				'label'     => __( 'Spacing', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .farmart-tab-list .box-nav .nav-title' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'nav_title_typography',
				'selector' => '{{WRAPPER}} .farmart-tab-list .box-nav .nav-title',
			]
		);

		$this->add_control(
			'nav_title_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-tab-list .box-nav .nav-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'nav_ac_title_color',
			[
				'label'     => __( 'Active Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-tab-list .box-nav.active .nav-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Icon
		$this->start_controls_tab(
			'nav_circle',
			[
				'label' => __( 'Circle', 'farmart-addons' ),
			]
		);

		$this->add_control(
			'circle_radius',
			[
				'label'     => __( 'Border Radius', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'%' => [
						'max' => 50,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .farmart-tab-list .circle' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'circle_height',
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
					'{{WRAPPER}} .farmart-tab-list .circle' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'circle_width',
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
					'{{WRAPPER}} .farmart-tab-list .circle' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'circle_color',
			[
				'label'     => __( 'Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-tab-list .circle' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'circle_bk_color',
			[
				'label'     => __( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-tab-list .circle' => 'background-color: {{VALUE}};',
				],
			]

		);

		$this->add_control(
			'ac_circle_color',
			[
				'label'     => __( 'Active Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-tab-list .box-nav.active .circle' => 'border-color: {{VALUE}};',
				],
			]

		);

		$this->add_control(
			'ac_circle_bk_color',
			[
				'label'     => __( 'Actice Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-tab-list .box-nav.active .circle' => 'background-color: {{VALUE}};',
				],
			]

		);

		$this->end_controls_tab();

		// Line
		$this->start_controls_tab(
			'nav_line',
			[
				'label' => __( 'Line', 'farmart-addons' ),
			]
		);

		$this->add_control(
			'line_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-tab-list .tab__nav:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'line_height',
			[
				'label'     => __( 'Height', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 10,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .farmart-tab-list .tab__nav:before' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'line_height_spacing',
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
					'{{WRAPPER}} .farmart-tab-list .tab__nav:before' => 'top: calc(100% - {{SIZE}}{{UNIT}});',
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
			'farmart-tab-list'
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		$output_list = $output_events = array();
		$tab_item = $tab_content = '';

		foreach (  $settings["element"]  as $index => $item ) {

			$settings['image']      = $item['image'];
			$image = Group_Control_Image_Size::get_attachment_image_html( $settings );

			$nav_title     = $item["nav_title"] ? '<div class="nav-title">'. $item["nav_title"] . '</div>' : '';
			$title     = $item["content_title"] ? '<h6 class="title">' . $item["content_title"] . '</h6>' : '';
			$desc = $item['desc'] ? sprintf( '<div class="box-note">%s</div>', $item["desc"]  ) : '';

			if ( $item["nav_title"] ) {
				$tab_item = sprintf( '<div class="tab-pointer"><span class="circle"></span> %s</div>' , $nav_title );
			}

			$img_html = $image == '' ? '' : sprintf('<div class="box-img">%s</div>',$image);
			$text_html = $title == '' && $desc == '' ? '' : sprintf( '<div class="box-text">%s %s</div>' ,$title, $desc  );

			$tab_content = $title == '' && $desc == '' ? '' : sprintf( '<div class="box-content">%s %s</div>' ,$img_html, $text_html  );

			$output_list[] = sprintf( '<li class="elementor-repeater-item-%s box-nav">%s %s</li>' , $item['_id'], $tab_item, $tab_content );

		}

		if ( $output_list ) {
			$output[] = sprintf( '<ul class="tab__nav"> %s</ul>', implode( '', $output_list) );
		}

		echo sprintf(
			'<div %s>%s</div>',
			$this->get_render_attribute_string( 'wrapper' ),
			implode( '', $output )
		);
	}
}