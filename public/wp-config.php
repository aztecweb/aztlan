<?php

$root_dir = dirname( __DIR__ );
$webroot_dir = $root_dir . '/public';

require_once $root_dir . '/inc/vendor/autoload.php';

$wppackages_autoload_file = $root_dir . '/wp-packages/vendor/autoload.php';
if (file_exists($wppackages_autoload_file)) {
	require_once $wppackages_autoload_file;
}

/**
 * Load environment variables
 */
if ( null === $_SERVER[ 'WP_HOME' ] ) {
	$env_dir = $root_dir;
	$dotenv = Dotenv\Dotenv::createImmutable( $env_dir, '.env' );
	$dotenv->load();
}

/**
 * MySQL
 */
define( 'DB_NAME', $_SERVER[ 'DB_NAME' ] );
define( 'DB_USER', $_SERVER[ 'DB_USER' ] );
define( 'DB_PASSWORD', $_SERVER[ 'DB_PASSWORD' ] );
define( 'DB_HOST', $_SERVER[ 'DB_HOST' ] );
define( 'DB_CHARSET', $_SERVER[ 'DB_CHARSET' ] );
define( 'DB_COLLATE', $_SERVER[ 'DB_COLLATE' ]  );

/**
 * Authentication Unique Keys and Salts.
 */
define( 'AUTH_KEY', $_SERVER[ 'AUTH_KEY' ] );
define( 'SECURE_AUTH_KEY', $_SERVER[ 'SECURE_AUTH_KEY' ] );
define( 'LOGGED_IN_KEY', $_SERVER[ 'LOGGED_IN_KEY' ] );
define( 'NONCE_KEY', $_SERVER[ 'NONCE_KEY' ] );
define( 'AUTH_SALT', $_SERVER[ 'AUTH_SALT' ] );
define( 'SECURE_AUTH_SALT', $_SERVER[ 'SECURE_AUTH_SALT' ] );
define( 'LOGGED_IN_SALT', $_SERVER[ 'LOGGED_IN_SALT' ] );
define( 'NONCE_SALT', $_SERVER[ 'NONCE_SALT' ] );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';
if ( true === isset( $_SERVER[ 'DB_TABLE_PREFIX' ] ) ) {
	$table_prefix = $_SERVER[ 'DB_TABLE_PREFIX' ];
}

/**
 * WordPress debugging mode.
 */
if ( 'true' == $_SERVER[ 'WP_DEBUG' ] ) {
	// Enable WP_DEBUG mode
	define( 'WP_DEBUG', true );

	// Use dev versions of core JS and CSS files (only needed if you are modifying these core files)
	define( 'SCRIPT_DEBUG', true );
}

/**
 * Define WP_DEBUG_DISPLAY to WordPress don't change display_errors ini settings
 */
define( 'WP_DEBUG_DISPLAY', null );

/**
 * Define multisite consts
 */
if( 'true' === $_SERVER[ 'MULTISITE' ] ) {
	define( 'MULTISITE', 'true' === $_SERVER[ 'MULTISITE' ] );
	define( 'SUBDOMAIN_INSTALL', 'true' === $_SERVER[ 'SUBDOMAIN_INSTALL' ] );
	define( 'DOMAIN_CURRENT_SITE', $_SERVER[ 'DOMAIN_CURRENT_SITE' ] );
	define( 'PATH_CURRENT_SITE', $_SERVER[ 'PATH_CURRENT_SITE' ] );
	define( 'COOKIE_DOMAIN', $_SERVER['HTTP_HOST'] );
}

/**
 * Permite escrever diretamente em disco.
 */
define( 'FS_METHOD', 'direct' );

/**
 * Custom content directory.
 */
define( 'WP_HOME', $_SERVER[ 'WP_HOME' ] );
define( 'WP_SITEURL', $_SERVER[ 'WP_SITEURL' ] );
define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/packages' );
define( 'WP_CONTENT_URL', $_SERVER[ 'WP_HOME' ] . '/packages' );

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
