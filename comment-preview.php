<?php

declare( strict_types = 1 );

/**
 * Plugin Name:       Comment Preview
 * Description:       Allow to display comment preview.
 * Plugin URI:        https://github.com/kishanjasani/comment-preview
 * Author:            Kishan Jasani
 * Author URI:        https://kishanjasani.wordpress.com/
 * Version:           0.1.0
 * License:           GPLv3
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path:       /languages
 * Text Domain:       comment-preview
 *
 * @package CommentPreview
 */

use CommentPreview\Inc\CommentPreview;
use CommentPreview\Inc\Assets;
use CommentPreview\Inc\CommentHandler;

define( 'COMMENT_PREVIEW_URL', plugin_dir_url( __FILE__ ) );
define( 'COMMENT_PREVIEW_PATH', plugin_dir_path( __FILE__ ) );

// Composer autoloder file.
if ( is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

// Initialize the plugin.
add_action( 'plugins_loaded', function() {
	$assets = new Assets();
	$comment_handler = new CommentHandler();
	$comment_preview = new CommentPreview( $assets, $comment_handler );
	$comment_preview->setup_hooks();
} );
