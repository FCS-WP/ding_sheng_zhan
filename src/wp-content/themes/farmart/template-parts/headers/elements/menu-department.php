<?php
/**
 * Menu department header
 */

if( ! farmart_get_option('header_menu_department_menu') ) {
	return;
}

$classes = '';
if ( ( is_home() || is_front_page() ) && intval( farmart_get_option('header_menu_department_dropdown') ) ) {
	$classes = 'show';
}

?>
<div class="farmart-menu-department menu-hover <?php echo esc_attr( $classes ) ?>">
	<div class="menu-icon">
		<?php
			echo Farmart\Icon::get_svg('menu', 'farmart-icon farmart-icon-menu');
			if ( farmart_get_option('header_menu_department_text') ) {
				echo '<span class="farmart-title">' .esc_html( farmart_get_option('header_menu_department_text_input') ). '</span>';
			}
			if ( farmart_get_option('header_menu_department_dropdown_icon') ) {
				echo Farmart\Icon::get_svg( 'chevron-bottom' );
			}
		?>
	</div>
	<?php
		echo '<div class="department-menu main-navigation"><nav class="farmart-department-menu--dropdown">';
			if ( class_exists( '\Farmart\Addons\Modules\Mega_Menu\Walker' ) ) {
				wp_nav_menu( array(
					'menu'  		 => esc_attr( farmart_get_option('header_menu_department_menu') ),
					'theme_location' => '__no_such_location',
					'container'      => false,
					'menu_class'     => 'farmart-department-menu',
					'walker' 		=>  new Farmart\Addons\Modules\Mega_Menu\Walker()
				) );
			} else {
				wp_nav_menu( array(
					'menu'  		 => esc_attr( farmart_get_option('header_menu_department_menu') ),
					'theme_location' => '__no_such_location',
					'container'      => false,
					'menu_class'     => 'farmart-department-menu',
				) );
			}
		echo '</nav></div>';
	?>
</div>