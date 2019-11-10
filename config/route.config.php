<?php

namespace ZfPhinx;

use ZfPhinx\Controller\PhinxController;

return [
    'test' => [
        'options' => [
            'route'    => 'zfphinx test [-v|-vv|-vvv] [-q] [-n] [--environment=]',
            'defaults' => [
                'controller' => PhinxController::class,
                'action'     => 'test',
            ],
        ],
    ],
    'create' => [
        'options' => [
            'route'    => 'zfphinx create [-v|-vv|-vvv] [-q] [-n] [--template=] [--class=] <migration>',
            'defaults' => [
                'controller' => PhinxController::class,
                'action'     => 'create',
            ],
        ],
    ],
    'migrate' => [
        'options' => [
            'route'    => 'zfphinx migrate [-v|-vv|-vvv] [-q] [-n] [--target=] [--date=] [--environment=] [--dry-run]',
            'defaults' => [
                'controller' => PhinxController::class,
                'action'     => 'migrate',
            ],
        ],
    ],
    'rollback' => [
        'options' => [
            'route'    => 'zfphinx rollback [-v|-vv|-vvv] [-q] [-n] [--target=] [--date=] [--environment=] [--dry-run]',
            'defaults' => [
                'controller' => PhinxController::class,
                'action'     => 'rollback',
            ],
        ],
    ],
    'status' => [
        'options' => [
            'route'    => 'zfphinx status [-v|-vv|-vvv] [-q] [-n] [--format=] [--environment=]',
            'defaults' => [
                'controller' => PhinxController::class,
                'action'     => 'status',
            ],
        ],
    ],
];
