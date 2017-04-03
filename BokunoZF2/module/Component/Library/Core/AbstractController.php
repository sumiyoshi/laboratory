<?php

namespace Component\Library\Core;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class AbstractController
 *
 * @package Component\Library\Core
 */
abstract class AbstractController extends AbstractActionController
{

    protected $dto = array();

    /**
     * @return \Zend\Http\PhpEnvironment\Request
     */
    protected function _request()
    {
        return $this->getRequest();
    }

    /**
     * @return string
     */
    protected function getClassName()
    {
        return get_class($this);
    }

    /**
     * @return \Component\Service\Connection
     */
    protected function getConnection()
    {
        return $this->getServiceLocator()->get('Connection');
    }

    /**
     * @param $name
     *
     * @return AbstractViewModel
     */
    protected function viewModel($name = null)
    {

        if ($name) {
            $class_name = $this->getClassName();
            $_class = explode('\\', $class_name);
            $module = $_class[0];

            /** @var AbstractViewModel $viewModel */
            $viewModel = $this->getServiceLocator()->get("{$module}:{$name}");
            $viewModel->setVariables(
                ['dto' => $this->dto],
                true
            );
            $viewModel->exec();

            return $viewModel;
        } else {
            return ['dto' => $this->dto];
        }
    }
}