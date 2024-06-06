<?php
/**
 * Main plugin file for comment preview functionality.
 *
 * @package CommentPreview
 */

namespace CommentPreview\Inc;

use CommentPreview\Inc\Assets;
use CommentPreview\Inc\CommentHandler;

/**
 * Main plugin class.
 *
 * @package CommentPreview
 */
class CommentPreview {

	/**
	 * Instance of Assets.
	 *
	 * @var Assets
	 */
	private $assets;

	/**
	 * Instance of CommentHandler.
	 *
	 * @var CommentHandler
	 */
	private $comment_handler;

	/**
	 * Class constructor.
	 *
	 * @param Assets $assets Instance of Assets.
	 * @param CommentHandler $comment_handler Instance of CommentHandler.
	 */
	public function __construct( Assets $assets, CommentHandler $comment_handler) {
		$this->assets = $assets;
		$this->comment_handler = $comment_handler;
	}

	/**
	 * Initialize actions and filters.
	 */
	public function setup_hooks() {
		add_filter( 'comment_form_submit_button', [ $this->comment_handler, 'add_preview_button' ], 20 );
		add_filter( 'comment_form_fields', [ $this->comment_handler, 'comment_form_fields' ], 20 );
		add_filter( 'comment_form_field_comment', [ $this->comment_handler, 'add_markdown_option' ], 20 );
		add_action( 'rest_api_init', [ $this->comment_handler, 'register_rest_route' ] );
		add_action( 'wp_enqueue_scripts', [ $this->assets, 'enqueue_scripts' ] );
	}
}
