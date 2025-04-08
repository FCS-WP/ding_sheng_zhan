<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Farmart
 */

get_header();
?>
<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) { ?>
	<section id="primary" class="content-area <?php farmart_content_columns(); ?>">
		<main id="main" class="site-main">

		<?php if ( have_posts() ) : ?>
			<div class="content-search">
                <div class="farmart-post-list row-flex">
                    <div class="farmart-post-list__loading">
                        <div class="gooey">
                            <span class="dot"></span>
                            <div class="dots">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
					<?php
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();
						/*
						 * Include the Post-Type-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', 'search' );
					endwhile;?>
                </div>
				<?php farmart_numeric_pagination(); ?>

			</div>
		<?php
		else :
			get_template_part( 'template-parts/content', 'none' );
		endif;
		?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
	get_sidebar();
}
get_footer();
