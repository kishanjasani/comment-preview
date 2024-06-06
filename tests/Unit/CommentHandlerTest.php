<?php

namespace CommentPreview\Tests\Unit;

use Mockery;
use Brain\Monkey;
use Brain\Monkey\Functions;
use CommentPreview\Inc\CommentHandler;

class CommentHandlerTest extends AbstractUnitTestcase {

	protected function setUp(): void {
		parent::setUp();
		Monkey\setUp();
	}

	protected function tearDown(): void {
		Monkey\tearDown();
		Mockery::close();
		parent::tearDown();
	}

	public function testAddPreviewButton() {
		$commentHandler = new CommentHandler();

		Functions\stubTranslationFunctions();

		$submitButton = '<button type="submit">Submit</button>';
		$result = $commentHandler->add_preview_button($submitButton);

		$this->assertStringContainsString('name="preview-button"', $result);
		$this->assertStringContainsString('type="button"', $result);
		$this->assertStringContainsString('id="preview-button"', $result);
		$this->assertStringContainsString('class="submit"', $result);
		$this->assertStringContainsString('value="Preview"', $result);
	}

	public function testRegisterRestRoute() {
		$commentHandler = new CommentHandler();
		// Mock the WP_REST_Server class to avoid 'Class not found' error.
		if ( ! class_exists( 'WP_REST_Server' ) ) {
			eval( 'class WP_REST_Server { const CREATABLE = "POST"; }' );
		}

		// Expect the register_rest_route function to be called with specific parameters.
		Functions\expect( 'register_rest_route' )
			->once()
			->with(
				'comment_preview/v1',
				'preview',
				[
					'methods'             => 'POST',
					'callback'            => [ $commentHandler, 'generate_preview' ],
					'permission_callback' => '__return_true',
				]
			);

		$commentHandler->register_rest_route();

		self::assertTrue( true ); // To pass the test cases and confirm methos works as expected.
	}

	public function testGeneratePreview() {
		$commentHandler = new CommentHandler();

        $request = [
            'author'  => 'John Doe',
            'comment' => 'This is a comment.',
            'format'  => 'text'
        ];

		Functions\expect('esc_html')
			->once()
			->with('John Doe')
			->andReturn('John Doe');

		Functions\expect('is_user_logged_in')
			->once()
			->andReturn(false);

		Functions\expect('get_avatar_url')
			->once()
			->with(0, ['size' => 50])
			->andReturn('http://example.com/avatar.jpg');

		Functions\expect('current_time')
			->once()
			->andReturn('June 5, 2024 at 10:00 AM');

		Functions\expect('get_option')
			->twice()
			->andReturnUsing( function( $option ) {
				return $option === 'date_format' ? 'F j, Y' : 'g:i a';
			});

		Functions\expect('wp_kses_data')
			->once()
			->with('This is a comment.')
			->andReturn('This is a comment.');

		$response = $commentHandler->generate_preview($request);

		$this->assertArrayHasKey('author', $response);
		$this->assertEquals('John Doe', $response['author']);
		$this->assertArrayHasKey('date', $response);
		$this->assertEquals('June 5, 2024 at 10:00 AM', $response['date']);
		$this->assertArrayHasKey('comment', $response);
		$this->assertEquals('This is a comment.', $response['comment']);
	}
}
