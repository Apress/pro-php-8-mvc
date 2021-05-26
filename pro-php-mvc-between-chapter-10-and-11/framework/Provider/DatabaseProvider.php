<?php

namespace Framework\Provider;

use Framework\Database\Factory;
use Framework\Database\Connection\MysqlConnection;
use Framework\Database\Connection\SqliteConnection;
use Framework\Support\DriverProvider;
use Framework\Support\DriverFactory;

class DatabaseProvider extends DriverProvider
{
    protected function name(): string
    {
        return 'database';
    }

    protected function factory(): DriverFactory
    {
        return new Factory();
    }

    protected function drivers(): array
    {
        return [
            'sqlite' => function($config) {
                return new SqliteConnection($config);
            },
            'mysql' => function($config) {
                return new MysqlConnection($config);
            },
        ];
    }
}
