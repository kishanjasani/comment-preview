<?php
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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

define( 'COMMENT_PREVIEW_URL', plugin_dir_url( __FILE__ ) );
define( 'COMMENT_PREVIEW_PATH', plugin_dir_path( __FILE__ ) );

// Composer autoloder file.
require_once __DIR__ . '/vendor/autoload.php';

new \CommentPreview\Inc\CommentPreview();
