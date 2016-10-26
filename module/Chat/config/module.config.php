<?php

namespace Chat;

use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Router\Http\Segment;

return [
    'controllers' => [
        'factories' => [
            Controller\ChatController::class => InvokableFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'chat' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/chat[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ChatController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'chat' => __DIR__ . '/../view',
        ],
    ],
];
