<?php

namespace Common\View\Helper;

use DateTime as DateTime;
use Zend\View\Helper\AbstractHelper;

class DateFormat extends AbstractHelper
{
    /**
     * Format a date
     *
     * @access public
     * @param DateTime|int|array $date
     * @param int $dateType
     * @param int $timeType
     * @return string
     */
    public function __invoke($date, $dateType = \IntlDateFormatter::MEDIUM, $timeType = \IntlDateFormatter::MEDIUM)
    {
        if (is_string($date)) {
            $date = new \DateTime($date);
        }
        return (new \Zend\I18n\View\Helper\DateFormat())->__invoke(
            $date,
            $dateType,
            $timeType,
            $this->view->lang
        );
    }
}