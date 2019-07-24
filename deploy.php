<?php

declare(strict_types=1);

namespace Deployer;

use Symfony\Component\Dotenv\Dotenv;

require 'recipe/symfony4.php';

// Project repository

set('repository', 'git@github.com:thomasage/mileage.git');

// [Optional] Allocate tty for git clone. Default value is false.

set('git_tty', true);

// Shared files/dirs between deploys

set('shared_files', ['.env.local']);
add('shared_dirs', []);

// Writable dirs by web server

add('writable_dirs', []);
set('allow_anonymous_stats', false);

// Hosts

inventory(__DIR__.'/hosts.yaml');

// Tasks

desc('Execute tests');
task(
    'deploy:tests',
    static function (): void {
        runLocally('vendor/bin/simple-phpunit');
    }
);

desc('Setup env variables');
task(
    'deploy:env:setup',
    static function (): void {
        $dotenv = new Dotenv();
        // Remote env vars
        run('if [ ! -f shared/.env.local ] ; then touch shared/.env.local ; fi');
        $remoteEnvs = run('cat shared/.env.local');
        $remoteEnvs = $dotenv->parse($remoteEnvs);
        // Local env vars
        $localEnvs = $dotenv->parse(file_get_contents(__DIR__.'/.env'));
        // Populate missing env vars
        foreach ($localEnvs as $key => $val) {
            if (isset($remoteEnvs[$key])) {
                continue;
            }
            $val = ask($key, $val);
            if (false !== strpos($val, ' ')) {
                $val = sprintf('"%s"', $val);
            }
            run(sprintf('echo "%s=%s" >> shared/.env.local', $key, str_replace('"', '\"', $val)));
        }
    }
);

desc('Compile assets');
task(
    'deploy:assets',
    static function (): void {
        runLocally('yarn run encore prod');
        upload('public/build', '{{release_path}}/public');
    }
);

desc('Deploy project');
task(
    'deploy',
    [
        'deploy:tests',
        'deploy:info',
        'deploy:prepare',
        'deploy:lock',
        'deploy:release',
        'deploy:update_code',
        'deploy:shared',
        'deploy:env:setup',
        'deploy:vendors',
        'deploy:assets',
        'deploy:writable',
        'deploy:cache:clear',
        'deploy:cache:warmup',
        'deploy:symlink',
        'deploy:unlock',
        'cleanup',
    ]
);

// [Optional] Specific to OVH

set('bin/php', '/usr/local/php7.3/bin/php');

// [Optional] if deploy fails automatically unlock.

after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'database:migrate');
