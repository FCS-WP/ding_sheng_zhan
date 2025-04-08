<?php
/**
 * Custom functions for hook comments
 *
 * @package Farmart
 */

/**
 * Custom fields comment form
 *
 * @since  1.0
 *
 * @return  array  $fields
 */
if ( ! function_exists( 'farmart_comment_form_fields' ) ) :
	function farmart_comment_form_fields() {
		global $commenter, $aria_req;

		$comment_author = isset($commenter['comment_author']) ? $commenter['comment_author'] : '';
		$comment_author_email = isset($commenter['comment_author_email']) ? $commenter['comment_author_email'] : '';
		$comment_author_url = isset($commenter['comment_author_url']) ? $commenter['comment_author_url'] : '';

		$fields = array(
			'author' => '<p class="comment-form-author col-md-4 col-sm-12">' .
			            '<input id ="author" placeholder="' . esc_attr__( 'Name', 'farmart' ) . ' " name="author" type="text" required value="' . esc_attr( $comment_author ) .
			            '" size    ="30"' . $aria_req . ' /></p>',

			'email'  => '<p class="comment-form-email col-md-4 col-sm-12">' .
			            '<input id ="email" placeholder="' . esc_attr__( 'Email', 'farmart' ) . '" name="email" type="email" required value="' . esc_attr( $comment_author_email ) .
			            '" size    ="30"' . $aria_req . ' /></p>',

			'url'    => '<p class="comment-form-url col-md-4 col-sm-12">' .
			            '<input id ="url" placeholder="' . esc_attr__( 'Website', 'farmart' ) . '" name="url" type="text" value="' . esc_attr( $comment_author_url ) .
			            '" size    ="30" /></p>'
		);

		return $fields;
	}
endif;

add_filter( 'comment_form_default_fields', 'farmart_comment_form_fields' );
