<?php
/**
 * Custom functions that act on header templates
 *
 * @package Farmart
 */

/**
 * Options of footer items
 *
 * @since 1.0.0
 *
 * @return array
 */
function famart_footer_items_option() {
    return apply_filters( 'farmart_footer_items_option', array(
        'copyright' => esc_html__( 'Copyright', 'farmart' ),
        'payment'   => esc_html__( 'Payments', 'farmart' ),
        'social'    => esc_html__( 'Socials', 'farmart' ),
        'menu'      => esc_html__( 'Menu', 'farmart' ),
    ) );
}

/**
 * Custom template tags of footer
 *
 * @since 1.0.0
 *
 * @return  void
 */
if ( ! function_exists( 'farmart_footer_item' ) ) :
    function farmart_footer_item( $item ) {
        switch ( $item ) {
            case 'copyright':
                $copyright = farmart_get_option( 'footer_copyright' );
                echo '<div class="copyright">' . do_shortcode( $copyright ) . '</div>';
                break;

            case 'payment':
                farmart_footer_payments();
                break;

            case 'social':
                farmart_socials_menu();
                break;

            case 'menu':
                if ( has_nav_menu( 'footer' ) ) {
                    echo '<nav id="primary-menu" class="main-navigation primary-navigation footer-navigation">';
                        wp_nav_menu( array(
                            'theme_location' => 'footer',
                            'container'      => false,
                        ) );
                    echo '</nav>';
                }
                break;

            default:
                do_action( 'farmart_footer_footer_main_item', $item );
                break;
        }
    }
endif;

/**
 * Display payment  in footer
 *
 * @since 1.0.0
 *
 * @return  void
 */
if ( ! function_exists( 'farmart_footer_payments' ) ) :
    function farmart_footer_payments() {
        $output = array();

        $images = farmart_get_option( 'footer_main_payment_images' );
        if ( $images ) {

            $output[] = '<ul class="payments">';
            foreach ( (array) $images as $image ) {

                if ( ! isset( $image['image'] ) && ! $image['image'] ) {
                    continue;
                }

                $image_id = $image['image'];

                if( is_numeric($image_id) ) {
					$img = wp_get_attachment_image( $image_id, 'full' );
				} else {
					$img = sprintf('<img src="%s" alt="%s">', $image_id, esc_html__( 'Payment Image', 'farmart' ) );
				}

                if ( isset( $image['link'] ) && ! empty( $image['link'] ) ) {
                    if ( $img ) {
                        $output[] = sprintf( '<li><a href="%s">%s</a></li>', esc_url( $image['link'] ), $img );
                    }
                } else {
                    if ( $img ) {
                        $output[] = sprintf( '<li>%s</li>', $img );
                    }
                }

            }
            $output[] = '</ul>';
        }

        if ( $output ) {
            printf( '<div class="footer-payments">%s</div>', implode( ' ', $output ) );
        }
    }
endif;

/**
 * Get Socials menu
 *
 * @since 1.0.0
 *
 * @return void
 */
if ( ! function_exists( 'farmart_socials_menu' ) ) :
    function farmart_socials_menu() {
        if ( has_nav_menu( 'socials' ) ) {
            echo '<div class="farmart-footer-socials-menu socials-menu">';
            echo '<div class="farmart-footer-social-text">'. esc_html__( 'Stay connected:', 'farmart' ) .'</div>';

                if ( class_exists( '\Farmart\Addons\Modules\Mega_Menu\Socials_Walker' ) ) {
                    wp_nav_menu( apply_filters( 'farmart_navigation_social_content', array(
                        'theme_location'  => 'socials',
                        'menu_id'         => 'socials-menu',
                        'depth'           => 1,
                        'link_before'     => '<span>',
                        'link_after'      => '</span>',
                        'walker' 		=>	new \Farmart\Addons\Modules\Mega_Menu\Socials_Walker()
                    ) ) );
                } else {
                    wp_nav_menu( apply_filters( 'farmart_navigation_social_content', array(
                        'theme_location'  => 'socials',
                        'menu_id'         => 'socials-menu',
                        'depth'           => 1,
                        'link_before'     => '<span>',
                        'link_after'      => '</span>',
                    ) ) );
                }
            echo '</div>';
        }
    }
endif;