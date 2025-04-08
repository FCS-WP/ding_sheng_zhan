<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Farmart
 */

$img_404 = get_template_directory_uri() . '/images/error.png';
if ( farmart_get_option( '404_img' ) ) {
	$img_404 = farmart_get_option( '404_img' );
}

get_header();
?>
<?php if (!function_exists('elementor_theme_do_location') || !elementor_theme_do_location('single')) { ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<section class="error-404 not-found">

				<?php if ($img_404):?>
					<img src="<?php echo esc_url( $img_404 ); ?>" alt="<?php esc_attr_e( 'page not found', 'farmart' ); ?>">
				<?php endif; ?>

				<h2 class="page-title"><?php esc_html_e( 'Oops! Page not found.', 'farmart' ); ?></h2>

				<div class="page-content">
					<div class="description">
						<?php
							echo esc_html__( 'We can\'t find the page you\'re looking for. You can either ', 'farmart' ) .
								'<a href="javascript:history.go(-1)">' . esc_html__( 'return to the previous page', 'farmart' ) . '</a>, ' .
								'<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'visit our home page','farmart' ) . '</a>' .
								esc_html__( ' or search for something else.', 'farmart' );
						?>
					</div>

					<div class="search">
						<?php get_search_form(); ?>
					</div>
				</div>
				<!-- .page-content -->
			</section>
			<!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->
<?php } ?>
<?php
get_footer();
