<?php

namespace FarmartAddons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Group_Control_Border;
use FarmartAddons\Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Blog widget
 */
class Products_Brands extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'fm-products-brands';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Farmart - Product Brands', 'farmart-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-posts-grid';
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
		$this->brands_settings_controls();
		$this->products_settings_controls();
		$this->pagination_settings_controls();
	}

	protected function brands_settings_controls() {

		// Brands Settings
		$this->start_controls_section(
			'section_blogs',
			[ 'label' => esc_html__( 'Brands', 'farmart-addons' ) ]
		);

		// $this->add_control(
		// 	'source',
		// 	[
		// 		'label'       => esc_html__( 'Source', 'farmart-addons' ),
		// 		'type'        => Controls_Manager::SELECT,
		// 		'options'     => [
		// 			'default' => esc_html__( 'Default', 'farmart-addons' ),
		// 			'custom'  => esc_html__( 'Custom', 'farmart-addons' ),
		// 		],
		// 		'default'     => 'default',
		// 		'label_block' => true,
		// 	]
		// );

		// $this->add_control(
		// 	'ids',
		// 	[
		// 		'label'       => esc_html__( 'Brands', 'farmart-addons' ),
		// 		'placeholder' => esc_html__( 'Click here and start typing...', 'farmart-addons' ),
		// 		'type'        => 'fmautocomplete',
		// 		'default'     => '',
		// 		'label_block' => true,
		// 		'multiple'    => true,
		// 		'source'      => 'product_brand',
		// 		'sortable'    => true,
		// 		'condition'   => [
		// 			'source' => 'custom',
		// 		],
		// 	]
		// );

		$this->add_control(
			'perpage',
			[
				'label'     => esc_html__( 'Brands Per Page', 'farmart-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 3,
				'min'       => 2,
				'max'       => 50,
				'step'      => 1,
			]
		);

		$this->add_control(
			'brand_orderby',
			[
				'label'      => esc_html__( 'Order By', 'farmart-addons' ),
				'type'       => Controls_Manager::SELECT,
				'options'    => [
					''           => esc_html__( 'Default', 'farmart-addons' ),
					'menu_order' => esc_html__( 'Order', 'farmart-addons' ),
					'date'       => esc_html__( 'Date', 'farmart-addons' ),
					'name'       => esc_html__( 'Name', 'farmart-addons' ),
					'id'         => esc_html__( 'Ids', 'farmart-addons' ),
					'rand'       => esc_html__( 'Random', 'farmart-addons' ),
				],
				'default'    => '',
			]
		);

		$this->add_control(
			'brand_order',
			[
				'label'      => esc_html__( 'Order', 'farmart-addons' ),
				'type'       => Controls_Manager::SELECT,
				'options'    => [
					''     => esc_html__( 'Default', 'farmart-addons' ),
					'asc'  => esc_html__( 'Ascending', 'farmart-addons' ),
					'desc' => esc_html__( 'Descending', 'farmart-addons' ),
				],
				'default'    => '',
			]
		);

		$this->end_controls_section();
	}

	protected function products_settings_controls() {

		$this->start_controls_section(
			'section_products',
			[ 'label' => esc_html__( 'Products', 'farmart-addons' ) ]
		);
		$this->add_control(
			'per_page',
			[
				'label'   => esc_html__( 'Products per brand', 'farmart-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 4,
				'min'     => 2,
				'max'     => 50,
				'step'    => 1,
			]
		);

		$this->add_control(
			'columns',
			[
				'label'   => esc_html__( 'Columns', 'farmart-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 4,
				'min'     => 2,
				'max'     => 10,
				'step'    => 1,
			]
		);
		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order By', 'farmart-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''           => esc_html__( 'Default', 'farmart-addons' ),
					'date'       => esc_html__( 'Date', 'farmart-addons' ),
					'title'      => esc_html__( 'Title', 'farmart-addons' ),
					'menu_order' => esc_html__( 'Menu Order', 'farmart-addons' ),
					'rand'       => esc_html__( 'Random', 'farmart-addons' ),
				],
				'default' => '',
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'farmart-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''     => esc_html__( 'Default', 'farmart-addons' ),
					'asc'  => esc_html__( 'Ascending', 'farmart-addons' ),
					'desc' => esc_html__( 'Descending', 'farmart-addons' ),
				],
				'default' => '',
			]
		);
		$this->end_controls_section();
	}

	protected function pagination_settings_controls() {
		// Pagination Settings
		$this->start_controls_section(
			'section_pagination',
			[
				'label' => esc_html__( 'Pagination', 'farmart-addons' ),
			]
		);
		$this->add_control(
			'load_more',
			[
				'label'        => __( 'Button', 'farmart-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'farmart-addons' ),
				'label_off'    => __( 'Hide', 'farmart-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->add_control(
			'load_more_text',
			[
				'label'       => esc_html__( 'Text', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Load More', 'farmart-addons' ),
				'label_block' => true,
			]
		);
		$this->end_controls_section(); // End Pagination Settings

		$this->end_controls_section();
	}

	/**
	 * Section Style
	 */
	protected function section_style() {
		$this->section_garenal_style();
		$this->section_content_style();
	}

	protected function section_garenal_style() {
		// Heading Style
		$this->start_controls_section(
			'section_general_style',
			[
				'label' => esc_html__( 'Ganeral', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'general_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-products-brands .product-brands' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function section_content_style() {
		// Content Style
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content', 'farmart-addons' ),
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

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .fm-products-brands .brand-item-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .fm-products-brands .brand-item-wrapper' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'heading_style_tabs', [ 'separator' => 'before', ] );

		$this->start_controls_tab(
			'img_title_style',
			[
				'label' => __( 'Logo', 'farmart-addons' ),
			]
		);

		$this->add_responsive_control(
			'img_spacing',
			[
				'label'      => __( 'Spacing', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [],
				'selectors'  => [
					'{{WRAPPER}} .fm-products-brands .brand-logo' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'heading_title_style',
			[
				'label' => __( 'Name', 'farmart-addons' ),
			]
		);

		$this->add_responsive_control(
			'name_spacing',
			[
				'label'      => __( 'Spacing', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [],
				'selectors'  => [
					'{{WRAPPER}} .fm-products-brands .brand-info__name' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .fm-products-brands .brand-info__name',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-products-brands .brand-info__name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'heading_desc_style',
			[
				'label' => __( 'Desc', 'farmart-addons' ),
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typography',
				'selector' => '{{WRAPPER}} .fm-products-brands .brand-info__desc',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => esc_html__( 'Desc Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .fm-products-brands .brand-info__desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'heading_btn_style',
			[
				'label' => __( 'Button', 'farmart-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_links_typography',
				'selector' => '{{WRAPPER}} .fm-products-brands .brand-btn',
			]
		);

		$this->add_control(
			'heading_btn_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-products-brands .brand-btn' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'heading_btn_hover_color',
			[
				'label'     => esc_html__( 'Hover Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fm-products-brands .brand-btn:hover' => 'color: {{VALUE}}',
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
					'{{WRAPPER}}  .fm-products-brands .brand-btn i' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .fm-products-brands .brand-btn i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'link_icon_right_spacing',
			[
				'label'      => esc_html__( 'Left Spacing', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .fm-products-brands .brand-btn i' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_popover();

		$this->end_controls_tab();
		$this->end_controls_tabs();

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
				'fm-products-brands',
				$settings['hide_icon_button'] == 'yes' ? 'hide-icon-button' : ''
			]
		);

		$this->add_render_attribute( 'wrapper', 'data-text', $settings['load_more_text'] );

		$products = Elementor::brands_loop( $settings );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php echo $products; ?>
		</div>
		<?php

	}


}