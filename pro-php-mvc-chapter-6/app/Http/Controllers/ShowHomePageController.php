<?php

namespace App\Http\Controllers;

use Framework\Database\Factory;
use Framework\Database\Connection\MysqlConnection;
use Framework\Database\Connection\SqliteConnection;

class ShowHomePageController
{
    public function handle()
    {
        $factory = new Factory();

        $factory->addConnector('mysql', function($config) {
            return new MysqlConnection($config);
        });

        $factory->addConnector('sqlite', function($config) {
            return new SqliteConnection($config);
        });

        $config = require __DIR__ . '/../../../config/database.php';

        $connection = $factory->connect($config[$config['default']]);
        
        $product = $connection
            ->query()
            ->select()
            ->from('products')
            ->first();

        return view('home', [
            'number' => 42,
            'featured' => $product,
        ]);
    }
}
