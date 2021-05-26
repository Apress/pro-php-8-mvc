<?php

use App\Http\Controllers\ShowHomePageController;
use App\Http\Controllers\Products\OrderProductController;
use App\Http\Controllers\Products\ShowProductController;
use App\Http\Controllers\Users\LogInUserController;
use App\Http\Controllers\Users\RegisterUserController;
use App\Http\Controllers\Users\ShowRegisterFormController;
use Framework\Routing\Router;

return function(Router $router) {
    $router->errorHandler(
        404, fn() => 'whoops!'
    );

    $router->add(
        'GET', '/',
        [new ShowHomePageController($router), 'handle'],
    )->name('show-home-page');

    $router->add(
        'GET', '/products/view/{product}',
        [new ShowProductController($router), 'handle'],
    )->name('view-product');

    $router->add(
        'POST', '/products/order/{product}',
        [new OrderProductController($router), 'handle'],
    )->name('order-product');

    $router->add(
        'GET', '/register',
        [new ShowRegisterFormController($router), 'handle'],
    )->name('show-register-form');

    $router->add(
        'POST', '/register',
        [new RegisterUserController($router), 'handle'],
    )->name('register-user');

    $router->add(
        'POST', '/log-in',
        [new LogInUserController($router), 'handle'],
    )->name('log-in-user');
};
