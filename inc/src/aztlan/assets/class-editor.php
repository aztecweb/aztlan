<?php
/**
 * Editor assets class
 *
 * @package Aztec
 */

namespace Aztec\Aztlan\Assets;

/**
 * Load Gutenberg editor assets
 */
class Editor extends Assets {

	/**
	 * Config to load the editor assets
	 */
	public function init() {
		$this->set_file( 'editor' );
		$this->set_enqueue_hook( 'enqueue_block_editor_assets' );
		$this->add_hooks();
	}
}
