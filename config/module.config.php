<?php

namespace ZfPhinx;

use ZfPhinx\Controller\PhinxController;
use ZfPhinx\Controller\PhinxControllerFactory;
use ZfPhinx\Service\ZfPhinxService;
use ZfPhinx\Service\ZfPhinxServiceFactory;

return [
    'console' => [
        'router' => [
            'routes' => require __DIR__ . '/route.config.php',
        ],
    ],

    'controllers' => [
        'factories' => [
            PhinxController::class => PhinxControllerFactory::class,
        ],
    ],

    'service_manager' => [
        'factories' => [
            ZfPhinxService::class => ZfPhinxServiceFactory::class,
        ],
    ],

    'zfphinx' => [
        'paths' => [
            'migrations' => '',
            'seeds'      => '',
        ],

        'environments' => [
            'default_migration_table' => 'phinxlog',
            'default_database'        => null,
        ],
    ],
];
