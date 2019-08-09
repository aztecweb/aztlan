<?php
/**
 * Textdomain class
 *
 * @package Aztec
 */

namespace Aztec\Setup;

use Aztec\Base;

/**
 * Load traslation files
 */
class Textdomain extends Base {

	/**
	 * Execute hooks
	 */
	public function init() {
		add_action( 'after_setup_theme', $this->callback( 'load_textdomain' ) );
	}

	/**
	 * Load the installation locale theme language file
	 */
	public function load_textdomain() {
		load_theme_textdomain( 'aztlan', get_stylesheet_directory() . '/languages' );
		load_theme_textdomain( 'aztlan_inc', ABSPATH . '../../inc/languages' );
	}
}
