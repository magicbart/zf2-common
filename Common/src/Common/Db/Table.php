<?php
namespace Common\Db;

use Common\Model\Defaut;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\RowGateway\RowGateway;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\Feature;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Table extends TableGateway implements ServiceLocatorAwareInterface
{
    protected $serviceLocator;

    /**
     * Primary key
     * @var mixed
     */
    protected $_primary;

    protected $_identity = false;
    protected $_operation;

    protected $_orderBy;
    protected $_updateUrl;

    protected $_model;

    protected $_errors = array();

    protected $_paginator;

    /**
     * {@inheritdoc}
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * {@inheritdoc}
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }


    /**
     * @name Callbacks appellés avant et après chaque opération.
     * @abstract Ils doivent retourner un boolean. Si un callback retourne false l'opération
     * correspondante sera stoppé et retournera false.
     */
    // @{
    protected function _beforeInsert($object)
    {
        return true;
    }

    protected function _afterInsert($object)
    {
        return true;
    }

    protected function _beforeUpdate($object)
    {
        return true;
    }

    protected function _afterUpdate($object)
    {
        return true;
    }

    protected function _beforeDelete($object)
    {
        return true;
    }

    protected function _afterDelete($object)
    {
        return true;
    }

    // @}

    public function getPaginator()
    {
        return $this->_paginator;
    }


    /**
     * Convertit les messages d'erreur en une string unique avec retour à la ligne html
     * @return string
     */
    public function getMessages()
    {
        return implode("\n", $this->_errors);
    }

    /**
     * @return \Common\Model\Defaut
     */
    public function getModel()
    {
        $model = $this->_model;
        return new $model;
    }

    /**
     * Initialization of the Table
     */
    public function __construct()
    {
        $this->featureSet = new Feature\FeatureSet();
        $this->featureSet->addFeature(new Feature\GlobalAdapterFeature());
        //$this->featureSet->addFeature(new Feature\RowGatewayFeature('id'));
        //$this->featureSet->addFeature(new Feature\MetadataFeature());
        //$this->resultSetPrototype = new ResultSet(ResultSet::TYPE_ARRAYOBJECT);
        $this->initialize();
    }

    /**
     * Get all data ordered by _orderBy
     * @return ResultSet
     */
    public function fetchAll()
    {
        $orderBy = $this->_orderBy;
        return $this->select(
            function (Select $select) use ($orderBy) {
                if ($orderBy != null) {
                    $select->order($orderBy);
                }
            }
        );
    }

    /**
     * Operation INSERT avec callback
     * @param object|array $mixed
     * @return bool
     */
    public function insertRow($mixed)
    {
        if (is_array($mixed)) {
            $object = $this->getModel();
            $object->exchangeArray($mixed);
        } else {
            $object = $mixed;
        }

        $this->_setDateCreation($object);
        $this->_setDateModification($object);
        return $this->_operation('insert', $object);

    }


    /**
     * Operation UPDATE avec callback
     * @param object|array $mixed
     * @return bool
     */
    public function updateRow($mixed)
    {

        if (is_object($mixed)) {

            $this->_setDateModification($mixed);
            return $this->_operation('update', $mixed);

        } else {
            if (is_array($mixed)) {

                $rowset = $this->select($this->_whereExprPrimary((object)$mixed));
                $object = $rowset->current();
                $this->_setDateModification($object);

                $object->exchangeArray($mixed);

                return $this->_operation('update', $object);

            }
        }

    }

    public function deleteRow($mixed)
    {
        if (is_array($mixed)) {
            $object = $this->getModel();
            $object->exchangeArray($mixed);
            return $this->_operation('delete', $object);
        } else if (is_object($mixed)) {
            return $this->_operation('delete', $mixed);
        }
    }

    public function getLastInsertRow()
    {
        $id = $this->getLastInsertValue();
    }

    /**
     * @param string $type insert|update|delete
     * @param Defaut $object
     * @return bool
     */
    protected function _operation($type, $object)
    {

        //----- Before
        $method = '_before' . ucfirst($type);
        if (!$this->$method($object)) {
            return false;
        }


        switch ($type) {
            case 'insert' :
                $this->insert($object->getArrayCopy());
                if ($this->_identity) {
                    $object->{$this->_primary} = $this->getLastInsertValue();
                }
                break;
            case 'update' :
                $this->update($object->getArrayCopy(), $this->_whereExprPrimary($object));
                break;
            case 'delete' :
                $this->delete($this->_whereExprPrimary($object));
                break;
        }


        // => After
        $method = '_after' . ucfirst($type);
        if (!$this->$method($object)) {
            return false;
        }

        if ($type == 'insert') {
            return $object;
        }


        return true;

    }


    public function fecthRow($where)
    {
        $this->select($where);
    }


    public function getUpdateLink()
    {
        if ($this->_updateUrl == null) {
            return null;
        }
        if ($this->_operation == 'insert') {
            return str_replace(
                '{id}',
                $this->getLastInsertValue(),
                $this->_updateUrl
            );
        } else {
            return null;
        }
    }



    /***************************************************************************************************************/
    /******************************************  PRIVATE METHOD  ***************************************************/
    /***************************************************************************************************************/

    /**
     *
     * Enter description here ...
     * @param array $data
     */
    private function _filterColumns(array &$data)
    {
        $columns = $this->_getCols();
        foreach ($data as $key => $value) {
            if (!in_array($key, $columns)) {
                $this->_trashData[$key] = $data[$key];
                unset($data[$key]);
            }
        }
    }


    /**
     *
     * Enter description here ...
     * @param array $data
     */
    private function _unsetPrimaryKey(array $data)
    {
        if (is_array($this->_primary)) {
            foreach ($this->_primary as $column) {
                if (isset($data[$column])) {
                    unset($data[$column]);
                }
            }
        } else if (array_key_exists($this->_primary, $data)) {
            unset($data[$this->_primary]);
        }
    }

    /**
     * @param $object
     * @return bool
     */
    private function _isPrimaryKeyDefined($object)
    {
        $bool = true;
        $primary = (is_array($this->_primary)) ? $this->_primary : array($this->_primary);
        foreach ($primary as $column) {
            if ($object->$column == null) {
                $bool = false;
            }
        }
        return $bool;
    }

    /**
     * @param $object
     * @return array
     */
    private function _whereExprPrimary($object)
    {
        $where = array();
        $primary = (is_array($this->_primary)) ? $this->_primary : array($this->_primary);
        foreach ($primary as $column) {
            $where["$column = ?"] = $object->$column;
        }
        return $where;
    }

    /**
     * Set dateCreation
     * @param $object
     */
    private function _setDateCreation($object)
    {
        $reflect = new \ReflectionClass($object);
        if ($reflect->hasProperty('dateCreation')) {
            $object->dateCreation = date('Y-m-d H:i:s');
        }
    }

    /**
     * Set dateModification
     * @param $object
     */
    private function _setDateModification($object)
    {
        $reflect = new \ReflectionClass($object);
        if ($reflect->hasProperty('dateModification')) {
            $object->dateModification = date('Y-m-d H:i:s');
        }
    }


}