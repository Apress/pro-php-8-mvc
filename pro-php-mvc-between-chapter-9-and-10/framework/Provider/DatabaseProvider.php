<?php

namespace Framework\Provider;

use Framework\App;
use Framework\Database\Factory;
use Framework\Database\Connection\MysqlConnection;
use Framework\Database\Connection\SqliteConnection;

class DatabaseProvider
{
    public function bind(App $app): void
    {
        $app->bind('database', function($app) {
            $factory = new Factory();
            $this->addMysqlConnector($factory);
            $this->addSqliteConnector($factory);

            $config = $this->config($app);

            return $factory->connect($config[$config['default']]);
        });
    }

    private function config(App $app): array
    {
        $base = $app->resolve('paths.base');
        $separator = DIRECTORY_SEPARATOR;

        return require "{$base}{$separator}config/database.php";
    }

    private function addMysqlConnector($factory): void
    {
        $factory->addConnector('sqlite', function($config) {
            return new SqliteConnection($config);
        });
    }

    private function addSqliteConnector($factory): void
    {
        $factory->addConnector('mysql', function($config) {
            return new MysqlConnection($config);
        });
    }
}
