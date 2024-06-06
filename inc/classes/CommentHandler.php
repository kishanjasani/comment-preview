<?php
/**
 * Class to manage functions for comment preview.
 *
 * @package CommentPreview\Inc
 */

namespace CommentPreview\Inc;

/**
 * CommentHandler class.
 *
 * @package CommentPreview\Inc
 */
class CommentHandler {

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

	/**
	 * Add custom markup to comment form.
	 *
	 * @param array $comment_fields Comment fields.
	 *
	 * @return array Modified comment fields.
	 */
	public function comment_form_fields( array $comment_fields = [] ) {
		ob_start();

		// Get template file output.
		include_once COMMENT_PREVIEW_PATH . 'templates/comment-preview.php';

		$field = ob_get_clean();

		if ( ! empty( $field ) ) {
			$comment_fields['comment'] = '<div id="preview-wrapper"></div>' . $comment_fields['comment'];
			$comment_fields['comment'] .= $field;
		}

		return $comment_fields;
	}

	/**
	 * Register the route for generating comment previews.
	 */
	public function register_rest_route() {
		register_rest_route(
			'comment_preview/v1',
			'preview',
			[
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => [ $this, 'generate_preview' ],
				'permission_callback' => '__return_true',
			]
		);
	}

	/**
	 * Processes a comment for preview.
	 *
	 * @param array $request Full details about the request.
	 *
	 * @return array Response object.
	 */
	public function generate_preview( $request ) {
		$response = [];

		if ( ! empty( $request['author'] ) ) {
			$response['author'] = esc_html( $request['author'] );
		}

		$user_id = ( ( is_user_logged_in() ) ? get_current_user_id() : 0 );

		if ( ! empty( $user_id ) && empty( $response['author'] ) ) {
			$user = get_userdata( $user_id );
			if ( $user ) {
				$response['author'] = $user->data->display_name;
			}
		}

		$response['gravatar'] = get_avatar_url( $user_id, [ 'size' => 50 ] );
		$response['date'] = current_time( get_option( 'date_format' ) . ' \a\t ' . get_option( 'time_format' ) );

		if ( ! empty( $request['comment'] ) && isset( $request['format'] ) ) {
			if ( 'text' === $request['format'] ) {
				$comment = wp_kses_data( $request['comment'] );
			} else {
				$comment = apply_filters( 'pre_comment_content', $request['comment'] );
			}
		} else {
			$comment = '';
		}

		$response['comment'] = $comment;

		return $response;
	}

	/**
	 * Add radio buttons to allow a commenter to format their comment in
	 * either markdown or plain text.
	 *
	 * @param string $fields HTML to output for the comment field.
	 *
	 * @return string HTML.
	 */
	public function add_markdown_option( $fields ) {
		ob_start();

		// Get template file output.
		include_once COMMENT_PREVIEW_PATH . 'templates/markdown-option.php';

		$markdown_options = ob_get_clean();

		return $fields . $markdown_options;
	}
}
