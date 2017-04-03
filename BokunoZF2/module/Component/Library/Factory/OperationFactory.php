<?php

namespace Component\Library\Factory;

use Component\Operation\Base\AbstractOperation;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class OperationFactory
 *
 * @package Component\Factory
 */
class OperationFactory implements AbstractFactoryInterface
{
    /**
     * @param ServiceLocatorInterface $locator
     * @param $name
     * @param $requestedName
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $locator, $name, $requestedName)
    {
        if (preg_match('/.+Operation/', $requestedName)) {
            if (class_exists('Component\\Operation\\' . $requestedName)) {
                return true;
            }
        } else {
            return false;
        }

        return false;
    }

    /**
     * @param ServiceLocatorInterface $locator
     * @param $name
     * @param $requestedName
     * @return AbstractOperation
     */
    public function createServiceWithName(ServiceLocatorInterface $locator, $name, $requestedName)
    {
        $classOperation = 'Component\\Operation\\' . $requestedName;

        /** @var AbstractOperation $operation */
        $operation = new $classOperation();

        #region サービスロケータ
        if ($operation instanceof ServiceLocatorAwareInterface) {
            $operation->setServiceLocator($locator);
        }
        #endregion

        return $operation;
    }
}