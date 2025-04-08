<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Farmart
 */

if ( ! function_exists( 'farmart_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function farmart_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on farmart, use a find and replace
		 * to change  'farmart' to the name of your theme in all the template files.
		 */

		// Theme supports
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'post-formats', array( 'gallery', 'video', 'audio', 'link','video' ) );

		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
		add_theme_support( 'customize-selective-refresh-widgets' );

		add_editor_style( 'css/editor-style.css' );

		// Load regular editor styles into the new block-based editor.
		add_theme_support( 'editor-styles' );

		// Load default block styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for responsive embeds.
		add_theme_support( 'responsive-embeds' );

		add_theme_support( 'align-wide' );

		add_theme_support( 'align-full' );

		add_image_size( 'farmart-post-full', 1170, 500, true );
		add_image_size( 'farmart-blog-default', 1170, 739, true );
		add_image_size( 'farmart-blog-small', 600, 378, true );
		add_image_size( 'farmart-blog-small-2', 1170, 405, true );
		add_image_size( 'farmart-blog-listing', 1170, 737, true );
		add_image_size( 'farmart-blog-grid', 600, 379, true );
		add_image_size( 'farmart-blog-elementor', 370, 235, true );

		add_image_size( 'farmart-dokan-banner', 270, 250, true );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'farmart' ),
			'socials' => esc_html__( 'Social Menu', 'farmart' ),
			'mobile' => esc_html__( 'Mobile Menu', 'farmart' ),
			'footer' => esc_html__( 'Footer Menu', 'farmart' ),
		) );

	}
endif;
add_action( 'after_setup_theme', 'farmart_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function farmart_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'farmart_content_width', 640 );
}

add_action( 'after_setup_theme', 'farmart_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function farmart_widgets_init() {
	// Register primary sidebar
	$sidebars = array(
		'blog-sidebar'          => esc_html__( 'Blog Sidebar', 'farmart' ),
		'topbar-left'          	=> esc_html__( 'Topbar Left', 'farmart' ),
		'topbar-right'          => esc_html__( 'Topbar Right', 'farmart' ),
		'topbar-mobile'         => esc_html__( 'Topbar Mobile', 'farmart' ),
		'catalog-sidebar'       => esc_html__( 'Catalog Sidebar', 'farmart' ),
		'product-sidebar'       => esc_html__( 'Single Product Sidebar', 'farmart' ),
		'footer-link'      		=> esc_html__( 'Footer Link', 'farmart' ),
	);

	// Register sidebars
	foreach ( $sidebars as $id => $name ) {
		register_sidebar(
			array(
				'name'          => $name,
				'id'            => $id,
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
	}

	if ( intval( farmart_get_option( 'enable_mobile_version' ) ) ) {
		register_sidebar( array(
			'name'          => esc_html__( 'Single Product Sidebar Mobile', 'farmart' ),
			'id'            => 'product-sidebar-mobile',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}

	// Register footer sidebars
	for ( $i = 1; $i <= 5; $i ++ ) {
		$sidebars["footer-$i"] = esc_html__( 'Footer', 'farmart' ) . " $i";
	}

	// Register sidebars
	foreach ( $sidebars as $id => $name ) {
		register_sidebar(
			array(
				'name'          => $name,
				'id'            => $id,
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
	}
}

add_action( 'widgets_init', 'farmart_widgets_init' );

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce/woocommerce.php';

	// Vendor
	require get_template_directory() . '/inc/woocommerce/vendors/vendors.php';
}

/**
 * Custom functions for the theme.
 */
require get_template_directory() . '/inc/functions/search-ajax.php';
require get_template_directory() . '/inc/functions/recently-viewed-product-ajax.php';
require get_template_directory() . '/inc/functions/header.php';
require get_template_directory() . '/inc/functions/footer.php';
require get_template_directory() . '/inc/functions/layout.php';
require get_template_directory() . '/inc/functions/entry.php';
require get_template_directory() . '/inc/functions/comments.php';
require get_template_directory() . '/inc/functions/breadcrumbs.php';
require get_template_directory() . '/inc/functions/page-header.php';
require get_template_directory() . '/inc/functions/shop.php';
require get_template_directory() . '/inc/functions/style.php';
require get_template_directory() . '/inc/functions/icon.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/mobile/theme-options.php';
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Custom functions for the theme by hooking
 */

require get_template_directory() . '/inc/frontend/header.php';
require get_template_directory() . '/inc/frontend/footer.php';
require get_template_directory() . '/inc/frontend/layout.php';
require get_template_directory() . '/inc/frontend/comments.php';
require get_template_directory() . '/inc/frontend/nav.php';
require get_template_directory() . '/inc/frontend/entry.php';
require get_template_directory() . '/inc/frontend/page-header.php';
require get_template_directory() . '/inc/frontend/maintenance.php';

// Mobile
require get_template_directory() . '/inc/libs/mobile_detect.php';
require get_template_directory() . '/inc/mobile/layout.php';

if ( is_admin() ) {
	require get_template_directory() . '/inc/libs/class-tgm-plugin-activation.php';
	require get_template_directory() . '/inc/backend/plugins.php';
	require get_template_directory() . '/inc/backend/meta-boxes.php';
	require get_template_directory() . '/inc/backend/editor.php';
	require get_template_directory() . '/inc/backend/product-cat.php';
}
