<?php

namespace FarmartAddons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use FarmartAddons\Elementor;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Image Box widget
 */
class Testimonial_Banner extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'farmart-testimonial-banner';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Farmart - Testimonial Banner', 'farmart-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-testimonial';
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

	protected function section_content() {
		$this->section_setting_content();
		$this->section_carousel_content();
	}

	protected function section_setting_content( ) {
		$this->start_controls_section(
			'section_content',
			[ 'label' => esc_html__( 'Content', 'farmart-addons' ) ]
		);

		$this->add_control(
			'heading_text',
			[
				'label'     => esc_html__( 'Heading', 'farmart-addons' ),
				'type'      => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Our Happy Customers', 'farmart-addons' ),
				'label_block' => true,
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'banners_background',
				'label'    => __( 'Background', 'farmart-addons' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .farmart-testimonial-banner__wrapper',
				'fields_options'  => [
					'background' => [
						'default' => 'classic',
					],
					'image' => [
						'default'   => [
							'url' => 'https://via.placeholder.com/1170X670/f8f8f8?text=1170x670+Image',
						],
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				// Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default'   => 'full',
				'separator' => 'before',
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'image',
			[
				'label'   => esc_html__( 'Image Avatar', 'farmart-addons' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/70x70/f5f5f5?text=70x70',
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				// Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default'   => 'full',
				'separator' => 'none',
			]
		);

		$repeater->add_control(
			'name', [
				'label'       => esc_html__( 'Name', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'address', [
				'label'       => esc_html__( 'Job', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
				'separator' => 'after',
			]
		);

		$repeater->add_control(
			'desc', [
				'label'       => esc_html__( 'Description', 'farmart-addons' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => '',
				'label_block' => true,
				'separator' => 'after',
			]
		);

		$repeater->add_control(
			'icon',
			[
				'label'     => esc_html__( 'Icon', 'farmart-addons' ),
				'type'      => Controls_Manager::ICONS,
				'default'          => [
					'value'   => 'icon-quote-open',
					'library' => 'linearicons',
				],
			]
		);

		$this->add_control(
			'elements',
			[
				'label'         => esc_html__( 'Elements', 'farmart-addons' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [
					[
						'name' => esc_html__( 'Beatrice M.', 'farmart-addons' ),
						'job' => esc_html__( 'Masterchef at LA', 'farmart-addons' ),
						'desc' => esc_html__( '"It\'s incredible. I STRONGLY recommend Farmart to EVERYONE interested in running a successful online business!"', 'farmart-addons' ),
					],[
						'name' => esc_html__( 'Zorana S.', 'farmart-addons' ),
						'job' => esc_html__( 'Housewife', 'farmart-addons' ),
						'desc' => esc_html__( '"Not able to tell you how happy I am with Farmart. Keep up the excellent work."', 'farmart-addons' ),
					],[
						'name' => esc_html__( 'Robinia U.', 'farmart-addons' ),
						'job' => esc_html__( 'Masterchef', 'farmart-addons' ),
						'desc' => esc_html__( '"I would be lost without Farmart Platform. If you are not sure, always go for Farmart Platform."', 'farmart-addons' ),
					]
				],
				'title_field'   => '{{{ name }}}',
				'prevent_empty' => false,
			]
		);

		$this->end_controls_section();
	}

	protected function section_carousel_content() {

		$this->start_controls_section(
			'section_carousel_settings',
			[ 'label' => esc_html__( 'Carousel Settings', 'farmart-addons' ) ]
		);
		$this->add_responsive_control(
			'slidesToShow',
			[
				'label'   => esc_html__( 'Slides to show', 'farmart-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'default' => 1,
			]
		);
		$this->add_responsive_control(
			'rows',
			[
				'label'   => esc_html__( 'Rows', 'farmart-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 10,
				'default' => 2,
			]
		);
		$this->add_responsive_control(
			'slidesToScroll',
			[
				'label'   => esc_html__( 'Slides to scroll', 'farmart-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 4,
				'default' => 1,
			]
		);
		$this->add_responsive_control(
			'navigation',
			[
				'label'   => esc_html__( 'Navigation', 'farmart-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'both'   => esc_html__( 'Arrows and Dots', 'farmart-addons' ),
					'arrows' => esc_html__( 'Arrows', 'farmart-addons' ),
					'dots'   => esc_html__( 'Dots', 'farmart-addons' ),
					'none'   => esc_html__( 'None', 'farmart-addons' ),
				],
				'default' => 'arrows',
				'toggle'  => false,
			]
		);

		$this->add_control(
			'infinite',
			[
				'label'     => __( 'Infinite Loop', 'farmart-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'farmart-addons' ),
				'label_on'  => __( 'On', 'farmart-addons' ),
				'default'   => 'yes'
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'     => __( 'Autoplay', 'farmart-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'farmart-addons' ),
				'label_on'  => __( 'On', 'farmart-addons' ),
				'default'   => 'no'
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'   => __( 'Autoplay Speed (in ms)', 'farmart-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3000,
				'min'     => 100,
				'step'    => 100,
			]
		);

		$this->add_control(
			'speed',
			[
				'label'       => __( 'Speed', 'farmart-addons' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 800,
				'min'         => 100,
				'step'        => 50,
				'description' => esc_html__( 'Slide animation speed (in ms)', 'farmart-addons' ),
			]
		);

		// Additional Settings
		$this->_register_responsive_settings_controls();

		$this->end_controls_section();
	}

	protected function _register_responsive_settings_controls() {
		$this->add_control(
			'responsive_settings_divider',
			[
				'label' => __( 'Additional Settings', 'farmart-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'responsive_breakpoint', [
				'label' => __( 'Breakpoint', 'farmart-addons' ) . ' (px)',
				'description' => __( 'Below this breakpoint the options below will be triggered', 'farmart-addons' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 1200,
				'min'             => 320,
				'max'             => 1920,
			]
		);
		$repeater->add_control(
			'responsive_rows',
			[
				'label'           => esc_html__( 'Rows', 'farmart-addons' ),
				'type'            => Controls_Manager::NUMBER,
				'min'             => 1,
				'default' => 2,
			]
		);
		$repeater->add_control(
			'responsive_slidesToShow',
			[
				'label'           => esc_html__( 'Slides to show', 'farmart-addons' ),
				'type'            => Controls_Manager::NUMBER,
				'min'             => 1,
				'default' => 1,
			]
		);
		$repeater->add_control(
			'responsive_slidesToScroll',
			[
				'label'           => esc_html__( 'Slides to scroll', 'farmart-addons' ),
				'type'            => Controls_Manager::NUMBER,
				'min'             => 1,
				'default' => 1,
			]
		);
		$repeater->add_control(
			'responsive_navigation',
			[
				'label'           => esc_html__( 'Navigation', 'farmart-addons' ),
				'type'            => Controls_Manager::SELECT,
				'options'         => [
					'both'   => esc_html__( 'Arrows and Dots', 'farmart-addons' ),
					'arrows' => esc_html__( 'Arrows', 'farmart-addons' ),
					'dots'   => esc_html__( 'Dots', 'farmart-addons' ),
					'none'   => esc_html__( 'None', 'farmart-addons' ),
				],
				'default' => 'dots',
				'toggle'          => false,
			]
		);

		$this->add_control(
			'carousel_responsive_settings',
			[
				'label' => __( 'Settings', 'farmart-addons' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default' => [

				],
				'title_field' => '{{{ responsive_breakpoint }}}' . 'px',
				'prevent_empty' => false,
			]
		);
	}

	// Style
	protected function section_style() {
		$this->section_heading_style();
		$this->section_content_style();
		$this->section_carousel_style();
	}

	protected function section_heading_style() {
		$this->start_controls_section(
			'section_heading_style',
			[
				'label' => esc_html__( 'Heading', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'heading_spacing',
			[
				'label'      => __( 'Spacing', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [],
				'selectors'  => [
					'{{WRAPPER}} .farmart-testimonial-banner .heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'style_heading_typography',
				'selector' => '{{WRAPPER}} .farmart-testimonial-banner .heading',
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-testimonial-banner .heading'  => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function section_content_style() {
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'label' => esc_html__( 'Width ', 'farmart-addons' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => ['px','%','em' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-testimonial-banner__list' => 'width: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label' => esc_html__( 'Padding ', 'farmart-addons' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => ['px','%','em' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-testimonial-banner__list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_control(
			'bk_color',
			[
				'label'     => __( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-testimonial-banner__list'  => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_border_radius',
			[
				'label'     => esc_html__( 'Border Width', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-testimonial-banner__list .slick-slide > *:not(:last-child) .box-item' => 'border-width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .farmart-testimonial-banner__list .slick-slide > *:not(:last-child) .box-item'  => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'box_qoute_heading',
			[
				'label' => esc_html__( 'Box Quote', 'farmart-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs('content_quote');
		$this->start_controls_tab(
			'style_icon',
			[
				'label'         => esc_html__( 'Icon', 'farmart-addons' ),
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
					'{{WRAPPER}} .farmart-testimonial-banner .box-item__content .farmart-svg-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .farmart-testimonial-banner .box-item__content .farmart-svg-icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .farmart-testimonial-banner .box-item__content .farmart-svg-icon svg'     => 'fill: {{VALUE}};',
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
					'{{WRAPPER}} .farmart-testimonial-banner .box-item__content .farmart-svg-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .farmart-testimonial-banner .box-item__content .farmart-svg-icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->start_controls_tab(
			'style_desc',
			[
				'label'         => esc_html__( 'Description', 'farmart-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'style_desc_typography',
				'selector' => '{{WRAPPER}} .farmart-testimonial-banner .box-item__content .desc',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-testimonial-banner .box-item__content .desc'     => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'box_author_heading',
			[
				'label' => esc_html__( 'Box Author', 'farmart-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs('box_author_style');

		$this->start_controls_tab('style_img_author',
			[
				'label'         => esc_html__( 'Avatar', 'farmart-addons' ),
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
					'{{WRAPPER}} .farmart-testimonial-banner .box-item__image img' => 'margin-right: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .farmart-testimonial-banner .box-item__image img' => 'width: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .farmart-testimonial-banner .box-item__image img' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab('style_name_autho',
			[
				'label'         => esc_html__( 'Name', 'farmart-addons' ),
			]
		);

		$this->add_responsive_control(
			'name_author_spacing',
			[
				'label'      => __( 'Spacing', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [],
				'selectors'  => [
					'{{WRAPPER}} .farmart-testimonial-banner .box-item__content .box-text' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'style_name_author_typography',
				'selector' => '{{WRAPPER}} .farmart-testimonial-banner .box-item__content .name',
			]
		);

		$this->add_control(
			'name_author_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-testimonial-banner .box-item__content .name'     => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab('style_address_author',
			[
				'label'         => esc_html__( 'Job', 'farmart-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'style_add_author_typography',
				'selector' => '{{WRAPPER}} .farmart-testimonial-banner .box-item__content .job',
			]
		);

		$this->add_control(
			'add_author_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-testimonial-banner .box-item__content .job'     => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function section_carousel_style() {
		$this->start_controls_section(
			'section_carousel_style',
			[
				'label' => esc_html__( 'Carousel Settings', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'arrows_style_divider',
			[
				'label' => esc_html__( 'Arrows', 'farmart-addons' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		// Arrows
		$this->add_control(
			'arrows_style',
			[
				'label'        => __( 'Options', 'farmart-addons' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'farmart-addons' ),
				'label_on'     => __( 'Custom', 'farmart-addons' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'sliders_arrows_size',
			[
				'label'     => __( 'Size', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-testimonial-banner .slick-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'sliders_arrow_width',
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
					'{{WRAPPER}} .farmart-testimonial-banner .slick-arrow' => 'width: {{SIZE}}{{UNIT}}',
				],
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'sliders_arrow_height',
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
					'{{WRAPPER}} .farmart-testimonial-banner .slick-arrow' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'sliders_arrows_offset',
			[
				'label'     => esc_html__( 'Horizontal Offset', 'farmart-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'step'      => 1,
				'selectors' => [
					'{{WRAPPER}} .farmart-testimonial-banner .slick-prev-arrow' => 'right: {{VALUE}}px;',
				],
			]
		);

		$this->end_popover();

		$this->start_controls_tabs( 'sliders_normal_settings' );

		$this->start_controls_tab( 'sliders_normal', [ 'label' => esc_html__( 'Normal', 'farmart-addons' ) ] );

		$this->add_control(
			'sliders_arrow_background',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-testimonial-banner .slick-arrow' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sliders_arrow_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-testimonial-banner .slick-arrow' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'sliders_hover', [ 'label' => esc_html__( 'Hover', 'farmart-addons' ) ] );

		$this->add_control(
			'sliders_arrow_hover_background',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-testimonial-banner .slick-arrow:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sliders_arrow_hover_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-testimonial-banner .slick-arrow:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'dots_style_divider',
			[
				'label'     => esc_html__( 'Dots', 'farmart-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'dots_style',
			[
				'label'        => __( 'Options', 'farmart-addons' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'farmart-addons' ),
				'label_on'     => __( 'Custom', 'farmart-addons' ),
				'return_value' => 'yes',
			]
		);
		$this->start_popover();
		$this->add_control(
			'dots_border_radius',
			[
				'label'     => esc_html__( 'Border Radius', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-testimonial-banner  .slick-dots li button:before' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'sliders_dots_gap',
			[
				'label'     => __( 'Gap', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-testimonial-banner .slick-dots li' => 'margin: 0 {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'sliders_dots_offset',
			[
				'label'     => esc_html__( 'Vertical Offset', 'farmart-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'step'      => 1,
				'selectors' => [
					'{{WRAPPER}} .farmart-testimonial-banner .slick-dots' => 'bottom: {{VALUE}}px;',
				],
			]
		);
		$this->end_popover();

		$this->start_controls_tabs( 'dots_tabs' );

		$this->start_controls_tab( 'dots_normal', [ 'label' => esc_html__( 'Normal', 'farmart-addons' ) ] );

		$this->add_control(
			'dots_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-testimonial-banner  .slick-dots li button:before' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'dots_width',
			[
				'label'      => esc_html__( 'Width', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-testimonial-banner  .slick-dots li button,{{WRAPPER}} .farmart-testimonial-banner  .slick-dots li button:before' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'dots_height',
			[
				'label'      => esc_html__( 'Height', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-testimonial-banner  .slick-dots li button,{{WRAPPER}} .farmart-testimonial-banner  .slick-dots li button:before' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'dots_hover', [ 'label' => esc_html__( 'Hover', 'farmart-addons' ) ] );

		$this->add_control(
			'dots_hover_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-testimonial-banner  .slick-dots li button:hover:before' => 'background-color: {{VALUE}};',
				],
				'default'   => '',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'dots_active', [ 'label' => esc_html__( 'Active', 'farmart-addons' ) ] );

		$this->add_control(
			'dots_active_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-testimonial-banner  .slick-dots li.slick-active button:before' => 'background-color: {{VALUE}};'
				],
				'default'   => '',
			]
		);

		$this->add_control(
			'dots_active_width',
			[
				'label'      => esc_html__( 'Width', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-testimonial-banner  .slick-dots li.slick-active button,{{WRAPPER}} .farmart-testimonial-banner  .slick-dots li.slick-active button:before' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'dots_active_height',
			[
				'label'      => esc_html__( 'Height', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-testimonial-banner  .slick-dots li.slick-active button,{{WRAPPER}} .farmart-testimonial-banner  .slick-dots li.slick-active button:before' => 'height: {{SIZE}}{{UNIT}};',
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

		$nav        = $settings['navigation'];
		$nav_tablet = empty( $settings['navigation_tablet'] ) ? $nav : $settings['navigation_tablet'];
		$nav_mobile = empty( $settings['navigation_mobile'] ) ? $nav : $settings['navigation_mobile'];

		$this->add_render_attribute(
			'wrapper', 'class', [
				'farmart-testimonial-banner',
				'navigation-' . $nav,
				'navigation-tablet-' . $nav_tablet,
				'navigation-mobile-' . $nav_mobile,
			]
		);

		$this->add_render_attribute(
			'wrapper', 'data-show', [
				intval($settings['slidesToShow'])
			]
		);
		$output = [ ];
		$els = $settings['elements'];

		$prev = \Farmart\Icon::get_svg( 'chevron-left', 'slick-prev-arrow' );
		$next = \Farmart\Icon::get_svg( 'chevron-right', 'slick-next-arrow' );
		$box_arrow = sprintf('<div class="box-arrow slick-arrow">%s %s</div>',$prev,$next);

		if ( $settings['title'] ) {
			$title = '<h3 class="heading">' . $settings['title'] . '</h3>';
		}

		$this->add_render_attribute( 'slicks', 'data-slick', wp_json_encode( Elementor::get_data_slick( $settings ) ) );

		if ( ! empty ( $els ) ) {
			$output[] = '<div class="farmart-testimonial-banner__box-heading">';
			$output[] = $title;
			$output[] = $box_arrow;
			$output[] = '</div>';
			$output[] = '<div class="farmart-testimonial-banner__wrapper">';
			$output[] = '<div class="farmart-testimonial-banner__list row-flex" '. $this->get_render_attribute_string( 'slicks' ).' >';

			foreach ( $els as $index => $item ) {
				$name  = $image = '';

				$settings['image']      = $item['image'];
				$image = Group_Control_Image_Size::get_attachment_image_html( $settings );

				if ( $item['icon'] && \Elementor\Icons_Manager::is_migration_allowed() ) {
					ob_start();
					\Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] );
					$icon = '<span class="farmart-svg-icon">' . ob_get_clean() . '</span>';
				}

				if ( $item['name'] ) {
					$name = '<h5 class="name">' . $item['name'] . '</h5>';
				}

				if ( $item['job'] ) {
					$address = '<span class="job">' . $item['job'] . '</span>';
				}

				if ( $item['desc'] ) {
					$desc = '<div class="desc">' . $item['desc'] . '</div>';
				}
				$box_ing = sprintf('<div class="box-item__image">%s</div>',$image);

				$box_text = sprintf('<div class="box-text">%s %s</div>',$name,$address);

				$box_content = sprintf('<div class="box-item__content">%s %s %s</div>',$icon,$box_text,$desc);

				$col = intval(12/$settings['slidesToShow']);
				$output[] = sprintf(
					'<div class="box-item col-flex-md-%s"><div class="box-item--inner">%s %s </div> </div>',
					esc_attr($col),$box_ing,$box_content
				);
			}

			$output[] = '</div>';
			$output[] = '</div>';
		}

		?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
	        <?php echo implode( '', $output ) ?>
        </div>
		<?php
	}
}