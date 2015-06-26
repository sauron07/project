<?php
return [
    'router'       => array(
        'routes' => array(
            'home' => [
                'child_routes'  => [
                    'zfcuser' => array(
                        'type'          => 'Literal',
                        'priority'      => 1001,
                        'options'       => array(
                            'route'    => '/user',
                            'defaults' => array(
                                'controller' => \User\Controllers\UserController::ALIAS,
                                'action'     => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes'  => array(
                            'login'          => array(
                                'type'    => 'Literal',
                                'options' => array(
                                    'route'    => '/login',
                                    'defaults' => array(
                                        'controller' => 'zfcuser',
                                        'action'     => 'login',
                                    ),
                                ),
                            ),
                            'authenticate'   => array(
                                'type'    => 'Literal',
                                'options' => array(
                                    'route'    => '/authenticate',
                                    'defaults' => array(
                                        'controller' => 'zfcuser',
                                        'action'     => 'authenticate',
                                    ),
                                ),
                            ),
                            'logout'         => array(
                                'type'    => 'Literal',
                                'options' => array(
                                    'route'    => '/logout',
                                    'defaults' => array(
                                        'controller' => 'zfcuser',
                                        'action'     => 'logout',
                                    ),
                                ),
                            ),
                            'register'       => array(
                                'type'    => 'Literal',
                                'options' => array(
                                    'route'    => '/register',
                                    'defaults' => array(
                                        'controller' => 'zfcuser',
                                        'action'     => 'register',
                                    ),
                                ),
                            ),
                            'changepassword' => array(
                                'type'    => 'Literal',
                                'options' => array(
                                    'route'    => '/change-password',
                                    'defaults' => array(
                                        'controller' => 'zfcuser',
                                        'action'     => 'changepassword',
                                    ),
                                ),
                            ),
                            'changeemail'    => array(
                                'type'    => 'Literal',
                                'options' => array(
                                    'route'    => '/change-email',
                                    'defaults' => array(
                                        'controller' => 'zfcuser',
                                        'action'     => 'changeemail',
                                    ),
                                ),
                            ),
                        ),
                    ),
                ],
            ],
        ),
    ),
    'doctrine'     => [
        'driver' => [
            'user_entities' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/User/Entity']
            ],
            'orm_default'   => [
                'drivers' => [
                    'User\Entity' => 'user_entities'
                ]
            ]
        ]
    ],
    'data-fixture' => array(
        'User_fixture' => __DIR__ . '/../src/User/Fixtures',
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'zfc-user' => __DIR__ . '/../view'
        ),
        'template_map'        => [
            'user/user/index' => __DIR__ . '/../view/zfc-user/user/index.phtml',
        ]

    ),
    'zfcuser'      => [
        'logout_redirect_route'   => 'home',
        'login_redirect_route'    => 'home/zfcuser',
        'new_user_default_role'   => 'user',
        'enable_username'         => true,
        'auth_adapters'           => array(100 => 'ZfcUser\Authentication\Adapter\Db'),
        'user_entity_class'       => 'User\Entity\User',
        'enable_default_entities' => false,
        'enable_user_state'       => true,
        'default_user_state'      => 2,
        'allowed_login_states'    => array(null, 1, 2)
    ]
];
