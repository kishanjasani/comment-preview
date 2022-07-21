<?php
/**
 * Template to add options in comment's form.
 *
 * @package CommentPreview
 */

?>

<div class="comment-form-markdown">

	<input type="radio" id="format-markdown-radio" name="comment_format" value="markdown" checked="checked">
	<label for="format-markdown-radio"><?php esc_html_e( 'Use', 'comment-preview' ); ?> <a href="https://commonmark.org/help/"><?php esc_html_e( 'markdown', 'comment-preview' ); ?></a></label>

	<input type="radio" id="format-text-radio" name="comment_format" value="text">
	<label for="format-text-radio"><?php esc_html_e( 'Use plain text', 'comment-preview' ); ?></label>

</div>
