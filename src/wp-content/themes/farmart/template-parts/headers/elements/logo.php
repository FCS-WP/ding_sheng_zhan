<?php
/**
 * Template part for displaying the logo
 *
 */

$logo_type        = farmart_get_option( 'logo_type' );
$style            = $class = '';

if ( 'svg' == $logo_type ) :
	$logo = farmart_get_option( 'logo_svg' );
elseif ( 'text' == $logo_type ) :
	$logo = farmart_get_option( 'logo_text' );
	$class = 'logo-text';
else:
	$logo = farmart_get_option( 'logo' );

	if ( ! $logo ) {
		$logo = $logo ? $logo : get_theme_file_uri( '/images/logo.svg' );

		if ( strpos( $logo, '.svg' ) ) {
			$class = "logo-svg";
		}
	}

	$dimension = farmart_get_option( 'logo_dimension' );
	$style     = ! empty( $dimension['width'] ) ? ' width="' . esc_attr( $dimension['width'] ) . '"' : '';
	$style     .= ! empty( $dimension['height'] ) ? ' height="' . esc_attr( $dimension['height'] ) . '"' : '';
endif;

?>
<div class="site-branding">
    <a href="<?php echo esc_url( home_url( '/' ) ) ?>" class="logo <?php echo esc_attr( $class ) ?>">
		<?php if ( 'svg' == $logo_type ) : ?>
           <?php echo Farmart\Icon::sanitize_svg( $logo ); ?>
		<?php elseif ( 'text' == $logo_type ) : ?>
            <?php echo esc_html( $logo ); ?>
		<?php else : ?>
            <img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
				 class="logo-dark" <?php echo ! empty( $style ) ? $style : '';?>>
		<?php endif; ?>
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