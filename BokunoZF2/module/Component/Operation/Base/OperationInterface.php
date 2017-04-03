<?php

namespace Component\Operation\Base;

/**
 * Interface OperationInterface
 *
 * @package Components\Operations\Base
 */
interface OperationInterface
{
    public function setParams(array $data);

    /**
     * @return bool
     */
    public function exec();

    public function execAfter();

    /**
     * @return array
     */
    public function getResults();

    /**
     * @return array
     */
    public function getErrors();
}