<?php
namespace Common\Paginator;

class Paginator extends \Zend\Paginator\Paginator
{
    /**
     *
     * Enter description here ...
     */
    public function toArray()
    {
        $result = array();
        foreach ($this as $item) {
            array_push($result, $item);
        }
        return $result;
    }

    /**
     * Serializes the object as a string.  Proxies to {@link render()}.
     * Only if more than 1 page need to be displayed
     *
     * @return string
     */
    public function __toString()
    {
        if ($this->count() > 1) {
            return parent::__toString();
        }
        return '';
    }

}