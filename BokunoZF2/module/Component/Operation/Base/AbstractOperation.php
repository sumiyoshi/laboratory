<?php

namespace Component\Operation\Base;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Component\Library;

/**
 * Class AbstractOperation
 *
 * @package Components\Operations\Base
 */
abstract class AbstractOperation implements OperationInterface, ServiceLocatorAwareInterface
{
    use Library\Traits\Params;
    use Library\Traits\ServiceLocator;

    /** @var  string */
    public $mode;

    /**
     * @return bool
     */
    public function exec()
    {
        $this->init();
        $this->validate();
        if (!$this->hasError()) {
            return $this->_exec();
        } else {
            return false;
        }
    }

    protected function init()
    {
    }

    /**
     * @return bool
     */
    abstract protected function _exec();

    /**
     * @return bool
     */
    abstract protected function validate();


}