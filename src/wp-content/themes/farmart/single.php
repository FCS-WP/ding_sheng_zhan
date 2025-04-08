<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Farmart
 */

get_header();

$layout_content = $css = '';
$layout         = farmart_get_option( 'single_post_layout' );
$custom_layout  = get_post_meta( get_the_ID(), 'post_layout_settings', true );
if ( $custom_layout == '' ) {
	$layout_content = $layout;
} else {
	$layout_content = $custom_layout;
}

$post_format = get_post_format();

?>
<?php
if ( intval( farmart_get_option( 'show_post_cats' ) ) ) {
	do_action( 'farmart_before_post_loop' );
}

if ( $layout_content != 'full-content' && farmart_get_option( 'single_post_format' ) ) {
	if ( $post_format != 'link' ) {
		farmart_post_format( 'farmart-post-full', true );
	}
}
?>
<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) { ?>
    <div id="primary" class="content-area <?php farmart_content_columns(); ?>">
        <main id="main" class="site-main">
			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', 'single' );

				if ( 'post' == get_post_type() ) {
					farmart_the_post_navigation();
				}
				get_template_part( 'template-parts/related-posts' ); ?>

			<?php endwhile; // End of the loop.
			?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php

	get_sidebar();
}
get_footer();
