<?php
namespace Common\Controller\Plugin;

use Common\Filter\Bbcode as FilterBbcode;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class Bbcode extends AbstractPlugin
{

    public function bbcode()
    {
        $filter = new FilterBbcode();
        return stripslashes($filter->filter($string));
    }

}
