<?php
namespace Common\Model;

use Common\Db\Table;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;

class PaysTable extends Table
{
    protected $table = 't_pays';
    protected $_primary = 'idPays';
    protected $_orderBy = 'libPays_en ASC';


    /**
     * @inheritdoc
     */
    public function __construct()
    {
        parent::__construct();
        $this->resultSetPrototype = new ResultSet(ResultSet::TYPE_ARRAYOBJECT, new Pays());
    }


    /**
     * Get country list
     * @param array $params
     * @return ResultSet
     */
    public function getPays($params = array())
    {
        $result = $this->select(
            function (Select $select) use ($params) {
                if (array_key_exists('order', $params)) {
                    $select->order($params['order']);
                } else {
                    $select->order($this->_orderBy);
                }
            }
        );

        return $result;
    }

}
