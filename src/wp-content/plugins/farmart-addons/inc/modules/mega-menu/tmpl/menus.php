<# if ( data.depth == 0 ) { #>
<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Mega Menu Content', 'farmart-addons' ) ?>"
   data-panel="mega"><?php esc_html_e( 'Mega Menu', 'farmart-addons' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Mega Menu Background', 'farmart-addons' ) ?>"
   data-panel="background"><?php esc_html_e( 'Background', 'farmart-addons' ) ?></a>
<div class="separator"></div>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'farmart-addons' ) ?>"
   data-panel="icon"><?php esc_html_e( 'Icon', 'farmart-addons' ) ?></a>
<# } else if ( data.depth == 1 ) { #>
<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Menu Content', 'farmart-addons' ) ?>"
   data-panel="content"><?php esc_html_e( 'Menu Content', 'farmart-addons' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu General', 'farmart-addons' ) ?>"
   data-panel="general"><?php esc_html_e( 'General', 'farmart-addons' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'farmart-addons' ) ?>"
   data-panel="icon"><?php esc_html_e( 'Icon', 'farmart-addons' ) ?></a>
<# } else { #>
<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Menu Content', 'farmart-addons' ) ?>"
   data-panel="content"><?php esc_html_e( 'Menu Content', 'farmart-addons' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'farmart-addons' ) ?>"
   data-panel="icon"><?php esc_html_e( 'Icon', 'farmart-addons' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu General', 'farmart-addons' ) ?>"
   data-panel="general_2"><?php esc_html_e( 'General', 'farmart-addons' ) ?></a>
<# } #>
