<?php

namespace Deployer;

require 'recipe/common.php';

// Project name
set('application', 'Statamic demo site for W3C');

// Project repository
set('repository', 'git@github.com:studio24/statamic-demo.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);
set('http_user', 'apache');

// Shared files/dirs between deploys
set('shared_files', ['.env']);
set('shared_dirs', [
    'public/assets',
    'storage'
]);

// Writable dirs by web server
set('writable_dirs', ['']);
set('allow_anonymous_stats', false);

// Custom
set('keep_releases', 10);

// Composer install for custom S24.

task('deploy:s24:composer',function(){
    cd('{{release_path}}');
    run('composer install');
});

// Hosts

host('development')
    ->stage('development')
    ->hostname('128.30.54.149')
    ->user('studio24')
    ->set('deploy_path','/var/www/vhosts/statamic-demo/development');





// Tasks

desc('Deploy Statamic CMS Demo');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:s24:composer',
    'deploy:writable',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);

// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');


