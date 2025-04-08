<?php

namespace FarmartAddons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use FarmartAddons\Elementor;
use FarmartAddons\Elementor_AjaxLoader;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon Box widget
 */
class Products_Carousel_With_Category extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'farmart-products-carousel-with-category';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Farmart - Product Carousel with Category', 'farmart-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-post-slider';
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

		// Content Tab
		$this->register_heading_controls();
		$this->register_content_controls();
		$this->register_sidebar_controls();
		$this->register_products_controls();

		// Style Tab
		$this->register_heading_style_controls();
		$this->register_products_style_controls();

		$this->_register_carousel_settings_controls();
		$this->_register_lazy_load_controls();
	}

	/**
	 * Register the widget heading controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_heading_controls() {

		$this->start_controls_section(
			'section_heading',
			[ 'label' => esc_html__( 'Heading', 'farmart-addons' ) ]
		);
		$this->add_responsive_control(
			'header_alignment',
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
				'mobile_default'  => 'column',
				'toggle'          => false,
				'selectors'       => [
					'{{WRAPPER}} .fm-products-carousel-with-category .header-cat' => 'flex-direction: {{VALUE}}',
				],
				'required'        => true,
			]
		);
		$this->add_responsive_control(
			'content_position',
			[
				'label'           => __( 'Vertical Align', 'farmart-addons' ),
				'type'            => Controls_Manager::SELECT,
				'options'         => [
					''              => __( 'Default', 'farmart-addons' ),
					'flex-start'    => __( 'Start', 'farmart-addons' ),
					'center'        => __( 'Center', 'farmart-addons' ),
					'flex-end'      => __( 'End', 'farmart-addons' ),
					'stretch' 		=> __( 'Stretch', 'farmart-addons' ),
					'baseline'  	=> __( 'Baseline', 'farmart-addons' ),
				],
				'desktop_default' => '',
				'tablet_default'  => 'center',
				'mobile_default'  => 'center',
				'selectors'       => [
					'{{WRAPPER}} .fm-products-carousel-with-category .header-cat' => 'align-items: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'           => __( 'Horizontal Align', 'farmart-addons' ),
				'type'            => Controls_Manager::SELECT,
				'options'         => [
					''              => __( 'Default', 'farmart-addons' ),
					'flex-start'    => __( 'Start', 'farmart-addons' ),
					'center'        => __( 'Center', 'farmart-addons' ),
					'flex-end'      => __( 'End', 'farmart-addons' ),
					'space-between' => __( 'Space Between', 'farmart-addons' ),
					'space-around'  => __( 'Space Around', 'farmart-addons' ),
					'space-evenly'  => __( 'Space Evenly', 'farmart-addons' ),
				],
				'desktop_default' => '',
				'tablet_default'  => 'space-between',
				'mobile_default'  => 'space-between',
				'selectors'       => [
					'{{WRAPPER}} .fm-products-carousel-with-category .header-cat' => 'justify-content: {{VALUE}}',
				],
			]
		);
		$this->start_controls_tabs( 'heading_content_settings' );

		$this->start_controls_tab( 'title_tab', [ 'label' => esc_html__( 'Title', 'farmart-addons' ) ] );

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Category Name', 'farmart-addons' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'title_icon',
			[
				'label'   => esc_html__( 'Icon', 'farmart-addons' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => '',
					'library' => 'fa-solid',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'quick_links_tab', [ 'label' => esc_html__( 'Quick Links', 'farmart-addons' ) ] );


		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'link_text', [
				'label'       => esc_html__( 'Title', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
			]
		);

		$repeater->add_control(
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
			'links_group',
			[
				'label'         => esc_html__( 'Quick Links', 'farmart-addons' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [
					[
						'link_text' => esc_html__( 'Category #1', 'farmart-addons' ),
						'link_url'  => '#',
					],
					[
						'link_text' => esc_html__( 'Category #2', 'farmart-addons' ),
						'link_url'  => '#',
					],
					[
						'link_text' => esc_html__( 'Category #3', 'farmart-addons' ),
						'link_url'  => '#',
					],

				],
				'title_field'   => '{{{ link_text }}}',
				'prevent_empty' => false
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'view_all_tab', [ 'label' => esc_html__( 'View All', 'farmart-addons' ) ] );

		$this->add_control(
			'view_all_text',
			[
				'label'   => esc_html__( 'Text', 'farmart-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'View all', 'farmart-addons' ),
			]
		);

		$this->add_control(
			'view_all_link', [
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
			'view_all_icon',
			[
				'label'   => esc_html__( 'Icon', 'farmart-addons' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'icon-chevron-right',
					'library' => 'linearicons',
				],
			]
		);

		$this->add_control(
			'view_all_position',
			[
				'label'   => esc_html__( 'Position', 'farmart-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'before'  => esc_html__( 'Before Quick Link', 'farmart-addons' ),
					'after' => esc_html__( 'After Quick Link', 'farmart-addons' ),
				],
				'default' => 'after',
				'toggle'  => false,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}
	/**
	 * Register the widget content style controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */

	protected function register_content_controls() {
		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__( 'Content', 'farmart-addons' ),
			]
		);
		$this->add_responsive_control(
			'content_align',
			[
				'label'                => esc_html__( 'Content Align', 'farmart-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'horizontal' => [
						'title' => esc_html__( 'Horizontal', 'farmart-addons' ),
						'icon'  => 'fa fa-ellipsis-h',
					],
					'vertical'   => [
						'title' => esc_html__( 'Vertical', 'farmart-addons' ),
						'icon'  => 'fa fa-ellipsis-v',
					],
				],
				'default'              => 'horizontal',
				'selectors'            => [
					'{{WRAPPER}} .fm-products-carousel-with-category .content-wrapper' => '{{VALUE}}',
				],
				'selectors_dictionary' => [
					'horizontal' => '',
					'vertical'   => 'flex-direction: column',
				],
			]
		);

		$this->add_responsive_control(
			'content_align_css',
			[
				'label'                => __( 'Content CSS', 'farmart-addons' ),
				'type'                 => Controls_Manager::HIDDEN,
				'desktop_default'      => 'vertical',
				'tablet_default'       => 'vertical',
				'mobile_default'       => 'vertical',
				'selectors_dictionary' => [
					'vertical' => 'flex: 0 0 100%; max-width: 100%; width: 100%;',
				],
			]
		);

		$this->end_controls_section();
	}
	/**
	 * Register the widget sidebar controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_sidebar_controls() {

		$this->start_controls_section(
			'section_sidebar_content',
			[
				'label' => esc_html__( 'Banner', 'farmart-addons' ),
			]
		);
		$this->add_control(
			'image',
			[
				'label'   => esc_html__( 'Choose Image', 'farmart-addons' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/250x400/e7eff1?text=250x400+Banner',
				],
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
			'image_link', [
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

		$this->add_responsive_control(
			'banner_width',
			[
				'label'      => esc_html__( 'Width', 'farmart-addons' ) . ' %',
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-products-carousel-with-category .images-box' => 'flex: 0 0 {{SIZE}}{{UNIT}}; max-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .fm-products-carousel-with-category .products-box' => 'width: calc( 100% - {{SIZE}}{{UNIT}} )',
				],
				'default' => [
					'unit' => '%',
				],
				'separator' => 'before',
				'condition' => [
					'image[url]!' => '',
					'content_align' => 'horizontal'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'banner_border',
				'label'    => esc_html__( 'Border', 'farmart-addons' ),
				'selector' => '{{WRAPPER}} .fm-products-carousel-with-category .images-box',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register the widget products controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_products_controls() {

		$this->start_controls_section(
			'section_product_content',
			[
				'label' => esc_html__( 'Products', 'farmart-addons' ),
			]
		);

		$this->add_control(
			'products',
			[
				'label'     => esc_html__( 'Products', 'farmart-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'recent'       => esc_html__( 'Recent', 'farmart-addons' ),
					'featured'     => esc_html__( 'Featured', 'farmart-addons' ),
					'best_selling' => esc_html__( 'Best Selling', 'farmart-addons' ),
					'top_rated'    => esc_html__( 'Top Rated', 'farmart-addons' ),
					'sale'         => esc_html__( 'On Sale', 'farmart-addons' ),
				],
				'default'   => 'recent',
				'toggle'    => false,
			]
		);

		$this->add_control(
			'product_cats',
			[
				'label'       => esc_html__( 'Product Categories', 'farmart-addons' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => Elementor::get_taxonomy(),
				'default'     => '',
				'multiple'    => true,
				'label_block' => true,
			]
		);

		$this->add_control(
			'product_tags',
			[
				'label'       => esc_html__( 'Product Tags', 'farmart-addons' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => Elementor::get_taxonomy( 'product_tag' ),
				'default'     => '',
				'multiple'    => true,
				'label_block' => true,
			]
		);

		$this->add_control(
			'per_page',
			[
				'label'     => esc_html__( 'Products per view', 'farmart-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 10,
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
					'title'      => esc_html__( 'Title', 'farmart-addons' ),
					'menu_order' => esc_html__( 'Menu Order', 'farmart-addons' ),
					'rand'       => esc_html__( 'Random', 'farmart-addons' ),
				],
				'default'    => '',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'products',
							'value' => [ 'recent', 'sale', 'featured' ],
						]
					]
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'     => esc_html__( 'Order', 'farmart-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''     => esc_html__( 'Default', 'farmart-addons' ),
					'asc'  => esc_html__( 'Ascending', 'farmart-addons' ),
					'desc' => esc_html__( 'Descending', 'farmart-addons' ),
				],
				'default'   => '',
			]
		);

		$this->add_control(
			'product_type',
			[
				'label'      => esc_html__( 'Product Type', 'farmart-addons' ),
				'type'       => Controls_Manager::SELECT,
				'options'    => [
					'grid'     => esc_html__( 'Grid', 'farmart-addons' ),
					'carousel'  => esc_html__( 'Carousel', 'farmart-addons' ),
				],
				'default'    => 'carousel',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register the widget heading style controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_heading_style_controls() {

		$this->start_controls_section(
			'section_style_heading',
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
				'placeholder' => [
					'top'    => '20',
					'right'  => '20',
					'bottom' => '20',
					'left'   => '20',
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-products-carousel-with-category .header-cat' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-products-carousel-with-category .header-cat' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'heading_border',
				'label'    => esc_html__( 'Border', 'farmart-addons' ),
				'selector' => '{{WRAPPER}} .fm-products-carousel-with-category .header-cat',
			]
		);

		$this->add_control(
			'heading_style_divider',
			[
				'label' => '',
				'type'  => Controls_Manager::DIVIDER,
			]
		);

		$this->start_controls_tabs( 'heading_title_style_settings' );

		$this->start_controls_tab( 'heading_title_style_tab', [ 'label' => esc_html__( 'Title', 'farmart-addons' ) ] );

		$this->add_responsive_control(
			'heading_title_margin',
			[
				'label'              => __( 'Margin', 'farmart-addons' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px' ],
				'allowed_dimensions' => [ 'right', 'bottom' ],
				'placeholder'        => [
					'top'    => _x( 'Auto', 'Product with Category', 'farmart-addons' ),
					'right'  => '',
					'bottom' => '',
					'left'   => _x( 'Auto', 'Product with Category', 'farmart-addons' ),
				],
				'selectors'          => [
					'{{WRAPPER}} .fm-products-carousel-with-category .header-cat h2' => 'margin-right: {{RIGHT}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-products-carousel-with-category .header-cat .cat-title'   => 'color: {{VALUE}}',
					'{{WRAPPER}} .fm-products-carousel-with-category .header-cat .cat-title a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'heading_title_hover_color',
			[
				'label'     => esc_html__( 'Hover Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-products-carousel-with-category .header-cat .cat-title:hover'   => 'color: {{VALUE}}',
					'{{WRAPPER}} .fm-products-carousel-with-category .header-cat .cat-title:hover a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_title_typography',
				'selector' => '{{WRAPPER}} .fm-products-carousel-with-category .header-cat h2',
			]
		);

		$this->add_control(
			'title_icon_style',
			[
				'label'        => __( 'Icons', 'farmart-addons' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'farmart-addons' ),
				'label_on'     => __( 'Custom', 'farmart-addons' ),
				'return_value' => 'yes',
			]
		);
		$this->start_popover();

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .fm-products-carousel-with-category .header-cat h2 .farmart-svg-icon' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'icon_font_size',
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
					'{{WRAPPER}} .fm-products-carousel-with-category .header-cat h2 .farmart-svg-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'icon_right_spacing',
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
					'{{WRAPPER}} .fm-products-carousel-with-category .header-cat h2 .farmart-svg-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_popover();

		$this->end_controls_tab();

		$this->start_controls_tab( 'heading_links_style_tab', [ 'label' => esc_html__( 'Links', 'farmart-addons' ) ] );

		$this->add_responsive_control(
			'heading_quick_links_display',
			[
				'label'     => esc_html__( 'Quick Links', 'farmart-addons' ),
				'type'                 => Controls_Manager::SWITCHER,
				'label_on'             => __( 'Show', 'farmart-addons' ),
				'label_off'            => __( 'Hide', 'farmart-addons' ),
				'return_value'         => 'yes',
				'default'              => 'yes',
				'selectors_dictionary' => [
					'' => 'display: none',
				],
				'selectors' => [
					'{{WRAPPER}} .fm-products-carousel-with-category .header-cat .extra-links li.extra-link-item' => '{{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'heading_link_items_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'placeholder' => [
					'top'    => '',
					'right'  => '16',
					'bottom' => '',
					'left'   => '16',
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-products-carousel-with-category .header-cat .extra-links li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .fm-products-carousel-with-category .header-cat .extra-links li:first-child' => 'padding-left: 0',
					'{{WRAPPER}} .fm-products-carousel-with-category .header-cat .extra-links li:last-child' => 'padding-right: 0',
				],
			]
		);

		$this->add_control(
			'heading_links_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-products-carousel-with-category .header-cat .extra-links li a.extra-link'      => 'color: {{VALUE}}',
					'{{WRAPPER}} .fm-products-carousel-with-category .header-cat .extra-links li .header-link span' => 'color: {{VALUE}}',
					'{{WRAPPER}} .fm-products-carousel-with-category .header-cat .extra-links li:after'             => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'heading_links_hover_color',
			[
				'label'     => esc_html__( 'Hover Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-products-carousel-with-category .header-cat .extra-links li a.extra-link:hover'            => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'heading_links_hover_border_color',
			[
				'label'     => esc_html__( 'Hover Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-products-carousel-with-category .header-cat .extra-links li a.extra-link:hover'            => 'box-shadow: inset 0 0 0 transparent, inset 0 -1px 0 {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_links_typography',
				'selector' => '{{WRAPPER}} .fm-products-carousel-with-category .header-cat .extra-links li a',
			]
		);

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
					'{{WRAPPER}}  .fm-products-carousel-with-category .header-cat .extra-links .header-link .farmart-svg-icon' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .fm-products-carousel-with-category .header-cat .extra-links .header-link .farmart-svg-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'link_icon_left_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-products-carousel-with-category .header-cat .extra-links .header-link .farmart-svg-icon' => 'padding-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_popover();

		$this->add_responsive_control(
			'heading_quick_links_line',
			[
				'label'     => esc_html__( 'Line', 'farmart-addons' ),
				'type'                 => Controls_Manager::SWITCHER,
				'label_on'             => __( 'Show', 'farmart-addons' ),
				'label_off'            => __( 'Hide', 'farmart-addons' ),
				'return_value'         => 'yes',
				'default'              => 'yes',
				'selectors_dictionary' => [
					'' => 'display: none',
				],
				'selectors' => [
					'{{WRAPPER}} .fm-products-carousel-with-category .header-cat .extra-links li:after' => '{{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->start_controls_tab( 'heading_view_link_style_tab', [ 'label' => esc_html__( 'View Links', 'farmart-addons' ) ] );

		$this->add_responsive_control(
			'heading_view_link_items_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'placeholder' => [
					'top'    => '',
					'right'  => '16',
					'bottom' => '',
					'left'   => '16',
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-products-carousel-with-category .header-cat .extra-links .header-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_view_links_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-products-carousel-with-category .header-cat .extra-links .header-link'      => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'heading_view_links_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-products-carousel-with-category .header-cat .extra-links .header-link'      => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'heading_view_link_hover_color',
			[
				'label'     => esc_html__( 'Hover Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-products-carousel-with-category .header-cat .extra-links .header-link:hover .link-text'            => 'color: {{VALUE}};',
					'{{WRAPPER}} .fm-products-carousel-with-category .header-cat .extra-links .header-link:hover .farmart-svg-icon'     => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_view_link_typography',
				'selector' => '{{WRAPPER}} .fm-products-carousel-with-category .header-cat .extra-links .header-link',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	/**
	 * Register the widget sidebar style controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */

	protected function _register_carousel_settings_controls() {
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
				'max'     => 10,
				'default' => 5,
			]
		);
		$this->add_responsive_control(
			'slidesToScroll',
			[
				'label'   => esc_html__( 'Slides to scroll', 'farmart-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 10,
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

		// Carousel Style
		// Carousel Settings
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

		$this->add_control(
			'arrows_position',
			[
				'label'   => esc_html__( 'Position', 'farmart-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'inside'  => esc_html__( 'Inside Container', 'farmart-addons' ),
					'outside' => esc_html__( 'Outside Container', 'farmart-addons' ),
				],
				'default' => 'inside',
				'toggle'  => false,
			]
		);

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
					'{{WRAPPER}} .fm-products-carousel-with-category .slick-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .fm-products-carousel-with-category .slick-arrow' => 'width: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .fm-products-carousel-with-category .slick-arrow' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .fm-products-carousel-with-category .slick-prev-arrow' => 'left: {{VALUE}}px;',
					'{{WRAPPER}} .fm-products-carousel-with-category .slick-next-arrow' => 'right: {{VALUE}}px;',
					'{{WRAPPER}} .fm-products-carousel-with-category.farmart-nav-outside .slick-prev-arrow' => 'left: auto; right: calc({{VALUE}}px + 32px);',
					'{{WRAPPER}} .fm-products-carousel-with-category.farmart-nav-outside .slick-next-arrow' => 'left: auto; right: {{VALUE}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'sliders_arrows_offset_2',
			[
				'label'      => esc_html__( 'Vertical Offset', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => -500,
						'max' => 1000,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-products-carousel-with-category .slick-prev-arrow' => 'top: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .fm-products-carousel-with-category .slick-next-arrow' => 'top: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .fm-products-carousel-with-category .slick-prev-arrow, .fm-products-carousel-with-category .slick-next-arrow' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-products-carousel-with-category .slick-prev-arrow, .fm-products-carousel-with-category .slick-next-arrow' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-products-carousel-with-category .slick-prev-arrow, .fm-products-carousel-with-category .slick-next-arrow' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-products-carousel-with-category .slick-prev-arrow:hover, .fm-products-carousel-with-category .slick-next-arrow:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-products-carousel-with-category .slick-prev-arrow:hover, .fm-products-carousel-with-category .slick-next-arrow:hover' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-products-carousel-with-category .slick-prev-arrow:hover, .fm-products-carousel-with-category .slick-next-arrow:hover' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-products-carousel-with-category .slick-dots li' => 'margin: 0 {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'sliders_dots_width',
			[
				'label'      => esc_html__( 'Size', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-products-carousel-with-category .slick-dots li button'        => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .fm-products-carousel-with-category .slick-dots li button:before' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}}',
				],
				'separator'  => 'before',
			]
		);
		$this->add_responsive_control(
			'sliders_dots_offset',
			[
				'label'              => esc_html__( 'Margin', 'farmart-addons' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'allowed_dimensions' => 'vertical',
				'placeholder'        => [
					'top'    => '',
					'right'  => esc_html__( 'Auto', 'farmart-addons' ),
					'bottom' => '',
					'left'   => esc_html__( 'Auto', 'farmart-addons' ),
				],
				'selectors' => [
					'{{WRAPPER}} .fm-products-carousel-with-category .slick-dots' => 'margin-top: {{TOP}}{{UNIT}};margin-bottom:{{BOTTOM}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'sliders_dots_background',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-products-carousel-with-category .slick-dots li button:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sliders_dots_active_background',
			[
				'label'     => esc_html__( 'Active Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-products-carousel-with-category .slick-dots li.slick-active button:before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .fm-products-carousel-with-category .slick-dots li button:hover:before' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->end_popover();
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
	 * Register the widget products style controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_products_style_controls() {

		$this->start_controls_section(
			'section_style_products',
			[
				'label' => esc_html__( 'Products', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'hide_icon_button',
			[
				'label'     => __( 'Hide Icon Button', 'farmart-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Disable', 'farmart-addons' ),
				'label_on'  => __( 'Enable', 'farmart-addons' ),
				'default'   => '',
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'products_border',
				'label'    => esc_html__( 'Border', 'farmart-addons' ),
				'selector' => '{{WRAPPER}} .fm-products-carousel-with-category .products-box',
			]
		);

		$this->add_responsive_control(
			'products_padding',
			[
				'label'     => esc_html__( 'Padding Content', 'farmart-addons' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'placeholder' => [
					'top'    => '15',
					'right'  => '15',
					'bottom' => '15',
					'left'   => '15',
				],
				'selectors' => [
					'{{WRAPPER}} .fm-products-carousel-with-category .products-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'products_list_padding',
			[
				'label'     => esc_html__( 'Padding Content List', 'farmart-addons' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .fm-products-carousel-with-category .slick-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);
		$this->add_responsive_control(
			'products_list_margin',
			[
				'label'     => esc_html__( 'Margin Content List', 'farmart-addons' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .fm-products-carousel-with-category .slick-list' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'action_button',
			[
				'label'                => esc_html__( 'Wishlist/Compare Text', 'farmart-addons' ),
				'type'                 => Controls_Manager::SWITCHER,
				'label_on'             => esc_html__( 'Show', 'farmart-addons' ),
				'label_off'            => esc_html__( 'Hide', 'farmart-addons' ),
				'return_value'         => 'yes',
				'default'              => 'yes',
				'selectors_dictionary' => [
					''    => 'display: none',
				],
				'selectors'            => [
					'{{WRAPPER}} .fm-products-carousel-with-category ul.products li.product .product-button .group-yith a span' => '{{VALUE}}',
				],
			]
		);
		$this->add_control(
			'swatches',
			[
				'label'                => esc_html__( 'Swatches', 'farmart-addons' ),
				'type'                 => Controls_Manager::SWITCHER,
				'label_on'             => __( 'Show', 'farmart-addons' ),
				'label_off'            => __( 'Hide', 'farmart-addons' ),
				'return_value'         => 'yes',
				'default'              => 'yes',
				'selectors_dictionary' => [
					'' => 'display: none',
				],
				'selectors'   => [
					'{{WRAPPER}} .fm-products-carousel-with-category ul.products li.product .product-thumbnail .fm-attr-swatches' => '{{VALUE}}',
				],
			]
		);
		$this->add_control(
			'product_border_type',
			[
				'label'           => __( 'Border Style', 'farmart-addons' ),
				'type'            => Controls_Manager::SELECT,
				'default' 		  => '',
				'options'         => [
					''              => __( 'Style 1', 'farmart-addons' ),
					'2'    			=> __( 'Style 2', 'farmart-addons' ),
				],
			]
		);
		$this->end_controls_section();
	}

	protected function _register_lazy_load_controls() {
		// Content
		$this->start_controls_section(
			'section_lazy_load',
			[ 'label' => esc_html__( 'Lazy Load', 'farmart-addons' ) ]
		);
		$this->add_control(
			'lazy_load',
			[
				'label'        => esc_html__( 'Enable', 'farmart-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'farmart-addons' ),
				'label_off'    => esc_html__( 'No', 'farmart-addons' ),
				'default'      => '',
			]
		);
		$this->add_responsive_control(
			'lazy_load_height',
			[
				'label'     => esc_html__( 'Height', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [],
				'range'     => [
					'px' => [
						'min' => 10,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .fm-elementor-ajax-wrapper .farmart-loading-wrapper' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section(); // End

		// Style
		$this->start_controls_section(
			'section_lazy_load_style',
			[
				'label' => esc_html__( 'Lazy Load', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'loading_width',
			[
				'label'      => esc_html__( 'Loading Width', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-elementor-ajax-wrapper .farmart-loading:after' => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'loading_height',
			[
				'label'      => esc_html__( 'Loading Height', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-elementor-ajax-wrapper .farmart-loading:after' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_control(
			'loading_border_color',
			[
				'label'     => esc_html__( 'Loading Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-elementor-ajax-wrapper .farmart-loading:after' => 'border-color: {{VALUE}} transparent {{VALUE}} transparent;',
				],
				'separator' => 'before',
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
				'fm-products-carousel-with-category woocommerce',
				$settings['lazy_load'] == 'yes' ? '' : 'no-infinite',
				$settings['hide_icon_button'] == 'yes' ? 'hide-icon-button' : '',
				$settings['arrows_position'] == 'outside' ? 'farmart-nav-outside' : '',
				$settings['product_border_type'] == '2' ? 'farmart-border-type-2' : '',
			]
		);

		$is_rtl    = is_rtl();
		$direction = $is_rtl ? 'rtl' : 'ltr';
		$this->add_render_attribute( 'wrapper', 'dir', $direction );

		$this->add_render_attribute( 'wrapper', 'data-settings', wp_json_encode( Elementor::get_data_slick( $settings ) ) );
		$this->add_render_attribute( 'wrapper', 'data-type', $settings['product_type'] );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( $settings['lazy_load'] == 'yes' ) : ?>
				<?php
				// AJAX settings
				$this->add_render_attribute(
					'ajax_wrapper', 'class', [
						'fm-products-carousel-with-category-loading fm-elementor-ajax-wrapper'
					]
				);
				$ajax_settings = [
					'title'                  => $settings['title'],
					'title_icon'             => $settings['title_icon'],
					'links_group'            => $settings['links_group'],
					'view_all_text'          => $settings['view_all_text'],
					'view_all_link'          => $settings['view_all_link'],
					'view_all_icon'          => $settings['view_all_icon'],
					'view_all_position' 	=> $settings['view_all_position'],
					'image'                  => $settings['image'],
					'image_size'             => $settings['image_size'],
					'image_custom_dimension' => [
						'width'  => $settings['image_custom_dimension']['width'],
						'height' => $settings['image_custom_dimension']['height'],
					],
					'image_link'   => $settings['image_link'],
					'products'     => $settings['products'],
					'product_cats' => $settings['product_cats'],
					'product_tags' => $settings['product_tags'],
					'per_page'     => $settings['per_page'],
					'orderby'      => $settings['orderby'],
					'order'        => $settings['order'],
					'slidesToShow' => $settings['slidesToShow'],
				];
				$this->add_render_attribute( 'ajax_wrapper', 'data-settings', wp_json_encode( $ajax_settings ) );
				?>
                <div <?php echo $this->get_render_attribute_string( 'ajax_wrapper' ); ?>>
					<div class="farmart-loading-wrapper"><div class="farmart-loading"></div></div>
                </div>
			<?php else : ?>
				<?php Elementor_AjaxLoader::get_products_carousel_with_category( $settings ); ?>
			<?php endif; ?>
		</div>
		<?php
	}
}