<?php

return array(
    'db' => array(
        'driver' => 'pdo',
        'dsn' => 'mysql:dbname=zf2;host=localhost;charset=utf8',
        'username' => 'root',
        'password' => 'password',
    ),
    'path' => array(
        'log' => '/var/www/zf/data/log/',
        'cache' => '/var/www/zf/data/cache/app',
    ),
    'app_module' => array(
        'default' => 'front'
    ),
    'auth' => array(
        'user' => array(
            'name_space' => 'auth_user',
            'identity_name' => 'login_id',
            'password_name' => 'password',
            'table_name' => 'UserTable'
        )
    )
);
