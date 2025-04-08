<?php

namespace FarmartAddons;

use Elementor\Group_Control_Image_Size;
use FarmartAddons\Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Elementor_AjaxLoader {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'wc_ajax_fm_elementor_get_elements', [ $this, 'elementor_get_elements' ] );
	}

	public static function elementor_get_elements() {
		$output = '';

		if ( isset( $_POST['params'] ) && ! empty( $_POST['params'] ) ) {
			$params   = json_decode( stripslashes( $_POST['params'] ), true );
			$settings = array();
			foreach ( $params as $key => $value ) {
				$settings[ $key ] = $value;
			}

			$els = '';
			if ( isset( $_POST['element'] ) && ! empty( $_POST['element'] ) ) {
				$els = $_POST['element'];
			}

			if ( $els == 'productsCarousel' ) {
				ob_start();
				self::get_products_carousel( $settings );
				$output = ob_get_clean();
            } elseif ( $els == 'productsCarousel2' ) {
				ob_start();
				self::get_products_carousel_2( $settings );
				$output = ob_get_clean();
            } elseif ( $els == 'productsListCarousel' ) {
				ob_start();
				self::get_products_list_carousel( $settings );
				$output = ob_get_clean();
            } elseif ( $els == 'productsTabCarousel' ) {
				ob_start();
				self::get_products_tab_carousel( $settings );
				$output = ob_get_clean();
            } elseif ( $els == 'productsTabCarousel2' ) {
				ob_start();
				self::get_products_tab_carousel( $settings );
				$output = ob_get_clean();
            } elseif ( $els == 'productsTabCarousel3' ) {
				ob_start();
				self::get_products_tab_carousel( $settings );
				$output = ob_get_clean();
            } elseif ( $els == 'productsCarouselWithCat' ) {
				ob_start();
				self::get_products_carousel_with_category( $settings );
				$output = ob_get_clean();
            } elseif ( $els == 'productsWithCat' ) {
				ob_start();
				self::get_products_with_category( $settings );
				$output = ob_get_clean();
            }
		}

		wp_send_json_success( $output );
		die();
	}

	public static function get_products_carousel( $settings ) {
        $settings['columns'] = intval( $settings['slidesToShow'] );
		$products            = Elementor::get_products( $settings );

		$title = $link = $icon = $title_icon = '';
		if ( $settings['title_icon'] && ! empty( $settings['title_icon']['value'] ) && \Elementor\Icons_Manager::is_migration_allowed() ) {
			ob_start();
			\Elementor\Icons_Manager::render_icon( $settings['title_icon'], [ 'aria-hidden' => 'true' ] );
			$title_icon = '<span class="farmart-svg-icon">' . ob_get_clean() . '</span>';
		}

		if ( $settings['title'] ) {
			$title = '<h3>' . $title_icon . $settings['title'] . '</h3>';
		}

		if ( $settings['link_icon'] ) {
			if ( $settings['link_icon'] && ! empty( $settings['link_icon']['value'] ) && \Elementor\Icons_Manager::is_migration_allowed() ) {
				ob_start();
				\Elementor\Icons_Manager::render_icon( $settings['link_icon'], [ 'aria-hidden' => 'true' ] );
				$icon_svg = ob_get_clean();
				if( $icon_svg ) {
					$icon = '<span class="farmart-svg-icon">' . $icon_svg . '</span>';
				}
			}

			if( empty( $icon ) ) {
				$icon = '<span class="farmart-svg-icon"><svg viewBox="0 0 32 32"><path d="M8 32c-0.205 0-0.409-0.078-0.566-0.234-0.312-0.312-0.312-0.819 0-1.131l13.834-13.834-13.834-13.834c-0.312-0.312-0.312-0.819 0-1.131s0.819-0.312 1.131 0l14.4 14.4c0.312 0.312 0.312 0.819 0 1.131l-14.4 14.4c-0.156 0.156-0.361 0.234-0.566 0.234z"></path></svg></span>';
			}

		}

		if ( $settings['link_text'] ) {
			$text = '<span class="link-text">' . $settings['link_text'] . '</span>' . $icon;
			$link = self::get_link_control( 'header_link', $settings['link'], $text, [ 'class' => 'header-link' ] );
		}
		$header_html = $title == '' && $link == '' ? '' :sprintf('<div class="products-header">%s%s</div>',$title,$link);
		$products_html = sprintf('<div class="products-content">%s<div class="slick-dots-wrapper"></div></div>',$products);

		echo $header_html . $products_html;
	}

	public static function get_products_carousel_2( $settings ) {
		$settings['columns'] = intval( $settings['slidesToShow'] );
		$products            = Elementor::get_products( $settings );

		$title = $link = $icon = $title_icon = '';
		if ( $settings['title_icon'] && ! empty( $settings['title_icon']['value'] ) && \Elementor\Icons_Manager::is_migration_allowed() ) {
			ob_start();
			\Elementor\Icons_Manager::render_icon( $settings['title_icon'], [ 'aria-hidden' => 'true' ] );
			$title_icon = '<span class="farmart-svg-icon">' . ob_get_clean() . '</span>';
		}

		if ( $settings['title'] ) {
			$title = '<h3>' . $title_icon . $settings['title'] . '</h3>';
		}

		if ( $settings['link_icon'] ) {
			if ( $settings['link_icon'] && ! empty( $settings['link_icon']['value'] ) && \Elementor\Icons_Manager::is_migration_allowed() ) {
				ob_start();
				\Elementor\Icons_Manager::render_icon( $settings['link_icon'], [ 'aria-hidden' => 'true' ] );
				$icon_svg = ob_get_clean();
				if( $icon_svg ) {
					$icon = '<span class="farmart-svg-icon">' . $icon_svg . '</span>';
				}
			}

			if( empty( $icon ) ) {
				$icon = '<span class="farmart-svg-icon"><svg viewBox="0 0 32 32"><path d="M8 32c-0.205 0-0.409-0.078-0.566-0.234-0.312-0.312-0.312-0.819 0-1.131l13.834-13.834-13.834-13.834c-0.312-0.312-0.312-0.819 0-1.131s0.819-0.312 1.131 0l14.4 14.4c0.312 0.312 0.312 0.819 0 1.131l-14.4 14.4c-0.156 0.156-0.361 0.234-0.566 0.234z"></path></svg></span>';
			}
		}

		if ( $settings['link_text'] ) {
			$text = '<span class="link-text">' . $settings['link_text'] . '</span>' . $icon;
			$link = self::get_link_control( 'header_link', $settings['link'], $text, [ 'class' => 'header-link' ] );
		}

		?>
		<div class="products-header">
			<?php echo $title . $link; ?>
		</div>
		<div class="products-content"><?php echo $products; ?></div>
		<?php
	}

	public static function get_products_list_carousel( $settings ) {
        $settings['columns'] = intval( $settings['slidesToShow'] );
		$products            = Elementor::get_products( $settings );

		$title = $link = $icon = $title_icon = '';
		if ( $settings['title_icon'] && ! empty( $settings['title_icon']['value'] ) && \Elementor\Icons_Manager::is_migration_allowed() ) {
			ob_start();
			\Elementor\Icons_Manager::render_icon( $settings['title_icon'], [ 'aria-hidden' => 'true' ] );
			$title_icon = '<span class="farmart-svg-icon">' . ob_get_clean() . '</span>';
		}

		if ( $settings['title'] ) {
			$title = '<h3>' . $title_icon . $settings['title'] . '</h3>';
		}

		$header_html = $title ? sprintf( '<div class="products-header">%s<div class="slick-arrows-wrapper"></div></div>', $title ) : '' ;
		$products_html = sprintf( '<div class="products-content">%s</div>',$products );

		echo $header_html . $products_html;
	}

	public static function get_products_tab_carousel( $settings ) {
		$output      = [ ];
		$header_tabs = [ ];
		if ( ! empty( $settings['title'] ) ) {
			$header_tabs[] = sprintf( '<h3 class="title">%s</h3>', $settings['title'] );
		}

		$header_tabs[] = '<div class="tabs-header-nav">';

		$tab_content = [ ];

		$header_tabs[] = '<ul class="tabs-nav">';
		$i             = 0;
		if ( $settings['product_tabs_source'] == 'special_products' ) {
			$tabs = $settings['special_products_tabs'];

			if ( $tabs ) {
				foreach ( $tabs as $index => $item ) {

					$key_tab = 'key-'.esc_attr( $item['tab_products'] ).'-'.$i.' ';

					if ( isset( $item['title'] ) ) {
						$header_tabs[] = sprintf( '<li><a href="#" data-href="%s" data-key="%s" class="tab-item">%s</a></li>', esc_attr( $item['tab_products'] ),esc_attr($key_tab),esc_html( $item['title'] ) );
					}

					$tab_atts = array(
						'columns'             => intval( $settings['slidesToShow'] ),
						'products'            => $item['tab_products'],
						'order'               => ! empty( $item['tab_order'] ) ? $item['tab_order'] : '',
						'orderby'             => ! empty( $item['tab_orderby'] ) ? $item['tab_orderby'] : '',
						'per_page'            => intval( $settings['per_page'] ),
						'product_cats'        => $settings['product_cats'],
						'product_brands'      => $settings['product_brands'],
						'product_collections' => $settings['product_collections'],
					);

					if ( $i == 0 ) {
						$tab_content[] = sprintf(
							'<div class="tabs-panel tabs-%s tab-loaded %s">%s<div class="slick-dots-wrapper"></div></div>',
							esc_attr( $item['tab_products'] ),
							esc_attr($key_tab),
							Elementor::get_products( $tab_atts )
						);

					} else {
						if ( $settings['lazy_load'] == 'yes' ) {
							$tab_content[] = sprintf(
								'<div class="tabs-panel tabs-%s tab-loaded %s">%s<div class="slick-dots-wrapper"></div></div>',
								esc_attr( $item['tab_products'] ),
								esc_attr($key_tab),
								Elementor::get_products( $tab_atts )
							);
						} else {
							$tab_content[] = sprintf(
								'<div class="tabs-panel tabs-%s %s" data-settings="%s">
									<div class="farmart-loading-wrapper"><div class="farmart-loading"></div></div>
									<div class="slick-dots-wrapper"></div>
								</div>',
								esc_attr( $item['tab_products'] ),
								esc_attr($key_tab),
								esc_attr(wp_json_encode( $tab_atts ))
							);
						}

					}

					$i ++;
				}
			}
		} else {
			$cats = $settings['product_cats_tabs'];
			if ( $cats ) {
				foreach ( $cats as $tab ) {
					$term = get_term_by( 'slug', $tab['product_cat'], 'product_cat' );

					$key_tab = 'key-'.esc_attr( $tab['product_cat'] ).'-'.$i.' ';

					if ( ! is_wp_error( $term ) && $term ) {
						$header_tabs[] = sprintf(
							'<li><a href="#" data-href="%s" data-key="%s" class="tab-item">%s</a></li>',
							esc_attr( $tab['product_cat'] ),
							esc_attr($key_tab),
							esc_html( $term->name )
						);
					}

					$tab_atts = array(
						'columns'      => intval( $settings['slidesToShow'] ),
						'products'     => $settings['products'],
						'order'        => $settings['order'],
						'orderby'      => $settings['orderby'],
						'per_page'     => intval( $settings['per_page'] ),
						'product_cats' => $tab['product_cat'],
					);

					if ( $i == 0 ) {
						$tab_content[] = sprintf(
							'<div class="tabs-panel tabs-%s tab-loaded %s">%s<div class="slick-dots-wrapper"></div></div>',
							esc_attr( $tab['product_cat'] ),
							esc_attr($key_tab),
							Elementor::get_products( $tab_atts )
						);
					} else {
						if ( $settings['lazy_load'] == 'yes' ) {
							$tab_content[] = sprintf(
								'<div class="tabs-panel tabs-%s tab-loaded %s">%s<div class="slick-dots-wrapper"></div></div>',
								esc_attr( $tab['product_cat'] ),
								esc_attr($key_tab),
								Elementor::get_products( $tab_atts )
							);
						} else {
							$tab_content[] = sprintf(
								'<div class="tabs-panel tabs-%s %s" data-settings="%s">
									<div class="farmart-loading-wrapper"><div class="farmart-loading"></div></div>
									<div class="slick-dots-wrapper"></div>
								</div>',
								esc_attr( $tab['product_cat'] ),
								esc_attr($key_tab),
								esc_attr(wp_json_encode( $tab_atts ))
							);
						}
					}

					$i ++;

				}
			}
		}

		// All Tab
		if ( $settings['view_all'] ) {
			$link = self::get_link_control( 'view_all_link', $settings['view_all_url'], $settings['view_all'], [ 'class' => 'view-all' ] );
			$header_tabs[] = sprintf(
				'<li>%s</li>',
				$link
			);
		}

		$header_tabs[] = '</ul>';

		$header_tabs[] = '</div>';

		$output[] = sprintf( '<div class="tabs-header">%s</div>', implode( ' ', $header_tabs ) );
		$output[] = sprintf(
			'<div class="tabs-wrapper">
				<div class="tabs-content">%s</div>
			</div>',
			implode( ' ', $tab_content )
		);

		echo implode( '', $output );
	}

	public static function get_products_carousel_with_category( $settings ) {
		$settings['columns'] = intval( $settings['slidesToShow'] );

		$icon = '';
		if ( $settings['title_icon'] && ! empty( $settings['title_icon']['value'] ) && \Elementor\Icons_Manager::is_migration_allowed() ) {
			ob_start();
			\Elementor\Icons_Manager::render_icon( $settings['title_icon'], [ 'aria-hidden' => 'true' ] );
			$icon = '<span class="farmart-svg-icon">' . ob_get_clean() . '</span>';
		}

        ?>
        <div class="header-cat">
			<?php echo $settings['title'] ? '<h2>' . $icon . $settings['title'] . '</h2>' : '' ?>

			<?php if ( ! empty( $settings['links_group'] ) || $settings['view_all_text'] ) : ?>
				<div class="extra-links-wrapper">
					<ul class="extra-links">
						<?php
						// View All
						$link = '';
						if ( $settings['view_all_icon'] && ! empty( $settings['view_all_icon']['value'] ) && \Elementor\Icons_Manager::is_migration_allowed() ) {
							ob_start();
							\Elementor\Icons_Manager::render_icon( $settings['view_all_icon'], [ 'aria-hidden' => 'true' ] );
							$icon_svg = ob_get_clean();
							if( $icon_svg ) {
								$icon = '<span class="farmart-svg-icon">' . $icon_svg . '</span>';
							}
						}

						if( empty( $icon ) && $settings['view_all_position'] == 'after' ) {
							$icon = '<span class="farmart-svg-icon"><svg viewBox="0 0 32 32"><path d="M8 32c-0.205 0-0.409-0.078-0.566-0.234-0.312-0.312-0.312-0.819 0-1.131l13.834-13.834-13.834-13.834c-0.312-0.312-0.312-0.819 0-1.131s0.819-0.312 1.131 0l14.4 14.4c0.312 0.312 0.312 0.819 0 1.131l-14.4 14.4c-0.156 0.156-0.361 0.234-0.566 0.234z"></path></svg></span>';
						}

						if ( $settings['view_all_text'] ) {
							$text = '<span class="link-text">' . $settings['view_all_text'] . '</span>' . $icon;
							$link = self::get_link_control( 'header_link', $settings['view_all_link'], $text, [ 'class' => 'header-link' ] );
						}

						if( $settings['view_all_position'] == 'before' ) {
							echo sprintf( '<li class="extra-link-item view-all-btn">%s</li>', $link );
						}

						$links = $settings['links_group'];
						if ( $links ) {
							foreach ( $links as $index => $item ) {
								$link_key = 'extra_link' . $index;
								echo sprintf( '<li class="extra-link-item">%s</li>', self::get_link_control( $link_key, $item['link_url'], $item['link_text'], [ 'class' => 'extra-link' ] ) );
							}
						}

						if( $settings['view_all_position'] == 'after' ) {
							echo sprintf( '<li class="extra-link-item">%s</li>', $link );
						}
						?>
					</ul>
				</div>
			<?php endif; ?>

			</div>
			<div class="content-wrapper">
				<?php
				if ( ! empty( $settings['image']['url'] ) ) {
					$image = Group_Control_Image_Size::get_attachment_image_html( $settings );
					echo '<div class="images-box">';
					$link_key = 'image_link_key';
					echo self::get_link_control( $link_key, $settings['image_link'], $image, [ 'class' => 'image-item' ] );
					echo '</div>';
				}
				?>
				<div class="products-box">
					<?php echo Elementor::get_products( $settings ); ?>
				</div>
			</div>
		<?php
	}

	public static function get_products_with_category( $settings ) {
		$icon = $view_all_icon = '';
		if ( $settings['title_icon'] && ! empty( $settings['title_icon']['value'] ) && \Elementor\Icons_Manager::is_migration_allowed() ) {
			ob_start();
			\Elementor\Icons_Manager::render_icon( $settings['title_icon'], [ 'aria-hidden' => 'true' ] );
			$icon = '<span class="farmart-svg-icon">' . ob_get_clean() . '</span>';
		}

		if ( $settings['view_all_icon'] && ! empty( $settings['view_all_icon']['value'] ) && \Elementor\Icons_Manager::is_migration_allowed() ) {
			ob_start();
			\Elementor\Icons_Manager::render_icon( $settings['view_all_icon'], [ 'aria-hidden' => 'true' ] );
			$icon_svg = ob_get_clean();
			if( $icon_svg ) {
				$view_all_icon = '<span class="farmart-svg-icon">' . $icon_svg . '</span>';
			}
		}

		if( empty( $view_all_icon ) ) {
			$view_all_icon = '<span class="farmart-svg-icon"><svg viewBox="0 0 32 32"><path d="M8 32c-0.205 0-0.409-0.078-0.566-0.234-0.312-0.312-0.312-0.819 0-1.131l13.834-13.834-13.834-13.834c-0.312-0.312-0.312-0.819 0-1.131s0.819-0.312 1.131 0l14.4 14.4c0.312 0.312 0.312 0.819 0 1.131l-14.4 14.4c-0.156 0.156-0.361 0.234-0.566 0.234z"></path></svg></span>';
		}

		$slides = [ 'slidesToShow', 'slidesToScroll' ];

		foreach ( $slides as $slide ) {
			$settings[$slide] = 1;
		}

        ?>
        <div class="header-cat">
			<h2><?php echo self::get_link_control( 'link', $settings['c_link'], $icon . $settings['title'], [ 'class' => 'cat-title' ] ) ?></h2>
			<?php
				if( isset($settings['quick_links']) || $settings['quick_links'] == '' ){
					if (  $settings['view_all_text'] ) {
						$link_text = '<span class="link-text">' . $settings['view_all_text'] . '</span>';
						echo self::get_link_control( 'header_link', $settings['view_all_link'], $link_text . $view_all_icon, [ 'class' => 'header-link' ] );
					}
				}
			?>
		</div>
		<div class="content-wrapper">
			<div class="sidebar-box">
				<div class="images-slider">
					<div class="images-list" data-slick="<?php echo esc_attr(wp_json_encode( Elementor::get_data_slick( $settings ) ) ) ?>">
						<?php
						$banners = $settings['banners'];
						if ( $banners ) {
							foreach ( $banners as $index => $item ) {
								if ( empty( $item['image'] ) ) {
									continue;
								}
								$link_key               = 'banner_link' . $index;
								$settings['image']      = $item['image'];
								$settings['image_size'] = 'full';
								$image_url              = Group_Control_Image_Size::get_attachment_image_html( $settings );
								echo self::get_link_control( $link_key, $item['image_link'], $image_url, [ 'class' => 'image-item' ] );
							}
						}
						?>
					</div>
				</div>
				<div class="categories-box categories-box--columns-<?php echo $settings['quicklink_columns']; ?>">
					<div class="quick-links-wrapper">
						<?php for ( $i = 1; $i < 3; $i ++ ) : ?>
							<div class="category-box category-box--<?php echo esc_attr( $i ) ?>">
								<?php echo $settings['quicklink_title_' . $i] ? sprintf( '<h4>%s</h4>', self::get_link_control( 'quicklink_' . $i, $settings['quicklink_url_' . $i], $settings['quicklink_title_' . $i] ) ) : ''; ?>
								<ul class="extra-links">
									<?php
									$links = $settings['links_group_' . $i];
									if ( $links ) {
										foreach ( $links as $index => $item ) {
											$link_key = 'extra_link_' . $i . $index;
											echo sprintf( '<li>%s</li>', self::get_link_control( $link_key, $item['link_url_' . $i], $item['link_text_' . $i], [ 'class' => 'extra-link' ] ) );
										}
									}
									?>
								</ul>
							</div>
						<?php endfor; ?>
					</div>

					<?php
						if (  $settings['view_all_text'] ) {
							$link_text = '<span class="link-text">' . $settings['view_all_text'] . '</span>';
							echo '<div class="categories-box--footer">';
							echo self::get_link_control( 'footer_link', $settings['view_all_link'], $link_text . $view_all_icon, [ 'class' => 'header-link' ] );
							echo '</div>';
						}
					?>
				</div>
			</div>

			<div class="products-box">
				<?php echo Elementor::get_products( $settings ); ?>
			</div>
		</div>
		<?php
	}

    /**
	 * Render link control output
	 *
	 * @param       $link_key
	 * @param       $url
	 * @param       $content
	 * @param array $attr
	 *
	 * @return string
	 */
	public static function get_link_control( $link_key, $url, $content, $attr = [ ] ) {
		$attr_default = [ ];
		if ( isset( $url['url'] ) && $url['url'] ) {
			$attr_default['href'] = $url['url'];
		}

		if ( isset( $url['is_external'] ) && $url['is_external'] ) {
			$attr_default['target'] = '_blank';
		}

		if ( isset( $url['nofollow'] ) && $url['nofollow'] ) {
			$attr_default['rel'] = 'nofollow';
		}

		$attr = wp_parse_args( $attr, $attr_default );

		$tag = 'a';

		if ( empty( $attr['href'] ) ) {
			$tag = 'span';
		}

        $attributes = [];

        foreach( $attr as $name => $v ) {
            $attributes[] = $name . '="' . esc_attr( $v ) . '"';
        }

		return sprintf( '<%1$s %2$s>%3$s</%1$s>', $tag, implode( ' ', $attributes ), $content );
	}
}

new Elementor_AjaxLoader();