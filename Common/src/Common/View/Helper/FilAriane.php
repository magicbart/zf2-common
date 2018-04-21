<?php

namespace Common\View\Helper;

use Zend\View\Helper\AbstractHelper;

class FilAriane extends AbstractHelper
{

    /**
     * __invoke
     *
     * @access public
     * @return array $list
     */
    public function __invoke($list)
    {
        if (is_array($list)) {
            $result = array();
            foreach ($list as $row) {
                if (array_key_exists('url', $row)) {
                    $result[] = '<li><a href="' . $row['url'] . '">' . $row['label'] . '</a></li>';
                } else {
                    $result[] = '<li>' . $row['label'] . '</li>';
                }
            }
            return '<ul class="breadcrumb">' . implode($result) . '</ul>';
        } else {
            return '';
        }
    }


}
