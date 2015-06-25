<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'service_manager' => array(
        'aliases' => array(
            'zfcuser_zend_db_adapter' => (isset($settings['zend_db_adapter'])) ? $settings['zend_db_adapter'] : 'Zend\Db\Adapter\Adapter'
        )
    ),
    'bjyauthorize'    => [
        // Using the authentication identity provider, which basically reads the roles from the auth service's identity
        'identity_provider' => 'BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider',

        'role_providers'    => [
            // using an object repository (entity repository) to load all roles into our ACL
            'BjyAuthorize\Provider\Role\ObjectRepositoryProvider' => [
                'object_manager'    => 'doctrine.entitymanager.orm_default',
                'role_entity_class' => 'User\Entity\Role'
            ]
        ],
//        'unauthorized_strategy' => 'Application\View\UnauthorizedStrategy',
        'guards' => [
            'BjyAuthorize\Guard\Controller' => [
                //Base controllers
                ['controller' => 'zfcuser', 'roles' => ['admin', 'guest', 'user']],
                ['controller' => 'ZfcAdmin\Controller\AdminController', 'roles' => ['admin']],
                //home controllers
                ['controller' => Application\Controller\IndexController::ALIAS, 'roles' => ['admin', 'guest', 'user']],
                ['controller' => User\Controllers\UserController::ALIAS, 'roles' => ['admin', 'user', 'guest']],
                //Admin controllers
                ['controller' => Admin\Controllers\IndexController::ALIAS, 'roles' => ['admin']],
                ['controller' => Admin\Controllers\IndexController::ALIAS, 'action' => 'login', 'roles' => ['guest']],
                ['controller' => Admin\Controllers\UserController::ALIAS, 'roles' => ['admin']],
            ]
        ]
    ]
);
