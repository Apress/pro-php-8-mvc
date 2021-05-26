<?php

require_once __DIR__ . '/../vendor/autoload.php';

// basePath(__DIR__ . '/../');

// session_start();

// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
// $dotenv->load();

// $router = new Framework\Routing\Router();

// $routes = require_once __DIR__ . '/../app/routes.php';
// $routes($router);

// print $router->dispatch();

$app = \Framework\App::getInstance();
$app->bind('paths.base', fn() => __DIR__ . '/../');
$app->run();
