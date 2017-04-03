<?php

namespace Component\Library\Factory;

use Component\Library\Core\ServiceInterface;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ServiceFactory implements AbstractFactoryInterface
{
    /**
     * @param ServiceLocatorInterface $locator
     * @param $name
     * @param $requestedName
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $locator, $name, $requestedName)
    {
        if (class_exists('Component\\Service\\' . $requestedName)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param ServiceLocatorInterface $locator
     * @param $name
     * @param $requestedName
     * @return mixi
     */
    public function createServiceWithName(ServiceLocatorInterface $locator, $name, $requestedName)
    {

        $classService = 'Component\\Service\\' . $requestedName;
        $service = new $classService();

        #region サービスロケータ
        if ($service instanceof ServiceLocatorAwareInterface) {
            $service->setServiceLocator($locator);
        }
        #endregion

        if ($service instanceof ServiceInterface) {
            $service->init();
        }

        return $service;
    }
}