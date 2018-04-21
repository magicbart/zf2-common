<?php

namespace Common\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Maintenance extends AbstractHelper
{

    /**
     * __invoke
     *
     * @access public
     * @return String
     */
    public function __invoke()
    {
        $config = $this->getView()->getHelperPluginManager()->getServiceLocator()
            ->get('ServiceManager')->get('config');
        if (isset($config['appli']['maintenance'])) {
            if ($config['appli']['maintenance']['boolean'] === true) {
                return '<b>MODE MAINTENANCE</b>';
            }
        }
    }


}
