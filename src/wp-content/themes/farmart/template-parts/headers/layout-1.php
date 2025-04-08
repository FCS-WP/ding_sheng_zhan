<?php
/**
 * Header Layout 1
 */
?>

<div class="header-main-wrapper">
    <div class="container">
        <div class="header-top">
            <div class="hidden-lg header-menu-mobile fm-menu-mobile">
                <div class="menu-mobile-wrapper">
                    <nav class="primary-menu-mobile">
				        <?php
				        wp_nav_menu(
					        array(
						        'theme_location' => 'primary',
						        'container'      => false,
						        'menu_class'     => 'menu',
					        )
				        );
				        ?>
                    </nav>
                </div>
                <div class="menu-icon menu-icon-js"><?php echo Farmart\Icon::get_svg( 'menu' ) ?></div>
                <div class="fm-off-canvas-layer"></div>
            </div>
            <div class="header-logo">
				<?php get_template_part( 'template-parts/logo' ); ?>
            </div>
            <div class="hidden-xs hidden-sm hidden-md header-search">
				<?php farmart_header_search(); ?>
            </div>
            <div class="header-elements">
                <div class="header-element header-element--search hidden-lg">
                    <a href="#" class="open-header-search"><?php echo Farmart\Icon::get_svg( 'search' ) ?></a>
                    <div class="search-panel-content">
                        <div class="top-content">
                            <form method="get" class="form-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                                <div class="search-inner-content">
                                    <div class="search-wrapper">
                                        <span class="loading-icon"></span>
                                        <input type="text" name="s" class="search-field" autocomplete="off"
                                               placeholder="<?php echo apply_filters( 'farmart_header_search_placeholder', esc_attr__( 'I&rsquo;m shopping for...','farmart' ) ); ?>">
                                    </div>
                                </div>
                                <button class="search-submit" type="submit"><?php echo Farmart\Icon::get_svg( 'search' ) ?></button>
                            </form>
                            <a href="#" class="close-search-panel"><?php echo apply_filters( 'farmart_header_search_close_panel_text', esc_html__( 'Cancel','farmart' ) ); ?></a>
                        </div>
                    </div>
                    <div class="fm-off-canvas-layer"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="hidden-xs hidden-sm hidden-md header-main">
        <div class="container">
            <nav id="primary-menu" class="main-navigation primary-navigation">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'menu',
					)
				);
				?>
            </nav>
        </div>
    </div>
</div>