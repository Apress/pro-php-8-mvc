<?php

namespace App\Http\Controllers\Users;

use Framework\Routing\Router;

// DEBUG
use Framework\Database\Factory;
use Framework\Database\Connection\Connection;
use Framework\Database\Connection\MysqlConnection;

class ShowRegisterFormController
{
    protected Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function handle()
    {
        $factory = new Factory();

        $factory->addConnector('mysql', function(array $config): Connection {
            return new MysqlConnection($config);
        });

        $connection = $factory->connect([
            'type' => 'mysql',
        ]);

        dd($connection);

        return view('users/register', [
            'router' => $this->router,
        ]);
    }
}
