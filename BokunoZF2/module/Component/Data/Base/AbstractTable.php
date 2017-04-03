<?php
namespace Component\Data\Base;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Component\Library;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql;

/**
 * Class AbstractTable
 *
 * @package Component\Data\Base
 */
abstract class AbstractTable implements ServiceLocatorAwareInterface
{
    use Library\Traits\ServiceLocator;

    /** @var TableGateway */
    protected $tableData;

    /** @var  EntityInterface */
    protected $entity;

    /** @var bool */
    protected $resultArray = false;

    function __construct(TableGateway $tableData, EntityInterface $entity)
    {
        $this->tableData = $tableData;
        $this->entity = $entity;
    }

    /**
     * @return $this
     */
    public function resultArray()
    {
        $this->resultArray = true;
        return $this;
    }

    /**
     * 1件取得
     *
     * @param array $keys
     * @param Sql\Select|null $select
     * @return ModelInterface|array
     */
    public function find(array $keys, Sql\Select $select = null)
    {
        $select = $this->buildSelect($keys, $select);
        $select->limit(1);
        $res = $this->findAll($keys, $select);
        return array_shift($res);
    }

    /**
     * スカラー値を取得
     *
     * @param array $keys
     * @param Sql\Select $select
     * @return string
     */
    public function findOne(array $keys, Sql\Select $select = null)
    {
        $select = $this->buildSelect($keys, $select);
        $res = $this
        ->resultArray()
        ->find($keys, $select);

        return reset($res);
    }

    /**
     * レコードからキー/値のペアを取得
     *
     * @param array $keys
     * @param Sql\Select $select
     * @return array
     */
    public function findPairs(array $keys, Sql\Select $select = null)
    {
        $res = $this
        ->resultArray()
        ->findAll($keys, $select);

        $pairs = array();

        /** @var array $row */
        foreach ($res as $row) {
            $first = reset($row);
            $last = end($row);
            $pairs[$first] = $last;
        }
        return $pairs;
    }

    /**
     * レコードを全件取得
     *
     * @param array $keys
     * @param Sql\Select $select
     * @return array|ModelInterface[]
     */
    public function findAll(array $keys, Sql\Select $select = null)
    {
        $select = $this->buildSelect($keys, $select);

        if ($this->resultArray) {
            $statement = $this->tableData->getSql()->prepareStatementForSqlObject($select);
            $result = $statement->execute();
        } else {
            $result = $this->tableData->selectWith($select);
        }

        $res = array();
        foreach ($result as $row) {
            $res[] = $row;
        }

        $this->resultArray = false;

        return $res;
    }

    /**
     * @param array $keys
     * @return AbstractModel|bool
     */
    public function findByPrimaryKey(array $keys)
    {
        $primary_key = $this->getPrimaryKeys();
        $select = $this->getSelectSql();

        #region プライマリーキーがセットされているか
        foreach ($primary_key as $column) {
            if (!isset($keys[$column]) || empty($keys[$column])) {
                return false;
            }
        }
        #endregion

        foreach ($primary_key as $column) {
            $select->where->equalto($column, $keys[$column]);
        }

        return $this->find([], $select);
    }

    /**
     * @param Sql\Select $select
     * @param string $column
     * @return int
     */
    public function count(array $keys, $column = '*', Sql\Select $select = null)
    {
        $select = $this->buildSelect($keys, $select);
        $select = clone $select;
        $select->columns(array('count' => $this->predicate("count({$column})")));
        $select->reset('limit');
        $select->reset('offset');
        return (int)$this->findOne($keys, $select);
    }

    /**
     * @return TableGateway
     */
    protected function getTableData()
    {
        return $this->tableData;
    }

    /**
     * @return Sql\Select
     */
    public function getSelectSql()
    {
        return $this->tableData->getSql()->select();
    }

    /**
     * @return array
     */
    public function getPrimaryKeys()
    {
        return $this->entity->getPrimaryKeys();
    }

    /**
     * @param $str
     * @return Sql\Predicate\Expression
     */
    protected function predicate($str)
    {
        return new Sql\Predicate\Expression($str);
    }

    /**
     * @param array $keys
     * @param Sql\Select|null $select
     * @return Sql\Select
     */
    protected function buildSelect(array $keys, Sql\Select $select = null)
    {
        if (!$select) {
            $select = $this->getSelectSql();
        }

        $this->addWhere($select, $keys);

        return $select;
    }

    /**
     * @param \Zend\Db\Sql\Select $select
     * @param array $keys
     */
    abstract protected function addWhere(\Zend\Db\Sql\Select $select, array $keys);

}