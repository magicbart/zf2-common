<?php

namespace Common\View\Helper;

use Zend\View\Helper\AbstractHelper;

class NumberFormat extends AbstractHelper
{
    /**
     * Format a number
     *
     * @param  int|float $number
     * @param  int       $decimals
     * @return string
     */
    public function __invoke($number, $decimals = 0)
    {
        return (new \Zend\I18n\View\Helper\NumberFormat())->__invoke($number, null, null, $this->view->lang, $decimals);
    }
}