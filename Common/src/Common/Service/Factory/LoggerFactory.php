<?php

namespace Common\Service\Factory;

use Zend\Log\Filter\Priority;
use Zend\Log\Logger;
use Zend\Log\Writer\Db as DbWriter;
use Zend\Log\Writer\Stream as StreamWriter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory class for Logger.
 */
class LoggerFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $logger = new Logger();
        $writer = new StreamWriter('./data/log/' . date('Y-m-d') . '-error.log');
        $logger->addWriter($writer);

        //if (APPLICATION_ENV == 'local') {
        //$logger->addWriter(new \Zend\Log\Writer\FirePhp());
        //}

        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $mapping = array(
            'timestamp' => 'date',
            'priority' => 'type',
            'priorityName' => 'priority',
            'message' => 'message'
        );
        $writer = new DbWriter($dbAdapter, 't_log', $mapping);
        $writer->addFilter(new Priority(Logger::CRIT));
        $logger->addWriter($writer);
        return $logger;
    }
}