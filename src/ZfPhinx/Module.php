<?php

namespace ZfPhinx;

use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\Console\Adapter\AdapterInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Loader\StandardAutoloader;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleBannerProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\Mvc\Console\ResponseSender\ConsoleResponseSender;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\ResponseSender\SendResponseEvent;
use Zend\Mvc\SendResponseListener;

/**
 * Module class
 */
class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ConsoleUsageProviderInterface,
    ConsoleBannerProviderInterface
{
    const MODULE_NAME    = 'ZfPhinx';
    const MODULE_VERSION = '0.2.0';

    /**
     * Init event manager
     *
     * @param  MvcEvent $event
     * @return void
     */
    public function onBootstrap(MvcEvent $event)
    {
        $eventManager = $event->getApplication()->getServiceManager()->get(SendResponseListener::class)->getEventManager();
        /** @var EventManagerInterface $eventManager */
        $eventManager->attach(SendResponseEvent::EVENT_SEND_RESPONSE, new ConsoleResponseSender(), -2000);
    }

    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * Return an array for passing to Zend\Loader\AutoloaderFactory.
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            StandardAutoloader::class => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }

    /**
     * Returns an array or a string containing usage information for this module's Console commands.
     *
     * @param  AdapterInterface  $console
     * @return array|string|null
     */
    public function getConsoleUsage(Console $console)
    {
        return [
            'Common command flags',
            ['-q', 'Do not output any message'],
            ['-n', 'Do not ask any interactive question'],
            ['-v|vv|vvv', 'Verbosity of messages: normal|more verbose|debug'],
            'Commands',
            'zfphinx create [--template TEMPLATE] [--class CLASS] MIGRATION' => 'Create a new migration',
            ['--template TEMPLATE', 'Use an alternative template'],
            ['--class CLASS', 'Use a class implementing "Phinx\Migration\CreationInterface" to generate the template'],
            ['MIGRATION', 'Unique migration name'],
            'zfphinx migrate [--target TARGET] [--date DATE] [--environment ENVIRONMENT]' => 'Migrate the database',
            ['--target TARGET', 'The version number to migrate to. Format: YYYYMMDDHHMMSS'],
            ['--date DATE', 'The date to migrate to. Format: YYYYMMDD'],
            ['--environment ENVIRONMENT', 'The target environment'],
            'zfphinx rollback [--target TARGET] [--date DATE] [--environment ENVIRONMENT]' => 'Rollback the last or to a specific migration',
            ['--target TARGET', 'The version number to rollback to. Format: YYYYMMDDHHMMSS'],
            ['--date DATE', 'The date to rollback to. Format: YYYYMMDD'],
            ['--environment ENVIRONMENT', 'The target environment'],
            'zfphinx status [--format FORMAT] [--environment ENVIRONMENT]' => 'Show migration status',
            ['--format FORMAT', 'The output format: text or json. Defaults to text'],
            ['--environment ENVIRONMENT', 'The target environment'],
            'zfphinx test [--environment ENVIRONMENT]' => 'Verify the configuration file',
            ['--environment ENVIRONMENT', 'The target environment'],
        ];
    }

    /**
     * Returns a string containing a banner text, that describes the module and/or the application.
     *
     * @param  AdapterInterface $console
     * @return string|null
     */
    public function getConsoleBanner(Console $console)
    {
        return self::MODULE_NAME . ' ' . self::MODULE_VERSION;
    }
}
