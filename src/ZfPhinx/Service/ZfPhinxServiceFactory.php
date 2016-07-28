<?php

namespace ZfPhinx\Service;

use Phinx\Config\Config;
use Phinx\Console\PhinxApplication;
use Zend\Db\Adapter\AdapterInterface;
use Interop\Container\ContainerInterface;

/**
 * Phinx service factory
 */
class ZfPhinxServiceFactory
{
    use ServiceLocatorProviderTrait;

    /**
     * @param  ContainerInterface $container
     * @return ZfPhinxService
     */
    public function __invoke(ContainerInterface $container)
    {
        $service = new ZfPhinxService(
            $this->getPhinxApplication(),
            $this->getConfig($container)
        );

        return $service;
    }

    /**
     * Get Phinx application
     *
     * @return PhinxApplication
     */
    private function getPhinxApplication()
    {
        return new PhinxApplication();
    }

    /**
     * Gets Phinx config
     *
     * @param  ContainerInterface $container
     * @return Config
     */
    private function getConfig(ContainerInterface $container)
    {
        $config = $container->get('Config');

        if (!(array_key_exists('ZfPhinx', $config) && is_array($config['ZfPhinx']))) {
            throw new Exception\RuntimeException('ZfPhinx config is not found');
        }

        return new Config($this->performConfig($container, $config['ZfPhinx']));
    }

    /**
     * Performs config array from ZF to Phinx structure
     *
     * @param  ContainerInterface $container
     * @param  array                   $config
     * @return array
     */
    private function performConfig(ContainerInterface $container, array $config)
    {
        if (!(array_key_exists('environments', $config) && is_array($config['environments']))) {
            throw new Exception\RuntimeException('ZfPhinx environment config is not found');
        }

        array_walk(
            $config['environments'],
            function (&$element, $key) use ($container) {
                if (is_array($element) && array_key_exists('db_adapter', $element)) {
                    if (!$container->has($element['db_adapter'])) {
                        $message = sprintf(
                            'Adapter for environment %s is not found',
                            $key
                        );
                        throw new Exception\RuntimeException($message);
                    }

                    $adapter = $container->get($element['db_adapter']);

                    if (!$adapter instanceof AdapterInterface) {
                        $message = sprintf(
                            'Adapter for environment %s must implement %s; %s given',
                            $key,
                            AdapterInterface::class,
                            is_object($adapter) ? get_class($adapter) : gettype($adapter)
                        );
                        throw new Exception\RuntimeException($message);
                    }

                    $connection = $adapter
                        ->getDriver()
                        ->getConnection();

                    $element['connection'] = $connection->getResource();
                    $element['name']       = $connection->getCurrentSchema();
                }

                return $element;
            }
        );

        return $config;
    }
}
