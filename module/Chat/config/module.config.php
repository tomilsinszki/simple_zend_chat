<?php

namespace Chat;

use Chat\Controller\Factory\ChatControllerFactory;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zend\Router\Http\Segment;

return [
    'controllers' => [
        'factories' => [
            Controller\ChatController::class => Controller\Factory\ChatControllerFactory::class,
        ],
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ],
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
