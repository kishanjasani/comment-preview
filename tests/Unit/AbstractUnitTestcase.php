<?php

declare( strict_types = 1 );

namespace CommentPreview\Tests\Unit;

use Brain\Monkey;
use PHPUnit\Framework\TestCase;

abstract class AbstractUnitTestcase extends TestCase {
    /**
     * Sets up the environment.
     *
     * @return void
     */
    protected function setUp(): void {
        parent::setUp();
        Monkey\setUp();

		if ( ! defined( 'COMMENT_PREVIEW_PATH' ) ) {
			define( 'COMMENT_PREVIEW_PATH', dirname( dirname( dirname( __FILE__ ) ) ) . '/' );
		}

		if ( ! defined( 'COMMENT_PREVIEW_URL' ) ) {
			define( 'COMMENT_PREVIEW_URL', dirname( dirname( dirname( __FILE__ ) ) ) . '/' );
		}
    }

    /**
     * Tears down the environment.
     *
     * @return void
     */
    protected function tearDown(): void {
        Monkey\tearDown();
        parent::tearDown();
    }
}
