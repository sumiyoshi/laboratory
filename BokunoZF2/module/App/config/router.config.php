<?php

$constraints = array(
    'action' => '[a-z][0-9a-z_]*',
    'id' => '[0-9a-z]*',
);

$routes = array();
$controllers = array();

#region 設定ファイル読み込み
foreach (glob(__DIR__ . '/*_router.config.php') as $file) {
    $config = include($file);
    $routes = array_merge($routes, $config['routes']);
    $controllers = array_merge($controllers, $config['controllers']);
}
#endregion

return array(
    'router' => array(
        'routes' => $routes
    ),
    'controllers' => array(
        'invokables' => $controllers
    ),
);
