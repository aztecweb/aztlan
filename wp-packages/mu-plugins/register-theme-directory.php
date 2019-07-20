<?php
/*
Plugin Name:  Register Theme Directory
Description:  Register theme directory from application environment
Version:      1.0.0
Author:       Aztec Online Solutions
Author URI:   https://aztecweb.net/
License:      GPLv2
*/

namespace Aztec_MU_Plugin;

final class Register_Theme_Directory {

	/**
	 * Environment themes directory path
	 *
	 * @var string
	 */
	private $theme_directory;

	/**
	 * The instance
	 *
     * @var Register_Theme_Directory
     */
	private static $instance;

    /**
     * Get the instance via lazy initialization
     */
    public static function get_instance() {
        if( null === static::$instance ) {
            static::$instance = new static();
		}

        return static::$instance;
	}

	/**
     * Prevent the instance from being cloned (which would create a second
	 * instance of it)
     */
	private function __clone() {}

    /**
     * Prevent from being unserialized (which would create a second instance of
	 * it)
     */
    private function __wakeup() {}

	/**
	 * Start the object
	 */
	private function __construct() {
		$this->theme_directory = dirname( dirname( ABSPATH ) ) . '/themes';

		$this->register_theme();
		$this->fix_root_path( 'template' );
		$this->fix_root_path( 'stylesheet' );

		\add_filter( 'theme_root_uri', array( $this, 'theme_root_uri' ), 10, 3 );
	}

	/**
	 * Register the environment themes directory on WordPress
	 */
	private function register_theme() {
		\register_theme_directory( $this->theme_directory );
	}

	/**
	 * Fix the template or stylesheet root path
	 *
	 * This fix is necessary for application that works with deploys that
	 * create a new directory on each build. The function set the root path
	 * of the release into options table.
	 *
	 * @param string $kind The kind of theme that is being fixes. Just work
	 *                     with 'template' and 'stylesheet'.
	 */
	private function fix_root_path( $kind ) {
		$theme = ( 'template' === $kind ) ? \get_template() : \get_stylesheet();

		// Check if the current theme is on environment themes directory
		if( ! in_array( $theme, scandir( $this->theme_directory ) ) ) {
			return;
		}

		$option              = $kind .'_root';
		$theme_root_path     = \get_option( $option );
		$new_theme_root_path = $this->theme_directory;

		// Check if the path already is the same
		if( $new_theme_root_path === $theme_root_path ) {
			return;
		}

		\update_option( $option, $new_theme_root_path );
	}

	/**
	 * Define environment themes URL
	 *
	 * @param string $theme_root_uri         Default theme root URI.
	 * @param string $site_url               Site URL.
	 * @param string $stylesheet_or_template Theme slug.
	 * @return string The right default theme root URI.
	 */
	public function theme_root_uri( $theme_root_uri, $site_url, $stylesheet_or_template ) {
		if( $this->theme_directory !== $theme_root_uri ) {
			return $theme_root_uri;
		}

		return $site_url . '/themes';
	}
}

Register_Theme_Directory::get_instance();
