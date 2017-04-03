<?php

namespace Component\Data\Base;

/**
 * Interface ModelInterface
 *
 * @package Component\Data\Base
 */
interface ModelInterface
{
    /**
     * @param bool|true $primaryKey
     * @return array
     */
    public function getEntity($primaryKey = true);

    /**
     * @return bool
     */
    public function isSetPrimaryKey();

    /**
     * @param array $group
     * @return bool
     */
    public function isValid(array $group = array());

    /**
     * @return array
     */
    public function getErrors();

    /**
     * @return array
     */
    public function getGroup();
}
