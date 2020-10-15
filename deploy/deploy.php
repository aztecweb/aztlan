<?php
/**
 * Deploy settings
 */
namespace Deployer;

require 'recipe/common.php';

host( 'staging' )
	->hostname( $_ENV[ 'DEP_STG_HOST' ] )
	->port( $_ENV[ 'DEP_STG_PORT' ] )
	->stage( 'staging' )
	->user( $_ENV[ 'DEP_STG_USER' ] )
	->set( 'branch', $_ENV[ 'DEP_STG_BRANCH' ] )
	->set( 'deploy_path', $_ENV[ 'DEP_STG_PATH' ] );

set( 'http_user', $_ENV[ 'DEP_HTTP_USER' ] );
set( 'repository', $_ENV[ 'DEP_REPOSITORY' ] );

set( 'shared_files', array(
	'environment/env/app.env',
	'environment/env/install.env'
) );

set( 'shared_dirs', array(
	'public/packages/uploads'
) );

set( 'writable_dirs', array(
	'public/packages/uploads',
	'public/packages/languages',
	'public/packages/upgrade'
) );

task( 'deploy:install', function() {
	run( 'cd {{release_path}} && environment/bin/install', [ 'timeout' => null ] );
} );

/**
 * Move app.env to shared, if file exists
 */
task( 'deploy:update_env', function() {
	run( 'cd {{deploy_path}} && if [ -d env ]; then mkdir -p shared/environment/env/ && mv env/* shared/environment/env/ && rmdir env; fi' );
} );

task( 'deploy', array(
	'deploy:prepare',
	'deploy:lock',
	'deploy:release',
	'deploy:update_code',
	'deploy:shared',
	'deploy:update_env',
	'deploy:install',
	'deploy:writable',
	'deploy:clear_paths',
	'deploy:symlink',
	'deploy:unlock',
	'cleanup',
	'success'
) );
