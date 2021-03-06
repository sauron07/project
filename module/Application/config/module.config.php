<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return [
    'router'          => [
        'routes' => [
            'root' => [
                'type'    => 'Segment',
                'options' => [
                    'route'    => '[/]',
                    'defaults' => [
                        'controller' => \Application\Controller\IndexController::ALIAS,
                        'action'     => 'index'
                    ],
                ],
                'may_terminate' => true,
            ],
            'home' => [
                'type'    => 'Segment',
                'options' => [
                    'route'    => '/:lang',
                    'constraints' => [
                        'lang' => '[A-Za-z]{2}'
                    ],
                    'defaults' => [
                        'lang' => \I18n\Translator\Translator::DEFAULT_LANG,
                        'controller' => \Application\Controller\IndexController::ALIAS,
                        'action'     => 'index'
                    ],
                ],
                'may_terminate' => true,
            ],
        ]
    ],
    'service_manager' => [
        'abstract_factories' => [
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory'
        ],
        'aliases'            => [
            'translator' => 'MvcTranslator'
        ]
    ],
    'translator'      => [
        'locale'                    => 'en_US',
        'translation_file_patterns' => [
            [
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo'
            ]
        ]
    ],
    'view_manager'    => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map'             => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
            'test'                    => __DIR__ . '/../view/error/index.phtml'
        ],
        'template_path_stack'      => [
            __DIR__ . '/../view'
        ]
    ],
    // Placeholder for console routes
    'console'         => [
        'router' => [
            'routes' => []
        ]
    ]
];
