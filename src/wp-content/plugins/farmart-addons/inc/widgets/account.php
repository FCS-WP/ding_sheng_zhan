<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Farmart_Account_Widget' ) ) {
	class Farmart_Account_Widget extends WP_Widget {
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
				'farmart-account-widget',
				esc_html__( 'Farmart - Account', 'farmart-addons' ),
				array(
					'classname'                   => 'farmart-account-widget topbar-dropdown',
					'description'                 => esc_html__( 'Show account widget.', 'farmart-addons' ),
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
			$instance = wp_parse_args( $instance, $this->default );

			echo $args['before_widget'];

			if ( $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			$html = '';

			if ( is_user_logged_in() ) {
				$user_id   = get_current_user_id();
				$author       = get_user_by( 'id', $user_id );
				$link = array();

				foreach ( wc_get_account_menu_items() as $endpoint => $label ) {
					$link[] = sprintf(
						'<li class="account-link--%s">
						<a href="%s">%s</a>
						</li>',
						esc_attr( $endpoint ),
						esc_url( wc_get_account_endpoint_url( $endpoint ) ),
						esc_html( $label )
					);
				}

				$html = sprintf(
					'<a href="%s">%s <b>%s</b></a>
					<ul class="account-links">%s</ul>',
					esc_url( wc_get_account_endpoint_url( 'dashboard' ) ),
					esc_html__( 'Hello !', 'farmart-addons' ),
					$author->display_name,
					implode( "\n\t", $link )
				);
			} else {
				$html = sprintf(
					'<a href="%s">%s %s</a>',
					esc_url( wc_get_account_endpoint_url( 'dashboard' ) ),
					\Farmart\Icon::get_svg( 'user', '', 'shop' ),
					esc_html__( 'Login or Register', 'farmart-addons' )
				);
			}

			echo $html;

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
