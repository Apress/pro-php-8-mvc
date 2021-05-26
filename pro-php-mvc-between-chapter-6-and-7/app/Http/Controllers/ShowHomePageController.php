<?php

namespace App\Http\Controllers;

use Framework\Database\Factory;
use Framework\Database\Connection\MysqlConnection;
use Framework\Database\Connection\SqliteConnection;
use Framework\Routing\Router;

class ShowHomePageController
{
    protected Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

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
        
        $products = $connection
            ->query()
            ->select()
            ->from('products')
            ->all();

        $productsWithRoutes = array_map(fn($product) => array_merge($product, [
            'route' => $this->router->route('view-product', ['product' => $product['id']]),
        ]), $products);

        return view('home', [
            'number' => 42,
            'products' => $productsWithRoutes,
        ]);
    }
}
