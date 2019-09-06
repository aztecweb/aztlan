<?php
/**
 * Assets class
 *
 * @package Aztec
 */

namespace Aztec\Setup;

use Aztec\Base;
use DI\Container;

/**
 * Add Scripts and Styles
 */
class Assets extends Base {
	/**
	 * Add hooks
	 */
	public function init() {
		add_action( 'wp_enqueue_scripts', $this->callback( 'enqueue_styles' ), 1 );
		add_action( 'wp_enqueue_scripts', $this->callback( 'enqueue_script' ) );
	}

	/**
	 * Get assets URI
	 *
	 * @param  string $path File path.
	 * @return string
	 */
	private function assets_uri( $path ) {
		return getenv( 'ASSETS_URL' ) . '/' . trim( $path, '/' );
	}

	/**
	 * Load application style
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'aztec-env', $this->assets_uri( 'app.css' ), array(), self::VERSION );
	}

	/**
	 * Load application script
	 */
	public function enqueue_script() {
		wp_enqueue_script( 'aztec-env-vendor', $this->assets_uri( 'vendor.js' ), array( 'jquery' ), self::VERSION, true );
		wp_enqueue_script( 'aztec-env-app', $this->assets_uri( 'app.js' ), array(), self::VERSION, true );

		// Append PHP data to JS.
		wp_localize_script(
			'aztec-env-app',
			'aztec_env',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
			)
		);
	}
}
