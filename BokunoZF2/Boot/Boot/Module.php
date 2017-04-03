<?php

namespace Boot;

use Component\Logger;
use Zend\ServiceManager\ServiceManager;

/**
 * Class Module
 *
 * @package Boot
 */
class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'abstract_factories' => [
                'Component\Library\Factory\OperationFactory',
                'Component\Library\Factory\TableFactory',
                'Component\Library\Factory\ViewModelFactory',
                'Component\Library\Factory\ModelFactory',
                'Component\Library\Factory\AuthFactory',
                'Component\Library\Factory\ServiceFactory',
            ],

            'factories' => [
                'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
                'Logger' => function (ServiceManager $sm) {
                    $config = $sm->get('config');
                    $logPath = $config['path']['log'];
                    $logger = Logger::getLogger($logPath);
                    return $logger;
                },
                'RouteMatch' => function (ServiceManager $sm) {
                    $router = $sm->get('router');
                    $request = $sm->get('request');

                    /** @var \Zend\Mvc\Router\Http\RouteMatch $routeMatch */
                    $routeMatch = $router->match($request);

                    return $routeMatch;
                }

            ],

        ];
    }
}
