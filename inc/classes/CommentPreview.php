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

		// Display preview.
		add_filter( 'comment_form_fields', [ $this, 'comment_form_fields' ], 20 );

		add_action( 'rest_api_init', [ $this, 'register_rest_route' ] );

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

	/**
	 * Add custom markup to comment form.
	 *
	 * @param array $comment_fields Comment fields.
	 *
	 * @return mixed
	 */
	public function comment_form_fields( array $comment_fields = array() ) {

		ob_start();

		// Get template file output.
		include_once COMMENT_PREVIEW_PATH . 'templates/comment-preview.php';

		// Save output and stop output buffering.
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
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => [ $this, 'generate_preview' ],
				'permission_callback' => '__return_true',
			)
		);
	}

	/**
	 * Processes a comment for preview.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 *
	 * @return array Response object.
	 */
	public function generate_preview( $request ) {
		$response = array();

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

		$response['gravatar'] = get_avatar_url( $user_id, array( 'size' => 50 ) );

		$response['date'] = current_time( get_option( 'date_format' ) . ' \a\t ' . get_option( 'time_format' ) );

		if ( ! empty( $request['comment'] ) ) {
			$comment = apply_filters( 'pre_comment_content', $request['comment'] );
		} else {
			$comment = '';
		}

		$response['comment'] = $comment;

		return $response;
	}
}
