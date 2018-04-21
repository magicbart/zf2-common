<?php
namespace Common\Form\Element;

use Common\Model\PaysTable;
use Zend\Form\Element\Select;

/**
 * Form element for pays list
 */
class Pays extends Select
{
    /**
     * {@inheritdoc}
     */
    public function __construct($name)
    {
        parent::__construct($name);
        $lang = APPLICATION_LANG;

        $paysTable = new PaysTable();

        $this->setLabel('Pays');
        $this->setAttribute('id', 'form-pays');
        $valOpts = array();
        foreach ($paysTable->getPays(array('order' => "libPays_{$lang}")) as $pays) {
            $valOpts[$pays->idPays] = $pays->getLabel($lang);
        }

        $this->setValueOptions($valOpts);

    }
}
