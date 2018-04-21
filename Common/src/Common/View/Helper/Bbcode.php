<?php

namespace Common\View\Helper;

use Common\Filter\Bbcode as FilterBbcode;
use Zend\View\Helper\AbstractHelper;

class Bbcode extends AbstractHelper
{

    /**
     * __invoke
     *
     * @access public
     * @return String
     */
    public function __invoke($string)
    {
        return stripslashes(
            (new FilterBbcode())->filter($string)
        );
    }


}
