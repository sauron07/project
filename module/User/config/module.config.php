<?php
return [
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
        )
    ),
    'zfcuser'      => [
        'logout_redirect_route'   => 'home',
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
