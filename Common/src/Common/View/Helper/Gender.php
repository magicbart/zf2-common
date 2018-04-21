<?php

namespace Common\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Gender extends AbstractHelper
{

    /**
     * __invoke
     *
     * @return String
     */
    public function __invoke($object)
    {

        return sprintf(
            '%1$s <span class="_spriteForum-f spr-%2$s" title="%3$s">%3$s</span>',
            $this->view->translate('common.gender', 'Common'),
            $object->sexe,
            ($object->sexe === 'homme') ?
                $this->view->translate('common.gender.male', 'Common') :
                $this->view->translate('common.gender.female', 'Common')
        );
    }


}
