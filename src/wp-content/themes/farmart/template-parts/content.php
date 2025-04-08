<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Farmart
 */
global $wp_query;
$current = $wp_query->current_post + 1;

$post_format       = get_post_format();
$blog_view = farmart_get_option('blog_view');
$classes = 'blog-wrapper';
$date = true;

if ( $blog_view == 'default' ) {
	$size = 'farmart-blog-default';

	if (  $current != 1) {
		$classes .= ' col-flex-md-6 col-flex-xs-12 col-flex-sm-6';
	} else {
		$classes .= ' col-flex-md-12 col-flex-xs-12 col-flex-sm-12';
	}
} elseif ($blog_view == 'small-thumb'){
	$size = 'farmart-blog-small';
	$classes .= ' col-flex-md-12 col-flex-xs-12 col-flex-sm-12';

	if ($post_format == 'quote' ){
		$size = 'farmart-blog-small-2';
		$classes .= ' no-flex';

	} elseif ($post_format == 'audio') {
		$classes .= ' no-flex';
	}

	if ( get_post()->post_content == '' ) {
		$classes .= ' no-content';
	}

	if ( get_the_title() == '' ) {
		$classes .= ' no-title';
	}
} elseif ($blog_view == 'list'){
	$size = 'farmart-blog-listing';
	$classes .= ' col-flex-md-12 col-flex-xs-12 col-flex-sm-12';
	$date = false;

	if ($post_format == 'quote' || $post_format == 'link'){
		$classes .= ' no-flex';
	}
} else {
	$size = 'farmart-blog-grid';
	$col = intval(farmart_get_option('blog_columns'));
	$classes .= ' col-flex-xs-12 col-flex-sm-6 col-flex-md-'. (12/$col);
}

$excerpt_length = absint( farmart_get_option( 'excerpt_length' ) );
$quote          = get_post_meta( get_the_ID(), 'quote', true );

?>
<article id="post-<?php the_ID(); ?>" <?php post_class($classes); ?>>
	<div class="blog-wrapper__inner">
		<?php farmart_post_format($size); ?>

		<?php if ( ! $quote  ):?>
			<div class="entry-summary">
				<header class="entry-header">
					<?php
					the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
					farmart_blog_meta($date);
					?>
				</header><!-- .entry-header -->

				<?php if ($blog_view != 'grid' ):?>
				<div class="entry-content">
					<div class="entry-excerpt"><?php echo farmart_content_limit( $excerpt_length, '' ); ?></div>
				</div><!-- .entry-content -->
				<?php endif;?>

				<?php if ($blog_view == 'list'): ?>
				<div class="entry-meta"><?php  echo farmart_meta_date().farmart_meta_author() ?> </div>
				<?php  endif; ?>

                <div class="fm-entry-date"><?php echo farmart_meta_date().farmart_meta_author() ?></div>

			</div>

		<?php endif;?>

		<?php if (get_the_title() == '') : ?>
			<a href="<?php echo esc_url( get_permalink() )?>" class="link-no-title"></a>
		<?php endif;?>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
