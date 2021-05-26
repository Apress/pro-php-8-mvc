<?php

return [
    'default' => 'local',
    'local' => [
        'type' => 'local',
        'path' => __DIR__ . '/../storage/app',
    ],
    's3' => [
        'type' => 's3',
        'key' => '',
        'secret' => '',
        'token' => '',
        'region' => '',
        'bucket' => '',
    ],
    'ftp' => [
        'type' => 'ftp',
        'host' => '',
        'root' => '',
        'username' => '',
        'password' => '',
    ],
];
