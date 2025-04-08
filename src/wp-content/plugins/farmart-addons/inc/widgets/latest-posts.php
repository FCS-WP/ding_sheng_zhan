<?php

class Farmart_Latest_Post_Widget extends WP_Widget {
	/**
	 * Holds widget settings defaults, populated in constructor.
	 *
	 * @var array
	 */
	protected $defaults;

	/**
	 * Class constructor
	 * Set up the widget
	 *
	 * @return Farmart_Latest_Post_Widget
	 */
	function __construct() {
		$this->defaults = array(
			'title'      => '',
			'limit'      => 2,
			'date'       => 1,
			'thumb'      => 1,
			'thumb_size' => 'thumb',
		);

		parent::__construct(
			'latest-posts-widget',
			esc_html__( 'Farmart - Latest Post', 'farmart-addons' ),
			array(
				'classname'   => 'farmart-widget__latest-post',
				'description' => esc_html__( 'Display most latest posts', 'farmart-addons' ),
			)
		);
	}

	/**
	 * Display widget
	 *
	 * @param array $args     Sidebar configuration
	 * @param array $instance Widget settings
	 *
	 * @return void
	 */
	function widget( $args, $instance ) {
		$instance = wp_parse_args( $instance, $this->defaults );
		extract( $args );

		$query_args = array(
			'posts_per_page'      => $instance['limit'],
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
		);

		$query = new WP_Query( $query_args );

		if ( ! $query->have_posts() ) {
			return;
		}

		echo wp_kses_post($before_widget);

		if ( $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) ) {
			echo wp_kses_post($before_title) . $title . wp_kses_post($after_title);
		}

		$class = $instance['thumb'] ? 'has-post-thumbnail' : 'no-thumbnail';
		?>
		<div class="farmart-widget__inner">
		<?php
		while ( $query->have_posts() ) : $query->the_post();
			?>
			<div class="blog-item <?php echo esc_attr( $class ); ?>">
				<div class="blog-wrapper__inner">
					<?php
					if ( has_post_thumbnail() ) {
						printf(
							'<a class="widget-thumb" href="%s" title="%s">%s</a>',
							esc_url(get_permalink()),
							esc_attr(get_the_title()),
							get_the_post_thumbnail( get_the_ID(), 'thumbnail' )
						);
					}
					?>
					<div class="entry-header">
						<div class="entry-meta">
							<?php
							if ( $instance['date'] ) {
								$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

								$time_string = sprintf(
									$time_string,
									esc_attr( get_the_date( 'c' ) ),
									esc_html( get_the_date() )
								);

								$byline = sprintf(
								/* translators: %s: post author. */
									esc_html_x( ' by %s', 'post author', 'farmart-addons' ),
									'<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>'
								);

								printf(
									sprintf( '<div class="meta meta-date">%s%s</div>', $time_string, $byline )
								);
							}
							?>
						</div>
						<h6 class="entry-title"><a href="<?php esc_url(the_permalink()) ?>"><?php the_title() ?></a></h6>
					</div>
				</div>
			</div>
		<?php
		endwhile;
		?>
		</div>
		<?php
		wp_reset_postdata();

		echo wp_kses_post($after_widget);

	}

	/**
	 * Update widget
	 *
	 * @param array $new_instance New widget settings
	 * @param array $old_instance Old widget settings
	 *
	 * @return array
	 */
	function update( $new_instance, $old_instance ) {
		$new_instance['title']     = strip_tags( $new_instance['title'] );
		$new_instance['limit']     = intval( $new_instance['limit'] );
		$new_instance['thumb']     = ! empty( $new_instance['thumb'] );
		$new_instance['date']      = ! empty( $new_instance['date'] );

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

		<p>
			<input id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" type="text" size="2" value="<?php echo intval( $instance['limit'] ); ?>">
			<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php esc_html_e( 'Number Of Posts', 'farmart-addons' ); ?></label>
		</p>


		<p>
			<input id="<?php echo esc_attr( $this->get_field_id( 'date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'date' ) ); ?>" type="checkbox" value="1" <?php checked( $instance['date'] ); ?>>
			<label for="<?php echo esc_attr( $this->get_field_id( 'date' ) ); ?>"><?php esc_html_e( 'Show Date', 'farmart-addons' ); ?></label>
		</p>

		<p>
			<input id="<?php echo esc_attr( $this->get_field_id( 'thumb' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'thumb' ) ); ?>" type="checkbox" value="1" <?php checked( $instance['thumb'] ); ?>>
			<label for="<?php echo esc_attr( $this->get_field_id( 'thumb' ) ); ?>"><?php esc_html_e( 'Show Thumbnail', 'farmart-addons' ); ?></label>
		</p>

		<?php
	}

}