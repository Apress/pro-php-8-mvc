<?php

return [
    'default' => 'mysql',
    'mysql' => [
        'type' => 'mysql',
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'pro-php-mvc',
        'username' => 'root',
        'password' => '',
    ],
    'sqlite' => [
        'type' => 'sqlite',
        'path' => __DIR__ . '/../database/database.sqlite',
    ],
];
