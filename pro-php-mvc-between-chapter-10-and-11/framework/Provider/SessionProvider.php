<?php

namespace Framework\Provider;

use Framework\Session\Factory;
use Framework\Session\Driver\NativeDriver;
use Framework\Support\DriverProvider;
use Framework\Support\DriverFactory;

class SessionProvider extends DriverProvider
{
    protected function name(): string
    {
        return 'session';
    }

    protected function factory(): DriverFactory
    {
        return new Factory();
    }

    protected function drivers(): array
    {
        return [
            'native' => function($config) {
                return new NativeDriver($config);
            },
        ];
    }
}
