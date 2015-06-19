<?php
/**
 * Created by PhpStorm.
 * User: matveev
 * Date: 9/11/14
 * Time: 11:53 AM
 */
return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' =>'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => [
                    'host'     => 'localhost',
                    'port'     => '3306',
                    'user'     => 'root',
                    'password' => '',
                    'dbname'   => 'home'
                ]
            ]
        ]
    ]
];