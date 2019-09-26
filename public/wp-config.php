<?php

$root_dir = dirname( __DIR__ );
$webroot_dir = $root_dir . '/public';

require_once $root_dir . '/inc/vendor/autoload.php';

/**
 * Load environmen variables
 */
if ( false === getenv( 'ENV' ) ) {
	$env_dir = $root_dir . '/environment/env';
	$dotenv = new Dotenv\Dotenv( $env_dir, 'app.env' );
	$dotenv->load();
}

/**
 * MySQL
 */
define( 'DB_NAME', getenv( 'DB_NAME' ) );
define( 'DB_USER', getenv( 'DB_USER' ) );
define( 'DB_PASSWORD', getenv( 'DB_PASSWORD' ) );
define( 'DB_HOST', getenv( 'DB_HOST' ) );
define( 'DB_CHARSET', getenv( 'DB_CHARSET' ) );
define( 'DB_COLLATE', getenv( 'DB_COLLATE' )  );

/**
 * Authentication Unique Keys and Salts.
 */
define( 'AUTH_KEY', getenv( 'AUTH_KEY' ) );
define( 'SECURE_AUTH_KEY', getenv( 'SECURE_AUTH_KEY' ) );
define( 'LOGGED_IN_KEY', getenv( 'LOGGED_IN_KEY' ) );
define( 'NONCE_KEY', getenv( 'NONCE_KEY' ) );
define( 'AUTH_SALT', getenv( 'AUTH_SALT' ) );
define( 'SECURE_AUTH_SALT', getenv( 'SECURE_AUTH_SALT' ) );
define( 'LOGGED_IN_SALT', getenv( 'LOGGED_IN_SALT' ) );
define( 'NONCE_SALT', getenv( 'NONCE_SALT' ) );

/**
 * WordPress Database Table prefix.
 */
$table_prefix = 'wp_';

/**
 * WordPress debugging mode.
 */
if ( 'true' == getenv( 'WP_DEBUG' ) ) {
	// Enable WP_DEBUG mode
	define( 'WP_DEBUG', true );
	define( 'WCS_DEBUG', getenv( 'WCS_DEBUG' ) );

	// Enable Debug logging to the /wp-content/debug.log file
	define( 'WP_DEBUG_LOG', '/dev/stdout' );

	// Disable display of errors and warnings
	define( 'WP_DEBUG_DISPLAY', false );
	@ini_set( 'display_errors', 0 );

	// Use dev versions of core JS and CSS files (only needed if you are modifying these core files)
	define( 'SCRIPT_DEBUG', true );
}

/**
 * Permite escrever diretamente em disco.
 */
define( 'FS_METHOD', 'direct' );

/**
 * Custom content directory.
 */
define( 'WP_HOME', getenv( 'WP_HOME' ) );
define( 'WP_SITEURL', getenv( 'WP_SITEURL' ) );
define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/packages' );
define( 'WP_CONTENT_URL', getenv( 'WP_HOME' ) . '/packages' );

/**
 * Force process as HTTPS when the request is HTTPS but internally the server answer on the port 80
 */
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && strpos( $_SERVER['HTTP_X_FORWARDED_PROTO'], 'https' ) !== false ) {
	$_SERVER['HTTPS'] = 'on';
}

/**
 * Absolute path to the WordPress directory.
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', $webroot_dir . '/wp/' );
}

/**
 * Sets up WordPress vars and included files.
 */
require_once( ABSPATH . 'wp-settings.php' );
