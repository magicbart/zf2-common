<?php
namespace Common\Tools;


class ResultSet
{


    /**
     * Shullfe an array
     * @param Zend\Db\ResultSet\ResultSet $result
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