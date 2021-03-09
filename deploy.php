<?php
namespace Deployer;

require 'recipe/symfony.php';

// Config

set('application', 'mileage-old');
set('deploy_path', '~/');
set('repository', 'git@github.com:thomasage/mileage.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('mileage.fondcombe.eu')
    ->set('http_user', 'fondcomb-mileage')
    ->set('writable_mode', 'chmod')
    ->set('bin/php', '/usr/local/php8.0/bin/php')
    ->set('env', ['APP_ENV' => 'prod']);

// Tasks

task(
    'deploy:assets',
    static function (): void {
        runLocally('yarn build');
        upload('public/build', '{{release_path}}/public');
    }
);

before('deploy:writable', 'deploy:assets');

after('deploy:failed', 'deploy:unlock');
