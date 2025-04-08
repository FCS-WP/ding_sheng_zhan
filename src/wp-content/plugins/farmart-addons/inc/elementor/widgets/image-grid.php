<?php

namespace FarmartAddons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Image Grid widget
 */
class Image_Grid extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'farmart-image-grid';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Farmart - Image Grid', 'farmart-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-gallery-grid';
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
	}

	protected function section_setting_content( ) {
		$this->start_controls_section(
			'section_content',
			[ 'label' => esc_html__( 'Content', 'farmart-addons' ) ]
		);

		$this->add_control(
			'items_style',
			[
				'label'   => esc_html__( 'Items Style', 'farmart-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'columns',
				'options' => [
					'columns' => esc_html__( 'Columns', 'farmart-addons' ),
					'flex' => esc_html__( 'Flex', 'farmart-addons' ),
				],
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'        => esc_html__( 'Columns', 'farmart-addons' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => [
					'1' => esc_html__( '1 Columns', 'farmart-addons' ),
					'2' => esc_html__( '2 Columns', 'farmart-addons' ),
					'3' => esc_html__( '3 Columns', 'farmart-addons' ),
					'4' => esc_html__( '4 Columns', 'farmart-addons' ),
					'5' => esc_html__( '5 Columns', 'farmart-addons' ),
					'6' => esc_html__( '6 Columns', 'farmart-addons' ),
					'7' => esc_html__( '7 Columns', 'farmart-addons' ),
					'8' => esc_html__( '8 Columns', 'farmart-addons' ),
				],
				'default'      => '5',
				'toggle'       => false,
				'prefix_class' => 'columns-%s',
				'condition'   => [
					'items_style' => 'columns',
				],
			]
		);

		$this->add_responsive_control(
			'position',
			[
				'label'     => esc_html__( 'Align', 'farmart-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start'   => [
						'title' => esc_html__( 'Left', 'farmart-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'farmart-addons' ),
						'icon'  => 'eicon-h-align-center',
					],
					'flex-end'  => [
						'title' => esc_html__( 'Right', 'farmart-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-image-grid' => 'justify-content: {{VALUE}};',
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

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'image',
			[
				'label'   => esc_html__( 'Image', 'farmart-addons' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/235x90/f5f5f5?text=235x90',
				],
			]
		);

		$repeater->add_control(
			'link', [
				'label'         => esc_html__( 'Link', 'farmart-addons' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'farmart-addons' ),
				'description'   => esc_html__( 'Just works if the value of Lightbox is No', 'farmart-addons' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$repeater->add_control(
			'align',
			[
				'label'           => esc_html__( 'Align', 'farmart-addons' ),
				'type'            => Controls_Manager::SELECT,
				'options'         => [
					'left'  	=> esc_html__( 'Left', 'farmart-addons' ),
					'center' 	=> esc_html__( 'Center', 'farmart-addons' ),
				],
				'default' 		=> 'center',
				'toggle'          => false,
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
						'image' => [
							'url' => 'https://via.placeholder.com/235x90?text=235x90'
						],
					],[
						'image' => [
							'url' => 'https://via.placeholder.com/235x90?text=235x90'
						],
					],[
						'image' => [
							'url' => 'https://via.placeholder.com/235x90?text=235x90'
						],
					],[
						'image' => [
							'url' => 'https://via.placeholder.com/235x90?text=235x90'
						],
					],[
						'image' => [
							'url' => 'https://via.placeholder.com/235x90?text=235x90'
						],
					],
				],
				'prevent_empty' => false,
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	// Style
	protected function section_style() {
		$this->section_content_style();
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
			'items_padding',
			[
				'label'      =>esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-image-grid .box-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'items_margin',
			[
				'label'      => esc_html__( 'Margin', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-image-grid .box-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'border_style',
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
					'{{WRAPPER}} .farmart-image-grid, {{WRAPPER}} .farmart-image-grid .box-item' => 'border-style: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'border_color',
			[
				'label'     => esc_html__( 'Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-image-grid, {{WRAPPER}} .farmart-image-grid .box-item' => 'border-color: {{VALUE}}',

				],
			]
		);

		$this->add_control(
			'border_width',
			[
				'label' => __( 'Border Width', 'farmart-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-image-grid .box-item' => 'border-width: 0 {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} 0;',
					'{{WRAPPER}} .farmart-image-grid' => 'border-width: {{TOP}}{{UNIT}} 0 0 {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'bk_color',
			[
				'label'     => __( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-image-grid .box-item'     => 'background-color: {{VALUE}};',
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
				'farmart-image-grid',
			]
		);

		$output = [ ];
		$els = $settings['elements'];

		if ( ! empty ( $els ) ) {

			foreach ( $els as $index => $item ) {
				$align = $item['align'] == 'left' ? 'image-left' : '';

				$settings['image']      = $item['image'];
				$image = Group_Control_Image_Size::get_attachment_image_html( $settings );

				$key = 'image_' . $index;

			    if ( $item['link']['url'] ) :
					$image = $this->get_link_control( $key, $item['link'], $image, [ 'class' => 'has-link' ] );
				endif;

				$output[] = sprintf( '<div class="box-item %s">%s</div>', $align, $image );
			}

		}

		?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
	        <?php echo implode( '', $output ) ?>
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