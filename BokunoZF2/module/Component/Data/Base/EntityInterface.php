<?php

namespace Component\Data\Base;

/**
 * Interface EntityInterface
 *
 * @package Component\Data\Base
 *
 * @property array labels
 * @property array _entities
 *
 */
interface EntityInterface
{
    public function getTableName();

    public function getPrimaryKeys();

}
