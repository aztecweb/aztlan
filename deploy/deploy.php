<?php
/**
 * Configuração para gestão de deploy
 */
namespace Deployer;

require 'recipe/common.php';

host('ambiente.aztecweb.net')
    ->port(2201)
    ->stage('staging')
	->user('ambiente_staging')
	->set('branch', '10-configuracao-do-deploy')
	->set('deploy_path', '/home/ambiente_staging');



set('ssh_multiplexing', false);

set('http_user', 'www-data');
set('repository', 'git@greatcode.aztecweb.net:aztecwebteam/ambiente.git');

set('shared_files', [
	'environment/env/app.env',
	'environment/env/install.env'
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
	run('cd {{release_path}} && environment/bin/install', [ 'timeout' => null ]);
});

/**
 * Move arquivo app.env, se ele existe, da raiz para o diretório shared
 */
task('deploy:update_env', function() {
	run('cd {{deploy_path}} && if [ -d env ]; then mkdir -p shared/environment/env/ && mv env/* shared/environment/env/ && rmdir env; fi');
});

task('deploy', [
	'deploy:prepare',
	'deploy:lock',
	'deploy:release',
	'deploy:update_code',
	'deploy:shared',
	'deploy:update_env',
	'deploy:install',
	// 'deploy:writable',
	// 'deploy:clear_paths',
	// 'deploy:symlink',
	// 'deploy:unlock',
	// 'cleanup',
	// 'success'
]);
