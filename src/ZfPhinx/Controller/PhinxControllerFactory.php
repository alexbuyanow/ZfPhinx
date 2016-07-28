<?php

namespace ZfPhinx\Controller;

use Interop\Container\ContainerInterface;
use ZfPhinx\Service\ServiceLocatorProviderTrait;
use ZfPhinx\Service\ZfPhinxService;

/**
 * Phinx controller factory
 */
class PhinxControllerFactory
{
    use ServiceLocatorProviderTrait;

    /**
     * @param  ContainerInterface $container
     * @return PhinxController
     */
    public function __invoke(ContainerInterface $container)
    {
        return new PhinxController(
            $this->getZfPhinxService($container)
        );
    }

    /**
     * Gets ZF Phinx Service
     *
     * @param  ContainerInterface $container
     * @return ZfPhinxService
     */
    private function getZfPhinxService(ContainerInterface $container)
    {
        return $container->get(ZfPhinxService::class);
    }
}
