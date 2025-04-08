<?php
/**
 * Template part for displaying the logo
 *
 */

?>
<div class="site-branding">
    <a href="<?php echo esc_url( home_url( '/' ) ) ?>" class="logo">
            <img src="<?php echo esc_url( farmart_get_option( 'mobile_logo' ) ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>">
    </a>

	<?php if ( is_front_page() && is_home() ) : ?>
        <h1 class="site-title">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
        </h1>
	<?php else : ?>
        <p class="site-title">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
        </p>
	<?php endif; ?>

	<?php if ( ( $description = get_bloginfo( 'description', 'display' ) ) || is_customize_preview() ) : ?>
        <p class="site-description"><?php echo ! empty( $description ) ? $description : ''; /* WPCS: xss ok. */ ?></p>
	<?php endif; ?>
</div>