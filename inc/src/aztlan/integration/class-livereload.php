<?php
/**
 * Livereload class
 *
 * @package Aztec
 */

declare(strict_types = 1);

namespace Aztec\Aztlan\Integration;

use Aztec\Base;

/**
 * Enable live reload on development environment
 */
class Livereload extends Base {
	/**
	 * Add hooks and filters
	 */
	public function init() : void {
		add_action( 'wp_enqueue_scripts', $this->callback( 'enqueue_script' ), 999 );
	}

	/**
	 * Add live reload JS
	 */
	public function enqueue_script() : void {
		if ( 'development' === $_ENV['ENV'] ) {
			wp_enqueue_script( 'aztec-env-livereload', 'http://localhost:35729/livereload.js?snipver=1', array(), self::VERSION, true );
		}
	}
}
