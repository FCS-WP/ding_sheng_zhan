<?php
/**
 * The template part for displaying related posts
 *
 * @package Sober
 */

// Only support posts
if ( 'post' != get_post_type() ) {
	return;
}

$related_posts_show    = get_post_meta( get_the_ID(), 'hide_related_posts', true );
$related_posts_title   = get_post_meta( get_the_ID(), 'related_posts_title', true );
$related_posts_numbers = get_post_meta( get_the_ID(), 'related_posts_numbers', true );
$related_posts_columns = get_post_meta( get_the_ID(), 'related_posts_columns', true );

$titles = farmart_get_option( 'related_posts_title' );

if ( ! intval( farmart_get_option( 'related_posts' ) ) ) {
	return;
}

if ( $related_posts_show == 1 ) {
	return;
}

if ( empty( $related_posts_title ) ) {
	$related_posts_title = $titles;
}

if ( empty( $related_posts_numbers ) ) {
	$related_posts_numbers = farmart_get_option( 'related_posts_numbers' );
}

if ( empty( $related_posts_columns ) ) {
	$related_posts_columns = farmart_get_option( 'related_posts_columns' );
}

global $post;

$args          = array(
	'post_type'           => 'post',
	'posts_per_page'      => $related_posts_numbers,
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'order'               => 'rand',
	'post__not_in'        => array( $post->ID ),
	'tax_query'           => array(
		'relation' => 'OR',
		array(
			'taxonomy' => 'category',
			'field'    => 'term_id',
			'terms'    => farmart_get_related_terms( 'category', $post->ID ),
			'operator' => 'IN',
		),
		array(
			'taxonomy' => 'post_tag',
			'field'    => 'term_id',
			'terms'    => farmart_get_related_terms( 'post_tag', $post->ID ),
			'operator' => 'IN',
		),
	),
);
$related_posts = new WP_Query( $args );

$carousel_settings = array(
	'slidesToShow'   => intval( $related_posts_columns ),
	'slidesToScroll' => 1,
	'arrows'         => true,
	'dots'           => true,
	'infinite'       => false,
	'responsive'     => array(
		array(
			'breakpoint' => 1200,
			'settings'   => array(
				'slidesToShow'   => $related_posts_columns < 2 ? $related_posts_columns : 2,
				'slidesToScroll' => 1,
			)
		),
		array(
			'breakpoint' => 480,
			'settings'   => array(
				'slidesToShow'   => 1,
				'slidesToScroll' => 1,
			)
		)
	)
);

if ( ! $related_posts->have_posts() ) {
	return;
}
?>
    <div class="farmart-post__related">
        <div class="heading">
			<?php
			if ( ! empty( $titles ) && ! empty( $related_posts_title ) ) {
				echo sprintf( '<h3 class="related-title">%s</h3>', $related_posts_title );
			}
			?>
        </div>
        <div class="list-post--wrapper">
            <div class="list-post row-flex" data-slick="<?php echo esc_attr( wp_json_encode( $carousel_settings ) ) ?>">
				<?php
				while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>
					<?php
					$size = 'farmart-blog-grid';

					$classes = 'blog-wrapper';

					$post_format       = get_post_format();
					$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
					$thumb             = farmart_get_image_html( $post_thumbnail_id, $size );
					$symbol            = $thumb_html = '';

					if ( ! has_post_thumbnail() ) {
						$classes .= ' no-thumb';
					}

					$add_class = '';
					$url       = get_permalink();

					switch ( $post_format ) {
						case 'video':
							$add_class = 'popup-video';
							$url       = get_post_meta( get_the_ID(), 'video', true );

							$symbol = get_template_directory_uri() . '/images/play-icon.png';
							$symbol = '<span class="post-format-icon"><img src="' . esc_url( $symbol ) . '" alt =""/></span>';
							break;
						case 'audio':
							$symbol = '<span class="post-format-icon">'. Farmart\Icon::get_svg( 'music-note' ) .'</span>';
							break;
						case 'link':
							$symbol = '<span class="post-format-icon">'. Farmart\Icon::get_svg( 'link' ) .'</span>';
							break;
						case 'quote':
							$symbol = '<span class="post-format-icon">'. Farmart\Icon::get_svg( 'quote-open' ) .'</span>';
							break;
						default:
							break;
					}
					?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
                        <div class="blog-inner">
							<?php
							if ( $thumb ) {
								printf(
									'<div class="entry-format format-%s"><a class="entry-image %s" href="%s">%s%s</a></div>',
									esc_attr( $post_format ),
									$add_class,
									esc_url( $url ),
									$symbol,
									$thumb
								);
							}
							?>
                            <div class="entry-header">
								<?php farmart_blog_meta( $date = false ); ?>
								<?php the_title( '<h5 class="entry-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h5>' ); ?>
                            </div>
                            <div class="entry-content">
                                <div class="entry-excerpt"><?php echo farmart_content_limit( 20, '' ); ?></div>
                            </div>
                        </div>
                    </article><!-- #post-<?php the_ID(); ?> -->
				<?php endwhile; ?>
            </div>
        </div>
    </div>
<?php
wp_reset_postdata();