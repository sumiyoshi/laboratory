<?php

namespace Component\Library\Factory;

use Component\Auth;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthFactory implements AbstractFactoryInterface
{
    /**
     * @param ServiceLocatorInterface $locator
     * @param $name
     * @param $requestedName
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $locator, $name, $requestedName)
    {
        if (preg_match('/Auth:.+/', $requestedName)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param ServiceLocatorInterface $locator
     * @param $name
     * @param $requestedName
     * @return Auth
     */
    public function createServiceWithName(ServiceLocatorInterface $locator, $name, $requestedName)
    {
        $auth = new Auth();

        #region サービスロケータ
        if ($auth instanceof ServiceLocatorAwareInterface) {
            $auth->setServiceLocator($locator);
        }
        #endregion


        $explode = explode(':', $name);
        $target = $explode[1];

        $config = $locator->get('config');
        $option = $config['auth'][$target];

        $name_space = $option['name_space'];
        $identity_name = $option['identity_name'];
        $password_name = $option['password_name'];
        $table_name = $option['table_name'];

        $auth->init($name_space, $identity_name, $password_name, $table_name);

        return $auth;
    }
}