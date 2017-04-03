<?php

namespace Component\Library\Traits;

use Component\Library\Util\String;

/**
 * Class Attribute
 * @package Component\Library\Traits
 */
trait Attribute
{

    private $attribute_params = array();

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $method_attribute = 'set' . ucfirst(String::camelize($name)) . 'Attribute';
        if ($value && method_exists($this, $method_attribute)) {
            $value = $this->{$method_attribute}($value);
        }

        $this->attribute_params[$name] = $value;
    }

    /**
     * @param $name
     * @return null
     */
    public function __get($name)
    {
        $value = null;

        if (isset($this->attribute_params[$name])) {
            $value = $this->attribute_params[$name];
        }

        $method_attribute = 'get' . ucfirst(String::camelize($name)) . 'Attribute';
        if (method_exists($this, $method_attribute)) {
            $value = $this->{$method_attribute}($value);
        }

        return $value;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $res = array();

        foreach ($this as $key => $val) {
            $res[$key] = $this->{$key};
        }

        foreach ($this->attribute_params as $key => $val) {
            $res[$key] = $this->{$key};
        }

        return $res;
    }
}