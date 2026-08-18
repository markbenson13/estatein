<?php
/**
 * Comment list + form template.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title h4">
			<?php
			printf(
				/* translators: %d: number of comments. */
				esc_html( _n( '%d Comment', '%d Comments', get_comments_number(), 'estatein' ) ),
				(int) get_comments_number()
			);
			?>
		</h2>

		<ol class="comment-list list-unstyled d-flex flex-column gap-3 mb-4">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 44,
				)
			);
			?>
		</ol>

		<?php estatein_pagination(); ?>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="no-comments text-body-secondary"><?php esc_html_e( 'Comments are closed.', 'estatein' ); ?></p>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'class_submit'  => 'btn btn-primary',
			'class_form'    => 'comment-form',
			'title_reply'   => __( 'Leave a Comment', 'estatein' ),
			'comment_field' => '<div class="mb-3"><label for="comment" class="form-label small">' . _x( 'Comment', 'noun', 'estatein' ) . '</label><textarea id="comment" name="comment" class="form-control" rows="6" required></textarea></div>',
		)
	);
	?>
</div>
