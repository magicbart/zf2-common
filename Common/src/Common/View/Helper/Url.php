<?php
namespace Common\View\Helper;

use Common\Tools\String as StringTools;
use Zend\Console\Console;
use Zend\Mvc\Router\Http\RouteMatch;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Helper\Url as UrlHelper;
use Zend\View\HelperPluginManager;

/**
 * View Helper Url
 */
class Url extends UrlHelper implements FactoryInterface, ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * [@inheritdoc]
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var HelperPluginManager $serviceLocator */
        $this->setServiceLocator($serviceLocator->getServiceLocator());

        $router = Console::isConsole() ? 'HttpRouter' : 'Router';
        $this->setRouter($this->getServiceLocator()->get($router));

        $match = $this->getServiceLocator()->get('application')
            ->getMvcEvent()
            ->getRouteMatch();

        if ($match instanceof RouteMatch) {
            $this->setRouteMatch($match);
        }

        return $this;
    }

    /**
     * [@inheritdoc}
     */
    public function __invoke($name = null, $params = array(), $options = array(), $reuseMatchedParams = false)
    {
        if (array_key_exists('label', $params)) {
            $params['label'] = StringTools::rewrite($params['label']);
        }
        return parent::__invoke($name, $params, $options, $reuseMatchedParams);
    }
}
