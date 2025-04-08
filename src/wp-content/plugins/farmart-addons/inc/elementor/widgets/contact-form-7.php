<?php

namespace FarmartAddons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon Box widget
 */
class Contact_Form_7 extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'farmart-contact-form-7';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Farmart - Contact Form 7', 'farmart-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-mail';
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

		$this->start_controls_section(
			'section_content',
			[ 'label' => esc_html__( 'Content', 'farmart-addons' ) ]
		);

		$this->add_control(
			'form',
			[
				'label'   => esc_html__( 'Contact Form 7', 'farmart-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $this->get_contact_form(),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__( 'Content', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'textarea_height',
			[
				'label' => __( 'Textarea Field Height', 'farmart-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 60,
						'max' => 300,
					],
				],
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .farmart-contact-form-7 textarea' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'input_height',
			[
				'label' => __( 'Input Field Height', 'farmart-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .farmart-contact-form-7 input' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'space',
			[
				'label' => __( 'Space Items', 'farmart-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .farmart-contact-form-7 .wpcf7-form-control-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_content',
			[
				'label' => esc_html__( 'Button', 'farmart-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'after',
			]
		);

		$this->add_control(
			'button_width',
			[
				'label'     => esc_html__( 'Button Width', 'farmart-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'auto' => esc_html__( 'Auto', 'farmart-addons' ),
					'100%' => esc_html__( 'Full Width', 'farmart-addons' ),
				],
				'default'   => '100%',
				'toggle'    => false,
				'selectors' => [
					'{{WRAPPER}} .farmart-contact-form-7 .wpcf7 .wpcf7-submit' => 'width: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'btn_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-contact-form-7 .wpcf7 .wpcf7-submit' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-contact-form-7 .wpcf7 .wpcf7-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .farmart-contact-form-7 .wpcf7 .wpcf7-submit',
			]
		);

		$this->add_control(
			'btn_border',
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
			'button_border_style',
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
					'{{WRAPPER}} .farmart-contact-form-7 .wpcf7 .wpcf7-submit' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_border_width',
			[
				'label'     => esc_html__( 'Border Width', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-contact-form-7 .wpcf7 .wpcf7-submit' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'     => esc_html__( 'Border Radius', 'farmart-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .farmart-contact-form-7 .wpcf7 .wpcf7-submit' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);

		$this->end_popover();

		$this->start_controls_tabs( 'button_tabs' );

		$this->start_controls_tab( 'normal', [ 'label' => esc_html__( 'Normal', 'farmart-addons' ) ] );

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-contact-form-7 .wpcf7 .wpcf7-submit' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-contact-form-7 .wpcf7 .wpcf7-submit' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-contact-form-7 .wpcf7 .wpcf7-submit' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover', [ 'label' => esc_html__( 'Hover', 'farmart-addons' ) ] );

		$this->add_control(
			'button_hover_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-contact-form-7 .wpcf7 .wpcf7-submit:hover' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_control(
			'button_hover_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-contact-form-7 .wpcf7 .wpcf7-submit:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .farmart-contact-form-7 .wpcf7 .wpcf7-submit:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

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

		$classes = [
			'farmart-contact-form-7'
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( $settings['form'] ) :
				echo do_shortcode( '[contact-form-7 id="' . esc_attr( $settings['form'] ) . '"]' );
			endif; ?>
		</div>
		<?php
	}

	/**
	 * Get Contact Form
	 */
	protected function get_contact_form() {
		$mail_forms    = get_posts( 'post_type=wpcf7_contact_form&posts_per_page=-1' );
		$mail_form_ids = array(
			'' => esc_html__( 'Select Form', 'farmart-addons' ),
		);
		foreach ( $mail_forms as $form ) {
			$mail_form_ids[$form->ID] = $form->post_title;
		}

		return $mail_form_ids;
	}
}