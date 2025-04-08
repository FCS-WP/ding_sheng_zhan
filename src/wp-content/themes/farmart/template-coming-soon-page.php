<?php
/**
 * Template Name: Coming Soon Page
 *
 * The template file for displaying Coming Soon page.
 *
 * @package Farmart
 */

get_header(); ?>

<?php
if ( have_posts() ) :
	while ( have_posts() ) : the_post();
		the_content();
	endwhile;

endif;
?>

<?php get_footer(); ?>
