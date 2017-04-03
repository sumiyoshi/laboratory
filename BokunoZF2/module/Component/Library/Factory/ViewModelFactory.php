<?php
/**
 * Created by IntelliJ IDEA.
 * User: sumi
 * Date: 15/06/20
 * Time: 午後9:21
 */

namespace Component\Library\Factory;

use Component\Library\Core\AbstractViewModel;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ViewModelFactory implements AbstractFactoryInterface
{
    /**
     * @param ServiceLocatorInterface $locator
     * @param $name
     * @param $requestedName
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $locator, $name, $requestedName)
    {

        if (preg_match('/.+ViewModel/', $requestedName)) {
            if (class_exists($this->getClassName($requestedName))) {
                return true;
            }
        } else {
            return false;
        }

        return false;
    }


    private function getClassName($requestedName)
    {

        $names = explode(':', $requestedName);
        if (is_array($names) && count($names) == 2) {
            return $names[0] . "\\ViewModel\\" . $names[1];
        } else {
            return $requestedName;
        }
    }

    /**
     * @param ServiceLocatorInterface $locator
     * @param $name
     * @param $requestedName
     * @return AbstractViewModel
     */
    public function createServiceWithName(ServiceLocatorInterface $locator, $name, $requestedName)
    {
        $viewModelClass = $this->getClassName($requestedName);
        /** @var AbstractViewModel $operation */
        $viewModel = new $viewModelClass();
        #region サービスロケータ
        if ($viewModel instanceof ServiceLocatorAwareInterface) {
            $viewModel->setServiceLocator($locator);
        }
        #endregion

        return $viewModel;
    }
}