<?php
/**
 * Menu primary header
 */

$classes = 'main-navigation primary-navigation';
?>
<nav id="primary-menu" class="<?php echo esc_attr( $classes ); ?>">
	<?php
		if ( has_nav_menu( 'primary' ) ) {
			if ( class_exists( '\Farmart\Addons\Modules\Mega_Menu\Walker' ) ) {
				wp_nav_menu( apply_filters( 'farmart_navigation_primary_content', array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'farmart-main-menu main-navigation fm-main-menu--has-effect',
					'walker' 		=>  new Farmart\Addons\Modules\Mega_Menu\Walker()
				) ) );
			} else {
				wp_nav_menu( apply_filters( 'farmart_navigation_primary_content', array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'farmart-main-menu main-navigation fm-main-menu--has-effect',
				) ) );
			}
		}
	?>
</nav>
