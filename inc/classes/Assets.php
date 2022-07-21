<?php
/**
 * Assets for Comment Preview.
 *
 * @package CommentPreview
 */

namespace CommentPreview\Inc;

/**
 * Assets.
 *
 * @package CommentPreview\Inc
 */
class Assets {

	/**
	 * Class constructor.
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
	}

	/**
	 * Enqueue scripts to load comment preview.
	 */
	public function enqueue_scripts() {
		error_log( 'hello' );
		/**
		 * Filter to enable comment preview on custom post types.
		 *
		 * @param array List of post types.
		 */
		$post_types = apply_filters( 'comment_preview_allowed_post_types', array( 'post' ) );

		wp_register_script(
			'comment-preview',
			COMMENT_PREVIEW_URL . '/assets/js/comment-preview.js',
			array(),
			filemtime( COMMENT_PREVIEW_PATH . '/assets/js/comment-preview.js' ),
			true
		);

		wp_localize_script(
			'comment-preview',
			'commentPreviewData',
			array(
				'apiURL' => get_rest_url( null, 'wp_comment_preview/v1/' ),
				'nonce'  => wp_create_nonce( 'wp_rest' ),
			)
		);

		if ( is_singular( $post_types ) ) {
			wp_enqueue_script( 'comment-preview' );
		}
	}
}
