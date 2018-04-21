<?php

namespace Common\Service\Factory;

use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\Config\ConfigInterface;
use Zend\Session\Container;
use Zend\Session\SaveHandler\DbTableGateway;
use Zend\Session\SaveHandler\DbTableGatewayOptions;
use Zend\Session\SessionManager;

/**
 * Factory class for SessionManager.
 */
class SessionManagerFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        if (isset($config['session'])) {
            $session = $config['session'];

            $sessionConfig = null;
            if (isset($session['config'])) {
                $class = isset($session['config']['class']) ?
                    $session['config']['class'] : 'Zend\Session\Config\SessionConfig';
                $options = isset($session['config']['options']) ? $session['config']['options'] : array();
                /** @var ConfigInterface $sessionConfig */
                $sessionConfig = new $class();
                $sessionConfig->setOptions($options);
            }

            $sessionStorage = null;
            if (isset($session['storage'])) {
                $class = $session['storage'];
                $sessionStorage = new $class();
            }

            $sessionSaveHandler = null;
            if (isset($session['save_handler'])) {
                // class should be fetched from service manager since it will require constructor arguments
                //$sessionSaveHandler = $sm->get($session['save_handler']);
                $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
                $sessionOptions = new DbTableGatewayOptions();
                $sessionTableGateway = new TableGateway(
                    $session['table'],
                    $dbAdapter
                );
                $sessionSaveHandler = new DbTableGateway(
                    $sessionTableGateway,
                    $sessionOptions
                );
            }

            $sessionManager = new SessionManager($sessionConfig, $sessionStorage, $sessionSaveHandler);

            if (isset($session['validator'])) {
                $chain = $sessionManager->getValidatorChain();
                foreach ($session['validator'] as $validator) {
                    $validator = new $validator();
                    $chain->attach('session.validate', array($validator, 'isValid'));
                }
            }
        } else {
            $sessionManager = new SessionManager();
        }
        Container::setDefaultManager($sessionManager);
        return $sessionManager;
    }
}