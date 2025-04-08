<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Farmart
 */
$type = farmart_get_option( 'navigation_type' );

get_header();
?>
<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) { ?>
    <div id="primary" class="content-area <?php farmart_content_columns(); ?>">
        <main id="main" class="site-main">
			<?php
			if ( intval( farmart_get_option( 'show_blog_cats' ) ) ) {
				do_action( 'farmart_before_post_loop' );
            }
			?>

            <div class="farmart-post--wrapper">
				<?php if ( have_posts() ) : ?>
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
							get_template_part( 'template-parts/content', get_post_type() );
						endwhile; ?>
                    </div>
					<?php
					if ( $type == "numberic" ):
						farmart_numeric_pagination();
					else:
						farmart_load_pagination();
					endif;
				else :
					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php
	get_sidebar();
}
get_footer();
