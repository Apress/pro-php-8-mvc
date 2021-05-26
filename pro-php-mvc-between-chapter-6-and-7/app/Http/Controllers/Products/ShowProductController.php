<?php

namespace App\Http\Controllers\Products;

use Framework\Database\Factory;
use Framework\Database\Connection\MysqlConnection;
use Framework\Database\Connection\SqliteConnection;
use Framework\Routing\Router;

class ShowProductController
{
    protected Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function handle()
    {
        $parameters = $this->router->current()->parameters();

        $factory = new Factory();

        $factory->addConnector('mysql', function($config) {
            return new MysqlConnection($config);
        });

        $factory->addConnector('sqlite', function($config) {
            return new SqliteConnection($config);
        });

        $config = require __DIR__ . '/../../../../config/database.php';

        $connection = $factory->connect($config[$config['default']]);

        $product = $connection
            ->query()
            ->select()
            ->from('products')
            ->where('id', $parameters['product'])
            ->first();

        return view('products/view', [
            'product' => $product,
            'orderAction' => $this->router->route('order-product', ['product' => $product['id']]),
            'csrf' => csrf(),
        ]);
    }
}
