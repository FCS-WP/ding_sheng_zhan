<?php

namespace FarmartAddons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon Box widget
 */
class Newsletter extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'farmart-newsletter';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Farmart - Newsletter', 'farmart-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-mailchimp';
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

	/**
	 * Section Content
	 */
	protected function section_content() {
		$this->start_controls_section(
			'section_content',
			[ 'label' => esc_html__( 'Content', 'farmart-addons' ) ]
		);

		$this->add_control(
			'form',
			[
				'label'   => esc_html__( 'Mailchimp Form', 'farmart-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $this->get_contact_form(),
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Section Style
	 */
	protected function section_style() {
		$this->section_form_style();
		$this->section_field_style();
		$this->section_button_style();
	}

	/**
	 * Element in Tab Style
	 *
	 * Form
	 */
	protected function section_form_style() {
		$this->start_controls_section(
			'section_form_style',
			[
				'label' => __( 'Form', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'form_display',
			[
				'label'   => esc_html__( 'Display', 'farmart-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'flex',
				'options' => [
					'flex'  => esc_html__( 'Flex', 'farmart-addons' ),
					'block' => esc_html__( 'Block', 'farmart-addons' ),
				],
				'selectors'  => [
					'{{WRAPPER}} .farmart-newletter .mc4wp-form .mc4wp-form-fields,
					{{WRAPPER}} .mc4wp-form input[type=text],
					{{WRAPPER}} .mc4wp-form input[type=email],
					{{WRAPPER}} .mc4wp-form input[type=submit]' => 'display: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'form_position',
			[
				'label'                => __( 'Position', 'farmart-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'left'   => [
						'title' => __( 'Left', 'farmart-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'farmart-addons' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'farmart-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors'            => [
					'{{WRAPPER}} .farmart-newletter .mc4wp-form .mc4wp-form-fields' => '{{VALUE}}',
				],
				'selectors_dictionary' => [
					'left'   => 'margin-right: auto; margin-left: 0;',
					'center' => 'margin: 0 auto',
					'right'  => 'margin-left: auto; margin-right: 0;',
				],
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Element in Tab Style
	 *
	 * Field
	 */
	protected function section_field_style() {
		$this->start_controls_section(
			'section_field_style',
			[
				'label' => __( 'Field', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'form_width',
			[
				'label'      => __( 'Width', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
					'%'  => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default'    => [ ],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-newletter .mc4wp-form .mc4wp-form-fields input[type=email]' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'field_text_color',
			[
				'label'     => __( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form input[type=text], {{WRAPPER}} .mc4wp-form input[type=email]' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'field_typography',
				'selector' => '{{WRAPPER}} .mc4wp-form input[type=text], {{WRAPPER}} .mc4wp-form input[type=email]',
			]
		);
		$this->add_responsive_control(
			'field_width',
			[
				'label'      => __( 'Width', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
					'%'  => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default'    => [ ],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .mc4wp-form input[type=text], {{WRAPPER}} .mc4wp-form label' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .mc4wp-form input[type=text], {{WRAPPER}} .mc4wp-form input[type=email]' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'form_display' => 'block',
				],
				'separator' => 'after',
			]
		);
		$this->add_responsive_control(
			'field_spacing',
			[
				'label'      => __( 'Spacing', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 40,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 10,
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .mc4wp-form input[type=text], {{WRAPPER}} .mc4wp-form input[type=email]' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'form_display' => 'block',
				],
			]
		);
		$this->add_control(
			'field_background_color',
			[
				'label'     => __( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form input[type=text], {{WRAPPER}} .mc4wp-form input[type=email]' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .farmart-newletter .mc4wp-form .mc4wp-form-fields label' => 'background-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'field_border_color',
			[
				'label'     => __( 'Border Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form input[type=text], {{WRAPPER}} .mc4wp-form input[type=email]' => 'border-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'field_border_width',
			[
				'label'       => __( 'Border Width', 'farmart-addons' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'placeholder' => '1',
				'size_units'  => [ 'px' ],
				'selectors'   => [
					'{{WRAPPER}} .mc4wp-form input[type=text], {{WRAPPER}} .mc4wp-form input[type=email]' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'field_border_radius',
			[
				'label'      => __( 'Border Radius', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .mc4wp-form input[type=text], {{WRAPPER}} .mc4wp-form input[type=email]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'field_padding',
			[
				'label'      => __( 'Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .mc4wp-form input[type=text], {{WRAPPER}} .mc4wp-form input[type=email]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Element in Tab Style
	 *
	 * Button
	 */
	protected function section_button_style() {
		$this->start_controls_section(
			'section_button_style',
			[
				'label' => __( 'Button', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => __( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form input[type=submit]' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => __( 'Text Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form input[type=submit]' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .mc4wp-form input[type=submit]',
			]
		);
		$this->add_responsive_control(
			'button_width',
			[
				'label'      => __( 'Width', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
					'%'  => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default'    => [ ],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .mc4wp-form input[type=submit]' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'form_display' => 'block',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'     => 'button_border',
				'selector' => '{{WRAPPER}} .elementor-button',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'      => __( 'Border Radius', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .mc4wp-form input[type=submit]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_text_padding',
			[
				'label'      => __( 'Text Padding', 'farmart-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .mc4wp-form input[type=submit]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

		$classes = [
			'farmart-newletter'
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( $settings['form'] ) :
				echo do_shortcode( '[mc4wp_form id="' . esc_attr( $settings['form'] ) . '"]' );
			endif; ?>
		</div>
		<?php
	}

	/**
	 * Get Contact Form
	 */
	protected function get_contact_form() {
		$mail_forms    = get_posts( 'post_type=mc4wp-form&posts_per_page=-1' );
		$mail_form_ids = array(
			'' => esc_html__( 'Select Form', 'farmart-addons' ),
		);
		foreach ( $mail_forms as $form ) {
			$mail_form_ids[$form->ID] = $form->post_title;
		}

		return $mail_form_ids;
	}
}