<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Farmart_Language_Switcher_Widget' ) ) {

	class Farmart_Language_Switcher_Widget extends WP_Widget {
		/**
		 * Holds widget default settings, populated in constructor.
		 *
		 * @var array
		 */
		protected $defaults;

		/**
		 * Constructor
		 *
		 * @return Farmart_Language_Switcher_Widget
		 */
		function __construct() {
			$this->defaults = array(
				'title'     => '',
			);

			parent::__construct(
				'farmart-languages-widget',
				esc_html__( 'Farmart - Language Switcher', 'farmart-addons' ),
				array(
					'classname'   => 'farmart-languages-widget topbar-dropdown',
					'description' => esc_html__( 'Display Language switcher', 'farmart-addons' ),
				)
			);
		}

		/**
		 * Outputs the HTML for this widget.
		 *
		 * @param array $args     An array of standard parameters for widgets in this theme
		 * @param array $instance An array of settings for this widget instance
		 */
		function widget( $args, $instance ) {
			$instance = wp_parse_args( $instance, $this->defaults );
			extract( $args );
			$languages = function_exists( 'icl_get_languages' ) ? icl_get_languages() : array();
			$languages = apply_filters( 'wpml_active_languages', $languages, 'skip_missing=0' );

			if ( empty( $languages ) ) {
				return;
			}

			echo $before_widget;

			if ( $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) ) {
				echo $before_title . $title . $after_title;
			}

			$lang_list = array();
			$current   = '';

			foreach ( (array) $languages as $code => $language ) {
				$context = '<img src="' . esc_url( $language['country_flag_url'] ) . '" alt="' . esc_attr( $language['native_name'] ) . '">' . esc_html( $language['native_name'] );

				if ( ! $language['active'] ) {
					$lang_list[] = sprintf(
						'<li class="%s"><a href="%s">%s</a></li>',
						esc_attr( $code ),
						esc_url( $language['url'] ),
						$context
					);
				} else {
					$current = $context;
					array_unshift(
						$lang_list, sprintf(
						'<li class="%s"><a href="%s">%s</a></li>',
						esc_attr( $code ),
						esc_url( $language['url'] ),
						$context
					)
					);
				}
			}
			?>

			<div class="language list-dropdown">
				<span class="current"><?php echo wp_kses_post( $current ); ?><?php echo Farmart\Icon::get_svg('chevron-bottom') ?></span>
				<ul>
					<?php echo implode( "\n\t", $lang_list ); ?>
				</ul>
			</div>

			<?php

			echo $after_widget;
		}

		/**
		 * Handles updating settings for the current Custom Menu widget instance.
		 *
		 * @param array $new_instance New settings for this instance as input by the user via WP_Widget::form().
		 * @param array $old_instance Old settings for this instance.
		 *
		 * @return array Updated settings to save.
		 */
		function update( $new_instance, $old_instance ) {
			$new_instance['title']     = sanitize_text_field( $new_instance['title'] );

			return $new_instance;
		}

		/**
		 * Display widget settings
		 *
		 * @param array $instance Widget settings
		 *
		 * @return void
		 */
		function form( $instance ) {
			$instance = wp_parse_args( $instance, $this->defaults );
			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'farmart-addons' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
			</p>

			<?php
		}
	}
}