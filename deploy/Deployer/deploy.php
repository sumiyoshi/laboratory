<?php
namespace Deployer;

require 'recipe/common.php';

// Project name
set('application', __DIR__.'/my_project');

// Project repository
set('repository', 'https://github.com/sumiyoshi/BokunoSlim3.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys 
set('shared_files', []);
set('shared_dirs', []);

// Writable dirs by web server 
set('writable_dirs', []);

// Hosts
set('deploy_path', '{{application}}');
//host('localhost')
//    ->set('deploy_path', '{{application}}');

#region Tasks
desc('TESTタスク');
task('test', function () {
    writeln('Hello world');
});

desc('ヘルプメッセージ');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
])->isLocal();
#endregion


// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
