<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Farmart
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

$comments_number = get_comments_number();
$comments_class  = $comments_number ? 'has-comments' : '';

if ( is_home() || is_front_page() ) {
	return;
}

?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
        <h3 class="comments-title <?php echo esc_attr( $comments_class ); ?>">
	        <?php
	        if ( $comments_number > 0 ) {
		        printf( // WPCS: XSS OK.
			        esc_html( _nx( '%1$s Comment', '%1$s Comments', $comments_number, 'comments title', 'farmart' ) ),
			        number_format_i18n( $comments_number )
		        );
	        } else {
		        printf( esc_html__( 'No comment', 'farmart' ) );
	        }
	        ?>
        </h3><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

        <ol class="comment-list <?php echo esc_attr( $comments_class ); ?>">
			<?php
			wp_list_comments( array(
				'avatar_size' => 60,
				'short_ping'  => true,
				'callback'   => 'farmart_comment'
			) );
			?>
        </ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
            <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'farmart' ); ?></p>
		<?php
		endif;

	endif; // Check for have_comments().
	$comment_field = '<p class="comment-form-comment"><textarea required id="comment" placeholder="' . esc_attr__( 'Content', 'farmart' ) . '" name="comment" cols="45" rows="7" aria-required="true"></textarea></p>';
	comment_form(
		array(
			'title_reply' => ''.esc_html__( 'Leave A Comment ','farmart'),
			'format'        => 'xhtml',
			'comment_field' => $comment_field,
		)
	)
	?>

</div><!-- #comments -->
