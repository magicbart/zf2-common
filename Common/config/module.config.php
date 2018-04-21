<?php
return array(
    'router' => array(
        'routes' => array(
            'form' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/form[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'common\form',
                        'action' => 'index',
                    ),
                ),
            ),
            'bbcode' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/bbcode[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'common\bbcode',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'session' => array(
        'table' => 't_session',
        'config' => array(
            'class' => 'Zend\Session\Config\SessionConfig',
            'options' => array(
                'name' => 'appli',
                'gc_maxlifetime' => 86400,
                'remember_me_seconds' => 86400,
                'use_cookies' => true,
                'cookie_lifetime' => 86400,
            ),
        ),
        'storage' => 'Zend\Session\Storage\SessionArrayStorage',
        'save_handler' => 'Zend\Session\SaveHandler\DbTableGateway',
        'validators' => array(
            array(
                'Zend\Session\Validator\RemoteAddr',
                'Zend\Session\Validator\HttpUserAgent',
            ),
        ),
    ),
    'acl' => array(
        'resources' => array('appli', 'admin', 'log'),
        'roles' => array('guest', 'member', 'admin', 'superadmin', 'debuggeur', 'SuperAdmin', 'Admin', 'Debuggeur'),
        'allow' => array(
            array('role' => array('superadmin', 'admin'), 'resource' => 'admin', 'action' => null),
            array('role' => 'superadmin', 'resource' => 'log', 'action' => null),
        ),
    ),

);