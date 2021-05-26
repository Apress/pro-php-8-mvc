<?php

use App\Http\Controllers\ShowHomePageController;
use App\Http\Controllers\Products\ListProductsController;
use App\Http\Controllers\Products\ShowProductController;
use App\Http\Controllers\Services\ShowServiceController;
use App\Http\Controllers\Users\RegisterUserController;
use App\Http\Controllers\Users\ShowRegisterFormController;
use Framework\Routing\Router;

return function(Router $router) {
    $router->add(
        'GET', '/',
        [ShowHomePageController::class, 'handle'],
    )->name('show-home-page');

    $router->errorHandler(
        404, fn() => 'whoops!'
    );

    $router->add(
        'GET', '/products/view/{product}',
        [new ShowProductController($router), 'handle'],
    )->name('view-product');

    $router->add(
        'GET', '/products/{page?}',
        [new ListProductsController($router), 'handle'],
    )->name('list-products');

    $router->add(
        'GET', '/services/view/{service?}',
        [new ShowServiceController($router), 'handle'],
    )->name('show-service');

    $router->add(
        'GET', '/register',
        [new ShowRegisterFormController($router), 'handle'],
    )->name('show-register-form');

    $router->add(
        'POST', '/register',
        [new RegisterUserController($router), 'handle'],
    )->name('register-user');
};
