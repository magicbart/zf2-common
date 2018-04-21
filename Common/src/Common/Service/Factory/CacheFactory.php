<?php

namespace Common\Service\Factory;

use Zend\Cache\StorageFactory;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory class for Cache.
 */
class CacheFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return StorageFactory::factory(
            array(
                'adapter' => array(
                    'name' => 'filesystem',
                    'options' => array(
                        'cache_dir' => APPLICATION_PATH . '/../../data/cache',
                        'ttl' => 100
                    ),
                ),
                'plugins' => array(
                    array(
                        'name' => 'serializer',
                        'options' => array()
                    )
                )
            )
        );
    }

}