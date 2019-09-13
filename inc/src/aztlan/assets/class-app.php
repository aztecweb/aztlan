<?php
/**
 * App assets class
 *
 * @package Aztec
 */

namespace Aztec\Aztlan\Assets;

/**
 * Load application assets
 */
class App extends Assets {

	/**
	 * Config to load the application assets
	 */
	public function init() {
		$this->set_file( 'app' );
		$this->set_enqueue_hook( 'wp_enqueue_scripts' );
		$this->add_hooks();
	}
}
