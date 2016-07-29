<?php

namespace ZfPhinx;

use ZfPhinx\Controller\PhinxController;

return [
    'test' => [
        'options' => [
            'route'    => 'zfphinx test [-v|-vv|-vvv] [-q] [-n] [-e]',
            'defaults' => [
                'controller' => PhinxController::class,
                'action'     => 'test',
            ],
        ],
    ],
    'create' => [
        'options' => [
            'route'    => 'zfphinx create [-v|-vv|-vvv] [-q] [-n] [-t] [-l] MIGRATION',
            'defaults' => [
                'controller' => PhinxController::class,
                'action'     => 'create',
            ],
        ],
    ],
    'migrate' => [
        'options' => [
            'route'    => 'zfphinx migrate [-v|-vv|-vvv] [-q] [-n] [-t] [-d] [-e]',
            'defaults' => [
                'controller' => PhinxController::class,
                'action'     => 'migrate',
            ],
        ],
    ],
    'rollback' => [
        'options' => [
            'route'    => 'zfphinx rollback [-v|-vv|-vvv] [-q] [-n] [-t] [-d] [-e]',
            'defaults' => [
                'controller' => PhinxController::class,
                'action'     => 'rollback',
            ],
        ],
    ],
    'status' => [
        'options' => [
            'route'    => 'zfphinx status [-v|-vv|-vvv] [-q] [-n] [-f] [-e]',
            'defaults' => [
                'controller' => PhinxController::class,
                'action'     => 'status',
            ],
        ],
    ],
];
