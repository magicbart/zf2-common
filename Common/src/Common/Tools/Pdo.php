<?php
namespace Common\Tools;


class Pdo
{


    /**
     * Shullfe an array
     * @param Zend\Db\Adapter\Driver\Pdo\Result $result
     * @return array
     */
    public static function toArray($result)
    {
        $return = array();
        foreach ($result as $row) {
            $return[] = $row;
        }
        return $return;
    }

}