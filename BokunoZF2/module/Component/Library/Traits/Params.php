<?php

namespace Component\Library\Traits;

/**
 * Class Params
 *
 * @package Component\Library\Traits
 */
trait Params
{
    /** @var array */
    private $results = array();
    /** @var array */
    private $errors = array();
    /**  @var array */
    private $params = array();


    /**
     * @param array $data
     * @return $this
     */
    public function setParams(array $data)
    {
        $this->params = $data;

        return $this;
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    protected function addParams($name, $value)
    {
        $this->params[$name] = $value;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasParams()
    {
        return ((bool)$this->params);
    }

    /**
     * @return array
     */
    protected function getParams()
    {
        return $this->params;
    }

    /**
     * @param $name
     * @return null
     */
    protected function param($name)
    {
        if (isset($this->params[$name])) {
            return $this->params[$name];
        } else {
            return null;
        }
    }


    /**
     * @param $name
     * @param $value
     * @return $this
     */
    protected function addResult($name, $value)
    {
        $this->results[$name] = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    protected function setResult($value)
    {
        $this->results = $value;
        return $this;
    }

    /**
     * @return array
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * @param $index
     * @param $msg
     * @return $this
     */
    protected function addError($index, $msg)
    {
        if (!isset($this->errors[$index])) {
            $this->errors[$index] = null;
        }
        $this->errors[$index] = $msg;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasError()
    {
        return (bool)$this->errors;
    }

    /**
     * @param array $errors
     * @return $this
     */
    protected function setError(array $errors)
    {
        $this->errors = $errors;
        return $this;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

}