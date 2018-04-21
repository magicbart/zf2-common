<?php

namespace Common;

use Common\Form\Element\Pays as PaysElement;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\EventManager\EventInterface;
use Zend\I18n\Translator\TranslatorAwareInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerPluginProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\FormElementProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;
use Zend\View\HelperPluginManager;

/**
 * Defines the common module.
 */
class Module implements
    AutoloaderProviderInterface,
    BootstrapListenerInterface,
    ConfigProviderInterface,
    ControllerProviderInterface,
    ControllerPluginProviderInterface,
    FormElementProviderInterface,
    ServiceProviderInterface,
    ViewHelperProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function onBootstrap(EventInterface $e)
    {
        /** @var MvcEvent $e */

        //----- events
        $eventManager = $e->getApplication()->getEventManager();

        //----- set db default
        GlobalAdapterFeature::setStaticAdapter(
            $e->getApplication()->getServiceManager()->get('Zend\Db\Adapter\Adapter')
        );

        //----- session
        $this->bootstrapSession($e);

        $viewHelperManager = $e->getApplication()->getServiceManager()->get('viewHelperManager');
        // Getting the headTitle helper from the view helper manager
        $headTitleHelper = $viewHelperManager->get('headTitle');
        // Setting a separator string for segments
        $headTitleHelper->setSeparator(' - ');


        //----- Attach attributes to the controller
        $sharedManager = $eventManager->getSharedManager();
        $sharedManager->attach(
            'Zend\Mvc\Controller\AbstractActionController',
            'dispatch',
            function ($e) {
                /** @var MvcEvent $e */
                $controller = $e->getTarget();
                $controller->session = new Container('appli');
                $controller->cache = $e->getApplication()->getServiceManager()->get('cache');
                $viewHelperManager = $e->getApplication()->getServiceManager()->get('viewHelperManager');
                $controller->headTitle = $viewHelperManager->get('headTitle');
                $controller->headScript = $viewHelperManager->get('headScript');
                $controller->headLink = $viewHelperManager->get('headLink');
                $controller->headMeta = $viewHelperManager->get('headMeta');
                $controller->headLang = $viewHelperManager->get('headLang');
                $controller->translator = $e->getApplication()->getServiceManager()->get('translator');
            },
            101
        );

        $translator = $e->getApplication()->getServiceManager()->get('translator');
        $translator->addTranslationFile('gettext', __DIR__ . '/language/fr_FR.mo', __NAMESPACE__, 'fr');
        $translator->addTranslationFile('gettext', __DIR__ . '/language/en_US.mo', __NAMESPACE__, 'en');
    }

    /**
     * @param MvcEvent $e
     */
    public function bootstrapSession(MvcEvent $e)
    {
        $session = $e->getApplication()
            ->getServiceManager()
            ->get('Zend\Session\SessionManager');
        $session->start();

        $container = new Container('appli');
        if (!isset($container->init)) {
            $session->regenerateId(true);
            $container->init = 1;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * {@inheritdoc}
     */
    public function getControllerConfig()
    {
        return array(
            'invokables' => array(
                'common\form' => 'Common\Controller\FormController',
                'common\bbcode' => 'Common\Controller\BbcodeController',
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getControllerPluginConfig()
    {
        return array(
            'invokables' => array(
                'url' => 'Common\Controller\Plugin\Url',
                'bbcode' => 'Common\Controller\Plugin\Bbcode',
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFormElementConfig()
    {
        return array(
            'factories' => array(
                'PaysElement' => function ($sm) {
                    /** @var HelperPluginManager $sm */
                    $serviceLocator = $sm->getServiceLocator();
                    $paysTable = $serviceLocator->get('Common\Model\PaysTable');
                    $element = new PaysElement($paysTable);
                    return $element;
                }
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'logger' => 'Common\Service\Factory\LoggerFactory',
                'cache' => 'Common\Service\Factory\CacheFactory',
                'acl' => 'Common\Service\Factory\AclFactory',
                'Zend\Session\SessionManager' => 'Common\Service\Factory\SessionManagerFactory',
                'Common\Model\PaysTable' => 'Common\Model\PaysTableFactory',
                'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
            ),
            'initializers' => array(
                'Zend\Db\Adapter' => function($instance, $sm) {
                    if ($instance instanceof AdapterAwareInterface) {
                        $instance->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                    }
                },
                'Zend\I18n\Translator' => function($instance, $sm) {
                    if ($instance instanceof TranslatorAwareInterface) {
                        $instance->setTranslator($sm->get('translator'));
                    }
                },
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'url' => 'Common\View\Helper\Url',
            ),
            'invokables' => array(
                'dataGrid' => 'Common\Form\View\Helper\DataGrid',
                'gridForm' => 'Common\Form\View\Helper\GridForm',
                'addthis' => 'Common\View\Helper\AddThis',
                'bbcode' => 'Common\View\Helper\Bbcode',
                'dateFormat' => 'Common\View\Helper\DateFormat',
                'filAriane' => 'Common\View\Helper\FilAriane',
                'gender' => 'Common\View\Helper\Gender',
                'ganalytics' => 'Common\View\Helper\GoogleAnalytics',
                'location' => 'Common\View\Helper\Location',
                'numberFormat' => 'Common\View\Helper\NumberFormat',
                'maintenance' => 'Common\View\Helper\Maintenance',
                'displayResultset' => 'Common\View\Helper\DisplayResultset',
                'headLink' => 'Common\View\Helper\HeadLink',
                'headLang' => 'Common\View\Helper\HeadLang',
                'countryFlag' => 'Common\View\Helper\CountryFlag',
            ),
        );

    }
}
