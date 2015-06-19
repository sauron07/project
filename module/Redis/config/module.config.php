<?php
return [
    'redis-session' => [
        'set_storage_on_boot' => true,
        'redis' => [
            'adapter' => [
                'name' => 'redis',
                'options' => [
                    'server' => [
                        'host' => '127.0.0.1',
                        'port' => 6379,
                    ],
                    // optional db identifier
                    'database' => 0,
                ]
            ]
        ],
        'session' => [
            'cache_expire'        => 86400,
            'cookie_lifetime'     => 31536000,
            'gc_maxlifetime'      => 31536000,
            'cookie_path'         => '/',
            'cookie_secure'       => false,
            'remember_me_seconds' => 31536000,
            'use_cookies'         => true
        ]
    ]
];