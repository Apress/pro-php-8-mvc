<?php

namespace App\Http\Controllers\Users;

use Framework\Database\Factory;
use Framework\Database\Connection\Connection;
use Framework\Database\Connection\MysqlConnection;
use Framework\Routing\Router;

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

        $factory->addConnector('mysql', function($config) {
            return new MysqlConnection($config);
        });

        $factory->addConnector('sqlite', function($config) {
            return new SqliteConnection($config);
        });

        $config = require __DIR__ . '/../../../../config/database.php';

        $connection = $factory->connect($config[$config['default']]);

        return view('users/register', [
            'registerAction' => $this->router->route('register-user'),
            'logInAction' => $this->router->route('log-in-user'),
            'csrf' => csrf(),
        ]);
    }
}
