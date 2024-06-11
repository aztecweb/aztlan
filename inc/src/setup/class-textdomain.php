<?php
/**
 * Textdomain class
 *
 * @package Aztec
 */

declare(strict_types = 1);

namespace Aztec\Setup;

use Aztec\Base;

/**
 * Load translation files
 */
class Textdomain extends Base {
	/**
	 * Add hooks
	 */
	public function init(): void {
		add_action( 'after_setup_theme', $this->callback( 'load_textdomain' ) );
	}

	/**
	 * Load the installation locale theme language file
	 */
	public function load_textdomain(): void {
		load_theme_textdomain( 'env-theme', get_stylesheet_directory() . '/languages' );
		load_textdomain( 'env-theme_inc', ABSPATH . '../../inc/languages/env-theme_inc-' . determine_locale() . '.mo' );
	}
}
