<?php

declare(strict_types = 1);

namespace Aztec\Aztlan\Integration;

use Aztec\Base;

class Livereload extends Base {

	public function init() : void {
		add_action( 'wp_enqueue_scripts', $this->callback( 'enqueue_script' ), 999 );
	}

	/**
	 * Add Livereload JS on development environment
	 */
	public function enqueue_script() : void {
		$env = isset( $_SERVER['ENV'] ) ? sanitize_text_field( wp_unslash( $_SERVER['ENV'] ) ) : 'development';

		if ( 'development' === $env ) {
			wp_enqueue_script( 'aztec-env-livereload', 'http://localhost:35729/livereload.js?snipver=1', array(), self::VERSION, true );
		}
	}
}
