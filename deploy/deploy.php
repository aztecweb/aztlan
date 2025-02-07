<?php

/**
 * Deploy settings
 *
 * This file contains settings and tasks for deployment using Deployer.
 */

declare(strict_types=1);

namespace Deployer;

require 'recipe/common.php';

host( 'staging' )
	->set( 'hostname', '207.246.74.78' )
	->set( 'port', 2201 )
	->set( 'remote_user', 'ambiente_staging' )
	->set( 'labels', array( 'stage' => 'staging' ) )
	->set( 'user', 'ambiente_staging' )
	->set( 'branch', 'staging' )
	->set( 'deploy_path', '/home/ambiente_staging' );

set( 'http_user', 'www-data' );
if ( true === isset( $_SERVER['HTTP_USER'] ) ) {
	set( 'http_user', $_SERVER['HTTP_USER'] );  // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
}
set( 'repository', 'git@git.aztecweb.net:aztecwebteam/ambiente.git' );
set( 'keep_releases', '3' );
set( 'writable_recursive', true );
set( 'update_code_strategy', 'clone' );
set( 'cache_symlink_path', '/var/cache/sites/{{user}}' );
set( 'cache_dir', '{{release_path}}/public/packages/cache' );

set(
	'shared_files',
	array(
		'.env',
	)
);

set(
	'shared_dirs',
	array(
		'public/packages/uploads',
	)
);

task(
	'deploy:build',
	function () {
		run( 'cd {{release_path}} && environment/bin/build dist filesystem', array( 'timeout' => null ) );
	}
);

task(
	'deploy:install',
	function () {
		run( 'cd {{release_path}} && set -o allexport && source .env && set +o allexport && environment/bin/aztlan-install', array( 'timeout' => null ) );
	}
);

/**
 * Move .env to shared, if file exists
 */
task(
	'deploy:update_env',
	function () {
		run( 'cd {{deploy_path}} && if [ -d env ]; then mv env/* shared/ && rmdir env; fi' );
	}
);

task(
	'deploy:restart_services',
	function () {
		try {
			$has_sudo_permissions = test( 'sudo -v' );

			if ( ! $has_sudo_permissions ) {
				writeln( '<error>FPM and NGINX need to be restarted manually.</error>' );
				return;
			}

			if ( true === isset( $_SERVER['PHP_VERSION'] ) ) {
				preg_match( '/\d.\d/', $_SERVER['PHP_VERSION'], $php_version ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			}

			run( 'sudo service php' . reset( $php_version ) . '-fpm reload' );
			run( 'sudo bash -c "nginx -t && service nginx reload"' );
		} catch ( \Deployer\Exception\RunException $e ) {
			writeln( '<error>FPM and NGINX need to be restarted manually.</error>' );
		}
	}
);

task(
	'deploy:symlink_cache',
	function () {
		$cache_exists_command = '[ -d {{cache_symlink_path}} ]';
		if ( test( $cache_exists_command ) ) {
			run( 'rm -rf {{cache_dir}}', array( 'timeout' => null ) );
			run( 'ln -s {{cache_symlink_path}} {{cache_dir}}', array( 'timeout' => null ) );
			writeln( '<info>Symlink created: {{release_path}}/public/packages/cache -> {{cache_symlink_path}}</info>' );
		} else {
			writeln( '<info>Cache directory does not exist, skipping symlink creation.</info>' );
		}
	}
);

task(
	'deploy',
	array(
		'deploy:prepare',
		'deploy:update_env',
		'deploy:build',
		'deploy:install',
		'deploy:clear_paths',
		'deploy:symlink',
		'deploy:symlink_cache',
		'deploy:restart_services',
		'deploy:unlock',
		'deploy:cleanup',
		'deploy:success',
	)
);

after( 'rollback', 'deploy:restart_services' );
