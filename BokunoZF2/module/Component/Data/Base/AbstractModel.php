<?php

namespace Component\Data\Base;

use Zend\Db\RowGateway\AbstractRowGateway;
use Zend\InputFilter\Factory;
use Zend\InputFilter\InputFilter;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Component\Library;

/**
 * Class AbstractModel
 *
 * @package Component\Data\Base
 */
abstract class AbstractModel extends \ArrayObject implements ModelInterface, ServiceLocatorAwareInterface
{
    use Library\Traits\ServiceLocator;
    use Library\Traits\Attribute;

    /** @var  InputFilter */
    protected $inputFilter;

    /** @var  EntityInterface */
    protected $entity;

    protected $rowData;

    function __construct(EntityInterface $entity, AbstractRowGateway $rowData)
    {
        $this->entity = $entity;
        $this->rowData = $rowData;
    }

    /**
     * @param bool|false $update
     * @return int
     */
    public function save($update = false)
    {
        $this->rowData->populate($this->getEntity(), $update);
        if ($this->rowData->save()) {
            $this->exchangeUpdateArray($this->rowData->toArray());
            return true;
        } else {
            return false;
        }

    }

    /**
     * @return int
     */
    public function delete()
    {
        $this->rowData->populate($this->getEntity(), true);
        return $this->rowData->delete();
    }

    /**
     * @param mixed $data
     * @return void
     */
    public function exchangeArray($data)
    {
        parent::exchangeArray($data);

        if ($data && is_array($data)) {
            foreach ($data as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * @param array $data
     */
    public function exchangeUpdateArray(array $data)
    {
        if ($data && is_array($data)) {
            foreach ($data as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * @param bool|true $unSetPrimaryKey
     * @return array
     */
    public function getEntity($unSetPrimaryKey = false)
    {
        $primaryKeys = $this->entity->getPrimaryKeys();
        $data = $this->toArray();

        $res = array();
        if ($data && is_array($data)) {
            foreach ($data as $key => $value) {

                if ($unSetPrimaryKey && array_search($key, $primaryKeys) !== false) {
                    continue;
                }

                if (array_key_exists($key, $this->entity->_entities)) {
                    $res[$key] = $value;
                }
            }
        }

        return $res;
    }

    /**
     * @param array $group
     * @return bool
     */
    public function isValid(array $group = array())
    {
        return
            $this
                ->getInputFilter()
                ->setValidationGroup($group)
                ->setData($this->getEntity())
                ->isValid();
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        $messages = $this->inputFilter->getMessages();
        $errors = array();

        foreach ($messages as $key => $message) {
            $errors[$key]['error'] = current($message);
            $errors[$key]['label'] = (isset($this->entity->labels[$key])) ? $this->entity->labels[$key] : null;
        }

        return $errors;
    }

    /**
     * @param bool|true $setPrimaryKey
     * @return array
     */
    public function getGroup($setPrimaryKey = true)
    {
        $primaryKeys = $this->entity->getPrimaryKeys();
        $group = $this->entity->_entities;

        if (!$setPrimaryKey) {
            foreach ($primaryKeys as $key) {
                if (array_key_exists($key, $group)) {
                    unset($group[$key]);
                }
            }
        }

        return array_keys($group);
    }

    /**
     * @return bool
     */
    public function isSetPrimaryKey()
    {
        $primaryKey = $this->entity->getPrimaryKeys();
        $_entities = $this->getEntity();

        $bool = true;
        foreach ($primaryKey as $key) {
            if (empty($_entities[$key])) {
                $bool = false;
                break;
            }
        }

        return $bool;
    }

    /**
     * @return InputFilter
     */
    protected function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new Factory();

            $this->addInputFilter($inputFilter, $factory);
            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    /**
     * @param \Zend\InputFilter\InputFilter $inputFilter
     * @param \Zend\InputFilter\Factory $factory
     */
    abstract protected function addInputFilter($inputFilter, $factory);

}