<?php

namespace Framework\Provider;

use Framework\Cache\Factory;
use Framework\Cache\Driver\FileDriver;
use Framework\Cache\Driver\MemcacheDriver;
use Framework\Cache\Driver\MemoryDriver;
use Framework\Support\DriverProvider;
use Framework\Support\DriverFactory;

class CacheProvider extends DriverProvider
{
    protected function name(): string
    {
        return 'cache';
    }

    protected function factory(): DriverFactory
    {
        return new Factory();
    }

    protected function drivers(): array
    {
        return [
            'file' => function($config) {
                return new FileDriver($config);
            },
            'memcache' => function($config) {
                return new MemcacheDriver($config);
            },
            'memory' => function($config) {
                return new MemoryDriver($config);
            },
        ];
    }
}
