<?php
/**
 * Class to manage functions for comment preview.
 *
 * @package CommentPreview
 */

namespace CommentPreview\Inc;

/**
 * Class for comment preview functionality.
 *
 * @package CommentPreview\Inc
 */
class CommentPreview {

	/**
	 * Class constructor.
	 */
	public function __construct() {

		$assets = new Assets();
		$this->setup_hooks();
	}

	/**
	 * Initialize actions and filters.
	 */
	protected function setup_hooks() {

		// Add Preview Button.
		add_filter( 'comment_form_submit_button', [ $this, 'add_preview_button' ], 20 );

	}

	/**
	 * Append a button to allow commenters to preview their comment.
	 *
	 * @param string $submit_button HTML to output for the submit button.
	 *
	 * @return string Modified HTML
	 */
	public function add_preview_button( $submit_button = '' ) {
		$preview_button = sprintf(
			'<input name="preview-button" type="button" id="preview-button" class="submit" value="%1$s">',
			esc_html__( 'Preview', 'comment-preview' )
		);

		return $submit_button . ' ' . $preview_button;
	}

}
