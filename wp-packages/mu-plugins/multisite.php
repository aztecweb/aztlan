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

final class Multisite {

	/**
	 * Environment themes directory path
	 *
	 * @var string
	 */
	private $theme_directory;

	/**
	 * The instance
	 *
     * @var Multisite
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
		\add_filter( 'redirect_network_admin_request', array( $this, 'redirect_network_admin_request' ), 10, 3 );
	}

	public function redirect_network_admin_request( $redirect ) {
		global $current_blog, $current_site;

		return 0 !== strcasecmp( $current_blog->path . 'wp/', $current_site->path );
	}


}

Multisite::get_instance();
