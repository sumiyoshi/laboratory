<?php

namespace Component\Library\Traits;

use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ServiceLocator
 *
 * @package Component\Library\Traits
 */
trait ServiceLocator
{
    private $serviceLocator;

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

}