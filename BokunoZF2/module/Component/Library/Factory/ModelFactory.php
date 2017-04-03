<?php

namespace Component\Library\Factory;

use Component\Data\Base\AbstractModel;
use Component\Data\Base\EntityInterface;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ModelFactory implements AbstractFactoryInterface
{
    /**
     * @param ServiceLocatorInterface $locator
     * @param $name
     * @param $requestedName
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $locator, $name, $requestedName)
    {
        if (preg_match('/.+Model/', $requestedName)) {
            if (class_exists('Component\\Data\\Model\\' . $requestedName)) {
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
     * @return AbstractModel
     */
    public function createServiceWithName(ServiceLocatorInterface $locator, $name, $requestedName)
    {
        $entityClass = 'Component\\Data\\Entity\\' . str_replace('Model', 'Entity', $requestedName);
        $recordClass = 'Component\\Data\\Model\\' . $requestedName;

        /** @var EntityInterface $entity */
        $entity = new $entityClass();

        $rowData = new \Zend\Db\RowGateway\RowGateway($entity->getPrimaryKeys(), $entity->getTableName(), $locator->get('Zend\Db\Adapter\Adapter'));

        /** @var AbstractModel $record */
        $record = new $recordClass($entity, $rowData);
        #region サービスロケータ
        if ($record instanceof ServiceLocatorAwareInterface) {
            $record->setServiceLocator($locator);
        }
        #endregion

        $record->exchangeArray($entity->_entities);

        return $record;
    }
}