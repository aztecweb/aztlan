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
    private function __wakeup() {}

	/**
	 * Start the object
	 */
	private function __construct() {
		// \add_filter( 'redirect_network_admin_request', array( $this, 'redirect_network_admin_request' ) );
		\add_filter( 'network_site_url', array( $this, 'network_site_url' ), 10, 3 );
	}

	// /**
	//  * Changes the validation of the redirect_network_admin_request to follow
	//  * the Aztlan standard that uses / wp in the path
	//  *
	//  * @param bool $redirect_network_admin_request
	//  * @return bool
	//  */
	// public function redirect_network_admin_request( $redirect_network_admin_request ) {
	// 	global $current_blog, $current_site;

	// 	if( 0 !== strcasecmp( $current_blog->domain, $current_site->domain ) ) {
	// 		return true;
	// 	}

	// 	$slash_regex = '/(\/+)/';
	// 	$current_blog_path = preg_replace( $slash_regex, '/', $current_blog->path . PATH_CURRENT_SITE );

	// 	return 0 !== strcasecmp( $current_blog_path, $current_site->path );
	// }

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
