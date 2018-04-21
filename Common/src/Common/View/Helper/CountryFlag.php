<?php

namespace Common\View\Helper;

use Zend\View\Helper\AbstractHelper;

class CountryFlag extends AbstractHelper
{

    /**
     * __invoke
     *
     * @return String
     */
    public function __invoke($object)
    {
        $libPays = (APPLICATION_LANG == 'fr') ? $object->libPays_fr : $object->libPays_en;

        return sprintf(
            '<span class="flag-%s" title="%s">%s</span>',
            $object->codeIso,
            $libPays,
            $libPays
        );

    }


}
