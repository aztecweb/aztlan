<?php

declare(strict_types = 1);

namespace Aztec\Aztlan\Assets;

use Aztec\Base;
use DI\Container;

/**
 * This class manage the environment assets file
 *
 * It is considered that a set of assets is compound by a JS, CSS and a JSON textdomain
 * file for the current locale. The responsible to doesn't load some of these files if
 * they don't exist is of WordPress API.
 */
class Assets extends Base {

	private string $handle_base = 'aztlan';

	private string $file;

	private string $language_dir;

	private string $enqueue_hook;

	public function __construct( Container $container ) {
		parent::__construct( $container );

		$this->language_dir = ABSPATH . '../../assets/languages';
	}

	protected function set_enqueue_hook( string $hook ) : void {
		$this->enqueue_hook = $hook;
	}

	protected function set_file( string $file ) : void {
		$this->file = $file;
	}

	private function handle( string $suffix = '' ) : string {
		if ( '' === $suffix ) {
			$suffix = $this->file;
		}

		return $this->handle_base . '-' . $suffix;
	}

	protected function add_hooks() : void {
		add_action( 'init', $this->callback( 'register_script' ) );
		add_action( 'init', $this->callback( 'register_style' ) );
		add_action( 'init', $this->callback( 'set_script_translations' ) );
		add_action( $this->enqueue_hook, $this->callback( 'enqueue' ) );

		add_filter( 'load_script_translation_file', $this->callback( 'load_script_translation_file' ), 10, 3 );
	}

	public function assets_uri( string $path ) : string {
		$assets_url = isset( $_SERVER['ASSETS_URL'] ) ? sanitize_text_field( wp_unslash( $_SERVER['ASSETS_URL'] ) ) : 'http://localhost';

		return $assets_url . '/' . trim( $path, '/' );
	}

	public function register_script() : void {
		$src           = $this->assets_uri( $this->file . '.js' );
		$vendor_handle = $this->handle( 'vendor' );

		wp_register_script( $vendor_handle, $this->assets_uri( 'vendor.js' ), array( 'jquery' ), self::VERSION, true );
		wp_register_script( $this->handle(), $src, array( $vendor_handle ), self::VERSION, true );
	}

	public function register_style() : void {
		$src = $this->assets_uri( $this->file . '.css' );

		wp_register_style( $this->handle(), $src, array(), self::VERSION );
	}

	public function set_script_translations() : void {
		$theme_active = isset( $_SERVER['THEME_ACTIVE'] ) ? sanitize_text_field( wp_unslash( $_SERVER['THEME_ACTIVE'] ) ) : 'aztlan';

		wp_set_script_translations( $this->handle(), $theme_active . '_assets', $this->language_dir );
	}

	/**
	 * Load the json translation file for the script
	 *
	 * As the assets is out of WordPress structure, the files must be loaded with a custom code.
	 */
	public function load_script_translation_file( string $file, string $handle, string $domain ) : string {
		if ( $this->handle() !== $handle ) {
			return $file;
		}

		$locale = get_locale();
		$md5    = md5( $this->file . '.js' );
		$file   = "{$this->language_dir}/{$domain}-{$locale}-{$md5}.json";

		return $file;
	}

	/**
	 * Enqueue assets on the page
	 */
	public function enqueue() : void {
		wp_enqueue_script( $this->handle() );
		wp_enqueue_style( $this->handle() );
	}
}
