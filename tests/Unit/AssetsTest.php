<?php

namespace CommentPreview\Tests\Unit;

use Mockery;
use Brain\Monkey;
use Brain\Monkey\Functions;
use Brain\Monkey\Actions;
use CommentPreview\Inc\Assets;

class AssetsTest extends AbstractUnitTestcase {

	public function testEnqueueScripts() {
		$assets = new Assets();

		// Mock the filemtime function to return a fixed timestamp.
		Functions\expect('filemtime')
			->once()
			->with(COMMENT_PREVIEW_PATH . '/assets/js/comment-preview.js')
			->andReturn(123456);

		// Mock the get_rest_url function to return a fixed URL.
		Functions\expect('get_rest_url')
			->once()
			->with(null, 'comment_preview/v1/')
			->andReturn('http://example.com/wp-json/comment_preview/v1/');

		// Mock the wp_create_nonce function to return a fixed nonce.
		Functions\expect('wp_create_nonce')
			->once()
			->with('wp_rest')
			->andReturn('fake_nonce');

		// Mock the apply_filters function to return a list of post types.
		Functions\expect('apply_filters')
			->once()
			->with('comment_preview_allowed_post_types', ['post'])
			->andReturn(['post']);

		// Mock the is_singular function to return true.
		Functions\expect('is_singular')
			->once()
			->with(['post'])
			->andReturn(true);

		// Expect wp_register_script to be called with the correct parameters.
		Functions\expect('wp_register_script')
			->once()
			->with(
				'comment-preview',
				COMMENT_PREVIEW_URL . '/assets/js/comment-preview.js',
				[],
				123456,
				true
			);

		// Expect wp_localize_script to be called with the correct parameters.
		Functions\expect('wp_localize_script')
			->once()
			->with(
				'comment-preview',
				'commentPreviewData',
				[
					'apiURL' => 'http://example.com/wp-json/comment_preview/v1/',
					'nonce'  => 'fake_nonce',
				]
			);

		// Expect wp_enqueue_script to be called with the correct parameters.
		Functions\expect('wp_enqueue_script')
			->once()
			->with('comment-preview');

		// Call the enqueue_scripts method.
		$assets->enqueue_scripts();

		self::assertTrue( true ); // To pass the test cases and confirm methos works as expected.
	}
}
