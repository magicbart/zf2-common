<?php
namespace Common\Controller\Plugin;

use Common\Tools\String as StringTools;
use Zend\Mvc\Controller\Plugin\Url as ZendUrl;

class Url extends ZendUrl
{
    /**
     * @inheritdoc
     */
    public function fromRoute($route = null, $params = array(), $options = array(), $reuseMatchedParams = false)
    {
        if (array_key_exists('label', $params)) {
            $params['label'] = StringTools::rewrite($params['label']);
        }
        return parent::fromRoute($route, $params, $options, $reuseMatchedParams);
    }
}
