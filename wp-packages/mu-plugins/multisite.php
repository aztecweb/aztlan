<?php
/*
Plugin Name:  Multisite custom config
Description:  Register multisite application environment
Version:      1.0.0
Author:       Aztec Online Solutions
Author URI:   https://aztecweb.net/
License:      GPLv2
*/

namespace Aztec_MU_Plugin;

final class Multisite {

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
    public function __wakeup() {}

	/**
	 * Start the object
	 */
	private function __construct() {
		\add_filter( 'network_site_url', array( $this, 'network_site_url' ), 10, 3 );
	}

	/**
	 * Filters the network site URL.
	 *
	 * @param string      $url    The complete network site URL including scheme and path.
	 * @param string      $path   Path relative to the network site URL. Blank string if
	 *                            no path is specified.
	 * @param string|null $scheme Scheme to give the URL context. Accepts 'http', 'https',
	 *                            'relative' or null.
	 */
	public function network_site_url( $url, $path, $scheme ) {
		$url = trailingslashit( WP_SITEURL ) . $path;

		return $url;
	}


}

Multisite::get_instance();
