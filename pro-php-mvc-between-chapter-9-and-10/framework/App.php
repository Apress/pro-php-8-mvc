<?php

namespace Framework;

use Dotenv\Dotenv;
use Framework\Routing\Router;
use Framework\Http\Response;

class App extends Container
{
    private static $instance;

    public static function getInstance()
    {
        if (!static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    private function __construct() {}
    private function __clone() {}

    public function run()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $basePath = $this->resolve('paths.base');

        $this->configure($basePath);
        $this->bindProviders($basePath);

        return $this->dispatch($basePath);
    }

    private function configure(string $basePath)
    {
        $dotenv = Dotenv::createImmutable($basePath);
        $dotenv->load();
    }

    private function bindProviders(string $basePath)
    {
        $providers = require "{$basePath}/config/providers.php";

        foreach ($providers as $provider) {
            $instance = new $provider;

            if (method_exists($instance, 'bind')) {
                $instance->bind($this);
            }
        }
    }

    private function dispatch(string $basePath): Response
    {
        $router = new Router();

        $this->bind(Router::class, fn() => $router);

        $routes = require "{$basePath}/app/routes.php";
        $routes($router);

        $response = $router->dispatch();

        if (!$response instanceof Response) {
            $response = $this->resolve('response')->content($response);
        }

        return $response;
    }
}
