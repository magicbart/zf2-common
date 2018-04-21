<?php

namespace Common\Service\Factory;

use Zend\Permissions\Acl\Acl;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory class for Acl.
 */
class AclFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $cache = $serviceLocator->get('cache');
        $acl = $cache->getItem('acl');
        if (!$acl) {
            $config = $serviceLocator->get('config');
            $acl = new Acl();
            if (isset($config['acl'])) {
                if (isset($config['acl']['resources'])) {
                    foreach ($config['acl']['resources'] as $string) {
                        $acl->addResource($string);
                    }
                }
                if (isset($config['acl']['roles'])) {
                    foreach ($config['acl']['roles'] as $string) {
                        $acl->addRole($string);
                    }
                }
                if (isset($config['acl']['allow'])) {
                    foreach ($config['acl']['allow'] as $row) {
                        $acl->allow($row['role'], $row['resource'], $row['action']);
                    }
                }
            }
            $cache->setItem('acl', serialize($acl));
        } else {
            $acl = unserialize($acl);
        }
        return $acl;
    }
}