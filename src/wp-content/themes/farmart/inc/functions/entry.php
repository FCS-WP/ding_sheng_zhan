<?php
/**
 * Custom functions for post
 *
 * @package Farmart
 */

if ( ! function_exists( 'wp_body_open' ) ) {

	/**
	 * Shim for wp_body_open, ensuring backward compatibility with versions of WordPress older than 5.2.
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

if ( ! function_exists( 'farmart_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function farmart_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
		/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'farmart' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'farmart_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function farmart_posted_by() {
		$byline = sprintf(
		/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'farmart' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'farmart_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function farmart_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'farmart' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'farmart' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'farmart' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'farmart' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
					/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'farmart' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'farmart' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'farmart_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function farmart_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

            <div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
            </div><!-- .post-thumbnail -->

		<?php else : ?>

            <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
				the_post_thumbnail( 'post-thumbnail', array(
					'alt' => the_title_attribute( array(
						'echo' => false,
					) ),
				) );
				?>
            </a>

		<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'farmart_meta_cat' ) ) :
	function farmart_meta_cat() {
		$cats  = get_the_category();
		$count = count( $cats );

		$i      = 0;
		$number = apply_filters( 'farmart_meta_cat_number', 1 );

		$cat_html = '';
		$output   = array();

		if ( ! is_wp_error( $cats ) && $cats ) {
			foreach ( $cats as $cat ) {
				$output[] = sprintf( '<a href="%s">%s</a>', esc_url( get_category_link( $cat->term_id ) ), esc_html( $cat->cat_name ) );

				$i ++;

				if ( $i > $number || $i > ( $count - 1 ) ) {
					break;
				}

				$output[] = ', ';
			}

			$cat_html = sprintf( '<div class="meta meta-cat">%s%s</div>', esc_html__('in ', 'farmart') , implode( '', $output ) );
		}

		return $cat_html;
	}
endif;

if ( ! function_exists( 'farmart_meta_date' ) ) :
	function farmart_meta_date() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);

		return sprintf( '<div class="meta meta-date">%s%s</div>', esc_html__('on ', 'farmart'), $time_string );
	}
endif;

if ( ! function_exists( 'farmart_meta_author' ) ) :
	function farmart_meta_author() {

		$byline = sprintf(
		/* translators: %s: post author. */
			esc_html_x( 'By %s', 'post author', 'farmart' ),
			'<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>'
		);

		return sprintf( '<div class="meta meta-author">%s</div>', $byline );
	}
endif;

if ( ! function_exists( 'farmart_meta_social' ) ) :
	function farmart_meta_social() {
		if ( is_search() ) {
			return;
		}

		$socials = farmart_get_option( 'post_socials_share' );

		if ( function_exists( 'farmart_addons_share_link_socials' ) && ( ! empty( $socials ) ) ) {
			return sprintf( '<div class="single-post-socials-share">%s</div>', farmart_addons_share_link_socials( $socials, get_the_title(), get_the_permalink(), get_the_post_thumbnail() ) );
		};
	}
endif;

if ( ! function_exists( 'farmart_meta_comment' ) ) :
	function farmart_meta_comment() {
		$number          = get_comments_number();
		$text_after      = $number == 1 ? esc_html__( 'comment', 'farmart' ) : esc_html__( 'comments', 'farmart' );
		$text_after_html = sprintf( '<span class="text-after">%s</span>', $text_after );

		if ( farmart_is_blog() ) {
			$text_after_html = '';
		}

		return sprintf( '<div class="meta meta-comment">%s %s %s</div>', Farmart\Icon::get_svg( 'bubbles' ), number_format_i18n( $number ), $text_after_html );
	}
endif;

if ( ! function_exists( 'farmart_blog_meta' ) ) :
	function farmart_blog_meta( $date = true ) {
		$metas = (array) farmart_get_option( 'post_entry_meta' );

		if ( farmart_is_blog() ) {
			$metas = (array) farmart_get_option( 'blog_entry_meta' );
		}

		$meta_html = $social = '';

		foreach ( $metas as $meta ) {
			switch ( $meta ) {
				case 'cat' :
					$meta_html .= farmart_meta_cat();

					break;
				case 'comment' :
					$meta_html .= farmart_meta_comment();

					break;
				case 'date' :
					if ( $date == false ) {
						break;
					}

					$meta_html .= farmart_meta_date();

					break;
				case 'author' :
					if ( $date == false ) {
						break;
					}

					$meta_html .= farmart_meta_author();

					break;
				case 'social' :
					if ( $date == false ) {
						break;
					}

					$social = farmart_meta_social();

					break;
				default :
			}
		}

		echo '<div class="single-header"><div class="entry-meta">' . $meta_html . '</div>' . $social . '</div>';
	}
endif;

if ( ! function_exists( 'farmart_post_format_video' ) ) :
	function farmart_post_format_video() {
		$video = get_post_meta( get_the_ID(), 'video', true );

		if ( ! $video ) {
			return;
		}
		$video_html = '';
		// If URL: show oEmbed HTML
		if ( filter_var( $video, FILTER_VALIDATE_URL ) ) {
			if ( $oembed = @wp_oembed_get( $video, array( 'width' => 1170, 'height' => 500 ) ) ) {
				$video_html = $oembed;
			} else {
				$atts = array(
					'src'    => $video,
					'width'  => 1170,
					'height' => 500,
				);

				if ( has_post_thumbnail() ) {
					$atts['poster'] = get_the_post_thumbnail_url( get_the_ID(), 'full' );
				}
				$video_html = wp_video_shortcode( $atts );
			}
		} // If embed code: just display
		else {
			$video_html = $video;
		}

		return $video_html;

	}
endif;

/**
 * Get post format audio
 *
 * @since  1.0
 */

if ( ! function_exists( 'farmart_post_format_audio' ) ) :
	function farmart_post_format_audio() {
		$audio = get_post_meta( get_the_ID(), 'audio', true );
		if ( ! $audio ) {
			return;
		}

		$html = '';

		// If URL: show oEmbed HTML or jPlayer
		if ( filter_var( $audio, FILTER_VALIDATE_URL ) ) {
			// Try oEmbed first
			if ( $oembed = @wp_oembed_get( $audio ) ) {
				$html .= $oembed;
			} // Use audio shortcode
			else {
				$html .= '<div class="audio-player">' . wp_audio_shortcode( array( 'src' => $audio ) ) . '</div>';
			}
		} // If embed code: just display
		else {
			$html .= $audio;
		}

		return $html;
	}
endif;

if ( ! function_exists( 'farmart_post_format_quote' ) ) :
	function farmart_post_format_quote() {
		$quote             = get_post_meta( get_the_ID(), 'quote', true );
		$author            = get_post_meta( get_the_ID(), 'quote_author', true );
		$author_url        = get_post_meta( get_the_ID(), 'author_url', true );
		$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );

		$img_html = farmart_get_image_html( $post_thumbnail_id, 'full' );

		if ( ! $quote ) {
			return;
		}

		return sprintf(
			'<blockquote>%s <div class="box-content">%s<cite>&#45; %s</cite></div></blockquote>',
			$img_html,
			esc_html( $quote ),
			empty( $author_url ) ? $author : '<a href="' . esc_url( $author_url ) . '">' . $author . '</a>'
		);
	}
endif;

function farmart_get_image_html( $post_thumbnail_id, $image_size, $css_class = '', $attributes = false ) {
	$output = '';
	if ( intval( farmart_get_option( 'lazyload' ) ) ) {
		$alt   = trim( strip_tags( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) ) );
		$image = wp_get_attachment_image_src( $post_thumbnail_id, $image_size );

		if ( $image ) {
			$image_trans = get_template_directory_uri() . '/images/transparent.png';

			if ( $attributes ) {
				$full_size_image = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
				$output          = sprintf(
					'<img src="%s" data-original="%s"  alt="%s" class="lazy %s" data-large_image="%s" data-large_image_width="%s" data-large_image_height="%s">',
					esc_url( $image_trans ),
					esc_url( $image[0] ),
					esc_attr( $alt ),
					esc_attr( $css_class ),
					esc_attr( $full_size_image[0] ),
					esc_attr( $attributes['data-large_image_width'] ),
					esc_attr( $attributes['data-large_image_height'] )
				);
			} else {
				$output = sprintf(
					'<img src="%s" data-original="%s"  alt="%s" class="lazy %s" width="%s" height="%s">',
					esc_url( $image_trans ),
					esc_url( $image[0] ),
					esc_attr( $alt ),
					esc_attr( $css_class ),
					esc_attr( $image[1] ),
					esc_attr( $image[2] )
				);
			}

		}
	} else {
		if ( $css_class ) {
			$attributes['class'] = $css_class;
		}

		$output              = wp_get_attachment_image( $post_thumbnail_id, $image_size, false, $attributes );
	}

	return $output;
}

if ( ! function_exists( 'farmart_post_format_gallery' ) ) :
	function farmart_post_format_gallery( $size, $dot = true, $arrow = false ) {
		$image_ids = get_post_meta( get_the_ID(), 'images', false );

		if ( farmart_is_blog() ) {
			$blog_view = farmart_get_option( 'blog_view' );
			if ( $blog_view == 'small-thumb' ) {
				$dot   = true;
				$arrow = false;
			} elseif ( $blog_view == 'list' || $blog_view == 'grid' || $blog_view == 'default' ) {
				$dot   = true;
				$arrow = true;
			}
		}

		$carousel_settings = array(
			'arrows'     => $arrow,
			'dots'       => $dot,
			'infinite'   => false,
			'responsive' => array(
				array(
					'breakpoint' => 1200,
					'settings'   => array(
						'arrows' => false,
						'dots'   => true,
					)
				),
			)
		);

		$carousel_settings = apply_filters( 'farmart_post_format_gallery_settings', $carousel_settings );

		if ( empty( $image_ids ) ) {
			$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );

			if ( is_single() ) {
				return farmart_get_image_html( $post_thumbnail_id, $size );
			} else {
				return '<a class="entry-image" href="' . get_permalink() . '">' . farmart_get_image_html( $post_thumbnail_id, $size ) . '</a>';
			}
		} else {
			$gallery = array();
			foreach ( $image_ids as $id ) {
				$image = farmart_get_image_html( $id, $size );
				if ( $image ) {
					if ( is_single() ) {
						$gallery[] = '<li>' . $image . '</li>';
					} else {
						$gallery[] = '<li><a class="entry-image" href="' . get_permalink() . '">' . $image . '</a></li>';
					}
				}
			}

			return '<ul class="slides" data-slick="' . esc_attr( wp_json_encode( $carousel_settings ) ) . '">' . implode( '', $gallery ) . '</ul>';
		}

	}
endif;

if ( ! function_exists( 'entry-image' ) ) :
	function farmart_post_format_image( $size ) {
		$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
		$thumb             = farmart_get_image_html( $post_thumbnail_id, $size );
		$symbol            = '';
		$post_format       = get_post_format();
		$add_class         = '';
		$url               = get_permalink();

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

			default:
				break;
		}

		if ( empty( $thumb ) ) {
			return;
		}

		if ( is_single() ) {
			return $thumb;
		} else {
			return '<a class="entry-image ' . $add_class . '" href="' . $url . '">' . $symbol . $thumb . '</a>';
		}
	}
endif;

/**
 * Get post format link
 *
 * @since  1.0
 */

if ( ! function_exists( 'farmart_post_format_link' ) ) :
	function farmart_post_format_link() {
		$title = get_post_meta( get_the_ID(), 'title', true );
		$desc  = get_post_meta( get_the_ID(), 'desc', true );
		$link  = get_post_meta( get_the_ID(), 'url', true );
		$text  = get_post_meta( get_the_ID(), 'url_text', true );

		if ( ! $link ) {
			return;
		}

		if ( $title ) {
			$title = sprintf( '<h3 class="title">%s</h3>', $title );
		}

		$link_html = sprintf( '<a href="%s" class="link-block">%s</a>', esc_url( $link ), $text ? $text : $link );

		$box_text = sprintf( '<div class="box-text"><p class="desc">%s </p> %s</div>', $desc, $link_html );

		return sprintf( '%s%s', $title, $box_text );
	}
endif;

function farmart_get_type_postformat( $post_format, $size ) {

	switch ( $post_format ) {
		case 'gallery':
			$html = farmart_post_format_gallery( $size );
			break;
		case 'audio':
			$html = farmart_post_format_audio();
			break;

		case 'video':
			$html = farmart_post_format_video();
			break;

		case 'link':
			$html = farmart_post_format_link();
			break;

		case 'quote':
			$html = farmart_post_format_quote();
			break;

		default:
			$html = farmart_post_format_image( $size );
			break;
	}

	return $html;
}

if ( ! function_exists( 'farmart_post_format' ) ) :
	function farmart_post_format( $size, $class = false ) {
		$post_format = get_post_format();
		$blog_view   = farmart_get_option( 'blog_view' );

		$post_format = $post_format ? $post_format : 'image';
		$css_class   = 'format-' . $post_format;

		if ( $class == true ) {
			$css_class .= ' fm-post-format';
		}

		if ( farmart_is_blog() ) {
			if ( $blog_view == 'default' || $blog_view == 'grid' ) {
				if ( $post_format == 'quote' ) {
					$html = farmart_post_format_quote();
				} elseif ( $post_format == 'gallery' ) {
					$html = farmart_post_format_gallery( $size );
				} else {
					$html = farmart_post_format_image( $size );
				}
			} elseif ( $blog_view == 'small-thumb' ) {
				if ( $post_format == 'quote' ) {
					$html = farmart_post_format_quote();
				} elseif ( $post_format == 'gallery' ) {
					$html = farmart_post_format_gallery( $size );
				} elseif ( $post_format == 'audio' ) {
					$html = farmart_post_format_audio();
				} else {
					$html = farmart_post_format_image( $size );
				}
			} elseif ( $blog_view == 'list' ) {
				$html = farmart_get_type_postformat( $post_format, $size );

			} else {
				if ( $post_format == 'quote' ) {
					$html = farmart_post_format_quote();
				} elseif ( $post_format == 'gallery' ) {
					$html = farmart_post_format_gallery( $size );
				} elseif ( $post_format == 'audio' ) {
					$html = farmart_post_format_audio();
				} elseif ( $post_format == 'video' ) {
					$html = farmart_post_format_video();
				} else {
					$html = farmart_post_format_image( $size );
				}
			}

		} elseif ( is_singular( 'post' ) ) {
			$html = farmart_get_type_postformat( $post_format, $size );

		} else {
			if ( $post_format == 'quote' ) {
				$html = farmart_post_format_quote();
			} elseif ( $post_format == 'gallery' ) {
				$html = farmart_post_format_gallery( $size );
			} else {
				$html = farmart_post_format_image( $size );
			}
		}

		if ( empty( $html ) ) {
			return;
		}

		echo "<div class='entry-format $css_class'>$html</div>";


	}
endif;


function farmart_content_limit( $num_words, $more = "&hellip;" ) {
	$content = get_the_excerpt();

	// Strip tags and shortcodes so the content truncation count is done correctly
	$content = strip_tags(
		strip_shortcodes( $content ), apply_filters(
			'farmart_content_limit_allowed_tags', '<script>,<style>'
		)
	);

	// Remove inline styles / scripts
	$content = trim( preg_replace( '#<(s(cript|tyle)).*?</\1>#si', '', $content ) );

	// Truncate $content to $max_char
	$content = wp_trim_words( $content, $num_words );

	if ( $more ) {
		$output = sprintf(
			'<p>%s <a href="%s" class="more-link" title="%s">%s</a></p>',
			$content,
			get_permalink(),
			sprintf( esc_attr__( 'Continue reading &quot;%s&quot;', 'farmart' ), the_title_attribute( 'echo=0' ) ),
			esc_html( $more )
		);
	} else {
		$output = sprintf( '<p>%s</p>', $content );
	}

	return $output;
}

if ( ! function_exists( 'farmart_author_box' ) ) :
	function farmart_author_box() {
		if ( ! intval( farmart_get_option( 'show_author_box' ) ) ) {
			return;
		}

		if ( ! get_the_author_meta( 'description' ) ) {
			return;
		}
		?>

        <div class="post-author">
            <div class="post-author--box clearfix">
                <div class="post-author--avatar">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 80 ); ?>
                </div>
                <div class="post-author--info">
                    <h4 class="author-name"><?php the_author_meta( 'display_name' ); ?></h4>

                    <div><?php the_author_meta( 'description' ); ?></div>
                </div>
            </div>
        </div>

		<?php
	}
endif;

if ( ! function_exists( 'farmart_post_tag' ) ):

	function farmart_post_tag() {

		if ( has_tag() == false ) {
			return;
		}

		if ( has_tag() ) :
			the_tags( '<div class="farmart-post__tag-list"><span class="label">' . esc_html__( 'Tags:', 'farmart' ) . '</span>', ' ', '</div>' );
		endif;
	}
endif;

function farmart_get_related_terms( $term, $post_id = null ) {
	$post_id     = $post_id ? $post_id : get_the_ID();
	$terms_array = array( 0 );

	$terms = wp_get_post_terms( $post_id, $term );
	foreach ( $terms as $term ) {
		$terms_array[] = $term->term_id;
	}

	return array_map( 'absint', $terms_array );
}

/**
 * Show categories filter
 *
 * @return string
 */

if ( ! function_exists( 'farmart_taxs_list' ) ) :
	function farmart_taxs_list( $taxonomy = 'category' ) {

		$orderby  = farmart_get_option( 'blog_cats_orderby' );
		$order    = farmart_get_option( 'blog_cats_order' );
		$number   = farmart_get_option( 'blog_cats_number' );
		$view_all = farmart_get_option( 'blog_cats_view_all' );

		$cats   = '';
		$output = array();
		$number = apply_filters( 'farmart_blog_cats_number', $number );


		$args = array(
			'number'  => $number,
			'orderby' => $orderby,
			'order'   => $order
		);

		$term_id = 0;

		if ( is_tax( $taxonomy ) || is_category() ) {

			$queried_object = get_queried_object();
			if ( $queried_object ) {
				$term_id = $queried_object->term_id;
			}
		}

		$found       = false;
		$custom_slug = intval( farmart_get_option( 'custom_blog_cats' ) );
		if ( $custom_slug ) {
			$cats_slug = (array) farmart_get_option( 'blog_cats_slug' );
			foreach ( $cats_slug as $slug ) {
				$cat = get_term_by( 'slug', $slug, $taxonomy );
				if ( $cat ) {
					$css_class = '';
					if ( $cat->term_id == $term_id ) {
						$css_class = 'selected';
						$found     = true;
					}
					$cats .= sprintf( '<li><a class="%s" href="%s">%s</a></li>', esc_attr( $css_class ), esc_url( get_term_link( $cat ) ), esc_html( $cat->name ) );
				}
			}
		} else {
			$categories = get_terms( $taxonomy, $args );
			if ( ! is_wp_error( $categories ) && $categories ) {
				foreach ( $categories as $cat ) {
					$cat_selected = '';
					if ( $cat->term_id == $term_id ) {
						$cat_selected = 'selected';
						$found        = true;
					}
					$cats .= sprintf( '<li><a href="%s" class="%s">%s</a></li>', esc_url( get_term_link( $cat ) ), esc_attr( $cat_selected ), esc_html( $cat->name ) );
				}
			}
		}


		$cat_selected = $found ? '' : 'selected';

		if ( $cats ) {
			$blog_url = get_page_link( get_option( 'page_for_posts' ) );
			if ( 'posts' == get_option( 'show_on_front' ) ) {
				$blog_url = home_url();
			}

			$view_all_box = '';

			if ( ! empty( $view_all ) ) {
				$view_all_box = sprintf(
					'<li><a href="%s" class="%s">%s</a></li>',
					esc_url( $blog_url ),
					esc_attr( $cat_selected ),
					esc_html( $view_all )
				);
			}

			$output[] = sprintf(
				'<ul>%s%s</ul>',
				$view_all_box,
				$cats
			);
		}

		if ( $output ) {
			if ( farmart_is_blog() ) {

			$output = apply_filters( 'farmart_blog_taxs_list', $output );

				echo '<div class="farmart-taxs-list" id="farmart-taxs-list"><div class="container">' . implode( "\n", $output ) . '</div></div>';
			} else {
				echo '<div class="farmart-post-taxs-list">' . implode( "\n", $output ) . '</div>';
			}
		}

	}

endif;

if ( ! function_exists( 'farmart_is_blog' ) ) :
	function farmart_is_blog() {
		if ( ( is_archive() || is_author() || is_category() || is_home() || is_tag() ) && 'post' == get_post_type() ) {
			return true;
		}

		return false;
	}
endif;

/**
 * Conditional function to check if current page is the maintenance page.
 *
 * @return bool
 */
function farmart_is_maintenance_page() {
	if ( ! farmart_get_option( 'maintenance_enable' ) ) {
		return false;
	}

	if ( current_user_can( 'super admin' ) ) {
		return false;
	}

	$page_id = farmart_get_option( 'maintenance_page' );

	if ( ! $page_id ) {
		return false;
	}

	return is_page( $page_id );
}

/**
 * Check is catalog
 *
 * @return bool
 */
if ( ! function_exists( 'farmart_is_catalog' ) ) :
	function farmart_is_catalog() {
		if ( function_exists( 'is_shop' ) && ( (is_search() && get_post_type()  == 'product') || is_shop() || is_product_category() || is_product_tag() || is_tax( 'product_brand' ) || is_tax( 'product_collection' ) || is_tax( 'product_condition' ) ) ) {
			return true;
		}

		return false;
	}
endif;

/**
 * Check is vendor page
 *
 * @return bool
 */
if ( ! function_exists( 'farmart_is_vendor_page' ) ) :
	function farmart_is_vendor_page() {

		if ( function_exists( 'dokan_is_store_page' ) && dokan_is_store_page() ) {
			return true;
		}

		if ( farmart_is_wc_vendor_page() ) {
			return true;
		}

		if ( farmart_is_dc_vendor_store() ) {
			return true;
		}

		if ( function_exists( 'wcfm_is_store_page' ) && wcfm_is_store_page() ) {
			return true;
		}

		if ( class_exists( 'WCFMmp' ) ) {
			if ( wcfmmp_is_stores_list_page() ) {
				return true;
			}
		}

		return false;
	}
endif;

/**
 * Check is vendor page
 *
 * @return bool
 */
if ( ! function_exists( 'farmart_is_wc_vendor_page' ) ) :
	function farmart_is_wc_vendor_page() {

		if ( class_exists( 'WCV_Vendors' ) && method_exists( 'WCV_Vendors', 'is_vendor_page' ) ) {
			return WCV_Vendors::is_vendor_page();
		}

		return false;
	}
endif;

/**
 * Check is vendor page
 *
 * @return bool
 */
if ( ! function_exists( 'farmart_is_dc_vendor_store' ) ) :
	function farmart_is_dc_vendor_store() {

		if ( ! class_exists( 'WCMp' ) ) {
			return false;
		}

		global $WCMp;
		if ( empty( $WCMp ) ) {
			return false;
		}

		if ( is_tax( $WCMp->taxonomy->taxonomy_name ) ) {
			return true;
		}

		return false;
	}
endif;

/**
 * Check mobile version
 *
 * @since  1.0
 *
 */
if ( ! function_exists( 'farmart_is_mobile' ) ) :
	function farmart_is_mobile() {

		if ( ! class_exists( 'Mobile_Detect' ) ) {
			return false;
		}

		$mobile = false;
		$detect = new Mobile_Detect();
		if ( $detect->isMobile() && ! $detect->isTablet() ) {
			$mobile = true;
		}

		return $mobile;
	}
endif;

/**
 * Get current page URL for layered nav items.
 * @return string
 */
if ( ! function_exists( 'farmart_get_page_base_url' ) ) :
	function farmart_get_page_base_url() {
		if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
			$link = home_url( '/' );
		} elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id( 'shop' ) ) ) {
			$link = get_post_type_archive_link( 'product' );
		} elseif ( is_product_category() ) {
			$link = get_term_link( get_query_var( 'product_cat' ), 'product_cat' );
		} elseif ( is_product_tag() ) {
			$link = get_term_link( get_query_var( 'product_tag' ), 'product_tag' );
		} elseif ( is_tax() ) {
			$queried_object = get_queried_object();
			$link           = get_term_link( $queried_object->slug, $queried_object->taxonomy );
		} else {
			$link = get_post_type_archive_link( 'product' );
		}

		return $link;
	}
endif;

if ( ! function_exists( 'farmart_product_video' ) ) :
	function farmart_product_video() {
		global $product;
		$video_image  = get_post_meta( $product->get_id(), 'video_thumbnail', true );
		$video_url    = get_post_meta( $product->get_id(), 'video_url', true );
		$video_width  = 1024;
		$video_height = 768;
		$video_html   = '';
		if ( $video_image ) {
			$video_thumb = wp_get_attachment_image_src( $video_image, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
			$video_thumb = $video_thumb[0];
			// If URL: show oEmbed HTML
			if ( filter_var( $video_url, FILTER_VALIDATE_URL ) ) {

				$atts = array(
					'width'  => $video_width,
					'height' => $video_height
				);

				if ( $oembed = @wp_oembed_get( $video_url, $atts ) ) {
					$video_html = $oembed;
				} else {
					$atts = array(
						'src'    => $video_url,
						'width'  => $video_width,
						'height' => $video_height
					);

					$video_html = wp_video_shortcode( $atts );

				}
			}
			if ( $video_html ) {
				$vid_html      = '<div class="fm-video-wrapper">' . $video_html . '</div>';
				$video_wrapper = sprintf( '<div class="fm-video-content">%s</div>', $vid_html );
				$video_html    = '<div data-thumb="' . esc_url( $video_thumb ) . '" class="woocommerce-product-gallery__image fm-product-video">' . $video_wrapper . '</div>';
			}
		}

		return $video_html;
	}
endif;


if ( ! function_exists( 'farmart_product_video' ) ) :
	function farmart_product_video() {
		global $product;
		$video_image  = get_post_meta( $product->get_id(), 'video_thumbnail', true );
		$video_url    = get_post_meta( $product->get_id(), 'video_url', true );
		$video_first  = get_post_meta( $product->get_id(), 'video_position', true );
		$video_width  = 1024;
		$video_height = 768;
		$video_html   = '';
		if ( $video_image ) {
			$video_thumb = wp_get_attachment_image_src( $video_image, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
			$video_thumb = $video_thumb[0];
			// If URL: show oEmbed HTML
			if ( filter_var( $video_url, FILTER_VALIDATE_URL ) ) {

				$atts = array(
					'width'  => $video_width,
					'height' => $video_height
				);

				if ( $oembed = @wp_oembed_get( $video_url, $atts ) ) {
					$video_html = $oembed;
				} else {
					$atts = array(
						'src'    => $video_url,
						'width'  => $video_width,
						'height' => $video_height
					);

					$video_html = wp_video_shortcode( $atts );

				}
			}
			if ( $video_html ) {

				$vid_html = '<div class="fm-video-wrapper">' . $video_html . '</div>';
				if ( $video_first == '2' ) {
					$post_thumbnail_id = $product->get_image_id();
					$vid_html          .= '<div class="woocommerce-product-gallery__image"><a href="#"><img class="wp-post-image" src="#"></a></div>';
				}
				$video_wrapper = sprintf( '<div class="fm-video-content">%s</div>', $vid_html );
				$video_html    = '<div data-thumb="' . esc_url( $video_thumb ) . '" class="woocommerce-product-gallery__image fm-product-video">' . $video_wrapper . '</div>';
			}
		}

		return $video_html;
	}
endif;

/**
 * Get Post ID
 *
 * @since 1.0.0
 *
 * @return string
 */
if ( ! function_exists( 'farmart_get_post_ID' ) ) :
	function farmart_get_post_ID() {
		if ( farmart_is_catalog() ) {
			$post_id = intval( get_option( 'woocommerce_shop_page_id' ) );
		} elseif ( farmart_is_blog() ) {
			$post_id = intval( get_option( 'page_for_posts' ) );
		} else {
			$post_id = get_the_ID();
		}

		return $post_id;
	}
endif;

/**
 * Star rating HTML.
 *
 * @since 1.0.0
 *
 * @param string $html Star rating HTML.
 * @param int $rating Rating value.
 * @param int $count Rated count.
 *
 * @return string
 */
if ( ! function_exists( 'farmart_star_rating_html' ) ) :
	function farmart_star_rating_html( $html, $rating, $count ) {
		$icon = '<span class="farmart-svg-icon"><svg aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></span>';
		$html = '<span class="max-rating rating-stars">'
				. $icon
				. $icon
				. $icon
				. $icon
				. $icon
				. '</span>';
		$html .= '<span class="user-rating rating-stars" style="width:' . ( ( intval($rating) / 5 ) * 100 ) . '%">'
				. $icon
				. $icon
				. $icon
				. $icon
				. $icon
					. '</span>';

		$html .= '<span class="screen-reader-text">';

		if ( 0 < $count ) {
			/* translators: 1: rating 2: rating count */
			$html .= sprintf( _n( 'Rated %1$s out of 5 based on %2$s customer rating', 'Rated %1$s out of 5 based on %2$s customer ratings', $count, 'farmart' ), '<strong class="rating">' . esc_html( $rating ) . '</strong>', '<span class="rating">' . esc_html( $count ) . '</span>' );
		} else {
			/* translators: %s: rating */
			$html .= sprintf( esc_html__( 'Rated %s out of 5', 'farmart' ), '<strong class="rating">' . esc_html( $rating ) . '</strong>' );
		}

		$html .= '</span>';

		return $html;
	}
	endif;