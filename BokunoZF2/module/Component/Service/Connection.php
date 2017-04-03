<?php

namespace Component\Service;

use Component\Library\Core\ServiceInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

/**
 * Class Connection
 *
 * @package Component\Service
 */
class Connection implements ServiceInterface, ServiceLocatorAwareInterface
{
    use \Component\Library\Traits\ServiceLocator;

    public function init()
    {
    }

    /**
     * @param string $adapter
     * @return \Zend\Db\Adapter\Driver\ConnectionInterface
     */
    public function getConnection($adapter)
    {
        /** @var \Zend\Db\Adapter\Adapter $adapter */
        $adapter = $this->getServiceLocator()->get($adapter);
        return $adapter->getDriver()->getConnection();
    }

    /**
     * @param $func
     * @param string $adapter
     * @return mixed
     * @throws \Exception
     */
    public function transaction($func, $adapter = 'Zend\Db\Adapter\Adapter')
    {
        $connection = $this->getConnection($adapter);
        $connection->beginTransaction();

        try {
            $res = $func();

            $connection->commit();
        } catch (\Exception $e) {
            $connection->rollback();
            throw $e;
        }

        return $res;
    }
}