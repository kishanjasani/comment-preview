<?php

namespace CommentPreview\Tests\Unit;

use Mockery;
use Brain\Monkey\Functions;
use CommentPreview\Inc\CommentPreview;
use CommentPreview\Inc\Assets;
use CommentPreview\Inc\CommentHandler;

class CommentPreviewTest extends AbstractUnitTestcase {

	public function testSetupHooks() {
		$assets = Mockery::mock(Assets::class);
		$commentHandler = Mockery::mock(CommentHandler::class);

		$commentPreview = new CommentPreview($assets, $commentHandler);

		// Expect the WordPress functions to be called with the correct parameters.
		Functions\expect('add_filter')
			->with('comment_form_submit_button', [$commentHandler, 'add_preview_button'], 20)
			->once();

		Functions\expect('add_filter')
			->with('comment_form_fields', [$commentHandler, 'comment_form_fields'], 20)
			->once();

		Functions\expect('add_filter')
			->with('comment_form_field_comment', [$commentHandler, 'add_markdown_option'], 20)
			->once();

		Functions\expect('add_action')
			->with('rest_api_init', [$commentHandler, 'register_rest_route'])
			->once();

		Functions\expect('add_action')
			->with('wp_enqueue_scripts', [$assets, 'enqueue_scripts'])
			->once();

		// Call the setup_hooks method.
		$commentPreview->setup_hooks();

		self::assertTrue( true ); // To pass the test cases and confirm methos works as expected.
	}
}
