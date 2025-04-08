<?php
/**
 * Theme customizer
 *
 * @package Farmart
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Farmart_Customize {
	/**
	 * Customize settings
	 *
	 * @var array
	 */
	protected $config = array();

	/**
	 * The class constructor
	 *
	 * @param array $config
	 */
	public function __construct( $config ) {
		$this->config = $config;

		if ( ! class_exists( 'Kirki' ) ) {
			return;
		}

		add_action( 'init', array( $this, 'register' ) );

		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Register settings
	 */
	public function register() {

		/**
		 * Add the theme configuration
		 */
		if ( ! empty( $this->config['theme'] ) ) {
			Kirki::add_config(
				$this->config['theme'], array(
					'capability'  => 'edit_theme_options',
					'option_type' => 'theme_mod',
				)
			);
		}

		/**
		 * Add panels
		 */
		if ( ! empty( $this->config['panels'] ) ) {
			foreach ( $this->config['panels'] as $panel => $settings ) {
				Kirki::add_panel( $panel, $settings );
			}
		}

		/**
		 * Add sections
		 */
		if ( ! empty( $this->config['sections'] ) ) {
			foreach ( $this->config['sections'] as $section => $settings ) {
				Kirki::add_section( $section, $settings );
			}
		}

		/**
		 * Add fields
		 */
		if ( ! empty( $this->config['theme'] ) && ! empty( $this->config['fields'] ) ) {
			foreach ( $this->config['fields'] as $name => $settings ) {
				if ( ! isset( $settings['settings'] ) ) {
					$settings['settings'] = $name;
				}

				Kirki::add_field( $this->config['theme'], $settings );
			}
		}
	}

	/**
	 * Enqueues style and scripts for customizer controls
	 */
	public function enqueue_scripts() {
		wp_add_inline_style( 'customize-controls', 'li.control-section-kirki-default { min-height: unset; }' );
	}

	/**
	 * Get config ID
	 *
	 * @return string
	 */
	public function get_theme() {
		return $this->config['theme'];
	}

	/**
	 * Get customize setting value
	 *
	 * @param string $name
	 *
	 * @return bool|string
	 */
	public function get_option( $name ) {

		$default = $this->get_option_default( $name );

		return get_theme_mod( $name, $default );
	}

	/**
	 * Get default option values
	 *
	 * @param $name
	 *
	 * @return mixed
	 */
	public function get_option_default( $name ) {
		if ( ! isset( $this->config['fields'][$name] ) ) {
			return false;
		}

		return isset( $this->config['fields'][$name]['default'] ) ? $this->config['fields'][$name]['default'] : false;
	}
}

/**
 * This is a short hand function for getting setting value from customizer
 *
 * @param string $name
 *
 * @return bool|string
 */
function farmart_get_option( $name ) {
	global $farmart_customize;

	$value = false;

	if ( class_exists( 'Kirki' ) ) {
		$value = Kirki::get_option( 'farmart', $name );
	} elseif ( ! empty( $farmart_customize ) ) {
		$value = $farmart_customize->get_option( $name );
	}

	return apply_filters( 'farmart_get_option', $value, $name );
}

/**
 * Get nav menus
 *
 * @since 1.0.0
 *
 * @return array
 */
function farmart_select_menus() {
	if ( ! is_admin() ) {
		return [];
	}

	$menus = wp_get_nav_menus();
	if ( ! $menus ) {
		return [];
	}

	$output = array(
		0 => esc_html__( 'Select Menu', 'farmart' ),
	);
	foreach ( $menus as $menu ) {
		$output[ $menu->slug ] = $menu->name;
	}

	return $output;
}
/**
 * Get default option values
 *
 * @param $name
 *
 * @return mixed
 */
function farmart_get_option_default( $name ) {
	global $farmart_customize;

	if ( empty( $farmart_customize ) ) {
		return false;
	}

	return $farmart_customize->get_option_default( $name );
}

/**
 * Options of footer items
 *
 * @since 1.0.0
 *
 * @return array
 */
function footer_items_option() {
	return apply_filters('farmart_footer_items_option', array(
		'copyright' => esc_html__('Copyright', 'farmart'),
		'payment'   => esc_html__('Payments', 'farmart'),
		'social'    => esc_html__('Socials', 'farmart'),
		'menu'    	=> esc_html__('Menu', 'farmart'),
	));
}

/**
 * Options of mobile header icons
 *
 * @since 1.0.0
 *
 * @return array
 */
function mobile_header_option() {
	return apply_filters( 'farmart_mobile_header_option', array(
		'logo'     => esc_html__( 'Logo', 'farmart' ),
		'cart'     => esc_html__( 'Cart Icon', 'farmart' ),
		'wishlist' => esc_html__( 'Wishlist Icon', 'farmart' ),
		'menu'     => esc_html__( 'Menu Icon', 'farmart' ),
		'search'   => esc_html__( 'Search Icon', 'farmart' ),
	) );
}

/**
 * Move some default sections to `general` panel that registered by theme
 *
 * @param object $wp_customize
 */
function farmart_customize_modify( $wp_customize ) {
	$wp_customize->get_section( 'title_tagline' )->panel     = 'general';
	$wp_customize->get_section( 'static_front_page' )->panel = 'general';
}

add_action( 'customize_register', 'farmart_customize_modify' );


/**
 * Get customize settings
 *
 * @return array
 */
function farmart_customize_settings() {
	/**
	 * Customizer configuration
	 */
	$settings = array(
		'theme' => 'farmart',
	);

	$panels = array(
		'general' => array(
			'title'    => esc_html__( 'General', 'farmart' ),
		),

		// Typography
		'typography'  => array(
			'title'    => esc_html__( 'Typography', 'farmart' ),
		),

		// Style
		'styling'  => array(
			'title'      => esc_html__( 'Styling', 'farmart' ),
			'capability' => 'edit_theme_options',
		),

		// Header
		'header'  => array(
			'title'      => esc_html__( 'Header', 'farmart' ),
			'capability' => 'edit_theme_options',
		),

		// Page
		'pages'   => array(
			'title'      => esc_html__( 'Page', 'farmart' ),
			'capability' => 'edit_theme_options',
		),

		// Blog
		'blog'    => array(
			'title'      => esc_html__( 'Blog', 'farmart' ),
			'capability' => 'edit_theme_options',
		),

		// Footer
		'footer'  => array(
			'title'      => esc_html__( 'Footer', 'farmart' ),
			'capability' => 'edit_theme_options',
		),

		// Mobile
		'mobile_general'  => array(
			'title'      => esc_html__( 'Mobile', 'farmart' ),
			'capability' => 'edit_theme_options',
		),
	);

	$sections = array(
		// Maintenance
		'maintenance'      => array(
			'title'      => esc_html__( 'Maintenance', 'farmart' ),
			'priority'   => 5,
			'capability' => 'edit_theme_options',
		),

		// Typography Section
		'body_typo'                    => array(
			'title'       => esc_html__( 'Body', 'farmart' ),
			'description' => '',
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'panel'       => 'typography',
		),
		'heading_typo'                 => array(
			'title'       => esc_html__( 'Heading', 'farmart' ),
			'description' => '',
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'panel'       => 'typography',
		),

		// Styling
		'styling_general'  => array(
			'title'       => esc_html__( 'General', 'farmart' ),
			'description' => '',
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'panel'       => 'styling',
		),
		'color_scheme'           => array(
			'title'       => esc_html__( 'Color Scheme', 'farmart' ),
			'description' => '',
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'panel'       => 'styling',
		),

		// Header
		'topbar'                       => array(
			'title'       => esc_html__( 'Topbar', 'farmart' ),
			'description' => '',
			'panel'       => 'header',
		),

		// Header
		'header_layout'     => array(
			'title' => esc_html__( 'Header Layout', 'farmart' ),
			'panel' => 'header',
		),
		'header_main'     => array(
			'title' => esc_html__( 'Header Main', 'farmart' ),
			'panel' => 'header',
		),
		'header_bottom'     => array(
			'title' => esc_html__('Header Bottom', 'farmart'),
			'panel' => 'header',
		),
		'header_background'     => array(
			'title' => esc_html__('Header Background', 'farmart'),
			'panel' => 'header',
		),

		// Header item
		'header_logo'      => array(
			'title'       => esc_html__( 'Logo', 'farmart' ),
			'description' => '',
			'capability'  => 'edit_theme_options',
			'panel'       => 'header',
		),
		'header_search'     => array(
			'title' => esc_html__('Search', 'farmart'),
			'panel' => 'header',
		),
		'header_bar'     => array(
			'title' => esc_html__('Header Bar', 'farmart'),
			'panel' => 'header',
		),
		'header_button_primary'     => array(
			'title' => esc_html__('Button Primary', 'farmart'),
			'panel' => 'header',
		),
		'header_button_secondary'     => array(
			'title' => esc_html__('Button Secondary', 'farmart'),
			'panel' => 'header',
		),
		'header_compare'     => array(
			'title' => esc_html__('Compare', 'farmart'),
			'panel' => 'header',
		),
		'header_wishlist'     => array(
			'title' => esc_html__('Wishlist', 'farmart'),
			'panel' => 'header',
		),
		'header_cart'     => array(
			'title' => esc_html__('Cart', 'farmart'),
			'panel' => 'header',
		),
		'header_account'     => array(
			'title' => esc_html__('Account', 'farmart'),
			'panel' => 'header',
		),
		'header_menu_department'     => array(
			'title' => esc_html__('Menu Department', 'farmart'),
			'panel' => 'header',
		),
		'header_recently_product'     => array(
			'title' => esc_html__('Recently Viewed Product', 'farmart'),
			'panel' => 'header',
		),

		// 404
		'404_page'          => array(
		'title'       => esc_html__( '404 Page', 'farmart' ),
		'description' => '',
		'priority'    => 10,
		'capability'  => 'edit_theme_options',
		'panel'       => 'pages',
		),

		// Pages
		'page_header_page' => array(
			'title'       => esc_html__( 'Page Header', 'farmart' ),
			'description' => '',
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'panel'       => 'pages',
		),

		'page_header_blog' => array(
			'title'       => esc_html__( 'Blog Page Header', 'farmart' ),
			'description' => '',
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'panel'       => 'blog',
		),
		'blog_categories_list'      => array(
			'title'       => esc_html__( 'Categories Filter', 'farmart' ),
			'description' => '',
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'panel'       => 'blog',
		),
		'blog_page'        => array(
			'title'       => esc_html__( 'Blog Page', 'farmart' ),
			'description' => '',
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'panel'       => 'blog',
		),
		'single_post'      => array(
			'title'       => esc_html__( 'Single Post', 'farmart' ),
			'description' => '',
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'panel'       => 'blog',
		),
		'related_posts'      => array(
			'title'       => esc_html__( 'Related Posts', 'farmart' ),
			'description' => '',
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'panel'       => 'blog',
		),

		'backtotop'                    => array(
			'title'       => esc_html__( 'Back to Top', 'farmart' ),
			'description' => '',
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'panel'       => 'footer',
		),

		// Footer
		'footer_layout'    => array(
			'title'       => esc_html__( 'Footer Layout', 'farmart' ),
			'description' => '',
			'capability'  => 'edit_theme_options',
			'panel'       => 'footer',
		),
		'footer_background'    => array(
			'title'       => esc_html__( 'Footer Background', 'farmart' ),
			'description' => '',
			'capability'  => 'edit_theme_options',
			'panel'       => 'footer',
		),
		'footer_newsletter'    => array(
			'title'       => esc_html__( 'Footer Newsletter', 'farmart' ),
			'description' => '',
			'capability'  => 'edit_theme_options',
			'panel'       => 'footer',
		),
		'footer_extra'    => array(
			'title'       => esc_html__( 'Footer Extra', 'farmart' ),
			'description' => '',
			'capability'  => 'edit_theme_options',
			'panel'       => 'footer',
		),
		'footer_infor'    => array(
			'title'       => esc_html__( 'Footer Infor', 'farmart' ),
			'description' => '',
			'capability'  => 'edit_theme_options',
			'panel'       => 'footer',
		),
		'footer_widget'    => array(
			'title'       => esc_html__( 'Footer Widget', 'farmart' ),
			'description' => '',
			'capability'  => 'edit_theme_options',
			'panel'       => 'footer',
		),
		'footer_main'    => array(
			'title'       => esc_html__( 'Footer Main', 'farmart' ),
			'description' => '',
			'capability'  => 'edit_theme_options',
			'panel'       => 'footer',
		),
		'footer_copyright'    => array(
			'title'       => esc_html__( 'Copyright', 'farmart' ),
			'description' => '',
			'capability'  => 'edit_theme_options',
			'panel'       => 'footer',
		),
		'footer_payment'    => array(
			'title'       => esc_html__( 'Payment', 'farmart' ),
			'description' => '',
			'capability'  => 'edit_theme_options',
			'panel'       => 'footer',
		),

		// Mobile
		'mobile_header'    => array(
			'title'       => esc_html__( 'Header', 'farmart' ),
			'description' => '',
			'capability'  => 'edit_theme_options',
			'panel'       => 'mobile_general',
		),
		'mobile_logo'    => array(
			'title'       => esc_html__( 'Logo', 'farmart' ),
			'description' => '',
			'capability'  => 'edit_theme_options',
			'panel'       => 'mobile_general',
		),
		'mobile_search'    => array(
			'title'       => esc_html__( 'Search', 'farmart' ),
			'description' => '',
			'capability'  => 'edit_theme_options',
			'panel'       => 'mobile_general',
		),
		'mobile_menu'    => array(
			'title'       => esc_html__( 'Primary Menu', 'farmart' ),
			'description' => '',
			'capability'  => 'edit_theme_options',
			'panel'       => 'mobile_general',
		),
	);

	$fields = array(
		// Maintenance
		'maintenance_enable'      => array(
			'type'        => 'toggle',
			'label'       => esc_html__( 'Enable Maintenance Mode', 'farmart' ),
			'description' => esc_html__( 'Put your site into maintenance mode', 'farmart' ),
			'default'     => false,
			'section'     => 'maintenance',
		),
		'maintenance_mode'        => array(
			'type'        => 'radio',
			'label'       => esc_html__( 'Mode', 'farmart' ),
			'description' => esc_html__( 'Select the correct mode for your site', 'farmart' ),
			'tooltip'     => sprintf( __( 'If you are putting your site into maintenance mode for a longer perior of time, you should set this to "Coming Soon". Maintenance will return HTTP 503, Comming Soon will set HTTP to 200. <a href="%s" target="_blank">Learn more</a>', 'farmart' ), 'https://yoast.com/http-503-site-maintenance-seo/' ),
			'default'     => 'maintenance',
			'section'     => 'maintenance',
			'choices'     => array(
				'maintenance' => esc_attr__( 'Maintenance', 'farmart' ),
				'coming_soon' => esc_attr__( 'Coming Soon', 'farmart' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'maintenance_enable',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		'maintenance_page'        => array(
			'type'    => 'dropdown-pages',
			'label'   => esc_html__( 'Maintenance Page', 'farmart' ),
			'default' => 0,
			'section' => 'maintenance',
			'active_callback' => array(
				array(
					'setting'  => 'maintenance_enable',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		'maintenance_textcolor'   => array(
			'type'    => 'radio',
			'label'   => esc_html__( 'Text Color', 'farmart' ),
			'default' => 'dark',
			'section' => 'maintenance',
			'choices' => array(
				'dark'  => esc_attr__( 'Dark', 'farmart' ),
				'light' => esc_attr__( 'Light', 'farmart' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'maintenance_enable',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),

		// Typography
		'body_typo'                                             => array(
			'type'     => 'typography',
			'label'    => esc_html__( 'Body', 'farmart' ),
			'section'  => 'body_typo',
			'priority' => 10,
			'default'  => array(
				'font-family'    => 'Muli',
				'variant'        => '400',
				'font-size'      => '14px',
				'line-height'    => '1.7',
				'letter-spacing' => '0',
				'subsets'        => array( 'latin-ext' ),
				'color'          => '#666',
				'text-transform' => 'none',
			),
		),
		'heading1_typo'                                         => array(
			'type'     => 'typography',
			'label'    => esc_html__( 'Heading 1', 'farmart' ),
			'section'  => 'heading_typo',
			'priority' => 10,
			'default'  => array(
				'font-family'    => 'Muli',
				'variant'        => '700',
				'font-size'      => '48px',
				'line-height'    => '1.7',
				'letter-spacing' => '0',
				'subsets'        => array( 'latin-ext' ),
				'color'          => '#222',
				'text-transform' => 'none',
			),
		),
		'heading2_typo'                                         => array(
			'type'     => 'typography',
			'label'    => esc_html__( 'Heading 2', 'farmart' ),
			'section'  => 'heading_typo',
			'priority' => 10,
			'default'  => array(
				'font-family'    => 'Muli',
				'variant'        => '700',
				'font-size'      => '35px',
				'line-height'    => '1.7',
				'letter-spacing' => '0',
				'subsets'        => array( 'latin-ext' ),
				'color'          => '#222',
				'text-transform' => 'none',
			),
		),
		'heading3_typo'                                         => array(
			'type'     => 'typography',
			'label'    => esc_html__( 'Heading 3', 'farmart' ),
			'section'  => 'heading_typo',
			'priority' => 10,
			'default'  => array(
				'font-family'    => 'Muli',
				'variant'        => '700',
				'font-size'      => '21px',
				'line-height'    => '1.7',
				'letter-spacing' => '0',
				'subsets'        => array( 'latin-ext' ),
				'color'          => '#222',
				'text-transform' => 'none',
			),
		),
		'heading4_typo'                                         => array(
			'type'     => 'typography',
			'label'    => esc_html__( 'Heading 4', 'farmart' ),
			'section'  => 'heading_typo',
			'priority' => 10,
			'default'  => array(
				'font-family'    => 'Muli',
				'variant'        => '700',
				'font-size'      => '18px',
				'line-height'    => '1.7',
				'letter-spacing' => '0',
				'subsets'        => array( 'latin-ext' ),
				'color'          => '#222',
				'text-transform' => 'none',
			),
		),
		'heading5_typo'                                         => array(
			'type'     => 'typography',
			'label'    => esc_html__( 'Heading 5', 'farmart' ),
			'section'  => 'heading_typo',
			'priority' => 10,
			'default'  => array(
				'font-family'    => 'Muli',
				'variant'        => '700',
				'font-size'      => '16px',
				'line-height'    => '1.7',
				'letter-spacing' => '0',
				'subsets'        => array( 'latin-ext' ),
				'color'          => '#222',
				'text-transform' => 'none',
			),
		),
		'heading6_typo'                                         => array(
			'type'     => 'typography',
			'label'    => esc_html__( 'Heading 6', 'farmart' ),
			'section'  => 'heading_typo',
			'priority' => 10,
			'default'  => array(
				'font-family'    => 'Muli',
				'variant'        => '700',
				'font-size'      => '14px',
				'line-height'    => '1.7',
				'letter-spacing' => '0',
				'subsets'        => array( 'latin-ext' ),
				'color'          => '#222',
				'text-transform' => 'none',
			),
		),

		// Styling
		'preloader'               => array(
			'type'        => 'toggle',
			'label'       => esc_html__( 'Preloader', 'farmart' ),
			'default'     => 0,
			'section'     => 'styling_general',
			'priority'    => 10,
			'description' => esc_html__( 'Display a preloader when page is loading.', 'farmart' ),
		),

		// Color Scheme
		'color_scheme'                                     => array(
			'type'     => 'palette',
			'label'    => esc_html__( 'Base Color Scheme', 'farmart' ),
			'default'  => '#fab528',
			'section'  => 'color_scheme',
			'priority' => 10,
			'choices'  => array(
				''        => array( '#26901b' ),
				'#ff7200' => array( '#ff7200' ),
				'#80990b' => array( '#80990b' ),
				'#fab528' => array( '#fab528' ),
			),
		),
		'custom_color_scheme'                              => array(
			'type'     => 'toggle',
			'label'    => esc_html__( 'Custom Color Scheme', 'farmart' ),
			'default'  => 0,
			'section'  => 'color_scheme',
			'priority' => 10,
		),
		'custom_color'                                     => array(
			'type'            => 'color',
			'label'           => esc_html__( 'Color', 'farmart' ),
			'default'         => '',
			'section'         => 'color_scheme',
			'priority'        => 10,
			'active_callback' => array(
				array(
					'setting'  => 'custom_color_scheme',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		'color_scheme_skin'	=> array(
			'type'    => 'select',
			'label'   => esc_html__('Color Skin', 'farmart'),
			'section' => 'color_scheme',
			'default' => 'dark',
			'choices' => array(
				'dark'	=> esc_attr__( 'Dark', 'farmart' ),
				'light' => esc_attr__( 'Light', 'farmart' ),
				'custom' => esc_attr__( 'Custom', 'farmart' ),
			),
		),
		'color_scheme_skin_custom'                                     => array(
			'type'            => 'color',
			'label'           => esc_html__( 'Custom Color Skin', 'farmart' ),
			'default'         => '',
			'section'         => 'color_scheme',
			'priority'        => 10,
			'active_callback' => array(
				array(
					'setting'  => 'color_scheme_skin',
					'operator' => '==',
					'value'    => 'custom',
				),
			),
		),
		'color_scheme_custom_field_1'     => array(
			'type'    => 'custom',
			'section' => 'color_scheme',
			'default' => '<hr/>',
		),
		'secondary_color_scheme'                                     => array(
			'type'     => 'palette',
			'label'    => esc_html__( 'Secondary Color Scheme', 'farmart' ),
			'default'  => '',
			'section'  => 'color_scheme',
			'priority' => 10,
			'choices'  => array(
				''        => array( '#ff7200' ),
				'#26901b' => array( '#26901b' ),
				'#d5dee5' => array( '#d5dee5' ),
				'#fab528' => array( '#fab528' ),
			),
		),
		'custom_secondary_color_scheme'                              => array(
			'type'     => 'toggle',
			'label'    => esc_html__( 'Custom Color Scheme', 'farmart' ),
			'default'  => 0,
			'section'  => 'color_scheme',
			'priority' => 10,
		),
		'custom_secondary_color'                                     => array(
			'type'            => 'color',
			'label'           => esc_html__( 'Color', 'farmart' ),
			'default'         => '',
			'section'         => 'color_scheme',
			'priority'        => 10,
			'active_callback' => array(
				array(
					'setting'  => 'custom_secondary_color_scheme',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		'secondary_color_scheme_skin'	=> array(
			'type'    => 'select',
			'label'   => esc_html__('Color Skin', 'farmart'),
			'section' => 'color_scheme',
			'default' => 'light',
			'choices' => array(
				'dark'	=> esc_attr__( 'Dark', 'farmart' ),
				'light' => esc_attr__( 'Light', 'farmart' ),
				'custom' => esc_attr__( 'Custom', 'farmart' ),
			),
		),
		'secondary_color_scheme_skin_custom'                                     => array(
			'type'            => 'color',
			'label'           => esc_html__( 'Custom Color Skin', 'farmart' ),
			'default'         => '',
			'section'         => 'color_scheme',
			'priority'        => 10,
			'active_callback' => array(
				array(
					'setting'  => 'secondary_color_scheme_skin',
					'operator' => '==',
					'value'    => 'custom',
				),
			),
		),


		// 404
		'404_img'                      => array(
			'type'     => 'image',
			'label'    => esc_html__( '404 Image', 'farmart' ),
			'section'  => '404_page',
			'default'  => '',
			'priority' => 10,
		),

		// Topbar
		'topbar_enable'                          => array(
			'type'     => 'toggle',
			'label'    => esc_html__( 'Show Topbar', 'farmart' ),
			'section'  => 'topbar',
			'default'  => 1,
		),
		'topbar_mobile'                          => array(
			'type'     => 'toggle',
			'label'    => esc_html__( 'Show Topbar On Mobile', 'farmart' ),
			'section'  => 'topbar',
			'default'  => 0,
		),

		// Header
		'header_type'             => array(
			'type'        => 'radio',
			'label'       => esc_html__( 'Header Type', 'farmart' ),
			'description' => esc_html__( 'Select a default header or custom header', 'farmart' ),
			'section'     => 'header_layout',
			'default'     => 'default',
			'choices'     => array(
				'default' => esc_html__( 'Use pre-build header', 'farmart' ),
				'custom'  => esc_html__( 'Build my own', 'farmart' ),
			),
		),
		'header_layout_version'           => array(
			'type'            => 'select',
			'label'           => esc_html__( 'Header Layout', 'farmart' ),
			'section'         => 'header_layout',
			'default'         => 'v2',
			'choices'         => array(
				'v1' => esc_html__( 'Header v1', 'farmart' ),
				'v2' => esc_html__( 'Header v2', 'farmart' ),
				'v3' => esc_html__( 'Header v3', 'farmart' ),
				'v4' => esc_html__( 'Header v4', 'farmart' ),
				'v5' => esc_html__( 'Header v5', 'farmart' ),
				'v6' => esc_html__( 'Header v6', 'farmart' ),
				'v7' => esc_html__( 'Header v7', 'farmart' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'header_type',
					'operator' => '==',
					'value'    => 'default',
				),
			),
		),

		'header_width'	=> array(
			'type'    => 'select',
			'label'   => esc_html__('Header Width', 'farmart'),
			'section' => 'header_layout',
			'default' => 'container',
			'choices' => array(
				'container'			=> esc_attr__( 'Standard', 'farmart' ),
				'farmart-container' => esc_attr__( 'Large', 'farmart' ),
			),
		),

		// Header Sticky
		'header_sticky'                             => array(
			'type'    => 'toggle',
			'label'   => esc_html__('Sticky Header', 'farmart'),
			'default' => false,
			'section' => 'header_layout',
		),
		'header_sticky_el'                          => array(
			'type'     => 'multicheck',
			'label'    => esc_html__('Sticky Header Elements', 'farmart'),
			'section'  => 'header_layout',
			'default'  => '',
			'priority' => 10,
			'choices'  => array(
				'header_main'   => esc_html__('Header Main', 'farmart'),
				'header_bottom' => esc_html__('Header Bottom', 'farmart'),
			),
			'active_callback' => array(
				array(
					'setting'  => 'header_sticky',
					'operator' => '==',
					'value'    => true,
				),
			),
		),

		// Header Main
		'header_main_left'                          => array(
			'type'        => 'repeater',
			'label'       => esc_html__('Left Items', 'farmart'),
			'description' => esc_html__('Control items on the left side of header main', 'farmart'),
			'transport'   => 'postMessage',
			'section'     => 'header_main',
			'default'     => array(),
			'row_label'   => array(
				'type'  => 'field',
				'value' => esc_attr__('Item', 'farmart'),
				'field' => 'item',
			),
			'fields'          => array(
				'item' => array(
					'type'    => 'select',
					'choices' => get_header_items_option(),
				),
			),
			'active_callback' => array(
				array(
					'setting'  => 'header_type',
					'operator' => '==',
					'value'    => 'custom',
				),
			),
		),
		'header_main_center'                        => array(
			'type'        => 'repeater',
			'label'       => esc_html__('Center Items', 'farmart'),
			'description' => esc_html__('Control items at the center of header main', 'farmart'),
			'transport'   => 'postMessage',
			'section'     => 'header_main',
			'default'     => array(),
			'row_label'   => array(
				'type'  => 'field',
				'value' => esc_attr__('Item', 'farmart'),
				'field' => 'item',
			),
			'fields'          => array(
				'item' => array(
					'type'    => 'select',
					'choices' => get_header_items_option(),
				),
			),
			'active_callback' => array(
				array(
					'setting'  => 'header_type',
					'operator' => '==',
					'value'    => 'custom',
				),
			),
		),
		'header_main_right'                         => array(
			'type'        => 'repeater',
			'label'       => esc_html__('Right Items', 'farmart'),
			'description' => esc_html__('Control items on the right of header main', 'farmart'),
			'transport'   => 'postMessage',
			'section'     => 'header_main',
			'default'     => array(),
			'row_label'   => array(
				'type'  => 'field',
				'value' => esc_attr__('Item', 'farmart'),
				'field' => 'item',
			),
			'fields'          => array(
				'item' => array(
					'type'    => 'select',
					'choices' => get_header_items_option(),
				),
			),
			'active_callback' => array(
				array(
					'setting'  => 'header_type',
					'operator' => '==',
					'value'    => 'custom',
				),
			),
		),
		// Header Bottom
		'header_bottom_left'                        => array(
			'type'        => 'repeater',
			'label'       => esc_html__('Left Items', 'farmart'),
			'description' => esc_html__('Control items on the left side of header bottom', 'farmart'),
			'transport'   => 'postMessage',
			'section'     => 'header_bottom',
			'default'     => array(),
			'row_label'   => array(
				'type'  => 'field',
				'value' => esc_attr__('Item', 'farmart'),
				'field' => 'item',
			),
			'fields'          => array(
				'item' => array(
					'type'    => 'select',
					'choices' => get_header_items_option(),
				),
			),
			'active_callback' => array(
				array(
					'setting'  => 'header_type',
					'operator' => '==',
					'value'    => 'custom',
				),
			),
		),
		'header_bottom_center'                      => array(
			'type'        => 'repeater',
			'label'       => esc_html__('Center Items', 'farmart'),
			'description' => esc_html__('Control items at the center of header bottom', 'farmart'),
			'transport'   => 'postMessage',
			'section'     => 'header_bottom',
			'default'     => array(),
			'row_label'   => array(
				'type'  => 'field',
				'value' => esc_attr__('Item', 'farmart'),
				'field' => 'item',
			),
			'fields'          => array(
				'item' => array(
					'type'    => 'select',
					'choices' => get_header_items_option(),
				),
			),
			'active_callback' => array(
				array(
					'setting'  => 'header_type',
					'operator' => '==',
					'value'    => 'custom',
				),
			),
		),
		'header_bottom_right'                       => array(
			'type'        => 'repeater',
			'label'       => esc_html__('Right Items', 'farmart'),
			'description' => esc_html__('Control items on the right of header bottom', 'farmart'),
			'transport'   => 'postMessage',
			'section'     => 'header_bottom',
			'default'     => array(),
			'row_label'   => array(
				'type'  => 'field',
				'value' => esc_attr__('Item', 'farmart'),
				'field' => 'item',
			),
			'fields'          => array(
				'item' => array(
					'type'    => 'select',
					'choices' => get_header_items_option(),
				),
			),
			'active_callback' => array(
				array(
					'setting'  => 'header_type',
					'operator' => '==',
					'value'    => 'custom',
				),
			),
		),

		// Header Backgound
		'header_main_background'                    => array(
			'type'    => 'toggle',
			'label'   => esc_html__('Header Main Custom Color', 'farmart'),
			'section' => 'header_background',
			'default' => 0,
		),
		'header_main_background_color'              => array(
			'type'            => 'color',
			'label'           => esc_html__('Background Color', 'farmart'),
			'default'         => '',
			'transport'       => 'postMessage',
			'section'         => 'header_background',
			'active_callback' => array(
				array(
					'setting'  => 'header_main_background',
					'operator' => '==',
					'value'    => '1',
				),
			),
			'js_vars'         => array(
				array(
					'element'  => '.site-header .header-main',
					'property' => 'background-color',
				),
			),
		),
		'header_main_background_text_color'         => array(
			'type'            => 'color',
			'label'           => esc_html__('Text Color', 'farmart'),
			'default'         => '',
			'transport'       => 'postMessage',
			'section'         => 'header_background',
			'active_callback' => array(
				array(
					'setting'  => 'header_main_background',
					'operator' => '==',
					'value'    => '1',
				),
			),
			'js_vars'         => array(
				array(
					'element'  => '.site-header .header-main',
					'property' => '--fm-background-text-color-primary',
				),
				array(
					'element'  => '.site-header .header-main',
					'property' => '--fm-background-text-color-secondary',
				),
				array(
					'element'  => '.site-header .header-main',
					'property' => '--farmart-header-text-color',
				),
			),
		),
		'header_main_color_hover'   => array(
			'type'            => 'color',
			'label'           => esc_html__('Text Hover Color', 'farmart'),
			'default'         => '',
			'transport'       => 'postMessage',
			'section'         => 'header_background',
			'active_callback' => array(
				array(
					'setting'  => 'header_main_background',
					'operator' => '==',
					'value'    => '1',
				),
			),
			'js_vars'         => array(
				array(
					'element'  => '.site-header .header-main',
					'property' => '--farmart-header-text-hover-color',
				),
			),
		),
		'header_background_hr'                      => array(
			'type'    => 'custom',
			'section' => 'header_background',
			'default' => '<hr>',
		),
		'header_bottom_background'                  => array(
			'type'    => 'toggle',
			'label'   => esc_html__('Header Bottom Custom Color', 'farmart'),
			'section' => 'header_background',
			'default' => 0,
		),
		'header_bottom_background_color'            => array(
			'type'            => 'color',
			'label'           => esc_html__('Background Color', 'farmart'),
			'default'         => '',
			'transport'       => 'postMessage',
			'section'         => 'header_background',
			'active_callback' => array(
				array(
					'setting'  => 'header_bottom_background',
					'operator' => '==',
					'value'    => '1',
				),
			),
			'js_vars'         => array(
				array(
					'element'  => '.site-header .header-bottom',
					'property' => 'background-color',
				),
			),
		),
		'header_bottom_background_text_color'       => array(
			'type'            => 'color',
			'label'           => esc_html__('Text Color', 'farmart'),
			'default'         => '',
			'transport'       => 'postMessage',
			'section'         => 'header_background',
			'active_callback' => array(
				array(
					'setting'  => 'header_bottom_background',
					'operator' => '==',
					'value'    => '1',
				),
			),
			'js_vars'         => array(
				'js_vars'         => array(
					array(
						'element'  => '.site-header .header-bottom',
						'property' => '--fm-background-text-color-primary',
					),
					array(
						'element'  => '.site-header .header-bottom',
						'property' => '--fm-background-text-color-secondary',
					),
					array(
						'element'  => '.site-header .header-bottom',
						'property' => '--farmart-header-text-color',
					),
				),
			),
		),
		'header_bottom_color_hover' => array(
			'type'            => 'color',
			'label'           => esc_html__('Text Hover Color', 'farmart'),
			'default'         => '',
			'transport'       => 'postMessage',
			'section'         => 'header_background',
			'active_callback' => array(
				array(
					'setting'  => 'header_bottom_background',
					'operator' => '==',
					'value'    => '1',
				),
			),
			'js_vars'         => array(
				array(
					'element'  => '.site-header .header-bottom',
					'property' => '--farmart-header-text-hover',
				),
			),
		),

		// Logo
		'logo_type'                                 => array(
			'type'    => 'radio',
			'label'   => esc_html__( 'Logo Type', 'farmart' ),
			'default' => 'image',
			'section' => 'header_logo',
			'choices' => array(
				'image' => esc_html__( 'Image', 'farmart' ),
				'svg'   => esc_html__( 'SVG', 'farmart' ),
				'text'  => esc_html__( 'Text', 'farmart' ),
			),
		),
		'logo_svg'                                  => array(
			'type'              => 'textarea',
			'label'             => esc_html__( 'Logo SVG', 'farmart' ),
			'section'           => 'header_logo',
			'description'       => esc_html__( 'Paste SVG code of your logo here', 'farmart' ),
			'sanitize_callback' => 'Farmart\Icon::sanitize_svg',
			'output'            => array(
				array(
					'element' => '.site-branding .logo',
				),
			),
			'active_callback'   => array(
				array(
					'setting'  => 'logo_type',
					'operator' => '==',
					'value'    => 'svg',
				),
			),
		),
		'logo'                                      => array(
			'type'            => 'image',
			'label'           => esc_html__( 'Logo', 'farmart' ),
			'default'         => '',
			'section'         => 'header_logo',
			'active_callback' => array(
				array(
					'setting'  => 'logo_type',
					'operator' => '==',
					'value'    => 'image',
				),
			),
		),
		'logo_text'                                 => array(
			'type'            => 'textarea',
			'label'           => esc_html__( 'Logo Text', 'farmart' ),
			'default'         => '',
			'section'         => 'header_logo',
			'output'          => array(
				array(
					'element' => '.site-branding .logo',
				),
			),
			'active_callback' => array(
				array(
					'setting'  => 'logo_type',
					'operator' => '==',
					'value'    => 'text',
				),
			),
		),
		'logo_dimension'                            => array(
			'type'            => 'dimensions',
			'label'           => esc_html__( 'Logo Dimension', 'farmart' ),
			'default'         => array(
				'width'  => '',
				'height' => '',
			),
			'section'         => 'header_logo',
			'active_callback' => array(
				array(
					'setting'  => 'logo_type',
					'operator' => '!=',
					'value'    => 'text',
				),
				array(
					'setting'  => 'logo_type',
					'operator' => '!=',
					'value'    => 'svg',
				),
			),
		),

		// Header Search
		'header_search_layout'                        => array(
			'type'    => 'select',
			'label'   => esc_html__('Search Layout', 'farmart'),
			'default' => 'icon',
			'section' => 'header_search',
			'choices' => array(
				'icon'   => esc_html__('Icon Only', 'farmart'),
				'form'	 => esc_html__('Search form', 'farmart'),
			),
		),
		'header_search_custom_field_1'              => array(
			'type'            => 'custom',
			'section'         => 'header_search',
			'default'         => '<hr/>',
		),
		'header_search_type'                        => array(
			'type'    => 'select',
			'label'   => esc_html__('Search For', 'farmart'),
			'default' => '',
			'section' => 'header_search',
			'choices' => array(
				''        => esc_html__('Search for everything', 'farmart'),
				'product' => esc_html__('Search for products', 'farmart'),
			),
		),
		'header_search_custom_field_2'              => array(
			'type'            => 'custom',
			'section'         => 'header_search',
			'default'         => '<hr/>',
		),

		'header_search_button_type'                        => array(
			'type'    => 'select',
			'label'   => esc_html__('Button Type', 'farmart'),
			'default' => 'icon',
			'section' => 'header_search',
			'choices' => array(
				'icon'      => esc_html__('Icon', 'farmart'),
				'text' 		=> esc_html__('Text', 'farmart'),
			),
		),
		'header_search_button_text'                 => array(
			'type'    => 'text',
			'label'   => esc_html__('Button Text', 'farmart'),
			'section' => 'header_search',
			'default' => esc_html__( 'Search', 'farmart' ),
			'active_callback' => array(
				array(
					'setting'  => 'header_search_button_type',
					'operator' => '==',
					'value'    => 'text',
				),
			),
		),

		'header_search_custom_field_5'              => array(
			'type'            => 'custom',
			'section'         => 'header_search',
			'default'         => '<hr/>',
		),
		'header_search_placeholder'                 => array(
			'type'    => 'text',
			'label'   => esc_html__('Placeholder', 'farmart'),
			'section' => 'header_search',
			'default' => esc_html__( 'I’m searching for...', 'farmart' ),
		),
		'header_search_category_position'                        => array(
			'type'    => 'select',
			'label'   => esc_html__('Category Position', 'farmart'),
			'default' => 'left',
			'section' => 'header_search',
			'choices' => array(
				'left'  => esc_html__('Left', 'farmart'),
				'right' => esc_html__('Right', 'farmart'),
			),
			'active_callback' => array(
				array(
					'setting'  => 'header_search_type',
					'operator' => '==',
					'value'    => 'product',
				),
				array(
					'setting'  => 'header_search_layout',
					'operator' => '==',
					'value'    => 'form',
				),
			),
		),
		'header_search_category_depth'                      => array(
			'type'            => 'number',
			'label'           => esc_html__('Category Depth', 'farmart'),
			'default'         => 2,
			'section'         => 'header_search',
			'active_callback' => array(
				array(
					'setting'  => 'header_search_type',
					'operator' => '==',
					'value'    => 'product',
				),
				array(
					'setting'  => 'header_search_layout',
					'operator' => '==',
					'value'    => 'form',
				),
			),
		),
		'header_search_category_include'   => array(
			'type'            => 'text',
			'section'         => 'header_search',
			'label'           => esc_html__( 'Category Include', 'farmart' ),
			'default'         => '',
			'multiple'        => 999,
			'active_callback' => array(
				array(
					'setting'  => 'header_search_type',
					'operator' => '==',
					'value'    => 'product',
				),
			),
		),
		'header_search_category_exclude'   => array(
			'type'            => 'text',
			'section'         => 'header_search',
			'label'           => esc_html__( 'Category Exclude', 'farmart' ),
			'default'         => '',
			'multiple'        => 999,
			'active_callback' => array(
				array(
					'setting'  => 'header_search_type',
					'operator' => '==',
					'value'    => 'product',
				),
			),
		),

		'header_search_custom_field_3'              => array(
			'type'            => 'custom',
			'section'         => 'header_search',
			'default'         => '<hr/>',
		),

		'header_search_hot_enable'                          => array(
			'type'     => 'toggle',
			'label'    => esc_html__( 'Hot Enable', 'farmart' ),
			'section'  => 'header_search',
			'default'  => 0,
		),
		'header_search_hot_items' => array(
			'type'      => 'repeater',
			'label'     => esc_html__('Hot Items', 'farmart'),
			'section'   => 'header_search',
			'row_label' => array(
				'type'  => 'text',
				'value' => esc_html__('Item', 'farmart'),
			),
			'fields'    => array(
				'text'  => array(
					'type'    => 'text',
					'label'   => esc_html__('Text', 'farmart'),
					'default' => '',
				),
				'link'  => array(
					'type'    => 'text',
					'label'   => esc_html__('Url', 'farmart'),
					'default' => '',
				),
			),
			'active_callback' => array(
				array(
					'setting'  => 'header_search_type',
					'operator' => '==',
					'value'    => 'product',
				),
				array(
					'setting'  => 'header_search_layout',
					'operator' => '==',
					'value'    => 'form',
				),
				array(
					'setting'  => 'header_search_hot_enable',
					'operator' => '==',
					'value'    => '1',
				),
			),
		),

		'header_search_custom_field_4'              => array(
			'type'            => 'custom',
			'section'         => 'header_search',
			'default'         => '<hr/>',
		),
		'header_search_ajax'                        => array(
			'type'        => 'toggle',
			'label'       => esc_html__('AJAX Search', 'farmart'),
			'section'     => 'header_search',
			'default'     => 0,
			'description' => esc_html__('Check this option to enable AJAX search in the header', 'farmart'),
		),
		'header_search_number'                      => array(
			'type'            => 'number',
			'label'           => esc_html__('AJAX Product Numbers', 'farmart'),
			'default'         => 6,
			'section'         => 'header_search',
			'active_callback' => array(
				array(
					'setting'  => 'header_search_ajax',
					'operator' => '==',
					'value'    => '1',
				),
			),
		),
		'header_search_button_custom_color'     => array(
			'type'        => 'toggle',
			'label'       => esc_html__( 'Enable Button Custom Color', 'farmart' ),
			'section'     => 'header_search',
			'default'     => 0,
		),
		'header_search_button_custom_color_text'              => array(
			'type'            => 'color',
			'label'           => esc_html__('Text Color', 'farmart'),
			'default'         => '',
			'transport'       => 'postMessage',
			'section'         => 'header_search',
			'active_callback' => array(
				array(
					'setting'  => 'header_search_button_custom_color',
					'operator' => '==',
					'value'    => '1',
				),
			),
			'js_vars'         => array(
				array(
					'element'  => '.farmart-products-search .search-submit',
					'property' => '--farmart-header-background-text-color-secondary',
				),
			),
		),
		'header_search_button_custom_color_background'              => array(
			'type'            => 'color',
			'label'           => esc_html__('Background Color', 'farmart'),
			'default'         => '',
			'transport'       => 'postMessage',
			'section'         => 'header_search',
			'active_callback' => array(
				array(
					'setting'  => 'header_search_button_custom_color',
					'operator' => '==',
					'value'    => '1',
				),
			),
			'js_vars'         => array(
				array(
					'element'  => '.farmart-products-search .search-submit',
					'property' => '--farmart-header-background-color-secondary',
				),
			),
		),

		// Header Bar
		'header_bar_icon'  => array(
			'type'    => 'textarea',
			'label'   => esc_html__('Header Bar Icon', 'farmart'),
			'description' => esc_html__('Show Icon svg in header','farmart'),
			'sanitize_callback' => 'Farmart\Icon::sanitize_svg',
			'default' => '',
			'section' => 'header_bar',
		),
		'header_bar_text'  => array(
			'type'    => 'textarea',
			'label'   => esc_html__('Header Bar Text', 'farmart'),
			'description' => esc_html__('Show HTML or Text in header','farmart'),
			'default' => '',
			'section' => 'header_bar',
		),

		// Header Button
		'header_button_primary_text'  => array(
			'type'    => 'text',
			'label'   => esc_html__('Primary Button Text', 'farmart'),
			'description' => esc_html__('Show button text primary','farmart'),
			'default' => '',
			'section' => 'header_button_primary',
		),
		'header_button_primary_link'  => array(
			'type'    => 'text',
			'label'   => esc_html__('Primary Button Link', 'farmart'),
			'description' => esc_html__('Show button link primary','farmart'),
			'default' => '',
			'section' => 'header_button_primary',
		),
		'header_button_primary_bg_color'            => array(
			'type'            => 'color',
			'label'           => esc_html__('Background Color', 'farmart'),
			'default'         => '',
			'transport'       => 'postMessage',
			'section'         => 'header_button_primary',
			'js_vars'         => array(
				array(
					'element'  => '.header-element--primary-button a',
					'property' => 'background-color',
				),
			),
		),
		'header_button_primary_color'            => array(
			'type'            => 'color',
			'label'           => esc_html__('Color', 'farmart'),
			'default'         => '',
			'transport'       => 'postMessage',
			'section'         => 'header_button_primary',
			'js_vars'         => array(
				array(
					'element'  => '.header-element--primary-button a',
					'property' => 'color',
				),
			),
		),
		'header_button_primary_border_color'            => array(
			'type'            => 'color',
			'label'           => esc_html__('Border Color', 'farmart'),
			'default'         => '',
			'transport'       => 'postMessage',
			'section'         => 'header_button_primary',
			'js_vars'         => array(
				array(
					'element'  => '.header-element--primary-button a',
					'property' => 'border-color',
				),
			),
		),
		'header_button_secondary_text'  => array(
			'type'    => 'text',
			'label'   => esc_html__('Secondary Button Text', 'farmart'),
			'description' => esc_html__('Show button text secondary','farmart'),
			'default' => '',
			'section' => 'header_button_secondary',
		),
		'header_button_secondary_link'  => array(
			'type'    => 'text',
			'label'   => esc_html__('Secondary Button Link', 'farmart'),
			'description' => esc_html__('Show button link secondary','farmart'),
			'default' => '',
			'section' => 'header_button_secondary',
		),
		'header_button_secondary_bg_color'            => array(
			'type'            => 'color',
			'label'           => esc_html__('Background Color', 'farmart'),
			'default'         => '',
			'transport'       => 'postMessage',
			'section'         => 'header_button_secondary',
			'js_vars'         => array(
				array(
					'element'  => '.header-element--secondary-button a',
					'property' => 'background-color',
				),
			),
		),
		'header_button_secondary_color'            => array(
			'type'            => 'color',
			'label'           => esc_html__('Color', 'farmart'),
			'default'         => '',
			'transport'       => 'postMessage',
			'section'         => 'header_button_secondary',
			'js_vars'         => array(
				array(
					'element'  => '.header-element--secondary-button a',
					'property' => 'color',
				),
			),
		),
		'header_button_secondary_border_color'            => array(
			'type'            => 'color',
			'label'           => esc_html__('Border Color', 'farmart'),
			'default'         => '',
			'transport'       => 'postMessage',
			'section'         => 'header_button_secondary',
			'js_vars'         => array(
				array(
					'element'  => '.header-element--secondary-button a',
					'property' => 'border-color',
				),
			),
		),

		// Compare
		'header_compare_counter'  => array(
			'type'        => 'toggle',
			'label'       => esc_html__('Enable counter', 'farmart'),
			'section'     => 'header_compare',
			'default'     => 1,
		),
		'header_compare_custom_color'  => array(
			'type'        => 'toggle',
			'label'       => esc_html__('Enable custom color', 'farmart'),
			'section'     => 'header_compare',
			'default'     => 0,
			'active_callback' => array(
				array(
					'setting'  => 'header_compare_counter',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		'header_compare_custom_color_text'            => array(
			'type'            => 'color',
			'label'           => esc_html__('Text Color', 'farmart'),
			'default'         => '',
			'transport'       => 'postMessage',
			'section'         => 'header_compare',
			'active_callback' => array(
				array(
					'setting'  => 'header_compare_counter',
					'operator' => '==',
					'value'    => 1,
				),
				array(
					'setting'  => 'header_compare_custom_color',
					'operator' => '==',
					'value'    => 1,
				),
			),
			'js_vars'         => array(
				array(
					'element'  => '.header-element--compare .mini-item-counter',
					'property' => 'color',
				),
			),
		),
		'header_compare_custom_color_background'            => array(
			'type'            => 'color',
			'label'           => esc_html__('Background Color', 'farmart'),
			'default'         => '',
			'transport'       => 'postMessage',
			'section'         => 'header_compare',
			'active_callback' => array(
				array(
					'setting'  => 'header_compare_counter',
					'operator' => '==',
					'value'    => 1,
				),
				array(
					'setting'  => 'header_compare_custom_color',
					'operator' => '==',
					'value'    => 1,
				),
			),
			'js_vars'         => array(
				array(
					'element'  => '.header-element--compare .mini-item-counter',
					'property' => 'background-color',
				),
			),
		),

		// Wishlist
		'header_wishlist_counter'  => array(
			'type'        => 'toggle',
			'label'       => esc_html__('Enable counter', 'farmart'),
			'section'     => 'header_wishlist',
			'default'     => 1,
		),
		'header_wishlist_custom_color'  => array(
			'type'        => 'toggle',
			'label'       => esc_html__('Enable custom color', 'farmart'),
			'section'     => 'header_wishlist',
			'default'     => 0,
			'active_callback' => array(
				array(
					'setting'  => 'header_wishlist_counter',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		'header_wishlist_custom_color_text'            => array(
			'type'            => 'color',
			'label'           => esc_html__('Text Color', 'farmart'),
			'default'         => '',
			'transport'       => 'postMessage',
			'section'         => 'header_wishlist',
			'active_callback' => array(
				array(
					'setting'  => 'header_wishlist_counter',
					'operator' => '==',
					'value'    => 1,
				),
				array(
					'setting'  => 'header_wishlist_custom_color',
					'operator' => '==',
					'value'    => 1,
				),
			),
			'js_vars'         => array(
				array(
					'element'  => '.header-element--wishlist .mini-item-counter',
					'property' => 'color',
				),
			),
		),
		'header_wishlist_custom_color_background'            => array(
			'type'            => 'color',
			'label'           => esc_html__('Background Color', 'farmart'),
			'default'         => '',
			'transport'       => 'postMessage',
			'section'         => 'header_wishlist',
			'active_callback' => array(
				array(
					'setting'  => 'header_wishlist_counter',
					'operator' => '==',
					'value'    => 1,
				),
				array(
					'setting'  => 'header_wishlist_custom_color',
					'operator' => '==',
					'value'    => 1,
				),
			),
			'js_vars'         => array(
				array(
					'element'  => '.header-element--wishlist .mini-item-counter',
					'property' => 'background-color',
				),
			),
		),

		// Cart Header
		'header_cart_behaviour' => array(
			'type'    => 'radio',
			'label'   => esc_html__( 'Cart Behaviour', 'farmart' ),
			'default' => 'page',
			'section' => 'header_cart',
			'choices' => array(
				'page' => esc_attr__( 'Open the cart page', 'farmart' ),
				'panel' => esc_attr__( 'Open the cart panel', 'farmart' ),
			),
		),
		'header_cart_custom_field_2' => array(
			'type'    => 'custom',
			'section' => 'header_cart',
			'default' => '<hr/',
			'active_callback' => array(
				array(
					'setting'  => 'header_cart_behaviour',
					'operator' => '==',
					'value'    => 'panel',
				),
			),
		),
		'header_cart_side_type'                       => array(
			'type'    => 'select',
			'label'   => esc_html__('Show Menu', 'farmart'),
			'section' => 'header_cart',
			'default' => 'side-left',
			'choices' => array(
				'side-left'  => esc_html__('Side to right', 'farmart'),
				'side-right' => esc_html__('Side to left', 'farmart'),
			),
			'active_callback' => array(
				array(
					'setting'  => 'header_cart_behaviour',
					'operator' => '==',
					'value'    => 'panel',
				),
			),
		),
		'header_cart_custom_field_3' => array(
			'type'    => 'custom',
			'section' => 'header_cart',
			'default' => '<hr/',
		),
		'header_cart_total'     => array(
			'type'        => 'toggle',
			'label'       => esc_html__( 'Enable Total Price', 'farmart' ),
			'description' => esc_html__( 'Enable total price next to the icon or text on the header.', 'farmart' ),
			'section'     => 'header_cart',
			'default'     => 1,
		),
		'header_cart_custom_field_3' => array(
			'type'    => 'custom',
			'section' => 'header_cart',
			'default' => '<hr/',
		),
		'header_cart_counter'     => array(
			'type'        => 'toggle',
			'label'       => esc_html__( 'Enable Counter', 'farmart' ),
			'description' => esc_html__( 'Enable counter on top the icon.', 'farmart' ),
			'section'     => 'header_cart',
			'default'     => 1,
		),
		'header_cart_counter_custom_color'     => array(
			'type'        => 'toggle',
			'label'       => esc_html__( 'Enable Custom Color', 'farmart' ),
			'section'     => 'header_cart',
			'default'     => 0,
			'active_callback' => array(
				array(
					'setting'  => 'header_cart_counter',
					'operator' => '==',
					'value'    => '1',
				),
			),
		),
		'header_cart_counter_custom_color_text'              => array(
			'type'            => 'color',
			'label'           => esc_html__('Text Color Counter', 'farmart'),
			'default'         => '',
			'transport'       => 'postMessage',
			'section'         => 'header_cart',
			'active_callback' => array(
				array(
					'setting'  => 'header_cart_counter_custom_color',
					'operator' => '==',
					'value'    => '1',
				),
				array(
					'setting'  => 'header_cart_counter',
					'operator' => '==',
					'value'    => '1',
				),
			),
			'js_vars'         => array(
				array(
					'element'  => '.header-element--cart .cart-contents .fm-mini-cart-counter',
					'property' => 'color',
				),
			),
		),
		'header_cart_counter_custom_color_background'              => array(
			'type'            => 'color',
			'label'           => esc_html__('Background Color Counter', 'farmart'),
			'default'         => '',
			'transport'       => 'postMessage',
			'section'         => 'header_cart',
			'active_callback' => array(
				array(
					'setting'  => 'header_cart_counter_custom_color',
					'operator' => '==',
					'value'    => '1',
				),
				array(
					'setting'  => 'header_cart_counter',
					'operator' => '==',
					'value'    => '1',
				),
			),
			'js_vars'         => array(
				array(
					'element'  => '.header-element--cart .cart-contents .fm-mini-cart-counter',
					'property' => 'background-color',
				),
			),
		),

		// Account
		'header_account_text'     => array(
			'type'        => 'toggle',
			'label'       => esc_html__( 'Enable Text', 'farmart' ),
			'section'     => 'header_account',
			'default'     => 0,
		),

		// Menu Department
		'header_menu_department_menu'       => array(
			'type'            => 'select',
			'label'           => esc_html__( 'Select Menu', 'farmart' ),
			'section'         => 'header_menu_department',
			'default'         => '',
			'choices'         => farmart_select_menus(),

		),
		'header_menu_department_text'     => array(
			'type'        => 'toggle',
			'label'       => esc_html__( 'Enable text', 'farmart' ),
			'section'     => 'header_menu_department',
			'default'     => 1,
		),
		'header_menu_department_text_input'                  => array(
			'type'            => 'text',
			'section'         => 'header_menu_department',
			'default'         => esc_html__( 'Shop By Category', 'farmart' ),
			'active_callback' => array(
				array(
					'setting'  => 'header_menu_department_text',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		'header_menu_department_dropdown_icon'     => array(
			'type'        => 'toggle',
			'label'       => esc_html__( 'Enable Dropdown Icon', 'farmart' ),
			'section'     => 'header_menu_department',
			'default'     => 0,
		),
		'header_menu_department_dropdown'     => array(
			'type'        => 'toggle',
			'label'       => esc_html__( 'Enable Open On Homepage ', 'farmart' ),
			'description' => esc_html__( 'If enabled, the dropdown list will always appear on the homepage.', 'farmart' ),
			'section'     => 'header_menu_department',
			'default'     => 0,
		),
		'header_menu_department_custom_field_1'     => array(
			'type'    => 'custom',
			'section' => 'header_menu_department',
			'default' => '<hr/>',
		),
		'header_menu_department_bg_color'                                     => array(
			'type'            => 'color',
			'label'           => esc_html__( 'Background Color', 'farmart' ),
			'default'         => '',
			'section'         => 'header_menu_department',
			'transport'       => 'postMessage',
			'js_vars'         => array(
				array(
					'element'  => '.site-header .farmart-menu-department',
					'property' => 'background-color',
				),
			),
		),
		'header_menu_department_color'                                     => array(
			'type'            => 'color',
			'label'           => esc_html__( 'Color', 'farmart' ),
			'default'         => '',
			'section'         => 'header_menu_department',
			'transport'       => 'postMessage',
			'js_vars'         => array(
				array(
					'element'  => '.site-header .farmart-menu-department',
					'property' => 'color',
				),
			),
		),
		'header_menu_department_spacing'                            => array(
			'type'            => 'dimensions',
			'label'           => esc_html__( 'Spacing', 'farmart' ),
			'section'         => 'header_menu_department',
			'transport' 	  => 'refresh',
			'choices'   	  => array(
				'top' 		=> esc_html__( 'Top (px, em, %)', 'farmart' ),
				'bottom' 	=> esc_html__( 'Bottom (px, em, %)', 'farmart' ),
				'right' 	=> esc_html__( 'Right (px, em, %)', 'farmart' ),
				'left' 		=> esc_html__( 'Left (px, em, %)', 'farmart' ),
			),
			'default' => array(
				'top' 		=> '',
				'right' 	=> '',
				'bottom' 	=> '',
				'left' 		=> '',
			),
		),

		// Recently view product
		'header_recently_product_text'                  => array(
			'type'            => 'text',
			'section'         => 'header_recently_product',
			'default'         => esc_html__( 'Recently Viewed', 'farmart' ),
		),

		// Page
		'page_header_page'        => array(
			'type'        => 'toggle',
			'default'     => 1,
			'label'       => esc_html__( 'Enable Page Header', 'farmart' ),
			'section'     => 'page_header_page',
			'description' => esc_html__( 'Enable to show a page header for the page below the site header', 'farmart' ),
			'priority'    => 10,
		),

		'page_header_page_layout' => array(
			'type'            => 'select',
			'label'           => esc_html__( 'Page Header Layout', 'farmart' ),
			'section'         => 'page_header_page',
			'default'         => '1',
			'priority'        => 10,
			'description'     => esc_html__( 'Select default layout for page header.', 'farmart' ),
			'choices'         => array(
				'1' => esc_html__( 'Layout 1', 'farmart' ),
				'2' => esc_html__( 'Layout 2', 'farmart' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'page_header_page',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),

		'page_header_pages_els'   => array(
			'type'            => 'multicheck',
			'label'           => esc_html__( 'Page Header Elements', 'farmart' ),
			'section'         => 'page_header_page',
			'default'         => array( 'breadcrumb', 'title' ),
			'priority'        => 10,
			'choices'         => array(
				'breadcrumb' => esc_html__( 'BreadCrumb', 'farmart' ),
				'title'      => esc_html__( 'Title', 'farmart' ),
			),
			'description'     => esc_html__( 'Select which elements you want to show.', 'farmart' ),
			'active_callback' => array(
				array(
					'setting'  => 'page_header_page',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),

		// Blog Page Header
		'page_header_blog'        => array(
			'type'        => 'toggle',
			'default'     => 1,
			'label'       => esc_html__( 'Enable Page Header', 'farmart' ),
			'section'     => 'page_header_blog',
			'description' => esc_html__( 'Enable to show a page header for the blog page below the site header', 'farmart' ),
			'priority'    => 10,
		),

		'page_header_blog_layout' => array(
			'type'            => 'select',
			'label'           => esc_html__( 'Blog Layout', 'farmart' ),
			'section'         => 'page_header_blog',
			'default'         => '1',
			'priority'        => 10,
			'description'     => esc_html__( 'Select default layout for page header.', 'farmart' ),
			'choices'         => array(
				'1' => esc_html__( 'Layout 1', 'farmart' ),
				'2' => esc_html__( 'Layout 2', 'farmart' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'page_header_blog',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),

		'page_header_blog_els'    => array(
			'type'            => 'multicheck',
			'label'           => esc_html__( 'Page Header Elements', 'farmart' ),
			'section'         => 'page_header_blog',
			'default'         => array( 'breadcrumb', 'title' ),
			'priority'        => 10,
			'choices'         => array(
				'breadcrumb' => esc_html__( 'BreadCrumb', 'farmart' ),
				'title'      => esc_html__( 'Title', 'farmart' ),
			),
			'description'     => esc_html__( 'Select which elements you want to show.', 'farmart' ),
			'active_callback' => array(
				array(
					'setting'  => 'page_header_blog',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),

		// Blog
		'blog_view'               => array(
			'type'     => 'select',
			'label'    => esc_html__( 'Blog View', 'farmart' ),
			'section'  => 'blog_page',
			'default'  => 'small-thumb',
			'priority' => 10,
			'choices'  => array(
				'default'     => esc_html__( 'Default', 'farmart' ),
				'small-thumb' => esc_html__( 'Small Thumbnail', 'farmart' ),
				'grid'        => esc_html__( 'Grid', 'farmart' ),
				'list'        => esc_html__( 'Listing', 'farmart' ),
			),
		),

		'blog_columns'               => array(
			'type'     => 'select',
			'label'    => esc_html__( 'Columns', 'farmart' ),
			'section'  => 'blog_page',
			'default'  => '3',
			'priority' => 10,
			'choices'  => array(
				'2'     => esc_html__( '2 Columns', 'farmart' ),
				'3'     => esc_html__( '3 Columns', 'farmart' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'blog_view',
					'operator' => '==',
					'value'    => 'grid',
				),
			),
		),

		'blog_layout'             => array(
			'type'            => 'select',
			'label'           => esc_html__( 'Blog Layout', 'farmart' ),
			'section'         => 'blog_page',
			'default'         => 'content-sidebar',
			'priority'        => 10,
			'description'     => esc_html__( 'Select default sidebar for the blog page.', 'farmart' ),
			'choices'         => array(
				'content-sidebar' => esc_html__( 'Right Sidebar', 'farmart' ),
				'sidebar-content' => esc_html__( 'Left Sidebar', 'farmart' ),
				'full-content'    => esc_html__( 'Full Content', 'farmart' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'blog_view',
					'operator' => 'in',
					'value'    => array( 'default', 'small-thumb' ),
				),
			),
		),
		'blog_entry_meta'         => array(
			'type'     => 'multicheck',
			'label'    => esc_html__( 'Entry Meta', 'farmart' ),
			'section'  => 'blog_page',
			'default'  => array( 'author', 'date', 'cat' ),
			'choices'  => array(
				'author'  => esc_html__( 'Author', 'farmart' ),
				'date'    => esc_html__( 'Date', 'farmart' ),
				'cat'     => esc_html__( 'Cat', 'farmart' ),
				'comment' => esc_html__( 'Comment', 'farmart' ),
			),
			'priority' => 10,
		),

		'excerpt_length'          => array(
			'type'     => 'number',
			'label'    => esc_html__( 'Excerpt Length', 'farmart' ),
			'section'  => 'blog_page',
			'default'  => 30,
			'priority' => 10,
			'active_callback' => array(
				array(
					'setting'  => 'blog_view',
					'operator' => '!=',
					'value'    => 'grid',
				),
			),
		),

		'blog_custom_field_1'     => array(
			'type'    => 'custom',
			'section' => 'blog_page',
			'default' => '<hr/>',
		),

		'navigation_type'                 => array(
			'type'        => 'select',
			'label'       => esc_html__( 'Type Navigation', 'farmart' ),
			'section'     => 'blog_page',
			'default'     => 'numberic',
			'priority'    => 10,
			'description' => esc_html__( 'Select default type navigation for the blog page.', 'farmart' ),
			'choices'     => array(
				'numberic'  => esc_html__( 'Numberic', 'farmart' ),
				'loading'   => esc_html__( 'Loading Scroll', 'farmart' ),
			),
		),

		'view_more_text'                  => array(
			'type'            => 'text',
			'label'           => esc_html__( 'View More Text', 'farmart' ),
			'section'         => 'blog_page',
			'default'         => esc_html__( 'LOADING', 'farmart' ),
			'priority'        => 10,
			'active_callback' => array(
				array(
					'setting'  => 'navigation_type',
					'operator' => '==',
					'value'    => 'loading',
				),
			),
		),
		// Single Post
		'single_post_layout'      => array(
			'type'        => 'select',
			'label'       => esc_html__( 'Single Post Layout', 'farmart' ),
			'section'     => 'single_post',
			'default'     => 'full-content',
			'priority'    => 10,
			'description' => esc_html__( 'Select default sidebar for the single post page.', 'farmart' ),
			'choices'     => array(
				'content-sidebar' => esc_html__( 'Right Sidebar', 'farmart' ),
				'sidebar-content' => esc_html__( 'Left Sidebar', 'farmart' ),
				'full-content'    => esc_html__( 'Full Content', 'farmart' ),
			),
		),
		'post_custom_field_1'     => array(
			'type'    => 'custom',
			'section' => 'single_post',
			'default' => '<hr/>',
		),
		'single_featured_image' => array(
			'type'     => 'toggle',
			'label'    => esc_html__( 'Show Featured Image', 'farmart' ),
			'section'  => 'single_post',
			'default'  => '0',
			'priority' => 10,
		),
		'single_post_format' => array(
			'type'     => 'toggle',
			'label'    => esc_html__( 'Show Post Format', 'farmart' ),
			'section'  => 'single_post',
			'default'  => 1,
			'priority' => 10,
		),
		'show_author_box'         => array(
			'type'     => 'toggle',
			'label'    => esc_html__( 'Show Author Box', 'farmart' ),
			'section'  => 'single_post',
			'default'  => 0,
			'priority' => 10,
		),
		'show_post_navigation'    => array(
			'type'     => 'toggle',
			'label'    => esc_html__( 'Show Post Navigation', 'farmart' ),
			'section'  => 'single_post',
			'default'  => 1,
			'priority' => 10,
		),
		'post_custom_field_2'     => array(
			'type'    => 'custom',
			'section' => 'single_post',
			'default' => '<hr/>',
		),
		'post_entry_meta'         => array(
			'type'     => 'multicheck',
			'label'    => esc_html__( 'Entry Meta', 'farmart' ),
			'section'  => 'single_post',
			'default'  => array( 'breadcrumbs', 'author','date','cat' ),
			'choices'  => array(
				'breadcrumbs'     => esc_html__( 'Breadcrumbs', 'farmart' ),
				'author'    => esc_html__( 'Author', 'farmart' ),
				'cat'     => esc_html__( 'Category', 'farmart' ),
				'date'    => esc_html__( 'Date', 'farmart' ),
				'comment' => esc_html__( 'Comment', 'farmart' ),
				'social'    => esc_html__( 'Social', 'farmart' ),
			),
			'priority' => 10,
		),
		'post_socials_share' => array(
			'type'            => 'multicheck',
			'label'           => esc_html__( 'Socials Share', 'farmart' ),
			'section'         => 'single_post',
			'default'         => array( 'facebook', 'twitter', 'google', 'tumblr' ),
			'choices'         => array(
				'facebook'  => esc_html__( 'Facebook', 'farmart' ),
				'twitter'   => esc_html__( 'Twitter', 'farmart' ),
				'google'    => esc_html__( 'Google Plus', 'farmart' ),
				'tumblr'    => esc_html__( 'Tumblr', 'farmart' ),
				'pinterest' => esc_html__( 'Pinterest', 'farmart' ),
				'linkedin'  => esc_html__( 'Linkedin', 'farmart' ),
			),
			'priority'        => 10,
			'active_callback' => array(
				array(
					'setting'  => 'post_entry_meta',
					'operator' => 'contains',
					'value'    => array('social'),
				),
			),
		),

		'related_posts'         => array(
			'type'        => 'toggle',
			'label'       => esc_html__( 'Related Posts', 'farmart' ),
			'description' => esc_html__( 'Check this option to show related posts in the single post.', 'farmart' ),
			'section'     => 'related_posts',
			'default'     => 0,
			'priority'    => 10,
		),
		'related_posts_title'   => array(
			'type'            => 'text',
			'label'           => esc_html__( 'Related Posts Title', 'farmart' ),
			'section'         => 'related_posts',
			'default'         => esc_html__( 'Related Posts', 'farmart' ),
			'priority'        => 10,

		),
		'related_posts_numbers' => array(
			'type'            => 'number',
			'label'           => esc_html__( 'Numbers of Related Posts', 'farmart' ),
			'description'     => esc_html__( 'How many related posts would you like to show', 'farmart' ),
			'section'         => 'related_posts',
			'default'         => 9,
			'priority'        => 10,

		),
		'related_posts_columns' => array(
			'type'            => 'number',
			'label'           => esc_html__( 'Columns of Related Posts', 'farmart' ),
			'section'         => 'related_posts',
			'default'         => 4,
			'priority'        => 10,

		),

		// Categories Filter
		'show_blog_cats'          => array(
			'type'        => 'toggle',
			'label'       => esc_html__( 'Show Blog Page', 'farmart' ),
			'section'     => 'blog_categories_list',
			'default'     => 0,
			'description' => esc_html__( 'Display categories list above posts list on blog, archive page', 'farmart' ),
			'priority'    => 10,
		),
		'show_post_cats'          => array(
			'type'        => 'toggle',
			'label'       => esc_html__( 'Show Single Post', 'farmart' ),
			'section'     => 'blog_categories_list',
			'default'     => 0,
			'description' => esc_html__( 'Display categories list on single post', 'farmart' ),
			'priority'    => 10,
		),
		'blog_categories_filter_custom_field_1'     => array(
			'type'    => 'custom',
			'section' => 'blog_categories_list',
			'default' => '<hr/>',
		),
		'custom_blog_cats'        => array(
			'type'     => 'toggle',
			'label'    => esc_html__( 'Custom Categories List', 'farmart' ),
			'section'  => 'blog_categories_list',
			'default'  => 0,
			'priority' => 10,
		),
		'blog_cats_slug'          => array(
			'type'            => 'select',
			'section'         => 'blog_categories_list',
			'label'           => esc_html__( 'Custom Categories', 'farmart' ),
			'description'     => esc_html__( 'Select product categories you want to show.', 'farmart' ),
			'default'         => '',
			'multiple'        => 999,
			'priority'        => 10,
			'choices'         => class_exists('Kirki_Helper') ? Kirki_Helper::get_taxonomies() : '',
			'active_callback' => array(
				array(
					'setting'  => 'custom_blog_cats',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		'blog_categories_filter_custom_field_2'     => array(
			'type'    => 'custom',
			'section' => 'blog_categories_list',
			'default' => '<hr/>',
		),
		'blog_cats_view_all'                  => array(
			'type'            => 'text',
			'label'           => esc_html__( 'View All Text', 'farmart' ),
			'section'         => 'blog_categories_list',
			'default'         => esc_html__( 'All', 'farmart' ),
			'priority'        => 10,
		),
		'blog_cats_orderby' => array(
			'type'            => 'select',
			'label'           => esc_html__( 'Categories Orderby', 'farmart' ),
			'section'         => 'blog_categories_list',
			'default'         => 'count',
			'priority'        => 10,
			'choices'         => array(
				'count' => esc_html__( 'Count', 'farmart' ),
				'title' => esc_html__( 'Title', 'farmart' ),
				'id' => esc_html__( 'ID', 'farmart' ),
			),
		),
		'blog_cats_order' => array(
			'type'            => 'select',
			'label'           => esc_html__( 'Categories Order', 'farmart' ),
			'section'         => 'blog_categories_list',
			'default'         => 'DESC',
			'priority'        => 10,
			'choices'         => array(
				'DESC' => esc_html__( 'DESC', 'farmart' ),
				'ASC' => esc_html__( 'ASC', 'farmart' ),
			),
		),
		'blog_cats_number' => array(
			'type'            => 'number',
			'label'           => esc_html__( 'Categories Number', 'farmart' ),
			'section'         => 'blog_categories_list',
			'default'         => 6,
			'priority'        => 10,
		),

		//Footer
		'back_to_top'                   => array(
			'type'     => 'toggle',
			'label'    => esc_html__( 'Back to Top', 'farmart' ),
			'section'  => 'backtotop',
			'default'  => 0,
			'priority' => 10,
		),

		'footer_sections'           => array(
			'type'        => 'sortable',
			'label'       => esc_html__('Footer Sections', 'farmart'),
			'description' => esc_html__('Select and order footer contents', 'farmart'),
			'default'     => array( 'widgets', 'main' ),
			'choices'     => array(
				'newsletter' 	=> esc_attr__('Footer Newsletter', 'farmart'),
				'extra' 		=> esc_attr__('Footer Extra', 'farmart'),
				'infor' 		=> esc_attr__('Footer Infor', 'farmart'),
				'widgets'   	=> esc_attr__('Footer Widgets', 'farmart'),
				'link'     		=> esc_attr__('Footer Link', 'farmart'),
				'main'      	=> esc_attr__('Footer Main', 'farmart'),
			),
			'section' => 'footer_layout',
		),

		'footer_width'	=> array(
			'type'    => 'select',
			'label'   => esc_html__('Footer Width', 'farmart'),
			'section' => 'footer_layout',
			'default' => 'farmart-container',
			'choices' => array(
				'container'			=> esc_attr__( 'Standard', 'farmart' ),
				'farmart-container' => esc_attr__( 'Large', 'farmart' ),
			),
		),

		'footer_custom_field_1'     => array(
			'type'    => 'custom',
			'section' => 'footer_layout',
			'default' => '<hr/>',
		),

		'footer_padding_top'   => array(
			'type'      => 'slider',
			'label'     => esc_html__('Padding Top', 'farmart'),
			'section'   => 'footer_layout',
			'default'   => 0,
			'transport' => 'postMessage',
			'choices'   => array(
				'min' => 0,
				'max' => 500,
			),
			'js_vars'         => array(
				array(
					'element'  => '.site-footer',
					'property' => 'padding-top',
					'units'    => 'px',
				),
			),
		),
		'footer_padding_bottom'   => array(
			'type'      => 'slider',
			'label'     => esc_html__('Padding Bottom', 'farmart'),
			'section'   => 'footer_layout',
			'default'   => 0,
			'transport' => 'postMessage',
			'choices'   => array(
				'min' => 0,
				'max' => 1000,
			),
			'js_vars'         => array(
				array(
					'element'  => '.site-footer',
					'property' => 'padding-bottom',
					'units'    => 'px',
				),
			),
		),

		// Footer Background
		'footer_background_image' => array(
			'type'    => 'image',
			'label'   => esc_html__('Background Image', 'farmart'),
			'default' => '',
			'section' => 'footer_background',
		),

		'footer_background_color'            => array(
			'type'            => 'color',
			'label'           => esc_html__('Background Color', 'farmart'),
			'default'         => '',
			'transport'       => 'postMessage',
			'section'         => 'footer_background',
			'js_vars'         => array(
				array(
					'element'  => '.site-footer',
					'property' => 'background-color',
				),
			),
		),
		'footer_background_heading'            => array(
			'type'            => 'color',
			'label'           => esc_html__('Heading Color', 'farmart'),
			'default'         => '',
			'transport'       => 'postMessage',
			'section'         => 'footer_background',
			'js_vars'         => array(
				array(
					'element'  => '.widget-title, h1, h2, h3, h4, h5, h6',
					'property' => 'color',
				),
			),
		),
		'footer_background_text'            => array(
			'type'            => 'color',
			'label'           => esc_html__('Text Color', 'farmart'),
			'default'         => '',
			'transport'       => 'postMessage',
			'section'         => 'footer_background',
			'js_vars'         => array(
				array(
					'element'  => '.site-footer',
					'property' => 'color',
				),
			),
		),
		'footer_background_text_hover'            => array(
			'type'            => 'color',
			'label'           => esc_html__('Hover Color', 'farmart'),
			'default'         => '',
			'transport'       => 'postMessage',
			'section'         => 'footer_background',
			'js_vars'         => array(
				array(
					'element'  => '.site-footer',
					'property' => 'color',
				),
			),
		),

		// Footer newsletter
		'footer_newsletter_text' => array(
			'type'            => 'textarea',
			'label'           => esc_html__('Text', 'farmart'),
			'section'         => 'footer_newsletter',
			'default'         => '',
		),

		'footer_newsletter_form' => array(
			'type'            => 'textarea',
			'label'           => esc_html__('Form', 'farmart'),
			'description'     => esc_html__('Enter the shortcode of MailChimp form', 'farmart'),
			'section'         => 'footer_newsletter',
			'default'         => '',
		),

		'custom_newsletter_link_to_form' => array(
			'type'            => 'custom',
			'section'         => 'footer_newsletter',
			'default'         => sprintf('<a href="%s">%s</a>', admin_url('admin.php?page=mailchimp-for-wp-forms'), esc_html__('Go to MailChimp form', 'farmart')),
		),

		'footer_newsletter_bg' => array(
			'type'    => 'image',
			'label'   => esc_html__('Background Image', 'farmart'),
			'default' => '',
			'section' => 'footer_newsletter',
		),

		'footer_newsletter_bg_color'            => array(
			'type'            => 'color',
			'label'           => esc_html__('Background Color', 'farmart'),
			'default'         => '',
			'transport'       => 'postMessage',
			'section'         => 'footer_newsletter',
			'js_vars'         => array(
				array(
					'element'  => '.footer-newsletter',
					'property' => '--fm-newsletter-background-color',
				),
			),
		),

		'footer_newsletter_text_color'            => array(
			'type'            => 'color',
			'label'           => esc_html__('Text Color', 'farmart'),
			'default'         => '',
			'transport'       => 'postMessage',
			'section'         => 'footer_newsletter',
			'js_vars'         => array(
				array(
					'element'  => '.footer-newsletter',
					'property' => '--fm-newsletter-text-color',
				),
			),
		),

		// Footer Extra
		'footer_extra_items' => array(
			'type'      => 'repeater',
			'label'     => esc_html__('Extra Items', 'farmart'),
			'section'   => 'footer_extra',
			'row_label' => array(
				'type'  => 'text',
				'value' => esc_html__('Item', 'farmart'),
			),
			'fields'    => array(
				'svg' => array(
					'type'    => 'textarea',
					'label'   => esc_html__('Icon', 'farmart'),
					'default' => '',
					'description'       => esc_html__( 'Paste SVG code here', 'farmart' ),
					'sanitize_callback' => 'Farmart\Icon::sanitize_svg',
				),
				'title'  => array(
					'type'    => 'text',
					'label'   => esc_html__('Text', 'farmart'),
					'default' => '',
				),
				'description'  => array(
					'type'    => 'textarea',
					'label'   => esc_html__('Description', 'farmart'),
					'default' => '',
				),
			),
		),

		// Footer Info
		'footer_infor'           => array(
			'type'     => 'toggle',
			'label'    => esc_html__( 'Footer Infor', 'farmart' ),
			'section'  => 'footer_infor',
			'default'  => '',
			'choices'  => '',
		),

		'footer_infor_items' => array(
			'type'      => 'repeater',
			'label'     => esc_html__('Infor Items', 'farmart'),
			'section'   => 'footer_infor',
			'row_label' => array(
				'type'  => 'text',
				'value' => esc_html__('Image', 'farmart'),
			),
			'fields'    => array(
				'image' => array(
					'type'    => 'image',
					'label'   => esc_html__('Image', 'farmart'),
					'default' => '',
				),
				'svg' => array(
					'type'    => 'textarea',
					'label'   => esc_html__('Image SVG', 'farmart'),
					'default' => '',
					'sanitize_callback' => 'Farmart\Icon::sanitize_svg',
				),
				'title'  => array(
					'type'    => 'text',
					'label'   => esc_html__('Title', 'farmart'),
					'default' => '',
				),
				'description'  => array(
					'type'    => 'textarea',
					'label'   => esc_html__('Description', 'farmart'),
					'default' => '',
				),
			),
			'active_callback' => array(
				array(
					'setting'  => 'footer_infor',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),

		// Footer Widget
		'footer_widgets_layout'     => array(
			'type'        => 'select',
			'tooltip'     => esc_html__('Go to appearance > widgets find to footer sidebar to edit your sidebar', 'farmart'),
			'label'       => esc_html__('Layout', 'farmart'),
			'description' => esc_html__('Select number of columns for displaying widgets', 'farmart'),
			'default'     => '4-columns',
			'choices'     => array(
				'2-columns'      => esc_html__('2 Columns', 'farmart'),
				'3-columns'      => esc_html__('3 Columns', 'farmart'),
				'4-columns'      => esc_html__('4 Columns', 'farmart'),
				'5-columns'      => esc_html__('5 Columns', 'farmart'),
			),
			'section' => 'footer_widget',
		),
		'footer_widgets_style'     => array(
			'type'        => 'select',
			'label'       => esc_html__('Style', 'farmart'),
			'description' => esc_html__('Select number of style for displaying widgets', 'farmart'),
			'default'     => '1',
			'choices'     => array(
				'1'      => esc_html__('Style 1', 'farmart'),
				'2'      => esc_html__('Style 2', 'farmart'),
			),
			'section' => 'footer_widget',
		),

		// Footer Main
		'footer_main_left'             => array(
			'type'        => 'repeater',
			'label'       => esc_html__('Left Items', 'farmart'),
			'description' => esc_html__('Control left items of the footer', 'farmart'),
			'transport'   => 'postMessage',
			'default'     => array(array('item' => 'copyright')),
			'row_label'   => array(
				'type'  => 'field',
				'value' => esc_attr__('Item', 'farmart'),
				'field' => 'item',
			),
			'fields'          => array(
				'item' => array(
					'type'    => 'select',
					'choices' => footer_items_option(),
				),
			),
			'partial_refresh' => array(
				'footer_main_left' => array(
					'selector'            => '.footer-main',
					'container_inclusive' => true,
					'render_callback'     => function () {
						get_template_part('template-parts/footer/footer');
					},
				),
			),
			'section' => 'footer_main',
		),
		'footer_main_center'           => array(
			'type'        => 'repeater',
			'label'       => esc_html__('Center Items', 'farmart'),
			'description' => esc_html__('Control center items of the footer', 'farmart'),
			'transport'   => 'postMessage',
			'default'     => array(),
			'row_label'   => array(
				'type'  => 'field',
				'value' => esc_attr__('Item', 'farmart'),
				'field' => 'item',
			),
			'fields'          => array(
				'item' => array(
					'type'    => 'select',
					'choices' => footer_items_option(),
				),
			),
			'partial_refresh' => array(
				'footer_main_center' => array(
					'selector'            => '.footer-main',
					'container_inclusive' => true,
					'render_callback'     => function () {
						get_template_part('template-parts/footer/footer');
					},
				),
			),
			'section' => 'footer_main',
		),
		'footer_main_right'            => array(
			'type'        => 'repeater',
			'label'       => esc_html__('Right Items', 'farmart'),
			'description' => esc_html__('Control right items of the footer', 'farmart'),
			'transport'   => 'postMessage',
			'default'     => array(array('item' => 'menu')),
			'row_label'   => array(
				'type'  => 'field',
				'value' => esc_attr__('Item', 'farmart'),
				'field' => 'item',
			),
			'fields'          => array(
				'item' => array(
					'type'    => 'select',
					'default' => 'copyright',
					'choices' => footer_items_option(),
				),
			),
			'partial_refresh' => array(
				'footer_main_right' => array(
					'selector'            => '.footer-main',
					'container_inclusive' => true,
					'render_callback'     => function () {
						get_template_part('template-parts/footer/footer');
					},
				),
			),
			'section' => 'footer_main',
		),

		'footer_copyright'           => array(
			'type'        => 'textarea',
			'label'       => esc_html__('Footer Copyright', 'farmart'),
			'description' => esc_html__('Display copyright info on the left side of footer', 'farmart'),
			'default'     => sprintf('%s <b>%s</b> ' . esc_html__('All rights reserved', 'farmart'), '&copy;' . date('Y'), get_bloginfo('name')),
			'section'     => 'footer_copyright',
		),

		'footer_main_payment_images' => array(
			'type'      => 'repeater',
			'label'     => esc_html__('Payment Images', 'farmart'),
			'section'   => 'footer_payment',
			'row_label' => array(
				'type'  => 'text',
				'value' => esc_html__('Image', 'farmart'),
			),
			'fields'    => array(
				'image' => array(
					'type'    => 'image',
					'label'   => esc_html__('Image', 'farmart'),
					'default' => '',
				),
				'link'  => array(
					'type'    => 'text',
					'label'   => esc_html__('Link', 'farmart'),
					'default' => '',
				),
			),
		),

		// Mobile Header Item
		'mobile_header_left'             => array(
			'type'        => 'repeater',
			'label'       => esc_html__('Left Items', 'farmart'),
			'description' => esc_html__('Control left items of the footer', 'farmart'),
			'priority' => 10,
			'transport'   => 'postMessage',
			'default'     => array(array('item' => 'menu')),
			'row_label'   => array(
				'type'  => 'field',
				'value' => esc_attr__('Item', 'farmart'),
				'field' => 'item',
			),
			'fields'          => array(
				'item' => array(
					'type'    => 'select',
					'choices' => mobile_header_option(),
				),
			),
			'section' => 'mobile_header',
		),
		'mobile_header_center'           => array(
			'type'        => 'repeater',
			'label'       => esc_html__('Center Items', 'farmart'),
			'description' => esc_html__('Control center items of the footer', 'farmart'),
			'priority' => 15,
			'transport'   => 'postMessage',
			'default'     => array(array('item' => 'logo')),
			'row_label'   => array(
				'type'  => 'field',
				'value' => esc_attr__('Item', 'farmart'),
				'field' => 'item',
			),
			'fields'          => array(
				'item' => array(
					'type'    => 'select',
					'choices' => mobile_header_option(),
				),
			),
			'section' => 'mobile_header',
		),
		'mobile_header_right'            => array(
			'type'        => 'repeater',
			'label'       => esc_html__('Right Items', 'farmart'),
			'description' => esc_html__('Control right items of the footer', 'farmart'),
			'priority' => 20,
			'transport'   => 'postMessage',
			'default'     => array(array('item' => 'search')),
			'row_label'   => array(
				'type'  => 'field',
				'value' => esc_attr__('Item', 'farmart'),
				'field' => 'item',
			),
			'fields'          => array(
				'item' => array(
					'type'    => 'select',
					'default' => 'copyright',
					'choices' => mobile_header_option(),
				),
			),
			'section' => 'mobile_header',
		),

		// Sticky Mobile
		'mobile_header_sticky_hr'     => array(
			'type'    => 'custom',
			'default' => '<hr/>',
			'priority' => 25,
			'active_callback' => array(
				array(
					'setting'  => 'header_sticky',
					'operator' => '==',
					'value'    => true,
				),
			),
			'section' => 'mobile_header',
		),
		'mobile_header_sticky'           => array(
			'type'     => 'toggle',
			'label'    => esc_html__( 'Sticky Header', 'farmart' ),
			'priority' => 30,
			'default'  => true,
			'active_callback' => array(
				array(
					'setting'  => 'header_sticky',
					'operator' => '==',
					'value'    => true,
				),
			),
			'section'  => 'mobile_header',
		),

		// Mobile
		'mobile_logo'                                      => array(
			'type'            => 'image',
			'label'           => esc_html__( 'Logo', 'farmart' ),
			'default'         => '',
			'section'         => 'mobile_logo',
		),
		'header_search_trending_items' => array(
			'type'      => 'repeater',
			'label'     => esc_html__('List Item', 'farmart'),
			'section'   => 'mobile_search',
			'row_label' => array(
				'type'  => 'text',
				'value' => esc_html__('Item', 'farmart'),
			),
			'fields'    => array(
				'text'  => array(
					'type'    => 'text',
					'label'   => esc_html__('Text', 'farmart'),
					'default' => '',
				),
				'link'  => array(
					'type'    => 'text',
					'label'   => esc_html__('Link', 'farmart'),
					'default' => '',
				),
			),
		),
		'header_primary_menu_items' => array(
			'type'      => 'repeater',
			'label'     => esc_html__('Item footer in menu mobile', 'farmart'),
			'section'   => 'mobile_menu',
			'row_label' => array(
				'type'  => 'text',
				'value' => esc_html__('Item', 'farmart'),
			),
			'fields'    => array(
				'image' => array(
					'type'    => 'image',
					'label'   => esc_html__('Image', 'farmart'),
					'default' => '',
				),
				'svg' => array(
					'type'    => 'textarea',
					'label'   => esc_html__('SVG', 'farmart'),
					'default' => '',
					'description'       => esc_html__( 'Paste SVG code of your logo here', 'farmart' ),
					'sanitize_callback' => 'Farmart\Icon::sanitize_svg',
				),
				'text'  => array(
					'type'    => 'text',
					'label'   => esc_html__('Text', 'farmart'),
					'default' => '',
				),
				'link'  => array(
					'type'    => 'text',
					'label'   => esc_html__('Link', 'farmart'),
					'default' => '',
				),
			),
		),
	);

	$settings['panels']   = apply_filters( 'farmart_customize_panels', $panels );
	$settings['sections'] = apply_filters( 'farmart_customize_sections', $sections );
	$settings['fields']   = apply_filters( 'farmart_customize_fields', $fields );

	return $settings;
}

$farmart_customize = new Farmart_Customize( farmart_customize_settings() );

// Fix downloaded fonts from Google.
if ( defined( 'KIRKI_VERSION' ) && version_compare( KIRKI_VERSION, '5.0.0', '<=' ) ) {

	/**
	 * Change the http request headers of 'user-agent' to download .woff2 fonts frm Google.
	 *
	 * @param  array $args
	 * @param  string $url
	 *
	 * @return array
	 */
	function farmart_fix_kirki_fonts_request_headers( $args, $url ) {
		if ( false === strpos( $url, 'https://fonts.googleapis.com/css' ) ) {
			return $args;
		}

		if ( isset( $args['user-agent'] ) && $args['user-agent'] == 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/603.3.8 (KHTML, like Gecko) Version/10.1.2 Safari/603.3.8' ) {
			$args['user-agent'] = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:73.0) Gecko/20100101 Firefox/73.0';
		}

		return $args;
	}

	add_filter( 'http_request_args', 'farmart_fix_kirki_fonts_request_headers', 10, 2 );

	/**
	 * Fix incorrect fonts files downloaded from Google.
	 * Delete the Kirki's transients to force downloading font files again.
	 *
	 * @return void
	 */
	function farmart_fix_kirki_fonts() {
		delete_transient( 'kirki_remote_url_contents' );
	}

	add_action( 'after_switch_theme', 'farmart_fix_kirki_fonts' );
	add_action( 'wp_ajax_kirki_clear_font_cache', 'farmart_fix_kirki_fonts' );
}