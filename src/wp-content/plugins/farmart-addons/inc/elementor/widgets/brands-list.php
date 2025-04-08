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
class Products_Brands extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'farmart-products-brands';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Farmart - Brands List', 'farmart-addons' );
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
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Section Style
	 */
	protected function section_style() {
		$this->section_garenal_style();
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
		$this->add_responsive_control(
			'general_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-products-brands' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'general_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-products-brands' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'general_border',
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
			'general_border_style',
			[
				'label'     => esc_html__( 'Border Style', 'farmart-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'dotted' => esc_html__( 'Dotted', 'farmart-addons' ),
					'dashed' => esc_html__( 'Dashed', 'farmart-addons' ),
					'solid'  => esc_html__( 'Solid', 'farmart-addons' ),
					'none'   => esc_html__( 'None', 'farmart-addons' ),
				],
				'default'   => '',
				'toggle'    => false,
				'selectors' => [
					'{{WRAPPER}} .farmart-products-brands' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'general_border_width',
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
					'{{WRAPPER}} .farmart-products-brands' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'general_border_color',
			[
				'label'     => __( 'Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-products-brands' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_popover();

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
				'farmart-brands-list',
			]
		);


		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>

		</div>
		<?php

	}


}