<?php

namespace Common\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Location extends AbstractHelper
{

    /**
     * __invoke
     *
     * @access public
     * @return String
     */
    public function __invoke($object)
    {

        return sprintf(
            '%s <span class="drapeau pays_drapeau-%d" title="%s"></span>',
            $this->view->translate('common.location', 'Common'),
            $object->idPays,
            $object->libPays_en
        );
    }

}
