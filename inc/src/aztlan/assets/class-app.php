<?php

declare(strict_types = 1);

namespace Aztec\Aztlan\Assets;

class App extends Assets {

	/**
	 * Config to load the application assets
	 */
	public function init() : void {
		$this->set_file( 'app' );
		$this->set_enqueue_hook( 'wp_enqueue_scripts' );
		$this->add_hooks();
	}
}
