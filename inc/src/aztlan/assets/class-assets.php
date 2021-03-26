<?php
/**
 * Aztlan assets WordPress integration base class
 *
 * @package Aztec
 */

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

	/**
	 * Base of the handle to the assets
	 *
	 * @var string
	 */
	private string $handle_base = 'aztlan';

	/**
	 * The name of the file for the CSS and JS
	 *
	 * @var string
	 */
	private string $file;

	/**
	 * The path of the language directory
	 *
	 * @var string
	 */
	private string $language_dir;

	/**
	 * The action hook used to enqueue the scripts
	 *
	 * @var string
	 */
	private string $enqueue_hook;

	/**
	 * Constructor
	 *
	 * @param Container $container The application container.
	 */
	public function __construct( Container $container ) {
		parent::__construct( $container );

		$this->language_dir = ABSPATH . '../../assets/languages';
	}

	/**
	 * Set the hook that will be used to enqueue the assets on the page
	 *
	 * @param string $hook The enqueue hook.
	 */
	protected function set_enqueue_hook( string $hook ) : void {
		$this->enqueue_hook = $hook;
	}

	/**
	 * Set the file that will be loaded
	 *
	 * @param string $file The file base name to css and js.
	 */
	protected function set_file( $file ) : void {
		$this->file = $file;
	}

	/**
	 * Generate a handle for the assets
	 *
	 * @param string $suffix An optional suffix. Default: The asset file name.
	 * @return string The handle.
	 */
	private function handle( string $suffix = '' ) : string {
		if ( '' === $suffix ) {
			$suffix = $this->file;
		}

		return $this->handle_base . '-' . $suffix;
	}

	/**
	 * Add the hooks to WordPress
	 */
	protected function add_hooks() : void {
		add_action( 'init', $this->callback( 'register_script' ) );
		add_action( 'init', $this->callback( 'register_style' ) );
		add_action( 'init', $this->callback( 'set_script_translations' ) );
		add_action( $this->enqueue_hook, $this->callback( 'enqueue' ) );

		add_filter( 'load_script_translation_file', $this->callback( 'load_script_translation_file' ), 10, 3 );
	}

	/**
	 * Get assets URI
	 *
	 * @param  string $path File path.
	 * @return string
	 */
	public function assets_uri( $path ) : string {
		return $_ENV['ASSETS_URL'] . '/' . trim( $path, '/' );
	}

	/**
	 * Register the script
	 *
	 * Ensure that the vendor is registered too.
	 */
	public function register_script() : void {
		$src           = $this->assets_uri( $this->file . '.js' );
		$vendor_handle = $this->handle( 'vendor' );

		wp_register_script( $vendor_handle, $this->assets_uri( 'vendor.js' ), array( 'jquery' ), self::VERSION, true );
		wp_register_script( $this->handle(), $src, array( $vendor_handle ), self::VERSION, true );
	}

	/**
	 * Register the style
	 */
	public function register_style() : void {
		$src = $this->assets_uri( $this->file . '.css' );

		wp_register_style( $this->handle(), $src, array(), self::VERSION );
	}

	/**
	 * Set translations for editor script
	 */
	public function set_script_translations() : void {
		wp_set_script_translations( $this->handle(), $_ENV['THEME_ACTIVE'] . '_assets', $this->language_dir );
	}

	/**
	 * Load the json translation file for the script
	 *
	 * As the assets is out of WordPress structure, the files must be loaded
	 * with a custom code.
	 *
	 * @param string $file The current file path.
	 * @param string $handle The script handle.
	 * @param string $domain The translation domain.
	 * @return string The translation file for the script.
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
