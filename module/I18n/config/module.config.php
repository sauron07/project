<?php
return [
    'doctrine' => [
        'driver' => [
            'locale_entities' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/I18n/Entity']
            ],
            'orm_default'     => [
                'drivers' => [
                    'I18n\Entity' => 'locale_entities'
                ]
            ]
        ]
    ],
    'data-fixture' => array(
        'Locale_fixture' => __DIR__ . '/../src/I18n/Fixtures',
    ),
];
