<?php

if ( ! function_exists( 'farmart_get_the_post_navigation' ) ) :

	/**
	 * @param array $args
	 *
	 * @return string*
	 */

	function farmart_get_the_post_navigation( $args = array() ) {
		$left = sprintf(
			'<span class="box-nav box-nav--left"><span class="nav-before">%s</span><span class="nav">%s %s</span></span>',
			esc_html__( 'Previous Post', 'farmart' ),
			Farmart\Icon::get_svg( 'arrow-left' ),
			'%title'
		);

		$right = sprintf(
			'<span class="box-nav box-nav--right"><span class="nav-before">%s</span><span class="nav">%s %s</span></span>',
			esc_html__( 'Next Post', 'farmart' ),
			'%title',
			Farmart\Icon::get_svg( 'arrow-right' )
		);

		$args = wp_parse_args(
			$args, array(
				'prev_text'          => $left,
				'next_text'          => $right,
				'in_same_term'       => false,
				'excluded_terms'     => '',
				'taxonomy'           => 'category',
				'screen_reader_text' => esc_attr__( 'Post navigation', 'farmart' )
			)
		);

		$navigation = '';

		$previous = get_previous_post_link(
			'%link',
			$args['prev_text'],
			$args['in_same_term'],
			$args['excluded_terms'],
			$args['taxonomy']
		);

		$next = get_next_post_link(
			'%link',
			$args['next_text'],
			$args['in_same_term'],
			$args['excluded_terms'],
			$args['taxonomy']
		);

		if ($previous == '' ){
			$previous = '<div class="none"></div>';
		}

		if ( $next == '' ){
			 $next = '<div class="none"></div>';
		}

		// Only add markup if there's somewhere to navigate to.
		if ( $previous || $next ) {
			$navigation = _navigation_markup( $previous . $next, 'farmart-post--navigation', $args['screen_reader_text'] );
		}

		return $navigation;
	}

endif;

/**
 *
 * post navigation
 *
 */
if ( ! function_exists( 'farmart_the_post_navigation' ) ) :
	function farmart_the_post_navigation( $args = array() ) {

		if ( ! intval( farmart_get_option( 'show_post_navigation' ) ) ) {
			return;
		}

		echo farmart_get_the_post_navigation( $args );
	}
endif;

function farmart_numeric_pagination()
{
	global $wp_query;

	if ($wp_query->max_num_pages < 2) {
		return;
	}

	?>
	<nav class="blog-navigation num-navigation">
		<?php
		$big = 999999999;

		$args = array(
			'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
			'total' => $wp_query->max_num_pages,
			'current' => max(1, get_query_var('paged')),
			'prev_text' => Farmart\Icon::get_svg( 'chevron-left' ),
			'next_text' => Farmart\Icon::get_svg( 'chevron-right' ),
			'prev_next' => true,
			'type' => 'plain',
		);

		echo paginate_links($args);
		?>
	</nav>
	<?php
}

function farmart_load_pagination() {
	global $wp_query;

	if ( $wp_query->max_num_pages < 2 ) {
		return;
	}

	$view = farmart_get_option( 'view_more_text' );
	$ids = 'farmart-posts-load-scroll';
	$id = 'farmart-blog-previous-ajax';

	$type = farmart_get_option( 'navigation_type' );
	$nav_html = sprintf('<span class="button-text"><span class="button-text--after">%s</span></span>',$view);

	if ( $type == 'loading' ):
		$output = sprintf('<div id="%s">%s </div>',esc_attr($ids),$nav_html);
	endif;

	?>
	<nav class="navigation load-navigation">
		<div class="nav-links">
			<?php if ( get_next_posts_link() ) : ?>
				<div id="<?php echo esc_attr( $id ); ?>" class="nav-previous-ajax">
					<?php next_posts_link( $output ); ?>
					<div class="after-loading">
						<div class="farmart-blog-loading">
							<span class="loading-icon">
								<span class="bubble"><span class="dot"></span></span>
								<span class="bubble"><span class="dot"></span></span>
								<span class="bubble"><span class="dot"></span></span>
							</span>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</nav>
	<?php
}
