<?php

namespace Component\Library\Core;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\View\Model\ViewModel;
use Component\Library;

/**
 * Class AbstractViewModel
 *
 * @package Component\Library\Core
 */
abstract class AbstractViewModel extends ViewModel implements ServiceLocatorAwareInterface
{
    use Library\Traits\ServiceLocator;

    public function exec()
    {
        /** @var \Zend\Mvc\Router\Http\RouteMatch $routeMatch */
        $routeMatch = $this->getServiceLocator()->get('RouteMatch');

        //ルート名セット
        $this->setVariable('route_name', $routeMatch->getMatchedRouteName());

        #region アクションごとの処理
        $action = $routeMatch->getParam('action') . 'Action';


        if (method_exists($this, $action)) {
            $this->{$action}();
        }
        #endregion
    }
}