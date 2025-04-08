<?php

namespace FarmartAddons\Elementor\Widgets;

use Elementor\Controls_Stack;
use Elementor\Controls_Manager;
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
class Products_With_Category extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'farmart-product-with-category';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Farmart - Product with Category', 'farmart-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-products';
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
		$this->register_content_style_controls();
		$this->register_sidebar_style_controls();
		$this->register_products_style_controls();

		$this->_register_lazy_load_controls();

		$this->register_vertical_tab_controls();
	}

	protected function register_vertical_tab_controls() {
		$this->start_controls_section(
			'vertical_tab_controls',
			[ 'label' => esc_html__( 'Vertical Tabs', 'farmart-addons' ) ]
		);
		$this->add_control(
			'vertical_tab_description',
			[
				'raw'             => __( 'Vertical Tabs snippet out of the box.', 'farmart-addons' ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-descriptor',
			]
		);
		$this->add_control(
			'vertical_tab',
			[
				'label'        => esc_html__( 'Enable', 'farmart-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'farmart-addons' ),
				'label_off'    => esc_html__( 'No', 'farmart-addons' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		$this->add_control(
			'vertical_tab_title',
			[
				'label'       => esc_html__( 'Title', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
			]
		);
		$this->add_control(
			'vertical_tab_title_icon',
			[
				'label'   => esc_html__( 'Icon', 'farmart-addons' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value' => 'icon-apple',
				],
			]
		);
		$this->end_controls_section();
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

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Heading Title', 'farmart-addons' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'c_link', [
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

		$this->end_controls_section();
	}

	protected function register_content_controls() {
		$this->start_controls_section(
			'section_content',
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
					'{{WRAPPER}} .fm-product-with-category .content-wrapper' => '{{VALUE}}',
				],
				'selectors_dictionary' => [
					'horizontal' => '',
					'vertical'   => 'flex-direction: column',
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
				'label' => esc_html__( 'Sidebar', 'farmart-addons' ),
			]
		);
		$this->add_responsive_control(
			'sidebar',
			[
				'label'                => esc_html__( 'Enable', 'farmart-addons' ),
				'type'                 => Controls_Manager::SWITCHER,
				'label_on'             => esc_html__( 'Yes', 'farmart-addons' ),
				'label_off'            => esc_html__( 'No', 'farmart-addons' ),
				'return_value'         => 'yes',
				'desktop_default'      => 'yes',
				'tablet_default'       => 'yes',
				'mobile_default'       => '',
				'selectors_dictionary' => [
					'' => 'display: none',
				],
			]
		);
		$this->add_control(
			'banners_settings',
			[
				'label'     => esc_html__( 'Banners', 'farmart-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);
		$this->add_responsive_control(
			'banner',
			[
				'label'                => esc_html__( 'Enable', 'farmart-addons' ),
				'type'                 => Controls_Manager::SWITCHER,
				'label_on'             => esc_html__( 'Yes', 'farmart-addons' ),
				'label_off'            => esc_html__( 'No', 'farmart-addons' ),
				'return_value'         => 'yes',
				'desktop_default'      => 'yes',
				'tablet_default'       => 'yes',
				'mobile_default'       => '',
				'selectors_dictionary' => [
					''    => 'display: none',
					'yes' => 'display: block',
				],
			]
		);
		$this->start_controls_tabs( 'sidebar_content_settings' );

		$this->start_controls_tab( 'banner_images_tab', [ 'label' => esc_html__( 'Images', 'farmart-addons' ) ] );

		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'image',
			[
				'label'   => esc_html__( 'Choose Image', 'farmart-addons' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/455x328/e7eff1?text=455x328+Banner',
				],
			]
		);

		$repeater->add_control(
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

		$this->add_control(
			'banners',
			[
				'label'         => esc_html__( 'Images', 'farmart-addons' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [
					[
						'image'      => [
							'url' => 'https://via.placeholder.com/393x340/e7eff1?text=393x340+Banner'
						],
						'image_link' => [
							'url' => '#'
						]
					],
					[
						'image'      => [
							'url' => 'https://via.placeholder.com/393x340/e7eff1?text=393x340+Banner+2'
						],
						'image_link' => [
							'url' => '#'
						]
					]
				],
				'prevent_empty' => false
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'carousel_settings_tab', [ 'label' => esc_html__( 'Carousel Settings', 'farmart-addons' ) ] );

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
				'default' => 'both',
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
				'default'   => ''
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
				'step'        => 100,
				'description' => esc_html__( 'Slide animation speed (in ms)', 'farmart-addons' ),
			]
		);

		//Responsive Settings
		$this->_register_responsive_settings_controls();

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// Categories Box
		$this->add_control(
			'quicklink_settings',
			[
				'label'     => esc_html__( 'Categories Box', 'farmart-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);
		$this->add_responsive_control(
			'quick_links',
			[
				'label'                => esc_html__( 'Enable', 'farmart-addons' ),
				'type'                 => Controls_Manager::SWITCHER,
				'label_on'             => esc_html__( 'Yes', 'farmart-addons' ),
				'label_off'            => esc_html__( 'No', 'farmart-addons' ),
				'return_value'         => 'yes',
				'desktop_default'      => 'yes',
				'tablet_default'       => 'yes',
				'mobile_default'       => '',
				'selectors_dictionary' => [
					''    => 'display: none',
					'yes' => 'display: flex',
				],
			]
		);
		$this->add_control(
			'quicklink_columns',
			[
				'label'   => esc_html__( 'Quick Links Columns', 'farmart-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'2' => esc_html__( '2 Columns', 'farmart-addons' ),
					'1' => esc_html__( '1 Column', 'farmart-addons' ),
				],
				'default' => '2',
				'toggle'  => false,
			]
		);
		$this->start_controls_tabs( 'quicklink_settings_tabs' );

		$this->start_controls_tab( 'quicklink_1_tab', [ 'label' => esc_html__( 'Quick Links 1', 'farmart-addons' ) ] );
		$this->add_control(
			'quicklink_title_1',
			[
				'label'       => esc_html__( 'Title', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Quick link title #1', 'farmart-addons' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'quicklink_url_1', [
				'label'         => esc_html__( 'URL', 'farmart-addons' ),
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
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'link_text_1', [
				'label'       => esc_html__( 'Title', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'link_url_1', [
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
			'links_group_1',
			[
				'label'         => esc_html__( 'Items', 'farmart-addons' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [
					[
						'link_text_1' => esc_html__( 'Category #1', 'farmart-addons' ),
						'link_url_1'  => '#',
					],
					[
						'link_text_1' => esc_html__( 'Category #2', 'farmart-addons' ),
						'link_url_1'  => '#',
					],
					[
						'link_text_1' => esc_html__( 'Category #3', 'farmart-addons' ),
						'link_url_1'  => '#',
					],

				],
				'title_field'   => '{{{ link_text_1 }}}',
				'prevent_empty' => false
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab( 'quicklink_2_tab', [ 'label' => esc_html__( 'Quick Links 2', 'farmart-addons' ) ] );
		$this->add_control(
			'quicklink_title_2',
			[
				'label'       => esc_html__( 'Title', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Quick link title #2', 'farmart-addons' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'quicklink_url_2', [
				'label'         => esc_html__( 'URL', 'farmart-addons' ),
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
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'link_text_2', [
				'label'       => esc_html__( 'Title', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'link_url_2', [
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
			'links_group_2',
			[
				'label'         => esc_html__( 'Items', 'farmart-addons' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [
					[
						'link_text_2' => esc_html__( 'Category #1', 'farmart-addons' ),
						'link_url_2'  => '#',
					],
					[
						'link_text_2' => esc_html__( 'Category #2', 'farmart-addons' ),
						'link_url_2'  => '#',
					],
					[
						'link_text_2' => esc_html__( 'Category #3', 'farmart-addons' ),
						'link_url_2'  => '#',
					],

				],
				'title_field'   => '{{{ link_text_2 }}}',
				'prevent_empty' => false
			]
		);
		$this->end_controls_tab();

		// View All
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
					'library' => 'fa-solid',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

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
				'label'   => esc_html__( 'Products', 'farmart-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'recent'       => esc_html__( 'Recent', 'farmart-addons' ),
					'featured'     => esc_html__( 'Featured', 'farmart-addons' ),
					'best_selling' => esc_html__( 'Best Selling', 'farmart-addons' ),
					'top_rated'    => esc_html__( 'Top Rated', 'farmart-addons' ),
					'sale'         => esc_html__( 'On Sale', 'farmart-addons' ),
				],
				'default' => 'recent',
				'toggle'  => false,
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
				'label'   => esc_html__( 'Products per view', 'farmart-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 8,
				'min'     => 2,
				'max'     => 500,
				'step'    => 1,
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'           => esc_html__( 'Product Columns', 'farmart-addons' ),
				'type'            => Controls_Manager::SELECT,
				'options'         => [
					'1' => esc_html__( '1 Column', 'farmart-addons' ),
					'2' => esc_html__( '2 Columns', 'farmart-addons' ),
					'3' => esc_html__( '3 Columns', 'farmart-addons' ),
					'4' => esc_html__( '4 Columns', 'farmart-addons' ),
					'5' => esc_html__( '5 Columns', 'farmart-addons' ),
					'6' => esc_html__( '6 Columns', 'farmart-addons' ),
				],
				'toggle'          => false,
				'desktop_default' => '4',
				'tablet_default'  => '4',
				'mobile_default'  => '2',
				'required'        => true,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'     => esc_html__( 'Order By', 'farmart-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''           => esc_html__( 'Default', 'farmart-addons' ),
					'date'       => esc_html__( 'Date', 'farmart-addons' ),
					'title'      => esc_html__( 'Title', 'farmart-addons' ),
					'menu_order' => esc_html__( 'Menu Order', 'farmart-addons' ),
					'rand'       => esc_html__( 'Random', 'farmart-addons' ),
				],
				'default'   => '',
				'condition' => [
					'products' => [ 'top_rated', 'sale', 'featured' ],
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
				'condition' => [
					'products' => [ 'top_rated', 'sale', 'featured' ],
				],
			]
		);

		$this->add_control(
			'divider_1',
			[
				'label'     => esc_html__( 'Item', 'farmart-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'product_item_height',
			[
				'label'       => esc_html__( 'Min Height', 'farmart-addons' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'description' => esc_html__( 'Should be equal banner height', 'farmart-addons' ),
				'selectors'   => [
					'{{WRAPPER}} .fm-product-with-category ul.products li.product' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'product_title_length',
			[
				'label'                => esc_html__( 'Title Length', 'farmart-addons' ),
				'type'                 => Controls_Manager::SELECT,
				'options'              => [
					'default' => esc_html__( 'Default', 'farmart-addons' ),
					'custom'  => esc_html__( '1 Line', 'farmart-addons' ),
				],
				'default'              => 'default',
				'selectors_dictionary' => [
					'custom' => 'overflow: hidden;
									text-overflow: ellipsis;
									display: -webkit-box;
									-webkit-line-clamp: 1;
									-webkit-box-orient: vertical;
									line-height: 16px;
									max-height: 18px;',
				],
				'selectors'            => [
					'{{WRAPPER}} ul.products li.product .woocommerce-loop-product__title a' => '{{VALUE}}',
				],
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
				'label'       => esc_html__( 'Padding', 'farmart-addons' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => [ 'px', 'em', '%' ],
				'placeholder' => [
					'top'    => '',
					'right'  => '',
					'bottom' => '20',
					'left'   => '',
				],
				'selectors'   => [
					'{{WRAPPER}} .fm-product-with-category .header-cat' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-with-category .header-cat' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'heading_border',
				'label'    => esc_html__( 'Border', 'farmart-addons' ),
				'selector' => '{{WRAPPER}} .fm-product-with-category .header-cat',
			]
		);

		$this->add_control(
			'heading_style_divider',
			[
				'label'     => __( 'Title', 'farmart-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_title_typography',
				'selector' => '{{WRAPPER}} .fm-product-with-category .header-cat h2',
			]
		);

		$this->add_control(
			'heading_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-with-category .header-cat .cat-title'   => 'color: {{VALUE}}',
					'{{WRAPPER}} .fm-product-with-category .header-cat .cat-title a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'heading_title_hover_color',
			[
				'label'     => esc_html__( 'Hover Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-with-category .header-cat .cat-title:hover'   => 'color: {{VALUE}}',
					'{{WRAPPER}} .fm-product-with-category .header-cat .cat-title:hover a' => 'color: {{VALUE}}',
				],
			]
		);

		// Icon
		$this->add_control(
			'title_icon_style',
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
			'title_icon_color',
			[
				'label'     => esc_html__( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-with-category .header-cat h2 .farmart-svg-icon' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'title_icon_font_size',
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
					'{{WRAPPER}} .fm-product-with-category .header-cat h2 .farmart-svg-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'title_icon_right_spacing',
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
					'{{WRAPPER}} .fm-product-with-category .header-cat h2 .farmart-svg-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_popover();

		$this->end_controls_section();

	}

	protected function register_content_style_controls() {
		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__( 'Content', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'content_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-product-with-category .categories-box'                             => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .fm-product-with-category .categories-box .categories-box--footer'     => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .fm-product-with-category .products-box'                               => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .fm-product-with-category ul.products li.product'                      => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .fm-product-with-category ul.products li.product .product-inner:hover' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .fm-product-with-category ul.products li.product .product-bottom-box'  => 'border-color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Register the widget sidebar style controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_sidebar_style_controls() {
		$this->start_controls_section(
			'section_style_sidebar',
			[
				'label' => esc_html__( 'Sidebar', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'sidebar_width',
			[
				'label'      => esc_html__( 'Width', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range'      => [
					'%'  => [
						'min' => 0,
						'max' => 100
					],
					'px' => [
						'min' => 0,
						'max' => 1000
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-product-with-category .sidebar-box' => 'max-width: {{SIZE}}{{UNIT}}; flex: 0 0 {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'sidebar_position',
			[
				'label'                => esc_html__( 'Position', 'farmart-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'left'  => [
						'title' => __( 'Left', 'farmart-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => __( 'Right', 'farmart-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'              => 'left',
				'toggle'               => false,
				'selectors'            => [
					'{{WRAPPER}} .fm-product-with-category .sidebar-box' => '{{VALUE}}',
				],
				'selectors_dictionary' => [
					'left'  => 'order: 1;',
					'right' => 'order: 3;',
				],
			]
		);
		$this->end_controls_section();

		// Banner
		$this->start_controls_section(
			'section_style_banners',
			[
				'label' => esc_html__( 'Banners', 'farmart-addons' ),
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
					'{{WRAPPER}} .fm-product-with-category .images-slider .slick-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'sliders_arrow_width',
			[
				'label'     => esc_html__( 'Width', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'unit' => 'px',
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .fm-product-with-category .images-slider .slick-arrow' => 'width: {{SIZE}}{{UNIT}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sliders_arrow_height',
			[
				'label'     => esc_html__( 'Height', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'unit' => 'px',
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .fm-product-with-category .images-slider .slick-arrow' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .fm-product-with-category .images-slider .slick-prev-arrow' => 'left: {{VALUE}}px;',
					'{{WRAPPER}} .fm-product-with-category .images-slider .slick-next-arrow' => 'right: {{VALUE}}px;',
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
					'{{WRAPPER}} .fm-product-with-category .images-slider .slick-arrow' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-product-with-category .images-slider .slick-arrow' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-product-with-category .images-slider .slick-arrow' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-product-with-category .images-slider .slick-arrow:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-product-with-category .images-slider .slick-arrow:hover' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-product-with-category .images-slider .slick-arrow:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// Dots
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
			'sliders_dots_width',
			[
				'label'     => esc_html__( 'Size', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'unit' => 'px',
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .fm-product-with-category .images-slider .slick-dots li button'        => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .fm-product-with-category .images-slider .slick-dots li button:before' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}}',
				],

			]
		);
		$this->add_responsive_control(
			'sliders_dots_top_spacing',
			[
				'label'      => esc_html__( 'Top Spacing', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => - 200,
						'max' => 200,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-product-with-category .slick-dots' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_responsive_control(
			'sliders_dots_bottom_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => - 200,
						'max' => 200,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-product-with-category .slick-dots' => 'margin-bottom: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .fm-product-with-category .images-slider .slick-dots li button:before' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .fm-product-with-category .images-slider .slick-dots li.slick-active button:before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .fm-product-with-category .images-slider .slick-dots li button:hover:before'        => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_popover();

		$this->end_controls_section();

		// Quick Link
		$this->start_controls_section(
			'section_style_quicklink',
			[
				'label' => esc_html__( 'Categories Box', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'quicklink_background',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-product-with-category .categories-box' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'quicklink_padding',
			[
				'label'       => esc_html__( 'Padding', 'farmart-addons' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'placeholder' => [
					'top'    => '20',
					'right'  => '30',
					'bottom' => '25',
					'left'   => '30',
				],
				'selectors'   => [
					'{{WRAPPER}} .fm-product-with-category .categories-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'quicklink_style_divider',
			[
				'label'     => esc_html__( 'Quick Links', 'farmart-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);
		$this->start_controls_tabs( 'quicklink_style_settings' );
		$this->start_controls_tab( 'quicklink_title_style_tab', [ 'label' => esc_html__( 'Title', 'farmart-addons' ) ] );
		$this->add_responsive_control(
			'quicklink_title_spacing',
			[
				'label'      => esc_html__( 'Margin Bottom', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-product-with-category .categories-box h4' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_control(
			'quicklink_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-with-category .categories-box h4'   => 'color: {{VALUE}}',
					'{{WRAPPER}} .fm-product-with-category .categories-box h4 a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'quicklink_title_hover_color',
			[
				'label'     => esc_html__( 'Hover Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-with-category .categories-box h4:hover'   => 'color: {{VALUE}}',
					'{{WRAPPER}} .fm-product-with-category .categories-box h4:hover a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'quicklink_title_typography',
				'selector' => '{{WRAPPER}} .fm-product-with-category .categories-box h4',
			]
		);
		$this->end_controls_tab();

		// Link
		$this->start_controls_tab( 'quicklink_item_style_tab', [ 'label' => esc_html__( 'Items', 'farmart-addons' ) ] );
		$this->add_responsive_control(
			'quicklink_items_padding',
			[
				'label'              => esc_html__( 'Padding', 'farmart-addons' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px', '%' ],
				'allowed_dimensions' => 'vertical',
				'placeholder'        => [
					'top'    => '2',
					'right'  => 'auto',
					'bottom' => '2',
					'left'   => 'auto',
				],
				'selectors'          => [
					'{{WRAPPER}} .fm-product-with-category .categories-box ul.extra-links li'             => 'padding-top: {{TOP}}{{UNIT}}; padding-bottom: {{BOTTOM}}{{UNIT}};',
					'{{WRAPPER}} .fm-product-with-category .categories-box ul.extra-links li:first-child' => 'padding-top: 0;',
					'{{WRAPPER}} .fm-product-with-category .categories-box ul.extra-links li:last-child'  => 'padding-bottom: 0;',
				],
			]
		);
		$this->add_control(
			'quicklink_items_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-with-category .categories-box ul.extra-links a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'quicklink_items_hover_color',
			[
				'label'     => esc_html__( 'Hover Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-with-category .categories-box ul.extra-links a:hover' => 'color: {{VALUE}}; box-shadow: inset 0 0 0 transparent, inset 0 -1px 0 {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'quicklink_link_typography',
				'selector' => '{{WRAPPER}} .fm-product-with-category .categories-box ul.extra-links',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// View All
		$this->add_control(
			'view_all_style_divider',
			[
				'label'     => esc_html__( 'View All Button', 'farmart-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'heading_links_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-with-category .categories-box .header-link span' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_control(
			'heading_links_hover_color',
			[
				'label'     => esc_html__( 'Hover Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-product-with-category .categories-box .header-link:hover span'       => 'color: {{VALUE}}',
					'{{WRAPPER}} .fm-product-with-category .categories-box .header-link:hover .link-text' => 'text-shadow: 0 0 {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_links_typography',
				'selector' => '{{WRAPPER}} .fm-product-with-category .categories-box .header-link .link-text',
			]
		);

		// Icon
		$this->add_control(
			'header_link_icon_style',
			[
				'label'        => __( 'Icon', 'farmart-addons' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'farmart-addons' ),
				'label_on'     => __( 'Custom', 'farmart-addons' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'header_link_icon_font_size',
			[
				'label'     => __( 'Font Size', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .fm-product-with-category .categories-box .header-link .farmart-svg-icon'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .fm-product-with-category .categories-box .header-link .farmart-svg-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_responsive_control(
			'header_link_icon_spacing',
			[
				'label'     => __( 'Spacing', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 20,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .fm-product-with-category .categories-box .header-link .farmart-svg-icon' => 'padding-left: {{SIZE}}{{UNIT}};',
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
				'type'  => Controls_Manager::HEADING,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'responsive_breakpoint', [
				'label'       => __( 'Breakpoint', 'farmart-addons' ) . ' (px)',
				'description' => __( 'Below this breakpoint the options below will be triggered', 'farmart-addons' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 1200,
				'min'         => 320,
				'max'         => 1920,
			]
		);
		$repeater->add_control(
			'responsive_navigation',
			[
				'label'   => esc_html__( 'Navigation', 'farmart-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'both'   => esc_html__( 'Arrows and Dots', 'farmart-addons' ),
					'arrows' => esc_html__( 'Arrows', 'farmart-addons' ),
					'dots'   => esc_html__( 'Dots', 'farmart-addons' ),
					'none'   => esc_html__( 'None', 'farmart-addons' ),
				],
				'default' => 'dots',
				'toggle'  => false,
			]
		);

		$this->add_control(
			'carousel_responsive_settings',
			[
				'label'         => __( 'Settings', 'farmart-addons' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [],
				'title_field'   => '{{{ responsive_breakpoint }}}' . 'px',
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
					'' => 'display: none',
				],
				'selectors'            => [
					'{{WRAPPER}} .fm-product-with-category ul.products li.product .product-button .group-yith a span' => '{{VALUE}}',
				],
			]
		);
		$this->add_control(
			'swatches',
			[
				'label'                => esc_html__( 'Swatches', 'farmart-addons' ),
				'type'                 => Controls_Manager::SWITCHER,
				'label_on'             => esc_html__( 'Show', 'farmart-addons' ),
				'label_off'            => esc_html__( 'Hide', 'farmart-addons' ),
				'return_value'         => 'yes',
				'default'              => '',
				'selectors_dictionary' => [
					''    => 'display: none',
					'yes' => 'display: block',
				],
				'selectors'            => [
					'{{WRAPPER}} .fm-product-with-category ul.products li.product .product-thumbnail .fm-attr-swatches' => '{{VALUE}}',
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
				'label'     => esc_html__( 'Enable', 'farmart-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'farmart-addons' ),
				'label_off' => esc_html__( 'No', 'farmart-addons' ),
				'default'   => '',
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
				'fm-product-with-category woocommerce',
				$settings['lazy_load'] == 'yes' ? '' : 'no-infinite',
				$settings['hide_icon_button'] == 'yes' ? 'hide-icon-button' : ''
			]
		);

		$id = uniqid( 'fm-product-with-category-' );

		$is_rtl    = is_rtl();
		$direction = $is_rtl ? 'rtl' : 'ltr';
		$this->add_render_attribute( 'wrapper', 'dir', $direction );

		$this->add_render_attribute( 'wrapper', 'id', $id );

		?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( $settings['lazy_load'] == 'yes' ) : ?>
				<?php
				// AJAX settings
				$this->add_render_attribute(
					'ajax_wrapper', 'class', [
						'fm-product-with-category-loading fm-elementor-ajax-wrapper'
					]
				);
				$ajax_settings = [
					'title'                        => $settings['title'],
					'c_link'                       => $settings['c_link'],
					'title_icon'                   => $settings['title_icon'],
					'view_all_text'                => $settings['view_all_text'],
					'view_all_link'                => $settings['view_all_link'],
					'view_all_icon'                => $settings['view_all_icon'],
					'banners'                      => $settings['banners'],
					'quick_links'                  => $settings['quick_links'],
					'quicklink_columns'            => $settings['quicklink_columns'],
					'quicklink_title_1'            => $settings['quicklink_title_1'],
					'quicklink_url_1'              => $settings['quicklink_url_1'],
					'links_group_1'                => $settings['links_group_1'],
					'quicklink_title_2'            => $settings['quicklink_title_2'],
					'quicklink_url_2'              => $settings['quicklink_url_2'],
					'links_group_2'                => $settings['links_group_2'],
					'columns'                      => $settings['columns'],
					'products'                     => $settings['products'],
					'product_cats'                 => $settings['product_cats'],
					'product_tags'                 => $settings['product_tags'],
					'per_page'                     => $settings['per_page'],
					'orderby'                      => $settings['orderby'],
					'order'                        => $settings['order'],
					'navigation'                   => $settings['navigation'],
					'navigation_tablet'            => $settings['navigation_tablet'],
					'navigation_mobile'            => $settings['navigation_mobile'],
					'infinite'                     => $settings['infinite'],
					'autoplay'                     => $settings['autoplay'],
					'autoplay_speed'               => $settings['autoplay_speed'],
					'speed'                        => $settings['speed'],
					'carousel_responsive_settings' => $settings['carousel_responsive_settings'],
				];
				$this->add_render_attribute( 'ajax_wrapper', 'data-settings', wp_json_encode( $ajax_settings ) );
				?>
                <div <?php echo $this->get_render_attribute_string( 'ajax_wrapper' ); ?>>
                    <div class="farmart-loading-wrapper">
                        <div class="farmart-loading"></div>
                    </div>
                </div>
			<?php else : ?>
				<?php Elementor_AjaxLoader::get_products_with_category( $settings ); ?>
			<?php endif; ?>
        </div>

		<?php

		$vertical_tab_icon = '';
		if ( $settings['vertical_tab_title_icon'] && ! empty( $settings['vertical_tab_title_icon']['value'] ) && \Elementor\Icons_Manager::is_migration_allowed() ) {
			ob_start();
			\Elementor\Icons_Manager::render_icon( $settings['vertical_tab_title_icon'], [ 'aria-hidden' => 'true' ] );
			$vertical_tab_icon = '<span class="farmart-svg-icon">' . ob_get_clean() . '</span>';
		}

		$this->add_render_attribute(
			'vertical_tab_item',
			[
				'href'          => '#' . $id,
				'class'         => $id,
				'title'         => $settings['vertical_tab_title'],
				'data-tooltips' => $settings['vertical_tab_title'],
			]
		);

		if ( $settings['vertical_tab'] == 'yes' ) {
			printf(
				'<div class="vertical-tab-content hidden"><a %s>%s</a></div>',
				$this->get_render_attribute_string( 'vertical_tab_item' ),
				$vertical_tab_icon
			);
		}
	}
}