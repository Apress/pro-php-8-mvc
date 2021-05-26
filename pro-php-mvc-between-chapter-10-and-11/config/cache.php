<?php

return [
    'default' => 'memory',
    'memory' => [
        'type' => 'memory',
        'seconds' => 31536000,
    ],
    'file' => [
        'type' => 'file',
        'seconds' => 31536000,
    ],
    'memcache' => [
        'type' => 'memcache',
        'host' => '127.0.0.1',
        'port' => 11211,
        'seconds' => 31536000,
    ],
];
