<?php
/**
 * Assets for Comment Preview.
 *
 * @package CommentPreview\Inc
 */

namespace CommentPreview\Inc;

/**
 * Assets class.
 *
 * @package CommentPreview\Inc
 */
class Assets {

	/**
	 * Enqueue scripts to load comment preview.
	 */
	public function enqueue_scripts() {
		$post_types = apply_filters( 'comment_preview_allowed_post_types', [ 'post' ] );

		wp_register_script(
			'comment-preview',
			COMMENT_PREVIEW_URL . '/assets/js/comment-preview.js',
			[],
			filemtime( COMMENT_PREVIEW_PATH . '/assets/js/comment-preview.js' ),
			true
		);

		wp_localize_script(
			'comment-preview',
			'commentPreviewData',
			[
				'apiURL' => get_rest_url( null, 'comment_preview/v1/' ),
				'nonce'  => wp_create_nonce( 'wp_rest' ),
			]
		);

		if ( is_singular( $post_types ) ) {
			wp_enqueue_script( 'comment-preview' );
		}
	}
}
