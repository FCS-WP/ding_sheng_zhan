<?php
/**
 * Hooks for importer
 *
 * @package Farmart
 */


/**
 * Importer the demo content
 *
 * @since  1.0
 *
 */
function farmart_vc_addons_importer() {
	return array(
		array(
			'name'       => 'Home Supermarket',
			'preview'    => 'https://raw.githubusercontent.com/drfuri/demo-content/main/farmart/home-supermarket/preview.jpg',
			'content'    => 'https://raw.githubusercontent.com/drfuri/demo-content/main/farmart/home-supermarket/demo-content.xml',
			'customizer' => 'https://raw.githubusercontent.com/drfuri/demo-content/main/farmart/home-supermarket/customizer.dat',
			'widgets'    => 'https://raw.githubusercontent.com/drfuri/demo-content/main/farmart/home-supermarket/widgets.wie',
			'pages'      => array(
				'front_page' => 'Home Supermarket',
				'blog'       => 'Blog & News',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
			),
			'menus'      => array(
				'primary' => 'primary-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 400,
					'height' => 400,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 600,
					'height' => 600,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 70,
					'height' => 70,
					'crop'   => 1,
				),
			),
		),
		array(
			'name'       => 'Home Supermarket V2',
			'preview'    => 'https://raw.githubusercontent.com/drfuri/demo-content/main/farmart/home-supermarket-v2/preview.jpg',
			'content'    => 'https://raw.githubusercontent.com/drfuri/demo-content/main/farmart/home-supermarket-v2/demo-content.xml',
			'customizer' => 'https://raw.githubusercontent.com/drfuri/demo-content/main/farmart/home-supermarket-v2/customizer.dat',
			'widgets'    => 'https://raw.githubusercontent.com/drfuri/demo-content/main/farmart/home-supermarket-v2/widgets.wie',
			'pages'      => array(
				'front_page' => 'Home Supermarket New',
				'blog'       => 'Blog & News',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
			),
			'menus'      => array(
				'primary' => 'primary-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 400,
					'height' => 400,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 600,
					'height' => 600,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 70,
					'height' => 70,
					'crop'   => 1,
				),
			),
		),
		array(
			'name'       => 'Home Supermarket Full Width',
			'preview'    => 'https://raw.githubusercontent.com/drfuri/demo-content/main/farmart/home-supermarket-full-width/preview.jpg',
			'content'    => 'https://raw.githubusercontent.com/drfuri/demo-content/main/farmart/home-supermarket-full-width/demo-content.xml',
			'customizer' => 'https://raw.githubusercontent.com/drfuri/demo-content/main/farmart/home-supermarket-full-width/customizer.dat',
			'widgets'    => 'https://raw.githubusercontent.com/drfuri/demo-content/main/farmart/home-supermarket-full-width/widgets.wie',
			'pages'      => array(
				'front_page' => 'Home Supermarket Full Width',
				'blog'       => 'Blog & News',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
			),
			'menus'      => array(
				'primary' => 'menu-full-width',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 400,
					'height' => 400,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 600,
					'height' => 600,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 70,
					'height' => 70,
					'crop'   => 1,
				),
			),
		),
		array(
			'name'       => 'Home Local Store',
			'preview'    => 'https://raw.githubusercontent.com/drfuri/demo-content/main/farmart/home-local-store/preview.jpg',
			'content'    => 'https://raw.githubusercontent.com/drfuri/demo-content/main/farmart/home-local-store/demo-content.xml',
			'customizer' => 'https://raw.githubusercontent.com/drfuri/demo-content/main/farmart/home-local-store/customizer.dat',
			'widgets'    => 'https://raw.githubusercontent.com/drfuri/demo-content/main/farmart/home-local-store/widgets.wie',
			'pages'      => array(
				'front_page' => 'Home Local Store',
				'blog'       => 'Blog & News',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
			),
			'menus'      => array(
				'primary' => 'primary-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 400,
					'height' => 400,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 600,
					'height' => 600,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 70,
					'height' => 70,
					'crop'   => 1,
				),
			),
		),
		array(
			'name'       => 'Home Sidebar',
			'preview'    => 'https://raw.githubusercontent.com/drfuri/demo-content/main/farmart/home-sidebar/preview.jpg',
			'content'    => 'https://raw.githubusercontent.com/drfuri/demo-content/main/farmart/home-sidebar/demo-content.xml',
			'customizer' => 'https://raw.githubusercontent.com/drfuri/demo-content/main/farmart/home-sidebar/customizer.dat',
			'widgets'    => 'https://raw.githubusercontent.com/drfuri/demo-content/main/farmart/home-sidebar/widgets.wie',
			'pages'      => array(
				'front_page' => 'Home Sidebar',
				'blog'       => 'Blog & News',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
			),
			'menus'      => array(
				'primary' => 'primary-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 400,
					'height' => 400,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 600,
					'height' => 600,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 70,
					'height' => 70,
					'crop'   => 1,
				),
			),
		),
		array(
			'name'       => 'Home Business',
			'preview'    => 'https://raw.githubusercontent.com/drfuri/demo-content/main/farmart/home-business/preview.jpg',
			'content'    => 'https://raw.githubusercontent.com/drfuri/demo-content/main/farmart/home-business/demo-content.xml',
			'customizer' => 'https://raw.githubusercontent.com/drfuri/demo-content/main/farmart/home-business/customizer.dat',
			'widgets'    => 'https://raw.githubusercontent.com/drfuri/demo-content/main/farmart/home-business/widgets.wie',
			'pages'      => array(
				'front_page' => 'Home Business',
				'blog'       => 'Blog & News',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
			),
			'menus'      => array(
				'primary' => 'primary-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 400,
					'height' => 400,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 600,
					'height' => 600,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 70,
					'height' => 70,
					'crop'   => 1,
				),
			),
		),
	);
}

add_filter( 'soo_demo_packages', 'farmart_vc_addons_importer', 20 );
