<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Farmart
 */

$layout_content = $css = '';
$layout         = farmart_get_option( 'single_post_layout' );
$custom_layout  = get_post_meta( get_the_ID(), 'post_layout_settings', true );

if ( $custom_layout == '' ) {
	$layout_content = $layout;
} else {
	$layout_content = $custom_layout;
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post-wrapper' ); ?>>
    <header class="entry-header">
        <div class="row">
            <div class="col-md-12 col-xs-12">
				<?php
				farmart_blog_single_breadcrumbs();
				if ( intval( farmart_get_option( 'single_featured_image' ) ) ) {
					farmart_post_thumbnail();
				}
				the_title( '<h2 class="entry-title">', '</h2>' );
				farmart_blog_meta();
				?>
            </div><!-- .row -->
        </div><!-- .col -->
    </header><!-- .entry-header -->

	<?php
	if ( $layout_content == 'full-content' && farmart_get_option( 'single_post_format' )) {
		farmart_post_format( 'farmart-post-full' );
	}
	?>

    <div class="entry-content">
		<?php
		the_content( sprintf(
			wp_kses(
			/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Continue reading<span class="screen-reader-text">"%s"</span>', 'farmart' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		) );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'farmart' ),
			'after'  => '</div>',
		) );
		?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <div class="row">
            <div class="col-md-12 col-xs-12">
				<?php
				farmart_post_tag();
				farmart_author_box();
				?>
            </div>
        </div>

    </footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
