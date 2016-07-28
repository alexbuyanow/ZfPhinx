<?php

namespace ZfPhinx;

use ZfPhinx\Controller\PhinxController;

return [
    'test' => [
        'options' => [
            'route'    => 'ZfPhinx test [-v|-vv|-vvv] [-q] [-n] -e ENVIRONMENT',
            'defaults' => [
                'controller' => PhinxController::class,
                'action'     => 'test',
            ],
        ],
    ],
    'create' => [
        'options' => [
            'route'    => 'ZfPhinx create [-v|-vv|-vvv] [-q] [-n] [-t] [-l] MIGRATION',
            'defaults' => [
                'controller' => PhinxController::class,
                'action'     => 'create',
            ],
        ],
    ],
    'migrate' => [
        'options' => [
            'route'    => 'ZfPhinx migrate [-v|-vv|-vvv] [-q] [-n] [-t] [-d] -e ENVIRONMENT',
            'defaults' => [
                'controller' => PhinxController::class,
                'action'     => 'migrate',
            ],
        ],
    ],
    'rollback' => [
        'options' => [
            'route'    => 'ZfPhinx rollback [-v|-vv|-vvv] [-q] [-n] [-t] [-d] -e ENVIRONMENT',
            'defaults' => [
                'controller' => PhinxController::class,
                'action'     => 'rollback',
            ],
        ],
    ],
    'status' => [
        'options' => [
            'route'    => 'ZfPhinx status [-v|-vv|-vvv] [-q] [-n] [-f] -e ENVIRONMENT',
            'defaults' => [
                'controller' => PhinxController::class,
                'action'     => 'status',
            ],
        ],
    ],
];
