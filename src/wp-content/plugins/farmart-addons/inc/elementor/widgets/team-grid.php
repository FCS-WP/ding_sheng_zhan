<?php

namespace FarmartAddons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use FarmartAddons\Elementor;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Team Grid widget
 */
class Team_Grid extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'farmart-team-grid';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Farmart - Team Grid', 'farmart-addons' );
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

	protected function section_content() {
		$this->section_setting_content();
	}

	protected function section_setting_content( ) {
		$this->start_controls_section(
			'section_content',
			[ 'label' => esc_html__( 'Content', 'farmart-addons' ) ]
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
			'image',
			[
				'label'   => esc_html__( 'Image', 'farmart-addons' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/150x150/f5f5f5?text=150x150',
				],
			]
		);

		$this->add_control(
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

		$this->add_control(
			'name',
			[
				'label'       => esc_html__( 'Name', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Member\'s Name', 'farmart-addons' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'job',
			[
				'label'       => esc_html__( 'Job', 'farmart-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Member\'s Job', 'farmart-addons' ),
				'label_block' => true,
			]
		);

		$icon = new \Elementor\Repeater();
		$icon->add_control(
			'icon',
			[
				'label'   => esc_html__( 'Icon', 'farmart-addons' ),
				'type'    => Controls_Manager::ICONS,
				'default'          => [
					'value'   => 'social_facebook',
					'library' => 'eleganticons',
				],
			]
		);
		$icon->add_control(
			'link_icon', [
				'label'         => esc_html__( 'Link', 'farmart-addons' ),
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

		$this->add_control(
			'socials',
			[
				'label'         => esc_html__( 'Socials', 'farmart-addons' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $icon->get_controls(),
				'default'       => [
					[
						'icon'  => [
							'value'   => 'social_facebook',
						],
						'link_icon'       => [
							'url'         => '#',
							'is_external' => false,
							'nofollow'    => false,
						],
					],
					[
						'icon'  => [
							'value'   => 'social_twitter',
						],
						'link_icon'       => [
							'url'         => '#',
							'is_external' => false,
							'nofollow'    => false,
						],
					],
					[
						'icon'  => [
							'value'   => 'social_googleplus',
						],
						'link_icon'       => [
							'url'         => '#',
							'is_external' => false,
							'nofollow'    => false,
						],
					],[
						'icon'  => [
							'value'   => 'social_youtube',
						],
						'link_icon'       => [
							'url'         => '#',
							'is_external' => false,
							'nofollow'    => false,
						],
					]
				],
				'prevent_empty' => false
			]
		);

		$this->end_controls_section();
	}

	// Style
	protected function section_style() {
		$this->section_content_style();
		$this->section_element_style();
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
			'position',
			[
				'label'     => esc_html__( 'Align', 'farmart-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'farmart-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'' => [
						'title' => esc_html__( 'Center', 'farmart-addons' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'farmart-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-team-grid' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'padding',
			[
				'label' => esc_html__( 'Padding ', 'farmart-addons' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => ['px','%','em' ],
				'selectors'  => [
					'{{WRAPPER}} .farmart-team-grid__inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .farmart-team-grid .member-socials' => 'padding-left: {{LEFT}}{{UNIT}};padding-right: {{RIGHT}}{{UNIT}};'
				]
			]
		);

		$this->add_control(
			'content_border_style',
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
					'{{WRAPPER}} .farmart-team-grid__inner' => 'border-style: {{VALUE}};',
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
					'{{WRAPPER}} .farmart-team-grid__inner' => 'border-color: {{VALUE}}',

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
					'{{WRAPPER}} .farmart-team-grid__inner' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_popover();

		$this->add_control(
			'bk_color',
			[
				'label'     => __( 'Background Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-team-grid__inner'     => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .farmart-team-grid:hover'     => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'hover_content',
			[
				'label' => esc_html__( 'Hover Content', 'farmart-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'label'         => esc_html__( 'Shadow', 'farmart-addons' ),
				'name'          => 'item_shadow',
				'selector'      => '{{WRAPPER}} .farmart-team-grid:hover',
			]
		);

		$this->add_control(
			'name_hover_color',
			[
				'label'     => __( 'Name Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-team-grid:hover .name a,{{WRAPPER}} .farmart-team-grid:hover .name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function section_element_style() {
		$this->start_controls_section(
			'section_element_style',
			[
				'label' => esc_html__( 'Elements', 'farmart-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'img_style',
			[
				'label' => esc_html__( 'Image', 'farmart-addons' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'img_style_setting',
			[
				'label'        => __( 'Setting', 'farmart-addons' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'farmart-addons' ),
				'label_on'     => __( 'Custom', 'farmart-addons' ),
				'return_value' => 'yes',
			]
		);
		$this->start_popover();

		$this->add_control(
			'img_width',
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
					'{{WRAPPER}} .farmart-team-grid .image img' => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'img_height',
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
					'{{WRAPPER}} .farmart-team-grid .image img' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'img_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range'      => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .farmart-team-grid .image img' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_popover();



		$this->add_control(
			'text_style',
			[
				'label' => esc_html__( 'Text', 'farmart-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);

		$this->start_controls_tabs('content_subtext');

		$this->start_controls_tab(
			'content_text_name',
			[
				'label'         => esc_html__( 'Name', 'farmart-addons' ),
			]
		);

		$this->add_responsive_control(
			'sub_spacing',
			[
				'label'      => __( 'Spacing', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [],
				'selectors'  => [
					'{{WRAPPER}} .farmart-team-grid .name' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'style_sub_typography',
				'selector' => '{{WRAPPER}} .farmart-team-grid .name',
			]
		);

		$this->add_control(
			'sub_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-team-grid .name, {{WRAPPER}} .farmart-team-grid .name a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'content_text_job',
			[
				'label'         => esc_html__( 'Job', 'farmart-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'style_heading_typography',
				'selector' => '{{WRAPPER}} .farmart-team-grid .job',
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => __( 'Color', 'farmart-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .farmart-team-grid .job'  => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'icon_style',
			[
				'label' => esc_html__( 'Socials', 'farmart-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'icon_style_setting',
			[
				'label'        => __( 'Setting', 'farmart-addons' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'farmart-addons' ),
				'label_on'     => __( 'Custom', 'farmart-addons' ),
				'return_value' => 'yes',
			]
		);
		$this->start_popover();

		$this->add_responsive_control(
			'icon_spacing',
			[
				'label'      => __( 'Spacing', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [],
				'selectors'  => [
					'{{WRAPPER}} .farmart-team-grid .farmart-svg-icon' => 'margin: 0 {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'      => __( 'Font Size', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'default'    => [],
				'selectors'  => [
					'{{WRAPPER}} .farmart-team-grid .farmart-svg-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'hori_position',
			[
				'label'      => __( 'Horizontal', 'farmart-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range'      => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [],
				'selectors'  => [
					'{{WRAPPER}} .farmart-team-grid .member-socials' => 'transform: translateY( -{{SIZE}}{{UNIT}});',
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
					'{{WRAPPER}} .farmart-team-grid .farmart-svg-icon'  => 'color: {{VALUE}};',
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
				'farmart-team-grid',
			]
		);

		$output = [ ];
		$els = $settings['socials'];

		$image = Group_Control_Image_Size::get_attachment_image_html( $settings );

		if ( $settings['link']['url'] ) :
			$image = $this->get_link_control( 'link', $settings['link'], $image, [ 'class' => 'has-link' ] );
		endif;
		$output = [];

		$output[] =  '<div class="image">'.$image.'</div>';
		if ( $settings['name'] ) {
			$output[] = sprintf( '<h6 class="name">%s</h6>', $this->get_link_control( 'link-2', $settings['link'], $settings['name'], '' ) );
		}

		if ( $settings['job'] ) {
			$output[] = sprintf( '<div class="job">%s</div>', $settings['job'] );
		}

		if ( ! empty ( $els ) ) {

			$socials_html[] = '<div class="member-socials">';
			foreach ( $els as $index => $item ) {
				$link_key = 'link_' . $index;
				$icon     = '';
				if ( $item['icon'] ) {
					if ( $item['icon'] && \Elementor\Icons_Manager::is_migration_allowed() ) {
						ob_start();
						\Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] );
						$icon = '<span class="farmart-svg-icon">' . ob_get_clean() . '</span>';
					}
				}

				$link = $item['link_icon'] ? $this->get_link_control( $link_key, $item['link_icon'], $icon, ['class' => 'has-link' ] ) : $icon;

				$socials_html[] = sprintf( '%s', $link );
			}
			$socials_html[] = '</div>';
		}

		?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
	        <div class="farmart-team-grid__inner">
		        <?php echo implode( '', $output ) ?>
	        </div>
	        <?php echo implode( '', $socials_html ) ?>
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