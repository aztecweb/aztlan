<?php
/**
 * Editor assets class
 *
 * @package Aztec
 */

declare(strict_types = 1);

namespace Aztec\Aztlan\Assets;

/**
 * Load Gutenberg editor assets
 */
class Editor extends Assets {

	/**
	 * Config to load the editor assets
	 */
	public function init() : void {
		$this->set_file( 'editor' );
		$this->set_enqueue_hook( 'enqueue_block_editor_assets' );
		$this->add_hooks();
	}
}
