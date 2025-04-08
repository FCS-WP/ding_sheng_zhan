<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Farmart_Currency_Switch_Widget' ) ) {
	class Farmart_Currency_Switch_Widget extends WP_Widget {
		/**
		 * Holds widget settings defaults, populated in constructor.
		 *
		 * @var array
		 */
		protected $default;

		/**
		 * Instantiate the object.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		function __construct() {
			$this->default = array(
				'title' 		 => '',
			);

			parent::__construct(
				'farmart-currency-widget',
				esc_html__( 'Farmart - Currency Switch', 'farmart-addons' ),
				array(
					'classname'                   => 'farmart-currency-widget topbar-dropdown',
					'description'                 => esc_html__( 'Show currency switch.', 'farmart-addons' ),
					'customize_selective_refresh' => true,
				)
			);
		}

		/**
		 * Outputs the HTML for this widget.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args     An array of standard parameters for widgets in this theme
		 * @param array $instance An array of settings for this widget instance
		 *
		 * @return void Echoes it's output
		 */
		function widget( $args, $instance ) {
			if ( ! class_exists( 'WOOCS' ) ) {
				return;
			}

			$instance = wp_parse_args( $instance, $this->default );

			echo $args['before_widget'];

			if ( $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			global $WOOCS;

			$currencies    = $WOOCS->get_currencies();
			$currency_list = array();

			foreach ( $currencies as $key => $currency ) {
				if ( $WOOCS->current_currency == $key ) {
					array_unshift( $currency_list, sprintf(
						'<li class="%s"><a href="#" class="woocs_flag_view_item woocs_flag_view_item_current" data-currency="%s">%s %s</a></li>',
						$currencies[ $WOOCS->current_currency ]['name'] === $currency['name'] ? 'active' : '',
						esc_attr( $currency['name'] ),
						esc_html( $currency['symbol'] ),
						esc_html( $currency['name'] )
					) );
				} else {
					$currency_list[] = sprintf(
						'<li class="%s"><a href="#" class="woocs_flag_view_item" data-currency="%s">%s %s</a></li>',
						$currencies[ $WOOCS->current_currency ]['name'] === $currency['name'] ? 'active' : '',
						esc_attr( $currency['name'] ),
						esc_html( $currency['symbol'] ),
						esc_html( $currency['name'] )
					);
				}
			}

			$output = sprintf(
				'<div class="dropdown"><span class="current"><span class="selected">%s</span>%s</span><ul>%s</ul></div>',
				esc_html( $currencies[ $WOOCS->current_currency ]['name'] ),
				\Farmart\Icon::get_svg( 'chevron-bottom' ),
				implode( "\n\t", $currency_list )
			);

			?>

			<div class="farmart-currency">
				<?php echo $output; ?>
			</div>
			<?php

			echo $args['after_widget'];
		}

		/**
		 * Displays the form for this widget on the Widgets page of the WP Admin area.
		 *
		 * @since 1.0.0
		 *
		 * @param array $instance
		 *
		 * @return string|void
		 */
		function form( $instance ) {
			$instance = wp_parse_args( $instance, $this->default );
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'farmart-addons' ); ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			</p>
			<?php
		}
	}
}
