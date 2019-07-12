<?php
/**
 * Configuração para gestão de deploy
 */
namespace Deployer;

require 'recipe/common.php';

set('ssh_multiplexing', false);

set('http_user', 'www-data');
set('repository', 'git@greatcode.aztecweb.net:aztecwebteam/ambiente.git');

set('shared_files', [
	'environment/env/app.env'
]);

set('shared_dirs', [
	'public/packages/uploads'
]);

set('writable_dirs', [
	'public/packages/uploads',
	'public/packages/languages',
	'public/packages/upgrade'
]);

task('deploy:install', function () {
    run('cd {{release_path}} && environment/bin/server-install', [ 'timeout' => null ]);
});

task('deploy', [
	'deploy:prepare',
	'deploy:lock',
	'deploy:release',
	'deploy:update_code',
	'deploy:shared',
	'deploy:install',
	'deploy:writable',
	'deploy:clear_paths',
	'deploy:symlink',
	'deploy:unlock',
	'cleanup',
	'success'
]);
