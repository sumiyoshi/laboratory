<?php

namespace Component\Library\Factory;

use Component\Data\Base\AbstractModel;
use Component\Data\Base\EntityInterface;
use Component\Data\Base\AbstractTable;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class TableFactory
 *
 * @package Component\Factory
 */
class TableFactory implements AbstractFactoryInterface
{
    /**
     * @param ServiceLocatorInterface $locator
     * @param $name
     * @param $requestedName
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $locator, $name, $requestedName)
    {
        if (preg_match('/.+Table/', $requestedName)) {
            if (class_exists('Component\\Data\\Table\\' . $requestedName)) {
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
     * @return AbstractTable
     */
    public function createServiceWithName(ServiceLocatorInterface $locator, $name, $requestedName)
    {
        $entityClass = 'Component\\Data\\Entity\\' . str_replace('Table', 'Entity', $requestedName);
        $recordClass = str_replace('Table', 'Model', $requestedName);
        $tableClass = 'Component\\Data\\Table\\' . $requestedName;

        /** @var \Zend\Db\Adapter\Adapter $adapter */
        $adapter = $locator->get('Zend\Db\Adapter\Adapter');

        #region resultSet
        /** @var AbstractModel $record */
        $record = $locator->get($recordClass);
        $resultSet = new \Zend\Db\ResultSet\ResultSet();
        $resultSet->setArrayObjectPrototype($record);
        #endregion

        /** @var EntityInterface $entity */
        $entity = new $entityClass();

        $tableData = new \Zend\Db\TableGateway\TableGateway($entity->getTableName(), $adapter, null, $resultSet);
        $table = new $tableClass($tableData, $entity);

        return $table;
    }
}