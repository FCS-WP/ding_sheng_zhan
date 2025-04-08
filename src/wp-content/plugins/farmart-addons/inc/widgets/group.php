<?php

class Farmart_Group_Widget extends WP_Widget {
	protected $defaults;

	function __construct() {
		$this->defaults = array(
			'title'   => '',
			'sidebar' => '',
		);

		parent::__construct(
			'farmart-group-widget',
			esc_html__( 'Farmart - Group Widget', 'farmart-addons' ),
			array(
				'classname'   => 'farmart-group-widget',
				'description' => esc_html__( 'Display Widgets in a Sidebar', 'farmart-addons' ),
			)
		);
	}

	/**
	 * Outputs the HTML for this widget.
	 *
	 * @param array $args     An array of standard parameters for widgets in this theme
	 * @param array $instance An array of settings for this widget instance
	 *
	 * @return void Echoes it's output
	 */
	function widget( $args, $instance ) {
		$instance = wp_parse_args( $instance, $this->defaults );

		if ( $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) ) {
			echo $before_title . $title . $after_title;
		}

		if ( empty( $instance['sidebar'] ) ) {
			return;
		}

		echo '<div class="farmart-group-widget">';

		if ( is_active_sidebar( $instance['sidebar'] ) ) {
			dynamic_sidebar( $instance['sidebar'] );
		}

		echo '</div>';
	}

	/**
	 * Deals with the settings when they are saved by the admin.
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 */
	function update( $new_instance, $old_instance ) {
		$instance            = array();
		$instance['title']   = strip_tags( $new_instance['title'] );
		$instance['sidebar'] = sanitize_text_field( $new_instance['sidebar'] );

		return $instance;
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 *
	 * @param array $instance
	 *
	 * @return array
	 */
	function form( $instance ) {
		$instance        = wp_parse_args( $instance, $this->defaults );
		$current_sidebar = sanitize_title( $instance['sidebar'] );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'farmart-addons' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'sidebar' ) ); ?>"><?php esc_html_e( 'Sidebar', 'farmart-addons' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'sidebar' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'sidebar' ) ); ?>" class="widefat">
				<option value="" <?php echo ( '' == $current_sidebar ) ? 'selected' : '' ?>><?php esc_html_e( 'Choose Sidebar', 'farmart-addons' ); ?></option>
				<?php foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) { ?>
					<option value="<?php echo $sidebar['id']; ?>" <?php echo ( $sidebar['id'] == $current_sidebar ) ? 'selected' : '' ?>>
						<?php echo ucwords( $sidebar['name'] ); ?>
					</option>
				<?php } ?>
			</select>
		</p>
		<?php
	}
}
