<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Farmart
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<?php do_action( 'farmart_before_header' ); ?>
    <?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {?>
      <header id="site-header" class="site-header">
      <?php do_action( 'farmart_header' ); ?>
      </header>
    <?php } ?>
    <!-- #masthead -->
	<?php do_action( 'farmart_after_header' ); ?>

    <div id="content" class="site-content <?php echo apply_filters( 'farmart_site_content_class', '' ) ?>">
		<?php do_action( 'farmart_after_site_content_open' ); ?>
