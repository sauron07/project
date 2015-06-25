<?php
use Admin\Controllers\IndexController;
use Admin\Controllers\UserController;

return [
    'router'             => [
        'routes' => [
            'zfcadmin' => [
                'may_terminate' => true,
                'child_routes'  => [
                    'default' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => '/',
                            'defaults' => [
                                'controller' => IndexController::ALIAS,
                                'action'     => 'index'
                            ]
                        ]
                    ],
                    'test'    => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => '/test',
                            'defaults' => [
                                'controller' => IndexController::ALIAS,
                                'action'     => 'index',
                            ]
                        ]
                    ],
                    'login'   => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/login',
                            'defaults' => array(
                                'controller' => IndexController::ALIAS,
                                'action'     => 'login'
                            )
                        )
                    ),
                    'users'   => array(
                        'type'          => 'Literal',
                        'options'       => array(
                            'route'    => '/users',
                            'defaults' => array(
                                'controller' => UserController::ALIAS,
                                'action'     => 'users'
                            )
                        ),
                        'may_terminate' => true,
                        'child_routes'  => array(
                            'ajax'     => [
                                'type'    => 'Literal',
                                'options' => array(
                                    'route'    => '/ajax',
                                    'defaults' => array(
                                        'controller' => UserController::ALIAS,
                                        'action'     => 'ajax-users'
                                    )
                                )
                            ],
                            'activate' => [
                                'type'    => 'Literal',
                                'options' => array(
                                    'route'    => '/activate',
                                    'defaults' => array(
                                        'controller' => UserController::ALIAS,
                                        'action'     => 'activate'
                                    )
                                )
                            ]
                        )
                    ),
                    'user'    => [
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => [
                            'route'       => '/user[/][:action][/][:id]',
                            'constraints' => array(
                                'action' => 'create|edit',
                                'id'     => '[0-9]*'
                            ),
                            'defaults'    => [
                                'controller' => UserController::ALIAS,
                                'action'     => 'index'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],
    'zfcadmin'           => array(
        'use_admin_layout'      => true,
        'admin_layout_template' => 'layout/admin'
    ),
    'view_helper_config' => array(
        'flashmessenger' => array(
            'message_open_format'      => '<div%s>',
            'message_separator_string' => '<br>',
            'message_close_string'     => '</div>'
        )
    ),
    'view_manager'       => [
        'template_map'        => [
            'layout/admin' => __DIR__ . '/../view/layout/layout.phtml'
        ],
        'template_path_stack' => array(
            'zf-table' => __DIR__ . '/../view'
        )
    ],
];
