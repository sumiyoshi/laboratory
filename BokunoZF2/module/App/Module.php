<?php

namespace App;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

/**
 * Class Module
 *
 * @package App
 */
class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/router.config.php';
    }

    public function getAutoloaderConfig()
    {
        if (file_exists(__DIR__ . '/config/namespaces_map.config.php')) {
            return array(
                'Zend\Loader\StandardAutoloader' => array(
                    'namespaces' => include __DIR__ . '/config/namespaces_map.config.php'
                ),
            );
        } else {
            return array();
        }
    }
}
