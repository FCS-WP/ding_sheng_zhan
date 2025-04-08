<?php

namespace FarmartAddons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use FarmartAddons\Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Blog widget
 */
class Blog extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'farmart-blog-shortcode';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Farmart - Blog', 'farmart-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-posts-carousel';
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
		$this->heading_settings_controls();
		$this->blog_settings_controls();
		$this->carousel_settings_controls();
	}

	protected function heading_settings_controls() {
		// Heading Settings
		$this->start_controls_section(
			'section_heading',
			[ 'label' => esc_html__( 'Heading', 'farmart-addons' ) ]
		);
		$this->start_controls_tabs( 'heading_settings_tabs' );
		$this->start_controls_tab(
			'heading_title_tab',
			[
				'label' => __( 'Title', 'farmart-addons' ),
			]
		);

		$this->add_control(
			'bf_title',
			[
				'label'       => esc_html__( 'Before Title', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Heading Name', 'farmart-addons' ),
				'placeholder' => esc_html__( 'Enter your title', 'farmart-addons' ),
				'label_block' => true,
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'links_tab', [ 'label' => esc_html__( 'Links', 'farmart-addons' ) ] );

		$this->add_control(
			'link_text', [
				'label'       => esc_html__( 'Title', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__('View all','farmart-addons'),
				'label_block' => true,
			]
		);

		$this->add_control(
			'link_url', [
				'label'         => esc_html__( 'Link', 'farmart-addons' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'farmart-addons' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$this->add_control(
			'link_icon',
			[
				'label'   => esc_html__( 'Icon', 'farmart-addons' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'icon-chevron-right',
					'library' => 'linearicons',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section(); // End Heading Settings
	}

	protected function blog_settings_controls() {

		// Blogs Settings
		$this->start_controls_section(
			'section_blogs',
			[ 'label' => esc_html__( 'Posts', 'farmart-addons' ) ]
		);

		$this->add_control(
			'source',
			[
				'label'       => esc_html__( 'Source', 'farmart-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'default' => esc_html__( 'Default', 'farmart-addons' ),
					'custom'  => esc_html__( 'Custom', 'farmart-addons' ),
				],
				'default'     => 'default',
				'label_block' => true,
			]
		);
		$this->add_control(
			'ids',
			[
				'label'       => esc_html__( 'Posts', 'farmart-addons' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'farmart-addons' ),
				'type'        => 'fmautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'post',
				'sortable'    => true,
				'condition'   => [
					'source' => 'custom',
				],
			]
		);

		$this->add_control(
			'blog_cats',
			[
				'label'       => esc_html__( 'Categories', 'farmart-addons' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => Elementor::get_taxonomy('category'),
				'default'     => '',
				'multiple'    => true,
				'label_block' => true,
				'condition'   => [
					'source' => 'default',
				],
			]
		);

		$this->add_control(
			'limit',
			[
				'label'     => esc_html__( 'Total post', 'farmart-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 8,
				'min'       => 2,
				'max'       => 50,
				'step'      => 1,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'      => esc_html__( 'Order By', 'farmart-addons' ),
				'type'       => Controls_Manager::SELECT,
				'options'    => [
					''           => esc_html__( 'Default', 'farmart-addons' ),
					'date'       => esc_html__( 'Date', 'farmart-addons' ),
					'name'       => esc_html__( 'Name', 'farmart-addons' ),
					'id'         => esc_html__( 'Ids', 'farmart-addons' ),
					'rand'       => esc_html__( 'Random', 'farmart-addons' ),
				],
				'default'    => '',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'source',
							'value' => 'default',
						]
					]
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'      => esc_html__( 'Order', 'farmart-addons' ),
				'type'       => Controls_Manager::SELECT,
				'options'    => [
					''     => esc_html__( 'Default', 'farmart-addons' ),
					'asc'  => esc_html__( 'Ascending', 'farmart-addons' ),
					'desc' => esc_html__( 'Descending', 'farmart-addons' ),
				],
				'default'    => '',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'source',
							'value' => 'default',
						]
					]
				],
			]
		);

		$this->add_control(
			'excerpt_length',
			[
				'label'     => esc_html__( 'Excerpt Length', 'farmart-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 15,
				'min'       => 2,
				'max'       => 100,
				'separator'  => 'before',
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

		$this->end_controls_section();
	}
	protected function carousel_settings_controls() {
		// Carousel Settings
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
				'max'     => 7,
				'default' => 4,
			]
		);
		$this->add_responsive_control(
			'slidesToScroll',
			[
				'label'   => esc_html__( 'Slides to scroll', 'farmart-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 7,
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
			'autoplay',
			[
				'label'     => __( 'Autoplay', 'farmart-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'farmart-addons' ),
				'label_on'  => __( 'On', 'farmart-addons' ),
				'default'   => 'yes'
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

		$this->end_controls_section(); // End Carousel Settings
	}
	/**
	 * Section Style
	 */
	protected function section_style() {
		$this->section_heading_style();
		$this->section_blog_style();
		$this->section_carousel_style();
	}

	protected function section_heading_style() {
		// Heading Style
		$this->start_controls_section(
			'section_heading_style',
			[
				'label' => esc_html__( 'Heading', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'heading_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-blog-shortcode .heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-blog-shortcode .heading' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'heading_border',
				'label'    => esc_html__( 'Border', 'farmart-addons' ),
				'selector' => '{{WRAPPER}} .farmart-blog-shortcode .heading',
				'fields_options'  => [
					'border' => [
						'default' => 'none',
					],
				],
			]
		);

		$this->start_controls_tabs( 'heading_style_tabs', [ 'separator' => 'before', ] );

		$this->start_controls_tab(
			'heading_bftitle_style',
			[
				'label' => __( 'Before Title', 'farmart-addons' ),
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'bftitle_typography',
				'selector' => '{{WRAPPER}} .farmart-blog-shortcode .box-title span',
			]
		);

		$this->add_control(
			'bftitle_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-blog-shortcode .box-title span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

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
				'selector' => '{{WRAPPER}} .farmart-blog-shortcode .box-title h3',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-blog-shortcode .box-title h3' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'heading_links_style',
			[
				'label' => __( 'Links', 'farmart-addons' ),
			]
		);

		$this->add_responsive_control(
			'link_all_enable',
			[
				'label'     => __( 'Link All', 'farmart-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'farmart-addons' ),
				'label_on'  => __( 'Show', 'farmart-addons' ),
				'default'   => 'yes',
				'selectors_dictionary' => [
					'' => 'display: none',
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-blog-shortcode .heading .extra-link' => '{{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_links_typography',
				'selector' => '{{WRAPPER}} .farmart-blog-shortcode .heading .extra-link',
			]
		);

		$this->add_control(
			'heading_links_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-blog-shortcode .heading .extra-link' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'heading_links_hover_color',
			[
				'label'     => esc_html__( 'Hover Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-blog-shortcode .heading .extra-link:hover' => 'color: {{VALUE}}',
				],
			]
		);

		// Icon
		$this->add_control(
			'link_icon_style',
			[
				'label'        => __( 'Icon', 'farmart-addons' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'farmart-addons' ),
				'label_on'     => __( 'Custom', 'farmart-addons' ),
				'return_value' => 'yes',
			]
		);
		$this->start_popover();

		$this->add_control(
			'link_icon_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .farmart-blog-shortcode .extra-link .farmart-svg-icon' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'link_icon_font_size',
			[
				'label'      => esc_html__( 'Font size', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .farmart-blog-shortcode .extra-link .farmart-svg-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'link_icon_right_spacing',
			[
				'label'      => esc_html__( 'Right Spacing', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .farmart-blog-shortcode .extra-link .farmart-svg-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_popover();

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function section_blog_style() {
		// Heading Style
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'meta_option',
			[
				'label'       => esc_html__( 'Meta', 'farmart-addons' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'label_block' => true,
				'default'     => ['author', 'cat', 'date'],
				'options'     => [
					'author'    => esc_html__( 'Author', 'farmart-addons' ),
					'cat' 		=> esc_html__( 'Category', 'farmart-addons' ),
					'comment'  	=> esc_html__( 'Comment', 'farmart-addons' ),
					'date'  	=> esc_html__( 'Date', 'farmart-addons' ),
				],
			]
		);

		$this->add_control(
			'entry_footer',
			[
				'label'     => __( 'Entry Footer', 'farmart-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'farmart-addons' ),
				'label_on'  => __( 'Show', 'farmart-addons' ),
				'default'   => 'yes',
				'selectors_dictionary' => [
					'' => 'display: none',
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-blog-shortcode .fm-entry-date' => '{{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-blog-shortcode .list-post--wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-blog-shortcode .list-post--wrapper' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'content_border',
				'label'    => esc_html__( 'Border', 'farmart-addons' ),
				'selector' => '{{WRAPPER}} .farmart-blog-shortcode .list-post--wrapper',
				'fields_options'  => [
					'border' => [
						'default' => 'solid',
					],
				],
			]
		);

		$this->add_responsive_control(
			'content_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .farmart-blog-shortcode .list-post--wrapper' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'item_title',
			[
				'label' => esc_html__( 'Title', 'farmart-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator'   => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_title_typography',
				'selector' => '{{WRAPPER}} .farmart-blog-shortcode .entry-title a',
			]
		);

		$this->add_control(
			'item_title_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-blog-shortcode .entry-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_divider',
			[
				'label' => esc_html__( 'Divider', 'farmart-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'item_divider_background_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-blog-shortcode .blog-wrapper' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this -> end_controls_section();
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
					'{{WRAPPER}} .farmart-blog-shortcode .slick-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .farmart-blog-shortcode .slick-arrow' => 'width: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .farmart-blog-shortcode .slick-arrow' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .farmart-blog-shortcode .slick-prev-arrow' => 'left: {{VALUE}}px;',
					'{{WRAPPER}} .farmart-blog-shortcode .slick-next-arrow' => 'right: {{VALUE}}px;',
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
					'{{WRAPPER}} .farmart-blog-shortcode .slick-arrow' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .farmart-blog-shortcode .slick-arrow' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sliders_arrow_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-blog-shortcode .slick-arrow' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .farmart-blog-shortcode .slick-arrow:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .farmart-blog-shortcode .slick-arrow:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sliders_arrow_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-blog-shortcode .slick-arrow:hover' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .farmart-blog-shortcode .list-post > .slick-dots li button:before' => 'border-radius: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .farmart-blog-shortcode .list-post > .slick-dots li' => 'margin: 0 {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .farmart-blog-shortcode .list-post > .slick-dots' => 'bottom: {{VALUE}}px;',
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
					'{{WRAPPER}} .farmart-blog-shortcode .list-post > .slick-dots li button:before' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .farmart-blog-shortcode .list-post > .slick-dots li button,{{WRAPPER}} .farmart-blog-shortcode .list-post > .slick-dots li button:before' => 'width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .farmart-blog-shortcode .list-post > .slick-dots li button,{{WRAPPER}} .farmart-blog-shortcode .list-post > .slick-dots li button:before' => 'height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .farmart-blog-shortcode .list-post > .slick-dots li button:hover:before' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .farmart-blog-shortcode .list-post > .slick-dots li.slick-active button:before' => 'background-color: {{VALUE}};'
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
					'{{WRAPPER}} .farmart-blog-shortcode .list-post > .slick-dots li.slick-active button,{{WRAPPER}} .farmart-blog-shortcode .list-post > .slick-dots li.slick-active button:before' => 'width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .farmart-blog-shortcode .list-post > .slick-dots li.slick-active button,{{WRAPPER}} .farmart-blog-shortcode .list-post > .slick-dots li.slick-active button:before' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

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
			'responsive_slidesToShow',
			[
				'label'           => esc_html__( 'Slides to show', 'farmart-addons' ),
				'type'            => Controls_Manager::NUMBER,
				'min'             => 1,
				'max'             => 7,
				'default' => 1,
			]
		);
		$repeater->add_control(
			'responsive_slidesToScroll',
			[
				'label'           => esc_html__( 'Slides to scroll', 'farmart-addons' ),
				'type'            => Controls_Manager::NUMBER,
				'min'             => 1,
				'max'             => 7,
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

	/**
	 * Render icon box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute(
			'wrapper', 'class', [
				'farmart-blog-shortcode',
			]
		);

		$this->add_render_attribute(
			'wrapper', 'data-show', [
				intval($settings['slidesToShow'])
			]
		);

		$link_icon = \Farmart\Icon::get_svg( 'chevron-right' );

		if ( $settings['link_icon'] && ! empty( $settings['link_icon']['value'] ) && \Elementor\Icons_Manager::is_migration_allowed() ) {
			ob_start();
			\Elementor\Icons_Manager::render_icon( $settings['link_icon'], [ 'aria-hidden' => 'true' ] );
			$icon_svg = ob_get_clean();
			if( $icon_svg ) {
				$link_icon = '<span class="farmart-svg-icon">' . $icon_svg . '</span>';
			}
		}

		if( empty( $link_icon ) ) {
			$link_icon = '<span class="farmart-svg-icon"><svg viewBox="0 0 32 32"><path d="M8 32c-0.205 0-0.409-0.078-0.566-0.234-0.312-0.312-0.312-0.819 0-1.131l13.834-13.834-13.834-13.834c-0.312-0.312-0.312-0.819 0-1.131s0.819-0.312 1.131 0l14.4 14.4c0.312 0.312 0.312 0.819 0 1.131l-14.4 14.4c-0.156 0.156-0.361 0.234-0.566 0.234z"></path></svg></span>';
		}

		$settings['infinite'] = false;
		$this->add_render_attribute('slicks','data-slick',wp_json_encode(Elementor::get_data_slick($settings)) );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div class="heading">
				<div class="box-title">
					<span><?php echo esc_html( $settings['bf_title'] ); ?></span>
					<h3><?php echo esc_html( $settings['title'] ); ?></h3>
				</div>
				<?php if ( $settings['link_text'] ) :
					echo $this->get_link_control( 'links', $settings['link_url'], $settings['link_text'].$link_icon, [ 'class' => 'extra-link' ] );
				endif; ?>
			</div>
			<div class="list-post--wrapper">
				<div class="list-post" <?php echo $this->get_render_attribute_string( 'slicks' ); ?>>
					<?php
						if ($settings['source'] == 'default'){
							$query_args = array(
								'post_status' => 'publish',
								'orderby' => $settings['orderby'],
								'order' => $settings['order'],
								'ignore_sticky_posts' => true,
								'posts_per_page' => $settings['limit'],
							);

							if ( ! empty( $settings['blog_cats'] ) ) {
								$query_args['tax_query'] = array(
									'relation' => 'OR',
									array(
										'taxonomy' => 'category',
										'field'    => 'slug',
										'terms'    => $settings['blog_cats'],
										'operator' => 'IN',
									),
								);
							}
						} else {
							$query_args['post__in'] =  explode(",",$settings['ids']) ;
						}
						$query = new \WP_Query($query_args);
						while ($query->have_posts()) : $query->the_post();

						$classes = 'blog-wrapper col-flex-md-12 col-flex-xs-12 col-flex-sm-12';
						$thumbnail_id = absint( get_post_thumbnail_id() );
						$image['url'] = wp_get_attachment_image_src( $thumbnail_id );
						$image['id']  = $thumbnail_id;

						$settings['image'] = $image;

						$url = get_the_permalink();
						$post_format       = get_post_format();
						$add_class = $symbol = '';

						switch ( $post_format ) {
							case 'video':
								$add_class = 'popup-video';
								$url       = get_post_meta( get_the_ID(), 'video', true );
								$symbol = get_template_directory_uri() . '/images/play-icon.png';
								$symbol = '<span class="post-format-icon"><img src="' . esc_url( $symbol ) . '" alt =""/></span>';
								break;
							case 'audio':
								$symbol = '<span class="post-format-icon">'. \Farmart\Icon::get_svg( 'music-note' ) .'</span>';
								break;
							case 'link':
								$symbol = '<span class="post-format-icon">'. \Farmart\Icon::get_svg( 'link' ) .'</span>';
								break;

							default:
								break;
						}
					?>
						<article id="post-<?php the_ID(); ?>" <?php post_class($classes); ?>>
							<div class="blog-wrapper__inner">
								<div class="entry-format format-<?php echo $post_format; ?>">
									<a class="entry-image <?php echo $add_class ?>" href="<?php echo $url; ?>">
										<?php echo $symbol; ?>
										<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings ); ?>
									</a>
								</div>

								<div class="entry-summary">
									<header class="entry-header">
										<?php
											$metas = (array) $settings['meta_option'];

											$meta_html = '';
											foreach ( $metas as $meta ) {
												switch ( $meta ) {
													case 'cat' :
														$meta_html .= farmart_meta_cat();

														break;
													case 'comment' :
														$meta_html .= farmart_meta_comment();

														break;
													case 'date' :
														$meta_html .= farmart_meta_date();

														break;
													case 'author' :
														$meta_html .= farmart_meta_author();

														break;
													case 'social' :
													default :
												}
											}

											echo '<div class="entry-meta">' . $meta_html . '</div>';
										?>
										<?php
										the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
										?>
									</header><!-- .entry-header -->

									<div class="entry-content">
										<div class="entry-excerpt"><?php echo farmart_content_limit( $settings['excerpt_length'], '' ); ?></div>
									</div><!-- .entry-content -->

									<div class="fm-entry-date"><?php echo farmart_meta_date(true).farmart_meta_author() ?></div>

								</div>

							</div>
						</article><!-- #post-<?php the_ID(); ?> -->
					<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>
				</div>
			</div>
		</div>
		<?php

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