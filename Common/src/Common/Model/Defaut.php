<?php
namespace Common\Model;

/**
 * Basic class for models.
 */
class Defaut
{

    protected $_trash;


    /**
     * @return mixed
     */
    public function getTrash()
    {
        return $this->_trash;
    }

    /**
     * @param $object
     */
    public function setTrash($object)
    {
        $object->_trash = null;
        $this->_trash = clone($object);
    }

    /**
     * Set class values from data
     * @param array $data
     */
    public function exchangeArray($data)
    {
        $this->trash = $this;
        $reflect = new \ReflectionClass($this);
        $props = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);
        foreach ($props as $prop) {
            if (array_key_exists($prop->name, $data)) {
                $this->{$prop->name} = $data[$prop->name];
            }
        }
    }

    /**
     * Get an array of class data
     * @return array
     */
    public function getArrayCopy()
    {
        $copy = array();
        $reflect = new \ReflectionClass($this);
        $props = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);
        foreach ($props as $prop) {
            $copy[$prop->name] = $this->{$prop->name};
        }
        return $copy;
    }
}