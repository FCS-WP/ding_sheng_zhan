<?php

namespace FarmartAddons\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Banner Medium widget
 */
class Banner_Larger extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'farmart-banner-larger';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Farmart - Banner Larger', 'farmart-addons' );
	}


	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-banner';
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

	// Tab Content
	protected function section_content() {
		$this->section_content_banner();
	}

	protected function section_content_banner() {
		$this->start_controls_section(
			'section_banner',
			[ 'label' => esc_html__( 'Content', 'farmart-addons' ) ]
		);

		$this->add_responsive_control(
			'height',
			[
				'label'     => esc_html__( 'Height', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [],
				'range'     => [
					'px' => [
						'min' => 100,
						'max' => 600,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-banner-larger .banner-content' => 'height: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'elements',
			[
				'label' => esc_html__( 'Elements', 'farmart-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'banner_content_settings' );

		$this->start_controls_tab( 'content_text', [ 'label' => esc_html__( 'Text', 'farmart-addons' ) ] );

		$this->add_control(
			'highlight',
			[
				'label'       => esc_html__( 'Highlight', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'This is the highlight', 'farmart-addons' ),
				'placeholder' => esc_html__( 'Enter your highlight', 'farmart-addons' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'position_highlight',
			[
				'label'       => esc_html__( 'Highlight', 'farmart-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'above' => esc_html__( 'Above the title', 'farmart-addons' ),
					'under' => esc_html__( 'Under the title', 'farmart-addons' ),
				],
				'default'   => 'above',
				'label_block' => true,
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter your text', 'farmart-addons' ),
				'label_block' => true,
				'default'     => __( 'This is the title', 'farmart-addons' ),
			]
		);

		$this->add_control(
			'desc',
			[
				'label'       => esc_html__( 'Description', 'farmart-addons' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => __( 'This is the desc', 'farmart-addons' ),
				'placeholder' => esc_html__( 'Enter your description', 'farmart-addons' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'button_link', [
				'label'         => esc_html__( 'Link URL', 'farmart-addons' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'farmart-addons' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'content_sale', [ 'label' => esc_html__( 'Sale', 'farmart-addons' ) ] );

		$this->add_control(
			'text_box',
			[
				'label'       => esc_html__( 'Text box', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter your text', 'farmart-addons' ),
				'label_block' => true,
				'default'     => __( 'This is the text', 'farmart-addons' ),
			]
		);

		$this->add_control(
			'price_box',
			[
				'label'       => esc_html__( 'Sale Number', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your number', 'farmart-addons' ),
				'label_block' => true,
				'default'     => __( '49', 'farmart-addons' ),
			]
		);

		$this->add_control(
			'unit_box',
			[
				'label'       => esc_html__( 'Unit', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your unit', 'farmart-addons' ),
				'label_block' => true,
				'default'     => __( '%', 'farmart-addons' ),
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'background', [ 'label' => esc_html__( 'Background', 'farmart-addons' ) ] );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'banners_background',
				'label'    => __( 'Background', 'farmart-addons' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .farmart-banner-larger .banner-featured-image',
				'fields_options'  => [
					'background' => [
						'default' => 'classic',
					],
					'image' => [
						'default'   => [
							'url' => 'https://via.placeholder.com/1170X170/cccccc?text=1170x170+Image',
						],
					],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	// Tab Style
	protected function section_style(){
		$this->section_style_banner();
		$this->section_style_title();
		$this->section_style_sale();
		$this->section_style_divider();
	}

	protected function section_style_banner(){
		// Banner
		$this->start_controls_section(
			'section_style_banner',
			[
				'label' => esc_html__( 'Content', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_max_width',
			[
				'label'          => esc_html__( 'Content Width', 'farmart-addons' ),
				'type'           => Controls_Manager::SLIDER,
				'range'          => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units'     => [ '%', 'px' ],
				'default'        => [
					'size' => '72',
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'selectors'      => [
					'{{WRAPPER}} .farmart-banner-larger .banner-content' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'banner_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-banner-larger .banner-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'banner_horizontal_position',
			[
				'label'        => esc_html__( 'Horizontal Position', 'farmart-addons' ),
				'type'         => Controls_Manager::CHOOSE,
				'label_block'  => false,
				'default'      => 'center',
				'options'      => [
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
				'prefix_class' => 'farmart--h-position-',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'banner_vertical_position',
			[
				'label'        => esc_html__( 'Vertical Position', 'farmart-addons' ),
				'type'         => Controls_Manager::CHOOSE,
				'label_block'  => false,
				'default'      => 'middle',
				'options'      => [
					'top'    => [
						'title' => esc_html__( 'Top', 'farmart-addons' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => esc_html__( 'Middle', 'farmart-addons' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'farmart-addons' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'prefix_class' => 'farmart--v-position-',
			]
		);

		$this->add_control(
			'banner_text_align',
			[
				'label'       => esc_html__( 'Text Align', 'farmart-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					''   => [
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
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .farmart-banner-larger .banner-content' => 'justify-content: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function section_style_title(){

		// Title
		$this->start_controls_section(
			'section_style_title',
			[
				'label' => esc_html__( 'Text', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'style_text' );

		$this->start_controls_tab( 'hightlight_text', [ 'label' => esc_html__( 'Hightlight', 'farmart-addons' ) ] );

		$this->add_control(
			'hightlight_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-banner-larger .highlight' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'hightlight_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-banner-larger .highlight' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'hightlight_typography',
				'selector' => '{{WRAPPER}} .farmart-banner-larger .highlight',
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab( 'title_text', [ 'label' => esc_html__( 'Title', 'farmart-addons' ) ] );

		$this->add_control(
			'heading_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-banner-larger .title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-banner-larger .title' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .farmart-banner-larger .title',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'desc_text', [ 'label' => esc_html__( 'Desc', 'farmart-addons' ) ] );

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-banner-larger .desc' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .farmart-banner-larger .desc',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function section_style_sale(){

		// Title
		$this->start_controls_section(
			'section_style_sale',
			[
				'label' => esc_html__( 'Sale', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'style_sale_setting' );

		$this->start_controls_tab( 'note_sale_style', [ 'label' => esc_html__( 'Text', 'farmart-addons' ) ] );

		$this->add_control(
			'note_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-banner-larger .text-sale' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'note_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-banner-larger .text-sale' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'note_typography',
				'selector' => '{{WRAPPER}} .farmart-banner-larger .text-sale',
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab( 'num_sale_text', [ 'label' => esc_html__( 'Number', 'farmart-addons' ) ] );

		$this->add_control(
			'num_sale_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-banner-larger .number-sale' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'num_sale_typography',
				'selector' => '{{WRAPPER}} .farmart-banner-larger .number-sale',
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab( 'price_box_style', [ 'label' => esc_html__( 'Unit', 'farmart-addons' ) ] );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'price_box_typography',
				'selector' => '{{WRAPPER}} .farmart-banner-larger .unit-sale',
			]
		);

		$this->add_responsive_control(
			'price_box_position_left',
			[
				'label'              => esc_html__( 'Position ', 'farmart-addons' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'allowed_dimensions' => [ 'top', 'right' ],
				'size_units'         => [ 'px', '%' ],
				'default'            => [],
				'selectors'          => [
					'{{WRAPPER}} .farmart-banner-larger .unit-sale' => ' top:{{TOP}}{{UNIT}};right: {{RIGHT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'price_box_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-banner-larger .unit-sale' => 'color: {{VALUE}}',

				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->end_controls_section();
	}

	protected function section_style_divider(){
		// Divider
		$this->start_controls_section(
			'section_style_divider',
			[
				'label' => esc_html__( 'Divider', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'divider_spacing',
			[
				'label'              => esc_html__( 'Spacing ', 'farmart-addons' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'allowed_dimensions' => [ 'left', 'right' ],
				'size_units'         => [ 'px', '%' ],
				'default'            => [],
				'selectors'          => [
					'{{WRAPPER}} .farmart-banner-larger .divider' => ' margin-left:{{LEFT}}{{UNIT}};margin-right: {{RIGHT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'divider_bkcolor',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-banner-larger .divider' => 'background-color: {{VALUE}}',

				],
			]
		);

		$this->add_control(
			'divider_width',
			[
				'label'      => esc_html__( 'Width', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px','%' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-banner-larger .divider' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'divider_height',
			[
				'label'      => esc_html__( 'Height', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px','%' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-banner-larger .divider' => 'height: {{SIZE}}{{UNIT}};',
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

		$this->add_render_attribute( 'wrapper', 'class', [
			'farmart-banner-larger',
		] );

		if ( $settings['button_link']['is_external'] ) {
			$this->add_render_attribute( 'link', 'target', '_blank' );
		}

		if ( $settings['button_link']['nofollow'] ) {
			$this->add_render_attribute( 'link', 'rel', 'nofollow' );
		}

		if ( $settings['button_link']['url'] ) {
			$this->add_render_attribute( 'link', 'href', $settings['button_link']['url'] );
		}

		// Content
		$title = $settings['title'] ? sprintf('<h3 class="title">%s</h3>',$settings['title']) : '';
		$bf_unit    = $settings['highlight'] ? sprintf('<h3 class="highlight">%s</h3>',$settings['highlight']) : '';

		$pos_title = $settings['position_highlight'] == 'above' ? $bf_unit.$title : $title.$bf_unit ;

		$desc = $settings['desc'] ? sprintf('<div class="desc">%s</div>',$settings['desc']) : '';

		$html_text =  $bf_unit == '' && $title == ''&& $desc == ''? '' : sprintf('<div class="banner-content__text">%s %s</div>',$pos_title,$desc);

		// Sale
		$text_sale = $settings['text_box'] ? sprintf('<h5 class="text-sale">%s</h5>',$settings['text_box']) : '';
		$unit_sale = $settings['unit_box'] ? sprintf('<span class="unit-sale">%s</span>',$settings['unit_box']) : '';
		$num_sale = $settings['price_box'] ? sprintf('<div class="number-sale">%s %s</div>',$settings['price_box'],$unit_sale) : '';

		$html_sale =  $text_sale == '' && $num_sale == '' ? '' : sprintf('<div class="banner-content__sale">%s %s</div>',$text_sale,$num_sale);

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div class="banner-featured-image"></div>
			<?php if ( $settings['button_link']['url'] ) : ?>
				<a class="link" <?php echo $this->get_render_attribute_string( 'link' ); ?>></a>
			<?php endif; ?>
			<div class="banner-content">
				<?php echo $html_sale?>
				<div class="divider"></div>
				<?php echo $html_text?>
			</div>
		</div>
		<?php
	}
}