<?php
/**
 * Custom functions that act on header templates
 *
 * @package Farmart
 */

/**
 * Register fonts
 *
 * @since  1.0.0
 *
 * @return string
 */

if (!function_exists('farmart_fonts_url')):
    function farmart_fonts_url()
    {
        $fonts_url = '';

        /* Translators: If there are characters in your language that are not
        * supported by Montserrat, translate this to 'off'. Do not translate
        * into your own language.
        */
        if ('off' !== _x('on', 'Muli font: on or off', 'farmart')) {
            $font_families[] = 'Muli:400,600,700';
        }

        if ('off' !== _x('on', 'Playfair Display font: on or off', 'farmart')) {
            $font_families[] = 'Playfair Display:400,400i';
        }

        if ('off' !== _x('on', 'Open Sans font: on or off', 'farmart')) {
            $font_families[] = 'Open Sans:400,600,700';
        }

        if (!empty($font_families)) {
            $query_args = array(
                'family' => urlencode(implode('|', $font_families)),
                'subset' => urlencode('latin,latin-ext'),
            );

            $fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
        }

        return esc_url_raw($fonts_url);
    }
endif;

/**
 * Get Menu extra search
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if (!function_exists('farmart_extra_search')) :
    function farmart_header_search()
    {
        ?>
        <form method="get" action="<?php echo esc_url(home_url('/')) ?>">
            <label>
                <input type="text" name="s" class="search-field"
                       value="<?php echo esc_attr(get_search_query()); ?>"
                       placeholder="<?php echo apply_filters('farmart_header_search_placeholder', esc_attr__('I&rsquo;m searching for...', 'farmart')); ?>"
                       autocomplete="off">
                <button type="submit" class="search-submit"><?php esc_html_e('Search', 'farmart') ?></button>
            </label>
        </form>
        <?php
    }

endif;

/**
 * Options of header items
 *
 * @since 1.0.0
 *
 * @return array
 */
if ( !function_exists( 'get_header_items_option' ) ) :
	function get_header_items_option()
    {
		return apply_filters( 'farmart_header_items_option', array(
			'0'              	=> esc_html__( 'Select a item', 'farmart' ),
			'logo'           	=> esc_html__( 'Logo', 'farmart' ),
			'search'           	=> esc_html__( 'Search', 'farmart' ),
			'account'          	=> esc_html__( 'Account Icon', 'farmart' ),
			'wishlist'         	=> esc_html__( 'Wishlist Icon', 'farmart' ),
			'compare'         	=> esc_html__( 'Compare Icon', 'farmart' ),
			'cart'          	=> esc_html__( 'Cart Icon', 'farmart' ),
			'header-bar'      	=> esc_html__( 'Header Bar', 'farmart' ),
			'primary-button'    => esc_html__( 'Primary Button', 'farmart' ),
			'secondary-button'  => esc_html__( 'Secondary Button', 'farmart' ),
			'menu-primary'     	=> esc_html__( 'Menu Primary', 'farmart' ),
			'menu-department'  	=> esc_html__( 'Menu Department', 'farmart' ),
			'recently-product' 	=> esc_html__( 'Recently Product', 'farmart' ),
		) );
	}
endif;

/**
 * Options of mobile header icons
 *
 * @since 1.0.0
 *
 * @return array
 */
function farmart_mobile_header_option() {
	return apply_filters( 'farmart_mobile_header_option', array(
		'logo'     => esc_html__( 'Logo', 'farmart' ),
		'cart'     => esc_html__( 'Cart Icon', 'farmart' ),
		'wishlist' => esc_html__( 'Wishlist Icon', 'farmart' ),
        'compare'  => esc_html__( 'Compare Icon', 'farmart' ),
		'menu'     => esc_html__( 'Menu Icon', 'farmart' ),
		'search'   => esc_html__( 'Search Icon', 'farmart' ),
	) );
}

/**
 * Custom template tags of footer
 *
 * @since 1.0.0
 *
 * @return  void
 */
if ( ! function_exists( 'farmart_mobile_header_item' ) ) :
    function farmart_mobile_header_item( $item ) {
        switch ( $item ) {
            case 'menu':
                get_template_part( 'template-parts/mobile/header-menu' );
                break;

            case 'logo':
                if ( ! empty( farmart_get_option( 'mobile_logo' ) ) ) {
                    get_template_part( 'template-parts/mobile/header-logo' );
                } else {
                    get_template_part( 'template-parts/headers/elements/logo' );
                }
                break;

            case 'search':
                get_template_part( 'template-parts/mobile/header-search' );
                break;

            case 'cart':
                get_template_part( 'template-parts/mobile/header-cart' );
                break;

            case 'wishlist':
                get_template_part( 'template-parts/headers/elements/wishlist' );
                break;

            case 'compare':
                get_template_part( 'template-parts/headers/elements/compare' );
                break;

            default:
                do_action( 'farmart_mobile_header_item', $item );
                break;
        }
    }
endif;